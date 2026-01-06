<?php

class Customer_invoice_model extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function getcustomerdata()
	 {
		 $q = $this->db->where("status",0);
		 $q= $this->db->get("tbl_customer_invoice");
		  
		 return $q->result();
	 }
	
	public function select_exporter()
	{
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	} 
	public function html_delete($id)
	{
		$q1 = $this->db->where('table_id',$id);
		$q1 = $this->db->delete('tbl_invoices_html');
		return $q1; 		
	}
	public function get_invoice_html($cust_id)
	{
		$q = $this->db->where('table_id',$cust_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','commercial_invoice');
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
	public function get_bl_html($cust_id)
	{
		$q = $this->db->where('table_id',$cust_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','bl_html');
		$q = $this->db->get('tbl_invoices_html');
		  
	 	return $q->row();
	} 
	public function get_coo_html($cust_id)
	{
		$q = $this->db->where('table_id',$cust_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','coo_html');
		$q = $this->db->get('tbl_invoices_html');
		  
	 	return $q->row();
	} 
	public function packing_html_data($cust_id)
	{
		$q = $this->db->where('table_id',$cust_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','commercial_packing_html');
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
	public function customerinvoicedelete($id)
	{
		
		$data = array("status"=>2);
		$updateid = $this->db->where('customer_invoice_id',$id);
		$updateid = $this->db->update('tbl_customer_invoice',$data);
		  
		return 	$updateid;
	}
	public function insert_productrecord($data){
		 
		$this->db->insert('tbl_customer_invoice_trn',$data);
		 return  $this->db->insert_id();
	}
	public function select_consigner()
	{
		$q = $this->db->get('customer_detail');
		return $q->result();
	}
	public function other_consigner($id){
		$q = $this->db->where('customer_id',$id);
		$q = $this->db->get('customer_add_consigner');
		//  echo $this->db->last_query();
		return $q->result();
	}
	public function updatecustomer($export_data,$customer_invoice_id)
	{
		$q= $this->db->where('customer_invoice_id', $customer_invoice_id); 
		$q= $this->db->update('tbl_customer_invoice',$export_data);
		  
		return $q;//Set 
	}
	 
 	// public function get_invoice_data($id)
	// {
		// $q = $this->db->select('invoice.*, consign.c_name, consign.c_companyname, cur.currency_name,cur.currency_code, cur.currency_id,term.terms_name,export.export_ref_no as exportref_no,export.aeo_no,export.lut_no,export.performa_date,export.export_invoice_no,export.direct_invoice,export.performa_invoice_id,export.calculation_operator,export.commision_amt as total_commision_rate,export.rex_no_detail as export_rex_no_detail,consign.rex_no_detail as rexnodetail,consign.rex_detail_status  as rexdetail_status,invoice.rex_no as rexno')
			 // ->from('tbl_customer_invoice as invoice')
			 // ->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			 // ->join('tbl_currency as cur', 'invoice.invoice_currency_id = cur.currency_id', 'LEFT')
			 // ->join('tbl_terms as term', 'term.terms_id = invoice.terms_id', 'LEFT')
			 // ->join('tbl_export_invoice as export', 'export.export_invoice_id = invoice.export_invoice_id', 'LEFT')
			 // ->where('customer_invoice_id',$id)
			 // ->get();
		  
			// return $q->row();
	// }
public function get_invoice_data($id)
{
    $q = $this->db
        ->select('
            invoice.*, 
            consign.c_name,
            consign.c_companyname,
            consign.rex_no_detail AS rexnodetail,
            consign.rex_detail_status AS rexdetail_status,
            cur.currency_name,
            cur.currency_code,
            cur.currency_id,
            term.terms_name,
            export.export_ref_no AS exportref_no,
            export.Exchange_Rate_val,
            export.indian_ruppe_val,
            export.indian_ruppe_after_gst,
            export.igst_status,
            export.remarks as expremarks,
            export.aeo_no,
            export.lut_no,
            export.performa_date,
            export.export_invoice_no,
            export.direct_invoice,
            export.performa_invoice_id,
            export.calculation_operator,
            export.commision_amt AS total_commision_rate,
            export.rex_no_detail AS export_rex_no_detail,
            pi.sign_detail_id,
            user.sign_pi_status,
            user.for_signature_name,
            user.sign_image,
            user.authorised_signatury,
            user.contact_person_name,
            user.contact_no,
            user.contact_email
        ')
        ->from('tbl_customer_invoice AS invoice')
        ->join('customer_detail AS consign', 'invoice.consiger_id = consign.id', 'LEFT')
        ->join('tbl_currency AS cur', 'invoice.invoice_currency_id = cur.currency_id', 'LEFT')
        ->join('tbl_terms AS term', 'term.terms_id = invoice.terms_id', 'LEFT')
        ->join('tbl_export_invoice AS export', 'export.export_invoice_id = invoice.export_invoice_id', 'LEFT')
        ->join('tbl_performa_invoice AS pi', 'pi.performa_invoice_id = export.performa_invoice_id', 'LEFT')
        ->join('tbl_user AS user', 'user.user_id = pi.sign_detail_id', 'LEFT')
        ->where('customer_invoice_id', $id)
        ->get();

    return $q->row();
}
	public function customer_invoice_stepupdate($id,$step,$temp_status){
		$data = array(
          "step" =>$step
		); 
		 
		$this->db->where('customer_invoice_id', $id);
		return $this->db->update('tbl_customer_invoice', $data);
	}
	public function delete_from_commercial($export_sampletrn_id,$commercial_status){
		$data = array(
          "commercial_status" =>$commercial_status
		); 
		 
		$q = $this->db->where('export_sampletrn_id', $export_sampletrn_id);
		$q = $this->db->update('tbl_export_sampletrn', $data);
		 
		return $q;
	}  
	public function get_container_data($id)
	{	
		$q = $this->db->where('exportinvoice_id',$id);
		$q = $this->db->get('tbl_exportmakecontainer');
			 return $q->result();
		 
	}
	public function selectinvoicetype($id){
		$q = $this->db->where('invoicetype_id',$id);
		$q = $this->db->get('tbl_invoicetype');
		return $q->row();
	}
	 
	 
	public function select_invoice_data($id,$array)
	{
		
		$q = $this->db->select('
    invoice.*,
    invoice.invoice_date as current_invoice_date,
    pinvoice.invoice_no as performa_invoice,
    pinvoice.performa_date,
    pinvoice.payment_terms as performa_payment_terms,
    consign.c_name,
    consign.c_companyname,
    consign.c_address,
    consign.c_city,
    country.c_name as country_name,
    (SELECT GROUP_CONCAT(invoice_date) FROM `tbl_export_invoice` WHERE export_invoice_id IN ('.implode(",", $array).')) as all_invoice_dates,
    (SELECT GROUP_CONCAT(export_invoice_no) FROM `tbl_export_invoice` WHERE export_invoice_id IN ('.implode(",", $array).')) as export_invoice_no,
    (SELECT SUM(container_details) FROM `tbl_export_invoice` WHERE export_invoice_id IN ('.implode(",", $array).')) as no_of_container,
    (SELECT SUM(container_forty) FROM `tbl_export_invoice` WHERE export_invoice_id IN ('.implode(",", $array).')) as container_forty,
    (SELECT SUM(container_twenty) FROM `tbl_export_invoice` WHERE export_invoice_id IN ('.implode(",", $array).')) as container_twenty,
    (SELECT GROUP_CONCAT(Shipping_Bill_no) FROM `upload_shiping_bill` WHERE export_invoice_id IN ('.implode(",", $array).')) as Shipping_Bill_no,
    (SELECT GROUP_CONCAT(bill.date) FROM `upload_shiping_bill` AS bill WHERE export_invoice_id IN ('.implode(",", $array).')) as Shipping_date
')

			 ->from('tbl_export_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			->join('country_detail as country', 'country.id = consign.c_country', 'LEFT')
			->join('tbl_performa_invoice as pinvoice', 'pinvoice.performa_invoice_id = invoice.performa_invoice_id', 'LEFT')
			->where('invoice.export_invoice_id',$id)
			->order_by("invoice_date", "desc")
			->get();
			
		 	return $q->row();
	}
	
	public function productdata_select($id)
	{
		$q = $this->db->where('invoice_id',$id);
		$q = $this->db->order_by("product_container", "desc");
		$q = $this->db->get('tbl_invoice_product_data');
		
		 
		return $q->result();
	}
	public function ciadmin_login()
	{
		$q = $this->db->get('ciadmin_login');
		return $q->row();
	}
	 public function bank_detail($id){
		$this->db->where('id',$id);
		$q = $this->db->get('bank_detail');
		return $q->row();
	}
	public function invoice_firststep($data){
		 
		$this->db->insert('tbl_customer_invoice',$data);
		 return  $this->db->insert_id();
	}
	public function update_invoicenumber($id,$invoice_series)
	{
		$data = array("invoice_series"=>($invoice_series+1));
		$this->db->where('invoicetype_id',$id);	
		return $this->db->update('tbl_invoicetype',$data);	
			
	}
	public function update_cust_status($id,$status)
	{
		$qry = "UPDATE `tbl_export_invoice` set `customer_invoice` = ".$status." where export_invoice_id in (".$id.")";
		 $query = $this->db->query($qry);
		 if($status == 0)
		 {
			 $qry1 = "UPDATE `tbl_exportproduct_trn` set `cust_hsnc_code` = '',`cust_description_goods` = '' where export_invoice_id in (".$id.")";
			$query1 = $this->db->query($qry1);
		 }
		 return $query;
	}
	
	public function s_edit($data,$id)
	{
		$this->db->where('export_invoice_id',$id);	
		return $this->db->update('tbl_export_invoice',$data);	
		
	}
	 public function updatehsnc_code($data,$id)
	{
		$q = $this->db->where('exportproduct_trn_id',$id);	
		$q = $this->db->update('tbl_exportproduct_trn',$data);	
	 
		return $q;
	}
	 
	public function exportinvoice_data($id){
		$q = $this->db->select('invoice.*, consign.c_name')
			 ->from('tbl_export_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			->where('export_invoice_id',$id)
			->get();
			//echo $this->db->last_query();
			return $q->row();
	}
	public function cutomerinvoice_update($data,$id)
	{
		$this->db->where('customer_invoice_id',$id);	
		return $this->db->update('tbl_customer_invoice',$data);	
	}
	public function update_customer_invoice_data($data,$id)
	{
		$this->db->where('export_loading_trn_id',$id);	
		return $this->db->update('tbl_export_loading_trn',$data);	
	}
	 
	 public function gettermsdata()
	{
		$q = $this->db->where('status !=','2');
		$q = $this->db->get('tbl_terms');
		return $q->result();
	}
		public function get_all_performainvoice()
	{
		$q = $this->db->where('status',3);
		$q = $this->db->get('tbl_performa_invoice');
	 	return $q->result();
	}
	public function loadingtrn_data($export_invoice_id)
	{
		$q= $this->db->select("mst.*, model.design_file,model.model_name,pro.size_width_mm,pro.size_height_mm,pro.size_type_mm,serices.hsnc_code,code.p_name,code.hsnc_code")
			 ->from("tbl_export_loading_trn as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
		 	 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			 ->join("tbl_series as serices","serices.series_id=pro.series_id","LEFT")
			  ->join('product_code_detail as code', 'code.hsnc_code = serices.hsnc_code', 'LEFT')
			 ->where("mst.export_invoice_id",$export_invoice_id)
			 ->get();
	 
		   return $q->result(); 
 	}
}
