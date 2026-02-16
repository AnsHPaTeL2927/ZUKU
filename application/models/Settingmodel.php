<?php

class Settingmodel extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
			
	}
	public function insert($data)
	{
		$q = $this->db->insert('tbl_invoicetype',$data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function update($data,$invoice_type_id)
	{
		$q = $this->db->where('invoicetype_id',$invoice_type_id);
		$updateid = $this->db->update('tbl_invoicetype',$data);
		 
		return  $updateid;
	}
	public function fecth()
	{
		$q = $this->db->get('tbl_invoicetype');
		return  $q->result();
	}
	public function singlerecord($id)
	{
		$q = $this->db->where('invoicetype_id',$id);
		$q = $this->db->get('tbl_invoicetype');
		return  $q->row();
	}
	public function afetrlogin($id)
	{
		$array = array('user_id' => $id);
		$q = $this->db->where($array);
		$q = $this->db->get('tbl_user');
		 //echo $this->db->last_query();
		return $q->row();
	}
	public function update_onoff($value,$control)
	{
		
		$data = array(
			$control => $value 
		);
		$this->db->where('log_id',1);
		return $this->db->update('ciadmin_login',$data);
	}

	public function update_production_reminder_days($days)
	{
		$days = (int) $days;
		if ($days < 0) $days = 0;
		$data = array('production_reminder_days' => $days);
		$this->db->where('log_id', 1);
		return $this->db->update('ciadmin_login', $data);
	}
	
	
	public function setting_data($id)
	{
		$array = array('log_id' => $id);
		$q = $this->db->where($array);
		$q = $this->db->get('ciadmin_login');
		 //echo $this->db->last_query();
		return $q->row();
	}
	
	public function update_onoff_pi($value,$control)
	{
		
		$data = array(
			$control => $value 
		);
		$this->db->where('pi_id',1);
		return $this->db->update('pi_format_onoff',$data);
	}
	
	public function setting_data_pi($id)
	{
		$array = array('pi_id' => $id);
		$q = $this->db->where($array);
		$q = $this->db->get('pi_format_onoff');
		 //echo $this->db->last_query();
		return $q->row();
	}
	
	public function warner_data($id)
	{
		$array = array('company_id' => $id);
		$q = $this->db->where($array);
		$q = $this->db->get('tbl_warner');
		 //echo $this->db->last_query();
		return $q->row();
	}
	public function update_warner($data,$company_id)
	{
		$q = $this->db->where('company_id',$company_id);
		$q = $this->db->update('tbl_warner',$data);
	 
		return $q;
	}
	public function updateprice($usd,$euro,$id,$psize,$notification_text,$gbp,$fob_charges,$pallet_charges,$big_pallet_charge,$small_pallet_charges,$exchange_rate_btn)
	{
		if($exchange_rate_btn == 1)
		{
			$data=array(
				'usd'					=> $usd,
				'euro'					=> $euro,
				'gbp'					=> $gbp,
				'size_type'				=> $psize,
				'notification_text'		=> $notification_text,
				'udate'					=> date('Y-m-d H:i:s')
			);
		}
		else
		{
			$data = array(
				'fob_charges'			=> $fob_charges,
				'pallet_charges'		=> $pallet_charges,
				'big_pallet_charge'		=> $big_pallet_charge,
				'small_pallet_charges'	=> $small_pallet_charges,
			);
		}
		$q = $this->db->where('log_id',$id);
		$q = $this->db->update('ciadmin_login',$data);
	 
		return $q;
	}
	public function fields_data()
	{
		$q = $this->db->get('tbl_packing_fields');
		return  $q->result();
	}
	public function update_packing_fields($fields_data,$id)
	{
		$this->db->where('packing_fields_id',$id);
		return $this->db->update('tbl_packing_fields',$fields_data);
	}
	public function get_table()
	{
		$table_query="show tables;";
		$query = $this->db->query($table_query); 
		return $query->result();
	}
	public function from_table($table)
	{
		$q = $this->db->get($table);
		$result = array();
		$result['fieldcount'] 	= $q->num_fields();
		$result['affectedrows'] = $q->num_rows();
		$result['resultrow'] 	= $q->result_array();
		 
		return $result;
	}
	public function create_table($table)
	{
		$table_query='SHOW CREATE TABLE '.$table;
		$query = $this->db->query($table_query); 
		return $query->result_array();
	}
	public function truncate_all($which)
	{
		$table_array = array();
		
		if($which == 1)
		{
				$table_array = array('bank_master','container_photos','customer_add_consigner','customer_detail','login_history','tbl_autometic_loading_plan','tbl_box_design','tbl_cha_contact','tbl_cha_master','tbl_customer_add_detail','tbl_customer_box_design','tbl_customer_invoice','tbl_design_detail','tbl_design_rate','tbl_design_suppiler_rate','tbl_expense','tbl_expense_party','tbl_export_annexure','tbl_export_invoice', 'tbl_export_loading_trn','tbl_export_packing','tbl_export_sampletrn','tbl_export_supplier','tbl_exportmakecontainer','tbl_exportproduct_trn','tbl_finish','tbl_forwarer_contact','tbl_forwarer_master','tbl_fumigation','tbl_invoices_html','tbl_packing_model','tbl_pallet_cap','tbl_pallet_order','tbl_pallet_order_trn','tbl_pallet_party','tbl_pallet_type','tbl_payment','tbl_performa_additional_detail','tbl_performa_box_design','tbl_performa_invoice','tbl_performa_packing','tbl_performa_trn','tbl_pi_advance_payment','tbl_pi_loading_plan','tbl_po_payment','tbl_po_payment_trn','tbl_producation','tbl_product','tbl_product_size','tbl_production_mst','tbl_production_trn','tbl_purchase_order','tbl_purchase_packing','tbl_purchaseordertrn','tbl_qc_photos','tbl_qc_table','tbl_quotation','tbl_quotation_trn','tbl_receive_payment_part','tbl_receive_payment_part_trn','tbl_remainder','tbl_supplie_epcg','tbl_supplier','tbl_supplier_product','tbl_tax_sampletrn','tbl_taxinvoice','tbl_taxinvoicetrn','tbl_temp_import_record','tbl_user_wise_customer','tbl_vgm','tbl_vgmtrn','upload_bl','upload_shiping_bill','upload_shiping_bill_trn','tbl_estimate','tbl_estimate_trn','tbl_estimate_packing','company_tag_master','tbl_agent_master','tbl_company_document','tbl_company_document_setup','tbl_cust_product_detail','tbl_document_upload','tbl_eseal','tbl_expense_payment','tbl_expense_payment_trn','tbl_follow_up_type','tbl_payment_terms','tbl_pi_followup','tbl_shipping_line_master','tbl_warner','tbl_company_branch');
		}
		else if($which == 2)
		{
				$table_array = array('tbl_autometic_loading_plan','tbl_customer_invoice','tbl_expense_payment_trn','tbl_expense','tbl_export_annexure','tbl_export_invoice', 'tbl_export_loading_trn','tbl_export_packing','tbl_export_sampletrn','tbl_export_supplier','tbl_exportmakecontainer','tbl_exportproduct_trn','tbl_invoices_html','tbl_pallet_order','tbl_pallet_order_trn','tbl_payment','tbl_performa_additional_detail','tbl_performa_box_design','tbl_performa_invoice','tbl_performa_packing','tbl_performa_trn','tbl_pi_advance_payment','tbl_pi_loading_plan','tbl_po_payment','tbl_po_payment_trn', 'tbl_producation','tbl_production_mst','tbl_production_trn','tbl_purchase_order','tbl_purchase_packing','tbl_purchaseordertrn','tbl_qc_photos','tbl_qc_table','tbl_quotation','tbl_quotation_trn','tbl_receive_payment_part','tbl_receive_payment_part_trn','tbl_remainder','tbl_tax_sampletrn','tbl_taxinvoice','tbl_taxinvoicetrn','tbl_temp_import_record','tbl_vgm','tbl_vgmtrn','upload_bl','upload_shiping_bill','tbl_estimate','tbl_estimate_trn','tbl_estimate_packing','tbl_eseal','tbl_pi_followup','upload_shiping_bill_trn');
		}
		else if($which == 3)
		{
				$table_array = array('customer_add_consigner','customer_detail','tbl_customer_add_detail','tbl_customer_box_design','tbl_autometic_loading_plan','tbl_customer_invoice','tbl_expense','tbl_export_annexure','tbl_export_invoice' ,'tbl_export_loading_trn','tbl_export_packing','tbl_export_sampletrn','tbl_export_supplier','tbl_exportmakecontainer','tbl_exportproduct_trn','tbl_invoices_html','tbl_pallet_order','tbl_pallet_order_trn','tbl_payment','tbl_performa_additional_detail','tbl_performa_box_design','tbl_performa_invoice','tbl_performa_packing','tbl_performa_trn','tbl_pi_advance_payment','tbl_pi_loading_plan','tbl_po_payment','tbl_po_payment_trn', 'tbl_producation','tbl_production_mst','tbl_production_trn','tbl_purchase_order','tbl_purchase_packing','tbl_purchaseordertrn','tbl_qc_photos','tbl_qc_table','tbl_quotation','tbl_quotation_trn','tbl_receive_payment_part','tbl_receive_payment_part_trn','tbl_remainder','tbl_tax_sampletrn','tbl_taxinvoice','tbl_taxinvoicetrn','tbl_temp_import_record','tbl_vgm','tbl_vgmtrn','upload_bl','upload_shiping_bill','tbl_supplie_epcg','tbl_supplier','tbl_supplier_product','tbl_estimate','tbl_estimate_trn','tbl_estimate_packing','tbl_cust_product_detail','tbl_eseal','tbl_pi_followup','upload_shiping_bill_trn');
		}
		foreach($table_array as $table)
		{
			$qry = 'TRUNCATE '.$table; 
			$qry = $this->db->query($qry);
		}
		return 1;
		 
	}
}

?>