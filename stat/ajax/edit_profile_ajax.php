<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Ошибка авторизации!');
	}

else if ($_POST['oldpass']!="") //изменение пароля
		{
		$old_password=md5(mysql_real_escape_string($_POST['oldpass']));
		$sqlpasscheck="SELECT * FROM users WHERE user_password='$old_password'";
		$respasscheck=mysql_query($sqlpasscheck);
		$userinfopasscheck=mysql_fetch_array($respasscheck);
		if (isset($userinfopasscheck['user_id'])) {
			if ($_POST['newpass']==$_POST['confirmnewpass']){
				if (strlen($_POST['confirmnewpass'])>4){
				$user_id=$userinfopasscheck['user_id'];
				$new_password=md5(mysql_real_escape_string($_POST['newpass']));
				$updatepassword = mysql_query ("UPDATE users SET user_password='$new_password' WHERE user_id='$user_id'");
					if ($updatepassword==true) {
					echo <<<HTML
					<script language="JavaScript">
					document.getElementById('profilesafebutton').innerHTML = "";
					</script>
HTML;
					returneditprofileform($id=$_GET[id],$allowsafe=0, $message="<font color=green>Пароль успешно изменен! Может потребоваться повторная авторизация.</font>");
					}
					else {
					returneditprofileform($id=$_GET[id],$allowsafe=1, $message="<font color=red>Ошибка! При обновлении базы данных!</font>");
					}
				}
				else {
				returneditprofileform($id=$_GET[id],$allowsafe=1, $message="<font color=red>Ошибка! Минимальная длина нового пароля 5 символов!</font>");
				}
			}
			else {
			returneditprofileform($id=$_GET[id],$allowsafe=1, $message="<font color=red>Ошибка! Введенные пароли не совпадают!</font>");
			}
		}
		else {
		returneditprofileform($id=$_GET[id],$allowsafe=1, $message="<font color=red>Ошибка! Пользователь не найден!</font>");
		}
		}

else {
returneditprofileform($id=$_GET[id],$allowsafe=1, $message="<font color=red>Ошибка! Вы не ввели данные в форму!</font>");
}
?>


