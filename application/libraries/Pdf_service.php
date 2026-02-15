<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf_service
{
    protected $CI;
    protected $dompdf;

    public function __construct()
    {
        $this->CI =& get_instance();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $this->dompdf = new Dompdf($options);
    }

    /**
     * Generate PDF from HTML and store it
     *
     * @param string $fileName
     * @param string $folderName
     * @param string $htmlContent
     * @return string|false
     */
    public function generateAndStore($fileName, $folderName, $htmlContent)
    {
        try {

            // Ensure .pdf extension
            if (strlen($fileName) < 4 || substr_compare($fileName, '.pdf', -4, 4) !== 0) {
				$fileName .= '.pdf';
			}

            $basePath = FCPATH . 'uploads/' . $folderName . '/';

            // Create folder if not exists
            if (!is_dir($basePath)) {
                mkdir($basePath, 0777, true);
            }

            // Load HTML
            $this->dompdf->loadHtml($htmlContent);

            // Paper setup
            $this->dompdf->setPaper('A4', 'portrait');

            // Render PDF
            $this->dompdf->render();

            $output = $this->dompdf->output();

            $filePath = $basePath . $fileName;

            file_put_contents($filePath, $output);

            // Return relative path
            return 'uploads/' . $folderName . '/' . $fileName;

        } catch (Exception $e) {
            log_message('error', 'PDF Error: ' . $e->getMessage());
            return false;
        }
    }

	public function sendEmail($to, $subject, $body, $attachment_path = null)
	{
		$this->CI->load->library('email');
		$this->CI->email->clear(TRUE);
		$this->CI->email->from('patelansh2918@gmail.com', 'ZUKU App');
		// For testing: send all emails to test address when config is enabled
		if (!empty($this->CI->config->item('email_test_override')) && $this->CI->config->item('email_test_address')) {
			$to = $this->CI->config->item('email_test_address');
		}
		$this->CI->email->to($to);
		$this->CI->email->subject($subject);
		$this->CI->email->message($body);
		
		// Attach PDF if path is provided (same as PO: path from generate_*_pdf is relative e.g. ./adminast/assets/upload/file.pdf)
		if (!empty($attachment_path)) {
			if (strpos($attachment_path, FCPATH) === 0) {
				$full_path = $attachment_path;
			} else {
				$rel = ltrim(str_replace('\\', '/', $attachment_path), './');
				$full_path = rtrim(FCPATH, '/\\') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
			}
			if (file_exists($full_path)) {
				$this->CI->email->attach($full_path);
			}
		}
		
		return $this->CI->email->send();
	}
}
