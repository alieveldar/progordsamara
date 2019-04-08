<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Попытка взлома1');
	}

else if (($_POST['id']!=""))
	{
		$delid=mysql_real_escape_string($_POST['id']);
		$deleteworkernow= mysql_query ("DELETE FROM workers WHERE id='$delid';");
		$deleteworkermeetsnow= mysql_query ("DELETE FROM meetings WHERE workers_id='$delid';");
		if ($deleteworkernow==true) {
		echo "<font color=green>Удаление завершено!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deleteworkerbutton').innerHTML = "";
					</script>
HTML;
					}
		else {
		echo "<font color=red>Ошибка при внесении данных в базу!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deleteworkerbutton').innerHTML = "";
					</script>
HTML;
		}			
		

	}
	
else {
echo "<font color=red>Ошибка! Не удалось определить сотрудника!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deleteworkerbutton').innerHTML = "";
					</script>
HTML;
}
?>

