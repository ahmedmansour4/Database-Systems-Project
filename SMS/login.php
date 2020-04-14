<?php
include 'assets/include.php';
$message = "";
if(isset($_SESSION['isSignedIn'])){
    $isSignedIn = $_SESSION['isSignedIn']; 
    if($isSignedIn === "BAD"){
        $message = "Weird... Wrong user-password combination. Are you sure you are supposed to be here?";
    }  
    else {
        if(isset($_SESSION['UserId']))
        {
            $userId = $_SESSION['UserId'];
            $username = $_SESSION['UserName'];
            $firstname = $_SESSION['FirstName'];
            $lastname = $_SESSION['LastName'];
            $email = $_SESSION['Email'];
            $isAdmin = $_SESSION['isAdmin'];
            if($isAdmin == "1"){
                $message = "Hey admin! What are you doing here? <a href='index.php'>Go to the admin section?</a>";
            }
            else{
                $message = "Hey user! You are not an admin. Sorry!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SMS Home Page</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.png">
        <link href="assets/styles.css" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <img src="Amazoff-logo.png" style="height: 150px;" />
            <span style="padding-left: 100px;">SMS Login</span>            
        </div>        
        <section class="container" >
            <div class="sidenav">
                <div id="cssmenu">
                    <ul>
                       <li class="active"><a href="login.php"><span>Login</span></a></li>
                       <li><a href="http://amazoff.fun/">Store</a></li>
                    </ul>
                </div>
            </div>
            <div class="main">
                <h2>
                        Please, enter your credentials to login
                </h2>
                <form method="post" action="assets/sms-auth.php" >
                    <div>
                        <label>Username:</label>
                        <input type="text" name="username" />
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" />
                    </div>
                    <div class="multiple">
                        <label>&nbsp;</label>
                        <input type="submit" name="submit" value="Login">
                    </div>
                </form>
                <?=$message?>
            </div>            
        </section>
    </body>
</html>