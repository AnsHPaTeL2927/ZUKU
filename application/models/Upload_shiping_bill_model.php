<?php
class Upload_shiping_bill_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function insert_bl($data){

		$id = $this->db->insert('upload_shiping_bill',$data);
		 
		return $this->db->insert_id();
	}
	public function insert_bl_trn($data){

		$id = $this->db->insert('upload_shiping_bill_trn',$data);
		 
		return $this->db->insert_id();
	}
	public function get_export_data($id)
	{
		$q = "SELECT export_invoice_id,export_invoice_no,consiger_id from tbl_export_invoice where status=0 and export_invoice_id = '$id' and invoice_date >='2020-04-01'";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	public function get_customer_data($id)
	{
		$q = "SELECT c_name,c_companyname from customer_detail where id = '$id'";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	public function fetchmodeldata($id)
	 {
		 $q = $this->db->where("id",$id);
		 $q= $this->db->get("upload_shiping_bill");
		  
		 return $q->row();
	 }
	public function shiping_bill_select(){
		$q=$this->db->order_by('id','desc');
		$q=$this->db->get('upload_shiping_bill');
		return $q->result();
	}
	public function update_bl($id,$insert_id){
		
		$data = array(
			"upload_shiping_bill" =>$insert_id
			);
		$this->db->where('export_invoice_id',$id);
		$q=$this->db->update('tbl_export_invoice',$data);
		return $q;
	}
	public function updatedata($data,$id)
	{ 	
	   $this->db->where('id',$id);
	   $updateid= $this->db->update('upload_shiping_bill',$data);
	   return $updateid;
	}
	public function removeupdate_bl($id){
		
		$data = array(
			"upload_bl" =>''
			);
		$this->db->where('upload_bl',$id);
		$q=$this->db->update('tbl_export_invoice',$data);
		return $q;
	}
	public function deleteupdate_bl($id){
	
		$this->db->where('id',$id);
		$q=$this->db->delete('upload_bl');
		return $q;
	}

	public function get_shipping_bill($id){
		$q = $this->db->where('id',$id);
		$q = $this->db->get('upload_shiping_bill');
		 return $q->row();
		 
	}
	public function get_shipping_bill_trn($id)
	{
		$q = $this->db->where('upload_shiping_bill_id',$id);
		$q = $this->db->join('tbl_export_packing as packing','packing.export_packing_id = mst.export_packing_id', 'LEFT');
		$q = $this->db->join('tbl_exportproduct_trn as trn','packing.exportproduct_trn_id = trn.exportproduct_trn_id', 'LEFT');
		$q = $this->db->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT");
		$q = $this->db->join('tbl_product as pro','pro.product_id = trn.product_id', 'LEFT');
		$q = $this->db->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT');
		$q = $this->db->join('tbl_finish as finish','finish.finish_id=packing.finish_id','LEFT');
		$q = $this->db->get('upload_shiping_bill_trn as mst');
		 
		 return $q->result();
		 
	}
	public function delete_shipping_bill_trn($id){
		
		$this->db->where('upload_shiping_bill_id',$id);
		return $this->db->delete('upload_shiping_bill_trn');
	}
	public function update_upload_bl($updata,$uid){
		
		$this->db->where('id',$uid);
		$q=$this->db->update('upload_shiping_bill',$updata);
		return $q;
	
	}
	public function get_customer()
	{
		$q = $this->db->get('customer_detail');
	 	return $q->result();
	}
	public function get_customer_detail($id)
	{
		$q = $this->db->where('id',$id);
		$q = $this->db->get('customer_detail');
	 	return $q->row();
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
	public function get_customer_bill($id,$start_date,$end_date)
	{
		$q = "SELECT `mst`.`export_invoice_id`,exportproduct_trn_id,`invoice_date`, `trn`.`description_goods`,`serices`.`series_name`, `export_invoice_no`, `product`.`size_type_mm`, `container_details`, `total_no_of_sqm`,  `total_product_amt`, `grand_total`, `certification_charge`, `insurance_charge`, `seafright_charge`, `calculation_operator`, terms_id FROM `tbl_export_invoice` as `mst` INNER JOIN `tbl_exportproduct_trn` as `trn` ON `trn`.`export_invoice_id`=`mst`.`export_invoice_id` LEFT JOIN `tbl_product` as `product` ON `product`.`product_id` = `trn`.`product_id` LEFT JOIN `tbl_series` as `serices` ON `serices`.`series_id` = `product`.`series_id`    WHERE `consiger_id` = ".$id." AND invoice_date between '".date('Y-m-d',strtotime($start_date))."' and '".date('Y-m-d',strtotime($end_date))."' and  invoice_date >= '2020-04-01' and mst.step = 4 and mst.status= 0 ORDER BY `export_invoice_id` ASC";
		$q_con = $this->db->query($q);
		 	foreach ($q_con->result() as $category) {
					$sub = $category->exportproduct_trn_id;
					$category->serices = $this->getproductrate($category->exportproduct_trn_id);
					$return[] = $category;
			  } 
			  
			  return $return;
		  
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
	public function get_total_bill_detail($id)
	{
		$q = "SELECT  sum(grand_total) as total_grand_total,(select sum(paid_amount) from tbl_payment where status=0 and customer_id = mst.consiger_id) as total_paid_amt  from  tbl_export_invoice as mst where mst.consiger_id = ".$id." and step =4 and status=0";
		$q_con = $this->db->query($q);
		return $q_con->row();
	} 
	public function get_due_amount($id)
	{
		$q = "SELECT grand_total,certification_charge, insurance_charge,seafright_charge,calculation_operator ,(select sum(paid_amount) from tbl_payment where status=0 and bill_id = mst.export_invoice_id) as total_paid_amt from  tbl_export_invoice as mst where mst.export_invoice_id = ".$id." and step=4 and status=0";
		$q_con = $this->db->query($q);
		return $q_con->row();
	}
	public function delete_payment($id){
		
		$data = array(
			"status" =>2
			);
		$this->db->where('payment_id',$id);
		$q=$this->db->update('tbl_payment',$data);
		return $q;
	}
	public function get_payment_detail($id,$customer_id)
	{
		$where = '';
		if(!empty($id))
		{
			$where  = ' and bill_id = '.$id;
		}
		else
		{
			$where  = ' and bill_id = 0';
		}
		
		$q = "select * from tbl_payment as mst left join tbl_payment_mode mode on mode.payment_mode_id=mst.payment_mode_id 
		left join bank_detail bank on bank.id=mst.bank_id where mst.customer_id=".$customer_id." and   mst.status=0 and mst.date >= '2020-04-01' ".$where;
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	public function get_customer_statement_detail($id)
	{
		 $q = "(select invoice_date as date,export_invoice_no as descrption,1 as entry, grand_total as amount from tbl_export_invoice where step = 4 and status=0 and consiger_id = ".$id.") UNION (select date,payment_mode as descrption,2 as entry,paid_amount as amount from tbl_payment as mst left join tbl_payment_mode as mode on mode.payment_mode_id=mst.payment_mode_id where mst.status=0 and customer_id=".$id.") order by date";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	public function get_bill_detail($id)
	{
		$q = "SELECT export_invoice_id,export_invoice_no,grand_total from  tbl_export_invoice as mst where mst.consiger_id = ".$id." and step =4 and status=0 and invoice_date >='2020-04-01'";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	public function get_customer_statement($id)
	{
		$where = '';
		if(!empty($id))
		{
			$where = ' where mst.id='.$id;
		}
		 $q = "SELECT mst.id,c_name,c_companyname,opening_balance,open_balance_status,currency_id,(SELECT SUM(grand_total) from tbl_export_invoice where consiger_id = mst.id and step=4 and STATUS = 0 and invoice_date >= '2020-04-01') as grand_total,(SELECT SUM(paid_amount) from tbl_payment where customer_id = mst.id and STATUS =0 and date >= '2020-04-01') as paid_amount,(SELECT SUM(bank_charge) from tbl_payment where customer_id = mst.id and STATUS =0 and date >= '2020-04-01') as bank_charge FROM `customer_detail` as mst".$where;
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
}

?>