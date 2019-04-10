<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Ошибка авторизации!');
	}

else if (($_POST['name']!="") && ($_POST['working']!="") && ($_POST['workerdept']!="null")) //
		{
		$workername=mysql_real_escape_string($_POST['name']);
		$workerwork=mysql_real_escape_string($_POST['working']);
		$workerdept=mysql_real_escape_string($_POST['workerdept']);
		
		$sqlworkerscheck="SELECT * FROM workers WHERE name='$workername'";
		$resworkerscheck=mysql_query($sqlworkerscheck);
		$userinfoworkerscheck=mysql_fetch_array($resworkerscheck);
		if (!isset($userinfoworkerscheck['name']))
		{
			$date=date("y-m-d H:i:s");
			$cash=md5(date('d.m.y H:i:s'));
			$result = mysql_query ("INSERT INTO workers (name, dept_id, working, date, cash) VALUES ('$workername', '$workerdept', '$workerwork', '$date', '$cash')");
				if ($result==true) {
				returnaddworkersform($id=0,$allowsafe=0, $message="<font color=green>Успешное сохранение!</font>");
				echo <<<HTML
				<script language="JavaScript">
				document.getElementById('addworkersbutton').innerHTML = "";
				</script>
HTML;
									}
				else {
			returnaddworkersform($id=0,$allowsafe=1, $message="<font color=red>Ошибка! Не удалось внести данные в базу!</font>");
			}
		}
		else {
		returnaddworkersform($id=0,$allowsafe=1, $message="<font color=red>Ошибка! Такой сотрудник уже существует!</font>");
		}

		}
else {
returnaddworkersform($id=0,$allowsafe=1, $message="<font color=red>Ошибка! Вы не заполнили форму!</font>");
}
?>


