<?php
    include_once "resource/session.php";
    $servername = "127.0.0.1";
    $username = "root";
    $password = "mariadb";
    $dbname = "Farm";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST["loginBtn"])) {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["pass"]);

        // SQL query to select the user
        $sel_user = "SELECT * FROM Users WHERE username = '$username'";
        $run_user = mysqli_query($conn, $sel_user);

        if (mysqli_num_rows($run_user) > 0) {
            $row = mysqli_fetch_assoc($run_user);
            $hashed_password = $row['password']; // Get the hashed password from the database

            // Verify the entered password with the hashed password
            if (password_verify($password, $hashed_password)) {
                // Password matches, set session and redirect
                $_SESSION['username'] = $username;
                echo "<script>window.open('index.php', '_self')</script>";
            } else {
                // Invalid password
                echo "<script>alert('Invalid username or password');</script>";
            }
        } else {
            // Invalid username
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Farm Connect: Buy and Sell Raw Product Online</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
			background: url('image/background3.jpg') center/cover no-repeat;

        }

        .hero {
            background: url('image/background4.jpg') center/cover no-repeat;
            height: 400px;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero h1 {
            font-weight: bold;
        }

        .marketplace h1 {
            margin-bottom: 20px;
        }

        .thumbnail img:hover {
            transform: scale(1.05);
            filter: brightness(85%);
            transition: transform 0.3s ease-in, filter 0.3s ease-in;
            box-shadow: 0 0 16px rgba(0, 255, 255, 0.5);
        }

        footer {
            background-color: #f8f9fa;
            color: #333;
            padding: 1em 0;
            text-align: center;
        }

        /* Custom login styling */
        .login-form {
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .login-form h1 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 32px;
            color: #333;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #555;
        }

        .login-form .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .login-form input {
            font-size: 16px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        /* Focus input border color to a yellow-orange similar to the cart icon color */
        .login-form input:focus {
            border-color: #FFA500;
            outline: none;
        }

        .login-form .form-group i {
            position: absolute;
            top: 16px;
            left: 12px;
            color: #FFA500; /* Yellow-Orange icon color */
        }

        .login-form .form-group input {
            padding-left: 35px;
        }

        .login-form button {
            width: 100%;
            padding: 15px;
            background-color: #FFA500; /* Yellow-Orange button color */
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form button:hover {
            background-color: #ff8c00; /* Darker shade of yellow-orange on hover */
        }

        .login-form a {
            display: inline-block;
            font-size: 14px;
            text-decoration: none;
            color: #FFA500; /* Yellow-Orange color for links */
            margin-top: 10px;
        }

        .login-form a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #f8f9fa;
            color: #333;
            padding: 1em 0;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><strong>FarmDirect</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Buy Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="loginfarmers.php">Farmer Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">How it Works</a></li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="#"><strong>Cart</strong> <i class="fas fa-cart-plus"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <div class="login-form">
        <h1>FarmConnect</h1>
        <h2>Buyer's Sign In</h2>

        <form method="POST">
            <div class="form-group">
                <input type="text" class="form-control" id="UserName" name="username" placeholder="Username" required>
                <i class="fa fa-user"></i>
            </div>

            <div class="form-group log-status">
                <input type="password" class="form-control" placeholder="Password" id="Password" name="pass" required>
                <i class="fa fa-lock"></i>
            </div>

            <a class="link" style="float: left; padding-left: 20px;" href="register.php">Register Here</a>
            <a class="link" style="float: right; padding-right: 20px;" href="forgot_pass.php">Lost your password?</a><br><br>

            <div align="center">
                <button name="loginBtn" type="submit" class="btn btn-primary"><strong>SIGN IN</strong></button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <hr>
        <p>Contact Us: (+94)0762552365 &copy; FarmConnect. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
