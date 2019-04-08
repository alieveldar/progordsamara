<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Ошибка авторизации!');
	}

else if ($_POST['deptname']!="") //
		{
		$deptname=mysql_real_escape_string($_POST['deptname']);
		
		$sqldeptcheck="SELECT * FROM dept WHERE name='$deptname'";
		$resdeptcheck=mysql_query($sqldeptcheck);
		$userinfodeptcheck=mysql_fetch_array($resdeptcheck);
		if (!isset($userinfodeptcheck['name']))
		{
			$date=date("y-m-d H:i:s");
			$cash=md5(date('d.m.y H:i:s'));
			$result = mysql_query ("INSERT INTO dept (name, date, cash) VALUES ('$deptname', '$date', '$cash')");
				if ($result==true) {
				returnadddeptform($id=0,$allowsafe=0, $message="<font color=green>Успешное сохранение!</font>");
				echo <<<HTML
				<script language="JavaScript">
				document.getElementById('adddeptbutton').innerHTML = "";
				</script>
HTML;
									}
				else {
			returnadddeptform($id=0,$allowsafe=1, $message="<font color=red>Ошибка! Не удалось внести данные в базу!</font>");
			}
		}
		else {
		returnadddeptform($id=0,$allowsafe=1, $message="<font color=red>Ошибка! Такой отдел уже существует!</font>");
		}

		}
else {
returnadddeptform($id=0,$allowsafe=1, $message="<font color=red>Ошибка! Вы не ввели название отдела!</font>");
}
?>


