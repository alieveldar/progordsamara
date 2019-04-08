<?
### СТРОЧНЫЕ ОБЪЯВЛЕНИЯ ######################################################################################################################
$table1=$link."_objects"; $table2=$link."_razdels"; $table3=$link."_users"; $table4=$link."_pays";

$data=DB("SELECT `sets` FROM `_pages` WHERE (`module`='strochki' && `stat`='1') LIMIT 1");
if ($data["total"]!=1) { $text=@file_get_contents($ROOT."/template/404.html"); $cap="Страница не найдена - 404"; $Page404=1;
} else {
	@mysql_data_seek($data["result"], 0);
	$ar=@mysql_fetch_array($data["result"]); $SETS=explode("|", $ar["sets"]);
	if ($start=="") { list($text, $cap)=GetIndex(); }
	if ($start=="result") { list($text, $cap)=GetResult(); }
	if ($start=="pay") { list($text, $cap)=GetPayOnly(); }
	if ($start=="payclear") { list($text, $cap)=GetPayClear(); }
	if ($start=="add") { list($text, $cap)=GetNewAdd(); }
}
$Page["Content"]=$text; $Page["Caption"]=$cap;

#############################################################################################################################################

function GetIndex() {
	global $SETS, $VARS, $GLOBAL, $node, $link, $C15, $C10, $C, $C5; $cap=$node["name"];
	$text="<div class='WhiteBlock'>В этом разделе можно подать строчное объявление в газету «Город» в Самаре и Новокуйбышевске. Если вы хотите узнать все о рекламе в виде модулей или статей — перейдите «<a href='/page867'>Реклама в газете «Pro Город»</a>»</div>".$C15;
	$text.="<a class='rslink' href='/".$link."/add'>Я знаю что такое «Строчное объявление», хочу подать новое объявление</a>
	<a class='rslink' href='/".$link."/pay'>Я — ваш клиент. Хочу заплатить или продлить свое объявление</a>
	<a class='rslink' href='#what'>Что такое строчное объявление</a>
	<a class='rslink' href='#look'>Как выглядит строчное объявление «Pro Город»</a>
	<a class='rslink' href='#work'>Как работает строчное объявление в газете «Pro Город»</a>
	<a class='rslink' href='#price'>Сколько стоит строчное объявление</a>
	<a class='rslink' href='#howpay'>Как оплатить строчное объявление</a>";

	$text.="<a id='what' name='what'></a>".$C15."<div class='rsblock'><h3>Что такое строчное объявление</h3>
	<p>Строчное объявление в газете «Город» (Pro Город) — самый недорогой, но эффективный вид рекламы в популярной газете. Строчное объявление — хороший инструмент, чтобы предложить жителям Самары свои услуги по автоперевозкам, строительству, ремонту техники, сопровождению сделок с недвижимостью. Также многие наши клиенты используют «строчки» для быстрого поиска новых сотрудников.</p>
	<a class='rsbtn' href='/".$link."/add'>Перейти к подаче объявления</a></div>

	<a id='look' name='look'></a>".$C15."<div class='rsblock'><h3>Как выглядит строчное объявление «Pro Город»</h3>
	<p>Строчные объявления в газете «Город» («Pro Город Самара»)  могут быть обычными или с выделением, если Вы хотите повысить эффективность рекламы в  газете «Город» («Pro Город Самара»), то можете воспользоваться дополнительными услугами,  например, выделить строчное объявление красным маркером или цветом, рамкой, жирным шрифтом и заглавными буквами. Также Вы сможете занять интересующую Вас позицию в строчных объявлениях.</p>
	<img src='/modules/strochki/view.jpg' style='width:100%; height:auto; margin:0 0 10px 0;' />
	<a class='rsbtn' href='/".$link."/add'>Перейти к подаче объявления</a></div>



	<a id='work' name='work'></a>".$C15."<div class='rsblock'><h3>Как работает строчное объявление в газете «Pro Город»</h3>
	<p>Реклама в разделе строчных объявлений газеты «Город» («Pro Город Самара») привлекает людей заинтересованных в конкретной товарной категории, облегчает выбор и ускоряет процесс покупки за счет удобной навигации и большого ассортимента товаров и услуг.</p><p>Раздел строчных объявлений в газете «Город» («Pro Город Самара») всегда находится на последних полосах газеты -  это удобно и эффективно. Все предложения собраны в одном месте, что позволяет с легкостью выбрать нужный вариант.</p><p>Отзывы клиентов об эффективности работы рекламы в разделе строчных объявлений газеты «Город» («Pro Город Самара»)</p>
	<img src='/modules/strochki/review1.jpg' style='width:100%; height:auto; margin:0 0 10px 0;' />
	<img src='/modules/strochki/review2.jpg' style='width:100%; height:auto; margin:0 0 10px 0;' />
	<a class='rsbtn' href='/".$link."/add'>Перейти к подаче объявления</a></div>



	<a id='price' name='price'></a>".$C15."<div class='rsblock'><h3>Сколько стоит строчное объявление</h3>
	<p>Стоимость размещения строчных объявлений в газете «Город» («Pro Город Самара») рассчитывается по символам (символ – буква, цифра, знак препинания, пробел).</p><p>Если Вас заинтересовали определенные позиции строчных объявлений или выделения, то нужно умножить стоимость Вашего объявления на повышающий коэффициент, так Вы сможете получить итоговую сумму Вашего строчного объявления газете «Город» («Pro Город Самара»).</p><p>Например, если Вы хотите подать строчное объявление с выделением красным маркером: «Сантехник 24 часа», то количество символов – 17 (330 руб.) умножаем на повышающий коэффициент 2,5. Получается итоговая сумма объявления 330х2,5 – 825 руб.</p>
	<h3>Самара</h3><img src='/modules/strochki/price2.jpg' style='margin:0 0 10px 0;' /><p><b>ОБЪЯВЛЕНИЯ ПРИНИМАЮТСЯ ДО ЧЕТВЕРГА ДО 16:00</b></p>
	<h3>Новокуйбышевск</h3><img src='/modules/strochki/price1.jpg' style='margin:0 0 10px 0;' /><p><b>ОБЪЯВЛЕНИЯ ПРИНИМАЮТСЯ ДО ЧЕТВЕРГА ДО 16:00</b></p>
	<a class='rsbtn' href='/".$link."/add'>Перейти к подаче объявления</a></div>




	<a id='howpay' name='howpay'></a>".$C15."<div class='rsblock'><h3>Как оплатить строчное объявление</h3>
	<p>Подать и оплатить строчное объявление в газете «Город» («Pro Город Самара») можно на сайте progorodsamara.ru  не выходя из дома или офиса. Вам нужно перейти по ссылке <a href='http://progorodsamara.ru/advertise/pay'>progorodsamara.ru/advertise/pay</a> и следовать пошаговой инструкции. Но, если Вы не доверяете техническим новинкам, то можете позвонить нашему менеджеру  по телефону 8-987-922-00-63 или приехать в наш офис по адресу: Московское шоссе 4, стр.15, 7 этаж, офис 705 (ТОЦ «Скала»).</p>
	<a class='rsbtn' href='/".$link."/add'>Перейти к подаче объявления</a></div>



	".$C15; return(array($text, $cap));
}

#############################################################################################################################################

function GetPayClear() { global $dir; $_SESSION['OrderId']=0; SD(); @header("location: /".$dir[0]."/"); exit(); }
function Email_check($Email) { if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($Email))) { return false; } else { return true; }}

#############################################################################################################################################

function GetResult() {
	global $SETS, $VARS, $GLOBAL, $dir, $RealPage, $Page, $node, $table1, $table2, $table3, $table4, $C15, $C10, $C, $C5;
	if ($dir[2]=="success") { $cap="Успешная оплата"; $text='<div class="SuccessDiv">Спасибо! Счет №'.$_SESSION['OrderId'].' успешно оплачен.</div>';
	$text.="<div class='WhiteBlock'><img src='/modules/strochki/success.png' style='float:left; margin:0 15px 0 0;'> <a href='/".$dir[0]."/payclear/'><b><u>Вернуться в раздел</u></b></a>".$C."</div>".$C10; }
	if ($dir[2]=="fail") { $cap="Ошибка оплаты"; $text='<div class="ErrorDiv">Внимание! Возникла ошибка при оплате счета №'.$_SESSION['OrderId'].'.</div>';
	$text.="<div class='WhiteBlock'><img src='/modules/strochki/error.png' style='float:left; margin:0 15px 0 0;'> <a href='/".$dir[0]."/payclear/'><b><u>Вернуться в раздел</u></b></a>".$C."</div>".$C10; }
	$_SESSION['OrderId']=0; SD(); return(array($text, $cap));
}

#############################################################################################################################################

function GetPayOnly() {
	global $SETS, $VARS, $GLOBAL, $dir, $RealPage, $Page, $node, $table1, $table2, $table3, $table4, $C15, $C10, $C, $C5; $cap="Онлайн оплата объявлений";
	if (isset($_SESSION['Data']["sendbutton"])) { $P=$_SESSION['Data'];
		if ($P["name"]=="" || (int)$P["price"]==0) { $msg='<div class="ErrorDiv">Внимание! Поля не заполнены или заполнены неверно.</div>'.$C10; } else {
			if ((int)$_SESSION['OrderId']==0) { DB("INSERT INTO `".$table4."` (`price`,`fio`,`text`,`data`) values ('".(int)$P["price"]."','".str_replace(array("select","in","or","delete","drop","insert","update","<br>","h1","h2","h3","from","union"),"",htmlspecialchars(strip_tags($P["name"])))."','".str_replace(array("select","in","or","delete","drop","insert","update","<br>","h1","h2","h3","from","union"),"",htmlspecialchars(strip_tags($P["textarea"])))."','".time()."')");
			$_SESSION['OrderId']=DBL(); } else { $OrderId=$_SESSION['OrderId']; } $OrderId=$_SESSION['OrderId']; $signature=md5($SETS[0].":".(int)$P["price"].":".(int)$OrderId.":".$SETS[1]);
			$paylink=$SETS[3]."?MrchLogin=".$SETS[0]."&OutSum=".(int)$P["price"]."&InvId=".(int)$OrderId."&SignatureValue=".$signature;
			$msg="<div class='SuccessDiv'>Спасибо! Счет создан осталось оплатить его, перейти к оплате:$C10<div class='WhiteBlock'>".$C5."<b><a href='".$paylink."'><u>Перейти к оплате</u></a></b>$C10<hr>$C10
			Заказ #<b>".(int)$OrderId."</b><br>ФИО: <b>".htmlspecialchars(strip_tags($P["name"]))."</b><br>Сумма: <b>".$P["price"]."</b><br>Комментарий: <b>".htmlspecialchars(strip_tags($P["textarea"]))."</b>".
			$C10."<hr>".$C10."<a href='/".$dir[0]."/payclear/'><b><u>От платежа отказываюсь</u></b></a>".$C5."</div></div>".$C10; $_SESSION['OrderId']=0; SD();
	}}
	$text=$msg; $text.="<div class='WhiteBlock'>".$node["pretext"]."</div>".$C15.'<div class="RoundText" id="Tgg"><form action="/modules/SubmitForm.php?bp='.$RealPage.'" enctype="multipart/form-data" method="post"><table>';
	$text.='<tr class="TRLine0"><td class="VarText">Ваши Ф.И.О.<star>*</star></td><td class="LongInput"><input name="name" type="text" placeholder="Например: Иванов Петр Сергеевич" style="width:550px;"></td></tr>';
	$text.='<tr class="TRLine0"><td class="VarText">Сумма платежа<star>*</star></td><td class="LongInput"><input name="price" type="text" placeholder="Например: 750" style="width:550px;"><br><span style="font:11px/14px Tahoma;">(Сумму платежа за ваши объявления можно уточнить по телефону)</span><br><br></td></tr>';
	$text.='<tr class="TRLine0"><td class="VarText" style="vertical-align:top; padding-top:10px;">Сообщение администратору</td><td class="LongInput"><textarea name="textarea" style="height:60px; width:550px;"></textarea></td></tr>';
	$text.='</table>'.$C10.'<div class="CenterText"><input type="submit" name="sendbutton" id="sendbutton" class="SaveButton" value="Оплатить"></div></form></div>'; return(array($text, $cap));
}


#############################################################################################################################################

function GetNewAdd() { global $SETS, $VARS, $GLOBAL, $dir, $Page, $RealPage, $node, $table1, $table2, $table3, $table4, $C15, $C10, $C, $C5;

	$raz=array(); $prses=array(); $data=DB("SELECT * FROM `".$dir[0]."_razdels` WHERE (`stat`='1') ORDER BY `rate` DESC"); for($i=0; $i<$data["total"]; $i++) { @mysql_data_seek($data["result"], $i); $ar=@mysql_fetch_array($data["result"]); $raz[]=$ar; }
	$sel="<option value='0' selected>--- Выберите раздел размещения ---</option>"; foreach ($raz as $main) { if ($main["pid"]==0) { $sel.="<option style='background:#CCC;' disabled>".$main["name"]."</option>";
	foreach ($raz as $sec) { if ($main["id"]==$sec["pid"]) { $sel.="<option value='".$sec["id"]."'>... ".$sec["name"]."</option>";$prses[$sec["id"]]=$sec["price"]; $prs.="prices[".$sec["id"]."]='".$sec["price"]."';"; }}}}

	$Data=$_SESSION["Data"]; if (isset($Data["regbutton"])) { mb_internal_encoding("UTF-8"); $er=0; $l1=mb_strlen(trim($Data["obj"])); $l2=mb_strlen(trim($Data["phone"])); $ll=$l1+$l2; $arpr=explode(",", $prses[$Data["cat"]]);

	/* 1-самара, 2-новокуйбышевск ar[0]=Math.round(ar[0]*0.57); ar[1]=Math.round(ar[1]*0.68); ar[2]=Math.round(ar[2]*0.81); ar[3]=Math.round(ar[3]*0.83);*/
	if ((int)$Data["city"]==2) { $arpr[0]=round($arpr[0]*0.387); $arpr[1]=round($arpr[1]*0.475); $arpr[2]=round($arpr[2]*0.589); $arpr[3]=round($arpr[3]*0.569); }
	$price=$arpr[3]; if ($ll<151) { $price=$arpr[3]; } if ($ll<101) { $price=$arpr[2]; } if ($ll<51) { $price=$arpr[1]; } if ($ll<31) { $price=$arpr[0]; }
	$sets=$Data["dop1"].",".$Data["dop2"].",".$Data["dop3"].",".$Data["dop4"] . "," . $Data['dop5'];
	$onznak=$price; $datas=explode(",", trim($Data["datss"],",")); $exit=count($datas); $dts=""; foreach($datas as $data) { $dts.=date("d.m.Y", $data).","; } $dts=trim($dts, ",");

	if ((int)$Data["dop1"]==1) { $price=$price*2.3; } if ((int)$Data["dop2"]==1) { $price=$price*1.8; } if ((int)$Data["dop3"]==1) { $price=$price*1.5; } if ((int)$Data["dop4"]==1) { $price=$price*1.5; }
	if ((int)$Data['dop5']==1) { $price*=2.5;}
	/*СКИДКА ЗА СРОК!!!*/ $oneprice=$price; $price=$price*$exit*$Data["hs"];

	$data=DB("INSERT INTO `".$table3."` (`login`,`pass`,`name`,`phone`) VALUES ('auto','".time()."','".$Data["usname"]."','".$Data["usphone"]."')"); $LASTUSER=DBL();

	$q="INSERT INTO `".$dir[0]."_objects` (`uid`, `city`, `text`, `phone`, `rid`, `price`, `stat`, `sets`, `data`, `datas`, `dop`) VALUES ('".$LASTUSER."', '".$Data["city"]."', '".$Data["obj"]."', '".$Data["phone"]."', '".(int)$Data["cat"]."', '$price', '0','".$sets."', '".time()."', '".$dts."', 'Выходов: ".$exit.". Символов: ".$ll.". По разделу: ".$onznak."p. Скидка: ".(100-100*$Data["hs"])."%. ".$oneprice."p. x ".$exit."шт. - ".(100-100*$Data["hs"])."% = ".$price."p.')"; $d=DB($q); $dbl=DBL();

	DB("INSERT INTO `".$dir[0]."_pays` (`uid`, `oid`, `price`, `data`) VALUES ('".$LASTUSER."', '".$dbl."', '".$price."', '".time()."');");  $dpay=DBL();

	$signature=md5($SETS[0].":".(int)$price.":".(int)$dpay.":".$SETS[1]);
	$paylink=$SETS[3]."?MrchLogin=".$SETS[0]."&OutSum=".(int)$price."&InvId=".(int)$dpay."&SignatureValue=".$signature;
	$pay="<a href='".$paylink."' style='color:red;'><b><u>Оплатить</u></b></a>";

	SD(); if ($er==0) { @header("location: ".$paylink); exit(); }

	}

	$text.='<div class="RoundText WhiteBlock" id="Tgg"><script>prices=new Array(); '.$prs.'prices[0]=\'0,0,0,0\';</script>';
	$text.='<form action="/modules/SubmitForm.php?bp='.$RealPage.'" enctype="multipart/form-data" method="post" onsubmit="return SubmitForm();"><table>';
	$text.='<tr class="TRLine0">
	<td class="VarText" style="width:30%;"><b>Ваши данные</b><br><span style="color:#777; font-size:10px;">не публикуется, требуется для уточнения деталей</span></td>
	<td class="LongInput" style="width:30%;"><input name="usname" id="usname" style="width:300px;" placeholder="ФИО" />'.$C10.'
	<input name="usphone" id="usphone" style="width:300px;" placeholder="Телефон для связи" /></td><td style="width:40%;"></td></tr><tr><td colspan="3"><hr></td></tr>

	<tr class="TRLine0"><td class="VarText" style="width:30%;"><b>Выберите город</b></td><td class="LongInput" style="width:30%;">
	<select id="city" name="city" style="width:315px; font-size:13px;" onchange="ChangePrice();"><option value="1">Самара</option><option value="2">Новокуйбышевск</option></select></td><td style="width:40%;"></td></tr>

	<tr class="TRLine0"><td class="VarText" style="width:30%;"><b>Выберите категорию</b></td><td class="LongInput" style="width:30%;">
	<select id="cat" name="cat" style="width:315px; font-size:13px;" onchange="ChangePrice();">'.$sel.'</select></td><td style="width:40%;"></td></tr>

	<tr class="TRLine0"><td class="VarText" style="width:30%;"><b>Текст объявления</b><br><span style="color:#777; font-size:10px;">указывайте здесь только текст, телефон указывается ниже</span></td>
	<td class="LongInput" style="width:30%;"><textarea name="obj" maxlength="140" id="obj" style="width:300px; height:70px;"></textarea><input name="hs" id="hs" value="1" type="hidden" /></td>

	<td style="width:40%; color:#777; font-size:10px;"><div id="stoimost"></div><div class="C10"></div>Символов в объявлении: <b><span id="leng">0</span></b></td></tr>

	<tr class="TRLine0"><td class="VarText"><b>Телефон</b></td><td class="LongInput"><input name="phone" id="phone" style="width:300px;" /></td><td><span style="color:#777; font-size:10px;">входит в общее количество</span></td></tr>

	<tr class="TRLine0"><td class="VarText" colspan="3"><div class="C5"></div><h3>Даты выходов объявлений. Всего выходов: <span id="texit">1</span></h3><div class="C10"></div>
	<i style="font-size:11px; font-family:Arial;color:red;">Выберите желаемые даты выхода вашего объявления, для этого кликните на

    с оттветствующие желтые ячейки календаря. Выход газеты ProГород
    происходит 1 раз в неделю по субботам.
    Внимание! Среда - последний день приема объявлений в текущую неделю</i></td></tr><tr class="TRLine0"><td colspan="3">';

	$n=time();
	if ((date("w")>3 || date("w")==0) && date("d")>24) { $n=$n+7*24*60*60; }
	$num = 31;
	if (date('d') == 31 && date('m') == 1){
		$num = 27;
	}
	$t1 = time();
	//$t2=$n+1*$num*24*60*60; $t3=$t2+31*24*60*60; $t4=$t3+31*24*60*60; $t5=$t4 + 31*24*60*60; $t6=$t5+31*24*60*60; $t7=$t6+31*24*60*60; $t8=$t7+31*24*60*60; $t9=$t8+31*24*60*60; $WasSetDay=0;
	$t2 = strtotime('first day of next month');
	$t3 = strtotime('first day of next month', $t2);
	$t4 = strtotime('first day of next month', $t3);
	$t5 = strtotime('first day of next month', $t4);
	$t6 = strtotime('first day of next month', $t5);
	$t7 = strtotime('first day of next month', $t6);
	$t8 = strtotime('first day of next month', $t7);
	$t9 = strtotime('first day of next month', $t8);

$text.="<table><tr><td width='33%' style='padding:5px;' valign='top'>".CreateCal($t1)."</td><td width='34%' style='padding:5px;' valign='top'>".CreateCal($t2)."</td><td width='33%' style='padding:5px;' valign='top'>".CreateCal($t3)."</td></tr></table>"
.$C15."<table><tr><td width='33%' style='padding:5px;' valign='top'>".CreateCal($t4)."</td><td width='34%' style='padding:5px;' valign='top'>".CreateCal($t5)."</td><td width='33%' style='padding:5px;' valign='top'>".CreateCal($t6)."</td></tr></table>"
.$C15."<table><tr><td width='33%' style='padding:5px;' valign='top'>".CreateCal($t7)."</td><td width='34%' style='padding:5px;' valign='top'>".CreateCal($t8)."</td><td width='33%' style='padding:5px;' valign='top'>".CreateCal($t9)."</td></tr></table>";

	$text.='</td></tr><tr class="TRLine0"><td colspan="3"><i style="font-size:11px; font-family:Arial;">При размещении объявления на длительный период (от 4 выходов газеты подряд) действуют значительные скидки: 4 выходов и более - 15%, 12 выходов и более - 20%, 27 выходов и более - 25%</i></td></tr><tr class="TRLine0">

	<td class="VarText" colspan="3"><h3>Сделайте ваше объявление более заметным, изменив стандартное оформление с помощью дополнительных возможностей!</h3></td></tr><tr class="TRLine0"><td colspan="3">

	<input type="hidden" name="dop1" value="0" /><input type="hidden" name="dop2" value="0" /><input type="hidden" name="dop3" value="0" /><input type="hidden" name="dop4" value="0" />
	<input type="checkbox" id="dop1" name="dop1" value="1" />  <span style="background-color:#FF8C00">выделено цветом</span><span style="color:#777; font-size:10px;"> ... увеличение стоимости объявления в  <b>2.3 раза</b></span><div class="C5"></div>
   <input type="checkbox" id="dop2" name="dop2" value="1" /> <span style="border-top:solid black;border-bottom:solid black;border-width:1 px;">выделено  рамкой</span><span style="color:#777; font-size:10px;"> ... увеличение стоимости объявления в  <b>1.8 раза</b></span>

	<div class="C5"></div>

    <input type="checkbox" id="dop3" name="dop3" value="1" /> <b> выделено  жирным шрифтом</b><span style="color:#777; font-size:10px;"> ... увеличение стоимости объявления в  <b>1.5 раза</b></span><div class="C5"></div>
    <input type="checkbox" id="dop4" name="dop4" value="1" checked /><b> ВЫДЕЛЕНО ЗАГЛАВНЫМИ БУКВАМИ</b><span style="color:#777; font-size:10px;"> ... увеличение стоимости объявления в  <b>1.5 раза</b></span><div class="C5"></div>
    <input type="checkbox" id="dop5" name="dop5" value="1" /> <span style="color:#f00;">выделение красным маркером</span><span style="color:#777; font-size:10px;"> ... увеличение стоимости объявления в  <b>2.5 раза</b></span>

	</td></tr><tr class="TRLine0"><td class="VarText" colspan="3"><hr></td></tr><tr class="TRLine0"><td><b>Стоимость одного выхода:</b><br><div id="sum" class="summa">0<b>р.</b></div></td>
	<td><b>Скидка за долгосрок:</b><br><div id="skidka" class="summa">0<b>%</b></div></td><td><b>Общая стоимость:</b><br><div id="sumall" class="summa">0<b>.</b></div></td></tr><tr class="TRLine0"><td class="VarText" colspan="3" id="tmp">
	<hr>После добавления объявления, вы будете перенаправлены на страницу оплаты этого объявления.<hr></td></tr>';
	$text.='</table>'.$C5.'<div class="CenterText"><input type="hidden" id="datss" name="datss">
	<input type="submit" name="regbutton" class="SaveButton" value="Создать объявление и перейти к оплате" style="width:300px;">
	</div><
	//form><div class="C10"></div></div>';
	$text.=$C10."";
$cap="Добавить новое объявление"; return(array($text, $cap)); }


#############################################################################################################################################

function CreateCal($tm) {
	global $GLOBAL, $WasSetDay; list($n,$Y,$t,$m)=explode(".", date("n.Y.t.m", $tm)); $dw=1; $text="<div style='text-align:center; margin:0 0 7px 0;'><b>".$GLOBAL["mothi"][$n]." ".$Y."</b></div><table class='Calendar'>
	<tr class='DayWeek'><td>ПН</td><td>ВТ</td><td>СР</td><td>ЧТ</td><td>ПТ</td><td>СБ</td><td>ВС</td></tr><tr>";
	$fd=date("w", strtotime("01-$m-$Y")); if ($fd==0) { $fd=7; } if ($fd!=1) { for ($j=1; $j<$fd; $j++) { $text.="<td></td>"; $dw++; }} if ($dw%7==1) { $dw=1; }
	for ($i=1; $i<=$t; $i++) { if ($i<10) { $j="0".$i; } else { $j=$i; } $mk=strtotime("$j-$m-$Y"); if ($dw%6!=0 || $mk<time()) { $text.="<td class='DayNoExit'>".$i."</td>"; } else {
	if ($WasSetDay==0) { $WasSetDay=1; $text.="<td class='DaySel DayEnabled' title='".$mk."'>".$i."</td>"; } else { $text.="<td class='DaySel' title='$mk'>".$i."</td>"; }}
	$dw++; if ($dw%7==1) { $text.="</tr><tr>"; $dw=1; }} if ($dw!=1) { for ($j=$dw; $j<8; $j++) { $text.="<td></td>"; }} $text.="</tr></table>"; return $text;
}

?>
