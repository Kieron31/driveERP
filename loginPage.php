<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
        <style>
            .form-control{
                width: 300px;
            }
            .container{
                text-align: center;
                align-content: center;
            }
        </style>
        <script>
            function userLogin() {

                var username = $('#username').val();
                var password = $('#password').val();
                $.ajax({
                    url: 'ajax/ajaxLogin.php',
                    cache: false,
                    type: 'POST',
                    data: {
                        'request': 'homeLogin',
                        'username': username,
                        'password': password,
                    },
                    dataType: 'json',
                    success: function (data)
                    { //gets variables when opening edit data
                        document.location.href = 'home.php';
                        if (data.loginValid == 0)
                        
                        {
                            //invalid
                            $('#invalidAlert').show();
                        } else
                        {
                            //valid
                            
                        }

                    },
                    error: function (data) {
                        alert('error in calling ajax page');
                    }

                });
            }
        </script>



    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 emailForm">
                    <div id='invalidAlert' class="alert alert-danger alert-dismissible" role="alert" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Invalid Username or Password</strong> Please try again
                    </div>
                    <h1> Login </h1>
                    <div style="display: inline-block;">
                        <div class="form-group">
                            <label for="name">Username:</label>
                            <input type="text" id="username" class="form-control" placeholder="Username"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Password:</label>
                            <input type="password" id="password" class="form-control" placeholder="Password"/>
                        </div>

                        <button onclick='userLogin()' class="btn btn-success btn-lg" value="Login">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
