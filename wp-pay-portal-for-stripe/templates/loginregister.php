
<div class="stl-row">
	<?php include_once(WPSTRIPESM_DIR.'templates/common_input.php'); ?>
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
	
			<div class="stl-col-md-12">
				<label>
					<input type="radio" name="stl_lrgform" class="stl_select_login" value="login" checked> <?= _e('Login to Existing Account','wp_stripe_management'); ?> 
				</label>
				<form id="stl_loginform" name="loginform" method="post">
					<div class="stl-col-md-12">
						<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('Login Email Address','wp_stripe_management'); ?></label>
								<input type="text" name="email" class="stl-form-control">
							</div>
					   	</div>
					   	<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('Existing Password','wp_stripe_management'); ?></label>
								<input type="password" name="password" class="stl-form-control">
							</div>
					   	</div>
					   	<div class="stl-col-md-6">
					   		<input type="hidden" name="action" value="loginAction">
					   		<input type="hidden" class="login_pwdrequired" value="1">
							<input type="hidden" value="http://stallioni.in/595/wp-stripe-add-subscription/" name="redirect_to" class="login_redirect">
					   		<button type="submit" class="stl-btn stl-btn-success" id="wp-submit" value="Login" name="wp-submit"><?= _e('Login','wp_stripe_management'); ?></button>
					   	</div>

					</div>
				</form>
			</div>
			<div class="stl-col-md-12">
				<label>
					<input type="radio" name="stl_lrgform" class="stl_select_login" value="register"> <?= _e('Register New Account','wp_stripe_management'); ?> 
				</label>
				<form id="stl_regsform">
					<div class="stl-col-md-12">
						<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('Full Name','wp_stripe_management'); ?></label>
								<input type="text" name="full_name" class="stl-form-control">
							</div>
					   	</div>
					   	<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('Login Email Address','wp_stripe_management'); ?></label>
								<input type="text" name="email" class="stl-form-control">
							</div>
					   	</div>
						<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('New Password','wp_stripe_management'); ?></label>
								<input type="text" name="password" class="stl-form-control" id="mainpassword">
							</div>
					   	</div>
					   	<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('New Verify Password','wp_stripe_management'); ?></label>
								<input type="text" name="confirm_password" class="stl-form-control">
							</div>
					   	</div>
					   	<div class="stl-col-md-6">
					   		<input type="hidden" class="reg_pwdrequired" value="1">
					   		<input type="hidden" name="action" value="registerAction">
					   		<input type="hidden" value="http://stallioni.in/595/wp-stripe-add-subscription/" name="redirect_to" class="reg_redirect">
					   		<button type="submit" class="stl-btn stl-btn-success"><?= _e('Register','wp_stripe_management'); ?></button>
					   	</div>
					</div>
				</form>
			</div>
		</div>
	</div>







