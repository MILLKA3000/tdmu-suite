 <script type="text/javascript" src="script/jquery.js"></script> 
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript" src="script/graf.js"></script>

     
<?php
if ($_SESSION['name_sesion_a']=="admin"){
 include "class/function.php";
  include "class/mysql-class.php";
include_once("XLSToDBNew.class.php");

$base = new class_mysql_base();
$data = new XLSToDB("test.xls", 'CP1251');

//new
$a=$_POST['filename'];
echo $a;
//new

?>
<HTML>
<HEAD><TITLE>Валідність тестових завдань</TITLE>
<META http-equiv="Content-Type" Content="text/html; charset=windows-1251">
<link rel="stylesheet" href="css/style.css" type="text/css">
</HEAD>
<BODY bgcolor="#94AAB5">

<?php

include "menu.php";
$strResultHeader = "
<html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:word\" xmlns=\"http://www.w3.org/TR/REC-html40\">
<head>
	<meta http-equiv=Content-Type content=\"text/html; charset=windows-1251\">
	<meta name=ProgId content=Word.Sheet>
	<meta name=Generator content=\"Microsoft Word 11\">
</head>

<body>";

//new
echo "<center><form action='all72.php' method='post' enctype='multipart/form-data'>
  <table width=90% style='border: 1px solid blue;margin-top:20px;background-color:white;'><tr><td>
 
 </td><td><center><h2><p><b>Завантажити файл з 72 питаннями </b></p></h2></center>
<b>Записати до БД дані</b><br>
Відмітьте для запису<input type='checkbox' name='bd'><br><br>
<b>Виберіть файл для обробки</b> <br><input type='file' name='filename'  value='Огляд'>
 <input type='submit' value='Завантажити файл'><br></table></form>";

 //Перевірка на тип файлу
$allowed = array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         if ((!in_array($_FILES["filename"]["type"], $allowed))) {
		 if (!empty($_FILES["filename"]["type"])){
		 echo "<FONT COLOR=red><B>Файл не підтримується</B></FONT>";}
         } else { 
cleanDir('report');
cleanDir('report/var');
//Перенесення файлу в папку на сервері
//echo "file/".$_FILES["filename"]["name"];
if (isset($_FILES["filename"]["tmp_name"])) {
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
    {
    move_uploaded_file($_FILES["filename"]["tmp_name"], "file/".$_FILES["filename"]["name"]);
	}
}
}
if (!empty($_FILES["filename"]["name"])){
$fileXLS = $_FILES["filename"]["name"];

$variantArray=$data->getVariants($fileXLS);

$lehki = array();
$vashki = array();
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
if ($_POST['bd']=='on'){
	$last_id_type = $base->insert("INSERT INTO  `val`.`type_validn` (`date` ,`note`) VALUES ('".date("Y-m-d")."', '".$fileXLS."');");}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

foreach ($variantArray as $vk=>$vv)
{
	$strResult = $strResultHeader;
	$tempArr = array();

	$fp = fopen('report/var/' . $vk . '.doc', 'w');

	$myArray=$data->fileToMasAll72($vk, $fileXLS);

$ind1 = 0;

//echo $vk .  " - ";

for($i=1;$i<$data->predmet;$i++)
{

	foreach ($myArray as $k=>$v)
	{
		foreach ($v as $m=>$n)
		{
			if($m == $i)
			{
				$tempArr[$k] = $n['mark'];
			}
		}
	}

	arsort($tempArr);

	$userNum = count($tempArr);

	$strResult .= "<br><br><b>Варіант: " . $vk . "; Предмет: " . $i . "; Кількість студентів: " . $userNum . ".</b><br>";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	if ($_POST['bd']=='on'){
	$last_id = $base->insert("INSERT INTO  `val`.`variant` (`variant` ,`predmet` ,`sumstyd`,`type`) VALUES ('".$vk."', '".$i."', '".$userNum."','".$last_id_type."');");}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$group   = floor($userNum/5)+1;
//----------------------------------------------------discrete---------------------------	
	$group_discret  = floor($userNum/3)+1;
//----------------------------------------------------discrete---------------------------		
	$tempUserArr = array();

	//echo $i .  " - ";	
	for($j=1;$j<73;$j++)
	{
		$grp = 1;
		$ind = 0;
//----------------------------------------------------discrete---------------------------			
		$grp_discret = 1;
		$ind_discret = 0;
//----------------------------------------------------discrete---------------------------	
		$tempUserArr[1] = 0;
		$tempUserArr[2] = 0;
		$tempUserArr[3] = 0;
		$tempUserArr[4] = 0;
		$tempUserArr[5] = 0;

		foreach ($tempArr as $userid=>$mark)
		{
			if($myArray[$userid][$i]['question'][$j] > 0)
			{
				$tempUserArr[$grp]++;
			}

			$ind++;

			if($ind >= $group)
			{
				$grp++;
				$ind=0;
			}
		}
//----------------------------------------------------discrete---------------------------		
		$discret[1]=0;
		$discret[2]=0;
		$discret[3]=0;
		foreach ($tempArr as $userid=>$mark)
		{
			if($myArray[$userid][$i]['question'][$j] > 0)
			{
				$discret[$grp_discret]++;
			}

			$ind_discret++;

			if($ind_discret >= $group_discret)
			{
				$grp_discret++;
				$ind_discret=0;
			}
		}
		//echo $discret[1]."   ".$discret[2]." ".$discret[3]." | | ".$tempUserArr[1]." ".$tempUserArr[2]." ".$tempUserArr[3]." ".$tempUserArr[4]." ".$tempUserArr[5]."<br>";
		$discr_zavd=($discret[1]-$discret[3])/$group_discret;
		//echo round($discr_zavd,2)." <br> ";
//----------------------------------------------------discrete---------------------------

		$answerCorrect = $tempUserArr[1] + $tempUserArr[2] + $tempUserArr[3] + $tempUserArr[4] + $tempUserArr[5];

		if ($group != 0)
		{
			$tempUserArr[1] = $tempUserArr[1]/$group*100;
		}
		else
		{
			$tempUserArr[1]=0;
		}

		if ($group != 0){$tempUserArr[2] = $tempUserArr[2]/$group*100;}else{$tempUserArr[2]=0;}
		if ($group != 0){$tempUserArr[3] = $tempUserArr[3]/$group*100;}else{$tempUserArr[3]=0;}
		if ($group != 0){$tempUserArr[4] = $tempUserArr[4]/$group*100;}else{$tempUserArr[4]=0;}

		if (($userNum - $group*4) !=0 ){$tempUserArr[5] = $tempUserArr[5]/($userNum - $group*4)*100;}else{$tempUserArr[5]=0;}

		if(($tempUserArr[1] < 20) and ($tempUserArr[2] < 20)){
			$strVal = "Питання за важке!";
			$ind1++;
			$vashki[$i]++;
		}

		//if(($tempUserArr[1]+$tempUserArr[2]+$tempUserArr[3]+$tempUserArr[4]+$tempUserArr[5])>490){
			$strVal = "Питання за легке!";
			$ind1++;
			$lehki[$i]++;
		}

		$strResult .= "<li><b>Питання: " . $j . "</b>";

		$strResult .= "[" . round($tempUserArr[1], 1) . "%]";
		$strResult .= "[" . round($tempUserArr[2], 1) . "%]";
		$strResult .= "[" . round($tempUserArr[3], 1) . "%]";
		$strResult .= "[" . round($tempUserArr[4], 1) . "%]";
		$strResult .= "[" . round($tempUserArr[5], 1) . "%]. " . $strVal;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['bd']=='on'){
	$base->insert("INSERT INTO  `val`.`group` (
`numvariant` ,
`numquestion` ,
`gr1` ,
`gr2` ,
`gr3` ,
`gr4` ,
`gr5` ,
`validn`,
`check`,
`discrit`) VALUES (
 '".$last_id."',  '".$j."',  '".round($tempUserArr[1], 1)."',  '".round($tempUserArr[2], 1)."',  '".round($tempUserArr[3], 1)."',  '".round($tempUserArr[4], 1)."',  '".round($tempUserArr[5], 1)."', '".$strVal."','".$answerCorrect."','".round($discr_zavd,2)."'
)");}
$strVal = "";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		

//		echo " Загальна: " . $userNum . "/" . $answerCorrect . ".<br>";
		
	//}
//	echo $ind1/100*70 . "<br />";
}

$numVariants = sizeof($variantArray);
$numQueation = $numVariants*72;

fwrite($fp, $strResult);
fclose($fp);

}
//---------------NEW----------------------
$suma = array();
$procentLegkuh[$k] = array();
$procentVashkuh[$k] = array();
echo "<table border=1>";
for($k=1;$k<$data->predmet;$k++){
	$procentLegkuh[$k] = round(($lehki[$k]*100)/$numQueation, 2);
	$procentVashkuh[$k] = round(($vashki[$k]*100)/$numQueation, 2);
	
	if ($procentLegkuh[$k] + $procentVashkuh[$k]<99){
	$suma[$k] = $procentLegkuh[$k] + $procentVashkuh[$k];
	
	echo "<tr><td>Предмет: " . $k . " - Питань: " . $numQueation . " - Легкі: " . $procentLegkuh[$k] . "(" . $lehki[$k] . ")" . "% - Важкі: " . $procentVashkuh[$k] . "(" . $vashki[$k] . ")" . "% - Не валідні: " . $suma[$k] . "% <br />";
	}
}
echo "</table>";
echo "<script type='text/javascript'>var mas = ".js_array($suma).";</script>";
echo "<script type='text/javascript'>var masl = ".js_array($procentLegkuh).";masv = ".js_array($procentVashkuh).";</script>";
echo "<table><tr><td><div id='chart_div' style='width: 300px; height: 400px;'></div></td><td>";
echo "<div id='chart_divlv' style='width: 500px; height: 400px;'></div></td></tr></table>";
//---------------END NEW----------------------
$strResult2 = $strResultHeader;
$fp2 = fopen('report/72.doc', 'w');
for($k=1;$k<$data->predmet;$k++){

	$procentLegkuh = round(($lehki[$k]*100)/$numQueation, 2);
	$procentVashkuh = round(($vashki[$k]*100)/$numQueation, 2);

	$suma = $procentLegkuh + $procentVashkuh;
	$strResult2 .= "Предмет: " . $k . " - Питань: " . $numQueation . " - Легкі: " . $procentLegkuh . "(" . $lehki[$k] . ")" . "% - Важкі: " . $procentVashkuh . "(" . $vashki[$k] . ")" . "% - Не валідні: " . $suma . "% <br>";
	

}
fwrite($fp2, $strResult2);
fclose($fp2);}
//new

?>
</td><td width=200px valign='top'>
<?
include ("wood_script.php");
}?>
</BODY></HTML>
