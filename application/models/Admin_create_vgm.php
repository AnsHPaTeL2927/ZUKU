<?php
class Admin_create_vgm extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	  
	public function select_invoice_data($id){
		$q = $this->db->select('invoice.*, consign.c_name')
			 ->from('tbl_export_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			->where('export_invoice_id',$id) 
			->get();
			return $q->row();
	}
	
	public function getinvoiceproductdata($id)
	{
		$q = $this->db->select('mst.*, product.size_type_mm, code.p_name, code.hsnc_code,product.thickness, product.size_width_mm, product.size_height_mm')
			 ->from('tbl_exportproduct_trn as mst')
			->join('tbl_product as product', 'product.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as series', 'product.series_id = series.series_id', 'LEFT')
			->join('product_code_detail as code', 'code.hsnc_code = series.hsnc_code', 'LEFT')
			 
			->where('export_invoice_id',$id)
			->order_by("product_container", "desc")
			->order_by("container_order_by", "asc")
			->order_by("exportproduct_trn_id", "asc")
			->get();	 
			foreach ($q->result() as $category) {
				$sub = $category->exportproduct_trn_id;
				$category->sub = $this->sampleproductdata($category->exportproduct_trn_id,$id);
				$category->serices = $this->getproductrate($category->exportproduct_trn_id);
				
			 	$return[] = $category;
				 
			  } 
		 
		   return $return;
	}
	
	public function sampleproductdata($exportproduct_trn_id,$id)
	{
		$array = array('trn.exportinvoicetrnid' => $exportproduct_trn_id, 'trn.export_id' =>$id);
		$q = $this->db->select('trn.*, product.size_type_mm, size.sqm_per_box, size.weight_per_box, size.pallet_weight,code.p_name, code.hsnc_code')
			 ->from('tbl_export_sampletrn as trn')
		 	->join('tbl_product as product', 'product.product_id = trn.product_id', 'LEFT')
			->join('tbl_series as series', 'product.series_id = series.series_id', 'LEFT')
			->join('tbl_product_size as size', 'size.product_id = product.product_id', 'LEFT')
			->join('product_code_detail as code', 'code.hsnc_code = series.hsnc_code', 'LEFT')
			->where($array)
			->get();
		 
		return $q->result();	 
	}
	public function getproductrate($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name")
			 ->from("tbl_export_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("mst.exportproduct_trn_id",$id)
			 ->get();
		 
		return $q->result();
	}
	public function regualr_packing_model_data_image($id)
	{
		$this->db->where("status=0 and seriesgroup_id = 0 and design_file != '' and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
	 	//echo $this->db->last_query(); 
		return $q->result();
	}
	public function group_packing_model_data_image($id,$seriesgroup_id)
	{
		$this->db->where("status=0 and seriesgroup_id = ".$seriesgroup_id." and design_file != '' and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
	//	 echo $this->db->last_query();
		return $q->result();
	}
	public function get_container_data($id,$export_invoice_id,$performa_invoice_id)
	{
		 
		 
			$q = $this->db->where('exportinvoice_id',$id);
			$q = $this->db->get('tbl_exportmakecontainer');
			 return $q->result();
		 
	}
  	public function getimage($design_id)
	{
		$this->db->where("packing_model_id=".$design_id);
		$q = $this->db->get('tbl_packing_model');
	 	$img = $q->row();
		return $img->design_file;
	}
	public function insert_vgm($data)
	{
		$q = $this->db->insert('tbl_vgm',$data);
		return $this->db->insert_id();
	}
	public function insert_vgmtrn($data)
	{
		$q = $this->db->insert('tbl_vgmtrn',$data);
		 
		return $this->db->insert_id();
	}
	public function vgm_data($id)
	{
		$q= $this->db->select("mst.*,invoice.export_invoice_no,invoice.e_email,pi.sign_detail_id,
            user.sign_pi_status,
            user.for_signature_name,
            user.sign_image,
            user.authorised_signatury,
            user.contact_person_name,
            user.contact_no,
            user.contact_email")
			 ->from("tbl_vgm as mst")
			 ->join("tbl_export_invoice as invoice","invoice.export_invoice_id=mst.export_invoice_id")
			   ->join('tbl_performa_invoice AS pi', 'pi.performa_invoice_id = invoice.performa_invoice_id', 'LEFT')
				->join('tbl_user AS user', 'user.user_id = pi.sign_detail_id', 'LEFT')
			 ->where("mst.vgm_id",$id)
			 ->get();
		 
		return $q->row();
	}
	public function update_vgm($data,$id)
	{
		$this->db->where('vgm_id',$id);	
		return $this->db->update('tbl_vgm',$data);	
	}
	public function vgmtrn_data($vgm_id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_vgmtrn as mst")
			  ->where("mst.vgm_id",$vgm_id)
			 ->get();
		 
		return $q->result();
 	}
	public function delete_vgmtrn($id)
	{
	 	$this->db->where('vgm_id',$id);
		return $this->db->delete('tbl_vgmtrn');
	}
}
