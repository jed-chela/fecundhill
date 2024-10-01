<?php

class Users extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		
		date_default_timezone_set("GMT");

		$this->session_key = "by32wd27ert588" ;
    }
	
	private $session_key;
	
	public function isActive(){
		//Check Cookies
		
		//Check Sessions
		if($this->check()  === true){
			// Check Status
			
			$user_status = $this->getUserStatus($this->getUserID());
			if($user_status == 2){
				// Reset First Password
		//		header("Location:".base_url()."profile/verify_email");
			}else if ($user_status == 9) {
				// Suspended
		//		header("Location:".base_url()."profile/suspended");
			}
			return true ;
		}else{
			return false ;
		}
	}
	public function create($user_id){
		/* Create/Activate Current User Sessions */
		$this->session->set_userdata("user_logged_in".$this->session_key, true) ;
		$this->session->set_userdata("user_".$this->session_key."_id", $user_id) ;
		return true ;
	}
	public function remove(){
		/* Unset Current User Sessions */
		$this->session->unset_userdata("user_logged_in".$this->session_key) ;
		$this->session->unset_userdata("user_".$this->session_key."_id") ;
		return true ;
	}
	public function check(){
		if(($this->session->userdata("user_logged_in".$this->session_key)) == true){
			return true;
		}
		return false;
	}
	public function getUserID(){
		if($this->check() === true ){
//			return ($this->session->userdata("user_logged_in".$this->session_key));
			return ($this->session->userdata("user_".$this->session_key."_id"));
		}
		return false;
	}
	public function delete(){
		$this->session->unset_userdata("user_logged_in".$this->session_key) ;
		$this->session->unset_userdata("user_".$this->session_key."_id") ;
		return true ;
	}
	public function executeLogin($email, $pass){
		$email = mb_strtolower($email);
		$pass = passEncrypt($pass);
		$this->db->select("id");
		$this->db->where(array('email' => $email, 'password' => $pass) );
		$this->db->from('app_users');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result_array = $query->result_array() ;
			return array(true, $result_array[0]["id"] ) ;
		}
		return array(false) ;
	}

	public function createUser($email, $password){
		// id, username, email, phone, password, salt, status, time_updated

		$email = mb_strtolower($email);

		$salt = $this->createSalt();

		$password_hash = pbkdf2("SHA256", $password, $salt, "1000", "128");

		$query = array(
			"username" 		=> $email,
			"email" 		=> $email,
			"phone" 		=> $email,
			"password"		=> $password_hash,
			"salt"			=> $salt,
			"status" 		=> 2,
			"time_updated"	=> date("Y-m-d H:i:s"),
			"time_created"	=> date("Y-m-d H:i:s"),
		);
		$this->db->insert("app_users", $query);

		return $this->db->insert_id();
	}
	public function updatePassword($user_id, $password){
		// id, user_id, password

		return $this->resetPasswordAndActivateAccount($user_id, $password);
		
	}
	public function createSalt(){
		return $this->generateRandomString("app_users", "salt", "generateRandomSalt");
	}
	public function addUserPermission($user_id, $permission = 1){
		$query = array(
			"user_id" 		=> $user_id,
			"permission"	=> $permission,
			"status" 		=> 1,
			"time_updated"	=> date("Y-m-d H:i:s")
		);
		$this->db->insert("app_users_permissions", $query);
		return true;
	}

	public function getSubAdminAccess($user_id)
	{
		$this->db->select("permission, user_id, admin_id, category_id");
		$this->db->where(array("user_id" => $user_id));
		$this->db->from("sub_admin_access");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function addSubAdminAccess($user_id, $admin_id, $permission, $category_id = 0)
	{
		$query = array(
			"user_id" 		=> $user_id,
			"admin_id" 		=> $admin_id,
			"permission"	=> $permission,
			"category_id"	=> $category_id,
			"status" 		=> 1,
			"time_created"	=> date("Y-m-d H:i:s"),
			"time_updated"	=> date("Y-m-d H:i:s")
		);
		$this->db->insert("sub_admin_access", $query);
		return true;
	}
	public function removeSubAdminAccess($user_id)
	{
		$query = "DELETE FROM sub_admin_access WHERE user_id = '$user_id' ";
		$query = $this->db->query($query);
		return true;
	}
	public function getUserAccessPermission($user_id){
		$this->db->select("permission");
		$this->db->where(array("user_id" => $user_id) );
		$this->db->from("app_users_permissions");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result_array = $query->result_array();
			return $result_array[0]["permission"];
		}
		return false;
	}


	public function checkField($value, $table, $field){
		
		$this->db->select($field);
		$this->db->where(array($field => $value) );
		$this->db->from($table);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return true;
		}
		return false;
	}
	public function checkFieldTwo($value1, $value2, $table, $field1, $field2){
		
		$this->db->select($field1);
		$this->db->where(array($field1 => $value1, $field2 => $value2) );
		$this->db->from($table);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return true;
		}
		return false;
	}

	public function generateRandomAlpha($length, $table = "", $field = "", $dict = "abcdefghjkmnpqrstuvwxyz"){
		$string = $this->generateRandomAlphaString($length, $dict);

		$chkval = $this->checkField($string, $table, $field);
		while($chkval !== false){ 
			$string = $this->generateRandomAlphaString($length, $dict);
			
			if( ($table != "") ){
				$chkval = $this->checkField($string, $table, $field);
			}else{ 
				$chkval = false; 
			}
		}
		return $string;
	}

	public function generateRandomAlphaString($length, $dict = "abcdefghjkmnpqrstuvwxyz"){
		$string = '';
		for ($p = 0; $p < $length; $p++) {
			$string .= $dict[mt_rand(0, strlen($dict) - 1)];
		}
		return $string;
	}


	public function generateRandomString($table = "", $field = "", $anonFunction = ""){
		$string = $this->$anonFunction();

		$chkval = $this->checkField($string, $table, $field);
		while($chkval !== false){ 
			$string = $this->$anonFunction();
			
			if( ($table != "") ){
				$chkval = $this->checkField($string, $table, $field);
			}else{ 
				$chkval = false; 
			}
		}
		return $string;
	}

	public function generateRandomSalt($length = 10){
		$salt = openssl_random_pseudo_bytes($length);
    	return bin2hex($salt);
	}

	public function generateRandomCharacters($length = 12){
		$string = openssl_random_pseudo_bytes($length);
    	return bin2hex($string);
	}


	/*** LOGIN METHODS ***/

	public function signUserIn($email, $pass){

		$emailphone_okay = false;
		$emailphone_flag = "";

		$email = mb_strtolower($email);

		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// Sign In Via Email
			$val_email = $this->checkSignInEmail($email, $pass);
			if($val_email !== false){

				$app_user_id = $val_email[1];
				
				// Kill Active Sessions
				$this->remove();

				// Activate Sessions
				if($this->create($app_user_id)){
					return array(true);
				}

			}else{
				// SignIn using Email Address Failed
				$emailphone_flag = 1;
			}
			
		}

/*		else{
			// Sign In Via Phone Number
			$val_phone = $this->checkSignInPhone($emailphone, $passwstr);
			
			if($val_phone !== false){

				$app_user_id = $val_phone[1];

				// Activate Sessions
				if($this->activateAppUserSessions($app_user_id)){
					return array(true);
				}
				
			}else{
				// SignIn using Phone Number Failed
				$emailphone_flag = 2;
			}		
		}*/

		return array(false, $emailphone_flag);
	}

	public function checkSignInEmail($email, $password){

		$email = mb_strtolower($email);
		
		$this->db->select("id, password, salt");
		$this->db->where(array('email' => $email) );
		$this->db->from('app_users');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result_array = $query->result_array() ;

			$id 			= $result_array[0]["id"];
			$salt 			= $result_array[0]["salt"];
			$saved_hash 	= $result_array[0]["password"];

			$password_hash = pbkdf2("SHA256", $password, $salt, "1000", "128");

			if($saved_hash == $password_hash){
				return array(true, $id);
			}

		}
		return false;
	}
	public function checkSignInEmailOnly($email){

		$email = mb_strtolower($email);
		
		$this->db->select("id");
		$this->db->where(array('email' => $email) );
		$this->db->from('app_users');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result_array = $query->result_array() ;

			$id = $result_array[0]["id"];
			
			return array(true, $id);
			
		}
		return false;
	}
	public function checkSignInPhone($phone, $password){
		
		$collection = $this->coll_app_users;
				
		$document = $collection->findOne([
			"phone" => $phone
		]);

		if(isset($document)){
			
			$id 			= $document["_id"];
			$salt 			= $document["salt"];
			$saved_hash 	= $document["password"];

			$password_hash = pbkdf2("SHA256", $password, $salt, "1000", "128");

			if($saved_hash == $password_hash){
				return array(true, $id);
			}
			
		}
		return false;
	}

	public function getUserStatus($user_id){
		$this->db->select("status");
		$this->db->where(array('id' => $user_id) );
		$this->db->from('app_users');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result_array = $query->result_array() ;

			$status 		= $result_array[0]["status"];

			return $status;
		}
		return false;
	}
	public function getUserEmail($user_id){
		$this->db->select("email");
		$this->db->where(array('id' => $user_id) );
		$this->db->from('app_users');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result_array = $query->result_array() ;

			$email 		= $result_array[0]["email"];

			return $email;
		}
		return false;
	}
	public function getUserByEmail($email)
	{

		$email = mb_strtolower($email);
		
		$this->db->select("id, email, status");
		$this->db->where(array('email' => $email));
		$this->db->from('app_users');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();

			$status 		= $result_array[0];

			return $status;
		}
		return false;
	}

	public function getAllUsers()
	{
		$this->db->select("id, email, username, phone, status, time_updated, time_created");
		$this->db->from('app_users');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function getUser($user_id)
	{
		$this->db->select("id, email, username, phone, status, time_updated, time_created");
		$this->db->where('id', $user_id);
		$this->db->from('app_users');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array[0];
		}
		return false;
	}

	public function createVerifyAccountHash($user_id, $user_email)
	{
		// get existing
		$existing = $this->getVerifyAccountHash($user_email);
		if($existing !== false){
			return $existing;
		}

		// add new
		$string1 = $this->createSalt();
		$string2 = $this->createSalt();

		$reset_hash = pbkdf2("SHA256", $string1, $string2, "1000", "128");

		$query = array(
			"user_id" 		=> $user_id,
			"email" 		=> $user_email,
			"hash"			=> $reset_hash,
			"time_created"	=> date("Y-m-d H:i:s"),
			"status"		=> 9,
			"time_updated"	=> date("Y-m-d H:i:s"),
		);
		$this->db->insert("account_verify", $query);

		return $reset_hash;
		
	}
	public function getVerifyAccountHash($email)
	{
		$this->db->select("hash");
		$this->db->where(array('email' => $email));
		$this->db->from('account_verify');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();

			$hash 		= $result_array[0]["hash"];

			return $hash;
		}
		return false;
	}
	public function removeVerifyAccountHash($user_id)
	{
		$query = "DELETE FROM account_verify WHERE user_id = '$user_id' ";
		$query = $this->db->query($query);
		return true;
	}
	public function removeVerifyAccountHashByEmail($user_email)
	{
		$query = "DELETE FROM account_verify WHERE email = '$user_email' ";
		$query = $this->db->query($query);
		return true;
	}
	public function getVerifyAccountInfo($hash)
	{
		$this->db->where(array('hash' => $hash));
		$this->db->from('account_verify');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();

			return $result_array[0];
		}
		return false;
	}
	public function getVerifyAccountInfoByID($user_id)
	{
		$this->db->where(array('user_id' => $user_id));
		$this->db->from('account_verify');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			
			return $result_array[0];
		}
		return false;
	}
	public function updateVerifyAccountInfo($id)
	{
		$query = array(
			'status' 		=> 1,
			'time_updated' 	=> date("Y-m-d H:i:s")
		);

		$this->db->where('id', $id);
		$this->db->update('account_verify', $query);
		return true;
	}
	public function verifyAndActivateAccount($user_id)
	{
		$query = array(
			'status' 		=> 1,
			'time_updated' 	=> date("Y-m-d H:i:s")
		);

		$this->db->where('id', $user_id);
		$this->db->update('app_users', $query);
		return true;
	}

	
	public function createResetPasswordHash($user_id, $user_email){
		// remove existing
		$this->removeResetPasswordHash($user_id);

		// add new

		$string1 = $this->createSalt();
		$string2 = $this->createSalt();

		$reset_hash = pbkdf2("SHA256", $string1, $string2, "1000", "128");

		$query = array(
			"user_id" 		=> $user_id,
			"email" 		=> $user_email,
			"hash"			=> $reset_hash,
			"time_created"	=> date("Y-m-d H:i:s")
		);
		$this->db->insert("reset_password", $query);

		return $reset_hash;
	}

	public function removeResetPasswordHash($user_id){
		$query = "DELETE FROM reset_password WHERE user_id = '$user_id' " ;
		$query = $this->db->query($query);
		return true;
	}
	public function removeResetPasswordHashByEmail($user_email)
	{
		$query = "DELETE FROM reset_password WHERE email = '$user_email' ";
		$query = $this->db->query($query);
		return true;
	}

	public function getResetPasswordInfo($hash){
		$this->db->where(array('hash' => $hash) );
		$this->db->from('reset_password');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result_array = $query->result_array() ;

			$email 		= $result_array[0];

			return $email;
		}
		return false;
	}

	public function getResetPasswordStatus($email){
		$this->db->where(array('email' => $email) );
		$this->db->from('reset_password');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return true;
		}
		return false;
	}

	public function getResetPasswordHash($email){
		$this->db->select("hash");
		$this->db->where(array('email' => $email) );
		$this->db->from('reset_password');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result_array = $query->result_array() ;

			$hash 		= $result_array[0]["hash"];

			return $hash;
		}
		return false;
	}

	public function resetPasswordAndActivateAccount($user_id, $password){

		$salt = $this->createSalt();

		$password_hash = pbkdf2("SHA256", $password, $salt, "1000", "128");

		$query = array(
           'password' 		=> $password_hash,
           'salt' 			=> $salt,
           'status' 		=> 1,
           'time_updated' 	=> date("Y-m-d H:i:s")
        );

		$this->db->where('id', $user_id);
		$this->db->update('app_users', $query); 
		return true;
	}

	public function resetAccountPassword($user_id, $password)
	{
		$salt = $this->createSalt();

		$password_hash = pbkdf2("SHA256", $password, $salt, "1000", "128");

		$query = array(
			'password' 		=> $password_hash,
			'salt' 			=> $salt,
			'time_updated' 	=> date("Y-m-d H:i:s")
		);

		$this->db->where('id', $user_id);
		$this->db->update('app_users', $query);
		return true;
	}

	public function createPhoneVerify($user_id, $phone, $otp){
		// id, user_id, phone, otp, time_updated

		$query = array(
			"user_id" 		=> $user_id,
			"phone" 		=> $phone,
			"otp" 			=> $otp,
			"status" 		=> 1,
			"time_updated"	=> date("Y-m-d H:i:s"),
			"time_added"	=> date("Y-m-d H:i:s"),
		);
		$this->db->insert("phone_verify", $query);

		return $this->db->insert_id();
	}
	public function getPhoneVerify($user_id)
	{
		$this->db->where(array("user_id" => $user_id));
		$this->db->from("phone_verify");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result_array = $query->result_array();
			return $result_array;
		}
		return false;
	}
	public function updatePhoneVerifyRecord($user_id, $phone, $otp)
	{
		$query = array(
			"phone" 		=> $phone,
			"otp" 			=> $otp,
			'verify' 		=> 1,
			'time_updated' 	=> date("Y-m-d H:i:s")
		);

		$this->db->where('user_id', $user_id);
		$this->db->update('phone_verify', $query);
		return true;
	}
	public function updatePhoneVerifyStatus($user_id, $verify)
	{
		$query = array(
			'verify' 		=> 2,
			'time_updated' 	=> date("Y-m-d H:i:s")
		);

		$this->db->where('user_id', $user_id);
		$this->db->update('phone_verify', $query);
		return true;
	}

	/*** END LOGIN METHODS ***/




}
?>
<?php
/*
 * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
 * $algorithm - The hash algorithm to use. Recommended: SHA256
 * $password - The password.
 * $salt - A salt that is unique to the password.
 * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
 * $key_length - The length of the derived key in bytes.
 * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
 * Returns: A $key_length-byte key derived from the password and salt.
 *
 * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
 *
 * This implementation of PBKDF2 was originally created by https://defuse.ca
 * With improvements by http://www.variations-of-shadow.com
 */
function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
{
    $algorithm = strtolower($algorithm);
    if(!in_array($algorithm, hash_algos(), true))
        trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
    if($count <= 0 || $key_length <= 0)
        trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);

    if (function_exists("hash_pbkdf2")) {
        // The output length is in NIBBLES (4-bits) if $raw_output is false!
        if (!$raw_output) {
            $key_length = $key_length * 2;
        }
        return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
    }

    $hash_length = strlen(hash($algorithm, "", true));
    $block_count = ceil($key_length / $hash_length);

    $output = "";
    for($i = 1; $i <= $block_count; $i++) {
        // $i encoded as 4 bytes, big endian.
        $last = $salt . pack("N", $i);
        // first iteration
        $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
        // perform the other $count - 1 iterations
        for ($j = 1; $j < $count; $j++) {
            $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
        }
        $output .= $xorsum;
    }

    if($raw_output)
        return substr($output, 0, $key_length);
    else
        return bin2hex(substr($output, 0, $key_length));
}
