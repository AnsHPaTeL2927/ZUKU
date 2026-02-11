<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Email service: PI email template, download PDF, and send confirmation email.
 */
class Email_service
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
     * Get PI PDF HTML from email template (used by download and email).
     * @param int $pi_id Proforma Invoice ID
     * @return array|false ['html' => string, 'invoice_no' => string] or false
     */
    public function get_pi_pdf_html($pi_id)
    {
        try {
            $this->CI->load->model('Admin_pdf');
            $company = $this->CI->Admin_pdf->company_select();
            $data   = $this->CI->Admin_pdf->select_invoice_data($pi_id);
            $datap  = $this->CI->Admin_pdf->product_data($pi_id);
            if (!$data) {
                return false;
            }
            $view_data = array(
                'invoicedata'    => $data,
                'product_data'   => $datap,
                'company_detail' => $company,
                'mode'           => ''
            );
            $html = $this->CI->load->view('admin/pi_email_pdf_template', $view_data, true);
            $invoice_no = !empty($data->invoice_no) ? $data->invoice_no : 'PI-' . $pi_id;
            return array('html' => $html, 'invoice_no' => $invoice_no);
        } catch (Throwable $e) {
            log_message('error', 'Email_service get_pi_pdf_html: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate PI PDF and send as download (from Performa_invoice_pdf).
     * @param int $pi_id Proforma Invoice ID
     */
    public function download_pi_pdf($pi_id)
    {
        $res = $this->get_pi_pdf_html($pi_id);
        if (!$res || empty($res['html'])) {
            return;
        }
        $filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $res['invoice_no']) . '.pdf';
        $this->dompdf->loadHtml($res['html']);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $output = $this->dompdf->output();
        $this->CI->output->set_header('Content-Type: application/pdf');
        $this->CI->output->set_header('Content-Disposition: attachment; filename="' . $filename . '"');
        $this->CI->output->set_output($output);
    }

    /**
     * Generate PI PDF, save to uploads, and send confirmation email (call when Confirm PI action fires).
     * @param int $pi_id Proforma Invoice ID
     * @return bool
     */
    public function send_pi_confirmed_email($pi_id)
    {
        try {
            $res = $this->get_pi_pdf_html($pi_id);
            if (!$res || empty($res['html'])) {
                return false;
            }
            $this->CI->load->model('Admin_pdf');
            $pi_data = $this->CI->Admin_pdf->select_invoice_data($pi_id);
            if (!$pi_data) {
                return false;
            }
            $filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $res['invoice_no']) . '.pdf';
            $this->dompdf->loadHtml($res['html']);
            $this->dompdf->setPaper('A4', 'portrait');
            $this->dompdf->render();
            $output = $this->dompdf->output();
            $basePath = FCPATH . 'uploads/invoices/';
            if (!is_dir($basePath)) {
                mkdir($basePath, 0777, true);
            }
            $file_path = $basePath . $filename;
            file_put_contents($file_path, $output);
            $attachment_path = 'uploads/invoices/' . $filename;

            $this->CI->load->model('Admin_invoice');
            $customer_data = $this->CI->Admin_invoice->customerdetail($pi_data->consigne_id);
            $client_email = (!empty($customer_data) && !empty($customer_data->c_email)) ? $customer_data->c_email : '';
            if (empty($client_email) && $this->CI->config->item('email_test_override') && $this->CI->config->item('email_test_address')) {
                $client_email = $this->CI->config->item('email_test_address');
            }
            if (empty($client_email)) {
                log_message('warning', 'Email_service send_pi_confirmed_email: no recipient for PI ID ' . $pi_id);
                return false;
            }
            $invoice_no    = $res['invoice_no'];
            $subject       = 'Proforma Invoice Confirmed - ' . $invoice_no;
            $customer_name = (!empty($customer_data) && !empty($customer_data->c_name)) ? $customer_data->c_name : 'Client';
            $body = 'Dear ' . $customer_name . ',<br><br>';
            $body .= 'Your Proforma Invoice has been confirmed by the admin.<br><br>';
            $body .= '<strong>Invoice Details:</strong><br>';
            $body .= 'Invoice Number: ' . $invoice_no . '<br>';
            $body .= 'Invoice Date: ' . date('d-m-Y', strtotime($pi_data->performa_date)) . '<br><br>';
            $body .= 'Please find the attached PDF for details.<br><br>Thank you.<br><br>Best regards,<br>ZUKU App';

            $this->CI->load->library('Pdf_service');
            $sent = $this->CI->pdf_service->sendEmail($client_email, $subject, $body, $attachment_path);
            return $sent;
        } catch (Throwable $e) {
            log_message('error', 'Email_service send_pi_confirmed_email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send pallatization done email notification (call when Pallatization Done action fires).
     * @param int $production_mst_id Production Master ID
     * @return bool
     */
    public function send_pallatization_done_email($production_mst_id)
    {
        try {
            $this->CI->load->model('Admin_pdf');
            $production_data = $this->CI->Admin_pdf->producation_mst_data($production_mst_id);
            if (!$production_data) {
                log_message('warning', 'Email_service send_pallatization_done_email: production data not found for ID ' . $production_mst_id);
                return false;
            }

            // Get customer email from production data (already joined with customer_detail)
            $client_email = (!empty($production_data->c_email)) ? $production_data->c_email : '';
            if (empty($client_email) && $this->CI->config->item('email_test_override') && $this->CI->config->item('email_test_address')) {
                $client_email = $this->CI->config->item('email_test_address');
            }
            if (empty($client_email)) {
                log_message('warning', 'Email_service send_pallatization_done_email: no recipient for Production ID ' . $production_mst_id);
                return false;
            }

            $production_no = !empty($production_data->producation_no) ? $production_data->producation_no : 'PROD-' . $production_mst_id;
            $invoice_no = !empty($production_data->invoice_no) ? $production_data->invoice_no : '';
            $subject = 'Pallatization Completed - ' . $production_no;
            
            $customer_name = (!empty($production_data->c_name)) ? $production_data->c_name : 
                            (!empty($production_data->c_companyname) ? $production_data->c_companyname : 'Client');
            
            $body = 'Dear ' . $customer_name . ',<br><br>';
            $body .= 'This is to inform you that pallatization has been completed for your production order.<br><br>';
            $body .= '<strong>Production Details:</strong><br>';
            $body .= 'Production Number: ' . $production_no . '<br>';
            if (!empty($invoice_no)) {
                $body .= 'Proforma Invoice Number: ' . $invoice_no . '<br>';
            }
            if (!empty($production_data->producation_date)) {
                $body .= 'Production Date: ' . date('d-m-Y', strtotime($production_data->producation_date)) . '<br>';
            }
            $body .= '<br>Thank you.<br><br>Best regards,<br>ZUKU App';

            $this->CI->load->library('Pdf_service');
            // Send email without PDF attachment (null for attachment_path)
            $sent = $this->CI->pdf_service->sendEmail($client_email, $subject, $body, null);
            return $sent;
        } catch (Throwable $e) {
            log_message('error', 'Email_service send_pallatization_done_email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send inventory added email notification to admin (call when client adds to inventory/stock).
     * @param int $performa_invoice_id Proforma Invoice ID
     * @return bool
     */
    public function send_inventory_added_email($performa_invoice_id)
    {
        try {
            // Get admin email from company detail
            $this->CI->load->model('admin_company_detail');
            $company_detail = $this->CI->admin_company_detail->s_select();
            $admin_email = (!empty($company_detail) && !empty($company_detail[0]->s_email)) ? $company_detail[0]->s_email : '';
            
            if (empty($admin_email) && $this->CI->config->item('email_test_override') && $this->CI->config->item('email_test_address')) {
                $admin_email = $this->CI->config->item('email_test_address');
            }
            
            if (empty($admin_email)) {
                log_message('warning', 'Email_service send_inventory_added_email: no admin email found for PI ID ' . $performa_invoice_id);
                return false;
            }

            // Get PI data
            $this->CI->load->model('Admin_pdf');
            $pi_data = $this->CI->Admin_pdf->select_invoice_data($performa_invoice_id);
            if (!$pi_data) {
                log_message('warning', 'Email_service send_inventory_added_email: PI data not found for ID ' . $performa_invoice_id);
                return false;
            }

            $invoice_no = !empty($pi_data->invoice_no) ? $pi_data->invoice_no : 'PI-' . $performa_invoice_id;
            $subject = 'Inventory Added - ' . $invoice_no;
            
            $body = 'Dear Admin,<br><br>';
            $body .= 'CON.REACHED<br><br>';
            $body .= 'A client has added items to inventory/stock.<br><br>';
            $body .= '<strong>Invoice Details:</strong><br>';
            $body .= 'Invoice Number: ' . $invoice_no . '<br>';
            if (!empty($pi_data->performa_date)) {
                $body .= 'Invoice Date: ' . date('d-m-Y', strtotime($pi_data->performa_date)) . '<br>';
            }
            $body .= '<br>Thank you.<br><br>Best regards,<br>ZUKU App';

            $this->CI->load->library('Pdf_service');
            // Send email without PDF attachment (null for attachment_path)
            $sent = $this->CI->pdf_service->sendEmail($admin_email, $subject, $body, null);
            return $sent;
        } catch (Throwable $e) {
            log_message('error', 'Email_service send_inventory_added_email: ' . $e->getMessage());
            return false;
        }
    }
}
