<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Taxinvoice_listing extends CI_controller{
	 public function __construct(){
	 	parent:: __construct();
	 	$this->load->helper('url');
	 	$this->load->library(array('form_validation','session','encrypt'));
	 	$this->load->model('admin_taxinvoice_list','tax');
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
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['invoicenodata']	= $this->tax->getinvoicenodata();
			$data['consigneenamedata']	= $this->tax->getconsigneenamedata();
			
			$data['menu_data'] 			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/taxinvoice_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->tax->taxdelete($id);	
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
	}
	public function updateexport_invoice()
	{
		$id = $this->input->post('id');
		$updaterecord = $this->tax->updateexportinvoice($id);	
 
			echo 1;
	}

	public function viewproductdetail(){
		$id = $this->input->post('id');
		$exchangevalue = $this->input->post('Exchange_Rate_val');
		 
		$result = $this->tax->get_productdetail($id);	
		$str = '<table>
					<table class="table table-bordered table-hover" id="sample-table-1">
						<thead>
							<tr>
							
								<th>Sr No.</th>
								<th>Description od Goods</th>
								<th>Plts</th>
								<th>Boxes</th>
								<th>SQM</th>
								<th>Rate In USD</th>
								<th>Per</th>
								<th>Total Amount</th>
								
							</tr>
						</thead>
						<tbody>';
			$no=1;
				for($i=0; $i<count($result);$i++)
				{
					 
					$jsondata = $result[$i];
					 $rowspan=(count($jsondata->serices)>0)?(count($jsondata->serices)+1):'';
					if($jsondata->defualt_status==1)
						{		 
					$str .= '<tr>
								<td rowspan="'.$rowspan.'">'.$no.'</td>
								<td>'.$jsondata->description_goods.'</td>
								<td>'.$jsondata->total_pallet.'</td>
								<td>'.$jsondata->Boxes.'</td>
								<td>'.$jsondata->SQM.'</td>
								<td>&#x20b9;  '.($jsondata->product_rate * $exchangevalue).'</td>
								<td>'.$jsondata->Per.'</td>
								<td>&#x20b9;  '.($jsondata->Total_Amount * $exchangevalue).'</td>
								 
							</tr>
							';
						}
						for($s=0;$s<count($jsondata->serices);$s++)
						{
							$str .= '<tr>';
							  if($jsondata->defualt_status==0)
							 {
								
								if($s==0)
								{
									
									$str .='<td rowspan="'.count($jsondata->serices).'">'.$no.'</td>';
								}
							 }
								$str .='<td>'.$jsondata->serices[$s]->description_goods.' - '.$jsondata->serices[$s]->seriesgroup_name.'</td>
								<td>'.$jsondata->serices[$s]->group_total_pallet.'</td>
								<td>'.$jsondata->serices[$s]->group_total_boxes.'</td>
								<td>'.$jsondata->serices[$s]->group_SQM.'</td>
								<td>&#x20b9; '.($jsondata->serices[$s]->group_Rate_In_USD * $exchangevalue).'</td>
								<td>'.$jsondata->Per.'</td>
								<td>&#x20b9; '.($jsondata->serices[$s]->group_productrate * $exchangevalue).'</td>
							</tr>
							';
						}
						$no++;
				}							
											
				$str .= '</tbody></table>';
		echo $str;
	}
	
	public function fetch_record()
	{
		$invoicenoid = $this->input->get('invoicenoid');
		$consigneename = $this->input->get('consigneename');
				 
		$invoicedate = explode(" - ",$this->input->get('date'));
	 	$where = ' and mst.invoice_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
		if($this->session->usertype_id != 1)
			{
				$where .= " and find_in_set(consign.id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			}	 
		if(!empty($invoicenoid))
		{
			$where .= ' and mst.taxinvoice_id = '.$invoicenoid;
			$_SESSION['invoiceno_get_id'] = $invoicenoid;
		}	
		else
		{
			$_SESSION['invoiceno_get_id'] = '';
		}
		
		if(!empty($consigneename))
		{
			$where .= ' and consign.id = '.$consigneename;
			$_SESSION['get_consigneename'] = $consigneename;
		}	
		else
		{
			$_SESSION['get_consigneename'] = '';
		}

		$this->load->model('Pagging_model');//call module 
		$aColumns = array('taxinvoice_id', 'taxinvoice_no', 'consign.c_companyname','mst.invoice_date','mst.container_details','invoice.igst_status','mst.indian_ruppe_after_gst','mst.grand_total','mst.Exchange_Rate_val','mst.status','mst.cdate','mst.export_invoice_id','(select group_concat(taxinvoice_no) from tbl_taxinvoice as taxinvoice where taxinvoice.taxinvoice_id=mst.taxinvoice_id and status = 0) as taxinvoice_no');
		$isWhere = array("mst.status = 0".$where);
		$table = " tbl_taxinvoice as mst";
		$isJOIN = array(
			'left join customer_detail as consign on consign.id = mst.consiger_id',
			'left join tbl_export_invoice as invoice on invoice.export_invoice_id = mst.export_invoice_id'
			);
			$hOrder = "mst.invoice_date desc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				
		foreach($sqlReturn['data'] as $row) {
			$row_data = array();
		 	$row_data[] = $no;
			$row_data[] = date('d/m/Y',strtotime($row->invoice_date));
			$row_data[] = '<a class="tooltips" data-toggle="tooltip" data-title="Product Detail" href="javascript:;"  onclick="view_detail('.$row->taxinvoice_id.','.$row->Exchange_Rate_val.')">'.$row->taxinvoice_no.'</a>';
			$row_data[] = $row->c_companyname;
			
			$row_data[] = $row->container_details;
			$row_data[] = ($row->igst_status ==1)?"Without GST":"With GST";
			$row_data[] = ($row->igst_status ==1)?"":'<img src="http://i.stack.imgur.com/nGbfO.png" width="8" height="10"> '.indian_number($row->indian_ruppe_after_gst,2);
			$row_data[] = '<img src="http://i.stack.imgur.com/nGbfO.png" width="8" height="10"> '.indian_number($row->grand_total,2);
			$viewinvoice='';
			$actionbtn = '<li> 
						 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'taxinvoice/tax_edit/'.$row->taxinvoice_id.'"><i class="fa fa-pencil"></i> Edit</a>
						 </li>
						 ';
			 $viewinvoice='	<li>
							 	<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('taxinvoiceview/index/'.$row->taxinvoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice</a>
							  </li>
							 <li>
							 	<a class="tooltips" data-toggle="tooltip" data-title="View Invoice(Other Product)" href="'.base_url('taxinvoiceview/other_product/'.$row->taxinvoice_id).'"  ><i class="fa fa-file-text-o"></i> View Invoice(Other Product)</a>
							 </li>
							  <li>
						 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->taxinvoice_id.','.$row->export_invoice_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
						 </li>
							';
		  $row_data[] = '<div class="dropdown">
								<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
								<span class="caret"></span></button>
								<ul class="dropdown-menu">
									'.$actionbtn .'
									'.$viewinvoice.'
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
}
?>