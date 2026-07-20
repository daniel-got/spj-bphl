<?php
$file = 'resources/views/pages/spd/print.blade.php';
$content = file_get_contents($file);

// Replace CSS
$cssOld = <<<CSS
        .labelrow-table {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
            margin: 0;
            padding: 0;
            table-layout: fixed;
        }
        .labelrow-table td {
            border: none !important;
            padding: 0 !important;
            vertical-align: top;
            text-align: left;
            overflow: visible;
            word-wrap: break-word;
            white-space: normal;
        }
        .labelrow-table .label-col {
            width: 75pt;
        }
        .labelrow-table .value-col {
            width: 100%;
        }
CSS;

$cssNew = <<<CSS
        .labelrow {
            display: flex;
            width: 100%;
        }
        .labelrow .label-col {
            flex: 0 0 75pt;
            white-space: normal;
        }
        .labelrow .value-col {
            flex: 1 0 auto;
            white-space: normal;
        }
CSS;

$content = str_replace($cssOld, $cssNew, $content);

// Replace HTML
$pattern = '/<table class="labelrow-table"><tr><td class="label-col">(.*?)<\/td><td class="value-col">(.*?)<\/td><\/tr><\/table>/s';
$replacement = '<div class="labelrow"><span class="label-col">$1</span><span class="value-col">$2</span></div>';
$content = preg_replace($pattern, $replacement, $content);

file_put_contents($file, $content);
echo "Fixed!\n";
