<?

$stream="<table border=1>
<tr><td>№</td><td>Курс</td><td>Назва модулю (дисципліни)</td><td>Загальна кількість студентів </td><td>Загальна кількість студентів 	Кількість студентів , що склали модуль на 'незадовіль-но' (відсоток)</td><td>Кількість студентів , що склали модуль на 'задовільно' (відсоток)</td><td>Кількість студентів , що склали модуль на 'добре' (відсоток)</td><td>Кількість студентів , що склали модуль на 'відмінно' (відсоток)</td><td>Cередній бал</td><td>Середній бал поточної успішності</td><td>Важкі</td><td>Легкі</td><td>Середній показник</td></tr>";

for ($i=0;$i<count($discipline);$i++)
		{
		$plan = $contingent->select("select bvm.modulenum,gd.discipline,bvm.moduletheme,BT.SEMESTER from STUDENT2TESTLIST S2T
		    inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm 
			on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join guide_discipline gd
			on (BVI_V.disciplineid = gd.disciplineid) where BT.TESTLISTID=".$discipline[$i][2]."");
		$zag=$local->select("SELECT count(oc.oc) FROM `oc`,`to`,`zv` WHERE oc.name_user='".$_SESSION['role']."' AND oc.name_user=zv.name_user AND oc.name_user=to.name_user AND oc.num=".$discipline[$i][1]." AND oc.kod=zv.kod AND to.idstyd=zv.idstyd AND to.num=oc.num AND to.value='true';");
		if ($zag[0][0]==0){$zag2[0][0]=1;}else{$zag2[0][0]=$zag[0][0];}
		$o2=$local->select("SELECT count(oc.oc) FROM `oc`,`to`,`zv` WHERE oc.name_user='".$_SESSION['role']."' AND oc.name_user=zv.name_user AND oc.name_user=to.name_user AND oc.num=".$discipline[$i][1]." AND oc.kod=zv.kod AND to.idstyd=zv.idstyd AND to.num=oc.num AND ((to.value='true' AND oc='0(n)')or(to.value='true' AND oc='0'))");$o2=$o2[0][0]."(".(number_format($o2[0][0]/$zag2[0][0]*100,2))."%)";
		$o3=$local->select("SELECT count(oc.oc) FROM `oc`,`to`,`zv` WHERE oc.name_user='".$_SESSION['role']."' AND oc.name_user=zv.name_user AND oc.name_user=to.name_user AND oc.num=".$discipline[$i][1]." AND oc.kod=zv.kod AND to.idstyd=zv.idstyd AND to.num=oc.num AND to.value='true' AND oc>=4 AND oc<=6;");$o3=$o3[0][0]."(".(number_format($o3[0][0]/$zag2[0][0]*100,2))."%)";
		$o4=$local->select("SELECT count(oc.oc) FROM `oc`,`to`,`zv` WHERE oc.name_user='".$_SESSION['role']."' AND oc.name_user=zv.name_user AND oc.name_user=to.name_user AND oc.num=".$discipline[$i][1]." AND oc.kod=zv.kod AND to.idstyd=zv.idstyd AND to.num=oc.num AND to.value='true' AND oc>=7 AND oc<=9;");$o4=$o4[0][0]."(".(number_format($o4[0][0]/$zag2[0][0]*100,2))."%)";
		$o5=$local->select("SELECT count(oc.oc) FROM `oc`,`to`,`zv` WHERE oc.name_user='".$_SESSION['role']."' AND oc.name_user=zv.name_user AND oc.name_user=to.name_user AND oc.num=".$discipline[$i][1]." AND oc.kod=zv.kod AND to.idstyd=zv.idstyd AND to.num=oc.num AND to.value='true' AND oc>=10 AND oc<=12;");$o5=$o5[0][0]."(".(number_format($o5[0][0]/$zag2[0][0]*100,2))."%)";
		$ser_bal = $local->select("SELECT avg(oc.oc) FROM `oc`,`to`,`zv` WHERE oc.name_user='".$_SESSION['role']."' AND oc.name_user=zv.name_user AND oc.name_user=to.name_user AND oc.num=".$discipline[$i][1]." AND oc.kod=zv.kod AND to.idstyd=zv.idstyd AND to.num=oc.num AND to.value='true';");
		$styd = $local->select("SELECT zv.idstyd FROM `oc`,`to`,`zv` WHERE oc.name_user='".$_SESSION['role']."' AND oc.name_user=zv.name_user AND oc.name_user=to.name_user AND oc.num=".$discipline[$i][1]." AND oc.kod=zv.kod AND to.idstyd=zv.idstyd AND to.num=oc.num AND to.value='true';");	
		$pot=0;
						for ($x=0;$x<count($styd);$x++)
						{
						$plans = $contingent->select("select bvm.modulenum,gd.discipline,bvm.moduletheme,S2T.TESTLISTID,S2T.CREDITS_CUR from STUDENT2TESTLIST S2T
						inner join B_TESTLIST BT on (BT.TESTLISTID = S2T.TESTLISTID) inner join B_VARIANT_ITEMS BVI_M on (BVI_M.VARIANTID = BT.VARIANTID) inner join b_variant_module bvm 
						on (BVI_M.VARIANTID = bvm.VARIANTID) inner join B_VARIANT_ITEMS BVI_V on (BVI_V.VARIANTID = BVI_M.PARENTVARIANTID) inner join guide_discipline gd
						on (BVI_V.disciplineid = gd.disciplineid) where BT.TESTLISTID=".$discipline[$i][2]." AND S2T.STUDENTID=".$styd[$x][0]."");
						$pot=$pot+potochna($plans[0][4]);
						}
					if (count($styd)==0){$pot=0;$styd[0][0]=1;}
		$stream.="<tr><td>".($i+1)."</td><td>".course($student[0][4])."</td><td>".$plan[0][1]." - ".$plan[0][0].".".$plan[0][2]."</td><td>".$zag[0][0]."</td><td>".$o2."</td><td>".$o3."</td><td>".$o4."</td><td>".$o5."</td><td>".$ser_bal[0][0]."</td><td>".$pot/count($styd)."<td></td><td></td><td></td></tr>";
		}
$fp2=fopen("arhiv/faculty/".rus2translit($student[0][3])."/".rus2translit($student[0][2])."/Semester ".rus2translit($student[0][4])."/Date ".$date."/Statistick/Zagalna.doc","w+");
fwrite($fp2, $stream);
fclose($fp2);
 ?>
