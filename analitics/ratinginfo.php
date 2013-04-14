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
//check('детальна інформація:',$detail,'DETAIL');
//check('сумарна інформація:',$summary,'SUMMARY');
echo "</td></tr></table>";
echo "<br><center><input type='submit' name='var' value='Вибрати'><br></form>";

    if (!$_POST['INDEXID']==0){
        //Processing will start only if someone parameter is selected
        if (!$_POST['DETAIL']=="on") {
            //Processing "show detail info" checkbox option
            if (!$_POST['DEPARTMENT']==0) {
                //Get detail data for a selected department
                $detail_mas =$base_tdmu->select("SELECT tk.kaf_name, tn.name, tiv.index_value
                                        FROM `tr_teacher_indices_values` tiv
                                        INNER JOIN `tbl_tech_name` tn ON tn.name_id = tiv.teacher_id
                                        INNER JOIN `tbl_tech_journals` tj ON tj.name_id = tn.name_id
                                        INNER JOIN `tbl_tech_kaf` tk ON tk.kaf_id = tj.kaf_id
                                        WHERE (tiv.index_id =".$_POST['INDEXID'].") AND (tiv.index_value >0) AND (tk.kaf_id=".$_POST['DEPARTMENT'].") order by tk.kaf_name, tn.name");
            } else {
                //Get detail data for all departments
                $detail_mas =$base_tdmu->select("SELECT tk.kaf_name, tn.name, tiv.index_value
                                                FROM `tr_teacher_indices_values` tiv
                                                INNER JOIN `tbl_tech_name` tn ON tn.name_id = tiv.teacher_id
                                                INNER JOIN `tbl_tech_journals` tj ON tj.name_id = tn.name_id
                                                INNER JOIN `tbl_tech_kaf` tk ON tk.kaf_id = tj.kaf_id
                                                WHERE (tiv.index_id =".$_POST['INDEXID'].") AND (tiv.index_value >0) order by tk.kaf_name, tn.name");            
            }
            //Display detail data table
            echo "<center><h3>Детальна інформація по кафедрі(ах)</h3>";            
            echo" <table bgcolor='white' border=1 width = 100% class='ser'><tr><td colspan=3><center><b>".$ratingindex[$_POST['INDEXID']][1]."</b></td></tr><tr><td><center><b>Назва кафедри</td><td><center><b>П.І.Б. викладача</b></td><td><center><b>Значення параметру</b></td></tr>";
            for ($i=0;$i<count($detail_mas);$i++)
            {
                echo "<tr>";
                for($j=0;$j<count($detail_mas[0]);$j++)
                {
                    if ($j<2) {
                        $cell_alignment = "<left>";
                    } else {
                        $cell_alignment = "<center>";
                    }
                    echo "<td>".$cell_alignment.$detail_mas[$i][$j]."</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } 
        if (!$_POST['SUMMARY']=="on") {
            //Processing "show summary info" checkbox option
            if (!$_POST['DEPARTMENT']==0) {
                //Get summary data for a selected department         
                $summary_mas =$base_tdmu->select("SELECT tk.kaf_name, SUM(tiv.index_value)
                                        FROM `tr_teacher_indices_values` tiv
                                        INNER JOIN `tbl_tech_name` tn ON tn.name_id = tiv.teacher_id
                                        INNER JOIN `tbl_tech_journals` tj ON tj.name_id = tn.name_id
                                        INNER JOIN `tbl_tech_kaf` tk ON tk.kaf_id = tj.kaf_id
                                        WHERE (tiv.index_id =".$_POST['INDEXID'].") AND (tiv.index_value >0) AND (tk.kaf_id=".$_POST['DEPARTMENT'].") order by tk.kaf_name");
            } else {
                //Get summary data for all departments            
                $summary_mas =$base_tdmu->select("SELECT tk.kaf_name, SUM(tiv.index_value)
                                                FROM `tr_teacher_indices_values` tiv
                                                INNER JOIN `tbl_tech_name` tn ON tn.name_id = tiv.teacher_id
                                                INNER JOIN `tbl_tech_journals` tj ON tj.name_id = tn.name_id
                                                INNER JOIN `tbl_tech_kaf` tk ON tk.kaf_id = tj.kaf_id
                                                WHERE (tiv.index_id =".$_POST['INDEXID'].") AND (tiv.index_value >0) order by tk.kaf_name, tn.name");         
            }
            //Display summary data table
            echo "<center><h3>Сумарна інформація по кафедрі(ах)</h3>";            
            echo" <table bgcolor='white' border=1 width = 100% class='ser'><tr><td colspan=2><center><b>".$ratingindex[$_POST['INDEXID']][1]."</b></td></tr><tr><td><center><b>Назва кафедри</b></td><td><center><b>Сумарно по кафедрі</b></td></tr>";
            $grand_total = 0;
            for ($i=0;$i<count($summary_mas);$i++)
            {
                echo "<tr>";
                for($j=0;$j<count($summary_mas[0]);$j++)
                {
                    if ($j<1) {
                        $cell_alignment = "<left>";
                    } else {
                        $cell_alignment = "<center>";
                    }
                    echo "<td>".$cell_alignment.$summary_mas[$i][$j]."</td>";
                    $grand_total = $grand_total + $summary_mas[$i][$j];//Calculate total for whole university
                }
                echo "</tr>";
            }
            echo "</table>";
            //Display total for whole university data table
            if ($_POST['DEPARTMENT']==0) {
                echo "<center><h3>Сумарна інформація по університету</h3>";            
                echo" <table bgcolor='white' border=1 width = 100% class='ser'><tr><td><left><b>".$ratingindex[$_POST['INDEXID']][1]."</b></td></tr>";
                echo"<tr><td><center><b>".$grand_total."</b></td></tr></table>";
            }
        }
    }
}else {header("Location: index.php");}
?> 