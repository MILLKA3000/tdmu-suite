 <script type="text/javascript" src="../testcenter/datepicker/jquery.js"></script>
 
<?php  
include "class/function.php";
include "auth.php";
if ($_SESSION['name_sesion_a']=="admin"){
include "menu.php";
include "navigate.php";
require_once "class/mysql_class_tdmu.php";
require_once "class/mysql_class_tdmu_rating.php";

//Get select controls data
$base_tdmu_rating = new class_mysql_base_tdmu_rating();
$ratingindex = $base_tdmu_rating->select("SELECT DISTINCT index_id, index_text FROM tr_teacher_indices ORDER BY index_id;");
$base_tdmu = new class_mysql_base_tdmu();
$department = $base_tdmu->select("SELECT kaf_id, kaf_name FROM tbl_tech_kaf ORDER BY kaf_name;");

echo "<center><h2>Дані рейтингу викладачів</h2>";
echo "<form action='ratinginfo.php?".$_SERVER['QUERY_STRING']."' method='POST' enctype='multipart/form-data'>";
//Draw indices selector
echo "<table width=100%><tr><td bgcolor=gray valign=top><center>";
navigate('Виберіть показник:',$ratingindex,'INDEXID');
echo "</td></tr>";
//Draw departmnet selector
echo "<tr><td bgcolor=gray valign=top><center>";
navigate('Кафедра (чи всі):',$department,'DEPARTMENT');
echo "</td></tr>";
//Draw options checkboxes
echo "<tr><td bgcolor=gray valign=top><center>";
    if ($_POST['DETAIL']=="on"){
        echo"<input type='checkbox' class='DETAIL' name='DETAIL' CHECKED> "." - Детальна інформація"."<br>";
    } else {
        echo"<input type='checkbox' class='DETAIL' name='DETAIL'> "." - Детальна інформація"."<br>";
    }
    if ($_POST['SUMMARY']=="on"){
        echo"<input type='checkbox' class='SUMMARY' name='SUMMARY' CHECKED> "." - Сумарна інформація"."<br>";
    } else {
        echo"<input type='checkbox' class='SUMMARY' name='SUMMARY'> "." - Сумарна інформація"."<br>";
    }
check('детальна інформація:',$detail,'DETAIL');
check('сумарна інформація:',$summary,'SUMMARY');
echo "</td></tr></table>";
echo "<br><center><input type='submit' name='var' value='Вибрати'><br></form>";

    if (!$_POST['INDEXID']==0){
        if (!$_POST['DEPARTMENT']==0) {
        $zag_mas =$base_tdmu->select("SELECT tk.kaf_name, tn.name, tiv.index_value
                                    FROM `tr_teacher_indices_values` tiv
                                    INNER JOIN `tbl_tech_name` tn ON tn.name_id = tiv.teacher_id
                                    INNER JOIN `tbl_tech_journals` tj ON tj.name_id = tn.name_id
                                    INNER JOIN `tbl_tech_kaf` tk ON tk.kaf_id = tj.kaf_id
                                    WHERE (tiv.index_id =".$_POST['INDEXID'].") AND (tiv.index_value >0) AND (tk.kaf_id=".$_POST['DEPARTMENT'].") order by tk.kaf_name, tn.name");	
        } else {
            $zag_mas =$base_tdmu->select("SELECT tk.kaf_name, tn.name, tiv.index_value
                                        FROM `tr_teacher_indices_values` tiv
                                        INNER JOIN `tbl_tech_name` tn ON tn.name_id = tiv.teacher_id
                                        INNER JOIN `tbl_tech_journals` tj ON tj.name_id = tn.name_id
                                        INNER JOIN `tbl_tech_kaf` tk ON tk.kaf_id = tj.kaf_id
                                        WHERE (tiv.index_id =".$_POST['INDEXID'].") AND (tiv.index_value >0) order by tk.kaf_name, tn.name");    
        }
        echo" <table bgcolor='white' border=1 width = 100% class='ser'><tr><td colspan=3><center><b>".$ratingindex[$_POST['INDEXID']][1]."</b></td></tr>
    <tr><td><center><b>Назва кафедри</td><td><center><b>П.І.Б. викладача</td><td><center><b>Значення параметру</td></tr>";
        for ($i=0;$i<count($zag_mas);$i++)
        {
        echo "<tr>";
            for($j=0;$j<count($zag_mas[0]);$j++)
            {
                if ($j<2) {
                    $cell_alignment = "<left>";
                } else {
                    $cell_alignment = "<center>";
                }
                echo "<td>".$cell_alignment.$zag_mas[$i][$j]."</td>";
            }
        echo "</tr>";
        }
        echo "</table>";
    }

}else {header("Location: index.php");}
?> 