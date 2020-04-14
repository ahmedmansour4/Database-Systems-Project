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
$productId = $_SERVER['QUERY_STRING'];

$query = "
    SELECT 
        USR.`UserId`,
        USR.`UserName`,
        USR.`FirstName`,
        USR.`LastName`,
        USR.`Email`,
        USR.`Phone`
    FROM 
            amazoffdb.`User` USR 
    WHERE 
            USR.UserID IN (SELECT UserID FROM amazoffdb.`Order` WHERE ProductID = ?);";

$statementObj = $connection->prepare($query);
$statementObj->bind_param("i", $productId);
$statementObj->execute();

$statementObj->bind_result($UserId,$UserName,$FirstName,$LastName,$Email,$Phone);
$statementObj->store_result();

$message = "";
if ($statementObj->num_rows <= 0) 
{
    $message = "No possible buyers available for this product.";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Possible Buyers</title>
    </head>
    <body>
        <div id="Header">
            <h2>
                List of Possible Buyers
            </h2>
        </div>        
        <div id="Body">
            <table>
                <tr>
                    <th>User Id</th>
                    <th>UserName</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
                <?php while($statementObj->fetch()): ?>
                    <tr>
                        <td><?=$UserId?></td>
                        <td><?=$UserName?></td>
                        <td><?=$FirstName?></td>
                        <td><?=$LastName?></td>
                        <td><?=$Email?></td>
                        <td><?=$Phone?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <?=$message?>
        </div>
        <a href='product-list.php'>Go back to the product list</a>
	</body>
</html>

<?php

$statementObj->close();
$connection->close();

?>

