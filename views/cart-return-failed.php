
	<section class="cart">
    	<div class="container">
            <h2>My Shopping Cart (<?php echo $cms->cartTotal(); ?>)</h2>
            <ul class="cart-step">
                <li>Summary</li>
                <li>Address</li>
                <li>Info</li>
                <li class="active">Payment</li>
            </ul>
            <div class="return">
                <h1>Payment Failed!</h1>
                <?php if(!empty($pp_error)){ ?><p style="color: red;">*Note: <?php echo $pp_error; ?></p><?php } ?>
                <p>Sorry, your payment for the order is unsuccessful. Please return to the shopping cart and try again.</p>
                <p>We apologize for any inconvenience caused.</p>
                <p>For more enquiries please email to us at <a href="mailto:<?php echo $settings['email']; ?>"><?php echo $settings['email']; ?></a></p>
                <p>Please click here to continue shopping with <?php echo option('title'); ?>!</p>
                <p>Have a nice day!</p>
                <p><button class="btn btn-mearisse" onClick="location.href='<?php echo url_for('/cart/payment'); ?>'">Return To Payment Page</button></p>
            </div>
        </div>
	</section>