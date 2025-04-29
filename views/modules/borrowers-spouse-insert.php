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
            		<h1><i class='fa fa-list'></i> Spouse</h1>
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
						<h2><strong>Insert</strong> Spouse</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							
                            <div class="form-group">
								<label class="col-sm-2 control-label phone">Full Name</label>
                                <div class="col-sm-3">
                                    <input type="text"  maxlength="100" class="form-control" name="full_name" value="" required >
                                </div>
								<label class="col-sm-1 control-label">Gender</label>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="gender">
                                        <option value="Male"><?php echo gender_type('1'); ?></option>
                                        <option value="Female"><?php echo gender_type('2'); ?></option>
                                    </select>
                                </div>
								<label class="col-sm-1 control-label">DOB</label>
								<div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="dob" style="z-index: 1;" value="">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
							</div>                            
							<div class="form-group">
                                <label class="col-sm-2 control-label">Nationality *</label>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="nationality">
									<?php foreach($countries as $keys){ ?>
										<?php if($keys['id'] == 129) { ?>
											<option selected value="<?php echo $keys['id']; ?>"><?php echo $keys['name']; ?></option>
										<?php }else{ ?>
											<option value="<?php echo $keys['id']; ?>"><?php echo $keys['name']; ?></option>
										<?php } ?>                                        
                                    <?php } ?>
									</select>
                                </div>
								
                                <label class="col-sm-2 control-label">NRIC(New) *</label>
                                <div class="col-sm-2">
                                    <input type="text" id="nric_format" maxlength="14" class="form-control nric-number" name="nric_new" required value="">
                                </div>
								<label class="col-sm-1 control-label">NRIC(Old)</label>
                                <div class="col-sm-2" id="contacts">
                                    <input type="text" class="form-control" maxlength="14" name="nric_old"  value="">
                                </div>
                            </div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Resident Address</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="resident_address"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">NRIC Address</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="nric_address"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Resident Address2</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="resident_address2"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Remarks</label>
								<div class="col-sm-5">
									<textarea class="form-control" style="text-transform: uppercase;" name="remarks"></textarea>
								</div>
								<label class="col-sm-2 control-label">Marital Status</label>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="marital">
                                        <option value="Single"><?php echo marital_status('1'); ?></option>
                                        <option value="Married"><?php echo marital_status('2'); ?></option>
										<option value="Divorced"><?php echo marital_status('3'); ?></option>
										<option value="Widowed"><?php echo marital_status('4'); ?></option>
                                    </select>
                                </div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Race</label>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="race">
                                        <option value="Chinese">Chinese</option>
                                        <option value="Indian">Indian</option>
										<option value="Malay">Malay</option>
										<option value="Others">Others</option>
                                    </select>
                                </div>	
								<!-- <label class="col-sm-1 control-label phone">Mobile1</label>
                                <div class="col-sm-2">
                                    <input required pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile1" value=""  >
                                </div>
								<label class="col-sm-1 control-label phone">Mobile2</label>
                                <div class="col-sm-3">
                                    <input required pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile2" value=""  >
                                </div>							 -->
                            </div>
							<div class="form-group">
								<a class="btn btn btn-primary" onclick="addMobileNumber()">Add</a>
								<label class="col-sm-2 control-label phone">Mobile</label>
                                <div class="col-sm-4">
                                    <input pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile_input" value="" >
                                </div>
							</div>
							<div class="mobile-list">
							</div>
							<hr>
								<!-- <input type="hidden" name="admin_id" value="<?php echo $cms->admin->id; ?>"> -->
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Add">
									<a href="<?php echo url_for('/borrowers/'.$borrower_id); ?>/#spouse"><input type="button" class="btn btn-default" value="Back"> </a>
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
