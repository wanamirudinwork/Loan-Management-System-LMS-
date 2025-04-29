		<!-- Start right content -->
		<script>
		function addHyphen () {
			var phone = $(".phone").val();
			alert(phone);
			
		}
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
					$url = explode("/", $_GET['uri']);
					$borrower_id = $url[3];
				?>
								
				<!-- Your awesome content goes here -->
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Insert</strong> Contact</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							
                            <div class="form-group">								
								<label class="col-sm-2 control-label">Address</label>
								<div class="col-sm-5">
									<textarea class="form-control" style="text-transform: uppercase;height:100px;" name="address" required ></textarea>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label phone">Phone</label>
                                <div class="col-sm-3">
                                    <input type="text" maxlength="12" class="form-control mobile-number" name="mobile_number" value="" placeholder="012-12345678"  pattern="^\d{3}-\d{6,8}$" title="Invalid phone number." >
                                </div>
                            </div>
							<hr>
							<!-- <input type="hidden" name="borrower_id" value="<?php echo $borrower_id; ?>"> -->
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Add">
									<a href="<?php echo url_for('/borrowers/'.$borrower_id); ?>/#contacts"><input type="button" class="btn btn-default" value="Back"> </a>
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
