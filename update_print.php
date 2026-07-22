<?php
$file = "resources/views/pages/spd/print.blade.php";
$content = file_get_contents($file);

$rows = [
    'III' => 1,
    'IV' => 2,
    'V' => 3,
    'VI' => 4,
    'VII' => 5
];

foreach ($rows as $roman => $index) {
    // We need to find the section for this roman numeral.
    $startStr = ">\n                        $roman.</td>";
    $startPos = strpos($content, $startStr);
    
    if ($startPos === false) {
        echo "Could not find $roman\n";
        continue;
    }
    
    // Find the next roman numeral (or VIII) to bound our search
    $nextRoman = $roman == 'VII' ? 'VIII' : array_keys($rows)[array_search($roman, array_keys($rows)) + 1];
    $endStr = ">\n                        $nextRoman.</td>";
    $endPos = strpos($content, $endStr, $startPos);
    
    if ($endPos === false) {
        $endPos = strlen($content);
    }
    
    $section = substr($content, $startPos, $endPos - $startPos);
    
    // Replacements
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
    
    // Note: 'Kepala' appears twice in the section, the str_replace will replace both, which is exactly what we want (one for arrival, one for departure).
    // Let's do string replace on the section.
    $newSection = str_replace(array_keys($reps), array_values($reps), $section);
    
    // Now for the tricky part: Name and NIP.
    // They don't have explicit labels. We need to inject them.
    // However, they are in the last two <tr>s of the block.
    // Let's just output the section replacement for now, and see what happens.
    
    $content = str_replace($section, $newSection, $content);
}

file_put_contents($file, $content);
echo "Done labels.\n";
?>
