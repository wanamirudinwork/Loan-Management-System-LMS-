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
                <h2><strong>Update</strong> Admin</h2>
            </div>
            <div class="widget-content padding">
                <form id="selfForm" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $admin['admin_username']; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" placeholder="****" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" placeholder="****" name="confirmPassword">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="<?php echo $admin['admin_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Contact Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="contact" value="<?php echo $admin['admin_contact']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" value="<?php echo $admin['admin_email']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-control selectpicker" name="role">
                                <?php
                                if($role){
                                    foreach($role as $keys){

                                        if($keys['role_id'] == $admin['admin_role']){
                                            $selected = 'selected';
                                        }else{
                                            $selected = '';
                                        }
                                        ?>

                                        <option value="<?php echo $keys['role_id'] ?>" <?php echo $selected; ?>><?php echo $keys['role_name']; ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php if($admin['role_type'] == '3'){ ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Reporting To</label>
                        <div class="col-sm-10">
                            <select class="form-control selectpicker" name="head">
                                <?php
                                if($type){
                                    ?><option value="0">Nothing Selected</option><?php
                                    foreach($type as $keys){
                                        ?>
                                        <option value="<?php echo $keys['admin_id']; ?>" <?php echo $team['head_id'] == $keys['admin_id'] ? ' selected' : ''; ?>><?php echo $keys['admin_name']; ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control selectpicker" name="status">
                                <option value="1"<?php echo  ($admin['admin_status']) == '1' ? ' selected' : ''; ?>><?php echo lstatus('1'); ?></option>
                                <option value="0"<?php echo  ($admin['admin_status'] )== '0' ? ' selected' : ''; ?>><?php echo lstatus('0'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary" value="Update">
                            <input type="button" class="btn btn-default back" value="Back">
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