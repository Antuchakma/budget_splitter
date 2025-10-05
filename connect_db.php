<?php

$username = "root";            
$password = "";                
$dbname   = "sp1";       





try {
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8mb4"); // Use modern UTF-8

} catch (mysqli_sql_exception $e) {
    
    error_log("Database Connection Error: " . $e->getMessage(), 0);

    // Show generic message to users
    die("Sorry, we’re having trouble connecting to the database. Please try again later.");
}

