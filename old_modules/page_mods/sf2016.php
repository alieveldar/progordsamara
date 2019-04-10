<?
$table=""; $news=""; $bomb="";

$soc="<a href='https://vk.com/avitex_sport' target='_blank'><img src='/template/sf2016/i1.jpg' /></a><a href='https://www.instagram.com/avitex_sport/' target='_blank'><img src='/template/sf2016/i2.jpg' /></a><a href='https://www.youtube.com/user/vikterrasport' target='_blank'><img src='/template/sf2016/i3.jpg' /></a><cl></cl>";

// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

$data=DB("SELECT * FROM `sport_lenta` WHERE (`id`='148147')"); @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]); $table=$ar["text"];
$Page["Content"]="<div class='pretext'>".$soc.$node["text"]."</div><div class='tables'><h2><strong>Туринирная таблица</strong> высшая лига</h2><div class='table'>".$table."</div></div>";

// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

$q="SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`data`, `[table]`.`lid`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`tags` LIKE '%,181,%')";
$endq="ORDER BY `data` DESC LIMIT 7"; $data=getNewsFromLentas($q, $endq);
for ($i=0; $i<$data["total"]; $i++) { @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]); $d=ToRusData($ar["data"]); $dat=$d[2];
	if ($i==0) {
		$news.="<div class='bitem'>";
			$news.="<div class='data'>".$dat."</div>";
			$news.="<div class='name'><a href='/".$ar["link"]."/view/".$ar["id"]."' target='_blank'>".$ar["name"]."</a></div>";
			$news.="<div class='text'>".$ar["lid"]."</div>";
		$news.="</div><cl></cl><div>";
	} else {
		$news.="<div class='item'>";
			$news.="<div class='data'>".$dat."</div>";
			$news.="<div class='name'><a href='/".$ar["link"]."/view/".$ar["id"]."' target='_blank'>".$ar["name"]."</a></div>";
			$news.="<div class='text'>".$ar["lid"]."</div>";
		$news.="</div>";
		if ($i/3==1) { $news.="<cl></cl>"; }
	}
}
$news.="</div><cl></cl>";
$Page["Content"].="<div class='news'><h3>НОВОСТИ</h3><cl></cl><div class='items'>".$news."</div></div>";

// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

$data=DB("SELECT * FROM `_widget_pics` WHERE (`pid`='148147' && `link`='sport') order by `rate` asc"); $bomb.="<div>"; $numb=1;
for ($i=0; $i<$data["total"]; $i++) { @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]);
	if ($ar["name"]!="") { $bomb.="</div><cl></cl><h2>".$ar["name"]."</h2><div>"; $numb=1; }
	
	$bomb.="<div class='boots'>";
		$bomb.="<div class='numb'>".$numb."</div>";
		$bomb.="<div class='pics'><img src='/userfiles/picsquare/".$ar["pic"]."'></div>";
		$bomb.="<div class='name'>".$ar["author"]."<br /><b>".strip_tags($ar["text"])."</b></div>";
	$bomb.="</div>";	
	if ($numb%3==0) { $bomb.="<cl></cl>"; }
	$numb++;
}
$bomb.="</div>"; $Page["Content"].="<div class='bomb'>".$bomb."</div>";

// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

?>