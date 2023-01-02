
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bid_management extends ERP_Controller {
    public function __construct() {
        parent::__construct();
        is_login();
        $this->load->library(array( 'form_validation'));
		$this->load->helper('bid_management/bid_management');
        $this->load->model('bid_management_model');
		$this->settings['css'][]= 'assets/plugins/google-code-prettify/bin/prettify.min.css';
		$this->settings['css'][] = 'assets/modules/bid_management/css/style.css';
		$this->scripts['js'][] = 'assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js';
		$this->scripts['js'][] = 'assets/plugins/jquery.hotkeys/jquery.hotkeys.js';
		$this->scripts['js'][] = 'assets/plugins/google-code-prettify/src/prettify.js';
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->scripts['js'][] = 'assets/plugins/switchery/dist/switchery.min.js';
		# for Graph
		$this->scripts['js'][] = 'assets/plugins/fastclick/lib/fastclick.js';
		$this->scripts['js'][] = 'assets/plugins/nprogress/nprogress.js';
		$this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
		$this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';		
		#for Print
		$this->scripts['js'][] = 'assets/modules/bid_management/js/print.js'; 
		#for wsywig editor
		$this->scripts['js'][] = 'assets/modules/bid_management/js/ckeditor/ckeditor.js'; 
		$this->scripts['js'][] = 'assets/modules/bid_management/js/ckeditor/ckeditor.js'; 
		$this->settings['css'][] = 'assets/modules/bid_management/css/zooming.css'; 
		$this->scripts['js'][] = 'assets/modules/bid_management/js/script.js';
        $this->load->library('CSVReader');//load PHPExcel library 
		//$this->load->model('upload_model');//To Upload file in a directory
               // $this->load->model('excel_data_insert_model');


        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

    }
	
    /* Main Function to fetch all the listing of leads */
    public function index(){ 			
			$this->register_opportunity();
    }
	
	# Main Function to fetch all the listing of leads in datatable 	
/*     public function register_opportunity(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_view'] = view_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();		
		$this->breadcrumb->add('Bid Managemnt', base_url() . 'Bid Management/dashboard');
		$this->breadcrumb->add('Register Opportunity', base_url() . 'Bid Management/register_opportunity');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Register Opportunity';
		$this->data['tender_status'] = $this->bid_management_model->get_data('tender_status');
		$this->data['tender_owner'] = $this->bid_management_model->get_data('user_detail',array("c_id"=>$this->companyGroupId));
		//pre($_POST);

		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' ) {
			
			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId);	

			$this->data['register_opportunity'] = $this->bid_management_model->get_own_tbl_data('leads', $inProcessWhere,'','tender_owner');
			//$this->_render_template('leads/index', $this->data);   
		
		}elseif(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) ){	
			
			$tender_status = array('register_opportunity.created_date >=' => $_POST['start'] , 'register_opportunity.created_date <=' => $_POST['end'], 'register_opportunity.created_by_cid' => $this->companyGroupId);
			
		}else{
			
			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId);
		}
	
		# if view permission is disabled than the user can see only his leads	
		if(!empty($this->data['permissions']) && $this->data['permissions']->is_view == 0){ 
			
		$this->data['register_opportunity'] = $this->bid_management_model->get_own_tbl_data('register_opportunity', $tender_status,'','tender_owner');

		
		}else if((!empty($this->data['permissions']) && $this->data['permissions']->is_view == 1) ||  ($_SESSION['loggedInUser']->role == 3 || $_SESSION['loggedInUser']->role == 1 ) ){	
			
			# if view permission is enabled than users can see leads of others also		
			$this->data['register_opportunity']  = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status);			
		}
		
		
		#pre($this->data['complete_leads']);
		
		if (isset($_POST['favourites']) ){
				
			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId ,'favourite_sts'=> 1);

			$this->data['register_opportunity'] = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status,'','tender_owner');

			
			$this->_render_template('register_opportunity/index', $this->data);
		}
		else{
		
		if(!empty($_POST)){
			$this->_render_template('register_opportunity/index', $this->data);
		}else{
			$this->_render_template('register_opportunity/index', $this->data);
		}

	}
		
    } */
	
		
	# Main Function to fetch all the listing of leads in datatable 	
    public function register_opportunity(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_view'] = view_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();	
		 $this->data['can_validate'] = validate_permissions();	
		$this->breadcrumb->add('Bid Managemnt', base_url() . 'Bid Management/dashboard');
		$this->breadcrumb->add('Register Opportunity', base_url() . 'Bid Management/register_opportunity');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Register Opportunity';
		$this->data['tender_status'] = $this->bid_management_model->get_data('tender_status');
		
		$this->data['tender_owner'] = $this->bid_management_model->get_data('user_detail',array("c_id"=>$this->companyGroupId));
		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' ) {

			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId);	
				$this->data['register_opportunity']  = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status);
		/**	$this->data['register_opportunity'] = $this->bid_management_model->get_own_tbl_data('register_opportunity', $tender_status,'','tender_owner');**/
		//echo	$this->data['register_opportunity'] = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status,'','tender_owner');die();
		}elseif(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) ){				
			$tender_status = array('register_opportunity.created_date >=' => $_POST['start'] , 'register_opportunity.created_date <=' => $_POST['end'], 'register_opportunity.created_by_cid' => $this->companyGroupId);			
		}else{			
			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId);
		}
		$this->data['register_opportunity']  = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status);
		$tender_status1= array('register_opportunity.created_by_cid' => $this->companyGroupId,'register_opportunity.approve'=>1);
		$this->data['register_opportunity1']  = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status1);	
		if (isset($_POST['favourites']) ){				
			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId ,'favourite_sts'=> 1);
			$this->data['register_opportunity'] = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status,'','tender_owner');
		}		
		$this->_render_template('register_opportunity/index', $this->data);	
    }
	
	
	
		# Function to load add/edit lead page 
	public function edit_register_opportunity(){
		if($this->input->post('id') != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}				
		$this->data['register_opportunity'] = $this->bid_management_model->get_data_byId('register_opportunity','id',$this->input->post('id'));
		$this->data['tenderstatus']  = $this->bid_management_model->get_data('tender_status');

		$whereAttachment = array('rel_id'=> $this->input->post('id'), 'rel_type'=> 'tender_docs');
		$this->data['attachments']  = $this->bid_management_model->get_attachmets_by_saleOrderId('attachments',$whereAttachment);
		
		$whereAttachment1 = array('rel_id'=> $this->input->post('id'), 'rel_type'=> 'tender_loa_docs');
		$this->data['attachments1']  = $this->bid_management_model->get_attachmets_by_saleOrderId('attachments',$whereAttachment1);
		
		$whereAttachment2 = array('rel_id'=> $this->input->post('id'), 'rel_type'=> 'tender_po_docs');
		$this->data['attachments2']  = $this->bid_management_model->get_attachmets_by_saleOrderId('attachments',$whereAttachment2);
		
		$this->data['agent'] = $this->bid_management_model->get_data('liasoning_agent');
		if($this->input->post('id') != ''){
			$where = array('lead_id'=> $this->input->post('id'));
			$lead_call_log = $this->bid_management_model->get_data('tender_activity',$where);
			$this->data['tender_activities'] = $lead_call_log;
		}
	//	$this->load->view('leads/edit', $this->data);
		$this->load->view('register_opportunity/edit_new', $this->data);
	}
	
	//Conersion Tender
	public function con_register_opportunity(){
		if($this->input->post('id') != '');
		$this->data['register_opportunity'] = $this->bid_management_model->get_data_byId('register_opportunity','id',$this->input->post('id'));
	//	$this->load->view('leads/edit', $this->data);
		$this->load->view('register_opportunity/conversion', $this->data);
	}
	//Rank
		public function rank_register_opportunity(){
		if($this->input->post('id') != '');
		$this->data['register_opportunity'] = $this->bid_management_model->get_data_byId('register_opportunity','id',$this->input->post('id'));
	//	$this->load->view('leads/edit', $this->data);
		$this->load->view('rank/edit', $this->data);
	}
	//save rank
	public function save_rank(){
		$id=$_POST['id'];
		$data  = $this->input->post();
		$this->bid_management_model->update_data_details('register_opportunity',$data, 'id', $id);	
		$this->session->set_flashdata('message', 'Rank Added Successfully');
		redirect(base_url().'bid_management/register_opportunity', 'refresh');
		}
	
	public function getCompProduct(){
	$id=$this->input->post('id');
	$account = $this->bid_management_model->get_data_byId('register_opportunity','id',$this->input->post('id'));
	    $tt = json_decode($account->product_detail);
            if (!empty($tt)) {
                $i = 0;
                $newProduct = array();
                foreach ($tt as $key) {
                    $pp = getNameById('material', $key->material_name_id, 'id');
                    $cc = getNameById('uom', $key->uom_material, 'id');
                    $key->material_name_id = $pp->id;
                    $key->description = $key->description;
                    $key->price = $key->price;
					 $key->material_name = $pp->material_name;
					 $key->qty = $key->qty;
                    $newProduct[$i] = $key;
                    $i++;
                }
                echo json_encode($newProduct);
	}
	}
	# Function to load view lead page
	public function view_register_opportunity(){
		if($this->input->post('id') != ''){
			permissions_redirect('is_view');
		}
		$whereAttachment = array('rel_id'=> $this->input->post('id'), 'rel_type'=> 'tender_docs');
		$this->data['attachments']  = $this->bid_management_model->get_attachmets_by_saleOrderId('attachments',$whereAttachment);
		
		$whereAttachment1 = array('rel_id'=> $this->input->post('id'), 'rel_type'=> 'tender_loa_docs');
		$this->data['attachments1']  = $this->bid_management_model->get_attachmets_by_saleOrderId('attachments',$whereAttachment1);
		
		$whereAttachment2 = array('rel_id'=> $this->input->post('id'), 'rel_type'=> 'tender_po_docs');
		$this->data['attachments2']  = $this->bid_management_model->get_attachmets_by_saleOrderId('attachments',$whereAttachment2);
		
		$this->data['register_opportunity'] = $this->bid_management_model->get_data_byId('register_opportunity','id',$this->input->post('id'));
		if($this->input->post('id') != ''){
			$where = array('lead_id'=> $this->input->post('id'));
			$lead_call_log = $this->bid_management_model->get_data('tender_activity',$where);
			$this->data['lead_activities'] = $lead_call_log;
		}
		$this->load->view('register_opportunity/view', $this->data);
	}
	
	
	public function save_competitor_result()
	{
		$id=$_POST['id'];
		 $data['result']=$_POST['result1'];
		 echo $attach=$_POST['attach'];
		 
		if($_FILES['attachment']['name']=='' && $attach!='')
		 {
			 $data['attachment']=$attach;
		 }
		  elseif($_FILES['attachment']['name']==''){
        $data['attachment']='';
		 }
		 else
            {
        $config['upload_path'] = './assets/modules/bid_management/uploads/'; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|txt|doc|pdf';
       $config['max_size'] = 10000;
       // $config['max_width'] = 1500;
       // $config['max_height'] = 1500;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('attachment')) 
		{
            $error = array('error' => $this->upload->display_errors());
            print_r($error);die();
        } 
		else 
		{ 
            $data1 = array('attachment' => $this->upload->data());
        }
		 $data['attachment']=$data1['attachment']['orig_name'];
			}
		if(!empty($_POST['account_id'])){
			$comp_details = count($_POST['account_id']);					
    if($comp_details >0){
            $arr1 =array();
            $i = 0;
			 while($i<$comp_details) {
			$comp_id=$_POST['account_id'][$i];
				// echo count($_POST['material_name'][$comp_id][$i]);
		$material_details = count($_POST['material_name'][$comp_id][$i]);
				if($material_details >0){
					 $arr = [];
                    $j = 0;
                    while ($j <=$material_details) {
				$jsonArrayObject = (array('material_name' => isset($_POST['material_name'][$comp_id][$j])?$_POST['material_name'][$comp_id][$j]:'', 'disc' => isset($_POST['disc'][$comp_id][$j])?$_POST['disc'][$comp_id][$j]:'', 'qty' =>isset($_POST['uom_value1'][$comp_id][$j])?$_POST['uom_value1'][$comp_id][$j]:'', 'price' => isset($_POST['price'][$comp_id][$j])?$_POST['price'][$comp_id][$j]:''));
                        $arr[$j] = $jsonArrayObject;
                        $j++;
                    }
                     $materialDetail_array = json_encode($arr);
                } else {
                    $materialDetail_array = '';
					}
				
				$jsonArrayObject1 = (array('account_id' =>isset($_POST['account_id'][$i])?$_POST['account_id'][$i]:'','result'=>isset($_POST['result'][$i])?$_POST['result'][$i]:'','comp_product'=>$materialDetail_array));
			 $arr1[$i] = $jsonArrayObject1;
               $i++;
			 }	
			
	        $compDetail_array = json_encode($arr1);
        }else{
            $compDetail_array = '';
        }
		
		 $data['bid_comp_price_info'] = $compDetail_array;
}
		
			//pre($data);die();
    $this->bid_management_model->update_data_details('register_opportunity',$data, 'id', $id);	
	$data['message'] = "Register Opportunity updated successfully";
	 redirect(base_url().'bid_management/register_opportunity', 'refresh');
   }
	
	#  Function to insert/update lead 
	public function save_register_opportunity(){	 
		
		if ($this->input->post()) {
			# required field server side validation 
			$required_fields = array('grandTotal');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				# If form is valid
				$data  = $this->input->post();
				$contacts = count($_POST['tender_name']);
				if($contacts >0){
					$arr =[];
					$i = 0;
					while($i < $contacts) {	
						$jsonArrayObject = array('tender_name' => $_POST['tender_name'][$i], 'department_name' => $_POST['department_name'][$i], 'tender_link' => $_POST['tender_link'][$i]);
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$contact_array = json_encode($arr);
				}else{
					$contact_array = '';
				}
				/*material detail save*/
				$countMaterial = count($_POST['material_name_id']);
				if($countMaterial >0){
					$materialarr =[];
					$k = 0;
					while($k < $countMaterial) {	
						$MaterialArrayObject = array('material_name_id' => isset($_POST['material_name_id'][$k])?$_POST['material_name_id'][$k]:'', 'description' =>isset($_POST['description'][$k])?$_POST['description'][$k]:'', 'uom_material'=>isset($_POST['uom_material'][$k])?$_POST['uom_material'][$k]:'','qty'=>isset($_POST['qty'][$k])?$_POST['qty'][$k]:'','price' =>isset($_POST['price'][$k])?$_POST['price'][$k]:'','gst' =>isset($_POST['gst'][$k])?$_POST['gst'][$k]:'','total' =>isset($_POST['totals'][$k])?$_POST['totals'][$k]:'','TotalWithGst' => isset($_POST['TotalWithGsts'][$k])?$_POST['TotalWithGsts'][$k]:'');
						$materialarr[$k] = $MaterialArrayObject;
						$k++;				
					}
					 $materialDetail_array = json_encode($materialarr);
				}else{
					$materialDetail_array = '';
				}

    if(isset($_POST['comp_status'])){          
 $data['comp_status'] = $_POST['comp_status'];
	}else{
		 $data['comp_status'] ='';
		}
				$data['totalwithoutgst'] = $_POST['total'];
				$data['grand_total'] = $_POST['grandTotal'];
				$data['tender_status'] = $_POST['tender_status'];
				$data['issue_date'] = $_POST['issue_date'];
				$data['clossing_date'] = $_POST['bidclossing_date'];
				$data['bid_id'] = $_POST['bid_id'];
				$data['bid_location'] = $_POST['bid_location'];
				$data['lpr_rate'] = $_POST['lpr_rate'];
				$data['created_by'] = $_SESSION['loggedInUser']->id;
				$data['created_by_cid'] = $this->companyGroupId;
				$data['created_date'] = date('y-m-d');
				$data['tender_detail'] = $contact_array;
				$data['product_detail'] = $materialDetail_array;
			//pre($data);die();
				//$data['tender_status'] =  $data['tender_status']?$data['tender_status']:1;
				$id = $data['id'];		//die();
				 $insert_id = $this->bid_management_model->get_last_id()+1;
				$usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 5));
					
					if(!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0]!=''){
							$attachment_array = array();
							 $certificateCount = count($_FILES['attachment']['name']);
							for($i = 0; $i <($certificateCount-1); $i++){
								$filename     = $_FILES['attachment']['name'][$i];
								$tmpname     = $_FILES['attachment']['tmp_name'][$i];               
								$type     = $_FILES['attachment']['type'][$i];               
								$error    = $_FILES['attachment']['error'][$i];
								$size    = $_FILES['attachment']['size'][$i];
								$exp=explode('.', $filename);
								$ext=end($exp);
								$newname=  $exp[0].'_'.time().".".$ext; 
								$config['upload_path'] = 'assets/modules/bid_management/uploads/';
								$config['upload_url'] =  base_url().'assets/modules/bid_management/uploads/';
							$config['allowed_types'] = "gif|jpg|jpeg|png|ico|pdf|xls|xlsx|doc";
								$config['max_size'] = '2000000'; 
								$config['file_name'] = $newname;
								$this->load->library('upload', $config);
								move_uploaded_file($tmpname,"assets/modules/bid_management/uploads/".$newname);				
								$attachment_array[$i]['rel_id'] = $insert_id;
								$attachment_array[$i]['rel_type'] = 'tender_docs';
								$attachment_array[$i]['file_name'] = $newname;
								$attachment_array[$i]['file_type'] = $type;
	//pre($attachment_array);						
	}
								if(!empty($attachment_array)){
									/* Insert file information into the database */
									$attachmentId = $this->bid_management_model->insert_attachment_data('attachments', $attachment_array,'bid_management/editSaleOrder/'.$data['id']);
								}
						}	
				//	die();		
					
				if($id && $id != ''){
					# Edit lead
					$data['edited_by'] = $_SESSION['loggedInUser']->id;
					
					$success = $this->bid_management_model->update_data('register_opportunity',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Register Opportunity updated successfully";
                        logActivity('Register Opportunity Updated','Register_Oppurtunity',$id);
						
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){					
								/*	pushNotification(array('subject'=> 'Lead updated' , 'message' => 'Lead updated : #'.$id.'is updated by '.$_SESSION['loggedInUser']->name,'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id,'class'=>'add_bid_management_tabs','data_id' => 'lead_view','icon'=>'fa fa-shekel'));*/
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							/*pushNotification(array('subject'=> 'Lead updated' , 'message' => 'Lead updated : #'.$id.'is updated by '.$_SESSION['loggedInUser']->name,'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id,'class'=>'add_bid_management_tabs','data_id' => 'lead_view','icon'=>'fa fa-shekel'));*/
				
						}
						
                        $this->session->set_flashdata('message', 'Register Opportunity Updated successfully');
					    redirect(base_url().'bid_management/register_opportunity', 'refresh');
                    }
				}else{
					# Insert lead
					#pre($data);
					if (isset($_POST['is_npdm'])) {
                        $data = $this->input->post();
                        $data['product_name'] = $_POST['product_name'];
                        $data['product_require'] = $_POST['product_require'];
                        $data['budget_assigned'] = $_POST['budget_assigned'];
                        $data['end_date'] = $_POST['end_date'];
                        $data['npdm_status'] = $_POST['npdm_status'];
                        $data['created_by'] = $_SESSION['loggedInUser']->id;
                        $data['created_by_cid'] = $this->companyGroupId;
                        $data['created_date'] = date('y-m-d');
                        $id = $data['id'];
                        $this->bid_management_model->insert_tbl_data('npdm', $data);
                    }
					//pre($data);
					$id = $this->bid_management_model->insert_tbl_data('register_opportunity',$data);	
                       # die;
							
					if ($id) {                        
                        logActivity('New Register Opportunity Created','Register_Oppurtunity',$id);
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){					
								/*	pushNotification(array('subject'=> 'Lead created' , 'message' => 'New Lead is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_bid_management_tabs','data_id' => 'lead_view' ,'icon'=>'fa fa-shekel'));*/
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
						/*	pushNotification(array('subject'=> 'Lead created' , 'message' => 'New Lead is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id ,'class'=>'add_bid_management_tabs','data_id' => 'lead_view' ,'icon'=>'fa fa-shekel'));*/
				
						}
                        $this->session->set_flashdata('message', 'Register Opportunity inserted successfully');

                 
					
						
                        #die;
					    redirect(base_url().'bid_management/register_opportunity','refresh');
                       				
				}
			}			
        }
	}
	
}


public function change_tender_status(){
		$status_data = $this->bid_management_model->change_lead_status($_POST['id'], $_POST['status'], $_POST['status_comment']);
        logActivity('Tender Status Changed','lead',$_POST['id']);
		$usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 5));
			
		if(!empty($usersWithViewPermissions)){
			foreach($usersWithViewPermissions as $userViewPermission){
				if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){					
					/*pushNotification(array('subject'=> 'Lead status changed' , 'message' => 'Lead status changed by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$_POST['id'].'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $_POST['id'] , 'class'=>'add_bid_management_tabs','data_id' => 'lead_view','icon'=>'fa fa-shekel'));*/
				}
			}
		}	
		if($_SESSION['loggedInUser']->role !=1){
		/*	pushNotification(array('subject'=> 'Lead status changed' , 'message' => 'Lead status changed by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id, 'class'=>'add_bid_management_tabs','data_id' => 'lead_view','icon'=>'fa fa-shekel'));		*/		
		}
        $result = array('msg' => 'Tender Status Changed', 'status' => 'success', 'code' => 'C221','url' => base_url().'bid_management/register_opportunity/');
        echo json_encode($result);
	}

/* approve by selected */
public function approve_bid_by_selection(){
	       if ($_POST['nameAttributeId'] && $_POST['nameAttributeId'] != '') {
            $id = $this->input->get_post('id');
            $approve = $this->input->get_post('approve');
            $validated_by = $this->input->get_post('validated_by');
            $disapprove_reason = "";
            $disapprove = "0";
            $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
            foreach ($id as $key) {
                $data = array('id' => $key, 'approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0);
                $result = $this->bid_management_model->approvebiddata($data);
                logActivity('Purchase indent approved', 'purchase_indent', $key);
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Purchase indent approved', 'message' => 'Register Opportunity is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_bid_mng_tabs', 'data_id' => 'register_opportunity_view', 'icon' => 'fa-shopping-cart'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Register Opportunity approved', 'message' => 'Register Opportunity is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $id, 'class' => 'add_bid_mng_tabs', 'data_id' => 'register_opportunity_view', 'icon' => 'fa-shopping-cart'));
                }
            }
            if ($result) {
                logActivity('Register Opportunity approved', 'register_opportunity', $key);
                $this->session->set_flashdata('message', 'Register Opportunity approved');
                $result = array('msg' => 'Register Opportunity approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'bid_management/register_opportunity');
                 json_encode($result);
              //  die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
}
 /*approve indent*/
    public function approve_bid() {
        if ($_POST['id'] && $_POST['id'] != '') {
            $data = array('approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0);
            $result = $this->bid_management_model->approvebiddata($_POST);
            if ($result) {
                logActivity('Register Opportunity approved', 'register_opportunity', $_POST['id']);
                $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                if (!empty($usersWithViewPermissions)) {
                    foreach ($usersWithViewPermissions as $userViewPermission) {
                        if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                            pushNotification(array('subject' => 'Register Opportunity approved', 'message' => 'Register Opportunity id :# ' . $_POST["id"] . ' is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $_POST['id'], 'class' => 'add_bid_mng_tabs', 'data_id' => 'register_opportunity_view', 'icon' => 'fa-shopping-cart'));
                        }
                    }
                }
                if ($_SESSION['loggedInUser']->role != 1) {
                    pushNotification(array('subject' => 'Register Opportunity approved', 'message' => 'Register Opportunity id :# ' . $_POST["id"] . ' is approved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $_POST['id'], 'class' => 'add_bid_mng_tabs', 'data_id' => 'register_opportunity_view', 'icon' => 'fa-shopping-cart'));
                }
                $this->session->set_flashdata('message', 'Register Opportunity approved');
                $result = array('msg' => 'Register Opportunity approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'bid_management/register_opportunity');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
    /*disarppove indent*/
    public function disApprove_bid() {
        if ($this->input->post()) {
            $required_fields = array('disapprove_reason');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $idss1 = $_POST['id'];
                $id = explode(",", $idss1);
                $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                foreach ($id as $key) {
             $data = array('id' => $key, 'validated_by' => $_POST['validated_by'], 'disapprove' => $_POST['disapprove'], 'approve' => $_POST['approve'], 'disapprove_reason' => $_POST['disapprove_reason']);
                    $success = $this->bid_management_model->disApprovedata($data);
                    logActivity('Opportunity Disapproved', 'register_opportunity', $key);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'Purchase opportunity disapproved', 'message' => 'Register Opportunity id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $key, 'class' => 'add_bid_mng_tabs', 'data_id' => 'register_opportunity_view', 'icon' => 'fa-shopping-cart'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'Register opportunity disapproved', 'message' => 'Register Opportunity id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $key, 'class' => 'add_bid_mng_tabs', 'data_id' => 'register_opportunity_view', 'icon' => 'fa-shopping-cart'));
                    }
                }
                if ($success) {
            $data['message'] = "Register Opportunity Disapproved";
            $this->session->set_flashdata('message', 'Register Opportunity Disapproved successfully');
            redirect(base_url() . 'bid_management/register_opportunity', 'refresh');
                }
            }
        }
    }


	/*delete Lead */
	public function delete_register_opportunity($id = ''){	
		if (!$id) {
           redirect('bid_management/register_opportunity', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->bid_management_model->delete_data('register_opportunity','id',$id);
		if($result){
			logActivity('Tender Records Deleted','leads',$id);
			$usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 5));
			
			if(!empty($usersWithViewPermissions)){
				foreach($usersWithViewPermissions as $userViewPermission){
					if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){					
						
						pushNotification(array('subject'=> 'Tender Record deleted' , 'message' => 'Tender id : # '.$id.' is deleted by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id,'icon'=>'fa fa-shekel'));
					}
				}
			}	
			if($_SESSION['loggedInUser']->role !=1){
				pushNotification(array('subject'=> 'Tender deleted' , 'message' => 'Lead id : # '.$id.' is deleted by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id,'icon'=>'fa fa-shekel'));			
			}
			
			$this->session->set_flashdata('message', 'Tender Deleted Successfully');
			$result = array('msg' => 'Tender Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'bid_management/register_opportunity');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}

	
	
	/*  Function to add/update Lead activity */
	public function save_register_opportunity_Activity(){		
		if ($this->input->post()) {
			$required_fields = array('subject','comment');		
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();
				$data['created_by'] = $_SESSION['loggedInUser']->id;
				$data['created_by_cid'] = $this->companyGroupId;
				$id = $this->bid_management_model->insert_tbl_data('tender_activity',$data);	
				
				
				
				if ($id) {  
					if($data['activity_type']!='New task'){
						change_new_task_status('tender_activity','lead_id',$data['lead_id']);
					}				
					if(!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0]!=''){
							$attachment_array = array();
							$certificateCount = count($_FILES['attachment']['name']);
							for($i = 0; $i < $certificateCount; $i++){
								$filename     = $_FILES['attachment']['name'][$i];
								$tmpname     = $_FILES['attachment']['tmp_name'][$i];               
								$type     = $_FILES['attachment']['type'][$i];               
								$error    = $_FILES['attachment']['error'][$i];
								$size    = $_FILES['attachment']['size'][$i];
								$exp=explode('.', $filename);
								$ext=end($exp);
								$newname=  $exp[0].'_'.time().".".$ext; 
								$config['upload_path'] = 'assets/modules/bid_management/uploads/';
								$config['upload_url'] =  base_url().'assets/modules/bid_management/uploads/';
								$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
								$config['max_size'] = '2000000'; 
								$config['file_name'] = $newname;
								$this->load->library('upload', $config);
								move_uploaded_file($tmpname,"assets/modules/bid_management/uploads/".$newname);				
								$attachment_array[$i]['rel_id'] = $id;
								$attachment_array[$i]['rel_type'] = 'lead_activity';
								$attachment_array[$i]['file_name'] = $newname;
								$attachment_array[$i]['file_type'] = $type;
							}
							if(!empty($attachment_array)){
								/* Insert file information into the database */
								$attachmentId = $this->bid_management_model->insert_attachment_data('attachments', $attachment_array,'bid_management/edit_lead/'.$data['lead_id']);
							}
						}
					logActivity('New Tender call log created','lead call log',$id);					
					$usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 5));			
					if(!empty($usersWithViewPermissions)){
						foreach($usersWithViewPermissions as $userViewPermission){
							if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){					
							
								
							}
						}
					}	
					if($_SESSION['loggedInUser']->role !=1){
						//pushNotification(array('subject'=> 'Lead activity done' , 'message' => 'Lead activity done by '.$_SESSION['loggedInUser']->name'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id ,'class'=>'add_purchase_tabs','data_id' => 'lead_view','icon'=>'fa fa-shekel'));				
					}					
					$this->session->set_flashdata('message', 'Tender call log inserted successfully');
					redirect(base_url().'bid_management/register_opportunity', 'refresh');
				}   
			}			
        }
	}
	
	# Function to delete  attachments 
	public function deleteAttachment($id = ''){
		if (!$id) {
           redirect('bid_management/register_opportunity', 'refresh');
        }
        $result = $this->bid_management_model->delete_data('attachments','id',$id);
		if($result) {
			logActivity('Attachment Deleted','register_opportunity',$id);
			$msg = 'Attachment Deleted Successfully';
			$this->session->set_flashdata('message', $msg);
			$result = array('msg' => $msg, 'status' => 'success', 'code' => 'C174','url' => base_url() . 'bid_management/register_opportunity');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
	}


	public function getMaterialDataById(){
		if($_POST['id'] !=''){
			$material = $this->bid_management_model->get_data_byId('material','id',$_POST['id']);
			$ww = getNameById('uom',$material->uom,'id');			
			$material->uom = $ww->ugc_code;

			$material->uomid = $ww->id;

			//pre($material);
			echo json_encode($material);
		}
	}
	
		# Main Function to load dashboard	
    public function dashboard(){
		if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
			redirect( base_url().'bid_management/leads/', 'refresh');
		}

		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Bid Management', base_url() . 'dashboard');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Dashboard';
		$getPermissions = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>5,'permissions.is_view'=>1));
		$this->data['contactGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['accountGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['saleOrderGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;	
		$limit = 10;
		$where = array('register_opportunity.created_by_cid' => $this->companyGroupId);
		if($this->data['permissions']->is_view == 0){
			$this->data['leads'] = $this->bid_management_model->get_own_tbl_data('register_opportunity',$where,$limit,'tender_owner');
		}else{
			$this->data['leads']  = $this->bid_management_model->get_tbl_data('register_opportunity',$where,$limit);	
		}	


		
		$this->data['user_dashboard']  = $this->bid_management_model->get_data('user_dashboard',array('user_id' => $_SESSION['loggedInUser']->id));
		#pre($this->data['user_dashboard']);
		$this->_render_template('dashboard/index', $this->data);
    }

	
	/* Function to fetch all the CRM dashboard data with or without month-year range */
	public function graphDashboardData(){
		if(!empty($_POST)) {
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
		}else{
			$startDate =  $endDate = '' ;
		}
		
		$getPermissions = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>5,'permissions.is_view'=>1));
		$this->data['contactGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['accountGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['saleOrderGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;	
		
		$graphDashboardArray=array();
		if((!empty($getPermissions) &&  $_SESSION['loggedInUser']->role == 2) || $_SESSION['loggedInUser']->role == 1){
			$monthLeadStatusGraph = monthLeadStatusGraph($startDate, $endDate);
			$monthLeadTargetGraph = monthLeadTargetGraph($startDate, $endDate);
			$monthSaleOrderGraph = monthSaleOrderGraph($startDate, $endDate);
			$getLeadStatusGraph = getLeadStatusGraph($startDate, $endDate);
			$getWinLeadVsTotalGraph = getWinLeadVsTotalGraph($startDate, $endDate);
			$getDashboardCount = getDashboardCount($startDate, $endDate);
			$recentActivitiesDashboardData = recentActivitiesDashboardData($startDate, $endDate);
			$getCrmTableData = getCrmTableData($startDate, $endDate);
		}
		$graphDashboardArray = array('monthLeadStatusGraph' => $monthLeadStatusGraph , 'monthLeadTargetGraph' => $monthLeadTargetGraph,'monthSaleOrderGraph' => $monthSaleOrderGraph,'getLeadStatusGraph'=> $getLeadStatusGraph,'getWinLeadVsTotalGraph'=>$getWinLeadVsTotalGraph,'getDashboardCount'=>$getDashboardCount,'leadActivity'=> $recentActivitiesDashboardData['leadActivity'],'accountActivity'=> $recentActivitiesDashboardData['accountActivity'], 'saleOrderActivity'=> $recentActivitiesDashboardData['saleOrderActivity'],'getCrmTableData'=>$getCrmTableData);
		echo json_encode($graphDashboardArray);


		//pre($graphDashboardArray);
	}
	
	public function showDashboardOnRequirement(){
		$data = $_POST;
		$data['user_id'] = $_SESSION['loggedInUser']->id;
		$userDashboardRes = $this->bid_management_model->get_data('user_dashboard',array('user_id'=> $_SESSION['loggedInUser']->id , 'graph_id' => $data['graph_id']));	
		if(!empty($userDashboardRes)){
			$id = $this->bid_management_model->update_data('user_dashboard',$data,'id',$userDashboardRes[0]['id']);	
		}else{
			$id = $this->bid_management_model->insert_tbl_data('user_dashboard',$data);
		}	
		if($id){
			$result = array('msg' => 'Data for user set', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'bid_management/dsahbaord');    
			echo json_encode($result);
			die;	
		}		
	}
	/* Controller for quick Add*/

// for select all delete			
public function deleteall(){           
			$tablename = $this->input->get_post('tablename');
			$checkValues = $this->input->get_post('checkValues');
			$datamsg = $this->input->get_post('datamsg');
			$ai = $this->input->get_post('ai');
			$str = implode(',', $ai);
			foreach ($checkValues as $key) {
           		$this->bid_management_model->delete_data($tablename,'id',$key);
            	 	logActivity($datamsg.' Deleted',$tablename,$key);
            	 	echo $str;
            	 	ComplogActivity($str,$datamsg.' Deleted',$datamsg,$key);
			}
			$this->session->set_flashdata('message', $datamsg.' Deleted Successfully');
			// redirect(base_url().'bid_management/leads', 'refresh');
        }
        
	public function markfavourite(){
					$id = $this->input->get_post('checkValues');
					$tablename =  $this->input->get_post('tablename');
					$favourite = $this->input->get_post('favourite');
					$datamsg = $this->input->get_post('datamsg');
					$data  = $favourite;
					$result = $this->bid_management_model->markfavour($tablename,$data,$id);	
			if($result == true){
				foreach($id as $ky){
					logActivity($datamsg.' Records marked favourite',$tablename,$ky);
				}
				$this->session->set_flashdata('message', $datamsg.' Favourites');
				$result = array('msg' => 'Sale order approved', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'bid_management/sale_orders');    
				echo json_encode($result);				
			}else {
				echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
			}
	}



	// For PipeLine Module Start//
	public function changeProcessType() {
		$data = $this->input->post();
		$id=$data['processId'];
		$process_status = $this->bid_management_model->change_process_status($data,$id);
		
		$usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 5));			
		if(!empty($usersWithViewPermissions)){
			foreach($usersWithViewPermissions as $userViewPermission){
				if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){					
					pushNotification(array('subject'=> 'Tender status updated' , 'message' => 'Tender status updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'to status'=>$data['processTypeId'] , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));
				}
			}
		}	
		if($_SESSION['loggedInUser']->role !=1){
			pushNotification(array('subject'=> 'Tender status updated' , 'message' => 'Tender status updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'to status'=>$data['processTypeId'] , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));			
		}			
		$this->_render_template('pipe_line/index', $process_status);	
    }

    public function changeOrder(){
		$orders = $_POST['order'];
		//pre($orders);
		$process_order = $this->bid_management_model->change_process_order($orders);
		echo json_encode(array('msg' => 'error', 'status' => 'success', 'code' => 'C774'));		
	}
		
	public function pipeline(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Bid Management', base_url() . 'bid_management/dashboard');
		$this->breadcrumb->add('Pipe Line', base_url() . 'bid_management/pipeline');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Pipeline';
		$where = array('c_id' => $this->companyGroupId);
		$this->data['user1']= $this->bid_management_model->get_data('user_detail',$where);
		if(isset($_POST['user_id'])){
			$array = [];
			//$where = array('created_by_cid' => $this->companyGroupId);
			$this->data['processType']= $this->bid_management_model->get_data('tender_status');
			$i=0;
			foreach($this->data['processType'] as $ProcessType){
				$where = array('tender_status'=> $ProcessType['id'] ,'save_status'=>1, 'created_by' => $_POST['user_id']);
				$process = $this->bid_management_model->get_data('register_opportunity',$where);	
				$array[$i]['types'] = $ProcessType;
				$array[$i]['process'] = $process;
				$i++;	
			}
			$this->data['processdata'] = $array;		
			$this->_render_template('pipe_line/index',$this->data);

		}else{
				$array = [];
			//	$where = array('created_by_cid' => $this->companyGroupId);
				$this->data['processType']= $this->bid_management_model->get_data('tender_status');
				$i=0;
				foreach($this->data['processType'] as $ProcessType){
					$where = array('tender_status'=> $ProcessType['id'],'save_status'=>1,'created_by_cid' => $this->companyGroupId);
					$process = $this->bid_management_model->get_data('register_opportunity',$where);	
					$array[$i]['types'] = $ProcessType;
					$array[$i]['process'] = $process;
					$i++;	
				}
				$this->data['processdata'] = $array;		
				$this->_render_template('pipe_line/index',$this->data);

		 }



	}
		//liasoning agent
		public function lisoning_agent(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_view'] = view_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();		
		$this->breadcrumb->add('Bid Managemnt', base_url() . 'Bid Management/dashboard');
		$this->breadcrumb->add('Liasoning Agent', base_url() . 'Bid Management/liasoning_agent');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Liasoning Agent';
		$this->data['agent_data'] = $this->bid_management_model->get_data('liasoning_agent');
		$this->_render_template('liasoning_agent/index',$this->data);
		}
		
		public function edit_liasoning_agent(){
		if($this->input->post('id') != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}		
		if($this->input->post('id') != ''){		
		$this->data['agent'] = $this->bid_management_model->get_data_byId('liasoning_agent','id',$this->input->post('id'));
		}
		$this->load->view('liasoning_agent/edit',$this->data);
		}


		public function liasoning_agent_view(){
		if($this->input->post('id') != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}		
		if($this->input->post('id') != ''){		
		$this->data['agent'] = $this->bid_management_model->get_data_byId('liasoning_agent','id',$this->input->post('id'));
		}
		$this->load->view('liasoning_agent/view',$this->data);
		}

		
		public function save_liasoning_agent(){
		$data=$this->input->post();
		#$data['agreement_upload']=$this->input->post('agreement_upload');
		//print_r($data);
		$data['created_by_cid']=$this->companyGroupId;
		$id=$this->input->post('id');
		$upload=$this->input->post('upload');
		//echo $this->input->post('agreement_upload');
		if($upload!=''){
        $data['agreement_upload']=$upload;
		 }
		if($_FILES['agreement_upload']['name']==''){
			$data['agreement_upload']=$upload;
       // $data['agreement_upload']='';
		 }else
            {
        $config['upload_path'] = './assets/modules/bid_management/uploads/'; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|txt|doc|pdf';
       $config['max_size'] = 10000;
       // $config['max_width'] = 1500;
       // $config['max_height'] = 1500;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('agreement_upload')) 
		{
            $error = array('error' => $this->upload->display_errors());
            print_r($error);die();
        } 
		else 
		{ 
            $data1 = array('agreement_upload' => $this->upload->data());
        }
		 $data['agreement_upload']=$data1['agreement_upload']['orig_name'];
			}
			//print_r($data);die();
			if($id!='')
			{
				$this->bid_management_model->update_data('liasoning_agent',$data,'id',$id);	
			$this->session->set_flashdata('message', 'Agent Updated successfully');
			}
			else
			{
			$this->bid_management_model->insert_tbl_data('liasoning_agent',$data);	
			$this->session->set_flashdata('message', 'Agent Added successfully');
			}
			redirect(base_url().'bid_management/lisoning_agent', 'refresh');
		}
		
		public function delete_liasoning_agent(){
			$id=$this->uri->segment('3');
			if($id=='')
			{
				redirect(base_url().'bid_management/lisoning_agent', 'refresh');
			}
			$this->bid_management_model->delete_data('liasoning_agent','id',$id);
			$this->session->set_flashdata('message', ' Deleted Successfully');
			redirect(base_url().'bid_management/lisoning_agent', 'refresh');
		}
		public function liasoning_report(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_view'] = view_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();		
		$this->breadcrumb->add('Bid Managemnt', base_url() . 'Bid Management/dashboard');
		$this->breadcrumb->add('Liasoning Report', base_url() . 'Bid Management/liasoning_report');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Liasoning Report';
		$agent_id=$this->input->post('agent_id');
		$where='';
		if($agent_id!=''){
			$where='liasoning_agent.id="'.$agent_id.'"';
		$this->data['agent'] = $this->bid_management_model->get_multiple_data('liasoning_agent',$where);	
		}
		else{
		$this->data['agent'] = $this->bid_management_model->get_multiple_data('liasoning_agent',$where='');	
		}
			$this->_render_template('liasoning_report/index',$this->data);
		}
		public function meeting_schedule(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_view'] = view_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();		
		$this->breadcrumb->add('Bid Managemnt', base_url() . 'Bid Management/dashboard');
		$this->breadcrumb->add('Meeting Schedule', base_url() . 'Bid Management/meeting_schedule');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Meeting Schedule';
		$this->data['meeting'] = $this->bid_management_model->get_data('meeting_scheduling',array('status'=>'0'));
		$this->data['meeting_done'] = $this->bid_management_model->get_data('meeting_scheduling',array('status'=>'1'));
		$this->_render_template('meeting/index',$this->data);	
		}
		
		public function edit_meeting(){
			if($this->input->post('id') != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}		
		if($this->input->post('id') != ''){		
		$this->data['meeting'] = $this->bid_management_model->get_data_byId('meeting_scheduling','id',$this->input->post('id'));
		}
		$this->load->view('meeting/edit',$this->data);
		}
		public function view_meeting_schedule(){		
		if($this->input->post('id') != ''){		
		$this->data['meeting'] = $this->bid_management_model->get_data_byId('meeting_scheduling','id',$this->input->post('id'));
		}
		$this->load->view('meeting/view1',$this->data);
		}
		
		public function view_meeting(){
			$id=$this->input->post('id');
			$this->data['meeting'] = $this->bid_management_model->get_data_byId('meeting_scheduling','id',$this->input->post('id'));
			$this->load->view('meeting/view',$this->data);
		}
		public function cancel_meeting(){	
		$id=$this->input->post('id');	
		$this->data['meeting'] = $this->bid_management_model->get_data_byId('meeting_scheduling','id',$this->input->post('id'));
		$this->load->view('meeting/cancel',$this->data);
		}
		public function save_cancel_meeting_detail()
		{
		$id=$this->input->post('id');	
		$data=array('cancel_reason'=>$this->input->post('cancel_reason'));	
		$this->bid_management_model->update_data_details('meeting_scheduling',$data,'id',$id);	
		
		$this->session->set_flashdata('message', 'Meeting Cancelled successfully');
		redirect(base_url().'bid_management/meeting_schedule');
		}
		public function detail_meeting(){		
		if($this->input->post('id') != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}		
		if($this->input->post('id') != ''){		
		$this->data['meeting'] = $this->bid_management_model->get_data_byId('meeting_scheduling','id',$this->input->post('id'));
		}
		$this->load->view('meeting/detail',$this->data);
		}
		
		public function save_meeting(){
		$data=$this->input->post();
		$data['created_by_cid']=$this->companyGroupId;
		$id=$this->input->post('id');	
		if($_FILES['attachment']['name']==''){
        $data['attachment']='';
		 }else
            {
        $config['upload_path'] = './assets/modules/bid_management/uploads/'; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|txt|doc|pdf|xml';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('attachment')) 
		{
            $error = array('error' => $this->upload->display_errors());
            print_r($error);die();
        } 
		else 
		{ 
            $data1 = array('attachment' => $this->upload->data());
        }
		 $data['attachment']=$data1['attachment']['orig_name'];
			}
			//print_r($data);die();
			if($id!='')
			{
				$this->bid_management_model->update_data('meeting_scheduling',$data,'id',$id);	
			$this->session->set_flashdata('message', 'Meeting Updated successfully');
			}
			else
			{
			$this->bid_management_model->insert_tbl_data('meeting_scheduling',$data);	
			$this->session->set_flashdata('message', 'Meeting Added successfully');
			}
			redirect(base_url().'bid_management/meeting_schedule', 'refresh');
		}
		
		public function save_meeting_detail(){
		$id=$this->input->post('id');	
			if($id!='')
			{
		$data['message_detail']=$this->input->post('message_detail');
		$data['status']=$this->input->post('status');
			if($_FILES['message_attachment']['name']==''){
        $data['message_attachment']='';
		 }else
            {
        $config['upload_path'] = './assets/modules/bid_management/uploads/'; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|txt|doc';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('message_attachment')) 
		{
            $error = array('error' => $this->upload->display_errors());
            print_r($error);die();
        } 
		else 
		{ 
            $data1 = array('message_attachment' => $this->upload->data());
        }
		 $data['message_attachment']=$data1['message_attachment']['orig_name'];
			}
			//print_r($data);die();
		$this->bid_management_model->update_data_details('meeting_scheduling',$data,'id',$id);	
			$this->session->set_flashdata('message', 'Meeting Updated successfully');
			}
			redirect(base_url().'bid_management/meeting_schedule', 'refresh');
		}
		//Competitor Analysis
		public function competitor_details(){	
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
	$this->breadcrumb->add('Bid Managemnt', base_url() . 'bid_management/dashboard');
		$this->breadcrumb->add('Competitor Details', base_url() . 'bid_management/competitor_analysis');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Competitor Details';
		$this->data['search_string'] = '';	
		/*$search_string = $this->input->post('search');
		$likeArray = array(	'account.name' => $search_string,
							'account.phone' => $search_string);	*/	
							//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2=" bid_competitor_details.id like '%".$search_string."%' or bid_competitor_details.name like '%".$search_string."%'";
		}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
			
		}else{
			$order="desc";
		}
		if (isset($_POST['favourites'])){
			$where = array('bid_competitor_details.favourite_sts'=> 1 ,'bid_competitor_details.account_owner'=> $this->companyGroupId);	
		}else{
			if(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) && !isset($_POST['ExportType'])){		
			$where = array('bid_competitor_details.created_date >=' => $_POST['start'] , 'bid_competitor_details.created_date <=' => $_POST['end'],'bid_competitor_details.account_owner'=> $this->companyGroupId);	
			}elseif(!empty($_POST)  &&  (isset($_POST['account_name']) && $_POST['account_name'] !='')){		
				$where = "account_owner = ".$this->companyGroupId." AND  created_by =".$_POST['account_name'];
			}elseif(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' &&  $_POST['account_name'] == '' ){			
				$where = array('bid_competitor_details.account_owner'=> $this->companyGroupId);	
			}else{	
				$where = array('account_owner'=> $this->companyGroupId);		
			}			
		}			
	/*	if($this->data['permissions']->is_view == 0){ 
			$countRows = $this->bid_management_model->num_rows('account', $where,$search_string,'contact_owner',$likeArray);
		}else{	
			# if view permission is enabled than users can see leads of others also		
			$countRows = $this->bid_management_model->num_rows('account', $where,$search_string,'',$likeArray);
		}	*/
			$config = array();
			$config["base_url"] = base_url() . "bid_management/bid_competitor_details/";
			$config["total_rows"] = $this->bid_management_model->num_rows('bid_competitor_details', $where,$where2);
		$config["per_page"] = 10;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = true;
			$config["use_page_numbers"] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul><!--pagination-->';
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev page">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = 'Next &rarr;';
			$config['next_tag_open'] = '<li class="next page">';
			$config['next_tag_close'] = '</li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&larr; Previous';
			$config['prev_tag_open'] = '<li class="prev page">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
			$config['anchor_class'] = 'follow_link';
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;			
		if($this->data['permissions']->is_view == 0){ 
			$this->data['competitor_details'] = $this->bid_management_model->get_data_listing('bid_competitor_details', $where, $config["per_page"], $page,$where2,$order);
		}else{	
			# if view permission is enabled than users can see leads of others also		
			$this->data['competitor_details']  = $this->bid_management_model->get_data_listing('bid_competitor_details',$where, $config["per_page"], $page,$where2,$order);	
		}	
		
	$this->_render_template('competitor_details/index', $this->data);	
	}

	public function competitor_details_edit(){
		if($this->input->post('id') != ''){
			permissions_redirect('is_edit');
		}else{
			permissions_redirect('is_add');
		}
		$this->data['users']  = $this->bid_management_model->get_data('user_detail');
		$this->data['account'] = $this->bid_management_model->get_data_byId('bid_competitor_details','id',$this->input->post('id'));
		#pre($this->data['account']);
		$this->load->view('competitor_details/edit', $this->data);	
	}
	public function competitor_details_view(){
		$this->data['users']  = $this->bid_management_model->get_data('user_detail');
		$this->data['account'] = $this->bid_management_model->get_data_byId('bid_competitor_details','id',$this->input->post('id'));
		#pre($this->data['account']);
		$this->load->view('competitor_details/view', $this->data);	
	}
		/*  Function to save/update Account */
	public function save_competitor_details(){	 
	#pre($_POST); 
		if ($this->input->post()) {
			$required_fields = array('phone');		
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{

				$material_details = count($_POST['material_name']);
				if($material_details >0){
					$arr = [];
					$j = 0;
					while($j < $material_details) {	
						$jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$j], 'material_name_id' => $_POST['material_name'][$j], 'disc' => $_POST['disc'][$j] ,'unit' => $_POST['uom_value'][$j],'price' => $_POST['price'][$j]));				
						$arr[$j] = $jsonArrayObject;
						$j++;				
					}
					$materialDetail_array = json_encode($arr);
				}else{
					$materialDetail_array = '';
				}	



				$data  = $this->input->post();	
				$data['account_owner'] = $this->companyGroupId;
				$id  =	$data['id'];	
				$data['product_detail'] = $materialDetail_array;
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $this->companyGroupId;
				$usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 6));	
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->bid_management_model->update_data('bid_competitor_details',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Competitor Details updated successfully";
                        logActivity('Competitor Details Updated','bid_competitor_details',$id);		
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){					
									/*pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/


									pushNotification(array('subject'=> 'Competitor Details updated' , 'message' => 'Competitor Details updated : #'.$id.'is updated by '.$_SESSION['loggedInUser']->name,'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id,'class'=>'add_bid_management_tabs','data_id' => 'competitor_details_view','icon'=>'fa fa-shekel'));


								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
						/*	pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));	*/


							pushNotification(array('subject'=> 'Competitor Details updated' , 'message' => 'Competitor Details updated : #'.$id.'is updated by '.$_SESSION['loggedInUser']->name,'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' =>  $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id,'class'=>'add_bid_management_tabs','data_id' => 'bid_competitor_details_view','icon'=>'fa fa-shekel'));


			
						}		
                        $this->session->set_flashdata('message', 'Competitor Details updatedsuccessfully');
					    redirect(base_url().'bid_management/competitor_details', 'refresh');
                    }
				}else{
					$data['created_by'] = $_SESSION['loggedInUser']->u_id;
					 $id = $this->bid_management_model->insert_tbl_data('bid_competitor_details',$data);							
					if ($id) {                        
                        logActivity('New Competitor Details Created','bid_competitor_details',$id);
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){					
									/*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/



									pushNotification(array('subject'=> 'Competitor Details created' , 'message' => 'New Competitor Details is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_bid_management_tabs','data_id' => 'competitor_details_view' ,'icon'=>'fa fa-shekel'));

								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							/*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/

								pushNotification(array('subject'=> 'Competitor Details created' , 'message' => 'New Competitor Details is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' =>  $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id ,'class'=>'add_bid_management_tabs','data_id' => 'bid_competitor_details_view' ,'icon'=>'fa fa-shekel'));


						}		
                        $this->session->set_flashdata('message', 'New Competitor Details inserted successfully');
					     redirect(base_url().'bid_management/competitor_details', 'refresh');
                    }    				
				}
			}			
        }
	}
	public function viewAccount(){
		if($this->input->post('id') != ''){
			permissions_redirect('is_view');
		}		
		$this->data['users']  = $this->bid_management_model->get_data('user_detail');
		$this->data['account'] = $this->bid_management_model->get_data_byId('account','id',$this->input->post('id'));
		$this->load->view('accounts/view', $this->data);
	}
	  /* Add Price */
    public function add_price_compt() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Bid Management', base_url() . 'bid_management/dashboard');
        $this->breadcrumb->add('Add Price (Competitor)', base_url() . 'bid_management/add_price_compt');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Add Price (Competitor)';
        $where = 'AND bid_comp_price.account_owner = ' . $this->companyGroupId;
        $this->data['competitor_details'] = $this->bid_management_model->get_data('bid_comp_price');
        $this->_render_template('add_price/index', $this->data);
    }
    public function addPrice_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->bid_management_model->get_data('user_detail');
        $this->data['account'] = $this->bid_management_model->get_data_byId('bid_comp_price', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('add_price/edit', $this->data);
    }
	   public function addPrice_view() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->bid_management_model->get_data('user_detail');
        $this->data['account'] = $this->bid_management_model->get_data_byId('bid_comp_price', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('add_price/view', $this->data);
    }
    /*  Function to save/update Account */
    public function save_add_price() {
        #pre($_POST);
        if ($this->input->post()) {
            $required_fields = array('account_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $material_details = count($_POST['material_name']);
                if ($material_details > 0) {
                    $arr = [];
                    $j = 0;
                    while ($j < $material_details) {
                        $jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$j], 'material_name_id' => $_POST['material_name'][$j], 'disc' => $_POST['disc'][$j], 'unit' => $_POST['uom_value'][$j], 'price' => $_POST['price'][$j]));
                        $arr[$j] = $jsonArrayObject;
                        $j++;
                    }
                    $materialDetail_array = json_encode($arr);
                } else {
                    $materialDetail_array = '';
                }
                $data = $this->input->post();
                $data['account_owner'] = $this->companyGroupId;
                $id = $data['id'];
                $data['product_detail'] = $materialDetail_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    #pre($data);
                    #die;
                    $success = $this->bid_management_model->update_data('bid_comp_price', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Competitor Price Details updated successfully";
                        logActivity('Competitor Price Details Updated', 'bid_competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Competitor Details updated', 'message' => 'Competitor Details updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_bid_management_tabs', 'data_id' => 'bid_competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*	pushNotification(array('subject'=> 'Company updated' , 'message' => 'Company updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));	*/
                            pushNotification(array('subject' => 'Competitor Price Details updated', 'message' => 'Competitor Price Details updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_bid_management_tabs', 'data_id' => 'bid_competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Competitor Price Details updated successfully');
                        redirect(base_url() . 'bid_management/add_price_compt', 'refresh');
                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->bid_management_model->insert_tbl_data('bid_comp_price', $data);
                    if ($id) {
                        logActivity('New Competitor Details Created', 'bid_competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Competitor Price Details created', 'message' => 'New Competitor Price Details is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_bid_management_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Company created' , 'message' => 'Company created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Competitor Price Details created', 'message' => 'New Competitor Price Details is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_bid_management_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Competitor Price Details inserted successfully');
                        redirect(base_url() . 'bid_management/add_price_compt', 'refresh');
                    }
                }
            }
        }
    }
    public function delete_add_price_compt($id = '') {
        if (!$id) {
            redirect('bid_management/competitor_details', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->bid_management_model->delete_data('bid_comp_price', 'id', $id);
        if ($result) {
            logActivity('Competitor Price Details (Competitor vise)  Deleted', 'bid_comp_price', $id);
            $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Competitor Price Details (Competitor vise)', 'message' => 'Competitor Price Details (Competitor vise) id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Competitor Price Details (Competitor vise)', 'message' => 'Competitor Price Details (Competitor vise) id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Competitor Price Details (Competitor vise) Deleted Successfully');
            $result = array('msg' => 'Competitor Price Details (Competitor vise) deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'bid_management/add_price_compt');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    public function getMat() {
        if ($_POST['id'] != '') {
            $account = $this->bid_management_model->get_data_byId('bid_competitor_details', 'id', $_POST['id']);
            $tt = json_decode($account->product_detail);
            if (!empty($tt)) {
                $i = 0;
                $uu = "";
                $newProduct = array();
                foreach ($tt as $key) {
                    $ww = getNameById('material_type', $key->material_type_id, 'id');
                    $pp = getNameById('material', $key->material_name_id, 'id');
                    $cc = getNameById('uom', $key->unit, 'id');
                    $key->material_type_id = $ww->id;
                    $key->material_type = $ww->name;
                    $key->material_name_id = $pp->id;
                    $key->material_name = $pp->material_name;
                    $key->unit = $cc->id;
                    $key->unit_name = $cc->ugc_code;
                    $key->disc = $key->disc;
                    $key->price = $key->price;
                    $newProduct[$i] = $key;
                    $i++;
                }
                echo json_encode($newProduct);
            }
        }
    }
    public function add_price_prodct() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Bid Management', base_url() . 'bid_management/dashboard');
        $this->breadcrumb->add('Add Price (Product)', base_url() . 'bid_management/add_price_prodct');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Add Price (Product)';
        $where = 'AND bid_prodct_price.created_by_cid = ' . $this->companyGroupId;
        $this->data['competitor_details'] = $this->bid_management_model->get_data('bid_prodct_price');
        $this->_render_template('add_price_prodct/index', $this->data);
    }
    public function add_price_prodct_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->bid_management_model->get_data('user_detail');
        $this->data['account'] = $this->bid_management_model->get_data_byId('bid_prodct_price', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('add_price_prodct/edit', $this->data);
    }
	public function add_price_prodct_view() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->bid_management_model->get_data('user_detail');
        $this->data['competitordetails'] = $this->bid_management_model->get_data_byId('bid_prodct_price', 'id', $this->input->post('id'));
        #pre($this->data['account']);
        $this->load->view('add_price_prodct/viewmat', $this->data);
    }
    public function save_price_prodct() {
        if ($this->input->post()) {
            $required_fields = array('account_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $material_details = count($_POST['account_id']);
                if ($material_details > 0) {
                    $arr = [];
                    $j = 0;
                    while ($j < $material_details) {
                        $jsonArrayObject = (array('compt_id' => $_POST['account_id'][$j], 'disc' => $_POST['disc'][$j], 'price' => $_POST['price'][$j]));
                        $arr[$j] = $jsonArrayObject;
                        $j++;
                    }
                    $materialDetail_array = json_encode($arr);
                } else {
                    $materialDetail_array = '';
                }
                $data = $this->input->post();
                $id = $data['id'];
                $data['comp_price_info'] = $materialDetail_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
                if ($id && $id != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    #pre($data);
                    #die;
                    $success = $this->bid_management_model->update_data('bid_prodct_price', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Competitor Price Details (Product vise) updated successfully";
                        logActivity('Competitor Price Details (Product vise)', 'bid_competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Competitor Price Details (Product vise) updated', 'message' => 'Competitor Price Details (Product vise) updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_bid_management_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Competitor Price Details (Product vise) updated', 'message' => 'Competitor Price Details (Product vise) updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_bid_management_tabs', 'data_id' => 'competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Competitor Price Details (Product vise) updated successfully');
                        redirect(base_url() . 'bid_management/add_price_prodct', 'refresh');
                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->bid_management_model->insert_tbl_data('bid_prodct_price', $data);
                    if ($id) {
                        logActivity('New Competitor Price Details (Product vise) Created', 'bid_competitor_details', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    pushNotification(array('subject' => 'Competitor Price Details (Product vise) Created created', 'message' => 'New Competitor Price Details (Product vise) Created is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_bid_management_tabs', 'data_id' => 'bid_competitor_details_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Competitor Price Details (Product vise) Created', 'message' => 'New Competitor Price Details (Product vise) Created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_bid_management_tabs', 'data_id' => 'bid_competitor_details_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Competitor Price Details (Product vise) inserted successfully');
                        redirect(base_url() . 'bid_management/add_price_prodct', 'refresh');
                    }
                }
            }
        }
    }
    /*delete supplier*/
    public function deleteProdctPrice($id = '') {
        if (!$id) {
            redirect('bid_management/add_price_prodct', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->bid_management_model->delete_data('bid_prodct_price', 'id', $id);
        if ($result) {
            logActivity('record  Deleted', 'leads', $id);
            $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Company deleted', 'message' => 'Company id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Company deleted', 'message' => 'Company id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Record Deleted Successfully');
            $result = array('msg' => 'Record Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'bid_management/add_price_prodct');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
    public function getCompt() {
        if ($_POST['mat_type_id'] != '' && $_POST['mat_name_id'] != '') {
            $mat_typ_id = $_POST['mat_type_id'];
            $mat_nam_id = $_POST['mat_name_id'];
            $bb = "'";
            $cc = "'";
            $ty = $bb . '%[{"material_type_id":"' . $mat_typ_id . '","material_name_id":"' . $mat_nam_id . '"%' . $cc;
            $this->data['cptdet'] = $this->bid_management_model->get_data('bid_competitor_details', 'account_owner = ' . $this->companyGroupId . ' AND ' . '`product_detail` LIKE ' . $ty . '');
            if (!empty($this->data['cptdet'])) {
                $i = 0;
                $newProduct = array();
                foreach ($this->data['cptdet'] as $key) {
                    $key['name'] = $key['name'];
                    $key['id'] = $key['id'];
                    $newProduct[$i] = $key;
                    $i++;
                }
                echo json_encode($newProduct);
            }
        }
    }
	
	  /* Add Tender */
    public function add_tender_compt() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
		$this->data['can_validate'] = validate_permissions();
        $this->breadcrumb->add('Bid Management', base_url() . 'bid_management/dashboard');
        $this->breadcrumb->add('Add Tender (Competitor)', base_url() . 'bid_management/add_tender');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Add Tender (Competitor)';
		$this->data['tender_status'] = $this->bid_management_model->get_data('tender_status');
		$this->data['tender_owner'] = $this->bid_management_model->get_data('user_detail',array("c_id"=>$this->companyGroupId));
		if(isset($_POST["ExportType"]) && $_POST['start'] == '' && $_POST['end'] == '' ) {

			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId);	
		/**	$this->data['register_opportunity'] = $this->bid_management_model->get_own_tbl_data('register_opportunity', $tender_status,'','tender_owner');**/
		//echo	$this->data['register_opportunity'] = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status,'','tender_owner');die();
		}elseif(!empty($_POST) && isset($_POST['start']) &&  isset($_POST['end']) ){				
			$tender_status = array('register_opportunity.created_date >=' => $_POST['start'] , 'register_opportunity.created_date <=' => $_POST['end'], 'register_opportunity.created_by_cid' => $this->companyGroupId);			
		}else{			
			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId);
		}
		$this->data['register_opportunity']  = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status);
		$tender_status1= array('register_opportunity.created_by_cid' => $this->companyGroupId,'register_opportunity.approve'=>1);
		$this->data['register_opportunity1']  = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status1);	
		if (isset($_POST['favourites']) ){				
			$tender_status = array('register_opportunity.created_by_cid' => $this->companyGroupId ,'favourite_sts'=> 1);
			$this->data['register_opportunity'] = $this->bid_management_model->get_tbl_data('register_opportunity', $tender_status,'','tender_owner');
		}		
        //$this->data['bid_competitor_details'] = $this->bid_management_model->get_data('tender_price');
        $this->_render_template('add_tender/index', $this->data);
    }
	
	 public function addtender_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
		$this->data['register_opportunity'] = $this->bid_management_model->get_data_byId('register_opportunity','id',$this->input->post('id'));
		$this->data['tenderstatus']  = $this->bid_management_model->get_data('tender_status');

		$whereAttachment = array('rel_id'=> $this->input->post('id'), 'rel_type'=> 'tender_docs');
		$this->data['attachments']  = $this->bid_management_model->get_attachmets_by_saleOrderId('attachments',$whereAttachment);
		$this->data['agent'] = $this->bid_management_model->get_data('liasoning_agent');
		 // $this->data['register'] = $this->bid_management_model->get_data('register_opportunity');
        //$this->data['account'] = $this->bid_management_model->get_data_byId('tender_price', 'id', $this->input->post('id'));
			if($this->input->post('id') != ''){
			$where = array('lead_id'=> $this->input->post('id'));
			$lead_call_log = $this->bid_management_model->get_data('tender_activity',$where);
			$this->data['tender_activities'] = $lead_call_log;
		}
        $this->load->view('add_tender/edit', $this->data);
    }
	   
	    public function getMaterialDataByIdCA() {
        if ($_POST['id'] != '') {
            //pre($_POST['id']);
            $material = $this->bid_management_model->get_data_byId('material', 'id', $_POST['id']);
            if ($material->uom) {
                $ww = getNameById('uom', $material->uom, 'id');
                $material->uom = $ww->ugc_code;
                $material->uomid = $ww->id;
                //pre($material);
                echo json_encode($material);
            }
        }
    }
  public function add_tender_price(){
  	$comp_details = count($_POST['account_id']);
    if($comp_details >0){
            $arr1 = [];
            $i = 0;
			 while($i<$comp_details) {
				 $comp_id=$_POST['account_id'][$i];
				// echo $comp_id;
		$material_details = count($_POST['material_name'][$comp_id][$i]);
				if($material_details >0){
					 $arr = [];
                    $j = 0;
                    while ($j <=$material_details) {
					$jsonArrayObject = (array('material_type_id' => $_POST['material_type_id'][$comp_id][$j], 'material_name' => $_POST['material_name'][$comp_id][$j], 'disc' => $_POST['disc'][$comp_id][$j], 'unit' => $_POST['uom_value'][$comp_id][$j], 'price' => $_POST['price'][$comp_id][$j]));
                        $arr[$j] = $jsonArrayObject;
                        $j++;
                    }
                    $materialDetail_array = json_encode($arr);
                } else {
                    $materialDetail_array = '';
					}
				
				$jsonArrayObject1 = (array('account_id' =>isset($_POST['account_id'][$i])?$_POST['account_id'][$i]:'','comp_product'=>$materialDetail_array));
			 $arr1[$i] = $jsonArrayObject1;
               $i++;
			 }	
			// pre($arr1);
	        $compDetail_array = json_encode($arr1);
        }else{
            $compDetail_array = '';
        }
	
                $data = $this->input->post();
                $data['bid_comp_price_info'] = $compDetail_array;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;          
                if ($this->input->post('id') && $this->input->post('id') != '') {
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    #pre($data);
                    #die;
                    $success = $this->bid_management_model->update_data('tender_price', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Competitor Price Details updated successfully";
                     //   logActivity('Competitor Price Details Updated', 'bid_competitor_details', $id);
                      
                        $this->session->set_flashdata('message', 'Competitor Price Details updated successfully');
                        redirect(base_url() . 'bid_management/add_tender_compt', 'refresh');
                    }
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                    $id = $this->bid_management_model->insert_tbl_data('tender_price', $data);
                    $this->session->set_flashdata('message', 'Competitor Price Details Added successfully');
                        redirect(base_url() . 'bid_management/add_tender_compt', 'refresh');
                    }
                }
            
 //delete tender
    public function delete_add_tender_compt($id = '') {
        if (!$id) {
            redirect('bid_management/competitor_details', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->bid_management_model->delete_data('tender_price', 'id', $id);
        if ($result) {
            logActivity('Competitor Tender Details (Competitor vise)  Deleted', 'tender_price', $id);
            $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 6));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Competitor Tender Details (Competitor vise)', 'message' => 'Competitor Tender Details (Competitor vise) id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Competitor Tender Details (Competitor vise)', 'message' => 'Competitor Price Details (Competitor vise) id : # ' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-shekel'));
            }
            $this->session->set_flashdata('message', 'Competitor Tender Details (Competitor vise) Deleted Successfully');
            $result = array('msg' => 'Competitor Tender Details (Competitor vise) deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'bid_management/add_tender_compt');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
    }
	
   // For Importing Bids
      public function importbid() {
        if (!empty($_FILES['uploadFile']['name']) != '') {
            $path = 'assets/modules/bid_management/excel_for_tender/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = "csv|xls|xlsx";
            $config['remove_spaces'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (empty($error)) {
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                //$tt = 'assets/modules/crm/excel_for_contacts/'.$data['uploadFile']['name'];
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
					
                 $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(true, true, true, true, true);
                    $flag = true;
                    $i = 0;
                    foreach ($allDataInSheet as $value) {
                        if ($flag) {
                            $flag = false;
                            continue;
                        }
						
						//$originalDate = $value['L'];
					
						// $newDate = date("Y-m-d", strtotime($originalDate));
						
						 $newDate = date("Y-m-d H:i:s");
                        //$insertdata[$i]['id'] = $value['A'];
                        $insertdata[$i]['tender_detail'] ='[{"tender_name":"'.$value['C'].'","department_name":"'.$value['A'].'","tender_link":"'.$value['D'].'"}]';
                        $insertdata[$i]['issue_date'] = $value['E'];
                        $insertdata[$i]['clossing_date'] = $value['F'];
                        $insertdata[$i]['emd_amount'] = $value['G'];
                        $insertdata[$i]['tender_amount'] = $value['H'];
                        $insertdata[$i]['tender_status'] = $value['I'];
                        $insertdata[$i]['status_comment'] = $value['J'];
                        $insertdata[$i]['created_date'] = $newDate;
						$insertdata[$i]['bid_location'] = $value['B'];
						$insertdata[$i]['bid_id'] = $value['K'];
						$insertdata[$i]['product_detail'] ='[{"material_name_id":"'.$value['M'].'","description":"","uom_material":"","qty":"'.$value['N'].'","price":"'.$value['O'].'","gst":"","total":"","TotalWithGst":""}]';
					    $insertdata[$i]['created_by_cid'] = $this->companyGroupId; 
						$insertdata[$i]['tender_name'] = ''; 
						$insertdata[$i]['tender_link'] = ''; 
						$insertdata[$i]['lpr_rate'] =0;
						$insertdata[$i]['material_type_id'] =0;
						$insertdata[$i]['agent_id'] =0;
						$insertdata[$i]['totalwithoutgst'] =0;
						$insertdata[$i]['grand_total'] =0;
						$insertdata[$i]['bid_comp_price_info'] =0;
						$insertdata[$i]['counter_offer'] =0;
						$insertdata[$i]['quantites'] =0;
						$insertdata[$i]['tender_owner'] =0;
						$insertdata[$i]['save_status']=1;
						$insertdata[$i]['approve']=0;
						$insertdata[$i]['disapprove']=0;
						$insertdata[$i]['validated_by']=0;
						$insertdata[$i]['disapprove_reason']='';
						$insertdata[$i]['attachment']='';
						$insertdata[$i]['result']=0;
						$insertdata[$i]['reject_reason']='';
						$insertdata[$i]['loa_code']=0;
						$insertdata[$i]['loa_date']='';
						$insertdata[$i]['payment_terms']='';
						$insertdata[$i]['billing_name']='';
						$insertdata[$i]['delivery_schedule']='';
						$insertdata[$i]['contact_person_name']='';
						$insertdata[$i]['company_address']='';
						$insertdata[$i]['inspection_agency']='';
						$insertdata[$i]['other_terms']='';
						$insertdata[$i]['svc_clause']='';
						$insertdata[$i]['email_id']='';
						$insertdata[$i]['deposit_name']='';
						$insertdata[$i]['deposit_date']='';
						$insertdata[$i]['item_rate']=0;
						$insertdata[$i]['loa_gst']=0;
						$insertdata[$i]['contact_number']='';
						$insertdata[$i]['item_desc']='';
						$insertdata[$i]['rites_add']='';
						$insertdata[$i]['option_clause']='';
						$insertdata[$i]['attachment1']='';
						$insertdata[$i]['consignee']='';
						$insertdata[$i]['po_code']=0;
						$insertdata[$i]['po_date']='';
						$insertdata[$i]['po_payment_terms']='';
						$insertdata[$i]['po_billing_name']='';
						$insertdata[$i]['po_delivery_schedule']='';
						$insertdata[$i]['po_contact_person_name']='';
						$insertdata[$i]['po_company_address']='';
						$insertdata[$i]['po_inspection_agency']='';
						$insertdata[$i]['po_other_terms']='';
						$insertdata[$i]['po_svc_clause']='';
						$insertdata[$i]['po_email_id']='';
						$insertdata[$i]['amendments']='';
						$insertdata[$i]['po_item_type']='';
						$insertdata[$i]['po_item_rate']=0;
						$insertdata[$i]['po_gst']=0;
						$insertdata[$i]['rites_case_number']=0;
						$insertdata[$i]['po_contact_number']='';
						$insertdata[$i]['po_item_desc']='';
						$insertdata[$i]['po_rites_add']='';
						$insertdata[$i]['po_option_clause']='';
						$insertdata[$i]['po_bank_details']='';
						$insertdata[$i]['po_consignee']='';
						$insertdata[$i]['created_by']=0;
						$insertdata[$i]['edited_by']=0;
						$i++;
                    } 
					//pre($insertdata);die();
                    $result = $this->bid_management_model->importbid($insertdata);
                    if ($result) {
                        //echo "Imported successfully";
                        // die();
                        
                    } else {
                        echo "ERROR !";
                    }
                }
                catch(Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
            } else {
                echo $error['error'];
            }
            $this->session->set_flashdata('message', 'Tender Imported Successfully');
            redirect(base_url() . 'bid_management/register_opportunity', 'refresh');
        }
        echo "<script>alert('Please Select the File to Upload')</script>";
        redirect(base_url() . 'bid_management/register_opportunity', 'refresh');
    }
 function Create_blankxls(){
	 $fileName = 'Blank_bid_management'.time().'.xls'; 
	$this->load->library('excel');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
		
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Department');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Location');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Tender Number');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Tender Type');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Issue Date');       
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Bid Clossing Date');       
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'EMD Amount');       
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Tender Amount');       
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Tender Status');       
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Status Comment');       
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Bid id');       
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Filling Date'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Item Name'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Qty'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'price'); 
	
	
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
         //redirect(site_url().$fileName);
		 
		 

		 redirect(base_url().'bid_management/register_opportunity', 'refresh');
 }	
	
	
	
	
	
	
	
	
	
	//Upload counter offer
	public function upload_counter_offer()
	{
			$id=$this->input->post('id');
if($id!=''){	
		if($_FILES['counter_offer']['name']==''){
        $data['counter_offer']='';
		 }else
            {
        $config['upload_path'] = './assets/modules/bid_management/uploads/'; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|txt|doc|pdf|csv';
       $config['max_size'] = 10000;
       // $config['max_width'] = 1500;
       // $config['max_height'] = 1500;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('counter_offer')) 
		{
            $error = array('error' => $this->upload->display_errors());
            print_r($error);die();
        } 
		else 
		{ 
            $data1 = array('counter_offer' => $this->upload->data());
        }
		 $data['counter_offer']=$data1['counter_offer']['orig_name'];
			}
			
		//	pre($data);die();
	$this->bid_management_model->update_data_details('register_opportunity',$data, 'id', $id);	
	$this->session->set_flashdata('message', 'File Uploaded Successfully');
		redirect(base_url() . 'bid_management/pipeline', 'refresh');
	}
	}
	
	//Update counter reject reason
	public function update_reject_reason()
	{
		$id=$_POST['id'];
		$data['reject_reason']=$_POST['reason'];
		$data['offer_is_reject']=1;
		$data['offer_is_accept']=0;
		$val= $this->bid_management_model->update_data_details('register_opportunity',$data, 'id', $id);
		echo $val;		
    }
	public function update_id_status()
	{
		$id=$_POST['id'];
		$data['tender_status']=6;
		$data['offer_is_accept']=1;
		$data['offer_is_reject']=0;
		$val=$this->bid_management_model->update_data_details('register_opportunity',$data, 'id', $id);
		echo $val;
	}
	
	public function save_loa(){
			$id =$this->input->post('id');
			$data  = $this->input->post();
			$consignee=$this->input->post('consignee');
			$data['consignee'] = json_encode($consignee);
					//pre($data);//die();
					if(!empty($_FILES['attachment1']['name']) && $_FILES['attachment1']['name'][0]!=''){
							$attachment_array = array();
							$certificateCount = count($_FILES['attachment1']['name']);
							for($i = 0; $i < $certificateCount; $i++){
								$filename     = $_FILES['attachment1']['name'][$i];
								$tmpname     = $_FILES['attachment1']['tmp_name'][$i];               
								$type     = $_FILES['attachment1']['type'][$i];               
								$error    = $_FILES['attachment1']['error'][$i];
								$size    = $_FILES['attachment1']['size'][$i];
								$exp=explode('.', $filename);
								$ext=end($exp);
								$newname=  $exp[0].'_'.time().".".$ext; 
								$config['upload_path'] = 'assets/modules/bid_management/uploads/';
								$config['upload_url'] =  base_url().'assets/modules/bid_management/uploads/';
								$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
								$config['max_size'] = '2000000'; 
								$config['file_name'] = $newname;
								$this->load->library('upload', $config);
								move_uploaded_file($tmpname,"assets/modules/bid_management/uploads/".$newname);				
								$attachment_array[$i]['rel_id'] = $id;
								$attachment_array[$i]['rel_type'] = 'tender_loa_docs';
								$attachment_array[$i]['file_name'] = $newname;
								$attachment_array[$i]['file_type'] = $type;
							}
								if(!empty($attachment_array)){
									/* Insert file information into the database */
									$attachmentId = $this->bid_management_model->insert_attachment_data('attachments', $attachment_array,'bid_management/editSaleOrder/'.$data['id']);
								}
					}
			$this->bid_management_model->update_data_details('register_opportunity',$data, 'id', $id);	
					$data['message'] = "Register Opportunity updated successfully";
					 redirect(base_url() . 'bid_management/pipeline', 'refresh');
	}
	
	public function save_po(){
			$id =$this->input->post('id');
			$data  = $this->input->post();
			//pre($data);die();
			$consignee=$this->input->post('po_consignee');
			$data['po_consignee'] = json_encode($consignee);
			//pre($data);
				if(!empty($_FILES['po_attachment']['name']) && $_FILES['po_attachment']['name'][0]!=''){
							$attachment_array = array();
							$certificateCount = count($_FILES['po_attachment']['name']);
							for($i = 0; $i < $certificateCount; $i++){
								$filename = $_FILES['po_attachment']['name'][$i];
								$tmpname  = $_FILES['po_attachment']['tmp_name'][$i];               
								$type     = $_FILES['po_attachment']['type'][$i];               
								$error    = $_FILES['po_attachment']['error'][$i];
								$size     = $_FILES['po_attachment']['size'][$i];
								$exp=explode('.', $filename);
								$ext=end($exp);
								$newname=  $exp[0].'_'.time().".".$ext; 
								$config['upload_path'] = 'assets/modules/bid_management/uploads/';
								$config['upload_url'] =  base_url().'assets/modules/bid_management/uploads/';
								$config['allowed_types'] = "gif|jpg|jpeg|png|ico|pdf|csv";
								$config['max_size'] = '2000000'; 
								$config['file_name'] = $newname;
								$this->load->library('upload', $config);
								move_uploaded_file($tmpname,"assets/modules/bid_management/uploads/".$newname);				
								$attachment_array[$i]['rel_id'] = $id;
								$attachment_array[$i]['rel_type'] = 'tender_po_docs';
								$attachment_array[$i]['file_name'] = $newname;
								$attachment_array[$i]['file_type'] = $type;
							}
								if(!empty($attachment_array)){
									/* Insert file information into the database */
									$attachmentId = $this->bid_management_model->insert_attachment_data('attachments', $attachment_array,'bid_management/editSaleOrder/'.$data['id']);
								}
				}
			$this->bid_management_model->update_data_details('register_opportunity',$data, 'id', $id);	
			$data['message'] = "Register Opportunity updated successfully";
			redirect(base_url() . 'bid_management/pipeline', 'refresh');
	}
	
	//sale order conversion pipeline
	public function edit_sale_order()
	{
		 if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
		  $this->data['users'] = $this->bid_management_model->get_data('user_detail');
		  $this->data['register_opportunity'] = $this->bid_management_model->get_data_byId('register_opportunity','id',$this->input->post('id'));
		  $this->load->view('sale_order/edit',$this->data);
	}
	 public function saveSaleOrder() {
        if ($this->input->post()) {
            $required_fields = array('account_id', 'product', 'qty', 'uom', 'price', 'order_date');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $products = count($_POST['product']);
                $comp_id = $_POST['account_id'];
                $sale_order_priority_array = array();
                if ($products > 0) {
                    $arr = [];
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product' => $_POST['product'][$i], 'description' => $_POST['description'][$i], 'quantity' => $_POST['qty'][$i], 'uom' => $_POST['uom'][$i], 'price' => $_POST['price'][$i], 'gst' => $_POST['gst'][$i], 'individualTotal' => $_POST['totals'][$i], 'individualTotalWithGst' => $_POST['TotalWithGsts'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $data['so_order'] = ($data['revised_so_code'] != '') ? $data['revised_so_code'] : $data['so_order'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                //$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['product'] = $product_array;
                $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
                $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
                //$data['payment_terms'] = json_encode($data['payment_terms']);
                //  $data['payment_terms'] = json_encode($data['payment_terms']);
                $id = $data['id'];
                $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 9));
                #pre($data); die;
                if ($id && $id != '') {
                    $success = $this->bid_management_model->update_data('sale_order', $data, 'id', $id);
                    if ($success) {
                        if (!empty($arr)) {
                            foreach ($arr as $res) {
                                //$this->bid_management_model->update_single_value_data('material',array('sales_price'=>$res['price']), array('id'=> $res['product'],'created_by_cid'=>$_SESSION['loggedInUser']->c_id));
                                $this->bid_management_model->update_single_value_data('material', array('sales_price' => $res['price']), array('id' => $res['product'], 'created_by_cid' => $this->companyGroupId));
                            }
                        }
                        $data['message'] = "Sale Order updated successfully";
                        logActivity('Sale Order Updated', 'lead', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInCompany']->u_id) {
                                    /*pushNotification(array('subject'=> 'Sale order updated' , 'message' => 'Sale order updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Sale Order updated', 'message' => 'Sale order updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Sale order updated' , 'message' => 'Sale order updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Sale Order updated', 'message' => 'Sale order updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                        }
                        ComplogActivity($comp_id, 'Sale Order Updated', 'Sale Order', $id);
                        $this->session->set_flashdata('message', 'Sale Order Updated successfully');
                    }
                } else {
                    $id = $this->bid_management_model->insert_tbl_data('sale_order', $data);
                    if ($id) {
                        if (!empty($arr)) {
                            foreach ($arr as $res) {
                                //$this->bid_management_model->update_single_value_data('material',array('sales_price'=>$res['price']), array('id'=> $res['product'],'created_by_cid'=>$_SESSION['loggedInUser']->c_id));
                                $this->bid_management_model->update_single_value_data('material', array('sales_price' => $res['price']), array('id' => $res['product'], 'created_by_cid' => $this->companyGroupId));
                            }
                        }
                        logActivity('New Sale Order Created', 'Sale Order', $id);
                        ComplogActivity($comp_id, 'Sale Order Inserted', 'Sale Order', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInCompany']->u_id) {
                                    /*  pushNotification(array('subject'=> 'Sale order created' , 'message' => 'Sale order created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Sale order created', 'message' => 'New Sale order is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInCompany']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'Sale created updated' , 'message' => 'Sale order created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Sale order created', 'message' => 'New Sale order is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'add_crm_tabs', 'data_id' => 'sale_order_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Sale Order inserted successfully');
                    }
                }
                if ($id) {
                    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['name'][0] != '') {
                        $attachment_array = array();
                        $certificateCount = count($_FILES['attachment']['name']);
                        for ($i = 0;$i < $certificateCount;$i++) {
                            $filename = $_FILES['attachment']['name'][$i];
                            $tmpname = $_FILES['attachment']['tmp_name'][$i];
                            $type = $_FILES['attachment']['type'][$i];
                            $error = $_FILES['attachment']['error'][$i];
                            $size = $_FILES['attachment']['size'][$i];
                            $exp = explode('.', $filename);
                            $ext = end($exp);
                            $newname = $exp[0] . '_' . time() . "." . $ext;
                            $config['upload_path'] = 'assets/modules/crm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/crm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/crm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $id;
                            $attachment_array[$i]['rel_type'] = 'sale_order';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->bid_management_model->insert_attachment_data('attachments', $attachment_array, 'crm/editSaleOrder/' . $data['id']);
                        }
                    }
                    if ($data['id'] && $data['id'] != '') {
                        $result = $this->bid_management_model->delete_data('sale_order_priority', 'sale_order_id', $data['id']);
                    }
                    /* insert sale order priority */
                    $sale_order_priority_array = array();
                    $maxPriority = getMaxSaleOrderPriority();
                    $maxPriority = $maxPriority ? ($maxPriority + 1) : 1;
                    $j = 0;
                    while ($j < $products) {
                        $sale_order_priority_array[$j]['sale_order_id'] = $id;
                        $sale_order_priority_array[$j]['product_id'] = $_POST['product'][$j];
                        $sale_order_priority_array[$j]['quantity'] = $_POST['qty'][$j];
                        $sale_order_priority_array[$j]['uom'] = $_POST['uom'][$j];
                        $sale_order_priority_array[$j]['price'] = $_POST['price'][$j];
                        $sale_order_priority_array[$j]['individualTotal'] = $_POST['totals'][$j];
                        $sale_order_priority_array[$j]['individualTotalWithGst'] = $_POST['TotalWithGsts'][$j];
                        $sale_order_priority_array[$j]['priority'] = $maxPriority;
                        //$sale_order_priority_array[$j]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
                        $sale_order_priority_array[$j]['created_by_cid'] = $this->companyGroupId;
                        $j++;
                        $maxPriority++;
                    }
                    if (!empty($sale_order_priority_array)) {
                        $attachmentId = $this->bid_management_model->insertPriorityData('sale_order_priority', $sale_order_priority_array);
                    }
                    /* insert sale order priority */
                }
                redirect(base_url() . 'bid_management/register_opportunity', 'refresh');
            }
	 }}
	    /*get company  addresses in crm sale order*/
    function getAddress() {
        //$where = array('id' => $_SESSION['loggedInUser']->c_id);
        $where = array('id' => $this->companyGroupId);
        $data = $this->bid_management_model->get_data_byAddress('company_detail', $where);
        $data1 = $data[0]['address'];
        $data2 = json_decode($data1);
        $addressArray = array();
        $i = 0;
        foreach ($data2 as $dt) {
            $addressArray[$i]['id'] = $dt->compny_branch_name;
            $addressArray[$i]['text'] = $dt->compny_branch_name;
            $i++;
        }
        echo json_encode($addressArray);
    }
	    public function getAccountDataById() {
        if ($_POST['id'] != '') {
            $account = $this->bid_management_model->get_data_byId('account', 'id', $_POST['id']);
            echo json_encode($account);
        }
    }
    public function getContactDataById() {
        if ($_POST['id'] != '') {
            $contacts = $this->bid_management_model->get_data_byId('contacts', 'id', $_POST['id']);
            echo json_encode($contacts);
        }
    }
	    public function fetchLocationById() {
        //pre($_POST); die;
        $country = $this->bid_management_model->get_data_byId('country', 'country_id', $_POST['billing_country']);
        $state = $this->bid_management_model->get_data_byId('state', 'state_id', $_POST['billing_state']);
        $city = $this->bid_management_model->get_data_byId('city', 'city_id', $_POST['billing_city']);
        //echo $address = $country->country_name . '</br>'.  $state->state_name . '</br>'.  $city->city_name;
        $address = array('country' => $country->country_name, 'state' => $state->state_name, 'city' => $city->city_name);
        echo json_encode($address);
    }
	
	public function edit_hrm_task(){
		$id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
		$this->data['register_opportunity'] = $this->bid_management_model->get_data_byId('register_opportunity','id',$this->input->post('id'));
        $this->data['work_detail'] = $this->bid_management_model->get_data_byId('work_detail', 'id', $id);
        $this->load->view('work_detail/edit', $this->data);
	}
	   public function saveWorkdetail()
    {
        if ($this->input->post()) {
            $required_fields = array(
                ''
            );
            $is_valid        = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data                     = $this->input->post();
                $id                       = $data['id'];
                $data['npdm_id']          = $_POST['npdm_name'];
                $data['created_by']       = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid']   = $_SESSION['loggedInUser']->c_id;
                $usersWithViewPermissions = $this->bid_management_model->get_data('permissions', array(
                    'is_view' => 1,
                    'sub_module_id' => 115
                ));
                if ($id && $id != '') {
                    //$processType = $this->production_model->processTypeExist($_POST['process_type'], 'update');
                    //if($processType){
                    //}else{
                    $success = $this->bid_management_model->update_data('work_detail', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Work Details  updated successfully";
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    //pushNotification(array('subject'=> 'Work Details updated' , 'message' => 'Work Details updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));
                                    
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            //pushNotification(array('subject'=> 'Work Details updated' , 'message' => 'Work Details updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));
                            
                        }
                        logActivity('Work Details Updated', 'work_detail', $id);
                        $this->session->set_flashdata('message', 'Work Details Updated successfully');
                        redirect(base_url() . 'bid_management/work_detail', 'refresh');
                    }
                } else {
                    $id = $this->bid_management_model->insert_tbl_data('work_detail', $data);
                    if ($id) {
                        logActivity('Work Details inserted', 'work_detail', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    //pushNotification(array('subject'=> 'Work Details created' , 'message' => 'Work Details created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));
                                    
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            //pushNotification(array('subject'=> 'Work Details created' , 'message' => 'Work Details created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));
                            
                        }
                        $this->session->set_flashdata('message', 'Work Details inserted successfully');
                        redirect(base_url() . 'bid_management/pipeline', 'refresh');
                    }
                }
            }
        }
    }
	    public function checkworkstatus()
    {
        echo date("Y-m-d H:i:s");
        //$where2 = array('end_date_time' <= date("Y-m-d H:i:s"));
        $this->data['work_d'] = $this->bid_management_model->get_data('work_detail');
        foreach ($this->data['work_d'] as $key) {
            if ($key['work_status'] != 4 && $key['work_status'] != 5) {
                $data['work_status']      = '2';
                $data['job_name']         = $key['job_name'];
                $data['work_assigned_to'] = $key['work_assigned_to'];
                $data['work_description'] = $key['work_description'];
                $data['end_date_time']    = $key['end_date_time'];
                $data['created_by']       = $key['created_by'];
                $data['created_by_cid']   = $key['created_by_cid'];
                $data['created_date']     = $key['created_date'];
                $data['updated_date']     = date("Y-m-d H:i:s");
                $data['npdm_id']          = $key['npdm_id'];
                $var                      = $key['end_date_time'];
                if (time() > strtotime($var)) {
                    $success = $this->bid_management_model->update_data('work_detail', $data, 'id', $key['id']);
                    echo 'Status Updated';
                } else {
                    echo 'dont update status' . '<br>';
                }
            }
        }
    }
/*end of controller*/
}



