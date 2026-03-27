<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProblemReport;

class ProblemReportController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'section_head') {
            // Section head sees pending reports for verification, and also maybe history
            $reports = ProblemReport::with(['user', 'verifier'])->latest()->get();
        } else {
            // Leader sees their own created reports
            $reports = ProblemReport::where('user_id', $user->id)->with('verifier')->latest()->get();
        }

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'leader') {
            abort(403, 'Only leader can create problem reports.');
        }
        return view('reports.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'leader') {
            abort(403, 'Only leader can create problem reports.');
        }

        $validated = $request->validate([
            'report_date' => 'required|date',
            'section' => 'required|in:2W,4W',
            'comp_name_2w' => 'nullable|string|max:255',
            'part_number' => 'required|string|max:255',
            'part_name' => 'required|string|max:255',
            'customer' => 'required|in:AHM,ADM,HMMI,HPM,MKM',
            'line_problem' => 'required|string|max:255',
            'category' => 'required|in:Single Part,Sub Assy,Finishing',
            'quantity' => 'required|integer|min:1',
            'problem_status' => 'required|in:baru,berulang',
            'vendor' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'problem_type' => 'required|in:visual,dimensi,kelengkapan',
            'detail' => 'required|string',
            'pic_qc' => 'required|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        ProblemReport::create($validated);

        return redirect()->route('reports.index')->with('success', 'Problem report created successfully and is pending verification.');
    }

    public function show(ProblemReport $report)
    {
        return view('reports.show', compact('report'));
    }

    public function verify(Request $request, ProblemReport $report)
    {
        if (auth()->user()->role !== 'section_head') {
            abort(403, 'Only section head can verify reports.');
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $report->update([
            'status' => $request->status,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('reports.index')->with('success', 'Report has been ' . $request->status . '.');
    }

    public function exportExcel(ProblemReport $report)
    {
        if ($report->status !== 'accepted') {
            abort(403, 'Can only export accepted reports.');
        }

        $spreadsheet = $this->getLmkSpreadsheet($report);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'LMK_QC_Report_' . $report->part_number . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportPdf(ProblemReport $report)
    {
        if ($report->status !== 'accepted') {
            abort(403, 'Can only export accepted reports.');
        }

        try {
            $spreadsheet = $this->getLmkSpreadsheet($report);
            
            // PDF Page Setup
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            $sheet->getPageSetup()->setFitToPage(true);
            $sheet->getPageSetup()->setFitToWidth(1);
            $sheet->getPageSetup()->setFitToHeight(0);
            
            // Set margins (inches)
            $sheet->getPageMargins()->setTop(0.3);
            $sheet->getPageMargins()->setRight(0.3);
            $sheet->getPageMargins()->setLeft(0.3);
            $sheet->getPageMargins()->setBottom(0.3);

            // Use direct writer instantiation for modern PhpSpreadsheet
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf($spreadsheet);
            $filename = 'LMK_QC_Report_' . $report->part_number . '.pdf';

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, $filename, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('PDF Export failed: ' . $e->getMessage());
            
            // Fallback to HTML-based PDF if PhpSpreadsheet PDF fails
            return \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact('report'))
                ->download('LMK_QC_Report_' . $report->part_number . '.pdf');
        }
    }

    private function getLmkSpreadsheet(ProblemReport $report)
    {
        $templatePath = public_path('FORM LMK.xlsx');
        if (!file_exists($templatePath)) {
            $templatePath = base_path('FORM LMK.xlsx');
        }
        
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Adjust Column Widths
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(5);

        // --- CRITICAL: CLEAR OVERLAPPING MERGES ---
        $targetRanges = ['B8:H18', 'Q2:X6', 'I21:K27', 'I32:K38'];
        $existingMerges = $sheet->getMergeCells();
        foreach ($existingMerges as $mergeRange) {
            foreach ($targetRanges as $target) {
                if ($this->isRangeOverlapping($mergeRange, $target)) {
                    try { $sheet->unmergeCells($mergeRange); } catch (\Exception $e) {}
                    break;
                }
            }
        }

        // 1. BACKGROUND Area
        $leftFields = [
            8 => $report->id_report, // Reg No
            9 => $report->comp_name_2w ?: $report->part_name,
            10 => $report->part_number,
            11 => $report->type,
            12 => $report->part_name,
        ];

        foreach ($leftFields as $row => $val) {
            $sheet->mergeCells("B$row:D$row");
            $sheet->setCellValue("B$row", $val);
            
            $style = $sheet->getStyle("B$row:D$row");
            $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $style->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $style->getAlignment()->setWrapText(true);
            $style->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            // Ensure H is empty and borderless
            $sheet->getStyle("H$row")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
        }

        // Row 12 has bottom border
        $sheet->getStyle('B12:D12')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Right side labels and values (E, F:G)
        $currentE8 = $sheet->getCell('E8')->getValue();
        $sheet->setCellValue('E8', ($currentE8 ?: 'Informasi problem dari :') . ' ' . $report->section);
        $sheet->getStyle('E8:G8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('E8:G8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('E8:G8')->getAlignment()->setShrinkToFit(true);
        $sheet->getStyle('E8:G8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $rightLabels = [9 => 'Line Problem :', 10 => 'Tanggal :', 11 => 'Jam :', 12 => 'Customer :'];
        $rightValues = [
            9 => $report->line_problem,
            10 => \Carbon\Carbon::parse($report->report_date)->format('d F Y'),
            11 => '11:30',
            12 => $report->customer
        ];

        foreach ($rightLabels as $row => $label) {
            $sheet->setCellValue("E$row", $label);
            $sheet->getStyle("E$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            
            $sheet->mergeCells("F$row:G$row");
            $sheet->setCellValue("F$row", $rightValues[$row]);
            $valStyle = $sheet->getStyle("F$row:G$row");
            $valStyle->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $valStyle->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $valStyle->getAlignment()->setShrinkToFit(true);
            
            $boxStyle = $sheet->getStyle("E$row:G$row");
            $boxStyle->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $boxStyle->getBorders()->getVertical()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
            if ($row == 12) {
                $boxStyle->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
            $sheet->getStyle("H$row")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
        }

        // Rows 13-17: Merge width B:G (Excluding H) for left-aligned values
        $fullWidthRows = [13, 14, 15, 16, 17];
        foreach ($fullWidthRows as $row) {
            $sheet->mergeCells("B$row:G$row");
            if ($row == 13) $sheet->setCellValue("B$row", $report->part_number);
            if ($row == 14) $sheet->setCellValue("B$row", $report->quantity . ' Pcs');
            if ($row == 15) {
                $sheet->setCellValue("B$row", strtoupper($report->problem_status));
                if ($report->problem_status == 'berulang') {
                    $sheet->getStyle("B$row")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                    $sheet->getStyle("B$row")->getFont()->setBold(true);
                }
            }
            if ($row == 16) $sheet->setCellValue("B$row", 'Tidak');
            if ($row == 17) $sheet->setCellValue("B$row", $report->category ?: 'Single Part');

            $fullStyle = $sheet->getStyle("B$row:G$row");
            $fullStyle->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $fullStyle->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $fullStyle->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            // Ensure H is empty and borderless
            $sheet->getStyle("H$row")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
        }

        // Detail Problem (B18:H18)
        $sheet->mergeCells('B18:H18');
        $sheet->setCellValue('B18', $report->detail);
        $detailStyle = $sheet->getStyle('B18:H18');
        $detailStyle->getAlignment()->setWrapText(true);
        $detailStyle->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $detailStyle->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $detailStyle->getFont()->setBold(true)->setItalic(true);
        $detailStyle->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Signatures Area (Q2:X6)
        $approvalCols = [
            'Q:R' => 'PIC QC',
            'S:T' => 'Sect Head QC',
            'U:V' => 'PIC IQC',
            'W:X' => 'PIC Procurement'
        ];

        foreach ($approvalCols as $range => $label) {
            [$startCol, $endCol] = explode(':', $range);
            
            // Header Row 2
            $sheet->mergeCells("{$startCol}2:{$endCol}2");
            $sheet->setCellValue("{$startCol}2", $label);
            $sheet->getStyle("{$startCol}2:{$endCol}2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$startCol}2:{$endCol}2")->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("{$startCol}2:{$endCol}2")->getFont()->setBold(true);

            // Stamp Area Row 3-5
            $sheet->mergeCells("{$startCol}3:{$endCol}5");
            $sheet->getStyle("{$startCol}3:{$endCol}5")->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            // Name Area Row 6
            $sheet->mergeCells("{$startCol}6:{$endCol}6");
            $sheet->getStyle("{$startCol}6:{$endCol}6")->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        // Fill Data
        $sheet->setCellValue('Q6', $report->pic_qc);
        $sheet->getStyle('Q6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        if ($report->status === 'accepted') {
            // "VERIFIED" text in the stamp box (S3:T5)
            $sheet->setCellValue('S3', 'VERIFIED');
            $sheet->getStyle('S3:T5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('S3:T5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('S3:T5')->getFont()->setBold(true)->setSize(12)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN);

            // Verifier name in S6:T6
            $sheet->setCellValue('S6', $report->verifier->name ?? 'Wahid');
            $sheet->getStyle('S6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // --- SECTION 3: IDENTIFICATION PROBLEM (FLOWCHART) ---
        // Inject the reference image provided by the user
        $sheet->setCellValue('B30', '3. IDENTIFICATION PROBLEM');
        $sheet->getStyle('B30')->getFont()->setBold(true);
        $sheet->setCellValue('B32', ''); // Explicitly clear any template text
        
        $imagePath = public_path('flowchart lmk.png');
        if (!file_exists($imagePath)) {
            $imagePath = base_path('flowchart lmk.png');
        }

        if (file_exists($imagePath)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Flowchart LMK');
            $drawing->setDescription('LMK Flowchart Section');
            $drawing->setPath($imagePath);
            $drawing->setCoordinates('A33');
            $drawing->setOffsetX(0);
            $drawing->setOffsetY(0);
            $drawing->setHeight(140); // 3.72 cm (approx 140 px at 96dpi)
            $drawing->setWidth(722);  // 19.1 cm (approx 722 px at 96dpi)
            $drawing->setWorksheet($sheet);
            
            // Set Row Heights for Rows 33, 34, 35
            $sheet->getRowDimension(33)->setRowHeight(35);
            $sheet->getRowDimension(34)->setRowHeight(35);
            $sheet->getRowDimension(35)->setRowHeight(35);
        }

        // --- SECTION 4: FTA 4M + 1E (A40 area) ---
        // Shifting labels to A and using B-E for the analysis columns
        $sheet->setCellValue('A42', '4. FTA 4M + 1E');
        $sheet->getStyle('A42')->getFont()->setBold(true);
        
        $sheet->setCellValue('A43', '4M + 1E');
        $sheet->setCellValue('B43', 'Control Point');
        $sheet->setCellValue('C43', 'Std');
        $sheet->setCellValue('D43', 'Act');
        $sheet->setCellValue('E43', 'Judg');
        
        $sheet->getStyle('A43:E43')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A43:E43')->getFont()->setBold(true);

        $ftaRows = [44, 45, 46, 47, 48]; // MAN, MACHINE, METHODE, MATERIAL, ENVIRONMENT
        $ftaLabels = ['MAN', 'MACHINE', 'METHODE', 'MATERIAL', 'ENVIRONMENT'];
        foreach ($ftaRows as $idx => $row) {
            $sheet->setCellValue('A' . $row, $ftaLabels[$idx]);
            // Table borders from A to E
            $sheet->getStyle("A$row:E$row")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
        
        // Ensure old misplaced headers in B/F/G/H are cleared
        $sheet->setCellValue('F43', '');
        $sheet->setCellValue('G43', '');
        $sheet->setCellValue('H43', '');

        // --- SECTION 5: TEMPORARY ACTION (I8:X17 area) ---
        // Big box for containment and initial fixes
        $sheet->mergeCells('I8:X17');
        $sheet->getStyle('I8:X17')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I8:X17')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('I8:X17')->getAlignment()->setWrapText(true);

        // --- SECTION 6 & 7: 5-WHY ANALYSIS ---
        // Deep clear all cells in the RCA area (I to K) to remove template remnants
        for ($r = 21; $r <= 38; $r++) {
            $sheet->setCellValue('I' . $r, '');
            $sheet->setCellValue('J' . $r, '');
            $sheet->setCellValue('K' . $r, '');
        }

        // Outflow (Why Send)
        // Explicitly merge into one cell as requested
        $sheet->mergeCells('I21:K27');
        $sheet->getStyle('I21:K27')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Occurrence (Why Made) Header
        $sheet->mergeCells('I31:K31');
        $sheet->setCellValue('I31', 'PROBLEM');
        $sheet->getStyle('I31')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I31')->getFont()->setBold(true);

        // Occurrence Box
        // Explicitly merge into one cell as requested
        $sheet->mergeCells('I32:K38');
        $sheet->getStyle('I32:K38')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Column L/M Why rows should be EMPTY as requested
        for ($i = 21; $i <= 36; $i++) {
            $sheet->setCellValue('L' . $i, '');
            $sheet->setCellValue('M' . $i, '');
        }

        // --- SECTION 8 & 9: PERBAIKAN & EVALUASI ---
        $sheet->getStyle('I42:P54')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        // Grid Chart Area (Q43:X50)
        $sheet->getStyle('Q43:X50')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        for ($r = 44; $r <= 49; $r++) {
            $sheet->getStyle("Q$r:X$r")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        }

        return $spreadsheet;
    }

    /**
     * Check if two Excel ranges overlap.
     */
    private function isRangeOverlapping($rangeA, $rangeB)
    {
        // Extraction may return single cell if only one provided, but we assume ranges here
        try {
            $rangeAall = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::extractAllCellReferencesInRange($rangeA);
            $rangeBall = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::extractAllCellReferencesInRange($rangeB);
            return !empty(array_intersect($rangeAall, $rangeBall));
        } catch (\Exception $e) {
            return false;
        }
    }
}
