<style>
a {color:blue;font-size:12pt;}
body {background:White;}
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<body>

<?php
class scan {
var $file_pdf = array(array());
var $in=0;
	function getNumPagesPdf($filepath,$file){
	
    $fp = @fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
    $max=0;
    while(!feof($fp)) {
            $line = fgets($fp,255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)){
					//preg_match_all("/\/Page\W/", $matches[0], $matches2);
                    preg_match('/[0-9]+/',$matches[0], $matches2);
                    if ($max<$matches2[0]) $max=$matches2[0];
            }
    }
    fclose($fp);
    /*if($max==0){
        $im = new Imagick($filepath);
		$max=$im->getNumberImages(); 
    }*/
	
		
	$this->file_pdf[$this->in]['file']=$filepath;
	$this->file_pdf[$this->in]['max']=$max;
	$this->file_pdf[$this->in]['name_file']=$file;
	$this->in++;
	}

   function scan_dir($dirname,$type)
   {
    $count=0;
	
     $dir = opendir($dirname);
     // ������ � ����� ����������
     while (($file = readdir($dir)) !== false)
     {
 // ���� ��� �� ������������ ���������� � �� ������� ����������, ��
       if($file != "." && $file != "..")
       {
         if(is_dir($dirname."/".$file))//���� ��� ����������
         {
          $kil=$kil+$this->scan_dir($dirname."/".$file,$type);//���������� ������������� ��. ����������
         }
         if(is_file($dirname."/".$file))//���� ��� ����
         {
			if ((strpos($file,".htm"))||(strpos($file,".html"))||(strpos($file,".ppt"))||(strpos($file,".pptx"))||(strpos($file,".pdf"))){
			$count++;}
			if (strpos($file,".pdf")){
			
			$this->getNumPagesPdf($dirname."/".$file,$file);
			}
         }
       }
     }
			if (($count>1)||(($count!=0)&&(strpos($dirname,"rob_prog")))){
			$kil=$kil+$count;
			}		
     closedir($dir);
	
	return $kil;
   }
   
}
//------------------��������� ����� 
$scan = new scan();
//----------------------------------
$doc_0_kaf = array(anatomy=>"������� ������i� ������",
patologanatom=>"������� �������i��� ������i� � ����i���� ������ �� ������� ���������",
histolog=>"������� �i������i� �� ����i����i�", 
med_biologia=>"������� ������� �i����i�",
micbio=>"������� �i����i����i�, �i�������i� �� i�������i�",
normal_phiz=>"������� �i�i����i�",
socmedic=>"������� ���i����� ��������, �����i���i� �� ������i�� ������� ������'� � �������� ����������� �� i����i�� ��������",
deontologi=>"������� ������� ������� �� ��������㳿",
chemistry=>"������� ������� �i��i�i�",
pharmakologia=>"������� ����������i� � ��i�i���� ����������i��",
hihiena=>"������� �������� �i�i��� �� ������i�",
patolog_phis=>"������� �������i��� �i�i����i�",
med_catastrof=>"������� �������� ��������� �� �������� ��������",
informatika=>"������� ������� i����������",
biofiz=>"������� ������� ������ �� ��������� ����������",
philosophy=>"������� ��������� �� ��������� ��������",
sus_dusct=>"������� ��������������",
in_mow=>"������� ��������� ��� � �������� ��������㳺�",
i_nurse=>"̳�������� �������������� �����",
distance=>"����������� ������ (��������) - ����������� ����� ��������",
magistr=>"����������� ������ (������) - ����������� ����� ��������",
u_nurse=>"�������, �� ���������� ������������� ��������� ���������� �����",
clinlab=>"������� ��i�i��-����������� �i���������",
propedeutic_vn_des=>"������� ������������ �����i���� �������� �� ����i���i�",
vn_med_alerg=>"������� �����i���� �������� �1",
klinpat=>"������� ������������� ���������� �� ������ ����������㳿",
vn_med_al=>"������� �����i���� �������� �3",
infect_desease=>"������� i�����i���� ������ � ��i���i����i��, ��i����� �� ����������� ���������",
nervous_desease=>"������� ��������i�, ����i���i�, ��������i� �� ������� ��������i�",
pedistrics=>"������� ���i���i� �� ������ �i����i�",
zagalna_surgery=>"������� �������� �� ���������� �i����i� � ��������i���� ������i��",
hospital_surgery=>"������� �i����i� �1",
obstetrics_ginecology_1=>"������� ���������� �� �i�������i� �1",
sport_medic=>"������� ������� ����i�i���i� �� ��������� ��������",
lor=>"������� �����������������i�, �����������i� �� ������i����i�",
onkologia=>"������� o������i�, ��������� �i��������� i �����i� �� ���i��i��� ��������",
policlin=>"������� �������� ������-�������� �������� �� ������ ��������",
nev_stan=>"������� ���������� �� �������� ������� ��������",
upr_ekon=>"������� ��������� �� �������� ��������",
pharma_2=>"������� ������������� �i�i�",
pharma_1=>"������� �����������i� � �������� �����i���",
klinpharm=>"������� ������ ��������",
lik_tex=>"������� �������㳿 ���",
endoscop_fpo=>"������� �������ﳿ � ������������� �����㳺�, �����㳺�, ������䳺� �� ����������㳺� ���",
obsretr_fpo=>"������� a��������� �� �i�������i� ���",
travmatologia_FPO=>"������� �����㳿 ���",
pediatria_fpo=>"������� ���i���i� ���",
therapy_fpo=>"������� �����i� �� �i����� �������� ���",
stomat_hir=>"������� ��������� ���������㳿",
stomat_ter=>"������� ������������ ���������㳿",
stomat_ter_dit=>"������� ������ ���������㳿",
stomat_ortop=>"������� ����������� ���������㳿",
meds=>"������� ��i�i��� i�������i�, ���������i� �� ���������� ������� �� �������",
surgery2=>"������� �i����i� � �������i����i�� �2",
vnutrmed2=>"������� �����i���� �������� �2",
ginecology2=>"������� ���������� �� �i�������i� �2",
pediatria2=>"������� ���i���i� �2"); 

echo "<div><table  width=100% border=1><tbody><tr><th width='30%'><h1><center>�������</th><th width=70% ><h1><center>��������� (����� ��� ���������)</th></tr><tr><td valign=top><b>";
foreach ($doc_0_kaf as $kaf_id=>$kaf_name){
echo"<li><a href='scan.php?kaf=".$kaf_id."'>".$kaf_name."</a><br>";
} 
echo "</td>"; 
echo "<td valign=top>"; 
if ($_GET['kaf']){
echo "<center><h3>".$doc_0_kaf[$_GET['kaf']]."</h3></center>";
echo "<table width=100% border=1><tbody><tr><td><b>���</td><td><b>��������</td><td><b>��������</td><td><b>�������</td><td><b>��������</td></tr>";  
$t=array(0=>"classes_stud",1=>"classes_stud/en",2=>"classes_stud/ru",3=>"classes_stud/uk",
4=>"lectures_stud",5=>"lectures_stud/en",6=>"lectures_stud/ru",7=>"lectures_stud/uk",
8=>"metod_rozrobky",9=>"metod_rozrobky/en",10=>"metod_rozrobky/ru",11=>"metod_rozrobky/uk",
12=>"presentations",13=>"presentations/en",14=>"presentations/ru",15=>"presentations/uk",
16=>"rob_prog",17=>"rob_prog/en",18=>"rob_prog/ru",19=>"rob_prog/uk"); 

$ENCODE_FOLDERNAME = ARRAY('classes_stud'=>'�������� �� ��������� �� ����������',
'classes_stud/en'=>'',
'classes_stud/ru'=>'',
'classes_stud/uk'=>'',
'lectures_stud'=>'�������� �� ��������� �� ������',
'lectures_stud/en'=>'',
'lectures_stud/ru'=>'',
'lectures_stud/uk'=>'',
'metod_rozrobky'=>'��������i ����i���',
'metod_rozrobky/en'=>'',
'metod_rozrobky/ru'=>'',
'metod_rozrobky/uk'=>'',
'presentations'=>'����������� ������',
'presentations/en'=>'',
'presentations/ru'=>'',
'presentations/uk'=>'',
'rob_prog'=>'������ ��������',
'rob_prog/en'=>'',
'rob_prog/ru'=>'',
'rob_prog/uk'=>''
); 

   for ($i=0;$i<count($t);$i++){
   if (isset($ENCODE_FOLDERNAME[$t[$i]])){$name=$ENCODE_FOLDERNAME[$t[$i]];}else{$name=$t[$i];}
   if(is_dir($_GET['kaf'].'/'.$t[$i].'/')){
$count=$scan->scan_dir($_GET['kaf'].'/'.$t[$i].'/',"");



if (($i==0)){echo "<tr>";}
if (($i==4)||($i==8)||($i==12)||($i==16)){echo "</tr><tr>";}
if (($i==1)||($i==5)||($i==9)||($i==13)||($i==17)){$angl=$angl+$count;}
if (($i==2)||($i==6)||($i==10)||($i==14)||($i==18)){$rus=$rus+$count;}
if (($i==3)||($i==7)||($i==11)||($i==15)||($i==19)){$ua=$ua+$count;}
if (($i==0)||($i==4)||($i==8)||($i==12)||($i==16)){
if ($count==0) {echo"<td><b><font color=red><center>".$name."</td><td><b><font color=red><center> 0 </td>";}else{
echo "<td><b>".$name."</td><td><b><center>".$count." </td>"; $zagalne=$zagalne+$count;}}
else{if ($count==0) {echo"<td><b><font color=red><center>".$name." 0 </td>";}else{echo "<td><b><center>".$count." </td>";} }
 
if (($i==20)){echo "</tr>";}

}
	else
		{
			echo"<td><b><font color=red>".$name." 0 </td>";
		}
								}
echo "</tr><tr><td><b>�����</td><td><b><center>".$zagalne."</td><td><b><center>".$angl."</td><td><b><center>".$rus."</td><td><b><center>".$ua."</td></tr></tbody></table>";

}

//------��������� ��� �������-----------
if ($_GET['kaf']){ 
if(is_dir($_GET['kaf']."/")){
echo "<br><br><center><b>������ <font color=green>PDF</font> ����� �� ���� ������� �������</b></center>";
$max_shet=0;
uksort($scan->file_pdf,"max");
echo"<table bgcolor='white' width='100%' border='1'><tbody><tr  bgcolor='gray'><td>�</td><td>����</td><td>ʳ������ �������</td></tr>";
		for ($i=0;$i<count($scan->file_pdf);$i++)
			{
			$max_shet=$max_shet+$scan->file_pdf[$i]['max'];
			echo "<tr>";
	
				echo "<td bgcolor='gray'>".($i+1)."</td><td><a href='http://intranet.tdmu.edu.ua/data/kafedra/internal/".$scan->file_pdf[$i]['file']."'>".$scan->file_pdf[$i]['name_file']."</a></td><td>".$scan->file_pdf[$i]['max']."</td>";
				
			echo "</tr>";
			}
			echo "<tr><td colspan=2><b>����� ������� (��������)</b></td><td><b>".$max_shet."</b></td></tr>";
	echo "</tbody></table>";
}
}
echo "</td></tr></tbody></table></div>";
   
?>
