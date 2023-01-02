<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Account extends ERP_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            redirect( base_url().'auth/login', 'refresh');
        }
		/*$this->settings['parent_menu'] = 'setup';
		$this->settings['active_menu'] = 'setup';		*/
        $this->load->library(array( 'form_validation'));
		
		$this->load->helper('account/account');
        $this->load->model('account_model');
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->settings['css'][] = 'assets/plugins/ion.rangeSlider/css/ion.rangeSlider.css';
		$this->settings['css'][] = 'assets/modules/account/css/custom_style.css';
		$this->settings['css'][] = 'assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css';
		$this->settings['css'][] = 'assets/modules/account/css/style.css';
		$this->settings['css'][] = 'assets/css/new-style.css';
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->scripts['js'][] = 'assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js';
		$this->scripts['js'][] = 'assets/js/select2.js';
		$this->scripts['js'][] = 'assets/js/custom/ajax_script.js';	
		
		
		$this->scripts['js'][] = 'assets/plugins/fastclick/lib/fastclick.js';
		$this->scripts['js'][] = 'assets/plugins/nprogress/nprogress.js';
		$this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
		$this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';		
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';
		
	
		$this->settings['css'][] = 'assets/plugins/switchery/dist/switchery.min.css';
		$this->scripts['js'][] = 'assets/plugins/switchery/dist/switchery.min.js"';
		$this->scripts['js'][] = 'assets/modules/purchase/js/script.js';
		$this->scripts['js'][] = 'assets/modules/inventory/js/script.js';
		$this->scripts['js'][] = 'assets/modules/account/js/script.js';
		//$this->scripts['js'][] = 'assets/modules/account/js/new_script.js';
		$this->scripts['js'][] = 'assets/modules/account/js/jexcel.js';
		
		
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

		
	}
	
    /* Main Function to fetch all the listing of departments */
    public function index(){ 
		/*if(!is_admin()){
			redirect( base_url().'dashboard', 'refresh');
		}*/
		#else{
			$this->data['title'] = "Users";
			$this->data['module'] = "User";
			$this->data['sidetab'] = "support";
			$this->data['currenttab'] = "User";
			$this->settings['module_title'] = 'Users';
			$this->data['company']  = $this->account_model->get_data('company',array('user_id'=> 0));	
			$this->_render_template('index', $this->data);
		#}
    }
	
	/* Main Function to fetch all the listing of departments */
    public function account_groups() { 
		$this->load->library('pagination');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account Group', base_url() . 'leads');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Account Group';
	//	$created_id = $_SESSION['loggedInUser']->u_id;
		$created_id = $_SESSION['loggedInUser']->c_id;
		/*if(isset($_GET['start']) && $_GET['start']!='' &&  isset($_GET['end']) && $_GET['end']!=''){
			$where_row='account_group.created_date>="'.$_GET['start'].'" && account_group.created_date<="'.$_GET['end'].'"';
		}*/
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2=" account_group.id like '%".$search_string."%' or account_group.name like '%".$search_string."%'";
		 redirect("account/account_groups/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "account_group.name like'%" . $_GET['search'] . "%' or account_group.id like'%". $_GET['search']."%'";
			}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
      $where_row='(created_by_cid = 0 OR created_by_cid = "'.$created_id.'")';
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/account_groups/";
			$config["total_rows"] = $this->account_model->num_rows('account_group',$where_row,$where2);
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
	//	$this->data['ledgers']  = $this->account_model->get_data_listing('ledger',$where, $config['per_page'] , $page,  $this->data['sort_by'], $orderBy,$this->data['search_string']);
	$this->data['account_groups'] = $this->account_model->get_data_with_zero_id_condtions('account_group',$created_id, $config["per_page"], $page,$where2,$order);
	if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		$this->_render_template('account_group/index', $this->data);
    }
		
	public function editAccountGroup(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['account_group'] = $this->account_model->get_data_byId('account_group','id',$this->input->post('id'));			
			$this->load->view('account_group/edit', $this->data);
		}	
	}
	
	/*  Function to add/edit Lead */
	public function saveAccountGroup(){	 
		if ($this->input->post()) { 
		//pre($_POST);die();
			$required_fields = array('name');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();	
				
				$data['created_by'] = $_SESSION['loggedInCompany']->id;
				$data['created_by_cid'] = $this->companyGroupId;
				$id = $data['id'];
				// $default_group_name_check = checkValue('account_group',$data['name'],'name');
				// if($default_group_name_check > 0){
					// $this->session->set_flashdata('message', 'This Group Name is Alrady Added');
					// redirect(base_url().'account/account_groups', 'refresh');
					
				// }
				
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInCompany']->id;
					$success = $this->account_model->update_data('account_group',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Group updated successfully";
                        logActivity('Group Updated','account_group',$id);
                        $this->session->set_flashdata('message', 'Group Updated successfully');
					    redirect(base_url().'account/account_groups', 'refresh');
                    }
				}else{
					$id = $this->account_model->insert_tbl_data('account_group',$data);					
					if ($id) {                        
                        logActivity('New Group Created','account_group',$id);
                        $this->session->set_flashdata('message', 'Group inserted successfully');
					    redirect(base_url().'account/account_groups', 'refresh');
                    }else{
						$this->session->set_flashdata('message', 'This Group Name is Alrady Added');
					    redirect(base_url().'account/account_groups', 'refresh');
					}   				
				}
				
			}			
        }
	}
	
	
	/* Main Function to fetch all the listing of departments */
    public function ledgers() { 
		$this->load->library('pagination');
        $this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'ledger');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Ledgers';
		$created_id = $_SESSION['loggedInUser']->u_id;
		//$created_c_id = $_SESSION['loggedInUser']->c_id;
		$created_c_id = $this->companyGroupId;
		//$where = "ledger.created_by_cid = ".$created_c_id." AND activ_status = 1";
		//$where_inactive = "ledger.created_by_cid = ".$created_c_id." AND activ_status = 0";
		
		if($_GET['tab']=='active_ledger'){
				$where = "(ledger.created_by_cid = ".$created_c_id." OR ledger.created_by_cid = 0)  AND ledger.activ_status = 1";
			}elseif($_GET['tab']=='inactive_ledger'){
				$where_inactive = "(ledger.created_by_cid = ".$created_c_id." OR ledger.created_by_cid = 0) AND ledger.activ_status = 0";
			}else{
				$where = "(ledger.created_by_cid = ".$created_c_id." OR ledger.created_by_cid = 0) AND ledger.activ_status = 1";
			}
			
			
		if(isset($_GET['ExportType'])!='')
		{
			if($_GET['tab']=='active_ledger'){
				$where = "(ledger.created_by_cid = ".$created_c_id." OR ledger.created_by_cid = 0)  AND ledger.activ_status = 1";
			}elseif($_GET['tab']=='inactive_ledger'){
				$where_inactive = "(ledger.created_by_cid = ".$created_c_id." OR ledger.created_by_cid = 0) AND ledger.activ_status = 0";
			}else{
				$where = "(ledger.created_by_cid = ".$created_c_id." OR ledger.created_by_cid = 0) AND ledger.activ_status = 1";
			}
		}
		if(!empty($_POST['gst_number'])){
		 $invalid_gst = implode(',', $_POST['gst_number']);
		$this->data['ledgers']  = $this->account_model->get_active_and_inactive_ledgers('ledger',$created_c_id,$invalid_gst,$config["per_page"], $page,$where2,$order);			
		$this->_render_template('ledger/index', $this->data);
		}
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2="(ledger.name like'%".$search_string."%' or ledger.id ='".$search_string."')";
		 redirect("account/ledgers/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "(ledger.name like'%" . $_GET['search'] . "%' or ledger.id ='". $_GET['search']."')";
			}
		
	if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
		if($_GET['tab']=='active_ledger' && $_GET['tab']!='inactive_ledger'){
			$rows=$this->account_model->num_rows('ledger',$where,$where2);
		}elseif($_GET['tab']=='inactive_ledger' && $_GET['tab']!='active_ledger'){
			$rows=$this->account_model->num_rows('ledger',$where_inactive,$where2);
		}else{
			$rows=$this->account_model->num_rows('ledger',$where,$where2);
		}
		
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/ledgers/";
			$config["total_rows"] = $rows;
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			if($_GET['tab']=='active_ledger' && $_GET['tab']!='inactive_ledger'){
			$this->data['ledgers']  = $this->account_model->get_ledgers_active('ledger',$where, $config["per_page"], $page,$where2,$order,$export_data);}
			elseif($_GET['tab']=='inactive_ledger' && $_GET['tab']!='active_ledger'){
			$this->data['ledgers_inactive']  = $this->account_model->get_ledgers_active('ledger',$where_inactive, $config["per_page"], $page,$where2,$order,$export_data);
			}else{
				$this->data['ledgers']  = $this->account_model->get_ledgers_active('ledger',$where, $config["per_page"], $page,$where2,$order,$export_data);
				}
			if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }

	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		
			$this->_render_template('ledger/index', $this->data);
			
    }
	
	
	public function ledger_create(){
		$this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'ledger');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Ledgers';
		$this->_render_template('ledger/edit', $this->data);
	}
	public function editLedger(){
	
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['ledger'] = $this->account_model->get_data_byId('ledger','id',$this->input->post('id'));
			$this->load->view('ledger/edit', $this->data);
		}	
	}
	
	public function viewLedger(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['ledger'] = $this->account_model->get_data_byId('ledger','id',$this->input->post('id'));			
			$this->load->view('ledger/view', $this->data);
		}	
	}
	
		/*  Function to add/edit Lead */
	public function saveLedger(){
		if ($this->input->post()) {
			$required_fields = array('name','account_group_id');	
			$mailing_addressLength = count($_POST['mailing_address']);
				//if($mailing_addressLength >0){
					$arr = [];
					$i = 0;
					$tt = 1;
					while($i < $mailing_addressLength) {	
						$jsonArrayObject = (array('ID'=>$tt,'mailing_name' =>$_POST['mailing_name'][$i],'mailing_address' => $_POST['mailing_address'][$i],'mailing_country' => $_POST['mailing_country'][$i], 'mailing_state' => $_POST['mailing_state'][$i], 'mailing_city' => $_POST['mailing_city'][$i], 'mailing_pincode' => $_POST['mailing_pincode'][$i],'gstin_no' => $_POST['gstin_no'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
						$tt++;				
					}
					$descr_of_ldgr_array = json_encode($arr);
				// }else{
					// $descr_of_ldgr_array = '';
				// }
		
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}else{
				
				$data  = $this->input->post();
				    $created_by_id = $_SESSION['loggedInUser']->u_id;
					$group_id = $_POST['account_group_id']; 
					$dd = $this->account_model->get_ledger_account_grp_Dtl('account_group',$created_by_id,$group_id); 
					
					//@$data['parent_group_id'] = $dd[0]['parent_group_id'];
				//Assign sales Person
				// $party_Limit_Dtls = getNameById('ledger',$_POST['id'],'id');
				// $salesPersonArr = $party_Limit_Dtls->salesPersons;
				
				$salesPerson = json_encode($_POST['salesPersons']);			
		
				
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				if (!empty($_POST['temp_crlimitDate'] && $_POST['temp_crlimitDate'] != '0000-00-00')) {
					$data['temp_crlimitDate'] = date("Y-m-d H:i:s", strtotime($_POST['temp_crlimitDate']));
				}else{
					$data['temp_crlimitDate'] = '0000-00-00';
				}
				$data['mailing_address'] = $descr_of_ldgr_array;	
				$data['due_days'] = (int)$_POST['due_days'];	
				$data['salesPersons'] = $salesPerson;	
				$id = $data['id'];
				//pre($data);die('HMM');
				$usersWithViewPermissions = $this->account_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 18));
				$perviuss_ledger = getNameById('ledger',$_POST['name'],'name');
				
				
					
				if($id && $id != ''){
					 $created_by_id = $_SESSION['loggedInUser']->u_id; 
					 $group_id = $_POST['account_group_id']; 
					 $dd = $this->account_model->get_ledger_account_grp_Dtl('account_group',$created_by_id,$group_id); 
					// $data['parent_group_id'] = @$dd[0]['parent_group_id'];	
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					//$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$data['created_by_cid'] = $this->companyGroupId;
				//	pre($_POST);die();
					$success = $this->account_model->update_data('ledger',$data, 'id', $id);
					
					if(!empty($usersWithViewPermissions)){
						foreach($usersWithViewPermissions as $userViewPermission){
							if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
								pushNotification(array('subject'=> 'Ledger Updated' , 'message' => 'Ledger id : #'.$id.' is updated by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id,'class'=>'add_account_tabs','data_id' => 'ledger_view','icon'=>'fa-shopping-cart'));
							}
						}
					} 
					if($_SESSION['loggedInUser']->role !=1){
						pushNotification(array('subject'=> 'Ledger Updated' , 'message' => 'Ledger id : #'.$id.' is updated by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id,'class'=>'add_account_tabs','data_id' => 'ledger_view','icon'=>'fa-shopping-cart'));
					}	
					if ($success) {
						
                        $data['message'] = "Ledger updated successfully";
                        logActivity('Ledger Updated','ledger',$id);
                        $this->session->set_flashdata('message', 'Ledger Updated successfully');
					    redirect(base_url().'account/ledgers', 'refresh');
                    }
				}else{
					if($perviuss_ledger->name != $_POST['name'] || $perviuss_ledger->account_group_id !=  $_POST['account_group_id'] || $perviuss_ledger->parent_group_id !=  $_POST['parent_group_id'] ){
					$id = $this->account_model->insert_tbl_data('ledger',$data);
					if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'New Ledger created' , 'message' => 'New Ledger is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_account_tabs','data_id' => 'ledger_view' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'New Ledger created' , 'message' => 'New Ledger is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'add_account_tabs','data_id' => 'ledger_view','icon'=>'fa-shopping-cart'));
						}	
					
					if ($id) {                        
                        logActivity('New Ledger Created','ledger',$id);
                        $this->session->set_flashdata('message', 'Ledger Inserted successfully');
					    redirect(base_url().'account/ledgers', 'refresh');
                    } 

					}else{
						$this->session->set_flashdata('message', 'Ledger Already Exists');
						redirect(base_url().'account/ledgers', 'refresh');
					}		
				}
				
				
			}			
        }
	}
	



	/*delete supplier*/
	public function deleteLedger($id = ''){	
		if (!$id) {
           redirect('account/ledgers', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('ledger','id',$id);
		if($result){
			logActivity('Ledgers Deleted','ledger',$id);
			$this->session->set_flashdata('message', 'Ledger Deleted Successfully');
			$result = array('msg' => 'Ledger Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/ledgers');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}
	public function deleteAccountGroup($id = ''){
		if (!$id) {
           redirect('account/account_groups', 'refresh');   
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('account_group','id',$id);
		if($result){
			logActivity('Account Group Deleted','account_group',$id);
			$this->session->set_flashdata('message', 'Account Group Deleted Successfully');
			$result = array('msg' => 'Account Group Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/account_groups');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => '188'));
        }
		
	}
	public function voucher_types() { 
	$this->load->library('pagination');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Voucher Type', base_url() . 'Voucher');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Voucher';
		$created_id = $_SESSION['loggedInUser']->u_id;
		//$created_cid = $_SESSION['loggedInUser']->c_id;
		$created_cid = $this->companyGroupId;
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2="voucher_type.voucher_name like'%".$search_string."%' or voucher_type.id like'%".$search_string."%'";
		redirect("account/voucher_types/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "voucher_type.voucher_name like'%" . $_GET['search'] . "%' or voucher_type.id like'%". $_GET['search']."%'";
		}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
			
		}else{
			$order="desc";
		}
		$where_row='created_by_c_id = 0 OR created_by_c_id = "'.$created_cid.'"';
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/voucher_types/";
			$config["total_rows"] = $this->account_model->num_rows('voucher_type',$where_row,$where2);
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
			//sort
			if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		
		$this->data['voucher']  = $this->account_model->get_data_with_zero_id_condtions('voucher_type',$created_cid, $config['per_page'] , $page,$where2,$order); 
	$this->_render_template('voucher/index', $this->data);
    }
	
	public function saveVoucher_type(){	  
		if ($this->input->post()) {
			$required_fields = array('voucher_name','voucher_desc');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();			
				$data['created_by_uid'] = $_SESSION['loggedInUser']->u_id;
				//$data['created_by_c_id'] = $_SESSION['loggedInUser']->c_id;
				$data['created_by_c_id'] = $this->companyGroupId;
				$id = $data['id'];
				//pre($data);die('dd');
				$default_voucher_name_check = checkValue('voucher_type',$data['voucher_name'],'voucher_name');
				if($default_voucher_name_check > 0){
					$this->session->set_flashdata('message', 'This Voucher Name is Alrady Added');
					redirect(base_url().'account/voucher_types', 'refresh');
				}
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('voucher_type',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Voucher updated successfully";
                        logActivity('Voucher  Updated','voucher_type',$id);
                        $this->session->set_flashdata('message', 'Voucher Type Updated successfully');
					    redirect(base_url().'account/voucher_types', 'refresh');
                    }
				}else{
					$id = $this->account_model->insert_tbl_data('voucher_type',$data);  					
					if ($id) {                        
                        logActivity('New Voucher Created','voucher_type',$id);
                        $this->session->set_flashdata('message', 'Voucher Type inserted successfully');
					    redirect(base_url().'account/voucher_types', 'refresh');
                    }    				
				}
			}			
        }
	}
	/* Quick Add voucher */
	public function quick_add_voucher(){
		$voucher_name = $_REQUEST['voucher_name'];
		$voucher_desc = $_REQUEST['voucher_desc'];
		
		$vouchers_details = array(
					'voucher_name'=>$voucher_name,
					'voucher_desc'=>$voucher_desc,
					//'created_by_c_id'=>$_SESSION['loggedInUser']->c_id,
					'created_by_c_id'=>$this->companyGroupId,
					'created_by_uid'=>$_SESSION['loggedInUser']->u_id,
				);	
		
		
		$data = $this->account_model->insert_on_spot_tbl_data('voucher_type',$vouchers_details);
		if($data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	
	/* Quick Add voucher */
	
	
	public function viewVoucher(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher'] = $this->account_model->get_data_byId('voucher_type','id',$this->input->post('id'));			
			$this->load->view('voucher/view', $this->data);
		}	
	}
	public function editVoucher(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher'] = $this->account_model->get_data_byId('voucher_type','id',$this->input->post('id'));			
			$this->load->view('voucher/edit', $this->data);
		}	
	}
	public function deleteVoucher($id = ''){	
		if (!$id) {
           redirect('account/voucher_types', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('voucher_type','id',$id);
		if($result){
			logActivity('Voucher Deleted','voucher_type',$id);
			$this->session->set_flashdata('message', 'Voucher Deleted Successfully');
			$result = array('msg' => 'Voucher Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/voucher_types');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	
	//Add Voucher Function
	
	public function invoices() { 

	$this->load->library('pagination');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Invoice Details', base_url() . 'Add Invoice');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = ' Invoice Details';
		//$created_by_id  = $_SESSION['loggedInUser']->c_id;
		$created_by_id  = $this->companyGroupId;
		$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$created_by_id);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			
			if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date('Y-m-d', $second_date22);
					}
				}
				$original_Date_start = $_GET['start'];
				$cnvrted_newDate_Start = date("Y-m-d", strtotime($original_Date_start));
				$original_Date_end = $_GET['end'];
				$cnvrted_newDate_end = date("Y-m-d", strtotime($original_Date_end));
	//	pre($_GET);
		$where=array('created_by_cid'=> $created_by_id,'invoice.date_time_of_invoice_issue >=' =>$first_date, 'invoice.date_time_of_invoice_issue <=' => $second_date);	
		if(!empty($_POST['hsnsac_number'])){
			$invalid_hsnsac = implode(',', $_POST['hsnsac_number']);
			$this->data['add_invoice_details']  = $this->account_model->get_ledgers_whereIn_conditions('invoice',$created_by_id,$invalid_hsnsac);
			//$this->_render_template('invoice/index', $this->data);
			//$this->load->view('invoice/index', $this->data);
		}

		if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
		
			$where = array('created_by_cid'=> $created_by_id,'invoice.date_time_of_invoice_issue >=' =>$cnvrted_newDate_Start, 'invoice.date_time_of_invoice_issue <=' => $cnvrted_newDate_end);
		}elseif(isset($_GET['start'])!='' &&  isset($_GET['end'])!='' && isset($_GET["ExportType"])){
		
			$where = "invoice.created_by_cid = ".$created_by_id." AND  (invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')";
		}elseif($_GET['selected_branch_idd'] != '' &&  $_GET['start'] == '' && $_GET['end'] == '' && $_GET['selected_branch_idd'] != 'All' ){
		
				$where = array('invoice.sale_lger_brnch_id =' => $_GET['selected_branch_idd'], 'invoice.created_by_cid'=> $this->companyGroupId);
			
		}elseif($_GET['start'] != ''  && $_GET['end'] != '' && $_GET['selected_branch_idd'] != ''){
		//echo 'There';
			$where = "invoice.created_by_cid = ".$this->companyGroupId." AND  (invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')AND invoice.sale_lger_brnch_id=".$_GET['selected_branch_idd'];
		}elseif($_GET['selected_branch_idd'] == 'All' &&  $_GET['start'] == '' && $_GET['end'] == '') {
			$where = array('invoice.created_by_cid'=> $this->companyGroupId);
		}elseif($_GET['start'] !='' &&  $_GET['end']!='' && $_GET["ExportType"] ==''){
		
			$where = "invoice.created_by_cid = ".$created_by_id." AND  (invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')";
		}
		//Search
		
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			
				$search_string = $_POST['search'];
				$materialName=getNameById('material',$search_string,'material_name');
				if($materialName->id == '' ){
					$where2 = "invoice.invoice_num like '%" . $search_string . "%' or invoice.id like '%" .$search_string. "%'";
				}elseif($materialName->id != ''){
					$json_dtl ='{"material_id" : "'.$materialName->id.'"}';
					$where2 = "invoice.descr_of_goods!='' AND json_contains(`descr_of_goods`, '".$json_dtl."')" ;
				}
			 redirect("account/invoices/?search=$search_string");
        }else if(isset($_GET['search']) && $_GET['search'] != ''){
				 $materialName=getNameById('material',$_GET['search'],'material_name');
				if($materialName->id == '' ){
					$where2 = "invoice.invoice_num like '%" .$_GET['search']. "%' or invoice.id like '%" .$_GET['search']. "%'";
				}elseif($materialName->id != ''){
					$json_dtl ='{"material_id" : "'.$materialName->id.'"}';
					$where2 = "invoice.descr_of_goods!='' AND json_contains(`descr_of_goods`, '".$json_dtl."')" ;
			}}
			
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
		//Pagination
			
		$config = array();
			$config["base_url"] = base_url() . "account/invoices/";
			$config["total_rows"] = $this->account_model->num_rows('invoice',$where,$where2);
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			
			$this->data['add_invoice_details']  = $this->account_model->get_invoice_details('invoice',$where, $config["per_page"], $page,$where2,$order,$export_data);
			
			$where2 = array('account_freeze.created_by_cid' => $created_by_id);
			$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
				if(!empty($this->uri->segment(3))){
					$frt = (int)$this->uri->segment(3) - 1;
					$start= $frt * $config['per_page']+1;
			   }else{
					$start= (int)$this->uri->segment(3) * $config['per_page']+1;
			   }
	   
		   if(!empty($this->uri->segment(3))){
			   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
		   }else{
			  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
		   }
		   
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
	
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		$this->_render_template('invoice/index', $this->data);
	
	}
	
	public function viewInvoice_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));			
			$this->load->view('invoice/view', $this->data);
		}	
	}
	public function viewInvoice_mat_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));			
			$this->load->view('invoice/mat_view', $this->data);
		}	
	}
	public function saleregister_view(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));			
			$this->load->view('saleregister/view', $this->data);
		}	
	}
	public function view_unpaid_invoice_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			//$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));
			$this->data['invoice_details_unpaid'] = $this->account_model->not_paid_purchase_bill('invoice',array('party_name'=> $_REQUEST['id']));	
			$this->load->view('accountreciveable/view_unpaid_invoices', $this->data);
		}	
	}
	
	public function editInvoice_details(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$this->uri->segment(3));	
			$this->data['docss'] = $this->account_model->get_image_byId('attachments', 'rel_id', $this->uri->segment(3),'invoice');		
			$this->_render_template('invoice/edit', $this->data);
		}else{
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');
				$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));	
				$this->data['docss'] = $this->account_model->get_image_byId('attachments', 'rel_id', $this->input->post('id'),'invoice');				
				$this->load->view('invoice/edit', $this->data);
			}
		}	
	}
	public function check_invoice_email(){
		$dataPdf['dataPdf'] = $this->account_model->get_data_byId('invoice','id',292);
		$this->load->view('invoice/invoice_pdf_email',$dataPdf);
	}
	public function Create_invoice(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Invoice Details', base_url() . 'Add Invoice');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Invoices Details';
		$this->_render_template('invoice/edit', $this->data);
	}
	
	public function saveInvoice_Details(){
		#pre($this->input->post());die;
		if ($this->input->post()) {
			
			// pre($_POST);die();
			//Check Party Credit Limit
			$party_Limit_Dtls = getNameById('ledger',$_POST['party_name'],'id');
			$party_amountDtls = $this->account_model->not_paid_InvoiceForLIMIT('invoice',array('party_name'=> $_POST['party_name']));
			$total_amtInvoce = 0;
			foreach($party_amountDtls as $partyAmtdtls){
				$DDueDdATe = $partyAmtdtls->due_date;
				$total_amtInvoce += $partyAmtdtls->total_amount;
			}
			
			
				$date_now = date("Y-m-d  00:00:00");
				if ($date_now > $party_Limit_Dtls->temp_crlimitDate) {
					$totalCreditAmt = $party_Limit_Dtls->purchaseLimit;
				}else{
					$totalCreditAmt = $party_Limit_Dtls->purchaseLimit + $party_Limit_Dtls->temp_credit_limit;
				}
				
				
				$TotalPurhaseAmt = $total_amtInvoce + $_POST['total_amout_with_tax_on_keyup'];
				$totalcredit_Blance = $totalCreditAmt - $TotalPurhaseAmt;
			
			 if($totalCreditAmt < $totalcredit_Blance  || $totalcredit_Blance < 0  || $totalcredit_Blance == 0){
					$this->session->set_flashdata('message', 'Party Credit Limit exceed Please Check' .' '.abs($totalcredit_Blance));
					redirect(base_url().'account/invoices', 'refresh');		 
				}
				
				
			// if($DDueDdATe > $date_now){
				// $this->session->set_flashdata('message', 'Please First Clear Pervious Bills');
				// redirect(base_url().'account/invoices', 'refresh');		
			// }
			//Check Party Credit Limit
			 $sec = strtotime( $_POST['date_time_of_invoice_issue']);  
			 $add_Date = date ("Y-m-d H:i", $sec); 
			 $data['date_time_of_invoice_issue'] = date ("Y-m-d H:i", $_POST['date_time_of_invoice_issue']);  
			 
		if($_POST['save_status'] == '1'){


			
			if($_POST['party_billing_state_id'] != $_POST['sale_company_state_id']){
				$_POST['CGST'] = '';
				 $_POST['SGST'] = '';
			}else{
				 $_POST['IGST'] = '';
			}
			$charges_tax = array_sum($_POST['amt_tax']);//ADD Charges and Discount Tax for add material Tax.
			if($_POST['CGST'] != '' && $_POST['SGST'] != '' ){
				$both_tax = $charges_tax / 2;
			}else{
				$both_tax = $charges_tax;
			}
			$usersWithViewPermissions = $this->account_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 31));
			$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i], 'tax' => $_POST['tax'][$i],'added_tax_Row_val'=> $_POST['added_tax_Row_val'][$i],'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i],'disctype'=>$_POST['disctype'][$i],'discamt'=>$_POST['discamt'][$i],'after_desc_amt'=>$_POST['after_desc_amt'][$i],'amount_with_tax_after_disco'=>$_POST['amount'][$i],'item_code'=>$_POST['item_code'][$i],'cess'=>$_POST['cess'][$i],'valuation_type'=>$_POST['valuation_type'][$i],'cess_tax_calculation'=>$_POST['cess_tax_calculation'][$i],'alterqty'=>$_POST['alterqty'][$i],'alterqtty'=>$_POST['alterqtty'][$i],'alterqtyuomid'=>$_POST['alterqtyuomid'][$i],'TotalQty'=>$_POST['TotalQty'][$i],'altuomcode'=>$_POST['altuomcode'][$i],'sale_amount'=>$_POST['sale_amount'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}			
				$get_mat_id_qty = json_decode($descr_of_goods_array);
				$get_mat_for_so = json_decode($descr_of_goods_array,TRUE);
				if(isset($_POST['convert_so_to_inv'])){
					    $sale_order_id = $_POST['so_id'];
			            $where = array('id' => $sale_order_id);
			            $SO_data = $this->account_model->get_data('sale_order', $where);
			            $matrial_jsonString = $SO_data[0]['product'];
			            $so_data1 = json_decode($matrial_jsonString, TRUE);
			            $updated_data_for_so = array();
			            $array_for_so = array();
			            $countSo1 = 0;
			            foreach($get_mat_for_so as $key => $so_item) {
			                foreach($so_data1 as $key => $so_data111) {
			                	#pre($so_data111);
			                    if ($so_item['material_id'] == $so_data111['product'] && $so_data111['remaning_qty'] != '0') {
			                       # echo "frfrfrfrfrfrf";
			                        $remaing_mat_qty = $so_data111['quantity'] - $so_item['quantity'];
			                        $array_for_so[] = array('material_type_id' => $so_data111['material_type_id'],'product' => $so_item['material_id'], 'description' => $so_item['description'],'quantity' => $so_data111['quantity'],'uom' => $so_item['UOM'], 'price' => $so_item['rate'], 'gst' => $so_item['tax'], 'individualTotal' => $so_item['amount'], 'individualTotalWithGst' => $so_item['amount_with_tax_after_disco'],'r_price'=> $so_data111['r_price'],'remaning_qty' => $remaing_mat_qty);
			                        $countPo1++;
			               		}else{
			               			#echo "wqwqwqqwqw";
			                        $array_for_so[] = array('material_type_id' => $so_data111['material_type_id'],'product' => $so_item['material_id'], 'description' => $so_item['description'],'quantity' => $so_data111['quantity'],'uom' => $so_item['UOM'], 'price' => $so_item['rate'], 'gst' => $so_item['tax'], 'individualTotal' => $so_item['amount'], 'individualTotalWithGst' => $so_item['amount_with_tax_after_disco'],'r_price'=> $so_data111['r_price'],'remaning_qty' => $so_data111['remaning_qty']);
			                        $countPo1++;
			               		}
           				 	}
           				 	$updated_data_for_so = $array_for_so;
				            $afterdata_sort_so = array_unique($updated_data_for_so, SORT_REGULAR);
				            $remaning_data_so = json_encode($afterdata_sort_so);
				            $this->account_model->update_sO_material_data('sale_order', $sale_order_id, $remaning_data_so); //When we create MRN through PI
				            /* Code used for when Purchase Indent Complete*/
				            $so_data_to_check_rem_qty = json_decode($matrial_jsonString, TRUE);
				            $rem_qty1 = 0;
				            $rm_QTY1 = array_count_values(array_column($afterdata_sort_so, 'remaning_qty')) [$rem_qty1];
				            $count221 = 0;
				            foreach ($so_data_to_check_rem_qty as $type) {
				                $count221+= count($type['remaning_qty']);
				            }
				            if ($rm_QTY1 == $count221) { //this Count Check material count is equal to material  qty
				                $this->account_model->update_so_single_data('sale_order', $sale_order_id); //INV_or_not
				                
				            }
				        }
				}
				#die;
				$invoice_price_totalLength = count($_POST['invoice_total_with_tax']);
					if($invoice_price_totalLength >0){ 
							$arra = [];
							$j = 0;
						while($j < $invoice_price_totalLength) {	
								$jsonArrayObject1 = array('total' =>$_POST['total'][$j],'totaltax' => $_POST['totaltax'][$j],'invoice_total_with_tax' => $_POST['invoice_total_with_tax'][$j],'cess_all_total' => $_POST['cess_all_total'][$j],'tds_tax' => $_POST['tds_tax'][$j]);
								$arra[$j] = $jsonArrayObject1;
								$j++;
							}
							$invoice_price_total_array = json_encode($arra);
						}else{
							$invoice_price_total_array = '';
						}
					//pre($invoice_price_total_array);die();
				$charges_Added_Count = 	count($_POST['charges_added']);
					if($charges_Added_Count > 0){
						$charg_Add = [];
						$ch = 0;
						while($ch < $charges_Added_Count){
							$jsonarray_chargeobj = (array('particular_charges_name'=>$_POST['particular_charges'][$ch],'type_charges'=>$_POST['type_charges'][$ch],'ledger_name'=>$_POST['ledger_name'][$ch],'ledger_name_id'=>$_POST['ledger_name_id'][$ch],'amt_tax'=>$_POST['amt_tax'][$ch],'charges_added'=>$_POST['charges_added'][$ch],'sgst_amt'=>$_POST['sgst_amt'][$ch],'cgst_amt'=>$_POST['cgst_amt'][$ch],'igst_amt'=>$_POST['igst_amt'][$ch],'amt_with_tax'=>$_POST['amt_with_tax'][$ch],'amount_of_charges'=>$_POST['amount_of_charges'][$ch]));
							$charg_Add[$ch] = $jsonarray_chargeobj;
							
							$ch++;
						}
						$json_charg_lead_total_array = json_encode($charg_Add);
					}else{
						$json_charg_lead_total_array = '';
					}
					
					$required_fields = array('party_name');	
					$is_valid = validate_fields($_POST, $required_fields);
					if (count($is_valid) > 0) {
						valid_fields($is_valid);				
					}else{	
				$data  = $this->input->post();
				$data['descr_of_goods'] = $descr_of_goods_array;	
				$data['invoice_total_with_tax'] = $invoice_price_total_array;	
				$data['charges_added'] = $json_charg_lead_total_array;	
				$data['date_time_of_invoice_issue'] = date("Y-m-d", strtotime($_POST['date_time_of_invoice_issue']));
				$data['due_date'] = date("Y-m-d h:m:s", strtotime($_POST['due_date']));
				// $data['disctype'] = $json_discount_added_array;	
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				//$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$data['created_by_cid'] = $this->companyGroupId;
				//pre($data);die();
				/******** Calculation of Due Date For Party invice ***************/
					$partyData = getNameById('ledger',$_POST['party_name'],'id');
					
					if($partyData->due_days != 0){
						$due_date =  date('Y-m-d h:m', strtotime($_POST['date_time_of_invoice_issue']. ' + '.$partyData->due_days.' days')); /// result
						$data['due_date'] = $due_date;
					}else{
						$data['due_date'] =  '';
					}
					
				//$data['sales_person'] = $partyData->sales_person;
				$id = $data['id'];
				
				//Assign sales Person
				$salesPersonArr = $party_Limit_Dtls->salesPersons;
				if(!empty($salesPersonArr)){
				$jsondecode = json_decode($salesPersonArr);
					if (in_array($data['sales_person'], $jsondecode)) {
						$spersondata = json_encode($jsondecode);
					}else{
						array_push($jsondecode, $data['sales_person']);
						$spersondata = json_encode($jsondecode);
					}
				}else{
					$firstTimeArr = array($data['sales_person']);
					$spersondata = json_encode($firstTimeArr);
				}	
				$this->account_model->update_salesPersonjson($spersondata,$_POST['party_name']);			
			//Assign sales Person	
				/******** Calculation of Due Date For Party invice ***************/
				//$check_invoice_num = $this->account->invoiceExist($_POST['invoice_num']);
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$data['created_by_cid'] = $this->companyGroupId;
					if($data['accept_reject'] !='' && $data['reject_invoice'] !='' ){
						$data['accept_reject'] = '';
						//pre($data);die('1');
						$success = $this->account_model->update_data('invoice',$data, 'id', $id);
						
					}else{	
					
						 $success = $this->account_model->update_data('invoice',$data, 'id', $id);
					}
					/***************** For Transaction Table Update*********************/
					if(!empty($_FILES['file_attachment']['name']) && $_FILES['file_attachment']['name'][0]!=''){
								$docs_array = array();
								$docCount = count($_FILES['file_attachment']['name']);
								for($i = 0; $i < $docCount; $i++){
									$filename     = $_FILES['file_attachment']['name'][$i];
									$tmpname     = $_FILES['file_attachment']['tmp_name'][$i];               
									$type     = $_FILES['file_attachment']['type'][$i];               
									$error    = $_FILES['file_attachment']['error'][$i];
									$size    = $_FILES['file_attachment']['size'][$i];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext; 
									$config['upload_path'] = 'assets/modules/account/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000'; 
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);				
									$docs_array[$i]['rel_id'] = $id;
									$docs_array[$i]['rel_type'] = 'invoice';
									$docs_array[$i]['file_name'] = $newname;
									$docs_array[$i]['file_type'] = $type;
								}
								if(!empty($docs_array)){
							/* Insert file information into the database */
							$docsAttachmentID = $this->account_model->insert_attachment_data('attachments', $docs_array, $id);
							}  
						}
					
					
					// if($_POST['total_amout_without_tax_on_keyup'] != ''){
						// $debit_data['debit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					// }
					$ledger_id = $_REQUEST['sale_ledger'];
					$debit_data['credit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$debit_data['type'] = 'invoice';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    //$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 1;
					$debit_data['add_date'] = $add_Date;
					
					$this->account_model->update_transaction_data_chk('transaction_dtl',$debit_data, 'type_id', $id, 'invoice',$ledger_id);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['credit_dtl'] = '0';
					$ledger_id = $_POST['party_name'];
					if($_POST['total_amout_with_tax_on_keyup'] !=''){
					 $credit_data['debit_dtl'] = $_POST['total_amout_with_tax_on_keyup'];
					}
					$credit_data['type'] = 'invoice';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$credit_data['cancel_restore'] = 1;
					
					$this->account_model->update_transaction_data_chk('transaction_dtl',$credit_data, 'type_id', $id, 'invoice',$ledger_id);
					
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($_POST['CGST'] !=''){
								
								$ledger_id = '2';
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['credit_dtl'] = $_POST['CGST'] + $both_tax ;
								$CGST_data['type'] = 'invoice';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								//$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$CGST_data['cancel_restore'] = 1;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$CGST_data, 'type_id', $id, 'invoice',$ledger_id);
							}
							
							if($_POST['SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$ledger_id = '3';
								$SGST_data['credit_dtl'] = $_POST['SGST'] + $both_tax ;
								$SGST_data['type'] = 'invoice';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 1;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$SGST_data, 'type_id', $id, 'invoice',$ledger_id);
							}
							
							if($_POST['IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$ledger_id = '1';
								$IGST_data['credit_dtl'] = $_POST['IGST'] + $both_tax ;
								$IGST_data['type'] = 'invoice';
								$IGST_data['type_id'] = $id;
								$IGST_data['cancel_restore'] = 1;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								//$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$IGST_data, 'type_id', $id, 'invoice',$ledger_id);
							}
							
					/* For CGST SGST IGST Table*/
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					$ddt =	json_decode($json_charg_lead_total_array, true);
					
				if($ddt[0]['particular_charges_name'] != ''){
						$charges_Discount_data = json_decode($json_charg_lead_total_array,true);
						foreach($charges_Discount_data as $chrg_data){
							if(!empty($chrg_data)){
							if($chrg_data['type_charges'] == 'plus'){
								
								$charges_Data['debit_dtl'] = '0';
								$charges_Data['credit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['add_date'] = $add_Date;
								$charges_Data['cancel_restore'] = 1;
								$this->account_model->update_single_data_for_charges($chrg_data['amt_with_tax'], $id,'invoice');//USd to add Charges in Per invoice 
								$this->account_model->update_transaction_data_chk('transaction_dtl',$charges_Data, 'type_id', $id, 'invoice',$chrg_data['ledger_name_id']);
							}else{
								$charges_Data['debit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['credit_dtl'] = '0';
								$charges_Data['add_date'] = $add_Date;
								$charges_Data['cancel_restore'] = 1;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$charges_Data, 'type_id', $id, 'invoice',$chrg_data['ledger_name_id']);	
							}
						}
						}		
					}
					/***************** For Transaction Table Update*********************/
					
					/* Inventory Flow*/
					if(!empty($data) && $data['descr_of_goods'] !=''){
						$inventoryFlowData = json_decode($data['descr_of_goods']);
						$inventoryFlowDataArray = [];
						$inCount = 0;
						foreach($inventoryFlowData as $key => $item) {
							$inventoryFlowDataArray['material_id'] =  $item->material_id;
							$inventoryFlowDataArray['material_out'] =  $item->quantity;
							$inventoryFlowDataArray['uom'] =  $item->UOM;
							$inventoryFlowDataArray['through'] =  'Invoice';
							$inventoryFlowDataArray['ref_id'] =  $id;
							
							// $get_Data  = $this->account_model->get_previous_inventery_flow_data('inventory_flow',$item->material_id,$id,'Invoice');
							// pre($get_Data);
							//pre($inventoryFlowDataArray);die('Inventory');
							
							$this->account_model->update_inventery_mat_details('inventory_flow',$item->material_id,$id,$inventoryFlowDataArray);
							$inCount++;
						}		


					}
					
					/* Inventory Flow*/
					//die('ACCHA');
						
					if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'Invoice updated' , 'message' => 'Invoice is updated by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_invoice_details','data_id' => 'invoice_view_details' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'Invoice updated' , 'message' => 'Invoice is updated by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'add_invoice_details','data_id' => 'invoice_view_details','icon'=>'fa-shopping-cart'));
						} 
					
					if ($success) {
                        $data['message'] = "Invoice updated successfully";
                        logActivity('Invoice  Updated','invoice',$id);
                        $this->session->set_flashdata('message', 'Invoice Details Updated successfully');
					    redirect(base_url().'account/invoices', 'refresh');
                    }
				}else{
					
					$check_invoice_num = $this->account_model->invoiceExist($_POST['invoice_num']);
					if(empty($check_invoice_num)){
				/*Product Details Inventory Process*/
					// $saleLedger_addresschk = getNameById('company_address',$_POST['sale_lger_brnch_id'],'compny_branch_id');
					// $locationIds = $saleLedger_addresschk->id;
					// foreach($get_mat_id_qty as $for_decrease_qty){
					// $mat_idd = $for_decrease_qty->material_id;
					// $mat_qqty = $for_decrease_qty->quantity;
					// $get_dataa = $this->account_model->get_matrial_qty_invoice('mat_locations',$mat_idd,$locationIds);
					// $remaining_qty =  $get_dataa['quantity'] - $mat_qqty;
					// $this->account_model->update_matrial_qty_invoice('material',$mat_idd,$remaining_qty,$locationIds);
					// }
					
				/*Product Details Inventory Process*/	
				
				//pre($data); 
				
				$salesPersonArr = $party_Limit_Dtls->salesPersons;
				$jsondecode = json_decode($salesPersonArr);
					if (in_array($data['sales_person'], $jsondecode)) {
						$spersondata = json_encode($jsondecode);
					}else{
						array_push($jsondecode, $data['sales_person']);
						$spersondata = json_encode($jsondecode);
					}
				$this->account_model->update_salesPersonjson($spersondata,$_POST['party_name']);
				
				//die('2');
				
					$id = $this->account_model->insert_tbl_data('invoice',$data);

					/* Inventory Flow*/
					if(!empty($data) && $data['descr_of_goods'] !=''){
						$inventoryFlowData = json_decode($data['descr_of_goods']);
						
						$inventoryFlowDataArray = [];
						$inCount = 0;
						$closingblcn = 0;
						$saleLedger_addresschk = getNameById('company_address',$_POST['sale_lger_brnch_id'],'compny_branch_id');
						$locationIds = $saleLedger_addresschk->id;
						foreach($inventoryFlowData as $key => $item) {
							$getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' =>$item->material_id));
							foreach($getAddres as $loc1){
                                     $arr[] =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] , 'quantity' => $item->quantity , 'Qtyuom' => $item->UOM)));
                                     $rt++;
                                 }

                            	 $yu = getNameById_mat('mat_locations',$item->material_id,'material_name_id');
                                 $sum = 0;
                                 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}

                            $closingblcn = $sum - $item->quantity;
                            $inventoryFlowDataArray['current_location'] = $arr[$i];     
							$inventoryFlowDataArray['material_id'] =  $item->material_id;
							$inventoryFlowDataArray['material_out'] =  $item->quantity;
							$inventoryFlowDataArray['opening_blnc'] = $sum;
                            $inventoryFlowDataArray['closing_blnc'] = $closingblcn;
							$inventoryFlowDataArray['uom'] =  $item->UOM;
							$inventoryFlowDataArray['material_type_id'] =  $loc1['material_type_id'];

							$inventoryFlowDataArray['through'] =  'Invoice';
							$inventoryFlowDataArray['ref_id'] =  $id;
							$inventoryFlowDataArray['created_by'] =  $_SESSION['loggedInUser']->id;
							//$inventoryFlowDataArray['created_by_cid'] =  $_SESSION['loggedInUser']->c_id;
							$inventoryFlowDataArray['created_by_cid'] =  $this->companyGroupId;

							#pre($inventoryFlowDataArray);die;
							$this->account_model->insert_tbl_data('inventory_flow',$inventoryFlowDataArray);
							#pre($item);		
							$inCount++;
							$getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' => $item->material_id,'location_id'=>$locationIds));
					
							foreach ($getAddres as & $values) {
								if ($values['material_name_id'] == $item->material_id) {
									$updatedQty = $values['quantity'] - $item->quantity;
									$values['quantity'] = $updatedQty;
									$success = $this->account_model->update_single_field('mat_locations', $values, $item->material_id);
									break;
								}
							}
						}
					}
					/* Inventory Flow*/
					/* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_REQUEST['sale_ledger'];
					$debit_data['credit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$debit_data['type'] = 'invoice';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 1;
					$debit_data['add_date'] = $add_Date;
						$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['total_amout_with_tax_on_keyup'];
					// $credit_data['debit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$credit_data['ledger_id'] = $_POST['party_name'];
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'invoice';
					$credit_data['cancel_restore'] = 1;
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
				    //$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
					
					
					
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($_POST['CGST'] !=''){
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = $_POST['CGST'] + $both_tax ;
								$CGST_data['type'] = 'invoice';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								$CGST_data['type_id'] = $id;
								$CGST_data['cancel_restore'] = 1;
								$CGST_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
								//$tax = array('CGST'=> $_POST['CGST']);
							}
							
							if($_POST['SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = $_POST['SGST'] + $both_tax ;
								$SGST_data['type'] = 'invoice';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 1;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($_POST['IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = $_POST['IGST'] + $both_tax ;
								$IGST_data['type'] = 'invoice';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['cancel_restore'] = 1;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
					/* For CGST SGST IGST Table*/
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					$ddt =	json_decode($json_charg_lead_total_array, true);
				if($ddt[0]['particular_charges_name'] != ''){
					
						$charges_Discount_data = json_decode($json_charg_lead_total_array,true);
						foreach($charges_Discount_data as $chrg_data){
						if(!empty($chrg_data)){	
							if($chrg_data['type_charges'] == 'plus'){
								$charges_Data['debit_dtl'] = '0';
								$charges_Data['ledger_id'] = $chrg_data['ledger_name_id'];
								$charges_Data['credit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['type'] = 'invoice';
								$charges_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$charges_Data['created_by_cid'] = $this->companyGroupId;
								$charges_Data['type_id'] = $id;
								$charges_Data['add_date'] = $add_Date;
								$charges_Data['cancel_restore'] = 1;
								$this->account_model->update_single_data_for_charges($chrg_data['amt_with_tax'], $id,'invoice');//USd to add Charges in Per invoice 
								$this->account_model->insert_tbl_data('transaction_dtl',$charges_Data);
							}else{
								$charges_Data['debit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['ledger_id'] = $chrg_data['ledger_name_id'];
								$charges_Data['credit_dtl'] = '0';
								$charges_Data['type'] = 'invoice';
								$charges_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$charges_Data['created_by_cid'] = $this->companyGroupId;
								$charges_Data['type_id'] = $id;
								$charges_Data['add_date'] = $add_Date;
								$charges_Data['cancel_restore'] = 1;
								$this->account_model->insert_tbl_data('transaction_dtl',$charges_Data);
							}
							}
						}
							
					}
					
					
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					
					
							
						
					if(!empty($_FILES['file_attachment']['name']) && $_FILES['file_attachment']['name'][0]!=''){
								$docs_array = array();
								$docCount = count($_FILES['file_attachment']['name']);
								for($i = 0; $i < $docCount; $i++){
									$filename     = $_FILES['file_attachment']['name'][$i];
									$tmpname     = $_FILES['file_attachment']['tmp_name'][$i];               
									$type     = $_FILES['file_attachment']['type'][$i];               
									$error    = $_FILES['file_attachment']['error'][$i];
									$size    = $_FILES['file_attachment']['size'][$i];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext; 
									$config['upload_path'] = 'assets/modules/account/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000'; 
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);				
									$docs_array[$i]['rel_id'] = $id;
									$docs_array[$i]['rel_type'] = 'invoice';
									$docs_array[$i]['file_name'] = $newname;
									$docs_array[$i]['file_type'] = $type;
								}
								if(!empty($docs_array)){
							/* Insert file information into the database */
							$docsAttachmentID = $this->account_model->insert_attachment_data('attachments', $docs_array, $id);
							}  
						}
						
							
															
					if ($id) {
						
						$company_email_Settings = $this->account_model->get_data('company_detail',array('id'=> $_SESSION['loggedInUser']->c_id));
						if($company_email_Settings[0]['email_send_setting'] == 'email_send' || $company_email_Settings[0]['email_send_setting'] == '' ){	
					    $email_id = $data['email'];
						}else{
							$email_id = '';
						}

						
						$party_name = getNameById('ledger',$data['party_name'],'id');
						$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<meta name="viewport" content="width=device-width" />
							</head>
							<body style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 40px 0;" bgcolor="#efefef">
								<table class="body-wrap text-center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef">
									<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
												<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
													<td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="'.base_url().'assets/modules/company/uploads/'.$_SESSION['loggedInCompany']->logo.'" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 20%; display: block; margin: 0 auto; padding: 0;" /></td>
												</tr>';    
										
								$footer = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
											<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
												<td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">							
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="'. base_url() .'" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Support: dev@lastingerp.com</p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Phase 1 Industrial Area Panchkula Plot No 39, India - 134109</p>
												</td>
											</tr>
										</table>
										</td>
									</tr>
								</table>
							</body>
						</html>';
						$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
															<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$party_name->name.',</p>								
																
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Message '.$data['message_for_email'].'</p>	
															</td>
														</tr>
													</table>
												</td>
											</tr>';	
						$messageContent = $header.$email_message.$footer;

	
					ini_set('memory_limit', '20M');
						$this->load->library('Pdf');
						$this->load->library('email');
						$dataPdf['dataPdf'] = $this->account_model->get_data_byId('invoice','id',$id);
						
						$html = $this->load->view('invoice/invoice_pdf_email',$dataPdf, true);
						
						
						
						
					    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
							$pdf->SetCreator(PDF_CREATOR);
							$pdf->AddPage();
						
						$pdfFilePath = FCPATH . "assets/modules/account/pdf_invoice/pdf_invoice.pdf";
						
						$pdf->WriteHTML($html);
						
						//pre($ddddf);die('chk Pdf');
						
						$pdf->Output($pdfFilePath, "F");
						$this->email->attach($pdfFilePath);
						
						    $this->load->library('email');
							$config['mailtype'] = 'html';
							$this->email->initialize($config);
							$this->email->to($email_id);
							$this->email->from('admin@lastingerp.com', "Lasting ERP Team");
							$this->email->subject("Invoice");
						
						 if(!empty($docs_array)){ 
							  foreach($docs_array as $key => $value){
								$attched_file = $_SERVER['DOCUMENT_ROOT'] . "/assets/modules/account/uploads/".$value['file_name'];
								$this->email->attach($attched_file);
							}
							
						 }  
						 $this->email->message($messageContent);
						
						 $data['message'] = "Sorry Unable to send email..."; 
						  if($this->email->send()){     
						   $data['message'] = "Mail sent...";  
							unlink($pdfFilePath);
						  }
							  
						  
						  #die();
						 
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'New Invoice created' , 'message' => 'New Invoice is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_invoice_details','data_id' => 'invoice_view_details' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'New Invoice created' , 'message' => 'New Invoice is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'add_invoice_details','data_id' => 'invoice_view_details','icon'=>'fa-shopping-cart'));
						}  
						  
						  
						  
						  
						  
						  
						  

                        logActivity('New Invoice Created','invoice',$id);
                        $this->session->set_flashdata('message', 'Invoice Details inserted successfully');
					    redirect(base_url().'account/invoices', 'refresh');
                    }
					}else{
						$this->session->set_flashdata('message', 'Invoice  Number is  Already exists');
						redirect(base_url().'account/invoices', 'refresh');
						} 
					}
				
			}
		 }//Save not draft 
		 if($_POST['save_status'] == '0'){//This code Is used to Save as Drafts
			$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i], 'tax' => $_POST['tax'][$i] ,'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i],'disctype'=>$_POST['disctype'][$i],'discamt'=>$_POST['discamt'][$i],'after_desc_amt'=>$_POST['after_desc_amt'][$i],'amount_with_tax_after_disco'=>$_POST['amount'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}
				
				//pre($descr_of_goods_array);die();
				$get_mat_id_qty = json_decode($descr_of_goods_array);
				
				
			
				$invoice_price_totalLength = count($_POST['invoice_total_with_tax']);
					if($invoice_price_totalLength >0){ 
							$arra = [];
							$j = 0;
						while($j < $invoice_price_totalLength) {	
								$jsonArrayObject1 = (array('total' =>$_POST['total'][$j],'totaltax' => $_POST['totaltax'][$j],'invoice_total_with_tax' => $_POST['invoice_total_with_tax'][$j]));
								$arra[$j] = $jsonArrayObject1;
								$j++;
							}
							$invoice_price_total_array = json_encode($arra);
						}else{
							$invoice_price_total_array = '';
						}
						
				$charges_Added_Count = 	count($_POST['charges_added']);
					
					if($charges_Added_Count > 0){
						$charg_Add = [];
						$ch = 0;
						while($ch < $charges_Added_Count){
							$jsonarray_chargeobj = (array('particular_charges_name'=>$_POST['particular_charges'][$ch],'charges_added'=>$_POST['charges_added'][$ch],'sgst_amt'=>$_POST['sgst_amt'][$ch],'cgst_amt'=>$_POST['cgst_amt'][$ch],'igst_amt'=>$_POST['igst_amt'][$ch],'amt_with_tax'=>$_POST['amt_with_tax'][$ch]));
							$charg_Add[$ch] = $jsonarray_chargeobj;
							$ch++;
						}
						$json_charg_lead_total_array = json_encode($charg_Add);
					}else{
						$json_charg_lead_total_array = '';
					}
					
					$required_fields = array('sale_ledger','party_name');	
					$is_valid = validate_fields($_POST, $required_fields);
					if (count($is_valid) > 0) {
						valid_fields($is_valid);				
					}else{
					
				$data  = $this->input->post();
				$data['descr_of_goods'] = $descr_of_goods_array;	
				$data['invoice_total_with_tax'] = $invoice_price_total_array;	
				$data['charges_added'] = $json_charg_lead_total_array;	
				// $data['disctype'] = $json_discount_added_array;	
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$id = $data['id'];
				
				//$check_invoice_num = $this->account->invoiceExist($_POST['invoice_num']);
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					if($data['accept_reject'] !='' && $data['reject_invoice'] !='' ){
						$data['accept_reject'] = '';
						$success = $this->account_model->update_data('invoice',$data, 'id', $id);
						
					}else{	
						 $success = $this->account_model->update_data('invoice',$data, 'id', $id);
					}
				
					
					if ($success) {
                        $data['message'] = "Invoice updated successfully";
                        logActivity('Invoice  Updated','invoice',$id);
                        $this->session->set_flashdata('message', 'Invoice Details Updated successfully');
					    redirect(base_url().'account/invoices', 'refresh');
                    }
				}else{
					
					$check_invoice_num = $this->account_model->invoiceExist($_POST['invoice_num']);
					if(empty($check_invoice_num)){
				/*Product Details Inventory Process*/
					// $saleLedger_addresschk = getNameById('company_address',$_POST['sale_lger_brnch_id'],'compny_branch_id');
					// $locationIds = $saleLedger_addresschk->id;
					// foreach($get_mat_id_qty as $for_decrease_qty){
					// $mat_idd = $for_decrease_qty->material_id;
					// $mat_qqty = $for_decrease_qty->quantity;
					// $get_dataa = $this->account_model->get_matrial_qty_invoice('material',$mat_idd,$locationIds);
					// $remaining_qty =  $get_dataa['closing_balance'] - $mat_qqty;
					// $this->account_model->update_matrial_qty_invoice('material',$mat_idd,$remaining_qty,$locationIds);
					// }
				/*Product Details Inventory Process*/	
				
					$id = $this->account_model->insert_tbl_data('invoice',$data);
					
					
		if($_POST['save_status'] == 0){
		
				/* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_REQUEST['sale_ledger'];
					$debit_data['credit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$debit_data['type'] = 'invoice';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 0;
					$debit_data['add_date'] = $add_Date;
						$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					//pre($debit_data);die();
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['total_amout_with_tax_on_keyup'];
					// $credit_data['debit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$credit_data['ledger_id'] = $_POST['party_name'];
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'invoice';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
				    //$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['cancel_restore'] = 0;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
					
					
					
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($_POST['CGST'] !=''){
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = $_POST['CGST'] + $both_tax ;
								$CGST_data['type'] = 'invoice';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$CGST_data['cancel_restore'] = 0;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
								//$tax = array('CGST'=> $_POST['CGST']);
							}
							
							if($_POST['SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = $_POST['SGST'] + $both_tax ;
								$SGST_data['type'] = 'invoice';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 0;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($_POST['IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = $_POST['IGST'] + $both_tax ;
								$IGST_data['type'] = 'invoice';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['cancel_restore'] = 0;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
			}
					if(!empty($_FILES['file_attachment']['name']) && $_FILES['file_attachment']['name'][0]!=''){
								$docs_array = array();
								$docCount = count($_FILES['file_attachment']['name']);
								for($i = 0; $i < $docCount; $i++){
									$filename     = $_FILES['file_attachment']['name'][$i];
									$tmpname     = $_FILES['file_attachment']['tmp_name'][$i];               
									$type     = $_FILES['file_attachment']['type'][$i];               
									$error    = $_FILES['file_attachment']['error'][$i];
									$size    = $_FILES['file_attachment']['size'][$i];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext; 
									$config['upload_path'] = 'assets/modules/account/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000'; 
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);				
									$docs_array[$i]['rel_id'] = $id;
									$docs_array[$i]['rel_type'] = 'invoice';
									$docs_array[$i]['file_name'] = $newname;
									$docs_array[$i]['file_type'] = $type;
								}
								if(!empty($docs_array)){
							/* Insert file information into the database */
							$docsAttachmentID = $this->account_model->insert_attachment_data('attachments', $docs_array, $id);
							}  
						}
						
							
															
					if ($id) {
                        logActivity('New Invoice Created','invoice',$id);
                        $this->session->set_flashdata('message', 'Invoice Details Added as Drafts successfully');
					    // redirect(base_url().'account/Create_invoice', 'refresh');
					   redirect(base_url().'account/invoices', 'refresh');
                    }
					}else{
						$this->session->set_flashdata('message', 'Invoice  Number is  Already exists');
						// redirect(base_url().'account/Create_invoice', 'refresh');
						redirect(base_url().'account/invoices', 'refresh');
						} 
				}
			
		}
	 }//Save
	
   }
}

/*Create Accounting Invoice Code*/
public function accountingviewInvoice(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['accounting_data'] = $this->account_model->get_data_byId('tbl_accounting_invoice','id',$this->input->post('id'));			
			$this->load->view('accounting_invoice/view', $this->data);
		}	
	}
		public function Create_accounting_invoice(){
				$this->data['can_edit'] = edit_permissions();
				$this->data['can_delete'] = delete_permissions();
				$this->data['can_add'] = add_permissions();
				$this->breadcrumb->add('Accounting Invoice Details', base_url() . 'Add Accounting Invoice');
				$this->settings['breadcrumbs'] = $this->breadcrumb->output();
				$this->settings['pageTitle'] = 'Accounting Invoice Details';  
				$this->_render_template('accounting_invoice/edit', $this->data);
			}
		public function saveAccounting_Invoice_Details(){
			if ($this->input->post()) {
				
				$sec = strtotime( $_POST['date_time_of_invoice_issue']);  
				$add_Date = date ("Y-m-d H:i", $sec); 
				if($_POST['save_status'] == '1'){
					$id = $_POST['id'];
					$data  = $this->input->post();
					$data['date_time_of_invoice_issue'] = date("Y-m-d", strtotime($_POST['date_time_of_invoice_issue']));
					
					
					$data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$data['created_by_cid'] = $this->companyGroupId;
					if($id && $id != ''){
						$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
						$data['created_by_cid'] = $this->companyGroupId;
						$success = $this->account_model->update_data('tbl_accounting_invoice',$data, 'id', $id);
				
					$ledger_id = $_REQUEST['sale_ledger'];
					$debit_data['credit_dtl'] =  $_POST['added_amt'];
					$debit_data['type'] = 'accountinginvoice';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    //$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 1;
					$debit_data['add_date'] = $add_Date;
					
					$this->account_model->update_transaction_data_chk('transaction_dtl',$debit_data, 'type_id', $id, 'accountinginvoice',$ledger_id);
					/* For Sale Ledger Details data*/
					$withtaxamt = $_POST['added_amt'] + $_POST['totaltaxAMT'];
					/* For Purchase Ledger Details data*/
					$credit_data['credit_dtl'] = '0';
					$ledger_id = $_POST['party_name'];
					
					 $credit_data['debit_dtl'] = $withtaxamt;
				
					$credit_data['type'] = 'accountinginvoice';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$credit_data['cancel_restore'] = 1;
					
					$this->account_model->update_transaction_data_chk('transaction_dtl',$credit_data, 'type_id', $id, 'accountinginvoice',$ledger_id);
					
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($_POST['CGST'] !=''){
								
								$ledger_id = '2';
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['credit_dtl'] = $_POST['CGST'];
								$CGST_data['type'] = 'accountinginvoice';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								//$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$CGST_data['cancel_restore'] = 1;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$CGST_data, 'type_id', $id, 'accountinginvoice',$ledger_id);
							}
							
							if($_POST['SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$ledger_id = '3';
								$SGST_data['credit_dtl'] = $_POST['SGST'] ;
								$SGST_data['type'] = 'accountinginvoice';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 1;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$SGST_data, 'type_id', $id, 'accountinginvoice',$ledger_id);
							}
							
							if($_POST['IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$ledger_id = '1';
								$IGST_data['credit_dtl'] = $_POST['IGST'];
								$IGST_data['type'] = 'accountinginvoice';
								$IGST_data['type_id'] = $id;
								$IGST_data['cancel_restore'] = 1;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								//$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$IGST_data, 'type_id', $id, 'accountinginvoice',$ledger_id);
							}
						if ($success) {
								$data['message'] = "Invoice updated successfully";
								logActivity('Invoice  Updated','tbl_accounting_invoice',$id);
								$this->session->set_flashdata('message', 'Accounting Invoice Details Updated successfully');
								redirect(base_url().'account/accounting_invoice', 'refresh');
							}
					}else{	
							
						
						
						$id = $this->account_model->insert_tbl_data('tbl_accounting_invoice',$data);
					/* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_REQUEST['sale_ledger'];
					$debit_data['credit_dtl'] = $_POST['added_amt'];
					$debit_data['type'] = 'accountinginvoice';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 0;
					$debit_data['add_date'] = $add_Date;
						$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					//pre($debit_data);die();
					/* For Purchase Ledger Details data*/
					$withtaxamt = $_POST['added_amt'] + $_POST['totaltaxAMT'];
					$credit_data['debit_dtl'] = $withtaxamt;
					// $credit_data['debit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$credit_data['ledger_id'] = $_POST['party_name'];
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'accountinginvoice';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
				    //$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['cancel_restore'] = 0;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
				
					
					/* For CGST SGST IGST Table*/
							if($_POST['CGST'] !=''){
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = $_POST['CGST'];
								$CGST_data['type'] = 'accountinginvoice';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$CGST_data['cancel_restore'] = 0;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
								//$tax = array('CGST'=> $_POST['CGST']);
							}
							
							if($_POST['SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = $_POST['SGST'];
								$SGST_data['type'] = 'accountinginvoice';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 0;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($_POST['IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = $_POST['IGST'];
								$IGST_data['type'] = 'accountinginvoice';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['cancel_restore'] = 0;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
							logActivity('New Invoice Created','tbl_accounting_invoice',$id);
							$this->session->set_flashdata('message', 'Accounting Invoice Details inserted successfully');
							redirect(base_url().'account/accounting_invoice', 'refresh');
						}
				}
				if($_POST['save_status'] == '0'){
					$data['date_time_of_invoice_issue'] = date("Y-m-d", strtotime($_POST['date_time_of_invoice_issue']));
					$data  = $this->input->post();
					$data['created_by'] = $_SESSION['loggedInUser']->u_id;
					$data['created_by_cid'] = $this->companyGroupId;
					
					$id = $this->account_model->insert_tbl_data('tbl_accounting_invoice',$data);
					/* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_REQUEST['sale_ledger'];
					$debit_data['credit_dtl'] = $_POST['added_amt'];
					$debit_data['type'] = 'accountinginvoice';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 0;
					$debit_data['add_date'] = $add_Date;
						$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					//pre($debit_data);die();
					/* For Purchase Ledger Details data*/
					$withtaxamt = $_POST['added_amt'] + $_POST['totaltaxAMT'];
					$credit_data['debit_dtl'] = $withtaxamt;
					// $credit_data['debit_dtl'] = $_POST['total_amout_without_tax_on_keyup'];
					$credit_data['ledger_id'] = $_POST['party_name'];
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'accountinginvoice';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
				    //$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['cancel_restore'] = 0;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
				
					
					/* For CGST SGST IGST Table*/
							if($_POST['CGST'] !=''){
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = $_POST['CGST'];
								$CGST_data['type'] = 'accountinginvoice';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date;
								$CGST_data['cancel_restore'] = 0;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
								//$tax = array('CGST'=> $_POST['CGST']);
							}
							
							if($_POST['SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = $_POST['SGST'];
								$SGST_data['type'] = 'accountinginvoice';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 0;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($_POST['IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = $_POST['IGST'];
								$IGST_data['type'] = 'accountinginvoice';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['cancel_restore'] = 0;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
						logActivity('New Invoice Created','tbl_accounting_invoice',$id);
						$this->session->set_flashdata('message', 'Accounting Invoice Details inserted successfully');
						redirect(base_url().'account/accounting_invoice', 'refresh');
					
				}
			}	
		}	
public function deleteaccInvoice_details($id = ''){	
		if (!$id) {
           redirect('account/accounting_invoice', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('tbl_accounting_invoice','id',$id);
	    // $this->account_model->delete_inventery_mat_details('inventory_flow',$id, 'invoice');
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'accountinginvoice');
		if($result){
			logActivity('Invoice Details Deleted','tbl_accounting_invoice',$id);
			$this->session->set_flashdata('message', 'Invoice Details Deleted Successfully');
			$result = array('msg' => 'Invoice Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/accounting_invoice');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
public function create_pdfacc($id = ''){
		$this->load->library('Pdf');
		$dataPdf['dataPdf'] = $this->account_model->get_data_byId('tbl_accounting_invoice','id',$id);
     	$this->load->view('accounting_invoice/genpdf',$dataPdf);	
		//$this->_render_template('purchase_order/view_pdf', $this->data);
		
	}
public function accounting_invoice() { 

	$this->load->library('pagination');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Accounting Invoice Details', base_url() . 'Add Invoice');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Accounting Invoice Details';
		//$created_by_id  = $_SESSION['loggedInUser']->c_id;
		$created_by_id  = $this->companyGroupId;
		$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$created_by_id);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			
			if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date('Y-m-d', $second_date22);
					}
				}
				$original_Date_start = $_GET['start'];
				$cnvrted_newDate_Start = date("Y-m-d", strtotime($original_Date_start));
				$original_Date_end = $_GET['end'];
				$cnvrted_newDate_end = date("Y-m-d", strtotime($original_Date_end));
	//	pre($_GET);
		$where=array('created_by_cid'=> $created_by_id,'tbl_accounting_invoice.created_date >=' =>$first_date, 'tbl_accounting_invoice.created_date <=' => $second_date);	
		

		if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
		
			$where = array('created_by_cid'=> $created_by_id,'tbl_accounting_invoice.date_time_of_invoice_issue >=' =>$first_date, 'tbl_accounting_invoice.date_time_of_invoice_issue <=' => $second_date);
			
		}elseif(isset($_GET['start'])!='' &&  isset($_GET['end'])!='' && isset($_GET["ExportType"])){
		
			$where = "tbl_accounting_invoice.created_by_cid = ".$created_by_id." AND  (tbl_accounting_invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  tbl_accounting_invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')";
		}elseif($_GET['selected_branch_idd'] != '' &&  $_GET['start'] == '' && $_GET['end'] == '' && $_GET['selected_branch_idd'] != 'All' ){
		
				$where = array('tbl_accounting_invoice.sale_lger_brnch_id =' => $_GET['selected_branch_idd'], 'tbl_accounting_invoice.created_by_cid'=> $this->companyGroupId);
			
		}elseif($_GET['start'] != ''  && $_GET['end'] != '' && $_GET['selected_branch_idd'] != ''){
		//echo 'There';
			$where = "tbl_accounting_invoice.created_by_cid = ".$this->companyGroupId." AND  (tbl_accounting_invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  tbl_accounting_invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')AND tbl_accounting_invoice.sale_lger_brnch_id=".$_GET['selected_branch_idd'];
		}elseif($_GET['selected_branch_idd'] == 'All' &&  $_GET['start'] == '' && $_GET['end'] == '') {
			$where = array('tbl_accounting_invoice.created_by_cid'=> $this->companyGroupId);
		}elseif($_GET['start'] !='' &&  $_GET['end']!='' && $_GET["ExportType"] ==''){
		
			$where = "tbl_accounting_invoice.created_by_cid = ".$created_by_id." AND  (tbl_accounting_invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  tbl_accounting_invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')";
		}
		//Search
		
		$where2='';
		$search_string = '';
		if(!empty($_GET['search'])){
			
				$search_string = $_GET['search'];
				
					$where2 = "tbl_accounting_invoice.invoice_num like '%" . $search_string . "%' or tbl_accounting_invoice.id like '%" .$search_string. "%'";
			
        }
			
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
		//Pagination
			
		$config = array();
			$config["base_url"] = base_url() . "account/accounting_invoice/";
			$config["total_rows"] = $this->account_model->num_rows('tbl_accounting_invoice',$where,$where2);
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			
			$this->data['add_invoice_details']  = $this->account_model->get_invoice_details('tbl_accounting_invoice',$where, $config["per_page"], $page,$where2,$order,$export_data);
			
			$where2 = array('account_freeze.created_by_cid' => $created_by_id);
			$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
				if(!empty($this->uri->segment(3))){
					$frt = (int)$this->uri->segment(3) - 1;
					$start= $frt * $config['per_page']+1;
			   }else{
					$start= (int)$this->uri->segment(3) * $config['per_page']+1;
			   }
	   
		   if(!empty($this->uri->segment(3))){
			   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
		   }else{
			  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
		   }
		   
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
	
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		$this->_render_template('accounting_invoice/index', $this->data);
	
	}	
	
	public function editaccountingInvoice_details(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('tbl_accounting_invoice','id',$this->uri->segment(3));	
			//$this->data['docss'] = $this->account_model->get_image_byId('attachments', 'rel_id', $this->uri->segment(3),'invoice');		
			$this->_render_template('accounting_invoice/edit', $this->data);
		}else{
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');
				$this->data['invoice_detail'] = $this->account_model->get_data_byId('tbl_accounting_invoice','id',$this->input->post('id'));	
				//$this->data['docss'] = $this->account_model->get_image_byId('attachments', 'rel_id', $this->input->post('id'),'invoice');				
				$this->load->view('accounting_invoice/edit', $this->data);
			}
		}	
	}
/*Create Accounting Invoice Code*/	
	
	
	
	
	
	public function deleteInvoice_details($id = ''){	
		if (!$id) {
           redirect('account/invoices', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('invoice','id',$id);
		$this->account_model->delete_inventery_mat_details('inventory_flow',$id, 'invoice');
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'invoice');
		if($result){
			logActivity('Invoice Details Deleted','invoice',$id);
			$this->session->set_flashdata('message', 'Invoice Details Deleted Successfully');
			$result = array('msg' => 'Invoice Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/invoices');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	
	public function cancelInvoice_details($id = ''){	
		if (!$id) {
           redirect('account/invoices', 'refresh');
        }
		$result = $this->account_model->cancel_restore_data('invoice','id',$id,'0');
		$this->account_model->cancel_restore_transational_tbl_data('transaction_dtl','type_id', $id, 'invoice','0');
		//$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'invoice');
		if($result){
			$this->session->set_flashdata('message', 'Invoice Canceled Successfully');
			$result = array('msg' => 'Invoice Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/invoices');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	public function restoreInvoice_details($id = ''){	
		if (!$id) {
           redirect('account/invoices', 'refresh');
        }
		$result = $this->account_model->cancel_restore_data('invoice','id',$id,'1');
		$this->account_model->cancel_restore_transational_tbl_data('transaction_dtl','type_id', $id, 'invoice','1');
		//$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'invoice');
		if($result){
			$this->session->set_flashdata('message', 'Invoice Restore Successfully');
			$result = array('msg' => 'Invoice Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/invoices');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	
	
	
	
	
	
	
	
	
	
	
	//GET PARTY DETAILS
	public function GetParty_details(){
		
		if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data = $this->account_model->get_matrial_data_byId('ledger','id',$_REQUEST['id']);
			echo json_encode($data,true);
			die;
			 
		 }
		
	}
	public function selectMatrial(){
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data = $this->account_model->get_matrial_data_byId('material','id',$_REQUEST['id']);

			$ww = getNameById('uom',$data->uom,'id');			
			$data->uom = $ww->ugc_code;
			$data->uomid = $ww->id;
			
			$alternateUOMid = getNameById('uom',$data->alternateuom,'id');			
			$data->altuomcode = $alternateUOMid->ugc_code;
			$data->altuomid = $alternateUOMid->id;
			echo json_encode($data,true);
			die;
		 }
	}
	public function selectMatrial_according_item_code(){
		 if($_REQUEST['material_code'] && $_REQUEST['material_code'] != ''){
			$data = $this->account_model->get_matrial_data_byId('material','material_code',$_REQUEST['material_code']);
			echo json_encode($data,true);
			die;
		 }
	}
	public function get_process_type(){
		 if($_REQUEST['jobcard_id'] && $_REQUEST['jobcard_id'] != ''){
			$data = $this->account_model->get_process_data_byId('job_card','id',$_REQUEST['jobcard_id']);
			$dataprocess = json_decode($data->machine_details,true);
			 //$html .='<option value="">Select Option</option>';
			foreach($dataprocess as $process_dtl){
				$process_name_id = getNameById('add_process',$process_dtl['processess'],'id');
				 $html .= '<option value="'.$process_name_id->id.'">'.$process_name_id->process_name.'</option>';
			}
			echo $html;
		 }
	}
	/* Get Leger state id during Tax Calulation*/
	public function get_ledger_mailing_state(){
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			//$data = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['id'],$_SESSION['loggedInUser']->c_id);
			$data = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['id'],$this->companyGroupId);
			//pre($data);die();
			echo json_encode($data,true);
			die;
		 }
	}
	
	public function get_company_branch_state(){
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			//$data = $this->account_model->get_comapny_sate_Data('company_detail','id',$_SESSION['loggedInUser']->c_id);
			$data = $this->account_model->get_comapny_sate_Data('company_detail','id',$this->companyGroupId);
			echo json_encode($data,true);
			die;
		 }
	}
	public function get_ledger_address_more_thanOne(){
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			//$created_by_cid  = $_SESSION['loggedInUser']->c_id;
			$created_by_cid  = $this->companyGroupId;
			$resultt = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['id'],$created_by_cid);
			echo json_encode($resultt,true);
			die;
			 
		 }
	}
	/* Get Leger state id during Tax Calulation*/
	/* Get Particulars charges Data */
	public function get_charges_details(){
		
		 if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data22 = $this->account_model->get_particulars_charges_data('charges_lead','id',$_REQUEST['id']);
			$data['data'] = $this->account_model->get_particulars_charges_data('charges_lead','id',$_REQUEST['id']);
			$ledger_Data = getNameById('ledger',$data22->ledger_id,'id');
			$data['ledger_nam'] =  $ledger_Data->name;
			
			echo json_encode($data);
			die;
			 
		 }
	}
	/* Get Particulars charges Data */
	
		public function get_company_branch(){
		  //$data22 = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);
		  $data22 = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);
		  $adress_id = $_REQUEST['selected_sale_ledger_brch_id'];
		  $address_Data = json_decode($data22->address);
		foreach($address_Data as $get_Add_id){
			 if($get_Add_id->add_id == $adress_id){
				$term_arr[] = $get_Add_id->prefix_inv_num;
			 }
		 }
	
		  $query = $this->db->query('SELECT * FROM invoice');
			$invoice_count =  $query->num_rows();
			if(!empty($term_arr[0])){
				//$ccounnt = $invoice_count + 1;
				$ccounnt = rand(10,100) + 1;
				echo strtoupper($term_arr[0].'/'.$ccounnt);
			}else{
				$ccount = $invoice_count + 2;
				echo 'INVOICE/'.$ccount;
			}	
	  // }
   }
   
   
   public function get_company_address(){
	    if($_REQUEST['login_c_id'] && $_REQUEST['login_c_id'] != ''){
			 $c_data = $this->account_model->get_termconditions_details('company_detail','id',$_REQUEST['login_c_id']);
			 $json_array  = json_decode($c_data->address, true);
			 $elementCount  = count($json_array);
			if($elementCount == 1){
				$single_add_dataa =  Json_decode($c_data->address,true);
				$single_add_Data = array();
				foreach($single_add_dataa as $get_add_name){
					$mailing_address = $get_add_name['address'];
					$mailing_country_id = $get_add_name['country'];
					$mailing_state_id = $get_add_name['state'];
					$mailing_city_id = $get_add_name['city'];
					$postal_zipcode = $get_add_name['postal_zipcode'];
					
					 $country_name = getNameById('country',$mailing_country_id,'country_id');
					 $state_name = getNameById('state',$mailing_state_id,'state_id');
					 $city_name = getNameById('city',$mailing_city_id,'city_id');
					
						$single_add_Data[] = array(
							'country_id' => $mailing_country_id,
							'state_id' => $mailing_state_id,
							'city_id' => $mailing_city_id,
							'mailing_add' => $mailing_address,
							'postal_zipcode' => $postal_zipcode,
							'postal_zipcode' => $postal_zipcode,
							'country_name' => $country_name->country_name,
							'state_name' => $state_name->state_name,
							'city_name' => $city_name->city_name
						);
					} 
				echo json_encode($single_add_Data,true);
				die;
			}
		}
	}
   
   public function get_company_unit_address(){
	  // $unit_Data =  $this->account_model->get_termconditions_details('location_settings','id',$_REQUEST['selected_unit_id']);
	  // $selected_company_id = $unit_Data->c_id;
	  //$selected_compny_branch_name = $unit_Data->compny_branch_name;
	  //$get_login_com_details = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
	  $get_login_com_details = getNameById('company_detail',$this->companyGroupId,'id');
	  $company_add = $get_login_com_details->address;
		
	  $company_multi_add =  Json_decode($company_add,true);
	 
		$multi_add_Data ='';
		$multi_add_Data = array();
	
	  foreach ($company_multi_add as $key => $val) {
		  
		  if ($val['add_id'] == $_REQUEST['selected_unit_id']) {
			        $compny_branch_name = $val['compny_branch_name'];
			        $mailing_address = $val['address'];
					$mailing_country_id = $val['country'];
					$mailing_state_id = $val['state'];
					$mailing_city_id = $val['city'];
					$postal_zipcode = $val['postal_zipcode'];
					$company_gstin = $val['company_gstin'];
					$country_name = getNameById('country',$mailing_country_id,'country_id');
					$state_name = getNameById('state',$mailing_state_id,'state_id');
					$city_name = getNameById('city',$mailing_city_id,'city_id');
					
					$multi_add_Data[] = array(
						'compny_branch_name' => $compny_branch_name,
						'country_id' => $mailing_country_id,
						'state_id' => $mailing_state_id,
						'city_id' => $mailing_city_id,
						'mailing_add' => $mailing_address,
						'postal_zipcode' => $postal_zipcode,
						'company_gstin' => $company_gstin,
						'country_name' => $country_name->country_name,
						'state_name' => $state_name->state_name,
						'city_name' => $city_name->city_name
					);
			
		}
		
		
	}
	
		echo json_encode($multi_add_Data,true);

}
	
	
	
	public function add_party_details_during_invoice(){
		
		$account_name = $_REQUEST['name'];
		$email = $_REQUEST['email'];
		$gstin = $_REQUEST['gstin'];
		$country = $_REQUEST['country'];
		$state = $_REQUEST['state'];
		$city_id = $_REQUEST['city_id'];
		$acc_group_id = $_REQUEST['acc_group_id'];
		$compny_branch_id = $_REQUEST['compny_branch_id'];
		$mailing_address = $_REQUEST['mailing_address'];
		$opening_balance = $_REQUEST['opening_balance'];
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		//$created_by_cid  = $_SESSION['loggedInUser']->c_id;
		$created_by_cid  = $this->companyGroupId;
		 $dd = $this->account_model->get_ledger_account_grp_Dtl('account_group',$created_by_cid,$_REQUEST['acc_group_id']); 
		
		if($_REQUEST['sale_ledger_data_val'] != 'Add Sale Ledger'){
			$mailing_addressLength = count($_POST['country']);
				if($mailing_addressLength >0){
					$arr = [];
					$i = 0;
					$idds = 1;
					while($i < $mailing_addressLength) {	
						$jsonArrayObject = (array('ID'=> $idds,'mailing_name'=>$account_name,'mailing_country' =>$country,'mailing_state' => $state,'mailing_city' => $city_id,'mailing_address'=>$mailing_address,'gstin_no'=>$gstin));
						$arr[$i] = $jsonArrayObject;
						$i++;
						$idds++;	
			
					}
					
					$descr_of_ldgr_array = json_encode($arr);
				}else{
					$descr_of_ldgr_array = '';
				}
			
			
			$party_details = array(
					'name'=>$account_name,
					'email'=>$email,
					'gstin'=>$gstin,
					'opening_balance '=>$opening_balance,
					'mailing_address' =>$descr_of_ldgr_array,
					'account_group_id'=>$acc_group_id,	
					'compny_branch_id'=>$compny_branch_id,	
					'created_by'=>$created_by_id, 
					'created_by_cid'=>$created_by_cid, 
					'parent_group_id'=>@$dd[0]['parent_group_id'],	 
				);
		
		}else{
			$party_details = array(
					'name'=>$account_name,
					'email'=>$email,
					'gstin'=>$gstin,
					'mailing_address' =>$descr_of_ldgr_array,
					'account_group_id'=>$acc_group_id,	
					'compny_branch_id'=>$compny_branch_id,	
					'parent_group_id'=>@$dd[0]['parent_group_id'],	
					'opening_balance '=>$opening_balance, 
					'created_by '=>$created_by_id, 
					'created_by_cid'=>$created_by_cid, 
				);	
			
		}
		
		//pre($party_details);die();
		
		$data = $this->account_model->insert_on_spot_tbl_data('ledger',$party_details);
		if($data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	
	
	public function add_matrial_Details_onthe_spot(){
		
		$material_name = $_REQUEST['material_name'];
		$hsn_code = $_REQUEST['hsn_code'];
		$uom = $_REQUEST['uom'];
		$tax = $_REQUEST['tax'];
		$specification = $_REQUEST['specification'];
		$chk_box_val = $_REQUEST['chk_box_val'];
		$material_type_id = $_REQUEST['material_type_id'];
		$prefix = $_REQUEST['prefix'];
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		$created_by_cid  = $this->companyGroupId;
		//$created_by_cid  = $_SESSION['loggedInUser']->c_id;
		$last_id = getLastTableId('material');
					$rId = $last_id + 1;
					$matCode = 'MAT_'.rand(1, 1000000).'_'.$rId; 
			//$non_inventry_material = 0;
	//echo $chk_box_val;
			// if($chk_box_val == 'checked'){
				// $non_inventry_material = 1;
			// }elseif($chk_box_val == 'not checked'){
				// $non_inventry_material = 0;  
			// }
	
			$matrial_details = array(
					'material_name'=>$material_name,
					'hsn_code'=>$hsn_code,
					'uom'=>$uom,
					'tax'=>$tax,
					'specification '=>$specification, 
					'created_by '=>$created_by_id, 
					'closing_balance '=>200,  
					'material_type_id '=>$material_type_id, 
					'prefix '=>$prefix, 
					'non_inventry_material '=>$chk_box_val, 
					'material_code '=>$matCode, 
					//'created_by '=>$created_by_id, 
					'created_by_cid '=>$created_by_cid, 
				);
				// pre($matrial_details);die();
			
		$data = $this->account_model->insert_on_spot_tbl_data('material',$matrial_details);
		if($data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	/*GEt Material type*/
	public function Get_matrial_type(){
		$get_data = $this->account_model->get_data_material_type('material_type');
		echo json_encode($get_data,true);
			die;
	}
	/*GEt Material type*/
	
	
	
	
	public function create_pdf($id = ''){
		$this->load->library('Pdf');
		$dataPdf['dataPdf'] = $this->account_model->get_data_byId('invoice','id',$id);
     	$this->load->view('invoice/invoice_pdf_genrate',$dataPdf);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		
	}
	public function create_pdf_all($id = ''){
		$this->load->library('Pdf');
		$login_cid = $_POST['login_c_id'];
		$start_date = $_POST['start'];
		$end_date = $_POST['end'];
		
		if($login_cid !='' && $start_date != '' &&  $end_date !='' ){
			$where = array('invoice.created_date >=' => $start_date , 'invoice.created_date <=' => $end_date,'invoice.created_by_cid'=> $this->companyGroupId);
			$dataPdfs['dataPdfs']  = $this->account_model->get_data_bywhereId('invoice',$where);
			
			 $this->load->view('invoice/all_invoice_pdf',$dataPdfs);
		}else{
			//$where = array('invoice.created_by_cid' => $_SESSION['loggedInUser']->c_id);
			$where = array('invoice.created_by_cid' => $this->companyGroupId);
			$dataPdfs['dataPdfs'] = $this->account_model->get_data_bywhereId('invoice',$where);
		    $this->load->view('invoice/all_invoice_pdf',$dataPdfs);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		}
		
		// $dataPdfs['dataPdfs'] = $this->account_model->get_data_bywhereId('invoice','created_by_cid',$login_cid);
		// $this->load->view('invoice/all_invoice_pdf',$dataPdfs);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		
  }
	
	public function invoice_setting() {
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Invoice Settings', base_url() . 'Add Invoice Settings');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Add Invoice Settings';
		//$company_id = $_SESSION['loggedInUser']->c_id;
		$company_id = $this->companyGroupId;
		
		$this->data['update_invoice_setting']  = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId); 
		$this->_render_template('invoice/invoice_setting_index', $this->data);
    }
	public function viewInvoice_setting(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['invoice_settingss'] = $this->account_model->get_data_byId('company_detail','id',$this->input->post('id'));			
			$this->load->view('invoice/viewInvoice_Setting', $this->data);
		}	
	}
	public function financial_year_settings() {
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Financial Year Settings', base_url() . 'Financial Year Settings');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Financial Year Settings';
		$company_id = $this->companyGroupId;
		//$company_id = $_SESSION['loggedInUser']->c_id;
		
		$this->data['update_invoice_setting']  = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId); 
		$this->_render_template('invoice/fiscal_year_settings', $this->data);
    }
	
	
	
	public function editInvoice_setting(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');
			$this->data['invoice_settingss'] = $this->account_model->get_data_byId('company_detail','id',$this->input->post('id'));			
			$this->load->view('invoice/editInvoice_setting', $this->data);
		}	
	}
	public function saveInvoice_settings(){	 
		if ($this->input->post()) {
			$data  = $this->input->post();
			$data['id'] = $_SESSION['loggedInUser']->id;
			$id = $data['id'];
			if($id && $id != ''){
				$success = $this->account_model->update_data('company_detail',$data, 'u_id', $_SESSION['loggedInUser']->id);	
					if ($success) {
                        $data['message'] = "Terms and Conditions Added successfully";
                        logActivity('Terms and Conditions Added','company_detail',$id);
                        $this->session->set_flashdata('message', 'Terms and Conditions Added successfully');
					    redirect(base_url().'account/invoice_setting', 'refresh');
                    }
				 }
			}			
        }
		
	public function saveAgeingEmail_settings(){	 
		if ($this->input->post()) {
			$data  = $this->input->post();
			$data = array($data);
			$vald = json_encode($data);
			$data['id'] = $_SESSION['loggedInUser']->id;
			$data['aging_email_text'] = $vald;
			
			$id = $data['id'];
			if($id && $id != ''){
				$success = $this->account_model->update_data('company_detail',$data, 'u_id', $_SESSION['loggedInUser']->id);	
					if ($success) {
                        $data['message'] = "Ageing Email setting Added successfully";
                        logActivity('Ageing Email setting Added','company_detail',$id);
                        $this->session->set_flashdata('message', 'Ageing Email setting Added successfully');
					    redirect(base_url().'account/invoice_setting', 'refresh');
                    }
				 }
			}			
        }	
	
	public function uploadFile($fielName) {
		$filename=$_FILES[$fielName]['name'];
		$tmpname=$_FILES[$fielName]['tmp_name']; 
		$exp=explode('.', $filename);
		$ext=end($exp);
		$newname=  $exp[0].'_'.time().".".$ext; 
		$config['upload_path'] = 'assets/modules/account/uploads/';
		$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
		$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
		$config['max_size'] = '2000000'; 
		$config['file_name'] = $newname;
		$this->load->library('upload', $config);
		move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);
		return $newname;
	}

	
public function voucher_detail(){
		$this->load->library('pagination');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Voucher Details', base_url() . 'Voucher Details');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Voucher Details';
		//$created_by_id  = $_SESSION['loggedInUser']->c_id;
		$created_by_id  = $this->companyGroupId;
		// $this->data['voucher_dtls']  = $this->account_model->get_voucher_dtatils('voucher',array('created_by'=> $created_by_id)); 
		// $this->_render_template('voucher_detail/index', $this->data);
		/* For Financial Year*/
		$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
		$date_fcal = json_decode($date_fun->financial_year_date,true);
	
				if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date('Y-m-d', $second_date22);
					}
				}
				 $first_date = date("d-m-Y", strtotime($first_date));
				 $second_date = date("d-m-Y", strtotime($second_date));
/* For Financial Year*/
		$where = array('voucher.created_by_cid'=> $created_by_id,'voucher.voucher_date >=' =>$first_date, 'voucher.voucher_date <=' => $second_date,'auto_entry'=>'0');
		//print_r($where);
		if(isset($_GET['tab'])=='drct_voucherr' && $_GET['tab']!='voucher' )
		{
		$where = array('voucher.created_by_cid'=> $created_by_id,'voucher.voucher_date >=' =>$first_date, 'voucher.voucher_date <=' => $second_date,'auto_entry'=>'1');
		}elseif($_GET['tab']=='voucher' && $_GET['tab']!='drct_voucherr'){
			$where = array('voucher.created_by_cid'=> $created_by_id,'voucher.voucher_date >=' =>$first_date, 'voucher.voucher_date <=' => $second_date,'auto_entry'=>'0');
			}
		if(isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '' ) {
		
			if($_GET['tab']=='drct_voucherr' && $_GET['tab']!='voucher' ){
			$where = array('voucher.created_by_cid'=> $created_by_id,'voucher.voucher_date >=' =>$first_date, 'voucher.voucher_date <=' => $second_date,'auto_entry'=>'1');
			}elseif($_GET['tab']=='voucher' && $_GET['tab']!='drct_voucherr'){
				$where = array('voucher.created_by_cid'=> $created_by_id,'voucher.voucher_date >=' =>$first_date, 'voucher.voucher_date <=' => $second_date,'auto_entry'=>'0');
			}else{
				$where = array('voucher.created_by_cid'=> $created_by_id,'voucher.voucher_date >=' =>$first_date, 'voucher.voucher_date <=' => $second_date,'auto_entry'=>'0');
			}
		}elseif(isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= '') {
			 if($_GET['tab']=='voucher' && $_GET['tab']!='drct_voucherr'){
			 $where = "voucher.created_by_cid = ".$created_by_id." AND  (STR_TO_DATE(`voucher_date`, '%Y-%m-%d')  >='".$_GET['start']."' AND STR_TO_DATE(`voucher_date`, '%Y-%m-%d') <='".$_GET['end']."' AND auto_entry=0)";
		}elseif(isset($_GET['tab'])=='drct_voucherr' && $_GET['tab']!='voucher' ){
				  $where = "voucher.created_by_cid = ".$created_by_id." AND  (STR_TO_DATE(`voucher_date`, '%Y-%m-%d') >='".$_GET['start']."' AND  STR_TO_DATE(`voucher_date`, '%Y-%m-%d') <='".$end_date."') AND auto_entry=1";
		}else{
				$where = "voucher.created_by_cid = ".$created_by_id." AND  STR_TO_DATE(`voucher_date`, '%Y-%m-%d') >='".$_GET['start']."' AND  STR_TO_DATE(`voucher_date`, '%Y-%m-%d')<='".$_GET['end']."' AND auto_entry=0";
			}
		}
		
		if(isset($_GET['start'])!=''  && isset($_GET['end'])!='' && $_GET["ExportType"]==''){
			if($_GET['tab']=='voucher' && $_GET['tab']!='drct_voucherr'){
			
				$where = "voucher.created_by_cid = ".$created_by_id." AND  STR_TO_DATE(`voucher_date`, '%Y-%m-%d')>='".$_GET['start']."' AND STR_TO_DATE(`voucher_date`, '%Y-%m-%d')<='".$_GET['end']."' AND auto_entry=0";
			 }elseif($_GET['tab']== 'drct_voucherr' && $_GET['tab']!= 'voucher' ){
			$where = "voucher.created_by_cid = ".$created_by_id." AND  STR_TO_DATE(`voucher_date`, '%Y-%m-%d')>='".$_GET['start']."' AND  STR_TO_DATE(`voucher_date`, '%Y-%m-%d')<='".$_GET['end']."'  AND auto_entry=1";
			 }else{
				
				$where = "voucher.created_by_cid = ".$created_by_id." AND  STR_TO_DATE(`voucher_date`, '%Y-%m-%d')>='".$_GET['start']."' AND  STR_TO_DATE(`voucher_date`, '%Y-%m-%d')<='".$_GET['end']."' AND auto_entry=0";
			 }
		}
			//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$voucherName=getNameById('voucher_type',$search_string,'voucher_name');
			if($voucherName->id != '' ){
				$where2 = "voucher.voucher_name like'%".$voucherName->id."%'";
			}else{
			$where2="(voucher.id ='".$search_string."')";
			 redirect("account/voucher_detail/?search=$search_string");
        }}else if(isset($_GET['search']) && ($_GET['search'])!=''){
			$voucherName=getNameById('voucher_type',$_GET['search'],'voucher_name');
			if($voucherName->id != '' ){
				$where2 = "voucher.voucher_name like'%".$voucherName->id."%'";
			}else{
			$where2="(voucher.id ='".$_GET['search']."')";
			}	
			}
			if($_GET['tab']=='voucher' && $_GET['tab']!='drct_voucherr'){
			$rows=$this->account_model->num_rows('voucher',$where,$where2);
		}elseif($_GET['tab']=='drct_voucherr' && $_GET['tab']!='voucher'){
			$rows=$this->account_model->num_rows('voucher',$where,$where2);
		}else{
			$rows=$this->account_model->num_rows('voucher',$where,$where2);
		}
		//Pagination*/
		$config = array();
			$config["base_url"] = base_url() . "account/voucher_detail/";
			$config["total_rows"] = $rows;
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
		
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			if($_GET['tab']=='voucher' && $_GET['tab']!='drct_voucherr'){
				$this->data['voucher_dtls']  = $this->account_model->get_voucher_dtatils('voucher',$where, $config["per_page"], $page,$where2,$order,$export_data);
			}elseif($_GET['tab']!='voucher' && $_GET['tab']=='drct_voucherr'){
				$this->data['voucher_dtls_auto']  = $this->account_model->get_voucher_dtatils('voucher',$where, $config["per_page"], $page,$where2,$order,$export_data);
			}else{
			$this->data['voucher_dtls']  = $this->account_model->get_voucher_dtatils('voucher',$where, $config["per_page"], $page,$where2,$order,$export_data);
			//pre($this->data['voucher_dtls']);die();
			$this->data['voucher_dtls_auto']  = $this->account_model->get_voucher_dtatils('voucher',$where, $config["per_page"], $page,$where2,$order,$export_data);
			$where2 = array('account_freeze.created_by_cid' => $this->companyGroupId);
			$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
			}
	if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
	
			$this->_render_template('voucher_detail/index', $this->data);
		
	}
	
	public function Create_VoucherDtl(){
		$this->load->library('pagination');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Voucher Details', base_url() . 'Voucher Details');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Voucher Details';
		$this->_render_template('voucher_detail/edit', $this->data);
	}	
	
	
	
	public function viewVoucher_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher_dtls'] = $this->account_model->get_data_byId('voucher','id',$this->input->post('id'));			
			$this->load->view('voucher_detail/view', $this->data);
		}	
	}
	public function viewVoucher_detailmatdtl(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher_dtls'] = $this->account_model->get_data_byId('voucher','id',$this->input->post('id'));			
			$this->load->view('voucher_detail/viewdtl', $this->data);
		}	
	}
	public function editVoucher_detail(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['voucher_dtls'] = $this->account_model->get_data_byId('voucher','id',$this->uri->segment(3));			
			$this->_render_template('voucher_detail/edit', $this->data);
		}else{
			if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['voucher_dtls'] = $this->account_model->get_data_byId('voucher','id',$this->input->post('id'));			
			$this->load->view('voucher_detail/edit', $this->data);
			}
		}	
	}
	
	
	
	
	
   public function saveVoucher_Details(){
	  if ($this->input->post()) {
		 $usersWithViewPermissions = $this->account_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 86));
		 $voucher_detlsLength = count($_POST['credit_debit_party_dtl']);
			if($voucher_detlsLength >0){
				$arra = [];
				$i = 0;
				
				while($i < $voucher_detlsLength) {	
			
					$jsonArrayObject = (array('credit_debit_party_dtl' => $_POST['credit_debit_party_dtl'][$i],'credit_1' => $_POST['credit_1'][$i], 'debit_1' => $_POST['debit_1'][$i],'cr_dr'=>$_POST['cr_dr'][$i]));
					$arra[$i] = $jsonArrayObject;
					$i++;
				 // pre($arra);			
				}
				$description_voucher = json_encode($arra);
				}else{
				$description_voucher = '';
			}
				
			 $sec = strtotime( $_POST['voucher_date']);  
			 $add_Date = date ("Y-m-d H:i", $sec); 
				 //echo $add_Date = $add_Date . ":00";die();
			$required_fields = array('voucher_name');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();			
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				//$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$data['created_by_cid'] = $this->companyGroupId;
				$data['credit_debit_party_dtl'] = $description_voucher;
				$data['auto_entry'] = 0;
				$data['voucher_date'] = date("Y-m-d",strtotime($_POST['voucher_date']));
				$id = $data['id'];
				
				
				if($id && $id != ''){
					//pre($data);die();
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('voucher',$data, 'id', $id);	
					$for_transation_tbl = json_decode($description_voucher);
					
						if($for_transation_tbl !=''){
								$credit_Data = array();
								$debit_Data = array();
								$taxxxs = '';
								 $j=0;
								 $trans_id = $this->account_model->get_data_byId('transaction_dtl','type_id',$id);
								 $crdittotal = 0;
								 $debittotal = 0;
								 $dbittotal = 0;
							foreach($for_transation_tbl as $val){
								
								 $crdittotal += $val->credit_1;
								 $debittotal += $val->debit_1;
								 $dbittotal += $val->debit_1;
								$trans_tbl_id = $trans_id->id + $j;// Transaction Table id for Update
								//pre($trans_tbl_id);
								if($val->credit_debit_party_dtl == '1'){
									
										$ledger_id = $val->credit_debit_party_dtl;
										$IGST_data['debit_dtl'] = $dbittotal;
										$IGST_data['ledger_id'] = $val->credit_debit_party_dtl;
										$IGST_data['credit_dtl'] = '0';
										$IGST_data['type'] = 'voucher';
										$IGST_data['type_id'] = $id;
										$IGST_data['add_date'] = $add_Date;
										$IGST_data['cancel_restore'] = 1;
										$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										//$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$IGST_data['created_by_cid'] = $this->companyGroupId;
										//$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
										$this->account_model->update_transaction_data('transaction_dtl',$IGST_data, 'type_id', $id, 'voucher',$ledger_id,$trans_tbl_id);
									}
								if($val->credit_debit_party_dtl == '2'){
									
									    $ledger_id = $val->credit_debit_party_dtl;
										$CGST_data['debit_dtl'] = $dbittotal;
										$CGST_data['ledger_id'] = $val->credit_debit_party_dtl;
										$CGST_data['credit_dtl'] = '0';
										$CGST_data['type'] = 'voucher';
										$CGST_data['type_id'] = $id;
										$CGST_data['add_date'] = $add_Date;
										$CGST_data['cancel_restore'] = 1;
										$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										//$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$CGST_data['created_by_cid'] = $this->companyGroupId;
										//$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
										$this->account_model->update_transaction_data('transaction_dtl',$CGST_data, 'type_id', $id, 'voucher',$ledger_id,$trans_tbl_id);
									}	
								if($val->credit_debit_party_dtl == '3'){
									
										$ledger_id = $val->credit_debit_party_dtl;
										$SGST_data['debit_dtl'] = $dbittotal;
										$SGST_data['ledger_id'] = $val->credit_debit_party_dtl;
										$SGST_data['credit_dtl'] = '0';
										$SGST_data['type'] = 'voucher';
										$SGST_data['type_id'] = $id;
										$CGST_data['cancel_restore'] = 1;
										$SGST_data['add_date'] = $add_Date;
										$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										//$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$SGST_data['created_by_cid'] = $this->companyGroupId;
										//$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
										$this->account_model->update_transaction_data('transaction_dtl',$SGST_data, 'type_id', $id, 'voucher',$ledger_id,$trans_tbl_id);
									}	
								if($val->cr_dr == 'credit'  && $val->credit_debit_party_dtl !='1' && $val->credit_debit_party_dtl !='2' && $val->credit_debit_party_dtl !='3'){
									
									
									$alerady_Added_ledger =  $this->account_model->get_data_byId_transcation_dtl('transaction_dtl','type_id',$id,'credit_dtl');
									$ledger_id = $alerady_Added_ledger->ledger_id;
									$credit_data['debit_dtl'] = '0';
									$credit_data['ledger_id'] = $val->credit_debit_party_dtl;
									$credit_data['credit_dtl'] = $crdittotal;
									$credit_data['cancel_restore'] = 1;
									$credit_data['type'] = 'voucher';
									$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
									//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
									$credit_data['created_by_cid'] = $this->companyGroupId;
									$credit_data['type_id'] = $id;
									$credit_data['add_date'] = $add_Date;
									
									
									//$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
									$this->account_model->update_transaction_data('transaction_dtl',$credit_data, 'type_id', $id, 'voucher',$ledger_id,$trans_tbl_id,'credit_dtl');
									}else if($val->cr_dr == 'debit' && $val->credit_debit_party_dtl !='1' && $val->credit_debit_party_dtl !='2' && $val->credit_debit_party_dtl !='3'){
										
										$alerady_Added_ledger =  $this->account_model->get_data_byId_transcation_dtl('transaction_dtl','type_id',$id,'debit_dtl');
									$ledger_id = $alerady_Added_ledger->ledger_id;
										$debit_data['debit_dtl'] = $debittotal;
										$debit_data['ledger_id'] = $val->credit_debit_party_dtl;
										$debit_data['credit_dtl'] = '0';
										$debit_data['type'] = 'voucher';
										$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$debit_data['created_by_cid'] = $this->companyGroupId;
										//$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
										$debit_data['type_id'] = $id;
										$debit_data['cancel_restore'] = 1;
										$debit_data['add_date'] = $add_Date;
										//$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
										$this->account_model->update_transaction_data('transaction_dtl',$debit_data, 'type_id', $id, 'voucher',$ledger_id,$trans_tbl_id,'debit_dtl');
									}
									//pre($debit_data);
								$j++;	
								}
								
								
						}
					// die('Accha');
					if ($success) {
                        $data['message'] = "Voucher updated successfully";
                        logActivity('Voucher details  Updated','voucher_type',$id);
                        $this->session->set_flashdata('message', 'Voucher Updated successfully');
					    redirect(base_url().'account/voucher_detail', 'refresh');
                    }
				}else{
					$id = $this->account_model->insert_tbl_data('voucher',$data);
					if(!empty($usersWithViewPermissions)){
						foreach($usersWithViewPermissions as $userViewPermission){
							if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
								pushNotification(array('subject'=> 'Voucher Updated' , 'message' => 'Voucher id : #'.$id.' is updated by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id,'class'=>'add_voucher_details_tabs','data_id' => 'voucher_dtl_view','icon'=>'fa-shopping-cart'));
							}
						}
					}
					if($_SESSION['loggedInUser']->role !=1){
						pushNotification(array('subject'=> 'Voucher Updated' , 'message' => 'Voucher id : #'.$id.' is updated by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id,'class'=>'add_voucher_details_tabs','data_id' => 'voucher_dtl_view','icon'=>'fa-shopping-cart'));
					}
					
					/*Transaction table Data*/
				$for_transation_tbl = json_decode($description_voucher);
				if($for_transation_tbl !=''){
						$credit_Data = array();
						$debit_Data = array();
						$taxxxs = '';
						 $i=0;
					foreach($for_transation_tbl as $val){
						if($val->credit_debit_party_dtl == '1'){
								$IGST_data['debit_dtl'] = $val->debit_1;
								$IGST_data['ledger_id'] = $val->credit_debit_party_dtl;
								$IGST_data['credit_dtl'] = '0';
								$IGST_data['type'] = 'voucher';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['cancel_restore'] = 1;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
						if($val->credit_debit_party_dtl == '2'){
								$CGST_data['debit_dtl'] = $val->debit_1;
								$CGST_data['ledger_id'] = $val->credit_debit_party_dtl;
								$CGST_data['credit_dtl'] = '0';
								$CGST_data['type'] = 'voucher';
								$CGST_data['type_id'] = $id;
								$CGST_data['cancel_restore'] = 1;
								$CGST_data['add_date'] = $add_Date;
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
							}	
						if($val->credit_debit_party_dtl == '3'){
								$SGST_data['debit_dtl'] = $val->debit_1;
								$SGST_data['ledger_id'] = $val->credit_debit_party_dtl;
								$SGST_data['credit_dtl'] = '0';
								$SGST_data['type'] = 'voucher';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 1;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
							}	
						if($val->cr_dr == 'credit'  && $val->credit_debit_party_dtl !='1' && $val->credit_debit_party_dtl !='2' && $val->credit_debit_party_dtl !='3'){
							$credit_data['debit_dtl'] = '0';
							$credit_data['ledger_id'] = $val->credit_debit_party_dtl;
							$credit_data['credit_dtl'] = $val->credit_1;
							$credit_data['type'] = 'voucher';
							$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$credit_data['created_by_cid'] = $this->companyGroupId;
							$credit_data['type_id'] = $id;
							$credit_data['cancel_restore'] = 1;
							$credit_data['add_date'] = $add_Date;
							$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
							// pre($credit_data);
							}else if($val->cr_dr == 'debit' && $val->credit_debit_party_dtl !='1' && $val->credit_debit_party_dtl !='2' && $val->credit_debit_party_dtl !='3'){
								// $debit_Data[$i]['sale_ledger_id']  = $val->credit_debit_party_dtl;
								// $debit_Data[$i]['debit'] = $val->debit_1;
								$debit_data['debit_dtl'] = $val->debit_1;
								$debit_data['ledger_id'] = $val->credit_debit_party_dtl;
								$debit_data['credit_dtl'] = '0';
								$debit_data['type'] = 'voucher';
								$debit_data['cancel_restore'] = 1;
								$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$debit_data['created_by_cid'] = $this->companyGroupId;
								//$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$debit_data['type_id'] = $id;
								$debit_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
							}
							//pre($debit_data);
							
						}
						//die('Accha');
						
				}
			/*Transaction table Data*/
			if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'New Voucher created' , 'message' => 'New Voucher is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_voucher_details_tabs','data_id' => 'voucher_dtl_view' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'New Voucher created' , 'message' => 'New Voucher is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'add_voucher_details_tabs','data_id' => 'voucher_dtl_view','icon'=>'fa-shopping-cart'));
						}	
			
						
					if ($id) {                        
                        logActivity('New Voucher details Created','voucher_type',$id);
                        $this->session->set_flashdata('message', 'Voucher inserted successfully');
					    redirect(base_url().'account/voucher_detail', 'refresh');
                    }    				
				}
			}			
        }
	
  }
  
  public function deleteVoucher_details($id = ''){	
	//pre($id);die('AYA');
		if (!$id) {
           redirect('account/voucher_detail', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('voucher','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'voucher');
		if($result){
			logActivity('Voucher Details Deleted','voucher',$id);
			$this->session->set_flashdata('message', 'Voucher Details Deleted Successfully');
			$result = array('msg' => 'Voucher Details Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/voucher_detail');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}


	


/*********************************************************************************************************/	
/**********************************Receipt TO MODULE START***********************************************/	
/*******************************************************************************************************/	
	public function recvpayment(){
		$this->load->library('pagination');
	    $this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Receive Payment', base_url() . 'Receive Payment');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Receive Payment';
		$created_by_id  = $this->companyGroupId;
		// $this->data['payment_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',array('type'=> '0','created_by'=>$created_by_id)); 
		// $this->_render_template('receive_payment/index', $this->data);
		/* For Financial Year*/
			//$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			
				if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}	
		$where = array('payment.type'=> '0','payment.created_by_cid'=> $created_by_id,'payment.created_date >=' =>$first_date, 'payment.created_date <=' => $second_date);
			
		if(isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search'] == '') {
		$where=array('payment.type'=> '0','payment.created_by_cid'=> $created_by_id,'payment.created_date >=' =>$first_date, 'payment.created_date <=' => $second_date); 
		}
		elseif($_GET["ExportType"]!='' && $_GET['start'] != '' && $_GET['end']!= '' && $_GET['search'] == '') {
			$where = array('payment.type'=> '0','payment.created_date >=' => $_GET['start'] , 'payment.created_date <=' => $_GET['end'],'payment.created_by_cid'=> $this->companyGroupId);
		}
		
		if(isset($_GET['start'])!='' && isset($_GET['end'])!='' && isset($_GET["ExportType"])==''&& $_GET['search'] == ''){
			//pre($_POST);die();
			$where = array('payment.type'=> '0','payment.created_date >=' => $_GET['start'] , 'payment.created_date <=' => $_GET['end'],'payment.created_by_cid'=> $this->companyGroupId);
		}		
			//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$ledgerName=getNameById('ledger',$search_string,'name');
				if($ledgerName->id != ''){
				$where2 = "(payment.recieve_ledger_id like'%".$ledgerName->id."%')" ;
				}else{
				$where2="(payment.id like'%".$search_string."%')";
				}
		 redirect("account/recvpayment/?search=$search_string");
        }else if($_GET['search']!=''){
			$ledgerName=getNameById('ledger',$_GET['search'],'name');
				if($ledgerName->id != ''){
				$where2 = "(payment.recieve_ledger_id like'%".$ledgerName->id."%')" ;
				}else{
				 $where2 = "(payment.id like'%". $_GET['search']."%')";
				}
				
			}
			
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
		
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/recvpayment/";
			$config["total_rows"] = $this->account_model->num_rows('payment',$where,$where2);
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		
/* For Financial Year*/
			$this->data['payment_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',$where, $config["per_page"], $page,$where2,$order,$export_data);
			$where2 = array('account_freeze.created_by_cid' => $this->companyGroupId);
			$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
			$this->_render_template('receive_payment/index', $this->data);
				}	
	

	public function receve_payment(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Receive Payment', base_url() . 'Receive Payment');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Receive Payment';
		$this->_render_template('receive_payment/edit', $this->data);
		
	}	
	
	public function editrecvpayment_detail(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['payment_dtl'] = $this->account_model->get_data_byId('payment','id',$this->uri->segment(3));	
			$this->_render_template('receive_payment/edit', $this->data);
		}else{
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');	
				$this->data['payment_dtl'] = $this->account_model->get_data_byId('payment','id',$this->input->post('id'));			
				$this->load->view('receive_payment/edit', $this->data);
			}	
		}
	}	
	public function viewrecvpayment_detail(){
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');	
				$this->data['payment_dtl'] = $this->account_model->get_data_byId('payment','id',$this->input->post('id'));			
				$this->load->view('receive_payment/view', $this->data);
			}	
		}

	//GET NOT PAID INVOICES to show Payment Recepit
// public function get_not_paid_invoices(){
		 // if($_REQUEST['party_id'] && $_REQUEST['party_id'] != ''){
			// $invoice_data22 = $this->account_model->not_paid_data_byID('invoice',array('party_name'=> $_REQUEST['party_id'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id));
			// $data['data'] = $this->account_model->not_paid_data_byID('invoice',array('party_name'=> $_REQUEST['party_id'],'created_by_cid'=> $_SESSION['loggedInUser']->c_id));
			
			
			
			// $charges_amt_sum = 0;
			// foreach($invoice_data22 as $charg_DD){
				// $chrg = json_decode($charg_DD['charges_added']);
				// foreach($chrg as $chargs){
					// $charges_amt_sum = $chargs->amt_with_tax;
					 // $charges_amt_sum2 = number_format((float)$charges_amt_sum, 2, '.', '');
			        // $data['charge_taxamt'] = $charges_amt_sum2;
				// }
			// }
			
		
			// echo json_encode($data);
			// die;
		// }
	// }
	public function get_not_paid_invoices(){
		 if($_REQUEST['party_id'] && $_REQUEST['party_id'] != ''){
			$invoice_data = $this->account_model->not_paid_data_byID('invoice',array('party_name'=> $_REQUEST['party_id'],'created_by_cid'=> $this->companyGroupId));
			echo json_encode($invoice_data);
			die;
		}
	}
public function get_seleceted_user_balance(){
	 if($_REQUEST['party_id'] && $_REQUEST['party_id'] != ''){
			$payment_data_advance = $this->account_model->Get_advance_payment('payment',array('party_id'=> $_REQUEST['party_id'],'created_by_cid'=> $this->companyGroupId));
			$bblnce = number_format((float)$payment_data_advance->amount_to_credit, 2, '.', '');
			echo $bblnce ;
			die;
	 }		
}

public function get_supplier_details(){
	 if($_REQUEST['party_id'] && $_REQUEST['party_id'] != ''){
			$supplier_details = $this->account_model->get_ledger_sate_Data('ledger','id',$_REQUEST['party_id'],$this->companyGroupId);
			
			echo json_encode($supplier_details);
			
			//echo $details_new =  $supplier_details->email;
			
			die;
	 }		
}	
	
	

public function saverecept_Details(){

	if ($this->input->post()) {
	
		 $sec = strtotime($_POST['payment_date']);  
		 $add_Date = date ("Y-m-d H:i", $sec); 
	//pre($_POST);die();
	   $add_reciptdetail_Length = count($_POST['description']);
			if($add_reciptdetail_Length > 0){
				$arra = [];
				$i = 0;
				
				while($i < $add_reciptdetail_Length) {	
				if($_POST['invoice_id'][$i] != ''){
					$jsonArrayObject = (array('invoice_id' => $_POST['invoice_id'][$i],'open_balance' => $_POST['open_balance'][$i], 'payment_amount' => $_POST['payment_amount'][$i],'due_date' => $_POST['due_date'][$i]));
					$arra[$i] = $jsonArrayObject;
					}
				$i++;
			}	
			$payment_receipt_Detail = json_encode($arra);
				}else{
				$payment_receipt_Detail = '';
			}
			$required_fields = array('party_id','party_email','created_date','payment_method','reference_no');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
					valid_fields($is_valid);				
			}else{
					$data  = $this->input->post();
					$data['created_by'] = $_SESSION['loggedInUser']->u_id;
					//$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$data['created_by_cid'] = $this->companyGroupId;
					$data['payment_detail'] = $payment_receipt_Detail;
					$data['balance'] = abs($data['balance']);
					$id = $data['id'];
				
			if($id && $id != ''){
				//pre($_POST);die();
				$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
				$success = $this->account_model->update_data('payment',$data, 'id', $id);
					if($payment_receipt_Detail != ''){
    					$ledger_id = $_REQUEST['recieve_ledger_id'];
						$debit_data['credit_dtl'] = '0';
						$debit_data['debit_dtl'] = $_POST['added_amount'];
						$debit_data['type'] = 'Payment Receive';
						//$debit_data['ifadvance'] = 'advance';
						$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						//$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$debit_data['created_by_cid'] = $this->companyGroupId;
						$debit_data['type_id'] = $id;
						$debit_data['add_date'] = $add_Date;
						$debit_data['cancel_restore'] = 1;
						
						$this->account_model->update_transaction_data('transaction_dtl',$debit_data, 'type_id', $id, 'Payment Receive',$ledger_id);
						/* For Sale Ledger Details data*/
						
						/* For Purchase Ledger Details data*/
						$credit_data['debit_dtl'] = '0';
						$ledger_id = $_POST['party_id'];
						$credit_data['credit_dtl'] = $_POST['added_amount'];
						//$debit_data['ifadvance'] = 'advance';
						$credit_data['type'] = 'Payment Receive';
						$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$credit_data['created_by_cid'] = $this->companyGroupId;
						$credit_data['type_id'] = $id;
						$credit_data['add_date'] = $add_Date;
						$credit_data['cancel_restore'] = 1;
						$this->account_model->update_transaction_data('transaction_dtl',$credit_data, 'type_id', $id, 'Payment Receive',$ledger_id);
					}
					/* For Purchase Ledger Details data*/
					
						
				if ($success) {
					$data['message'] = "Receive Payment updated successfully";
					logActivity('Receive Payment Updated','payment',$id);
					$this->session->set_flashdata('message', 'Receive Payment Updated successfully');
					redirect(base_url().'account/recvpayment', 'refresh');
				}
				}else{
					if (!empty($data)){
					/* Get Details of paid and not paid and update invoice Table accordingly*/
					//pre($data);die();
					$get_proper_invoice_paid = json_decode($data['payment_detail']);
							foreach($get_proper_invoice_paid as $paid_invc_data)
							{
								$invoice_id = $paid_invc_data->invoice_id;
								$open_balance = $paid_invc_data->open_balance;
								$payment_amount = $paid_invc_data->payment_amount;
								
								// pre($open_balance);
								// pre($payment_amount);
								
								
								//if($open_balance != $payment_amount){
								if($open_balance != $_POST['added_amount']){
								
									//$data['balance'] = $open_balance - $payment_amount;
									$data['balance'] = $open_balance - $_POST['added_amount'];
									$update_data = array(
											'total_amount' => abs($data['balance']),
											'charges_total_tax' => '0'
									);
									$this->account_model->add_balance_amount_or_paid('invoice',$update_data, $invoice_id);
								}else{
										$update_data = array(
											'pay_or_not' => '1',
											'charges_total_tax' => '0'
										);
									$this->account_model->add_balance_amount_or_paid('invoice',$update_data, $invoice_id);
								}
							}
						
						//die();
					/* Get Details of paid and not paid and update invoice Table accordingly*/
					$id = $this->account_model->insert_tbl_data('payment',$data);
					
					
					
							//if($payment_receipt_Detail != ''){
								
								$debit_data['debit_dtl'] = $_POST['added_amount'];
								$debit_data['ledger_id'] = $_REQUEST['recieve_ledger_id'];
								$debit_data['credit_dtl'] = '0';
								$debit_data['type'] = 'Payment Receive';
								$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$debit_data['created_by_cid'] = $this->companyGroupId;
								//$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$debit_data['type_id'] = $id;
								$debit_data['add_date'] = $add_Date;
								$debit_data['cancel_restore'] = 1;
								
									$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
								/* For Sale Ledger Details data*/
								
								/* For Purchase Ledger Details data*/
								$credit_data['debit_dtl'] = '0';
								$credit_data['cancel_restore'] = 1;
								$credit_data['ledger_id'] = $_POST['party_id'];
								$credit_data['credit_dtl'] = $_POST['added_amount'];
								$credit_data['type'] = 'Payment Receive';
								$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$credit_data['created_by_cid'] = $this->companyGroupId;
								//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$credit_data['type_id'] = $id;
								
								$credit_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
								/* For Purchase Ledger Details data*/
						//	}
							/*Code For Charges and Testing*/
							
							

				}
				if ($id) {                        
					logActivity('New add payment details Created','payment',$id);
					$this->session->set_flashdata('message', 'Receive Payment inserted successfully');
				   redirect(base_url().'account/recvpayment', 'refresh');
				}    				
			}
		}			
	}
	}	
	
	public function deleterecipt($id = ''){	
		if (!$id) {
           redirect('account/recvpayment', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('payment','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'Payment Receive');
		if($result){
			logActivity('Receive Payment Deleted','payment',$id);
			$this->session->set_flashdata('message', 'Receive Payment Deleted Successfully');
			$result = array('msg' => 'Receive Payment Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/recvpayment');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}	

/***********************************************************************************************************************************************/	
/******************************************************PAYMENT TO MODULE START******************************************************************/	
/***********************************************************************************************************************************************/	
	public function paymentto(){
		$this->load->library('pagination');
	    $this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Payment', base_url() . 'Payment');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Payment To';
		$created_by_id  = $this->companyGroupId;
		//$created_by_id  = $_SESSION['loggedInUser']->c_id;
		/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			
			if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}
		$where = array('payment.type'=> '1','payment.created_by_cid' => $this->companyGroupId,'payment.created_date >=' =>$first_date, 'payment.created_date <=' => $second_date);
		if($_GET["ExportType"]!='' && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['search']=='') {
			$where = array('payment.type'=> '1','payment.created_by_cid' => $this->companyGroupId,'payment.created_date >=' =>$first_date, 'payment.created_date <=' => $second_date);
		}elseif(isset($_GET["ExportType"])!='' && $_GET['start']!= '' && $_GET['end']!= '' && $_GET['search']=='') 
		{
			$where = array('payment.type'=> '1','payment.created_date >=' => $_GET['start'] , 'payment.created_date <=' => $_GET['end'],'payment.created_by_cid'=> $this->companyGroupId);
		}
		if(isset($_GET["ExportType"])!='' && $_GET['start']!= '' && $_GET['end']!= '' && $_GET['search']=='') 
		{
			$where = array('payment.type'=> '1','payment.created_date >=' => $_GET['start'] , 'payment.created_date <=' => $_GET['end'],'payment.created_by_cid'=> $this->companyGroupId);
		}	
		if(isset($_GET["ExportType"])=='' && $_GET['start']!= '' && $_GET['end']!= '' && $_GET['search']=='') 
		{
			$where = array('payment.type'=> '1','payment.created_date >=' => $_GET['start'] , 'payment.created_date <=' => $_GET['end'],'payment.created_by_cid'=> $this->companyGroupId);
		}				
			//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
	$search_string = $_POST['search'];
	$ledgerName=getNameById('ledger',$search_string,'name');
				if($ledgerName->id != ''){
				$where2 = "(payment.party_id like'%".$ledgerName->id."%')" ;
				}else{
				$where2="(payment.id like'%".$search_string."%')";
				}
		 redirect("account/paymentto/?search=$search_string");
        }else if($_GET['search']!=''){
			$ledgerName=getNameById('ledger',$_GET['search'],'name');
				if($ledgerName->id != ''){
				$where2 = "(payment.party_id like'%".$ledgerName->id."%')" ;
				}else{
				$where2 = "(payment.id like'%". $_GET['search']."%')";
				}
			}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
			//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/paymentto/";
			$config["total_rows"] = $this->account_model->num_rows('payment',$where,$where2);
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
			  if(!empty($_GET['ExportType'])){
			$export_data = 1;
		}else{
			$export_data = 0;
		}		
		if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		
/* For Financial Year*/
			$this->data['payment_to_dtl']  = $this->account_model->get_data_for_wherecdtion('payment',$where, $config["per_page"], $page,$where2,$order,$export_data);
		    $this->_render_template('payment_to/index', $this->data);		
	}

	public function payment_to_ctrl(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Payment', base_url() . 'Payment');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Payment To';
		$this->_render_template('payment_to/edit', $this->data);
	}		

	public function editpayment_to_detail(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['payment_to_dtl'] = $this->account_model->get_data_byId('payment','id',$this->uri->segment(3));	
			$this->data['bank_name'] = $this->account_model->get_data('bank_name');	
			$this->_render_template('payment_to/edit', $this->data);
		}else{
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');	
				$this->data['payment_to_dtl'] = $this->account_model->get_data_byId('payment','id',$this->input->post('id'));
				$this->data['bank_name'] = $this->account_model->get_data('bank_name');
				
				$this->load->view('payment_to/edit', $this->data);
			}	
		}
	}	
	public function viewpayment_to_detail(){
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');	
				$this->data['payment_to_dtl'] = $this->account_model->get_data_byId('payment','id',$this->input->post('id'));			
				$this->load->view('payment_to/view', $this->data);
			}	
		}
	
	public function get_not_paid_bills(){
	
		 if($_REQUEST['supplier_name'] && $_REQUEST['supplier_name'] != ''){
			$bills_data = $this->account_model->not_paid_purchase_bill('purchase_bill',array('supplier_name'=> $_REQUEST['supplier_name'],'auto_entry'=>'0'));
		//	pre($bills_data);die();
			$purchase_order_data = $this->account_model->not_paid_purchase_bill('purchase_order',array('supplier_name'=> $_REQUEST['supplier_name'],'mrn_or_not'=>'0'));
			$merage_Data = array_merge($bills_data, $purchase_order_data); 
			
  			echo json_encode($merage_Data);
			die();
		}
	}

public function savepayment_to_Details(){
	
	  if ($this->input->post()) {
		    $sec = strtotime( $_POST['payment_date']);  
			$add_Date = date ("Y-m-d H:i", $sec); 
			$add_reciptdetail_Length = count($_POST['description']);
			if($add_reciptdetail_Length >0){
				$arra = [];
				$i = 0;
				while($i < $add_reciptdetail_Length) {	
					if($_POST['bill_id'][$i] != ''){
						$jsonArrayObject = (array('bill_id' => $_POST['bill_id'][$i],'open_balance' => $_POST['open_balance'][$i], 'payment_amount' => $_POST['payment_amount'][$i],'date' => $_POST['date'][$i],'order_code' => $_POST['order_code'][$i],'from_detail'=>$_POST['from_detail'][$i]));
						$arra[$i] = $jsonArrayObject;
					}
					$i++;
				}	
				$payment_receipt_Detail = json_encode($arra);
			}else{
					$payment_receipt_Detail = '';
				}
				$required_fields = array('party_id');	
				$is_valid = validate_fields($_POST, $required_fields);
				if (count($is_valid) > 0) {
					valid_fields($is_valid);				
				}else{
				$data  = $this->input->post();			
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $this->companyGroupId;
				$data['payment_detail'] = $payment_receipt_Detail;
				$data['type'] = '1';//0 for payment recived 1 for payment to
				$id = $data['id'];
				
				// pre($_POST);die();
				// pre($data);die();
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('payment',$data, 'id', $id);
					//Code for  add Transaction Details according to Details	
						$ledger_id = $_REQUEST['recieve_ledger_id'];
						$debit_data['credit_dtl'] = $_POST['added_amount'];
						$debit_data['debit_dtl'] =  '0';
						$debit_data['type'] = 'purchase_bill_payment_recive';
						$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						//$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$debit_data['created_by_cid'] = $this->companyGroupId;
						$debit_data['type_id'] = $id;
						$debit_data['add_date'] = $add_Date;
						$debit_data['cancel_restore'] = 1;
						$this->account_model->update_transaction_data('transaction_dtl',$debit_data, 'type_id', $id, 'purchase_bill_payment_recive',$ledger_id);
						/* For Sale Ledger Details data*/
						
						/* For Purchase Ledger Details data*/
						$credit_data['debit_dtl'] = $_POST['added_amount'];
						$ledger_id = $_POST['party_id'];
						$credit_data['credit_dtl'] =  '0';
						$credit_data['type'] = 'purchase_bill_payment_recive';
						$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$credit_data['created_by_cid'] = $this->companyGroupId;
						//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$credit_data['type_id'] = $id;
						$credit_data['add_date'] = $add_Date;
						$credit_data['cancel_restore'] = 1;
						$this->account_model->update_transaction_data('transaction_dtl',$credit_data, 'type_id', $id, 'purchase_bill_payment_recive',$ledger_id);
						
					//Code for  add Transaction Details according to Details	
					if ($success) {
                        $data['message'] = "Payment updated successfully";
                        logActivity('Payment Updated','payment',$id);
                        $this->session->set_flashdata('message', 'Payment Updated successfully');
					    redirect(base_url().'account/paymentto', 'refresh');
                    }
				}else{
					if (!empty($data)){
						/* Get Details of paid and not paid and update invoice Table accordingly*/
						$get_proper_bills_paid = json_decode($data['payment_detail']);
							foreach($get_proper_bills_paid as $paid_bills_data){
								$bill_id = $paid_bills_data->bill_id;
								$open_balance = $paid_bills_data->open_balance;
								$payment_amount = $paid_bills_data->payment_amount;
								$order_code_check_for_order_table_data = $paid_bills_data->order_code;
								$pi_id = $paid_bills_data->pi_id;
							if($order_code_check_for_order_table_data == 'undefined' && $_POST['throu_pi_or_not'] == 0){
										if($open_balance != $payment_amount){
										// if($data['balance'] != 0){
											$balance = $open_balance - $payment_amount;
											 $update_data = array(
													'grand_total' => abs($balance),
													'charges_total_tax' => '0'
											);
											$this->account_model->add_balance_amount_or_paid('purchase_bill',$update_data, $bill_id);
										}else{
											$update_data = array(
													'pay_or_not' => '1',
													'charges_total_tax' => '0'
											);
									    	$this->account_model->add_balance_amount_or_paid('purchase_bill',$update_data, $bill_id);
										}
								}elseif($order_code_check_for_order_table_data != 'undefined' && $_POST['throu_pi_or_not'] == 0){
									if($open_balance != $payment_amount){
									// if($data['balance'] != 0){
											$balance = $open_balance - $payment_amount;
											 $update_data = array(
													'grand_total' => abs($balance),
													//'charges_total_tax' => '0'
											);
											$this->account_model->add_balance_amount_or_paid('purchase_order',$update_data, $bill_id);
										}else{
											$date22 = date('Y-m-d H:i:s');
											$update_data = array(
													'pay_or_not' => '1',
													'mrn_or_not' => '1',
													'ifbalance' => '0',
													'complete_date' => $date22 
											);
											$this->account_model->add_balance_amount_or_paid('purchase_order',$update_data, $bill_id);
										}
								}elseif($_POST['throu_pi_or_not'] != 0){
									if($open_balance != $payment_amount){
										// if($data['balance'] != 0){
											$balance = $open_balance - $payment_amount;
										
											 $update_data = array(
													'grand_total' => $balance,
													//'charges_total_tax' => '0'
											);
											$this->account_model->add_balance_amount_or_paid('purchase_indent',$update_data, $_POST['throu_pi_or_not']);
										}else{
											$update_data = array(
													'pay_or_not' => '1',
													//'charges_total_tax' => '0'		
											);
										
											$this->account_model->add_balance_amount_or_paid('purchase_indent',$update_data, $_POST['throu_pi_or_not']);
										}
								}	
						}
							
							//die('after for loop');
				
						/* Get Details of paid and not paid and update invoice Table accordingly*/
							$id = $this->account_model->insert_tbl_data('payment',$data);
							$debit_data['debit_dtl'] = '0';
							$debit_data['ledger_id'] = $_REQUEST['recieve_ledger_id'];
							$debit_data['credit_dtl'] = $_POST['added_amount'];
							$debit_data['type'] = 'purchase_bill_payment_recive';
							$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$debit_data['created_by_cid'] = $this->companyGroupId;
							//$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
							$debit_data['type_id'] = $id;
							$debit_data['cancel_restore'] = 1;
							$debit_data['add_date'] = $add_Date;
							$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
							/* For Sale Ledger Details data*/
							
							/* For Purchase Ledger Details data*/
							$credit_data['debit_dtl'] = $_POST['added_amount'];
							$credit_data['ledger_id'] = $_POST['party_id'];
							$credit_data['credit_dtl'] = '0';
							$credit_data['type'] = 'purchase_bill_payment_recive';
							$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$credit_data['created_by_cid'] = $this->companyGroupId;
							//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
							$credit_data['type_id'] = $id;
							$credit_data['cancel_restore'] = 1;
							$credit_data['add_date'] = $add_Date;
							$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);						
						
					}
					if ($id) {                        
                        logActivity('New Payment details Created','payment',$id);
                        $this->session->set_flashdata('message', 'Payment inserted successfully');
					   redirect(base_url().'account/paymentto', 'refresh');
                    }    				
				}
			}			
        }
	
  }	

public function delete_payment_to($id = ''){
		if (!$id) {
           redirect('account/paymentto', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('payment','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'purchase_bill_payment_recive');
		if($result){
			logActivity('Payment Deleted','payment',$id);
			$this->session->set_flashdata('message', 'Payment Deleted Successfully');
			$result = array('msg' => 'Payment Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/paymentto');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1050'));
        }
	}




/*********************************************************************************************************/	
/******************Purchase Bill MODULE Start*******************************************************/	
/***************************************************************************************************/
public function create_purchaseBill(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Purchase Bill', base_url() . 'Purchase Bill');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Purchase Bill';
		$this->_render_template('purchase_bill/edit', $this->data);
	}
	public function  purchase_bill(){
			$this->load->library('pagination');
			$this->data['can_edit'] = edit_permissions();
			$this->data['can_delete'] = delete_permissions();
			$this->data['can_add'] = add_permissions();
			$this->breadcrumb->add('Purchase Bill', base_url() . 'Purchase Bill');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Purchase Bill';
			$created_by_id  = $_SESSION['loggedInUser']->u_id;
			//$connected_com_id  = $_SESSION['loggedInUser']->c_id;
			$connected_com_id  = $this->companyGroupId;
			
			/* For Financial Year*/
				$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
				$date_fcal = json_decode($date_fun->financial_year_date,true);
				
			if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}
			$original_Date_start = $_GET['start'];
			$cnvrted_newDate = date("Y-m-d", strtotime($original_Date_start));
			$original_Date_end = $_GET['end'];
			$cnvrted_newDate_end = date("Y-m-d", strtotime($original_Date_end));
			if($_GET['tab']=='auto_entry'){
					$where=array('created_by_cid'=>$connected_com_id,'invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date);
				}elseif($_GET['tab']=='purchase_bill'){
					$where=array('created_by_cid'=>$connected_com_id,'purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date,'auto_entry' => 0,'save_status'=>1);
				}elseif($_GET['tab']==''){
					$where=array('created_by_cid'=>$connected_com_id,'purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date,'auto_entry' => 0 );
				}
			if(!empty($_GET['hsnsac_number'])){
				$invalid_hsnsac = implode(',', $_GET['hsnsac_number']);
				$this->data['purchase_data']  = $this->account_model->get_ledgers_whereIn_conditions('purchase_bill',$connected_com_id,$invalid_hsnsac);
				}
			
			if(isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '') {
				if($_GET['tab']!='auto_entry' && $_GET['tab'] == 'purchase_bill'){
					$where=array('created_by_cid'=>$connected_com_id,'purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date,'auto_entry' => 0 ,'save_status'=>1);
				}elseif($_GET['tab']=='auto_entry' && $_GET['tab']!='purchase_bill'){
					$where=array('created_by_cid'=>$connected_com_id,'invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date);
				}else{
					$where=array('created_by_cid'=>$connected_com_id,'purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date,'auto_entry' => 0 );
				}
			}elseif(isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= '') {
				if($_GET['tab']=='auto_entry' && $_GET['tab']!='purchase_bill'){
					
					$where = "purchase_bill.created_by_cid = ".$connected_com_id." AND  (purchase_bill.date >='".$cnvrted_newDate."' AND  purchase_bill.date <='".$cnvrted_newDate_end."')";
					
				}elseif($_GET['tab']!='auto_entry' && $_GET['tab'] == 'purchase_bill'){
					
					$where=array('party_conn_company'=> $connected_com_id,'accept_reject'=>'','invoice.created_date >=' => $_GET['start'] , 'invoice.created_date <=' => $_GET['end'],'invoice.created_by_cid'=> $this->companyGroupId);
					
				}else{
					$where = "purchase_bill.created_by_cid = ".$connected_com_id." AND  (purchase_bill.date >='".$cnvrted_newDate."' AND  purchase_bill.date <='".$cnvrted_newDate_end."')";
					
				}
			}
			if(isset($_GET['start']) && isset($_GET['end']) && isset($_GET['ExportType'])==''){
			    $where = "purchase_bill.created_by_cid = ".$connected_com_id." AND  (purchase_bill.date >='".$_GET['start']."' AND  purchase_bill.date <='".$_GET['end']."') AND save_status=1";
				
				$this->data['purchase_data']  = $this->account_model->get_purchase_invoice_details('purchase_bill',$where, $config["per_page"], $page,$where2,$order,$export_data);
				
			    $this->data['automatic_purchase_bill']  = $this->account_model->get_auto_invoice_details('invoice',array('party_conn_company'=> $connected_com_id,'accept_reject'=>'','invoice.created_date >=' => $_GET['start'] , 'invoice.created_date <=' => $_GET['end'],'invoice.created_by_cid'=> $this->companyGroupId), $config["per_page"], $page,$where2,$order,$export_data);
				
				$this->data['purchase_data_form_mrn']  = $this->account_model->get_purchase_invoice_details('purchase_bill',array('purchase_bill.created_by_cid' => $this->companyGroupId,'auto_entry'=>'1','purchase_bill.date >=' =>$_GET['start'], 'purchase_bill.date <=' => $_GET['end']), $config["per_page"], $page,$where2,$order,$export_data);
				}
		
			//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2="id like'%".$search_string."%'";
		 redirect("account/purchase_bill/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "id like'%". $_GET['search']."%'";
				
			}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
		//echo $_GET['tab'];
		if($_GET['tab']=='purchase_bill' && $_GET['tab']!='auto_entry')
		{
			$rows=$this->account_model->num_rows('purchase_bill',$where,$where2);
		}elseif($_GET['tab']=='auto_entry' && $_GET['tab']!='purchase_bill'){
			//$rows=$this->account_model->num_rows('invoice',$where,$where2);
			$rows=$this->account_model->num_rows('purchase_bill',array('purchase_bill.created_by_cid' => $this->companyGroupId,'auto_entry'=>'1'),$where2);
		}
		else
		{
			$rows=$this->account_model->num_rows('purchase_bill',$where,$where2);
		}
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/purchase_bill/";
			$config["total_rows"] = $rows;
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
				if(!empty($_GET['ExportType'])){
				$export_data = 1;
				}else{
				$export_data = 0;
				}
				
		if($_GET['tab']=='purchase_bill' && $_GET['tab']!='auto_entry'){		
			$this->data['purchase_data']  = $this->account_model->get_purchase_invoice_details('purchase_bill',$where, $config["per_page"], $page,$where2,$order,$export_data);
		}elseif($_GET['tab']=='auto_entry' && $_GET['tab']!='purchase_bill'){		
			//$this->data['automatic_purchase_bill']  = $this->account_model->get_auto_invoice_details('invoice',array('party_conn_company'=> $connected_com_id,'accept_reject'=>'','invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date), $config["per_page"], $page,$where2,$order,$export_data);
			$this->data['purchase_data_form_mrn']  = $this->account_model->get_purchase_invoice_details('purchase_bill',array('purchase_bill.created_by_cid' => $this->companyGroupId,'auto_entry'=>'1','purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date), $config["per_page"], $page,$where2,$order,$export_data);
		}else{		
			$this->data['purchase_data']  = $this->account_model->get_purchase_invoice_details('purchase_bill',$where, $config["per_page"], $page,$where2,$order,$export_data);
			$this->data['purchase_data_form_mrn']  = $this->account_model->get_purchase_invoice_details('purchase_bill',array('purchase_bill.created_by_cid' => $this->companyGroupId,'auto_entry'=>'1','purchase_bill.created_date >=' =>$first_date, 'purchase_bill.created_date <=' => $second_date), $config["per_page"], $page,$where2,$order,$export_data);
			$this->data['automatic_purchase_bill']  = $this->account_model->get_auto_invoice_details('invoice',array('party_conn_company'=> $connected_com_id,'accept_reject'=>'','invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date), $config["per_page"], $page,$where2,$order,$export_data);
			$where2 = array('account_freeze.created_by_cid' => $this->companyGroupId);
			$this->data['freeze_date']  = $this->account_model->get_account_freeze('account_freeze',$where2);
			}
			
		 if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
				}
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
	   if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		$this->_render_template('purchase_bill/index', $this->data);
	}
			
			// $this->data['purchase_data']  = $this->account_model->get_purchase_invoice_details('purchase_bill',array('created_by'=> $created_by_id));
			// $this->data['automatic_purchase_bill']  = $this->account_model->get_auto_invoice_details('invoice',array('party_conn_company'=> $connected_com_id,'accept_reject'=>''));$this->_render_template('purchase_bill/index', $this->data);
	


	public function editpurchase_bill_detail(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->uri->segment(3));
			$this->data['docss'] = $this->account_model->get_image_byId('attachments', 'rel_id', $this->uri->segment(3),'purchase bill');			
			$this->_render_template('purchase_bill/edit', $this->data);
		}else{
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');
				$this->data['docss'] = $this->account_model->get_image_byId('attachments', 'rel_id', $this->input->post('id'),'purchase bill');				
				$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));	 		
				$this->load->view('purchase_bill/edit', $this->data);
			}
		}	
	}
	
public function viewpurchase_bill_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));			
			$this->load->view('purchase_bill/view', $this->data);
		}	
	}
public function viewpurchase_bill_mat_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));			
			$this->load->view('purchase_bill/mat_view', $this->data);
		}	
	}	
public function viewpurchase_register_detail(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));			
			$this->load->view('purchaseregister/view', $this->data);
		}	
	}	
	
public function viewpurchase_unpaid_bill_detail(){
	if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			//$this->data['purchase_data'] = $this->account_model->get_data_byId('purchase_bill','id',$this->input->post('id'));
			$this->data['purchase_data'] = $this->account_model->not_paid_purchase_bill('purchase_bill',array('supplier_name'=> $_REQUEST['id'],'auto_entry'=> 0));	
			$this->load->view('accountpayable/view_unpaid_bill', $this->data);
		}	
	}	
	


public function viewautomatic_entry_invoice(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['auto_invoice_data'] = $this->account_model->get_data_byId('invoice','id',$this->input->post('id'));			
			$this->load->view('purchase_bill/view_auto_invoice', $this->data);
		}	
	}	


//GET supplier DETAILS
	public function Getsupplier_details(){
		
		if($_REQUEST['id'] && $_REQUEST['id'] != ''){
			$data = $this->account_model->get_matrial_data_byId('ledger','id',$_REQUEST['id']);
			echo json_encode($data,true);
			die;
			 
		 }
		
	}
//Get Email for Supplier Payment	
public function getEmail(){        
        $id = $_POST['supplier_name'];
        $data = $this->account_model->get_email('supplier',$id);
    
        $contact_email = '';    
        foreach($data as $val){
            $email_Data = json_decode($val['contact_detail'],true);
            $contact_email = $email_Data[0]['email'];
        }
        echo $contact_email;
}
//Get Email for Supplier Payment

public function savepurchase_bill_Details(){
	  if ($this->input->post()) {
		 // pre($_POST);die();
			$sec = strtotime( $_POST['date']);  
			$add_Date = date ("Y-m-d H:i", $sec);
			
			
			$total =  $_POST['invoice_grandtotal'] -  $_POST['totaltax_total'];
			$subtotal_tax_withtax = array(array('total'=>$_POST['total_AMMT'],'totaltax'=>$_POST['totaltax_total'],'invoice_total_with_tax'=>$_POST['invoice_total_with_tax'][0],'cess_all_total' => $_POST['cess_total'],'tcsonOffAMT' => $_POST['tcsonOffAMT']));
			$totoaal_tax_data = json_encode($subtotal_tax_withtax);
		  /*Calulation for get amount with tax and tax*/
		   
			$CGST = $SGST = $IGST = 0;
			
			$usersWithViewPermissions = $this->account_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 34));
			
			if($_POST['party_billing_state_id'] != $_POST['sale_company_state_id']){
				$IGST = $_POST['totaltax_total'];
				
			}else{
				
				$divide_cgst_sgst = $_POST['totaltax_total']/2;
				//$divide_charge_tax = $charges_tax / 2;
				 $CGST = $divide_cgst_sgst;
				 $SGST = $divide_cgst_sgst;
			}
			
			
			  
			$charges_Added_Count = 	count($_POST['charges_added']);
					
					if($charges_Added_Count > 0){
						$charg_Add = [];
						$ch = 0;
						while($ch < $charges_Added_Count){
							//$jsonarray_chargeobj = (array('particular_charges_name'=>$_POST['particular_charges'][$ch],'charges_added'=>$_POST['charges_added'][$ch],'sgst_amt'=>$_POST['sgst_amt'][$ch],'cgst_amt'=>$_POST['cgst_amt'][$ch],'igst_amt'=>$_POST['igst_amt'][$ch],'amt_with_tax'=>$_POST['amt_with_tax'][$ch]));

							$jsonarray_chargeobj = (array('particular_charges_name'=>$_POST['particular_charges'][$ch],'type_charges'=>$_POST['type_charges'][$ch],'ledger_name'=>$_POST['ledger_name'][$ch],'ledger_name_id'=>$_POST['ledger_name_id'][$ch],'amt_tax'=>$_POST['amt_tax'][$ch],'charges_added'=>$_POST['charges_added'][$ch],'sgst_amt'=>$_POST['sgst_amt'][$ch],'cgst_amt'=>$_POST['cgst_amt'][$ch],'igst_amt'=>$_POST['igst_amt'][$ch],'amt_with_tax'=>$_POST['amt_with_tax'][$ch]));
							$charg_Add[$ch] = $jsonarray_chargeobj;
							$ch++;
						}
						$json_charg_lead_total_array = json_encode($charg_Add);
					}else{
						$json_charg_lead_total_array = '';
					}
					
				

		   $descr_of_bills_Length = count($_POST['descr_of_bills']);
				if($descr_of_bills_Length >0){
					$arra = [];
					$i = 0;
					while($i < $descr_of_bills_Length) {	
						$jsonArrayObject = (array('descr_of_bills' => $_POST['descr_of_bills'][$i],'product_details' => $_POST['product_details'][$i], 'qty' => $_POST['qty'][$i],'UOM' => $_POST['UOM'][$i],'hsnsac' => $_POST['hsnsac'][$i],'rate' => $_POST['rate'][$i],'tax' => $_POST['tax'][$i],'added_tax_Row_val' => $_POST['added_tax_Row_val'][$i],'amountwittax' => $_POST['amount'][$i],'subtotal' => $_POST['subtotal'][$i],'disctype'=>$_POST['disctype'][$i],'discamt'=>$_POST['discamt'][$i],'after_desc_amt'=>$_POST['after_desc_amt'][$i],'cess'=>$_POST['cess'][$i],'valuation_type'=>$_POST['valuation_type'][$i],'cess_tax_calculation'=>$_POST['cess_tax_calculation'][$i]));
						$arra[$i] = $jsonArrayObject;
						$i++;
				}	
					$purchase_bill_Detail = json_encode($arra);
				}else{
					$purchase_bill_Detail = '';
				}
				
				// pre($_POST);
				// pre($_POST['totaltax_total']);
				
					// $debit_amt = $_POST['total_amount']  -  $_POST['totaltax_total']; 
					$debit_amt = $_POST['invoice_grandtotal']  -  $_POST['totaltax_total']; 
					$matrial_dtl = json_decode($purchase_bill_Detail);
			 
				
			
			
			$required_fields = array('supplier_name','descr_of_bills');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				
				$data  = $this->input->post();			
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				//$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$data['created_by_cid'] = $this->companyGroupId;
				$data['descr_of_bills'] = $purchase_bill_Detail;
				$data['date'] = date("Y-m-d", strtotime($_POST['date']));
				$data['charges_added'] = $json_charg_lead_total_array;	
				$data['IGST'] = $IGST;
				$data['CGST'] = $CGST;
				$data['SGST'] = $SGST;
				$data['invoice_total_with_tax'] = $totoaal_tax_data;
				$data['product_detail'] = 'From Bill';
				$id = $data['id'];

				$data['npdm_id'] = $_POST['npdm_name'];
				$data['grand_total'] = $_POST['invoice_grandtotal'];
				$data['total_amount'] = $_POST['invoice_grandtotal'];
				//pre($totoaal_tax_data);
				// pre($data);
				
				
				// die('dd');
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					//$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$data['created_by_cid'] = $this->companyGroupId;
					$success = $this->account_model->update_data('purchase_bill',$data, 'id', $id);	
					 /* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_POST['supplier_name'];
					$debit_data['credit_dtl'] = $_POST['total_AMMT'];
					$debit_data['type'] = 'purchase_bill';
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 1;
					$debit_data['add_date'] = $add_Date;
			
					$this->account_model->update_transaction_data_chk('transaction_dtl',$debit_data, 'type_id', $id, 'purchase_bill',$_POST['supplier_name']);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['invoice_grandtotal'];
					$credit_data['ledger_id'] = $_POST['party_name'];
					//$credit_data['credit_dtl'] = $debit_amt;
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'purchase_bill';
					$credit_data['type_id'] = $id;
					$credit_data['cancel_restore'] = 1;
					$credit_data['add_date'] = $add_Date; 
					$this->account_model->update_transaction_data_chk('transaction_dtl',$credit_data, 'type_id', $id, 'purchase_bill',$_POST['party_name']);
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($CGST !=''){
								$CGST_data['debit_dtl'] = $CGST;
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = '0';
								$CGST_data['type'] = 'purchase_bill';
								$CGST_data['cancel_restore'] = 1;
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								//$CGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$CGST_data['type_id'] = $id;
								$CGST_data['add_date'] = $add_Date; 
								$this->account_model->update_transaction_data_chk('transaction_dtl',$CGST_data, 'type_id', $id, 'purchase_bill','2');
							}
							
							if($SGST != ''){
								$SGST_data['debit_dtl'] = $SGST;
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = '0';
								$SGST_data['type'] = 'purchase_bill';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date; 
								$SGST_data['cancel_restore'] = 1;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								//$SGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$SGST_data, 'type_id', $id, 'purchase_bill','3');
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($IGST != ''){
								$IGST_data['debit_dtl'] = $IGST;
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = '0';
								$IGST_data['type'] = 'purchase_bill';
								$IGST_data['type_id'] = $id;
								$IGST_data['cancel_restore'] = 1;
								$IGST_data['add_date'] = $add_Date; 
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								//$IGST_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$IGST_data, 'type_id', $id, 'purchase_bill','1');
							}
						if($data['auto_entry'] == '1' ){
							
							 /* For Sale Ledger Details data*/
									$debit_data['debit_dtl'] = '0';
									$debit_data['ledger_id'] = $_POST['supplier_name'];
									$debit_data['credit_dtl'] = $_POST['total_AMMT'];
									$debit_data['type'] = 'purchase_bill';
									$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
									$debit_data['created_by_cid'] = $this->companyGroupId;
									$debit_data['type_id'] = $id;
									$debit_data['cancel_restore'] = 1;
									$debit_data['add_date'] = $add_Date;
									
									$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
									/* For Sale Ledger Details data*/
									
									/* For Purchase Ledger Details data*/
									$credit_data['debit_dtl'] = $_POST['invoice_grandtotal'];
									$credit_data['ledger_id'] = $_POST['party_name'];
									//$credit_data['credit_dtl'] = $debit_amt;
									$credit_data['credit_dtl'] = '0';
									$credit_data['type'] = 'purchase_bill';
									$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
									$credit_data['created_by_cid'] = $this->companyGroupId;
									$credit_data['type_id'] = $id;
									$credit_data['cancel_restore'] = 1;
									$credit_data['add_date'] = $add_Date;
									$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
									/* For Purchase Ledger Details data*/
							
							/* For CGST SGST IGST Table*/
									if($CGST !=''){
										$CGST_data['debit_dtl'] = $CGST;
										$CGST_data['ledger_id'] = '2';
										$CGST_data['credit_dtl'] = '0';
										$CGST_data['cancel_restore'] = 1;
										$CGST_data['type'] = 'purchase_bill';
										$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$CGST_data['created_by_cid'] = $this->companyGroupId;
										$CGST_data['type_id'] = $id;
										$CGST_data['add_date'] = $add_Date;
										$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
										//$tax = array('CGST'=> $_POST['CGST']);
									}
									
									if($SGST != ''){
										$SGST_data['debit_dtl'] = $SGST;
										$SGST_data['ledger_id'] = '3';
										$SGST_data['credit_dtl'] = '0';
										$SGST_data['type'] = 'purchase_bill';
										$SGST_data['type_id'] = $id;
										$SGST_data['cancel_restore'] = 1;
										$SGST_data['add_date'] = $add_Date;
										$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$SGST_data['created_by_cid'] = $this->companyGroupId;
										$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
										//$tax = array('SGST'=> $_POST['SGST']);
									}
									
									if($IGST != ''){
										$IGST_data['debit_dtl'] = $IGST;
										$IGST_data['ledger_id'] = '1';
										$IGST_data['credit_dtl'] = '0';
										$IGST_data['type'] = 'purchase_bill';
										$IGST_data['type_id'] = $id;
										$IGST_data['cancel_restore'] = 1;
										$IGST_data['add_date'] = $add_Date;
										$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$IGST_data['created_by_cid'] = $this->companyGroupId;
										$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
									}
									
									//$this->account_model->update_data('purchase_bill',$data, 'id', $id);
									$this->account_model->update_single_data_for_purchase_bill_auto_entery($id,'purchase_bill');
								}		
					
					/*Update Code For charges Ledgers and Discount Ledgers*/
					$ddt =	json_decode($json_charg_lead_total_array, true);
				if($ddt[0]['particular_charges_name'] != ''){	
						$charges_Discount_data = json_decode($json_charg_lead_total_array,true);
						
						foreach($charges_Discount_data as $chrg_data){
							if(!empty($chrg_data)){
							
							if($chrg_data['type_charges'] == 'plus'){
								$charges_Data['debit_dtl'] =  $chrg_data['charges_added'];
								$charges_Data['credit_dtl'] = '0';
								$charges_Data['add_date'] = $add_Date;
								$charges_Data['cancel_restore'] = 1;
								$this->account_model->update_single_data_for_charges($chrg_data['amt_with_tax'], $id,'purchase_bill');//USd to add Charges in Per invoice 
								$this->account_model->update_transaction_data_purchase_bill('transaction_dtl',$charges_Data, 'type_id', $id, 'purchase_bill',$chrg_data['ledger_name_id']);
							}else{
								$charges_Data['debit_dtl'] = '0';
								$charges_Data['cancel_restore'] = 1;
								$charges_Data['credit_dtl'] = $chrg_data['charges_added'];
								$this->account_model->update_transaction_data_purchase_bill('transaction_dtl',$charges_Data, 'type_id', $id, 'purchase_bill',$chrg_data['ledger_name_id']);
							}
						}	
					}
				}
		
					/*Update Code For charges Ledgers and Discount Ledgers*/
					
					/* Enable RCM code start*/
						
						$get_RCM_enable_or_not = getNameById('ledger',$_POST['supplier_name'],'id');
				
						$get_party_state = getNameById('ledger',$_POST['party_name'],'id');
						$supplier_state_id = json_decode($get_RCM_enable_or_not->mailing_address,true);
						$party_state_id = json_decode($get_party_state->mailing_address,true);
						
						if($get_RCM_enable_or_not->enble_disbl_rcm == 1){// if 1 its Enable RCM
						
						if($party_state_id[0]['mailing_state'] != $supplier_state_id[0]['mailing_state']){	
							  $Voucher_DAta ='[{"credit_debit_party_dtl":"'.$_POST['supplier_name'].'","credit_1":"'.$_POST['total'][0].'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"'.$_POST['party_name'].'","credit_1":"","debit_1":"'.$_POST['total'][0].'","cr_dr":"debit"},{"credit_debit_party_dtl":"1","credit_1":"","debit_1":"'.$IGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"4","credit_1":"'.$IGST.'","debit_1":"","cr_dr":"credit"}]';
						}else{
							$Voucher_DAta ='[{"credit_debit_party_dtl":"'.$_POST['supplier_name'].'","credit_1":"'.$_POST['total'][0].'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"'.$_POST['party_name'].'","credit_1":"","debit_1":"'.$_POST['total'][0].'","cr_dr":"debit"},{"credit_debit_party_dtl":"2","credit_1":"","debit_1":"'.$CGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"3","credit_1":"","debit_1":"'.$SGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"5","credit_1":"'.$CGST.'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"6","credit_1":"'.$SGST.'","debit_1":"","cr_dr":"credit"}]';
						}
										
						$voucher_tbl_Data['credit_debit_party_dtl'] = $Voucher_DAta;
						$voucher_tbl_Data['voucher_name'] = '18';
						$voucher_tbl_Data['voucher_date'] = $_POST['date'];
						$voucher_tbl_Data['total'] = $_POST['total'][0];
						$voucher_tbl_Data['purchase_id'] = $id;
						$voucher_tbl_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$voucher_tbl_Data['created_by_cid'] = $this->companyGroupId;
						$voucher_tbl_Data['edited_by'] = $_SESSION['loggedInUser']->u_id;
						
						$this->account_model->update_data('voucher',$voucher_tbl_Data, 'purchase_id', $id);
				}
					/* Enable RCM code start*/
					if(!empty($usersWithViewPermissions)){
						foreach($usersWithViewPermissions as $userViewPermission){
							if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
								pushNotification(array('subject'=> 'Purchase Bill Updated' , 'message' => 'Purchase Bill id : #'.$id.' is updated by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id,'class'=>'add_purchase_bill_to_tabs','data_id' => 'purchase_bill_view','icon'=>'fa-shopping-cart'));
							}
						}
					}
					if($_SESSION['loggedInUser']->role !=1){
						pushNotification(array('subject'=> 'Purchase Bill Updated' , 'message' => 'Purchase Bill id : #'.$id.' is updated by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id , 'ref_id'=> $id,'class'=>'add_purchase_bill_to_tabs','data_id' => 'purchase_bill_view','icon'=>'fa-shopping-cart'));
					}
						//pre($_FILES);die();
					/* For Purchase Details data*/
						if(!empty($_FILES['bill_attachment_files']['name']) && $_FILES['bill_attachment_files']['name'][0]!=''){
							
							$bills_array = array();
							$docCount = count($_FILES['bill_attachment_files']['name']);
							
							for($j = 0; $j < $docCount; $j++)
							{
									$filename = $_FILES['bill_attachment_files']['name'][$j];
									$tmpname  = $_FILES['bill_attachment_files']['tmp_name'][$j];               
									$type     = $_FILES['bill_attachment_files']['type'][$j];               
									$error    = $_FILES['bill_attachment_files']['error'][$j];
									$size     = $_FILES['bill_attachment_files']['size'][$j];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext; 
									$config['upload_path'] = 'assets/modules/account/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000'; 
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									
									move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);
									
									$bills_array[$j]['rel_id'] = $id;
									$bills_array[$j]['rel_type'] = 'purchase bill';
									$bills_array[$j]['file_name'] = $newname;
									$bills_array[$j]['file_type'] = $type;
									
							}
							if(!empty($bills_array)){
						   /* Insert file information into the database */
							$docsAttachmentID = $this->account_model->insert_attachment_data('attachments', $bills_array,'account/purchase_bill/'.$id);
							}
							
						}
					
					
					
					
					if ($success) {
                        $data['message'] = "Bill Detail updated successfully";
                        logActivity('Bill Detail Updated','purchase_bill',$id);
                        $this->session->set_flashdata('message', 'Bill Detail Updated successfully');
					    redirect(base_url().'account/purchase_bill', 'refresh');
                    }
				}else{
					//
					if (!empty($data)){
						
					/*Product Details Inventory Process*/
					
					$saleLedger_addresschk = getNameById('company_address',$_POST['purchase_lger_brnch_id'],'compny_branch_id');
					
					$locationIds = $saleLedger_addresschk->id;
					//pre($locationIds);die();
						foreach($matrial_dtl as $for_increase_qty){
							$mat_idd = $for_increase_qty->product_details;
							$mat_qqty = $for_increase_qty->qty;
							$get_dataa = $this->account_model->get_matrial_qty_invoice('mat_locations',$mat_idd,$locationIds);
							$remaining_qty =  $get_dataa['quantity'] + $mat_qqty;
							$this->account_model->update_matrial_qty_invoice('mat_locations',$mat_idd,$remaining_qty,$locationIds);
						}
					/*Product Details Inventory Process*/
						// pre($_POST);die();
						$id = $this->account_model->insert_tbl_data('purchase_bill',$data); 
						
						
						/* Enable RCM code start*/
						
						$get_RCM_enable_or_not = getNameById('ledger',$_POST['supplier_name'],'id');
				
						$get_party_state = getNameById('ledger',$_POST['party_name'],'id');
						$supplier_state_id = json_decode($get_RCM_enable_or_not->mailing_address,true);
						$party_state_id = json_decode($get_party_state->mailing_address,true);
						
						if($get_RCM_enable_or_not->enble_disbl_rcm == 1){// if 1 its Enable RCM
						
							if($party_state_id[0]['mailing_state'] != $supplier_state_id[0]['mailing_state']){	
								  $Voucher_DAta ='[{"credit_debit_party_dtl":"'.$_POST['supplier_name'].'","credit_1":"'.$_POST['total'][0].'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"'.$_POST['party_name'].'","credit_1":"","debit_1":"'.$_POST['total'][0].'","cr_dr":"debit"},{"credit_debit_party_dtl":"1","credit_1":"","debit_1":"'.$IGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"4","credit_1":"'.$IGST.'","debit_1":"","cr_dr":"credit"}]';
										
										$IGST_urds_data['debit_dtl'] = '0';
										$IGST_urds_data['ledger_id'] = 4;
										$IGST_urds_data['credit_dtl'] = $IGST;
										$IGST_urds_data['type'] = 'purchase_bill';
										$IGST_urds_data['type_id'] = $id;
										$IGST_urds_data['add_date'] = $add_Date;
										$IGST_urds_data['created_by'] = $_SESSION['loggedInUser']->u_id;
										$IGST_urds_data['created_by_cid'] = $this->companyGroupId;
										$this->account_model->insert_tbl_data('transaction_dtl',$IGST_urds_data); 
										
								}else{
								$Voucher_DAta ='[{"credit_debit_party_dtl":"'.$_POST['supplier_name'].'","credit_1":"'.$_POST['total'][0].'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"'.$_POST['party_name'].'","credit_1":"","debit_1":"'.$_POST['total'][0].'","cr_dr":"debit"},{"credit_debit_party_dtl":"2","credit_1":"","debit_1":"'.$CGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"3","credit_1":"","debit_1":"'.$SGST.'","cr_dr":"debit"},{"credit_debit_party_dtl":"5","credit_1":"'.$CGST.'","debit_1":"","cr_dr":"credit"},{"credit_debit_party_dtl":"6","credit_1":"'.$SGST.'","debit_1":"","cr_dr":"credit"}]';
								
								$CGST_URDS_data['debit_dtl'] = $CGST;
								$CGST_URDS_data['ledger_id'] = 5;
								$CGST_URDS_data['credit_dtl'] = '0';
								$CGST_URDS_data['type'] = 'voucher';
								$CGST_URDS_data['type_id'] = $id;
								$CGST_URDS_data['add_date'] = $add_Date;
								$CGST_URDS_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_URDS_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_URDS_data);
								
								$SGST_URDS_data['debit_dtl'] = $SGST;
								$SGST_URDS_data['ledger_id'] = 6;
								$SGST_URDS_data['credit_dtl'] = '0';
								$SGST_URDS_data['type'] = 'voucher';
								$SGST_URDS_data['type_id'] = $id;
								$SGST_URDS_data['add_date'] = $add_Date;
								$SGST_URDS_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_URDS_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_URDS_data);
							}				
							$voucher_tbl_Data['credit_debit_party_dtl'] = $Voucher_DAta;
							$voucher_tbl_Data['voucher_name'] = '18';
							$voucher_tbl_Data['voucher_date'] = $_POST['date'];
							$voucher_tbl_Data['total'] = $_POST['total'][0];
							$voucher_tbl_Data['purchase_id'] = $id;
							$voucher_tbl_Data['created_by'] = $_SESSION['loggedInUser']->c_id;
							$voucher_tbl_Data['created_by_cid'] = $this->companyGroupId;
							//pre($voucher_tbl_Data);die();
						
						$this->account_model->insert_tbl_data('voucher',$voucher_tbl_Data);
							
					}
					/* Enable RCM code End*/
				
				
				
					 /* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_POST['supplier_name'];
					$debit_data['credit_dtl'] = $_POST['total_AMMT'];
					$debit_data['type'] = 'purchase_bill';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 1;
					$debit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					
					
					
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['invoice_grandtotal'];
					$credit_data['ledger_id'] = $_POST['party_name'];  
					//$credit_data['credit_dtl'] = $debit_amt;
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'purchase_bill';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
					$credit_data['type_id'] = $id;
					$credit_data['cancel_restore'] = 1;
					$credit_data['add_date'] = $add_Date;
					//pre($credit_data);die();
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
					/* For Purchase Ledger Details data*/
					
					/* For CGST SGST IGST Table*/
							if($CGST !=''){
								$CGST_data['debit_dtl'] = $CGST;
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = '0';
								$CGST_data['type'] = 'purchase_bill';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								$CGST_data['type_id'] = $id;
								$CGST_data['cancel_restore'] = 1;
								$CGST_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
								//$tax = array('CGST'=> $_POST['CGST']);
							}
							
							if($SGST != ''){
								$SGST_data['debit_dtl'] = $SGST;
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = '0';
								$SGST_data['type'] = 'purchase_bill';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 1;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
								//$tax = array('SGST'=> $_POST['SGST']);
							}
							
							if($IGST != ''){
								$IGST_data['debit_dtl'] = $IGST;
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = '0';
								$IGST_data['type'] = 'purchase_bill';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['cancel_restore'] = 1;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					
					
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
					$ddt =	json_decode($json_charg_lead_total_array, true);
				if($ddt[0]['particular_charges_name'] != ''){	
						$charges_Discount_data = json_decode($json_charg_lead_total_array,true);
						foreach($charges_Discount_data as $chrg_data){
							if(!empty($chrg_data)){
							if($chrg_data['type_charges'] == 'plus'){
								$charges_Data['debit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['ledger_id'] = $chrg_data['ledger_name_id'];
								$charges_Data['credit_dtl'] = '0';
								$charges_Data['type'] = 'purchase_bill';
								$charges_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$charges_Data['created_by_cid'] = $this->companyGroupId;
								$charges_Data['type_id'] = $id;
								$charges_Data['add_date'] = $add_Date;
								$charges_Data['cancel_restore'] = 1;
								$this->account_model->update_single_data_for_charges($chrg_data['amt_with_tax'], $id,'purchase_bill');//USd to add Charges in Per invoice 
								$this->account_model->insert_tbl_data('transaction_dtl',$charges_Data);
							}else{
								$charges_Data['debit_dtl'] = '0';
								$charges_Data['ledger_id'] = $chrg_data['ledger_name_id'];
								$charges_Data['credit_dtl'] = $chrg_data['charges_added'];
								$charges_Data['type'] = 'purchase_bill';
								$charges_Data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$charges_Data['created_by_cid'] = $this->companyGroupId;
								$charges_Data['type_id'] = $id;
								$charges_Data['add_date'] = $add_Date;
								$charges_Data['cancel_restore'] = 1;
								$this->account_model->insert_tbl_data('transaction_dtl',$charges_Data);
							}
						}	
					}
				}	
					
					/*INSERT Code For charges Ledgers and Discount Ledgers*/
				}
					
					//pre($_FILES);die();
					/* For Purchase Details data*/
						if(!empty($_FILES['bill_attachment_files']['name']) && $_FILES['bill_attachment_files']['name'][0]!=''){
							
							$bills_array = array();
							$docCount = count($_FILES['bill_attachment_files']['name']);
							//pre($docCount);die();
							for($j = 0; $j < $docCount; $j++)
							{
									$filename = $_FILES['bill_attachment_files']['name'][$j];
									$tmpname  = $_FILES['bill_attachment_files']['tmp_name'][$j];               
									$type     = $_FILES['bill_attachment_files']['type'][$j];               
									$error    = $_FILES['bill_attachment_files']['error'][$j];
									$size     = $_FILES['bill_attachment_files']['size'][$j];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext; 
									$config['upload_path'] = 'assets/modules/account/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/account/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000'; 
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									
									move_uploaded_file($tmpname,"assets/modules/account/uploads/".$newname);
									
									$bills_array[$j]['rel_id'] = $id;
									$bills_array[$j]['rel_type'] = 'purchase bill';
									$bills_array[$j]['file_name'] = $newname;
									$bills_array[$j]['file_type'] = $type;
									
							}
							if(!empty($bills_array)){
						   /* Insert file information into the database */
							$docsAttachmentID = $this->account_model->insert_attachment_data('attachments', $bills_array,'account/purchase_bill/'.$id);
							}
							
						}
					if ($id) {                        
                        logActivity('New Bill Detail Created','purchase_bill',$id);
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'New Purchase Bill created' , 'message' => 'New Purchase Bill is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_purchase_bill_to_tabs','data_id' => 'purchase_bill_view' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'New Purchase Bill created' , 'message' => 'New Purchase Bill is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'add_purchase_bill_to_tabs','data_id' => 'purchase_bill_view','icon'=>'fa-shopping-cart'));
						}
                        $this->session->set_flashdata('message', 'New Bill Detail inserted successfully');
					     redirect(base_url().'account/purchase_bill', 'refresh');
                    }    				
				}
			}			
        }
	
  }
public function deletePurchase_bill_details($id = ''){	
		if (!$id) {
           redirect('account/purchase_bill', 'refresh');
        }
		permissions_redirect('is_delete');
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'purchase_bill');
		$this->account_model->delete_RCM_data('voucher','purchase_id', $id);
		
		$result = $this->account_model->delete_data('purchase_bill','id',$id);
		
		if($result){
			logActivity('Bill Detail Deleted','purchase_bill',$id);
			$this->session->set_flashdata('message', 'Bill Detail Deleted Successfully');
			$result = array('msg' => 'Bill Detail Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/purchase_bill');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1080'));
        }
	}

public function add_suppliers_detials_on_the_spot(){
	  
		$supplier_name = $_REQUEST['name'];
		$mailing_address = $_REQUEST['mailing_address'];
		$gstin = $_REQUEST['gstin'];
		$country = $_REQUEST['country'];
		$state = $_REQUEST['state'];
		$city_id = $_REQUEST['city_id'];
		$acc_group_id = $_REQUEST['acc_group_id'];
		$created_by_cid  = $this->companyGroupId;
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		
		$last_id = getLastTableId('supplier'); 
		$rId = $last_id + 1;
		$supCode = 'SUPP_'.rand(1, 1000000).'_'.$rId;
		
		$dd = $this->account_model->get_ledger_account_grp_Dtl('account_group',$created_by_cid,$_REQUEST['acc_group_id']); 
		
		$supplier_details = array(
					'supplier_code'=>$supCode,
					'name'=>$supplier_name,
					//'address'=>$address,
					'gstin'=>$gstin,
					'country'=>$country,
					'state'=>$state,
					'city'=>$city_id,
					'address'=>$mailing_address,
					'supp_account_group_id'=>$acc_group_id,
					'created_by_cid'=>$created_by_cid, 
					'created_by '=>$created_by_id 
				);
				
					
			//pre($supplier_details);die();		
					
					//$data_for_ledger['parent_group_id'] = $dd[0]['parent_group_id'];
		$data = $this->account_model->insert_on_spot_tbl_data('supplier',$supplier_details);
		
		$mailing_addressLength = count($_REQUEST['country']);
				if($mailing_addressLength >0){
					$arr = [];
					$i = 0;
					$idds = 1;
					while($i < $mailing_addressLength) {	
						$jsonArrayObject = (array('ID'=> $idds,'mailing_name'=>$supplier_name,'mailing_country' =>$country,'mailing_state' => $state,'mailing_city' => $city_id,'mailing_address'=>$mailing_address,'gstin_no'=>$gstin));
						$arr[$i] = $jsonArrayObject;
						$i++;
						$idds++;	
			
					}
					
					$descr_of_ldgr_array = json_encode($arr);
				}else{
					$descr_of_ldgr_array = '';
				}
		$supplier_details_ledger_tbl = array(
							'name'=>$supplier_name,
							'supp_id'=>$data,
							'gstin'=>$gstin,
							'account_group_id'=>$_REQUEST['acc_group_id'],
							'parent_group_id'=>$dd[0]['parent_group_id'],
							'created_by_cid'=>$created_by_cid, 
							'mailing_address'=>$descr_of_ldgr_array, 
							'created_by '=>$created_by_id 
						);
			$this->account_model->insert_on_spot_tbl_data('ledger',$supplier_details_ledger_tbl);
		
		if($data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}




/***********************************************************************************************************/	
/****************************** Ledger Report MODULE Start ************************************************/	
/********************************************************************************************************/

public function ledger_report(){
	$this->load->library('pagination');
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Ledger Report', base_url() . 'Ledger Report');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Ledger Report';
	$created_by_id  = $this->companyGroupId;
	$where2="";
	$order="";	
	$ledger_details = "(created_by_cid = '".$created_by_id."' OR created_by_cid = 0  )";

			$config = array();
			$config["base_url"] = base_url() . "account/ledger_report/";
			$config["total_rows"] = $this->account_model->num_rows('ledger',$ledger_details,$where2);
			$config["per_page"] = 20;
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
			$merage_report_Data['get_Data']  = $this->account_model->get_data_with_zero_id_condtionsFor_ledger_report('ledger',$created_by_id,$config["per_page"], $page,$where2,$order); 
			$this->_render_template('ladger_report/index', $merage_report_Data);
}

// public function ledger_report(){
	// $this->data['can_edit'] = edit_permissions();
	// $this->data['can_delete'] = delete_permissions();
	// $this->data['can_add'] = add_permissions();
	// $this->breadcrumb->add('Ledger Report', base_url() . 'Ledger Report');
	// $this->settings['breadcrumbs'] = $this->breadcrumb->output();
	// $this->settings['pageTitle'] = 'Ledger Report';
	// $created_by_id  = $this->companyGroupId;
	//$ladger_Rdata['get_Data']  = $this->account_model->get_invoice_details('ledger',array('created_by'=> $created_by_id)); 
	// $merage_report_Data['get_Data']  = $this->account_model->get_data_with_zero_id_condtions_ledger_report('ledger',$created_by_id); 
	//$suppliers_data  = $this->account_model->get_invoice_details('supplier',array('created_by'=> $created_by_id)); 
	//$merage_report_Data['get_Data'] = array_merge($ladger_Rdata, $suppliers_data);  
	
	// $this->_render_template('ladger_report/index', $merage_report_Data);
// }

//get_data_with_zero_id_condtions_ledger_report
public function get_ledger_account_detials(){
	$created_by_id  = $_SESSION['loggedInUser']->u_id;
	$created_by_cid  = $this->companyGroupId;
	$selected_ledger_id = $_REQUEST['ledger_party_id'];
	$data_type_transaction = $_REQUEST['data_type_transaction'];
	$login_user_id = $_SESSION['loggedInUser']->u_id;
	
	
		
		/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
				if(empty($date_fcal)){
						
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}
	/* For Financial Year*/
	
	if($_REQUEST['start'] =='' && $_REQUEST['end'] ==''){
	
			$selected_ledger_id = $_REQUEST['ledger_party_id'];
			$login_user_id = $_SESSION['loggedInUser']->u_id;
				$get_details = array(
					'ledger_id' => $selected_ledger_id,
					'created_by_cid' => $created_by_cid,
					'add_date >=' => $first_date,
					'add_date <=' => $second_date
				);
		}
		$get_ledger_Data = $this->account_model->get_ladger_account_Data('ledger',array('id'=> $selected_ledger_id));
	
		$sstartDAtet = date("Y-m-d", strtotime($get_ledger_Data[0]->created_date));//Ledger Creation Date
	
		if($_REQUEST['start'] !='' && $_REQUEST['end'] !=''){
			
			$where = "(transaction_dtl.add_date >='".$_REQUEST['start']."' AND  transaction_dtl.add_date <='".$_REQUEST['end']."') AND transaction_dtl.ledger_id = '". $_REQUEST['ledger_party_id']  ."' AND transaction_dtl.created_by_cid = '".$created_by_cid."'";
			
			
			
			$subtractDate = date('Y-m-d', strtotime('-1 day', strtotime($_REQUEST['start'])));
			
			
			$where2 = "(transaction_dtl.add_date >='".$sstartDAtet."' AND  transaction_dtl.add_date <='".$subtractDate."') AND transaction_dtl.ledger_id = '". $_REQUEST['ledger_party_id']  ."' AND transaction_dtl.created_by_cid = '".$created_by_cid."'";
		}
			//die();
		

			

			
			
			if(empty($get_ledger_Data)){
				$data1['ledger_Data']  = $this->account_model->get_ladger_account_Data('ledger',array('supp_id'=> $selected_ledger_id));
			}else{
				$data1['ledger_Data']  = $this->account_model->get_ladger_account_Data('ledger',array('id'=> $selected_ledger_id)); 
					
			}
			// pre($_GET);
			if($_REQUEST['start'] !='' && $_REQUEST['end'] !=''){
				
				$data1['ledger_dtl']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$where); 
				$data1['ledger_dtl2']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$where2); 
				
				// $data1['dr_total'] = get_total_user_amount_debit_where('transaction_dtl',$_REQUEST['ledger_party_id'],$created_by_cid,$where);
				// $data1['cr_total'] = get_total_user_amount_crdt_where('transaction_dtl',$_REQUEST['ledger_party_id'],$created_by_cid,$where);  
				
				
			

				
				$this->load->view('ladger_report/ledger_report', $data1);
			}else{
			
				$data1['ledger_dtl']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$get_details);
				$this->load->view('ladger_report/ledger_report', $data1);
			}
	}
	
	public function invoice_report(){
		if($this->input->post()){
			
			$invoice_idd = $this->input->post('id');
			//$created_by_cid  = $_SESSION['loggedInUser']->c_id;
			$created_by_cid  = $this->companyGroupId;
				$where = array(
					'type_id' => $invoice_idd,
					'type' => 'invoice',
					'created_by_cid' => $created_by_cid,
				);
				
			$this->data['invoice_dtl_report'] = $this->account_model->get_invoice_report_details('transaction_dtl',$where); 			
			$this->load->view('invoice/view_report', $this->data);
		}	
		
	}
	
	
	
	
	
	
	
	public function get_pdf_for_ledger_report($id = ''){
	   $selected_ledger_id =$this->uri->segment(3);
		$login_user_id = $_SESSION['loggedInUser']->u_id;
		
		/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			if(empty($date_fcal)){
						
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}
	/* For Financial Year*/
		
		$this->load->library('Pdf');
		if($_REQUEST['start'] =='' && $_REQUEST['end'] ==''){
			$where = array(
					'ledger_id' => $selected_ledger_id,
					//'created_by' => $login_user_id,  
					'created_by_cid' => $this->companyGroupId,
					'add_date >=' => $first_date,
					'add_date <=' => $second_date
				);
		$dataPdf['ledger_rpt_data']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$where);   
		}elseif($_POST['start'] !='' && $_POST['end'] !=''){
			$get_ledger_Data = $this->account_model->get_ladger_account_Data('ledger',array('id'=> $selected_ledger_id));
			$sstartDAtet = date("Y-m-d", strtotime($get_ledger_Data[0]->created_date));//Ledger Creation Date
			
			$where = "(transaction_dtl.add_date >='".$_POST['start']."' AND  transaction_dtl.add_date <='".$_POST['end']."') AND transaction_dtl.ledger_id = '". $selected_ledger_id  ."' AND transaction_dtl.created_by_cid = '".$this->companyGroupId."'";
			
			$subtractDate = date('Y-m-d', strtotime('-1 day', strtotime($_POST['start'])));
		
			$where2 = "(transaction_dtl.add_date >='".$sstartDAtet."' AND  transaction_dtl.add_date <='".$subtractDate."') AND transaction_dtl.ledger_id = '". $selected_ledger_id  ."' AND transaction_dtl.created_by_cid = '".$this->companyGroupId."'";
			$dataPdf['ledger_rpt_data']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$where);   
		$dataPdf['ledger_rpt_data2']  = $this->account_model->get_ladger_account_Data2('transaction_dtl',$where2);   
		}
		// pre($where2);die();
		
     	$this->load->view('ladger_report/ledger_report_pdf_genrate',$dataPdf);	//$this->_render_template('purchase_order/view_pdf', $this->data);
	}
	
//Get Ledger Account Details For Ledgers
	public function get_ledger_account_onserach(){
		$text_box_val = $_REQUEST['text_box_val'];
		$login_user_id = $_REQUEST['login_user_id'];
		$get_serach_details = "(created_by_cid = '".$login_user_id."' OR 'created_by_cid = 0 ' )";
		$data_serach1 = $this->account_model->get_ladger_account_search_Data('ledger',$get_serach_details,$text_box_val);
		//$data_serach2 = $this->account_model->get_ladger_account_search_Data('supplier',$get_serach_details,$text_box_val);
		//$merage_report_serach_Data = array_merge($data_serach1, $data_serach2);
		//pre($merage_report_serach_Data);die();
		echo json_encode($data_serach1);
		die;
		
	}


/*************************************************************************************************************************************************/	
/*******************************************************Trial Balance MODULE Start **************************************************************/	
/************************************************************************************************************************************************/

public function trial_balance(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Trial Balance', base_url() . 'Trial Balance');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Trial Balance';
	$created_by_id  = $_SESSION['loggedInUser']->u_id;
	$company_id  = $this->companyGroupId;
	// pre($_GET);
	
	
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
	if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}	
	/* For Financial Year*/

	if($_GET['selected_branch_idd'] == 'All'){
		$where = "(transaction_dtl.add_date >='".$first_date."' AND  transaction_dtl.add_date <='".$second_date."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') OR ledger.created_by_cid = '".$this->companyGroupId."'";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		//$this->_render_template('trial_balance/index', $ladger_Rdata);
	}
	
	
	//pre($_POST);die();
	if(isset($_GET['start'] ) && isset($_GET['end']) && $_GET['selected_branch_idd'] =='' && $_GET['create_excel'] =='' && $_GET['create_PDF'] == ''){
		
		$start_DATE = date("Y-m-d", strtotime($_GET['start']));
		$end_DATE = date("Y-m-d", strtotime($_GET['end']));
		$where = "(transaction_dtl.add_date >='".$start_DATE."' AND  transaction_dtl.add_date <='".$end_DATE."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') AND  ledger.created_by_cid = '".$this->companyGroupId."'  AND activ_status = 1";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
	   // $this->_render_template('trial_balance/index', $ladger_Rdata);
		}elseif(isset($_GET['selected_branch_idd']) && $_GET['start']==''  && $_GET['end'] =='' && $_GET['On_selected_Branch_idd'] == '' && $_GET['create_excel'] == '' && $_GET['create_PDF'] == '' ){
			
			$where = "(transaction_dtl.add_date >='".$first_date."' AND  transaction_dtl.add_date <='".$second_date."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') OR ledger.compny_branch_id = '". $_POST['selected_branch_idd']  ."' AND ledger.created_by_cid = '".$this->companyGroupId."'  AND activ_status = 1";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		//$this->_render_template('trial_balance/index', $ladger_Rdata);
	}elseif(isset($_GET['create_excel']) && isset($_GET['On_selected_Branch_idd']) && !isset($_GET['start'] ) && !isset($_GET['end']) && $_GET['create_PDF'] == ''){
		
		$where = "( transaction_dtl.add_date >='".$first_date."' AND  transaction_dtl.add_date <='".$second_date."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') OR ledger.created_by_cid = '".$this->companyGroupId."' AND ledger.compny_branch_id = '". $_GET['On_selected_Branch_idd']  ."' AND activ_status = 1";
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		//$this->load->view('trial_balance/excel', $ladger_Rdata);
	}elseif($_GET['start']!= ''  && $_GET['end'] != '' && $_GET['selected_branch_idd'] != '' && $_GET['create_PDF'] == ''){
		
		$where = "(transaction_dtl.add_date >='".$_GET['start']."' AND  transaction_dtl.add_date <='".$_GET['end']."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') OR ledger.created_by_cid = '".$this->companyGroupId."' AND ledger.compny_branch_id = '". $_GET['selected_branch_idd']  ."'  AND activ_status = 1";
	
		$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
	    //$this->_render_template('trial_balance/index_report', $ladger_Rdata);
		
	}elseif($_GET['start']!= ''  && $_GET['end'] != '' && $_GET['On_selected_Branch_idd'] == '' && $_GET['create_excel'] != '' && $_GET['create_PDF'] == ''){
		$where = "(transaction_dtl.add_date >='".$_GET['start']."' AND  transaction_dtl.add_date <='".$_GET['end']."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."')  AND activ_status = 1";
		
		
		//$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$ladger_Rdata  = $this->account_model->get_ledgers_details_using_group_byid($where);
		//$this->load->view('trial_balance/excel', $ladger_Rdata);
		$this->trial_balanceExcelReport_Data($ladger_Rdata);
	}elseif($_GET['start'] == ''  && $_GET['end'] == '' && $_GET['On_selected_Branch_idd'] == '' && $_GET['create_excel'] != '' && $_GET['create_PDF'] == ''){
		
			
		$where = "(transaction_dtl.add_date >='".$first_date."' AND  transaction_dtl.add_date <='".$second_date."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') OR  ledger.created_by_cid = '".$this->companyGroupId."'  AND activ_status = 1";
		
	
		//$ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$ladger_Rdata  = $this->account_model->get_ledgers_details_using_group_byid($where);
		//pre($ladger_Rdata);die();
		//$this->load->view('trial_balance/excel', $ladger_Rdata);
		$this->trial_balanceExcelReport_Data($ladger_Rdata);
		
	}elseif($_GET['start'] != ''  && $_GET['end'] != '' && $_GET['On_selected_Branch_idd'] == '' && $_GET['create_PDF'] != '' && $_GET['create_excel'] == ''){
		// die('HERE');
		// $where = "(transaction_dtl.add_date >='".$_GET['start']."' AND  transaction_dtl.add_date <='".$_GET['end']."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') OR  ledger.created_by_cid = '".$this->companyGroupId."'  AND activ_status = 1";
			$where = "(transaction_dtl.add_date >='".$_GET['start']."' AND  transaction_dtl.add_date <='".$_GET['end']."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."')  AND activ_status = 1";
		
		$ladger_Rdata = $this->account_model->get_ledgers_details_using_group_byid($where);
		//$this->load->view('trial_balance/trial_balance_pdf', $ladger_Rdata);
		
		$this->trial_balancePDFReport_Data($ladger_Rdata);
	}elseif($_GET['start'] == ''  && $_GET['end'] == '' && $_GET['On_selected_Branch_idd'] == '' && $_GET['create_PDF'] != '' && $_GET['create_excel'] == ''){
		
		$where = "(transaction_dtl.add_date >='".$first_date."' AND  transaction_dtl.add_date <='".$second_date."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') OR  ledger.created_by_cid = '".$this->companyGroupId."'  AND activ_status = 1";
		$ladger_Rdata  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$this->trial_balancePDFReport_Data($ladger_Rdata);
		//$this->load->view('trial_balance/trial_balance_pdf', $ladger_Rdata);
	}else{
		
		$where = "(transaction_dtl.add_date >='".$first_date."' AND  transaction_dtl.add_date <='".$second_date."' AND  `transaction_dtl`.`created_by_cid` = '".$this->companyGroupId."') OR  ledger.created_by_cid = '".$this->companyGroupId."'  AND activ_status = 1";
		
		// $ladger_Rdata['ledger_Data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		// $this->_render_template('trial_balance/index', $ladger_Rdata); 
		
	}	
		$data['report_data']  = $this->account_model->get_data('trial_blnc_report',array('created_by_cid'=> $company_id));
		$this->_render_template('trial_balance/index_report', $data);
}


public function trial_balancePDFReport_Data($ladger_Rdata){
	
	$this->load->library('Pdf');
	$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("Trial Balance");  
    $obj_pdf->SetHeaderData('Trial Balance', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);  
    $obj_pdf->SetAutoPageBreak(TRUE, 2);
	$obj_pdf->SetTopMargin(1);	
    $obj_pdf->SetFont('helvetica', '', 9);
	$obj_pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
	$obj_pdf->SetCreator(PDF_CREATOR);
	$obj_pdf->AddPage();
	
	$content = '';
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$Login_user_id = $this->companyGroupId;
		if(!empty($_GET['start'])  &&  !empty($_GET['end'])){
				$startDate = date("d-M-Y", strtotime($_GET['start']));
				$EndDate = date("d-M-Y", strtotime($_GET['end']));
				$ddate = 	'('. $startDate .' to '. $EndDate  .')';
			}else{
				$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$company_id);//Fetch Data to Company Table
					$date_fcal = json_decode($date_fun->financial_year_date,true);
					
					if(empty($date_fcal)){
						
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', strtotime($second_date22));
					}
				}
					
					$first_date_con = date("d-M-Y", strtotime($first_date));
					$second_date_con = date("d-M-Y", strtotime($second_date));
				$ddate = 	'('. $first_date_con .' to '. $second_date_con  .')';
			}
		
	
				 setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
				 $aDecode = $ladger_Rdata;
			     $account_group_id = array_unique(array_column($aDecode, 'account_group_id'));
				 $parent_group_id = array_unique(array_column($aDecode, 'parent_group_id'));
				 $acc = array_unique(array_column($aDecode, 'ledgerid'));
				 $data_acc_group = array_intersect_key($aDecode, $account_group_id);
				 $data_acc = array_intersect_key($aDecode, $acc);
				 $p_idd = array_intersect_key($aDecode, $parent_group_id);
				 $company_brnaches = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
			
	      $content .='<table  id="jobs"  border="1" style="width:100%;"  cellpadding="3">
			<tr align="center">
				<td></td>
				<td>
					<b style="font-size:18px;">'.$company_brnaches->name.'</b> <br/><br/><b> Trial Balance<br/><br/>'.$ddate.'</b>
				</td>
				<td></td>
			</tr>';
						$debit_amount_for_grand_ttl	 = 0;
						$credit_amount_for_grand_ttl = 0;
						
						
						foreach($account_group_id as $agid){ 
						$account_group_name = getNameById('account_group',$agid,'id');
						$debit_amount = $credit_amount = $IGST_amt = $CGST_amt = $SGST_amt = $sum = 0;
						foreach($data_acc as $account_gd){
							
							if($account_gd['account_group_id'] == $agid){
								$amount_totalgd = get_total_user_amount_debit('transaction_dtl',$account_gd['ledgerid'],$Login_user_id);
								$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$account_gd['ledgerid'],$Login_user_id);
								$ledger_detailsGD = get_closing_balance($account_gd['ledgerid'],$Login_user_id);
								foreach($ledger_detailsGD as $ledger_dtlsgd){
									if($ledger_dtlsgd['openingbalc_cr_dr'] == 1 ){
										 	$leger_debit_ttl = $amount_totalgd['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtlsgd['opening_balance'];
											$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										}
									if($ledger_dtlsgd['openingbalc_cr_dr'] == 0 ){
										$leger_debit_ttl = $amount_totalgd['sum(debit_dtl)'];
										$opening_balance =  $ledger_dtlsgd['opening_balance'];
										$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									}
								}	
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										$debit_amount += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										$debit_amount_for_grand_ttl += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										$credit_amount += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										$credit_amount_for_grand_ttl += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}
								
							}	
					}
					
			
				
				//$content .= '<tr style="background-color:#ddd;text-transform: capitalize;"><th>';					
					foreach($p_idd as $get_parent_name){
						if($get_parent_name['account_group_id'] == $agid && $get_parent_name['parent_group_id'] != 0){
							$parent_name = getNameById('account_group',$get_parent_name['parent_group_id'],'id');
							//$content .= '<span style="font-size: 14px;float:left;">'.$parent_name->name.'</span></br></br>';	
					}		
				}		
					$content .= '<tr><th><span style="font-size: 12px; float:left;">'.$account_group_name->name.'</span></th>';
					$content .= '<th>Debit '. money_format('%!i',$debit_amount).'</th>';
					$content .= '<th>Credit '. money_format('%!i',$credit_amount).'</th></tr>';
				
				foreach($data_acc as $account){
					if($account['account_group_id'] == $agid){
						
							// 
							//'1','Means credit opening balance','0','means debit opening balance'
						
							$amount_total = get_total_user_amount_debit('transaction_dtl',$account['ledgerid'],$Login_user_id);
							$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$account['ledgerid'],$Login_user_id);
							$ledger_details = get_closing_balance($account['ledgerid'],$Login_user_id);
							
								foreach($ledger_details as $ledger_dtls){
									if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
										 	$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtls['opening_balance'];
											$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										}
									if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
										$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
										$opening_balance =  $ledger_dtls['opening_balance'];
										$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									}
								}	
								if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal_chk = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal_chk = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}

									//echo $ledger_amt_aftr_calcu_dr;
								if($ledger_amt_aftr_calcu_cr != '' || $ledger_amt_aftr_calcu_cr != 0 || $ledger_amt_aftr_calcu_dr != '' || $ledger_amt_aftr_calcu_dr != 0){
									
										// echo '<td width="500px"><a href="javascript:void(0)" id="'. $account['ledgerid'] . '" data-id="ledger_view" class="add_account_tabs">'.$account['name'].'</a></td>';
										$content .= '<tr><td  style="font-size: 12px;"><a href="javascript:void(0)" class="lager_rp_name" data-id='.$account['ledgerid'].' >'. $account['name'] .'</a></td>';
									
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										
											$content .= '<td >' .money_format('%!i',$closing_bal).'</td>';//Debit
											$content .= '<td></td>'; 
										
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										
											$content .= '<td></td>';
											$content .= '<td >'.money_format('%!i', $closing_bal).'</td>';//Credit
										
									}
									$content .= '</tr>';
								}	
							
								//$content .= '<tr style="display:none;"><td>'.$get_parent_name['created_date'].'</td></tr>';	
							
						}
					}
					
			 
			}					
	$content .='<tr>
			<td colspan="1">Grand Total</td>
			<td style="text-align: center;">'.money_format('%!i', $debit_amount_for_grand_ttl).'</td>
			<td  style="text-align: center;">'.money_format('%!i', $credit_amount_for_grand_ttl).'</td></tr>';
		$content .='</table>';
		
		
		
		$obj_pdf->writeHTML($content);
		ob_end_clean(); 
		$rand_num = rand(5000000, 1500000);
		$filename = "Trial_balance_".$rand_num."" . ".pdf";
		$obj_pdf->Output(FCPATH . 'assets/modules/account/trial_balance/'.$filename, 'F');		
		$pdfFilePath = FCPATH . 'assets/modules/account/trial_balance/'.$filename;		
		//$obj_pdf->Output('sample.pdf', 'I');
        if(!empty($_GET['start'])  &&  !empty($_GET['end'])){
				$startDate = $_GET['start'];
				$EndDate = $_GET['end'];
			}else{
			$startDate = $first_date;
			$EndDate = $second_date;
		}
   $report_Saved_Data = array(
		'report_start_date'=>$startDate,
		'report_end_date'=>$EndDate,
		'created_by_cid'=>$this->companyGroupId,
		'created_by'=>$_SESSION['loggedInUser']->u_id,
		'file_name'=>$filename,
		'debit_total'=>$debit_amount_for_grand_ttl,
		'credit_total'=>$credit_amount_for_grand_ttl
		);
	$this->account_model->insert_tbl_data('trial_blnc_report',$report_Saved_Data);
	$this->session->set_flashdata('message', 'Report Generated Successfully.');
	redirect('account/trial_balance', 'refresh');		
	
}

public function trial_balanceExcelReport_Data($ladger_Rdata){
	//pre($ladger_Rdata);die();
	$rand_num = rand(5000000, 1500000);
	$filename = "Trial_balance_".$rand_num."" . ".xls"; 
	$fd = fopen (FCPATH."assets/modules/account/trial_balance/".$filename, "w");

	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		
		 $Login_user_id = $_SESSION['loggedInUser']->c_id;
		 $company_brnaches = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
		
			//This Code is used to show Financial Year date and Filter Date showing
			if(!empty($_GET['start'])  &&  !empty($_GET['end'])){
				$startDate = date("d-M-Y", strtotime($_GET['start']));
				$EndDate = date("d-M-Y", strtotime($_GET['end']));
				$ddate = 	'('. $startDate .' to '. $EndDate  .')';
			}else{
				$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$company_id);//Fetch Data to Company Table
					$date_fcal = json_decode($date_fun->financial_year_date,true);
					
					if(empty($date_fcal)){
						
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', strtotime($second_date22));
					}
				}
					
					$first_date_con = date("d-M-Y", strtotime($first_date));
					$second_date_con = date("d-M-Y", strtotime($second_date));
				$ddate = 	'('. $first_date_con .' to '. $second_date_con  .')';
			}
			//This Code is used to show Financial Year date and Filter Date showing
			
		
		$content .='<table  id="jobs"  border="1" style="width:100%;" >
			<tr align="center">
				<td></td>
				<td>
					<b style="font-size:18px;">'.$company_brnaches->name.'</b> <br/><br/><b> Trial Balance<br/><br/>'.$ddate.'</b>
				</td>
				<td></td>
			</tr><thead>';
		
		setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
			$aDecode = $ladger_Rdata;
			$account_group_id = array_unique(array_column($aDecode, 'account_group_id'));
			$parent_group_id = array_unique(array_column($aDecode, 'parent_group_id'));
			$acc = array_unique(array_column($aDecode, 'ledgerid'));
			$data_acc_group = array_intersect_key($aDecode, $account_group_id);
			$data_acc = array_intersect_key($aDecode, $acc);
			$p_idd = array_intersect_key($aDecode, $parent_group_id);
			
			
							
				$debit_amount_for_grand_ttl	 = 0;
				$credit_amount_for_grand_ttl = 0;
				
				foreach($account_group_id as $agid){ 
					$account_group_name = getNameById('account_group',$agid,'id');
					$debit_amount = $credit_amount = $IGST_amt = $CGST_amt = $SGST_amt = $sum = 0;
					//$Ledger_data2 = '';
						foreach($data_acc as $account_gd){
							if($account_gd['account_group_id'] == $agid){
								$amount_totalgd = get_total_user_amount_debit('transaction_dtl',$account_gd['ledgerid'],$Login_user_id);
								$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$account_gd['ledgerid'],$Login_user_id);
								$ledger_detailsGD = get_closing_balance($account_gd['ledgerid'],$Login_user_id);
								foreach($ledger_detailsGD as $ledger_dtlsgd){
									if($ledger_dtlsgd['openingbalc_cr_dr'] == 1 ){
										 	$leger_debit_ttl = $amount_totalgd['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtlsgd['opening_balance'];
											$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										}
									if($ledger_dtlsgd['openingbalc_cr_dr'] == 0 ){
										$leger_debit_ttl = $amount_totalgd['sum(debit_dtl)'];
										$opening_balance =  $ledger_dtlsgd['opening_balance'];
										$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									}
								}	
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										$debit_amount += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										$debit_amount_for_grand_ttl += $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										$credit_amount += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										$credit_amount_for_grand_ttl += $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}
								}
			
							}
				
					
			if($debit_amount != 0	 ||  $credit_amount != '' ){
				
				$content .='<tr style="background-color:#ddd;text-transform: capitalize;"><th style="text-align:left!important;">';					
				foreach($p_idd as $get_parent_name){
					if($get_parent_name['account_group_id'] == $agid && $get_parent_name['parent_group_id'] != 0){
						$parent_name = getNameById('account_group',$get_parent_name['parent_group_id'],'id');
						$content .=' <span style="font-size: 14px;">'.$parent_name->name.'</span></br>';	
					}		
				}		
				$content .='<span style="font-size: 12px; text-align:left;">'.$account_group_name->name.'</span></th>';
				$content .='<th>Debit     '. money_format('%!i',$debit_amount).'</th>';
				$content .='<th>Credit    '. money_format('%!i',$credit_amount).'</th>';
				$content .='</tr>';
				$content .='</thead>';
				$content .='<tbody>';
		}				
			
				foreach($data_acc as $account){
					
					if($account['account_group_id'] == $agid){
						//$time_start = microtime(true);
						
					
						
						if($account['ledger_id'] != ''){
							$ledger_name = getNameById('ledger',$account['ledgerid'],'id');
						}else{
							$ledger_name = getNameById('ledger',$account['id'],'id');
						}
		
							//'1','Means credit opening balance','0','means debit opening balance'
							$amount_total = get_total_user_amount_debit('transaction_dtl',$account['ledgerid'],$Login_user_id);
							$amount_total_credit = get_total_user_amount_crdt('transaction_dtl',$account['ledgerid'],$Login_user_id);
							$ledger_details = get_closing_balance($account['ledgerid'],$Login_user_id);
								foreach($ledger_details as $ledger_dtls){
									if($ledger_dtls['openingbalc_cr_dr'] == 1 ){
										 	$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
											$opening_balance =  $ledger_dtls['opening_balance'];
											$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
									    	$ledger_amt_aftr_calcu_cr = $leger_credit_ttl + $opening_balance;
											$ledger_amt_aftr_calcu_dr = $leger_debit_ttl;
										}
									if($ledger_dtls['openingbalc_cr_dr'] == 0 ){
										$leger_debit_ttl = $amount_total['sum(debit_dtl)'];
										$opening_balance =  $ledger_dtls['opening_balance'];
										$leger_credit_ttl = $amount_total_credit['sum(credit_dtl)'];
										$ledger_amt_aftr_calcu_dr = $leger_debit_ttl + $opening_balance;
										$ledger_amt_aftr_calcu_cr = $leger_credit_ttl;
									}
									
								}
							
								if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal_chk = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal_chk = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
									}
				
									
								if($ledger_amt_aftr_calcu_cr != '' || $ledger_amt_aftr_calcu_cr != 0 || $ledger_amt_aftr_calcu_dr != '' || $ledger_amt_aftr_calcu_dr != 0  ){
										$content .= '<tr>';
										// echo '<td width="500px"><a href="javascript:void(0)" id="'. $account['ledgerid'] . '" data-id="ledger_view" class="add_account_tabs">'.$account['name'].'</a></td>';
										$content .= '<td width="500px" style="font-size: 12px;">'. $account['name'] .'</td>';
									
									if($ledger_amt_aftr_calcu_dr > $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_dr - $ledger_amt_aftr_calcu_cr;
										
											 $content .=  '<td style="text-align:center;">' .money_format('%!i',$closing_bal).'</td>';//Debit
											 $content .=  '<td></td>'; 
										
									}else if($ledger_amt_aftr_calcu_dr < $ledger_amt_aftr_calcu_cr){
										$closing_bal = $ledger_amt_aftr_calcu_cr - $ledger_amt_aftr_calcu_dr;
										
											$content .=  '<td></td>';
											$content .=  '<td style="text-align:center;">'.money_format('%!i', $closing_bal).'</td>';//Credit
										
									}
								}	
							'</tr>';
						
							
						}
					}
					 // $time_end = microtime(true);
						// $time = $time_end - $time_start;	
// pre($time);						
			 
			}					
	//die('Aya');	 
	$content .='<tr><td colspan="4" style="display:none;"></td></tr>
				<tr><td colspan="4" style="display:none;"></td></tr>
				<tr>
				<th  width="90px" style="text-align: center;  width:69%;">Grand Total</th>
				<td width="90px" style="text-align: center;"> '.money_format('%!i', $debit_amount_for_grand_ttl).'</td>
				<td width="90px" style="text-align: center;">'. money_format('%!i', $credit_amount_for_grand_ttl).'</td>
			</tr>
			</tbody></table>';





	if(!empty($_GET['start'])  &&  !empty($_GET['end'])){
				$startDate = $_GET['start'];
				$EndDate = $_GET['end'];
			}else{
			$startDate = $first_date;
			$EndDate = $second_date;
		}
   $report_Saved_Data = array(
							'report_start_date'=>$startDate,
							'report_end_date'=>$EndDate,
							'created_by_cid'=>$this->companyGroupId,
							'created_by'=>$_SESSION['loggedInUser']->u_id,
							'file_name'=>$filename,
							'debit_total'=>$debit_amount_for_grand_ttl,
							'credit_total'=>$credit_amount_for_grand_ttl
							);
	$this->account_model->insert_tbl_data('trial_blnc_report',$report_Saved_Data);
	fputs($fd, $content);
	fclose($fd);
	$this->session->set_flashdata('message', 'Report Generated Successfully.');
	redirect('account/trial_balance', 'refresh');
}

public function deleteTrialBlanance_dtl($id = ''){	
		if (!$id) {
           redirect('account/trial_balance', 'refresh');
        }
		permissions_redirect('is_delete');
		$trial_blnc_fileName = $this->account_model->get_data_byId('trial_blnc_report','id',$id);
		
		$path = FCPATH.'assets/modules/account/trial_balance/'.$trial_blnc_fileName->file_name;
		$result = $this->account_model->delete_data('trial_blnc_report','id',$id);
		if(unlink($path))
		if($result){
			logActivity('Invoice Details Deleted','invoice',$id);
			$this->session->set_flashdata('message', 'Trial Balance Report Deleted Successfully');
			$result = array('msg' => 'Trial Balance Report Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/trial_balance');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}




public function get_ledger_balance_details(){ 
	$selected_ledger_id = $_REQUEST['ledger_id'];
	$login_user_id = $_REQUEST['login_user_id'];
	$get_details = array(
		'id' => $selected_ledger_id,
		'created_by' => $login_user_id
	);
	$data133 = $this->account_model->get_ladger_account_Data('ledger',$get_details);
	
	// $this->load->view('trial_balance/index', $data133);
	//echo json_encode($data133);
	die;
}

/***************************************************************************************************************************************/
/**************************************************** GSTR1 Start  *********************************************************************/
/***************************************************************************************************************************************/

public function Gstr_1(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('GSTR-1', base_url() . 'GSTR-1');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'GSTR-1';
	$created_by_id  = $this->companyGroupId;
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$created_by_id);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
	
		if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
					
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}	
	/* For Financial Year*/
				if(!empty($_GET)){
					
						$where = "(invoice.created_date >='".$_GET['start']."' AND  invoice.created_date <='".$_GET['end']."') AND invoice.created_by_cid = '".$this->companyGroupId."'";
						$where2 = "(voucher.created_date >='".$_GET['start']."' AND  voucher.created_date <='".$_GET['end']."') AND voucher.created_by_cid = '".$this->companyGroupId."'";
				}
	
				if($_POST['select_GST_number']!='' && $_POST['select_GST_number']!='All'){
					
					$where = "(invoice.created_date >='".$first_date."' AND  invoice.created_date <='".$second_date."') AND invoice.sale_leger_gstin_no = '". $_POST['select_GST_number']  ."' AND invoice.created_by_cid = '".$this->companyGroupId."'";
					
					$where2 = "(voucher.created_date >='".$first_date."' AND  voucher.created_date <='".$second_date."') AND voucher.branch_gst = '". $_POST['select_GST_number']  ."' AND voucher.created_by_cid = '".$this->companyGroupId."'";
				}elseif(empty($_GET)){
					
						$where = "(invoice.created_date >='".$first_date."' AND  invoice.created_date <='".$second_date."') AND invoice.created_by_cid = '".$this->companyGroupId."'";
						$where2 = "(voucher.created_date >='".$first_date."' AND  voucher.created_date <='".$second_date."') AND voucher.created_by_cid = '".$this->companyGroupId."'";
				}
	
	
			$data['invoice_data']  = $this->account_model->Get_GST_data('invoice',$where); 
			$data['credit_debit_notes']  = $this->account_model->Get_GST_data('voucher',$where2); 
			$data1 = GSTR1_helper();
			$data['GSTR1_data'] = $data1; 

			$this->_render_template('GSTR1/index', $data);
	}	


 public function gstr1_validations() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'validations');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Incomplete / Mismatch in Information (GSTR-1)';
		$created_id = $_SESSION['loggedInUser']->u_id;
		$created_c_id = $this->companyGroupId;
		$this->data['get_outwards_sales']  = $this->account_model->get_data_for_GSTR1_validation('invoice',$created_c_id);
		$this->_render_template('GSTR1/gstr1_validation', $this->data);
    }

/**********************************************************************************************************************************/
/****************************************** GSTR3B Start  ***********************************************************************/
/***********************************************************************************************************************************/

public function Gstr_3b(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('GSTR-3B', base_url() . 'GSTR-3B');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'GSTR-3B';
	$created_by_id  = $this->companyGroupId;
	$data['Sale_Data']  = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id)); 
	$data['Purchase_Data']  = $this->account_model->get_data('purchase_bill',array('created_by_cid'=> $created_by_id,'auto_entry'=>0)); 
	$data1 = GSTR3B_helper();
	$data['GSTR1_data'] = $data1;
	if(isset($_POST['create_excel'])){
		$this->load->view('GSTR3B/gstr3b_excel', $data);
		// pre($data);
	}else{
		$this->_render_template('GSTR3B/index', $data);
	}	
}



public function gstr3B_validations() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'validations');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Incomplete / Mismatch in Information (GSTR-3B)';
		$created_id = $_SESSION['loggedInUser']->u_id;
		$created_c_id = $this->companyGroupId;
		$this->data['get_inwards_purchase']  = $this->account_model->get_data_for_GST3B_validation('purchase_bill',$created_c_id);
		$this->_render_template('GSTR3B/gstr3b_validations', $this->data);
    }

/*******************************************************************************************************************************************/
/****************************************************** GSTR3B End  ***********************************************************************/
/*****************************************************************************************************************************************/



/****************************************************************************************************************************/
/************************************************ Balance Sheet Start  ******************************************************/
/***************************************************************************************************************************/
public function balance_sheet(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Balance Sheet', base_url() . 'Balance Sheet');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Balance Sheet';
	$created_by_id  = $this->companyGroupId;
	
	
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
	//pre($_POST['selected_branch_idd']);
	
		if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}	
	
	// if($_POST['selected_branch_idd'] == 'All'){
		// $where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";
		
		// $ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		
		// $this->_render_template('balance_sheet/index', $ladger_Rdata);
	// }
	
	if(isset($_POST['start']) && isset($_POST['end']) && $_POST['selected_branch_idd']=='' && $_POST['create_excel']==''  ){
		$start_Date = $_POST['start'];
		$end_Date = $_POST['end'];
		$where = "(ledger.created_date >='".$start_Date."' AND  ledger.created_date <='".$end_Date."') AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);	
	    $this->_render_template('balance_sheet/index', $ladger_Rdata);
	}elseif($_POST['selected_branch_idd'] != 'All' && $_POST['selected_branch_idd'] != '' && $_POST['create_excel'] == '' && $_POST['start']=='' && $_POST['end']=='' ){
	
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = ". $_POST['selected_branch_idd']  ." AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->_render_template('balance_sheet/index', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd'] == '' && $_POST['start'] =='' &&  $_POST['end'] =='' ){
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->load->view('balance_sheet/balance_sheet_excel', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd'] != '' && $_POST['start'] =='' &&  $_POST['end'] =='' ){
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND  ledger.compny_branch_id = ". $_POST['On_selected_Branch_idd']  ."  AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->load->view('balance_sheet/balance_sheet_excel', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd'] != '' && $_POST['start'] !='' &&  $_POST['end'] !='' ){
		$where = "( ledger.created_date >='".$start_Date."' AND  ledger.created_date <='".$end_Date."') AND ledger.compny_branch_id = ". $_POST['On_selected_Branch_idd']  ."  AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->load->view('balance_sheet/balance_sheet_excel', $ladger_Rdata);
	}else{
		//$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($created_by_id,$first_date,$second_date); 
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['trial_balance_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->_render_template('balance_sheet/index', $ladger_Rdata);
	}
	
	
}
 


/**********************************************************************************************************/
/************************************************ Profit and Loss Start ***********************************/
/***********************************************************************************************************/
public function profit_and_loss(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Profit And Loss', base_url() . 'Profit And Loss');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Profit And Loss';
	$created_by_id  = $this->companyGroupId;
	
	
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
		if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}	
	
	/* For Financial Year*/
	if($_POST['selected_branch_idd'] == 'All'){
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$this->_render_template('profitand_loss/index', $ladger_Rdata);
	}
	
	if(isset($_POST['start'] ) && isset($_POST['end']) && $_POST['selected_branch_idd'] == '' && $_POST['create_excel'] == ''){
		$start_Date = $_POST['start'];
		$end_Date = $_POST['end'];
		//$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($created_by_id,$start_Date,$end_Date);
		$where = "(ledger.created_date >='".$start_Date."' AND  ledger.created_date <='".$end_Date."') AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//opening Stock
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//closing Stock
		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		$this->_render_template('profitand_loss/index', $ladger_Rdata);	
	}elseif(isset($_POST['selected_branch_idd']) && $_POST['start']=='' && $_POST['end']=='' && $_POST['create_excel'] == '' ){
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = '". $_POST['selected_branch_idd']  ."' AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_for_balance_sheet($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//opening Stock
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//closing Stock

		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		$this->_render_template('profitand_loss/index', $ladger_Rdata);
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd']==''  && $_POST['start']=='' && $_POST['end']==''){
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//opening Stock
		
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//closing Stock

		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		
		$this->load->view('profitand_loss/profit_and_loss_excel', $ladger_Rdata);	
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd']!=''  && $_POST['start']=='' && $_POST['end']==''){
		$where = "( ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = '". $_POST['On_selected_Branch_idd']  ."' AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//opening Stock
		
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//closing Stock

		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		
		$this->load->view('profitand_loss/profit_and_loss_excel', $ladger_Rdata);	
		
	}elseif(isset($_POST['create_excel']) && $_POST['On_selected_Branch_idd']!=''  && $_POST['start']!='' && $_POST['end']!=''){
		$where = "( ledger.created_date >='".$start_Date."' AND  ledger.created_date <='".$end_Date."') AND ledger.compny_branch_id = '". $_POST['On_selected_Branch_idd']  ."' AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where);
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//opening Stock
		
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$this->companyGroupId."'";//closing Stock

		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		
		$this->load->view('profitand_loss/profit_and_loss_excel', $ladger_Rdata);	
		
	}else{
		$where = "(ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.created_by_cid = '".$this->companyGroupId."' AND activ_status = 1";
		$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($where); 
		//$ladger_Rdata['profit_loss_data']  = $this->account_model->get_ledgers_details_using_group_byid($created_by_id,$first_date,$second_date);
		
	
		$opening_Stock = "(inventory_flow.created_date <='".$first_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//opening Stock
		$closing_Stock = "(inventory_flow.created_date <='".$second_date."') AND inventory_flow.created_by_cid = '".$_SESSION['loggedInUser']->c_id."'";//closing Stock

		
		$ladger_Rdata['opening_Stock']  = $this->account_model->getClosingBalance($opening_Stock); 
		$ladger_Rdata['closing_Stock']  = $this->account_model->getClosingBalance($closing_Stock); 
		$this->_render_template('profitand_loss/index', $ladger_Rdata);
	}
}

/********************************************************************************************************************/
/*************************************** Profit and Loss End  *****************************************************/
/******************************************************************************************************************/

	public function Get_Ledgers_according_toParent(){
		$created_id = $_SESSION['loggedInUser']->u_id;
		$dded = $this->account_model->get_data_new('account_group',$created_id);
		$paret_idd = [];
				foreach($dded as $get_data){
				  $paret_idd[] = $get_data['parent_group_id'];
				}
				$data_parent =  implode(", ", $paret_idd);
				$dded_check = $this->account_model->get_data_Accrding_toparent_id($data_parent,$created_id);
				echo json_encode($dded_check);
			}
/****************************************************************************************************************/
/*****************************Get connected Company controller START HERE for drop Down**********************/
/*****************************************************************************************************************/	
		public function Get_connected_company_ctrller(){
			$company_id = $_REQUEST['login_company_id'];
			$data_get = $this->account_model->get_connected_company_data('connection',array('requested_by' => $this->companyGroupId,'requested_to' => $this->companyGroupId));
			$data_get = connectedCompany();
			echo json_encode($data_get);
			//pre($data);
			
		}     			
	public function accept_reject_invoice(){
		$accept_reject_invoice_id = $_REQUEST['invoice_idd'];
		@$reject_invoice_msg = $_REQUEST['reject_invoice'];
		$accept_reject = $_REQUEST['accept_reject'];//0 for accept and 1 for Reject
		if($accept_reject == '1'){
			$update_data = array(
						'accept_reject' => 1,
						'reject_invoice' => $reject_invoice_msg,
						);
			$usersWithViewPermissions = $this->account_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 31));
			if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'Invoice Accepted' , 'message' => 'Your Invoice is accepted', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_invoice_details','data_id' => 'invoice_view_details' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}
			
		
		$accept_reject_Data = $this->account_model->accept_reject_invoice_modl('invoice',array('id'=>$accept_reject_invoice_id),$update_data);				
		}
		if($accept_reject == '0'){
			$update_data = array(
						'accept_reject' => 0,
						);
						$usersWithViewPermissions = $this->account_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 31));
			if(!empty($usersWithViewPermissions)){
				foreach($usersWithViewPermissions as $userViewPermission){
					if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
						pushNotification(array('subject'=> 'Invoice Rejected' , 'message' => 'Your Invoice is Rejected', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'add_invoice_details','data_id' => 'invoice_view_details' ,'icon'=>'fa-shopping-cart'));
					}
				}
		}
		$accept_reject_Data = $this->account_model->accept_reject_invoice_modl('invoice',array('id'=>$accept_reject_invoice_id),$update_data);
			
		}
		
		if($accept_reject_Data > 0){
			echo 'true';
		}else{
			echo 'false';
		}
	}
		
/***************************************************************************************************************************************/
				/************************************************Bank Reconciliation**************************************************/
/*************************************************************************************************************************************/
	Public function bank_reconciliation(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Bank Reconciliation', base_url() . 'Bank Reconciliation');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Bank Reconciliation';
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		$ladger_Rdata['bank_reconciliation_data']  = $this->account_model->Get_profit_and_loss_data($created_by_id); 
		$this->_render_template('bank_reconciliation/index', $ladger_Rdata);
}

/*****************************************************************************************************************************************/
				/********************************************Sale Register AND other**************************************************/
/*************************************************************************************************************************************/
Public Function sale_register(){
$this->load->library('pagination');
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Sale Register', base_url() . 'Sale Register');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Sale Register';
	$created_by_id  = $_SESSION['loggedInUser']->u_id;
	$company_id  = $this->companyGroupId;
	$where = array('invoice.created_by_cid'=> $this->companyGroupId,'pay_or_not'=>0);
	if($_GET['selected_branch_idd'] == 'All'){
		redirect(base_url().'account/sale_register', 'refresh');
	}

	

	if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
		$where = array('invoice.created_by_cid'=> $this->companyGroupId);
	}
	if(!empty($_GET['start']) && !empty($_GET['end']) && !isset($_GET['selected_branch_idd'])){
		
			$original_Date_start = $_GET['start'];
			$cnvrted_newDate_Start = date("Y-m-d", strtotime($original_Date_start));
			$original_Date_end = $_GET['end'];
			$cnvrted_newDate_end = date("Y-m-d", strtotime($original_Date_end));
			
			//$where = array('invoice.date_time_of_invoice_issue >=' => $cnvrted_newDate_Start , 'invoice.date_time_of_invoice_issue <=' => $cnvrted_newDate_end,'invoice.created_by_cid'=> $this->companyGroupId);
			
			$where = "invoice.created_by_cid = ".$this->companyGroupId." AND  (invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')";
		}elseif(isset($_GET['selected_branch_idd'])){
				$where = array('invoice.sale_lger_brnch_id =' => $_GET['selected_branch_idd'], 'invoice.created_by_cid'=> $this->companyGroupId);
				
		}elseif(!empty($_GET['start']) && !empty($_GET['end']) && isset($_GET['selected_branch_idd'])){
			$original_Date_start = $_GET['start'];
			$cnvrted_newDate_Start = date("Y-m-d", strtotime($original_Date_start));
			$original_Date_end = $_GET['end'];
			$cnvrted_newDate_end = date("Y-m-d", strtotime($original_Date_end));
			//$where = array('invoice.date_time_of_invoice_issue >=' => $cnvrted_newDate_Start, 'invoice.date_time_of_invoice_issue <=' => $cnvrted_newDate_end,'invoice.created_by_cid'=> $this->companyGroupId);
			$where = "invoice.created_by_cid = ".$this->companyGroupId." AND  (invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')";
		}elseif(isset($_GET['sales_person'])){
			$where = array('invoice.sales_person =' => $_GET['sales_person'], 'invoice.created_by_cid'=> $this->companyGroupId);
		}
	//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$materialName=getNameById('material',$search_string,'material_name');
				if($materialName->id != ''){
			$json_dtl ='{"material_id" : "'.$materialName->id.'"}';
			 $where = "invoice.descr_of_goods!='' && json_contains(`descr_of_goods`, '".$json_dtl."')" ;
				}else{
						 $where2 = "invoice.id like'%". $_GET['search']."%'";
				}
			$where2="invoice.id like'%".$search_string."%'";
		 redirect("account/sale_register/?search=$search_string");
        }else if(isset($_GET['search'])&& $_GET['search']!=''){
				$materialName=getNameById('material',$_GET['search'],'material_name');
				if($materialName->id != ''){
				$json_dtl ='{"material_id" : "'.$materialName->id.'"}';
				$where = "invoice.descr_of_goods!='' && json_contains(`descr_of_goods`, '".$json_dtl."')" ;
				}else{
				$where2 = "invoice.id like'%". $_GET['search']."%'";
				}
			}
		if(!empty($_GET['order']))
		{
			$order=$_GET['order'];
		}else{
			$order="desc";
		}
		
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/sale_register/";
			$config["total_rows"] = $this->account_model->num_rows('invoice',$where,$where2);
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			//$ladger_Rdata['saleReg_Data']  = $this->account_model->Get_get_Sale_register('invoice',$where, $config["per_page"], $page,$where2,$order,$export_data);
		    $this->data['saleReg_Data']  = $this->account_model->Get_get_Sale_register('invoice',$where, $config["per_page"], $page,$where2,$order,$export_data);
			if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		
			$this->_render_template('saleregister/index', $this->data);
}


Public Function prchase_register(){
	 $this->load->library('pagination');
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Purchase Register', base_url() . 'Purchase Register');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Purchase Register';
	$created_by_id  = $_SESSION['loggedInUser']->c_id;
	$where = array('purchase_bill.created_by_cid'=> $this->companyGroupId,'auto_entry'=>0);
	if($_GET['selected_branch_idd'] == 'All'){
		redirect(base_url().'account/prchase_register', 'refresh');
	}
	if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
		$where = array('purchase_bill.created_by_cid'=> $_SESSION['loggedInUser']->c_id,'auto_entry'=>0);
	}elseif(isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= '') {
		$original_Date_start = $_GET['start'];
		$cnvrted_newDate = date("Y-m-d", strtotime($original_Date_start));
		$original_Date_end = $_GET['end'];
		$cnvrted_newDate_end = date("Y-m-d", strtotime($original_Date_end));
		$where = "purchase_bill.created_by_cid = ".$this->companyGroupId." AND  (purchase_bill.date >='".$cnvrted_newDate."' AND  purchase_bill.date <='".$cnvrted_newDate_end."')AND auto_entry=0";
	}
	
	if(!empty($_GET['start']) && !empty($_GET['end'])){
		//pre($_GET);
		$original_Date_start = $_GET['start'];
		$cnvrted_newDate = date("Y-m-d", strtotime($original_Date_start));
		$original_Date_end = $_GET['end'];
		$cnvrted_newDate_end = date("Y-m-d", strtotime($original_Date_end));
		$where = "purchase_bill.created_by_cid = ".$this->companyGroupId." AND  (purchase_bill.date >='".$cnvrted_newDate."' AND  purchase_bill.date <='".$cnvrted_newDate_end."' AND auto_entry=0)";
	}elseif(isset($_GET['selected_branch_idd'])){
			$where = array('purchase_bill.purchase_lger_brnch_id =' => $_GET['selected_branch_idd'], 'purchase_bill.created_by_cid'=> $this->companyGroupId);
	}
	//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$SupplierName=getNameById('supplier',$search_string,'name');
				if($SupplierName->id != '' ){
				 $where2= "(purchase_bill.supplier_name='".$SupplierName->id."')";
				}else{
				$where2="purchase_bill.id ='".$search_string."'";
				}
			
		 redirect("account/prchase_register/?search=$search_string");
        }else if(isset($_GET['search']) && $_GET['search']!=''){
				$SupplierName=getNameBySearch('ledger',$_GET['search'],'name');
				if($SupplierName->id != '' ){
				  $where2= "(purchase_bill.supplier_name='".$SupplierName->id."')";
				}else{
				  $where2="purchase_bill.id ='".$_GET['search']."'";
				}	
			}
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/prchase_register/";
			$config["total_rows"] = $this->account_model->num_rows('purchase_bill',$where,$where2);
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
		if(!empty($_GET['ExportType'])){
			$export_data = 1;
		}else{
			$export_data = 0;
		}
	   $this->data['purchaseReg_Data']  = $this->account_model->Get_get_Sale_register('purchase_bill',$where,$config["per_page"],$page,$where2,$order,$export_data);
	   if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		
		$this->_render_template('purchaseregister/index', $this->data);
 }


Public Function account_payable(){
	$this->load->library('pagination');
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Account Payable', base_url() . 'Account Payable');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Account Payable';
	$created_by_id  = $_SESSION['loggedInUser']->u_id;
	/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
				if(empty($date_fcal)){
						
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}
	/* For Financial Year*/
	
	
	
	
			$where = array('ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'3','ledger.activ_status'=>'1');
			if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
			
				$where = array('ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'3','ledger.activ_status'=>'1');
			}elseif(isset($_GET['ExportType']) && $_GET['start'] != '' && $_GET['end']!= '')
			{
				$where = array('ledger.created_date >=' => $_GET['start'] , 'ledger.created_date <=' => $_GET['end'],'ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'3','ledger.activ_status'=>'1');
			}else{
				$where = array('ledger.created_date >=' => $first_date , 'ledger.created_date <=' => $second_date,'ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'3','ledger.activ_status'=>'1');
			}
			
			if(!empty($_GET['start']) && !empty($_GET['end'])){
				$suppidd != 0; 
				$where = array('ledger.created_date >=' => $_GET['start'] , 'ledger.created_date <=' => $_GET['end'],'ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'3','ledger.activ_status'=>'1');
			}
	
	
		
//Search
		$where2='';
		//$where='';
		$search_string = '';
		if(!empty($_POST['search'])){
		$search_string = $_POST['search'];
		$where2="(ledger.name like'%".$search_string."%' or ledger.id like'%".$search_string."%')";
		 redirect("account/account_payable/?search=$search_string");
        }else if(isset($_GET['search'])&& $_GET['search']!=''){
		$where2 = "(ledger.name like'%" . $_GET['search'] . "%' or  ledger.id like'%". $_GET['search']."%')";
				
			}
		if(!empty($_GET['order']))
		{
			$order=$_GET['order'];
		}else{
			$order="desc";
		}
		// pre($where);
		// pre($where2);
		// die();
		//Pagination $this->account_model->get_supplier_Dtl_COUNT($where,$where2);
		$config = array();
			$config["base_url"] = base_url() . "account/account_payable/";
			$config["total_rows"] = $this->account_model->num_rows('ledger',$where,$where2);
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
			
			if(!empty($_GET['start'])){
		//pre($_GET);die();
		
		$this->data['payable_Data']  = $this->account_model->get_supplier_Dtl('ledger',$where, $config["per_page"], $page,$where2,$order);
	}else{
		$this->data['payable_Data']  = $this->account_model->get_supplier_Dtl('ledger',$where, $config["per_page"], $page,$where2,$order);
	}
		if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
		$this->data['payable_Data']  = $this->account_model->get_supplier_Dtl('ledger',$where, $config["per_page"], $page,$where2,$order); 
	}
			if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		$this->_render_template('accountpayable/index', $this->data);
}

Public Function account_recivable(){
	$this->load->library('pagination');
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Account Receivable', base_url() . 'Account Receivable');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Account Receivable';
	//$created_by_id  = $_SESSION['loggedInUser']->c_id;
	$created_by_id  = $this->companyGroupId;
	
	 
	if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
	
		$where = array('ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'6','ledger.activ_status'=>'1');
	}elseif(isset($_GET['ExportType']) && $_GET['start'] != '' && $_GET['end']!= ''){
		$where = array('ledger.created_date >=' => $_GET['start'] , 'ledger.created_date <=' => $_GET['end'],'ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'6','ledger.activ_status'=>'1');
	}elseif($_GET['ExportType'] == '' && $_GET['start'] != '' && $_GET['end']!= ''){
		$where = array('ledger.created_date >=' => $_GET['start'] , 'ledger.created_date <=' => $_GET['end'],'ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'6','ledger.activ_status'=>'1');
	}else{
		$where = array('ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'6','ledger.activ_status'=>'1');
	}
	
	// pre($where);
	// pre($_GET);
	
	if(!empty($_GET['start']) && !empty($_GET['end'])){
		$suppidd != 0; 
		$where = array('ledger.created_date >=' => $_GET['start'] , 'ledger.created_date <=' => $_GET['end'],'ledger.created_by_cid'=> $this->companyGroupId,'ledger.parent_group_id'=>'6','ledger.activ_status'=>'1');
	}

	//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
	$search_string = $_POST['search'];
	$where2="(ledger.name like'%".$search_string."%' or ledger.id like'%".$search_string."%')";
	 redirect("account/account_recivable/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "(ledger.name like'%" . $_GET['search'] . "%'or ledger.id like'%". $_GET['search']."%')";
			}
		if(!empty($_GET['order']))
		{
			$order=$_GET['order'];
		}else{
			$order="desc";
		}
		
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/account_recivable/";
			$config["total_rows"] = $this->account_model->num_rows('ledger',$where,$where2);
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
			if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		
		if(!empty($_GET['ExportType'])){
			$export_data = 1;
		}else{
			$export_data = 0;
		}
		$this->data['reciva_data']  = $this->account_model->get_ledger_Dtl('ledger',$where, $config["per_page"], $page,$where2,$order,$export_data); 
		$this->_render_template('accountreciveable/index', $this->data);			
}

/********************************************************************************************************************************************/  
	/************************************************************Import Data**************************************************/
/*******************************************************************************************************************************************/
	public function import_view(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Import Data', base_url() . 'Import Data');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Import Data';
    
		$this->load->library('excel');

  if ($_FILES) {
	 
			$created_by_id  = $this->companyGroupId;
			//$created_by_id  = $_SESSION['loggedInUser']->c_id;
			$path = 'assets/modules/import/uploads/';
			$this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config); 
		
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
			
            if(empty($error)){
              if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
				
	
				
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				
				
                $flag = true;
                $i=0;
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
					}

				for ($row = 2; $row <= $highestRow; $row++){ 
						$rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
							$rowData[0] = array_combine($headings[0], $rowData[0]);
							
							
					
							$EXCEL_DATE  = $rowData[0]['Ledger.`$CreatedDate`'];
							$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
	
							$created_Date = date('Y-m-d H:m:i', (int) $UNIX_DATE);
							
							// if($flag){
								 // $flag =false;
								 // continue;
							// }
     					  $inserdata[$i]['id'] = $rowData[0]['id'];
     					  $inserdata[$i]['name'] = $rowData[0]['name'] ? $rowData[0]['name']:'';
						  $inserdata[$i]['account_group_id'] = $rowData[0]['account_group_id'] ? $rowData[0]['account_group_id']:'';
						  $inserdata[$i]['parent_group_id'] = $rowData[0]['parent_group_id'] ? $rowData[0]['parent_group_id']:'';
						  $inserdata[$i]['compny_branch_id'] = $rowData[0]['compny_branch_id'] ? $rowData[0]['compny_branch_id']:'';
						  $inserdata[$i]['opening_balance'] = $rowData[0]['opening_balance']  ? $rowData[0]['opening_balance']:'';
						  $inserdata[$i]['openingbalc_cr_dr'] = $rowData[0]['openingbalc_cr_dr']  ? $rowData[0]['openingbalc_cr_dr']:'';
						  $inserdata[$i]['enble_disbl_rcm'] = $rowData[0]['enble_disbl_rcm']  ? $rowData[0]['enble_disbl_rcm']:'';
						  $inserdata[$i]['mailing_address'] = $rowData[0]['mailing_address']  ? $rowData[0]['mailing_address']:'';
						  $inserdata[$i]['supp_id'] = $rowData[0]['supp_id']  ? $rowData[0]['supp_id']:'';
						  $inserdata[$i]['gstin'] = $rowData[0]['gstin']? $rowData[0]['gstin']:'';
						  $inserdata[$i]['delarType'] = $rowData[0]['delarType']? $rowData[0]['delarType']:'';
						  $inserdata[$i]['areastation'] = $rowData[0]['areastation']? $rowData[0]['areastation']:'';
						 // $inserdata[$i]['created_date'] = $created_Date;
						  $inserdata[$i]['created_by'] = $_SESSION['loggedInCompany']->id;
						  $inserdata[$i]['created_by_cid'] = $this->companyGroupId;
						  //$inserdata[$i]['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						  $i++;
                } 
				
				// pre($inserdata);
				// die('Ledgers');
				$result = $this->account_model->importdata('ledger',$inserdata);   
                if($result){
                  //echo "Imported successfully";
				   $this->session->set_flashdata('message', 'Imported successfully');
                }else{
                //  echo "ERROR !";
				 $this->session->set_flashdata('message', 'ERROR !');
                }             

          } catch (Exception $e) {
              $this->session->set_flashdata('message', 'This Type File Not allowed for upload');
				redirect('account/import_view', 'refresh');	
            }
          }else{
             $this->session->set_flashdata('message', $error['error']);
			  redirect('account/import_view', 'refresh');	
            }
            
            
    }
	//$this->load->view('import_ledger/index',$this->data);
	$this->_render_template('import/index');
  } 
  public function import_invoices(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Import Data', base_url() . 'Import Data');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Import Data';
		
		 $this->load->library('excel');
		

	if ($_FILES) {
			$created_by_id  = $this->companyGroupId;
			$path = 'assets/modules/import/uploads/';
			$this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
	
            $this->load->library('upload', $config);
            $this->upload->initialize($config);            
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error)){
              if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
          $inputFileName = $path . $import_xls_file;
          $inputFileNamedd = FCPATH.$path . $import_xls_file;
		  
         // pre($inputFileName);
		 // die();
		  
            
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				
				//$ledgers_details = $this->account_model->get_data_with_zero_id_condtions('ledger',$created_by_id);
				
				
				
                $flag = true;
                $i=0;
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
					}
		
				for ($row = 2; $row <= $highestRow; $row++){ 
						$rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
						$rowData[0] = array_combine($headings[0], $rowData[0]);
						
						//Create JSON material and Tax Details
						$descr_of_goodsLength = count($rowData[0]['material_id']);
						if($descr_of_goodsLength >0){
							$arr = [];
							$arra = [];
							$j = 0;
							while($j < $descr_of_goodsLength) {	
							$material_id = getNameByID('material',$rowData[0]['material_id'],'material_name');
								if($material_id == ''){
									$mat_name_IDD = '0';
								}else{
									$mat_name_IDD = $material_id->id;
								}
								$jsonArrayObject = (array('material_id' =>$mat_name_IDD,'descr_of_goods' => $rowData[0]['descr_of_goods'],'hsnsac' => $rowData[0]['hsnsac'], 'quantity' => $rowData[0]['quantity'], 'rate' => $rowData[0]['rate'], 'tax' => $rowData[0]['tax'],'added_tax_Row_val'=> $rowData[0]['added_tax_Row_val'],'UOM' => $rowData[0]['UOM'],'amount'=>$rowData[0]['amount'],'disctype'=>$rowData[0]['disctype'],'discamt'=>$rowData[0]['discamt'],'after_desc_amt'=>$rowData[0]['after_desc_amt'],'amount_with_tax_after_disco'=>$rowData[0]['amount'],'item_code'=>$rowData[0]['item_code'],'cess'=>$rowData[0]['cess'],'valuation_type'=>$rowData[0]['valuation_type'],'cess_tax_calculation'=>$rowData[0]['cess_tax_calculation']));
								$arr[$j] = $jsonArrayObject;
								
								$jsonArrayObject1 = array('total' =>$rowData[0]['total_amount'],'totaltax' => $rowData[0]['totaltax_total'],'invoice_total_with_tax' => $rowData[0]['invoice_total_with_tax'],'cess_all_total' => $rowData[0]['cess_all_total']);
								$arra[$j] = $jsonArrayObject1;
								$j++;				
							}
							$descr_of_goods_array = json_encode($arr);
							$invoice_price_total_array = json_encode($arra);
						}else{
							$descr_of_goods_array = '';
							$invoice_price_total_array = '';
						}
							//Create JSON material and Tax Details
							
							//Create changes JSON If have
							$Added_changrges_Details = count($rowData[0]['charges_added']);
							if($Added_changrges_Details > 0){
								$charg_Add = [];
								$ch = 0;
								while($ch < $Added_changrges_Details){
									$jsonarray_chargeobj = (array('particular_charges_name'=>$rowData[0]['particular_charges_name'],'type_charges'=>$rowData[0]['type_charges'],'ledger_name'=>$rowData[0]['ledger_name'],'ledger_name_id'=>$rowData[0]['ledger_name_id'],'amt_tax'=>$rowData[0]['amt_tax'],'charges_added'=>$rowData[0]['charges_added'],'sgst_amt'=>$rowData[0]['sgst_amt'],'cgst_amt'=>$rowData[0]['cgst_amt'],'igst_amt'=>$rowData[0]['igst_amt'],'amt_with_tax'=>$rowData[0]['amt_with_tax']));
									$charg_Add[$ch] = $jsonarray_chargeobj;
									$ch++;
								}
								$json_charg_lead_total_array = json_encode($charg_Add);
							}else{
								$json_charg_lead_total_array = '';
							}
							//Create changes JSON If have	
							
							
						//pre($descr_of_goods_array);
							
						//$matchArray = array();
						// $j=0;
						if($rowData[0]['CGST'] == ''){
							$cgst = '0';
						}else{
							$cgst = $rowData[0]['CGST'];
						}
						if($rowData[0]['SGST'] == ''){
							$sgst = '0';
						}else{
							$sgst = $rowData[0]['SGST'];
						}
						if($rowData[0]['IGST'] == ''){
							$igst = '0';
						}else{
							$igst = $rowData[0]['IGST'];
						}
						if($rowData[0]['eway_bill_no'] == ''){
							$eway_bill_no = '0';
						}else{
							$eway_bill_no = $rowData[0]['eway_bill_no'];
						}
						if($rowData[0]['invoice_type'] == ''){
							$invoice_type = 'domestic_invoice';
						}else{
							$invoice_type = $rowData[0]['invoice_type'];
						}
						
						
							$EXCEL_DATE  = $rowData[0]['date_time_of_invoice_issue'];
							$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
							//$date_time_of_invoice_issue = date('Y-m-d', (int) $UNIX_DATE);
							$date_time_of_invoice_issue = date("Y-m-d", strtotime($rowData[0]['date_time_of_invoice_issue']));
							
							$EXCEL_DATE2  = $rowData[0]['date_time_removel_of_goods'];
							$UNIX_DATE2 = ($EXCEL_DATE2 - 25569) * 86400;
							//$date_time_removel_of_goods = date('Y-m-d', (int) $UNIX_DATE2);
							$date_time_removel_of_goods = date("Y-m-d", strtotime($rowData[0]['date_time_removel_of_goods']));
							
							$EXCEL_DATE3  = $rowData[0]['date_time_removel_of_goods'];
							$UNIX_DATE3 = ($EXCEL_DATE3 - 25569) * 86400;
							
							//$gr_date22 = date('Y-m-d', (int) $UNIX_DATE3);
							$gr_date22 = date("Y-m-d", strtotime($rowData[0]['date_time_removel_of_goods']));
							if($gr_date == ''){
								$gr_date = '';
							}else{
								$gr_date = $gr_date22;
							}
							
							$party_name = getNameByID('ledger',$rowData[0]['party_name'],'name');
								if($party_name == ''){
									$get_party_name = '0';
								}else{
									$get_party_name = $party_name->id;
								}
							
							$sale_ledger = getNameByID('ledger',$rowData[0]['sale_ledger'],'name');
							
								if($sale_ledger == ''){
									$get_sale_ledger_name = '0';
								}else{
									$get_sale_ledger_name = $sale_ledger->id;
								}
							$sales_person_name = getNameByID('user_detail',$rowData[0]['sales_person'],'name');
								if($sales_person_name == ''){
									$get_sales_person_name = '0';
								}else{
									$get_sales_person_name = $sales_person_name->u_id;
								}
								
								$party_State_id = getNameByID('state',$rowData[0]['party_state_id'],'state_name');
							
								if($party_State_id == ''){
									$get_party_State_id_name = '0';
								}else{
									$get_party_State_id_name = $party_State_id->state_id;
								}	
								$sale_State_id = getNameByID('state',$rowData[0]['sale_L_state_id'],'state_name');
								if($sale_State_id == ''){
									$get_sale_State_id_name = '0';
								}else{
									$get_sale_State_id_name = $sale_State_id->state_id;
								}	
							$partyData = getNameById('ledger',$rowData[0]['party_name'],'name');
							$due_date =  date('Y-m-d h:m', strtotime($date_time_of_invoice_issue. ' + '.$partyData->due_days.' days')); /// 
							
							$inserdata[$i]['created_date'] = date('Y/m/d H:i:s');
							$inserdata[$i]['buyer_order_no'] = $rowData[0]['buyer_order_no'] ? $rowData[0]['buyer_order_no']:'';
							$inserdata[$i]['party_name'] = $get_party_name;				  
							$inserdata[$i]['sale_ledger'] = $get_sale_ledger_name;					  
							$inserdata[$i]['sales_person'] = $get_sales_person_name;					  
							$inserdata[$i]['eway_bill_no'] = $eway_bill_no;					  
							$inserdata[$i]['sale_lger_brnch_id'] = $rowData[0]['sale_lger_brnch_id'] ? $rowData[0]['sale_lger_brnch_id']:'';		  
							$inserdata[$i]['email'] = $rowData[0]['email'] ? $rowData[0]['email']:'';			  
							$inserdata[$i]['gr_date'] = $gr_date;					  
							$inserdata[$i]['party_phone'] = $rowData[0]['party_phone'] ? $rowData[0]['party_phone']:'';				  
							$inserdata[$i]['invoice_type'] = $invoice_type;					  
							$inserdata[$i]['invoice_num'] = $rowData[0]['invoice_num'] ? $rowData[0]['invoice_num']:'';		  
							$inserdata[$i]['vehicle_reg_no'] = $rowData[0]['vehicle_reg_no'] ? $rowData[0]['vehicle_reg_no']:'';					  
							$inserdata[$i]['pan'] = $rowData[0]['pan'] ? $rowData[0]['pan']:'';			  
							$inserdata[$i]['gstin'] = $rowData[0]['gstin'] ? $rowData[0]['gstin']:'';					  
							$inserdata[$i]['sale_leger_gstin_no'] = $rowData[0]['sale_leger_gstin_no'] ? $rowData[0]['sale_leger_gstin_no']:'';		  
							$inserdata[$i]['transport_driver_pno'] = $rowData[0]['transport_driver_pno'] ? $rowData[0]['transport_driver_pno']:'';	$inserdata[$i]['date_time_of_invoice_issue'] = $date_time_of_invoice_issue;					  
							$inserdata[$i]['date_time_removel_of_goods'] = $date_time_removel_of_goods;					  
							$inserdata[$i]['CGST'] = $cgst;					  
							$inserdata[$i]['SGST'] = $sgst;					  
							$inserdata[$i]['IGST'] = $igst;					  
							$inserdata[$i]['charges_total_tax'] = $rowData[0]['charges_total_tax'] ? $rowData[0]['charges_total_tax']:'';	
							$inserdata[$i]['descr_of_goods'] = $descr_of_goods_array;		
							$inserdata[$i]['invoice_total_with_tax'] = $invoice_price_total_array;		
							$inserdata[$i]['charges_added'] = $json_charg_lead_total_array;		
							$inserdata[$i]['total_amount'] = $rowData[0]['total_amount'] ? $rowData[0]['total_amount']:'';		
							$inserdata[$i]['totaltax_total'] = $rowData[0]['totaltax_total'] ? $rowData[0]['totaltax_total']:'';		
							$inserdata[$i]['party_state_id'] = $get_party_State_id_name;		
							$inserdata[$i]['sale_L_state_id'] = $get_sale_State_id_name;		
							$inserdata[$i]['pay_or_not'] = $rowData[0]['pay_or_not'] ? $rowData[0]['pay_or_not']:'';		
							$inserdata[$i]['due_date'] = $due_date;		
							// $inserdata[$i]['material_id'] = $rowData[0]['material_id'];					  
							// $inserdata[$i]['descr_of_goods'] = $rowData[0]['descr_of_goods'];					  
							// $inserdata[$i]['hsnsac'] = $rowData[0]['hsnsac'];					  
							// $inserdata[$i]['quantity'] = $rowData[0]['quantity'];					  
							// $inserdata[$i]['rate'] = $rowData[0]['rate'];					  
							// $inserdata[$i]['tax'] = $rowData[0]['tax'];					  
							// $inserdata[$i]['UOM'] = $rowData[0]['UOM'];					  
							// $inserdata[$i]['amount'] = $rowData[0]['amount'];					  
							// $inserdata[$i]['disctype'] = $rowData[0]['disctype'];					  
							// $inserdata[$i]['discamt'] = $rowData[0]['discamt'];					  
							// $inserdata[$i]['after_desc_amt'] = $rowData[0]['after_desc_amt'];					  
							// $inserdata[$i]['amount_with_tax_after_disco'] = $rowData[0]['amount_with_tax_after_disco'];					  
						    $inserdata[$i]['created_by_cid'] = $created_by_id;
						    $inserdata[$i]['created_by'] = $_SESSION['loggedInUser']->u_id;
						  $i++;
               
			}
			
			 pre($inserdata);
		die('There');
			// redirect('account/invoices', 'refresh');	
			// die();
		
			
				$result = $this->account_model->importdata('invoice',$inserdata);   
                if($result){
                 unlink($inputFileNamedd);
				 $this->session->set_flashdata('message', 'Imported successfully');
				 redirect('account/invoices', 'refresh');	
                }else{
                 // echo "ERROR !";
				 $this->session->set_flashdata('message', 'ERROR !');
				 redirect('account/invoices', 'refresh');	
                }             

          }
		  catch (Exception $e) {
			
               //die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                       // . '": ' .$e->getMessage());
				$this->session->set_flashdata('message', 'This Type File Not allowed for upload');
				redirect('account/invoices', 'refresh');	
            }
          }else{
			  //echo $error['error'];
			  $this->session->set_flashdata('message', $error['error']);
			  redirect('account/invoices', 'refresh');	
			}
    }
	$this->_render_template('import/index');
  }
  
/*Function to Import invoices*/	
	function Create_invoice_blankxls(){
	$fileName = 'Blank_invoice'.time().'.xls'; 
	$this->load->library('excel');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
		
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'party_name');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'sale_ledger');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'eway_bill_no');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'email');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'gr_date');       
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'party_phone');       
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'buyer_order_no');       
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'invoice_type');       
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'vehicle_reg_no');       
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'pan');       
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'gstin');       
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'transport_driver_pno'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'date_time_of_invoice_issue'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'date_time_removel_of_goods'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'CGST'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'SGST'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'IGST'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'charges_total_tax'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'invoice_num'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'material_id'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'descr_of_goods'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'hsnsac'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'quantity'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'rate'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'tax'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'UOM'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'amount'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'disctype'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'discamt'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'after_desc_amt'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'amount_with_tax_after_disco');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'item_code');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'cess');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'valuation_type');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'cess_tax_calculation');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'total_amount');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'totaltax_total');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'cess_all_total');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'party_state_id');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'mode_of_payment');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'pay_or_not');  //0 for not Paid and 1 for Paid
	$objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'particular_charges_name');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'type_charges');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'sale_L_state_id');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'mailing_address_name');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'amt_tax');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'charges_added');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'sgst_amt');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AW1', 'cgst_amt');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AX1', 'igst_amt');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AY1', 'amt_with_tax');  
	$objPHPExcel->getActiveSheet()->SetCellValue('AZ1', 'sales_person');  
	$objPHPExcel->getActiveSheet()->SetCellValue('BA1', 'sale_lger_brnch_id');  
	$objPHPExcel->getActiveSheet()->SetCellValue('BB1', 'invoice_total_with_tax');  
	$objPHPExcel->getActiveSheet()->SetCellValue('BC1', 'added_tax_Row_val');  
	
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
         //redirect(site_url().$fileName);
		 redirect(base_url().'account/invoices', 'refresh');
		 
		 
	
}	  
/*Function to Import invoices*/
function Create_ledgers_blankxls(){
	
	$fileName = 'Blank_ledger'.time().'.xls'; 
	$this->load->library('excel');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
		
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'name');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'account_group_id');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'parent_group_id');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'conn_comp_id');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'compny_branch_id');       
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'opening_balance');       
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'openingbalc_cr_dr');       
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'enble_disbl_rcm');       
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'mailing_address');       
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'contact_person');       
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'phone_no');       
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'mobile_no'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'email'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'date_time_removel_of_goods'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'registration_type'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'gstin'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'pan'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'delarType'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'areastation'); 
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$fileName.'"');
	header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
       //  redirect(site_url().$fileName);
		 redirect(base_url().'account/invoices', 'refresh');
	
}

  public function import_sale_ledgers(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Import Data', base_url() . 'Import Data');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Import Data';
    
		$this->load->library('excel');

  if ($_FILES) {
	 
			$created_by_id  = $_SESSION['loggedInUser']->u_id;
			$path = 'assets/modules/import/uploads/';
			$this->load->library('excel');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config); 
		
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
			
            if(empty($error)){
              if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            
            try {
                $inputFileType = PHPExcel_IOFa<tory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
				
	
				
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				
				
				
                $flag = true;
                $i=0;
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
					}

				for ($row = 2; $row <= $highestRow; $row++){ 
						$rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
						$rowData[0] = array_combine($headings[0], $rowData[0]);
						
						
						foreach($rowData as $dd){
							$result = array_merge($dd,$rowData[0]);
							// if($rowData[0]['Vch Type'] == ){
								
							 // pre($rowData[0]['Vch Type']);
								
							// }
							
							pre(array($result));
							
							
						}
						
							
							 
							
							// $EXCEL_DATE  = $rowData[0]['Ledger.`$CreatedDate`'];
							// $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
	
							// $created_Date = date('Y-m-d H:m:i', (int) $UNIX_DATE);
							
							
     					  // $inserdata[$i]['name'] = $rowData[0]['Ledger.`$Name`'];
						  // $inserdata[$i]['email'] = $rowData[0]['Ledger.`$EMail`'];
						  
						  // $inserdata[$i]['created_date'] = $created_Date;
						  // $inserdata[$i]['mailing_country'] = $rowData[0]['Ledger.`$CountryName`'];
						  // $inserdata[$i]['gstin'] = $rowData[0]['Ledger.`$PartyGSTIN`'];
						  // $inserdata[$i]['created_by'] = $created_by_id;
						  $i++;
                } 
				die();
				//pre($inserdata);die('Ledgers');
				$result = $this->account_model->importdata('ledger',$inserdata);   
                if($result){
                  //echo "Imported successfully";
				   $this->session->set_flashdata('message', 'Imported successfully');
                }else{
                //  echo "ERROR !";
				 $this->session->set_flashdata('message', 'ERROR !');
                }             

          } catch (Exception $e) {
              $this->session->set_flashdata('message', 'This Type File Not allowed for upload');
				redirect('account/import_view', 'refresh');	
            }
          }else{
             $this->session->set_flashdata('message', $error['error']);
			  redirect('account/import_view', 'refresh');	
            }
            
            
    }
	//$this->load->view('import_ledger/index',$this->data);
	$this->_render_template('import/index');
  }
  
/*********************************************************************************************************************/
  /*****************************Integration Inventery and account***************************************************/
/*******************************************************************************************************************/
		public function get_closing_matrila_qty(){
			$matrial_id = $_REQUEST['matral_idds'];
			$locationID = $_REQUEST['Selectedlocation'];
			$saleLedger_address = getNameById('company_address',$locationID,'compny_branch_id');
			$locationId = $saleLedger_address->id;
		
			$ddf = $this->account_model->get_matrial_qty_invoice('mat_locations',$matrial_id,$locationId);
			echo $ddf['quantity'];
			// pre($ddf);            
		}
		

/******************************************************************************************************************************************/
  /***********************************************Create GSTR1 CSV Functions*************************************************************/
/**********************************************************************************************************************************/

 public function createXLS_GSTR1() {
			// create file name
			$fileName = 'ERP_GSTR1_'.time().'.xls'; 
			//$created_id = $_SESSION['loggedInUser']->c_id;		
			$created_id = $this->companyGroupId;		
			// load excel library
			
			$this->load->library('excel');
			$gst_Datas = $this->account_model->get_data_for_xls_import($created_id);
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'GSTIN/UIN of Recipient');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice Number');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Invoice Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Invoice Value');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Place Of Supply');       
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Reverse Charge');       
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Applicable % of Tax Rate');       
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Invoice Type');       
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'E-Commerce GSTIN');       
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Rate');       
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Taxable Value');       
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Cess Amount');       
			// set Row
			if(!empty($gst_Datas)){
			$rowCount = 2;
			foreach ($gst_Datas as $element) {
				
			
				$descr_goods = json_decode($element['descr_of_goods'],true);
		    	//$sale_ledger_data  = getNameById('ledger',$element['sale_ledger'],'id');
				$party_dtail  = getNameById('ledger',$element['party_name'],'id');
				
				$party_city_name  = getNameById('city',$party_dtail->mailing_city,'city_id')->city_name;
				
				$invoice_date = date("d-M-y", strtotime($element['created_date']));
					if($element['invoice_type'] == ''){
						  $invoice_type = 'Regular';
					}else{
						$invoice_type = $element['invoice_type'];
					}
				// if($party_dtail->gstin != ''){
				// $gstin_no =  $party_dtail->gstin;
					// }else{
						// $gstin_no =   '';
					// }
				$Taxable_value = $descr_goods[0]['quantity'] *  $descr_goods[0]['rate'];
			
    		 $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $party_dtail->gstin);
             $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['id']);
             $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $invoice_date);
             $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($descr_goods[0]['amount']));
             $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $party_city_name);
			 $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'R');
             $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
             $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $invoice_type);
             $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
             $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $descr_goods[0]['tax']);
             $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, number_format($Taxable_value));
             $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, '');
            $rowCount++;
        }
		//pre($objPHPExcel);die();
		
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
         redirect(site_url().$fileName);
		}else{
			$this->session->set_flashdata('message', 'No Data Avilable');
			redirect(base_url().'account/Gstr_1', 'refresh');
		}
    
}
public function create_GSTR1_json(){
	//$created_by_id = $_SESSION['loggedInUser']->c_id;	
	$created_by_id = $this->companyGroupId;	
	$invoice_data  = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id)); 
	$data['credit_debit_notes']  = $this->account_model->get_data('voucher',array('created_by_cid'=> $created_by_id)); 
	if (date('m') <= 4) {//Upto June 2014-2015
		 $mydate = date(date('Y-04-01'));
		$lastyear = strtotime("-1 year", strtotime($mydate));
		$first_date = date("Y", $lastyear); 
		$date = date(date('Y-03-31'));
		$second_date = date('y', strtotime("$date"));
	} else {//After June 2015-2016
		 $mydate = date(date('Y-04-01'));
		//$lastyear = strtotime("-1 year", strtotime($mydate));
		 $first_date = date("Y", strtotime($mydate));
		 $date = date(date('Y-03-31'));
		 $second_date22 = strtotime("+1 year", strtotime($date));
		 $second_date = date("y", $second_date22); 
	}
	
		$unique_GST_number = array_unique(array_map(function($elem){return $elem['sale_leger_gstin_no'];}, $invoice_data));
		
		
		
		$finalArray = array();
		if(!empty($unique_GST_number)){
			$i = 0;
			foreach($unique_GST_number as $uniq_gst){
				$invoices  = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id,'sale_leger_gstin_no'=>$uniq_gst)); 				
					
				$finalArray[$i]['ctin'] = $uniq_gst;
				if(!empty($invoices)){
					
					$j = 0;
					foreach($invoices as $invoice){
						
						$total_amount_witout_tax_Amount = json_decode($invoice['invoice_total_with_tax']);
						$total_amount_for_conditions = $total_amount_witout_tax_Amount[0]->total;
						if($invoice['gstin'] !='' && $invoice['invoice_type']=='domestic_invoice'){
							$finalArray[$i]['inv'][$j]['inum'] = $invoice['invoice_num'];
							$finalArray[$i]['inv'][$j]['idt'] = $invoice['date_time_of_invoice_issue'];
							$finalArray[$i]['inv'][$j]['val'] = $invoice['total_amount'];
							$finalArray[$i]['inv'][$j]['pos'] = sprintf("%02d", $invoice['party_state_id']);
							$finalArray[$i]['inv'][$j]['rchrg'] = 'N';
							if($invoice['descr_of_goods'] !=''){
								$products = json_decode($invoice['descr_of_goods']);
								if(!empty($products)){
									$k = 0;
									$mat_num = 1;
									foreach($products as $product){
										$total_mat_amt = $product->amount - $product->added_tax_Row_val;
										$finalArray[$i]['inv'][$j]['items'][$k]['num'] = $mat_num;	
										$finalArray[$i]['inv'][$j]['items'][$k]['itm_det']['txval'] = $total_mat_amt;	
										$finalArray[$i]['inv'][$j]['items'][$k]['itm_det']['rt'] = $product->tax;	
										$finalArray[$i]['inv'][$j]['items'][$k]['itm_det']['iamt'] = $product->added_tax_Row_val;	
										$finalArray[$i]['inv'][$j]['items'][$k]['itm_det']['csamt'] = $product->cess;	
										
										$k++;
										$mat_num++;
									}
									$finalArray[$i]['inv'][$j]['inv_typ'] = 'R';
								}
							}
							
							$j++;
						}
						if($invoice['gstin'] =='' && $total_amount_for_conditions < 1500 && $invoice['invoice_type']=='domestic_invoice' ){
							
							$finalArrayb2cs =array();
							if($invoice['descr_of_goods'] !=''){
								
								
								$products2 = json_decode($invoice['descr_of_goods']);
								
								if(!empty($products2)){
									
									
									$g = 0;
									foreach($invoices as $b2cs){
										$finalArrayb2cs[$g]['rt'] = '18';
										if($b2cs['CGST'] != '' && $b2cs['SGST'] != '' && $b2cs['IGST'] == '0.00' ){
											$finalArrayb2cs[$g]['sply_ty'] = 'INTRA';	
										}
										if($b2cs['IGST'] != '' && $b2cs['CGST'] == '0.00' && $b2cs['SGST'] == '0.00'){
										   $finalArrayb2cs[$g]['sply_ty'] = 'INTER';
										}
											$finalArrayb2cs[$g]['pos'] = sprintf("%02d", $b2cs['party_state_id']);
											$finalArrayb2cs[$g]['typ'] = 'OE';			
											$finalArrayb2cs[$g]['txval'] = $b2cs['totaltax_total'];
										if($b2cs['CGST'] != '' && $b2cs['SGST'] != '' && $b2cs['IGST'] == '0.00' ){
											$finalArrayb2cs[$g]['camt'] = $b2cs['CGST'];	
											$finalArrayb2cs[$g]['samt'] = $b2cs['SGST'];		
										}
										if($b2cs['IGST'] != '' && $b2cs['CGST'] == '0.00' && $b2cs['SGST'] == '0.00'){
										  $finalArrayb2cs[$g]['iamt'] = $b2cs['IGST'];
										}
											$finalArrayb2cs[$g]['csamt'] = '0.0';
									$g++;			
									}
									
									
									
								
									
									
								}
							}
						}
						
					}
					
					if($invoice['descr_of_goods'] !=''){
								$products = json_decode($invoice['descr_of_goods']);
								if(!empty($products)){
									$w = 0;
									$mat_num = 1;
									foreach($products as $product){
										
										$total_mat_amt = $product->amount - $product->added_tax_Row_val;
										$hsn_array['data'][$w]['num'] = $mat_num;	
										$hsn_array['data'][$w]['hsn_sc'] = $product->hsnsac;	
										$hsn_array['data'][$w]['desc'] = $product->descr_of_goods;	
										$hsn_array['data'][$w]['uqc'] = $product->UOM;	
										$hsn_array['data'][$w]['qty'] = $product->quantity;	
										$hsn_array['data'][$w]['val'] = $total_mat_amt;	
										$hsn_array['data'][$w]['txval'] = $product->added_tax_Row_val;
										
										if($invoice['IGST'] !='' && $invoice['SGST'] == '0.00' && $invoice['CGST'] == '0.00' ){	
										
											$hsn_array['data'][$w]['iamt'] = $product->added_tax_Row_val;
											$hsn_array['data'][$w]['camt'] = '0.00';	
										    $hsn_array['data'][$w]['samt'] = '0.00';	
										}
										if($invoice['IGST'] =='0.00' && $invoice['SGST']!= '' && $invoice['CGST'] != ''){	
										
										$hsn_array['data'][$w]['camt'] = $product->added_tax_Row_val;	
										$hsn_array['data'][$w]['samt'] = $product->added_tax_Row_val;
										$hsn_array['data'][$w]['iamt'] = '0.00';
										}	
										$hsn_array['data'][$w]['csamt'] = $product->cess_tax_calculation;	
										
										$w++;
										$mat_num++;
									}
									
								}
							}
						}
					$i++;  
				}
		}
		
	
		
			$posts = array(
					'gstin'=> $_SESSION['loggedInCompany']->gstin,
					'fp'=> '022020',
					'gt'=> '022020',
					'cur_gt'=> '022020',
					'b2b' =>$finalArray,
					'b2cs' =>$finalArrayb2cs,
					'hsn'=>$hsn_array
				);

	$File_name = 'GSTR-1_'.$_SESSION['loggedInCompany']->gstin.'_'.date('F').'_'.$first_date.'-'.$second_date;
	
			
			// $json_data = json_encode($posts, JSON_PRETTY_PRINT);
			$json_data = json_encode($posts);
			header('Content-disposition: attachment; filename='.$File_name.'.json');
			header('Content-type: application/json');
			echo $json_data;
			
			redirect(base_url().'account/Gstr_1', 'refresh');
	
}
	
public function create_GSTR3B_json() {
			//$created_by_id = $_SESSION['loggedInUser']->c_id;	
			$created_by_id = $this->companyGroupId;	
			$Sale_Data = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id)); 
			$Purchase_Data  = $this->account_model->get_data('purchase_bill',array('created_by_cid'=> $created_by_id,'auto_entry'=>0)); 
			$finalArray_first = array();
			$finalArray_second = array();
			setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
		$i = 0;
		$m = 0;
		
			foreach($Sale_Data as $invoice){
				if($invoice['gstin'] !=''  ){
					$total_amount_witout_tax_Amount = json_decode($invoice['invoice_total_with_tax']);
						$total_amount = $total_amount + $total_amount_witout_tax_Amount[0]->total;
							if($invoice['CGST'] == '0.00' && $invoice['CGST'] == '0.00' && $invoice['IGST'] != ''){
								$integrated_tax_sum = $integrated_tax_sum + $invoice['IGST'];
							}
							if($invoice['CGST'] != '' && $invoice['SGST'] != '' && $invoice['IGST'] == '0.00'){
								$cgst_sum = $cgst_sum + $invoice['CGST'];
								$sgst_sum = $sgst_sum + $invoice['SGST'];
							}
						
							$finalArray_first['osup_det']['txval'] = money_format('%!i',$total_amount);
							$finalArray_first['osup_det']['iamt'] = money_format('%!i',$integrated_tax_sum);
							$finalArray_first['osup_det']['camt'] = money_format('%!i',$cgst_sum);
							$finalArray_first['osup_det']['samt'] = money_format('%!i',$sgst_sum);
							$finalArray_first['osup_det']['csamt'] = '0.00';
							
						}
						
					if($invoice['gstin'] =='' && $invoice['party_state_id'] != $invoice['sale_L_state_id'] ){	
								$total_amount_witout_tax_of_supplies = json_decode($invoice['invoice_total_with_tax']);
								foreach($total_amount_witout_tax_of_supplies as $data_total){
								  $total_taax =	$data_total->totaltax;
								  $integrated_tax_sumof_supplies = $integrated_tax_sumof_supplies + $total_taax;
								  $total_amountof_supplies = $total_amountof_supplies + $data_total->total;
									
									$finalArray_first['osup_zero']['txval'] = money_format('%!i',$total_amountof_supplies);
									$finalArray_first['osup_zero']['iamt'] = money_format('%!i',$integrated_tax_sumof_supplies);
									$finalArray_first['osup_zero']['camt'] = '0.00';
									$finalArray_first['osup_zero']['samt'] = '0.00';
									$finalArray_first['osup_zero']['csamt'] = '0.00';
								}
							}
					//if($invoice['CGST'] == '0.00' && $invoice['SGST'] == '0.00' && $invoice['IGST'] == '0.00'){
					
							if($invoice['CGST'] == '0.00' && $invoice['SGST'] == '0.00' && $invoice['IGST'] == '0.00'){
								// pre($invoice);
								$total_amount_witout_tax_Amount = json_decode($invoice['invoice_total_with_tax']);
								$total_amount_nill = $total_amount + $total_amount_witout_tax_Amount[0]->total;
								
								$integrated_tax_sum_nill = $integrated_tax_sum + $invoice['IGST'];
								$cgst_sum_nill = $cgst_sum + $invoice['CGST'];
								$sgst_sum_nill = $sgst_sum + $invoice['SGST'];
							}
							
						
							$finalArray_first['osup_nil_exmp']['txval'] = money_format('%!i',$total_amount_nill);
							$finalArray_first['osup_nil_exmp']['iamt'] = money_format('%!i',$integrated_tax_sum_nill);
							$finalArray_first['osup_nil_exmp']['camt'] = money_format('%!i',$cgst_sum_nill);
							$finalArray_first['osup_nil_exmp']['samt'] = money_format('%!i',$sgst_sum_nill);
							$finalArray_first['osup_nil_exmp']['csamt'] = '0.00';
							
						//}			
							$finalArray_first['isup_rev']['txval'] = '0.00';
							$finalArray_first['isup_rev']['iamt'] = '0.00';
							$finalArray_first['isup_rev']['camt'] = '0.00';
							$finalArray_first['isup_rev']['samt'] = '0.00';
							
							$finalArray_first['osup_nongst']['txval'] = '0.00';
							$finalArray_first['osup_nongst']['iamt'] = '0.00';
							$finalArray_first['osup_nongst']['camt'] = '0.00';
							$finalArray_first['osup_nongst']['samt'] = '0.00';
						
							$finalArray_second['itc_avl'][$i]['ty'] = 'IMPG';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_avl'][$i]['ty'] = 'IMPS';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_avl'][$i]['ty'] = 'ISRC';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_avl'][$i]['ty'] = 'ISD';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_avl'][$i]['ty'] = 'ISD';
							$finalArray_second['itc_avl'][$i]['iamt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['camt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['samt'] = '0.00';
							$finalArray_second['itc_avl'][$i]['csamt'] = '0.00';
							
							$finalArray_second['itc_rev']['ty'] = 'RUL';
							$finalArray_second['itc_rev']['iamt'] = '0.00';
							$finalArray_second['itc_rev']['camt'] = '0.00';
							$finalArray_second['itc_rev']['samt'] = '0.00';
							$finalArray_second['itc_rev']['csamt'] = '0.00';
							
							$finalArray_second['itc_rev']['ty'] = 'OTH';
							$finalArray_second['itc_rev']['iamt'] = '0.00';
							$finalArray_second['itc_rev']['camt'] = '0.00';
							$finalArray_second['itc_rev']['samt'] = '0.00';
							$finalArray_second['itc_rev']['csamt'] = '0.00';
							
							$finalArray_second['itc_net']['iamt'] = '0.00';
							$finalArray_second['itc_net']['camt'] = '0.00';
							$finalArray_second['itc_net']['samt'] = '0.00';
							$finalArray_second['itc_net']['csamt'] = '0.00';
							
							$finalArray_second['itc_inelg']['ty'] = 'RUL';
							$finalArray_second['itc_inelg']['iamt'] = '0.00';
							$finalArray_second['itc_inelg']['camt'] = '0.00';
							$finalArray_second['itc_inelg']['samt'] = '0.00';
							$finalArray_second['itc_inelg']['csamt'] = '0.00';
							
							$finalArray_second['itc_inelg']['ty'] = 'OTH';
							$finalArray_second['itc_inelg']['iamt'] = '0.00';
							$finalArray_second['itc_inelg']['camt'] = '0.00';
							$finalArray_second['itc_inelg']['samt'] = '0.00';
							$finalArray_second['itc_inelg']['csamt'] = '0.00';
				$i++;		
				$m++;		
				}
				$finalArray_first_inward = array();
				$finalArray_first_inward_un_reg = array();
				$b = 0;
				$bm = 0;
				
				foreach($Purchase_Data as $inward_supp){
					
					if($inward_supp['gstin'] !=''  ){
					$total_amount_inward_supp = json_decode($inward_supp['invoice_total_with_tax']);
					
						$total_amount_inward_supp1 = $total_amount_inward_supp1 + $total_amount_inward_supp[0]->total;
							if($inward_supp['CGST'] == '0.00' && $inward_supp['CGST'] == '0.00' && $inward_supp['IGST'] != ''){
								$integrated_tax_sum1 = $integrated_tax_sum1 + $inward_supp['IGST'];
							}
							if($inward_supp['CGST'] != '' && $inward_supp['SGST'] != '' && $inward_supp['IGST'] == '0.00'){
								$cgst_sum1 = $cgst_sum1 + $inward_supp['CGST'];
								$sgst_sum1 = $sgst_sum1 + $inward_supp['SGST'];
								$inter = $cgst_sum1 + $sgst_sum1;
							}
						
							$finalArray_first_inward['isup_details'][$b]['ty'] = 'GST';
							$finalArray_first_inward['isup_details'][$b]['inter'] = money_format('%!i',$inter);
							$finalArray_first_inward['isup_details'][$b]['intra'] = money_format('%!i',$integrated_tax_sum1);
							
							
						}elseif($inward_supp['gstin'] ==''  ){
							
									$total_amount_inward_supp = json_decode($inward_supp['invoice_total_with_tax']);
									$total_amount_inward_supp1 = $total_amount_inward_supp1 + $total_amount_inward_supp[0]->total;
							if($inward_supp['CGST'] == '0.00' && $inward_supp['CGST'] == '0.00' && $inward_supp['IGST'] != ''){
								$integrated_tax_sum1 = $integrated_tax_sum1 + $inward_supp['IGST'];
							}
							if($inward_supp['CGST'] != '' && $inward_supp['SGST'] != '' && $inward_supp['IGST'] == '0.00'){
								$cgst_sum1 = $cgst_sum1 + $inward_supp['CGST'];
								$sgst_sum1 = $sgst_sum1 + $inward_supp['SGST'];
								$inter = $cgst_sum1 + $sgst_sum1;
							}
						
							$finalArray_first_inward['isup_details'][$b]['ty'] = 'NONGST';
							$finalArray_first_inward['isup_details'][$b]['inter'] = money_format('%!i',$inter);
							$finalArray_first_inward['isup_details'][$b]['intra'] = money_format('%!i',$integrated_tax_sum1);
							
							
						}
						
							if($inward_supp['CGST'] == '0.00' && $inward_supp['CGST'] == '0.00' && $inward_supp['IGST'] != ''){
								$iggst = $iggst + $inward_supp['IGST'];
							}
							if($inward_supp['CGST'] != '' && $inward_supp['SGST'] != '' && $inward_supp['IGST'] == '0.00'){
								$cgst_sum12 = $cgst_sum12 + $inward_supp['CGST'];
								$sgst_sum12 = $sgst_sum12 + $inward_supp['SGST'];
								
							}
						$total_amountforcess = json_decode($inward_supp['invoice_total_with_tax']);
						
						    $finalArray_first_inwardintr_details['intr_details']['iamt'] = money_format('%!i',$iggst);
							$finalArray_first_inwardintr_details['intr_details']['camt'] = money_format('%!i',$cgst_sum12);
							$finalArray_first_inwardintr_details['intr_details']['samt'] = money_format('%!i',$sgst_sum12);
							$finalArray_first_inwardintr_details['intr_details']['csamt'] = money_format('%!i',$total_amountforcess[0]->cess_all_total);
						
				

					if($inward_supp['gstin'] !='' &&  $inward_supp['CGST'] == '0.00' && $inward_supp['SGST'] == '0.00' ){
						
						
						$tax_val = $inward_supp['total_amount'] - $inward_supp['totaltax_total'];
					
						    $finalArray_first_inward_un_reg['unreg_details'][$bm]['pos'] = sprintf("%02d", $inward_supp['party_billing_state_id']);
							$finalArray_first_inward_un_reg['unreg_details'][$bm]['txval'] = money_format('%!i',$tax_val);
							$finalArray_first_inward_un_reg['unreg_details'][$bm]['iamt'] = money_format('%!i',$inward_supp['IGST']);
							
					}	
				$b++;	
				$bm++;	
					}
				

				
			$posts = array(
					'gstin'=> $_SESSION['loggedInCompany']->gstin,
					'ret_period'=> '042020',
					'sup_details'=> $finalArray_first,
					'itc_elg'=> $finalArray_second,
					'inward_sup'=> $finalArray_first_inward,  
					'intr_ltfee'=> $finalArray_first_inwardintr_details,  
					'inter_sup'=> $finalArray_first_inward_un_reg,  
					
					
				);
			
			// $json_data = json_encode($posts, JSON_PRETTY_PRINT);
			
			$json_data = json_encode($posts);
			// pre($json_data);		
		// die();
			header('Content-disposition: attachment; filename=gstr_3B.json');
			header('Content-type: application/json');
			echo $json_data;
			
			redirect(base_url().'account/Gstr_3b', 'refresh');
			
			
    }	

	
		
/**************************************************************************************************************************************/
  /********************************************Create Ledger CSV Functions*************************************************************/
/*********************************************************************************************************************************/	
		
	public function add_financial_year_date() {
	 //$login_company_id = $created_id = $_SESSION['loggedInUser']->c_id;
	 $login_company_id = $created_id = $this->companyGroupId;
	 $start_date = $_REQUEST['start'];
	 $end_date = $_REQUEST['end'];
		 $return_data = $this->account_model->save_financial_year_date('company_detail',$login_company_id,$start_date,$end_date); 
		 if($return_data > 0){
			 echo 'true';
		 }
	}
	
	
	public function remove_financial_year_date() {
		$login_company_id = $created_id = $this->companyGroupId;
		//$remove_Date = $_REQUEST['remove_Date'];
		 $return_data = $this->account_model->remove_financial_year_date('company_detail',$login_company_id); 
		 if($return_data > 0){
			 $this->session->set_flashdata('message', 'Financial Year Date Removed');
				redirect('account/financial_year_settings', 'refresh');	
		 }
	}
	
	public function save_invoice_num_prefix(){
	
		if (isset($_POST['prefix_inv_num'])) {
			
			$addressLength = count($_POST['prefix_inv_num']);	
				if($addressLength >0){
					$addressArr = [];
					$i = 0;
					$idds = 1;
					while($i < $addressLength) {				
						$addressJsonArrayObject = array('add_id'=> $idds,'address' => $_POST['address'][$i], 'country' => $_POST['country'][$i], 'state' => $_POST['state'][$i], 'city' => $_POST['city'][$i],'postal_zipcode' => $_POST['postal_zipcode'][$i],'company_gstin' => $_POST['company_gstin'][$i],'compny_branch_name'=>$_POST['compny_branch_name'][$i],'prefix_inv_num' => $_POST['prefix_inv_num'][$i]);
						$addressArr[$i] = $addressJsonArrayObject;
						$i++;	
						$idds++;	
					
					}
					$address_array = json_encode($addressArr);
				}else{
					$address_array = '';
				}
			$retrn_val = $this->account_model->update_data_check('company_detail',$address_array); 
			if($retrn_val > 0){
			 $this->session->set_flashdata('message', 'Prefix Invoice Settings Added.');
				redirect('account/invoice_setting', 'refresh');	
		 }
		}
		if(isset($_POST['email_send_setting'])){
		
			$login_company_id = $this->companyGroupId;
			$retrn_val_Email = $this->account_model->update_email_Settings('company_detail',$_POST['email_send_setting'],$login_company_id); 
			if($retrn_val_Email > 0){
			 $this->session->set_flashdata('message', 'Email Settings changed');
			 redirect('account/invoice_setting', 'refresh');	
		 }
		}
		if(isset($_POST['invoice_num_of_copies'])){
			$login_company_id = $this->companyGroupId;
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','invoice_num_of_copies',$_POST['invoice_num_of_copies'],$login_company_id); 
			//echo $rtrn;die();
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update Number of Invoice Copies ');
				redirect('account/invoice_setting', 'refresh');	
		 }
			
		}
		if(isset($_POST['discount_on_off'])){
			$login_company_id =  $this->companyGroupId;
			//$login_company_id =  $_SESSION['loggedInUser']->c_id;
			
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','discount_on_off',$_POST['discount_on_off'],$login_company_id); 
			//echo $rtrn;die();
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update Discount Settings');
				redirect('account/invoice_setting', 'refresh');	
		 }
	}
		if(isset($_POST['multi_loc_on_off'])){
			$login_company_id =  $this->companyGroupId;
			
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','multi_loc_on_off',$_POST['multi_loc_on_off'],$login_company_id); 
			//echo $rtrn;die();
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update Multi Location  Settings');
				redirect('account/invoice_setting', 'refresh');	
		 }
			
		}
		if(isset($_POST['item_code_on_off'])){
			$login_company_id =  $this->companyGroupId;
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','item_code_on_off',$_POST['item_code_on_off'],$login_company_id); 
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update Item Code   Settings');
				redirect('account/invoice_setting', 'refresh');	
		 }
		}
		if(isset($_POST['invoice_cancl_restor'])){
			//$login_company_id =  $_SESSION['loggedInUser']->c_id;
			$login_company_id =  $this->companyGroupId;
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','invoice_cancl_restor',$_POST['invoice_cancl_restor'],$login_company_id); 
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update invoice Cancel Restore   Settings');
				redirect('account/invoice_setting', 'refresh');	
		 }
		}
		
		if(isset($_POST['tcs_onOff'])){
			//$login_company_id =  $_SESSION['loggedInUser']->c_id;
			$login_company_id =  $this->companyGroupId;
			$rtrn = $this->account_model->save_number_of_invoice_copeies('company_detail','tcs_onOff',$_POST['tcs_onOff'],$login_company_id); 
			if($rtrn >=0 ){
			 $this->session->set_flashdata('message', 'Update TCS Settings');
				redirect('account/invoice_setting', 'refresh');	
			}
		}
		
	}
		
	public function get_quantity_calulation_and_more(){
			$created_by_id  = $this->companyGroupId;
			$ladger_Rdata['qtty_dtls']  = $this->account_model->get_data('invoice',array('created_by_cid'=> $created_by_id)); 			
			$this->load->view('saleregister/quantity_check', $ladger_Rdata);
			
	}	
		
		
		public function dashboard(){		
		$this->breadcrumb->add('dashboard', base_url() . 'dashboard');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Dashboard';	
		$this->data['user_dashboard']  = $this->account_model->get_data('user_dashboard',array('user_id' => $_SESSION['loggedInUser']->id));
		$this->_render_template('dashboard/index', $this->data);
	}
	
	public function monthWiseIncomeExpenseAmountGraph(){
		if(!empty($_GET)) {
			$startDate = $_GET['startDate'];
			$endDate = $_GET['endDate'];
		}else{
			$startDate =  $endDate = '' ;
		}		
		$getPermissions = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>6,'permissions.is_view'=>1));
		$this->data['incomeExpenseGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['productSaleGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;
		$this->data['cashFlowGraphPermission']  =  $_SESSION['loggedInUser']->role == 1?1:0 ;		
		$accountGraphDashboardArray = array();
		if((!empty($getPermissions) &&  $_SESSION['loggedInUser']->role == 2) || $_SESSION['loggedInUser']->role == 1){
			$monthWiseIncomeExpenseAmountGraph = monthWiseIncomeExpenseAmountGraph($startDate, $endDate);
			$materialSaleAmountGraph = materialSaleAmountGraph($startDate, $endDate);
			$monthWiseCashFlowGraph = monthWiseCashFlowGraph($startDate, $endDate);
		}
		$accountGraphDashboardArray = array('monthWiseIncomeExpenseAmountGraph' => $monthWiseIncomeExpenseAmountGraph ,'materialSaleAmountGraph' => $materialSaleAmountGraph ,'monthWiseCashFlowGraph'=> $monthWiseCashFlowGraph);		
		echo json_encode($accountGraphDashboardArray);
	}
		
	public function showDashboardOnRequirement(){
		$data = $_GET;
		$data['user_id'] = $_SESSION['loggedInUser']->id;
		$userDashboardRes = $this->account_model->get_data('user_dashboard',array('user_id'=> $_SESSION['loggedInUser']->id , 'graph_id' => $data['graph_id']));	
		if(!empty($userDashboardRes)){
			$id = $this->account_model->update_data('user_dashboard',$data,'id',$userDashboardRes[0]['id']);	
		}else{
			$id = $this->account_model->insert_tbl_data('user_dashboard',$data);
		}	
		if($id){
			$result = array('msg' => 'Data for user set', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/dashbaord');    
			echo json_encode($result);
			die;	
		}		
	}	
		
	public function chart_of_accounts() { 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Chart of Accounts', base_url() . 'chart_of_accounts');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Chart of Accounts';
		$created_id = $this->companyGroupId;
		//$created_id = $_SESSION['loggedInUser']->c_id;
		$this->data['ChartAccount']  = $this->account_model->get_parent('account_group',$created_id);
		$this->_render_template('chart_of_accounts/index', $this->data);
    }		
		
	
	public function createLedgerViaAjax(){	
		$id = $this->account_model->createLedgerViaAjax('ledger',array('account_group_id'=>$_GET['account_group_id'] , 'name' => $_GET['name'] , 'parent_group_id' => $_GET['parent_group_id'],'created_by_cid' => $this->companyGroupId, 'created_by' => $_SESSION['loggedInUser']->id,'activ_status' => 1));
		if($id){
			$result = array('msg' => 'Ledger created successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/chart_of_accounts');    
			echo json_encode($result);
			die;	
		}	
	}	
	
	
	
	public function createLedgerAccountViaAjax(){

		if($_GET['table'] == 'ledger'){
		$id = $this->account_model->createLedgerAccountViaAjax($_GET['table'],array('account_group_id'=>$_GET['account_group_id'] , 'name' => $_GET['name'] , 'parent_group_id' => $_GET['parent_group_id'],'created_by_cid' => $this->companyGroupId, 'created_by' => $_SESSION['loggedInUser']->id));
		}else{
			$id = $this->account_model->createLedgerAccountViaAjax($_GET['table'],array('name' => $_GET['name'] , 'parent_group_id' => $_GET['parent_group_id'],'created_by_cid' => $this->companyGroupId, 'created_by' => $_SESSION['loggedInUser']->id));
		}
		if($id){
			$result = array('msg' => 'Created successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/chart_of_accounts');    
			echo json_encode($result);
			die;	
		}	
	}	
	
	
	
	
	public function updateLedgerGroupNameViaAjax(){			
		$id = $this->account_model->updateLedgerGroupNameViaAjax($_GET['table'],array('name' => $_GET['name']),'id',$_GET['id']);	
		if($id){
			$result = array('msg' => 'Updated successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/chart_of_accounts');    
			echo json_encode($result);
			die;	
		}	
	}	
	
/*************************************************account freeze*************************************************************/

	public function account_freeze(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account Freeze', base_url() . 'account_freeze');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Account Freeze';
		$where = array('account_freeze.created_by_cid' => $this->companyGroupId);
		//$where = array('account_freeze.created_by_cid' => $_SESSION['loggedInUser']->c_id);
		
		$this->data['account_freeze']  = $this->account_model->get_account_freeze_date('account_freeze',$where);
		$this->_render_template('account_freeze/index', $this->data);
	}		
		
	public function	editAccountFreeze(){
			$id=$_GET['id'];
			$this->data['get_account_freeze'] = $this->account_model->get_data_byId('account_freeze','id',$id);
			$this->load->view('account_freeze/edit', $this->data);		
	}
		
	public function saveAccountFreeze(){	
		if ($this->input->post()) {
			$required_fields = array('freeze_date');		
			$is_valid = validate_fields($_GET, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}else{
				$data  = $this->input->post();	
				
				//$data['created_by'] =$_SESSION['loggedInUser']->id;
				$data['created_by_cid'] = $this->companyGroupId ;
				$id=$data['id'];
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->id;
					$success = $this->account_model->update_data('account_freeze',$data, 'id', $id);	
					if ($success) {
						$data['message'] = "Account freeze updated successfully";
						logActivity('Account freeze Updated','Account freeze',$id);
						$this->session->set_flashdata('message', 'Account freeze Updated successfully');
						redirect(base_url().'account/account_freeze', 'refresh');
					}	
				}else{	
						//pre("sdfsd");
					$id = $this->account_model->insert_tbl_data('account_freeze',$data);
					
					if ($id) {
                       
						logActivity('Account freeze inserted','Account freeze',$id);
						$this->session->set_flashdata('message', 'Account freeze inserted successfully');
						redirect(base_url().'account/account_freeze', 'refresh');
					}              
				}
			}
		}
	}	

// Crages Head
public function charges_lead() {
		 $this->load->library('pagination'); 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'Charges Head');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Charges Head';
		//$created_id = $_SESSION['loggedInUser']->c_id;
		$created_id = $this->companyGroupId;
		//$this->data['ledgers']  = $this->account_model->get_data('ledger',array('created_by'=> $created_id));
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2="(charges_lead.id like'%".$search_string."%' or charges_lead.particular_charges like'%".$search_string."%')";
		redirect("account/charges_lead/?search=$search_string");
        }else if(isset($_GET['search']) && $_GET['search']!=''){
				 $where2 = "(charges_lead.id like'%" . $_GET['search'] . "%' or charges_lead.particular_charges like'%". $_GET['search']."%' )";
			}
			
		if(!empty($_GET['order']))
		{
			$order=$_GET['order'];
		}else{
			$order="desc";
		}
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/charges_lead/";
			$config["total_rows"] = $this->account_model->num_rows('charges_lead',array('created_by_cid'=>$created_id,'charges_for' =>0),$where2);
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
			 if(!empty($_GET['ExportType'])){
			$export_data = 1;
		}else{
			$export_data = 0;
		}
		if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		$this->data['charge_lead_Datas']  = $this->account_model->get_data1('charges_lead',array('created_by_cid'=> $created_id,'charges_for'=>0), $config["per_page"], $page,$where2,$order,$export_data);	
		$this->_render_template('charges_lead/index', $this->data);
    }

	
	public function editcharges_account(){
	
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['charge_lead_Datas'] = $this->account_model->get_data_byId('charges_lead','id',$this->input->post('id'));
		//echo 'there';die();
			$this->load->view('charges_lead/edit', $this->data);
		}	
	}
    public function savecharges(){
		if ($this->input->post()) {
			$required_fields = array('account_group','particular_charges');	
			$is_valid = validate_fields($_GET, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}else{
				$data  = $this->input->post();			
				$data['created_by_uid'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $this->companyGroupId;
				$id = $data['id'];
			if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_data('charges_lead',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Charges updated successfully";
                        logActivity('Charges  Updated','charges_lead',$id);
                        $this->session->set_flashdata('message', 'Charges  Updated successfully');
					    redirect(base_url().'account/charges_lead', 'refresh');
                    }
				}else{
						$id = $this->account_model->insert_tbl_data('charges_lead',$data);  					
					if ($id) {                        
                        logActivity('New Charges Created','charges_lead',$id);
                        $this->session->set_flashdata('message', 'Charges  inserted successfully');
					    //redirect(base_url().'account/charges_lead', 'refresh');
						redirect($_SERVER['HTTP_REFERER']);
                    }    				
				}
			}			
        }
	}
public function deleteCharges_leads($id = ''){	
		if (!$id) {
           redirect('account/charges_lead', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('charges_lead','id',$id);
		if($result){
			logActivity('Charge  Deleted','charges_lead',$id);
			$this->session->set_flashdata('message', 'Charge Deleted Successfully');
			$result = array('msg' => 'Charge Deleted Successfully', 'status' => 'success', 'code' => 'C264','url' => base_url() . 'account/charges_lead');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}	
// Crages Lead	
	public function delivery_chln() {
		$this->load->library('pagination'); 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'delivery chln');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Delivery Challan OutWard';
		$created_id = $this->companyGroupId;
		//$created_id = $_SESSION['loggedInUser']->c_id;
		
		// if($_GET){
			// $where = array('challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>1);
				 // }
		if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
			$where = array('challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>1);
			}elseif($_GET['tab']!='auto' && $_GET['tab']=='challan'){
				$where = array('challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>0);
			}else{
				$where = array('challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>0);	
			 }
		if(isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '') {
			if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
					$where = array('challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>1);
				}elseif($_GET['tab']=='challan' && $_GET['tab']!='auto'){
					$where = array('challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>0);
				}else{
					$where = array('challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>0);
				}
		}elseif(isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= '') {
			if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
				$where = array('challan_dilivery.created_date >=' => $_GET['start'] , 'challan_dilivery.created_date <=' => $_GET['end'],'challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>1);
			}elseif($_GET['tab']=='challan' && $_GET['tab']!='auto'){
				$where = array('challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>0);
			}else{
				$where = array('challan_dilivery.created_date >=' => $_GET['start'] , 'challan_dilivery.created_date <=' => $_GET['end'],'challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>0);
			}
		}
		if(!empty($_GET) && isset($_GET['start']) &&  isset($_GET['end']) && isset($_GET["ExportType"])==''){
			if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
				$where = array('challan_dilivery.created_date >=' => $_GET['start'] , 'challan_dilivery.created_date <=' => $_GET['end'],'challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>1);
			}elseif($_GET['tab']=='challan' && $_GET['tab']!='auto'){
				$where = array('challan_dilivery.created_date >=' => $_GET['start'] , 'challan_dilivery.created_date <=' => $_GET['end'],'challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>0);
			}else{
				$where = array('challan_dilivery.created_date >=' => $_GET['start'] , 'challan_dilivery.created_date <=' => $_GET['end'],'challan_dilivery.created_by_cid'=> $this->companyGroupId,'challan_dilivery.auto_entry_po'=>0);
			}
		}
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2="challan_dilivery.challan_num like'%".$search_string."%'";
			redirect("account/delivery_chln/?search=$search_string");
        }else if(isset($_GET['search'])&& $_GET['search']!=''){
			$where2 = "challan_dilivery.challan_num like'%" . $_GET['search'] . "%' AND challan_in_out_wordType = 0";
		}
			
		if(!empty($_GET['order'])){
			$order=$_GET['order'];
		}else{
			$order="desc";
		}
		
		if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
				$rows=$this->account_model->num_rows('challan_dilivery',$where,$where2);
			}elseif($_GET['tab']=='challan' && $_GET['tab']!='auto'){
				$rows=$this->account_model->num_rows('challan_dilivery',$where,$where2);
			}else{
				$rows=$this->account_model->num_rows('challan_dilivery',$where,$where2);
			}
		
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/delivery_chln/";
			$config["total_rows"] = $rows;
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			
			if($_GET['tab'] == 'auto' && $_GET['tab'] != 'challan'){		
				$this->data['delivery_data_auto']  = $this->account_model->get_data1('challan_dilivery',$where, $config["per_page"], $page,$where2,$order,$export_data);
			}elseif($_GET['tab'] == 'challan' && $_GET['tab'] != 'auto'){
				$this->data['delivery_data']  = $this->account_model->get_data1('challan_dilivery',$where, $config["per_page"], $page,$where2,$order,$export_data);
				//pre($this->data['delivery_data']);
			}else{
				$this->data['delivery_data']  = $this->account_model->get_data1('challan_dilivery',$where, $config["per_page"], $page,$where2,$order,$export_data);
				$this->data['delivery_data_auto']  = $this->account_model->get_data1('challan_dilivery',$where, $config["per_page"], $page,$where2,$order,$export_data);	
			}
			if(!empty($this->uri->segment(3))){
				$frt = (int)$this->uri->segment(3) - 1;
				$start= $frt * $config['per_page']+1;
			}else{
				$start= (int)$this->uri->segment(3) * $config['per_page']+1;
			}
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
			$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
			$this->_render_template('delivery_chln/index', $this->data);
    }
	
	public function delivery_challan() {
		$this->load->library('pagination'); 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'delivery chln');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Delivery Challan Outward';
		$this->_render_template('delivery_chln/edit', $this->data);
	
	}
	public function delivery_challanInwardN() {
		$this->load->library('pagination'); 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'delivery chln');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Delivery Challan Inward';
		$this->_render_template('delivery_chln/edit_inword', $this->data);
	
	}
	
	
	public function editdelivery_chln(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery','id',$this->uri->segment(3));			
			$this->_render_template('delivery_chln/edit', $this->data);
		}else{
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');	
				$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery','id',$this->input->post('id'));
				$this->load->view('delivery_chln/edit', $this->data);
			}	
		}
	}	
	public function viewchalan_details(){
		
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');	
				$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery','id',$this->input->post('id'));			
				$this->load->view('delivery_chln/view', $this->data);
			}	
	}
	public function viewchalan_detailsinward(){
		
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');	
				$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery_inword','id',$this->input->post('id'));			
				$this->load->view('delivery_chln/inwardview', $this->data);
			}	
	}
	public function viewchalan_mat_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');
     		$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery','id',$this->input->post('id'));			
			$this->load->view('delivery_chln/mat_view', $this->data);
		}	
	}
	public function saveChallan_Details(){
		
		if ($this->input->post()) {
			// pre($_POST);die();
		
			$required_fields = array('descr_of_goods');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i],'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i],'bom_number'=>$_POST['bom_number'][$i],'process_name'=>$_POST['process_name'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}
								
				$data  = $this->input->post();
				$data['descr_of_goods'] = $descr_of_goods_array;
				$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['created_by_cid'] = $this->companyGroupId;
				$id = $data['id'];
				
				
				
				
				
				
			    
				if($id && $id != ''){
				/*Code for Third Party inventory Listing*/
				
				   
				
				   
				   /*Code for Third Party inventory Listing*/
				    //Convert auto entry To Challan
						$data['auto_entry_po'] = 0;
					 //Convert auto entry To Challan
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_datachallan('challan_dilivery',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "Challan updated successfully";
                        logActivity('Challan  Updated','delivery_chln',$id);
                        $this->session->set_flashdata('message', 'Challan  Updated successfully');
					    redirect(base_url().'account/delivery_chln', 'refresh');
                    }
				}else{
					if($_POST['auto_entry_po'] == 1 && $_POST['save_status'] == 1){
					 $invet_calculation = json_decode($descr_of_goods_array);
					
					 foreach($invet_calculation as $inv_data){
							$mat_idd = $inv_data->material_id;
							$get_dataa = $this->account_model->get_matrial_details2('mat_locations',$mat_idd,'material_name_id');
							$mat_qqty = $inv_data->quantity;
							$remaining_qty =  $get_dataa['quantity'] - $inv_data->quantity;
							$this->account_model->update_matrial_for_dilivery_challan('mat_locations',$mat_idd,$remaining_qty,$get_dataa['location_id']);
						}
						   $third_party_inv['material_descr'] = $descr_of_goods_array;
						   $third_party_inv['created_by'] = $_SESSION['loggedInUser']->u_id;
						   $third_party_inv['created_by_cid'] = $this->companyGroupId;
						   $third_party_inv['challan_totl_amt'] = $_POST['challan_total_amt'];
						   $third_party_inv['challan_number'] = $_POST['challan_num'];
						   $third_party_inv['challan_tbl_id'] = $_POST['id'];
						   $third_party_inv['challa_pur_ordr_no'] = $_POST['puo_id'];
						   $third_party_inv['party_name'] = $_POST['reciver_name'];
						   $third_party_inv['party_state_id'] = $_POST['party_state_id'];
						  
						   $this->account_model->insert_tbl_data('thrd_party_invtry',$third_party_inv);  	
				   }
				   
				 
					$id = $this->account_model->insert_tbl_datachallan('challan_dilivery',$data); 
					if($_POST['challan_type'] == 1 && $_POST['save_status'] == 1){
					   /*-- Challan Delivery Inword Data --*/
					$inword['descr_of_goods'] = $descr_of_goods_array;
					$inword['created_by'] = $_SESSION['loggedInUser']->u_id;
					$inword['branch_name'] = $_POST['branch_name'];
					$inword['challan_type'] = $_POST['challan_type'];
					$inword['reciver_name'] = $_POST['reciver_name'];
					$inword['reciver_address'] = $_POST['reciver_address'];
					$inword['supplier_ledger'] = $_POST['supplier_ledger'];
					$inword['supplier_address'] = $_POST['supplier_address'];
					$inword['party_phone'] = $_POST['party_phone'];
					$inword['challan_num'] = $_POST['challan_num'];
					$inword['challan_date'] = $_POST['challan_date'];
					$inword['vehicle_reg_no'] = $_POST['vehicle_reg_no'];
					//$inword['descr_of_goods'] = $descr_of_goods_array;
					$inword['challan_total_amt'] = $_POST['challan_total_amt'];
					$inword['transporter_phone'] = $_POST['transporter_phone'];
					$inword['terms_of_delivery'] = $_POST['terms_of_delivery'];
					$inword['auto_entry'] = 1;
					$inword['challan_id'] = $id;
					$inword['created_by_cid'] = $this->companyGroupId;
				/*-- Challan Delivery Inword Data --*/
					 $this->account_model->insert_tbl_datachallan('challan_dilivery_inword',$inword);
					   
				   } 					
					if ($id) {                        
                        logActivity('New Challan Created','delivery_chln',$id);
                        $this->session->set_flashdata('message', 'Challan  inserted successfully');
					    redirect(base_url().'account/delivery_chln', 'refresh');
                    }    				
				}
			}			
        }
	}
	public function deleteChallan_details($id = ''){	
		if (!$id) {
           redirect('account/delivery_chln', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('challan_dilivery','id',$id);
		
		if($result){
			logActivity('Challan Details Deleted','challan_dilivery',$id);
			$this->session->set_flashdata('message', 'Challan Details Deleted Successfully');
			$result = array('msg' => 'Challan Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/delivery_chln');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
public function deleteChallan_detailsinward($id = ''){	
		if (!$id) {
           redirect('account/delivery_chln_inword', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('challan_dilivery_inword','id',$id);
		
		if($result){
			logActivity('Challan Details Deleted','challan_dilivery_inword',$id);
			$this->session->set_flashdata('message', 'Challan Details Deleted Successfully');
			$result = array('msg' => 'Challan Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'account/delivery_chln_inword');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}
	
	public function create_challan_pdf($id = ''){
		$this->load->library('Pdf');
		$dataPdf['dataPdf'] = $this->account_model->get_data_byId('challan_dilivery','id',$id);
     	$this->load->view('delivery_chln/dilivery_challan_pdf',$dataPdf);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		
	}
	public function create_challan_pdfinward($id = ''){
		$this->load->library('Pdf');
		$dataPdf['dataPdf'] = $this->account_model->get_data_byId('challan_dilivery_inword','id',$id);
     	$this->load->view('delivery_chln/dilivery_challan_pdf',$dataPdf);	//$this->_render_template('purchase_order/view_pdf', $this->data);
		
	}
/* In word Delivery Challan*/
public function editdelivery_chlninword(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery_inword','id',$this->uri->segment(3));			
			$this->_render_template('delivery_chln/edit_inword', $this->data);
		}
	}
	
public function adddelivery_chlninword(){
		
			if($this->input->post()){
				$this->data['id'] = $this->input->post('id');	
				$this->data['delivery_data'] = $this->account_model->get_data_byId('challan_dilivery_inword','id',$this->input->post('id'));
				$this->load->view('delivery_chln/delivery_chln_inword', $this->data);
				
		}
	}		
	
public function delivery_chln_inword() {
		$this->load->library('pagination'); 
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Account', base_url() . 'delivery chln');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Delivery Challan In Word';
		$created_id = $this->companyGroupId;
		//$created_id = $_SESSION['loggedInUser']->c_id;
		
	
		if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
			$where = array('challan_dilivery_inword.auto_entry'=>1,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
			}elseif($_GET['tab']!='auto' && $_GET['tab']=='challan'){
				$where = array('challan_dilivery_inword.auto_entry'=>0,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
			}else{
				$where = array('challan_dilivery_inword.auto_entry'=>0,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);	
			 }
		if(isset($_GET["ExportType"])!='' && $_GET['start'] == '' && $_GET['end'] == '') {
			if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
					$where = array('challan_dilivery_inword.auto_entry'=>1,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
				}elseif($_GET['tab']=='challan' && $_GET['tab']!='auto'){
					$where = array('challan_dilivery_inword.auto_entry'=>0,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
				}else{
					$where = array('challan_dilivery_inword.auto_entry'=>0,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
				}
		}elseif(isset($_GET["ExportType"]) && $_GET['start']!= '' && $_GET['end']!= '') {
			if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
				$where = array('challan_dilivery_inword.created_date >=' => $_GET['start'] , 'challan_dilivery_inword.created_date <=' => $_GET['end'],'challan_dilivery_inword.auto_entry'=>1,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
			}elseif($_GET['tab']=='challan' && $_GET['tab']!='auto'){
				$where = array('challan_dilivery_inword.auto_entry'=>0,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
			}else{
				$where = array('challan_dilivery_inword.created_date >=' => $_GET['start'] , 'challan_dilivery_inword.created_date <=' => $_GET['end'],'challan_dilivery_inword.auto_entry'=>0,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
			}
		}
		if(!empty($_GET) && isset($_GET['start']) &&  isset($_GET['end']) && isset($_GET["ExportType"])==''){
			if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
				$where = array('challan_dilivery_inword.created_date >=' => $_GET['start'] , 'challan_dilivery_inword.created_date <=' => $_GET['end'],'challan_dilivery_inword.auto_entry_po'=>1,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
			}elseif($_GET['tab']=='challan' && $_GET['tab']!='auto'){
				$where = array('challan_dilivery_inword.created_date >=' => $_GET['start'] , 'challan_dilivery_inword.created_date <=' => $_GET['end'],'challan_dilivery_inword.auto_entry_po'=>0,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
			}else{
				$where = array('challan_dilivery_inword.created_date >=' => $_GET['start'] , 'challan_dilivery_inword.created_date <=' => $_GET['end'],'challan_dilivery_inword.auto_entry_po'=>0,'challan_dilivery_inword.branch_name'=> $this->companyGroupId);
			}
		}
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2="challan_dilivery_inword.challan_num like'%".$search_string."%'";
			redirect("account/delivery_chln_inword/?search=$search_string");
        }else if(isset($_GET['search'])&& $_GET['search']!=''){
			$where2 = "challan_dilivery_inword.challan_num like'%" . $_GET['search'] . "%' AND challan_in_out_wordType = 1";
		}
			
		if(!empty($_GET['order'])){
			$order=$_GET['order'];
		}else{
			$order="desc";
		}
		
		if($_GET['tab']=='auto' && $_GET['tab']!='challan'){
				$rows=$this->account_model->num_rows('challan_dilivery_inword',$where,$where2);
			}elseif($_GET['tab']=='challan' && $_GET['tab']!='auto'){
				$rows=$this->account_model->num_rows('challan_dilivery_inword',$where,$where2);
			}else{
				$rows=$this->account_model->num_rows('challan_dilivery_inword',$where,$where2);
			}
		
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/delivery_chln_inword/";
			$config["total_rows"] = $rows;
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			
			if($_GET['tab'] == 'auto' && $_GET['tab'] != 'challan'){		
				$this->data['delivery_data_auto']  = $this->account_model->get_data1('challan_dilivery_inword',$where, $config["per_page"], $page,$where2,$order,$export_data);
			}elseif($_GET['tab'] == 'challan' && $_GET['tab'] != 'auto'){
				$this->data['delivery_data']  = $this->account_model->get_data1('challan_dilivery_inword',$where, $config["per_page"], $page,$where2,$order,$export_data);
				//pre($this->data['delivery_data']);
			}else{
				$this->data['delivery_data']  = $this->account_model->get_data1('challan_dilivery_inword',$where, $config["per_page"], $page,$where2,$order,$export_data);
				$this->data['delivery_data_auto']  = $this->account_model->get_data1('challan_dilivery_inword',$where, $config["per_page"], $page,$where2,$order,$export_data);	
			}
			if(!empty($this->uri->segment(3))){
				$frt = (int)$this->uri->segment(3) - 1;
				$start= $frt * $config['per_page']+1;
			}else{
				$start= (int)$this->uri->segment(3) * $config['per_page']+1;
			}
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
			$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$end.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
			$this->_render_template('delivery_chln/inword_index.php', $this->data);
    }

public function saveinwordChallan_Details(){
		
		if ($this->input->post()) {
		
			$required_fields = array('descr_of_goods');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i],'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i],'bom_number'=>$_POST['bom_number'][$i],'process_name'=>$_POST['process_name'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}
					$id = $_POST['id'];	
					//$data  = $this->input->post();
				     $data['descr_of_goods'] = $descr_of_goods_array;
					 $data['created_by'] = $_SESSION['loggedInUser']->u_id;
					$data['reciver_name'] = $_POST['reciver_name'];
					$data['reciver_address'] = $_POST['reciver_address'];
					$data['supplier_ledger'] = $_POST['supplier_ledger'];
					$data['supplier_address'] = $_POST['supplier_address'];
					$data['branch_name'] = $_POST['branch_name'];
					$data['challan_type'] = $_POST['challan_type'];
					$data['party_phone'] = $_POST['party_phone'];
					$data['challan_num'] = $_POST['challan_num'];
					$data['challan_date'] = $_POST['challan_date'];
					$data['vehicle_reg_no'] = $_POST['vehicle_reg_no'];
					$data['challan_total_amt'] = $_POST['challan_total_amt'];
					$data['transporter_phone'] = $_POST['transporter_phone'];
					$data['terms_of_delivery'] = $_POST['terms_of_delivery'];
					 $data['auto_entry'] = 0;
					// $data['challan_id'] = $_POST['challan_id'];
					$data['created_by_cid'] = $this->companyGroupId;
					
					//pre($data);die();
				if($id && $id != ''){
				/*Code for Third Party inventory Listing*/
				
					 //Convert auto entry To Challan
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					$success = $this->account_model->update_datachallan('challan_dilivery_inword',$data, 'id', $id);
					if(!empty($data) && $data['descr_of_goods'] !=''){
						$inventoryFlowData = json_decode($data['descr_of_goods']);
						foreach($inventoryFlowData as $key => $item) {
							$getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' =>$item->material_id));
							foreach($getAddres as $loc1){
									 $arr[] =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] , 'quantity' => $item->quantity , 'Qtyuom' => $item->UOM)));
									 $rt++;
								 }

								 $yu = getNameById_mat('mat_locations',$item->material_id,'material_name_id');
								 $sum = 0;
								 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}

							$closingblcn = $sum - $item->quantity;
							$inventoryFlowDataArray['current_location'] = $arr[$i];     
							$inventoryFlowDataArray['material_id'] =  $item->material_id;
							$inventoryFlowDataArray['material_out'] =  $item->quantity;
							$inventoryFlowDataArray['opening_blnc'] = $sum;
							$inventoryFlowDataArray['closing_blnc'] = $closingblcn;
							$inventoryFlowDataArray['uom'] =  $item->UOM;
							$inventoryFlowDataArray['material_type_id'] =  $loc1['material_type_id'];

							$inventoryFlowDataArray['through'] =  'Dilivery challan';
							$inventoryFlowDataArray['ref_id'] =  $id;
							$inventoryFlowDataArray['created_by'] =  $_SESSION['loggedInUser']->id;
							//$inventoryFlowDataArray['created_by_cid'] =  $_SESSION['loggedInUser']->c_id;
							$inventoryFlowDataArray['created_by_cid'] =  $this->companyGroupId;

							#pre($inventoryFlowDataArray);die;
							$this->account_model->insert_tbl_data('inventory_flow',$inventoryFlowDataArray);
							#pre($item);		
							$inCount++;
							$getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' => $item->material_id,'location_id'=>$supplier_address));

							foreach ($getAddres as & $values) {
								if ($values['material_name_id'] == $item->material_id) {
									$updatedQty = $values['quantity'] - $item->quantity;
									$values['quantity'] = $updatedQty;
									$success = $this->account_model->update_single_field('mat_locations', $values, $item->material_id);
									break;
								}
							}
							
							$getAddres_reciver = $this->account_model->get_data('mat_locations', array('material_name_id' => $item->material_id,'location_id'=>$reciver_address));
							if(!empty($getAddres_reciver)){
								foreach ($getAddres_reciver as & $values) {
									if ($values['material_name_id'] == $item->material_id) {
										$updatedQty = $values['quantity'] + $item->quantity;
										$values['quantity'] = $updatedQty;
										$success = $this->account_model->update_single_field('mat_locations', $values, $item->material_id);
										break;
									}
								}
							}else{
								$insert_data['quantity'] = $item->quantity;
								$insert_data['material_name_id'] = $item->material_id;
								$insert_data['material_type_id'] = $loc1['material_type_id'];
								$insert_data['location_id'] = $reciver_address;
								$insert_data['Qtyuom'] = $item->UOM;
								$this->account_model->insert_tbl_data('mat_locations',$insert_data);
								// foreach ($getAddres_reciver as & $values) {
									// if ($values['material_name_id'] == $item->material_id) {
										// $updatedQty = $values['quantity'] + $item->quantity;
										// $values['quantity'] = $updatedQty;
										// $success = $this->account_model->update_single_field('mat_locations', $values, $item->material_id);
										// break;
									// }
								// }
								
							}	
						}
						
					}					
					if ($success) {
                        $data['message'] = "Challan updated successfully";
                        logActivity('Challan  Updated','challan_dilivery_inword',$id);
                        $this->session->set_flashdata('message', 'Challan  Updated successfully');
					    redirect(base_url().'account/delivery_chln_inword', 'refresh');
                    }
				}else{
					//pre($data);die('NW');
				   $id = $this->account_model->insert_tbl_datachallan('challan_dilivery_inword',$data); 
			
					   
				   } 					
					if ($id) {                        
                        logActivity('New Challan Created','challan_dilivery_inword',$id);
                        $this->session->set_flashdata('message', 'Challan  inserted successfully');
					    redirect(base_url().'account/delivery_chln_inword', 'refresh');
                    }    				
				}
			}			
        }
		
/* In word Delivery Challan*/	
	
	
	
	
	
	 function share_pdf_using_email_invoice(){
		$share_email_address = $_REQUEST['share_email'];
		$invoiceid = $_REQUEST['invoice_id'];
		$email_message = $_REQUEST['email_msg_id'];
		$invoice_details = getNameById('invoice',$invoiceid,'id');
		$company_details = getNameById('company_detail',$this->companyGroupId,'id');
		$company_emails = getNameById('user',$this->companyGroupId,'c_id');
		$company_dtl = json_decode($company_details->address,true);
		$country_dtl = getNameById('country',$company_dtl[0]['country'],'country_id');
		
		$namddd = $country_dtl->country_name . ' - ' . $company_dtl[0]['postal_zipcode'];
		
		
		
		
		
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />
								<meta name="viewport" content="width=device-width" />
							</head>
							<body style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 40px 0;" bgcolor="#efefef">
								<table class="body-wrap text-center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef">
									<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
												<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
													<td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="'.base_url().'assets/modules/company/uploads/'.$_SESSION['loggedInCompany']->logo.'" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 20%; display: block; margin: 0 auto; padding: 0;" /></td>
												</tr>';    
										
								$footer = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
											<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
												<td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">							
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="'. base_url() .'" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Support: '.$company_emails->email.'</p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">'.$company_dtl[0]['address'].',  '. $namddd .' </p>
												</td>
											</tr>
										</table>
										</td>
									</tr>
								</table>
							</body>
						</html>';
						$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
															<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi ,</p>								
																
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Message '.$email_message.'</p>	
															</td>
														</tr>
													</table>
												</td>
											</tr>';	
											//$invoice_details->message_for_email
						$messageContent = $header.$email_message.$footer;
						
						$invoice_numm = 'Invoice No:- '.$invoice_details->invoice_num;
						ini_set('memory_limit', '20M');
						$this->load->library('pdf');
						$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);
						// $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
						$pdf->SetCreator(PDF_CREATOR);  
						$pdf->SetTitle("TAX INVOICE");  
						$pdf->SetHeaderData('TAX INVOICE', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
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
						$dataPdf['dataPdf'] = $this->account_model->get_data_byId('invoice','id',$invoice_details->id);
						//$dataPdf = $this->account_model->get_data_byId('invoice','id',$invoice_details->id);
						$pdf->SetCreator(PDF_CREATOR);
						$pdf->AddPage();
						$html = $this->load->view('invoice/invoice_pdf_email',$dataPdf, true);
						
						
			
						$pdf->WriteHTML($html); 
						// $pdf->writeHTML($html, true, 0, true, 0);
						$pdf->lastPage();
						// $pdf->WriteHTML(0, $html, '', 0, 'L', true, 0, false, false, 0);	
						$pdfFilePath = FCPATH . "assets/modules/account/pdf_invoice/pdf_invoice.pdf";
						ob_clean();
						$pdf->Output($pdfFilePath, "F");
							
						
		// PHPMailer object
		        	$this->load->library('phpmailer_lib');
                        $mail = $this->phpmailer_lib->load();
                                 //Server settings
                            $mail->SMTPDebug = 0;  
                                    $mail->SMTPOptions = array(
                                    'ssl' => array(
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true
                                    )
                                );// Enable verbose debug output
                                    $mail->isSMTP();                                            // Send using SMTP
                                    $mail->Host       = 'email-smtp.ap-south-1.amazonaws.com';                    // Set the SMTP server to send through
                                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                    $mail->Username   = 'AKIAZB4WVENV5X4RKVMF';                     // SMTP username
                                    $mail->Password   = 'BBOBZRx1LIjwa56GWzgM0e8X9JAfCZ6Rr7ldVOcGHHRk';                               // SMTP password
                                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                                
                                         //Recipients
                                    $mail->setFrom('dev@lastingerp.com',$company_details->name);
                                    $mail->addAddress($share_email_address,'');     // Add a recipient

                                    // Content
                                        $mail->isHTML(true);
                                        // Email body content
                                        $mailContent = $messageContent;
                                        $mail->Body = $mailContent;
                                        $mail->Subject = $invoice_numm;
                                        $mail->addAttachment($pdfFilePath);
                						  if($mail->send()){
                						  echo '<script>alert("Welcome to Geeks for Geeks")</script>'; 
                							unlink($pdfFilePath);
                						  }else{
                						      
                							echo "notsend"; 
                						  }
                                        
	}
	
/* Day book functionality Start*/	
 function day_book(){
	$this->load->library('pagination');
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Account', base_url() . 'day_book');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Day Book';
	$created_id = $this->companyGroupId;
	// pre($_GET);
	// die();
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_GET['search'])){
			$search_string = $_GET['search'];
			$where2="transaction_dtl.type like'%".$search_string."%'";
		     //redirect("account/day_book/?search=$search_string");
        }
		// else if(isset($_GET['search'])){
				 // $where2 = "transaction_dtl.type like'%" . $_GET['search'] . "%' ";
			// }
			
			if(!empty($_GET['order'])){
			$order=$_GET['order'];
		}else{
			$order="desc";
		}
		
		//Pagination
		$current_date = date('Y-m-d');
		$config = array();
			$config["base_url"] = base_url() . "account/day_book/";
			$config["total_rows"] = $this->account_model->num_rows('transaction_dtl',array('created_by_cid'=>$created_id,DATE_FORMAT(created_date,'%Y-%m-%d')=>$current_date,'ledger_id'=>1,'ledger_id'=>2,'ledger_id'=>3,'ledger_id'=>4,'ledger_id'=>5,'ledger_id'=>6),$where2);
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
			if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		
		$current_date = date('Y-m-d');
		
		if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
				// echo '1';
			$this->data['day_data_val']  = $this->account_model->get_data_daybook('transaction_dtl',array('created_by_cid'=> $created_id),$config["per_page"], $page,$where2,$order);
			$this->_render_template('day_book/index', $this->data);
		}
		if(isset($_GET['start']) &&  isset($_GET['end'])){
			// echo '2';
			$where = array('transaction_dtl.created_date >=' => $_GET['start'],'transaction_dtl.created_date <=' => $_GET['end'],'transaction_dtl.created_by_cid'=> $this->companyGroupId);
			$this->data['day_data_val']  = $this->account_model->get_data_day_book('transaction_dtl',$where,$config["per_page"], $page,$where2,$order);
			//$this->_render_template('day_book/index', $this->data);
			//$this->load->view('account_group/edit', $this->data);
		}elseif(isset($_GET["ExportType"]) && $_GET['start'] != '' && $_GET['end'] != ''){
			// echo '3';
		    $this->data['day_data_val']  = $this->account_model->get_data_daybook('transaction_dtl',array('created_by_cid'=> $created_id),$config["per_page"], $page,$where2,$order);
			$this->_render_template('day_book/index', $this->data);
		}else{
		
			$this->data['day_data_val']  = $this->account_model->get_data_daybook('transaction_dtl',array('created_by_cid'=> $created_id), $config["per_page"], $page,$where2,$order);
			
			$this->_render_template('day_book/index', $this->data);
		}
		
		//SELECT * FROM `transaction_dtl` WHERE `created_by_cid` = '3' AND DATE_FORMAT(`created_date`,'%Y-%m-%d') = '2020-02-06'
}
/* Day book functionality End*/	
 function cash_flow(){
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Account', base_url() . 'cash_flow');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Cash Flow';
	$created_id = $_SESSION['loggedInUser']->c_id;
	
	/* 0 for Payment receive and 1 for Payment to */
	/* For Financial Year*/
	$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$_SESSION['loggedInUser']->c_id);//Fetch Data to Company Table
	$date_fcal = json_decode($date_fun->financial_year_date,true);
	
		if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}
	/* For Financial Year*/
	
	if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
			 $where = " (ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND  transaction_dtl.created_by_cid = ".$this->companyGroupId."";
			$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($where);
			$this->_render_template('cash_flow/index', $this->data);
		}
	if($_GET['selected_branch_idd'] == 'All'){
		$where = " (ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND  transaction_dtl.created_by_cid = ".$this->companyGroupId."";
		$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($where);
		$this->_render_template('cash_flow/index', $this->data);
	}
	
	if(!empty($_GET) && isset($_GET['start']) &&  isset($_GET['end']) && !isset($_GET['selected_branch_idd'])){
			$where = ' AND ledger.created_date >="'.$_GET['start'] . '" AND ledger.created_date <="' .$_GET['end'] . '"' ;
			$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($_GET['start'],$_GET['end']);
			$this->_render_template('cash_flow/index', $this->data);
		}elseif(isset($_GET['selected_branch_idd'])){
			
			$where = " (ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND ledger.compny_branch_id = '". $_GET['selected_branch_idd']  ."' AND ledger.created_by_cid = '".$this->companyGroupId."'";
			$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($where);
			
			$this->_render_template('cash_flow/index', $this->data);
		}else{
			$where = " (ledger.created_date >='".$first_date."' AND  ledger.created_date <='".$second_date."') AND  transaction_dtl.created_by_cid = ".$this->companyGroupId."";
			$this->data['cash_flow_val']  = $this->account_model->get_cash_flow_data($where);
			$this->_render_template('cash_flow/index', $this->data);
	}
}	
	
	
	
	
 function updateoldrecords(){

//$invoice_data = $this->account_model->get_data('invoice',array('created_by_cid'=> $this->companyGroupId));
$invoice_data = $this->account_model->get_data('purchase_bill',array('created_by_cid'=> $this->companyGroupId));





foreach ($invoice_data as $datas) {
	
$id =  $datas['id'];

//$convert_date = date("Y-m-d", strtotime($datas['date_time_of_invoice_issue']));	
$convert_date = date("Y-m-d", strtotime($datas['date']));	
//echo $convert_date;	
	//$this->account_model->update_single_date_fun($convert_date, $id,'invoice','date_time_of_invoice_issue');
	$this->account_model->update_single_date_fun($convert_date, $id,'purchase_bill','date');
	
	
	
	
	
	
	
	
				//$products = json_decode($key['descr_of_goods']);

				//foreach($products as $product){

				//	$ww =	getNameById('uom', $product->UOM,'ugc_code');

				//	$product->UOM = $ww->id;

					//$product_array = "[".json_encode($product)."]";

					//$data['descr_of_goods'] = $product_array;

					//pre($data['descr_of_goods']);

				//	$aa = array('id' => $key['id']);

					//$this->account_model->updateRowWhere('invoice',$aa,$data);

					//die();
				//}
}

}	
	
	 function view_invoice($invoice_id = 317){
		if($invoice_id){
			$this->data['id'] = $this->input->post('id');	
			$this->data['invoice_detail'] = $this->account_model->get_data_byId('invoice','id',$invoice_id);			
			$this->_render_template('invoice/view_invoice', $this->data);
		}	
	}
	
     function change_status_ledgerss(){
		$id = (isset($_POST['id'])) ? $_POST['id'] : '';		
		$status = (isset($_POST['gstatus']) && $_POST['gstatus'] == 1) ? '1' : '0';
		
        $status_data = $this->account_model->change_status_toggle($id, $status);
		echo json_encode($status_data);
    }	
	
	
	/************************* Ageing Report Code HEre***********************************/
	// function create_agingReport_PDF(){
		// echo 'Hello';
		// pre($_GET);
	// }
	 function aging_report() { 
	 $this->load->library('pagination');
	 $this->load->library('pdf'); 
  
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Ageing Report', base_url() . 'Ageing Report');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Ageing Report Detail';
		//$created_by_id  = $_SESSION['loggedInUser']->c_id;
		$created_by_id  = $this->companyGroupId;
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$created_by_id);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date('Y-m-d', $second_date22);
					}
				}
		$where=array('created_by_cid'=> $created_by_id,'invoice.date_time_of_invoice_issue >=' =>$first_date, 'invoice.date_time_of_invoice_issue <=' => $second_date,'invoice.pay_or_not = '=> 0);	
		if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
			$where = array('created_by_cid'=> $created_by_id,'invoice.date_time_of_invoice_issue >=' =>$first_date, 'invoice.date_time_of_invoice_issue <=' => $second_date,'invoice.pay_or_not = ' => 0);
		}elseif(isset($_GET['start'])!='' &&  isset($_GET['end'])!='' && isset($_GET["ExportType"])){
			$where = "invoice.created_by_cid = ".$created_by_id." AND  (invoice.date_time_of_invoice_issue >='".$_GET['start']."' AND  invoice.date_time_of_invoice_issue <='".$_GET['end']."' AND 'invoice.pay_or_not' = 0)";
		}
		
		if(isset($_GET['start'])!='' &&  isset($_GET['end'])!='' && isset($_GET["ExportType"])==''){
			$where = "invoice.created_by_cid = ".$created_by_id." AND  (invoice.date_time_of_invoice_issue >='".$_GET['start']."' AND  invoice.date_time_of_invoice_issue <='".$_GET['end']."' AND 'invoice.pay_or_not' = 0)";
		}elseif(isset($_GET['sales_person'])){
			$where = array('invoice.sales_person =' => $_GET['sales_person'], 'invoice.created_by_cid'=> $this->companyGroupId);
		}
		//Search
		$where2='';
		$search_string = '';
		if(isset($_GET['search']) && $_GET['search'] != ''){
			$party_name=getNameBySearch('ledger',$_GET['search'],'name');
			$supplier_name = getNameById('user_detail',$_GET['search'],'name');
			if($party_name->name != '' ){
					$where2 = "invoice.party_name like '%" .$party_name->id. "%'  AND  invoice.pay_or_not = 0 ";
				}
				else if($party_name->sales_person != '') {
					$where2 = "invoice.sales_person like '%" .$supplier_name->u_id. "%'  AND  invoice.pay_or_not = 0 ";
				}else{
					$where2 = "invoice.id like '%" .$_GET['search']. "%'  AND  invoice.pay_or_not = 0 ";
				}
			}
			
		if(!empty($_POST['order'])){
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
		//Pagination
			
		$config = array();
			$config["base_url"] = base_url() . "account/aging_report/";
			$config["total_rows"] = $this->account_model->num_rows('invoice',$where,$where2);
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			
		//pre($_GET);
		
			$this->data['add_invoice_details']  = $this->account_model->get_invoice_details_aging_report('invoice',$where, $config["per_page"], $page,$where2,$order,$export_data,$_GET['over_due_payment']);
			
			
			
			if($_GET['ExportTypePDF'] == 'aging_reportdata'){
				$this->load->view('aging_report/pdffile', $this->data);
				//$this->_render_template('aging_report/pdffile', $this->data);
				//die();
				
			}
				if(!empty($this->uri->segment(3))){
					$frt = (int)$this->uri->segment(3) - 1;
					$start= $frt * $config['per_page']+1;
			   }else{
					$start= (int)$this->uri->segment(3) * $config['per_page']+1;
			   }
	   
		   if(!empty($this->uri->segment(3))){
			   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
		   }else{
			  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
		   }
		 
			if($end>$config['total_rows'])
			{
			$total=$config['total_rows'];	
			}else{
			$total=$end;		
			}
		
		   
			$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.
			
			
			
			
			$this->_render_template('aging_report/index', $this->data);
	}
	
	
	
	public function ageing_report_over_due() { 
		$this->load->library('pagination');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Ageing Report', base_url() . 'Ageing Report');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Ageing Report Detail';
		//$created_by_id  = $_SESSION['loggedInUser']->c_id;
		$created_by_id  = $this->companyGroupId;
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$created_by_id);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
			
			if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date('Y-m-d', $second_date22);
					}
				}
				
		$where=array('created_by_cid'=> $created_by_id,'invoice.created_date >=' =>$first_date, 'invoice.created_date <=' => $second_date,'invoice.pay_or_not = '=> 0);	
		

		if(isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '') {
			$where = array('created_by_cid'=> $created_by_id,'invoice.date_time_of_invoice_issue >=' =>$first_date, 'invoice.date_time_of_invoice_issue <=' => $second_date,'invoice.pay_or_not = ' => 0);
			
		}elseif(isset($_GET['start'])!='' &&  isset($_GET['end'])!='' && isset($_GET["ExportType"])){
			$where = "invoice.created_by_cid = ".$created_by_id." AND  (invoice.date_time_of_invoice_issue >='".$_GET['start']."' AND  invoice.date_time_of_invoice_issue <='".$_GET['end']."' AND 'invoice.pay_or_not' = 0)";
		}
		
		if(isset($_GET['start'])!='' &&  isset($_GET['end'])!='' && isset($_GET["ExportType"])==''){
			$where = "invoice.created_by_cid = ".$created_by_id." AND  (invoice.date_time_of_invoice_issue >='".$_GET['start']."' AND  invoice.date_time_of_invoice_issue <='".$_GET['end']."' AND 'invoice.pay_or_not' = 0)";
		}
		//Search
		$where2='';
		$search_string = '';
		if(isset($_GET['search']) && $_GET['search'] != ''){
			    $party_name=getNameBySearch('ledger',$_GET['search'],'name');
				 $supplier_name = getNameById('user_detail',$_GET['search'],'name');
				//pre($party_name);
				if($party_name->name != '' ){
					$where2 = "invoice.party_name like '%" .$party_name->id. "%'  AND  invoice.pay_or_not = 0 ";
				}
				else if($party_name->sales_person != '') {
					$where2 = "invoice.sales_person like '%" .$supplier_name->u_id. "%'  AND  invoice.pay_or_not = 0 ";
				}
			}
			
		if(!empty($_POST['order'])){
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
		//Pagination
			
		$config = array();
			$config["base_url"] = base_url() . "account/invoices/";
			$config["total_rows"] = $this->account_model->num_rows('invoice',$where,$where2);
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
			if(!empty($_GET['ExportType'])){
				$export_data = 1;
			}else{
				$export_data = 0;
			}
			
			$over_Due_invoice = 1;
			$this->data['add_invoice_details']  = $this->account_model->get_invoice_details_aging_report('invoice',$where, $config["per_page"], $page,$where2,$order,$export_data,$over_Due_invoice);
			
			
				if(!empty($this->uri->segment(3))){
					$frt = (int)$this->uri->segment(3) - 1;
					$start= $frt * $config['per_page']+1;
			   }else{
					$start= (int)$this->uri->segment(3) * $config['per_page']+1;
			   }
	   
		   if(!empty($this->uri->segment(3))){
			   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
		   }else{
			  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
		   }
		   
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
	
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.
		$this->_render_template('aging_report/over_due', $this->data);
	}
	
	
	
	function Aging_report_email_Send(){
		$invoice_id = $_REQUEST['invoice_id'];
		$company_details = getNameById('company_detail',$this->companyGroupId,'id');
		$email_data = json_decode($company_details->aging_email_text,true);
		
		foreach($invoice_id as $idd){
			$email_subject_chk = $email_data[0]['email_subject'];
			$email_msg = $email_data[0]['email_message'];
			$email_subject = $email_subject_chk;
			$email_message_Data = $email_msg;
			
			//$inv_data[]['invoice_id'] = $invoice_id;
		
			$invoice_Data = getNameById('invoice',$idd,'id');
			$INNVoice_no =  $invoice_Data->invoice_num;
			$subject_email = $email_subject .' '.$INNVoice_no;
			
			$ledger_Data = getNameById('ledger',$invoice_Data->party_name,'id');
			 $party_ledger_name = $ledger_Data->name;
			
			 $party_email_name = $ledger_Data->email;
			
			//$invoice_details = getNameById('invoice',$invoiceid,'id');
		
			$company_emails = getNameById('user',$this->companyGroupId,'c_id');
			$company_dtl = json_decode($company_details->address,true);
			$country_dtl = getNameById('country',$company_dtl[0]['country'],'country_id');
			$namddd = $country_dtl->country_name . ' - ' . $company_dtl[0]['postal_zipcode'];
		
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />
								<meta name="viewport" content="width=device-width" />
							</head>
							<body style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 40px 0;" bgcolor="#efefef">
								<table class="body-wrap text-center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; text-align: center; background: #efefef; margin: 0; padding: 0;" bgcolor="#efefef">
									<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
												<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
													<td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="'.base_url().'assets/modules/company/uploads/'.$_SESSION['loggedInCompany']->logo.'" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 20%; display: block; margin: 0 auto; padding: 0;" /></td>
												</tr>';    
										
								$footer = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
											<!-- Message start -->
											<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
											<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
												<td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">							
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="'. base_url() .'" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Support: '.$company_emails->email.'</p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">'.$company_dtl[0]['address'].',  '. $namddd .' </p>
												</td>
											</tr>
										</table>
										</td>
									</tr>
								</table>
							</body>
						</html>';
						$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
										<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
											<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi , '.$party_ledger_name.'</p>								
											
											<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">'.$email_message_Data.'</p>	</br></br></br>
											<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Thanks</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>';	
						//$invoice_details->message_for_email
						$messageContent = $header.$email_message.$footer;
					
						//$invoice_numm = 'Invoice No:- '.$invoice_details->invoice_num;
						
						ini_set('memory_limit', '20M');
						$this->load->library('phpmailer_lib');
                        $mail = $this->phpmailer_lib->load();
                                 //Server settings
                            $mail->SMTPDebug = 0;  
                                    $mail->SMTPOptions = array(
                                    'ssl' => array(
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true
                                    )
                                );// Enable verbose debug output
                                    $mail->isSMTP();                                            // Send using SMTP
                                    $mail->Host       = 'email-smtp.ap-south-1.amazonaws.com';                    // Set the SMTP server to send through
                                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                    $mail->Username   = 'AKIAZB4WVENV5X4RKVMF';                     // SMTP username
                                    $mail->Password   = 'BBOBZRx1LIjwa56GWzgM0e8X9JAfCZ6Rr7ldVOcGHHRk';                               // SMTP password
                                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                                
                                         //Recipients
                                    $mail->setFrom('dev@lastingerp.com',$company_details->name);
                                    $mail->addAddress($party_email_name,'');     // Add a recipient

                                    // Content
                                        $mail->isHTML(true);
                                        // Email body content
                                        $mailContent = $messageContent;
                                        $mail->Body = $mailContent;
                                        $mail->Subject = $subject_email;
										$mail->send();
									}	
                                       // $mail->addAttachment($pdfFilePath);
                						  if($mail->send()){
                						 // echo '<script>alert("Welcome to Geeks for Geeks")</script>'; 
											echo 'sent';
                							//unlink($pdfFilePath);
                						  }else{
                						      
                							echo "notsend"; 
                						  }
								        
							}
							
							
	/*START  HSN MASTER CODE*/						
	public function hsnsacmaster(){
		$this->load->library('pagination');
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('HSN / SAC Master', base_url() . 'HSN / SAC Master');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'HSN / SAC Master';
		$created_id = $this->companyGroupId;
		
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2=" hsn_sac_master.id like '%".$search_string."%' or hsn_sac_master.short_name like '%".$search_string."%'";
		 redirect("account/hsnsacmaster/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "hsn_sac_master.short_name like'%" . $_GET['search'] . "%' or hsn_sac_master.id like'%". $_GET['search']."%'";
			}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
      $where_row='(created_by_cid = 0 OR created_by_cid = "'.$created_id.'")';
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/hsnsacmaster/";
			$config["total_rows"] = $this->account_model->num_rows('hsn_sac_master',$where_row,$where2);
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
	//	$this->data['ledgers']  = $this->account_model->get_data_listing('ledger',$where, $config['per_page'] , $page,  $this->data['sort_by'], $orderBy,$this->data['search_string']);
	$this->data['hsn_master_data'] = $this->account_model->get_data_with_zero_id_condtions('hsn_sac_master',$created_id, $config["per_page"], $page,$where2,$order);
	if(!empty($this->uri->segment(3))){
		    $frt = (int)$this->uri->segment(3) - 1;
			$start= $frt * $config['per_page']+1;
	      }else{
	   	   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
	    }
	   
	   if(!empty($this->uri->segment(3))){
		   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
	   }else{
		  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
	   }
		if($end>$config['total_rows'])
		{
		$total=$config['total_rows'];	
		}else{
		$total=$end;		
		}
		$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
		$this->_render_template('hsnsac_master/index', $this->data);
		  
	}
	public function createHSNSAC_master(){
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('HSN / SAC Master', base_url() . 'HSN / SAC Master');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'HSN / SAC Master';
		$this->_render_template('hsnsac_master/edit', $this->data);
	}
	public function editHSNSAC_master(){
		$this->data['id'] = $this->input->post('id');	
		$this->data['hsn_master_data'] = $this->account_model->get_data_byId('hsn_sac_master','id',$this->input->post('id'));$this->load->view('hsnsac_master/edit', $this->data);
	}
	
	/*  Function to add/edit Lead */
	public function saveHSNSAC_master(){	 
		if ($this->input->post()) { 
		//pre($_POST);die();
			$required_fields = array('name');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}
			else{
				$data  = $this->input->post();	
				
				$data['created_by'] = $_SESSION['loggedInCompany']->id;
				$data['created_by_cid'] = $this->companyGroupId;
				$id = $data['id'];
				
			
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInCompany']->id;
					$success = $this->account_model->update_data('hsn_sac_master',$data, 'id', $id);	
					if ($success) {
                        $data['message'] = "HSN / SAC updated successfully";
                        logActivity('HSN / SAC Updated','hsn_sac_master',$id);
                        $this->session->set_flashdata('message', 'HSN / SAC Updated successfully');
					    redirect(base_url().'account/hsnsacmaster', 'refresh');
                    }
				}else{
					$id = $this->account_model->insert_tbl_data('hsn_sac_master',$data);					
					if ($id) {                        
                        logActivity('New HSN / SAC Created','hsn_sac_master',$id);
                        $this->session->set_flashdata('message', 'HSN / SAC  inserted successfully');
					    redirect(base_url().'account/hsnsacmaster', 'refresh');
                    }else{
						$this->session->set_flashdata('message', 'This HSN / SAC Name is Alrady Added');
					    redirect(base_url().'account/hsnsacmaster', 'refresh');
					}   				
				}
				
			}			
        }
	}
	
	public function deleteHSNSAC($id = ''){	
		if (!$id) {
           redirect('account/hsnsacmaster', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('hsn_sac_master','id',$id);
		if($result){
			logActivity('HSN / SAC Master Deleted','hsn_sac_master',$id);
			$this->session->set_flashdata('message', 'HSN / SAC Master Deleted Successfully');
			$result = array('msg' => 'HSN / SAC Master Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/hsnsacmaster');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}
	/*START  HSN MASTER CODE*/						
	/*START  Credit Note sale Return Functionality*/
	public function salereturnCN_create(){
		$this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Credit Note Sale Return', base_url() . 'Credit Note');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Credit Note Sale Return';
		$this->_render_template('creditNote/edit', $this->data);
		
	}
	
	public function viewsaleReturnCreditNote(){
		$this->load->library('pagination');
		$this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Credit Note', base_url() . 'Credit Note');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Create Credit Note';
		$created_id = $this->companyGroupId;
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2=" creditnote_tbl.id like '%".$search_string."%' or creditnote_tbl.name like '%".$search_string."%'";
		 redirect("account/viewsaleReturnCreditNote/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "creditnote_tbl.crditNoteNo like'%" . $_GET['search'] . "%' or creditnote_tbl.id like'%". $_GET['search']."%'";
			}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
      $where_row='(created_by_cid = "'.$created_id.'" AND saleReturn_CN_ornot = "0")';
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/viewsaleReturnCreditNote/";
			$config["total_rows"] = $this->account_model->num_rows('creditnote_tbl',$where_row,$where2);
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
	
			$this->data['creditNoteNo'] = $this->account_model->get_credit_debitDATA('creditnote_tbl',$created_id, $config["per_page"], $page,$where2,$order,$where_row);
			if(!empty($this->uri->segment(3))){
					$frt = (int)$this->uri->segment(3) - 1;
					$start= $frt * $config['per_page']+1;
				  }else{
				   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
				}
	   
			   if(!empty($this->uri->segment(3))){
				   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
			   }else{
				  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
			   }
				if($end>$config['total_rows']){
					$total=$config['total_rows'];	
				}else{
					$total=$end;		
				}
			$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
			$this->_render_template('creditNote/index', $this->data);
	}
	
	public function editSaleReturnCN_details(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['CrCNDtl'] = $this->account_model->get_data_byId('creditnote_tbl','id',$this->uri->segment(3));			
			$this->_render_template('creditNote/edit', $this->data);
			}	
		}	
	
	public function get_SaleReturnInvoice(){
		 if($_REQUEST['saleReturnInvoiceID'] && $_REQUEST['saleReturnInvoiceID'] != ''){
			$Invoice_data = $this->account_model->not_paid_InvoiceForReturn('invoice',array('id'=> $_REQUEST['saleReturnInvoiceID']));
			//pre($Invoice_data);die();
			$gstData['party_billing_state_id'] = $Invoice_data->gstin;
			$gstData['sale_company_state_id'] = $Invoice_data->sale_leger_gstin_no;
			
			 $productData = json_decode($Invoice_data->descr_of_goods);
			foreach($productData as $val){
			
				$basicAmt = $val->rate * $val->quantity;
				$material_name = getNameById('material',$val->material_id,'id');
				$uom_name = getNameById('uom',$val->UOM,'id');
				$html .='<div class="add_more_credit_note_row scend-tr mailing-box col-md-12" ><div class="item form-group col-md-2 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="hidden" class="itemName form-control"   name="material_id[]" value="'.$val->material_id.'"  ><input type="text" class="itemName form-control"  required="required" name="material_name[]" value="'.$material_name->material_name.'" readonly ></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="descr_of_goods[]"  class="form-control col-md-1 goods_descr_section" placeholder="Description Of Goods" value="'.$val->descr_of_goods.'" readonly></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="'.$val->hsnsac.'" ></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text"  required="required" name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event_crnote" placeholder="Quantity" value="'.$val->quantity.'"></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event_crnote" placeholder="Rate" value="'.$val->rate.'"><input type="hidden" name="basic_Amt[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="'.$basicAmt.'"></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax"   placeholder="Tax" value="'.$val->tax.'" readonly><input type="hidden" value="'.$val->added_tax_Row_val.'" name="added_tax_Row_val[]" ></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly value="'.$uom_name->uom_quantity.'"><input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly value="'.$val->UOM.'"></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="amount"   name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" readonly placeholder="Amount" value="'.$val->amount.'" ></div></div><button class="btn btn-danger remove_cradd_add_field" type="button"><i class="fa fa-minus"></i></button></div>';
			}
			echo json_encode(array('GSTDATA'=>$gstData,'htmldata'=>$html));
  			
	}
}
 
 
	public function saveSale_return_creditNote(){
		if ($this->input->post()) {
		//	pre($_POST);die();
			 $sec = strtotime( $_POST['date']);  
			 $add_Date = date ("Y-m-d H:i", $sec); 
			$usersWithViewPermissions = $this->account_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 31));
			$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i], 'tax' => $_POST['tax'][$i],'added_tax_Row_val'=> $_POST['added_tax_Row_val'][$i],'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i],'basic_Amt'=>$_POST['basic_Amt'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}
			
			
			$total_tax = $_POST['total_tax_IGST'] + $_POST['total_tax_SGST'] + $_POST['total_tax_CGST'];
			//$total_tax = number_format((float)$total_tax, 2, '.', '');
			$total_tax = floor($total_tax*100)/100;;
			
				$AmountToltal = count($_POST['subTotal_Amt']);
					if($AmountToltal >0){ 
							$arra = [];
							$j = 0;
						while($j < $AmountToltal) {	
								$jsonArrayObject1 = array('subtotal' =>$_POST['subTotal_Amt'],'total_tax' => $total_tax,'grand_total' => $_POST['grand_total']);
								$arra[$j] = $jsonArrayObject1;
								$j++;
							}
							$invoice_price_total_array = json_encode($arra);
						}else{
							$invoice_price_total_array = '';
						}
					
				
					
					$required_fields = array('crditNoteNo');	
					$is_valid = validate_fields($_POST, $required_fields);
					if (count($is_valid) > 0) {
						valid_fields($is_valid);				
					}else{
						$data  = $this->input->post();
						$id = $_POST['id'];
						$data['productDtl'] = $descr_of_goods_array;	
						$data['amountDtl'] = $invoice_price_total_array;	
						$data['IGST'] = $_POST['total_tax_IGST'];	
						$data['CGST'] = $_POST['total_tax_CGST'];	
						$data['SGST'] = $_POST['total_tax_SGST'];	
						$data['date'] = date("Y-m-d", strtotime($_POST['date']));
						$data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$data['created_by_cid'] = $this->companyGroupId;
			
				if($id && $id != ''){
						
						$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
						//pre($data);die();
						/* Transaction Table Update Code*/
						$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_REQUEST['customer_id'];
					$debit_data['credit_dtl'] = $_POST['subTotal_Amt'];
					$debit_data['type'] = 'creditnoteSaleReturn';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 1;
					$debit_data['add_date'] = $add_Date;
					$debit_data['cancel_restore'] = 1;
						$this->account_model->update_transaction_data_chk('transaction_dtl',$debit_data, 'type_id', $id, 'creditnoteSaleReturn',$_REQUEST['customer_id']);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['subTotal_Amt'];
					$credit_data['ledger_id'] = $_POST['ledgerID'];
					$credit_data['credit_dtl'] = '0';
					$credit_data['cancel_restore'] = 1;
					$credit_data['type'] = 'creditnoteSaleReturn';
					$credit_data['cancel_restore'] = 1;
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
				    //$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->update_transaction_data_chk('transaction_dtl',$credit_data, 'type_id', $id, 'creditnoteSaleReturn',$_POST['ledgerID']);
					
						if($_POST['total_tax_IGST'] != ''){
							$ledgerdataID = '1';
							$IGST_data['debit_dtl'] = '0';
							$IGST_data['ledger_id'] = '1';
							$IGST_data['cancel_restore'] = 1;
							$IGST_data['credit_dtl'] = $_POST['total_tax_IGST'];
							$IGST_data['type'] = 'creditnoteSaleReturn';
							$IGST_data['type_id'] = $id;
							$IGST_data['cancel_restore'] = 1;
							$IGST_data['add_date'] = $add_Date;
							$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$IGST_data['created_by_cid'] = $this->companyGroupId;
							$this->account_model->update_transaction_data_chk('transaction_dtl',$IGST_data, 'type_id', $id, 'creditnoteSaleReturn',$ledgerdataID);
						}
				
						if($_POST['total_tax_CGST'] !=''){
							$ledgerdataID = '2';
							$CGST_data['debit_dtl'] = '0';
							$CGST_data['cancel_restore'] = 1;
							$CGST_data['ledger_id'] = '2';
							$CGST_data['credit_dtl'] = $_POST['total_tax_CGST'];
							$CGST_data['type'] = 'creditnoteSaleReturn';
							$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$CGST_data['created_by_cid'] = $this->companyGroupId;
							$CGST_data['type_id'] = $id;
							$CGST_data['cancel_restore'] = 1;
							$CGST_data['add_date'] = $add_Date;
							$this->account_model->update_transaction_data_chk('transaction_dtl',$CGST_data, 'type_id', $id, 'creditnoteSaleReturn',$ledgerdataID);
						}
						
						if($_POST['total_tax_SGST'] != ''){
							$ledgerdataID = '3';
							$SGST_data['debit_dtl'] = '0';
							$SGST_data['ledger_id'] = '3';
							$SGST_data['cancel_restore'] = 1;
							$SGST_data['credit_dtl'] = $_POST['total_tax_SGST'];
							$SGST_data['type'] = 'creditnoteSaleReturn';
							$SGST_data['type_id'] = $id;
							$SGST_data['cancel_restore'] = 1;
							$SGST_data['add_date'] = $add_Date;
							$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$SGST_data['created_by_cid'] = $this->companyGroupId;
							$this->account_model->update_transaction_data_chk('transaction_dtl',$SGST_data, 'type_id', $id, 'creditnoteSaleReturn',$ledgerdataID);
						}
						/* Transaction Table Update Code*/
						$success = $this->account_model->update_data('creditnote_tbl',$data, 'id', $id);	
						if ($success) {
							$data['message'] = "Credit note Sale Return updated successfully";
							logActivity('Credit note Sale Return Updated','creditnote_tbl',$id);
							$this->session->set_flashdata('message', 'Credit note Sale Return Updated successfully');
							redirect(base_url().'account/viewsaleReturnCreditNote', 'refresh');
						}
					//$data['created_by_cid'] = $this->companyGroupId;
					}else{
						//pre($data);die();
						$id = $this->account_model->insert_tbl_data('creditnote_tbl',$data);

					/* Inventory Flow*/
					if(!empty($data) && $data['productDtl'] !=''){
						$inventoryFlowData = json_decode($data['productDtl']);
						$inventoryFlowDataArray = [];
						$inCount = 0;
						$closingblcn = 0;
						
						foreach($inventoryFlowData as $key => $item) {
							$getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' =>$item->material_id));
							foreach($getAddres as $loc1){
                                     $arr[] =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] , 'quantity' => $item->quantity , 'Qtyuom' => $item->UOM)));
                                     $rt++;
                                 }

                            	 $yu = getNameById_mat('mat_locations',$item->material_id,'material_name_id');
                                 $sum = 0;
                                 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}

                            $closingblcn = $sum + $item->quantity;
                            $inventoryFlowDataArray['current_location'] = $arr[$i];     
							$inventoryFlowDataArray['material_id'] =  $item->material_id;
							$inventoryFlowDataArray['material_in'] =  $item->quantity;
							$inventoryFlowDataArray['opening_blnc'] = $sum;
                            $inventoryFlowDataArray['closing_blnc'] = $closingblcn;
							$inventoryFlowDataArray['uom'] =  $item->UOM;
							$inventoryFlowDataArray['material_type_id'] =  $loc1['material_type_id'];

							$inventoryFlowDataArray['through'] =  'Credit note';
							$inventoryFlowDataArray['ref_id'] =  $id;
							$inventoryFlowDataArray['created_by'] =  $_SESSION['loggedInUser']->id;
							$inventoryFlowDataArray['created_by_cid'] =  $this->companyGroupId;

							$this->account_model->insert_tbl_data('inventory_flow',$inventoryFlowDataArray);
							#pre($item);		
							$inCount++;
							
							$getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' => $item->material_id));
						
						foreach ($getAddres as  $values) {
							if ($values['material_name_id'] == $item->material_id) {
								$updatedQty = $values['quantity'] + $item->quantity;
								$values['quantity'] = $updatedQty;
								$success = $this->account_model->update_single_field('mat_locations', $values, $item->material_id);
								break;
							}
							
						}
				}
						
				

					}
					/* Inventory Flow*/
					/* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_REQUEST['customer_id'];
					$debit_data['credit_dtl'] = $_POST['subTotal_Amt'];
					$debit_data['type'] = 'creditnoteSaleReturn';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['cancel_restore'] = 1;
					$debit_data['add_date'] = $add_Date;
						$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['subTotal_Amt'];
					$credit_data['ledger_id'] = $_POST['ledgerID'];
					$credit_data['credit_dtl'] = '0';
					$credit_data['cancel_restore'] = 1;
					$credit_data['type'] = 'creditnoteSaleReturn';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
				    //$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
					        if($_POST['total_tax_IGST'] != ''){
								$IGST_data['debit_dtl'] = '0';
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = $_POST['total_tax_IGST'];
								$IGST_data['type'] = 'creditnoteSaleReturn';
								$IGST_data['type_id'] = $id;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['cancel_restore'] = 1;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
							}
					
							if($_POST['total_tax_CGST'] !=''){
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = $_POST['total_tax_CGST'];
								$CGST_data['type'] = 'creditnoteSaleReturn';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								$CGST_data['type_id'] = $id;
								$CGST_data['cancel_restore'] = 1;
								$CGST_data['add_date'] = $add_Date;
								$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
							}
							
							if($_POST['total_tax_SGST'] != ''){
								$SGST_data['debit_dtl'] = '0';
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = $_POST['total_tax_SGST'];
								$SGST_data['type'] = 'creditnoteSaleReturn';
								$SGST_data['type_id'] = $id;
								$SGST_data['cancel_restore'] = 1;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
							}
							
							
					if ($id) {
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'New Credit Note Sale Return created' , 'message' => 'New Credit Note is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'','data_id' => '' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'New Credit Note Sale Return Created' , 'message' => 'New Credit Note is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'','data_id' => '','icon'=>'fa-shopping-cart'));
						}  
						
                        logActivity('Credit Note Created','creditnote_tbl',$id);
                        $this->session->set_flashdata('message', 'Credit Note Sale Return Details inserted successfully');
					    redirect(base_url().'account/viewsaleReturnCreditNote', 'refresh');
                    }
				}
			}
		}
	}
	
 public function deleteSaleReturnCN($id = ''){	
		if (!$id) {
           redirect('account/viewsaleReturnCreditNote', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('creditnote_tbl','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'creditnoteSaleReturn');
		if($result){
			logActivity('Credit Note Deleted','creditnote_tbl',$id);
			$this->session->set_flashdata('message', 'Credit Note  Deleted Successfully');
			$result = array('msg' => 'Credit Note Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/viewsaleReturnCreditNote');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}
	
	
	
 
 
	
	/*START  Credit Note Sale Return Functionality*/						
/*START  Credit Note  Functionality*/
public Function creditNote_create(){
	$this->load->helper('url');		
	$this->data['can_edit'] = edit_permissions();
	$this->data['can_delete'] = delete_permissions();
	$this->data['can_add'] = add_permissions();
	$this->breadcrumb->add('Credit Note', base_url() . 'Credit Note');
	$this->settings['breadcrumbs'] = $this->breadcrumb->output();
	$this->settings['pageTitle'] = 'Create Credit Note';
	$this->_render_template('creditNote/edit_creditNote', $this->data);
}


public function save_creditNote(){
	if ($this->input->post()) {
			
			$sec = strtotime( $_POST['date']);  
			$add_Date = date ("Y-m-d H:i", $sec); 
						
			$required_fields = array('crditNoteNo');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}else{
						$data  = $this->input->post();
						$id = $_POST['id'];
						$data['date'] = date("Y-m-d", strtotime($_POST['date']));
						$data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$data['created_by_cid'] = $this->companyGroupId;
			
				if($id && $id != ''){
						$data['date'] = date("Y-m-d", strtotime($_POST['date']));
						$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
						/* For Sale Ledger Details data*/
						$debit_data['debit_dtl'] = '0';
						$debit_data['ledger_id'] = $_REQUEST['customer_id'];
						$debit_data['credit_dtl'] = $_POST['creditAMt'];
						$debit_data['type'] = 'creditnote';
						$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$debit_data['created_by_cid'] = $this->companyGroupId;
						$debit_data['type_id'] = $id;
						$debit_data['add_date'] = $add_Date;
						$debit_data['cancel_restore'] = 1;
						$this->account_model->update_transaction_data_chk('transaction_dtl',$debit_data, 'type_id', $id, 'creditnote',$_REQUEST['customer_id']);
						/* For Sale Ledger Details data*/
						
						/* For Purchase Ledger Details data*/
						$credit_data['debit_dtl'] = $_POST['creditAMt'];
						$credit_data['ledger_id'] = $_POST['ledgerID'];
						$credit_data['credit_dtl'] = '0';
						$credit_data['type'] = 'creditnote';
						$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$credit_data['created_by_cid'] = $this->companyGroupId;
						//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$credit_data['type_id'] = $id;
						$credit_data['add_date'] = $add_Date;
						$credit_data['cancel_restore'] = 1;
						$this->account_model->update_transaction_data_chk('transaction_dtl',$credit_data, 'type_id', $id, 'creditnote',$_REQUEST['ledgerID']);
						
						$success = $this->account_model->update_data('creditnote_tbl',$data, 'id', $id);	
						if ($success) {
							$data['message'] = "Credit note Sale Return updated successfully";
							logActivity('Credit note Sale Return Updated','creditnote_tbl',$id);
							$this->session->set_flashdata('message', 'Credit note Sale Return Updated successfully');
							redirect(base_url().'account/creditNoteview', 'refresh');
						}
					}else{
						
						$id = $this->account_model->insert_tbl_data('creditnote_tbl',$data);

						/* For Sale Ledger Details data*/
						$debit_data['debit_dtl'] = '0';
						$debit_data['ledger_id'] = $_REQUEST['customer_id'];
						$debit_data['credit_dtl'] = $_POST['creditAMt'];
						$debit_data['type'] = 'creditnote';
						$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$debit_data['created_by_cid'] = $this->companyGroupId;
						$debit_data['type_id'] = $id;
						$debit_data['cancel_restore'] = 1;
						$debit_data['add_date'] = $add_Date;
							$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
						/* For Sale Ledger Details data*/
						
						/* For Purchase Ledger Details data*/
						$credit_data['debit_dtl'] = $_POST['creditAMt'];
						$credit_data['ledger_id'] = $_POST['ledgerID'];
						$credit_data['credit_dtl'] = '0';
						$credit_data['cancel_restore'] = 1;
						$credit_data['type'] = 'creditnote';
						$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$credit_data['created_by_cid'] = $this->companyGroupId;
						//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$credit_data['type_id'] = $id;
						$credit_data['add_date'] = $add_Date;
						$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
				if ($id) {
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'New Credit Note created' , 'message' => 'New Credit Note is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'','data_id' => '' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'New Credit Note Sale Return Created' , 'message' => 'New Credit Note is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'','data_id' => '','icon'=>'fa-shopping-cart'));
						}  
						
                        logActivity('Credit Note Created','creditnote_tbl',$id);
                        $this->session->set_flashdata('message', 'Credit Note Details inserted successfully');
					    redirect(base_url().'account/creditNoteview', 'refresh');
                    }
				}
			}
		}
	
}
Public function creditNoteview(){
	$this->load->library('pagination');
		$this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Credit Note', base_url() . 'Credit Note');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Create Credit Note';
		$created_id = $this->companyGroupId;
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2=" creditnote_tbl.id like '%".$search_string."%' or creditnote_tbl.name like '%".$search_string."%'";
		 redirect("account/creditNoteview/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "creditnote_tbl.crditNoteNo like'%" . $_GET['search'] . "%' or creditnote_tbl.id like'%". $_GET['search']."%'";
			}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
      $where_row='(created_by_cid = "'.$created_id.'" AND saleReturn_CN_ornot = "1")';
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/creditNoteview/";
			$config["total_rows"] = $this->account_model->num_rows('creditnote_tbl',$where_row,$where2);
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
	
			$this->data['creditNoteNo'] = $this->account_model->get_credit_debitDATA('creditnote_tbl',$created_id, $config["per_page"], $page,$where2,$order,$where_row);
			if(!empty($this->uri->segment(3))){
					$frt = (int)$this->uri->segment(3) - 1;
					$start= $frt * $config['per_page']+1;
				  }else{
				   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
				}
	   
			   if(!empty($this->uri->segment(3))){
				   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
			   }else{
				  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
			   }
				if($end>$config['total_rows']){
					$total=$config['total_rows'];	
				}else{
					$total=$end;		
				}
			$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
			$this->_render_template('creditNote/index_creditNote', $this->data);
	
}



public function editCreditNote_details(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['CrCNDtl'] = $this->account_model->get_data_byId('creditnote_tbl','id',$this->uri->segment(3));			
			$this->_render_template('creditNote/edit_creditNote', $this->data);
			}	
		}

public function deletecreditNote($id = ''){	
		if (!$id) {
           redirect('account/creditNoteview', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('creditnote_tbl','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'creditnote');
		if($result){
			logActivity('Credit Note Deleted','creditnote_tbl',$id);
			$this->session->set_flashdata('message', 'Credit Note  Deleted Successfully');
			$result = array('msg' => 'Credit Note Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/creditNoteview');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}

	public function crSaleReturn_view_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['CNSalereturn_detail'] = $this->account_model->get_data_byId('creditnote_tbl','id',$this->input->post('id'));			
			$this->load->view('creditNote/view', $this->data);
		}	
	}	

/*START  Credit Note  Functionality*/						
/*START  Debit Note  Functionality*/
	public Function purchasereturnDN_create(){
		$this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Debit Note', base_url() . 'Debit Note');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Create Debit Note';
		$this->_render_template('debitNote/edit', $this->data);
	}
	
	public function DRSaleReturn_view_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');	
			$this->data['DNSalereturn_detail'] = $this->account_model->get_data_byId('debitnote_tbl','id',$this->input->post('id'));			
			$this->load->view('debitNote/view', $this->data);
		}	
	}	
	
	public function get_PurchaseReturnBill(){
		 if($_REQUEST['purchaseReturnBillID'] && $_REQUEST['purchaseReturnBillID'] != ''){
			$purchase_data = $this->account_model->not_paid_InvoiceForReturn('purchase_bill',array('id'=> $_REQUEST['purchaseReturnBillID']));
			//pre($purchase_data);die();
			$gstData['sale_company_state_id'] = $purchase_data->purchase_gstin;
			$gstData['party_billing_state_id'] = $purchase_data->gstin;
			
			 $productData = json_decode($purchase_data->descr_of_bills);
			foreach($productData as $val){
				//pre($val);die();
			
				$basicAmt = $val->rate * $val->qty;
				$material_name = getNameById('material',$val->product_details,'id');
				$uom_name = getNameById('uom',$val->UOM,'id');
				$html .='<div class="add_more_credit_note_row scend-tr mailing-box col-md-12" ><div class="item form-group col-md-2 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="hidden" class="itemName form-control"   name="material_id[]" value="'.$val->product_details.'"  ><input type="text" class="itemName form-control"  required="required" name="material_name[]" value="'.$material_name->material_name.'" readonly ></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="descr_of_goods[]"  class="form-control col-md-1 goods_descr_section" placeholder="Description Of Goods" value="'.$val->descr_of_bills.'" readonly></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value="'.$val->hsnsac.'" ></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text"  required="required" name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event_crnote" placeholder="Quantity" value="'.$val->qty.'"></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event_crnote" placeholder="Rate" value="'.$val->rate.'"><input type="hidden" name="basic_Amt[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="'.$basicAmt.'"></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax"   placeholder="Tax" value="'.$val->tax.'" readonly><input type="hidden" value="'.$val->added_tax_Row_val.'" name="added_tax_Row_val[]" ></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly value="'.$uom_name->uom_quantity.'"><input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly value="'.$val->UOM.'"></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="amount"   name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" readonly placeholder="Amount" value="'.$val->amountwittax.'" ></div></div><button class="btn btn-danger remove_cradd_add_field" type="button"><i class="fa fa-minus"></i></button></div>';
			}
			echo json_encode(array('GSTDATA'=>$gstData,'htmldata'=>$html));
  			
	}
}



 public function savePurchase_return_DebitNote(){
		if ($this->input->post()) {
			//pre($_POST);die();
			 $sec = strtotime( $_POST['date']);  
			 $add_Date = date ("Y-m-d H:i", $sec); 
			$usersWithViewPermissions = $this->account_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 31));
			$descr_of_goodsLength = count($_POST['descr_of_goods']);
				if($descr_of_goodsLength >0){
					$arr = [];
					$i = 0;
					while($i < $descr_of_goodsLength) {	
						$jsonArrayObject = (array('material_id' =>$_POST['material_id'][$i],'descr_of_goods' => $_POST['descr_of_goods'][$i],'hsnsac' => $_POST['hsnsac'][$i], 'quantity' => $_POST['quantity'][$i], 'rate' => $_POST['rate'][$i], 'tax' => $_POST['tax'][$i],'added_tax_Row_val'=> $_POST['added_tax_Row_val'][$i],'UOM' => $_POST['UOM'][$i],'amount'=>$_POST['amount'][$i],'basic_Amt'=>$_POST['subtotal'][$i]));
						$arr[$i] = $jsonArrayObject;
						$i++;				
					}
					$descr_of_goods_array = json_encode($arr);
				}else{
					$descr_of_goods_array = '';
				}
			
			
			$total_tax = $_POST['total_tax_IGST'] + $_POST['total_tax_SGST'] + $_POST['total_tax_CGST'];
			//$total_tax = number_format((float)$total_tax, 2, '.', '');
			$total_tax = floor($total_tax*100)/100;;
			
				$AmountToltal = count($_POST['subTotal_Amt']);
					if($AmountToltal >0){ 
							$arra = [];
							$j = 0;
						while($j < $AmountToltal) {	
								$jsonArrayObject1 = array('subtotal' =>$_POST['subTotal_Amt'],'total_tax' => $total_tax,'grand_total' => $_POST['grand_total']);
								$arra[$j] = $jsonArrayObject1;
								$j++;
							}
							$invoice_price_total_array = json_encode($arra);
						}else{
							$invoice_price_total_array = '';
						}
					
				
					
					$required_fields = array('crditNoteNo');	
					$is_valid = validate_fields($_POST, $required_fields);
					if (count($is_valid) > 0) {
						valid_fields($is_valid);				
					}else{
						$data  = $this->input->post();
						$id = $_POST['id'];
						$data['productDtl'] = $descr_of_goods_array;	
						$data['amountDtl'] = $invoice_price_total_array;	
						$data['IGST'] = $_POST['total_tax_IGST'];	
						$data['CGST'] = $_POST['total_tax_CGST'];	
						$data['SGST'] = $_POST['total_tax_SGST'];	
						$data['date'] = date("Y-m-d", strtotime($_POST['date']));
						$data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$data['created_by_cid'] = $this->companyGroupId;
			
				if($id && $id != ''){
						
						$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
						/* Transaction Table update */
						
							$debit_data['debit_dtl'] = '0';
							$debit_data['ledger_id'] = $_REQUEST['supplier_id'];
							$debit_data['credit_dtl'] = $_POST['subTotal_Amt'];
							$debit_data['type'] = 'debitNotePurchaseReturn';
							$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$debit_data['created_by_cid'] = $this->companyGroupId;
							$debit_data['type_id'] = $id;
							$debit_data['add_date'] = $add_Date;
							$debit_data['cancel_restore'] = 1;
								
							$this->account_model->update_transaction_data_chk('transaction_dtl',$debit_data, 'type_id', $id, 'debitNotePurchaseReturn',$_REQUEST['supplier_id']);
							$credit_data['debit_dtl'] = $_POST['subTotal_Amt'];
							$credit_data['ledger_id'] = $_POST['buyerID'];
							$credit_data['credit_dtl'] = '0';
							$credit_data['type'] = 'debitNotePurchaseReturn';
							$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
							$credit_data['created_by_cid'] = $this->companyGroupId;
							$credit_data['cancel_restore'] = 1;
							//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
							$credit_data['type_id'] = $id;
							$credit_data['add_date'] = $add_Date;
							$this->account_model->update_transaction_data_chk('transaction_dtl',$credit_data, 'type_id', $id, 'debitNotePurchaseReturn',$_REQUEST['buyerID']);
							if($_POST['total_tax_IGST'] != ''){
								$ledgerdataID = '1';
								$IGST_data['debit_dtl'] = '0';
								$IGST_data['ledger_id'] = '1';
								$IGST_data['credit_dtl'] = $_POST['total_tax_IGST'];
								$IGST_data['type'] = 'debitNotePurchaseReturn';
								$IGST_data['type_id'] = $id;
								$IGST_data['cancel_restore'] = 1;
								$IGST_data['add_date'] = $add_Date;
								$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$IGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$IGST_data, 'type_id', $id, 'debitNotePurchaseReturn',$ledgerdataID);
							}
							
							if($_POST['total_tax_CGST'] !=''){
								$ledgerdataID = '2';
								$CGST_data['debit_dtl'] = '0';
								$CGST_data['ledger_id'] = '2';
								$CGST_data['credit_dtl'] = $_POST['total_tax_CGST'];
								$CGST_data['type'] = 'debitNotePurchaseReturn';
								$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$CGST_data['created_by_cid'] = $this->companyGroupId;
								$CGST_data['type_id'] = $id;
								$CGST_data['cancel_restore'] = 1;
								$CGST_data['add_date'] = $add_Date;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$CGST_data, 'type_id', $id, 'debitNotePurchaseReturn',$ledgerdataID);
							}
									
							if($_POST['total_tax_SGST'] != ''){
								$ledgerdataID = '3';
								$SGST_data['debit_dtl'] = '0';
								$SGST_data['ledger_id'] = '3';
								$SGST_data['credit_dtl'] = $_POST['total_tax_SGST'];
								$SGST_data['type'] = 'debitNotePurchaseReturn';
								$SGST_data['type_id'] = $id;
								$SGST_data['add_date'] = $add_Date;
								$SGST_data['cancel_restore'] = 1;
								$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
								$SGST_data['created_by_cid'] = $this->companyGroupId;
								$this->account_model->update_transaction_data_chk('transaction_dtl',$SGST_data, 'type_id', $id, 'debitNotePurchaseReturn',$ledgerdataID);
							}
						/* Transaction Table update */
						$success = $this->account_model->update_data('debitnote_tbl',$data, 'id', $id);	
						if ($success) {
							$data['message'] = "Debit note Purchase Return updated successfully";
							logActivity('Debit note Purchase Return Updated','debitnote_tbl',$id);
							$this->session->set_flashdata('message', 'Debit note Purchase Return Updated successfully');
							redirect(base_url().'account/viewPurchaseReturnDebitNote', 'refresh');
						}
					//$data['created_by_cid'] = $this->companyGroupId;
				}else{
					//echo 'hi';die();
				
						$id = $this->account_model->insert_tbl_data('debitnote_tbl',$data);

					/* Inventory Flow*/
					if(!empty($data) && $data['productDtl'] !=''){
						$inventoryFlowData = json_decode($data['productDtl']);
						$inventoryFlowDataArray = [];
						$inCount = 0;
						$closingblcn = 0;
						
						foreach($inventoryFlowData as $key => $item) {
							
							$getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' =>$item->material_id));
							foreach($getAddres as $loc1){
                                     $arr[] =  json_encode(array(array('location' => $loc1['location_id'],'Storage' => $loc1['Storage'] , 'RackNumber' => $loc1['RackNumber'] , 'quantity' => $item->quantity , 'Qtyuom' => $item->UOM)));
                                     $rt++;
                                 }

                            	 $yu = getNameById_mat('mat_locations',$item->material_id,'material_name_id');
                                 $sum = 0;
                                 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}

                            $closingblcn = $sum - $item->quantity;
                            $inventoryFlowDataArray['current_location'] = $arr[$i];     
							$inventoryFlowDataArray['material_id'] =  $item->material_id;
							$inventoryFlowDataArray['material_out'] =  $item->quantity;
							$inventoryFlowDataArray['opening_blnc'] = $sum;
                            $inventoryFlowDataArray['closing_blnc'] = $closingblcn;
							$inventoryFlowDataArray['uom'] =  $item->UOM;
							$inventoryFlowDataArray['material_type_id'] =  $loc1['material_type_id'];

							$inventoryFlowDataArray['through'] =  'Debit note';
							$inventoryFlowDataArray['ref_id'] =  $id;
							$inventoryFlowDataArray['created_by'] =  $_SESSION['loggedInUser']->id;
							$inventoryFlowDataArray['created_by_cid'] =  $this->companyGroupId;

							$this->account_model->insert_tbl_data('inventory_flow',$inventoryFlowDataArray);
							#pre($item);		
							$inCount++;
							
							$getAddres = $this->account_model->get_data('mat_locations', array('material_name_id' => $item->material_id));
						
						foreach ($getAddres as  $values) {
							if ($values['material_name_id'] == $item->material_id) {
								$updatedQty = $values['quantity'] - $item->quantity;
								$values['quantity'] = $updatedQty;
								$success = $this->account_model->update_single_field('mat_locations', $values, $item->material_id);
								break;
							}
							
						}
				}
						
				

					}
					/* Inventory Flow*/
					/* For Sale Ledger Details data*/
					$debit_data['debit_dtl'] = '0';
					$debit_data['ledger_id'] = $_REQUEST['supplier_id'];
					$debit_data['credit_dtl'] = $_POST['subTotal_Amt'];
					$debit_data['type'] = 'debitNotePurchaseReturn';
					$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $debit_data['created_by_cid'] = $this->companyGroupId;
					$debit_data['type_id'] = $id;
					$debit_data['add_date'] = $add_Date;
					$debit_data['cancel_restore'] = 1;
						$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
					/* For Sale Ledger Details data*/
					
					/* For Purchase Ledger Details data*/
					$credit_data['debit_dtl'] = $_POST['subTotal_Amt'];
					$credit_data['ledger_id'] = $_POST['buyerID'];
					$credit_data['credit_dtl'] = '0';
					$credit_data['type'] = 'debitNotePurchaseReturn';
					$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
				    $credit_data['created_by_cid'] = $this->companyGroupId;
				    //$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
					$credit_data['type_id'] = $id;
					$credit_data['add_date'] = $add_Date;
					$credit_data['cancel_restore'] = 1;
					$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
					if($_POST['total_tax_IGST'] != ''){
						$IGST_data['debit_dtl'] = '0';
						$IGST_data['ledger_id'] = '1';
						$IGST_data['credit_dtl'] = $_POST['total_tax_IGST'];
						$IGST_data['type'] = 'debitNotePurchaseReturn';
						$IGST_data['type_id'] = $id;
						$IGST_data['add_date'] = $add_Date;
						$IGST_data['cancel_restore'] = 1;
						$IGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$IGST_data['created_by_cid'] = $this->companyGroupId;
						$this->account_model->insert_tbl_data('transaction_dtl',$IGST_data);
					}
					
					if($_POST['total_tax_CGST'] !=''){
						$CGST_data['debit_dtl'] = '0';
						$CGST_data['ledger_id'] = '2';
						$CGST_data['credit_dtl'] = $_POST['total_tax_CGST'];
						$CGST_data['type'] = 'debitNotePurchaseReturn';
						$CGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$CGST_data['created_by_cid'] = $this->companyGroupId;
						$CGST_data['type_id'] = $id;
						$CGST_data['add_date'] = $add_Date;
						$CGST_data['cancel_restore'] = 1;
						$this->account_model->insert_tbl_data('transaction_dtl',$CGST_data);
					}
							
					if($_POST['total_tax_SGST'] != ''){
						$SGST_data['debit_dtl'] = '0';
						$SGST_data['ledger_id'] = '3';
						$SGST_data['credit_dtl'] = $_POST['total_tax_SGST'];
						$SGST_data['type'] = 'debitNotePurchaseReturn';
						$SGST_data['type_id'] = $id;
						$SGST_data['add_date'] = $add_Date;
						$SGST_data['cancel_restore'] = 1;
						$SGST_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$SGST_data['created_by_cid'] = $this->companyGroupId;
						$this->account_model->insert_tbl_data('transaction_dtl',$SGST_data);
					}
							
							
					if ($id) {
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'New Debit Note Purchase Return created' , 'message' => 'New Credit Note is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'','data_id' => '' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'New Debit Note Purchase Return Created' , 'message' => 'New Credit Note is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'','data_id' => '','icon'=>'fa-shopping-cart'));
						}  
						
                        logActivity('Debit Note Return Created','debitnote_tbl',$id);
                        $this->session->set_flashdata('message', 'Debit Note Purchase Return Details inserted successfully');
					    redirect(base_url().'account/viewPurchaseReturnDebitNote', 'refresh');
                    }
				}
			}
		}
	}
	
	
	
	public function viewPurchaseReturnDebitNote(){
		$this->load->library('pagination');
		$this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Debit Note Purchase Return', base_url() . 'Debit Note');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Debit Note Purchase Return';
		$created_id = $this->companyGroupId;
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2=" debitnote_tbl.id like '%".$search_string."%' or debitnote_tbl.name like '%".$search_string."%'";
		 redirect("account/viewPurchaseReturnDebitNote/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "debitnote_tbl.debitNoteNo like'%" . $_GET['search'] . "%' or debitnote_tbl.id like'%". $_GET['search']."%'";
			}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
      $where_row='(created_by_cid = "'.$created_id.'" AND PurchaseReturn_DN_ornot = "0")';
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/viewPurchaseReturnDebitNote/";
			$config["total_rows"] = $this->account_model->num_rows('debitnote_tbl',$where_row,$where2);
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
	
			$this->data['creditNoteNo'] = $this->account_model->get_credit_debitDATA('debitnote_tbl',$created_id, $config["per_page"], $page,$where2,$order,$where_row);
			if(!empty($this->uri->segment(3))){
					$frt = (int)$this->uri->segment(3) - 1;
					$start= $frt * $config['per_page']+1;
				  }else{
				   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
				}
	   
			   if(!empty($this->uri->segment(3))){
				   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
			   }else{
				  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
			   }
				if($end>$config['total_rows']){
					$total=$config['total_rows'];	
				}else{
					$total=$end;		
				}
			$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
			$this->_render_template('debitNote/index', $this->data);
	}
	
	
	public function editPurchaseReturnDN_details(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['DRDNDtl'] = $this->account_model->get_data_byId('debitnote_tbl','id',$this->uri->segment(3));			
			$this->_render_template('debitNote/edit', $this->data);
			}	
		}
		
		
	 public function deletePurchaseReturnDN($id = ''){	
		if (!$id) {
           redirect('account/viewPurchaseReturnDebitNote', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('debitnote_tbl','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'debitNotePurchaseReturn');
		if($result){
			logActivity('Debit Note Deleted','debitnote_tbl',$id);
			$this->session->set_flashdata('message', 'Debit Note  Deleted Successfully');
			$result = array('msg' => 'Debit Note Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/viewPurchaseReturnDebitNote');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}



	public Function debitNote_create(){
		$this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Debit Note', base_url() . 'Debit Note');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Create Debit Note';
		$this->_render_template('debitNote/edit_debitNote', $this->data);
	}

public function save_debitNote(){
	if ($this->input->post()) {
			
			$sec = strtotime( $_POST['date']);  
			$add_Date = date ("Y-m-d H:i", $sec); 
						
			$required_fields = array('crditNoteNo');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}else{
						$data  = $this->input->post();
						$id = $_POST['id'];
						$data['date'] = date("Y-m-d", strtotime($_POST['date']));
						$data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$data['created_by_cid'] = $this->companyGroupId;
			//pre($_POST);die();
				if($id && $id != ''){
						$data['date'] = date("Y-m-d", strtotime($_POST['date']));
						$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
						/* For Sale Ledger Details data*/
						$debit_data['debit_dtl'] = '0';
						$debit_data['ledger_id'] = $_REQUEST['supplier_id'];
						$debit_data['credit_dtl'] = $_POST['debitAMt'];
						$debit_data['type'] = 'debitNote';
						$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$debit_data['created_by_cid'] = $this->companyGroupId;
						$debit_data['type_id'] = $id;
						$debit_data['add_date'] = $add_Date;
						$debit_data['cancel_restore'] = 1;
					$this->account_model->update_transaction_data_chk('transaction_dtl',$debit_data, 'type_id', $id, 'debitNote',$_REQUEST['supplier_id']);
						/* For Sale Ledger Details data*/
						
						/* For Purchase Ledger Details data*/
						$credit_data['debit_dtl'] = $_POST['debitAMt'];
						$credit_data['ledger_id'] = $_POST['buyerID'];
						$credit_data['credit_dtl'] = '0';
						$credit_data['type'] = 'debitNote';
						$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$credit_data['created_by_cid'] = $this->companyGroupId;
						//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$credit_data['type_id'] = $id;
						$credit_data['cancel_restore'] = 1;
						$credit_data['add_date'] = $add_Date;
						$this->account_model->update_transaction_data_chk('transaction_dtl',$credit_data, 'type_id', $id, 'debitNote',$_REQUEST['buyerID']);
						$success = $this->account_model->update_data('debitnote_tbl',$data, 'id', $id);	
						if ($success) {
							$data['message'] = "Debit note  updated successfully";
							logActivity('Debit note Updated','debitnote_tbl',$id);
							$this->session->set_flashdata('message', 'Debit note Updated successfully');
							redirect(base_url().'account/debitNoteview', 'refresh');
						}
					}else{
						
						$id = $this->account_model->insert_tbl_data('debitnote_tbl',$data);

						/* For Sale Ledger Details data*/
						$debit_data['debit_dtl'] = '0';
						$debit_data['ledger_id'] = $_REQUEST['supplier_id'];
						$debit_data['credit_dtl'] = $_POST['debitAMt'];
						$debit_data['type'] = 'debitNote';
						$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$debit_data['created_by_cid'] = $this->companyGroupId;
						$debit_data['type_id'] = $id;
						$debit_data['add_date'] = $add_Date;
						$debit_data['cancel_restore'] = 1;
							$this->account_model->insert_tbl_data('transaction_dtl',$debit_data);
						/* For Sale Ledger Details data*/
						
						/* For Purchase Ledger Details data*/
						$credit_data['debit_dtl'] = $_POST['debitAMt'];
						$credit_data['ledger_id'] = $_POST['buyerID'];
						$credit_data['credit_dtl'] = '0';
						$credit_data['type'] = 'debitNote';
						$credit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
						$credit_data['created_by_cid'] = $this->companyGroupId;
						//$credit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
						$credit_data['type_id'] = $id;
						$credit_data['cancel_restore'] = 1;
						$credit_data['add_date'] = $add_Date;
						$this->account_model->insert_tbl_data('transaction_dtl',$credit_data);
				if ($id) {
						if(!empty($usersWithViewPermissions)){
							foreach($usersWithViewPermissions as $userViewPermission){
								if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
									pushNotification(array('subject'=> 'New Debit Note created' , 'message' => 'New Debit Note is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'] , 'ref_id'=> $id ,'class'=>'','data_id' => '' ,'icon'=>'fa-shopping-cart'));
								}
							}
						}	
						if($_SESSION['loggedInUser']->role !=1){
							pushNotification(array('subject'=> 'New Debit  Created' , 'message' => 'New Debit Note is created by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id  , 'ref_id'=> $id,'class'=>'','data_id' => '','icon'=>'fa-shopping-cart'));
						}  
						
                        logActivity('Debit Note Created','debitnote_tbl',$id);
                        $this->session->set_flashdata('message', 'Debit Note Details inserted successfully');
					    redirect(base_url().'account/debitNoteview', 'refresh');
                    }
				}
			}
		}
	}
	public function deletedebitNote($id = ''){	
		if (!$id) {
           redirect('account/debitNoteview', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('debitnote_tbl','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'debitNote');
		if($result){
			logActivity('Debit Note Deleted','debitnote_tbl',$id);
			$this->session->set_flashdata('message', 'Debit Note  Deleted Successfully');
			$result = array('msg' => 'Debit Note Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/debitNoteview');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}
	Public function debitNoteview(){
		$this->load->library('pagination');
		$this->load->helper('url');		
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Debit Note', base_url() . 'Debit Note');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Create Debit Note';
		$created_id = $this->companyGroupId;
		//Search
		$where2='';
		$search_string = '';
		if(!empty($_POST['search'])){
			$search_string = $_POST['search'];
			$where2=" debitnote_tbl.id like '%".$search_string."%' or debitnote_tbl.name like '%".$search_string."%'";
		 redirect("account/creditNoteview/?search=$search_string");
        }else if(isset($_GET['search'])){
				 $where2 = "debitnote_tbl.crditNoteNo like'%" . $_GET['search'] . "%' or debitnote_tbl.id like'%". $_GET['search']."%'";
			}
		if(!empty($_POST['order']))
		{
			$order=$_POST['order'];
		}else{
			$order="desc";
		}
      $where_row='(created_by_cid = "'.$created_id.'" AND PurchaseReturn_DN_ornot = "1")';
		//Pagination
		$config = array();
			$config["base_url"] = base_url() . "account/debitNoteview/";
			$config["total_rows"] = $this->account_model->num_rows('debitnote_tbl',$where_row,$where2);
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
	
			$this->data['creditNoteNo'] = $this->account_model->get_credit_debitDATA('debitnote_tbl',$created_id, $config["per_page"], $page,$where2,$order,$where_row);
			if(!empty($this->uri->segment(3))){
					$frt = (int)$this->uri->segment(3) - 1;
					$start= $frt * $config['per_page']+1;
				  }else{
				   $start= (int)$this->uri->segment(3) * $config['per_page']+1;
				}
	   
			   if(!empty($this->uri->segment(3))){
				   $end = ($this->uri->segment(3) == (floor($config['total_rows']/ $config['per_page'])+1))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page']; 
			   }else{
				  $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page']; 
			   }
				if($end>$config['total_rows']){
					$total=$config['total_rows'];	
				}else{
					$total=$end;		
				}
			$this->data['result_count']= '<span class="Dj"><span><span class="ts">'.$start.'</span>–<span class="ts">'.$total.'</span></span> of <span class="ts">'.$config['total_rows'].'</span>';
			$this->_render_template('debitNote/index_debitNote', $this->data);
	
}



	public function editdebitNote_details(){
		if($this->uri->segment(3)){
			$this->data['id'] = $this->uri->segment(3);
			$this->data['DRDNDtl'] = $this->account_model->get_data_byId('debitnote_tbl','id',$this->uri->segment(3));			
			$this->_render_template('debitNote/edit_debitNote', $this->data);
			}	
		}	
	 public function deletePurchasedebitNote($id = ''){	
		if (!$id) {
           redirect('account/debitNoteview', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->account_model->delete_data('debitnote_tbl','id',$id);
		$this->account_model->delete_transaction_data('transaction_dtl','type_id', $id, 'debitNotePurchaseReturn');
		if($result){
			logActivity('Debit Note Deleted','debitnote_tbl',$id);
			$this->session->set_flashdata('message', 'Debit Note  Deleted Successfully');
			$result = array('msg' => 'Debit Note Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'account/debitNoteview');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
        }
	}	

/*START  Debit Note  Functionality*/						
	
	public function add_salesPerson_during_invoice(){
		
		$salesPersonName = $_REQUEST['name'];
		$email = $_REQUEST['email'];
		$gender = $_REQUEST['gender'];
		$salesphone = $_REQUEST['salesphone'];
		$salesdesignation = $_REQUEST['salesdesignation'];
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		$created_by_cid  = $this->companyGroupId;
		
		$checkEmail = $this->account_model->emailExistUSER($data['email']);
		if($checkEmail == ''){
			 $password                = rand(100000000, 999999999);
			 $user['password']        = easy_crypt($password);
             $user['activation_code'] = md5(rand());
             $user['email_status']    = 'not verified';
             
             $user['email']            = $email;
             $user['role']            = 2;
             $user['status']          = 1;
             $user['company_db_name'] = $_SESSION['loggedInUser']->company_db_name;
             $user['business_status'] = 1;
             $user['c_id'] = $this->companyGroupId;
			
	
		//pre($data);die();
		$addedData = $this->account_model->insert_on_spot_tbl_data('user',$user);
		 $data['u_id'] = $addedData;
		 $data['name']            = $salesPersonName;
		 $data['designation']     = $salesdesignation;
		 $data['gender']          = $gender;
		 $data['contact_no']      = $salesphone;
		 $data['c_id'] = $this->companyGroupId;
		 //$data['u_id'] = $_SESSION['loggedInUser']->u_id;
		 $data['company_id'] = $this->companyGroupId;
         $insertedUserDetailId = $this->account_model->insert_on_spot_tbl_data('user_detail', $data);
		if($insertedUserDetailId > 0){
			echo 'true';
		}else{
			echo 'false';
		}
	}else{
		echo 'false';
	}	
		
	}	

    public function add_Charges_during_invoice(){
		
		$particular_charges = $_REQUEST['particular_charges'];
		$chargesledgerName = $_REQUEST['chargesledgerName'];
		$typecharges = $_REQUEST['typecharges'];
		$chargesFedas = $_REQUEST['chargesFedas'];
		$taxVal = $_REQUEST['taxVal'];
		$created_by_id  = $_SESSION['loggedInUser']->u_id;
		$created_by_cid  = $this->companyGroupId;
		
		$datat['particular_charges'] = $particular_charges;
		$datat['ledger_id'] = $chargesledgerName;
		$datat['type_charges'] = $typecharges;
		$datat['amount_of_charges'] = $chargesFedas;
		$datat['tax_slab'] = $taxVal;
		$datat['created_by_cid'] = $this->companyGroupId;
		$datat['created_by_uid'] = $_SESSION['loggedInUser']->u_id;
		
		$id = $this->account_model->insert_tbl_data('charges_lead',$datat);  

      	if($id > 0){
			echo 'true';
		}else{
			echo 'false';
		}
	
	}
	
	
	
	public function get_ledger_creditLimit(){
		$ledger_id = $_REQUEST['selected_partyID'];
		$currentAmt = $_REQUEST['currentAmt'];
		if($ledger_id != ''){

		$party_Limit_Dtls = getNameById('ledger',$ledger_id,'id');
			$party_amountDtls = $this->account_model->not_paid_InvoiceForLIMIT('invoice',array('party_name'=> $ledger_id));
			
			$total_amtInvoce = 0;
			foreach($party_amountDtls as $partyAmtdtls){
				$total_amtInvoce += $partyAmtdtls->total_amount;
			}
			$date_now = date("Y-m-d  00:00:00");
				if ($date_now > $party_Limit_Dtls->temp_crlimitDate) {
					$totalCreditAmt = $party_Limit_Dtls->purchaseLimit;
				}else{
					$totalCreditAmt = $party_Limit_Dtls->purchaseLimit + $party_Limit_Dtls->temp_credit_limit;
				}
				$TotalPurhaseAmt = $total_amtInvoce + $currentAmt;
				$totalcredit_Blance = $totalCreditAmt - $TotalPurhaseAmt;
				// pre($totalCreditAmt);
				// pre($totalcredit_Blance);
				// pre($TotalPurhaseAmt);
				if($totalCreditAmt < $totalcredit_Blance  || $totalcredit_Blance < 0  || $totalcredit_Blance == 0){
					 $data['limitexeed'] = abs($totalcredit_Blance);
					 $data['msg'] = 'true';
				}
				else if($totalCreditAmt > $totalcredit_Blance){ 
					 $data['limitnotexeed'] = abs($totalcredit_Blance);
					  $data['msg'] = 'false';
				}
				
		}else{
			 $data['empty'] =  'Please Select Party Name';
		}
		 echo json_encode($data);	
	
	}
	
	public function get_ledgerSaleAmtForTCS(){
		$ledger_idTDS = $_REQUEST['selected_partyIDTDS'];
		$currentAmtTDS = $_REQUEST['currentAmtTDS'];
		if($ledger_idTDS != ''){
			$party_Limit_Dtls = getNameById('ledger',$ledger_idTDS,'id');
			//pre($party_Limit_Dtls);die();
			/* For Financial Year*/
			$date_fun = $this->account_model->get_termconditions_details('company_detail','id',$this->companyGroupId);//Fetch Data to Company Table
			$date_fcal = json_decode($date_fun->financial_year_date,true);
				if(empty($date_fcal)){
						
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$first_date = date("Y-m-d", strtotime($mydate)); 
						$date = date(date('Y-03-31'));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date("Y-m-d", $second_date22); 
					} else {//After June 2015-2016
						 $mydate = date(date('Y-04-01'));
						//$lastyear = strtotime("-1 year", strtotime($mydate));
						 $first_date = date("Y-m-d", strtotime($mydate));
						 $date = date(date('Y-03-31'));
						 $second_date22 = strtotime("+1 year", strtotime($date));
						 $second_date = date("Y-m-d", $second_date22); 
					}
				}else{
					
					if (date('m') <= 4) {//Upto June 2014-2015
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date = date('Y-m-d', strtotime("$date"));
					} else {//After June 2015-2016
						$s_Date = date("Y-m-d", strtotime($date_fcal[0]['start']));
						$e_Date = date("Y-m-d", strtotime($date_fcal[0]['end']));
						$first_date = date(date($s_Date));
						$date = date(date($e_Date));
						$second_date22 = strtotime("+1 year", strtotime($date));
						$second_date = date('Y-m-d', $second_date22);
					}
				}
	/* For Financial Year*/
			$original_Date_start = $first_date;
			$cnvrted_newDate_Start = date("Y-m-d", strtotime($original_Date_start));
			$original_Date_end = $second_date;
			$cnvrted_newDate_end = date("Y-m-d", strtotime($original_Date_end));
			
			$where = "invoice.party_name=".$ledger_idTDS." AND invoice.created_by_cid = ".$this->companyGroupId." AND  (invoice.date_time_of_invoice_issue >='".$cnvrted_newDate_Start."' AND  invoice.date_time_of_invoice_issue <='".$cnvrted_newDate_end."')";
			
			//$party_amountDtlstds = $this->account_model->not_paid_InvoiceForLIMIT('invoice',array('party_name'=> $ledger_idTDS));
			$party_amountDtlstds = $this->account_model->not_paid_InvoiceForTDS('invoice',$where);
		
			$total_amt_not_paid_InvoceforTDS = 0;
			$total_amt_paid_InvoceforTDS = 0;
			foreach($party_amountDtlstds as $partyAmtdtlstds){
				if($partyAmtdtlstds->pay_or_not == 0){//Not PAid invoices
					$total_amt_not_paid_InvoceforTDS += $partyAmtdtlstds->total_amount;
				}elseif($partyAmtdtlstds->pay_or_not == 1){//Paid invoices
					$total_amt_paid_InvoceforTDS += $partyAmtdtlstds->total_amount;
				}
			}
			// $currentAnd_totalAmt = $currentAmtTDS + $total_amt_not_paid_InvoceforTDS;
			// if($currentAnd_totalAmt > 5000000  && $party_Limit_Dtls->tcs_onOff == 1){
			    // $forTdsCalc	= $currentAnd_totalAmt - 5000000;
				// $tdsAMT = $forTdsCalc*0.1/100;
				// $tdsAMT =	floor($tdsAMT*100)/100;;
				// echo $tdsAMT;
			// }elseif($total_amt_paid_InvoceforTDS >= 5000000 && $party_Limit_Dtls->tcs_onOff == 1){
				// $tdsAMT = $currentAmtTDS*0.1/100;
				// $tdsAMT =	floor($tdsAMT*100)/100;
				// echo $tdsAMT;
			// }
			if($party_Limit_Dtls->tcs_onOff == 1){
				$tdsAMT = $currentAmtTDS*0.1/100;
				$tdsAMT =	floor($tdsAMT*100)/100;;
				echo $tdsAMT;
			}
			// elseif($party_Limit_Dtls->tcs_onOff == 1){
				// $tdsAMT = $currentAmtTDS*0.1/100;
				// $tdsAMT =	floor($tdsAMT*100)/100;
				// echo $tdsAMT;
			// }
		}	
	}
	
	function get_CRMSale_order(){
		$orderID = $_REQUEST['id'];
		$dataval = $this->account_model->get_data('sale_order', array('id' => $orderID));
		pre($dataval);die();
	}
	
	
	public function delete_doccs($id = '', $docsId = '') {
        if (!$id) {
            redirect('account/purchase_bill', 'refresh');
        }
        $result = $this->account_model->delete_data('attachments', 'id', $id);
        if ($result) {
            logActivity('Deleted Successfully', 'Docs', $id);
            $this->session->set_flashdata('message', ' Deleted Successfully');
            // $result = array('msg' => 'Document Deleted Successfully', 'status' => 'success', 'code' => 'C174','url' => base_url() . 'purchase/suppliers/supplier_edit/'.$docsId);
            // echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
	
	public function get_so(){
		 if($_REQUEST['so_id'] && $_REQUEST['so_id'] != ''){
			$so_data = $this->account_model->get_so_details('sale_order',array('id'=> $_REQUEST['so_id'],'created_by_cid'=> $this->companyGroupId));
			$products = json_decode($so_data->product);
            if (!empty($products)) {
                $i = 0;
                $newProduct = array();
                foreach ($products as $product1) {
                    $ww = getNameById('uom', $product1->uom, 'id');
                    $material1 = getNameById('material', $product1->product, 'id');
                        $product1->uom_name = $ww->ugc_code;
                        $product1->mat_name = $material1->material_name;
                    $newProduct[$i] = $product1;
                    $i++;
                }
                echo json_encode($newProduct);
            }
			#die;
		}
	}	

	public function completeinvoice() {
        if ($_POST['id'] && $_POST['id'] != '') {
            #$data = array('complete_status' => $_POST['complete_status'] , 'completed_by' => $_POST['completed_by']);
            $result = $this->account_model->completeInvoice($_POST);
            if ($result) {
               
                $this->session->set_flashdata('message', 'Invoice compltely Successfullyc');
                $result = array('msg' => 'Invoice compltely', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'crm/invoices');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }		
}//main