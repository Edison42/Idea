<div>
    <?php

    include('includes/db.php');

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

            $product_name = $pp_price['product_title'];

            $values=array_sum($product_price);

            $total+=$values;

        }
    }

    global $pro_id;

    $get_qty = "select * from cart WHERE p_id='$pro_id'";

    $run_qty = mysqli_query($con,$get_qty);

    $row_qty = mysqli_fetch_array($run_qty);

    $qty = $row_qty['qty'];

    if($qty = 0){
        $qty = 1;
    }else{
        $qty = $qty;
    }

    ?>
<h2 align="center">Pay Now With Pay Pal.</h2>
  <p style="text-align: center; padding: 5%">

    <form target="PayPal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

<!--        Identify your business so that you can collect your payments. -->
        <input type="hidden" name="business" value="bussinesstest@shop.com">

<!--        Specify the Buy Now Button. -->
        <input type="hidden" name="cmd" value="_xclick">

<!--        Specify the details about the items that the Buyers will Purchase. -->
        <input type="hidden" name="item_name" value="<?php global $product_name; echo $product_name; ?>">
        <input type="hidden" name="item_number" value="<?php global $product_id; echo $product_id; ?>">
        <input type="hidden" name="amount" value="<?php global $total; echo $total; ?>">
        <input type="hidden" name="currency_code" value="USD">

<!--        Redirecting the User. -->
        <input type="hidden" name="return" value="http://www.hosting-website.com/ecommerce/paypal_success.php">
        <input type="hidden" name="cancel_return" value="http://www.hosting-website.com/ecommerce/paypal_cancel.php">

        <input type="hidden" name="shipping" value="">
        <input type="hidden" name="shipping2" value="">
        <input type="hidden" name="handling" value="">

        <input type="hidden" name="undefined_quantity" value="0">
        <input type="hidden" name="receiver_email" value="">
        <input type="hidden" name="no_shipping" value="0">
        <input type="hidden" name="no_note" value="1">

<!--        Display The Payment Button. -->
        <input type="image" name="submit" src="" style="border: 0;" alt="Make payments with PayPal the easier way to pay on line, it's fast, free, and secure!">
        <img src="" border="0" height="1" width="1" alt="">
    </form>

  </p>  
</div>