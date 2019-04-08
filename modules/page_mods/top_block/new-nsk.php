<?
$file = "_topblock-new3prodefault";
if (RetCache($file, "cacheblock") == "true") {
    list($Page["TopContent"], $cap) = GetCache($file, 0);
} else {
    list($Page["TopContent"], $cap) = CreateTopBlock();
    SetCache($file, $Page["TopContent"], "", "cacheblock");
}
$Page["TopContent"] = str_replace(
  "<!--USER-->",
  $Page["UserAuth"],
  $Page["TopContent"]
);

function CreateTopBlock()
{
    global $MENU, $BasVARS;

    $social = '';

    foreach ($BasVARS as $var) {
        if ($var['name'] === 'nsk_social') {
            $social = $var['value'];
        }
    }

    $topText2 = '';
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    $text = "<div id='ProHead'>
		<div class='logo'><a href='/'><img src='/template/pronsk/logo.png' /></a></div>
		<div class='navs'>
			<div class='user'><!--USER--></div>
			<div class='navsicon'>".$social."</div>
			<div class='wdgt2'>".getWidgetsInHead()."</div>
		</div><div class='C'></div>
		<div class='menu'>".$MENU['pronsk']."</div><div class='C'></div>
		<div class='wdgt'>".$topText2."</div><div class='C'></div>
	</div>
	<div class='C15'></div>
	<!-- <div id='MainTags'>".$MENU["maintags"]."</div> -->";

    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    return (array($text, ""));
}


function getWidgetsInHead()
{
//	$xml=simplexml_load_file("http://export.yandex.ru/bar/reginfo.xml?region=51"); $lvl=$xml->traffic->level; $icnt=$xml->traffic->icon; $txtt=$xml->traffic->hint; $temp=$xml->weather->day->day_part->temperature; $icnpa=$xml->weather->day->day_part->xpath('//image-v3'); $txtp=$xml->weather->day->day_part->weather_type; $icnp=$icnpa[0]; if ($lvl==1) { $balls="<b>".$lvl."</b> балл"; } elseif ($lvl==2 || $lvl==3 || $lvl==4) { $balls="<b>".$lvl."</b> балла"; } else { $balls="<b>".$lvl."</b> баллов"; }
    $xml = simplexml_load_file(
      "http://kovalut.ru/webmaster/xml-table.php?kod=6301"
    );
    $data = $xml->Central_Bank_RF;
    $day = $xml->Central_Bank_RF->USD->New->Digital_Date;
    $usd = $xml->Central_Bank_RF->USD->New->Exch_Rate;
    $euro = $xml->Central_Bank_RF->EUR->New->Exch_Rate;
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
//	$text="<a href='/weather' target='_blank' class='info' title='".$txtp."'><img src='".$icnp."' />В Самаре: <b>".$temp."</b>°C</a>";
//	$text.="<a href='/traffic' target='_blank' class='info' title='".$txtt."'><img src='/template/standart/icons/".$icnt.".png' />Пробки: ".$balls."</a>";
    $text .= "<a href='/exchange' target='_blank' class='info' title='Узнать курсы в банках'><b>$</b>=".$usd."  <b>€</b>=".$euro."</a>";

    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    return $text;
}

?>