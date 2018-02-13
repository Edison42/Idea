<!DOCTYPE>

<?php
include("functions/functions.php");
?>

<html>
<head>
    <title>My Online Shop</title>
    <link href="styles/style.css" type="text/css" rel="stylesheet" media="all">
    <!--    <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">-->
    <!--    <link href="bootstrap/js/bootstrap.js" type="text/css" rel="stylesheet" media="all">-->
</head>

<body background="images/bg-pattern.jpg">

<div class="main_wrapper">
    <div class="header_wrapper">
        <img id="logo" src="images/logo.png" alt="SHOPLOGO">
        <img id="banner" src="images" alt="SHOPBANNER">
    </div>

    <div class="menubar">

        <ul id="menu">
            <li><a href="#">Home</a> </li>
            <li><a href="#">All products</a> </li>
            <li><a href="#">My Account</a> </li>
            <li><a href="#">Sign Up</a> </li>
            <li><a href="#">Shopping Cart</a> </li>
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
        <span style="float: right; font-size: 18px; padding: 5px; line-height: 40px">
            Welcome Guest! <b style="color: yellow">Shopping Cart -</b>Total Items: Total Price: <a href="cart.php" style="color: yellow;">Go to
                Cart</a>
        </span>
            </div>
            <div id="products_box">

                <?php
                if(isset($_GET['pro_id'])){

                $product_id=$_GET['pro_id'];

                $get_pro = "select * from products WHERE product_id='$product_id'";

                $run_pro = mysqli_query($con, $get_pro);

                while ($row_pro = mysqli_fetch_array($run_pro)) {

                $pro_id = $row_pro['product_id'];
                $pro_title = $row_pro['product_title'];
                $pro_price = $row_pro['product_price'];
                $pro_image = $row_pro['product_image'];
                $pro_desc=$row_pro['product_desc'];

                echo "
                <div id='single_product'>

                    <h3>$pro_title</h3>

                    <img src='admin_area/images/$pro_image'  width='400'  height='300' />

                    <p><b>Ushs. $pro_price /=</b></p>

                    <a href='index.php' style='float: left;'>Go back</a>
                    <a href='index.php?add_cart=$pro_id'><button style='float: right;'>Add to Cart</button> </a>
                    <p><b>$pro_desc</b></p>
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