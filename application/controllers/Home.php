<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index() {
		$this->load->view('header/header');
		$this->load->view('home');
		$this->load->view('footer/footer');
	}

	public function login() {
		if(!$this->session->has_userdata('logged_in') || $this->session->userdata('logged_in') == FALSE ) {
			$this->load->view('header/header');
			$this->load->view('login/login');
			$this->load->view('footer/footer');
		}else{
			redirect('/home');
		}
	}

	public function account()
	{
		if($this->session->has_userdata('logged_in') && $this->session->userdata('logged_in') == TRUE ) {
			$this->load->view('header/header');
			$this->load->view('login/account');
			$this->load->view('footer/footer');
		}else{
			redirect('/home/login');
		}
	}

	public function signup() {
		if(!$this->session->has_userdata('logged_in') || $this->session->userdata('logged_in') == FALSE ) {		
			$this->load->view('header/header');
			$this->load->view('login/signup');
			$this->load->view('footer/footer');
		}else{
			redirect('/home');
		}
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */