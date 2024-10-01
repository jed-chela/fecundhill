<?php

class Finance extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		
		date_default_timezone_set("GMT");

    }
	
	public function getAccount($user_id, $type){

		$this->db->where(array("user_id" => $user_id, "type" => $type));
		$this->db->from("finance_accounts");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function getAccountsByType($type)
	{

		$this->db->where(array("type" => $type));
		$this->db->from("finance_accounts");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAccountsByType2($type = "")
	{

		$this->db->distinct();
		$this->db->select(array('user_id'));
		$this->db->from("finance_accounts");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function createNewAccount($user_id, $type)
	{
		//type  1. Savings, 2. Fecundvest
		$query = array(
			"user_id" 		=> $user_id,
			"type" 			=> $type,
			"status" 		=> 0,
			"date_authorized" => date("Y-m-d H:i:s"),
			"time_created"	=> date("Y-m-d H:i:s"),
			"time_updated"	=> date("Y-m-d H:i:s")
		);
		$this->db->insert("finance_accounts", $query);
		
		return $this->db->insert_id();
	}
	public function updateAccountInfo($account_id, $query)
	{
		$this->db->where('id', $account_id);
		$this->db->update('finance_accounts', $query);

		return true;
	}
	public function getAccountRequests($account_type, $status){
		$this->db->where(array("type" => $account_type, "status" => $status));
		$this->db->from("finance_accounts");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function confirmNewAccount($account_id, $admin_id){
		$query = array(
			"admin_id" => $admin_id,
			"status" => 1
		);
		$this->db->where('id', $account_id);
		$this->db->update('finance_accounts', $query);

		return true;
	}

	public function createNewLoanRequest($user_id, $loan_amount, $loan_duration, $children, $bank_account, $cheque_book, $bank_name, $account_name, $account_number, $current_income, $other_loan, $deposit_frequency, $payment_amount, $specific_day, $purpose, $collateral, $referral_code, $employment, $asset_location)
	{
		$query = array(
			"user_id" 			=> $user_id,
			"amount" 			=> $loan_amount,
			"duration" 			=> $loan_duration,
			"children" 			=> $children,
			"bank_account"		=> $bank_account,
			"cheque_book" 		=> $cheque_book,
			"bank_name" 		=> $bank_name,
			"account_name" 		=> $account_name,
			"account_number" 	=> $account_number,
			"current_income" 	=> $current_income,
			"other_loan" 		=> $other_loan,
			"status" 			=> 0,
			"time_created" 		=> date("Y-m-d H:i:s"),
			"time_updated"		=> date("Y-m-d H:i:s"),
			"referee"			=> $referral_code,
			"deposit_frequency"	=> $deposit_frequency,
			"payment_amount"	=> $payment_amount,
			"specific_day"		=> $specific_day,
			"purpose"			=> $purpose,
			"collateral"		=> $collateral,
			"employment"		=> $employment,
			"asset_location"	=> $asset_location,
		);
		$this->db->insert("finance_loan_request", $query);

		return $this->db->insert_id();
	}

	public function getPendingLoanRequest($user_id){
		return $this->getLoanRequest($user_id, 0);
	}

	public function getLoanRequest($user_id, $status)
	{
		$this->db->where(array("user_id" => $user_id, "status" => $status));
		$this->db->from("finance_loan_request");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getUserLoanRequests($user_id)
	{
		$this->db->where(array("user_id" => $user_id));
		$this->db->order_by('time_created', "DESC");
		$this->db->from("finance_loan_request");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getLoanRequestRecord($request_id)
	{
		$this->db->where(array("id" => $request_id));
		$this->db->from("finance_loan_request");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function updateLoanRequestRecord($request_id, $update_query){
		$this->db->where('id', $request_id);
		$this->db->update('finance_loan_request', $update_query);

		return true;
	}

	public function createNewActiveLoan($loan_request_id, $user_id, $loan_amount, $loan_duration, $admin_id)
	{
		$query = array(
			"user_id" 			=> $user_id,
			"loan_request_id" 	=> $loan_request_id,
			"amount" 			=> $loan_amount,
			"duration" 			=> $loan_duration,
			"admin_id" 			=> $admin_id,
			"active_status" 	=> 1,
			"time_created" 		=> date("Y-m-d H:i:s"),
			"time_updated"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("finance_loans", $query);

		return $this->db->insert_id();
	}
	public function getActiveLoans($user_id, $active_status = 1){
		$this->db->where(array("user_id" => $user_id, "active_status" => $active_status));
		$this->db->from("finance_loans");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllLoansByStatus($status = 1){
		$this->db->where(array("active_status" => $status));
		$this->db->from("finance_loans");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllLoans(){
		$this->db->from("finance_loans");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllUserLoans($user_id){
		$this->db->where(array("user_id" => $user_id));
		$this->db->order_by('time_created', "desc");
		$this->db->from("finance_loans");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getActiveLoanRecordByRequest($request_id){
		$this->db->where(array("loan_request_id" => $request_id));
		$this->db->from("finance_loans");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function updateActiveLoanRecord($loan_id, $update_query){
		$this->db->where('id', $loan_id);
		$this->db->update('finance_loans', $update_query);

		return true;
	}

	public function getAllPendingLoanRequests()
	{
		return $this->getAllLoanRequests("0");
	}

	public function getAllLoanRequests($status = "")
	{
		$this->db->order_by('time_created', "DESC");

		if($status != ""){
			$this->db->where(array("status" => $status));
		}
		
		
		$this->db->from("finance_loan_request");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllLoanRequestsByDate($min_date = "")
	{
		if($min_date == ""){
			$min_date = date ( "Y-m-d H:i:s", strtotime ( '-30 days' ) );
		}
		
		$this->db->where("time_created >= '$min_date'");
		$this->db->from("finance_loan_request");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllActiveLoans($active_status = 1)
	{
		$this->db->where(array("active_status" => $active_status));
		$this->db->from("finance_loans");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function createNewWithdrawalRequest($user_id, $withdraw_amount, $bank_account, $bank_name, $account_name, $account_number){
		$query = array(
			"user_id" 			=> $user_id,
			"amount" 			=> $withdraw_amount,
			"bank_account"		=> $bank_account,
			"bank_name" 		=> $bank_name,
			"account_name" 		=> $account_name,
			"account_number" 	=> $account_number,
			"approval" 			=> 0,
			"status" 			=> 1,
			"time_created" 		=> date("Y-m-d H:i:s"),
			"time_updated"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("finance_withdrawal_request", $query);

		return $this->db->insert_id();
	}

	public function getAllPendingWithdrawalRequests()
	{
		return $this->getAllWithdrawalRequests("0");
	}
	public function getAllWithdrawalRequests($status = "")
	{
		if($status != "")
		$this->db->where(array("approval" => $status));
		$this->db->order_by('time_created', "DESC");
		$this->db->from("finance_withdrawal_request");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getPendingWithdrawalRequest($user_id)
	{
		return $this->getWithdrawalRequest($user_id, 0);
	}

	public function getWithdrawalRequest($user_id, $approval)
	{
		$this->db->where(array("user_id" => $user_id, "approval" => $approval));
		$this->db->from("finance_withdrawal_request");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getWithdrawalRequestRecord($request_id)
	{
		$this->db->where(array("id" => $request_id));
		$this->db->from("finance_withdrawal_request");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function updateWithdrawalRequestRecord($request_id, $update_query)
	{
		$this->db->where('id', $request_id);
		$this->db->update('finance_withdrawal_request', $update_query);

		return true;
	}

	public function getFixedDepositAccountNumber($user_id){
		$res = $this->getAccount($user_id, 2);
		if($res !== false){
			return $res["id"];
		}
		return "";
	}

	public function createNewTransaction($account_no, $ref_number, $type, $user_id, $amount, $admin_id)
	{
		// Transaction Types:  1. Fecundvest, 2. Savings, 5. Fecundvest Withdrawal
		/*
			1. Credit
			2. Fecundvest Interest
			6. Admin charges
			7. Default charge
			8. Fecundvest bonus 
			9. Referral bonus 
			10. Loan repayment
			11. Ride payment
			12. Hire purchase payment
			. Deposit
			. Savings 
		*/
		$query = array(
			"account_no"		=> $account_no,
			"user_id" 			=> $user_id,
			"ref_number" 		=> $ref_number,
			"type" 				=> $type,
			"admin_id" 			=> $admin_id,
			"amount" 			=> $amount,
			"status" 			=> 1,
			"day" 				=> date("d"),
			"month" 			=> date("m"),
			"year" 				=> date("Y"),
			"time_added" 		=> date("Y-m-d H:i:s"),
			"time_updated"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("finance_transactions", $query);

		return $this->db->insert_id();
	}
	public function getTransactions($user_id, $status = 1)
	{
		$this->db->where(array("user_id" => $user_id, "status" => $status));
		$this->db->from("finance_transactions");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getTransactionRecordByRefNumber($ref_number, $type)
	{
		$this->db->where(array("ref_number" => $ref_number, "type" => $type));
		$this->db->from("finance_transactions");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function getTransactionRecordByAccountNo($account_no)
	{
		$this->db->where(array("account_no" => $account_no));
		$this->db->from("finance_transactions");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function updateTransactionRecord($transaction_id, $update_query)
	{
		$this->db->where('id', $transaction_id);
		$this->db->update('finance_transactions', $update_query);

		return true;
	}
	public function updateFecundVest($account_id, $update_query)
	{
		$this->db->where('id', $account_id);
		$this->db->update('finance_accounts', $update_query);

		return true;
	}
	

}