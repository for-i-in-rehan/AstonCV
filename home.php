<?php
    $dbuser = "u-210034413";
    $dbpass = "FpL5U86SrmtHHbr";
    $dbname = "u_210034413_db";
    $dbserver = "localhost";
    $conn = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    session_start();
	$errormsg = "";
		
	if(isset($_POST['login'])){
           $email = $_POST['email'];
           $password = $_POST['password'];
           $sql = "SELECT * FROM cvs";
           $result = mysqli_query($conn, $sql);
		$UserLoggedIn = false;
           if (mysqli_num_rows($result) >= 1) {
               while ($row = mysqli_fetch_assoc($result)) {
                   if($email == $row["email"]){
                       $passwordunhasher = password_verify($password, $row['password']);
                       if($passwordunhasher){
                           $UserLoggedIn = true;
                           $name = $row["name"];
                           $_SESSION['email'] = $row["email"];
                           $_SESSION['name'] = $row["name"];
                       }else{
                           $error = "Incorrrect Password!";
                       }
                   }else{
                       $error = "Incorrect Email!";
                   }
               }
           }      
           mysqli_close($conn);    
       }

       if(isset($_POST['Logout'])){
        $UserLoggedIn = false;
        session_unset();
        session_destroy();
        header("Location: home.php");

    }     
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="CSS/logout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>AstonCV</title>
</head>
<body>
<header class="main-header" id="header">
            <nav>
                <a href="home.php">
                    <div class="logo">
                        AstonCV
                    </div>
                </a>
                <input type="checkbox" name="z" id="checkboxClick">
                <label for="checkboxClick" class="menu-btn">
                <i class="fa fa-bars"></i> 
            </label>
                <ul class="nav-">
                    <li><a href="home.php" class="acitve">Home</a></li>
                    <li><a href="CV.php" class="acitve">CV</a></li>
                </ul>
            </nav>
        </header>

   <div>

   <section class="contact-me">
    <?php
        if (!isset($_SESSION['email'])){
                

        ?>
            <div class="wrapper">
                <h2>Login</h2>
                <form id="myform" name="contact" onsubmit="return validate(); return false;" action="home.php" method="post">
                    <div class="input_field">
                        <input type="email" placeholder="Email" id="email" name="email" required >
                    </div>
                    <div class="input_field">
                        <input type="password" placeholder="Password" id="phone" name="password" required>
                    </div>
                    <div class="submit">
                        <input type="submit" name="login" id="login" value="Login">
                    </div>
                    <div class="error_message">
                    <label>
                     <?php echo $errormsg; ?>
                             </label>       
                </div>
                    <div class="register">
                        <a href="register.php">Register Here</a>
                    </div>
                </form>
            </div>



        </section>
        <?php
        }else{

        
        ?>
   
        <section>
            <div class="box">
            <div class="welcome">
            <label><?php echo "Welcome ".$_SESSION["name"]; ?></label>
            </div>
            <div class="log">
                <form action="home.php" method="post">
                    <input type="submit" name="Logout" value="Logout" class="out" placeholder=""id="Logout">
                </form>
                    </div>
                    <div>
        </section>

    <?php


    }

?>


    
</body>
</html>