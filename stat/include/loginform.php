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
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
    </style>
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <form class="form-signin" method="post" action="/">
        <h2 class="form-signin-heading">Про "Сотрудники"</h2>
        <input type="text" name="login" class="input-block-level" placeholder="Логин">
        <input type="password" name="pass" class="input-block-level" placeholder="Пароль">
        <button class="btn btn-large btn-primary" type="submit" name="submit">Войти</button>
		<div style="font=size:12px;line-height:23px;float:right;">
		$loginerror<br>
		$passerror
		</div>
      </form>
    </div> <!-- /container -->
  </body>
</html>
HTML;
?>