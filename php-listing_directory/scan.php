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
echo "<div><table  width=100% border=1><tr><td width='40%'><h1><center>Кафедри</td><td width=60% ><h1><center>Результат</td></tr><tr><td valign=top>";
echo"<b>
<li><a href='scan.php?kaf=anatomy'> Кафедра анатомiї людини </a><br>
<li><a href='scan.php?kaf=patologanatom'> Кафедра патологiчної анатомiї з секцiйним курсом та судовою медициною </a><br>
<li><a href='scan.php?kaf=histolog'> Кафедра гiстологiї та ембрiологiї</a><br> 
<li><a href='scan.php?kaf=med_biologia'> Кафедра медичної бiологiї </a><br>
<li><a href='scan.php?kaf=micbio'> Кафедра мiкробiологiї, вiрусологiї та iмунологiї </a><br>
<li><a href='scan.php?kaf=normal_phiz'> Кафедра фiзiологiї </a><br>
<li><a href='scan.php?kaf=socmedic'> Кафедра соцiальної медицини, органiзацiї та економiки охорони здоров'я з медичною статистикою та iсторiєю медицини </a><br>
<li><a href='scan.php?kaf=deontologi'> Кафедра Медичної біоетики та деонтології </a><br>
<li><a href='scan.php?kaf=chemistry'> Кафедра медичної бiохiмiї </a><br>
<li><a href='scan.php?kaf=pharmakologia'> Кафедра фармакологiї з клiнiчною фармакологiєю </a><br>
<li><a href='scan.php?kaf=hihiena'> Кафедра загальної гiгiєни та екологiї </a><br>
<li><a href='scan.php?kaf=patolog_phis'> Кафедра патологiчної фiзiологiї </a><br>
<li><a href='scan.php?kaf=med_catastrof'> Кафедра медицини катастроф та військової медицини </a><br>
<li><a href='scan.php?kaf=informatika'> Кафедра медичної iнформатики </a><br>
<li><a href='scan.php?kaf=biofiz'> Кафедра медичної фізики та медичного обладнання </a><br>
<li><a href='scan.php?kaf=philosophy'> Кафедра філософії та суспільних дисциплін </a><br>
<li><a href='scan.php?kaf=sus_dusct'> Кафедра українознавства </a><br>
<li><a href='scan.php?kaf=in_mow'> Кафедра іноземних мов з медичною термінологією </a><br>
<li><a href='scan.php?kaf=i_nurse'> Міжнародна медсестринська школа </a><br>
<li><a href='scan.php?kaf=distance'> Сестринська справа (бакалавр) - дистанційна форма навчання </a><br>
<li><a href='scan.php?kaf=magistr'> Сестринська справа (магістр) - дистанційна форма навчання </a><br>
<li><a href='scan.php?kaf=u_nurse'> Кафедри, що викладають медсестринські дисципліни українською мовою </a><br>
<li><a href='scan.php?kaf=clinlab'> Кафедра клiнiко-лабораторної дiагностики </a><br>
<li><a href='scan.php?kaf=propedeutic_vn_des'> Кафедра пропедевтики внутрiшньої медицини та фтизiатрiї </a><br>
<li><a href='scan.php?kaf=vn_med_alerg'> Кафедра внутрiшньої медицини №1 </a><br>
<li><a href='scan.php?kaf=klinpat'> Кафедра функціональної діагностики та клінічної патофізіології </a><br>
<li><a href='scan.php?kaf=vn_med_al'> Кафедра внутрiшньої медицини №3 </a><br>
<li><a href='scan.php?kaf=infect_desease'> Кафедра iнфекцiйних хвороб з епiдемiологiєю, шкiрними та венеричними хворобами </a><br>
<li><a href='scan.php?kaf=nervous_desease'> Кафедра неврологiї, психiатрiї, наркологiї та медичної психологiї </a><br>
<li><a href='scan.php?kaf=pedistrics'> Кафедра педiатрiї та дитячої хiрургiї </a><br>
<li><a href='scan.php?kaf=zagalna_surgery'> Кафедра загальної та оперативної хiрургiї з топографiчною анатомiєю </a><br>
<li><a href='scan.php?kaf=hospital_surgery'> Кафедра хiрургiї №1 </a><br>
<li><a href='scan.php?kaf=obstetrics_ginecology_1'> Кафедра акушерства та гiнекологiї </a><br>
<li><a href='scan.php?kaf=sport_medic'> Кафедра медичної реабiлiтацiї та спортивної медицини </a><br>
<li><a href='scan.php?kaf=lor'> Кафедра оториноларингологiї, офтальмологiї та нейрохiрургiї </a><br>
<li><a href='scan.php?kaf=onkologia'> Кафедра oнкологiї, променевої дiагностики i терапiї та радiацiйної медицини </a><br>
<li><a href='scan.php?kaf=policlin'> Кафедра первинної медико-санітарної допомоги та сімейної медицини </a><br>
<li><a href='scan.php?kaf=nev_stan'> Кафедра невідкладної та екстреної медичної допомоги </a><br>
<li><a href='scan.php?kaf=upr_ekon'> Кафедра управління та економіки фармації </a><br>
<li><a href='scan.php?kaf=pharma_2'> Кафедра фармацевтичної хiмiї </a><br>
<li><a href='scan.php?kaf=pharma_1'> Кафедра фармакогнозiї з медичною ботанiкою </a><br>
<li><a href='scan.php?kaf=klinpharm'> Кафедра клінічної фармації </a><br>
<li><a href='scan.php?kaf=lik_tex'> Кафедра технології ліків </a><br>
<li><a href='scan.php?kaf=endoscop_fpo'> Кафедра ендоскопії з малоінвазивною хірургією, урологією, ортопедією та травматологією ФПО </a><br>
<li><a href='scan.php?kaf=obsretr_fpo'> Кафедра aкушерства та гiнекологiї </a><br>
<li><a href='scan.php?kaf=travmatologia_FPO'> Кафедра хірургії </a><br>
<li><a href='scan.php?kaf=pediatria_fpo'> Кафедра педiатрiї </a><br>
<li><a href='scan.php?kaf=therapy_fpo'> Кафедра терапiї та сiмейної медицини </a><br>
<li><a href='scan.php?kaf=stomat_hir'> Кафедра хірургічної стоматології </a>br>
<li><a href='scan.php?kaf=stomat_ter'> Кафедра терапевтичної стоматології </a><br>
<li><a href='scan.php?kaf=stomat_ter_dit'> Кафедра дитячої стоматології </a><br>
<li><a href='scan.php?kaf=stomat_ortop'> Кафедра ортопедичної стоматології </a><br>
<li><a href='scan.php?kaf=meds'> Кафедра клiнiчної iмунологiї, алергологiї та загального догляду за хворими </a><br>
<li><a href='scan.php?kaf=surgery2'> Кафедра хiрургiї з анестезiологiєю №2 </a><br>
<li><a href='scan.php?kaf=vnutrmed2'> Кафедра внутрiшньої медицини №2 </a><br>
<li><a href='scan.php?kaf=ginecology2'> Кафедра акушерства та гiнекологiї №2 </a><br>
<li><a href='scan.php?kaf=pediatria2'> Кафедра педiатрiї №2</a><br>"; 
 echo "</td><td valign=top><h3><table width=100% border=1><tr><td><b>Тип</td><td><b>Загальна</td><td><b>Англійські</td><td><b>Російські</td><td><b>Українські</td></tr>"; 
  if ($_GET['kaf']){ 
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
if ($count==0) {echo"<td><b><font color=red><center>".$name." 0 </td>";}else{
echo "<td><b>".$name."</td><td><b><center>".$count." </td>"; $zagalne=$zagalne+$count;}}
else{if ($count==0) {echo"<td><b><font color=red><center>".$name." 0 </td>";}else{echo "<td><b><center>".$count." </td>";} }
 
if (($i==20)){echo "</tr>";}

}
	else
		{
			echo"<td><b><font color=red>".$name." 0 </td>";
		}
								}
echo "</tr><tr><td><b>Сумма</td><td><b><center>".$zagalne."</td><td><b><center>".$angl."</td><td><b><center>".$rus."</td><td><b><center>".$ua."</td></tr></table>";

}

//------Обрахунок ПДФ сторінок-----------
if ($_GET['kaf']){ 
if(is_dir($_GET['kaf']."/")){
echo "<br><br><center><b>Перелік <font color=green>PDF</font> Файлів та їхня кількість сторінок</b></center>";
$max_shet=0;
uksort($scan->file_pdf,"max");
echo"<table bgcolor='white' width='100%' border='1'><tr  bgcolor='gray'><td>№</td><td>Шлях</td><td>Кількість сторінок</td></tr>";
		for ($i=0;$i<count($scan->file_pdf);$i++)
			{
			$max_shet=$max_shet+$scan->file_pdf[$i]['max'];
			echo "<tr>";
	
				echo "<td bgcolor='gray'>".($i+1)."</td><td><a href='http://intranet.tdmu.edu.ua/data/kafedra/internal/".$scan->file_pdf[$i]['file']."'>".$scan->file_pdf[$i]['name_file']."</a></td><td>".$scan->file_pdf[$i]['max']."</td>";
				
			echo "</tr>";
			}
			echo "<tr><td colspan=2></td><td>".$max_shet."</td></tr>";
	echo "</table>";
}
}
echo "</td></tr></table></div>";
   
?>
