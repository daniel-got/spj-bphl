<?php

$html = file_get_contents('resources/views/pages/spd/print.blade.php');
$lines = explode("\n", $html);
$row_num = 0;
foreach ($lines as $i => $line) {
    if (strpos($line, '<tr') !== false) {
        $row_num = $i + 1;
    }
    if (strpos($line, 'nip_ppk') !== false) {
        echo "Found nip_ppk at row starting line $row_num (Line $i)\n";
    }
}
