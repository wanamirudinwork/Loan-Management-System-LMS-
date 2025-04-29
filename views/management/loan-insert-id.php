
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
				<?php 
					$url = (explode("/",$_SERVER['REQUEST_URI']));
					$borrower_id = $url[3];

				?>
				<!-- Your awesome content goes here -->
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Insert  </strong>New Loan Details </h2>
					</div>
					<?php //var_dump($_SESSION); ?>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							<!-- displaying lender name  -->
                            <div class="form-group">
								<label class="col-sm-2 control-label " for="borrowerID">Borrower Name</label>
								<div class="col-sm-10">
									<!--select id="borrowerID" class="form-control " name="borrowerID" onchange="showUser(this.value)"-->
									<select id="borrowerID" class="form-control " name="borrowerID" style="text-transform:uppercase;">
									<?php 
									  
									  if($borrowerNameList){
									  foreach($borrowerNameList as $borrower){ ?>
									  
									  	<option value="<?php echo $borrower['borrower_id']; ?>"><?php echo $borrower['full_name'];?></option>
									  <?php } 
										}	?>


									  
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Recommended by</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="recommended_by">
								</div>
								<label class="col-sm-2 control-label">Commissions</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="commission" placeholder="0.00">
								</div>
							</div>
							
							
							<!--div id="ajaxSpace"></div-->
							
							 
                            <hr>
							<h4>Loan Structure</h4>
								<div class="form-group">
									<label class="col-sm-2 control-label">Amount Borrowed *</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="amount" required placeholder="0.00">
									</div>
									<label class="col-sm-2 control-label">Loan Date *</label>
									<div class="col-sm-2">
										<div class="input-group date">
											<input type="text" class="form-control" name="loan_date" style="z-index: 1;" required >
											<div class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</div>
										</div>
									</div>
									<label class="col-sm-2 control-label">Cash Given By Hand</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="cash">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Loan Repayment Terms *</label>
									<div class="col-sm-2">
										<select class="form-control selectpicker" name="loan_term" required>
											<option value="0">Interest only</option>
											<option value="12">12 months</option>
											<option value="24">24 months</option>
											<option value="36">36 months</option>
											<option value="48">48 months</option>
										</select>
									</div>
									<!--label class="col-sm-2 control-label">Interest per Annum *</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="loan_interest_year" required>
									</div-->
									<label class="col-sm-2 control-label">Interest per Month *</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="loan_interest_month" required>
									</div>
                                    <label class="col-sm-2 control-label">Stamp Duty Fees</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="stamp">
                                    </div>
								</div>
<!--								<div class="form-group">-->
<!--									<label class="col-sm-2 control-label">Principal Paid</label>-->
<!--									<div class="col-sm-2">-->
<!--										<input type="text" class="form-control" name="principal" placeholder="0.00">-->
<!--									</div>-->
<!--									<label class="col-sm-2 control-label">Principal Paid Date *</label>-->
<!--									<div class="col-sm-2">-->
<!--										<div class="input-group date">-->
<!--											<input type="text" class="form-control" name="principal_date" style="z-index: 1;" required>-->
<!--											<div class="input-group-addon">-->
<!--												<span class="glyphicon glyphicon-th"></span>-->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
                            
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Insert">
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
		<script>
			
function showUser(str) {
	
  if (str == "") {
  	document.getElementById("ajaxSpace").innerHTML = this.responseText;
  	
    return;
  } else {
    
  	 var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("ajaxSpace").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "../ajax/getApplicationDetails.php?id=" + str, true);
    xmlhttp.send();
	

  }
}




</script>
