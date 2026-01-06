<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/dompdf/autoload.php'); // Adjust path if necessary

use Dompdf\Dompdf; // Import the Dompdf class

class Pdf
{
    public function createPDF($html, $filename = '', $download = true)
    {
        $dompdf = new Dompdf();
        
         // Enable remote images and HTML5 parsing
        $dompdf->set_option('isRemoteEnabled', true); 
        
        $dompdf->set_option('isHtml5ParserEnabled', true); 
        
        $dompdf->set_option('dpi', 150); // Increase DPI for better image quality
        
        $dompdf->loadHtml($html);
        
        $dompdf->setPaper('A4', 'portrait');
        
        $dompdf->render();
        
        if ($download) {
            $dompdf->stream($filename, array("Attachment" => 1)); // Force download
        } else {
            return $dompdf->output(); // Return the file as a string for other usages
        }
    }
}
