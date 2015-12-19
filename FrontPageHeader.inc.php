<?php
session_start();
if(isset($_POST['logout'])){
	$_SESSION = array();
	session_regenerate_id();
	session_destroy();
}
?>
<header>
<?php
require_once 'includes/swiftmailer/lib/swift_required.php';
if(isset($_SESSION['user'])){
?>
<div id="topbar">
<nav>
<ul>
<li><a href="index.php"><span class="icon-home3"></span>Home</a></li>
<li><a href=""><span class="icon-user"></span>My Account</a></li>
<li><a href=""><span class="icon-cart"></span>Shopping Cart</a></li>
<li><a href="checkout.php"><span class="icon-checkmark"></span>Checkout</a></li>
</ul>
</nav>
</div>
<?php
}
?>
<div id="subheader">
<a href="index.php"><h1 id="logo">UAAR Bookstore</h1></a>
<?php
if(isset($_SESSION['user'])){
?>
<div id="login"><form><button type="submit" formaction="index.php" name="logout" formmethod="post">Logout</button></form></div>
<?php
}
else{
?>
<div id="login"><a href="register.php">Login | Register</a></div>
<?php
}
?>
</div>
<div id="cat">
<nav>
<ul>
<li><a href="">Islamic Books</a></li>
<li><a href="">Magazines</a></li>
<li><a href="">Textbooks</a></li>
<li><a href="">Novels</a></li>
<li><a href="">Notes</a></li>
</ul>
</nav>
</div>
<div id="slider">
<figure>
<a href="#"><img src="images/featured-books.jpg" title="Featured Books" alt="Featured Books"></a>
</figure>
</div>
<h2>Featured Books</h2>
</header>