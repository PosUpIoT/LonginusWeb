<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {

	public function __construct() {
		parent::__construct();

        // initiate faker
        $this->faker = Faker\Factory::create();
		$this->load->model('post_model');
	}

	public function index()
	{
		
	}

	public function seed()
    {
        $this->_seed_posts(5000);
    }
 
    /**
     * seed users
     *
     * @param int $limit
     */

    public $vehicle_type = ['car','motorcycle','other'];
    public $car_brands = ["ford","renault","honda","chrysler"];
    public $moto_brands = ["harley davidson","suzuki","honda"];
    public $animal_type = ['dog','cat','bird','other'];
    public $dog_breeds = ["Pastor Alemao","Husky","Hotweiller"];

    public function _seed_posts($limit)
    {
        echo "seeding $limit posts";
        for ($i = 0; $i < $limit; $i++) {
            echo ".";
            $cat = $this->faker->numberBetween(1,3);
			//Curitiba -25.4738334,-49.2686818


			if($this->faker->boolean(22))
			{
				//CURITIBA
				$lat = -25 - $this->faker->randomFloat(7, 0.473, 0.48);
				$lng = -49 - $this->faker->randomFloat(7, 0.268, 0.27);
				$data = array(
						'title' => 'CURIT '.$this->faker->catchPhrase,
						'description' => $this->faker->paragraph(3),
						'type' => $this->faker->numberBetween(1,2),
						'status' => $this->faker->numberBetween(1,2),
						'latitude' => $lat,
						'longitude' => $lng,
						'id_category' => $cat,
						'id_user' => '1',
						'create_date' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'));
			}else{
				//OUTROS
				$data = array(
						'title' => $this->faker->catchPhrase,
						'description' => $this->faker->paragraph(3),
						'type' => $this->faker->numberBetween(1,2),
						'status' => $this->faker->numberBetween(1,2),
						'latitude' => $this->faker->latitude,
						'longitude' => $this->faker->longitude,
						'id_category' => $cat,
						'id_user' => '1',
						'create_date' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'));
			}

			$this->load->model('category_model');
			$id = $this->post_model->new_post($data);
			if($cat == 1)
			{
				//people
				if($this->faker->boolean(40))
				{
					//sex
					if($this->faker->boolean(50))
					{
						$this->category_model->new_category_property(array('id_category_properties'=>5,'id_post'=>$id, 'value'=> 'male'));
					}else{
						$this->category_model->new_category_property(array('id_category_properties'=>5,'id_post'=>$id, 'value'=> 'female'));
					}
				}
				if($this->faker->boolean(40))
				{
					//skin
					if($this->faker->boolean(33))
					{
						$this->category_model->new_category_property(array('id_category_properties'=>6,'id_post'=>$id, 'value'=> 'black'));
					}else if($this->faker->boolean(33)){
						$this->category_model->new_category_property(array('id_category_properties'=>6,'id_post'=>$id, 'value'=> 'caucasian'));
					}else{
						$this->category_model->new_category_property(array('id_category_properties'=>6,'id_post'=>$id, 'value'=> 'yellow'));
					}
				}
				if($this->faker->boolean(40))
				{
					//age
					$this->category_model->new_category_property(array('id_category_properties'=>7,'id_post'=>$id, 'value'=> 'black'));
				}
				if($this->faker->boolean(30))
				{
					//height	
					$this->category_model->new_category_property(array('id_category_properties'=>8,'id_post'=>$id, 'value'=> $this->faker->randomFloat(2,1.30, 1.9)));
				}

			}else if($cat == 2){
				//vehicles
				//Plate
				$this->category_model->new_category_property(array('id_category_properties'=>3,'id_post'=>$id, 'value'=>
					strtoupper($this->faker->randomLetter.$this->faker->randomLetter.$this->faker->randomLetter). '-'. $this->faker->randomNumber(4)));
				//Type
					$type = $this->vehicle_type[$this->faker->numberBetween(0,2)];
					switch ($type) {
						case 'car':
							//Color
							$color = $this->faker->safeColorName;
							//Brand
							$brand = $this->car_brands[$this->faker->numberBetween(0,3)];
							$this->category_model->new_category_property(array('id_category_properties'=>2,'id_post'=>$id, 
								'value'=> json_encode(['type'=>$type,'brand'=>$brand,'color'=>$color ])
							));
							break;
						
						case 'motorcycle':
							//Color
							$color = $this->faker->safeColorName;
							//Brand
							$brand = $this->moto_brands[$this->faker->numberBetween(0,2)];
							$this->category_model->new_category_property(array('id_category_properties'=>2,'id_post'=>$id, 
								'value'=> json_encode(['type'=>$type,'brand'=>$brand,'color'=>$color ])
							));
							break;

						case 'other':
							# code...
							$this->category_model->new_category_property(array('id_category_properties'=>2,'id_post'=>$id, 
								'value'=>  json_encode(['type'=>$type])
							));
							break;
					}
			}else if($cat == 3){
				//animals
				$type = $this->animal_type[$this->faker->numberBetween(0,3)];
					switch ($type) {
						case 'dog':
							//Color
							$color = $this->faker->safeColorName;
							//Breed
							$breed = $this->dog_breeds[$this->faker->numberBetween(0,2)];
							$this->category_model->new_category_property(array('id_category_properties'=>1,'id_post'=>$id, 'value'=>
								json_encode(['type'=>$type,'breed'=>$breed,'color'=>$color ])
							));
							break;
						
						case 'cat':
							//Color
							$color = $this->faker->safeColorName;
							$this->category_model->new_category_property(array('id_category_properties'=>1,'id_post'=>$id, 'value'=>
								json_encode(['type'=>$type,'color'=>$color])
							));
							break;
						case 'bird':
							//Color
							$color = $this->faker->safeColorName;
							$this->category_model->new_category_property(array('id_category_properties'=>1,'id_post'=>$id, 'value'=>
								json_encode(['type'=>$type,'color'=>$color])
							));
							break;
						case 'other':
							# code...
							$this->category_model->new_category_property(array('id_category_properties'=>1,'id_post'=>$id, 'value'=>
								json_encode(['type'=>$type])
							));
							break;
					}

			}

			$url = $this->faker->imageUrl(800, 600);
			$this->load->model('picture_model');
			$this->picture_model->insert_picture(array('id_post'=>$id, 'path'=>$url, 'highlighted'=>1));
        }
        echo "done seeding $limit posts";
 
        echo PHP_EOL;
    }

}

/* End of file Post.php */
/* Location: ./application/controllers/Post.php */