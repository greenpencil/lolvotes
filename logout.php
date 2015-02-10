<?php
header('Location: index.php');
setcookie("username", "", time()-3600);
?>