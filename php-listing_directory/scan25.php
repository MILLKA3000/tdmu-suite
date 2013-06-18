<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<body>

<?php
//$doc_1_categories = array(1=>"classes_stud",2=>"lectures_stud",3=>"metod_rozrobky",4=>"presentations",5=>"rob_prog");
//$doc_2_lang = array(1=>"en",2=>"ru",3=>"uk");
//$doc_3_faculties = array(1=>"mad",2=>"pharm",3=>"stomat",4=>"nurse");
$skip_dir1 = ".files";
$skip_dir2 = "_files";
$doc_1_categories = array(classes_stud=>"Матеріали до підготовки до практичних",lectures_stud=>"Матеріали до підготовки до лекції",metod_rozrobky=>"Методичнi вказiвки",presentations=>"Презентацій лекцій",rob_prog=>"Робочі програми");
$doc_2_lang = array(en=>"Англійські",ru=>"Російські",uk=>"Українські");
$doc_3_faculties = array(med=>"Медичний", pharm=>"pharm", stomat=>"stomat", nurse=>"nurse");
$doc_4_spec_by_fkt = array (
                        med => array(lik=>"Лікувальна справа", biol=>"Біологія", medprof=>"Медико-профілактична справа", health=>"Здоров’я людини"),
                        stomat => array(stom=>"Стоматологія"),
                        pharm => array(prov_pharm=>"Фармація", klin_pharm=>"Клінічна фармація", tpkz=>"ТПКЗ"),
                        nurse => array(_and=>"Сестринська справа (молодший спеціаліст)", bsn=>"Сестринська справа (бакалавр)", blb=>"Лабораторна діагностика (бакалавр)")
                        );
//$doc_4_spec_med = array(lik=>"Лікувальна справа",biol=>"Біологія");
//$doc_4_spec_stom = array(lik=>"Лікувальна справа",biol=>"Біологія");
//$doc_4_spec_pharm = array(lik=>"Лікувальна справа",biol=>"Біологія");
//$doc_4_spec_nurse = array(lik=>"Лікувальна справа",biol=>"Біологія");

///print_r($doc_4_spec_by_fkt);
function getSubDirFoolproof($dir, $sub)
{
    /*
    This is the ONLY WAY we have to make SURE that the
    last segment of $dir is a file and not a directory.
    */
    if (is_file($dir))
    {
        $dir = dirname($dir);
    }

    // Is it necessary to convert to the fully expanded path?
    $dir = realpath($dir);
    $sub = realpath($sub);

    // Do we need to worry about Windows?
    $dir = str_replace('\\', '/', $dir);
    $sub = str_replace('\\', '/', $sub);

    // Here we filter leading, trailing and consecutive slashes.
    $dir = array_filter(explode('/', $dir));
    $sub = array_filter(explode('/', $sub));
    // All done!
    return array_diff($dir, $sub);
    //return array_slice(array_diff($dir, $sub), 0, 1);//return just 1 first subfolder in $dir that follow firstly after $sub
}
/*
echo "=============================================================";
$path = realpath("informatika/classes_stud/");

//$path = realpath("Z:\home\ia-wp.org\www\wp-content\/");
/////$path = realpath("uploads/informatika/classes_stud/en");

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
*/
echo "=============================================================";
$res_count = array();
$res_info = array();
$tmp_dirname_arr = array();
//precess all categories
foreach ($doc_4_spec_by_fkt as $fkt_id=>$fkt_spec)
{
    echo "<p>Faculty: ".$doc_3_faculties[$fkt_id]."</p>";
    //precess all specialities
    foreach ($fkt_spec as $spec_id=>$spec_name)
    {
        echo "<p>Speciality: ".$spec_name."</p>";
        //precess all categories
        foreach ($doc_1_categories as $cat_id=>$cat_name)
        {
            echo "<p>".$cat_name."</p>";
            //process all languages
            foreach ($doc_2_lang as $lang_id=>$lang_name)
            {
                echo "<p>".$lang_name."</p>";
                
                $filecount = 0;
                /////$path_str = "uploads/informatika/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
                //prepare base path
                $path_str = "informatika/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
                $base_path = realpath($path_str);
                if (is_dir($base_path)) {//process only existing base path
                    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base_path), RecursiveIteratorIterator::CHILD_FIRST);
        
                    foreach($objects as $path)
                    {
                        if ($path->isDir()) {
                            if ($filecount > 0){
                              //  echo "<p>-curr_depth: ".$currdepth."</p>"; 
                                echo "<p>term: ".$curr_term."</p>";
                                echo "<p>subject, course: ".$curr_course."</p>";
                                echo "<p>Files count: ".$filecount."</p>";
                                $filecount = 0;//reset count - start a new folder
                               // echo "<p>debug: curr_dir ".$curr_dir."</p>";
                                //todo -1- display subject name and course num
                                //todo -2- save data there
                            
                                /// $res_count [$cat_id][$lang_id]= $filecount;//??
                            }
                        } else if ($path->isFile()) {
                            //check path and skip .Files or _files content                        
                            $curr_dir = $path->getPath();
                            if ((stripos($curr_dir, $skip_dir1)===false)&&(stripos($curr_dir, $skip_dir2)===false)){
                                //echo "<p>debug: curr_dir1 ".$curr_dir."</p>";
                                //echo "<p>debug: check ".stripos($curr_file, $skip_dir1)."</p>";
                                //check filetype
                                $file = $path->getFilename();    
                                if ((stripos($file,".htm"))||(stripos($file,".html"))||(stripos($file,".ppt"))||(stripos($file,".pptx"))||(stripos($file,".pdf"))){
                                    $filecount++;
                                    //todo -3- store subject name and course num
                                    $curr_subject = '';
                                    $tmp_dirname_arr = getSubDirFoolproof($curr_dir, $base_path);
//var_dump($tmp_dirname_arr);
                                    foreach($tmp_dirname_arr as $subdir_id=>$subdir_name){
                                        if ($subdir_name == "ptp") {
                                            $curr_term = "Повний термін навчання";
                                        } elseif ($subdir_name == "ntn") {
                                            $curr_term = "Нормативний термін навчання";
                                        } else {
                                            $curr_subject = $curr_subject."  ".$subdir_name;
                                        }
                                    }


                                
                
                                    ///$curr_course = dirname($curr_file);
                                    //$curr_dir = $path->getPath();
                                    $curr_course = $path->getPath();
                                    $curr_subject = dirname($curr_course);
                                }   
                            }
                        }
                           
                    }
                
                }
            }
        }
    }
}

?>

