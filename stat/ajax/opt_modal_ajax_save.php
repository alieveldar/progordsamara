<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Попытка взлома1');
	}

else if (isset($_GET['id'])) //ставим метку к заказу
	{
	echo "<font color=green>Успешное сохранение ".$_GET['id']."</font>";
	}

else {die('Попытка взлома2');}
?>

