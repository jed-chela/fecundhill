<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');	

	/* Input Cleansing/Sterilization */
	function protect($string){
		$string = htmlspecialchars(trim($string) , ENT_QUOTES, 'UTF-8') ;
		return $string;
	}
	function protectNoUTF8($string){
		$string = htmlspecialchars(trim($string ), ENT_QUOTES) ;
		return $string;
	}
	function protectPlain($string){
		$string = htmlspecialchars(trim($string )) ;
		return $string;
	}
	function protectNoTrim($string){
		$string = htmlspecialchars($string , ENT_QUOTES, 'UTF-8') ;
		return $string;
	}
	function noProtect($string){
		return trim($string ) ;
	}
    function protectExactText($str){
		$str = protectNoTrim($str);
		return keepStringForm($str) ;
	}
	function decodeURLEncodedString($string){
		return rawurldecode($string) ;
	}
	function ajaxTxtPostProtect($str){
		$str = $str ;
		
		$len = strlen($str) ;
		
		if($str[0] == "#"){
			if($str[$len - 1] == "?"){
				$str = substr($str,1,($len - 2)) ;
				$cryp = new nebula_cryptic() ;
				$str = $cryp->decrypt($str) ;
				$str = protect($str);
				return keepStringForm($str) ;
			}else{ 
				//log error
				return 0; 
			}
		}else{ 
			//log error
			return 0; 
		}
	}
	function keepStringForm($content){
		if($content != ""){
			$content = str_replace("\n","<br>",$content) ;
			$content = str_replace("  "," "."&nbsp;",$content) ;
		}
		return $content ;
	}
	function getStringTextForm($content){
		if($content != ""){
			$content = str_replace("<br>","\n",$content) ;
			$content = str_replace(" "."&nbsp;", "  ", $content) ;
			$content = str_replace("&quot;", '"', $content) ;
		}
		return $content ;
	}


	/* Confirm If user is Logged in */
	function confirmLoginStat(){
		if((isset($_SESSION['ordering_app_fxgv89v2_LOGXVCDcrypt'])) && ($_SESSION['ordering_app_fxgv89v2_LOGXVCDcrypt_logged_in'] == 1) ) {
			return 1 ;
			}
		else return 0 ;
	}
	/* Get Logged in user_id */
	function get_logged_in_user_id(){
		if(confirmLoginStat() == 1){
			return $_SESSION['ordering_app_fxgv89v2_LOGXVCDcrypt'] ;
		}else{
			return "" ;
		}
	}
	
	/* ID Generators */
	function checkAnId($id,$id_tablename,$id_fieldname){
		$ci = get_codeigniter_this() ;
		$query = "SELECT $id_fieldname FROM $id_tablename WHERE $id_fieldname = '$id' " ;
		$query = $ci->db->query($query) ;
		if ($query->num_rows() > 0)
		{
			return true ;
		}
		return false ;
	}
	function createAnId($id_tablename,$id_fieldname){
		$id = ( mt_rand(10, 999) * 5 ) + mt_rand(1020025005, 1920025005) ; //10 digits max	
		$chkem = checkAnId($id,$id_tablename,$id_fieldname) ;
		while($chkem != false){ 
			$id = ( mt_rand(2, 1000) * 5 ) + mt_rand(100, 9990000999) ;	 //10 digits max
			$chkem = checkAnId($id,$id_tablename,$id_fieldname) ;
			}
		return $id ;
	}
	function createAnIdSmall($id_tablename,$id_fieldname){
		$id = ( mt_rand(10, 999) * 3 ) + mt_rand(100, 99999) ; //10 digits max	
		$chkem = checkAnId($id,$id_tablename,$id_fieldname) ;
		while($chkem != false){ 
			$id = ( mt_rand(2, 1000) * 5 ) + mt_rand(100, 9990000999) ;	 //10 digits max
			$chkem = checkAnId($id,$id_tablename,$id_fieldname) ;
			}
		return $id ;
	}

	/* Get Codeigniter $this Object */
	function get_codeigniter_this(){
		$ci =& get_instance() ;
		return $ci ;
	}

	/* Regular Session handlers */
	function setLastUrl(){
		$url = $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'] ;
		setcookie("last_url","$url");
	}
	function getLastUrl($val = 0){
		if(isset($_COOKIE['last_url'])){
			return protect($_COOKIE['last_url'] ) ;
		}else{ 
			if($val == 1){ return "search_projects.php" ;
			}else return 0 ; 
		}
	}
	
	/* Misc */
	function getSelect($name,$lower,$upper,$inc,$class=""){
		$o = "<select name='$name' class='$class'>" ;
			$o .= "<option value=\" \">-- SELECT --</option>" ;
			for($i = $lower; $i <= $upper; $i += $inc){
				$o .= "<option value='$i'>$i</option>" ;
			}
		$o .= "</select>" ;
		return $o ;
	}
	function getSelectOpts($num,$opts,$texts,$name='',$class=''){
		$o  = "<select name='$name' class='$class'>" ;
			for($i = 0; $i < $num; $i++){
				$o .= "<option value='".$opts[$i]."'>".$texts[$i]."</option>" ;
			}
		$o .= "</select>" ;
		return $o ;
	}
	function returnProjectType($int){
			switch($int){
				case 1: return "Postgraduate" ; break ;
				case 2: return "Undergraduate" ; break ;
				default: return 0; break ;
			}
		}
	function returnPageHref($val){
		switch($val){
			case "upl": return "upload_project.php" ; break ;
			case "uplres": return "upload_project.php" ; break ;
			case "srch": return "search_projects.php" ; break ;
			default: return "index.php" ;break ;
		}
	}
	function firstLetterToCaps($str){
		if($str != ""){
			$str[0] = strtoupper($str[0]) ;
		}
		return $str ;
	}
	function spaceAfterComma($str){
		$str = str_replace(",  ",",",$str);
		$str = str_replace(", ",",",$str);
		$str = str_replace(",",", ",$str);
		return $str ;
	}

	function curl_post($url, $post, $options){
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
//		curl_setopt($ch, CURLOPT_POSTFIELDS,
//		            $post);

		// In real life you should use something like:
		 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close($ch);
//		print_r($server_output);
		// Further processing ...
		if ($server_output == "OK") {
			return true;
		}
		return false;
	}
/* End of file main_helper.php */
/* Location: ./application/helpers/main_helper.php */