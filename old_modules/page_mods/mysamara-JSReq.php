<?
session_start(); $dir=explode("/", $_SERVER['HTTP_REFERER']); $HTTPREFERER=$dir[2];
if ($HTTPREFERER==$_SERVER['HTTP_HOST']) {
	
	$GLOBAL["sitekey"]=1; $error=0;
	@require $_SERVER['DOCUMENT_ROOT']."/modules/standart/DataBase.php";
	@require $_SERVER['DOCUMENT_ROOT']."/modules/standart/JsRequest.php";
	$JsHttpRequest=new JsHttpRequest("utf-8");
	
	// полученные данные ================================================
	$R = $_REQUEST; $id=preg_replace('/[^a-z0-9_]+/i', '', $R["id"]);
	
	// отправка данных ================================================
	$result["code"]=0; $result["text"]=""; $result["lastid"]=$id; $part=time(); $result["part"]=$part;
	
	$news=DB("SELECT `id`,`picoriginal`,`username` FROM `_widget_insta` WHERE (`stat`=1 && `id`<'".$id."') ORDER BY `data` DESC LIMIT 9"); $arn=array();
	if ($news["total"]>1) { for ($i=0; $i<$news["total"]; $i++): @mysql_data_seek($news["result"], $i); $ar=@mysql_fetch_array($news["result"]); $result["lastid"]=$ar["id"]; $arn[]=$ar; endfor;
	
	$result["text"].="<table width='100%' border='0' cellspacing='0' cellpadding='2' class='iworks'><tr>
	<td colspan='2' rowspan='2' width='50%'><a href='".$arn[0]["picoriginal"]."' title='Автор: ".$arn[0]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[0]["picoriginal"]."' alt='Автор: ".$arn[0]["username"]."' title='Автор: ".$arn[0]["username"]."' /></a></td>
	<td width='25%'><a href='".$arn[1]["picoriginal"]."' title='Автор: ".$arn[1]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[1]["picoriginal"]."' alt='Автор: ".$arn[1]["username"]."' title='Автор: ".$arn[1]["username"]."' /></a></td>
	<td width='25%'><a href='".$arn[2]["picoriginal"]."' title='Автор: ".$arn[2]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[2]["picoriginal"]."' alt='Автор: ".$arn[2]["username"]."' title='Автор: ".$arn[2]["username"]."' /></a></td>
</tr><tr>
	<td width='25%'><a href='".$arn[3]["picoriginal"]."' title='Автор: ".$arn[3]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[3]["picoriginal"]."' alt='Автор: ".$arn[3]["username"]."' title='Автор: ".$arn[3]["username"]."' /></a></td>
	<td width='25%'><a href='".$arn[4]["picoriginal"]."' title='Автор: ".$arn[4]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[4]["picoriginal"]."' alt='Автор: ".$arn[4]["username"]."' title='Автор: ".$arn[4]["username"]."' /></a></td>
</tr><tr>
	<td width='25%'><a href='".$arn[5]["picoriginal"]."' title='Автор: ".$arn[5]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[5]["picoriginal"]."' alt='Автор: ".$arn[5]["username"]."' title='Автор: ".$arn[5]["username"]."' /></a></td>
	<td colspan='3' rowspan='3' width='75%'><a href='".$arn[6]["picoriginal"]."' title='Автор: ".$arn[6]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[6]["picoriginal"]."' alt='Автор: ".$arn[6]["username"]."' title='Автор: ".$arn[6]["username"]."' /></a></td>
</tr>
	<tr><td width='25%'><a href='".$arn[7]["picoriginal"]."' title='Автор: ".$arn[7]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[7]["picoriginal"]."' alt='Автор: ".$arn[7]["username"]."' title='Автор: ".$arn[7]["username"]."' /></a></td></tr>
	<tr><td width='25%'><a href='".$arn[8]["picoriginal"]."' title='Автор: ".$arn[8]["username"]."' rel='prettyPhoto".$part."[gallery]'><img src='".$arn[8]["picoriginal"]."' alt='Автор: ".$arn[8]["username"]."' title='Автор: ".$arn[9]["username"]."' /></a></td></tr>
</table>";
}
	
	
	if ($news["total"]==9) { $result["code"]=1; }
	
} else { $result=array("Code"=>0, "Text"=>"--- Security alert ---", "Class"=>"ErrorDiv", "Comment"=>''); }

// отправляемые данные ==============================================
$GLOBALS['_RESULT']	= $result;
?>