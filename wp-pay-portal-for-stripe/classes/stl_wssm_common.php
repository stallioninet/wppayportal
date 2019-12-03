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
		add_action('wp_ajax_checkEmailalreadyexists', array( $this,'checkEmailalreadyexists'));
		add_action( 'wp_ajax_nopriv_checkEmailalreadyexists', array( $this,'checkEmailalreadyexists') );

		add_action('wp_ajax_saveAdditionalUser', array( $this,'saveAdditionalUser'));
		add_action( 'wp_ajax_nopriv_saveAdditionalUser', array( $this,'saveAdditionalUser') );

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
		$user_activation_code = md5(rand());
		$wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('plan_details' => $product_plans,'activation_code' => $user_activation_code, 'status_type' => 'reglogin') );
		$lastid = $wpdb->insert_id;
		echo json_encode(array('actcode' => $user_activation_code,'stl_status' => true));
		exit;
	}

	public function changeEmailid(){
		global $wpdb;
		$user = wp_get_current_user();
    	$uid  = (int) $user->ID;

    	$emailid = (isset($_POST['emailid']))?$_POST['emailid']:'';
		$oldemailid = (isset($_POST['oldemailid']))?$_POST['oldemailid']:'';

		if(!email_exists( $emailid ))
		{
		
			// echo "<pre>";print_r($_POST);echo "</pre>";
			$product_plans = (isset($_POST['product_plans']))?$_POST['product_plans']:'';
			$company_name = (isset($_POST['company_name']))?$_POST['company_name']:'';
			
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
			$user_activation_code = md5(rand());
			$wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('plan_details' => $product_plans, 'user_oldemail' => $oldemailid,'user_newemail' => $emailid,'status_type' => 'changeemail','activation_code' => $user_activation_code) );
			$lastid = $wpdb->insert_id;
			$wpstlemail =new WPStlEmailManagement();
		    $stl_status =  $wpstlemail->changeUserEmailid($oldemailid,$emailid,$user_activation_code);
		    if($stl_status)
		    {
		        $message = __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management');
		        $stl_status = true;
		    } else {
				$message = __('Error in mail sending. Please try again!','wp_stripe_management');
				$stl_status = false;
			}

		}
		else
		{
			$message = __('Email already in use!','wp_stripe_management');
			$stl_status = false;
		}
		echo json_encode(array('actcode' => $user_activation_code,'stl_status' => $stl_status,'message' => $message));
		exit;
	}

	


	public function registerAction(){
		global $wpdb;
		$return_data = array('stl_status'=>false,'message' => __('Error in user registration. Please try again later.','wp_stripe_management'));
		try{
		$actcode = (isset($_POST['actcode']))?$_POST['actcode']:'';

		$password = $_POST['password'];
 		$full_name = $_POST['full_name'];
		$password = $_POST['password'];
		$email =$_POST['email'];
		$rpage = (isset($_POST['rpage']))?$_POST['rpage']:'';

		if($actcode !='')
		{
			$update_status = $wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('full_name' => $full_name,'password' => $password,'user_oldemail' =>$email,'created_on' => date('Y-m-d H:i:s'),'status_type' => 'accessreg' ), array('activation_code' => $actcode));
		}
		else
		{
			$actcode = md5(rand());
			$update_status = $wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('full_name' => $full_name,'password' => $password,'user_oldemail' =>$email,'created_on' => date('Y-m-d H:i:s'),'status_type' => 'accessreg' ,'activation_code' => $actcode));
		}
		
		// echo $wpdb->last_query;
		// echo "<pre>";print_r($update_status);echo "</pre>";
		if($update_status){
			$wpstlemail =new WPStlEmailManagement();
	            $stl_status =  $wpstlemail->registerVerficationEmail($email,$actcode,$rpage);
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
		if (!session_id())
    		session_start();
		global $wpdb;
		$try_count = 0;
		$return_data = array('stl_status'=>false,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));
		$login_data = array();  
		$login_pwdrequired = (isset($_POST['login_pwdrequired']))?$_POST['login_pwdrequired']:'';
		$actcode = (isset($_POST['actcode']))?$_POST['actcode']:'';
		$rpage = (isset($_POST['rpage']))?$_POST['rpage']:'';
    	$mess = '';
    	$stl_transient_name = (isset($_SESSION['stl_transient_name']))?$_SESSION['stl_transient_name']:'';
    	$stl_transient_mail = (isset($_POST['email']))?$_POST['email']:'';
    	$stl_transient_new = 'attempted_login_'.$stl_transient_mail;
    	// echo "stl_transient_name = ".$stl_transient_name;

    	if($login_pwdrequired == '')
    	{
    		// echo "1111";
    		// echo "sss".get_transient( 'attempted_login' );
    		if ( $stl_transient_name !='' && $stl_transient_new == $stl_transient_name  && get_transient( $stl_transient_name ) ) {
    			// echo "222222222";

    			$datas = get_transient( $stl_transient_name );
    			$try_count = $datas['tried'];
    			if ( $datas['tried'] < 4 ) {
    				// echo "33333333";
		    		$login_data['user_login'] = $_POST['email'];  
		    		$login_data['user_password'] = $_POST['password'];
			     	$user_verify = wp_signon( $login_data, true );   
			     	// echo "</pre>";print_r($user_verify);echo "</pre>";
			    	if ( !is_wp_error($user_verify) )   
			    	{  
			    		$return_data = array('stl_status'=>true,'message' => __('Logged in successfully','wp_stripe_management')); 
			    	}
			    	else
			    	{
			    		// echo "<pre>";print_r(is_wp_error($user_verify));echo "</pre>";
			    		$return_data = array('stl_status'=>false,'try_count' => $try_count,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));

			    	}
			    }
			    else
			    {
			    	$until = get_option( '_transient_timeout_' . $stl_transient_name );
					$time = time_to_go( $until );
					$mess = 'You have reached authentication limit, you will be able to try again in '.$time.'.';
					$return_data = array('stl_status'=>false,'message' => $mess );
			    }
	    	} 
	    	else
	    	{
	    		$login_data['user_login'] = $_POST['email'];  
		    		$login_data['user_password'] = $_POST['password'];
			     	$user_verify = wp_signon( $login_data, true );   
			     	// echo "</pre>";print_r($user_verify);echo "</pre>";
			    	if ( !is_wp_error($user_verify) )   
			    	{  
			    		$return_data = array('stl_status'=>true,'message' => __('Logged in successfully','wp_stripe_management')); 
			    	}
			    	else
			    	{
			    		$try_count++;
			    		// echo "<pre>";print_r(is_wp_error($user_verify));echo "</pre>";
			    		$return_data = array('stl_status'=>false,'try_count' => $try_count,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));

			    	}
	    	}
    	}
    	else
    	{

    		if($actcode =='')
			{
				$actcode = md5(rand());
				$insert_status = $wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('user_oldemail' => $_POST['email'],'created_on' => date('Y-m-d H:i:s'),'status_type' => 'accessreg','activation_code' => $actcode));
				// echo $wpdb->last_query;
			}
			
// echo "actcode = ".$actcode;

    		$wpstlemail =new WPStlEmailManagement();
            $stl_status =  $wpstlemail->loginVerficationEmail($_POST['email'],$actcode,$rpage);
            // exit;
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

	public function saveAdditionalUser(){
		global $wpdb;
		$return_data = array('stl_status'=>false,'message' => __('Error in user registration. Please try again later.','wp_stripe_management'));
		try{

		$password = $_POST['password'];
 		$full_name = $_POST['full_name'];
		$password = $_POST['password'];
		$email =$_POST['email'];
		$parent_userid = $_POST['parent_userid'];
		$rpage = 'additional_users';

		$actcode = md5(rand());
		$update_status = $wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('full_name' => $full_name,'password' => $password,'user_oldemail' =>$email,'created_on' => date('Y-m-d H:i:s'),'status_type' => 'additional_user_add' ,'activation_code' => $actcode,'plan_details' => $parent_userid));


		if($update_status){
			$wpstlemail =new WPStlEmailManagement();
	            $stl_status =  $wpstlemail->additionalUserVerficationEmail($email,$actcode,$rpage);
	            if($stl_status)
	            {
	            	 $return_data = array('stl_status'=>true,'message' => __('Email Verification send to the user mail id. Please check the added mail and verify it','wp_stripe_management'));
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

 		echo json_encode($return_data);
    	exit;
	}

	public function resendEmailVerification(){
		// echo "<pre>";print_r($_POST);echo "</pre>";
		$actcode = (isset($_POST['actcode']))?$_POST['actcode']:'';
		$wpstlemail =new WPStlEmailManagement();
        $stl_status =  $wpstlemail->resendVerficationEmail($actcode);
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

	public function checkEmailalreadyexists(){
		// require_once("../../../../wp-load.php");
		// echo "<pre>";print_r($_POST);echo "</pre>";
		
		
		$emailtype  = (isset($_POST['emailtype']))?$_POST['emailtype']:'accountadd';
		
	
		if($emailtype == 'accountadd')
		{
			$email = (isset($_POST['email']))?$_POST['email']:'';
			$email_exitid = email_exists( $email );
			if($email_exitid)
			{
				echo 'false';
			}
			else
			{
				echo 'true';
			}
		}
		else if($emailtype == 'accountunameadd')
		{
			$full_name = (isset($_POST['full_name']))?$_POST['full_name']:'';
			$uname_exitid = username_exists( $full_name );
			if($uname_exitid)
			{
				echo 'false';
			}
			else
			{
				echo 'true';
			}
		}
		else if($emailtype == 'accountedit' )
		{
			$email = (isset($_POST['emailid']))?$_POST['emailid']:'';
			$old_emailid = (isset($_POST['old_emailid']))?$_POST['old_emailid']:'';
			if($old_emailid != $email)
			{
				$email_exitid = email_exists( $email );
				// echo "email_exitid = ".$email_exitid;
				if($email_exitid)
				{
					echo 'false';
				}
				else
				{
					echo 'true';
				}
			}
			else{echo 'true';}
		}
		else{echo 'true';}
		exit;
	}
	

}