<?
session_start();
if ($_SESSION['userrole']>=2) {
	$GLOBAL["sitekey"]=1;
	@require "../../../modules/standart/DataBase.php";
	@require "../../../modules/standart/Settings.php";
	@require "../../../modules/standart/JsRequest.php";
	$JsHttpRequest=new JsHttpRequest("utf-8");
	// полученные данные ================================================
	
	$R=$_REQUEST;
	$parent=(int)$R["pid"];
	$item=(int)$R["id"];
	$items=$R["id"];
	$table="tests_answers";///tests_answers
	$pic=$R["pic"];
	$file = '';

		
	// операции =========================================================
	
	if ($R["act"]=="DEL") {
		$data = DB("SELECT `pic` FROM `".$table."` WHERE (`id` IN (".$items."))");
		for ($i=0; $i<$data["total"]; $i++){
			@mysql_data_seek($data["result"], $i);
			$ar=@mysql_fetch_array($data["result"]); 
			foreach ($GLOBAL['AutoPicPaths'] as $path=>$size) {
			@unlink($ROOT."/userfiles/".$path."/".$ar['pic']); }
		}
		DB("DELETE FROM `".$table."` WHERE (`id` IN (".$items."))");
	}
	
	// операции =========================================================
	
	if ($R["act"]=="DOWN") {
		$data=DB("SELECT id, rate FROM `".$table."` WHERE (`pid`='".$parent."' && `rate`>=(SELECT `rate` FROM `".$table."` WHERE (`id`='".$item."')) && `point`='report') ORDER BY `rate` ASC LIMIT 2");
		$t="SELECT id, rate FROM `".$table."` WHERE (`pid`='".$parent."' && `rate`>=(SELECT `rate` FROM `".$table."` WHERE (`id`='".$item."')) && `point`='report') ORDER BY `rate` DESC LIMIT 2";
		if ($data["total"]==2) { 
		@mysql_data_seek($data["result"], 0);
		$a1=@mysql_fetch_array($data["result"]);
		@mysql_data_seek($data["result"], 1); 
		$a2=@mysql_fetch_array($data["result"]);
		$res=DB("INSERT INTO `".$table."` (`id`, `rate`) VALUE ('".$a1["id"]."','".$a2["rate"]."'), ('".$a2["id"]."','".$a1["rate"]."') ON DUPLICATE KEY UPDATE `rate`=values(`rate`)");
		$t.="<hr>INSERT INTO `".$table."` (`id`, `rate`) VALUE ('".$a1["id"]."','".$a2["rate"]."'), ('".$a2["id"]."','".$a1["rate"]."') ON DUPLICATE KEY UPDATE `rate`=values(`rate`)".$data["total"]; }
	}	
	
	// операции =========================================================
	
	if ($R["act"]=="UP") {
		$data=DB("SELECT id, rate FROM `".$table."` WHERE (`pid`='".$parent."' && `rate`<=(SELECT `rate` FROM `".$table."` WHERE (`id`='".$item."')) && `point`='report') ORDER BY `rate` DESC LIMIT 2");
		$t="SELECT id, rate FROM `".$table."` WHERE (`pid`='".$parent."' && `rate`<=(SELECT `rate` FROM `".$table."` WHERE (`id`='".$item."')) && `point`='report') ORDER BY `rate` ASC LIMIT 2";
		if ($data["total"]==2) { 
		@mysql_data_seek($data["result"], 0);
		$a1=@mysql_fetch_array($data["result"]);
		@mysql_data_seek($data["result"], 1);
		$a2=@mysql_fetch_array($data["result"]);
		$res=DB("INSERT INTO `".$table."` (`id`, `rate`) VALUE ('".$a1["id"]."','".$a2["rate"]."'), ('".$a2["id"]."','".$a1["rate"]."') ON DUPLICATE KEY UPDATE `rate`=values(`rate`)");
		$t.="<hr>INSERT INTO `".$table."` (`id`, `rate`) VALUE ('".$a1["id"]."','".$a2["rate"]."'), ('".$a2["id"]."','".$a1["rate"]."') ON DUPLICATE KEY UPDATE `rate`=values(`rate`) ".$data["total"]; }
	}

	$result["content"]="ok";
	$GLOBALS['_RESULT']	= $result;
}
?>