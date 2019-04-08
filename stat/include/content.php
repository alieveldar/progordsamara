<?
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>$App_Name</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="$App_Desc">
    <meta name="author" content="$App_Developer">
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="/css/datepicker.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="masthead">
        <h3 class="muted">
			<a href="/">$App_Name</a>
			<div style="margin:0px auto; float:right;font-size:14px;line-height:20px;">
				$App_Template[Login_Text], <a href="/?exit=1">$App_Template[Logout_Text]</a><br><a href="#profile" data-toggle="modal">$App_Template[Change_Password_Text]</a>
			</div>
		</h3> 
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
HTML;
			ReturnMenu();
echo <<<HTML

            </div>
          </div>
        </div><!-- /.navbar -->

HTML;

if (!isset($_GET['go'])) 
	{
	include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/index.php');	
	}
else if ($_GET['go']=="dept") 
	{
	include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/dept.php');
	}
else if ($_GET['go']=="workers") 
	{
	include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/workers.php');
	}
else if ($_GET['go']=="meetings") 
	{
    include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/meetings.php');
	}
else if ($_GET['go']=="stats") 
	{
    include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/stats.php');
	}
else 
	{
	echo $Errors['No_Module'];
	}
include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/footer.php');
include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/profilemodule.php');
echo <<<HTML
	<script src="/js/jquery.js"></script>
	<script src="/ajax/java.js"></script>
	<script src="/js/bootstrap-transition.js"></script>
	<script src="/js/bootstrap-modal.js"></script>
	<script src="/js/bootstrap-datepicker.js"></script>
</body>
</html>
HTML;
?>