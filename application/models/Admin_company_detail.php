<?php 
class Admin_company_detail extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function s_select()
	{
 		$q = $this->db->get('tbl_company_profile');
		return $q->result();
	}
 	public function s_edit_select($id)
	{
		$this->db->where('s_id',$id);
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	}
	public function get_subcription_detail($id)
	{
		$q = 'SELECT max(subcription_amt_id) as subcription_amt_id FROM `tbl_subcription_amt`';
		$q_con = $this->db->query($q);
		return $q_con->row();
	}
	public function document_data($id)
	{
		$this->db->where('doc.company_id',$id);
		$q = $this->db->join('tbl_company_profile as mst','mst.s_id = doc.company_id','Inner');
		$q = $this->db->get('tbl_company_document as doc');
		return $q->row();
	}
	public function insert_subcription($data)
	{
		 $this->db->insert('tbl_subcription_amt',$data);
		  return   $this->db->insert_id();
	}
	public function s_edit($data,$id)
	{
		
		$this->db->where('s_id',$id);	
		return $this->db->update('tbl_company_profile',$data);	
	}

	public function s_del($id)
	{
		$this->db->where('s_id',$id);
		return $this->db->delete('tbl_company_profile');
	}
	public function update_doc($data,$id)
	{
	 	$this->db->where('company_id',$id);	
		return $this->db->update('tbl_company_document',$data);	
	}
	public function checkrenew($renewdays,$totaldays)
 	{
	  	$checking_dates = $totaldays - $renewdays;
		 $q = 'SELECT ('.$totaldays.' - DATEDIFF(CURRENT_DATE(),cdate)) as subdues_days FROM `ciadmin_login` where DATEDIFF(CURRENT_DATE(),cdate) >= '.$checking_dates; 
		$q_con = $this->db->query($q);
		
		return $q_con->row();
		 
	}  
}

?>