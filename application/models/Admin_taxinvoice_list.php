<?php 
class Admin_taxinvoice_list extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
		
	}
	
	public function getinvoicenodata()
	 {
		 $q = $this->db->where("status",0);
		 $q= $this->db->get("tbl_taxinvoice");
		  
		 return $q->result();
	 }
	 
	 
	 public function getconsigneenamedata()
	 {
		$q = $this->db->select('*')
			 ->from('customer_detail')
			->where('status=0')
			->order_by("c_companyname", "asc")
			->get();
		  
		 return $q->result();
	 }
	 
	 
	public function s_select(){
		$q = $this->db->select('invoice.*, consign.c_name, cosign.c_companyname')
			 ->from('tbl_performa_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			->where('status=0')
			->order_by("performa_date", "desc")
			->get();
		 
		return $q->result();
	}
	public function c_select($id){
		
		$this->db->where('customer_id',$id);	
		$q = $this->db->get('performa_invoice');
		return $q->result();
	}

	public function s_edit_select($id){
		$this->db->where('id',$id);
		$q = $this->db->get('performa_invoice');
		return $q->row();
	}
	public function taxdelete($id){
		
		$data = array("status"=>2);
		$this->db->where('taxinvoice_id',$id);
	 
		return $this->db->update('tbl_taxinvoice',$data);	
	}
	public function get_productdetail($id)
	{
		 $q = $this->db->select('mst.*, product.size_type_mm,code.p_name,code.hsnc_code')
			 ->from('tbl_taxinvoicetrn as mst')
			->join('tbl_product as product', 'product.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as series', 'product.series_id = series.series_id', 'LEFT')
			->join('product_code_detail as code', 'code.hsnc_code = series.hsnc_code', 'LEFT')
			->where('taxinvoice_id',$id)
			->get(); 
			 
			foreach ($q->result() as $category) {
				$sub = $category->taxinvoicetrn_id;
				 $category->serices = $this->gettaxproductrate($category->taxinvoicetrn_id);
				$return[] = $category;
				 
			  }  
			
		   return $return;
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
	public function updateexportinvoice($id)
	{
		$data = array("tax_status"=>0);
		$this->db->where('export_invoice_id',$id);
		return $this->db->update('tbl_export_invoice',$data);	
	}
}

?>