<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

	/** 


	**/

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
		return $this->db->insert_id();
	}

	public function recent_post()
	{

		$max_distance = 30;
		$pos = $this->geolocate();
		//aux fields categories.name, post_category_data.value as property_value, category_properties.property_name
		$query = $this->db->distinct()->select('SQL_CALC_FOUND_ROWS posts.id, posts.title, posts.type, posts.description, pictures.path, posts.status, posts.latitude, posts.longitude, categories.name as category, posts.create_date, users.name as user, users.email, ( 6371 * acos( cos( radians('.$pos['lat'].') ) * cos( radians( posts.latitude ) ) * cos( radians( posts.longitude ) - radians('.$pos['lng'].') ) + sin( radians('.$pos['lat'].') ) * sin( radians( posts.latitude ) ) ) ) AS distance', FALSE)->from('posts')
				->join('users', 'posts.id_user = users.id', 'inner')
				->join('categories', 'posts.id_category = categories.id', 'inner')
				->join('post_category_data', 'post_category_data.id_post = posts.id', 'inner')
				->join('category_properties', 'category_properties.id_category = categories.id', 'inner')
				->join('pictures', 'posts.id = pictures.id_post', 'inner')
				->where('pictures.highlighted', 1)
				->where('posts.status !=', 3);
		$query->having('distance <= '.$max_distance);
		$rows = $query->order_by('posts.create_date', 'DESC')->limit(10)->get();
		$results = $rows->result_array();
		$this->db->flush_cache();
		return $results;
	}

	public function feed($per_page, $page){
		try{
			$pos = $this->geolocate();
			//aux fields categories.name, post_category_data.value as property_value, category_properties.property_name
			$query = $this->db->distinct()->select('SQL_CALC_FOUND_ROWS posts.id, posts.title, posts.type, posts.description, pictures.path, posts.status, posts.latitude, posts.longitude, categories.name as category, posts.create_date, users.name as user, users.email,( 6371 * acos( cos( radians('.$pos['lat'].') ) * cos( radians( posts.latitude ) ) * cos( radians( posts.longitude ) - radians('.$pos['lng'].') ) + sin( radians('.$pos['lat'].') ) * sin( radians( posts.latitude ) ) ) ) AS distance', FALSE)->from('posts')
					->join('users', 'posts.id_user = users.id', 'inner')
					->join('categories', 'posts.id_category = categories.id', 'inner')
					->join('post_category_data', 'post_category_data.id_post = posts.id', 'inner')
					->join('category_properties', 'category_properties.id_category = categories.id', 'inner')
					->join('pictures', 'posts.id = pictures.id_post', 'inner')
					->where('pictures.highlighted', 1)
					->where('posts.status !=', 3);
			$rows = $query->order_by('posts.create_date', 'DESC')->limit($per_page, $page)->get();
			$results = $rows->result_array();
			$query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
			$objCount = $query->result_array();
			$total = $objCount[0]['Count'];
			$this->db->flush_cache();
			return array('results'=>$results, 'total'=> $total);
		}catch (Exception $e)
		{
			return $e->getMessage();
		}
	}



	public function geolocate()
	{


		$url = "http://ip-api.com/json";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response);
		return array('lat'=> $response_a->lat, 'lng'=>$response_a->lon);

	}

	public function quick_search($data, $per_page, $page)
	{
		try{
			$max_distance = 30;
			$pos = $this->geolocate();
			//aux fields categories.name, post_category_data.value as property_value, category_properties.property_name
			$query = $this->db->distinct()->select('SQL_CALC_FOUND_ROWS posts.id, posts.title, posts.type, posts.description, pictures.path, posts.status, posts.latitude, posts.longitude, categories.name as category, posts.create_date, users.name as user, users.email, ( 6371 * acos( cos( radians('.$pos['lat'].') ) * cos( radians( posts.latitude ) ) * cos( radians( posts.longitude ) - radians('.$pos['lng'].') ) + sin( radians('.$pos['lat'].') ) * sin( radians( posts.latitude ) ) ) ) AS distance', FALSE)->from('posts')
					->join('users', 'posts.id_user = users.id', 'inner')
					->join('categories', 'posts.id_category = categories.id', 'inner')
					->join('post_category_data', 'post_category_data.id_post = posts.id', 'inner')
					->join('category_properties', 'category_properties.id_category = categories.id', 'inner')
					->join('pictures', 'posts.id = pictures.id_post', 'inner')
					->where('pictures.highlighted', 1)
					->where('posts.status !=', 3);

			$keywords = explode(' ', $data['q']);
			foreach ($keywords as $keyword)
			{
				$keyword = trim($keyword);
				$query->like('posts.title', $keyword);
				$query->or_like('post_category_data.value',  $keyword);
			}

			$query->having('distance <= '.$max_distance);
			$rows = $query->limit($per_page, $page)->get();
			$results = $rows->result_array();
			$query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
			$objCount = $query->result_array();
			$total = $objCount[0]['Count'];
			$this->db->flush_cache();
			return array('results'=>$results, 'total'=> $total);
		}catch (Exception $e)
		{
			return $e->getMessage();
		}
	}

	public function advanced_search($data, $per_page, $page)
	{
		try{
			$params = [];
			$max_distance = round(($data['rad']/1000),2);
			$params[] = array('distance'=>$max_distance.'km');
			//aux fields categories.name, post_category_data.value as property_value, category_properties.property_name
			$query = $this->db->distinct()->select('SQL_CALC_FOUND_ROWS posts.id, posts.title, posts.type, posts.description, pictures.path, posts.status, posts.latitude, posts.longitude, categories.name as category, posts.create_date, users.name as user, users.email, ( 6371 * acos( cos( radians('.$data['lat'].') ) * cos( radians( posts.latitude ) ) * cos( radians( posts.longitude ) - radians('.$data['lng'].') ) + sin( radians('.$data['lat'].') ) * sin( radians( posts.latitude ) ) ) ) AS distance', FALSE)->from('posts')
			->join('users', 'posts.id_user = users.id', 'inner')
			->join('categories', 'posts.id_category = categories.id', 'inner')
			->join('post_category_data', 'post_category_data.id_post = posts.id', 'inner')
			->join('category_properties', 'category_properties.id_category = categories.id', 'inner')
			->join('pictures', 'posts.id = pictures.id_post', 'inner')
			->where('posts.type', intval($data['searchType']))
			->where('pictures.highlighted', 1)
			->where('posts.status !=', 3)
			->having('distance <= '.$max_distance);
			if(isset($data['category']) && $data['category'] != '')
			{
				$query->where('categories.name', $data['category']);
				$params[] = array('category'=>$data['category']);
			}
			if(isset($data['search']) && $data['search'] != '')
			{
				$query->like('posts.title', $data['search'])->like('posts.description', $data['search'])->like('users.email', $data['search'])->like('users.name', $data['search']);
				$params[] = array('term'=>$data['search']);
			}
			if(isset($data['properties']))
			{
				$properties = json_decode($data['properties'], true);
				if(count($properties) > 0)
				{
					foreach ($properties as $key => $property) {
						if(isset($property['value']))
						{
							if($property['value'] != '')
							{
								//category_properties.property_name
								//post_category_data.value as property_value
								$query->like('category_properties.property_name', $property['property'])->like('post_category_data.value', $property['value']);
								$params[] = array($property['property']=>$property['value']);
								if(isset($property['subproperties']))
								{
									foreach ($property['subproperties'] as $key2 => $subproperty) {
										if(isset($subproperty['value']))
										{
											if(is_array($subproperty['value']))
											{
												foreach ($subproperty['value'] as $key3 => $subproperty_val) {

													$query->like('post_category_data.value', '"'.$subproperty['name'].'":"'.$subproperty_val.'"');
													$params[] = array($subproperty['name']=>$subproperty_val);

												}
											}else{
												$query->like('post_category_data.value', '"'.$subproperty['name'].'":"'.$subproperty['value'].'"');
												$params[] = array($subproperty['name']=>$subproperty['value']);
											}
										}
									}
								}
							}
						}
					}
				}
			}
			$rows = $query->limit($per_page, $page)->get();
			$results = $rows->result_array();
			$query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
			$objCount = $query->result_array();
			$total = $objCount[0]['Count'];
			$this->db->flush_cache();
			return array('results'=>$results, 'total'=> $total,'params'=>$params);
		}catch (Exception $e)
		{
			return $e->getMessage();
		}
	}
}

/* End of file Post_model.php */
/* Location: ./application/models/Post_model.php */