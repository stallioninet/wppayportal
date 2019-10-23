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
		add_action('wp_ajax_savePlanBeforeReglogin', array( $this,'savePlanBeforeReglogin'));
		add_action( 'wp_ajax_nopriv_savePlanBeforeReglogin', array( $this,'savePlanBeforeReglogin') );

		add_action('wp_ajax_changeEmailid', array( $this,'changeEmailid'));
		add_action( 'wp_ajax_nopriv_changeEmailid', array( $this,'changeEmailid') );

		add_action('wp_ajax_registerAction', array( $this,'registerAction'));
		add_action( 'wp_ajax_nopriv_registerAction', array( $this,'registerAction') );

		add_action('wp_ajax_loginAction', array( $this,'loginAction'));
		add_action( 'wp_ajax_nopriv_loginAction', array( $this,'loginAction') );

		add_action('wp_ajax_resendEmailVerification', array( $this,'resendEmailVerification'));
		add_action( 'wp_ajax_nopriv_resendEmailVerification', array( $this,'resendEmailVerification') );

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

	public function savePlanBeforeReglogin(){
		global $wpdb;
		// echo "<pre>";print_r($_POST);echo "</pre>";
		$product_plans = (isset($_POST['product_plans']))?$_POST['product_plans']:'';
		$product_plans=serialize($product_plans);
		$wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('plan_details' => $product_plans, 'status_type' => 'reglogin') );
		$lastid = $wpdb->insert_id;
		echo json_encode(array('suser_id' => $lastid,'stl_status' => true));
		exit;
	}

	public function changeEmailid(){
		global $wpdb;
		$user = wp_get_current_user();
    	$uid  = (int) $user->ID;


		// echo "<pre>";print_r($_POST);echo "</pre>";
		$product_plans = (isset($_POST['product_plans']))?$_POST['product_plans']:'';
		$company_name = (isset($_POST['company_name']))?$_POST['company_name']:'';
		$emailid = (isset($_POST['emailid']))?$_POST['emailid']:'';
		$oldemailid = (isset($_POST['oldemailid']))?$_POST['oldemailid']:'';
		$address_line1 = (isset($_POST['address_line1']))?$_POST['address_line1']:'';
		$city = (isset($_POST['city']))?$_POST['city']:'';
		$state = (isset($_POST['state']))?$_POST['state']:'';
		$postal_code = (isset($_POST['postal_code']))?$_POST['postal_code']:'';
		$country = (isset($_POST['country']))?$_POST['country']:'';
		$phone = (isset($_POST['phone']))?$_POST['phone']:'';
		$address_line2 = (isset($_POST['address_line2']))?$_POST['address_line2']:'';

		update_user_meta( $uid, 'wssm_company_name', $company_name);
		update_user_meta( $uid, 'wssm_address_line1', $address_line1);
		update_user_meta( $uid, 'wssm_address_line2', $address_line2);
		update_user_meta( $uid, 'wssm_city', $city);
		update_user_meta( $uid, 'wssm_state', $state);
		update_user_meta( $uid, 'wssm_postal_code', $postal_code);
		update_user_meta( $uid, 'wssm_country', $country);
		update_user_meta( $uid, 'wssm_phone', $phone);

		

		$product_plans=serialize($product_plans);
		$wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('plan_details' => $product_plans, 'user_oldemail' => $oldemailid,'user_newemail' => $emailid,'status_type' => 'changeemail') );
		$lastid = $wpdb->insert_id;
		$wpstlemail =new WPStlEmailManagement();
	            $stl_status =  $wpstlemail->changeUserEmailid($oldemailid,$emailid,$lastid);
	            if($stl_status)
	            {
	            	 $message = __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management');
	            } else {
			    	$message = __('Error in mail sending. Please try again!','wp_stripe_management');
			    }

		echo json_encode(array('suser_id' => $lastid,'stl_status' => true,'message' => $message));
		exit;
	}

	


	public function registerAction(){
		global $wpdb;
		$return_data = array('stl_status'=>false,'message' => __('Error in user registration. Please try again later.','wp_stripe_management'));
		try{
		$suser_id = (isset($_POST['suser_id']))?$_POST['suser_id']:'';

		$password = $_POST['password'];
 		$full_name = $_POST['full_name'];
		$password = $_POST['password'];
		$email =$_POST['email'];

		$update_status = $wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('full_name' => $full_name,'password' => $password,'user_oldemail' =>$email,'created_on' => date('Y-m-d H:i:s') ), array('suser_id' => $suser_id));
		if($update_status){
			$wpstlemail =new WPStlEmailManagement();
	            $stl_status =  $wpstlemail->registerVerficationEmail($email,$suser_id);
	            if($stl_status)
	            {
	            	 $return_data = array('stl_status'=>true,'message' => __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management'));
	            } else {
			    	$return_data = array('stl_status'=>false,'message' => __('Error in mail sending. Please try again!','wp_stripe_management'));
			    }
			}
			else
			{
				$return_data = array('stl_status'=>false,'message' => __('Error in user creation. Please try again!','wp_stripe_management'));
			}
		   }
		  catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $return_data = array('stl_status'=>false,'message' => $err['message']);
            // $productplanids = array('stl_status' => false, 'message' => $err['message']);
        }

		/*$status = wp_create_user( $full_name, $password ,$email );
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

  			$return_data = array('stl_status'=>true,'message' => __('Account register successfully.Please check your mail.','wp_stripe_management'));
 		}*/
 		echo json_encode($return_data);
    	exit;
	}

	public function loginAction(){
		$return_data = array('stl_status'=>false,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));
		$login_data = array();  
		$login_pwdrequired = (isset($_POST['login_pwdrequired']))?$_POST['login_pwdrequired']:'';
		$suser_id = (isset($_POST['suser_id']))?$_POST['suser_id']:'';
    	
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

    		$wpstlemail =new WPStlEmailManagement();
            $stl_status =  $wpstlemail->loginVerficationEmail($_POST['email'],$suser_id);
            if($stl_status)
            {
            	 $return_data = array('stl_status'=>true,'message' => __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management'));
            } else {
		    	$return_data = array('stl_status'=>false,'message' => __('Error in mail sending. Please try again!','wp_stripe_management'));
		    }

    	// 	$username = $_POST['email'];  
    	// 	$user_verify = get_user_by('email', $username );
    	// 	// echo "<pre>";print_r($user_verify);echo "</pre>";
  			// if ( !is_wp_error( $user_verify ) && !empty($user_verify) )
		   //  {
		   //      wp_clear_auth_cookie();
		   //      wp_set_current_user ( $user_verify->ID );
		   //      wp_set_auth_cookie  ( $user_verify->ID );

		   //      $return_data = array('stl_status'=>true,'message' => __('Logged in successfully','wp_stripe_management'));
		   //  } else {
		   //  	$return_data = array('stl_status'=>false,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));
		   //  }
	    	 
    	}
    	
    	echo json_encode($return_data);
    	exit;
	}


	public function resendEmailVerification(){
		// echo "<pre>";print_r($_POST);echo "</pre>";
		$suser_id = (isset($_POST['suser_id']))?$_POST['suser_id']:'';
		$wpstlemail =new WPStlEmailManagement();
        $stl_status =  $wpstlemail->resendVerficationEmail($suser_id);
        // echo "stl_status = ".$stl_status;
        if($stl_status)
        {
           	$return_data = array('stl_status'=>true,'message' => __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management'));
        } else {
		   	$return_data = array('stl_status'=>false,'message' => __('Error in mail sending. Please try again!','wp_stripe_management'));
		}
		echo json_encode($return_data);
		exit;
	}

}