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
								<h2><strong>Applications</strong> Management</h2>
                                <div class="additional-btn toolbar-action">
									<a href="<?php echo url_for('/applications/insert'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Insert New</a>
								</div>
							</div>
                            
							<div class="widget-content">
								<br>					
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									        <thead>
									            <tr>
                                                	<th class="c">Customer Name</th>
                                                	<th class="c">Terms</th>
                                                	<th class="c">Installment</th>
                                                    <th width="200" class="c">Interest</th>
									                <th width="150" class="c">Principal</th>
                                                    <th width="150" class="c">Start Amount</th>
                                                    <th width="150" class="c">End Amount</th>
                                                    <th width="120"></th>
									            </tr>
									 		</thead>
									        <tbody>
                                            <?php
												if($keys){
													foreach($keys as $key){
											?>
									            <tr>
                                                	<td class="c"><?php echo $key['customer_name']; ?></td>
                                                	<td class="c"><?php echo $key['app_home_name']; ?></td>
													<?php if ($key['credit_score'] == NULL || $key['credit_score'] <= 0){ ?>
														<td class="c">
															<form method='POST' action='../api/api.php'>
																<input type="hidden" name="cust_id" value="<?php echo $key['cust_id']; ?>">
																<input type="submit" value="Get Scoring">
															</form>
														
														</td>
													<?php }else{ ?>
														<td class="c"><?php echo $key['credit_score']; ?>/10</td>
													<?php } ?>
                                                    <td class="c"><?php echo $key['app_years']; ?></td>
                                                    <td class="c"><?php echo ucwords($key['app_home_location']); ?></td>
                                                    <td class="c"><?php echo mstatus($key['app_status']); ?></td>
									                <td class="text-center">
                                                        <a class="btn btn-primary btn-xs" href="<?php echo url_for('applications/'.$key['app_id']); ?>" title="Edit"><span class="icon-pencil"></span></a>
                                                        <a class="btn btn-danger btn-xs delete" href="#" title="Delete" data-type="application" data-id="<?php echo $key['cust_id']; ?>"><span class="icon-trash"></span></a>
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
