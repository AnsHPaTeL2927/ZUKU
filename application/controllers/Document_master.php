<?php 
class Document_master extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	$this->load->library('image_lib');
	$this->load->model('Document_master_model','mode');
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
			 $this->load->view('admin/document_master',$data);
			 $this->form_validation->set_rules('label_name', 'label_name', 'trim|required|valid_label_name');
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
		 $aColumns = array('mst.document_master_id','mst.label_name','file_type','upload_option','remarks','order_no','is_active','(SELECT count(*) FROM `tbl_document_master`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "tbl_document_master as mst";
		 $isJOIN = array();
		 $hOrder = "is_active asc,status asc,mst.order_no asc";
		 
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {	

					$rdbutton = $row->file_type;
					
					if($row->file_type == '1')
					{
						$row->file_type = 'Single';
					}
					else if($row->file_type == '2')
					{
						$row->file_type = 'Multiple';
					}
					
					
					
					$rdbutton = $row->upload_option;
					
					if($row->upload_option == '1')
					{
						$row->upload_option = 'Image';
					}
					else if($row->upload_option == '2')
					{
						$row->upload_option = 'Video';
					}
					else
					{
						$row->upload_option = 'Document';
					}
															
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->label_name;
					$row_data[] = $row->file_type;
				 	$row_data[] = $row->upload_option;
				 					
					$row_data[] = $row->is_active;
					
					$actionbtn = '';
					$archivebtn = '';
				 	$delete_btn = '';
										
									
					if($row->status==0)
					{
						$archivebtn = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->document_master_id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
						$actionbtn = '<li> 
								 	<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->document_master_id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								'.$actionbtn;
						
						if($row->total_cnt>=1)
						{
							$delete_btn = ' <li>
										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->document_master_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li>';
									 
									 
						}
		
					}	
					else
					{
						$archivebtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->document_master_id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
					
					
										
					
					
					
			
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											
											'.$archivebtn.'
										
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
	
	public function download($document_upload = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('./upload/document_master/'.$document_upload));
		force_download($document_upload, $data);
	}
	
	public function manage()
	{
		$id =  $this->input->post('eid');
		
		if(!empty($id))
		{
				$check_box_design = $this->mode->check_doc_update($this->input->post('edit_label_name'));
							
				if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_label_name'))
				{
					$ornumber = $this->input->post('edit_ornumber');
					if($ornumber == $this->input->post('edit_ornumber'));
					{
						$ornumber;
					}
					
					$data = array
					(
					
						 'label_name' 						=> $this->input->post('edit_label_name'),
						 'file_type' 						=> $this->input->post('edit_radiofiles'), 
						 'upload_option' 					=> $this->input->post('edit_radiofiles1'),
						 'remarks' 							=> $this->input->post('edit_remarks'),
						 'is_active'						=> $this->input->post('edit_isactive'),
						 'order_no' 						=> $ornumber,
						 'status'   	   					=> 0
					);
					
					$id = $this->input->post('eid');				
					
					$updatedid = $this->mode->updatedata($data,$id);
					 if($updatedid)
					{
						 $row['id'] =  $id;
						
						 $update_previous_order 	 = $this->mode->updateprivious_data($ornumber,$id);
						 $row['res'] = 1;
						
					}
					else
					{
						$row['id'] =0;
						 $row['label_name'] =0;
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
			$check_box_design = $this->mode->check_doc_update($this->input->post('label_name'));
			$ornumber = $this->input->post('ornumber');
				if($ornumber == $this->input->post('ornumber'));
				{
					$ornumber;
				}
			if(empty($check_box_design))
			{
				$data = array
				(
															
						 'label_name' 						=> $this->input->post('label_name'),
						 'file_type' 						=> $this->input->post('radiofiles'),
						 'upload_option' 					=> $this->input->post('radiofiles1'),
						 'remarks' 							=> $this->input->post('remarks'),
						 'is_active'						=> $this->input->post('isactive'),
						 'order_no' 						=> $ornumber,
						 'status'   	   					=> 0
				);
							
				$insertid = $this->mode->document_insert($data);
		 
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

	public function fetchshippingdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchmodeldata($id);
				
		echo json_encode($resultdata);
	}
	
	public function archive_record()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$deleterecord = $this->mode->archive_record($id,$status);
		
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
		$resultdata=$this->mode->fetchdocumentdata($id);
				
		$deleteid=$this->mode->deleterecord($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
		
}
?>