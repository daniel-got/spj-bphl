<?php
$html = file_get_contents('resources/views/pages/spd/print.blade.php');
$lines = explode("\n", $html);
$in_row = false;
$row_num = 0;
foreach($lines as $i => $line) {
    if(strpos($line, '<tr') !== false) {
        $in_row = true;
        $row_num = $i + 1;
    }
    if(strpos($line, '</tr') !== false) {
        $in_row = false;
    }
    if($in_row && $row_num >= 4800 && $row_num <= 5300) {
        if(trim($line) !== '' && strpos(trim($line), '<td') === false && strpos(trim($line), '</td') === false && strpos(trim($line), '<tr') === false && strpos(trim($line), 'style=') === false) {
            echo "Row $row_num: " . trim($line) . "\n";
        }
    }
}
