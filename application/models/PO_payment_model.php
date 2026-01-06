<?php
class PO_payment_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function insert_payment($data)
	{
		$id = $this->db->insert('tbl_po_payment',$data);
		return $this->db->insert_id();
	}
	public function insert_po_payment_trn($data)
	{
		$id = $this->db->insert('tbl_po_payment_trn',$data);
		return $this->db->insert_id();
	}
	public function insert_receive_payment_part_trn($data)
	{
		$id = $this->db->insert('tbl_receive_payment_part_trn',$data);
		return $this->db->insert_id();
	}
	public function get_suppiler()
	{
		
		$q = $this->db->where('status',0);
		$q = $this->db->get('tbl_supplier');
	 	return $q->result();
	}
	public function delete_trn_payment($po_payment_id)
	{
		$q = $this->db->where('po_payment_id',$po_payment_id);
		$q = $this->db->delete('tbl_po_payment_trn');
		
		$q1 = $this->db->where('table_name','tbl_po_payment');
		$q1 = $this->db->where('table_main_id',$po_payment_id);
		$q1 = $this->db->delete('tbl_receive_payment_part_trn');
	 	return $q;
	}
	public function update_payment($data,$po_payment_id)
	{
		 
		$q = $this->db->where('po_payment_id',$po_payment_id);	
		$q = $this->db->update('tbl_po_payment',$data);	
		 
		return $q;
	}
	public function getpayment_detail($id)
	{

		$q=$this->db->where('po_payment_id',$id);
		$q=$this->db->get('tbl_po_payment');
		$data = $q->row();
		$data->trn_data = $this->getpayment_trn($id);
		return $data;
	}
	public function getpayment_trn($id)
	{
		$q=$this->db->where('po_payment_id',$id);
		$q=$this->db->join('tbl_purchase_order as order','order.purchase_order_id = trn.purchase_order_id','inner');
		$q=$this->db->select('trn.*,order.purchase_order_no,order.grand_total,(SELECT sum(bill_paid_amount)  FROM `tbl_po_payment_trn` where status = 0 and purchase_order_id = trn.purchase_order_id) as total_paid_amount,(select sum(amount) from tbl_receive_payment_part_trn as receive_trn inner join tbl_po_payment_trn as po_trn on po_trn.po_payment_trn_id =  receive_trn.table_trn_id where receive_trn.status = 0 and po_trn.purchase_order_id = trn.purchase_order_id and table_name = "tbl_po_payment") as extra_amount');
		
		$q=$this->db->get('tbl_po_payment_trn as trn');
		$return = array();
			foreach ($q->result() as $category)
			{
				$sub = $category->po_payment_trn_id;
				$category->receive_trn = $this->get_receive_trn($category->po_payment_trn_id);
				$return[] = $category;
			}
		return $return;  
		 
	}
	public function get_receive_trn($po_payment_trn_id)
	{
		$q = $this->db->where('trn.status',0);
	  	$q = $this->db->select('trn.*,(select amount from tbl_receive_payment_part_trn where receive_payment_part_id = trn.receive_payment_part_id and table_trn_id = '.$po_payment_trn_id.' and table_name ="tbl_po_payment") as amount');
		$q = $this->db->get('tbl_receive_payment_part as trn');
		
	 	return $q->result();
	}
	public function get_payment_mode()
	{
		$q = $this->db->where('status',0);
		$q = $this->db->get('tbl_payment_mode');
	 	return $q->result();
	}
	public function get_bank_detail()
	{
		 $q = $this->db->get('bank_detail');
	 	 return $q->result();
	}
	public function delete_payment($id)
	{
		$data = array(
			"status" => 2
		);
		$q = $this->db->where('po_payment_id',$id);	
		$q = $this->db->update('tbl_po_payment',$data);	
		
		$q1 = $this->db->where('po_payment_id',$id);	
		$q1 = $this->db->update('tbl_po_payment_trn',$data);	
		
		return $q;
	}
	public function get_due_bill($id)
	{
	 $q = "SELECT purchase_order_id,purchase_order_date as date, purchase_order_no,container_details,grand_total,1 as fromwhere,(SELECT sum(bill_paid_amount + (select sum(amount) from tbl_receive_payment_part_trn as receive_trn inner join tbl_po_payment_trn as po_trn on po_trn.po_payment_trn_id =  receive_trn.table_trn_id where receive_trn.status = 0 and po_trn.purchase_order_id = mst.purchase_order_id and table_name = 'tbl_po_payment')) FROM `tbl_po_payment_trn` where status = 0 and purchase_order_id = mst.purchase_order_id) as paid_amount
  FROM `tbl_purchase_order` as `mst` 
WHERE `seller_id` = ".$id." and mst.step = 2 and mst.status= 0 

and grand_total > if((SELECT sum(bill_paid_amount + (select sum(amount) from tbl_receive_payment_part_trn as receive_trn inner join tbl_po_payment_trn as po_trn on po_trn.po_payment_trn_id =  receive_trn.table_trn_id where receive_trn.status = 0 and po_trn.purchase_order_id = mst.purchase_order_id and table_name = 'tbl_po_payment')) FROM `tbl_po_payment_trn` where status = 0 and purchase_order_id = mst.purchase_order_id) >0,(SELECT sum(bill_paid_amount + (select sum(amount) from tbl_receive_payment_part_trn as receive_trn inner join tbl_po_payment_trn as po_trn on po_trn.po_payment_trn_id =  receive_trn.table_trn_id where receive_trn.status = 0 and po_trn.purchase_order_id = mst.purchase_order_id and table_name = 'tbl_po_payment')) FROM `tbl_po_payment_trn` where status = 0 and purchase_order_id = mst.purchase_order_id) , 0) 

ORDER BY purchase_order_date ASC";
		$q_con = $this->db->query($q);
		return $q_con->result();
		  
	} 
	public function get_receive_payment_part()
	{
		
		$q = $this->db->where('status',0);
		$q = $this->db->get('tbl_receive_payment_part');
	 	return $q->result();
	} 
	 
}

?>