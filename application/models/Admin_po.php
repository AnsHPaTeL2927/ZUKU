<?php

class Admin_po extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function update_producation_status($id,$status)
	{
		$qry = "UPDATE `tbl_production_mst` set `po_status` = ".$status." where production_mst_id in (".$id.")";
		 $query = $this->db->query($qry);
		 return $query;
	}
	
	public function select_exporter(){
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	}

	public function select_supplier(){
		$q = $this->db->get('tbl_supplier');
		return $q->result();
	}
	public function other_consigner($id){
		$q = $this->db->where('customer_id',$id);
		$q = $this->db->get('customer_add_consigner');
		//  echo $this->db->last_query();
		return $q->result();
	}
	
	public function selectinvoicetype($id){
		$q = $this->db->where('invoicetype_id',$id);
		$q = $this->db->get('tbl_invoicetype');
		return $q->row();
	}
	 
	 
	public function select_invoice_data($id,$array)
	{
		$q = $this->db->select('mst.*, invoice.exporter_detail,invoice.port_of_loading,invoice.final_destination,
		consign.c_name,invoice.performa_invoice_id,additional.loading_by,additional.pallet_by,additional.qc_by,
		
		(SELECT GROUP_CONCAT(iinvoice.performa_invoice_id) as invoice_no FROM `tbl_production_mst` as innerqry 
			inner join tbl_performa_invoice as iinvoice on iinvoice.performa_invoice_id = innerqry.performa_invoice_id 
			WHERE production_mst_id in ('.implode(",",$array).'))  as performa_invoice_id,
	
		(SELECT GROUP_CONCAT(iinvoice.invoice_no) as invoice_no FROM `tbl_production_mst` as innerqry 
			inner join tbl_performa_invoice as iinvoice on iinvoice.performa_invoice_id = innerqry.performa_invoice_id 
			WHERE production_mst_id in ('.implode(",",$array).'))  as invoice_no,
		
		(SELECT GROUP_CONCAT(production_mst_id) as production_mst_id FROM `tbl_production_mst` WHERE production_mst_id in ('.implode(",",$array).')) as production_mst_id,
		
		(SELECT SUM(no_of_countainer) as no_of_container FROM `tbl_production_mst` WHERE production_mst_id in ('.implode(",",$array).')) as no_of_countainer,
		(SELECT SUM(con_twentry) as container_forty FROM `tbl_production_mst` WHERE production_mst_id in ('.implode(",",$array).')) as container_twenty,
		(SELECT SUM(con_fourty) as con_fourty FROM `tbl_production_mst` WHERE production_mst_id in ('.implode(",",$array).')) as container_forty,
		')
			->from('tbl_production_mst as mst')
		 	->join('tbl_performa_invoice as invoice', 'invoice.performa_invoice_id = mst.performa_invoice_id', 'LEFT')
		 	->join('tbl_performa_additional_detail as additional', 'additional.production_mst_id = mst.production_mst_id', 'LEFT')
		 	->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			->where('mst.production_mst_id',$id)
		 	->get();
			  
		 	return $q->row();
	}
	 
	public function productdata_select($id){
		$q = $this->db->where('invoice_id',$id);
		$q = $this->db->order_by("product_container", "desc");
		$q = $this->db->get('tbl_invoice_product_data');
		
		 
		return $q->result();
	}
	 public function supplierdetail($id){
		$this->db->where('supplier_id',$id);
		$q = $this->db->get('tbl_supplier');
		return $q->row();
	}
	public function insertpo($data){
		 
		$cid = $this->db->insert('tbl_purchase_order',$data);
		  return $cid = $this->db->insert_id();
	}
	
	public function update_invoicenumber($id,$invoice_series)
	{
		$data = array("invoice_series"=>$invoice_series);
		$this->db->where('invoicetype_id',$id);	
		return $this->db->update('tbl_invoicetype',$data);	
			
	}
	public function s_edit($data,$id)
	{
		$this->db->where('export_invoice_id',$id);	
		return $this->db->update('tbl_export_invoice',$data);	
		
	}
	public function update_performa($id,$no_of_po)
	{
		$data = array("no_of_po"=>$no_of_po);
		$this->db->where('performa_invoice_id',$id);	
		return $this->db->update('tbl_performa_invoice',$data);	
			
	}
	public function po_data($id){
		$q = $this->db->select('po.*,supplier.supplier_name')
			 ->from('tbl_purchase_order as po')
			->join('tbl_supplier as supplier', 'supplier.supplier_id = po.seller_id', 'LEFT')
			->where('purchase_order_id',$id)
			->get();
		  
			return $q->row();
	}
	public function po_update($data,$id)
	{
		$this->db->where('purchase_order_id',$id);	
		return $this->db->update('tbl_purchase_order',$data);	
	}
}
