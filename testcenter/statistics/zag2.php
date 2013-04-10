<?php
  echo"<center><b><div class='stat'><br><a class='zag2' name='zag' href='#'> Cтатистика по бюджет контракт </a></div></b></center>
    <div class='table_zag2'  name='table_zag' style='display:none;'>
    <table  border=1 bgcolor='white' style='font-size:9pt;'><tr><td rowspan=2>№</td><td rowspan=2>Семе-<br>стер</td><td rowspan=2>Потік</td><td rowspan=2>Час-<br>ти-<br>на</td>
	<td rowspan=2>Назва модулю (дисципліни)
        </td><td colspan=2>Кількість студентів , що склали модуль на 'незадовіль-но' (відсоток)
		</td><td colspan=2>Кількість студентів , що склали модуль на 'задовільно' (відсоток)  
		</td><td colspan=2>Кількість студентів , що склали модуль на 'добре' (відсоток)
        </td><td colspan=2>Кількість студентів , що склали модуль на 'відмінно' (відсоток)     
		</td><td colspan=2>Cередній бал
        </td><td colspan=2>Середній бал поточної успішності
        </td><td rowspan=2>Загальна кількість студентів</td>                                                                     
	</tr>
    <tr>
    <td>Бюджет</td><td>Контракт</td>
    <td>Бюджет</td><td>Контракт</td>
    <td>Бюджет</td><td>Контракт</td>
    <td>Бюджет</td><td>Контракт</td>
    <td>Бюджет</td><td>Контракт</td>
    <td>Бюджет</td><td>Контракт</td> 
    "; 
    $sum_array = array();
     for($j=1;$j<count($exel);$j++)
     {
        $parametr = $parametr." or excel_id='".$exel[$j]."'";
		$parametr2 = $parametr2." or id_excel='".$exel[$j]."'";
     }
     $discipline = $test->select_module("SELECT DISTINCT id_discipline,id_module,sort FROM module WHERE (id_excel='".$exel[0]."'".$parametr2.") ORDER BY id ASC;");
     $excel = $test->select_excel($_POST['faculti']," AND id='".$exel[0]."'");
     $sum_students =  $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE (excel_id='".$exel[0]."'".$parametr.");");
    $_zag_2_b=0;$_zag_2_k=0;
    $_zag_3_b=0;$_zag_3_k=0;
    $_zag_4_b=0;$_zag_4_k=0;
    $_zag_5_b=0;$_zag_5_k=0;        
    for ($j=0;$j<count($discipline);$j++)
        {
            
            $sum_stud_b =$test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'Б' AND (excel_id='".$exel[0]."'".$parametr.");");
            $sum_stud_k =$test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'К' AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku2_b = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'Б' AND examen = '0' AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku3_b = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'Б' AND (examen>'3.5' AND examen<'6.99') AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku4_b = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'Б' AND (examen>'6.99' AND examen<'9.99') AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku5_b = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'Б' AND (examen>'9.99' AND examen<'12.01') AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku2_k = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'К' AND examen = '0' AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku3_k = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'К' AND (examen>'3.5' AND examen<'6.99') AND  (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku4_k = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'К' AND (examen>'6.99' AND examen<'9.99') AND  (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku5_k = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND form LIKE 'К' AND (examen>'9.99' AND examen<'12.01') AND  (excel_id='".$exel[0]."'".$parametr.");");
			$_2=0;
			for($x=0;$x<count($ocinku2_b);$x++)
			{for($y=0;$y<count($sum_stud_b);$y++)
					{
					if(($ocinku2_b[$x]['student_id']=='0')&&($ocinku2_b[$x]['student_id']==$ocinku3_b[$y]['student_id'])){$_2++;}	
					if(($ocinku2_b[$x]['student_id']=='0')&&($ocinku2_b[$x]['student_id']==$ocinku4_b[$y]['student_id'])){$_2++;}	
					if(($ocinku2_b[$x]['student_id']=='0')&&($ocinku2_b[$x]['student_id']==$ocinku5_b[$y]['student_id'])){$_2++;}
					}
			}
            
			$_2=0;
			for($x=0;$x<count($ocinku2_k);$x++)
			{for($y=0;$y<count($sum_stud_k);$y++)
					{
					if(($ocinku2_k[$x]['student_id']=='0')&&($ocinku2_k[$x]['student_id']==$ocinku3_k[$y]['student_id'])){$_2++;}	
					if(($ocinku2_k[$x]['student_id']=='0')&&($ocinku2_k[$x]['student_id']==$ocinku4_k[$y]['student_id'])){$_2++;}	
					if(($ocinku2_k[$x]['student_id']=='0')&&($ocinku2_k[$x]['student_id']==$ocinku5_k[$y]['student_id'])){$_2++;}
					}
			}
            
            if ($ocinku2_b[0]==NULL){$ocinku2_b='0';}else{$ocinku2_b=count($ocinku2_b)-$_2;}
            if ($ocinku3_b[0]==NULL){$ocinku3_b='0';}else{$ocinku3_b=count($ocinku3_b);}
            if ($ocinku4_b[0]==NULL){$ocinku4_b='0';}else{$ocinku4_b=count($ocinku4_b);}
            if ($ocinku5_b[0]==NULL){$ocinku5_b='0';}else{$ocinku5_b=count($ocinku5_b);}
			if ($sum_stud_b[0]==NULL){$sum_stud_b='0.0001';}else{$sum_stud_b=count($sum_stud_b);}
            
            if ($ocinku2_k[0]==NULL){$ocinku2_k='0';}else{$ocinku2_k=count($ocinku2_k)-$_2;}
            if ($ocinku3_k[0]==NULL){$ocinku3_k='0';}else{$ocinku3_k=count($ocinku3_k);}
            if ($ocinku4_k[0]==NULL){$ocinku4_k='0';}else{$ocinku4_k=count($ocinku4_k);}
            if ($ocinku5_k[0]==NULL){$ocinku5_k='0';}else{$ocinku5_k=count($ocinku5_k);}
			if ($sum_stud_k[0]==NULL){$sum_stud_k='0.0001';}else{$sum_stud_k=count($sum_stud_k);}
            
            $ocinku_b = $test->select_table_ocinka("SELECT examen,potochna FROM table_ocinka WHERE form LIKE 'Б' AND sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND (excel_id='".$exel[0]."'".$parametr.");");
			
			$ocinku_k = $test->select_table_ocinka("SELECT examen,potochna FROM table_ocinka WHERE form LIKE 'К' AND sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND (excel_id='".$exel[0]."'".$parametr.");");
			$exam_b=0;
			$potoch_b=0;
            $exam_k=0;
			$potoch_k=0;
			for($x=0;$x<count($ocinku);$x++){
			$exam_b=$exam_b+$ocinku_b[$x]['examen'];
			$potoch_b=$potoch_b+$ocinku_b[$x]['potochna'];
			$exam_k=$exam_k+$ocinku_k[$x]['examen'];
			$potoch_k=$potoch_k+$ocinku_k[$x]['potochna'];
			}
			$exam_b=$exam_b/count($ocinku_b);
			$potoch_b=$potoch_b/count($ocinku_b);
            $exam_k=$exam_k/count($ocinku_k);
			$potoch_k=$potoch_k/count($ocinku_k);
            
			$predmet = $test->select_module("SELECT DISTINCT name_discipline,name_module,sort FROM module WHERE sort='".$discipline[$j]['sort']."' AND id_discipline=".$discipline[$j]['id_discipline']." AND id_module='".$discipline[$j]['id_module']."';");
			$predmet2 = $test->select_module("SELECT name_discipline,name_module,sort,id_excel FROM module WHERE (id_excel='".$exel[0]."'".$parametr2.") AND sort='".$discipline[$j]['sort']."' AND id_discipline='".$discipline[$j]['id_discipline']."' AND id_module='".$discipline[$j]['id_module']."';");
         echo "<tr align='center'><td>".($j+1)."</td>
         <td><center>".$excel[0]['semester']."</td><td>";
		 for($z=0;$z<count($predmet2);$z++)
			{	
			$excel = $test->select_excel2("SELECT DISTINCT potik,chastuna,semester FROM excel WHERE id='".$predmet2[$z]['id_excel']."';");
			echo $excel[0]['potik']." ";
			}
		 
		 echo "</td> <td>".$excel[0]['chastuna']."</td>
		 <td>".$predmet[0]['name_discipline']." - ".$predmet[0]['name_module']."</td>
         <td>".$ocinku2_b." (".round($ocinku2_b*100/$sum_stud_b,2)."%)</td>
         <td>".$ocinku2_k." (".round($ocinku2_k*100/$sum_stud_k,2)."%)</td>
         <td>".$ocinku3_b." (".round($ocinku3_b*100/$sum_stud_b,2)."%)</td>
         <td>".$ocinku3_k." (".round($ocinku3_k*100/$sum_stud_k,2)."%)</td>
         <td>".$ocinku4_b." (".round($ocinku4_b*100/$sum_stud_b,2)."%)</td>
         <td>".$ocinku4_k." (".round($ocinku4_k*100/$sum_stud_k,2)."%)</td>
         <td>".$ocinku5_b." (".round($ocinku5_b*100/$sum_stud_b,2)."%)</td>
         <td>".$ocinku5_k." (".round($ocinku5_k*100/$sum_stud_b,2)."%)</td>
         <td>".round($exam_b,2)."</td>
         <td>".round($exam_k,2)."</td>
         <td>".round($potoch_b,2)."</td>
         <td>".round($potoch_k,2)."</td>
         <td>".round($sum_stud_k+$sum_stud_b)."</td>
         </tr>";
        $_zag_2_b=$_zag_2_b+$ocinku2_b;$_zag_2_k=$_zag_2_k+$ocinku2_k;
        $_zag_3_b=$_zag_3_b+$ocinku3_b;$_zag_3_k=$_zag_3_k+$ocinku3_k;
        $_zag_4_b=$_zag_4_b+$ocinku4_b;$_zag_4_k=$_zag_4_k+$ocinku4_k;
        $_zag_5_b=$_zag_5_b+$ocinku5_b;$_zag_5_k=$_zag_5_k+$ocinku5_k;
        }
        $full_b=$_zag_2_b+$_zag_3_b+$_zag_4_b+$_zag_5_b+0.00001;
        $full_k=$_zag_2_k+$_zag_3_k+$_zag_4_k+$_zag_5_k+0.00001;
    echo "
     <tr align='center'><td colspan=5>Загальна</td>
     <td>".$_zag_2_b." (".round(($_zag_2_b/($full_b)*100),2)."%)</td>
     <td>".$_zag_2_k." (".round(($_zag_2_k/($full_k)*100),2)."%)</td>
     <td>".$_zag_3_b." (".round(($_zag_3_b/($full_b)*100),2)."%)</td>
     <td>".$_zag_3_k." (".round(($_zag_3_k/($full_k)*100),2)."%)</td>
     <td>".$_zag_4_b." (".round(($_zag_4_b/($full_b)*100),2)."%)</td>
     <td>".$_zag_4_k." (".round(($_zag_4_k/($full_k)*100),2)."%)</td>
     <td>".$_zag_5_b." (".round(($_zag_5_b/($full_b)*100),2)."%)</td>
     <td>".$_zag_5_k." (".round(($_zag_5_k/($full_k)*100),2)."%)</td>
     </tr>
    <tr><td td colspan=18> 
     <script type='text/javascript'>var zag_2_b = ".$_zag_2_b.";var zag_3_b = ".$_zag_3_b.";var zag_4_b = ".$_zag_4_b.";var zag_5_b = ".$_zag_5_b.";</script>
     <script type='text/javascript'>var zag_2_k = ".$_zag_2_k.";var zag_3_k = ".$_zag_3_k.";var zag_4_k = ".$_zag_4_k.";var zag_5_k = ".$_zag_5_k.";</script>
     <div id='chart_div2' style='width: 400px; height: 200px;'></div>
     
    </td></tr>
    
    </table></div>"; 
?>