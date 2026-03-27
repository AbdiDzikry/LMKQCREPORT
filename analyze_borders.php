<?php
require 'vendor/autoload.php';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('FORM LMK.xlsx');
$sheet = $spreadsheet->getActiveSheet();

$output = "Cell Border and Fill Analysis (Rows 8-15)\n";
$output .= "==========================================\n\n";

for ($r = 8; $r <= 15; $r++) {
    for ($c = 'A'; $c <= 'H'; $c++) {
        $coord = $c.$r;
        $style = $sheet->getStyle($coord);
        $borders = $style->getBorders();
        $hasBorders = ($borders->getTop()->getBorderStyle() !== 'none' ||
                       $borders->getBottom()->getBorderStyle() !== 'none' ||
                       $borders->getLeft()->getBorderStyle() !== 'none' ||
                       $borders->getRight()->getBorderStyle() !== 'none');
        $fill = $style->getFill()->getFillType();
        $color = $style->getFill()->getStartColor()->getARGB();
        
        if ($hasBorders || $fill !== 'none') {
            $output .= "[$coord] Border: " . ($hasBorders ? 'Yes' : 'No') . " | Fill: " . ($fill !== 'none' ? $color : 'None') . " | Value: " . $sheet->getCell($coord)->getValue() . "\n";
        }
    }
}

file_put_contents('excel_borders.txt', $output);
echo "Analysis complete.\n";
