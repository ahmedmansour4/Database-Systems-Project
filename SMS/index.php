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
    </head>
    <body>
        <div id="Header">
            <h2>
                Willkommen <?=$firstname?>, your email is <?=$email?>
            </h2>
        </div>        
        <div id="Body">
            There is no much to do here, but you can try one of the following:
            <ul>
                <li>
                    <a href="discount-list.php">List of Discount Codes</a>
                </li>     
                <li>
                    <a href="product-list.php">List of Products</a>
                </li>               
            </ul>
        </div>
    </body>
</html>