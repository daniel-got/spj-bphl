<?php
$file = "resources/views/pages/spd/print.blade.php";
$content = file_get_contents($file);

// 1. CSS
$content = str_replace(
    '.sheet-2 tr[style*="56.25pt"] {
            height: 25pt !important;
        }',
    '.sheet-2 tr[style*="56.25pt"] {
            height: 42pt !important;
        }',
    $content
);
$content = str_replace(
    'body.paper-a4 .sheet-2 tr[style*="56.25pt"] { height: 25pt !important; }',
    'body.paper-a4 .sheet-2 tr[style*="56.25pt"] { height: 42pt !important; }',
    $content
);
$content = str_replace(
    'body.paper-f4 .sheet-2 tr[style*="56.25pt"] { height: 25pt !important; }',
    'body.paper-f4 .sheet-2 tr[style*="56.25pt"] { height: 42pt !important; }',
    $content
);

// 2. Row II
$content = str_replace(
    '<div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:<span class="print-value">{{ $spd->pejabat_instansi_perusahaan }}</span></span></div>',
    '<div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:<span class="print-value">{{ $spd->destinasi[0]["pejabat_jabatan"] ?? "" }}</span></span></div>',
    $content
);
$content = str_replace(
    '<div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">: <span class="print-value">{{ $spd->pejabat_instansi_perusahaan }}</span></span></div>',
    '<div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">: <span class="print-value">{{ $spd->destinasi[0]["pejabat_jabatan"] ?? "" }}</span></span></div>',
    $content
);
$content = str_replace(
    '<span style="padding-left: 3.5em; text-decoration: underline; "><span class="print-value">{{ $spd->pejabat_instansi_perusahaan_nama }}</span></span>',
    '<span style="padding-left: 3.5em; text-decoration: underline; "><span class="print-value">{{ $spd->destinasi[0]["pejabat_nama"] ?? "" }}</span></span>',
    $content
);
$content = str_replace(
    '@if($spd->pejabat_instansi_perusahaan_nip)<span style="padding-left: 3.5em; "><span class="print-value">NIP. {{ $spd->pejabat_instansi_perusahaan_nip }}</span></span>@endif',
    '@if(($spd->destinasi[0]["pejabat_nip"] ?? "") !== "")<span style="padding-left: 3.5em; "><span class="print-value">NIP. {{ $spd->destinasi[0]["pejabat_nip"] }}</span></span>@endif',
    $content
);


// 3. Row III - VII
$rows = [
    'III' => 1,
    'IV' => 2,
    'V' => 3,
    'VI' => 4,
    'VII' => 5
];

foreach ($rows as $roman => $index) {
    $startStr = ">\n                        $roman.</td>";
    $startPos = strpos($content, $startStr);
    
    if ($startPos === false) continue;
    
    $nextRoman = $roman == 'VII' ? 'VIII' : array_keys($rows)[array_search($roman, array_keys($rows)) + 1];
    $endStr = ">\n                        $nextRoman.</td>";
    $endPos = strpos($content, $endStr, $startPos);
    
    if ($endPos === false) $endPos = strlen($content);
    
    $sectionLength = $endPos - $startPos;
    $section = substr($content, $startPos, $sectionLength);
    
    // Labels replacement
    $reps = [
        '<div class="labelrow"><span class="label-col">Tiba di</span><span class="value-col">:</span></div>' => 
        '<div class="labelrow"><span class="label-col">Tiba di</span><span class="value-col">:@if(!empty($spd->destinasi['.$index.']["tiba_di"]))<span class="print-value">{{ $spd->destinasi['.$index.']["tiba_di"] }}</span>@endif</span></div>',
        
        '<div class="labelrow"><span class="label-col">Berangkat dari</span><span class="value-col">:</span></div>' => 
        '<div class="labelrow"><span class="label-col">Berangkat dari</span><span class="value-col">:@if(!empty($spd->destinasi['.$index.']["berangkat_dari"]))<span class="print-value">{{ $spd->destinasi['.$index.']["berangkat_dari"] }}</span>@endif</span></div>',
        
        '<div class="labelrow"><span class="label-col">Pada Tgl.</span><span class="value-col">:</span></div>' => 
        '<div class="labelrow"><span class="label-col">Pada Tgl.</span><span class="value-col">:@if(!empty($spd->destinasi['.$index.']["tgl_tiba"]))<span class="print-value">{{ \Carbon\Carbon::parse($spd->destinasi['.$index.']["tgl_tiba"])->locale("id")->translatedFormat("d F Y") }}</span>@endif</span></div>',
        
        '<div class="labelrow"><span class="label-col">Ke</span><span class="value-col">:</span></div>' => 
        '<div class="labelrow"><span class="label-col">Ke</span><span class="value-col">:@if(!empty($spd->destinasi['.$index.']["tujuan_selanjutnya"]))<span class="print-value">{{ $spd->destinasi['.$index.']["tujuan_selanjutnya"] }}</span>@endif</span></div>',
        
        '<div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:</span></div>' => 
        '<div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:@if(!empty($spd->destinasi['.$index.']["pejabat_jabatan"]))<span class="print-value">{{ $spd->destinasi['.$index.']["pejabat_jabatan"] }}</span>@endif</span></div>',
        
        '<div class="labelrow"><span class="label-col">Pada Tanggal</span><span class="value-col">:</span></div>' => 
        '<div class="labelrow"><span class="label-col">Pada Tanggal</span><span class="value-col">:@if(!empty($spd->destinasi['.$index.']["tgl_berangkat"]))<span class="print-value">{{ \Carbon\Carbon::parse($spd->destinasi['.$index.']["tgl_berangkat"])->locale("id")->translatedFormat("d F Y") }}</span>@endif</span></div>',
    ];
    $newSection = str_replace(array_keys($reps), array_values($reps), $section);
    
    // Now Names and NIP using substr_replace to replace ONLY the exact offsets!
    preg_match_all('/<tr style="height:8.9pt;">(.*?)<\/tr>/s', $newSection, $matches, PREG_OFFSET_CAPTURE);
    
    if (count($matches[0]) >= 6) {
        // Last two are Name (tr9) and NIP (tr10)
        $tr9_match = $matches[0][count($matches[0]) - 2];
        $tr10_match = $matches[0][count($matches[0]) - 1];
        
        $tr9 = $tr9_match[0];
        $tr9_offset = $tr9_match[1];
        
        $tr10 = $tr10_match[0];
        $tr10_offset = $tr10_match[1];
        
        // Function to inject into the correct TDs of a single TR
        $injectTd = function($tr, $injectionStr) {
            $tdCount = 0;
            return preg_replace_callback('/<td(.*?)>(.*?)<\/td>/s', function($tdMatch) use (&$tdCount, $injectionStr) {
                $tdCount++;
                if ($tdCount == 2) {
                    return '<td' . $tdMatch[1] . '>' . $injectionStr . '</td>';
                }
                if (strpos($tdMatch[1], 'border-right') !== false) {
                    $tdCount = 99; // Next td will be 100
                    return $tdMatch[0];
                }
                if ($tdCount == 100) {
                    return '<td' . $tdMatch[1] . '>' . $injectionStr . '</td>';
                }
                return $tdMatch[0];
            }, $tr);
        };
        
        $newTr9 = $injectTd($tr9, '@if(!empty($spd->destinasi['.$index.']["pejabat_nama"]))<span style="padding-left: 3.5em; text-decoration: underline; "><span class="print-value">{{ $spd->destinasi['.$index.']["pejabat_nama"] }}</span></span>@endif');
        $newTr10 = $injectTd($tr10, '@if(!empty($spd->destinasi['.$index.']["pejabat_nip"]))<span style="padding-left: 3.5em; "><span class="print-value">NIP. {{ $spd->destinasi['.$index.']["pejabat_nip"] }}</span></span>@endif');
        
        // Replace from the back so offsets don't change
        $newSection = substr_replace($newSection, $newTr10, $tr10_offset, strlen($tr10));
        $newSection = substr_replace($newSection, $newTr9, $tr9_offset, strlen($tr9));
    }
    
    // Replace the section in the full content
    $content = substr_replace($content, $newSection, $startPos, $sectionLength);
}

file_put_contents($file, $content);
echo "Successfully updated print.blade.php\n";
?>
