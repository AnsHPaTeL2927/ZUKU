<?php 
class Admin_design_list extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}

	 public function getproductdata()
	 {
		 $q= $this->db->select("mst.*,series.series_name")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			->where('mst.status',"0")
			 ->get();
		 return $q->result();
	 }
	  public function getmodeldata($id)
	 {
		 $array = array("model.status"=>"0","model.product_id"=>$id);
		 $q= $this->db->select("model.*")
			 ->from("tbl_packing_model as model")
			 ->where($array)
			 ->get();
			   
		 return $q->result();
	 }
	 public function getdesigndata()
	 {
		  $q= $this->db->select("mst.*,product.size_type_mm,series.series_name,model.model_name")
			 ->from("tbl_design as mst")
			 ->join("tbl_product as product","product.product_id=mst.product_id","LEFT")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.model_id","LEFT")
			 ->join("tbl_series as series","series.series_id=product.series_id","LEFT")
			->where('mst.status',"0")
			 ->get();
		 return $q->result();
	 }
	 public function insertdata($data)
	 {
		 $q = $this->db->insert("tbl_design",$data);
		 return $this->db->insert_id();
	 }
	 public function deleterecord($id){
		$data= array("status"=>"2");
		$this->db->where('design_id',$id);
		$updateid= $this->db->update('tbl_design',$data);
		return $updateid;
	}
	 public function fetchdesign_data($id)
	 {
		 $q= $this->db->where("design_id",$id);
		 $q= $this->db->get("tbl_design");
		 return $q->row();
	 }
	 public function updatedata($data,$id)
	 { 	
		$this->db->where('design_id',$id);
		$updateid= $this->db->update('tbl_design',$data);
		return $updateid;
	 }
	  public function checkdata($data)
	 {
		 $data1 = array('status'=>0,
					  'design_name'=>$data['design_name'],
					  'product_id'=>$data['product_id'],
					  'model_id'=>$data['model_id']
				 );
		
		$q= $this->db->where($data1);
		$q=$this->db->get('tbl_design');
		return $q->result();
	 }
}

?>