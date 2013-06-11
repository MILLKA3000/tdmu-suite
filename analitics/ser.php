 <script type="text/javascript" src="../testcenter/datepicker/jquery.js"></script>
 
<?php  
include "class/function.php";
include "auth.php";
if ($_SESSION['name_sesion_a']=="admin"){
include "menu.php";
include "navigate.php";
require_once "class/class_firebird.php";
require_once "class/mysql_class_local.php";
require_once "class/mysql_class_moodle2.php";
$contingent = new class_ibase();
$base_local = new class_mysql_base_local();
$base_moodle = new class_mysql_base_moodle();
$department = $contingent->select("select DISTINCT GUIDE_DEPARTMENT.DEPARTMENTID,GUIDE_DEPARTMENT.DEPARTMENT from  B_TESTLIST, GUIDE_DEPARTMENT WHERE B_TESTLIST.DEPARTMENTID=GUIDE_DEPARTMENT.DEPARTMENTID ORDER by GUIDE_DEPARTMENT.DEPARTMENTID DESC;");
echo "<center><h2>Збір статистики з бази Контингент
<table width=100%><tr><td width=70% valign=top>";
navigate('Факультет',$department,'DEPARTMENT');
if ($_GET['DEPARTMENT'])
	{
$speciality = $contingent->select("select DISTINCT BVI_V.SPECIALITYID,GS.CODE|| '-' ||GS.SPECIALITY from  B_TESTLIST BT inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join B_VARIANT_ITEMS BVI_V   on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join GUIDE_SPECIALITY GS on (BVI_V.SPECIALITYID = GS.SPECIALITYID) where  BT.DEPARTMENTID = ".$_GET['DEPARTMENT']."");
		navigate('Спеціальність',$speciality,'SPECIALITY');	
	}
if ($_GET['SPECIALITY'])
	{
	$discipline = $contingent->select("select DISTINCT gd.disciplineid,gd.discipline from  B_TESTLIST BT inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join GUIDE_SPECIALITY GS on (BVI_V.SPECIALITYID = GS.SPECIALITYID) inner join guide_discipline gd on (BVI_V.disciplineid = gd.disciplineid) where  BT.DEPARTMENTID = ".$_GET['DEPARTMENT']." AND BVI_V.SPECIALITYID = ".$_GET['SPECIALITY']." order by gd.discipline");
		navigate('Дисципліна',$discipline,'DISCIPLINE');	
	}
	
if ($_GET['DISCIPLINE'])
	{	
$ekzam = array(array('Більше 0'));
$year =$contingent->select("select DISTINCT GE.EDUYEARSTR,GE.EDUYEAR from B_TESTLIST BT inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join GUIDE_EDUYEAR GE on (BT.EDUYEAR = GE.EDUYEAR) where BVI_V.DISCIPLINEID = ".$_GET['DISCIPLINE']." and BVI_V.SPECIALITYID = ".$_GET['SPECIALITY']." and BT.DEPARTMENTID = ".$_GET['DEPARTMENT']."");	
$sem =$contingent->select("select   DISTINCT BT.SEMESTER from B_TESTLIST BT inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) where BVI_V.DISCIPLINEID = ".$_GET['DISCIPLINE']." and BVI_V.SPECIALITYID = ".$_GET['SPECIALITY']." and BT.DEPARTMENTID = ".$_GET['DEPARTMENT']."");
  echo "</td><td bgcolor=gray valign=top><center> Фільтр";
		echo "<br><br><form action='ser.php?".$_SERVER['QUERY_STRING']."' method='post' enctype='multipart/form-data'><table bgcolor='white'><tr><td valign=top>";
		check('Рік',$year,'year');
		echo "</td><td valign=top>";
		check('Семестер',$sem,'sem');
		echo "</td><td valign=top>";
		check('Екзамен',$ekzam,'ekzam');
		echo "</td></tr><tr><td></td><td><input type='submit' name='put' value='Вибрати'></td></tr></table>";
 
 if($_POST['put']||$_POST['var'])
 {
	$year_v = array();
	$sem_v = array();
	$s=0;$y=0;
    for ($i=0;$i<count($year)+count($sem)+1;$i++)
    {
        if ($_POST["year".$i]) {$year_v[$y]=$year[$i][1];$y++;}
		if ($_POST["sem".$i]) {$sem_v[$s]=$sem[$i][0];$s++;}
    } 
$sem_sql=$contingent->for_sql($sem_v);	
$year_sql=$contingent->for_sql($year_v);	

if ($sem_sql!=''){
$sem_sql="AND BT.SEMESTER in (".$sem_sql.")";}
if ($year_sql!='')
{
$year_sql="and BT.EDUYEAR in (".$year_sql.")";
}
 }else{
$sem_sql='';
$year_sql='';
  }
 $zag_mas =$contingent->select("select DISTINCT BVI_V.VARIANTID,
(select count (iBVI_M.VARIANTID)
from B_VARIANT_ITEMS iBVI_M
inner join B_VARIANT_MODULE iBVM
  on (iBVM.VARIANTID = iBVI_M.VARIANTID)
inner join B_VARIANT_ITEMS iBVI_V
  on (iBVI_V.VARIANTID = iBVI_M.PARENTVARIANTID)
where iBVI_V.VARIANTID = BVI_V.VARIANTID
  group by iBVI_M.PARENTVARIANTID) total_modules,GE.EDUYEARSTR,BT.SEMESTER,bvm.modulenum,bvm.moduletheme from B_TESTLIST BT inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join GUIDE_EDUYEAR GE on (BT.EDUYEAR = GE.EDUYEAR) where BVI_V.DISCIPLINEID = ".$_GET['DISCIPLINE']." and BVI_V.SPECIALITYID = ".$_GET['SPECIALITY']." and BT.DEPARTMENTID = ".$_GET['DEPARTMENT']." ".$sem_sql." ".$year_sql." order by BVI_V.VARIANTID,GE.EDUYEARSTR,BT.SEMESTER,bvm.modulenum"); 
  echo "</td></tr><tr><td colspan=2><br>";
$discipl=$base_local->select("SELECT DISTINCT id_kaf_moodle FROM discipline WHERE id_kontingent='".(int)$_GET['DISCIPLINE']."';");
$kaf=$base_moodle->select("SELECT id,name FROM mdl_course_categories WHERE id = '".(int)$discipl[0][0]."';");
$parts = explode("(", strip_tags($kaf[0][1]));

	if ($parts[0]!='')
	{
		echo "<center style='background-color:white;'>Кафедра (<font color=green >".$parts[0]."</font>)</center>";
	}
		else
	{
		echo "<center style='background-color:white;'><font color=red>Ця дисципліна не зв'язана з кафедрою, зверніться до адміністратора!</font></center>";
	}
	
  echo "
  <table bgcolor='white' border=1 width=100% class='ser2'><tr style='text-align:center' bgcolor=gray><td width=3%>
  <input type='checkbox' id='toggle' value='S' onClick='do_this()' /></td><td>Номер варіанту</td><td>Сум</td><td>Рік</td><td>Семестер</td><td>Номер<br>модуля</td><td>Назва модуля</td>";

  for ($i=0;$i<count($zag_mas);$i++)
  {
	echo "<tr class='id2' name='id[".$zag_mas[$i][0]."][".$zag_mas[$i][2]."][".$zag_mas[$i][3]."]' year='".$zag_mas[$i][2]."' sem='".$zag_mas[$i][3]."' mod='".$zag_mas[$i][4]."'>
	
	<td bgcolor=gray><input type='checkbox' class='id'  name='id[".$zag_mas[$i][0]."][".$zag_mas[$i][2]."][".$zag_mas[$i][3]."]' year='".$zag_mas[$i][2]."' sem='".$zag_mas[$i][3]."' mod='".$zag_mas[$i][4]."'></td>";
		for($j=0;$j<count($zag_mas[0]);$j++)
		{
			echo "<td><center>".$zag_mas[$i][$j]."</td>";
		}
  echo "</tr>";
  }
echo "</table><br><center><input type='submit' name='var' value='Вибрати'><br><br></form>";
if(($_POST['var'])&&(!empty($_POST['id'])))
 {

 $id= array();
 $year= array();
 $sem= array(array());
 $i=0;
 if (!empty($_POST['id']))
 {
  $chb = $_POST['id'];
  foreach($chb as $index => $go)
   {
   $id[$i]=$index;
   $i++;
   };

 $id_sql=$contingent->for_sql($id);	
 if ($_POST['ekzam0']=='on'){$exampl=" AND S2T.credits_test>10 ";}else{$exampl="";}


  foreach($chb as $index => $gos)
   {$j=0;
   	foreach($gos as $go => $go2)
   	{$i=0;
   		$sem[$j][$i]=$go[0].$go[1].$go[2].$go[3]; 
   		foreach($go2 as $go3 => $go4)
   		{
  	 	$sem[$j][$i+1]=$go3;
  		 $i++;
  	 	};
  	 	$j++;
  	 	
	};
   };
 };

for ($i=0;$i<count($sem);$i++)
{	
	$sql_year_sem.="(BT.SEMESTER in (";
	for($j=1;$j<count($sem)+1;$j++)
	{
		if (($sem[$i][$j]!=null)) {$sql_year_sem.=$sem[$i][$j]." ";}
		if (($j!=count($sem))&&($sem[$i][$j+1]!=null)) {$sql_year_sem.=" , ";}
	}
	$sql_year_sem.=") AND BT.EDUYEAR=".$sem[$i][0].") ";
 	if (($sem[$i+1][0]!=null)) {$sql_year_sem.="OR ";}
}

echo " <script type='text/javascript'> var mas = ".js_array($id)."</script>";
//upd 2013-06: convert 120/80 ECTS level back to the 12-ball grade system
  $zagalne =$contingent->select("select
 avg(
case
 when S2T.CREDITS_CUR=66 then 4
 when S2T.CREDITS_CUR=69 then 4.5
 when S2T.CREDITS_CUR=72 then 5
 when S2T.CREDITS_CUR=75 then 5.5
 when S2T.CREDITS_CUR=78 then 6
 when S2T.CREDITS_CUR=81 then 6.5
 when S2T.CREDITS_CUR=84 then 7
 when S2T.CREDITS_CUR=87 then 7.5
 when S2T.CREDITS_CUR=90 then 8
 when S2T.CREDITS_CUR=93 then 8.5
 when S2T.CREDITS_CUR=96 then 9
 when S2T.CREDITS_CUR=99 then 9.5
 when S2T.CREDITS_CUR=102 then 10
 when S2T.CREDITS_CUR=105 then 10.5
 when S2T.CREDITS_CUR=108 then 11
 when S2T.CREDITS_CUR=111 then 11.5
 when S2T.CREDITS_CUR=112 then 12
 else 0
 END 
 ) avg_of_credits_cur,
  avg(
 case
 when S2T.credits_test=50 then 5.5
 when S2T.credits_test=52 then 6
 when S2T.credits_test=54 then 6.5
 when S2T.credits_test=56 then 7
 when S2T.credits_test=58 then 7.5
 when S2T.credits_test=60 then 8
 when S2T.credits_test=62 then 8.5
 when S2T.credits_test=64 then 9
 when S2T.credits_test=66 then 9.5
 when S2T.credits_test=68 then 10
 when S2T.credits_test=70 then 10.5
 when S2T.credits_test=72 then 11
 when S2T.credits_test=74 then 11.5
 when S2T.credits_test=80 then 12
 else 0
 END 
  ) avg_of_credits_test
from STUDENT2TESTLIST S2T
inner join B_TESTLIST BT
  on (BT.TESTLISTID = S2T.TESTLISTID)
inner join B_VARIANT_ITEMS BVI_M 
  on (BVI_M.VARIANTID = BT.VARIANTID)
inner join B_VARIANT_ITEMS BVI_V 
  on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID)
where  BVI_V.DISCIPLINEID = ".$_GET['DISCIPLINE']."
  and BVI_V.SPECIALITYID = ".$_GET['SPECIALITY']."
  and BT.DEPARTMENTID = ".$_GET['DEPARTMENT']." 
 ".$exampl." AND (".$sql_year_sem.");");
 

echo" <table bgcolor='white' border=1 width = 100% class='ser'><tr><td colspan=3>Результат по вибраних відомостях (".$id_sql.")</td></tr>
<tr><td><center><b>Поточна</td><td><center><b>Екзаменаційна</td><td><center><b>Загальна</td></tr>";
  for ($i=0;$i<count($zagalne);$i++)
  {
  echo "<tr>";
    $avg_curr = $zagalne[$i][0];
    $avg_test = $zagalne[$i][1];
    $avg_total = round($avg_curr*0.6 + $avg_test*0.4,1);
    echo "<td><center>".$zagalne[$i][0]."</td>";//Поточна
    echo "<td><center>".$zagalne[$i][1]."</td>";//Екзаменаційна
    echo "<td><center>".$avg_total."</td>";//Загальна
  echo "</tr>";
  }
echo "</table>";
 }
}}else {header("Location: index.php");}
?> 
<script type="text/javascript" src="script/ser.js"></script>