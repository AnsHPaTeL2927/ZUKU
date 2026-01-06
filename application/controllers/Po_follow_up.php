<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Po_follow_up extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Admin_Producation','producation');
		$this->load->model('Admin_pdf');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id'])  && $this->session->title == TITLE) {
			redirect(base_url());
		}
	}

	function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
		 	$this->load->model('admin_company_detail');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			 $data = array(
			  	'menu_data'			=> $menu_data,
			  	'followup_type'		=> $this->producation->get_followup_type(),
			  	'allsupplier'		=> $this->producation->all_supplier(),
				'alluser'			=> $this->producation->alluser(),
				'company_detail'	=> $this->admin_company_detail->s_select(),
			 );
			$this->load->view('admin/po_follow_up',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function delete_followup()
	{
		$id	=	$this->input->post('id');
		$deleteid=$this->producation->delete_follow_up($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function manage()
	{
		$data = array(
				'performa_invoice_id'	=> $this->input->post('production_mst_id'),
				'followup_today'		=> date('Y-m-d H:i:s',strtotime($this->input->post('followup_today'))),
				'follow_up_type_id'		=> $this->input->post('follow_up_type_id'),
				'follow_date' 			=> date('Y-m-d H:i:s',strtotime($this->input->post('follow_date'))),
				'remarks' 	 			=> nl2br($this->input->post('remarks')),
				'field_1' 				=> $this->input->post('field_1'),
				'field_2' 				=> $this->input->post('field_2'),
				'field_3' 				=> $this->input->post('field_3'),
				'field_4' 				=> $this->input->post('field_4'),
				'followup_from' 	 	=> $this->input->post('followup_from'),
				'follow_up_status' 	 	=> $this->input->post('follow_up_status'),
				'user_id' 				=> $this->input->post('user_id'),
			  	'cdate'				    => date('Y-m-d H:i:s')
				);
		 $insertid = $this->producation->insert_pi_followup($data);
		 $row = array();
					if(!empty($insertid))
					{
						 $row['res'] = 1;
				 	}
					else
					{
						$row['res'] = 0;
				 	}
		 echo json_encode($row);
	}
	 public function view_report()
	 {
		 $invoicedate = explode(" - ",$this->input->post('daterange'));
			$str = ' <table class="table table-bordered table-hover display" id="datatable" width="100%">
						<thead>
							<tr>
							<th class="text-center" width="5%">Sr no</th>
							<th class="text-center" width="10%">PI no</th>
							<th class="text-center" width="10%">Confirm Date</th>
							<th class="text-center" width="10%">Production Created</th>
							<th class="text-center" width="10%">PO Create</th>
						 	<th class="text-center" width="8%">Size</th>
							<th class="text-center" width="8%">Box</th>
							<th class="text-center" width="10%">Remarks</th>
							<th class="text-center" width="10%">Follow Up Date</th>
							<th class="text-center" width="10%">Follow Up By</th>
							<th class="text-center" width="10%">Action</th>
							</tr>
						</thead>';
				$all_cofirm_pi = $this->producation->get_all_productionsheet($invoicedate[0],$invoicedate[1]);
				$no = 1;
				foreach($all_cofirm_pi as $row)
				{
					if(empty($row->already_loading))
					{
					$producationdetail = !empty($row->producation_no)?"YES <br> ".date('d/m/Y',strtotime($row->producation_date)):"NO";
					$podetail = !empty($row->purchase_order_no)?"YES <br> ".date('d/m/Y',strtotime($row->purchase_order_date)):"NO";
			$str .= '<tbody>
						<tr>
							<td  class="text-center">'.$no.'</td>
							<td  class="text-center">'.$row->invoice_no.'</td>
							<td  class="text-center">'.date('d/m/Y',strtotime($row->confirm_date)).'</td>
							<td  class="text-center">'.$producationdetail.'</td>
							<td  class="text-center">'.$podetail.'</td>
							<td  class="text-center">'.$row->size_ordered.'</td>
							<td  class="text-center">'.$row->total_boxes.'</td>';
					if(!empty($row->producation_no))	
					{
						$get_latest_followup = $this->producation->get_latest_followup($row->production_mst_id,2);
						$follow_date = !empty($get_latest_followup->follow_up_status == "Follow Up")?date('d-m-Y h:i A',strtotime($get_latest_followup->follow_date)):"";
						
						$add_follow_up = '<a class="tooltips  btn btn-primary" data-toggle="tooltip" data-title="Add Follow Up" href="javascript:;" onclick="add_fllow_up('.$row->production_mst_id.',&quot;'.$row->producation_no.'&quot;,&quot;'.$follow_date.'&quot;)"   ><i class="fa fa-plus"></i></a>';
						if($get_latest_followup->follow_up_status == "Done")
						{
							$add_follow_up = '<a class="tooltips  btn btn-primary" data-toggle="tooltip" data-title="Add Producation Detail" href="javascript:;" onclick="add_producation_detail('.$row->production_mst_id.',&quot;'.$row->producation_no.'&quot;)"   ><i class="fa fa-industry"></i></a>';
						}
						$str .= '<td  class="text-center">'.$get_latest_followup->remarks.'</td>
								<td  class="text-center">'.$follow_date.'</td>
								<td  class="text-center">'.$get_latest_followup->user_name.'</td>
								<td  class="text-center"> 
								'.$add_follow_up.'
								<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="View Follow up" href="javascript:;" onclick="view_fllow_up('.$row->production_mst_id.',&quot;'.$row->producation_no.'&quot;)" ><i class="fa fa-eye"></i></a>
							</td>';
					}
					else
					{
						$str .= '<td colspan="4" class="text-center"> Production Sheet Pending</td>';
					}
					$str .= '</tr>
                    </tbody>
				 ';
				 $no++;
					}
				 
				}				 
               $str .= ' </table>';
			   echo $str;
	 } 
	 public function fetch_followup_record()
	  {
	 	$performa_invoice_id = $this->input->get('performa_invoice_id');
		 
		
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('pi_followup_id','followup_today', 'invoice.producation_no','follow_date','type.follow_up_type','follow_up_status','mst.remarks');
				$isWhere = array("mst.status = 0  and followup_from = 2 and mst.performa_invoice_id =".$performa_invoice_id);
				$table = "tbl_pi_followup as mst";
				$isJOIN = array(
								'left join tbl_production_mst invoice on invoice.production_mst_id=mst.performa_invoice_id', 
								'left join tbl_follow_up_type type on type.follow_up_type_id=mst.follow_up_type_id' 
								);
				$hOrder = "mst.followup_today desc";
				 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
				foreach($sqlReturn['data'] as $row)
				{
				 
					$row_data = array();
					  
				  
					
					$row_data[] = $no;
					$row_data[] = $row->producation_no;
					$row_data[] = date('d/m/Y h:i A',strtotime($row->followup_today));
				 	$row_data[] = $row->follow_up_type;
				 	$row_data[] = $row->follow_up_status;
				 	$row_data[] = ($row->follow_up_status == "Follow Up")?date('d/m/Y h:i A',strtotime($row->follow_date)):"";
				 	$row_data[] = $row->remarks;
					 $edit=' 
								<a class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_follow('.$row->pi_followup_id.');"><i class="fa fa-pencil"></i></a>
							 ';
					$delete=' 
								<a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->pi_followup_id.')" href="javascript:;" ><i class="fa fa-trash"></i></a>
							 '; 
					$row_data[]  = $delete;
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
	 
}
