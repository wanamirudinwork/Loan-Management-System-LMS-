
	<section>
    	<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Transaction History</h2>
                    
                    <table class="cart-table history">
                        <tr>
                        	<th width="100" class="c">Order ID</th>
                            <th width="105">Items</th>
                            <th class="c" width="120">Order Date</th>
                            <th>Delivery To</th>
                            <th class="c" width="150">Payment Method</th>
                            <th class="c" width="150">Total</th>
                            <th class="c" width="150">Status</th>
                        </tr>
                        <?php
                            if($checkout){
                                foreach($checkout as $keys){
                        ?>
                        <tr>
                        	<td class="c"><b>#<?php echo $keys['id']; ?></b><?php /*<br>Tracking No: <b><?php echo $keys['tracking_no']; ?></b>*/ ?></td>
                            <td class="c">
                                <?php
                                    if($keys['carts']){
                                        foreach($keys['carts'] as $cart){
                                            $images = unserialize($cart['product']['images']);
                                            $iamge = current($images);
                                            $item_options = unserialize($cart['item_option']);
                                                ?>
                                <a href="<?php echo url_for('/product/' . $cart['product']['id'] . '-' . slug($cart['product']['title'])); ?>" title="<?php echo $cart['product']['title']; ?>" data-pos="top">
                                    <img src="<?php echo img($iamge['src'], 75, 75); ?>" alt="<?php echo $iamge['alt']; ?>">
                                    <p>
                                        <b>Qty:</b> <?php echo $cart['quantity']; ?><br>
                                        <?php
                                            if($item_options){
                                                foreach($item_options as $i => $option){
                                                    echo '<b>' . $cart['product']['options'][$i]['title'] . '</b>: ' . $cart['product']['options'][$i]['values'][$option]['title'] . '<br>';
                                                }
                                            }
                                        ?>
                                    </p>
                                </a>
                                                <?php
                                        }
                                    }
                                ?>
                            </td>
                            <td class="c"><?php echo dateTime($keys['payment_date']); ?></td>
                            <td>
                            <?php if(!empty($keys['delivery_address1'])){ ?>
                                <div><?php echo ucwords($keys['delivery_salutation'] . ' ' . $keys['delivery_firstname'] . ' ' . $keys['delivery_lastname']); ?></div>
                                <div><?php echo $keys['delivery_address1']; ?></div>
                                <div><?php echo $keys['delivery_address2']; ?></div>
                                <div><?php echo $keys['delivery_zip']; ?> <?php echo $keys['delivery_city']; ?></div>
                                <div><?php echo $cms->getCountryName($keys['delivery_country']); ?></div>
                                <div><?php echo $cms->getStateName($keys['delivery_state']); ?></div>
                            <?php }else{ ?>
                                <div>Self-Collection</div>
                            <?php } ?>
                            </td>
                            <td class="c"><?php echo $keys['payment_method'] == 'paypal' ? 'PayPal' : 'Manual Bank Transfer'; ?></td>
                            <td class="c"><?php echo $cms->price($keys['total'] + $keys['shipping']); ?></td>
                            <td class="c"><?php echo tracking($keys['tracking']['status']); ?></td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                        <tr></tr>
                    </table>
                </div>
            </div>
        </div>
	</section>