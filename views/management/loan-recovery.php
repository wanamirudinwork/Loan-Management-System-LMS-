		<!-- Start right content -->
        <div class="content-page">
			<!-- ============================================================== -->
			<!-- Start Content here -->
			<!-- ============================================================== -->
            <div class="content">
				<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='fa fa-list'></i> Management</h1>
				</div>
            	<!-- Page Heading End-->	
				<?php
					$url = (explode("/",$_SERVER['REQUEST_URI']));
					$loan_id = $url[4];
					//print_r($keys);
				?>
				<!-- Your awesome content goes here -->
                <div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>Recovery</strong> List</h2>
								<div class="additional-btn toolbar-action">
									<a href="<?php echo url_for('/loan/update/'.$loan_id); ?> " class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back</a>
								</div>
							</div>
                            <?php //print_r($keys); ?>
							<div class="widget-content">
								<br>					
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									        <thead>
									            <tr>
									            	<th class="c" style="border:0px">No. </th>
                                                	<th class="c" style="border:0px">Installment</th>
                                                	<th class="c" width="10%" style="border:0px">Pay Date</th>
                                                	<th class="c" style="border:0px">Balance B/F Gross</th>
                                                	<th class="c" style="border:0px">Balance B/F Principal</th>
                                                	<th class="c" style="border:0px">Interest (RM)</th>
                                                	<th class="c" style="border:0px">Principal (RM)</th>
                                                	<th class="c" style="border:0px">Paid Late Charges</th>
                                                	<th class="c" style="border:0px">Balance C/F Gross</th>
                                                	<th class="c" style="border:0px">Balance C/F Principal</th>
									            </tr>
									 		</thead>
									        <tbody>
											<?php $i = 1; ?>
													<?php foreach($keys as $key){ ?>
													
												<tr style="border:0px;">
													<td class="c" style="border:0px;"><?php echo $i; ?></td>
													<td class="c" style="border:0px;"><?php echo number_format($key['installment_amt'],2); ?></td>
													<td class="c" style="border:0px;"><?php echo $key['payment_date']; ?></td>
													<td class="c" style="border:0px;"><?php echo number_format($key['balance_bf_gross'],2); ?></td>
													<td class="c" style="border:0px;"><?php echo number_format($key['balance_bf_principal'],2); ?></td>
													<td class="c" style="border:0px;"><?php echo number_format($key['interest'],2); ?></td>
													<td class="c" style="border:0px;"><?php echo number_format($key['principal'],2); ?></td>
													<td class="c" style="border:0px;"><?php echo number_format($key['total_late'],2); ?></td>
													<td class="c" style="border:0px;"><?php echo number_format($key['balance_cf_gross'],2); ?></td>
													<td class="c" style="border:0px;"><?php echo number_format($key['balance_cf_principal'],2); ?></td>
													<?php $i++; ?>
												</tr>
													<?php } ?>
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
