<?php
$password_status = get_option('wssm_stripe_password_status','');
$page_addsub = get_option('wssm_stripe_page_addsubscription','');
$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');
$suser_id = (isset($_GET['suser_id']))?$_GET['suser_id']:'';
$mail_send = (isset($_GET['mail_send']))?$_GET['mail_send']:'';


?>
<div class="stl-row">
	<?php include_once(WPSTRIPESM_DIR.'templates/common_input.php'); ?>
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>

			<div class="stl-col-md-12">
				<p><label>
					<input type="radio" name="stl_lrgform" class="stl_select_login" value="login" checked> <?= _e('Login to Existing Account','wp_stripe_management'); ?> 
				</label></p>
				<form id="stl_loginform" name="loginform" method="post">
					<input type="hidden" name="suser_id" class="suser_id" value="<?= $suser_id; ?>">
					<input type="hidden" name="action" value="loginAction">
					<input type="hidden" name="login_pwdrequired" class="login_pwdrequired" value="<?php echo $password_status; ?>">
					<?php 
						$lredirect_url = $page_addsub;
						if($password_status == ''){ 
							$lredirect_url = $wssm_mail_urlredirect;
						}
					?>
						<input type="hidden" value="<?php echo site_url().'/'.$lredirect_url; ?>" name="redirect_to" class="login_redirect">



					<div class="stl-col-md-12">
						<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('Login Email Address','wp_stripe_management'); ?></label>
								<input type="text" name="email" class="stl-form-control">
							</div>
					   	</div>
					   	<div class="stl-col-md-6" style="display:<?php echo ($password_status == '1')?'block':'none';?>">
					   		<div class="stl-form-group">
								<label><?= _e('Existing Password','wp_stripe_management'); ?></label>
								<input type="password" name="password" class="stl-form-control">
							</div>
					   	</div>
					   	<div class="stl-col-md-6" style="clear: both;">
					   		
					   		<button type="submit" class="stl-btn stl-btn-success" id="wp-submit" value="Login" name="wp-submit"><?= _e('Login','wp_stripe_management'); ?></button>
					   	</div>

					</div>
				</form>
			</div>
			<div class="stl-col-md-12">
				<br><p><label>
					<input type="radio" name="stl_lrgform" class="stl_select_login" value="register"> <?= _e('Register New Account','wp_stripe_management'); ?> 
				</label></p>
				<form id="stl_regsform">
					<input type="hidden" name="suser_id" class="suser_id" value="<?= $suser_id; ?>">
					<input type="hidden" name="action" value="registerAction">
					<input type="hidden" value="<?php echo site_url()."/".$wssm_mail_urlredirect."/"; ?>" name="redirect_to" class="reg_redirect">
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
								<input type="text" name="email" id="email_address" class="stl-form-control">
							</div>
					   	</div>
						<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('New Password','wp_stripe_management'); ?></label>
								<input type="password" name="password" class="stl-form-control" id="mainpassword">
							</div>
					   	</div>
					   	<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('New Verify Password','wp_stripe_management'); ?></label>
								<input type="password" name="confirm_password" class="stl-form-control">
							</div>
					   	</div>
					   	<div class="stl-col-md-6" style="clear: both;">
					   		
					   		<button type="submit" class="stl-btn stl-btn-success"><?= _e('Register','wp_stripe_management'); ?></button>
					   	</div>
					</div>
				</form>
			</div>


		</div>
	</div>







