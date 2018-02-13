<?php
session_start();
?>
<?php

    include('includes/db.php');
    include('functions/functions.php');

    //this is all for the products
    $total=0;

    global $con;

    $ip = getIp();

    $sel_price="select * from cart where ip_add='$ip'";
    $run_price=mysqli_query($con,$sel_price);

    while($p_price=mysqli_fetch_array($run_price)){

    $pro_id=$p_price['p_id'];

    $pro_price="select * from products WHERE  product_id='$pro_id'";

    $run_pro_price=mysqli_query($con,$pro_price);

    while($pp_price=mysqli_fetch_array($run_pro_price)){

        $product_price=array($pp_price['product_price']);
        $product_id = $pp_price['product_id'];
        $values=array_sum($product_price);

        $total+=$values;

    }
}
    //echo "Ushs . ".$total." /=";

    //getting quantity of the products
    $get_qty = "select * from cart WHERE p_id='$pro_id'";
    $run_qty = mysqli_query($con,$get_qty);
    $row_qty = mysqli_fetch_array($run_qty);
    $qty = $row_qty['qty'];

    if($qty = 0){
    $qty = 1;
    }else{
    $qty = $qty;
    $total=$total*$qty;
    }

    //this is all for the customers

    $user = $_SESSION['customer_email'];
    $get_c = "select * customers where customer_email='$user'";
    $run_c = mysqli_query($con,$get_c);
    $row_c = mysqli_fetch_array($run_c);
    $c_id = $row_c['customer_id'];

    //payment details from paypal

    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $trx_id = $_GET['tx'];

    // a function in php that generates random numbers
    $Invoice_no = mt_rand();

    $insert_payment = "insert into payments (amount,customer_id,product_id,trx_id,currency,payment_date) VALUES ('$amount','$c_id','$pro_id','$trx_id','$currency',NOW ())";
    $run_payment = mysqli_query($con,$insert_payment);

    $insert_order = "insert into orders (p_id,c_id,qty,Invoice_no,order_date,status) values ('$pro_id','$c_id','$qty','$Invoice_no',NOW (),'in Progress...')";
    $run_order = mysqli_query($con,$insert_order);

    $empty_cart = "delete from cart";
    $run_empty_cart = mysqli_query($con,$empty_cart);

    if($amount==$total){

        echo "<h2>Welcome : ".$_SESSION['customer_email']."<br />"." Your Payment Was Successfull.</h2>";
        echo "<a href='customer/my_account.php'>Go to Your Account</a>";

    }else{
        echo "<h2>Welcome Guest , Your Payment Was Failed Due To Some Few Reasons.</h2>";
        echo "<a href='index.php'>Go back to Shop</a>";
    }
?>

<!DOCTYPE html>
    <html>
<head>
    <title>Payment Successful!</title>
</head>
<body background="images/bg-pattern.jpg">
<center>
    <h2>Welcome : <i style="color: #fffccc; "><?php echo $_SESSION['customer_email']; ?></i></h2>
    <h3>Your Payment Was Successful, Please Go to your Account</h3>
    <h3><a href="customer/my_account.php">Go to Your Account</a></h3>
<!--    <h3><a href="https://www.edisonwabwire.com/ecommerce/customer/my_account.php />">Go to Your Account</a></h3>-->
</center>
</body>
</html>