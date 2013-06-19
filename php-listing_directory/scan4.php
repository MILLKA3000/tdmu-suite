<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<body>

<?php
$path_str = "informatika/";
$dir  = new RecursiveDirectoryIterator($path_str, RecursiveDirectoryIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::LEAVES_ONLY);

echo "[$path_str]\n";
foreach ($files as $file) {
echo "<p>";
    $indent = str_repeat('   ', $files->getDepth());
    echo $indent." + $file";
}
?>