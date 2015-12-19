<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet/reset.css">
<link rel="stylesheet" type="text/css" href="stylesheet/fonts/stylesheet.css">
<link rel="stylesheet" type="text/css" href="stylesheet/icons/style.css">
<link rel="stylesheet" type="text/css" href="stylesheet/register.css?version=2">
</script>
<meta charset="utf-8">
<title>User Registration</title>
</head>
<body>
<?php
require "header.inc.php";
?>
<div id="container">
<?php
if(isset($_POST['signup'])){
include('includes/dbconnect.inc.php');
try{
$sendTo=$_POST["email"];
$username=$_POST["username"];
$email=md5($_POST["email"]);
$password=md5($_POST["pswd"]);
$address=$_POST["address"];
$interest1=$_POST["inter"];
$interest2=$_POST["inter2"];
$gender=$_POST["gender"];
$age=$_POST["age"];
$photo=$_POST["photo"];
$accountStatus=0;
$hash = md5( rand(0,1000) );
$q=$checkDatabaseConnection->prepare("insert into reader_registration values(:username,:email,:password,:address,:interest1,:interest2,:gender,:age,:photo,:hash,:accountStatus)");
$q->bindParam(':username',$username);
$q->bindParam(':email',$email);
$q->bindParam(':password',$password);
$q->bindParam(':address',$address);
$q->bindParam(':interest1',$interest1);
$q->bindParam(':interest2',$interest2);
$q->bindParam(':gender',$gender);
$q->bindParam(':age',$age);
$q->bindParam(':photo',$photo);
$q->bindParam(':hash',$hash);
$q->bindParam(':accountStatus',$accountStatus);
$q->execute();
echo"<p id=\"sqlerror\">We have sent a Confirmation Link to your specified Email Address. Please click that Confirmation Link to Activate Your Account.</p>";
	$to      = $sendTo;
$subject = 'Signup | Verification';
$message = '
 
Thanks for signing up!
Your account has been created, you can login after you have activated your account by pressing the url below.
Please click this link to activate your account:
http://localhost/project/verify.php?email='.$sendTo.'&hash='.$hash.'
Sent to: 
------------------------
Username: '.$username.'
Email:		'.$sendTo.'
------------------------
If this Email is not supposed to be sent to you, then Please contact us at :
support@uaarbookstore.com
to get Unregistered. 

 
';
                     
$from = 'info@uaarbookstore.com';
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
  ->setUsername('ar27111994@gmail.com')
  ->setPassword(')%!$$@(%$)')
  ;
$mailer = Swift_Mailer::newInstance($transport);
$RegisterMail=Swift_Message::newInstance();
$RegisterMail->setSubject($subject);
$RegisterMail->setBody($message);
$RegisterMail->setFrom($from);
$RegisterMail->setTo($to);
$subscribed=$mailer->send($RegisterMail);

$checkDatabaseConnection=NULL;
}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
}
else{
	echo"<p id=\"sqlerror\">Invalid Approach.</p>";
}
?>
</div>
<?php
require 'footer.inc.php';
?>
</body>
</html>