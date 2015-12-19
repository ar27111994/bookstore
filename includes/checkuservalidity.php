<?php
session_start();
$emailaddress = md5($_POST["email"]);
$validity = md5($_SESSION['user']); 
if($emailaddress == $validity) {
    echo 1;
}
else {
    echo 0;
}
?>