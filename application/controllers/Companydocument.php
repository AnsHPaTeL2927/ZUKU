<?php 
class Companydocument extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
 	 /*load Model*/
	
	$this->load->model('Companydocument_model','mode');
	$this->load->model('menu_model','menu');
	}
	
	public function index()
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $this->load->model('admin_company_detail');	
			 $data['no']	= $this->mode->getno();
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/cdocument',$data);
		}
		else
		{
			redirect(base_url().'');
		}	
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
		 $aColumns = array('mst.cmp_doc_setup_id','mst.document_name','file_type','document_details','important_document','renew_reminder','order_no','is_active','(SELECT count(*) FROM `tbl_company_document_setup`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "tbl_company_document_setup as mst";
		 $isJOIN = array();
		 $hOrder = "status asc, mst.order_no asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {
				
				// for change radiobutton value while fetch data
					$rdbutton = $row->file_type;
					if($row->file_type == '1')
					{
						$row->file_type = 'Single';
					}
					else if($row->file_type == '2')
					{
						$row->file_type = 'Multiple';
					}
					
					// For condition of date if it's empty
					$date = $row->renew_date;
					if(!($row->renew_date) == '0000-00-00' || $row->renew_date == '1970-01-01')
					{
						$row->renew_date = date('d/m/Y',strtotime($row->renew_date));
					}
					else if($row->renew_date == '0000-00-00' || $row->renew_date == '1970-01-01')
					{
						$row->renew_date = '-';
					}
					else{
						$row->renew_date = date('d/m/Y',strtotime($row->renew_date));
					}
														
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->document_name;
				 	$row_data[] = $row->file_type;
					$row_data[] = $row->document_details;
					
					$actionbtn = '';
				 	$delete_btn = '';
					if($row->status==0)
					{
						$actionbtn = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->cmp_doc_setup_id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
						
						if($row->total_cnt>=1)
						{
							$delete_btn = ' <li>
										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->cmp_doc_setup_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li> ';
									 
						
						}
											
						 $actionbtn = '<li> 
										<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->cmp_doc_setup_id.');"><i class="fa fa-pencil"></i> Edit</a>
									 </li>
									'.$actionbtn	;
					
					
						
		
					}	
					else
					{
						$actionbtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->cmp_doc_setup_id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
					
			
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
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
				
				$check_box_design = $this->mode->check_doc_update($this->input->post('edit_dname'));
				
				if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_dname'))
				{
					$data = array
					(
							'document_name' 		=> $this->input->post('edit_dname'),
							'file_type' 			=> $this->input->post('edit_radiofiles'),
							'document_details' 		=> $this->input->post('edit_details'),
							'important_document' 	=> $this->input->post('edit_impdocument'),
							//'renew_date' 			=> $date,
							'renew_reminder'		=> $this->input->post('edit_renewbutton'),
							// 'reminder_days' 		=> $this->input->post('edit_dayreminder'),
							 'order_no' 				=> $this->input->post('edit_ornumber'),
							'is_active'				=> $this->input->post('edit_isactive')
					);
					
					$insertid = $this->mode->doc_update($data,$id);
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
					$row['editdocumentmode'] = $this->input->post('editdocumentmode');
				}
			}
			else 
			{
				$check_box_design = $this->mode->check_doc_update($this->input->post('dname'));
				// $date = '';
				// if(!empty($this->input->post('erdate'))){
					// $date = date('Y-m-d',strtotime($this->input->post('erdate')));
				// }
				if(empty($check_box_design))
				{
					$data = array
					(
							'document_name' 		=> $this->input->post('dname'),
							'file_type' 			=> $this->input->post('radiofiles'),
							'document_details' 		=> $this->input->post('details'),
							'important_document' 	=> $this->input->post('impdocument'),
							//'renew_date' 			=> $date,
							'renew_reminder'		=> $this->input->post('renewbutton'),
							//'reminder_days' 		=> $this->input->post('dayreminder'),
							'order_no' 				=> $this->input->post('ornumber'),
							'is_active'				=> $this->input->post('isactive'),
								'status'   	   	=> 0
					);
					
					$insertid = $this->mode->doc_insert($data);
			 
					$row = array();
					if($insertid)
					{
						$row['res'] = 1;
						// $row['cmp_doc_setup_id'] = $insertid;
						// $row['document_name'] = $this->input->post('dname');
					}
					else
					{
						$row['res'] = 0;
					}
				}
				else
				{
						 $row['res'] = 2;
						//$row['cmp_doc_setup_id'] = $check_docname->cmp_doc_setup_id;
						 // $row['document_name'] = $this->input->post('dname');
						  // $row['order_no'] = $this->input->post('ornumber');
				}
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
		$deleteid=$this->mode->doc_delete($id);
		
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
				 
				$resultdata=$this->mode->doc_party($id);
			 	$resultdata->renew_date = date('d-m-Y',strtotime($resultdata->renew_date));
				echo json_encode($resultdata);
			}
}

?>