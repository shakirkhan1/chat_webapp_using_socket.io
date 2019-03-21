<?php

$host     = "localhost";     // your Host name
$username = "root";          // your Mysql username
$password = "";              // your Mysql password
$db_name  = "groupchat";          // your Database name

$con=mysqli_connect("$host", "$username", "$password","$db_name") or die("could not connect to server.");
?>
