<?php


$jsonVal = new stdClass();
$request = $_POST['request'];
$userID = $_POST['username'];
$passID = $_POST['password'];

$sqlconn = null;
include_once '../config.php';
$sqlconn = connectToDatabase();
$errMsg = "";
$loginValid =0;

if ($request == "homeLogin") {
    if ($sqlconn != null) {
        try {
            $sqlQuery = "SELECT * FROM LoginDetails WHERE username='$userID' AND password='$passID' ";
           // echo $sqlQuery;
            $result = $sqlconn->prepare($sqlQuery);

            $result->execute();
            $rs = $result->fetchAll();
            //print_r($rs);
            $loginValid = $result->rowCount();  
        } catch (PDOException $e) {
            $errFlg = 1;
            $errMsg = $e->getMessage();
        }
    }
    $jsonVal->errMsg = $errMsg;
    $jsonVal->loginValid = $loginValid;
}
echo json_encode($jsonVal);
?>