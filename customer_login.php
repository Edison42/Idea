<?php
include("includes/db.php");
?>

<div>
    <form method="post" action="">
        <table width="650" align="center" bgcolor="#87ceeb">
            <tr align="center">
                <td colspan="3">
                    <h2>Login or Register to Buy!</h2>
                </td>
            </tr>
            <tr>
                <td align="right"><b>Email:</b></b></td>
                <td><input type="text" placeholder="enter email" name="email" required/></td>
            </tr>
            <tr>
                <td align="right"><b>Password:</b></b></td>
                <td><input type="password" name="pass" placeholder="************" required/></td>
            </tr>

            <tr align="center">
                <td colspan="3"><a href="checkout.php?forgot_pass" style="text-decoration: none;" >Forgot Password?</a> </td>
            </tr>
            <tr align="center">
                <td colspan="3"><input type="submit" name="login" value="Login"/></td>
            </tr>
        </table>
        <h2 style="float: right; padding-right: 20px;"><a href="customer_register.php" style="text-decoration: none;
        ">New? Register Here</a> </h2>
    </form>
</div>
<?php
        if(isset($_POST['login'])){
           $c_email=$_POST['email'];
           $c_pass=$_POST['pass'];
           $sel_c="select * from customers WHERE customer_email='$c_email' AND customer_pass='$c_pass'";

           $run_c=mysqli_query($con,$sel_c);
            $check_customer=mysqli_num_rows($run_c);

            if($check_customer==0){
                echo "<script>alert('password or email is incorrect, please try again')</script>";
                exit();
            }

            $ip=getIp();

            $sel_cart="select * from cart where ip_add='$ip'";
            $run_cart = mysqli_query($con,$sel_cart);
            $check_cart=mysqli_num_rows($run_cart);

            if($check_customer>0 and $check_cart==0){
                $_SESSION['customer_email']=$c_email;
                echo "<script>alert('You Logged in Successfully, Thanks!')</script>";
                echo "<script>window.open('customer/my_account.php','_self')</script>";
            }else{
                $_SESSION['customer_email']=$c_email;
                echo "<script>alert('You Logged in Successfully, Thanks!')</script>";
                echo "<script>window.open('checkout.php','_self')</script>";
            }




        }

?>

