<?
### НАСТРОЙКИ САЙТА
if ($GLOBAL["sitekey"] == 1 && $GLOBAL["database"] == 1) {
// РАЗДЕЛ
    $data = DB(
      "SELECT `id`,`shortname`,`link`, `sets` FROM `_pages` WHERE (`link`='".$alias."') LIMIT 1"
  );
    $advert_life = DB(
        "SELECT * FROM `advert_life` WHERE (`news_id`='".$id."') LIMIT 1"
    );
    if($advert_life["total"] != null)
        $advert_life_items = @mysql_fetch_array($advert_life["result"]);

    if ($data["total"] != 1) {
        $AdminText = ATextReplace('Item-Module-Error', $id, "_pages");
        $GLOBAL["error"] = 1;
    } else {
        @mysql_data_seek($data["result"], 0);
        $raz = @mysql_fetch_array($data["result"]);
        $bst = "";

// СОХРАНЕНИЕ ПОЛЕЙ И ФОРМ
        $P = $_POST;
        if (isset($P["savebutton"])) {
            $dtags = ",";
            foreach ($P["tags"] as $k => $v) {
                $dtags .= $k.",";
            }
            $ar = explode(".", $P["ddata1"]);
            $sdata1 = mktime(
              $P["ddata2"],
              $P["ddata3"],
              $P["ddata4"],
              $ar[1],
              $ar[0],
              $ar[2]
          );
            $ar = explode(".", $P["ddata11"]);
            $sdata2 = mktime(
              $P["ddata21"],
              $P["ddata31"],
              $P["ddata41"],
              $ar[1],
              $ar[0],
              $ar[2]
          );

            $q = "UPDATE `".$alias."_lenta` SET 
            `uid`='".(int)$P['authid']."',
            `bid`='".(int)$P['bid']."',
            `name`='".str_replace("'", '&#039;', $P["dname"])."',
            `cat`='".$P["site"]."',
            `kw`='".str_replace("'", '&#039;', $P["dkw"])."', 
            `ds`='".str_replace("'", '&#039;', $P["dds"])."', 
            `cens`='".$P["cens"]."',
            `realinfo`='".str_replace("'", '&#039;', $P["realinfo"])."', 
            `comments`='".$P["comms"]."', 
            `data`='".$sdata1."',
            `astat`='".(int)$P["autoon"]."', 
            `adata`='".$sdata2."', 
            `promo`='".(int)$P["comrs"]."', 
            `spromo`='".(int)$P["scomrs"]."',
            `onind`='".(int)$P["ontv"]."', 
            `spec`='".(int)$P["spec"]."', 
            `yarss`='".$P["yarss"]."', 
            `mailrss`='".$P["mailrss"]."', 
            `tavto`='".(int)$P["tavto"]."', 
            `tags`='".$dtags."',
            `redak`='".(int)$P["redak"]."', 
            `gis`='".(int)$P["gis"]."', 
            `mailtizer`='".(int)$P["mailtizer"]."',
            `main_pronsk` = '".(int)$P['main_pronsk']."',
            `main_column_pronsk` = '".(int)$P['main_column_pronsk']."',
            `left_column_pronsk` = '".(int)$P['left_column_pronsk']."',
            `main_column_pronsk_both` = '".(int)$P['main_column_pronsk_both']."',
            `left_column_pronsk_both` = '".(int)$P['left_column_pronsk_both']."',
            `commerce_column_pronsk_both` = '".(int)$P['commerce_column_pronsk_both']."',
            `dzenrss` = '".$P['dzenrss']."'
            WHERE (id='".(int)$id."')";
            DB(
              "INSERT INTO `_lentalog` (`link`, `id`, `uid`, `data`, `ip`, `text`) VALUES ('".$alias."', '".$id."', '".$_SESSION['userid']."', '".time(
              )."', '".$_SERVER['REMOTE_ADDR']."', 'Сохранение (name): ".str_replace(
                "'",
                '&#039;',
                $P["dname"]
            )."')"
          );

            DB($q);

            if($P["autoon"] == 1 && $sdata2 != null)
            {
                $life_date = $sdata2 + $P['life_days'] * 25 * 60 * 60;
            } else { $life_date = $sdata1 + $P['life_days'] * 25 * 60 * 60; }

            if ($advert_life["total"] == 0 && ($P["comrs"] != null || $P["scomrs"] != null))
            {
                DB("INSERT INTO `advert_life` (`news_id`, `data`, `module`) VALUES ('".(int)$id."', '".$life_date."', '".$alias."_lenta')");
            } else if ($advert_life["total"] == 1 && ($P["comrs"] != null || $P["scomrs"] != null))
            {
                DB(
                    "UPDATE `advert_life` SET 
                    `data`='".$life_date."',
                    `module`='".$alias."_lenta'
                    WHERE news_id='".$id."'"
                );
            } else if ($advert_life["total"] == 1 && $P["comrs"] == null && $P["scomrs"] == null)
            {
                DB("DELETE FROM `advert_life` WHERE `news_id` = '".$id."'");
            }

            $_SESSION["Msg"] = "<div class='SuccessDiv'>Запись успешно сохранена!</div>";
            @header("location: ".$_SERVER["REQUEST_URI"]);
            exit();
        }

        // ВЫВОД ПОЛЕЙ И ФОРМ
        $data = DB(
          "SELECT * FROM `".$alias."_lenta` WHERE (`id`='".(int)$id."') LIMIT 1"
      );
        if ($data["total"] != 1) {
            $AdminText = ATextReplace(
              'ItemError',
              $raz["shortname"]." (".$alias.")",
              $id
          );
            $GLOBAL["error"] = 1;
        } else {

            ### Заполнение данных
            @mysql_data_seek($data["result"], 0);
            $node = @mysql_fetch_array($data["result"]);
            if ($node["stat"] == 1) {
                $chk = "checked";
            }
            if ($node["astat"] == 1) {
                $chk1 = "checked";
            }
            if ($node["promo"] == 1) {
                $chk2 = "checked";
            }
            if ($node["onind"] == 1) {
                $chk3 = "checked";
            }
            if ($node["spec"] == 1) {
                $chk4 = "checked";
            }
            if ($node["yarss"] == 1) {
                $chk5 = "checked";
            }
            if ($node["mailrss"] == 1) {
                $chk6 = "checked";
            }
            if ($node["tavto"] == 1) {
                $chk7 = "checked";
            }
            if ($node["mailtizer"] == 1) {
                $chk8 = "checked";
            }
            if ($node["redak"] == 1) {
                $chk9 = "checked";
            }
            if ($node["gis"] == 1) {
                $chk10 = "checked";
            }
            if ($node["spromo"] == 1) {
                $chk11 = "checked";
            }
            if ($node["dzenrss"] == 1) {
                $chk12 = "checked";
            }

            if ($node['main_pronsk'] == 1) {
                $mainPronsk = 'checked';
            }
            if ($node['main_column_pronsk'] == 1) {
                $mainColumnPronsk = 'checked';
            }
            if ($node['left_column_pronsk'] == 1) {
                $leftColumnPronsk = 'checked';
            }
            if ($node['main_column_pronsk_both'] == 1) {
                $mainColumnPronskBoth = 'checked';
            }
            if ($node['left_column_pronsk_both'] == 1) {
                $leftColumnPronskBoth = 'checked';
            }
            if ($node['commerce_column_pronsk_both'] == 1) {
                $commerceColumnPronskBoth = 'checked';
            }

            if ($node["comments"] == 0) {
                $c1 = "selected";
            } elseif ($node["comments"] == 1) {
                $c2 = "selected";
            } else {
                $c3 = "selected";
            }

            if($node["astat"] == 1 && $node["adata"] != null)
            {
                $advert_life_items["data"] = ($advert_life_items["data"] - $node["adata"]) / 60 / 60 / 24;
            } else { $advert_life_items["data"] = ($advert_life_items["data"] - $node["data"]) / 60 / 60 / 24 ; }

            if ($advert_life_items["data"] == 1) {
                $a_l1 = "selected";
            } elseif ($advert_life_items["data"] == 5) {
                $a_l2 = "selected";
            } elseif ($advert_life_items["data"] == 10) {
                $a_l3 = "selected";
            }

            $utags = explode(",", trim($node["tags"], ","));
            $site = array();
            $data = DB(
              "SELECT `id`, `name` FROM `".$alias."_cats` ORDER BY `rate` DESC"
          );
            for ($i = 0; $i < $data["total"]; $i++): @mysql_data_seek(
              $data["result"],
              $i
          );
                $ar = @mysql_fetch_array($data["result"]);
                $site[$ar["id"]] = $ar["name"]; endfor;
                $usr = array();
                $data = DB(
                  "SELECT `id`, `nick` FROM `_users` WHERE (`role`>0) ORDER BY `nick` ASC"
              );
                for ($i = 0; $i < $data["total"]; $i++): @mysql_data_seek(
                  $data["result"],
                  $i
              );
                    $ar = @mysql_fetch_array($data["result"]);
                    $usr[$ar["id"]] = $ar["nick"]; endfor;

                    /* заявка из баннерной системы */
                    if ($node["bid"] != 0) {
                        $bb = DB(
                          "SELECT * FROM `_banners_orders` WHERE (`zid`='".(int)$node["bid"]."') LIMIT 1"
                      );
                        if ($bb["total"] != 1) {
                            $bst = "<div style='font-size:10px; color:red; margin-top:3px;'>Не найдено выходов статей в баннерной системе с ZID=".(int)$node["bid"]."</div>";
                        } else {
                            @mysql_data_seek($bb["result"], 0);
                            $br = @mysql_fetch_array($bb["result"]);
                            $bst = "<div style='font-size:11px; color:#777; margin-top:4px;'>ZID = <a href='?cat=banners_editorder&id=".(int)$node["bid"]."' target='_blank'>".(int)$node["bid"]."</a>; Выходы: ".str_replace(
                                ",",
                                " ... ",
                                $br["dataart"]
                            )."</div>";
                        }
                    }

                    $AdminText = '<h2>Редактирование: &laquo'.$node["name"].'&raquo;</h2>'.$_SESSION["Msg"]."<form action='".$_SERVER["REQUEST_URI"]."' enctype='multipart/form-data' method='post'>";
                    $AdminText .= "<div class='RoundText'><table>".'<tr class="TRLine0"><td style="width:22%;"></td><td style="width:78%;"></td></tr>

                    <tr class="TRLine0"><td class="VarText">Заголовок материала<star>*</star></td><td class="LongInput">	<input name="dname" id="dname" type="text" value=\''.$node["name"].'\' maxlength="90" style="width:500px; float:left;">
                    <input id="dcount" type="text" title="Осталось символов" style="width:40px; float:right; text-align:center;" value="" readonly>	</td><tr>

                    <tr class="TRLine1"><td class="VarText">Категория</td><td class="LongInput"><div class="sdiv"><select name="site">'.GetSelected(
                        $site,
                        $node["cat"]
                        ).'</select></div></td><tr>
                    <tr class="TRLine0"><td class="VarName"></td><td><a href="javascript:void(0);" onclick="ShowSets();" id="ShowSets">Показать дополнительные настройки</a></td><tr>	
                    <tr class="TRLine0 ShowSets"><td class="VarName">Автор материала</td><td class="LongInput"><div class="sdiv"><select name="authid">'.GetSelected(
                        $usr,
                        $node["uid"]
                        ).'</select></td><tr>
                    <tr class="TRLine1 ShowSets"><td class="VarName">Ключевые слова (keywords)</td><td class="LongInput"><input name="dkw" type="text" value=\''.$node["kw"].'\'></td><tr>
                    <tr class="TRLine0 ShowSets"><td class="VarName">Описание (description)</td><td class="LongInput"><input name="dds" type="text" value=\''.$node["ds"].'\'></td><tr>
                    <tr class="TRLine1 ShowSets"><td class="VarName">Номер ZID (<a href="?cat=banners_order" target="_blank">заявка БС</a>)</td>
                    <td class="LongInput"><input name="bid" type="text" value="'.$node["bid"].'" placeholder="Введите номер BID из баннерной системы">'.$bst.'</td><tr>
                    <tr class="TRLine0 ShowSets"><td class="VarName">Цензор материала</td><td class="LongInput"><input name="cens" type="text" value=\''.$node["cens"].'\'></td><tr>
                    <tr class="TRLine1 ShowSets"><td class="VarName">Источник материала</td><td class="LongInput"><input name="realinfo" type="text" value=\''.$node["realinfo"].'\'></td><tr>
                    <tr class="TRLine0 ShowSets"><td class="VarName">Комментарии</td><td class="LongInput">
                    <div class="sdiv"><select name="comms"><option value="0" '.$c1.'>Чтение и добавление</option><option value="1" '.$c2.'>Только чтение</option><option value="2" '.$c3.'>Запретить комментарии</option></select></div></td><tr>	
                    <tr class="TRLine1 ShowSets"><td class="VarName">Дата создания</td><td class="DateInput">'.GetDataSet(
                        $node["data"],
                        ""
                        ).'</td><tr>
                    <tr class="TRLine0 ShowSets"><td class="VarName">Автопубликация</td><td class="DateInput">'.GetDataSet(
                        $node["adata"],
                        1
                        ).' включить таймер: <input type="checkbox" name="autoon" id="autoon" value="1" '.$chk1.'></td><tr>
                    <tr class="TRLine0 ShowSets"><td class="VarName">Время жизни коммерции</td><td class="LongInput"><div class="sdiv"><select name="life_days"><option value="1" '.$a_l1.'>1 день</option><option value="5" '.$a_l2.'>5 дней</option><option value="10" '.$a_l3.'>10 дней</option></select></div></td><tr>
                    '."</table></div>";

            ### Экспорт материала
                    $AdminText .= "<h2>Отображение и экспорт материала</h2><div class='RoundText TagsList'><table>
                    <tr class='TRLine0'>
                    <td width='1%'></td><td width='1%'></td>
                    <td width='1%'></td><td width='1%'></td>
                    <!--<td width='1%'><input name='gis' id='gis' type='checkbox' value='1' $chk10></td><td width='20%'><b>«Телевизор»</b> Семья</td>-->
                    </tr>
                    <tr class='TRLine1'>
                    <td width='1%'><input name='ontv' id='ontv' type='checkbox' value='1' $chk3></td><td width='20%'><b>«Телевизор»</b> ProKazan</td>
                    <td width='1%'><input name='redak' id='redak' type='checkbox' value='1' $chk9></td><td width='20%'>Редакционная колонка</td>
                    <td width='1%'><input name='tavto' id='tavto' type='checkbox' value='1' $chk7></td><td width='20%'>Выводить Фото в лентах</td>

                    </tr>
                    <tr class='TRLine0'>
                    <td width='1%'><input name='comrs' id='comrs' type='checkbox' value='1' $chk2></td><td width='20%'>Коммерческая новость</td>
                    <td width='1%'><input name='scomrs' id='scomrs' type='checkbox' value='1' $chk11></td><td width='20%'>VIP Коммерческая новость</td>
                    <td width='1%'><input name='spec' id='spec' type='checkbox' value='1' $chk4></td><td width='20%'>Отправить PUSH уведомлением</td>		
                    </tr>
                    <tr class='TRLine1'>
                    <td width='1%'><input name='yarss' id='yarss' type='checkbox' value='1' $chk5></td><td width='20%'>Отправить в <b>Яндекс RSS</b></td>
                    <td width='1%'><input name='mailrss' id='mailrss' type='checkbox' value='1' $chk6></td><td width='20%'>Отправить в <b>Mail RSS</b></td>
                    <td width='1%'><input name='mailtizer' id='mailtizer' type='checkbox' value='1' $chk8></td><td width='20%'>Отправить в <b>Тизер Mail</b></td>
                    </tr>
                    <tr class='TRLine0'>
                    <td width='1%'><input name='dzenrss' id='dzenrss' type='checkbox' value='1' $chk12></td><td width='20%'>Отправить в <b>Яндекс.Дзен</b></td>
                    </tr>
                    </table></div>";

            ###
            ### ProNSK Module config page
            ###
                    $AdminText .= '<h2>Отображение на сайтах</h2>';
                    $AdminText .= '<div class="RoundText TagsList"><table>
                    <tr class="TRLine1">
                    <td><input name="main_pronsk" id="main_pronsk" type="checkbox" value="1" '.$mainPronsk.'></td><td width="20%">Главная новость <b>ProNSK</b></td>
                    <td width="1%"><input name="main_column_pronsk" id="main_column_pronsk" type="checkbox" value="1" '.$mainColumnPronsk.'></td><td width="20%">Основная колонка <b>ProNSK</b></td>
                    <td width="1%"><input name="left_column_pronsk" id="left_column_pronsk" type="checkbox" value="1" '.$leftColumnPronsk.'></td><td width="20%">Боковая колонка <b>ProNSK</b></td>
                    </tr>
                    <tr>
                    <td width="1%"><input name="main_column_pronsk_both" id="main_column_pronsk_both" type="checkbox" value="1" '.$mainColumnPronskBoth.'></td><td width="20%">Отобразить новость <b>в главной колонке</b> в Самаре и Новокуйбышевске</td>
                    <td width="1%"><input name="left_column_pronsk_both" id="left_column_pronsk_both" type="checkbox" value="1" '.$leftColumnPronskBoth.'></td><td width="20%">Отобразить новость <b>в боковой колонке</b> в Самаре и Новокуйбышевске</td>
                    <td width="1%"><input name="commerce_column_pronsk_both" id="commerce_column_pronsk_both" type="checkbox" value="1" '.$commerceColumnPronskBoth.'></td><td width="20%">Коммерческая новость ProNSK.ru</td>
                    </tr>
                    </table></div>';

            ### Список тэгов публикцаций
                    $tags = "";
                    $data = DB("SELECT `id`, `name` FROM `_tags` ORDER BY `name` ASC");
                    $line = 1;
                    for ($i = 0; $i < $data["total"]; $i++): @mysql_data_seek(
                      $data["result"],
                      $i
                  );
                        $ar = @mysql_fetch_array($data["result"]);
                        if (in_array($ar["id"], $utags)) {
                            $chkt = "checked";
                        } else {
                            $chkt = "";
                        }
                        $tags .= "<td width='1%'><input name='tags[".$ar["id"]."]' id='tags[".$ar["id"]."]' type='checkbox' class='tags' value='1' $chkt></td>
                        <td width='20%'>".$ar["name"]."</td>";
                        if (($i + 1) % 3 == 0) {
                            $tags .= "</tr><tr class='TRLine".($line % 2)."'>";
                            $line++;
                            if ($line == 3) {
                                $line = 1;
                            }
                        } endfor;
                        $AdminText .= "<h2>Тэги публикации</h2><div class='InfoH2'>Выберите 2-4 темы, самые подходящие по смыслу публикации:</div><div class='RoundText TagsList' style='max-height:500px;'><table><tr class='TRLine0'>".$tags."</tr></table></div>";

            ### Сохранение
                        $AdminText .= "<div class='CenterText'><input type='submit' name='savebutton' id='savebutton' class='SaveButton' value='Сохранить данные'></div>";

            // ПРАВАЯ КОЛОНКА
                        $AdminRight = "<br><br>
                        <div class='RoundText'><table><tr class='TRLine'><td class='CheckInput'><input type='checkbox' id='RS-".$id."-".$alias."_lenta' ".$chk."></td><td><b>Опубликовано</b></td></tr>
                        <tr><td colspan='2'><hr><div id='dataNow' align='center'><a href='javascript:void(0);' onclick='stanUpData();'>Поставить текущие дату и время</a></div></td></tr></table></div>
                        <div class='SecondMenu2'><a href='?cat=".$alias."_edit&id=".$id."'>Основные настройки</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_photo&id=".$id."'>Основная фотография</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_text&id=".$id."'>Основное содержание</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_cards&id=".$id."'>Виджет: Карточки</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_pretext&id=".$id."'>Виджет: Текстовые поля</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_voting&id=".$id."'>Виджет: Голосование</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_report&id=".$id."'>Виджет: Фото-отчет</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_album&id=".$id."'>Виджет: Фото-альбом</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_film&id=".$id."'>Виджет: Видео-вставка</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_contacts&id=".$id."'>Виджет: Лого и контакты</a></div>
                        <div class='SecondMenu'><a href='?cat=".$alias."_eventmap&id=".$id."'>Виджет: Карта событий</a></div>
                        <br><div class='CenterText'><input type='submit' name='savebutton' id='savebutton' class='SaveButton' value='Сохранить данные'></div><br><br>
                        <div class='SecondMenu2'><a href='/$alias/view/$id/' target='_blank'>Просмотр на сайте</a></div></form>";
                        if ($_SESSION['userrole'] > 2) {
                            $AdminRight .= "<div class='SecondMenu'><a href='?cat=".$alias."_log&id=".$id."'>Лог редактирования записи</a></div>";
                        }

                    }
                }
            }
            $_SESSION["Msg"] = "";
            ?>