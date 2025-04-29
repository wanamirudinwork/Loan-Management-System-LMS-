
	<section>
    	<div class="container">
            <div class="row">
                <div class="col-md-12 c">
                    <h2>Account Activation</h2>
                    <?php
                        if(!empty($member)){
                    ?>
                    <h3>Congratulation!</h3>
                    <h4>You have successfully registered an account with Party With Us!</h4>
                    <?php
                        }else{
                    ?>
                    <h2>Error!</h2>
                    <h3>Invalid token!</h3>
                    <?php
                        }
                    ?>
                    <br>
                    <p>
                        <a href="<?php echo url_for('/'); ?>" class="btn btn-mearisse"><i class="fa fa-home"></i> Return To Home</a>
                    </p>
                </div>
            </div>
        </div>
	</section>