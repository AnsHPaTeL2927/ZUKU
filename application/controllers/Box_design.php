<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Box_design extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		 
		$this->load->model('Box_design_model','design');
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
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/box_design_list',$data);	
		}
		else
		{
			redirect(base_url().'');
		}		
	}
	public function fetch_record()
	{
		 
		$where = '';
	 
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.box_design_id','box_design_name','box_design_img','box_design_remarks','mst.status','(SELECT count(*) FROM `tbl_performa_packing` where box_design_id = mst.box_design_id) as total_cnt');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_box_design as mst";
		 $isJOIN = array();
		 $hOrder = "mst.box_design_id desc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->box_design_name;
				 	$row_data[] = '<img src="'.base_url().'upload/box_design/'.$row->box_design_img.'" height="50px" width="50px"/>';
						$row_data[] = $row->box_design_remarks;
				  
					$delete_btn = '';
					 if($row->total_cnt==0)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->box_design_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					}	 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_box_design('.$row->box_design_id.');"><i class="fa fa-pencil"></i> Edit</a>
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
		$data = array(
			 'box_design_name' 		=> $this->input->post('box_design_name'),
		 	 'box_design_remarks' 	=> $this->input->post('box_design_remarks'),
			 'status' 				=> 0 
		 );
			$check_box_design = $this->design->check_box_design($this->input->post('box_design_name'));
			if(empty($check_box_design))
			{
				if($_FILES['box_design_img']['name'] != "" )	
				{
					$this->load->library('upload');
					$this->upload->initialize($this->set_upload_options('box_design_img',$_FILES['box_design_img']['name']));
					$this->upload->do_upload('box_design_img');
					$upload_image = $this->upload->data();
					$data['box_design_img']  = $upload_image['file_name'];
					
				}
				$insertid = $this->design->insertdata($data);
				if($insertid)
				{
					$row['res'] 		 = 1;
				}
				else
				{
					$row['id'] =0;
					$row['model_name'] =0;
					$row['res'] = 0;
				}
			}
			else
			{
				$row['res'] = 2;
			}
			 echo json_encode($row);
		
	}
	private function set_upload_options($newfilename,$filename)
	{   
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] = $newfilename.rand(0,9999).'.'.$extension;
		$config['upload_path'] = './upload/box_design/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']      = '5000';
		$config['overwrite']     = FALSE;

		return $config;
	}
	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->design->deleterecord($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->design->fetch_data($id);
		 
		echo json_encode($resultdata);
	}
	public function edit_record()
	{
		$check_box_design = $this->design->check_box_design($this->input->post('edit_box_design_name'));
			if(empty($check_box_design) || $this->input->post('edit_box_design_name') == $this->input->post('editbox_design_name'))
			{
				$data = array(
					'box_design_name' 		=> $this->input->post('edit_box_design_name'),
					'box_design_remarks' 	=> $this->input->post('edit_box_design_remarks'),
					'status' 				=> 0 
				);
		if($_FILES['edit_box_design_img']['name'] != "" )	
		{
			unlink("./upload/".$this->input->post('design_file'));
				
			$this->load->library('upload');
			$this->upload->initialize($this->set_upload_options('box_design',$_FILES['edit_box_design_img']['name']));
			$this->upload->do_upload('edit_box_design_img');
			$upload_image = $this->upload->data();
			$data['box_design_img']  = $upload_image['file_name'];
			
		}
		
			$id = $this->input->post('eid');
			 
			$updatedid = $this->design->updatedata($data,$id);
			 if($updatedid)
			{
				$row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['model_name'] =0;
				 $row['res'] = 0;
			}
			}
			else
			{
				$row['res'] = 2;
				$row['box_design_name'] = $this->input->post('editbox_design_name');
			}
			 echo json_encode($row);
		
	}
	 
}
?>