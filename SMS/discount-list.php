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
        <title>SMS Discount Codes</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.png">
        <link href="assets/styles.css" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <img src="Amazoff-logo.png" style="height: 150px;" />
            <span style="padding-left: 100px;">Store Management System - Discount Codes</span>            
        </div>        
        <section class="container" >
            <div class="sidenav">
                <div id="cssmenu">
                    <ul>
                       <li><a href="index.php"><span>Home</span></a></li>
                       <li class="active"><a href="discount-list.php">Expired Codes</a></li>
                       <li><a href="product-list.php">Potential Buyers</a></li>
                    </ul>
                </div>
            </div>
            <div class="main">
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
            
        </section>
    </body>
</html>
<?php

$resultObj->close();
$connection->close();

?>