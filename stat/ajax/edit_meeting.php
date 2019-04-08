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
	$sqloldmeeting="SELECT *, DATE_FORMAT(date,'%d-%m-%Y') as 'Mdate' FROM meetings WHERE id='$id'";
	$resoldmeeting=mysql_query($sqloldmeeting);
	$oldmeetingrow=mysql_fetch_array($resoldmeeting);
	returneditmeetform($id=$oldmeetingrow['id'],$date=$oldmeetingrow['Mdate'],$type_id=$oldmeetingrow['meeting_type'],$p=$oldmeetingrow['p'],$f=$oldmeetingrow['f'],$pcom=$oldmeetingrow['pcom'],$fcom=$oldmeetingrow['fcom'], $allowsafe=1, $message="");
	}

else {die('Попытка взлома2');}
?>

