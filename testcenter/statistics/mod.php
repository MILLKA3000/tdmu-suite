<?php
    $sum_array = array();
     for($j=1;$j<count($exel);$j++)
     {
        $parametr = $parametr." or excel_id='".$exel[$j]."'";
		$parametr2 = $parametr2." or id_excel='".$exel[$j]."'";
     }
     $discipline = $test->select_module("SELECT DISTINCT id_discipline,id_module,sort FROM module WHERE (id_excel='".$exel[0]."'".$parametr2.") ORDER BY id ASC;");
     $excel = $test->select_excel($_POST['faculti']," AND id='".$exel[0]."'");
     $sum_students =  $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE (excel_id='".$exel[0]."'".$parametr.");");
      echo"<center><b><div class='stat'><br><a class='mod' href='#'> Cтатистика по модулях </a></div></b></center>
    <div class='table_mod' style='display:none;'>
    <table width='100%' border=1 bgcolor='white' style='font-size:9pt;'><tr><td>";
	
	for ($j=0;$j<count($discipline);$j++)
        {
			$sum_stud =$test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."'  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku2 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND  examen = '0'  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku3 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND  (examen>'3.5' AND examen<'6.99')  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku4 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND  (examen>'6.99' AND examen<'9.99')  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku5 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE sort='".$discipline[$j]['sort']."' AND module_id='".$discipline[$j]['id_module']."' AND discipline_id='".$discipline[$j]['id_discipline']."' AND  (examen>'9.99' AND examen<'12.01')  AND (excel_id='".$exel[0]."'".$parametr.");");
			$predmet = $test->select_module("SELECT DISTINCT name_discipline,name_module,sort,id_excel FROM module WHERE sort='".$discipline[$j]['sort']."' AND id_discipline='".$discipline[$j]['id_discipline']."' AND id_module='".$discipline[$j]['id_module']."';");
			$_2=0;
			for($x=0;$x<count($ocinku2);$x++)
			{for($y=0;$y<count($sum_students);$y++)
					{
					if(($ocinku2[$x]['student_id']=='0')&&($ocinku2[$x]['student_id']==$ocinku3[$y]['student_id'])){$_2++;}	
					if(($ocinku2[$x]['student_id']=='0')&&($ocinku2[$x]['student_id']==$ocinku4[$y]['student_id'])){$_2++;}	
					if(($ocinku2[$x]['student_id']=='0')&&($ocinku2[$x]['student_id']==$ocinku5[$y]['student_id'])){$_2++;}
					}
			}
			
            if ($ocinku3[0]==NULL){$ocinku3='0';}else{$ocinku3=count($ocinku3);}
            if ($ocinku4[0]==NULL){$ocinku4='0';}else{$ocinku4=count($ocinku4);}
            if ($ocinku5[0]==NULL){$ocinku5='0';}else{$ocinku5=count($ocinku5);}
			if ($sum_stud[0]==NULL){$sum_stud='0.0001';}else{$sum_stud=count($sum_stud);}
			if ($ocinku2[0]==NULL){$ocinku2='0';}else{$ocinku2=count($ocinku2)-$_2;}
			echo ($j+1)."<b>: Дисципліна: ".$predmet[0]['name_discipline']." - ".$predmet[0]['name_module']."</b><br>";
			echo "Кількість пятірок - ".$ocinku5."<br>";
			echo "Кількість четвірок - ".$ocinku4."<br>";
			echo "Кількість трійок - ".$ocinku3."<br>";
			echo "Кількість двійок - <FONT color='red'>".$ocinku2."</FONT><br>";
			
			
			echo "<br><br>";
			
		}
			$oc_2 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE  examen = '0'  AND (excel_id='".$exel[0]."'".$parametr.");");
			$ocinku3 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE   (examen>'3.5' AND examen<'6.99')  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku4 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE   (examen>'6.99' AND examen<'9.99')  AND (excel_id='".$exel[0]."'".$parametr.");");
            $ocinku5 = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE   (examen>'9.99' AND examen<'12.01')  AND (excel_id='".$exel[0]."'".$parametr.");");

			if ($oc_2[0]['student_id']!=null){
			echo "<br><b>Двієшники</b><br>";
			
			for ($ii=0;$ii<count($oc_2);$ii++)
			{
				
				$student_contingent = $fac->select_idstyd_tocontingent($oc_2[$ii]['student_id']);
				$kilk = $test->select_table_ocinka("SELECT student_id FROM table_ocinka WHERE  student_id = '".$oc_2[$ii]['student_id']."'  AND examen = '0'  AND (excel_id='".$exel[0]."'".$parametr.");");
				echo ($ii+1).": ".$student_contingent['FIO']." - ".count($kilk)."<br>";
			}}
	echo"</td></tr></table>";
?>