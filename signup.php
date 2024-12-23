<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="fud-pal, Navigation App, Location, Google map" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="description"
        content="This is a software developed as a project to get certified by Trybe-x community" />
    <meta name="author" content="Team-Alpha" />
    <!-- custom css links -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" />
    <script type="text/javascript" src="assets/js/script.js"></script>
    <link rel="icon" href="assets/images/Fud_20240913_191519_0000.png" type="image/png" sizes="16x16" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="path/to/bootstrap/dist/css/bootstrap.min.css">
    <script src="path/to/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/js/passwordGenerator.js"></script>
    <!-- icon link -->
    <link rel="icon" href="assets/images/logo.png" type="image/png" sizes="30x30" />
    <style>
    .register-link a {
        color: #a0522d;
        font-size: 18px;
        text-decoration: none;
    }

    a:hover {
        color: #ceb2a6;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>SIGN UP</h1>
        <form action="/Database/serve.php" method="post">

            <label for="Name"><i class="fa-solid fa-user"></i> Full Name </label>
            <input type="text" name="name" id="name" />
            <label for="Email"> <i class="fa-solid fa-envelope"> </i> Email Address </label>
            <input type="email" id="email" name="email" />
            <label for="Reg_number"> Registration Number </label>
            <input type="text" id="Reg_number" name="Reg_number" />
            <label for="Password"><i class="fa-solid fa-lock"></i> Create Password </label>
            <input type="password" name="Password" id="password" autocomplete="off" minlength="8" maxlength="16"
                title="Password must be at least 8 characters long, containing at least lowercase letter, 1 uppercase  letter and a number"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required />
            <label for="Confirm_psw"><i class="fa-solid fa-lock"></i> Confirm Password </label>
            <input type="password" name="confirm_psw" id="confirm_password" autocomplete="off" minlength="8"
                maxlength="16"
                title="Password must be at least 8 characters long, containing at least lowercase letter, 1 uppercase  letter and a number"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required />

            <button class="signup-button" type="submit" name="signUp">
                Create Account
            </button>
        </form>
        <div class="register-link">
            Already have an account
            <a href="index.php"> Login Here! </a>
        </div>
    </div>
    <script type="text/javaScript" src="/assets/js/passwordGenerator.js"></script>
</body>

</html>