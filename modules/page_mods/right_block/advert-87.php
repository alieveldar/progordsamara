<?
$file = "_rightblock-right87";
if (RetCache($file, "cacheblock") == "true") {
    list($Page["RightContent"], $cap) = GetCache($file, 0);
} else {
    list($Page["RightContent"], $cap) = CreateRightBlock();
    SetCache($file, $Page["RightContent"], "", "cacheblock");
}
$yandex1 = '<!-- Яндекс.Директ --><div id="yandex1ad"></div><script type="text/javascript">(function(w, d, n, s, t) { w[n] = w[n] || []; w[n].push(function() { Ya.Direct.insertInto(125901, "yandex1ad", { ad_format: "direct", font_size: 0.8, type: "vertical", border_type: "block", limit: 3, title_font_size: 1, site_bg_color: "FFFFFF", header_bg_color: "CCCCCC", border_color: "CCCCCC", title_color: "0066CC", url_color: "006600", text_color: "000000", hover_color: "0066FF", no_sitelinks: true}); }); t = d.getElementsByTagName("script")[0]; s = d.createElement("script"); s.src = "//an.yandex.ru/system/context.js"; s.type = "text/javascript"; s.async = true; t.parentNode.insertBefore(s, t);})(window, document, "yandex_context_callbacks");</script>'.$C25;
$yandex2 = '<!-- Яндекс.Директ --><div id="yandex2ad"></div><script type="text/javascript">(function(w, d, n, s, t) { w[n] = w[n] || []; w[n].push(function() { Ya.Direct.insertInto(125901, "yandex2ad", { ad_format: "direct", font_size: 0.8, type: "vertical", border_type: "block", limit: 3, title_font_size: 1, site_bg_color: "FFFFFF", header_bg_color: "CCCCCC", border_color: "CCCCCC", title_color: "0066CC", url_color: "006600", text_color: "000000", hover_color: "0066FF", no_sitelinks: true}); }); t = d.getElementsByTagName("script")[0]; s = d.createElement("script"); s.src = "//an.yandex.ru/system/context.js"; s.type = "text/javascript"; s.async = true; t.parentNode.insertBefore(s, t);})(window, document, "yandex_context_callbacks");</script>'.$C25;

function CreateRightBlock()
{
    global $Domains, $SubDomain, $GLOBAL, $C20, $C25, $C, $C10, $C15, $yandex1, $yandex2;
    $ban10 = 2;
    $text = '';
    $src = "";

    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

    $text = '<div style="width: 240px; height: 400px; display: block;"><object type="application/x-shockwave-flash" data="http://progorodsamara.ru/advert/files/flash/2015.03.10-flash-100-7084.swf" width="240" height="400"><param name="movie" value="http://progorodsamara.ru/advert/files/flash/2015.03.10-flash-100-7084.swf"><param name="quality" value="high"><param name="wmode" value="opaque"><param name="flashvars" value="link1=/advert/clickBanner.php?id=145%26away=http%3A%2F%2Fkia-na-moskovskom.ru%2Fautosalon%2Fnews%2F&amp;link2=/advert/clickBanner.php?id=145%26away=&amp;link3=/advert/clickBanner.php?id=145%26away="><embed type="application/x-shockwave-flash" width="240" height="400" quality="high" wmode="opaque" src="http://progorodsamara.ru/advert/files/flash/2015.03.10-flash-100-7084.swf" flashvars="link1=/advert/clickBanner.php?id=145%26away=http%3A%2F%2Fkia-na-moskovskom.ru%2Fautosalon%2Fnews%2F&amp;link2=/advert/clickBanner.php?id=145%26away=&amp;link3=/advert/clickBanner.php?id=145%26away="></object></div>'.$C25;

    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

    /*PodSurikat*/
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`tavto`,`[table]`.`data`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`>'".(time(
        ) - 4 * 24 * 60 * 60)."' && `[table]`.`promo`=1 [used])";
    $endq = "ORDER BY `data` DESC LIMIT 6";
    $data = getNewsFromLentas($q, $endq);
    $list = array();
    $cnt = 1;
    if ((int)$data["total"] > 0) {
        for ($i = 0; $i < $data["total"]; $i++) {
            @mysql_data_seek($data["result"], $i);
            $ar = @mysql_fetch_array($data["result"]);
            $list[] = $ar;
        }
        foreach ($list as $ar) {
            $text .= "<div class='OCNew ReTwoOrder'>";
            $text .= "<a href='/".$ar["link"]."/view/".$ar["id"]."'>";
            if ($ar["tavto"] == 1 && $ar["pic"] != "") {
                $text .= "<img src='$src/userfiles/pictavto/".$ar["pic"]."'>";
            }
            $text .= $ar["name"]."</a>";
            $text .= "</div>".$C25;
            $cnt++;
        }
    } else {
        $text .= $yandex1;
    }

    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;

    $q = "SELECT `[table]`.`id`, `[table]`.`name`,`[table]`.`data`, '1' as `tavto`, `[table]`.`lid`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`>'".(time(
        ) - 4 * 24 * 60 * 60)."' && `[table]`.`promo`=1 [used])";
    $endq = "ORDER BY `data` DESC LIMIT 6,6";
    $data = getNewsFromLentas($q, $endq);
    $list = array();
    $cnt = 1;
    if ((int)$data["total"] > 0) {
        for ($i = 0; $i < $data["total"]; $i++) {
            @mysql_data_seek($data["result"], $i);
            $ar = @mysql_fetch_array($data["result"]);
            $list[] = $ar;
        }
        foreach ($list as $ar) {
            if (strpos($ar["link"], "ls") !== false || strpos(
                $ar["link"],
                "bubr"
              ) !== false) {
                $rel = "target='_blank' rel='nofollow'";
            } else {
                $rel = "";
            }
            $text .= "<div class='OCNew ReTwoOrder'>";
            $text .= "<a href='/".$ar["link"]."/view/".$ar["id"]."' $rel>";
            if ($ar["tavto"] == 1 && $ar["pic"] != "") {
                $text .= "<img src='$src/userfiles/pictavto/".$ar["pic"]."'>";
            }
            $text .= $ar["name"]."</a>";
            $text .= "</div>".$C25;
            $cnt++;
        }
    } else {
        $text .= $yandex2;
    }

    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;
    $text .= "<h3>Самое популярное</h3>".getMaxSeens();
    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;
    $text .= "<h3>Самое комментируемое</h3>".getMaxComments();
    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;
    $text .= '<h3>Наши партнеры</h3><div id="n4p_9108">...</div><script type="text/javascript" charset="utf-8" src="http://js.grt02.com/ticker_9108.js"></script>'.$C20;
    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;
    $text .= "<h3>Выбор читателей</h3>".getMaxLikes();
    #$text.="<h3>Новости России</h3><div style='width:240px; overflow:hidden;'><script src='http://partner.mediametrics.ru/inject/inject.js' type='text/javascript' id='MediaMetricsInject' data-width='240' data-height='320' data-bgcolor='FFFFFF' data-bordercolor='000000' data-linkscolor='232323' data-transparent='' data-rows='5' data-inline='' data-font='small' data-fontfamily='roboto' data-border='' data-borderwidth='1' data-alignment='vertical' data-country='ru' data-site='mmet/progorodsamara_ru'></script></div>".$C25;
    #$text.='<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:240px;height:400px" data-ad-client="ca-pub-2073806235209608" data-ad-slot="7095611817"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';

    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    return (array($text, ""));
}

?>