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
if ($_POST['zdacha'])
{
    $test->update_excel("UPDATE excel SET type_atemp = '".$_POST['year']."',date = '".$_POST['date']."',lang = '".$_POST['lang']."'
    ,chastuna = '".$_POST['chastuna']."',potik = '".$_POST['potik']."',type_sesion = '".$_POST['zdacha']."' WHERE id = '".$_GET['id']."'");
    
}  
    //$department_kil = $test->select_excel_faculty();
    
    /*$department = $fac->select_faculty();
    $special = $fac->select_speciality();*/
   
   echo "<br> 
   <h3><center>Редагування бази Excel </h3>";
    if ($_GET['id_excel'])
 {
    $log = $test->select_log("SELECT * FROM log_excel WHERE id_export_table='".$_GET['id_excel']."'");
    unlink($log[0]['file_path']);
    $test->delete_log_excel($_GET['id_excel']);
    
 }   
 
   include("navigate/navigate.php");
   

if ($_GET['faculty']!='' && $_GET['year']!='')
    {   
        if ($_GET['special']){$parameter=" AND speciality_id=".$_GET['special']."";}  
        if ($_GET['lang']){$parameter=$parameter." AND lang='".$_GET['lang']."'";}
        if ($_GET['course']){$parameter=$parameter." AND semester='".$_GET['course']."'";}  
        if ($_GET['year']){$parameter=$parameter." AND type_atemp='".$_GET['year']."'";}
		$excel = $test->select_excel($_GET['faculty'],$parameter);
        
        
    if ($excel[0]['id']!=NULL){
    	echo "<table width='100%'id='t' style='border: 1px solid blue;margin-top:20px;background-color:white;'>";
        for($i=0;$i<count($excel);$i++)
		{
        echo "<tr><td height='50px'>";
        $log = $test->select_log("SELECT * FROM log_excel WHERE id_export_table='".$excel[$i]['id']."'");
		$department = $fac->select_faculty($excel[$i]['faculty_id']);
		$speciality = $fac->select_speciality($excel[$i]['speciality_id']);
        $type_session = $test->select_type_session("id=".$excel[$i]['type_sesion']);
		$predmet = $test->select_module("SELECT DISTINCT name_discipline,name_module,sort FROM module WHERE id_excel=".$excel[$i]['id'].";");
			echo "<table width='100%'><tr><td width='30%' style='font-size:8pt;'>";
			echo "Факультет: ".$department['DEPARTMENT']."<br>";
			echo "Спеціальність: ".$speciality['SPECIALITY']."<br>";
			echo "Мова: ".$excel[$i]['lang']."<br>";
			echo "Семестер: ".$excel[$i]['semester']."</td><td width='30%' style='font-size:8pt;'>";
            echo "<b>Тип здачі: ".$type_session[0]['type']."<br>";
            if ($excel[$i]['potik']=='0'){$potik="Без потоку";}else{$potik=$excel[$i]['potik'];}
            echo "Потік: ".$potik."<br>";
            echo "Частина: ".$excel[$i]['chastuna']."</b><br>";
            echo "Кількість предметів: ".count($predmet)."";
			echo "</td><td width='10%' style='font-size:8pt;'><b><a style='color:green;border: 2px solid green;padding:10px;' href='".$log[0]['file_path']."'>Скачати</a>";
            echo "</td><td width='10%' style='font-size:8pt;'><b><a style='color:blue;border: 2px solid blue;padding:10px;' href='reg_info_excel.php?id=".$excel[$i]['id']."&faculty=".$_GET['faculty']."&special=".$_GET['special']."&lang=".$_GET['lang']."&year=".$_GET['year']."&course=".$_GET['course']."'>Редагувати</a>";
            echo "</td><td width='10%' style='font-size:8pt;'><b><a style='color:red;border: 2px solid red;padding:10px;' href='reg_graf.php?id_excel=".$excel[$i]['id']."'>Видалити</a>";
            
            echo "</td></tr></table>";
			echo "</td></tr>";
        }}
        
    }   
   
   
   
   
   

}
include('footer.php');           
?>

<script type="text/javascript">
$('.year').change(function() {
                
            window.location.href='reg_graf.php?year='+ encodeURIComponent($('select[name=\'year\']').val());
		
    });
$('.faculti').change(function() {
                
            window.location.href='reg_graf.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val());
		
    });
$('.special').change(function() {
                
            window.location.href='reg_graf.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val());
		
    });
$('.lang').change(function() {
                
            window.location.href='reg_graf.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
            +'&lang='+ encodeURIComponent($('select[name=\'lang\']').val());
		
    });
$('.course').change(function() {
                
            window.location.href='reg_graf.php?faculty='+ encodeURIComponent($('select[name=\'faculti\']').val())
            +'&special='+ encodeURIComponent($('select[name=\'special\']').val())
            +'&lang='+ encodeURIComponent($('select[name=\'lang\']').val())
            +'&year='+ encodeURIComponent($('select[name=\'year\']').val())
			+'&course='+ encodeURIComponent($('select[name=\'course\']').val());
		
    });
</script>