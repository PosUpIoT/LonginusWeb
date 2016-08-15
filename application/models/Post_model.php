<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

	public function get_posts($latitude, $longitude) {
		$query = $this->db->get('posts');
		return $query->result_array();
	}

	public function get_post($id) {
		$data = ['id' => $id];
		$query = $this->db->get_where('posts', $data);
		return $query->row_array();
	}

	public function new_post($data) {
		$this->db->insert('posts', $data);
	}

}

/* End of file Post_model.php */
/* Location: ./application/models/Post_model.php */