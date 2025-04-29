
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
				<?php //print_r($recovery); ?>
				<?php //print_r($cms->admin->id); ?>
				<!-- Your awesome content goes here -->
                <div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>Total Bad Debt</strong>  List (until <?php echo date('F Y'); ?>)</h2>
									<div class="additional-btn toolbar-action">
									<a href="#" class="btn btn-primary btn-xs btn-export-officer"><i class="fa fa-plus-circle"></i> Export By officer</a>
								</div>
                            </div>
                            

							<div class="widget-content">
                            <form class="form-inline" role="form">
                        <div class="form-group" style="padding: 10px 20px;">
                            <label class="control-label">Officer Name</label>
                            <select id="adminID" class="form-control " name="adminID">
                                <option value=""> All </option>
                                <?php
                                if($selectofficername){
                                    foreach($selectofficername as $selection){ if($selection['admin_id'] == $cms->admin->id){
										?>{
											<option value="<?php echo $selection['admin_id']; ?>" <?php echo $selection['admin_id'] == $admin_id ? ' selected' : ''; ?>><?php echo $selection['admin_name'];?></option>
										<?php 
										}
										if($selection['head_id'] == $cms->admin->id){
											?>{
												<option value="<?php echo $selection['admin_id']; ?>" <?php echo $selection['admin_id'] == $admin_id ? ' selected' : ''; ?>><?php echo $selection['admin_name'];?></option>
											<?php 
											}
											if($cms->admin->role == '1' || $cms->admin->role == '2' || $cms->admin->role_type == '1'){
												?>{
													<option value="<?php echo $selection['admin_id']; ?>" <?php echo $selection['admin_id'] == $admin_id ? ' selected' : ''; ?>><?php echo $selection['admin_name'];?></option>
												<?php 
												}
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
                                                	<th class="c pointer">Loan ID</th>
                                                	<th class="c pointer">Payment Date</th>
                                                    <th class="c pointer">Month</th>
                                                    <th class="c pointer">Recovery Officer</th>
                                                	<th width="250 "class="c pointer">Collection Amount (RM)</th>
									            </tr>
									 		</thead>
									        <tbody>
									        	<?php
												if($recovery){

													$i=1;
													foreach($recovery as $var){

                                                        if($cms->admin->role == '1' || $cms->admin->role == '2' || $cms->admin->role_type == '1'){

                                                            if(strtotime($var['payment_date']) <= strtotime(date("d-m-Y"))){
                                                                $tr_class = "style='background-color:#FFFACD;'";
                                                            }else{
                                                                $tr_class = "";
                                                            } ?>

                                                            <tr <?php echo $tr_class; ?>>
                                                                <td class="c"><?php echo $i; ?></td>
                                                                <td class="c">
                                                                    <a href="<?php echo url_for('/borrowers/'.$var['borrower_id']); ?>"><?php echo $var['borrower']; ?></a>
                                                                </td>
                                                                <td class="c"><?php echo substr($var['date_created'],0,4).'0'.$var['loan_id']; ?></td>
                                                                <td class="c"><?php echo ($var['payment_date']); ?></td>
                                                                <td class="c"><?php echo (determineMonth($var['Months'])); ?></td>
                                                                <td class="c"><?php echo ($var['admin_name']); ?></td>
                                                                <td class="c"><?php echo number_format($var['installment_amt'],2,'.',','); ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }

                                                        else if($var['admin_id'] == $cms->admin->id){

                                                            if(strtotime($var['payment_date']) <= strtotime(date("d-m-Y"))){
                                                                $tr_class = "style='background-color:#FFFACD;'";
                                                            }else{
                                                                $tr_class = "";
                                                            }



                                                            ?>

                                                            <tr <?php echo $tr_class; ?>>
                                                                <td class="c"><?php echo $i; ?></td>
                                                                <td class="c">
                                                                    <a href="<?php echo url_for('/borrowers/'.$var['borrower_id']); ?>"><?php echo $var['borrower']; ?></a>
                                                                </td>
                                                                <td class="c"><?php echo substr($var['date_created'],0,4).'0'.$var['loan_id']; ?></td>
                                                                <td class="c"><?php echo ($var['payment_date']); ?></td>
                                                                <td class="c"><?php echo (determineMonth($var['Months'])); ?></td>
                                                                <td class="c"><?php echo ($var['admin_name']); ?></td>
                                                                <td class="c"><?php echo number_format($var['installment_amt'],2,'.',','); ?></td>
                                                            </tr>
													<?php
                                                            $i++;
														}

                                                        else if($var['head_id'] == $cms->admin->id){

                                                            if(strtotime($var['payment_date']) <= strtotime(date("d-m-Y"))){
                                                                $tr_class = "style='background-color:#FFFACD;'";
                                                            }else{
                                                                $tr_class = "";
                                                            }



                                                            ?>

                                                            <tr <?php echo $tr_class; ?>>
                                                                <td class="c"><?php echo $i; ?></td>
                                                                <td class="c">
                                                                    <a href="<?php echo url_for('/borrowers/'.$var['borrower_id']); ?>"><?php echo $var['borrower']; ?></a>
                                                                </td>
                                                                <td class="c"><?php echo substr($var['date_created'],0,4).'0'.$var['loan_id']; ?></td>
                                                                <td class="c"><?php echo ($var['payment_date']); ?></td>
                                                                <td class="c"><?php echo (determineMonth($var['Months'])); ?></td>
                                                                <td class="c"><?php echo ($var['admin_name']); ?></td>
                                                                <td class="c"><?php echo number_format($var['installment_amt'],2,'.',','); ?></td>
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
        $(document).on('click', '.btn-filter-officer', function(){
            adminID = $('[name="adminID"]').val();

            location.href = rootPath + 'dashboard-bad-debt?adminID=' + adminID;
        });
        $(document).on('click', '.btn-export-officer', function(){
            adminID = $('[name="adminID"]').val();

            location.href = rootPath + 'dashboard-bad-debt?adminID=' + adminID + '&exportofficer=1';
        });

    });
				</script>