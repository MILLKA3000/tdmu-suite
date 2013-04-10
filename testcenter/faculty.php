 <script type="text/javascript" src="datepicker/jquery.js"></script>
<?PHP 
require("auth.php");
if (($_SESSION['login_name'])&&($_SESSION['role'] =="admin"))
{
    require("header.php");
    require("menu.php");
    require("class/class_firebird.php");
    require("class/mysql-class.php");
    
    $fac = new class_ibase();
    $test = new class_mysql_base();
    
    //$department_kil = $test->select_excel_faculty();
    
    /*$department = $fac->select_faculty();
    $special = $fac->select_speciality();*/
   
   echo "<br> 
   <h3><center>Вибір груп здачі для проведення статистики </h3>
   <form action='stat.php' method='post' enctype='multipart/form-data'>
   <center>";
   
   include("navigate/navigate.php");
    
	//------------------------------------------------------------------------------------------------
	//
	//000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
	//
	//------------------------------------------------------------------------------------------------

    
	if ($_GET['special'] && $_GET['faculty'] && $_GET['lang']&&$_GET['year'])
    {   
        if ($_GET['special']){$parameter=" AND speciality_id=".$_GET['special']."";}  
        if ($_GET['lang']){$parameter=$parameter." AND lang='".$_GET['lang']."'";}
        if ($_GET['course']){$parameter=$parameter." AND semester='".$_GET['course']."'";}  
        if ($_GET['year']){$parameter=$parameter." AND type_atemp='".$_GET['year']."'";}
		$excel = $test->select_excel($_GET['faculty'],$parameter);
		
		echo "<table width='100%'id='t' style='border: 1px solid blue;margin-top:20px;background-color:white;'>";
        //<tr><td>Вибір</td><td>Коротка інформація</td><td>Коротка статистика</td><td>Модулі які здавались</td></tr>
		for($i=0;$i<count($excel);$i++)
		{
			echo "<tr><td height='100px'>";
		$department = $fac->select_faculty($excel[$i]['faculty_id']);
		$speciality = $fac->select_speciality($excel[$i]['speciality_id']);
        $type_session = $test->select_type_session("id=".$excel[$i]['type_sesion']);
		$predmet = $test->select_module("SELECT DISTINCT name_discipline,name_module,sort FROM module WHERE id_excel=".$excel[$i]['id'].";");
			echo "<table width='100%'><tr><td width='4%'><input type='checkbox' name='".$excel[$i]['id']."' value='".$excel[$i]['id']."'></td><td width='30%' style='font-size:8pt;'>";
			echo "Факультет: ".$department['DEPARTMENT']."<br>";
			echo "Спеціальність: ".$speciality['SPECIALITY']."<br>";
			echo "Мова: ".$excel[$i]['lang']."<br>";
			echo "Семестер: ".$excel[$i]['semester']."<br>";
            echo "Тип здачі: ".$type_session[0]['type']."<br>";
            if ($excel[$i]['potik']=='0'){$potik="Без потоку";}else{$potik=$excel[$i]['potik'];}
            echo "Потік: ".$potik."<br>";
            echo "Частина: ".$excel[$i]['chastuna']."<br>";
			echo "</td><td width='30%' style='font-size:8pt;'>";
		$ocinku = $test->select_table_ocinka("SELECT DISTINCT student_id FROM table_ocinka WHERE excel_id='".$excel[$i]['id']."';");	
			echo "Кількість студентів: ".count($ocinku)."<br>";
        $kontr_butjet = $fac->butjetorkontrakt($ocinku);
            echo "Кількість контрактних студентів: ".$kontr_butjet[0]."<br>";
            echo "Кількість бютжетних студентів: ".$kontr_butjet[1]."<br>";
        $ocinku_stud_null = $test->select_table_ocinka("SELECT DISTINCT student_id FROM `table_ocinka`WHERE `excel_id` ='".$excel[$i]['id']."' AND `examen` =0");
        	echo "Кількість двієшників: ".count($ocinku_stud_null)."<br>";
            echo "Кількість предметів: ".count($predmet)."<br>";
			echo "</td><td width='30%' style='font-size:8pt;'>";
            
            
			
        for($j=0;$j<count($predmet);$j++)
        {
            
            echo $predmet[$j]['sort'].":  ".$predmet[$j]['name_discipline']." <div style='padding-left:18px;'> ".$predmet[$j]['name_module']."</div>";
            
        }    
            echo "</td></tr></table>";
			echo "</td></tr>";
		}
		echo "</table>";
	}
if ($_GET['lang'])
    {    
echo "
	<input type='submit'  value='Далі'></FORM></table>
";}
}
include('footer.php');           
?>

<script type="text/javascript">
$('.year').change(function() {
                
            window.location.href='faculty.php?year='+ encodeURIComponent($('select[name=\'year\']').val());
		
    });
$('.faculti').change(function() {
                
            window.location.href='faculty.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val());
		
    });
$('.special').change(function() {
                
            window.location.href='faculty.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val());
		
    });
$('.lang').change(function() {
                
            window.location.href='faculty.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
            +'&lang='+ encodeURIComponent($('select[name=\'lang\']').val());
		
    });
$('.course').change(function() {
                
            window.location.href='faculty.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val())
            +'&lang='+ encodeURIComponent($('select[name=\'lang\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
			+'&course='+ encodeURIComponent($('select[name=\'course\']').val());
		
    });
</script>