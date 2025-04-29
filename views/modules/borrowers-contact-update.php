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
						<h2><strong>Update</strong> Contact</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
							
                            <div class="form-group">
                                <?php if(!empty($update_contact['contactAddress']) == '1'){ ?>
                                    <label class="col-sm-2 control-label" style="color:red">Address</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label">Address</label>
                                <?php } ?>
								<div class="col-sm-5">
									<textarea class="form-control" style="text-transform: uppercase;height:100px;" name="address" required><?php echo $contact["address"]; ?></textarea>
								</div>
							</div>
                            <div class="form-group">
                                <?php if(!empty($update_contact['contactMobile_number']) == '1'){ ?>
                                    <label class="col-sm-2 control-label phone" style="color:red">Phone</label>
                                <?php } else{ ?>
                                    <label class="col-sm-2 control-label phone">Phone</label>
                                <?php } ?>
                                <div class="col-sm-3">
                                    <input type="text" maxlength="12" class="form-control mobile-number" name="mobile_number"  placeholder="012-12345678" pattern="^\d{3}-\d{6,8}$" title="Invalid phone number." value="<?php echo $contact["mobile_number"]; ?>">
                                </div>
                            </div>
							<hr>
							<?php
								$disabled = "";
									if($cms->admin->role != 2){
										$disabled = "disabled";
									}

							?>
							<input type="hidden" name="borrower_id" value="<?php echo $borrower_id; ?>">
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-primary" value="Update" <?php //echo $disabled; ?>>
									<a href="<?php echo url_for('/borrowers/'.$borrower_id); ?>/#contacts"><input type="button" class="btn btn-default" value="Back">
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
