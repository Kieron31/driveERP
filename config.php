<?php

//connect


function connectToDatabase() {
    $dbName = "siteLogin";
    $sqlUser = "Kieron";
    $sqlPass = "Admin";
    $host = "DESKTOP-VG3HOEJ";
    $conn = new PDO('sqlsrv:Server=DESKTOP-VG3HOEJ; Database=siteLogin; ConnectionPooling=0 ', $sqlUser, $sqlPass);


if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
return $conn;
}
?>