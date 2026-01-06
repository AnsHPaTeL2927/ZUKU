<?php
class Performa_model extends CI_model
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
	public function get_confirm_performa($customer_id,$start_date,$end_date)
	{
		$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consigne_id = ".$customer_id;
		}
		 if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		} 
		$sql = "SELECT   mst.performa_invoice_id,invoice_no,performa_date,c_companyname, mst.seafright_charge,notify.notify_name,pro.size_type_mm,model.model_name,finish.finish_name,country_final_destination,mst.port_of_discharge,mst.payment_terms,container_details,mst.grand_total,
		(select sum(packing.no_of_pallet + packing.no_of_big_pallet + packing.no_of_small_pallet) from  tbl_performa_trn as trn inner join tbl_performa_packing as packing on packing.performa_trn_id = trn.performa_trn_id where trn.invoice_id = mst.performa_invoice_id)  as all_no_of_pallet,
		(select sum(packing.no_of_boxes) from   tbl_performa_trn as trn inner join tbl_performa_packing as packing on packing.performa_trn_id = trn.performa_trn_id where trn.invoice_id = mst.performa_invoice_id)  as all_no_of_boxes,
		(select sum(packing.no_of_sqm) from   tbl_performa_trn as trn inner join tbl_performa_packing as packing on packing.performa_trn_id = trn.performa_trn_id where trn.invoice_id = mst.performa_invoice_id)  as all_no_of_sqm,
		(select sum(packing.product_amt) from  tbl_performa_trn as trn inner join tbl_performa_packing as packing on packing.performa_trn_id = trn.performa_trn_id where trn.invoice_id = mst.performa_invoice_id)  as all_product_amt
		
		FROM `tbl_performa_invoice` as mst 
	 	 left join customer_detail as cust on cust.id = mst.consigne_id 
	 	 left join customer_add_consigner as notify on notify.id = mst.notify_id 
	 	 left join tbl_performa_trn as trn on trn.invoice_id = mst.performa_invoice_id 
		 left join tbl_performa_packing as pack on pack.performa_trn_id = trn.performa_trn_id 
	 	 inner join tbl_product as pro on pro.product_id = trn.product_id 
	 	 inner join tbl_packing_model as model on model.packing_model_id = pack.design_id 
	 	 inner join tbl_finish as finish on finish.finish_id = pack.finish_id 
	 	 
	
	 	   
		 where mst.confirm_status = 1 ".$where.' order by mst.mdate desc';
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function get_confirm_performa1($customer_id,$start_date,$end_date)
	{
		$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consigne_id = ".$customer_id;
		}
		 if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		} 
		$sql = "SELECT   mst.performa_invoice_id,invoice_no,performa_date,c_companyname, mst.seafright_charge,notify.notify_name,pro.size_type_mm,trn.total_no_of_boxes,trn.total_no_of_pallet,trn.total_no_of_sqm,trn.total_product_amt,model.model_name,finish.finish_name,country_final_destination,mst.port_of_discharge,mst.payment_terms,container_details,mst.grand_total
		
		
		FROM `tbl_performa_invoice` as mst 
	 	 left join customer_detail as cust on cust.id = mst.consigne_id 
	 	 left join customer_add_consigner as notify on notify.id = mst.notify_id 
	 	 left join tbl_performa_trn as trn on trn.invoice_id = mst.performa_invoice_id 
		 left join tbl_performa_packing as pack on pack.performa_trn_id = trn.performa_trn_id 
	 	 inner join tbl_product as pro on pro.product_id = trn.product_id 
	 	 inner join tbl_packing_model as model on model.packing_model_id = pack.design_id 
	 	 inner join tbl_finish as finish on finish.finish_id = pack.finish_id 
	 	 
	
	 	   
		 where mst.confirm_status = 1 ".$where.' order by mst.mdate desc';
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_commercial_invoice($start_date,$end_date)
	{
		$where = ' and invoice_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		 
		 if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consiger_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		} 
		    $sql = "SELECT   series.hsnc_code,series.series_name,mst.customer_invoice_no,mst.invoice_date,mst.grand_total,mst.port_of_discharge,mst.final_destination,trn.cust_hsnc_code,
		 (SELECT count(distinct inner_series.series_id) FROM `tbl_customer_invoice` as inner_mst left join tbl_exportproduct_trn as inner_trn on inner_trn.export_invoice_id = inner_mst.export_invoice_id
		left join tbl_product as inner_pro on inner_pro.product_id = inner_trn.product_id 
		left join tbl_series as inner_series on inner_series.series_id = inner_pro.series_id 
		where  inner_mst.customer_invoice_id = mst.customer_invoice_id) as rowspan_no

			FROM `tbl_customer_invoice` as mst 
	 	 left join tbl_exportproduct_trn as trn on trn.export_invoice_id = mst.export_invoice_id 
	 	 left join tbl_product as pro on pro.product_id = trn.product_id
	 	 left join tbl_series as series on series.series_id = pro.series_id
	 	  
	 	   
		 where mst.rex_detail_status = 1  and mst.status=0 ".$where." group by mst.customer_invoice_no,series.series_id order by mst.mdate desc";
		$query = $this->db->query($sql);
		return $query->result();
	}
}

?>