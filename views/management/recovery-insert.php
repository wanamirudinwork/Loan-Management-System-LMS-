		
        <script language="javascript">countryList = <?php echo json_encode($countryList); ?>;</script>
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
				<div class="widget">
					<div class="widget-header transparent">
						<h2><strong>Insert</strong> Promo Code</h2>
					</div>
					<div class="widget-content padding">
						<form id="backForm" class="form-horizontal" role="form">
                        	<div class="form-group">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="code" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="qty" value="1">
                                    <p class="help-block">-1 for unlimited.</p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Category</label>
                            	<div class="col-sm-10">
                                    <select class="form-control chosen-select" name="category_ids[]" multiple>
                                    	<option value="-1">All Categories</option>
									<?php
                                        if($categories){
                                            foreach($categories as $keys){
                                                ?>
                                        <option value="<?php echo $keys['id']; ?>"><?php echo $keys['title']; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                    </select>
                                    <p class="help-block"><i>* Once selected it will apply to all product under it's category. No need to choose product below.</i></p>
                            	</div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Products</label>
                            	<div class="col-sm-10">
                                    <select class="form-control chosen-select" name="products[]" multiple>
                                    <?php
										if($products){
											foreach($products as $product){
												?>
                                    	<option value="<?php echo $product['id']; ?>"><?php echo $product['title']; ?></option>
                                                <?php
											}
										}
									?>
                                    </select>
                            	</div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Discount Type</label>
                            	<div class="col-sm-10">
                                    <select class="form-control selectpicker" name="type">
                                    	<option value="percent">Percent</option>
                                		<option value="amount">Amount</option>
                                    </select>
                            	</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Discount Value</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="value">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Date Start</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control date" name="date_start" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Date End</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control date" name="date_end" required>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label">Status</label>
                            	<div class="col-sm-10">
                                    <select class="form-control selectpicker" name="status">
                                    	<option value="1" selected><?php echo mstatus('1'); ?></option>
                                    	<option value="0"><?php echo mstatus('0'); ?></option>
                                    </select>
                            	</div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-2 control-label"></label>
                            	<div class="col-sm-10">
                                 	<input type="submit" class="btn btn-primary" value="Insert New">
                                    <input type="button" class="btn btn-default back" value="Cancel">
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
