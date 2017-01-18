<?

$errFlg = 0;
$errMsg = " ";
$ProductID = $_POST['ProductID'];
$sqlconn = null;
include_once 'config.php';
$sqlconn = connectToDatabase();

$target_dir = 'uploads/';
$target_fileName = $target_dir . basename($_FILES['productImage']['name']);
if (move_uploaded_file($_FILES['productImage']['tmp_name'], $target_fileName)) {
    echo 'uploaded';
        $sqlQuery = "UPDATE Products SET productImgPath='$target_fileName' WHERE ProductID=$ProductID  ";
        //echo $sqlQuery;
        $result = $sqlconn->prepare($sqlQuery);

        $result->execute();
        $rs = $result->fetchAll();
        //print_r($rs);
        //print_r($result->rowCount());  
} else {
    echo'error uploading';
}
?>