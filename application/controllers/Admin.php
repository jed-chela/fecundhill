<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->dashboard();
	}

	public function dashboard($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Admin Dashboard";
		$error_message = "";

		if ($this->input->post("new_account_confirm")) {

			$admin_id = $this->Users->getUserID();
			$account_id = protect($this->input->post("account_id"));

			$save_res = $this->Finance->confirmNewAccount($account_id, $admin_id);
			if ($save_res !== false) {
				// New Account Confirmed successfully
				$error_message .= "<p class='label label-success label-lg'>New Account Confirmed successfully!</p>";
				
			} else {
				// Failure, New Account was NOT Confirmed
				$error_message .= "<p class='label label-danger'> Failure, New Account was NOT Confirmed.</p>";
			}
		}else if($this->input->post("loan_reject")){
			$loan_request_id = protect($this->input->post("request_id"));
			
			// Update Loan Request Record Status
			$update_query = array(
				"status" => 2
			);

			$res = $this->Finance->updateLoanRequestRecord($loan_request_id, $update_query);
			if($res === true){
				// Update Successfull
				$error_message .= "<p class='label label-success'>The Loan Request has been REJECTED!</p>";
			}else{
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}

		}else if($this->input->post("loan_accept")){
			$loan_request_id = protect($this->input->post("request_id"));
			$admin_id = $this->Users->getUserID();

			$loan_request = $this->Finance->getLoanRequestRecord($loan_request_id);
			if($loan_request !== false){
				// Update Loan Request Record Status
				$update_query = array(
					"status" => 1
				);

				// Check for Active Loan Record to prevent duplicate
				$check = $this->Finance->getActiveLoanRecordByRequest($loan_request_id);
				if($check === false){
						
					$res1 = $this->Finance->updateLoanRequestRecord($loan_request_id, $update_query);
					if($res1 === true){
						// Update Successfull
						$error_message .= "<p class='label label-success'>The Loan Request has been Accepted!</p> ";

						// Create Active Loan Record
						$res2 = $this->Finance->createNewActiveLoan($loan_request_id, $loan_request['user_id'], $loan_request['amount'], $loan_request['duration'], $admin_id);

						// Create Loan Disbursement Transaction
						$loan_disburse_transaction_type = 13;
						$ref_number = $res2; //loan id
						$loan_res = $this->Finance->createNewTransaction("", $ref_number, $loan_disburse_transaction_type, $loan_request['user_id'], $loan_request['amount'], $admin_id);


					}else{
						$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p> ";
					}
				}else{
					$error_message .= "<p class='label label-danger'>A Loan Record for this loan request already exists!</p> ";
				}
			}else{
				$error_message .= "<p class='label label-danger'>Loan Request NOT Found!</p> ";
			}

		}else if($this->input->post("loan_complete")){
			$loan_id = protect($this->input->post("loan_id"));
			$admin_id = $this->Users->getUserID();

			// Update Active Loan Record Status
			$update_query = array(
				"remarks" => $admin_id,
				"active_status" => 2 // Repayment Complete
			);

			$res = $this->Finance->updateActiveLoanRecord($loan_id, $update_query);
			if($res === true){
				// Update Successfull
				$error_message .= "<p class='label label-success'>The Loan has been marked as Fully Repaid!</p> ";
			}else{
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p> ";
			}
		} else if ($this->input->post("partner_accept")) {
			$partner_id = protect($this->input->post("partner_id"));

			// Update Partner Account Record Status
			$update_query = array(
				// Rejected Account Request
				"enabled" => 1,
				"status" => 1
			);

			$res = $this->Partner->updateBusinessInfoByPartnerID($partner_id, $update_query);
			if ($res === true) {
				// Update Successfull
				$error_message .= "<p class='label label-success'>The Partner Account Request has been ACCEPTED!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}
		} else if ($this->input->post("partner_reject")) {
			$partner_id = protect($this->input->post("partner_id"));

			// Update Partner Account Record Status
			$update_query = array(
				// Rejected Account Request
				"enabled" => 2,
				"status" => 1
			);

			$res = $this->Partner->updateBusinessInfoByPartnerID($partner_id, $update_query);
			if ($res === true) {
				// Update Successfull
				$error_message .= "<p class='label label-success'>The Partner Account Request has been REJECTED!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}
		} else if ($this->input->post("withdrawal_reject")) {
			$withdrawal_request_id = protect($this->input->post("request_id"));

			// Update Withdrawal Request Record Status
			$update_query = array(
				"approval" => 2
			);

			$res = $this->Finance->updateWithdrawalRequestRecord($withdrawal_request_id, $update_query);
			if ($res === true) {
				// Update Successfull
				$error_message .= "<p class='label label-success'>The Withdrawal Request has been REJECTED!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}
		} else if ($this->input->post("withdrawal_accept")) {
			$withdrawal_request_id = protect($this->input->post("request_id"));
			$admin_id = $this->Users->getUserID();

			$withdrawal_request = $this->Finance->getWithdrawalRequestRecord($withdrawal_request_id);
			if ($withdrawal_request !== false) {
				// Update Withdrawal Request Record Status
				$update_query = array(
					"approval" => 1
				);

				// Check for Transaction Record to prevent duplicate
				// Transaction Types: 1. Fecundvest, 2. Savings, 5. Withdrawal
				$check = $this->Finance->getTransactionRecordByRefNumber($withdrawal_request_id, 5);
				if ($check === false) {

					$res1 = $this->Finance->updateWithdrawalRequestRecord($withdrawal_request_id, $update_query);
					if ($res1 === true) {
						// Update Successfull
						$error_message .= "<p class='label label-success'>The Withdrawal Request has been Accepted!</p> ";

						$account_no = $this->Finance->getFixedDepositAccountNumber($withdrawal_request['user_id']);

						// Create Transaction Record
						$res2 = $this->Finance->createNewTransaction($account_no, $withdrawal_request_id, 5, $withdrawal_request['user_id'], $withdrawal_request['amount'], $admin_id);
					} else {
						$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p> ";
					}
				} else {
					$error_message .= "<p class='label label-danger'>A Transaction for this withdrawal request already exists!</p> ";
				}
			} else {
				$error_message .= "<p class='label label-danger'>Withdrawal Request NOT Found!</p> ";
			}
		}
		

		$data["form_error"] .= $error_message;
		$this->load->view("admin/dashboard", $data);
	}


	public function new_message($param = "")
	{

		$data["form_error"] = "";
		$data["page_title"] = "Fecundhill | Admin - New Direct Message";
		$error_message = "";
	
		if ($this->input->post("direct_message_submit")) {

			$data["direct_message_error"] = "";

			$this->form_validation->set_rules('member_id', 'Select Recipient', 'required');
			$this->form_validation->set_rules('msg_subject', 'Message Title', 'required');
			$this->form_validation->set_rules('msg_body', 'Message', 'required');
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$data["direct_message_error"] .= validation_errors();
			} else {

				$sender_id 		= $this->Users->getUserID();
				$recipient_id 	= protect($this->input->post("member_id"));
				$title 			= protect($this->input->post("msg_subject"));
				$message 		= protect($this->input->post("msg_body"));

				// Save Message Information
				// type 1. To Admin 2. From Admin
				// status 0. unread 1. read
				$res = $this->Personal->saveDirectMessage(2, $sender_id, $title, $message, $recipient_id);
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

										$new_filename = $file_ext_arr[0]."_".$message_id.$i.".".$file_ext;

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
		$this->load->view("admin/message_new", $data);
	}

	public function messages($param = "")
	{
		$data = array("message_status" => $param);
		$data["page_title"] = "Fecundhill | Admin - View Message";
		
		$this->load->view("admin/messages", $data);
	}

	public function message_view($message_id)
	{
		$data = array("message_id" => $message_id);
		$data["page_title"] = "Fecundhill | Admin - View Message";

		$this->load->view("admin/message_view", $data);
	}

	public function service_requests($param = "")
	{
		$data = array("message_status" => $param);
		$data["page_title"] = "Fecundhill | Admin - Service Requests";

		$this->load->view("admin/service_requests", $data);
	}

	public function service_request_view($message_id)
	{
		$data = array("message_id" => $message_id);
		$data["page_title"] = "Fecundhill | Admin - View Service Request";

		$this->load->view("admin/service_request_view", $data);
	}
	
	public function view_profile($id)
	{
		$data = array("profile_id" => $id);
		$data["page_title"] = "Fecundhill | Admin - View Profile";

		$this->load->view("admin/profile_view", $data);
	}

	public function view_loan_requests_history($id = "")
	{
		$data = array("the_user_id" => $id);
		$data["page_title"] = "Fecundhill | Admin - Loan Requests History";

		if($id == ""){
			$this->load->view("admin/loan_requests_history_all", $data);
		}else{
			$this->load->view("admin/loan_requests_history", $data);
		}		
	}

	public function view_loans_history($id = "")
	{
		$data = array("the_user_id" => $id);
		$data["page_title"] = "Fecundhill | Admin - Loans History";

		if($id == ""){
			$this->load->view("admin/loans_history_all", $data);
		}	
	}

	public function withdrawal_requests_history($id = "")
	{
		$data = array("the_user_id" => $id);
		$data["page_title"] = "Fecundhill | Admin - Withdrawal Requests History";
		
		if($id == ""){
			$this->load->view("admin/withdrawal_requests_history_all", $data);
		}	
	}

	public function view_loan_history($id = "")
	{
		$data = array("the_user_id" => $id);
		$data["page_title"] = "Fecundhill | Admin - Loan History";

		$this->load->view("admin/loan_history", $data);
	}

	public function edit_loan_request($request_id = ""){
		$data = array("request_id" => $request_id);
		$data["page_title"] = "Fecundhill | Admin - Edit Loan Request";

		if ($this->input->post("update_loan_request_but")) {

			$data["request_loan_form_error"] = "";

			$this->form_validation->set_rules('loan_request_id', 'Request ID', 'required');
			$this->form_validation->set_rules('loan_amount', 'Loan Amount', 'required');
			$this->form_validation->set_rules('loan_duration', 'Loan Duration', 'required');
	/*		$this->form_validation->set_rules('bank_account', 'Bank Account', 'required');
			$this->form_validation->set_rules('cheque_book', 'Cheque Book', 'required');
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('account_name', 'Account Name', 'required');
			$this->form_validation->set_rules('current_income', 'Current Income', 'required');
			$this->form_validation->set_rules('other_loan', 'Other Loan', 'required');	*/

			

			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$data["request_loan_form_error"] .= validation_errors();
			} else {

				$loan_request_id 	= protect($this->input->post("loan_request_id"));
				$amount 			= protect($this->input->post("loan_amount"));
				$duration 			= protect($this->input->post("loan_duration"));
	/*			$bank_account 		= protect($this->input->post("bank_account"));
				$cheque_book 		= protect($this->input->post("cheque_book"));
				$bank_name 			= protect($this->input->post("bank_name"));
				$account_name 		= protect($this->input->post("account_name"));
				$current_income 	= protect($this->input->post("current_income"));
				$other_loan 		= protect($this->input->post("other_loan"));
				$collateral 		= protect($this->input->post("collateral"));
				$employment 		= protect($this->input->post("employment"));
				$asset_location 	= protect($this->input->post("asset_location"));
				*/

				$termination_date 	= protect($this->input->post("termination_date"));
				$moratorium 		= protect($this->input->post("moratorium"));

				$update_query = array(
					"amount" 			=> $amount,
					"duration" 			=> $duration,
	/*				"bank_account" 		=> $bank_account,
					"cheque_book" 		=> $cheque_book,
					"bank_name" 		=> $bank_name,
					"account_name" 		=> $account_name,
					"current_income" 	=> $current_income,
					"other_loan" 		=> $other_loan,	
					"collateral"		=> $collateral,
					"employment"		=> $employment,
					"asset_location"	=> $asset_location,
					*/
					"termination_date" 	=> $termination_date,
					"moratorium" 		=> $moratorium,
				);
				$res = $this->Finance->updateLoanRequestRecord($loan_request_id, $update_query);
				if ($res !== false) {
					// Successful!
					$data['request_loan_form_error'] = "<p class='label label-success'>Loan Request Update was Successful!</p>";
				}else{
					// Failure!
					$data['request_loan_form_error'] = "<p class='label label-danger'>Loan Request Update Failed!</p>";
				}
			}
		}

		$this->load->view("admin/loan_request_edit", $data);
	}

	public function contact_info($id)
	{
		$data = array("profile_id" => $id);
		$data["page_title"] = "Fecundhill | Admin - View Contact Information";

		$this->load->view("admin/partner_contact_view", $data);
	}

	public function user_management($params1 ="", $params2 ="")
	{
		$data = array();

		if ( ($params1 == "lock_profile") & ($params2 != "") ){

			$the_user_id = $params2;
			
			$admin_id 		= $this->Users->getUserID();

			$res = $this->Personal->toggleProfileLock(1, $the_user_id, $admin_id);
			if($res){
				header("Location: " . base_url() . "admin/user_management");
			}
			
		}
		if (($params1 == "unlock_profile") & ($params2 != "")) {

			$the_user_id = $params2;

			$admin_id 		= $this->Users->getUserID();

			$res = $this->Personal->toggleProfileLock(0, $the_user_id, $admin_id);
			if ($res) {
				header("Location: " . base_url() . "admin/user_management");
			}
		}
		if (($params1 == "enable_subadmin") & ($params2 != "")) {

			$the_user_id = $params2;

			$admin_id 		= $this->Users->getUserID();

			$this->Users->removeSubAdminAccess($the_user_id);
			$res = $this->Users->addSubAdminAccess($the_user_id, $admin_id, 1);
			if ($res) {
				header("Location: " . base_url() . "admin/user_management");
			}
		}
		if (($params1 == "disable_subadmin") & ($params2 != "")) {

			$the_user_id = $params2;

			$admin_id 		= $this->Users->getUserID();

			
			$res = $this->Users->removeSubAdminAccess($the_user_id);
			if ($res) {
				header("Location: " . base_url() . "admin/user_management");
			}
		}
		if (($params1 == "enable_mainadmin") & ($params2 != "")) {

			$the_user_id = $params2;

			$admin_id 		= $this->Users->getUserID();

			$this->Users->removeSubAdminAccess($the_user_id);
			$res = $this->Users->addSubAdminAccess($the_user_id, $admin_id, 10);
			if ($res) {
				header("Location: " . base_url() . "admin/user_management");
			}
		}
		
		

		$this->load->view("admin/user_management", $data);
	}

	
	public function transaction_management($req_type = "", $params1 = "", $params2 = "")
	{
		$data = array();
		$error_message = "";
		$data['req_type'] = "";

		if($req_type == "tr_add"){
			$data['req_type'] = "transaction_add";
			$data['the_user_id'] = $params1;
			$data['the_account_type'] = $params2;

		}else if($req_type == "tr_history"){
			$data['req_type'] = "transaction_history";
			$data['the_user_id'] = $params1;
			$data['the_account_type'] = $params2;

		}

		if ($this->input->post("new_transaction_but")) {

			$admin_id 			= $this->Users->getUserID();
			$user_id 			= protect($this->input->post("the_user_id"));
			$transaction_type 	= protect($this->input->post("the_transaction_type"));
			$amount 			= protect($this->input->post("the_amount"));

			$account_no = $this->Finance->getFixedDepositAccountNumber($user_id);

			$save_res = $this->Finance->createNewTransaction($account_no, "", $transaction_type, $user_id, $amount, $admin_id);
			if ($save_res !== false) {
				// Transaction saved successfully
				$error_message .= "<p class='label label-success label-lg'>Transaction saved successfully!</p>";
			} else {
				// Failure, Transaction was NOT saved
				$error_message .= "<p class='label label-danger'> Failure, Transaction was NOT saved.</p>";
			}
			$data['add_transaction_error'] = $error_message;
		}

		$this->load->view("admin/transaction_management", $data);
	}

	public function view_partner($id)
	{
		$data = array("partner_id" => $id);
		$data["page_title"] = "Fecundhill | Admin - View Partner";

		$this->load->view("admin/partner_view", $data);
	}

	public function listings($param = "")
	{
		$data = array("listing_status" => $param);
		$data["page_title"] = "Fecundhill | Admin - View Listings";

		$error_message = "";

		if($this->input->post("listing_pub_but")){

			$listing_id = protect($this->input->post("listing_id"));
			$publish_status = 1; // Accepted
			$admin_id = $this->Users->getUserID();

			$res = $this->Listing->updateListingPublishStatus($listing_id, $publish_status, $admin_id);
			if ($res === true) {

				$error_message .= "<p class='label label-success'>The Listing has been PUBLISHED!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}

		} else if ($this->input->post("listing_rej_but")) {
			
			$listing_id = protect($this->input->post("listing_id"));
			$publish_status = 2; // Rejected

			$admin_id = $this->Users->getUserID();

			$res = $this->Listing->updateListingPublishStatus($listing_id, $publish_status, $admin_id);
			if ($res === true) {

				$error_message .= "<p class='label label-success'>The Listing has been REJECTED!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}
		}

		$this->load->view("admin/listings", $data);
	}

	public function booking($param = "")
	{
		$data = array("booking_type" => firstLetterToCaps($param));
		$data["page_title"] = "Fecundhill | Admin - View ".firstLetterToCaps($param)." Booking";

		$error_message = "";

		if($this->input->post("booking_approve_but")){
			
			$booking_id = protect($this->input->post("booking_id"));
			$approval = 1; // Accepted
			$admin_id = $this->Users->getUserID();

			$res = $this->Listing->updateBookingApprovalStatus($booking_id, $approval, $admin_id);
			if ($res === true) {

				$error_message .= "<p class='label label-success'>The booking_id has been APPROVED!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}

		} else if ($this->input->post("booking_reject_but")) {
			
			$booking_id = protect($this->input->post("booking_id"));
			$approval = 2; // Rejected

			$admin_id = $this->Users->getUserID();

			$res = $this->Listing->updateBookingApprovalStatus($booking_id, $approval, $admin_id);
			if ($res === true) {

				$error_message .= "<p class='label label-success'>The Booking has been REJECTED!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}
		} else if ($this->input->post("booking_complete_but")) {
			
			$booking_id = protect($this->input->post("booking_id"));
			$approval = 3; // Completed

			$admin_id = $this->Users->getUserID();

			$res = $this->Listing->updateBookingApprovalStatus($booking_id, $approval, $admin_id);
			if ($res === true) {

				$error_message .= "<p class='label label-success'>The Booking has been REJECTED!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}
		}

		$this->load->view("admin/bookings", $data);
	}
	public function express_delivery($param = "")
	{
		$data = array("booking_type" => firstLetterToCaps($param));
		$data["page_title"] = "Fecundhill | Admin - View ".firstLetterToCaps($param)." Express Delivery";

		$error_message = "";

		if($this->input->post("express_delivery_status_but")){
			
			$delivery_id 		= protect($this->input->post("delivery_id"));
			$tracking_status 	= protect($this->input->post("tracking_status")); // Accepted
			$admin_id 			= $this->Users->getUserID();

			$query = array(
				"tracking_status" 	=> $tracking_status, 
				"admin_id" 			=> $admin_id
			);

			$res = $this->ExpressDelivery->updateRecord($delivery_id, $query);
			if ($res === true) {

				$error_message .= "<p class='label label-success'>The Tracking Status has been updated!</p>";
			} else {
				$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
			}
		}

		$this->load->view("admin/express_delivery", $data);
	}
	public function referral_codes($param = "")
	{
		$data = array("param" => firstLetterToCaps($param));
		$data["page_title"] = "Fecundhill | Admin - Referral Codes";

		$error_message = "";

		$this->load->view("admin/referral_codes", $data);
	}
	public function referrals($param = "")
	{
		$data = array("param" => firstLetterToCaps($param));
		$data["page_title"] = "Fecundhill | Admin - Referrals";
		
		$error_message = "";

		$this->load->view("admin/referrals", $data);
	}
	public function booking_edit($booking_id = "")
	{
		$data["booking_id"] = protect($booking_id);
		$data["page_title"] = "Fecundhill | Admin - Edit Booking Information";

		$error_message = "";

		if($this->input->post("booking_edit_but")){

			$this->form_validation->set_rules('booking_id', 'Booking ID', 'required');
			$this->form_validation->set_rules('departure_time', 'Preferred Date/time of departure', 'required');			
			
			if ($this->form_validation->run() == FALSE) {
				// Form Validation Failed
				$error_message .= validation_errors();
			} else {
				$booking_id = protect($this->input->post("booking_id"));
				$admin_id = $this->Users->getUserID();

				$return_time = protect($this->input->post("return_time"));
				if($return_time != ""){
					$return_time = date("Y-m-d H:i:s", strtotime(protect($this->input->post("return_time"))) );
				}

				$query = array(
					"departure_time" 	=> date("Y-m-d H:i:s", strtotime(protect($this->input->post("departure_time"))) ),
					"return_time" 		=> $return_time,
					"time_updated"		=> date("Y-m-d H:i:s")
				);

				echo "Good to go! ".date("Y-m-d H:i:s", strtotime(protect($this->input->post("departure_time"))) )." | ". $return_time;
				$res = $this->Listing->updateBooking($booking_id, $query);
				if ($res === true) {
					$error_message .= "<p class='label label-success'>The Booking Updated!</p>";
				} else {
					$error_message .= "<p class='label label-danger'>The Process Failed to complete!</p>";
				}
			}			
		}
		$data["form_error"] = $error_message;
		$this->load->view("admin/booking_edit", $data);
	}

	public function listing_view($id)
	{
		$data = array("listing_id" => $id);
		$data["page_title"] = "Fecundhill | Admin - View Listings";

		$this->load->view("admin/listing_view", $data);
	}

	public function listing_requests(){
		$data["page_title"] = "Fecundhill | Admin - View Requests";
		$data["request_service_form_error"] = "";

		$process_form = false;
		$approval = 0;
		if ($this->input->post("approve_request_but")) {
			$process_form = true;
			$approval = 1;
		}
		if ($this->input->post("decline_request_but")) {
			$process_form = true;
			$approval = 2;
		}
		if ($process_form === true) {

			$user_id 	= $this->Users->getUserID();
			$listing_request_id = protect($this->input->post("listing_request_id"));

			$query = array(
				"admin_id" 			=> $user_id,
				"approval"			=> $approval,
				"time_updated"		=> date("Y-m-d H:i:s")
			);

			$save_res = $this->Listing->updateListingRequest($listing_request_id, $query);
			if ($save_res !== false) {
				// Successfull
				$data["request_service_form_error"]  .= "<p class='label label-success label-lg'>Successfull!</p>";
			} else {
				// Failure
				$data["request_service_form_error"] .= "<p class='label label-danger'>Failure.</p>";
			}
		
		}

		$this->load->view("admin/listing_requests_view", $data);
	}

	public function driver_signups(){
		$data["page_title"] = "Fecundhill | Admin - View Driver Signup Requests";
		$data["request_service_form_error"] = "";

		$process_form = false;
		$approval = 0;
		if ($this->input->post("approve_request_but")) {
			$process_form = true;
			$approval = 1;
		}
		if ($this->input->post("decline_request_but")) {
			$process_form = true;
			$approval = 2;
		}
		if ($process_form === true) {

			$user_id 	= $this->Users->getUserID();
			$listing_request_id = protect($this->input->post("listing_request_id"));

			$query = array(
				"admin_id" 			=> $user_id,
				"approval"			=> $approval,
				"time_updated"		=> date("Y-m-d H:i:s")
			);

		//	$save_res = $this->Listing->updateListingRequest($listing_request_id, $query);
			if ($save_res !== false) {
				// Successfull
				$data["request_service_form_error"]  .= "<p class='label label-success label-lg'>Successfull!</p>";
			} else {
				// Failure
				$data["request_service_form_error"] .= "<p class='label label-danger'>Failure.</p>";
			}
		
		}

		$this->load->view("admin/driver_signups", $data);
	}

	public function vehicle_signups(){
		$data["page_title"] = "Fecundhill | Admin - View Vehicle Signup Requests";
		$data["request_service_form_error"] = "";

		$process_form = false;
		$approval = 0;
		if ($this->input->post("approve_request_but")) {
			$process_form = true;
			$approval = 1;
		}
		if ($this->input->post("decline_request_but")) {
			$process_form = true;
			$approval = 2;
		}
		if ($this->input->post("suspend_request_but")) {
			$process_form = true;
			$approval = 3;
		}
		if ($process_form === true) {

			$user_id 	= $this->Users->getUserID();
			$vehicle_req_id = protect($this->input->post("vehicle_req_id"));

			$query = array(
				"status"			=> $approval,
				"time_updated"		=> date("Y-m-d H:i:s")
			);

			$save_res = $this->Listing->updateVehicleRequest($vehicle_req_id, $query);
			if ($save_res !== false) {
				// Successfull
				$data["request_service_form_error"]  .= "<p class='label label-success label-lg'>Successfull!</p>";
			} else {
				// Failure
				$data["request_service_form_error"] .= "<p class='label label-danger'>Failure.</p>";
			}
		
		}

		$this->load->view("admin/vehicle_signups", $data);
	}

}
