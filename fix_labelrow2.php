<?php

$file = 'resources/views/pages/spd/print.blade.php';
$content = file_get_contents($file);

// 1. Replace CSS
$cssOld = <<<'CSS'
        .labelrow-table {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
            margin: 0;
            padding: 0;
        }
        .labelrow-table td {
            border: none !important;
            padding: 0 !important;
            vertical-align: top;
            text-align: left;
        }
        .labelrow-table .label-col {
            width: 75pt;
        }
CSS;

$cssNew = <<<'CSS'
        .labelrow {
            display: block;
            white-space: nowrap;
        }
        .labelrow .label-col {
            display: inline-block;
            width: 75pt;
            vertical-align: top;
            white-space: normal;
        }
        .labelrow .value-col {
            display: inline-block;
            vertical-align: top;
            white-space: normal;
        }
CSS;

$content = str_replace($cssOld, $cssNew, $content);

// 2. Replace HTML
$pattern = '/<table class="labelrow-table"><tr><td class="label-col">(.*?)<\/td><td class="value-col">(.*?)<\/td><\/tr><\/table>/s';
$replacement = '<div class="labelrow"><span class="label-col">$1</span><span class="value-col">$2</span></div>';
$content = preg_replace($pattern, $replacement, $content);

file_put_contents($file, $content);
echo "Fixed!\n";
