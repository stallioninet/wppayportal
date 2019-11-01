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


	public function checkEmailVerification()
	{
		$error_status = 0;
		$logreg_url = get_option('wssm_logreg_urlredirect','');
		$actinfo_url = get_option('wssm_stripe_page_acounttinfo','');
		
		$cdefault_currency = $this->cdefault_currency;
		$cdefault_currency_symbol = $this->cdefault_currency_symbol;
		$wssm_customer_id = $this->wssm_customer_id;
		global $wpdb;
		$message = $suser_id = $user_email = '';
		$link_expire = get_option('wssm_link_expire','never');
		try{
			// echo "<pre>";print_r($_GET);echo "</pre>";exit;
			if(isset($_GET['wssm_activationcode']) &&  isset($_GET['action']))
			{
				$actcode = $_GET['wssm_activationcode'];
			// echo "ifffffff";
				if($_GET['action'] == 'update')
				{
					$user_query = new WP_User_Query(array('meta_key'=>'wssm_activationcode','meta_value'=> $actcode));
					$users = $user_query->get_results();
					// echo "<pre>ggggggg";print_r($users);echo "</pre>";
					if(!empty($users))
					{
						foreach($users as $user)
						{
							$suser_id = $user->ID;
							$user_email = $user->user_email;
						}
					}
					// echo "user_id = ".$suser_id;

					// Query for users based on the meta data
					


					// $suser_id = $_GET['suser_id'];
					// $user = get_user_by( 'id', $suser_id );
					// echo "<pre>";print_r($user);echo "</pre>";
					
					
					// $actcode = get_user_meta( $suser_id, 'wssm_activationcode',true);
					$actdate = get_user_meta( $suser_id, 'wssm_activation_date',true);
					$new_email = get_user_meta( $suser_id, 'wssm_new_email',true);
					// echo "actcode = ".$actcode;
				}
				else if($_GET['action'] == 'accesslogin' || $_GET['action'] == 'accessreg' || $_GET['action'] == 'changemail'){
					// $suser_id = (isset($_GET['suser_id']))?$_GET['suser_id']:'';
					if($actcode !='')
					{
						$user_plans = $wpdb->get_row("SELECT * FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE activation_code = '".$actcode."'");
						if($user_plans)
						{
							$suser_id = $user_plans->suser_id;
							$status_type = $user_plans->status_type;
							if($status_type == 'changeemail')
							{
								$new_email = $user_plans->user_newemail;
							}
							else
							{
								$new_email = $user_plans->user_oldemail;
							}
							$user_oldemail = $user_plans->user_oldemail;
							$actcode = $user_plans->activation_code;
							$actdate = $user_plans->created_on;
							$full_name = $user_plans->full_name;
							$password = $user_plans->password;

						}
					}
				}
				else{}

// echo "suser_id = ".$suser_id;exit;
				if($suser_id !='')
				{
					// echo "act code match";
					$current_date = date('Y-m-d H:i:s');
					$to_time = strtotime($current_date);
					$from_time = strtotime($actdate);
					$time_differ = round(abs($to_time - $from_time) / 60);
					// echo "link_expire = ".$link_expire;
					// echo "time_differ = ".$time_differ;exit;

					if(($link_expire == '10mins' && $time_differ <= 10) || ($link_expire == '20mins' && $time_differ <= 20) || ($link_expire == '1hr' && $time_differ <= 60) || $link_expire == 'never')
					{
						if($_GET['action'] == 'update')
						{
							// echo "ifffffff";
							if($new_email !='')
							{
								if(!email_exists( $new_email))
								{
									$customer_details = parent::updateCustomerEmailID($user_email,$new_email);
									if($customer_details['stl_status'])
									{
										$args = array(
											'ID'         => $suser_id,
											'user_email' => esc_attr( $new_email )
										);
										wp_update_user( $args );

										// update_user_meta( $suser_id, 'wssm_activationcode', '');
										// update_user_meta( $suser_id, 'wssm_new_email', '');

										$message = '<div class="stl-alert stl-alert-success">'.__('Account details update successfully','wp_stripe_management').'</div>';

										$page_actinfo = get_option('wssm_stripe_page_acounttinfo','');
										$page_actinfo_url = site_url()."/".$page_actinfo;
										// wp_redirect( $page_addsub_url );
										echo "<script>window.location='".$page_actinfo_url."'</script>";exit;


										// $error_status = 0;
									}
									else
									{
										echo $message = '<div class="stl-alert stl-alert-danger">'.$customer_details['message'].'. <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';

										$page_url = site_url().'/'.$actinfo_url;
										// wp_redirect( $page_addsub_url );
										echo "<script>window.location='".$page_url."'</script>";exit;

									}
								}
								else
								{
									echo $message = '<div class="stl-alert stl-alert-danger">'.__('Email id already exists. Please try another email id.','wp_stripe_management').' <a href="'.site_url().'/'.$actinfo_url.'">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';

									$page_url = site_url().'/'.$actinfo_url;
									// wp_redirect( $page_addsub_url );
									echo "<script>window.location='".$page_url."'</script>";exit;

								}
							}
							else
							{
								echo $message = '<div class="stl-alert stl-alert-danger">'.__('The provided email id is not valid. Please try to change another email id.','wp_stripe_management').' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';

								$page_url = site_url().'/'.$actinfo_url;
								// wp_redirect( $page_addsub_url );
								echo "<script>window.location='".$page_url."'</script>";exit;
							}	
						}
						else if($_GET['action'] == 'changemail')
						{
							// echo "ddddddddd";
							if($new_email !='')
							{
								if(!email_exists( $new_email))
								{
									// echo "suser_id = ".$suser_id;
									// echo "new_email = ".$new_email;
									$old_user = get_user_by( 'email', $user_oldemail );
									// echo "<pre>";print_r($old_user);echo "</pre>";
									$user_id = $old_user->ID;
										$args = array(
											'ID'         => $user_id,
											'user_email' => esc_attr( $new_email )
										);
										wp_update_user( $args );

										// update_user_meta( $_GET['user_id'], 'wssm_activationcode', '');
										// update_user_meta( $_GET['user_id'], 'wssm_new_email', '');

										$user_verify = get_user_by('email', $new_email );
								    	// echo "<pre>";print_r($user_verify);echo "</pre>";
								  		if ( !is_wp_error( $user_verify ) && !empty($user_verify) )
										{
										    wp_clear_auth_cookie();
										    wp_set_current_user ( $user_verify->ID );
										    wp_set_auth_cookie  ( $user_verify->ID );

										    $message = '<div class="stl-alert stl-alert-success">'.__('Logged in successfully','wp_stripe_management').'</div>';
										    $error_status = 1;

										    $page_addsub = get_option('wssm_stripe_page_addsubscription','');
											$page_addsub_url = site_url()."/".$page_addsub."/?suser_id=".$suser_id;
											// wp_redirect( $page_addsub_url );
											echo "<script>window.location='".$page_addsub_url."'</script>";exit;

										} else {
											$message = '<div class="stl-alert stl-alert-danger">'.__('Something went wrong. Please try again!','wp_stripe_management').' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';
										}


										// $message = '<div class="stl-alert stl-alert-success">'.__('Account details update successfully','wp_stripe_management').'</div>';
									
								}
								else
								{
									$message = '<div class="stl-alert stl-alert-danger">'.__('Email id already exists. Please try another email id.','wp_stripe_management').'</div>';

									$page_addsub = get_option('wssm_stripe_page_addsubscription','');
											$page_addsub_url = site_url()."/".$page_addsub."/?suser_id=".$suser_id;
											// wp_redirect( $page_addsub_url );
											echo "<script>window.location='".$page_addsub_url."'</script>";exit;

								}
							}
							else
							{
								$message = '<div class="stl-alert stl-alert-danger">'.__('The provided email id is not valid. Please try to change another email id.','wp_stripe_management').'</div>';

								$page_addsub = get_option('wssm_stripe_page_addsubscription','');
											$page_addsub_url = site_url()."/".$page_addsub."/?suser_id=".$suser_id;
											// wp_redirect( $page_addsub_url );
											echo "<script>window.location='".$page_addsub_url."'</script>";exit;

							}	
						}
						else if($_GET['action'] == 'accesslogin')
						{
							// echo "elseeeeeee";

					    	$user_verify = get_user_by('email', $new_email );
					    	// echo "<pre>";print_r($user_verify);echo "</pre>";
					  		if ( !is_wp_error( $user_verify ) && !empty($user_verify) )
							{
							    wp_clear_auth_cookie();
							    wp_set_current_user ( $user_verify->ID );
							    wp_set_auth_cookie  ( $user_verify->ID );

							    $message = '<div class="stl-alert stl-alert-success">'.__('Logged in successfully','wp_stripe_management').'</div>';

							    $page_addsub = get_option('wssm_stripe_page_addsubscription','');
								$page_addsub_url = site_url()."/".$page_addsub."/?suser_id=".$suser_id;
								// wp_redirect( $page_addsub_url );
								echo "<script>window.location='".$page_addsub_url."'</script>";exit;

							} else {
								$message = '<div class="stl-alert stl-alert-danger">'.__('Invalid username or password. Please try again!','wp_stripe_management').' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';
							}

							

						}
						else if($_GET['action'] == 'accessreg')
						{
							if(!email_exists( $new_email))
							{
								if(!username_exists( $full_name))
								{

									// $website = "http://example.com";
									$userdata = array(
									    'user_pass'             => $password, 
									    'user_login'            => $full_name, 
									    'user_nicename'         => $full_name,  
									    'user_email'            => $new_email,  
									    'display_name'          => $full_name, 
									    'nickname'              => $full_name, 
									    'first_name'            => $full_name,  
									);
 
									$status = wp_insert_user( $userdata ) ;
									 

									// $status = wp_create_user( $full_name, $password ,$new_email );
									if( is_wp_error($status) ){
										$msg = '';
							 			foreach( $status->errors as $key=>$val ){
							 				foreach( $val as $k=>$v ){
							 					$msg = '<p class="error">'.$v.'</p>';
							 				}
							 			}
										// $return_data = array('stl_status'=>false,'message' => $msg);
										$message = '<div class="stl-alert stl-alert-danger">'.$msg.' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';
							 		}
							 		else
							 		{

								    	$user_verify = get_user_by('email', $new_email );
								    	// echo "<pre>";print_r($user_verify);echo "</pre>";
								  		if ( !is_wp_error( $user_verify ) && !empty($user_verify) )
										{
										    wp_clear_auth_cookie();
										    wp_set_current_user ( $user_verify->ID );
										    wp_set_auth_cookie  ( $user_verify->ID );

										    $message = '<div class="stl-alert stl-alert-success">'. __('Logged in successfully','wp_stripe_management').'</div>';

										    $page_addsub = get_option('wssm_stripe_page_addsubscription','');
											$page_addsub_url = site_url()."/".$page_addsub."/?suser_id=".$suser_id;
											// wp_redirect( $page_addsub_url );
											echo "<script>window.location='".$page_addsub_url."'</script>";exit;


										} else {

										    $message = '<div class="stl-alert stl-alert-danger">'.__('Someting went wrong. Please try again!','wp_stripe_management').' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';
										}

										
									}
								}
								else
								{
									$user_verify = get_user_by('login', $full_name );
								    // echo "<pre>";print_r($user_verify);echo "</pre>";
								  	if ( !is_wp_error( $user_verify ) && !empty($user_verify) )
									{
										wp_clear_auth_cookie();
										wp_set_current_user ( $user_verify->ID );
										wp_set_auth_cookie  ( $user_verify->ID );
										$page_addsub = get_option('wssm_stripe_page_addsubscription','');
										$page_addsub_url = site_url()."/".$page_addsub."/?suser_id=".$suser_id;
										// wp_redirect( $page_addsub_url );
										echo "<script>window.location='".$page_addsub_url."'</script>";exit;
									}

								}

							}
							else
							{
								$user_verify = get_user_by('email', $new_email );
							    // echo "<pre>";print_r($user_verify);echo "</pre>";
							  	if ( !is_wp_error( $user_verify ) && !empty($user_verify) )
								{
									wp_clear_auth_cookie();
									wp_set_current_user ( $user_verify->ID );
									wp_set_auth_cookie  ( $user_verify->ID );
									$page_addsub = get_option('wssm_stripe_page_addsubscription','');
									$page_addsub_url = site_url()."/".$page_addsub."/?suser_id=".$suser_id;
									// wp_redirect( $page_addsub_url );
									echo "<script>window.location='".$page_addsub_url."'</script>";exit;
								}

							}

						}
						else
						{

						}
					}
					else
					{
						$message = '<div class="stl-alert stl-alert-danger">'.__('The link is expired.','wp_stripe_management').' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';

						


					}
				}
				else
				{
					$message = '<div class="stl-alert stl-alert-danger">'.__('The activation code is not valid.','wp_stripe_management').' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';
				}
				if(file_exists(WPSTRIPESM_DIR.'templates/emailactivation.php')){

					include_once(WPSTRIPESM_DIR.'templates/emailactivation.php');
				}
			}
			else if(isset($_GET['wssm_activationcode']))
			{
				$new_email = '';
				$wssm_activationcode = (isset($_GET['wssm_activationcode']))?$_GET['wssm_activationcode']:'';
				// echo "suser_id = ".$suser_id;
				if($wssm_activationcode !='')
				{
					$user_plans = $wpdb->get_row("SELECT * FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE activation_code = '".$wssm_activationcode."'");
					// echo "<pre>";print_r($user_plans);echo "</pre>";
					if($user_plans)
					{
						$status_type = $user_plans->status_type;
						if($status_type == 'changeemail')
						{
							$new_email = $user_plans->user_newemail;
						}
						else
						{
							$new_email = $user_plans->user_oldemail;
						}
						
					}
				}
				
				$error_status = 1;
				// echo "error_status= ".$error_status;

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
        catch(Exception $e) {
        	$message = '<div class="stl-alert stl-alert-danger">'. $e->getMessage().' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';
        	if(file_exists(WPSTRIPESM_DIR.'templates/emailactivation.php')){
				include_once(WPSTRIPESM_DIR.'templates/emailactivation.php');
			}
        }

	}
	public function loginRegister(){	

		if(file_exists(WPSTRIPESM_DIR.'templates/loginregister.php')){
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			include_once(WPSTRIPESM_DIR.'templates/loginregister.php');
		}

	}
	




}

