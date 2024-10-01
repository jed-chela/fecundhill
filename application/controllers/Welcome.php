<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Load Libraries
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encryption');

		// Load Database
		$this->load->database();

		// Load Helpers
		$this->load->helper('url');
		$this->load->helper('main');
		$this->load->helper('time_functions');
		//	$this->load->helper('encryption_helper');

		// Load Models
		$this->load->model('Emailer');

		$this->load->model('Users');
	}


	public function index()
	{
		
		$this->load->view('index');
	}

	public function about()
	{
		$data["page_title"] = "Fecundhill | About";

		$this->load->view('about', $data);
	}
	public function about_finance()
	{
		$data["page_title"] = "Fecundhill | About Finance";

		$this->load->view('about_finance', $data);
	}
	public function about_transport()
	{
		$data["page_title"] = "Fecundhill | About Transport";

		$this->load->view('about_transport', $data);
	}
	public function about_real_estate()
	{
		$data["page_title"] = "Fecundhill | About Real Estate";

		$this->load->view('about_real_estate', $data);
	}
	public function contact_us()
	{
		$data["page_title"] = "Fecundhill | Contact Us";

		$this->load->view('contact_us', $data);
	}

	public function test_email(){
		$email = "testemail@testemail.biz";

		// Send Account Verification Email
		$website_name = "Fecundhill";
		$contact_email = "info@fecundhill.com";
		$subject = "Fecundhill - Please Verify Your Account";
		$msg = "";
		$msg = "";
		//			$msg .= "<br/><hr/><br/>" ;

		$msg .= "<h3><b>Hello $email</b></h3>";

		$msg .= "<p>This message is for email account verification and enabling your Account on " . $website_name . " website. Please click the link below to verify your email address. Thank you</p>";
		$msg .= "<p><a href='" . base_url() . "auth_account/verify/>Email Address Verification Link</a></p>";
		$msg .= "<p>&nbsp;</p>";
		$msg .= "<p>If you received this email in error, please ignore it and complain to " . $contact_email . "</p>";
		$msg .= "<p>Best Regards</p>";
		
		//			$msg .= "<br/><hr/><br/>" ;

		$cc_arr = array("jedacctwo@gmail.com");

		echo "Running";
	//	echo $this->Emailer->send_email_notification($email, $subject, $msg, $cc_arr);

	}
}
