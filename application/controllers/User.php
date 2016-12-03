<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();

        // initiate faker
        $this->faker = Faker\Factory::create();
		$this->load->model('user_model');
	}

	public function index() {
		
		$retorno = $this->user_model->get_users();
		var_dump($retorno);
	}

	public function auth()
	{
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_check_email_exists');
		$this->form_validation->set_rules('password', 'Senha', 'required|min_length[6]');
        if ($this->form_validation->run() == FALSE)
        {
			$this->load->view('header/header');
			$this->load->view('login/login');
			$this->load->view('footer/footer');
        }
        else
        {
		 if($this->user_model->login($this->input->post('email'), $this->input->post('password')) == true){
		 	redirect('/home');
		 }else{
		 	$this->session->set_flashdata('message', 'Senha incorreta!');
			redirect($this->agent->referrer());
		 }
        }

	}

	public function facebook_auth()
	{
		$data['user'] = array();
		// Check if user is logged in
		if ($this->facebook->is_authenticated()  && $this->session->has_userdata('logged_in') == FALSE)
		{
			// User logged in, get user details
			$user = $this->facebook->request('get', '/me?fields=name,birthday,location,email,friends.limit(8),id');

			//$this->facebook->destroy_session();

			if (!isset($user['error']))
			{
				$data['user'] = $user;
				$retorno = $this->user_model->facebook_login($user, $this->facebook->is_authenticated());				
				if($retorno == true)
				{
					//redirect('/home');
					$this->session->set_flashdata('message', 'Usuário registrado com sucesso!');
					redirect('/home/login');
				}else{
					$this->session->set_flashdata('message', $e);
					
					$this->session->set_flashdata('message', 'Autenticação via Facebook falhou! Tente novamente ou contate o administrador!');
					redirect($this->agent->referrer());					
				}
			}
		}

	}

	public function register()
	{
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Nome', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required|min_length[6]');
		$this->form_validation->set_rules('password_conf', 'Confirmação de Senha', 'required|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        if ($this->form_validation->run() == FALSE)
        {
			$this->load->view('header/header');
			$this->load->view('login/signup');
			$this->load->view('footer/footer');
        }
        else
        { 
				$data = array(
	            	'role'=>1,
	            	'name'=> $this->input->post('name'),
	                'email' => $this->input->post('email'),
	                'password' => md5($this->input->post('password')), // run this via your password hashing function
	                'phone' => '',
	                'provider'=>'internal',
	                'create_date' => date('Y-m-d H:i:s')
	            );
	 
	            $retorno = $this->user_model->insert_user($data);
				if($retorno)
				{
					$this->user_model->login($this->input->post('email'),$this->input->post('password'));
					redirect('/home');
					//$this->session->set_flashdata('message', 'Usuário registrado com sucesso!');
					//redirect('/home/login');
				}else{
					$this->session->set_flashdata('email', $this->input->post('email'));
					$this->session->set_flashdata('name', $this->input->post('name'));
					redirect($this->agent->referrer());					
				}
		}
	}

	public function logout()
	{
		if($this->session->has_userdata('logged_in')) {
			$retorno = $this->user_model->logout();
			//TODO:eliminar acesso API-Longinus
		}
		redirect('/home');
	}

	public function facebook_logout()
	{
		if($this->facebook->is_authenticated()) {
			$this->facebook->destroy_session();
			//TODO:eliminar acesso API-Longinus
		}
		redirect('/home');
	}

	function seed()
    {
        $this->_seed_users(25);
    }
 
    /**
     * seed users
     *
     * @param int $limit
     */
    function _seed_users($limit)
    {
        echo "seeding $limit users";
        for ($i = 0; $i < $limit; $i++) {
            echo ".";
 
            $data = array(
            	'role'=>1,
            	'name'=>$this->faker->name,
                'email' => $this->faker->email,
                'facebook_id' => NULL,
                'facebook_access_token'=>'',
                'facebook_refresh_token'=>'',
                'password' => md5('thithi'), // run this via your password hashing function
                'phone' => $this->faker->phoneNumber,
                'create_date' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s')
            );
 
            $this->user_model->insert_user($data);
        }
 
        echo PHP_EOL;
    }
 
    private function _truncate_db()
    {
        $this->user_model->truncate();
    }

	public function check_email_exists($email)
	{

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
	  if ($this->user_model->check_email_exists($email,'internal') == FALSE)
	  {

        $this->form_validation->set_message('check_email_exists', 'The user was not found in our database!');
	    return FALSE;
	  }
	  else
	  {
	    return TRUE;
	  }
	}
}

/* End of file User.php */
/* Location: ./application/controllers/User.php */ ?>