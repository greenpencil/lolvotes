<?php
include('core.php');
$core = new core;

if(isset($_COOKIE['username']))
{
    $core->makeVote($_POST['gameid'],$core->getIDfromName($_COOKIE['username']),$_POST['votetype'],$_POST['winnervote']);
    header("Location:".$_POST['page']."?error=vote");
}
else
{
    header("Location:".$_POST['page']."?error=loggedin");

}

?>