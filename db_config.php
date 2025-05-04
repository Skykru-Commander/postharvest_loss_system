<?php
// settngs for the connection of the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "postharvest_db";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>