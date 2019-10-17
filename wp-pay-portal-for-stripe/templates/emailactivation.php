<div class="stl-row">
	<input type="hidden" class="stl_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>">
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
		
			<?php include_once(WPSTRIPESM_DIR.'templates/common_input.php'); ?>
			<?php //include_once(WPSTRIPESM_DIR.'templates/sidebar.php'); ?>

			<div class="stl-col-md-12">
				<p class="stl_htitle"><?= _e('Payment Methods','wp_stripe_management'); ?> &nbsp;&nbsp;<button type="button" class="stl-btn stl-btn-default stl-btn-sm btn_addcard"><?= _e('New','wp_stripe_management'); ?></button></p>
				<?php echo $message; ?>
				<p>
					A verification email has been sent to <?php echo $new_email; ?>.

Click on the email link provided to verify your email address. 

If you did not receive it, <a href="">click Here</a> to resend.
</p>
			</div>
		</div>
	</div>
