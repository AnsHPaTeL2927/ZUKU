<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Admin_product_code extends CI_model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function pc_select(){

		$q = $this->db->select('mst.*')
			 ->from('product_code_detail as mst')
			 ->order_by("orderby", "asc")
			 ->get();
		return $q->result();
	}

	public function pc_insert($data){

		return $this->db->insert('product_code_detail',$data);
	}
	public function pc_select_edit($id){

		$q=$this->db->where('id',$id);
		$q=$this->db->get('product_code_detail');
		return $q->row();
	}

	public function pc_edit($data,$id){

		$this->db->where('id',$id);
		$q=$this->db->update('product_code_detail',$data);
		return $q;
	}
	public function pc_del($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('product_code_detail');
	}
	public function check_hsc($hsnc_code)
	{
		$q=$this->db->where('hsnc_code',$hsnc_code);
		$q=$this->db->where('status',0);
		$q=$this->db->get('product_code_detail');

		return $q->row();
	} 

}


?>