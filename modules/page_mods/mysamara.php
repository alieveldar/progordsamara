<?

$news = DB(
  "SELECT `id`,`picoriginal`,`username` FROM `_widget_insta` WHERE (`stat`=1) ORDER BY `data` DESC LIMIT 9"
);
$arn = array();
if ($news["total"] > 1) {
    for ($i = 0; $i < $news["total"]; $i++): @mysql_data_seek(
      $news["result"],
      $i
    );
        $ar = @mysql_fetch_array($news["result"]);
        $arn[] = $ar; endfor;
}

$text .= "<table width='100%' border='0' cellspacing='0' cellpadding='2' class='iworks'><tr>
	<td colspan='2' rowspan='2' width='50%'><a href='".$arn[0]["picoriginal"]."' title='Автор: ".$arn[0]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[0]["picoriginal"]."' alt='Автор: ".$arn[0]["username"]."' title='Автор: ".$arn[0]["username"]."' /></a></td>
	<td width='25%'><a href='".$arn[1]["picoriginal"]."' title='Автор: ".$arn[1]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[1]["picoriginal"]."' alt='Автор: ".$arn[1]["username"]."' title='Автор: ".$arn[1]["username"]."' /></a></td>
	<td width='25%'><a href='".$arn[2]["picoriginal"]."' title='Автор: ".$arn[2]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[2]["picoriginal"]."' alt='Автор: ".$arn[2]["username"]."' title='Автор: ".$arn[2]["username"]."' /></a></td>
</tr><tr>
	<td width='25%'><a href='".$arn[3]["picoriginal"]."' title='Автор: ".$arn[3]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[3]["picoriginal"]."' alt='Автор: ".$arn[3]["username"]."' title='Автор: ".$arn[3]["username"]."' /></a></td>
	<td width='25%'><a href='".$arn[4]["picoriginal"]."' title='Автор: ".$arn[4]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[4]["picoriginal"]."' alt='Автор: ".$arn[4]["username"]."' title='Автор: ".$arn[4]["username"]."' /></a></td>
</tr><tr>
	<td width='25%'><a href='".$arn[5]["picoriginal"]."' title='Автор: ".$arn[5]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[5]["picoriginal"]."' alt='Автор: ".$arn[5]["username"]."' title='Автор: ".$arn[5]["username"]."' /></a></td>
	<td colspan='3' rowspan='3' width='75%'><a href='".$arn[6]["picoriginal"]."' title='Автор: ".$arn[6]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[6]["picoriginal"]."' alt='Автор: ".$arn[6]["username"]."' title='Автор: ".$arn[6]["username"]."' /></a></td>
</tr>
	<tr><td width='25%'><a href='".$arn[7]["picoriginal"]."' title='Автор: ".$arn[7]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[7]["picoriginal"]."' alt='Автор: ".$arn[7]["username"]."' title='Автор: ".$arn[7]["username"]."' /></a></td></tr>
	<tr><td width='25%'><a href='".$arn[8]["picoriginal"]."' title='Автор: ".$arn[8]["username"]."' rel='prettyPhoto[gallery]'><img src='".$arn[8]["picoriginal"]."' alt='Автор: ".$arn[8]["username"]."' title='Автор: ".$arn[9]["username"]."' /></a></td></tr>
</table>";

$Page["Content"] = "<div id='works'>".$text."</div><div class='C10'></div><script>var lastid='".$ar["id"]."';</script><div id='More' style='text-align:center;'><a href='javascript:void(0)' onclick='ShowMore()'><img src='/template/instasamara/dot.jpg'></a></div>";
?>