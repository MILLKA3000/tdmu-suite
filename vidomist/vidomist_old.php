 <script type="text/javascript" src="http://www.eyecon.ro/datepicker/js/jquery.js"></script>
 <link href="styles/datepicker.css" rel="stylesheet">
<script src="script/bootstrap-datepicker.js"></script>
<?php  
include "auth.php";
if ($_SESSION['name_sesion_a']=="admin"){ 
include "menu.php";
include "navigate.php"; 
include "class/function.php";
include "class/pclzip.lib.php";
include "class/potochna.php";
require_once "class/class_firebird.php";
require_once "class/mysql_class_local.php";
include_once "class/class reader.php";
$contingent = new class_ibase();
$local = new class_mysql_base_local(); 
echo"<div class='well'><center><h2>Створення відомостей</h2><form action='vidomist_old.php?".$_SERVER['QUERY_STRING']."' method='post' enctype='multipart/form-data'>
      Виберіть файл <input type='file' name='filename'  value='Огляд'> <input type='submit' value='Завантажити дані'></div></form>";
	  echo "<br></b><center>"; 
	  if (isset($_FILES["filename"]["tmp_name"])) {
    if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
     {
		$table=array();
		$name_table=array('Оцінки','Звязок','Предмети','Поточна успішність','Таблиця точності');
		$table_id=array('1','2','3','4','5');
		$temp_file = date("d-m-i-s");
         move_uploaded_file($_FILES["filename"]["tmp_name"], "xls/".$temp_file.$_FILES["filename"]["name"]);
         
         $data = new XLSToDB($temp_file.$_FILES["filename"]["name"], 'UTF-8');
         $fileXLS=$temp_file.$_FILES["filename"]["name"];
         $links="xls/".$temp_file.$_FILES["filename"]["name"];
		 //-----формування масивів листів 
         $table[0]=$ocinku_styd=$data->get($fileXLS,0,10);
		 $table[1]=$zvjaz_styd=$data->get($fileXLS,1,3);
		 $table[2]=$module_styd=$data->get($fileXLS,2,6);
		 $table[3]=$potochna_styd=$data->get($fileXLS,3,12);
		 $table[4]=$ostatochna_styd=$data->get($fileXLS,4,12);
		 $kilk=0;$g=0;$l1=0;
	//----------------таблиці   ----------------------------
	   table($name_table,$table,$table_id);
	   $local->ins("DELETE FROM `pr` WHERE name_user='".$_SESSION['role']."';");
		for ($i=0;$i<count($module_styd);$i++)
		 {	
			if ($module_styd[$i][0]!=NULL){
			$local->ins("INSERT INTO  `vidomosti`.`pr` (`num` ,`idvar`,`name_user`)VALUES ('".$module_styd[$i][0]."',  '".$module_styd[$i][5]."',  '".$_SESSION['role']."');");
		 }}	   
		$kilk_mod = $local->select("SELECT * FROM pr WHERE name_user='".$_SESSION['role']."';");
		 for($i=0;$i<10;$i++)
         {
            if ($ocinku_styd[0][$i]!=NULL)$kilk++;
         }
		
	//Оброблення таблиці оцінок  
         for ($i=0 ; $i < count($ocinku_styd)+1 ; $i++)
    {	

        if ($ocinku_styd[$i][0]!=""){
         for ($j=2;$j<$kilk-1;$j++)
         {
         if ($ocinku_styd[$i][0]==1)
         {
         $ocinku[$g][1]=$j-1;
         }
    
          if (($ocinku_styd[$i][0]==2)&&($j-1+$kilk-3<=count($kilk_mod)))
           {
           $ocinku[$g][1]=$j-1+$kilk-3;
           }
			  /*
          if ($ocinku_styd[$i][0]==3)
             {
                $ocinku[$g][1]=$j-1+$kilk*2-4;
             }*/
			 if (($ocinku_styd[$i][0]==1)&&($j-1<=count($kilk_mod))){
            $ocinku[$g][2]=$ocinku_styd[$i][$j+1];
            $ocinku[$g][0]=$ocinku_styd[$i][2];
			$g++;}
			 if (($ocinku_styd[$i][0]==2)&&($j-1+$kilk-3<=count($kilk_mod))){
            $ocinku[$g][2]=$ocinku_styd[$i][$j+1];
            $ocinku[$g][0]=$ocinku_styd[$i][2];
			$g++;}
            }}}	

	//END Оброблення таблиці оцінок	
	echo $_SESSION['role'];
			$local->ins("DELETE FROM `oc` WHERE name_user='".$_SESSION['role']."';");$local->ins("DELETE FROM `zv` WHERE name_user='".$_SESSION['role']."';");$local->ins("DELETE FROM `to` WHERE name_user='".$_SESSION['role']."';");
	//INSERT OC таблиці оцінок
		 for ($i=0;$i<count($ocinku);$i++)
		 {	
			if ($ocinku[$i][0]!=NULL){
			$local->ins("INSERT INTO  `vidomosti`.`oc` (`kod` ,`num` ,`oc`,`name_user`)VALUES ('".$ocinku[$i][0]."',  '".$ocinku[$i][1]."',  '".$ocinku[$i][2]."',  '".$_SESSION['role']."');");
		 }}
		 
		/*for ($i=0;$i<count($module_styd);$i++)
		 {	
			if ($module_styd[$i][0]!=NULL){
			$local->ins("INSERT INTO  `vidomosti`.`pr` (`num` ,`idvar`,`name_user`)VALUES ('".$module_styd[$i][0]."',  '".$module_styd[$i][5]."',  '".$_SESSION['role']."');");
		 }}*/
		 
		 for ($i=0;$i<count($zvjaz_styd);$i++)
		 {		
			if ($zvjaz_styd[$i][0]!=NULL){
			$gr=$contingent->select("SELECT groupnum FROM students WHERE studentid='".$zvjaz_styd[$i][1]."'");
			$local->ins("INSERT INTO `vidomosti`.`zv` (`idstyd`, `kod`, `gr`,`name_user`) VALUES ('".$zvjaz_styd[$i][1]."', '".$zvjaz_styd[$i][2]."', '".$gr[0][0]."',  '".$_SESSION['role']."');");
		 }}
		 
		 
			
		for ($i=0;$i<count($ostatochna_styd);$i++)
		 for ($j=2;$j<$kilk-1;$j++)
		 {	
			if ($ostatochna_styd[$i][0]!=NULL){
			if ($ostatochna_styd[$i][$j]=='0'){$ostatochna_styd[$i][$j]='true';}else if($ostatochna_styd[$i][$j]==''){$ostatochna_styd[$i][$j]='false';}
			$local->ins("INSERT INTO `vidomosti`.`to` (`idstyd`, `num`, `value`,`name_user`) VALUES ('".$ostatochna_styd[$i][1]."', '".($j-1)."', '".$ostatochna_styd[$i][$j]."',  '".$_SESSION['role']."');");}
		 }
		}}
		$kilk_mod = $local->select("SELECT * FROM pr WHERE name_user='".$_SESSION['role']."';");
		//-----------------------------------------------------------------------------------
		if ((isset($_FILES["filename"]["tmp_name"]))||$_POST['obr']){
		echo "</center><img id='active_d' act='N' src='http://market.auto.ria.ua/img/minus.gif'>Приховати/Показати дані по файлу<center>
		<div id='disciplin' >";
		echo "<div class='well'>";
		
		$ZV = $local->select("SELECT * FROM zv WHERE name_user='".$_SESSION['role']."';");
		
		echo "<b>Кількість студентів: ".count($ZV)."<br></b><hr>";	
		$not_oc_kod = $local->select("SELECT DISTINCT kod FROM  `oc` WHERE name_user='".$_SESSION['role']."' AND CHARACTER_LENGTH( kod ) <5 OR CHARACTER_LENGTH( kod ) >5 OR kod LIKE '%О%' OR kod LIKE '%З%' OR kod LIKE '%Т%' OR kod LIKE '%T%' OR kod LIKE '%O%';");		
		echo "<b>Виявлених можливих помилок у скануванні: ";
		if(count($not_oc_kod)==0){echo"<font color=green>".count($not_oc_kod)."</font></b>";}else{echo"<font color=red>".count($not_oc_kod)."</font></b>";}
				echo "<br> &nbsp;&nbsp;<img class='t' name='s1' act='Y' src='images/down.gif'>
				<div id='s1' tabl=d style='display:none;'>";
				for ($i=0;$i<count($not_oc_kod);$i++)
				{	
					echo " (".$not_oc_kod[$i][0].") ";
				}
				echo"</div>";
		$povtor_oc = $local->select("SELECT e1.kod FROM oc e1, oc e2 WHERE e1.name_user='".$_SESSION['role']."' AND e2.name_user='".$_SESSION['role']."' AND e1.kod = e2.kod GROUP BY e1.kod HAVING COUNT( e1.kod ) >=".(count($kilk_mod)*count($kilk_mod)+1)."");
		
		echo "<hr><b>Кількість виявлених повторів у скануванні: ";
		if(count($povtor_oc)==0){echo"<font color=green>".count($povtor_oc)."</font></b>";}else{echo"<font color=red>".count($povtor_oc)."</font></b>";}
		echo "<br> &nbsp;&nbsp;<img class='t' name='s2' act='Y' src='images/down.gif'>
				<div id='s2' tabl=d style='display:none;'>";
		for ($i=0;$i<count($povtor_oc);$i++)
				{	
					echo " (".$povtor_oc[$i][0].") ";
				}	
		echo"</div>";				
		$povtor_zv_one = $local->select("SELECT e1.kod FROM zv e1, zv e2 WHERE e1.name_user='".$_SESSION['role']."' AND e2.name_user='".$_SESSION['role']."' AND e1.kod = e2.kod GROUP BY e1.kod HAVING COUNT( e1.kod ) >=2");
			for ($i=0;$i<count($povtor_zv_one);$i++){$mas_styd_povtor[$i]=$povtor_zv_one[$i][0];}
			if (for_sql($mas_styd_povtor)=='') {$sql_kod='0';}else{$sql_kod=for_sql($mas_styd_povtor);}
		$povtor_zv = $local->select("SELECT * FROM zv WHERE name_user='".$_SESSION['role']."' AND kod in (".$sql_kod.") order by kod;");
		echo "<hr><b>Кількість виявлених повторів у розкодуванні: ";
		if(count($povtor_zv_one)==0){echo"<font color=green>".count($povtor_zv_one)."</font></b>";}else{echo"<font color=red>".count($povtor_zv_one)."</font></b>";}
				echo "<br> &nbsp;&nbsp;<img class='t' name='s3' act='Y' src='images/down.gif'>
				<div id='s3' tabl=d style='display:none;'>";
				for ($i=0;$i<count($povtor_zv);$i++)
				{	
					$styd_name=$contingent->select("SELECT FIO,groupnum FROM students WHERE studentid='".$povtor_zv[$i][1]."'");
					echo "<font color=red> <b> ".$styd_name[0][0]." код (".$povtor_zv[$i][2].") група ".$styd_name[0][1]."</b></font><br>";
				}
		echo"</div>";
		$not_zv = $local->select("SELECT * FROM zv WHERE name_user='".$_SESSION['role']."' AND zv.kod NOT IN (SELECT oc.kod FROM oc);");
		echo "<hr><b>Кількість невиявлених оцінок у кодах: ";
		if(count($not_zv)==0){echo"<font color=green>".count($not_zv)."</font></b>";}else{echo"<font color=red>".count($not_zv)."</font></b>";}
				echo "<br> &nbsp;&nbsp;<img class='t' name='s4' act='Y' src='images/down.gif'>
				<div id='s4' tabl=d style='display:none;'>";
				for ($i=0;$i<count($not_zv);$i++)
				{	
					$styd_name=$contingent->select("SELECT FIO,groupnum FROM students WHERE studentid='".$not_zv[$i][1]."'");
					echo "<font color=red> <b> ".$styd_name[0][0]." код (".$not_zv[$i][2].") група ".$styd_name[0][1]."</b></font><br>";
				}
		echo"</div>";
		$not_to = $local->select("SELECT * FROM zv WHERE name_user='".$_SESSION['role']."' AND zv.idstyd NOT IN (SELECT to.idstyd FROM `to`);");
		echo "<hr><b>Кількість невиявлених студентів у таблиці точності: ".count($not_to)."<br></b>";
				echo " &nbsp;&nbsp;<img class='t' name='s5' act='Y' src='images/down.gif'>
				<div id='s5' tabl=d style='display:none;'>";
				for ($i=0;$i<count($not_to);$i++)
				{	
					$styd_name=$contingent->select("SELECT FIO,groupnum FROM students WHERE studentid='".$not_to[$i][1]."'");
					echo "<font color=gray> <b> ".$styd_name[0][0]." id ".$not_to[$i][1]." група ".$styd_name[0][1]."</b></font><br>";
				}		
		echo"</div>"; 
		echo "</div></div><br>"; 
		
		if ($_POST['mod_name']=='on'){$str='CHECKED=CHECKED';}else{$str='';}
		if ($_POST['date']){$date=$_POST['date'];}else{$date = date("d.m.Y");}
		echo "</center><div class='well'>
		<form action='vidomist_old.php?".$_SERVER['QUERY_STRING']."&file=".$links."' method='post' enctype='multipart/form-data'>
		<br><input type='checkbox' name='ects' CHECKED=CHECKED> ECTS (60/40) (Відмітьте для кредитно модульної системи обробки) 
		<br><input type='checkbox' name='to' CHECKED=CHECKED> Використати для обробки таблицю точності 
		<br><input type='checkbox' name='mod_name' ".$str."> Довгі назви файлів (повна назва дисципліни замість номера) 
		<br><input type='checkbox' name='arhiv_rar' CHECKED=CHECKED> Зробити архівну копію RAR (У папці з файлами буде поміщено архів rar з усіма даними)
		<br><input type='checkbox' name='arhiv'> Добавити в архів бази (даний файл буде поміщено у БД)
		<br>
        <div class='span9 columns'>
		<div class='well'>
            <input type='text' class='span2' name='date' value='".$date."' id='dp1' >Введіть дату для обробки відомостей
          </div></div> 
		<br><center><input type='submit' name='obr'  value='Зробити відомості'></form></div>";

		} 
		if ($_POST['obr']==true){
		
		echo "<script>
		$('#disciplin').slideUp();
		$('#active_d').attr('act','Y');
		$('#active_d').attr('src','http://market.auto.ria.ua/img/plus.gif');
		</script>
		";
		
		//-------------------Наявні предмети
			$discipline = $local->select("SELECT * FROM  `pr` WHERE name_user='".$_SESSION['role']."'");
		
		//-------------------Наявні групи
			$group = $local->select("SELECT DISTINCT gr FROM  `zv` WHERE name_user='".$_SESSION['role']."' order by gr");

		//-------------------1 студент у таблиці звязку
			$one_styd = $local->select("SELECT * FROM  `zv` WHERE name_user='".$_SESSION['role']."'");
			
		//-------------------По першому студенту дізнатись факультет та спеціальність 
			$student = $contingent->select("SELECT STUDENTS.STUDENTID, STUDENTS.FIO,GUIDE_SPECIALITY.SPECIALITY,GUIDE_DEPARTMENT.DEPARTMENT,STUDENTS.SEMESTER, STUDENTS.GROUPNUM,STUDENTS.RECORDBOOKNUM FROM STUDENTS,GUIDE_SPECIALITY,GUIDE_DEPARTMENT WHERE STUDENTS.STUDENTID='".$one_styd[0][1]."' AND GUIDE_SPECIALITY.SPECIALITYID=STUDENTS.SPECIALITYID AND GUIDE_DEPARTMENT.DEPARTMENTID=STUDENTS.DEPARTMENTID;");
		//-------------------Створення іїрархії папок 
		
		if (!file_exists("arhiv/faculty/".rus2translit($student[0][3]))){mkdir("arhiv/faculty/".rus2translit($student[0][3]));};
		if (!file_exists("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2]))){mkdir("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2]));};
		if (!file_exists("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4]))){mkdir("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4]));};
		if (!file_exists("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date)){mkdir("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date);};
		if (!file_exists("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/Vidomist/")){mkdir("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/Vidomist/");};
		if (!file_exists("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/Statistick/")){mkdir("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/Statistick/");};
		if (@fopen($_GET['file'], "r"))
		{
		rename($_GET['file'], "arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/original.xls");
		}
		for ($i=0;$i<count($discipline);$i++)
		{	
			$plan = $contingent->select("select bvm.modulenum,gd.discipline,bvm.moduletheme,BT.SEMESTER from STUDENT2TESTLIST S2T
		    inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm 
			on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join guide_discipline gd
			on (BVI_V.disciplineid = gd.disciplineid) where BT.TESTLISTID=".$discipline[$i][2]."");
			
			for ($j=0;$j<count($group);$j++)
			{
			
			$tochn=$local->select("SELECT COUNT(value) FROM  `zv`,`to` WHERE zv.name_user='".$_SESSION['role']."' AND zv.idstyd=to.idstyd AND to.num=".$discipline[$i][1]." AND zv.gr=".$group[$j][0]." AND to.value='true'");
			
			if ($tochn[0][0]!='0'){
			$stream="<html>
						<head>
							<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
						<style> 
						body {font-size:14px;} 
						</style> 
					</head>
					<body>
        
					<p align=center>МІНІСТЕРСТВО ОХОРОНИ ЗДОРОВЯ УКРАЇНИ </p>
					<p align=center><b><u>Тернопільський державний медичний університет імені І.Я. Горбачевського</u></b></p>
					<span align=left> Факультет <u>".$student[0][3]."</u></span><br>
					<span align=left> Спеціальність <u>".$student[0][2]."</u></span>
 				    <span align=right>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Група_<u>".$student[0][5]."</u>___</span>
					&nbsp;&nbsp;&nbsp;&nbsp;2012/2013 навчальний рік &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Курс _<u>".course($student[0][4])."</u>___<br />
             	     <p align=center>ЕКЗАМЕНАЦІЙНА ВІДОМІСТЬ №____ </p>
             	     <p>З <u>".$plan[0][0].".".$plan[0][2]."</u> - <u>".$plan[0][1]."</u></p>
             	     <p>За _<u>".$plan[0][3]."</u>___ навчальний семестр, екзамен <u>_".$date."___</u></p>
					 <table class=guestbook width=600 align=center cellspacing=0 cellpadding=3 border=1>
             	       <tr>
             	          <td width=10%>
             			<b>№ п/п</b>
             		  </td>
             	          <td width=50%>
             			<b>Прізвище, ім'я по-батькові</b>
             		  </td>
             	          <td width=10%>
             			<b>№ індиві-дуального навч. плану</b>
             		  </td>
 	                      <td width=15%>
 	            		<b>Оцінка за поточну успішність</b>
 	            	  </td>
                                  
 	            	  <td width=15%>
             			<b>Екзаме-наційна оцінка</b>
 	            	  </td>
 	                      <td width=10%>
 	            		<b>Оцінка за модуль</b>
 	                        	  </td>
                       
 	                   </tr>
             ";
				$styd = $local->select("SELECT * FROM  `zv` WHERE name_user='".$_SESSION['role']."' AND gr='".(int)$group[$j][0]."';");	
						for ($x=0;$x<count($styd);$x++){
						if ($_POST['to']=='on'){
						$to=$local->select("SELECT value FROM  `zv`,`to` WHERE zv.name_user='".$_SESSION['role']."' AND zv.idstyd=".$styd[$x][1]." AND zv.idstyd=to.idstyd AND to.num=".$discipline[$i][1]."");	
						}else $to[0][0]='true';
				if ($to[0][0]=='true'){		
				$exam_styd = $local->select("SELECT oc.oc FROM  `zv`,`oc` WHERE zv.name_user='".$_SESSION['role']."' AND zv.kod LIKE oc.kod AND oc.num=".$discipline[$i][1]." AND zv.idstyd=".$styd[$x][1]."");
				$students = $contingent->select("SELECT STUDENTS.STUDENTID, STUDENTS.FIO,GUIDE_SPECIALITY.SPECIALITY,GUIDE_DEPARTMENT.DEPARTMENT,STUDENTS.SEMESTER, STUDENTS.GROUPNUM,STUDENTS.RECORDBOOKNUM FROM STUDENTS,GUIDE_SPECIALITY,GUIDE_DEPARTMENT WHERE STUDENTS.STUDENTID='".$styd[$x][1]."' AND GUIDE_SPECIALITY.SPECIALITYID=STUDENTS.SPECIALITYID AND GUIDE_DEPARTMENT.DEPARTMENTID=STUDENTS.DEPARTMENTID;");
				$plans = $contingent->select("select bvm.modulenum,gd.discipline,bvm.moduletheme,S2T.TESTLISTID,S2T.CREDITS_CUR from STUDENT2TESTLIST S2T
				inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm 
				on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join guide_discipline gd
				on (BVI_V.disciplineid = gd.disciplineid) where BT.TESTLISTID=".$discipline[$i][2]." AND S2T.STUDENTID=".$students[0][0]."");
				if (($exam_styd[0][0]==0) || (($_POST['to']!='on')&&($to[0][0]=='true'))){$ex='0(не склав)';$ost='(не склав)';}else{
				$ex=$exam_styd[0][0];if ($_POST['ects']=='on'){$ost=potochna($plans[0][4])*0.6+$ex*0.4;}else{$ost=potochna($plans[0][4])*0.5+$ex*0.5;$ost=number_format( $ost, 0);}}
				
				$stream.="
 	                   <tr>
 	                      <td width=10%>
                        ".($x+1)."
             		  </td>    
 	                      <td width=50%> 
                        ".$students[0][1]."
             		  </td>          
             	          <td width=10%> 
                        ".$students[0][6]."
             		  </td>          
             	          <td width=15%> 
                        ".potochna($plans[0][4])."  
             		  </td>           
             		  <td width=15%>  
                        ".$ex."
             		  </td>           
             	          <td width=10%>  
						".$ost."
             		  </td>          
             	       </tr>             
				";}}
              $stream.="</table><br />        
              		Голова комісії _______________________________________________________________ <br>                      
              		(вчені звання, прізвище та ініціали)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(підпис)<br />       
              		Члени комісії _______________________________________________________________ <br>                       
              		(вчені звання, прізвище та ініціали)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(підпис)<br />       
              		Викладач(і) _________________________________________________________________ <br>                       
              		(вчені звання, прізвище та ініціали)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(підпис) <br>        
              		____________________________________________________________________________ <br>                        
              		(вчені звання, прізвище та ініціали)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(підпис) <br><br>    
              		1.	Проти прізвища студента, який не з’явився  на підсумковий контроль, екзаменатор вказує – „не з’явився”.<br> 
              		2.	Відомість подається в деканат не пізніше наступного дня після проведення підсумкового контролю. ";   
				
				
				if ($_POST['mod_name']=='on')
				{
				$fp2 = fopen("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/Vidomist/".$group[$j][0]."-".$discipline[$i][1]."(".$plan[0][0].".".$plan[0][1].").doc","w+");
				}else
				{
				$fp2 = fopen("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/Vidomist/".$group[$j][0]."-".$discipline[$i][1].".doc","w+");
				}
				fwrite($fp2, $stream);
				fclose($fp2);
				$stream="";
				}}}
				include('statistick/zagaln.php');
		$url="arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date;		
		//-------------------------------//создаем новый архив
		
		if ($_POST['arhiv_rar']=='on'){
			if (@fopen($url."/all.zip", "r")){unlink($url."/all.zip");}
		
		$archive = new PclZip("all.zip"); 
				
		$openDIR = opendir("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date);
		while ($scan = readdir($openDIR))
		{
		if($scan == '.' || $scan == '..' ) continue;
		
		$archive->add("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/".$scan, PCLZIP_OPT_REMOVE_PATH , "arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4]));
		}	
		rename("all.zip", "arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/all.zip");
		}
		echo"<br><div class='well'>";
		include "wood_script_old.php";
		echo"</div>";	
		}
}else {header("Location: index.php");}
?> 
<script type="text/javascript" src="script/ser.js"></script>