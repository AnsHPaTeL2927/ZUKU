<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_design_detail extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Admin_customer_detail','customer');
			$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 		= $this->admin_company_detail->s_select();	
			$data['cust_data']				= $this->customer->s_edit_select($id); 
			$data['get_product_name_data'] 	= $this->customer->getproductdata(0,$id); 
			$data['menu_data']				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			$this->load->view('admin/add_design_detail',$data);
		}
		else
		{
			redirect(base_url().'');
		}				
	}
	public function load_packing()
	{
		$filter_product_id 		= $this->input->post('filter_product_id');
		 
		$get_design_list		= $this->customer->getproductdesign_filter($filter_product_id); 
		$str = '<option value="">All Design</option>';
		foreach($get_design_list as $design_row)
		{
			$str .= "<option  value='".$design_row->packing_model_id."'>".$design_row->model_name."</option>";
		}
		echo $str;
	}
	public function supplier_rate($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 		= $this->admin_company_detail->s_select();	
			$data['sup_data']				= $this->customer->get_supplier($id); 
			$data['get_product_name_data'] 	= $this->customer->get_sup_productdata(0,$id); 
			$data['menu_data']				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			$this->load->view('admin/add_supplier_rate',$data);
		}
		else
		{
			redirect(base_url().'');
		}				
	}
	public function load_data()
	{
		$str = '  <table class="table table-bordered" style="margin-top:50px" >
						<tr>
							<th>Sr no</th>
							<th>Finish Name</th>
							<th>Price Unit</th>
							<th>Price</th> 
							<th>Action</th> 
						</tr>';
					 $n=0; 
					 $n1=1; 
					 $product_id = $this->input->post('filter_product_id');
					  $_SESSION['customer_product_id'] = $product_id;
					$get_product_name_data	= $this->customer->getproductdata($product_id,$this->input->post('cust_id')); 
				 	foreach($get_product_name_data as $product_row)
					{
						$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
						$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
					 
						$str .= '<tr>
								  		<th colspan="4" class="text-center">'.$product_name.'</th>
								  		<th   class="text-center">	</th>
							 	 </tr>';
								
							 	foreach($product_row->finish_data as $finish_row)
								{
									 $deisgn_rate_data = $this->customer->get_design_rate($this->input->post('cust_id'),$product_row->product_id,$finish_row->finish_id); 
									
  									 $sel1 = ($product_row->sale_unit == "SQM")?"selected='selected'":"";
									 $sel2 = ($product_row->sale_unit == "BOX")?"selected='selected'":"";
									 $sel3 = ($product_row->sale_unit == "SQF")?"selected='selected'":"";
									 $sel4 = ($product_row->sale_unit == "PCS")?"selected='selected'":"";
									  
									 $sel1 = ($deisgn_rate_data->product_rate_per == "SQM")?"selected='selected'":$sel1;
									 $sel2 = ($deisgn_rate_data->product_rate_per == "BOX")?"selected='selected'":$sel2;
									 $sel3 = ($deisgn_rate_data->product_rate_per == "SQF")?"selected='selected'":$sel3;
									 $sel4 = ($deisgn_rate_data->product_rate_per == "PCS")?"selected='selected'":$sel4;
									 $design_rate_id = !empty($deisgn_rate_data->design_rate_id)?$deisgn_rate_data->design_rate_id:0;
						$str .='<tr>
									<td>'.$n1.'</td>
									<td>'.$finish_row->finish_name.'</td>
									<td>
										<select  name="product_rate_per'.$product_row->product_id.'[]" id="product_rate_per'.$n.'" class="form-control" >
											<option '.$sel1.' value="SQM">SQM</option>
											<option '.$sel2.'value="BOX">BOX</option>
											<option '.$sel3.'value="SQF">SQF</option>
											<option '.$sel4.'value="PCS">PCS</option>
										</select>
									</td>
								 	<td>
										<input type="text" class="form-control" name="design_rate'.$product_row->product_id.'[]" id="design_rate'.$n.'" placeholder="Rate"  value="'.number_format($deisgn_rate_data->design_rate,2).'"/>
									</td> 
									<td class="text-center">
										<a class="btn btn-warning tooltips" data-title="Update"  onclick="update_price('.$finish_row->finish_id.','.$product_row->product_id.','.$n.','.$design_rate_id.')" href="javascript:;" ><i class="fa fa-pencil"></i> </a>		
									</td> 
									
													<input type="hidden"   name="finish_id'.$product_row->product_id.'[]" id="finish_id'.$n.$f.'"  value="'.$finish_row->finish_id.'" />
														
											 		
													<input type="hidden"  name="design_rate_id'.$product_row->product_id.'[]" id="design_rate_id'.$n.$f.'"  value="'.$design_rate_id.'" />	
													
													<input type="hidden"  name="product_id'.$product_row->product_id.'[]" id="product_id'.$n.$f.'"  value="'.$product_row->product_id.'" />	
													
								</tr>';
								 
												$n++;
												$n1++;
								}
								$str .='<tr>
										<td colspan="5" class="text-center">
											<a class="btn btn-info tooltips" data-title="Update All Product"  onclick="update_price_by_product('.$product_row->product_id.','.$n.')" href="javascript:;" ><i class="fa fa-pencil"></i> Save All</a>
										</td>
										</tr>';
								
					}
									  
										  
									$str .='</table>';
					
						 
		echo $str; 		
	}		
	public function load_barcode_data()
	{
		$str = '  <table class="table table-bordered" style="margin-top:50px" >
						 <tr>
							<th>Sr no</th>
							<th>Design Name</th>
							<th>Finish Name</th>
						 	<th>Client Design Name</th> 
						 	<th>Barcode No</th> 
						 	<th>Design Code</th> 
							<th>Action</th> 
						 </tr>';
						  $product_id = $this->input->post('filter_product_id');
						   
						  $design_id = $this->input->post('filter_packing_model_id');
						$_SESSION['customer_barcode_product_id'] 		= $product_id;
					 		
					 	$getproductdesign		= $this->customer->getproductdesign($product_id,$design_id); 
						$no = 1;
										$n = 1;
				 	foreach($getproductdesign as $product_row)
					{
						$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
						$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
					 
						$str .= '<tr>
								  		<th colspan="6" class="text-center">'.$product_name.'</th>
								  		<th   class="text-center">	</th>
										
								 </tr>';
								 	
							 	foreach($product_row->design_data as $design_row)
								{
									 if(!empty($design_row->finish_data))
									 {
										foreach($design_row->finish_data as $finish_row)
										{
											$deisgn_rate_data = $this->customer->get_design_data($this->input->post('cust_id'),$product_row->product_id,$design_row->packing_model_id,$finish_row->finish_id);
											 $design_rate_id = !empty($deisgn_rate_data->design_detail_id)?$deisgn_rate_data->design_detail_id:0;
										 $str .='<tr>
									<td>'.$n.'</td>
									<td>'.$design_row->model_name.'</td>
									<td>'.$finish_row->finish_name.'</td>
									<td>
										<input type="text" class="form-control" name="cust_design_name'.$product_row->product_id.'[]" id="cust_design_name'.$n.'" placeholder="Client Design Name"  value="'.$deisgn_rate_data->cust_design_name.'"/>
									</td>
								 	<td>
										<input type="text" class="form-control" name="barcode_no'.$product_row->product_id.'[]" id="barcode_no'.$n.'" placeholder="Barcode"  value="'.$deisgn_rate_data->barcode_no.'"/>
									</td> 
									<td>
										<input type="text" class="form-control" name="extra_flied'.$product_row->product_id.'[]" id="extra_flied'.$n.'" placeholder="Design Code"  value="'.$deisgn_rate_data->extra_flied.'"/>
									</td> 
									<td class="text-center">
										<a class="btn btn-warning tooltips" data-title="Update"  onclick="update_price('.$design_row->packing_model_id.','.$product_row->product_id.','.$n.','.$design_rate_id.','.$finish_row->finish_id.')" href="javascript:;" ><i class="fa fa-pencil"></i> </a>		
									</td> 
									
													<input type="hidden"   name="packing_model_id'.$product_row->product_id.'[]" id="packing_model_id'.$n.$f.'"  value="'.$design_row->packing_model_id.'" />
													
													<input type="hidden"   name="finish_id'.$product_row->product_id.'[]" id="finish_id'.$n.$f.'"  value="'.$finish_row->finish_id.'" />
														
											 		
													<input type="hidden"  name="design_detail_id'.$product_row->product_id.'[]" id="design_detail_id'.$n.$f.'"  value="'.$design_rate_id.'" />	
													
													<input type="hidden"  name="product_id'.$product_row->product_id.'[]" id="product_id'.$n.$f.'"  value="'.$product_row->product_id.'" />	
													
								</tr>';
								$n++;
										}											
									 }
									 else
									 {
										  
										 $deisgn_rate_data = $this->customer->get_design_data($this->input->post('cust_id'),$product_row->product_id,$design_row->packing_model_id,0); 
										  $design_rate_id = !empty($deisgn_rate_data->design_detail_id)?$deisgn_rate_data->design_detail_id:0;
						$str .='<tr>
									<td>'.$n.'</td>
									<td>'.$design_row->model_name.'</td>
									<td> </td>
									<td>
										<input type="text" class="form-control" name="cust_design_name'.$product_row->product_id.'[]" id="cust_design_name'.$n.'" placeholder="Client Design Name"  value="'.$deisgn_rate_data->cust_design_name.'"/>
									</td>
								 	<td>
										<input type="text" class="form-control" name="barcode_no'.$product_row->product_id.'[]" id="barcode_no'.$n.'" placeholder="Barcode"  value="'.$deisgn_rate_data->barcode_no.'"/>
									</td> 
									<td>
										<input type="text" class="form-control" name="extra_flied'.$product_row->product_id.'[]" id="extra_flied'.$n.'" placeholder="Extra Field"  value="'.$deisgn_rate_data->extra_flied.'"/>
									</td> 
									<td class="text-center">
										<a class="btn btn-warning tooltips" data-title="Update"  onclick="update_price('.$design_row->packing_model_id.','.$product_row->product_id.','.$n.','.$design_rate_id.',0)" href="javascript:;" ><i class="fa fa-pencil"></i> </a>		
									</td> 
									
													<input type="hidden"   name="packing_model_id'.$product_row->product_id.'[]" id="packing_model_id'.$n.$f.'"  value="'.$design_row->packing_model_id.'" />
														
											 		
													<input type="hidden"  name="design_detail_id'.$product_row->product_id.'[]" id="design_detail_id'.$n.$f.'"  value="'.$design_rate_id.'" />	
													
													<input type="hidden"   name="finish_id'.$product_row->product_id.'[]" id="finish_id'.$n.$f.'"  value="0" />
													
													<input type="hidden"  name="product_id'.$product_row->product_id.'[]" id="product_id'.$n.$f.'"  value="'.$product_row->product_id.'" />	
													
								</tr>';
								$n++;
									 }
								 
										
								}
								$str .='<tr>
										<td colspan="7" class="text-center">
											<a class="btn btn-info tooltips" data-title="Update All Product"  onclick="update_price_by_product('.$product_row->product_id.','.$n.')" href="javascript:;" ><i class="fa fa-pencil"></i> Save All</a>
										</td>
										</tr>';		
					}
									  
										  
									$str .='</table>';
					
						 
		echo $str; 		
	}		
	
	public function update_multiple_price()
	{
		$product_array_id = $this->input->post('product_array_id');
		$no=0;
		
		foreach($product_array_id as $row)
		{
			$design_rate_id = $this->input->post('design_rate_id')[$no];
			 $data=array(
				'cust_id' 			=> $this->input->post('cust_id'),
				'product_rate_per'  => $this->input->post('product_rate_per')[$no],
				'design_rate' 		=> !empty($this->input->post('design_rate')[$no] || $this->input->post('design_rate')[$no] ==0)?$this->input->post('design_rate')[$no]:"NULL",
			 	'finish_id' 		=> $this->input->post('finish_id')[$no],
			 	'product_id' 		=> $row,
				'cdate'		 		=> date('d-m-Y H:i:s'),
				'status' 			=> 0
			);
			  
			if($design_rate_id > 0)
			{
				 
				$insert_id = $this->customer->update_design_rate($data,$design_rate_id);
				  
			}
			else if(!empty($this->input->post('design_rate')[$no]))
			{
		 
				$insert_id = $this->customer->insert_design_rate($data);
					 
			}
			$no++;
		}
		$row = array();
        	$row['res'] = 1;
		echo json_encode($row);
	}
	public function update_multiple_customerdetail()
	{
		$product_array_id = $this->input->post('product_array_id');
		$no=0;
		
				foreach($product_array_id as $row)
				{
					$design_rate_id = $this->input->post('design_detail_id')[$no];
					$data=array(
					'cust_id' 			=> $this->input->post('cust_id'),
					'cust_design_name' 	=> $this->input->post('cust_design_array')[$no],
					'extra_flied' 		=> $this->input->post('extra_flied_array')[$no],
					'barcode_no' 		=> $this->input->post('barcode_no_array')[$no],
					'finish_id' 		=> $this->input->post('finish_id_array')[$no],
					'packing_model_id' 	=> $this->input->post('packing_model_id')[$no],
					'product_id' 		=> $row,
					'cdate'		 		=> date('d-m-Y H:i:s'),
					'status' 			=> 0
					);
					 
				if($design_rate_id > 0)
				{
					$insert_id = $this->customer->update_design_detail($data,$design_rate_id);
						if($insert_id)
						{
							$row['res'] = 2;
						}
						else
						{
							$row['res'] = 0;
						}
				}
				else{
					$insert_id = $this->customer->insert_design_detail($data);
						if($insert_id)
						{
							$row['res'] = 1;
						}
						else
						{
							$row['res'] = 0;
						}
				}
		 
			 
			$no++;
		}
		$row = array();
        	$row['res'] = 1;
		echo json_encode($row);
	}
	
	public function design_detail($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 		= $this->admin_company_detail->s_select();	
			$data['cust_data']				= $this->customer->s_edit_select($id); 
		 	$data['design_data'] 			= $this->customer->getproductdesign_filter(0); 
			$data['get_product_name_data'] 	= $this->customer->getproductdata(0,$id);  
			$data['menu_data']				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			$this->load->view('admin/design_detail',$data);
		}
		else
		{
			redirect(base_url().'');
		}				
	}
	public function download($cust_id)
	{
		 
		$cust_data		= $this->customer->s_edit_select($cust_id);
		$get_product_name_data 	= $this->customer->getproductdata(0,$cust_id); 
		$data = array();
		 
				$no =1;
				
		foreach($get_product_name_data as $product_row)
		{
			$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
			$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
			foreach($product_row->finish_data as $finish_row)
			{
				$deisgn_rate_data = $this->customer->get_design_rate($cust_data->id,$product_row->product_id,$finish_row->finish_id);
				$row['Sr no']	=	$no;
				$consige_name =  $cust_data->c_companyname;
				$row['Customer Name'] 		= $consige_name;
				$row['Product Name']		= $product_name;
				$row['Finish Name']			=	$finish_row->finish_name;
				$row['Price']				=	 $deisgn_rate_data->design_rate;
				$row['design_rate_id']		=	 $deisgn_rate_data->design_rate_id;
				array_push($data,$row);
				$no++;
			}
		}
		$str .= '</table>';
		 $consige_name =  $cust_data->c_companyname;
		 
		$fileName_1 = $consige_name.'_price.csv';
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName_1}");
        header("Expires: 0");
        header("Pragma: public");
        $fh1 = @fopen( 'php://output', 'w' );
        $headerDisplayed1 = false;
        foreach ( $data as $data1 ) {
            // Add a header row if it hasn't been added yet
            if ( !$headerDisplayed1 ) {
                // Use the keys from $data as the titles
                fputcsv($fh1, array_keys($data1));
                $headerDisplayed1 = true;
            }
            // Put the data into the stream
            fputcsv($fh1, $data1);
        }
    // Close the file
        fclose($fh1);
    // Make sure nothing else is sent, our file is done
        exit;
		 
	}
	public function download_cust_data($cust_id)
	{
		 
		$cust_data	 			= $this->customer->s_edit_select($cust_id);
		$get_product_name_data 	= $this->customer->getproductdesign(0,0); 
		 $data = array();
		 
				$no =1;
		foreach($get_product_name_data as $product_row)
		{
			$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
			$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
			foreach($product_row->design_data as $design_row)
			{
				if(!empty($design_row->finish_data))	
				{
					foreach($design_row->finish_data as $finish_row)
					{
						$deisgn_rate_data = $this->customer->get_design_data($cust_data->id,$product_row->product_id,$design_row->packing_model_id,$finish_row->finish_id);
						$row['Sr no']				=	$no;
						$consige_name =  $cust_data->c_companyname;
						$row['Customer Name'] 		= 	$consige_name;
						$row['Product Name']		= 	$product_name;
						$row['Design Name']			=	$design_row->model_name;
						$row['Finish Name']			=	$finish_row->finish_name;
						$row['Client Design Name']	=	$deisgn_rate_data->cust_design_name;
						$row['Barcode No']			=	$deisgn_rate_data->barcode_no;
						$row['Extra Field']			=	$deisgn_rate_data->extra_flied;
						$row['design_detail_id']	=	$deisgn_rate_data->design_detail_id;
						array_push($data,$row);
					}
				}
				else
				{
					$deisgn_rate_data = $this->customer->get_design_data($cust_data->id,$product_row->product_id,$design_row->packing_model_id,0);
					$consige_name =  $cust_data->c_companyname;
				$row['Sr no']				=	$no;
				$row['Customer Name'] 		= 	$consige_name;
				$row['Product Name']		= 	$product_name;
				$row['Design Name']			=	$design_row->model_name;
				$row['Finish Name']			=	'';
				$row['Client Design Name']	=	$deisgn_rate_data->cust_design_name;
				$row['Barcode No']			=	$deisgn_rate_data->barcode_no;
				$row['Extra Field']			=	$deisgn_rate_data->extra_flied;
			 	$row['design_detail_id']	=	$deisgn_rate_data->design_detail_id;
				array_push($data,$row);
				}
				$no++;
			}
		}
		$str .= '</table>';
		 $consige_name =  $cust_data->c_companyname;
		$fileName_1 = $consige_name.'_design_detail.csv';
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName_1}");
        header("Expires: 0");
        header("Pragma: public");
        $fh1 = @fopen( 'php://output', 'w' );
        $headerDisplayed1 = false;
        foreach ( $data as $data1 ) {
            // Add a header row if it hasn't been added yet
            if ( !$headerDisplayed1 ) {
                // Use the keys from $data as the titles
                fputcsv($fh1, array_keys($data1));
                $headerDisplayed1 = true;
            }
            // Put the data into the stream
            fputcsv($fh1, $data1);
        }
    // Close the file
        fclose($fh1);
    // Make sure nothing else is sent, our file is done
        exit;
		 
	}
	public function import_price()
	{
		//ignore_user_abort(true);
		set_time_limit(0);
		error_reporting(0);
		$row = array();
		if($_FILES['import_file']['name'] != "" )	
		{
			 $path = './upload/csv/';
			 unlink($path."pricefile.csv");
			$this->load->library('upload');
		 	$this->upload->initialize($this->set_upload_options1('pricefile',$_FILES['import_file']['name'],$path));
			$this->upload->do_upload('import_file');
			$upload_image = $this->upload->data();
			$data['file_name']  = $upload_image['file_name'];
			 
			if(!empty($data['file_name']))
			{
				$file = fopen($path.$data['file_name'], 'r');
				 
				$fields = fgetcsv($file);
				 
				if(count($fields)==6)
				{
					$farray = array("Sr no","Customer Name","Product Name","Finish Name","Price",'design_rate_id');
					 
				 	if($fields == $farray)
					{
					 	$line_no = 2;
						$error = array();
						$error_line = array();
					 	while(($row = fgetcsv($file)) != false ) 
						{        
						 	$error_array = '';
							$complete_status = '';
							if(!empty(trim($row[0])))
							{ 
								$checkcustomer = $this->customer->check_customer($this->input->post('import_cust_id'),$row[1]);
								if(!empty($checkcustomer))
								{
									$check_finish = $this->customer->getfinish($row[3]);
									
									$check_product = $this->customer->get_product($row[2]);
									
									$data=array(
										'cust_id' 			=> $this->input->post('import_cust_id'),
										'design_rate' 		=> $row[4],
										'finish_id' 		=> $check_finish->finish_id,
										'product_id' 		=> $check_product->product_id,
										'cdate'		 		=> date('d-m-Y H:i:s'),
										'status' 			=> 0
									);
									 
									 $design_rate_id = $row[5];
										if($design_rate_id > 0)
										{
											$insert_id = $this->customer->update_design_rate($data,$design_rate_id);
												 
										}
										else{
											$insert_id = $this->customer->insert_design_rate($data);
										}
										 
								}
								else
								{
										$error_array = "Customer Wrong.";
										$complete_status = 1;
								}
							}
							else
							{
									$error_array = "Blank Row.";
									$complete_status = 1;
							}
						   array_push($error,$error_array);
						   array_push($error_line,$line_no);
						 $line_no++;
					}
						fclose($file);
					  
					 if(empty($error_array))
					 {
					 	 $row['res'] = 1;
					 }
					 else
					 {
						  $row['res'] = 4;
						  $str = '<table class="table table-bordered" width="100%"> 
									<tr>
										<td>Line No</td>
										<td>Error</td>
									</tr>
								';
								for($e=0;$e<count($error);$e++)
								{
									$str .= '
										<tr>
											<td>'.$error_line[$e].'</td>
											<td>'.$error[$e].'</td>
										</tr>
									';
									
								}
							$str .= '</table>';
						  $row['error_html'] =$str; 
					 }
					}
					else
					{
						$row['res'] = 3;
					}
				}
				else
				{
					$row['res'] = 2;
				}
			} 
			else
			{
				$row['res'] = 0;
			}
	 	}
		else
		{
			$row['res'] = 0;
		}
		
		echo json_encode($row);
		 
	}
	public function import_cust_data()
	{
		//ignore_user_abort(true);
		set_time_limit(0);
		error_reporting(0);
		$row = array();
		if($_FILES['import_file']['name'] != "" )	
		{
			 $path = './upload/csv/';
			 unlink($path."custdesignfile.csv");
			$this->load->library('upload');
		 	$this->upload->initialize($this->set_upload_options1('custdesignfile',$_FILES['import_file']['name'],$path));
			$this->upload->do_upload('import_file');
			$upload_image = $this->upload->data();
			$data['file_name']  = $upload_image['file_name'];
			 
			if(!empty($data['file_name']))
			{
				$file = fopen($path.$data['file_name'], 'r');
				 
				$fields = fgetcsv($file);
				 
				if(count($fields)==9)
				{
					$farray = array("Sr no","Customer Name","Product Name","Design Name","Finish Name","Client Design Name","Barcode No","Extra Field",'design_detail_id');
					 
				 	if($fields == $farray)
					{
					 	$line_no = 2;
						$error = array();
						$error_line = array();
					 	while(($row = fgetcsv($file)) != false ) 
						{        
						 	$error_array = '';
							$complete_status = '';
							if(!empty(trim($row[0])))
							{ 
								$checkcustomer = $this->customer->check_customer($this->input->post('import_cust_id'),$row[1]);
								if(!empty($checkcustomer))
								{
									$check_design = $this->customer->getdesign_data($row[3]);
									 
									$check_product = $this->customer->get_product($row[2]);
									$check_finish = $this->customer->getfinish($row[4]);
									 
									$data=array(
										'cust_id' 			=> $this->input->post('import_cust_id'),
									 	'packing_model_id' 	=> $check_design->packing_model_id,
									 	'finish_id' 		=> $check_finish->finish_id,
										'product_id' 		=> $check_product->product_id,
										'barcode_no' 		=> $row[6],
										'extra_flied' 		=> $row[7],
										'cust_design_name' 	=> $row[5],
										'cdate'		 		=> date('d-m-Y H:i:s'),
										'status' 			=> 0
									);
									 $design_detail_id = $row[8];
									 
										if($design_detail_id > 0)
										{
											$insert_id = $this->customer->update_design_detail($data,$design_detail_id);
												 
										}
										else
										{
											$insert_id = $this->customer->insert_design_detail($data);
										}
										 
								}
								else
								{
										$error_array = "Customer Wrong.";
										$complete_status = 1;
								}
							}
							else
							{
									$error_array = "Blank Row.";
									$complete_status = 1;
							}
						   array_push($error,$error_array);
						   array_push($error_line,$line_no);
						 $line_no++;
					}
						fclose($file);
					  
					 if(empty($error_array))
					 {
					 	 $row['res'] = 1;
					 }
					 else
					 {
						  $row['res'] = 4;
						  $str = '<table class="table table-bordered" width="100%"> 
									<tr>
										<td>Line No</td>
										<td>Error</td>
									</tr>
								';
								for($e=0;$e<count($error);$e++)
								{
									$str .= '
										<tr>
											<td>'.$error_line[$e].'</td>
											<td>'.$error[$e].'</td>
										</tr>
									';
									
								}
							$str .= '</table>';
						  $row['error_html'] =$str; 
					 }
					}
					else
					{
						$row['res'] = 3;
					}
				}
				else
				{
					$row['res'] = 2;
				}
			} 
			else
			{
				$row['res'] = 0;
			}
	 	}
		else
		{
			$row['res'] = 0;
		}
		
		echo json_encode($row);
		 
	}
	
	private function set_upload_options1($newfilename,$filename)
	{   
			//upload an image options
			$config = array();
			$extension = end(explode(".", $filename));
			$config['file_name'] = $newfilename.'.'.$extension;
			$config['upload_path'] = './upload/csv/';
			$config['allowed_types'] = 'csv';
			$config['max_size']      = '5000';
			$config['overwrite']     = FALSE;

			return $config;
	}

	public function updateprice()
	{
		$design_rate_id = $this->input->post('design_rate_id');
		$data=array(
			'cust_id' 			=> $this->input->post('cust_id'),
			'design_rate' 		=> $this->input->post('design_rate'),
			//'cust_design_name' 	=> $this->input->post('design_name'),
			//'barcode_no' 		=> $this->input->post('barcode_no'),
			'finish_id' 		=> $this->input->post('finish_id'),
			'product_rate_per' 		=> $this->input->post('product_rate_per'),
			//'packing_model_id' 	=> $this->input->post('packing_model_id'),
			'product_id' 		=> $this->input->post('product_id'),
			'cdate'		 		=> date('Y-m-d H:i:s'),
			'status' 			=> 0
		);
		if($design_rate_id > 0)
		{
			$insert_id = $this->customer->update_design_rate($data,$design_rate_id);
				if($insert_id)
				 {
				 	$row['res'] = 2;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
		}
		else{
			$insert_id = $this->customer->insert_design_rate($data);
				if($insert_id)
				 {
				 	$row['res'] = 1;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
		}
          
		echo json_encode($row);
	}
	public function updatedesigndetail()
	{
		$design_rate_id = $this->input->post('design_rate_id');
		$data=array(
			'cust_id' 			=> $this->input->post('cust_id'),
			'cust_design_name' 	=> $this->input->post('cust_design_name'),
			'barcode_no' 		=> $this->input->post('barcode_no'),
			'extra_flied' 		=> $this->input->post('extra_flied'),
			'packing_model_id' 	=> $this->input->post('packing_model_id'),
			'finish_id' 		=> $this->input->post('finish_id'),
			'product_id' 		=> $this->input->post('product_id'),
			'cdate'		 		=> date('d-m-Y H:i:s'),
			'status' 			=> 0
		);
		if($design_rate_id > 0)
		{
			$insert_id = $this->customer->update_design_detail($data,$design_rate_id);
				if($insert_id)
				 {
				 	$row['res'] = 2;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
		}
		else{
			$insert_id = $this->customer->insert_design_detail($data);
				if($insert_id)
				 {
				 	$row['res'] = 1;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
		}
          
		echo json_encode($row);
	}
	public function getsupilerestimate($id){

		if( $this->session->id == 1 && $this->session->title == TITLE)
		{
			$data['edit_record']=$this->supplier->getsupplierproduct_record($id);
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select(); 
			$data['maindetail'] = $this->supplier->select_config(); 
		//	$data['get_series'] = $this->supplier->get_series(); 
			$data['mode']="Change";
		 	$this->load->view('admin/getsupilerestimate',$data);
		}
		else
		{
			
			redirect(base_url().'');
		}	
	}
 	public function addrow()
	{
		$no = intval($this->input->post('no'))+1;
		$get_series = $this->supplier->get_series(); 
			
		$str = '<tr id="rowtr'.$no.'">
							<td>
							<select class="select2" name="series_id" id="series_id'.$no.'"  required title="Select Series" onchange="add_new_serices(this.value,'.$no.')">
							<option value="">Select Series</option>
								<option value="0">Add New Series</option>
								';
							 
								 for($s=0;$s<count($get_series);$s++)
								 {
									 $selected = '';
									  if($get_series[$s]->series_id==$edit_record->series_id)
									 {
										 $selected = 'selected="selected"';
									 }
									$str .=' <option '.$selected.' value="'.$get_series[$s]->series_id.'">'.$get_series[$s]->series_name.'</option>';
								 } 
								 
								
							$str .='</select> </td>
							<td> 
								<input type="text" name="rate" id="rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" value="" onkeyup="price_calaculation('.$no.')" />
							</td>
							<td>
							<select class="form-control" name="price_type" id="price_type'.$no.'" onchange="price_calaculation('.$no.')" required title="Select Price Per">
								<option value="">Select Price per</option> 
								<option '.$select.' value="Feet" >Feet</option>
								<option '.$select1.' value="Box">Box</option>
								<option '.$select2.' value="SQM">SQM</option>
								</select>
							</td>
							<td> 
								<input type="text" name="pallet_charges" id="pallet_charges'.$no.'" class="form-control pallet_calcution" onkeypress="return isNumber(event)" onkeyup="price_calaculation('.$no.')"  />
							</td>
							<td>
								<input type="text" name="fob_expenenses" id="fob_expenenses'.$no.'" class="form-control" onkeypress="return isNumber(event)"  onkeyup="price_calaculation('.$no.')" />
							</td>
							<td> 
								<input type="text" name="our_selling_price" id="our_selling_price'.$no.'" class="form-control" onkeypress="return isNumber(event)" onkeyup="our_price_calaculation('.$no.')"  />
							</td>
							<td> 
								<input type="text" readonly  name="profit_price" id="profit_price'.$no.'" class="form-control"  />
							</td>
							<td> 
								 <button class="btn btn-danger" onclick="remove_row('.$no.')">-</button>
							</td> 
							<input type="hidden" name="usd_per_box" id="usd_per_box'.$no.'" class="form-control"    />
							
						</tr>';
			echo $str;
	}

	public function load_sup_data()
	{
		$str = '  <table class="table table-bordered" style="margin-top:50px" >
						<tr>
							<th>Sr no</th>
							<th>Finish Name</th>
							<th>Price Unit</th>
							<th>Price</th> 
							<th>Action</th> 
						</tr>';
					 $n=0; 
					 $n1=1; 
					   $_SESSION['sup_product_id'] = $this->input->post('filter_product_id');
					$get_product_name_data	= $this->customer->get_sup_productdata($this->input->post('filter_product_id')); 
				 	foreach($get_product_name_data as $product_row)
					{
						$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
						$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
					 
						$str .= '<tr>
								  		<th colspan="5" class="text-center">'.$product_name.'</th>
							 	 </tr>';
								
							 	foreach($product_row->finish_data as $finish_row)
								{
									 $deisgn_rate_data = $this->customer->get_design_suppiler_rate($this->input->post('supplier_id'),$product_row->product_id,$finish_row->finish_id); 
									 
									 
									 $sel1 = ($product_row->purchase_unit == "SQM")?"selected='selected'":"";
									 $sel2 = ($product_row->purchase_unit == "BOX")?"selected='selected'":"";
									 $sel3 = ($product_row->purchase_unit == "SQF")?"selected='selected'":"";
									 $sel4 = ($product_row->purchase_unit == "PCS")?"selected='selected'":"";
									 
									 $sel1 = ($deisgn_rate_data->product_rate_per == "SQM")?"selected='selected'":$sel1;
									 $sel2 = ($deisgn_rate_data->product_rate_per == "BOX")?"selected='selected'":$sel2;
									 $sel3 = ($deisgn_rate_data->product_rate_per == "SQF")?"selected='selected'":$sel3;
									 $sel4 = ($deisgn_rate_data->product_rate_per == "PCS")?"selected='selected'":$sel4;
									 $design_suppiler_rate_id = !empty($deisgn_rate_data->design_suppiler_rate_id)?$deisgn_rate_data->design_suppiler_rate_id:0;
						$str .='<tr>
									<td>'.$n1.'</td>
									<td>'.$finish_row->finish_name.'</td>
									<td>
										<select  name="product_rate_per'.$product_row->product_id.'[]" id="product_rate_per'.$n.'" class="form-control" >
											<option '.$sel1.' value="SQM">SQM</option>
											<option '.$sel2.'value="BOX">BOX</option>
											<option '.$sel3.'value="SQF">SQF</option>
											<option '.$sel4.'value="PCS">PCS</option>
										</select>
									</td>
								 	<td>
										<input type="text" class="form-control" name="design_rate'.$product_row->product_id.'[]" id="design_rate'.$n.'" placeholder="Rate"  value="'.number_format($deisgn_rate_data->design_rate,2).'"/>
									</td> 
									<td class="text-center">
										<a class="btn btn-warning tooltips" data-title="Update"  onclick="update_price('.$finish_row->finish_id.','.$product_row->product_id.','.$n.','.$design_suppiler_rate_id.')" href="javascript:;" ><i class="fa fa-pencil"></i> </a>		
									</td> 
									
													<input type="hidden"   name="finish_id'.$product_row->product_id.'[]" id="finish_id'.$n.$f.'"  value="'.$finish_row->finish_id.'" />
														
											 		
													<input type="hidden"  name="design_rate_id'.$product_row->product_id.'[]" id="design_rate_id'.$n.$f.'"  value="'.$design_suppiler_rate_id.'" />	
													
													<input type="hidden"  name="product_id'.$product_row->product_id.'[]" id="product_id'.$n.$f.'"  value="'.$product_row->product_id.'" />	
													
								</tr>';
								 
												$n++;
												$n1++;
								}
								$str .= '<tr><th colspan="5"  class="text-center"><a class="btn btn-info tooltips" data-title="Update All Product"  onclick="update_price_by_product('.$product_row->product_id.','.$n.')" href="javascript:;" ><i class="fa fa-pencil"></i> Save all</a>	</th></tr>';
					}
									  
										  
									$str .='</table>';
					
						 
		echo $str; 		
	}		
	public function update_sup_price()
	{
		$design_suppiler_rate_id = $this->input->post('design_rate_id');
		$data=array(
			'supplier_id' 			=> $this->input->post('supplier_id'),
			'design_rate' 		=> $this->input->post('design_rate'),
			//'cust_design_name' 	=> $this->input->post('design_name'),
			//'barcode_no' 		=> $this->input->post('barcode_no'),
			'finish_id' 		=> $this->input->post('finish_id'),
			'product_rate_per' 		=> $this->input->post('product_rate_per'),
			//'packing_model_id' 	=> $this->input->post('packing_model_id'),
			'product_id' 		=> $this->input->post('product_id'),
			'cdate'		 		=> date('Y-m-d H:i:s'),
			'status' 			=> 0
		);
		if($design_suppiler_rate_id > 0)
		{
			$insert_id = $this->customer->update_sup_design_rate($data,$design_suppiler_rate_id);
				if($insert_id)
				 {
				 	$row['res'] = 2;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
		}
		else{
			$insert_id = $this->customer->insert_sup_design_rate($data);
				if($insert_id)
				 {
				 	$row['res'] = 1;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
		}
          
		echo json_encode($row);
	}
	public function update_multiple_sup_price()
	{
		$product_array_id = $this->input->post('product_array_id');
		$no=0;
		
		foreach($product_array_id as $row)
		{
			$design_rate_id = $this->input->post('design_rate_id')[$no];
			 $data=array(
				'supplier_id' 			=> $this->input->post('supplier_id'),
				'product_rate_per'  => $this->input->post('product_rate_per')[$no],
				'design_rate' 		=> !empty($this->input->post('design_rate')[$no] || $this->input->post('design_rate')[$no] ==0)?$this->input->post('design_rate')[$no]:"NULL",
			 	'finish_id' 		=> $this->input->post('finish_id')[$no],
			 	'product_id' 		=> $row,
				'cdate'		 		=> date('d-m-Y H:i:s'),
				'status' 			=> 0
			);
			  
			if($design_rate_id > 0)
			{
				 
				$insert_id = $this->customer->update_sup_design_rate($data,$design_rate_id);
				  
			}
			else if(!empty($this->input->post('design_rate')[$no]))
			{
		 
				$insert_id = $this->customer->insert_sup_design_rate($data);
					 
			}
			$no++;
		}
		$row = array();
        	$row['res'] = 1;
		echo json_encode($row);
	}
	public function download_sup_rate($sup_id)
	{
		 
		$sup_data	 			= $this->customer->get_supplier($sup_id);
		$get_product_name_data 	= $this->customer->get_sup_productdata(0); 
		 $data = array();
		 
		
				$no =1;
		foreach($get_product_name_data as $product_row)
		{
			$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
			$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
			
				if(!empty($product_row->finish_data))	
				{
					foreach($product_row->finish_data as $finish_row)
					{
					 	
						$deisgn_rate_data = $this->customer->get_design_suppiler_rate($sup_data->supplier_id,$product_row->product_id,$finish_row->finish_id);
						$row['Sr no']						=	$no;
						$consige_name 						=  $sup_data->company_name;
						$row['Supplier Name'] 				= 	$consige_name;
						$row['Product Name']				= 	$product_name;
						$row['Finish Name']					=	$finish_row->finish_name;
						$row['Price']						=	 $deisgn_rate_data->design_rate;
						$row['design_suppiler_rate_id']		=	 $deisgn_rate_data->design_suppiler_rate_id;
						 
						array_push($data,$row);
						$no++;
					}
				}
				else
				{
					$deisgn_rate_data = $this->customer->get_design_suppiler_rate($sup_data->supplier_id,$product_row->product_id,$finish_row->finish_id);
					$consige_name =  $sup_data->company_name;
					$row['Sr no']						=	$no;
					$row['Supplier Name'] 				= 	$consige_name;
					$row['Supplier Name'] 				= 	$consige_name;
					$row['Product Name']				= 	$product_name;
					$row['Finish Name']					=	'';
					$row['Price']						=	 $deisgn_rate_data->design_rate;
					$row['design_suppiler_rate_id']		=	 $deisgn_rate_data->design_suppiler_rate_id;
			 	 
				array_push($data,$row);
					$no++;
				}
				
			 
		}
		$str .= '</table>';
		 $consige_name =  $sup_data->company_name;
		$fileName_1 = $consige_name.'_design_rate.csv';
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName_1}");
        header("Expires: 0");
        header("Pragma: public");
        $fh1 = @fopen( 'php://output', 'w' );
        $headerDisplayed1 = false;
        foreach ( $data as $data1 ) {
            // Add a header row if it hasn't been added yet
            if ( !$headerDisplayed1 ) {
                // Use the keys from $data as the titles
                fputcsv($fh1, array_keys($data1));
                $headerDisplayed1 = true;
            }
            // Put the data into the stream
            fputcsv($fh1, $data1);
        }
    // Close the file
        fclose($fh1);
    // Make sure nothing else is sent, our file is done
        exit;
		 
	}
	public function import_sup_price()
	{
		//ignore_user_abort(true);
		set_time_limit(0);
		error_reporting(0);
		$row = array();
		if($_FILES['import_file']['name'] != "" )	
		{
			 $path = './upload/csv/';
			 unlink($path."pricefile.csv");
			$this->load->library('upload');
		 	$this->upload->initialize($this->set_upload_options1('pricefile',$_FILES['import_file']['name'],$path));
			$this->upload->do_upload('import_file');
			$upload_image = $this->upload->data();
			$data['file_name']  = $upload_image['file_name'];
			 
			if(!empty($data['file_name']))
			{
				$file = fopen($path.$data['file_name'], 'r');
				 
				$fields = fgetcsv($file);
				 
				if(count($fields)==6)
				{
					$farray = array("Sr no","Supplier Name","Product Name","Finish Name","Price",'design_suppiler_rate_id');
					 
				 	if($fields == $farray)
					{
					 	$line_no = 2;
						$error = array();
						$error_line = array();
					 	while(($row = fgetcsv($file)) != false ) 
						{        
						 	$error_array = '';
							$complete_status = '';
							if(!empty(trim($row[0])))
							{ 
								$checkcustomer = $this->customer->check_sup($this->input->post('import_supplier_id'),$row[1]);
								if(!empty($checkcustomer))
								{
									$check_finish = $this->customer->getfinish($row[3]);
									
									$check_product = $this->customer->get_product($row[2]);
									
									$data=array(
										'supplier_id' 		=> $this->input->post('import_supplier_id'),
										'design_rate' 		=> $row[4],
										'finish_id' 		=> $check_finish->finish_id,
										'product_id' 		=> $check_product->product_id,
										'cdate'		 		=> date('d-m-Y H:i:s'),
										'status' 			=> 0
									);
									 
									 $design_suppiler_rate_id = $row[5];
										if($design_suppiler_rate_id > 0)
										{
											$insert_id = $this->customer->update_sup_design_rate($data,$design_suppiler_rate_id);
												 
										}
										else{
											$insert_id = $this->customer->insert_sup_design_rate($data);
										}
										 
								}
								else
								{
										$error_array = "Customer Wrong.";
										$complete_status = 1;
								}
							}
							else
							{
									$error_array = "Blank Row.";
									$complete_status = 1;
							}
						   array_push($error,$error_array);
						   array_push($error_line,$line_no);
						 $line_no++;
					}
						fclose($file);
					  
					 if(empty($error_array))
					 {
					 	 $row['res'] = 1;
					 }
					 else
					 {
						  $row['res'] = 4;
						  $str = '<table class="table table-bordered" width="100%"> 
									<tr>
										<td>Line No</td>
										<td>Error</td>
									</tr>
								';
								for($e=0;$e<count($error);$e++)
								{
									$str .= '
										<tr>
											<td>'.$error_line[$e].'</td>
											<td>'.$error[$e].'</td>
										</tr>
									';
									
								}
							$str .= '</table>';
						  $row['error_html'] =$str; 
					 }
					}
					else
					{
						$row['res'] = 3;
					}
				}
				else
				{
					$row['res'] = 2;
				}
			} 
			else
			{
				$row['res'] = 0;
			}
	 	}
		else
		{
			$row['res'] = 0;
		}
		
		echo json_encode($row);
		 
	}
	
	
}

?>