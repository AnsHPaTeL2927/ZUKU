<?php
class Admin_product_invoice extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function updateseq($sequeance,$performainvoice_id,$id)
	{
		$qry = "select performa_trn_id,seq from tbl_performa_trn where invoice_id = ".$performainvoice_id." order by seq asc";
		$q_con = $this->db->query($qry);
		$seq = $sequeance;
		
		foreach($q_con->result() as $row)
		{
		 	if($sequeance <= $row->seq)
			{
				$sequeance++;
				$data = array("seq" => $sequeance);
				$q= $this->db->where('performa_trn_id', $row->performa_trn_id); 
				$q= $this->db->update('tbl_performa_trn',$data);
				
			 
		 	}
			if($id == $row->performa_trn_id)
			{
				$data1 = array("seq" => $seq);
				$q1= $this->db->where('performa_trn_id', $row->performa_trn_id); 
				$q1= $this->db->update('tbl_performa_trn',$data1);
			}
			
		}
		 
		 return 1;
	}
	public function insert_po_producttrn_record($data)
	{
		 $this->db->insert('tbl_purchaseordertrn',$data);
		 return $cid = $this->db->insert_id();
	} 
	public function insert_additional($data){
		$q =  $this->db->insert('tbl_performa_additional_detail',$data);
		return $this->db->insert_id();
	}
	public function insert_boxdesign_data($data){
		$q =  $this->db->insert('tbl_performa_box_design',$data);
		return $this->db->insert_id();
	}
	public function select_supplier(){
		$q = $this->db->get('tbl_supplier');
		return $q->result();
	}
	public function update_additional($data,$performa_additional_detail_id){
		$q= $this->db->where('performa_additional_detail_id', $performa_additional_detail_id); 
		$q= $this->db->update('tbl_performa_additional_detail',$data);
		//	echo $this->db->last_query();
		return $q;//Set 
	}
	public function select_invoice_data($id)
	{
		$q = $this->db->select('invoice.*, consign.c_name,cur.currency_name,cur.currency_code,cur.currency_id,term.terms_name')
			 ->from('tbl_performa_invoice as invoice')
			->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			->join('tbl_currency as cur', 'invoice.invoice_currency_id = cur.currency_id', 'LEFT')
			->join('tbl_terms as term', 'term.terms_id = invoice.terms_id', 'LEFT')
			->where('performa_invoice_id',$id)
			->order_by("performa_date", "desc")
			->get();
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
	public function allsizeproduct()
	{
		 $q= $this->db->select("mst.*,series.series_name,detail.orderby,series.hsnc_code,size.product_packing_name,size.product_size_id")
			 ->from("tbl_product as mst")
			 ->join("tbl_product_size as size","size.product_id=mst.product_id","LEFT")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->order_by('detail.orderby asc, series.series_name asc, mst.product_id desc')
			 ->where('mst.status',"0")
			 ->where('size.status',"0")
			 ->get();
		  
		 return $q->result();
	}
	
	public function get_product_size($id,$mode,$customer_id)
	{
	  $q = $this->db->select('mst.*, serices.hsnc_code, pro.size_type_mm, pro.defualt_rate, pro.thickness, hsnc.p_name, serices.series_name,design.box_design_id, design.pallet_type_id')
			->from('tbl_product_size as mst')
			->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as serices','serices.series_id = pro.series_id', 'LEFT')
			->join('product_code_detail as hsnc','hsnc.hsnc_code = serices.hsnc_code', 'LEFT')
			->join('tbl_customer_box_design as design','design.product_id = pro.product_id and customer_id = '.$customer_id, 'LEFT')
			->where('mst.product_size_id',$id)
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
	public function hsncproductsizedetail($id,$mode,$consigne_id)
	{
	  $q = $this->db->select('mst.*, 
							serices.hsnc_code,serices.series_name, 
							pro.size_type_mm, pro.defualt_rate,
							pro.thickness, hsnc.p_name, 
							serices.series_name,
							design.box_design_id,
							design.pallet_type_id')
			->from('tbl_product_size as mst')
			->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as serices','serices.series_id = pro.series_id', 'LEFT')
			->join('product_code_detail as hsnc','hsnc.hsnc_code = serices.hsnc_code', 'LEFT')
			->join('tbl_customer_box_design as design','design.product_id = pro.product_id and customer_id = '.$consigne_id, 'LEFT')
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
	public function insert_productrecord($data)
	{
		$q =  $this->db->insert('tbl_performa_trn',$data);
		 
		return $this->db->insert_id();
	}
	public function insert_makecontainer($data)
	{
		return $this->db->insert('tbl_makecontainer',$data);
	}
	public function get_container_data($id)
	{
		$q = $this->db->where('invoice_id',$id);
	 	$q = $this->db->get('tbl_makecontainer');
		return $q->result();
	}
	public function get_fumigation()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_fumigation');
		return $q->result();
	}
	public function get_pallet_type()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_pallet_type');
		return $q->result();
	}
	public function get_pallet_cap()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_pallet_cap');
		return $q->result();
	}
	public function get_box_design()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_box_design');
		return $q->result();
	}
	public function get_additional_data($id)
	{
		$q = $this->db->where('performa_id',$id);
	 	$q = $this->db->get('tbl_performa_additional_detail');
		return $q->row();
	}
	public function productdata_select($id)
	{
		$q = $this->db->select("mst.*,pro.size_type_mm,pro.thickness,series.series_name,
		mst.boxes_per_pallet, pro_size.total_pallent_container, pro_size.no_big_plt_container_new, pro_size.no_small_plt_container_new, pro_size.box_per_container, pro_size.multi_box_per_container, pro_size.total_boxes
		")
			->from('tbl_performa_trn as mst')
			->join("tbl_product as pro","mst.product_id=pro.product_id","LEFT")
			->join('tbl_product_size as pro_size', 'pro_size.product_size_id = mst.product_size_id', 'LEFT')
			->join("tbl_series as series","series.series_id=pro.series_id","LEFT")
			->where('invoice_id',$id) 
			->where('extra_loading',0) 
			->order_by('seq','asc')
			->get(); 
			 
		foreach ($q->result() as $category) {
			$sub = $category->performa_trn_id;
			$category->packing = $this->get_packing($category->performa_trn_id);
			$return[] = $category;
		}
		
		return $return;
	}
	public function all_size($id,$consigne_id)
	{
		$q = $this->db->select("mst.*,pro.size_type_mm,pro.thickness,design.box_design_id,cust.box_design_id as boxdesignid,cust.pallet_type_id as pallettypeid,design.pallet_type_id as designpallet_type_id")
			->from('tbl_performa_trn as mst')
			->join("tbl_product as pro","mst.product_id=pro.product_id","LEFT")
			->join("tbl_performa_box_design as design","pro.size_type_mm=design.size_type_mm and performa_invoice_id =".$id,"LEFT")
			->join("tbl_customer_box_design as cust","pro.size_type_mm=cust.size_type_mm and customer_id =".$consigne_id,"LEFT")
			->where('invoice_id',$id) 
			->group_by("size_type_mm") 
		 	->get(); 
	 
		 return  $q->result();
	}
 	public function get_packing($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name")
			 ->from("tbl_performa_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("performa_trn_id",$id)
			 ->get();
		return $q->result();
	}
	public function getpacking($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name")
			 ->from("tbl_performa_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("performa_packing_id",$id)
			 ->get();
		return $q->row();
	}
	public function delete_product($id){
		
		$this->db->where('performa_trn_id',$id);
		return $this->db->delete('tbl_performa_trn');
	}
	public function delete_boxdesign_data($id){
		
		$this->db->where('performa_invoice_id',$id);
		return $this->db->delete('tbl_performa_box_design');
	}
	public function delete_product_packing($id){
		
		$this->db->where('performa_trn_id',$id);
		return $this->db->delete('tbl_performa_packing');
	}
	public function fetchrecord($id)
	{
		$q = $this->db->where("performa_trn_id",$id);
		$q = $this->db->get("tbl_performa_trn");
		return $q->row();
	}
	public function fetchdesign_detail($id)
	{
		$q = $this->db->where("status",0);
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
	public function getdesignrate($cust_id,$product_id,$packing_model_id,$finish_id)
	{
		 $where = '';
		  $where  = ' and finish_id = '.$finish_id;
		 $productid = explode(" - ",$product_id);
		 $q =  "SELECT `mst`.* FROM `tbl_design_rate` as `mst` WHERE mst.`status` = '0' AND mst.cust_id  = ".$cust_id." and product_id = ".$productid[0].$where;
		 $query = $this->db->query($q);
		 return $query->row();
	}
	public function fetchproductrecord($performa_trn_id)
	{
		$q= $this->db->select("mst.*,code.hsnc_code")
			 ->from("tbl_performa_trn as mst")
			 ->join("tbl_product as pro","pro.product_id = mst.product_id","LEFT")
			 ->join("product_code_detail as code","code.id = pro.series_id","LEFT")
			->where("performa_trn_id",$performa_trn_id)
			 ->get(); 
		return $q->row();
	}
	public function update_productrecord($data,$id){
		$this->db->where('performa_trn_id', $id); 
		return $this->db->update('tbl_performa_trn',$data); //Set 
	}
	public function update_proforma($profoma_data,$performainvoice_id){
		$q= $this->db->where('performa_invoice_id', $performainvoice_id); 
		$q= $this->db->update('tbl_performa_invoice',$profoma_data);
		//	echo $this->db->last_query();
		return $q;//Set 
	}
	
	public function product_data_save($id){
		$this->db->set('status', '1');   
		$this->db->where('invoice_id', $id);  
		return $this->db->update('tbl_invoice_product_data'); 
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
	public function performa_invoice_stepupdate($invoiceid,$step,$remarks)
	{
		$data = array(
          "step" 	=>$step 
		); 
		
	 	$this->db->where('performa_invoice_id', $invoiceid);
		return $this->db->update('tbl_performa_invoice', $data);
	}
	public function update_performainvoice($id,$remarks,$image_status){
		$data = array(
		  "image_status" => $image_status
		);
		if(!empty($remarks))
		{
			$data['remarks'] = $remarks;
		}
		$this->db->where('performa_invoice_id', $id);
		return $this->db->update('tbl_performa_invoice', $data);
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
		return $this->db->delete('tbl_makecontainer');
	}
	public function updateinvoicecontainer($data,$id,$invoice_id)
	{ 
		$array = array('container_order_by' => $id, 'invoice_id' =>$invoice_id);
		$this->db->where($array);
		$updateid= $this->db->update('tbl_performa_trn', $data);
		 
		return $updateid;
	}
	public function get_modeltype($id)
	{
		$q = $this->db->where('product_id',$id);
		$q = $this->db->get('tbl_seriesgroup');
		 
		return $q->result();
	}
	 public function insert_modeltype($data){
		 $q =  $this->db->insert('tbl_model_type',$data);
		 return $this->db->insert_id();
	}
	public function insert_packing_data($packing_data)
	{
		 $q =  $this->db->insert('tbl_performa_packing',$packing_data);
		 return $this->db->insert_id();
	}
	public function delete_rate_data($id)
	{
		$this->db->where('performa_trn_id',$id);
		return $this->db->delete('tbl_performa_packing');
	}
	public function get_ratedata($id)
	{
		$q = "SELECT * FROM `tbl_seriesgroup` as `mst` WHERE find_in_set(seriesgroup_id,'".$id."')";
		$q_con = $this->db->query($q);
		return $q_con->result();
	}
	public function get_edit_ratedata($id,$product_trn_id)
	{
	 	$q = "SELECT * FROM `tbl_performa_product_rate` as `mst` left join tbl_seriesgroup as serices on serices.seriesgroup_id=mst.model_type_id  WHERE find_in_set(seriesgroup_id,'".$id."') and product_trn_id=".$product_trn_id;
		$q_con = $this->db->query($q);
		
		return $q_con->result();
	}
	public function getpackingmodeldata($productsizeid)
	{
		$this->db->where('product_size_id',$productsizeid);
		$q = $this->db->get('tbl_packing_model');
		return $q->result();
	}
	 
	public function update_productpackingrecord($data_packing,$id)
	{
		$this->db->where('performa_packing_id',$id);
		$updateid= $this->db->update('tbl_performa_packing', $data_packing);
	 
		return $updateid;
	}
	public function getpacking_data($id)
	{
		$q = 'SELECT sum(no_of_pallet) as total_pallet,sum(boxes) as totalboxes FROM `tbl_product_packing` where invoice_product_data_id='.$id;
		$result = $this->db->query($q);
		return $result->row();
	}
	public function get_design_data($id,$packing_model_id)
	{
		$array = array("status"=>"0","product_id"=>$id,"model_id" => $packing_model_id);
		$q = $this->db->where($array);
		$q = $this->db->get('tbl_design');
		return $q->result();
	}
	public function get_alreadydesign_data($performa_invoice_id,$design_id)
	{
		$array = array("invoice_id"=>$performa_invoice_id,"design_id" => $design_id);
		$q = $this->db->where($array);
		$q = $this->db->get('tbl_product_packing');
		 
		return $q->num_rows();
	}
	public function fields_data($id)
	{
		$q = 'SELECT * FROM `tbl_performa_packing_fields` as mst left join tbl_packing_fields as trn on trn.packing_fields_id=mst.packing_fields_id where performa_invoice_id='.$id.'   ORDER BY trn.`packing_fields_id` ASC';
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
		 $this->db->where('performa_invoice_id',$id);
		return $this->db->delete('tbl_performa_packing_fields');
	}
	public function insert_packing_fields($fields_data)
	{
		 $q =  $this->db->insert('tbl_performa_packing_fields',$fields_data);
		 return $this->db->insert_id();
	}
	
	public function all_seriesgroup_data($id){
		$this->db->where("status=0  and product_id=".$id);
		$q = $this->db->get('tbl_seriesgroup');
		 
		return $q->result();
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
	public function packing_model_data_from_invoice($id,$seriesgroup_id)
	{
		$this->db->where("model_type_id = ".$seriesgroup_id." and product_trn_id=".$id);
		$q = $this->db->get('tbl_performa_product_rate');
		
		return $q->num_rows();
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
	public function getrate($invoice_product_data_id,$performa_invoice_id,$product_id,$packing_model_id)
	{
		 $q = "SELECT seriesgroup_id FROM `tbl_packing_model` where packing_model_id = ".$packing_model_id;
		$q_con = $this->db->query($q);
	 	$result_mst =  $q_con->row();
		 $q1 = "SELECT grp.seriesgroup_name,mst.* FROM `tbl_performa_product_rate` as mst left join tbl_seriesgroup as grp on grp.seriesgroup_id = mst.model_type_id where model_type_id = ".$result_mst->seriesgroup_id." and performa_invoice_id=".$performa_invoice_id." and product_size_id=".$product_id." and product_trn_id=".$invoice_product_data_id;
		$q_con1 = $this->db->query($q1);
	 	return $q_con1->row();
		
	} 
	public function getdefault_rate($invoice_product_data_id,$performa_invoice_id,$product_id,$packing_model_id)
	{
		 $q = "SELECT * FROM `tbl_invoice_product_data`  WHERE invoice_product_data_id = ".$invoice_product_data_id." and invoice_id = ".$performa_invoice_id." and product_size_id=".$product_id;
		 $q_con = $this->db->query($q);
	 	 return $q_con->row();
	}
	public function getproductrate_packing($id,$seriesgroup_id)
	{
		$q =  "SELECT * from tbl_performa_product_rate where product_trn_id=".$id." and model_type_id=".$seriesgroup_id; 
		$q_con = $this->db->query($q);
		return $q_con->row();
	}
	 public function getfinishdata()
	 {
		 $q = $this->db->where("status",0);
		 $q= $this->db->get("tbl_finish");
		  
		 return $q->result();
	 }
	  public function trancute_tempdata()
	{
		$q = 'truncate  tbl_temp_import_record';
		 $query = $this->db->query($q);
		return 1;
	}
	public function getsize($size_type_mm,$product_packing_name)
	{
		 $q= $this->db->select("mst.*,series.series_name,detail.orderby,series.hsnc_code,size.*")
			 ->from("tbl_product as mst")
			 ->join("tbl_product_size as size","size.product_id=mst.product_id","LEFT")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->order_by('detail.orderby asc, series.series_name asc, mst.product_id desc')
			 ->where('mst.status',"0")
			 ->where('mst.size_type_mm',preg_replace('/\s+/', '', $size_type_mm))
			 ->where('size.product_packing_name',$product_packing_name)
			 ->get();
		    
		 return $q->row();
	}
	public function checkdesign($model_name,$product_id)
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_packing_model as mst")
		 	 ->where("model_name",$model_name)
			 ->where("product_id",$product_id)
			 ->where("status",0)
			 ->get();
		  
		return $q->row();
	}
	public function check_finish($finish_name,$packing_model_id)
	{
		$qry  = 'SELECT finish_id,finish_name FROM `tbl_finish` where find_in_set(finish_id,(SELECT finish_id from tbl_packing_model where packing_model_id = '.$packing_model_id.' and status = 0)) and status = 0 and finish_name = "'.$finish_name.'"';
		 
		$q_con = $this->db->query($qry);
	 	return $q_con->row();
	}
	public function check_pallet_type($pallet_type_name)
	{
		$qry  = 'SELECT * FROM `tbl_pallet_type` where   status = 0 and pallet_type_name = "'.$pallet_type_name.'"';
	 	$q_con = $this->db->query($qry);
	 	return $q_con->row();
	}
	public function check_box_design($box_design_name)
	{
		$qry  = 'SELECT * FROM `tbl_box_design` where   status = 0 and box_design_name = "'.$box_design_name.'"';
	 	$q_con = $this->db->query($qry);
	 	return $q_con->row();
	}
	public function check_error_inexcel()
	{
		 $sql= "SELECT * FROM  tbl_temp_import_record where complete_status = 1";
		 $query = $this->db->query($sql);
		 if($query->num_rows()>0)
		 {
			 return 4;
		 }
		 else
		 {
			 return 1;
		 }
	}
	public function get_tempdata($id)
	{
		 $sql= "SELECT * FROM  tbl_temp_import_record where complete_status = 1 and performa_id=".$id;
		 $query = $this->db->query($sql);
		 return $query->result();
	}
	public function insert_tempdata($data)
	{
		$q =  $this->db->insert('tbl_temp_import_record',$data);
		return $this->db->insert_id();
	}
	public function checkalready($performa_id,$product_id,$design_id,$finish_id,$no_of_boxes,$per,$product_rate,$seq)
	{
		$qry  = 'SELECT * FROM `tbl_performa_packing` as mst inner join tbl_performa_trn as trn on trn.performa_trn_id = mst.performa_trn_id where invoice_id ='.$performa_id.' and product_id ='.$product_id.' and design_id = '.$design_id.' and finish_id='.$finish_id.' and no_of_boxes ='.$no_of_boxes.' and per ="'.$per.'" and product_rate ='.$product_rate.' and seq ='.$seq;
		$q = $this->db->get("tbl_finish");
		$q_con = $this->db->query($qry);
	 	return  $q_con->num_rows();
	}
	public function get_cust_additional_data($id){
		
		$q = $this->db->select('cust.*')
			 ->from('tbl_customer_add_detail as cust')
			 ->where('customer_id',$id)
			->get();	
	 
		return $q->row();
	}
	public function check_production_sheet($id){
		
		$q = $this->db->select('cust.*')
			 ->from('tbl_production_mst as cust')
			 ->where('performa_invoice_id',$id)
			 ->where('status',0)
			->get();	
	 
		return $q->num_rows();
	}
	public function check_production_sheet_with_suppiler($performainvoice_id,$suppiler_id)
	{
		
		$q = $this->db->select('cust.*')
			 ->from('tbl_production_mst as cust')
			 ->where('performa_invoice_id',$performainvoice_id)
			 ->where('supplier_id',$suppiler_id)
			 ->where('status',0)
			->get();	
	 
		return $q->row();
	}
	public function check_production_sheet_withsuppiler($production_mst_id,$suppiler_id)
	{
		
		$q = $this->db->select('cust.*')
			 ->from('tbl_production_mst as cust')
			 ->where('production_mst_id',$production_mst_id)
			 ->where('supplier_id',$suppiler_id)
			 ->where('status',0)
			->get();	
	 
		return $q->row();
	}
	public function check_productionsheet($performa_packing_id)
	{
		
		$q = $this->db->select('trn.*,supplier.supplier_id,supplier.supplier_name,supplier.company_name')
			 ->from('tbl_production_trn as trn')
			 ->join('tbl_production_mst as mst','mst.production_mst_id = trn.production_mst_id', 'LEFT')
			 ->join('tbl_supplier as supplier','supplier.supplier_id = mst.supplier_id', 'LEFT')
		 	 ->where('performa_packing_id',$performa_packing_id)
		 	 ->where('trn.status',0)
		 	 ->group_by('mst.supplier_id')
			 ->get();	
	 
		return $q->result();
	}
	public function check_po($production_mst_id)
	{
		
		$q = $this->db->select('cust.*')
			 ->from('tbl_purchase_order as cust')
			 ->where('production_mst_id',$production_mst_id)
		 	 ->where('status',0)
			->get();	
	 
		return $q->row();
	}
	public function update_producation_trnrecord($data_packing,$production_trn_id)
	{
		$this->db->where('production_trn_id',$production_trn_id);
	 	$updateid= $this->db->update('tbl_production_trn', $data_packing);
	 
		return $updateid;
	}
	public function update_producation_mstrecord($production_mst_id,$data_producation_trn)
	{
		$this->db->where('production_mst_id',$production_mst_id);
	 	$updateid= $this->db->update('tbl_production_mst', $data_producation_trn);
	 
		return $updateid;
	}
	public function update_popackingrecord($popacking_id,$data)
	{
		$this->db->where('popacking_id',$popacking_id);
	 	$updateid= $this->db->update('tbl_purchase_packing', $data);
	 
		return $updateid;
	}
	public function delete_production_mst($performa_packing_id)
	{
		$this->db->where('performa_packing_id',$performa_packing_id);
	 	$updateid= $this->db->delete('tbl_production_trn');
	 
		return $updateid;
	}
}
