<?php
$customerID = $_POST['customerID'];
$dueDate = $_POST['dueDate'];
$customerEmail = $_POST['customerEmail'];
$customerTele = $_POST['custTeleNum'];
$currency = $_POST['currency'];
$orderID = $_POST['orderID'];
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
            var productIDG = "";
            var prodCost = "";

            $(document).ready(function () {
                $('#orderCompleteDlg').dialog({
                    resizable: false,
                    height: "auto",
                    width: 500,
                    modal: true,
                    autoOpen: false,
                    draggable: false,
                    closeOnEscape: false,
                    open: function (event, ui) {
                        $(".ui-dialog-titlebar-close").hide();
                    }
                })
            });
            addOther();

            function searchUpdate() {
                var productSearch = $('#productSearch').val();
                var len = productSearch.length;
                var outputData = "";
                if (len < 3) { //if the length of the word being typed into the product search is less than 3 characters, dont do anything
                    $('#searchResults').html("");
                    return;
                }
                $.ajax({//if the length of the word being typed is more than 3 it will call the ajax and give the user a table of suggested products based on what they are typing
                    url: 'orderAjax.php',
                    cache: false,

                    type: 'POST',
                    data: {
                        'request': 'prodSearchUpdate',
                        'productSearch': productSearch
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        outputData = outputData + "<table>";
                        for (i = 0; i < data.prodResults.length; i++) { //creates a table with the suggested products
                            outputData = outputData + "<tr> <td onclick='completeCustomer(\"" + data.prodResults[i].ProductDescLong + "\" , \"" + data.prodResults[i].ProductID + "\")' >" + data.prodResults[i].ProductDescLong + "</td> </tr>";


                        }
                        outputData = outputData + "</table>";
                        $('#searchResults').html(outputData);
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }

                });
            }
            function completeCustomer(productName, productID) { //when the user clicks a name in the suggested products it will auto fill the input box
                $('#productSearch').val(productName);
                $('#searchResults').html("");
                var productID = productID;
                productIDG = productID;
                $.ajax({//call an ajax to update the cost of the product in the total cost field
                    url: 'orderAjax.php',
                    cache: false,

                    type: 'POST',
                    data: {
                        'request': 'productCost',
                        'productID': productIDG
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        var cost = data.costResults;
                        prodCost = cost;
                        $('#productCost').val(cost);
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }

                });
            }
            function updateCost() {
                var quantity = document.getElementById('quantity').value;
                var cost = prodCost;
                var crateCost = (cost * 24)
                var totalCost = (quantity * crateCost);
                $('#productCost').val(totalCost);

            }
            function customerOrder() {
                var quantity = $('#quantity').val();
                var totalCost = $('#productCost').val();

                $.ajax({//
                    url: 'orderAjax.php',
                    cache: false,
                    type: 'POST',
                    data: {
                        'request': 'addOrder',
                        'productID': productIDG,
                        'quantity': quantity,
                        'totalCost': totalCost,
                        'orderID': '<? echo $orderID ?>',
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        $('#orderCompleteDlg').dialog('open');

                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }

                });
            }
            function addOther() {
                var orderData = "";
                $.ajax({//
                    url: 'orderAjax.php',
                    cache: false,
                    type: 'POST',
                    data: {
                        'request': 'drawTable',
                        'orderID': '<? echo $orderID ?>',
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        orderData = orderData + "<table>";
                        for (i = 0; i < data.orderResults.length; i++) { //creates a table with the suggested products
                            orderData = orderData + "<tr> <td class='tableData'>" + data.orderResults[i].OrderID + "</td> <td class='tableData'>" + data.orderResults[i].CustomerID + "</td> <td class='tableData'>" + data.orderResults[i].email + "</td> <td class='tableData'>" + data.orderResults[i].dueDate + "</td> <td class='tableData'>" + data.orderResults[i].telNo + "</td> <td class='tableData'>" + data.orderResults[i].currency + "</td> <td class='tableData'>" + data.orderResults[i].quantity + "</td> <td class='tableData'>" + data.orderResults[i].ProductID + "</td> <td class='tableData'>" + data.orderResults[i].price + "</td> </tr>";


                        }
                        orderData = orderData + "</table>";
                        $('#productTable').html(orderData);
                        $('#orderCompleteDlg').dialog('close');
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                        $('#orderCompleteDlg').dialog('close');
                    }

                });
            }

        </script>
        <style>
            #mainContentHolder{
                background-color: lightgray;
                text-align: center;
            }
            .form-control{
                text-align: center;
                font-size: 1.4em !important;
                height: 30px !important;
                width: 600px !important;
                display: inline-block;
            }
            .form-group{
                padding: 10px;
            }
            #dueDate{
                text-align: center;
                width: 260px;
                font-size: 1.5em;
                background-color: lightsteelblue;
                border-radius: 20px;
            }
            .inputLabels{
                font-size: 1.2em;
            }
            #currencySel{
                font-size: 1.3em !important;
                width: 200px !important;
                height: 100px !important;
            }
            #searchResults{
                position: relative;
                display: inline-block;
            }
            .tableData{
                padding: 10px;
            }
        </style>
    </head>

    <? include_once 'header.php' ?>
    <body>

        <div id="mainContentHolder">
            <form method="POST" >
                <div><h2>Your Order ID is: <? echo $orderID ?></h2> </div>
                <div class="form-group">
                    <label class="inputLabels" for="productSearch">Product</label> <br>
                    <input type="text" autocomplete="off" onkeyup="searchUpdate()" class="form-control" id="productSearch" placeholder="Search For Product">
                </div>
                <div id="searchResults">

                </div> <br>
                <label class="inputLabels" for="quantity">Quantity (Crates of 24 Cans)</label><br>
                <input onchange="updateCost()" autocomplete="off" type="number" class="form-control" id="quantity">
                <div class="form-group">
                    <label class="inputLabels" for="productCost">Total Cost</label> <br>
                    <input type="number" disabled="yes" class="form-control" id="productCost" placeholder="Total Price">
                </div>
                <button type="button" onclick="customerOrder()" class="btn btn-primary">Add Product</button>
            </form>
            <div id="productTable">

            </div>
            <div id="orderCompleteDlg">
                <h2>Product has been submitted </h2>
                <button type="button" onclick="addOther()">Add Another Product</button>
            </div>
        </div>



    </body>
</html>
