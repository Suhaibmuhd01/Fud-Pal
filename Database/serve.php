<?php  
 include("./database/connection.php");

 $server = "localhost";
 $username = "root";
 $password = "";
 $database = "localhost";

 $conn = mysqli_connect($server,$username,$password,$database) or die("Error occurred");

 if(isset($_POST['submit'])){
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $regno = $_POST['Reg_no'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_psw'];

    // verify  the unique Reg number
    $verify_query = mysqli_query($con, " SELECT Reg_no FROM Student WHERE Reg_no ='$regno'");

    if(mysqli_num_rows($verify_query) !=0){
     echo "<div class='message'>
                 <p>❌Already used Reg Number, Try another one please!</p>
             </div> <br>";
     echo "<a href='javascript:self.history.back()'><button class='btn'> Go back</button[>";
    }
    else{
     // insert user data to the db
     mysqli_query($con,"INSERT INTO Student(Name, Email,Reg_no,Password, Confirm_psw) VALUES('$name','$email','$regno,'$password', $confirm_psw)") or die("Error Occurred");

     echo "<div class='message'>
             <p>Registration Successful ✔</p>
         </div> <br>";
     echo "<a href='index.php'><button class='btn'> Login Now </button>";

    }
}else{
    header("Location: index.html");
}
    ?>