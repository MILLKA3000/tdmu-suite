<link rel='stylesheet' href='datepicker/datepicker.css' type='text/css' />

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
    $year = $test->select_year("SELECT DISTINCT date,name,id FROM yearplan WHERE 1 ORDER BY id DESC;");

    
    echo " <br><center><h3>Завантажити файл з EXCEL </h3><br></center>
    <form action='up_stat.php' method='post' enctype='multipart/form-data'>
    	
        
    <div class='kvadrant'><br>
	Короткий опис
	<input  name='title' value='' />
	<br><br>
	</div>  

    <div class='kvadrant'><br>
	Тип здачі 
	<select name='year'>
    ";
    for ($i=0;$i<count($year);$i++)
    {
		echo "<option value='".$year[$i]['id']."'>".$year[$i]['date']."/".$year[$i]['name']."</option>";
	}
    echo "
	</select>
	<br><br>
	</div>

    <div class='kvadrant'><br>
	Мова здачі 
	<select name='lang'>
    <option value='UA'>Українська</option>
    <option value='ENG'>Іноземна</option>
	</select>
	<br><br>
	</div>
      
    <div class='kvadrant'><br>    
	Дата здачі
	<input  id='inputDate4' name='date' value='".Date("Y-m-d")."' />
	<br><br>
	</div>
    
	<div class='kvadrant'><br>
	Тип здачі 
	<select name='zdacha'>
    ";
    for ($i=0;$i<count($type_session);$i++)
    {
		echo "<option value='".$type_session[$i]['id']."'>".$type_session[$i]['type']."</option>";
	}
    echo "
	</select>
	<br><br>
	</div>
	
	<div class='kvadrant'><br>
	Потік 
	<select name='potik'>
		<option value='0' name=''>Без потоку</option>
		<option value='1' name=''>І потік</option>
		<option value='2' name=''>ІІ потік</option>
	</select>
	<br><br>
	</div>
	
	<div class='kvadrant'><br>
	Частина
	<select name='chastuna'>
		<option value='1' name=''>І частина</option>
		<option value='2' name=''>ІІ частина</option>
	</select>
	<br><br>
	</div>
	<div class='kvadrant'><br>
	Виберіть файл 
      <input type='file' name='filename'  value='Огляд'>
      <br><br></div><br><br>
      <input type='submit' value='Експортувати дані'><br></form>";
      
    if (isset($_FILES["filename"]["tmp_name"])) {
    if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
     {
		
		$temp_file = date("d-m-i-s");
         move_uploaded_file($_FILES["filename"]["tmp_name"], "sheets/".$temp_file.$_FILES["filename"]["name"]);
         include_once("Class/class reader.php");
         $data = new XLSToDB($temp_file.$_FILES["filename"]["name"], 'CP1251');
         $fileXLS=$temp_file.$_FILES["filename"]["name"];
         $links="sheets/".$temp_file.$_FILES["filename"]["name"];
         
         
         $ocinku_styd=$data->get($fileXLS,0,10);
		 $zvjaz_styd=$data->get($fileXLS,1,3);
		 $module_styd=$data->get($fileXLS,2,5);
		 $potochna_styd=$data->get($fileXLS,3,12);
		 $ostatochna_styd=$data->get($fileXLS,4,12);
         $kilk=0;$g=0;$l1=0;
	//Кількість оцінок
         for($i=0;$i<10;$i++)
         {
            if ($ocinku_styd[0][$i]!=NULL)$kilk++;
            
         }
         $kilk=$kilk;
		 
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
    
          if ($ocinku_styd[$i][0]==2)
           {
           $ocinku[$g][1]=$j-1+$kilk-2;
           }

          if ($ocinku_styd[$i][0]==3)
             {
                $ocinku[$g][1]=$j-1+$kilk*2-4;
             }
            $ocinku[$g][2]=$ocinku_styd[$i][$j+1];
            $ocinku[$g][0]=$ocinku_styd[$i][2];
            $g++;
            }}}

  
  //Звязок оцінок з розкодуванням    

$student_contingent = $ibase->select_idstyd_tocontingent($zvjaz_styd[0][1]);
$last_id_excel = $test->insert_excel($student_contingent['SEMESTER'],$student_contingent['DEPARTMENTID'],$student_contingent['SPECIALITYID'],$_POST['zdacha'],$_POST['potik'],$_POST['chastuna'],$_POST['date'],$_POST['lang'],count($module_styd)-1,$_POST['year']);
$test->insert_log_excel($_POST['title'],$_POST['date'],$links,'MILKA',$last_id_excel);
 for ($m=0;$m<count($module_styd)-1;$m++)
            {
			if($module_styd[$m][1]!=null)
				{
				$test->insert_module($last_id_excel,$module_styd[$m][3],$module_styd[$m][4],$module_styd[$m][2],$module_styd[$m][1],$module_styd[$m][0]);
				}
            }
echo "<table border='1' id='t'><tr><td>Прізвище</td><td>Дисципліни</td><td>За тест</td><td>Поточна</td><td>Остаточна</td></tr>";
        for ($j=0;$j<count($zvjaz_styd);$j++)
            {
             $m=0;
                for ($i=0;$i<(count($ocinku));$i++)
                {
                    if (($zvjaz_styd[$j][2]==$ocinku[$i][0]))
						{
						for ($x=0;$x<count($potochna_styd);$x++)
							{
							if ($zvjaz_styd[$j][1]==$potochna_styd[$x][1])
								{
									for ($o=0;$o<count($ostatochna_styd);$o++)
									{
										if (($zvjaz_styd[$j][1]==$ostatochna_styd[$o][1])&&($ostatochna_styd[$o][$m+2]!=''))
										{
										$kil++;
                                        $student_contingent_form = $ibase->select_idstyd_tocontingent($zvjaz_styd[$j][1]);
                                        $test->insert_ocinka(pereved_pot($potochna_styd[$x][$m+2]),$ocinku[$i][2],pereved_ostatochna($ocinku[$i][2],pereved_pot($potochna_styd[$x][$m+2])),$zvjaz_styd[$j][1],$module_styd[$m][3],$module_styd[$m][4],$last_id_excel,$module_styd[$m][0],$student_contingent_form['EDUBASISID'],$student_contingent_form['GROUPNUM']);
                                        
										echo "
											<tr>
											<td width='15%' rowspan='".$kilkist."'>".$zvjaz_styd[$j][0]."</td>
											<td width='20%'>".$module_styd[$m][1]." - ".$module_styd[$m][2]."</td>
											<td width='5%'>".$ocinku[$i][2]."</td>
											<td width='5%'>".pereved_pot($potochna_styd[$x][$m+2])."</td>
											<td width='5%'>".pereved_ostatochna($ocinku[$i][2],pereved_pot($potochna_styd[$x][$m+2]))."</td>
											</tr>";
											break;
										}
									
									}
								$m++;
								}
								
							}
						}
                } 
                
            }    
		
		
		

     }}
      
}
echo "</td></tr></table>";
include('footer.php');           
?>
