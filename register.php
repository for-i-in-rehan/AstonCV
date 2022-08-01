<?php
                $dbuser = "u-210034413";
                $dbpass = "FpL5U86SrmtHHbr";
                $dbname = "u_210034413_db";
                $dbserver = "localhost";
                $errormsg = "";
                $hash = "";

                $conn = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }



              


                if(isset($_POST['submit'])){
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $confirm_email = $_POST['confirm-email'];
                    $password = $_POST['password'];
                    $confirm_password = $_POST['confirm-password'];
                    $emailcheck =  false;
                    

                    if($email == $confirm_email){
                        if($password == $confirm_password){
                            $sql = "SELECT * FROM cvs";
                            $result = mysqli_query($conn, $sql);
        
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if($email == $row["email"]){
                                        $errormsg = "This already exists, Please use a different email address";
                                        $emailcheck = true;
                                    }
                                }

                                if($emailcheck == false) {
                                    $hash = password_hash($password, PASSWORD_DEFAULT);
                                    $sql = "INSERT INTO cvs (name, email, password) VALUES ('$name', '$email', '$hash')";
                                    $errormsg = "Account Created successfully";

                                }
                            }


                            if(mysqli_query($conn, $sql)){
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                            } else {
                            $errormsg = "Passwords do not match";
                            }
                    } else {
                            $errormsg = "Emails do not match";
                        }


                    mysqli_close($conn);
                    
                }

                
                ?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="CSS/register.css">
</head>
<body>
<section class="contact-me">
            <div class="wrapper">

                <h2>Register</h2>
                <form id="myform" name="contact" onsubmit="return validate(); return false;" action="register.php" method="post">
                    <div class="input_field">
                        <input type="text" placeholder="Name" id="name" name="name" required>
                    </div>
                    <div class="input_field">
                        <input type="email" placeholder="Email" id="email" name="email" required>
                    </div>
                    <div class="input_field">
                        <input type="email" placeholder="Confirm email" id="subemail" name="confirm-email" required>
                    </div>
                    <div class="input_field">
                        <input type="password" placeholder="Password" id="phone" name="password" required>
                    </div>
                    <div class="input_field">
                        <input type="password" placeholder="Confirm Password" id="phone" name="confirm-password" required>
                    </div>
                    <div class="submit">
                        <input type="submit" name="submit" id="register" value="register">
                    </div>
                    <div class="error_message">
                    <label>
                     <?php echo $errormsg; ?>
                             </label>       
                </div>
                <div class="login">
                <a href="home.php">Login here</a> 
                </div>
                </form>
            </div>
        </section>
</body>
</html>