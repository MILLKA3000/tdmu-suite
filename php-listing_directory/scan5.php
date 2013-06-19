<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<body>
<?php
 $ite=new RecursiveDirectoryIterator("informatika/");

$bytestotal=0;
$nbfiles=0;
 foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) {
     $filesize=$cur->getSize();
     $bytestotal+=$filesize;
     $nbfiles++;
     echo $filename." => ".$filesize."<p>";
 }

$bytestotal=number_format($bytestotal);
 echo "Total: $nbfiles files, $bytestotal bytes\n";
?>