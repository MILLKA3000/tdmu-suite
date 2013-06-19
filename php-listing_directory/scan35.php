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
$doc_1_categories = array(classes_stud=>"Матеріали до підготовки до практичних",lectures_stud=>"Матеріали до підготовки до лекції",metod_rozrobky=>"Методичнi вказiвки",presentations=>"Презентацій лекцій",rob_prog=>"Робочі програми");
$doc_2_lang = array(en=>"Англійські",ru=>"Російські",uk=>"Українські");
$doc_3_faculties = array(med=>"Медичний", stomat=>"Стоматологічний", pharm=>"Фармацевтичний", nurse=>"ННІ медсестринства");
$doc_4_spec_by_fkt = array (
                        med => array(lik=>"Лікувальна справа", biol=>"Біологія", medprof=>"Медико-профілактична справа", health=>"Здоров’я людини"),
                        stomat => array(stom=>"Стоматологія"),
                        pharm => array(prov_pharm=>"Фармація", klin_pharm=>"Клінічна фармація", tpkz=>"ТПКЗ"),
                        nurse => array(and1=>"Сестринська справа (молодший спеціаліст)", bsn=>"Сестринська справа (бакалавр)", blb=>"Лабораторна діагностика (бакалавр)")
                        );
//$doc_4_spec_med = array(lik=>"Лікувальна справа",biol=>"Біологія");
//$doc_4_spec_stom = array(lik=>"Лікувальна справа",biol=>"Біологія");
//$doc_4_spec_pharm = array(lik=>"Лікувальна справа",biol=>"Біологія");
//$doc_4_spec_nurse = array(lik=>"Лікувальна справа",biol=>"Біологія");

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
  ///////  echo "<p>".$fkt_id."-Faculty: ".$doc_3_faculties[$fkt_id]."</p>";
    //precess all specialities
    foreach ($fkt_spec as $spec_id=>$spec_name)
    {
        //precess all categories
        foreach ($doc_1_categories as $cat_id=>$cat_name)
        {
      /////      echo "<p>".$cat_name."</p>";
            //process all languages
            foreach ($doc_2_lang as $lang_id=>$lang_name)
            {
      ///////          echo "<p>".$lang_name."</p>";
                
                $filecount = 0;
                /////$path_str = "uploads/informatika/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
                //prepare base path
                $path_str = "informatika/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
                if ($fkt_id == "stomat"){   //grabli N1
                    $path_str = "informatika/".$cat_id."/".$lang_id."/".$fkt_id;
                }
                if ($spec_id == "and1") {     //grabli N2
                    $path_str = "informatika/".$cat_id."/".$lang_id."/".$fkt_id."/and";
                }
                $base_path = realpath($path_str);
                if (is_dir($base_path)) {//process only existing base path

                    $dir  = new RecursiveDirectoryIterator($base_path, RecursiveDirectoryIterator::SKIP_DOTS);
                    $objects = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);
                    //get first file path
                    foreach($objects as $last_path){
                        $last_dir = $last_path->getPath();
                        break;
                    }
                    //process all files
                    foreach($objects as $path){                        
                     ///   $curr_dir = $path->getPath();
                        //check is it current path is equal to previous - if not - print data and reset count
                     /////////   if ($curr_dir!==$last_dir) {
                        if ($path->isFile()) {
                            $curr_dir = $path->getPath();
                             //check path and skip .Files or _files content                                                    
                            if ((stripos($curr_dir, $skip_dir1)===false)&&(stripos($curr_dir, $skip_dir2)===false)){
                                
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
                                  //          $curr_term = "Повний термін навчання";
                                  //      } elseif ($subdir_name == "ntn") {
                                  //          $curr_term = "Нормативний термін навчання";
                                  //      } else {
                                  //          $curr_subject = $curr_subject."  ".$subdir_name;
                                  //      }
                                  //  }
                                }  
                                echo "<p>debug: curr_dir1 ".$curr_dir." curr file count:".$filecount."</p>";        
                            }                          
                        }
                         /*   
                        else {
                        //prind data reset count
                               //todo -0- extract path folder names and convert it to subj term etc.!!!!
                               // echo "<p>term: ".$curr_term."</p>";
                               // echo "<p>subject, course: ".$curr_subject."</p>";
                               //check path and skip .Files or _files content
                            if ((stripos($curr_dir, $skip_dir1)===false)&&(stripos($curr_dir, $skip_dir2)===false)){
                                echo "<p>Path: ".$curr_dir." Files count: ".$filecount."</p>";
                                if ($filecount>0){
                                  //  $res_count[$last_dir]= $filecount;
                                    /////////$res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$curr_dir]= $filecount;
                                    if (!isset($res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$curr_dir])){
                                        $res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$curr_dir]= $filecount;
                                    }                                    
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
                        */
                    }
                    
                    ///if ((stripos($curr_dir, $skip_dir1)===false)&&(stripos($curr_dir, $skip_dir2)===false)){
                                echo "<p>Path: ".$curr_dir." Files count: ".$filecount."</p>";
                                if ($filecount>0){
                                   // $res_count[$last_dir]= $filecount;
                                    $res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$curr_dir]= $filecount;
                                }
                                $totals = $totals + $filecount;
                                $filecount = 0;//reset count - start a new folder
                                $last_dir = $curr_dir; //reset folder name
                    ///}
                    
                }
            }
        }
    }
}    
//foreach ($res_count as $file_path=>$file_count){
//    echo "<p>Path: ".$file_path." Files count: ".$file_count."</p>";
//}
echo "<p> Total files count: ".$totals."</p>";
//var_dump($res_count5);     
   
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
echo "</table>";

echo "<p>==================================================";
echo "<table width=100% border=1><tr>";
echo "<td>Мова:</td>";
foreach ($doc_1_categories as $cat_id=>$cat_name){
$cat_totals [$cat_id] = 0;
echo "<td>".$cat_name."</td>";
}
echo "<td>Разом:</td>";
echo "</tr><tr>";
$cat_totals = array();
$last_lang = '';
$last_cat = 'classes_stud';
$last_fkt = '';
$last_spec = '';
foreach ($doc_4_spec_by_fkt as $fkt_id=>$fkt_spec)
{
    echo '</tr><tr><td colspan="7"><center>'.$doc_3_faculties[$fkt_id]."</center></td>";
    //precess all specialities
    foreach ($fkt_spec as $spec_id=>$spec_name)
    {
        echo '</tr><tr><td colspan="7"><center>'.$spec_name."</center></td>";
        //process all languages
        //$last_lang = '';
        foreach ($doc_2_lang as $lang_id=>$lang_name)
        {
        //    if ($lang_id != $last_lang){
            echo "</tr><tr><td>".$doc_2_lang[$lang_id]."</td>";
        //    $lang_id = $lang_key;
            $row_flcount = 0;
            foreach ($doc_1_categories as $cat_id=>$cat_name){
                $cat_flcount =0;
                if (isset($res_count5[$fkt_id][$spec_id][$lang_id][$cat_id])){
                
                    foreach ($res_count5[$fkt_id][$spec_id][$lang_id][$cat_id] as $flpath=>$flcount){
                        $cat_flcount = $cat_flcount+$flcount;
                    }                           
                }
                echo "<td>".$cat_flcount."</td>";
                $cat_totals [$cat_id] = $cat_totals [$cat_id]+ $cat_flcount;//total by each category
                $row_flcount = $row_flcount + $cat_flcount;
            }
            echo "<td><b>".$row_flcount."</b></td>";
        //    }        
        }        
    }
}
echo "</tr><tr><td><b>Всього по кафедрі:<b></td>";
$dep_all = 0;
foreach ($cat_totals as $cat_id=>$cat_total){
echo "<td><b>".$cat_total."<b></td>";
$dep_all = $dep_all + $cat_total;
}
echo "<td><b>".$dep_all."<b></td></tr>";
echo "</table>";
        
?>

