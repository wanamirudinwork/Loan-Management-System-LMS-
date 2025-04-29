		<!-- Start right content -->
        <div class="content-page">
			<!-- ============================================================== -->
			<!-- Start Content here -->
			<!-- ============================================================== -->
            <div class="content">
				<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='fa fa-shopping-cart'></i> Orders</h1>
				</div>
            	<!-- Page Heading End-->	
								
				<!-- Your awesome content goes here -->
                <div class="col-md-12">
					<div class="widget">
						<div class="widget-header">
							<h2>Order <strong>#<?php echo $key['id']; ?></strong></h2>
						</div>
                           
						<div class="widget-content padding">
                        	<h2>Email Address</h2>
                            <?php echo $key['email']; ?>
                            <br><br>
                        	<div class="row">
                            	<div class="col-sm-6 ">
                                	<h2>Billing Address</h2>
                                	<p>
                                    	<?php echo $key['billing_firstname'] . ' ' . $key['billing_lastname']; ?><br>
                                        <?php echo $key['billing_address1']; ?><br>
                                        <?php echo $key['billing_address2']; ?><br>
                                        <?php echo $key['billing_zip'] . ' ' . $key['billing_city']; ?><br>
                                        <?php echo $key['billing_state']; ?><br>
                                        <?php echo $key['billing_country']; ?><br><br>
                                        <b>Phone No:</b> <?php echo $key['billing_contact']; ?>
                                    </p>
                                    
                                    
                                </div>
                                <div class="col-sm-6">
                                	<h2>Delivery Address</h2>
                                    <?php
										if(!empty($key['delivery_firstname'])){
									?>
                                	<p>
                                    	<?php echo $key['delivery_firstname'] . ' ' . $key['delivery_lastname']; ?><br>
                                        <?php echo $key['delivery_address1']; ?><br>
                                        <?php echo $key['delivery_address2']; ?><br>
                                        <?php echo $key['delivery_zip'] . ' ' . $key['delivery_city']; ?><br>
                                        <?php echo $key['delivery_state']; ?><br>
                                        <?php echo $key['delivery_country']; ?><br><br>
                                        <b>Phone No:</b> <?php echo $key['delivery_contact']; ?>
                                    </p>
                                    <?php
										}else{
									?>
                                    <p>Self-Collection</p>
                                    <?php
										}
									?>
                                </div>
                            </div>
                                                        
                           	<br>
                            <h2>Order Details</h2>
							<table class="table table-hover table-striped">
                    	       	<tr>
									<th colspan="2">Product</th>
									<th width="120" class="c">Quantity</th>
                                    <th width="120" class="c">Unit Price</th>
                                    <th width="120" class="c">Total</th>
								</tr>
                                <?php
								$total = 0;
									if($carts){
										foreach($carts as $keys){
											$image = is_array($keys['product']['images']) ? current($keys['product']['images']) : array('src' => '');
								?>
                                <tr>
                                	<td width="100">
                                    	<img src="<?php echo img($image['src'], 100, 100); ?>">
                                    </td>
                                    <td>
                                    	<?php echo $keys['product']['title']; ?>
                                        <?php
											if($keys['options']){
												foreach($keys['options'] as $option => $value){
													echo '<br><b>' . $keys['product']['options'][$option]['title'] . ':</b> ' .$keys['product']['options'][$option]['values'][$value]['title'];
												}
											}
										?>
                                    </td>
                                    <td class="c"><?php echo $keys['quantity']; ?></td>
                                    <td class="c"><?php echo $cms->price($keys['price']); ?></td>
                                    <td class="c"><?php echo $cms->price($keys['price'] * $keys['quantity']); ?></td>
                                </tr>
                                <?php
										$total += $keys['price'] * $keys['quantity'];
										}
									}
								?>
                                <?php if($promo){ ?>
                                <tr>
                                	<td colspan="2">Promo Code</td>
                                    <td class="r" colspan="3"><?php echo $promo; ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                	<th colspan="4">Subtotal</th>
                                    <th class="c"><?php echo $cms->price($total); ?></th>
                                </tr>
                                <tr>
                                	<th colspan="4">Shipping</th>
                                    <th class="c"><?php echo $cms->price($key['shipping']); ?></th>
                                </tr>
                                <tr>
                                	<th colspan="4">Total Paid</th>
                                    <th class="c"><?php echo $cms->price($key['total'] + $key['shipping']); ?></th>
                                </tr>
                             </table>
						</div>
					</div>
                    
                    <?php if($key['payment_method'] == 'manual'){ ?>
                    <div class="widget">
						<div class="widget-header">
							<h2><strong>Payment</strong> Details</h2>
						</div>
                           
						<div class="widget-content padding">
                        	<div class="row">
                            	<div class="col-sm-6 ">
                                	<h2>Payment Reference</h2>
                                    <?php echo nl2br($key['payment_reference']); ?>
                                </div>
                                <div class="col-sm-6">                                    
                                	<h2>Uploaded Receipts</h2>
                                    <ul class="list">
                                    	<?php
											if($receipts){
												foreach($receipts as $i => $receipt){
													$filename = explode('/', $receipt);
													$filename = end($filename);
													?>
                                    	<li><a href="<?php echo option('site_uri') . $receipt; ?>" target="_blank"><?php echo $filename; ?></a></li>
                                                    <?php
												}
											}
										?>
                                    </ul>
                                </div>
                            </div>
						</div>
					</div>
                    <?php } ?>
                    
                    <?php if($key['payment_method'] == 'paypal'){ ?>
                    <div class="widget">
						<div class="widget-header">
							<h2><strong>PayPal</strong> Transaction</h2>
						</div>
                           
						<div class="widget-content padding">
                        	<div class="row">
                            	<div class="col-sm-6 ">
                                	<h2>GetExpressCheckoutDetails</h2>
                                    <table class="table table-hover table-striped payment-details">
                                    <?php
										if($GetExpressCheckoutDetails){
											foreach($GetExpressCheckoutDetails as $keys => $val){
												?>
                                        <tr>
                                            <th><?php echo $keys; ?></th>
                                            <td><?php echo $val; ?></td>
                                        </tr>
                                                <?php
											}
										}
									?>
                                    </table>
                                </div>
                                <div class="col-sm-6">                                    
                                	<h2>DoExpressCheckoutPayment</h2>
                                    <table class="table table-hover table-striped payment-details">
                                    <?php
										if($DoExpressCheckoutPayment){
											foreach($DoExpressCheckoutPayment as $keys => $val){
												?>
                                        <tr>
                                            <th><?php echo $keys; ?></th>
                                            <td><?php echo $val; ?></td>
                                        </tr>
                                                <?php
											}
										}
									?>
                                    </table>
                                </div>
                            </div>
						</div>
					</div>
                    <?php } ?>
                    
                    <div class="widget">
                    	<div class="widget-content padding">
                        	<h2>Update Order</h2>
                             <form id="selfForm" class="form-horizontal" role="form">
                             <div class="form-group">
                             	<label class="col-sm-2 control-label">Tracking No</label>
                             	<div class="col-sm-10">
                             		<input type="text" class="form-control" name="tracking_no" value="<?php echo $key['tracking_no']; ?>">
                             	</div>
                             </div>
                             <div class="form-group">
                             	<label class="col-sm-2 control-label">Status</label>
                             	<div class="col-sm-10">
                                    <select class="form-control selectpicker" name="status">
                                        <option value="0"<?php echo $lastTracking['status'] == '0' ? ' selected' : ''; ?>><?php echo tracking('0'); ?></option>
                                        <option value="1"<?php echo $lastTracking['status'] == '1' ? ' selected' : ''; ?>><?php echo tracking('1'); ?></option>
                                        <option value="2"<?php echo $lastTracking['status'] == '2' ? ' selected' : ''; ?>><?php echo tracking('2'); ?></option>
                                        <option value="3"<?php echo $lastTracking['status'] == '3' ? ' selected' : ''; ?>><?php echo tracking('3'); ?></option>
                                        <option value="10"<?php echo $lastTracking['status'] == '10' ? ' selected' : ''; ?>><?php echo tracking('10'); ?></option>
                                    </select>
                             	</div>
                             </div>
                             <div class="form-group">
                             	<label class="col-sm-2 control-label">Notify Member By Email</label>
                             	<div class="col-sm-10">
                                    <input type="checkbox" name="notify" class="ios-switch ios-switch-success ios-switch-sm" checked />
                                </div>
                             </div>
                             <div class="form-group">
                             	<label class="col-sm-2 control-label"></label>
                             	<div class="col-sm-10">
                             		<input type="submit" class="btn btn-primary" value="Update">
                             		<input type="button" class="btn btn-default back" value="Back">
                             	</div>
                             </div>
                            </form>
                        </div>
                    </div>
                    
					<?php echo partial('copy.php'); ?>
                    <!-- End of your awesome content -->
				</div>
            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->
