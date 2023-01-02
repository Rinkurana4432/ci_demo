<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//getLocationArea
class Dailyreport_inventory extends ERP_Controller {
    function __construct() {
        parent::__construct();
        $dynamicdb = $this->load->database();
        // $this->load->helper('daily_report_inventory_helper');
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
        //ob_start();
        //print_r("hi");die;
        $this->load->library('Pdf');
        $this->breadcrumb->add('Inventory', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Dashboard', base_url() . 'inventory/dashboard');
        $this->breadcrumb->add('Materials Daily Report', base_url() . 'Materials Daily Report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $config_app = $this->switch_db_dinamico('lastingerp');
        #$workers = $this->dailyreport_inventory_model->get_worker();
        #$where  = array( 'material_type_id' =>  '1');
        $where = "frequency = 1 AND toEmail != ''";
        // $where = "email_status = 'verified' and role = 1 and status = 1 and business_status = 1";
        // $raw_data = $this->dailyreport_inventory_model->get_data($config_app, 'user', $where);
        $raw_data = $this->dailyreport_inventory_model->get_data($config_app, 'daily_report_setting', $where);
        //echo"<pre>";print_r($raw_data);die;
       //$i = 1;
           

                         
        foreach($raw_data as $raw_dataItems){
             ob_start();
                    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
                    $pdf->SetCreator(PDF_CREATOR);            
             $pdf->AddPage(); 
            //echo"<pre>";print_r($raw_dataItems);
            $report_name = $raw_dataItems['report_name'];
            $emailsTo = array();
            //$emailsTo = array('jagdish@lastingerp.com');
            $emailuserIds = json_decode($raw_dataItems['toEmail']);
            if($emailuserIds){
            //print_r($emailuserIds);echo "<br>";
            /*}else{
                echo "No id";
            }*/
            //continue;            
            foreach($emailuserIds as $emailuserIdsItems){
                $getUserEmail = $this->dailyreport_inventory_model->get_mat_spec_column($config_app, 'user', 'id='.$emailuserIdsItems, 'email');
                
                if($getUserEmail){
                    $emailsTo[] = $getUserEmail[0]['email'];
                }else{
                    $emailsTo = array();
                }
            }
            if(count($emailsTo)  == 0){continue;}
            //echo count($emailsTo);
            //print_r($emailsTo);echo "<br>";
            //continue;
            // $raw_dataItems['report_name'];
            //pre($raw_dataItems);
            // $where = 'material_type_id =' .$raw_dataItems['material_type_id'];
            $getmatID = array();
            //SELECT *  FROM `material` WHERE `material_type_id` = 30 AND `status` = 1 AND save_status = 1 and created_by_cid = 2 and opening_balance != 0
            $where = 'material_type_id =' .$raw_dataItems['material_type_id']." AND created_by_cid=".$raw_dataItems['created_by_cid']." AND `status` = 1 AND save_status = 1 AND closing_balance != 0 AND non_inventry_material = 0";
            $getmatID = $this->dailyreport_inventory_model->get_mat_spec_column($config_app, 'material', $where, 'id');
            //echo $where;

            //continue;
           // echo $this->db->last_query();

           //$user_email_data =array();
           /* foreach ($toEmail as $user_email) {
                 $where = array('user.c_id' => $this->companyId,'id'=>$user_email);
                     $useremail = $this->inventory_model->get_data_byId('user', 'id', $user_email);
                     $user_email_data[] =  $useremail->email;
           }  */
           $mat_trans = array();
           $user_email_data =  $emailsTo;          
           foreach($getmatID as $getmatdata){
               //echo $getmatdata['id']." AND Created by ".$raw_dataItems['created_by_cid']."<br>";
                // $where1 = array( 'material_id'=>$getmatdata['id']);
                //$where1 = "inventory_flow.material_id='".$getmatdata['id']."' AND created_by_cid=".$raw_dataItems['created_by_cid']." ORDER BY id DESC LIMIT 1";
                //$where1 = "inventory_flow.material_id='".$getmatdata['id']."' AND inventory_flow.created_by_cid= 1 ORDER BY inventory_flow.id DESC LIMIT 1";
                $where1 = 'material_type_id =' .$raw_dataItems['material_type_id'].' AND material_id='.$getmatdata['id'].' AND created_by_cid = '.$raw_dataItems['created_by_cid'];
                $orderBy = 'inventory_flow.id DESC';
                $limit = 1;
                //echo $where1;
                $mat_trans[] = $this->dailyreport_inventory_model->getDatabycheckid($config_app, 'inventory_flow', $where1, $orderBy, $limit);
                //echo $this->db->last_query();
            }

           
            //echo  'id='.$raw_dataItems['created_by_cid'];
            $company_data =  $this->dailyreport_inventory_model->get_mat_spec_column($config_app, 'company_detail', 'id='.$raw_dataItems['created_by_cid'],'name,branch');
            
            $mat_trans = array_filter($mat_trans);
            //if($raw_dataItems['created_by_cid'] == 1){
                //echo"<pre>";print_r($mat_trans);echo "<br>";
            //}    
            //continue;            
            $getmatName = $this->dailyreport_inventory_model->get_mat_spec_column($config_app, 'material_type', 'id =' .$raw_dataItems['material_type_id'], 'name');
            //print_r($getmatName);die;
            $content='';
            $content.='<table border="1" style="border-collapse: collapse;" cellpadding="2">
                     <thead>
                          <tr>
                            <td colspan="3"><strong></strong><br><br><strong> Company Name :</strong> '.$company_data[0]['name'].'<br> <strong>Branch :</strong> '.$company_data[0]['branch'].'<br> </td>
                            <td colspan="3"><strong></strong><br><br><strong> Date :</strong> '.date("j F , Y").'<br> <strong>Material Type :</strong> '.$getmatName[0]['name'].'<br></td>
                          </tr>
                      <tr><td colspan="6"><b style="font-size:20px; text-align:center;">Material Description</b></td></tr>
                     <tr>
                          <th  rowspan="2" style="text-align:center;"><b>Material Name</b></th>
                          <th  rowspan="2" style="text-align:center;"><b>UOM</b></th>
                          <th  rowspan="2" style="text-align:center;"><b>Opening Stock</b></th>
                          <th  rowspan="2" style="text-align:center;"><b>Inwards</b></th>
                          <th  rowspan="2" style="text-align:center;"><b>Outwards</b></th>
                          <th  rowspan="2" style="text-align:center;"><b>Closing Stock</b></th>

                     </tr>
                 </thead>
                  <tbody>';
                  if(!empty($mat_trans)){
                   //pre($mat_trans);
                    foreach($mat_trans as $mattrans){
                        $moved = "";
                       //$statusChecked = "";
                       $action = '';
                       if($mattrans['through'] == "Moved"){
                           $moved = "(Material Moved from Current to new Location)";
                           }
                        //    echo 'material_id='.$mattrans['material_id'];
                       $ww =  $this->dailyreport_inventory_model->get_mat_spec_column($config_app, 'material', 'id='.$mattrans['material_id'],'material_name');
                       
                       $matname = !empty($ww)?$ww[0]['material_name']:'';
                       
                       #pre($mattrans['material_id']);
                       $ww1 =  $this->dailyreport_inventory_model->get_mat_spec_column($config_app, 'uom', 'id='.$mattrans['uom'],'ugc_code');
                       $uom = !empty($ww1)?$ww1[0]['ugc_code']:'-';
                       //print_r($ww1);die;

                       $matin = !empty($mattrans['material_in'])?$mattrans['material_in']:'-';
                       $matout = !empty($mattrans['material_out'])?$mattrans['material_out']:'-';

                       $ww2 =  $this->dailyreport_inventory_model->get_mat_spec_column($config_app, 'user_detail','u_id='.$mattrans['created_by'],'name');
                       $uname = !empty($ww2)?$ww2[0]['name']:'';

                       $dt =  date("d-M-Y", strtotime($mattrans['created_date']));
                       #$dt =  date("j F , Y", strtotime($mattrans['created_date']));
                       
                        // pre($mattrans);
                        $content.="<br><tr>
                                 <td style='text-align:right;' data-label='Material Name:'>".$matname."</td>
                                 <td style='text-align:right;' data-label='Material UOM:'>".$uom."</td>
                                 <td style='text-align:right;' data-label='Opening Stock:'>".$mattrans['opening_blnc']."</td>
                                 <td style='text-align:right;' data-label='Material in:'>".$matin."</td>
                                 <td style='text-align:right;' data-label='Material out:'>".$matout."</td>
                                 <td style='text-align:right;' data-label='Closing Stock:'>".$mattrans['closing_blnc']."</td>

                           </tr>";
                    }
                    //pre($content);die;
                    // die();
                 }
                  $content.='</tbody>
                  </table>';


                    //print_r($content);

                    //continue;
                    $pdf->WriteHTML($content);
                    //$pdfFilePath = FCPATH . "assets/modules/inventory/daily_report/daily_report_".$raw_dataItems['created_by_cid'].".pdf";
                    $pdfFilePath = FCPATH . "assets/modules/inventory/daily_report/daily_report.pdf";
                    //if (ob_get_contents()) ob_end_clean();
                    ob_end_clean();
                    $pdf->Output($pdfFilePath, "F"); 
                    
                    //unset($content);
                    // $pdf->Output($pdfFilePath, "I"); 
                    $this->sendEmail($pdfFilePath,$user_email_data,$report_name);
                    unlink($pdfFilePath);
                     
                    //$i++;
                    //echo $i;          
            //die; 
            }
        }
        echo "Complete";
    }

    function sendEmail($pdfFilePath,$emails,$report_name){
		 
		

        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->SMTPDebug = 0;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
        $mail->isSMTP();
        $mail->Host       = 'email-smtp.ap-south-1.amazonaws.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'AKIAZB4WVENVZ773ONVF';
        $mail->Password   = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->setFrom('dev@lastingerp.com','lerp');

        $emailIds = '';
        foreach($emails as $email)
        {
           //$emailIds .= $email.",";
           $mail->addAddress($email, '');
            // $mail->addAddress('dharamveersingh@lastingerp.com', '');
        }
        //print_r(trim($emailIds,','));die;
        //$mail->addAddress('princy@lastingerp.com','');
        // $mail->addAddress($emails,'');
        // while (list ($key, $val) = each($email)) {
        //     pre($val); die;
        //       $email->addAddress($val);
        //   }
        $mail->addAddress(trim($emailIds,','), '');
        $mail->isHTML(true);
        $mail->Body = $report_name;
        $mail->Subject = $report_name;
        $mail->addAttachment($pdfFilePath,'Inventory Reports','base64','application/pdf');
        $status = $mail->send();
        if($status){
            //redirect(base_url() . 'inventory/inventory_setting', 'refresh');
            //$this->session->set_flashdata('message', 'Report Sand Successfully');


        }else{
            echo 'Mailer error: ' . $mail->ErrorInfo;
        }
    }    
}
/* End of file Cronjob */
