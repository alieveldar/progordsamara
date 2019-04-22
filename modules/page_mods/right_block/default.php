<?
$file = "_rightblock-rightPRO";
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
    $text = "<div class='banner' id='Banner-1-1'></div>";
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

    /*PodSurikat 1 */
    $q = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`lid`, `[table]`.`tavto`,`[table]`.`data`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` LEFT JOIN `advert_life` ON `[table]`.id = `advert_life`.news_id WHERE (`advert_life`.`data` > '".time()."' && `advert_life`.`module` = '[table]' && `[table]`.`stat`='1' && `[table]`.`data`>'".(time(
    ) - 6 * 24 * 60 * 60)."' && (`[table]`.`promo`=1 || `[table]`.`spromo`=1) [used])";
    $endq = "ORDER BY `data` DESC LIMIT 6";
    $data = getNewsFromLentas($q, $endq);

    $list = array();
    $cnt = 1;
    if ((int)$data["total"] > 0) {
        for ($i = 0; $i < $data["total"]; $i++) {
            @mysql_data_seek($data["result"], $i);
            $ar = @mysql_fetch_array($data["result"]);
            $ar["style"] = "ReTwoOrder";
            $list[] = $ar;
        }
        foreach ($list as $ar) {
            $text .= getAdvRightBlock($ar);
            $text .= "</div>".$C25;
        }
    } else {
        $text .= $yandex1;
    }

    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;

    /*PodSurikat 2 
    $q = "SELECT `[table]`.`id`, `[table]`.`name`,`[table]`.`data`, '1' as `tavto`, `[table]`.`lid`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` WHERE (`[table]`.`stat`='1' && `[table]`.`data`>'".(time(
        ) - 6 * 24 * 60 * 60)."' && (`[table]`.`promo`=1 || `[table]`.`spromo`=1) [used])";
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
        $text .= $yandex2;
    }
*/

    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;
    $text .= "<h3>Самое популярное</h3>".getMaxSeens();
    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;
    $text .= "<h3>Самое комментируемое</h3>".getMaxComments();
    $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
    $ban10 = $ban10 + 2;
    /*   $text .= '<h3>Наши партнеры</h3><div id="n4p_9108">...</div><script type="text/javascript" charset="utf-8" src="http://js.grt02.com/ticker_9108.js"></script>'.$C20;*/
 //орион
    $text .='<script type="text/javascript">
    (function loadExtData(w) {
      w.adv = new Adv();
      })(window);
      </script>
      <div id="adfox_149699505329239858"></div>
      <script type="text/javascript">
      adv.banner(function(webmd) {
        console.log("Showing banner 1", webmd);
        var wmclusters = webmd["clusters"].toString();
        var audiences =  webmd["audiences"].toString();
        wmclusters = wmclusters.replace(/,/g,":");
        audiences = audiences.replace(/,/g,":");
        window.Ya.adfoxCode.create({
            ownerId: 251657,
            containerId: "adfox_149699505329239858",
            params: {
                pp: "h",
                ps: "cjoe",
                p2: "fkuh",
                puid1: webmd["socio_demographics"]["age"],
                puid2: webmd["socio_demographics"]["gender"],
                puid3: webmd["socio_demographics"]["social_class"],
                puid4: wmclusters,
                puid5: audiences
                },
                onRender: function() { console.log("otag_rendered"); },
                onError: function(error) { console.log("otag_error"); },
                onStub: function() { console.log("otag_stub"); }
                });
                });
                </script>';
                $text .= $C10."<div class='banner3' id='Banner-10-".$ban10."'></div>";
                $ban10 = $ban10 + 2;
                $text .= "<h3>Выбор читателей</h3>".getMaxLikes();

 // Реклама, доживающая свои дни
                $q_adv = "SELECT `[table]`.`id`, `[table]`.`name`, `[table]`.`data`, '1' as `tavto`, `[table]`.`lid`, `[table]`.`pic`, '[link]' as `link` FROM `[table]` LEFT JOIN `advert_life` ON `[table]`.id = `advert_life`.news_id WHERE (`advert_life`.`data` <= '".time()."' && `advert_life`.`module` = '[table]' && `[table]`.`stat`='1' && `[table]`.`data`>'".(time(
                ) - 11 * 24 * 60 * 60)."' && `[table]`.`promo`=1 [used] AND (main_column_pronsk <> 1 AND left_column_pronsk <> 1 AND commerce_column_pronsk_both <> 1))";
                $endq_adv = "ORDER BY `data` DESC LIMIT 6";
                $data_adv = getNewsFromLentas($q_adv, $endq_adv);

                // реклама в самый низ
                $list = array();
                if ((int)$data_adv["total"] > 0) {
                    for ($i = 0; $i < $data_adv["total"]; $i++) {
                        @mysql_data_seek($data_adv["result"], $i);
                        $ar = @mysql_fetch_array($data_adv["result"]);
                        $list[] = $ar;
                        $used[ $ar['link'] ][] = $ar['id'];
                    }
                }

                if(!empty($list)) {
                    foreach ($list as $ar) {
                     $text .= getAdvRightBlock($ar);
                     $text .= "</div>".$C25;
                 }
             }

    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
             return (array($text, ""));
         }

         ?>