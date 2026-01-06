<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Portmaster extends CI_controller
{
	
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	$this->load->model('Portmaster_model','mode');
	$this->load->model('menu_model','menu');
	}
	
	public function index()
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $data['countrydata']	= $this->mode->getcountrydata();
			
			 $this->load->model('admin_company_detail');	
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/portmaster',$data);
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
		 $aColumns = array('mst.id','mst.port_name','c_name','port_code','remarks','is_active','mst.status','(select group_concat(c_name) from country_detail as country where find_in_set(country.id,mst.c_name)) as c_name','(SELECT count(*) FROM `tbl_port_master`) as total_cnt');
		 $isWhere = array($where);
		 $table = "tbl_port_master as mst";
		 $isJOIN = array();
		 $hOrder = "is_active asc,status asc,mst.port_name asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
					foreach($sqlReturn['data'] as $row) {
			
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->port_name;
					$row_data[] = $row->port_code;
					$row_data[] = $row->c_name;
					//$row_data[] = $row->document_file;					
					
					$row_data[] = $row->is_active;
					
					
					$actionbtn = '';
					$archivebtn = '';
				 	$delete_btn = '';
					
					if($row->status==0)
					{
						$archivebtn = '<li>
										<a class="tooltips" data-toggle="tooltip" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
						
					}	
					else
					{
						$archivebtn = '<li>
											<a class="tooltips" data-toggle="tooltip" data-title="Unarchive" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
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
	
	public function manage()
		{
			$id =  $this->input->post('eid');
			
			if(!empty($id))
			{
					$check_box_design = $this->mode->check_port_update($this->input->post('edit_port_name'));
								
					if(empty($check_box_design) || $this->input->post('editportname') == $this->input->post('edit_port_name'))
					{
						$countries = implode(",",$this->input->post('edit_country'));
						
						$ornumber = $this->input->post('edit_ornumber');
						if($ornumber == $this->input->post('edit_ornumber'));
						{
							$ornumber;
						}
						
						
						$data = array
						(
						
							'port_name' 						=> $this->input->post('edit_port_name'),
							'port_code' 						=> $this->input->post('edit_port_code'),
							'c_name' 							=> $countries,							
							'remarks' 							=> $this->input->post('edit_remarks'),
							'is_active'							=> $this->input->post('edit_isactive'),
							
							'status'   	   						=> 0
						);
						
						$id = $this->input->post('eid');
												
						$updatedid = $this->mode->updatedata($data,$id);
						if($updatedid)
						{
							 $row['id'] =  $id;
							 $row['port_name'] = $this->input->post('edit_port_name');
							
							 $row['res'] = 1;
							
						}
						else
						{
							$row['id'] =0;
							 $row['port_name'] =0;
							 $row['res'] = 0;
						}
					}
				else
				{
					$row['res'] = 2;
					$row['editportname'] = $this->input->post('editportname');
				}
		
			}
			else 
			{
				$check_box_design = $this->mode->check_port_update($this->input->post('port_name'));
				
				
				if(empty($check_box_design))
				{
					
					
					$countries = implode(",",$this->input->post('country'));
					
				
					$data = array
					(
							'port_name' 						=> $this->input->post('port_name'),
							'port_code' 						=> $this->input->post('port_code'),
							'c_name' 							=> $countries,							
							'remarks' 							=> $this->input->post('remarks'),
							'is_active'							=> $this->input->post('isactive'),
							
							'status'   	   	=> 0
					);
					
					$insertid = $this->mode->port_insert($data);
			 
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
		
	public function fetchportdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchmodeldata($id);
				
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
		$deleteid=$this->mode->port_delete($id);
		
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function import_port()
	{
		//ignore_user_abort(true);
		set_time_limit(0);
		error_reporting(0);
		$row = array();
		if($_FILES['import_file']['name'] != "" )	
		{
			 $path = './upload/csv/';
			 unlink($path."csvfile.csv");
			$this->load->library('upload');
		 	$this->upload->initialize($this->set_upload_options1('csvfile',$_FILES['import_file']['name'],$path));
			$this->upload->do_upload('import_file');
			
			$upload_image 		= $this->upload->data();
			$data['file_name']  = $upload_image['file_name'];
			 
			if(!empty($data['file_name']))
			{
				$file = fopen($path.$data['file_name'], 'r');
				 
				$fields = fgetcsv($file);
				
				if(count($fields)==5)
				{
					$farray = array("Port Name","Port Code","Country","Remarks","Is Active");
					 
				 	if($fields == $farray)
					{
						 
						$line_no = 2;
						$error = array();
						$error_line = array();
					 	while(($row = fgetcsv($file)) != false ) 
						{        
						
							$error_array = '';
							$complete_status = '';
							if(!empty(trim($row[0])))
							{ 
								$checkcountry = $this->mode->checkcountry($row[2]);
								$coutry_id = $checkcountry->id;
								if(!empty($coutry_id))
								{
									// $lastcountryinserted_id = $this->mode->countryinsert($coutry_id);
									//indsert country
									//$coutry_id = $lastcountryinserted_id();
								//}
								
								
																		
										 $data = array(
												'port_name' 				=> $row[0],
												'port_code'					=> $row[1],
												'c_name' 					=> $coutry_id,
												'remarks' 					=> $row[3],
												'is_active' 				=> $row[4]
											 	
											);
											 
											$checkalready_exit = $this->mode->checkalready($data);
											if($checkalready_exit == 0)
											{
													 $rdata = $this->mode->port_insert($data);
														if(!empty($rdata))
														{
															$error_array = "Ok";
														}
														else
														{
															$error_array = "Record Not Inserted.";
															$complete_status = 1;
														}
											}
											else
											{
												$error_array = "Record already inserted.";
												$complete_status = 1;
											}
								 
							}
							else
								{
										$error_array = "Country Not Found.";
										$complete_status = 1;
								}
							}
							else
							{
									$error_array = "Blank Row.";
									$complete_status = 1;
							}
							 
							if($complete_status ==1)
							{
								array_push($error,$error_array);
								array_push($error_line,$line_no);
							}
						 $line_no++;
					}
						fclose($file);
					   
					 if(empty($error))
					 {
					 	 $row['res'] = 1;
					 }
					 else
					 {
						  $row['res'] = 4;
						  $str = '<table class="table table-bordered" width="100%"> 
									<tr>
										<td>Line No</td>
										<td>Error</td>
									</tr>
								';
								for($e=0;$e<count($error);$e++)
								{
									$str .= '
										<tr>
											<td>'.$error_line[$e].'</td>
											<td>'.$error[$e].'</td>
										</tr>
									';
									
								}
							$str .= '</table>';
						  $row['error_html'] =$str; 
					 }
					}
					else
					{
						$row['res'] = 3;
					}
				}
				else
				{
					$row['res'] = 2;
				}
			} 
			else
			{
				$row['res'] = 0;
			}
	 	}
		else
		{
			$row['res'] = 0;
		}
		
		echo json_encode($row);
		 
	}
	private function set_upload_options1($newfilename,$filename)
	{   
			//upload an image options
			$config = array();
			$extension = end(explode(".", $filename));
			$config['file_name'] = $newfilename.'.'.$extension;
			$config['upload_path'] = './upload/csv/';
			$config['allowed_types'] = 'csv';
			$config['max_size']      = '8000';
			$config['overwrite']     = TRUE;

			return $config;
	}
}
?>