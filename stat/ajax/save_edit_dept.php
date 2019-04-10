<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Попытка взлома1');
	}

else if (($_POST['id']!="")&&($_POST['newdeptname']!=""))
	{
	if ($_POST['deptnowname']!=$_POST['newdeptname'])
	 {
		$newname=mysql_real_escape_string($_POST['newdeptname']);
		$id=mysql_real_escape_string($_POST['id']);
		$sqldeptcheck="SELECT * FROM dept WHERE name='$newname'";
		$resdeptcheck=mysql_query($sqldeptcheck);
		$userinfodeptcheck=mysql_fetch_array($resdeptcheck);
		if (!isset($userinfodeptcheck['name']))
			{
			$updatedept = mysql_query ("UPDATE dept SET name='$newname' WHERE id='$id'");
				if ($updatedept==true) {
					returneditdeptform($id=$_POST[id], $name=$_POST[newdeptname], $allowsafe=0, $message="<font color=green>Отдел успешно отредактирован!</font>");
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('editdeptbutton').innerHTML = "";
					</script>
HTML;
					}
				else {
				returneditdeptform($id=$_POST[id], $name=$_POST[newdeptname], $allowsafe=1, $message="<font color=red>Ошибка при внесении данных в базу!</font>");
					}
			}
		else 
		{
		returneditdeptform($id=$_POST[id], $name=$_POST[newdeptname], $allowsafe=1, $message="<font color=red>Ошибка! Такой отдел уже существует!</font>");
		}

	 }
	 else {
	 returneditdeptform($id=$_POST[id], $name=$_POST[newdeptname], $allowsafe=1, $message="<font color=red>Ошибка! Вы не внесли изменения в отдел!</font>");
	 }
}

else {
returneditdeptform($id=$_POST[id], $name=$_POST[newdeptname], $allowsafe=1, $message="<font color=red>Ошибка! Вы не заполнили форму!</font>");
}
?>

