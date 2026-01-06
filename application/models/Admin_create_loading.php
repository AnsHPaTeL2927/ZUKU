<?php
class Admin_create_loading extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	  
	public function select_invoice_data($id)
	{
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
	public function get_container_data($id,$export_invoice_id,$performa_invoice_id)
	{
		 
		if(empty($export_invoice_id))
		{
			$q = $this->db->where('invoice_id',$performa_invoice_id);
			$q = $this->db->get('tbl_makecontainer');
			return $q->result();
		}
		else{
			$q = $this->db->where('exportinvoice_id',$id);
			$q = $this->db->get('tbl_exportmakecontainer');
			 return $q->result();
		}
	}
  	public function getimage($design_id)
	{
		$this->db->where("packing_model_id=".$design_id);
		$q = $this->db->get('tbl_packing_model');
		
	 	$img = $q->row();
		return $img->design_file;
	}
	public function insert_loading($data)
	{
		$q = $this->db->insert('tbl_export_loading',$data);
		
		return $this->db->insert_id();
	}
	public function insert_loadingtrn($data)
	{
		$q = $this->db->insert('tbl_export_loading_trn',$data);
		$this->db->insert_id();
		  
		return 1;
		 
	}
	public function loading_data($id,$exportinvoice_id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_export_loading as mst")
			 ->where("mst.".$exportinvoice_id,$id)
			 ->get();
		// echo $this->db->last_query()
		return $q->row();
	}
	public function update_loading($data,$id)
	{
		$this->db->where('export_loading_id',$id);	
		return $this->db->update('tbl_export_loading',$data);	
	}
	public function update_loadingtrn($data,$id)
	{
		$this->db->where('export_loading_trn_id',$id);	
		return $this->db->update('tbl_export_loading_trn',$data);	
	}
	public function loadingtrn_data($export_invoice_id)
	{
		$q= $this->db->select("mst.*,model.design_file,model.model_name,pro.size_width_mm,pro.size_height_mm")
			 ->from("tbl_export_loading_trn as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_export_loading as load","load.export_loading_id=mst.export_loading_id","LEFT")
			 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			 ->where("load.export_invoice_id",$export_invoice_id)
			 ->get();
		 foreach ($q->result() as $category) {
				$category->desing_html = $this->packing_model_data_image($category->product_id);
				$category->desing_image = $this->getimage($category->design_id);
			 	$return[] = $category;
			   } 
		 
		   return $return; 
 	}
	public function loadingtrndata($export_loading_id)
	{
		$q= $this->db->select("mst.*,model.design_file,model.model_name,pro.size_width_mm,pro.size_height_mm,(SELECT COUNT(*) from tbl_export_loading_trn where con_no = mst.con_no  and export_loading_id=".$export_loading_id.") as size_rowspan")
			 ->from("tbl_export_loading_trn as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			 ->where("mst.export_loading_id",$export_loading_id)
			 ->order_by("con_no asc")
			 ->order_by("export_loading_trn_id asc")
			 ->get();
		 
		return $q->result();
 	}
	public function delete_loadingtrn($id,$con_no,$export_loading_id)
	{
	 	$this->db->where('export_loading_trn_id',$id);
		 $this->db->delete('tbl_export_loading_trn');
	 
		$qry = "UPDATE `tbl_export_loading_trn` SET `rowspan_no` = rowspan_no-1 WHERE con_no = ".$con_no." and export_loading_id = ".$export_loading_id;
		$this->db->query($qry);
		return 1;
	}
	public function getinvoice_trn_data($id)
	{
		$q = $this->db->select('mst.exportproduct_trn_id,mst.export_invoice_id,mst.product_id, product.size_type_mm, code.p_name, code.hsnc_code,   product.thickness, product.size_width_mm, product.size_height_mm, mst.description_goods,mst.container_no,mst.seal_no,mst.pallet_status,mst.boxes_per_pallet,mst.box_per_big_pallet,mst.box_per_small_pallet')
			 ->from('tbl_exportproduct_trn as mst')
			 ->join('tbl_product as product', 'product.product_id = mst.product_id', 'LEFT')
			 ->join('tbl_series as series', 'product.series_id = series.series_id', 'LEFT')
			 ->join('product_code_detail as code', 'code.hsnc_code = series.hsnc_code', 'LEFT')
		 	 ->where('exportproduct_trn_id in ('.$id.')')
		  	 ->get();	
		 
		   return $q->result();
	}
	public function getinvoice_rate_trn_data($id)
	{
		$q= $this->db->select("mst.*,series.seriesgroup_name,invoicedata.description_goods,product.thickness,exptrn.product_container,exptrn.Plts,exptrn.box_per_big_pallet,exptrn.box_per_small_pallet,exptrn.pallet_status,exptrn.exportproduct_trn_id,exptrn.container_detail,exptrn.seal_no")
			 ->from("tbl_exportproduct_rate as mst")
			 ->join('tbl_exportproduct_trn as exptrn', 'exptrn.exportproduct_trn_id = mst.exportproduct_trn_id', 'LEFT')
			 ->join('tbl_product as product', 'product.product_id = mst.product_id', 'LEFT')
			 ->join("tbl_seriesgroup as series","series.seriesgroup_id=mst.model_type_id","LEFT")
			 ->join("tbl_exportproduct_trn as invoicedata","invoicedata.exportproduct_trn_id=mst.exportproduct_trn_id","LEFT")
			 ->where('exptrn.exportproduct_trn_id in ('.$id.')')
			 ->get();
		 
		    return $q->result();
	}
	public function getinvoice_sample_trn_data($id)
	{
		 
		$q = $this->db->select('trn.*, product.size_type_mm, size.sqm_per_box, size.weight_per_box, size.pallet_weight,code.p_name, code.hsnc_code,trn.exportinvoicetrnid')
			 ->from('tbl_export_sampletrn as trn')
		 	->join('tbl_product as product', 'product.product_id = trn.product_id', 'LEFT')
			->join('tbl_series as series', 'product.series_id = series.series_id', 'LEFT')
			->join('tbl_product_size as size', 'size.product_size_id = trn.product_size_id', 'LEFT')
			->join('product_code_detail as code', 'code.hsnc_code = series.hsnc_code', 'LEFT')
			 ->where(' trn.exportinvoicetrnid in ('.$id.')')
			->get();
		 
		return $q->result();	 
	}
	public function  packing_model_data_image($id)
	{
		$this->db->where("status=0  and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
		   
		return $q->result();
	}
	public function getinvoice_trn_alldata($id)
	{
		$q = $this->db->select('mst.*,model.model_name, model.packing_model_id')
			 ->from('tbl_export_packing as mst')
			->join('tbl_packing_model as model', 'model.packing_model_id = mst.design_id', 'LEFT')
			->where('exportproduct_trn_id',$id)
		 	->get();
		 	 
			$category = $q->result();
			 
		  return $category;
	}
	public function getinvoice_packing_data($id)
	{
		$q= $this->db->select("mst.*,trn.pallet_status,trn.product_id,pro.size_type_mm,trn.boxes_per_pallet,trn.box_per_big_pallet,trn.box_per_small_pallet,trn.sqm_per_box,trn.weight_per_box,trn.pallet_weight,trn.big_pallet_weight,trn.small_pallet_weight")
			 ->from("tbl_export_packing as mst")
			 ->join('tbl_exportproduct_trn as trn', 'trn.exportproduct_trn_id = mst.exportproduct_trn_id', 'LEFT')
			 ->join('tbl_product as pro', 'pro.product_id = trn.product_id', 'LEFT')
			 ->where("mst.export_packing_id",$id)
			 ->get();
			$category = $q->row();
			$category->design_html = $this->packing_model_data_image($category->product_id);
		  return $category;
	}
	public function getinvoice_sample_alltrn_data($id)
	{
		$array = array('trn.export_sampletrn_id' => $id);
		$q = $this->db->select('trn.*, product.size_type_mm,invoicedata.description_goods,invoicedata.pallet_status,invoicedata.weight_per_box,invoicedata.pallet_weight,invoicedata.big_pallet_weight,invoicedata.small_pallet_weight')
			 ->from('tbl_export_sampletrn as trn')
			 ->join('tbl_product as product', 'product.product_id = trn.product_id', 'LEFT')
			 ->join("tbl_exportproduct_trn as invoicedata","invoicedata.exportproduct_trn_id=trn.exportinvoicetrnid","LEFT")
			 ->where($array)
			->get();
		 
			$category = $q->row();
			 
			$category->design_html = $this->packing_model_data_image($category->product_id);
		  return $category; 
	}
}
