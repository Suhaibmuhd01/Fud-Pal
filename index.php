<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="fud-pal, Navigation App, Location, Google map" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <meta name="description" content="This is a software developed as a project to get certified by Trybe-x Community" />
  <meta name="author" content="Team Alpha" />
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" />
  <script type="text/javascript" src="assets/js/script.js"></script>
  <!-- bootstrap -->
  <link rel="stylesheet" href="path/to/bootstrap/dist/css/bootstrap.min.css">
  <script src="path/to/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- owl carosoul -->
  <link rel="stylesheet" href="path/to/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="path/to/owl.carousel/dist/assets/owl.theme.default.min.css">
  <script src="path/to/owl.carousel/dist/owl.carousel.min.js"></script>
  <!-- icon link -->
  <link rel="icon" href="assets/images/Fud_20240913_191519_0000.png" type="image/png" sizes="30x30" />
  <style type="text/css">
    * {
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      margin: 0;
      padding: 0%;
      box-sizing: border-box;
      font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;
    }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      background-color: #ffffff;
    }

    .header {
      width: 100%;
      background-color: #00a651;
      padding: 12px;
      top: -10px;
      display: flex;
      position: static;
      z-index: 100;
      align-items: center;
    }

    .header img {
      width: 30px;
      height: 30px;
    }

    .container {
      text-align: center;
      width: 80%;
      max-width: 400px;
    }

    h1 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      position: relative;
    }

    label {
      display: block;
      font-size: 16px;
      font-weight: 550;
      margin-bottom: 5px;
      text-align: left;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 2px solid #a0522d;
      border-radius: 25px;
      font-size: 16px;
    }

    input:active {
      border: 2px solid #a0522d;
    }

    .login-button {
      background-color: #a0522d;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      width: 100%;
      font-size: 16px;
      cursor: pointer;
    }

    .login-button:hover {
      opacity: 0.8;
    }

    .register-link {
      margin-top: 20px;
      font-size: 14px;
    }

    .register-link a {
      color: #a0522d;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <?php
  include("/database/connection.php");
  if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $result = mysqli_query($con, "SELECT * FROM users WHERE Email='$email' AND password='$password' ") or die('select Error');
    $row = mysqli_fetch_assoc($result);
    if (is_array($row) && !empty($row)) {
      $_SESSION['valid'] = $row['Email'];
      $_SESSION['name'] = $row['Name'];
      $_SESSION['regno'] = $row['Reg_no'];
      $_SESSION['id'] = $row['Id'];
    } else {
      echo "<div class='container2'>
                            <p>Wrong Name or Password</p>
                              </div> <br>";
      echo "<a href='index.php'><button class='btn'> Go back</button>";
    }
    if (isset($_SESSION['valid'])) {
      header("Location: dashboard.html");
    }
  } else {
  ?>
    <div class="header">
      <img
        alt="Logo"
        height="35"
        src="assets/images/Fud_20240913_191519_0000.png"
        width="35" />
    </div>
    <div class="container">
      <h1>LOGIN!</h1>
      <form>
        <label for="email"> Email </label>
        <input id="email" name="email" type="text" />
        <label for="password"> Password </label>
        <input id="password" name="password" type="password" />
        <button class="login-button" name="login" type="submit">Login</button>
      </form>
      <div class="register-link">
        Don&apos;t Have An Account?
        <a href="signup.html"> Register Here! </a>
      </div>
    </div>
  <?php } ?>
</body>

</html>