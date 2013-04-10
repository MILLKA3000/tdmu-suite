<?php
 echo"<center><br><b><div class='stat'><br><a class='zag' name='zag' href='#'> Загальна статистика </a></div></b></center>
    <div class='table_zag'  name='table_zag' style='display:none;'>
    <table  border=1 bgcolor='white' style='font-size:9pt;' ><tr><td>№</td><td>Се-<br>ме-<br>стр</td><td>Потік</td><td>Час-<br>ти-<br>на</td><td>Назва модулю (дисципліни)</td><td>             
			Кількість студентів , що склали модуль на 'незадовіль-но' (відсоток)
		</td><td>Кількість студентів , що склали модуль на 'задовільно' (відсоток)  
		</td><td>Кількість студентів , що склали модуль на 'добре' (відсоток)
        </td><td>Кількість студентів , що склали модуль на 'відмінно' (відсоток)     
		</td><td>Cередній бал</td><td>Середній бал поточної успішності</td><td>Загальна кількість студентів</td>                                                                     
	</tr> ";
    
    $sum_array = array();
     for($j=1;$j<count($exel);$j++)
     {
        $parametr = $parametr." or excel_id='".$exel[$j]."'";
		$parametr2 = $parametr2." or id_excel='".$exel[$j]."'";
		$parametr3 = $parametr3." or id='".$exel[$j]."'";
     }
    //$discipline = $test->select_table_ocinka("SELECT DISTINCT discipline_id,module_id FROM table_ocinka,module WHERE module.excel_id='".$exel[0]."'".$parametr." ORDER BY excel_id,sort ASC;"); 
	$discipline = $test->select_module("SELECT DISTINCT id_discipline,id_module,sort FROM module WHERE (id_excel='".$exel[0]."'".$parametr2.") ORDER BY id ASC;");
    $excel = $test->select_excel($_POST['faculti']," AND id='".$exel[0]."'");
   // $ocinku = $test->select_table_ocinka("SELECT * FROM table_ocinka WHERE excel_id='".$exel[0]."';"); 
    $sum_students =  $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE (excel_id='".$exel[0]."'".$parametr.");");
     $_zag_2=0; $_zag_3=0; $_zag_4=0; $_zag_5=0;
    for ($j=0;$j<count($discipline);$j++)
        {
            
            $sum_stud =$test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku2 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND  examen = '0'  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku3 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND  (examen>'3.5' AND examen<'6.99')  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku4 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND  (examen>'6.99' AND examen<'9.99')  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku5 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND  (examen>'9.99' AND examen<'12.01')  AND (excel_id='".$exel[0]."'".$parametr.");");
			$_2=0;
			
			for($x=0;$x<count($ocinku2);$x++)
			{for($y=0;$y<count($sum_students);$y++)
					{
					if(($ocinku2[$x]['student_id']=='0')&&($ocinku2[$x]['student_id']==$ocinku3[$y]['student_id'])){$_2++;}	
					if(($ocinku2[$x]['student_id']=='0')&&($ocinku2[$x]['student_id']==$ocinku4[$y]['student_id'])){$_2++;}	
					if(($ocinku2[$x]['student_id']=='0')&&($ocinku2[$x]['student_id']==$ocinku5[$y]['student_id'])){$_2++;}
					}
			}
            if ($ocinku2[0]==NULL){$ocinku2='0';}else{$ocinku2=count($ocinku2)-$_2;$_zag_2=$_zag_2+$ocinku2;}
            if ($ocinku3[0]==NULL){$ocinku3='0';}else{$ocinku3=count($ocinku3);$_zag_3=$_zag_3+$ocinku3;}
            if ($ocinku4[0]==NULL){$ocinku4='0';}else{$ocinku4=count($ocinku4);$_zag_4=$_zag_4+$ocinku4;}
            if ($ocinku5[0]==NULL){$ocinku5='0';}else{$ocinku5=count($ocinku5);$_zag_5=$_zag_5+$ocinku5;}
			if ($sum_stud[0]==NULL){$sum_stud='0.0001';}else{$sum_stud=count($sum_stud);}
			$ocinku = $test->select_table_ocinka("SELECT examen,potochna FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND (excel_id='".$exel[0]."'".$parametr.");");
			$exam=0;
			$potoch=0;
			for($x=0;$x<count($ocinku);$x++){
			$exam=$exam+$ocinku[$x]['examen'];
			//echo $potoch."=".$potoch."+".$ocinku[$x]['potochna']."<br>";
			$potoch=$potoch+$ocinku[$x]['potochna'];
			}
			$exam=$exam/count($ocinku);
			$potoch=$potoch/count($ocinku);
			
			$predmet = $test->select_module("SELECT DISTINCT name_discipline,name_module,sort,id_excel FROM module WHERE sort='".$discipline[$j]['sort']."' AND id_discipline='".$discipline[$j]['id_discipline']."' AND id_module='".$discipline[$j]['id_module']."';");
			$predmet2 = $test->select_module("SELECT name_discipline,name_module,sort,id_excel FROM module WHERE (id_excel='".$exel[0]."'".$parametr2.") AND sort='".$discipline[$j]['sort']."' AND id_discipline='".$discipline[$j]['id_discipline']."' AND id_module='".$discipline[$j]['id_module']."';");
         echo "<tr align='center'><td>".($j+1)."</td>
         <td>".$excel[0]['semester']."</td><td>";
		 for($z=0;$z<count($predmet2);$z++)
			{	
			$excel = $test->select_excel2("SELECT DISTINCT potik,chastuna,semester FROM excel WHERE id='".$predmet2[$z]['id_excel']."';");
			echo $excel[0]['potik']." ";
			}
		 
		 echo "</td><td>".$excel[0]['chastuna']."</td>
         <td>".$predmet[0]['name_discipline']." - ".$predmet[0]['name_module']."</td>
         <td>".$ocinku2." (".round($ocinku2*100/$sum_stud,2)."%)</td>
         <td>".$ocinku3." (".round($ocinku3*100/$sum_stud,2)."%)</td>
         <td>".$ocinku4." (".round($ocinku4*100/$sum_stud,2)."%)</td>
         <td>".$ocinku5." (".round($ocinku5*100/$sum_stud,2)."%)</td>
         <td>".round($exam,2)."</td>
         <td>".round($potoch,2)."</td>
         <td>".round($sum_stud)."</td>
         </tr>";
      
        }
        $full=$_zag_2+$_zag_3+$_zag_4+$_zag_5+0.00001;
     echo "
     <tr align='center'><td colspan=5>Загальна</td>
     <td>".round($_zag_2)." (".round(($_zag_2/($full)*100),2)."%)</td>
     <td>".round($_zag_3)." (".round(($_zag_3/($full)*100),2)."%)</td>
     <td>".round($_zag_4)." (".round(($_zag_4/($full)*100),2)."%)</td>
     <td>".round($_zag_5)." (".round(($_zag_5/($full)*100),2)."%)</td>
     </tr>
     <tr><td td colspan=12> 
     <script type='text/javascript'>var zag_2 = ".$_zag_2.";var zag_3 = ".$_zag_3.";var zag_4 = ".$_zag_4.";var zag_5 = ".$_zag_5.";</script>
     <div id='chart_div' style='width: 400px; height: 200px;'></div>
     
    </td></tr></table></div>"; 
?>