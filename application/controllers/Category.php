<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function index()
	{
		
	}

	public function seed()
	{
		$this->load->model('category_model');


		$this->category_model->new_category(array('name'=>'people'));
		$this->category_model->new_category(array('name'=>'vehicles'));
		$this->category_model->new_category(array('name'=>'animals'));
		
		$this->category_model->new_category_property(array(
			'id_category'=>'3',
			'property_name'=>'type',
			'property_value'=>'[ { "name": "dog", "breed" : [ { "name": "Chihuaua" }, { "name": "Pastor Alemao" }, { "name": "Husky" }, { "name": "Hotweiller" } ], "color":[ { "name": "black" }, { "name": "white" }, { "name": "brown" } ] }, { "name": "cat", "color":[ { "name": "black" }, { "name": "white" }, { "name": "brown" } ] }, { "name": "bird", "color":[ { "name": "black" }, { "name": "white" }, { "name": "yellow" } ] }, { "name": "other" } ]'
		));
		$this->category_model->new_category_property(array(
			'id_category'=>'2',
			'property_name'=>'type',
			'property_value'=>'[{"name":"car","color":[{"name":"black"},{"name":"white"},{"name":"brown"}],"brand":[{"name":"ford"},{"name":"renault"},{"name":"honda"},{"name":"chrysler"}]},{"name":"motorcycle","color":[{"name":"black"},{"name":"white"},{"name":"yellow"}],"brand":[{"name":"harley davidson"},{"name":"suzuki"},{"name":"honda"}]},{"name":"other"}]'
		));
		$this->category_model->new_category_property(array(
			'id_category'=>'2',
			'property_name'=>'plate',
			'property_value'=>''
		));

		$this->category_model->new_category_property(array(
			'id_category'=>'1',
			'property_name'=>'sex',
			'property_value'=>'[{"name":"male"},{"name":"female"}]'
		));
		$this->category_model->new_category_property(array(
			'id_category'=>'1',
			'property_name'=>'skin color',
			'property_value'=>'[{"name":"black"},{"name":"caucasian"},{"name":"yellow"}]'
		));
		$this->category_model->new_category_property(array(
			'id_category'=>'1',
			'property_name'=>'age',
			'property_value'=>''
		));		
		$this->category_model->new_category_property(array(
			'id_category'=>'1',
			'property_name'=>'height',
			'property_value'=>''
		));

	}

}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */ ?>