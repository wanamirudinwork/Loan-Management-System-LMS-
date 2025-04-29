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
            		<h1><i class='fa fa-list'></i> Remark</h1>
				</div>
            	<!-- Page Heading End-->	
				<?php
				
				$url = explode("/", $_GET['uri']);
				$borrower_id = $url[3];
				
				//print_r($borrower_id);
				
				
				?>
								
				<!-- Your awesome content goes here -->
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Insert</strong> Remark</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Remark</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="text-transform: uppercase;" name="remarks"></textarea>
								</div>
							</div>
							<hr>
								<!-- <input type="hidden" name="admin_id" value="<?php echo $cms->admin->id; ?>"> -->
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Add">
									<a href="<?php echo url_for('/borrowers/'.$borrower_id); ?>/#remarks"><input type="button" class="btn btn-default" value="Back"> </a>
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
