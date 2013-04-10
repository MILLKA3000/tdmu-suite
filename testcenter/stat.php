 <script type="text/javascript" src="datepicker/jquery.js"></script> 
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript" src="datepicker/graf.js"></script>
<?php
require("auth.php");
if (($_SESSION['login_name'])&&($_SESSION['role'] =="admin"))
{
    require("header.php");
    require("menu.php");
    require("class/class_firebird.php");
    require("class/mysql-class.php");
    $fac = new class_ibase();
    $test = new class_mysql_base();
  	$excel_kil = $test->select_excel2("SELECT id FROM excel WHERE 1;"); 
    $kil = array();
    for($i=0;$i<count($excel_kil);$i++){$kil[$i]=$excel_kil[$i]['id'];}
      $max = max($kil);
  
    $exel = array();
    $j=0;
    for ($i=0;$i<100;$i++)
    {
        if ($_POST[$i]>0) {$exel[$j]=$_POST[$i];$j++;}
    }
    echo "<CENTER><h3>Виберіть тип статистики</h3></CENTER>";
    //--------------------------------------------------------------------------------------------------------------------------------
    //                                 Загальна статистика
    //--------------------------------------------------------------------------------------------------------------------------------
   include("statistics/zag.php");
     //--------------------------------------------------------------------------------------------------------------------------------
     //                                 Cтатистика по бюджет контракт
     //--------------------------------------------------------------------------------------------------------------------------------
   include("statistics/zag2.php");
   include("statistics/mod.php");
}
?>

<script type="text/javascript">

    $('.zag').click(function() {
      if ( $(".table_zag").is(":hidden")) 
			{			$(".table_zag").slideDown(800);			

            }		else 			{			$(".table_zag").slideUp(800);			}		
    });
    $('.zag2').click(function() {
      if ( $(".table_zag2").is(":hidden")) 
			{			$(".table_zag2").slideDown(800);			}		else 			{			$(".table_zag2").slideUp(800);			}		
    });
	 $('.mod').click(function() {
      if ( $(".table_mod").is(":hidden")) 
			{			$(".table_mod").slideDown(800);			}		else 			{			$(".table_mod").slideUp(800);			}		
    });
$(".table_zag").hide();
$(".table_zag2").hide();
$(".table_mod").hide();
</script>

    


