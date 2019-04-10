<?
$file = "_index-traffic";
$VARS["cachepages"] = 0;
if (RetCache($file) == "true") {
    list($text, $cap) = GetCache($file, 0);
} else {
    list($text, $cap) = Traffic();
    SetCache($file, $text, "");
}
$Page["Content"] = '<div class="WhiteBlock" style="padding:0 !important;">'.$text.'</div>'.$C20.$Page["Content"];

function Traffic()
{
    $C = "";
    $text = '<script src="//api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script><script type="text/javascript">ymaps.ready(init); function init () {
	var myMap = new ymaps.Map("map", { center: [53.198221,50.120115], zoom: 13 }); var actualProvider = new ymaps.traffic.provider.Actual({}, { infoLayerShown: true }); actualProvider.setMap(myMap);
	myMap.controls.add("zoomControl", { left: 5, top: 5 }).add("typeSelector").add("mapTools", { left: 35, top: 5 }); var trafficControl = new ymaps.control.TrafficControl({ providerKey: "traffic#actual", shown: true });
	myMap.controls.add(trafficControl); trafficControl.getProvider("traffic#actual").state.set("infoLayerShown", true);	}</script><div id="map" style="width:100%; height:620px"></div>';

    return (array($text, $C));
}

$Page["RightContent"] = $C20.$C20.'<!-- Яндекс.Директ --><div id="yandex2_ad"></div><script type="text/javascript">(function(w, d, n, s, t) {  w[n] = w[n] || [];  w[n].push(function() { Ya.Direct.insertInto(126201, "yandex2_ad", {
ad_format: "direct",  font_size: 0.9,  font_family: "tahoma",  type: "vertical",  border_type: "block",  limit: 5,  title_font_size: 1,  site_bg_color: "FFFFFF",  border_color: "CCCCFF",  title_color: "0066CC", url_color: "666666",
text_color: "000000",  hover_color: "0066FF",  no_sitelinks: true    });  });  t = d.getElementsByTagName("script")[0];  s = d.createElement("script");  s.src = "//an.yandex.ru/system/context.js"; s.type = "text/javascript";
s.async = true;  t.parentNode.insertBefore(s, t);})(window, document, "yandex_context_callbacks");</script>';
?>