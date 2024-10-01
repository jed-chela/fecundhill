<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

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
	//	$this->load->helper('encryption_helper');

		// Load Models
		$this->load->model('Users');
		$this->load->model('Personal');
		$this->load->model('Emailer');
		$this->load->model('Referrals');

		// Authenticate User
        if($this->Users->isActive()){
    //   		header("Location:" . base_url() . "profile"); die();
        }else{
        }
	}

	public function index()
	{
		$this->Users->remove();
		header("Location:" . base_url() . "auth/login");
	}


}
