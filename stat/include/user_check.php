<?
mysql_connect("localhost", "admin_samara", "IJXeKV5I9M");
mysql_select_db("admin_stat");
mysql_query("SET NAMES utf8");
$userinfo='';
$state='0';
if( (isset($_COOKIE['login'])) & (isset($_COOKIE['pass'])) ) {// если в куках лежит логин и зашифрованый пароль
  if (!isset($_GET['exit'])) {// если кнопка выход не была нажата
    $login=$_COOKIE['login'];
    $pass=$_COOKIE['pass'];
    
    // проверяем наличие пользователя в БД и достаём оттуда пароль
    $sql="SELECT * FROM users WHERE user_login='$login'";
    $res=mysql_query($sql);
    if(mysql_num_rows($res)>0){// если пользователь есть в БД
      $userinfo = mysql_fetch_array($res);// в этой переменной лежит пароль из БД
      if(strcmp($pass,md5($userinfo['user_password'])) == 0) { //проверяем схожесть пароля из БД с паролем из куков
	
	// достаём все данные из БД
	$sql="SELECT * FROM users WHERE user_login='$login'";
	$res=mysql_query($sql);
	$userinfo=mysql_fetch_array($res); // в этой переменной будет лежать вся информация о пользователе из БД
	$time=time();
	// устанавливаем куки для запоминания статуса пользователя
	//setcookie("login",$login,$time+99999);
	//setcookie("pass",$pass,$time+99999);
	$state = 1;// статус, если 1, тогда пользователь авторизован
      }
    }
  } else {
    //обнуляем куки, если была нажата кнопка выход
    setcookie("login");
    setcookie("pass");
  }
}
if($state != 1) {// если после проверки куков, оказалось, что пользователь не авторизован, то идем дальше
  if( (isset($_POST['login'])) & (isset($_POST['pass'])) ){ // если пользователь ввёл логин и пароль
	if ($_POST['login']=="") {$loginerror="<font color=\"red\">Поле логин не заполнено</font>";}
	if ($_POST['pass']=="") {$passerror="<font color=\"red\">Поле пароль не заполнено</font>";}

  $login = mysql_real_escape_string($_POST['login']);	
  
  // проверяем наличие пользователя в БД и достаём оттуда пароль
  $sql = "SELECT * FROM users WHERE user_login='$login'";
  $res = mysql_query($sql);
    if(mysql_num_rows($res)>0) {// если пользователь есть в БД
      $userinfo = mysql_fetch_array($res);// в этой переменной лежит пароль из БД и номер пользователя
      $pass = md5($_POST['pass']);
      if(strcmp($pass,$userinfo['user_password'])==0){
	
	// достаём все данные из БД
	$sql="SELECT * FROM users WHERE user_login='$login'";
	$res=mysql_query($sql);
	$userinfo=mysql_fetch_array($res);// в этой переменной будет лежать вся информация о пользователе из БД
	$time=time();
	// устанавливаем куки для запоминания статуса пользователя, пароль шифруем
	setcookie("login", $login, $time+99999);
	setcookie("pass", md5($pass), $time+99999);
	$state = 1;// статус, если 1, тогда пользователь авторизован
      }
      else { $passerror="<font color=\"red\">Ошибка логина/пароля</font>"; $loginerror="";}
    }
    elseif (($_POST['login']!="") && ($_POST['pass']!="")) { 
           $loginerror="";
           $passerror="<font color=\"red\">Пользователь не найден</font>";
         }
  }
}
?>