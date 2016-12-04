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

	public function insert_friendship($user, $friend)
	{
		$user_exists = $this->check_social_network_exists($user, 'facebook');
		$friend_exists = $this->check_social_network_exists($friend, 'facebook');

		if($user_exists && $friend_exists) {
			$user_data = $this->get_user_by_facebook_id($user);
			$friend_data = $this->get_user_by_facebook_id($friend);

			if(!$this->check_friendship($user_data['id'], $friend_data['id'])) {
				$friendship1 = [
					'user_id' => $user_data['id'],
					'friend_id' => $friend_data['id'],
					'create_date' => date('Y-m-d H:i:s')
				];

				$this->db->insert('user_friends', $friendship1);
			}

			if(!$this->check_friendship($friend_data['id'], $user_data['id'])) {
				$friendship2 = [
					'user_id' => $friend_data['id'],
					'friend_id' => $user_data['id'],
					'create_date' => date('Y-m-d H:i:s')
				];

				$this->db->insert('user_friends', $friendship2);
			}

			return TRUE;
		}

		return FALSE;
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

	public function check_friendship($userId, $friendId)
	{
		$data = array('user_id' => $userId, 'friend_id' => $friendId);
		$query = $this->db->get_where('user_friends', $data);

	    if($query->num_rows() == 1) {
	        return TRUE;
	    } else {
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

	public function get_user_by_facebook_id($facebook_id)
	{
		$data = array('social_network_id' => $facebook_id, 'provider'=>'facebook');
		$query = $this->db->get_where('users', $data);
		return $query->row_array();
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