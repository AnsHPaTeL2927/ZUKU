<?php

class Admin_purchase_order_product extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function po_data($id){
		$q = $this->db->select('po.*,supplier.supplier_name')
			 ->from('tbl_purchase_order as po')
			->join('tbl_supplier as supplier', 'supplier.supplier_id = po.seller_id', 'LEFT')
			->where('purchase_order_id',$id)
			->get();
		  
			return $q->row();
	}
	public function fetchdesign_detail($id)
	{
		$q = $this->db->where("product_id",$id);
		$q = $this->db->get("tbl_packing_model");
		return $q->result();
	}
	public function fetchfinish_detail($id)
	{
		$qry  = 'SELECT finish_id,finish_name FROM `tbl_finish` where find_in_set(finish_id,(SELECT finish_id from tbl_packing_model where packing_model_id = '.$id.')) and status = 0';
		$q = $this->db->get("tbl_finish");
		$q_con = $this->db->query($qry);
	 	return $q_con->result();
	}
	public function company_select(){
		
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	}
	public function allproductsize()
	{
		$q= $this->db->select("mst.*,series.series_name")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->order_by('hsnc_code')
			 ->where('mst.status',"0")
			 ->get();
			 
		return $q->result();
	}
	
	public function hsncproductsizedetail($id,$mode)
	{
		$q = $this->db->select('mst.*, serices.hsnc_code, pro.size_type_mm, pro.defualt_rate, pro.thickness, hsnc.p_name, serices.series_name')
			->from('tbl_product_size as mst')
			->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as serices','serices.series_id = pro.series_id', 'LEFT')
			->join('product_code_detail as hsnc','hsnc.hsnc_code = serices.hsnc_code', 'LEFT')
			->where('mst.product_id',$id)
			->order_by("serices.hsnc_code", "desc")
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
	public function hsncproductcodedetail($hsnc_value)
	{
		$this->db->where('hsnc_code',$hsnc_value);
		$q = $this->db->get('product_code_detail');
		 return $q->result();
	 
	}
	public function get_modeltype($id)
	{
		$q = $this->db->where('product_id',$id);
		$q = $this->db->get('tbl_seriesgroup');
		return $q->result();
	}
	public function get_ratedata($id)
	{
		$q = "SELECT * FROM `tbl_seriesgroup` as `mst` WHERE find_in_set(seriesgroup_id,'".$id."')";
		$q_con = $this->db->query($q);
		return $q_con->result();
	}
	public function get_edit_ratedata($id,$purchaseordertrn_id)
	{
	 	$q = "SELECT * FROM `tbl_purchaseorder_rate` as `mst` left join tbl_seriesgroup as serices on serices.seriesgroup_id=mst.model_type_id  WHERE find_in_set(seriesgroup_id,'".$id."') and purchaseordertrn_id=".$purchaseordertrn_id;
		$q_con = $this->db->query($q);
		
		return $q_con->result();
	}
	public function insert_productrecord($data){
		$q =  $this->db->insert('tbl_purchaseordertrn',$data);
		return $this->db->insert_id();
	}
	public function insert_packing_data($packing_data)
	{
		 $q =  $this->db->insert('tbl_purchase_packing',$packing_data);
		 return $this->db->insert_id();
	}
	public function insert_makecontainer($data)
	{
		return $this->db->insert('tbl_pomakecontainer',$data);
	}
	public function get_container_data($id,$export_invoice_id,$performa_invoice_id)
	{
		if(empty($export_invoice_id))
		{
			$q = $this->db->where('invoice_id',$performa_invoice_id);
			$q = $this->db->get('tbl_makecontainer');
			return $q->result();
		}
		else{
			$q = $this->db->where('purchase_order_id',$id);
			$q = $this->db->get('tbl_pomakecontainer');
			return $q->result();
		}
	}
	public function getpo_productdata($id,$production_mst_id,$no_of_container,$mutiple_status,$seller_id)
	{
		$q = $this->db->where('purchase_order_id',$id);
		$q = $this->db->order_by("product_container", "desc");
		$q = $this->db->order_by("container_order_by", "asc");
		$q = $this->db->get('tbl_purchaseordertrn');
		 
		if($q ->num_rows()==0)
		{ 
			
			 
					 $copyqry1 = 'INSERT INTO  tbl_purchase_packing (purchaseordertrn_id,purchase_order_id,performa_trn_id,design_id,finish_id,client_name,barcode_no,no_of_pallet, no_of_big_pallet, no_of_small_pallet, no_of_boxes, no_of_sqm,packing_net_weight,packing_gross_weight,other_image,performa_per,pallet_type_id,box_design_id)  
					
					SELECT 0,'.$id.', mst.performa_trn_id,mst.design_id, mst.finish_id, mst.client_name, mst.barcode_no, trn.no_of_pallet,trn.no_of_big_pallet, trn.no_of_small_pallet, trn.no_of_boxes, trn.no_of_sqm,(IFNULL((trn.no_of_pallet * ptrn.pallet_weight),0) + IFNULL((trn.no_of_big_pallet * ptrn.big_pallet_weight),0) + IFNULL((trn.no_of_small_pallet * ptrn.small_pallet_weight),0) + (ptrn.weight_per_box * trn.no_of_boxes)),(ptrn.weight_per_box * trn.no_of_boxes),other_image,mst.per,mst.pallet_type_id,mst.box_design_id FROM tbl_production_trn as trn 
					 	inner join tbl_performa_packing as mst on mst.performa_packing_id = trn.performa_packing_id 
					 	inner join tbl_performa_trn as ptrn on ptrn.performa_trn_id = mst.performa_trn_id 
					 	  WHERE   production_mst_id in ('.$production_mst_id.')'; 
						$this->db->query($copyqry1);
						
					 
							 $copyqry = 'INSERT INTO  tbl_purchaseordertrn (purchase_order_id,performa_trn_id,product_size_id,product_id,product_container,description_goods,pallet_status,weight_per_box,pallet_weight,big_pallet_weight,small_pallet_weight,boxes_per_pallet,box_per_big_pallet,box_per_small_pallet,sqm_per_box,feet_per_box,pcs_per_box,total_no_of_pallet,total_no_of_boxes,total_no_of_sqm,total_pallet_weight,total_net_weight,total_gross_weight,container_half,rowspan_no,container_order_by,extra_product)  
				
							SELECT '.$id.' , packing.performa_trn_id, trn.product_size_id,trn.product_id,trn.product_container,trn.description_goods,trn.pallet_status,trn.weight_per_box,trn.pallet_weight,trn.big_pallet_weight,trn.small_pallet_weight,trn.boxes_per_pallet,trn.box_per_big_pallet,trn.box_per_small_pallet,trn.sqm_per_box,trn.feet_per_box,trn.pcs_per_box,
							sum(packing.no_of_pallet + packing.no_of_big_pallet + packing.no_of_small_pallet),
							sum(packing.no_of_boxes) ,
							sum(packing.no_of_sqm),
							(IFNULL((sum(packing.no_of_pallet) * trn.pallet_weight),0) + IFNULL((sum(packing.no_of_big_pallet) * trn.big_pallet_weight),0) + IFNULL((sum(packing.no_of_small_pallet) * trn.small_pallet_weight),0)) ,
							sum(packing.packing_net_weight),
							sum(packing.packing_gross_weight),trn.container_half,trn.rowspan_no,trn.container_order_by,extra_product 
							FROM `tbl_purchase_packing` as packing
							inner join tbl_performa_trn as trn on trn.performa_trn_id=packing.performa_trn_id 
							WHERE packing.purchase_order_id='.$id.' GROUP BY packing.performa_trn_id';
							$this->db->query($copyqry);
						$q = 'select purchaseordertrn_id,performa_trn_id from tbl_purchaseordertrn where purchase_order_id='.$id;
						$qry = $this->db->query($q);
							foreach ($qry->result() as $cate)
							{
									$updateqry = 'update tbl_purchase_packing set purchaseordertrn_id = '.$cate->purchaseordertrn_id.' where purchaseordertrn_id=0 and performa_trn_id = '.$cate->performa_trn_id;
									$this->db->query($updateqry);
							}
					
						
						$q = $this->db->select('mst.*, product.size_type_mm,code.p_name,code.hsnc_code,product.thickness,productsize.feet_per_box')
							->from('tbl_purchaseordertrn as mst')
							->join('tbl_product as product', 'product.product_id = mst.product_id', 'LEFT')
							->join('tbl_product_size as productsize', 'productsize.product_size_id = mst.product_size_id', 'LEFT')
							->join('tbl_series as series', 'product.series_id = series.series_id', 'LEFT')
							->join('product_code_detail as code', 'code.hsnc_code = series.hsnc_code', 'LEFT')
							->where('purchase_order_id',$id)
							->order_by("product_container", "desc")
							->order_by("container_order_by", "asc")
							->order_by("purchaseordertrn_id", "asc")
							->get();
							 
						 	foreach ($q->result() as $category)
							{
									$sub = $category->purchaseordertrn_id;
									$category->packing = $this->getpurchaseproductrate($category->purchaseordertrn_id,$category->product_id,$seller_id);
									$return[] = $category;
							} 
							return $return;
			 
		}
		else
		{
			$q = $this->db->select('mst.*, product.size_type_mm,code.p_name,code.hsnc_code,product.thickness,productsize.feet_per_box')
							->from('tbl_purchaseordertrn as mst')
							->join('tbl_product as product', 'product.product_id = mst.product_id', 'LEFT')
							->join('tbl_product_size as productsize', 'productsize.product_size_id = mst.product_size_id', 'LEFT')
							->join('tbl_series as series', 'product.series_id = series.series_id', 'LEFT')
							->join('product_code_detail as code', 'code.hsnc_code = series.hsnc_code', 'LEFT')
							->where('purchase_order_id',$id)
							->order_by("product_container", "desc")
							->order_by("container_order_by", "asc")
							->order_by("purchaseordertrn_id", "asc")
							->get();
							 
			  foreach ($q->result() as $category) {
							$sub 				= $category->purchaseordertrn_id;
						 	$category->packing 	= $this->getpurchaseproductrate($category->purchaseordertrn_id,$category->product_id,$seller_id);
							$return[] 			= $category;
					} 
					return $return;
		} 		  
	}
	public function getinvoice_mutiple_record($id,$performa_invoice_id)
	{
		 $copyqry = 'INSERT INTO  tbl_purchaseordertrn (purchase_order_id,performa_trn_id,product_size_id,product_id,product_container,description_goods,pallet_status,weight_per_box,pallet_weight,big_pallet_weight,small_pallet_weight,boxes_per_pallet,box_per_big_pallet,box_per_small_pallet,sqm_per_box,feet_per_box,pcs_per_box,total_no_of_pallet,total_no_of_boxes,total_no_of_sqm,total_pallet_weight,total_net_weight,total_gross_weight,container_half,rowspan_no,container_order_by)  SELECT '.$id.',performa_trn_id,mst.product_size_id,mst.product_id, mst.product_container, mst.description_goods, mst.pallet_status,mst.weight_per_box, mst.pallet_weight, mst.big_pallet_weight,mst.small_pallet_weight, mst.boxes_per_pallet,  mst.box_per_big_pallet,mst.box_per_small_pallet,mst.sqm_per_box,size.feet_per_box,mst.pcs_per_box,total_no_of_pallet,total_no_of_boxes,total_no_of_sqm,total_pallet_weight,total_net_weight,total_gross_weight,container_half,rowspan_no,container_order_by FROM tbl_performa_trn as mst inner join tbl_product_size as size on size.product_size_id = mst.product_size_id  WHERE mst.invoice_id='.$performa_invoice_id;  
				$this->db->query($copyqry);
				
				$q = $this->db->select('mst.*')
							->from('tbl_purchaseordertrn as mst')
						 	->where('purchase_order_id',$id)
							->order_by("product_container", "desc")
							->order_by("container_order_by", "asc")
							->get();
				
					foreach($q->result() as $rowcon)
					{
						$copyqry1 = 'INSERT INTO  tbl_purchase_packing (purchaseordertrn_id,purchase_order_id,design_id,finish_id,client_name,barcode_no,no_of_pallet, no_of_big_pallet, no_of_small_pallet, no_of_boxes, no_of_sqm,packing_net_weight,packing_gross_weight)  SELECT '.$rowcon->purchaseordertrn_id.','.$id.',design_id,finish_id,client_name,barcode_no,no_of_pallet,no_of_big_pallet, no_of_small_pallet, no_of_boxes,no_of_sqm,packing_net_weight,packing_gross_weight FROM tbl_performa_packing as mst WHERE   performa_trn_id='.$rowcon->performa_trn_id;
						$this->db->query($copyqry1);
						 
					}
			return 1;
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
	public function getpurchaseproductrate($id,$product_id,$seller_id)
	{
		$q= $this->db->select("mst.*,finish.finish_name,model.model_name,(SELECT design_rate FROM `tbl_design_suppiler_rate` where product_id = ".$product_id." and finish_id = mst.finish_id and supplier_id = ".$seller_id." and status = 0) as mst_design_rate,(SELECT product_rate_per FROM `tbl_design_suppiler_rate` where product_id = ".$product_id." and finish_id = mst.finish_id and supplier_id = ".$seller_id." and status = 0) as product_rate_per")
			 ->from("tbl_purchase_packing as mst")
			 ->join('tbl_finish as finish','finish.finish_id=mst.finish_id','LEFT')
			 ->join('tbl_packing_model as model','model.packing_model_id=mst.design_id','LEFT')
			 ->where("mst.purchaseordertrn_id",$id)
			 ->get();
		 
		return $q->result();
	}
	public function get_packing($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name,porder.seller_id")
			 ->from("tbl_purchase_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->join("tbl_purchase_order as porder","porder.purchase_order_id=mst.purchase_order_id","LEFT")
			 ->where("purchaseordertrn_id",$id)
			 ->get();
		  
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
	public function get_packing_detail($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_product_size as mst")
			  ->where("product_id",$id)
			  ->where("status",0)
			 ->get();
		  
		return $q->result();
	}
	
	public function get_performapacking_detail($performa_invoice_id,$product_data)
	{
		$countproduct = count($product_data);
		$all_product_check_array = array();
		for($i=0;$i<$countproduct;$i++)
		{
			array_push($all_product_check_array,$product_data[$i]->invoice_product_data_id);
		}
		$checkpopacking = 'SELECT model_details,sum(boxes) as total_boxes FROM tbl_product_packing as mst WHERE mst.invoice_id='.$performa_invoice_id.' group by mst.model_details'; 
		$get_previous_qry = $this->db->query($checkpopacking);
		$get_previous_array = $get_previous_qry->result();
		$model_details_array = array();
		foreach($get_previous_array as $check_row)
		{			
			$checkpopackingtrn = 'SELECT  mst.model_details,sum(packing_boxes) as total_boxes FROM  tbl_popacking as mst inner join tbl_purchaseordertrn as trn on trn.purchaseordertrn_id=mst.purchaseordertrn_id where find_in_set(trn.invoice_product_data_id,(SELECT GROUP_CONCAT(invoice_product_data_id) from tbl_product_packing where invoice_id = '.$performa_invoice_id.')) and  mst.model_details = '.$check_row->model_details.'  GROUP by mst.model_details';  
			$get_previous_trn_qry = $this->db->query($checkpopackingtrn);
			$get_previous_trn_array = $get_previous_trn_qry->row();
			if($check_row->total_boxes <= $get_previous_trn_array->total_boxes)
			{
				array_push($model_details_array,$get_previous_trn_array->model_details);
			}
			
		 }	
		 
	 	$q = $this->db->select("packing.*,trn.model_name,trn.design_file")
			->from('tbl_product_packing as packing')
			->join('tbl_packing_model as trn','trn.packing_model_id=packing.model_details','LEFT')
			 ->where('invoice_id',$performa_invoice_id)
			//->where('!find_in_set(model_details,"'.implode(",",$model_details_array).'") <> 0')
			->where('find_in_set(invoice_product_data_id,"'.implode(",",$all_product_check_array).'") <> 0')
			->order_by('packing.product_packing_id')
			->get();
		 
		return $q->result();
	}
	public function copydesign($productpacking_id,$performa_invoice_id,$purchase_order_id)
	{
		$copyqry = 'SELECT  mst.* FROM  tbl_product_packing as mst inner join tbl_invoice_product_data as trn on trn.invoice_product_data_id=mst.invoice_product_data_id WHERE mst.invoice_id='.$performa_invoice_id.' and mst.product_packing_id in ('.implode(",",$productpacking_id).')'; 
		 $row = $this->db->query($copyqry);
		foreach($row->result() as $row)
		{
			$q3= "SELECT purchaseordertrn_id FROM `tbl_purchaseordertrn` where invoice_product_data_id= ".$row->invoice_product_data_id." and purchase_order_id=".$purchase_order_id;
			$result3 = $this->db->query($q3);
			$purchaseordertrn_detail =  $result3->row();
			$data_purchase_packing = array(
						"purchaseordertrn_id" 		=> $purchaseordertrn_detail->purchaseordertrn_id,
						"purchase_order_id" 		=> $purchase_order_id,
						"purchase_order_no" 		=> $purchase_order_id,
						"packing_details" 			=> $purchaseordertrn_detail->purchaseordertrn_id,
						"model_details" 			=> $row->model_details,
						"design_id" 				=> $row->design_id,
						"sqm" 						=> $row->sqm,
						"plts" 						=> $row->plts,
						"boxes" 					=> $row->boxes,
						"product_short_desc" 		=> $row->product_short_desc,
						"appsqmperboxes" 			=> $row->appsqmperboxes,
						"apwigtperbox" 				=> $row->apwigtperbox,
						"product_rate" 				=> $row->product_rate,
						"pcs_per_box" 				=> $row->pcs_per_box,
						"no_of_pallet" 				=> $row->no_of_pallet,
						"product_box_per_big_plt" 	=> $row->product_box_per_big_plt,
						"product_box_per_small_plt" => $row->product_box_per_small_plt,
						"big_pallet_qty" 			=> $row->big_pallet_qty,
						"small_pallet_qty" 			=> $row->small_pallet_qty,
						"packing_boxes" 			=> $row->packing_boxes,
						"packing_pcs" 				=> $row->packing_pcs,
						"packing_sqmlm" 			=> $row->packing_sqmlm,
						"fcl" 						=> $row->fcl,
						"temp_status" 				=> $row->temp_status
					);
					$q_insert =  $this->db->insert('tbl_popacking',$data_purchase_packing);
		}
		return 1;
	}
	 
	public function insertratedata($modelpricedata)
	{
		 $q =  $this->db->insert('tbl_purchaseorder_rate',$modelpricedata);
		 
		 return $this->db->insert_id();
	}
	public function delete_packing_data($id)
	{
		$this->db->where('purchaseordertrn_id',$id);
		return $this->db->delete('tbl_purchase_packing');
	}
	public function delete_product($id){
		
		$this->db->where('purchaseordertrn_id',$id);
		return $this->db->delete('tbl_purchaseordertrn');
	}
	 
	public function delete_product_packing($id){
		
		$this->db->where('purchaseordertrn_id',$id);
		return $this->db->delete('tbl_purchase_packing');
	}
	public function fetchrecord($id)
	{
		$q = $this->db->where("purchaseordertrn_id",$id);
		$q = $this->db->get("tbl_purchaseordertrn");
		return $q->row();
	}
	public function fetchproductrecord($purchaseordertrn_id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_purchaseordertrn as mst")
			 ->where("purchaseordertrn_id",$purchaseordertrn_id)
			 ->get(); 
		return $q->row();
	}
	public function update_productrecord($data,$id)
	{
		$this->db->where('purchaseordertrn_id', $id); 
		 $this->db->update('tbl_purchaseordertrn',$data); //Set
		 
		 return $this->db->affected_rows();
	}
	public function update_po_packing($data,$id)
	{
		$this->db->where('popacking_id', $id); 
		 $this->db->update('tbl_purchase_packing',$data); //Set
		 
		 return $this->db->affected_rows();
	}
	public function update_po($po_data,$purchase_order_id)
	{
		$q= $this->db->where('purchase_order_id', $purchase_order_id); 
		$q= $this->db->update('tbl_purchase_order',$po_data);
		//	echo $this->db->last_query();
		return $q;//Set 
	}
	public function product_data_save($id){
		$this->db->set('status', '1');   
		$this->db->where('invoice_id', $id);  
		return $this->db->update('tbl_invoice_product_data'); 
	}
	public function postepupdate($id,$step,$temp_status,$remarks){
		$data = array(
          "step" =>$step,
		  "notes"=>$remarks
		); 
	  	$this->db->where('purchase_order_id', $id);
		return $this->db->update('tbl_purchase_order', $data);
	}
	public function all_model_data($id){
		$this->db->where("status=0 and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
	 
		return $q->result();
	} 	
	
	public function packingdata_insert($data){
		
		$insert = $this->db->insert('tbl_popacking',$data);
		return $insert;
	}
	public function packingdata_delete($id){
		 $this->db->where('popacking_id',$id);
		return $this->db->delete('tbl_popacking');
	}
	public function update_packing_details($data,$id)
	{ 
		$this->db->where('popacking_id', $id);
		$updateid= $this->db->update('tbl_popacking', $data);
		return $updateid;
	}
	public function po_stepupdate($id,$step,$image_status,$remarks,$notes){
		$data = array(
          "step" =>$step,
		  "packing_remarks"=>$remarks,
		  "notes"=>$notes,
		  "image_status"=>$image_status
		); 
		 
		$this->db->where('purchase_order_id', $id);
		return $this->db->update('tbl_purchase_order', $data);
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
	public function make_containerdelete($id){
		
		$this->db->where('container_order_by',$id);
		return $this->db->delete('tbl_pomakecontainer');
	}
	public function updateinvoicecontainer($data,$id,$invoice_id)
	{ 
		$array = array('container_order_by' => $id, 'purchase_order_id' =>$invoice_id);
		$this->db->where($array);
		$updateid= $this->db->update('tbl_purchaseordertrn', $data);
		 
		return $updateid;
	}
	public function copycontainter($producttrn_id,$purchase_order_id,$performa_invoice_id)
	{
		  
			$copyqry = 'INSERT INTO  tbl_purchaseordertrn (purchase_order_id,performa_trn_id,product_size_id,product_id,product_container,description_goods,pallet_status,weight_per_box,pallet_weight,big_pallet_weight,small_pallet_weight,boxes_per_pallet,box_per_big_pallet,box_per_small_pallet,sqm_per_box,pcs_per_box,total_no_of_pallet,total_no_of_boxes,total_no_of_sqm,total_pallet_weight,total_net_weight,total_gross_weight,container_half,rowspan_no,container_order_by)  SELECT '.$purchase_order_id.',performa_trn_id,product_size_id,product_id, product_container, description_goods, pallet_status,weight_per_box, pallet_weight, big_pallet_weight,small_pallet_weight, boxes_per_pallet,  box_per_big_pallet,box_per_small_pallet,sqm_per_box,pcs_per_box,total_no_of_pallet,total_no_of_boxes,total_no_of_sqm,total_pallet_weight,total_net_weight,total_gross_weight,container_half,rowspan_no,container_order_by FROM tbl_performa_trn as mst  WHERE find_in_set(mst.performa_trn_id,"'.$producttrn_id.'") and  mst.invoice_id='.$performa_invoice_id;
				$this->db->query($copyqry);
				 
				$q  = "select * from tbl_purchaseordertrn as mst where purchase_order_id = ".$purchase_order_id;
				$q_result = $this->db->query($q);
					foreach($q_result->result() as $rowcon)
					{
					  	$copyqry1 = 'INSERT INTO  tbl_purchase_packing (purchaseordertrn_id,purchase_order_id,design_id, finish_id,client_name,barcode_no,no_of_pallet,no_of_big_pallet, no_of_small_pallet, no_of_boxes, no_of_sqm,packing_net_weight,packing_gross_weight)  SELECT '.$rowcon->purchaseordertrn_id.','.$purchase_order_id.',design_id,finish_id,client_name,barcode_no, no_of_pallet, no_of_big_pallet, no_of_small_pallet, no_of_boxes, no_of_sqm, packing_net_weight,packing_gross_weight FROM tbl_performa_packing as mst WHERE   performa_trn_id='.$rowcon->performa_trn_id;
						$this->db->query($copyqry1);
					}
					 $q_con = "SELECT * FROM (SELECT *, `allproduct_id` REGEXP REPLACE('".$producttrn_id."' , ',', '(\\,|$)|') as haslists FROM `tbl_makecontainer` B where invoice_id=".$performa_invoice_id.") A WHERE A.haslists = 1";
						$result_makecon = $this->db->query($q_con);
						foreach($result_makecon->result() as $row_con)
						{ 
						 $makecontainerqry= "SELECT GROUP_CONCAT(purchaseordertrn_id) as allpo_id,container_order_by FROM `tbl_purchaseordertrn` where find_in_set(performa_trn_id,'".$row_con->allproduct_id."') and purchase_order_id = ".$purchase_order_id;
						$result_con = $this->db->query($makecontainerqry);
						$rel_con = $result_con->row();
						$data = array(
								'allproduct_id'=>$rel_con->allpo_id,
								'container_count'=>1,
								'purchase_order_id'=>$purchase_order_id,
								'mix_net_weight' 	=> $row_con->mix_net_weight,
								 'mix_gross_weight'	=> $row_con->mix_gross_weight,
								'container_order_by'=>$row_con->container_order_by
							);
						$insertid = $this->insert_makecontainer($data);
					 	 
					}
			return 1;
	}
	public function regualr_packing_model_data_image($id)
	{
		$this->db->where("status=0 and seriesgroup_id = 0 and design_file != '' and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
		 
		return $q->result();
	}
	public function regualr_packing_model_data($id)
	{
		$this->db->where("status=0 and seriesgroup_id = 0 and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
		
		return $q->result();
	}
	public function all_seriesgroup_data($id){
		$this->db->where("status=0  and product_id=".$id);
		$q = $this->db->get('tbl_seriesgroup');
		 
		return $q->result();
	}
	public function group_packing_model_data_image($id,$seriesgroup_id)
	{
		$this->db->where("status=0 and seriesgroup_id = ".$seriesgroup_id." and design_file != '' and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
		
		return $q->result();
	}
	public function group_packing_model_data($id,$seriesgroup_id)
	{
		$this->db->where("status=0 and seriesgroup_id = ".$seriesgroup_id." and product_id=".$id);
		$q = $this->db->get('tbl_packing_model');
		
		return $q->result();
	}
	public function fields_data($id)
	{
		$q = 'SELECT * FROM `tbl_po_packing_fields` as mst left join tbl_packing_fields as trn on trn.packing_fields_id=mst.packing_fields_id where purchase_order_id='.$id.'   ORDER BY trn.`packing_fields_id` ASC';
		$q_con = $this->db->query($q);
		if($q_con->num_rows()==0)
		{
			$q = 'SELECT * FROM `tbl_packing_fields` ORDER BY `packing_fields_id` ASC';
			$q_con = $this->db->query($q);
			$result = $q_con->result();
		}
		else
		{
			$result = $q_con->result();
		}
		return  $result;
	}
	public function delete_packing_fields_data($id)
	{
		 $this->db->where('purchase_order_id',$id);
		return $this->db->delete('tbl_po_packing_fields');
	}
	public function insert_packing_fields($fields_data)
	{
		 $q =  $this->db->insert('tbl_po_packing_fields',$fields_data);
		 return $this->db->insert_id();
	}
	public function getrate($purchaseordertrn_id,$purchase_order_id,$product_id,$packing_model_id)
	{
		$q = "SELECT seriesgroup_id FROM `tbl_packing_model` where packing_model_id = ".$packing_model_id;
		$q_con = $this->db->query($q);
	 	$result_mst =  $q_con->row();
		$q1 = "SELECT grp.seriesgroup_name,mst.* FROM `tbl_purchaseorder_rate` as mst left join tbl_seriesgroup as grp on grp.seriesgroup_id = mst.model_type_id where model_type_id = ".$result_mst->seriesgroup_id." and purchase_order_id=".$purchase_order_id." and mst.product_id=".$product_id." and purchaseordertrn_id=".$purchaseordertrn_id;
		$q_con1 = $this->db->query($q1);
	 	return $q_con1->row();
		
	} 
	public function getdefault_rate($purchaseordertrn_id,$purchase_order_id,$product_id,$packing_model_id)
	{
		 $q = "SELECT * FROM `tbl_purchaseordertrn`  WHERE purchaseordertrn_id = ".$purchaseordertrn_id." and purchase_order_id = ".$purchase_order_id." and product_id=".$product_id;
		 $q_con = $this->db->query($q);
	 	 return $q_con->row();
	}
	public function packing_model_data_from_invoice($id,$seriesgroup_id)
	{
		$this->db->where("model_type_id = ".$seriesgroup_id." and purchaseordertrn_id=".$id);
		$q = $this->db->get('tbl_purchaseorder_rate');
	//	echo $this->db->last_query();
		return $q->num_rows();
	}
	public function update_productpackingrecord($data_packing,$id)
	{
		$this->db->where('purchaseordertrn_id',$id);
		$updateid= $this->db->update('tbl_popacking', $data_packing);
	 
		return $updateid;
	}
	public function getdesignrate($seller_id,$product_id,$packing_model_id,$finish_id)
	{
		 $where = '';
		  $where  = ' and finish_id = '.$finish_id;
		 $productid = explode(" - ",$product_id);
		 $q =  "SELECT `mst`.* FROM `tbl_design_suppiler_rate` as `mst` WHERE mst.`status` = '0' AND mst.supplier_id  = ".$seller_id." and product_id = ".$productid[0].$where;
		 $query = $this->db->query($q);
		 return $query->row();
	}

	/**
	 * Rate from tbl_design_rate by product_id + finish_id. Returns design_rate, product_rate_per.
	 */
	public function get_design_rate_from_tbl_design_rate($product_id, $finish_id)
	{
		$product_id = (int) $product_id;
		$finish_id = (int) $finish_id;
		if (!$product_id || !$finish_id) {
			return null;
		}
		$q = $this->db->select('design_rate, product_rate_per')
			->from('tbl_design_rate')
			->where('status', 0)
			->where('product_id', $product_id)
			->where('finish_id', $finish_id)
			->order_by('design_rate_id', 'DESC')
			->limit(1)
			->get();
		return $q->row();
	}
}
