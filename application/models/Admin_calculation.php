<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Admin_calculation extends CI_model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function select_hsnc(){
		 
		 $q =  $this->db->select('mst.*,serices.hsnc_code,pro.size_type_mm,serices.series_name')
			  ->from('tbl_product_size as mst')
			  ->join('tbl_product as pro','mst.product_id=pro.product_id','LEFT') 
			  ->join('tbl_series as serices','pro.series_id=serices.series_id','LEFT') 
			  ->where('mst.status',0)
			  ->order_by('mst.product_size_id desc')
			  ->get('');
		return $q->result();
	}
	public function select_config(){

		$q=$this->db->get('ciadmin_login');
		return $q->result();
	}
	public function ciadmin_login()
	{
		$q = $this->db->get('ciadmin_login');
		return $q->row();
	}
	public function b_form_edit($id){

		$q=$this->db->where('product_size_id',$id);
		$q=$this->db->get('tbl_product_size');
		return $q->row();
	}
	public function pc_insert($data){

		return $this->db->insert('hsnc_product_size',$data);
	}
	public function pc_select_edit($id){

		$q=$this->db->where('id',$id);
		$q=$this->db->get('hsnc_product_size');
		return $q->row();
	}

	public function pc_edit($data,$id){

		$this->db->where('id',$id);
		$q=$this->db->update('hsnc_product_size',$data);
		return $q;
	}
	public function pc_del($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('hsnc_product_size');
	}
	public function select_hsnc_product_size($id){

		$query = $this->db->where('product_size_id', $id);
		$query = $this->db->join('tbl_product as product','product.product_id = size.product_id','inner');
		$query = $this->db->join('tbl_series as serices','product.series_id=serices.series_id','inner');
		$query = $this->db->get('tbl_product_size as size');
		 
		return $query->row();
	}
	public function update_hsnc_product_size($json_data,$id){

		$data = array("size_details"=>$json_data);
		$this->db->where('id',$id);
		$q=$this->db->update('hsnc_product_size',$data);
		if ($this->db->affected_rows() > 0)
		{
		  echo "Data update successfully";
		}
		else
		{
		  echo "Nothing to update";
		}
	}
	public function delete_calc($id){

		$data = array("status"=>2);
		$this->db->where('product_size_id',$id);
		return $q=$this->db->update('tbl_product_size',$data);
		 
	}
	public function b_edit($data,$id)
	{
	  	$this->db->where('product_size_id',$id);	
		return $this->db->update('tbl_product_size',$data);	
	}
}


?>