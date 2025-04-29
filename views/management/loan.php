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
								<h2><strong>Loan</strong> Management</h2>
                                <div class="additional-btn toolbar-action">
                                    <?php if($cms->admin->mloan == '1'){ ?>
									<a href="<?php echo url_for('/loan/insert'); ?> " class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Insert New</a>
                                    <?php } ?>
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
									            	<th class="c pointer">No. </th>
                                                	<th class="c pointer">Borrower Name</th>
                                                	<th class="c pointer">Loan ID</th>
                                                	<th width="250 "class="c pointer">Loan Amount (RM)</th>
                                                    <th width="150" class="c pointer">Terms (Years)</th>
                                                    <th width="150" class="c pointer">Interest (%)</th>
                                                    <th width="200" class="c pointer">Created By</th>
                                                    <th width="150" class="c pointer">Loan Status</th>
													<th width="150" class="c pointer">Rejection Reason</th>
                                                    <th width="150" class="c">Actions</th>
									            </tr>
									 		</thead>
									        <tbody>
                                            <?php
												if($keys){
													$i =0;
													foreach($keys as $key){
														
														if($key['loan_term'] == 0 || $key['loan_term'] == ""){
															$key['loan_term'] = "Interest Only";
														}

                                                        if($cms->admin->mapproval == '1' && ($key['loan_status'] == '5' || $key['loan_status'] == '2' || $key['loan_status'] == '6')){
                                                            $tr_class = "style='background-color:#FFFACD;'";
                                                        }else if($cms->admin->vapproval == '1' && $cms->admin->mapproval == '0' && ($key['loan_status'] == '3' || $key['loan_status'] == '7')){
                                                            $tr_class = "style='background-color:#FFFACD;'";
                                                        }else{
                                                            $tr_class = "";
                                                        } ?>

                                                <tr <?php echo $tr_class; ?>>
									            	<td class="c"><?php echo $i+1 ?></td>
                                                	<td class="c" width="25%">
                                                        <a href="<?php echo url_for('/borrowers/'.$key['borrower_id']); ?>"><?php echo $key['borrower'] ?></a>
                                                    </td>
													<td class="c"><?php echo substr($key['date_created'],0,4).'0'.$key['loan_id']; ?></td>
                                                	<td class="c"><?php echo number_format($key['loan_amt'],2,'.',','); ?></td>
                                                	<td class="c"><?php echo $key['loan_term']; ?></td>
                                                    <td class="c"><?php echo $key['loan_interest_month']; ?>%</td>
                                                    <td class="c"><?php echo $key['user']; ?></td>
                                                    <td class="c"><?php echo default_status ($key['loan_status']); ?></td>
                                                    <?php if($key['loan_status'] == '3' || $key['loan_status'] == '7'){ ?>
                                                        <td class="c"><?php echo ($key['rejection']); ?></td>
                                                    <?php } else{?>
                                                        <td class="c">-</td>
                                                    <?php } ?>
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
