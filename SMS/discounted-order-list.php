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
$ProductName = "";
$Description = "";
$AmazonUrl = "";
$ImageUrl = "";
$Price = 0.0;
$DiscountPercent = 0;
$DiscountedPrice = 0.0;
$OrderCount = 0;

$productquery = "
    SELECT DISTINCT
        PRD.`Name` ProductName,
        PRD.Description,
        PRD.AmazonUrl,
        PRD.ImageUrl,
        PRD.Price,
        DCD.DiscountPercent,
        CAST((PRD.Price - (PRD.Price*DCD.DiscountPercent/100)) AS DECIMAL(12,2)) DiscountedPrice,
        `amazoffdb`.fnGetOrderCountForDiscountCode(ORD.DiscountCode) OrderCount

    FROM 
        amazoffdb.`Order` ORD 	
        INNER JOIN amazoffdb.`Product` PRD ON (ORD.ProductID=PRD.ProductID)
        INNER JOIN amazoffdb.`DiscountCode` DCD ON (ORD.DiscountCode=DCD.DiscountCode)
    WHERE
        ORD.DiscountCode = ?;";

$productStatementObj = $connection->prepare($productquery);
$productStatementObj->bind_param("s", $discountCode);
$productStatementObj->execute();

$productStatementObj->bind_result(
    $ProductName,
    $Description,
    $AmazonUrl,
    $ImageUrl,
    $Price,
    $DiscountPercent,
    $DiscountedPrice,
    $OrderCount
);
$productStatementObj->store_result();
$productStatementObj->fetch();

$productStatementObj->close();    

$query = "
    SELECT 
        ORD.OrderId,
        USR.UserName,
        USR.Email,
        ORD.BillingAddress,
        ORD.ShippingAddress,
        ORD.CreditCardCompany,
        ORD.CreditCardExpirationMonth,
        ORD.CreditCardExpirationYear,
        ORD.CreditCardName,
        ORD.CreditCardNumber,
        ORD.CreditCardSecurityCode,
        ORD.CreatedDate

    FROM 
        amazoffdb.`Order` ORD 	
        INNER JOIN amazoffdb.`User` USR ON (ORD.UserID=USR.UserId)
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
                       <li><a href="ItemAdding/AdjustDiscountPolicy.html">Adjust Discounts</a></li>
					   <li><a href="ItemAdding/AddItem.html">Add or Delete Items</a></li>
                    </ul>
                </div>
            </div>
            <div class="main">
                <div>
                    <h3>Product Information</h3>
                    <table style="width: 500px;">
                        <tr>
                            <td style="width:200px">
                                Discount Code
                            </td>
                            <td>
                                <?=$discountCode?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Original Price
                            </td>
                            <td>
                                $ <?=$Price?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Count of Orders 
                            </td>
                            <td>
                                <?=$OrderCount?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Discount
                            </td>
                            <td>
                                <?=$DiscountPercent?> %
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Current Discounted Price
                            </td>
                            <td>
                                $ <?=$DiscountedPrice?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Name
                            </td>
                            <td>
                                <?=$ProductName?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Description
                            </td>
                            <td>
                                <?=$Description?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Url
                            </td>
                            <td>
                                <?=$AmazonUrl?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Image
                            </td>
                            <td>
                                <img  style="width:250px" src="<?=$ImageUrl?>" />
                            </td>
                        </tr>
                    </table>
                </div>
                <br />
                <br />
                <div>
                    <h3>Orders For this Discount Code</h3>                
                    <table>
                        <tr>
                            <th>Order Id</th>
                            <th>UserName</th>
                            <th>Email</th>
                            <th>Billing Address</th>
                            <th>Shipping Address</th>
                            <th>CC Company</th>
                            <th>CC Month</th>
                            <th>CC Year</th>
                            <th>CC Name</th>
                            <th>CC Number</th>
                            <th>CC Sec Code</th>
                            <th>Created Date</th>
                        </tr>
                        <?php while($statementObj->fetch()): ?>
                            <tr>
                                <td><?=$OrderId?></td>
                                <td><?=$UserName?></td>
                                <td><?=$Email?></td>
                                <td><?=$BillingAddress?></td>
                                <td><?=$ShippingAddress?></td>
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
                </div>
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

