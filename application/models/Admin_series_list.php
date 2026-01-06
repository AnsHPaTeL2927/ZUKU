<?php 
class Admin_series_list extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function getseriesdata()
	{
		 $q= $this->db->select("mst.*,(SELECT count(*) FROM `tbl_product` where series_id = mst.series_id) as total_cnt ")
			 ->from("tbl_series as mst")
			 ->where('mst.status',"0")
			 ->order_by('series_id',"desc")
			 ->get();

		 return $q->result();
	}
	public function checkdata($series_name,$hsnc_code)
	{
		$array = array("status"=>0,"series_name"=>$series_name,"hsnc_code"=>$hsnc_code);
		$q= $this->db->where($array);
		$q= $this->db->get("tbl_series");
		return $q->row();
	}
	public function insertdata($data)
	{
		$q = $this->db->insert("tbl_series",$data);
		return $this->db->insert_id();
	}
	public function deleterecord($id)
	{
		$data= array("status"=>"2");
		$this->db->where('series_id',$id);
		$updateid= $this->db->update('tbl_series',$data);
		return $updateid;
	}
	public function fetchmodeldata($id)
	{
		$q= $this->db->where("series_id",$id);
		$q= $this->db->get("tbl_series");
		return $q->row();
	}
	public function updatedata($data,$id)
	{ 	
		$this->db->where('series_id',$id);
		$updateid= $this->db->update('tbl_series',$data);
		return $updateid;
	}
	public function hsncdata()
	{
		$q = $this->db->select('mst.*')
			 ->from('product_code_detail as mst')
			 ->where("status", "Active")
			 ->order_by("orderby", "asc")
			 ->get();
	 	 return $q->result();
	}
}

?>