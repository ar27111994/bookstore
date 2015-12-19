<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="stylesheet/reset.css">
<link rel="stylesheet" type="text/css" href="stylesheet/fonts/stylesheet.css">
<link rel="stylesheet" type="text/css" href="stylesheet/icons/style.css">
<link rel="stylesheet" type="text/css" href="stylesheet/checkout.css">
<title>All Products</title>
</head>

<body>
<div id="container">
<table>
<?php
require 'header.inc.php';
$rowsperpage=5;
include 'includes/dbconnect.inc.php';
try{
	$totalproducts=$checkDatabaseConnection->prepare("SELECT COUNT(*) as `num` FROM books");
	$totalproducts->execute();
	$noOfProducts=$totalproducts->fetch();
	$totalNoOfProducts=$noOfProducts['num'];
	$totalPages=ceil($totalNoOfProducts/$rowsperpage);
	if(isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])){
		$currentpage=(int)$_GET['currentpage'];
	}
	else{
		$currentpage=1;
	}
	if($currentpage>$totalPages){
		$currentpage=$totalPages;
	}
	if($currentpage<1){
		$currentpage=1;
	}
	$limitStart=($currentpage-1)*$rowsperpage;
	$books=$checkDatabaseConnection->prepare("SELECT * FROM books LIMIT :start,:end");
	$books->bindParam(':start',$limitStart, PDO::PARAM_INT);
	$books->bindParam(':end',$rowsperpage, PDO::PARAM_INT);
	$books->execute();
	while($book=$books->fetch(PDO::FETCH_ASSOC)){
		echo '<tr><td>';?><a href="single product.php?pid=<?php echo $book['Book_id'];?>"><img style="float:left; max-width:100px;" src="<?php 
if(file_exists('images/'.md5($book["BookName"]).'.jpg')){
echo 'images/'.md5($book["BookName"]).'.jpg';
}
else if(file_exists('images/'.md5($book["BookName"]).'.png')){
echo 'images/'.md5($book["BookName"]).'.png';
}
else if(file_exists('images/'.md5($book["BookName"]).'.gif')){
echo 'images/'.md5($book["BookName"]).'.gif';	
}
else if(file_exists('images/'.md5($book["BookName"]).'.jpeg')){
echo 'images/'.md5($book["BookName"]).'.jpeg';
}
else if(file_exists('/images/'.md5($book["BookName"]).'.bmp')){
echo 'images/'.md5($book["BookName"]).'.bmp';
}
else{
	die("Fatal Error");
}
?>"><?php echo "<span style=\"padding:7px;margin:3px;float:right;\">".$book["BookName"].'</span></a></td></tr>';
	}
	$range=2;
	if($currentpage>1){
		echo "<a style=\"padding:7px;margin:3px;background:#C0DAA5;\" href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a>  ";
		$prevpage=$currentpage-1;
		echo "<a style=\"padding:7px;margin:3px;background:#C0DAA5;\" href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a>";
	}
	for($i=$currentpage-$range; $i<($currentpage+$range)+1; $i++){
		if($i>0 && $i<=$totalPages){
			if($i==$currentpage){
				echo "<b style=\"padding:7px;margin:3px;\">$i</b>";
			}
			else{
				echo "<a style=\"padding:7px;margin:3px;background:#C0DAA5;\" href='{$_SERVER['PHP_SELF']}?currentpage=$i'>$i</a>";
			}
		}
	}
	if($currentpage!=$totalPages){
		$nextPage=$currentpage+1;
		echo "<a style=\"padding:7px;margin:3px;background:#C0DAA5;\" href='{$_SERVER['PHP_SELF']}?currentpage=$nextPage'>></a>  ";
		$prevpage=$currentpage-1;
		echo "<a style=\"padding:7px;margin:3px;background:#C0DAA5;\" href='{$_SERVER['PHP_SELF']}?currentpage=$totalPages'>>></a>";

	}
	}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
?>
</table>
</div>
<?php
require 'footer.inc.php';
?>
</body>
</html>