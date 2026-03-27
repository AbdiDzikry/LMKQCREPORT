<?php
require 'vendor/autoload.php';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('FORM LMK.xlsx');
$sheet = $spreadsheet->getActiveSheet();

$output = "Column and Row Dimensions\n";
$output .= "==========================\n\n";

$output .= "COLUMN WIDTHS:\n";
foreach (range('A', 'X') as $col) {
    $output .= "$col: " . $sheet->getColumnDimension($col)->getWidth() . "\n";
}

$output .= "\nROW HEIGHTS (8-20):\n";
for ($row = 8; $row <= 20; $row++) {
    $output .= "Row $row: " . $sheet->getRowDimension($row)->getRowHeight() . "\n";
}

file_put_contents('excel_dimensions.txt', $output);
echo "Analysis complete.\n";
