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

$query = "
    SELECT 
        DCD.DiscountCodeId,
        DCD.DiscountCode,
        DCD.DiscountPercent,
        DCD.ExpirationDate,
        DCD.ExpiredFlag,
        DCD.ProductID,
        (`amazoffdb`.`fnGetOrderCountForDiscountCode`(DCD.DiscountCode)) OrderCount
    FROM 
            amazoffdb.`DiscountCode` DCD;";

$resultObj = $connection->query($query);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Discounts</title>
    </head>
    <body>
        <div id="Header">
            <h2>
                    Discount list
            </h2>
        </div>        
        <div id="Body">
            <table>
                <tr>
                    <th>Discount Code Id</th>
                    <th>Discount Code</th>
                    <th>Discount Percent</th>
                    <th>Expiration Date</th>
                    <th>Expired Flag</th>
                    <th>Product ID</th>
                    <th>Order Count</th>
                </tr>
                <?php while($row = $resultObj->fetch_assoc()): ?>
                    <tr>
                        <td><?=$row['DiscountCodeId']?></td>
                        <td><?=$row['DiscountCode']?></td>
                        <td><?=$row['DiscountPercent']?></td>
                        <td><?=$row['ExpirationDate']?></td>
                        <td><?=$row['ExpiredFlag']?></td>
                        <td><?=$row['ProductID']?></td>
                        <td><a href="discounted-order-list.php?<?=$row['DiscountCode']?>"><?=$row['OrderCount']?></a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <a href="index.php">Go back home.</a>
	</body>
</html>

<?php

$resultObj->close();
$connection->close();

?>