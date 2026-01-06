<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Model_list extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_model_list','model');
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
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['productdata'] 	= $this->model->getproductdata();	
			$data['finishdata']	 	= $this->model->getfinishdata();	
			$data['supdata']	 	=  $this->model->get_supplier();	
			$data['menu_data']		= $this->menu->usermain_menu($this->session->usertype_id);	
		
			$this->load->view('admin/model_list',$data);	
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
		$_SESSION['modal_filter_product_id'] = '';
		if(!empty($this->input->get('filter_product_id')))
		{
			$where .= ' and mst.product_id ='.$this->input->get('filter_product_id'); 
			$_SESSION['modal_filter_product_id'] = $this->input->get('filter_product_id');
		}
		if(!empty($this->input->get('finishid')))
		{
			$where .= ' and find_in_set("'.$this->input->get('finishid').'",mst.finish_id)'; 
			$_SESSION['modal_filter_finish_id'] = $this->input->get('finishid');
		}
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.packing_model_id','mst.model_name','series.series_name','pro.size_type_mm','pro.thickness', 'design_file','mst.status','hsnc.orderby','(select group_concat(finish_name) from tbl_finish as finish where find_in_set(finish.finish_id,mst.finish_id) and status = 0) as finish_name');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_packing_model as mst";
		 $isJOIN = array(
						 'left join tbl_product as pro on pro.product_id=mst.product_id',
						 'left join tbl_series as series on series.series_id=pro.series_id',
						 'left join product_code_detail as hsnc on hsnc.hsnc_code=series.hsnc_code',
					 	 );
		 $hOrder = "mst.packing_model_id desc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
				 
					$row_data = array();
				 	$row_data[] = $no;
					$thickness = (!empty($row->thickness))?' - '.$row->thickness.' MM':"";
					$row_data[] = $row->size_type_mm.' ('.$row->series_name.')'.$thickness;
					$row_data[] = $row->model_name ;
					$row_data[] = $row->finish_name ;
					
					$row_data[] = !empty($row->design_file)?'<a href="'.DESIGN_PATH.$row->design_file.'" data-fancybox="gallery" class="gallery" data-caption="'.$row->model_name.'">
						<img src="'.(DESIGN_PATH.$row->design_file).'" heigth="50px" width="50px" /> 
					</a>':'';
					$delete_btn = '';
					if($row->total_cnt==0)
					{
						if(!empty($row->design_file))
						{
							$delete_btn = ' 
						<li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele Image"  onclick="delete_image('.$row->packing_model_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele Image</a>
						</li> 
						<li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->packing_model_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> 
								 
								 ';
						}
						else
						{
							$delete_btn = ' 
						 
						<li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->packing_model_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> 
								 
								 ';
						}
						
					}			 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->packing_model_id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								'.$delete_btn;
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											 
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
		 
		if($this->input->post('folder_option') == 1)
		{
			$finish_name = implode(",",$this->input->post('finish_id'));
			$data = array(
				'product_id'		=> $this->input->post('product_id'),
				'model_name'		=> $this->input->post('model_name'),
				'finish_id' 		=> $finish_name,
				'factory_id'  		=> $this->input->post('factory_id'),
				'field1' 			=> $this->input->post('field1'),
				'field2' 			=> $this->input->post('field2'),
				'field3' 			=> $this->input->post('field3'),
				'field4' 			=> $this->input->post('field4'),
				'field5' 			=> $this->input->post('field5'),
				'no_of_randome' 	=> $this->input->post('no_of_randome'),
				'status' 	 		=> 0 
			);
			
			$check_data = $this->model->checkdata($data);
			  
			if(!empty($check_data))
			{
				$row['packing_model_id'] 	 = intval($check_data->packing_model_id);
				$row['model_name']  		 = $this->input->post('model_name');
				$row['res'] 		= 2;	
			}
			else
			{
				
				if($_FILES['design_file']['name'] != "" )	
				{
					$this->load->library('upload');
					 $extension = explode(".", $_FILES['design_file']['name']);
					$this->upload->initialize($this->set_upload_options($extension[0].'_'.$finish_name,$_FILES['design_file']['name']));
					$this->upload->do_upload('design_file');
					$upload_image = $this->upload->data();
					$data['design_file']  = $upload_image['file_name'];
					
				}
				 
				$insertid = $this->model->insertdata($data);
				if($insertid)
				{
					$row['packing_model_id']	= $insertid;
					$row['model_name'] 			= $this->input->post('model_name');
					$row['res'] 				= 1;
					
				}
				else
				{
					$row['id'] =0;
					$row['model_name'] =0;
					$row['res'] = 0;
				}
			}
		}
		else
		{
			 $files = $_FILES;
			 $no	= 0;
		   	$cpt 	= count($_FILES['design_folder']['name']);
			
            for($i=0; $i<$cpt; $i++)
            {   
			
					 $this->load->library('upload');
					 $_FILES['filename']['name']	= $files['design_folder']['name'][$i];
					 $_FILES['filename']['type']	= $files['design_folder']['type'][$i];
					 $_FILES['filename']['tmp_name']= $files['design_folder']['tmp_name'][$i];
					 $_FILES['filename']['error']	= $files['design_folder']['error'][$i];
					 $_FILES['filename']['size'] 	= $files['design_folder']['size'][$i];    
					 $extension = explode(".", $_FILES['filename']['name']);
					$this->upload->initialize($this->set_upload_options($extension[0].'_'.$finish_name,$_FILES['filename']['name']));
					$this->upload->do_upload('filename');
					$dataInfo = $this->upload->data();
					$design_name  = explode(".",$files['design_folder']['name'][$i]);
					$data = array(
						'product_id' => $this->input->post('product_id'),
						'model_name' => $design_name[0],
						'finish_id'  => implode(",",$this->input->post('finish_id')),
						'factory_id' => $this->input->post('factory_id'),
						'field1' 	 => $this->input->post('field1'),
						'field2' 	 => $this->input->post('field2'),
						'field3' 	 => $this->input->post('field3'),
						'field4' 	 => $this->input->post('field4'),
						'field5' 	 => $this->input->post('field5'),
						'status' 	 => 0 
					);
					$data['design_file']  = $dataInfo['file_name'];
					$insertid = $this->model->insertdata($data);
			 	 $no++;
			}
				if($insertid)
				{
					$row['packing_model_id']	= $insertid;
					$row['model_name'] 			= '';
					$row['res'] 				= 1;
					
				}
				else
				{
					$row['id'] =0;
					$row['model_name'] =0;
					$row['res'] = 0;
				}
		}
			 echo json_encode($row);
		
	}
	public function multiple_manage()
	{
		$model_name = explode(",",$this->input->post('model_name'));
		for($m=0;$m<count($model_name);$m++)
		{
			$data = array(
				'product_id' 	=> $this->input->post('product_id'),
				'model_name' 	=> $model_name[$m],
				'finish_id' 	=> implode(",",$this->input->post('finish_id')),
				'factory_id' 	=> $this->input->post('factory_id'),
				'field1' 	 	=> $this->input->post('field1'),
				'field2' 	 	=> $this->input->post('field2'),
				'field3' 		=> $this->input->post('field3'),
				'field4' 		=> $this->input->post('field4'),
				'field5' 		=> $this->input->post('field5'),
			 	'status' 		=> 0 
			);
			$check_data = $this->model->checkdata($data);
			
			if(!empty($check_data))
			{
				$row['id'] 			= $check_data->packing_model_id;
				$row['model_name']  = $model_name[$m];
				$row['res'] 		= 2;	
			}
			else
			{
				$insertid = $this->model->insertdata($data);
				if($insertid)
				{
					$row['id'] 			= $insertid;
					$row['model_name']  = $model_name[$m];
					$row['res'] 		= 1;
					
				}
				else
				{
					$row['id'] =0;
					$row['model_name'] =0;
					$row['res'] = 0;
				}
			}
		}
		echo json_encode($row);
	}
	private function set_upload_options($newfilename,$filename)
	{   
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 		= $newfilename.'_'.rand(0,9999).'.'.$extension;
		$config['upload_path'] 		= './upload/design/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png';
		$config['max_size']      	= '5000';
		$config['overwrite']     	= FALSE;

		return $config;
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$user_id = $this->session->id; // assuming you store user_id in session

		$resultdata = $this->model->fetchmodeldata($id);

		// delete file if exists
		if (!empty($resultdata->design_file) && file_exists(DESIGN_PATH . $resultdata->design_file)) {
			unlink(DESIGN_PATH . $resultdata->design_file);
		}

		// pass user_id to model
		$deleteid = $this->model->deleterecord($id, $user_id);

		$row['res'] = $deleteid ? 1 : 0;
		echo json_encode($row);
	}

	public function delete_image()
	{
		$id=$this->input->post('id');
		$resultdata=$this->model->fetchmodeldata($id);
		unlink(DESIGN_PATH.$resultdata->design_file);
		
		$data['design_file']  = '';
				  
		 $updatedid = $this->model->updatedata($data,$id);
		 
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchmodeldata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->model->fetchmodeldata($id);
		 
		echo json_encode($resultdata);
	}
	public function edit_record()
	{
		$finish_name = implode(",",$this->input->post('edit_finish_id'));
		$data = array(
			 'product_id' 		=> $this->input->post('edit_product_id'),
			 'model_name'	 	=> $this->input->post('edit_model_name'),
			 'finish_id' 		=> $finish_name,
			 'factory_id' 		=> $this->input->post('edit_factory_id'),
			 'field1' 		 	=> $this->input->post('edit_field1'),
			 'field2' 		 	=> $this->input->post('edit_field2'),
			 'field3' 			 => $this->input->post('edit_field3'),
			 'field4' 			 => $this->input->post('edit_field4'),
			 'field5' 			 => $this->input->post('edit_field5'),
			 'no_of_randome' 	=> $this->input->post('edit_no_of_randome'),
			 'status' 			=> 0 
		 );
			$id = $this->input->post('eid');
			if($_FILES['edit_design_file']['name'] != "" )	
			{
				$resultdata=$this->model->fetchmodeldata($id);
				unlink(DESIGN_PATH.$resultdata->design_file);
				$this->load->library('upload');
				$extension = explode(".", $_FILES['edit_design_file']['name']);
				$this->upload->initialize($this->set_upload_options($extension[0].'_'.$finish_name,$_FILES['edit_design_file']['name']));
				$this->upload->do_upload('edit_design_file');
				$upload_image = $this->upload->data();
				$data['design_file']  = $upload_image['file_name'];
				  
				 
			}
			
			$updatedid = $this->model->updatedata($data,$id);
			 if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['model_name'] = $this->input->post('edit_model_name');
					 
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['model_name'] =0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
	}
	 
	
}
?>