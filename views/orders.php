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
								<h2><strong>Orders</strong> Management</h2>
							</div>
                            
							<div class="widget-content">
								<br>					
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									        <thead>
									            <tr>
                                                	<th width="80" class="c">Order ID</th>
                                                    <th width="100" class="c">Tracking ID</th>
                                                    <th width="100" class="c">Cart ID</th>
                                                	<th width="100">Member</th>
                                                    <th width="130" class="c">Transaction Date</th>
                                                    <th width="100" class="c">Total</th>
                                                    <th width="100" class="c">Shipping</th>
                                                    <th width="110" class="c">Payment Method</th>
                                                    <th width="50" class="c">Status</th>
                                                    <th width="20"></th>
									            </tr>
									 		</thead>
									        <tbody>
                                            <?php
												if($keys){
													foreach($keys as $keys){
											?>
									            <tr>
                                                	<td class="c">#<?php echo $keys['id']; ?></td>
                                                    <td class="c"><?php echo $keys['tracking_no']; ?></td>
                                                    <td class="c"><?php echo $keys['item_id']; ?></td>
                                                	<td><?php echo $keys['member']['firstname'] . ' ' . $keys['member']['lastname']; ?></td>
                                                    <td class="c"><?php echo strtotime($keys['payment_date']) > 0 ? dateTimeFormat($keys['payment_date']) : '-'; ?></td>
                                                    <td class="c"><?php echo $cms->price($keys['total']); ?></td>
                                                    <td class="c"><?php echo $cms->price($keys['shipping']); ?></td>
                                                    <td class="c"><?php echo $keys['payment_method'] == 'paypal' ? 'PayPal' : ($keys['payment_method'] == 'manual' ? 'Bank Transfer' : '-'); ?></td>
                                                    <td class="c"><?php echo tracking($keys['lastTracking']['status']); ?></td>
									                <td class="text-center">
                                                        <a href="<?php echo url_for('orders/'.$keys['id']); ?>" title="Edit"><i class="icon-pencil"></i></a>
                                                    </td>
									            </tr>
                                            <?php
													}
												}
											?>
									        </tbody>
									    </table>
									</form>
								</div>
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
