
	<section class="cart">
    	<div class="container">
            <h2>My Shopping Cart (<?php echo $cms->cartTotal(); ?>)</h2>
            <ul class="cart-step">
                <li>Summary</li>
                <li>Address</li>
                <li>Info</li>
                <li class="active">Payment</li>
            </ul>
            
            <table class="cart-table">
                <tr>
                    <th width="105">Item</th>
                    <th>Description</th>
                    <th class="c" width="100">Price</th>
                    <th class="c" width="100">Quantity</th>
                    <th class="c" width="100">Total</th>
                </tr>
                <?php
                    if($carts['items']){
                        foreach($carts['items'] as $cart){
                            $images = unserialize($cart['product']['images']);
                            $iamge = current($images);
                            $item_options = unserialize($cart['item_option']);
                ?>
                <tr>
                    <td>
                        <a href="<?php echo url_for('/product/' . $cart['product']['id'] . '-' . slug($cart['product']['title'])); ?>">
                            <img src="<?php echo imgCrop($iamge['src'], 105, 127); ?>" alt="<?php echo $iamge['alt']; ?>">
                        </a>
                    </td>
                    <td>
                        <strong><a href="<?php echo url_for('/product/' . $cart['product']['id'] . '-' . slug($cart['product']['title'])); ?>"><?php echo $cart['product']['title']; ?></a></strong>
                        <p>
                        	<?php
                                if(!empty($cart['item_color'])){
                                	echo '<b>Color</b>: ' . $cart['product']['colors'][$cart['item_color']]['title'] . '<br>';
                                }
                            ?>
                            <?php
                                if($item_options){
                                    foreach($item_options as $i => $option){
                                        echo '<b>' . $cart['product']['options'][$i]['title'] . '</b>: ' . $cart['product']['options'][$i]['values'][$option]['title'] . '<br>';
                                    }
                                }
                            ?>
                        </p>
                    </td>
                    <td class="c"><?php echo $cms->price($cart['price']); ?></td>
                    <td class="c"><?php echo $cart['quantity']; ?></td>
                    <td class="c"><?php echo $cms->price($cart['price'] * $cart['quantity']); ?></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
            
            <table class="cart-table">
                <tr>
                    <th>Email</th>
                </tr>
                <tr>
                    <td><?php echo $carts['SHIPPING']['email']; ?></td>
                </tr>
            </table>
            
            <table class="cart-table">
                <tr>
                    <th width="50%">Delivery Address</th>
                    <th width="50%">Billing Address</th>
                </tr>
                <tr>
                    <td>
                    <?php
                        if($carts['ADDRESS']['DELIVERY_METHOD'] == '1'){
                    ?>
                        <div><?php echo ucwords($carts['ADDRESS']['DELIVERY']['salutation'] . ' ' . $carts['ADDRESS']['DELIVERY']['firstname'] . ' ' . $carts['ADDRESS']['DELIVERY']['lastname']); ?></div>
                        <div><?php echo $carts['ADDRESS']['DELIVERY']['address1']; ?></div>
                        <div><?php echo $carts['ADDRESS']['DELIVERY']['address2']; ?></div>
                        <div><?php echo $carts['ADDRESS']['DELIVERY']['zip']; ?> <?php echo $carts['ADDRESS']['DELIVERY']['city']; ?></div>
                        <div><?php echo $cms->getCountryName($carts['ADDRESS']['DELIVERY']['country']); ?></div>
                        <?php if(!empty($carts['ADDRESS']['DELIVERY']['state'])){ ?><div><?php echo $cms->getStateName($carts['ADDRESS']['DELIVERY']['state']); ?></div><?php } ?>
                        <?php if(!empty($carts['ADDRESS']['DELIVERY']['contact'])){ ?><br><div>Contact: <?php echo $carts['ADDRESS']['DELIVERY']['contact']; ?></div><?php } ?>
                    <?php
                        }else{
                    ?>
                        <div>Self-Collection</div>
                    <?php } ?>
                    </td>
                    <td>
                        <div><?php echo ucwords($carts['ADDRESS']['BILLING']['salutation'] . ' ' . $carts['ADDRESS']['BILLING']['firstname'] . ' ' . $carts['ADDRESS']['BILLING']['lastname']); ?></div>
                        <div><?php echo $carts['ADDRESS']['BILLING']['address1']; ?></div>
                        <div><?php echo $carts['ADDRESS']['BILLING']['address2']; ?></div>
                        <div><?php echo $carts['ADDRESS']['BILLING']['zip']; ?> <?php echo $carts['ADDRESS']['BILLING']['city']; ?></div>
                        <div><?php echo $cms->getCountryName($carts['ADDRESS']['BILLING']['country']); ?></div>
                        <?php if(!empty($carts['ADDRESS']['BILLING']['state'])){ ?><div><?php echo $cms->getStateName($carts['ADDRESS']['BILLING']['state']); ?></div><?php } ?>
                        <?php if(!empty($carts['ADDRESS']['BILLING']['contact'])){ ?><br><div>Contact: <?php echo $carts['ADDRESS']['BILLING']['contact']; ?></div><?php } ?>
                    </td>
                </tr>
            </table>
            
            <?php if(!empty($carts['SHIPPING']['comments'])){ ?>
            <table class="cart-table">
                <tr>
                    <th>Instructions / Additional Comments</th>
                </tr>
                <tr>
                    <td><?php echo $carts['SHIPPING']['comments']; ?></td>
                </tr>
            </table>
            <?php } ?>
            
            <table class="cart-table">
                <tr>
                    <th>Delivery Charges</th>
                    <th width="100" class="c">Total</th>
                </tr>
                <tr>
                    <td>
                    <?php
                        if($carts['delivery_charges']){
                            foreach($carts['delivery_charges'] as $delivery_charge){
                                echo $delivery_charge[0] . '<br>';
                            }
                        }
                    ?>
                    </td>
                    <td class="c"><?php echo $cms->price($carts['shipping_cost']); ?></td>
                </tr>
            </table>
            
            <table class="cart-table promo-code">
            <?php
                if($carts['hasPromo']){
            ?>
                <tr>
                    <td>Promo Code</td>
                    <td colspan="2" class="r"><?php echo $carts['hasPromo']; ?></td>
                </tr>
            <?php
                }else{
            ?>
                <tr>
                    <td></td>
                    <td width="200" class="r"><input type="text" class="form-control input-sm" placeholder="Promo Code"></td>
                    <td width="50"><button class="btn btn-mearisse btn-sm">Update</button></td>
                </tr>
             <?php
                }
             ?>
            </table>
            
            <table class="cart-table">
                <tr>
                    <th>Sub-Total</th>
                    <th width="100" class="c"><?php echo $cms->price($carts['subtotal']); ?></th>
                </tr>
            </table>
            
            <div class="row payment-method">
            	<div class="col-md-2 col-md-offset-8"><h4>Payment Method</h4></div>
                <div class="col-md-2 method"><button class="btn btn-block btn-primary" data-type="paypal"><i class="fa fa-paypal"></i> PayPal</button></div>
                <div class="col-md-2 col-md-offset-10 r">
                	<button class="btn btn-block btn-mearisse" data-type="manual">Bank Transfer</button>
                </div>
            </div>
        </div>
	</section>