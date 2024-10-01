<?php
$db_host = getenv("MYSQL_HOST");
$db_user = getenv("MYSQL_USER");
$db_password = getenv("MYSQL_PASSWORD");
$db_name = getenv("MYSQL_DB");

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if($conn->connect_error) {
    die("connection failed");
}

if (!$conn->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $conn->error);
}
