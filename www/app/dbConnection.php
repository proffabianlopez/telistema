<?php
$db_host = getenv("MYSQL_HOST");
$db_user = getenv("MYSQL_USER");
$db_password = getenv("MYSQL_PASSWORD");
$db_name = getenv("MYSQL_DB");

// Create Connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check Connection
if($conn->connect_error) {
    die("connection failed");
}
?>