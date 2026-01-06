<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Payment_terms extends CI_controller
{
	
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	$this->load->model('Payment_terms_model','mode');
	$this->load->model('menu_model','menu');
	}
	
	public function index()
    {    
		
		 $data['no']	= $this->mode->getno();
		 $this->load->model('admin_company_detail');	
		 $data['company_detail'] = $this->admin_company_detail->s_select();	
		 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
		 $this->load->view('admin/payment_terms',$data);
		
    }
	
	public function fetch_record()
	{
		 $status = $this->input->get('status');
		 
		 if($status == 2)
		 {
			 $where = ' mst.status = 0';
		 }
		 else  if($status == 1)
		 {
			 $where = ' mst.status = 2';
		 }
		 //$where = '';
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.id','mst.payment_terms','is_active','order_no','(SELECT count(*) FROM `tbl_payment_terms`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "tbl_payment_terms as mst";
		 $isJOIN = array();
		 $hOrder = "is_active asc,status asc,mst.order_no asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {
														
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->payment_terms;
					$row_data[] = $row->is_active;
					$row_data[] = $row->order_no;
					
					$actionbtn = '';
				 	$delete_btn = '';
					$archive = '';
					
					if($row->status==0)
					{
						$archive = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
						
		
					}	
					else
					{
						$archive = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
					if($row->total_cnt>=1)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
								 
					
					}
										
					 $actionbtn = '<li> 
								 	<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								'.$actionbtn	;
					
					
			
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$archive.'
											'.$delete_btn .'
											
											
									</ul>
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
				
				$check_box_design = $this->mode->check_payment_terms_update($this->input->post('edit_payment_terms'));
				
				if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_payment_terms'))
				{
					$ornumber = $this->input->post('edit_ornumber');
						if($ornumber == $this->input->post('edit_ornumber'));
						{
							$ornumber;
						}
						
					$data = array
					(
							'payment_terms' 		=> $this->input->post('edit_payment_terms'),
							'is_active'				=> $this->input->post('edit_isactive'),
							'order_no' 				=> $ornumber,
							'status'				=> 0
							
					);
					
					$insertid = $this->mode->payment_terms_update($data,$id);
					// $row = array();
					if($insertid)
					{
						$row['id'] =  $id;
						$row['payment_terms'] = $this->input->post('edit_payment_terms');
						$update_previous_order 	 = $this->mode->updateprivious_data($ornumber,$id);
						$row['res'] = 1;
						
					}
					else
					{
						$row['id'] =0;
						$row['payment_terms'] =0;
						$row['res'] = 0;
					}
			}
			else
			{
				$row['res'] = 2;
				$row['editdocumentmode'] = $this->input->post('editdocumentmode');
			}
			}
			else 
			{
				$check_box_design = $this->mode->check_payment_terms_update($this->input->post('payment_terms'));
				
				if(empty($check_box_design))
				{
					$data = array
					(
							'payment_terms' 		=> $this->input->post('payment_terms'),
							'is_active'				=> $this->input->post('isactive'),
							'order_no' 				=> $this->input->post('ornumber'),
							'status'   	   	=> 0
					);
					
					$insertid = $this->mode->payment_terms_insert($data);
			 
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
		
	public function edit_record()
	{		
		$data = array(
			
			 'payment_terms'	 	=> $this->input->post('edit_payment_terms'),
			
			 'is_active' 			=> $this->input->post('edit_isactive'),
			 'order_no' 			=> $this->input->post('edit_ornumber'),
			 'status' 				=> 0 
		 );
		 
			$id = $this->input->post('eid');
			
			$updatedid = $this->mode->updatedata($data,$id);
			 if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['payment_terms'] = $this->input->post('edit_payment_terms');
					 
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['payment_terms'] =0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
	}
		
		public function archive_record()
		{
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			$deleterecord = $this->mode->archive_record($id,$status	);	
				if($deleterecord)
				{
					$row['res'] = '1';
				}
				else{
					$row['res'] = '0';
				}
				echo json_encode($row);
	
		}
		
	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->mode->payment_terms_delete($id);
		
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function fetchdocumentdata()
	{
		$id=$this->input->post('id');
		 
		$resultdata=$this->mode->fetch_payment_terms_data($id);
	 	
		echo json_encode($resultdata);
	}
	
}

?>