<?php
class WPStlCommoncls extends WPStlStripeManagement {

	public $carddetail_url = 'card'; 
	public $invoice_url = 'invoices'; 
	public $subscription_url = 'subscriptions'; 
	public $add_subscription_url = 'add_subscription'; 
	public $flat_subscription_url = 'flat_subscriptions'; 
	public $meter_subscription_url = 'meter_subscriptions';
	public $multitier_subscription_url = 'multi_tier_subscriptions'; 
	public $flat_subscription_key = 'Flat Subscription'; 
	public $meter_subscription_key = 'Metered-based Subscription';
	public $multitier_subscription_key = 'Multi-tier subscription'; 


	public function __construct(){
		parent::__construct();
		add_action('init', array( $this,'stl_common_initfn'));
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
		// add_action('wp_ajax_getProductPlans', array( $this,'getProductPlans'));
		// add_action( 'wp_ajax_nopriv_getProductPlans', array( $this,'getProductPlans') );

		// add_action( 'init', array( $this,'add_rules' ));

	}

	public function stl_common_initfn(){
		add_rewrite_endpoint( $this->carddetail_url, EP_PAGES );
		add_rewrite_endpoint( $this->invoice_url, EP_PAGES );
		add_rewrite_endpoint( $this->subscription_url, EP_PAGES );
		add_rewrite_endpoint( $this->add_subscription_url, EP_PAGES );
		add_rewrite_endpoint( $this->flat_subscription_url, EP_PAGES );
		add_rewrite_endpoint( $this->meter_subscription_url, EP_PAGES );
		add_rewrite_endpoint( $this->multitier_subscription_url, EP_PAGES );
		// $subscription_types = SUBCSRIPTION_TYPES;
		// foreach($subscription_types as $key => $val)
		// {
		// 	add_rewrite_endpoint( $key, EP_PAGES );
		// }
		//add_rewrite_endpoint( $this->subscription_url, EP_PAGES );

		flush_rewrite_rules();
	}

	/*public function stl_common_templredirect(){
		global $wp_query;
		global $wssm_stripe_user_id;
		$stltemplate = new WPStlTemplatecls();

		


	    if ( ! isset( $wp_query->query_vars[$this->carddetail_url] ) && ! isset( $wp_query->query_vars[$this->invoice_url] ) && ! isset( $wp_query->query_vars[$this->add_subscription_url] ) && !isset($wp_query->query_vars[$this->flat_subscription_url]) && !isset($wp_query->query_vars[$this->meter_subscription_url]) && !isset($wp_query->query_vars[$this->multitier_subscription_url]) && !isset($wp_query->query_vars[$this->subscription_url])) {
	        return;
	    }

	    if ( isset( $wp_query->query_vars[$this->carddetail_url] ) ) {
	    	if ( is_user_logged_in() ) {
	    		// echo "product";
	    		$stltemplate->getCardTemplate();
	    	}
	    	else
			{
				wp_redirect( wp_login_url() );
			}
	    	die;
	    }
	    if ( isset( $wp_query->query_vars[$this->invoice_url] ) ) {
	    	if ( is_user_logged_in() ) {
	    		// echo "product";
	    		$stltemplate->getInvoiceTemplate();
	    	}
	    	else
			{
				wp_redirect( wp_login_url() );
			}
	    	die;
	    }

	    if ( isset( $wp_query->query_vars[$this->subscription_url] ) ) {
	    	if ( is_user_logged_in() ) {
	    		$stltemplate->getSubscriptionTemplate();
	    	}
	    	else
			{
				wp_redirect( wp_login_url() );
			}
	    	die;
	    }

	    if ( isset( $wp_query->query_vars[$this->add_subscription_url] ) ) {
	    	if ( is_user_logged_in() ) {
	    		$stltemplate->addSubscriptionTemplate();
	    	}
	    	else
			{
				wp_redirect( wp_login_url() );
			}
	    	die;
	    }

	    if ( isset( $wp_query->query_vars[$this->flat_subscription_url] ) ) {
	    	if ( is_user_logged_in() ) {
	    		$stltemplate->getSubscriptionTemplate_old('flat',$this->flat_subscription_key);
	    	}
	    	else
			{
				wp_redirect( wp_login_url() );
			}
	    	die;
	    }

	    if ( isset( $wp_query->query_vars[$this->meter_subscription_url] ) ) {
	    	if ( is_user_logged_in() ) {
	    		$stltemplate->getSubscriptionTemplate_old('meter',$this->meter_subscription_key);
	    	}
	    	else
			{
				wp_redirect( wp_login_url() );
			}
	    	die;
	    }

	    if ( isset( $wp_query->query_vars[$this->multitier_subscription_url] ) ) {
	    	if ( is_user_logged_in() ) {
	    		$stltemplate->getSubscriptionTemplate_old('multitier',$this->multitier_subscription_key);
	    	}
	    	else
			{
				wp_redirect( wp_login_url() );
			}
	    	die;
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
		// $pay_duedays = (isset($_POST['pay_duedays']))?$_POST['pay_duedays']:'';
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
		// $response_data = array('stl_status' => flase,'message' => 'Error to retrive invoice details.');
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
		//echo "<pre>";print_r($_POST);echo "</pre>";

		$successdata = parent::saveNewSubscriptionDetails($_POST);
		echo json_encode($successdata);

		// echo json_encode(array('stl_status' => false,'message' => 'test'));
		exit;
	}

	// public function getProductPlans(){
		


	// 	$successdata = parent::saveNewSubscriptionDetails($_POST);
	// 	echo json_encode($successdata);
	// 	exit;
	// }

}