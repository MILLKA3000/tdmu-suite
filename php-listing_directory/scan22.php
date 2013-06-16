<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>

<?php
//$doc_1_categories = array(1=>"classes_stud",2=>"lectures_stud",3=>"metod_rozrobky",4=>"presentations",5=>"rob_prog");
//$doc_2_lang = array(1=>"en",2=>"ru",3=>"uk");
//$doc_3_faculties = array(1=>"mad",2=>"pharm",3=>"stomat",4=>"nurse");
$doc_1_categories = array(classes_stud=>"Матеріали до підготовки до практичних",lectures_stud=>"Матеріали до підготовки до лекції",metod_rozrobky=>"Методичнi вказiвки",presentations=>"Презентацій лекцій",rob_prog=>"Робочі програми");
$doc_2_lang = array(en=>"Англійські",ru=>"Російські",uk=>"Українські");
$doc_3_faculties = array(med=>"Медичний", pharm=>"pharm", stomat=>"stomat", nurse=>"nurse");
$doc_4_spec_med = array(lik=>"Лікувальна справа",biol=>"Біологія");
$doc_4_spec_stom = array(lik=>"Лікувальна справа",biol=>"Біологія");
$doc_4_spec_pharm = array(lik=>"Лікувальна справа",biol=>"Біологія");
$doc_4_spec_nurse = array(lik=>"Лікувальна справа",biol=>"Біологія");

print_r($doc_3_spec_by_faculties);
//$path = realpath("informatika/classes_stud/");

//$path = realpath("Z:\home\ia-wp.org\www\wp-content\/");
$path = realpath("uploads/informatika/classes_stud/en");

//$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
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

echo "=============================================================";
foreach ($doc_3_faculties as $fkt_id=>$fkt_name)
{
echo "<p>".$fkt_name."</p>";
foreach ($doc_1_categories as $cat_id=>$cat_name)
{
    echo "<p>".$cat_name."</p>";
    foreach ($doc_2_lang as $lang_id=>$lang_name)
    {
        echo "<p>".$lang_name."</p>";

        $path_str = "uploads/informatika/".$cat_id."/".$lang_id."/".$fkt_id;
        $path = realpath($path_str);
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
        
        foreach($objects as $path)
        {

    if ($path->isDir()) {
        if ($filecount > 0){
           echo "<p>Files count: ".$filecount."</p>";
           $filecount = 0;
        }
        //echo "<p>".($path->__toString())."</p>";
    } else {
        if ($path->isFile()) {
            $filecount = $filecount +1;
        }
    }   
        }
        
    }
}
}

?>

