<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Quotation_listing extends CI_controller{
	
	  public function __construct(){
	  	parent:: __construct();
	  	$this->load->helper('url');
	  	$this->load->library(array('form_validation','session','encrypt'));
	  	$this->load->model('admin_quotation_list','quotation');
		$this->load->model('menu_model','menu');	
	  	if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
	  		redirect(base_url());
	  	}
	  }	
	  public function index($m="")
	  {
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$data['erd']= $m;
			$this->load->model('admin_company_detail');	
			$data['company_detail']  = $this->admin_company_detail->s_select();	
			$data['menu_data']		 = $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/quotation_listing',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	  }
	  public function fetch_record()
	  {
				$quotation_status = $this->input->get('quotation_status');
				$invoicedate = explode(" - ",$this->input->get('date'));
				$where = ' and quotation_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
				 
				if($this->session->usertype_id != 1)
			   {
				$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			   }
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('estimate_id', 'estimate_no','consign.c_name','consign.c_companyname','quotation_date','mst.container_details','mst.port_of_discharge','grand_total','mst.status','mst.cdate','step','cur.currency_name','cur.currency_id');
				$isWhere = array("mst.status = 0".$where);
				$table = "tbl_estimate as mst";
				$isJOIN = array('left join customer_detail consign on consign.id=mst.consigne_id','left join tbl_currency cur on cur.currency_id=mst.invoice_currency_id');
				$hOrder = "mst.estimate_id desc";
				 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
				foreach($sqlReturn['data'] as $row)
				{
					$row_data = array();
					$step_status='';
					if($row->step==1)
					{
						$step_status = '<a class="btn btn-warning tooltips" data-toggle="tooltip" data-title="Add Product Pending" href="'.base_url().'quotation_product/index/'.$row->estimate_id.'"><i class="glyphicon glyphicon-stop"></i></a>';
					}
				 	else if($row->step==2)
					{
						$step_status = '<a class="btn btn-success tooltips" data-toggle="tooltip" data-title="Proforma Invoice Done" href="javascript:;"><i class="fa fa-check-square-o"></i></a>';
					}
					$row_data[] = $step_status;
					if($row->step!=1)
					{
						$row_data[] = '<a class="tooltips" data-toggle="tooltip" data-title="Product Detail" href="javascript:;"  onclick="view_detail('.$row->estimate_id.','.$row->currency_id.')">'.$row->estimate_no.'</a>';
					}
					else{
						$row_data[] = $row->estimate_no;
					}
					$row_data[] = $row->c_companyname.' - '.$row->c_name;
					 
					$row_data[] = date('d/m/Y',strtotime($row->quotation_date));
					$row_data[] = $row->container_details;
					$row_data[] = $row->port_of_discharge;
					$row_data[] = ($row->currency_name=="Euro")?"&euro; ".$row->grand_total:"$".' '.$row->grand_total;
					$viewinvoice='';
					if($row->step==2)
					{
						 
						 
						$viewinvoice='<li>
										<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('quotation_pdf/index/'.$row->estimate_id).'" ><i class="fa fa-file-text-o"></i> View</a>
										 
							 		 </li> ';
					}
					$edit='
					<li>
						<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'quotation/form_edit/'.$row->estimate_id.'"><i class="fa fa-pencil"></i>Edit</a>
						
					</li>';
					$delete=' <li><a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->estimate_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
					</li>';
					if($row->export_status==1)
					{
						$edit ='';
						$delete ='';
					}
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											
												'.$edit.'
												'.$viewinvoice.' '.$delete.'</div>';
					$appData[] = $row_data;
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

	  public function deleterecord()
	  {
	  	$id = $this->input->post('id');
	  	$quotationrecord = $this->quotation->quotation_delete($id);	
	  		if($quotationrecord)
	  		{
	  			$row['res'] = '1';
	  		}
	  		else{
	  			$row['res'] = '0';
	  		}
	  		echo json_encode($row);
	  }
	 
	
}
?>