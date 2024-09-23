<?php
/*
$db_host = getenv("MYSQL_HOST");
$db_user = getenv("MYSQL_USER");
$db_password = getenv("MYSQL_PASSWORD");
$db_name = getenv("MYSQL_DB");

// Create Connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check Connection
if($conn->connect_error) {
    die("connection failed");
}*/
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

// Set charset to utf8mb4
if (!$conn->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $conn->error);
}
