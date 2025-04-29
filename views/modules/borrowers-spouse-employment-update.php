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
            		<h1><i class='fa fa-list'></i> Spouse Employment</h1>
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
						<h2><strong>Update</strong> Spouse Employment</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							
                            <div class="form-group">
                                <?php if(!empty($update_contact['spouseemploymentsEmployer_name']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Employer Name *</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Employer Name *</label>
                                <?php } ?>
                                <div class="col-sm-3">
                                    <input type="text"  maxlength="100" class="form-control" name="employer_name" value="<?php echo $spouse_employment["employer_name"]; ?>" required >
                                </div>
                                <?php if(!empty($update_contact['spouseemploymentsDesignation']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Designation *</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Designation *</label>
                                <?php } ?>
                                <div class="col-sm-3">
                                    <input type="text" maxlength="100" class="form-control" name="designation" value="<?php echo $spouse_employment["designation"]; ?>" required >
                                </div>
							</div>
                            <div class="form-group">
                                <?php if(!empty($update_contact['spouseemploymentsSalary_range']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Salary Range (RM)</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Salary Range (RM)</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="14" class="form-control" name="salary_range" value="<?php echo $spouse_employment["salary_range"]; ?>" placeholder="RM" >
                                </div>
                                <?php if(!empty($update_contact['spouseemploymentsPay_date']) == '1'){ ?>
                                    <label class="col-sm-1 control-label phone" style="color:red">Paydate</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label phone">Paydate</label>
                                <?php } ?>
                                <div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="pay_date" style="z-index: 1;" value="<?php echo $spouse_employment["pay_date"]; ?>">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
                                <?php if(!empty($update_contact['spouseemploymentsAdvance_date']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Advanced Paydate</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Advanced Paydate</label>
                                <?php } ?>
                                <div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="advance_date" style="z-index: 1;" value="<?php echo $spouse_employment["advance_date"]; ?>">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
                            </div>
							<div class="form-group">
                                <?php if(!empty($update_contact['spouseemploymentsStaff_id']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Staff ID</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Staff ID</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="100" class="form-control" name="staff_id" value="<?php echo $spouse_employment["staff_id"]; ?>"  >
                                </div>
                                <?php if(!empty($update_contact['spouseemploymentsHired_on']) == '1'){ ?>
                                    <label class="col-sm-1 control-label phone" style="color:red">Hired On</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label phone">Hired On</label>
                                <?php } ?>
                                <div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="hired_on" style="z-index: 1;" value="<?php echo $spouse_employment["hired_on"]; ?>">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
                                <?php if(!empty($update_contact['spouseemploymentsDepartment']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Department</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Department</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="100" class="form-control" name="department" value="<?php echo $spouse_employment["department"]; ?>"  >
                                </div>
							</div>
							<div class="form-group">
                                <?php if(!empty($update_contact['spouseemploymentsAddress']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Address</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Address</label>
                                <?php } ?>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="address"><?php echo $spouse_employment["address"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
                                <?php if(!empty($update_contact['spouseemploymentsWork_location']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Work Location</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Work Location</label>
                                <?php } ?>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="100" class="form-control" name="work_location" value="<?php echo $spouse_employment["work_location"]; ?>"  >
                                </div>
							</div>
							
							<div class="form-group">
                                <?php if(!empty($update_contact['spouseemploymentsPhone']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Phone</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Phone</label>
                                <?php } ?>
                                <div class="col-sm-3">
                                    <input type="text" maxlength="12" class="form-control mobile-number" name="phone" value="<?php echo $spouse_employment["phone"]; ?>" >
                                </div>
                                <?php if(!empty($update_contact['spouseemploymentsFax']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Fax</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Fax</label>
                                <?php } ?>
                                <div class="col-sm-3">
									<input type="text" maxlength="12" class="form-control" name="fax" value="<?php echo $spouse_employment["fax"]; ?>"  >
								</div>
							</div>
							
							<hr>
							<?php 
								$disabled = "";
									if($cms->admin->role != 2){
										$disabled = "disabled";
									}

							?>
								<!-- <input type="hidden" name="admin_id" value="<?php echo $cms->admin->id; ?>"> -->
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Save" <?php //echo $disabled; ?>>
									<a href="<?php echo url_for('/borrowers/'.$borrower_id); ?>/#spouse_employment"><input type="button" class="btn btn-default" value="Back"> </a>
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
