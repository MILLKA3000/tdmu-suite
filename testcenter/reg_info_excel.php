<link rel="stylesheet" href="datepicker/datepicker.css" type="text/css" /> 
<?PHP 
require("auth.php");
echo "
<script type='text/javascript' src='datepicker/jquery.js'></script>
<script type='text/javascript' src='datepicker/date.js'></script>
<script type='text/javascript' src='datepicker/jquery.datePicker-2.1.2.js'></script>
 
<script type='text/javascript'>
$(function()
{
$('#inputDate4').datePicker({
createButton:false,
clickInput:true,
endDate: (new Date()).addDays(365).asString()
});
});
</script>";
if (($_SESSION['login_name'])&&($_SESSION['role'] =="admin"))
{
    require("header.php");
    require("menu.php");
    require("class/potochna.php");
    require("class/mysql-class.php");
    require("class/class_firebird.php");
    $test = new class_mysql_base();
    $ibase = new class_ibase();
    $type_session =$test->select_type_session("1");
    
 
   
      if ($_GET['id'])
 {
    $excel_info = $test->select_excel2("SELECT * FROM excel WHERE id='".(int)$_GET['id']."';");

    $year = $test->select_year("SELECT DISTINCT date,name,id FROM yearplan WHERE 1 ORDER BY id DESC;");

    
    echo " <center><h3>Редагування файла EXCEL </h3><br></center>
    <form action='reg_graf.php?id=".$_GET['id']."&faculty=".$_GET['faculty']."&special=".$_GET['special']."&lang=".$_GET['lang']."&year=".$_GET['year']."&course=".$_GET['course']."' method='post' enctype='multipart/form-data'>
    	
        
    <div class='kvadrant'><br>
	Короткий опис
	<input  name='title' value='".$excel_info[0]['title']."' />
	<br><br>
	</div>  

    <div class='kvadrant'><br>
	Тип здачі 
	<select name='year'>
    ";
    for ($i=0;$i<count($year);$i++)
    {
        if($year[$i]['id']==$excel_info[0]['type_atemp'])
        {
            echo "<option value='".$year[$i]['id']."' selected='SELECTED'>".$year[$i]['date']."/".$year[$i]['name']."</option>";
        }
        else
        {
            echo "<option value='".$year[$i]['id']."'>".$year[$i]['date']."/".$year[$i]['name']."</option>";    
        }
	}
    echo "
	</select>
	<br><br>
	</div>

    <div class='kvadrant'><br>
	Мова здачі 
	<select name='lang'>";
    if ($excel_info[0]['lang']=='UA')
    {
        echo "<option value='UA' selected='SELECTED'>Українська</option>
              <option value='ENG'>Іноземна</option>
        ";    
    }else
    {
        echo "<option value='UA'>Українська</option>
              <option value='ENG' selected='SELECTED'>Іноземна</option>
        ";    
    }
    
    
    
	echo"</select>
	<br><br>
	</div>
      
    <div class='kvadrant'><br>    
	Дата здачі
	<input  id='inputDate4' name='date' value='".$excel_info[0]['date']."' />
	<br><br>
	</div>
    
	<div class='kvadrant'><br>
	Тип здачі 
	<select name='zdacha'>
    ";
    for ($i=0;$i<count($type_session);$i++)
    {
         if($type_session[$i]['id']==$excel_info[0]['type_sesion'])
        {
            echo "<option value='".$type_session[$i]['id']."' selected='SELECTED'>".$type_session[$i]['type']."</option>";
        }    
        else
        {
            echo "<option value='".$type_session[$i]['id']."'>".$type_session[$i]['type']."</option>";    
        }
	}
    echo "
	</select>
	<br><br>
	</div>
	
	<div class='kvadrant'><br>
	Потік 
	<select name='potik'>";
        if ($excel_info[0]['potik']=='0')
    {
        echo "<option value='0' selected='SELECTED'>Без потоку</option>
		      <option value='1' >І потік</option>
		      <option value='2' >ІІ потік</option>
        ";    
    } else  if ($excel_info[0]['potik']=='1')
    {
        echo "<option value='0'>Без потоку</option>
		      <option value='1' selected='SELECTED'>І потік</option>
		      <option value='2' >ІІ потік</option>
        ";    
    } else  if ($excel_info[0]['potik']=='2')
    {
        echo "<option value='0'>Без потоку</option>
		      <option value='1'>І потік</option>
		      <option value='2' selected='SELECTED' >ІІ потік</option>
        ";    
    }
	echo"</select>
	<br><br>
	</div>
	
	<div class='kvadrant'><br>
	Частина
	<select name='chastuna'>";
    if ($excel_info[0]['chastuna']=='1')
    {
        echo "  <option value='1' selected='SELECTED'>І частина</option>
	           	<option value='2' >ІІ частина</option>
        "; 
    }else if ($excel_info[0]['chastuna']=='2')
    {
        echo "  <option value='1' >І частина</option>
	           	<option value='2' selected='SELECTED'>ІІ частина</option>
        "; 
    }
	echo "</select>
	<br><br>
	</div>
	<br><br>
      <input type='submit' value='Зберегти'><br></form>";
   }  
   if ($_POST['zdacha'])
   {
    $test->update_excel("UPDATE excel SET type_atemp = '".$_POST['year']."',date = '".$_POST['date']."',lang = '".$_POST['lang']."'
    ,chastuna = '".$_POST['chastuna']."',potik = '".$_POST['potik']."',type_sesion = '".$_POST['zdacha']."' WHERE id = '".$_GET['id']."'");
   }    
}
echo "</td></tr></table>";
include('footer.php');           
?>
