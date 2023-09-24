<?php
include('./inc/config.php');
$session_uid='';
$session_googleCode='';
$_SESSION['uid']=''; 
$_SESSION['googleCode']='';
if(empty($session_uid) && empty($_SESSION['uid'])){
  header("Location: ./index.php");
}
?>