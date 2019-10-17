<?php
class WPStlCommoncls extends WPStlStripeManagement {

	public $emailvalidation_url = 'wssm_email_validation'; 



	public function __construct(){
		parent::__construct();
		//add_action('init', array( $this,'stl_common_initfn'));
		//add_action( 'template_redirect',array( $this,'stl_common_templredirect'));
		add_action('wp_ajax_SaveAccountInfo', array( $this,'SaveAccountInfo'));
		add_action( 'wp_ajax_nopriv_SaveAccountInfo', array( $this,'SaveAccountInfo') );
		add_action('wp_ajax_SaveAccountCupon', array( $this,'SaveAccountCupon'));
		add_action( 'wp_ajax_nopriv_SaveAccountCupon', array( $this,'SaveAccountCupon') );
		add_action('wp_ajax_getCardDetails', array( $this,'getCardDetails'));
		add_action( 'wp_ajax_nopriv_getCardDetails', array( $this,'getCardDetails') );
		add_action('wp_ajax_SaveCardInfo', array( $this,'SaveCardInfo'));
		add_action( 'wp_ajax_nopriv_SaveCardInfo', array( $this,'SaveCardInfo') );
		add_action('wp_ajax_AddCardInfo', array( $this,'AddCardInfo'));
		add_action( 'wp_ajax_nopriv_AddCardInfo', array( $this,'AddCardInfo') );
		add_action('wp_ajax_DeleteCardInfo', array( $this,'DeleteCardInfo'));
		add_action( 'wp_ajax_nopriv_DeleteCardInfo', array( $this,'DeleteCardInfo') );
		add_action('wp_ajax_CancelSubscription', array( $this,'CancelSubscription'));
		add_action( 'wp_ajax_nopriv_CancelSubscription', array( $this,'CancelSubscription') );
		add_action('wp_ajax_ReactiveSubscription', array( $this,'ReactiveSubscription'));
		add_action( 'wp_ajax_nopriv_ReactiveSubscription', array( $this,'ReactiveSubscription') );
		add_action('wp_ajax_addSubscriptionCoupon', array( $this,'addSubscriptionCoupon'));
		add_action( 'wp_ajax_nopriv_addSubscriptionCoupon', array( $this,'addSubscriptionCoupon') );
		add_action('wp_ajax_UpdateSubPaymenttype', array( $this,'UpdateSubPaymenttype'));
		add_action( 'wp_ajax_nopriv_UpdateSubPaymenttype', array( $this,'UpdateSubPaymenttype') );
		add_action('wp_ajax_PayInvoice', array( $this,'PayInvoice'));
		add_action( 'wp_ajax_nopriv_PayInvoice', array( $this,'PayInvoice') );
		add_action('wp_ajax_getMeterUsageDetails', array( $this,'getMeterUsageDetails'));
		add_action( 'wp_ajax_nopriv_getMeterUsageDetails', array( $this,'getMeterUsageDetails') );
		add_action('wp_ajax_getNextInvoiceDetails', array( $this,'getNextInvoiceDetails'));
		add_action( 'wp_ajax_nopriv_getNextInvoiceDetails', array( $this,'getNextInvoiceDetails') );
		add_action('wp_ajax_addNewsubscription', array( $this,'addNewsubscription'));
		add_action( 'wp_ajax_nopriv_addNewsubscription', array( $this,'addNewsubscription') );

		add_action('wp_ajax_registerAction', array( $this,'registerAction'));
		add_action( 'wp_ajax_nopriv_registerAction', array( $this,'registerAction') );

		add_action('wp_ajax_loginAction', array( $this,'loginAction'));
		add_action( 'wp_ajax_nopriv_loginAction', array( $this,'loginAction') );


	}

	/*public function stl_common_initfn(){
		add_rewrite_endpoint( $this->emailvalidation_url, EP_PAGES );
		flush_rewrite_rules();
	}

	public function stl_common_templredirect(){
		// echo "dddddddddddddddd";

		global $wp_query;
		$stltemplate = new WPStlTemplatecls();



	    if ( isset( $wp_query->query_vars['name'] ) ) {
	    	if( $wp_query->query_vars['name'] == $this->emailvalidation_url )
	    	{
	    		// echo "sssssssss";
	    		$stltemplate->checkEmailVerification();

	    	}
	    }


	}*/

	public function SaveAccountInfo(){
		$customerdata = parent::saveCustomerInfo($_POST);
		echo json_encode($customerdata);
		exit;
	}

	public function SaveAccountCupon(){
		$customerdata = parent::addCustomerCuponcode($_POST);
		echo json_encode($customerdata);
		exit;
	}

	
	public function getCardDetails(){
		$cardid = (isset($_POST['cardid']))?$_POST['cardid']:'';
		$customerid = (isset($_POST['customerid']))?$_POST['customerid']:'';
		$customerdata = parent::getCustomerCardDetails($customerid,$cardid);
		echo json_encode($customerdata);
		exit;
	}

	public function SaveCardInfo(){
		$customerdata = parent::updateCardInfo($_POST);
		echo json_encode($customerdata);
		exit;
	}
	public function AddCardInfo(){
		$customerdata = parent::addnewCardInfo($_POST);
		echo json_encode($customerdata);
		exit;
	}

	public function DeleteCardInfo(){
		$customerdata = parent::deleteCardInfomation($_POST);
		echo json_encode($customerdata);
		exit;
	}

	
	public function CancelSubscription(){
		$subid = (isset($_POST['subid']))?$_POST['subid']:'';
		$subscriptiondata = parent::cancelCustomerSubscription($subid);
		echo json_encode($subscriptiondata);
		exit;
	}
	public function ReactiveSubscription(){
		$subid = (isset($_POST['subid']))?$_POST['subid']:'';
		$subscriptiondata = parent::reactiveCustomerSubscription($subid);
		echo json_encode($subscriptiondata);
		exit;
	}
	public function addSubscriptionCoupon(){
		$subid = (isset($_POST['subid']))?$_POST['subid']:'';
		$couponid = (isset($_POST['couponid']))?$_POST['couponid']:'';
		$customer_id = (isset($_POST['customer_id']))?$_POST['customer_id']:'';
		$subscriptiondata = parent::addCustomerSubscriptionCoupon($customer_id,$subid,$couponid);
		echo json_encode($subscriptiondata);
		exit;
	}
	
	public function UpdateSubPaymenttype(){
		$subid = (isset($_POST['subid']))?$_POST['subid']:'';
		$payment_type = (isset($_POST['payment_type']))?$_POST['payment_type']:'';
		$subscriptiondata = parent::updateSubscriptionPaymenttype($_POST);
		echo json_encode($subscriptiondata);
		exit;
	}

	public function PayInvoice(){
		$customerdata = parent::PaystripeInvoice($_POST);
		echo json_encode($customerdata);
		exit;
	}

	public function getNextInvoiceDetails(){
		$invoicedata = parent::getCustomerNextInvoiceDetails($_POST);
		echo json_encode($invoicedata);
		exit;
	}
	public function getMeterUsageDetails(){
		$invoicedata = parent::getCustomerMeterUsageDetails($_POST);
		echo json_encode($invoicedata);
		exit;
	}

	public function addNewsubscription(){
		$successdata = parent::saveNewSubscriptionDetails($_POST);
		echo json_encode($successdata);
		exit;
	}

	public function registerAction(){
		global $wpdb;
		$return_data = array('stl_status'=>false,'message' => __('Error in user registration. Please try again later.','wp_stripe_management'));
		$reg_pwdrequired = (isset($_POST['reg_pwdrequired']))?$_POST['reg_pwdrequired']:'';
		if($reg_pwdrequired == '1')
		{
			$password = $_POST['password'];
		}
		else
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    		$password = substr(str_shuffle($chars),0,8);
		}
 		$full_name = $_POST['full_name'];
		$password = $_POST['password'];
		$email =$_POST['email'];
		$status = wp_create_user( $full_name, $password ,$email );
		if( is_wp_error($status) ){
			$msg = '';
 			foreach( $status->errors as $key=>$val ){
 				foreach( $val as $k=>$v ){
 					$msg = '<p class="error">'.$v.'</p>';
 				}
 			}
			$return_data = array('stl_status'=>false,'message' => $msg);
 		}
 		else
 		{
   			// $register_user =$status;
    		// $password_encrypted = password_hash($_POST['password'], PASSWORD_DEFAULT);
  				// // $password_encrypted  = md5($_POST['password']);
    		// 	$insert =  $wpdb->insert('wp_swpm_members_tbl', array(
      //                       'user_name' => $_POST['first_name'],
      //                       'first_name' => $_POST['first_name'],
      //                       'last_name' => $_POST['last_name'],
      //                       'password'=> $password_encrypted,
      //                       'member_since' =>date('Y-m-d'),
      //                       'membership_level'=>2,
      //                       'account_state' =>'active',
      //                       'email' =>$_POST['email'],
      //                       'subscription_starts'=>date('Y-m-d') ));
    		// 	if(!empty($register_user))  {
      //   			wp_set_current_user( $register_user, $uname );
      //   			wp_set_auth_cookie( $register_user );
      //   			do_action( 'wp_login', $uname );
      // 				// wp_redirect(site_url().'/upgrade');
      //    			echo "<script type='text/javascript'>window.location='". home_url() ."/upgrade/#choose_plan'</script>"; 
    		// 	}
  				$return_data = array('stl_status'=>true,'message' => __('Account register successfully.Please check your mail.','wp_stripe_management'));
 			}
 		echo json_encode($return_data);
    	exit;
	}

	public function loginAction(){
		$return_data = array('stl_status'=>false,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));
		$login_data = array();  
		$login_pwdrequired = (isset($_POST['login_pwdrequired']))?$_POST['login_pwdrequired']:'';
    	
    	if($login_pwdrequired == '1')
    	{
    		$login_data['user_login'] = $_POST['email'];  
    		$login_data['user_password'] = $_POST['password'];
	     	$user_verify = wp_signon( $login_data, true );   
	    	if ( !is_wp_error($user_verify) )   
	    	{  
	    		$return_data = array('stl_status'=>true,'message' => __('Logged in successfully','wp_stripe_management')); 
	    	}
	    	else
	    	{
	    		$return_data = array('stl_status'=>false,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));
	    	} 
    	}
    	else
    	{

    		$username = $_POST['email'];  
    		$user_verify = get_user_by('email', $username );
    		// echo "<pre>";print_r($user_verify);echo "</pre>";
  			if ( !is_wp_error( $user_verify ) && !empty($user_verify) )
		    {
		        wp_clear_auth_cookie();
		        wp_set_current_user ( $user_verify->ID );
		        wp_set_auth_cookie  ( $user_verify->ID );

		        $return_data = array('stl_status'=>true,'message' => __('Logged in successfully','wp_stripe_management'));
		    } else {
		    	$return_data = array('stl_status'=>false,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));
		    }
	    	 
    	}
    	
    	echo json_encode($return_data);
    	exit;
	}


}