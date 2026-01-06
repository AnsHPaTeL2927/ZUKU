<?php 
defined("BASEPATH") or exit('no direct script allowed');
class Dashboard extends CI_controller{
	
	public function __construct()
	{
		parent::__construct();
	
		$this->load->model('admin_login');	
		$this->load->model('menu_model','menu');
	 
	}
	
	public function index() {
		if ($this->session->userdata('id')  && $this->session->userdata('title') == TITLE) {
			// if (!$this->session->userdata('otp_verified')) {
				// redirect(base_url('Otp/index'));
				// return; 
			// }
			
			$checkdata['result'] = $this->admin_login->afetrlogin($this->session->id);
			$this->load->model('admin_company_detail');
			$checkdata['company_detail'] = $this->admin_company_detail->s_select();
			$checkdata['menu_data'] = $this->menu->usermain_menu($this->session->usertype_id);
			
			$this->load->view('admin/dashboard', $checkdata);
		} else {
			redirect(base_url());
		}
	}
	
	public function fetch_dashboard()
	{
		$f_year = $this->input->post('f_year');
			$all_data								 = $this->admin_login->get_data($f_year); 
			$checkdata['export_con']				 = ($all_data->export_con + $all_data->direct_export_con);
			$checkdata['pendingdoc_con']	 		 = ($all_data->pendingdoc_con - $all_data->export_con);
		 	$checkdata['confirm_pi']				 = ($all_data->confirm_pi - $all_data->export_con);
		  	$checkdata['pending_producation_sheet']	 = ($all_data->confirm_pi - $all_data->under_producation);
		
			$checkdata['ready_to_load']				 = ($all_data->pqpdone);
			//$checkdata['ready_to_load']				 = ($all_data->ready_to_load);
		 	$checkdata['produced']					 = ($all_data->productiondone);
		 	//$checkdata['produced']					 = ($all_data->total_produced);
		  	//$checkdata['under_producation']			 = ($all_data->under_producation - $checkdata['produced'] - $checkdata['ready_to_load'] - $all_data->export_con);
		  
		  	$checkdata['under_producation']			 = ($all_data->under_producation_order_new);
		 
			
			//order
			$checkdata['export_con_order']			 	 = ($all_data->export_con_order + $all_data->direct_export_con_order);
			$checkdata['confirm_pi_order']				 = ($all_data->confirm_pi_order - $all_data->export_con_order);
			 
			$checkdata['total_amount']			     	 = ($all_data->total_amount);
			$checkdata['paid_amount']			     	 = ($all_data->paid_amount);
			$checkdata['due_amount']			     	 = ($all_data->total_amount - $all_data->paid_amount);
			 echo json_encode($checkdata);
	}
	public function fetch_calenderdata()
	{
		$start = date('Y-m-d',strtotime($this->input->get('start')));
	 
		$end = date('Y-m-d',strtotime($this->input->get('end')));
		$get_data = $this->admin_login->get_remainder_data($start,$end);
		  
		echo json_encode($get_data);
	}
	public function calaendar_data()
	{
		$id =  $this->input->post('id');
	  
		$get_data = $this->admin_login->get_remainder_singel_data($id);
		  
		echo json_encode($get_data);
	}
	public function calaendar_delete()
	{
		$id =  $this->input->post('id');
	  
		$deleteid = $this->admin_login->delete_remainder_singel_data($id);
		  
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function manage()
	{
		$data=array(
			'start_date' 	 => date('Y-m-d',strtotime($this->input->post('start_date'))),
			'end_date'   	 => date('Y-m-d',strtotime($this->input->post('end_date'))),
			'remainder_text' => $this->input->post('remainder_text'),
			'cdate'		 	 => date('d-m-Y H:i:s'),
			'status' => 0
			);
			if(strtolower($this->input->post('mode'))=="add")
			{
				$rdata = $this->admin_login->insert_remainder($data);
				 if($rdata)
				 {
				 	$row['res'] = 1;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
			}
			else if(strtolower($this->input->post('mode'))=="edit"){
				$id = $this->input->post('product_size_id');
				$rdata = $this->hsnc->b_edit($data,$id);
				 if($rdata)
				 {
				 	$row['res'] = 2;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
			}
          
		echo json_encode($row);
	}
	 
}

?>