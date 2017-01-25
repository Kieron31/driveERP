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
                $('#orderID').val(0);
                
            });
            function getOrder() {
                
                var orderData = "";
                var orderHeaders = "";
                var orderID = $('#orderID').val();
                
                $.ajax({ 
                    url: 'orderAjax.php',
                    cache: false,
                    type: 'POST',
                    data: {
                        'request': 'drawTable',
                        'orderID': orderID
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        var orderValue = 0;
                        orderData = orderData + "<table style='margin: auto;'> <tr> <td class='tableData'> Product </td> <td class='tableData'> Quantity </td> <td class='tableData'> Item Cost </td> <td class='tableData'> Total Value </td> </tr>";
                        for (i = 0; i < data.orderResults.length; i++) { 
                            orderData = orderData + "<tr> <td class='tableData'>" + data.orderResults[i].ProductDescShort + "</td> <td class='tableData'>" + data.orderResults[i].quantity + "</td> <td class='tableData'>" + parseFloat(Math.round(data.orderResults[i].price * 100) / 100).toFixed(2)+ "</td> <td class='tableData'>" + parseFloat(Math.round(data.orderResults[i].itemValue * 100) / 100).toFixed(2) + "</td> </tr>";
                            orderValue = orderValue + Number(data.orderResults[i].itemValue);
                        }
                        orderData = orderData + "</table>";
                        
                        orderHeaders = orderHeaders + "<table style='margin: auto;'> <tr> <td class='tableData'> Email </td> <td class='tableData'> Due Date </td> <td class='tableData'> Telephone </td> <td class='tableData'> Currency </td> </tr>";
                            orderHeaders = orderHeaders + "<tr> <td class='tableData'>" + data.headerResults[0].email + "</td> <td class='tableData'>" + data.headerResults[0].dueDate + " <td class='tableData'>" + data.headerResults[0].telNo + "</td>" + " <td class='tableData'>" + data.headerResults[0].currency + "</td>" + " </td> </tr>";
                            orderHeaders = orderHeaders + "</table>";
                            
                        $('#productTable').html(orderData);
                        $('#headerTable').html(orderHeaders);
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }
                });
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
            #orderID{
                width: 200px;
                text-align: center;
                background-color: graytext;
                border-radius: 10px;
                color: white;
            }
            .inputLabels{
                font-size: 1.2em;
            }
            .tableData{
                padding: 10px;
                text-align: center;
            }
        </style>
    </head>
    <? include_once 'header.php' ?>
    <body>
        <div id="mainContentHolder">
            <label class="inputLabels" for="orderID">Your Order ID</label> <br>
            
            
            <input type="number" name="orderID" id="orderID"  placeholder="Enter Order ID" min="0"> <br>
            <button type="button" class="btn btn-primary" onclick="getOrder()" value="Continue">Continue</button>
            <div name="productTable" id="productTable">
            </div>
            <div name="headerTable" id="headerTable">
                
            </div>
            
        </div>
    </body>
</html>