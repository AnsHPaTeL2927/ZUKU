<?php 
class Admin_seriesgroup_list extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}

	 
	  public function getseriesdata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_seriesgroup as mst")
			->where('mst.status',"0")
			->get();
		 return $q->result();
	 }
	 public function insertdata($data)
	 {
		 $q = $this->db->insert("tbl_seriesgroup",$data);
		 return $this->db->insert_id();
	 }
	 public function deleterecord($id){
		$data= array("status"=>"2");
		$this->db->where('seriesgroup_id',$id);
		$updateid= $this->db->update('tbl_seriesgroup',$data);
		return $updateid;
	}
	 public function fetchmodeldata($id)
	 {
		 $q= $this->db->where("seriesgroup_id",$id);
		 $q= $this->db->get("tbl_seriesgroup");
		 return $q->row();
	 }
	
	 public function getmodeldata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_packing_model as mst")
			->where('mst.status',"0")
			->get();
		 return $q->result();
	 }
}

?>