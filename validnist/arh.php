<HTML>
<HEAD><TITLE>Архів тестових завдань</TITLE>
<META http-equiv="Content-Type" Content="text/html; charset=windows-1251">
<link rel="stylesheet" href="css/style.css" type="text/css">
</HEAD>
<BODY bgcolor="#94AAB5">
<?php
include("menu.php");
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
 
 </td><td><center><h2><p><b>Архів груп варіантів</b></p></h2></center>
 <table width=90%><tr><td>Вмісні варіанти</td><td>Дата додавання</td><td>Дія</td></tr>
 ";

 $type_var=$base->select_type_variant("SELECT * FROM type_validn WHERE 1;");

for ($i=0;$i<count($type_var);$i++)
{ 

	echo "<tr><td>";
	$var=$base->select_variant("SELECT distinct variant FROM variant WHERE type='".(int)$type_var[$i]['id']."';");
	for ($j=0;$j<count($var);$j++)
		{
			echo "<a style='color:green;' href='variant.php?variant=".$var[$j]['variant']."'>".$var[$j]['variant']."</a>,";
		}
	echo "</td><td>".$type_var[$i]['date']."</td><td>";
	if ($_SESSION['name_sesion_a']=="admin"){echo "<a style='color:RED;' href='arh.php?id=".$type_var[$i]['id']."'>Видалити</a></td></tr>";}
	else {echo "Немає прав для видалення</td></tr>";}

}
 
echo "</table></form>";
?>