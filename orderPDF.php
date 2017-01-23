<?php

//****************************/
//Co-ordinates
$itemLineHeight = 12;
$productX = 14;
$startItemRow = 90;
$currentRow = 0;
$currentColumn = 0;
$startColumn = 14;
$priceCol = 460;
$lrgProductX = 60;
//******************************/
$orderID = $_POST['orderID'];
$sqlconn = null;
include_once 'config.php';
$sqlconn = connectToDatabase();

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
        
        //print_r($rs);
        //print_r($result->rowCount());  
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo 'connection error';
}

require('fpdf181/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$currentRow = $startItemRow;
$currentColumn = $productX;
foreach ($rs as $dataSet) { 
    //1st Column Product Code
    $productCode = $dataSet['ProductCode'];
    $pdf->Text($currentColumn ,$currentRow, $productCode);
    $currentColumn = $currentColumn + $productX;
    //2nd Column Product Name
    $productName = $dataSet['ProductDescShort'];
    $pdf->Text($currentColumn ,$currentRow, $productName);
    $currentColumn = $currentColumn + $lrgProductX;
    //3rd Column Product Price
    $price = $dataSet['price'];
    $pdf->Text($currentColumn ,$currentRow, $price);
    $currentColumn = $currentColumn + $productX;
    //4th Column Order Quantity
    $quantity = $dataSet['quantity'];
    $pdf->Text($currentColumn ,$currentRow, $quantity);
    $currentColumn = $currentColumn + $productX;
    //5th Column Item cost
    $itemValue = $dataSet['itemValue'];
    $pdf->Text($currentColumn ,$currentRow, $itemValue);
    $currentColumn = $startColumn;
    //6th Column Total Value
    
    
    $currentRow = $currentRow + $itemLineHeight;
}
$totalCost = $itemValue + $itemValue;
$pdf->Text($currentColumn, $currentRow, "Total Cost = $totalCost");

$pdf->Output();
?>