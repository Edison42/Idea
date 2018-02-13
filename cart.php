<?php
session_start();
include("functions/functions.php");
?>
<!DOCTYPE html>
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

            <?php cart(); ?>

            <div id="shopping_cart">
            <span style="float: right; font-size: 13px; padding: 5px; line-height: 40px">
            <?php
            if(isset($_SESSION['customer_email'])){
                echo "<b>Welcome : </b>" ."<i style='color: #fffccc'>". $_SESSION['customer_email']."</i>"."<b
                style='color:yellow'> Your</b>";
            }else{
                echo "<b>Welcome : Anonymous</b>";
            }
            ?>
            <b style="color: yellow">Shopping Cart -</b>Total Items: <b style="color: #a6e1ec"><?php get_total_items(); ?>
            </b>Total Price: <b style="color: #a6e1ec"><?php total_price(); ?>
            </b> <a href="index.php" style="color: yellow;">Shop Again</a>
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
            <form method="post" action="" enctype="multipart/form-data">

                <table align="center" width="700" bgcolor="#87ceeb">
                    <tr align="center">
                        <th>Remove</th>
                        <th>Product(s)</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <?php

                    $total=0;

                    global $con;

                    $ip=getIp();

                    $sel_price="select * from cart where ip_add='$ip'";
                    $run_price=mysqli_query($con,$sel_price);

                    while($p_price=mysqli_fetch_array($run_price)){

                    $pro_id=$p_price['p_id'];

                    $pro_price="select * from products WHERE  product_id='$pro_id'";

                    $run_pro_price=mysqli_query($con,$pro_price);

                    while($pp_price=mysqli_fetch_array($run_pro_price)){
                    $product_price=array($pp_price['product_price']);
                    $product_title=$pp_price['product_title'];
                    $product_image=$pp_price['product_image'];
                    $single_price=$pp_price['product_price'];

                    $values=array_sum($product_price);

                    $total+=$values;

                    ?>

                        <tr align="center">
                        <td><input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>"/> </td>
                        <td>
                            <?php echo $product_title ?>
                            <br />
                            <img src="admin_area/product_images/<?php echo $product_image; ?>" height="60" width="60" />
                        </td>
                        <td><input type="text" size="3" name="qty"  /></td>

                            <?php
                            if(isset($_POST['update_cart'])){

                                $qty=$_POST['qty'];

                                $update_qty="update cart set qty='$qty'";

                                $run_qty=mysqli_query($con,$update_qty);

//                              $_SESSION['qty']=$qty;

                                $total=$total*$qty;
                            }
                            ?>
                        <td><?php echo "Ushs. ".$single_price."/="; ?></td>
                    </tr>

                    <!-- logic  way of terminating two nested while loops of the same kind............-->

                    <?php
                        }}
                    ?>

                    <tr align="right">
                        <td colspan="5"><b>Sub_total :</b> </td>
                        <td colspan="5"><?php echo "Ushs. ".$total."/="; ?></td>
                    </tr>
                    <tr align="center">
                        <td colspan="2"><input type="submit" name="update_cart" value="Update Cart" /></td>
                        <td><input type="submit" name="continue" value="Continue Shopping"/></td>
                        <td><button><a href="checkout.php" style="text-decoration: none; color:black;">CheckOut</a></button> </td>
                    </tr>
                </table>
            </form>

                <?php
                function updatecart()
                {
                    $ip = getIp();

                    global $con;

                    if (isset($_POST['update_cart'])) {

                        foreach ($_POST['remove'] as $remove_id) {

                            $delete_product = "delete from cart WHERE p_id='$remove_id' AND ip_add='$ip'";

                            $run_delete = mysqli_query($con, $delete_product);

                            if ($run_delete) {
                                echo "<script>window.open('cart.php','_self')</script>";
                            }

                        }
                    }
                    if (isset($_POST['continue'])) {
                        echo "<script>window.open('index.php','_self')</script>";

                    }

                    echo @$up_cart = updatecart();
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