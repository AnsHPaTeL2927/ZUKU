<?php
class Payment_list_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	
	 
	public function getbilldata()
	{
		$q = 'SELECT `payment`.*, `export`.`export_invoice_no` FROM `tbl_payment` as `payment` LEFT JOIN `tbl_export_invoice` as `export` on (find_in_set(export.export_invoice_id,payment.aginst_invoie)) WHERE `payment`.`status` = 0 group by export.export_invoice_id';
		$q_con = $this->db->query($q);
		return $q_con->result();
	}
	
	public function getcustomerdata()
	{
		$q = $this->db->select('payment.*, cust.c_companyname')
			 ->from('tbl_payment as payment')
			 ->join('customer_detail as cust', 'payment.customer_id = cust.id', 'LEFT')
			->where('payment.status',"0")
			->group_by('payment.customer_id')
			->get();
		return $q->result();
	}
	
	public function insert_payment($data){

		$id = $this->db->insert('tbl_payment',$data);
		 
		return $this->db->insert_id();
	}
	public function get_customer()
	{
		// if($this->session->usertype_id != 1)
		// {
			// $q = $this->db->where('find_in_set(id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = '.$this->session->id.' and status =0)) <> ',"0");
		// }
		$q = $this->db->get('customer_detail');
	 	return $q->result();
	}
	
	public function get_customer_name()
	{
		// if($this->session->usertype_id != 1)
		// {
			// $this->db->where("find_in_set(id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` WHERE user_id = ".$this->session->id." AND status = 0)) <>", "0");
		// }

		// Add condition to exclude empty or null customer names
		$this->db->where("c_name IS NOT NULL");
		$this->db->where("c_name !=", "");

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
	public function get_customer_bill($id, $start_date, $end_date)
{
	$q = "(SELECT 
			mst.export_invoice_id, 
			mst.invoice_date as date, 
			mst.export_invoice_no, 
			mst.container_details, 
			cust.before_grand_total as grand_total, 
			cust.extra_calc_amt, 
			mst.payment_terms, 
			'' as bank_charge, 
			1 as fromwhere, 
			'' as bank_name 
		FROM `tbl_customer_invoice` as `cust`
		LEFT JOIN tbl_export_invoice as mst ON mst.export_invoice_id = cust.export_invoice_id
		WHERE cust.`consiger_id` = ".$id." 
		AND cust.invoice_date BETWEEN '".date('Y-m-d', strtotime($start_date))."' AND '".date('Y-m-d', strtotime($end_date))."' 
		AND cust.invoice_date >= '2020-04-01' 
		AND cust.status = 0 
		AND mst.step = 4 
		AND mst.status = 0)

	UNION 

	(SELECT 
		payment_id as export_invoice_id, 
		date, 
		refernace_no as export_invoice_no, 
		payment_mode as container_details, 
		total_payment as grand_total, 
		 '' AS extra_calc_amt,  
		refernace_no as payment_terms, 
		bank_charge, 
		2 as fromwhere, 
		bank_name  
	FROM `tbl_payment` as `mst`  
	LEFT JOIN bank_detail bank ON bank.id = mst.bank_id 
	LEFT JOIN tbl_payment_mode mode ON mode.payment_mode_id = mst.payment_mode_id 
	WHERE `customer_id` = ".$id."  
	AND date BETWEEN '".date('Y-m-d', strtotime($start_date))."' AND '".date('Y-m-d', strtotime($end_date))."' 
	AND date >= '2020-04-01' 
	AND mst.status = 0)

	UNION 

	(SELECT 
		kasar_amount_id as export_invoice_id, 
		kasar_date as date, 
		invoice.export_invoice_no, 
		'kasar' as container_details, 
		kasar_amt as grand_total, 
		 '' AS extra_calc_amt,  
		'' as payment_terms, 
		'' as bank_charge, 
		2 as fromwhere, 
		'' as bank_name  
	FROM `tbl_kasar_amount` as `ksrmst`  
	LEFT JOIN tbl_export_invoice as invoice ON invoice.export_invoice_id = ksrmst.export_invoice_id 
	WHERE ksrmst.`consiger_id` = ".$id."  
	AND kasar_date BETWEEN '".date('Y-m-d', strtotime($start_date))."' AND '".date('Y-m-d', strtotime($end_date))."'  
	AND kasar_date >= '2020-04-01' 
	AND ksrmst.status = 0)

	ORDER BY date ASC, export_invoice_id ASC";

	$q_con = $this->db->query($q);
	return $q_con->result();
}

	 public function get_customer_bill_opening_balance($id,$start_date)
	{
		  $q = "(SELECT export_invoice_id,invoice_date as date, export_invoice_no,container_details,grand_total,payment_terms,'' as bank_charge,1 as fromwhere,'' as bank_name FROM `tbl_export_invoice` as `mst`  WHERE `consiger_id` = ".$id." AND invoice_date < '".date('Y-m-d',strtotime($start_date))."'   and  invoice_date >= '2020-04-01' and mst.step = 4 and mst.status= 0)
		UNION 
		(SELECT payment_id as export_invoice_id,date, refernace_no as export_invoice_no,payment_mode as container_details,total_payment as grand_total,refernace_no as payment_terms,bank_charge,2 as fromwhere,bank_name  FROM `tbl_payment` as `mst`  
		left join bank_detail bank on bank.id=mst.bank_id 
		left join tbl_payment_mode mode on mode.payment_mode_id=mst.payment_mode_id 
		WHERE `customer_id` = ".$id."  AND date < '".date('Y-m-d',strtotime($start_date))."'  and  date >= '2020-04-01' and mst.status= 0)
	 	UNION 
		(SELECT kasar_amount_id as export_invoice_id,kasar_date as date, '' as export_invoice_no,'' as container_details,kasar_amt as grand_total,'' as payment_terms,'' as bank_charge,2 as fromwhere,'' as bank_name  FROM `tbl_kasar_amount` as `mst`  
		WHERE `consiger_id` = ".$id."  AND kasar_date < '".date('Y-m-d',strtotime($start_date))."'  and  kasar_date >= '2020-04-01' and mst.status= 0)
		ORDER BY date ASC,export_invoice_id ASC";
		$q_con = $this->db->query($q);
		 	 
			  return $q_con->result();
		  
	} 
	 
	public function get_total_bill_detail($id)
	{
		$q = "SELECT  sum(grand_total) as total_grand_total,(select sum(paid_amount) from tbl_payment where status=0 and customer_id = mst.consiger_id) as total_paid_amt  from  tbl_export_invoice as mst where mst.consiger_id = ".$id." and step =4 and status=0";
		$q_con = $this->db->query($q);
		return $q_con->row();
	} 
	
	public function get_due_amount($id,$start_date,$end_date)
	{
		$q = "SELECT grand_total,certification_charge, insurance_charge,seafright_charge,calculation_operator ,(select sum(paid_amount + bank_charge) from tbl_payment where status!=2 and date between '".date('Y-m-d',strtotime($start_date))."' and '".date('Y-m-d',strtotime($end_date))."' and bill_id = mst.export_invoice_id) as total_paid_amt,(select kasar_amt from tbl_kasar_amount where status!=2  and export_invoice_id = mst.export_invoice_id) as kasar_amt from  tbl_export_invoice as mst where mst.export_invoice_id = ".$id." and step=4 and status=0";
		$q_con = $this->db->query($q);
		return $q_con->row();
	}
	
	// public function get_due_amount($id,$start_date,$end_date)
	// {
		// $q = "SELECT before_grand_total,grand_total,certification_charge, insurance_charge,seafright_charge,(select sum(paid_amount + bank_charge) from tbl_payment where status!=2 and date between '".date('Y-m-d',strtotime($start_date))."' and '".date('Y-m-d',strtotime($end_date))."' and bill_id = mst.export_invoice_id) as total_paid_amt,(select kasar_amt from tbl_kasar_amount where status!=2  and export_invoice_id = mst.export_invoice_id) as kasar_amt from  tbl_customer_invoice as mst where mst.export_invoice_id = ".$id." and step=4 and status=0";
		// $q_con = $this->db->query($q);
		// return $q_con->row();
	// }
	
	// public function get_due_amount($id, $start_date, $end_date)
// {
	// $start = date('Y-m-d', strtotime($start_date));
	// $end = date('Y-m-d', strtotime($end_date));

	// $q = "SELECT 
			// mst.before_grand_total, 
			// mst.grand_total, 
			// mst.certification_charge, 
			// mst.insurance_charge, 
			// mst.seafright_charge,

			// IFNULL((
				// SELECT SUM(paid_amount + bank_charge) 
				// FROM tbl_payment 
				// WHERE status != 2 
				  // AND date BETWEEN '$start' AND '$end'
				  // AND bill_id = mst.export_invoice_id
			// ), 0) AS total_paid_amt,

			// IFNULL((
				// SELECT kasar_amt 
				// FROM tbl_kasar_amount 
				// WHERE status != 2 
				  // AND export_invoice_id = mst.export_invoice_id
				// LIMIT 1
			// ), 0) AS kasar_amt

		// FROM tbl_customer_invoice AS mst 
		// WHERE mst.export_invoice_id = $id 
		  // AND step = 4 
		  // AND status = 0";

	// $q_con = $this->db->query($q);
	// return $q_con->row();
// }


	public function delete_payment($id)
	{
		 $qry = "select cdate from tbl_payment where payment_id=".$id;
		$q_con = $this->db->query($qry);
		$row = $q_con->row();
		 $data = array(
			"status" =>2
			);
			$this->db->where('cdate',$row->cdate);
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
	public function getpayment_detail($id)
	{
		 
		
		$q = "select * from tbl_payment as mst  where payment_id = ".$id;
		$q_con = $this->db->query($q);
		return $q_con->row();
	} 
	public function get_customer_statement_detail($id)
	{
		$where = '';
		$where1 = '';
		if($this->session->usertype_id != 1)
			{
				$where = " and find_in_set(consiger_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
				$where1 = " and find_in_set(customer_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			}	
		 $q = "(select invoice_date as date,export_invoice_no as descrption,1 as entry, grand_total as amount from tbl_export_invoice where step = 4 and status=0 and consiger_id = ".$id.$where.") UNION (select date,payment_mode as descrption,2 as entry,paid_amount as amount from tbl_payment as mst left join tbl_payment_mode as mode on mode.payment_mode_id=mst.payment_mode_id where mst.status=0 and customer_id=".$id.$where1.") order by date";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	public function get_bill_detail($id)
	{
		$q = "SELECT export_invoice_id,export_invoice_no,grand_total from  tbl_export_invoice as mst where mst.consiger_id = ".$id." and step =4 and status=0 and invoice_date >='2020-04-01'";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
public function get_customer_statement($company_id = null)
{
    $where = ' WHERE mst.status = 0'; // Fetch only active customers

    // If company ID is provided
    if (!empty($company_id)) {
        $where .= ' AND mst.id = ' . $this->db->escape($company_id);
    }

    // Main Query
    $q = "SELECT 
            mst.id, 
            c_name, 
            c_companyname, 
            opening_balance, 
            open_balance_status, 
            currency_id,

            (SELECT SUM(grand_total)
             FROM tbl_export_invoice
             WHERE consiger_id = mst.id AND step = 4 AND status = 0 AND invoice_date >= '2020-04-01') AS grand_total,

            (SELECT SUM(before_grand_total)
             FROM tbl_customer_invoice
             WHERE consiger_id = mst.id AND status = 0 AND invoice_date >= '1970-01-01') AS before_grand_total,

            (SELECT SUM(total_payment)
             FROM tbl_payment
             WHERE customer_id = mst.id AND status = 0 AND date >= '1970-01-01') AS paid_amount,

            (SELECT SUM(bank_charge)
             FROM tbl_payment
             WHERE customer_id = mst.id AND status = 0 AND date >= '1970-01-01') AS bank_charge,

            (SELECT SUM(kasar_amt)
             FROM tbl_kasar_amount
             WHERE status != 2 AND consiger_id = mst.id) AS total_kasar_amt

        FROM customer_detail AS mst
        $where
        ORDER BY c_companyname";

    $q_con = $this->db->query($q);
    return $q_con->result();
}


// public function get_customer_statement($id)
// {
    // $where = '';

    // if(!empty($id))
    // {
        // $where = ' and mst.id='.$id;
    // }

    // if($this->session->usertype_id != 1)
    // {
        // $where .= " and find_in_set(mst.id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
    // }

    // $q = "SELECT * FROM (
            // SELECT 
                // mst.id,
                // c_name,
                // c_companyname,
                // opening_balance,
                // open_balance_status,
                // currency_id,
                // (SELECT SUM(grand_total) 
                 // FROM tbl_export_invoice 
                 // WHERE consiger_id = mst.id 
                   // AND step = 4 
                   // AND STATUS = 0 
                   // AND invoice_date >= '2020-04-01') as grand_total,
                // (SELECT SUM(total_payment) 
                 // FROM tbl_payment 
                 // WHERE customer_id = mst.id 
                   // AND STATUS = 0 
                   // AND date >= '2020-04-01') as paid_amount,
                // (SELECT SUM(bank_charge) 
                 // FROM tbl_payment 
                 // WHERE customer_id = mst.id 
                   // AND STATUS != 2 
                   // AND date >= '2020-04-01') as bank_charge,
                // (SELECT SUM(kasar_amt) 
                 // FROM tbl_kasar_amount 
                 // WHERE status != 2  
                   // AND consiger_id = mst.id) as total_kasar_amt
            // FROM customer_detail as mst 
            // WHERE mst.id != 0 {$where}
        // ) as subquery 
        // WHERE grand_total IS NOT NULL AND grand_total != 0
        // ORDER BY c_companyname";

    // $q_con = $this->db->query($q);
    // return $q_con->result();
// }
	

	public function get_customer_reportbydate($customer_id,$open_balance_status,$sdate,$edate='')
	{	
		$bal = 0;
		
		$this->db->select('SUM(grand_total) as grand_total')->where('consiger_id',$customer_id)->where('step',4)->where('STATUS',0);
		if($edate=='')
		{	
			$grand_total = $this->db->where('invoice_date <=',$sdate)->get('tbl_export_invoice')->row_array();
		}else{
			$grand_total = $this->db->where('invoice_date <=',$sdate)->where('invoice_date >=',$edate)->get('tbl_export_invoice')->row_array();
		}

		
		if($edate=='')
		{	$this->db->select(' SUM(total_payment) as paid_amount')->where('customer_id',$customer_id)->where('STATUS',0);
			$paid_amount = $this->db->where('date <=',$sdate)->get('tbl_payment')->row_array();
		}else{
			$this->db->select(' SUM(total_payment) as paid_amount')->where('customer_id',$customer_id)->where('STATUS',0);
			$paid_amount = $this->db->where('date <=',$sdate)->where('date >=',$edate)->get('tbl_payment')->row_array();
		}
		

		if($edate=='')
		{
			$this->db->select(' SUM(bank_charge) as bank_charge')->where('customer_id',$customer_id)->where('STATUS !=',2);
			$bank_charge = $this->db->where('date <=',$sdate)->get('tbl_payment')->row_array();
		}else{
			$this->db->select(' SUM(bank_charge) as bank_charge')->where('customer_id',$customer_id)->where('STATUS !=',2);
			$bank_charge = $this->db->where('date <=',$sdate)->where('date >=',$edate)->get('tbl_payment')->row_array();
		}

		$grandTotal = !empty($grand_total) && !empty($grand_total['grand_total']) ? $grand_total['grand_total'] : 0;

		$paidAmount = !empty($paid_amount) && !empty($paid_amount['paid_amount']) ? $paid_amount['paid_amount'] : 0;

		$bankCharge = !empty($bank_charge) && !empty($bank_charge['bank_charge']) ? $bank_charge['bank_charge'] : 0;

		$bal = $grandTotal - ($paidAmount + $bankCharge);
		return $bal;
	}

	public function exportinvoice_data($id)
	{
		$q = $this->db->select('invoice.*')
			->from('tbl_export_invoice as invoice')
		 	->where('export_invoice_id',$id)
			->get();
			 
			return $q->row();
	}
}

?>