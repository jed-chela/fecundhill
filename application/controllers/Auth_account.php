<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_account extends CI_Controller {

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
	//	$this->load->helper('encryption_helper');

		// Load Models
		$this->load->model('Users');
		$this->load->model('Emailer');
	}

	public function index()
	{
		//$this->login();

		echo "Handle Default Auth Behaviour!";
	}

	public function verify($hash)
	{

		$data = array();

		$data["login_error"] = "";
		$error_message = "";

		// Check Hash
		$verify_account_info = $this->Users->getVerifyAccountInfo($hash);

		if ($verify_account_info !== false) {
			
			// Check Account Verification Info Status
			if($verify_account_info['status'] == 9){
				// Success! Hash Activation Has Not Yet Been Used

				// Update Account Status to verified
				if($this->Users->verifyAndActivateAccount($verify_account_info['user_id'])){
					// Update Account Verification Info Status
					if ($this->Users->updateVerifyAccountInfo($verify_account_info['id'])) {

						// Sign User in
				//		$val_email = $this->Users->checkSignInEmailOnly($verify_account_info['email']);
				//		if ($val_email !== false) {

				//			$user_id = $val_email[1];

							// Kill All Sessions
							$this->Users->remove();

							// Activate Sessions
							$this->Users->create($verify_account_info['user_id']);

							header("Location:" . base_url() . "auth_account/verified");
				//		}

					}
				}

			}else{
				// Hash Activation Has Been Used. 
				// Do not Re-Activate for security purposes
				// Kill All Sessions
				$this->Users->remove();

				header("Location:" . base_url() . "auth_account/duplicate");
			}

			
		}else{
			// Kill All Sessions
			$this->Users->remove();
			
			header("Location:" . base_url() . "auth_account/invalidlink");
		}
			
	}

	public function invalidlink()
	{
		$this->load->view('auth/verify_invalid');
	}
	public function duplicate()
	{
		$this->load->view('auth/verify_duplicate');
	}
	public function verified()
	{
		$this->load->view('auth/verify_success');
	}





	
}
