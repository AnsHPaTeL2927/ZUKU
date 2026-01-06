<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Expense_model extends CI_model
{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	 
	public function getshippingdata()
	{
		$q = $this->db->select('shippingbill.*')
			 ->from('upload_shiping_bill as shippingbill')
			 //->join('tbl_export_invoice as export', 'shippingbill.export_invoice_id = export.export_invoice_id', 'LEFT')
			//->where('shippingbill.status',"0")
			->get();
		return $q->result();
	} 
	
	public function getexportinvoicedata()
	{
		$q = $this->db->select('shippingbill.*, export.export_invoice_no')
			 ->from('upload_shiping_bill as shippingbill')
			 ->join('tbl_export_invoice as export', 'shippingbill.export_invoice_id = export.export_invoice_id', 'LEFT')
			//->where('shippingbill.status',"0")
			->get();
		return $q->result();
	} 
	
	public function getinvoicedata()
	{
		$q = $this->db->select('invoicedata.*, export.export_invoice_no')
			 ->from('tbl_expense as invoicedata')
			 ->join('tbl_export_invoice as export', 'invoicedata.export_invoice_id = export.export_invoice_id', 'LEFT')
			->where('invoicedata.status',"0")
			->group_by('invoicedata.export_invoice_id')
			->get();
		return $q->result();
	}
	
	public function getpaymentdata()
	{
		$q = $this->db->select('payment.*, expenseparty.party_name')
			 ->from('tbl_expense_payment as payment')
			 ->join('tbl_expense_party as expenseparty', 'payment.expense_party_id = expenseparty.expense_party_id', 'LEFT')
			->where('payment.status',"0")
			->group_by('payment.expense_party_id')
			->get();
		return $q->result();
	}
 
	public function getexpensedata()
	{
		$q = $this->db->select('expense.*, expenseparty.party_name')
			 ->from('tbl_expense as expense')
			 ->join('tbl_expense_party as expenseparty', 'expense.expense_party_id = expenseparty.expense_party_id', 'LEFT')
			 // ->join('tbl_expense_category as expensecategory', 'expense.expense_category_id = expensecategory.expense_category_id', 'LEFT')
			->where('expense.status',"0")
			->group_by('expense.expense_party_id')
			->get();
		return $q->result();
	}
	
	// public function expense_outstanding_report()
	// {
		// $q = $this->db->select('expense.*, party.expense_party_id, party.party_name')
			 // ->from('tbl_expense as expense')
			 // ->join('tbl_expense_party as party', 'party.expense_party_id = expense.expense_party_id', 'LEFT')
			 // // ->join('tbl_expense_category as expensecategory', 'expense.expense_category_id = expensecategory.expense_category_id', 'LEFT')
			// ->where('expense.status',"0")
			// // ->where('expense.expense_category_id !=', "12")
			// // ->group_by('expense.expense_party_id')
			// ->get();
		// return $q->result();
	// }

	public function expense_outstanding_report()
	{
		 $q = "SELECT party.expense_party_id,party.party_name,datediff(CURRENT_DATE(), expense_date) as days,total_amt,(select sum(paid_amount + kasar_amount + tds_amount) from  tbl_expense_payment_trn where status!=2  and expense_id = mst.expense_id) as total_paid_amt,party.credit_days  from  tbl_expense as mst 
		INNER JOIN tbl_expense_party as party ON party.expense_party_id = mst.expense_party_id
		where mst.expense_category_id != 12 and mst.status!=2 order by days desc";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	
	public function insert_expense_category($data){
		$id = $this->db->insert('tbl_expense_category',$data);
		return $this->db->insert_id();
	}
	public function insert_expense_payment($data)
	{
		$id = $this->db->insert('tbl_expense_payment',$data);
		return $this->db->insert_id();
	}
	public function insert_expense_payment_trn($expense_payment_data)
	{
		$id = $this->db->insert('tbl_expense_payment_trn',$expense_payment_data);
		return $this->db->insert_id();
	}
	public function insert_expense_party($data){
		$id = $this->db->insert('tbl_expense_party',$data);
		return $this->db->insert_id();
	}
	public function insert_expense($data){
		$id = $this->db->insert('tbl_expense',$data);
		return $this->db->insert_id();
	}
	public function get_expense_category($id){

		$q=$this->db->where('expense_category_id',$id);
		$q=$this->db->get('tbl_expense_category');
		 
		return $q->row();
	}
	public function get_expensedata($id){

		$q=$this->db->where('expense_id',$id);
		$q=$this->db->get('tbl_expense');
		 
		return $q->row();
	}
	public function get_expensepaymentdata($id){

		$q=$this->db->where('expense_payment_id',$id);
		$q=$this->db->get('tbl_expense_payment');
		 
		return $q->row();
	}
	public function get_expense_party($id){

		$q=$this->db->where('expense_party_id',$id);
		$q=$this->db->get('tbl_expense_party');
		 
		return $q->row();
	}
	public function get_expenseparty($id){

		if(!empty($id))
		{
			$q=$this->db->where('find_in_set('.$id.',mst.expense_category_id) and mst.expense_category_id !=',0);
		}
		$q=$this->db->where('mst.status',0);
		$q=$this->db->join('tbl_expense_category as cat','cat.expense_category_id = mst.expense_category_id');
		$q=$this->db->get('tbl_expense_party as mst');
		 
		return $q->result();
	}
	public function update_expense_party($data,$id){

		$q =	$this->db->where('expense_party_id',$id);
		$q =	$this->db->update('tbl_expense_party',$data);
		  
		return $q;
	}
	public function update_expense_payment($id,$data){

		$q =	$this->db->where('expense_payment_id',$id);
		$q =	$this->db->update('tbl_expense_payment',$data);
		  
		return $q;
	}
	public function update_expense($expense_id,$data){

		$q =	$this->db->where('expense_id',$expense_id);
		$q =	$this->db->update('tbl_expense',$data);
		 
		return $q;
	}
	public function update_shipping_bill($data,$upload_shipping_bill_id){

		$q =	$this->db->where('id',$upload_shipping_bill_id);
		$q =	$this->db->update('upload_shiping_bill',$data);
		 
		return $q;
	}
	public function update_expense_category($data,$id){

		$this->db->where('expense_category_id',$id);
		$q=$this->db->update('tbl_expense_category',$data);
		return $q;
	}
	public function delete_record_party($id){
		$data = array(
			"status" => 2
		);
		$q = $this->db->where('expense_party_id',$id);
		return $this->db->update('tbl_expense_party',$data);
	}
	public function delete_record($id){
		$data = array(
			"status" => 2
		);
		$q = $this->db->where('expense_category_id',$id);
		return $this->db->update('tbl_expense_category',$data);
	}
	public function delete_expense($id){
		
		$data = array(
			"status" => 2
		);
		
		$q =  $this->db->where('expense_id',$id);
		return $this->db->update('tbl_expense',$data);
	}
	public function get_payment_mode()
	{
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_payment_mode');
		 
		return $q->result();
	}
	public function get_export_invoice()
	{
		$q=$this->db->where('status',0);
		$q=$this->db->where('step',4);
		$q=$this->db->get('tbl_export_invoice');
		 
		return $q->result();
	}
	public function get_expensecategory()
	{
		$q=$this->db->where('status',0);
		 
		$q=$this->db->get('tbl_expense_category');
		 
		return $q->result();
	}
	public function get_due_bill($id)
	{
	 $q = "SELECT expense_id,expense_date as date, reference_no,amount,total_amt,
		   (SELECT sum(paid_amount + kasar_amount + tds_amount) from tbl_expense_payment_trn   where expense_id = mst.expense_id and status=0) as paid_amount
           FROM `tbl_expense` as `mst` 
	    	WHERE mst.status = 0 and expense_party_id = ".$id;
			$q_con = $this->db->query($q);
			return $q_con->result();
		  
	} 
	public function get_due_bill_edit($expense_id,$expense_payment_id)
	{
	 $q = "SELECT *  FROM `tbl_expense_payment_trn` as `mst` 
	    	WHERE mst.status = 0 and expense_id = ".$expense_id." and expense_payment_id =".$expense_payment_id;
			$q_con = $this->db->query($q);
			return $q_con->row();
		  
	} 
	public function delete_expense_payment($expense_payment_id)
	{
		$data = array(
			"status" => 2
		);
		$q = $this->db->where('expense_payment_id',$expense_payment_id);
		$q = $this->db->update('tbl_expense_payment_trn',$data);
		 
		return $q;
	}
	public function delete_expensepayment($expense_payment_id)
	{
		$data = array(
			"status" => 2
		);
		 
		$q1 = $this->db->where('expense_payment_id',$expense_payment_id);
		$q1 = $this->db->update('tbl_expense_payment',$data);
		 
		$q = $this->db->where('expense_payment_id',$expense_payment_id);
		$q = $this->db->update('tbl_expense_payment_trn',$data);
		 
		return $q;
	}
}


?>