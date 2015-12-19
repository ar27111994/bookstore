<?php
session_start();
$book=$_POST['bookid'];
unset($_SESSION['cart'][$book]);
echo 1;
?>