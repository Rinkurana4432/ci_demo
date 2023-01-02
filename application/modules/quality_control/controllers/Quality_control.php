<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Quality_control extends ERP_Controller {
    public function __construct()  {
        parent::__construct();
        is_login();		
        $this->load->library(array( 'form_validation'));
        $this->load->model('Quality_control_model');
		$this->load->helper('quality_control/quality_control');		
		$this->settings['css'][] = 'assets/plugins/morris.js/morris.css';
		$this->settings['css'][] = 'assets/plugins/switchery/dist/switchery.min.css';
		$this->settings['css'][] = 'assets/plugins/iCheck/skins/flat/green.css';
		$this->settings['css'][] = 'assets/plugins/bootstrap-taginput/tagsinput/bootstrap-tagsinput.css';
		$this->settings['css'][] = 'assets/plugins/jquery-ui/jquery-ui.css';
		$this->settings['css'][] = 'assets/plugins/bootstrap-tagmanager/tagmanager.css';
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->settings['css'][] = 'assets/plugins/editable_datatable/DataTables-1.10.18/css/jquery.dataTables.min.css';
		$this->settings['css'][] = 'assets/plugins/editable_datatable/Buttons-1.5.4/css/buttons.dataTables.css';
		$this->settings['css'][] = 'assets/plugins/editable_datatable/Select-1.2.6/css/select.dataTables.css';
		$this->scripts['js'][]   = 'assets/plugins/editable_datatable/Buttons-1.5.4/js/dataTables.buttons.min.js';
		$this->scripts['js'][]   = 'assets/plugins/editable_datatable/Select-1.2.6/js/dataTables.select.js';
		$this->scripts['js'][]   = 'assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';
		$this->scripts['js'][]   = 'assets/plugins/bootstrap-taginput/tagsinput/bootstrap-tagsinput.js';
		$this->scripts['js'][]   = 'assets/plugins/bootstrap-typehead/bootstrap3-typeahead.js';
		$this->scripts['js'][]   = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->scripts['js'][]   = 'assets/plugins/Chart.js/dist/Chart.min.js';
		$this->scripts['js'][]   = 'assets/plugins/raphael/raphael.min.js';
		$this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';
		$this->scripts['js'][] = 'assets/plugins/echarts/dist/echarts.min.js';
		$this->scripts['js'][] = 'assets/plugins/switchery/dist/switchery.min.js';
		$this->scripts['js'][] = 'assets/plugins/iCheck/icheck.min.js';
		$this->scripts['js'][] = 'assets/plugins/jquery-ui/jquery-ui.js';
		$this->scripts['js'][] = 'assets/plugins/autosize/dist/autosize.js';
		$this->scripts['js'][] = 'assets/modules/quality_control/js/script.js';
		$this->settings['css'][] = 'assets/modules/quality_control/css/style.css';
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
    }
	
	/****************************** Quality Control ********************************************/
	
	public function index(){
	    $this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
	    $this->breadcrumb->add('Quality Control',base_url().'quality_control');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Quality Control';
	    $data['report']= $this->Quality_control_model->get_report_data();
	    $this->_render_template('quality_report/index',$data);
    }
	//Add Report
	public function add_new_report(){
		//$data['get_workorder']= $this->Quality_control_model->get_data('work_order','');
		$data['get_jobcard']= $this->Quality_control_model->get_data1('job_card',array('created_by_cid'=>$this->companyGroupId),'');
		$data['material']= $this->Quality_control_model->get_data1('material',array('created_by_cid'=>$this->companyGroupId),'');
		$data['ins']=$this->Quality_control_model->get_data1('instrument',array('created_by_cid'=>$this->companyGroupId),'');
		$data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1);
		$this->load->view('quality_report/add_report',$data);
	}                             	
	//Get Material Name	
	public function get_material_name(){
	   $id=$_POST['material']; 
	   $data['material_type']= $this->Quality_control_model->get_material_name($id);
    }
		
		//Get Product Name	
	public function get_product_name(){
		   $id=$_POST['material']; 
		   echo $this->Quality_control_model->get_row_value('material','id',$id);
	}
	//Get Job process

	public function get_job_process_type(){
		   $job=$_POST['jobcard']; 
		   $jobcard = $this->Quality_control_model->get_row_value1('job_card','job_card_no',$job);
		   if( isset($jobcard->machine_details) ){
				$process_data = json_decode($jobcard->machine_details,TRUE);
		        $machinDetails = [];
		   		$html='<option value="">Select process</option>';
		   		foreach($process_data as $processKey =>  $process_namee){
				    $proc_nam = getNameById('add_process', $process_namee['processess'],'id');
					if( $proc_nam ){
			      		$html.= '<option jobCardNo="'.$job.'" value="'.$process_namee['processess'].'">'.$proc_nam->process_name.'</option>';
			      	}
			    }
			   	echo json_encode(['options' => $html ]);
		}	
	}

	public function getMachineByProcess(){
	   $job       = $_POST['jobCard'];
	   $processId = $_POST['processId'];
	   $jobcard = $this->Quality_control_model->get_row_value1('job_card','job_card_no',$job);
	   if( $_POST['incId'] ){
	   		if( $incData = $this->Quality_control_model->get_table_field('inspection_report_master','id',$_POST['incId']) ){
	   			$incData = $incData[0];
			}
		}
	   if( isset($jobcard->machine_details) ){
			$process_data = json_decode($jobcard->machine_details,TRUE);
	        $machinDetails = [];
	   		$html='<option value="">Select Machine</option>';
	   		foreach($process_data as $processKey =>  $process_namee){
	   			if( $processId == $process_namee['processess'] ){
				    if( $process_namee['machine_details'] ){
			   				$machineData = json_decode($process_namee['machine_details']);
			   				foreach ($machineData as $machinKey => $machinValue) {
			   					$disabled = $selected = "";
			   					$allMacData = $this->Quality_control_model->get_row_value1('add_machine','id',$machinValue->machine_id);
			   					if( $_POST['incId'] ){
			   						if( isset($incData->machine_id) ){
			   							if( $incData->machine_id == $machinValue->machine_id ){
			   								$html = "<option jobCard='{$_POST['jobCard']}' processId='{$process_namee['processess']}' value='{$machinValue->machine_id}' selected >{$allMacData->machine_name}</option>";
			   							}
			   						}
			   					}else{
			   						$html .= "<option jobCard='{$_POST['jobCard']}' processId='{$process_namee['processess']}' value='{$machinValue->machine_id}' {$selected} {$disabled}>{$allMacData->machine_name}</option>";
			   					}
			   				}
			    	}
			   		echo json_encode(['options' => $html ]);
	   			}
			}
		}
    }
    
    public function qualityInspationReportPdf(){
        $this->load->library('Pdf');
        $id        = $_GET['id'];
        $jobCard   = $_GET['jobCard'];
        $processId = $_GET['processId'];
        $machineId = $_GET['machineId'];
        $machineData = $this->get_machine_by_process_type($id,$jobCard,$processId,$machineId);
        

	    $data['edit']=$this->Quality_control_model->get_table_field('inspection_report_master','id',$id);
	    if($data['edit']){
	    	$data['edit'] = $data['edit'][0];
	    }

	    $machineData['trans']=$this->Quality_control_model->get_table_field('inspection_report_trans','report_id',$id);
	    $machineData['get_workorder']= $this->Quality_control_model->get_data('work_order','');
	    $machineData['get_jobcard']= $this->Quality_control_model->get_data('job_card','');
	    $machineData['process_type']= $this->Quality_control_model->get_data('add_process','');
		$machineData['uom']=$this->Quality_control_model->get_table_field('uom','created_by_cid',$this->companyGroupId);
		$machineData['ins']=$this->Quality_control_model->get_data1('instrument',array('created_by_cid'=>$this->companyGroupId),'');
        

        $this->load->view('inspection/view_pdf',$machineData);
    }

	public function get_machine_by_process_type($id="",$jobCard="",$processId="",$machineId=""){

	       $returnType = false;
	       if( $id!="" ){
	           $_POST['incId'] = $id;
	           $_POST['view']  = 'view';
	            $returnType = true;
	       }
	       if( $jobCard!="" ){
	           $_POST['jobCard'] = $jobCard;
	       }
	       if( $processId!="" ){
	           $_POST['processId'] = $processId;
	       }
	       if( $machineId!="" ){
	           $_POST['machineId'] = $machineId;
	       }
	       $line=$_POST['line'];
	    
		   $data = [];
		   $incTrnsData['trans'] = $incData['edit'] = "";
		   $job       = $_POST['jobCard']??0; 
		   $processId = $_POST['processId']??0;
		   $machineId = $_POST['machineId']??0;
		   if( $_POST['incId'] ){
		   		if( $incData = $this->Quality_control_model->get_table_field('inspection_report_master','id',$_POST['incId']) ){
		   			$incData['edit'] = $incData[0];
		   		}
		   		if( $incTrnsData = $this->Quality_control_model->get_table_field('inspection_report_trans','report_id',$_POST['incId']) ){
					$incTrnsData['trans'] = $incTrnsData[0];
		   		}
		   }
		   $jobcard = $this->Quality_control_model->get_row_value1('job_card','job_card_no',$job);
		   if( isset($jobcard->machine_details) ){
				$process_data = json_decode($jobcard->machine_details,TRUE);
		        $machinDetails = [];
		   		foreach($process_data as $processKey =>  $process_namee){
			   		if( $process_namee['processess'] == $processId ){
					    $machinDetails[$processKey]['dos'] = $process_namee['dos'];
					    $machinDetails[$processKey]['donts'] = $process_namee['donts'];
				        $machinDetails[$processKey]['description'] = $process_namee['description']??'';
			    		if( @$process_namee['machine_details'] ){
			   				$machineData = json_decode($process_namee['machine_details']);
			   				foreach ($machineData as $machinKey => $machinValue) {
			   					if( $machinValue->machine_id == $machineId ){
					   				$allMacData = $this->Quality_control_model->get_row_value1('add_machine','id',$machinValue->machine_id);
					   				$machinDetails[$processKey]['machineDetails']['production_shift'] = $machinValue->production_shift;
					   				$machinDetails[$processKey]['machineDetails']['workers'] = $machinValue->workers;
					   				$machinDetails[$processKey]['machineDetails']['machineBio'][$machinKey]['machine_name'] = $allMacData->machine_name;
					   				$machinDetails[$processKey]['machineDetails']['machineBio'][$machinKey]['machine_code'] = $allMacData->machine_code;
					   				$macPer     = json_decode($allMacData->machine_parameter);
					   				$macProcess = json_decode($allMacData->process);
					   				if( !empty($macPer) ){
					   					foreach ($macPer as $macPerkey => $macPervalue) {
						   					$machinDetails[$processKey]['machineDetails']['machineBio'][$machinKey]['machine_parameter'][$macPerkey]['machine_parameter'] = $macPervalue->machine_parameter;
						   					$machinDetails[$processKey]['machineDetails']['machineBio'][$machinKey]['machine_parameter'][$macPerkey]['uom']  = getNameById('uom',$macPervalue->uom,'id')->uom_quantity??'';
					   					}
					   				}
				   					foreach ($machinValue->parameter_detials as $paraDetKey => $paraDetValue) {
				   						$machinDetails[$processKey]['machineDetails']['machineBio'][$machinKey]['machine_parameter'][$paraDetKey]['uom_value'] = $paraDetValue->uom_value;
				   					}
			   					}
			   			    }
			   		    }
				   		$inputProcess = json_decode(@$process_namee['input_process']);
				   		if( $inputProcess ){
				   			foreach ($inputProcess as $inputProcessKey => $inputProcessValue) {
				   				$machinDetails[$processKey]['input_process'][$inputProcessKey]['material_type'] = getNameById('material_type',$inputProcessValue->material_type_input_id,'id')->name??'';
				   				$machinDetails[$processKey]['input_process'][$inputProcessKey]['material_name'] = getNameById('material',$inputProcessValue->material_input_name,'id')->material_name??'';
				   				$machinDetails[$processKey]['input_process'][$inputProcessKey]['quantity_input'] = $inputProcessValue->quantity_input;
				   				$machinDetails[$processKey]['input_process'][$inputProcessKey]['uom']  = $inputProcessValue->uom_value_input1??'';
				   				$machinDetails[$processKey]['input_process'][$inputProcessKey]['materialNameId']  = $inputProcessValue->material_input_name;
				   			}
				   		}
				    }
			    }
			    $details['dataProcess'] = $machinDetails;
			    $details['edit'] = $incData['edit'];
			    $details['view'] = $_POST['view']??'';
			    $machineReportHtml = $this->load->view('inspection/machineData',$details,TRUE);
				$data = ['machineData' => $machineReportHtml,'machineParemeter' => $this->machineParametersTable($line,$incTrnsData,$details['view'])  ];
		}
		
		if( $returnType ){
		    return $data;    
		}else{
		    echo json_encode($data);
		}
		
			
	}

	function machineParametersTable($line="",$trans = "",$view="" ){
   
		$data = [];
		$data['uom']=$this->Quality_control_model->get_table_field('uom','created_by_cid',$this->companyGroupId);
		$data['ins']=$this->Quality_control_model->get_data1('instrument',array('created_by_cid'=>$this->companyGroupId),'');
		if( $trans ){
			unset($trans['trans']);
			$data['incTrans'] = $trans;	
		}
		if( $view ){
		    $data['view'] = 'view';	
		}
		$data['line']=$line;
		return $this->load->view('inspection/parameters',$data, TRUE);
	}

	// Get machine Data by jobcard no.
		
	public function	get_job_process_type_report(){
		   $job = $_POST['jobcard']; 
		   $data['process_type']= $this->Quality_control_model->get_process_type($id);
	}
	//edit Report	
	public function edit_new_report(){
		$id=$_POST['id'];
		if($id != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}
		$data['edit']= $this->Quality_control_model->get_table_field('quality_control','id',$id);
		$data['edit_trans']= $this->Quality_control_model->get_table_field_array('quality_control_trans','report_id',$id);
	 	$data['get_jobcard']= $this->Quality_control_model->get_data1('job_card',array('created_by_cid'=>$this->companyGroupId),'');
		$data['process']= $this->Quality_control_model->get_data('process_type','');
		$data['material_type']= $this->Quality_control_model->get_data('material_type','');
		$data['material']= $this->Quality_control_model->get_data('material','');
		$data['ins']=$this->Quality_control_model->get_data('instrument','');
		$data['uom']=$this->Quality_control_model->get_table_field('uom','created_by_cid',$this->companyGroupId);
		$this->load->view('quality_report/edit',$data);
	}
	//view Report                                   	
	public function view(){
		$id=$_POST['id'];
		$data['edit']= $this->Quality_control_model->get_table_field('quality_control','id',$id);
		$data['edit_trans']= $this->Quality_control_model->get_table_field_array('quality_control_trans','report_id',$id);
		$data['get_jobcard']= $this->Quality_control_model->get_data('job_card','');
		$data['process']= $this->Quality_control_model->get_data('process_type','');
		$data['material_type']= $this->Quality_control_model->get_data('material_type','');
		$data['material']= $this->Quality_control_model->get_data('material','');
		$data['uom']=$this->Quality_control_model->get_table_field('uom','created_by_cid',$this->companyGroupId);
		$this->load->view('quality_report/view_report',$data);
	}
										
	//delete Report                                   	
   	public function delete(){
		$id=$this->uri->segment(3);
		$this->Quality_control_model->delete_data('quality_control','id',$id);
		$this->session->set_flashdata('message', 'Report Deleted Successfully');
		redirect(base_url().'quality_control', 'refresh');
	}
	
	public function delete_ncr(){
		$id=$this->uri->segment(4);
		$this->Quality_control_model->delete_data('register_complaint','id',$id);
		$this->session->set_flashdata('message', 'Complaint Deleted Successfully');
		redirect(base_url().'quality_control/ncr', 'refresh');
	}
	//Save Report
	public function savereport(){
		$data=$this->input->post();
        switch ($this->input->post('report_chk')) {
        	case 'manufacturing':
        		$selectedBy = ['at' => $this->input->post('ins_val1'),'report_for' => $this->input->post('ins_val2') ];
        	break;
        	case 'grn':
        		$selectedBy = ['uom' => $this->input->post('uom'),'report_for' => $this->input->post('sel_grn') ];
        	break;
        	case 'pid':
        		$selectedBy = ['uom' => $this->input->post('uom'),'report_for' => $this->input->post('sel_pid') ];
        	break;
        }

        if( $selectedBy['report_for'] == "" ){
        	$this->session->set_flashdata('message', 'Required all fields');
			redirect(base_url().'quality_control', 'refresh');
        }



        $data = $data + $selectedBy + ['created_by_cid' => $this->companyGroupId ,
        								'created_by' => $_SESSION['loggedInUser']->id,'type' => $this->input->post('report_chk') ];

       	if( isset($_POST['id']) && $_POST['id'] != "" ){
       		$masterData = $data;
	    	unset($masterData['report'],$masterData['logged_in_user'],$masterData['report_chk'],$masterData['sel_grn']);
	    	if( $masterData['type'] == 'grn' || $masterData['type'] == 'pid' ){
	    		$masterData = $masterData + ['at' => ""];
	    	}
	    	$res = $this->Quality_control_model->update_data('quality_control',$masterData,'id',$_POST['id']);
       	}else{
       		$res = $this->Quality_control_model->insert('quality_control',$data);
       	}

	    foreach ($data['report'] as $key => $value) {

	    	if( isset($value['trans_id'])  && $value['trans_id'] != '' ){
	    		$updateValue = $value;
	    		unset($updateValue['trans_id']);
			    $this->Quality_control_model->update_data('quality_control_trans',$updateValue,'id',$value['trans_id']);

	    	}else{
		    	if( $res ){
			    	$value = $value + ['report_id' => $res];
			    	$this->Quality_control_model->insert('quality_control_trans',$value);
		    	}

	    	}
	    }
   		$this->session->set_flashdata('message', 'Report Added Successfully');
		redirect(base_url().'quality_control', 'refresh');
	}
	
	public function updatereport(){
		 $id=$_POST['id'];
		 $report_name= $this->input->post('report_name');
		 $observations= $this->input->post('observations');
		 $per_lot_of= $this->input->post('per_lot_of');
		 $uom=$this->input->post('uom');
	     $type=$this->input->post('report_chk');
			    if( $type=='manufacturing')
		    {
		    $at=$this->input->post('ins_val1');	
		    $report_for=$this->input->post('ins_val2');
		    }
		    if($type=='grn')
		    {
			 $at='';
		     $report_for=$this->input->post('sel_grn');  
		    }
			if($type=='pid')
		    {
			 $at='';
		     $report_for=$this->input->post('sel_pid');  
		    }
		   $created_by= $_SESSION['loggedInUser']->id;
		   $created_by_cid= $this->companyGroupId;
		   $date=date("Y-m-d H:i:s");
		   $data=array(
		       'report_name'=> $report_name,
		       'observations'=>$observations,
		       'per_lot_of'=>$per_lot_of,
		       'uom'=>$uom,
		       'type'=>$type,
		       'at'=>$at,
		       'report_for'=>$report_for,
		       'created_date'=>$date,
		       'created_by'=>$created_by,
		       'created_by_cid'=>$created_by_cid);
		       $res=$this->Quality_control_model->update_data('quality_control',$data,'id',$id);
			  
		      logActivity('Report Updated Successfully','quality_control',$id);
                   
  		$this->Quality_control_model->delete_data('quality_control_trans','report_id',$id);//die();
					$parameter=$this->input->post('parameter');
                    $instrument=$this->input->post('instrument');
                    $uom=$this->input->post('uom1');
                    $expectation=$this->input->post('exp');
                	$deviation_min=$this->input->post('min_dev');
                	$deviation_max=$this->input->post('max_dev');
                	$exp_min_dev=$this->input->post('exp_min_dev');
                	$exp_max_dev=$this->input->post('exp_max_dev');
					if($expectation!='')
					{
					$count=count($expectation);	
					}else{
					$count=0;	
					}
					
		    	for ($i =0;$i<$count;$i++){
		   $data=array(
    		        
                    'parameter'=>$parameter[$i],
                    'instrument'=>$instrument[$i],
                    'expectation'=>$expectation[$i],
                    'uom1'=>$uom[$i],
                	'deviation_min'=>$deviation_min[$i],
                	'deviation_max'=>$deviation_max[$i],
                	'exp_min_dev'=>$exp_min_dev[$i],
                	'exp_max_dev'=>$exp_max_dev[$i],
                	'report_id'=>$id
		       ); 
	  $this->Quality_control_model->insert('quality_control_trans',$data);
                                                 }//print_r($data);die();
	   	$this->session->set_flashdata('message', 'Report Updated Successfully');
		redirect(base_url().'quality_control','refresh');
		}
	/******************* Inspection Report***********************/	
	public function inspection()
	{
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Quality Control',base_url().'quality_control');
	    $this->settings['breadcrumbs'] = $this->breadcrumb->output();
	    $this->settings['pageTitle'] = 'Manufacturing';
	    $data['ins']=$this->Quality_control_model->get_data1('inspection_report_master',array('created_by_cid'=>$this->companyGroupId),'');
	    $this->_render_template('quality_control/inspection/index',$data);
	}

	public function delete_inspection(){
		$id=$this->uri->segment(3);
		$this->Quality_control_model->delete_data('inspection_report_master','id',$id);
		$this->Quality_control_model->delete_data('inspection_report_trans','report_id',$id);
		$this->session->set_flashdata('message', 'Manufacturing Deleted Successfully');
		redirect(base_url().'quality_control/inspection', 'refresh');
	}
	public function get_sale_products(){
	   $id=$_POST['saleorder'];
	   $product_id=$this->Quality_control_model->get_sale_order('sale_order','id',$id);
	   $res =$this->Quality_control_model->get_data('job_card','saleorder');
		foreach ($res as $key) {
			$data = json_decode($key['material_details'],true);
			foreach($data as $dtl){
				if($dtl['material_name_id'] == $product_id)
				{
				$val= $this->Quality_control_model->get_jobcard_no($product_id);
				}
			                       }
		                         }
          echo $val;
    }
											
	public function get_work_products(){
	   $id=$_POST['workorder'];
	   $data['product']=$this->Quality_control_model->get_table_field('work_order','id',$id);
	   foreach($data['product'] as $data1){
		echo $data1->product_detail;
		}
    }

	public function save_inspection_report(){
		
		$userData         = ['created_by' => $_SESSION['loggedInUser']->id,'created_by_cid' => $this->companyGroupId,'created_date' => date('Y-m-d h:i:s')  ];
		$allData          = $this->input->post() + $userData;
		 
		$inputProcess     = json_encode($allData['inputProcess']);
		$machineActual    = json_encode($allData['machine']['actual']);
		unset($allData['inputProcess'],$allData['logged_in_user'],$allData['machine']);
		$removeReportData = $allData;
		if( $removeReportData['report'] ){
			unset($removeReportData['report']);         
		}

		$removeReportData = $removeReportData + ['input_process' => $inputProcess ] + ['machine_actual' => $machineActual];

		unset($removeReportData['incId']);
		if( $_POST['incId'] ){
			unset($removeReportData['created_date']);
			$this->Quality_control_model->updateWhereData('inspection_report_master',['id' => $_POST['incId'] ],$removeReportData);
			logActivity('Report Updated Successfully','inspection_report',$_POST['incId']);
			
			foreach ($allData['report'] as $key => $value) {
				$allParmData = $value;
				unset($allParmData['transId']);
				$this->Quality_control_model->updateWhereData('inspection_report_trans',['id' => $value['transId'] ],$allParmData);		
			}
			$msg = 'Report Update Successfully';
		}else{
			$reportId  = $this->Quality_control_model->insertAllData('inspection_report_master',$removeReportData);
			logActivity('Report Inserted Successfully','inspection_report',$reportId);
			if( $reportId ){
				foreach ($allData['report'] as $key => $value) {
					unset($value['transId']);
					$allParmData = $value + ['report_id' => $reportId ];
					$this->Quality_control_model->insertAllData('inspection_report_trans',$allParmData);		
				}	
			}
			$msg = 'Report Added Successfully';			
		}

		$this->session->set_flashdata('message',$msg);
		redirect(base_url().'quality_control/inspection', 'refresh');
	}
	
		
	public function get_job_table_values(){
	   $jobcard=$_POST['jobcard'];
	   $process_id=$_POST['process_id'];
	   $report_id=$this->Quality_control_model->get_jobcard_table_data('quality_control','at',$jobcard,'report_for',$process_id);
	   $this->Quality_control_model->get_table_field('quality_control_trans','report_id',$report_id);
	}
		//edit inspection report
	public function edit_inspection(){
	    $id=$_POST['id'];
	    if($id != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}

	    $data['edit']          = $this->Quality_control_model->get_table_field('inspection_report_master','id',$id);
	    $data['trans']         = $this->Quality_control_model->get_table_field('inspection_report_trans','report_id',$id);
	    $data['get_saleorder'] = $this->Quality_control_model->get_saleorder('sale_order','complete_status',0);
		$data['get_workorder'] = $this->Quality_control_model->get_data('work_order','');
	    $data['get_jobcard']   = $this->Quality_control_model->get_data('job_card','');
	    $data['process_type']  = $this->Quality_control_model->get_data('add_process','');
		$data['uom']           = $this->Quality_control_model->get_table_field('uom','created_by_cid',$this->companyGroupId);
		$data['ins']           = $this->Quality_control_model->get_data1('instrument',array('created_by_cid'=>$this->companyGroupId),'');
		$this->load->view('inspection/edit_inspection_report',$data);
	}
		//view inspection report
	public function view_inspection(){
	    permissions_redirect('is_view');
	    $id=$_POST['id'];
	    $data['edit']=$this->Quality_control_model->get_table_field('inspection_report_master','id',$id);
	    if($data['edit']){
	    	$data['edit'] = $data['edit'][0];
	    }

	    $data['trans']=$this->Quality_control_model->get_table_field('inspection_report_trans','report_id',$id);
	    $data['get_workorder']= $this->Quality_control_model->get_data('work_order','');
	    $data['get_jobcard']= $this->Quality_control_model->get_data('job_card','');
	    $data['process_type']= $this->Quality_control_model->get_data('add_process','');
		$data['uom']=$this->Quality_control_model->get_table_field('uom','created_by_cid',$this->companyGroupId);
		$data['ins']=$this->Quality_control_model->get_data1('instrument',array('created_by_cid'=>$this->companyGroupId),'');

	   $this->load->view('inspection/view_inspection_report',$data);
	}
	public function inspection_report(){
  		// $data['get_saleorder']= $this->Quality_control_model->get_saleorder('sale_order','complete_status',0);
		$data['get_workorder']= $this->Quality_control_model->get_data1('work_order',array('created_by_cid'=>$this->companyGroupId),'');
		$data['get_jobcard']= $this->Quality_control_model->get_data1('job_card',array('created_by_cid'=>$this->companyGroupId),'');
		$data['get_process']= $this->Quality_control_model->get_data1('add_process',array('created_by_cid'=>$this->companyGroupId),'');
		$data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1);
		$this->load->view('inspection/add_inspection_report',$data);
	}
		/***************** GRN *************/
	public function grn(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Quality Control',base_url().'quality_control/grn');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'GRN';
        $data['con']=$this->Quality_control_model->get_data1('controlled_report_master',array('created_by_cid'=>$this->companyGroupId,'saleorder'=>'grn'),'');
        $this->_render_template('quality_control/grn/index',$data);
	}

	public function add_grn() {
		$id=$_POST['id'];
		if($id!=''){
			$data['grn']=$this->Quality_control_model->get_data_byId('controlled_report_master','id',$id);
			$data['grn_trans']=$this->Quality_control_model->get_table_field_array('controlled_report_trans','report_id',$id);
		}
		$data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1);
		$data['material']= $this->Quality_control_model->get_data('material','');
	    $this->load->view('grn/edit',$data);
    }
	public function view_grn(){
	    permissions_redirect('is_view');
	    $id=$_POST['id'];
        $data['edit']=$this->Quality_control_model->get_table_field('controlled_report_master','id',$id);
	    $data['trans']=$this->Quality_control_model->get_table_field('controlled_report_trans','report_id',$id);
		$data['material']= $this->Quality_control_model->get_data('material','');
	    $data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1); 
	    $this->load->view('grn/view',$data);	
	}
	public function delete_grn(){
		$id=$this->uri->segment(3);
		$this->Quality_control_model->delete_data('controlled_report_master','id',$id);
		$this->Quality_control_model->delete_data('controlled_report_trans','report_id',$id);
		$this->session->set_flashdata('message', 'GRN Deleted Successfully');
		redirect(base_url().'quality_control/grn', 'refresh');
	}


	public function save_grn_report(){	

	    $data = $this->input->post();
	    $data = $data + ['quantity_info' => json_encode(['tot_qty' => $data['tot_qty'],'qty_pass' => $data['qty_pass'],
	    	'qty_reject' => $data['qty_reject'],'qty_rework' =>$data['qty_rework']  ])];
	    if( $data['id'] !='' ){
	    	$masterData = $data;
	    	unset($masterData['report'],$masterData['logged_in_user'],$masterData['trnsId'],$masterData['tot_qty'],$masterData['qty_pass'],
	    		$masterData['qty_reject'],$masterData['qty_reject'],$masterData['qty_rework']);
	    	$this->Quality_control_model->update_data('controlled_report_master',$masterData,'id',$masterData['id']);
	    }else{
	    	$masterData = $data;
	    	$masterData = $masterData + ['created_by' => $masterData['logged_in_user'],'created_by_cid' => $this->companyGroupId ];
	    	unset($masterData['report'],$masterData['logged_in_user'],$masterData['trnsId'],$masterData['tot_qty'],$masterData['qty_pass'],
	    	$masterData['qty_reject'],$masterData['qty_reject'],$masterData['qty_rework'],$masterData['id']);
	    	$insertLastId = $this->Quality_control_model->insertReport('controlled_report_master',$masterData);
	    }

	   	foreach ($data['report'] as $key => $value) {
	   		$value = $value + ['coils' => json_encode($value['obs']) ];
	   		unset($value['obs']);
	   		if( $data['id'] != "" ){
	   			$value = $value + ['report_id' => $data['id']];
	   			$this->Quality_control_model->update_data('controlled_report_trans',$value,'id',$data['trnsId']);
	   		}else{
	   			$value = $value + ['report_id' => $insertLastId];
	   			$this->Quality_control_model->insertReport('controlled_report_trans',$value);
	   		}
	   	}
		
		if( $data['saleorder'] == 'grn' ){ $upDateMsg = 'GRN'; }else{ $upDateMsg = 'PID'; }			
		if($data['id']!='' ){
			$this->session->set_flashdata('message', "{$upDateMsg} Updated Successfully");
		}else{
	   		$this->session->set_flashdata('message', "{$upDateMsg} Added Successfully");
		}

		if( $data['saleorder'] == 'grn' ){
			redirect(base_url().'quality_control/grn', 'refresh');			
		}else{
			redirect(base_url().'quality_control/pid', 'refresh');	
		}
	}

		
		/***************** PID *************/
	public function pid(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Quality Control',base_url().'quality_controlpid');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'PDI';
        $data['pid']=$this->Quality_control_model->get_data1('controlled_report_master',array('created_by_cid'=>$this->companyGroupId,'saleorder'=>'pid'),'');
        $this->_render_template('quality_control/pid/index',$data);
	}	
	
	public function add_pid() {
		$id=$_POST['id'];
		if($id!=''){
			$data['pid']=$this->Quality_control_model->get_data_byId('controlled_report_master','id',$id);
			$data['pid_trans']=$this->Quality_control_model->get_table_field_array('controlled_report_trans','report_id',$id);
		}
		$data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1);
		$data['material']= $this->Quality_control_model->get_data('material','');
	   $this->load->view('pid/edit',$data);
    }
	
	public function view_pid(){
	    	permissions_redirect('is_view');
		    $id=$_POST['id'];
            $data['edit']=$this->Quality_control_model->get_table_field('controlled_report_master','id',$id);
		    $data['trans']=$this->Quality_control_model->get_table_field('controlled_report_trans','report_id',$id);
			$data['material']= $this->Quality_control_model->get_data('material','');
		    $data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1); 
		    $this->load->view('pid/view',$data);	
	}
	   
	public function delete_pid(){
		$id=$this->uri->segment(3);
		$this->Quality_control_model->delete_data('controlled_report_master','id',$id);
		$this->Quality_control_model->delete_data('controlled_report_trans','report_id',$id);
		$this->session->set_flashdata('message', 'Pid Deleted Successfully');
		redirect(base_url().'quality_control/pid', 'refresh');
	}

		
		/*********************** NCR ********************/
			public function ncr(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->data['can_validate'] = validate_permissions();	
		$this->breadcrumb->add('Quality Control',base_url().'quality_control/ncr');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'NCRs';
        $this->data['ncr']=$this->Quality_control_model->get_data1('register_complaint',array('created_by_cid'=>$this->companyGroupId,'status'=>'Open'),'');
		$this->data['close_ncr']=$this->Quality_control_model->get_data1('register_complaint',array('created_by_cid'=>$this->companyGroupId,'status'=>'Close'),'');
        $this->_render_template('quality_control/ncr/index',$this->data);
		//pre($this->data);die;
			}
			
		public function add_ncr() {
		$id=$_POST['id'];
		if($id!=''){
		$data['edit']=$this->Quality_control_model->get_data_byId('register_complaint','id',$id);
		}
	  $data['get_user']= $this->Quality_control_model->get_data1('user_detail',array('c_id'=>$this->companyGroupId),'');
	   $this->load->view('ncr/edit',$data);
                                   }
                                    	
        public function save_ncr(){
		$data= $this->input->post();
		$data['created_by_cid']= $this->companyGroupId;
		$data['auto_cust_id']=time();
		$data['status']='Open';
		$data['email']=json_encode(array('email'=>$this->input->post('email')));
		$data['problem']=json_encode(array('problem'=>$this->input->post('problem')));

        
        if(!empty($this->input->post('email')[0])){
			$this->load->library('email');
			$config = array('mailtype' => 'text', 'charset' => 'utf-8');
			$this->email->initialize($config);
			
			$this->email->from('varsha@lastingerp.com');
			$this->email->to("varsha@lastingerp.com");
			$this->email->subject('This Email for testing purpose');
			$this->email->message('This Email for testing purpose');
			//
			//Send mail 
			if($this->email->send()) {
				//echo "sent";
			} else {
			// echo $this->email->print_debugger();
			}
		}
        
        
        
	//pre($data); die();
		if($this->input->post('id')!=''){
			$this->Quality_control_model->update_data('register_complaint',$data,'id',$_POST['id']);	
			}else{
     	$this->Quality_control_model->insert('register_complaint',$data);
		$this->session->set_flashdata('message', 'NCRs Registered Successfully');
		}
	   redirect(base_url().'quality_control/ncr', 'refresh');
                        }
						
		public function view_ncr(){
		permissions_redirect('is_view');
		$id=$_POST['id'];
		if($id!='')
		{
			 $data['get_user']= $this->Quality_control_model->get_data1('user_detail',array('c_id'=>$this->companyGroupId),'');
            $data['edit']=$this->Quality_control_model->get_data_byId('register_complaint','id',$id);
		}
		$this->load->view('ncr/view',$data);	
		}
         
		public function close_ncr(){
			
				$this->load->view('ncr/close');	
		}
		 
		public function update_ncr(){
			$id= $this->input->post('id');
			//$data['status']='Close';
			$data['cause']=json_encode(array('root_cause'=>$this->input->post('root_cause'),'corr_act'=>$this->input->post('corr_act'),'prev_act'=>$this->input->post('prev_act')));
			//pre($data);die();
			$this->Quality_control_model->update_data('register_complaint',$data,'id',$id);
			redirect(base_url().'quality_control/ncr', 'refresh');			
		 }
		 //finish Goods
		public function finish_goods(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->data['can_validate'] = validate_permissions();	
		$this->breadcrumb->add('Quality Control',base_url().'quality_control/finish_goods');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Finish Goods';
        $this->data['finish_goods']=$this->Quality_control_model->get_data1('quality_finish_goods',array('created_by_cid'=>$this->companyGroupId),'');
        $this->_render_template('quality_control/finish_goods/index',$this->data);
	}
			
		public function finish_goods_edit() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = add_permissions();
        $where = array('created_by_cid' => $this->companyGroupId);
		$this->data['edit'] = $this->Quality_control_model->get_data_byId('quality_finish_goods','id',$this->input->post('id'));
        $this->load->view('finish_goods/edit', $this->data);
    }
	public function jobcard_details() {
        $where = array('created_by_cid' => $this->companyGroupId);
		$this->data['datst'] = $this->Quality_control_model->get_data_byId('quality_finish_goods','id',$this->input->post('id'));
        $this->load->view('finish_goods/view', $this->data);
    }
		 //approve ncr
		   public function approve_ncr() {
        if ($_POST['id'] && $_POST['id'] != '') {
            $data = array('approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0,'status'=>'Close');
            $result = $this->Quality_control_model->approve_ncr_data($_POST);
            if ($result) {
                logActivity('NCRs approved', 'register_complaint', $_POST['id']);
                $usersWithViewPermissions = $this->Quality_control_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'NCRs approved', 'message' => 'NCRs id :# ' . $_POST["id"] . ' is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $_POST['id'], 'class' => 'qualityTab', 'data_id' => 'register_complaint_view', 'icon' => 'fa-shopping-cart'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'NCRs approved', 'message' => 'NCRs id :# ' . $_POST["id"] . ' is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $_POST['id'], 'class' => 'qualityTab', 'data_id' => 'register_complaint_view', 'icon' => 'fa-shopping-cart'));
                }
                $this->session->set_flashdata('message', 'NCRs approved');
					
                $result = array('msg' => 'NCRs approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'quality_control/register_complaint');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
		
        }
        
    }
	
	//disapprove ncr
	 public function disApprove_ncr() {
        if ($this->input->post()) {
            $required_fields = array('disapprove_reason');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $idss1 = $_POST['id'];
                $id = explode(",", $idss1);
                $usersWithViewPermissions = $this->Quality_control_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                foreach ($id as $key) {
             $data = array('id' => $key, 'validated_by' => $_POST['validated_by'], 'disapprove' => $_POST['disapprove'],'disapprove' => 1, 'approve' => $_POST['approve'], 'disapprove_reason' => $_POST['disapprove_reason']);
                    $success = $this->Quality_control_model->disApprovedata($data);
                    logActivity('Complaint Disapproved', 'register_complaint', $key);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'complaint disapproved', 'message' => 'Register Complaint id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $key, 'class' => 'qualityTab', 'data_id' => 'register_complaint_view', 'icon' => 'fa-shopping-cart'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'NCRs disapproved', 'message' => 'Register Complaint id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $key, 'class' => 'qualityTab', 'data_id' => 'register_complaint_view', 'icon' => 'fa-shopping-cart'));
                    }
                }
                if ($success) {
            $data['message'] = "Register Complaint Disapproved";
            $this->session->set_flashdata('message', 'NCRs Disapproved successfully');
            redirect(base_url() . 'quality_control/ncr', 'refresh');
                }
            }
        }
    }
	
        public function get_cust_saleorder(){
            $account_id=$_POST['account_id'];
            $get_saleorder= $this->Quality_control_model->get_data1('sale_order',array('account_id'=>$account_id),'');
            $html="<option>Select SaleOrder</option>";
            foreach($get_saleorder as $data)
            {
               $html.='<option value="'.$data['id'].'">'.$data['so_order'].'</option>'; 
            }
           echo $html;
        }
        
		   public function get_cust_email(){
            $account_id=$_POST['account_id'];
            $data=$this->Quality_control_model->get_data_byId('account','id',$account_id);
			echo $data->email;
        }
		
        public function get_cust_saleorder_products(){
            $saleorder_id=$_POST['saleorder_id'];
            $get_saleorder_products= $this->Quality_control_model->get_data1('sale_order',array('id'=>$saleorder_id),'');
            foreach($get_saleorder_products as $products){
            $pro=json_decode($products['product'],true);
            $html="<option>Select Products</option>";
            foreach($pro as $data)
            {
            $pro_nam = getNameById('material',$data['product'],'id');
            $html.='<option value="'.$data['product'].'">'.$pro_nam->material_name.'</option>'; 
            }
           echo $html;
            }
        }
        
		/******************* Controlled Report***********************/	
		public function controlled(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Quality Control',base_url().'quality_control/controlled');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'GRN';
        $data['con']=$this->Quality_control_model->get_data1('controlled_report_master',array('created_by_cid'=>$this->companyGroupId),'');
        $this->_render_template('quality_control/controlled/index',$data);
	                            	}	
									
	public function controlled_report() {
		$id=$_POST['id'];
	$data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1);
	   $this->load->view('controlled/add_controlled_report',$data);
                                    	}
	
	public function	get_product_order()	{
	   $val=$_POST['product'];
	  // echo $val;
	   if($val=='grn')
	   {
	        $material_data=$this->Quality_control_model->get_data1('material',array('created_by_cid'=>$this->companyGroupId),'');
			echo json_encode($material_data);
	   }else
	   {
	        $this->Quality_control_model->get_sale_products();	    
                                	}
	}
	/*** get_grn_product_quantity ***/
	public function	get_grn_product_quantity()
	{
		$material_id = $_POST['product'];

		$quantity=0;
		$data=$this->Quality_control_model->get_material_qty('mrn_detail','material_name',$material_id);
		foreach($data as $data1){
			//pre($data1);
		$val= json_decode($data1->material_name);
		//pre($val);	
		foreach($val as $val1){	
		if($val1->material_name_id==$material_id)
			{
				$qty=$val1->quantity;
			 $quantity= $quantity+$qty;
			}
		}
		
		}
		echo  $quantity;
	}
	
	public function	get_saleorder_product_order()
	{
		$material_id=$_POST['product'];
		$quantity=0;
		$data=$this->Quality_control_model->get_material_qty('sale_order','product',$material_id);
		foreach($data as $data1){
			//pre($data1);
		$val= json_decode($data1->product);
		//pre($val);
				$quantity=0;
		foreach($val as $val1){	
		if($val1->product==$material_id)
			{
			$quantity+= $val1->quantity;
			}
		}
		}
		echo  $quantity;
	}
   public function	get_con_table_values(){
   	   if( $_POST['id'] != "" ){
   	   		$grn = $this->Quality_control_model->getReportByType(['id' => $_POST['id']],'controlled_report_master');	
   	   		$data['grn']       = $grn[0];
		   	$data['grn_trans'] = $this->Quality_control_model->get_table_field_array('controlled_report_trans','report_id',$data['grn']->id);
   	   }else{
	       $material_id=$_POST['material_id'];
	       $grn = $this->Quality_control_model->getReportByType(['report_for' => $material_id,'type' => $_POST['reportType'] ]);
	       $data['grn']       = $grn[0];
		   $data['grn_trans'] = $this->Quality_control_model->get_table_field_array('quality_control_trans','report_id',$data['grn']->id);
   	   }
	   echo json_encode(['paremeter' => $this->load->view('report_parameter/reportParameter',$data,TRUE),'reportData' => $data['grn'] ]);
	   //return $this->load->view('report_parameter/reportParameter',$data,TRUE);
   }

   public function save_controlled_report()
		{	
		   $data= $this->input->post();
		   $data['created_by']= $_SESSION['loggedInUser']->id;
		   $data['created_by_cid']= $this->companyGroupId;
		   $data['created_date']=date("Y-m-d H:i:s");//pre($data); die();
		   $qty=json_encode(array('tot_qty'=>$this->input->post('tot_qty'),'qty_pass'=>$this->input->post('qty_pass'),'qty_reject'=>$this->input->post('qty_reject'),'qty_rework'=>$this->input->post('qty_rework')));
		   $data['quantity_info']=$qty;
		   $res=$this->Quality_control_model->insert('controlled_report_master',$data);
		          $count=0; 
                   $parameter=$this->input->post('parameter');
                    $instrument=$this->input->post('instrument');
                     $uom=$this->input->post('uom1');
                    $expectation=$this->input->post('exp');
                	$deviation_min=$this->input->post('min_dev');
                	$deviation_max=$this->input->post('max_dev');
                	$exp_min_dev=$this->input->post('exp_min_dev');
                	$exp_max_dev=$this->input->post('exp_max_dev');
                	$result=$this->input->post('result');
                	$remark=$this->input->post('remark');
                	$grade=$this->input->post('res');
    $count=count($expectation);
        for ($j =0; $j <$count; $j++){
		   $data=array(
                    'parameter'=>$parameter[$j],
                    'instrument'=>$instrument[$j],
                    'uom1'=>$uom[$j],
                    'expectation'=>$expectation[$j],
                	'deviation_min'=>$deviation_min[$j],
                	'deviation_max'=>$deviation_max[$j],
                	'exp_min_dev'=>$exp_min_dev[$j],
                	'exp_max_dev'=>$exp_max_dev[$j],
                	'result'=>$result[$j],
                	'remark'=>$remark[$j],
                	'pf'=>$grade[$j],
                	'report_id'=>$res);
					
		$this->Quality_control_model->insert('controlled_report_trans',$data);
                                     }
	   	$this->session->set_flashdata('message', 'Report Added Successfully');
		redirect(base_url().'quality_control/controlled', 'refresh');
		}
		public function edit_controlled()
		{
		      $id=$_POST['id'];
		        	if($id != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}
	$grn_id=$this->Quality_control_model->get_row_value1('controlled_report_master','id',$id);
	$material1=$this->Quality_control_model->get_table_field_array('mrn_detail','id',$grn_id->grn_id);
	//pre($material1);
	foreach ($material1 as $key) {
				 $data = json_decode($key['material_name'],true);
				foreach($data as $dtl){
		$data['material']=$this->Quality_control_model->get_grn_material($dtl['material_name_id']);
				}//pre($data['material']); 
	}
	//die();
		    $data['edit']=$this->Quality_control_model->get_table_field('controlled_report_master','id',$id);
		    $data['trans']=$this->Quality_control_model->get_table_field('controlled_report_trans','report_id',$id);
		    $data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1);
		   $this->load->view('controlled/edit_controlled_report',$data);
		}
		public function update_controlled_report()
	{
	   $id=$_POST['id'];
	   $report_name= $this->input->post('report_name');
	   $observations= $this->input->post('observations');
	   $per_lot_of= $this->input->post('per_lot_of');
	   $uom=$this->input->post('uom');
	   $saleorder=$this->input->post('saleorder');
	   $material_id=$this->input->post('material_id');
      // $created_by=$this->input->post('logged_in_user');
	    $final_report=$this->input->post('final_report');
       $date=date("Y-m-d H:i:s");
		    $data=array('report_name'=> $report_name,
		       'observations'=>$observations,
		       'per_lot_of'=>$per_lot_of,
		       'uom'=>$uom,
		       'saleorder'=>$saleorder,
		       'material_id'=>$material_id,
		       'created_date'=>$date,
			     'final_report'=>$final_report,
		       );
	  $res=$this->Quality_control_model->update_data('controlled_report_master',$data,'id',$id);
	       	logActivity('Report Updated Successfully','controlled_report',$id);
		  $this->Quality_control_model->delete_data('controlled_report_trans','report_id',$id);    
		          $count=0;
                    $parameter=$this->input->post('parameter');
                    $instrument=$this->input->post('instrument');
                    $uom=$this->input->post('uom1');
                    $expectation=$this->input->post('exp');
                	$deviation_min=$this->input->post('min_dev');
                	$deviation_max=$this->input->post('max_dev');
                	$exp_min_dev=$this->input->post('exp_min_dev');
                	$exp_max_dev=$this->input->post('exp_max_dev');
                	$result=$this->input->post('result');
                	$remark=$this->input->post('remark');
                	$grade=$this->input->post('res');
					if($expectation!='')
            {$count=count($expectation);}
		    	for ($j =0; $j <$count; $j++){
            		   $data=array(
                                'parameter'=>$parameter[$j],
                                'instrument'=>$instrument[$j],
                                'uom1'=>$uom[$j],
                                'expectation'=>$expectation[$j],
                            	'deviation_min'=>$deviation_min[$j],
                            	'deviation_max'=>$deviation_max[$j],
                            	'exp_min_dev'=>$exp_min_dev[$j],
                            	'exp_max_dev'=>$exp_max_dev[$j],
                            	'result'=>$result[$j],
                            	'remark'=>$remark[$j],
                            	'pf'=>$grade[$j],
                              'report_id'=>$id);
		    $this->Quality_control_model->insert('controlled_report_trans',$data);
        } //die();
	   	$this->session->set_flashdata('message', 'Report Updated Successfully');
		redirect(base_url().'quality_control/controlled/', 'refresh');
	}
	public function view_controlled(){
	    permissions_redirect('is_view');
		    $id=$_POST['id'];
            $data['edit']=$this->Quality_control_model->get_table_field('controlled_report_master','id',$id);
		    $data['trans']=$this->Quality_control_model->get_table_field('controlled_report_trans','report_id',$id);
		    $data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1); 
		    $this->load->view('controlled/view_controlled_report',$data);
		                                        }
/******************* Instrument ***********************/	
    public function instrument(){
        $this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		    $this->breadcrumb->add('Quality Control',base_url().'quality_control/instrument');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Instrument';
        $data['ins']=$this->Quality_control_model->get_data1('instrument',array('created_by_cid'=>$this->companyGroupId),'');
        $this->_render_template('quality_control/instrument/index',$data);
	                            	}	
	public function add_instrument(){
			  $this->load->view('instrument/add_instrument');
		}
	public function delete_instrument(){
			$id=$this->uri->segment(3);
			$this->Quality_control_model->delete_data('instrument','id',$id);
			$this->session->set_flashdata('message', 'Instrument Deleted Successfully');
			redirect(base_url().'quality_control/instrument', 'refresh');
		}
	public function save_instrument(){
		$data= $this->input->post();
		//echo 'pic'.$_FILES["calibration_certificate"]["name"].$this->input->post('calibration_certificate');
		 if($_FILES["calibration_certificate"]["name"]==''){
            $data['calibration_certificate']='';
		 }else
            {
        $config['upload_path'] = './assets/modules/quality_control/uploads/'; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|pdf|xml|doc|jfif';
       // $config['max_size'] = 2000;
       // $config['max_width'] = 1500;
       // $config['max_height'] = 1500;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('calibration_certificate')) 
		{
            $error = array('error' => $this->upload->display_errors());
            print_r($error);die();
        } 
		else 
		{ 
            $data1 = array('calibration_certificate' => $this->upload->data());
        }
		 $data['calibration_certificate']=$data1['calibration_certificate']['orig_name'];
			}
			
       //pre($data);die();
           $data['created_by']= $_SESSION['loggedInUser']->id;
		   $data['created_by_cid']= $this->companyGroupId;//print_r($data);die();
     $this->Quality_control_model->insert('instrument',$data);
    $this->session->set_flashdata('message', 'Instrument Added Successfully');
		redirect(base_url().'quality_control/instrument', 'refresh');
	}
	public function edit_instrument(){
	     $id=$_POST['id'];
	       	if($id != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}
	  $data['ins']=$this->Quality_control_model->get_table_field('instrument','id',$id);
	  $this->load->view('instrument/edit_instrument',$data);
	}
	public function view_instrument(){
	    permissions_redirect('is_view');
	 $id=$_POST['id'];
	  $data['ins']=$this->Quality_control_model->get_table_field('instrument','id',$id);
	  $this->load->view('instrument/view_instrument',$data);
	}
	public function update_instrument(){
	    $id=$_POST['id'];
		$name= $this->input->post('name');
		$range= $this->input->post('ins_range');
		$upper_range= $this->input->post('upper_range');
		$range_uom= $this->input->post('range_uom');
		$least_count= $this->input->post('least_count');
		$least_uom= $this->input->post('least_uom');
		$date_of_purchase=$this->input->post('date_of_purchase');
		$last_calibrated_on=$this->input->post('last_calibrated_on');
		$calibration_due_date=$this->input->post('calibration_due_date');
		$ins_assign_to=$this->input->post('ins_assign_to');
		$calibration_certificate=$_FILES["calibration_certificate"]["name"];
		if($calibration_certificate==''){
            $calibration_certificate=$this->input->post('image');
		}
		else
        {
        	$config['upload_path'] = './assets/modules/quality_control/uploads/'; 
        	$config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|pdf|xml|doc|jfif';
			// $config['max_size'] = 2000;
			// $config['max_width'] = 1500;
			// $config['max_height'] = 1500;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('calibration_certificate')) 
			{
				$error = array('error' => $this->upload->display_errors());
				//print_r($error);
			} 
			else 
			{
				$data1 = array('calibration_certificate' => $this->upload->data());
				//print_r($data1);die();
			}
          	$calibration_certificate=$data1['calibration_certificate']['orig_name'];
        }		
        $data=array('name'=>$name,'ins_range'=>$range,'upper_range'=>$upper_range,'range_uom'=>$range_uom,'least_count'=>$least_count,'least_uom'=>$least_uom,'date_of_purchase'=>$date_of_purchase,'last_calibrated_on'=>$last_calibrated_on,'calibration_due_date'=>$calibration_due_date,'ins_assign_to'=>$ins_assign_to,'calibration_certificate'=>$calibration_certificate);
        #print_r($data);die();
        $this->Quality_control_model->update_data('instrument',$data,'id',$id);
        $this->session->set_flashdata('message', 'Instrument Updated Successfully');
		redirect(base_url().'quality_control/instrument', 'refresh');
	}
/************************** Sale Order **************************/
   public function sale_orders(){
        $this->breadcrumb->add('Quality Control',base_url().'quality_control/sale_orders');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Sale Orders';
        $data['process']=$this->Quality_control_model->get_data1('sale_order',array('created_by_cid'=>$this->companyGroupId,'complete_status'=>0),'');
        $data['completed']=$this->Quality_control_model->get_data1('sale_order',array('created_by_cid'=>$this->companyGroupId,'complete_status'=>1),'');;
       // pre($data);
        $this->_render_template('quality_control/sale_orders/index',$data);
	}
	public function get_report(){
	    $this->breadcrumb->add('Quality Control',base_url().'quality_control/sale_orders');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Sale Order Reports';
	    $id=$this->uri->segment(3);
		$workorder_id = $this->Quality_control_model->get_element_by_id('work_order','sale_order_id',$id);
		if($workorder_id!=''){$work=$workorder_id->id;}else{$work='';}
		$data['ins']=$this->Quality_control_model->get_saleorder_report($work);
		$this->_render_template('quality_control/sale_orders/report',$data);
	}
// For Inspection PipeLine Module Start//

	
	public function changgrnProcessType(){
		echo $data = $this->input->post();
		
	}
	
    public function changeOrder(){
		$orders = $_POST['order'];
		//pre($orders);
		$process_order = $this->Quality_control_model->change_process_order('inspection_report_master',$orders);
		echo json_encode(array('msg' => 'error', 'status' => 'success', 'code' => 'C774'));		
	}
	public function inspection_pipeline(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Quality Control', base_url() . 'quality_control/dashboard');
		$this->breadcrumb->add('Pipe Line', base_url() . 'quality_control/pipeline');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Pipeline';
		//$where = array('created_by_cid'=>$this->companyGroupId);
				$array = [];
				$where = array('created_by_cid' => $this->companyGroupId);
				$this->data['processType']= $this->Quality_control_model->get_data('controlled_report_status','report_status');
				$i=0;
				foreach($this->data['processType'] as $ProcessType){
				$process = $this->Quality_control_model->get_data1('inspection_report_master',array('created_by_cid' => $this->companyGroupId,'final_report'=>$ProcessType['id']),'');	
					$array[$i]['types'] = $ProcessType;
					$array[$i]['process'] = $process;
					$i++;	
				}
				$this->data['processdata'] = $array;						
				$this->_render_template('quality_control/pipeline/inspection_pipeline',$this->data);
	}
	//Controlled pipeline
	public function changeProcessType1() {
		$data = $this->input->post();
		$id=$data['processId'];
		//pre($data);die();
		$process_status = $this->Quality_control_model->change_process_status('controlled_report_master',$data,$id);
		$this->_render_template('quality_control/pipeline/index', $process_status);	
    }
		public function changeProcessType() {
		$data = $this->input->post();
		$id=$data['processId'];
		$process_status = $this->Quality_control_model->change_process_status('inspection_report_master',$data,$id);
		$this->_render_template('quality_control/pipeline/index', $process_status);	
    }
    public function changeOrder1(){
		$orders = $_POST['order'];
		//pre($orders);
		$process_order = $this->Quality_control_model->change_process_order('controlled_report_master',$orders);
		echo json_encode(array('msg' => 'error', 'status' => 'success', 'code' => 'C774'));		
	}
	public function pipeline(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Quality Control', base_url() . 'quality_control/dashboard');
		$this->breadcrumb->add('Pipe Line', base_url() . 'quality_control/pipeline');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Pipeline';
		$where =array('created_by_cid'=>$this->companyGroupId);
				$array = [];
			//	$where = array('created_by_cid' => $this->companyGroupId);
				$this->data['processType']= $this->Quality_control_model->get_data('controlled_report_status','report_status');
				$i=0;
				foreach($this->data['processType'] as $ProcessType){
					$process = $this->Quality_control_model->get_data1('controlled_report_master',array('created_by_cid' => $this->companyGroupId,'final_report'=>$ProcessType['id'],'saleorder'=>'grn'),'');
					$array[$i]['types'] = $ProcessType;
					$array[$i]['process'] = $process;
					$i++;	
				}
				$this->data['processdata'] = $array;		
				$array1 = [];
				//$where = array('created_by_cid' => $this->companyGroupId);
				$i=0;
				foreach($this->data['processType'] as $ProcessType){
				$process1 = $this->Quality_control_model->get_data1('inspection_report_master',array('created_by_cid' => $this->companyGroupId,'final_report'=>$ProcessType['id']),'');	
					$array1[$i]['types'] = $ProcessType;
					$array1[$i]['process'] = $process1;
					$i++;	
				}
				$this->data['processdata1'] = $array1;
				$array2 = [];
				//$where = array('created_by_cid' => $this->companyGroupId);
				$i=0;
				foreach($this->data['processType'] as $ProcessType){
				$process2 = $this->Quality_control_model->get_data1('controlled_report_master',array('created_by_cid' => $this->companyGroupId,'final_report'=>$ProcessType['id'],'saleorder'=>'pid'),'');	
					$array2[$i]['types'] = $ProcessType;
					$array2[$i]['process'] = $process2;
					$i++;	
				}
				$this->data['processdata2'] = $array2;	
				$this->_render_template('quality_control/pipeline/index',$this->data);
	}
	//add comment to pipeline report
	public function add_comment(){
	  //  pre($_POST);die();
	  //  pre($_POST);die();
	    $data=array('comment'=>$_POST['comment']);
	   if($_POST['active_tab']=='inspection')
	   {
	         $this->Quality_control_model->update_data('inspection_report_master',$data,'id',$_POST['id']);
	          redirect(base_url().'quality_control/pipeline');
	   }else{
	         $this->Quality_control_model->update_data('controlled_report_master',$data,'id',$_POST['id']);
	          redirect(base_url().'quality_control/pipeline');
	   }
	  
	}
	/*************** Dashboard **************/
		public function dashboard(){
		      $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Quality Control',base_url().'quality_control/dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Dashboard';
        $this->_render_template('quality_control/dashboard/index');
	}
	public function changeProcessType2() {
		$data = $this->input->post();
		$id=$data['processId'];
		$process_status = $this->Quality_control_model->change_process_status1('job_application',$data,$id);
		$this->_render_template('quality_control/recruitment/pipeline/index', $process_status);	
    }
    public function changeOrder2(){
		$orders = $_POST['order'];
		//pre($orders);
		$process_order = $this->Quality_control_model->change_process_order('job_application',$orders);
		echo json_encode(array('msg' => 'error', 'status' => 'success', 'code' => 'C774'));		
	}
	
// For Indexing Terms & Condtions
    public function hrmterms_condtn(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
		$this->breadcrumb->add('Settings', base_url() . 'hrm/settings');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Settings';
	    $this->data['termsconds'] = $this->Quality_control_model->get_data('hrm_terms',array('created_by_cid'=> $this->companyGroupId));
        $this->_render_template('settings/terms_conditions/index', $this->data);
		}   
		//	For Editing Terms & Conditions
	public function editterms_condtn(){
		if($this->input->post('id') != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}
		$this->data['termsconds'] = $this->Quality_control_model->get_element_by_id('hrm_terms','id',$this->input->post('id'));
		$this->load->view('settings/terms_conditions/edit', $this->data);	
	}
	
	// For Viewing Terms & Conditions
	public function termscond_view(){
	    $id=$_POST['id'];
		if($id != ''){
			permissions_redirect('is_view');
		}		
		$this->data['termsconds'] = $this->Quality_control_model->get_element_by_id('hrm_terms','id',$id);
		$this->load->view('settings/terms_conditions/view', $this->data);
	}
	

// For Saving Terms & Conditions
	public function saveterms_condtn(){	 
	#pre($_POST); 
			
		if ($this->input->post()) {
			$required_fields = array('title','terms_cond');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();
				$data['created_by'] = $_SESSION['loggedInUser']->id;
			//	$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;

				$data['created_by_cid'] = $this->companyGroupId;
				$id = $data['id'];
			//	$usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 95));
			
				if($id && $id != ''){
					$success = $this->Quality_control_model->update_data('hrm_terms',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Terms & Conditions updated successfully";
                        logActivity('Terms & Conditions updated','lead',$id);
			
						if($_SESSION['loggedInUser']->role !=1){
						/*	pushNotification(array('subject'=> 'CRM terms & conditions updated' , 'message' => 'CRM terms & conditions updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/	

							pushNotification(array('subject'=> 'terms & conditions updated' , 'message' => 'terms & conditions updated : #'.$id.'is updated by '.$_SESSION['loggedInUser']->name,'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' =>  $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id,'class'=>'qualityTab','data_id' => 'termscond_view','icon'=>'fa fa-shekel'));
						}
						
                        $this->session->set_flashdata('message', 'Terms & Conditions updated successfully');
                    }
				}else{
					$id = $this->Quality_control_model->insert('hrm_terms',$data);					
					if ($id) {                        
                        logActivity('New Terms & Conditions Created','Terms & Conditions',$id);
					
						if($_SESSION['loggedInUser']->role !=1){
						

							pushNotification(array('subject'=> 'terms & conditions created' , 'message' => 'New terms & conditions created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' =>  $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id ,'class'=>'qualityTab','data_id' => 'termscond_view' ,'icon'=>'fa fa-shekel'));
						}
                        $this->session->set_flashdata('message', 'New Terms & Conditions Created','Terms & Conditions');
                    }    				
				}
				  redirect(base_url().'quality_control/hrmterms_condtn', 'refresh');
			}			
        }
	}
	
	 function qualityReportPdf(){
        $this->load->library('Pdf');
        $id = $this->uri->segment(3);
        $data['edit']=$this->Quality_control_model->get_table_field('controlled_report_master','id',$id);
        if( !empty($data['edit'] )){
            $data['edit'] = $data['edit'][0];
        }
        $data['trans']=$this->Quality_control_model->get_table_field('controlled_report_trans','report_id',$id);
           $data['ins']=$this->Quality_control_model->get_data1('instrument',array('created_by_cid'=>$this->companyGroupId),'');
        $data['material']= $this->Quality_control_model->get_data('material','');
        $data['uom']=$this->Quality_control_model->get_table_field('uom','active_inactive',1);
        $this->load->view('view_pdf',$data);
    }
	function day_line_wise_inspection(){
		 $this->load->library('pagination');
        $this->data['can_edit']   = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add']    = add_permissions();
        $this->data['can_view']   = view_permissions();
      // $this->breadcrumb->add('Machine List', base_url() . 'add_machine');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle']   = 'Day Line Wise Inspection';
        /* if(isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!=''){
        $_SESSION['loggedInUser']->c_id = $_SESSION['companyGroupSessionId'];
        } */
        $this->data['AddMachine']='';
        $where='';
       if (!empty($_GET["start"])  && !empty($_GET['end']) &&  !empty($_GET['company_branch'])) {
     
            $start = date('Y-m-d 00:00:01',strtotime($_GET['start']));
          $end = date('Y-m-d 23:59:59',strtotime($_GET['end']));
             $where .= "company_branch like'%" . $_GET['company_branch'] . "%' AND created_date BETWEEN '{$start}' AND '{$end}'";
              
        }elseif( !empty($_GET['start']) && !empty($_GET['end']) ){
            $start = date('Y-m-d 00:00:01',strtotime($_GET['start']));
            $end = date('Y-m-d 23:59:59',strtotime($_GET['end']));
            $where .= "created_date BETWEEN '{$start}' AND '{$end}'";
        }elseif(!empty($_GET['search']) ){
          $search_string = $_GET['search'];
            $where = "(inspection_report_master.machine_name like'%" . $_GET['search'] . "%' or inspection_report_master.id like'%" . $_GET['search'] . "%'  )";
        }else if(!empty($_GET['company_branch']) ){
          $search_string = $_GET['company_branch'];
         $where = "(inspection_report_master.company_branch like'%" . $_GET['company_branch'] . "%'  )";
        }  elseif (isset($_GET["ExportType"]) != '' && $_GET['start'] == '' && $_GET['end'] == '' ) {

            $where = "created_by_cid = $this->companyGroupId ";
         } 
         else{
               //$where=' MONTH(created_date)=MONTH(now())';
         	   $start_date = date('Y-m-d 00:00:01');
         	    //$start_dates = date("Y-m-d 00:00:00", strtotime ( '-2 day' , strtotime ( $start_date ) )) ;
         	   $end_date = date('Y-m-d 23:59:59');
              $where .= "created_date BETWEEN '{$start_date}' AND '{$end_date}' order by machine_id desc";
        }
            // $date = date('Y-m-d 00:00:00');
            // $start_date = date("Y-m-d 00:00:00", strtotime ( '-2 month' , strtotime ( $date ) )) ;
            // $end_date = $date;
            // $amazon_transaction  = $this->Ecommerce_model->get_data_transaction('amazon_transaction_report', array('posted_date >=' => $start_date, 'posted_date <=' => $end_date));
          

 
         //$this->data['Addall'] =$this->Quality_control_model->get_table_field_array('inspection_report_master',$where,$config["per_page"]);
         $this->data['Addall'] =$this->Quality_control_model->get_table_quality('inspection_report_master',$where);
   
          $machineData = [];
          if( $this->data['Addall'] ){
          		foreach ($this->data['Addall'] as $key => $value) {
	                if( !empty($value['machine_id'])){
	                   $machineData[$value['machine_id']][] = $value + ['machine_timestmp' => strtotime($value['created_date'])]; 
	             	}
            	}
          }
            
            // pre($machineData);  die;
            $this->data['AddMachine']=$machineData;

         
        	// $workorderabc= array();
         //    Get Shift And Plant Data 
         //   $allrecord=$this->data['newdata'];
         //   $process_id='';
         //   $Workorder='';
         //   foreach ($allrecord as $key=> $allvalue) {
         //   	$process_id=$allvalue['process_id'];
         //   	$Workorder=$allvalue['workorder_id'];

         //   	 $b = '"process_name":["'.$process_id;
         //     $a = '"work_order":["'.$Workorder;
         //     $where = "planning_data LIKE '%{$a}%' AND planning_data LIKE '%{$b}%'";
        
         //   $workorder  = $this->Quality_control_model->get_worker_data('production_planning',$where);
         //   $workorderabc = $workorder;
         //   $workorderabc[$key]['ida'] = $allvalue['id'];
         //   $workorderabc[$key]['created_dsate'] = $allvalue['created_date'];
         //   $workorderabc[$key]['created_byre'] = $allvalue['created_by'];
         // }  

       // $this->data['AddMachine']=$workorderabc;
       // pre($this->data['newdata']); die;
       $this->_render_template('day_line_wise_inspection/index', $this->data);
	}

	  public function viewMachaine()
        {
        $id = $this->input->post('id');
        $where = "`id`='{$id}' AND created_by_cid = $this->companyGroupId";
        $this->data['AddMachine'] =$this->Quality_control_model->get_table_field_array('inspection_report_master',$where,$config["per_page"]);

         $this->load->view('day_line_wise_inspection/view_machine', $this->data);
       }
         public function view_overview()
        {

        $id = $this->input->post('id');
        $result = $this->input->post('result'); 
        $valu='';
          if ($result==1) {
          	$valu='pass';
          }else if($result==2){
          	$valu='fail';
          }
           $where = "`report_id`='{$id}' AND `pf`= '{$valu}' ";
        $this->data['AddMachine'] =$this->Quality_control_model->get_table_field_array('inspection_report_trans',$where,$config["per_page"]);
         $this->load->view('day_line_wise_inspection/view_ovre', $this->data);
       }
}//main
