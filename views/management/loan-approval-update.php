
</script>
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
        <?php //print_r($_REQUEST); ?>
        <!-- Your awesome content goes here -->
        <div class="widget">
            <div class="widget-header transparent">
                <h2><strong>Update  </strong>New Loan Details | <a href="<?php echo url_for('/loan/recovery/'.$loan['loan_id']); ?>"><b>Recovery Schedule</b></a>

                </h2>

            </div>
            <?php //print_r($loan); ?>
            <?php //print_r($borrower); ?>
            <div class="widget-content padding">


                <form id="backForm" class="form-horizontal" role="form">
                    <!-- displaying lender name  -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label " for="borrowerID">Borrower Name</label>
                        <div class="col-sm-10">
                            <select id="borrowerID" class="form-control " name="borrowerID">
                                <?php

                                if($borrower){ ?>
                                    <option value="<?php echo $loan['borrower_id']; ?>"><?php echo $borrower['full_name'];?></option>
                                <?php } ?>



                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Recommended by</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="recommended_by" value="<?php echo $loan['recommended_by']; ?>" readonly="readonly">
                        </div>
                        <label class="col-sm-2 control-label">Commissions</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="commission" value="<?php echo $loan['commission']; ?>" readonly="readonly">
                        </div>
                    </div>

                    <hr>
                    <h4>Loan Structure</h4>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Amount Borrowed *</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="amount" required  value="<?php echo $loan['loan_amt']; ?>" readonly="readonly">
                        </div>
                        <label class="col-sm-2 control-label">Loan Date *</label>
                        <div class="col-sm-2">
                            <div class="input-group date">
                                <input type="text" class="form-control" name="loan_date" style="z-index: 1;" required  value="<?php echo $loan['loan_date']; ?>" readonly="readonly">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Cash Given By Hand</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="cash" value="<?php echo $loan['cash_by_hand']; ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Loan Repayment Terms *</label>
                        <div class="col-sm-2">
                            <select class="form-control selectpicker" name="loan_term">
                                <?php if ($loan['loan_term'] > 0){ ?>
                                    <option value="<?php echo $loan['loan_term'] ?>"><?php echo $loan['loan_term'] ?> months</option>
                                <?php }else{ ?>
                                    <option value="0">Interest Only</option>
                                <?php }	?>
                            </select>
                        </div>
                        <!--label class="col-sm-2 control-label">Interest per Annum *</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="loan_interest_year" required value="<?php echo $loan['loan_interest_year']; ?>">
									</div-->
                        <label class="col-sm-2 control-label">Interest per Month *</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="loan_interest_month" required value="<?php echo $loan['loan_interest_month']; ?>" readonly="readonly">
                        </div>
                        <label class="col-sm-2 control-label">Stamp Duty Fees</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="stamp" value="<?php echo $loan['stamp_duty_fees']; ?>" readonly="readonly">
                        </div>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label class="col-sm-2 control-label">Principal Paid</label>-->
<!--                        <div class="col-sm-2">-->
<!--                            <input type="text" class="form-control" name="principal" value="--><?php //echo $loan['principal_paid']; ?><!--" readonly="readonly">-->
<!--                        </div>-->
<!--                        <label class="col-sm-2 control-label">Principal Paid Date *</label>-->
<!--                        <div class="col-sm-2">-->
<!--                            <div class="input-group date">-->
<!--                                <input type="text" class="form-control" name="principal_date" style="z-index: 1;" value="--><?php //echo $loan['principal_paid_date']; ?><!--" readonly="readonly">-->
<!--                                <div class="input-group-addon">-->
<!--                                    <span class="glyphicon glyphicon-th"></span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <?php if ($cms->admin->mloanapproval == '1') { ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control selectpicker" name="status" onchange="show(this)">
                                    <?php if ($loan['reschedule'] == '1') { ?>
                                        <option value="8"<?php echo $loan['loan_status'] == 8 ? ' selected' : ''; ?>><?php if($loan['loan_status'] == '8'){echo default_status('8');}else{echo loanApproval_status('1');} ?></option>
                                    <?php }else{ ?>
                                        <option value="1"<?php echo $loan['loan_status'] == 1 ? ' selected' : ''; ?>><?php echo loanApproval_status('1'); ?></option>
                                    <?php } ?>
                                    <option value="4"<?php echo $loan['loan_status'] == 4 ? ' selected' : ''; ?>><?php echo loanApproval_status('4'); ?></option>
                                    <option value="7"<?php echo $loan['loan_status'] == 3 ? ' selected' : ''; ?>><?php echo loanApproval_status('3'); ?></option>
                                </select>
                            </div>
                        </div>
                    <?php } else if ($cms->admin->vloanapproval == '1') { ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control selectpicker" name="status" onchange="show(this)">
                                    <?php if ($loan['loan_status'] == '1') { ?>
                                        <option value="1"<?php echo $loan['loan_status'] == 1 ? ' selected' : ''; ?>><?php echo loanApproval_status('1'); ?></option>
                                    <?php } else if ($loan['loan_status'] == '4') { ?>
                                        <option value="4"<?php echo $loan['loan_status'] == 4 ? ' selected' : ''; ?>><?php echo loanApproval_status('4'); ?></option>
                                    <?php } else if ($loan['loan_status'] == '3') { ?>
                                        <option value="7"<?php echo $loan['loan_status'] == 3 ? ' selected' : ''; ?>><?php echo loanApproval_status('3'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } else if ($cms->admin->vloanapproval == NULL || $cms->admin->vloanapproval == '0') { ?>
                        <div class="form-group" style="display:none;">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control selectpicker" name="status" onchange="show(this)">
                                    <?php if ($loan['loan_status'] == '1') { ?>
                                        <option value="1"<?php echo $loan['loan_status'] == 1 ? ' selected' : ''; ?>><?php echo loanApproval_status('1'); ?></option>
                                    <?php } else if ($loan['loan_status'] == '4') { ?>
                                        <option value="4"<?php echo $loan['loan_status'] == 4 ? ' selected' : ''; ?>><?php echo loanApproval_status('4'); ?></option>
                                    <?php } else if ($loan['loan_status'] == '3') { ?>
                                        <option value="7"<?php echo $loan['loan_status'] == 3 ? ' selected' : ''; ?>><?php echo loanApproval_status('3'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                    <div id="rejection" class="form-group">
                        <label  class="col-sm-2 control-label">Rejection Reason</label>
                        <div class="col-sm-8">
                            <textarea style="font-size:18px;" class="form-control" name="rejection"><?php echo $loan['rejection']; ?></textarea>
                        </div>
                    </div>
                    <script>
                        document.getElementById("rejection").style.visibility = "hidden";
                        function show(select){
                            if(select.value == '7'){
                                document.getElementById("rejection").style.visibility = "visible";

                            }
                            else if(select.value == '2'){
                                document.getElementById("rejection").style.visibility = "hidden";

                            }
                            else if(select.value == '1'){
                                document.getElementById("rejection").style.visibility = "hidden";

                            }}
                    </script>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary" value="Update" <?php if($loan['loan_status']=='1') echo "disabled"; ?>>
                            <input type="button" class="btn btn-default" value="Back" onclick="history.back()">

                            <a href="<?php echo url_for('/loan/'.$loan['loan_id'].'/export/pdf'); ?>" target="_blank" class="btn btn-success btn-m"><i class="fa fa-pencil"></i> Export Lampiran to PDF</a>
                            <a href="#" target="_blank" class="btn btn-export btn-success btn-m"><i class="fa fa-pencil"></i> Export Lampiran to .CSV</a>
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
<script>

    $(function(){
        $(document).on('click', '.btn-export', function(){
            location.href = rootPath + 'loan/<?php echo $loan['loan_id'];?>/export/csv';
        });
    });
</script>
