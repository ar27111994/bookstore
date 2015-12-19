<?php
$checkDatabaseConnection=new PDO("mysql:host=localhost;dbname=uaarbookstore","root","");
$checkDatabaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>