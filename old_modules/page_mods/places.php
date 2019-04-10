<?
$Page["RightContent"]=$Page["LeftContent"]=$Page["Content"]=$Page["Caption"]="";	$cap=$node["name"]; $text="";
if ($start==""){ list($cap, $text)=getPlacesIndex(); }elseif($start=="cat"){ list($cap, $text)=getPlacesCat(); }elseif($start=="view"){ list($cap, $text)=getPlacesView(); }else{ $text="Страница не найдена"; }
$Page["Title"]=$cap; $Page["TopContent"].=$C20."<h1 align='center'>".$cap."</h1>".$C10.$text.$C20."<div class='aboutinfo' style='overflow:hidden;'>".$node["text"]."</div>";

// === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === ===

function getPlacesIndex() {
	global $start, $page, $id, $C, $C5, $C10, $C15, $C20, $GLOBAL, $node; $cap=$node["name"]; $text=$dots="";
	// ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ----	
		$data=DB("SELECT `id`,`name`,`gps` FROM `places_list` WHERE (`stat`=1)");
		for ($i=0; $i<$data["total"]; $i++) { @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]); $dots.=$ar["id"].",".$ar["gps"].";"; }
		$text.="<div id='yamap'>Идет загрузка карты...</div><input id='idots' type='hidden' value='".$dots."' />".$C20;
		$text.="<script src='http://maps.googleapis.com/maps/api/js?key=AIzaSyCddgG6eKjpefXa062IUNXP_NmrNIMo04k'></script>";
		
		$data=DB("SELECT `id`,`pic` FROM `places_cats` WHERE (`stat`=1) ORDER BY `rate` ASC");		
		for ($i=0; $i<$data["total"]; $i++) { @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]);
		$text.="<a href='/places/cat/".$ar["id"]."' class='mapcat'><img src='/userfiles/picintv/".$ar["pic"]."' /></a>"; }
	// ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ----
	return(array($cap, $text));
}

// === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === ===

function getPlacesCat() {
	global $start, $page, $id, $C, $C5, $C10, $C15, $C20, $GLOBAL, $node; $cap=$text="";
	// ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ----	
		$data=DB("SELECT `name` FROM `places_cats` WHERE (`stat`=1 && `id`=".(int)$page.") LIMIT 1");		
		if ($data["total"]==1) { @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]); $cap=$ar["name"];
			$data=DB("SELECT `id`,`pic`,`name` FROM `places_list` WHERE (`stat`=1 && `pid`=".(int)$page.") ORDER BY `vip` DESC, `name` ASC");		
			for ($i=0; $i<$data["total"]; $i++) { @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]);
				$text.="<a href='/places/view/".$ar["id"]."' class='mapcat'><img src='/userfiles/picintv/".$ar["pic"]."' />".$ar["name"]."</a>";
				if (($i+1)%3==0) { $text.="<cl></cl>"; } 
			}
			$text.="<div class='backlink'><a href='/places'>Вернуться на главную страницу</a></div>";
		}
	// ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ----
	return(array($cap, $text));
}

// === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === === ===

function getPlacesView() {
	global $start, $page, $id, $C, $C5, $C10, $C15, $C20, $GLOBAL, $node; $cap=$text="";
	// ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ----	
		$data=DB("SELECT * FROM `places_list` WHERE (`stat`=1 && `id`=".(int)$page.") LIMIT 1");		
		if ($data["total"]==1){ @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]); $cap=$ar["name"];	
			if($ar["gps"]!=""){ $text.="<script src='http://maps.googleapis.com/maps/api/js?key=AIzaSyCddgG6eKjpefXa062IUNXP_NmrNIMo04k'></script><script>singleDot('".$ar["gps"]."');</script>"; }
			$text.="<div class='ldiv'><a href='/userfiles/picintv/".$ar["pic"]."' rel='prettyPhoto[gallery]'><img src='/userfiles/picintv/".$ar["pic"]."' /></a></div>";
			$text.="<div class='rdiv'><div id='yamap'></div></div>".$C20;
			if ($ar["phone"]!="" || $ar["adres"]!="" || $ar["proezd"]!="" || $ar["worktime"]!="" || $ar["price"]!="") {
				if ($ar["adres"]!="") { $text.="<div class='placeinfo'><b>Адрес: </b>".$ar["adres"]."</div>"; }
				if ($ar["proezd"]!="") { $text.="<div class='placeinfo'><b>Проезд: </b>".$ar["proezd"]."</div>"; }
				if ($ar["phone"]!="") { $text.="<div class='placeinfo'><b>Телефон: </b>".$ar["phone"]."</div>"; }				
				if ($ar["worktime"]!="") { $text.="<div class='placeinfo'><b>Время работы: </b>".$ar["worktime"]."</div>"; }
				if ($ar["price"]!="") { $text.="<div class='placeinfo'><b>Стоимость: </b>".$ar["price"]."</div>"; }
				$text.=$C10;
			}
			$text.=nl2br($ar["text"]).$C15;
			$pics=explode("|", trim($ar["pics"],"|")); $i=1; if (sizeof($pics)>0 && $ar["pics"]!="") { $text.="<div>"; foreach($pics as $pic) {
			$text.="<a href='/userfiles/picintv/".$pic."' class='mapcat' rel='prettyPhoto[gallery]'><img src='/userfiles/picintv/".$pic."' /></a>";
			if ($i%3==0) { $text.="<cl></cl>"; } $i++; } $text.="</div>"; }
		}
		$text.="<div class='backlink'><a href='/places'>Вернуться на главную страницу</a></div>";
	// ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ---- ----
	return(array($cap, $text));
}
?>