<?php
class WPStlStripeManagement {
	public $wssm_stripe_client_id;
    public $wssm_stripe_public_key;
    public $wssm_stripe_secret_key;
    public $wssm_stripe_mode;
    public $wssm_stripe_productid;
    public $wssm_stripe_access_token;
    public $wssm_stripe_user_id;
    //public $meta_key = array('wssm_service','wssm_tier');
    // global $wpdb;

	public function __construct(){
		global $stl_user_id;
		// global $wssm_stripe_client_id;
		$this->wssm_stripe_mode = get_option('wssm_stripe_mode','test');
		// $wssm_stripe_mode = 'live';
		if($this->wssm_stripe_mode == 'test')
		{
			$this->wssm_stripe_client_id = get_option('wssm_test_client_id','');
        	$this->wssm_stripe_public_key = get_option('wssm_test_public_key','');
        	$this->wssm_stripe_secret_key = get_option('wssm_test_secret_key','');
        	$this->wssm_stripe_productid = get_option('wssm_test_product_id','');
        	$this->wssm_stripe_access_token = get_user_meta( $stl_user_id, 'wssm_test_access_token', true);
        	$this->wssm_stripe_user_id = get_user_meta( $stl_user_id, 'wssm_stripe_test_user_id', true);
		}
		else
		{
        	$this->wssm_stripe_client_id = get_option('wssm_live_client_id','');
        	$this->wssm_stripe_public_key = get_option('wssm_live_public_key','');
        	$this->wssm_stripe_secret_key = get_option('wssm_live_secret_key','');
        	$this->wssm_stripe_productid = get_option('wssm_live_product_id','');
        	$this->wssm_stripe_access_token = get_user_meta( $stl_user_id, 'wssm_live_access_token', true);
        	$this->wssm_stripe_user_id = get_user_meta( $stl_user_id, 'wssm_stripe_live_user_id', true);
		}




	}

    public function getProductandPlanIDs($subkey ='',$limit = '100')
    {
        global $stl_user_email;
        $productplanids = array('stl_status' => false, 'message' => "No products found");
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);
            $productlists = \Stripe\Product::all(['active' => true,'limit' => $limit]);
            // $productlists = $productlists->__toArray(true);
            if(isset($productlists['data']))
            {
                $productdatas = $productlists['data'];
                //$this_metakey = $this->meta_key;
                foreach($productdatas as $productdata)
                {
                    $product_id = $productdata['id'];
                    $product_meta = $productdata['metadata'];
                    $key_productid = '';
                    if($subkey !='')
                    {
                        if (array_key_exists('wssm_service',$product_meta))
                        {
                            if($product_meta['wssm_service'] == $subkey)
                            {
                                $key_productid = $product_id;
                            }
                        }
                    }
                    else
                    {
                        if (array_key_exists('wssm_service',$product_meta))
                        {
                            $key_productid = $product_id;
                        }
                    }
                    

                    // foreach($this_metakey as $this_meta)
                    // {
                    //     if (array_key_exists($this_meta,$product_meta))
                    //     {
                    //         $key_productid = $product_id;
                            
                    //     }
                    // }
                    if($key_productid !='')
                    {
                        $planlists = \Stripe\Plan::all(['product' => $key_productid,'limit' => 100]);
                        // $planlists = $planlists->__toArray(true);
                        $plandatas = $planlists['data'];
                        foreach($plandatas as $plandata)
                        {
                            $productplanids['product_ids'][$key_productid][] = $plandata['id'];
                        }
                        // $productplanids['product_ids'][$key_productid]['plandetails'] = $plandatas;
                        // $productplanids['product_ids'][$key_productid]['productdetails'] = $productdatas;
                    }
                    
                }
                //$productplanids[] = $productdatas;
            }
            $productplanids['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $productplanids = array('stl_status' => false, 'message' => $err['message']);
        }
        return $productplanids;
    }

    public function getAllCustomerlistbymail($limit = '1')
    {
        global $stl_user_email;
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);
            $customerlists = \Stripe\Customer::all(['email' => $stl_user_email,'limit' => $limit]);
            // echo "<pre>";print_r($customerlists);echo "</pre>";
            // $customerlists = $customerlists->__toJSON();
            $customerlists['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $customerlists = array('stl_status' => false, 'message' => $err['message']);
        }
        return $customerlists;
    }
    public function updateCustomerEmailID($customer_email,$new_emailid)
    {
        global $stl_user_email;
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);
            $customerlists = \Stripe\Customer::all(['email' => $customer_email,'limit' => 1]);
            if(!empty($customerlists))
            {
                $customer_datas = $customerlists['data'];
                foreach($customer_datas as $customer_data)
                {
                    $customer_id = $customer_data['id'];
                    $customerdetails = \Stripe\Customer::update($customer_id,
                        [
                            'email' => $new_emailid,
                            

                    ]);
                }
            }

            $customerlists['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $customerlists = array('stl_status' => false, 'message' => $err['message']);
        }
        return $customerlists;
    }
    public function getStripeCustomerbasic(){
        global $stl_user_email;
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            // \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);
            // $customerlists = \Stripe\Customer::all(['email' => $stl_user_email,'limit' => 1]);
            // $customerlists = $customerlists->__toArray(true);

            $customerlists =  $this->getAllCustomerlistbymail(1);

            if($customerlists['stl_status'])
            {
                if(isset($customerlists['data'][0]))
                {
                    $customerdetails = $customerlists['data'][0];
                    $customerdetails['stl_status'] = true;
                }
                else
                {
                    $customerdetails = array('stl_status' => false, 'message' => 'Stripe customer not found for this user emailid.');
                }                
            }
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $customerdetails = array('stl_status' => false, 'message' => $err['message']);
        }
        return $customerdetails;
    }

    public function saveCustomerInfo($postdata = array()){

        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            $customer_id = $postdata['customer_id'];
            if($customer_id !='')
            {
                if($postdata['old_emailid'] == $postdata['emailid']){
                    $customerdetails = \Stripe\Customer::update($customer_id,
                        [
                            'name' => $postdata['company_name'],
                            // 'email' => $postdata['emailid'],
                            'phone' => $postdata['phone'],
                            'address' => [
                                'line1' => $postdata['address_line1'],
                                'line2' => $postdata['address_line2'],
                                'city' => $postdata['city'],
                                'state' => $postdata['state'],
                                'country' => $postdata['country'],
                                'postal_code' => $postdata['postal_code'],
                            ]

                    ]);
                    $stl_status = true;
                    $message = '';
                }
                else
                {
                    $wpstlemail =new WPStlEmailManagement();
                    $stl_status =  $wpstlemail->emailAccountinfoEmailEdit($postdata['old_emailid'],$postdata['emailid']);
                    // $stl_status = $wpstlemail->emailAccountinfoEmailEdit($postdata['old_emailid'],'vijayasanthi.e@gmail.com');
                    $message = 'A verification email has been sent to your new mail id. Kindly check your mail and verify it.';
 
                }
                // $customer_data = $customer_data->__toArray(true);
                $customerdetails = array('stl_status' => $stl_status, 'message' => $message);
            }
            else
            {
                $customerdetails = \Stripe\Customer::create(
                    [
                        'name' => $postdata['company_name'],
                        'phone' => $postdata['phone'],
                        'email' => $postdata['emailid'],
                        'address' => [
                            'line1' => $postdata['address_line1'],
                            'line2' => $postdata['address_line2'],
                            'city' => $postdata['city'],
                            'state' => $postdata['state'],
                            'country' => $postdata['country'],
                            'postal_code' => $postdata['postal_code'],
                        ]

                ]);
                // $customer_data = $customer_data->__toArray(true);
                $customerdetails = array('stl_status' => true);
                
            }

            
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $customerdetails = array('stl_status' => false, 'message' => $err['message']);
        }
        return $customerdetails;
    }

    public function addCustomerCuponcode($postdata = array()){

        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            $customerlists =  $this->getAllCustomerlistbymail(1);
            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);
            if($customerlists['stl_status'])
            {
                $customerdatas = $customerlists['data'];
                foreach($customerdatas as $customerdata)
                {
                    // echo "<pre>";print_r($customerdata);echo "</pre>";
                    $customerdetails = \Stripe\Customer::update($customerdata['id'],
                    [
                        'coupon' => $postdata['coupon']
                    ]);
                    // $customerdetails = $customerdetails->__toArray(true);
                    $customerdetails = array('stl_status' => true);
                }
                
            }
            
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $customerdetails = array('stl_status' => false, 'message' => $err['message']);
        }
        return $customerdetails;
    }

    public function getCustomerCardlist(){
        global $stl_user_email;
        $card_list = array('stl_status' => false, 'message' => 'No data found');
        $card_lists = array();
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            $customerlists =  $this->getAllCustomerlistbymail(1);
            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            if($customerlists['stl_status'])
            {
                $customerdatas = $customerlists['data'];
                foreach($customerdatas as $customerdata)
                {
                    $card_data = \Stripe\Customer::allSources($customerdata['id'],['limit' => 105,'object' => 'card']
                    );
                    // $card_data = $card_data->__toArray(true);
                    if(isset($card_data['data']))
                    {
                        $card_data = $card_data['data'];
                        // $card_lists[] = $card_data['data'];
                        $card_lists = array_merge($card_lists,$card_data);
                    }
                    // echo "<pre>";print_r($card_data);echo "</pre>";
                    // $card_data = array('stl_status' => true);
                    
                }
                $card_list = array('stl_status' => true, 'card_lists' => $card_lists);
                
            }

        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $card_list = array('stl_status' => false, 'message' => $err['message']);
        }
        return $card_list;
    }

    public function getCustomerCardDetails($customerid,$card_id){
        global $stl_user_email;
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

             $carddata = \Stripe\Customer::retrieveSource($customerid,$card_id);
            // $carddata = $carddata->__toArray(true);
            $carddetails['stl_status'] = true;
            $carddetails['carddetails'] = $carddata;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $carddetails = array('stl_status' => false, 'message' => $err['message']);
        }
        return $carddetails;
    }

    public function deleteCardInfomation($postdata = array()){
        global $stl_user_email;
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

             $carddata = \Stripe\Customer::deleteSource(
                $postdata['customer_id'],
                $postdata['card_id']
            );
            $carddetails['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $carddetails = array('stl_status' => false, 'message' => $err['message']);
        }
        return $carddetails;
    }
    public function updateCardInfo($postdata = array()){
        global $stl_user_email;
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

             $carddata = \Stripe\Customer::updateSource(
                $postdata['customer_id'],
                $postdata['card_id'],
                [
                    'name' => $postdata['holder_name'],
                    'exp_month' => $postdata['expire_month'],
                    'exp_year' => $postdata['expire_year'],
                    'address_line1' => $postdata['address_line1'],
                    'address_line2' => $postdata['address_line2'],
                    'address_city' => $postdata['city'],
                    'address_state' => $postdata['state'],
                    'address_country' => $postdata['country'],
                    'address_zip' => $postdata['postal_code']
                ]
            );
            $carddetails['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $carddetails = array('stl_status' => false, 'message' => $err['message']);
        }
        return $carddetails;
    }

    public function addnewCardInfo($postdata = array()){
        global $stl_user_email;
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            $customerlists =  $this->getAllCustomerlistbymail(1);
            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            if($customerlists['stl_status'])
            {
                $customerdatas = $customerlists['data'];
                foreach($customerdatas as $customerdata)
                {
                    $carddata = \Stripe\Customer::createSource(
                        $customerdata['id'],
                        [
                            'source' => array(
                                'object' => 'card',
                                'name' => $postdata['holder_name'],
                                'number' => $postdata['card_no'],
                                'exp_month' => $postdata['expire_month'],
                                'exp_year' => $postdata['expire_year'],
                                'cvc' => $postdata['ccv'],
                                'address_line1' => $postdata['address_line1'],
                                'address_line2' => $postdata['address_line2'],
                                'address_city' => $postdata['city'],
                                'address_state' => $postdata['state'],
                                'address_country' => $postdata['country'],
                                'address_zip' => $postdata['postal_code']
                            )
                        ]
                    );
                    $carddetails['stl_status'] = true;
                }
            }

           

             
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $carddetails = array('stl_status' => false, 'message' => $err['message']);
        }
        return $carddetails;
    }

    public function getCustomerInvoicelist(){
        global $stl_user_email;
        $invoice_list = array('stl_status' => false, 'message' => 'No data found');
        $invoice_lists = array();
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            $customerlists =  $this->getAllCustomerlistbymail(1);
            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            if($customerlists['stl_status'])
            {
                $customerdatas = $customerlists['data'];
                foreach($customerdatas as $customerdata)
                {
                    $invoice_data = \Stripe\Invoice::all(['limit' => 100,'customer' => $customerdata['id']]
                    );
                    // $invoice_data = $invoice_data->__toArray(true);
                    if(isset($invoice_data['data']))
                    {
                        $invoice_data = $invoice_data['data'];
                        $invoice_lists = array_merge($invoice_lists,$invoice_data);
                    }
                }
                $invoice_list = array('stl_status' => true, 'invoice_lists' => $invoice_lists);
                
            }

        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $invoice_list = array('stl_status' => false, 'message' => $err['message']);
        }
        return $invoice_list;
    }

    public function getCustomerSubscriptionlist(){
        global $stl_user_email;
        $subscription_list = array('stl_status' => false, 'message' => 'No data found');
        $subscription_lists = array();
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            // foreach($subkey as $subk)
            // {
                // $productplanids = $this->getProductandPlanIDs($subk);
                // if($productplanids['stl_status'])
                // {
                    // $product_ids = $productplanids['product_ids'];
                    $customerlists =  $this->getAllCustomerlistbymail(1);
                    \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

                    if($customerlists['stl_status'])
                    {
                        $customerdatas = $customerlists['data'];
                        foreach($customerdatas as $customerdata)
                        {
                            /*$subscription_data = \Stripe\Subscription::all(['status' => 'all','limit' => 100,'customer' => $customerdata['id']]);
                                    $subscription_data = $subscription_data->__toArray(true);
                                    if(isset($subscription_data['data']))
                                    {
                                        $subscription_data = $subscription_data['data'];
                                        $subscription_lists = array_merge($subscription_lists,$subscription_data);
                                    }*/

                            // foreach($product_ids as $product_id => $plan_ids)
                            // {
                                // foreach($plan_ids as $plan_id)
                                // {
                                    $subscription_data = \Stripe\Subscription::all(['status' => 'all','limit' => 100,'customer' => $customerdata['id']]);
                                    // $subscription_data = $subscription_data->__toArray(true);
                                    if(isset($subscription_data['data']))
                                    {
                                        $subscription_data = $subscription_data['data'];
                                        $subdata = array();
                                        foreach($subscription_data as $subscription)
                                        {
                                            $sub_id = $subscription['id'];
                                            $invoice_data = \Stripe\Invoice::all(['subscription' => $sub_id,'limit' => 1]);

                                            $subdata_inner = $subscription;
                                            $subdata_inner['invoice'] = $invoice_data;
                                            $subdata[] = $subdata_inner;
                                        }
                                        

                                        $subscription_lists = array_merge($subscription_lists,$subdata);
                                    }
                                // }
                            // }
                            
                        }
                        $subscription_list = array('stl_status' => true, 'subscription_lists' => $subscription_lists,'customer_lists' => $customerlists);
                        
                    }
                    else
                    {
                        $subscription_list = array('stl_status' => false, 'message' => $customerlists['message']);
                    }
                // }
                // else
                // {
                //     $subscription_list = array('stl_status' => false, 'message' => $productplanids['message']);
                // }
            // }

        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_list = array('stl_status' => false, 'message' => $err['message']);
        }
        return $subscription_list;
    }

    public function getCustomerSubscriptionlist_withmeta($subkey = array()){
        global $stl_user_email;
        $subscription_list = array('stl_status' => false, 'message' => 'No data found');
        $subscription_lists = array();
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            foreach($subkey as $subk)
            {
                $productplanids = $this->getProductandPlanIDs($subk);
                if($productplanids['stl_status'])
                {
                    $product_ids = $productplanids['product_ids'];
                    $customerlists =  $this->getAllCustomerlistbymail(1);
                    \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

                    if($customerlists['stl_status'])
                    {
                        $customerdatas = $customerlists['data'];
                        foreach($customerdatas as $customerdata)
                        {
                            /*$subscription_data = \Stripe\Subscription::all(['status' => 'all','limit' => 100,'customer' => $customerdata['id']]);
                                    $subscription_data = $subscription_data->__toArray(true);
                                    if(isset($subscription_data['data']))
                                    {
                                        $subscription_data = $subscription_data['data'];
                                        $subscription_lists = array_merge($subscription_lists,$subscription_data);
                                    }*/

                            foreach($product_ids as $product_id => $plan_ids)
                            {
                                foreach($plan_ids as $plan_id)
                                {
                                    $subscription_data = \Stripe\Subscription::all(['status' => 'all','limit' => 100,'customer' => $customerdata['id'],'plan' => $plan_id]);
                                    // $subscription_data = $subscription_data->__toArray(true);
                                    if(isset($subscription_data['data']))
                                    {
                                        $subscription_data = $subscription_data['data'];
                                        $subscription_lists = array_merge($subscription_lists,$subscription_data);
                                    }
                                }
                            }
                            
                        }
                        $subscription_list = array('stl_status' => true, 'subscription_lists' => $subscription_lists);
                        
                    }
                }
                else
                {
                    $subscription_list = array('stl_status' => false, 'message' => $productplanids['message']);
                    return $plan_data;
                }
            }

        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_list = array('stl_status' => false, 'message' => $err['message']);
        }
        return $subscription_list;
    }
    public function getCustomerSubscriptionlist_old($subkey){
        global $stl_user_email;
        $subscription_list = array('stl_status' => false, 'message' => 'No data found');
        $subscription_lists = array();
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            $productplanids = $this->getProductandPlanIDs($subkey);
            if($productplanids['stl_status'])
            {
                $product_ids = $productplanids['product_ids'];
                $customerlists =  $this->getAllCustomerlistbymail(1);
                \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

                if($customerlists['stl_status'])
                {
                    $customerdatas = $customerlists['data'];
                    foreach($customerdatas as $customerdata)
                    {
                        foreach($product_ids as $product_id => $plan_ids)
                        {
                            foreach($plan_ids as $plan_id)
                            {
                                $subscription_data = \Stripe\Subscription::all(['limit' => 100,'customer' => $customerdata['id'],'plan' => $plan_id]);
                                // $subscription_data = $subscription_data->__toArray(true);
                                if(isset($subscription_data['data']))
                                {
                                    $subscription_data = $subscription_data['data'];
                                    $subscription_lists = array_merge($subscription_lists,$subscription_data);
                                }
                            }
                        }
                        
                    }
                    $subscription_list = array('stl_status' => true, 'subscription_lists' => $subscription_lists);
                    
                }
            }
            else
            {
                $subscription_list = array('stl_status' => false, 'message' => $productplanids['message']);
            }

        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_list = array('stl_status' => false, 'message' => $err['message']);
        }
        return $subscription_list;
    }
    public function cancelCustomerSubscription($subscription_id = ''){
        global $stl_user_email;
        $subscription_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            $wssm_stripe_cancel = get_option('wssm_stripe_cancel','immediately');
            $wssm_stripe_cancel_msg = get_option('wssm_stripe_cancel_msg','Subscription canceled');


            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            if($wssm_stripe_cancel == 'immediately')
            {
                $subscription_data = \Stripe\Subscription::retrieve($subscription_id);
                $subscription_data->cancel();
            }
            else
            {
                $subscription_data = \Stripe\Subscription::update($subscription_id,
                    ['cancel_at_period_end' => true]
                );
            }
            
            // $subscription_data = $subscription_data->__toArray(true);
            $subscription_data['stl_status'] = true;
            $subscription_data['message'] = $wssm_stripe_cancel_msg;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_data = array('stl_status' => false, 'message' => $err['message']);
        }
        return $subscription_data;
    }

    public function reactiveCustomerSubscription($subscription_id = ''){
        global $stl_user_email;
        $subscription_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');


            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);


                $subscription_data = \Stripe\Subscription::update($subscription_id,
                    ['cancel_at_period_end' => false]
                );
            
            
            // $subscription_data = $subscription_data->__toArray(true);
            $subscription_data['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_data = array('stl_status' => false, 'message' => $err['message']);
        }
        return $subscription_data;
    }

    public function addCustomerSubscriptionCoupon($customer_id = '',$subscription_id = '',$couponid = ''){
        global $stl_user_email;
        $subscription_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);
            $customerdetails = \Stripe\Customer::update($customer_id,
                    [
                        'coupon' => $couponid
                    ]);

            $subscription_data = \Stripe\Subscription::update($subscription_id,['coupon' => $couponid]);
            $subscription_data->cancel();
            // $subscription_data = $subscription_data->__toArray(true);
            $subscription_data['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_data = array('stl_status' => false, 'message' => $err['message']);
        }
        return $subscription_data;
    }

    public function getCustomerNextInvoiceDetails($postdata = array()){
        global $stl_user_email;
        $subscription_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);
            $subscription_data = \Stripe\Invoice::upcoming(["customer" => $postdata['customerid'], 'subscription' => $postdata['subscription_id']]);
            // $subscription_data = $subscription_data->__toArray(true);
            $subscription_data['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_data = array('stl_status' => false, 'message' => $err['message']);
        }
        return $subscription_data;
    }

    public function getCustomerMeterUsageDetails($postdata = array()){
        global $stl_user_email;
        // $subscription_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            $subitemid = $postdata['subitemid'];
            // $subitemid_arr = explode(',',$subitemid);
            // foreach($subitemid_arr as $sub_itemid)
            // {
            //     $subscription_data = \Stripe\UsageRecordSummary::all(["subscription_item" => $sub_itemid]);
            // }
            // $subscription_data = \Stripe\UsageRecordSummary::all();
           // $subscription_data =  \Stripe\UsageRecordSummary::all(['limit' => 3]);
            // $subscription_data = \Stripe\UsageRecordSummary::all(["subscription_item" => 'si_Ft333dyLxQGJiM']);


            $item = \Stripe\SubscriptionItem::retrieve($subitemid);
            $subscription_data['usages'] = $item->usageRecordSummaries();
            $subscription_data['item'] = $item;

            // $subscription_data = $subscription_data->__toArray(true);
            $subscription_data['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_data = array('message' => $err['message']);
        }
        return $subscription_data;
    }

    public function updateSubscriptionPaymenttype($postdata = array()){
        $subscription_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

           $pay_duedays = get_option('wssm_stripe_pay_duedays',30);
            if($postdata['payment_type'] == 'charge_automatically')
            {
                $payarra = ['collection_method' => $postdata['payment_type'],"default_source" => $postdata['card_id']];
            }
            else
            {
                $payarra = ['collection_method' => $postdata['payment_type'],'days_until_due' => $pay_duedays];
            }


            $subscription_data = \Stripe\Subscription::update($postdata['subid'],$payarra);
            // $subscription_data = $subscription_data->__toArray(true);
            $subscription_data['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $subscription_data = array('stl_status' => false, 'message' => $err['message']);
        }
        return $subscription_data;
    }

    public function PaystripeInvoice($postdata = array()){
        $return_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);


//             $intent = \Stripe\PaymentIntent::retrieve('pi_1FSJkMBKorklj30OFbPS8qvL');
// $intent->confirm([
//   // 'payment_method' => 'pm_card_visa',
//     'payment_method_types' => [
//     "card"
//   ],
// ]);


            $card_arr = [
                'card' => [
                    'number' => $postdata['card_no'],
                    'exp_month' => $postdata['expire_month'],
                    'exp_year' => $postdata['expire_year'],
                    'cvc' => $postdata['ccv'],
                    'name' => $postdata['holder_name'],
                    'address_line1' => $postdata['address_line1'],
                    'address_line2' => $postdata['address_line2'],
                    'address_city' => $postdata['city'],
                    'address_state' => $postdata['state'],
                    'address_zip' => $postdata['postal_code'],
                    'address_country' => $postdata['country']
                ]
            ];
            
            $card_type = $postdata['card_type'];
            $card_id = $postdata['card_id'];
            $invoice_arr = array();
            if($postdata['invpayment_type'] == 'single')
            {
                $invoice_arr[] = (object) $postdata;
            }
            else
            {
                //$invoice_arr = $postdata['invoice_arr'];
                $invoice_arr = json_decode(stripslashes($postdata['invoice_arr']));
            }

                foreach($invoice_arr as $invoice)
                {
                    if($card_type == '1')
                    {
                        
                            $create_chargedata =  \Stripe\Charge::create([
                              "amount" => $invoice->invoice_amount,
                              "currency" => $invoice->invoice_currency,
                              "customer" => $invoice->customer_id,
                              "card" => $card_id, // obtained with Stripe.js
                              //"description" => "Charge for jenny.rosen@example.com"
                            ]);
                            if($create_chargedata)
                            {
                               
                                    $invoice_data = \Stripe\Invoice::retrieve($invoice->invoice_id);
                                    $invoice_data->pay();
                                    // $return_data = $invoice_data->__toArray(true);
                                    $return_data['stl_status'] = true;
                                
                            }
                        

                    }
                    else
                    {
                        $stripe_token_data = \Stripe\Token::create($card_arr);
                        // $stripe_token_data = $stripe_token_data->__toArray(true);
                        // echo "<pre>";print_r($stripe_token_data);echo "</pre>";
                        if($stripe_token_data)
                        {
                            $token_id = $stripe_token_data['id'];
                            
                                $create_chargedata =  \Stripe\Charge::create([
                                  "amount" => $invoice->invoice_amount,
                                  "currency" => $invoice->invoice_currency,
                                  "source" => $token_id, // obtained with Stripe.js
                                  //"description" => "Charge for jenny.rosen@example.com"
                                ]);
                                if($create_chargedata)
                                {
                                    
                                        $invoice_data = \Stripe\Invoice::retrieve($invoice->invoice_id);
                                        $invoice_data->pay();
                                        // $return_data = $invoice_data->__toArray(true);
                                        $return_data['stl_status'] = true;
                                    
                                }
                            
                        }
                    }
                    
                    
                }

        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $return_data = array('stl_status' => false, 'message' => $err['message']);
        }
        return $return_data;
    }

    public function getProductPlanList(){
        $plan_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            $plan_data = \Stripe\Plan::all(['limit' => 100]);
            // $plan_data = \Stripe\Plan::all();
            // $plan_data = $plan_data->__toArray(true);
            $plan_data['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $plan_data = array('stl_status' => false, 'message' => $err['message']);
        }
        return $plan_data;
    }

    public function getTaxList(){
        $tax_data = array('stl_status' => false, 'message' => 'Subscription cance; faild.');
        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            $tax_data = \Stripe\TaxRate::all(['limit' => 100,'active' => true]);
            // $plan_data = \Stripe\Plan::all();
            // $tax_data = $tax_data->__toArray(true);
            $tax_data['stl_status'] = true;
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $tax_data = array('stl_status' => false, 'message' => $err['message']);
        }
        return $tax_data;
    }

    public function saveNewSubscriptionDetails($postdata){
        $customer_id = $postdata['customer_id'];
        $return_data = array('stl_status' => false, 'message' => 'Subscription add faild.');

        try {
            if (!isset($this->wssm_stripe_secret_key))
                    throw new Exception('The Stripe key was not added correctly');

            \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);

            
            $card_type = $postdata['card_type'];
            $collection_method = $postdata['collection_method'];
            $product_plans = $postdata['product_plans'];

            $company_name = (isset($_POST['company_name']))?$_POST['company_name']:'';
            if($company_name == '')
            {
                $company_name = $_POST['full_name'];
            }

            if($customer_id != '')
            {
                $customer_data = \Stripe\Customer::update($customer_id,
                    [
                        'name' => $company_name,
                        'phone' => $postdata['phone'],
                        'address' => [
                            'line1' => $postdata['address_line1'],
                            'line2' => $postdata['address_line2'],
                            'city' => $postdata['city'],
                            'state' => $postdata['state'],
                            'country' => $postdata['country'],
                            'postal_code' => $postdata['postal_code'],
                        ],
                        'metadata' => [
                            'fullname' => $postdata['full_name'],
                        ]

                    ]);
            }
            else
            {
                // echo "yyyyyyyy";
                $customer_data = \Stripe\Customer::create(
                    [
                        'name' => $company_name,
                        'phone' => $postdata['phone'],
                        'email' => $postdata['emailid'],
                        'address' => [
                            'line1' => $postdata['address_line1'],
                            'line2' => $postdata['address_line2'],
                            'city' => $postdata['city'],
                            'state' => $postdata['state'],
                            'country' => $postdata['country'],
                            'postal_code' => $postdata['postal_code'],
                        ],
                        'metadata' => [
                            'fullname' => $postdata['full_name'],
                        ]

                    ]);
                // $customer_data = $customer_data->__toArray(true);
                // echo "<pre>";print_r($customer_data);echo "</pre>";
                $customer_id = $customer_data['id'];
            }
            // echo "customer_id = ".$customer_id;
             $items_array = array();
            foreach($product_plans as $product_plan)
            {
                $plan_id = $product_plan['plan_id'];
                $qty = $product_plan['qty'];
                $usage_type = $product_plan['usage_type'];
                if($usage_type != 'metered')
                {
                    $items_array[] = array('plan' => $plan_id,'quantity' => $qty);
                }
                else
                {
                    $items_array[] = array('plan' => $plan_id);
                }
                
            }

            $meta_data = array();
            $metadata = $postdata['metadata'];
            foreach($metadata as $key => $value)
            {
                $meta_data[$key] = $value;
            }

            // $meta_data = array('application' => $postdata['metadata_application'],'customer' => $postdata['metadata_customer']);
                // $meta_data = array('application' => 'Root','customer' => 'testtttt meta viji');

            if($collection_method == 'charge_automatically')
            {
                if($card_type != '1')
                {
                    $carddata = \Stripe\Customer::createSource(
                        $customer_id,
                        [
                            'source' => array(
                                'object' => 'card',
                                'name' => $postdata['holder_name'],
                                'number' => $postdata['card_no'],
                                'exp_month' => $postdata['expire_month'],
                                'exp_year' => $postdata['expire_year'],
                                'cvc' => $postdata['ccv'],
                                'address_line1' => $postdata['card_address_line1'],
                                'address_line2' => $postdata['card_address_line2'],
                                'address_city' => $postdata['card_city'],
                                'address_state' => $postdata['card_state'],
                                'address_country' => $postdata['card_country'],
                                'address_zip' => $postdata['card_postal_code']
                            )
                        ]
                    );
                    // $carddata = $carddata->__toArray(true);
                    $card_id = $carddata['id'];
                }
                else
                {
                    $card_id = $postdata['card_id'];
                }

                $tax_id = $postdata['tax_id'];
                $default_tax = '';
                if($tax_id !='')
                {
                   
                    $return_data = \Stripe\Subscription::create([
                      "customer" => $customer_id,
                      "collection_method" => $postdata['collection_method'],
                      "items" => $items_array,
                      "default_source" => $card_id,
                      "default_tax_rates" => 
                        [
                            $tax_id,
                        ],
                      "metadata" => $meta_data,
                      "trial_from_plan" => true,
                      "payment_behavior" => "allow_incomplete",
                      "off_session" =>true
                    ]);
                }
                else
                {
                    $return_data = \Stripe\Subscription::create([
                      "customer" => $customer_id,
                      "collection_method" => $postdata['collection_method'],
                      "items" => $items_array,
                      "default_source" => $card_id,
                      "metadata" => $meta_data,
                      "payment_behavior" => "allow_incomplete",
                      "off_session" =>true
                    ]);
                }
                // $return_data = $return_data->__toArray(true);
                $return_data['stl_status'] = true;
            }
            else
            {
                $pay_duedays = get_option('wssm_stripe_pay_duedays',30);
                $tax_id = $postdata['tax_id'];
                $default_tax = '';
                if($tax_id !='')
                {
                   
                    $return_data = \Stripe\Subscription::create([
                      "customer" => $customer_id,
                      "collection_method" => $postdata['collection_method'],
                      "days_until_due" => $pay_duedays,
                      "items" => $items_array,
                      "default_tax_rates" => 
                        [
                            $tax_id,
                        ],
                      "metadata" => $meta_data,
                      "trial_from_plan" => true,
                      "payment_behavior" => "allow_incomplete",
                      "off_session" =>true
                    ]);
                }
                else
                {
                    $return_data = \Stripe\Subscription::create([
                      "customer" => $customer_id,
                      "collection_method" => $postdata['collection_method'],
                      "days_until_due" => $pay_duedays,
                      "items" => $items_array,
                      "metadata" => $meta_data,
                      "payment_behavior" => "allow_incomplete",
                      "off_session" =>true
                    ]);
                }

                
                
                // $return_data = $return_data->__toArray(true);
                $return_data['stl_status'] = true;
            }
           

            

           
        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $return_data = array('stl_status' => false, 'message' => $err['message'],'customer_id' => $customer_id);

        }
        return $return_data;
    }
}