<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Попытка взлома1');
	}
else if (($_POST['nowdept']!=null) && ($_POST['newworkername']!="") && ($_POST['newworking']!="") && ($_POST['editworkerid']!="") && ($_POST['workernowname']!="") && ($_POST['nowworking']!="") && ($_POST['nowdeptid']!=""))
	{
	if (($_POST['nowdept']==$_POST['nowdeptid']) & ($_POST['newworkername']==$_POST['workernowname']) & ($_POST['newworking']==$_POST['nowworking']))
	 {
	returneditworkerform($id=$_POST[editworkerid],$name=$_POST[workernowname],$working=$_POST[nowworking],$dept="",$deptid=$_POST[nowdeptid],$allowsafe=1, $message="<font color=red>Ошибка! Вы не внесли изменения в форме!</font>");
	 }
	 else {
	 		$checknewname=mysql_real_escape_string($_POST['newworkername']);
			$sqlwcheck="SELECT * FROM workers WHERE name='$checknewname'";
			$reswcheck=mysql_query($sqlwcheck);
			$userinfowcheck=mysql_fetch_array($reswcheck);
			if ((!isset($userinfowcheck['name'])) || ($_POST['newworkername']==$_POST['workernowname'])) {
				$newworkerdeptid=$_POST['nowdept'];
				$newworkername=$_POST['newworkername'];
				$newworkerworking=$_POST['newworking'];
				$editworker=$_POST['editworkerid'];
	 			$updateworker = mysql_query ("UPDATE workers SET name='$newworkername', dept_id='$newworkerdeptid', working='$newworkerworking' WHERE id='$editworker'");
				if ($updateworker==true) {
					returneditworkerform($id=$_POST[editworkerid],$name=$_POST[workernowname],$working=$_POST[nowworking],$dept="",$deptid=$_POST[nowdeptid],$allowsafe=0, $message="<font color=green>Успешное сохранение!</font>");
				echo <<<HTML
				<script language="JavaScript">
				document.getElementById('editworkerbutton').innerHTML = "";
				</script>
HTML;
				}
				else {
				returneditworkerform($id=$_POST[editworkerid],$name=$_POST[workernowname],$working=$_POST[nowworking],$dept="",$deptid=$_POST[nowdeptid],$allowsafe=1, $message="<font color=red>Ошибка при внесении данных в базу!</font>");
				}
				}
			else {
				returneditworkerform($id=$_POST[editworkerid],$name=$_POST[workernowname],$working=$_POST[nowworking],$dept="",$deptid=$_POST[nowdeptid],$allowsafe=1, $message="<font color=red>Ошибка! Такой сотрудник уже существует!</font>");
			}
	 }
}
else {
returneditworkerform($id=$_POST[editworkerid],$name=$_POST[workernowname],$working=$_POST[nowworking],$dept="",$deptid=$_POST[nowdeptid],$allowsafe=1, $message="<font color=red>Ошибка! Вы не заполнили форму!</font>");
}
?>

