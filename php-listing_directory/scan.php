<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<body>

<?php
class scan {
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

   function scan_dir($dirname,$type)
   {
    $count=0;
	
     $dir = opendir($dirname);
     // Читаем в цикле директорию
     while (($file = readdir($dir)) !== false)
     {
 // Если это не родительская директория и не текущая директория, то
       if($file != "." && $file != "..")
       {
         if(is_dir($dirname."/".$file))//если это директоиия
         {
          $kil=$kil+$this->scan_dir($dirname."/".$file,$type);//продолжать скнарирование др. директорий
         }
         if(is_file($dirname."/".$file))//если это файл
         {
			if ((strpos($file,".htm"))||(strpos($file,".html"))||(strpos($file,".ppt"))||(strpos($file,".pptx"))||(strpos($file,".pdf"))){
			$count++;}
			if (strpos($file,".pdf")){
			
			$this->getNumPagesPdf($dirname."/".$file,$file);
			}
         }
       }
     }
			if (($count>1)||(($count!=0)&&(strpos($dirname,"rob_prog")))){
			$kil=$kil+$count;
			}		
     closedir($dir);
	
	return $kil;
   }
   
}
//------------------Створення обєкту 
$scan = new scan();
//----------------------------------
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

echo "<div><table  width=100% border=1><tbody><tr><th width='30%'><h1><center>Кафедри</th><th width=70% ><h1><center>Результат (файлів без структури)</th></tr><tr><td valign=top><b>";
foreach ($doc_0_kaf as $kaf_id=>$kaf_name){
echo"<li><a href='scan.php?kaf=".$kaf_id."'>".$kaf_name."</a><br>";
} 
echo "</td>"; 
echo "<td valign=top>"; 
if ($_GET['kaf']){
echo "<center><h3>".$doc_0_kaf[$_GET['kaf']]."</h3></center>";
echo "<table width=100% border=1><tbody><tr><td><b>Тип</td><td><b>Загальна</td><td><b>Англійські</td><td><b>Російські</td><td><b>Українські</td></tr>";  
$t=array(0=>"classes_stud",1=>"classes_stud/en",2=>"classes_stud/ru",3=>"classes_stud/uk",
4=>"lectures_stud",5=>"lectures_stud/en",6=>"lectures_stud/ru",7=>"lectures_stud/uk",
8=>"metod_rozrobky",9=>"metod_rozrobky/en",10=>"metod_rozrobky/ru",11=>"metod_rozrobky/uk",
12=>"presentations",13=>"presentations/en",14=>"presentations/ru",15=>"presentations/uk",
16=>"rob_prog",17=>"rob_prog/en",18=>"rob_prog/ru",19=>"rob_prog/uk"); 

$ENCODE_FOLDERNAME = ARRAY('classes_stud'=>'Матеріали до підготовки до практичних',
'classes_stud/en'=>'',
'classes_stud/ru'=>'',
'classes_stud/uk'=>'',
'lectures_stud'=>'Матеріали до підготовки до лекції',
'lectures_stud/en'=>'',
'lectures_stud/ru'=>'',
'lectures_stud/uk'=>'',
'metod_rozrobky'=>'Методичнi вказiвки',
'metod_rozrobky/en'=>'',
'metod_rozrobky/ru'=>'',
'metod_rozrobky/uk'=>'',
'presentations'=>'Презентацій лекцій',
'presentations/en'=>'',
'presentations/ru'=>'',
'presentations/uk'=>'',
'rob_prog'=>'Робочі програми',
'rob_prog/en'=>'',
'rob_prog/ru'=>'',
'rob_prog/uk'=>''
); 

   for ($i=0;$i<count($t);$i++){
   if (isset($ENCODE_FOLDERNAME[$t[$i]])){$name=$ENCODE_FOLDERNAME[$t[$i]];}else{$name=$t[$i];}
   if(is_dir($_GET['kaf'].'/'.$t[$i].'/')){
$count=$scan->scan_dir($_GET['kaf'].'/'.$t[$i].'/',"");



if (($i==0)){echo "<tr>";}
if (($i==4)||($i==8)||($i==12)||($i==16)){echo "</tr><tr>";}
if (($i==1)||($i==5)||($i==9)||($i==13)||($i==17)){$angl=$angl+$count;}
if (($i==2)||($i==6)||($i==10)||($i==14)||($i==18)){$rus=$rus+$count;}
if (($i==3)||($i==7)||($i==11)||($i==15)||($i==19)){$ua=$ua+$count;}
if (($i==0)||($i==4)||($i==8)||($i==12)||($i==16)){
if ($count==0) {echo"<td><b><font color=red><center>".$name."</td><td><b><font color=red><center> 0 </td>";}else{
echo "<td><b>".$name."</td><td><b><center>".$count." </td>"; $zagalne=$zagalne+$count;}}
else{if ($count==0) {echo"<td><b><font color=red><center>".$name." 0 </td>";}else{echo "<td><b><center>".$count." </td>";} }
 
if (($i==20)){echo "</tr>";}

}
	else
		{
			echo"<td><b><font color=red>".$name." 0 </td>";
		}
								}
echo "</tr><tr><td><b>Сумма</td><td><b><center>".$zagalne."</td><td><b><center>".$angl."</td><td><b><center>".$rus."</td><td><b><center>".$ua."</td></tr></tbody></table>";

}

//------Обрахунок ПДФ сторінок-----------
if ($_GET['kaf']){ 
if(is_dir($_GET['kaf']."/")){
echo "<br><br><center><b>Перелік <font color=green>PDF</font> Файлів та їхня кількість сторінок</b></center>";
$max_shet=0;
uksort($scan->file_pdf,"max");
echo"<table bgcolor='white' width='100%' border='1'><tbody><tr  bgcolor='gray'><td>№</td><td>Шлях</td><td>Кількість сторінок</td></tr>";
		for ($i=0;$i<count($scan->file_pdf);$i++)
			{
			$max_shet=$max_shet+$scan->file_pdf[$i]['max'];
			echo "<tr>";
	
				echo "<td bgcolor='gray'>".($i+1)."</td><td><a href='http://intranet.tdmu.edu.ua/data/kafedra/internal/".$scan->file_pdf[$i]['file']."'>".$scan->file_pdf[$i]['name_file']."</a></td><td>".$scan->file_pdf[$i]['max']."</td>";
				
			echo "</tr>";
			}
			echo "<tr><td colspan=2><b>Разом сторінок (орієнтовно)</b></td><td><b>".$max_shet."</b></td></tr>";
	echo "</tbody></table>";
}
}
echo "</td></tr></tbody></table></div>";
   
?>
