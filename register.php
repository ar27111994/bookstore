<?php
ob_start();
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet/reset.css">
<link rel="stylesheet" type="text/css" href="stylesheet/fonts/stylesheet.css">
<link rel="stylesheet" type="text/css" href="stylesheet/icons/style.css">
<link rel="stylesheet" type="text/css" href="stylesheet/register.css">
<script src="js/jquery.js"></script>
<script src="js/validate.js"></script>
<meta charset="utf-8">
<title>Login | Register</title>
</head>
<body>
<?php
require "header.inc.php";
?>
<div id="container">
<?php
if(isset($_POST['Login']) && empty($_SESSION['user'])){
	$useremail=MD5($_POST['useremail']);
	$userpassword=MD5($_POST['pswd']);
	include('includes/dbconnect.inc.php');
	try{
	$loginQuery=$checkDatabaseConnection->prepare("SELECT * FROM reader_registration WHERE EMAIL=:email AND PASSWORD=:password");
	$loginQuery->bindParam(':password',$userpassword);
	$loginQuery->bindParam(':email',$useremail);
	$loginQuery->execute();
	$countRows=$loginQuery->rowCount();
	if($countRows==1){
		session_start();
		$_SESSION['user']=$_POST['useremail'];
		echo"<p id='redirect'>Redirecting you to previous page.</p>";
		echo '<input type="hidden" name="location" value="';
		$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/project/index.php';
		unset($_SESSION['redirect_url']);
		header("Location: $redirect_url", true, 303);
		exit;
	}
	else{
		echo"<div id=\"sqlerror\"><h1>Login Failed.</h1>";
		echo"<p>Please Re-Enter Your Email and Password</p>";
		$checkDatabaseConnection=NULL;
		?>
        <div id="signin">
<section><form action="register.php" method="post" onSubmit="return validateLogin();" enctype="multipart/form-data">
<fieldset>
<legend>Sign In</legend>
<table>
<tr><td><label for="user-id">Email:</label></td>
<td><input name="useremail" size="35" id="user-id" type="text" maxlength="100" /></td></tr>
<tr><td><label for="pswd">Password:</label></td>
<td id="loginError" class="error"><input name="pswd" size="35" id="pswrd" type="password" maxlength="15" />
</td></tr>
<tr><td><input type="submit" name="Login" value="Login" /></td></tr>
</table>
</fieldset>
</form></section>
</div>
</div>
<?php
	}
	}
	catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}
else if(isset($_SESSION['user'])){
	echo"<p id=\"sqlerror\">Invalid Approach! You are already Logged In.</p>";
}
else{
?>
<div id="signup">
<section><form action="process.php" onSubmit="return validateRegistration();" method="post">
<fieldset>
<legend>Customer  Registration</legend>
<table>
<tr><td><label for="username">Enter your name (Alphabets Only):</label></td>
<td><input type="text" size="50" name="username" id="username" maxlength="256" /></td></tr>
<tr><td><label for="email">Enter your E-Mail address:</label></td>
<td class="error"><input type="email" size="50" name="email" id="email" maxlength="256" />
<p id="emailError"></p></td></tr>
<tr><td><label for="pswd">Enter a password (maximum 20 characters):</label></td>
<td><input type="password" size="50" name="pswd" id="pswd" maxlength="20" /></td></tr>
<tr><td><label for="confirm_password">Confirm Password</label></td>
<td><input type="password" size="50" name="confirm_password" id="confirm_password" /></td></tr>
<tr><td><label for="address">Enter your Address:</label></td>
<td><input type="text" size="50" id="address" width="500" name="address"></td></tr>
<tr><td><label for="interest">Select your Area Of Interest:</label></td>
<td class="error" id="selectError"><select id="interest" name="inter">
	<option id="select" value="0">Select</option>
	<option value="594">Autobiography</option>
	<option value="65">Animals, Birds &amp; Wildtrfe</option>
	<option value="66">Architecture &amp; Interior Design</option>
	<option value="67">Art, Design &amp; Fashion</option>
	<option value="76">Automobile</option>
	<option value="77">Aviation</option>
	<option value="78">Award Winning Books</option>
	<option value="79">Biographies &amp; Memoirs</option>
	<option value="88">Business, Management &amp; Finance</option>
	<option value="121">Childcare &amp; Parenting</option>
	<option value="122">Coffee Tables</option>
	<option value="123">Computers &amp; Information Technology</option>
	<option value="149">Cooking, Food &amp; Drink</option>
	<option value="159">Current Affairs</option>
	<option value="160">Engineering</option>
	<option value="161">Entertainment</option>
	<option value="163">Fiction</option>
	<option value="167">Games &amp; Sports</option>
	<option value="168">Gardening &amp; Garden Design</option>
	<option value="169">Gift Books</option>
	<option value="170">Graphic Novels</option>
	<option value="171">Guns &amp; Ammunition</option>
	<option value="172">Health</option>
	<option value="173">History</option>
	<option value="174">trterature/Poetry &amp; Drama</option>
	<option value="175">Local Interest</option>
	<option value="177">Mathematics</option>
	<option value="178">Medical Books</option>
	<option value="179">Non-Fiction</option>
	<option value="180">Philosophy</option>
	<option value="181">Potrtics &amp; Social Sciences</option>
	<option value="182">Psychology</option>
	<option value="183">Reduced Price</option>
	<option value="184">Reference</option>
	<option value="185">Retrgion &amp; Spirituatrty</option>
	<option value="186">Science</option>
	<option value="187">Self Help</option>
	<option value="188">Travel</option>
	<option value="189">Urdu Books</option>
	<option value="190">Young Adults</option>
	<option value="330">Children's Books</option>
	<option value="520">Global Affairs</option>
	<option value="523">Performing Arts</option>
	<option value="524">Nature &amp; Ecology</option>
	<option value="528">Weapons &amp; Warfare</option>
	<option value="574">Signed Copies</option>
</select></td></tr>
<tr><td><label for="interest2">Select another Area Of Interest:</label></td>
<td><select id="interest2" name="inter2">
	<option value="0">Select</option>
	<option value="594">Autobiography</option>
	<option value="65">Animals, Birds &amp; Wildtrfe</option>
	<option value="66">Architecture &amp; Interior Design</option>
	<option value="67">Art, Design &amp; Fashion</option>
	<option value="76">Automobile</option>
	<option value="77">Aviation</option>
	<option value="78">Award Winning Books</option>
	<option value="79">Biographies &amp; Memoirs</option>
	<option value="88">Business, Management &amp; Finance</option>
	<option value="121">Childcare &amp; Parenting</option>
	<option value="122">Coffee Tables</option>
	<option value="123">Computers &amp; Information Technology</option>
	<option value="149">Cooking, Food &amp; Drink</option>
	<option value="159">Current Affairs</option>
	<option value="160">Engineering</option>
	<option value="161">Entertainment</option>
	<option value="163">Fiction</option>
	<option value="167">Games &amp; Sports</option>
	<option value="168">Gardening &amp; Garden Design</option>
	<option value="169">Gift Books</option>
	<option value="170">Graphic Novels</option>
	<option value="171">Guns &amp; Ammunition</option>
	<option value="172">Health</option>
	<option value="173">History</option>
	<option value="174">trterature/Poetry &amp; Drama</option>
	<option value="175">Local Interest</option>
	<option value="177">Mathematics</option>
	<option value="178">Medical Books</option>
	<option value="179">Non-Fiction</option>
	<option value="180">Philosophy</option>
	<option value="181">Potrtics &amp; Social Sciences</option>
	<option value="182">Psychology</option>
	<option value="183">Reduced Price</option>
	<option value="184">Reference</option>
	<option value="185">Retrgion &amp; Spirituatrty</option>
	<option value="186">Science</option>
	<option value="187">Self Help</option>
	<option value="188">Travel</option>
	<option value="189">Urdu Books</option>
	<option value="190">Young Adults</option>
	<option value="330">Children's Books</option>
	<option value="520">Global Affairs</option>
	<option value="523">Performing Arts</option>
	<option value="524">Nature &amp; Ecology</option>
	<option value="528">Weapons &amp; Warfare</option>
	<option value="574">Signed Copies</option>
</select></td></tr>
<tr><td><label>Select Gender:</label></td><td class="error" id="radioError"><input type="radio" name="gender" id="male" value="male" />Male
<input type="radio" id="female" name="gender" value="female" />Female</td></tr>
<tr><td><label for="age">Select your age (From 18 to 65 years):</label></td>
<td class="error" id="rangeError"><input type="text" name="age" step="1" id="age"/></td></tr>
<tr><td><label for="image">Upload Your Picture:</label></td>
<td id="fileError" class="error"><input type="file" name="photo" id="image" /></td></tr>
<tr><td><input type="submit" value="Register Yourself" name="signup" /></td></tr>
</table>
</fieldset>
</form></section>
</div>
<div id="signin">
<section><form action="register.php" method="post" onSubmit="return validateLogin();" enctype="multipart/form-data">
<fieldset>
<legend>Sign In</legend>
<table>
<tr><td><label for="user-id">Email:</label></td>
<td><input name="useremail" size="35" id="user-id" type="text" maxlength="100" /></td></tr>
<tr><td><label for="pswd">Password:</label></td>
<td id="loginError" class="error"><input name="pswd" size="35" id="pswrd" type="password" maxlength="15" />
</td></tr>
<tr><td><input type="submit" name="Login" value="Login" /></td></tr>
</table>
</fieldset>
</form></section>
</div>
<?php
}
?>
</div>
<?php
require "footer.inc.php";
?>
</body>
</html>
<?php
ob_end_flush();
?>