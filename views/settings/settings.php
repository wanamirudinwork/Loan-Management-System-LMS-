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
								
				<!-- Your awesome content goes here -->
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Website</strong> Settings</h2>
					</div>
					<div class="widget-content padding">
						<form id="selfForm" class="form-horizontal" role="form">
						<?php if ($cms->admin->role == '1'){ ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Logo</label>
								<div class="col-sm-10">
									<div class="multiImg">
                                        <img src="<?php echo img($settings['logo'], 200, 100, true);?>" style="display:table;margin: 5px auto;max-width:200px;max-height:100px;">
                                        <input id="photo" name="logo" value="<?php echo $settings['logo']; ?>" type="hidden">
                                        <a href="javascript:void(0)" onclick="kcFinderB('photo')">Browse</a> | 
                                        <a href="javascript:void(0)" onclick="kcFinderC('photo')">Cancel</a>
                                    </div>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Site Name</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="site_name"><?php echo $settings['site_name']; ?></textarea>	
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Meta Description</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="meta_description"><?php echo $settings['meta_description']; ?></textarea>	
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Meta Keywords</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="meta_keyword"><?php echo $settings['meta_keyword']; ?></textarea>	
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Google Analytics</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="google_analytics" rows="9" placeholder="Including the <script> tags."><?php echo stripslashes($settings['google_analytics']); ?></textarea>	
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Email Address</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email" value="<?php echo $settings['email']; ?>">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Facebook</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="facebook" value="<?php echo $settings['facebook']; ?>">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label">Instagram</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="instagram" value="<?php echo $settings['instagram']; ?>">
								</div>
							</div>
              <div class="form-group">
								<label class="col-sm-2 control-label">Whatsapp</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="whatsapp" value="<?php echo $settings['whatsapp']; ?>">
								</div>
							</div>

							 <div class="form-group">
								<label class="col-sm-2 control-label">frontend link</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="frontend-link" value="<?php echo $settings['frontend-link']; ?>">
								</div>
							</div>
						<?php } ?>
							<!-- For Interest -->
                            <div class="form-group">
								<label class="col-sm-2 control-label">Interest (%)</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="whatsapp" value="<?php echo $settings['interest']; ?>" placeholder="%">
								</div>
								<label class="col-sm-4 control-label">HomeCrowd Dividend (%)</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="whatsapp" value="<?php echo $settings['hc_dividend']; ?>" placeholder="%">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-default" value="Save">
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
