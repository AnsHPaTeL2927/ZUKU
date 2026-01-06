<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Tagmaster extends CI_controller{
	
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	$this->load->model('Tagmaster_model','mode');
	$this->load->model('menu_model','menu');
	}
	
	public function index()
    {    
	if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $data['productdata'] 	= $this->mode->manage();	
			 $data['no']	= $this->mode->getno();
			 $data['tagdata']	= $this->mode->gettagdata();
			 //$this->load->model('Companydocument_model','mode');
			 $this->load->model('admin_company_detail');	
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/tagmaster',$data);
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
		 $aColumns = array('mst.tag_id','mst.tag_name','order_no','is_active','(SELECT count(*) FROM `company_tag_master`) as total_cnt','mst.status','(select group_concat(tag_name) from company_tag_master as tag where find_in_set(tag.tag_id,mst.tag_id) and status = 0) as tag_name');
		 $isWhere = array($where);
		 $table = "company_tag_master as mst";
		 $isJOIN = array();
		 $hOrder = "mst.order_no asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
					foreach($sqlReturn['data'] as $row) {
									
					// For condition of date if it's empty
					// $date = $row->stempdate;
					// if(!($row->stempdate) == '0000-00-00' || $row->stempdate == '1970-01-01')
					// {
						// $row->stempdate = date('d/m/Y',strtotime($row->stempdate));
					// }
					// else if($row->stempdate == '0000-00-00' || $row->stempdate == '1970-01-01')
					// {
						// $row->stempdate = '-';
					// }
					// else{
						// $row->stempdate = date('d/m/Y',strtotime($row->stempdate));
					// }
														
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->tag_name;
					//$row_data[] = $row->stempdate;
					$row_data[] = $row->is_active;
					$row_data[] = $row->order_no;
					$actionbtn = '';
				 	$delete_btn = '';
					if($row->status==0)
					{
						$actionbtn = '<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->tag_id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
						
		
					}	
					else
					{
						$actionbtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->tag_id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
					if($row->total_cnt>=1)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->tag_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
								 
					
					}
										
					 $actionbtn = '<li> 
								 	<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->tag_id.');"><i class="fa fa-pencil"></i> Edit</a>
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
				
				$check_box_design = $this->mode->check_tag_update($this->input->post('edit_tagname'));
				
				
				if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_tagname'))
				{
					$data = array
					(
							'tag_name' 		=> $this->input->post('edit_tagname'),
							'order_no' 		=> $this->input->post('edit_ornumber'),
							'is_active' 	=> $this->input->post('edit_isactive')
							
							
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
				$check_box_design = $this->mode->check_tag_update($this->input->post('tagname'));
				
				if(empty($check_box_design))
				{
					$data = array
					(
							'tag_name' 		=> $this->input->post('tagname'),
							'order_no' 		=> $this->input->post('ornumber'),
							'is_active' 	=> $this->input->post('isactive'),
				
							'status'   	   	=> 0
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
		$deleteid=$this->mode->tag_delete($id);
		
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
		
		public function fetchtagdata()
			{
				$id=$this->input->post('id');
				 
				$resultdata=$this->mode->tag_party($id);
			 	//$resultdata->stempdate = date('d-m-Y',strtotime($resultdata->stempdate));
				echo json_encode($resultdata);
			}
}