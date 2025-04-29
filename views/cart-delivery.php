
	<section class="cart">
    	<div class="container">
            <h2>My Shopping Cart (<?php echo $cms->cartTotal(); ?>)</h2>
            <ul class="cart-step">
                <li>Summary</li>
                <li>Address</li>
                <li class="active">Info</li>
                <li>Payment</li>
            </ul>
            
            <form id="cartDeliveryForm">            
            <div class="row">
            	<div class="col-md-12">
                	<div class="form-group">
                        <p>Email Address*</p>
                        <input type="text" class="form-control" name="email" value="<?php echo $shipping['email']; ?>" placeholder="Required for order update notification" required>
                    </div>
                </div>
                <?php if(!$user->logged){ ?>
                <div class="form-group">
                	<div class="col-md-12">
                		<div class="checkbox">
                			<label>
                				<input type="checkbox" name="register" value="1" onclick="$('.password-box').toggleClass('hidden');"> Create account for future use
                			</label>
                		</div>
                	</div>
                </div>
                <div class="password-box hidden">
                    <div class="col-md-6">
                        <div class="form-group">
                            <p>Password*</p>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p>Confirm Password*</p>
                            <input type="password" class="form-control" name="password2">
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-12">
                    <div class="form-group">
                        <p>Instructions / Additional Comments</p>
                        <textarea class="form-control" name="comments" placeholder="Optional"><?php echo $shipping['comments']; ?></textarea>
                    </div>
                </div>
            </div>
            
            <table class="cart-table">
                <tr>
                    <td class="r"><button class="btn btn-mearisse">Next</button></td>
                </tr>
            </table>
            </form>
        </div>
	</section>
    
    <script>
	$(function(){
		$('.datepicker').datetimepicker({
			format: 'YYYY-MM-DD',
			minDate: '<?php echo date('Y-m-d', strtotime('today + 1 days + 48 hours')); ?>',
        });
	});
	</script>
