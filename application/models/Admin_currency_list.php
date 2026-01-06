<?php 
class Admin_currency_list extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function getcurrencydata()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_currency as mst")
			->where('status',"0")
			->get();
		 return $q->result();
	 }
	 public function insertdata($data)
	 {
		 $q = $this->db->insert("tbl_currency",$data);
		 return $this->db->insert_id();
	 }
	 public function deleterecord($id){
		$data= array("status"=>"2");
		$this->db->where('currency_id',$id);
		$updateid= $this->db->update('tbl_currency',$data);
		return $updateid;
	}
	 public function fetchmodeldata($id)
	 {
		 $q= $this->db->where("currency_id",$id);
		 $q= $this->db->get("tbl_currency");
		 return $q->row();
	 }
	 public function updatedata($data,$id)
	 { 	
		$this->db->where('currency_id',$id);
		$updateid= $this->db->update('tbl_currency',$data);
		return $updateid;
	 }
	  public function remove_defualt_currency($id)
	 { 	
		$data = array(
			"currency_status" => 0
		);
		$this->db->where('currency_id !=',$id);
		$updateid= $this->db->update('tbl_currency',$data);
		return $updateid;
	 }
}

?>