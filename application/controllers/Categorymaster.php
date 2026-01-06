<?php 
class Categorymaster extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	$this->load->library('image_lib');
	$this->load->model('Categorymaster_model','mode');
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
			 $data['finishdata']	 	= $this->mode->getfinishdata();	
			 $this->load->view('admin/categorymaster',$data);
			 $this->form_validation->set_rules('category_name', 'category_name', 'trim|required|valid_shipping_name');
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
		 $aColumns = array('mst.cat_id','mst.category_name','category_desc','color_code','front_page','back_page','free_field_1','free_field_2','is_active','set_default','order_no','(SELECT count(*) FROM `tbl_category_master`) as total_cnt','mst.status','(select group_concat(finish_name) from tbl_finish as finish where find_in_set(finish.finish_id,mst.finish_id) and status = 0) as finish_name');
		 $isWhere = array($where);
		 $table = "tbl_category_master as mst";
		 $isJOIN = array();
		 $hOrder = "mst.order_no asc";
		 
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {				
														
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->category_name;
				 	$row_data[] = $row->category_desc;
					$row_data[] = $row->finish_name;
					
					//image fetch front
					if($row->front_page != "No file")
					{
						$row_data[] = !empty($row->front_page)?'<a href="'.base_url().'upload/Category_image/front_page/'.$row->front_page.'" data-fancybox="gallery" class="gallery" data-caption="'.$row->category_name.'">
							<img src="'.base_url().'upload/Category_image/front_page/'.$row->front_page.'" heigth="50px" width="50px" />
						</a>':'';
						
					}
					else 
					{
						$row_data[] = "";
						
					}

					//image fetch back
					if($row->back_page != "No file")
					{
						$row_data[] = !empty($row->back_page)?'<a href="'.base_url().'upload/Category_image/back_page/'.$row->back_page.'" data-fancybox="gallery" class="gallery" data-caption="'.$row->category_name.'">
							<img src="'.base_url().'upload/Category_image/back_page/'.$row->back_page.'" heigth="50px" width="50px" />
						</a>':'';
						
					}
					else 
					{
						$row_data[] = "";
						
					}
					
					
					$row_data[] = $row->set_default;
					$row_data[] = $row->is_active;
					
					$actionbtn = '';
					$archivebtn = '';
				 	$delete_btn = '';
					$viewbtn ='';
					$downloadbtn = '';
					$viewbtn1 ='';
					$downloadbtn1 = '';
					$deleteimagebtn = '';
					$deleteimagebtn1 = '';
					
					
					if($row->status==0)
					{
						$archivebtn = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->cat_id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
									
						//all action option as archive status 0 
						if($row->front_page != "No file")
						{
						 $viewbtn = '<li> 
										<a class="tooltips" name="front_file_view" id="front_file_view"  data-toggle="tooltip"  data-title="view" 
								href="'.base_url().'upload/Category_image/front_page/'.$row->front_page.'" target="_blank"><i class="fa fa-eye"></i> View Front Page</a> 
									 </li>';
						}
						else
						{
							$viewbtn = "";
						}
						
						if($row->front_page != "No file")
						{
						$downloadbtn = '<li> 
										<a class="tooltips"   data-toggle="tooltip" data-title="Download" 
										href="'.base_url().'Categorymaster/download/'.$row->front_page.'" ><i class="fa fa-download"></i> Download Front Page</a>
									 </li>';
						}
					
						else
						{
							$downloadbtn = '';
						}
						
						//back page image
						if($row->back_page != "No file")
						{
						 $viewbtn1 = '<li> 
										<a class="tooltips" name="back_file_view" id="back_file_view"  data-toggle="tooltip"  data-title="view" 
								href="'.base_url().'upload/Category_image/back_page/'.$row->back_page.'" target="_blank"><i class="fa fa-eye"></i> View Back Page</a> 
									 </li>';
						}
						else
						{
							$viewbtn1 = "";
						}
						
						if($row->back_page != "No file")
						{
						$downloadbtn1 = '<li> 
										<a class="tooltips"   data-toggle="tooltip" data-title="Download" 
										href="'.base_url().'Categorymaster/download1/'.$row->back_page.'" ><i class="fa fa-download"></i> Download Back Page</a>
									 </li>';
						}
					
						else
						{
							$downloadbtn1 = '';
						}
					
						if($row->front_page != "No file")
						{
						$deleteimagebtn = '<li> 
										<a class="tooltips" name="category_frontimg_delete" id="category_frontimg_delete" data-toggle="tooltip" data-title="Delete FrontPage Image" 
										onclick="delete_image('.$row->cat_id.')" href="javascript:;"><i class="fa fa-trash"></i> Delete FrontPage Image</a>
									 </li>';
						}	
						else
						{
							$deleteimagebtn  = '';
						}	
						
						if($row->back_page != "No file")
						{
						$deleteimagebtn1 = '<li> 
										<a class="tooltips" name="category_backimg_delete" id="category_backimg_delete" data-toggle="tooltip" data-title="Delete BackPage Image" 
										onclick="delete_image1('.$row->cat_id.')" href="javascript:;"><i class="fa fa-trash"></i> Delete BackPage Image</a>
									 </li>';
						}	
						else
						{
							$deleteimagebtn1  = '';
						}
						
						if($row->total_cnt>=1)
						{
							$delete_btn = ' <li>
										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->cat_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li>';
									 
									 
						}
											
						 $actionbtn = '<li> 
										<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->cat_id.');"><i class="fa fa-pencil"></i> Edit</a>
									 </li>
									'.$actionbtn	;
					
					
					}	
					else
					{
						$archivebtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->cat_id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
					
					
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$viewbtn .'
											'.$viewbtn1 .'
											'.$downloadbtn.'
											'.$downloadbtn1.'
											'.$archivebtn.'
											'.$deleteimagebtn .'
											'.$deleteimagebtn1 .'
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
	
	public function download($front_page = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('./upload/Category_image/front_page/'.$front_page));
		force_download($front_page, $data);
	}
	
	public function download1($back_page = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('./upload/Category_image/back_page/'.$back_page));
		force_download($back_page, $data);
	}
	
	public function manage()
		{
			$id =  $this->input->post('eid');
			
			if(!empty($id))
			{
					$check_box_design = $this->mode->check_doc_update($this->input->post('edit_category_name'));
								
					if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_category_name'))
					{
						$ornumber = $this->input->post('edit_ornumber');
						if($ornumber == $this->input->post('edit_ornumber'));
						{
							$ornumber;
						}
						$finish_name = implode(",",$this->input->post('edit_finish_id'));
						
						$data = array
						(
						
							 'category_name' 					=> $this->input->post('edit_category_name'),
							 'category_desc' 					=> $this->input->post('edit_category_desc'),
							 'finish_id' 						=> $finish_name,														  
							 'color_code' 						=> $this->input->post('edit_color_code'),
							 'free_field_1'						=> $this->input->post('free_field_1'),
							 'free_field_2'						=> $this->input->post('free_field_2'),
							
							 'set_default'						=> $this->input->post('edit_setdefault'),
							 'is_active'						=> $this->input->post('edit_isactive'),
							 'order_no' 						=> $ornumber,
							 'status'   	   					=> 0
						
						);
						
						$id = $this->input->post('eid');
						
						if($_FILES['edit_front_page']['name'] != "" )	
						{
							$resultdata=$this->mode->fetchmodeldata($id);
							unlink('upload/Category_image/front_page/'.$resultdata->front_page);
							$this->load->library('upload');
							$extension = explode(".", $_FILES['edit_front_page']['name']);
							$this->upload->initialize($this->set_upload_options($extension[0].''.$front_page,$_FILES['edit_front_page']['name']));
							$this->upload->do_upload('edit_front_page');
							$upload_image = $this->upload->data();
							$data['front_page']  = $upload_image['file_name'];
						
						}
						
						if($_FILES['edit_back_page']['name'] != "" )	
						{
							$resultdata=$this->mode->fetchmodeldata($id);
							unlink('upload/Category_image/back_page/'.$resultdata->back_page);
							$this->load->library('upload');
							$extension = explode(".", $_FILES['edit_back_page']['name']);
							$this->upload->initialize($this->set_upload_options1($extension[0].''.$back_page,$_FILES['edit_back_page']['name']));
							$this->upload->do_upload('edit_back_page');
							$upload_image = $this->upload->data();
							$data['back_page']  = $upload_image['file_name'];
						
						}
						
						
						$updatedid = $this->mode->updatedata($data,$id);
						 if($updatedid)
						{
							 $row['id'] =  $id;
							 $row['category_name'] = $this->input->post('edit_category_name');
							 $update_previous_order 	 = $this->mode->updateprivious_data($ornumber,$id);
							 $row['res'] = 1;
							
						}
						else
						{
							$row['id'] =0;
							 $row['category_name'] =0;
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
				$check_box_design = $this->mode->check_doc_update($this->input->post('category_name'));
				
				if(empty($check_box_design))
				{
					$finish_name = implode(",",$this->input->post('finish_id'));
					$data = array
					(
																
							'category_name' 					=> $this->input->post('category_name'),
							'category_desc' 					=> $this->input->post('category_desc'),
							'finish_id' 						=> $finish_name,
							'color_code' 						=> $this->input->post('color_code'),
							'free_field_1'						=> $this->input->post('free_field_1'),
							'free_field_2'						=> $this->input->post('free_field_1'),
							
							'set_default'						=> $this->input->post('setdefault'),
							'is_active'							=> $this->input->post('isactive'),
							'order_no' 							=> $this->input->post('ornumber'),
							'status'   	   	=> 0
					);
					
					if($_FILES['front_page']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['front_page']['name']);
						$this->upload->initialize($this->set_upload_options('document_',$_FILES['front_page']['name']));
						$this->upload->do_upload('front_page');
						$upload_image = $this->upload->data();
						$data['front_page']  = $upload_image['file_name'];
					
					}
					else{
						$data['front_page']  = 'No file';
					}
					
					if($_FILES['back_page']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['back_page']['name']);
						$this->upload->initialize($this->set_upload_options1('document_',$_FILES['back_page']['name']));
						$this->upload->do_upload('back_page');
						$upload_image = $this->upload->data();
						$data['back_page']  = $upload_image['file_name'];
					
					}
					else{
						$data['back_page']  = 'No file';
					}
					
					
					$insertid = $this->mode->category_insert($data);
			 
					$row = array();
					if($insertid)
					{
						$row['res'] = 1;
						$row['id'] = $insertid;
						$row['category_name'] = $this->input->post('category_name');
						
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
		
		$data = array
			(
			
				 'category_name' 				=> $this->input->post('edit_category_name'),
				 'shipping_line_details' 			=> $this->input->post('edit_shipping_detail'),
																		  
				 'remarks' 							=> $this->input->post('edit_remarks'),
				 'free_field_1'						=> $this->input->post('edit_ff1'),
				 'free_field_2'						=> $this->input->post('edit_ff2'),
				 'free_field_3'						=> $this->input->post('edit_ff3'),
				 'is_active'						=> $this->input->post('edit_isactive'),
				 'order_no' 						=> $this->input->post('edit_ornumber'),
				 'status'   	   					=> 0
			);
			
			$id = $this->input->post('eid');
					
					if($_FILES['edit_upload_logo']['name'] != "" )	
					{
						$resultdata=$this->mode->fetchmodeldata($id);
						unlink('upload/shipping_logo/'.$resultdata->shipping_logo);
						$this->load->library('upload');
						$extension = explode(".", $_FILES['edit_upload_logo']['name']);
						$this->upload->initialize($this->set_upload_options($extension[0].''.$shipping_logo,$_FILES['edit_upload_logo']['name']));
						$this->upload->do_upload('edit_upload_logo');
						$upload_image = $this->upload->data();
						$data['shipping_logo']  = $upload_image['file_name'];
					
					}
					
			
			$updatedid = $this->mode->updatedata($data,$id);
			 if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['category_name'] = $this->input->post('edit_category_name');
					 
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['category_name'] =0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
	}
		
	public function fetchshippingdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchmodeldata($id);
				
		echo json_encode($resultdata);
	}
		
	private function set_upload_options($newfilename,$filename)
	{   
		$this->load->library('image_lib');
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 		= $newfilename.'_'.rand(0,9999).'.'.$extension;
		$config['upload_path'] 		= './upload/Category_image/front_page/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf|jfif';
		$config['max_size']      	= '8000';
		$config['overwrite']     	= FALSE;
		

		return $config;
	}
	
	private function set_upload_options1($newfilename,$filename)
	{   
		$this->load->library('image_lib');
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 		= $newfilename.'_'.rand(0,9999).'.'.$extension;
		$config['upload_path'] 		= './upload/Category_image/back_page/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf|jfif';
		$config['max_size']      	= '8000';
		$config['overwrite']     	= FALSE;
		

		return $config;
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
		unlink('upload/shipping_logo/'.$resultdata->shipping_logo);
		
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
		unlink('upload/Category_image/front_page/'.$resultdata->front_page);
		
		$data['front_page']  = 'No file';
				  
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
	
	public function delete_image1()
	{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchdocumentdata($id);
		unlink('upload/Category_image/back_page/'.$resultdata->back_page);
		
		$data['back_page']  = 'No file';
				  
		 $updatedid = $this->mode->deleteimage1($data,$id);
		 
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
