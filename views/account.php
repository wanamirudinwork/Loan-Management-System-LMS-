
	<section>
    	<div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2>Update My Account</h2>
                    <form id="selfForm" class="form-horizontal">
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Salutation*</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="salutation" required>
                            <option value=""></option>
                            <option value="mr"<?php echo $user->info['salutation'] == 'mr' ? ' selected' : ''; ?>>Mr.</option>
                            <option value="dr"<?php echo $user->info['salutation'] == 'dr' ? ' selected' : ''; ?>>Dr.</option>
                            <option value="ms"<?php echo $user->info['salutation'] == 'ms' ? ' selected' : ''; ?>>Ms.</option>
                            <option value="mrs"<?php echo $user->info['salutation'] == 'mrs' ? ' selected' : ''; ?>>Mrs.</option>
                            <option value="mdm"<?php echo $user->info['salutation'] == 'mdm' ? ' selected' : ''; ?>>Mdm.</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">First Name*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="firstname" value="<?php echo $user->info['firstname']; ?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="lastname" value="<?php echo $user->info['lastname']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Contact Number*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="contact" value="<?php echo $user->info['contact']; ?>" required>
                        </div>
                      </div>
                      <?php if(empty($user->info['fb_uid'])){ ?>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Email*</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" value="<?php echo $user->info['email']; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Password*</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" name="password" placeholder="********">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Confirm Password*</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" name="password2" placeholder="********">
                        </div>
                      </div>
                      <?php } ?>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Address 1</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="address1" value="<?php echo $user->info['address1']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Address 2</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="address2" value="<?php echo $user->info['address2']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">City</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="city" value="<?php echo $user->info['city']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Postal Code</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="zip" value="<?php echo $user->info['zip']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Country</label>
                        <div class="col-sm-9">
                          <select class="form-control country" name="country">
                            <?php if($countries){ foreach($countries as $country){ ?>
                            <option value="<?php echo $country['id']; ?>"<?php echo $country['id'] == $user->info['country'] ? ' selected' : ''; ?>><?php echo $country['name']; ?></option>
                            <?php } } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">State</label>
                        <div class="col-sm-9">
                          <select class="form-control state" name="state">
                            <?php if($states){ foreach($states as $state){ ?>
                            <option value="<?php echo $state['id']; ?>"<?php echo $state['id'] == $user->info['state'] ? ' selected' : ''; ?>><?php echo $state['name']; ?></option>
                            <?php } } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 r">
                          <button type="submit" class="btn btn-mearisse">Update</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
	</section>