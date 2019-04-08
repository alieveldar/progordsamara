<? 
echo <<<HTML
<div class="row-fluid">
        <h2>$Workers_Text[Name] <a style="font-size: 14px !important;line-height: 40px !important;" href="#addworkers" class="addworkers" data-toggle="modal">$Workers_Text[Add_Worker]</a></h2>	

HTML;

echo <<<HTML
	<!-- addworkers -->
    <div id="addworkers" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">$Workers_Text[Add_Modal_Name]</h3>
    </div>
    <div class="modal-body" id="addworkersform">
    <p>
HTML;
returnaddworkersform($id=$id,$allowsafe=1, $message="");
echo <<<HTML
	</p>
    </div>
    <div class="modal-footer">
    <button id="addworkersclosemodal" class="btn" data-dismiss="modal" aria-hidden="true">$App_Template[Close_Button]</button>
	<div id="addworkersbutton" style="display:inline-block;"><button class="btn btn-primary" onclick="addworkers();">$App_Template[Save_Button]</button></div>
    </div>
    </div>
	
	
	<!-- edit worker-->
    <div id="editworker" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">$Workers_Text[Edit_Modal_Name]</h3>
    </div>
    <div class="modal-body" id="editworkerform">
    <p>
	<form onsubmit="return editworkersave();" id="editdept">
	<div id="newworkernameblock">
	</div>
	</form>
    </div>
    <div class="modal-footer">
    <button id="closeeditworkerbutton" class="btn" data-dismiss="modal" aria-hidden="true">$App_Template[Close_Button]</button>
	<div id="editworkerbutton" style="display:inline-block;"><button class="btn btn-primary" onclick="editworkersave();">$App_Template[Save_Button]</button></div>
    </div>
    </div>
	
	<!-- delete worker-->
    <div id="deleteworker" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">$Workers_Text[Delete_Modal_Name]</h3>
    </div>
    <div class="modal-body" id="deletedeptform">
    <p>
	<form onsubmit="return dodeleteworker();" id="deleteworker">
	<div id="deleteworkerarea">
	</div>
	</form>
    </div>
    <div class="modal-footer">
    <button id="closedeleteworkerbutton" class="btn" data-dismiss="modal" aria-hidden="true">$App_Template[Close_Button]</button>
	<div id="deleteworkerbutton" style="display:inline-block;"><button class="btn btn-primary" onclick="dodeleteworker();">$App_Template[Delete_Button]</button></div>
    </div>
    </div>
	
HTML;
?>



<?
echo "<table class=\"table table-striped table-hover\">";
 echo '<tr><td><b>№</b></td><td><b>ФИО</b></td><td><b>Должность</b></td><td><b>Дата</b></td><td><b>Действия</b></td></tr>'; // то выводим новый тип
$query = "SELECT DATE_FORMAT(workers.date,'%d.%m.%Y %H:%i') as 'date',dept.name as 'dname', dept.id as 'did', workers.name as 'name',workers.dept_id as 'dept_id',workers.working as 'working', workers.id as 'wid'  FROM dept INNER JOIN workers ON ( dept.id = workers.dept_id ) ORDER BY dept.name";
$res = mysql_query($query);
$data = array();
while($row = mysql_fetch_assoc($res)){
    $data[] = $row; // получаем данные в массив
}
//print_r($data);
$group = $data[0]['dname']; // выбираем первый тип и помещаем в переменную group
echo '<tr><td colspan=5><b>' .$group. '</b></td></tr>'; // выводим первый тип
/* проходимся по массиву */
foreach($data as $item){
    /* если текущий тип не совпадает с имеющимся в переменной group */
    if($group != $item['dname']){
            echo '<tr><td colspan=5><b>' .$item['dname']. '</b></td></tr>'; // то выводим новый тип
            $group = $item['dname']; // и заносим новый тип в переменную group
			$workerscount=0;
			
    }
	$workerscount++;
	 
    /* если же текущий тип совпадает с имеющимся в переменной group, то цикл пропускаем */
    echo '<tr><td>'.$workerscount.'</td><td>'.$item['name']. ' </td><td> '; // выводим текст
    echo $item['working']. "</td><td>".$item['date']."</td><td><a href=\"#edit\" class=\"\" onclick=\"editworkermodal(".$item['wid'].")\"><img width=\"17px\" src=\"/img/edit.png\" alt=\"Редактировать\" title=\"Редактировать\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"#delete\" onclick=\"deleteworkermodal(".$item['wid'].",'".$item['name']."');\"><img width=\"17px\" src=\"/img/delete.png\" alt=\"Удалить\" title=\"Удалить\"></a></td></tr>"; 
}

echo "</table>";
?>