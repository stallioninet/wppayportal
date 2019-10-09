<?php
class WPStlTemplatecls extends WPStlStripeManagement {

	public $cdefault_currency = 'usd';
	public $cdefault_currency_symbol = 'usd';
	public $wssm_customer_id = '';
	public function __construct(){
		parent::__construct();
		$customerdata = parent::getStripeCustomerbasic();
		if($customerdata['stl_status']){
			$currency = $customerdata['currency'];
			$currency = ($currency !='')?$currency:'usd';
			$this->cdefault_currency = $currency;
			$this->cdefault_currency_symbol = (array_key_exists($currency,WSSM_CURRENCY))?WSSM_CURRENCY[$currency]:'US $';
			$this->wssm_customer_id = $customerdata['id'];
			// $this->cdefault_currency = ($currency !='')?$currency:'usd';
		}
	}
	
	public function getAcccountInfoTemplate(){	

		if($this->wssm_customer_id != '')
		{
			$active_menu = 'accountinfo';	
			if(file_exists(WPSTRIPESM_DIR.'templates/accountinfo.php')){
				wp_enqueue_script('stl_wssm_accountinfo_js');
				$cdefault_currency = $this->cdefault_currency;
				$cdefault_currency_symbol = $this->cdefault_currency_symbol;
				$wssm_customer_id = $this->wssm_customer_id;
				$customerdata = parent::getStripeCustomerbasic();
				include_once(WPSTRIPESM_DIR.'templates/accountinfo.php');
			}
		}
		else
		{
			$page_addsub = get_option('wssm_stripe_page_addsubscription','');
			$page_addsub_url = site_url()."/".$page_addsub;
			// wp_redirect( $page_addsub_url );
			echo "<script>window.location='".$page_addsub_url."'</script>";exit;
		}
	}
	public function getCardTemplate(){
		if($this->wssm_customer_id != '')
		{	
			$active_menu = 'card';		
			if(file_exists(WPSTRIPESM_DIR.'templates/card.php')){
				$cdefault_currency = $this->cdefault_currency;
				$cdefault_currency_symbol = $this->cdefault_currency_symbol;
				$wssm_customer_id = $this->wssm_customer_id;
				$cardlists = parent::getCustomerCardlist();
				include_once(WPSTRIPESM_DIR.'templates/card.php');
			}
		}
		else
		{
			$page_addsub = get_option('wssm_stripe_page_addsubscription','');
			$page_addsub_url = site_url()."/".$page_addsub;
			// wp_redirect( $page_addsub_url );
			echo "<script>window.location='".$page_addsub_url."'</script>";exit;
		}
	}
	public function getInvoiceTemplate(){
		if($this->wssm_customer_id != '')
		{	
			$active_menu = 'invoice';		
			if(file_exists(WPSTRIPESM_DIR.'templates/invoices.php')){
				$cdefault_currency = $this->cdefault_currency;
				$cdefault_currency_symbol = $this->cdefault_currency_symbol;
				$wssm_customer_id = $this->wssm_customer_id;
				$cardlists = parent::getCustomerCardlist();
				$invoicelists = parent::getCustomerInvoicelist();
				include_once(WPSTRIPESM_DIR.'templates/invoices.php');
			}
		}
		else
		{
			$page_addsub = get_option('wssm_stripe_page_addsubscription','');
			$page_addsub_url = site_url()."/".$page_addsub;
			// wp_redirect( $page_addsub_url );
			echo "<script>window.location='".$page_addsub_url."'</script>";exit;
		}
	}
	public function getSubscriptionTemplate(){	
		if($this->wssm_customer_id != '')
		{
			$active_menu = 'subcription';	
			//echo "<pre>";print_r($subkey);echo "</pre>";	
			//echo "subscription_type = ".$subscription_type;
			if(file_exists(WPSTRIPESM_DIR.'templates/subscriptions.php')){
				$cdefault_currency = $this->cdefault_currency;
				$cdefault_currency_symbol = $this->cdefault_currency_symbol;
				$wssm_customer_id = $this->wssm_customer_id;
				$subscriptiondatas = parent::getCustomerSubscriptionlist();
				$customerdata = parent::getStripeCustomerbasic();
				$cardlists = parent::getCustomerCardlist();
				// $planlists = parent::getProductPlanList();
				// $cardlists = parent::getCustomerCardlist();
				// $subscriptionlists = array('stl_status' => false);
				// $subproductss = parent::getProductandPlanIDs();
				
				include_once(WPSTRIPESM_DIR.'templates/subscriptions.php');
			}
		}
		else
		{
			$page_addsub = get_option('wssm_stripe_page_addsubscription','');
			$page_addsub_url = site_url()."/".$page_addsub;
			// wp_redirect( $page_addsub_url );
			echo "<script>window.location='".$page_addsub_url."'</script>";exit;
		}
	}
	public function addSubscriptionTemplate(){	
		$active_menu = 'subcription';	
		//echo "<pre>";print_r($subkey);echo "</pre>";	
		//echo "subscription_type = ".$subscription_type;
		if(file_exists(WPSTRIPESM_DIR.'templates/add_subscriptions.php')){
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			// $subscriptiondatas = parent::getCustomerSubscriptionlist($subkey);
			$customerdata = parent::getStripeCustomerbasic();
			$planlists = parent::getProductPlanList();
			$cardlists = parent::getCustomerCardlist();
			$taxlists = parent::getTaxList();
			// $subscriptionlists = array('stl_status' => false);
			// $subproductss = parent::getProductandPlanIDs();
			
			include_once(WPSTRIPESM_DIR.'templates/add_subscriptions.php');
		}
	}
	public function getSubscriptionTemplate_old($subscription_type = 'flat',$subkey = 'Flat Subscription'){		
		//echo "subscription_type = ".$subscription_type;
		if(file_exists(WPSTRIPESM_DIR.'templates/subscriptions.php')){
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			$subscriptionlists = parent::getCustomerSubscriptionlist_old($subkey);

			// $subscriptionlists = array('stl_status' => false);
			// $subproductss = parent::getProductandPlanIDs();
			
			include_once(WPSTRIPESM_DIR.'templates/subscriptions.php');
		}
	}

	




}

