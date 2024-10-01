<?php

class Partner extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		
		date_default_timezone_set("GMT");

	}
	
	public function getAllPartnersArray(){

		$this->db->from("partner_info");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getAllPendingPartnerAccounts($enabled = 0)
	{

		$this->db->where(array("enabled" => $enabled));
		$this->db->from("partner_info");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	
	public function getAccount($user_id){

		$this->db->where(array("user_id" => $user_id));
		$this->db->from("partner_info");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function getPartnerID($user_id)
	{
		$this->db->where(array("user_id" => $user_id));
		$this->db->from("partner_info");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0]["id"];
		}
		return false;
	}
	public function getPartnerAccount($partner_id)
	{

		$this->db->where(array("id" => $partner_id));
		$this->db->from("partner_info");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function createPartnerAccount($user_id, $query){
		if($this->getAccount($user_id) === false){
			$this->db->insert("partner_info", $query);

			return $this->db->insert_id();
		}
		return false;
	}
	public function updateBusinessInfo($user_id, $query)
	{

		$this->db->where('user_id', $user_id);
		$this->db->update('partner_info', $query);

		return true;
	}
	public function updateBusinessInfoByPartnerID($partner_id, $query)
	{

		$this->db->where('id', $partner_id);
		$this->db->update('partner_info', $query);

		return true;
	}
	public function businessName($user_id)
	{
		$partner = $this->getAccount($user_id);
		
		return $partner["business_name"];
	}

	public function toggleAccountLock($lock_status, $the_account_id, $admin_id){

		$query = array(
			"admin_id" => $admin_id,
			"lock_status" => $lock_status,
			"time_updated" => date("Y-m-d H:i:s")
		);

		$this->db->where('id', $the_account_id);
		$this->db->update('partner_info', $query);

		return true;
	}

}
	
?>