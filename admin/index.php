<?php
session_start();
?>
<!doctype html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="../stylesheet/reset.css">
<link type="text/css" rel="stylesheet" href="../stylesheet/fonts/stylesheet.css">
<link type="text/css" rel="stylesheet" href="../stylesheet/adminlogin.css">
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../js/validate.js"></script>
<meta charset="utf-8">
<title>Administrator</title>
</head>
<body>
<div id="adminLogin">
<?php
if(isset($_POST['Login']) && empty($_SESSION['admin'])){
	$admin=MD5($_POST['admin']);
	$adminpassword=MD5($_POST['password']);
	include('../includes/dbconnect.inc.php');
	try{
	$loginQuery="SELECT * FROM admin WHERE ADMIN_NAME=:admin AND ADMIN_PASSWORD=:adminpassword";
	$loginQueryResult=$checkDatabaseConnection->prepare($loginQuery);
	$loginQueryResult->bindParam(':admin',$admin);
	$loginQueryResult->bindParam(':adminpassword',$adminpassword);
	$loginQueryResult->execute();
	$countRows=$loginQueryResult->rowCount();
	if($countRows==1){
		$_SESSION['admin']=$_POST['admin'];
		echo"<p id='redirect'>Redirecting you to previous page.</p>";
		echo '<input type="hidden" name="location" value="';
		$redirect_url = '/project/admin/dashboard.php';
		header("Location: $redirect_url", true, 303);
		exit;
	}
	else{
		echo"<div id=\"sqlerror\"><h1>Login Failed.</h1>";
		echo"<p>Please Re-Enter Admin Username and Password</p></div>";
		mysqli_close($checkDatabaseConnection);
		?>
<form name="adminLogin" action="../admin/index.php" method="post" onSubmit="return validateAdminLogin();">
<fieldset>
<legend>Admin Login</legend>
<table>
<tr><td><label for="admin">Username:</label></td>
<td><input name="admin" size="35" id="admin" type="text" maxlength="100" id="admin" /></td></tr>
<tr><td><label for="password">Password:</label></td>
<td id="adminLoginError" class="error"><input name="password" size="35" id="password" type="password" />
<p></p>
</td></tr>
<tr><td><input type="submit" name="Login" value="Login" /></td></tr>
</table>
</fieldset>
</form>
<?php
	}
		}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }

}
else if(isset($_SESSION['admin'])){
	echo"<p id=\"sqlerror\">Invalid Approach! You are already Logged In.</p>";
}
else{
?>
<form name="adminLogin" action="../admin/index.php" method="post" onSubmit="return validateAdminLogin();">
<fieldset>
<legend>Admin Login</legend>
<table>
<tr><td><label for="admin">Username:</label></td>
<td><input name="admin" size="35" id="admin" type="text" maxlength="100" /></td></tr>
<tr><td><label for="password">Password:</label></td>
<td id="adminLoginError" class="error"><input name="password" size="35" id="password" type="password" />
<p></p>
</td></tr>
<tr><td><input type="submit" name="Login" value="Login" /></td></tr>
</table>
</fieldset>
</form>
<?php
}
?>
</div>
</body>
</html>