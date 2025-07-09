<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $admin = $res->fetch_assoc();
        $_SESSION['admin'] = $admin['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login</title>
  <link rel="icon" href="https://img.icons8.com/ios-filled/50/ffffff/lock-2.png" type="image/png" /> 
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f5f7fa;
      color: #2c3e50;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      background-color: #1a237e;
      color: white;
      padding: 1.2rem;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .login-box {
      background: white;
      padding: 35px;
      border-radius: 10px;
      box-shadow: 0 6px 24px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 360px;
      margin: 60px auto;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #1a237e;
    }

    .login-box form {
      display: flex;
      flex-direction: column;
    }

    .login-box input {
      margin-bottom: 15px;
      padding: 12px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      transition: border 0.3s, box-shadow 0.3s;
    }

    .login-box input:focus {
      border-color: #3949ab;
      box-shadow: 0 0 0 3px rgba(57, 73, 171, 0.2);
      outline: none;
    }

    .login-box button {
      background-color: #3949ab;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-box button:hover {
      background-color: #303f9f;
    }

    .error {
      background-color: #ffebee;
      color: #c62828;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      text-align: center;
      font-weight: 500;
      font-size: 14px;
    }

    @media (max-width: 400px) {
      .login-box {
        margin: 40px 20px;
        padding: 25px;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Admin Login</h1>
  </header>
  <section>
    <div class="login-box">
      <h2>Welcome Back</h2>
      <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
      <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" autocomplete="off" required />
        <input type="password" name="password" placeholder="Enter Password" required />
        <button type="submit">Login</button>
      </form>
    </div>
  </section>
</body>
</html>
