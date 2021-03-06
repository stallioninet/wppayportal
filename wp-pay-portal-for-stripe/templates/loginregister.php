<?php
global $wpdb;
if (!session_id())
    session_start();
$password_status = get_option('wssm_stripe_password_status','');
$page_addsub = get_option('wssm_stripe_page_addsubscription','');
$page_actinfo = get_option('wssm_stripe_page_acounttinfo','');
$page_card = get_option('wssm_stripe_page_card','');
$page_invoice = get_option('wssm_stripe_page_invoice','');
$page_sub = get_option('wssm_stripe_page_subscription','');
$page_additional_users = get_option('wssm_stripe_page_additionalusers','');

$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');
$actcode = (isset($_GET['wssm_activationcode']))?$_GET['wssm_activationcode']:'';
$mail_send = (isset($_GET['mail_send']))?$_GET['mail_send']:'';
$rpage = (isset($_GET['rpage']))?$_GET['rpage']:'';
// echo "<pre>";print_r($_SESSION);echo "</pre>";
$stl_transient_name = (isset($_SESSION['stl_transient_name']))?$_SESSION['stl_transient_name']:'';
// echo "stl_transient_name = ".$stl_transient_name;
if($actcode == '')
{
	$actcode = md5(rand());
	$insert_status = $wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('status_type' => 'reglogin','activation_code' => $actcode));
}

$num1=rand(1,9); //Generate First number between 1 and 9  
$num2=rand(1,9); //Generate Second number between 1 and 9  
$captcha_total=$num1+$num2;  

$math = "$num1"." + "."$num2"." =";  
$try_count = 0;
if ( get_transient( $stl_transient_name ) ) {
	$datas = get_transient( $stl_transient_name );
	// echo "<pre>";print_r($datas);echo "</pre>";
    			$try_count = $datas['tried'];
    		}

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
					<input type="hidden" name="actcode" class="actcode" value="<?= $actcode; ?>">
					<input type="hidden" name="action" value="loginAction">
					<input type="hidden" name="rpage" class="rpage" value="<?=$rpage; ?>">
					<input type="hidden" name="captcha_total" class="captcha_total" value="<?=$captcha_total;?>">
					<input type="hidden" name="try_count" class="try_count" value="<?=$try_count;?>">
					<input type="hidden" name="login_pwdrequired" class="login_pwdrequired" value="<?php echo $password_status; ?>">
					<?php
						
						if($rpage == 'accountinfo')
							$lredirect_url = $page_actinfo;
						else if($rpage == 'card')
							$lredirect_url = $page_card;
						else if($rpage == 'invoice')
							$lredirect_url = $page_invoice;
						else if($rpage == 'additional_users')
							$lredirect_url = $page_additional_users;
						else if($rpage == 'subscription')
							$lredirect_url = $page_sub;
						else
							$lredirect_url = $page_addsub;
					
						if($password_status == '1'){ 
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
					   	<div class="stl-col-md-6" style="display:<?php echo ($password_status == '')?'block':'none';?>">
					   		<div class="stl-form-group">
								<label><?= _e('Existing Password','wp_stripe_management'); ?></label>
								<input type="password" name="password" class="stl-form-control">
							</div>
					   	</div>
					   	<div class="stl-col-md-6 captcha_div" style="<?php echo ($try_count>0)?'display:block':'display:none'; ?>">
					
					   		<div class="stl-form-group">
								<label><?= _e(' What\'s','wp_stripe_management'); ?> <?=$math;?></label>
								<input type="number" name="captcha_input" class="stl-form-control">
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
					<input type="hidden" name="actcode" class="actcode" value="<?= $actcode; ?>">
					<input type="hidden" name="action" value="registerAction">
					<input type="hidden" name="rpage" class="rpage" value="<?=$rpage; ?>">
					<input type="hidden" name="captcha_total" class="captcha_total" value="<?=$captcha_total;?>">
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
						<div class="stl-col-md-6" style="clear: both;">
					   		<div class="stl-form-group">
								<label><?= _e('New Password (min 8 chars)','wp_stripe_management'); ?></label>
								<input type="password" name="password" class="stl-form-control" id="mainpassword" onKeyUp="checkPasswordStrength();">
								<div id="password-strength-status"></div>
							</div>
					   	</div>
					   	<div class="stl-col-md-6">
					   		<div class="stl-form-group">
								<label><?= _e('New Verify Password','wp_stripe_management'); ?></label>
								<input type="password" name="confirm_password" class="stl-form-control">

							</div>
					   	</div>
					   	<div class="stl-col-md-6 regcaptcha_div">
					
					   		<div class="stl-form-group">
								<label><?= _e(' What\'s','wp_stripe_management'); ?> <?=$math;?></label>
								<input type="number" name="captcha_input" class="stl-form-control">
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







