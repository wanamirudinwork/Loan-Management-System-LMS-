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
								<h2><strong>Administrator</strong> Management</h2>
								<div class="additional-btn toolbar-action">
									<a href="<?php echo url_for('/admin/insert'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Insert New</a>
								</div>
							</div>
                            
							<div class="widget-content">
								<br>					
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									        <thead>
									            <tr>
									                <th class="pointer">Username</th>
									                <th class="pointer">Fullname</th>
									                <th class="pointer">Contact</th>
									                <th class="pointer">Role</th>
									                <th class="text-center pointer">Status</th>
                                                    <th class="pointer">Registered At & Last Activity</th>
									                <th class="text-center" width="50">Actions</th>
									            </tr>
									 		</thead>
									        <tbody>
                                            <?php
												if($admins){
													foreach($admins as $keys){
											?>
									            <tr>
									                <td><?php echo $keys[ 'admin_username']; ?></td>
									                <td><?php echo $keys[ 'admin_name'];?></td>
									                <td><?php echo $keys[ 'admin_contact']; ?><br/><?php echo $keys[ 'admin_email']; ?></td>
									                <td><?php echo $keys[ 'admin_type']; ?></td>
									                <td class="text-center"><?php echo lstatus($keys[ 'admin_status']); ?></td>
                                                    <td><?php echo dateTimeFormat($keys['admin_registered']); ?><br/><?php echo dateTimeFormat($keys['admin_last_activity']); ?></td>
									                <td class="text-center">
                                                        <a href="<?php echo url_for('admin/'.$keys['admin_id']); ?>" title="Edit"><span class="icon-pencil"></span></a>
                                                    <?php if($keys['admin_id'] != '1' ){ ?>
                                                        <a href="javascript:;" class="delete" data-type="admin" data-id="<?php echo $keys['admin_id']; ?>" title="Delete"><span class="icon-trash"></span></a>
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
					</div>
                    
				<!-- End of your awesome content -->
			
            <?php echo partial('copy.php'); ?>

            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->
