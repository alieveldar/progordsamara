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
	$sqlolddeptname="SELECT * FROM workers WHERE id='$id'";
	$resolddeptname=mysql_query($sqlolddeptname);
	$userinfoolddeptname=mysql_fetch_array($resolddeptname);
	returneditworkerform($id=$userinfoolddeptname[id],$name=$userinfoolddeptname[name],$working=$userinfoolddeptname[working],$dept="",$deptid=$userinfoolddeptname[dept_id],$allowsafe=1, $message="");

	}

else {die('Попытка взлома2');}
?>

