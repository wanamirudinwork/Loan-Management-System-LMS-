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
								
						<?php //print_r($role); ?>
				<!-- Your awesome content goes here -->
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Update</strong> Role</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-sm-2 control-label">Role ID</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" value="<?php echo $role['role_id']; ?>" disabled>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Role Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name" value="<?php echo $role['role_name']; ?>">
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Role Type</label>
                                <div class="col-sm-10">
                                    <div class="radio-group">
                                        <div class="radio">
                                            <?php if ($role['role_type'] == '1') { ?>
                                            <label><input type="radio" name="optradio" value="1" checked> Recovery Team Leader</label>
                                            <?php } else { ?>
                                            <label><input type="radio" name="optradio" value="1"> Recovery Team Leader</label>
                                            <?php } ?>
                                        </div>
                                        <div class="radio">
                                            <?php if ($role['role_type'] == '2') { ?>
                                            <label><input type="radio" name="optradio" value="2" checked> Recovery Head</label>
                                            <?php } else { ?>
                                            <label><input type="radio" name="optradio" value="2"> Recovery Head</label>
                                            <?php } ?>
                                        </div>
                                        <div class="radio">
                                            <?php if ($role['role_type'] == '3') { ?>
                                            <label><input type="radio" name="optradio" value="3" checked> Recovery Officer</label>
                                            <?php } else { ?>
                                            <label><input type="radio" name="optradio" value="3"> Recovery Officer</label>
                                            <?php } ?>
                                        </div>
                                        <div class="radio">
                                            <?php if ($role['role_type'] == '0') { ?>
                                            <label><input type="radio" name="optradio" value="0" checked> Others</label>
                                            <?php } else { ?>
                                            <label><input type="radio" name="optradio" value="0"> Others</label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Permission</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="checkbox-group">
                                                <div class="checkbox">
                                                    <label><i class="fa fa-dashboard" aria-hidden="true"></i><b> Dashboard</b></label>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['new_borrower_d'] == '1') { ?>
                                                        <label><input type="checkbox" name="newborrowerd" value="1" checked>New Borrowers</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="newborrowerd" value="1">New Borrower</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['active_borrower_d'] == '1') { ?>
                                                        <label><input type="checkbox" name="activeborrower" value="1" checked>Active Borrower</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="activeborrower" value="1">Active Borrower</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['borrower_statistic_d'] == '1') { ?>
                                                        <label><input type="checkbox" name="borrowerstatistic" value="1" checked>Borrower Statistic</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="borrowerstatistic" value="1">Borrower Statistic</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['total_borrower_d'] == '1') { ?>
                                                        <label><input type="checkbox" name="totalborrowerd" value="1" checked>Total Borrowers</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="totalborrowerd" value="1">Total Borrowers</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['total_loan_d'] == '1') { ?>
                                                        <label><input type="checkbox" name="totalloand" value="1" checked>Total Loan</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="totalloand" value="1">Total Loan</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['total_recovered_d'] == '1') { ?>
                                                        <label><input type="checkbox" name="totalrecoveredd" value="1" checked>Total Recovered</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="totalrecoveredd" value="1">Total Recovered</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['total_collection_d'] == '1') { ?>
                                                        <label><input type="checkbox" name="totalcollectiond" value="1" checked>Total Collection</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="totalcollectiond" value="1">Total Collection</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['total_bad_debt_d'] == '1') { ?>
                                                        <label><input type="checkbox" name="totalbaddebtd" value="1" checked>Total Bad Debt</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="totalbaddebtd" value="1">Total Bad Debt</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['years_of_collection'] == '1') { ?>
                                                        <label><input type="checkbox" name="yearsofcollection" value="1" checked>Year of Collection</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="yearsofcollection" value="1">Year of Collection</label>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox-group">
                                                <div class="checkbox">
                                                    <label><i class="fa fa-eye" aria-hidden="true"></i><b> View</b></label>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_borrower'] == '1') { ?>
                                                        <label><input type="checkbox" name="vborrower" value="1" checked>Borrower</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vborrower" value="1">Borrower</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_loan'] == '1') { ?>
                                                        <label><input type="checkbox" name="vloan" value="1" checked>Loan</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vloan" value="1">Loan</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_loan_approval'] == '1') { ?>
                                                        <label><input type="checkbox" name="vloanapproval" value="1" checked>Finance</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vloanapproval" value="1">Finance</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_recovery'] == '1') { ?>
                                                        <label><input type="checkbox" name="vrecovery" value="1" checked>Recovery</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vrecovery" value="1">Recovery</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_risk'] == '1') { ?>
                                                        <label><input type="checkbox" name="vrisk" value="1" checked>Risk</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vrisk" value="1">Risk</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_approval'] == '1') { ?>
                                                        <label><input type="checkbox" name="vapproval" value="1" checked>Approval Loan/Borrower</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vapproval" value="1">Approval Loan/Borrower</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_collection'] == '1') { ?>
                                                        <label><input type="checkbox" name="vcollection" value="1" checked>Collection</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vcollection" value="1">Collection</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_report_loan'] == '1') { ?>
                                                        <label><input type="checkbox" name="vreportloan" value="1" checked>Report Loan Creation</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vreportloan" value="1">Report Loan Creation</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_report_payment'] == '1') { ?>
                                                        <label><input type="checkbox" name="vreportpayment" value="1" checked>Report Payment</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vreportpayment" value="1">Report Payment</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_report_collection'] == '1') { ?>
                                                        <label><input type="checkbox" name="vreportcollection" value="1" checked>Report Collection</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vreportcollection" value="1">Report Collection</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_report_collection_schedule'] == '1') { ?>
                                                        <label><input type="checkbox" name="vreportcollectionschedule" value="1" checked>Report Collection Schedule</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vreportcollectionschedule" value="1">Report Collection Schedule</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_report_individual'] == '1') { ?>
                                                        <label><input type="checkbox" name="vreportindividual" value="1" checked>Report Individual Collection</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vreportindividual" value="1">Report Individual Collection</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_report_head'] == '1') { ?>
                                                        <label><input type="checkbox" name="vreporthead" value="1" checked>Report Head Collection</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vreporthead" value="1">Report Head Collection</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['view_report_summary'] == '1') { ?>
                                                        <label><input type="checkbox" name="vreportsummary" value="1" checked>Report Summary Collection</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="vreportsummary" value="1">Report Summary Collection</label>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox-group">
                                                <div class="checkbox">
                                                    <label><i class="fa fa-pencil" aria-hidden="true"></i><b> Manage</b></label>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['manage_borrower'] == '1') { ?>
                                                        <label><input type="checkbox" name="mborrower" value="1" checked>Borrower</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="mborrower" value="1">Borrower</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['manage_loan'] == '1') { ?>
                                                        <label><input type="checkbox" name="mloan" value="1" checked>Loan</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="mloan" value="1">Loan</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['manage_loan_approval'] == '1') { ?>
                                                        <label><input type="checkbox" name="mloanapproval" value="1" checked>Finance</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="mloanapproval" value="1">Finance</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['manage_recovery'] == '1') { ?>
                                                        <label><input type="checkbox" name="mrecovery" value="1" checked>Recovery</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="mrecovery" value="1">Recovery</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['manage_risk'] == '1') { ?>
                                                        <label><input type="checkbox" name="mrisk" value="1" checked>Risk</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="mrisk" value="1">Risk</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['manage_approval'] == '1') { ?>
                                                        <label><input type="checkbox" name="mapproval" value="1" checked>Approval Loan/Borrower</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="mapproval" value="1">Approval Loan/Borrower</label>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox-group">
                                                <div class="checkbox">
                                                    <label><i class="fa fa-trash" aria-hidden="true"></i><b> Delete</b></label>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['delete_borrower'] == '1') { ?>
                                                        <label><input type="checkbox" name="dborrower" value="1" checked>Borrower</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="dborrower" value="1">Borrower</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="checkbox">
                                                    <?php if ($role['delete_loan'] == '1') { ?>
                                                        <label><input type="checkbox" name="dloan" value="1" checked>Loan</label>
                                                    <?php } else { ?>
                                                        <label><input type="checkbox" name="dloan" value="1">Loan</label>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Status</label>
                            	<div class="col-sm-10">
									<select class="form-control selectpicker" name="status">
                                    	<option value="1"<?php echo $role['role_status'] == '1' ? ' selected' : ''; ?>><?php echo lstatus('1'); ?></option>
                                    	<option value="0"<?php echo $role['role_status'] == '0' ? ' selected' : ''; ?>><?php echo lstatus('0'); ?></option>
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
