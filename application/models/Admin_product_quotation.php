<?php
class Admin_product_quotation extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function updateseq($sequeance,$estimate_id,$id)
	{
		$qry = "select estimate_trn_id,seq from tbl_estimate_trn where estimate_id = ".$estimate_id." order by seq asc";
		$q_con = $this->db->query($qry);
		$seq = $sequeance;
		
		foreach($q_con->result() as $row)
		{
		 	if($sequeance <= $row->seq)
			{
				$sequeance++;
				$data = array("seq" => $sequeance);
				$q= $this->db->where('estimate_trn_id', $row->estimate_trn_id); 
				$q= $this->db->update('tbl_estimate_trn',$data);
				
			 
		 	}
			if($id == $row->estimate_trn_id)
			{
				$data1 = array("seq" => $seq);
				$q1= $this->db->where('estimate_trn_id', $row->estimate_trn_id); 
				$q1= $this->db->update('tbl_estimate_trn',$data1);
			}
			
		}
		 
		 return 1;
	}
	public function select_quotation_data($id)
	{
		$q = $this->db->select('invoice.*, consign.c_name,cur.currency_name,cur.currency_id,term.terms_name,cur.currency_code,')
			 ->from('tbl_estimate as invoice')
			->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			->join('tbl_currency as cur', 'invoice.invoice_currency_id = cur.currency_id', 'LEFT')
			->join('tbl_terms as term', 'term.terms_id = invoice.terms_id', 'LEFT')
			->where('estimate_id',$id)
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
	public function hsncproductcodedetail($hsnc_value)
	{
		$this->db->where('hsnc_code',$hsnc_value);
		$q = $this->db->get('product_code_detail');
		return $q->result();
	}
	public function insert_quotation_trn($data){
		$q =  $this->db->insert('tbl_estimate_trn',$data);
		return $this->db->insert_id();
	}
	public function insert_packing_data($packing_data)
	{
		 $q =  $this->db->insert('tbl_estimate_packing',$packing_data);
		 return $this->db->insert_id();
	}
	public function insert_makecontainer($data)
	{
		return $this->db->insert('tbl_quotation_makecontainer',$data);
	}
	 
	public function productdata_select($id){
		$q = $this->db->select("mst.*,pro.size_type_mm,pro.thickness,series.series_name,
		mst.boxes_per_pallet, pro_size.total_pallent_container, pro_size.no_big_plt_container_new, pro_size.no_small_plt_container_new, pro_size.box_per_container, pro_size.multi_box_per_container, pro_size.total_boxes,series.hsnc_code
		")
			->from('tbl_estimate_trn as mst')
			->join("tbl_product as pro","mst.product_id=pro.product_id","LEFT")
			->join('tbl_product_size as pro_size', 'pro_size.product_size_id = mst.product_size_id', 'LEFT')
			->join("tbl_series as series","series.series_id=pro.series_id","LEFT")
			->where('estimate_id',$id) 
			->order_by('seq','asc')
			->get(); 
		foreach ($q->result() as $category) 
		{
			$sub = $category->estimate_trn_id;
			$category->packing = $this->getproductrate($category->estimate_trn_id);
			$return[] = $category;
		}
		
		return $return;
	}
	public function getproductrate($id)
	{
		$q= $this->db->select("mst.*,model.model_name,model.design_file,finish.finish_name")
			 ->from("tbl_estimate_packing as mst")
		 	 ->join("tbl_estimate_trn as invoicedata","invoicedata.estimate_trn_id=mst.estimate_trn_id","LEFT")
		 	 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
		 	->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("mst.estimate_trn_id",$id)
			 ->get();
		 
		return $q->result();
	}
	public function getpacking($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name")
			 ->from("tbl_estimate_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("estimate_packing_id",$id)
			 ->get();
		return $q->row();
	}
	public function delete_product($id){
		
		$this->db->where('estimate_trn_id',$id);
		return $this->db->delete('tbl_estimate_trn');
	}
	public function delete_product_packing($id){
		
		$this->db->where('estimate_trn_id',$id);
		return $this->db->delete('tbl_estimate_packing');
	}
	public function fetchrecord($id)
	{
		$q = $this->db->where("estimate_trn_id",$id);
		$q = $this->db->get("tbl_estimate_trn");
		return $q->row();
	}
	
	public function fetchproductrecord($id)
	{
		$q= $this->db->select("mst.*,pro.product_id,pro.pcs_per_box")
			 ->from("tbl_estimate_trn as mst")
			 ->join("tbl_product_size as pro","pro.product_id=mst.product_size_id","LEFT")
			 ->where("estimate_trn_id",$id)
			 ->get(); 
		return $q->row();
	}
	public function update_productrecord($data,$id){
		$this->db->where('estimate_trn_id', $id); 
		return $this->db->update('tbl_estimate_trn',$data); //Set 
	}
	public function update_quotation($quotation_data,$quotationid){
		$q= $this->db->where('estimate_id', $quotationid); 
		$q= $this->db->update('tbl_estimate',$quotation_data);
		// 	echo $this->db->last_query();
		return $q;//Set 
	}
	
	public function product_data_save($id){
		$this->db->set('status', '1');   
		$this->db->where('estimate_id', $id);  
		return $this->db->update('tbl_estimate_trn'); 
	}
 
	
	public function get_packing_detail($id)
	{
		$q = $this->db->select("packing.*,trn.model_name,trn.design_file")
			->from('tbl_estimate_packing as packing')
			->join('tbl_packing_model as trn','trn.packing_model_id=packing.model_details','LEFT')
			 ->where('estimate_id',$id)
			->order_by('packing.estimate_packing_id')
			->get();
		return $q->result();
	}
	public function productdataselect($id){
			$q = $this->db->select('mst.*, pro.size_type_mm,pro.size_type_cm,detail.p_name,detail.hsnc_code,series.series_name')
				->from('tbl_invoice_product_data as mst')
				->join('tbl_product_size as product', 'product.product_size_id = mst.product_size_id', 'LEFT')
				->join('tbl_product as pro', 'pro.product_id = mst.product_size_id', 'LEFT')
				->join('tbl_series as series', 'series.series_id = pro.product_id', 'LEFT')
				->join('product_code_detail as detail', 'detail.hsnc_code = series.hsnc_code', 'LEFT')
				->where('invoice_id',$id)
				->order_by('product_container','desc')
				->order_by('container_order_by','asc')
				->get();
			 
			foreach ($q->result() as $category) {
				 $return[$category->invoice_product_data_id] = $category;
				 $return[$category->invoice_product_data_id]->subs  = $this->packing_data($category->invoice_product_data_id,$category->invoice_id);
				 
			 } 
		 
		return $return;
	}
	public function packing_data($id,$invoice_id){
		$array = array('invoice_product_data_id'=>$id,'invoice_id'=>$invoice_id);
		$q = $this->db->select("packing.*,trn.model_name")
			->from('tbl_product_packing as packing')
			->join('tbl_packing_model as trn','trn.packing_model_id=packing.model_details','LEFT')
			->where($array)
			->get();
			//echo $this->db->last_query();
		return $q->result();
	}
	public function packingdata_insert($data){
		
		$insert = $this->db->insert('tbl_estimate_packing',$data);
		//echo $this->db->last_query();
		return $insert;
	}
	
	public function packingdata_delete($id){
		 $this->db->where('quotation_packing_id',$id);
		return $this->db->delete('tbl_estimate_packing');
	}
	public function packingdata_delete_all($id){
		 $this->db->where('estimate_id',$id);
		return $this->db->delete('tbl_estimate_packing');
	}
	public function update_packing_details($data,$id)
	{ 
		$this->db->where('quotation_packing_id', $id);
		$updateid= $this->db->update('tbl_estimate_packing', $data);
		return $updateid;
	}
	
	public function quotation_stepupdate($invoiceid,$step,$remarks,$image_status)
	{
		$data = array(
          "step" =>$step,
		  "remarks"=>$remarks,
		  "image_status"=>$image_status
		); 
		
	 	$this->db->where('estimate_id', $invoiceid);
		return $this->db->update('tbl_quotation', $data);
	}
	public function updatequotation($id,$remarks,$image_status)
	{
		$data = array(
		  "image_status" => $image_status
		);
		if(!empty($remarks))
		{
			$data['remarks'] = $remarks;
		}
		$this->db->where('estimate_id', $id);
		return $this->db->update('tbl_quotation', $data);
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
		return $this->db->delete('tbl_quotation_makecontainer');
	}
	public function update_quotationcontainer($data,$id,$estimate_id)
	{ 
		$array = array('container_order_by' => $id, 'estimate_id' =>$estimate_id);
		$this->db->where($array);
		$updateid= $this->db->update('tbl_estimate_trn', $data);
		 
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
	public function insertratedata($modelpricedata)
	{
		 $q =  $this->db->insert('tbl_estimate_packing',$modelpricedata);
		 return $this->db->insert_id();
	}
	public function delete_rate_data($id)
	{
		$this->db->where('estimate_trn_id',$id);
		return $this->db->delete('tbl_estimate_packing');
	}
	  
	public function getpackingmodeldata($productsizeid)
	{
		$this->db->where('product_size_id',$productsizeid);
		$q = $this->db->get('tbl_packing_model');
		return $q->result();
	}
	 
	public function update_productpackingrecord($data_packing,$id)
	{
		$this->db->where('estimate_packing_id',$id);
		$updateid= $this->db->update('tbl_estimate_packing', $data_packing);
	 
		return $updateid;
	}
	
	public function getpacking_data($id)
	{
		$q = 'SELECT sum(no_of_pallet) as total_pallet,sum(boxes) as totalboxes FROM `tbl_estimate_packing` where estimate_trn_id='.$id;
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
		$q = 'SELECT * FROM `tbl_estimate_packing_fields` as mst left join tbl_packing_fields as trn on trn.packing_fields_id=mst.packing_fields_id where estimate_id='.$id.'   ORDER BY trn.`packing_fields_id` ASC';
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
		 $this->db->where('estimate_id',$id);
		return $this->db->delete('tbl_estimate_packing_fields');
	}
	public function insert_packing_fields($fields_data)
	{
		 $q =  $this->db->insert('tbl_estimate_packing_fields',$fields_data);
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
		$this->db->where("model_type_id = ".$seriesgroup_id." and estimate_trn_id=".$id);
		$q = $this->db->get('tbl_estimate_packing');
		
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
	public function getrate($estimate_trn_id,$estimate_id,$product_id,$packing_model_id)
	{
		$q = "SELECT seriesgroup_id FROM `tbl_packing_model` where packing_model_id = ".$packing_model_id;
		$q_con = $this->db->query($q);
	 	$result_mst =  $q_con->row();
		$q1 = "SELECT * FROM `tbl_estimate_packing` where model_type_id = ".$result_mst->seriesgroup_id." and estimate_id=".$estimate_id." and product_size_id=".$product_id." and estimate_trn_id=".$estimate_trn_id;
		$q_con1 = $this->db->query($q1);
	 	return $q_con1->row();
		
	} 
	public function getdefault_rate($estimate_trn_id,$estimate_id,$product_id,$packing_model_id)
	{
		 $q = "SELECT * FROM `tbl_estimate_trn`  WHERE estimate_trn_id = ".$estimate_trn_id." and estimate_id = ".$estimate_id." and product_size_id=".$product_id;
		 $q_con = $this->db->query($q);
	 	 return $q_con->row();
	}
	public function getproductrate_packing($id,$seriesgroup_id)
	{
		$q =  "SELECT * from tbl_performa_product_rate where product_trn_id=".$id." and model_type_id=".$seriesgroup_id; 
		$q_con = $this->db->query($q);
		return $q_con->row();
	}
	public function get_invoice_html($cust_id)
	{
		$q = $this->db->where('table_id',$cust_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name','estimate_html');
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
	public function company_select(){
		
		$q = $this->db->get('tbl_company_profile');
		return $q->result();
	}
	
}
