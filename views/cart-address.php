
	<section class="cart">
    	<div class="container">
            <h2>My Shopping Cart (<?php echo $cms->cartTotal(); ?>)</h2>
            <ul class="cart-step">
                <li>Summary</li>
                <li class="active">Address</li>
                <li>Info</li>
                <li>Payment</li>
            </ul>
            
            <form id="cartAddressForm">
            <div class="row">
                <div class="col-md-6">
                    <table class="cart-table">
                        <tr>
                            <th class="l">Delivery Address</th>
                        </tr>
                    </table>
                    <div class="form-horizontal margintb">
                    	<?php /*
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-11">
                                <div class="radio"><label><input type="radio" name="delivery_method" value="1"<?php echo $address['DELIVERY_METHOD'] == '1' ? ' checked' : ''; ?>>Delivery</label></div>
                                <div class="radio"><label><input type="radio" name="delivery_method" value="0"<?php echo $address['DELIVERY_METHOD'] == '0' ? ' checked' : ''; ?>>Self-Collection</label></div>
                            </div>
                        </div>
						*/ ?>
                        <div class="delivery-field<?php echo $address['DELIVERY_METHOD'] == '0' ? ' hidden' : ''; ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <a href="#" class="copy delivery"><i class="fa fa-copy"></i> Same details as my saved profile</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Salutation</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="address[DELIVERY][salutation]" required>
                                    <option value=""></option>
                                    <option value="mr"<?php echo $address['DELIVERY']['salutation'] == 'mr' ? ' selected' : ''; ?>>Mr.</option>
                                    <option value="ms"<?php echo $address['DELIVERY']['salutation'] == 'ms' ? ' selected' : ''; ?>>Ms.</option>
                                    <option value="mrs"<?php echo $address['DELIVERY']['salutation'] == 'mrs' ? ' selected' : ''; ?>>Mrs.</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Firstname</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[DELIVERY][firstname]" value="<?php echo $address['DELIVERY']['firstname']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lastname</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[DELIVERY][lastname]" value="<?php echo $address['DELIVERY']['lastname']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Contact Number</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[DELIVERY][contact]" value="<?php echo $address['DELIVERY']['contact']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address 1</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[DELIVERY][address1]" value="<?php echo $address['DELIVERY']['address1']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address 2</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[DELIVERY][address2]" value="<?php echo $address['DELIVERY']['address2']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[DELIVERY][city]" value="<?php echo $address['DELIVERY']['city']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Postal Code</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[DELIVERY][zip]" value="<?php echo $address['DELIVERY']['zip']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Country</label>
                            <div class="col-sm-9">
                                <select class="form-control country" name="address[DELIVERY][country]" required>
                                    <?php if($countries){ foreach($countries as $country){ ?>
                                    <option value="<?php echo $country['id']; ?>"<?php echo $country['id'] == $address['DELIVERY']['country'] ? ' selected' : ''; ?>><?php echo $country['name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">State</label>
                            <div class="col-sm-9">
                                <select class="form-control state" name="address[DELIVERY][state]">
                                    <?php if($states['DELIVERY']){ foreach($states['DELIVERY'] as $state){ ?>
                                    <option value="<?php echo $state['id']; ?>"<?php echo $state['id'] == $address['DELIVERY']['state'] ? ' selected' : ''; ?>><?php echo $state['name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="cart-table">
                        <tr>
                            <th class="l">Billing Address</th>
                        </tr>
                    </table>
                    <div class="form-horizontal margintb">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <a href="#" class="copy billing"><i class="fa fa-copy"></i> Same details as my saved profile</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Salutation</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="address[BILLING][salutation]" required>
                                    <option value=""></option>
                                    <option value="mr"<?php echo $address['BILLING']['salutation'] == 'mr' ? ' selected' : ''; ?>>Mr.</option>
                                    <option value="ms"<?php echo $address['BILLING']['salutation'] == 'ms' ? ' selected' : ''; ?>>Ms.</option>
                                    <option value="mrs"<?php echo $address['BILLING']['salutation'] == 'mrs' ? ' selected' : ''; ?>>Mrs.</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Firstname</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[BILLING][firstname]" value="<?php echo $address['BILLING']['firstname']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lastname</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[BILLING][lastname]" value="<?php echo $address['BILLING']['lastname']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Contact Number</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[BILLING][contact]" value="<?php echo $address['BILLING']['contact']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address 1</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[BILLING][address1]" value="<?php echo $address['BILLING']['address1']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address 2</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[BILLING][address2]" value="<?php echo $address['BILLING']['address2']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[BILLING][city]" value="<?php echo $address['BILLING']['city']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Postal Code</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="address[BILLING][zip]" value="<?php echo $address['BILLING']['zip']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Country</label>
                            <div class="col-sm-9">
                                <select class="form-control country" name="address[BILLING][country]" required>
                                    <?php if($countries){ foreach($countries as $country){ ?>
                                    <option value="<?php echo $country['id']; ?>"<?php echo $country['id'] == $address['BILLING']['country'] ? ' selected' : ''; ?>><?php echo $country['name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">State</label>
                            <div class="col-sm-9">
                                <select class="form-control state" name="address[BILLING][state]">
                                    <?php if($states['BILLING']){ foreach($states['BILLING'] as $state){ ?>
                                    <option value="<?php echo $state['id']; ?>"<?php echo $state['id'] == $address['BILLING']['state'] ? ' selected' : ''; ?>><?php echo $state['name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="r">
                <button class="btn btn-mearisse">Next</button>
            </div>
            </form>
        </div>
	</section>
    
    <script>
		$(function(){
			myaddress = <?php echo $myaddress; ?>;
			
			$('#cartAddressForm .copy.delivery').live('click', function(e){
				e.preventDefault();
				$('#cartAddressForm select[name=\'address[DELIVERY][salutation]\']').val(myaddress.salutation).change();
				$('#cartAddressForm input[name=\'address[DELIVERY][firstname]\']').val(myaddress.firstname);
				$('#cartAddressForm input[name=\'address[DELIVERY][lastname]\']').val(myaddress.lastname);
				$('#cartAddressForm input[name=\'address[DELIVERY][contact]\']').val(myaddress.contact);
				$('#cartAddressForm input[name=\'address[DELIVERY][address1]\']').val(myaddress.address1);
				$('#cartAddressForm input[name=\'address[DELIVERY][address2]\']').val(myaddress.address2);
				$('#cartAddressForm input[name=\'address[DELIVERY][zip]\']').val(myaddress.zip);
				$('#cartAddressForm input[name=\'address[DELIVERY][city]\']').val(myaddress.city);
				$('#cartAddressForm select[name=\'address[DELIVERY][country]\']').val(myaddress.country).change();
				$('#cartAddressForm select[name=\'address[DELIVERY][state]\']').val(myaddress.state);
				interval = setInterval(function(){
					$('#cartAddressForm select[name=\'address[DELIVERY][state]\']').val(myaddress.state);
					if( $('#shippingForm select[name=\'address[DELIVERY][state]\']').val() == myaddress.state ) clearInterval(interval);
				}, 1000);
			});
			
			$('#cartAddressForm .copy.billing').live('click', function(e){
				e.preventDefault();
				$('#cartAddressForm select[name=\'address[BILLING][salutation]\']').val(myaddress.salutation).change();
				$('#cartAddressForm input[name=\'address[BILLING][firstname]\']').val(myaddress.firstname);
				$('#cartAddressForm input[name=\'address[BILLING][lastname]\']').val(myaddress.lastname);
				$('#cartAddressForm input[name=\'address[BILLING][contact]\']').val(myaddress.contact);
				$('#cartAddressForm input[name=\'address[BILLING][address1]\']').val(myaddress.address1);
				$('#cartAddressForm input[name=\'address[BILLING][address2]\']').val(myaddress.address2);
				$('#cartAddressForm input[name=\'address[BILLING][zip]\']').val(myaddress.zip);
				$('#cartAddressForm input[name=\'address[BILLING][city]\']').val(myaddress.city);
				$('#cartAddressForm select[name=\'address[BILLING][country]\']').val(myaddress.country).change();
				$('#cartAddressForm select[name=\'address[BILLING][state]\']').val(myaddress.state);
				interval = setInterval(function(){
					$('#cartAddressForm select[name=\'address[BILLING][state]\']').val(myaddress.state);
					if( $('#shippingForm select[name=\'address[BILLING][state]\']').val() == myaddress.state ) clearInterval(interval);
				}, 1000);
			});
		});
		<?php if($address['DELIVERY_METHOD'] == '0'){ ?>
		$(window).load(function(){
			$('[required]', '.delivery-field').prop('disabled', true);
		});
		<?php } ?>
	</script>