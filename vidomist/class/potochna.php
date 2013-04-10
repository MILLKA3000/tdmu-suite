<?
function pereved_pot($d1)
{
if ($d1==66){$d1=4;}
if ($d1==69){$d1=4.5;}
if ($d1==72) {$d1=5;}
if ($d1==75){$d1=5.5;}
if ($d1==78) {$d1=6;}
if ($d1==81){$d1=6.5;}
if ($d1==84) {$d1=7;}
if ($d1==87){$d1=7.5;}
if ($d1==90) {$d1=8;}
if ($d1==93){$d1=8.5;}
if ($d1==96) {$d1=9;}
if ($d1==99){$d1=9.5;}
if ($d1==102) {$d1=10;}
if ($d1==105){$d1=10.5;}
if ($d1==108) {$d1=11;}
if ($d1==111){$d1=11.5;}
if ($d1>=112) {$d1=12;}
if ($d1=='') {$d1=0;}
return $d1;
}
function pereved_ostatochna($ocinka,$potochna)
{
if ($ocinka!='')
{
	if ($ocinka=='0(n)'){$ostatochna='0(n)';}
	if ($ocinka=='0'){$ostatochna='0';}
	if ($ocinka>0){$ostatochna=($ocinka*0.4)+($potochna*0.6);}
    if ($potochna=='0'){$ostatochna='0';}
}
return $ostatochna;
}
?>