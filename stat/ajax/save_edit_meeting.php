<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы
	$mid=mysql_real_escape_string($_POST['chmid']);
	$Parse_Date=date_parse_from_format("d-m-Y",$_POST['changemeetdate']);
	$Sql_Date=$Parse_Date['year']."-".$Parse_Date['month']."-".$Parse_Date['day']." ".date("H:i:s");
	$mtype=mysql_real_escape_string($_POST['nowtype']);
	$p=mysql_real_escape_string($_POST['chp']);
	$f=mysql_real_escape_string($_POST['chf']);
	$pcom=mysql_real_escape_string($_POST['chpcom']);
	$fcom=mysql_real_escape_string($_POST['chfcom']);

	
if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Попытка взлома1');
	}

else if ($_POST['chmid']!="" && $_POST['changemeetdate']!="" && $_POST['nowtype']!="")
	{
	$doupdate=1;
		if(!preg_match("|^[\d]*$|", $_POST['chp'])) 
			{
			$Error_Count++;
			$doupdate=0;
			}
		if(!preg_match("|^[\d]*$|", $_POST['chf'])) 
			{
			$Error_Count++;
			$doupdate=0;
			}
		if ((($_POST['chp']=="") && ($_POST['chf']=="")) || (($_POST['chp']=="0") && ($_POST['chf']=="0")) || (($_POST['chp']=="0") && ($_POST['chf']=="")) || (($_POST['chp']=="") && ($_POST['chf']=="0")))
		{
		$doupdate=0;
		}
	if ($doupdate>0)
		{
		$updatemeet = mysql_query ("UPDATE meetings SET meeting_type='$mtype', p='$p', f='$f', pcom='$pcom', fcom='$fcom' WHERE id='$mid';");
				if ($updatemeet==true) {
				returneditmeetform($id=$mid,$date=$_POST['changemeetdate'],$type_id=$mtype,$p=$p,$f=$f,$pcom=$pcom,$fcom=$fcom, $allowsafe=0, $message="");
				echo <<<HTML
				<font color="green">Успешное сохранение!</font>
				<script language="JavaScript">
				document.getElementById('editmeetbutton').innerHTML = "";
				</script>
HTML;
				}
				else {
				returneditmeetform($id=$mid,$date=$_POST['changemeetdate'],$type_id=$mtype,$p=$p,$f=$f,$pcom=$pcom,$fcom=$fcom, $allowsafe=1, $message="<font color=red>Ошибка при внесении данных в базу!</font>");
				echo $mid."<br>".$Sql_Date."<br>".$mtype."<br>".$p."<br>".$f."<br>".$pcom."<br>".$fcom."<br>";
				}
		}
	else 
		{
		returneditmeetform($id=$mid,$date=$_POST['changemeetdate'],$type_id=$mtype,$p=$p,$f=$f,$pcom=$pcom,$fcom=$fcom, $allowsafe=1, $message="<font color=red>Ошибка! Форма заполнена неверно!</font>");
		}
	}
else {
returneditmeetform($id=$mid,$date=$_POST['changemeetdate'],$type_id=$mtype,$p=$p,$f=$f,$pcom=$pcom,$fcom=$fcom, $allowsafe=1, $message="<font color=red>Ошибка! Не удалось определить встречу!</font>");
}
?>

