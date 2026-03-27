<?php
require 'vendor/autoload.php';
$sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('FORM LMK.xlsx')->getActiveSheet();
for ($r = 8; $r <= 18; $r++) {
    for ($c = 'E'; $c <= 'K'; $c++) {
        $val = $sheet->getCell($c . $r)->getValue();
        if ($val)
            echo "$c$r: $val | ";
    }
    echo "\n";
}
