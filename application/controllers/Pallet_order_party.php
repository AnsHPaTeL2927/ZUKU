<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Pallet_order_party extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Pallet_order_party_model','pallet');
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
			$data['cust_data']			= $this->pallet->bank_select(); 
			$data['company_detail']		= $this->admin_company_detail->s_select();	
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
		  	$this->load->view('admin/pallet_order_party',$data);	
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
		 $aColumns = array('mst.pallet_party_id','mst.party_name','party_gst_no','status','(SELECT count(*) FROM `tbl_pallet_order` where pallet_party_id = mst.pallet_party_id) as total_cnt','bank_id');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_pallet_party as mst";
		 $isJOIN = array();
		 $hOrder = "mst.pallet_party_id asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->party_name;
				 	$row_data[] = $row->party_gst_no;
				 	$delete_btn = '';
					if($row->total_cnt==0)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->pallet_party_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					}			 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->pallet_party_id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								'.$delete_btn;
								
					$bankdetailbtn = '<li>
									<a class="tooltips" data-title="Bank Details" id="bankmodal" data-toggle="modal" data-target="" onclick="bank_data('.$row->pallet_party_id.','.$row->bank_id.');"><i class="fa fa-bank"></i>Bank Details</a>
								</li>';
								
				
					$contactbtn = '<li>
										<a class="tooltips" data-title="Edit" href="'.base_url().'Pallet_contact_list/index/'.$row->pallet_party_id.'" ><i class="fa fa-plus"></i>Add Contact</a>
									</li>';
								
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$bankdetailbtn.'
											'.$contactbtn.'
											'.$delete_btn.'
											 
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
		$id =  $this->input->post('palletparty_id');
		
		if(!empty($id))
		{
			$check_partyname = $this->pallet->check_pallet_party($this->input->post('edit_party_name'));
			if(empty($check_partyname) || $this->input->post('editpalletmode') == $this->input->post('edit_party_name'))
			{
				$data = array(
						
						'party_name' 	=> $this->input->post('edit_party_name'),
						'party_address' => nl2br($this->input->post('edit_party_address')),
						'party_gst_no'  => $this->input->post('edit_party_gst_no'),
						'status' 	 	=> '0',
						'cdate' 	 	=> date('Y-m-d H:i:s')
					);
					$insertid = $this->pallet->pallet_update($data,$id);
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
				$row['editpalletmode'] = $this->input->post('editpalletmode');
			}
		}
		else 
		{
			$check_partyname = $this->pallet->check_pallet_party($this->input->post('party_name'));
			if(empty($check_partyname))
			{
				$data = array(
						'party_name' 	=> $this->input->post('party_name'),
						'party_address' => nl2br($this->input->post('party_address')),
						'party_gst_no'  => $this->input->post('party_gst_no'),
						'status' 	 	=> '0',
						'cdate' 	 	=> date('Y-m-d H:i:s')
					);
				
				// $data = array(
						// 'bank_id' 	=> $this->input->post('bank_id')
						
					// );
					
				$insertid = $this->pallet->pallet_insert($data);
				
		 
				$row = array();
				if($insertid)
				{
					$row['res'] = 1;
					//$row['pallet_party_id'] = $insertid;
					$row['party_name'] 	  = $this->input->post('party_name');
				}
				else
				{
					$row['res'] = 0;
				}
			}
			else
			{
					$row['res'] = 2;
					//$row['pallet_party_id'] = $check_partyname->pallet_party_id;
					$row['party_name'] 	  	= $this->input->post('party_name');
				
			}
		}
		echo json_encode($row);
 	}
	
 	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->pallet->pallet_delete($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchpalletorderdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->pallet->pallet_party($id);
		$resultdata->party_address = strip_tags($resultdata->party_address);
		echo json_encode($resultdata);
	}
	
}
?>