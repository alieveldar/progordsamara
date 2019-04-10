<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Попытка взлома1');
	}

else if (isset($_POST['id'])) //ставим метку к заказу
	{
	echo "<form onsubmit=\"return deptsave(".$_POST['id'].");\" id=\"deptsave\">
	      <input id=\"saveinfo\" type=\"text\" placeholder=\"".$_GET['id']."\">
		  </form>";
	}

else {die('Попытка взлома2');}
?>


