<?php

class Personal extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		
		date_default_timezone_set("GMT");

	}
	
	public function getAllProfilesArray(){
	//	$this->db->where(array("surname" => $user_id));
		$this->db->from("personal_info");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	
	public function myPersonalInfo(){
	
		$user_id = $this->Users->getUserID();
		
		return $this->personalInfo($user_id) ;
	
	}
	public function createMyPersonalInfo()
	{

		$user_id = $this->Users->getUserID();

		return $this->createPersonalInfo($user_id);
	}
	public function personalInfo($user_id){

		$this->db->where(array("user_id" => $user_id));
		$this->db->from("personal_info");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function createPersonalInfo($user_id)
	{
		$query = array(
			"user_id" 		=> $user_id,
			"admin_id" 		=> "",
			"lock_status" 		=> 0,
			"time_created"	=> date("Y-m-d H:i:s"),
			"time_updated"	=> date("Y-m-d H:i:s")
		);
		$this->db->insert("personal_info", $query);

		return $this->db->insert_id();
	}
	public function createPersonalInfo2($user_id, $firstname, $surname, $phone, $state, $town, $gender, $marital_status, $date_of_birth, $lga)
	{
		$query = array(
			"user_id" 			=> $user_id,
			"firstname" 		=> $firstname,
			"surname" 			=> $surname,
			"phone" 			=> $phone,
			"residential_state" => $state,
			"residential_lga" 	=> $lga,
			"residential_city" 	=> $town,
			"gender" 			=> $gender,
			"marital_status" 	=> $marital_status,
			"date_of_birth" 	=> $date_of_birth,

			"admin_id" 			=> "",
			"lock_status" 		=> 0,
			"time_created"		=> date("Y-m-d H:i:s"),
			"time_updated"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("personal_info", $query);

		return $this->db->insert_id();
	}
	public function updatePersonalInfo($user_id, $query)
	{

		$update_query = $query;

		$this->db->where('user_id', $user_id);
		$this->db->update('personal_info', $update_query);

		return true;
	}
	public function userName($user_id)
	{
		$user = $this->personalInfo($user_id);
		
		return $user["title"]. " " . $user["firstname"] . " " . $user["surname"]. " ".$user["othername"];
	}

	public function saveDirectMessage($type, $sender_id, $title, $message, $recipient_id = "")
	{
		// type 1. To Admin 2. From Admin
		// status 0. unread 1. read

		$query = array(
			"type" 				=> $type,
			"sender_id" 		=> $sender_id,
			"recipient_id" 		=> $recipient_id,
			"title" 			=> $title,
			"message" 			=> $message,
			"status" 			=> 0,
			"time_read"			=> date("Y-m-d H:i:s"),
			"time_updated"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("messages", $query);

		return array(true, $this->db->insert_id());
	}

	public function saveSpecialMessage($type, $sender_id, $category, $sub_category, $title, $message, $location, $destination = "", $recipient_id = "")
	{
		// type 1. To Admin 2. From Admin, Type= 7. Special Request to Admin
		// status 0. unread 1. read

		$query = array(
			"type" 				=> $type,
			"sender_id" 		=> $sender_id,
			"recipient_id" 		=> $recipient_id,
			"title" 			=> $title,
			"message" 			=> $message,
			"category" 			=> $category,
			"sub_category" 		=> $sub_category,
			"location"			=> $location,
			"destination"		=> $destination,
			"status" 			=> 0,
			"time_read"			=> date("Y-m-d H:i:s"),
			"time_updated"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("messages", $query);

		return array(true, $this->db->insert_id());
	}

	public function saveDirectMessageAttachment($message_id, $order, $file_name, $file_ext)
	{
		// type 1. To Admin 2. From Admin
		// status 0. unread 1. read

		$query = array(
			"message_id" 		=> $message_id,
			"order" 			=> $order,
			"file_name" 		=> $file_name,
			"file_ext" 			=> $file_ext,
			"status" 			=> 1,
			"time_added"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("message_attachments", $query);

		return true;
	}

	public function getAdminMessages($type1 = 1, $type2 = 2)
	{
		$this->db->where('type =', $type1);
		$this->db->or_where('type =', $type2);
		$this->db->order_by('time_updated', "desc");
		$this->db->from("messages");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getAdminMessagesOne($type1 = 1)
	{
		$this->db->where('type =', $type1);
		$this->db->order_by('time_updated', "desc");
		$this->db->from("messages");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getAdminServiceRequests($type = 7)
	{
		$this->db->where('type =', $type);
		$this->db->order_by('time_updated', "desc");
		$this->db->from("messages");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAdminServiceRequestsByUser($user_id, $type = 7)
	{
		$this->db->where(array("type" => $type, "$user_id" => $user_id ) );
		$this->db->order_by('time_updated', "desc");
		$this->db->from("messages");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAdminServiceRequestsByCategoryAndDate($category, $min_date = "", $type = 7)
	{
		if($min_date == ""){
			$min_date = date ( "Y-m-d H:i:s", strtotime ( '-30 days' ) );
		}
		
	//	$this->db->where("time_updated >= '$min_date'");

		$this->db->where(array('type' => $type, 'category' => $category, 'time_updated >=' => "$min_date" ) );
		$this->db->order_by('time_updated', "desc");
		$this->db->from("messages");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getMyMessages($user_id){
		$query = "SELECT * FROM messages WHERE (sender_id = '$user_id' AND type = '1' ) OR (recipient_id = '$user_id' AND type = '2' ) ORDER BY time_updated DESC";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	
	public function getMessageAttachments($message_id)
	{
		$this->db->where('message_id', $message_id);
		$this->db->order_by('order', "");
		$this->db->from("message_attachments");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getMessage($message_id){
		$this->db->where('id', $message_id);
		$this->db->from("messages");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}

	public function toggleProfileLock($lock_status, $the_user_id, $admin_id){

		$query = array(
			"admin_id" => $admin_id,
			"lock_status" => $lock_status,
			"time_updated" => date("Y-m-d H:i:s")
		);

		$this->db->where('user_id', $the_user_id);
		$this->db->update('personal_info', $query);

		return true;
	}

}