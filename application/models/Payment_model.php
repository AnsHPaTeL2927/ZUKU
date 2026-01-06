<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Payment_model extends CI_model
{

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
	
	public function get_payment_data()
	{
	
		$q = $this->db->select('*')
			 ->from('tbl_payment_mode')
			 ->get();
		 
		return $q->result();
	}

	public function insert_payment($data){

		$id = $this->db->insert('tbl_payment_mode',$data);
		return $this->db->insert_id();
	}
	public function getpaymentmode($id){

		$q=$this->db->where('payment_mode_id',$id);
		$q=$this->db->get('tbl_payment_mode');
		 
		return $q->row();
	}

	public function update_payment($data,$id){

		$this->db->where('payment_mode_id',$id);
		$q=$this->db->update('tbl_payment_mode',$data);
		return $q;
	}

	public function check_paymentmode($payment_mode)
	{
		$q=$this->db->where('payment_mode',$payment_mode);
		$q=$this->db->where('status',0);
	 	$q=$this->db->get('tbl_payment_mode');

		return $q->row();
	} 
	
	public function delete_record($id){
	
	$this->db->where('payment_mode_id',$id);
	return $this->db->delete('tbl_payment_mode');
	}

}


?>