<?php
Class Category_model extends CI_Model{

	public function getCategories(){
		$queryGroup = $this->db->get('categories');
		return $queryGroup->result_array();
	}

	public function getProperties($category)
	{
		$query = $this->db->select('categories.*, category_properties.*')
			->from('categories')
			->join('category_properties', 'categories.id = category_properties.id_category', 'left')
			->where(array('categories.name' => $category))
			->get();
		return $query->result_array();
	}

	public function new_category_data($data)
	{
		$this->db->insert('post_category_data', $data);
		$new_post_property = $this->db->insert_id();		
	}

	public function new_category($data)
	{
		$this->db->insert('categories', $data);
	}

	public function new_category_property($data)
	{
		$this->db->insert('post_category_data', $data);
	}	
}
?>