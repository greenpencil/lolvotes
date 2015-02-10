<?php
include('../core.php');
$core = new core;

echo $core->awardUsers($_GET['gameid'],$_GET['winner'])
?>