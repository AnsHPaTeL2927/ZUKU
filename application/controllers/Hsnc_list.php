<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Hsnc_list extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_product_code','code');
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
			 			
				
			$this->load->view('admin/hsnc_list',$data);	
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
		 $aColumns = array('mst.id','mst.hsnc_code','orderby','status','(SELECT count(*) FROM `tbl_series` where hsnc_code = mst.hsnc_code) as total_cnt');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "product_code_detail as mst";
		 $isJOIN = array();
		 $hOrder = "mst.orderby asc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->hsnc_code;
				 	$row_data[] = $row->orderby;
				 	$delete_btn = '';
					if($row->total_cnt==0)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					}			 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->id.');"><i class="fa fa-pencil"></i> Edit</a>
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
			$check_box_design = $this->code->check_hsc($this->input->post('edit_hsnc_code'));
			if(empty($check_box_design) || $this->input->post('edit_hsnccode') == $this->input->post('edit_hsnc_code'))
			{
				$data = array(
						'hsnc_code' 	=> $this->input->post('edit_hsnc_code'),
						'p_name' 	 	=> '',
						'size_type' 	=> 'SQM',
						'status' 	 	=> 'Active',
						'orderby' 	 	=> $this->input->post('edit_order_by')
					);
					$insertid = $this->code->pc_edit($data,$id);
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
				$row['edit_hsnccode'] = $this->input->post('edit_hsnccode');
			}
		}
		else 
		{
			$check_box_design = $this->code->check_hsc($this->input->post('hsnc_code'));
			if(empty($check_box_design))
			{
				$data = array(
					'hsnc_code' => $this->input->post('hsnc_code'),
					'p_name' 	 => '',
					'size_type' => 'SQM',
					'status' 	 => 'Active',
					'orderby' 	 => $this->input->post('order_by')
				);
				$insertid = $this->code->pc_insert($data);
				
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
		$deleteid=$this->code->pc_del($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchhsncdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->code->pc_select_edit($id);
		 
		echo json_encode($resultdata);
	}
	 
	
}
?>