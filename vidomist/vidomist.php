<script type="text/javascript" src="http://www.eyecon.ro/datepicker/js/jquery.js"></script>
 <link href="styles/datepicker.css" rel="stylesheet">
<script src="script/bootstrap-datepicker.js"></script>
<?php  
include "class/function.php";
include "auth.php";
if ($_SESSION['name_sesion_a']=="admin"){
include "menu.php";
include "navigate.php";
require_once "class/class_firebird.php";
$contingent = new class_ibase();
echo "<div class='well'><center><h2>Відомості</h2>";
echo "<form action='vidomist.php?".$_SERVER['QUERY_STRING']."' method='post' enctype='multipart/form-data'>
";
echo "Введіть Ім'я студента для пошуку в базі <input type='text' name='name_styd' value='".$_POST['name_styd']."'>";	
echo "<input type='submit' name='put' value='Пошук'></div>";
	if ($_POST['name_styd']!='')
	{
		$student = $contingent->select("SELECT STUDENTS.STUDENTID, STUDENTS.FIO,GUIDE_SPECIALITY.SPECIALITY,GUIDE_DEPARTMENT.DEPARTMENT,STUDENTS.SEMESTER, STUDENTS.GROUPNUM, STUDENTS.PHOTO FROM STUDENTS,GUIDE_SPECIALITY,GUIDE_DEPARTMENT WHERE STUDENTS.FIO LIKE '%".$_POST['name_styd']."%' AND STUDENTS.STATUS='С' AND GUIDE_SPECIALITY.SPECIALITYID=STUDENTS.SPECIALITYID AND GUIDE_DEPARTMENT.DEPARTMENTID=STUDENTS.DEPARTMENTID;");
		echo"<br>Виберіть студента<br><table bgcolor='white' width='100%' border='1'><tr  bgcolor='gray'><td></td><td>ФІО</td><td>Спеціальність</td><td>Факультет</td><td>Семестер</td><td>Група</td></tr>";
		for ($i=0;$i<count($student);$i++)
			{
			echo "<tr name='".$student[$i][0]."' class='id_vid_tr'>";
	
				echo "<td><input type='radio' name='id' class='id_vid' value='".$student[$i][0]."'></td><td>".$student[$i][1]."</td><td>".$student[$i][2]."</td><td>".$student[$i][3]."</td><td>".$student[$i][4]."</td><td>".$student[$i][5]."</td>";
				
			echo "</tr>";
			}
	echo "</table>";
	}
	if ($_GET['student']!='')
	{
	if (!file_exists("arhiv/students/".$_GET['student'])){mkdir("arhiv/students/".$_GET['student']);};
	
	echo "<script>var id_styd=".$_GET['student']."</script>";
	$student = $contingent->select("SELECT STUDENTS.STUDENTID, STUDENTS.FIO,GUIDE_SPECIALITY.SPECIALITY,GUIDE_DEPARTMENT.DEPARTMENT,STUDENTS.SEMESTER, STUDENTS.GROUPNUM,STUDENTS.RECORDBOOKNUM FROM STUDENTS,GUIDE_SPECIALITY,GUIDE_DEPARTMENT WHERE STUDENTS.STUDENTID='".$_GET['student']."' AND GUIDE_SPECIALITY.SPECIALITYID=STUDENTS.SPECIALITYID AND GUIDE_DEPARTMENT.DEPARTMENTID=STUDENTS.DEPARTMENTID;");
	$plan_semester = $contingent->select("select distinct BT.SEMESTER,BT.SEMESTER from STUDENT2TESTLIST S2T
inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join B_VARIANT_ITEMS BVI_V
  on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) where S2T.STUDENTID=".$student[0][0]." ");
  //---------навчальний план
    if ($_GET['semester']){
	
	$plan = $contingent->select("select bvm.modulenum,gd.discipline,bvm.moduletheme,S2T.TESTLISTID from STUDENT2TESTLIST S2T
inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm 
  on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join guide_discipline gd
  on (BVI_V.disciplineid = gd.disciplineid) where S2T.STUDENTID=".$student[0][0]." AND BT.SEMESTER=".$_GET['semester']." ORDER BY discipline"); }
	echo"<br><div class='well'><table bgcolor='white' width='100%'>";
	echo"<tr><td width=10%><b>Студент </td><td width=50%>".$student[0][1]."</td><td width=40% valign=top rowspan=6><img width='100' src='class/photo.php?id_photo=".$student[0][0]."'></td>
	<td rowspan=6 ><center><b>Навчальний план<br>";
	
	navigate('Фільтр по семестру',$plan_semester,'semester');
	echo"<div style='width: 700px; height: 300px; overflow: auto; ' id='over'><div class='well'><table bgcolor='#cecece' id='t' width='100%'>";
	for ($i=0;$i<count($plan);$i++)
			{
			echo "<tr style='font-size:8pt;' name='".$plan[$i][3]."' class='id_mod'>";

				echo "<td><input type='checkbox' name='mod' class='mod' value='".$plan[$i][3]."'></td><td><center>".$plan[$i][1]."</td><td>".$plan[$i][0].".".$plan[$i][2]."</td>";

			echo "</tr>";
			}
	echo "</table></div></div>";
	//---------навчальний план
	echo"</td></tr>";
	echo"<tr><td><b>Спеціальність </td><td>".$student[0][2]."</tr>";
	echo"<tr><td><b>Факультет </td><td>".$student[0][3]."</tr>";
	echo"<tr><td><b>Семестер </td><td>".$student[0][4]."</tr>";
	echo"<tr><td><b>Група </td><td>".$student[0][5]."</tr>";
	echo"<tr class='vidomist' style='display:none;'><td colspan=4 valign=bottom><center>
	Введіть дату <input type='text' class='span2' name='date'  value='".date("d.m.Y")."' id='dp1'> 
	Введіть оцінку <input type='text' id='ocinka' name='ocinka' value='".$_POST['ocinka']."'></td>";
	echo"<tr class='vidomist' style='display:none;'><td colspan=4 valign=bottom><center>
	<input type='button'  name='formy' class='formy' value='Зформувати відомість' onClick='vido()'></td></tr></table></div>";
	echo "<script>var semester='".$_GET['semester']."';</script><center><b>Збереженні відомості по студентові<br></b></center><div class='well'>";
	include "wood_script.php";
	echo"</div>";
	}

}else {header("Location: index.php");}
?> 
<script type="text/javascript" src="script/ser.js"></script>