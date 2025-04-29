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
								<h2><strong>Total Borrowers</strong> List</h2>
							</div>
                            
							<div class="widget-content">
								<br>					
								<div class="table-responsive">
									<form class='form-horizontal' id="selfForm" role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
										  <!--div style="padding:2%;"><button type="submit">Export to CSV</button></div-->
									        <thead>
									            <tr>
									            	<!--th width="5%" class="c" >Export</th-->
                                                    <th class="c pointer">No.</th>
                                                	<th width="30%" class="c pointer" >Name</th>
                                                	<th width="20%" class="c pointer" >NRIC</th>
                                                    <th width="150" class="c pointer" >Source</th>
                                                	<th width="20%" class="c pointer" >Date Created</th>
                                                    <th width="150" class="c pointer" >Borrower Status</th>

									            </tr>
									 		</thead>
									        <tbody>
                                            <?php
												if($keys){

                                                    $i=1;
													foreach($keys as $key){ ?>

                                                <tr>
									            	<!--td><input type="checkbox" name="export[]" value="<?php echo $key['borrower_id'] ?>"></td-->
                                                    <td class="c"><?php echo $i; ?></td>
                                                    <td>
                                                        <a href="<?php echo url_for('/borrowers/'.$key['borrower_id']); ?>"><?php echo $key['full_name']; ?></a>
                                                    </td>
                                                	<td class="c"><?php echo $key['nric_new']; ?></td>
                                                    <td class="c">
                                                        <?php
                                                        if($key['source'] != '1'){
                                                            echo "CTOS";
                                                        }else{
                                                            echo "Manual";
                                                        } ?>
                                                    </td>
                                                	<td class="c"><?php echo $key['created']; ?></td>
                                                    <?php if($key['pending_approval'] == '2'){ ?>
                                                        <td class="c"><?php echo borrower_restatus ($key['borrower_status']); ?></td>
                                                    <?php } else{ ?>
                                                        <td class="c"><?php echo borrower_status ($key['borrower_status']); ?></td>
                                                    <?php } ?>
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
