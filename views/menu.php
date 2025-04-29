<?php
$dashboard = array('admin','adminInsert','adminUpdate','test','role','roleInsert','roleUpdate','site_settings','analytic','report_loan','report_payment');
$management = array('sliderUpdate','borrowers','borrowerInsert','borrowerUpdate','products','productInsert','productUpdate','holiday','holidayInsert','holidayUpdate','promoCode','promoCodeInsert','promoCodeUpdate');
$articles = array('articles','articleInsert','articleUpdate','pages','pageInsert','pageUpdate');
$report = ['reportLoan','reportPayment','reportCollection','reportCollectionSchedule'];
?>
                <div id="sidebar-menu">
                    <ul>
                        <li><a href="<?php echo url_for('/'); ?>" class="<?php navActive($currPath, array('home','dashboardBadDebt','dashboardCollection','dashboardRecovered','dashboardYearCollection','dashboardNewBorrowers','dashboardTotalBorrowers','dashboardActiveBorrowers','dashboardTotalLoan')); ?>"><i class='icon-home-3'></i><span>Dashboard</span></a></li>

						<!-- BORROWER -->
						<?php if ($cms->admin->vborrower == '1') { ?>
						<li class=><a href="<?php echo url_for('/borrowers'); ?>" class="<?php navActive($currPath, array('borrowers','borrowerInsert','borrowerUpdate')); ?>"><i class='fa fa-users'></i><span>Borrower</span></a></li>
						<?php } ?>

						<!-- LOAN -->
                        <?php if ($cms->admin->vloan == '1') { ?>
						<li class=><a href="<?php echo url_for('/loan'); ?>" class="<?php navActive($currPath, ['loan','loanUpdate','loanInsert']); ?>"><i class='fa fa-dollar'></i><span>Loans</span></a></li>
						<?php } ?>

                        <!-- LOAN APPROVAL -->
                        <?php if ($cms->admin->vloanapproval == '1') { ?>
                            <li class=><a href="<?php echo url_for('/loanApproval'); ?>" class="<?php navActive($currPath, ['loanApproval','loanApprovalUpdate']); ?>"><i class='fa fa-check'></i><span>Finance Approval</span></a></li>
                        <?php } ?>

						<!-- RECOVERY -->
                        <?php if ($cms->admin->vrecovery == '1') { ?>
                        <li><a href="<?php echo url_for('/recovery'); ?>" class="<?php navActive($currPath, ['recovery','recoveryUpdate']); ?>"><i class='fa fa-recycle'></i><span>Recovery</span></a></li>
						<?php } ?>

						<!-- RISK -->
                        <?php if ($cms->admin->vrisk == '1') { ?>
                        <li><a href="<?php echo url_for('/risk'); ?>" class="<?php navActive($currPath, ['risk','riskUpdate']); ?>"><i class='fa fa-recycle'></i><span>Recovery Payment</span></a></li>
						<?php } ?>

                        <!-- Collection -->
                        <?php if ($cms->admin->vcollection == '1') { ?>
                            <li><a href="<?php echo url_for('/collection'); ?>" class="<?php navActive($currPath, ['collection']); ?>"><i class='fa fa-money'></i><span>Collection</span></a></li>
                        <?php } ?>

						<!-- REPORT -->
                        <?php if ($cms->admin->vreportloan == '1' || $cms->admin->vreportpayment == '1' || $cms->admin->vreportcollection == '1' || $cms->admin->vreportcollectionschedule == '1' || $cms->admin->vreportindividual == '1' || $cms->admin->vreporthead == '1' || $cms->admin->vreportsummary == '1') { ?>
                        <li class='has_sub'><a href='javascript:void(0);' class="<?php navActive($currPath, $report); ?>"><i class='fa fa-file-text'></i><span>Reports</span> <span class="pull-right"><i class="fa fa-angle-down"></i></span></a>
                            <ul>
                                <?php if($cms->admin->vreportloan == '1'){ ?> <li><a href="<?php echo url_for('/report/loan'); ?>" class="<?php navActive($currPath, array('reportLoan')); ?>"><span>Loan Creation Report</span></a></li> <?php } ?>
                                <?php if($cms->admin->vreportpayment == '1'){ ?> <li><a href="<?php echo url_for('/report/payment'); ?>" class="<?php navActive($currPath, array('reportPayment')); ?>"><span>Payment Report</span></a></li> <?php } ?>
                                <?php if($cms->admin->vreportcollection == '1'){ ?> <li><a href="<?php echo url_for('/report/collection-report'); ?>" class="<?php navActive($currPath, array('reportCollectionReport')); ?>"><span>Collection Report</span></a></li> <?php } ?>
                                <?php if($cms->admin->vreportcollectionschedule == '1'){ ?> <li><a href="<?php echo url_for('/report/collection-schedule-report'); ?>" class="<?php navActive($currPath, array('reportCollectionScheduleReport')); ?>"><span>Collection Schedule Report</span></a></li> <?php } ?>
                                <?php if($cms->admin->vreportindividual == '1'){ ?> <li><a href="<?php echo url_for('/report/individualcollection'); ?>" class="<?php navActive($currPath, array('individualcollection')); ?>"><span>Individual Collection Report</span></a></li> <?php } ?>
                                <?php if($cms->admin->vreporthead == '1'){ ?> <li><a href="<?php echo url_for('/report/headcollection'); ?>" class="<?php navActive($currPath, array('headcollection')); ?>"><span>Head Collection Report</span></a></li> <?php } ?>
                                <?php if($cms->admin->vreportsummary == '1'){ ?> <li><a href="<?php echo url_for('/report/summarycollection'); ?>" class="<?php navActive($currPath, array('summarycollection')); ?>"><span>Summary Collection Report</span></a></li> <?php } ?>
                            </ul>
                        </li>
						<?php } ?>

						<!-- PROFILE -->
						<li><a href="<?php echo url_for('/profile'); ?>" class="<?php navActive($currPath, 'profile'); ?>"><i class='fa fa-gear'></i><span>Update Profile</span></a></li>

						<!-- SETTINGS -->
						<?php if (in_array($cms->admin->role, [1, 2])) { ?>
                        <li class='has_sub'><a href='javascript:void(0);' class="<?php navActive($currPath, $dashboard); ?>"><i class='fa fa-gear'></i><span>Settings</span> <span class="pull-right"><i class="fa fa-angle-down"></i></span></a>
                            <ul>

                                <li><a href="<?php echo url_for('/role'); ?>" class="<?php navActive($currPath, array('role','roleInsert','roleUpdate')); ?>"><span>Role Management</span></a></li>
                                <li><a href="<?php echo url_for('/admin'); ?>" class="<?php navActive($currPath, array('admin','adminInsert','adminUpdate')); ?>"><span>Administrator Management</span></a></li>
                                <!--li><a href="<?php echo url_for('/settings'); ?>" class="<?php navActive($currPath, 'site_settings'); ?>"><span>Website Settings</span></a></li-->
                                <!--li><a href="<?php echo url_for('/slider'); ?>" class="<?php navActive($currPath, array('sliderUpdate')); ?>"><span>Slider</span></a></li-->
								<!--li><a href="<?php echo url_for('/analytic'); ?>" class="<?php navActive($currPath, 'analytic'); ?>"><span>Visitor Analytics</span></a></li-->
                            </ul>
                        </li>
						<?php } ?>

                    </ul>
                    <div class="clearfix"></div>
                </div>


       

