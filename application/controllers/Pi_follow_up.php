<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Pi_follow_up extends CI_controller
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
				'allconsign'		=> $this->producation->allconsign(),
				'alluser'			=> $this->producation->alluser(),
				'company_detail'	=> $this->admin_company_detail->s_select(),
			 );
			$this->load->view('admin/pi_follow_up',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function follow_up($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
		 	$this->load->model('admin_company_detail');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);
 
			$performainvoice_detail = $this->Admin_pdf->select_invoice_data($id);
			$product_data	= 	$this->Admin_pdf->product_data($id);
		 			
			 $data = array(
			  	'menu_data'					=> $menu_data,
			  	'followup_type'				=> $this->producation->get_followup_type(),
			  	'performainvoice_detail'	=> $performainvoice_detail,
			  	'product_data'				=> $product_data,
				'allconsign'				=> $this->producation->allconsign(),
				'alluser'					=> $this->producation->alluser(),
				'company_detail'			=> $this->admin_company_detail->s_select(),
			 );
			$this->load->view('admin/follow_up_of_pi',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_follow_up($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
		 	$this->load->model('admin_company_detail');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);
			$performainvoice_detail = $this->Admin_pdf->select_invoice_data($id);
		 			
			 $data = array(
			  	'menu_data'					=> $menu_data,
			  	'followup_type'				=> $this->producation->get_followup_type(),
			  	'performainvoice_detail'	=> $performainvoice_detail,
			  	'product_data'				=> $product_data,
				'allconsign'				=> $this->producation->allconsign(),
				'alluser'					=> $this->producation->alluser(),
				'company_detail'			=> $this->admin_company_detail->s_select(),
			 );
			$this->load->view('admin/view_follow_up',$data);
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
				'performa_invoice_id'	=> $this->input->post('performa_invoice_id'),
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
	 public function fetch_record()
	  {
	 	$cust_id = $this->input->get('cust_id');
		$status_id = $this->input->get('status_id');
		$invoicedate = explode(" - ",$this->input->get('date'));
		$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
		 
		if($status_id==1)
		{
			 $where .= ' and confirm_status=0';
		}
		else if($status_id==2)
		{
			$where .= ' and confirm_status = 1';
		}
		 
		$_SESSION['pi_follow_up_s_date'] = $invoicedate[0];
		$_SESSION['pi_follow_up_e_date'] = $invoicedate[1];
		 
		if(!empty($cust_id))
		{
			$where .= ' and mst.consigne_id = '.$cust_id;
			$_SESSION['pi_follow_up_cust_id'] = $cust_id;
	 	}	
		else
		{
			$_SESSION['pi_follow_up_cust_id'] = '';
		}
		 if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('mst.performa_invoice_id', 'invoice_no','performa_date','consign.c_companyname','mst.country_final_destination','mst.container_details','mst.port_of_discharge','grand_total','mst.status','mst.cdate','step','no_of_export','no_of_po','cur.currency_name','cur.currency_id','cur.currency_code','mst.consigne_id','addition_detail_status','confirm_status','user.user_name','consign.c_nick_name','(SELECT GROUP_CONCAT(distinct  product.size_type_mm) from tbl_performa_trn as ptrn inner join tbl_product as product on product.product_id = ptrn.product_id where invoice_id = mst.performa_invoice_id ) as size_ordered','(SELECT sum(no_of_boxes) from tbl_performa_packing as packing inner join tbl_performa_trn as ptrn on ptrn.performa_trn_id = packing.performa_trn_id where ptrn.invoice_id = mst.performa_invoice_id ) as total_boxes','(SELECT sum(no_of_sqm) from tbl_performa_packing as packing inner join tbl_performa_trn as ptrn on ptrn.performa_trn_id = packing.performa_trn_id where ptrn.invoice_id = mst.performa_invoice_id ) as total_sqm','(SELECT DATEDIFF(CURDATE(),performa_date) FROM `tbl_performa_invoice` as daysinvoice where daysinvoice.performa_invoice_id = mst.performa_invoice_id ) as ago_days');
				$isWhere = array("mst.status = 0  and step = 3".$where);
				$table = "tbl_performa_invoice as mst";
				$isJOIN = array(
								'left join customer_detail consign on consign.id=mst.consigne_id',
								'left join tbl_currency cur on cur.currency_id=mst.invoice_currency_id',
								'left join country_detail country on country.id=mst.invoice_currency_id',
								'left join tbl_user user on user.user_id=mst.user_id' 
								);
				$hOrder = "(select date(follow_date) from tbl_pi_followup where status=0 and performa_invoice_id = mst.performa_invoice_id and followup_from =1 order by follow_date limit 1) = CURRENT_DATE() desc,mst.performa_invoice_id desc";
				 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
				foreach($sqlReturn['data'] as $row)
				{
					$color = '';
				if( $row->ago_days > 7 &&  $row->ago_days < 14)
				{
					$color = '<a class="tooltips btn" style="background:green;color:#fff" data-toggle="tooltip" data-title="'. $row->ago_days.' days" href="javascript:;">'. $row->ago_days.' days</a>';
				 
				}
				else if($row->ago_days >= 14 && $row->ago_days < 21)
				{
					$color = '<a class="tooltips btn" style="background:blue;color:#fff" data-toggle="tooltip" data-title="'. $row->ago_days.' days" href="javascript:;">'. $row->ago_days.' days</a>';
				}
				else if($row->ago_days  >= 21 &&$row->ago_days < 28)
				{
					$color = '<a class="tooltips btn" style="background:purple;color:#fff" data-toggle="tooltip" data-title="'. $row->ago_days.' days" href="javascript:;">'. $row->ago_days.' days</a>';
					 
				}
				else if($row->ago_days >= 28 &&$row->ago_days < 60)
				{
					
					$color = '<a class="tooltips btn" style="background:orange;color:#fff" data-toggle="tooltip" data-title="'. $row->ago_days.' days" href="javascript:;">'. $row->ago_days.' days</a>';
					 
				}
				else if($row->ago_days  >= 60 &&$row->ago_days  < 90)
				{
					$color = '<a class="tooltips btn" style="background:gray;color:#fff" data-toggle="tooltip" data-title="'. $row->ago_days.' days" href="javascript:;">'. $row->ago_days.' days</a>';
				}
				else if($row->ago_days  >= 90)
				{
					$color = '<a class="tooltips btn" style="background:red;color:#fff" data-toggle="tooltip" data-title="'. $row->ago_days.' days" href="javascript:;">'. $row->ago_days.' days</a>';
				}
				else if( $row->ago_days == 0)
				{
					$color = '<a class="tooltips btn btn-defualt" style="color:#333" data-toggle="tooltip" data-title="Today" href="javascript:;">Today</a>';
				}
				else
				{
					$color = '<a class="tooltips btn btn-defualt" style="color:#333" data-toggle="tooltip" data-title="'. $row->ago_days.' days" href="javascript:;">'. $row->ago_days.' days</a>';
				}
				$get_latest_followup = $this->producation->get_latest_followup($row->performa_invoice_id,1);
					$row_data = array();
					$step_status='';
					 
				  
					$row_data[] = $no;
					$row_data[] = $row->invoice_no;
					$row_data[] = date('d/m/Y',strtotime($row->performa_date)).'<br>'.$color;
					$consige_name = !empty($row->c_nick_name)?$row->c_nick_name:$row->c_companyname;
					$row_data[] = $consige_name;
					 
				 	$row_data[] = $row->container_details;
					$row_data[] = ($row->total_boxes > 0)?$row->total_boxes:0;
				 
				 	 $follow_date = !empty($get_latest_followup->follow_up_status == "Follow Up")?date('d-m-Y h:i A',strtotime($get_latest_followup->follow_date)):"";
					$row_data[] = $get_latest_followup->remarks;
					$row_data[] = $follow_date;
					$row_data[] = $get_latest_followup->user_name;
				 	 
					$viewinvoice='';
					$checkbox = '';
				 
						if($row->confirm_status == 1)
						{ 
						$exportinvoice= '
							 	<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="View Follow up" href="'.base_url().'pi_follow_up/view_follow_up/'.$row->performa_invoice_id.'"    ><i class="fa fa-eye"></i></a> ';
						}
						else
						{
							$exportinvoice= '
							
								<a class="tooltips  btn btn-primary" data-toggle="tooltip" data-title="Add Follow Up" href="'.base_url().'pi_follow_up/follow_up/'.$row->performa_invoice_id.'" ><i class="fa fa-plus"></i></a>
								<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="View Follow up" href="'.base_url().'pi_follow_up/view_follow_up/'.$row->performa_invoice_id.'" ><i class="fa fa-eye"></i></a> ';
						}
						 
					 
				 		
					 
					$row_data[] = $exportinvoice;
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
	 public function fetch_followup_record()
	  {
	 	$performa_invoice_id = $this->input->get('performa_invoice_id');
		 
		
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('pi_followup_id','followup_today', 'invoice.invoice_no','follow_date','type.follow_up_type','follow_up_status','mst.remarks');
				$isWhere = array("mst.status = 0 and followup_from = 1  and mst.performa_invoice_id =".$performa_invoice_id);
				$table = "tbl_pi_followup as mst";
				$isJOIN = array(
								'left join tbl_performa_invoice invoice on invoice.performa_invoice_id=mst.performa_invoice_id', 
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
				 	$row_data[] = date('d/m/Y h:i A',strtotime($row->followup_today));
				 	$row_data[] = $row->follow_up_type;
				 	$row_data[] = $row->follow_up_status;
				 	$row_data[] = ($row->follow_up_status == "Follow Up")?date('d-m-Y h:i A',strtotime($row->follow_date)):"";
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
	  public function order_summery()
	  {
			
			$str = ' <table class="table table-bordered table-hover display" id="datatable" width="100%">
						<thead>
							<tr> 
									<td colspan="4">PI no 	: '.$performainvoice_detail->invoice_no.'</td>
									<td colspan="3">PI Date : '.date('d/m/Y',strtotime($performainvoice_detail->performa_date)).'	</td>
									<td>
												<div class="dropdown" style="float:left;">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu">
											 <li>
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="'.base_url('performa_invoice_pdf/index/'.$performainvoice_detail->performa_invoice_id).'><i class="fa fa-file-text-o"></i> PI 1</a>
												<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="'.base_url('performa_invoice_pdf/index_withoutfinish/'.$performainvoice_detail->performa_invoice_id).'><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="'.base_url('performa_invoice_pdf/index_withthickness/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="'.base_url('performa_invoice_pdf1/index/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="'.base_url('performa_invoice_pdf2/index/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="'.base_url('performa_invoice_pdf3/index/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 6</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf4/index/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 7</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="'.base_url('performa_invoice_pdf6/index/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 8 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="'.base_url('performa_invoice_pdf7/index/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 9 (With Other Product)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf/index_accord/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 10</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf/index_olwin/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 11</a>	
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf11/index/'.$performainvoice_detail->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 12 (Without Pallet)</a>
											 </li>											 
											</ul>
										</div>&nbsp;
									
									</td>
						 	</tr>
							
							<tr>
							 	<th class="text-center" width="10%">Size</th>
								<th class="text-center" width="10%">Design Name</th>
								<th class="text-center" width="10%">Finish</th>
								<th class="text-center" width="8%">Pallets</th>
								<th class="text-center" width="8%">Boxes</th>
								<th class="text-center" width="10%">SQM</th>
								<th class="text-center" width="10%">Rate / '.$performainvoice_detail->per_value.' ('.strtoupper($performainvoice_detail->currency_name).')</th>
								<th class="text-center" width="10%">Amount (USD)</th>
						 	</tr>
						</thead>
						<tbody>';
			$product_data	= 	$this->Admin_pdf->product_data($performa_invoice_id);
		 
			for($i=0; $i<count($product_data);$i++)
			{ 
				foreach($product_data[$i]->packing  as $packing_row)
				{
					$product_plts = '';
					
					 if($packing_row->no_of_pallet>0)
					{
						$no_of_pallet = $packing_row->no_of_pallet;
					}
					else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet >0)
					{
					  	$no_of_pallet =  $packing_row->no_of_big_pallet.'<br>'.$packing_row->no_of_small_pallet;
					}
					else
					{
						$no_of_pallet =  '-';
					}
					$str .= '<tr>
							 	<td class="text-center">'.$product_data[$i]->size_type_mm.'</td>
								<td class="text-center">'.$packing_row->model_name.'</td>
								<td class="text-center">'.$packing_row->finish_name.'</td>
								<td class="text-center">'.$no_of_pallet.'</td>
								<td class="text-center">'.$packing_row->no_of_boxes.'</td>
								<td class="text-center">'.$packing_row->no_of_sqm.'</td>
								<td class="text-center">'.number_format($packing_row->product_rate,2,'.','').'</td>
								<td class="text-center">'.number_format($packing_row->product_amt,2,'.','').'</td>
						 	</tr>';
				}
			}
			$str .= '</tboday>
					</table>';
				$row = array();
				$row['html'] = $str;
			echo json_encode($row);
	  }		  
}
