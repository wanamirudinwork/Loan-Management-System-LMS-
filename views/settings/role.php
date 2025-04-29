		<!-- Start right content -->
        <div class="content-page">
			<!-- ============================================================== -->
			<!-- Start Content here -->
			<!-- ============================================================== -->
            <div class="content">
				<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='fa fa-gear'></i> Settings</h1>
				</div>
            	<!-- Page Heading End-->	
								
				<!-- Your awesome content goes here -->
                <div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>Role</strong> Management</h2>
								<div class="additional-btn toolbar-action">
									<a href="<?php echo url_for('/role/insert'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Insert New</a>
								</div>
							</div>
                            
							<div class="widget-content">
								<br>					
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									        <thead>
									            <tr>
									                <th class="pointer">No.</th>
									                <th class="pointer">Role Type</th>
									                <th class="text-center pointer">Status</th>
                                                    <th class="text-center pointer">Created On</th>
                                                    <th class="text-center pointer">Last Updated</th>
									                <th class="text-center" width="50">Actions</th>
									            </tr>
									 		</thead>
									        <tbody>
                                            <?php
												$no = 1;
												
												if($roles){
													foreach($roles as $keys){
											?>
									            <tr>
									                <td><?php echo $no; ?></td>
									                <td><?php echo $keys[ 'role_name'];?></td>
									                <td class="text-center"><?php echo lstatus($keys[ 'role_status']); ?></td>
                                                    <td class="text-center"><?php echo dateTimeFormat($keys['date_created']); ?></td>
													<td class="text-center"><?php echo dateTimeFormat($keys['date_updated']); ?></td>
									                <td class="text-center">
                                                        <a href="<?php echo url_for('role/'.$keys['role_id']); ?>" title="Edit"><span class="icon-pencil"></span></a>
                                                    <?php if($keys['role_id'] != '1' ){ ?>
                                                        <a href="javascript:;" class="delete" data-type="role" data-id="<?php echo $keys['role_id']; ?>" title="Delete"><span class="icon-trash"></span></a>
                            						<?php } ?>
                                                    </td>
									            </tr>
                                            <?php
														$no++;
													}
												}
											?>
									        </tbody>
									    </table>
									</form>
								</div>
							</div>
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
