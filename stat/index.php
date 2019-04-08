<?php
session_start();
header('Content-type: text/html; charset=utf-8');
include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/user_check.php');
include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/_globals.php');
include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/functions.php');
if($state != 1) {
include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/loginform.php');
}
else if($state == 1) {
include('/home/admin/domains/progorodsamara.ru/public_html/stat/include/content.php');
}
?>