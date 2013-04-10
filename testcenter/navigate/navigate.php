<?php
    $year = $test->select_year("SELECT DISTINCT date,name,id FROM `yearplan` WHERE 1 ORDER BY id DESC;");
  echo "  <center>
   <table bgcolor='#c5d9e5' valing='top' style='margin-top:10px;width:600px;border: 1px solid blue;'>
   <tr><td>
    Виберіть рік здачі</td><td style='float:right;'>
   <select class='year' name='year'>
   <option value='' selected='selected'>------Пусто-----</option>
    ";
    for ($i=0;$i<count($year);$i++)
    {
        if ($_GET['year']==$year[$i]['id'])
                {   
                    echo "<option value='".$year[$i]['id']."' selected='selected'>".$year[$i]['date']."/".$year[$i]['name']."</option>";
                }
        else    {
		            echo "<option value='".$year[$i]['id']."'>".$year[$i]['date']."/".$year[$i]['name']."</option>";
                }
	}
        echo "
	</select></td></tr>";
        if ($_GET['year']!=null)
    {
    $department_kil = $test->select_excel2("SELECT DISTINCT faculty_id FROM excel WHERE type_atemp='".$_GET['year']."'");

    
   echo"<tr><td>Виберіть факультет</td><td style='float:right;'>
   <select class='faculti' name='faculti'>
   <option value='' selected='selected'>------Пусто-----</option>
    ";
    for ($i=0;$i<count($department_kil);$i++)
    {
        $department = $fac->select_faculty($department_kil[$i]['faculty_id']);
        if ($_GET['faculty']==$department['DEPARTMENTID'])
                {   
                    echo "<option value='".$department['DEPARTMENTID']."' selected='selected'>".$department['DEPARTMENT']."</option>";
                }
        else    {
		            echo "<option value='".$department['DEPARTMENTID']."'>".$department['DEPARTMENT']."</option>";
                }
	}
    echo "
	</select></td></tr>";
    }
    if ($_GET['faculty']!=null && $_GET['year']!=null)
    {
     $speciality_kil = $test->select_excel2("SELECT DISTINCT speciality_id FROM excel WHERE faculty_id='".$_GET['faculty']."' AND type_atemp='".$_GET['year']."'");
     
    echo "<tr><td> Виберіть спеціальніть </td><td style='float:right;'><select name='special' class='special'>
    <option value='' selected='selected'>------Пусто-----</option>
    ";
    for ($i=0;$i<count($speciality_kil);$i++)
    {
        $speciality = $fac->select_speciality($speciality_kil[$i]['speciality_id']);
         if ($_GET['special']==$speciality['SPECIALITYID'])
         {
		      echo "<option value='".$speciality['SPECIALITYID']."' selected='selected'>".$speciality['SPECIALITY']."</option>";
         }
         else
         {
              echo "<option value='".$speciality['SPECIALITYID']."'>".$speciality['SPECIALITY']."</option>";
         }
	}
    echo "
	</select> </td></tr>";  
    }
    if ($_GET['special']!=''&&$_GET['faculty']!=''&&$_GET['year']!='')
    {
    $lang_kil = $test->select_excel2("SELECT DISTINCT lang FROM excel WHERE speciality_id='".$_GET['special']."' AND faculty_id='".$_GET['faculty']."' AND type_atemp='".$_GET['year']."'");
     
    echo "<tr><td> Виберіть мову складання </td><td style='float:right;'><select name='lang' class='lang'>
    <option value='' selected='selected'>------Пусто-----</option>
    ";
    for ($i=0;$i<count($lang_kil);$i++)
    {
       if ($_GET['lang']==$lang_kil[$i]['lang']) 
       {
          echo "<option value='".$lang_kil[$i]['lang']."' selected='selected'>".$lang_kil[$i]['lang']."</option>";
       }
       else
       {
          echo "<option value='".$lang_kil[$i]['lang']."'>".$lang_kil[$i]['lang']."</option>";
       }
    }
    echo "
	</select> </td></tr>";  
    }
	if ($_GET['special']!='' && $_GET['faculty']!='' && $_GET['lang']!=''&&$_GET['year']!='')
    {
    $course_kil = $test->select_excel2("SELECT DISTINCT semester FROM excel WHERE lang='".$_GET['lang']."' AND speciality_id='".$_GET['special']."' AND faculty_id='".$_GET['faculty']."' AND type_atemp='".$_GET['year']."'"); 
    echo "<tr><td> Виберіть семестер </td><td style='float:right;'><select name='course' class='course'>
    <option value='' selected='selected'>------Пусто-----</option>
    ";
    for ($i=0;$i<count($course_kil);$i++)
    {
       if ($_GET['course']==$course_kil[$i]['semester']) 
       {
          echo "<option value='".$course_kil[$i]['semester']."' selected='selected'>".$course_kil[$i]['semester']."</option>";
       }
       else
       {
          echo "<option value='".$course_kil[$i]['semester']."'>".$course_kil[$i]['semester']."</option>";
       }
    }
    echo "
	</select> </td></tr>";  
    }

?>
