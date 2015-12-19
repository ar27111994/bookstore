<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet/reset.css">
<link rel="stylesheet" type="text/css" href="stylesheet/fonts/stylesheet.css">
<link rel="stylesheet" type="text/css" href="stylesheet/icons/style.css">
<link rel="stylesheet" type="text/css" href="stylesheet/register.css?version=2">
<title>Email Verification</title>
</head>
<body>
<?php
require 'header.inc.php';
?>
<div id="container">
<?php
include('includes/dbconnect.inc.php');
if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])){
	try{
    $email = md5($_GET['email']);
    $hash = $_GET['hash'];
	$ACCOUNT_STATUS=0;
	$search=$checkDatabaseConnection->prepare("SELECT EMAIL, HASH, ACCOUNT_STATUS FROM reader_registration WHERE EMAIL=:email AND HASH=:hash AND ACCOUNT_STATUS=:ACCOUNT_STATUS");
	$search->bindParam(':email',$email);
	$search->bindParam(':hash',$hash);
	$search->bindParam(':ACCOUNT_STATUS',$ACCOUNT_STATUS);
	$search->execute();
	$match  = $search->rowCount();
	if($match == 1){
	$activate=$checkDatabaseConnection->prepare("UPDATE reader_registration SET ACCOUNT_STATUS=:ACCOUNT_STATUS WHERE EMAIL=:email AND HASH=:hash AND ACCOUNT_STATUS=:ACCOUNT_STATUS");
	$activate->bindParam(':email',$email);
	$activate->bindParam(':hash',$hash);
	$activate->bindParam(':ACCOUNT_STATUS',$ACCOUNT_STATUS);
	$activate->execute();
	echo '<p class="accountstatusmsg">Your account has been activated, you can now login</p>';
	}
	else{
	echo '<p class="accountstatusmsg">The url is either invalid or you already have activated your account.</p>';
	}
	}
	catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
}else{
    echo '<p class="accountstatusmsg">Invalid approach, please use the link that has been sent to your email.</p>';
}
?>
</div>
<?php
require 'footer.inc.php';
?>
</body>
</html>