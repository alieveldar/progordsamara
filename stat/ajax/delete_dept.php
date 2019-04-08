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
	$todelname=0;
	$delid=mysql_real_escape_string($_POST['id']);
	$deptsql = mysql_query("select * from workers WHERE dept_id='$delid';");
	while($deptrow = mysql_fetch_array($deptsql))
		{
		$todelname++;
		}
	if ($todelname==0) 
		{
		$deletedeptnow= mysql_query ("DELETE FROM dept WHERE id='$delid';");
		if ($deletedeptnow==true) {
		echo "<font color=green>Удаление завершено!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deletedeptbutton').innerHTML = "";
					</script>
HTML;
					}
		else {
		echo "<font color=red>Ошибка при внесении данных в базу!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deletedeptbutton').innerHTML = "";
					</script>
HTML;
		}			
		

		}
	else 
		{
		echo "<font color=red>Ошибка! Перенесите или удалите сотрудников из отдела для удаления!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deletedeptbutton').innerHTML = "";
					</script>
HTML;
		}
	}
else {
echo "<font color=red>Ошибка! Не удалось определить отдел!</font>";
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('deletedeptbutton').innerHTML = "";
					</script>
HTML;
}
?>

