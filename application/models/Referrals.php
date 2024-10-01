<?php

class Referrals extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		
		date_default_timezone_set("GMT");

	}
	
	public function getAllReferralCodesArray(){

		$this->db->from("referral_codes");
		$this->db->order_by('time_created', "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getReferralCode($user_id)
	{
		$this->db->where(array("user_id" => $user_id));
		$this->db->from("referral_codes");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0]['code'];
		}
		return false;
	}
	public function getReferralCodeUser($code)
	{
		$this->db->where(array("code" => $code));
		$this->db->from("referral_codes");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function createReferralCode($user_id){

		$query = array(
			"user_id" 			=> $user_id,
			"code" 				=> $this->generateReferralCode(),
			"status"			=> 1,
			"time_created"		=> date("Y-m-d H:i:s")
		);

		$this->db->insert("referral_codes", $query);

		return array(true, $this->db->insert_id() );
	}
	public function generateReferralCode($length_of_string = 5){

		$string1 	= $this->generateCodeString($length_of_string);
		$chkem 		= $this->checkReferralCode($string1);
		while($chkem != false){ 
			$string1 	= $this->generateCodeString($length_of_string);
			$chkem 		= $this->checkReferralCode($string1);
		}
		return $string1;
	}
	public function checkReferralCode($code){
	    $this->db->where(array("code" => mb_strtoupper($code) ));
		$this->db->from("referral_codes");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $true;
		}
		return false;
	}
	public function generateCodeString($length_of_string){
	    $str_result = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789'; 
	    return substr(str_shuffle($str_result), 0, $length_of_string);
	}

	public function getAllReferrals(){

		$this->db->from("referrals");
		$this->db->order_by('time_created', "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getReferralInfo($code)
	{
		$this->db->where(array("code" => $code));
		$this->db->from("referrals");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function getReferralInfoByUser($user_id)
	{
		$this->db->where(array("user_id" => $user_id));
		$this->db->from("referrals");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function saveReferral($user_id, $code, $service){

		$query = array(
			"user_id" 			=> $user_id,
			"code" 				=> $code,
			"service"			=> $service,
			"status"			=> 1,
			"time_created"		=> date("Y-m-d H:i:s")
		);

		$this->db->insert("referrals", $query);

		return array(true, $this->db->insert_id() );
	}

}
	
?>