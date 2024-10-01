<?php

class ExpressDelivery extends CI_Model
{
	private $table = "express_delivery";
    
    public function __construct()
    {
        parent::__construct();
		
		date_default_timezone_set("GMT");

	}
	
	public function create($query){

		$this->db->insert($this->table, $query);

		return array(true, $this->db->insert_id() );
	}

	public function checkDuplicate($user_id, $description, $pickup_location, $delivery_location, $pickup_datetime)
	{
		$this->db->where(array("user_id" => $user_id, "description" => $description, "pickup_location" => $pickup_location, "delivery_location" => $delivery_location, "pickup_datetime" => $pickup_datetime));
		$this->db->from($this->table);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}

	public function read($user_id = "", $limit = ""){

		if($user_id != ""){
			$this->db->where(array("user_id" => $user_id));
		}

		if($limit != ""){
			$this->db->limit($limit);
		}

		$this->db->order_by('time_added', "desc");
		$this->db->from($this->table);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function updateRecord($id, $query)
	{
		$this->db->where('id', $id);
		$this->db->update($this->table, $query);
		return true;
	}

	public function deleteRecord($id)
	{
		$query = "DELETE FROM ".$this->table." WHERE id = '$id' ";
		$query = $this->db->query($query);
		return true;
	}

}
	
?>