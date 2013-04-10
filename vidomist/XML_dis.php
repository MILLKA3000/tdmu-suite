 <link href="styles/datepicker.css" rel="stylesheet">
<?php  
session_start();
include "auth.php";
if ($_SESSION['name_sesion_a']=="admin"){ 
include "menu.php";
include "navigate.php"; 
require_once "class/class_firebird.php";
$contingent = new class_ibase();
echo"<div class='well'><center><h2>Робота з XML</h2><font color=green><b>Файл для загрузки береться з контингенту список навчального плану </b></font><form action='XML_dis.php?".$_SERVER['QUERY_STRING']."' method='post' enctype='multipart/form-data'>
      Виберіть файл <input type='file' name='filename'  value='Огляд'> <input type='submit' value='Завантажити дані'></div></form>";
	  echo "<br></b><center>";
	  if (isset($_FILES["filename"]["tmp_name"])) {
    if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
     {
	 
$xml = simplexml_load_file($_FILES["filename"]["tmp_name"]);
$year = $xml->params->eduyear;
$sem = $xml->params->semester;
$dep = $xml->params->departmentid;
$student = $xml->params->studentid;
$x=array(array());
$i=0;
foreach($xml->disciplines as $key0 => $value){

foreach($value->discipline as $key1 => $value2){
$j=0;
foreach($value2->modules->module as $key2 => $value3){
$x[$i][$j+4]=json_decode( json_encode($value2->variantid) , 1);//----
$x[$i][$j+3]=json_decode( json_encode($value2->disciplineid) , 1);
$x[$i][$j]=json_decode( json_encode($value2->dmtitle) , 1);
$x[$i][$j+5]=json_decode( json_encode($value3->variantid) , 1);//----
$x[$i][$j+2]=json_decode( json_encode($value3->modulenum) , 1);
$x[$i][$j+1]=json_decode( json_encode($value3->moduletheme) , 1);
$i++;
}
}}
echo "<form action='xls_out.php?".$_SERVER['QUERY_STRING']."' method='post' enctype='multipart/form-data'><div class='well'>
<font color=green><b>Виберіть дисципліни які будуть експортовані у формат XLS </b></font><table border=1><tr bgcolor=gray><td></td><td>Назва дисципліни</td><td>Модуль</td><td>№ модуля</td><td></td><td></td><td></td><td></td>";
for ($i=0;$i<count($x);$i++)
  {
  $testlist = $contingent->select("select distinct S2T.TESTLISTID from STUDENT2TESTLIST S2T
		inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm 
		on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join guide_discipline gd
		on (BVI_V.disciplineid = gd.disciplineid) where BVI_M.PARENTVARIANTID=".$x[$i][4][0]." AND BVI_M.VARIANTID=".$x[$i][5][0]." AND BT.SEMESTER=".$sem." AND BT.EDUYEAR=".$year." AND BT.DEPARTMENTID=".$dep." AND S2T.STUDENTID=".$student." ");	
	$x[$i][6][0]=$testlist[0][0];	
	echo "<tr><td><input type='checkbox' name='id".$i."' class='id_vid' value='".$i."' CHECKED=CHECKED></td>";
		for($j=0;$j<count($x[0]);$j++)
		{
			echo "<td><center>".$x[$i][$j][0]."</td>";
		}
  echo "</tr>";
  }
echo "</table></div>";
$_SESSION['mas']=$x;
echo "<input type='submit' value='Скачати у форматі XLS'></form>";		
}}	

		
		
		
	    /*$testlist = $contingent->select("select distinct S2T.TESTLISTID from STUDENT2TESTLIST S2T
		inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm 
		on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join guide_discipline gd
		on (BVI_V.disciplineid = gd.disciplineid) where BVI_M.PARENTVARIANTID=12010000115282 AND BVI_M.VARIANTID=12010000115283 AND BT.SEMESTER=3 AND BT.EDUYEAR=2012 AND BT.DEPARTMENTID=43 AND BT.TESTLISTNUM='12.189' ");
		*/ 
}
?>