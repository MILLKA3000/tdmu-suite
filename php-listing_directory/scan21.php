<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>

<?php
//$path = realpath("/informatika/classes_stud/");

//$path = realpath("Z:\home\ia-wp.org\www\wp-content\/");
$path = realpath("uploads/");

$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
//$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
//foreach($objects as $name => $object)
//{
//    echo "<p>".$name."</p>";    
//}
$filecount = 0;
foreach($objects as $path)
{
    echo "<p>".$name."</p>";
    if ($path->isDir()) {
        if ($filecount > 0){
           echo "<p>Files count: ".$filecount."</p>";
           $filecount = 0;
        }
        echo "<p>".($path->__toString())."</p>";
    } else {
        if ($path->isFile()) {
            $filecount = $filecount +1;
        }
    }   
}
//for a last object (required for a SELF_FIRST option)
if ($filecount > 0){
           echo "<p>Files count: ".$filecount."</p>";
           $filecount = 0;
        }

?>

