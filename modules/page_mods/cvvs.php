<?
$Page["RightContent"] = $Page["LeftContent"] = $Page["Content"] = $Page["Caption"] = "";
$cap = $node["name"];
$text = "";
$Page["Title"] = $cap;
$Page["TopContent"] .= $C20."<h1 align='center'>".$cap."</h1>".$C10."<div>".$node["text"]."</div>";
#$Page["TopContent"].=UsersComments("news", 180263, 1);
?>