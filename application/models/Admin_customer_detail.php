<?php 
class Admin_customer_detail extends CI_Model{

	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	
	//fetch bank modal
	public function bank_select()
	 {
		$q= $this->db->select("mst.*")
			 ->from("bank_detail as mst")
			 //->where('mst.status',"0")
			->where('mst.id not in (select id from customer_detail where id = mst.id ) and mst.id !=',0)
			 ->get();
			  
		 return $q->result();
	 }
	
	public function get_customer($id){
		$q=$this->db->where('id',$id);
		$q=$this->db->get('customer_detail');

		return $q->row();
	}
	public function insert_user_customer($data){
		$q =  $this->db->insert('tbl_user_wise_customer',$data);
		
		return $this->db->insert_id();
	}
	public function getforwarerdata()
	{
		$q= $this->db->select("mst.*")
			->from("tbl_forwarer_master as mst")
			->where('mst.status',"0")
			->get();
		return $q->result();
	}	
	
	public function getdesigndata()
	{
		$q= $this->db->select("mst.*")
			->from("tbl_packing_model as mst")
			//->where('mst.status',"0")
			->get();
		return $q->result();
	}
	
	public function getcompanydata()
	 {
		 //$q = $this->db->where("status",0);
		 $q= $this->db->get("customer_detail");
		  
		 return $q->result();
	 }
	 
	public function insert_customer_user($data){
		$q =  $this->db->insert('tbl_user_wise_customer',$data);
		return $this->db->insert_id();
	}
	
	public function insert_customer_design($data){
		$q =  $this->db->insert('tbl_customer_wise_design',$data);
		return $this->db->insert_id();
	}
	
	public function update_customer_user($customer_wise_user_id,$data){
		$this->db->where('user_wise_customer_id',$id);
		$q=$this->db->update('tbl_user_wise_customer',$data);
		return $q;
	}
	
	
	public function get_customer_wise_user($customer_id1)
	{
		$sql = "select * from tbl_user_wise_customer as mst inner join tbl_user as user on user.user_id = mst.user_id where mst.status = 0 and mst.customer_id=".$customer_id1;
		$query = $this->db->query($sql);
	    return $query->result(); 
	}
	
	public function get_customer_wise_designs($designid1)
	{
		$sql = "select * from tbl_customer_wise_design as mst inner join tbl_user as user on user.user_id = mst.user_id where mst.status = 0 and mst.designid=".$designid1;
		$query = $this->db->query($sql);
	    return $query->result(); 
	}
	
	public function getuser(){
		$q = $this->db->get('tbl_user');
		return $q->result();
	}
	
	public function remove_user_record($id,$data)
	{
		$q = $this->db->where('user_wise_customer_id',$id);
		$q = $this->db->update('tbl_user_wise_customer',$data);
		
		return $q;
	}
	
	public function terms_insert($data1)
	{
		$id = $this->db->insert('tbl_payment_terms',$data1); 
		return $this->db->insert_id();
	}
	
	public function check_consigne_id($c_companyname)
	{
		// $this->db->where('status',0);
		$this->db->where('c_companyname',$c_companyname);
		$q = $this->db->get('customer_detail');
		return $q->row();
	}
	
	public function check_terms_update($payment_terms)
	{
		$q=$this->db->where('payment_terms',$payment_terms);
		
		$q=$this->db->get('tbl_payment_terms');

		return $q->row();
	}

	public function agentdata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_agent_master as mst")
			 ->where('mst.status',"0")
			 ->where('is_active',"Yes")
			 ->where('mst.id not in (select agent_id from customer_detail where agent_id = mst.id and status=0) and mst.id !=',0)
			 ->get();
			  
		 return $q->result();
	 }
	 
	public function getpaymenttermsdata()
	{
		$q= $this->db->select("mst.*")
		->from("tbl_payment_terms as mst")
		->where('mst.status',"0")
		->where('is_active',"Yes")
		->get();
		return $q->result();
	}
	
	public function s_insert($data)
	{
		$insertid = $this->db->insert('customer_detail',$data);
		return $this->db->insert_id();

	}
	public function insert_notify($data)
	{
		$insertid = $this->db->insert('customer_add_consigner',$data);
		return $this->db->insert_id();

	}
	public function insert_customer_box_design($data)
	{
		$insertid = $this->db->insert('tbl_customer_box_design',$data);
		return $this->db->insert_id();

	}
	public function update_customer_box_design($data,$customer_box_design_id)
	{
		$q = $this->db->where('customer_box_design_id',$customer_box_design_id);	
		$q =  $this->db->update('tbl_customer_box_design',$data);	
		return $q;	
	}	
	public function insert_additional_detail($data)
	{
		$insertid = $this->db->insert('tbl_customer_add_detail',$data);
		return $this->db->insert_id();

	}
	public function update_additional_detail($data,$customer_add_detail_id)
	{
		$q = $this->db->where('customer_add_detail_id',$customer_add_detail_id);	
		$q =  $this->db->update('tbl_customer_add_detail',$data);	
		return $q;	
	}
	public function get_additional_detail($id){
		
		$q = $this->db->select('cust.*')
			 ->from('tbl_customer_add_detail as cust')
			 ->where('customer_id',$id)
			 
			->get();	
		
		return $q->row();
	}
	public function get_pallet_type()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_pallet_type');
		return $q->result();
	}	
	public function get_notify_detail($id)
	{
		$q = $this->db->where('id',$id);
	 	$q = $this->db->get('customer_add_consigner');
		return $q->row();
	}	
	public function insert_design_rate($data)
	{
		$insertid = $this->db->insert('tbl_design_rate',$data);
		return $this->db->insert_id();

	}	
	public function insert_design_detail($data)
	{
		$insertid = $this->db->insert('tbl_design_detail',$data);
		return $this->db->insert_id();

	}	
	 
	public function consign_select($id){
		
		$q = $this->db->select('cust.*')
			 ->from('customer_add_consigner as cust')
	 		->where('customer_id',$id)
			->order_by("cust.id","desc")
			->get();	
		
		return $q->result();
	}

	public function s_edit_select($id){
		$this->db->where('id',$id);
		$q = $this->db->get('customer_detail');
		return $q->row();
	}
	
	

	public function s_edit($data,$id)
	{
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('customer_detail',$data);	
		return $q;	
	}
	public function update_notify($data,$id)
	{
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('customer_add_consigner',$data);	
		return $q;	
	}
	
	public function delete_record($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('customer_add_consigner');
	}
	
	public function update_design_rate($data,$id)
	{
		$q = $this->db->where('design_rate_id',$id);	
		$q =  $this->db->update('tbl_design_rate',$data);	
		 
		return $q;	
	}

	public function update_design_detail($data,$id)
	{
		$q = $this->db->where('design_detail_id',$id);	
		$q =  $this->db->update('tbl_design_detail',$data);	
		return $q;	
	}
	
	
	public function s_del($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('customer_detail');
	}
	
	
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('customer_detail',$data);	
		return $q;	
	}
	 public function getcurrencydata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_currency as mst")
			->where('status',"0")
			->get();
		 return $q->result();
	 }
	 public function getproductdata($product_id,$cust_id)
	 {
		 $q= $this->db->select("mst.*,series.series_name,series.hsnc_code,series.sale_unit")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			  ->where('mst.status',"0")
			   ->where(!empty($product_id)?'mst.product_id':'mst.product_id !=',!empty($product_id)?$product_id:0)
			 ->order_by('CASE WHEN (select product_id from tbl_design_rate where product_id = mst.product_id and cust_id = '.$cust_id.' limit 1) THEN mst.product_id end desc')
			 ->get();
			 
			 $return1 = array();
			 foreach ($q->result() as $category) 
			{
					$category->finish_data = $this->get_product_finish($category->product_id,$cust_id);
					 
					$return1[] = $category;
			}
		 
		 return $return1;
	 }
	  public function get_sup_productdata($product_id)
	 {
		 $q= $this->db->select("mst.*,series.series_name,series.hsnc_code,series.purchase_unit")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->join("tbl_design_suppiler_rate as rate","rate.product_id=mst.product_id","LEFT")
			 ->join("tbl_packing_model as model","model.product_id=mst.product_id","INNER")
			 ->where('mst.status',"0")
			 ->where('model.finish_id !=',"0")
			  ->where(!empty($product_id)?'mst.product_id':'mst.product_id !=',!empty($product_id)?$product_id:0)
			 ->group_by('mst.product_id')
			 ->order_by('rate.design_suppiler_rate_id desc')
			 ->get();
			 
			 $return1 = array();
			 foreach ($q->result() as $category) 
			{
					$category->finish_data = $this->get_sup_product_finish($category->product_id);
					 
					$return1[] = $category;
			}
		 
		 return $return1;
	 }
	   
	  public function get_sup_product_finish($product_id)
	 {
			  $q =  'SELECT mst.* FROM `tbl_finish` as mst  left join tbl_design_suppiler_rate as rate on rate.finish_id = mst.finish_id 
				and  rate.product_id = '.$product_id.' WHERE find_in_set(mst.finish_id,(SELECT GROUP_CONCAT(finish_id) FROM `tbl_packing_model` where product_id = '.$product_id.' and mst.status = 0)) and mst.status = 0 GROUP BY mst.finish_id order by rate.design_rate desc,design_suppiler_rate_id desc';
			  $query = $this->db->query($q);
	 	return $query->result() ;
	 }
	  public function getproductdesign($product_id,$packing_model_id)
	 {
		 $q= $this->db->select("mst.*,series.series_name,series.hsnc_code,series.sale_unit")
			->from("tbl_product as mst")
			->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			->join("tbl_design_rate as rate","rate.product_id=mst.product_id","LEFT")
			->where('mst.status',"0")
			->where(!empty($product_id)?'mst.product_id':'mst.product_id !=',!empty($product_id)?$product_id:0)
			->group_by('mst.product_id')
			->order_by('rate.design_rate_id desc')
			 ->get();
			 $return1 = array();
			 foreach ($q->result() as $category) 
			 {
					$category->design_data = $this->getdesign($category->product_id,$packing_model_id);
					$return1[] = $category;
			 }
		 
		 return $return1;
	 }
	 public function getdesign($product_id,$packing_model_id)
	 {
			$where = '';
			if(!empty($packing_model_id))
			{
				$where = ' and mst.packing_model_id = '.$packing_model_id;
			}
		 $q =  'SELECT mst.* FROM `tbl_packing_model` as mst left join tbl_design_rate as rate on rate.finish_id = mst.finish_id 
				and  rate.product_id = '.$product_id.' WHERE  mst.product_id = '.$product_id.' and mst.status = 0'.$where.' group by mst.packing_model_id order by rate.design_rate desc,design_rate_id desc';
		 $query = $this->db->query($q);
			 foreach ($query->result() as $category) 
			 {
					$category->finish_data = $this->get_design($category->packing_model_id);
					$return1[] = $category;
			 }
		 
	 	return $return1;
	 }
	  public function get_design($packing_model_id)
	 { 
	 
		$q =  'SELECT * FROM `tbl_finish` WHERE find_in_set(finish_id,(SELECT GROUP_CONCAT(finish_id) FROM `tbl_packing_model` where packing_model_id = '.$packing_model_id.' and status = 0))';
			  $query = $this->db->query($q);
	 	return $query->result() ;
	 }
	   // public function get_product_finish($product_id,$cust_id)
	 // {
			 // $q =  'SELECT mst.* FROM `tbl_finish` as mst   WHERE find_in_set(mst.finish_id,(SELECT GROUP_CONCAT(finish_id) FROM `tbl_packing_model` where product_id = '.$product_id.' and mst.status = 0)) and mst.status = 0 order by CASE WHEN (select design_rate from tbl_design_rate where finish_id = mst.finish_id and cust_id = '.$cust_id.' and product_id = '.$product_id.') THEN mst.finish_id end desc';
			  // $query = $this->db->query($q);
	 	// return $query->result() ;
	 // }
	 
		public function get_product_finish($product_id, $cust_id)
		{
			$q = 'SELECT mst.*
				  FROM tbl_finish AS mst
				  WHERE FIND_IN_SET(
						  mst.finish_id,
						  (SELECT GROUP_CONCAT(finish_id)
						   FROM tbl_packing_model
						   WHERE product_id = ' . (int)$product_id . ' AND status = 0)
						)
					AND mst.status = 0
				  ORDER BY (
					  SELECT design_rate
					  FROM tbl_design_rate
					  WHERE finish_id = mst.finish_id
						AND cust_id = ' . (int)$cust_id . '
						AND product_id = ' . (int)$product_id . '
					  LIMIT 1
				  ) DESC, mst.finish_id DESC';

			$query = $this->db->query($q);
			return $query->result();
		}


	 public function getproductdesign_filter($product_id)
	 {
		 $where = '';
		 if(!empty($product_id))
		{
			 $where = ' and product_id = '.$product_id;
		}
		 $q =  'SELECT * FROM `tbl_packing_model` WHERE   status = 0'.$where;
			  $query = $this->db->query($q);
	 	return $query->result() ;
	 }
	  public function getdesign_data($packing_model_id)
	 {
		$q =  'SELECT * FROM `tbl_packing_model` WHERE model_name in ("'.$packing_model_id.'")  and status = 0';
			  $query = $this->db->query($q);
	 	return $query->row() ;
	 }
	  public function get_finish($finish_id)
	 {
		$q =  "SELECT `mst`.* FROM `tbl_finish` as `mst` WHERE mst.`status` = '0' AND mst.finish_id in (".$finish_id.")";
		 $query = $this->db->query($q);
		 return $query->result();
	 }
	  public function getfinish($finish_name)
	 {
		$q =  "SELECT `mst`.* FROM `tbl_finish` as `mst` WHERE mst.`status` = '0' AND mst.finish_name in ('".$finish_name."')";
		 $query = $this->db->query($q);
		 return $query->row();
	 }
	  public function get_product($product_name)
	 {
		$q =  "  SELECT product_id FROM `tbl_product` as mst inner join tbl_series as ser on ser.series_id = mst.series_id where CONCAT(size_type_mm,' (',series_name,')',IF(IFNULL(thickness, '') = '', '',concat(' - ',thickness,' MM'))) = '".$product_name."'";
		 $query = $this->db->query($q);
		 return $query->row();
	 }
	  public function get_design_rate($cust_id,$product_id,$finish_id)
	 {
		 $where = '';
		 
			 $where  = ' and finish_id = '.$finish_id;
		 
		$q =  "SELECT `mst`.* FROM `tbl_design_rate` as `mst` WHERE mst.`status` = '0' AND mst.cust_id  = ".$cust_id." and product_id = ".$product_id.$where;
		 $query = $this->db->query($q);
		 return $query->row();
	 }
	 public function get_design_suppiler_rate($supplier_id,$product_id,$finish_id)
	 {
		 $where = '';
		 
			 $where  = ' and finish_id = '.$finish_id;
		 
		$q =  "SELECT `mst`.* FROM `tbl_design_suppiler_rate` as `mst` WHERE mst.`status` = '0' AND mst.supplier_id  = ".$supplier_id." and product_id = ".$product_id.$where;
		 $query = $this->db->query($q);
		 return $query->row();
	 }
	  public function get_design_data($cust_id,$product_id,$packing_model_id,$finish_id)
	 {
		 $where = '';
		 
			 $where  = ' and packing_model_id = '.$packing_model_id;
			 if(!empty($finish_id))
			 {
				$where  .= ' and finish_id = '.$finish_id;
			 }
		$q =  "SELECT `mst`.* FROM `tbl_design_detail` as `mst` WHERE mst.`status` = '0' AND mst.cust_id  = ".$cust_id." and product_id = ".$product_id.$where;
		 $query = $this->db->query($q);
		 return $query->row();
	 }
	 public function get_all_size($id)
	 {
		 $q= $this->db->select("mst.*,mst.product_id as productid,mst.size_type_mm as sizetypemm,series.series_name,cust.*")
			 ->from("tbl_product as mst")
			 ->join("tbl_customer_box_design as cust","cust.product_id = mst.product_id and customer_id=".$id,"LEFT")
			 ->join("tbl_series as series","series.series_id = mst.series_id","LEFT")
		 	 ->where('mst.status',"0")
		 	 ->order_by('mst.product_id',"asc")
	 		 ->get();
		
		foreach ($q->result() as $category)
		{
			
			$sub = $category->product_id;
			$category->packing = $this->get_packing($category->product_id);
			$return[] = $category;
		}	 
		 return $return;
	 }
	  public function get_packing($product_id)
	{
		$q = $this->db->where('status',0);
		$q = $this->db->where('product_id',$product_id);
	 	$q = $this->db->get('tbl_product_size');
		 
		return $q->result();
	}
	 
	 public function get_box_design()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_box_design');
		return $q->result();
	}
	public function checkcountry($country_name)
	{
		
		$q =  "SELECT `mst`.* FROM `country_detail` as `mst` WHERE  LOWER(mst.c_name) Like '%".strtolower($country_name)."%'";
		 $query = $this->db->query($q);
		 return $query->row();
	}
	public function checkcurrency($currency){
		
		$q =  "SELECT `mst`.* FROM `tbl_currency` as `mst` WHERE  LOWER(mst.currency_name) Like '%".strtolower($currency)."%'";
		 $query = $this->db->query($q);
		 return $query->row();
	}
	public function checkalready($data)
	{
		
		  $q =  "SELECT `mst`.* FROM `customer_detail` as `mst` WHERE  LOWER(mst.c_companyname) Like '%".strtolower($data['c_companyname'])."%' and c_country =".$data['c_country']." and c_contact ='".$data['c_contact']."'";
		 $query = $this->db->query($q);
		 return $query->num_rows();
	}
	public function check_customer($import_cust_id,$custname)
	{
		
		$q =  "SELECT `mst`.* FROM `customer_detail` as `mst` WHERE  LOWER(mst.c_companyname) Like '%".strtolower($custname)."%' and id =".$import_cust_id;
		 $query = $this->db->query($q);
		 return $query->num_rows();
	}
	public function check_sup($import_supplier_id,$supname)
	{
		
		$q =  "SELECT `mst`.* FROM `tbl_supplier` as `mst` WHERE  LOWER(mst.company_name) Like '%".strtolower($supname)."%' and supplier_id =".$import_supplier_id;
		 $query = $this->db->query($q);
		 return $query->num_rows();
	}
	 public function get_fumigation()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_fumigation');
		return $q->result();
	}
	public function get_pallet_cap()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_pallet_cap');
		return $q->result();
	}
	public function get_supplier($id)
	{
		$q = $this->db->where('supplier_id',$id);
	 	$q = $this->db->get('tbl_supplier');
		return $q->row();
	}
	public function update_sup_design_rate($data,$id)
	{
		$q = $this->db->where('design_suppiler_rate_id',$id);	
		$q =  $this->db->update('tbl_design_suppiler_rate',$data);	
		 
		return $q;	
	}
	public function insert_sup_design_rate($data)
	{
		$insertid = $this->db->insert('tbl_design_suppiler_rate',$data);
		return $this->db->insert_id();

	}	
	public function get_cust_product_detail($product_id,$cust_id)
	{
		$q = $this->db->where('customer_id',$cust_id);
		$q = $this->db->where('product_id',$product_id);
	 	$q = $this->db->get('tbl_cust_product_detail');
		  
		return $q->row();
	}
	public function insert_product_detail($data)
	{
		$insertid = $this->db->insert('tbl_cust_product_detail',$data);
		return $this->db->insert_id();

	}
	public function update_product_detail($data,$id)
	{
		$q = $this->db->where('cust_product_detail_id',$id);	
		$q =  $this->db->update('tbl_cust_product_detail',$data);	
		 
		return $q;	
	}
	 public function check_cust_addtional($customer_id,$product_id)
	 {
		 
		 
		$q =  "SELECT `mst`.* FROM `tbl_customer_box_design` as `mst` WHERE mst.`status` = '0' AND mst.customer_id  = ".$customer_id." and product_id = ".$product_id;
		 $query = $this->db->query($q);
		 return $query->row();
	 }
}

?>