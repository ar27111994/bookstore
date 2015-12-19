<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet/reset.css">
<link rel="stylesheet" type="text/css" href="stylesheet/fonts/stylesheet.css">
<link rel="stylesheet" type="text/css" href="stylesheet/icons/style.css">
<link rel="stylesheet" type="text/css" href="stylesheet/register.css?version=2">
</script>
<meta charset="utf-8">
<title>Unsubscribe</title>
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
	$search->prepare("DELETE FROM subscribers WHERE Subscription_Email=:email AND HASH=:hash");
	$search->bindParam(':email',$email);
	$search->bindParam(':hash',$hash);
	$search->execute();
	if($search->rowCount()>0){
	echo '<p class="accountstatusmsg">Successfully Unsubscribed.</p>';
	}
	else{
	echo '<p class="accountstatusmsg">The url is either invalid or you already have unsubscribed.</p>';
	}
	}
	catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
}
	else{
    echo '<p class="accountstatusmsg">Invalid approach, please use the link that has been sent to your email.</p>';
}
?>
</div>
<?php
require 'footer.inc.php';
?>
</body>
</html>