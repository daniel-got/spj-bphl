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
    if($in_row && $row_num == 5199) {
        echo trim($line) . "\n";
    }
}
