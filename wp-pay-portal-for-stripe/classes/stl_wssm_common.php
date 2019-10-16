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


}