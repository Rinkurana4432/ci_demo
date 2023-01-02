<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//getLocationArea
class Dailyreport_inventory extends ERP_Controller {
    function __construct() {
        parent::__construct();
        $dynamicdb = $this->load->database();
        $this->load->helper('daily_report_inventory_helper');
        $this->load->model('dailyreport_inventory_model');
    }
    public function switch_db_dinamico($name_db){
		$config_app['hostname'] = 'lastingerp-instance-1.cihrq4rjnxlt.ap-south-1.rds.amazonaws.com';
		$config_app['username'] = 'lastingerp';
		$config_app['password'] = '!lastingerpamitaerp!';
		$config_app['database'] = $name_db;
		$config_app['dbdriver'] = 'mysqli';
		$config_app['dbprefix'] = '';
		$config_app['pconnect'] = FALSE;
		$config_app['db_debug'] = (ENVIRONMENT !== 'production'); 
		$config_app['save_queries'] = true;
    	$config_app['db_debug'] = FALSE;
    	$config_app['cache_on'] = FALSE;
    	$config_app['cachedir'] = '';
    	$config_app['char_set'] = 'utf8mb4';
    	$config_app['dbcollat'] = 'utf8mb4_unicode_ci';
    	$config_app['swap_pre'] = '';
    	$config_app['encrypt'] = FALSE;
    	$config_app['compress'] = FALSE;
    	$config_app['stricton'] = FALSE;
    	$config_app['failover'] = array();
    	$config_app['save_queries'] = TRUE;
		return $config_app;
	}	
    public function index() {
        $this->load->library('Pdf');
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Materials Daily Report', base_url() . 'Materials Daily Report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $config_app = $this->switch_db_dinamico('lastingerp');
        #$workers = $this->dailyreport_inventory_model->get_worker();
        #$where  = array( 'material_type_id' =>  '1');
        $where = "email_status = 'verified' and role = 1 and status = 1 and business_status = 1";
        $raw_data = $this->dailyreport_inventory_model->get_data($config_app, 'user', $where);
        #pre($raw_data);
        $f = 0;
        $i = 0;
        $i11 = 0;
        $raw_data1 = array();
        $groupedArray = array();
        foreach ($raw_data as $wsa) {
            $where22 = "status = 1";
            $raw_data22 = $this->dailyreport_inventory_model->get_data($config_app, 'material_type', $where22);
            #$where12 = "created_by_cid = '" . $wsa['c_id'] . "'ORDER BY id DESC LIMIT 1";
            #$emailsetting[] = $this->dailyreport_inventory_model->get_data($config_app, 'daily_report_setting', $where12);
            foreach ($raw_data22 as $rfg) {
                $rty =  date("Y-m-d H:i:s", time());
                $where1 = "material_type_id = '" . $rfg['id'] . "' AND  created_by_cid = '" . $wsa['c_id'] . "' AND 'created_date' >= '".$rty."' - INTERVAL 0 DAY AND (SELECT MAX( id ) FROM inventory_flow) ORDER BY id DESC LIMIT 1";
                $raw_data1[] = $this->dailyreport_inventory_model->get_data($config_app, 'inventory_flow', $where1);
                foreach ($raw_data1 as $key) {
                    $yui = $key;
                }
                if (!empty($yui)) {
                    $mydt[$i] = $yui[0];
                }
                $i++;
            }
        }
      #  pre($raw_data1);die;
        $groupedArray = array();
        $y = 0;
        $rfd = array();
        foreach ($mydt as $valuesAry) {
            $matname = '';
            $created_by_cid = $valuesAry['created_by_cid'];
            $groupedArray[$created_by_cid][] = $valuesAry;
        }
        $ir = 0;
        $r = 0;
        $edsc = '';
        $tgh = '';
        $q = 0;
        $matname = array();
           $html = '';
           $rvc = array_keys($groupedArray);
        foreach ($groupedArray as $tgh) {
             $where22 = "c_id = '" . $rvc[$r] . "' AND role = 1 and business_status = 1";
            $raw_data = $this->dailyreport_inventory_model->get_data($config_app, 'user', $where22);
                $AreaArray = array();
                $iw = 0;
                if (!empty($raw_data)) {
                    foreach ($raw_data as $areaName) {
                        $AreaArray[$iw]['emailid'] = $areaName['email'];
                        $iw++;
                    }
                }
        
            ini_set('memory_limit', '20M');
            $this->load->library('pdf');
            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle("Daily Inventory Stock Report");
            $pdf->SetHeaderData('Daily Inventory Stock Report', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont('helvetica');
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetAutoPageBreak(TRUE, 2);
            // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetTopMargin(1);
            $pdf->SetFont('helvetica', '', 9);
            $this->load->library('email');
            $dataPdf['dataPdf'] = $tgh;
            //$dataPdf = $this->account_model->get_data_byId('invoice','id',$invoice_details->id);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->AddPage();
            $html = $this->_render_template('template/dail_report_pdf', $dataPdf, true);
            ob_start();
            $pdf->WriteHTML($html);
            // $pdf->writeHTML($html, true, 0, true, 0);
            $pdf->lastPage();
            // $pdf->WriteHTML(0, $html, '', 0, 'L', true, 0, false, false, 0);
            $pdfFilePath = FCPATH . "assets/uploadscron/" . rand() . ".pdf";
            ob_end_clean();
          # ob_clean();
            $pdf->Output($pdfFilePath, "F");
            $this->load->library('phpmailer_lib');
            $mail = $this->phpmailer_lib->load();
            //Server settings
            $mail->SMTPDebug = 1;
            $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)); // Enable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = 'email-smtp.ap-south-1.amazonaws.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'AKIAZB4WVENVZ773ONVF'; // SMTP username
            $mail->Password = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            //Recipients
           // $mail->setFrom('dev@lastingerp.com', 'LastingERP');
           // $mail->addAddress($AreaArray[0]['emailid']); // Add a recipient
            // Content
            $mail->isHTML(true);
            // Email body content
            #$mailContent = $messageContent;
            $mail->Body = 'Please find the attachment given below.';
            $mail->Subject = 'Inventory Stock Report ' . date('d-m-Y');
            $mail->addAttachment($pdfFilePath);
            //$mail->send();
             $r++;
        }
        die;
    }
}
/* End of file Cronjob */
