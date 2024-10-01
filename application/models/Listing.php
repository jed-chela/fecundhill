<?php

class Listing extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		
		date_default_timezone_set("GMT");

	}
	
	public function getAllListingsArray(){

		$this->db->from("listings");
		$this->db->order_by('time_created', "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getAllListingsByDate($min_date = "", $category = "")
	{
		if($min_date == ""){
			$min_date = date ( "Y-m-d H:i:s", strtotime ( '-30 days' ) );
		}

		if($category == "")
			$this->db->where(array("time_created >=" => "$min_date" ));
		else if($category != ""){
			$this->db->where(array("time_created >=" => "$min_date" , "category" => $category));
		}
		$this->db->order_by('time_created', "desc");
		$this->db->from("listings");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getAllListingsByPublishStatus($publish_status = 0, $category = "")
	{
		if($category == "")
			$this->db->where(array("publish_status" => $publish_status));
		else if($category != ""){
			$this->db->where(array("publish_status" => $publish_status, "category" => $category));
		}
		$this->db->order_by('time_created', "desc");
		$this->db->from("listings");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getListingsByPublishStatus($partner_id, $publish_status = 0)
	{
		$this->db->where(array("partner_id" => $partner_id, "publish_status" => $publish_status));
		$this->db->from("listings");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	
	public function getListingsByPartnerID($partner_id)
	{
		$this->db->where(array("partner_id" => $partner_id));
		$this->db->from("listings");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getListingsByUserIDAndCategory($user_id, $category)
	{
		$this->db->where(array("user_id" => $user_id, "category" => $category));
		$this->db->from("listings");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getListingsByUserID($user_id)
	{
		$this->db->where(array("user_id" => $user_id));
		$this->db->from("listings");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getListing($listing_id)
	{
		$this->db->where(array("id" => $listing_id));
		$this->db->from("listings");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function createListing($query){

		$this->db->insert("listings", $query);

		return array(true, $this->db->insert_id() );
	}
	public function updateListing($partner_id, $query)
	{
		$this->db->where('partner_id', $partner_id);
		$this->db->update('listings', $query);

		return true;
	}
	public function updateListingPublishStatus($listing_id, $publish_status, $admin_id){
		$this->db->where(array("id" => $listing_id));
		$query = array(
			"publish_status" 	=> $publish_status,
			"admin_id" 			=> $admin_id,
			"time_updated"		=> date("Y-m-d H:i:s")
		);
		$query = $this->db->update('listings', $query);
		return true;
	}
	public function listingTitle($listing_id)
	{
		$listing = $this->getListing($listing_id);
		
		return $listing["title"];
	}


	public function saveListingPhotos($listing_id, $order, $file_name, $file_ext)
	{
		// type 1. To Admin 2. From Admin
		// status 0. unread 1. read

		$query = array(
			"listing_id" 		=> $listing_id,
			"order" 			=> $order,
			"file_name" 		=> $file_name,
			"file_ext" 			=> $file_ext,
			"status" 			=> 1,
			"time_added"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("listing_images", $query);

		return true;
	}


	public function getListingPhotos($message_id)
	{
		$this->db->where('listing_id', $message_id);
		$this->db->order_by('order', "");
		$this->db->from("listing_images");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function createListingRequest($query){

		$this->db->insert("listing_requests", $query);

		return true;
	}
	public function getListingRequest($listing_id, $user_id, $status = 1){
		$this->db->where(array('listing_id' => $listing_id, 'user_id' => $user_id, 'status' => $status) );
		$this->db->from("listing_requests");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}

	public function getMyListingRequests($user_id, $status = 1)
	{
		$this->db->where(array('user_id' => $user_id, 'status' => $status));
		$this->db->from("listing_requests");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function updateListingRequest($listing_request_id, $query){
		$this->db->where('id', $listing_request_id);
		$this->db->update('listing_requests', $query);

		return true;
	}

	public function getAllListingRequests(){
		$this->db->from("listing_requests");
		$this->db->order_by('time_updated', "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function getAllListingRequestsByDate($min_date = "")
	{
		if($min_date == ""){
			$min_date = date ( "Y-m-d H:i:s", strtotime ( '-30 days' ) );
		}

		$this->db->where(array("time_updated >=" => "$min_date" ));
		
		$this->db->from("listing_requests");
		$this->db->order_by('time_updated', "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}

	public function createDriverSignup($query)
	{

		$this->db->insert("driver_signup", $query);

		return array(true, $this->db->insert_id() );
	}
	public function getDriverSignupByUser($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->from("driver_signup");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllDriverSignupRequests(){
		$this->db->from("driver_signup");
		$this->db->order_by('time_updated', "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function removeDriverSignup($ref_id)
	{
		$query = "DELETE FROM driver_signup WHERE id = '$ref_id' ";
		$query = $this->db->query($query);
		return true;
	}

	public function saveDriverSignupFiles($ref_id, $order, $file_name, $file_ext)
	{
		$query = array(
			"ref_id" 			=> $ref_id,
			"order" 			=> $order,
			"file_name" 		=> $file_name,
			"file_ext" 			=> $file_ext,
			"status" 			=> 1,
			"time_added"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("driver_signup_files", $query);

		return true;
	}
	public function getDriverSignupFiles($ref_id)
	{
		$this->db->where('ref_id', $ref_id);
		$this->db->order_by('order', "");
		$this->db->from("driver_signup_files");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function removeDriverSignupFiles($ref_id, $upload_path)
	{
		$result_array = $this->getDriverSignupFiles($ref_id);
		if($result_array !== false){
			foreach ($result_array as $index => $row) {
				unlink($upload_path."/".$row["file_name"]);
			}
		}

		$query = "DELETE FROM driver_signup_files WHERE ref_id = '$ref_id' ";
		$query = $this->db->query($query);
		return true;
	}

	/* VEHICLE CODES*/

	public function createVehicleSignup($query)
	{
		$this->db->insert("vehicle_signup", $query);

		return array(true, $this->db->insert_id() );
	}
	public function getVehicleSignupByUser($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->order_by('time_updated', "desc");
		$this->db->from("vehicle_signup");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllVehicleSignupRequests($exclude_rejected = false){
		if($exclude_rejected){
			$this->db->where("status !=", 2);
		}

		$this->db->from("vehicle_signup");
		$this->db->order_by('time_updated', "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function updateVehicleRequest($vehicle_request_id, $query){
		$this->db->where('id', $vehicle_request_id);
		$this->db->update('vehicle_signup', $query);

		return true;
	}
	public function removeVehicleSignup($ref_id)
	{
		$query = "DELETE FROM vehicle_signup WHERE id = '$ref_id' ";
		$query = $this->db->query($query);
		return true;
	}

	public function saveVehicleSignupFiles($ref_id, $order, $file_name, $file_ext)
	{
		$query = array(
			"ref_id" 			=> $ref_id,
			"order" 			=> $order,
			"file_name" 		=> $file_name,
			"file_ext" 			=> $file_ext,
			"status" 			=> 1,
			"time_added"		=> date("Y-m-d H:i:s")
		);
		$this->db->insert("vehicle_signup_files", $query);

		return true;
	}
	public function getVehicleSignupFiles($ref_id)
	{
		$this->db->where('ref_id', $ref_id);
		$this->db->order_by('order', "");
		$this->db->from("vehicle_signup_files");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function removeVehicleSignupFiles($ref_id, $upload_path)
	{
		$result_array = $this->getVehicleSignupFiles($ref_id);
		if($result_array !== false){
			foreach ($result_array as $index => $row) {
				unlink($upload_path."/".$row["file_name"]);
			}
		}

		$query = "DELETE FROM vehicle_signup_files WHERE ref_id = '$ref_id' ";
		$query = $this->db->query($query);
		return true;
	}

	/* BOOKING RIDE/FLIGHT CODES*/

	public function createBooking($query)
	{
		$this->db->insert("booking", $query);

		return array(true, $this->db->insert_id() );
	}
	public function getBooking($ref_id)
	{
		$this->db->where('id', $ref_id);
		$this->db->from("booking");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}
	public function getBookingByUser($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->from("booking");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllBookingRequests()
	{
		$this->db->from("booking");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getAllBookingRequestsByType($type)
	{
		$this->db->where('type', $type);
		$this->db->from("booking");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function updateBooking($booking_id, $query)
	{
		$this->db->where('id', $booking_id);
		$this->db->update('booking', $query);

		return true;
	}
	public function updateBookingApprovalStatus($booking_id, $approval, $admin_id)
	{
		$query = array(
			"approval" 			=> $approval,
			"time_updated"		=> date("Y-m-d H:i:s")
		);
		
		$this->db->where('id', $booking_id);
		$this->db->update('booking', $query);
		
		return true;
	}
	public function checkBookingByUser($user_id, $type, $departure, $departure_time)
	{
		$this->db->where(array("user_id" => $user_id, "type" => $type, "departure" => $departure, "departure_time" => $departure_time));
		$this->db->from("booking");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function removeBooking($ref_id)
	{
		$query = "DELETE FROM booking WHERE id = '$ref_id' ";
		$query = $this->db->query($query);
		return true;
	}


}
	
?>