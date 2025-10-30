<?php
// Pretty-print WordPress Plugin Check JSON with ANSI colors.
// Usage: php plugin-check-pretty.php <output_file> [slug]

if ($argc < 2) {
    fwrite(STDERR, "Usage: php plugin-check-pretty.php <output_file> [slug]\n");
    exit(1);
}

$path = $argv[1];
$slug = $argv[2] ?? '';
$raw  = @file_get_contents($path) ?: '';

// Extract JSON array segment even if there is noise before/after.
$start = strpos($raw, '[');
$end   = strrpos($raw, ']');
if ($start === false || $end === false || $end < $start) {
    echo $raw, "\n"; // fallback: just echo
    exit(0);
}
$json = substr($raw, $start, $end - $start + 1);

$data = json_decode($json, true);
if (!is_array($data)) {
    echo $raw, "\n";
    exit(0);
}

// ANSI colors
function color($s, $c) { return "\033[{$c}m{$s}\033[0m"; }
$red    = fn($s) => color($s, '31');
$yellow = fn($s) => color($s, '33');
$green  = fn($s) => color($s, '32');
$cyan   = fn($s) => color($s, '36');

echo $cyan("WP Plugin Check"), $slug ? ' — ' . $slug : '', "\n";

if (empty($data)) {
    echo $green("✔ No issues found"), "\n";
    exit(0);
}

// Group by type+code+message
$groups = [];
$err = 0; $warn = 0;
foreach ($data as $row) {
    $type = strtoupper($row['type'] ?? '');
    $code = (string)($row['code'] ?? '');
    $msg  = (string)($row['message'] ?? '');
    $key  = $type . '|' . $code . '|' . $msg;
    $groups[$key] = ($groups[$key] ?? 0) + 1;
    if ($type === 'ERROR') { $err++; } elseif ($type === 'WARNING') { $warn++; }
}

$summary = [];
if ($err)   { $summary[] = $red("Errors: {$err}"); }
if ($warn)  { $summary[] = $yellow("Warnings: {$warn}"); }
if (!$err && !$warn) { $summary[] = $green('No issues'); }
echo implode('  ', $summary), "\n";

// Sort: ERROR first, then by count desc
uksort($groups, function($a, $b) use ($groups) {
    [$ta] = explode('|', $a, 2);
    [$tb] = explode('|', $b, 2);
    if ($ta !== $tb) {
        return $ta === 'ERROR' ? -1 : 1;
    }
    return $groups[$b] <=> $groups[$a];
});

foreach ($groups as $k => $count) {
    [$type, $code, $msg] = explode('|', $k, 3);
    $badge = $type === 'ERROR' ? $red('✖ ERROR') : $yellow('▲ WARNING');
    $suffix = $count > 1 ? " (x{$count})" : '';
    echo "  • {$badge}  {$code} — {$msg}{$suffix}\n";
}

exit(0);

