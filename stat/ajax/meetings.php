<? 
$nowdate=date("d-m-Y");
if ((isset($_GET['worker']))&&($_GET['worker']!="")) {
$selectworker=" selected";
$selectnone="";
}
else {
$selectnone=" selected";
$selectworker="";
}

echo <<<HTML
<div class="row-fluid">
        <h2>Встречи</h2>
		<form name="getworker" action="/?go=meetings" method="get">
		<input type="hidden" name="go" value="meetings">
		<select name="worker" id="workerlist" onchange="JavaScript:document.forms['getworker'].submit();">
		<option$selectnone disabled="disabled">Выберите сотрудника...</option>
HTML;
$query = "SELECT DATE_FORMAT(workers.date,'%d.%m.%Y %H:%i') as 'date',dept.name as 'dname', dept.id as 'did', workers.name as 'name',workers.dept_id as 'dept_id',workers.working as 'working', workers.id as 'wid'  FROM dept INNER JOIN workers ON ( dept.id = workers.dept_id ) ORDER BY dept.name";
$res = mysql_query($query);
$data = array();
while($row = mysql_fetch_assoc($res)){
    $data[] = $row; // получаем данные в массив
}
$group = $data[0]['dname']; // выбираем первый тип и помещаем в переменную group
echo '<option disabled="disabled" value=""><b>' .$group. '</b></option>'; // выводим первый тип
/* проходимся по массиву */
foreach($data as $item){
    /* если текущий тип не совпадает с имеющимся в переменной group */
    if($group != $item['dname']){
            echo '<option disabled="disabled" value=""><b>' .$item['dname']. '</b></option>'; // то выводим новый тип
            $group = $item['dname']; // и заносим новый тип в переменную group
			$workerscount=0;	
    }
	$workerscount++;
    /* если же текущий тип совпадает с имеющимся в переменной group, то цикл пропускаем */
	if ($item['wid']==$_GET['worker']) {
	if ($prev_WID!="") {$prev_WID_save=$prev_WID;$prev_WID="";}
	echo "<option$selectworker value=\"".$item['wid']."\">".$item['name']."</option>";
	$savenext=1;
	}
	else {
	if ($savenext==1) {$next_worker_id=$item['wid'];$savenext=0;}
	$prev_WID=$item['wid'];
	echo "<option value=\"".$item['wid']."\">".$item['name']."</option>";
	}

}
echo <<<HTML
		</select>
		</form>	
HTML;


if ((isset($_GET['worker']))&&($_GET['worker']!="")) {
$W_Id=mysql_real_escape_string($_GET['worker']);
$Worker_Info_Sql = mysql_query("SELECT DATE_FORMAT(meetings.date,'%d.%m.%Y') as 'last_meeting_date', DATE_FORMAT(workers.date,'%d.%m.%Y %H:%i') as 'date',dept.name as 'dname', dept.id as 'did', workers.name as 'name',workers.dept_id as 'dept_id',workers.working as 'working', workers.id as 'wid'  FROM dept INNER JOIN workers ON ( dept.id = workers.dept_id ) LEFT JOIN meetings ON ( workers.id = meetings.workers_id ) WHERE workers.id=$W_Id ORDER BY meetings.date;");
while($Worker_Info_Rows = mysql_fetch_array($Worker_Info_Sql))
{
$W_Name=$Worker_Info_Rows['name'];
$W_Working=$Worker_Info_Rows['working'];
if ($Worker_Info_Rows['last_meeting_date']!="") {
$W_Last_Meeting="<span style=\"font-size:12px;\">(Последняя встреча: ".$Worker_Info_Rows['last_meeting_date'].") <a id=\"historyC\" href=\"#history\" style=\"\" onclick=\"showhistory(".$_GET[worker].",0);\">История</a></span>";
}
else {
$W_Last_Meeting="<span style=\"font-size:12px;\">(Встречи ещё не добавлены)</span>";
}
$W_Dept_Name=$Worker_Info_Rows['dname'];
}
echo <<<HTML

	<!-- edit meet-->
    <div id="editmeet" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Редактировать встречу</h3>
    </div>
    <div class="modal-body" id="editmeetform">
    <p>
	<form onsubmit="return editmeetsave();" id="editmeetf" class="form-horizontal">
	<div id="newmeetblock">
	</div>
	</form>
    </div>
    <div class="modal-footer">
    <button id="closeeditmeetbutton" class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
	<div id="editmeetbutton" style="display:inline-block;"></div>
    </div>
    </div>

	<!-- delete meet-->
    <div id="deletemeet" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Удалить встречу</h3>
    </div>
    <div class="modal-body" id="deletemeetform">
    <p>
	<form onsubmit="return dodeletemeet();" id="deletemeet">
	<div id="deletemeetarea">
	</div>
	</form>
    </div>
    <div class="modal-footer">
    <button id="closedeletemeetbutton" class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
	<div id="deletemeetbutton" style="display:inline-block;"><button class="btn btn-primary" onclick="dodeletemeet();">Удалить</button></div>
    </div>
    </div>

<div id="addmeetsarea">
<table class="table table-bordered" style="width:600px;">
<tr class="info"><td colspan="5">
$W_Dept_Name - <a id="historyD" href="#dept_history" style="" onclick="showdepthistory($Worker_Info_Rows[did],0);">История</a></span>
<div style="width:600px;" id="depthistoryarea"></div>
<h3>$W_Name -<br>$W_Working <span id="W_Last_Meeting">$W_Last_Meeting</span></h3>
<div style="width:600px;" id="historyarea"></div>
</td></tr>

<tr><td colspan="5">
<form id="addmeetings" method="post" action="" onsubmit="addmeet($_GET[worker]);">
<h4>Добавить встречи:</h4>
<style>
.micro {
width:20px!important;
}
.comm {
width:140px!important;
}
</style>
<div id="addmeetformres">
</div>
Дата: 		<div class="input-append date" id="meetingdate" data-date="$nowdate" data-date-format="dd-mm-yyyy">
			<input class="span2" size="16" value="$nowdate" readonly="" type="text" style="width:100%;" id="meetdate">
			<span class="add-on"><i class="icon-calendar"></i></span>
			</div> 
</td></tr>
<tr><td></td><td><b>План</b></td><td><b>Факт</b></td><td><b>П.комм</b></td><td><b>Ф.комм</b></td></tr>
<tr><td><b>СИ</b></td><td><center>
<input name="cp" id="cp" type="text" class="input-mini micro"></center></td><td><center>
<input name="cf" id="cf" type="text" class="input-mini micro"></center></td><td><center>
<input name="cpcomm" id="cpcomm" type="text" class="input-mini comm"></center></td><td><center>
<input name="cfcomm" id="cfcomm" type="text" class="input-mini comm"></center></td></tr>

<tr><td><b>КП</b></td><td><center>
<input name="kp" id="kp" type="text" class="input-mini micro"></center></td><td><center>
<input name="kf" id="kf" type="text" class="input-mini micro"></center></td><td><center>
<input name="kpcomm" id="kpcomm" type="text" class="input-mini comm"></center></td><td><center>
<input name="kfcomm" id="kfcomm" type="text" class="input-mini comm"></center></td></tr>

<tr><td><b>ФЭСИМ</b></td><td><center>
<input name="fp" id="fp" type="text" class="input-mini micro"></center></td><td><center>
<input name="ff" id="ff" type="text" class="input-mini micro"></center></td><td><center>
<input name="fpcomm" id="fpcomm" type="text" class="input-mini comm"></center></td><td><center>
<input name="ffcomm" id="ffcomm" type="text" class="input-mini comm"></center></td></tr>


<tr><td><b>ПРОД</b></td><td><center>
<input name="pp" id="pp" type="text" class="input-mini micro"></center></td><td><center>
<input name="pf" id="pf" type="text" class="input-mini micro"></center></td><td><center>
<input name="ppcomm" id="ppcomm" type="text" class="input-mini comm"></center></td><td><center>
<input name="pfcomm" id="pfcomm" type="text" class="input-mini comm"></center></td></tr>

<tr><td><b>ТВ</b></td><td><center>
<input name="tp" id="tp" type="text" class="input-mini micro"></center></td><td><center>
<input name="tf" id="tf" type="text" class="input-mini micro"></center></td><td><center>
<input name="tpcomm" id="tpcomm" type="text" class="input-mini comm"></center></td><td><center>
<input name="tfcomm" id="tfcomm" type="text" class="input-mini comm"></center></td></tr>

<tr><td><b>Досбор</b></td><td><center>
<input name="dp" id="dp" type="text" class="input-mini micro"></center></td><td><center>
<input name="df" id="df" type="text" class="input-mini micro"></center></td><td><center>
<input name="dpcomm" id="dpcomm" type="text" class="input-mini comm"></center></td><td><center>
<input name="dfcomm" id="dfcomm" type="text" class="input-mini comm"></center></td></tr>

<tr><td colspan="5">
<div style="float:right;" id="safebuttonarea"><a class="btn btn-primary" onclick="addmeet($_GET[worker]);" href="#add">Сохранить</a></div>
<div style="clear:both;"></div>
<div id="safeerrors" style="float:right;"></div>
</td></tr>
</table>
</div>
<div style="width:600px;">
HTML;
if($next_worker_id!="") {
echo <<<HTML
<div style="width:200px;text-align:right;float:right;"><a href="/?go=meetings&worker=$next_worker_id" >Следующий сотрудник &rarr;</a></div>
</form>
HTML;
}
if($prev_WID_save!="") {
echo <<<HTML
<div style="width:200px;text-align:left;float:left;"><a href="/?go=meetings&worker=$prev_WID_save" >&larr; Предыдущий сотрудник</a></div>
</form>
HTML;
}
echo <<<HTML
</div>
HTML;
}
else {
echo "";
}

?>