<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->helper(array('form', 'url'));
		if($this->input->post('productImage'))
		{
			$file_name = time().'-'.$_FILES["image"]['name'];
			
			$config = array(
				'upload_path' => "./assets/images/",
				'allowed_types' => "gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF",
				'overwrite' => TRUE,
				'max_size' => "26200",
				'max_width' => "650",
				'max_height' => "500",
				'file_name' => $new_name
			);
			$this->load->library('upload', $config);
	
			
			$data = $this->upload->data();
			
			// Create thumnail or resize image
			$config2 = array(
				'source_image'		=> $data['full_path'], //get original image
				'new_image'			=> $data['file_path'].'thumb', //save as new image //need to create thumbs first
				'maintain_ratio'	=> true,
				'width'				=> 150
			);
			$this->load->library('image_lib'); //load library
			$this->image_lib->initialize($config2);
			$this->image_lib->resize();
			$this->image_lib->clear();
			$this->load->view('upload');
		}
		else
		{
			$this->load->view('upload', $data);
		}
	}
}
?>