<?php

class Admin_hsnc_code extends CI_model
{
	public function __construct()
	{
	parent:: __construct();	
	$this->load->database();
		
	}

	public function b_insert($data){
		return  $this->db->insert('tbl_product_size',$data); //$this->db->insert('hsnc_product_size_price',$data);
	}

	public function b_select(){
		$q=$this->db->get('hsnc_product_size');
		return $q->result();
	}
	public function b_form_edit($id){

		$q= $this->db->select("mst.*,pro.size_width_mm,pro.size_width_cm,pro.size_height_mm,pro.size_height_cm")
			 ->from("tbl_product_size as mst")
			 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			  ->where('product_size_id',$id)
			 ->get();
	  
		return $q->row();
	}


	public function b_del($id){
		$this->db->where('id',$id);
		$this->db->delete('hsnc_product_size');
	}

	public function b_edit($data,$id)
	{
	  	$this->db->where('product_size_id',$id);	
		return $this->db->update('tbl_product_size',$data);	
	}
	public function getproduct()
	{
		$q=$this->db->select('mst.*,serices.series_name')
			->from('tbl_product as mst')
			->join("tbl_series as serices","mst.series_id=serices.series_id","LEFT")
			->where('mst.status',0)
			->get();
		return $q->result();
	}
	
}

?>