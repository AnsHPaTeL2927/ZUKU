<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Supplier_api extends CI_controller
{
	
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	
	/*load Model*/
	$this->load->model('Supplier_api_model','mode');
	$this->load->model('menu_model','menu');
	
	
	}
	
	public function index()
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 
			 $this->load->model('admin_company_detail');	
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/supplier_api',$data);
		}
		else
		{
			redirect(base_url().'');
		}	
    }
	
	public function fetch_record()
	{
		$where = '';
		$_SESSION['modal_filter_finish_id'] = '';
		if(!empty($this->input->get('countryid')))
		{
			$where .= ' find_in_set("'.$this->input->get('countryid').'",mst.c_name)'; 
			$_SESSION['modal_filter_finish_id'] = $this->input->get('countryid');
		}
		
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
		 $aColumns = array('mst.id','supplier_gstno','supplier_panno','supplier_iecno','supplier_name','supplier_contactno','supplier_companyname','supplier_address','upload_logo','is_active','mst.status','(SELECT count(*) FROM `tbl_supplier_api`) as total_cnt');
		 $isWhere = array($where);
		 $table = "tbl_supplier_api as mst";
		 $isJOIN = array();
		 $hOrder = "is_active asc,status asc,supplier_name asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
					foreach($sqlReturn['data'] as $row) {
			
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->supplier_name;
					$row_data[] = $row->supplier_companyname;
					//image fetch
					if($row->upload_logo != "No file")
					{
						$row_data[] = !empty($row->upload_logo)?'<a href="'.base_url().'upload/supplier_api/'.$row->upload_logo.'" data-fancybox="gallery" class="gallery" data-caption="'.$row->supplier_companyname.'">
							<img src="'.base_url().'upload/supplier_api/'.$row->upload_logo.'" heigth="50px" width="50px" />
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
										<a class="tooltips" data-toggle="tooltip" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
									
						if($row->total_cnt>=1)
						{
							$delete_btn = '<li>
										<a class="tooltips" data-toggle="tooltip" data-title="Delete"  onclick="delete_record('.$row->id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li> ';	
						
						}
										
						$actionbtn = '<li> 
								 	<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								'.$actionbtn	;
						
						if($row->upload_logo != "No file")
						{
						 $viewbtn = '<li> 
										<a class="tooltips" name="design_file_view" id="design_file_view"  data-toggle="tooltip"  data-title="view" 
								href="'.base_url().'upload/supplier_api/'.$row->upload_logo.'" target="_blank"><i class="fa fa-eye"></i> View</a> 
									 </li>';
						}
						// 
						
						else
						{
							$viewbtn = "";
						}
						
						if($row->upload_logo != "No file")
						{
						$downloadbtn = '<li> 
										<a class="tooltips"   data-toggle="tooltip" data-title="Download" 
										href="'.base_url().'Shippingmaster/download/'.$row->upload_logo.'" ><i class="fa fa-download"></i> Download</a>
									 </li>';
						}
					
						else
						{
							$downloadbtn = '';
						}
					
						if($row->upload_logo != "No file")
						{
						$deleteimagebtn = '<li> 
										<a class="tooltips" name="shipping_file_delete" id="shipping_file_delete" data-toggle="tooltip" data-title="Delete Image" 
										onclick="delete_image('.$row->id.')" href="javascript:;"><i class="fa fa-trash"></i> Delete Image/File</a>
									 </li>';
						}	
						else
						{
							$deleteimagebtn  = '';
						}
							
					}	
					else
					{
						$archivebtn = '<li>
											<a class="tooltips" data-toggle="tooltip" data-title="Unarchive" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
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
	
	public function download($upload_logo = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('./upload/supplier_api/'.$upload_logo));
		force_download($upload_logo, $data);
	}
	
	public function manage()
		{
			$id =  $this->input->post('eid');
			
			if(!empty($id))
			{
					$check_box_design = $this->mode->check_supplier_update($this->input->post('edit_supplier_companyname'));
								
					if(empty($check_box_design) || $this->input->post('editsupplier') == $this->input->post('edit_supplier_companyname'))
					{
												
						$data = array
						(
						
							'supplier_companyname' 		=> $this->input->post('edit_supplier_companyname'),
							'supplier_gstno' 			=> $this->input->post('edit_supplier_gstno'),
							'supplier_panno' 			=> $this->input->post('edit_supplier_panno'),
							'supplier_iecno' 			=> $this->input->post('edit_supplier_iecno'),
							'supplier_address' 	  		=> $this->input->post('edit_supplier_address'),
							'supplier_name' 			=> $this->input->post('edit_supplier_name'),
							'supplier_contactno' 		=> $this->input->post('edit_supplier_contactno'),
							'is_active'					=> $this->input->post('edit_isactive'),
							
							'status'   	   	=> 0
						);
						
						
						$id = $this->input->post('eid');
						
						if($_FILES['edit_upload_logo']['name'] != "" )	
						{
							$this->load->library('upload');
							 $extension = explode(".", $_FILES['edit_upload_logo']['name']);
							$this->upload->initialize($this->set_upload_options('document_',$_FILES['edit_upload_logo']['name']));
							$this->upload->do_upload('edit_upload_logo');
							$upload_image = $this->upload->data();
							$data['upload_logo']  = $upload_image['file_name'];
						
						}
																	
						$updatedid = $this->mode->updatedata($data,$id);
						if($updatedid)
						{
							 $row['id'] =  $id;
							 $row['supplier_companyname'] = $this->input->post('edit_supplier_companyname');
							
							 $row['res'] = 1;
							
						}
						else
						{
							$row['id'] =0;
							$row['supplier_companyname'] =0;
							$row['res'] = 0;
						}
					}
				else
				{
					$row['res'] = 2;
					$row['editsupplier'] = $this->input->post('editsupplier');
				}
		
			}
			else 
			{
				$check_box_design = $this->mode->check_supplier_update($this->input->post('supplier_companyname'));
				
				
				if(empty($check_box_design))
				{
									
					$data = array
					(
							'supplier_companyname' 		=> $this->input->post('supplier_companyname'),
							'supplier_gstno' 			=> $this->input->post('supplier_gstno'),
							'supplier_panno' 			=> $this->input->post('supplier_panno'),
							'supplier_iecno' 			=> $this->input->post('supplier_iecno'),
							'supplier_address' 			=> $this->input->post('supplier_address'),
							'supplier_name' 			=> $this->input->post('supplier_name'),
							'supplier_contactno' 		=> $this->input->post('supplier_contactno'),
							'is_active'					=> $this->input->post('isactive'),
							
							'status'   	   	=> 0
					);
					
					if($_FILES['upload_logo']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['upload_logo']['name']);
						$this->upload->initialize($this->set_upload_options('document_',$_FILES['upload_logo']['name']));
						$this->upload->do_upload('upload_logo');
						$upload_image = $this->upload->data();
						$data['upload_logo']  = $upload_image['file_name'];
					
					}
					else{
						$data['upload_logo']  = 'No file';
					}
					
					$insertid = $this->mode->supplier_insert($data);
			 
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
		$config['upload_path'] 		= './upload/supplier_api/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf|jfif';
		$config['max_size']      	= '8000';
		$config['overwrite']     	= FALSE;
	
		return $config;
	}
	
public function fetchmodeldata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchmodeldata1($id);
				
		echo json_encode($resultdata);
	}
	
	public function archive_record()
		{
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			$archiverecord = $this->mode->archive_record($id,$status);	
				if($archiverecord)
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
		$deleteid=$this->mode->supplier_delete($id);
		
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
		unlink('upload/supplier_api/'.$resultdata->upload_logo);
		
		$data['upload_logo']  = 'No file';
				  
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