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
            		<h1><i class='fa fa-list'></i> Guarantor</h1>
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
						<h2><strong>Insert</strong> Guarantor</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
						<div class="form-group">
                                <label class="col-sm-2 control-label">Profile Photo</label>
                                <div class="col-sm-10">
									<div class="multiImg">
										<img onerror="this.src='<?php echo ROOTPATH; ?>images/noimage.png'" src="<?php echo imgCrop(''); ?>" style="display:table;margin:5px;max-width:200px;max-height:100px;">
										<input id="photo_1" name="photo_1" value="<?php echo $key['documents']['photo_1']; ?>" type="hidden">
										<a href="javascript:void(0)" onclick="kcFinderB('photo_1')">Browse</a> | <a href="javascript:void(0)" onclick="kcFinderC('photo_1')">Cancel</a>
									</div>
									<div class="multiImg">
										<img onerror="this.src='<?php echo ROOTPATH; ?>images/noimage.png'" src="<?php echo imgCrop(''); ?>" style="display:table;margin:5px;max-width:300px;max-height:100px;">
										<input id="photo_2" name="photo_2" value="<?php echo $key['documents']['photo_2']; ?>" type="hidden">
										<a href="javascript:void(0)" onclick="kcFinderB('photo_2')">Browse</a> | <a href="javascript:void(0)" onclick="kcFinderC('photo_2')">Cancel</a><br>
										
									</div>
									<div class="multiImg">
										<img onerror="this.src='<?php echo ROOTPATH; ?>images/noimage.png'" src="<?php echo imgCrop(''); ?>" style="display:table;margin:5px;max-width:300px;max-height:100px;">
										<input id="photo_3" name="photo_3" value="<?php echo $key['documents']['photo_3']; ?>" type="hidden">
										<a href="javascript:void(0)" onclick="kcFinderB('photo_3')">Browse</a> | <a href="javascript:void(0)" onclick="kcFinderC('photo_3')">Cancel</a>
										
									</div>
                                </div>
                            </div>							
                            <div class="form-group">
								<label class="col-sm-2 control-label">Full Name</label>
                                <div class="col-sm-2">
                                    <input type="text"  maxlength="100" class="form-control" name="full_name" value="" required >
                                </div>
								
								<label class="col-sm-1 control-label">Relation</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="relation" value="" required>
                                    <!-- <select class="form-control selectpicker" name="relation">
                                        <option value="BROTHER"><?php echo relation_type('1'); ?></option>
                                        <option value="BROTHER"><?php echo relation_type('2'); ?></option>
										<option value="COUSIN"><?php echo relation_type('3'); ?></option>
										<option value="DAUGHTER"><?php echo relation_type('4'); ?></option>
										<option value="FATHER"><?php echo relation_type('5'); ?></option>
										<option value="FRIEND"><?php echo relation_type('6'); ?></option>
										<option value="HUSBAND"><?php echo relation_type('7'); ?></option>
										<option value="MOTHER"><?php echo relation_type('8'); ?></option>
										<option value="MOTHER"><?php echo relation_type('9'); ?></option>
										<option value="RECOMMENDER"><?php echo relation_type('10'); ?></option>
										<option value="SISTER"><?php echo relation_type('11'); ?></option>
										<option value="SISTER"><?php echo relation_type('12'); ?></option>
										<option value="SON"><?php echo relation_type('13'); ?></option>
										<option value="SON"><?php echo relation_type('14'); ?></option>
										<option value="SPOUSE"><?php echo relation_type('15'); ?></option>
										<option value="UNCLE"><?php echo relation_type('16'); ?></option>
										<option value="WIFE"><?php echo relation_type('17'); ?></option>
										<option value="WIFE"><?php echo relation_type('18'); ?></option>
                                    </select> -->
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
								
                                <label class="col-sm-2 control-label">NRIC(New) *</label>
                                <div class="col-sm-4">
                                    <input type="text" id="nric_format" maxlength="14" class="form-control nric-number" name="nric_new" required value="">
                                </div>
								<label class="col-sm-1 control-label">NRIC(Old)</label>
                                <div class="col-sm-4" id="contacts">
                                    <input type="text" class="form-control " maxlength="14" name="nric_old"  value="">
                                </div>
                            </div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Resident Address</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="residence_address"></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Other Address</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="other_address"></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Mobile1</label>
                                <div class="col-sm-4">
                                    <input pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile1" value="" >
                                </div>
								<label class="col-sm-1 control-label">Mobile2</label>
                                <div class="col-sm-4">
                                    <input pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile2" value=""  >
                                </div>							
                            </div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Employer Name</label>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="100" class="form-control" name="employer_name" value=""  >
                                </div>
								<label class="col-sm-1 control-label">Designation</label>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="100" class="form-control" name="designation" value=""  >
                                </div>	
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Staff ID</label>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="100" class="form-control" name="staff_id" value=""  >
                                </div>
								<label class="col-sm-1 control-label">Hired On</label>
                                <div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="hired_on" style="z-index: 1;">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
								<label class="col-sm-2 control-label">Department</label>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="100" class="form-control" name="department" value=""  >
                                </div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Employer Address</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="employer_address"></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Work Location</label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="100" class="form-control" name="work_location" value=""  >
                                </div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="12" class="form-control mobile-number" name="phone" value=""  >
                                </div>
								<label class="col-sm-1 control-label">Fax</label>
                                <div class="col-sm-4">
									<input type="text" maxlength="12" class="form-control" name="fax" value=""  >
								</div>
							</div>

							<hr>
								<!-- <input type="hidden" name="admin_id" value="<?php echo $cms->admin->id; ?>"> -->
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Add">
									<a href="<?php echo url_for('/borrowers/'.$borrower_id); ?>/#guarantor"><input type="button" class="btn btn-default" value="Back"> </a>
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
