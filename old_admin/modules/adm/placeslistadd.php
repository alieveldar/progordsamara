<?
### НАСТРОЙКИ САЙТА
if ($GLOBAL["sitekey"]==1 && $GLOBAL["database"]==1) {

// СОХРАНЕНИЕ ПОЛЕЙ И ФОРМ
	$P=$_POST; $alias="places";
	if (isset($P["savebutton"])) {
		$q="INSERT INTO `".$alias."_list` (`stat`,`name`, `pid`) VALUES ('0', '".str_replace("'", "\'", $P["dname"])."', '1')";
		$_SESSION["Msg"]="<div class='SuccessDiv'>Новая публикация успешно создана!</div>"; $data=DB($q); $last=DBL(); 
		@header("location: ?cat=adm_placeslistedit&id=".$last); exit();
	}

	$AdminText='<h2>Добавление материала</h2>'.$_SESSION["Msg"];
	$AdminText.="<form action='".$_SERVER["REQUEST_URI"]."' enctype='multipart/form-data' method='post'>";

	### Основные данные
	$AdminText.="<div class='RoundText'><table>".'<tr class="TRLine0"><td style="width:22%;"></td><td style="width:78%;"></td></tr>
	<tr class="TRLine0"><td class="VarText">Название<star>*</star></td><td class="LongInput"><input name="dname" id="dname" type="text" class="JsVerify2" maxlength="255" ></td><tr>'."</table></div>";
	$AdminText.="<div class='CenterText'><input type='submit' name='savebutton' id='savebutton' class='SaveButton' value='Создать запись'></div>";

// ПРАВАЯ КОЛОНКА
	$AdminRight="</form>";
}





$_SESSION["Msg"]="";
?>