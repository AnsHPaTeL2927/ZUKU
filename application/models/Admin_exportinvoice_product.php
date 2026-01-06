<?php

class Admin_exportinvoice_product extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	 public function gettermsdata()
	{
		$q = $this->db->where('status !=','2');
		$q = $this->db->get('tbl_terms');
		return $q->result();
	}
	
	public function get_packing_wise_size($id)
	{
		$sql = 'SELECT GROUP_CONCAT(export_packing_id) as export_packing_id,pro.size_type_mm,size.product_packing_name,trn.description_goods,model.model_name,finish.finish_name
		FROM `tbl_export_packing` as packing 
		left join tbl_exportproduct_trn as trn on trn.exportproduct_trn_id = packing.exportproduct_trn_id
		left join tbl_product as pro on pro.product_id = trn.product_id 
		left join tbl_product_size as size on size.product_size_id = trn.product_size_id 
		left join tbl_packing_model as model on model.packing_model_id = packing.design_id 
		left join tbl_finish as finish on finish.finish_id = packing.finish_id 
	 	where packing.export_invoice_id = '.$id.' GROUP by model.packing_model_id,finish.finish_id,trn.product_id,trn.product_size_id,trn.description_goods';
		 $list= $this->db->query($sql);
		return $list->result();				
	}
	public function get_advance_payment($advance_payment_id)
	{
		$qry = "SELECT * FROM `tbl_payment` where payment_id =".$advance_payment_id;
		$q_con = $this->db->query($qry);
		return $q_con->row();
	}
	public function get_company_branch()
	{
		$qry = "SELECT * FROM `tbl_company_branch` where status = 0";
		$q_con = $this->db->query($qry);
		return $q_con->result();
	}
	
	public function get_invoice_data($id)
	{
		$q = $this->db->select('invoice.*,consign.c_name,consign.c_companyname,pi.sign_detail_id,pi.grand_total as pigrandtotal,pi.agent_grand_total as piagentgrandtotal,
            user.sign_pi_status,
            user.for_signature_name,
            user.sign_image,
            user.authorised_signatury,
            user.contact_person_name,
            user.contact_no,
            user.contact_email, supplier.supplier_gstno,supplier.supplier_panno, supplier.company_name, supplier.supplier_name, supplier.address,supplier.permission_date, supplier.permission_no, supplier.expiry_date, supplier.issue_authority_address, cur.currency_name,cur.currency_code,cur.currency_id,epcg.epcg_no,epcg.epcg_date,term.terms_name,country.company_rules as companyrules,consign.rex_no_detail as rexnodetail,consign.rex_detail_status as rex_detail_status')
			 ->from('tbl_export_invoice as invoice')
			 ->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			 ->join('country_detail as country', 'country.id = consign.c_country', 'LEFT')
			 ->join('tbl_supplier as supplier', 'supplier.supplier_id = invoice.supplier_id', 'LEFT')
			 ->join('tbl_supplie_epcg as epcg', 'epcg.supplie_epcg_id = invoice.epcg_licence_no', 'LEFT')
			 ->join('tbl_currency as cur', 'invoice.invoice_currency_id = cur.currency_id', 'LEFT')
			 ->join('tbl_terms as term', 'term.terms_id = invoice.terms_id', 'LEFT')
			   ->join('tbl_performa_invoice AS pi', 'pi.performa_invoice_id = invoice.performa_invoice_id', 'LEFT')
				->join('tbl_user AS user', 'user.user_id = pi.sign_detail_id', 'LEFT')
			 ->where('export_invoice_id',$id)
			 ->get();
		  
			return $q->row();
	}
	public function update_weightrecord($id)
	{
		$data = array(
			"updated_grossweight" 	=> 0,
			"updated_netweight" 	=> 0
		);
		$this->db->where('export_invoice_id', $id);
		return $this->db->update('tbl_exportproduct_trn', $data);
	}
	public function update_export_loading($data_loading,$container_no,$export_invoice_id)
	{
		 
		$q = $this->db->where('updated_net_weight > ', 0);
		$q = $this->db->where('updated_gross_weight >', 0);
		$q = $this->db->where('container_no', $container_no);
		$q = $this->db->where('export_invoice_id', $export_invoice_id);
		$q = $this->db->update('tbl_export_loading_trn', $data_loading);
		 
		return $q;
	}
	public function company_select(){
		
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	}
	public function warner_data($company_id)
	{
		
		$q = $this->db->where('company_id',$company_id);
		$q = $this->db->get('tbl_warner');
		return $q->row();
	}
	
	public function allproductsize()
	{
		 $q= $this->db->select("mst.*,series.series_name,detail.orderby,series.hsnc_code")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->order_by('detail.orderby asc, series.series_name asc, mst.product_id desc')
			 ->where('mst.status',"0")
			 ->get();
		 return $q->result();
	}
	
	public function hsncproductsizedetail($id,$mode)
	{
		 $q = $this->db->select('mst.*, serices.hsnc_code, pro.size_type_mm, pro.defualt_rate, hsnc.p_name, serices.series_name, hsnc.orderby, pro.thickness')
			 ->from('tbl_product_size as mst')
			->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as serices','serices.series_id = pro.series_id', 'LEFT')
			->join('product_code_detail as hsnc','hsnc.hsnc_code = serices.hsnc_code', 'LEFT')
			->where('mst.product_id',$id)
			->order_by("hsnc.orderby", "desc")
			->get();
		if($mode==1)
		{
			return $q->num_rows();
		}
		else
		{
			return $q->result();
		}
	}
	
	
	
	public function get_ratedata($id)
	{
		$q = "SELECT * FROM `tbl_seriesgroup` as `mst` WHERE find_in_set(seriesgroup_id,'".$id."')";
		$q_con = $this->db->query($q);
		return $q_con->result();
	}
	public function hsncproductcodedetail($hsnc_value)
	{
		$this->db->where('hsnc_code',$hsnc_value);
		$q = $this->db->get('product_code_detail');
		 return $q->result();
	 
	}
	public function fetchfinish_detail($id)
	{
		 $qry  = 'SELECT finish_id,finish_name FROM `tbl_finish` where find_in_set(finish_id,(SELECT finish_id from tbl_packing_model where packing_model_id = '.$id.' and status = 0)) and status = 0';
		$q = $this->db->get("tbl_finish");
		$q_con = $this->db->query($qry);
	 	return $q_con->result();
	}
	public function insert_productrecord($data)
	{
		$q = $this->db->insert('tbl_exportproduct_trn',$data);
		return $this->db->insert_id();
	}
	public function insertsuppiler($data)
	{
		$q = $this->db->insert('tbl_export_supplier',$data);
		return $this->db->insert_id();
	}
	public function insert_makecontainer($data)
	{
		return $this->db->insert('tbl_exportmakecontainer',$data);
	}
	public function updateproductrecord($data,$id){
		$this->db->where('exportproduct_trn_id', $id); 
		return $this->db->update('tbl_exportproduct_trn',$data); //Set 
	}
	public function update_cointainer($data,$id)
	{
		$q = $this->db->where('export_packing_id', $id); 
		$q =  $this->db->update('tbl_export_packing',$data); //Set 
		 
		return $q;
	}
	public function get_container_data($id,$export_invoice_id,$performa_invoice_id)
	{
		 
	 	$q = $this->db->where('exportinvoice_id',$id);
			$q = $this->db->get('tbl_exportmakecontainer');
			 return $q->result();
		 
	}
	 
	public function update_productpackingrecord($data_packing,$id)
	{
		$this->db->where('export_packing_id',$id);
		$updateid= $this->db->update('tbl_export_packing', $data_packing);
	 
		return $updateid;
	}
	public function getinvoice_productdata($id,$performa_invoice_id,$no_of_container,$mutiple_status,$supplier_id,$direct_invoice,$container_status)
	{
		$q = $this->db->where('export_invoice_id',$id);
		$q = $this->db->order_by("product_container", "desc");
		$q = $this->db->order_by("container_order_by", "asc");
		$q = $this->db->get('tbl_exportproduct_trn');
		 
		if($q->num_rows()==0)
		{ 
				 
			if($mutiple_status == 2)
			{
				return 0;
			}
			else
			{
				$supplier_id = explode('-',$supplier_id);
				$where = '';
				if($container_status == 1)
				{
					$where  = ' and container < 1';
				}
				else if($container_status == 3)
				{
					$where  = ' and container != 0';
				}
				else
				{
					
					$where  = ' and container >= 1';
				}
				 
				$performa_invoice_id = implode(",",$performa_invoice_id);
				
				$q = "SELECT `make`.*, `mst`.*, `packing`.*, `model`.`model_name`, `model`.`design_file`, `finish`.`finish_name`, `pro`.`size_type_mm`, `pro`.`size_type_cm`, (select count(con_entry) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = ".$performa_invoice_id.") as rowcon_no,
				(select count(con_entry) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = ".$performa_invoice_id.") as sizerowcon_no,
				(select max(con_entry) from tbl_pi_loading_plan where performa_invoice_id = ".$performa_invoice_id.") as max_no, (select (SUM(origanal_boxes) * mst.weight_per_box) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = ".$performa_invoice_id.") as orignal_net_weight, 
				(select (SUM(origanal_pallet) * mst.pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = ".$performa_invoice_id.") as orignal_pallet_weight, 
				(select (SUM(orginal_no_of_big_pallet) * mst.big_pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = ".$performa_invoice_id.") as orignal_big_pallet_weight, 
				(select (SUM(orginal_no_of_small_pallet) * mst.small_pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = ".$performa_invoice_id.") as orignal_small_pallet_weight, 
				(select max(export_time) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = ".$performa_invoice_id.") as exporttime
				FROM `tbl_pi_loading_plan` as `make` LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `make`.`performa_packing_id` LEFT JOIN `tbl_performa_trn` as `mst` ON `packing`.`performa_trn_id` = `mst`.`performa_trn_id` LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `mst`.`product_id` LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id` WHERE `performa_invoice_id` = ".$performa_invoice_id." AND make.supplier_id in (".implode(",",$supplier_id).") ".$where."  AND `make`.`already_done` = 1 AND `make`.`export_done_status` = 0 ORDER BY `make`.`con_no` ASC";
					  $query = $this->db->query($q);
			
					foreach($query->result() as $row)
					{
						
						 
						$total_pallet        = ($row->origanal_pallet + $row->orginal_no_of_big_pallet  + $row->orginal_no_of_small_pallet);
						$palletweight1	     = $row->origanal_pallet * $row->pallet_weight;
						$bigpalletweight1 	 = $row->big_pallet_weight * $row->orginal_no_of_big_pallet;
						$smallpalletweight1  = $row->orginal_no_of_small_pallet * $row->small_pallet_weight;
						$total_pallet_weight = ($palletweight1	+  $bigpalletweight1 + $smallpalletweight1);
						
						$total_net_weight 	= $row->origanal_boxes * $row->weight_per_box;
						$product_rate 		= $row->product_rate;
						$product_amt 		= $row->product_amt;
						$total_sqm 			= ($row->product_id == 0)?$row->origanal_sqm:($row->origanal_boxes * $row->sqm_per_box);
						if($row->product_id != 0)
						{
						 	if($row->per == "SQF")
							{
								$total_sqm =  $total_sqm;
								$productamt = $row->origanal_boxes * $row->feet_per_box * $product_rate;
								$product_rate = $productamt/$total_sqm;
							}
							else if($row->per == "BOX")
							{
								$total_sqm =  $total_sqm;
								$productamt = $row->origanal_boxes * $product_rate;
							 	$product_rate = $productamt/$total_sqm;
								
							}
							else if($row->per == "SQM")
							{
								$total_sqm =  $total_sqm;
								 $product_rate = $row->product_rate;
							}
							else if($row->per == "PCS")
							{
								$total_sqm =  $total_sqm;
								$productamt = $row->origanal_boxes * $row->pcs_per_box * $product_rate;
								$product_rate = $productamt/$total_sqm;
							}
							$product_amt 	=  $total_sqm * $product_rate;
						}
						else
						{
							$product_rate =  $row->product_rate;
							if($row->per == "SQF")
							{
								$total_sqm 	  =  $row->origanal_boxes;
								  
							}
							else if($row->per == "BOX")
							{
								$total_sqm 		=  $row->origanal_boxes;
							 	 
							}
							else if($row->per == "SQM")
							{
								$total_sqm =  $row->origanal_sqm;
								 
							}
							else if($row->per == "PCS")
							{
								$total_sqm =  $row->origanal_boxes;
								 
							}
							
							 
							$product_amt 	=  $total_sqm * $product_rate;
							
						}
						
						 
						$export_data = array(
							"export_invoice_id"		=> $id,
							"performa_trn_id"		=> $row->performa_trn_id,
							"product_size_id"		=> $row->product_size_id,
							"product_id"			=> $row->product_id,
							"product_container"		=> 0,
							"description_goods"		=> $row->description_goods,
							"pallet_status"			=> $row->pallet_status,
							"weight_per_box"		=> $row->weight_per_box,
							"pallet_weight"			=> $row->pallet_weight,
							"big_pallet_weight" 	=> $row->big_pallet_weight,
							"small_pallet_weight" 	=> $row->small_pallet_weight,
							"boxes_per_pallet" 		=> $row->boxes_per_pallet,
							"box_per_big_pallet"  	=> $row->box_per_big_pallet,
							"box_per_small_pallet" 	=> $row->box_per_small_pallet,
							"sqm_per_box" 			=> $row->sqm_per_box,
							"pcs_per_box" 			=> $row->pcs_per_box,
							"feet_per_box" 			=> $row->feet_per_box,
							"total_no_of_pallet" 	=> $total_pallet,
							"total_no_of_boxes" 	=> $row->origanal_boxes,
							"total_no_of_sqm" 		=> (!empty($total_sqm))?$total_sqm:0,
							"total_product_amt" 	=> ($product_amt),
							"total_pallet_weight" 	=> $total_pallet_weight,
							"total_net_weight" 		=> $total_net_weight,
							"total_gross_weight" 	=> ($total_net_weight + $total_pallet_weight),
							"container_half" 		=> ($row->container_half),
							"rowspan_no" 			=> ($row->rowspan_no),
							"container_order_by"  	=> ($row->container_order_by)
						);
						 $insert_id = $this->insert_productrecord($export_data);
						
						$no_of_sqm 		= ($row->product_id == 0)?$row->origanal_sqm:($row->origanal_boxes * $row->sqm_per_box);
						 
						$product_per 	= ($row->product_id == 0)?$row->per:'SQM';
						$export_packing = array(
							"exportproduct_trn_id"	=> $insert_id,
							"export_invoice_id"		=> $id,
							"design_id"				=> $row->design_id,
							"finish_id"				=> $row->finish_id,
							"client_name"		 	=> $row->client_name,
							"barcode_no"		 	=> $row->barcode_no,
							"product_rate"		 	=> $product_rate,
							"no_of_pallet"		 	=> $row->origanal_pallet,
							"no_of_big_pallet"		=> $row->orginal_no_of_big_pallet,
							"no_of_small_pallet"	=> $row->orginal_no_of_small_pallet,
							"no_of_boxes"		 	=> $row->origanal_boxes,
							"no_of_sqm"		 		=> (!empty($no_of_sqm))?$no_of_sqm:0,
							"per"		 			=> $product_per,
							"performa_per"		 	=> $row->per,
							"product_amt"		 	=> $product_amt,
							"packing_net_weight"	=> $total_net_weight,
							"packing_gross_weight"	=> ($total_net_weight + $total_pallet_weight),
						);
						$insert_packing_id = $this->insert_packing_data($export_packing);
						 $copyqry = 'INSERT INTO tbl_export_loading_trn (export_invoice_id,performa_invoice_id,container_no,seal_no,self_seal_no,booking_no, container_size,lr_no, truck_no, mobile_no, remark, tare_weight, exportproduct_trn_id, export_packing_id , product_id, updated_net_weight, updated_gross_weight, origanal_pallet, con_entry, orginal_no_of_big_pallet, orginal_no_of_small_pallet, origanal_boxes,origanal_sqm, status,pi_loading_plan_id,batch_no,shade_no,pallet_ids,make_pallet_no)  SELECT '.$id.','.$performa_invoice_id.',container_no,seal_no,rfidseal_no,booking_no, container_size,lr_no, truck_no, mobile_no, remark, tare_weight, '.$insert_id.', '.$insert_packing_id.' , product_id, updated_net_weight, updated_gross_weight, IF(make_pallet_no = 0,  origanal_pallet, make_pallet_no), con_entry, orginal_no_of_big_pallet, orginal_no_of_small_pallet, origanal_boxes,origanal_sqm, 0 ,pi_loading_plan_id,batch_no,shade_no,pallet_ids,make_pallet_no FROM tbl_pi_loading_plan as mst  WHERE mst.export_done_status = 0 and mst.pi_loading_plan_id='.$row->pi_loading_plan_id;
				  
						$this->db->query($copyqry);
						$export_done_data =array(
							"export_done_status" => 1,
							"export_time"		=> $id
						);
						$update_export_done = $this->db->where('pi_loading_plan_id', $row->pi_loading_plan_id); 
						$update_export_done = $this->db->update('tbl_pi_loading_plan',$export_done_data);
					}
					 
					/*
					$copyqry = 'INSERT INTO tbl_exportproduct_trn (export_invoice_id,performa_trn_id,product_size_id,product_id,product_container,description_goods, pallet_status,weight_per_box, pallet_weight, big_pallet_weight, small_pallet_weight, boxes_per_pallet, box_per_big_pallet, box_per_small_pallet , sqm_per_box, pcs_per_box, total_no_of_pallet, total_no_of_boxes, total_no_of_sqm, total_product_amt, total_pallet_weight, total_net_weight, total_gross_weight, container_half, rowspan_no,container_order_by)  SELECT '.$id.',performa_trn_id,product_size_id,product_id, product_container, description_goods, pallet_status,weight_per_box, pallet_weight, big_pallet_weight,small_pallet_weight, boxes_per_pallet,  box_per_big_pallet,box_per_small_pallet,sqm_per_box,pcs_per_box,total_no_of_pallet,total_no_of_boxes,total_no_of_sqm,total_product_amt,total_pallet_weight,total_net_weight,total_gross_weight,container_half,rowspan_no,container_order_by FROM tbl_performa_trn as mst  WHERE mst.invoice_id='.$performa_invoice_id;
				  
					$this->db->query($copyqry);
			  
					$q = $this->db->select('mst.*')
							->from('tbl_exportproduct_trn as mst')
						 	->where('export_invoice_id',$id)
							->order_by("product_container", "desc")
							->order_by("container_order_by", "asc")
							->get();
				 
					foreach($q->result() as $rowcon)
					{
						$copyqry1 = 'INSERT INTO  tbl_export_packing (exportproduct_trn_id,export_invoice_id,design_id,finish_id,client_name,barcode_no, product_rate,no_of_pallet, no_of_big_pallet, no_of_small_pallet, no_of_boxes, no_of_sqm, per,product_amt,packing_net_weight,packing_gross_weight)  SELECT '.$rowcon->exportproduct_trn_id.','.$id.',design_id,finish_id,client_name,barcode_no, product_rate,no_of_pallet, no_of_big_pallet, no_of_small_pallet, no_of_boxes, no_of_sqm, per,product_amt,packing_net_weight,packing_gross_weight FROM tbl_performa_packing as mst WHERE  performa_trn_id='.$rowcon->performa_trn_id;
						$this->db->query($copyqry1);
						 
					}
					  
						$q_con = $this->db->where('invoice_id',$performa_invoice_id);
						$q_con = $this->db->get('tbl_makecontainer');
						foreach($q_con->result() as $row_con)
						{ 
							$makecontainerqry= "SELECT GROUP_CONCAT(exportproduct_trn_id) as allexpotproduct_id,container_order_by FROM `tbl_exportproduct_trn` where find_in_set(performa_trn_id,'".$row_con->allproduct_id."') and export_invoice_id = ".$id;
							$result_con = $this->db->query($makecontainerqry);
							$rel_con = $result_con->row();
							$data = array(
									'allproduct_id'=>$rel_con->allexpotproduct_id,
									'container_count'=>1,
									'exportinvoice_id'=>$id,
									'mix_net_weight'=>$row_con->mix_net_weight,
									'mix_gross_weight'=>$row_con->mix_gross_weight,
									'container_order_by'=>$rel_con->container_order_by
								);
							$insertid = $this->insert_makecontainer($data);
						}*/
						$qry = $this->db->select('make.*,mst.*,packing.*,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,(select count(con_entry) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.') as rowcon_no')
						->from('tbl_export_loading_trn as make')
						->join('tbl_export_packing as packing','packing.export_packing_id = make.export_packing_id', 'LEFT')
						->join('tbl_exportproduct_trn as mst','packing.exportproduct_trn_id = mst.exportproduct_trn_id', 'LEFT')
						->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
						->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
						->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
						->where('make.export_invoice_id',$id)
					 	->order_by('make.con_entry','asc')
						->order_by('make.container_no','desc')
						->get();
						
						return $qry->result();
					}
		 
		}
		else
		{
		 	$qry = $this->db->select('make.*,mst.*,packing.*,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,(select count(con_entry) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.') as rowcon_no,
			(select pallet_ids from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and find_in_set(make.pi_loading_plan_id,pallet_ids) and pi_loading_plan_id !=0) as pallet_row,
			perfoma.invoice_no,series.hsnc_code')
			->from('tbl_export_loading_trn as make')
			->join('tbl_export_packing as packing','packing.export_packing_id = make.export_packing_id', 'LEFT')
			->join('tbl_exportproduct_trn as mst','packing.exportproduct_trn_id = mst.exportproduct_trn_id', 'LEFT')
			->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as series', 'pro.series_id = series.series_id', 'LEFT')
			->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
			->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
			->join("tbl_performa_invoice as perfoma","perfoma.performa_invoice_id=make.performa_invoice_id","LEFT")
			->where('make.export_invoice_id',$id)
			->order_by('make.con_entry','asc')
			->order_by('make.updated_net_weight','desc')
			->get();
			
			$return = array();
			foreach ($qry->result() as $category) {
						$sub = $category->export_loading_trn_id;
						$category->sample = $this->get_sample_trn($category->export_loading_trn_id,0);
						$return[] = $category;
					}
					 
			 return $return;  
		 
		} 		  
	}
	public function get_sample_trn($export_loading_trn_id,$check)
	{
		
		$array = array('trn.export_loading_trn_id' => $export_loading_trn_id,"trn.status" => 0);
		$where = '';
		if($check == 1)
		{
			$array['commercial_status'] = 0;
		}
		$q = $this->db->select('trn.*')
			 ->from('tbl_export_sampletrn as trn')
		 	 ->where($array)
			 ->get();
		 
		return $q->result();
	}	
	public function getproductrate($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name")
			 ->from("tbl_export_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("mst.exportproduct_trn_id",$id)
			 ->get();
		 
		return $q->result();
	}
	public function getinvoice_mutiple_record($id,$performa_invoice_id_array,$supplier_id,$con_entry,$container_status)
	{
		 
				$where = '';
				if($container_status == 1)
				{
					$where  = ' and container < 1';
				}
				else if($container_status == 3)
				{
					$where  = ' and container != 0';
				}
				else
				{
					
					$where  = ' and container >= 1';
				}
			$performa_invoice_id = implode(",",$performa_invoice_id_array);
		 
			$q =  'SELECT `make`.*, `mst`.*, `packing`.*, `model`.`model_name`, `model`.`design_file`, `finish`.`finish_name`, `pro`.`size_type_mm`, `pro`.`size_type_cm`, (select count(con_entry) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id in ('.$performa_invoice_id.')) as rowcon_no, (select max(con_entry) from tbl_pi_loading_plan where  performa_invoice_id in ('.$performa_invoice_id.')) as max_no, (select (SUM(origanal_boxes) * mst.weight_per_box) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id =  performa_invoice_id in ('.$performa_invoice_id.')) as orignal_net_weight, (select (SUM(origanal_pallet) * mst.pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and  performa_invoice_id in ('.$performa_invoice_id.')) as orignal_pallet_weight, (select (SUM(orginal_no_of_big_pallet) * mst.big_pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and  performa_invoice_id in ('.$performa_invoice_id.')) as orignal_big_pallet_weight, (select (SUM(orginal_no_of_small_pallet) * mst.small_pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and  performa_invoice_id in ('.$performa_invoice_id.')) as orignal_small_pallet_weight FROM `tbl_pi_loading_plan` as `make` LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `make`.`performa_packing_id` LEFT JOIN `tbl_performa_trn` as `mst` ON `packing`.`performa_trn_id` = `mst`.`performa_trn_id` LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `mst`.`product_id` LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id` WHERE  performa_invoice_id in ('.$performa_invoice_id.') AND `make`.`supplier_id` in ('.implode(",",$supplier_id).') '.$where.'  AND `make`.`already_done` = 1 AND `make`.`export_done_status` = 0 ORDER BY `make`.`con_entry` ASC';
			$query = $this->db->query($q);
					 	 
					 $con_array = array();
					foreach($query->result() as $row)
					{
						 if(!in_array($row->container_no,$con_array))
						 {
							 $con_entry = $con_entry + 1;
							 array_push($con_array,$row->container_no);
						 }
						$total_pallet  = ($row->origanal_pallet + $row->orginal_no_of_big_pallet  + $row->orginal_no_of_small_pallet);
						$palletweight1	  = $row->origanal_pallet * $row->pallet_weight;
						$bigpalletweight1 = $row->big_pallet_weight * $row->orginal_no_of_big_pallet;
						$smallpalletweight1 = $row->orginal_no_of_small_pallet * $row->small_pallet_weight;
						$total_pallet_weight = ($palletweight1	+  $bigpalletweight1 + $smallpalletweight1);
						$total_net_weight = $row->origanal_boxes * $row->weight_per_box;
						
						$product_rate 		= $row->product_rate;
						$product_amt 		= $row->product_amt;
						$total_sqm 			= ($row->product_id == 0)?$row->origanal_sqm:($row->origanal_boxes * $row->sqm_per_box);
						
						if($row->product_id != 0)
						{
						 	if($row->per == "SQF")
							{
								$total_sqm =  $total_sqm;
								$product_rate = $row->product_amt/$total_sqm;
							}
							else if($row->per == "BOX")
							{
								$total_sqm =  $total_sqm;
								$product_rate = $row->product_amt/$total_sqm;
							}
							else if($row->per == "SQM")
							{
								$total_sqm =  $total_sqm;
								$product_rate = $row->product_rate;
							}
							else if($row->per == "PCS")
							{
								$total_sqm =  $total_sqm;
								$product_rate = $row->product_amt/$total_sqm;
							}
							$product_amt 	=  $total_sqm * $product_rate;
						}
						else
						{
							if($row->per == "SQF")
							{
								$total_sqm 	  =  $total_sqm;
								$product_rate = $row->product_amt/$total_sqm;
							}
							else if($row->per == "BOX")
							{
								$total_sqm 		=  $row->origanal_boxes;
								$product_rate 	=  $row->product_rate;
								$product_amt	=  $total_sqm * $product_rate;
								 
							}
							else if($row->per == "SQM")
							{
								$total_sqm =  $total_sqm;
								$product_rate = $row->product_rate;
							}
							else if($row->per == "PCS")
							{
								$total_sqm =  $total_sqm;
								$product_rate = $row->product_amt/$total_sqm;
							}
						}
						 
						$export_data = array(
							"export_invoice_id"		=> $id,
							"performa_trn_id"		=> $row->performa_trn_id,
							"product_size_id"		=> $row->product_size_id,
							"product_id"			=> $row->product_id,
							"product_container"		=> 0,
							"description_goods"		=> $row->description_goods,
							"pallet_status"			=> $row->pallet_status,
							"weight_per_box"		=> $row->weight_per_box,
							"pallet_weight"			=> $row->pallet_weight,
							"big_pallet_weight" 	=> $row->big_pallet_weight,
							"small_pallet_weight" 	=> $row->small_pallet_weight,
							"boxes_per_pallet" 		=> $row->boxes_per_pallet,
							"box_per_big_pallet"  	=> $row->box_per_big_pallet,
							"box_per_small_pallet" 	=> $row->box_per_small_pallet,
							"sqm_per_box" 			=> $row->sqm_per_box,
							"pcs_per_box" 			=> $row->pcs_per_box,
							"feet_per_box" 			=> $row->feet_per_box,
							"total_no_of_pallet" 	=> $total_pallet,
							"total_no_of_boxes" 	=> $row->origanal_boxes,
							"total_no_of_sqm" 		=> ($total_sqm),
							"total_product_amt" 	=> ($product_amt),
							"total_pallet_weight" 	=> $total_pallet_weight,
							"total_net_weight" 		=> $total_net_weight,
							"total_gross_weight" 	=> ($total_net_weight + $total_pallet_weight),
							"container_half" 		=> ($row->container_half),
							"rowspan_no" 			=> ($row->rowspan_no),
							"container_order_by"  	=> ($row->container_order_by)
						);
						$insert_id = $this->insert_productrecord($export_data);
						
						$no_of_sqm 	= ($row->product_id == 0)?$row->origanal_sqm:($row->origanal_boxes * $row->sqm_per_box);
						$export_packing = array(
							"exportproduct_trn_id"	=> $insert_id,
							"export_invoice_id"		=> $id,
							"design_id"				=> $row->design_id,
							"finish_id"				=> $row->finish_id,
							"client_name"		 	=> $row->client_name,
							"barcode_no"		 	=> $row->barcode_no,
							"product_rate"		 	=> $product_rate,
							"no_of_pallet"		 	=> $row->origanal_pallet,
							"no_of_big_pallet"		=> $row->orginal_no_of_big_pallet,
							"no_of_small_pallet"	=> $row->orginal_no_of_small_pallet,
							"no_of_boxes"		 	=> $row->origanal_boxes,
							"no_of_sqm"		 		=> $no_of_sqm,
							"per"		 			=> 'SQM',
							"performa_per"		 	=> $row->per,
							"product_amt"		 	=> ($product_amt),
							"packing_net_weight"	=>  $total_net_weight,
							"packing_gross_weight"	=> ($total_net_weight + $total_pallet_weight),
						);
						$insert_packing_id = $this->insert_packing_data($export_packing);
						$copyqry = 'INSERT INTO tbl_export_loading_trn (export_invoice_id,performa_invoice_id,container_no,seal_no,self_seal_no,booking_no, container_size,lr_no, truck_no, mobile_no, remark, tare_weight, exportproduct_trn_id, export_packing_id , product_id, updated_net_weight, updated_gross_weight, origanal_pallet, con_entry, orginal_no_of_big_pallet, orginal_no_of_small_pallet, origanal_boxes,origanal_sqm, status,pi_loading_plan_id)  SELECT '.$id.','.$row->performa_invoice_id.',container_no,seal_no,rfidseal_no,booking_no, container_size,lr_no, truck_no, mobile_no, remark, tare_weight, '.$insert_id.', '.$insert_packing_id.' , product_id, updated_net_weight, updated_gross_weight, origanal_pallet, '.$con_entry.', orginal_no_of_big_pallet, orginal_no_of_small_pallet, origanal_boxes,origanal_sqm,0,pi_loading_plan_id FROM tbl_pi_loading_plan as mst  WHERE mst.export_done_status = 0 and mst.pi_loading_plan_id='.$row->pi_loading_plan_id;
				  
						$this->db->query($copyqry);
						$export_done_data =array(
							"export_done_status" => 1,
							"export_time"		=> $id
						);
						$update_export_done = $this->db->where('pi_loading_plan_id', $row->pi_loading_plan_id); 
						$update_export_done = $this->db->update('tbl_pi_loading_plan',$export_done_data);
					}
					return $con_entry;
	}
	
	public function fetchdesign_detail($id)
	{
		$q = $this->db->where("product_id",$id);
		$q = $this->db->where("status",0);
		$q = $this->db->get("tbl_packing_model");
		return $q->result();
	}
	
	public function only_sample_mst($exportproduct_trn_id,$id)
	{
		$array = array('mst.exportinvoicetrnid' => $exportproduct_trn_id, 'mst.export_invoice_id' =>$id);
		$q = $this->db->select('mst.*')
			 ->from('tbl_export_sample as mst')
			->where($array)
			->get();
		 
		return $q->result();	
	}
	public function only_sample_trn($export_loading_trn_id,$value,$exportproduct_trn_id)
	{
		if($value == 1)
		{
			$array = array('trn.exportproduct_trn_id' => $exportproduct_trn_id,'trn.status' => 0);
		}
		else
		{
			$array = array('trn.export_loading_trn_id' => $export_loading_trn_id,'trn.status' => 0);
		}
		$q = $this->db->select('trn.*,size.sqm_per_box, size.weight_per_box')
			 ->from('tbl_export_sampletrn as trn')
			 ->join('tbl_product as product', 'product.product_id = trn.product_id', 'LEFT')
			 ->join('tbl_product_size as size', 'size.product_size_id = trn.product_size_id', 'LEFT')
			 ->where($array)
			 ->get();
		   
		return $q->result();
	}
	public function getannexuredata($id)
	{
		$q = $this->db->select('mst.*,branch.company_branch_name,branch.company_branch_code');
		$q = $this->db->where('export_invoice_id',$id);
		$q = $this->db->join("tbl_company_branch as branch","branch.company_branch_id=mst.company_branch_id","LEFT");
		$q = $this->db->get('tbl_export_annexure as mst ');
		return $q->row();
	}
	public function getperformaproductrate($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name")
			 ->from("tbl_performa_packing as mst")
			  ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("mst.performa_trn_id",$id)
			 ->get();
		 
		return $q->result();
	}
	public function getdesignrate($cust_id,$product_id,$packing_model_id,$finish_id)
	{
		 $where = '';
		 if(!empty($finish_id))
		 {
			 $where  = ' and finish_id = '.$finish_id;
		 }
		$q =  "SELECT `mst`.* FROM `tbl_design_rate` as `mst` WHERE mst.`status` = '0' AND mst.cust_id  = ".$cust_id." and product_id = ".$product_id.$where;
		 $query = $this->db->query($q);
		 return $query->row();
	}
	public function getinvoiceproductdata($id)
	{
		$qry = $this->db->select('make.*,mst.*,packing.*,model.model_name,p_trn.location,pi_loading.location_name,supplier.company_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,pro.thickness,pro_size.boxes_per_pallet,pro_size.weight_per_box as master_weight_per_box,pro_size.product_packing_name,pro_size.pallet_weight as masterpalletweight,pro_size.big_plat_weight,pro_size.small_plat_weight,
		(select COUNT(DISTINCT product_id) from tbl_export_loading_trn where con_entry = make.con_entry and after_invoice_delete != 2 and export_invoice_id = '.$id.')  as rowcon_no,
		(select COUNT(export_loading_trn_id) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and after_invoice_delete != 2) as rowspan_no,
		(select SUM(origanal_boxes) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_package,
		(select SUM(origanal_boxes) from tbl_export_loading_trn where con_entry = make.con_entry  and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ann_package,
		(select pallet_ids from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and find_in_set(make.pi_loading_plan_id,pallet_ids) and pi_loading_plan_id !=0 and after_invoice_delete != 2) as pallet_row,
		
		(select SUM( IF(orginal_no_of_big_pallet>0, orginal_no_of_big_pallet,0)  +  IF(orginal_no_of_small_pallet>0, orginal_no_of_small_pallet,0) + IF((origanal_pallet>0 &&  (make_pallet_no IS NULL || make_pallet_no =0)), origanal_pallet,0) + IF(make_pallet_no>0, make_pallet_no,0) + IF((export_make_pallet_no = ""), 0,export_half_pallet)) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ori_pallet,
		
	 	(select SUM(origanal_boxes * mst.sqm_per_box) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ori_sqm,
		(select SUM(updated_net_weight) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ori_net_weight,epcg.epcg_no,epcg.epcg_date,
		(select SUM(updated_gross_weight) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ori_gross_weight,
		series.series_name,series.hsnc_code,series.water_text,pi_loading.production_mst_id,pinvoice.invoice_no as performa_invoice_no')
		 	->from('tbl_export_loading_trn as make')
			->join('tbl_pi_loading_plan as pi_loading','pi_loading.pi_loading_plan_id = make.pi_loading_plan_id', 'LEFT')
			->join('tbl_production_trn as p_trn','p_trn.production_trn_id  = pi_loading.production_trn_id ', 'LEFT')
			->join('tbl_performa_invoice as pinvoice','pinvoice.performa_invoice_id = make.performa_invoice_id', 'LEFT')
			->join('tbl_export_packing as packing','packing.export_packing_id = make.export_packing_id', 'LEFT')
			->join('tbl_exportproduct_trn as mst','packing.exportproduct_trn_id = mst.exportproduct_trn_id', 'LEFT')
			->join('tbl_product_size as pro_size', 'mst.product_size_id = pro_size.product_size_id', 'LEFT')
			->join('tbl_product as pro', 'pro.product_id = make.product_id', 'LEFT')
			
			->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
			->join('tbl_export_supplier as esup',"esup.export_invoice_id = make.export_invoice_id and FIND_IN_SET(packing.export_packing_id, esup.suppiler_trn_id)","left")
			->join('tbl_supplie_epcg as epcg',"epcg.supplie_epcg_id=esup.epcg_licence_no","left")
			->join('tbl_supplier as supplier',"supplier.supplier_id=esup.suppiler_id","left")
			->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
			->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
			->where('make.export_invoice_id',$id)
			->where('make.after_invoice_delete !=',2)
			->order_by('make.con_entry','asc')
			->order_by('make.updated_net_weight','desc')
			->get();
			 
		//  ->join('tbl_export_supplier as esup',"find_in_set(packing.export_packing_id,esup.suppiler_trn_id) and esup.export_invoice_id = ".$id,"left")
			$return = array();
			foreach ($qry->result() as $category) {
						$sub = $category->export_loading_trn_id;
						 
						$category->sample = $this->get_sample_trn($category->export_loading_trn_id,0);
						  
						$return[] = $category;
					}
					 
			 return $return;  
	}
	public function getinvoice_cust_data($id,$check,$consiger_id)
	{
		 
		$qry = $this->db->select('make.*,mst.*,packing.*,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,series.hsnc_code,series.series_name,series.water_text,pro_size.boxes_per_pallet,pro_size.weight_per_box as master_weight_per_box,pro_size.product_packing_name,pro_size.pallet_weight as masterpalletweight,pro_size.big_plat_weight,pro_size.small_plat_weight,
		(select COUNT(DISTINCT product_id) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id in ('.implode(",",$id).') and container_no = make.container_no and after_invoice_delete != 2 )  as rowcon_no,
		(select COUNT(export_loading_trn_id) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id in ('.implode(",",$id).') and container_no = make.container_no and after_invoice_delete != 2 ) as rowspan_no,
		(select SUM(origanal_boxes) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id in ('.implode(",",$id).') and container_no = make.container_no and after_invoice_delete != 2 ) as total_package,
		(select SUM(orginal_no_of_big_pallet + orginal_no_of_small_pallet + origanal_pallet + make_pallet_no) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id in ('.implode(",",$id).') and container_no = make.container_no and after_invoice_delete != 2 ) as total_ori_pallet,
		(select SUM(origanal_boxes * mst.sqm_per_box) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id in ('.implode(",",$id).') and container_no = make.container_no and after_invoice_delete != 2 ) as total_ori_sqm,
		(select SUM(updated_net_weight) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id in ('.implode(",",$id).') and container_no = make.container_no and after_invoice_delete != 2 ) as total_ori_net_weight,
		(select SUM(updated_gross_weight) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id in ('.implode(",",$id).') and container_no = make.container_no and after_invoice_delete != 2 ) as total_ori_gross_weight,make.export_invoice_id as einvoice_id,
		detail.cust_product_name,detail.cust_hsncode,detail.show_export,detail.show_cust,detail.show_bl,detail.show_coo
		')
			->from('tbl_export_loading_trn as make')
			->join('tbl_pi_loading_plan as pi_loading','pi_loading.pi_loading_plan_id = make.pi_loading_plan_id', 'LEFT')
			->join('tbl_export_packing as packing','packing.export_packing_id = make.export_packing_id', 'LEFT')
			->join('tbl_exportproduct_trn as mst','packing.exportproduct_trn_id = mst.exportproduct_trn_id', 'LEFT')
			->join('tbl_product_size as pro_size', 'mst.product_size_id = pro_size.product_size_id', 'LEFT')
			->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
			->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
			->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
			->join("tbl_cust_product_detail as detail","detail.product_id=pro.product_id and customer_id = ".$consiger_id,"LEFT")
			->where('make.export_invoice_id in ('.implode(",",$id).') and make.export_invoice_id !=',0)
			->where('make.after_invoice_delete !=',2)
			->order_by('make.con_entry','asc')
			->order_by('make.updated_net_weight','desc')
		 	->get();
 
			$return = array();
			foreach ($qry->result() as $category) {
						$sub = $category->export_loading_trn_id;
						$category->sample = $this->get_sample_trn($category->export_loading_trn_id,$check);
						$return[] = $category;
					} 
					 
			 return $return;  
	}
	public function get_suppiler_wise_data($id)
	{
		$q= $this->db->select("mst.*,product.size_type_mm,packing.client_name,model.model_name,finish.finish_name,series.hsnc_code,series.series_name,
		(select COUNT(DISTINCT product_id) from tbl_export_loading_trn where con_entry = mst.con_entry and export_invoice_id = ".$id." and container_no = mst.container_no)  as rowcon_no,
		(select COUNT(export_loading_trn_id) from tbl_export_loading_trn where con_entry = mst.con_entry and export_invoice_id = ".$id." and container_no = mst.container_no) as rowspan_no,pi_loading.supplier_id,exportsupplier.suppiler_invoice_date,exportsupplier.suppiler_invoice_date,exportsupplier.epcg_licence_no,exportsupplier.suppiler_invoice_no,trn.description_goods ")
			 ->from("tbl_export_loading_trn as mst")
			 ->join('tbl_pi_loading_plan as pi_loading','pi_loading.pi_loading_plan_id = mst.pi_loading_plan_id', 'LEFT')
			 ->join('tbl_supplier as supplier',"supplier.supplier_id=pi_loading.supplier_id","left")
		 	 ->join("tbl_product as product","product.product_id=mst.product_id","LEFT")
		 	 ->join("tbl_export_packing as packing","packing.export_packing_id=mst.export_packing_id","LEFT")
		 	 ->join("tbl_exportproduct_trn as trn","trn.exportproduct_trn_id=mst.exportproduct_trn_id","LEFT")
			 ->join('tbl_series as series', 'series.series_id = product.series_id', 'LEFT')
		 	 ->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
		 	 ->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
		 	->join("tbl_export_supplier as exportsupplier","exportsupplier.suppiler_trn_id=mst.export_loading_trn_id and exportsupplier.export_invoice_id = ".$id,"LEFT")
		 	 ->where("mst.export_invoice_id",$id)
			 ->get();
		 
		   return $q->result(); 		
	}
	public function get_ewb_template($id)
	{
		$q= $this->db->select("mst.*,invoice.export_invoice_no")
			 ->from("tbl_eseal as mst")
			 ->join('tbl_export_invoice as invoice', 'invoice.export_invoice_id = mst.export_invoice_id', 'LEFT')
			 ->where("mst.export_invoice_id",$id)
			->get();
		 
		return $q->row();
	}
	public function getinvoice_direct_productdata($id)
	{
			$qry = $this->db->select('make.*,mst.*,packing.*,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,
		(select COUNT(DISTINCT product_id) from tbl_export_loading_trn where con_entry = make.con_entry and after_invoice_delete != 2 and export_invoice_id = '.$id.')  as rowcon_no,
		(select COUNT(export_loading_trn_id) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and after_invoice_delete != 2) as rowspan_no,
		(select SUM(origanal_boxes) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_package,
		(select SUM(origanal_boxes) from tbl_export_loading_trn where con_entry = make.con_entry  and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ann_package,
		(select pallet_ids from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and find_in_set(make.pi_loading_plan_id,pallet_ids) and pi_loading_plan_id !=0 and after_invoice_delete != 2) as pallet_row,
		(select SUM( IF(orginal_no_of_big_pallet>0, orginal_no_of_big_pallet,0)  +  IF(orginal_no_of_small_pallet>0, orginal_no_of_small_pallet,0) + IF((origanal_pallet>0 &&  (make_pallet_no IS NULL || make_pallet_no =0)), origanal_pallet,0) + IF(make_pallet_no>0, make_pallet_no,0)) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ori_pallet,
	 	(select SUM(origanal_boxes * mst.sqm_per_box) from tbl_export_loading_trn where con_entry = make.con_entry and product_id = make.product_id and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ori_sqm,
		(select SUM(updated_net_weight) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ori_net_weight,epcg.epcg_no,epcg.epcg_date,
		(select SUM(updated_gross_weight) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$id.' and after_invoice_delete != 2) as total_ori_gross_weight,
		series.series_name,series.hsnc_code,series.water_text,pi_loading.production_mst_id,supplier.company_name,pinvoice.invoice_no as performa_invoice_no')
		 	->from('tbl_export_loading_trn as make')
			->join('tbl_pi_loading_plan as pi_loading','pi_loading.pi_loading_plan_id = make.pi_loading_plan_id', 'LEFT')
			->join('tbl_performa_invoice as pinvoice','pinvoice.performa_invoice_id = make.performa_invoice_id', 'LEFT')
			->join('tbl_export_packing as packing','packing.export_packing_id = make.export_packing_id', 'LEFT')
			->join('tbl_exportproduct_trn as mst','packing.exportproduct_trn_id = mst.exportproduct_trn_id', 'LEFT')
			->join('tbl_product as pro', 'pro.product_id = make.product_id', 'LEFT')
			->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
			->join('tbl_export_supplier as esup',"find_in_set(mst.exportproduct_trn_id,esup.suppiler_trn_id) and esup.export_invoice_id = ".$id."  and esup.suppiler_id = pi_loading.supplier_id","left")
			 ->join('tbl_supplie_epcg as epcg',"epcg.supplie_epcg_id=esup.epcg_licence_no","left")
			 ->join('tbl_supplier as supplier',"supplier.supplier_id=esup.suppiler_id","left")
			->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
			->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
			->where('make.export_invoice_id',$id)
			->where('make.after_invoice_delete !=',2)
	        ->order_by('series.hsnc_code','asc')
	        ->order_by('series.series_name','asc')
			->get();
			 
			$return = array();
			foreach ($qry->result() as $category) {
						$sub = $category->export_loading_trn_id;
						
						$category->sample = $this->get_sample_trn($category->export_loading_trn_id,0);
						  
						$return[] = $category;
					}
					 
			 return $return;  
	}
	public function loading_data($id)
	{
		$q = $this->db->select('mst.*,product.size_type_mm,series.series_name')
			 ->from('tbl_exportproduct_trn as mst')
			 ->join('tbl_product as product',"product.product_id=mst.product_id","LEFT")
			 ->join('tbl_series as series',"series.series_id=product.series_id","LEFT")
			 ->where('export_invoice_id',$id)
			->order_by("product_container", "desc")
			->order_by("container_order_by", "asc")
			->order_by("exportproduct_trn_id", "asc")
			->get();
			//echo $this->db->last_query();exit;
			foreach ($q->result() as $category)
			{
				$sub				= $category->exportproduct_trn_id;
				$category->packing	= $this->get_packing($category->exportproduct_trn_id);
				$category->sample 	= $this->get_sample($category->exportproduct_trn_id,$id);
					 
				$return[] = $category;
			} 
			  
			  return $return;
	}
	public function get_sampletrn($exportproduct_trn_id,$id)
	{
		$array = array('trn.exportproduct_trn_id' => $exportproduct_trn_id, 'trn.export_id' =>$id);
		$q = $this->db->select('trn.*')
			 ->from('tbl_export_sampletrn as trn')
			 ->where($array)
			 ->order_by("exportproduct_trn_id", "asc")
			->get();
		 
		return $q->result();	 
	}
	public function get_sample($exportproduct_trn_id,$id)
	{
		$array = array('trn.exportproduct_trn_id' => $exportproduct_trn_id, 'trn.export_id' =>$id);
		$q = $this->db->select('trn.*, product.size_type_mm, size.sqm_per_box, size.weight_per_box, size.pallet_weight ')
			 ->from('tbl_export_sampletrn as trn')
		    ->join('tbl_product as product', 'product.product_id = trn.product_id', 'LEFT')
			 ->join('tbl_product_size as size', 'size.product_size_id = trn.product_size_id', 'LEFT')
		 	->where($array)
			->order_by("exportproduct_trn_id", "asc")
			->get();
		 
		return $q->result();	 
	}
	public function getinvoicesampleproductdata($id,$check)
	{
		
		$array = array('trn.export_id in ('.$id.') and trn.export_id !=' => 0);
		if($check == 1)
		{
			$array['commercial_status'] = 0;
		}
		$q = $this->db->select('trn.*')
			->from('tbl_export_sampletrn as trn')
		 	->where($array)
			->get();
		  
		return $q->result();	 
	}
	public function getsampletotal($id)
	{
		$qry = 'SELECT trn.exportinvoicetrnid, COUNT(trn.exportinvoicetrnid) FROM tbl_export_sampletrn  as trn left join tbl_export_sample as mst on trn.export_sample_id = mst.export_sample_id where  mst.export_invoice_id = '.$id.' GROUP BY trn.exportinvoicetrnid HAVING COUNT(trn.exportinvoicetrnid) >= 1';
		$qry_result = $this->db->query($qry);
		return $qry_result->num_rows();
	}
	public function get_edit_ratedata($id,$exportproduct_trn_id)
	{
	 	$q = "SELECT * FROM `tbl_exportproduct_rate` as `mst` left join tbl_seriesgroup as serices on serices.seriesgroup_id=mst.model_type_id  WHERE find_in_set(seriesgroup_id,'".$id."') and exportproduct_trn_id=".$exportproduct_trn_id;
		$q_con = $this->db->query($q);
		
		return $q_con->result();
	}
	public function get_supplier()
	{
		$q=$this->db->get('tbl_supplier');
		return $q->result();
	}
	public function delete_product($id)
	{
		
		$this->db->where('exportproduct_trn_id',$id);
		return $this->db->delete('tbl_exportproduct_trn');
	}	
	
	public function delete_loading_trn($id1)
	{
		$this->db->where('export_invoice_id',$id1);
		return $this->db->delete('tbl_export_loading_trn');
	}
	
	public function deletesampleproductdata($export_loading_trn_id,$export_invoice_id,$value,$exportinvoicetrnid)
	{
		if($value == 2)
		{
			$array = array('exportproduct_trn_id' => $exportinvoicetrnid, 'export_id' =>$export_invoice_id);
		}
		else
		{
			$array = array('export_loading_trn_id' => $export_loading_trn_id, 'export_id' =>$export_invoice_id);
		}
		$q1 = $this->db->where($array);
		$q1 = $this->db->delete('tbl_export_sampletrn');
		 
	 	return 1;		
	}
	public function delete_product_packing($id){
		
		$this->db->where('invoice_product_data_id',$id);
		return $this->db->delete('tbl_product_packing');
	}
	public function delete_sample_product($id){
		
		$q = $this->db->where('exportinvoicetrnid',$id);
		$q = $this->db->delete('tbl_export_sample');
		$q1 = $this->db->where('exportinvoicetrnid',$id);
		$q1 = $this->db->delete('tbl_export_sampletrn');
		return 1;
	}
	public function fetchrecord($id)
	{
		$q = $this->db->where("exportproduct_trn_id",$id);
		$q = $this->db->get("tbl_exportproduct_trn");
		return $q->row();
	}
	public function get_packing($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name,model.design_file")
			 ->from("tbl_export_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("exportproduct_trn_id",$id)
			 ->get();
		  
		return $q->result();
	}
	public function fetchproductrecord($product_id)
	{
		$q = $this->db->select("mst.*,pro.product_id,serices.hsnc_code")
			 ->from("tbl_exportproduct_trn as mst")
			 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			->join('tbl_series as serices', 'serices.series_id = pro.series_id', 'LEFT')
		 	 ->where("exportproduct_trn_id",$product_id)
			 ->get();
			 
		return $q->row();
	}
	public function update_productrecord($data,$id)
	{
		$this->db->where('exportproduct_trn_id', $id); 
		return $this->db->update('tbl_exportproduct_trn',$data); //Set 
	}
	public function updateexport($export_data,$export_invoice_id){
		$q= $this->db->where('export_invoice_id', $export_invoice_id); 
		$q= $this->db->update('tbl_export_invoice',$export_data);
		//	echo $this->db->last_query();
		return $q;//Set 
	}
	public function update_seting_data($currency_data,$id){
		$q= $this->db->where('log_id', $id); 
		$q= $this->db->update('ciadmin_login',$currency_data);
		//	echo $this->db->last_query();
		return $q;//Set 
	}
	public function product_data_save($id){
		$this->db->set('status', '1');   
		$this->db->where('export_invoice_id', $id);  
		return $this->db->update('tbl_exportproduct_trn'); 
	}
	public function performainvoicestepupdate($id,$step){
		$data = array(
          "step" =>$step
		); 
	  	$this->db->where('performa_invoice_id', $id);
		return $this->db->update('tbl_performa_invoice', $data);
	}
	public function all_model_data($id){
		$this->db->where("status=0 and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
	 
		return $q->result();
	} 
	public function fetch_packing_detail($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_product_size as mst")
			  ->where("product_size_id",$id)
			  ->where("status",0)
			 ->get();
		  
		return $q->row();
	}	
	 public function getfinishdata()
	 {
		 $q = $this->db->where("status",0);
		 $q= $this->db->get("tbl_finish");
		  
		 return $q->result();
	 }
	public function get_packing_detail($id,$customer_id)
	{
		$q= $this->db->select("mst.*,design.product_size_id as p_size")
			 ->from("tbl_product_size as mst")
			 ->join("tbl_customer_box_design as design","design.product_size_id = mst.product_size_id and customer_id=".$customer_id,"LEFT")
			  ->where("mst.product_id",$id)
			  ->where("mst.status",0)
			 ->get();
		  
		return $q->result();
	}
	public function packingdata_insert($data){
		
		$insert = $this->db->insert('tbl_product_packing',$data);
		return $insert;
	}
	
	public function packingdata_delete($id){
		 $this->db->where('product_packing_id',$id);
		return $this->db->delete('tbl_product_packing');
	}
	public function update_packing_details($data,$id)
	{ 
		$this->db->where('product_packing_id', $id);
		$updateid= $this->db->update('tbl_product_packing', $data);
		return $updateid;
	}
	
	public function export_invoice_stepupdate($id,$step,$temp_status){
		$data = array(
          "step" =>$step
		); 
		 
		$this->db->where('export_invoice_id', $id);
		return $this->db->update('tbl_export_invoice', $data);
	}
	
	
	public function bselect($id){
		$this->db->where('id',$id);
		$q = $this->db->get('bank_detail');
		return $q->row();
	}
	

	public function b_insert($data){
		 $this->db->insert('performa_invoice',$data);
		 return $cid = $this->db->insert_id();
	} 
	
	public function pa_insert($data){
		 return $this->db->insert('packing_model',$data);
		 
	}
	
	public function hsncproductsize($hsncval)
	{
		$this->db->where('hsnc_code',$hsncval);
		$q = $this->db->get('hsnc_product_size');
		return $q->result();
	}
	public function ciadmin_login()
	{
		$q = $this->db->get('ciadmin_login');
		return $q->row();
	}
	public function insert_exportannexurerecord($data)
	{
		 $this->db->insert('tbl_export_annexure',$data);
		 return $cid = $this->db->insert_id();
	}
	public function update_exportannexurerecord($data,$id)
	{
		$this->db->where('export_annexure_id', $id);
		return $this->db->update('tbl_export_annexure', $data);
	}
	
	public function update_exporttrnrecord($data,$id)
	{
		$q = $this->db->where('exportproduct_trn_id', $id);
		$q = $this->db->update('tbl_exportproduct_trn', $data);
		  
		return $q;
	}
	public function update_export_packingrecord($data,$id)
	{
		$q =  $this->db->where('export_packing_id', $id);
		$q =  $this->db->update('tbl_export_packing',$data);
		
		return $q;
	}
	public function update_exportpackingrecord($data,$id)
	{
		$this->db->where('exportproduct_trn_id', $id);
		return $this->db->update('tbl_exportproduct_trn', $data);
	}
	public function insert_sampleentry($data)
	{
		 $this->db->insert('tbl_export_sampletrn',$data);
		 return $this->db->insert_id();
	}
	public function insert_sampleentrytrn($data)
	{
		 $this->db->insert('tbl_export_sampletrn',$data);
		 return $this->db->insert_id();
	}
	public function getproductdata($id)
	{
		$this->db->where('product_id',$id);
		$q = $this->db->get('tbl_product_size');
		 
		return $q->row();
	}
	public function delete_sampleproduct($id){
		
		$this->db->where('export_sample_id',$id);
		return $this->db->delete('tbl_export_sample');
	}
	public function delete_export_loading($id){
		
		$this->db->where('exportproduct_trn_id',$id);
		return $this->db->delete('tbl_export_loading_trn');
	}
	public function delete_sampletrnproduct($id){
		
		$this->db->where('export_sample_id',$id);
		return $this->db->delete('tbl_export_sampletrn');
	}
	public function update_exportsampletrn($data,$id)
	{
		$this->db->where('export_sampletrn_id', $id);
		return $this->db->update('tbl_export_sampletrn', $data);
	}
	public function make_containerdelete($id,$invoice_id){
		$array = array('container_order_by' => $id, 'exportinvoice_id' =>$invoice_id);
		$this->db->where($array);
		return $this->db->delete('tbl_exportmakecontainer');
	}
	public function updateinvoicecontainer($data,$id,$invoice_id)
	{ 
		$array = array('container_order_by' => $id, 'export_invoice_id' =>$invoice_id);
		$this->db->where($array);
		$updateid= $this->db->update('tbl_exportproduct_trn', $data);
		 
		return $updateid;
	}
	public function delete_sample($export_id,$container_name){
		
		$array = array('export_id' => $export_id, 'container_name' =>$export_id);
		$deletetrn  = $this->db->where($array);
		$this->db->delete('tbl_export_sampletrn');
		return 1;
		
	}
	
	public function get_modeltype($id)
	{
		$q = $this->db->where('product_id',$id);
		$q = $this->db->get('tbl_seriesgroup');
		 
		return $q->result();
	}
	public function insert_packing_data($packing_data)
	{
		 $q =  $this->db->insert('tbl_export_packing',$packing_data);
		 $q = $this->db->insert_id();
		 return $q;
	}
	public function insert_export_loading($packing_data)
	{
		 $q =  $this->db->insert('tbl_export_loading_trn',$packing_data);
		 
		 return $this->db->insert_id();
	}
	
	public function update_data($updateweight_data,$id1)
	{
		 $this->db->where('export_invoice_id',$id1);	
	     return $this->db->update('tbl_export_loading_trn',$updateweight_data);	
 	}
	
	public function delete_packing_data($id)
	{
		$this->db->where('exportproduct_trn_id',$id);
		return $this->db->delete('tbl_export_packing');
	}
	
	public function get_epcg_data($id)
	{
		$q = $this->db->where('supplier_id',$id);
		$q = $this->db->get('tbl_supplie_epcg');
		  
		return $q->result();
	}
	public function updaterowspandata($id,$total)
	{ 
		$qry_plus = "UPDATE `tbl_exportproduct_trn` SET `rowspan_no` = rowspan_no + ".($total+1)." WHERE `exportproduct_trn_id` = ".$id;
		 $updateid= $this->db->query($qry_plus);
								
		return $updateid;
	}
	public function get_export_supplier($id)
	{
		$q= $this->db->select("mst.*,sup.*,epcg.epcg_no,epcg.epcg_date")
			 ->from("tbl_export_supplier as mst")
			 ->join("tbl_supplier as sup","sup.supplier_id=mst.suppiler_id","LEFT")
			 ->join("tbl_supplie_epcg as epcg","epcg.supplie_epcg_id=mst.epcg_licence_no","LEFT")
			 ->where("export_invoice_id",$id)
			 ->where("mst.status",0)
			 ->group_by("mst.suppiler_id,mst.epcg_licence_no")
			 ->get();
		 
		return $q->result();
	}
	public function delete_export_supplier($id)
	{
		$q = $this->db->where('export_supplier_id',$id);
		$q = $this->db->delete('tbl_export_supplier');
		 
		return 1;
	}
	public function check_export_suppiler($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_export_supplier as mst")
			 ->where("suppiler_trn_id",$id)
			 ->where("mst.status",0)
			 ->get();
	 	return $q->row();
	}
	public function updatesuppiler($data,$export_supplier_id)
	{ 
		$array = array('export_supplier_id' => $export_supplier_id);
		$this->db->where($array);
		$updateid= $this->db->update('tbl_export_supplier', $data);
	 
		return $updateid;
	}
	
	public function get_packing_size_detail($product_size_id)
	{ 
		$q = $this->db->where('product_size_id',$product_size_id);
		$q = $this->db->get('tbl_product_size');
		  
		return $q->row();
	}
	 
	public function delete_loading_data($export_invoice_id,$container_no)
	{
		
		$q1 = $this->db->where('container_no',$container_no);
		$q1 = $this->db->where('export_invoice_id',$export_invoice_id);
		$q1 = $this->db->delete('tbl_export_loading_trn');
		 
		 return $q1;
 	}
	public function loadingtrn_data($export_invoice_id)
	{
		$q= $this->db->select("mst.*,product.size_type_mm,packing.client_name,model.model_name,finish.finish_name,trn.description_goods,
		(select COUNT(DISTINCT product_id) from tbl_export_loading_trn where con_entry = mst.con_entry and export_invoice_id = ".$export_invoice_id." and container_no = mst.container_no)  as rowcon_no,
		(select COUNT(export_loading_trn_id) from tbl_export_loading_trn where con_entry = mst.con_entry and export_invoice_id = ".$export_invoice_id." and container_no = mst.container_no) as rowspan_no,packing.per")
			 ->from("tbl_export_loading_trn as mst")
		 	 ->join("tbl_product as product","product.product_id=mst.product_id","LEFT")
		 	 ->join("tbl_export_packing as packing","packing.export_packing_id=mst.export_packing_id","LEFT")
		 	 ->join("tbl_exportproduct_trn as trn","trn.exportproduct_trn_id=mst.exportproduct_trn_id","LEFT")
		 	 ->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
		 	 ->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
			 ->where("mst.export_invoice_id",$export_invoice_id)
			 ->get();
	 
		$return = array();
			foreach ($q->result() as $category) {
						$sub = $category->export_loading_trn_id;
						$category->sample = $this->get_sample_trn($category->export_loading_trn_id,$check);
						$return[] = $category;
					}
					 
			 return $return;  
 	}
	public function insert_loading_data($data)
	{
		$this->load->model('Admin_create_loading');
		$loadingdata = array(
									"no_of_container"		=> $data->container_details,
									"container_size"		=> '',
									"exportinvoice_no"		=> $data->export_invoice_no,
									"export_date"			=> $data->invoice_date,
									"export_invoice_id"		=> $data->export_invoice_id,
									"cdate"					=> date('Y-m-d H:i:s'),
									"status"				=> 0,
									"export_ref_no"			=> $data->export_ref_no,
									 
							);
		// $loadinginsert_id = $this->Admin_create_loading->insert_loading($loadingdata);
		$q = $this->db->select('etrn.product_id,etrn.description_goods,etrn.pallet_status,etrn.weight_per_box,etrn.pallet_weight,etrn.big_pallet_weight,etrn.small_pallet_weight,etrn.boxes_per_pallet,etrn.box_per_big_pallet,etrn.box_per_small_pallet,etrn.sqm_per_box,etrn.pcs_per_box,epacking.no_of_pallet,epacking.no_of_big_pallet,epacking.no_of_small_pallet,epacking.no_of_boxes,epacking.no_of_sqm,epacking.product_rate,epacking.design_id,epacking.finish_id,epacking.client_name,epacking.barcode_no,invoice.invoice_no','make.con_entry')
		->from('tbl_pi_loading_plan as make')
		 ->join('tbl_performa_invoice as invoice','invoice.performa_invoice_id = make.performa_invoice_id', 'LEFT')
		 ->join('tbl_exportproduct_trn as etrn','etrn.performa_trn_id = make.performa_trn_id', 'LEFT')
		->join('tbl_export_packing as epacking','epacking.exportproduct_trn_id = etrn.exportproduct_trn_id', 'LEFT')
	 	->where('make.performa_invoice_id',$data->performa_invoice_id)
		->order_by('make.con_entry','desc')
		 ->get();
		 
						$no=1; 
					foreach($q->result() as $row)
					{ 
						 $no++;
						$total_pallet  = ($row->origanal_pallet + $row->no_of_big_pallet  + $row->no_of_small_pallet);
						$palletweight1	  = $row->origanal_pallet * $row->pallet_weight;
						$bigpalletweight1 = $row->big_pallet_weight * $row->no_of_big_pallet;
						$smallpalletweight1 = $row->no_of_small_pallet * $row->small_pallet_weight;
						$total_pallet_weight = ($palletweight1	+  $bigpalletweight1 + $smallpalletweight1);
						
						$total_net_weight = $row->no_of_boxes * $row->weight_per_box;
						
						
						 $loadingtrn_data = array(
							"pi_no"					=> $row->invoice_no,
							"container_detail"		=> "",
							"seal_no"				=> "",
							"self_seal_no"		 	=> "",
							"product_id"		 	=> $row->product_id,
							"description"		 	=> $row->description_goods,
							"pallet_status"		 	=> $row->pallet_status,
							"pallet"		 		=> $row->no_of_pallet,
							"box_per_pallet"		=> $row->boxes_per_pallet,
							"boxes"					=> $row->no_of_boxes,
							"design_id"		 	 	=> $row->design_id,
							"batch_no"		 		=> "",
							"export_loading_id"	 	=> 'SQM',
							"order_by"		 		=> $row->con_entry,
							"cdate"					=> date('Y-m-d H:i:s'),
							"status"				=> 0,
							"big_pallet"			=> $row->no_of_big_pallet,
							"small_pallet"			=> $row->no_of_small_pallet,
							"bigbox_per_pallet"		=> $row->box_per_big_pallet,
							"small_per_pallet"		=> $row->box_per_small_pallet,
							"sqm_per_box"			=> $row->sqm_per_box,
							"no_of_sqm"				=> $row->no_of_sqm,
							"rate"					=> $row->product_rate,
							"amount"				=> ($row->product_rate + $row->no_of_sqm),
							"netweight"				=> ($total_net_weight),
							"grossweight"			=> ($total_net_weight + $total_pallet_weight),
							"per"					=>  'SQM',
							"finish_id"				=> ($row->finish_id),
						);
						 $loadingtrn_id = $this->Admin_create_loading->insert_loadingtrn($loadingtrn_data); 
					}
 	}
	
	public function get_supplier_by_id($export_supplier_id)
	{
		$this->db->select('es.*, s.supplier_name, s.company_name');
		$this->db->from('tbl_export_supplier es');
		$this->db->join('tbl_supplier s', 's.supplier_id = es.supplier_id', 'left');
		$this->db->where('es.export_supplier_id', $export_supplier_id);
		$query = $this->db->get();

		return $query->row();
	}


	// public function getsuppier_detail($id)
	// {
		// $this->db->where('export_supplier_id',$id);
		// $q = $this->db->get('tbl_export_supplier');
		 // return $q->row();
	 
	// }
	public function update_suppiler($data,$id)
	{
		$this->db->where('export_supplier_id', $id); 
		return $this->db->update('tbl_export_supplier',$data); //Set 
	}
	public function edit_loadingtrn($con_entry,$export_invoice_id)
	{
		$q = $this->db->select('make.*,packing.*,trn.*,series.series_name,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,
		(select count(con_entry) from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$export_invoice_id.' ) as rowcon_no,
		
		(select pallet_ids from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$export_invoice_id.' and find_in_set(make.pi_loading_plan_id,pallet_ids) and pi_loading_plan_id !=0) as pallet_row,
		
		(select pallet_ids from tbl_export_loading_trn where con_entry = make.con_entry and export_invoice_id = '.$export_invoice_id.' and find_in_set(make.pi_loading_plan_id,pallet_ids) and pi_loading_plan_id !=0) as pallet_row,
		
		(select max(con_entry) from tbl_export_loading_trn where  export_invoice_id = '.$export_invoice_id.') as max_no')
				->from('tbl_export_loading_trn as make')
				->join('tbl_export_packing as packing','packing.export_packing_id = make.export_packing_id', 'LEFT')
			 	->join('tbl_exportproduct_trn as trn','trn.exportproduct_trn_id = packing.exportproduct_trn_id', 'LEFT')
				->join('tbl_product as pro', 'pro.product_id = trn.product_id', 'LEFT')
				->join('tbl_series as series', 'pro.series_id = series.series_id', 'LEFT')
				->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
				->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
			  	->where('make.export_invoice_id',$export_invoice_id)
			  	->where('con_entry',$con_entry)
				->get();
	  
		return $q->result();
	}
	public function updatecointainer($data,$id)
	{
		$q = $this->db->where('export_loading_trn_id', $id); 
		$q = $this->db->update('tbl_export_loading_trn',$data);
		 
		return $q;
	}
	public function update_vgm($export_invoiceid,$new_container_no,$container_no)
	{
		$q = $this->db->where('export_invoice_id',$export_invoiceid);
		$q = $this->db->get('tbl_vgm');
	 	$row_export =  $q->row();
		
		$data = array(
			"container_no" => $new_container_no
		);
		
		$update_q = $this->db->where('container_no',$container_no);	
		$update_q = $this->db->where('vgm_id',$row_export->vgm_id);	
		$update_q = $this->db->update('tbl_vgmtrn',$data);
		 
		return $update_q;
	}	
	public function get_invoice_html($export_invoice_id)
	{
		$q = $this->db->where('table_id',$export_invoice_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','export_invoice');
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
	public function get_packing_html($export_invoice_id)
	{
		$q = $this->db->where('table_id',$export_invoice_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','packing_html');
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
 
	public function get_annexure_html($export_invoice_id)
	{
		$q = $this->db->where('table_id',$export_invoice_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','annexure');
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
	
	public function get_loadingpdf_html($export_invoice_id)
	{
		$q = $this->db->where('table_id',$export_invoice_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','loadingpdf_html');
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
}
