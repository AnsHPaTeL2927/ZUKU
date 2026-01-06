<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Country_detail extends CI_controller{
public function __construct(){
	parent:: __construct();
	 
	 $this->load->model('admin_country_detail','sli');
	$this->load->model('menu_model','menu');	
		
	if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
}	
	
public function index($m="")
{

			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data['m'] = $this->sli->s_select();
				$data['erd']= $m;	
				$this->load->model('admin_company_detail');	
				$data['company_detail'] = $this->admin_company_detail->s_select();
				$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
							
				$this->load->view('admin/country_detail',$data);		
			}
			else
			{
				$this->load->view('admin/index');
			}	
}


		public function form()
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
					{
						$this->load->model('admin_bank_detail','bd');
						$data = array('fd' => 'manage', 'result' => $this->bd->b_select());
						$v['fd']= 'manage';
						$this->load->model('admin_company_detail');	
						$data['company_detail'] = $this->admin_company_detail->s_select();	
						$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
										
						$this->load->view('admin/country_detail',$data);
					}
					else
					{
						$this->load->view('admin/index');
					}
		}
private function set_upload_options()
{   
    //upload an image options
    $config = array();
    $config['upload_path'] = './upload/';
    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size']      = '5000';
    $config['overwrite']     = FALSE;

    return $config;
}
public function manage()
{
	$this->load->library('upload');
      $dataInfo = array();
      $files = $_FILES;
    	$cpt = count($_FILES['image']['name']);

    	 for($i=0; $i<$cpt; $i++)
    	{           
	        $_FILES['image']['name']= $files['image']['name'][$i];
	        $_FILES['image']['type']= $files['image']['type'][$i];
	        $_FILES['image']['tmp_name']= $files['image']['tmp_name'][$i];
	        $_FILES['image']['error']= $files['image']['error'][$i];
	        $_FILES['image']['size']= $files['image']['size'][$i];    

	        $this->upload->initialize($this->set_upload_options());
	        $this->upload->do_upload('image');
	        $dataInfo[] = $this->upload->data();
    	}
    	   $data = array(
                    'c_name' => $this->input->post('country_name'),
                    'c_currency' => $this->input->post('c_currency'),
                    'c_code' => $this->input->post('c_code'),
                    'c_latitude' => $this->input->post('c_latitude'),
                    'c_longitude' => $this->input->post('c_longitude'),
                    'company_rules' => $this->input->post('company_rules'),
                    'rex_no_detail' => $this->input->post('rex_no_detail'),
                    'c_image'      =>$dataInfo[0]['file_name']
			);
			$rdata = $this->sli->s_insert($data);
		if($this->input->post('mode')==1)
		{
			 $row['id'] = $rdata;
			 $row['cname'] = $this->input->post('country_name');
			 $row['res'] = 1;
			 echo json_encode($row);
		}
		else
		{
		   if($rdata)
		   {
			   redirect(base_url('country_detail/index'));
		   }
        }
	
}	


//update 

public function form_edit($id){
$this->load->model('admin_bank_detail','bd');

$data = $this->sli->s_edit_select($id);	
 
$v = array('fd'=>'edit','fdv'=>$data, 'result' => $this->bd->b_select(),'menu_data'=>$this->menu->usermain_menu($this->session->usertype_id));


$this->load->view('admin/country_detail',$v);		
	
}

public function edit($eid){

$img = str_replace(array('-', '_', '~'),array('+', '/', '='), $eid);
	
$id = $this->encrypt->decode($img);	 

$sd = 	$this->sli->s_edit_select($id);	
$img_oname = $sd->c_image; 
//print_r($_FILES);
if($_FILES['image']['name'] != "" )	
{

//unlink(FCPATH.'upload/'.$img_oname);
 $this->load->library('upload');
        $dataInfo = array();
        $files = $_FILES;
    	$cpt = count($_FILES['image']['name']);

    	 for($i=0; $i<$cpt; $i++)
    	{           
	        $_FILES['image']['name']= $files['image']['name'][$i];
	        $_FILES['image']['type']= $files['image']['type'][$i];
	        $_FILES['image']['tmp_name']= $files['image']['tmp_name'][$i];
	        $_FILES['image']['error']= $files['image']['error'][$i];
	        $_FILES['image']['size']= $files['image']['size'][$i];    

	        $this->upload->initialize($this->set_upload_options());
	        $this->upload->do_upload('image');
	        $dataInfo[] = $this->upload->data();
    	}
	


	if($dataInfo[0]['file_name'] != '')
	{
		$c_image_temp = $dataInfo[0]['file_name'];
	}
	else{
		$c_image_temp = $sd->c_image;
	}

	$data = array(
                 'c_name' => $this->input->post('country_name'),
                 'c_currency' => $this->input->post('c_currency'),
                 'c_code' => $this->input->post('c_code'),
                 'c_latitude' => $this->input->post('c_latitude'),
                 'c_longitude' => $this->input->post('c_longitude'),
				 'company_rules' => $this->input->post('company_rules'),
				 'rex_no_detail' => $this->input->post('rex_no_detail'),
                 'c_image'      => $c_image_temp
            );





}
else{
	
$sd = 	$this->sli->s_edit_select($id);	
	
$data = array(
                 'c_name' => $this->input->post('c_name'),
                    'c_currency' => $this->input->post('c_currency'),
                    'c_code' => $this->input->post('c_code'),
                    'c_latitude' => $this->input->post('c_latitude'),
                    'c_longitude' => $this->input->post('c_longitude'),
                    'c_image'      => $sd->c_image                           
            );
	
}

$rs = $this->sli->s_edit($data,$id);
if($rs)
{
	redirect(base_url('country_detail/index'));
}	
}
		public function del(){
		$id = $this->input->post('id');
		
		$deleteid = $this->sli->s_del($id);	
		if($deleteid)
		{
			$row['res'] = 1;
			
		}
		else
		{
			$row['res'] = 0;
		}
		echo json_encode($row);	
		}	
}
?>