<?php 
class Admin_terms_list extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function termsdata()
	{
		 $q= $this->db->select("mst.*,(SELECT count(*) FROM `tbl_performa_invoice` where terms_id = mst.terms_id) as total_cnt")
			 ->from("tbl_terms as mst")
			 ->where('mst.status !=',"2")
			 ->order_by('terms_id',"desc")
			 ->get();

		 return $q->result();
	}
	public function checkdata($terms_name)
	{
		$array = array("status"=>0,"terms_name"=>$terms_name);
		$q= $this->db->where($array);
		$q= $this->db->get("tbl_terms");
		return $q->row();
	}
	public function insertdata($data)
	{
		$q = $this->db->insert("tbl_terms",$data);
		return $this->db->insert_id();
	}
	public function deleterecord($id)
	{
		$data= array("status"=>"2");
		$this->db->where('terms_id',$id);
		$updateid= $this->db->update('tbl_terms',$data);
		return $updateid;
	}
	public function chnagerecord($id,$status)
	{
		$data= array("status"=>$status);
		$this->db->where('terms_id',$id);
		$updateid= $this->db->update('tbl_terms',$data);
		return $updateid;
	}
	public function fetchmodeldata($id)
	{
		$q= $this->db->where("terms_id",$id);
		$q= $this->db->get("tbl_terms");
		return $q->row();
	}
	public function updatedata($data,$id)
	{ 	
		$this->db->where('terms_id',$id);
		$updateid= $this->db->update('tbl_terms',$data);
		return $updateid;
	}
	 
}

?>