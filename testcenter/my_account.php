
<?PHP 
require("auth.php");
echo"<script type='text/javascript' src='datepicker/jquery.tcollapse.js'></script>";
if (($_SESSION['login_name'])&&($_SESSION['role'] =="student"))
{
    require("header.php");
    require("menu_stud.php");
    require("class/class_firebird.php");
    require("class/mysql-class.php");
    
    $fac = new class_ibase();
    $test = new class_mysql_base();
    echo "<CENTER><h3>Архів ваших здач</h3></CENTER>";
    $get_ocinku_excel = $test->select_table_ocinka("SELECT DISTINCT excel_id FROM `table_ocinka`WHERE `student_id` ='".$_SESSION['studentid']."';");
    echo "<table width='100%' bgcolor='gray' font-color='white' id='table0'>";
     for ($i=0;$i<count($get_ocinku_excel);$i++)
     {    
        $excel = $test->select_excel2("SELECT * FROM excel WHERE id='".$get_ocinku_excel[$i]['excel_id']."';");
        $type_session = $test->select_type_session("id=".$excel[0]['type_sesion']);
        echo "<tr><td><b>Тип здачі ".$type_session[0]['type']."</td><td><b>Семестер ".$excel[0]['semester']."</td><td><b> Частина ".$excel[0]['chastuna']."</td><td><b> Дата ".$excel[0]['date']."</td></tr>";
        $predmet = $test->select_module("SELECT * FROM module WHERE id_excel=".$excel[0]['id'].";");
		
        echo "<tbody><tr><td colspan='4'>
        <table width='100%' bgcolor='white'><tr><td>"; 
        for($j=0;$j<count($predmet);$j++)
        {
            $ocinku = $test->select_table_ocinka("SELECT DISTINCT potochna,examen,ostatochna FROM table_ocinka WHERE student_id='".$_SESSION['studentid']."' AND excel_id='".$excel[0]['id']."' AND discipline_id='".$predmet[$j]['id_discipline']."' AND module_id='".$predmet[$j]['id_module']."' AND sort='".$predmet[$j]['sort']."';");	
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
      


         

     
    echo "</table>";

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
        </script>