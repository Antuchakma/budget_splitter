<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($username === "admin" && $password === "1234") {
        echo "<script>alert('Login Successful!');</script>";
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In Page</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}
body {
    overflow: hidden;
    height: 100vh;
    background: #fff;
}
.container {
    display: flex;
    width: 100%;
    height: 100vh;
}
.left-side {
    flex: 1;
    background: linear-gradient(135deg, #2b80ff, #6f9eff);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    clip-path: ellipse(80% 100% at 10% 50%);
    animation: slideIn 1.5s ease-in-out;
}
@keyframes slideIn {
    0% {
        clip-path: ellipse(0% 100% at 10% 50%);
    }
    100% {
        clip-path: ellipse(80% 100% at 10% 50%);
    }
}
.left-content {
    z-index: 1;
    text-align: center;
    width: 80%;
    max-width: 400px;
    opacity: 0;
    animation: fadeIn 1.5s ease forwards;
    animation-delay: 0.8s;
}
@keyframes fadeIn {
    to { opacity: 1; }
}
.left-content h2 {
    font-size: 1.8rem;
    margin-bottom: 10px;
}
.left-content p {
    font-size: 0.9rem;
    margin-bottom: 20px;
}
.left-content button {
    padding: 10px 25px;
    border: 1px solid #fff;
    background: transparent;
    color: white;
    cursor: pointer;
    border-radius: 4px;
    transition: 0.3s;
}
.left-content button:hover {
    background: white;
    color: #2b80ff;
}
.illustration {
    width: 80%;
    max-width: 350px;
    margin-top: 30px;
}
.right-side {
    flex: 1;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
}
.signin-box {
    width: 80%;
    max-width: 350px;
    text-align: center;
    opacity: 0;
    animation: fadeInUp 1.5s ease forwards;
    animation-delay: 1s;
}
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
.signin-box h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    margin-bottom: 20px;
}
.input-group {
    position: relative;
    margin-bottom: 15px;
}
.input-group input {
    width: 100%;
    padding: 12px 40px;
    border: none;
    outline: none;
    background: #f3f3f3;
    border-radius: 30px;
    font-size: 0.95rem;
}
.input-group i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #777;
}
.login-btn {
    background: #2b80ff;
    color: white;
    border: none;
    padding: 10px 30px;
    border-radius: 30px;
    cursor: pointer;
    margin-top: 10px;
    font-weight: 500;
    letter-spacing: 1px;
    transition: 0.3s;
}
.login-btn:hover {
    background: #1c65d8;
}
.social {
    margin-top: 20px;
    font-size: 0.9rem;
}
.google-btn {
    margin-top: 10px;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 1px solid #000;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}
.google-btn:hover {
    background: #f3f3f3;
}
@media (max-width: 900px) {
    .container {
        flex-direction: column;
    }
    .left-side {
        clip-path: none;
        height: 50vh;
    }
    .right-side {
        height: 50vh;
    }
}
</style>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <div class="left-content">
                <h2>New Here ?</h2>
                <p>Don't have an account on our website and want to enjoy the great time saving features, just click on the button below to signup</p>
                <button onclick="window.location.href='signup.php'">SIGN UP</button>
                <img src="family.png" class="illustration" alt="illustration">
            </div>
        </div>
        <div class="right-side">
            <div class="signin-box">
                <h2>Sign In</h2>
                <form method="POST">
                    <div class="input-group">
                        <i class="fa fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-group">
                        <i class="fa fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="login-btn">LOGIN</button>
                </form>
                <div class="social">
                    <p>Or Sign in with social platform</p>
                    <div class="google-btn">G</div>
                </div>
            </div>
        </div>
    </div>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
