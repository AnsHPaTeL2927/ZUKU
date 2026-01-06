<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_notify_detail extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		 $this->load->model('admin_customer_detail','cust');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index($id)
	{ 
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
		 	$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['cust_detail'] 	= $this->cust->s_edit_select($id);
			$this->load->view('admin/add_notify_detail',$data);	
		}
		else
		{
			redirect(base_url().'');
		}		
	}
	public function fetch_record()
	{
		 $where = ' and customer_id = '.$this->input->get('customer_id');
		 
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.id','mst.notify_name','mst.notify_address','status');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "customer_add_consigner as mst";
		 $isJOIN = array();
		 $hOrder = "mst.id asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->notify_name;
				 	$row_data[] = $row->notify_address;
				  	$delete_btn = '';
					 
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					 		 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_data('.$row->id.');"><i class="fa fa-pencil"></i> Edit</a>
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
			$data = array(
					'customer_id' 		=> $this->input->post('edit_customer_id'), 
					'notify_name' 		=> $this->input->post('edit_notify_name'), 
					'notify_address' 	=> nl2br($this->input->post('edit_notify_address')), 
					'cdate' 			=> date('Y-m-d H:i:s'),
					'status' 			=> 0
				);
				$insertid = $this->cust->update_notify($data,$id);
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
			
			$data = array(
					'customer_id' 		=> $this->input->post('customer_id'), 
					'notify_name' 		=> $this->input->post('notify_name'), 
					'notify_address' 	=> nl2br($this->input->post('notify_address')), 
					'cdate' 			=> date('Y-m-d H:i:s'),
					'status' 			=> 0
				);
				$insertid = $this->cust->insert_notify($data);
		 
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
		echo json_encode($row);
 	}
 	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->cust->delete_record($id);
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
		$resultdata=$this->cust->get_notify_detail($id);
		$resultdata->notify_address=strip_tags($resultdata->notify_address);
		 
		echo json_encode($resultdata);
	}
}
?>