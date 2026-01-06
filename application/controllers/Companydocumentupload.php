<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Companydocumentupload extends CI_controller{
	
	public function __construct()
	{
		/*call CodeIgniter's default Constructor*/
		parent::__construct();
		
		/*load Model*/
		$this->load->model('Companydocumentupload_model','mode');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
		}
	}
	
	public function index()
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $data['documentdata'] 	= $this->mode->documentdata();	

			 $data['tagdata']	= $this->mode->gettagdata();
			 $data['filedata']  = $this->mode->filedata();
			 $this->load->model('admin_company_detail');	
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/companydocumentupload',$data);
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
		if(!empty($this->input->get('tagid')))
		{
			$where .= ' find_in_set("'.$this->input->get('tagid').'",mst.tag_id)'; 
			$_SESSION['modal_filter_finish_id'] = $this->input->get('tagid');
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
		 $aColumns = array('mst.document_id','pro.document_name','document_file','date','no_reminder_days','mst.status','(select group_concat(tag_name) from company_tag_master as tag where find_in_set(tag.tag_id,mst.tag_id) and status = 0) as tag_name','(SELECT count(*) FROM `tbl_document_upload`) as total_cnt');
		 $isWhere = array($where);
		 $table = "tbl_document_upload as mst";
		 $isJOIN = array(
						'inner join tbl_company_document_setup as pro on pro.cmp_doc_setup_id = mst.cmp_doc_setup_id'
						
						);
		 $hOrder = "status asc,mst.cmp_doc_setup_id asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
					foreach($sqlReturn['data'] as $row) {
									
					// For condition of date if it's empty
					$date = $row->date;
					if(!($row->date))
					{
						$row->date = date('d-m-Y',strtotime($row->date));
					}
					else if($row->date == '0000-00-00' || $row->date == '1970-01-01' || $row->date == ' ')
					{
						$row->date = '-';
					}
					
					else
					{
						$row->date = date('d-m-Y',strtotime($row->date));
					}
					
					$dayreminder = $row->no_reminder_days;
				    if($row->no_reminder_days == '0' )
					{
						$dayreminder = '-';
					}
					
					
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->document_name;
					$row_data[] = $row->tag_name;
					//$row_data[] = $row->document_file;					
					
					$row_data[] = $row->date;
					$row_data[] = $dayreminder;
					$actionbtn = '';
					$viewbtn = '';
					$archivebtn = '';
					$downloadbtn = '';
				 	$delete_btn = '';
					$deleteimagebtn = '';
					
					
					if($row->status==0)
					{
						$archivebtn = '<li>
										<a class="tooltips" data-toggle="tooltip" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->document_id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
						
						// show action option only status 0
						
						
						if($row->document_file != "No file")
						{
						 $viewbtn = '<li> 
										<a class="tooltips" name="design_file_view1" id="design_file_view1" target="_blank" data-toggle="tooltip"  data-title="view" 
								href="'.base_url().'upload/company_doc/'.$row->document_file.'"><i class="fa fa-eye"></i> View</a> 
									 </li>';
						}
						else
						{
							$viewbtn = "";
						}
						
						if($row->document_file != "No file")
						{
						 $downloadbtn = '<li> 
										<a class="tooltips" name="design_file_download1" id="design_file_download1"  data-toggle="tooltip"  data-title="Download" 
								href="'.base_url().'Companydocumentupload/download/'.$row->document_file.'" target="_blank"><i class="fa fa-download"></i> Download</a> 
									 </li>';
						}
						else
						{
							$downloadbtn = "";
						}
						
						if($row->document_file != "No file")
						{
						$deleteimagebtn = '<li> 
										<a class="tooltips" name="document_file_delete" id="document_file_delete" data-toggle="tooltip" data-title="Delete Image" 
										onclick="delete_image('.$row->document_id.')" href="javascript:;"><i class="fa fa-trash"></i> Delete Image/File</a>
									 </li>';
						}	
						else
						{
							$deleteimagebtn  = '';
						}

						if($row->total_cnt>=1)
						{
							$delete_btn = '<li>
										<a class="tooltips" data-toggle="tooltip" data-title="Delete"  onclick="delete_record('.$row->document_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li> ';

							
						}
											
						 $actionbtn = '<li> 
										<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->document_id.');"><i class="fa fa-pencil"></i> Edit</a>
									 </li>
									'.$actionbtn	;
						
					}	
					else
					{
						$archivebtn = '<li>
											<a class="tooltips" data-toggle="tooltip" data-title="Unarchive" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->document_id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
				
				
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$viewbtn.'
											'.$downloadbtn.'
											'.$archivebtn.'
											'.$delete_btn .'
											'.$deleteimagebtn.'
										
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
	
	public function download($document_file = NULL) 
	{
    // load download helder
    $this->load->helper('download');
    // read file contents
    $data = file_get_contents(base_url('./upload/company_doc/'.$document_file));
    force_download($document_file, $data);
	}

	public function manage()
		{
			$id =  $this->input->post('eid');
			
			if(!empty($id))
			{
				$check_box_design = $this->mode->check_tag_update($this->input->post('edit_document_id'));
				
				if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_document_id'))
				{
					$date1 = '';
				
					if(!empty($this->input->post('edit_date'))){
						$date1 = date('Y-m-d',strtotime($this->input->post('edit_date')));
					}
					else if($this->input->post('edit_date') == ' '){
						$date1 = '0000-00-00';
					}else if($this->input->post('edit_date') == '0'){
						$date1 = '0000-00-00';
					}
				
					$tagname = implode(",",$this->input->post('edit_tag_id'));
					
				
					$data = array
					(
							'cmp_doc_setup_id' 		=> $this->input->post('edit_document_id'),
							'tag_id' 				=> $tagname,
							
							'date' 					=> $date1,
							'no_reminder_days'      => $this->input->post('edit_dayreminder'),
							'status'   	   			=> 0
							
					);
					
					$id =  $this->input->post('eid');
					
					if($_FILES['edit_model_name']['name'] != "" )	
					{
						$resultdata=$this->mode->fetchmodeldata($id);
						unlink('upload/company_doc/'.$resultdata->document_file);
						$this->load->library('upload');
						$extension = explode(".", $_FILES['edit_model_name']['name']);
						$this->upload->initialize($this->set_upload_options($extension[0].''.$document_file,$_FILES['edit_model_name']['name']));
						$this->upload->do_upload('edit_model_name');
						$upload_image = $this->upload->data();
						$data['document_file']  = $upload_image['file_name'];
					}
										
					$updateid = $this->mode->tag_update($data,$id);
					
					if($updateid)
					{
						$row['id'] =  $id;
						$row['cmp_doc_setup_id'] = $this->input->post('edit_document_id');
						$row['res'] = 1;
						
					}
					else
					{
						$row['id'] =0;
					    $row['cmp_doc_setup_id'] =0;
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
				$check_box_design = $this->mode->check_tag_update($this->input->post('document_id'));
				
				$date = '';
				if(!empty($this->input->post('date'))){
					$date = date('Y-m-d',strtotime($this->input->post('date')));
				}else if($this->input->post('date') == ' '){
					$date = '0000-00-00';
				}
				
				if(empty($check_box_design))
				{
					$tagname = implode(",",$this->input->post('tag_id'));

					$data = array
					(
							'cmp_doc_setup_id' 			=> $this->input->post('document_id'),
							'tag_id' 					=> $tagname,							
							'date' 						=> $date,
							'no_reminder_days'   	    => $this->input->post('dayreminder'),
							'status'   	   				=> 0
					);
					
					if($_FILES['model_name']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['model_name']['name']);
						$this->upload->initialize($this->set_upload_options('document_',$_FILES['model_name']['name']));
						$this->upload->do_upload('model_name');
						$upload_image = $this->upload->data();
						$data['document_file']  = $upload_image['file_name'];
					}
					else
					{
						$data['document_file']  = 'No file';
					}
					
					
				
					$insertid = $this->mode->tag_insert($data);
			 
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
		$config['upload_path'] 		= './upload/company_doc/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf|jfif';
		$config['max_size']      	= '8000';
		$config['overwrite']     	= FALSE;
	

		return $config;
	}
	
	public function getdata()
	{
		$id=$this->input->post('id');
		$data = $this->mode->get_data($id);
	 	echo json_encode($data);
	}
	


public function fetchmodeldata()
{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchmodeldata($id);
		$resultdata->date = ($resultdata->date == "0000-00-00" || $resultdata->date == "1970-01-01")?"":date('d-m-Y',strtotime($resultdata->date));
		
		echo json_encode($resultdata);
}
	
public function edit_record()
	{
				$edit_date = $this->input->post('edit_date');
				
				if(!empty($edit_date)){
					$edit_date = date('Y-m-d',strtotime($edit_date));	
				}
				else if($edit_date == '0000-00-00'){
					$edit_date = ' ';
				}
				else if($edit_date == '1970-01-01'){
					$edit_date = ' ';
				}
				
				
				
				
		$tag_name = implode(",",$this->input->post('edit_tag_id'));
		$data = array(
			
			 'cmp_doc_setup_id'	 	=> $this->input->post('edit_document_id'),
			 'tag_id' 				=> $tag_name,
			 'date' 				=> $edit_date,
			 'no_reminder_days' 	=> $this->input->post('edit_dayreminder'),
			 'status' 				=> 0 
		 );
			$id = $this->input->post('eid');
					
					if($_FILES['edit_model_name']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['edit_model_name']['name']);
						$this->upload->initialize($this->set_upload_options('document_',$_FILES['edit_model_name']['name']));
						$this->upload->do_upload('edit_model_name');
						$upload_image = $this->upload->data();
						$data['document_file']  = $upload_image['file_name'];
					
					}
			
			$updatedid = $this->mode->updatedata($data,$id);
			 if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['document_id'] = $this->input->post('edit_document_id');
					 
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['document_id'] =0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
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
		unlink('upload/company_doc/'.$resultdata->document_file);
		
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
		unlink('upload/company_doc/'.$resultdata->document_file);
		
		$data['document_file']  = 'No file';
				  
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