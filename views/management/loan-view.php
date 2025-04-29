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
					$borrower_id = $url[2];
					// Bottom is for localhost
					//$borrower_id = $url[3];
					
				
					//print_r($_SESSION);
				?>
				<!-- Your awesome content goes here -->
                <div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>Loan</strong> Management</h2>
                                <?php
                                if($borrowerID['borrower_status'] == '1'){
                                        if($cms->admin->mloan == '1'){ ?>
                                    <div class="additional-btn toolbar-action">
                                        <a href="<?php echo url_for('/loan/insert/'.$borrowerID['borrower_id']); ?> " class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Insert New</a>
                                    </div>
                                <?php }} else{ ?>
                                    <!-- not approved borrower not allowed to insert new loan -->
                                <?php } ?>
							</div>
                            <?php //var_dump($borrower); ?>
							<div class="widget-content">
								<br>					
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									        <thead>
									            <tr>
									            	<th class="c pointer">No. </th>
                                                	<th class="c pointer">Borrower Name</th>
                                                	<th width="250 "class="c pointer">Loan Amount (RM)</th>
                                                    <th width="150" class="c pointer">Terms (Years)</th>
                                                    <th width="150" class="c pointer">Interest (%)</th>
                                                    <th width="200" class="c pointer">Created By</th>
                                                    <th width="150" class="c pointer">Loan Status</th>
                                                    <th width="150" class="c">Actions</th>
									            </tr>
									 		</thead>
									        <tbody>
                                            <?php
												if($keys){
													$i =0;
													foreach($keys as $key){
											?>
									            <tr>
									            	<td class="c"><?php echo $i+1 ?></td>
                                                    <?php
                                                    if($key['loan_status'] == '1' || $key['loan_status'] == '8' || $key['loan_status'] == '990'){ ?>
                                                        <td class="c" width="25%"><a href="<?php echo url_for('/report/collection-schedule-view-report-id/' .$key['borrower_id']. '/' .$key['loan_id']); ?>"><?php echo $key['borrower'] ?></a></td>
                                                    <?php }else{ ?>
                                                        <td class="c" width="25%"><a href="<?php echo url_for('/borrowers/'.$key['borrower_id']); ?>"><?php echo $key['borrower'] ?></a></td>
                                                    <?php } ?>
                                                	<td class="c"><?php echo number_format($key['loan_amt'],2,'.',','); ?></td>
                                                    <?php if ($key['loan_term'] > 0){ ?>
                                                        <td class="c"><?php echo $key['loan_term']; ?></td>
                                                    <?php }else{ ?>
                                                        <td class="c">Interest Only</td>
                                                    <?php }	?>
                                                    <td class="c"><?php echo $key['loan_interest_month']; ?>%</td>
                                                    <td class="c"><?php echo $key['user']; ?></td>
                                                    <td class="c"><?php echo default_status ($key['loan_status']); ?></td>
									                <td class="text-center">
                                                    <?php if($cms->admin->mloan == '1'){ ?>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo url_for('loan/update/'.$key['loan_id']); ?>" title="Edit" ><span class="icon-pencil"></span></a>
                                                    <?php } ?>
                                                    <?php if($cms->admin->dloan == '1'){ ?>
                                                        <a href="javascript:;" class="btn btn-danger btn-xs delete" data-type="loan" data-id="<?php echo $key['loan_id']; ?>" title="Delete" <?php if($key['loan_status']=='3') echo "disabled"; ?>><span class="icon-trash"></span></a>
													<?php } ?>
                                                    </td>
									            </tr>
                                            <?php
                                            $i++;
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
