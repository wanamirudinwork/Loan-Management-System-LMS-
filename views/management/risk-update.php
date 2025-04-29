
</script>
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
								
				<!-- Your awesome content goes here -->
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Record  </strong>Collection </h2>
					</div>
					<?php //print_r($risk); ?>
					<?php //print_r($borrower); ?>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
						<input type="hidden" name="loan_id" value="<?php echo $risk['loan_id']; ?>">
						<input type="hidden" name="installment_id" value="<?php echo $risk['installment_id']; ?>">
						<input type="hidden" name="pay_type" value="<?php echo $risk['pay_type']; ?>">
                        <input type="hidden" name="recovery_id" value="<?php echo $risk['recovery_id']; ?>">
							<!-- displaying lender name  -->
                            <div class="form-group">
								<label class="col-sm-2 control-label">Total Amount Due</label>
								<div class="col-sm-3">
									<label style="font-size:18px;">RM <?php echo number_format($risk['actual_amount']); ?></label>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Amount Paid</label>
								<div class="col-sm-3">
									<label style="font-size:18px;">RM <?php echo number_format($risk['amount_paid']); ?></label>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label " for="borrowerID">Borrower Name</label>
								<div class="col-sm-3">
									<label style="font-size:18px;"><?php echo $borrower['full_name']; ?></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Collection For</label>
								<!-- <label style="font-size:18px;"><?php echo $risk['pay_type']; ?></label> -->
								<label style="font-size:18px;"><?php if ($risk['pay_type'] == 0){ echo("");} ?></label>
								<label style="font-size:18px;"><?php if ($risk['pay_type'] == 1){ echo("Both (Principal + Interest)");} ?></label>
								<label style="font-size:18px;"><?php if ($risk['pay_type'] == 2){ echo("Interest Amount");} ?></label>
								<label style="font-size:18px;"><?php if ($risk['pay_type'] == 3){ echo("Rescheduling");} ?></label>
								<label style="font-size:18px;"><?php if ($risk['pay_type'] == 4){ echo("Partial Payment");} ?></label>
								<label style="font-size:18px;"><?php if ($risk['pay_type'] == 5){ echo("Late Charges");} ?></label>
								<label style="font-size:18px;"><?php if ($risk['pay_type'] == 6){ echo("Full Settlement");} ?></label>
                                    	
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Collection Date</label>
								<div class="col-sm-3">
									<label style="font-size:18px;"><?php echo $risk['paid_date']; ?></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Remarks</label>
								<div class="col-sm-8">
									<textarea style="font-size:18px;" class="form-control" name="remarks"><?php echo $risk['remarks']; ?></textarea>
								</div>
							</div>

	<div class="form-group">
								<label class="col-sm-2 control-label">Attach Receipt</label>
								<div class="col-sm-10">
                                	<div class="sortable">
										<?php if($receipts){ foreach($receipts as $i => $receipt){ ?>
											<div class="multiImg">
												<img src="<?php echo imgCrop($receipt['src']); ?>" style="display:table;margin:5px;max-width:200px;max-height:100px;">
												<input id="photo<?php echo $i+1; ?>" name="images[<?php echo $i+1; ?>][src]" value="<?php echo $receipt['src']; ?>" type="hidden">
												<input name="images[<?php echo $i+1; ?>][alt]" class="form-control" placeholder="LABEL" value="<?php echo $receipt['alt']; ?>" type="text">
												<a href="javascript:void(0)" onclick="kcFinderB('photo<?php echo $i+1; ?>')">Browse</a> | 
												<a href="javascript:void(0)" onclick="kcFinderR('photo<?php echo $i+1; ?>')">Cancel</a>
											</div>
										<?php }} ?>
									</div>
                                    <div class="addMultiImg">
                                    	<a href="javascript:;" class="btn btn-default"><i class="fa fa-plus"></i> Add Image</a>
                                    </div>
								</div>
							</div>



							<div class="form-group">
								<label class="col-sm-2 control-label">Receipt</label>
								<div class="col-sm-8">
									<?php if($risk['receipt']){ foreach($risk['receipt'] as $receipt){ ?>
									<a href="<?php echo imgCrop($receipt['src']); ?>" target="_blank"><img src="<?php echo imgCrop($receipt['src'], 150, 150); ?>" alt="<?php echo $receipt['alt']; ?>"></a> &nbsp;
									<?php }} ?>
								</div>
							</div>
							<div class="form-group">
                            	<label class="col-sm-2 control-label">Status</label>
                            	<div class="col-sm-10">
                                    <select class="form-control selectpicker" name="status"  onchange="show(this)">
                                    	<option value="4"<?php echo $risk['recovery_status'] == 4 ? ' selected' : ''; ?>><?php echo risk_status('1'); ?></option>
                                    	<option value="2"<?php echo $risk['recovery_status'] == 2 ? ' selected' : ''; ?>><?php echo risk_status('2'); ?></option>
                                    	<option value="3"<?php echo $risk['recovery_status'] == 3 ? ' selected' : ''; ?>><?php echo risk_status('3'); ?></option>
                                    </select>
                            	</div>
                            </div>
							<div id="rejection" class="form-group">
								<label  class="col-sm-2 control-label">Rejection Reason</label>
								<div class="col-sm-8">
									<textarea style="font-size:18px;" class="form-control" name="rejection"><?php echo $risk['rejection']; ?></textarea>
								</div>
							</div>
							<script>
								document.getElementById("rejection").style.visibility = "hidden";
								function show(select){
									if(select.value == '3'){
										document.getElementById("rejection").style.visibility = "visible";

									}
									else if(select.value == '2'){
										document.getElementById("rejection").style.visibility = "hidden";

									}
                                    else if(select.value == '4'){
                                        document.getElementById("rejection").style.visibility = "hidden";

                                    }
									else if(select.value == '1'){
										document.getElementById("rejection").style.visibility = "hidden";

									}}
								</script>




                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Update">
									<input type="button" class="btn btn-default" value="Back" onclick="history.back()">
                                   
								</div>
							</div>
						</form>
					</div>
				</div>
			
				<!-- End of your awesome content -->
			
			<?php echo partial('copy.php'); ?>
            		
            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->
