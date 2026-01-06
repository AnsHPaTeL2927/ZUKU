<?php 
class Admin_model_list extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}

	 public function getproductdata()
	 {
		 $q= $this->db->select("mst.*,series.series_name,series.hsnc_code")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->where('mst.status',"0")
			 ->order_by('detail.orderby asc, series.series_name asc, mst.product_id desc')
			 ->get();
		 return $q->result();
	 }
	 public function get_supplier()
	{
		$q=$this->db->get('tbl_supplier');
		return $q->result();
	}
	  public function getmodeldata()
	 {
		 $q= $this->db->select("model.*,pro.size_type_mm,series.series_name,(SELECT count(*) FROM `tbl_product_packing` where model_details = model.packing_model_id) as total_cnt")
			 ->from("tbl_packing_model as model")
			 ->join("tbl_product as pro","model.product_id=pro.product_id","LEFT")
			 ->join("tbl_series as series","series.series_id=pro.series_id","LEFT")
			 ->join("product_code_detail as code","code.hsnc_code=series.hsnc_code","LEFT")
			 ->where('model.status',"0")
			 ->order_by('code.hsnc_code',"ASC")
			 ->order_by('series.series_name',"ASC")
			 ->get();
		 return $q->result();
	 }
	 public function insertdata($data)
	 {
		 $q = $this->db->insert("tbl_packing_model",$data);
		 
		 return $this->db->insert_id();
	 }
	 
	public function deleterecord($id, $user_id)
{
    $data = array(
        "status"    => "2",        // mark as deleted
        "deleted_by" => $user_id,  // store who deleted it
        "deleted_at" => date('Y-m-d H:i:s') // optional: track when deleted
    );

    $this->db->where('packing_model_id', $id);
    $updateid = $this->db->update('tbl_packing_model', $data);
    return $updateid;
}
	
	 public function getfinishdata()
	 {
		 $q = $this->db->where("status",0);
		 $q= $this->db->get("tbl_finish");
		  
		 return $q->result();
	 }
	 public function fetchmodeldata($id)
	 {
		 $q = $this->db->where("packing_model_id",$id);
		 $q= $this->db->get("tbl_packing_model");
		  
		 return $q->row();
	 }
	public function fetchmodel_data($packing_model_id)
	{
		 $q = "SELECT * FROM `tbl_seriesgroup` as `mst`  WHERE find_in_set('".$packing_model_id."',packing_model_id)";
		$q_con = $this->db->query($q);
		return $q_con->row();
	}
	 public function updatedata($data,$id)
	 { 	
		$this->db->where('packing_model_id',$id);
		$updateid= $this->db->update('tbl_packing_model',$data);
		return $updateid;
	 }
	 public function checkdata($data)
	 {
		 $data1 = array('status'=>0,
					  'product_id'=>$data['product_id'],
					  'model_name'=>$data['model_name']
					);
		
		$q= $this->db->where($data1);
		$q=$this->db->get('tbl_packing_model');
		 
		return $q->row();
	 }
	 public function seriesgroup_data($id)
	 {
		$q= $this->db->where("status = 0 and product_id=".$id);
		$q=$this->db->get('tbl_seriesgroup');
		 
		return $q->result();
	 }
	 public function update_seriesgroup($packing_model_id,$seriesgroup_id)
	 {
		  $q = "SELECT * FROM `tbl_seriesgroup` as `mst`  WHERE find_in_set('".$packing_model_id."',packing_model_id) and seriesgroup_id=".$seriesgroup_id;
		$q_con = $this->db->query($q);
		if($q_con->num_rows() == 0)
		{
			$query = "update tbl_seriesgroup set packing_model_id=CONCAT(packing_model_id,',".$packing_model_id."') where seriesgroup_id=".$seriesgroup_id;
			$updateid=  $this->db->query($query);
		}
		return 1;
	 }
	 public function getgroup_detail($packing_model_id)
	 {
		 $sql = 'SELECT seriesgroup_name,group_rate FROM `tbl_seriesgroup` where find_in_set("'.$packing_model_id.'",packing_model_id)';
		 $q_con = $this->db->query($sql);
		 return $q_con->row();
	 }
}

?>