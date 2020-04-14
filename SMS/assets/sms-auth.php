<?php

require 'include.php';
$postedData = $_POST;
//unset($_SESSION['formPostData']);
if(isset($_SESSION['isSignedIn'])){
    unset($_SESSION['isSignedIn']); 
    if(isset($_SESSION['UserId']))
    {
        unset($_SESSION['UserId']);
        unset($_SESSION['UserName']);
        unset($_SESSION['FirstName']);
        unset($_SESSION['LastName']);
        unset($_SESSION['Email']);
        unset($_SESSION['isAdmin']);
    }
}
login($postedData['username'], $postedData['password']);

function login($username, $pass){
    
    require 'include.php';
    require 'db.php';    
   
    $pass = hash('md5', $pass);
    $query = "SELECT UserId, UserName, FirstName, LastName, Email, AdminFlag FROM User WHERE UserName = ? AND PassHashed = ?";
    $statementObj = $connection->prepare($query);

    $statementObj->bind_param("ss", $username, $pass);
    $statementObj->execute();

    $statementObj->bind_result($userId, $username, $firstname, $lastname, $email, $isAdmin);
    $statementObj->store_result();


    if ($statementObj->num_rows > 0) 
    {
        
        while($statementObj->fetch()){
            $_SESSION['isSignedIn'] = "GOOD";
            $_SESSION['UserId'] = $userId;
            $_SESSION['UserName'] = $username;
            $_SESSION['FirstName'] = $firstname;
            $_SESSION['LastName'] = $lastname;
            $_SESSION['Email'] = $email;
            $_SESSION['isAdmin'] = $isAdmin;
            
            if($isAdmin){
                header('Location: ../index.php');
            }
            else{
                header('Location: ../login.php');
            }            
        }
    }
    else {
        $_SESSION['isSignedIn'] = "BAD";
        header('Location: ../login.php');
    }


    $statementObj->close();    
    $connection->close();
}




//$username = $postedData['username']; // "gus";
//$pass = $postedData['password']; // "4be2e464084e503ba43674e8da673434";
// echo hash('md5', 'COP4710-2020');
//$pass = hash('md5', $pass);

?>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <div id="Header">
            <h2>
                    Please, wait while we log you in...
            </h2>
        </div>        
	</body>
</html>