<?php
class Pallet_contact_list_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	
	public function check_doc_update($Contact_Name)
	{
		$q=$this->db->where('Contact_Name',$Contact_Name);
		// $q=$this->db->where('status',0);
		$q=$this->db->get('tbl_pallet_contact');

		return $q->row();
	} 
	
	public function check_epcg_data($series_name,$supplier_id)
	{
		$array = array("status"=>0,"Contact_Name"=>$series_name,"pallet_id"=>$supplier_id);
		$q= $this->db->where($array);
		$q= $this->db->get("tbl_pallet_contact");
		return $q->row();
	}
	
	public function insert_epcg_data($data)
	{
		$q = $this->db->insert('tbl_pallet_contact',$data);
		return $this->db->insert_id();
	}
	public function get_epcg_data($id)
	{
		$q = $this->db->select("mst.*")
			->from("tbl_pallet_contact as mst")
			->where("pallet_id",$id)
			->get();
		// echo $this->db->last_query();
		return $q->result();
	}
	public function fetchepcgdata($id){

		$q = $this->db->where('contact_id',$id);
		$q = $this->db->get('tbl_pallet_contact');
		 
		return $q->row();
	}
	public function update_epcgdata($data,$id)
	{
		$this->db->where('contact_id', $id); 
		 return $this->db->update('tbl_pallet_contact',$data); 
	}
	public function deleteepcgrecord($id){
		
		$this->db->where('contact_id',$id);
		return $this->db->delete('tbl_pallet_contact');
	}
}
?>