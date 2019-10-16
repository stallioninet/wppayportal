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

		$bare_url = site_url().'/'.$wssm_mail_urlredirect.'?user_id='.$uid.'&action=update&wssm_activationcode='.$user_activation_code;
		update_user_meta( $uid, 'wssm_activationcode', $user_activation_code);
		update_user_meta( $uid, 'wssm_activation_date', date('Y-m-d H:i:s'));
		update_user_meta( $uid, 'wssm_new_email', $new_emailid);

		$url_txt = "<a href='".$bare_url."'>Click here</a>";

		$body = str_replace("{{LINK}}",$url_txt,$body);

		$to_email = $new_emailid;
		$to_email = 'vijayasanthi.e@gmail.com';
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