<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Admin_product_list extends CI_model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function select_product(){
		$q = $this->db->select("mst.*,series.hsnc_code,code.orderby")
			->from('tbl_product as mst')
			->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			->join("product_code_detail as code","code.hsnc_code=series.hsnc_code","LEFT")
			->where('status',0)
			->order_by('code.orderby asc')
			->get();
		 
		return $q->result();
	}
	public function select_config(){

		$q=$this->db->get('ciadmin_login');
		return $q->result();
	}
	public function ciadmin_login()
	{
		$q = $this->db->get('ciadmin_login');
		return $q->row();
	}
	public function b_form_edit($id)
	{
		$q=$this->db->where('product_size_id',$id);
		$q=$this->db->get('tbl_product_size');
		return $q->row();
	}
	public function pc_insert($data){

		return $this->db->insert('hsnc_product_size',$data);
	}
	public function pc_select_edit($id){

		$q=$this->db->where('id',$id);
		$q=$this->db->get('hsnc_product_size');
		return $q->row();
	}

	public function pc_edit($data,$id){

		$this->db->where('id',$id);
		$q=$this->db->update('hsnc_product_size',$data);
		return $q;
	}
	public function pc_del($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('hsnc_product_size');
	}
	public function select_hsnc_product_size($id){

		$query = $this->db->where('product_id', $id);
		$query = $this->db->get('tbl_product_size');
		//  $this->db->last_query();
		return $query->result();
	}
	public function update_hsnc_product_size($json_data,$id){

		$data = array("size_details"=>$json_data);
		$this->db->where('id',$id);
		$q=$this->db->update('hsnc_product_size',$data);
		if ($this->db->affected_rows() > 0)
		{
		  echo "Data update successfully";
		}
		else
		{
		  echo "Nothing to update";
		}
	}
	public function delete_product($id){

		$data = array("status"=>2);
		$this->db->where('product_id',$id);
		return $q=$this->db->update('tbl_product',$data);
		 
	}
	public function delete_product_size($id){

		$data = array("status"=>2);
		$this->db->where('product_size_id',$id);
		return $q=$this->db->update('tbl_product_size',$data);
		 
	}
	public function b_edit($data,$id)
	{
	  	$this->db->where('product_size_id',$id);	
		return $this->db->update('tbl_product_size',$data);	
	}
	public function seriesdata()
	{
		$q= $this->db->where('status',0);
		$q=$this->db->get('tbl_series');
		return $q->result();
	}
	public function seriesgroupdata($id)
	{
		$data = array('status'=>0,'product_id'=>$id);
		
		$q= $this->db->where($data);
		$q=$this->db->get('tbl_seriesgroup');
		 return $q->result();
	}
	public function insert_product($data){

		$q = $this->db->insert('tbl_product',$data);
		return $this->db->insert_id();
	}
	public function insert_packing_detail($data){

		$q = $this->db->insert('tbl_product_size',$data);
		return $this->db->insert_id();
	}
	public function productdata($id){
		$data = array('mst.status'=>0,'product_id'=>$id);
		
		$q= $this->db->select("mst.*,series.series_name")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->order_by('hsnc_code')
			 ->where($data)
			 ->get();
		return $q->row();
	}
	public function update_product($data,$id)
	{
		$this->db->where('product_id',$id);	
		return $this->db->update('tbl_product',$data);	
	}
	public function insert_grouprate($data){
		$q = $this->db->insert('tbl_seriesgroup',$data);
		return  $this->db->insert_id();
	}
	public function fetchgroupdata($id)
	 {
		 $q= $this->db->where("seriesgroup_id",$id);
		 $q= $this->db->get("tbl_seriesgroup");
		 
		 return $q->row();
	 }
	  public function updatemodeldata($data,$id)
	 { 	
		$this->db->where('seriesgroup_id',$id);
		$updateid= $this->db->update('tbl_seriesgroup',$data);
		return $updateid;
	 }
	 public function deletegrouprecord($id){
		
		$this->db->where('seriesgroup_id',$id);
		return $this->db->delete('tbl_seriesgroup');
	}
	 
	public function checkdata($data)
	{
		 
		$data1 = array('status'=>0,
					  'series_id'=>$data['series_id'],
					  'size_type_cm'=>$data['size_type_cm'],
					  'size_width_mm'=>$data['size_width_mm'],
					  'size_type_mm'=>$data['size_type_mm'],
					  'size_width_cm'=>$data['size_width_cm'],
					  'size_height_mm'=>$data['size_height_mm'],
					  'size_height_cm'=>$data['size_height_cm'],
					  'thickness'=>$data['thickness']
					  );
		
		$q= $this->db->where($data1);
		$q=$this->db->get('tbl_product');
		 
		 return $q->result();
	}
	
	public function packingmodel_data($id)
	{
		$array = array("product_id"=>$id,"status"=>0);
		$q = $this->db->select('mst.*')
			 ->from('tbl_packing_model as mst')
			 ->where($array)
			 ->get();
	 	 return $q->result();
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
	public function series_allgroupdata()
	{ 
		$q= $this->db->select("mst.*,pro.size_type_mm,series.series_name,pro.thickness")
			 ->from("tbl_seriesgroup as mst")
			 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			 ->join("tbl_series as series","series.series_id=pro.series_id","LEFT")
			 ->where('mst.status',"0")
			 ->order_by('mst.seriesgroup_id desc')
			 ->get();
		 return $q->result();
	}
	public function getproductpacking_detail($id)
	{
		$q= $this->db->select("mst.*,pro.size_width_mm,pro.size_width_cm,pro.size_height_mm,pro.size_height_cm")
			 ->from("tbl_product_size as mst")
			 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			  ->where('product_size_id',$id)
			 ->get();
	 
		return $q->row();
	}
	public function getproductpackingdetail($id)
	{
		$q= $this->db->select("mst.*,pro.size_width_mm,pro.size_width_cm,pro.size_height_mm,pro.size_height_cm")
			 ->from("tbl_product_size as mst")
			 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			  ->where('mst.product_id',$id)
			 ->get();
	 
		return $q->row();
	}
	public function update_packing_detail($data,$id)
	{
	  	$this->db->where('product_size_id',$id);	
		return $this->db->update('tbl_product_size',$data);	
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