<?php
$sqlconn = null;
include_once 'config.php';
$sqlconn = connectToDatabase();             ///connect to database
$ProductID = $_POST['ProductID'];
if (trim($ProductID) != "") {
    //Produc code has been posted 
    $errFlag = 0;
    //do sql
    $sqlQuery = "SELECT * FROM Products WHERE ProductID=$ProductID";
    //echo $sqlQuery;
    $result = $sqlconn->prepare($sqlQuery);

    $result->execute();
    $rs = $result->fetchAll();
    foreach ($rs as $dataSet) {
        $ProductCode = $dataSet['ProductCode'];
        $ProductDescShort = $dataSet['ProductDescShort'];
        $ProductDescLong = $dataSet['ProductDescLong'];
        $ProductEAN = $dataSet['ProductEAN'];
        $Cost = $dataSet['Cost'];
        $RRP = $dataSet['RRP'];
        $ProductCat = $dataSet['ProductCat'];
        $Weight = $dataSet['Weight'];
        $prodImg = "uploads/" . $dataSet['productImgPath'];
    }
} else {
    //no product code posted
    $errMsg = "no product found";
    $errFlag = 1;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jquery/jquery.min.js"></script>
        <script src="jquery/jquery-ui.min.js"></script>
        <script src="jquery/unslider-min.js"></script>
        <script src="jquery/unslider.js"></script>
        <script src="jquery/bootstrap.min.js"></script>
        <script src="jquery/bootstrapglyph.min.js"></script>
        <link rel='stylesheet' type='text/css' href='css/jquery-ui.min.css'>
        <link rel='stylesheet' type='text/css' href='css/unslider.css'>
        <link rel='stylesheet' type='text/css' href='css/unslider-dots.css'>
        <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='css/bootstrapglyph.min.css'>
        <!--<script src="jquery/mdb.min.js" type="text/javascript"></script>-->
        <script src="jquery/tether.min.js" type="text/javascript"></script>
        <!--<link href="css/mdb.min.css" rel="stylesheet" type="text/css"/>-->
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="styleSheet.css" rel="stylesheet" type="text/css"/>

        <style>
            #productName{
                background-color: lightgray;
                position: relative;
                width: 80%;
                margin: auto;
                padding: 8px;
            }
            #contentBody{
                position: relative;
                background-color: lightgray;
                width: 80%;
                height: 700px;
                top: 10px;
                padding: 10px;
                margin: auto;

            }
            #productDesc{
                background-color: graytext;
                position: relative;
                float: right;
                width: 66%;
                height: 620px;
                padding: 10px;
                color: white;
            }
            #productImg{
                background-color: beige;
                position: absolute;
                width: 500px;
                height: 500px;
            } 
            #prodDescNew
            {
                display:none;
                color: black;
                
            }
            #prodDescNow
            {
                display: block;
            }
            #prodCodeNew
            {
                display:none;
                color: black;
            }
            #prodCodeNow
            {
                display: block;
            }
            #prodEANNew
            {
                display:none;
                color: black;
            }
            #prodEANNow
            {
                display: block;
            }
            #prodCostNew
            {
                display:none;
                color: black;
            }
            #prodCostNow
            {
                display: block;
            }
            #prodRRPNew
            {
                display:none;
                color: black;
            }
            #prodRRPNow
            {
                display: block;
            }
            #prodWeightNew
            {
                display:none;
                color: black;
            }
            #prodWeightNow
            {
                display: block;
            }
            #updateBtn{
                display: none;
            }
        </style>
        <script>
            function initialiseEdit()
            {
                $('#prodDescNow').hide();
                $('#prodDescNew').show();
                
                $('#prodCodeNow').hide();
                $('#prodCodeNew').show();
                
                $('#prodEANNow').hide();
                $('#prodEANNew').show();
                
                $('#prodCostNow').hide();
                $('#prodCostNew').show();
                
                $('#prodRRPNow').hide();
                $('#prodRRPNew').show();
                
                $('#prodWeightNow').hide();
                $('#prodWeightNew').show();
                
                $('#editBtn').hide();
                $('#updateBtn').show();
            }
            function initialiseUpdate(){
                $('#editBtn').show();
                $('#updateBtn').hide();
                
                $('#prodDescNow').show();
                $('#prodDescNew').hide();
                
                $('#prodCodeNow').show();
                $('#prodCodeNew').hide();
                
                $('#prodEANNow').show();
                $('#prodEANNew').hide();
                
                $('#prodCostNow').show();
                $('#prodCostNew').hide();
                
                $('#prodRRPNow').show();
                $('#prodRRPNew').hide();
                
                $('#prodWeightNow').show();
                $('#prodWeightNew').hide();
                
                var getProductID = $('#ProductID').val();
                var getProductCode = $('#prodCodeNew').val();
                var getProductDescShort = $('#ProductDescShort').val();
                var getProductDescLong = $('#prodDescNew').val();
                var getProductEAN = $('#prodEANNew').val();
                var getCost = $('#prodCostNew').val();
                var getRRP = $('#prodRRPNew').val();
                var getWeight = $('#prodWeightNew').val();
                alert(getProductID);
                $.ajax({
                    url: 'ProductAjax.php',
                    cache: false,

                    type: 'POST',
                    data: {
                        'request': 'updateProduct',
                        'ProductID': getProductID,
                        'ProductCode': getProductCode,
                        'ProductDescShort': getProductDescShort,
                        'ProductDescLong': getProductDescLong,
                        'ProductEAN': getProductEAN,
                        'Cost': getCost,
                        'RRP': getRRP,
                        'Weight': getWeight,

                    },
                    dataType: 'json',
                    success: function (data)
                    { //reloads page once the data has successfully been edited
                        //document.location.reload();
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }

                });
            }
        </script>
            
    </head>
    <body>
<?php
include_once 'header.php';
if ($errFlag == 1) {
    echo $errMsg;
} else {
    ?>
            <div id="productName">
                <h2><?php echo $ProductDescShort ?></h2>
            </div>
            <div id="contentBody">
                <div id="productImg">
                    <img src='<?php echo $prodImg; ?>'
                </div> </div>
                <div id="productDesc">
                    <h3>Product Info:</h3> <input type='button' id="editBtn" value='Edit' onclick='initialiseEdit()'> <input type='button' id="updateBtn" value='Update' onclick='initialiseUpdate()'>
            <?php echo "<hr><div id='prodDescNow'>" . htmlspecialchars_decode($ProductDescLong) . "</div><div id='prodDescNew'><input size='100' type='text' id='prodDesc' value='" . htmlspecialchars_decode($ProductDescLong) . "'></div>" . 
                    "<hr> Product EAN: " . "<div id='prodEANNow'>" . $ProductEAN . "</div><div id='prodEANNew'><input size='100' type='text' id='prodEAN' value='" . $ProductEAN . "'></div>" .
                    "<hr> Product Code: " .  "<div id='prodCodeNow'>" .  $ProductCode . "</div><div id='prodCodeNew'><input size='100' type='text' id='prodCode' value='" . $ProductCode . "'></div>" .
                    "<hr> Cost To Produce: " . "<div id='prodCostNow'>" . $Cost . "</div><div id='prodCostNew'><input size='100' type='text' id='prodCost' value='" . $Cost . "'></div>" .
                    "<hr> Recommended Retail Price: " . "<div id='prodRRPNow'>" . $RRP . "</div><div id='prodRRPNew'><input size='100' type='text' id='prodRRP' value='" . $RRP . "'></div>" .
                    "<hr> Weight: " . "<div id='prodWeightNow'>" . $Weight . "</div><div id='prodWeightNew'><input size='100' type='text' id='prodWeight' value='" . $Weight . "'></div>" . "<hr>" ?>

                </div>
            </div>



<?php } 

?>


    </body>
</html>
