<?php
class WPStlTemplatecls extends WPStlStripeManagement {

	public $cdefault_currency = 'usd';
	public $cdefault_currency_symbol = 'US $';
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
				$planlists = parent::getProductPlanList();
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


	public function checkEmailVerification(){
		$message = '';
		// echo "<pre>";print_r($_GET);echo "</pre>";
		if(isset($_GET['wssm_activationcode']) && isset($_GET['user_id']) && isset($_GET['action']))
		{	
			if($_GET['action'] == 'update')
			{
				$user_id = $_GET['user_id'];
				$user = get_user_by( 'id', $user_id );
				// echo "<pre>";print_r($user);echo "</pre>";
				$user_email = $user->user_email;
				$link_expire = get_option('wssm_link_expire','never');
				$actcode = get_user_meta( $user_id, 'wssm_activationcode',true);
				$actdate = get_user_meta( $user_id, 'wssm_activation_date',true);
				$new_email = get_user_meta( $user_id, 'wssm_new_email',true);
				// echo "actcode = ".$actcode;
				if($actcode == $_GET['wssm_activationcode'])
				{
					// echo "act code match";
					$current_date = date('Y-m-d H:i:s');
					$to_time = strtotime($current_date);
					$from_time = strtotime($actdate);
					$time_differ = round(abs($to_time - $from_time) / 60);


					if(($link_expire == '10mins' && $time_differ <= 10) || ($link_expire == '20mins' && $time_differ <= 20) || ($link_expire == '1hr' && $time_differ <= 60) || $link_expire == 'never')
					{
						if($_GET['action'] == 'update')
						{
							if($new_email !='')
							{
								if(!email_exists( $new_email))
								{
									$customer_details = parent::updateCustomerEmailID($user_email,$new_email);
									if($customer_details['stl_status'])
									{
										$args = array(
										    'ID'         => $user_id,
										    'user_email' => esc_attr( $new_email )
										);
										wp_update_user( $args );

										update_user_meta( $user_id, 'wssm_activationcode', '');
										update_user_meta( $user_id, 'wssm_new_email', '');

										$message = '<div class="stl-alert stl-alert-success">'.__('Account details update successfully','wp_stripe_management').'</div>';
									}
									else
									{
										$message = '<div class="stl-alert stl-alert-success">'.$customer_details['message'].'</div>';
									}
								}
								else
								{
									$message = '<div class="stl-alert stl-alert-danger">'.__('Email id already exists. Please try another email id','wp_stripe_management').'</div>';
								}
							}
							else
							{
								$message = '<div class="stl-alert stl-alert-danger">'.__('The provided email id is not valid. Please try to change another email id.','wp_stripe_management').'</div>';
							}
							
						}
						else
						{

						}
					}
					else
					{
						$message = '<div class="stl-alert stl-alert-danger">'.__('The link is expired.','wp_stripe_management').'</div>';
						// echo "link expired";
					}
				}
				else
				{
					$message = '<div class="stl-alert stl-alert-danger">'.__('The activation code is not valid','wp_stripe_management').'</div>';
					// echo "no matchhhhh";
				}
			}
			else
			{

			}
	
			if(file_exists(WPSTRIPESM_DIR.'templates/emailactivation.php')){

				include_once(WPSTRIPESM_DIR.'templates/emailactivation.php');
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
	public function loginRegister(){	

		if(file_exists(WPSTRIPESM_DIR.'templates/loginregister.php')){

			include_once(WPSTRIPESM_DIR.'templates/loginregister.php');
		}

	}
	




}

