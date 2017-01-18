<!DOCTYPE html>


<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jquery/jquery.min.js"></script>
        <script src="jquery/jquery-ui.min.js"></script>
        <script src="jquery/bootstrap.min.js"></script>
        <link rel='stylesheet' type='text/css' href='css/jquery-ui.min.css'>
        <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
        <link href="css/mdb.min.css" rel="stylesheet" type="text/css"/>
        <link href="styleSheet.css" rel="stylesheet" type="text/css"/>
        <script>
            $(function ready() {
                $("#dueDate").datepicker();
            });
            function searchUpdate() {
                var customerSearch = $('#customerSearch').val();
                var len = customerSearch.length;
                var outputData = "";
                if (len < 3) {
                    $('#searchResults').html("");
                    return;
                }
                $.ajax({
                    url: 'orderAjax.php',
                    cache: false,

                    type: 'POST',
                    data: {
                        'request': 'searchUpdate',
                        'customerSearch': customerSearch
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        //alert(data.dataResults[0].CustomerName);
                        outputData = outputData + "<table>";
                        for (i = 0; i < data.dataResults.length; i++) {
                            outputData = outputData + "<tr> <td onclick='completeCustomer(\"" + data.dataResults[i].CustomerName + "\" , \"" + data.dataResults[i].CustomerID + "\")' >" + data.dataResults[i].CustomerName + "</td> </tr>";
                        }
                        outputData = outputData + "</table>";
                        $('#searchResults').html(outputData);
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }

                });
            }
            var customerIDG = '';
            function completeCustomer(customerName, customerID) {
                $('#customerSearch').val(customerName);
                $('#searchResults').html("");
                var customerID = customerID;
                customerIDG = customerID;
                //alert(customerIDG)
            }
            var orderID = 0;
            function newOrder() {
                var customerID = customerIDG;
                var dueDate = $('#dueDate').val();
                var customerEmail = $('#inputEmail').val();
                var custTeleNum = $('#telephoneInput').val();
                var currency = $('#currency').val();
                if (dueDate == "" || customerEmail == "" || custTeleNum == "" || currency == "" || customerID == "")
                {
                    alert('Please fill in all fields');
                    return;
                }
                
                $.ajax({
                    url: 'orderAjax.php',
                    cache: false,
                    type: 'POST',
                    data: {
                        'request': 'newOrder',
                        'customerID': customerID,
                        'dueDate': dueDate,
                        'customerEmail': customerEmail,
                        'custTeleNum': custTeleNum,
                        'currency': currency
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        orderID = data.OrderID;
                        $('#orderID').val(orderID);
                        document.forms['frmCustomer'].submit();
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
        </style>
    </head>
    <body>
        <?php include_once 'header.php' ?>

        <div id="mainContentHolder">
            <form name="frmCustomer" action="customerOrder.php" method="POST" >
                <div class="form-group">
                    <label class="inputLabels" for="customerSearch">Customer</label> <br>
                    <input type="text" autocomplete="off" onkeyup="searchUpdate()" class="form-control" name="customerSearch" id="customerSearch" placeholder="Search For Customer">
                </div>
                <div id="searchResults">

                </div> <br>
                <label class="inputLabels" for="dueDate">Due Date</label><br>
                <input autocomplete="off" type="text" name="dueDate" id="dueDate" size="30">
                <div class="form-group">
                    <label class="inputLabels" for="inputEmail">Email address</label> <br>
                    <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label class="inputLabels" for="telephoneInput">Telephone Number</label> <br>
                    <input type="text" class="form-control" name="telephoneInput" id="telephoneInput" placeholder="Enter Telephone Number">
                </div>
                <div class="form-group">
                    <label class="inputLabels" for="currency">Currency</label> <br>
                    <select class="form-control" name="currency" id="currency" style="height: 50px !important;">
                        <option>GBP</option>
                        <option>EUR</option>
                        <option>USD</option>
                        <option>AUD</option>
                    </select>
                </div>
                <input type="hidden" id="orderID" name="orderID">


                <input type="button" onclick="newOrder()" value="Continue" class="btn btn-primary">
            </form>
        </div>

    </body>
</html>
