<?php
$token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
$payerID = !empty($_REQUEST['PayerID']) ? $_REQUEST['PayerID'] : '';
$carts = $cms->cart();
$failed = true;

if($carts){
	if((!empty($token) && !empty($payerID) && !empty($_SESSION[WEBSITE_PREFIX.'PAYPALNVP3'])) || $_SESSION[WEBSITE_PREFIX.'PAYMENT']['method'] = 'manual'){
		$db->query("SELECT * FROM shopping_checkout WHERE status = '0' AND member_id = " . $db->escape($user->id));
		$checkout = $db->getSingleRow();
				
		if($checkout){
			$failed = false;
			
			if($_SESSION[WEBSITE_PREFIX.'PAYMENT']['method'] == 'paypal'){				
				$db->table('tracking');
				$db->insertArray(array(
					"checkout_id" => $checkout['id'],
					"status" => $carts['ADDRESS']['DELIVERY_METHOD'] > 0 ? '2' : '10',
					"date" => 'NOW()',
				));
				$db->insert();
			}
			
			if($_SESSION[WEBSITE_PREFIX.'PAYMENT']['method'] == 'manual'){
				if($user->logged){
					$db->table('shopping_checkout');
					$db->updateArray(array(
						"payment_method" => $_SESSION[WEBSITE_PREFIX.'PAYMENT']['method'],
						"payment_reference" => $_SESSION[WEBSITE_PREFIX.'PAYMENT']['reference'],
						"payment_receipts" => $_SESSION[WEBSITE_PREFIX.'PAYMENT']['receipts'],
						"payment_date" => 'NOW()',
						"status" => '1',
					));
					$db->whereArray(array(
						"member_id" => $user->id,
						"status" => '0',
					));
					$db->update();
					
				}else{
					$db->table('shopping_checkout');
					$db->updateArray(array(
						"payment_method" => $_SESSION[WEBSITE_PREFIX.'PAYMENT']['method'],
						"payment_reference" => $_SESSION[WEBSITE_PREFIX.'PAYMENT']['reference'],
						"payment_receipts" => $_SESSION[WEBSITE_PREFIX.'PAYMENT']['receipts'],
						"payment_date" => 'NOW()',
						"status" => '1',
					));
					$db->whereArray(array(
						"guest_id" => $user->guest_id,
						"status" => '0',
					));
					$db->update();
				}
				
				$db->table('tracking');
				$db->insertArray(array(
					"checkout_id" => $checkout['id'],
					"status" => $carts['ADDRESS']['DELIVERY_METHOD'] > 0 ? '1' : '10',
					"date" => 'NOW()',
				));
				$db->insert();
			}
																							
			$body = 
					'<html><body style="font-family:Segoe UI,Verdana,sans-serif; font-size:12px">
					<p><strong>Dear ' . ucwords($carts['ADDRESS']['BILLING']['firstname']) . ' ' . ucwords($carts['ADDRESS']['BILLING']['lastname']) . ',</strong></p>
					<p>Thank you for shopping with ' . option('title') . ', your purchase is successful!</p>
					<p>Here is your order list:</p>
					<table style="border-collapse:collapse;width:auto;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin:15px 0;">';
				
			$body .= '
						<tr>
							<th colspan="2" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;">Delivery Address</th>
							<th colspan="2" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;">Billing Address</th>
						</tr>
						<tr>
							<td valign="top" colspan="2" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;">';
							
			if($carts['ADDRESS']['DELIVERY_METHOD'] == '0'){
						$body .= 'Order in progress';	
			}else{
								
				$body .= '
							<p>' . ucwords($carts['ADDRESS']['DELIVERY']['firstname'] . ' ' . $carts['ADDRESS']['DELIVERY']['lastname']). '</p>
							<p>
								' . $carts['ADDRESS']['DELIVERY']['address1'] . '<br>
								' . $carts['ADDRESS']['DELIVERY']['address2'] . '<br>
								' . $carts['ADDRESS']['DELIVERY']['zip'] . ' ' . $carts['ADDRESS']['DELIVERY']['city'] . '<br>
								' . $cms->getStateName($carts['ADDRESS']['DELIVERY']['state']) . '<br>
								' . $cms->getCountryName($carts['ADDRESS']['DELIVERY']['country']);
				$body .= '
							</p>
							<p>Contact Number: ' . $carts['ADDRESS']['DELIVERY']['contact'] . '</p>';
			}
				$body .= '
							</td>
							<td valign="top" colspan="2" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;">
							<p>' . ucwords($carts['ADDRESS']['BILLING']['firstname'] . ' ' . $carts['ADDRESS']['BILLING']['lastname']). '</p>
							<p>
								' . $carts['ADDRESS']['BILLING']['address1'] . '<br>
								' . $carts['ADDRESS']['BILLING']['address2'] . '<br>
								' . $carts['ADDRESS']['BILLING']['city'] . ' ' . $carts['ADDRESS']['BILLING']['city'] . '<br>
								' . $cms->getStateName($carts['ADDRESS']['BILLING']['state']) . '<br>
								' . $cms->getCountryName($carts['ADDRESS']['BILLING']['country']);
				$body .= '
							</p>
							<p>Contact Number: ' . $carts['ADDRESS']['BILLING']['contact'] . '</p>';
				$body .= '
							</td>
						</tr>';
						
				if(!empty($carts['ADDRESS']['SHIPPING']['comments'])){
						$body .= '
						<tr>
							<th colspan="4" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;">
								Instructions / Additional Comments
							</th>
						</tr>
						<tr>
							<td colspan="4" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;">
								' . $carts['ADDRESS']['SHIPPING']['comments'] . '
							</td>
						</tr>
						';
				}
						
				$body .= '
						<tr>
							<th style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;width:200px;">Items</th>
							<th style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;width:200px;">Price</th>
							<th style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;width:200px;">Quantity</th>
							<th style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;width:200px;">Total</th>
						</tr>';
						
					if($carts['items']){
						foreach($carts['items'] as $no => $cart){
							$images = unserialize($cart['product']['images']);
							$iamge = current($images);
							$item_options = unserialize($cart['item_option']);
					$body .= '
						<tr>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;">';
					
							if(isset($cart['item_color'])){
								$body .= '<b>Color</b>: ' . $cart['product']['colors'][$cart['item_color']]['title'] . '<br>';
							}
					
					$body .= '
								' . ($no + 1) . '. ' . $cart['product']['title'];
								
							if($item_options){
								foreach($item_options as $i => $option){
									$body .= '<br><b>' . $cart['product']['options'][$i]['title'] . '</b>: ' . $cart['product']['options'][$i]['values'][$option]['title'];
								}
							}
								
								
					$body .= '
							</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $cms->price($cart['price']) . '</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $cart['quantity'] . '</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $cms->price($cart['price'] * $cart['quantity']) . '</td>
						</tr>';
						}
					}
					$body .= '
						<tr>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;padding:7px;color:#222222;" colspan="3">Shipping</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $cms->price($carts['shipping_cost']) . '</td>
						</tr>';
					
					if($carts['hasPromo']){
					$body .= '
						<tr>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;padding:7px;color:#222222;" colspan="3">Promo Code</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $carts['hasPromo'] . '</td>
						</tr>';
					}

					$body .= '
						<tr>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;padding:7px;color:#222222;" colspan="3">Total</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;padding:7px;color:#222222;text-align:center;">' . $cms->price($carts['subtotal']) . '</td>
						</tr>
					</table>
					<p>This is an auto-generated email. Please do not reply to this email.</p>
					<p>Sincerely,<br>' . option('title') . ' Team</p>
					</body></html>';
						
				if($carts['items']){
					foreach($carts['items'] as $cart){
						$db->table('shopping_cart');
						$db->updateArray(array(
							"status" => '2',
							"checkout_id" => $checkout['id'],
						));
						$db->whereArray(array(
							"id" => $cart['id'],

						));
						$db->update();
					}
				}
										
				$to = $carts['SHIPPING']['email'];
				$from = $cms->settings['email'];
				$subject = option('title') . ": Purchase Successful Receipt no #" . $checkout['id'];
				$mime = new sendMail($from, $to, "", "", $subject);
				$mime->set('html', true);
				$mime->parseBody($body);
				$mime->setHeaders(); 
				$mime->send();
				
				// Send to admin
				$ref = 'http://' . $_SERVER['HTTP_HOST'] . url_for('/backpanel/orders/' .  $checkout['id']);
				$link = $ref;
				
				$body = 
					'<html><body style="font-family:Segoe UI,Verdana,sans-serif; font-size:12px">
					<p><strong>Dear Admin,</strong></p>
					<p>You have a new order:</p>
					<p>Here is your order list:</p>
					<table style="border-collapse:collapse;width:auto;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin:15px 0;">';
				
				$body .= '
						<tr>
							<th colspan="2" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;">Delivery Address</th>
							<th colspan="2" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;">Billing Address</th>
						</tr>
						<tr>
							<td valign="top" colspan="2" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;">';
							
			if($carts['ADDRESS']['DELIVERY_METHOD'] == '0'){
						$body .= 'Order in progress';	
			}else{
								
				$body .= '
							<p>' . ucwords($carts['ADDRESS']['DELIVERY']['firstname'] . ' ' . $carts['ADDRESS']['DELIVERY']['lastname']). '</p>
							<p>
								' . $carts['ADDRESS']['DELIVERY']['address1'] . '<br>
								' . $carts['ADDRESS']['DELIVERY']['address2'] . '<br>
								' . $carts['ADDRESS']['DELIVERY']['zip'] . ' ' . $carts['ADDRESS']['DELIVERY']['city'] . '<br>
								' . $cms->getStateName($carts['ADDRESS']['DELIVERY']['state']) . '<br>
								' . $cms->getCountryName($carts['ADDRESS']['DELIVERY']['country']);
				$body .= '
							</p>
							<p>Contact Number: ' . $carts['ADDRESS']['DELIVERY']['contact'] . '</p>';
			}
				$body .= '
							</td>
							<td valign="top" colspan="2" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;">
							<p>' . ucwords($carts['ADDRESS']['BILLING']['firstname'] . ' ' . $carts['ADDRESS']['BILLING']['lastname']). '</p>
							<p>
								' . $carts['ADDRESS']['BILLING']['address1'] . '<br>
								' . $carts['ADDRESS']['BILLING']['address2'] . '<br>
								' . $carts['ADDRESS']['BILLING']['city'] . ' ' . $carts['ADDRESS']['BILLING']['city'] . '<br>
								' . $cms->getStateName($carts['ADDRESS']['BILLING']['state']) . '<br>
								' . $cms->getCountryName($carts['ADDRESS']['BILLING']['country']);
				$body .= '
							</p>
							<p>Contact Number: ' . $carts['ADDRESS']['BILLING']['contact'] . '</p>';
				$body .= '
							</td>
						</tr>';
						
				if(!empty($carts['ADDRESS']['SHIPPING']['comments'])){
						$body .= '
						<tr>
							<th colspan="4" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;">
								Instructions / Additional Comments
							</th>
						</tr>
						<tr>
							<td colspan="4" style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;">
								' . $carts['ADDRESS']['SHIPPING']['comments'] . '
							</td>
						</tr>
						';
				}
						
				$body .= '
						<tr>
							<th style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;width:200px;">Items</th>
							<th style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;width:200px;">Price</th>
							<th style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;width:200px;">Quantity</th>
							<th style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#222222;width:200px;">Total</th>
						</tr>';
						
					if($carts['items']){
						foreach($carts['items'] as $no => $cart){
							$images = unserialize($cart['product']['images']);
							$iamge = current($images);
							$item_options = unserialize($cart['item_option']);
					$body .= '
						<tr>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;">';
					
							if(isset($cart['item_color'])){
								$body .= '<b>Color</b>: ' . $cart['product']['colors'][$cart['item_color']]['title'] . '<br>';
							}
					
					$body .= '
								' . ($no + 1) . '. ' . $cart['product']['title'];
								
							if($item_options){
								foreach($item_options as $i => $option){
									$body .= '<br><b>' . $cart['product']['options'][$i]['title'] . '</b>: ' . $cart['product']['options'][$i]['values'][$option]['title'];
								}
							}
								
								
					$body .= '
							</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $cms->price($cart['price']) . '</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $cart['quantity'] . '</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $cms->price($cart['price'] * $cart['quantity']) . '</td>
						</tr>';
						}
					}
					$body .= '
						<tr>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;padding:7px;color:#222222;" colspan="3">Shipping</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $cms->price($carts['shipping_cost']) . '</td>
						</tr>';
					
					if($carts['hasPromo']){
					$body .= '
						<tr>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;padding:7px;color:#222222;" colspan="3">Promo Code</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;color:#222222;text-align:center;">' . $carts['hasPromo'] . '</td>
						</tr>';
					}

					$body .= '
						<tr>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;padding:7px;color:#222222;" colspan="3">Total</td>
							<td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;padding:7px;color:#222222;text-align:center;">' . $cms->price($carts['subtotal']) . '</td>
						</tr>
					</table>
					<p>View Order:<br><a href="' . $link . '">' . $link . '</a></p>
					</body></html>';
				
				$to = $cms->settings['email'];
				$from = $carts['SHIPPING']['email'];
				$subject = "You have an purchase order: Receipt no #" . $checkout['id'];
					
				$mime = new sendMail($from, $to, "", "", $subject);
				$mime->set('html', true);
				$mime->parseBody($body);
				$mime->setHeaders(); 
				$mime->send();
								
				unset($_SESSION[WEBSITE_PREFIX.'DELIVERY_ADDRESS']);
				unset($_SESSION[WEBSITE_PREFIX.'BILLING_ADDRESS']);
				unset($_SESSION[WEBSITE_PREFIX.'ADDRESS']);
				unset($_SESSION[WEBSITE_PREFIX.'SHIPPING']);
				unset($_SESSION[WEBSITE_PREFIX.'PAYPALNVP']);
				unset($_SESSION[WEBSITE_PREFIX.'DELIVERY_METHOD']);
				unset($_SESSION[WEBSITE_PREFIX.'PAYMENT']);
			?>
            
	<section class="cart">
    	<div class="container">
            <h2>My Shopping Cart</h2>
            <ul class="cart-step">
                <li>Summary</li>
                <li>Address</li>
                <li>Info</li>
                <li class="active">Payment</li>
            </ul>
            <div class="return">
                <h1>Your Order Has Been Processed!</h1>
                <?php if(!empty($nvp3['L_LONGMESSAGE0'])){ ?><p style="color: red;">*Note: <?php echo $nvp3['L_LONGMESSAGE0']; ?></p><?php } ?>
                <p>A receipt and record of your order has been e-mailed to your e-mail address.</p>
                <?php if($user->logged){ ?><p>You can view your order history by going to the <a href="<?php echo url_for('/account/history'); ?>">history</a> page.</p><?php } ?>
                <p>Please contact us at <a href="mailto:<?php echo $settings['email']; ?>"><?php echo $settings['email']; ?></a> if you have any questions on your orders</p>
                <p>Thanks again for choosing <?php echo option('title'); ?> and have a lovely, lovely day!</p>
                <p><button class="btn btn-mearisse" onClick="location.href='<?php echo url_for('/'); ?>'">Back To Home</button></p>
            </div>
        </div>
	</section>
    
			<?php
		}
	}
	
	if($failed){
		?>
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
		<?php
	}

}
?>
