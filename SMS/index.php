<?php

include 'assets/include.php';
include 'assets/db.php';

if(isset($_SESSION['UserId']))
{
    $userId = $_SESSION['UserId'];
    $username = $_SESSION['UserName'];
    $firstname = $_SESSION['FirstName'];
    $lastname = $_SESSION['LastName'];
    $email = $_SESSION['Email'];
    $isAdmin = $_SESSION['isAdmin'];
}
else
{
    header('Location: login.php');   
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
            <span style="padding-left: 100px;">Store Management System</span>            
        </div>        
        <section class="container" >
            <div class="sidenav">
                <div id="cssmenu">
                    <ul>
                       <li class="active"><a href="index.php"><span>Home</span></a></li>
                       <li><a href="discount-list.php">Expired Codes</a></li>
                       <li><a href="product-list.php">Potential Buyers</a></li>
                    </ul>
                </div>
            </div>
            <div class="main">
                Willkommen <?=$firstname?>, your email is <?=$email?>
            </div>
            
        </section>
    </body>
</html>