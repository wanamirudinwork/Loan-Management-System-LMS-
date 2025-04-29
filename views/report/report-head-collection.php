
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
				<!-- Your awesome content goes here -->
                <div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>Head Collection</strong>  Report</h2>
									<div class="additional-btn toolbar-action">
									<!-- <a href="#" class="btn btn-primary btn-xs btn-export"><i class="fa fa-plus-circle"></i> Export to CSV</a>
									<a href="#" class="btn btn-primary btn-xs btn-export-borrower"><i class="fa fa-plus-circle"></i> Export By Borrower</a> -->
									<a href="#" class="btn btn-primary btn-xs btn-export-officer"><i class="fa fa-plus-circle"></i> Export By Officer</a>
								</div>
                            </div>
                            
				
							<div class="widget-content">
							<!-- <form class="form-inline" role="form">
									<div class="form-group" style="padding: 10px 20px;">
										<label class="control-label">Date Range</label>
										<input type="text" name="date_from" class="form-control datepicker-input" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $date_from; ?>"> to 
										<input type="text" name="date_to" class="form-control datepicker-input" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $date_to; ?>">
										<input type="button" class="btn btn-primary btn-filter-date" value="Filter">
									</div>
								</form>
								<form class="form-inline" role="form">
                        <div class="form-group" style="padding: 10px 20px;">
                            <label class="control-label">Borrower Name</label>
                            <select id="borrowerID" class="form-control " name="borrowerID">
                                <option value=""> - </option>
                                <?php
                                if($select){
                                    foreach($select as $selection){
									if($selection['admin_id'] == $cms->admin->id){
									?>{
                                        <option value="<?php echo $selection['borrower_id']; ?>" <?php echo $selection['borrower_id'] == $borrower_id ? ' selected' : ''; ?>><?php echo $selection['full_name'];?></option>
                                    <?php 
									}
									if($selection['head_id'] == $cms->admin->id){
										?>{
											<option value="<?php echo $selection['borrower_id']; ?>" <?php echo $selection['borrower_id'] == $borrower_id ? ' selected' : ''; ?>><?php echo $selection['full_name'];?></option>
										<?php 
										}
										if($cms->admin->role == '1' || $cms->admin->role == '2' || $cms->admin->role_type == '1'){
											?>{
												<option value="<?php echo $selection['borrower_id']; ?>" <?php echo $selection['borrower_id'] == $borrower_id ? ' selected' : ''; ?>><?php echo $selection['full_name'];?></option>
											<?php 
											}
									
									
									
								}
                                } ?>
                            </select>
                            <input type="button" class="btn btn-primary btn-filter-borrower" value="Borrower Filter">
                        </div>
                    </form> -->

					<form class="form-inline" role="form">
                        <div class="form-group" style="padding: 10px 20px;">
                            <label class="control-label">Recovery Head Officer Name</label>
                            <select id="adminID" class="form-control " name="adminID">
                                <option value=""> All </option>
                                <?php
                                if($selectofficername){
                                    foreach($selectofficername as $selection){ 
										if($selection['head_id'] == $cms->admin->id){?>
                                        <option value="<?php echo $selection['head_id']; ?>" <?php echo $selection['head_id'] == $admin_id ? ' selected' : ''; ?>><?php echo $selection['admin_name'];?></option>
                                    <?php }
										if($cms->admin->role == '1' || $cms->admin->role == '2' || $cms->admin->role_type == '1'){?>
											<option value="<?php echo $selection['head_id']; ?>" <?php echo $selection['head_id'] == $admin_id ? ' selected' : ''; ?>><?php echo $selection['admin_name'];?></option>
										<?php }
									}
                                } ?>
                            </select>
                            <input type="button" class="btn btn-primary btn-filter-officer" value="Officer Filter">
                        </div>
                    </form>

					
								<br>		
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									        <thead>
									            <tr>
                                                	<th class="c pointer">No.</th>
                                                	<th class="c pointer">Borrower Name</th>
													<th class="c pointer">Loan Reference Number</th>
													<th class="c pointer">Collection Amount (RM)</th>
                                                	<th class="c pointer">Collection Date</th>
													<th class="c pointer">Payment Method</th>
													<th class="c pointer">Loan Amount (RM)</th>
													<th class="c pointer">Percentage</th>
													<th class="c pointer">Recovery Officer</th>
                                                	
                                                    <!-- <th width="200" class="c">Action</th> -->
                                                    
                                                    
									            </tr>
									 		</thead>
									        <tbody>
									        	<?php
												if($risk){

													$i=0;
													foreach($risk as $var){  
														if($cms->admin->role == '1' || $cms->admin->role == '2' || $cms->admin->role_type == '1'){
															?>	
															<tr>
	
															<td class="c"><?php echo $i+1; ?></td>
															<td class="c">
																<?php if($cms->admin->vborrower == '1'){ ?>
																	<a href="<?php echo url_for('/borrowers/'.$var['borrower_id']); ?>"><?php echo $var['full_name']; ?></a>
																<?php } else{
																	echo $var['full_name'];
																} ?>
															</td>
															<td class="c"><?php echo substr($var['date_created'],0,4).'0'.$var['loan_id']; ?></td>
															<td class="c"><?php echo number_format($var['amount_paid'],2,'.',','); ?></td>
															<td class="c"><?php echo ($var['paid_date']); ?></td>
															<td class="c">
															<?php if ($var['pay_type'] == 1){ echo("Both (Principal + Interest)");} ?>
															<?php if ($var['pay_type'] == 2){ echo("Interest Amount");} ?>
															<?php if ($var['pay_type'] == 3){ echo("Rescheduling");} ?>
															<?php if ($var['pay_type'] == 4){ echo("Partial Payment");} ?>
															<?php if ($var['pay_type'] == 5){ echo("Late Charges");} ?>
															<?php if ($var['pay_type'] == 6){ echo("Full Settlement");} ?></td>
															
															<td class="c"><?php echo ($var['loan_amt']); ?></td>
															<td class="c"><?php echo ($var['loan_interest_month']); ?>%</td>
															<td class="c"><?php echo ($var['officer']); ?></td>
															
		
		
															
	
													<?php
												  
													$i++;
														}	


														else if($var['admin_id'] == $cms->admin->id){
														?>	
														<tr>

														<td class="c"><?php echo $i+1; ?></td>
														<td class="c">
															<?php if($cms->admin->vborrower == '1'){ ?>
																<a href="<?php echo url_for('/borrowers/'.$var['borrower_id']); ?>"><?php echo $var['full_name']; ?></a>
															<?php } else{
																echo $var['full_name'];
															} ?>
														</td>
														<td class="c"><?php echo substr($var['date_created'],0,4).'0'.$var['loan_id']; ?></td>
														<td class="c"><?php echo number_format($var['amount_paid'],2,'.',','); ?></td>
														<td class="c"><?php echo ($var['paid_date']); ?></td>
														<td class="c">
														<?php if ($var['pay_type'] == 1){ echo("Both (Principal + Interest)");} ?>
														<?php if ($var['pay_type'] == 2){ echo("Interest Amount");} ?>
														<?php if ($var['pay_type'] == 3){ echo("Rescheduling");} ?>
														<?php if ($var['pay_type'] == 4){ echo("Partial Payment");} ?>
														<?php if ($var['pay_type'] == 5){ echo("Late Charges");} ?>
														<?php if ($var['pay_type'] == 6){ echo("Full Settlement");} ?></td>
														
														<td class="c"><?php echo ($var['loan_amt']); ?></td>
														<td class="c"><?php echo ($var['loan_interest_month']); ?>%</td>
														<td class="c"><?php echo ($var['officer']); ?></td>
														
	
	
														

												<?php
											  
												$i++;
													}	
													
													else if($var['head_id'] == $cms->admin->id){
														?>
														<tr>

														<td class="c"><?php echo $i+1; ?></td>
														<td class="c">
															<?php if($cms->admin->vborrower == '1'){ ?>
																<a href="<?php echo url_for('/borrowers/'.$var['borrower_id']); ?>"><?php echo $var['full_name']; ?></a>
															<?php } else{
																echo $var['full_name'];
															} ?>
														</td>
														<td class="c"><?php echo substr($var['date_created'],0,4).'0'.$var['loan_id']; ?></td>
														<td class="c"><?php echo number_format($var['amount_paid'],2,'.',','); ?></td>
														<td class="c"><?php echo ($var['paid_date']); ?></td>
														<td class="c">
														<?php if ($var['pay_type'] == 1){ echo("Both (Principal + Interest)");} ?>
														<?php if ($var['pay_type'] == 2){ echo("Interest Amount");} ?>
														<?php if ($var['pay_type'] == 3){ echo("Rescheduling");} ?>
														<?php if ($var['pay_type'] == 4){ echo("Partial Payment");} ?>
														<?php if ($var['pay_type'] == 5){ echo("Late Charges");} ?>
														<?php if ($var['pay_type'] == 6){ echo("Full Settlement");} ?></td>
														
														<td class="c"><?php echo ($var['loan_amt']); ?></td>
														<td class="c"><?php echo ($var['loan_interest_month']); ?>%</td>
														<td class="c"><?php echo ($var['officer']); ?></td>
														
	
	
														

														  
														   
														  
													</tr>
												<?php
											  
												$i++;
													}
													


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
		<script>
			$(function(){
				$(document).on('click', '.btn-filter-date', function(){
					date_from = $('[name="date_from"]').val();
					date_to = $('[name="date_to"]').val();

					location.href = rootPath + 'report/headcollection?date_from=' + date_from + '&date_to=' + date_to;
				});
				$(document).on('click', '.btn-export', function(){
					date_from = $('[name="date_from"]').val();
					date_to = $('[name="date_to"]').val();

					location.href = rootPath + 'report/headcollection?date_from=' + date_from + '&date_to=' + date_to + '&exportdate=1';
				});
				$(document).on('click', '.btn-export-borrower', function(){
            borrowerID = $('[name="borrowerID"]').val();

            location.href = rootPath + 'report/headcollection?borrowerID=' + borrowerID + '&exportborrower=1';
        });
		$(document).on('click', '.btn-export-officer', function(){
            adminID = $('[name="adminID"]').val();

            location.href = rootPath + 'report/headcollection?adminID=' + adminID + '&exportofficer=1';
        });

		$(document).on('click', '.btn-filter-borrower', function(){
            borrowerID = $('[name="borrowerID"]').val();

            location.href = rootPath + 'report/headcollection?borrowerID=' + borrowerID;
        });
		$(document).on('click', '.btn-filter-officer', function(){
            adminID = $('[name="adminID"]').val();

            location.href = rootPath + 'report/headcollection?adminID=' + adminID;
        });
			});
				</script>