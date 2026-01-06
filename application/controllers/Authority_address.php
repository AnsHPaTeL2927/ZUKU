<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Authority_address extends CI_controller
{
	
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	 
	
	/*load Model*/
	$this->load->model('Authority_address_model','mode');
	$this->load->model('menu_model','menu');
	
	
	}
	
	public function index()
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 
			 $this->load->model('admin_company_detail');	
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/authority_address',$data);
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
		 $aColumns = array('mst.id','authority_address','is_active','mst.status','(SELECT count(*) FROM `tbl_authority_address`) as total_cnt');
		 $isWhere = array($where);
		 $table = "tbl_authority_address as mst";
		 $isJOIN = array();
		 $hOrder = "is_active asc,status asc,authority_address asc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
					foreach($sqlReturn['data'] as $row) {
			
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->authority_address;
					
					$row_data[] = $row->is_active;
					
					
					$actionbtn = '';
					$archivebtn = '';
				 	$delete_btn = '';
				
					
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
					$check_box_design = $this->mode->check_address_update($this->input->post('edit_authority_address'));
								
					if(empty($check_box_design) || $this->input->post('editsupplier') == $this->input->post('edit_authority_address'))
					{
												
						$data = array
						(
							'authority_address' 		=> $this->input->post('edit_authority_address'),
							'is_active'					=> $this->input->post('edit_isactive'),
							
							'status'   	   	=> 0
						);
						
						
						$id = $this->input->post('eid');
						
																							
						$updatedid = $this->mode->updatedata($data,$id);
						if($updatedid)
						{
							 $row['id'] =  $id;
							 $row['authority_address'] = $this->input->post('edit_authority_address');
							
							 $row['res'] = 1;
							
						}
						else
						{
							$row['id'] =0;
							 $row['authority_address'] =0;
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
				$check_box_design = $this->mode->check_address_update($this->input->post('authority_address'));
				
				
				if(empty($check_box_design))
				{
									
					$data = array
					(
							
							'authority_address' 		=> $this->input->post('authority_address'),
							'is_active'					=> $this->input->post('isactive'),
							
							'status'   	   	=> 0
					);
					
				
					$insertid = $this->mode->address_insert($data);
			 
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
		$deleteid=$this->mode->address_delete($id);
		
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