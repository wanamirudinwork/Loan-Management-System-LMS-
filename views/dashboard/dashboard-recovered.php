
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
				<!-- Your awesome content goes here -->
                <div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>Total Recovered</strong>  List</h2>
									<div class="additional-btn toolbar-action">
									
								</div>
                            </div>
                            

							<div class="widget-content">

								<br>		
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									        <thead>
									            <tr>
                                                	<th class="c pointer">No.</th>
                                                	<th class="c pointer">Borrower Name</th>
                                                	<th class="c pointer">Collection Date</th>
                                                    <th class="c pointer">Month</th>
                                                	<th width="250 "class="c pointer">Collection Amount (RM)</th>
                                                    <!-- <th width="200" class="c">Action</th> -->
                                                    
                                                    
									            </tr>
									 		</thead>
									        <tbody>
									        	<?php
												if($risk){

													$i=0;
													foreach($risk as $var){  
													
													
												?>
													
									            <tr>

                                                	<td class="c"><?php echo $i+1; ?></td>
                                                	<td class="c">
                                                        <a href="<?php echo url_for('/borrowers/'.$var['borrower_id']); ?>"><?php echo $var['full_name']; ?></a>
                                                    </td>
                                                	<td class="c"><?php echo ($var['paid_date']); ?></td>
                                                    <td class="c"><?php echo (determineMonth(date('n',strtotime($var['paid_date'])))); ?></td>
                                                	
                                                	<td class="c"><?php echo number_format($var['amount_paid'],2,'.',','); ?></td>


                                                	
<!--                                                   
                                                    <td>
                                                    <!-- <?php if($cms->admin->mrisk == '1'){ ?>
                                                        <a class="btn btn-danger c" href="<?php echo url_for('/risk/update/'.$var['recovery_id']); ?>" title="Edit"  > CONFIRM <span class="icon-pencil"></span></a>
                                                    <?php } ?> -->
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
