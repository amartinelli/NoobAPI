<html>
<?php
$time = time()+60*60*24*30;
setcookie('mysheet','red',$time,'/');
header('Location: Site');
exit;
?>
