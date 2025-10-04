<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome | Money Splitter</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding-top: 100px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background: #f44336;
            padding: 10px 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This is your homepage. You can now access your dashboard or rooms here.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
