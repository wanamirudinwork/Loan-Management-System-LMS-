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
        <?php //print_r($agents); ?>
        <!-- Your awesome content goes here -->
        <div class="widget">
            <div class="widget-header transparent">
                <h2><strong>Insert</strong> Borrower Details</h2>
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
                        <label class="col-sm-2 control-label">Borrower Information</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" style="text-transform: uppercase;" name="borrower_remarks"></textarea>
                        </div>
                    </div>

                    <div class="form-group">

                        <label class="col-sm-2 control-label">Full Name *</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <label class="col-sm-1 control-label two-line">Recovery Officer</label>
                        <div class="col-sm-2">
                            <select class="form-control selectpicker" name="officerID">
                                <option>-</option>
                                <?php
                                if($agents){
                                    foreach($agents as $agent){ ?>
                                        <option value="<?php echo $agent['admin_id']; ?>"><?php echo $agent['admin_name'];?></option>
                                    <?php }
                                }	?>
                            </select>
                        </div>
                        <script>
                            var admin = <?php echo $cms->admin->id ?>;
                            if(admin == 3) {
                                document.getElementById("recovery_id").disabled = true;
                            }

                        </script>
                        <label class="col-sm-1 control-label two-line">Marital Status</label>
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
                        <div class="col-sm-3">
                            <select class="form-control selectpicker" name="race">
                                <option value="Chinese">Chinese</option>
                                <option value="Indian">Indian</option>
                                <option value="Malay">Malay</option>
                                <option value="Others">Others</option>
                            </select>
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
                                <input type="text" class="form-control" name="dob" style="z-index: 1;" required>
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
                            <input type="text" id="nric_format" maxlength="14" class="form-control nric-number" name="nric_new" value="" required>
                        </div>
                        <label class="col-sm-1 control-label">NRIC(Old)</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" maxlength="14" name="nric_old" value="">
                        </div>
                    </div>


                    <hr>
                    <!-- <input type="hidden" name="owner" value="<?php echo $cms->admin->id; ?>"> -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary" value="Add">
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