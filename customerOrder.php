<?php
$customerID = $_POST['customerID'];
$dueDate = $_POST['dueDate'];
$customerEmail = $_POST['inputEmail'];
$customerTele = $_POST['telephoneInput'];
$currency = $_POST['currency'];
$orderID = $_POST['orderID'];
$customerName = $_POST['customerSearch'];
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
            var orderID = '<? echo $orderID ?>';
            if (orderID == '') {
                alert('Invalid Order ID, Return to new order page');
                document.location.href = 'newOrder.php';
            }
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
            productVName = "";
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
                        $('#costPerCan').val(cost);
                        productVName = data.nameResults;
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }
                });
            }
            function updateCost() {
                var totalValue = 0;
                var quantity = $('#quantity').val();
                var cost = $('#costPerCan').val();
                totalValue = (cost * quantity);
                $('#costForQuantity').val(totalValue);
            }
            function customerOrder() {
                var quantity = $('#quantity').val();
                var totalCost = $('#costPerCan').val();
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
                        var orderValue = 0;
                        orderData = orderData + "<table style='margin: auto;'> <tr> <td class='tableData'> Email </td> <td class='tableData'> Product </td> <td class='tableData'> Quantity </td> <td class='tableData'> Item Cost </td> <td class='tableData'> Total Value </td> </tr>";
                        for (i = 0; i < data.orderResults.length; i++) { //creates a table with the suggested products
                            orderData = orderData + "<tr> <td class='tableData'>" + data.orderResults[i].email + "</td> <td class='tableData'>" + data.orderResults[i].ProductDescShort + "</td> <td class='tableData'>" + data.orderResults[i].quantity + "</td> <td class='tableData'>" + parseFloat(Math.round(data.orderResults[i].price * 100) / 100).toFixed(2)+ "</td> <td class='tableData'>" + parseFloat(Math.round(data.orderResults[i].itemValue * 100) / 100).toFixed(2) + "</td> </tr>";
                            orderValue = orderValue + Number(data.orderResults[i].itemValue);
                        }
                        orderData = orderData + "</table>";
                        $('#productTable').html(orderData);
                        $('#orderCompleteDlg').dialog('close');
                        //alert(orderValue)
                        $('#totalValue').html('Grand Total: ' + parseFloat(Math.round(orderValue * 100) / 100).toFixed(2));
                        $('#productSearch').val('');
                        $('#quantity').val(0);
                        $('#costPerCan').val(0);
                        $('#costForQuantity').val(0);
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                        $('#orderCompleteDlg').dialog('close');
                    }
                });
            }
            var customerName = "";
            function completeOrder(){
                document.forms['createPDF'].submit();
            }
        </script>
        <style>
            #mainContentHolder{
                background-color: lightgray;
                text-align: center;
                width: 70%;
                height: 100%;
                margin: auto;
                padding: 20px;
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
                text-align: center;
            }
            #totalValue{
                text-align: center;
                font-size: 1.3em;
                width: 300px;
                left: 56%;
                position: relative;
            }
            #orderCompleteDlg{
                text-align: center;
            }
            .costs{
                width: 15% !important;
            }
        </style>
    </head>
    <? include_once 'header.php' ?>
    <body>
        <div id="mainContentHolder">
            <form method="POST" action="orderPDF.php" name="createPDF">
                <div><h2>Your Order ID is: <? echo $orderID ?></h2> </div>
                
                <input type="hidden" name="orderID" value="<? echo $orderID ?>" >
                <input type="hidden" name="email" value="<? echo $customerEmail?>" >
                <input type="hidden" name="custName" value="<? echo $customerName?>" >
                <input type="hidden" name="dueDate" value="<? echo $dueDate?>" >
                <input type="hidden" name="custTele" value="<? echo $customerTele?>" >
                
                <div class="form-group">
                    <label class="inputLabels" for="productSearch">Product</label> <br>
                    <input type="text" autocomplete="off" onkeyup="searchUpdate()" class="form-control" id="productSearch" placeholder="Search For Product">
                </div>
                <div id="searchResults">
                </div> <br>
                <label class="inputLabels" for="quantity">Quantity (Single Cans)</label><br>
                <input onchange="updateCost()" autocomplete="off" value="0" type="number" class="form-control" min="0" id="quantity">
                <div class="form-group">
                    <label class="inputLabels" for="costPerCan">Item Cost </label> <label class="inputLabels" for="costForQuantity"> Total Value</label> <br>
                    <input type="number" disabled="yes" placeholder="0" class="form-control costs" id="costPerCan"> <input type="number" disabled="yes" class="form-control costs" id="costForQuantity">
                </div>
                <button type="button" onclick="customerOrder()" class="btn btn-primary">Add Product</button>
                <button type="button" onclick="completeOrder()" class="btn btn-primary">Complete Order</button>
            <h2>Current Order for Store: <? echo $customerName ?> </h2>
            <div name="productTable" id="productTable">
            </div>
            <div id="totalValue">
            </div>
            </form>
            <div id="orderCompleteDlg">
                <h2>Product has been added to order </h2>
                <button type="button" class="btn btn-primary" onclick="addOther()">Add Another Product</button>
            </div>
        </div>
    </body>
</html>
