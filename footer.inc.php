<footer>
<section id="col1" class="col">
<h1>Quick Links</h1>
<ul>
<li><a href="about us.php">About Us</a></li>
<li><a href="#">News</a></li>
<?php
$uri = $_SERVER['REQUEST_URI'];
if(!isset($_SESSION['user'])){
?>
<li><a href="register.php">Register</a></li>
<?php
}
?>
<li><a href="all products.php?currentpage=1">All Products</a></li>
</ul>
</section>
<section id="col2" class="col">
<h1>Connect with us</h1>
<ul>
<li><a href="#"><img src="images/twitter.png">Twitter</a></li>
<li><a href="#"><img src="images/facebook.png">Facebook</a></li>
<li><a href="#"><img src="images/google-plus.png">Google +</a></li>
<li><a href="#"><img src="images/linkedin.png">Linkedin</a></li>
</ul>
</section>
<section id="col3" class="col">
<h1>Get Latest Offers and News</h1>
<?php
if(isset($_POST['subscribe'])){
echo'<script>document.forms["subscriptionForm"]["emailAddress"].focus();</script>';
include 'includes/dbconnect.inc.php';
try{
$h = md5( rand(0,1000) );
$em=md5($_POST["emailAddress"]);
$emailAddress=$_POST["emailAddress"];
$query=$checkDatabaseConnection->prepare("insert into subscribers values(:email,:hash)");
$query->bindParam(':email',$em);
$query->bindParam(':hash',$h);
$query->execute();
    echo "<p id=\"sqlerror\">We have sent a Confirmation Email to your specified Email Address. To unsubscribe, please click the Unsubscribe Link to De-Activate Your Subscription.</p>";
	$messageBody = '
 
Thanks for Subscribing to our Newsletter!

------------------------
Email:'.$emailAddress.'
------------------------

To unsubscibe please click the link below:
http://localhost/project/unsubscribe.php?email='.$emailAddress.'&hash='.$h.'
Sent to: 
'.$emailAddress.'
If this Email is not supposed to be sent to you, then Please contact us at :
support@uaarbookstore.com
to get Unregistered.';
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
  ->setUsername('ar27111994@gmail.com')
  ->setPassword(')%!$$@(%$)')
  ;
$mailer = Swift_Mailer::newInstance($transport);
$subscribedMail=Swift_Message::newInstance();
$subscribedMail->setSubject('Subscription Letter');
$subscribedMail->setBody($messageBody);
$subscribedMail->setFrom('info@uaarbookstore.com');
$subscribedMail->setTo($emailAddress);
$subscribed=$mailer->send($subscribedMail);
}
catch(PDOException $e)
{
    echo "Error: User Already Subscribed <b>OR</b> " . $e->getMessage();
}
}
?>
<form name="subscriptionForm" method="post" action="<?php echo $uri; ?>" onSubmit="return subscribe();">
<ul>
<li><input type="email" placeholder="Email" name="emailAddress" required></li>
<li><input type="submit" value="Subscribe to Newsletter" name="subscribe"></li>
</ul>
</form>
</section>
</footer>