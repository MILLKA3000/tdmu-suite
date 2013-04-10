<?

require_once "class/class_firebird.php";
require_once "class/function.php";
$contingent = new class_ibase();
$student = $contingent->select("SELECT STUDENTS.STUDENTID, STUDENTS.FIO,GUIDE_SPECIALITY.SPECIALITY,GUIDE_DEPARTMENT.DEPARTMENT,STUDENTS.SEMESTER, STUDENTS.GROUPNUM,STUDENTS.RECORDBOOKNUM FROM STUDENTS,GUIDE_SPECIALITY,GUIDE_DEPARTMENT WHERE STUDENTS.STUDENTID='".$_GET['student']."' AND GUIDE_SPECIALITY.SPECIALITYID=STUDENTS.SPECIALITYID AND GUIDE_DEPARTMENT.DEPARTMENTID=STUDENTS.DEPARTMENTID;");
$plan = $contingent->select("select bvm.modulenum,gd.discipline,bvm.moduletheme,S2T.TESTLISTID,S2T.CREDITS_CUR from STUDENT2TESTLIST S2T
inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm 
  on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join guide_discipline gd
  on (BVI_V.disciplineid = gd.disciplineid) where BT.TESTLISTID=".$_GET['modul']." AND S2T.STUDENTID=".$_GET['student']."");
if ($_GET['ocinka']==0){$ex='0(не склав)';$ost='(не склав)';}else{$ex=$_GET['ocinka'];$ost=potochna($plan[0][4])*0.6+$ex*0.4;}

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
 	     <p>За _<u>".$_GET['semester']."</u>___ навчальний семестр, екзамен <u>_".$_GET['date']."___</u></p>
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
 
 	       <tr>
 	          <td width=10%>
1
 		  </td>    
 	          <td width=50%> 
".$student[0][1]."
 		  </td>          
 	          <td width=10%> 
".$student[0][6]."
 		  </td>          
 	          <td width=15%> 
".potochna($plan[0][4])."
 		  </td>           
 		  <td width=15%>  
".$ex."
 		  </td>           
 	          <td width=10%>  
".$ost."
 		  </td>          
 	       </tr>             
 
  	     </table><br />        
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
  	
 
echo $stream;
$fp2 = fopen("arhiv/students/".$_GET['student']."/semester-".$_GET['semester']."_|_". rus2translit($plan[0][0]).".". rus2translit($plan[0][1])."_(".date("d-m-Y").").doc","w+");

fwrite($fp2, $stream); 
fclose($fp2);

 ?> 
