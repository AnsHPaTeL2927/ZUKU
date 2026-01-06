<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Add_product extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		 
		$this->load->model('admin_product_list','product');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
        redirect(base_url());
        }
	}

	public function index(){

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {	
			$seriesdata = $this->product->seriesdata(); 
			$data1 = $this->product->select_config();
			$this->load->model('admin_company_detail');
 			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(	'config'=>$data1,
						'company_detail'=>$this->admin_company_detail->s_select(),
						"mode"=>"Add",
						"seriesdata"=>$seriesdata,
						"menu_data"=>$menu_data,
						"seriesgroupdata"=>$seriesgroupdata,
						'hsnc_data'=>$this->product->hsncdata()
					);
			$this->load->view('admin/add-product',$v);
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }
	}
	 
	public function displaydatanew()
	{
		  $id=$this->input->post('id');
		  $resultset = $this->calc->select_hsnc_product_size($id);
		  
		  if(!empty($resultset))
		  {
			  $contentdata = "";	
			  $result=$resultset[0];
				$checked1 =  ($result->pallet_status==1)?"checked":"";
				$checked2 =  ($result->pallet_status==2)?"checked":"";
				$display1 =  '';
				if($result->pallet_status==1)
				{
					$display1 =' 
										<tr class="pallet_calcution">
											<th>BOXES PER PALLET</th>
											<td id="third">
												<input type="text" value="'.$result->boxperplt.'" name="boxperplt" id="boxperplt" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr class="pallet_calcution">
											<th>NO OF PALLET IN CONTAINER</th>
											<td id="forth">
												<input type="text" value="'.$result->nopltcontainer.'" name="nopltcontainer" id="nopltcontainer" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr class="pallet_calcution">
											<th>Empty Pallet Weight</th>
											<td id="forth">
												<input type="text" value="'.$result->plat_weight.'" name="plat_weight" id="plat_weight" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
									 
										<tr class="boxes_calculation" style="display:none">
											<th>Total Boxes Per Container</th>
											<td>
												<input type="text" id="total_boxes" name="total_boxes" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="'.$result->total_boxes.'"   />
											</td>
										</tr>
										 
										 ';
				} 
				else if($result->pallet_status==2)
				{
					$display2 =  '
						<tr class="pallet_calcution" style="display:none">
											<th>BOXES PER PALLET</th>
											<td id="third">
												<input type="text" value="'.$result->boxperplt.'" name="boxperplt" id="boxperplt" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr class="pallet_calcution" style="display:none">
											<th>NO OF PALLET IN CONTAINER</th>
											<td id="forth">
													<input type="text" value="'.$result->nopltcontainer.'" name="nopltcontainer" id="nopltcontainer" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr class="pallet_calcution" style="display:none">
											<th>Empty Pallet Weight</th>
											<td id="forth">
													<input type="text" value="'.$result->plat_weight.'" name="plat_weight" id="plat_weight" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
								 
										<tr class="boxes_calculation">
											<th>Total Boxes Per Container</th>
											<td>
												<input type="text" id="total_boxes" name="total_boxes" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="'.$result->total_boxes.'"   />
											</td>
										</tr>
										 ';
				}
			  $hsnc_code = $this->input->post('hsnc_code');
			  if($hsnc_code == '69072300')
			  {
				  $contentdata .= '<input type="hidden" name="size_type_mm" id="size_type_mm" width="100" value="'.$result->size_type_mm.'">
									<input type="hidden" name="size_type_cm" id="size_type_cm" width="100" value="'.$result->size_type_cm.'">
									<input type="hidden" name="size_width_mm" id="size_width_mm" width="100" value="'.$result->size_width_mm.'">
									<input type="hidden" name="size_width_cm" id="size_width_cm" width="100" value="'.$result->size_width_cm.'">
									<input type="hidden" name="size_height_mm" id="size_height_mm" width="100" value="'.$result->size_height_mm.'">
									<input type="hidden" name="size_height_cm" id="size_height_cm" width="100" value="'.$result->size_height_cm.'">
									<input type="hidden" name="sqmprice" id="sqmprice" value="'.$result->sqmprice.'">
									<input type="hidden" name="priceperbox" id="priceperbox" width="100" value="'.$result->priceperbox.'">
									<input type="hidden" name="pricetypehide" id="pricetypehide" width="100" value="'.$result->pricetype.'">
										<tr>
											<th>Product Size With</th>
											<td>
												 '.$result->size_type_mm.'
											</td>
										</tr>
						 
										<tr>
											<th>PCS PER BOX</th>
											<td id="first2">
												<input type="text" value="'.$result->pcsperbox.'" name="pcsperbox" id="pcsperbox" width="100" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr>
											<th>APPROX WEIGHT PER BOX</th>
											<td id="second"> 
												<input type="text" value="'.$result->apwigtperbox.'" name="apwigtperbox" id="apwigtperbox" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr>
											<th>	With/Without Pallet </th>
											<td> 
												<label class="radio-inline">
													<input type="radio" name="pallet_status" id="pallet_status1" value="1" '.$checked1.' onclick="check_pallet(this.value)"  >With Pallet 
												</label>
												<label class="radio-inline">
													<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet(this.value)" '.$checked2.'>Without Pallet
												</label>
											</td>
										</tr>
										'.$display1.'
										'.$display2.'
										<tr>
											<th>APPROX SQM PER BOX</th>
											<td>
												<span id="appsqmperbox_html">'.$result->appsqmperbox.'</span>
												<input type="hidden" value="'.$result->appsqmperbox.'" name="appsqmperbox" id="appsqmperbox" readonly> 
												<input type="hidden" value="'.$result->appsqmperbox_new_cm.'" name="appsqmperboxcm" id="appsqmperboxcm" readonly>
											</td>
										</tr>
										<tr>
											<th>BOXES PER CONTAINER</th>
											<td>
												<span id="boxpercontain_html">'.$result->boxpercontain.'</span>
												<input type="hidden" value="'.$result->boxpercontain.'" name="boxpercontain" id="boxpercontain" readonly> 
											</td>
										</tr>
										<tr>
											<th>SQM PER container</th>
											<td>
												<span id="sqmpercontain_html">'.$result->sqmpercontain.'</span>
												<input type="hidden" value="'.$result->sqmpercontain.'" name="sqmpercontain" id="sqmpercontain" readonly> 
												<input type="hidden" value="'.$result->sqmpercontain_new_cm.'" name="sqmpercontaincm" id="sqmpercontaincm" readonly>
											</td>
										</tr>
										 
										<tr>
											<th>APPROX NET WEIGHT PER CONTIANER </th>
											<td>
												<span id="appwegtpercon_html">'.$result->appwegtpercon.'</span>
												<input type="hidden" value="'.$result->appwegtpercon.'" name="appwegtpercon" id="appwegtpercon" readonly> 
											</td>
										</tr>
										<tr>
											<th>APPROX GROSS WEIGHT PER CONTIANER</th>
											<td>
												<span id="appgrswetpercon_html">'.$result->appgrswetpercon.'</span>
												<input type="hidden" value="'.$result->appgrswetpercon.'" name="appgrswetpercon" id="appgrswetpercon" readonly>
											</td>
										</tr>
						  ';
			  }
			  elseif ($hsnc_code == '69072200') {
	
					$contentdata .= '<input type="hidden" name="size_type_mm" id="size_type_mm" width="100" value="'.$result->size_type_mm.'">
									<input type="hidden" name="size_type_cm" id="size_type_cm" width="100" value="'.$result->size_type_cm.'">
									<input type="hidden" name="size_width_mm" id="size_width_mm" width="100" value="'.$result->size_width_mm.'">
									<input type="hidden" name="size_width_cm" id="size_width_cm" width="100" value="'.$result->size_width_cm.'">
									<input type="hidden" name="size_height_mm" id="size_height_mm" width="100" value="'.$result->size_height_mm.'">
									<input type="hidden" name="size_height_cm" id="size_height_cm" width="100" value="'.$result->size_height_cm.'">
									<input type="hidden" name="sqmprice" id="sqmprice" value="'.$result->sqmprice.'">
									<input type="hidden" name="priceperbox" id="priceperbox" width="100" value="'.$result->priceperbox.'">
									<input type="hidden" name="pricetypehide" id="pricetypehide" width="100" value="'.$result->pricetype.'">
										<tr>
											<th>Product Size With</th>
											<td>
												 '.$result->size_type_mm.'
											</td>
										</tr>
						 
										<tr>
											<th>PCS PER BOX</th>
											<td id="first2">
												<input type="text" value="'.$result->pcsperbox.'" name="pcsperbox" id="pcsperbox" width="100" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr>
											<th>APPROX WEIGHT PER BOX</th>
											<td id="second"> 
												<input type="text" value="'.$result->apwigtperbox.'" name="apwigtperbox" id="apwigtperbox" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr>
											<th>	With/Without Pallet </th>
											<td> 
												<label class="radio-inline">
													<input type="radio" name="pallet_status" id="pallet_status1" value="1" '.$checked1.' onclick="check_pallet(this.value)"  >With Pallet 
												</label>
												<label class="radio-inline">
													<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet(this.value)" '.$checked2.'>Without Pallet
												</label>
											</td>
										</tr>
										'.$display1.'
										'.$display2.'
										<tr>
											<th>APPROX SQM PER BOX</th>
											<td>
												<span id="appsqmperbox_html">'.$result->appsqmperbox.'</span>
												<input type="hidden" value="'.$result->appsqmperbox.'" name="appsqmperbox" id="appsqmperbox" readonly> 
												<input type="hidden" value="'.$result->appsqmperbox_new_cm.'" name="appsqmperboxcm" id="appsqmperboxcm" readonly>
											</td>
										</tr>
										<tr>
											<th>BOXES PER CONTAINER</th>
											<td>
												<span id="boxpercontain_html">'.$result->boxpercontain.'</span>
												<input type="hidden" value="'.$result->boxpercontain.'" name="boxpercontain" id="boxpercontain" readonly> 
											</td>
										</tr>
										<tr>
											<th>SQM PER container</th>
											<td>
												<span id="sqmpercontain_html">'.$result->sqmpercontain.'</span>
												<input type="hidden" value="'.$result->sqmpercontain.'" name="sqmpercontain" id="sqmpercontain" readonly> 
												<input type="hidden" value="'.$result->sqmpercontain_new_cm.'" name="sqmpercontaincm" id="sqmpercontaincm" readonly>
											</td>
										</tr>
										 
										<tr>
											<th>APPROX NET WEIGHT PER CONTIANER </th>
											<td>
												<span id="appwegtpercon_html">'.$result->appwegtpercon.'</span>
												<input type="hidden" value="'.$result->appwegtpercon.'" name="appwegtpercon" id="appwegtpercon" readonly> 
											</td>
										</tr>
										<tr>
											<th>APPROX GROSS WEIGHT PER CONTIANER</th>
											<td>
												<span id="appgrswetpercon_html">'.$result->appgrswetpercon.'</span>
												<input type="hidden" value="'.$result->appgrswetpercon.'" name="appgrswetpercon" id="appgrswetpercon" readonly>
											</td>
										</tr>
						 
					';


			}
		      elseif ($hsnc_code == '69072100') {
	
					$contentdata .= '<input type="hidden" name="size_type_mm" id="size_type_mm" width="100" value="'.$result->size_type_mm.'">
									<input type="hidden" name="size_type_cm" id="size_type_cm" width="100" value="'.$result->size_type_cm.'">
									<input type="hidden" name="size_width_mm" id="size_width_mm" width="100" value="'.$result->size_width_mm.'">
									<input type="hidden" name="size_width_cm" id="size_width_cm" width="100" value="'.$result->size_width_cm.'">
									<input type="hidden" name="size_height_mm" id="size_height_mm" width="100" value="'.$result->size_height_mm.'">
									<input type="hidden" name="size_height_cm" id="size_height_cm" width="100" value="'.$result->size_height_cm.'">
									<input type="hidden" name="sqmprice" id="sqmprice" value="'.$result->sqmprice.'">
									<input type="hidden" name="priceperbox" id="priceperbox" width="100" value="'.$result->priceperbox.'">
									<input type="hidden" name="pricetypehide" id="pricetypehide" width="100" value="'.$result->pricetype.'">
										<tr>
											<th>Product Size With</th>
											<td>
												 '.$result->size_type_mm.'
											</td>
										</tr>
						 
										<tr>
											<th>PCS PER BOX</th>
											<td id="first2">
												<input type="text" value="'.$result->pcsperbox.'" name="pcsperbox" id="pcsperbox" width="100" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr>
											<th>APPROX WEIGHT PER BOX</th>
											<td id="second"> 
												<input type="text" value="'.$result->apwigtperbox.'" name="apwigtperbox" id="apwigtperbox" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" >
											</td>
										</tr>
										<tr>
											<th>	With/Without Pallet </th>
											<td> 
												<label class="radio-inline">
													<input type="radio" name="pallet_status" id="pallet_status1" value="1" '.$checked1.' onclick="check_pallet(this.value)"  >With Pallet 
												</label>
												<label class="radio-inline">
													<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet(this.value)" '.$checked2.'>Without Pallet
												</label>
											</td>
										</tr>
										'.$display1.'
										'.$display2.'
										<tr>
											<th>APPROX SQM PER BOX</th>
											<td>
												<span id="appsqmperbox_html">'.$result->appsqmperbox.'</span>
												<input type="hidden" value="'.$result->appsqmperbox.'" name="appsqmperbox" id="appsqmperbox" readonly> 
												<input type="hidden" value="'.$result->appsqmperbox_new_cm.'" name="appsqmperboxcm" id="appsqmperboxcm" readonly>
											</td>
										</tr>
										<tr>
											<th>BOXES PER CONTAINER</th>
											<td>
												<span id="boxpercontain_html">'.$result->boxpercontain.'</span>
												<input type="hidden" value="'.$result->boxpercontain.'" name="boxpercontain" id="boxpercontain" readonly> 
											</td>
										</tr>
										<tr>
											<th>SQM PER container</th>
											<td>
												<span id="sqmpercontain_html">'.$result->sqmpercontain.'</span>
												<input type="hidden" value="'.$result->sqmpercontain.'" name="sqmpercontain" id="sqmpercontain" readonly> 
												<input type="hidden" value="'.$result->sqmpercontain_new_cm.'" name="sqmpercontaincm" id="sqmpercontaincm" readonly>
											</td>
										</tr>
										 
										<tr>
											<th>APPROX NET WEIGHT PER CONTIANER </th>
											<td>
												<span id="appwegtpercon_html">'.$result->appwegtpercon.'</span>
												<input type="hidden" value="'.$result->appwegtpercon.'" name="appwegtpercon" id="appwegtpercon" readonly> 
											</td>
										</tr>
										<tr>
											<th>APPROX GROSS WEIGHT PER CONTIANER</th>
											<td>
												<span id="appgrswetpercon_html">'.$result->appgrswetpercon.'</span>
												<input type="hidden" value="'.$result->appgrswetpercon.'" name="appgrswetpercon" id="appgrswetpercon" readonly>
											</td>
										</tr>
					 
					';
				}

		  }
		   echo $contentdata;
	}
	 
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->calc->delete_calc($id);
			
		if($deleterecord)
		{
			$row['res'] = '1';
		}
		else{
			$row['res'] = '0';
		}
		echo json_encode($row);
	}
	public function edit($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$productdata = $this->product->productdata($id); 
			$seriesdata = $this->product->seriesdata(); 
	
			$data1 = $this->product->select_config();
			$this->load->model('admin_company_detail');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array('config'=>$data1,'company_detail'=>$this->admin_company_detail->s_select(),"mode"=>"Edit","seriesdata"=>$seriesdata,"seriesgroupdata"=>$seriesgroupdata,"edit_record"=>$productdata,"productsize_record"=>$this->product->getproductpacking_detail($id),'menu_data'=>$menu_data);
			$this->load->view('admin/add-product',$v);
		}
		else
		{
			
			redirect(base_url().'');
		}
	}
	public function add_packing_detail($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$productdata = $this->product->productdata($id); 
			$seriesdata = $this->product->seriesdata(); 
			
			$data1 = $this->product->select_config();
			$this->load->model('admin_company_detail');	
				$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
					'config'=>$data1,
					'company_detail'=>$this->admin_company_detail->s_select(),
					"mode"=>"packing",
					"seriesdata"=>$seriesdata,
					"menu_data"=>$menu_data,
					"seriesgroupdata"=>$seriesgroupdata,
					"product_data"=>$productdata,
				);
			$this->load->view('admin/add-product',$v);
		}
		else
		{
			
			redirect(base_url().'');
		}
	}
	public function edit_packing_detail($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$productsize_data 	=  $this->product->getproductpacking_detail($id);
			$productdata 		=  $this->product->productdata($productsize_data->product_id); 
			$seriesdata 		=  $this->product->seriesdata(); 
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$data1 = $this->product->select_config();
			$this->load->model('admin_company_detail');	
			$v = array(
					'config'				=> $data1,
					'company_detail'		=> $this->admin_company_detail->s_select(),
					"mode"					=> "packing",
					"seriesdata"			=> $seriesdata,
					"menu_data"				=> $menu_data,
					"seriesgroupdata"		=> $seriesgroupdata,
					"productsize_record"	=> $productsize_data,
					"product_data"			=> $productdata,
				);
			$this->load->view('admin/add-product',$v);
		}
		else
		{
			
			redirect(base_url().'');
		}
	}
	public function getproductdata()
	{
		$id = $this->input->post('productid');
		$productdata = $this->product->productdata($id); 
		echo json_encode($productdata);
	}
	 
	 public function fetchseriesdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->product->fetchgroupdata($id);
		 
		echo json_encode($resultdata);
	}
	public function edit_grouprecord()
	{
		$data = array(
			'seriesgroup_name' 	 => $this->input->post('edit_series_name'),
			'group_rate'		 => $this->input->post('edit_rate'),
			'series_id'		 	 => $this->input->post('edit_series_id'),
			'product_id'		 => $this->input->post('edit_product_id'),
			 'status' 			 => 0,
			'cdate' 			 => date('Y-m-d H:i:s')
		);
		
			$id = $this->input->post('eid');
			$updatedid = $this->product->updatemodeldata($data,$id);
			if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['seriesgroup_name'] = $this->input->post('edit_series_name');
				 $row['group_rate'] = $this->input->post('edit_rate');
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] = 0;
				 $row['seriesgroup_name'] = 0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
		
	}
	public function deletegrouprecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->product->deletegrouprecord($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetch_group_record()
	{ 
	
		 
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.seriesgroup_id','pro.size_type_mm','series.series_name','pro.thickness','mst.seriesgroup_name','mst.group_rate','mst.status','(SELECT count(*) FROM `tbl_packing_model` where seriesgroup_id = mst.seriesgroup_id) as total_cnt');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_seriesgroup as mst";
		 $isJOIN = array(
						 'left join tbl_product as pro on pro.product_id=mst.product_id',
						 'left join tbl_series as series on series.series_id=pro.series_id'
						 );
		 $hOrder = "mst.seriesgroup_id desc";
			$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
				 
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
					$thickness = (!empty($row->thickness))?' - '.$row->thickness.' MM':"";
					$row_data[] = $row->size_type_mm.' ('.$row->series_name.')'.$thickness;
					$row_data[] = $row->seriesgroup_name ;
					$row_data[] = $row->group_rate ;
					 
					$delete_btn = '';
					if($row->total_cnt==0)
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->seriesgroup_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					}			 
					 $actionbtn = '<li>
										<a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->seriesgroup_id.');"><i class="fa fa-pencil"></i>Edit</a>
									</li>
								'.$delete_btn;
					 
					$row_data[] = '<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
											  <ul class="dropdown-menu">
												'.$actionbtn.'
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
}


?>