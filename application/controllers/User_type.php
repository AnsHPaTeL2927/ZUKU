<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_type extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Usertpye_model','type');
		$this->load->model('menu_model','menu');			
		$this->load->helper('url');	
		$this->load->library(array('form_validation','session'));
				
	}
	public function index()
	{	
	
		 if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			 $data['afterstep'] = 0;
			 $this->load->model('admin_company_detail');	
			 $data['company_detail'] = $this->admin_company_detail->s_select();
			 $data['menu_data'] = $this->menu->usermain_menu($this->session->usertype_id);	
			
			
			 $this->load->view('admin/user_type',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function fetch_record()
	{ 
		 
		$this->load->model('Pagging_model');//call module 
		$aColumns = array('usertype_id', 'user_type');
		$isWhere = array();
		$table = "tbl_usertype as mst";
		$isJOIN = array();
		$hOrder = "mst.usertype_id desc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				
		foreach($sqlReturn['data'] as $row) {
			$row_data = array();
			$row_data[] = $no;
			$row_data[] = $row->user_type;
			 
			 
					 
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->usertype_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					 		 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="editpallet_cap('.$row->usertype_id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								'.$delete_btn;
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" cap="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											 
									</div>';
			$appData[] = $row_data;
			$no++;
		 }
			$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');
			$numrecord=$sqlReturn['data'];
		$output = array(
							"sEcho" => intval($this->input->get('sEcho')),
							"iTotalRecords" =>  $numrecord,
							"iTotalDisplayRecords" =>$totalrecord,
							"aaData" => $appData
					);
		echo json_encode( $output );
	}
	public function manage()
	{
		$data = array(
			'user_type'  => $this->input->post('user_type'),
	 	);
		$insertid = $this->type->insert_usertype($data);
		 if($insertid)
		 {
		 	 $row['res'] = 1;
		 	
		 }
		 else{
		 	$row['res'] = 0;
		 }
		 echo json_encode($row);
	}
	 public function fetchdata()
	{ 
		$id = $this->input->post('id');
		$data = $this->type->getusertype($id);
		 
		echo json_encode($data);
	}
	public function update_record()
	{
		$data_array = array(
			"user_type" => $this->input->post('edit_user_type') 
	 	);
		$id = $this->input->post('eid');
		$updateid = $this->type->update_data($data_array,$id);
		$row = array();
		if($updateid)
		{
			$row['res'] = 1;
		}
		else
		{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
	 	$updatedid = $this->type->deleterecord($id);
		$row = array();
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
}
