<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Payment_mode extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Payment_model','mode');
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
			 
			$this->load->view('admin/payment_mode_list',$data);	
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
		 $aColumns = array('mst.payment_mode_id','mst.payment_mode','status','(SELECT count(*) FROM `tbl_pi_advance_payment` where payment_mode_id = mst.payment_mode_id) as total_cnt');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_payment_mode as mst";
		 $isJOIN = array();
		 $hOrder = "mst.payment_mode_id asc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->payment_mode;
				  	$delete_btn = '';
					if($row->total_cnt==0 and $row->payment_mode_id != 2)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->payment_mode_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					}			 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_payment_mode('.$row->payment_mode_id.');"><i class="fa fa-pencil"></i> Edit</a>
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
			$check_box_design = $this->mode->check_paymentmode($this->input->post('edit_payment_mode'));
			if(empty($check_box_design))
			{
				$data = array(
						'payment_mode' => $this->input->post('edit_payment_mode') 
					);
				$insertid = $this->mode->update_payment($data,$id);
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
				$row['editpaymentmode'] = $this->input->post('editpaymentmode');
			}
		}
		else 
		{
			$check_box_design = $this->mode->check_paymentmode($this->input->post('payment_mode'));
			if(empty($check_box_design))
			{
				$data = array(
					'payment_mode' => $this->input->post('payment_mode') 
				);
				$insertid = $this->mode->insert_payment($data);
		 
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
		$deleteid=$this->mode->delete_record($id);
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
		$resultdata=$this->mode->getpaymentmode($id);
		 
		echo json_encode($resultdata);
	}
	
	
}
?>