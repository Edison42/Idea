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
            <li><a href="customer_register.php">Sign Up</a> </li>
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
        <span style="float: right; font-size: 14px; padding: 5px; line-height: 40px">
            <?php
            if(isset($_SESSION['customer_email'])){
                echo "<b>Welcome : </b>" ."<i style='color: #fffccc'>". $_SESSION['customer_email']."</i>"."<b
                style='color:yellow'> Your</b>";
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

                <form method="post" action="customer_register.php" enctype="multipart/form-data">

                    <table width="750" align="center">
                    <tr align="center">
                        <td colspan="2"><h2>Create An Account.</h2></td>
                    </tr>
                    <tr>
                        <td align="right">Customer Name:</td>
                        <td><input type="text" name="c_name" required/></td>
                    </tr>
                    <tr>
                        <td align="right">Customer Email:</td>
                        <td><input type="text" name="c_email" required/></td>
                    </tr>
                    <tr>
                        <td align="right">Customer Password:</td>
                        <td><input type="password" name="c_pass" required/></td>
                    </tr>
                    <tr>
                        <td align="right">Customer Image:</td>
                        <td><input type="file" name="c_image" required/></td>
                    </tr>
                    <tr>
                        <td align="right">Customer Country:</td>
                        <td>
                            <select name="c_country">
                                <option>Select a Country</option>
                                <option>Uganda</option>
                                <option>Kenya</option>
                                <option>Tanzania</option>
                                <option>Malawi</option>
                                <option>Rwanda</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">Customer City:</td>
                        <td><input type="text" name="c_city" required/></td>
                    </tr>
                    <tr>
                        <td align="right">Customer Contact:</td>
                        <td><input type="text" name="c_contact" required/></td>
                    </tr>
                    <tr>
                        <td align="right">Customer Address:</td>
                        <td>
                            <input type="text" name="c_address" required/>
                        </td>
                    </tr>
                    <tr align="center">
                       <td colspan="2">
                           <input name="register" type="submit" value="Create An Account Now." />
                       </td>
                    </tr>
                    </table>
                </form>

            </div>
        </div>

    </div>

    <div id="footer">
        <h3 style="text-align: center; padding-top: 30px; color: white; font-family: 'comic sans ms'; ">&copy; 2017 by Edison Wabwire (Final Year Project Portfolio) Bsc. Computer Science 2018/2019</h3>
    </div>
</div>
</body>
</html>

<?php
if(isset($_POST['register'])) {
    
    //establishing a connection to the database
    $con = mysqli_connect("localhost","root","","ecommerce");
    if(mysqli_connect_errno()){
        echo "Failed to connect to MySQL:".mysqli_connect_error();
    }

    $ip = getIp();
    $c_name = $_POST['c_name'];
    $c_email = $_POST['c_email'];
    $c_pass = $_POST['c_pass'];
    $c_image = $_FILES['c_image']['name'];
    $c_image_tmp = $_FILES['c_image']['tmp_name'];
    $c_country = $_POST['c_country'];
    $c_city = $_POST['c_city'];
    $c_contact = $_POST['c_contact'];
    $c_address = $_POST['c_address'];

    move_uploaded_file($c_image_tmp, "customer/customer_images/$c_image");

    $insert_c = "insert into customers (customer_ip,customer_name,customer_email,customer_pass,customer_country,customer_city,customer_contact,customer_address,customer_image) VALUES ('$ip','$c_name','$c_email','$c_pass','$c_country','$c_city','$c_contact','$c_address','$c_image')";

    $run_c = mysqli_query($con, $insert_c);


    $sel_cart = "select * from cart where ip_add='$ip'";

    $run_cart = mysqli_query($con, $sel_cart);

    $check_cart = mysqli_num_rows($run_cart);


    if ($check_cart == 0) {

        $_SESSION['customer_email'] = $c_email;
        echo "<script>alert('Account Has Been Created Successfully, Thanks!')</script>";
        echo "<script>window.open('customer/my_account.php','_self')</script>";
    } else {

        $_SESSION['customer_email'] = $c_email;
        echo "<script>alert('Account Has Been Created Successfully, Thanks!')</script>";
        echo "<script>window.open('checkout.php','_self')</script>";
    }

}

?>







