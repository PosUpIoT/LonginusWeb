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
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$retorno = $this->user_model->login($email,$password);
		if($retorno)
		{
			redirect('/home');
		}
		$this->session->set_flashdata('message', 'Não foi encontrado o usuário!');
		redirect($this->agent->referrer());
	}
	public function register()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$password_conf = $this->input->post('password_conf');
		if($password == $password_conf)
		{
			$retorno = $this->user_model->login($email,$password);
			if($retorno)
			{
				redirect('/home');
			}else{
				
			}
			$this->session->set_flashdata('message', 'Não foi encontrado o usuário!');
			$this->session->set_flashdata('email', $this->input->post('email'));
			redirect($this->agent->referrer());	
		}
		$this->session->set_flashdata('message', 'A senha de confirmação é diferente');
		$this->session->set_flashdata('email', $this->input->post('email'));
		redirect($this->agent->referrer());	

	}

	public function logout()
	{
		if($this->session->has_userdata('logged_in')) {
			$retorno = $this->user_model->logout();
			if($retorno)
			{
				redirect('/home');
			}
			//TODO:SHOW ERROR
		}
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
                'facebook' => NULL,
                'google' => NULL,
                'twitter' => NULL,
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

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */ ?>