	function validateRegistration(){
	var validUserId=/([A-Z])*(\s)*([a-z])+(\s)*([A-Z])*(\s)*([a-z])*$/g;
	var user=document.getElementById('username').value;
	var email=document.getElementById('email').value;
	var pswd=document.getElementById('pswd').value;
	var c_pswd=document.getElementById('confirm_password').value;
	var address=document.getElementById('address').value;
	var age=document.getElementById('age').value;
	var photo=document.getElementById('image').value;
	var emailError=document.getElementById('emailError').innerHTML;
	var check=1;
	if(!validUserId.test(user)||user.length>=256){
		$('#username').attr('placeholder','Please Enter Your Username (256 Characters max &amp; Alphabets only)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#username').removeAttr('placeholder').removeAttr('style');
	}
	if(email==''||email.length>100 || emailError.length==28){
		$('#email').attr('placeholder','Please Enter a Valid Email. (100 Characters max)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#email').removeAttr('placeholder').removeAttr('style');
	}
	if(pswd==''||pswd.length>=20){
		$('#pswd').attr('placeholder','Please Enter a Password (20 Characters max)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#pswd').removeAttr('placeholder').removeAttr('style');
	}
	if(c_pswd!=pswd){
		$('#confirm_password').attr('placeholder','Passwords Don\'t Match').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#confirm_password').removeAttr('placeholder').removeAttr('style');
	}
	if(address==''||address.length>=256){
		$('#address').attr('placeholder','Please Enter Your Address (256 Characters max)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#address').removeAttr('placeholder').removeAttr('style');
	}
	if(address==''||address.length>=256){
		$('#address').attr('placeholder','Please Enter Your Address (256 Characters max)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#address').removeAttr('placeholder').removeAttr('style');
	}
	if($('#interest :selected').val()=='0'){
		$('#selectError p').css('display','block');
		var node1=document.createElement("P");
		var selecterror=document.createTextNode("Please Select Your Reading Interest.");
		node1.appendChild(selecterror);
		if($('#selectError p').empty()){
		document.getElementById('selectError').appendChild(node1);
		}
		check++;
	}
	else{
		$('#selectError p').css('display','none');
	}
	if($('#male').is(':checked')||$('#female').is(':checked')){
		$('#radioError p').css('display','none');
	}
	else{
		$('#radioError p').css('display','block');
		var node2=document.createElement("P");
		var radioerror=document.createTextNode("Please Select Your Gender.");
		node2.appendChild(radioerror);
		if($('#radioError p').empty()){
		document.getElementById('radioError').appendChild(node2);
		}
		check++;
	}
	if(/[^\d\.]/.test(age)||age<18||age>65){
		$('#rangeError p').css('display','block');
		var node3=document.createElement("P");
		var rangeerror=document.createTextNode("Please Enter Your Age.");
		node3.appendChild(rangeerror);
		if($('#rangeError p').empty()){
		document.getElementById('rangeError').appendChild(node3);
		}
		check++;
	}
	else{
		$('#rangeError p').css('display','none');
	}
            var Extension = photo.substring(photo.lastIndexOf('.') + 1).toLowerCase();
if (Extension == "gif" || Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg") {
						$('#fileError p').css('display','none');
					}

	else{
		$('#fileError p').css('display','block');
		var node4=document.createElement("P");
		var fileerror=document.createTextNode("Please Select Your Picture / Photo (must be a valid image file).");
		node4.appendChild(fileerror);
		if($('#fileError p').empty()){
		document.getElementById('fileError').appendChild(node4);
		}
		check++;
	}
	if(check!=1){
	return false;
	}
	else{
		return true;
	}
}
function validateLogin(){
    if(document.getElementById('pswrd').value==''||document.getElementById('user-id').value==''){
		var node=document.createElement("P");
		var error=document.createTextNode("Please Enter Your Login Details");
		node.appendChild(error);
		$('#pswrd').css('border','2px solid #F00');
		$('#user-id').css('border','2px solid #F00');
		if($('#loginError p').empty()){
		document.getElementById('loginError').appendChild(node);
		}
		return false;
	}
	}
function validateAdminLogin(){
    if(document.getElementById('password').value==''||document.getElementById('admin').value==''){
		$('#password').css('border','2px solid #F00');
		$('#admin').css('border','2px solid #F00');
		$('#adminLoginError p').html('Please Enter Your Admin Login Details!').css('color','#F00');
		return false;
	}
	}
$(document).ready(function(e) {
		$("#email").keyup(function() {
        var email = $("#email").val();
        $("#emailError").html('<img alt="" src="images/loading.gif" />');
        $.post("includes/checkavailability.inc.php", {email:email},
            function(result) {
                if(result == 1 && $('#email').val()!='') {
                    $("#emailError").html("Email Available <span class=\"icon-checkmark\"></span>").css('color','#0F0');
                }
                else {
                    $("#emailError").html("Email not available <b>X</b>").css('color','#F00');
                }
            });
     });
	 	  });
		  	function addBook(){
	var validAuthorName=/([A-Z]|[a-z]|\s|,)$/g;
	var book=document.getElementById('book-name').value;
	var author=document.getElementById('author-name').value;
	var price=document.getElementById('price').value;
	var desc=document.getElementById('desc').value;
	var pages=document.getElementById('pages').value;
	var publisher=document.getElementById('publisher').value;
	var barcode=document.getElementById('barcode').value;
	var bookimage=document.getElementById('bookimage').value;
	var featuredimage=document.getElementById('featuredimage').innerHTML;
	var check=1;
	if(book.length==0||book.length>=256){
		$('#book-name').attr('placeholder','Please Enter Books\'s Name (256 Characters max and Alphabets only)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#book-name').removeAttr('placeholder').removeAttr('style');
	}
	if(!validAuthorName.test(author)||author.length>100){
		$('#author-name').attr('placeholder','Please Enter a Valid Author Name. (100 Characters max)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#author-name').removeAttr('placeholder').removeAttr('style');
	}
	if(/[^\d\.]/.test(price)||price.length>5||price.length==0){
		$('#price').attr('placeholder','Number(0 to 99999).').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#price').removeAttr('placeholder').removeAttr('style');
	}
	if(desc.length==0||desc.length>=550){
		$('#desc').attr('placeholder','Please Enter Books\'s Description (550 Characters max').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#desc').removeAttr('placeholder').removeAttr('style');
	}
	if(publisher.length==0||publisher.length>=150){
		$('#publisher').attr('placeholder','Please Enter Books\'s Publisher (150 Characters max').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#publisher').removeAttr('placeholder').removeAttr('style');
	}
	if(/[^\d\.]/.test(barcode)||barcode.length!=13){
		$('#barcode').attr('placeholder','Please Enter Books\'s Bar Code (150 Characters max').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#barcode').removeAttr('placeholder').removeAttr('style');
	}
	if(/[^\d\.]/.test(pages)||pages.length>5||pages.length==0){
		$('#pages').attr('placeholder','Number(0 to 99999).').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#pages').removeAttr('placeholder').removeAttr('style');
	}
	var Extension1 = bookimage.substring(bookimage.lastIndexOf('.') + 1).toLowerCase();
if (Extension1 == "gif" || Extension1 == "png" || Extension1 == "bmp"
                    || Extension1 == "jpeg" || Extension1 == "jpg") {
						$('#photoError p').css('display','none');
					}

	else{
		$('#photoError p').css('display','block');
		var node4=document.createElement("P");
		var fileerror=document.createTextNode("Please Select Book\'s Image. (must be a valid image file).");
		node4.appendChild(fileerror);
		if($('#photoError p').empty()){
		document.getElementById('photoError').appendChild(node4);
		}
		check++;
	}
	var Extension2 = featuredimage.substring(featuredimage.lastIndexOf('.') + 1).toLowerCase();
	if($('#featured').is(':checked')){
		if(Extension2 == "gif" || Extension2 == "png" || Extension2 == "bmp"
                    || Extension2 == "jpeg" || Extension2 == "jpg"){
						$('#featuredimgError p').css('display','none');
					}
					else{
						$('#featuredimgError p').css('display','block');
		var node5=document.createElement("P");
		var fileimgerror=document.createTextNode("Please Select Featured Book\'s Banner. (must be a valid image file).");
		node5.appendChild(fileimgerror);
		if($('#featuredimgError p').empty()){
		document.getElementById('featuredimgError').appendChild(node5);
		}
		check++;
					}
	}
	if(check!=1){
	return false;
	}
	else{
		return true;
	}
}

function editBook(){
	var validAuthorName=/([A-Z]|[a-z]|\s|,)$/g;
	var book=document.getElementById('book-name').value;
	var author=document.getElementById('author-name').value;
	var price=document.getElementById('price').value;
	var desc=document.getElementById('desc').value;
	var pages=document.getElementById('pages').value;
	var publisher=document.getElementById('publisher').value;
	var barcode=document.getElementById('barcode').value;
	var bookimage=document.getElementById('bookimage').value;
	var featuredimage=document.getElementById('featuredimage').innerHTML;
	var check=1;
	if(book.length==0||book.length>=256){
		$('#book-name').attr('placeholder','Please Enter Books\'s Name (256 Characters max and Alphabets only)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#book-name').removeAttr('placeholder').removeAttr('style');
	}
	if(!validAuthorName.test(author)||author.length>100){
		$('#author-name').attr('placeholder','Please Enter a Valid Author Name. (100 Characters max)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#author-name').removeAttr('placeholder').removeAttr('style');
	}
	if(/[^\d\.]/.test(price)||price.length>5||price.length==0){
		$('#price').attr('placeholder','Number(0 to 99999).').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#price').removeAttr('placeholder').removeAttr('style');
	}
	if(desc.length==0||desc.length>=550){
		$('#desc').attr('placeholder','Please Enter Books\'s Description (550 Characters max').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#desc').removeAttr('placeholder').removeAttr('style');
	}
	if(publisher.length==0||publisher.length>=150){
		$('#publisher').attr('placeholder','Please Enter Books\'s Publisher (150 Characters max').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#publisher').removeAttr('placeholder').removeAttr('style');
	}
	if(/[^\d\.]/.test(barcode)||barcode.length!=13){
		$('#barcode').attr('placeholder','Please Enter Books\'s Bar Code (150 Characters max').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#barcode').removeAttr('placeholder').removeAttr('style');
	}
	if(/[^\d\.]/.test(pages)||pages.length>5||pages.length==0){
		$('#pages').attr('placeholder','Number(0 to 99999).').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#pages').removeAttr('placeholder').removeAttr('style');
	}
	var Extension1 = bookimage.substring(bookimage.lastIndexOf('.') + 1).toLowerCase();
	if(bookimage!=''){
if (Extension1 == "gif" || Extension1 == "png" || Extension1 == "bmp"
                    || Extension1 == "jpeg" || Extension1 == "jpg") {
						$('#photoError p').css('display','none');
					}

	else{
		$('#photoError p').css('display','block');
		var node4=document.createElement("P");
		var fileerror=document.createTextNode("Please Select Book\'s Image. (must be a valid image file).");
		node4.appendChild(fileerror);
		if($('#photoError p').empty()){
		document.getElementById('photoError').appendChild(node4);
		}
		check++;
	}
	}
	var Extension2 = featuredimage.substring(featuredimage.lastIndexOf('.') + 1).toLowerCase();
	if($('#featured').is(':checked')){
		if(Extension2 == "gif" || Extension2 == "png" || Extension2 == "bmp"
                    || Extension2 == "jpeg" || Extension2 == "jpg"){
						$('#featuredimgError p').css('display','none');
					}
					else{
						$('#featuredimgError p').css('display','block');
		var node5=document.createElement("P");
		var fileimgerror=document.createTextNode("Please Select Featured Book\'s Banner. (must be a valid image file).");
		node5.appendChild(fileimgerror);
		if($('#featuredimgError p').empty()){
		document.getElementById('featuredimgError').appendChild(node5);
		}
		check++;
					}
	}
	if(check!=1){
	return false;
	}
	else{
		return true;

	}
}
function validateAddress(){
	var user=document.getElementById('username').value;
	var ph=document.getElementById('ph').value;
	var address=document.getElementById('addr').value;
	var street=document.getElementById('str').value;
	var house=document.getElementById('hno').value;
	var flat=document.getElementById('sno').value;
	var validUserId=/([A-Z])*(\s)*([a-z])+(\s)*([A-Z])*(\s)*([a-z])*$/g;
	var email=document.getElementById('useremail').value;
	var emailError=document.getElementById('emailError').innerHTML;
	var check=1;
	if(!validUserId.test(user)||user.length>256){
		$('#username').attr('placeholder','Please Enter Your Nname (256 Characters max &amp; Alphabets only)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#username').removeAttr('placeholder').removeAttr('style');
	}
	if($('#city :selected').val()=='0'){
		$('#selectError p').css('display','block');
		var n=document.createElement("P");
		var se=document.createTextNode("Please Select a City.");
		n.appendChild(se);
		if($('#selectError p').empty()){
		document.getElementById('selectError').appendChild(n);
		}
		check++;
	}
	else{
		$('#selectError p').css('display','none');
	}
	if($('#areacode :selected').val()=='0'){
		$('#selectError2 p').css('display','block');
		var n2=document.createElement("P");
		var se2=document.createTextNode("Please Select an Area Code.");
		n2.appendChild(se2);
		if($('#selectError2 p').empty()){
		document.getElementById('selectError2').appendChild(n2);
		}
		check++;
	}
	else{
		$('#selectError2 p').css('display','none');
	}
	if(address==''){
		$('#addr').attr('placeholder','Please Enter a Valid Destination Address').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#addr').removeAttr('placeholder').removeAttr('style');
	}
	if(street==''||street.length>=10){
		$('#str').attr('placeholder','Please Enter a Valid Street No.').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#str').removeAttr('placeholder').removeAttr('style');
	}
	if(house==''||house.length>=10){
		$('#hno').attr('placeholder','Please Enter a Valid House No.').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#hno').removeAttr('placeholder').removeAttr('style');
	}
	if(flat.length>=10){
		$('#sno').attr('placeholder','Please Enter a Valid Flat / Store No.').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#sno').removeAttr('placeholder').removeAttr('style');
	}
	if(ph==''||ph.length!=7){
		$('#ph').attr('placeholder','Enter a Valid Phone No.').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#ph').removeAttr('placeholder').removeAttr('style');
	}
	if(email=='' || emailError.length==26){
		$('#useremail').attr('placeholder','Please Enter a Valid Email. (100 Characters max)').css({'color':'#333','background-color':'rgba(255,0,0,0.5)'});
		check++;
	}
	else{
		$('#useremail').removeAttr('placeholder').removeAttr('style');
	}
		if(check!=1){
	return false;
	}
	else{
		return true;
	}
}
		
$(document).ready(function(e) {
	$('.q').change(function(e) {
        var quantity = this.value;
		if(/[0-9]+$/g.test(quantity) && parseInt(quantity) > 0 && quantity.length > 0 && quantity.length < 4){
		var id=$(this).data('id');
		$.post('includes/changeQuantity.php',{quantity:quantity,id:id});
		}
		else{
			alert("Please Enter a Numeric Value as Quantity (Minimum value 1 AND length < 4).");
		}
    });
});
$(document).ready(function(e) {
		$("#useremail").keyup(function() {
        var email = $("#useremail").val();
        $("#emailError").html('<img alt="" src="images/loading.gif" />');
        $.post("includes/checkuservalidity.php", {email:email},
            function(data) {
                if(data == 1 && $('#useremail').val()!='') {
                    $("#emailError").html("Correct Email <span class=\"icon-checkmark\"></span>").css('color','#0F0');
                }
                else {
                    $("#emailError").html("Email not Correct <b>X</b>").css('color','#F00');
                }
            });
     });
	 	  });
		  $(document).ready(function(e) {
			  $('input[name="check[]"]').each(function() {
			  $(this).change(function(e) {
                 if(!$(this).is(':checked')){
				var c=window.confirm("Do you really want to delete this item from your Shopping Cart?");
				if(c==true){
						var bookid=$(this).data("id");
						$.post('includes/deleteBook.php',{bookid:bookid},function(result){
							if(result==1){
								location.reload(true);
							}
						});
				}
			}
            });
			});
        });