<?php
$sqlconn = null;
include_once 'config.php';
$sqlconn = connectToDatabase();

?>
<!DOCTYPE html>
<html>
    <head>
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
        <script src="js/tinymce.min.js"></script>

        <style>
            .inputBoxB{
                position: relative;
                text-align: center;
            }
            .navBtn {
                background: #858585;
                background-image: -webkit-linear-gradient(top, #858585, #333333);
                background-image: -moz-linear-gradient(top, #858585, #333333);
                background-image: -ms-linear-gradient(top, #858585, #333333);
                background-image: -o-linear-gradient(top, #858585, #333333);
                background-image: linear-gradient(to bottom, #858585, #333333);
                -webkit-border-radius: 9;
                -moz-border-radius: 9;
                border-radius: 9px;
                font-family: Georgia;
                color: #ffffff;
                font-size: 29px;
                padding: 10px 20px 10px 20px;
                text-decoration: none;
                position: relative;

            }

            .navBtn:hover {
                background: #4d4d4d;
                background-image: -webkit-linear-gradient(top, #4d4d4d, #9e9e9e);
                background-image: -moz-linear-gradient(top, #4d4d4d, #9e9e9e);
                background-image: -ms-linear-gradient(top, #4d4d4d, #9e9e9e);
                background-image: -o-linear-gradient(top, #4d4d4d, #9e9e9e);
                background-image: linear-gradient(to bottom, #4d4d4d, #9e9e9e);
                text-decoration: none;
            }
        </style>
        <script>
            function addProduct() {
                var ProductCode = $('#ProductCode').val();
                var ProductDescShort = $('#ProductDescShort').val();
                var ProductDescLong = tinyMCE.get('ProductDescLong').getContent();
                //alert(ProductDescLong);
                var ProductEAN = $('#ProductEAN').val();
                var ProductCat = $('#ProductCat').val();
                var Cost = $('#Cost').val();
                var RRP = $('#RRP').val();
                var Weight = $('#Weight').val();
                $.ajax({
                    url: 'ProductAjax.php',
                    cache: false,
                    type: 'POST',
                    data: {
                        'request': 'addProduct',
                        'ProductCode': ProductCode,
                        'ProductDescShort': ProductDescShort,
                        'ProductDescLong': ProductDescLong,
                        'ProductEAN': ProductEAN,
                        'ProductCat': ProductCat,
                        'Cost': Cost,
                        'RRP': RRP,
                        'Weight': Weight
                    },
                    dataType: 'json',
                    success: function (data)
                    { //reloads page once the data has successfully been edited
                        //document.location.reload();
                        $('#imgProductID').val(data.prodID);
                        alert('Product Added');
                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }

                });
            }
            tinymce.init({
               selector: '#ProductDescLong'
            });
        </script>

    </head>
    <body>
        <?
        include_once 'header.php';
        ?>

        <div id="mainContent">

            <form name="frmAdd" > 


                <div id='QuestionBoxes'>
                    <!-- input boxes and buttons -->
                    <div class="inputBoxB">
                        <label style="font-size: 1.5em;">Product Code</label><br><input style="height: 50px;width: 50%;font-size: 1.5em;text-align: center;" name="ProductCode" id='ProductCode' class='inputBox' type='number' size='20' min='1000' max="9999">
                    </div>
                    <div class="inputBoxB">
                        <label style="font-size: 1.5em;">Product Desc Short</label><br><input style="height: 50px;width: 50%;font-size: 1.5em;text-align: center;" name="ProductDescShort" id='ProductDescShort' class='inputBox' type='text' size='50'>
                    </div>
                    <div class="inputBoxB">
                        <label style="font-size: 1.5em;">Product Desc Long</label>
                        <br><textarea style="height: 100px;" name="ProductDescLong" id='ProductDescLong' class='form-control' type='text' size='100'> </textarea>
                    </div>
                    <div class="inputBoxB">
                        <label style="font-size: 1.5em;">Product EAN (Bar Code)</label><br><input style="height: 50px;width: 50%;font-size: 1.5em; text-align: center;" name="ProductEAN" id='ProductEAN' class='inputBox' type='number' size='50' min='1000000000000' max='9999999999999'>
                    </div>
                    <div class="form-group inputBoxB">
                        <label style="font-size: 1.5em;">Product Category </label><br>
                        <select name="ProductCat" id='ProductCat'  placeholder='Product Category' >
                            <option value="RM">Raw Material</option>
                            <option value="FP">Finished Product</option>
                        </select>
                    </div>
                    <div class="inputBoxB">
                        <label style="font-size: 1.5em;">Cost To Make</label><br><input style="height: 50px;width: 50%;font-size: 1.5em; text-align: center;" name="Cost" id='Cost' class='inputBox' type='text' size='20'>
                    </div>
                    <div class="inputBoxB">
                        <label style="font-size: 1.5em;">RRP</label><br><input style="height: 50px;width: 50%;font-size: 1.5em; text-align: center;" name="RRP" id='RRP' class='inputBox' type='text' size='20'>
                    </div>
                    <div class="inputBoxB">
                        <label style="font-size: 1.5em;">Weight</label><br><input style="height: 50px;width: 50%;font-size: 1.5em;text-align: center;" name="Weight" id='Weight' class='inputBox' type='text' size='20'>
                    </div>
                    
                    <div style="text-align: center;">
                        <input class='navBtn' type='button' onclick="addProduct()" value="Add Product" style="margin: 15px;" >               
                    </div>
                    <div style="text-align: center;" id='viewButton'>
                        <button class='navBtn' onclick="location.href = 'home.php'" type='button'>Back</button>               

                    </div>
                </div>
            </form>
            <form action='upload.php' method="POST" enctype="multipart/form-data">
                <input type="file" name="productImage">
                <input type="submit" value="submit">
                <input type="hidden" name="ProductID" id='imgProductID'>
            </form>

        </div>
        <?php
        include_once 'footer.php';
        ?>
    </body>
</html>