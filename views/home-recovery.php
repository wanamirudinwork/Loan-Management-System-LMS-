		
		<!-- Start right content -->
        <div class="content-page">
			<!-- ============================================================== -->
			<!-- Start Content here -->
			<!-- ============================================================== -->
            <div class="content">
            	<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='icon-home-3'></i> Dashboard</h1>
				</div>
            	<!-- Page Heading End-->
                <!-- Start info box -->
				<div class="row top-summary">
					<div class="col-lg-3 col-md-6">
						<div class="widget green-1 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="icon-download"></i>
								</div>
								<div class="text-box">
									<p class="maindata">TOTAL <b>COLLECTION</b> (until <?php echo date('F Y'); ?>)</p>
									<h2><span class="animate-number" data-value="<?php echo $total['total_installment_paid_this_month_percent']; ?>" data-duration="3000">0</span>%</h2>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="widget-footer">
								<div class="row">
									<!--div class="col-sm-12">
										<?php echo $total['count_installment_paid_this_month']; ?> / <?php echo $total['count_installment_this_month']; ?> Recovery Record
										(<?php echo $cms->price($total['total_installment_paid_this_month']); ?> / <?php echo $cms->price($total['total_installment_this_month']); ?>)
									</div-->
									<div class="col-sm-12">
										<?php echo $cms->price($total['total_installment_paid_this_month']); ?> / <?php echo $cms->price($total['total_installment_this_month']); ?>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
						<div class="widget pink-2 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="fa fa-thumbs-o-down"></i>
								</div>
								<div class="text-box">
									<p class="maindata">TOTAL <b>BAD DEBT</b> (until <?php echo date('F Y'); ?>)</p>
									<h2><span class="animate-number" data-value="<?php echo $total['total_bad_debt']; ?>" data-duration="3000">0</span>%</h2>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="widget-footer">
								<div class="row">
									<div class="col-sm-12">
										<?php echo $cms->price($total['total_bad_debt_amount']); ?> / <?php echo $cms->price($total['total_installment_until_this_month']); ?>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
						<div class="widget darkblue-1 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="fa fa-dollar"></i>
								</div>
								<div class="text-box">
									<p class="maindata">YEAR OF <?php echo date('Y'); ?> <b>COLLECTION</b></p>
									<h2>RM <span class="animate-number" data-value="<?php echo $total['year_of_collection']; ?>" data-duration="3000">0</span></h2>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="widget-footer">
								<div class="row">
									<div class="col-sm-12">
										<?php echo $total['year_of_collection_count']; ?> Recovery Records Collected
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- End of info box -->
                
				<?php echo partial('copy.php'); ?>	
            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->
