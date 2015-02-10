<?php
include('core.php');
$core = new core;

$username = $_POST['username'];
$password = $_POST['password'];
$verifypassword = $_POST['verifypassword'];
$email = $_POST['email'];

if(strcmp($password,$verifypassword))
{
    header("Location:".$_POST['page']."?error=password");
}
elseif($core->checkUserExists($username) > 0)
{
    header("Location:".$_POST['page']."?error=username");
}
elseif($core->checkEmailExists($email) > 0)
{
    header("Location:".$_POST['page']."?error=email");
}
elseif(strlen($username) < 3)
{
    header("Location:".$_POST['page']."?error=usernamelengthsm");
}
elseif(strlen($username) > 21)
{
    header("Location:".$_POST['page']."?error=usernamelengthlr");
}
else
{
    $core->createUser($username,$password,$email);
    header("Location:".$_POST['page']."?error=none");
}
?>