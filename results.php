<!DOCTYPE>

<?php
session_start();
include("functions/functions.php");
?>

<html>
<head>
    <title>My Online Shop || All Products. </title>
    <link href="styles/style.css" type="text/css" rel="stylesheet" media="all">
    <!--    <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">-->
    <!--    <link href="bootstrap/js/bootstrap.js" type="text/css" rel="stylesheet" media="all">-->
</head>

<body background="images/bg-pattern.jpg">

<div class="main_wrapper">
    <div class="header_wrapper">
        <a href="index.php"><img id="logo" src="images/logo.png" alt="SHOP LOGO"></a>
        <img id="banner" src="images" alt="SHOP BANNER">
    </div>

    <div class="menubar">

        <ul id="menu">
            <li><a href="index.php">Home</a> </li>
            <li><a href="all_products.php">All products</a> </li>
            <li><a href="customer/my_account.php">My Account</a> </li>
            <li><a href="#">Sign Up</a> </li>
            <li><a href="cart.php">Shopping Cart</a> </li>
            <li><a href="#">Contact Us</a> </li>
        </ul>

        <div id="form">
            <form method="get" action="results.php" enctype="multipart/form-data">
                <input type="text" name="user_query" placeholder="Search a product" />
                <input type="submit" name="Search" value="Search"/>
            </form>
        </div>

    </div>

    <div class="content_wrapper">

        <div id="sidebar">

            <div id="sidebar_title">Categories</div>
            <ul id="cats">
                //calling the categories function
                <?php getCats(); ?>
            </ul>
            <div id="sidebar_title">Brands</div>
            <ul id="cats">
                //calling the brands function
                <?php getBrands(); ?>
            </ul>
        </div>

        <div id="content_area">
            <div id="shopping_cart">
                <span style="float: right; font-size: 13px; padding: 5px; line-height: 40px">
            <?php
            if(isset($_SESSION['customer_email'])){
                echo "<b>Welcome : </b>" ."<i style='color: #fffccc'>". $_SESSION['customer_email']."</i>"."<b style='color:yellow'> Your</b>";
            }else{
                echo "<b>Welcome : Anonymous</b>";
            }
            ?>
                    <b style="color: yellow">Shopping Cart -</b>Total Items: <b style="color: #a6e1ec"><?php
                        get_total_items(); ?>
                    </b>Total Price: <b style="color: #a6e1ec"><?php total_price(); ?>
                    </b> <a href="cart.php" style="color: yellow;">Go to Cart</a>
                    <?php

                    if(!isset($_SESSION['customer_email'])){

                        echo "<a href='checkout.php' style='color: red; text-decoration: blink;'>Login</a>";
                    }
                    else{
                        echo "<a href='logout.php' style='color: red;'>LogOut</a>";
                    }
                    ?>
        </span>

            </div>
            <div id="products_box">

                <?php

                if(isset($_GET['Search'])) {

                    global $con;

                    $search_query = $_GET['user_query'];

                    $get_pro = "select * from products WHERE product_keywords LIKE '%$search_query%'";

                    $run_pro = mysqli_query($con, $get_pro);

                    while ($row_pro = mysqli_fetch_array($run_pro)) {

                        $pro_id = $row_pro['product_id'];
                        $pro_cat = $row_pro['product_cat'];
                        $pro_brand = $row_pro['product_brand'];
                        $pro_title = $row_pro['product_title'];
                        $pro_price = $row_pro['product_price'];
                        $pro_image = $row_pro['product_image'];

                        echo "
                    <div id='single_product'>

                    <h3>$pro_title</h3>

                    <img src='admin_area/product_images/$pro_image'  width='180'  height='180' />

                    <p><b>Price : Ushs. $pro_price /=</b></p>

                    <a href='details.php?pro_id=$pro_id' style='float: left;'>Details</a>
                    <a href='index.php?add_cart=$pro_id'><button style='float: right'>Add to Cart</button> </a>

                </div>
                ";

                    }
                }
                ?>
            </div>
        </div>

    </div>

    <div id="footer">

        <h3 style="text-align: center; padding-top: 30px; color: white; font-family: 'comic sans ms'; ">&copy; 2017 by Edison Wabwire (Final Year Project Portifolio) Bsc. Computer Science 2018/2019</h3>

    </div>

</div>

</body>
</html>