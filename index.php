<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="stylesheet/reset.css">
<link rel="stylesheet" type="text/css" href="stylesheet/fonts/stylesheet.css">
<link rel="stylesheet" type="text/css" href="stylesheet/icons/style.css">
<link rel="stylesheet" type="text/css" href="stylesheet/style.css">
<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/flickity.css">
<script type="text/javascript" language="javascript">
function validate(){
	var em = document.forms["contactUsForm"]["email"].value;
	var query = document.forms["contactUsForm"]["query"].value;
	if(em == '' || query == ''){
		alert("Please Enter your Email and Query / Question.");
		return false;
	}
}
</script>
<script type="text/javascript" language="javascript" src="js/flickity.pkgd.min.js"></script>
<title>UAAR Bookshop | Home</title>
</head>
<body>
<?php
require 'FrontPageHeader.inc.php';
?>
<div id="container">
<section class="quick_selections">
<a href=""><h1>Latest Arrivals</h1></a>
<div class="carousel js-flickity" data-flickity-options='{ "contain":true, "pageDots":false, "autoPlay":1500 }'>
<?php
include 'includes/dbconnect.inc.php';
try{
$latest=$checkDatabaseConnection->prepare("SELECT * FROM `books` ORDER BY `Book_id` DESC LIMIT 0,13");
$latest->execute();
while($latestBook=$latest->fetch(PDO::FETCH_ASSOC)){
?>
<span class="gallery-cell">
<a href="single product.php?pid=<?php echo $latestBook['Book_id'];?>"><img src="<?php 
if(file_exists('images/'.md5($latestBook["BookName"]).'.jpg')){
echo 'images/'.md5($latestBook["BookName"]).'.jpg';
}
else if(file_exists('images/'.md5($latestBook["BookName"]).'.png')){
echo 'images/'.md5($latestBook["BookName"]).'.png';
}
else if(file_exists('images/'.md5($latestBook["BookName"]).'.gif')){
echo 'images/'.md5($latestBook["BookName"]).'.gif';	
}
else if(file_exists('images/'.md5($latestBook["BookName"]).'.jpeg')){
echo 'images/'.md5($latestBook["BookName"]).'.jpeg';
}
else if(file_exists('/images/'.md5($latestBook["BookName"]).'.bmp')){
echo 'images/'.md5($latestBook["BookName"]).'.bmp';
}
else{
	die("Fatal Error");
}
?>"></a><p><?php echo $latestBook['BookName'];?></p>
<p>Price: Rs <?php echo $latestBook['Price'];?></p>
</span>
<?php
}
$checkDatabaseConnection=NULL;
}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
?>
</div>
</section>
<section class="quick_selections">
<a href=""><h1>Bestsellers</h1></a>
<div class="carousel js-flickity" data-flickity-options='{ "contain":true, "pageDots":false, "autoPlay":1500 }'>
<?php
include 'includes/dbconnect.inc.php';
try{
$bestsellers=$checkDatabaseConnection->prepare("SELECT books.Book_id,books.BookName,books.Price,orders.Product_Id,SUM(orders.Quantity) FROM `orders` INNER JOIN books ON orders.Product_Id = books.Book_id GROUP BY Product_Id ORDER BY SUM(Quantity) DESC LIMIT 0,13");
$bestsellers->execute();
while($bestsellerBook=$bestsellers->fetch(PDO::FETCH_ASSOC)){
?>
<span class="gallery-cell">
<a href="single product.php?pid=<?php echo $bestsellerBook['Book_id'];?>"><img src="<?php 
if(file_exists('images/'.md5($bestsellerBook["BookName"]).'.jpg')){
echo 'images/'.md5($bestsellerBook["BookName"]).'.jpg';
}
else if(file_exists('images/'.md5($bestsellerBook["BookName"]).'.png')){
echo 'images/'.md5($bestsellerBook["BookName"]).'.png';
}
else if(file_exists('images/'.md5($bestsellerBook["BookName"]).'.gif')){
echo 'images/'.md5($bestsellerBook["BookName"]).'.gif';	
}
else if(file_exists('images/'.md5($bestsellerBook["BookName"]).'.jpeg')){
echo 'images/'.md5($bestsellerBook["BookName"]).'.jpeg';
}
else if(file_exists('/images/'.md5($bestsellerBook["BookName"]).'.bmp')){
echo 'images/'.md5($bestsellerBook["BookName"]).'.bmp';
}
else{
	die("Fatal Error");
}
?>"></a><p><?php echo $bestsellerBook['BookName'];?></p>
<p>Price: Rs <?php echo $bestsellerBook['Price'];?></p>
</span>
<?php
}
}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
?>
</div>
</section>
<div id="publishers">
<h2>Popular Publishers</h2>
<img src="images/anthem press.jpg">
<img src="images/streetpen.jpg">
<img src="images/sanctum.png">
<img src="images/atlantic.jpg">
</div>

<section class="quick_selections">
<a href=""><h1>Special Offers</h1></a>
<div class="carousel js-flickity" data-flickity-options='{ "contain":true, "pageDots":false, "autoPlay":1500 }'>
<?php
include 'includes/dbconnect.inc.php';
try{
$offer=$checkDatabaseConnection->prepare("SELECT * FROM `books` where OldPrice>Price LIMIT 0,13");
$offer->execute();
while($offerBook=$offer->fetch(PDO::FETCH_ASSOC)){
?>
<span class="gallery-cell">
<a href="single product.php?pid=<?php echo $offerBook['Book_id'];?>"><img src="<?php 
if(file_exists('images/'.md5($offerBook["BookName"]).'.jpg')){
echo 'images/'.md5($offerBook["BookName"]).'.jpg';
}
else if(file_exists('images/'.md5($offerBook["BookName"]).'.png')){
echo 'images/'.md5($offerBook["BookName"]).'.png';
}
else if(file_exists('images/'.md5($offerBook["BookName"]).'.gif')){
echo 'images/'.md5($offerBook["BookName"]).'.gif';	
}
else if(file_exists('images/'.md5($offerBook["BookName"]).'.jpeg')){
echo 'images/'.md5($offerBook["BookName"]).'.jpeg';
}
else if(file_exists('/images/'.md5($offerBook["BookName"]).'.bmp')){
echo 'images/'.md5($offerBook["BookName"]).'.bmp';
}
else{
	die("Fatal Error");
}
?>"></a><p><?php echo $offerBook['BookName'];?></p>
<p>Price: <?php echo'<strike style="color:#000;">Rs '.$offerBook['OldPrice'].'</strike>&nbsp;Rs. '.$offerBook['Price'];?></p>
</span>
<?php
}
$checkDatabaseConnection=NULL;
}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
?>
</div>
</section>



<section class="quick_selections">
<a href=""><h1>Featured Books</h1></a>
<div class="carousel js-flickity" data-flickity-options='{ "contain":true, "pageDots":false, "autoPlay":1500 }'>
<?php
include 'includes/dbconnect.inc.php';
try{
$offer=$checkDatabaseConnection->prepare("SELECT * FROM `books` where 'Featured/Un-Featured Book' = 1 LIMIT 0,13");
$offer->execute();
while($offerBook=$offer->fetch(PDO::FETCH_ASSOC)){
?>
<span class="gallery-cell">
<a href="single product.php?pid=<?php echo $offerBook['Book_id'];?>"><img src="<?php 
if(file_exists('images/'.md5($offerBook["BookName"]).'.jpg')){
echo 'images/'.md5($offerBook["BookName"]).'.jpg';
}
else if(file_exists('images/'.md5($offerBook["BookName"]).'.png')){
echo 'images/'.md5($offerBook["BookName"]).'.png';
}
else if(file_exists('images/'.md5($offerBook["BookName"]).'.gif')){
echo 'images/'.md5($offerBook["BookName"]).'.gif';	
}
else if(file_exists('images/'.md5($offerBook["BookName"]).'.jpeg')){
echo 'images/'.md5($offerBook["BookName"]).'.jpeg';
}
else if(file_exists('/images/'.md5($offerBook["BookName"]).'.bmp')){
echo 'images/'.md5($offerBook["BookName"]).'.bmp';
}
else{
	die("Fatal Error");
}
?>"></a><p><?php echo $offerBook['BookName'];?></p>
<p>Price: Rs <?php echo $offerBook['Price'];?></p>
</span>
<?php
}
$checkDatabaseConnection=NULL;
}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
?>
</div>
</section>
<div id="location">
<div id="map"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3022.9986241189304!2d73.080464!3d33.646635!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38df952e017d0acd%3A0xf20be4a76782ceaf!2sPir+Mehr+Ali+Shah+Arid+Agriculture+University!5e1!3m2!1sen!2s!4v1427978659549" width="500" height="330"></iframe></div>
<div id="address"><h2>Our Location</h2><p>PMAS-Arid Agriculture University Rawalpindi, Shamsabad, Muree Road Rawalpindi - Pakistan. </p><h2>Web Address</h2><p><a href="http://www.uaar.edu.pk">www.uaar.edu.pk</a></p><h2>Email Address</h2><p><a href="mailto:shop@uaar.edu.pk">shop@uaar.edu.pk</a></p><h2>Contact Number</h2><p>+92-51-9062290</p></div>
</div>
<div id="contact">
<figure>
<?php
if(isset($_POST['ask'])){
$e=$_POST['email'];
$q=$_POST['query'];
$body=
'Thanks for contacting us!
You will be contacted by our Support Staff as soon as possible.
------------------------
Email:'.$e.'
------------------------

------------------------
Query:'.$q.'
------------------------
If this Email is not supposed to be sent to you, then Please contact us at :
support@uaarbookstore.com
to get Unregistered.';
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
  ->setUsername('ar27111994@gmail.com')
  ->setPassword(')%!$$@(%$)')
  ;
$mailer = Swift_Mailer::newInstance($transport);
$mailtoMe=Swift_Message::newInstance();
$mailtoMe->setSubject('User Query');
$mailtoMe->setBody($body);
$mailtoMe->setFrom('info@uaarbookstore.com');
$mailtoMe->setTo('ar27111994@gmail.com');
$querytoMe=$mailer->send($mailtoMe);
$mailtoUser=Swift_Message::newInstance();
$mailtoUser->setSubject('Query Response');
$mailtoUser->setBody($body);
$mailtoUser->setFrom('info@uaarbookstore.com');
$mailtoUser->setTo($e);
$queryResponse=$mailer->send($mailtoUser);
echo'<script>alert("Your Query haa been submitted. Please wait for 12 hours for an appropriate response. Thanks!");</script>';
}
?>
<h2>Send Us a Message</h2>
<form method="post" action="index.php" name="contactUsForm" onSubmit="return validate();">
<input type="email" name="email" placeholder="Email">
<textarea rows="10" placeholder="Query" cols="50"  name="query"></textarea>
<input type="submit" value="Ask" name="ask">
</form>
</figure>
</div>

</div>
<?php
require 'footer.inc.php';
?>
</body>
</html>