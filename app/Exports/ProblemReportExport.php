<?php

namespace App\Exports;

use App\Models\ProblemReport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProblemReportExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $reportId;

    public function __construct($reportId)
    {
        $this->reportId = $reportId;
    }

    public function view(): View
    {
        return view('reports.excel', [
            'report' => ProblemReport::findOrFail($this->reportId)
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Apply overall font to make it look like the template
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
        $sheet->getParent()->getDefaultStyle()->getFont()->setSize(8);

        // Force wrap text on data cells
        $sheet->getStyle('E32:H36')->getAlignment()->setWrapText(true); // Detail Problem
        $sheet->getStyle('I20:V23')->getAlignment()->setWrapText(true); // RCA Why 1-5

        // Adjust specific column widths to force the grid to look right
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);

        return [
            // Ensure headers and titles are vertically centered
            1 => ['alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]],
        ];
    }
}
