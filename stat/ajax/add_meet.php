<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Ошибка авторизации!');
	}

else if ($_POST['workerid']!="") //
	{
		$workerid=mysql_real_escape_string($_POST['workerid']);
		$update=0;
		$Error_Count=0;
		//ПРОВЕРКА
		
		$update_CI=1;
		if(!preg_match("|^[\d]*$|", $_POST['cp'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! СИ П Введено неверное число!";
			$update_CI=0;
			}
		if(!preg_match("|^[\d]*$|", $_POST['cf'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! СИ Ф Введено неверное число!";
			$update_CI=0;
			}
		if ((($_POST['cp']=="") && ($_POST['cf']=="")) || (($_POST['cp']=="0") && ($_POST['cf']=="0")) || (($_POST['cp']=="0") && ($_POST['cf']=="")) || (($_POST['cp']=="") && ($_POST['cf']=="0")))
		{
		$update_CI=0;
		}
		
		//ПРОВЕРКА
		$update_KP=1;
		if(!preg_match("|^[\d]*$|", $_POST['kp'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! КП П Введено неверное число!";
			$update_KP=0;
			}
		if(!preg_match("|^[\d]*$|", $_POST['kf'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! КП Ф Введено неверное число!";
			$update_KP=0;
			}
		if ((($_POST['kp']=="") && ($_POST['kf']=="")) || (($_POST['kp']=="0") && ($_POST['kf']=="0")) || (($_POST['kp']=="0") && ($_POST['kf']=="")) || (($_POST['kp']=="") && ($_POST['kf']=="0")))
		{
		$update_KP=0;
		}
		
		
		//ПРОВЕРКА
		$update_F=1;
		if(!preg_match("|^[\d]*$|", $_POST['fp'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! ФЭСИМ П Введено неверное число!";
			$update_F=0;
			}
		if(!preg_match("|^[\d]*$|", $_POST['ff'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! ФЭСИМ Ф Введено неверное число!";
			$update_F=0;
			}
		if ((($_POST['fp']=="") && ($_POST['ff']=="")) || (($_POST['fp']=="0") && ($_POST['ff']=="0")) || (($_POST['fp']=="0") && ($_POST['ff']=="")) || (($_POST['fp']=="") && ($_POST['ff']=="0")))
		{
		$update_F=0;
		}
		
		//ПРОВЕРКА
		$update_P=1;
		if(!preg_match("|^[\d]*$|", $_POST['pp'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! Прод П Введено неверное число!";
			$update_P=0;
			}
		if(!preg_match("|^[\d]*$|", $_POST['pf'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! Прод Ф Введено неверное число!";
			$update_P=0;
			}
		if ((($_POST['pp']=="") && ($_POST['pf']=="")) || (($_POST['pp']=="0") && ($_POST['pf']=="0")) || (($_POST['pp']=="0") && ($_POST['pf']=="")) || (($_POST['pp']=="") && ($_POST['pf']=="0")))
		{
		$update_P=0;
		}
		//ПРОВЕРКА
		$update_T=1;
		if(!preg_match("|^[\d]*$|", $_POST['tp'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! ТВ П Введено неверное число!";
			$update_T=0;
			}
		if(!preg_match("|^[\d]*$|", $_POST['tf'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! ТВ Ф Введено неверное число!";
			$update_T=0;
			}
		if ((($_POST['tp']=="") && ($_POST['tf']=="")) || (($_POST['tp']=="0") && ($_POST['tf']=="0")) || (($_POST['tp']=="0") && ($_POST['tf']=="")) || (($_POST['tp']=="") && ($_POST['tf']=="0")))
		{
		$update_T=0;
		}
		//ПРОВЕРКА
		$update_D=1;
		if(!preg_match("|^[\d]*$|", $_POST['dp'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! ТВ П Введено неверное число!";
			$update_D=0;
			}
		if(!preg_match("|^[\d]*$|", $_POST['df'])) 
			{
			$Error_Count++;
			$Error_Messages[]="Ошибка! ТВ Ф Введено неверное число!";
			$update_D=0;
			}
		if ((($_POST['dp']=="") && ($_POST['df']=="")) || (($_POST['dp']=="0") && ($_POST['df']=="0")) || (($_POST['dp']=="0") && ($_POST['df']=="")) || (($_POST['dp']=="") && ($_POST['df']=="0")))
		{
		$update_D=0;
		}
		//вносим
		if ($Error_Count>0)
			{
			echo <<<HTML
			<script language="JavaScript">
			document.getElementById('safeerrors').innerHTML = "<span style='color:red'>
HTML;
			foreach ( $Error_Messages as $Error_Message ) 
				{
				echo $Error_Message."<br>";
				}
			echo <<<HTML
			</span>";
			</script>
HTML;
		}
		else {
		$Parse_Date=date_parse_from_format("d-m-Y",$_POST['date']);
		$Sql_Date=$Parse_Date['year']."-".$Parse_Date['month']."-".$Parse_Date['day']." ".date("H:i:s");
		//заносим 1 тип
		if ($update_CI==1) 
			{
			$CP=mysql_real_escape_string($_POST['cp']);
			$CF=mysql_real_escape_string($_POST['cf']);
			$CPCOMM=mysql_real_escape_string($_POST['cpcomm']);
			$CFCOMM=mysql_real_escape_string($_POST['cfcomm']);
			$Add_Meeting = mysql_query ("INSERT INTO meetings (date, workers_id, meeting_type, p, pcom, f, fcom) VALUES ('$Sql_Date', '$workerid', '1', '$CP', '$CPCOMM', '$CF', '$CFCOMM')");
			if ($Add_Meeting==true) {$Replace_Button++;}
			}
		//заносим 2 тип
		if ($update_KP==1) 
			{
			$KP=mysql_real_escape_string($_POST['kp']);
			$KF=mysql_real_escape_string($_POST['kf']);
			$KPCOMM=mysql_real_escape_string($_POST['kpcomm']);
			$KFCOMM=mysql_real_escape_string($_POST['kfcomm']);
			$Add_Meeting = mysql_query ("INSERT INTO meetings (date, workers_id, meeting_type, p, pcom, f, fcom) VALUES ('$Sql_Date', '$workerid', '2', '$KP', '$KPCOMM', '$KF', '$KFCOMM')");
			if ($Add_Meeting==true) {$Replace_Button++;}
			}
		//заносим 3 тип
		if ($update_F==1) 
			{
			$FP=mysql_real_escape_string($_POST['fp']);
			$FF=mysql_real_escape_string($_POST['ff']);
			$FPCOMM=mysql_real_escape_string($_POST['fpcomm']);
			$FFCOMM=mysql_real_escape_string($_POST['ffcomm']);
			$Add_Meeting = mysql_query ("INSERT INTO meetings (date, workers_id, meeting_type, p, pcom, f, fcom) VALUES ('$Sql_Date', '$workerid', '3', '$FP', '$FPCOMM', '$FF', '$FFCOMM')");
			if ($Add_Meeting==true) {$Replace_Button++;}
			}
		//заносим 4 тип
		if ($update_P==1) 
			{
			$PP=mysql_real_escape_string($_POST['pp']);
			$PF=mysql_real_escape_string($_POST['pf']);
			$PPCOMM=mysql_real_escape_string($_POST['ppcomm']);
			$PFCOMM=mysql_real_escape_string($_POST['pfcomm']);
			$Add_Meeting = mysql_query ("INSERT INTO meetings (date, workers_id, meeting_type, p, pcom, f, fcom) VALUES ('$Sql_Date', '$workerid', '4', '$PP', '$PPCOMM', '$PF', '$PFCOMM')");
			if ($Add_Meeting==true) {$Replace_Button++;}
			}
		//заносим 5 тип
		if ($update_T==1) 
			{
			$TP=mysql_real_escape_string($_POST['tp']);
			$TF=mysql_real_escape_string($_POST['tf']);
			$TPCOMM=mysql_real_escape_string($_POST['tpcomm']);
			$TFCOMM=mysql_real_escape_string($_POST['tfcomm']);
			$Add_Meeting = mysql_query ("INSERT INTO meetings (date, workers_id, meeting_type, p, pcom, f, fcom) VALUES ('$Sql_Date', '$workerid', '5', '$TP', '$TPCOMM', '$TF', '$TFCOMM')");
			if ($Add_Meeting==true) {$Replace_Button++;}
			}
		//заносим 6 тип
		if ($update_D==1) 
			{
			$DP=mysql_real_escape_string($_POST['dp']);
			$DF=mysql_real_escape_string($_POST['df']);
			$DPCOMM=mysql_real_escape_string($_POST['dpcomm']);
			$DFCOMM=mysql_real_escape_string($_POST['dfcomm']);
			$Add_Meeting = mysql_query ("INSERT INTO meetings (date, workers_id, meeting_type, p, pcom, f, fcom) VALUES ('$Sql_Date', '$workerid', '6', '$DP', '$DPCOMM', '$DF', '$DFCOMM')");
			if ($Add_Meeting==true) {$Replace_Button++;}
			}
			
		if ($Replace_Button>0) 
			{
			echo <<<HTML
			<script language="JavaScript">
			document.getElementById('safebuttonarea').innerHTML = "<div class='btn btn-primary' onclick='addmeet($workerid);'>Сохранить</div>";
			document.getElementById('addmeetings').reset();
			document.getElementById('safeerrors').innerHTML = "";
			document.getElementById('safeerrors').innerHTML = "<font color=green>Сохранено!</font>";

			document.getElementById('W_Last_Meeting').innerHTML = "<span style='font-size:12px;'>(Последняя встреча: $Sql_Date) <a href='#history' style='' onclick='showhistory($workerid,0);'>История</a></span>";			
			</script>
HTML;

			}
		//echo "Обновить СИ ". $update_CI."<br>Обновить КП ".$update_KP."<br>Обновить ФЭСИМ? ".$update_F."<br>Обновить Прод? ".$update_P."<br>Обновить ТВ? ".$update_T."<br>Обновить Досбор? ".$update_D;
		}
		
	}		
else {
echo "Ошибка! Сотрудник не определен!";
}
?>
<!--
cp
cpcomm
cf
cfcomm
/*		if ($insert>0) 
			{
			echo <<<HTML
			<script language="JavaScript">
			document.getElementById('safebuttonarea').innerHTML = "<div class='btn btn-success disabled'>Сохранено</div>";
			</script>
HTML;
			}

		}
*/

			foreach ( $Error_Messages as $Error_Message ) 
				{
				echo $Error_Message."<br>";
				}

-->

