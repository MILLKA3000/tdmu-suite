<?php
// **************************************************************************
// sample.php - sample script that demonstrates using as-diagrams.php,
// class for drawing gd-less bar diagrams.
//
// Written by Alexander Selifonov,  http://as-works.narod.ru
// Read "as-diagrams.htm" for how-to instructions
// **************************************************************************

include_once("XLSToDBNew.class.php");

$data = new XLSToDB("test.xls", 'CP1251');

?>
<HTML>
<HEAD><TITLE>Валідність тестових завдань</TITLE>
<META http-equiv="Content-Type" Content="text/html; charset=windows-1251">
<link rel="stylesheet" href="style.css" type="text/css">
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
echo "<form action='all24.php' method='post' enctype='multipart/form-data'>
 <table><tr><td>
 </td><td><center><h2><p><b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Завантажити 144 </b></p></h2>
 <input type='file' name='filename'  value='Огляд'>
      <input type='submit' value='Завантажити файл'><br>";
//new
//echo $_FILES["filename"]["type"];
$allowed = array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         if ((!in_array($_FILES["filename"]["type"], $allowed))) {
		 if (!empty($_FILES["filename"]["type"])){
		 echo "<FONT COLOR=red><B>Файл не підтримується</B></FONT>";}
         } else { 

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


foreach ($variantArray as $vk=>$vv)
{
	$strResult = $strResultHeader;
	$tempArr = array();

	$fp = fopen('E:\Apache2.2\htdocs\work\report\var' . $vk . '.doc', 'w');

	$myArray=$data->fileToMasAll144($vk, $fileXLS);

$ind1 = 0;

//echo $vk .  " - ";

for($i=1;$i<15;$i++)
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

	$group   = floor($userNum/5)+1;
	
	$tempUserArr = array();

	//echo $i .  " - ";	
	for($j=1;$j<145;$j++)
	{
		$grp = 1;
		$ind = 0;

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

		if(($tempUserArr[1]+$tempUserArr[2]+$tempUserArr[3]+$tempUserArr[4]+$tempUserArr[5])>490){
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

		$strVal = "";

//		echo " Загальна: " . $userNum . "/" . $answerCorrect . ".<br>";
		
	}
//	echo $ind1/100*70 . "<br />";
}

$numVariants = sizeof($variantArray);
$numQueation = $numVariants*144;

fwrite($fp, $strResult);
fclose($fp);

}

for($k=1;$k<15;$k++){
	$procentLegkuh = round(($lehki[$k]*100)/$numQueation, 2);
	$procentVashkuh = round(($vashki[$k]*100)/$numQueation, 2);

	$suma = $procentLegkuh + $procentVashkuh;
	echo "Предмет: " . $k . " - Питань: " . $numQueation . " - Легкі: " . $procentLegkuh . "(" . $lehki[$k] . ")" . "% - Важкі: " . $procentVashkuh . "(" . $vashki[$k] . ")" . "% - Не валідні: " . $suma . "% <br />";
}
}
?>

</BODY></HTML>
