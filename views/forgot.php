
	<section>
    	<div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Forgot Password</h2>
                    <h3>Reset Password</h3>
                     <?php
                        if(empty($token)){
                     ?>
                     <form id="selfForm" class="form-horizontal">
                      <div class="form-group">
                        <label class="col-sm-1 control-label">Email*</label>
                        <div class="col-sm-11">
                          <input type="email" class="form-control" placeholder="Email" name="email" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 r">
                          <button type="submit" class="btn btn-mearisse">Reset</button>
                        </div>
                      </div>
                    <?php
                        }else{
                    ?>
                      <form id="directForm" class="form-horizontal">
                      <div class="form-group">
                        <label class="col-sm-2 control-label">New Password*</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" placeholder="********" name="password" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Confirm New Password*</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" placeholder="********" name="password2" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 r">
                          <button type="submit" class="btn btn-mearisse">Save</button>
                        </div>
                      </div>
                    <?php
                        }
                    ?>
                    </form>
                </div>
            </div>
        </div>
	</section>