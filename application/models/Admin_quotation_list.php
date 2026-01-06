<?php 
class Admin_quotation_list extends CI_Model
{

	public function __construct()
	{
		parent:: __construct();	
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
	
	public function select_quotation_data($id)
	{
		$q = $this->db->select('invoice.*, consign.c_name,cur.currency_name,cur.currency_id,term.terms_name,cur.currency_code,')
			 ->from('tbl_estimate as invoice')
			->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			->join('tbl_currency as cur', 'invoice.invoice_currency_id = cur.currency_id', 'LEFT')
			->join('tbl_terms as term', 'term.terms_id = invoice.terms_id', 'LEFT')
			->where('estimate_id',$id)
		 	->get();
			return $q->row();
	}
	public function selectinvoicetype($id){
		$q = $this->db->where('invoicetype_id',$id);
		$q = $this->db->get('tbl_invoicetype');
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
	public function other_consigner($id){
		$q = $this->db->where('customer_id',$id);
		$q = $this->db->get('customer_add_consigner');
		// echo $this->db->last_query()
		return $q->result();
	}
	public function customerallconsignerdetail($id)
	{
		$this->db->where('customer_id',$id);
		$q = $this->db->get('customer_add_consigner');
		return $q->result();
	}
	public function quotation_insert($data){
		 
		$cid = $this->db->insert('tbl_estimate',$data);
		  return $cid = $this->db->insert_id();
	}
		public function update_quotation($quotation_data,$quotationid){
		$q= $this->db->where('estimate_id', $quotationid); 
		$q= $this->db->update('tbl_estimate',$quotation_data);
		// 	echo $this->db->last_query();
		return $q;//Set 
	}
	public function select_exporter(){
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	}

	public function select_consigner()
	{
		if($this->session->usertype_id != 1)
		{
			$q = $this->db->where('find_in_set(id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = '.$this->session->id.' and status =0)) <> ',"0");
		}
		$q = $this->db->where('status',0);
		$q = $this->db->get('customer_detail');
		return $q->result();
	}
	public function quotation_delete($id)
	{
		$data = array("status"=>2);
		$this->db->where('estimate_id',$id);
		return $this->db->update('tbl_estimate',$data);	
	}
	public function gettermsdata()
	{
		$q = $this->db->where('status !=','2');
		$q = $this->db->get('tbl_terms');
		return $q->result();
	}
	public function get_productdetail($id)
	{
		$q = $this->db->where('invoice_id',$id);
		$q = $this->db->order_by("product_container", "desc");
		$q = $this->db->order_by("container_order_by", "asc");
		$q = $this->db->get('tbl_invoice_product_data');
		foreach ($q->result() as $category) {
			$sub = $category->invoice_product_data_id;
			$category->serices = $this->getproductrate($category->invoice_product_data_id);
			$return[] = $category;
		}
		
		return $return;
	}
	
	
	
	public function getproductrate($id)
	{
		$q= $this->db->select("mst.*,series.seriesgroup_name,invoicedata.description_goods")
			 ->from("tbl_performa_product_rate as mst")
			 ->join("tbl_seriesgroup as series","series.seriesgroup_id=mst.model_type_id","LEFT")
			 ->join("tbl_invoice_product_data as invoicedata","invoicedata.invoice_product_data_id=mst.product_trn_id","LEFT")
			 ->where("product_trn_id",$id)
			 ->get();
		 
		return $q->result();
	}
	
}

?>