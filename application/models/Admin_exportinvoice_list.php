<?php 
class Admin_exportinvoice_list extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
		
	}
	
	public function getexportdata()
	 {
		 $q = $this->db->where("status",0);
		 $q= $this->db->get("tbl_export_invoice");
		  
		 return $q->result();
	 }
	 
	public function s_select()
	{
		$q = $this->db->select('invoice.*, consign.c_name')
			 ->from('tbl_performa_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			->where('status',0)
			->order_by("performa_date", "desc")
			->get();
	 	return $q->result();
	}

	// public function fugrecord($export_invoice_id) {
    //     $this->db->select('id');
    //     $this->db->from('tbl_createfumigation');
    //     $this->db->where('export_invoice_id', $export_invoice_id);
    //     $query = $this->db->get();

    //     if ($query->num_rows() > 0) {
    //         return $query->row();
    //     } else {
    //         return false;
    //     }
    // }
	
	public function s_select1($id){
		$this->db->where('id',$id);
		$q = $this->db->get('customer_detail');
		return $q->row();
	}
	
	public function select_consigner(){
		$q = $this->db->get('customer_detail');
		return $q->result();
	}
	public function c_select($id){
		
		$this->db->where('customer_id',$id);	
		$q = $this->db->get('performa_invoice');
		return $q->result();
	}

	public function s_edit_select($id){
		$this->db->where('id',$id);
		$q = $this->db->get('performa_invoice');
		return $q->row();
	}
	
	public function deleterecordvgm($id)
	{
	 	$cid = $this->db->where('vgm_id',$id);
		$cid = $this->db->delete('tbl_vgm');
		$cid1 = $this->db->where('vgm_id',$id);
		$cid1 = $this->db->delete('tbl_vgmtrn');
		return $cid1;
	}
	
	public function exportinvoicedelete($id)
	{
		
		$export_done_data =array(
			 "export_done_status" => 0,
			 "export_time"		  => 0
		);
		//$update_export_done = $this->db->where('performa_invoice_id', $performa_invoice_id); 
		$update_export_done = $this->db->where('export_time', $id); 
		$update_export_done = $this->db->update('tbl_pi_loading_plan',$export_done_data);
		 
		$data = array("status"=>2);
		$updateid = $this->db->where('export_invoice_id',$id);
		$updateid = $this->db->update('tbl_export_invoice',$data);
		$deletetrn = $this->db->where('export_invoice_id',$id);
		$deletetrn  = $this->db->delete('tbl_exportproduct_trn');
		$deletecon = $this->db->where('exportinvoice_id',$id);
		$deletecon  = $this->db->delete('tbl_exportmakecontainer');
		$deleteann = $this->db->where('export_invoice_id',$id);
		$deleteann  = $this->db->delete('tbl_export_annexure');
	 	$deletesamtrn = $this->db->where('export_invoice_id',$id);
		$deletesamtrn  = $this->db->delete('tbl_export_annexure');
		$deleteloding = $this->db->where('export_invoice_id',$id);
		$deleteloding  = $this->db->delete('tbl_export_loading_trn');
		// $cid 		= $this->db->where('upload_shiping_bill_id',$id);
		// $cid 		= $this->db->delete('upload_shiping_bill_trn');
		$cid1 		= $this->db->where('export_invoice_id',$id);
		$cid1 		= $this->db->delete('upload_shiping_bill');
		return 	$updateid;
	}
	
	public function exportinvoice_data($id)
	{
		$q = $this->db->select('invoice.*, consign.c_name , consign.c_companyname , consign.shippment_days')
			 ->from('tbl_export_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			->where('export_invoice_id',$id)
			->get();
			//echo $this->db->last_query();
			return $q->row();
	}
	public function get_port_data($port_of_discharge)
	{
		$q = $this->db->select('master.*')
			 ->from('tbl_port_master as master')
		 	->where('port_name Like "'.$port_of_discharge.'%" and is_active =','Yes')
			->get();
			 
			return $q->row();
	}
	
		
	public function warner_data($sid)
	{
		$q = $this->db->select("*");
		$q = $this->db->where("company_id",$sid);
	 	$q = $this->db->get("tbl_warner");
		  
		return $q->row();
	}
	
	public function loading_data($id)
	{
		$q = $this->db->select("trn.*");
		$q = $this->db->where("trn.export_invoice_id",$id);
	 	$q = $this->db->get("tbl_export_loading_trn as trn");
		  
		return $q->result();
	}
	public function shipping_bill_data($id)
	 {
		 $q = $this->db->where("id",$id);
		 $q= $this->db->get("upload_shiping_bill");
		  
		 return $q->row();
	 }
	public function updateperformainvoice($id,$no_of_export)
	{
		$data = array("no_of_export"=>$no_of_export);
		$this->db->where('performa_invoice_id',$id);
		 $this->db->update('tbl_performa_invoice',$data);	
		 
		 return 1;
	}
	public function check_congine($array)
	{
		$sql='SELECT DISTINCT consiger_id FROM `tbl_export_invoice` where export_invoice_id in ('.implode(",",$array).')';
		$query = $this->db->query($sql);

		return $query->num_rows();
	} 
	public function loadingrecord($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_export_loading as mst")
			 ->where("mst.export_invoice_id",$id)
			 ->get();
		 
		return $q->result();
	} 
	public function vgmrecord($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_vgm as mst")
			 ->where("mst.export_invoice_id",$id)
			 ->get();
		 
		return $q->row();
	} 
	
	public function fumigationrecord($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_createfumigation as mst")
			 ->where("mst.export_invoice",$id)
			 ->get();
		 
		return $q->row();
	} 
	public function qcrecord($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_qc_table as mst")
			 ->where("mst.export_invoice_id",$id)
			 ->where("mst.status",0)
			 ->get();
		 
		return $q->row();
	}
	public function insert_qc($data)
	{
		 
		$cid = $this->db->insert('tbl_qc_table',$data);
		return $cid = $this->db->insert_id();
	}	
	public function insert_ewb($data)
	{
	 	$cid = $this->db->insert('tbl_eseal',$data);
		return $cid = $this->db->insert_id();
	}
	public function update_ewb($data,$id)
	{
	 	$cid = $this->db->where('ewb_template_id',$id);
		$cid = $this->db->update('tbl_eseal',$data);
		 
		return $cid = $this->db->insert_id();
	}
	public function get_ewb_template($id)
	{
		$q= $this->db->select("mst.*,invoice.export_invoice_no")
			 ->from("tbl_eseal as mst")
			 ->join('tbl_export_invoice as invoice', 'invoice.export_invoice_id = mst.export_invoice_id', 'LEFT')
			 ->where("mst.export_invoice_id",$id)
			->get();
		 
		return $q->row();
	}
	public function update_qc($data,$id)
	{
	 	$cid = $this->db->where('qc_table_id',$id);
		$cid = $this->db->update('tbl_qc_table',$data);
		 
		return $cid = $this->db->insert_id();
	}
	public function update_qc_photos($data,$id)
	{
	 	$cid = $this->db->where('qc_photos_id',$id);
		$cid = $this->db->update('tbl_qc_photos',$data);
		 
		return $cid;
	}
	public function insert_qc_photos($data)
	{
		 
		$cid = $this->db->insert('tbl_qc_photos',$data);
		return $cid = $this->db->insert_id();
	}	
	public function qc_photo_delete($id)
	{
	 	$cid = $this->db->where('qc_photos_id',$id);
		$cid = $this->db->delete('tbl_qc_photos');
		return $cid;
	}	
	public function delete_shipping_bill($id)
	{
	 	$cid = $this->db->where('upload_shiping_bill_id',$id);
		$cid = $this->db->delete('upload_shiping_bill_trn');
		$cid1 = $this->db->where('id',$id);
		$cid1 = $this->db->delete('upload_shiping_bill');
		return $cid1;
	}
	public function qc_photo_record($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_qc_photos as mst")
			 ->where("mst.qc_photos_id",$id)
			 ->where("mst.status",0)
			 ->get();
		 
		return $q->row();
	}
	public function get_kasar_amt($id)
	{
		$q = $this->db->select('kasar.*,export.export_invoice_no')
			 ->from('tbl_kasar_amount as kasar')
			->join('tbl_export_invoice as export', 'export.export_invoice_id = kasar.export_invoice_id', 'LEFT')
			->where('kasar.export_invoice_id',$id)
			->get();
			//echo $this->db->last_query();
			return $q->row();
	}
	public function update_kasar_amt($data,$id)
	{
	 	$cid = $this->db->where('kasar_amount_id',$id);
		$cid = $this->db->update('tbl_kasar_amount',$data);
		 
		return $cid;
	}
	public function insert_kasar_amt($data)
	{
		 
		$cid = $this->db->insert('tbl_kasar_amount',$data);
		return $cid = $this->db->insert_id();
	}	
}

?>