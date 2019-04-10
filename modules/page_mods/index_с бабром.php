<?
$yandex1 = '<!-- Яндекс.Директ --><div id="yandex1ad"></div><script type="text/javascript">(function(w, d, n, s, t) { w[n] = w[n] || []; w[n].push(function() { Ya.Direct.insertInto(125901, "yandex1ad", { ad_format: "direct", font_size: 0.8, type: "vertical", border_type: "block", limit: 3, title_font_size: 1, site_bg_color: "FFFFFF", header_bg_color: "CCCCCC", border_color: "CCCCCC", title_color: "0066CC", url_color: "006600", text_color: "000000", hover_color: "0066FF", no_sitelinks: true}); }); t = d.getElementsByTagName("script")[0]; s = d.createElement("script"); s.src = "//an.yandex.ru/system/context.js"; s.type = "text/javascript"; s.async = true; t.parentNode.insertBefore(s, t);})(window, document, "yandex_context_callbacks");</script>'.$C25;
$yandex2 = '<!-- Яндекс.Директ --><div id="yandex2ad"></div><script type="text/javascript">(function(w, d, n, s, t) { w[n] = w[n] || []; w[n].push(function() { Ya.Direct.insertInto(125901, "yandex2ad", { ad_format: "direct", font_size: 0.8, type: "vertical", border_type: "block", limit: 3, title_font_size: 1, site_bg_color: "FFFFFF", header_bg_color: "CCCCCC", border_color: "CCCCCC", title_color: "0066CC", url_color: "006600", text_color: "000000", hover_color: "0066FF", no_sitelinks: true}); }); t = d.getElementsByTagName("script")[0]; s = d.createElement("script"); s.src = "//an.yandex.ru/system/context.js"; s.type = "text/javascript"; s.async = true; t.parentNode.insertBefore(s, t);})(window, document, "yandex_context_callbacks");</script>'.$C25;
$Page["Caption"] = "";
$Page["Content"] = "";
$Page["LeftContent"] = "";
$Page["RightContent"] = "";
$src = "";

$file = "_index-indexsmp4g";
if (RetCache($file, 'cacheblock') == "true") {
    list($text, $cap) = GetCache($file, 0);
} else {
    list($text, $cap) = NewIndexPage();
    SetCache($file, $text);
}
$CSSModules['lenta'] = '/modules/lenta/lenta.css';
$Page["TopContent"] .= $C15."<h1>Новости Самары и Самарской области".$capcache."</h1>".$C5;
if ($GLOBAL["USER"]["role"] > 1) {
    $Page["TopContent"] .= "<div id='AdminEditItem'><a href='".$BP."?nocache'>Обновить кэш. Не злоупотреблять! =)</a></div>".$C25;
}
$Page["TopContent"] .= $text;

### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ###

function NewIndexPage()
{
    global $VARS, $GLOBAL, $Page, $C10, $C20, $C25, $C, $used, $CommerceBlock, $lentas, $src;
    //--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- -
    $text = "<div id='ONLEFT'><div id='TV'>".TV()."</div><div id='LEFT'>".LEFT(
      )."</div><div id='CENTER'>".CENTER()."</div></div><div id='RIGHT'>".RIGHT(
      )."</div>";

    //--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- -
    return array($text, $cap);
}

### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ###

function TV()
{
    global $used, $C, $C5, $C10, $C20, $C25, $lentas, $src;
    $text = "";
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`data`, `[table]`.`comcount`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`onind`=1 [used]
AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND commerce_column_pronsk_both <> 1)
	)";
    $endq = "ORDER BY `data` DESC LIMIT 1";
    $data = getNewsFromLentas($q, $endq);
    if ($data["total"] == 1) {
        @mysql_data_seek($data["result"], 0);
        $ar = @mysql_fetch_array($data["result"]);
        $used[$ar["link"]][] = $ar["id"];
        $text .= "<a href='/".$ar["link"]."/view/".$ar["id"]."'><img src='$src/userfiles/picintv/".$ar["pic"]."' title='".$ar["name"]."' alt='".$ar["name"]."' class='TvPic'/></a>";
        $text .= "<a href='/".$ar["link"]."/view/".$ar["id"]."' class='TvLink'>".$ar["name"]."</a><div class='TvSpan'>".$ar["lid"]."</div>".Dater(
            $ar
          );
    }

    return $text;
}

### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ###

function LEFT()
{
    global $used, $C, $C10, $C20, $C25, $lentas, $src;
    $adv = array();
    $news = array();
    $list = array();
    $advid = 0;
    $cnt = 1;
    $ban10 = 1;

    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`tavto`, `[table]`.`lid`, `[table]`.`data`, `[table]`.`comcount`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`redak`!=1 && (`[table]`.`promo`=1 || `[table]`.`spromo`=1) && `[table]`.`data`<'".(time(
        ) - 5 * 24 * 60 * 60)."' && `[table]`.`data`>'".(time(
        ) - 7 * 24 * 60 * 60)."' [used]
	AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND main_column_pronsk_both <> 1 AND commerce_column_pronsk_both <> 1))";
    $endq = "ORDER BY `data` DESC";
    $data = getNewsFromLentas($q, $endq);
    for ($i = 0; $i < $data["total"]; $i++) {
        @mysql_data_seek($data["result"], $i);
        $ar = @mysql_fetch_array($data["result"]);
        $ar["pic"] = "";
        $ar["data"] = '';
        if ($ar["link"] != "ls") {
            $adv[] = $ar;
            $used[ $ar['link'] ][] = $ar['id'];
        }
    }
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`tavto`, `[table]`.`lid`, `[table]`.`data`, `[table]`.`comcount`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`redak`!=1 && (`[table]`.`promo`!=1 && `[table]`.`spromo`!=1) [used]
AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND main_column_pronsk_both <> 1 AND commerce_column_pronsk_both <> 1))";
    $endq = "ORDER BY `data` DESC LIMIT 98";
    $data = getNewsFromLentas($q, $endq);
    for ($i = 0; $i < $data["total"]; $i++) {
        @mysql_data_seek($data["result"], $i);
        $ar = @mysql_fetch_array($data["result"]);
        if (($i + 1) % 4 == 0 && $adv[$advid]["name"] != "") {
            $list[] = $adv[$advid];
            $advid++;
        }
        $list[] = $ar;
        $used[ $ar['link'] ][] = $ar['id'];
    }

    foreach ($list as $ar) {
        $text .= "<div class='ONew'>";
        $text .= "<a href='/".$ar["link"]."/view/".$ar["id"]."'>";
        if ($ar["tavto"] == 1 && $ar["pic"] != "") {
            $text .= "<img src='$src/userfiles/pictavto/".$ar["pic"]."'>";
        }
        $text .= $ar["name"]."</a>".$C.Dater($ar);
        $text .= "</div>".$C20;
        if ($cnt % 4 == 0) {
            if ($cnt == 4) {
                $text .= '<script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script><div id="vk_groupsVK"></div><script type="text/javascript">VK.Widgets.Group("vk_groupsVK", {mode: 1, width: "200", height: "140", color1: "FFFFFF", color2: "2B587A", color3: "5B7FA6"}, 40786487);</script>'.$C25;
                $text .= '<!--MaxLab START--><!— "MaxLab"--><!— : . progorodsamara.ru - —><!— : —><!— : 200 330--><div id="adfox_153690863007351038"></div><script>window.Ya.adfoxCode.create({ownerId: 233,containerId: \'adfox_153690863007351038\', params: {p1: \'bwqyi\', p2: \'folj\'}});</script>'.$C25;
            }
            if ($ban10 < 10) {
                $text .= "<div class='banner3' id='Banner-10-".$ban10."'></div>";
                $ban10 = $ban10 + 2;
            }
        }
        $cnt++;
    }

    return $text;
}

### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ###

function CENTER()
{
    global $used, $C, $C10, $C20, $C25, $C30, $lentas, $src;
    $adv = array();
    $advs = array();
    $news = array();
    $list = array();
    $tmplist = array();
    $redlist = array();
    $advid = 0;
    $advsid = 0;
    $cnt = 1;
    $ban6 = 1;

    /*Surikat*/
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`tavto`, `[table]`.`pic`,`[table]`.`data`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`>'".(time(
        ) - 1 * 24 * 60 * 60)."' && `[table]`.`spromo`=1 [used] AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND commerce_column_pronsk_both <> 1))";
    $endq = "ORDER BY `data` DESC LIMIT 1";
    $data = getNewsFromLentas($q, $endq);
    if ($data["total"] == 1) {
        @mysql_data_seek($data["result"], 0);
        $ar = @mysql_fetch_array($data["result"]);
        $ar["style"] = "NorN";
        $cnt++;
        $ar["linked"] = "/".$ar["link"]."/view/".$ar["id"];
        $ar["data"] = '';
        if ($ar["pic"] != "" && $ar["tavto"] == 1) {
            $ar["pic"] = $src."/userfiles/pictavto/".$ar["pic"];
        } else {
            $ar["pic"] = "";
        }
        if ($ar["link"] != "ls") {
            $list[] = $ar;
        }
        $used[ $ar['link'] ][] = $ar['id'];
    }

    /*PodSurikat*/
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`tavto`,`[table]`.`data`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`>'".(time(
        ) - 1 * 24 * 60 * 60)."' && `[table]`.`promo`=1 [used] AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND commerce_column_pronsk_both <> 1))";
    $endq = "ORDER BY `data` DESC";
    $data = getNewsFromLentas($q, $endq);
    for ($i = 0; $i < $data["total"]; $i++) {
        @mysql_data_seek($data["result"], $i);
        $ar = @mysql_fetch_array($data["result"]);
        $ar["style"] = "ReOneOrder";
        $ar["data"] = '';
        $ar["linked"] = "/".$ar["link"]."/view/".$ar["id"];
        if ($ar["pic"] != "" && $ar["tavto"] == 1) {
            $ar["pic"] = $src."/userfiles/pictavto/".$ar["pic"];
        } else {
            $ar["pic"] = "";
        }
        if ($ar["link"] != "ls") {
            $avd[] = $ar;
            $used[ $ar['link'] ][] = $ar['id'];
        }
    }

    /*Staruhi*/
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`tavto`,`[table]`.`data`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`<'".(time(
        ) - 7 * 24 * 60 * 60)."' && `[table]`.`data`>'".(time(
        ) - 11 * 24 * 60 * 60)."' && (`[table]`.`promo`=1 || `[table]`.`spromo`=1) [used] AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND commerce_column_pronsk_both <> 1))";
    $endq = "ORDER BY `data` DESC LIMIT 30";
    $data = getNewsFromLentas($q, $endq);
    for ($i = 0; $i < $data["total"]; $i++) {
        @mysql_data_seek($data["result"], $i);
        $ar = @mysql_fetch_array($data["result"]);
        $ar["style"] = "Oldest";
        $ar["data"] = '';
        $ar["linked"] = "/".$ar["link"]."/view/".$ar["id"];
        if ($ar["pic"] != "" && $ar["tavto"] == 1) {
            $ar["pic"] = $src."/userfiles/pictavto/".$ar["pic"];
        } else {
            $ar["pic"] = "";
        }
        if ($ar["link"] != "ls") {
            $avds[] = $ar;
            $used[ $ar['link'] ][] = $ar['id'];
        }
    }

    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`tavto`,`[table]`.`data`, `[table]`.`comcount`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`promo`!=1 && `[table]`.`spromo`!=1 && (`[table]`.`redak`=1 OR `[table]`.`main_column_pronsk_both` = 1) [used])";
    $endq = "ORDER BY `data` DESC LIMIT 60";
    $data = getNewsFromLentas($q, $endq);
    $sc = 0;
    for ($i = 0; $i < $data["total"]; $i++) {
        @mysql_data_seek($data["result"], $i);
        $ar = @mysql_fetch_array($data["result"]);
        $ar["style"] = "Editors";
        $ar["linked"] = "/".$ar["link"]."/view/".$ar["id"];
        if ($ar["pic"] != "" && $ar["tavto"] == 1) {
            $ar["pic"] = $src."/userfiles/pictavto/".$ar["pic"];
        } else {
            $ar["pic"] = "";
        }
        if ($sc < 4 && $ar["link"] != "ls") {
            $redlist[] = $ar;
            $sc++;
        } else {
            $tmplist[] = $ar;
        }
        $used[ $ar['link'] ][] = $ar['id'];
    }

    $xml = simplexml_load_file("http://bubr.ru/prokazan_news.xml");
    $bubr = array();
    if (!empty($xml)) {
        $count_str = count($xml->channel->item);
        $i = 0;
        while ($i <= ($count_str - 1)): $item = $xml->channel->item[$i];
            if ((int)$bubr["adv"] != 1) {
                $bubr["name"] = (string)$item->title;
                $bubr["link"] = (string)$item->link;
                $bubr["linked"] = (string)$item->link;
                $bubr["pic"] = (string)$item->picmiddle;
                $bubr["data"] = (string)$item->data;
                $bubr["lid"] = (string)$item->ttwo;
                $ar["style"] = "Bubr";
                $tmplist[] = $bubr;
            }
            $i++; endwhile;
    }

    usort($tmplist, ArraySort);

    foreach ($redlist as $ar) {
        $list[] = $ar;
        if (($cnt + 1) % 4 == 0) {
            if ($avd[$advid]["name"] != "") {
                $list[] = $avd[$advid];
                $advid++;
                $cnt++; /*PodSurikat*/
            } else {
                if ($avds[$advsid]["name"] != "") {
                    $list[] = $avds[$advsid];
                    $advsid++;
                    $cnt++; /*Staruhi*/
                }
            }
        }
        $cnt++;
    }

    foreach ($tmplist as $ar) {
        $list[] = $ar;
        if (($cnt + 1) % 4 == 0) {
            if ($avd[$advid]["name"] != "") {
                $list[] = $avd[$advid];
                $advid++;
                $cnt++; /*PodSurikat*/
            } else {
                if ($avds[$advsid]["name"] != "") {
                    $list[] = $avds[$advsid];
                    $advsid++;
                    $cnt++; /*Staruhi*/
                }
            }
        }
        $cnt++;
    }

    $cnt = 1;
    foreach ($list as $ar) {
        if (strpos($ar["link"], "ls") !== false || strpos(
            $ar["link"],
            "bubr"
          ) !== false) {
            $rel = "target='_blank' rel='nofollow'";
        } else {
            $rel = "";
        }

        $text .= "<div class='RedNews ".$ar["style"]."'>";
        if ($ar["pic"] != "") {
            $text .= "<div class='img'><a href='".$ar["linked"]."' $rel><img src='".$ar["pic"]."'></a></div><div class='stext'>";
        } else {
            $text .= "<div class='ftext'>";
        }
        $text .= "<a href='".$ar["linked"]."' class='caption' $rel>".$ar["name"]."</a>";
        if ($ar["lid"] != "") {
            $text .= "<div class='lid'>".$ar["lid"]."</div>";
        }
        $text .= $C.Dater($ar);
        $text .= "</div></div>".$C30;

        if ($cnt == 2) {
            $con = DB(
              "SELECT *, 'concurs' as `linked` FROM `concurs_lenta` WHERE (`stat`=1 && `votingend`>'".time(
              )."') ORDER BY `data` DESC LIMIT 1"
            );
            if ($con["total"] == 1) {
                @mysql_data_seek($con["result"], 0);
                $ac = @mysql_fetch_array($con["result"]);
                $text .= "<div class='RedNews Editors'>";
                if ($ac["pic"] != "") {
                    $text .= "<div class='img'><a href='".$ac["linked"]."' $rel><img src='/userfiles/pictavto/".$ac["pic"]."'></a></div><div class='stext'>";
                } else {
                    $text .= "<div class='ftext'>";
                }
                $text .= "<a href='".$ac["linked"]."/view/".$ac["id"]."' class='caption'>".$ac["name"]."</a>";
                if ($ac["lid"] != "") {
                    $text .= "<div class='lid'>".$ac["lid"]."</div>";
                }
                $text .= "</div></div>".$C30;
            }
        }


        if ($cnt % 4 == 0) {
            if ($ban6 < 10) {
                $text .= "<div class='banner2' id='Banner-6-".$ban6."'></div>";
                $ban6++;
            }
        }
        $cnt++;
    }

    return $text;
}

### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ### --- ###

function RIGHT()
{
    global $used, $C, $C10, $C20, $C25, $lentas, $src, $yandex1, $yandex2;
    $ban10 = 2;
    $text = "<div class='banner' id='Banner-1-1'></div><div class='C10'></div>";
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

    /*PodSurikat 1 */
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`tavto`,`[table]`.`data`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`>'".(time(
        ) - 6 * 24 * 60 * 60)."' && (`[table]`.`promo`=1 || `[table]`.`spromo`=1) [used])";
    $endq = "ORDER BY `data` DESC LIMIT 6";
    $data = getNewsFromLentas($q, $endq);
    $list = array();
    $cnt = 1;
    if ((int)$data["total"] > 0) {
        for ($i = 0; $i < $data["total"]; $i++) {
            @mysql_data_seek($data["result"], $i);
            $ar = @mysql_fetch_array($data["result"]);
            $list[] = $ar;
            $used[ $ar['link'] ][] = $ar['id'];
        }
        foreach ($list as $ar) {
            if ($ar["link"] != "ls") {
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
        }
    } else {
        $text .= $yandex1;
    }

    /*PodSurikat
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`tavto`,`[table]`.`data`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`<'".(time(
        ) - 2 * 24 * 60 * 60)."' && `[table]`.`data`>'".(time(
        ) - 5 * 24 * 60 * 60)."' && (`[table]`.`promo`=1 || `[table]`.`spromo`=1) [used] AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND commerce_column_pronsk_both <> 1))";
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
            if ($ar["link"] != "ls") {
                $text .= "<div class='OCNew ReTwoOrder'>";
                $text .= "<a href='/".$ar["link"]."/view/".$ar["id"]."'>";
                if ($ar["tavto"] == 1 && $ar["pic"] != "") {
                    $text .= "<img src='$src/userfiles/picsquare/".$ar["pic"]."'>";
                }
                $text .= $ar["name"]."</a>";
                $text .= "</div>".$C25;
                $cnt++;
            }
        }
    } else {
        $text .= $yandex1;
    }*/

    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;

    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`data`, '1' as `tavto`, `[table]`.`lid`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`<'".(time(
        ) - 2 * 24 * 60 * 60)."' && `[table]`.`data`>'".(time(
        ) - 5 * 24 * 60 * 60)."' && `[table]`.`promo`=1 [used] AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND commerce_column_pronsk_both <> 1))";
    $endq = "ORDER BY `data` DESC LIMIT 6, 6";
    $data = getNewsFromLentas($q, $endq);
    $list = array();
    $cnt = 1;
    if ((int)$data["total"] > 0) {
        for ($i = 0; $i < $data["total"]; $i++) {
            @mysql_data_seek($data["result"], $i);
            $ar = @mysql_fetch_array($data["result"]);
            $list[] = $ar;
            $used[ $ar['link'] ][] = $ar['id'];
        }
        foreach ($list as $ar) {
            if ($ar["link"] != "ls") {
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
                    $text .= "<img src='$src/userfiles/picsquare/".$ar["pic"]."'>";
                }
                $text .= $ar["name"]."</a>";
                $text .= "</div>".$C25;
                $cnt++;
            }
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
 //   $text .= '<h3>Наши партнеры</h3><div id="n4p_9108">...</div><script type="text/javascript" charset="utf-8" src="http://js.grt02.com/ticker_9108.js"></script>'.$C20;
    //орион
    // $text .='<div id="adfox_149699503432432432"></div>';

	$text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;
    $text .= "<h3>Выбор читателей</h3>".getMaxLikes();

/*    $text .= "<script src='//mediametrics.ru/partner/inject/inject.js' type='text/javascript' id='MediaMetricsInject' data-width='240' data-height='400' data-img='true' data-imgsize='70' data-type='img' data-bgcolor='FFFFFF' data-bordercolor='000000' data-linkscolor='232323' data-transparent='' data-rows='5' data-inline='' data-font='big' data-fontfamily='roboto' data-border='' data-borderwidth='0' data-alignment='vertical' data-country='ru' data-site='mmet/progorodsamara_ru'> </script>";*/

    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    return $text;
}

?>
