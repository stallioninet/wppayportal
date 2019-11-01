<?php
class WPStlEmailManagement {
	public $wssm_link_expire;
    public $wssm_email_subject;
    public $wssm_email_sender;
    public $wssm_email_content;

    public function __construct(){
		global $stl_user_id;
		$this->wssm_link_expire = get_option('wssm_link_expire','never');
		$this->wssm_email_subject = get_option('wssm_email_subject','');
        $this->wssm_email_sender = get_option('wssm_email_sender','');
        $this->wssm_email_content = get_option('wssm_email_content','');
	}

	public function registerVerficationEmail($emailid,$actcode){
		global $wpdb;
		// $to = 'vijayasanthi.e@gmail.com';
		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');

		$subject = $this->wssm_email_subject;
		$body = $this->wssm_email_content;
		$body = nl2br(htmlspecialchars($body));
		// $user_activation_code = md5(rand());
		$headers = array('Content-Type: text/html; charset=UTF-8','From: Info <'.$this->wssm_email_sender.'>');

		// $bare_url = site_url().'/'.$wssm_mail_urlredirect.'?suser_id='.$suser_id.'&action=accessreg&wssm_activationcode='.$user_activation_code;

		$bare_url = site_url().'/'.$wssm_mail_urlredirect.'?action=accessreg&wssm_activationcode='.$actcode;

    	// $wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('activation_code' => $user_activation_code), array('activation_code' => $actcode));


		// update_user_meta( $uid, 'wssm_activationcode', $user_activation_code);
		// update_user_meta( $uid, 'wssm_activation_date', date('Y-m-d H:i:s'));
		// update_user_meta( $uid, 'suser_id', $suser_id);
		// update_user_meta( $uid, 'wssm_new_email', $emailid);

		$url_txt = "<a href='".$bare_url."'>Click here</a>";

		$body = str_replace("{{LINK}}",$url_txt,$body);

		$to_email = $emailid;
		// $to_email = 'vijayasanthi.e@gmail.com';
		if(wp_mail( $to_email, $subject, $body, $headers ))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function loginVerficationEmail($emailid,$actcode){
		global $wpdb;
		// echo "actcode = ".$actcode;
		// $to = 'vijayasanthi.e@gmail.com';
		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');

		$subject = $this->wssm_email_subject;
		$body = $this->wssm_email_content;
		$body = nl2br(htmlspecialchars($body));
		// $user_activation_code = md5(rand());
		$headers = array('Content-Type: text/html; charset=UTF-8','From: Info <'.$this->wssm_email_sender.'>');

		// $bare_url = site_url().'/'.$wssm_mail_urlredirect.'?suser_id='.$suser_id.'&action=accesslogin&wssm_activationcode='.$user_activation_code;

		$bare_url = site_url().'/'.$wssm_mail_urlredirect.'?action=accesslogin&wssm_activationcode='.$user_activation_code;

    	$wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('user_oldemail' =>$emailid ), array('activation_code' => $actcode));


		// update_user_meta( $uid, 'wssm_activationcode', $user_activation_code);
		// update_user_meta( $uid, 'wssm_activation_date', date('Y-m-d H:i:s'));
		// update_user_meta( $uid, 'suser_id', $suser_id);
		// update_user_meta( $uid, 'wssm_new_email', $emailid);

		$url_txt = "<a href='".$bare_url."'>Click here</a>";

		$body = str_replace("{{LINK}}",$url_txt,$body);

		$to_email = $emailid;
		// $to_email = 'vijayasanthi.e@gmail.com';
		if(wp_mail( $to_email, $subject, $body, $headers ))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function resendVerficationEmail($actcode){
		global $wpdb;
		$emailid = $status_type = '';
		// echo "actcode = ".$actcode;
		$user_query = new WP_User_Query(array('meta_key'=>'wssm_activationcode','meta_value'=> $actcode));
		$users = $user_query->get_results();
		// echo "<pre>ggggggg";print_r($users);echo "</pre>";
		if(!empty($users))
		{
			foreach($users as $user)
			{
				$actstate = 1;
				$suser_id = $user->ID;
				$emailid = $user->user_email;
			}
		}

		$user_plans = $wpdb->get_row("SELECT * FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE activation_code = '".$actcode."'");
		// echo "<pre>jjj";print_r($user_plans);echo "</pre>";
		if($user_plans)
		{
			$actstate = 2;
			$emailid = $user_plans->user_oldemail;
			$status_type = $user_plans->status_type;
		}
		if($emailid !='')
		{
			$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');

			$subject = $this->wssm_email_subject;
			$body = $this->wssm_email_content;
			$body = nl2br(htmlspecialchars($body));
			// $user_activation_code = md5(rand());
			$headers = array('Content-Type: text/html; charset=UTF-8','From: Info <'.$this->wssm_email_sender.'>');
			// $bare_url = site_url().'/'.$wssm_mail_urlredirect.'?suser_id='.$suser_id.'&action=accesslogin&wssm_activationcode='.$user_activation_code;
			if($status_type == '')
			{
				$bare_url = site_url().'/'.$wssm_mail_urlredirect.'?action=accesslogin&wssm_activationcode='.$actcode;
			}
			else
			{
				$bare_url = site_url().'/'.$wssm_mail_urlredirect.'?action='.$status_type.'&wssm_activationcode='.$actcode;
			}
			
			if($actstate == '2')
			{
				$wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('user_oldemail' =>$emailid,'created_on' => date('Y-m-d H:i:s') ), array('activation_code' => $actcode));
			}
			else
			{
				// update_user_meta( $suser_id, 'wssm_activationcode', $user_activation_code);
				update_user_meta( $suser_id, 'wssm_activation_date', date('Y-m-d H:i:s'));
				update_user_meta( $suser_id, 'wssm_old_email', $emailid);
			}
	    	

			$url_txt = "<a href='".$bare_url."'>Click here</a>";

			$body = str_replace("{{LINK}}",$url_txt,$body);

			$to_email = $emailid;
			// $to_email = 'vijayasanthi.e@gmail.com';
			if(wp_mail( $to_email, $subject, $body, $headers ))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	public function changeUserEmailid($old_emailid,$new_emailid,$user_activation_code){
		global $wpdb;
		// $to = 'vijayasanthi.e@gmail.com';
		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');
		// $user = wp_get_current_user();
  //   	$uid  = (int) $user->ID;
		$subject = $this->wssm_email_subject;
		$body = $this->wssm_email_content;
		$body = nl2br(htmlspecialchars($body));
		// $user_activation_code = md5(rand());
		$headers = array('Content-Type: text/html; charset=UTF-8','From: Info <'.$this->wssm_email_sender.'>');

		// $bare_url = site_url().'/'.$wssm_mail_urlredirect.'?suser_id='.$suser_id.'&user_id='.$uid.'&action=changemail&wssm_activationcode='.$user_activation_code;
		$bare_url = site_url().'/'.$wssm_mail_urlredirect.'?action=changemail&wssm_activationcode='.$user_activation_code;

		$wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('created_on' => date('Y-m-d H:i:s') ), array('activation_code' => $user_activation_code));


		$url_txt = "<a href='".$bare_url."'>Click here</a>";

		$body = str_replace("{{LINK}}",$url_txt,$body);

		$to_email = $new_emailid;
		// $to_email = 'vijayasanthi.e@gmail.com';
		if(wp_mail( $to_email, $subject, $body, $headers ))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function emailAccountinfoEmailEdit($old_emailid,$new_emailid){
		// $to = 'vijayasanthi.e@gmail.com';
		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');
		$user = wp_get_current_user();
    	$uid  = (int) $user->ID;
		$subject = $this->wssm_email_subject;
		$body = $this->wssm_email_content;
		$body = nl2br(htmlspecialchars($body));
		$user_activation_code = md5(rand());
		$headers = array('Content-Type: text/html; charset=UTF-8','From: Info <'.$this->wssm_email_sender.'>');

		// $bare_url = site_url().'/'.$wssm_mail_urlredirect.'?suser_id='.$uid.'&action=update&wssm_activationcode='.$user_activation_code;
		$bare_url = site_url().'/'.$wssm_mail_urlredirect.'?action=update&wssm_activationcode='.$user_activation_code;
		update_user_meta( $uid, 'wssm_activationcode', $user_activation_code);
		update_user_meta( $uid, 'wssm_activation_date', date('Y-m-d H:i:s'));
		update_user_meta( $uid, 'wssm_new_email', $new_emailid);

		$url_txt = "<a href='".$bare_url."'>Click here</a>";

		$body = str_replace("{{LINK}}",$url_txt,$body);

		$to_email = $new_emailid;
		// $to_email = 'vijayasanthi.e@gmail.com';
		if(wp_mail( $to_email, $subject, $body, $headers ))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}