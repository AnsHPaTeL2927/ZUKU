<?php 
class Vessel_data extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	
	$this->load->model('Vessel_data_model','mode');
	$this->load->model('menu_model','menu');
	}
	
	public function index()
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $this->load->model('admin_company_detail');	
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/vessel_data',$data);
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
		 $aColumns = array('mst.id','mst.name','mst.details','(SELECT count(*) FROM `tbl_vessel_data`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "tbl_vessel_data as mst";
		 $isJOIN = array();
		 $hOrder = "status asc, name asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {
				
																	
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->name;
					$row_data[] = $row->details;
					
					$actionbtn = '';
				 	$delete_btn = '';
					if($row->status==0)
					{
						$actionbtn = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
									
						if($row->total_cnt>=1)
						{
							$delete_btn = ' <li>
										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li> ';
									 
						
						}
											
						 $actionbtn = '<li> 
										<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->id.');"><i class="fa fa-pencil"></i> Edit</a>
									 </li>
									'.$actionbtn;
					}	
					else
					{
						$actionbtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
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
							'name' 		=> $this->input->post('edit_dname'),
							'details' 		=> $this->input->post('edit_details'),
							'status'   	   	=> 0
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
				
				if(empty($check_box_design))
				{
					$data = array
					(
							'name' 			=> $this->input->post('dname'),
							'details' 		=> $this->input->post('details'),
							'status'   	   	=> 0
					);
					
					$insertid = $this->mode->doc_insert($data);
			 
					$row = array();
					if($insertid)
					{
						$row['res'] = 1;
						$row['id'] = $insertid;
						$row['name'] = $this->input->post('dname');
						
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
		 
		$resultdata=$this->mode->fetch_data($id);
		echo json_encode($resultdata);
	}
		
}
?>