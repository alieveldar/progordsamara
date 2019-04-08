<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Попытка взлома1');
	}

else if (isset($_POST['id'])) 
	{
	$id=mysql_real_escape_string($_POST['id']);
	$from=mysql_real_escape_string($_POST['from']);
	$to=$from+20;
	echo "<table class=\"table  table-striped table-hover\"> 
	<tr><td><b>Дата</b></td><td><b>Наименование</b></td><td><b>План</b></td><td><b>Факт</b></td><td><b>Действия</b></td></tr>
	";
	$Worker_Meetings_Sql = mysql_query("SELECT *,meets.name as 'mname',meetings.id as 'mid',DATE_FORMAT(meetings.date,'%d.%m.%Y %H:%i') as 'mdate'  FROM meetings LEFT JOIN meets ON(meetings.meeting_type=meets.id) WHERE workers_id='$id' ORDER by meetings.date DESC limit 0,$to;");
	while($Worker_Meetings_Rows = mysql_fetch_array($Worker_Meetings_Sql))
		{
		$Meet_Info=$Worker_Meetings_Rows['mname']." за ".$Worker_Meetings_Rows['mdate'];
		if (strlen($Worker_Meetings_Rows['pcom'])>30) {$pcom=$Worker_Meetings_Rows['pcom'];} else {$pcom=$Worker_Meetings_Rows['pcom'];}
		if (strlen($Worker_Meetings_Rows['fcom'])>30) {$fcom=$Worker_Meetings_Rows['fcom'];} else {$fcom=$Worker_Meetings_Rows['fcom'];}
		echo "<tr id=\"hrow".$Worker_Meetings_Rows['mid']."\"><td>".$Worker_Meetings_Rows['mdate']."</td><td>".$Worker_Meetings_Rows['mname']."</td><td width='129px' style='word-wrap: break-word;width:129px;'>".$Worker_Meetings_Rows['p']." <div id=\"showmeetcomment\" style='word-wrap: break-word;width:129px;'><span style=\"font-size:11px;\">".$pcom."</span></div></td><td width='129px' style='word-wrap: break-word;width:129px;'>".$Worker_Meetings_Rows['f']." <div id=\"showmeetcomment\" style='word-wrap: break-word;width:129px;'><span style=\"font-size:11px;\">".$fcom."</span></div></td><td><a href=\"#edit\" class=\"\" onclick=\"editmeetingmodal(".$Worker_Meetings_Rows['mid'].")\"><img width=\"17px\" src=\"/img/edit.png\" alt=\"Редактировать\" title=\"Редактировать\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"#delete\" onclick=\"deletemeetmodal(".$Worker_Meetings_Rows['mid'].",'".$Meet_Info."');\"><img width=\"17px\" src=\"/img/delete.png\" alt=\"Удалить\" title=\"Удалить\"></a></td></tr>";
		}
	echo "</table><center><a href=\"#hide\" onclick=\"hideblock('historyarea');\">- Скрыть -</a>&nbsp;&nbsp;&nbsp;<a href=\"#load\" onclick=\"showhistory(".$id.",".$to.");\">- Загрузить еще 20 -</a></center>";

	}

else {die('Попытка взлома2');}
?>