		
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
                <!-- Start info box -->
				<div class="row top-summary">
					<div class="col-lg-3 col-md-6">
						<div class="widget darkblue-2 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="fa fa-users"></i>
								</div>
								<div class="text-box">
									<p class="maindata">TOTAL <b>BORROWERS</b></p>
									<h2><span class="animate-number" data-value="<?php echo $total['total_borrowers']; ?>" data-duration="3000">0</span></h2>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
						<div class="widget green-1 animated fadeInDown">
							<div class="widget-content padding">
								<div class="widget-icon">
									<i class="fa fa-users"></i>
								</div>
								<div class="text-box">
									<p class="maindata">ACTIVE <b>BORROWERS</b></p>
									<h2><span class="animate-number" data-value="<?php echo $total['total_active_borrowers']; ?>" data-duration="3000">0</span></h2>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End of info box -->

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
                
				<?php echo partial('copy.php'); ?>	
            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->

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