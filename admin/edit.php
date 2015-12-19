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
<script>
$(document).ready(function(e) {
	$('input:radio').click(function(e) {
        if($(this).val()==0){
			$('#featuredimageError').hide();
		}
		else{
			$('#featuredimageError').show();
		}
    });
});
</script>
<meta charset="utf-8">
<title>Administrator Dashboard</title>
</head>
<body>
<?php
if(isset($_SESSION['admin'])){
	require('../includes/dbconnect.inc.php');
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
	if(isset($_POST['edit'])){
		try{
				$bookid=$_GET['bookid'];
	$book=$_POST["book"];
	$author=$_POST["author"];
	$edition=$_POST["edition"];
	$price=$_POST["price"];
	$stockstatus=$_POST["stock-status"];
	$desc=$_POST["desc"];
	$pages=$_POST["pages"];
	$pubdate=$_POST["pub-date"];
	$publisher=$_POST["publisher"];
	$barcode=$_POST["barcode"];
	$oldprice=(isset($_POST['oldprice']))?$_POST['oldprice']:NULL;
	$featuredbook=$_POST["featuredbook"];
		if (isset($_FILES["image"]["name"])) {
	$ext = pathinfo(basename($_FILES['image']['name']),PATHINFO_EXTENSION);
 	$newname = md5($book).".".$ext; 
	$target = $_SERVER['DOCUMENT_ROOT'] . '/project/images/'.$newname;
	move_uploaded_file( $_FILES['image']['tmp_name'], $target);
	}
	//for featured book banner
	if($featuredbook=="1"){
		if (isset($_FILES["featuredimage"]["name"])) {
	$ext = pathinfo(basename($_FILES['featuredimage']['name']),PATHINFO_EXTENSION);
 	$newname = md5($book)." featured.".$ext; 
	$target = $_SERVER['DOCUMENT_ROOT'] . '/project/featuredimages/'.$newname;
	move_uploaded_file( $_FILES['featuredimage']['tmp_name'], $target);
	
		}
		}
	$updateBook="UPDATE `books` SET `BookName`=:book,`Author Name`=:author,`Edition`=:edition, OldPrice=:oldprice,`Price`=:price,`Stock Status`=:stockstatus,`Book Description`=:desc,`Number of Pages`=:pages,`Publication Date`=:pubdate,`Featured / Un-Featured Book`=:featuredbook,`Publisher`=:publisher,`Bar Code`=:barcode WHERE `Book_id`=:bookid";
	$editBookquery=$checkDatabaseConnection->prepare($updateBook);
	$editBookquery->bindParam(':bookid',$bookid);
	$editBookquery->bindParam(':book',$book);
	$editBookquery->bindParam(':author',$author);
	$editBookquery->bindParam(':edition',$edition);
	$editBookquery->bindParam(':oldprice',$oldprice);
	$editBookquery->bindParam(':price',$price);
	$editBookquery->bindParam(':featuredbook',$featuredbook);
	$editBookquery->bindParam(':stockstatus',$stockstatus);
	$editBookquery->bindParam(':desc',$desc);
	$editBookquery->bindParam(':pages',$pages);
	$editBookquery->bindParam(':pubdate',$pubdate);
	$editBookquery->bindParam(':publisher',$publisher);
	$editBookquery->bindParam(':barcode',$barcode);
	$editBookquery->execute();
	}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
	exit;
    }
	unset($_POST['edit']);
	echo"<p id=\"sqlerror\">Book Updated Successfully. Please Click <a href=\"dashboard.php?view=managebooks\">Here</a> to Edit Another One.</p>";
	$keywords=implode(',',$_POST['keyword']);
}


else{
	try{
	$editBook="SELECT * FROM books WHERE Book_id=:bookid";
	$getbook=$checkDatabaseConnection->prepare($editBook);
	$getbook->bindParam(':bookid',$bookid);
	$getbook->execute();
	while($booktoedit = $getbook->fetch(PDO::FETCH_ASSOC)){
?>




<form method="post" action="edit.php?bookid=<?php echo $bookid;?>" id="addbook" onSubmit="return editBook();">
    <fieldset>
    <legend>Add Book</legend>
    <table>
    <tr>
    <td><input type="hidden" value="<?php echo $booktoedit['Book_id']; ?>" name="id"></td>
    </tr>
    <tr>
    <td><label for="book-name">Book Name:</label></td>
    <td><input name="book" size="70" id="book-name" type="text" value="<?php echo $booktoedit["BookName"]; ?>" maxlength="100" /></td>
    </tr>
    <tr>
    <td><label for="author-name">Author's Name:</label></td>
    <td><input name="author" value="<?php echo $booktoedit["Author Name"]; ?>" size="70" id="author-name" type="text" maxlength="100" /></td>
    </tr>
    <tr>
    <td><label for="edition">Book's Edition No.:</label></td>
    <td><select id="edition" name="edition">
	<option value="1st" <?php if($booktoedit["Edition"]=="1st") echo 'selected="selected"'; ?>>1st</option>
	<option value="2nd" <?php if($booktoedit["Edition"]=="2nd") echo 'selected="selected"'; ?>>2nd</option>
	<option value="3rd" <?php if($booktoedit["Edition"]=="3rd") echo 'selected="selected"'; ?>>3rd</option>
	<option value="4th" <?php if($booktoedit["Edition"]=="4th") echo 'selected="selected"'; ?>>4th</option>
	<option value="5th" <?php if($booktoedit["Edition"]=="5th") echo 'selected="selected"'; ?>>5th</option>
	<option value="6th" <?php if($booktoedit["Edition"]=="6th") echo 'selected="selected"'; ?>>6th</option>
	<option value="7th" <?php if($booktoedit["Edition"]=="7th") echo 'selected="selected"'; ?>>7th</option>
	<option value="8th" <?php if($booktoedit["Edition"]=="8th") echo 'selected="selected"'; ?>>8th</option>
	<option value="9th" <?php if($booktoedit["Edition"]=="9th") echo 'selected="selected"'; ?>>9th</option>
	<option value="10th" <?php if($booktoedit["Edition"]=="10th") echo 'selected="selected"'; ?>>10th</option>
	<option value="11th" <?php if($booktoedit["Edition"]=="11th") echo 'selected="selected"'; ?>>11th</option>
	<option value="12th" <?php if($booktoedit["Edition"]=="12th") echo 'selected="selected"'; ?>>12th</option>
	<option value="13th" <?php if($booktoedit["Edition"]=="13th") echo 'selected="selected"'; ?>>13th</option>
	<option value="14th" <?php if($booktoedit["Edition"]=="14th") echo 'selected="selected"'; ?>>14th</option>
	<option value="15th" <?php if($booktoedit["Edition"]=="15th") echo 'selected="selected"'; ?>>15th</option>
	<option value="16th" <?php if($booktoedit["Edition"]=="16th") echo 'selected="selected"'; ?>>16th</option>
    <option value="17th" <?php if($booktoedit["Edition"]=="17th") echo 'selected="selected"'; ?>>17th</option>
    <option value="18th" <?php if($booktoedit["Edition"]=="18th") echo 'selected="selected"'; ?>>18th</option>
    <option value="19th" <?php if($booktoedit["Edition"]=="19th") echo 'selected="selected"'; ?>>19th</option>
    <option value="20th" <?php if($booktoedit["Edition"]=="20th") echo 'selected="selected"'; ?>>20th</option>
    </select></td>
    </tr>
    <tr>
    <td><label for="oldprice">Book's Old  Price:</label></td>
    <td><input name="oldprice" value="<?php echo $booktoedit["OldPrice"]; ?>" id="oldprice" type="text" /></td>
    </tr>
    <tr>
    <td><label for="price">Book Price:</label></td>
    <td><input name="price" value="<?php echo $booktoedit["Price"]; ?>" id="price" type="text" /></td>
    </tr>
    <tr>
    <td><label for="stock-status">Stock Status:</label></td>
    <td><select name="stock-status" id="stock-status">
    <option value="in stock" <?php if($booktoedit["Stock Status"]=="in stock") echo 'selected="selected"'; ?>>In Stock</option>
    <option value="out of stock" <?php if($booktoedit["Stock Status"]=="out of stock") echo 'selected="selected"'; ?>>Out Of Stock</option>
    </select>
    </td>
    </tr>
    <tr>
    <td><label for="desc">Book Description:</label></td>
    <td><textarea name="desc" cols="80" rows="5" id="desc"><?php echo $booktoedit["Book Description"]; ?></textarea></td>
    </tr>
    <tr>
    <td><label for="pages">Number of Pages:</label></td>
    <td><input name="pages" value="<?php echo $booktoedit["Number of Pages"]; ?>" id="pages" type="text"></td>
    </tr>
    <tr>
    <td><label for="pub-date">Publication Date:</label></td>
    <td><input name="pub-date" id="pub-date" type="date" value="<?php echo $booktoedit["Publication Date"]; ?>" required></td>
    </tr>
    <tr>
    <td><label for="publisher">Publisher:</label></td>
    <td><input name="publisher" size="70" id="publisher" value="<?php echo $booktoedit["Publisher"]; ?>" type="text"></td>
    </tr>
    <tr>
    <td><label for="barcode">Bar Code:</label></td>
    <td><input name="barcode" id="barcode" value="<?php echo $booktoedit["Bar Code"]; ?>" type="text"></td>
    </tr>
    <tr>
    <td><label for="bookimage">Change Book's Image:</label></td>
	<td id="photoError" class="error"><input type="file" name="image" id="bookimage" />
    <br/>
    <img src="<?php 
if(file_exists('../images/'.md5($booktoedit["BookName"]).'.jpg')){
echo '../images/'.md5($booktoedit["BookName"]).'.jpg';
}
else if(file_exists('../images/'.md5($booktoedit["BookName"]).'.png')){
echo '../images/'.md5($booktoedit["BookName"]).'.png';
}
else if(file_exists('../images/'.md5($booktoedit["BookName"]).'.gif')){
echo '../images/'.md5($booktoedit["BookName"]).'.gif';	
}
else if(file_exists('../images/'.md5($booktoedit["BookName"]).'.jpeg')){
echo '../images/'.md5($booktoedit["BookName"]).'.jpeg';
}
else if(file_exists('../images/'.md5($booktoedit["BookName"]).'.bmp')){
echo '../images/'.md5($booktoedit["BookName"]).'.bmp';
}
else{
	die("Fatal Error");
}
?>"></td>
    </tr>
    <tr>
    <td><label for="featured">Featured / Un-Featured Book:</label></td>
	<td id="featuredError" class="error"><input type="radio" name="featuredbook" id="notfeatured" <?php if($booktoedit["Featured / Un-Featured Book"]==0) echo "checked"; ?> value="0" />Not Featured<input type="radio" <?php if($booktoedit["Featured / Un-Featured Book"]==1) echo "checked"; ?> name="featuredbook" id="featured" value="1" />Featured</td>
    </tr>
    <?php
    if($booktoedit["Featured / Un-Featured Book"]==0){
		echo '<script>$(document).ready(function(e) {
$("#featuredimageError").hide();
		});
		</script>';
	}
	?>
    <tr id="featuredimageError">
    <td><label for="featuredimage">Upload Featured Book's Banner (Size Proportional to 1263 x 354 pixels):</label></td>
	<td id="featuredimgError" class="error"><input type="file" name="featuredimage" id="featuredimage" />
        <br/>
    <img src="<?php 
if(file_exists('../featuredimages/'.md5($booktoedit["BookName"]).'.jpg')){
echo '../featuredimages/'.md5($booktoedit["BookName"]).' featured.jpg';
}
else if(file_exists('../featuredimages/'.md5($booktoedit["BookName"]).'.png')){
echo '../featuredimages/'.md5($booktoedit["BookName"]).' featured.png';
}
else if(file_exists('../featuredimages/'.md5($booktoedit["BookName"]).'.gif')){
echo '../featuredimages/'.md5($booktoedit["BookName"]).' featured.gif';	
}
else if(file_exists('../featuredimages/'.md5($booktoedit["BookName"]).'.jpeg')){
echo '../featuredimages/'.md5($booktoedit["BookName"]).' featured.jpeg';
}
else if(file_exists('../featuredimages/'.md5($booktoedit["BookName"]).'.bmp')){
echo '../featuredimages/'.md5($booktoedit["BookName"]).' featured.bmp';
}
?>"></td>
    </tr>
    <tr>
    <td><label for="keyword">Keywords (Multiple Select):</label></td>
	<td id="keywordError" class="error"><select multiple name="keyword[]" id="keyword">
    <?php
	$key="Select Keyword from bookkeywords WHERE Book_id=:bid";
	$keyQuery=$checkDatabaseConnection->prepare($key);
	$keyQuery->bindParam(':bid',$booktoedit["Book_id"]);
	$keyQuery->execute();
	$Keywords=array();
	$i=0;
	while($keyrow=$keyQuery->fetch(PDO::FETCH_ASSOC)){
		$Keywords[$i]=$keyrow["Keyword"];
		$i++;
	}
	$select="SELECT * FROM keywords";
	$selectquery=$checkDatabaseConnection->prepare($select);
	$selectquery->execute();
		while ($row = $selectquery->fetch(PDO::FETCH_ASSOC)) {
        echo"<option value='".$row["Keyword"]."'".((in_array($row["Keyword"],$Keywords))?" selected":"").">".$row["Keyword"]."</option>";
    }
	?>
	</select>
    </td>
    </tr>
    <tr>
    <td colspan="2"><input name="edit" id="add" type="submit" value="Edit Book" /></td>
    </tr>
    </table>
    </fieldset>
    </form>
<?php
	}//while
	}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	}//query
}//bookid

	?>
</div>
</div>
<?php
}
else{
	echo'<p id="sqlerror">Invalid Approach!.</p>';
}
?>
</body>
</html>