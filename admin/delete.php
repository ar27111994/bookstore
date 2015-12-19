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

if(isset($_GET['bookid'])){
	$bookid=$_GET['bookid'];
	if(isset($_POST['delete'])){
		try{
		$delete="DELETE FROM books WHERE Book_id=:bookid";
		$deleteBookquery=$checkDatabaseConnection->prepare($delete);
		$deleteBookquery->bindParam(':bookid',$bookid);
		$deleteBookquery->execute();
		unset($_POST['delete']);
		echo"<p id=\"sqlerror\">Book Deleted Successfully. Please Click <a href=\"dashboard.php?view=managebooks\">Here</a> to Delete Another One.</p>";
		}
		catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	}
	else{
	
?>
<form method="post">
<p>Do you really want to Delete this Book</p>
<button formaction="delete.php?bookid=<?php echo $bookid;?>" formmethod="post" name="delete">Delete</button>
<button formaction="dashboard.php?view=managebooks" formmethod="post">No, Go Back!</button>
</form>	
</div>
</div>
<?php
}
}


elseif(isset($_GET['rid'])){
	$rid=$_GET['rid'];
	if(isset($_POST['deleter'])){
		try{
		$deleter="DELETE FROM reader_registration WHERE EMAIL=:reader";
		$deleterquery=$checkDatabaseConnection->prepare($deleter);
		$deleterquery->bindParam(':reader',$rid);
		$deleterquery->execute();
	unset($_POST['deleter']);
	echo"<p id=\"sqlerror\">Reader Deleted Successfully. Please Click <a href=\"dashboard.php?view=managereaders\">Here</a> to Delete Another One.</p>";
		}
		catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	}
	else{
	
?>
<form method="post">
<p>Do you really want to Delete this Reader</p>
<button formaction="delete.php?rid=<?php echo $rid;?>" formmethod="post" name="deleter">Delete</button>
<button formaction="dashboard.php?view=managereaders" formmethod="post">No, Go Back!</button>
</form>	
</div>
</div>
<?php
}
}
elseif(isset($_GET['oid'])){
	$oid=$_GET['oid'];
	if(isset($_POST['deleter'])){
		try{
		$deleter="DELETE FROM orders WHERE Order_Id=:order";
		$deleterquery=$checkDatabaseConnection->prepare($deleter);
		$deleterquery->bindParam(':order',$oid);
		$deleterquery->execute();
	unset($_POST['deleter']);
	echo"<p id=\"sqlerror\">Order Deleted Successfully. Please Click <a href=\"dashboard.php?view=manageorders\">Here</a> to Delete Another One.</p>";
		}
		catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	}
	else{
	
?>

<form method="post">
<p>Do you really want to Delete this Order</p>
<button formaction="delete.php?oid=<?php echo $oid;?>" formmethod="post" name="deleter">Delete</button>
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