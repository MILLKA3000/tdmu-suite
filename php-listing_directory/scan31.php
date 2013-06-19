<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<body>

<?php
//init defaults
//skiped directories that have in path
$skip_dir1 = ".files";
$skip_dir2 = "_files";
//arrays with study entires text names
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

//compare dir and subdir and return array of different foldernames
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
function getSubDirToarray($dir)
{
    //This is the ONLY WAY we have to make SURE that the last segment of $dir is a file and not a directory.
    if (is_file($dir))
    {
        $dir = dirname($dir);
    }
    // Is it necessary to convert to the fully expanded path?
    $dir = realpath($dir);
    // Do we need to worry about Windows?
    $dir = str_replace('\\', '/', $dir);
    // Here we filter leading, trailing and consecutive slashes.
    $array_dir = array_filter(explode('/', $dir));
    // All done!
    return $array_dir;
}
echo "=============================================================";
$res_count = array();
$res_count3 = array();
$res_info = array();
$tmp_dirname_arr = array();
$totals = 0;
//precess all categories
foreach ($doc_4_spec_by_fkt as $fkt_id=>$fkt_spec)
{
    echo "<p>".$fkt_id."-Faculty: ".$doc_3_faculties[$fkt_id]."</p>";
    //precess all specialities
    foreach ($fkt_spec as $spec_id=>$spec_name)
    {
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
                if ($fkt_id <> "stomat"){
                    $path_str = "informatika/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
                } else {
                    $path_str = "informatika/".$cat_id."/".$lang_id."/".$fkt_id;
                }
              //  if ($spec_id="_and") {
              //      $path_str = "informatika/".$cat_id."/".$lang_id."/".$fkt_id."/and";
              //  } else {
              //      $path_str = "informatika/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
              //  }
                $base_path = realpath($path_str);
                if (is_dir($base_path)) {//process only existing base path

                    $dir  = new RecursiveDirectoryIterator($base_path, RecursiveDirectoryIterator::SKIP_DOTS);
                    $objects = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::LEAVES_ONLY);
                    //get first file path
                    foreach($objects as $last_path){
                        $last_dir = $last_path->getPath();
                        break;
                    }
                    //process all files
                    foreach($objects as $path){                        
                        $curr_dir = $path->getPath();
                        //check is it current path is equal to previous - if not - print data and reset count
                        if ($curr_dir!==$last_dir) {

                        //prind data reset count
                               //todo -0- extract path folder names and convert it to subj term etc.!!!!
                               // echo "<p>term: ".$curr_term."</p>";
                               // echo "<p>subject, course: ".$curr_subject."</p>";
                               //check path and skip .Files or _files content
                            if ((stripos($curr_dir, $skip_dir1)===false)&&(stripos($curr_dir, $skip_dir2)===false)){
                                echo "<p>Path: ".$last_dir." Files count: ".$filecount."</p>";
                                if ($filecount>0){
                                    $res_count[$last_dir]= $filecount;
                                    $res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$last_dir]= $filecount;
                                }
                                $totals = $totals + $filecount;
                                $filecount = 0;//reset count - start a new folder
                                $last_dir = $curr_dir; //reset folder name
                            }    
                               // echo "<p>debug: curr_dir ".$curr_dir."</p>";
                                //todo -1- display subject name and course num
                                //todo -2- save data there
                            
                                /// $res_count [$cat_id][$lang_id]= $filecount;//??                       
                        }
                             //check path and skip .Files or _files content                                                    
                            if ((stripos($curr_dir, $skip_dir1)===false)&&(stripos($curr_dir, $skip_dir2)===false)){
                                //echo "<p>debug: curr_dir1 ".$curr_dir."</p>";
                                //echo "<p>debug: check ".stripos($curr_file, $skip_dir1)."</p>";
                                //check filetype
                                $file = $path->getFilename();    
                                if ((stripos($file,".htm"))||(stripos($file,".html"))||(stripos($file,".ppt"))||(stripos($file,".pptx"))||(stripos($file,".pdf"))){
                                    $filecount++;
                                    //todo -3- store subject name and course num
                                  //  $curr_subject = '';
                                  //  $tmp_dirname_arr = getSubDirFoolproof($curr_dir, $base_path);
                                    
                                  //  foreach($tmp_dirname_arr as $subdir_id=>$subdir_name){
                                  //      if ($subdir_name == "ptn") {
                                  //          $curr_term = "������ ����� ��������";
                                  //      } elseif ($subdir_name == "ntn") {
                                  //          $curr_term = "����������� ����� ��������";
                                  //      } else {
                                  //          $curr_subject = $curr_subject."  ".$subdir_name;
                                  //      }
                                  //  }
                                }   
                            }                          
                    
                
                    }
                    if ((stripos($curr_dir, $skip_dir1)===false)&&(stripos($curr_dir, $skip_dir2)===false)){
                                ////////echo "<p>Path: ".$last_dir." Files count: ".$filecount."</p>";
                                if ($filecount>0){
                                    $res_count[$last_dir]= $filecount;
                                    $res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$last_dir]= $filecount;
                                }
                                $totals = $totals + $filecount;
                                $filecount = 0;//reset count - start a new folder
                                $last_dir = $curr_dir; //reset folder name
                    }
                }
            }
        }
    }
}    
foreach ($res_count as $file_path=>$file_count){
    echo "<p>Path: ".$file_path." Files count: ".$file_count."</p>";
}
echo "<p> Total files count: ".$totals."</p>";
var_dump($res_count5);     
   
echo "<p>==================================================";
echo "<table><tr>";
echo "<td>Lang:</td>";
foreach ($doc_1_categories as $cat_id=>$cat_name){
echo "<td>".$cat_name."</td>";
}
echo "</tr><tr>";
$last_lang = '';
$last_cat = 'classes_stud';
$last_fkt = '';
$last_spec = '';
foreach ($res_count5 as $fkt_key=>$fkt_row){
echo '</tr><tr><td colspan="6">'.$doc_3_faculties[$fkt_key]."</td>";
foreach ($fkt_row as $spec_key=>$spec_row){
echo '</tr><tr><td colspan="6">'.$doc_4_spec_by_fkt[$fkt_key][$spec_key]."</td>";
$last_lang = '';
foreach ($spec_row as $lang_key=>$lang_row){
    if ($lang_key != $last_lang){
        echo "</tr><tr><td>".$doc_2_lang[$lang_key]."</td>";
        $last_lang = $lang_key;

    }
    foreach ($lang_row as $cat_key=>$file_data){
        $cat_flcount =0;
        foreach ($file_data as $flpath=>$flcount){
            $cat_flcount = $cat_flcount+$flcount;
        }
        echo "<td>".$cat_flcount."</td>";
    }
}
}
}
echo "/<table>";
        
?>
