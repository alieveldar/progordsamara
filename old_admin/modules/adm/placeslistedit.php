<?
### КРОССЛИНКОВКА СТРАНИЦ
if ($GLOBAL["sitekey"]==1 && $GLOBAL["database"]==1) {
	global $pg; $alias="places"; $table=$alias."_items"; $table2=$alias."_list";
	$data=DB("SELECT * FROM `$table2` WHERE (`id`=".(int)$id.") LIMIT 1"); @mysql_data_seek($data["result"], 0); $action=@mysql_fetch_array($data["result"]); if ($action["stat"]==1) { $chk="checked"; } if ($action["vip"]==1) { $chk3="checked"; }
	
	// СОХРАНЕНИЕ ПОЛЕЙ И ФОРМ
	$P=$_POST; if (isset($P["savebutton"])) {
		$ROOT=$_SERVER['DOCUMENT_ROOT']; require 'actionsResizePhoto.php'; $pics = $action['pics']; $pic = $action['pic'];
		if($pic != $P["pic"]){ if ($pic){ foreach ($GLOBAL['AutoPicPaths'] as $path=>$size) { @unlink($ROOT."/userfiles/".$path."/".$pic); }}	$pic = $P["pic"]; if($pic) { actionsResizePhoto($pic); rename($ROOT."/userfiles/temp/".$pic, $ROOT."/userfiles/picoriginal/".$pic); }	}
		if($pics){ $pics = explode('|', $pics); foreach ($pics as $key => $pici) { if(!in_array($pici, $P["attachment"])) { foreach ($GLOBAL['AutoPicPaths'] as $path=>$size) { @unlink($ROOT."/userfiles/".$path."/".$pici); } unset($pics[$key]);}}	}
		if($P["attachment"]){ foreach ($P["attachment"] as $pici) { if(is_array($pics) && in_array($pici, $pics)) { continue; } actionsResizePhoto($pici); rename($ROOT."/userfiles/temp/".$pici, $ROOT."/userfiles/picoriginal/".$pici); $pics[] = $pici;}} 
		
		if ($pics!="") { $pics = implode('|', $pics); } else { $pics=""; }
		
		$q="UPDATE `$table2` SET 
		`name`='".str_replace("'", "\'", $P['name'])."',
		`text`='".str_replace("'", "\'", $P['text'])."', 
		`vip`='$P[vip]', `pid`='$P[site]', `pic`='$pic', `pics`='$pics',
		`adres`='".str_replace("'", "\'", $P['adres'])."',
		`phone`='".str_replace("'", "\'", $P['phone'])."',
		`proezd`='".str_replace("'", "\'", $P['proezd'])."',
		`worktime`='".str_replace("'", "\'", $P['worktime'])."',
		`gps`='".str_replace("'", "\'", $P['gps'])."',
		`price`='".str_replace("'", "\'", $P['price'])."'
		WHERE (`id`='".$action['id']."')";
		DB($q); @header("location: ?cat=adm_placeslistedit&id=".$action['id']); exit();
	}
	
	$site=array(); $data=DB("SELECT `id`, `name` FROM `".$alias."_cats` ORDER BY `rate` DESC"); for ($i=0; $i<$data["total"]; $i++): @mysql_data_seek($data["result"],$i); $ar=@mysql_fetch_array($data["result"]); $site[$ar["id"]]=$ar["name"]; endfor;
	
	$AdminText='<h2>Редактирование: &laquo<span class="companyName">'.$action["name"].'</span>&raquo;</h2>'.$_SESSION["Msg"];
	$AdminText.='<link media="all" href="/modules/standart/multiupload/client/uploader2.css" type="text/css" rel="stylesheet"><script type="text/javascript" src="/modules/standart/multiupload/client/uploader.js"></script>';
	$AdminText.='<div class="RoundText"><form action="'.$_SERVER["REQUEST_URI"].'" enctype="multipart/form-data" method="post" onsubmit="return JsVerify();" class="actionForm"><table class="actionTable"><tr class="TRLine0"><td style="width:22%;"></td><td style="width:78%;"></td></tr>';
	$AdminText.="<tr class='TRLine0'><td width='1%'></td><td ><input name='vip' id='vip' type='checkbox' value='1' $chk3> <b>VIP</b></td></tr>";
	$AdminText.="<tr class='TRLine1'><td class='VarText'>Название</td><td class='LongInput'><input name='name' type='text' value='".$action['name']."'></td></tr>";
	$AdminText.='<tr class="TRLine0"><td class="VarText">Категория</td><td class="LongInput"><div class="sdiv"><select name="site">'.GetSelected($site, $action["pid"]).'</select></div></td><tr>';
	$AdminText.="<tr class='TRLine1'><td class='VarText'>Адрес</td><td class='LongInput'><input name='adres' type='text' value='".$action['adres']."'></td></tr>";
	$AdminText.="<tr class='TRLine0'><td class='VarText'>Телефон</td><td class='LongInput'><input name='phone' type='text' value='".$action['phone']."'></td></tr>";
	$AdminText.="<tr class='TRLine1'><td class='VarText'>Проезд</td><td class='LongInput'><input name='proezd' type='text' value='".$action['proezd']."'></td></tr>";
	$AdminText.="<tr class='TRLine0'><td class='VarText'>GPS через запятую</td><td class='LongInput'><input name='gps' type='text' value='".$action['gps']."'></td></tr>";
	$AdminText.="<tr class='TRLine1'><td class='VarText'>Время работы</td><td class='LongInput'><input name='worktime' type='text' value='".$action['worktime']."'></td></tr>";
	$AdminText.="<tr class='TRLine0'><td class='VarText'>Средний чек (цена)</td><td class='LongInput'><input name='price' type='text' value='".$action['price']."'></td></tr>";
	$AdminText.='<tr class="TRLine1"><td class="VarText" style="vertical-align:top; padding-top:10px;">Текст</td><td class="LongInput"><textarea name="text" style="outline:none; height:250px;">'.$action['text'].'</textarea></td></tr>';
	$AdminText.='<tr class="TRLine0"><td class="VarText" style="vertical-align:top; padding-top:10px;">Основное фото</td><td class="LongInput"><div class="uploaderCon" style="'.($action['pic'] ? 'display:none;' : '').'"><div class="uploader"></div><div class="Info">Вы можете загрузить фотографию в формате jpg, gif и png</div></div><div class="uploaderFiles">';
	if($action['pic']) $AdminText.='<span class="imgCon"><img src="/userfiles/picintv/'.$action['pic'].'" class="img" /><img src="/template/standart/exit.png" class="remove" onclick="imgRemove($(this))" /><input type="hidden" name="pic" value="'.$action['pic'].'" /></span>';
	$AdminText.='</div></td></tr>';
	$AdminText.='<tr class="TRLine1"><td class="VarText" style="vertical-align:top; padding-top:10px;">Фотографии</td><td class="LongInput"><div class="uploader"></div><div class="Info">Вы можете загрузить фотографии в форматах jpg, gif и png</div><div class="uploaderFiles">';
	if($action['pics']){ $pics = explode('|', $action['pics']); foreach($pics as $pic){
		$AdminText.='<div style="display:inline-block;"><img src="/userfiles/picintv/'.$pic.'" class="img"/><img src="/template/standart/exit.png" class="remove" onclick="imgsRemove($(this))" /><input type="hidden" name="attachment[]" value="'.$pic.'" /></div>';

	}}
	$AdminText.='</div></td></tr>'; $AdminText.='</table>'.$C10.'<div class="CenterText"><input type="submit" name="savebutton" class="SaveButton" value="Сохранить"></div>'; $AdminText.='</form></div>';
	
	// ПРАВАЯ КОЛОНКА
	$AdminRight="<br><br><div class='RoundText'><table><tr class='TRLine'><td class='CheckInput'><input type='checkbox' id='RS-".$action['id']."-".$table2."' ".$chk."></td><td><b>Опубликовано</b></td></tr></table></div>";
	$AdminRight.="<style>.img { width:150px; height:auto; margin-top:15px; margin-left:15px; }</style>";
}

//=============================================
$_SESSION["Msg"]="";
?>