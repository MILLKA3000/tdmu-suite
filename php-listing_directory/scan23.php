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
$doc_1_categories = array(classes_stud=>"�������� �� ��������� �� ����������",lectures_stud=>"�������� �� ��������� �� ������",metod_rozrobky=>"��������i ����i���",presentations=>"����������� ������",rob_prog=>"������ ��������");
$doc_2_lang = array(en=>"��������",ru=>"�������",uk=>"��������");
$doc_3_faculties = array(med=>"��������", pharm=>"pharm", stomat=>"stomat", nurse=>"nurse");
$doc_4_spec_by_fkt = array (
                        med => array(lik=>"˳�������� ������", biol=>"�������", medprof=>"������-������������� ������", health=>"������� ������"),
                        stomat => array(stom=>"�����������"),
                        pharm => array(prov_pharm=>"��������", klin_pharm=>"������� ��������", tpkz=>"����"),
                        nurse => array(_and=>"����������� ������ (�������� ���������)", bsn=>"����������� ������ (��������)", blb=>"����������� ���������� (��������)")
                        );
//$doc_4_spec_med = array(lik=>"˳�������� ������",biol=>"�������");
//$doc_4_spec_stom = array(lik=>"˳�������� ������",biol=>"�������");
//$doc_4_spec_pharm = array(lik=>"˳�������� ������",biol=>"�������");
//$doc_4_spec_nurse = array(lik=>"˳�������� ������",biol=>"�������");

///print_r($doc_4_spec_by_fkt);

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

echo "=============================================================";
$res_count = array();
$res_info = array();
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
                $path = realpath($path_str);
                if (is_dir($path)) {//process only existing base path
                //$info = new SplFileInfo($path);
                //$basedepth = $info->getDepth();
                //echo "<p>-base_depth: ".$basedepth."</p>";
                    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
        
                    foreach($objects as $path)
                    {
                        if ($path->isDir()) {
                            if ($filecount > 0){
                              //  echo "<p>-curr_depth: ".$currdepth."</p>"; 
                               // echo "<p>course: ".$curr_course."</p>";
                              //  echo "<p>subject: ".$curr_course."</p>";
                                echo "<p>Files count: ".$filecount."</p>";
                                $filecount = 0;//reset count - start a new folder
                                //echo "<p>debug: curr_dir ".$curr_dir."</p>";
                                //todo -1- display subject name and course num
                                //todo -2- save data there
                            
                                /// $res_count [$cat_id][$lang_id]= $filecount;//??
                            }
                            //echo "<p>".($path->__toString())."</p>";
                        } else if ($path->isFile()) {
                                $curr_file = $path->getPath();
                                //check path and skip .Files or _files content
                                if ((stripos($curr_file, $skip_dir1)===false)&&(stripos($curr_file, $skip_dir2)===false)){
                                echo "<p>debug: curr_dir1 ".$curr_file."</p>";
                                //echo "<p>debug: check ".stripos($curr_file, $skip_dir1)."</p>";
                                    //todo -2- check filetype
                                    //todo -3- store subject name and course num
                                    $filecount = $filecount +1;
                                
                                    /// $curr_term = 
                                    //$currdepth = $objects->getDepth();
                
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

?>

