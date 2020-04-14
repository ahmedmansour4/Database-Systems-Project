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
$discountCode = $_SERVER['QUERY_STRING'];

$query = "
    SELECT 
        ORD.OrderId,
        USR.UserName,
        USR.Email,
        ORD.BillingAddress,
        ORD.ShippingAddress,
        PRD.`Name` ProductName,
        PRD.Description,
        PRD.AmazonUrl,
        PRD.ImageUrl,
        PRD.Price,
        DCD.DiscountPercent,
        (PRD.Price*DCD.DiscountPercent/100) DiscountedPrice,
        ORD.CreditCardCompany,
        ORD.CreditCardExpirationMonth,
        ORD.CreditCardExpirationYear,
        ORD.CreditCardName,
        ORD.CreditCardNumber,
        ORD.CreditCardSecurityCode,
        ORD.CreatedDate

    FROM 
        amazoffdb.`Order` ORD 	INNER JOIN amazoffdb.`User` USR ON (ORD.UserID=USR.UserId)
                                INNER JOIN amazoffdb.`Product` PRD ON (ORD.ProductID=PRD.ProductID)
                                INNER JOIN amazoffdb.`DiscountCode` DCD ON (ORD.DiscountCode=DCD.DiscountCode)
    WHERE
        ORD.DiscountCode = ?;";

$statementObj = $connection->prepare($query);
$statementObj->bind_param("s", $discountCode);
$statementObj->execute();

$statementObj->bind_result(
    $OrderId,
    $UserName,
    $Email,
    $BillingAddress,
    $ShippingAddress,
    $ProductName,
    $Description,
    $AmazonUrl,
    $ImageUrl,
    $Price,
    $DiscountPercent,
    $DiscountedPrice,
    $CreditCardCompany,
    $CreditCardExpirationMonth,
    $CreditCardExpirationYear,
    $CreditCardName,
    $CreditCardNumber,
    $CreditCardSecurityCode,
    $CreatedDate
);
$statementObj->store_result();

$message = "";
if ($statementObj->num_rows <= 0) 
{
    $message = "No orders available for this discount code.";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SMS Discounted Orders</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.png">
        <link href="assets/styles.css" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <img src="Amazoff-logo.png" style="height: 150px;" />
            <span style="padding-left: 100px;">Store Management System - Discounted Orders</span>            
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
                        <th>Order Id</th>
                        <th>UserName</th>
                        <th>Email</th>
                        <th>Billing Address</th>
                        <th>Shipping Address</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Url</th>
                        <th>Image Url</th>
                        <th>Price</th>
                        <th>Discount Percent</th>
                        <th>Discounted Price</th>
                        <th>Credit Card Company</th>
                        <th>Credit Card Expiration Month</th>
                        <th>Credit Card Expiration Year</th>
                        <th>Credit Card Name</th>
                        <th>Credit Card Number</th>
                        <th>Credit Card Security Code</th>
                        <th>Created Date</th>

                    </tr>
                    <?php while($statementObj->fetch()): ?>
                        <tr>
                            <td><?=$OrderId?></td>
                            <td><?=$UserName?></td>
                            <td><?=$Email?></td>
                            <td><?=$BillingAddress?></td>
                            <td><?=$ShippingAddress?></td>
                            <td><?=$ProductName?></td>
                            <td><?=$Description?></td>
                            <td><?=$AmazonUrl?></td>
                            <td><?=$ImageUrl?></td>
                            <td><?=$Price?></td>
                            <td><?=$DiscountPercent?></td>
                            <td><?=$DiscountedPrice?></td>
                            <td><?=$CreditCardCompany?></td>
                            <td><?=$CreditCardExpirationMonth?></td>
                            <td><?=$CreditCardExpirationYear?></td>
                            <td><?=$CreditCardName?></td>
                            <td><?=$CreditCardNumber?></td>
                            <td><?=$CreditCardSecurityCode?></td>
                            <td><?=$CreatedDate?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <?=$message?>
                <a href='discount-list.php'>Go back to the discount list</a>
            </div>
            
        </section>
    </body>
</html>
<?php

$statementObj->close();
$connection->close();

?>

