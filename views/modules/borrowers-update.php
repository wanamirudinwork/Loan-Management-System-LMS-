<style>
	table td {
		text-transform: uppercase;
	}
</style>

		<!-- Start right content -->
        <div class="content-page">
			<!-- ============================================================== -->
			<!-- Start Content here -->
			<!-- ============================================================== -->
            <div class="content">
				<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='fa fa-list'></i> Management</h1>
				</div>
            	<!-- Page Heading End-->
				<?php //print_r($admins); ?>
				<?php //print_r($cms->admin->role); ?>
				<!-- Your awesome content goes here -->
				<div class="widget">

					<div class="widget-header transparent">
						<h2><strong>Borrower</strong> Details |
                            <?php if(!empty($borrower_update['label_contacts']) == '1' || $borrower['new'] == '1' && $borrower['borrower_status'] == '99' && (empty($borrowerContacts['borrower_id']) || $borrowerContacts['status'] == '99')){ ?>
                                <a href="#contacts" style="color:red"><b>Contacts</b></a> |
                            <?php } else{ ?>
                                <a href="#contacts"><b>Contacts</b></a> |
                            <?php } ?>
                            <?php if(!empty($borrower_update['label_employments']) == '1' || $borrower['new'] == '1' && $borrower['borrower_status'] == '99' && (empty($borrowerEmployments['borrower_id']) || $borrowerEmployments['status'] == '99')){ ?>
                                <a href="#employment" style="color:red"><b>Employment</b></a> |
                            <?php } else{ ?>
                                <a href="#employment"><b>Employment</b></a> |
                            <?php } ?>
                            <?php if(!empty($borrower_update['label_spouse']) == '1' || $borrower['new'] == '1' && $borrower['borrower_status'] == '99' && $borrower['marital'] != 'Single' && (empty($borrowerSpouse['borrower_id']) || $borrowerSpouse['status'] == '99')){ ?>
                                <a href="#spouse" style="color:red"><b>Spouse</b></a> |
                            <?php } else{ ?>
                                <a href="#spouse"><b>Spouse</b></a> |
                            <?php } ?>
                            <?php if(!empty($borrower_update['label_spouse_employments']) == '1' || $borrower['new'] == '1' && $borrower['borrower_status'] == '99' && $borrower['marital'] != 'Single' && (empty($borrowerSpouseEmployments['borrower_id']) || $borrowerSpouseEmployments['status'] == '99')){ ?>
                                <a href="#spouse_employment" style="color:red"><b>Spouse Employment</b></a> |
                            <?php } else{ ?>
                                <a href="#spouse_employment"><b>Spouse Employment</b></a> |
                            <?php } ?>
                            <?php if(!empty($borrower_update['label_guarantor']) == '1' || $borrower['new'] == '1' && $borrower['borrower_status'] == '99' && (empty($borrowerGuarantors['borrower_id']) || $borrowerGuarantors['status'] == '99')){ ?>
                                <a href="#guarantor" style="color:red"><b>Guarantor</b></a> |
                            <?php } else{ ?>
                                <a href="#guarantor"><b>Guarantor</b></a> |
                            <?php } ?>
                            <?php if(!empty($borrower_update['label_references']) == '1' || $borrower['new'] == '1' && $borrower['borrower_status'] == '99' && (empty($borrowerReferences['borrower_id']) || $borrowerReferences['status'] == '99')){ ?>
                                <a href="#references" style="color:red"><b>References</b></a> |
                            <?php } else{ ?>
                                <a href="#references"><b>References</b></a> |
                            <?php } ?>
                            <a href="#remarks"><b>Remarks</b></a> |
                            <a href="<?php echo url_for('/loan/'.$borrower["borrower_id"]); ?>"><b>View Account<?php if($loan['amount'] > 1){ echo 's';} ?> (<?php echo $loan['amount']; ?>)</b></a> |
                            <a href="<?php echo url_for('/report/collection-schedule-view-report/'.$borrower["borrower_id"]); ?>"><b>View Report</b></a></h2></h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal">
                        <div class="form-group">
                                <label class="col-sm-2 control-label">Profile Photo</label>
                                <div class="col-sm-8">
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
                                <?php if(!empty($borrower_update['borrower_remarks']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Borrower Information</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Borrower Information</label>
                                <?php } ?>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="borrower_remarks"><?php echo $borrower['borrower_remarks']; ?></textarea>
								</div>
							</div>

                            <div class="form-group">
                                <?php if(!empty($borrower_update['full_name']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Full Name *</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Full Name *</label>
                                <?php } ?>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="full_name" value="<?php echo $borrower['full_name']; ?>" required>
								</div>
                                <?php if(!empty($borrower_update['agent_id']) == '1'){ ?>
                                    <label class="col-sm-1 control-label two-line" style="color:red">Recovery Officer</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label two-line">Recovery Officer</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <select id="recovery_id" class="form-control selectpicker" name="officerID">
										<option>-</option>
										<?php foreach ($admins as $admin){

												if($admin['admin_id'] == $borrower['agent_id']){
													$selected = "selected";
												}else{
													$selected = "";
												}
										?>
										<option value="<?php echo $admin['admin_id']; ?>" <?php echo $selected; ?>><?php echo $admin['admin_name']; ?></option>

										<?php } ?>
                                    </select>
                                </div>

								<script>
								 var admin = <?php echo $cms->admin->role ?>;
									if(admin != 1 && admin != 2) {
										document.getElementById("submit_save").disabled = true;
									}

								</script>
                                <?php if(!empty($borrower_update['marital']) == '1'){ ?>
                                    <label class="col-sm-1 control-label two-line" style="color:red">Marital Status</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label two-line">Marital Status</label>
                                <?php } ?>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="marital">
                                        <option <?php echo ($borrower['marital'] == "Single" ? "selected" : ""); ?> value="Single"><?php echo marital_status('1'); ?></option>
                                        <option <?php echo ($borrower['marital'] == "Married" ? "selected" : ""); ?> value="Married"><?php echo marital_status('2'); ?></option>
										<option <?php echo ($borrower['marital'] == "Divorced" ? "selected" : ""); ?> value="Divorced"><?php echo marital_status('3'); ?></option>
										<option <?php echo ($borrower['marital'] == "Widowed" ? "selected" : ""); ?> value="Widowed"><?php echo marital_status('4'); ?></option>
                                    </select>
                                </div>
							</div>
                            <div class="form-group">
                                <?php if(!empty($borrower_update['race']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Race</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Race</label>
                                <?php } ?>
								<div class="col-sm-3">
                                    <select class="form-control selectpicker" name="race">
                                        <option <?php echo ($borrower['race'] == "Chinese" ? "selected" : ""); ?> value="Chinese">Chinese</option>
                                        <option <?php echo ($borrower['race'] == "Indian" ? "selected" : ""); ?> value="Indian">Indian</option>
										<option <?php echo ($borrower['race'] == "Malay" ? "selected" : ""); ?> value="Malay">Malay</option>
										<option <?php echo ($borrower['race'] == "Others" ? "selected" : ""); ?> value="Others">Others</option>
                                    </select>
                                </div>
                                <?php if(!empty($borrower_update['gender']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">Gender</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">Gender</label>
                                <?php } ?>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="gender">
                                        <option <?php echo ($borrower['gender'] == "Male" ? "selected" : ""); ?> value="Male"><?php echo gender_type('1'); ?></option>
                                        <option <?php echo ($borrower['gender'] == "Female" ? "selected" : ""); ?> value="Female"><?php echo gender_type('2'); ?></option>
                                    </select>
                                </div>
                                <?php if(!empty($borrower_update['dob']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">DOB</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">DOB</label>
                                <?php } ?>
								<div class="col-sm-2">
									<div class="input-group date">
										<input type="text" class="form-control" name="dob" style="z-index: 1;" value="<?php echo $borrower['dob']; ?>">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
								</div>
                            </div>
							<?php
								$isSelected = false;
								foreach($countries as $keys){
									if($borrower['nationality'] == $keys['id']){
										$isSelected = true;
									}
								}
							?>
                            <div class="form-group">
                                <?php if(!empty($borrower_update['nationality']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Nationality *</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Nationality *</label>
                                <?php } ?>
								<div class="col-sm-2">
                                    <select class="form-control selectpicker" name="nationality">
									<?php foreach($countries as $keys){ ?>
										<?php if($borrower['nationality'] == $keys['id'] || (!$isSelected && $keys['id'] == 129)) { ?>
											<option selected value="<?php echo $keys['id']; ?>"><?php echo $keys['name']; ?></option>
										<?php }else{ ?>
											<option value="<?php echo $keys['id']; ?>"><?php echo $keys['name']; ?></option>
										<?php } ?>
                                    <?php } ?>
									</select>
                                </div>
                                <?php if(!empty($borrower_update['nric_new']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">NRIC(New) *</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">NRIC(New) *</label>
                                <?php } ?>
                                <div class="col-sm-2">
                                    <input type="text" id="nric_format" maxlength="14" class="form-control nric-number" name="nric_new" required value="<?php echo $borrower['nric_new']; ?>">
                                </div>
                                <?php if(!empty($borrower_update['nric_old']) == '1'){ ?>
                                    <label class="col-sm-1 control-label" style="color:red">NRIC(Old)</label>
                                <?php } else{ ?>
                                    <label class="col-sm-1 control-label">NRIC(Old)</label>
                                <?php } ?>
                                <div class="col-sm-2" id="contacts">
                                    <input type="text" class="form-control " maxlength="14	" name="nric_old"  value="<?php echo $borrower['nric_old']; ?>">
                                </div>
                            </div>
                            <?php if ($cms->admin->mapproval == '1') {
                                    if ($borrower['pending_approval'] == '2'){ ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control selectpicker" name="status" onchange="show(this)">
                                                    <option value="1"<?php echo $borrower['borrower_status'] == 1 ? ' selected' : ''; ?>><?php echo borrower_restatus('1'); ?></option>
                                                    <option value="2"<?php echo $borrower['borrower_status'] == 2 ? ' selected' : ''; ?>><?php echo borrower_restatus('2'); ?></option>
                                                    <option value="3"<?php echo $borrower['borrower_status'] == 3 ? ' selected' : ''; ?>><?php echo borrower_restatus('3'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                            <?php } else { ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control selectpicker" name="status" onchange="show(this)">
                                                    <?php if ($borrower['borrower_status'] == '5'){ ?>
                                                        <option value="5"<?php echo $borrower['borrower_status'] == 5 ? ' selected' : ''; ?>><?php echo borrower_status('5'); ?></option>
                                                    <?php } else if ($borrower['borrower_status'] == '4') { ?>
                                                        <option value="4"<?php echo $borrower['borrower_status'] == 4 ? ' selected' : ''; ?>><?php echo borrower_status('4'); ?></option>
                                                    <?php } else{?>
                                                        <option value="1"<?php echo $borrower['borrower_status'] == 1 ? ' selected' : ''; ?>><?php echo borrower_status('1'); ?></option>
                                                        <option value="2"<?php echo $borrower['borrower_status'] == 2 || $borrower['borrower_status'] == 0 || $borrower['borrower_status'] == 99 ? ' selected' : ''; if($borrower['pending_approval']=='1' || $borrower['pending_approval']=='2') echo "disabled"; ?>><?php echo borrower_status('2'); ?></option>
                                                        <option value="3"<?php echo $borrower['borrower_status'] == 3 ? ' selected' : ''; ?>><?php echo borrower_status('3'); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                            <?php } } else if ($cms->admin->vapproval == '1') {
                                if ($borrower['pending_approval'] == '1'){ ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control selectpicker" name="status" onchange="show(this)">
                                                    <option value="2"<?php echo $borrower['borrower_status'] == 2 ? ' selected' : ''; ?>><?php echo borrower_restatus('2'); ?></option>
                                                    <option value="3"<?php echo $borrower['borrower_status'] == 3 ? ' selected' : ''; ?>><?php echo borrower_restatus('3'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                            <?php } else if ($borrower['pending_approval'] == '2'){ ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control selectpicker" name="status" onchange="show(this)">
                                                <?php if ($borrower['borrower_status'] == '1') { ?>
                                                    <option value="1"<?php echo $borrower['borrower_status'] == 1 ? ' selected' : ''; ?>><?php echo borrower_restatus('1'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '2') { ?>
                                                    <option value="2"<?php echo $borrower['borrower_status'] == 2 ? ' selected' : ''; ?>><?php echo borrower_restatus('2'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '3') { ?>
                                                    <option value="3"<?php echo $borrower['borrower_status'] == 3 ? ' selected' : ''; ?>><?php echo borrower_restatus('3'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                            <?php } else { ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control selectpicker" name="status" onchange="show(this)">
                                                <?php if ($borrower['borrower_status'] == '1') { ?>
                                                    <option value="1"<?php echo $borrower['borrower_status'] == 1 ? ' selected' : ''; ?>><?php echo borrower_status('1'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '2' || $borrower['borrower_status'] == '0' || $borrower['borrower_status'] == '5' || $borrower['borrower_status'] == '99') { ?>
                                                    <option value="2"<?php echo $borrower['borrower_status'] == 2 ? ' selected' : ''; ?>><?php echo borrower_status('2'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '4') { ?>
                                                    <option value="2"<?php echo $borrower['borrower_status'] == 4 ? ' selected' : ''; ?>><?php echo borrower_status('2'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '3') { ?>
                                                    <option value="3"<?php echo $borrower['borrower_status'] == 3 ? ' selected' : ''; ?>><?php echo borrower_status('3'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                            <?php } } else if ($cms->admin->vapproval == NULL || $cms->admin->vapproval == '0') {
                                if ($borrower['pending_approval'] == '1'){ ?>
                                    <div class="form-group" style="display:none;">
                                        <label class="col-sm-2 control-label">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control selectpicker" name="status" onchange="show(this)">
                                                <option value="2"<?php echo $borrower['borrower_status'] == 2 ? ' selected' : ''; ?>><?php echo borrower_restatus('2'); ?></option>
                                                <option value="3"<?php echo $borrower['borrower_status'] == 3 ? ' selected' : ''; ?>><?php echo borrower_restatus('3'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } else if ($borrower['pending_approval'] == '2'){ ?>
                                    <div class="form-group" style="display:none;">
                                        <label class="col-sm-2 control-label">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control selectpicker" name="status" onchange="show(this)">
                                                <?php if ($borrower['borrower_status'] == '1') { ?>
                                                    <option value="1"<?php echo $borrower['borrower_status'] == 1 ? ' selected' : ''; ?>><?php echo borrower_restatus('1'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '2') { ?>
                                                    <option value="2"<?php echo $borrower['borrower_status'] == 2 ? ' selected' : ''; ?>><?php echo borrower_restatus('2'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '3') { ?>
                                                    <option value="3"<?php echo $borrower['borrower_status'] == 3 ? ' selected' : ''; ?>><?php echo borrower_restatus('3'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group" style="display:none;">
                                        <label class="col-sm-2 control-label">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control selectpicker" name="status" onchange="show(this)">
                                                <?php if ($borrower['borrower_status'] == '1') { ?>
                                                    <option value="1"<?php echo $borrower['borrower_status'] == 1 ? ' selected' : ''; ?>><?php echo borrower_status('1'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '2' || $borrower['borrower_status'] == '0' || $borrower['borrower_status'] == '5' || $borrower['borrower_status'] == '99') { ?>
                                                    <option value="2"<?php echo $borrower['borrower_status'] == 2 ? ' selected' : ''; ?>><?php echo borrower_status('2'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '4') { ?>
                                                    <option value="2"<?php echo $borrower['borrower_status'] == 4 ? ' selected' : ''; ?>><?php echo borrower_status('2'); ?></option>
                                                <?php } else if ($borrower['borrower_status'] == '3') { ?>
                                                    <option value="3"<?php echo $borrower['borrower_status'] == 3 ? ' selected' : ''; ?>><?php echo borrower_status('3'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } } ?>
							<hr>
							<!-- <input type="hidden" name="admin_id" value="1"> -->

                            <?php if($borrower['borrower_status'] == '3'){ ?>
                                <div class="form-group">
                                    <label  class="col-sm-2 control-label">Rejection Reason</label>
                                    <div class="col-sm-8">
                                        <textarea style="font-size:18px;" class="form-control" name="rejection" <?php if($cms->admin->mapproval != '1') echo "readonly"; ?>><?php echo $borrower['rejection']; ?></textarea>
                                    </div>
                                </div>
                            <?php } else{ ?>
                                <div id="rejection" class="form-group">
                                    <label  class="col-sm-2 control-label">Rejection Reason</label>
                                    <div class="col-sm-8">
                                        <textarea style="font-size:18px;" class="form-control" name="rejection"><?php echo $borrower['rejection']; ?></textarea>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById("rejection").style.visibility = "hidden";
                                    function show(select){
                                        if(select.value == '3'){
                                            document.getElementById("rejection").style.visibility = "visible";

                                        }
                                        else if(select.value == '2'){
                                            document.getElementById("rejection").style.visibility = "hidden";

                                        }
                                        else if(select.value == '1'){
                                            document.getElementById("rejection").style.visibility = "hidden";

                                        }}
                                </script>
                            <?php } ?>

                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
                                    <input type="submit" id="submit_save" class="btn btn-primary" value="Save" <?php if($cms->admin->mborrower == '0' || $borrower['new'] == '1' && $borrower['borrower_status'] == '99' && (empty($borrowerContacts['borrower_id']) || $borrowerContacts['status'] == '99' || empty($borrowerEmployments['borrower_id']) || $borrowerEmployments['status'] == '99' || ((empty($borrowerSpouse['borrower_id']) || $borrowerSpouse['status'] == '99') && $borrower['marital'] != 'Single') || ((empty($borrowerSpouseEmployments['borrower_id']) || $borrowerSpouseEmployments['status'] == '99') && $borrower['marital'] != 'Single') || empty($borrowerGuarantors['borrower_id']) || $borrowerGuarantors['status'] == '99' || empty($borrowerReferences['borrower_id']) || $borrowerReferences['status'] == '99')) echo "disabled"; ?>>
                                    <?php if($cms->admin->vborrower != '1'){ ?>
                                        <a href="<?php echo url_for('/'); ?>"><input type="button" class="btn btn-default" value="Cancel">
                                    <?php } else{ ?>
                                        <input type="button" class="btn btn-default back" value="Cancel">
                                    <?php } ?>
									<a href="<?php echo url_for('/borrowers/'.$borrower['borrower_id'].'/export/pdf'); ?>" target="_blank" class="btn btn-success btn-m"><i class="fa fa-pencil">&nbsp;&nbsp;</i></button>Export to PDF</a>
								</div>
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <?php if($borrower['new'] == '1' && $borrower['borrower_status'] == '99' && (empty($borrowerContacts['borrower_id']) || $borrowerContacts['status'] == '99' || empty($borrowerEmployments['borrower_id']) || $borrowerEmployments['status'] == '99' || ((empty($borrowerSpouse['borrower_id']) || $borrowerSpouse['status'] == '99') && $borrower['marital'] != 'Single') || ((empty($borrowerSpouseEmployments['borrower_id']) || $borrowerSpouseEmployments['status'] == '99') && $borrower['marital'] != 'Single') || empty($borrowerGuarantors['borrower_id']) || $borrowerGuarantors['status'] == '99' || empty($borrowerReferences['borrower_id']) || $borrowerReferences['status'] == '99')){ ?>
                                        <br><p style="color: red"> *PLEASE COMPLETE ALL SECTION </p>
                                    <?php } ?>
                                </div>
							</div>
						</form>
					</div>
					<hr>
					<!-- Contacts -->
					<div class="widget-content">
						<div class="widget-header transparent">
							<h2><strong>Contacts</strong></h2>
						</div>
                        <?php if($cms->admin->mborrower == '1'){ ?>
						<div style="text-align:right;padding-right:2%;">
							<a href="<?php echo url_for('/borrowers/contact/'.$borrower["borrower_id"].'/insert/'); ?>" class="btn btn-primary btn-xs" ><i class="fa fa-plus-circle"></i> Add Contact</a>
						</div>
                        <?php } ?>
						<br>
						<div class="table-responsive"  id="employment">
							<form class='form-horizontal' id="selfForm" role='form'>
							<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th width="65%" class="c" >Address</th>
											<th width="20%" class="c" >Phone</th>

											<th width="15%" class="c"></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($borrower['contacts'] as $contact){ ?>
										<tr><?php foreach($ucontacts as $ucontact){
                                                if($ucontact['contact_id'] == $contact["contact_id"]){
                                                    if($ucontact['contactAddress'] == '1' || $ucontact['contactMobile_number'] == '1'){ ?>
                                                        <td width="65%" class="c" style="color:red"><?php echo $contact["address"]; ?></td>
                                                        <td width="20%" class="c" style="color:red"><?php echo $contact["mobile_number"]; ?></td>
                                                    <?php } else{ ?>
                                                        <td width="65%" class="c"><?php echo $contact["address"]; ?></td>
                                                        <td width="20%" class="c" ><?php echo $contact["mobile_number"]; ?></td>
                                                    <?php }}} ?>
											<td width="15%" class="c">
                                                <?php if($cms->admin->mborrower == '1'){ ?>
                                                    <a href="<?php echo url_for('borrowers/contact/'.$borrower["borrower_id"].'/update/'.$contact["contact_id"]); ?>"><i class="fa fa-pencil"></i></a>
                                                <?php } ?>
												<?php if($cms->admin->dborrower == '1'){ ?>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a data-bid="<?php echo $borrower["borrower_id"]; ?>" data-column="<?php echo $contact["mobile_number"]; ?>"
                                                       data-id="<?php echo $contact["contact_id"]; ?>" data-url="borrowers/contact" data-action="delete" class="delete-borrower" href="#"><i class="fa fa-remove"></i></a>
                                                <?php } ?>
												</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<hr>
					<!-- Employment -->
					<div class="widget-content">
						<div class="widget-header transparent">
							<h2><strong>Employment</strong></h2>
						</div>
                        <?php if($cms->admin->mborrower == '1'){ ?>
                            <div style="text-align:right;padding-right:2%;">
                                <a href="<?php echo url_for('/borrowers/employment/'.$borrower["borrower_id"].'/insert/'); ?>" class="btn btn-primary btn-xs" ><i class="fa fa-plus-circle"></i> Add Employment</a>
                            </div>
                        <?php } ?>
						<br>
						<div class="table-responsive" id="spouse">
							<form class='form-horizontal' id="selfForm" role='form'>
							<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th width="25%" class="c" >Employer</th>
											<th width="20%" class="c" >Designation</th>
											<th width="15%" class="c" >Pay Date</th>
											<th width="15%" class="c" >Advanced Pay Date</th>
											<th width="15%" class="c" >Phone</th>
											<th width="20%" class="c"></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($borrower['employments'] as $employment){ ?>
											<tr>
                                                <?php foreach($uemployments as $uemployment){
                                                    if($uemployment['employment_id'] == $employment["employment_id"]){
                                                        if($uemployment['employmentEmployer_name'] == '1' || $uemployment['employmentDesignation'] == '1' || $uemployment['employmentSalary_range'] == '1' || $uemployment['employmentPay_date'] == '1' || $uemployment['employmentAdvance_date'] == '1' || $uemployment['employmentStaff_id'] == '1' || $uemployment['employmentHired_on'] == '1' || $uemployment['employmentDepartment'] == '1' || $uemployment['employmentAddress'] == '1' || $uemployment['employmentWork_location'] == '1' || $uemployment['employmentPhone'] == '1' || $uemployment['employmentFax'] == '1'){ ?>
                                                            <td width="25%" class="c" style="color:red"><?php echo $employment["employer_name"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $employment["designation"]; ?></td>
                                                            <td width="15%" class="c" style="color:red"><?php echo $employment["pay_date"]; ?></td>
                                                            <td width="15%" class="c" style="color:red"><?php echo $employment["advance_date"]; ?></td>
                                                            <td width="15%" class="c" style="color:red"><?php echo $employment["phone"]; ?></td>
                                                        <?php } else{ ?>
                                                            <td width="25%" class="c" ><?php echo $employment["employer_name"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $employment["designation"]; ?></td>
                                                            <td width="15%" class="c" ><?php echo $employment["pay_date"]; ?></td>
                                                            <td width="15%" class="c" ><?php echo $employment["advance_date"]; ?></td>
                                                            <td width="15%" class="c" ><?php echo $employment["phone"]; ?></td>
                                                        <?php }}} ?>
												<td width="20%" class="c">
                                                    <?php if($cms->admin->mborrower == '1'){ ?>
                                                        <a href="<?php echo url_for('borrowers/employment/'.$borrower["borrower_id"].'/update/'.$employment["employment_id"]); ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php } ?>
													<?php if($cms->admin->dborrower == '1'){ ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a data-bid="<?php echo $borrower["borrower_id"]; ?>" data-column="<?php echo $employment["employer_name"]; ?>" data-id="<?php echo $employment["employment_id"]; ?>" data-url="borrowers/employment" data-action="delete" class="delete-borrower" href="#"><i class="fa fa-remove"></i></a>
                                                    <?php } ?>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<hr>
					<!-- Spouse -->
					<div class="widget-content" >
						<div class="widget-header transparent">
							<h2><strong>Spouse</strong></h2>
						</div>
                        <?php if($cms->admin->mborrower == '1'){ ?>
                            <div style="text-align:right;padding-right:2%;">
                                <a href="<?php echo url_for('/borrowers/spouse/'.$borrower["borrower_id"].'/insert/'); ?>" class="btn btn-primary btn-xs" ><i class="fa fa-plus-circle"></i> Add Spouse</a>
                            </div>
                        <?php } ?>
						<br>

						<div class="table-responsive" id="spouse_employment">
							<form class='form-horizontal' id="selfForm" role='form'>
							<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th width="45%" class="c" >Full Name</th>
											<th width="20%" class="c" >NRIC(New)</th>
											<th width="20%" class="c" >Mobile</th>
											<th width="15%" class="c"></th>
										</tr>
									</thead>
									<?php
										$mobiles = [];
										foreach($borrower['spouse_contacts'] as $mcontact){
											$mobiles[$mcontact['spouse_id']] = !isset($mobiles[$mcontact['spouse_id']]) ? $mcontact['mobile'] : $mobiles[$mcontact['spouse_id']];
										}
									?>
									<tbody>
										<?php foreach($borrower['spouses'] as $spouse){ ?>
											<tr>
                                                <?php foreach($uspouses as $uspouse){
                                                    if($uspouse['spouse_id'] == $spouse["spouse_id"]){
                                                        if($uspouse['spousedetailsFull_name'] == '1' || $uspouse['spousedetailsGender'] == '1' || $uspouse['spousedetailsDob'] == '1' || $uspouse['spousedetailsNationality'] == '1' || $uspouse['spousedetailsNric_new'] == '1' || $uspouse['spousedetailsNric_old'] == '1' || $uspouse['spousedetailsResident_address'] == '1' || $uspouse['spousedetailsNric_address'] == '1' || $uspouse['spousedetailsResident_address2'] == '1' || $uspouse['spousedetailsRemarks'] == '1' || $uspouse['spousedetailsMarital'] == '1' || $uspouse['spousedetailsRace'] == '1' || $uspouse['spouseMobile1'] == '1' || $uspouse['spouseMobile2'] == '1' || $uspouse['spousecontactsMobile'] == '1'){ ?>
                                                            <td width="45%" class="c" style="color:red"><?php echo $spouse["full_name"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $spouse["nric_new"]; ?></td>
                                                            <?php if(!empty($mobiles[$spouse["spouse_id"]])){ ?>
                                                                <td width="20%" class="c" style="color:red"><?php echo $mobiles[$spouse["spouse_id"]]; ?></td>
                                                            <?php }else{ ?>
                                                                <td width="20%" class="c" ></td>
                                                            <?php } ?>
                                                        <?php } else{ ?>
                                                            <td width="45%" class="c" ><?php echo $spouse["full_name"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $spouse["nric_new"]; ?></td>
                                                            <?php if(!empty($mobiles[$spouse["spouse_id"]])){ ?>
                                                                <td width="20%" class="c" ><?php echo $mobiles[$spouse["spouse_id"]]; ?></td>
                                                            <?php }else{ ?>
                                                                <td width="20%" class="c" ></td>
                                                        <?php }}}} ?>
												<td width="15%" class="c">
                                                    <?php if($cms->admin->mborrower == '1'){ ?>
                                                        <a href="<?php echo url_for('borrowers/spouse/'.$borrower["borrower_id"].'/update/'.$spouse["spouse_id"]); ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php } ?>
													<?php if($cms->admin->dborrower == '1'){ ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a data-bid="<?php echo $borrower["borrower_id"]; ?>" data-column="<?php echo $spouse["full_name"]; ?>"
                                                           data-id="<?php echo $spouse["spouse_id"]; ?>" data-url="borrowers/spouse" data-action="delete" class="delete-borrower" href="#"><i class="fa fa-remove"></i></a>
                                                    <?php } ?>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<hr>
					<!-- Spouse Employment -->
					<div class="widget-content">
						<div class="widget-header transparent">
							<h2><strong>Spouse Employment</strong></h2>
						</div>
                        <?php if($cms->admin->mborrower == '1'){ ?>
                            <div style="text-align:right;padding-right:2%;">
                                <a href="<?php echo url_for('/borrowers/spouse_employment/'.$borrower["borrower_id"].'/insert/'); ?>" class="btn btn-primary btn-xs" ><i class="fa fa-plus-circle"></i> Add Spouse Employment</a>
                            </div>
                        <?php } ?>
						<br>
						<div class="table-responsive" id="guarantor">
							<form class='form-horizontal' id="selfForm" role='form'>
							<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th width="25%" class="c" >Employer Name</th>
											<th width="20%" class="c" >Designation</th>
											<th width="20%" class="c" >Pay Date</th>
											<th width="20%" class="c" >Phone</th>
											<th width="15%" class="c"></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($borrower['spouses_employment'] as $spouses_employment){ ?>
											<tr>
                                                <?php foreach($uspouse_employments as $uspouse_employment){
                                                    if($uspouse_employment['spouse_employment_id'] == $spouses_employment["employment_id"]){
                                                        if($uspouse_employment['spouseemploymentsEmployer_name'] == '1' || $uspouse_employment['spouseemploymentsDesignation'] == '1' || $uspouse_employment['spouseemploymentsSalary_range'] == '1' || $uspouse_employment['spouseemploymentsPay_date'] == '1' || $uspouse_employment['spouseemploymentsAdvance_date'] == '1' || $uspouse_employment['spouseemploymentsStaff_id'] == '1' || $uspouse_employment['spouseemploymentsHired_on'] == '1' || $uspouse_employment['spouseemploymentsDepartment'] == '1' || $uspouse_employment['spouseemploymentsAddress'] == '1' || $uspouse_employment['spouseemploymentsWork_location'] == '1' || $uspouse_employment['spouseemploymentsPhone'] == '1' || $uspouse_employment['spouseemploymentsFax'] == '1'){ ?>
                                                            <td width="25%" class="c" style="color:red"><?php echo $spouses_employment["employer_name"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $spouses_employment["designation"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $spouses_employment["pay_date"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $spouses_employment["phone"]; ?></td>
                                                        <?php } else{ ?>
                                                            <td width="25%" class="c" ><?php echo $spouses_employment["employer_name"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $spouses_employment["designation"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $spouses_employment["pay_date"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $spouses_employment["phone"]; ?></td>
                                                        <?php }}} ?>
												<td width="15%" class="c">
                                                    <?php if($cms->admin->mborrower == '1'){ ?>
                                                        <a href="<?php echo url_for('borrowers/spouse_employment/'.$borrower["borrower_id"].'/update/'.$spouses_employment["employment_id"]); ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php } ?>
													<?php if($cms->admin->dborrower == '1'){ ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a data-bid="<?php echo $borrower["borrower_id"]; ?>" data-column="<?php echo $spouses_employment["employer_name"]; ?>" data-id="<?php echo $spouses_employment["employment_id"]; ?>" data-url="borrowers/spouse_employment" data-action="delete" class="delete-borrower" href="#"><i class="fa fa-remove"></i></a>
                                                    <?php } ?>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<hr>
					<!-- Guarantor -->
					<div class="widget-content">
						<div class="widget-header transparent">
							<h2><strong>Guarantor</strong></h2>
						</div>
                        <?php if($cms->admin->mborrower == '1'){ ?>
                            <div style="text-align:right;padding-right:2%;">
                                <a href="<?php echo url_for('/borrowers/guarantor/'.$borrower["borrower_id"].'/insert/'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Add Guarantor</a>
                            </div>
                        <?php } ?>
						<br>
						<div class="table-responsive" id="references">
							<form class='form-horizontal' id="selfForm" role='form'>
							<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th width="25%" class="c" >Full Name</th>
											<th width="20%" class="c" >NRIC</th>
											<th width="20%" class="c" >Mobile</th>
											<th width="20%" class="c" >Relation</th>
											<th width="15%" class="c"></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($borrower['guarantors'] as $guarantor){ ?>
											<tr>
                                                <?php foreach($uguarantors as $uguarantor){
                                                    if($uguarantor['guarantor_id'] == $guarantor["guarantor_id"]){
                                                        if($uguarantor['guarantorsFull_name'] == '1' || $uguarantor['guarantorsNric_new'] == '1' || $uguarantor['guarantorsNric_old'] == '1' || $uguarantor['guarantorsRelation'] == '1' || $uguarantor['guarantorsResidence_address'] == '1' || $uguarantor['guarantorsOther_address'] == '1' || $uguarantor['guarantorsMobile1'] == '1' || $uguarantor['guarantorsMobile2'] == '1' || $uguarantor['guarantorsEmployer_name'] == '1' || $uguarantor['guarantorsDesignation'] == '1' || $uguarantor['guarantorsStaff_id'] == '1' || $uguarantor['guarantorsHired_on'] == '1' || $uguarantor['guarantorsDepartment'] == '1' || $uguarantor['guarantorsEmployer_address'] == '1' || $uguarantor['guarantorsWork_location'] == '1' || $uguarantor['guarantorsPhone'] == '1' || $uguarantor['guarantorsMarital'] == '1' || $uguarantor['guarantorsFax'] == '1'){ ?>
                                                            <td width="25%" class="c" style="color:red"><?php echo $guarantor["full_name"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $guarantor["nric_new"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $guarantor["mobile1"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $guarantor["relation"]; ?></td>
                                                        <?php } else{ ?>
                                                            <td width="25%" class="c" ><?php echo $guarantor["full_name"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $guarantor["nric_new"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $guarantor["mobile1"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $guarantor["relation"]; ?></td>
                                                        <?php }}} ?>
												<td width="15%" class="c">
                                                    <?php if($cms->admin->mborrower == '1'){ ?>
                                                        <a href="<?php echo url_for('borrowers/guarantor/'.$borrower["borrower_id"].'/update/'.$guarantor["guarantor_id"]); ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php } ?>
													<?php if($cms->admin->dborrower == '1'){ ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a data-bid="<?php echo $borrower["borrower_id"]; ?>" data-column="<?php echo $guarantor["full_name"]; ?>"
                                                           data-id="<?php echo $guarantor["guarantor_id"]; ?>" data-url="borrowers/guarantor" data-action="delete" class="delete-borrower" href="#"><i class="fa fa-remove"></i></a>
                                                    <?php } ?>
												</td>
											</tr>
										<?php } ?>

									</tbody>
								</table>
							</form>
						</div>
					</div>
					<hr>
					<!-- References -->
					<div class="widget-content" id="remarks">
						<div class="widget-header transparent">
							<h2><strong>References</strong></h2>
						</div>
                        <?php if($cms->admin->mborrower == '1'){ ?>
                            <div style="text-align:right;padding-right:2%;">
                                <a href="<?php echo url_for('/borrowers/reference/'.$borrower["borrower_id"].'/insert/'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Add References</a>
                            </div>
                        <?php } ?>
						<br>
						<div class="table-responsive">
							<form class='form-horizontal' id="selfForm" role='form'>
							<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th width="65%" class="c" >Full Name</th>
											<th width="20%" class="c" >NRIC</th>
											<th width="20%" class="c" >Mobile</th>
											<th width="20%" class="c" >Relation</th>
											<th width="15%" class="c"></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($borrower['references'] as $reference){ ?>
											<tr>
                                                <?php foreach($ureferences as $ureference){
                                                    if($ureference['reference_id'] == $reference["reference_id"]){
                                                        if($ureference['referencesFull_name'] == '1' || $ureference['referencesEmployer_name'] == '1' || $ureference['referencesRelation'] == '1' || $ureference['referencesDesignation'] == '1' || $ureference['referencesNric_new'] == '1' || $ureference['referencesNric_old'] == '1' || $ureference['referencesStaff_id'] == '1' || $ureference['referencesHired_on'] == '1' || $ureference['referencesDepartment'] == '1' || $ureference['referencesResidence_address'] == '1' || $ureference['referencesEmployer_address'] == '1' || $ureference['referencesOther_address'] == '1' || $ureference['referencesWork_location'] == '1' || $ureference['referencesMarital'] == '1' || $ureference['referencesPhone'] == '1' || $ureference['referencesFax'] == '1' || $ureference['referencesMobile1'] == '1' || $ureference['referencesMobile2'] == '1'){ ?>
                                                            <td width="25%" class="c" style="color:red"><?php echo $reference["full_name"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $reference["nric_new"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $reference["mobile1"]; ?></td>
                                                            <td width="20%" class="c" style="color:red"><?php echo $reference["relation"]; ?></td>
                                                        <?php } else{ ?>
                                                            <td width="25%" class="c" ><?php echo $reference["full_name"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $reference["nric_new"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $reference["mobile1"]; ?></td>
                                                            <td width="20%" class="c" ><?php echo $reference["relation"]; ?></td>
                                                        <?php }}} ?>
												<td width="15%" class="c">
                                                    <?php if($cms->admin->mborrower == '1'){ ?>
                                                        <a href="<?php echo url_for('borrowers/reference/'.$borrower["borrower_id"].'/update/'.$reference["reference_id"]); ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php } ?>
													<?php if($cms->admin->dborrower == '1'){ ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a data-bid="<?php echo $borrower["borrower_id"]; ?>" data-column="<?php echo $reference["full_name"]; ?>"
                                                           data-id="<?php echo $reference["reference_id"]; ?>" data-url="borrowers/reference" data-action="delete" class="delete-borrower" href="#"><i class="fa fa-remove"></i></a>
                                                    <?php } ?>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<hr>
					<!-- Remarks -->
					<div class="widget-content">
						<div class="widget-header transparent">
							<h2><strong>Remarks</strong></h2>
						</div>
                        <?php if($cms->admin->mborrower == '1'){ ?>
                            <div style="text-align:right;padding-right:2%;">
                                <a href="<?php echo url_for('/borrowers/remark/'.$borrower["borrower_id"].'/insert/'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Add Remark</a>
                            </div>
                        <?php } ?>
						<br>
						<div class="table-responsive">
							<form class='form-horizontal' id="selfForm" role='form'>
							<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th width="65%" class="c" >Remarks</th>
											<?php if($cms->admin->role == 1 || $cms->admin->role == 2){ ?>
											<th width="15%" class="c"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php foreach($borrower['remarks'] as $remark){ ?>
											<tr>
												<td width="25%" class="c" ><?php echo $remark["remarks"]; ?></td>
												<?php if($cms->admin->role == 1 || $cms->admin->role == 2){ ?>
												<td width="15%" class="c"></td>
												<?php } ?>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</form>
						</div>
					</div>

					<a href="#" id="scroll-to-top" class="float whatsapp" ><i class="fa fa-angle-up my-float"></i></a>
				</div>

				<!-- End of your awesome content -->

			<?php echo partial('copy.php'); ?>

            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->
