<?
include('../include/user_check.php'); // проверка авторизации пользователя
header("Content-type: text/html; charset=utf-8");
include('../include/functions.php'); // функции системы

if ($state != 1)
	{ // если пользователь не авторизован то умираем
                $state=0;
		die('Die hacking!');
	}

else if (isset($_POST['datef'])) 
	{
	$meetsarray=returnmeetsarray(); //масив с именами встреч

							$Parse_Datef=date_parse_from_format("d-m-Y",$_POST['datef']);
							$Sql_Datef=$Parse_Datef['year']."-".$Parse_Datef['month']."-".$Parse_Datef['day']." 00:00:00";
							
							$Parse_Datet=date_parse_from_format("d-m-Y",$_POST['datet']);
							$Sql_Datet=$Parse_Datet['year']."-".$Parse_Datet['month']."-".$Parse_Datet['day']." 23:59:59";
/*if ($Parse_Datef>$Parse_Datet) {
echo <<<HTML
<div class="alert alert-error">
<strong>Ошибка! Конечная дата не может быть меньше, чем начальная!</strong>
</div>
HTML;
}
*/

echo "<table class=\"table table-striped table-hover\">";
 echo '<tr><td><b>№</b></td><td><b>ФИО</b></td><td><b>Должность</b></td><td><b>Дата</b></td><td><b>'.$meetsarray[0][name].'</b></td><td><b>'.$meetsarray[1][name].'</b></td><td><b>'.$meetsarray[2][name].'</b></td><td><b>'.$meetsarray[3][name].'</b></td><td><b>'.$meetsarray[4][name].'</b></td><td><b>'.$meetsarray[5][name].'</b></td><td><b>Эфф.Л</b></td><td><b>Эфф</b></td></tr>'; // то выводим новый тип
$query = "SELECT DATE_FORMAT(workers.date,'%d.%m.%Y %H:%i') as 'date',dept.name as 'dname', dept.id as 'did', workers.name as 'name',workers.dept_id as 'dept_id',workers.working as 'working', workers.id as 'wid'  FROM dept INNER JOIN workers ON ( dept.id = workers.dept_id ) ORDER BY dept.name";
$res = mysql_query($query);
$data = array();
while($row = mysql_fetch_assoc($res)){
    $data[] = $row; // получаем данные в массив
}
//print_r($data);
$group = $data[0]['dname']; // выбираем первый тип и помещаем в переменную group
echo '<tr><td colspan=12><b>' .$group. '</b></td></tr>'; // выводим первый тип
/* проходимся по массиву */
foreach($data as $item){
    /* если текущий тип не совпадает с имеющимся в переменной group */
    if($group != $item['dname']){
	echo "<tr><td></td><td>ИТОГО</td><td></td><td></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
            echo '<tr><td colspan=12><b>' .$item['dname']. '</b></td></tr>'; // то выводим новый тип
            $group = $item['dname']; // и заносим новый тип в переменную group
			$workerscount=0;

			
    }
	$workerscount++;
    /* если же текущий тип совпадает с имеющимся в переменной group, то цикл пропускаем */
    echo '<tr><td>'.$workerscount.'</td><td>'.$item['name']. ' </td><td> '; // выводим текст
    echo $item['working']. "</td><td>";
	echo returnbeginenddates($item['wid']);
	echo "</td>"; 
				
					returallmeetsef($item['wid'],$Sql_Datef,$Sql_Datet);
					echo "</tr>";
}					
echo "<tr><td></td><td>ИТОГО</td><td></td><td></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";



echo "</table>";
	}

else {die('Die hacking!');}
?>