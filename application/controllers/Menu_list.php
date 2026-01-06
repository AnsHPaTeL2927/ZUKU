<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_list extends CI_Controller {

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
			  $data['company_detail']=$this->admin_company_detail->s_select();
			 $data['menu_data']	 	 = $this->menu->usermain_menu($this->session->usertype_id);	
			
			
			 $this->load->view('admin/menu_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function fetch_record()
	{ 
		 $where = '   pid = 0';
		if(!empty($this->input->get('pid')))
		{
			$where = '   pid = '.$this->input->get('pid');
			
		}
		$this->load->model('Pagging_model');//call module 
		$aColumns = array('menu_id', 'menu_name','url_name');
		$isWhere = array($where);
		$table = "tbl_menu as mst";
		$isJOIN = array();
		$hOrder = "mst.order_by asc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);	
		foreach($sqlReturn['data'] as $row) {
			$row_data = array();
			$row_data[] = $no;
			$row_data[] = $row->menu_name;
			 $plus_btn = ' ';
			 if(empty($row->url_name))
			 {
				 $plus_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Add Submenu"  onclick="add_submenu('.$row->menu_id.')" href="javascript:;" ><i class="fa fa-plus"></i> Submenu</a>
								 </li>';
			 }
			  $delete_btn = '	
								 
								<li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->menu_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					 		 
					 $actionbtn = $plus_btn.'
								 <li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="editmenu('.$row->menu_id.');"><i class="fa fa-pencil"></i> Edit</a>
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
			'menu_name' => $this->input->post('menu_name'),
			'url_name'  => $this->input->post('url_name'),
			'fa_icon'  	=> $this->input->post('fa_icon'),
			'order_by'  => $this->input->post('order_by'),
			'pid'  		=> $this->input->post('pid'),
			'status'  	=> 0,
			'cdate'  	=> date('Y-m-d H:i:s')
	 	);
		$insertid = $this->type->insert_menu($data);
		 if($insertid)
		 {
		 	 $row['res'] = 1;
		 	
		 }
		 else
		 {
		 	$row['res'] = 0;
		 }
		 echo json_encode($row);
	}
	 public function fetchdata()
	{ 
		$id = $this->input->post('id');
		$data = $this->type->getmenulist($id);
		 
		echo json_encode($data);
	}
	public function update_record()
	{
	$data = array(
			'menu_name' => $this->input->post('edit_menu_name'),
			'url_name'  => $this->input->post('edit_url_name'),
			'fa_icon'  	=> $this->input->post('edit_fa_icon'),
			'order_by'  => $this->input->post('edit_order_by'),
			'status'  	=> 0,
			'cdate'  	=> date('Y-m-d H:i:s')
	 	);
		$id = $this->input->post('eid');
		$updateid = $this->type->update_menudata($data,$id);
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
	 	$updatedid = $this->type->deletemenurecord($id);
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
