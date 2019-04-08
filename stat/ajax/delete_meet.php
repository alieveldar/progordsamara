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
		$delete = mysql_query ("DELETE FROM meetings WHERE id='$delid';");
		if ($delete==true) {
		echo "<font color=green>Удаление завершено!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deletemeetbutton').innerHTML = "";
					var delrow = document.getElementById("hrow$delid");
					delrow.parentNode.removeChild(delrow);
					</script>
					
HTML;
					}
		else {
		echo "<font color=red>Ошибка при внесении данных в базу!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deletemeetbutton').innerHTML = "";
					</script>
HTML;
		}			
		

	}
	
else {
echo "<font color=red>Ошибка! Не удалось определить встречу!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deletemeetbutton').innerHTML = "";
					</script>
HTML;
}
?>

