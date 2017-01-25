<?php
$orderID = $_POST['orderID'];
$email = $_POST['email'];
$custName = $_POST['custName'];
$dueDate = $_POST['dueDate'];
$custTele = $_POST['custTele'];

//****************************/
//Co-ordinates
$itemLineHeight = 12;
$productX = 20;
$startItemRow = 100;
$startItemRow2 = 30;
$currentRow = 0;
$currentColumn = 0;
$startColumn = 35;
$priceCol = 460;
$lrgProductX = 50;
$totalCost = 0;
$maxRow = 250;
$totalColumn = 165;
$grandTotalDisplay = 145;

//******************************/

include ("connect.php");
$sqlclass = new connect();
$sqlconn = $sqlclass->sqlConnection();

if ($sqlconn != null) {
    try {
        $sqlQuery = "SELECT        OrderHeader.OrderID, OrderHeader.dueDate, OrderHeader.email, OrderItems.quantity, STR((OrderItems.price),6,2) as price, Products.ProductCode, Products.ProductDescShort, STR((OrderItems.quantity * OrderItems.price),6,2) as itemValue
FROM            OrderHeader INNER JOIN
                         OrderItems ON OrderHeader.OrderID = OrderItems.OrderID INNER JOIN
                         Products ON OrderItems.ProductID = Products.ProductID 
 WHERE OrderItems.OrderID = $orderID ";
        $result = $sqlconn->prepare($sqlQuery);

        $result->execute();
        $rs = $result->fetchAll();
        $rs = $rs;
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

$pdf->SetFont('Arial', 'B', 14);
$currentColumn = $startColumn;
newPage($pdf);
$pdf->Text (85,20, "Your Order ID is: $orderID");
$pdf->Text (25,35, "Customer Details: ");
$pdf->SetFont('Arial', 'I', 10);
$pdf->Text (25,45, "Customer Email: $email ");
$pdf->Text (25,55, "Customer Telephone: $custTele ");
$pdf->Text (25,65, "Supermarket Branch: $custName ");
$pdf->Text (25,75, "Order Due By: $dueDate (MM/DD/YYYY)");
$pdf->SetFont('Arial', 'I', 14);
$pdf->Text (22,92, "Product Code");
$pdf->Text (67,92, "Product Name");
$pdf->Text (113,92, "Price");
$pdf->Text (133,92, "Quantity");
$pdf->Text (163,92, "Cost For Items");
$pdf->PageNo();
$currentRow = $startItemRow;
$pdf->SetXY($currentColumn, $currentRow);
foreach ($rs as $dataSet) { 
    $pdf->SetX(26);
    //1st Column Product Code
    $productCode = $dataSet['ProductCode'];
    $price = $dataSet['price'];
    $productName = $dataSet['ProductDescShort'];
    $quantity = $dataSet['quantity'];
    $itemValue = $dataSet['itemValue'];
    
    
    
    
    $pdf->Cell(20,6,$productCode,0, 0, C);
    //2nd Column Product Name
    
    $pdf->Cell(65,6,$productName,0, 0, C);
    //3rd Column Product Price
    
    $pdf->Cell(10,6,$price,0, 0, C);
    //4th Column Order Quantity
    
    $pdf->Cell(40,6,$quantity,0, 0, C);
    //5th Column Item cost
    
    $pdf->Cell(35,6,$itemValue,0, 0, C);
    //6th Column Total Value
    $totalCost = $totalCost + $itemValue;
    $pdf->Ln();
    if($currentRow > $maxRow){
        newPage($pdf);
    }
}
$pdf->SetX($grandTotalDisplay);
$pdf->Cell(50, 10, "Total Cost = " . (number_format($totalCost,2)));

$pdf->Output();




function newPage($pdf)
{
    global $currentRow, $startItemRow2;
    
    //Add new page header
    $pdf->AddPage();
    $currentRow = $startItemRow2;
    $pdf->Image ('images/blissLogo.png',8,4,25,17);
    $pdf->Cell(0, 5, "Page " . $pdf->PageNo(), 5,1,R);
    $pdf->SetXY(5, $currentRow);
}

?>