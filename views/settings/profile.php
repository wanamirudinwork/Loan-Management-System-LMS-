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
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Update</strong> Profile</h2>
					</div>
					<div class="widget-content padding">
						<form id="selfForm" class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" value="<?php echo $keys['admin_username']; ?>" disabled>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" placeholder="********" name="Password">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Confirm Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" placeholder="********" name="ConfirmPassword">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Full Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name" value="<?php echo $keys['admin_name']; ?>">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Contact Number</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="contact" value="<?php echo $keys['admin_contact']; ?>">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Email Address</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email" value="<?php echo $keys['admin_email']; ?>">
								</div>
							</div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Status</label>
                            	<div class="col-sm-10">
                            		<select class="form-control selectpicker" disabled>
										<option value="1"><?php echo lstatus($keys['admin_status']);?></option>
									</select>
                            	</div>
                            </div>
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-default" value="Save">
								</div>
							</div>
						</form>
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
        
