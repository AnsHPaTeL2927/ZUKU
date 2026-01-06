<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Follow_up_type extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Follow_up_type_model','follow');
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
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
		 	$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			$this->load->view('admin/follow_up_type',$data);	
		}
		else
		{
			redirect(base_url().'');
		}		
	}
	public function fetch_record()
	{
		 
		$where = '';
		 
		 $this->load->model('Pagging_model');//call module ,'(SELECT count(*) FROM `tbl_pi_advance_payment` where follow_up_type_id = mst.follow_up_type_id) as total_cnt'
		 $aColumns = array('mst.follow_up_type_id','mst.follow_up_type','status');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_follow_up_type as mst";
		 $isJOIN = array();
		 $hOrder = "mst.follow_up_type_id asc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->follow_up_type;
				  	$delete_btn = '';
					//if($row->total_cnt==0 and $row->follow_up_type_id != 2)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->follow_up_type_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					}			 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_follow_up_type('.$row->follow_up_type_id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								'.$delete_btn;
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
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
		if(!empty($id))
		{
			$check_box_design = $this->follow->check_follow_up_type($this->input->post('edit_follow_up_type'));
			if(empty($check_box_design))
			{
				$data = array(
						'follow_up_type' => $this->input->post('edit_follow_up_type') 
					);
				$insertid = $this->follow->update_follow_up_type($data,$id);
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
				$row['editfollowuptype'] = $this->input->post('editfollowuptype');
			}
		}
		else 
		{
			$check_box_design = $this->follow->check_follow_up_type($this->input->post('follow_up_type'));
			if(empty($check_box_design))
			{
				$data = array(
					'follow_up_type' => $this->input->post('follow_up_type') 
				);
				$insertid = $this->follow->insert_follow_up_type($data);
		 
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
			}
		}
		echo json_encode($row);
 	}
 	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->follow->delete_record($id);
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
		$resultdata=$this->follow->get_follow_up_type($id);
		 
		echo json_encode($resultdata);
	}
	
	
}
?>