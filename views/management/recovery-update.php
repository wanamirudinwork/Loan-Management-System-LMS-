
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

        <!-- Your awesome content goes here -->
        <div class="widget">
            <div class="widget-header transparent">
                <h2><strong>Record  </strong>Collection </h2>
            </div>
            <?php //print_r($recovery); ?>
            <?php //print_r($borrower); ?>
            <div class="widget-content padding">
                <form id="backForm" class="form-horizontal" role="form">
                    <!-- some hidden data -->
                    <input type="hidden" name="borrower_id" value="<?php echo $recovery['borrower_id']; ?>">
                    <input type="hidden" name="installment_id" value="<?php echo $recovery['installment_id']; ?>">
                    <input type="hidden" name="loan_id" value="<?php echo $recovery['loan_id']; ?>">
                    <input type="hidden" name="actual_amount" value="<?php echo $recovery['installment_amt']; ?>">
                    <input type="hidden" name="interest" value="<?php echo $recovery['interest']; ?>">
                    <input type="hidden" name="principal" value="<?php echo $recovery['principal']; ?>">
                    <input type="hidden" name="balance_bf_principal" value="<?php echo $recovery['balance_bf_principal']; ?>">
                    <input type="hidden" name="loan_date" value="<?php echo $recovery['loan_date']; ?>">
                    <input type="hidden" name="terms" value="<?php echo $recovery['terms']; ?>">
                    <!-- displaying lender name  -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Total Principal Due</label>
                        <div class="col-sm-3">
                            <label style="font-size:18px;">RM <?php echo number_format($recovery['balance_bf_principal']); ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Amount Due</label>
                        <div class="col-sm-3">
                            <label style="font-size:18px;">RM <?php echo number_format($recovery['installment_amt']); ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label " for="borrowerID">Borrower Name</label>
                        <div class="col-sm-3">
                            <label style="font-size:18px;"><?php echo $borrower['full_name']; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Collection For</label>
                        <div class="col-sm-3">
                            <select class="form-control selectpicker" name="paid_for" onchange="showAmount(this)" required>
                                <?php if($recovery['terms'] >= 1){ ?>
                                    <option value="0">- Select -</option>
                                    <option value="1">Both (Principal + Interest)</option>
                                    <option value="2">Interest Amount</option>
                                    <option value="4">Partial Payment</option>
                                    <option value="5">Late Charges</option>
                                    <option value="3">Rescheduling</option>
                                    <option value="6">Full Settlement</option>
                                <?php }else{ ?>
                                    <option value="0">- Select -</option>
                                    <option value="1">Both (Principal + Interest)</option>
                                    <option value="5">Late Charges</option>
                                    <option value="6">Full Settlement</option>
                                <?php } ?>
                            </select>
                        </div>
                        <label id="amount_title" class="col-sm-2 control-label" hidden>Amount: </label>
                        <label id="amount_title_full" class="col-sm-2 control-label" hidden>Full Settlement Amount: </label>
                        <div class="col-sm-2">
                            <input type="text" id="amount_show" style="font-size:18px;" class="form-control" name="amount_show" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="terms_title" class="col-sm-2 control-label">Terms (months): </label>
                        <div class="col-sm-3">
                            <input type="text" id="new_terms" style="font-size:18px;" class="form-control" name="new_terms">
                        </div>
                        <label id="amount_title_res" class="col-sm-2 control-label">New Principal Amount: </label>
                        <div class="col-sm-3">
                            <input type="text" id="amount_show_res" style="font-size:18px;" class="form-control" name="amount_show_res" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="interest_title" class="col-sm-2 control-label">Interest (%): </label>
                        <div class="col-sm-3">
                            <input type="text" id="new_interest" style="font-size:18px;" class="form-control" name="new_interest">
                        </div>
                        <label id="loan_date_title" class="col-sm-2 control-label">Loan Date: </label>
                        <div class="col-sm-3">
                            <div class="input-group date" id="new_loan_date">
                                <input type="text" class="form-control" style="font-size:18px;" name="new_loan_date">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="remarks_title" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-2">
                            <textarea id="remarks" style="width:400%;" class="form-control" name="remarks" ><?php if(!empty($remarks['remarks'])){echo $remarks['remarks'];} ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="receipt_title" class="col-sm-2 control-label">Attach Receipt</label>
                        <div id="receipt" class="col-sm-10">
                            <div class="sortable">
                                <?php if($receipts){ foreach($receipts as $i => $receipt){ ?>
                                    <div class="multiImg">
                                        <img src="<?php echo imgCrop($receipt['src']); ?>" style="display:table;margin:5px;max-width:200px;max-height:100px;">
                                        <input id="photo<?php echo $i+1; ?>" name="images[<?php echo $i+1; ?>][src]" value="<?php echo $receipt['src']; ?>" type="hidden">
                                        <input name="images[<?php echo $i+1; ?>][alt]" class="form-control" placeholder="LABEL" value="<?php echo $receipt['alt']; ?>" type="text">
                                        <a href="javascript:void(0)" onclick="kcFinderB('photo<?php echo $i+1; ?>')">Browse</a> |
                                        <a href="javascript:void(0)" onclick="kcFinderR('photo<?php echo $i+1; ?>')">Cancel</a>
                                    </div>
                                <?php }} ?>
                            </div>
                            <div class="addMultiImg">
                                <a href="javascript:;" class="btn btn-default"><i class="fa fa-plus"></i> Add Image</a>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById("terms_title").style.visibility = "hidden";
                        document.getElementById("new_terms").style.visibility = "hidden";
                        document.getElementById("interest_title").style.visibility = "hidden";
                        document.getElementById("new_interest").style.visibility = "hidden";
                        document.getElementById("amount_title").hidden = false;
                        document.getElementById("amount_title_full").hidden = true;
                        document.getElementById("amount_title_res").style.visibility = "hidden";
                        document.getElementById("amount_show_res").style.visibility = "hidden";
                        document.getElementById("loan_date_title").style.visibility = "hidden";
                        document.getElementById("new_loan_date").style.visibility = "hidden";

                        function showAmount(select){
                            if(select.value == '1'){
                                document.getElementById("amount_title").hidden = false;
                                document.getElementById("amount_title_full").hidden = true;
                                document.getElementById("amount_show").style.visibility = "visible";
                                document.getElementById("amount_show").value = <?php echo $recovery['installment_amt']; ?>;
                                document.getElementById("amount_show").disabled = true;
                                document.getElementById("terms_title").style.visibility = "hidden";
                                document.getElementById("new_terms").style.visibility = "hidden";
                                document.getElementById("interest_title").style.visibility = "hidden";
                                document.getElementById("new_interest").style.visibility = "hidden";
                                document.getElementById("new_terms").required = false;
                                document.getElementById("new_interest").required = false;
                                document.getElementById("amount_title_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").required = false;
                                document.getElementById("loan_date_title").style.visibility = "hidden";
                                document.getElementById("new_loan_date").style.visibility = "hidden";
                                document.getElementById("remarks_title").style.visibility = "visible";
                                document.getElementById("remarks").style.visibility = "visible";
                                document.getElementById("receipt_title").style.visibility = "visible";
                                document.getElementById("receipt").style.visibility = "visible";
                            }else if(select.value == '2'){
                                document.getElementById("amount_title").hidden = false;
                                document.getElementById("amount_title_full").hidden = true;
                                document.getElementById("amount_show").style.visibility = "visible";
                                document.getElementById("amount_show").value = <?php echo $recovery['interest']; ?>;
                                document.getElementById("amount_show").disabled = true;
                                document.getElementById("terms_title").style.visibility = "hidden";
                                document.getElementById("new_terms").style.visibility = "hidden";
                                document.getElementById("interest_title").style.visibility = "hidden";
                                document.getElementById("new_interest").style.visibility = "hidden";
                                document.getElementById("new_terms").required = false;
                                document.getElementById("new_interest").required = false;
                                document.getElementById("amount_title_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").required = false;
                                document.getElementById("loan_date_title").style.visibility = "hidden";
                                document.getElementById("new_loan_date").style.visibility = "hidden";
                                document.getElementById("remarks_title").style.visibility = "visible";
                                document.getElementById("remarks").style.visibility = "visible";
                                document.getElementById("receipt_title").style.visibility = "visible";
                                document.getElementById("receipt").style.visibility = "visible";
                            }else if(select.value == '3'){
                                document.getElementById("amount_title").hidden = true;
                                document.getElementById("amount_title_full").hidden = true;
                                document.getElementById("amount_show").style.visibility = "hidden";
                                document.getElementById("terms_title").style.visibility = "visible";
                                document.getElementById("new_terms").style.visibility = "visible";
                                document.getElementById("new_terms").required = true;
                                document.getElementById("amount_title_res").style.visibility = "visible";
                                document.getElementById("amount_show_res").style.visibility = "visible";
                                document.getElementById("amount_show_res").disabled = false;
                                document.getElementById("amount_show_res").value = "";
                                document.getElementById("amount_show_res").required = true;
                                document.getElementById("interest_title").style.visibility = "visible";
                                document.getElementById("new_interest").style.visibility = "visible";
                                document.getElementById("new_interest").required = true;
                                document.getElementById("loan_date_title").style.visibility = "visible";
                                document.getElementById("new_loan_date").style.visibility = "visible";
                                document.getElementById("remarks_title").style.visibility = "hidden";
                                document.getElementById("remarks").style.visibility = "hidden";
                                document.getElementById("receipt_title").style.visibility = "hidden";
                                document.getElementById("receipt").style.visibility = "hidden";
                            }else if(select.value == '4'){
                                document.getElementById("amount_title").hidden = false;
                                document.getElementById("amount_title_full").hidden = true;
                                document.getElementById("amount_show").style.visibility = "visible";
                                document.getElementById("amount_show").disabled = false;
                                document.getElementById("amount_show").value = "";
                                document.getElementById("terms_title").style.visibility = "hidden";
                                document.getElementById("new_terms").style.visibility = "hidden";
                                document.getElementById("interest_title").style.visibility = "hidden";
                                document.getElementById("new_interest").style.visibility = "hidden";
                                document.getElementById("new_terms").required = false;
                                document.getElementById("new_interest").required = false;
                                document.getElementById("amount_title_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").required = false;
                                document.getElementById("loan_date_title").style.visibility = "hidden";
                                document.getElementById("new_loan_date").style.visibility = "hidden";
                                document.getElementById("remarks_title").style.visibility = "visible";
                                document.getElementById("remarks").style.visibility = "visible";
                                document.getElementById("receipt_title").style.visibility = "visible";
                                document.getElementById("receipt").style.visibility = "visible";
                            }else if(select.value == '5'){
                                document.getElementById("amount_title").hidden = false;
                                document.getElementById("amount_title_full").hidden = true;
                                document.getElementById("amount_show").style.visibility = "visible";
                                document.getElementById("amount_show").disabled = false;
                                document.getElementById("amount_show").value = "";
                                document.getElementById("terms_title").style.visibility = "hidden";
                                document.getElementById("new_terms").style.visibility = "hidden";
                                document.getElementById("interest_title").style.visibility = "hidden";
                                document.getElementById("new_interest").style.visibility = "hidden";
                                document.getElementById("new_terms").required = false;
                                document.getElementById("new_interest").required = false;
                                document.getElementById("amount_title_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").required = false;
                                document.getElementById("loan_date_title").style.visibility = "hidden";
                                document.getElementById("new_loan_date").style.visibility = "hidden";
                                document.getElementById("remarks_title").style.visibility = "visible";
                                document.getElementById("remarks").style.visibility = "visible";
                                document.getElementById("receipt_title").style.visibility = "visible";
                                document.getElementById("receipt").style.visibility = "visible";
                            }else if(select.value == '6'){
                                document.getElementById("amount_title").hidden = true;
                                document.getElementById("amount_title_full").hidden = false;
                                document.getElementById("amount_show").style.visibility = "visible";
                                document.getElementById("amount_show").value = <?php echo $recovery['balance_bf_principal']; ?>;
                                document.getElementById("amount_show").disabled = false;
                                document.getElementById("terms_title").style.visibility = "hidden";
                                document.getElementById("new_terms").style.visibility = "hidden";
                                document.getElementById("interest_title").style.visibility = "hidden";
                                document.getElementById("new_interest").style.visibility = "hidden";
                                document.getElementById("new_terms").required = false;
                                document.getElementById("new_interest").required = false;
                                document.getElementById("amount_title_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").style.visibility = "hidden";
                                document.getElementById("amount_show_res").required = false;
                                document.getElementById("loan_date_title").style.visibility = "hidden";
                                document.getElementById("new_loan_date").style.visibility = "hidden";
                                document.getElementById("remarks_title").style.visibility = "visible";
                                document.getElementById("remarks").style.visibility = "visible";
                                document.getElementById("receipt_title").style.visibility = "visible";
                                document.getElementById("receipt").style.visibility = "visible";
                            }
                        }

                    </script>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary" value="Update">
                            <input type="button" class="btn btn-default" value="Back" onclick="history.back()">

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
