<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Finish_list extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Finish_model','finish');
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
			
			$this->load->view('admin/finish_list',$data);	
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
		 $aColumns = array('mst.finish_id','mst.finish_name','status','(SELECT count(*) FROM `tbl_packing_model` where finish_id = mst.finish_id) as total_cnt');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_finish as mst";
		 $isJOIN = array();
		 $hOrder = "mst.finish_id desc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->finish_name;
				  	$delete_btn = '';
					// if($row->total_cnt==0)
					//{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->finish_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					//}	 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="editfumigation('.$row->finish_id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								';
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$delete_btn .'
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
			$data = array(
					'finish_name' 	=> $this->input->post('edit_finish_name'), 
					'field1' 		=> $this->input->post('edit_field1'), 
					'field2' 		=> $this->input->post('edit_field2') 
				);
				$insertid = $this->finish->update_finish($data,$id);
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
			$check_finish = $this->finish->check_finish($this->input->post('finish_name'));
			if(empty($check_finish))
			{
				$data = array(
					'finish_name' 	=> $this->input->post('finish_name'), 
					'field1' 		=> $this->input->post('field1'), 
					'field2' 		=> $this->input->post('field2') 
				);
					$insertid = $this->finish->insert_finish($data);
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
		$deleteid=$this->finish->delete_record($id);
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
		$resultdata=$this->finish->get_finish($id);
		 
		echo json_encode($resultdata);
	}
}
?>