<?php

class Admin_exportinvoice extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// public function export_container_data($id)
	// {
		// $q = $this->db->select('export.*, consign.c_name , performa.invoice_no,  supplier.company_name,  consign.shippment_days')
			 // ->from('tbl_export_loading_trn as export')
			// ->join('customer_detail as consign', 'export.pi_loading_plan_id = consign.id', 'LEFT')
			// ->join('tbl_performa_invoice as performa', 'export.performa_invoice_id = performa.performa_invoice_id', 'LEFT')
			 
			// ->join('tbl_supplier as supplier', 'export.supplier_id = supplier.supplier_id', 'LEFT')
			// ->where('export_loading_trn_id',$id)
			// ->get();
			// //echo $this->db->last_query();
			// return $q->row();
	// }
	
	public function select_exporter()
	{
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	}
	
	
	public function delete_loadingtrn($export_loading_trn_id,$export_packing_id,$exportproduct_trn_id)
	{ 
	
		$q = $this->db->where('export_loading_trn_id',$export_loading_trn_id);
		$q = $this->db->delete('tbl_export_loading_trn');
		
		$q1 = $this->db->where('exportproduct_trn_id',$exportproduct_trn_id);
		$q1 = $this->db->delete('tbl_exportproduct_trn');
		
		$q2 = $this->db->where('export_packing_id',$export_packing_id);
		$q2 = $this->db->delete('tbl_export_packing');
		
		return $q;
	}
	public function delete_pallet($export_loading_trn_id,$export_make_pallet_no)
	{
			$data = array(
				"export_make_pallet_no" => ''  
			);
			$data1 = array(
				"export_half_pallet" => 0
			);
		$q =	$this->db->where('export_loading_trn_id',$export_loading_trn_id);	
		$q =	$this->db->update('tbl_export_loading_trn',$data);	
		$q1 =	$this->db->where('export_loading_trn_id in ('.$export_make_pallet_no.') and export_loading_trn_id !=',0);	
		$q1 =	$this->db->update('tbl_export_loading_trn',$data1);	
		 
		return $q;
	}
	public function delete_design($export_loading_trn_id,$data)
	{
			 
		$q =	$this->db->where('export_loading_trn_id',$export_loading_trn_id);	
		$q =	$this->db->update('tbl_export_loading_trn',$data);	
		 
		return $q;
	}
	public function update_weight_detail($export_invoice_id,$export_loading_trn_id,$con_entry,$status)
	{
		if($status == 2)
		{
			$qry = "select * from tbl_export_loading_trn where export_loading_trn_id =".$export_loading_trn_id." and updated_net_weight > 0";
			$qry_result = $this->db->query($qry);
			 
			if($qry_result->num_rows() > 0)
			{
				$row = $qry_result->row(); 
				$data1 = array(
					"self_seal_no" 				=> $row->self_seal_no,
					"booking_no" 				=> $row->booking_no,
					"lr_no" 					=> $row->lr_no, 
					"truck_no" 					=> $row->truck_no, 
					"mobile_no" 				=> $row->mobile_no, 
					"remark" 					=> $row->remark, 
					"tare_weight" 				=> $row->tare_weight, 
					"updated_net_weight" 		=> $row->updated_net_weight, 
					"updated_gross_weight" 		=> $row->updated_gross_weight 
				);
				$qry1 = "select * from tbl_export_loading_trn where export_invoice_id =".$export_invoice_id." and con_entry = ".$con_entry." and after_invoice_delete =0  limit 1";
				$qry_result1 = $this->db->query($qry1);
				$row1 = $qry_result1->row(); 
				$q =	$this->db->where('export_loading_trn_id',$row1->export_loading_trn_id);	
				$q =	$this->db->update('tbl_export_loading_trn',$data1);	
				
				$data_sample = array(
					"export_loading_trn_id" => $row1->export_loading_trn_id
				);
				
				$q1 =	$this->db->where('export_loading_trn_id',$export_loading_trn_id);	
				$q1 =	$this->db->update('tbl_export_sampletrn',$data_sample);	
				 
		 	
		 
			}
	 	}			
		else
		{
			$qry = "select * from tbl_export_loading_trn where export_loading_trn_id =".$export_loading_trn_id." and updated_net_weight > 0";
			$qry_result = $this->db->query($qry);
			
			if($qry_result->num_rows() > 0)
			{
				 
				$data1 = array(
					"self_seal_no" 				=> '',
					"booking_no" 				=> '',
					"lr_no" 					=> '',
					"truck_no" 					=> '',
					"mobile_no" 				=> '',
					"remark" 					=> '',
					"tare_weight" 				=> '',
					"updated_net_weight" 		=> '',
					"updated_gross_weight" 		=> ''
				);
				 
				$q =	$this->db->where('export_invoice_id',$export_invoice_id);	
				$q =	$this->db->where('con_entry',$con_entry);	
				$q =	$this->db->where('export_loading_trn_id != ',$export_loading_trn_id);	
				$q =	$this->db->update('tbl_export_loading_trn',$data1);	
				
				$data_sample = array(
					"export_loading_trn_id" => $export_loading_trn_id
				);
				$row = $qry_result->row();
				$q1 =	$this->db->where('export_id',$export_invoice_id);	
				$q1 =	$this->db->where('container_name',$row->container_no);
			 	$q1 =	$this->db->update('tbl_export_sampletrn',$data_sample);	
				  
		  	}
		}
		 
		return $q;
	}
	public function updatepayment($payment_id,$id)
	{
			$data = array(
				"bill_id" => $id,
				"aginst_invoie"=>$id
			);
			
		$q =	$this->db->where('payment_id',$payment_id);	
		$q =	$this->db->update('tbl_payment',$data);	
		 
		return $q;
	}
	public function select_consigner($id)
	{
		// if($this->session->usertype_id != 1)
		// {
			// $q = $this->db->where('find_in_set(id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = '.$this->session->id.' and status =0)) <> ',"0");
		// }
		if(!empty($id))
		{
			$where = '(id='.$id.' or status = "0")';
			$q = $this->db->where($where);
		}
		else
		{
			$q = $this->db->where('status',0);
	 	}
		$q = $this->db->get('customer_detail');
		
		return $q->result();
	}
	public function other_consigner($id)
	{
		$q = $this->db->where('customer_id',$id);
		$q = $this->db->get('customer_add_consigner');
		//  echo $this->db->last_query();
		return $q->result();
	}
	
	public function selectinvoicetype($id)
	{
		$q = $this->db->where('invoicetype_id',$id);
		$q = $this->db->get('tbl_invoicetype');
		return $q->row();
	}
	public function update_exportcointainer($con_entry,$export_invoice_id,$data)
	{
	  $q1 = $this->db->where('con_entry',$con_entry);
	  $q1 = $this->db->where('export_invoice_id',$export_invoice_id);
	  $q1 = $this->db->update('tbl_export_loading_trn',$data);
		return $q; 
	}
	public function update_export_weight_cointainer($export_loading_trn_id,$data)
	{
	   
	  $q1 = $this->db->where('export_loading_trn_id',$export_loading_trn_id);
	  $q1 = $this->db->update('tbl_export_loading_trn',$data);
	 
		return $q; 
	}
	public function product_set_data($id,$supplier_id,$array,$value)
	{
		$implode_array = implode(",",$array);
		$supplier_id 	= implode(",",$supplier_id);
		
		if(!empty($array))
		{
		 	if($value == 1)
			{
				$where = ' and container < 1';
			 	$q =  'SELECT
					(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where   performa_invoice_id in ('.$implode_array.') and export_done_status = 0  GROUP by con_entry,performa_invoice_id,export_done_status) AS inner_query  where  performa_invoice_id in ('.$implode_array.') and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 20 '.$where.') as container_twenty,

					(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where  performa_invoice_id in ('.$implode_array.') and export_done_status = 0  GROUP by con_entry,performa_invoice_id,export_done_status) AS inner_query  where  performa_invoice_id in ('.$implode_array.') and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 40 '.$where.')  as container_fourty'; 
					$q_con = $this->db->query($q);
					return $q_con->row();
			}
			else if($value == 3)
			{
				 
				 $q =  'SELECT
					(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where  performa_invoice_id in ('.$implode_array.') and export_done_status = 0 GROUP by con_entry,performa_invoice_id) AS inner_query  where  performa_invoice_id in ('.$implode_array.') and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 20) as container_twenty,

					(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where  performa_invoice_id in ('.$implode_array.') and export_done_status = 0 GROUP by con_entry,performa_invoice_id) AS inner_query  where  performa_invoice_id in ('.$implode_array.') and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 40)  as container_fourty';  
					$q_con = $this->db->query($q);
					return $q_con->row();
			}
			else
			{
				$where = ' and container >= 1';
		 	$q =  'SELECT
				(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where performa_invoice_id in ('.$implode_array.') and export_done_status = 0 GROUP by con_entry,performa_invoice_id) AS inner_query  where performa_invoice_id in ('.$implode_array.') and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 20 '.$where.') as container_twenty,

				(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where performa_invoice_id in ('.$implode_array.') and export_done_status = 0 GROUP by con_entry,performa_invoice_id) AS inner_query  where performa_invoice_id in ('.$implode_array.') and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 40 '.$where.')  as container_fourty'; 
				$q_con = $this->db->query($q);
				return $q_con->row();
				
			}
		}
		else
		{
			$where = '';
			if($value == 1)
			{
				$where = ' and container < 1';
				$q =  'SELECT
					(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where performa_invoice_id = '.$id.' and export_done_status = 0 GROUP by con_entry,performa_invoice_id,export_done_status) AS inner_query  where performa_invoice_id = '.$id.' and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 20 '.$where.') as container_twenty,

					(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where performa_invoice_id = '.$id.' and export_done_status = 0  GROUP by con_entry,performa_invoice_id,export_done_status) AS inner_query  where performa_invoice_id = '.$id.' and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 40 '.$where.')  as container_fourty';  
					$q_con = $this->db->query($q);
					return $q_con->row();
			}
			else if($value == 3)
			{
				 
				$q =  'SELECT
					(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where performa_invoice_id = '.$id.' and export_done_status = 0  GROUP by con_entry) AS inner_query  where performa_invoice_id = '.$id.' and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 20) as container_twenty,

					(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where performa_invoice_id = '.$id.'  and export_done_status = 0 GROUP by con_entry) AS inner_query  where performa_invoice_id = '.$id.' and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 40)  as container_fourty';  
					$q_con = $this->db->query($q);
					return $q_con->row();
			}
			else
			{
				$where = ' and container >= 1';
			 $q =  'SELECT
				(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where performa_invoice_id = '.$id.' and export_done_status = 0 GROUP by con_entry) AS inner_query  where performa_invoice_id = '.$id.' and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 20 '.$where.') as container_twenty,

				(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id,export_done_status,already_done  FROM tbl_pi_loading_plan where performa_invoice_id = '.$id.' and export_done_status = 0 GROUP by con_entry) AS inner_query  where performa_invoice_id = '.$id.' and  supplier_id in ('.$supplier_id.') and export_done_status =0 and already_done = 1 and  container_size = 40 '.$where.')  as container_fourty';  
				$q_con = $this->db->query($q);
				return $q_con->row();
				
			}
			
		}
	}
	 
	public function select_invoice_data($id,$array)
	{
		$q = $this->db->select('invoice.*, consign.c_name,
		(SELECT SUM(container_details) as no_of_container FROM `tbl_performa_invoice` WHERE performa_invoice_id in ('.implode(",",$array).')) as no_of_container,
		(SELECT group_concat(invoice_no) as performa_invoice_no FROM `tbl_performa_invoice` WHERE performa_invoice_id in ('.implode(",",$array).')) as performa_invoice_no')
			 ->from('tbl_performa_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			->where('performa_invoice_id',$id)
			->order_by("performa_date", "desc")
			->get();
		 	return $q->row();
	}
	 
	 public function bank_detail($id){
		$this->db->where('id',$id);
		$q = $this->db->get('bank_detail');
		return $q->row();
	}
	public function invoice_firststep($data){
		 
		$this->db->insert('tbl_export_invoice',$data);
		 return  $this->db->insert_id();
	}
	public function update_invoicenumber($id,$invoice_series)
	{
		$data = array("invoice_series"=>$invoice_series);
		$this->db->where('invoicetype_id',$id);	
		return $this->db->update('tbl_invoicetype',$data);	
			
	}
	public function update_make_cointainer($data,$export_loading_trn_id)
	{
	 	$q = $this->db->where('find_in_set(export_loading_trn_id,"'.implode(",",$export_loading_trn_id).'")  and export_loading_trn_id !=',0);	
		$q = $this->db->update('tbl_export_loading_trn',$data);	
		  
		return $q;
	}
	public function s_edit($data,$id)
	{
		$this->db->where('export_invoice_id',$id);	
		return $this->db->update('tbl_export_invoice',$data);	
		
	}
	public function update_performa($id,$no_of_export)
	{
		$data = array("no_of_export"=>$no_of_export);
		$this->db->where('performa_invoice_id',$id);	
		return $this->db->update('tbl_performa_invoice',$data);	
			
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
	// public function select_supplier_data()
	// {
		// $q = $this->db->get('tbl_supplier');
		// return $q->row();
	// }
	public function select_supplier_data($id){
		$q = $this->db->select('*')
			 ->from('tbl_supplier')
		
			->get();
			//echo $this->db->last_query();
			return $q->row();
	}
	public function exportinvoice_cust_data($id){
		$q = $this->db->select('invoice.*, consign.c_name')
			 ->from('tbl_customer_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			->where('export_invoice_id',$id)
			->get();
			//echo $this->db->last_query();
			return $q->row();
	}
	public function exportinvoice_update($data,$id)
	{
		$q = $this->db->where('export_invoice_id',$id);	
		$q = $this->db->update('tbl_export_invoice',$data);
		 
		return $q;
	}
	public function getpastexportinvoice($id,$performa_invoice_id)
	{
		$q = $this->db->where('status',0); 
		$q = $this->db->where('step',3); 
		$q = $this->db->where('export_invoice_id !=',$id); 
		$q = $this->db->where('performa_invoice_id',$performa_invoice_id); 
		$q = $this->db->get('tbl_export_invoice');
		//echo $this->db->last_query();exit;
		return $q->result();
	}
	 public function gettermsdata()
	{
		$q = $this->db->where('status !=','2');
		$q = $this->db->get('tbl_terms');
		return $q->result();
	}
	public function qcrecord($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_qc_table as mst")
			 ->where("mst.export_invoice_id",$id)
			 ->where("mst.status",0)
			 ->get();
		$category = $q->row();
		  
		  $category->qc_photos = $this->qcrecord_trn($category->qc_table_id);
		return $category;
	}
	
	 public function qcrecord_trn($qc_table_id)
	{
		$q = $this->db->where('qc_table_id',$qc_table_id);
		$q = $this->db->where('status',0);
		$q = $this->db->get('tbl_qc_photos');
	 	return $q->result();
	}
	 public function get_all_performainvoice()
	{
		$q = $this->db->where('status',3);
		$q = $this->db->get('tbl_performa_invoice');
	 	return $q->result();
	}
	
	public function check_invoice_html($table_name,$export_invoice_id)
	{
		$q = $this->db->where('table_id',$export_invoice_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name',$table_name);
		$q = $this->db->get('tbl_invoices_html');
		
	 	return $q->row();
	} 
	
	public function insert_invoice_html($data){
		 
		$this->db->insert('tbl_invoices_html',$data);
		 return  $this->db->insert_id();
	}
	
	public function update_invoice_html($data,$id,$html)
	{
		$q1 = $this->db->where('table_id',$id);
		$q1 = $this->db->where('invoice_table_name',$html);		
		$q1 = $this->db->update('tbl_invoices_html',$data);
		
		return $q1; 		
	}

	public function exportinvoice_html_delete($id)
	{
		$q1 = $this->db->where('table_id',$id);
		$q1 = $this->db->delete('tbl_invoices_html');
		return $q1; 		
	}
}
