<?php

$errFlg = 0;
$errMsg = '';
$jsonVal = new stdClass();
$ProductCode = $_POST['ProductCode'];
$ProductDescShort = $_POST['ProductDescShort'];
$ProductDescLong = $_POST['ProductDescLong '];
$ProductEAN = $_POST['ProductEAN'];
$ProductCat = $_POST['ProductCat'];
$Cost = $_POST['Cost'];
$RRP = $_POST['RRP'];
$Weight = $_POST['Weight'];


$sqlconn = null;
include_once 'config.php';
$sqlconn = connectToDatabase();
if ($request == 'addProduct') {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "INSERT INTO Products (ProductCode, ProductDescSmall, ProductDescLong, ProductEAN, ProductCat, Cost, RRP, Weight) VALUES ($ProductCode, '$ProductDescShort', '$ProductDescLong', $ProductEAN, '$ProductCat', $Cost, $RRP, $Weight);";
            $result = $sqlconn->prepare($sqlQuery);

            $result->execute();
            $rs = $result->fetchAll();
            //print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo 'connection error';
    }
}
header('Location: home.php');
?>