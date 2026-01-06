<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Createtask extends CI_controller{
	
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	  
	/*load Model*/
	$this->load->model('Createtask_model','mode');
	$this->load->model('menu_model','menu');
	}
	
	public function index()
    {    
	if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			
			 $this->load->model('admin_company_detail');
			 $data['documentdata'] 	= $this->mode->documentdata();	
			 $data['userdata']	= $this->mode->getuserdata();			 
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/createtask',$data);
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
		 $aColumns = array('mst.id','mst.title','details','date','time','pro.data','(SELECT count(*) FROM `task_list_managment`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "task_list_managment as mst";
		 $isJOIN = array(
						'inner join data_renew as pro on pro.id = mst.data'
						);
		 $hOrder = "mst.title asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {
					
					// For condition of date if it's empty
					$date = $row->date;
					if(!($row->date) == '0000-00-00' || $row->date == '1970-01-01')
					{
						$row->date = '-';
					}
					else if($row->date == '0000-00-00' || $row->date == '1970-01-01')
					{
						$row->date = '-';
					}
					else{
						$row->date = date('d/m/Y',strtotime($row->date));
					}
														
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->title;
				 	$row_data[] = $row->details;
					$row_data[] = $row->date;
					$row_data[] = $row->data;
					
					$actionbtn = '';
				 	$delete_btn = '';
					if($row->status==0)
					{
						$actionbtn = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
						
		
					}	
					else
					{
						$actionbtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
					if($row->total_cnt>=1)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
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
				
				$check_box_design = $this->mode->check_tag_update($this->input->post('edit_title'));
				
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
				
				$time = '';
				if(!empty($this->input->post('edit_time'))){
					$time = date('H:i:s',strtotime($this->input->post('edit_time')));
				}else if($this->input->post('edit_time') == ''){
					$time = '00:00:00';
				}
				
				$userdata = implode(",",$this->input->post('edit_user_id'));
				
				if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_title'))
				{
					$data = array
					(
							'title' 				=> $this->input->post('edit_title'),
							'details' 				=> $this->input->post('edit_details'),
							'date' 					=> $edit_date,
							'time' 					=> $time,
							'data' 			=> $this->input->post('edit_repeatdata'),
							'user_name' 			=> $userdata
							
					);
					
					$insertid = $this->mode->tag_update($data,$id);
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
				$check_box_design = $this->mode->check_tag_update($this->input->post('title'));
				$date = '';
				if(!empty($this->input->post('date'))){
					$date = date('Y-m-d',strtotime($this->input->post('date')));
				}else if($this->input->post('date') == ''){
					$date = '0000-00-00';
				}
				
				
				$time = '';
				if(!empty($this->input->post('time'))){
					$time = date('H:i:s',strtotime($this->input->post('time')));
				}else if($this->input->post('time') == ''){
					$time = '00:00:00';
				}
				
				$userdata = implode(",",$this->input->post('user_id'));
				
				if(empty($check_box_design))
				{
					$data = array
					(
							'title' 				=> $this->input->post('title'),
							'details' 				=> $this->input->post('details'),
							'date' 					=> $date,
							'time' 					=> $time,
							'data' 					=> $this->input->post('repeatdata'),
							'user_name' 			=> $userdata
				
					);
					
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
		
	public function fetchuserdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchmodeldata($id);
				
		echo json_encode($resultdata);
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
		$deleteid=$this->mode->task_delete($id);
		
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
