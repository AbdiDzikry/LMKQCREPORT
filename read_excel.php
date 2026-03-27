<?php
require 'vendor/autoload.php';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('FORM LMK.xlsx');
$sheet = $spreadsheet->getActiveSheet();

$cellsToCheck = ['A8', 'A9', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15', 'A16', 'A17', 'A18', 'E8', 'E9', 'E10', 'E11', 'E12'];

echo "Merge Ranges\n";
foreach ($sheet->getMergeCells() as $range) {
    if (strpos($range, '8') !== false || strpos($range, '9') !== false || strpos($range, '10') !== false || strpos($range, '11') !== false || strpos($range, '12') !== false || strpos($range, '13') !== false || strpos($range, '14') !== false || strpos($range, '15') !== false || strpos($range, '16') !== false || strpos($range, '17') !== false || strpos($range, '18') !== false || strpos($range, '19') !== false) {
        echo $range . "\n";
    }
}
