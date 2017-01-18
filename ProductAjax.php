<?php

$errFlg = 0;
$errMsg = " ";

$jsonVal = new stdClass();
$request = $_POST['request'];
$ProductID = $_POST['ProductID'];
$ProductCode = $_POST['ProductCode'];
$ProductDescShort = $_POST['ProductDescShort'];
$ProductDescLong = $_POST['ProductDescLong'];
$ProductDescLong = htmlspecialchars($ProductDescLong, ENT_QUOTES);
$ProductEAN = $_POST['ProductEAN'];
$Cost = $_POST['Cost'];
$RRP = $_POST['RRP'];
$ProductCat = $_POST['ProductCat'];
$Weight = $_POST['Weight'];
$prodImg = $_POST['prodImg'];

$sqlconn = null;
include_once 'config.php';
$sqlconn = connectToDatabase();

if ($request == "getProduct") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = " SELECT * FROM Products WHERE ProductID=$ProductID ";
            $result = $sqlconn->prepare($sqlQuery);

            $result->execute();
            $rs = $result->fetchAll();

            foreach ($rs as $dataSet) {
                $jsonVal->ProductCode = $dataSet['ProductCode'];
                $jsonVal->ProductDescShort = $dataSet['ProductDescShort'];
                $jsonVal->ProductDescLong = $dataSet['ProductDescLong'];
                $jsonVal->ProductEAN = $dataSet['ProductEAN'];
                $jsonVal->Cost = $dataSet['Cost'];
                $jsonVal->RRP = $dataSet['RRP'];
                $jsonVal->ProductCat = $dataSet['ProductCat'];
                $jsonVal->Weight = $dataSet['Weight'];
                $jsonVal->prodImg = $dataSet['prodImg'];
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
if ($request == 'addProduct') {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "INSERT INTO Products (ProductCode, ProductDescShort, ProductDescLong, ProductEAN, ProductCat, Cost, RRP, Weight) VALUES ($ProductCode, '$ProductDescShort', '$ProductDescLong', $ProductEAN, '$ProductCat', $Cost, $RRP, $Weight);";
            $result = $sqlconn->prepare($sqlQuery);
            $result->execute();
            //$rs = $result->fetchAll();
            $prodID = $sqlconn->lastInsertId('Products');
            //print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        $errMsg = $e->getMessage();
    }
    $jsonVal->errMsg = $errMsg;
    $jsonVal->prodID = $prodID;
}

if ($request == "updateProduct") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "UPDATE Products SET ProductCode='$ProductCode', ProductDescShort='$ProductDescShort', ProductDescLong='$ProductDescLong', ProductEAN='$ProductEAN', ProductCat='$ProductCat', Cost=$Cost, RRP=$RRP, Weight=$Weight, productImgPath='$prodImg' WHERE ProductID=$ProductID  ";
            //echo $sqlQuery;
            $result = $sqlconn->prepare($sqlQuery);

            $result->execute();
            $rs = $result->fetchAll();
            //print_r($rs);
            //print_r($result->rowCount());  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
}
if ($request == "viewProduct") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "SELECT * FROM Products WHERE ProductID=$ProductID";
            //echo $sqlQuery;
            $result = $sqlconn->prepare($sqlQuery);

            $result->execute();
            $rs = $result->fetchAll();
            foreach ($rs as $dataSet) {
                $jsonVal->ProductCode = $dataSet['ProductCode'];
                $jsonVal->ProductDescShort = $dataSet['ProductDescShort'];
                $jsonVal->ProductDescLong = $dataSet['ProductDescLong'];
                $jsonVal->ProductEAN = $dataSet['ProductEAN'];
                $jsonVal->Cost = $dataSet['Cost'];
                $jsonVal->RRP = $dataSet['RRP'];
                $jsonVal->ProductCat = $dataSet['ProductCat'];
                $jsonVal->Weight = $dataSet['Weight'];
                $jsonVal->prodImg = $dataSet['prodImg'];
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

echo json_encode($jsonVal);
?>