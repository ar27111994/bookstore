<?php
session_start();
if(isset($_POST['logout'])){
	$_SESSION=array();
	session_destroy();
	header("Location:index.php");
}
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../stylesheet/reset.css">
<link rel="stylesheet" type="text/css" href="../stylesheet/fonts/stylesheet.css">
<link type="text/css" rel="stylesheet" href="../stylesheet/dashboard.css">
<script src="../js/jquery.js"></script>
<script src="../js/validate.js"></script>
<meta charset="utf-8">
<title>Administrator Dashboard</title>
</head>
<body>
<?php
if(isset($_SESSION['admin'])){
	include('../includes/dbconnect.inc.php');
?>
<header>
<div id="topbar">
<nav>
<ul>
<li><a href="">Add Keyword</a></li>
<li><a href="">Remove Keyword</a></li>
</ul>
</nav>
<div id="logout">
<form action="edit.php" method="post"><input type="submit" name="logout" value="Logout"></form>
</div>
</div>
<div id="subheader">
<a href="dashboard.php"><h1 id="logo" align="center"><img src="../images/dash-logo.png">Administrator Dashboard</h1></a>
</div>
</header>
<div id="container">
<aside id="cat">
<nav>
<ul>
<li><a href="dashboard.php?view=addbooks">Add Book</a></li>
<li><a href="dashboard.php?view=managebooks">Edit / Remove Book</a></li>
<li><a href="dashboard.php">Manage Readers</a></li>
<li><a href="dashboard.php">Manage Orders</a></li>
<li><a href="dashboard.php">Manage Categories</a></li>
</ul>
</nav>
</aside>
<div id="content">
<?php

if(isset($_GET['oid'])){
	$oid=$_GET['oid'];
	$status=1;
	if(isset($_POST['update'])){
		try{
		$status="UPDATE orders SET `Order Status`=:status WHERE Order_Id=:oid";
		$statusquery=$checkDatabaseConnection->prepare($status);
		$statusquery->bindParam(':oid',$oid);
		$statusquery->bindParam(':status',$status);
		$statusquery->execute();
		unset($_POST['update']);
		echo"<p id=\"sqlerror\">Order Fullfilled Successfully. Please Click <a href=\"dashboard.php?view=manageorders\">Here</a> to Fulfill Another One.</p>";
		}
		catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	}
	else{
	
?>
<form method="post">
<p>Do you really want to Fullfill this Order</p>
<button formaction="fullfill.php?oid=<?php echo $oid;?>" formmethod="post" name="update">Fullfill</button>
<button formaction="dashboard.php?view=manageorders" formmethod="post">No, Go Back!</button>
</form>	
</div>
</div>
<?php
}
}


}
else{
	echo'<p id="sqlerror">Invalid Approach!.</p>';
}
?>
</body>
</html>