<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

require '/home1/skytouc1/public_html/skytouch_new/phpspreadsheet2/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pi_designdetails extends CI_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Admin_Producation','producation');
		$this->load->model('Admin_pdf');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id'])) {
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
			 	'mode'				=> 'Add',
				'invoicetype'		=> $selectinvoicetype,
				'menu_data'			=> $menu_data,
				'company_detail'	=> $this->admin_company_detail->s_select(),
				'allperforma_size'	=> $this->producation->allperforma_size(),
				'all_finish_data'	=> $this->producation->get_allfinish(),
				'documentdata'		=> $this->producation->documentdata(),
				'boxdesigndata'		=> $this->producation->boxdesigndata(),
				'series_name'        => $this->producation->seriesdata(),
				'producation_data'	=> $this->producation->get_order_sheet($size,$finish_id,$cust_id,$seriesid),
				'pi_numbers'        => $this->Admin_pdf->getDesignPIno(),
				'pi_sizes'          => $this->Admin_pdf->getDesignSizes(),				
				'pi_designs'        => $this->Admin_pdf->getPiDesigns()
			);
			$this->load->view('admin/pi_designdetails',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	public function view_pdf()
	{
		$this->load->view('admin/order_pdf');
	}
	
	public function get_order_sheet()
	{
		$str = '<div class="table-responsive">
					<table class="table table-bordered  display" id="datatable" width="100%" >
						<thead style="border-color: #6a6a6a;border-style: solid;">
							<tr style="border-color: #6a6a6a;border-style: solid;">
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Sr No</th>
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Invoice No</th>
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Consignee Name</th>
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Supplier Name</th>
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Product</th>
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Size</th>								
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Finish</th>
						 		<th style="border-color: #6a6a6a;border-style: solid;text-align:center;width:160px;">Design</th>								
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Required Quantity</th>
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Production Complete</th>
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Pending Production</th>	
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center;width:60px;">Qc</th>
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center;width:60px;">Pallet Packing</th>							
								<th style="border-color: #6a6a6a;border-style: solid;text-align:center">Action</th>									
						 	</tr>
						</thead>
						 <tbody style="border-color: #6a6a6a;border-style: solid;"> ';

						 $size 		= $this->input->post('size');
						 $finish_id = $this->input->post('finish_id');
						 $cust_id	 = $this->input->post('cust_id');
						 $seriesid	 = '';//$this->input->post('series_id');
						 $piNo	 = $this->input->post('pi_no');
						 $id = $this->input->post('producation_id');
						 $modelDesignId = $this->input->post('model_design_id');
						 $order_sheet_data = $this->Admin_pdf->get_pi_design_data($piNo,$size,$finish_id,$cust_id,$modelDesignId,$seriesid);
			 		     $sr =1;
						if(!empty($order_sheet_data))
						{
							foreach($order_sheet_data as $row)
							{						
									$order_boxes 		=  $row->no_of_boxes;
									$production_boxes 	= $row->production_complete;
									//$pending_box 		= $order_boxes-$production_boxes;
									$pending_box 		= $production_boxes-$order_boxes;

									$QC_status = $row->qc_status == 0 ? 'Pending' : 'Done';
									$Pallatazation_status = $row->pallatazation_status == 0 ? 'Pending' : 'Done';
									
									$dataget = $this->input->post('producation_id');
									$color = "";
									
									
									// if($pending_box == 0)
									// {
										// $color = "#65a465";
									// }elseif ($production_boxes > 0 && $pending_box > 0) {
										// $color = "#ebcc54d6";
										// //$color = "#e78e84";
									// }elseif ($pending_box < 0) {
										// //$color = "#ebcc54d6";
										// $color = "#e78e84";
									// }
									
									
									if($production_boxes == 0)
									{
										$color = "";
									}elseif ($order_boxes < $production_boxes ) {
										$color = "#ebcc54d6";
										//$color = "#e78e84";
									}elseif ($order_boxes > $production_boxes) {
										//$color = "#ebcc54d6";
										$color = "#e78e84";
									}
									elseif($pending_box == 0) {
										$color = "#65a465";
									}
									
									
									
									if($this->session->usertype_id == 1 || $this->session->usertype_id == 7)
									{
										$action = '<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
												  <span class="caret"></span></button>
												  <ul class="dropdown-menu">
												 	<li>
														<a class="tooltips" data-title="Edit" onclick="show_modal('.$row->pi_detail_id.','.$production_boxes.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-pencil"></i>Edit</a>
													</li>
													<li>
														<a class="tooltips" data-title="Detele" onclick="delete_row('.$row->pi_detail_id.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-trash"></i> Delete</a>
												 	</li>
												   </ul>
												</div>'	;
									}
									else if($this->session->usertype_id == 9)
									{
										$action = '<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
												  <span class="caret"></span></button>
												  <ul class="dropdown-menu">
												 	<li>
														<a class="tooltips" data-title="Edit" onclick="show_modal('.$row->pi_detail_id.','.$production_boxes.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-pencil"></i>Edit</a>
													</li>													
												   </ul>
												</div>'	;
									}
									
						if($this->session->usertype_id == 1)
							{				
								if($pending_box == 0)
								{
									$action=   '<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
												  <span class="caret"></span></button>
												  <ul class="dropdown-menu">													
													<li>
														<a class="tooltips" data-title="Detele" onclick="delete_row('.$row->pi_detail_id.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-trash"></i> Delete</a>
												 	</li>
												   </ul>
												</div>'	;
								}
							}
									
								$new = '';
								$new1 = '';
								
								if($row->thickness != '')
								{
									$new = X;
								}
								if($row->thickness != '')
								{
									$new1 = mm;
								}		
								
								if(!empty($row->c_nick_name))
								{
									$name = $row->c_nick_name;
								}								
								else								
								{									
									$name = $row->c_name;					
								}
								
								if($pending_box < 0 && $production_boxes == 0)
								{
									$pending_box = '-';
								}								
								else								
								{									
									$pending_box;					
								}
											
									$final = $new.$thick.$new1;									
									
									$str .= '<tr style="border-color: #6a6a6a;border-style: solid; background:'.$color.'">
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$sr.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$row->pi_no.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$name.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$row->company_name.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$row->series_name.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$row->size_type_cm.''.$new.''.$row->thickness.''.$new1.'</td>					
																
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$row->finish_name.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center; width:160px;">'.$row->model_name.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$order_boxes.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center"> '.$production_boxes.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center">'.$pending_box.'</td>
									<td style="border-color: #6a6a6a;border-style: solid;text-align:center";width:60px;>';

									if($row->qc_status == 0)
									{	
										$str .= '<input type="checkbox" id="q'.$row->pi_detail_id.'" onclick="change_qc_status(this.value)" class="qc_status" name="qc_status[]"
									 value="'.$row->pi_detail_id.'"/> <label  for="q'.$row->pi_detail_id.'">'.$QC_status.'</label>';
									}else{
										$str .= $QC_status;
									}
									 
									$str .='</td>	
									 <td style="text-align:center;width:60px;">';

									 if($row->pallatazation_status == 0)
									{
										$str .= '<input type="checkbox" id="p'.$row->pi_detail_id.'" onclick="change_pallatazation_status(this.value)" class="pallatazation_status" name="pallatazation_status[]"
									 value="'.$row->pi_detail_id.'"/> <label  for="p'.$row->pi_detail_id.'">'.$Pallatazation_status.'</label>';
									}else{
										$str .= $Pallatazation_status;
									}
									 
									$str .='</td>								
									<td style="text-align:center;">
									'.$action.'</td>';						 
									$str .= '</tr>';
									$sr++;
							}
						}
						else
						{
							$str .= '<tr><td class="text-center" colspan="12">No Data Found</td></tr>';
						}			 
						$str .= '</tbody></table></div>';
						$_SESSION['ordersheetnew']=$str;
						
						echo $str;
	}
	
	public function create_order_sheet_excel()
	{
		$size = $this->input->post('size');
		$finish_id = $this->input->post('finish_id');
		$cust_id = $this->input->post('cust_id');
		$piNo = $this->input->post('pi_no');
		$id = $this->input->post('producation_id');
		$modelDesignId = $this->input->post('model_design_id');
		$order_sheet_data = $this->Admin_pdf->get_pi_design_data($piNo, $size, $finish_id, $cust_id, $modelDesignId, $seriesid = '');

		if (empty($order_sheet_data)) {
			echo "No data found";
			return;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setTitle('Order Sheet');

		$headers = [
			'Sr No', 'Invoice No', 'Consignee Name', 'Supplier Name', 'Product', 
			'Size', 'Finish', 'Design', 'Required Quantity', 'Production Complete', 
			'Pending Production', 'QC', 'Pallet Packing'
		];


		$column = 'A';
		$row = 1;
		foreach ($headers as $header) {
			$sheet->setCellValue($column . $row, $header);
			$sheet->getStyle($column . $row)->getFont()->setBold(true); 
			$column++;
		}

		$row = 2;
		$sr = 1;

		foreach ($order_sheet_data as $data) {
			$pending_box = $data->production_complete - $data->no_of_boxes;
			$QC_status = $data->qc_status == 0 ? 'Pending' : 'Done';
			$Pallet_status = $data->pallatazation_status == 0 ? 'Pending' : 'Done';

			$sheet->setCellValue('A' . $row, $sr)
				->setCellValue('B' . $row, $data->pi_no)
				->setCellValue('C' . $row, !empty($data->c_nick_name) ? $data->c_nick_name : $data->c_name)
				->setCellValue('D' . $row, $data->company_name)
				->setCellValue('E' . $row, $data->series_name)
				->setCellValue('F' . $row, $data->size_type_cm . ' ' . $data->thickness . 'mm')
				->setCellValue('G' . $row, $data->finish_name)
				->setCellValue('H' . $row, $data->model_name)
				->setCellValue('I' . $row, $data->no_of_boxes)
				->setCellValue('J' . $row, $data->production_complete)
				->setCellValue('K' . $row, $pending_box)
				->setCellValue('L' . $row, $QC_status)
				->setCellValue('M' . $row, $Pallet_status);

			$sr++;
			$row++;
		}

		$lastRow = $row - 1; 
		$sheet->getStyle('A1:M' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

		foreach (range('A', 'M') as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Order Sheet.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}


	public function delete_row()
	{
		$id=$this->input->post('id');
		$deleteid=$this->Admin_pdf->delete_record($id);
		$row['res'] = 1;
		echo json_encode($row);
	}

	public function edit_production_complete()
	{
		$this->Admin_pdf->edit_record($this->input->post('id'),'production_complete',$this->input->post('production_complete'));
		$row['res'] = 1;
		echo json_encode($row);
	}

	public function change_row_status()
	{
		$id = $this->input->post('id');
		$field = $this->input->post('field');
		
		$this->Admin_pdf->edit_record($id, $field, 1);
		
		$row['res'] = 1;
		echo json_encode($row);
	}
}
