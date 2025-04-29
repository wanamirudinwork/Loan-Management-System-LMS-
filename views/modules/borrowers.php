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
								<h2><strong>Borrower</strong> Management</h2>
                                <div class="additional-btn toolbar-action">
                                    <?php if($cms->admin->mborrower == '1'){ ?>
									<a href="<?php echo url_for('/borrowers/insert'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Insert New</a>
                                    <?php } ?>
                                </div>
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
                                                	<th width="30%" class="c pointer" >Name</th>
                                                	<th width="20%" class="c pointer" >NRIC</th>
                                                	<th width="10%" class="c pointer" >Recovery Officer</th>
                                                    <th width="150" class="c pointer" >Source</th>
                                                	<th width="20%" class="c pointer" >Date Created</th>
                                                    <th width="150" class="c pointer" >Borrower Status</th>
													<th width="20%" class="c pointer" >Rejection Reason</th>
                                                    <th width="15%" class="c" >Actions</th>

									            </tr>
									 		</thead>
									        <tbody>
                                            <?php
												if($keys){
													foreach($keys as $key){

                                                        if($cms->admin->mapproval == '1' && ($key['borrower_status'] == '2' || $key['pending_approval'] == '2')){
                                                            $tr_class = "style='background-color:#FFFACD;'";
                                                        }else if($cms->admin->vapproval == '1' && $cms->admin->mapproval == '0' && ($key['borrower_status'] == '3' || $key['borrower_status'] == '5' || $key['borrower_status'] == '4')){
                                                            $tr_class = "style='background-color:#FFFACD;'";
                                                        }else{
                                                            $tr_class = "";
                                                        } ?>

                                                <tr <?php echo $tr_class; ?>>
									            	<!--td><input type="checkbox" name="export[]" value="<?php echo $key['borrower_id'] ?>"></td-->
                                                	<td><?php echo $key['full_name']; ?></td>
                                                	<td class="c"><?php echo $key['nric_new']; ?></td>
                                                	<td class="c">
                                                        <?php
                                                        if(!empty($key['agent'])){
                                                            echo $key['agent'];
                                                        }else{
                                                            echo "";
                                                        } ?>
                                                    </td>
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
                                                    <?php } if($key['borrower_status'] == '3'){ ?>
                                                        <td class="c"><?php echo ($key['rejection']); ?></td>
                                                    <?php } else{?>
                                                        <td class="c">-</td>
                                                    <?php } ?>
									                <td class="text-center">
                                                    <?php if($cms->admin->mborrower == '1'){ ?>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo url_for('borrowers/'.$key['borrower_id']); ?>" title="Edit"><span class="icon-pencil"></span></a>
                                                    <?php } ?>
													<!-- <?php if($cms->admin->dborrower == '1'){ ?>
                                                        <a class="btn btn-danger btn-xs delete-borrower-list" href="#" title="Delete" data-url="borrowers" data-action="delete" data-bid="<?php echo $key['borrower_id']; ?>"><span class="icon-trash"></span></a>
													<?php } ?> -->
													<?php if($cms->admin->dborrower == '1'){ ?>
                                                        <a href="javascript:;" class="btn btn-danger btn-xs delete" data-type="borrower" data-id="<?php echo $key['borrower_id']; ?>" title="Delete" <?php if($key['borrower_status']=='4') echo "disabled"; ?>><span class="icon-trash"></span></a>
                                                    <?php } ?>
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
