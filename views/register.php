
	<section>
    	<div class="container">
            <div class="row">
                 <div class="col-md-8 col-md-offset-2">
                	<h2>Register</h2>
                    <form id="registerForm" class="row">
                      <div class="form-group col-md-12">
                        <label for="inputEmail3">Salutation*</label>
                        <div>
                          <select class="form-control" name="salutation" required>
                            <option value=""></option>
                            <option value="mr">Mr.</option>
                            <option value="dr">Dr.</option>
                            <option value="ms">Ms.</option>
                            <option value="mrs">Mrs.</option>
                            <option value="mdm">Mdm.</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>First Name*</label>
                        <div>
                          <input type="text" class="form-control" name="firstname" required>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Last Name</label>
                        <div>
                          <input type="text" class="form-control" name="lastname">
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <label>Contact Number*</label>
                        <div>
                          <input type="text" class="form-control" name="contact" required>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <label>Email*</label>
                        <div>
                          <input type="email" class="form-control" name="email" required>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputPassword3">Password*</label>
                        <div>
                          <input type="password" class="form-control" name="password" required>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Confirm Password*</label>
                        <div>
                          <input type="password" class="form-control" name="password2" required>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <label>Address 1</label>
                        <div>
                          <input type="text" class="form-control" name="address1">
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <label>Address 2</label>
                        <div>
                          <input type="text" class="form-control" name="address2">
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>City</label>
                        <div>
                          <input type="text" class="form-control" name="city">
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Postal Code</label>
                        <div>
                          <input type="text" class="form-control" name="zip">
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputEmail3">Country</label>
                        <div>
                          <select class="form-control country" name="country">
                            <?php if($countries){ foreach($countries as $country){ ?>
                            <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                            <?php } } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputEmail3">State</label>
                        <div>
                          <select class="form-control state" name="state">
                            <?php if($states){ foreach($states as $state){ ?>
                            <option value="<?php echo $state['id']; ?>"<?php echo $state['id'] == '1983' ? ' selected' : ''; ?>><?php echo $state['name']; ?></option>
                            <?php } } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
						<i>* Mandatory Fields</i>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="terms" value="1" required> I understand and agree the <a href="<?php echo url_for('/terms-and-conditions'); ?>" target="_blank">Terms and Conditions</a> of Mearisse' Personal Data Protection Policy.
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 r">
                          <button type="submit" class="btn btn-mearisse">Register</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
	</section>