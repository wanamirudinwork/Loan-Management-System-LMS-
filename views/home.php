		<style>
			.output {
			  font-weight:bold;
			}
			#payment {
			  text-decoration:underline;
			}

			th, td {
			  vertical-align: top;
			}
		</style>
		<script>
		function pmtcalculate() {
			var amount = document.getElementById("amount");
			var apr = document.getElementById("apr");
			var years = document.getElementById("years");
			var payment = document.getElementById("payment");
			var total = document.getElementById("total");
			var totalinterest = document.getElementById("totalinterest");

			var principal = parseFloat(amount.value);
			var interest = parseFloat(apr.value) / 100 / 12;
			var payments = parseFloat(years.value) * 12;

			var x = Math.pow(1 + interest, payments); 
			var monthly = (principal * x * interest) / (x - 1);

			if (isFinite(monthly)) {
				payment.innerHTML = monthly.toFixed(2);
				total.innerHTML = (monthly * payments).toFixed(2);
				totalinterest.innerHTML = (monthly * payments - principal).toFixed(2);
			}
		}
		</script>
		
		<!-- Start right content -->
        <div class="content-page">
			<!-- ============================================================== -->
			<!-- Start Content here -->
			<!-- ============================================================== -->
            <div class="content">
            	<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='icon-home-3'></i> Dashboard</h1>
				</div>
            	<!-- Page Heading End-->
                <?php //print_r($total); ?>               
                <!-- Start info box -->
				<div class="row top-summary">
                    <?php if ($cms->admin->newborrowerd == '1') {?>
					<div class="col-lg-3 col-md-6">
						<div class="widget blue-3 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="icon-globe-inv"></i>
								</div>
								<div class="text-box">
                                    <a href="<?php echo url_for('/dashboard-new-borrowers/'); ?>">
                                        <p class="maindata">NEW <b>BORROWERS</b></p>
                                        <h2><span class="animate-number" data-value="<?php echo $total['new_borrowers']; ?>" data-duration="1000">0</span></h2>
                                        <div class="clearfix"></div>
                                    </a>
								</div>
							</div>
						</div>
					</div>
                    <?php } if ($cms->admin->totalloand == '1') {?>
					<div class="col-lg-3 col-md-6">
						<div class="widget darkblue-2 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="icon-bag"></i>
								</div>
								<div class="text-box">
                                    <a href="<?php echo url_for('/dashboard-total-loan/'); ?>">
                                        <p class="maindata">TOTAL <b>LOAN</b></p>
                                        <h2><span class="animate-number" data-value="<?php echo $total['total_loan']; ?>" data-duration="1500">0</span></h2>
                                        <div class="clearfix"></div>
                                    </a>
								</div>
							</div>
						</div>
					</div>
                    <?php } if ($cms->admin->totalborrowerd == '1') {?>
					<div class="col-lg-3 col-md-6">
						<div class="widget orange-3 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="fa fa-users"></i>
								</div>
								<div class="text-box">
                                    <a href="<?php echo url_for('/dashboard-total-borrowers/'); ?>">
                                        <p class="maindata">TOTAL <b>BORROWERS</b></p>
                                        <h2><span class="animate-number" data-value="<?php echo $total['borrowers']; ?>" data-duration="2000">0</span></h2>
                                        <div class="clearfix"></div>
                                    </a>
								</div>
							</div>
						</div>
					</div>
                    <?php } if ($cms->admin->activeborrower == '1') {?>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget green-3 animated fadeInDown">
                            <div class="widget-content padding">
                                <div class="widget-icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="text-box">
                                    <a href="<?php echo url_for('/dashboard-active-borrowers/'); ?>">
                                        <p class="maindata">ACTIVE <b>BORROWERS</b></p>
                                        <h2><span class="animate-number" data-value="<?php echo $total['total_active_borrowers']; ?>" data-duration="3000">0</span></h2>
                                        <div class="clearfix"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } if ($cms->admin->totalrecoveredd == '1') {?>
					<div class="col-lg-3 col-md-6">
						<div class="widget green-3 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="fa fa-dollar"></i>
								</div>
								<div class="text-box">
                                    <a href="<?php echo url_for('/dashboard-recovered/'); ?>">
                                        <p class="maindata">TOTAL <b>RECOVERED</b></p>
                                        <h2>RM <span class="animate-number" data-value="<?php echo $total['total_recovered']; ?>" data-duration="2500">0</span></h2>
                                        <div class="clearfix"></div>
                                    </a>
								</div>
							</div>
						</div>
					</div>
                    <?php } ?>
				</div>
				<div class="row top-summary">
                    <?php if ($cms->admin->totalcollectiond == '1') {?>
					<div class="col-lg-3 col-md-6">
						<div class="widget green-1 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon2">
									<i class="icon-download"></i>
								</div>
								<div class="text-box">
                                    <a href="<?php echo url_for('/dashboard-collection/'); ?>">
                                        <p class="maindata">TOTAL <b>COLLECTION</b> (until <?php echo date('F Y'); ?>)</p>
                                        <div class="number-position">
                                            <h2><span class="animate-number" data-value="<?php echo $total['total_installment_paid_this_month_percent']; ?>" data-duration="3000">0</span>%</h2>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
								</div>
							</div>
							<div class="widget-footer">
								<div class="row">
									<!--div class="col-sm-12">
										<?php echo $total['count_installment_paid_this_month']; ?> / <?php echo $total['count_installment_this_month']; ?> Recovery Record
										(<?php echo $cms->price($total['total_installment_paid_this_month']); ?> / <?php echo $cms->price($total['total_installment_this_month']); ?>)
									</div-->
									<div class="col-sm-12">
										<?php echo $cms->price($total['total_installment_paid_this_month']); ?> / <?php echo $cms->price($total['total_installment_this_month']); ?>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
                    <?php } if ($cms->admin->totalbaddebtd == '1') {?>
					<div class="col-lg-3 col-md-6">
						<div class="widget pink-2 animated fadeInDown">
							<div class="widget-content padding">
                                <div class="widget-icon2">
									<i class="fa fa-thumbs-o-down"></i>
								</div>
								<div class="text-box">
                                    <a href="<?php echo url_for('/dashboard-bad-debt/'); ?>">
                                        <p class="maindata">TOTAL <b>BAD DEBT</b> (until <?php echo date('F Y'); ?>)</p>
                                        <div class="number-position">
                                            <?php if ($cms->admin->role_type == '2') {?>
                                                <h2><span class="animate-number" data-value="<?php echo $total['total_bad_debt_rehead']; ?>" data-duration="3000">0</span>%</h2>
                                            <?php } else if($cms->admin->role_type == '3') { ?>
                                                <h2><span class="animate-number" data-value="<?php echo $total['total_bad_debt_reoffice']; ?>" data-duration="3000">0</span>%</h2>
                                            <?php } else { ?>
                                                <h2><span class="animate-number" data-value="<?php echo $total['total_bad_debt']; ?>" data-duration="3000">0</span>%</h2>
                                            <?php } ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
								</div>
							</div>
							<div class="widget-footer">
								<div class="row">
									<div class="col-sm-12">
                                        <?php if ($cms->admin->role_type == '2') {?>
                                            <?php echo $cms->price($total['total_bad_debt_amount_rehead']); ?> / <?php echo $cms->price($total['total_installment_until_this_month_rehead']); ?>
                                        <?php } else if($cms->admin->role_type == '3') { ?>
                                            <?php echo $cms->price($total['total_bad_debt_amount_reoffice']); ?> / <?php echo $cms->price($total['total_installment_until_this_month_reoffice']); ?>
                                        <?php } else { ?>
                                            <?php echo $cms->price($total['total_bad_debt_amount']); ?> / <?php echo $cms->price($total['total_installment_until_this_month']); ?>
                                        <?php } ?>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
                    <?php } if ($cms->admin->yearsofcollection == '1') {?>
					<div class="col-lg-3 col-md-6">
						<div class="widget darkblue-1 animated fadeInDown">
							<div class="widget-content padding">
                                <div class="widget-icon2">
									<i class="fa fa-dollar"></i>
								</div>
								<div class="text-box">
                                    <a href="<?php echo url_for('/dashboard-year-collection/'); ?>">
                                        <p class="maindata">YEAR OF <?php echo date('Y'); ?> <b>COLLECTION</b></p>
                                        <div class="number-position">
                                            <h2>RM <span class="animate-number" data-value="<?php echo $total['year_of_collection']; ?>" data-duration="3000">0</span></h2>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
								</div>
							</div>
							<div class="widget-footer">
								<div class="row">
									<div class="col-sm-12">
										<?php echo $total['year_of_collection_count']; ?> Recovery Records Collected
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
                    <?php } ?>
				</div>
                <?php if ($cms->admin->borrowerstatistic == '1') {?>
                <div class="row">
                    <div class="col-md-12 portlets">
                        <div class="widget">
                            <div class="widget-header transparent">
                                <h2><strong>Borrowers</strong> Statistic</h2>
                            </div>
                            <div class="widget-content padding">
                                <div id="borrower-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                    <script>
                        $(function(){
                            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                            Morris.Line({
                                element: 'borrower-chart',
                                resize: true,
                                data: <?php echo json_encode($chart_data); ?>,
                                xkey: 'month',
                                ykeys: ['new','total'],
                                labels: ['New','Total'],
                                xLabelFormat: function(date){
                                    var d = new Date(date);
                                    var month = months[d.getMonth()];
                                    return month;
                                },
                                hoverCallback: function (index, options, content, row) {
                                    return formatHoverLabel(row, options.preUnits);
                                }
                            });

                            function formatHoverLabel(row, preUnit){
                                var m_long_names = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                var d = new Date(row.month);
                                var curr_month = d.getMonth();
                                var curr_year = row.year;

                                var salesText = '<b>' + m_long_names[curr_month] + ' ' + curr_year + '</b><br>Total: ' + row.total + '<br>New: ' + row.new;
                                return salesText;
                            }
                        });
                    </script>
                <?php } ?>
				<!-- End of info box -->
				<!-- Start of overview box -->
				
                <div class="col-sm-12" style="padding-left: 0; padding-right: 0"S>
					<!--div class="col-sm-6" style="padding-left:0; margin">
						<div class="widget" style="margin-bottom:20px.">
							<div class="widget-header transparent">
								<h2><strong>Visitors/Sign Ups</strong></h2>
							</div>
							<table class="table table-hover">
								<tr>
									<td><b>Total Pending Collection:</b></td>
									<td class="r"><span style="font-weight:bold;" class="animate-number" data-value="<?php echo $total['recovery_count']; ?>" data-duration="3000">0</span></td>
								</tr>
								<tr>
									<td>Total Pending Collection Amount:</td>
									<td class="r"><span class="animate-number" data-value="<?php echo $total['recovery_sum']; ?>" data-duration="3000">0</span></td>
								</tr>
								<tr>
									<td>Total Lender Sign Up:</td>
									<td class="r"><span class="animate-number" data-value="<?php echo $total['signuplender']; ?>" data-duration="3000">0</span></td>
								</tr>
							</table>
						</div-->
						<!--div class="widget" style="margin-top:57px">
							<div class="widget-header transparent">
								<h2><strong>Applications</strong></h2>
							</div>
							<table class="table table-hover">
								<tr>
									<td>Total Application Submissions:</td>
									<td class="r"><span class="animate-number" data-value="<?php echo $total['application']; ?>" data-duration="3000">0</span></td>
								</tr>
								<tr>
									<td>Total Applications this Week:</td>
									<td class="r"><span class="animate-number" data-value="<?php echo $total['applicationweek']; ?>" data-duration="3000">0</span></td>
								</tr>
							</table>
						</div>
					</div-->
					
					<!--div class="col-sm-6" style="padding-right: 0">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong>Recovery Payment</strong></h2>
							</div>
							<table class="table table-hover">
								<tr>
									<td><b>Total recoveries collected:</b></td>
									<td class="r"><span style="font-weight:bold;" class="animate-number" data-value="<?php echo $total['count_recovery']; ?>" data-duration="300">0</span></td>
								</tr>
								<tr>
									<td>Total Pending Confirmation:</td>
									<td class="r"><span class="animate-number" data-value="<?php echo $total['count_unclaimed']; ?>" data-duration="300">0</span></td>
								</tr>
								<tr>
									<td>Total Pending Confirmation Amount:</td>
									<td class="r"><span class="animate-number" data-value="<?php echo $total['sum_unclaimed']; ?>" data-duration="300">0</span></td>
								</tr>
								<tr>
									<td>Recovered Amount:</td>
									<td class="r"><span class="animate-number" data-value="<?php echo $total['total_recovered']; ?>" data-duration="300">0</span></td>
								</tr>
							</table>
						</div>
						
						<!--div class="widget">
							<div class="widget-header transparent">
								<h2><strong>Pledges</strong></h2>
							</div>
							<table class="table table-hover">
								 <tr>
									<td>Total Pledges:</td>
									<td class="r">RM <span class="animate-number" data-value="<?php echo $total['pledge']; ?>" data-duration="3000">0</span></td>
								</tr>
								<tr>
									<td>Total Pledges this Week:</td>
									<td class="r">RM <span class="animate-number" data-value="<?php echo $total['pledgeweek']; ?>" data-duration="3000">0</span></td>
								</tr>
							</table>
						</div-->
					</div-->
				</div>
				<!-- End of overview box -->
				<!--
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div id="weather-widget" class="widget">
							<div class="widget-header transparent">
								<h2><strong>Mortgage</strong> Calculator</h2>
							</div>
							<div class="col-md-12">
								<center>
									<title>Loan Calculator </title>
									<table>
										<tr>
											<th>Enter Loan Data:</th>
										</tr>
										<tr>
											<td>Amount of the loan ($):</td>
											<td><input id="amount" size="12"/></td>
										</tr>
										<tr>
											<td>Annual interest (%):</td>
											<td><input id="apr" size="12" /></td>
										</tr>
										<tr>
											<td>Repayment period (years):</td>
											<td><input id="years" size="12" /></td>
										</tr>
										<tr>
											<th>Approximate Payments:</th>
											<td><button onclick="pmtcalculate();">Calculate</button></td>
										</tr>
										<tr>
											<td>Monthly payment:</td>
											<td>$<span class="output" id="payment"></span></td>
										</tr>
										<tr>
											<td>Total payment:</td>
											<td>$<span class="output" id="total"></span></td>
										</tr>
										<tr>
											<td>Total interest:</td>
											<td>$<span class="output" id="totalinterest"></span></td>
										</tr>
									</table>
								</center>
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6">
						<div id="calendar-widget2" class="widget blue-1">
							<div class="widget-header transparent">
								<h2><strong>Calendar</strong> Widget</h2>
								<div class="additional-btn">
									<a href="index.html#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
								</div>
							</div>
							<div id="calendar-box2" class="widget-content col-sm-12">
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div id="calc" class="widget darkblue-2">
							<div class="widget-header">
							<h2><strong>Calculator</strong></h2>
							<div class="additional-btn">
								<a href="index.html#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
							</div>
							</div>
							<div id="calculator" class="widget-content">
								<div class="calc-top col-xs-12">
									<div class="row">
										<div class="col-xs-3"><span class="calc-clean">C</span></div>
										<div class="col-xs-9"><div class="calc-screen"></div></div>
									</div>
								</div>
								
								<div class="calc-keys col-xs-12">
									<div class="row">
										<div class="col-xs-3"><span>7</span></div>
										<div class="col-xs-3"><span>8</span></div>
										<div class="col-xs-3"><span>9</span></div>
										<div class="col-xs-3"><span class="calc-operator">+</span></div>
									</div>
									<div class="row">
										<div class="col-xs-3"><span>4</span></div>
										<div class="col-xs-3"><span>5</span></div>
										<div class="col-xs-3"><span>6</span></div>
										<div class="col-xs-3"><span class="calc-operator">-</span></div>
									</div>
									<div class="row">
										<div class="col-xs-3"><span>1</span></div>
										<div class="col-xs-3"><span>2</span></div>
										<div class="col-xs-3"><span>3</span></div>
										<div class="col-xs-3"><span class="calc-operator">÷</span></div>
									</div>
									<div class="row">
										<div class="col-xs-3"><span>0</span></div>
										<div class="col-xs-3"><span>.</span></div>
										<div class="col-xs-3"><span class="calc-eval">=</span></div>
										<div class="col-xs-3"><span class="calc-operator">x</span></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
				-->
				<?php echo partial('copy.php'); ?>
			</div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->
