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


<?php 
    //Get number of rows
    $sql = "SELECT * FROM cvs";
    $result = $conn->query($sql);
    $increment = 1;
    $id = array();
    $name = array();
    $email = array();
    $education = array();
    $profile = array();
    $keyprogramming = array();
    $URLinks = array();
    

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id[$increment] = $row['id'];
            $name[$increment] = $row["name"];
            $email[$increment] = $row["email"];
            $education[$increment] = $row["education"];
            $profile[$increment] = $row["profile"];
            $keyprogramming[$increment] = $row["keyprogramming"];
            $increment++;
        } 
        
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/table.css">
    <link rel="stylesheet" href="CSS/CV.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
         
    

<?php
    if(!isset($_GET['get'])){

?>
                    
                    

<div class="details">
    <table class="table" border="5" >
        <tr class="data" >
            <th>Name</th>
            <th>Email</th>
            <th>Key Programming</th>
            <th>More Infomation Here</th>
        </tr>
        <?php 
        $data = $result->num_rows;


        for ($item = 1; $item <= $data; $item++) 
        {

    
        ?>

        <tr class="Item" border = "5">
            <th border = "5"> <?php echo $name[$item]; ?> </th>
            <th border = "5"> <?php echo $email[$item]; ?> </th>
            <th border = "5" > <?php echo $keyprogramming[$item]; ?> </th>
            <th border = "5">
                <button class= "More-Info" type="button"><a href="CV.php?get=<?php echo $email[$item]; ?>">More Info </a></button>

            </th>
        </tr>



<?php

    }

} else if (isset($_GET['get'])){

    $sql = "SELECT * FROM cvs WHERE email = '$_GET[get]'";
               
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $Opened_ID = $row["id"];   
            $Opened_Name = $row["name"];
            $Opened_Email = $row["email"];
            $Opened_Profile = $row["profile"];
            $Opened_KeyProgramming = $row["keyprogramming"];
            $Opened_URLinks = $row["URLlinks"];
            $Opened_Education = $row["education"];
        } 
        
    }


?>

<div class="dataList"> 
    <label>ID: <?php echo $Opened_ID?></label><br>
    <label>Name: <?php echo $Opened_Name?></label><br>
    <label>Email: <?php echo $Opened_Email?></label><br>
    <label>Profile: <?php echo $Opened_Profile?></label><br>
    <label>Key Programming: <?php echo $Opened_KeyProgramming?></label><br>
    <label>Education: <?php echo $Opened_Education?></label><br>
    <label>URL links: <?php echo $Opened_URLinks?></label><br>
</div>

<?php 
if($_SESSION == true){
    if($_SESSION['email'] == $_GET['get']){
}



?>

<div class="padder"> 
</div>

<div class="editList">
    <form action="CV.php" method="POST">
        <label>ID<label><br>
        <input name="id" value="<?php echo $Opened_ID?>"><br>
        <label>Name<label><br>
        <input name="name" value="<?php echo $Opened_Name?>"><br>
        <label>Email<label><br>
        <input name="email" value="<?php echo $Opened_Email?>"><br>
        <label>Profile<label><br>
        <input name="profile" value="<?php echo $Opened_Profile?>"><br>
        <label>Programming language<label><br>
        <input name="keyprogramming" value="<?php echo $Opened_KeyProgramming?>"><br>
        <label>Education<label><br>
        <input name="education" value="<?php echo $Opened_Education?>"><br>
        <label>URLs<label><br>
        <input name="URLlinks" value="<?php echo $Opened_URLinks?>"><br>
        <input name="edit" type= "submit" value="Edit">
    </form>

</div>

<?php

if(isset($_POST['edit'])){
    $db = mysqli_select_db($conn, 'astoncv');
    $sql = "UPDATE cvs SET id = '$_POST[id]', name = '$_POST[name]', email = '$_POST[email]', profile = '$_POST[profile]', keyprogramming = '$_POST[keyprogramming]', education = '$_POST[education]', URLlinks = '$_POST[URLlinks]' WHERE id = '$Opened_ID'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
  
    
    

}
?>


<?php
}
}
?>




    </table>
    
</body>
</html>