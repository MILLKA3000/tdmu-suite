

<?PHP 
require("auth.php");
echo"<script type='text/javascript' src='datepicker/jquery.tcollapse.js'></script>";
if (($_SESSION['login_name'])&&($_SESSION['role'] =="admin"))
{
    require("header.php");
    require("menu.php");
    require("class/class_firebird.php");
    require("class/mysql-class.php");
    
    $fac = new class_ibase();
    $test = new class_mysql_base();
    
    echo "<br><CENTER><h3>Архів здач студентів</h3></CENTER>";
    echo "<form action='students.php' method='post' enctype='multipart/form-data'>";
    
    include("navigate/navigate.php");
        if ($_GET['special'] && $_GET['faculty'] && $_GET['lang'] && $_GET['course']&&$_GET['year'])
    {   
        if ($_GET['special']){$parameter=" AND excel.speciality_id=".$_GET['special']."";}  
        if ($_GET['lang']){$parameter=$parameter." AND excel.lang='".$_GET['lang']."'";}
        if ($_GET['course']){$parameter=$parameter." AND excel.semester='".$_GET['course']."'";}  
        if ($_GET['year']){$parameter=$parameter." AND excel.type_atemp='".$_GET['year']."'";} 
		$excel = $test->select_excel($_GET['faculty'],$parameter);
		
		 for($j=1;$j<count($excel);$j++)
     {
        $parameter_excel = $parameter_excel." or `excel_id`='".$excel[$j]['id']."'";
     }
       $groups = $test->select_table_ocinka("SELECT DISTINCT `group` FROM `table_ocinka` WHERE (`excel_id`='".$excel[0]['id']."' ".$parameter_excel.");");
       echo "<tr><td> Виберіть групу </td><td style='float:right;'><select name='group' class='group'>
    <option value='' selected='selected'>------Пусто-----</option>
    ";
    for ($i=0;$i<count($groups);$i++)
    {
       if ($_GET['group']==$groups[$i]['group']) 
       {
          echo "<option value='".$groups[$i]['group']."' selected='selected'>".$groups[$i]['group']."</option>";
       }
       else
       {
          echo "<option value='".$groups[$i]['group']."'>".$groups[$i]['group']."</option>";
       }
    }   
    echo "
	</select> </td></tr>"; 
    }
    
    if ($_GET['special'] && $_GET['faculty'] && $_GET['lang'] && $_GET['course'] && $_GET['group'])
	{
		$student = $test->select_table_ocinka("SELECT DISTINCT table_ocinka.student_id FROM table_ocinka,excel WHERE excel.semester='".$_GET['course']."' AND table_ocinka.group='".$_GET['group']."' AND excel.speciality_id=".$_GET['special']." AND excel.id=table_ocinka.excel_id;");
			
		echo "<table width='70%' id='t'>";	
		for ($i=0;$i<count($student);$i++)
		{
			$student_contingent = $fac->select_idstyd_tocontingent($student[$i]['student_id']);
			echo "<tr><td style='border:solid 1px black;'><a style='float:right;color:black;display:block;width:100%;' href='students.php?student_id=".$student[$i]['student_id']."&faculty=".$_GET['faculty']."&year=".$_GET['year']."&special=".$_GET['special']."&lang=".$_GET['lang']."&course=".$_GET['course']."&group=".$_GET['group']."'>".$student_contingent['FIO']."</a></td></tr>";
		}		
		echo "</table>";
	}

    if ($_GET['student_id']){
	$student_contingent = $fac->select_idstyd_tocontingent($_GET['student_id']);
	echo "<br><b>Успішність студента<br><CENTER><h2>".$student_contingent['FIO']."</h2></CENTER></b>";
		
    $get_ocinku_excel = $test->select_table_ocinka("SELECT DISTINCT excel_id FROM `table_ocinka`WHERE `student_id` ='".$_GET['student_id']."';");
    echo "<table width='100%' bgcolor='#c5d9e5' font-color='white' id='table0' style='border: 1px solid blue;' >";
     for ($i=0;$i<count($get_ocinku_excel);$i++)
     {    
        $excel_stud = $test->select_excel2("SELECT * FROM excel WHERE id='".$get_ocinku_excel[$i]['excel_id']."';");
        $type_session = $test->select_type_session("id=".$excel_stud[0]['type_sesion']);
        echo "<tr><td><b>Тип здачі ".$type_session[0]['type']."</td><td><b>Семестер ".$excel_stud[0]['semester']."</td><td><b> Частина ".$excel_stud[0]['chastuna']."</td><td><b> Дата ".$excel_stud[0]['date']."</td></tr>";
        $predmet = $test->select_module("SELECT * FROM module WHERE id_excel=".$excel_stud[0]['id'].";");
		
        echo "<tbody><tr><td colspan='4'>
        <table width='100%' bgcolor='white'><tr><td>"; 
        for($j=0;$j<count($predmet);$j++)
        {	
			
            $ocinku = $test->select_table_ocinka("SELECT DISTINCT potochna,examen,ostatochna,sort FROM table_ocinka WHERE student_id='".$_GET['student_id']."' AND excel_id='".$excel_stud[0]['id']."' AND discipline_id='".$predmet[$j]['id_discipline']."' AND module_id='".$predmet[$j]['id_module']."' AND sort='".$predmet[$j]['sort']."';");	
			if ($ocinku[0]['examen'] || $ocinku[0]['examen']=='0'){
			 if ($ocinku[0]['examen']=='0')
             {
                echo "<div style='border-bottom: solid 1px gray;background-color:#feddbf;'>".$ocinku[0]['sort'].":  ".$predmet[$j]['name_discipline']." <div style='padding-left:18px;'> ".$predmet[$j]['name_module']."  <b style='float:right;'>Поточна : ".$ocinku[0]['potochna']." Екзамен : ".$ocinku[0]['examen']." Підсумкова : ".$ocinku[0]['ostatochna']." </b></div></div>";
             }
             else
             {
                echo "<div style='border-bottom: solid 1px gray;background-color:#bffec4;'>".$ocinku[0]['sort'].":  ".$predmet[$j]['name_discipline']." <div style='padding-left:18px;'> ".$predmet[$j]['name_module']."  <b style='float:right;'>Поточна : ".$ocinku[0]['potochna']." Екзамен : ".$ocinku[0]['examen']." Підсумкова : ".$ocinku[0]['ostatochna']." </b></div></div>";
             }
            
            }
        } 
        
        echo "</td></tr></table></td></tr></tbody>";
     }

    echo "</table><div style='height:300px;'></div>";

}
}
include('footer.php');           
?>
		 <script type="text/javascript">
            $().ready(
            function() {
                
                $('#table0').tCollapse();
                $('.uncollapse').click(
            function(){
                    $('#table0').removeCollapse();
                    
                    return false;
                }
            );
                $('.collapse').click(
                function(){
                    $('#table0').tCollapse();
                    
                    return false;
                }
            );
            }
        );
$('.year').change(function() {
                
            window.location.href='students.php?year='+ encodeURIComponent($('select[name=\'year\']').val());
		
    });
$('.faculti').change(function() {
                
            window.location.href='students.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val());
		
    });
$('.special').change(function() {
                
            window.location.href='students.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val());
		
    });
$('.lang').change(function() {
                
            window.location.href='students.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
            +'&lang='+ encodeURIComponent($('select[name=\'lang\']').val());
		
    });
$('.course').change(function() {
                
            window.location.href='students.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val())
            +'&lang='+ encodeURIComponent($('select[name=\'lang\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
			+'&course='+ encodeURIComponent($('select[name=\'course\']').val());
		
    });
$('.group').change(function() {
                
            window.location.href='students.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val())
            +'&lang='+ encodeURIComponent($('select[name=\'lang\']').val())
			+'&course='+ encodeURIComponent($('select[name=\'course\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
            +'&group='+ encodeURIComponent($('select[name=\'group\']').val());
		
    });
        </script>