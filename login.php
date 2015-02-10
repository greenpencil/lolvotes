<?php
include('core.php');
$core = new core;

if($core->checkLogin($_POST['username'],$_POST['password']) == true)
{
    setcookie("username", $_POST['username'], time()+3600);
    header("Location:".$_POST['page']);
}
else
{
    header("Location:".$_POST['page'] . "?error=login");
}
?>