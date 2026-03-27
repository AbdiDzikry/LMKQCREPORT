<?php
require 'vendor/autoload.php';
$templatePath = 'FORM LMK.xlsx';
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load($templatePath);
$sheet = $spreadsheet->getActiveSheet();

echo "Checking for drawings in $templatePath...\n";
$drawings = $sheet->getDrawingCollection();
echo "Total drawings found: " . count($drawings) . "\n";

foreach ($drawings as $idx => $d) {
    echo "Drawing #$idx: " . $d->getName() . " at " . $d->getCoordinates() . "\n";
}

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('test_shapes.xlsx');
echo "Saved to test_shapes.xlsx. Please check if shapes are still there.\n";
