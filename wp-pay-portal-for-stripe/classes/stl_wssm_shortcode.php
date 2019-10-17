<?php
class WPStlShortcode {
	public function __construct(){
		// add_shortcode('WSSM_STRIPE_CONNECT', array( $this,'stl_stripe_connectbtn'));
		add_shortcode('WSSM_STRIPE_MANAGEMENT', array( $this,'stl_stripe_managementfn'));
		add_shortcode('WSSM_STRIPE_CARD', array( $this,'stl_stripe_cardfn'));
		add_shortcode('WSSM_STRIPE_INVOICE', array( $this,'stl_stripe_invoicefn'));
		add_shortcode('WSSM_STRIPE_SUBSCRIPTION', array( $this,'stl_stripe_subscriptionfn'));
		add_shortcode('WSSM_STRIPE_ADDSUBSCRIPTION', array( $this,'stl_stripe_addsubscriptionfn'));
		add_shortcode('WSSM_EMAIL_VERIFICATION', array( $this,'stl_stripe_emailverficationfn'));
		add_shortcode('WSSM_LOGIN_REGISTER', array( $this,'stl_stripe_loginregisterfn'));
	}
	function stl_stripe_managementfn(){
		if ( is_user_logged_in() ) {
			ob_start();
			$wpstltemplate =new WPStlTemplatecls();
			$wpstltemplate->getAcccountInfoTemplate();

			$output = ob_get_contents();
    		ob_end_clean(); 
    		return  $output;
		}
		else
		{
			// wp_redirect( wp_login_url() );
			echo "<script>window.location='". wp_login_url()."'</script>";exit;
		}
	}
	function stl_stripe_cardfn(){
		if ( is_user_logged_in() ) {
			ob_start();
			$wpstltemplate =new WPStlTemplatecls();
			$wpstltemplate->getCardTemplate();
			$output = ob_get_contents();
    		ob_end_clean(); 
    		return  $output;
		}
		else
		{
			// wp_redirect( wp_login_url() );
			echo "<script>window.location='". wp_login_url()."'</script>";exit;
		}
	}
	function stl_stripe_invoicefn(){
		if ( is_user_logged_in() ) {
			ob_start();
			$wpstltemplate =new WPStlTemplatecls();
			$wpstltemplate->getInvoiceTemplate();
			$output = ob_get_contents();
    		ob_end_clean(); 
    		return  $output;
		}
		else
		{
			// wp_redirect( wp_login_url() );
			echo "<script>window.location='". wp_login_url()."'</script>";exit;
		}
	}
	function stl_stripe_subscriptionfn(){
		if ( is_user_logged_in() ) {
			ob_start();
			$wpstltemplate =new WPStlTemplatecls();
			$wpstltemplate->getSubscriptionTemplate();
			$output = ob_get_contents();
    		ob_end_clean(); 
    		return  $output;
		}
		else
		{
			// wp_redirect( wp_login_url() );
			echo "<script>window.location='". wp_login_url()."'</script>";exit;
		}
	}
	function stl_stripe_addsubscriptionfn(){
		if ( is_user_logged_in() ) {
			ob_start();
			$wpstltemplate =new WPStlTemplatecls();
			$wpstltemplate->addSubscriptionTemplate();
			$output = ob_get_contents();
    		ob_end_clean(); 
    		return  $output;
		}
		else
		{
			// wp_redirect( wp_login_url() );
			echo "<script>window.location='". wp_login_url()."'</script>";exit;
		}
	}

	function stl_stripe_emailverficationfn(){
		ob_start();
		$wpstltemplate =new WPStlTemplatecls();
		$wpstltemplate->checkEmailVerification();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;
	}

	function stl_stripe_loginregisterfn(){
		ob_start();
		$wpstltemplate =new WPStlTemplatecls();
		$wpstltemplate->loginRegister();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;
	}

	
	
}