<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    echo "<div style='padding:20px; background:#dff0d8; color:#3c763d; text-align:center;'>
            <h3>✅ Sign Up Successful!</h3>
            <p>Username: $username</p>
            <p>Email: $email</p>
          </div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Money Splitter - Sign Up</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body {
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
      background: #fff;
      overflow: hidden;
    }
    .container {
      display: flex;
      width: 100%;
      height: 100%;
    }
    .left, .right {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
    }
    .left { background: #fff; }
    .logo {
      position: absolute;
      top: 20px;
      left: 30px;
      display: flex;
      align-items: center;
      font-size: 28px;
      font-weight: bold;
      color: #000;
      opacity: 0;
      animation: fadeInDown 1s ease forwards;
    }
    .logo img {
      height: 50px;
      margin-right: 10px;
    }
    form {
      display: flex;
      flex-direction: column;
      width: 280px;
      gap: 15px;
      opacity: 0;
      transform: translateY(50px);
      animation: slideUp 1s ease forwards;
      animation-delay: 0.8s;
    }
    form h2 {
      margin-bottom: 20px;
      text-align: center;
      font-size: 28px;
      font-weight: bold;
    }
    input {
      width: 100%;
      padding: 12px 15px;
      border-radius: 25px;
      border: 1px solid #ccc;
      background: #f5f5f5;
      font-size: 14px;
    }
    .btn {
      background: #000;
      color: #fff;
      border: none;
      padding: 12px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 14px;
      transition: transform 0.3s ease;
    }
    .btn:hover { transform: scale(1.05); }
    .social {
      margin-top: 10px;
      text-align: center;
      font-size: 14px;
    }
    .google {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-top: 10px;
      width: 40px;
      height: 40px;
      border: 1px solid #000;
      border-radius: 50%;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.3s ease;
    }
    .google:hover {
      background: #000;
      color: #fff;
      transform: rotate(10deg);
    }
    .right {
      background: linear-gradient(135deg, #00aaff, #0099ff);
      color: #fff;
      clip-path: ellipse(80% 100% at 100% 50%);
      text-align: center;
      opacity: 0;
      transform: translateX(100px);
      animation: slideLeft 1s ease forwards;
      animation-delay: 1.2s;
    }
    .right h2 {
      font-size: 24px;
      margin-bottom: 15px;
    }
    .right p {
      margin-bottom: 20px;
    }
    .signin-btn {
      border: 2px solid #fff;
      padding: 10px 20px;
      border-radius: 5px;
      background: transparent;
      color: #fff;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .signin-btn:hover {
      background: #fff;
      color: #0099ff;
      transform: scale(1.05);
    }
    .joinus {
      position: absolute;
      top: 20px;
      right: 30px;
      color: #fff;
      font-weight: bold;
      text-decoration: none;
      opacity: 0;
      animation: fadeIn 1s ease forwards;
      animation-delay: 1.6s;
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(50px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideLeft {
      from { opacity: 0; transform: translateX(100px); }
      to { opacity: 1; transform: translateX(0); }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="logo">
        <img src="https://img.icons8.com/ios-filled/50/fa314a/money.png" alt="logo">
        Money Splitter
      </div>
      <form method="POST" action="">
        <h2>Sign Up</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">SIGN UP</button>
        <div class="social">Or Sign up with social platform</div>
        <div class="google">G</div>
      </form>
    </div>
    <div class="right">
      <a href="#" class="joinus">JOIN US</a>
      <h2>One of Us ?</h2>
      <p>Already have an account, just click on the login button.</p>
      <button class="signin-btn">LOGIN</button>
    </div>
  </div>
</body>
</html>
