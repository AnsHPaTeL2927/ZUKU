<?php
class Export_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function get_customer()
	{
		if($this->session->usertype_id != 1)
		{
			$q = $this->db->where('find_in_set(id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = '.$this->session->id.' and status =0)) <> ',"0");
		}
		$q = $this->db->get('customer_detail');
	 	return $q->result();
	} 
	public function get_country()
	{
		$q = $this->db->select('con.*')
			 ->from('country_detail as con')
			 ->get();
		 
		return $q->result();
	}
	public function get_size()
	{
		 $q= $this->db->select("mst.*,mst.size_type_mm as sizetypemm")
			 ->from("tbl_product as mst")
		 	 ->where('mst.status',"0")
			 ->group_by('mst.size_type_mm')
			 ->get();
		return $q->result();
	} 
	public function get_finish()
	{
		$q =  "SELECT `mst`.* FROM `tbl_finish` as `mst` WHERE mst.`status` = '0'";
		$query = $this->db->query($q);
		return $query->result();
	}
	public function get_pallet_type()
	{
		$q =  "SELECT * FROM `tbl_pallet_type` as `mst` WHERE mst.`status` = '0'  and pallet_type_name != ''";
		$query = $this->db->query($q);
		return $query->result();
	}
	public function get_export($customer_id,$start_date,$end_date)
	{
		$where = ' and mst.invoice_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consiger_id = ".$customer_id;
		}
		 if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consiger_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		  $sql = "SELECT   mst.export_invoice_id, mst.export_invoice_no, invoice_date, c_companyname, notify.notify_name,country_final_destination,mst.port_of_discharge,mst.payment_terms,container_details,seafright_charge,mst.discount,grand_total,Exchange_Rate_val,drawback_amount,received_date,
		(SELECT GROUP_CONCAT(invoice_no) from tbl_performa_invoice where find_in_set(performa_invoice_id,REPLACE(mst.performa_invoice_id,'-',','))) as performa_invoice_no,
		
		(SELECT GROUP_CONCAT(s_bill_no) from tbl_customer_invoice where find_in_set(mst.export_invoice_id,REPLACE(export_invoice_id,'-',',')) and status =0) as s_bill_no,
		
		(SELECT GROUP_CONCAT(s_date) from tbl_customer_invoice where find_in_set(mst.export_invoice_id,REPLACE(export_invoice_id,'-',',')) and status =0) as s_date,
		(SELECT GROUP_CONCAT(bl_no) from tbl_customer_invoice where find_in_set(mst.export_invoice_id,REPLACE(export_invoice_id,'-',',')) and status =0) as bl_no,
		(SELECT GROUP_CONCAT(bl_date) from tbl_customer_invoice where find_in_set(mst.export_invoice_id,REPLACE(export_invoice_id,'-',',')) and status =0) as bl_date,
		 
		(SELECT GROUP_CONCAT(distinct company_name) FROM `tbl_export_supplier` as sup inner join tbl_supplier as sup_mst on sup.suppiler_id = sup_mst.supplier_id where export_invoice_id = mst.export_invoice_id) as factory_name,
		
		(select GROUP_CONCAT(distinct series_name) FROM  tbl_exportproduct_trn as trn inner join tbl_product as pro on pro.product_id = trn.product_id inner join tbl_series as series on series.series_id = pro.series_id where trn.export_invoice_id = mst.export_invoice_id)  as product_name,
		
		(select GROUP_CONCAT(distinct size_type_mm) FROM  tbl_exportproduct_trn as trn inner join tbl_product as pro on pro.product_id = trn.product_id where trn.export_invoice_id = mst.export_invoice_id)  as size,
		
		(select sum(etrn.no_of_pallet + etrn.no_of_big_pallet + etrn.no_of_small_pallet) FROM  tbl_export_packing as etrn  where etrn.export_invoice_id = mst.export_invoice_id)  as all_no_of_pallet,
		
		(select sum(etrn.no_of_boxes) from  tbl_export_packing as etrn  where etrn.export_invoice_id = mst.export_invoice_id)  as all_no_of_boxes,
		
		(select sum(etrn.no_of_sqm) from  tbl_export_packing as etrn  where etrn.export_invoice_id = mst.export_invoice_id)  as all_no_of_sqm,
		
		(select sum(updated_net_weight) from tbl_export_loading_trn as etrn where etrn.export_invoice_id = mst.export_invoice_id order by updated_net_weight desc) as net_weight, 
		(select sum(updated_gross_weight) from tbl_export_loading_trn as etrn where etrn.export_invoice_id = mst.export_invoice_id order by updated_net_weight desc) as gross_weight, 
		
		
		
		(select sum(etrn.product_amt) from   tbl_export_packing as etrn  where etrn.export_invoice_id = mst.export_invoice_id)  as all_product_amt
		
		FROM `tbl_export_invoice` as mst 
	  	 left join customer_detail as cust on cust.id = mst.consiger_id 
	 	 left join customer_add_consigner as notify on notify.id = mst.notify_id 
	 	 left join upload_shiping_bill as bill on bill.export_invoice_id = mst.export_invoice_id 
	 	    
		 where mst.step =4 and  mst.status=0 ".$where.' order by  ExtractNumber(export_invoice_no) desc';
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_profit_report($customer_id,$country_id,$start_date,$end_date)
	{
		$where = ' and mst.invoice_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consiger_id = ".$customer_id;
		}
		if(!empty($country_id))
		{
			$where .= " and  cust.c_country = ".$country_id;
		}
		 if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consiger_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		$sql = "SELECT   mst.export_invoice_id, mst.export_invoice_no, invoice_date, c_companyname,container_details,
		
		(SELECT sum(total_amt) from tbl_expense where expense_category_id = 12 and status != 2 and export_invoice_id = mst.export_invoice_id) as factory_payment,
		(SELECT sum(total_amt) from tbl_expense where expense_category_id != 12 and status != 2 and export_invoice_id = mst.export_invoice_id) as other_payment,  
		
		(SELECT sum(inr_value) from  tbl_payment where bill_id = mst.export_invoice_id and status != 2) as receive_payment,  
		(SELECT sum(drawback_amount) from  upload_shiping_bill where export_invoice_id = mst.export_invoice_id and  status != 2) as drawback_amount, 
		(SELECT sum(rodtep_amount) from  upload_shiping_bill where export_invoice_id = mst.export_invoice_id  and  status != 2) as rodtep_amount 
		
		FROM `tbl_export_invoice` as mst 
	 	 left join customer_detail as cust on cust.id = mst.consiger_id 
	 	     
		 where mst.step =4 and  mst.status=0 ".$where.' order by  ExtractNumber(export_invoice_no) ASC';
		$query = $this->db->query($sql);
		return $query->result();
	}
 
}

?>