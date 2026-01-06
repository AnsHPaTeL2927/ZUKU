<?php
class Forwarer_master_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	
	public function bank_select()
	 {
		$q= $this->db->select("mst.*")
			 ->from("bank_master as mst")
			 //->where('mst.status',"0")
			->where('mst.id not in (select id from tbl_forwarer_master where id = mst.id ) and mst.id !=',0)
			 ->get();
			  
		 return $q->result();
	 }
	 
	public function supplier_select(){
		$q=$this->db->order_by('id','desc');
		$q=$this->db->get('tbl_forwarer_master');
		return $q->result();
	}
	public function supplierinsert($data)
	{
		
		$q = $this->db->insert('tbl_forwarer_master',$data);
		
		return $this->db->insert_id();
	}
	public function getsupplier_record($id)
	{
		$q = $this->db->where("id",$id);
		$q = $this->db->get('tbl_forwarer_master');
		//echo $this->db->last_query();
		return $q->row();
	}
	public function supplierupdate($id,$data)
	{
		$this->db->where('id', $id); 
		return $this->db->update('tbl_forwarer_master',$data); 
	}
	public function delete_supplier($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('tbl_forwarer_master');
	}
	public function allproductsize()
	{
		 $q= $this->db->select("mst.*,series.series_name,detail.orderby,series.hsnc_code")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->order_by('detail.orderby asc, series.series_name asc, mst.product_id desc')
			 ->where('mst.status',"0")
			 ->get();
		 return $q->result();
	}
	public function delete_supplierproduct($id){
		
		$this->db->where('id',$id);
		$this->db->delete('tbl_supplier_product');
	}
	public function insertsupplierproduct($product_id,$supplier_id)
	{
		    $copyqry = 'INSERT INTO tbl_supplier_product(product_id,supplier_id,size_type_cm,size_width_mm, size_type_mm, size_width_cm,  size_height_mm,  size_height_cm,thickness, series, pcs_per_box, weight_per_box, sqm_per_box,pallet_status, total_boxes, boxes_per_pallet, total_pallent_container, box_per_container, pallet_gross_weight_per_container, pallet_net_weight_per_container, pallet_weight, sqm_per_container, box_per_big_plt, box_per_small_plt_new,no_big_plt_container_new,no_small_plt_container_new,big_plat_weight,small_plat_weight,series_id,multi_box_per_container,withoutgross_weight_per_container,withoutnet_weight_per_container,withoutpallet_sqm_per_container,multi_gross_weight_container,multi_net_weight_container,multi_sqm_per_container,status,feet_per_box,rate,price_type,total_price,usd_per_box,our_selling_price,profit_price,pallet_charges,fob_expenenses)  SELECT '.$product_id.','.$supplier_id.', product.size_type_cm,product.size_width_mm, product.size_type_mm,product.size_width_cm, product.size_height_mm, product.size_height_cm,thickness, series.series_name, size.pcs_per_box, weight_per_box, sqm_per_box,pallet_status, total_boxes, boxes_per_pallet, total_pallent_container, box_per_container, pallet_gross_weight_per_container, pallet_net_weight_per_container, pallet_weight, sqm_per_container, box_per_big_plt,box_per_small_plt_new,no_big_plt_container_new,no_small_plt_container_new,big_plat_weight,small_plat_weight,series.series_id,multi_box_per_container,withoutgross_weight_per_container,withoutnet_weight_per_container,withoutpallet_sqm_per_container,multi_gross_weight_container,multi_net_weight_container,multi_sqm_per_container,0,0,0,0,0,0,0,0,0,0 FROM  tbl_product as product inner join tbl_series as series on series.series_id=product.series_id 
		inner join tbl_product_size as size on size.product_id=product.product_id 
		WHERE product.product_id='.$product_id; 
		return $this->db->query($copyqry);
		 
	}
	public function getaddedproduct($id)
	{
		$q = $this->db->select("mst.*")
			->from("tbl_supplier_product as mst")
			->where("supplier_id",$id)
			->get();
		// echo $this->db->last_query();
		return $q->result();
	}
	public function delete_onesupplierproduct($id){
		
		$this->db->where('supplier_product_id',$id);
		return $this->db->delete('tbl_supplier_product');
	}
	public function getsupplierproduct_record($id)
	{
		$q = $this->db->select("mst.*,supplier.supplier_name,ser.series_name")
			->from("tbl_supplier_product as mst")
			->where("supplier_product_id",$id)
			->join("tbl_supplier as supplier","mst.supplier_id = supplier.supplier_id","left")
			->join("tbl_series as ser","mst.series_id = ser.series_id","left")
			->get();
		 //echo $this->db->last_query();
		return $q->row();
	}
	public function edit_product_data($data,$id)
	{
		$this->db->where('supplier_product_id', $id); 
		 return $this->db->update('tbl_supplier_product',$data); 
	}
	public function select_config(){

		$q=$this->db->get('ciadmin_login');
		return $q->row();
	}
	public function get_series($id){

		$q = $this->db->where('product_id',$id);
		$q = $this->db->get('tbl_seriesgroup');
		 
		return $q->result();
	}
	public function check_epcg_data($series_name,$supplier_id)
	{
		$array = array("status"=>0,"Contact_Name"=>$series_name,"cha_id"=>$supplier_id);
		$q= $this->db->where($array);
		$q= $this->db->get("tbl_forwarer_contact");
		return $q->row();
	}
	public function insert_epcg_data($data)
	{
		$q = $this->db->insert('tbl_forwarer_contact',$data);
		return $this->db->insert_id();
	}
	public function get_epcg_data($id)
	{
		$q = $this->db->select("mst.*")
			->from("tbl_forwarer_contact as mst")
			->where("cha_id",$id)
			->get();
		// echo $this->db->last_query();
		return $q->result();
	}
	public function fetchepcgdata($id){

		$q = $this->db->where('contact_id',$id);
		$q = $this->db->get('tbl_forwarer_contact');
		 
		return $q->row();
	}
	public function update_epcgdata($data,$id)
	{
		$this->db->where('contact_id', $id); 
		 return $this->db->update('tbl_forwarer_contact',$data); 
	}
	public function deleteepcgrecord($id){
		
		$this->db->where('contact_id',$id);
		return $this->db->delete('tbl_forwarer_contact');
	}
}

?>