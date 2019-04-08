<?
### КРОССЛИНКОВКА СТРАНИЦ
if ($GLOBAL["sitekey"]==1 && $GLOBAL["database"]==1) {
	$table="places_list";
	
	// ЭЛЕМЕНТЫ
	$AdminText.='<h2 style="float:left;">'.$raz["name"].'</h2><div class="LinkG" style="float:right;"><a href="?cat=adm_placeslistadd">Добавить</a></div>'.$_SESSION["Msg"].$C5."<div id='Msg2' class='InfoDiv'>Вы можете редактировать и удалять записи</div>";

	$data=DB("SELECT * FROM `".$table."` ORDER BY `vip` DESC, `name` ASC"); $text="";
	for ($i=0; $i<$data["total"]; $i++): @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]);
		if ($ar["stat"]==1) { $chk="checked"; } else { $chk=""; } 
		$text.='<tr class="TRLine TRLine'.($i%2).'" id="Line'.$ar["id"].'">';				
		$text.='<td class="CheckInput"><input type="checkbox" id="RS-'.$ar["id"].'-'.$table.'" '.$chk.'></td>';		
		$text.="<td class='BigText'><a href='?cat=adm_placeslistedit&id=".$ar["id"]."' target='_blank'>".$ar["name"]."</a></td>";
		$text.='<td class="Act"><a href="?cat=adm_placeslistedit&id='.$ar["id"].'" title="Править">'.AIco('28').'</a></td>';
		$text.='<td class="Act" id="Act'.$ar["id"].'"><a href="javascript:void(0);" onclick="ItemDelete(\''.$ar["id"].'\', \''.$table.'\')" title="Удалить">'.AIco('exit').'</a></td>';
		$text.="</tr>";
	endfor;	
	$AdminText.="<div class='RoundText' id='Tgg'><table>".$text."</table></div>";
	// ПРАВАЯ КОЛОНКА
	$AdminRight="";
	
}

//=============================================
$_SESSION["Msg"]="";
?>