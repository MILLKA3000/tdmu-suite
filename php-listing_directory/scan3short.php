<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<body>

<?php
//init defaults:
//skiped directories that have in path
$skip_dir1 = ".files";
$skip_dir2 = "_files";
//arrays with study entires text names
$doc_1_categories = array(classes_stud=>"�������� �� ��������� �� ����������",lectures_stud=>"�������� �� ��������� �� ������",metod_rozrobky=>"��������i ����i���",presentations=>"����������� ������",rob_prog=>"������ ��������");
$doc_2_lang = array(en=>"��������",ru=>"�������",uk=>"��������");
$doc_3_faculties = array(med=>"��������", stomat=>"��������������", pharm=>"��������������", nurse=>"�Ͳ ��������������");
$doc_4_spec_by_fkt = array (
                        med => array(lik=>"˳�������� ������", biol=>"�������", medprof=>"������-������������� ������", health=>"������� ������"),
                        stomat => array(stom=>"�����������"),
                        pharm => array(prov_pharm=>"��������", klin_pharm=>"������ ��������", tpkz=>"����"),
                        nurse => array(and1=>"����������� ������ (�������� ���������)", bsn=>"����������� ������ (��������)", blb=>"����������� ���������� (��������)")
                        );


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

$res_count5 = array();
$tmp_dirname_arr = array();
//precess all categories
foreach ($doc_4_spec_by_fkt as $fkt_id=>$fkt_spec)
{
    //precess all specialities
    foreach ($fkt_spec as $spec_id=>$spec_name)
    {
        //precess all categories
        foreach ($doc_1_categories as $cat_id=>$cat_name)
        {
            //process all languages
            foreach ($doc_2_lang as $lang_id=>$lang_name)
            {
                
                $filecount = 0;
                /////$path_str = "uploads/informatika/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
                //prepare base path
                $path_str = "anatomy/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
                if ($fkt_id == "stomat"){   //grabli N1
                    $path_str = "anatomy/".$cat_id."/".$lang_id."/".$fkt_id;
                }
                if ($spec_id == "and1") {     //grabli N2
                    $path_str = "anatomy/".$cat_id."/".$lang_id."/".$fkt_id."/and";
                }
                $base_path = realpath($path_str);
                if (is_dir($base_path)) {//process only existing base path

                    $dir  = new RecursiveDirectoryIterator($base_path, RecursiveDirectoryIterator::SKIP_DOTS);
                    $objects = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);

                    //process all files
                    foreach($objects as $path){                        

                        if ($path->isFile()) {
                            $curr_dir = $path->getPath();
                             //check path and skip .Files or _files content                                                    
                            if ((stripos($curr_dir, $skip_dir1)===false)&&(stripos($curr_dir, $skip_dir2)===false)){
                                //check filetype
                                $file = $path->getFilename();    
                                if ((stripos($file,".htm"))||(stripos($file,".html"))||(stripos($file,".ppt"))||(stripos($file,".pptx"))||(stripos($file,".pdf"))){
                                    if (!isset($res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$curr_dir])){
                                        $res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$curr_dir]= 1;
                                    } else {
                                        $res_count5[$fkt_id][$spec_id][$lang_id][$cat_id][$curr_dir]++;
                                    }
                                }       
                            }                          
                        }
                    }
                }
            }
        }
    }
}    

$cat_totals = array();
//print table header
echo "<table width=100% border=1><tr>";
echo "<td>����:</td>";
foreach ($doc_1_categories as $cat_id=>$cat_name){
    $cat_totals [$cat_id] = 0;
    echo "<td>".$cat_name."</td>";
}
echo "<td>�����:</td>";
echo "</tr><tr>";
//print table body
//precess all departments (faculties)
foreach ($doc_4_spec_by_fkt as $fkt_id=>$fkt_spec)
{
    echo '</tr><tr><td colspan="7"><center>'.$doc_3_faculties[$fkt_id]."</center></td>";
    //precess all specialities
    foreach ($fkt_spec as $spec_id=>$spec_name)
    {
        echo '</tr><tr><td colspan="7"><center>'.$spec_name."</center></td>";
        //process all languages
        foreach ($doc_2_lang as $lang_id=>$lang_name)
        {
            echo "</tr><tr><td>".$doc_2_lang[$lang_id]."</td>";
            $row_flcount = 0;
            //process all categories
            foreach ($doc_1_categories as $cat_id=>$cat_name){
                $cat_flcount =0;
                if (isset($res_count5[$fkt_id][$spec_id][$lang_id][$cat_id])){
                
                    foreach ($res_count5[$fkt_id][$spec_id][$lang_id][$cat_id] as $flpath=>$flcount){
                        $cat_flcount = $cat_flcount+$flcount;
                    }                           
                }
                echo "<td>".$cat_flcount."</td>";
                $cat_totals [$cat_id] = $cat_totals [$cat_id]+ $cat_flcount;//total by each category
                $row_flcount = $row_flcount + $cat_flcount;//total by row (i.e. subject)
            }
            echo "<td><b>".$row_flcount."</b></td>";       
        }        
    }
}
//print table footer
echo "</tr><tr><td><b>������ �� ������:<b></td>";
$dep_all = 0;
foreach ($cat_totals as $cat_id=>$cat_total){
    echo "<td><b>".$cat_total."<b></td>";
    $dep_all = $dep_all + $cat_total;
}
echo "<td><b>".$dep_all."<b></td></tr>";
echo "</table>";
        
?>

