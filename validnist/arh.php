<HTML>
<HEAD><TITLE>Архів тестових завдань</TITLE>
<META http-equiv="Content-Type" Content="text/html; charset=windows-1251">
<link rel="stylesheet" href="css/style.css" type="text/css">
</HEAD>
<BODY bgcolor="#94AAB5">
<?php
include("menu.php");
 include "class/function.php";
include "class/mysql-class.php";
$base = new class_mysql_base();
if ($_SESSION['name_sesion_a']=="admin")
if ($_GET['id'])
{

$var_del=$base->select_variant("SELECT id FROM variant WHERE type='".$_GET['id']."';");
	for($v=0;$v<count($var_del);$v++)
	{
		$base->delete("DELETE FROM `group` WHERE `numvariant`='".$var_del[$v]['id']."';");
	}

$base->delete("DELETE FROM `variant` WHERE `type`='".$_GET['id']."';");
$base->delete("DELETE FROM `type_validn` WHERE `id`='".$_GET['id']."';");
}
echo "<center><form action='arh.php' method='POST' enctype='multipart/form-data'>
 <table width=90% style='border: 1px solid blue;margin-top:20px;background-color:white;'><tr><td>
 
 </td><td><center><h2><p><b>Архів груп варіантів</b></p></h2></center><br>
 ";
$speciality = $base-> select("select id,name from speciality where 1;");
$year = $base-> select("select id,name from year where 1;");
echo "<b><table><tr><td width='100px'><b>Фільтри</td><td><b>Виберіть спеціальність</b>";
navigate("Спеціальність",$speciality,"spec");
echo "</td><td><b>Виберіть рік здачі</b>";
navigate("Рік",$year,"year");

 echo "</td><td><input type='submit' value='Задіяти'></td></tr></table>";
 $sqls='1';
if($_POST['spec']>0){$sqls="id_spec=".$_POST['spec'];}
if($_POST['year']>0){$sqls="id_year=".$_POST['year'];}
if(($_POST['spec']>0)&&($_POST['year']>0)){$sqls="id_spec=".$_POST['spec']." AND id_year=".$_POST['year'].";";}
$type_var=$base->select_type_variant("SELECT * FROM type_validn WHERE ".$sqls.";");
if ($type_var[0][id]!=null){
	echo"<table border=1 width=100%><tr><td>Вмісні варіанти</td><td>Дата додавання</td><td>Спеціальність</td><td>Рік</td><td>Дія</td></tr>";
for ($i=0;$i<count($type_var);$i++)
{ 

	echo "<tr><td><font size='1pt'>";
	$var=$base->select_variant("SELECT distinct variant FROM variant WHERE type='".(int)$type_var[$i]['id']."';");
	for ($j=0;$j<count($var);$j++)
		{
			echo "<a style='color:green;' href='variant.php?variant=".$var[$j]['variant']."'>".$var[$j]['variant']."</a>,";
		}
	$speciality = $base-> select("select name from speciality where id=".$type_var[$i]['id_spec'].";");
	$year = $base-> select("select name from year where id=".$type_var[$i]['id_year'].";");	
	echo "</td><td><font size='1pt'>".$type_var[$i]['date']."</td><td><font size='1pt'>".$speciality[0][0]."</td><td><font size='1pt'>".$year[0][0]."</td><td>";
	if ($_SESSION['name_sesion_a']=="admin"){echo "<font size='1pt'><a style='color:RED;' href='arh.php?id=".$type_var[$i]['id']."'><b>Видалити</a></td></tr>";}
	else {echo "<font size='1pt' color=red>Немає прав для видалення</td></tr>";}

}
}
 
echo "</table></form>";
?>