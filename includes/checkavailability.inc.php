<?php
include 'dbconnect.inc.php';
$emailaddress =md5($_POST["email"]);
$sql = "SELECT * FROM reader_registration WHERE EMAIL = :emailaddress";
$result =$checkDatabaseConnection->prepare($sql);
$result->bindParam(':emailaddress',$emailaddress);
$result->execute();
if($result->rowCount() > 0) {
    echo 0;
}
else {
    echo 1;
}
?>