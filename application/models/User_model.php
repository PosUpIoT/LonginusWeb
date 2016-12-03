<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_users() {
		$query = $this->db->query('SELECT * FROM users');
		$users = $query->result_array();
		return $users;
	}	

	public function insert_user($data) {
		return $this->db->insert('users', $data);
	}

	public function facebook_login($user, $access_token)
	{

		try{
		    //checar se ja existe um user com provider facebook e este ID 
			if($this->check_social_network_exists($user['id'],'facebook'))
			{
				//refresh user
				$this->db->set('name', $user['name']);
				$this->db->set('email', $user['email']);
				$this->db->set('avatar', 'https://graph.facebook.com/'.$user['id'].'/picture?type=large');
				$this->db->set('social_network_access_token', $access_token);
				$this->db->where('social_network_id', $user['id']);
				$this->db->where('provider', 'facebook');
				$this->db->update('users'); 
			}else{
				//new user
				$data = array(
			            	'role'=>1,
			            	'name'=> $user['name'],
			                'email' => $user['email'],
			                'social_network_id' => $user['id'],
			                'social_network_access_token'=>$access_token,
			                'password' => '',
			                'phone' => '',
			                'provider' => 'facebook',
			                'avatar'=>'https://graph.facebook.com/'.$user['id'].'/picture?type=large',
			                'create_date' => date('Y-m-d H:i:s')
			    );
			    $retorno = $this->user_model->insert_user($data);
			}
		    //logar
			$data = array('social_network_id' => $user['id'], 'provider'=>'facebook');
			$query = $this->db->get_where('users', $data);

			if($query->num_rows() > 0){
				$newdata = array(
		        'name'  => $query->first_row()->name,
		        'email'     => $query->first_row()->email,
		        'src'=>'facebook',
		        'logged_in' => true
				);
				$this->session->set_userdata($newdata);
				return true;
			}
		}catch(Exception $e){
			return $e;
		}

	}

	public function login($email, $password) {
		$data = array('email' => $email, 'password' => md5($password), 'provider'=>'internal');
		$query = $this->db->get_where('users', $data);

		if($query->num_rows() > 0){
			$newdata = array(
	        'name'  => $query->first_row()->name,
	        'email'     => $query->first_row()->email,
	        'src'=>'internal',
	        'logged_in' => true
			);
			$this->session->set_userdata($newdata);
			return true;
		}

		return false;
	}

	public function check_email_exists($email,$provider)
	{
		$data = array('email' => $email,'provider'=>$provider);
		$query = $this->db->get_where('users', $data);
	    if($query->num_rows() == 1)
	    {
	        return TRUE;
	    }
	    else
	    {
	        return FALSE;
	    }
	}

	public function check_social_network_exists($id,$provider)
	{
		$data = array('social_network_id' => $id,'provider'=>$provider);
		$query = $this->db->get_where('users', $data);
	    if($query->num_rows() == 1)
	    {
	        return TRUE;
	    }
	    else
	    {
	        return FALSE;
	    }
	}

	public function logout() {
		try{

			if($this->session->userdata('src') == "facebook")
			{
				$this->facebook->destroy_session();
			}
			$newdata = array(
			    'username',
			    'email',
	        	'src',
			    'logged_in'
			);
			$this->session->unset_userdata($newdata);
			return true;
		}catch(Exception $e)
		{
			return false;
		}
	}

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */