<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<body>

<?php
class scanutils {
var $file_pdf = array(array());
var $in=0;
	function getNumPagesPdf($filepath,$file){
	
    $fp = @fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
    $max=0;
    while(!feof($fp)) {
            $line = fgets($fp,255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)){
					//preg_match_all("/\/Page\W/", $matches[0], $matches2);
                    preg_match('/[0-9]+/',$matches[0], $matches2);
                    if ($max<$matches2[0]) $max=$matches2[0];
            }
    }
    fclose($fp);
    /*if($max==0){
        $im = new Imagick($filepath);
		$max=$im->getNumberImages(); 
    }*/
	
		
	$this->file_pdf[$this->in]['file']=$filepath;
	$this->file_pdf[$this->in]['max']=$max;
	$this->file_pdf[$this->in]['name_file']=$file;
	$this->in++;
	}
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
}
//------------------Створення обєкту 
$scanutils = new scanutils();
//----------------------------------
//init defaults:
$doc_0_kaf = array(anatomy=>"Кафедра анатомiї людини",
patologanatom=>"Кафедра патологiчної анатомiї з секцiйним курсом та судовою медициною",
histolog=>"Кафедра гiстологiї та ембрiологiї", 
med_biologia=>"Кафедра медичної бiологiї",
micbio=>"Кафедра мiкробiологiї, вiрусологiї та iмунологiї",
normal_phiz=>"Кафедра фiзiологiї",
socmedic=>"Кафедра соцiальної медицини, органiзацiї та економiки охорони здоров'я з медичною статистикою та iсторiєю медицини",
deontologi=>"Кафедра Медичної біоетики та деонтології",
chemistry=>"Кафедра медичної бiохiмiї",
pharmakologia=>"Кафедра фармакологiї з клiнiчною фармакологiєю",
hihiena=>"Кафедра загальної гiгiєни та екологiї",
patolog_phis=>"Кафедра патологiчної фiзiологiї",
med_catastrof=>"Кафедра медицини катастроф та військової медицини",
informatika=>"Кафедра медичної iнформатики",
biofiz=>"Кафедра медичної фізики та медичного обладнання",
philosophy=>"Кафедра філософії та суспільних дисциплін",
sus_dusct=>"Кафедра українознавства",
in_mow=>"Кафедра іноземних мов з медичною термінологією",
i_nurse=>"Міжнародна медсестринська школа",
distance=>"Сестринська справа (бакалавр) - дистанційна форма навчання",
magistr=>"Сестринська справа (магістр) - дистанційна форма навчання",
u_nurse=>"Кафедри, що викладають медсестринські дисципліни українською мовою",
clinlab=>"Кафедра клiнiко-лабораторної дiагностики",
propedeutic_vn_des=>"Кафедра пропедевтики внутрiшньої медицини та фтизiатрiї",
vn_med_alerg=>"Кафедра внутрiшньої медицини №1",
klinpat=>"Кафедра функціональної діагностики та клінічної патофізіології",
vn_med_al=>"Кафедра внутрiшньої медицини №3",
infect_desease=>"Кафедра iнфекцiйних хвороб з епiдемiологiєю, шкiрними та венеричними хворобами",
nervous_desease=>"Кафедра неврологiї, психiатрiї, наркологiї та медичної психологiї",
pedistrics=>"Кафедра педiатрiї та дитячої хiрургiї",
zagalna_surgery=>"Кафедра загальної та оперативної хiрургiї з топографiчною анатомiєю",
hospital_surgery=>"Кафедра хiрургiї №1",
obstetrics_ginecology_1=>"Кафедра акушерства та гiнекологiї №1",
sport_medic=>"Кафедра медичної реабiлiтацiї та спортивної медицини",
lor=>"Кафедра оториноларингологiї, офтальмологiї та нейрохiрургiї",
onkologia=>"Кафедра oнкологiї, променевої дiагностики i терапiї та радiацiйної медицини",
policlin=>"Кафедра первинної медико-санітарної допомоги та сімейної медицини",
nev_stan=>"Кафедра невідкладної та екстреної медичної допомоги",
upr_ekon=>"Кафедра управління та економіки фармації",
pharma_2=>"Кафедра фармацевтичної хiмiї",
pharma_1=>"Кафедра фармакогнозiї з медичною ботанiкою",
klinpharm=>"Кафедра клінічної фармації",
lik_tex=>"Кафедра технології ліків",
endoscop_fpo=>"Кафедра ендоскопії з малоінвазивною хірургією, урологією, ортопедією та травматологією ФПО",
obsretr_fpo=>"Кафедра aкушерства та гiнекологiї ФПО",
travmatologia_FPO=>"Кафедра хірургії ФПО",
pediatria_fpo=>"Кафедра педiатрiї ФПО",
therapy_fpo=>"Кафедра терапiї та сiмейної медицини ФПО",
stomat_hir=>"Кафедра хірургічної стоматології",
stomat_ter=>"Кафедра терапевтичної стоматології",
stomat_ter_dit=>"Кафедра дитячої стоматології",
stomat_ortop=>"Кафедра ортопедичної стоматології",
meds=>"Кафедра клiнiчної iмунологiї, алергологiї та загального догляду за хворими",
surgery2=>"Кафедра хiрургiї з анестезiологiєю №2",
vnutrmed2=>"Кафедра внутрiшньої медицини №2",
ginecology2=>"Кафедра акушерства та гiнекологiї №2",
pediatria2=>"Кафедра педiатрiї №2"); 
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

echo "<div><table  width=100% border=1><tbody><tr><th width='30%'><h1><center>Кафедри</th><th width=70% ><h1><center>Результат (коротко - по спеціальностях)</th></tr><tr><td valign=top><b>";
foreach ($doc_0_kaf as $kaf_id=>$kaf_name){
echo"<li><a href='scan3short.php?kaf=".$kaf_id."'>".$kaf_name."</a><br>";
} 
echo "</td><td valign=top>";
//retreive selected department (i.e. kafedra)                        
if ($_GET['kaf']){

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
                $kaf_id = $_GET['kaf'];
                $path_str = $kaf_id."/".$cat_id."/".$lang_id."/".$fkt_id."/".$spec_id;
                if ($fkt_id == "stomat"){   //grabli N1
                    $path_str = $kaf_id."/".$cat_id."/".$lang_id."/".$fkt_id;
                }
                if ($spec_id == "and1") {     //grabli N2
                    $path_str = $kaf_id."/".$cat_id."/".$lang_id."/".$fkt_id."/and";
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
echo "<center><h3>".$doc_0_kaf[$kaf_id]."</h3></center>";
//print table header
echo "<table width=100% border=1><tbody><tr>";
echo "<th>Мова:</th>";
foreach ($doc_1_categories as $cat_id=>$cat_name){
    $cat_totals [$cat_id] = 0;
    echo "<th>".$cat_name."</th>";
}
echo "<th>Разом:</th>";
echo "</tr><tr>";
//print table body
//precess all departments (faculties)
foreach ($doc_4_spec_by_fkt as $fkt_id=>$fkt_spec)
{
    echo '</tr><tr><td colspan="7"><b><center>Факультет: '.$doc_3_faculties[$fkt_id]."<b></center></td>";
    //precess all specialities
    foreach ($fkt_spec as $spec_id=>$spec_name)
    {
        echo '</tr><tr><td colspan="7"><center>Спеціальність: '.$spec_name."</center></td>";
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
echo "</tr><tr><td><b>Всього по кафедрі:<b></td>";
$dep_all = 0;
foreach ($cat_totals as $cat_id=>$cat_total){
    echo "<td><b>".$cat_total."<b></td>";
    $dep_all = $dep_all + $cat_total;
}
echo "<td><b>".$dep_all."<b></td></tr>";
echo "</tbody></table>";
}
echo "</td></tr></tbody></table></div>";
        
?>

