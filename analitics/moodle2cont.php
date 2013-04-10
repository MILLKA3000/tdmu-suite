<script type="text/javascript" src="../testcenter/datepicker/jquery.js"></script>
<style>
#active_d:hover {}
</style> 
<?php  
include "class/function.php";
include "auth.php";
if ($_SESSION['name_sesion_a']=="admin"){
include "menu.php";
include "navigate.php";
require_once "class/class_firebird.php";
require_once "class/mysql_class_local.php";
require_once "class/mysql_class_moodle2.php";
echo "<center><h2>Звязок дисциплін контингенту та мудлу по кафедрам</h2></center><b>";
$contingent = new class_ibase();
$base_local = new class_mysql_base_local();
$base_moodle = new class_mysql_base_moodle();
$zagalne=$base_moodle->select("SELECT id,name FROM mdl_course_categories WHERE id NOT IN (65,66,67,68,38,45,58);");


//------------Відрізати після "(" у назвах кафедр -----------------------------
for ($i=0;$i<count($zagalne);$i++)
    {
	$parts = explode("(", strip_tags($zagalne[$i][1]));
	$zagalne[$i][1] = $parts[0];
	}	
navigate('Виберіть кафедру',$zagalne,'kaf');


//------------Якщо вибрана кафедра получити звязки дисциплін ----------------------------
if ($_GET['kaf'])
{
echo "<br><img id='active_d' act='Y' src='http://market.auto.ria.ua/img/plus.gif'>Показати прикріплені дисципліни до кафедри та мудла";
	if($_GET['del'])
	{
		$dis=$base_local->ins("DELETE FROM `dis_for_kaf`.`discipline` WHERE id=".(int)$_GET['del'].";");
	}
	if ($_POST['ins_old'])
	{
		$dis_cont = $contingent->select("SELECT DISTINCT guide_discipline.DISCIPLINEID,guide_discipline.DISCIPLINE FROM guide_discipline  WHERE guide_discipline.DISCIPLINEID=".(int)$_POST['dis_cont']." order by guide_discipline.DISCIPLINE");
		
		$dis=$base_local->ins("INSERT INTO  `dis_for_kaf`.`discipline` (`id_moodle` , `name_moodle` , `id_kontingent` , `name_kontingent` , `id_kaf_moodle`)VALUES ('1000000',  '<font color=red><b>Предмет добавлений на пряму з контингенту</b></font>',  '".$_POST['dis_cont']."',  '<font color=red><b>".$dis_cont[0][1]."</b></font>',  '".$_GET['kaf']."');");
		
	}
	if($_POST['ins'])
	{
		$dis_moodle = $base_moodle->select("SELECT id,fullname FROM `mdl_course` WHERE `id`='".(int)$_POST['dis_moodle']."';");
		
		$dis_cont = $contingent->select("SELECT DISTINCT guide_discipline.DISCIPLINEID,guide_discipline.DISCIPLINE FROM guide_discipline  WHERE guide_discipline.DISCIPLINEID=".(int)$_POST['dis_cont']." order by guide_discipline.DISCIPLINE");
		
		$dis=$base_local->ins("INSERT INTO  `dis_for_kaf`.`discipline` (`id_moodle` , `name_moodle` , `id_kontingent` , `name_kontingent` , `id_kaf_moodle`)VALUES ('".$_POST['dis_moodle']."',  '".$dis_moodle[0][1]."',  '".$_POST['dis_cont']."',  '".$dis_cont[0][1]."',  '".$_GET['kaf']."');");
		
	}
$dis_cont = $contingent->select("SELECT DISTINCT guide_discipline.DISCIPLINEID,guide_discipline.DISCIPLINE FROM guide_discipline , B_VARIANT_ITEMS WHERE B_VARIANT_ITEMS.DISCIPLINEID=guide_discipline.DISCIPLINEID order by guide_discipline.DISCIPLINE");
$dis=$base_local->select("SELECT id,name_kontingent,name_moodle,id_kaf_moodle FROM discipline WHERE id_kaf_moodle='".(int)$_GET['kaf']."' order by id,id_kontingent DESC;");
$dis_k=$base_local->select("SELECT id,name_kontingent,id_kaf_moodle FROM discipline WHERE id_moodle='1000000' order by id_kaf_moodle DESC;");

$disid=$base_local->select("SELECT DISTINCT id_moodle FROM discipline WHERE id_kaf_moodle='".(int)$_GET['kaf']."';");
	$mas = array();
	for ($d=0;$d<count($disid);$d++){$mas[$d]=$disid[$d][0];}
	$sql_disc=$contingent->for_sql($mas);
	if ($sql_disc==''){$sql_dis='';}else{$sql_dis=" AND id NOT IN (".$sql_disc.")";}
$dis_moodle = $base_moodle->select("SELECT id,fullname FROM `mdl_course` WHERE `category`='".(int)$_GET['kaf']."' ".$sql_dis.";");
if (count($dis[0])!=''){
echo "<br><div id='disciplin' style='display:none;'><table border=1 width=99% bgcolor='white'><tr><td>Назва дисципліни у контингенті</td><td>Назва дисципліни у мудлі</td><td>ID Кафедри</td><td></td></tr>";

for ($i=0;$i<count($dis);$i++)
  {
  echo "<tr style='font-size:8pt;'>";
		for($j=1;$j<count($dis[0]);$j++)
		{
			echo "<td><center>".$dis[$i][$j]."</td>";
		}
	if (count($dis[0])!=0){	
  echo "<td><a href='moodle2cont.php?".$_SERVER['QUERY_STRING']."&del=".$dis[$i][0]."'><center>Делете</td></tr>";}
  }
  
  echo "</table></div>";}else {echo "<br> <div id='disciplin' style='display:none;background-color:white;'><center style='color:red;'>Незнайдено прикріплених дисциплін</center></div>";}
  
echo "<br><img id='active_k' act='Y' src='http://market.auto.ria.ua/img/plus.gif'>Показати прикріплені дисципліни до кафедри , без прив'язки до дисциплін мудла";  
if (count($dis_k[0])!=''){
echo "<br><div id='disciplin_k' style='display:none;'><table border=1 width=99% bgcolor='white'><tr><td>Назва дисципліни у контингенті</td><td>Кафедра</td><td></td></tr>";
for ($i=0;$i<count($dis_k);$i++)
  {
  echo "<tr style='font-size:8pt;'>";
		for($j=1;$j<count($dis_k[0])-1;$j++)
		{
			echo "<td>".$dis_k[$i][$j]."</td>";
		}
	if (count($dis_k[0])!=0){
  echo "<td>";
  for ($g=0;$g<count($zagalne);$g++)
    {
  if ($zagalne[$g][0]==$dis_k[$i][2]){echo $zagalne[$g][1];}
	}
  echo "</td><td><a href='moodle2cont.php?".$_SERVER['QUERY_STRING']."&del=".$dis_k[$i][0]."'><center>Делете</td></tr>";}
  }
 echo "</table></div>";}else {echo "<br> <div id='disciplin_k' style='display:none;background-color:white;'><center style='color:red;'>Незнайдено прикріплених дисциплін</center></div>";}
echo "<br><form action='moodle2cont.php?".$_SERVER['QUERY_STRING']."' method='post' enctype='multipart/form-data'>";
echo "<table width=99% bgcolor='white'><tr><td colspan=2>
<center><b>Створення звязку дисциплін з кафедрою</b></center>";
navigate('Дисципліна з контингенту ',$dis_cont,'dis_cont');

navigate('Дисципліна з мудла на кафедрі ',$dis_moodle,'dis_moodle');
echo "<br></tr><tr><td><div style='display:block;'><input type='submit' name='ins' value='Створити звязок'></td><td  width=45%>";
echo " <font color=red style='font-size:10pt;'><b>Звязок дисципліни з кафедрою без привязки до мудла </b></font><input type='submit' name='ins_old' value='Звязати'></div></td></tr>";
echo "</table></form>";  
  
}

}else{header("Location: index.php");}
?>
<script>
$('.kaf').change(function() {window.location.href='moodle2cont.php?kaf='+ encodeURIComponent($('select[name=\'kaf\']').val());});
$('#active_d').click(function() { 
if ($(this).attr('act')=='Y'){
$('#disciplin').slideDown(500);
$(this).attr('act','N');
$(this).attr('src','http://market.auto.ria.ua/img/minus.gif');
} else {
$('#disciplin').slideUp();
$(this).attr('act','Y');
$(this).attr('src','http://market.auto.ria.ua/img/plus.gif');
}

});

$('#active_k').click(function() { 
if ($(this).attr('act')=='Y'){
$('#disciplin_k').slideDown(500);
$(this).attr('act','N');
$(this).attr('src','http://market.auto.ria.ua/img/minus.gif');
} else {
$('#disciplin_k').slideUp();
$(this).attr('act','Y');
$(this).attr('src','http://market.auto.ria.ua/img/plus.gif');
}

});
</script>
