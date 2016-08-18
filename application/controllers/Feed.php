<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Feed extends CI_Controller{

	public function __construct() {
		parent:: __construct();
		$this->load->helper("url");
		$this->load->library("pagination");
	}

	public function index(){

		$this->load->model('category_model');
		$categories = $this->category_model->getCategories();
		$this->load->view("header/header");
		$this->load->view("header/advanced-search", ['categories'=>$categories]);
		$this->load->view("feed/feed");
		$this->load->view("footer/footer");	
	}

	public function quickSearch()
	{
		//$this->output->enable_profiler(TRUE);
		$config = array();
		$config["per_page"] = 20;
		$CI =& get_instance();
    	$url = $CI->config->site_url($CI->uri->uri_string());
		$config['reuse_query_string'] = TRUE;
		$config['prefix'] = 'feed/quickSearch/';
		$config['enable_query_strings'] = TRUE;
		$config['query_string_segment'] = 'page';
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$query_data = $this->input->get();
		if(count($query_data))
		{
			$this->load->model('post_model');
			$res = $this->post_model->quick_search($query_data, $config["per_page"], $page);
			$data["results"] = $res['results'];
			$data['total'] = $res['total'];
			$config["total_rows"] = $res['total'];
			$this->pagination->initialize($config);
			$config["base_url"] = base_url() . "index.php/feed/search";
			echo json_encode($data);
		}else{
			echo json_encode(array());
		}
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
					$str_html .= '<div class="form-group form-custom category-property has-subproperties" data-prop="'.$prop['property_name'].'"><label for="disabledTextInput">'. ucfirst($prop['property_name']) .'</label><br>';
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
		/**
			Instrução para testes do trabalho do Grupo 4 (implementação da busca e feed)
			1. Garanta que o url do projeto (config.php - variável $config['base_url']) está correta - indicio que não está: assets não encontrados no load
			2. Garanta que você rodou o comando composer install na raiz do projeto para instalar os pacotes necessários para que o projeto rode - os pacotes Faker (para gerar falsas informações para testes) e Gravatar (associar imagens de avatar aos usuarios) foram instalados
			3. Rode o arquivo public/sql/longinus.sql para criação de tabelas
			4. Rode os caminhos /category/seed e /post/seed para que sejam criados a massa de dados de teste
			5. Thats it!
		**/


		//$this->output->enable_profiler(TRUE);
		$config = array();
		$config["per_page"] = 5;
		$CI =& get_instance();
    	$url = $CI->config->site_url($CI->uri->uri_string());
		$config["first_url"] = $_SERVER['QUERY_STRING'] ? 'feed/search/?'.$_SERVER['QUERY_STRING'] : $url;
		$config['reuse_query_string'] = TRUE;
		$config['prefix'] = 'feed/search/';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['enable_query_strings'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$query_data = $this->input->get();
		if(count($query_data))
		{
			$this->load->model('post_model');
			$this->session->userdata('search_query', json_encode($query_data));
			$res = $this->post_model->advanced_search($query_data, $config["per_page"], $page);
			$data["results"] = $res['results'];
			$data['total'] = $res['total'];
			$config["total_rows"] = $res['total'];
			$this->pagination->initialize($config);
			$data["links"] = $this->pagination->create_links();
			$data['parameters'] = $res["params"];
			$config["base_url"] = base_url() . "index.php/feed/search";
			$this->load->model('category_model');
			$categories = $this->category_model->getCategories();
			$this->load->view("header/header");
			$this->load->view("header/advanced-search", ['categories'=>$categories]);
			$this->load->view("feed/search",array('data'=>$data, 'query_data'=>$query_data));
			$this->load->view("footer/footer");
		}else{

			$this->load->model('category_model');
			$categories = $this->category_model->getCategories();
			$this->load->view("header/header");
			$this->load->view("header/advanced-search", ['categories'=>$categories]);
			$this->load->view("feed/search",array());
			$this->load->view("footer/footer");
		}


		//$this->load->view("example1", $data);
		//var_dump($data["results"]);
	    //header('Content-Type: application/json');
		//exit(json_encode($posts));
	}


	public function recent_post()
	{
		$this->load->model('post_model');
		$this->post_model->recent_post();
	}
}
?>