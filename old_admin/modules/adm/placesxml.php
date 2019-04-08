<?
### КРОССЛИНКОВКА СТРАНИЦ
if ($GLOBAL["sitekey"]==1 && $GLOBAL["database"]==1) {
	$P=$_POST; $ROOT=$_SERVER['DOCUMENT_ROOT']; $ROOTM=$ROOT."/mapper";
	
	// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
	
	if (isset($P["savebutton"])) { 
		@unlink($ROOTM."/appmobile.zip"); $text=''; $pics=array(); $site=array(); $news=array();

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		### МЕНЮ
		$text.="<menu>"; $text.="<item><id>0</id><title>Карта</title><link>mapitems</link><pic>map.jpg</pic></item>"."\r\n";
		$data=DB("SELECT `id`, `name`,`pic` FROM `places_cats` WHERE (`stat`=1) ORDER BY `rate` ASC");
		for ($i=0; $i<$data["total"]; $i++): @mysql_data_seek($data["result"],$i); $ar=@mysql_fetch_array($data["result"]); $site[$ar["id"]]=$ar; endfor;
		foreach ($site as $id=>$ar) { $text.="<item><id>".$id."</id><title>".$ar["name"]."</title><link>mapitems</link><pic>".$ar["pic"]."</pic></item>"."\r\n"; $pics[]=$ar["pic"]; } $text.="</menu>"."\r\n";
		
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		$data=DB("SELECT * FROM `places_list` WHERE (`stat`=1) ORDER BY `vip` DESC, `name` ASC");
		for ($i=0; $i<$data["total"]; $i++): @mysql_data_seek($data["result"],$i); $ar=@mysql_fetch_array($data["result"]); $news[$ar["id"]]=$ar; endfor;

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$text.="<news>";
		foreach($news as $ar) { 
			$pics[]=$ar["pic"];
			if ($ar["pics"]!="") { $arp=explode("|", trim(trim($ar["pics"]),"|")); foreach($arp as $ap) { $pics[]=$ap; }}
			$item="
			<item>
				<id>".$ar["id"]."</id>
				<pid>".$ar["pid"]."</pid>
				<vip>$ar[vip]</vip>
				<title><![CDATA[".$ar["name"]."]]></title>
				<text><![CDATA[".nl2br($ar["text"])."]]></text>
				<pic>$ar[pic]</pic>
				<pics>$ar[pics]</pics>
				<adres><![CDATA[".$ar["adres"]."]]></adres>
				<phone><![CDATA[".$ar["phone"]."]]></phone>
				<proezd><![CDATA[".$ar["proezd"]."]]></proezd>
				<worktime><![CDATA[".$ar["worktime"]."]]></worktime>
				<icon><![CDATA[".$ar["icon"]."]]></icon>
				<gps><![CDATA[".$ar["gps"]."]]></gps>
				<price><![CDATA[".$ar["price"]."]]></price>
			</item>";
			$text.=nlbr($item)."\r\n";
		}
		$text.="</news>";
		
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -		
		
		@file_put_contents($ROOTM."/content.lvv", "<items>\r\n".$text."\r\n</items>"); @require_once($ROOT."/admin/modules/adm/pclzip.lib.php"); $archive = new PclZip($ROOTM."/appmobile.zip");
		$archive->create($ROOTM.'/content.lvv', PCLZIP_OPT_REMOVE_PATH, $ROOTM);  $archive->add($ROOTM.'/map.jpg', PCLZIP_OPT_REMOVE_PATH, $ROOTM);
		foreach($pics as $pic) { if(is_file($ROOT."/userfiles/picintv/".$pic)){  $archive->add($ROOT."/userfiles/picintv/".$pic, PCLZIP_OPT_REMOVE_PATH, $ROOT."/userfiles/picintv");  }}
		
		$_SESSION["Msg"]="<div class='SuccessDiv'>Новая версия карты успешно создана!</div>"; @header("location: ?cat=adm_placesxml"); exit();
	}

	// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

	$AdminText='<h2>Создание выгрузки XML карты</h2>'.$_SESSION["Msg"];
	$AdminText.="<div class='RoundText'>Внимание, это действие нельзя обратить, не уходите со страницы и не закрывайте браузер, даже если задача выполянется слишком долго!</div>".$C;
	$AdminText.="<div class='RoundText'>После создания XML, не нажимайте кнопку «НАЗАД», просто перейдите по ссылке: <a href='/admin/'>На главную админки</a>!</div>".$C20;
	$AdminText.='<form action="'.$_SERVER["REQUEST_URI"].'" enctype="multipart/form-data" method="post"><div class="CenterText"><input type="submit" name="savebutton" class="SaveButton" value="Создать выгрузку"></div></form>';
}
//=============================================
$_SESSION["Msg"]=""; function nlbr($text) { $text=str_replace(array("\t","\r","\n","&nbsp;"), array("","",""," "), $text); return $text; }
?>