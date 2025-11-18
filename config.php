<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$db_name = "tp_mvc25";
$conn = new mysqli($servername, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed" . $conn->connect_error);
}
echo "";
