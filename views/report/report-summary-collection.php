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
				<?php //print_r($recovery); ?>
				<?php //print_r($cms->admin->id); ?>
				<!-- Your awesome content goes here -->
                <div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h2><strong>Summary Collection</strong>  Report</h2>
									<div class="additional-btn toolbar-action">
                                  
									<a href="#" class="btn btn-primary btn-xs btn-export"><i class="fa fa-plus-circle"></i> Export to CSV</a>
								</div>
									
								
                            </div>
                            

							<div class="widget-content">
<form class="form-inline" role="form">
                        <div class="form-group" style="padding: 10px 20px;">
                            <label class="control-label">Recovery Officer Name</label>
                            <select id="adminID" class="form-control " name="adminID">
                                <option value="">All </option>
                                <?php
                                if($selectofficername){
                                    foreach($selectofficername as $selection){ if($selection['admin_id'] == $cms->admin->id){
										?>{
											<option value="<?php echo $selection['admin_id']; ?>" <?php echo $selection['admin_id'] == $admin_id ? ' selected' : ''; ?>><?php echo $selection['admin_name'];?></option>
										<?php 
										}
										if($selection['head_id'] == $cms->admin->id){
											?>{
												<option value="<?php echo $selection['admin_id']; ?>" <?php echo $selection['admin_id'] == $admin_id ? ' selected' : ''; ?>><?php echo $selection['admin_name'];?></option>
											<?php 
											}
											if($cms->admin->role == '1' || $cms->admin->role == '2' || $cms->admin->role_type == '1'){
												?>{
													<option value="<?php echo $selection['admin_id']; ?>" <?php echo $selection['admin_id'] == $admin_id ? ' selected' : ''; ?>><?php echo $selection['admin_name'];?></option>
												<?php 
												}
										}
                                } ?>
                            </select>
                            <input type="button" class="btn btn-primary btn-filter-officer" value="Officer Filter">
                        </div>
                    </form>
								<br>		
								<div class="table-responsive">
									<form class='form-horizontal' role='form'>
									<table class="table table-striped table-bordered datatable" cellpadding="0" cellspacing="0">
									<thead>
									            <tr>
                                                	<th class="c pointer">No.</th>
                                                	<th class="c pointer">Collection Month</th>
													<th class="c pointer">Collection Year</th>
													<th class="c pointer">Collection Amount</th>
													<th class="c pointer">Recovery Officer</th>
                                                	
													
                                                	
                                                    <!-- <th width="200" class="c">Action</th> -->
                                                    
                                                    
									            </tr>
									 		</thead>
											 <tbody>
									        	<?php
												if($risk){

													$i=0;
													foreach($risk as $var){  
														
														if($cms->admin->role == '1' || $cms->admin->role == '2' || $cms->admin->role_type == '1'){
													
												?>
													
									            <tr>

                                                	<td class="c"><?php echo $i+1; ?></td>
                                                	
													
                                                	<td class="c">
													<?php if ($var['MONTH(a.paid_date)']=='1'){ echo("January)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='2'){ echo("February)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='3'){ echo("March)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='4'){ echo("April)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='5'){ echo("May)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='6'){ echo("June");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='7'){ echo("July");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='8'){ echo("August");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='9'){ echo("September");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='10'){ echo("October");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='11'){ echo("November");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='12'){ echo("December");} ?>
													</td>
													
												
													
													<td class="c"><?php echo ($var['YEAR(a.paid_date)']); ?></td>
													<td class="c"><?php echo ($var['TOTALCOUNT']); ?></td>
													<td class="c"><?php echo ($var['admin_name']); ?></td>
                                                	
                                                	


                                                	
                                                 
                                                    
  													
  													 
  													
									            </tr>
                                            <?php
                                          
                                            $i++;
														}

													else if($var['head_id'] == $cms->admin->id){
													
															?>
																
															<tr>
			
																<td class="c"><?php echo $i+1; ?></td>
																
																
																<td class="c">
													<?php if ($var['MONTH(a.paid_date)']=='1'){ echo("January)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='2'){ echo("February)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='3'){ echo("March)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='4'){ echo("April)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='5'){ echo("May)");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='6'){ echo("June");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='7'){ echo("July");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='8'){ echo("August");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='9'){ echo("September");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='10'){ echo("October");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='11'){ echo("November");} ?>
													<?php if ($var['MONTH(a.paid_date)']=='12'){ echo("December");} ?>
													</td>
															
																
																<td class="c"><?php echo ($var['YEAR(a.paid_date)']); ?></td>
																<td class="c"><?php echo ($var['TOTALCOUNT']); ?></td>
																<td class="c"><?php echo ($var['admin_name']); ?></td>
																
																
			
			
																
															 
																
																  
																   
																  
															</tr>
														<?php
													  
														$i++;
																	}

																	
													}
													
												}
											
										?>
											 </tbody>
									    </table>
									    
									</form>
								</div>
							</div>
						</div>
					<?php echo partial('copy.php'); ?>
                    <!-- End of your awesome content -->
				</div>
            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->
		<script>
			$(function(){
				
		$(document).on('click', '.btn-filter-officer', function(){
            adminID = $('[name="adminID"]').val();

            location.href = rootPath + 'report/summarycollection?adminID=' + adminID;
        });
		$(document).on('click', '.btn-export', function(){
            adminID = $('[name="adminID"]').val();

            location.href = rootPath + 'report/summarycollection?adminID=' + adminID + '&export=1';
        });
			});
				</script>