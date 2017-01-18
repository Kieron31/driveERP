<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?
$sqlconn = null;
include_once 'config.php';
$sqlconn = connectToDatabase();

if ($sqlconn != null) {
    try {
        $sqlQuery = "SELECT * FROM Products WHERE ProductCat = 'FP' ";
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
?>

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jquery/jquery.min.js"></script>
        <script src="jquery/jquery-ui.min.js"></script>

        <script src="jquery/bootstrap.min.js"></script>
        <script src="jquery/bootstrapglyph.min.js"></script>
        <link rel='stylesheet' type='text/css' href='css/jquery-ui.min.css'>

        <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='css/bootstrapglyph.min.css'>
        <link href="css/mdb.min.css" rel="stylesheet" type="text/css"/>
        <link href="styleSheet.css" rel="stylesheet" type="text/css"/>




        <script>
            $(document).ready(function () {
                $('#editDialog').dialog({//Dialog to edit data
                    resizable: false,
                    height: "auto",
                    width: 500,
                    modal: true,
                    autoOpen: false,
                    draggable: false,
                });

            });
            function ProductEdit(ProductID) {
                $('#editDialog').dialog('open'); //opens edit data dialog

                $.ajax({
                    url: 'ProductAjax.php',
                    cache: false,

                    type: 'POST',
                    data: {
                        'request': 'getProduct',
                        'ProductID': ProductID
                    },
                    dataType: 'json',
                    success: function (data)
                    { //gets variables when opening edit data
                        $('#ProductID').val(ProductID);
                        $('#ProductCode').val(data.ProductCode);
                        $('#ProductDescShort').val(data.ProductDescShort);
                        $('#ProductDescLong').val(data.ProductDescLong);
                        $('#ProductEAN').val(data.ProductEAN);
                        $('#Cost').val(data.Cost);
                        $('#RRP').val(data.RRP);
                        $('#ProductCat').val(data.ProductCat);
                        $('#Weight').val(data.Weight);
                        $('#prodImg').val(data.prodImg);
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }

                });
            }
            function updateProduct() {
                var getProductID = $('#ProductID').val();
                var getProductCode = $('#ProductCode').val();
                var getProductDescShort = $('#ProductDescShort').val();
                var getProductDescLong = $('#ProductDescLong').val();
                var getProductEAN = $('#ProductEAN').val();
                var getProductCat = $('#ProductCat').val();
                var getCost = $('#Cost').val();
                var getRRP = $('#RRP').val();
                var getWeight = $('#Weight').val();
                var prodImg = $('#prodImg').val();
                //alert(studentID)
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
                        'ProductCat': getProductCat,
                        'Cost': getCost,
                        'RRP': getRRP,
                        'Weight': getWeight,
                        'prodImg': prodImg

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
            function viewProduct(prodID) {
                $('#ProductID').val(prodID);
                document.forms['frmViewProduct'].submit();
                
                
                
            }
        </script>
    </head>
    <body>
        <?
        include_once 'header.php';
        ?>

        <div id="mainContent">
            <div id='DataTable'>
                <table style="width: 100%">
                    <tr class='tableHeader'>
                        <td class="tableHeading"> Product Desc </td> 
                        <td class="tableHeading"> EAN </td> 
                        <td class="tableHeading">Cost to Make </td>
                        <td class="tableHeading">RRP </td>
                        <td class="tableHeading">Edit </td>
                        <td class="tableHeading">View </td>
                    </tr>

                    <?php
                    foreach ($rs as $dataSet) {
                        echo " <tr> <td class='tableText'> " .
                        $dataSet['ProductDescShort'] . " </td> <td class='tableText'>" . $dataSet['ProductEAN'] . " </td> <td class='tableText'>" . $dataSet['Cost'] .
                        " </td> <td class='tableText'>" . $dataSet['RRP'] . "</td>" . "<td class='tableText'> " .
                        "<a onclick='ProductEdit(" . $dataSet['ProductID'] . ")''>Edit</a>" . "</td>" . "<td class='tableText'> <a  onclick='viewProduct(" . $dataSet['ProductID'] . ")''>View</a>" . "</td> </tr>";
                    }
                    ?>
                </table>
            </div>

            <button class='navBtn' type="button" onclick="location.href = 'addProduct.php'">Add Product</button>

            <div id="homeAbout">
                <h2>A little bit about us!</h2>
                <p> Rockstar Energy Drink is designed for those who lead active lifestyles, from Athletes to Rockstars. Rockstar supports the Rockstar lifestyle across the globe through Action Sports, Motor Sports, and Live Music.   </p>
            </div>

            <div>
                <iframe width="1280" height="720" src="https://www.youtube.com/embed/x5zQ5dr1qR4?autoplay=0&loop=1&playlist=woiCtY8_46g,Z_1BDRltko8,_WEZ7TvWrWM,zuHO86wkt0s" frameborder="0" allowfullscreen></iframe>

            </div>
            <div id='editDialog'>
                <input type="hidden" id='ProductID'>
                Product Code <input type="number" id='ProductCode' name="ProductCode"> <br>
                Product Desc Short <input type="text" id='ProductDescShort' name="ProductDescShort"> <br>
                Product Desc Long <input type="text" id='ProductDescLong' name="ProductDescLong"> <br>
                Product EAN <input type="number" id='ProductEAN' name="ProductEAN"> <br>
                Cost <input type="number" id='Cost' name="Cost"> <br>
                RRP <input type="number" id='RRP' name="RRP"> <br>
                Product Cat <select id='ProductCat' name="ProductCat"> <option value="FP">Finished Product</option> <option value="RM">Raw Material</option></select> <br>
                Weight <input type="number" id='Weight' name="Weight"> <br>
                Image <input type="file" id='prodImg' name="prodImg"> <br>
                <button onclick="updateProduct()" type="button">Update</button>

            </div>
        </div>
        <form action="productOriginal.php" method="POST" name="frmViewProduct">
            <input id="ProductID" name="ProductID" type="hidden">
            
            
        </form>
        <?
        include_once 'footer.php';
        ?>
    </body>
</html>
