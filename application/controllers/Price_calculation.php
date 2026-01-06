<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Price_calculation extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_calculation','calc');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index(){

		if( $this->session->id == 1 && $this->session->title == TITLE)
		{
			//$data['result'] = $this->calc->select_hsnc();
			$data = $this->calc->select_hsnc();
			$data1 = $this->calc->select_config();
			$this->load->model('admin_company_detail');	
			$v = array('config'=>$data1,'result'=>$data,'company_detail'=>$this->admin_company_detail->s_select());
			$this->load->view('admin/price_calculation',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function editprice(){

		if( $this->session->id == 1 && $this->session->title == TITLE)
		{ 
			$data = $this->calc->select_hsnc();
			$data1 = $this->calc->select_config();
			$this->load->model('admin_company_detail');	
			$request_id = $this->uri->segment('3');
			$this->load->model('settingmodel');
			$v = array('config'=>$data1,'result'=>$data,'company_detail'=>$this->admin_company_detail->s_select(),'edit_record'=>$this->calc->b_form_edit($request_id),"mode"=>"Edit","maindetail"=>$this->settingmodel->afetrlogin($this->session->id));
			$this->load->view('admin/editprice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	public function displaydataprice()
	{
		$id=$this->input->post('id');
		$data1 = $this->calc->ciadmin_login();
		$resultset = $this->calc->select_hsnc_product_size($id);
		 $contentdata = "";
		  if(!empty($resultset))
		  {
				$result=$resultset[0];
				if($result->pallet_status==1)
				{
					$display1 ='<tr  class="pallet_calcution">
									<th>Boxes Per Pallet</th>
									<td id="third">
										<input class="priceinput" readonly type="text" value="'.$result->boxperplt.'" name="boxperplt" id="boxperplt">
									</td>
								</tr>
								<tr  class="pallet_calcution">
									<th>No Of Pallet In Container</th>
									<td id="forth">
										<input class="priceinput" readonly type="text" value="'.$result->nopltcontainer.'" name="nopltcontainer" id="nopltcontainer">
									</td>
								</tr>
								<tr  class="pallet_calcution">
									<th>Pallet Weight</th>
									<td id="forth">
										<input class="priceinput" type="text" value="'.$result->plat_weight.'" name="plat_weight" id="plat_weight" readonly>
									</td>
								</tr>
								 <tr class="boxes_calculation" style="display:none">
											<th>Total Boxes Per Container</th>
											<td>
												<input type="text" id="total_boxes" name="total_boxes"  class="priceinput" value="'.$result->total_boxes.'"   />
											</td>
										</tr>
										 
										 ';
				} 
				else if($result->pallet_status==2)
				{
					$display1 =  '
						<tr class="pallet_calcution" style="display:none">
							<th>Boxes Per Pallet</th>
							<td id="third">
								<input class="priceinput" readonly type="text" value="'.$result->boxperplt.'" name="boxperplt" id="boxperplt">
							</td>
						</tr>
						<tr class="pallet_calcution" style="display:none">
							<th>No Of Pallet In Container</th>
							<td id="forth">
								<input class="priceinput" readonly type="text" value="'.$result->nopltcontainer.'" name="nopltcontainer" id="nopltcontainer">
							</td>
						</tr>
						<tr class="pallet_calcution" style="display:none">
							<th>Pallet Weight</th>
							<td id="forth">
								<input class="priceinput" type="text" value="'.$result->plat_weight.'" name="plat_weight" id="plat_weight" readonly>
							</td>
						</tr>
						 <tr class="boxes_calculation">
							<th>Total Boxes Per Container</th>
							<td>
								<input type="text" id="total_boxes" class="priceinput" name="total_boxes" placeholder="" class="form-control" onkeypress="return isNumber(event)"  value="'.$result->total_boxes.'"   />
							</td>
						</tr>
										 ';
				}
			 
			    $hsnc_code = $this->input->post('hsnc_code');
				$price=$result->sqmprice;
				$usd=$price/$data1->usd;
				$euro=$price/$data1->euro;
				if($hsnc_code == '69072300')
				{
					$contentdata .= '<input type="hidden" name="size_type_mm" id="size_type_mm" width="100" value="'.$result->size_type_mm.'">
					<input type="hidden" name="size_type_cm" id="size_type_cm" width="100" value="'.$result->size_type_cm.'">
					<input type="hidden" name="size_width_mm" id="size_width_mm" width="100" value="'.$result->size_width_mm.'">
					<input type="hidden" name="size_width_cm" id="size_width_cm" width="100" value="'.$result->size_width_cm.'">
					<input type="hidden" name="size_height_mm" id="size_height_mm" width="100" value="'.$result->size_height_mm.'">
					<input type="hidden" name="size_height_cm" id="size_height_cm" width="100" value="'.$result->size_height_cm.'">
						<tr>
							<th>Product Size With</th>
							<td id="fifth1">
								'.$result->size_type_mm.'
							</td>
						</tr>
						<tr>
							<th>Pcs Per Box</th>
							<td id="first">
								<input class="priceinput" readonly type="text" value="'.$result->pcsperbox.'" name="pcsperbox" id="pcsperbox" width="100">
							</td>
						</tr>
						<tr>
							<th>Approx Weight Per Box</th>
							<td id="second"> 
								<input class="priceinput" readonly type="text" value="'.$result->apwigtperbox.'" name="apwigtperbox" id="apwigtperbox">
							</td>
						</tr>
						<tr>
							<th>Approx Sqm Per Box </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appsqmperbox.'" name="appsqmperbox" id="appsqmperbox" readonly> 
								<input class="hidden" readonly type="text" value="'.$result->appsqmperbox_new_cm.'" name="appsqmperboxcm" id="appsqmperboxcm" readonly> 
								
							</td>
						</tr>
						 
						
						<tr>
							<th>Boxes Per Pallet</th>
							<td id="third">
								<input class="priceinput" readonly type="text" value="'.$result->boxperplt.'" name="boxperplt" id="boxperplt">
							</td>
						</tr>
						<tr>
							<th>No Of Pallet In Container</th>
							<td id="forth">
								<input class="priceinput" readonly type="text" value="'.$result->nopltcontainer.'" name="nopltcontainer" id="nopltcontainer">
							</td>
						</tr>
						<tr>
							<th>Pallet Weight</th>
							<td id="forth">
								<input class="priceinput" type="text" value="'.$result->plat_weight.'" name="plat_weight" id="plat_weight" readonly>
							</td>
						</tr>
						
						<tr>
							<th>Boxes Per Container</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->boxpercontain.'" name="boxpercontain" id="boxpercontain" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Sqm Per Container </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->sqmpercontain.'" name="sqmpercontain" id="sqmpercontain" readonly>&nbsp;&nbsp;&nbsp; 
								<input class="priceinput" type="hidden" value="'.$result->sqmpercontain_new_cm.'" name="sqmpercontaincm" id="sqmpercontaincm" readonly> 
							</td>
						</tr>
					 
						<tr>
							<th>Approx Net Weight Per Container </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appwegtpercon.'" name="appwegtpercon" id="appwegtpercon" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Approx Gross Weight Per Container</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appgrswetpercon.'" name="appgrswetpercon" id="appgrswetpercon" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Price </th>
							<td>
								<input type="text" onkeyup="cal_price()"  value="'.$result->priceperbox.'" name="priceperbox" id="priceperbox" >
								<input type="hidden" value="'.$result->pricetype.'" name="pricetypehide1" id="pricetypehide1" >

								<select class="selectdropdown" name="price_type" id="price_type" onchange="price_cal(this.value)">
								<option >Select Price per</option>
								<option value="Feet"'. ($result->pricetype === "Feet" ? "selected" : "").'>Feet</option>
								<option value="Box" '. ($result->pricetype === "Box" ? "selected" : "").'>Box</option>
								<option value="SQM" '. ($result->pricetype === "SQM" ? "selected" : "").'>SQM</option>
								</select>
								
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Rs</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->sqmprice.'" name="sqmprice" id="sqmprice" readonly>&nbsp;&nbsp;								
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Usd</th>
							<td>
							<input class="priceinput" type="text" value="'.number_format((float)$usd, 2, '.', '').'" name="sqmprice_usd" id="sqmprice_usd" readonly>&nbsp;&nbsp;	
							<input type="hidden" value="'.$data1->usd.'" name="usd_price" id="usd_price" readonly> 
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Euro</th>
							<td>
							<input class="priceinput" type="text" value="'.number_format((float)$euro, 2, '.', '').'" name="sqmprice_euro" id="sqmprice_euro" readonly>&nbsp;&nbsp;	
							<input type="hidden" value="'.$data1->euro.'" name="euro_price" id="euro_price" readonly> 
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
						<tr>
							<th>Product Size With</th>
							<td id="fifth1">
								'.$result->size_type_mm.'
							</td>
						</tr>
						<tr>
							<th>Pcs Per Box</th>
							<td id="first">
								<input class="priceinput" readonly type="text" value="'.$result->pcsperbox.'" name="pcsperbox" id="pcsperbox" width="100">
							</td>
						</tr>
						<tr>
							<th>Approx Weight Per Box</th>
							<td id="second"> 
								<input class="priceinput" readonly type="text" value="'.$result->apwigtperbox.'" name="apwigtperbox" id="apwigtperbox">
							</td>
						</tr>
						<tr>
							<th>Approx Sqm Per Box </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appsqmperbox.'" name="appsqmperbox" id="appsqmperbox" readonly> 
								<input class="hidden" readonly type="text" value="'.$result->appsqmperbox_new_cm.'" name="appsqmperboxcm" id="appsqmperboxcm" readonly> 
								
							</td>
						</tr>
						 
						
						<tr>
							<th>Boxes Per Pallet</th>
							<td id="third">
								<input class="priceinput" readonly type="text" value="'.$result->boxperplt.'" name="boxperplt" id="boxperplt">
							</td>
						</tr>
						<tr>
							<th>No Of Pallet In Container</th>
							<td id="forth">
								<input class="priceinput" readonly type="text" value="'.$result->nopltcontainer.'" name="nopltcontainer" id="nopltcontainer">
							</td>
						</tr>
						<tr>
							<th>Pallet Weight</th>
							<td id="forth">
								<input class="priceinput" type="text" value="'.$result->plat_weight.'" name="plat_weight" id="plat_weight" readonly>
							</td>
						</tr>
						
						<tr>
							<th>Boxes Per Container</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->boxpercontain.'" name="boxpercontain" id="boxpercontain" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Sqm Per Container </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->sqmpercontain.'" name="sqmpercontain" id="sqmpercontain" readonly>&nbsp;&nbsp;&nbsp; 
								<input class="priceinput" type="hidden" value="'.$result->sqmpercontain_new_cm.'" name="sqmpercontaincm" id="sqmpercontaincm" readonly> 
							</td>
						</tr>
					 
						<tr>
							<th>Approx Net Weight Per Container </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appwegtpercon.'" name="appwegtpercon" id="appwegtpercon" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Approx Gross Weight Per Container</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appgrswetpercon.'" name="appgrswetpercon" id="appgrswetpercon" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Price </th>
							<td>
								<input type="text" onkeyup="cal_price()"  value="'.$result->priceperbox.'" name="priceperbox" id="priceperbox" >
								<input type="hidden" value="'.$result->pricetype.'" name="pricetypehide1" id="pricetypehide1" >

								<select class="selectdropdown" name="price_type" id="price_type" onchange="price_cal(this.value)">
								<option >Select Price per</option>
								<option value="Feet"'. ($result->pricetype === "Feet" ? "selected" : "").'>Feet</option>
								<option value="Box" '. ($result->pricetype === "Box" ? "selected" : "").'>Box</option>
								<option value="SQM" '. ($result->pricetype === "SQM" ? "selected" : "").'>SQM</option>
								</select>
								
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Rs</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->sqmprice.'" name="sqmprice" id="sqmprice" readonly>&nbsp;&nbsp;								
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Usd</th>
							<td>
							<input class="priceinput" type="text" value="'.number_format((float)$usd, 2, '.', '').'" name="sqmprice_usd" id="sqmprice_usd" readonly>&nbsp;&nbsp;	
							<input type="hidden" value="'.$data1->usd.'" name="usd_price" id="usd_price" readonly> 
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Euro</th>
							<td>
							<input class="priceinput" type="text" value="'.number_format((float)$euro, 2, '.', '').'" name="sqmprice_euro" id="sqmprice_euro" readonly>&nbsp;&nbsp;	
							<input type="hidden" value="'.$data1->euro.'" name="euro_price" id="euro_price" readonly> 
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
						<tr>
							<th>Product Size With</th>
							<td id="fifth1">
								'.$result->size_type_mm.'
							</td>
						</tr>
						<tr>
							<th>Pcs Per Box</th>
							<td id="first">
								<input class="priceinput" readonly type="text" value="'.$result->pcsperbox.'" name="pcsperbox" id="pcsperbox" width="100">
							</td>
						</tr>
						<tr>
							<th>Approx Weight Per Box</th>
							<td id="second"> 
								<input class="priceinput" readonly type="text" value="'.$result->apwigtperbox.'" name="apwigtperbox" id="apwigtperbox">
							</td>
						</tr>
						<tr>
							<th>Approx Sqm Per Box </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appsqmperbox.'" name="appsqmperbox" id="appsqmperbox" readonly> 
								<input class="hidden" readonly type="text" value="'.$result->appsqmperbox_new_cm.'" name="appsqmperboxcm" id="appsqmperboxcm" readonly> 
								
							</td>
						</tr>
						'.$display1.'
						
						<tr>
							<th>Boxes Per Container</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->boxpercontain.'" name="boxpercontain" id="boxpercontain" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Sqm Per Container </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->sqmpercontain.'" name="sqmpercontain" id="sqmpercontain" readonly>&nbsp;&nbsp;&nbsp; 
								<input class="priceinput" type="hidden" value="'.$result->sqmpercontain_new_cm.'" name="sqmpercontaincm" id="sqmpercontaincm" readonly> 
							</td>
						</tr>
					 
						<tr>
							<th>Approx Net Weight Per Container </th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appwegtpercon.'" name="appwegtpercon" id="appwegtpercon" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Approx Gross Weight Per Container</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->appgrswetpercon.'" name="appgrswetpercon"  id="appgrswetpercon" readonly>&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<th>Price </th>
							<td>
								<input type="text" onkeyup="cal_price()" value="'.$result->priceperbox.'" name="priceperbox" id="priceperbox" >
								<input type="hidden" value="'.$result->pricetype.'" name="pricetypehide1" id="pricetypehide1" >

								<select class="selectdropdown" name="price_type" id="price_type" onchange="price_cal(this.value)">
								<option >Select Price per</option>
								<option value="Feet"'. ($result->pricetype === "Feet" ? "selected" : "").'>Feet</option>
								<option value="Box" '. ($result->pricetype === "Box" ? "selected" : "").'>Box</option>
								<option value="SQM" '. ($result->pricetype === "SQM" ? "selected" : "").'>SQM</option>
								</select>
								
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Rs</th>
							<td>
								<input class="priceinput" type="text" value="'.$result->sqmprice.'" name="sqmprice" id="sqmprice" readonly>&nbsp;&nbsp;								
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Usd</th>
							<td>
							<input class="priceinput" type="text" value="'.number_format((float)$usd, 2, '.', '').'" name="sqmprice_usd" id="sqmprice_usd" readonly>&nbsp;&nbsp;	
							<input type="hidden" value="'.$data1->usd.'" name="usd_price" id="usd_price" readonly> 
							</td>
						</tr>
						<tr>
							<th>Sqm Price In Euro</th>
							<td>
							<input class="priceinput" type="text" value="'.number_format((float)$euro, 2, '.', '').'" name="sqmprice_euro" id="sqmprice_euro" readonly>&nbsp;&nbsp;	
							<input type="hidden" value="'.$data1->euro.'" name="euro_price" id="euro_price" readonly> 
							</td>
						</tr>
					';
				}
		  }
	
			echo $contentdata;
	}
	
	public function insertdatanew()
	{
		$data = array(
			'size_type_mm' 		 => $this->input->post('size_type_mm'),
			'size_type_cm'		 => $this->input->post('size_type_cm'),
			'size_width_mm'		 => $this->input->post('size_width_mm'),
			'size_width_cm' 	 => $this->input->post('size_width_cm'),
			'size_height_mm' 	 => $this->input->post('size_height_mm'),
			'size_height_cm' 	 => $this->input->post('size_height_cm'),
			'series' 			 => $this->input->post('series'),
			'pcsperbox' 		 => $this->input->post('pcsperbox'),
			'apwigtperbox' 		 => $this->input->post('apwigtperbox'),
			'boxperplt'			 => $this->input->post('boxperplt'),
			'nopltcontainer' 	 => $this->input->post('nopltcontainer'),
			'appsqmperbox'		 => $this->input->post('appsqmperbox'),
			'appgrswetpercon' 	 => $this->input->post('appgrswetpercon'),
			'appwegtpercon' 	 => $this->input->post('appwegtpercon'),
			'sqmpercontain'	 	 => $this->input->post('sqmpercontain'),
			'boxpercontain' 	 => $this->input->post('boxpercontain'),
			'plat_weight' 		 => $this->input->post('plat_weight'),
			'size_id' 			 => $this->input->post('size'),
			'sqmpercontain_new_cm' => $this->input->post('sqmpercontain_new_cm'),
			'appsqmperbox_new_cm'=> $this->input->post('appsqmperbox_new_cm'),
			'sqmprice' 			 => $this->input->post('sqmprice'),
			'priceperbox' 		 => $this->input->post('priceperbox'),
			'pricetype' 		 => $this->input->post('pricetype')
		);
		$json_data = json_encode($data);
		$id=$this->input->post('size');
		$updateid = $this->calc->hsnc_product_size($json_data,$id);
		
	}




}


?>