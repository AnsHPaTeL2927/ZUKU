<?php 
class Shippingmaster extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	$this->load->library('image_lib');
	$this->load->model('Shippingmaster_model','mode');
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
			 $this->load->view('admin/shippingmaster',$data);
			 $this->form_validation->set_rules('shipping_name', 'shipping_name', 'trim|required|valid_shipping_name');
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
		 $aColumns = array('mst.shipping_id','mst.shipping_line_name','shipping_line_details','shipping_logo','remarks','free_field_1','free_field_2','free_field_3','is_active','order_no','(SELECT count(*) FROM `tbl_shipping_line_master`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "tbl_shipping_line_master as mst";
		 $isJOIN = array();
		 $hOrder = "is_active asc,status asc,mst.order_no asc";
		 
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {				
														
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->shipping_line_name;
				 	$row_data[] = $row->shipping_line_details;
					
					//image fetch
					if($row->shipping_logo != "No file")
					{
						$row_data[] = !empty($row->shipping_logo)?'<a href="'.base_url().'upload/shipping_logo/'.$row->shipping_logo.'" data-fancybox="gallery" class="gallery" data-caption="'.$row->shipping_line_name.'">
							<img src="'.base_url().'upload/shipping_logo/'.$row->shipping_logo.'" heigth="50px" width="50px" />
						</a>':'';
						
					}
					else 
					{
						$row_data[] = "";
						
					}
					
					
					$row_data[] = $row->is_active;
					
					$actionbtn = '';
					$archivebtn = '';
				 	$delete_btn = '';
					$viewbtn ='';
					$downloadbtn = '';
					$deleteimagebtn = '';
					
					
					if($row->status==0)
					{
						$archivebtn = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->shipping_id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
									
						//all action option as archive status 0 
						if($row->shipping_logo != "No file")
						{
						 $viewbtn = '<li> 
										<a class="tooltips" name="design_file_view" id="design_file_view"  data-toggle="tooltip"  data-title="view" 
								href="'.base_url().'upload/shipping_logo/'.$row->shipping_logo.'" target="_blank"><i class="fa fa-eye"></i> View</a> 
									 </li>';
						}
						else
						{
							$viewbtn = "";
						}
						
						if($row->shipping_logo != "No file")
						{
						$downloadbtn = '<li> 
										<a class="tooltips"   data-toggle="tooltip" data-title="Download" 
										href="'.base_url().'Shippingmaster/download/'.$row->shipping_logo.'" ><i class="fa fa-download"></i> Download</a>
									 </li>';
						}
					
						else
						{
							$downloadbtn = '';
						}
					
						if($row->shipping_logo != "No file")
						{
						$deleteimagebtn = '<li> 
										<a class="tooltips" name="shipping_file_delete" id="shipping_file_delete" data-toggle="tooltip" data-title="Delete Image" 
										onclick="delete_image('.$row->shipping_id.')" href="javascript:;"><i class="fa fa-trash"></i> Delete Image/File</a>
									 </li>';
						}	
						else
						{
							$deleteimagebtn  = '';
						}
						
						if($row->total_cnt>=1)
						{
							$delete_btn = ' <li>
										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->shipping_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li>';
									 
									 
						}
											
						 $actionbtn = '<li> 
										<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->shipping_id.');"><i class="fa fa-pencil"></i> Edit</a>
									 </li>
									'.$actionbtn	;
					
					
					}	
					else
					{
						$archivebtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->shipping_id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
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
	
	public function download($shipping_logo = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('./upload/shipping_logo/'.$shipping_logo));
		force_download($shipping_logo, $data);
	}
	
	public function manage()
		{
			$id =  $this->input->post('eid');
			
			if(!empty($id))
			{
					$check_box_design = $this->mode->check_doc_update($this->input->post('edit_shipping_name'));
								
					if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_shipping_name'))
					{
						$ornumber = $this->input->post('edit_ornumber');
						if($ornumber == $this->input->post('edit_ornumber'));
						{
							$ornumber;
						}
						
						$data = array
						(
						
							 'shipping_line_name' 				=> $this->input->post('edit_shipping_name'),
							 'shipping_line_details' 			=> $this->input->post('edit_shipping_detail'),
																					  
							 'remarks' 							=> $this->input->post('edit_remarks'),
							 'free_field_1'						=> $this->input->post('edit_ff1'),
							 'free_field_2'						=> $this->input->post('edit_ff2'),
							 'free_field_3'						=> $this->input->post('edit_ff3'),
							 'is_active'						=> $this->input->post('edit_isactive'),
							 'order_no' 						=> $ornumber,
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
							 $row['shipping_line_name'] = $this->input->post('edit_shipping_name');
							 $update_previous_order 	 = $this->mode->updateprivious_data($ornumber,$id);
							 $row['res'] = 1;
							
						}
						else
						{
							$row['id'] =0;
							 $row['shipping_line_name'] =0;
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
				$check_box_design = $this->mode->check_doc_update($this->input->post('shipping_name'));
				
				if(empty($check_box_design))
				{
					$data = array
					(
																
							'shipping_line_name' 				=> $this->input->post('shipping_name'),
							'shipping_line_details' 			=> $this->input->post('shipping_detail'),
							
							'remarks' 							=> $this->input->post('remarks'),
							'free_field_1'						=> $this->input->post('ff1'),
							'free_field_2'						=> $this->input->post('ff2'),
							'free_field_3'						=> $this->input->post('ff3'),
							'is_active'							=> $this->input->post('isactive'),
							'order_no' 							=> $this->input->post('ornumber'),
							'status'   	   	=> 0
					);
					
					if($_FILES['upload_logo']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['upload_logo']['name']);
						$this->upload->initialize($this->set_upload_options('document_',$_FILES['upload_logo']['name']));
						$this->upload->do_upload('upload_logo');
						$upload_image = $this->upload->data();
						$data['shipping_logo']  = $upload_image['file_name'];
					
					}
					else{
						$data['shipping_logo']  = 'No file';
					}
					
					
					$insertid = $this->mode->shipping_insert($data);
			 
					$row = array();
					if($insertid)
					{
						$row['res'] = 1;
						$row['id'] = $insertid;
						$row['shipping_line_name'] = $this->input->post('shipping_name');
						
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
			
				 'shipping_line_name' 				=> $this->input->post('edit_shipping_name'),
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
				 $row['shipping_line_name'] = $this->input->post('edit_shipping_name');
					 
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['shipping_line_name'] =0;
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
		$config['upload_path'] 		= './upload/shipping_logo/';
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
		unlink('upload/shipping_logo/'.$resultdata->shipping_logo);
		
		$data['shipping_logo']  = 'No file';
				  
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
