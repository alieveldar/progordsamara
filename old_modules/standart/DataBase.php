<?
if ($GLOBAL["sitekey"]==1) {

	$DataBaseServer="mysql.local";
	$DataBaseName="admin_samara";
	$DataBaseLogin="admin_samara2";
	$DataBasePass="gnsQXSJgXNou";
	$DataBaseCode="utf8_general_ci";
	$DataSetNames="utf8";
	### Соединение с базой данных
	@mysql_connect($DataBaseServer, $DataBaseLogin, $DataBasePass); @mysql_select_db($DataBaseName);
	### Установки кордировки подключения
	@mysql_query("set character_set_client='".$DataBaseCode."'");
	@mysql_query("set character_set_results='".$DataBaseCode."'");
	@mysql_query("set collation_connection='".$DataBaseCode."'");
	@mysql_query("set names ".$DataSetNames);

	date_default_timezone_set('Indian/Mauritius');

	if (mysql_error()=="") { $GLOBAL["log"].="<i>Успешно</i>: Соединение с базой данных.<hr>"; $GLOBAL["database"]=1;
	} else { $GLOBAL["log"].="<u>ОШИБКА</u>: Соединение с базой данных.<hr>"; $GLOBAL["database"]=0; }
} else {
	$GLOBAL["log"].="<u>ОШИБКА</u>: Соединение с базой данных запрещено.<hr>"; $GLOBAL["database"]=0;
}


### получение микро времени
function GetMicroTime($pre=4) { list($usec, $sec)=explode(" ", microtime()); $time=(float)$usec+(float)$sec; return($time); }

### иконка для админки
function AIco($n, $title='') { return("<img src='/admin/images/icons/".$n.".png' valign='middle' title='$title' style='margin:-2px 3px 0 0;'>"); }

### экранировние символов
function Dbcut($var) { $var=str_replace("'", "\'", $var); return($var); }

### убираем мусор из запроса по адресу страницы
function Dbsel($var) { $ar=array('"', "'", '&', '(', ')', ';', ',', '|', '=', '!'); $var=str_replace($ar, '', $var); return($var); }

### Функции работы с базой данных
function DB($query){
	global $GLOBAL; $tstart=GetMicroTime(); $data=array(); $sql=@mysql_query($query); if (mysql_error()!="") { $haveerror=" <u>[ОШИБКА]</u> "; } else { $haveerror=""; }
	$data["result"]=$sql; $data["total"]=@mysql_num_rows($sql); $tend=GetMicroTime(); $GLOBAL["sqlcount"]++; $GLOBAL["sqltime"]+=($tend-$tstart);
	$GLOBAL["log"].="<m>SQL</m>: <b>".round($tend-$tstart, 3)." с.</b> ".$query." - результат: ".$haveerror."<b>".$data["total"]."</b><hr>"; return $data;
}

### Получение последней вставленной строки
function DBL(){
	global $GLOBAL; $tstart=GetMicroTime(); $data=array(); $sql=@mysql_insert_id(); if (mysql_error()!="") { $haveerror=" <u>[ОШИБКА]</u> "; } else { $haveerror=""; } $tend=GetMicroTime();
	$GLOBAL["sqlcount"]++; $GLOBAL["sqltime"]+=($tend-$tstart); $GLOBAL["log"].="<m>SQL</m>: ".round($tend-$tstart, 3)." сек. <b>&laquo;LAST INSERT ID&raquo;</b> = ".$sql."<hr>"; return $sql;
}
?>
