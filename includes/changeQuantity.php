<?php
session_start();
$quantity=$_POST['quantity'];
$id=$_POST['id'];
$_SESSION['cart'][$id]['quantity']=$quantity;
if(isset($_SESSION['cart'][$id]['quantity'])){
echo 1;
}
?>