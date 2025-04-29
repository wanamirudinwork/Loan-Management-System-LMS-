		<!-- Start right content -->
		<script>
		function addHyphen () {
			var phone = $(".phone").val();
			alert(phone);
			
		}
	</script>
        <div class="content-page">
			<!-- ============================================================== -->
			<!-- Start Content here -->
			<!-- ============================================================== -->
            <div class="content">
				<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='fa fa-list'></i> Employment</h1>
				</div>
            	<!-- Page Heading End-->	
				<?php
				
				$url = explode("/", $_GET['uri']);
				$borrower_id = $url[3];
				
				//print_r($borrower_id);
				
				
				?>
								
				<!-- Your awesome content goes here -->
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Insert</strong> Employment</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							
                            <div class="form-group">
								<label class="col-sm-2 control-label phone">Employer Name</label>
                                <div class="col-sm-3">
                                    <input type="text"  maxlength="100" class="form-control" name="employer_name" value="" required >
                                </div>
								<label class="col-sm-2 control-label phone">Designation</label>
                                <div class="col-sm-3">
                                    <input type="text" maxlength="100" class="form-control" name="designation" value="" required >
                                </div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label phone">Salary Range (RM)</label>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="14" class="form-control" name="salary_range" value="" placeholder="RM" >
                                </div>
                                <label class="col-sm-1 control-label phone">Paydate</label>
                                <div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="pay_date" style="z-index: 1;" required>
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
                                <label class="col-sm-2 control-label phone">Advanced Paydate</label>
                                <div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="advance_date" style="z-index: 1;" >
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
                            </div>
							<div class="form-group">
								<label class="col-sm-2 control-label phone">Staff ID</label>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="100" class="form-control" name="staff_id" value=""  >
                                </div>
								<label class="col-sm-1 control-label phone">Hired On</label>
                                <div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="hired_on" style="z-index: 1;">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
								<label class="col-sm-2 control-label phone">Department</label>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="100" class="form-control" name="department" value=""  >
                                </div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Address</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="address"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label phone">Work Location</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="100" class="form-control" name="work_location" value=""  >
                                </div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label phone">Phone</label>
                                <div class="col-sm-3">
                                    <input type="text" maxlength="20" class="form-control mobile-number" name="phone" value=""  >
                                </div>
								<label class="col-sm-2 control-label phone">Fax</label>
                                <div class="col-sm-3">
                                    <input type="text" maxlength="20" class="form-control" name="fax" value=""  >
                                </div>															
							</div>
							
							<hr>
								<!-- <input type="hidden" name="admin_id" value="<?php echo $cms->admin->id; ?>"> -->
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Add">
									<a href="<?php echo url_for('/borrowers/'.$borrower_id); ?>/#employment"><input type="button" class="btn btn-default" value="Back"> </a>
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
