<?php

class Admin_product_grid extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function productdata()
	{
		$q= $this->db->where('status',0);
		$q=$this->db->get('tbl_series');
		foreach ($q->result() as $category) {
			$category->product_size = $this->get_product_size($category->series_id);
			$return[] = $category;
		}
		return $return;
	}
	public function get_product_size($series_id)
	{
		$array = array("status"=>0,"series_id"=>$series_id);
		$q= $this->db->where($array);
		$q=$this->db->get('tbl_product');
		return $q->result();
	}
	public function select_config(){

		$q=$this->db->get('ciadmin_login');
		return $q->result();
	}
	public function checkproductdata($series_name,$hsnc_code)
	{
		$array = array("status"=>0,"series_name"=>$series_name,"hsnc_code"=>$hsnc_code);
		$q= $this->db->where($array);
		$q= $this->db->get("tbl_series");
		return $q->row();
	}
	public function insert_productdata($data)
	{
		$q = $this->db->insert("tbl_series",$data);
		return $this->db->insert_id();
	}
	public function check_productsizedata($data)
	{
		$data1 = array(
					  'status'=>0,
					  'series_id'=>$data['series_id'],
					  'size_type_cm'=>$data['size_type_cm'],
					  'size_width_mm'=>$data['size_width_mm'],
					  'size_type_mm'=>$data['size_type_mm'],
					  'size_width_cm'=>$data['size_width_cm'],
					  'size_height_mm'=>$data['size_height_mm'],
					  'size_height_cm'=>$data['size_height_cm']
				);
		
		$q= $this->db->where($data1);
		$q=$this->db->get('tbl_product');
		return $q->row();
	}
	public function insert_productsizedata($data)
	{
		$q = $this->db->insert("tbl_product",$data);
		 
		return $this->db->insert_id();
	}
	public function check_sericesdata($data)
	{
		 $data1 = array('status'=>0,
					  'product_id'=>$data['product_id'],
					  'model_name'=>$data['model_name']
				 );
		
		$q= $this->db->where($data1);
		$q=$this->db->get('tbl_packing_model');
		 
		return $q->row();
	}
	public function insert_sericesdata($data)
	{
		$q = $this->db->insert("tbl_packing_model",$data);
		return $this->db->insert_id();
	}
}
