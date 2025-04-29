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

        <!-- Your awesome content goes here -->
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Collection</strong> Report &emsp; (Total Paid Amount : <strong><?php if(!empty($total_amount['total'])){ ?><?php echo $cms->price($total_amount['total']); }else{echo $cms->price(0);} ?></strong>)</h2>
                    <div class="additional-btn toolbar-action">
                        <a href="#" class="btn btn-primary btn-xs btn-export-date"><i class="fa fa-plus-circle"></i> Export By Date</a>
                        <a href="#" class="btn btn-primary btn-xs btn-export-borrower"><i class="fa fa-plus-circle"></i> Export By Borrower</a>
                    </div>
                </div>
                <?php //print_r($keys); ?>
                <div class="widget-content">
                    <form class="form-inline" role="form">
                        <div class="form-group" style="padding: 10px 20px;">
                            <label class="control-label">Collection Date &nbsp;</label>
                            <input type="text" name="date_from" class="form-control datepicker-input" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $date_from; ?>"> to
                            <input type="text" name="date_to" class="form-control datepicker-input" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $date_to; ?>">
                            <input type="button" class="btn btn-primary btn-filter-date" value="Date Filter">
                        </div>
                    </form>
                    <form class="form-inline" role="form">
                        <div class="form-group" style="padding: 10px 20px;">
                            <label class="control-label">Borrower Name and Loan ID &nbsp;</label>
                            <select id="borrowerID" class="form-control " name="borrowerID">
                                <option value=""> All </option>
                                <?php
                                if($select){
                                    foreach($select as $selection){ ?>
                                        <option value="<?php echo $selection['loan_id']; ?>" <?php echo $selection['loan_id'] == $borrower_id ? ' selected' : ''; ?>><?php echo $selection['full_name'];?> (<?php echo substr($selection['date_created'],0,4).'0'.$selection['loan_id']; ?>)</option>
                                    <?php }
                                } ?>
                            </select>
                            <input type="button" class="btn btn-primary btn-filter-borrower" value="Borrower Filter">
                        </div>
                    </form>
                    <br>
                    <div class="table-responsive">
                        <form class='form-horizontal' role='form'>
                            <table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="c pointer">No. </th>
                                    <th class="c pointer">Borrower Name</th>
                                    <th class="c pointer">Loan ID</th>
                                    <th class="c pointer">Installment Date</th>
                                    <th class="c pointer">Principal Amount</th>
                                    <th width="200" class="c pointer">Monthly Repayment</th>
                                    <th width="250 "class="c pointer">Balance Principal</th>
                                    <th width="150" class="c pointer">Payment Method</th>
                                    <th width="150" class="c pointer">Interest (%)</th>
                                    <th width="150" class="c pointer">Interest</th>
                                    <th width="150" class="c pointer">Principal</th>
                                    <th width="150" class="c pointer">Paid Amount</th>
                                    <th width="150" class="c pointer">Collection Date</th>
                                    <th width="150" class="c pointer">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($keys){
                                    $i =0;
                                    foreach($keys as $key){

                                        if($key['pay_type'] == '1'){
                                            $key['pay_type'] = "Both (Principal + Interest)";
                                        }
                                        if($key['pay_type'] == '2'){
                                            $key['pay_type'] = "Interest Amount";
                                            $key['balance_cf_principal'] += $key['principal'];
                                        }
                                        if($key['pay_type'] == '3'){
                                            $key['pay_type'] = "Rescheduling";
                                        }
                                        if($key['pay_type'] == '4'){
                                            $key['pay_type'] = "Partial Payment";
                                        }
                                        if($key['pay_type'] == '5'){
                                            $key['pay_type'] = "Late Charges";
                                            $key['balance_cf_principal'] += $key['principal'];
                                        }
                                        if($key['pay_type'] == '6'){
                                            $key['pay_type'] = "Full Settlement";
                                        }
                                        ?>
                                        <tr>
                                            <td class="c"><?php echo $i+1 ?></td>
                                            <td class="c" width="25%">
                                                <a href="<?php echo url_for('/borrowers/'.$key['borrower_id']); ?>"><?php echo $key['full_name'] ?></a>
                                            </td>
                                            <td class="c"><?php echo substr($key['date_created'],0,4).'0'.$key['loan_id']; ?></td>
                                            <td class="c"><?php echo $key['payment_date']; ?></td>
                                            <td class="c"><?php echo number_format($key['loan_amt'],2,'.',','); ?></td>
                                            <td class="c"><?php echo number_format($key['actual_amount'], 2, '.', ','); ?></td>
                                            <td class="c"><?php echo number_format($key['balance_cf_principal'], 2, '.', ','); ?></td>
                                            <td class="c"><?php echo $key['pay_type']; ?></td>
                                            <td class="c"><?php echo $key['loan_interest_month']; ?></td>
                                            <td class="c"><?php echo number_format($key['interest'], 2, '.', ','); ?></td>
                                            <td class="c"><?php echo number_format($key['principal'], 2, '.', ','); ?></td>
                                            <td class="c"><?php echo number_format($key['amount_paid'], 2, '.', ','); ?></td>
                                            <td class="c"><?php echo strftime('%d-%m-%Y', strtotime($key['paid_date'])); ?></td>
                                            <?php if($key['amount_paid'] == $key['interest']){ ?>
                                                <td class="c"><?php echo report_status_interest($key['recovery_status']); ?></td>
                                            <?php }else{ ?>
                                                <td class="c"><?php echo report_status($key['recovery_status']); ?></td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <?php echo partial('copy.php'); ?>
            <!-- End of your awesome content -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End content here -->
    <!-- ============================================================== -->

</div>
<!-- End right content -->

<script>
    $(function(){
        $(document).on('click', '.btn-filter-date', function(){
            date_from = $('[name="date_from"]').val();
            date_to = $('[name="date_to"]').val();

            location.href = rootPath + 'report/collection-report?date_from=' + date_from + '&date_to=' + date_to;
        });

        $(document).on('click', '.btn-filter-borrower', function(){
            borrowerID = $('[name="borrowerID"]').val();

            location.href = rootPath + 'report/collection-report?borrowerID=' + borrowerID;
        });

        $(document).on('click', '.btn-export-date', function(){
            date_from = $('[name="date_from"]').val();
            date_to = $('[name="date_to"]').val();

            location.href = rootPath + 'report/collection-report?date_from=' + date_from + '&date_to=' + date_to + '&exportdate=1';
        });

        $(document).on('click', '.btn-export-borrower', function(){
            borrowerID = $('[name="borrowerID"]').val();

            location.href = rootPath + 'report/collection-report?borrowerID=' + borrowerID + '&exportborrower=1';
        });
    });
</script>