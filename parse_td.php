<?php

$html = file_get_contents('resources/views/pages/spd/print.blade.php');
$lines = explode("\n", $html);
$in_row = false;
$row_num = 0;
$td_count = 0;
foreach ($lines as $i => $line) {
    if (strpos($line, '<tr') !== false) {
        $in_row = true;
        $row_num = $i + 1;
        $td_count = 0;
    }
    if (strpos($line, '<td') !== false) {
        $td_count++;
    }
    if (strpos($line, 'is_array($spd->kepala_seksi)') !== false) {
        echo "Found Kepala Seksi at row starting line $row_num, TD count so far: $td_count\n";
    }
    if (strpos($line, '{{$spd->pejabat_instansi_perusahaan}}') !== false) {
        echo "Found Pejabat at row starting line $row_num, TD count so far: $td_count\n";
    }
}
