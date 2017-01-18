
    <style>
        #navLogo{
            width: 150px;
            height: 50px;
            float: left;
        }
    </style>


    <!--Navbar-->
    <nav class="navbar navbar-dark bg-primary" style="background: linear-gradient(
         #4f4e4e, 
         rgba(0, 0, 0, 0.45)
         ) !important;">


        <!-- Collapse button-->
        <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx2">
            <i class="fa fa-bars"></i>
        </button>

        <div class="container">

            <!--Collapse content-->
            <div class="collapse navbar-toggleable-xs" id="collapseEx2">
                <!--Navbar Brand-->
                <a href="home.php"> <img id="navLogo" src="uploads/Rockstar_energy_drink_logo.svg.png" alt=""/></a>
                
                <!--Links-->
                <ul class="nav navbar-nav" style="font-size: 1.5em;padding: 10px;">
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="addProduct.php" class="nav-link">New Product</a>
                    </li>
                    <li class="nav-item">
                        <a href="newOrder.php" class="nav-link">New Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="loginPage.php" class="nav-link">Log Out</a>
                    </li>
                </ul>
                <!--Search form-->
                
            </div>
            <!--/.Collapse content-->

        </div>

    </nav>
