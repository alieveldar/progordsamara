<?php
if(!function_exists('date_parse_from_format')){
        function date_parse_from_format($_wp_format, $date){

                $date_pcs = preg_split('/ (?!.* )/',$_wp_format);
                $time_pcs = preg_split('/ (?!.* )/',$date);

                $_wp_date_str = preg_split("/[\s . , \: \- \/ ]/",$date_pcs[0]);
                $_ev_date_str = preg_split("/[\s . , \: \- \/ ]/",$time_pcs[0]);

                $check_array = array(
                        'Y'=>'year',
                        'y'=>'year',
                        'm'=>'month',
                        'n'=>'month',
                        'M'=>'month',
                        'F'=>'month',
                        'd'=>'day',
                        'j'=>'day',
                        'D'=>'day',
                        'l'=>'day',
                );

                foreach($_wp_date_str as $strk=>$str){

                        if($str=='M' || $str=='F' ){
                                $str_value = date('n', strtotime($_ev_date_str[$strk]));
                        }else{
                                $str_value=$_ev_date_str[$strk];
                        }

                        if(!empty($str) )
                                $ar[ $check_array[$str] ]=$str_value;           

                }

                $ar['hour']= date('H', strtotime($time_pcs[1]));
                $ar['minute']= date('i', strtotime($time_pcs[1]));

                return $ar;
        }
}
?>

<?
function ReturnMenu()
	{
?>
    <ul class="nav">
	<li <?php echo (!isset($_GET['go'])) ? "class=\"active\"" : ""; ?>><a href="/">Главная</a></li>
    <li <?php echo ($_GET['go'] == 'dept') ? "class=\"active\"" : ""; ?>><a href="/?go=dept">Отделы</a></li>
    <li <?php echo ($_GET['go'] == 'workers') ? "class=\"active\"" : ""; ?>><a href="/?go=workers">Сотрудники</a></li>
	<li <?php echo ($_GET['go'] == 'meetings') ? "class=\"active\"" : ""; ?>><a href="/?go=meetings">Встречи</a></li>
    <li <?php echo ($_GET['go'] == 'stats') ? "class=\"active\"" : ""; ?>><a href="/?go=stats">Отчеты</a></li>
	</ul>
<?
	}
?>


<?
function returneditprofileform($id,$allowsafe,$message) {

echo <<<HTML
    <p>
HTML;
	if ($allowsafe==1) {
echo <<<HTML
	<form onsubmit="return profile($id);" id="editprofile$id">
	<input placeholder="Старый пароль" type="password" name="oldpass" id="oldpass"><br>
	<input placeholder="Новый пароль" type="password" name="newpass" id="newpass">
	<input placeholder="Повторите новый пароль" type="password" name="confirmnewpass" id="confirmnewpass">
	</form>
HTML;
}
echo <<<HTML
	$message
	</p>
HTML;
}
?>

<?
function returnadddeptform($id,$allowsafe,$message) {
echo <<<HTML
    <p>
HTML;
if ($allowsafe==1) {
echo <<<HTML
	<form onsubmit="return adddept($id);" id="adddept$id">
	<input placeholder="Название отдела" type="text" name="deptname" id="deptname"><br>
	</form>
HTML;
}
echo <<<HTML
	$message
	</p>
HTML;
}
?>

<?
function returnaddworkersform($id,$allowsafe,$message) {
echo <<<HTML
    <p>
HTML;
if ($allowsafe==1) {
echo <<<HTML
	<form onsubmit="return addworkers();" id="addworkers">
	<input placeholder="ФИО" type="text" name="workername" id="workername"><br>
	<input placeholder="Должность" type="text" name="workerwork" id="workerwork"><br>
<select name="workerdept" id="workerdept">
<option selected disabled="disabled">Выберите отдел</option>
HTML;
	$workerdeptsql = mysql_query("select * from dept ORDER BY name;");
	while($workerdeptrow = mysql_fetch_array($workerdeptsql))
		{
		echo "<option value=\"".$workerdeptrow['id']."\">".$workerdeptrow['name']."</option>";
		}
echo <<<HTML
</select>
	</form>
HTML;
}
echo <<<HTML
	$message
	</p>
HTML;
}
?>

<?
function returneditdeptform($id,$name,$allowsafe, $message) {
	if ($allowsafe==1) {
	echo "<input placeholder=\"Название отдела\" type=\"text\" name=\"newdeptname\" id=\"newdeptname\" value=\"".$name."\">
	<input type=\"hidden\" name=\"editdeptid\" id=\"editdeptid\" value=\"".$id."\">
	<input type=\"hidden\" name=\"deptnowname\" id=\"deptnowname\" value=\"".$name."\">";
	}
	echo "<p>".$message."<p>";
}
?>

<?
function returneditworkerform($id,$name,$working,$dept,$deptid,$allowsafe, $message) {
	if ($allowsafe==1) {
	echo "<input placeholder=\"ФИО\" type=\"text\" name=\"newworkername\" id=\"newworkername\" value=\"".$name."\"><br>
	<input placeholder=\"Должность\" type=\"text\" name=\"newworking\" id=\"newworking\" value=\"".$working."\"><br>";
			$nowdept="<select name=\"nowdept\" id=\"nowdept\">
			<option selected disabled=\"disabled\">Выберите отдел</option>";
			$workerdeptsql = mysql_query("select * from dept ORDER BY name;");
			while($workerdeptrow = mysql_fetch_array($workerdeptsql))
			{
			if ($workerdeptrow['id']==$deptid) {$selected_dept=" selected";} else {$selected_dept="";}
			$nowdept = $nowdept."<option".$selected_dept." value=\"".$workerdeptrow['id']."\">".$workerdeptrow['name']."</option>";
			}
			$nowdept=$nowdept."</select>";
	echo $nowdept."
	<input type=\"hidden\" name=\"editworkerid\" id=\"editworkerid\" value=\"".$id."\">
	<input type=\"hidden\" name=\"workernowname\" id=\"workernowname\" value=\"".$name."\">
	<input type=\"hidden\" name=\"nowworking\" id=\"nowworking\" value=\"".$working."\">
	<input type=\"hidden\" name=\"nowdeptid\" id=\"nowdeptid\" value=\"".$deptid."\">";
	}
	echo "<p>".$message."<p>";
}
?>

<?
function returneditmeetform($id,$date,$type_id,$p,$f,$pcom,$fcom, $allowsafe, $message) {
	if ($allowsafe==1) {
	echo "<input value=\"".$date."\" readonly=\"\" type=\"hidden\" id=\"changemeetdate\">
			";
			$nowtype="<select name=\"nowtype\" id=\"nowtype\">
			<option selected disabled=\"disabled\">Выберите тип встречи</option>";
			$meetingsql = mysql_query("select * from meets ORDER BY id;");
			while($meetingrow = mysql_fetch_array($meetingsql))
			{
			if ($meetingrow['id']==$type_id) {$selected_type=" selected";} else {$selected_type="";}
			$nowtype = $nowtype."<option".$selected_type." value=\"".$meetingrow['id']."\">".$meetingrow['name']."</option>";
			}
			$nowtype=$nowtype."</select>";
	echo "<label>Тип встречи:</label>".$nowtype."<br>
	
	<label>План:</label> <input placeholder=\"План\" type=\"text\" name=\"chp\" id=\"chp\" value=\"".$p."\">
	<label>Факт:</label> <input placeholder=\"Факт\" type=\"text\" name=\"chf\" id=\"chf\" value=\"".$f."\"><br>
	<label>П.комм:</label> <input placeholder=\"П.комм\" type=\"text\" name=\"chpcom\" id=\"chpcom\" value=\"".$pcom."\"><br>
	<label>Ф.комм:</label> <input placeholder=\"Ф.комм\" type=\"text\" name=\"chfcom\" id=\"chfcom\" value=\"".$fcom."\">
	<input type=\"hidden\" name=\"chmid\" id=\"chmid\" value=\"".$id."\">
	<input type=\"hidden\" name=\"olddate\" id=\"olddate\" value=\"".$date."\"><br>
		";
	}
	echo "<p>".$message."<p>";
}
?>

<?
function returnmeetsarray() {
$query="SELECT * from meets ORDER BY id";
$res = mysql_query($query);
$meetsarray = array();
while($row = mysql_fetch_assoc($res))
	{
    $meetsarray[] = $row; // получаем данные в массив
	}
return $meetsarray;
}
?>

<?
function returnfisrtmeetday() {
$query="SELECT * from meetings ORDER BY date LIMIT 0,1";
$res = mysql_query($query);
$meetsarray = array();
while($row = mysql_fetch_assoc($res))
	{
    $fisrtmeetday=$row['date']; // получаем данные в массив
	}
return $fisrtmeetday;
}
?>

<?
function returallmeetsef($wid,$datef,$datet) {
$query=mysql_query("SELECT *, IFNULL(sum(p),0) as sip, IFNULL(sum(f),0) as sif  from meetings WHERE workers_id=$wid AND meeting_type=1 AND DATE(date) BETWEEN '$datef' AND '$datet';");
while($row = mysql_fetch_assoc($query))
{$sip=$row['sip']; $sif=$row['sif'];echo "<td>".$row['sip']."/".$row['sif']."</td>"; }

$query=mysql_query("SELECT *, IFNULL(sum(p),0) as kpp, IFNULL(sum(f),0) as kpf  from meetings WHERE workers_id=$wid AND meeting_type=2 AND DATE(date) BETWEEN '$datef' AND '$datet';");
while($row = mysql_fetch_assoc($query))
{$kpp=$row['kpp'];$kpf=$row['kpf']; echo "<td>".$row['kpp']."/".$row['kpf']."</td>"; }

$query=mysql_query("SELECT *, IFNULL(sum(p),0) as fep, IFNULL(sum(f),0) as fef  from meetings WHERE workers_id=$wid AND meeting_type=3 AND DATE(date) BETWEEN '$datef' AND '$datet';");
while($row = mysql_fetch_assoc($query))
{$fep=$row['fep']; $fef=$row['fef']; echo "<td>".$row['fep']."/".$row['fef']."</td>"; }

$query=mysql_query("SELECT *, IFNULL(sum(p),0) as prp, IFNULL(sum(f),0) as prf  from meetings WHERE workers_id=$wid AND meeting_type=4 AND DATE(date) BETWEEN '$datef' AND '$datet';");
while($row = mysql_fetch_assoc($query))
{$prp=$row['prp']; $prf=$row['prf']; echo "<td>".$row['prp']."/".$row['prf']."</td>"; }

$query=mysql_query("SELECT *, IFNULL(sum(p),0) as tvp, IFNULL(sum(f),0) as tvf  from meetings WHERE workers_id=$wid AND meeting_type=5 AND DATE(date) BETWEEN '$datef' AND '$datet';");
while($row = mysql_fetch_assoc($query))
{$tvp=$row['tvp']; $tvf=$row['tvf']; echo "<td>".$row['tvp']."/".$row['tvf']."</td>"; }

$query=mysql_query("SELECT *, IFNULL(sum(p),0) as dop, IFNULL(sum(f),0) as dof  from meetings WHERE workers_id=$wid AND meeting_type=6 AND DATE(date) BETWEEN '$datef' AND '$datet';");
while($row = mysql_fetch_assoc($query))
{ $dop=$row['dop'];$dof=$row['dof'];echo "<td>".$row['dop']."/".$row['dof']."</td>"; }

if (($sip+$kpp+$fep+$prp+$tvp+$dop!=0) && ($sif+$kpf+$fef+$prf+$tvf+$dof!=0)) {
$effl=floor((($sif+$kpf+$fef+$prf+$tvf+$dof)/($sip+$kpp+$fep+$prp+$tvp+$dop))*100);

echo "<td style=\"background:#d9edf7;\">".$effl."%</td>";
}
else {
echo "<td style=\"background:#d9edf7;\">НД</td>";
}


if (($prf!=0) && ($sif+$dof!=0)) {
$eff=floor($prf/($sif+$dof)*100);
echo "<td style=\"background:#d9edf7;\">".$eff."%</td>";
}
else {
echo "<td style=\"background:#d9edf7;\">НД</td>";
}


}

function returnbeginenddates($wid)
	{
	$query=mysql_query("SELECT DATE_FORMAT(date,'%d.%m.%Y') as 'Mdate' from meetings WHERE workers_id=$wid ORDER BY date LIMIT 0,1;");
	while($row = mysql_fetch_assoc($query))
		{ $BeginDate=$row['Mdate']; }
	$query=mysql_query("SELECT DATE_FORMAT(date,'%d.%m.%Y') as 'Mdate' from meetings WHERE workers_id=$wid ORDER BY date DESC LIMIT 0,1;");
	while($row = mysql_fetch_assoc($query))
		{ $EndDate=$row['Mdate']; }
	echo $BeginDate." - ".$EndDate;
	}	

?>