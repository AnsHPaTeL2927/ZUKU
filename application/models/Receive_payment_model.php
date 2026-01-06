<?php
class Receive_payment_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
			
	}
	 public function insert_receive_payment($data){

		$id = $this->db->insert('tbl_receive_payment_part',$data);
		return $this->db->insert_id();
	}
	public function get_receive_payment($id){

		$q=$this->db->where('receive_payment_part_id',$id);
		$q=$this->db->get('tbl_receive_payment_part');
		 
		return $q->row();
	}

	public function update_receive_payment($data,$id){

		$this->db->where('receive_payment_part_id',$id);
		$q=$this->db->update('tbl_receive_payment_part',$data);
		return $q;
	}
	public function delete_record($id){
		
		$this->db->where('receive_payment_part_id',$id);
		return $this->db->delete('tbl_receive_payment_part');
	}
	public function check_receive_payment($receive_payment_part_name)
	{
		$q=$this->db->where('receive_payment_part_name',$receive_payment_part_name);
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_receive_payment_part');

		return $q->row();
	} 
}

?>