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
                    <h2><strong>Loan Creation</strong> Report</h2>
                    <div class="additional-btn toolbar-action">
                        <a href="#" class="btn btn-primary btn-xs btn-export"><i class="fa fa-plus-circle"></i> Export to CSV</a>
                    </div>
                </div>
                <?php //print_r($keys); ?>
                <div class="widget-content">
                    <form class="form-inline" role="form">
                        <div class="form-group" style="padding: 10px 20px;">
                            <label class="control-label">Date Range</label>
                            <input type="text" name="date_from" class="form-control datepicker-input" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $date_from; ?>"> to
                            <input type="text" name="date_to" class="form-control datepicker-input" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $date_to; ?>">
                            <input type="button" class="btn btn-primary btn-filter-date" value="Filter">
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
                                    <th width="200" class="c pointer">Loan Creation Date</th>
                                    <th width="250 "class="c pointer">Loan Amount (RM)</th>
                                    <th width="150" class="c pointer">Terms (Years)</th>
                                    <th width="150" class="c pointer">Interest (%)</th>
                                    <th width="150" class="c pointer">Loan Status</th>
                                    <th width="150" class="c pointer">Created By</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($keys){
                                    $i =0;
                                    foreach($keys as $key){

                                        if($key['loan_term'] == 0 || $key['loan_term'] == ""){
                                            $key['loan_term'] = "Interest Only";
                                        }
                                        ?>
                                        <tr>
                                            <td class="c"><?php echo $i+1 ?></td>
                                            <td class="c" width="25%">
                                                <a href="<?php echo url_for('/borrowers/'.$key['borrower_id']); ?>"><?php echo $key['full_name'] ?></a>
                                            </td>
                                            <td class="c"><?php echo substr($key['date_created'],0,4).'0'.$key['loan_id']; ?></td>
                                            <td class="c"><?php echo $key['date_created']; ?></td>
                                            <td class="c"><?php echo number_format($key['loan_amt'],2,'.',','); ?></td>
                                            <td class="c"><?php echo $key['loan_term']; ?></td>
                                            <td class="c"><?php echo $key['loan_interest_month']; ?>%</td>
                                            <td class="c"><?php echo default_status($key['loan_status']); ?></td>
                                            <td class="c"><?php echo $key['created_by']; ?></td>
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

            location.href = rootPath + 'report/loan?date_from=' + date_from + '&date_to=' + date_to;
        });

        $(document).on('click', '.btn-export', function(){
            date_from = $('[name="date_from"]').val();
            date_to = $('[name="date_to"]').val();

            location.href = rootPath + 'report/loan?date_from=' + date_from + '&date_to=' + date_to + '&export=1';
        });
    });
</script>