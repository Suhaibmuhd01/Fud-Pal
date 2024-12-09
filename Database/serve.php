<?php  
 
 include("/database/connection.php");
 if(isset($_POST['submit'])){
    $name = $_POST['Username'];
    $email = $_POST['Email'];
    $regno = $_POST['Reg_no'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_psw'];

    // verify  the unique email

    $verify_query = mysqli_query($con, " SELECT Email FROM user WHERE Email ='$email'");

    if(mysqli_num_rows($verify_query) !=0){
     echo "<div class='message'>
                 <p>❌This email is used, Try another one please!</p>
             </div> <br>";
     echo "<a href='javascript:self.history.back()'><button class='btn'> Go back</button[>";
    }
    else{
     // insert user inputs to the db
     mysqli_query($con,"INSERT INTO user(Username, Email,Age,Password) VALUES('$username','$email','$age','$password')") or die("Error Occurred");

     echo "<div class='message'>
             <p>Registration Successful ✔</p>
         </div> <br>";
     echo "<a href='index.php'><button class='btn'> Login Now </button>";

    }
}else{
    header("Location: index.html");
}
    ?>