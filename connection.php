<?php
//$link=mysqli_connect("localhost","root","");
//mysqli_select_db($link,"EntrevisTech1");


$servername = "entrevistech1.mysql.dbaas.com.br";
$username = "entrevistech1";
$password = "Entreunicep12!";
$dbname = "entrevistech1";

$link = mysqli_connect($servername, $username, $password, $dbname);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>