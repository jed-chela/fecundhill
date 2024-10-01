<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
		$this->load->model('Personal');
		$this->load->model('Partner');
		$this->load->model('Finance');
		$this->load->model('Listing');
		$this->load->model('Referrals');
		$this->load->model('ExpressDelivery');

		if($this->Users->isActive()){
		
		}else{
			header("Location: ".base_url()."auth/login");
			exit();
		}
	}

	public function index()
	{
		//Enforce SMS Verification
		$user_id	= $this->Users->getUserID();
		$check 		= $this->Users->getPhoneVerify($user_id);
		if($check !== false){
			// Update if NOT verified
			if($check[0]["verify"] == 2){
				// User Already verified
			}else{
				// User NOT yet verified
				header("Location: ".base_url()."profile/verify_sms");
				exit();
			}
		}else{
			// User NOT yet verified
			header("Location: ".base_url()."profile/verify_sms");
			exit();
		}

		$this->finance_home();
	}

	public function dashboard($param = "")
	{
		$data["page_title"] = "Fecundhill | Dashboard";
		$data["nav_tag"] = "dashboard";
		$error_message = "";

		//Enforce SMS Verification
		$user_id	= $this->Users->getUserID();
		$check 		= $this->Users->getPhoneVerify($user_id);
		if($check !== false){
			// Update if NOT verified
			if($check[0]["verify"] == 2){
				// User Already verified
			}else{
				// User NOT yet verified
				header("Location: ".base_url()."profile/verify_sms");
				exit();
			}
		}else{
			// User NOT yet verified
			header("Location: ".base_url()."profile/verify_sms");
			exit();
		}

		$this->load->view("profile", $data);
	}

	public function verify_sms($param = "")
	{
		$data["request_loan_form_error"] = "";
		$data["withdrawal_form_error"] = "";
		$data["page_title"] = "Fecundhill | Verify SMS";
		$data["nav_tag"] = "profile";
		$error_message = "";

		if ($this->input->post("send_otp")) {

			$user_id	 		= $this->Users->getUserID();
			$phone 				= protect($this->input->post("phone"));

			// Generate the OTP
			//$otp = generateNumericOTP(5);
			$otp = mt_rand(10101, 99909);
			$send_otp = false;

			// Save OTP
			$check = $this->Users->getPhoneVerify($user_id);
			if($check !== false){
				// Update if NOT verified
				if($check[0]["verify"] == 2){
					// User Already verified
					$error_message = "You have already done SMS Verification";
				}else{
					// User NOT yet verified
					$this->Users->updatePhoneVerifyRecord($user_id, $phone, $otp);
					$send_otp = true;
				}
			}else{
				// Create
				$this->Users->createPhoneVerify($user_id, $phone, $otp);
				$send_otp = true;
			}

			if($send_otp === true){
				// Send OTP
				
				// Send OTP via SMS OTP API
			/*	$url 	= 'https://app.smartsmssolutions.com/io/api/client/v1/smsotp/send/';
				$post 	= array(
					"token" 		=> "YLyT7ctmIqpA7pFYnFJ8A0SU8QIZnHu2yBktniVgiyGxBtSFWa",
					"phone" 		=> $phone,
					"otp" 			=> $otp,
					"sender" 		=> "FECUNDHILL",
					"template_code" => "7153792424",
					"app_name_code"		=> "5832004304",
					"ref_id" 		=> "fec".idate("U"),
				);	
			*/

				// Send OTP via SMS API
				$message = "Your O T P is ".$otp. ". Please do not send it to anyone.";
				$url 	= 'https://app.smartsmssolutions.com/io/api/client/v1/sms/';
				$post 	= array(
					"token" 		=> "CpAIYnY0yGRiegkh1WDYRaeiDQMeMVWr1jNXSHAOFJcqLc6DLK",
					"to" 			=> $phone,
					"message" 		=> $message,
					"sender" 		=> "FECUNDHILL",
					"type" 			=> "0",
					"routing"		=> "3",
					"ref_id" 		=> "fec".idate("U"),
				);
			

		/*		$options = array(
					"CURLOPT_RETURNTRANSFER" => true
				);
		//		print_r($post);

		//		$result = curl_post($url, $post, $options);
				print_r($result);
				if($result){
		//			print_r($result);
				}		*/

				$cURLConnection = curl_init($url);
				curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $post);
				curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

				$apiResponse = curl_exec($cURLConnection);
				curl_close($cURLConnection);

				// $apiResponse - available data from the API request
				$jsonArrayResponse = json_decode($apiResponse);
			//	print_r($jsonArrayResponse);

			}
			
		}
		if ($this->input->post("confirm_otp")) {

			$user_id	 		= $this->Users->getUserID();
			$otp 				= protect($this->input->post("otpcode"));

			// Check OTP
			$check = $this->Users->getPhoneVerify($user_id);
			if($check !== false){
				// Update if NOT verified
				if($check[0]["verify"] == 2){
					// User Already verified
					$error_message = "You have already done SMS Verification";
				}else if($check[0]["otp"] == $otp){
					// OTP Matches, verify user
					$res = $this->Users->updatePhoneVerifyStatus($user_id, 2);
					$query_phone = array(
						"phone" 			=> $check[0]["phone"],
					);
					$res2 = $this->Users->updatePersonalInfo($user_id, $query_phone);
					$error_message = "<p class='text-success'>Successful SMS Verification</p>";
				}
			}else{
				// No Record Found. Reload Page and Try again.
				$error_message = "No Record Found. Reload Page and Try again.";
			}
		}
		
		$data["request_loan_form_error"] = $error_message;

		$this->load->view("profile_sms_verify", $data);
	}
	

	public function finance_home($param = "")
	{
		$data["request_loan_form_error"] = "";
		$data["withdrawal_form_error"] = "";
		$data["page_title"] = "Fecundhill | Dashboard - Finance";
		$data["nav_tag"] = "finance";
		$error_message = "";

		if ($this->input->post("request_loan_but")) {

			$user_id = $this->Users->getUserID();
			$loan_amount 		= protect($this->input->post("loan_amount"));
			$loan_duration 		= protect($this->input->post("loan_duration"));
			$children 			= protect($this->input->post("children"));
			$bank_account 		= protect($this->input->post("bank_account"));
			$cheque_book 		= protect($this->input->post("cheque_book"));
			$bank_name 			= protect($this->input->post("bank_name"));
			$account_name 		= protect($this->input->post("account_name"));
			$account_number 	= protect($this->input->post("account_number"));
			$current_income 	= protect($this->input->post("current_income"));
			$other_loan 		= protect($this->input->post("other_loan"));


			$check_pending = $this->Finance->getPendingLoanRequest($user_id);
			if ($check_pending === false){

				$save_res = $this->Finance->createNewLoanRequest($user_id, $loan_amount, $loan_duration, $children, $bank_account, $cheque_book, $bank_name, $account_name, $account_number, $current_income, $other_loan);
				if ($save_res !== false) {
					// Loan Request Info saved successfully
					$error_message  .= "<p class='label label-success label-lg'>Loan Request Info saved successfully!</p>";
				} else {
					// Failure, Loan Request Info was not saved
					$error_message  .= "<p class='label label-danger'>Failure, Loan Request Info was not saved.</p>";
				}
			} else {
				// Failure, Previous Loan Request has not yet been decided on.
				$error_message  .= "<p class='label label-danger'>Failure, Previous Loan Request has not yet been decided on.</p>";
			}
		}
		if ($this->input->post("withdrawal_but")) {

			$user_id 			= $this->Users->getUserID();
			$withdraw_amount 	= protect($this->input->post("withdraw_amount"));
			$withdraw_limit 	= protect($this->input->post("withdraw_limit"));
			$bank_account 		= protect($this->input->post("bank_account"));
			$bank_name 			= protect($this->input->post("bank_name"));
			$account_name 		= protect($this->input->post("account_name"));
			$account_number 	= protect($this->input->post("account_number"));

			if($withdraw_amount < 100){
				$data["withdrawal_form_error"]  .= "<p class='label label-danger label-lg'>Failure, Withdrawal Amount is less than N100</p>";
			}else{

			if($withdraw_limit > 500){
				if($withdraw_amount > $withdraw_limit){
					// Failure, Withdrawal limit is 
	$data["withdrawal_form_error"]  .= "<p class='label label-danger'>Failure, Withdrawal limit is ₦";
	$data["withdrawal_form_error"]  .= "" . number_format( ($withdraw_limit - 500), 2)."</p>";
				}else{
					// Proceed
					$check_pending = $this->Finance->getPendingWithdrawalRequest($user_id);
					if ($check_pending === false) {

						$save_res = $this->Finance->createNewWithdrawalRequest($user_id, $withdraw_amount, $bank_account, $bank_name, $account_name, $account_number);
						if ($save_res !== false) {
	// Withdrawal Request Info saved successfully
	$data["withdrawal_form_error"]  .= "<p class='label label-success label-lg'>Withdrawal Request Info saved successfully!</p>";
						} else {
	// Failure, Loan Request Info was not saved
	$data["withdrawal_form_error"]  .= "<p class='label label-danger'>Failure, Withdrawal Request Info was not saved.</p>";
						}
					} else {
	// Failure, Previous Loan Request has not yet been decided on.
	$data["withdrawal_form_error"]  .= "<p class='label label-danger'>Failure, Previous Withdrawal Request has not yet been decided on.</p>";
					}
				}
			}else{
				// Error
	$data["withdrawal_form_error"]  .= "<p class='label label-danger'>Failure, Withdrawal limit is ₦0 </p>";
			}

			}
	
		}
		
		$data["request_loan_form_error"] = $error_message;

		$this->load->view("profile_finance_home", $data);
	}

	public function finance_section_loans($param = "")
	{
		$data["request_loan_form_error"] = "";
		$data["withdrawal_form_error"] = "";
		$data["page_title"] = "Fecundhill | Loans";
		$data["nav_tag"] = "finance";
		$error_message = "";

		if ($this->input->post("request_loan_but")) {
			
			$user_id 			= $this->Users->getUserID();
			$loan_amount 		= protect($this->input->post("loan_amount"));
			$loan_duration 		= protect($this->input->post("loan_duration"));
		//	$children 			= protect($this->input->post("children"));
			$children 			= "";
		//	$bank_account 		= protect($this->input->post("bank_account"));
			$bank_account		= "";
			$cheque_book 		= protect($this->input->post("cheque_book"));
			$bank_name 			= protect($this->input->post("bank_name"));
			$account_name 		= protect($this->input->post("account_name"));
			$account_number 	= protect($this->input->post("account_number"));
			$current_income 	= protect($this->input->post("current_income"));
			$other_loan 		= protect($this->input->post("other_loan"));

			$deposit_frequency 	= protect($this->input->post("deposit_frequency"));
			$payment_amount 	= protect($this->input->post("payment_amount"));
			$specific_day 		= protect($this->input->post("specific_day"));
		//	$purpose 			= protect($this->input->post("purpose"));
			$purpose			= "";
			$collateral 		= protect($this->input->post("collateral"));
			$code 				= protect($this->input->post("referral_code"));
			$employment 		= protect($this->input->post("employment"));
			$asset_location		= protect($this->input->post("asset_location"));

			$check_pending = $this->Finance->getPendingLoanRequest($user_id);
			if ($check_pending === false) {

				$save_res = $this->Finance->createNewLoanRequest($user_id, $loan_amount, $loan_duration, $children, $bank_account, $cheque_book, $bank_name, $account_name, $account_number, $current_income, $other_loan, $deposit_frequency, $payment_amount, $specific_day, $purpose, $collateral, $code, $employment, $asset_location);
				if ($save_res !== false) {
					// Loan Request Info saved successfully
					$error_message  .= "<p class='label label-success label-lg'>Loan Request Info saved successfully!</p>";

					if($code != ""){
						$this->Referrals->saveReferral($user_id, $code, "loans");
					}

				} else {
					// Failure, Loan Request Info was not saved
					$error_message  .= "<p class='label label-danger'>Failure, Loan Request Info was not saved.</p>";
				}
			} else {
				// Failure, Previous Loan Request has not yet been decided on.
				$error_message  .= "<p class='label label-danger'>Failure, Previous Loan Request has not yet been decided on.</p>";
			}
		}
		
		$data["request_loan_form_error"] = $error_message;

		$this->load->view("profile_finance_loans", $data);
	}

	public function finance_section_fecundvest($param = "")
	{
		$data["request_loan_form_error"] = "";
		$data["withdrawal_form_error"] = "";
		$data["fecundvest_details_form_error"] = "";
		$data["page_title"] = "Fecundhill | Fecundvest";
		$data["nav_tag"] = "finance";
		$error_message = "";

		
		if ($this->input->post("withdrawal_but")) {

			$user_id 			= $this->Users->getUserID();
			$withdraw_amount 	= protect($this->input->post("withdraw_amount"));
			$withdraw_limit 	= protect($this->input->post("withdraw_limit"));
			$bank_account 		= protect($this->input->post("bank_account"));
			$bank_name 			= protect($this->input->post("bank_name"));
			$account_name 		= protect($this->input->post("account_name"));
			$account_number 	= protect($this->input->post("account_number"));

			if($withdraw_amount < 100){
				$data["withdrawal_form_error"]  .= "<p class='label label-danger label-lg'>Failure, Withdrawal Amount is less than N100</p>";
			}else{

			if($withdraw_limit > 500){
				if($withdraw_amount > $withdraw_limit){
					// Failure, Withdrawal limit is 
	$data["withdrawal_form_error"]  .= "<p class='label label-danger'>Failure, Withdrawal limit is ₦";
	$data["withdrawal_form_error"]  .= "" . number_format( ($withdraw_limit - 500), 2)."</p>";
				}else{
					// Proceed
					$check_pending = $this->Finance->getPendingWithdrawalRequest($user_id);
					if ($check_pending === false) {

						$save_res = $this->Finance->createNewWithdrawalRequest($user_id, $withdraw_amount, $bank_account, $bank_name, $account_name, $account_number);
						if ($save_res !== false) {
	// Withdrawal Request Info saved successfully
	$data["withdrawal_form_error"]  .= "<p class='label label-success label-lg'>Withdrawal Request Info saved successfully!</p>";
						} else {
	// Failure, Loan Request Info was not saved
	$data["withdrawal_form_error"]  .= "<p class='label label-danger'>Failure, Withdrawal Request Info was not saved.</p>";
						}
					} else {
	// Failure, Previous Loan Request has not yet been decided on.
	$data["withdrawal_form_error"]  .= "<p class='label label-danger'>Failure, Previous Withdrawal Request has not yet been decided on.</p>";
					}
				}
			}else{
				// Error
	$data["withdrawal_form_error"]  .= "<p class='label label-danger'>Failure, Withdrawal limit is ₦0 </p>";
			}

			}
	
		}

		if ($this->input->post("sub_fecundvest_update")) {

			$fecundvest_id 	= protect($this->input->post("fecundvest_id"));
			$purpose 		= protect($this->input->post("fecundvest_purpose"));
			$target 		= protect($this->input->post("target"));
			$duration 		= protect($this->input->post("duration"));
			$frequency 		= protect($this->input->post("deposit_frequency"));
			$deposit_amount = protect($this->input->post("deposit_amount"));
			$specific_day 	= protect($this->input->post("specific_day"));
			$start_date 	= protect($this->input->post("start_date"));
			$end_date 		= protect($this->input->post("end_date"));
			$bank_name 		= protect($this->input->post("bank_name"));
			$account_number	= protect($this->input->post("account_number"));
			$referral_code 	= protect($this->input->post("referral_code"));

			if($start_date != ""){
				$start_date = date("Y-m-d H:i:s", strtotime($start_date) );
			}
			if($end_date != ""){
				$end_date = date("Y-m-d H:i:s", strtotime($end_date) );
			}

			if($purpose != ""){
				$update_query = array(
					"purpose" => $purpose,
					"target" => $target,
					"duration" => $duration,
					"frequency" => $frequency,
					"deposit_amount" => $deposit_amount,
					"specific_day" => $specific_day,
					"start_date" => $start_date,
					"end_date" => $end_date,
					"bank_name" => $bank_name,
					"account_number" => $account_number,
					"referral_code" => $referral_code,
				); 

				$save_res = $this->Finance->updateFecundVest($fecundvest_id, $update_query);
				if ($save_res !== false) {
	// Successful
	$data["fecundvest_details_form_error"]  .= "<p class='label label-success label-lg'>Info updated successfully!</p>";
				} else {
	// Failure
	$data["fecundvest_details_form_error"]  .= "<p class='label label-danger'>Failure, Purpose info was not updated.</p>";
				}
			}else{
				$data["fecundvest_details_form_error"]  .= "<p class='label label-danger'>Failure, Purpose field is empty.</p>";
			}
						
	
		}

		$this->load->view("profile_finance_fecundvest", $data);
	}

	public function finance_section_hire_purchase($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Hire Purchase";
		$error_message = "";
		
		$data["form_error"] .= $error_message;
		$data["form_category"] = $param;
		$this->load->view("profile_finance_hire_purchase", $data);
	}

	public function finance_section_hire_purchase_form($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Hire Purchase";
		$error_message = "";

		if ($this->input->post("special_request_submit")) {

			$data["direct_message_error"] = "";

			$this->form_validation->set_rules('msg_subject', 'Message Title', 'required');
			$this->form_validation->set_rules('msg_body', 'Message', 'required');
			$this->form_validation->set_rules('msg_category', 'Category', 'required');
			$this->form_validation->set_rules('msg_location', 'Location', 'required');
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$data["direct_message_error"] .= validation_errors();
			} else {

				$sender_id 		= $this->Users->getUserID();
				$recipient_id 	= "";
				$category 		= protect($this->input->post("msg_category"));
				$sub_categories	= ($this->input->post("sub_cat"));
				$title 			= protect($this->input->post("msg_subject"));
				$message 		= protect($this->input->post("msg_body"));
				$location 		= protect($this->input->post("msg_location"));
				$destination 	= protect($this->input->post("msg_destination"));

				$sub_categories_str = implode(", ", $sub_categories);


				// Save Message Information
				// type 1. To Admin 2. From Admin
				// status 0. unread 1. read
				$res = $this->Personal->saveSpecialMessage(7, $sender_id, $category, $sub_categories_str, $title, $message, $location, $destination, $recipient_id);
				if ($res[0] === true) {

					$data['direct_message_error'] = "<p class='label label-success'>Service Request sent Successfully!</p>";

					$message_id = $res[1];

					// Check if Files were uploaded as attachments
					if (isset($_FILES)) {
						if (count($_FILES) > 0) {
							if ($_FILES['file_upload']["name"] != "") {

								$config['upload_path'] = 'uploads/dmfiles';
								$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
								$config['max_size']	= '2010';

								$uploaded_files_arr = $_FILES['file_upload'];
								$count = count($uploaded_files_arr['name']);

								for ($i = 0; $i < $count; $i++) {

									if (!empty($uploaded_files_arr['name'][$i])) {

										$file_ext_arr = explode(".", $uploaded_files_arr['name'][$i]);
										$file_ext = end($file_ext_arr);

										$new_filename = $file_ext_arr[0] . "_" . $message_id . $i . "." . $file_ext;

										//	$_FILES['file']['name'] = $uploaded_files_arr['name'][$i];
										$_FILES['file']['name'] = $new_filename;
										$_FILES['file']['type'] = $uploaded_files_arr['type'][$i];
										$_FILES['file']['tmp_name'] = $uploaded_files_arr['tmp_name'][$i];
										$_FILES['file']['error'] = $uploaded_files_arr['error'][$i];
										$_FILES['file']['size'] = $uploaded_files_arr['size'][$i];

										//		$config['file_name'] = $uploaded_files_arr['name'][$i];

										$this->load->library('upload', $config);

										if ($this->upload->do_upload('file')) {
											$uploadData = $this->upload->data();
											$filename = $uploadData['file_name'];

											$data['totalFiles'][] = $filename;

											// Successful, Save Info To Database
											$res2 = $this->Personal->saveDirectMessageAttachment($message_id, $i, $filename, $file_ext);
										} else {
											// Upload Failed
											$data['direct_message_error'] = $data['direct_message_error'] . "<p class='label label-danger'>Upload Failed! " . $this->upload->display_errors() . "</p>";
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$data["form_error"] .= $error_message;
		$data["form_category"] = $param;
		$this->load->view("profile_finance_hire_purchase_form", $data);
	}

	public function finance_section_hire_purchase_new_listing($param = "")
	{
		
		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Hire Purchase";
		$error_message = "";

		if ($this->input->post("new_listing_submit")) {

			$data["new_listing_error"] = "";

			$this->form_validation->set_rules('listing_category', 'Category', 'required');
			$this->form_validation->set_rules('listing_title', 'Service/Product Title', 'required');
			$this->form_validation->set_rules('listing_details', 'Details', 'required');
			$this->form_validation->set_rules('listing_location', 'Location State', 'required');
			$this->form_validation->set_rules('listing_phone', 'Contact Phone', 'required');
			
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$data["new_listing_error"] .= validation_errors();
			} else {

				$user_id 	= $this->Users->getUserID();
				$code		= protect($this->input->post("referral_code"));

				$query = array(
					"user_id" 			=> $user_id,
					"partner_id" 		=> $this->Partner->getPartnerID($user_id),
					"category" 			=> protect($this->input->post("listing_category")),
					"title" 			=> protect($this->input->post("listing_title")),
					"details" 			=> protect($this->input->post("listing_details")),
					"price" 			=> protect($this->input->post("listing_price")),
					"extra" 			=> protect($this->input->post("listing_extra")),
					"negotiable" 		=> protect($this->input->post("listing_negotiable")),
					"country" 			=> protect($this->input->post("listing_country")),
					"state" 			=> protect($this->input->post("listing_location")),
					"location_details" 	=> protect($this->input->post("listing_location_details")),
					"phone" 			=> protect($this->input->post("listing_phone")),
					"publish_status" 	=> 0,
					"record_status" 	=> 1,
					"time_created"		=> date("Y-m-d H:i:s"),
					"time_updated"		=> date("Y-m-d H:i:s")
				);
				
				$res = $this->Listing->createListing($query);
				if ($res[0] === true) {
					
					$data['new_listing_error'] = "<p class='label label-success'>Listing Added Successfully!</p>";

					if($code != ""){
						$this->Referrals->saveReferral($user_id, $code, "hire purchase");
					}

					$listing_id = $res[1];

					// Check if Files were uploaded as attachments
					if (isset($_FILES)) {
						if (count($_FILES) > 0) {
							if ($_FILES['file_upload']["name"] != "") {

								

								$config['upload_path'] = 'uploads/listings';
								$config['allowed_types'] = 'jpg|jpeg|png';
								$config['max_size']	= '2010';

								$uploaded_files_arr = $_FILES['file_upload'];
								$count = count($uploaded_files_arr['name']);

								for ($i = 0; $i < $count; $i++) {

									if (!empty($uploaded_files_arr['name'][$i])) {

										$file_ext_arr = explode(".", $uploaded_files_arr['name'][$i]);
										$file_ext = end($file_ext_arr);

										$new_filename = $file_ext_arr[0] . "_" . $listing_id . $i . "." . $file_ext;

										//	$_FILES['file']['name'] = $uploaded_files_arr['name'][$i];
										$_FILES['file']['name'] = $new_filename;
										$_FILES['file']['type'] = $uploaded_files_arr['type'][$i];
										$_FILES['file']['tmp_name'] = $uploaded_files_arr['tmp_name'][$i];
										$_FILES['file']['error'] = $uploaded_files_arr['error'][$i];
										$_FILES['file']['size'] = $uploaded_files_arr['size'][$i];

										//		$config['file_name'] = $uploaded_files_arr['name'][$i];

										$this->load->library('upload', $config);

										if ($this->upload->do_upload('file')) {
											$uploadData = $this->upload->data();
											$filename = $uploadData['file_name'];

											$data['totalFiles'][] = $filename;

											// Successful, Save Info To Database
											$res2 = $this->Listing->saveListingPhotos($listing_id, $i, $filename, $file_ext);
										} else {
											// Upload Failed
											$data['new_listing_error'] = $data['new_listing_error'] . "<p class='label label-danger'>Upload Failed! " . $this->upload->display_errors() . "</p>";
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$data["form_error"] .= $error_message;
		$data["form_category"] = $param;
		$this->load->view("profile_finance_hire_purchase_new_listing", $data);
	}

	public function real_estate_home($param = "")
	{
		$data["request_partner_form_error"] = "";
		$data["page_title"] = "Fecundhill | Dashboard - Real Estate";
		$data["nav_tag"] = "real_estate";
		$error_message = "";

		if ($this->input->post("request_partner_but")) {

			$user_id 	= $this->Users->getUserID();

			$query = array(
				"user_id" 			=> $user_id,
				"business_name" 	=> protect($this->input->post("business_name")),
				"owner_name" 		=> protect($this->input->post("owner_name")),
				"email" 			=> protect($this->input->post("email")),
				"phone" 			=> protect($this->input->post("phone")),
				"address" 			=> protect($this->input->post("address")),
				"country" 			=> protect($this->input->post("country")),
				"state" 			=> protect($this->input->post("state")),
				"city" 				=> protect($this->input->post("city")),
				"description" 		=> protect($this->input->post("description")),
				"category" 			=> protect($this->input->post("category")),
				"industry" 			=> protect($this->input->post("industry")),
				"identification" 	=> protect($this->input->post("identification")),
				"certification" 	=> protect($this->input->post("certification")),
				"lockup_shop" 		=> protect($this->input->post("lockup_shop")),
				"bank_account_type" => protect($this->input->post("bank_account_type")),
				"cheque_book" 		=> protect($this->input->post("cheque_book")),
				"lock_status"		=> 0,
				"enabled"			=> 0,
				"status"			=> 1,
				"time_created"		=> date("Y-m-d H:i:s"),
				"time_updated"		=> date("Y-m-d H:i:s")
			);

			$save_res = $this->Partner->createPartnerAccount($user_id, $query);
			if ($save_res !== false) {
				// Partner Request Info saved successfully
				$data["request_partner_form_error"]  .= "<p class='label label-success label-lg'>Partner Request Info saved successfully!</p>";
			} else {
				// Failure, Partner Request Info was not saved
				$data["request_partner_form_error"] .= "<p class='label label-danger'>Failure, Partner Request Info was not saved.</p>";
			}
		}

		$this->load->view("profile_real_estate_home", $data);
	}

	public function transport_home($param = "")
	{
		$data["request_partner_form_error"] = "";
		$data["page_title"] = "Fecundhill | Dashboard - Transport";
		$data["nav_tag"] = "transport";
		$error_message = "";

		if ($this->input->post("request_partner_but")) {

			$user_id 	= $this->Users->getUserID();

			$query = array(
				"user_id" 			=> $user_id,
				"business_name" 	=> protect($this->input->post("business_name")),
				"owner_name" 		=> protect($this->input->post("owner_name")),
				"email" 			=> protect($this->input->post("email")),
				"phone" 			=> protect($this->input->post("phone")),
				"address" 			=> protect($this->input->post("address")),
				"country" 			=> protect($this->input->post("country")),
				"state" 			=> protect($this->input->post("state")),
				"city" 				=> protect($this->input->post("city")),
				"description" 		=> protect($this->input->post("description")),
				"category" 			=> protect($this->input->post("category")),
				"industry" 			=> protect($this->input->post("industry")),
				"identification" 	=> protect($this->input->post("identification")),
				"certification" 	=> protect($this->input->post("certification")),
				"lockup_shop" 		=> protect($this->input->post("lockup_shop")),
				"bank_account_type" => protect($this->input->post("bank_account_type")),
				"cheque_book" 		=> protect($this->input->post("cheque_book")),
				"lock_status"		=> 0,
				"enabled"			=> 0,
				"status"			=> 1,
				"time_created"		=> date("Y-m-d H:i:s"),
				"time_updated"		=> date("Y-m-d H:i:s")
			);

			$save_res = $this->Partner->createPartnerAccount($user_id, $query);
			if ($save_res !== false) {
				// Partner Request Info saved successfully
				$data["request_partner_form_error"]  .= "<p class='label label-success label-lg'>Partner Request Info saved successfully!</p>";
			} else {
				// Failure, Partner Request Info was not saved
				$data["request_partner_form_error"] .= "<p class='label label-danger'>Failure, Partner Request Info was not saved.</p>";
			}
		}

		$this->load->view("profile_transport_home", $data);
	}

	public function view()
	{
		$data["page_title"] = "Fecundhill | View Profile";
		$this->load->view("profile_view", $data);
	}

	public function edit()
	{

		$data = array();

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Edit Profile";
		$error_message = "";

		if ($this->input->post('edit_profile_but')) {

			$this->form_validation->set_rules('surname', 'Surname', 'required');
			$this->form_validation->set_rules('firstname', 'First Name', 'required');

			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message = "<div class='label-danger' style='color:#FFF;'>" . validation_errors() . "</div>";
			} else {
				
				/* 
					id, user_id, surname, firstname, othername, title, mother_maiden, nationality, residency_no, dual_citizenship, dual_citizen_country, religion, 
					state_origin, lga_origin, phone, gender, place_of_birth, date_of_birth, identification, identification_no, identification_issue, 
					identification_expiry, identification_file_id, tax_identification_no, social_security_no, employment_status, employer_name, 
					employment_date, employer_address, employer_landmark, employer_city, employer_state, employer_lga, employer_business, employer_phone, 
					employee_id_no, marital_status, email, residential_address, residential_street, residential_landmark, residential_city, residential_state, 
					residential_lga, mailing_address, phone2, permanent_address, nok_surname, nok_firstname, nok_othernames, nok_birthdate, nok_title, nok_relationship, 
					nok_gender, nok_phone, nok_phone2, nok_address, nok_street, nok_city, nok_state, nok_lga, nok_landmark, nok_email, passport_photo_id, admin_id, 
					lock_status, time_created, time_updated, employer_rank

				*/
				
				$user_id = $this->Users->getUserID();

				$update_query = array(
					"surname" 					=> ( protect($this->input->post("surname"))),
					"firstname" 				=> ( protect($this->input->post("firstname"))),
					"othername" 				=> ( protect($this->input->post("othername"))),
					"title" 					=> protect($this->input->post("title")),
					"mother_maiden" 			=> protect($this->input->post("mother_maiden")),
					"nationality" 				=> protect($this->input->post("nationality")),
					"residency_no" 				=> protect($this->input->post("residency_no")),
					"dual_citizenship" 			=> protect($this->input->post("dual_citizenship")),
					"dual_citizen_country" 		=> protect($this->input->post("dual_citizen_country")),
					"religion" 					=> protect($this->input->post("religion")),
					"state_origin" 				=> protect($this->input->post("state_origin")),
					"lga_origin" 				=> protect($this->input->post("lga_origin")),
					"phone" 					=> protect($this->input->post("phone")),
					"gender" 					=> protect($this->input->post("gender")),
					"place_of_birth" 			=> protect($this->input->post("place_of_birth")),
					"date_of_birth" 			=> protect($this->input->post("date_of_birth")),
					"children" 					=> protect($this->input->post("children")),
					"identification" 			=> protect($this->input->post("identification")),
					"identification_no" 		=> protect($this->input->post("identification_no")),
					"identification_issue" 		=> protect($this->input->post("identification_issue")),
					"identification_expiry" 	=> protect($this->input->post("identification_expiry")),
			//		"identification_file_id" 	=> protect($this->input->post("identification_file_id")),
					"tax_identification_no" 	=> protect($this->input->post("tax_identification_no")),
					"social_security_no" 		=> protect($this->input->post("social_security_no")),
					"employment_status" 		=> protect($this->input->post("employment_status")),
					"employer_name" 			=> protect($this->input->post("employer_name")),
					"employment_date" 			=> protect($this->input->post("employment_date")),
					"employer_address" 			=> protect($this->input->post("employer_address")),
					"employer_landmark" 		=> protect($this->input->post("employer_landmark")),
					"employer_city" 			=> protect($this->input->post("employer_city")),
					"employer_state" 			=> protect($this->input->post("employer_state")),
					"employer_lga" 				=> protect($this->input->post("employer_lga")),
					"employer_business" 		=> protect($this->input->post("employer_business")),
					"employer_phone" 			=> protect($this->input->post("employer_phone")),
					"employee_id_no" 			=> protect($this->input->post("employee_id_no")),
					"marital_status" 			=> protect($this->input->post("marital_status")),
					"email" 					=> protect($this->input->post("email")),
					"residential_address" 		=> protect($this->input->post("residential_address")),
					"residential_street" 		=> protect($this->input->post("residential_street")),
					"residential_landmark" 		=> protect($this->input->post("residential_landmark")),
					"residential_city" 			=> protect($this->input->post("residential_city")),
					"residential_lga" 			=> protect($this->input->post("residential_lga")),
					"mailing_address" 			=> protect($this->input->post("mailing_address")),
					"phone2" 					=> protect($this->input->post("phone2")),
					"permanent_address" 		=> protect($this->input->post("permanent_address")),
					"nok_surname" 				=> protect($this->input->post("nok_surname")),
					"nok_firstname" 			=> protect($this->input->post("nok_firstname")),
					"nok_othernames" 			=> protect($this->input->post("nok_othernames")),
					"nok_birthdate" 			=> protect($this->input->post("nok_birthdate")),
					"nok_title" 				=> protect($this->input->post("nok_title")),
					"nok_relationship" 			=> protect($this->input->post("nok_relationship")),
					"nok_gender" 				=> protect($this->input->post("nok_gender")),
					"nok_phone" 				=> protect($this->input->post("nok_phone")),
					"nok_phone2" 				=> protect($this->input->post("nok_phone2")),
					"nok_address" 				=> protect($this->input->post("nok_address")),
					"nok_street" 				=> protect($this->input->post("nok_street")),
					"nok_city" 					=> protect($this->input->post("nok_city")),
					"nok_state" 				=> protect($this->input->post("nok_state")),
					"nok_lga" 					=> protect($this->input->post("nok_lga")),
					"nok_landmark" 				=> protect($this->input->post("nok_landmark")),
					"nok_email" 				=> protect($this->input->post("nok_email")),
			//		"passport_photo_id" 		=> protect($this->input->post("passport_photo_id")),
					"time_updated" 				=> date("Y-m-d H:i:s"),
					"blood_group" 				=> protect($this->input->post("blood_group")),
					"employer_rank" 			=> protect($this->input->post("employer_rank")),
				);
				
				$save_res = $this->Personal->updatePersonalInfo($user_id, $update_query);
				if ($save_res === true) {
					// Profile Info saved successfully
					$error_message  .= "<p class='label label-success label-lg'>Profile Info saved successfully!</p>";
				} else {
					// Failure, Profile Info was not saved
					$error_message  .= "<p class='label label-danger'>Failure, Profile Info was not saved</p>";
				}
			}
		}

		$data["form_error"] = $error_message;
		$this->load->view('profile_edit', $data);
	}

	public function verify_email()
	{
		$this->load->view("auth/verify_notice");
	}
	public function suspended()
	{
		$this->load->view("auth/suspended");
	}

	public function new_savings()
	{
		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | New Savings Account";
		$error_message = "";

		if($this->input->post("open_savings_account")){
			
			$user_id = $this->Users->getUserID();
			$type = 1; // Savings Account

			$save_res = $this->Finance->createNewAccount($user_id, $type);
			if ($save_res !== false) {
				// Profile Info saved successfully
				$error_message  .= "<p class='label label-success label-lg'>New Savings Account Created Successfully!</p>";

				header("Location: " . base_url() . "profile/dashboard");
				die();
			}else{
				// Failure, Profile Info was not saved
				$error_message  .= "<p class='label label-danger'>Failure, Savings Account was NOT Created.</p>";
			}
		}
		
		$data["form_error"] = $error_message;
		$this->load->view('finance/new_savings', $data);
	}

	public function new_fixed()
	{
		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | New Fecundvest Account";
		$error_message = "";
		
		if ($this->input->post("open_fixed_account")) {

			$user_id = $this->Users->getUserID();
			$type = 2; // Fecundvest Account

			$save_res = $this->Finance->createNewAccount($user_id, $type);
			if ($save_res !== false) {
				// Profile Info saved successfully
				$error_message  .= "<p class='label label-success label-lg'>New Fecundvest Account Created Successfully!</p>";

				header("Location: " . base_url() . "profile/finance_section_fecundvest");
				die();
			} else {
				// Failure, Profile Info was not saved
				$error_message  .= "<p class='label label-danger'>Failure, Fecundvest Account was NOT Created.</p>";
			}
		}

		$data["form_error"] = $error_message;
		$this->load->view('finance/new_fixed', $data);
	}


	public function new_message($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | New Direct Message to Admin";
		$error_message = "";

		if ($this->input->post("direct_message_submit")) {

			$data["direct_message_error"] = "";

			$this->form_validation->set_rules('msg_subject', 'Message Title', 'required');
			$this->form_validation->set_rules('msg_body', 'Message', 'required');
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$data["direct_message_error"] .= validation_errors();
			} else {

				$sender_id 		= $this->Users->getUserID();
				$recipient_id 	= "";
				$title 			= protect($this->input->post("msg_subject"));
				$message 		= protect($this->input->post("msg_body"));

				// Save Message Information
				// type 1. To Admin 2. From Admin
				// status 0. unread 1. read
				$res = $this->Personal->saveDirectMessage(1, $sender_id, $title, $message, $recipient_id);
				if ($res[0] === true) {

					$data['direct_message_error'] = "<p class='label label-success'>Direct Message sent Successfully!</p>";

					$message_id = $res[1];

					// Check if Files were uploaded as attachments
					if (isset($_FILES)) {
						if (count($_FILES) > 0) {
							if ($_FILES['file_upload']["name"] != "") {

								$config['upload_path'] = 'uploads/dmfiles';
								$config['allowed_types'] = 'jpg|jpeg|png|gif|svg|pdf|doc|docx';
								$config['max_size']	= '2010';

								$uploaded_files_arr = $_FILES['file_upload'];
								$count = count($uploaded_files_arr['name']);

								for ($i = 0; $i < $count; $i++) {

									if (!empty($uploaded_files_arr['name'][$i])) {

										$file_ext_arr = explode(".", $uploaded_files_arr['name'][$i]);
										$file_ext = end($file_ext_arr);

										$new_filename = $file_ext_arr[0] . "_" . $message_id . $i . "." . $file_ext;

										//	$_FILES['file']['name'] = $uploaded_files_arr['name'][$i];
										$_FILES['file']['name'] = $new_filename;
										$_FILES['file']['type'] = $uploaded_files_arr['type'][$i];
										$_FILES['file']['tmp_name'] = $uploaded_files_arr['tmp_name'][$i];
										$_FILES['file']['error'] = $uploaded_files_arr['error'][$i];
										$_FILES['file']['size'] = $uploaded_files_arr['size'][$i];

										//		$config['file_name'] = $uploaded_files_arr['name'][$i];

										$this->load->library('upload', $config);

										if ($this->upload->do_upload('file')) {
											$uploadData = $this->upload->data();
											$filename = $uploadData['file_name'];

											$data['totalFiles'][] = $filename;

											// Successful, Save Info To Database
											$res2 = $this->Personal->saveDirectMessageAttachment($message_id, $i, $filename, $file_ext);
										} else {
											// Upload Failed
											$data['direct_message_error'] = $data['direct_message_error'] . "<p class='label label-danger'>Upload Failed! " . $this->upload->display_errors() . "</p>";
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$data["form_error"] .= $error_message;
		$this->load->view("profile_message_new", $data);
	}

	public function new_special_message($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | New Special Request to FecundHill";
		$error_message = "";

		if ($this->input->post("special_request_submit")) {

			$data["direct_message_error"] = "";

			$this->form_validation->set_rules('msg_subject', 'Message Title', 'required');
			$this->form_validation->set_rules('msg_body', 'Message', 'required');
			$this->form_validation->set_rules('msg_category', 'Category', 'required');
			$this->form_validation->set_rules('msg_location', 'Location', 'required');
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$data["direct_message_error"] .= validation_errors();
			} else {

				$sender_id 		= $this->Users->getUserID();
				$recipient_id 	= "";
				$category 		= protect($this->input->post("msg_category"));
				$sub_categories	= ($this->input->post("sub_cat"));
				$title 			= protect($this->input->post("msg_subject"));
				$message 		= protect($this->input->post("msg_body"));
				$location 		= protect($this->input->post("msg_location"));
				$destination 	= protect($this->input->post("msg_destination"));
				$code			= protect($this->input->post("referral_code"));

				$sub_categories_str = implode(", ", $sub_categories);


				// Save Message Information
				// type 1. To Admin 2. From Admin
				// status 0. unread 1. read
				$res = $this->Personal->saveSpecialMessage(7, $sender_id, $category, $sub_categories_str, $title, $message, $location, $destination, $recipient_id);
				if ($res[0] === true) {

					$data['direct_message_error'] = "<p class='label label-success'>Service Request sent Successfully!</p>";

					if($code != ""){
						$this->Referrals->saveReferral($sender_id, $code, "real estate");
					}

					$message_id = $res[1];

					// Check if Files were uploaded as attachments
					if (isset($_FILES)) {
						if (count($_FILES) > 0) {
							if ($_FILES['file_upload']["name"] != "") {

								$config['upload_path'] = 'uploads/dmfiles';
								$config['allowed_types'] = 'jpg|jpeg|png|gif|svg|pdf|doc|docx';
								$config['max_size']	= '2010';

								$uploaded_files_arr = $_FILES['file_upload'];
								$count = count($uploaded_files_arr['name']);

								for ($i = 0; $i < $count; $i++) {

									if (!empty($uploaded_files_arr['name'][$i])) {

										$file_ext_arr = explode(".", $uploaded_files_arr['name'][$i]);
										$file_ext = end($file_ext_arr);

										$new_filename = $file_ext_arr[0] . "_" . $message_id . $i . "." . $file_ext;

										//	$_FILES['file']['name'] = $uploaded_files_arr['name'][$i];
										$_FILES['file']['name'] = $new_filename;
										$_FILES['file']['type'] = $uploaded_files_arr['type'][$i];
										$_FILES['file']['tmp_name'] = $uploaded_files_arr['tmp_name'][$i];
										$_FILES['file']['error'] = $uploaded_files_arr['error'][$i];
										$_FILES['file']['size'] = $uploaded_files_arr['size'][$i];

										//		$config['file_name'] = $uploaded_files_arr['name'][$i];

										$this->load->library('upload', $config);

										if ($this->upload->do_upload('file')) {
											$uploadData = $this->upload->data();
											$filename = $uploadData['file_name'];

											$data['totalFiles'][] = $filename;

											// Successful, Save Info To Database
											$res2 = $this->Personal->saveDirectMessageAttachment($message_id, $i, $filename, $file_ext);
										} else {
											// Upload Failed
											$data['direct_message_error'] = $data['direct_message_error'] . "<p class='label label-danger'>Upload Failed! " . $this->upload->display_errors() . "</p>";
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$data["form_error"] .= $error_message;
		$data["form_category"] = $param;
		$this->load->view("profile_special_request_new", $data);
	}

	public function messages($param = "")
	{
		$data["page_title"] = "Fecundhill | Messages and Notifications";
		$data = array("message_status" => $param);

		$this->load->view("profile_messages", $data);
	}

	public function message_view($message_id)
	{
		$data["page_title"] = "Fecundhill | View Message";
		$data = array("message_id" => $message_id);

		$this->load->view("profile_message_view", $data);
	}

	public function new_listing($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Create a New Listing";
		$error_message = "";

		if ($this->input->post("new_listing_submit")) {

			$data["new_listing_error"] = "";

			$this->form_validation->set_rules('listing_category', 'Category', 'required');
			$this->form_validation->set_rules('listing_title', 'Service/Product Title', 'required');
			$this->form_validation->set_rules('listing_details', 'Details', 'required');
			$this->form_validation->set_rules('listing_location', 'Location State', 'required');
			$this->form_validation->set_rules('listing_phone', 'Contact Phone', 'required');
			
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$data["new_listing_error"] .= validation_errors();
			} else {

				$user_id 	= $this->Users->getUserID();

				$query = array(
					"user_id" 			=> $user_id,
					"partner_id" 		=> $this->Partner->getPartnerID($user_id),
					"category" 			=> protect($this->input->post("listing_category")),
					"title" 			=> protect($this->input->post("listing_title")),
					"details" 			=> protect($this->input->post("listing_details")),
					"price" 			=> protect($this->input->post("listing_price")),
					"negotiable" 		=> protect($this->input->post("listing_negotiable")),
					"country" 			=> protect($this->input->post("listing_country")),
					"state" 			=> protect($this->input->post("listing_location")),
					"location_details" 	=> protect($this->input->post("listing_location_details")),
					"phone" 			=> protect($this->input->post("listing_phone")),
					"publish_status" 	=> 0,
					"record_status" 	=> 1,
					"time_created"		=> date("Y-m-d H:i:s"),
					"time_updated"		=> date("Y-m-d H:i:s")
				);
				
				$res = $this->Listing->createListing($query);
				if ($res[0] === true) {
					
					$data['new_listing_error'] = "<p class='label label-success'>Listing Added Successfully!</p>";

					$listing_id = $res[1];

					// Check if Files were uploaded as attachments
					if (isset($_FILES)) {
						if (count($_FILES) > 0) {
							if ($_FILES['file_upload']["name"] != "") {

								

								$config['upload_path'] = 'uploads/listings';
								$config['allowed_types'] = 'jpg|jpeg|png';
								$config['max_size']	= '2010';

								$uploaded_files_arr = $_FILES['file_upload'];
								$count = count($uploaded_files_arr['name']);

								for ($i = 0; $i < $count; $i++) {

									if (!empty($uploaded_files_arr['name'][$i])) {

										$file_ext_arr = explode(".", $uploaded_files_arr['name'][$i]);
										$file_ext = end($file_ext_arr);

										$new_filename = $file_ext_arr[0] . "_" . $listing_id . $i . "." . $file_ext;

										//	$_FILES['file']['name'] = $uploaded_files_arr['name'][$i];
										$_FILES['file']['name'] = $new_filename;
										$_FILES['file']['type'] = $uploaded_files_arr['type'][$i];
										$_FILES['file']['tmp_name'] = $uploaded_files_arr['tmp_name'][$i];
										$_FILES['file']['error'] = $uploaded_files_arr['error'][$i];
										$_FILES['file']['size'] = $uploaded_files_arr['size'][$i];

										//		$config['file_name'] = $uploaded_files_arr['name'][$i];

										$this->load->library('upload', $config);

										if ($this->upload->do_upload('file')) {
											$uploadData = $this->upload->data();
											$filename = $uploadData['file_name'];

											$data['totalFiles'][] = $filename;

											// Successful, Save Info To Database
											$res2 = $this->Listing->saveListingPhotos($listing_id, $i, $filename, $file_ext);
										} else {
											// Upload Failed
											$data['new_listing_error'] = $data['new_listing_error'] . "<p class='label label-danger'>Upload Failed! " . $this->upload->display_errors() . "</p>";
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$data["form_error"] .= $error_message;
		$this->load->view("profile_listing_new", $data);
	}


	public function listings($param = "")
	{
		$data["page_title"] = "Fecundhill | My Listings";
		$data = array("message_status" => $param);

		$this->load->view("profile_listings", $data);
	}

	public function listing_view($listing_id)
	{
		$data["page_title"] = "Fecundhill | View Listing";
		$data = array("listing_id" => $listing_id);

		$this->load->view("profile_listing_view", $data);
	}

	public function vehicles($param = "")
	{
		$data["page_title"] = "Fecundhill | My Vehicles";
		$data = array("message_status" => $param);

		$this->load->view("profile_vehicles", $data);
	}

	public function requests($param = "")
	{
		$data["page_title"] = "Fecundhill | My Requests";
		$data = array("message_status" => $param);

		$this->load->view("profile_requests", $data);
	}

	public function service_requests($param = "")
	{
		$data["page_title"] = "Fecundhill | My Service Requests";
		$data = array("message_status" => $param);

		$this->load->view("profile_service_requests", $data);
	}

	public function service_request_view($message_id)
	{
		$data["page_title"] = "Fecundhill | View Message";
		$data = array("message_id" => $message_id);

		$this->load->view("profile_service_request_view", $data);
	}

	public function published_listings($param = "")
	{
		$data["page_title"] = "Fecundhill | Published Listings";
		$data = array("category" => $param);

		$this->load->view("published_listings", $data);
	}

	public function listing_view2($listing_id)
	{
		$data["page_title"] = "Fecundhill | View Listing";
		$data["request_service_form_error"] = "";
		

		if ($this->input->post("service_request_but")) {

			$user_id 	= $this->Users->getUserID();

			$query = array(
				"user_id" 			=> $user_id,
				"listing_id" 		=> protect($this->input->post("listing_id")),
				"approval"			=> 0,
				"status"			=> 1,
				"time_updated"		=> date("Y-m-d H:i:s")
			);

			$check = $this->Listing->getListingRequest($listing_id, $user_id, 1);
			if($check === false){
				$save_res = $this->Listing->createListingRequest($query);
				if ($save_res !== false) {
					// Partner Request Info saved successfully
					$data["request_service_form_error"]  .= "<p class='label label-success label-lg'>Request Info saved successfully!</p>";
				} else {
					// Failure, Partner Request Info was not saved
					$data["request_service_form_error"] .= "<p class='label label-danger'>Failure, Request Info was not saved.</p>";
				}
			}else{
				// Ignore. Service Request Already Exists
			}
		}

		$data["listing_id"] = $listing_id;
		$this->load->view("published_listing_view", $data);
	}

	public function transactions($param = "")
	{
		$data["page_title"] = "Fecundhill | My Transactions";
		$data = array("category" => $param);

		$this->load->view("profile_transactions", $data);
	}

	public function transactions_all($param = "")
	{
		$data["page_title"] = "Fecundhill | All Transactions";
		$data = array("category" => $param);
		
		$this->load->view("profile_transactions_all", $data);
	}

	public function loans($param = "")
	{
		$data["page_title"] = "Fecundhill | My Loans";
		$data = array("message_status" => $param);

		$this->load->view("profile_loans", $data);
	}

	public function transport_driver_form($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Driver Signup Form";
		$error_message = "";

		if ($this->input->post("driver_form_submit")) {

			$this->form_validation->set_rules('driver_town', 'Category', 'required');
			$this->form_validation->set_rules('driver_years', 'Service/Product Title', 'required');
			
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message .= validation_errors();
			} else {

				$user_id 	= $this->Users->getUserID();

				$query = array(
					"user_id" 			=> $user_id,
					"driver_town" 		=> protect($this->input->post("driver_town")),
					"driver_years" 		=> protect($this->input->post("driver_years")),
					"extra" 			=> "",
					"record_status" 	=> 1,
					"time_created"		=> date("Y-m-d H:i:s"),
					"time_updated"		=> date("Y-m-d H:i:s")
				);

				$upload_check = false;
				$upload_ref_id = NULL;

// PREVENT MULTIPLE SUBMISSION
if($this->Listing->getDriverSignupByUser($user_id) === false){
				
				$res = $this->Listing->createDriverSignup($query);
				if ($res[0] === true) {

//	$error_message = "<p class='label label-success'>Listing Added Successfully!</p>";
	$upload_ref_id 	= $res[1];
	$record_id 		= $res[1];
/*	
	$passport_upload_result = $this->fileUploaderSingle($record_id, "file_passport", 'uploads/driver', "jpg|jpeg|png|pdf");
	if($passport_upload_result[0] === true){

		$p_u_r = $passport_upload_result;
		$files_res1 = $this->Listing->saveDriverSignupFiles($p_u_r[1], $p_u_r[2], $p_u_r[3], $p_u_r[4]);

		$utility_upload_result 	= $this->fileUploaderSingle($record_id, "file_utility", 'uploads/driver', "jpg|jpeg|png|pdf");
		if($utility_upload_result[0] === true){
			
			$u_u_r = $utility_upload_result;
			$files_res2 = $this->Listing->saveDriverSignupFiles($u_u_r[1], $u_u_r[2], $u_u_r[3], $u_u_r[4]);

			$nid_upload_result 		= $this->fileUploaderSingle($record_id, "file_nid", 'uploads/driver', "jpg|jpeg|png|pdf");
			if($nid_upload_result[0] === true){

				$n_u_r = $nid_upload_result;
				$files_res3 = $this->Listing->saveDriverSignupFiles($n_u_r[1], $n_u_r[2], $n_u_r[3], $n_u_r[4]);
*/
				$dlicense_upload_result = $this->fileUploaderSingle($record_id, "file_dlicense", 'uploads/driver', "jpg|jpeg|png|pdf");
				if($dlicense_upload_result[0] === true){
					
					$d_u_r = $dlicense_upload_result;
					$files_res4 = $this->Listing->saveDriverSignupFiles($d_u_r[1], $d_u_r[2], $d_u_r[3], $d_u_r[4]);

					$upload_check = true;

					$error_message .= "<p class='label label-success'>Form submitted successfully!</p>";
				}else{ $error_message .= "<span class='text-danger large-warning'><b>".$dlicense_upload_result[1]."</b></span>"; }
/*			}else{ $error_message .= "<span class='text-danger large-warning'><b>".$nid_upload_result[1]."</b></span>"; }
		}else{ $error_message .= "<span class='text-danger large-warning'><b>".$utility_upload_result[1]."</b></span>"; }
	}else{ $error_message .= "<span class='text-danger large-warning'><b>".$passport_upload_result[1]."</b></span>"; }
*/	
				}
// PREVENT MULTIPLE SUBMISSION
}else{
	$error_message .= "<p class='label label-warning'>You have already submitted this form!</p>";
}

				// Check upload and roll back changes where necessary
				if($upload_check === false){
					// Delete record from database
					$this->Listing->removeDriverSignup($upload_ref_id);
					// Unlink uploaded files
					$this->Listing->removeDriverSignupFiles($upload_ref_id, 'uploads/driver');

				}

			}
		}

		

		$data["form_error"] .= $error_message;
		$this->load->view("profile_transport_driver_form", $data);
	}

	public function transport_vehicle_form($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Vehicle Signup Form";
		$error_message = "";

		if ($this->input->post("vehicle_form_submit")) {

			$this->form_validation->set_rules('vehicle_town', 'Category', 'required');
			$this->form_validation->set_rules('vehicle_brand', 'Vehicle Brand', 'required');
			$this->form_validation->set_rules('vehicle_model', 'Vehicle Model', 'required');
			$this->form_validation->set_rules('vehicle_model_year', 'Model Year', 'required');
			$this->form_validation->set_rules('vehicle_color', 'Vehicle Color', 'required');
			$this->form_validation->set_rules('vehicle_passengers', 'Passenger Capacity', 'required');
			$this->form_validation->set_rules('vehicle_plate', 'Vehicle License Plate Number', 'required');
			
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message .= validation_errors();
			} else {

				$user_id 	= $this->Users->getUserID();

				$query = array(
					"user_id" 			=> $user_id,
					"vehicle_town" 		=> protect($this->input->post("vehicle_town")),
					"vehicle_brand" 	=> protect($this->input->post("vehicle_brand")),
					"vehicle_model" 	=> protect($this->input->post("vehicle_model")),
					"vehicle_model_year" 	=> protect($this->input->post("vehicle_model_year")),
					"vehicle_color" 		=> protect($this->input->post("vehicle_color")),
					"vehicle_passengers" 	=> protect($this->input->post("vehicle_passengers")),
					"vehicle_plate" 	=> protect($this->input->post("vehicle_plate")),
					"extra" 			=> "",
					"record_status" 	=> 1,
					"time_created"		=> date("Y-m-d H:i:s"),
					"time_updated"		=> date("Y-m-d H:i:s")
				);

				$upload_check = false;
				$upload_ref_id = NULL;

// PREVENT MULTIPLE SUBMISSION
//if($this->Listing->getVehicleSignupByUser($user_id) === false){
				
				$res = $this->Listing->createVehicleSignup($query);
				if ($res[0] === true) {

//	$error_message = "<p class='label label-success'>Listing Added Successfully!</p>";
	$upload_ref_id 	= $res[1];
	$record_id 		= $res[1];
	
	$vehicle_plate_result = $this->fileUploaderSingle($record_id, "file_vehicle_plate", 'uploads/vehicle', "jpg|jpeg|png|pdf");
	if($vehicle_plate_result[0] === true){

		$v_p_r = $vehicle_plate_result;
		$files_res1 = $this->Listing->saveVehicleSignupFiles($v_p_r[1], $v_p_r[2], $v_p_r[3], $v_p_r[4]);

		$vehicle_papers1_result 	= $this->fileUploaderSingle($record_id, "file_vehicle_papers1", 'uploads/vehicle', "jpg|jpeg|png|pdf");
		if($vehicle_papers1_result[0] === true){
			
			$u_u_r = $vehicle_papers1_result;
			$files_res2 = $this->Listing->saveVehicleSignupFiles($u_u_r[1], $u_u_r[2], $u_u_r[3], $u_u_r[4]);

			$vehicle_papers2_result 		= $this->fileUploaderSingle($record_id, "file_vehicle_papers2", 'uploads/vehicle', "jpg|jpeg|png|pdf");
			if($vehicle_papers2_result[0] === true){

				$d_u_r = $vehicle_papers2_result;
				$files_res4 = $this->Listing->saveVehicleSignupFiles($d_u_r[1], $d_u_r[2], $d_u_r[3], $d_u_r[4]);

				$upload_check = true;

			//	$error_message .= "<p class='label label-success'>Form submitted successfully!</p>";
			}else{ $error_message .= "<span class='text-danger large-warning'><b>".$vehicle_papers2_result[1]."</b></span>"; }
		}else{ $error_message .= "<span class='text-danger large-warning'><b>".$vehicle_papers1_result[1]."</b></span>"; }
	}else{ $error_message .= "<span class='text-danger large-warning'><b>".$vehicle_plate_result[1]."</b></span>"; }
	


//	$error_message = "<p class='label label-success'>Listing Added Successfully!</p>";
	$upload_ref_id 	= $res[1];
	$record_id 		= $res[1];
/*	
	$passport_upload_result = $this->fileUploaderSingle($record_id, "file_passport", 'uploads/vehicle', "jpg|jpeg|png|pdf");
	if($passport_upload_result[0] === true){

		$p_u_r = $passport_upload_result;
		$files_res1 = $this->Listing->saveVehicleSignupFiles($p_u_r[1], $p_u_r[2], $p_u_r[3], $p_u_r[4]);

		$utility_upload_result 	= $this->fileUploaderSingle($record_id, "file_utility", 'uploads/vehicle', "jpg|jpeg|png|pdf");
		if($utility_upload_result[0] === true){
			
			$u_u_r = $utility_upload_result;
			$files_res2 = $this->Listing->saveVehicleSignupFiles($u_u_r[1], $u_u_r[2], $u_u_r[3], $u_u_r[4]);

			$nid_upload_result 		= $this->fileUploaderSingle($record_id, "file_nid", 'uploads/vehicle', "jpg|jpeg|png|pdf");
			if($nid_upload_result[0] === true){

				$n_u_r = $nid_upload_result;
				$files_res3 = $this->Listing->saveVehicleSignupFiles($n_u_r[1], $n_u_r[2], $n_u_r[3], $n_u_r[4]);
*/

				$dlicense_upload_result = $this->fileUploaderSingle($record_id, "file_dlicense", 'uploads/vehicle', "jpg|jpeg|png|pdf");
				if($dlicense_upload_result[0] === true){
					
					$d_u_r = $dlicense_upload_result;
					$files_res4 = $this->Listing->saveVehicleSignupFiles($d_u_r[1], $d_u_r[2], $d_u_r[3], $d_u_r[4]);

					$upload_check = true;

					$error_message .= "<p class='label label-success'>Form submitted successfully!</p>";
				}else{ $error_message .= "<span class='text-danger large-warning'><b>".$dlicense_upload_result[1]."</b></span>"; }
/*			}else{ $error_message .= "<span class='text-danger large-warning'><b>".$nid_upload_result[1]."</b></span>"; }
		}else{ $error_message .= "<span class='text-danger large-warning'><b>".$utility_upload_result[1]."</b></span>"; }
	}else{ $error_message .= "<span class='text-danger large-warning'><b>".$passport_upload_result[1]."</b></span>"; }
*/


				}
// PREVENT MULTIPLE SUBMISSION
//}else{
//	$error_message .= "<p class='label label-warning'>You have already submitted this form!</p>";
//}

				// Check upload and roll back changes where necessary
				if($upload_check === false){
					// Delete record from database
					$this->Listing->removeVehicleSignup($upload_ref_id);
					// Unlink uploaded files
					$this->Listing->removeVehicleSignupFiles($upload_ref_id, 'uploads/vehicle');
				}
			}
		}

		$data["form_error"] .= $error_message;
		$this->load->view("profile_transport_vehicle_form", $data);
	}

	
	public function transport_booking($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Booking Form";
		$error_message = "";

		if ($this->input->post("booking_form_submit")) {

			$this->form_validation->set_rules('type', 'Flight/Ride', 'required');
			$this->form_validation->set_rules('departure', 'Point of Departure', 'required');
			$this->form_validation->set_rules('destination', 'Destination', 'required');
			$this->form_validation->set_rules('trip_type', 'Trip Type', 'required');
			$this->form_validation->set_rules('passengers', 'No of Passengers', 'required');
			$this->form_validation->set_rules('departure_time', 'Preferred Date/time of departure', 'required');
	//		$this->form_validation->set_rules('luggage', 'Luggage description', 'required');
			
			
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message .= validation_errors();
			} else {

				$user_id 	= $this->Users->getUserID();
				$type 		= protect($this->input->post("type"));
				$code		= protect($this->input->post("referral_code"));

				$return_time = protect($this->input->post("return_time"));
				if($return_time != ""){
					$return_time = date("Y-m-d H:i:s", strtotime(protect($this->input->post("return_time"))) );
				}

				$query = array(
					"user_id" 			=> $user_id,
					"type" 				=> $type,
					"departure" 		=> protect($this->input->post("departure")),
					"destination" 		=> protect($this->input->post("destination")),
					"trip_type" 		=> protect($this->input->post("trip_type")),
		//			"duration" 			=> protect($this->input->post("duration")),
					"passengers" 		=> protect($this->input->post("passengers")),
					"departure_time" 	=> date("Y-m-d H:i:s", strtotime(protect($this->input->post("departure_time"))) ),
					"return_time" 		=> $return_time,
					"luggage" 			=> protect($this->input->post("luggage")),
					"extra" 			=> "",
					"record_status" 	=> 1,
					"time_created"		=> date("Y-m-d H:i:s"),
					"time_updated"		=> date("Y-m-d H:i:s")
				);

				$upload_check = false;
				$upload_ref_id = NULL;

				// PREVENT MULTIPLE SUBMISSION
				if($this->Listing->checkBookingByUser($user_id, $query["type"], $query["departure"], $query["departure_time"]) === false){
					
					$res = $this->Listing->createBooking($query);
					if ($res[0] === true) {

						$error_message .= "<p class='label label-success'>Form submitted successfully!</p>";

						if($code != ""){
							$this->Referrals->saveReferral($user_id, $code, $type." booking");
						}
		
					}else{
						$error_message .= "<p class='label label-danger'>An error occured while submitting this form! Contact admin</p>";
					}
				// PREVENT MULTIPLE SUBMISSION
				}else{
					$error_message .= "<p class='label label-warning'>You have already submitted this form!</p>";
				}
			}
		}

		$data["form_error"] .= $error_message;
		$data["param"] = $param;
		$this->load->view("profile_transport_booking", $data);
	}

	public function express_delivery($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Express Delivery";
		$error_message = "";

		if ($this->input->post("express_form_submit")) {

			$this->form_validation->set_rules('parcel_description', 'Parcel Description', 'required');
			$this->form_validation->set_rules('pickup_location', 'Pickup Location', 'required');
			$this->form_validation->set_rules('pickup_datetime', 'Pickup Date / Time ', 'required');
			$this->form_validation->set_rules('delivery_location', 'Delivery Location', 'required');
			
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message .= validation_errors();
			} else {

				$user_id 			= $this->Users->getUserID();
				$description 		= protect($this->input->post("parcel_description"));
				$pickup_location	= protect($this->input->post("pickup_location"));
				$delivery_location	= protect($this->input->post("delivery_location"));
				$pickup_datetime 	= protect($this->input->post("pickup_datetime"));
				
				if($pickup_datetime != ""){
					$pickup_datetime = date("Y-m-d H:i:s", strtotime($pickup_datetime) );
				}

				$query = array(
					"user_id" 			=> $user_id,
					"description" 		=> $description,
					"pickup_location" 	=> $pickup_location,
					"delivery_location" => $delivery_location,
					"pickup_datetime" 	=> $pickup_datetime,
					"time_added"		=> date("Y-m-d H:i:s"),
					"time_updated"		=> date("Y-m-d H:i:s")
				);

				// PREVENT MULTIPLE SUBMISSION
				if($this->ExpressDelivery->checkDuplicate($user_id, $query["description"], $query["pickup_location"], $query["delivery_location"], $query["pickup_datetime"]) === false){
					
					$res = $this->ExpressDelivery->create($query);
					if ($res[0] === true) {

						$error_message .= "<p class='label label-success'>Successful!</p>";

					}else{
						$error_message .= "<p class='label label-danger'>An error occured! Contact admin</p>";
					}
				// PREVENT MULTIPLE SUBMISSION
				}else{
					$error_message .= "<p class='label label-warning'>Duplicate information. You have already submitted this request!</p>";
				}
			}
		}

		$data["express_form_error"] = $error_message;
		$data["param"] = $param;
		$this->load->view("profile_transport_express_delivery", $data);
	}

	public function fileUploaderSingle($unique_identifier, $field_name, $upload_path = 'uploads/listings', $allowed_types = "jpg|jpeg|png|pdf", $max_size = '2010'){
		// Check if Files were uploaded as attachments

		if (isset($_FILES)) {
			if (count($_FILES) > 0) {
				if ($_FILES["$field_name"]["name"] != "") {
					
			//		print_r($field_name);

					$config['upload_path'] = $upload_path;
					$config['allowed_types'] = $allowed_types;
					$config['max_size']	= $max_size;

					$uploaded_files_arr = $_FILES["$field_name"];

					$count = count($uploaded_files_arr['name']);

					for ($i = 0; $i < $count; $i++) {

						if (!empty($uploaded_files_arr['name'][$i])) {

							$file_ext_arr = explode(".", $uploaded_files_arr['name'][$i]);
							$file_ext = end($file_ext_arr);

				//			$new_filename = $file_ext_arr[0] . "_" . $unique_identifier . $i . "." . $file_ext;
							$new_filename = $field_name . "_" . $unique_identifier . $i . "." . $file_ext;

							//	$_FILES['file']['name'] = $uploaded_files_arr['name'][$i];
							$_FILES['file']['name'] = $new_filename;
							$_FILES['file']['type'] = $uploaded_files_arr['type'][$i];
							$_FILES['file']['tmp_name'] = $uploaded_files_arr['tmp_name'][$i];
							$_FILES['file']['error'] = $uploaded_files_arr['error'][$i];
							$_FILES['file']['size'] = $uploaded_files_arr['size'][$i];

							//		$config['file_name'] = $uploaded_files_arr['name'][$i];

							$this->load->library('upload', $config);

							if ($this->upload->do_upload('file')) {
					//			print_r($file_ext_arr[0]);
								$uploadData = $this->upload->data();
								$filename = $uploadData['file_name'];

								$data['totalFiles'][] = $filename;

								return array(true, $unique_identifier, $i, $filename, $file_ext);
								// Successful, Save Info To Database
							} else {
								// Upload Failed
								return array(false, $this->upload->display_errors());
			//					$error_message = $error_message . "<p class='label label-danger'>Upload Failed! " . $this->upload->display_errors() . "</p>";
							}
						}
					}
				}
			}
		}
	}

}
