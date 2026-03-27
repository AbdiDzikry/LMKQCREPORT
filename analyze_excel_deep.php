<?php
require 'vendor/autoload.php';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('FORM LMK.xlsx');
$sheet = $spreadsheet->getActiveSheet();

$output = "FORM LMK.xlsx Structure Analysis\n";
$output .= "=================================\n\n";

$output .= "MERGED CELLS:\n";
foreach ($sheet->getMergeCells() as $range) {
    $output .= "- $range\n";
}

$output .= "\nCELL CONTENT AND STYLES (Rows 1-40):\n";
foreach ($sheet->getRowIterator(1, 40) as $row) {
    $rowIndex = $row->getRowIndex();
    foreach ($row->getCellIterator() as $cell) {
        $coord = $cell->getCoordinate();
        $value = $cell->getValue();
        if (!empty($value)) {
            $style = $sheet->getStyle($coord);
            $font = $style->getFont();
            $output .= "[$coord] Value: $value\n";
            $output .= "       Font: " . $font->getName() . " | Size: " . $font->getSize() . " | Bold: " . ($font->getBold() ? 'Yes' : 'No') . "\n";
            $output .= "       Alignment: " . $style->getAlignment()->getHorizontal() . " / " . $style->getAlignment()->getVertical() . "\n";
        }
    }
}

file_put_contents('excel_analysis.txt', $output);
echo "Analysis complete. Saved to excel_analysis.txt\n";
