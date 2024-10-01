<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
		$this->load->model('Personal');
		$this->load->model('Emailer');
		$this->load->model('Referrals');

		// Authenticate User
        if($this->Users->isActive()){
       		header("Location:" . base_url() . "profile"); die();
        }else{
        }
	}

	public function index()
	{
		//$this->login();

	//	echo "Handle Default Auth Behaviour!";
	}

	public function login($param = "")
	{
		if($this->Users->isActive()){
        
       		header("Location:" . base_url() . "profile");
        }

		$data = array();

		$data["login_error"] = "";
		$data["reg_error"] = "";
		$data["page_title"] = "Fecundhill | Login/Register";
		$data["logo_color"] = "white";
		$error_message = "";
		
		if ($this->input->post('login_but')) {

			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message = validation_errors();
			} else {
				$email         = protect($this->input->post('email'));
				$pass          = protect($this->input->post('password'));

				$data["log_used_email"] = $email;

				$sign_in_res = $this->Users->signUserIn($email, $pass);
				if ($sign_in_res[0] !== false) {
					// Successful, redirect
					header("Location:" . base_url() . "profile");
					die();

				} else {
					// Failure, Email Address or Password is incorrect
					$error_message .= "<p class='label label-danger'>Email Address ($email) or Password is incorrect!</p>";
				}
			}
		}
		$data["login_error"] = $error_message;
		$error_message = "";

		if ($this->input->post('register_but')) {

			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('surname', 'Surname', 'required');
			$this->form_validation->set_rules('phone', 'Phone Number', 'required');
			$this->form_validation->set_rules('state_location', 'Where do you live?', 'required');
			$this->form_validation->set_rules('town', 'Town/Area', 'required');
			$this->form_validation->set_rules('reg_email', 'Email', 'required|min_length[6]|is_unique[app_users.email]');
			$this->form_validation->set_rules('reg_password', 'Password', 'required|matches[reg_password2]');
			$this->form_validation->set_rules('reg_password2', 'Re-enter Password', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('marital_status', 'Marital Status', 'required');
			$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
			$this->form_validation->set_rules('lga_location', 'L.G.A of residence', 'required');

			$email         			= mb_strtolower(protect($this->input->post('reg_email')) );
			$firstname   			= protect($this->input->post('firstname'));
			$surname   				= protect($this->input->post('surname'));
			$phone      		    = protect($this->input->post('phone'));
			$town         			= protect($this->input->post('town'));
			$gender         		= protect($this->input->post('gender'));
			$date_of_birth         	= protect($this->input->post('date_of_birth'));
			$lga_location         	= protect($this->input->post('lga_location'));

			$data["reg_used_email"] 		= $email;
			$data["reg_used_firstname"] 	= $firstname;
			$data["reg_used_surname"] 		= $surname;
			$data["reg_used_phone"] 		= $phone;
			$data["reg_used_gender"] 		= $gender;
			$data["reg_used_date_of_birth"]	= $date_of_birth;
			$data["reg_used_lga_location"] 	= $lga_location;
			$data["reg_used_town"] 			= $town;

			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message = "<div class='label-danger' style='color:#FFF;'>" . validation_errors() . "</div>";
			} else {
				$email         = mb_strtolower(protect($this->input->post('reg_email')) );
				$pass          = protect($this->input->post('reg_password'));

				$firstname   			= protect($this->input->post('firstname'));
				$surname   				= protect($this->input->post('surname'));
				$phone      		    = protect($this->input->post('phone'));
				$state_location         = protect($this->input->post('state_location'));
				$town         			= protect($this->input->post('town'));

				$gender         		= protect($this->input->post('gender'));
				$marital_status         = protect($this->input->post('marital_status'));
				$date_of_birth         	= protect($this->input->post('date_of_birth'));
				$lga_location         	= protect($this->input->post('lga_location'));

				$data["reg_used_email"] 		= $email;
				$data["reg_used_firstname"] 	= $firstname;
				$data["reg_used_surname"] 		= $surname;
				$data["reg_used_phone"] 		= $phone;
				$data["reg_used_gender"] 		= $gender;
				$data["reg_used_date_of_birth"]	= $date_of_birth;
				$data["reg_used_lga_location"] 	= $lga_location;
				$data["reg_used_town"] 			= $town;

				
				$new_user_id = $this->Users->createUser($email, $pass);
				if ($new_user_id !== false) {
					// Successful,
					
					// Create User Profile
					$prof_res = $this->Personal->createPersonalInfo2($new_user_id, $firstname, $surname, $phone, $state_location, $town, $gender, $marital_status, $date_of_birth, $lga_location);
					
					// Create Account Verification Hash
					$hash = $this->Users->createVerifyAccountHash($new_user_id, $email);

					//Create Referral Code
					$this->Referrals->createReferralCode($new_user_id);
					
					// Send Account Verification Email
					$website_name = "Fecundhill";
					$contact_email = "info@fecundhill.com";
					$subject = "Fecundhill - Please Verify Your Account";
					$msg = "";
					$msg = "" ;
		//			$msg .= "<br/><hr/><br/>" ;

					$msg .= "<h3><b>Hello $email</b></h3>" ;

					$msg .= "<p>This message is for email account verification and enabling your Account on " . $website_name . " website. Please click the link below to verify your email address. Thank you</p>" ;
					$msg .= "<p><b><a href='".base_url()."auth_account/verify/". $hash."' >Email Address Verification Link ".base_url()."auth_account/verify/". $hash." </a></b></p>" ;
					$msg .= "<p>&nbsp;</p>" ;
					$msg .= "<p>If you received this email in error, please ignore it and complain to ".$contact_email."</p>" ;
					$msg .= "<p>Best Regards</p>" ;

		//			$msg .= "<br/><hr/><br/>" ;

					$cc_arr = array("jedacctwo@gmail.com");
		//			$cc_arr = array();

					$email_res = $this->Emailer->send_email_notification($email, $subject, $msg, $cc_arr);


					// Successful, Sign User In, redirect
					// Kill All Sessions
					$this->Users->remove();

					// Activate Sessions
					$this->Users->create($new_user_id);

					// Success, Registration was successful
					$error_message  .= "<p class='label label-success'>Registration was successful!</p>";

					header("Location:" . base_url() . "profile/verify_email");
					die();
					
				} else {
					// Failure, Registration was not sucessful
					$error_message .= "<p class='label label-danger'>Registration was not successful!</p>";
				}
			}
		}
		
		$data["reg_error"] = $error_message;
 		$this->load->view('auth/login', $data);
	}

	public function forgot()
	{

		$data = array();

		$data["forgot_error"] = "";
		$error_message = "";

		if ($this->input->post('forgot_but')) {

			$this->form_validation->set_rules('email', 'Email', 'required');

			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message = "<div class='label-danger' style='color:#FFF;'>" . validation_errors(). "</div>";
			} else {
				$email         = mb_strtolower(protect($this->input->post('email')) );

				// Check Forgot Email if existing
				$user_info = $this->Users->getUserByEmail($email);
				if ($user_info !== false) {
					// Existing, 

					// Create Password Reset Hash
					$hash = $this->Users->createResetPasswordHash($user_info["id"], $email);

					// Send Password Reset Link via Email
					$website_name = "Fecundhill";
					$contact_email = "info@fecundhill.com";
					$subject = "Reset Your Fecundhill Account Password";
					$msg = "";
					$msg = "";
					//			$msg .= "<br/><hr/><br/>" ;

					$msg .= "<h3><b>Hello $email</b></h3>";

					$msg .= "<p>You have requested a password reset on " . $website_name . " website. This message was sent to this email address because it is your Login Email for ".$website_name."</p>" ;
					$msg .= "<p>Please click the link below to reset your password. Thank you</p>";
					$msg .= "<p><a href='" . base_url() . "auth/reset_password/" . $hash . "' >Password Reset Link</a></p>";
					$msg .= "<p>&nbsp;</p>";
					$msg .= "<p>If you received this email in error, please kindly report to " . $contact_email . "</p>";
					$msg .= "<p>Best Regards</p>";

					//			$msg .= "<br/><hr/><br/>" ;

			//		$cc_arr = array("jedacctwo@gmail.com");
					$cc_arr = array();

					$email_res = $this->Emailer->send_email_notification($email, $subject, $msg, $cc_arr);

					// Success, Password Reset Request was successful
					$error_message  .= "<p class='label label-success label-lg'>Password Reset Request was successful! Please check ".$email." email inbox</p>";

				} else {
					// Failure, Password Reset Request was not successful
					$error_message  .= "<p class='label label-danger'>Registration was not successful!</p>";
				}
			}
		}

		$data["forgot_error"] = $error_message;
		$this->load->view('auth/forgot', $data);
	}

	public function reset_password($hash = ""){
		$data = array();

		$data["reset_error"] = "";
		$error_message = "";

		
		if ($this->input->post('reset_but')) {

			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password2]');
			$this->form_validation->set_rules('password2', 'Re-enter Password', 'required');

			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message = "<div class='label-danger' style='color:#FFF;'>" . validation_errors() . "</div>";
			} else {
				$password         = protect($this->input->post('password'));

				// Check Hash
				$reset_password_info = $this->Users->getResetPasswordInfo($hash);

				if ($reset_password_info !== false) {
					$user_id = $reset_password_info['user_id'];
				}

				// Reset Password
				if ($this->Users->resetAccountPassword($user_id, $password)) {

					// Delete Password Reset Info 
					$this->Users->removeResetPasswordHash($user_id);

					// Success, Password Reset was successful
					$error_message  .= "<p class='label label-success label-lg'>Password Reset was successful!</p>";

					// Redirect to Login
					header("Location:" . base_url() . "auth/login");
				}
			}

			$data["reset_error"] = $error_message;
			$this->load->view('auth/reset_password', $data);
		}else{
			// Check Hash
			$reset_password_info = $this->Users->getResetPasswordInfo($hash);

			if ($reset_password_info !== false) {
				$user_id = $reset_password_info['user_id'];

				// Sign User In
				// Kill All Sessions
				$this->Users->remove();

				// Activate Sessions
				$this->Users->create($user_id);

				// Show Reset Password Form
				$this->load->view('auth/reset_password', $data);
			} else {
				// Kill All Sessions
				$this->Users->remove();

				header("Location:" . base_url() . "auth_account/invalidlink");
			}

		}
		
	}

	public function handle_reset_password()
	{

		$data = array();

		$data["reset_error"] = "";
		$error_message = "";

		// Get Logged In UserID
		$user_id = $this->Users->getUserID();

		if ($this->input->post('reset_but')) {

			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password2]');
			$this->form_validation->set_rules('password2', 'Re-enter Password', 'required');

			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message = "<div class='label-danger' style='color:#FFF;'>".validation_errors()."</div>";
			} else {
				$password         = protect($this->input->post('password'));

				
				// Reset Password
				if($this->Users->resetAccountPassword($user_id, $password)){

					// Delete Password Reset Info 
					$this->Users->removeResetPasswordHash($user_id);

					// Success, Password Reset was successful
					$error_message  .= "<p class='label label-success label-lg'>Password Reset was successful!</p>";
				}
			}
		}

		$data["reset_error"] = $error_message;
		$this->load->view('auth/reset_password', $data);
	}

	public function logout($param = "")
	{

		$this->Users->remove();
		header("Location:" . base_url() . "auth/login"); die();
	}


}
