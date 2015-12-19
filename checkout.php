<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet/fonts/stylesheet.css">
<link rel="stylesheet" type="text/css" href="stylesheet/reset.css">
<link rel="stylesheet" type="text/css" href="stylesheet/checkout.css">
<link rel="stylesheet" type="text/css" href="stylesheet/icons/style.css">
<script src="js/jquery.js"></script>
<script src="js/validate.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
<script>
function initialize() {
	 var options = {
  componentRestrictions: {country: "pk"}
 };
  var input = (document.getElementById('addr'));
  var autocomplete = new google.maps.places.Autocomplete(input,options);
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindow.close();
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<?php
if(isset($_POST['order'])){
	?>
<script>
$(document).ready(function(e) {
    $('#shipping_details').css({'display':'none','height':'0'});
	$('#address,#btn').css('display','block');
});
</script>
<?php
unset($_POST['order']);
}
else if(isset($_POST['back'])){
?>
<script>
$(document).ready(function(e) {
    $('#address,#btn').css({'display':'none','height':'0'});
	$('#shipping_details').css('display','block');
});
</script>
<?php
unset($_POST['back']);
}
else{
?>
<script>
$(document).ready(function(e) {
    $('#address,#btn').css({'display':'none','height':'0'});
});
</script>
<?php
}
?>
<meta charset="utf-8">
<title>Checkout</title>
<script>
var s=/\+([0-9])+\+$/g;
function check(){
var x=document.getElementById('ph').value;
if(!s.test(x)){
alert("Follow the pattern +[0-9]+");
}
}
</script>
</head>
<body>
<?php
require 'header.inc.php';
if(!isset($_SESSION["cart"]) || count($_SESSION["cart"]) < 1 || empty($_SESSION['user'])){
	echo"<p id=\"sqlerror\">Invalid Approach! Please Login &amp; Add an Item to the Shopping Cart.</p>";
}
	else{
		
		if(isset($_POST['PlaceOrder'])){
			try{
			include('includes/dbconnect.inc.php');
			$order_id=rand(1,100000);
			$bookid=$_POST['bookid'];
			$bookquantity=$_POST['quantity'];
			foreach($bookid as $key => $value){
			$username = $_POST['username'];
			$city = $_POST['city'];
			$address = $_POST['addr'];
			$street = $_POST['str'];
			$house = $_POST['hno'];
			$email=$_SESSION['user'];
			$status=0;
			$storey = (isset($_POST['sno']))?$_POST['sno']:NULL;
			$phone='+92-'.$_POST['areacode'].'-'.$_POST['ph'];
			$orderquery=$checkDatabaseConnection->prepare("INSERT INTO orders VALUES(:Order_Id,:Product_Id,:Quantity,:OrderStatus,:UserEmail,:USERNAME,:city,:Address,:StreetNumber,:HouseNumber,:StoreyNumber,:PhoneNumber)");
			$orderquery->bindParam(':Order_Id',$order_id);
			$orderquery->bindParam(':Product_Id',$bookid[$key]);
			$orderquery->bindParam(':Quantity',$bookquantity[$key]);
			$orderquery->bindParam(':OrderStatus',$status);
			$orderquery->bindParam(':UserEmail',$email);
			$orderquery->bindParam(':USERNAME',$username);
			$orderquery->bindParam(':city',$city);
			$orderquery->bindParam(':Address',$address);
			$orderquery->bindParam(':StreetNumber',$street);
			$orderquery->bindParam(':HouseNumber',$house);
			$orderquery->bindParam(':StoreyNumber',$storey);
			$orderquery->bindParam(':PhoneNumber',$phone);
$orderquery->execute();
			}
			$checkDatabaseConnection=NULL;
			}
			catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	if(!isset($_SESSION['o_mail'])){
			echo'<p id="sqlerror">We have sent a Confirmation Link to your Email Address. Please click that Confirmation Link to confirm Your Order.</p>';
			$_SESSION['o_mail']=true;
	}
	else if(isset($_SESSION['o_mail'])){
			echo'<p id="sqlerror">Your Have already placed your Order. Please Re-login To Place another Order.</p>';
	}
		}
		else{
$grandTotal=0;
?>
<div id="container">
<div id="shipping_details">
<h1>Shopping Cart</h1>
<section id="products">
<table>
<thead>
<tr>
<th>Book</th>
<th>Quantity</th>
<th>Price</th>
<th>Total Price</th>
<th>Select / Deselect</th>
</tr>
</thead>
<tbody>
<?php
include('includes/dbconnect.inc.php');
$i=0;
$id=array();
$quantity=array();
try{
		$n=0;
foreach($_SESSION['cart'] as $k=>$t){
	$cart=$checkDatabaseConnection->prepare("SELECT * FROM books where Book_id=:id");
	$cart->bindParam(':id',$k);
	$cart->execute();
	$keyword=$checkDatabaseConnection->prepare("SELECT * FROM bookkeywords where Book_id=:id");
	$keyword->bindParam(':id',$k);
	$keyword->execute();
	while($tag=$keyword->fetch(PDO::FETCH_ASSOC)){
		$Keywords[$n]=$tag["Keyword"];
		$n++;
	}
	while($crow = $cart->fetch(PDO::FETCH_ASSOC))
{

?>
<tr>
<td><img src="
<?php if(file_exists('images/'.md5($crow["BookName"]).'.jpg')){
echo 'images/'.md5($crow["BookName"]).'.jpg';
}
else if(file_exists('images/'.md5($crow["BookName"]).'.png')){
echo 'images/'.md5($crow["BookName"]).'.png';
}
else if(file_exists('images/'.md5($crow["BookName"]).'.gif')){
echo 'images/'.md5($crow["BookName"]).'.gif';	
}
else if(file_exists('images/'.md5($crow["BookName"]).'.jpeg')){
echo 'images/'.md5($crow["BookName"]).'.jpeg';
}
else if(file_exists('/images/'.md5($crow["BookName"]).'.bmp')){
echo 'images/'.md5($crow["BookName"]).'.bmp';
}
else{
	die("Fatal Error");
}
?>"><p><?php  echo $crow["BookName"];?></p></td>
<td><input type="text" class="q" data-id="<?php  echo $crow['Book_id'];?>" value="<?php  echo $_SESSION['cart'][$crow['Book_id']]['quantity'];?>" id="quantity" name="q[]" size="3"><p  id="itemQuantity"></p></td>
<td><?php  echo $crow["Price"];?></td>
<td>Rs. <?php  echo $crow["Price"]*$_SESSION['cart'][$crow['Book_id']]['quantity'];?></td>
<td><form action="" method="post" onSubmit=""><input type="checkbox" data-id="<?php  echo $crow['Book_id'];?>" class="check" name="check[]" checked></form></td>
</tr>
<?php
	$grandTotal+=$crow["Price"]*$_SESSION['cart'][$crow['Book_id']]['quantity'];
	$id[$i]=$crow['Book_id'];
	$quantity[$i]=$_SESSION['cart'][$crow['Book_id']]['quantity'];
	$i++;
}
}
$tags=array_unique($Keywords);
}
	catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
?>
</tbody>
</table>
</section>
<section id="total">
<h2>Grand Total:</h2>
<p>Rs. <?php echo $grandTotal;?></p>
<form id="order"><button formaction="checkout.php" formmethod="post" name="order">Place Order</button></form>
</section>
</div>
<div id="btn"><form><button formaction="checkout.php" formmethod="post" name="back">Go Back to Shopping Cart</button></form></div>
<form id="address" action="checkout.php" onSubmit="return validateAddress();" method="post">
<fieldset>
<legend>
Shipping Information
</legend>
<table>
<?php
$x=0;
while(isset($id[$x])){
?>
<input type="hidden" value="<?php echo $id[$x];?>" name="bookid[<?php echo $x;?>]">
<input type="hidden" value="<?php echo $quantity[$x];?>" name="quantity[<?php echo $x;?>]">
<?php
$x++;
	}
?>
<tr><td><label for="username">Enter your name:</label></td>
<td><input type="text" name="username" id="username" size="50" maxlength="256" /></td></tr>
<tr><td><label for="city">Select your City:</label></td>
<td id="selectError" class="error"><select id="city" name="city">
		<option selected="selected" value="0">Select Your City (must match with address provided below)</option>
		<option value="Lahore">Lahore</option>
		<option value="Karachi">Karachi</option>
		<option value="Islamabad">Islamabad</option>
		<option value="Hyderabad">Hyderabad</option>
		<option value="Sukkur">Sukkur</option>
		<option value="Larkana">Larkana</option>
		<option value="Nawabshah">Nawabshah</option>
		<option value="Mirpur Khas">Mirpur Khas</option>
		<option value="Jacobabad">Jacobabad</option>
		<option value="Shikarpur">Shikarpur</option>
		<option value="Dadu">Dadu</option>
		<option value="Tando Adam Khan">Tando Adam Khan</option>
		<option value="Ahmadpur East">Ahmadpur East</option>
		<option value="Ahmed Nager Chatha">Ahmed Nager Chatha</option>
		<option value="Ali Khan Abad">Ali Khan Abad</option>
		<option value="Alipur">Alipur</option>
		<option value="Arifwala">Arifwala</option>
		<option value="Attock">Attock</option>
		<option value="Bhera">Bhera</option>
		<option value="Bhalwal">Bhalwal</option>
		<option value="Bahawalnagar">Bahawalnagar</option>
		<option value="Bahawalpur">Bahawalpur</option>
		<option value="Bhakkar">Bhakkar</option>
		<option value="Burewala">Burewala</option>
		<option value="Chillianwala">Chillianwala</option>
		<option value="Chakwal">Chakwal</option>
		<option value="Chichawatni">Chichawatni</option>
		<option value="Chiniot">Chiniot</option>
		<option value="Chishtian">Chishtian</option>
		<option value="Daska">Daska</option>
		<option value="Darya Khan">Darya Khan</option>
		<option value="Dera Ghazi Khan">Dera Ghazi Khan</option>
		<option value="Dhaular">Dhaular</option>
		<option value="Dina">Dina</option>
		<option value="Dinga">Dinga</option>
		<option value="Dipalpur">Dipalpur</option>
		<option value="Faisalabad">Faisalabad</option>
		<option value="Fateh Jang">Fateh Jang</option>
		<option value="Ghakhar Mandi">Ghakhar Mandi</option>
		<option value="Gojra">Gojra</option>
		<option value="Gujranwala">Gujranwala</option>
		<option value="Gujrat">Gujrat</option>
		<option value="Gujar Khan">Gujar Khan</option>
		<option value="Hafizabad">Hafizabad</option>
		<option value="Haroonabad">Haroonabad</option>
		<option value="Hasilpur">Hasilpur</option>
		<option value="Haveli Lakha">Haveli Lakha</option>
		<option value="Jalalpur Jattan">Jalalpur Jattan</option>
		<option value="Jampur">Jampur</option>
		<option value="Jaranwala">Jaranwala</option>
		<option value="Jhang">Jhang</option>
		<option value="Jhelum">Jhelum</option>
		<option value="Kalabagh">Kalabagh</option>
		<option value="Karor Lal Esan">Karor Lal Esan</option>
		<option value="Kasur">Kasur</option>
		<option value="Kamalia">Kamalia</option>
		<option value="Kamoke">Kamoke</option>
		<option value="Khanewal">Khanewal</option>
		<option value="Khanpur">Khanpur</option>
		<option value="Kharian">Kharian</option>
		<option value="Khushab">Khushab</option>
		<option value="Kot Adu">Kot Adu</option>
		<option value="Jauharabad">Jauharabad</option>
		<option value="Lalamusa">Lalamusa</option>
		<option value="Layyah">Layyah</option>
		<option value="Liaquat Pur">Liaquat Pur</option>
		<option value="Lodhran">Lodhran</option>
		<option value="Malakwal">Malakwal</option>
		<option value="Mamoori">Mamoori</option>
		<option value="Mailsi">Mailsi</option>
		<option value="Mandi Bahauddin">Mandi Bahauddin</option>
		<option value="Mian Channu">Mian Channu</option>
		<option value="Mianwali">Mianwali</option>
		<option value="Multan">Multan</option>
		<option value="Murree">Murree</option>
		<option value="Muridke">Muridke</option>
		<option value="Mianwali Bangla">Mianwali Bangla</option>
		<option value="Muzaffargarh">Muzaffargarh</option>
		<option value="Narowal">Narowal</option>
		<option value="Okara">Okara</option>
		<option value="Renala Khurd">Renala Khurd</option>
		<option value="Pakpattan">Pakpattan</option>
		<option value="Pattoki">Pattoki</option>
		<option value="Pir Mahal">Pir Mahal</option>
		<option value="Qaimpur">Qaimpur</option>
		<option value="Qila Didar Singh">Qila Didar Singh</option>
		<option value="Rabwah">Rabwah</option>
		<option value="Raiwind">Raiwind</option>
		<option value="Rajanpur">Rajanpur</option>
		<option value="Rahim Yar Khan">Rahim Yar Khan</option>
		<option value="Rawalpindi">Rawalpindi</option>
		<option value="Sadiqabad">Sadiqabad</option>
		<option value="Safdarabad">Safdarabad</option>
		<option value="Sahiwal">Sahiwal</option>
		<option value="Sangla Hill">Sangla Hill</option>
		<option value="Sarai Alamgir">Sarai Alamgir</option>
		<option value="Sargodha">Sargodha</option>
		<option value="Shakargarh">Shakargarh</option>
		<option value="Sheikhupura">Sheikhupura</option>
		<option value="Sialkot">Sialkot</option>
		<option value="Sohawa">Sohawa</option>
		<option value="Soianwala">Soianwala</option>
		<option value="Siranwali">Siranwali</option>
		<option value="Talagang">Talagang</option>
		<option value="Taxila">Taxila</option>
		<option value="Toba Tek Singh">Toba Tek Singh</option>
		<option value="Vehari">Vehari</option>
		<option value="Wah Cantonment">Wah Cantonment</option>
		<option value="Wazirabad">Wazirabad</option>
		<option value="Badin">Badin</option>
		<option value="Bhirkan">Bhirkan</option>
		<option value="Rajo Khanani">Rajo Khanani</option>
		<option value="Chak">Chak</option>
		<option value="Dadu">Dadu</option>
		<option value="Digri">Digri</option>
		<option value="Diplo">Diplo</option>
		<option value="Dokri">Dokri</option>
		<option value="Ghotki">Ghotki</option>
		<option value="Haala">Haala</option>
		<option value="Hyderabad">Hyderabad</option>
		<option value="Islamkot">Islamkot</option>
		<option value="Jacobabad">Jacobabad</option>
		<option value="Jamshoro">Jamshoro</option>
		<option value="Jungshahi">Jungshahi</option>
		<option value="Kandhkot">Kandhkot</option>
		<option value="Kandiaro">Kandiaro</option>
		<option value="Kashmore">Kashmore</option>
		<option value="KetiBandar">KetiBandar</option>
		<option value="Khairpur">Khairpur</option>
		<option value="Kotri">Kotri</option>
		<option value="Larkana">Larkana</option>
		<option value="Matiari">Matiari</option>
		<option value="Mehar">Mehar</option>
		<option value="Mirpur Khas">Mirpur Khas</option>
		<option value="Mithani">Mithani</option>
		<option value="Mithi">Mithi</option>
		<option value="Mehrabpur">Mehrabpur</option>
		<option value="Moro">Moro</option>
		<option value="Nagarparkar">Nagarparkar</option>
		<option value="Naudero">Naudero</option>
		<option value="Naushahro Feroze">Naushahro Feroze</option>
		<option value="Naushara">Naushara</option>
		<option value="Nawabshah">Nawabshah</option>
		<option value="Nazimabad">Nazimabad</option>
		<option value="Qambar">Qambar</option>
		<option value="Qasimabad">Qasimabad</option>
		<option value="Ranipur">Ranipur</option>
		<option value="Ratodero">Ratodero</option>
		<option value="Rohri">Rohri</option>
		<option value="Sakrand">Sakrand</option>
		<option value="Sanghar">Sanghar</option>
		<option value="Shahbandar">Shahbandar</option>
		<option value="Shahdadkot">Shahdadkot</option>
		<option value="Shahdadpur">Shahdadpur</option>
		<option value="Shahpur Chakar">Shahpur Chakar</option>
		<option value="Shikarpaur">Shikarpaur</option>
		<option value="Sukkur">Sukkur</option>
		<option value="Tando Adam Khan">Tando Adam Khan</option>
		<option value="Tando Allahyar">Tando Allahyar</option>
		<option value="Tando Muhammad Khan">Tando Muhammad Khan</option>
		<option value="Thatta">Thatta</option>
		<option value="Umerkot">Umerkot</option>
		<option value="Warah">Warah</option>
		<option value="Abbottabad">Abbottabad</option>
		<option value="Adezai">Adezai</option>
		<option value="Alpuri">Alpuri</option>
		<option value="Ayubia">Ayubia</option>
		<option value="Banda Daud Shah">Banda Daud Shah</option>
		<option value="Bannu">Bannu</option>
		<option value="Batkhela">Batkhela</option>
		<option value="Battagram">Battagram</option>
		<option value="Birote">Birote</option>
		<option value="Chakdara">Chakdara</option>
		<option value="Charsadda">Charsadda</option>
		<option value="Chitral">Chitral</option>
		<option value="Daggar">Daggar</option>
		<option value="Dargai">Dargai</option>
		<option value="Darya Khan">Darya Khan</option>
		<option value="Dera Ismail Khan">Dera Ismail Khan</option>
		<option value="Doaba">Doaba</option>
		<option value="Dir">Dir</option>
		<option value="Drosh">Drosh</option>
		<option value="Hangu">Hangu</option>
		<option value="Haripur">Haripur</option>
		<option value="Karak">Karak</option>
		<option value="Kohat">Kohat</option>
		<option value="Kulachi">Kulachi</option>
		<option value="Lakki Marwat">Lakki Marwat</option>
		<option value="Latamber">Latamber</option>
		<option value="Madyan">Madyan</option>
		<option value="Mansehra">Mansehra</option>
		<option value="Mardan">Mardan</option>
		<option value="Mastuj">Mastuj</option>
		<option value="Mingora">Mingora</option>
		<option value="Nowshera">Nowshera</option>
		<option value="Paharpur">Paharpur</option>
		<option value="Peshawar">Peshawar</option>
		<option value="Saidu Sharif">Saidu Sharif</option>
		<option value="Shorkot">Shorkot</option>
		<option value="Swabi">Swabi</option>
		<option value="Swat">Swat</option>
		<option value="Tangi">Tangi</option>
		<option value="Tank">Tank</option>
		<option value="Thall">Thall</option>
		<option value="Timergara">Timergara</option>
		<option value="Tordher">Tordher</option>
		<option value="Quetta">Quetta</option>
		<option value="Khuzdar">Khuzdar</option>
		<option value="Turbat">Turbat</option>
		<option value="Chaman">Chaman</option>
		<option value="Hub">Hub</option>
		<option value="Sibi">Sibi</option>
		<option value="Zhob">Zhob</option>
		<option value="Gwadar">Gwadar</option>
		<option value="Dera Murad Jamali">Dera Murad Jamali</option>
		<option value="Dera Allah Yar">Dera Allah Yar</option>
		<option value="Usta Mohammad">Usta Mohammad</option>
		<option value="Loralai">Loralai</option>
		<option value="Pasni">Pasni</option>
		<option value="Kharan">Kharan</option>
		<option value="Mastung">Mastung</option>
		<option value="Nushki">Nushki</option>
		<option value="Kalat">Kalat</option>
		<option value="Azad Kashmir">Azad Kashmir</option>
		<option value="Askole">Askole</option>
		<option value="Astore">Astore</option>
		<option value="Bunji (or Boanzhi)">Bunji (or Boanzhi)</option>
		<option value="Chilas">Chilas</option>
		<option value="Chillinji">Chillinji</option>
		<option value="Chiran">Chiran</option>
		<option value="Gakuch">Gakuch</option>
		<option value="Ghangche">Ghangche</option>
		<option value="Ghizer">Ghizer</option>
		<option value="Gilgit">Gilgit</option>
		<option value="Gorikot">Gorikot</option>
		<option value="Gulmit">Gulmit</option>
		<option value="Jaglot">Jaglot</option>
		<option value="Chalt (Nagar)">Chalt (Nagar)</option>
		<option value="Thole (Nagar)">Thole (Nagar)</option>
		<option value="Nasir Abad">Nasir Abad</option>
		<option value="Mayoon">Mayoon</option>
		<option value="Khana Abad">Khana Abad</option>
		<option value="Hussain Abad">Hussain Abad</option>
		<option value="Qasimabad Masoot (Nagar)">Qasimabad Masoot (Nagar)</option>
		<option value="Nagar Proper">Nagar Proper</option>
		<option value="Ghulmat (Nagar)">Ghulmat (Nagar)</option>
		<option value="Karimabad (Hunza)">Karimabad (Hunza)</option>
		<option value="Ishkoman">Ishkoman</option>
		<option value="Khaplu">Khaplu</option>
		<option value="Minimerg">Minimerg</option>
		<option value="Misgar">Misgar</option>
		<option value="Passu">Passu</option>
		<option value="Shimshal">Shimshal</option>
		<option value="Skardu">Skardu</option>
		<option value="Sust">Sust</option>
		<option value="Taghafari">Taghafari</option>
		<option value="Thorar">Thorar</option>
		<option value="Nowshera">Nowshera</option>
		<option value="Dera Bugti">Dera Bugti</option>
		<option value="Panjgur">Panjgur</option>
		<option value="Khewrra">Khewrra</option>
</select></td></tr>
<tr><td><label for="addr">Enter your Address:</label></td>
<td><input type="text" id="addr" name="addr" size="60" width="500"></td></tr>
<tr><td><label for="str">Enter your Street / Block No.:</label></td>
<td><input type="text" name="str" id="str" size="10" maxlength="10" /></td></tr>
<tr><td><label for="hno">Enter your House / Building No.:</label></td>
<td><input type="text" name="hno" id="hno" size="10" maxlength="10" /></td></tr>
<tr><td><label for="sno">Enter your Flat / Storey No. (optional):</label></td>
<td><input type="text" name="sno" id="sno" size="10" maxlength="10" /></td></tr>
<tr><td><label for="ph">Enter your Phone Number:</label></td>
<td id="selectError2" class="error"><input type="tel" value="+92" disabled size="3">
<select name="areacode" id="areacode">
	<option value="0">Select an Area Code</option>
	<option value="0992">Abbottabad (0992)</option>
	<option value="0457">Arifwala (0457)</option>
	<option value="057">Attock (057)</option>
	<option value="05823">Azad Jammu and Kashmir - AJK (05823)</option>
	<option value="0297">Badin (0297)</option>
	<option value="058720">Bagh AJK (058720)</option>
	<option value="062">Bahawalpur (062)</option>
	<option value="063">Bahwalnagar (063)</option>
	<option value="0928">Bannu (0928)</option>
	<option value="049">Bhai Pheru (049)</option>
	<option value="0453">Bhakkar (0453)</option>
	<option value="0939">Bunair (0939)</option>
	<option value="0543">Chakwal (0543)</option>
	<option value="049">Changa Manga (049)</option>
	<option value="040">Chichawatani (040)</option>
	<option value="047">Chiniot (047)</option>
	<option value="0943">Chitral (0943)</option>
	<option value="049">Chunian (049)</option>
	<option value="0966">D. I. Khan (0966)</option>
	<option value="025">Dadu (025)</option>
	<option value="058630">Dadyal AJK (058630)</option>
	<option value="0723">Daharki (0723)</option>
	<option value="044">Depalpur (044)</option>
	<option value="064">Dera Ghazi Khan (064)</option>
	<option value="049">Ellahabad (049)</option>
	<option value="041">Faisalabad (041)</option>
	<option value="056">Farooqabad (056)</option>
	<option value="0243">Gambat (0243)</option>
	<option value="0726">Garhi yaseen (0726)</option>
	<option value="086">Gawadar (086)</option>
	<option value="0723">Ghotki (0723)</option>
	<option value="05811">Gilgit (05811)</option>
	<option value="055">Gujranwala (055)</option>
	<option value="053">Gujrat (053)</option>
	<option value="0547">Hafizabad (0547)</option>
	<option value="0925">Hangu (0925)</option>
	<option value="0995">Haripur (0995)</option>
	<option value="0995">Haripur (0995)</option>
	<option value="044">Haveli Lakha (044)</option>
	<option value="0853">Hub (0853)</option>
	<option value="05821">Hunza (05821)</option>
	<option value="022">Hyderabad (022)</option>
	<option value="051">Islamabad (051)</option>
	<option value="0722">Jacobabad (0722)</option>
	<option value="022">Jamshoro (022)</option>
	<option value="047">Jhang (047)</option>
	<option value="0544">Jhelum (0544)</option>
	<option value="074">Kamber Ali Khan (074)</option>
	<option value="0722">Kandh Kot (0722)</option>
	<option value="0242">Kandiaro (0242)</option>
	<option value="021">Karachi (021)</option>
	<option value="0927">Karak (0927)</option>
	<option value="0722">Kashmore (0722)</option>
	<option value="049">Kasur (049)</option>
	<option value="0243">Khairpur Mirs (0243)</option>
	<option value="065">Khanewal (065)</option>
	<option value="049">Khudian Khas (049)</option>
	<option value="0454">Khushab (0454)</option>
	<option value="0848">Khuzdar (0848)</option>
	<option value="0922">Kohat (0922)</option>
	<option value="049">Kot Radha Kishan (049)</option>
	<option value="05826">Kotli AJK (05826)</option>
	<option value="042">Lahore (042)</option>
	<option value="074">Larkana (074)</option>
	<option value="0606">Layyah (0606)</option>
	<option value="0608">Lodhran (0608)</option>
	<option value="0824">Loralai (0824)</option>
	<option value="0945">Lower Dir (0945)</option>
	<option value="0932">Malakand Agency (0932)</option>
	<option value="0546">Mandi Bahauddin (0546)</option>
	<option value="042">Manga Mandi (042)</option>
	<option value="0997">Manshera (0997)</option>
	<option value="0937">Mardan (0937)</option>
	<option value="0459">Mianwali (0459)</option>
	<option value="05827">Mirpur AJK (05827)</option>
	<option value="0723">Mirpur mathelo (0723)</option>
	<option value="0233">Mirpurkhas (0233)</option>
	<option value="0741">Moenjodaro (0741)</option>
	<option value="0242">Moro (0242)</option>
	<option value="061">Multan (061)</option>
	<option value="042">Muridke (042)</option>
	<option value="049">Mustafabad (049)</option>
	<option value="066">Muzaffar Garh (066)</option>
	<option value="05882">Muzaffarabad (05882)</option>
	<option value="056">Nanikana Sahib (056)</option>
	<option value="0542">Narowal (0542)</option>
	<option value="074">Naudero (074)</option>
	<option value="0244">Nawabshah (0244)</option>
	<option value="0923">Nowshera (0923)</option>
	<option value="0242">Nowsheroferoz (0242)</option>
	<option value="044">Okara (044)</option>
	<option value="0242">Padidan (0242)</option>
	<option value="0457">Pakpattan (0457)</option>
	<option value="071">Panu Aqil (071)</option>
	<option value="049">Pattoki (049)</option>
	<option value="091">Peshawar (091)</option>
	<option value="0457">Qabula (0457)</option>
	<option value="056">Qila Sheikhupura (056)</option>
	<option value="081">Quetta (081)</option>
	<option value="068">Rahim Yar Khan (068)</option>
	<option value="042">Raiwind (042)</option>
	<option value="0604">Rajanpur (0604)</option>
	<option value="0243">Ranipur (0243)</option>
	<option value="074">Ratodero (074)</option>
	<option value="051">Rawalpindi (051)</option>
	<option value="05824">Rawlakot (05824)</option>
	<option value="044">Renala Khurd (044)</option>
	<option value="071">Rohri (071)</option>
	<option value="040">Sahiwal (040)</option>
	<option value="0936">Saidu Sharif (0936)</option>
	<option value="0235">Sanghar (0235)</option>
	<option value="056">Sangla Hill (056)</option>
	<option value="048">Sargodha (048)</option>
	<option value="056">Shah Kot (056)</option>
	<option value="074">Shahdadkot (074)</option>
	<option value="056">Sheikhupura (056)</option>
	<option value="0726">Shikharpur (0726)</option>
	<option value="052">Sialkot (052)</option>
	<option value="05815">Skardu (05815)</option>
	<option value="071">Sukkur (071)</option>
	<option value="0938">Swabi (0938)</option>
	<option value="0946">Swat (0946)</option>
	<option value="0235">Tando Adam (0235)</option>
	<option value="051">Taxila (051)</option>
	<option value="0232">Tharparkar  (0232)</option>
	<option value="0298">Thatta (0298)</option>
	<option value="046">Toba Tek Singh (046)</option>
	<option value="0852">Turbat (0852)</option>
	<option value="0723">Ubauro (0723)</option>
	<option value="0238">Umerkot (0238)</option>
	<option value="05813">Upper Hunza (05813)</option>
	<option value="067">Vehari (067)</option>
	<option value="056">Warburton (056)</option>

</select>
<input name="ph" type="tel" id="ph" placeholder="Phone Number" size="15"></td></tr>
<tr><td><label for="useremail">Please Enter The Email With Which You Have Signed In:</label></td><td><input type="email" name="email" size="40" id="useremail"><p id="emailError" class="error"></p></td></tr>
<tr><td colspan="2"><input type="submit" name="PlaceOrder" value="Place Order"></td></tr>
</table>
</fieldset>
</form>
<aside id="related">
<h1>Related books</h1>
<ul>

<?php
include('includes/dbconnect.inc.php');
$x=0;
$id=array();
$quantity=array();
try{
foreach($tags as $v){
	$related=$checkDatabaseConnection->prepare("SELECT k.Book_id,b.BookName,b.Price FROM books b,bookkeywords k WHERE k.Keyword=:Keyword AND b.Book_id=k.Book_id GROUP BY k.Book_id");
	$k=$v;
	$related->bindParam(':Keyword',$k);
	$related->execute();
	while($crow = $related->fetch(PDO::FETCH_ASSOC))
{
$relatedBooks[$x]=$crow["Book_id"];
$x++;
}
}
$sidebar=array_unique($relatedBooks);
foreach($sidebar as $s){
$relatedSidebar=$checkDatabaseConnection->prepare("SELECT BookName,Price From books where Book_id=:id");
$relatedSidebar->bindParam(':id',$s);
$relatedSidebar->execute();
while($srow = $relatedSidebar->fetch(PDO::FETCH_ASSOC))
{
	?>
    <li>
<a href="single product.php?pid=<?php echo $s;?>"><img src="<?php 
if(file_exists('images/'.md5($srow["BookName"]).'.jpg')){
echo 'images/'.md5($srow["BookName"]).'.jpg';
}
else if(file_exists('images/'.md5($srow["BookName"]).'.png')){
echo 'images/'.md5($srow["BookName"]).'.png';
}
else if(file_exists('images/'.md5($srow["BookName"]).'.gif')){
echo 'images/'.md5($srow["BookName"]).'.gif';	
}
else if(file_exists('images/'.md5($srow["BookName"]).'.jpeg')){
echo 'images/'.md5($srow["BookName"]).'.jpeg';
}
else if(file_exists('/images/'.md5($srow["BookName"]).'.bmp')){
echo 'images/'.md5($srow["BookName"]).'.bmp';
}
else{
	die("Fatal Error");
}
?>"><p><?php echo $srow['BookName'];?></p>
<p>Price: Rs <?php echo $srow['Price'];?></p></a>
</li>
<?php
}
}
}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
?>


</ul>
</aside>
</div>
<?php
require 'footer.inc.php';
}
	}
?>
</body>
</html>