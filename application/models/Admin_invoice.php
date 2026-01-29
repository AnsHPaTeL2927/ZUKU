<?php

class Admin_invoice extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function terms_insert($data1)
	{
		$id = $this->db->insert('tbl_payment_terms',$data1); 
		return $this->db->insert_id();
	}
	
	public function check_terms_update($payment_terms)
	{
		$q=$this->db->where('payment_terms',$payment_terms);
		
		$q=$this->db->get('tbl_payment_terms');

		return $q->row();
	}

	public function select_exporter(){
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	}

	public function select_consigner()
	{
		$q = $this->db->get('customer_detail');
		return $q->result();
	}
	
	// perfect work fetch code
	// public function select_consigner()
	// {
		// if ($this->session->usertype_id != 1) {
			// $this->db->select('customer_detail.*');
			// $this->db->from('customer_detail');
			// $this->db->join('tbl_user_wise_customer', 'tbl_user_wise_customer.customer_id = customer_detail.id', 'inner');
			// $this->db->where('tbl_user_wise_customer.user_id', $this->session->id);
			// $this->db->where('tbl_user_wise_customer.status', 0);
			// $this->db->where('customer_detail.status', 0);
		// } else {
			// // Admin or superuser: return all active customers
			// $this->db->where('status', 0);
			// $this->db->from('customer_detail');
		// }

		// $query = $this->db->get();
		// return $query->result();
	// }


	// public function select_consigner()
	// {
		// if($this->session->usertype_id != 1)
		// {
			// $q = $this->db->where('find_in_set(id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = '.$this->session->id.' and status =0)) <> ',"0");
		// }
		// $q = $this->db->where('status',0);
		// $q = $this->db->get('customer_detail');
		// return $q->result();
	// }
	public function other_consigner($id){
		$q = $this->db->where('customer_id',$id);
		$q = $this->db->get('customer_add_consigner');
		// echo $this->db->last_query()
		return $q->result();
	}
	
	public function selectinvoicetype($id){
		$q = $this->db->where('invoicetype_id',$id);
		$q = $this->db->get('tbl_invoicetype');
		return $q->row();
	}
	public function performainvoice_insert($data){
		 
		$cid = $this->db->insert('tbl_performa_invoice',$data);
		  return $cid = $this->db->insert_id();
	}
	public function update_invoicenumber($id,$invoice_series)
	{
		$data = array("invoice_series"=>$invoice_series);
		$this->db->where('invoicetype_id',$id);	
		return $this->db->update('tbl_invoicetype',$data);	
	}
	public function updateperformainvoice($data,$id)
	{
		$q1 = $this->db->where('invoice_table_name','performa_invoice_pdf1');
		$q1 = $this->db->where('table_id',$id);
		$q1 = $this->db->delete('tbl_invoices_html');
			$this->db->where('performa_invoice_id',$id);	
		return $this->db->update('tbl_performa_invoice',$data);	
 	}
	
	public function getinvoicedata($id){
		$this->db->where('performa_invoice_id',$id);
		$q = $this->db->get('tbl_performa_invoice');
		return $q->row();
	}
	public function check_performa_no($invoice_no, $exclude_id = null)
	{
		$this->db->where('status',0);
		$this->db->where('invoice_no',$invoice_no);
		// Exclude current invoice ID when checking for duplicates in edit mode
		if(!empty($exclude_id)) {
			$this->db->where('performa_invoice_id !=', $exclude_id);
		}
		$q = $this->db->get('tbl_performa_invoice');
		return $q->row();
	}
	
	public function check_consigne_id($consign_detail)
	{
		// $this->db->where('status',0);
		$this->db->where('consign_detail',$consign_detail);
		$q = $this->db->get('tbl_performa_invoice');
		return $q->row();
	}
	
	public function customerdetail($id)
	{
	 	$q =$this->db->select('cust.*, country.c_name as country_name,country.company_rules,cur.currency_id,cur.currency_name ,detail.container_weight,detail.note,detail.bank_id,bdetail.*')
			 ->from('customer_detail as cust')
			 ->where('cust.id',$id)
			 ->join('country_detail as country', 'cust.c_country = country.id', 'LEFT')
			 ->join('tbl_currency as cur', 'cur.currency_id = cust.currency_id', 'LEFT')
			 ->join('tbl_customer_add_detail as detail', 'detail.customer_id = cust.id', 'LEFT')
			 ->join('bank_detail as bdetail', 'bdetail.id = detail.bank_id', 'LEFT')
			->get();
		return $q->row();
	}
	public function customerallconsignerdetail($id)
	{
		$this->db->where('customer_id',$id);
		$q = $this->db->get('customer_add_consigner');
		return $q->result();
	}	
	public function customerconsignerdetail($id)
	{
		$q = $this->db->select('mst.*')
			->from('customer_add_consigner as mst')
			->where('mst.id',$id)
	 		->get();
		return $q->row();
	}	
	public function gettermsdata()
	{
		$q = $this->db->where('status','0');
		$q = $this->db->get('tbl_terms');
		return $q->result();
	}
	public function payment_data($id,$mode)
	{
		$where = 'and (!find_in_set(payment_id,(select GROUP_CONCAT(advance_payment_id) from tbl_export_invoice where status !=2)) or (select count(advance_payment_id) from tbl_export_invoice where status !=2) = 0)';
		if($mode == "Edit")
		{
			$where ='';
		}
		$q =  'select * from tbl_payment where customer_id='.$id.' and status!=2 and payment_mode_id=2 '.$where;
		$query =  $this->db->query($q);
		return $query->result();
	}
}
