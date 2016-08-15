<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Feed extends CI_Controller{
	public function index(){
		/*$latitude = 0;
		$longitude = 0;

		$this->load->model('post_model');
		var_dump($this->post_model->getPosts($latitude, $longitude));*/
		$this->load->model('category_model');
		$categories = $this->category_model->getCategories();
		$this->load->view("header/header");
		$this->load->view("header/advanced-search", ['categories'=>$categories]);
		$this->load->view("feed/feed");
		$this->load->view("footer/footer");	
	}

	public function newPost(){
		$data = array('title' => 'Teste', 
			'description' => 'Teste de feed de post', 
			'type' => '1', 
			'status' => '1', 
			'latitude' => '-25.4456399', 
			'longitude' => '-49.3602385', 
			'id_category' => '1', 
			'id_user' => '2', 
			'create_date' => date("Y-m-d H:i:s"));

		$this->load->model('post_model');
		$this->post_model->newPost($data);
	}

	public function quickSearch()
	{
		$search_term = $this->input->post('search');
		//TODO:search query matheus
	}

	public function getCategoryProperties()
	{

		/**
  					<div class="form-group"><label for="exampleInputPassword1">Password</label>
				    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
				  </div>
		**/
		$category = $this->input->get('category');
		$this->load->model('category_model');
		$properties =  $this->category_model->getProperties($category);
		$str_html = '';
		$inner_props_html = '';
		foreach ($properties as $key => $prop) {
			if($prop['id_category'] != null)
			{
				if($prop['property_value'] != '')
				{
					$str_html .= '<div class="form-group category-property has-subproperties" data-prop="'.$prop['property_name'].'"><label for="disabledTextInput">'. ucfirst($prop['property_name']) .'</label><br>';
					$json_prop = json_decode($prop['property_value']);
					foreach ($json_prop as $key => $temp) {
						$str_html .= '<label class="radio-inline"><input type="radio" class="property-radio" name="'.$prop['property_name'].'" id="'.$prop['property_name'].$key.'" value="'.$temp->name.'">'.ucfirst($temp->name).'</label>';
							foreach ($temp as $key2 => $value2) {
								if($key2 != 'name')
								{
									$inner_props_html .= '<div class="form-group '.$temp->name.'-sub"><div class="col-sm-10 '. $prop['property_name'] .' property-suboptions '.$temp->name.'-sub hidden"><label for="disabledTextInput">'. ucfirst($key2) .'</label><br><select multiple="multiple" class="inner-props" data-subprop="'.$key2.'" style="width:100%;">';
									foreach ($value2 as $key3 => $inner_prop) {
											$inner_props_html .= '<option value="'.$inner_prop->name.'">'.ucfirst($inner_prop->name).'</option>';
									}
									$inner_props_html .= '</select></div></div>';
								}
							}
					}
					$str_html .= '</div>';
					$str_html .= $inner_props_html;
				}else{
					$str_html .= '<div class="form-group category-property"><div class="col-sm-10"><label for="input-'.$prop['property_name'].'" >'. ucfirst($prop['property_name']).'</label>';
					$str_html .= '<input type="text" class="property-input form-control"  name="'.$prop['property_name'].'" id="input-'.$prop['property_name'].'" placeholder="'. ucfirst($prop['property_name']).'"></div></div>';
					
				}
			}

		}
		//echo json_encode($properties);
		echo $str_html;
	}

	public function search()
	{
		$properties = $this->input->post('properties');
		var_dump($properties);
		$this->load->model('category_model');


	    header('Content-Type: application/json');
	    echo json_encode( $properties );
	}
}
?>