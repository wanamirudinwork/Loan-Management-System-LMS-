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
						<h2><strong>Update</strong> Guarantor</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">

						<div class="form-group">
                                <label class="col-sm-2 control-label">Profile Photo</label>
                                <div class="col-sm-10">
									<div class="multiImg">
										<img onerror="this.src='<?php echo ROOTPATH; ?>images/noimage.png'" src="<?php echo ROOTPATH.'upload/images/'.$profile_image[0]['filename']; ?>" style="display:table;margin:5px;max-width:200px;max-height:100px;">
										<input id="photo_1" name="photo_1" value="<?php echo $profile_image[0]['filename']; ?>" type="hidden">
										<input id="photo_1_file_id" name="photo_1_file_id" value="<?php echo $profile_image[0]['file_id']; ?>" type="hidden">
										<a href="javascript:void(0)" onclick="kcFinderB('photo_1')">Browse</a> | <a href="javascript:void(0)" onclick="kcFinderC('photo_1')">Cancel</a>
									</div>
									<div class="multiImg">
										<img onerror="this.src='<?php echo ROOTPATH; ?>images/noimage.png'" src="<?php echo ROOTPATH.'upload/images/'.$other_image[0]['filename']; ?>" style="display:table;margin:5px;max-width:200px;max-height:100px;">
										<input id="photo_2" name="photo_2" value="<?php echo $other_image[0]['filename']; ?>" type="hidden">
										<input id="photo_2_file_id" name="photo_2_file_id" value="<?php echo $other_image[0]['file_id']; ?>" type="hidden">
										<a href="javascript:void(0)" onclick="kcFinderB('photo_2')">Browse</a> | <a href="javascript:void(0)" onclick="kcFinderC('photo_2')">Cancel</a>
										
									</div>
									<div class="multiImg">
										<img onerror="this.src='<?php echo ROOTPATH; ?>images/noimage.png'" src="<?php echo ROOTPATH.'upload/images/'.$other_image[1]['filename']; ?>" style="display:table;margin:5px;max-width:200px;max-height:100px;">
										<input id="photo_3" name="photo_3" value="<?php echo $other_image[1]['filename']; ?>" type="hidden">
										<input id="photo_3_file_id" name="photo_3_file_id" value="<?php echo $other_image[1]['file_id']; ?>" type="hidden">
										<a href="javascript:void(0)" onclick="kcFinderB('photo_3')">Browse</a> | <a href="javascript:void(0)" onclick="kcFinderC('photo_3')">Cancel</a>
										
									</div>
                                </div>
                            </div>								
                            <div class="form-group">
                                <?php if(!empty($update_contact['guarantorsFull_name']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Full Name</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Full Name</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input type="text"  maxlength="14" class="form-control" name="full_name" value="<?php echo $guarantor["full_name"]; ?>" required >
                                </div>
                                <?php if(!empty($update_contact['guarantorsRelation']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">Relation</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">Relation</label>
                                <?php } ?>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="relation" value="<?php echo $guarantor["relation"]; ?>" required>
                                    <!-- <select class="form-control selectpicker" name="relation">
                                        <option <?php echo ($guarantor["relation"] == "BROTHER" ? "selected" : ""); ?> value="BROTHER"><?php echo relation_type('1'); ?></option>
                                        <option <?php echo ($guarantor["relation"] == "BROTHER" ? "selected" : ""); ?> value="BROTHER"><?php echo relation_type('2'); ?></option>
										<option <?php echo ($guarantor["relation"] == "COUSIN" ? "selected" : ""); ?> value="COUSIN"><?php echo relation_type('3'); ?></option>
										<option <?php echo ($guarantor["relation"] == "DAUGHTER" ? "selected" : ""); ?> value="DAUGHTER"><?php echo relation_type('4'); ?></option>
										<option <?php echo ($guarantor["relation"] == "FATHER" ? "selected" : ""); ?> value="FATHER"><?php echo relation_type('5'); ?></option>
										<option <?php echo ($guarantor["relation"] == "FRIEND" ? "selected" : ""); ?> value="FRIEND"><?php echo relation_type('6'); ?></option>
										<option <?php echo ($guarantor["relation"] == "HUSBAND" ? "selected" : ""); ?> value="HUSBAND"><?php echo relation_type('7'); ?></option>
										<option <?php echo ($guarantor["relation"] == "MOTHER" ? "selected" : ""); ?> value="MOTHER"><?php echo relation_type('8'); ?></option>
										<option <?php echo ($guarantor["relation"] == "MOTHER" ? "selected" : ""); ?> value="MOTHER"><?php echo relation_type('9'); ?></option>
										<option <?php echo ($guarantor["relation"] == "RECOMMENDER" ? "selected" : ""); ?> value="RECOMMENDER"><?php echo relation_type('10'); ?></option>
										<option <?php echo ($guarantor["relation"] == "SISTER" ? "selected" : ""); ?> value="SISTER"><?php echo relation_type('11'); ?></option>
										<option <?php echo ($guarantor["relation"] == "SISTER" ? "selected" : ""); ?> value="SISTER"><?php echo relation_type('12'); ?></option>
										<option <?php echo ($guarantor["relation"] == "SON" ? "selected" : ""); ?> value="SON"><?php echo relation_type('13'); ?></option>
										<option <?php echo ($guarantor["relation"] == "SON" ? "selected" : ""); ?> value="SON"><?php echo relation_type('14'); ?></option>
										<option <?php echo ($guarantor["relation"] == "SPOUSE" ? "selected" : ""); ?> value="SPOUSE"><?php echo relation_type('15'); ?></option>
										<option <?php echo ($guarantor["relation"] == "UNCLE" ? "selected" : ""); ?> value="UNCLE"><?php echo relation_type('16'); ?></option>
										<option <?php echo ($guarantor["relation"] == "WIFE" ? "selected" : ""); ?> value="WIFE"><?php echo relation_type('17'); ?></option>
										<option <?php echo ($guarantor["relation"] == "WIFE" ? "selected" : ""); ?> value="WIFE"><?php echo relation_type('18'); ?></option>
                                    </select> -->
                                </div>
                                <?php if(!empty($update_contact['guarantorsMarital']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Marital Status</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Marital Status</label>
                                <?php } ?>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="marital">
                                        <option <?php echo ($guarantor["marital"] == "Single" ? "selected" : ""); ?> value="Single"><?php echo marital_status('1'); ?></option>
                                        <option <?php echo ($guarantor["marital"] == "Married" ? "selected" : ""); ?> value="Married"><?php echo marital_status('2'); ?></option>
										<option <?php echo ($guarantor["marital"] == "Divorced" ? "selected" : ""); ?> value="Divorced"><?php echo marital_status('3'); ?></option>
										<option <?php echo ($guarantor["marital"] == "Widowed" ? "selected" : ""); ?> value="Widowed"><?php echo marital_status('4'); ?></option>
                                    </select>
                                </div>
								
							</div>                            
							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsNric_new']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">NRIC(New) *</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">NRIC(New) *</label>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <input type="text" id="nric_format" maxlength="14" class="form-control nric-number" name="nric_new" required value="<?php echo $guarantor["nric_new"]; ?>">
                                </div>
                                <?php if(!empty($update_contact['guarantorsNric_old']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">NRIC(Old)</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">NRIC(Old)</label>
                                <?php } ?>
                                <div class="col-sm-4" id="contacts">
                                    <input type="text" class="form-control nric-number" maxlength="14" name="nric_old"  value="<?php echo $guarantor["nric_old"]; ?>">
                                </div>
                            </div>
							
							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsResidence_address']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Resident Address</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Resident Address</label>
                                <?php } ?>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="residence_address"><?php echo $guarantor["residence_address"]; ?></textarea>
								</div>
							</div>
							
							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsOther_address']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Other Address</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Other Address</label>
                                <?php } ?>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="other_address"><?php echo $guarantor["other_address"]; ?></textarea>
								</div>
							</div>
							
							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsMobile1']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Mobile1</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Mobile1</label>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <input pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile1" value="<?php echo $guarantor["mobile1"]; ?>" >
                                </div>
                                <?php if(!empty($update_contact['guarantorsMobile2']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">Mobile2</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">Mobile2</label>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <input pattern="^\d{3}-\d{7,8}$" title="Invalid phone number." type="text" maxlength="12" class="form-control mobile-number" name="mobile2" value="<?php echo $guarantor["mobile2"]; ?>"  >
                                </div>							
                            </div>

							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsEmployer_name']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Employer Name</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Employer Name</label>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="14" class="form-control" name="employer_name" value="<?php echo $guarantor["employer_name"]; ?>"  >
                                </div>
                                <?php if(!empty($update_contact['guarantorsDesignation']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">Designation</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">Designation</label>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="14" class="form-control" name="designation" value="<?php echo $guarantor["designation"]; ?>"  >
                                </div>
							</div>

							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsStaff_id']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Staff ID</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Staff ID</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="14" class="form-control" name="staff_id" value="<?php echo $guarantor["staff_id"]; ?>"  >
                                </div>
                                <?php if(!empty($update_contact['guarantorsHired_on']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">Hired On</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">Hired On</label>
                                <?php } ?>
                                <div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="hired_on" style="z-index: 1;" value="<?php echo $guarantor["hired_on"]; ?>">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
                                <?php if(!empty($update_contact['guarantorsDepartment']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Department</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Department</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="14" class="form-control" name="department" value="<?php echo $guarantor["department"]; ?>"  >
                                </div>
							</div>

							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsEmployer_address']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Employer Address</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Employer Address</label>
                                <?php } ?>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="employer_address"><?php echo $guarantor["employer_address"]; ?></textarea>
								</div>
							</div>

							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsWork_location']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Work Location</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Work Location</label>
                                <?php } ?>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="14" class="form-control" name="work_location" value="<?php echo $guarantor["work_location"]; ?>"  >
                                </div>
							</div>

							<div class="form-group">
                                <?php if(!empty($update_contact['guarantorsPhone']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Phone</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Phone</label>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="12" class="form-control mobile-number" name="phone" value="<?php echo $guarantor["phone"]; ?>"  >
                                </div>
                                <?php if(!empty($update_contact['guarantorsFax']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">Fax</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">Fax</label>
                                <?php } ?>
                                <div class="col-sm-4">
									<input type="text" maxlength="10" class="form-control" name="fax" value="<?php echo $guarantor["fax"]; ?>"  >
								</div>
							</div>
							<?php 
								$disabled = "";
									if($cms->admin->role != 2){
										$disabled = "disabled";
									}

							?>

							<hr>
								<!-- <input type="hidden" name="admin_id" value="<?php echo $cms->admin->id; ?>"> -->
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Save" <?php //echo $disabled; ?>>
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
