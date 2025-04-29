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
				
				//print_r($spouse['race']);
				
				
				?>
								
				<!-- Your awesome content goes here -->
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Update</strong> Spouse</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							
                            <div class="form-group">
                                <?php if(!empty($update_contact['spousedetailsFull_name']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Full Name</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Full Name</label>
                                <?php } ?>
                                <div class="col-sm-3">
                                    <input type="text"  maxlength="100" class="form-control" name="full_name" value="<?php echo $spouse['full_name']; ?>" required >
                                </div>
                                <?php if(!empty($update_contact['spousedetailsGender']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">Gender</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">Gender</label>
                                <?php } ?>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="gender">
                                        <option <?php echo ($spouse['gender'] == "Male" ? "selected" : ""); ?> value="Male"><?php echo gender_type('1'); ?></option>
                                        <option <?php echo ($spouse['gender'] == "Female" ? "selected" : ""); ?> value="Female"><?php echo gender_type('2'); ?></option>
                                    </select>
                                </div>
                                <?php if(!empty($update_contact['spousedetailsDob']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">DOB</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">DOB</label>
                                <?php } ?>
								<div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="dob" style="z-index: 1;" value="<?php echo $spouse['dob']; ?>">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
							</div>  

							<?php 							
								$isSelected = false;
								foreach($countries as $keys){ 
									if($spouse['nationality'] == $keys['id']){
										$isSelected = true;
									}
								} 
							?>
						
							<div class="form-group">
                                <?php if(!empty($update_contact['spousedetailsNationality']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Nationality *</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Nationality *</label>
                                <?php } ?>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="nationality" country-val>
									<?php foreach($countries as $keys){ ?>
										<?php if($spouse['nationality'] == $keys['id'] || (!$isSelected && $keys['id'] == 129)) { ?>
											<option selected value="<?php echo $keys['id']; ?>"><?php echo $keys['name']; ?></option>
										<?php }else{ ?>
											<option value="<?php echo $keys['id']; ?>"><?php echo $keys['name']; ?></option>
										<?php } ?>                                        
                                    <?php } ?>
									</select>
                                </div>
                                <?php if(!empty($update_contact['spousedetailsNric_new']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">NRIC(New) *</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">NRIC(New) *</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input type="text" id="nric_format" maxlength="14" class="form-control nric-number" name="nric_new" required value="<?php echo $spouse['nric_new']; ?>">
                                </div>
                                <?php if(!empty($update_contact['spousedetailsNric_old']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">NRIC(Old)</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">NRIC(Old)</label>
                                <?php } ?>
                                <div class="col-sm-2" id="contacts">
                                    <input type="text" class="form-control" maxlength="14" name="nric_old"  value="<?php echo $spouse['nric_old']; ?>">
                                </div>
                            </div>
							<div class="form-group">
                                <?php if(!empty($update_contact['spousedetailsResident_address']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Resident Address</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Resident Address</label>
                                <?php } ?>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="resident_address"><?php echo $spouse['resident_address']; ?></textarea>
								</div>
							</div>
							<div class="form-group">
                                <?php if(!empty($update_contact['spousedetailsNric_address']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">NRIC Address</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">NRIC Address</label>
                                <?php } ?>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="nric_address"><?php echo $spouse['nric_address']; ?></textarea>
								</div>
							</div>
							<div class="form-group">
                                <?php if(!empty($update_contact['spousedetailsResident_address2']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Resident Address2</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Resident Address2</label>
                                <?php } ?>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="resident_address2"><?php echo $spouse['resident_address2']; ?></textarea>
								</div>
							</div>
							<div class="form-group">
                                <?php if(!empty($update_contact['spousedetailsRemarks']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Remarks</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Remarks</label>
                                <?php } ?>
								<div class="col-sm-5">
									<textarea class="form-control" style="text-transform: uppercase;" name="remarks"><?php echo $spouse['remarks']; ?></textarea>
								</div>
                                <?php if(!empty($update_contact['spousedetailsMarital']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Marital Status</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Marital Status</label>
                                <?php } ?>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="marital">
                                        <option <?php echo ($spouse['marital'] == "Single" ? "selected" : ""); ?> value="Single"><?php echo marital_status('1'); ?></option>
                                        <option <?php echo ($spouse['marital'] == "Married" ? "selected" : ""); ?> value="Married"><?php echo marital_status('2'); ?></option>
										<option <?php echo ($spouse['marital'] == "Divorced" ? "selected" : ""); ?> value="Divorced"><?php echo marital_status('3'); ?></option>
										<option <?php echo ($spouse['marital'] == "Widowed" ? "selected" : ""); ?> value="Widowed"><?php echo marital_status('4'); ?></option>
                                    </select>
                                </div>
							</div>
							<div class="form-group">
                                <?php if(!empty($update_contact['spousedetailsRace']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Race</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Race</label>
                                <?php } ?>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="race">
									<?php
										if($spouse['race'] == "Indian"){
											$chinese = "";
											$malay = "";
											$indian = "selected";
											$others = "";
										}
										if($spouse['race'] == "Chinese"){
											$chinese = "selected";
											$malay = "";
											$indian = "";
											$others = "";
										}
										if($spouse['race'] == "Malay"){
											$chinese = "";
											$malay = "selected";
											$indian = "";
											$others = "";
										}
										if($spouse['race'] == "Others"){
											$chinese = "";
											$malay = "";
											$indian = "";
											$others = "selected";
										}
									?>
                                        <option <?php echo $chinese; ?> value="Chinese">Chinese</option>
                                        <option <?php echo $indian; ?> value="Indian">Indian</option>
										<option <?php echo $malay; ?> value="Malay">Malay</option>
										<option <?php echo $others; ?> value="Others">Others</option>
                                    </select>
                                </div>	
								<!-- <label class="col-sm-1 control-label phone">Mobile1</label>
                                <div class="col-sm-2">
                                    <input required pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile1" value="<?php echo $spouse['mobile1']; ?>"  >
                                </div>
								<label class="col-sm-1 control-label phone">Mobile2</label>
                                <div class="col-sm-3">
                                    <input required pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile2" value="<?php echo $spouse['mobile2']; ?>"  >
                                </div>							 -->
                            </div>
							<div class="form-group">
								<a class="btn btn btn-primary" onclick="addMobileNumber()">Add</a>
								<label class="col-sm-2 control-label phone">Mobile</label>
                                <div class="col-sm-4">
                                    <input pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile_input" value=""  >
                                </div>
							</div>
							<div class="mobile-list">
								<?php foreach($spouse_contacts as $conatct){ ?>								
									<div>
										<span class="col-sm-2 control-label"></span>
										<input type="hidden" name="mobile[]" value="<?php echo $conatct['mobile']; ?>"/>
										<span style="display: inline-block; border: 1px solid #ccc; padding: 7px; margin: 0 5px; width: 37%; background-color: #ddd;"><?php echo $conatct['mobile']; ?></span> <span style="padding: 5px 10px; cursor: pointer;" onclick="removeMobileNumber(this)">x</span>
									</div>
								<?php } ?>
							</div>
							<script>
							 var admin = <?php echo $cms->admin->role ?>;
								if(admin != 1 && admin != 2) {
									document.getElementById("submit_save").disabled = true;
								}

							</script>
							<?php 
								$disabled = "";
									if($cms->admin->role != 2){
										$disabled = "disabled";
									}
							
							?>
							<hr>
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" id="submit_save" class="btn btn-primary" value="Save" <?php //echo $disabled; ?>>
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
