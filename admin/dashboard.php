<?php
header('Content-type: text/html; charset=utf-8');
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
	$('#featuredimageError').hide();
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
<form action="dashboard.php" method="post"><input type="submit" name="logout" value="Logout"></form>
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
<li><a href="dashboard.php?view=managereaders">Manage Readers</a></li>
<li><a href="dashboard.php?view=manageorders">Manage Orders</a></li>
<li><a href="dashboard.php">Manage Categories</a></li>
</ul>
</nav>
</aside>
<div id="content">
<?php
if(isset($_GET['view'])){
if($_GET['view']=='addbooks'){
	if(isset($_GET['form'])&&$_GET['form']=='add'){
	if(isset($_POST['add'])){
		try{
	$book=mysql_real_escape_string($_POST["book"]);
	$author=mysql_real_escape_string($_POST["author"]);
	$edition=$_POST["edition"];
	$price=$_POST["price"];
	$stockstatus=$_POST["stock-status"];
	$desc=mysql_real_escape_string($_POST["desc"]);
	$pages=$_POST["pages"];
	$pubdate=$_POST["pub-date"];
	$publisher=$_POST["publisher"];
	$barcode=$_POST["barcode"];
	$featuredbook=$_POST["featuredbook"];
	$bookid=NULL;
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
	$addBook=$checkDatabaseConnection->prepare("insert into books values(:bookid,:book,:author,:edition,:price,:stockstatus,:desc,:pages,:pubdate,:publisher,:barcode,:featuredbook)");
	$addBook->bindParam(':bookid',$bookid);
	$addBook->bindParam(':book',$book);
	$addBook->bindParam(':author',$author);
	$addBook->bindParam(':edition',$edition);
	$addBook->bindParam(':price',$price);
	$addBook->bindParam(':stockstatus',$stockstatus);
	$addBook->bindParam(':desc',$desc);
	$addBook->bindParam(':pages',$pages);
	$addBook->bindParam(':pubdate',$pubdate);
	$addBook->bindParam(':publisher',$publisher);
	$addBook->bindParam(':barcode',$barcode);
	$addBook->bindParam(':featuredbook',$featuredbook);
	$addBook->execute();
	$bookid=$checkDatabaseConnection->lastInsertId();
	foreach($_POST['keyword'] as $keyword){
		$keywordquery=$checkDatabaseConnection->prepare("insert into bookkeywords values(:book_id,:keyword)");
		$keywordquery->bindParam(':book_id',$bookid);
		$keywordquery->bindParam(':keyword',$keyword);
		$keywordquery->execute();
	}
	unset($_POST['add']);
	echo"<p id=\"sqlerror\">Book Added Successfully. Please Click <a href=\"dashboard.php?view=addbooks\">Here</a> to Add Another One.</p>";
	}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	}
	else{
		echo"<p id=\"sqlerror\">Invalid Approach.</p>";
	}
	}
	else{
?>
	<form method="post" action="dashboard.php?view=addbooks&form=add" id="addbook" onSubmit="return addBook();" enctype="multipart/form-data">
    <fieldset>
    <legend>Add Book</legend>
    <table>
    <tr>
    <td><label for="book-name">Book Name:</label></td>
    <td><input name="book" size="70" id="book-name" type="text" maxlength="100" /></td>
    </tr>
    <tr>
    <td><label for="author-name">Author's Name:</label></td>
    <td><input name="author" size="70" id="author-name" type="text" maxlength="100" /></td>
    </tr>
    <tr>
    <td><label for="edition">Book's Edition No.:</label></td>
    <td><select id="edition" name="edition">
	<option value="1st">1st</option>
	<option value="2nd">2nd</option>
	<option value="3rd">3rd</option>
	<option value="4th">4th</option>
	<option value="5th">5th</option>
	<option value="6th">6th</option>
	<option value="7th">7th</option>
	<option value="8th">8th</option>
	<option value="9th">9th</option>
	<option value="10th">10th</option>
	<option value="11th">11th</option>
	<option value="12th">12th</option>
	<option value="13th">13th</option>
	<option value="14th">14th</option>
	<option value="15th">15th</option>
	<option value="16th">16th</option>
    <option value="17th">17th</option>
    <option value="18th">18th</option>
    <option value="19th">19th</option>
    <option value="20th">20th</option>
    </select></td>
    </tr>
    <tr>
    <td><label for="price">Book Price:</label></td>
    <td><input name="price" id="price" type="text" /></td>
    </tr>
    <tr>
    <td><label for="stock-status">Stock Status:</label></td>
    <td><select name="stock-status" id="stock-status">
    <option value="in stock">In Stock</option>
    <option value="out of stock">Out Of Stock</option>
    </select>
    </td>
    </tr>
    <tr>
    <td><label for="desc">Book Description:</label></td>
    <td><textarea name="desc" cols="80" rows="5" id="desc"></textarea></td>
    </tr>
    <tr>
    <td><label for="pages">Number of Pages:</label></td>
    <td><input name="pages" id="pages" type="text"></td>
    </tr>
    <tr>
    <td><label for="pub-date">Publication Date:</label></td>
    <td><input name="pub-date" id="pub-date" type="date" required></td>
    </tr>
    <tr>
    <td><label for="publisher">Publisher:</label></td>
    <td><input name="publisher" size="70" id="publisher" type="text"></td>
    </tr>
    <tr>
    <td><label for="barcode">Bar Code:</label></td>
    <td><input name="barcode" id="barcode" type="text"></td>
    </tr>
    <tr>
    <td><label for="bookimage">Upload Book's Image:</label></td>
	<td id="photoError" class="error"><input type="file" name="image" id="bookimage" /></td>
    </tr>
    <tr>
    <td><label for="featured">Featured / Un-Featured Book:</label></td>
	<td id="featuredError" class="error"><input type="radio" name="featuredbook" id="notfeatured" value="0" checked />Not Featured<input type="radio" name="featuredbook" id="featured" value="1" />Featured</td>
    </tr>
    <tr id="featuredimageError">
    <td><label for="featuredimage">Upload Featured Book's Banner (Size Proportional to 1263 x 354 pixels):</label></td>
	<td id="featuredimgError" class="error"><input type="file" name="featuredimage" id="featuredimage" /></td>
    </tr>
    <tr>
    <td><label for="keyword">Keywords (Multiple Select):</label></td>
	<td id="keywordError" class="error"><select multiple name="keyword[]" id="keyword">
    <?php
	try{
	$select="SELECT * FROM keywords";
	$selectquery=$checkDatabaseConnection->prepare($select);
	$selectquery->execute();
		$i=0;
		while ($row = $selectquery->fetch(PDO::FETCH_ASSOC)) {
			if($i==0){
        echo"<option value='".$row["Keyword"]."' selected>".$row["Keyword"]."</option>";
			}
			else{
				echo"<option value='".$row["Keyword"]."'>".$row["Keyword"]."</option>";
			}
			$i++;
    }
	}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	?>
    </td>
    </tr>
    <tr>
    <td colspan="2"><input name="add" id="add" type="submit" value="Add Book" /></td>
    </tr>
    </table>
    </fieldset>
    </form>
<?php
	}
}
elseif($_GET['view']=='managebooks'){
	?>
	<table id="managebooks">
    <tr>
    <th>Book I.D.</th>
    <th>Book Name</th>
    <th>Edition</th>
    <th>Author's Name</th>
    <th>Price</th>
    <th>Edit</th>
    <th>Remove</th>
    </tr>
    <?php
	try{
	$selectbooks="SELECT * FROM books";
	$selectbooksquery=$checkDatabaseConnection->prepare($selectbooks);
	$selectbooksquery->execute();
		while ($bookrow = $selectbooksquery->fetch(PDO::FETCH_ASSOC)) {
			
        echo"<tr> <td>".$bookrow["Book_id"]."</td> <td>".$bookrow["BookName"]."</td> <td>".$bookrow["Edition"]."</td> <td>".$bookrow["Author Name"]."</td> <td>".$bookrow["Price"]."</td> <td><a href=\"edit.php?bookid=".$bookrow["Book_id"]."\">Edit</a></td> <td><a href=\"delete.php?bookid=".$bookrow["Book_id"]."\">Remove</a></td> </tr>";
			
    }
	}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	?>
    </table>
	
<?php	
}


elseif($_GET['view']=='managereaders'){
	?>
	<table id="managebooks">
    <tr>
    <th>Username</th>
    <th>Email</th>
    <th>Address</th>
    <th>Gender</th>
    <th>Age</th>
    <th>Account Status</th>
    <th>Remove</th>
    </tr>
    <?php
	try{
	$selectreaders="SELECT * FROM reader_registration";
	$selectreadersquery=$checkDatabaseConnection->prepare($selectreaders);
	$selectreadersquery->execute();
		while ($rrow = $selectreadersquery->fetch(PDO::FETCH_ASSOC)) {
			
        echo"<tr> <td>".$rrow["USERNAME"]."</td> <td>".$rrow["EMAIL"]."</td> <td>".$rrow["ADDRESS"]."</td> <td>".$rrow["GENDER"]."</td> <td>".$rrow["AGE"]."</td> <td>".$rrow["ACCOUNT_STATUS"]."</td> <td><a href=\"delete.php?rid=".$rrow["EMAIL"]."\">Remove</a></td> </tr>";
			
    }
	}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	?>
    </table>
    <?php
}
	elseif($_GET['view']=='manageorders'){
	?>
	<table id="managebooks">
    <tr>
    <th>Order I.D.</th>
    <th>Book I.D.</th>
    <th>Quantity</th>
    <th>Order Status</th>
    <th>User Email</th>
    <th>Username</th>
    <th>Address</th>
    <th>House No.</th>
    <th>Street No.</th>
    <th>Storey No.</th>
    <th>Phone No.</th>
    <th>Fullfill Order</th>
    <th>Remove</th>
    </tr>
    <?php
	try{
	$selectorders="SELECT * FROM orders";
	$selectordersquery=$checkDatabaseConnection->prepare($selectorders);
	$selectordersquery->execute();
		while ($orow = $selectordersquery->fetch(PDO::FETCH_ASSOC)) {
			
        echo"<tr> <td>".$orow["Order_Id"]."</td> <td><a href=\"../single product.php?pid=".$orow["Product_Id"]."\">".$orow["Product_Id"]."</a></td> <td>".$orow["Quantity"]."</td> <td>".$orow["Order Status"]."</td> <td>".$orow["User Email"]."</td> <td>".$orow["USERNAME"]."</td> <td>".$orow["Address"].", ".$orow["city"]."</td> <td>".$orow["House Number"]."</td> <td>".$orow["Street Number"]."</td> <td>".$orow["Storey Number"]."</td> <td>".$orow["Phone Number"]."</td> <td><a href=\"fullfill.php?oid=".$orow["Order_Id"]."\">Fullfill Order</a></td> <td><a href=\"delete.php?oid=".$orow["Order_Id"]."\">Remove</a></td> </tr>";
			
    }
	}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	?>
    </table>
	

<?php	
}


}
else{
	echo'<h2>Welcome to Administrator Dashboard.</h2>';
	echo'<p style="font-size:24px;color:red">You can Manage &amp; Update your Bookstore Here.</p>';
}
?>
</div>
</div>
<?php	
}
else{
	echo'<p id="sqlerror">Invalid Approach! Please Login as Administrator to use the Dashboard.</p>';
}
?>
</body>
</html>