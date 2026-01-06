<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Pallet_type_list extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Pallet_type_model','pallet');
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
			$data['company_detail'] = $this->admin_company_detail->s_select();	
		 	$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/pallet_type_list',$data);	
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
		 $aColumns = array('mst.pallet_type_id','mst.pallet_type_name','status','(SELECT count(*) FROM `tbl_performa_packing` where pallet_type_id = mst.pallet_type_id) as total_cnt');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_pallet_type as mst";
		 $isJOIN = array();
		 $hOrder = "mst.pallet_type_id asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->pallet_type_name;
				  	$delete_btn = '';
					 
					 // if($row->total_cnt==0)
					// {
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->pallet_type_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					//}	 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="editpallet_type('.$row->pallet_type_id.');"><i class="fa fa-pencil"></i> Edit</a>
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
			$check_pallet_type = $this->pallet->check_pallet_type($this->input->post('edit_pallettype'));
			if(empty($check_pallet_type))
			{
				$data = array(
						'pallet_type_name' => $this->input->post('edit_pallettype') 
					);
					$insertid = $this->pallet->update_pallet($data,$id);
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
					$row['pallettype'] = $this->input->post('editpallettype');
				
			}
				
		}
		else 
		{
			$check_pallet_type = $this->pallet->check_pallet_type($this->input->post('pallet_type'));
			if(empty($check_pallet_type))
			{
				$data = array(
					'pallet_type_name' => $this->input->post('pallet_type') 
				);
				$insertid = $this->pallet->insert_pallet($data);
		 
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
		$deleteid=$this->pallet->delete_record($id);
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
		$resultdata=$this->pallet->get_pallet($id);
		 
		echo json_encode($resultdata);
	}
}
?>