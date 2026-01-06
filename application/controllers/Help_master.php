<?php 
class Help_master extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	$this->load->library('image_lib');
	$this->load->model('Help_master_model','mode');
	$this->load->model('menu_model','menu');
	}
	
	public function index()
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $this->load->model('admin_company_detail');	
			
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/help_master',$data);
			 $this->form_validation->set_rules('module_name', 'module_name', 'trim|required|valid_module_name');
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
		 $aColumns = array('mst.help_id','mst.module_name','action_textbox','description','yellow_tips','file_upload','youtube_link','field1','field2','(SELECT count(*) FROM `tbl_help_master`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "tbl_help_master as mst";
		 $isJOIN = array();
		 $hOrder = "status asc,mst.module_name asc";
		 
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {				
														
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->module_name;
				 	
					//image fetch
					
					if($row->file_upload != "No file")
					{
						$row_data[] = !empty($row->file_upload)?'<a href="'.base_url().'upload/help_file/'.$row->file_upload.'" data-fancybox="gallery" class="gallery" data-caption="'.$row->module_name.'">
							<img src="'.base_url().'upload/help_file/'.$row->file_upload.'" heigth="50px" width="50px" link/>
						</a>':'';
						
					}
					else 
					{
						$row_data[] = "";
						
					}
					
					
					$row_data[] = $row->youtube_link;
					
					$actionbtn = '';
					$archivebtn = '';
				 	$delete_btn = '';
					$viewbtn ='';
					$downloadbtn = '';
					$deleteimagebtn = '';
					
					
					if($row->status==0)
					{
						$archivebtn = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->help_id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
						if($row->file_upload != "No file")
						{
						 $viewbtn = '<li> 
										<a class="tooltips" name="design_file_view1" id="design_file_view1"  data-toggle="tooltip"  data-title="view" 
								href="'.base_url().'upload/help_file/'.$row->file_upload.'" target="_blank"><i class="fa fa-eye"></i> View</a> 
									 </li>';
						}
						// 
						
						else
						{
							$viewbtn = "";
						}
						
						if($row->file_upload != "No file")
						{
						$downloadbtn = '<li> 
										<a class="tooltips"   data-toggle="tooltip" data-title="Download" 
										href="'.base_url().'Help_master/download/'.$row->file_upload.'" ><i class="fa fa-download"></i> Download</a>
									 </li>';
						}
					
						else
						{
							$downloadbtn = '';
						}
					
						if($row->file_upload != "No file")
						{
						$deleteimagebtn = '<li> 
										<a class="tooltips" name="shipping_file_delete" id="shipping_file_delete" data-toggle="tooltip" data-title="Delete Image" 
										onclick="delete_image('.$row->help_id.')" href="javascript:;"><i class="fa fa-trash"></i> Delete Image/File</a>
									 </li>';
						}	
						else
						{
							$deleteimagebtn  = '';
						}
						
						if($row->total_cnt>=1)
						{
							$delete_btn = ' <li>
										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->help_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li>';
									 
									 
						}
											
						 $actionbtn = '<li> 
										<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->help_id.');"><i class="fa fa-pencil"></i> Edit</a>
									 </li>
									'.$actionbtn	;
						
						}	
					else
					{
						$archivebtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->help_id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
					
					
			
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$viewbtn .'
											'.$downloadbtn.'
											'.$archivebtn.'
											'.$deleteimagebtn .'
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
	
	public function download($file_upload = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('./upload/help_file/'.$file_upload));
		force_download(file_upload);
	}
	
	public function manage()
		{
			$id =  $this->input->post('eid');
			
			if(!empty($id))
			{
					$check_box_design = $this->mode->check_doc_update($this->input->post('edit_module_name'));
								
					if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_module_name'))
					{
						
						$data = array
						(
						
							'module_name' 				=> $this->input->post('edit_module_name'),
							'action_textbox' 			=> $this->input->post('edit_action_textbox'),
																			   
							'description' 				=> $this->input->post('edit_description'),
							'yellow_tips'				=> $this->input->post('edit_yellow_tips'),
																			  
							'youtube_link'				=> $this->input->post('edit_youtube_link'),
							'field1'					=> $this->input->post('edit_ff1'),
							'field2' 					=> $this->input->post('edit_ff2'),
							'status'   	   	=> 0
						);
						
						$id = $this->input->post('eid');
						
						if($_FILES['edit_file_upload']['name'] != "" )	
						{
							$resultdata=$this->mode->fetchmodeldata($id);
							unlink('upload/help_file/'.$resultdata->file_upload);
							$this->load->library('upload');
							$extension = explode(".", $_FILES['edit_file_upload']['name']);
							$this->upload->initialize($this->set_upload_options($extension[0].''.$file_upload,$_FILES['edit_file_upload']['name']));
							$this->upload->do_upload('edit_file_upload');
							$upload_image = $this->upload->data();
							$data['file_upload']  = $upload_image['file_name'];
							
						}
						
						$updatedid = $this->mode->updatedata($data,$id);
						 if($updatedid)
						{
							 $row['id'] =  $id;
							 $row['module_name'] = $this->input->post('edit_module_name');
							
							 $row['res'] = 1;
							
						}
						else
						{
							$row['id'] =0;
							 $row['module_name'] =0;
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
				$check_box_design = $this->mode->check_doc_update($this->input->post('module_name'));
				// $date = '';
				// if(!empty($this->input->post('erdate'))){
					// $date = date('Y-m-d',strtotime($this->input->post('erdate')));
				// }
				if(empty($check_box_design))
				{
					$data = array
					(
																
							'module_name' 				=> $this->input->post('module_name'),
							'action_textbox' 			=> $this->input->post('action_textbox'),
							
							'description' 				=> $this->input->post('description'),
							'yellow_tips'				=> $this->input->post('ff1'),
							
							'youtube_link'				=> $this->input->post('youtube_link'),
							'field1'					=> $this->input->post('ff1'),
							'field2' 					=> $this->input->post('ff2'),
							'status'   	   	=> 0
					);
					
					if($_FILES['file_upload']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['file_upload']['name']);
						$this->upload->initialize($this->set_upload_options('document_',$_FILES['file_upload']['name']));
						$this->upload->do_upload('file_upload');
						$upload_image = $this->upload->data();
						$data['file_upload']  = $upload_image['file_name'];
					
					}
					else{
						$data['file_upload']  = 'No file';
					}
					
					
					$insertid = $this->mode->help_insert($data);
			 
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
		
	private function set_upload_options($newfilename,$filename)
	{   
		$this->load->library('image_lib');
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 		= $newfilename.'_'.rand(0,9999).'.'.$extension;
		$config['upload_path'] 		= './upload/help_file/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf|jfif';
		$config['max_size']      	= '8000';
		$config['overwrite']     	= FALSE;
		// $config = array(
			// 'image_library' => 'gd2',
			// 'quality' => '100%',
			// 'source_image' => './upload/shipping_logo/',
			// 'new_image' => './upload/shipping_logo/demo/',
			// 'maintain_ratio' => true,
			// 'create_thumb' => false,
			// 'width' => 50,
			// 'height' => 50
		// );              
		// $this->image_lib->initialize($config);              
		// $this->image_lib->resize();

		return $config;
	}
	
	public function fetchhelpdata()
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
		unlink('upload/help_file/'.$resultdata->file_upload);
		
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
	
	public function delete_image()
	{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchdocumentdata($id);
		unlink('upload/help_file/'.$resultdata->file_upload);
		
		$data['file_upload']  = 'No file';
				  
		 $updatedid = $this->mode->deleteimage($data,$id);
		 
		if($updatedid)
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