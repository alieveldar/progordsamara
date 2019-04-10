<? 
echo <<<HTML
<div class="row-fluid">
        <h2>$Dept_Text[Name] <a style="font-size: 14px !important;line-height: 40px !important;" href="#adddept" class="adddept" data-toggle="modal">$Dept_Text[Add_Dept]</a></h2>
HTML;
echo <<<HTML
	<!-- adddept -->
    <div id="adddept" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">$Dept_Text[Add_Modal_Name]</h3>
    </div>
    <div class="modal-body" id="adddeptform">
    <p>
HTML;
returnadddeptform($id=$id,$allowsafe=1, $message="");
echo <<<HTML
	</p>
    </div>
    <div class="modal-footer">
    <button id="adddeptclosemodal" class="btn" data-dismiss="modal" aria-hidden="true">$App_Template[Close_Button]</button>
	<div id="adddeptbutton" style="display:inline-block;"><button class="btn btn-primary" onclick="adddept();">$App_Template[Save_Button]</button></div>
    </div>
    </div>
	<!-- edit dept-->
    <div id="editdept" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">$Dept_Text[Edit_Modal_Name]</h3>
    </div>
    <div class="modal-body" id="editdeptform">
    <p>
	<form onsubmit="return editdeptsave();" id="editdept">
	<div id="newdeptnameblock">
	</div>
	</form>
    </div>
    <div class="modal-footer">
    <button id="closeeditdeptbutton" class="btn" data-dismiss="modal" aria-hidden="true">$App_Template[Close_Button]</button>
	<div id="editdeptbutton" style="display:inline-block;"><button class="btn btn-primary" onclick="editdeptsave();">$App_Template[Save_Button]</button></div>
    </div>
    </div>
	<!-- delete dept-->
    <div id="deletedept" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">$Dept_Text[Delete_Modal_Name]</h3>
    </div>
    <div class="modal-body" id="deletedeptform">
    <p>
	<form onsubmit="return deletedept();" id="editdept">
	<div id="deletedeptarea">
	</div>
	</form>
    </div>
    <div class="modal-footer">
    <button id="closedeletedeptbutton" class="btn" data-dismiss="modal" aria-hidden="true">$App_Template[Close_Button]</button>
	<div id="deletedeptbutton" style="display:inline-block;"><button class="btn btn-primary" onclick="dodeletedept();">$App_Template[Delete_Button]</button></div>
    </div>
    </div>
HTML;
$deptcount=0;
$deptsql = mysql_query("select dept.id as 'id', dept.name as 'name', DATE_FORMAT(dept.date,'%d.%m.%Y %H:%i') as 'date', sum(dept.id = workers.dept_id) as 'wname' from dept LEFT JOIN workers ON ( dept.id = workers.dept_id ) group by dept.id;");
echo $Dept_Text['Table_Start'];
echo $Dept_Text['Table_Head'];
while($deptrow = mysql_fetch_array($deptsql))
{
$deptcount++;
echo "<tr><td>".$deptcount."</td><td>".$deptrow[name]."</td><td>".$deptrow[wname]."</td><td>".$deptrow[date]."</td><td><a href=\"#edit\" class=\"\" onclick=\"editdeptmodal(".$deptrow[id].")\"><img width=\"17px\" src=\"/img/edit.png\" alt=\"".$App_Template[Edit_Button]."\" title=\"".$App_Template[Edit_Button]."\"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"#delete\" onclick=\"deletedeptmodal(".$deptrow[id].",'".$deptrow[name]."');\"><img width=\"17px\" src=\"/img/delete.png\" alt=\"".$App_Template[Delete_Button]."\" title=\"".$App_Template[Delete_Button]."\"></a></td></tr>";
}
echo "</table>";
?>