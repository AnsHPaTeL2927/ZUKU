<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Backup extends CI_controller
{
	
	public function __construct()
	{
		parent:: __construct();
		 
		$this->load->model('Backup_model','backup');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$db_name = 'Tables_in_'.$this->db->database;
 			$get_all_table = $this->backup->get_table();	
		$target_tables = array();
		foreach($get_all_table as $tablerow)
		{
			array_push($target_tables,$tablerow->$db_name);
		}
	 	$tables=false;
		if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); }
		$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n \r\n\r\n\r\n";
		 
	 	foreach($target_tables as $table)
		{
		 	$result	= $this->backup->from_table($table); 
			
			$fields_amount=$result['fieldcount'];  
			$rows_num=$result['affectedrows']; 
			$res = $this->backup->create_table($table);
			
			$TableMLine=$res[0];
			$content .= "\n\n DROP TABLE IF EXISTS ".$table.";\n\n";
			$content .= "\n\n".$TableMLine["Create Table"].";\n\n";
			$st_counter = 0;
			 
				foreach($result['resultrow'] as $allrow)
				{ 			
					$row = array_values($allrow);  
					 	if ($st_counter%100 == 0 || $st_counter == 0 )
						{
							$content .= "\nINSERT INTO ".$table." VALUES";
						}
						$content .= "\n(";
					 	for($j=0; $j<$fields_amount; $j++)  
						{
							$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ; }else {$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}		
						}
						$content .=")";
						if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
						{
							$content .= ";";
						} 
						else 
						{ 
							$content .= ",";
						}	
						$st_counter=$st_counter+1;
				}
			   $content .="\n\n\n";
		}
		
	 	$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
		
			$backup_name =   "Zuku_export_(".date('d-m-Y H').")".".sql";
		//$backup_name =   "addlavi_(".date('d-m-Y H').")".".txt";
		/**Code for backup record add*/
		 
		/**Code for backup record add*/
		 
		header('Content-Type: application/octet-stream');	
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
		echo $content; exit;
		 
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }			
	}
	public function with_zip()
	{
		ini_set('max_execution_time', 10000);
		ini_set('memory_limit', '-1');
		set_time_limit(0);
		ignore_user_abort(true);
		
		 $filename = "Zuku_export_files_backup_(".date('d-m-Y H').").zip";
		 $path = 'upload';
		 $path1 = 'application';
		 $this->zip->read_dir($path);
		 $this->zip->read_dir($path1);
		// $this->zip->read_dir($path);
		 $this->zip->archive(FCPATH.'/archivefiles/'.$filename);
		 
		  $this->zip->download($filename);
		  
	}
	 
}
?>