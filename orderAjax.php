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
            $sqlQuery = "SELECT Cost FROM Products WHERE ProductID = $ProductID  ";
            $result = $sqlconn->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            foreach ($rs as $dataset){
            $jsonVal->costResults = $dataset['Cost'];
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
    if ($sqlconn != null) {
        try {
            $sqlQuery = "INSERT INTO OrderItems(OrderID , ProductID, quantity, price) VALUES ($orderID ,$ProductID, $quantity, $totalCost) ";
            $result = $sqlconn->prepare($sqlQuery);
            $result->execute();
            //$rs = $result->fetchAll();
            
            //print_r($rs);
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