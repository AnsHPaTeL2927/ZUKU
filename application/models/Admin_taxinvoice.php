<?php
class Admin_taxinvoice extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function select_consigner(){
		$q = $this->db->get('customer_detail');
		return $q->result();
	}
	public function other_consigner($id)
	{
		$q = $this->db->where('customer_id',$id);
		$q = $this->db->get('customer_add_consigner');
		//  echo $this->db->last_query();
		return $q->result();
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
	
	public function get_invoice_html($tax_id)
	{
		$q = $this->db->where('table_id',$tax_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','tax_invoice');
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
	
	public function selectinvoicetype($id){
		$q = $this->db->where('invoicetype_id',$id);
		$q = $this->db->get('tbl_invoicetype');
		return $q->row();
	}
	 public function update_invoicenumber($id,$invoice_series)
	{
		$data = array("invoice_series"=>($invoice_series));
		$this->db->where('invoicetype_id',$id);	
		return $this->db->update('tbl_invoicetype',$data);	
			
	} 
	 public function bank_detail($id){
		$this->db->where('id',$id);
		$q = $this->db->get('bank_detail');
		return $q->row();
	}
	public function getinvoiceproductdata($id)
	{ 
		$q = $this->db->select('mst.*,product.size_type_mm,series.series_name')
			 ->from('tbl_exportproduct_trn as mst')
			 ->join('tbl_product as product',"product.product_id=mst.product_id","INNER")
			 ->join('tbl_series as series',"series.series_id=product.series_id","INNER")
			 ->where('export_invoice_id',$id)
			->order_by("product_container", "desc")
			->order_by("container_order_by", "asc")
			->order_by("exportproduct_trn_id", "asc")
			->get();
		 
			foreach ($q->result() as $category) {
					$sub = $category->exportproduct_trn_id;
					$category->packing = $this->get_packing($category->exportproduct_trn_id);
					$category->sample  = $this->get_sample($category->exportproduct_trn_id,$id);
					 
					$return[] = $category;
			  } 
			  
			  return $return;
	}
	public function get_sample($exportproduct_trn_id,$id)
	{
		$array = array('trn.exportproduct_trn_id' => $exportproduct_trn_id, 'trn.export_id' =>$id);
		$q = $this->db->select('trn.*, product.size_type_mm, size.sqm_per_box, size.weight_per_box, size.pallet_weight ')
			 ->from('tbl_export_sampletrn as trn')
		    ->join('tbl_product as product', 'product.product_id = trn.product_id', 'LEFT')
			 ->join('tbl_product_size as size', 'size.product_size_id = trn.product_size_id', 'LEFT')
		 	->where($array)
			->order_by("exportproduct_trn_id", "asc")
			->get();
		 
		return $q->result();	 
	}
	public function get_sample_trn($export_id)
	{
		$array = array('trn.export_id' => $export_id);
		$q = $this->db->select('trn.*,size.sqm_per_box, size.weight_per_box,product.size_type_mm')
			 ->from('tbl_export_sampletrn as trn')
			 ->join('tbl_product as product', 'product.product_id = trn.product_id', 'LEFT')
			 ->join('tbl_product_size as size', 'size.product_id = product.product_id', 'LEFT')
			 ->where($array)
			 ->get();
		 
		return $q->result();
	}	
	public function get_packing($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name")
			 ->from("tbl_export_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("exportproduct_trn_id",$id)
			 ->get();
		  
		return $q->result();
	}
	public function insert_taxinvoice($data)
	{
		$this->db->insert('tbl_taxinvoice',$data);
		 return $this->db->insert_id();
	}
	public function insert_taxinvoicetrn($data)
	{
		$this->db->insert('tbl_taxinvoicetrn',$data);
		
		 return $this->db->insert_id();
	}
	public function insertratedata($data)
	{
		$this->db->insert('tbl_taxinvoice_rate',$data);
		 //echo $this->db->last_query();
		 return $this->db->insert_id();
	}
	public function insert_taxsample($data)
	{
		$this->db->insert('tbl_tax_sample',$data);
		return $this->db->insert_id();
	}
	public function insert_taxsampletrn($data)
	{
		$this->db->insert('tbl_tax_sampletrn',$data);
		 
		 return $this->db->insert_id();
	}
	public function update_exportinvoice($id,$export_status)
	{
		$data = array("tax_status"=>$export_status);
		$this->db->where('export_invoice_id',$id);	
		return $this->db->update('tbl_export_invoice',$data);	
			
	}
	public function taxinvoice_data($id)
	{
		$q = $this->db->select('invoice.*, consign.c_name,supplier.supplier_gstno,,epcg.epcg_no,epcg.epcg_date,terms.terms_name,einvoice.igst_status')
			 ->from('tbl_taxinvoice as invoice')
			->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			 ->join('tbl_supplier as supplier', 'supplier.supplier_id = invoice.supplier_id', 'LEFT')
			->join('tbl_supplie_epcg as epcg', 'epcg.supplie_epcg_id = invoice.epcg_licence_no', 'LEFT')
			->join('tbl_export_invoice as einvoice', 'einvoice.export_invoice_id = invoice.export_invoice_id', 'LEFT')
			->join('tbl_terms as terms', 'terms.terms_id = einvoice.terms_id', 'LEFT')
			->where('taxinvoice_id',$id)
			->get();
			//echo $this->db->last_query();
			return $q->row();
	}
	public function taxinvoice_update($data,$id)
	{
		$this->db->where('taxinvoice_id',$id);	
		$this->db->update('tbl_taxinvoice',$data);	
		return $this->db->last_query();
	}
	public function update_taxinvoicetrn($data,$id)
	{
		$this->db->where('taxinvoicetrn_id',$id);	
		return $this->db->update('tbl_taxinvoicetrn',$data);	
	}
	public function updateratedata($modelpricedata,$sericeskey)
	{
		$array = array('taxinvoice_rate_id' => $sericeskey);
		$this->db->where($array);		
		return $this->db->update('tbl_taxinvoice_rate',$modelpricedata);	
		   
	}
	public function update_taxsample($data_sample,$id)
	{
		$array = array('tax_sample_id' =>$id);
		$this->db->where($array);		
		return $this->db->update('tbl_tax_sample',$data_sample);
			 
	}
	public function update_taxsampletrn($data_sampletrn,$id)
	{
		$this->db->where('taxinvoicetrn_id',$id);	
		return $this->db->update('tbl_tax_sampletrn',$data_sampletrn);	
	}
	public function gettaxproductdata($id)
	{
		 $q = $this->db->select('mst.description_goods,mst.total_box as origanal_boxes,mst.total_sqm as no_of_sqm,mst.exportproduct_trn_id,mst.product_rate,mst.Total_Amount as product_amt,mst.per,pro.size_type_mm,,series.hsnc_code,series.series_name')
			 ->from('tbl_taxinvoicetrn as mst')
			 ->join('tbl_exportproduct_trn as loading_trn','loading_trn.exportproduct_trn_id = mst.exportproduct_trn_id', 'LEFT')
			 ->join('tbl_product as pro', 'pro.product_id = loading_trn.product_id', 'LEFT')
			->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
		 	->where('taxinvoice_id',$id)
			->get(); 
			 
	    return $q->result();
	}
	public function gettax_sample_productdata($id)
	{
		$array = array( 'trn.taxinvoice_id' =>$id);
		$q = $this->db->select('trn.*')
			 ->from('tbl_tax_sampletrn as trn')
			 ->where($array)
			->get();
		  
		return $q->result();	 
	}
	public function gettaxproductrate($id)
	{
		$q= $this->db->select("mst.*,series.seriesgroup_name,invoicedata.description_goods")
			 ->from("tbl_taxinvoice_rate as mst")
			 ->join("tbl_seriesgroup as series","series.seriesgroup_id=mst.model_type_id","LEFT")
			 ->join("tbl_taxinvoicetrn as invoicedata","invoicedata.taxinvoicetrn_id=mst.taxinvoicetrn_id","LEFT")
			 ->where("mst.taxinvoicetrn_id",$id)
			 ->get();
		 
		return $q->result();
	}
	public function delete_tax_trn($id)
	{
		
		$this->db->where('taxinvoice_id',$id);
		return $this->db->delete('tbl_taxinvoicetrn');
	}

	public function delete_tax_sample($id)
	{
		
		$this->db->where('taxinvoice_id',$id);
		return $this->db->delete('tbl_tax_sampletrn');
	}
}
