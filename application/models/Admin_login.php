<?php 
class Admin_login extends CI_Model 
{
	function __construct()
	{
		parent::__construct();	
		$this->load->database();
			
	}
 	public function login($data)
	{	
		$uname = $data['username'];
		$password = md5($data['password']);
		 
		$q = 'SELECT * FROM `tbl_user` where (mobile_no = "'.stripcslashes($uname).'" or user_name = "'.stripcslashes($uname).'" or email = "'.stripcslashes($uname).'") and password ="'.$password.'" and status = 0';
		$q_con = $this->db->query($q);
		$login_detail = $q_con->row();
		 
		return  $login_detail;
	}

	public function add_user_key_verification_log($data)
	{
		$this->db->insert('tbl_user_key_verification_log',$data);
	}
	
	public function checkp($data)
 	{
	 
		$q = 'SELECT * FROM `ciadmin_login` where DATEDIFF(CURRENT_DATE(),cdate) <= '.CONFIGURATION;
		$q_con = $this->db->query($q);
		
		return $q_con->row();
		 
	}
	public function checkrenew_key($renew_key)
 	{
	 
		if(!empty($renew_key))
		{
			$where = 'renew_key = "'.$renew_key.'"';
		}
		else
		{
			$where = 'renew_key = ""';
		}
		$q = 'SELECT * FROM `ciadmin_login` where '.$where.' and  convert_tz(UTC_TIMESTAMP(),"+00:00","+05:30") BETWEEN key_genrate_time and DATE_ADD(key_genrate_time,INTERVAL 24 HOUR)';
		$q_con = $this->db->query($q);
		
		return $q_con->row();
		 
	}
	public function checkserial($serial)
 	{
	 	$q = 'SELECT * FROM `ciadmin_login` where checking_key = "'.md5($serial).'"';
		$q_con = $this->db->query($q);
	 	return $q_con->row();
	}
	public function update_subcription($log_id,$serial)
 	{
		$q = 'UPDATE `ciadmin_login` SET `subcription_time` = `subcription_time` + 1,cdate = "'.date('Y-m-d').'",checking_key = "'.md5($serial).'" WHERE `ciadmin_login`.`log_id` = '.$log_id;
		$q_con = $this->db->query($q);
		return 1;
	}
	public function afetrlogin($id)
	{
		$array = array('user_id' => $id);
		$q = $this->db->where($array);
		$q = $this->db->get('tbl_user');
		//echo $this->db->last_query();
		return $q->row();
	}
	public function get_remainder_data($start,$end)
	{
		 
		 $qry = "SELECT * FROM `tbl_remainder` where status =0 and start_date BETWEEN '".date('Y-m-d',strtotime($start))."' and '".date('Y-m-d',strtotime($end))."'";
		 $q_con = $this->db->query($qry);
		
		return $q_con->result();
	}
	public function get_remainder_singel_data($id)
	{
		 
		 $qry = "SELECT * FROM `tbl_remainder` where status =0 and  remainder_id = ".$id;
		$q_con = $this->db->query($qry);
		
		return $q_con->row();
	}
	public function delete_remainder_singel_data($id){
		
		$this->db->where('remainder_id',$id);
		return $this->db->delete('tbl_remainder');
	}
	public function updateprice($usd,$euro,$id)
	{
		$data=array('usd'=>$usd,'euro'=>$euro,'udate'=>date('Y-m-d H:i:s'));
		$this->db->where('log_id',$id);
		$this->db->update('ciadmin_login',$data);
		if ($this->db->affected_rows() > 0)
		{
		  return "Data update successfully";
		}
		else
		{
		  return "Something is wrong";
		}
	}
	public function updatesize($sizeval,$id)
	{
		
		$data=array('size_type'=>$sizeval,'udate'=>date('Y-m-d H:i:s'));
		$this->db->where('log_id',$id);
		$this->db->update('ciadmin_login',$data);
		if ($this->db->affected_rows() > 0)
		{
		  return "Data update successfully";
		}
		else
		{
		  return "Something is wrong";
		}
	}
	public function insert_loginistory($data)
	{
		 $this->db->insert('login_history',$data);
		  return   $this->db->insert_id();
	}
	public function insert_remainder($data){
		 $this->db->insert('tbl_remainder',$data);
		  return   $this->db->insert_id();
	}
	public function update_loginistory($id,$data)
	{
		$this->db->where('log_id',$id);	
		return $this->db->update('login_history',$data);	
	}
	public function update_key($data)
	{
		$q = $this->db->where('log_id',1);	
		$q = $this->db->update('ciadmin_login',$data);	
		return $q;
	}
	public function get_data($f_year)
	{
		$f_year = explode(" - ",$f_year);
		$start_date = date($f_year[0].'-04-01');
		$end_date 	= date($f_year[1].'-03-31');
		$qry = "SELECT 
			(SELECT sum(container_details) as confirm_pi FROM `tbl_performa_invoice` WHERE status = 0 and step = 3 and confirm_status = 1 and performa_date between '".$start_date."' and '".$end_date."') as confirm_pi,
			
			(SELECT count(*) as confirm_pi FROM `tbl_performa_invoice` WHERE status = 0 and step = 3 and confirm_status = 1 and performa_date between '".$start_date."' and '".$end_date."') as confirm_pi_order,
			
			
			(SELECT sum(no_of_countainer) as under_producation FROM `tbl_production_mst` as production
			inner join tbl_performa_invoice as mst on mst.performa_invoice_id=production.performa_invoice_id   WHERE production.status = 0 and mst.status=0  and step = 3 and confirm_status = 1 and producation_date between '".$start_date."' and '".$end_date."') as under_producation,
			
			(SELECT sum(no_of_countainer) as under_producation_order_new FROM `tbl_production_mst` as production
			inner join tbl_performa_invoice as mst on mst.performa_invoice_id=production.performa_invoice_id   WHERE production.production_status = 0 and production.status = 0 and mst.status=0  and step = 3 and confirm_status = 1 and producation_date between '".$start_date."' and '".$end_date."') as under_producation_order_new,
			
			(SELECT sum(no_of_countainer) as productiondone FROM `tbl_production_mst` as production
			inner join tbl_performa_invoice as mst on mst.performa_invoice_id=production.performa_invoice_id   WHERE production.production_status = 1 and production.status = 0 and mst.status=0  and step = 3 and confirm_status = 1 and producation_date between '".$start_date."' and '".$end_date."') as productiondone,
			
			(SELECT sum(no_of_countainer) as pqpdone FROM `tbl_production_mst` as production  WHERE production.production_status != 0 and production.qc_status != 0 and production.pallet_status != 0 and production.status = 0 and producation_date between '".$start_date."' and '".$end_date."') as pqpdone,
			
			
			(SELECT count(*) as under_producation FROM `tbl_production_mst` as production
			inner join tbl_performa_invoice as mst on mst.performa_invoice_id=production.performa_invoice_id   WHERE production.status = 0 and mst.status=0  and step = 3 and confirm_status = 1 and producation_date between '".$start_date."' and '".$end_date."') as under_producation_order,
			
			
			
			(SELECT sum(total_con) as produced from (SELECT count(DISTINCT con_entry) as total_con FROM `tbl_pi_loading_plan` where already_done = 0 and export_time =0 and date(cdate) between '".$start_date."' and '".$end_date."' GROUP BY performa_invoice_id) as totalproduced) as total_produced,
			
			(SELECT count(*) as produced from (SELECT count(DISTINCT con_entry) as total_con FROM `tbl_pi_loading_plan` where already_done = 0 and export_time =0 and date(cdate) between '".$start_date."' and '".$end_date."' GROUP BY performa_invoice_id) as totalproduced) as total_produced_order,
		 	
			(SELECT sum(total_con) as ready_load from (SELECT count(DISTINCT con_entry) as total_con FROM `tbl_pi_loading_plan` where already_done = 1 and export_time =0 and date(cdate) between '".$start_date."' and '".$end_date."' GROUP BY performa_invoice_id) as readytoload) as ready_to_load,
			
			(SELECT count(*) as ready_load from (SELECT count(DISTINCT con_entry) as total_con FROM `tbl_pi_loading_plan` where already_done = 1 and export_time =0 and date(cdate) between '".$start_date."' and '".$end_date."' GROUP BY performa_invoice_id) as readytoload) as ready_to_load_order,
			
			(SELECT sum(total_con) as pending_doc from (SELECT count(DISTINCT con_entry) as total_con FROM `tbl_pi_loading_plan` where already_done = 1 and export_time != 0 and  export_done_status = 1 and date(cdate) between '".$start_date."' and '".$end_date."' GROUP BY export_time ) as pendingdoc) as pendingdoc_con,
			
			(SELECT count(*) as pending_doc from (SELECT count(DISTINCT con_entry) as total_con FROM `tbl_pi_loading_plan` where already_done = 1 and export_time != 0 and  export_done_status = 1 and date(cdate) between '".$start_date."' and '".$end_date."' GROUP BY export_time ) as pendingdoc) as pendingdoc_con_order,
			
			(SELECT sum(container_details) as export_con FROM `tbl_export_invoice` WHERE status = 0 and step = 4  and direct_invoice = 2 and invoice_date between '".$start_date."' and '".$end_date."') as export_con,
			
			(SELECT count(*) as export_con FROM `tbl_export_invoice` WHERE status = 0 and step = 4  and direct_invoice = 2 and invoice_date between '".$start_date."' and '".$end_date."') as export_con_order,
			
			(SELECT sum(container_details) as export_con FROM `tbl_export_invoice` WHERE status = 0 and step = 4  and direct_invoice = 1 and invoice_date between '".$start_date."' and '".$end_date."') as direct_export_con,
			
			(SELECT  count(*) as export_con FROM `tbl_export_invoice` WHERE status = 0 and step = 4  and direct_invoice = 1 and invoice_date between '".$start_date."' and '".$end_date."') as direct_export_con_order,
		 	 
			(SELECT sum(grand_total)   FROM `tbl_export_invoice` WHERE status = 0 and step = 4 and invoice_date between '".$start_date."' and '".$end_date."') as total_amount,
			(SELECT sum(paid_amount)   FROM `tbl_payment` WHERE status = 0 and date between '".$start_date."' and '".$end_date."') as paid_amount
		";
		$q_con = $this->db->query($qry);
		
		return $q_con->row();
	}
}


?>
