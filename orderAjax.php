<?php

$sqlconn = null;
include_once 'config.php';
$sqlconn = connectToDatabase();

$errFlg = 0;
$errMsg = " ";

$jsonVal = new stdClass();
$productInput = $_POST['productSearch'];
$customerInput = $_POST['customerSearch'];
$customerID = $_POST['customerID'];
$dueDate = $_POST['dueDate'];
$customerEmail = $_POST['customerEmail'];
$custTeleNum = $_POST['custTeleNum'];
$currency = $_POST['currency'];
$ProductID = $_POST['productID'];
$quantity = $_POST['quantity'];
$totalCost = $_POST['totalCost'];
$orderID = $_POST['orderID'];
$itemID = $_POST['itemID'];
$customerID2 = $_POST['customerID'];

$request = $_POST['request'];

if ($request == "searchUpdate") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "SELECT * FROM Customers WHERE CustomerName LIKE '%$customerInput%'; ";
            $result = $sqlconn->prepare($sqlQuery);

            $result->execute();
            $rs = $result->fetchAll();

            $jsonVal->dataResults = $rs;


            //print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
}
if ($request == "newOrder") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "INSERT INTO OrderHeader(CustomerID, dueDate, email, telNo, currency) VALUES ($customerID, '$dueDate', '$customerEmail', '$custTeleNum', '$currency')  ";
            $result = $sqlconn->prepare($sqlQuery);

            $result->execute();
            //$rs = $result->fetchAll();
            $last_id = $sqlconn->lastInsertId();
            $jsonVal->OrderID = $last_id;

            //print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
}
if ($request == "prodSearchUpdate") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "SELECT * FROM Products WHERE ProductDescLong LIKE '%$productInput%';  ";
            $result = $sqlconn->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            $jsonVal->prodResults = $rs;

            //print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
}
if ($request == "productCost") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "SELECT * FROM Products WHERE ProductID = $ProductID  ";
            $result = $sqlconn->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            foreach ($rs as $dataset){
            $jsonVal->costResults = $dataset['Cost'];
            $jsonVal->nameResults = $dataset['ProductDescShort'];
            }
            //print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
}
if ($request == "addOrder") {
    //Inserting order details into table
    if ($sqlconn != null) {
        try {
            $sqlQuery = "INSERT INTO OrderItems(OrderID , ProductID, quantity, price) VALUES ($orderID ,$ProductID, $quantity, $totalCost) ";
            $result = $sqlconn->prepare($sqlQuery);
            $result->execute();
            
            print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
}
if ($request == "drawTable") {
    //joins and selects customer table and product table
    if ($sqlconn != null) {
        try {
            $sqlQuery = "SELECT        OrderHeader.OrderID, OrderHeader.dueDate, OrderHeader.email, OrderItems.quantity, OrderItems.price, Products.ProductCode, Products.ProductDescShort, OrderItems.quantity * OrderItems.price as itemValue
FROM            OrderHeader INNER JOIN
                         OrderItems ON OrderHeader.OrderID = OrderItems.OrderID INNER JOIN
                         Products ON OrderItems.ProductID = Products.ProductID 
 WHERE OrderItems.OrderID = $orderID ";
            $result = $sqlconn->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            
            $jsonVal->orderResults = $rs;
            
            //print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
}
if ($request == "getCustomer") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "SELECT CustomerName FROM Customers WHERE CustomerID = $customerID2 ";
            $result = $sqlconn->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            
            $jsonVal->customer = $rs;
            print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
}
echo json_encode($jsonVal);
?>