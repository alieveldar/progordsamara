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
	$sqlolddeptname="SELECT * FROM dept WHERE id='$id'";
	$resolddeptname=mysql_query($sqlolddeptname);
	$userinfoolddeptname=mysql_fetch_array($resolddeptname);
	returneditdeptform($id=$userinfoolddeptname[id], $name=$userinfoolddeptname[name], $allowsafe=1, $message="");

	}

else {die('Попытка взлома2');}
?>

