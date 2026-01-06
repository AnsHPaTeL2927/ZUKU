<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Company_branch extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
	 
		$this->load->model('Branch_model','branch');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index()
	{ 
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_company_detail');	
			$this->load->model('Settingmodel');	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['setting_data'] 	= $this->Settingmodel->setting_data(1);	
		 	$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/company_branch_list',$data);	
		}
		else
		{
			redirect(base_url().'');
		}		
	}
	public function fetch_record()
	{
	 	$where = '';
		 
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.company_branch_id','company_branch_code','company_branch_name','company_branch_address','(SELECT count(*) FROM `tbl_export_annexure` where company_branch_id = mst.company_branch_id) as total_cnt');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_company_branch as mst";
		 $isJOIN = array();
		 $hOrder = "mst.company_branch_id asc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->company_branch_code;
				 	$row_data[] = $row->company_branch_name;
				 	$row_data[] = $row->company_branch_address;
				  	$delete_btn = '';
					if($row->total_cnt==0)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->company_branch_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					} 		 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="editpallet_cap('.$row->company_branch_id.');"><i class="fa fa-pencil"></i> Edit</a>
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
		$id =  $this->input->post('eid');
		$row = array();
		if(!empty($id))
		{
			$check_pallet_cap = $this->branch->check_pallet_cap($this->input->post('edit_company_branch_code'));
			if(empty($check_pallet_cap) || $this->input->post('edit_company_branch_code') == $this->input->post('editcompanybranchcode'))
			{
				$data = array(
						'company_branch_name' 		=> $this->input->post('edit_company_branch_name'), 
						'company_branch_code' 		=> $this->input->post('edit_company_branch_code'), 
						'company_branch_address' 	=> $this->input->post('edit_company_branch_address'), 
						'field1' 					=> $this->input->post('edit_field1'), 
						'field2' 					=> $this->input->post('edit_field2'), 
						'field3' 					=> $this->input->post('edit_field3'), 
						'status' 					=> 0, 
						'cdate' 					=> date('Y-m-d H:i:s')
					);
					$insertid = $this->branch->update_company_branch($data,$id);
				$row = array();
				if($insertid)
				{
					$row['res'] = 1;
				}
				else
				{
					$row['res'] = 0;
				}
			}
			else
			{
					$row['res'] = 2;
					$row['company_branch_code']  = $this->input->post('editcompanybranchcode');
			}
		}
		else 
		{
			$check_pallet_cap = $this->branch->check_pallet_cap($this->input->post('company_branch_code'));
			if(empty($check_pallet_cap))
			{
				$data = array(
						'company_branch_name' 		=> $this->input->post('company_branch_name'), 
						'company_branch_code' 		=> $this->input->post('company_branch_code'), 
						'company_branch_address' 	=> $this->input->post('company_branch_address'), 
						'field1' 					=> $this->input->post('field1'), 
						'field2' 					=> $this->input->post('field2'), 
						'field3' 					=> $this->input->post('field3'), 
						'status' 					=> 0, 
						'cdate' 					=> date('Y-m-d H:i:s')
					);
				$insertid = $this->branch->insert_company_branch($data);
		 
				
				if($insertid)
				{
						$row['res'] = 1;
						$row['company_branch_id']	 = $insertid;
						$row['company_branch_code'] = $this->input->post('company_branch_code');
				}
				else
				{
					$row['res'] = 0;
				}
			}
			else
			{
					$row['res'] = 2;
					$row['company_branch_id']	 = $check_pallet_cap->company_branch_id;
					$row['company_branch_code']  = $this->input->post('company_branch_code');
			}
		}
		echo json_encode($row);
 	}
 	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->branch->delete_record($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	} 
	public function use_onoff()
	{
		$checked=$this->input->post('value');
		$deleteid=$this->branch->update_onoff($checked);
		if($deleteid)
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
		$id=$this->input->post('id');
		$resultdata=$this->branch->get_company_branch($id);
		 
		echo json_encode($resultdata);
	}
	
	
}
?>