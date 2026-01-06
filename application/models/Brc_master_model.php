<?php
class Brc_master_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function insert_payment($data){

		$id = $this->db->insert('tbl_payment',$data);
		 
		return $this->db->insert_id();
	}
	public function getinvoicedata()
	{
		// $q= $this->db->select('mst.export_invoice_id', 'mst.export_invoice_no','tbl_payment.paid_amount','tbl_payment.bank_charge', 'customer_detail.c_companyname','mst.invoice_date','mst.container_details','mst.port_of_discharge','mst.grand_total','mst.status','mst.cdate','mst.step','mst.performa_invoice_id','mst.upload_bl','mst.upload_shiping_bill','tax_status','tbl_performa_invoice.no_of_export','tbl_currency.currency_name','tbl_currency.currency_id','mst.certification_charge', 'mst.insurance_charge','mst.seafright_charge','mst.calculation_operator')
		// 	 ->from('tbl_export_invoice as mst')
		// 	 ->join('customer_detail','customer_detail.id=mst.consiger_id', 'left')
		// 	 ->join('tbl_performa_invoice','tbl_performa_invoice.performa_invoice_id=mst.performa_invoice_id', 'left')
		// 	 ->join('tbl_currency','tbl_currency.currency_id=mst.invoice_currency_id', 'left')
		// 	 ->join('tbl_payment','tbl_payment.bill_id=mst.export_invoice_id', 'left')
		// 	 ->where_in("mst.status = 0")
		// 	 ->get();
		  
		// $q = $this->db->query("SELECT mst.export_invoice_id, mst.export_invoice_no,payment.paid_amount,payment.bank_charge, consign.c_companyname,mst.invoice_date,
		// mst.container_details,mst.port_of_discharge,mst.grand_total,mst.status,mst.cdate,mst.step,mst.performa_invoice_id,
		// mst.upload_bl,mst.upload_shiping_bill,tax_status,proforma.no_of_export,cur.currency_name,cur.currency_id,mst.certification_charge,
		//  mst.insurance_charge,mst.seafright_charge,mst.calculation_operator from tbl_export_invoice as mst 
		//  LEFT JOIN customer_detail as consign on 'consign.id'='mst.consiger_id',
		//  LEFT JOIN tbl_performa_invoice on 'tbl_performa_invoice.performa_invoice_id'='mst.performa_invoice_id',
		//  LEFT JOIN tbl_currency on 'tbl_currency.currency_id'='mst.invoice_currency_id',
		//  LEFT JOIN tbl_payment on 'tbl_payment.bill_id=mst.export_invoice_id'
		//  where mst.status=0 ");
		//customer_detail.c_companyname
		 $q = $this->db->query("SELECT mst.export_invoice_id,customer_detail.c_companyname,tbl_currency.currency_name,tbl_currency.currency_id,SUM(tbl_payment.paid_amount + tbl_payment.bank_charge) as total_paid,tbl_payment.bank_charge,tbl_payment.paid_amount, mst.export_invoice_no,mst.invoice_date, mst.container_details,mst.port_of_discharge,mst.grand_total,mst.status,mst.cdate,mst.step,mst.performa_invoice_id, mst.upload_bl,mst.upload_shiping_bill,tax_status,mst.certification_charge, mst.insurance_charge,mst.seafright_charge,mst.calculation_operator from tbl_export_invoice as mst LEFT JOIN customer_detail ON customer_detail.id = mst.consiger_id LEFT JOIN tbl_currency ON tbl_currency.currency_id=mst.invoice_currency_id LEFT JOIN tbl_payment ON tbl_payment.bill_id=mst.export_invoice_id where mst.status=0 GROUP BY export_invoice_id ORDER BY mst.export_invoice_id DESC");
		//print_r($q);
		return $q->result();
		}

	public function get_export_data($id)
	{
		//$q = "SELECT * from tbl_export_invoice where status=0 and export_invoice_id = '$id' and invoice_date >='2020-04-01'";
		$q = $this->db->query("SELECT mst.export_invoice_id,customer_detail.c_companyname,tbl_currency.currency_name,tbl_currency.currency_id,SUM(tbl_payment.paid_amount + tbl_payment.bank_charge) as total_paid,SUM(tbl_payment.bank_charge) as total_bank_charges,tbl_payment.bank_charge,tbl_payment.paid_amount, mst.export_invoice_no,mst.invoice_date, mst.container_details,mst.port_of_discharge,mst.grand_total,mst.status,mst.cdate,mst.step,mst.performa_invoice_id, mst.upload_bl,mst.upload_shiping_bill,tax_status,mst.certification_charge, mst.insurance_charge,mst.seafright_charge,mst.calculation_operator from tbl_export_invoice as mst LEFT JOIN customer_detail ON customer_detail.id = mst.consiger_id LEFT JOIN tbl_currency ON tbl_currency.currency_id=mst.invoice_currency_id LEFT JOIN tbl_payment ON tbl_payment.bill_id=mst.export_invoice_id where mst.status=0 AND export_invoice_id = '$id' GROUP BY export_invoice_id ORDER BY mst.export_invoice_id DESC");
		//$q_con = $this->db->query($q);
		return $q->result();
	} 
	public function get_payment_data($id)
	{
		$q = "SELECT * from tbl_payment where status=0 and bill_id = '$id'";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	public function get_customer_data($id)
	{
		$q = "SELECT c_name,c_companyname from customer_detail where id = '$id'";
		$q_con = $this->db->query($q);
		return $q_con->result();
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