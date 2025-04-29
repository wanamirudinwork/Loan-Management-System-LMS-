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
						<h2><strong>Insert</strong> Admin</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="username" value="">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" placeholder="********" name="password">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Confirm Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" placeholder="********" name="confirmPassword">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Full Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name" value="">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Contact Number</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="contact" value="">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Email Address</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email" value="">
								</div>
							</div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Role</label>
                            	<div class="col-sm-10">
                            		<select class="form-control selectpicker" name="role">
									<?php
												if($role){
													foreach($role as $keys){
											?>
										<option value="<?php echo $keys['role_id']; ?>"><?php echo $keys['role_name']; ?></option>
										
										<?php
													}
												}
										?>
									</select>
                            	</div>
                            </div>
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Insert New">
                                    <input type="button" class="btn btn-default back" value="Cancel">
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
