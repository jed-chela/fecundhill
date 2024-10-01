<?php

class Emailer extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		// Call the Model constructor
        parent::__construct();
		
	}
	
	var $domain 			= "fecundhill.com" ;
	var $from_default 		= "noreply@fecundhill.com" ;
	var $contact_email		= "info@fecundhill.com" ;
	var $from_default_name 	= "Fecundhill" ;
	var $mail_header_title 	= "Fecundhill" ;
	
	// EMAIL TEMPLATE
	public function send_email_notification($to, $subject, $msg, $cc = array(), $attachments = array()) {
		$this->load->library('email');
		
		$this->email->from($this->from_default, $this->from_default_name);
		$this->email->to($to);
		
		if(count($cc) > 0){
			$this->email->cc($cc);
		}
		
		if(count($attachments) > 0){
			for($i = 0; $i < count($attachments); $i++){
				$this->email->attach($attachments[$i]);
			}
		}
		
		$this->email->subject($subject);
		
		$msg1 = $this->notice_head();
		$msg2 = $this->notice_bottom();
		
		$msg = $msg1.$msg.$msg2;
		
		$this->email->message($msg);
		
		if($this->email->send()){ return true; }
		
		return false;
	}
	
	public function notice_head(){
		$logo = base_url()."assets/images/logo.jpg";
	//	$msg1 = "<html><head></head><body style='color:#000;font-size:11px;'><div style='float:none;width:100%;text-align:left; margin-left:20px; margin-top:10px;'><img src='" . $logo . "' alt='logo' width='120' /></div><div style='width:80%;margin-left:auto;margin-right:auto;color:#000;font-size:11px;border:1px solid #FFF;border-radius: 12px; padding:1em;'><div style='float:left;width:75%;font-size:2.0em;font-weight:bold;color:#000;padding-top:1em'>".$this->mail_header_title."</div><div style='float:right;width:25%;text-align:right'><img src='".$logo."' alt='logo' width='120' /></div><div style='text-align:justify;'>";
		$msg1 = "<html><head></head><body style='color:#000;font-size:11px;'><div style='float:none;width:100%;text-align:left; margin-left:1px; margin-top:10px;'><img src='" . $logo . "' alt='logo' width='120' /></div><div style='text-align:justify;'>";
		
		return $msg1;
	}

    public function notice_bottom(){
		$msg2 = "</div><div style='margin-bottom:2em;margin-top:3em;color:#000;'><span style='color:#004444;font-weight:bold;font-size:11px;'>For enquiries you can send a mail to ".$this->contact_email.".</span><br><br><br>Thank you<br>".$this->from_default_name." ICT Support Team.</div><div style='margin-top:1em;margin-bottom:1em;border-top:1px dashed #CCCCCC;text-align:left;'><br> ".$this->mail_header_title." &copy; ".date('Y')." </div></div></body></html>";

		return $msg2;
	}

	
}

?>