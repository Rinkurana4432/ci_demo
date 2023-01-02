<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends ERP_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->library(array( 'form_validation'));
        $this->load->model('company_model');
		$this->load->helper('company/company');
		$this->settings['css'][] = 'assets/plugins/iCheck/skins/flat/green.css';
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->settings['css'][] = 'assets/plugins/ion.rangeSlider/css/ion.rangeSlider.css';
		$this->settings['css'][] = 'assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css';
		$this->settings['css'][] = 'assets/modules/company/css/style.css';
		$this->scripts['js'][] = 'assets/plugins/iCheck/icheck.min.js';
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->scripts['js'][] = 'assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js';
		$this->scripts['js'][] = 'assets/modules/home/js/slick.min.js';
		$this->scripts['js'][] = 'assets/modules/company/js/script.js';

		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
    }

    /* Main Function to fetch all the listing of departments */
    public function index() {
		$this->breadcrumb->add('Company', base_url() . 'company');
		$this->breadcrumb->add('Edit', base_url() . 'company');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Company';
		$this->data['company'] = $this->company_model->get_data('user');
		//pre($this->data['company']);
		$this->_render_template('index', $this->data);
    }

	 /* Main Function to fetch all the listing of departments */
    public function search() {
		is_login();
		$this->breadcrumb->add('Company', base_url() . 'company');
		$this->breadcrumb->add('Search', base_url() . 'company/search');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Search';
		$this->data['company'] = $this->company_model->get_data('user');
		//pre($this->data['company']);
		$this->_render_template('search', $this->data);
    }




	/*public function add(){
		$this->breadcrumb->add('Company', base_url() . 'company');
		$this->breadcrumb->add('Add', base_url() . 'company/add');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Company Add';
		$this->data['company']  = $this->company_model->get_data('company');
		$this->_render_template('edit', $this->data);
	}*/

	public function edit($id = ''){
		is_login();
		$this->breadcrumb->add('Company', base_url() . 'company/edit/'.$id);
		$this->breadcrumb->add('Edit', base_url() . 'company/edit');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Company Edit';
		$this->data['company'] = $this->company_model->get_data_by_key('user','id',$id);
		if(!empty($this->data['company'])){
			#$this->data['companyCertificate']  = $this->company_model->get_certificates_by_companyId('attachments', 'rel_id',$id);
			$this->data['companyCertificate']  = $this->company_model->get_certificates_by_companyId('attachments', 'rel_id',$this->data['company']->c_id);
		}
		$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','u_id',$this->data['company']->u_id);
		$totalFields = count(array_keys((array) $this->data['company'])) - 3;
		$nonEmptyFields = count(array_filter((array) $this->data['company'])) - 3;
		$this->data['profileComplete'] = round($nonEmptyFields * 100 / $totalFields);
		$this->data['country'] = $this->company_model->fetch_country();
		//$this->data['postCommentData'] = $this->company_model->getPosts($id);
		$this->data['postCommentData'] = $this->company_model->getPosts($this->data['company']->c_id);
		#$this->data['connections'] = connectedCompany($id);
		$this->data['connections'] = connectedCompany($id);
		#$this->data['products']  = $this->company_model->get_company_related_data('material', array('created_by_cid' => $id ));
		#$this->data['products']  = $this->company_model->get_company_related_data('material', array('created_by_cid' => $this->data['company']->c_id));
		#$this->data['products']  = $this->company_model->get_product_saleType('material', array('created_by_cid' => $this->data['company']->c_id ,'status'=>1,'sale_purchase'=> '["Sale"]'));
		$this->data['products']  = $this->company_model->get_product_saleType('material',  $this->data['company']->c_id);


		$this->data['employees'] = $this->company_model->get_user_by_cid('user_detail','c_id',$this->data['company']->c_id);
		$this->data['gallery'] = $this->company_model->getPosts($this->data['company']->c_id);
		//$this->data['company'] = $this->company_model->get_data_by_key('company_detail','id',$id);
		//pre($this->data['company']); die;
		//if(!empty($this->data['company']))
		//$this->data['products']  = $this->company_model->getProductsByCompanyId($this->data['company']->c_id);
		//$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','c_id',$id);
		//pre($this->data['connection']);

		//$this->_render_template('edit', $this->data);
		$this->_render_template('company_view', $this->data);
	}

	/*public function view($id = ''){
		if(is_company()){
			$this->data['company'] = $this->company_model->get_data_by_key('company','id',$id);
			$this->data['companyCertificate']  = $this->company_model->get_certificates_by_companyId('attachments', 'rel_id',$id);
		}
		$this->_render_template('view', $this->data);
	}*/




	public function company_view($id = ''){
		is_login();
		if($this->input->post()){
			permissions_redirect('is_view');
		}
		$this->data['profile'] = 'Profile Page';
		if($id == ''){
			$id = $_SESSION['loggedInUser']->id;
		}
		if($id != ''){
			$this->breadcrumb->add('Company', base_url() . 'company/view/'.$id);
			$this->breadcrumb->add('View', base_url() . 'company/view');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Company View';
			$this->data['company'] = $this->company_model->get_data_by_key('user','id',$id);
			if(!empty($this->data['company']))
			$this->data['products']  = $this->company_model->get_company_related_data('material', array('created_by_cid' => $id ));
			//$this->data['products']  = $this->company_model->getProductsByCompanyId($this->data['company']->c_id);
			$this->data['companyCertificate']  = $this->company_model->get_certificates_by_companyId('attachments', 'rel_id',$id);
			$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','u_id',$this->data['company']->u_id);
			//pre($this->data['users']);
			$this->data['employees'] = $this->company_model->get_user_by_cid('user_detail','c_id',$this->data['company']->c_id);
			//pre($this->data['employees']);
			$this->data['postCommentData'] = $this->company_model->getPosts($id);
			//pre($this->data['postCommentData']);
			$this->data['connections'] = connectedCompany();
			$this->_render_template('company/company_view', $this->data);
		}
	}


	public function view($id = ''){
		is_login();
		if($this->input->post()){
			permissions_redirect('is_view');
		}
		$this->data['profile'] = 'Profile Page';
		if($id == ''){
			$id = $_SESSION['loggedInUser']->id;
		}
		if($id != ''){
			$this->breadcrumb->add('Company', base_url() . 'company/view/'.$id);
			$this->breadcrumb->add('View', base_url() . 'company/view');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Company View';
			$this->data['company'] = $this->company_model->get_data_by_key('user','id',$id);
			if(!empty($this->data['company'])){
			$this->data['products']  = $this->company_model->get_product_saleType('material',  $this->data['company']->c_id);
			if(!empty($this->data['company'])){
				$this->data['companyCertificate']  = $this->company_model->get_certificates_by_companyId('attachments', 'rel_id',$this->data['company']->c_id);
			}
			$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','u_id',$this->data['company']->u_id);
			$totalFields = count(array_keys((array) $this->data['company'])) - 3;
			$nonEmptyFields = count(array_filter((array) $this->data['company'])) - 3;
			$this->data['profileComplete'] = round($nonEmptyFields * 100 / $totalFields);
			$this->data['country'] = $this->company_model->fetch_country();
			$this->data['employees'] = $this->company_model->get_user_by_cid('user_detail','c_id',$this->data['company']->c_id);
			$this->data['postCommentData'] = $this->company_model->getPosts($this->data['company']->c_id);
			$this->data['connections'] = connectedCompany($this->data['company']->c_id);
			$this->data['gallery'] = $this->company_model->getPosts($this->data['company']->c_id);
		}
			//$this->_render_template('company/view', $this->data);
			$this->_render_template('company/company_view', $this->data);
		}
	}


	// Company view profile without login
	public function view_profile($id = ''){
		if($this->input->post()){
			permissions_redirect('is_view');
		}
		$this->data['profile'] = 'Profile Page';
		if($id == ''){
			$id = $_SESSION['loggedInUser']->id;
		}
		if($id != ''){
			$this->breadcrumb->add('Company', base_url() . 'company/view/'.$id);
			$this->breadcrumb->add('View', base_url() . 'company/view');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Company View';
			#$this->data['company'] = $this->company_model->get_data_by_key('user','id',$id);
			$this->data['company'] = $this->company_model->get_data_by_key('user','c_id',$id);
			if(!empty($this->data['company'])){
			#$this->data['products']  = $this->company_model->get_product_saleType('material', array('created_by_cid' => $this->data['company']->c_id ,'status'=>1,'sale_purchase'=> '["Sale"]'));
			$this->data['products']  = $this->company_model->get_product_saleType('material',  $this->data['company']->c_id);
			#$this->data['products']  = $this->company_model->get_company_related_data('material', array('created_by_cid' => $id ));
			//$this->data['products']  = $this->company_model->getProductsByCompanyId($this->data['company']->c_id);
			//$this->data['products']  = $this->company_model->get_company_related_data('material', array('created_by_cid' => $this->data['company']->c_id ));
			$this->data['companyCertificate']  = $this->company_model->get_certificates_by_companyId('attachments', 'rel_id',$id);
			$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','u_id',$this->data['company']->u_id);
			$this->data['employees'] = $this->company_model->get_user_by_cid('user_detail','c_id',$this->data['company']->c_id);
			$this->data['postCommentData'] = $this->company_model->getPosts($id);
			$this->data['connections'] = connectedCompany($id);
			$this->data['gallery'] = $this->company_model->getPosts($this->data['company']->c_id);
		}
		$this->load->view('home/header');
		$this->load->view('company/view_profile', $this->data);
		$this->load->view('home/footer');
		}
	}


		# Function to edit Company Details
public function save(){
// pre($_POST);	die();
		is_login();
		if ($this->input->post()) {
			$required_fields = array('year_of_establish','description','no_of_employees','address','key_people');
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}
			else{
				$data  = $this->input->post();
				if(!empty($_FILES['logo']['name'])){
					$data['logo']=$this->uploadFile('logo');
				} else {
					$data['logo'] = $this->input->post('fileOldlogo');
				}
				$data['key_people'] = json_encode($data['key_people']);
				$addressLength = count($_POST['address']);
				if($addressLength >0){
					$addressArr = [];
					$i = 0;
					$idds = 1;
					while($i < $addressLength) {
						@$addressJsonArrayObject = array('add_id'=> $idds,'address' => $_POST['address'][$i], 'country' => $_POST['country'][$i], 'state' => $_POST['state'][$i], 'city' => $_POST['city'][$i] , 'postal_zipcode' => $_POST['postal_zipcode'][$i], 'company_gstin' => $_POST['company_gstin'][$i],'compny_branch_name'=>$_POST['compny_branch_name'][$i],'prefix_inv_num' => isset($_POST['prefix_inv_num'][$i])?$_POST['prefix_inv_num'][$i]:'');
						$addressArr[$i] = $addressJsonArrayObject;
						$i++;
						$idds++;
					}
					$address_array = json_encode($addressArr);
				}else{
					$address_array = '';
				}
				//pre($address_array); die;
				$data['address'] = $address_array;
				$id = $data['id'];
				$userId = $data['u_id'];
				if($id && $id != ''){
							if(!empty($_FILES['certification']['name']) && $_FILES['certification']['name'][0]!=''){
								$certificate_array = array();
								$certificateCount = count($_FILES['certification']['name']);
								for($i = 0; $i < $certificateCount; $i++){
									$filename     = $_FILES['certification']['name'][$i];
									$tmpname     = $_FILES['certification']['tmp_name'][$i];
									$type     = $_FILES['certification']['type'][$i];
									$error    = $_FILES['certification']['error'][$i];
									$size    = $_FILES['certification']['size'][$i];
									$exp=explode('.', $filename);
									$ext=end($exp);
									$newname=  $exp[0].'_'.time().".".$ext;
									$config['upload_path'] = 'assets/modules/company/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/company/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000';
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);
									move_uploaded_file($tmpname,"assets/modules/company/uploads/".$newname);
									$certificate_array[$i]['rel_id'] = $data['c_id'];
									$certificate_array[$i]['rel_type'] = 'company';
									$certificate_array[$i]['file_name'] = $newname;
									$certificate_array[$i]['file_type'] = $type;
								}
									if(!empty($certificate_array)){
									/* Insert file information into the database */
									$certificateAttachmentId = $this->company_model->insert_attachment_data('attachments', $certificate_array,'company/edit/'.$id);
									}
							}
							
						// $bankdetailsdata = getNameById('company_detail',$userId,'u_id');	

					// pre($bankdetailsdata);
					// pre($data);
					
					
					// die();
					$success = $this->company_model->update_data('company_detail',$data, 'u_id', $userId);
					if ($success) {
                        if(!empty($addressArr)){
							$branch_data = $this->company_model->get_data_company('company_address',array('company_address.created_by_cid' => $this->companyGroupId));
							// $this->company_model->get_data_company('company_address',$data, 'u_id', $userId);
							// $branch_data = get_location_settings_dtl('company_address',$_SESSION['loggedInUser']->c_id,'created_by_cid');
							

							//$branch_data = get_location_settings_dtl('location_settings',$_SESSION['loggedInUser']->c_id,'created_by_cid');
							$already_data = count($branch_data);
							$j = 0;
							$p = 0;
							$compny_branch_id = 1;
                            foreach($addressArr as $address){
								$locationSettingData = array(
									'location' => $address['address'],
									'company_unit' => $address['compny_branch_name'],
									'compny_branch_id' => $address['add_id'],
									'created_by_cid' => $_SESSION['loggedInUser']->c_id,
									'created_by' => $_SESSION['loggedInUser']->u_id,
								);
                                    /* $locationSettingData = array(
													'location' => $address['address'],
													'company_unit' => $address['compny_branch_name'],
                                                    'c_id' => $_SESSION['loggedInUser']->c_id,
                                                    'compny_branch_id' => $address['add_id'],
                                                    'created_by_cid' => $_SESSION['loggedInUser']->c_id,
                                                ); */
										/* Sale Ledger Add During add Branch*/
										$sale_ledger_name = $address['compny_branch_name'] . ' Sale Ledger';
										$address_sale_ledger_JsonArrayObject =	array('ID'=> $address['add_id'],'mailing_name' => $sale_ledger_name, 'mailing_address' => $address['address'],'mailing_country' => $address['country'][$p], 'mailing_state' => $address['state'],'mailing_city' => $address['city'],'mailing_pincode' => $address['postal_zipcode']);

										$sale_ledger_addressArr[$p] = $address_sale_ledger_JsonArrayObject;
										$saleledger_address_array = json_encode($sale_ledger_addressArr);
										$add_sale_ledger = array(
																'name' =>  $sale_ledger_name,
																'account_group_id' =>  7,
																'save_status' =>  1,
																'compny_branch_id' =>  $address['add_id'],
																'mailing_address' =>  $saleledger_address_array,
																'created_by_cid' => $_SESSION['loggedInUser']->c_id,
																'created_by' => $_SESSION['loggedInUser']->u_id,
															);

									/* Sale Ledger Add During add Branch*/
									if(empty($branch_data)){
											//$this->company_model->insert_tbl_data('location_settings',$locationSettingData);
											$this->company_model->insert_tbl_data('company_address',$locationSettingData);
											$this->company_model->insert_sale_ledger_data('ledger',$add_sale_ledger);
									}else if($already_data < $addressLength){
										if(++$j === $addressLength) {//To Get Last Added Array in Company branch
											//$this->company_model->insert_tbl_data('location_settings',$locationSettingData);
											$this->company_model->insert_tbl_data('company_address',$locationSettingData);
											$this->company_model->insert_sale_ledger_data('ledger',$add_sale_ledger);
										  }
									}else{
										//$this->company_model->update_data('location_settings',$locationSettingData, 'compny_branch_id', $compny_branch_id);
										$this->company_model->update_data('company_address',$locationSettingData, 'compny_branch_id', $compny_branch_id);
									}
							$compny_branch_id++;

						}
                        }
                        $data['message'] = "Company details updated successfully";
                        logActivity('Company details Updated','company_detail',$id);
						$companyUsers = $this->company_model->get_data('user', array('c_id' => $_SESSION['loggedInUser']->c_id, 'status'=> 1 ));
						// if(!empty($companyUsers)){
							// foreach($companyUsers as $companyUser){
								// if($companyUser['user_id'] != $_SESSION['loggedInUser']->u_id){
									// pushNotification(array('subject'=> 'Company profile updated' , 'message' => 'Company profile updated by admin', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $companyUser['user_id'], 'ref_id'=> $id));
								// }
							// }
						// }
						// if($_SESSION['loggedInUser']->role !=1){
							// pushNotification(array('subject'=> 'Company profile updated' , 'message' => 'Company profile updated by admin', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));
						// }
                        $this->session->set_flashdata('message', 'Company Details Updated successfully');
                        //redirect( base_url().'company/edit/'.$id, 'refresh');
						redirect( base_url().'company/view', 'refresh');
                    }
				}
			}
		}
	}

	# Function to upload file in folder
	public function uploadFile($fieldName) {
		is_login();
		$filename=$_FILES[$fieldName]['name'];
		$tmpname=$_FILES[$fieldName]['tmp_name'];
		$exp=explode('.', $filename);
		$ext=end($exp);
		$newname=  $exp[0].'_'.time().".".$ext;
		$config['upload_path'] = 'assets/modules/company/uploads/';
		$config['upload_url'] =  base_url().'assets/modules/company/uploads/';
		$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
		$config['max_size'] = '2000000';
		$config['file_name'] = $newname;
		$this->load->library('upload', $config);
		move_uploaded_file($tmpname,"assets/modules/company/uploads/".$newname);
		return $newname;
	}

	# Function to delete company certificates
	public function deleteCertificate($id = ''){
		is_login();
		if (!$id) {
           redirect('company', 'refresh');
        }
        $result = $this->company_model->delete_data('attachments','id',$id);
		if($result) {
			logActivity('Company Certificate Deleted','company',$id);
			$this->session->set_flashdata('message', 'Certificate Deleted Successfully');
			$result = array('msg' => 'Certificate Deleted Successfully', 'status' => 'success', 'code' => 'C174','url' => base_url() . 'company/edit/'.$_SESSION['loggedInUser']->id);
			echo json_encode($result);
			die;
        }
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
	}

	# Function to upload Cover photo of company
	public function saveCoverPhoto(){
		is_login();
		if ($this->input->post()) {
				//$data['id']  = $_POST['u_id'];
				if(!empty($_FILES['cover_photo']['name'])){
					$data['cover_photo']=$this->uploadFile('cover_photo');
				} else {
					$data['cover_photo'] = $this->input->post('fileOldCoverPhoto');
				}
				//$id = $data['id'];
				$user_id = $_POST['u_id'];

				if($user_id && $user_id != ''){
					//$success = $this->company_model->updateCoverPhoto('company_detail',$data, 'id', $id);
					$success = $this->company_model->updateCoverPhoto('company_detail',$data, 'u_id', $user_id);
					if ($success) {
						$msg = "Company details updated Successfully.";
						logActivity('Cover Photo Updated','company_detail',$user_id);
						$this->session->set_flashdata('message', $msg);
						redirect( base_url().'company/edit/'.$user_id, 'refresh');
					}
				}
		}
	}

	# Function to delete Cover photo of company
	public function deleteCoverPhoto($id = ''){
		is_login();
		if (!$id) {
           redirect('company', 'refresh');
        }
        $result = $this->company_model->deleteCoverPhoto($id);
		if($result){
			logActivity('Company Cover Photo Deleted','company',$id);
			$msg = 'Cover Photo Deleted Successfully.';
			$this->session->set_flashdata('message', $msg);
			#redirect( base_url().'company/edit/'.$id, 'refresh');
			$result = array('msg' => $msg, 'status' => 'success', 'code' => 'C174','url' => base_url() . 'company/edit/'.$id);
			echo json_encode($result);
        }else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
	}

	/*public function fetch_state(){
		if($this->input->post('country_id')){
		   echo $this->company_model->fetch_state($this->input->post('country_id'));
		}
	 }

	public function fetch_city(){
		if($this->input->post('state_id')){
			echo $this->company_model->fetch_city($this->input->post('state_id'));
	  }
	 }*/


	public function savePost(){

		is_login();
		if ($this->input->post()) {
			$required_fields = array('description');
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}
			else{
				$data  = $this->input->post();
				/*if(!empty($_FILES['image']['name'])){
					$data['image']=$this->uploadFile('image');
				} */
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$data['created_by'] = $_SESSION['loggedInUser']->id;
				//pre($data); die;
				$id = $this->company_model->insert_tbl_data('post',$data);
				if ($id) {
					$data['message'] = "Company post uploaded successfully";
					logActivity('Company post uploaded','company_post',$id);
					$this->session->set_flashdata('message', 'Company post uploaded successfully');
					//redirect( base_url().'company/edit/'.$_SESSION['loggedInUser']->c_id, 'refresh');
					redirect( base_url().'company/edit/'.$_SESSION['loggedInUser']->id, 'refresh');
				}

			}
		}
	 }

	 public function saveComment(){
		is_login();
		if ($this->input->post()) {
			$required_fields = array('comment');
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}
			else{
				$data  = $this->input->post();
				$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
				$id = $this->company_model->insert_tbl_data('comments',$data);
				if ($id) {
					$data['message'] = "Commented successfully";
					logActivity('Commented','post_comment',$id);
					$this->session->set_flashdata('message', 'Commented successfully');
					#redirect( base_url().'company/edit/'.$_SESSION['loggedInUser']->c_id, 'refresh');
					#die;
					if($data['commentFilter'] == 'newsFeed'){
						redirect( base_url().'company/news_feed', 'refresh');
					}else{
						redirect( base_url().'company/edit/'.$_SESSION['loggedInUser']->id, 'refresh');
					}
				}

			}
		}
	 }

	 public function searchCompanyList(){
		is_login();
		if(!empty($_POST)){
			$companyList = searchCompanyList($_POST['companyName']);
			$companyList = json_encode($companyList);
			echo $companyList;
		}
	 }

	/* public function getCompanyData(){
		if(!empty($_POST)){
			$company = $this->company_model->get_data_by_key('user','c_id',$_POST['companyId']);
			echo json_encode($company);
		}
	 }*/




	 public function getCompanyData(){
		is_login();
		if(!empty($_POST)){
			//$company = $this->company_model->get_data_by_key('user','c_id',$_POST['companyId']);
			//echo json_encode($company);
		//}

		//if($id != ''){
			//$this->breadcrumb->add('Company', base_url() . 'company/view/1');
			$this->breadcrumb->add('Company', base_url() . 'company/view/'.$_POST['companyId']);
			$this->breadcrumb->add('View', base_url() . 'company/view');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Company View';
			//$this->data['company'] = $this->company_model->get_data_by_key('user','id',1);
			$this->data['company'] = $this->company_model->get_data_by_key('user','c_id',$_POST['companyId']);
			if(!empty($this->data['company'])){
				#$this->data['products']  = $this->company_model->get_product_saleType('material', array('created_by_cid' => $this->data['company']->c_id ,'status'=>1,'sale_purchase'=> '["Sale"]'));
				$this->data['products']  = $this->company_model->get_product_saleType('material',  $this->data['company']->c_id);
			}
			#$this->data['products']  = $this->company_model->get_company_related_data('material', array('created_by_cid' => $this->data['company']->c_id ));
			//$this->data['products']  = $this->company_model->getProductsByCompanyId($this->data['company']->c_id);
			//$this->data['companyCertificate']  = $this->company_model->get_certificates_by_companyId('attachments', 'rel_id',1);
			$this->data['companyCertificate']  = $this->company_model->get_certificates_by_companyId('attachments', 'rel_id',$_POST['companyId']);
			$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','u_id',$this->data['company']->u_id);
			$this->data['employees'] = $this->company_model->get_user_by_cid('user_detail','c_id',$this->data['company']->c_id);
		//	$this->data['postCommentData'] = $this->company_model->getPosts(1);
			$this->data['postCommentData'] = $this->company_model->getPosts($_POST['companyId']);
			#$this->data['connection'] = $this->company_model->get_company_related_data('connection',array('requested_to' => $_POST['companyId'] , 'requested_by' => $_SESSION['loggedInUser']->c_id )); // Company is connected or not with searched company
			$this->data['connection'] = companyConnectionData($_POST['companyId'] , $_SESSION['loggedInUser']->c_id ); // Company is connected or not with searched company
			$this->data['connections'] = connectedCompany($_POST['companyId']); // List of Connected companies with searched company
			$this->data['gallery'] = $this->company_model->getPosts($this->data['company']->c_id);
			$this->data['profile'] = 'View Page';
			//$this->_render_template('company/view', $this->data);
			$this->load->view('company/view', $this->data);
		}



	 }

	 public function sendRequestForConnect(){
		is_login();
		if ($this->input->post()) {
			$data = $this->input->post();
			#$requestedByData = getNameById('user_detail',$data['requested_by'],'u_id');
			#$requestedToData = getNameById('user_detail',$data['requested_to'],'u_id');

			$requestedByData = getNameById('user_detail',$data['requested_by'],'c_id');
			$requestedToData = getNameById('user_detail',$data['requested_to'],'c_id');
			$requestedToEmail = getNameById('user',$requestedToData->u_id,'id')->email;


			$data['connection_activation_code'] = md5(rand());
			$id = $this->company_model->insert_tbl_data('connection',$data);
			if ($id) {

				$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
													<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
														<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$requestedToData->name.',</p>
														<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">'.$requestedByData->name.' wants to connect with you</p>
														<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">. If you want to connect than open this link and accept the connect - '.base_url().'company/verifyConnectionRequest/'.$data['connection_activation_code'].'</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>';

									send_mail($requestedToEmail ,'Request to connect' ,$email_message);


				$data['message'] = "Connection request sent successfully";
				logActivity('Request sent for connection','connection',$id);
				$this->session->set_flashdata('message', 'Request sent for connection');
				redirect( base_url().'company/search', 'refresh');
			}
		 }
	 }



	/* Function to accept the connection request*/
	public function verifyConnectionRequest(){
		is_login();
		if(!empty($_POST)){
			$connection_activation_code = $_POST['connection_activation_code'];
		}else{
			$connection_activation_code =  $this->uri->segment(3);
		}
		if(isset($connection_activation_code)){
			$rowResult = $this->company_model->get_company_related_data('connection',array('connection_activation_code'=>$connection_activation_code));
			if(!empty($rowResult)){
				$row = $rowResult[0];
				$id = $row['id'];
				$field = $row;
				$field['status'] = 1;
				if($row['status'] == 0){
					#$this->company_model->update_data('connection',$field,'id',$id);
					$this->company_model->verify_connection_update_data('connection',$field,'id',$id);
					$this->data['message'] = "You accepted connection request";
				}else{
					$this->data['message'] = "You already accepted the connection";
				}
			}else{
				$this->data['message'] = "Invalid Link";
			}
		}

		if(!empty($_POST)){
			echo $this->data['message'];
		}else{
			$this->load->view('verifyConnectionRequest', $this->data);
		}


	}


	 /* Main Function to fetch all the listing of departments */
    public function connection_request() {
		is_login();
		$this->breadcrumb->add('Company', base_url() . 'company');
		$this->breadcrumb->add('Connection Request', base_url() . 'company');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Connection Request';
		#$this->data['connection_request_received'] = $this->company_model->get_company_related_data('connection',array('requested_to' => $_SESSION['loggedInUser']->c_id));
		$this->data['connection_request_received'] = $this->company_model->get_company_related_data('connection',array('requested_to' => $_SESSION['loggedInUser']->c_id,'status'=>0));
		#$this->data['connection_request_sent'] = $this->company_model->get_company_related_data('connection',array('requested_by' => $_SESSION['loggedInUser']->c_id));
		$this->data['connection_request_sent'] = $this->company_model->get_company_related_data('connection',array('requested_by' => $_SESSION['loggedInUser']->c_id,'status'=>0));
		$this->data['connected_company'] = connectedCompany($_SESSION['loggedInUser']->c_id);
		//pre($this->data['connected_company']);die();
		//$allCompanyList = searchCompanyList();
		//pre($allCompanyList);
		$this->_render_template('connection_request', $this->data);
    }


	public function sendMessage(){
		is_login();
		if ($this->input->post()) {
			$required_fields = array('message');
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}
			else{
				$data  = $this->input->post();
				#pre($data); die;
				$id = $this->company_model->insert_tbl_data('message',$data);
				if ($id) {
					$data['message'] = "Message Sent successfully";
					logActivity('Message Sent','message',$id);
					$this->session->set_flashdata('message', 'Message Sent successfully');
					redirect( base_url().'company/search/', 'refresh');
				}
			}
		}
	 }

	 /* Main Function to send messages form message chnat modules */
    public function message() {

		is_login();
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Message', base_url() . 'message');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Message';
		//$data1['record'] = searchCompanyList();
		$data1['record'] = connectedCompany($_SESSION['loggedInUser']->c_id);
		$this->_render_template('inter_communication/dashboard/index', $data1);
		/* File upload code */
       if(isset($_FILES['userfile'])){
            $id = $this->uri->segment(3);
            $config['upload_path'] = './assets/modules/company/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|sql|xlsx|xls|ppt|pptx|php';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {

               # die();
               // redirect('inter_communication/dashboard/index/'.$id);
               redirect('company/message/'. $id);
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_ext = $data['upload_data']['file_ext'];
                if ($file_ext == '.docx' || $file_ext == '.doc' || $file_ext == '.pdf' || $file_ext == '.xls' || $file_ext == '.xlsx' || $file_ext == '.ppt' || $file_ext == '.php' || $file_ext == '.pptx'){
                    $is_image = '0';
                    $is_doc = '1';
                }else {
                    $is_image = '1';
                    $is_doc = '0';
                }
                $chat_id = $this->uri->segment(3);
                $user_id = $this->session->userdata('user_id');
                $content = $data['upload_data']['file_name'];
                $data = [
                    'chat_id' => $chat_id,
                    'user_id' => $user_id,
                    'content' => $content,
                    'is_image' => $is_image,
                    'is_doc' => $is_doc,
                    'messaged_by' => $_SESSION['loggedInUser']->u_id
                ];
                $this->db->insert('inter_comm_chats_messages', $data);
               // redirect('inter_communication/dashboard/index/'.$chat_id);
               // redirect('inter_communication/dashboard/index/'.$chat_id);
				redirect('company/message/'. $id);
            }
        }
		elseif (isset($_POST['submit_video'])) {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            /* Activate video call */
            $this->view_data['video'] = 1;
            $this->view_data['audio'] = $this->session->userdata('audio');
            $this->session->set_userdata(['video' => 1]);
            $this->chat_component($chat_id);
        } elseif (isset($_POST['submit_audio'])) {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            /* Activate video call */
            $this->view_data['video'] = $this->session->userdata('video');
            $this->view_data['audio'] = 1;
            $this->session->set_userdata(['audio' => 1]);
            $this->chat_component($chat_id);
        } elseif (isset($_POST['submit_close_audio'])) {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            /* Activate video call */
            $this->session->unset_userdata('audio');
            $this->view_data['video'] = $this->session->userdata('video');
            $this->view_data['audio'] = 0;
            $this->chat_component($chat_id);
        } elseif (isset($_POST['submit_close_video'])) {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            /* Activate video call */
            $this->session->unset_userdata('video');
            $this->view_data['video'] = 0;
            $this->view_data['audio'] = $this->session->userdata('audio');
            $this->chat_component($chat_id);
        } else {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            $this->view_data['audio'] = $this->session->userdata('audio');
            $this->view_data['video'] = $this->session->userdata('video');
            $this->chat_component($chat_id);
        }
    }



    /* Call this method within index method */
    public function chat_component($chat_id){
		is_login();
        /* Get the array of data of chat_id from model */
        $this->view_data['chat_data'] = $this->company_model->get_company_related_data('inter_comm_chats', array('id' => $chat_id) , 'oneRecord');
        /* Send in chat_id and user_id */
        $this->view_data['chat_id'] = $chat_id;
        $this->view_data['user_id'] = $this->session->userdata('user_id');
        $this->session->set_userdata('last_chat_message_id_' . $this->view_data['chat_id'], 0);
    }


	    /*** Redirect method */
    public function redirect(){
		is_login();
        $first_id = $this->uri->segment(3);
        $second_id = $this->uri->segment(4);
        $third_id = $this->uri->segment(5);

        $this->session->set_userdata('target_id', $second_id);
        $result = $this->company_model->locate($first_id, $second_id);
        if ($result == 1) {
			if($third_id != ''){
				redirect('company/non_connected_message/'. $this->session->userdata('chat_id'));
			}else{
				redirect('company/message/'. $this->session->userdata('chat_id'));
			}

        } else {
            /* Create the chatroom between two id */
            //$chat = $this->company_model->create($first_id, $second_id);
			$data['topic'] =  $first_id .$second_id;
            $chat = $this->company_model->insert_tbl_data('inter_comm_chats',$data);
            if ($chat == 1) {
                $topic = $first_id . $second_id;
                $chat = $this->company_model->get_company_related_data('inter_comm_chats', array('topic' => $topic) , 'oneRecord');
                /* Data to be inserted to uri_segments table */
                $data['first'] = $first_id;
                $data['second'] = $second_id;
                $data['chat_id'] = $chat['id'];
                //$segment = $this->company_model->createSegment($data);
                $segment = $this->company_model->insert_tbl_data('inter_comm_uri_segments',$data);
                if ($segment == 1) {
					if($third_id != ''){
						redirect('company/non_connected_message/'. $data['chat_id']);
					}else{
						redirect('company/message/'. $data['chat_id']);
					}


                } else {
                    echo "Error!!!";
                    die();
                }
            }
            /* Create the uri segment for locate method */
           // $this->company_model->createSegment();
            $this->company_model->insert_tbl_data('inter_comm_uri_segments');
        }
    }

	    /**  Ajax Add Chat Message */
    public function ajax_add_chat_message(){
		is_login();
		/* Posted Data  */
		$data = $this->input->post();
		$data['messaged_by'] = $_SESSION['loggedInUser']->u_id;
        $this->company_model->insert_tbl_data('inter_comm_chats_messages', $data);
        /* Executing the method on model */
        echo $this->_get_chats_messages($chat_id);
	}

	public function insert_file_chat_message(){
		is_login();
		/* Posted Data  */
		$data = $this->input->post();
        $this->company_model->insert_tbl_data('inter_comm_chats_messages', $data);
        /* Executing the method on model */
        echo $this->_get_chats_messages($chat_id);
	}


    public function ajax_get_chats_messages(){
		is_login();
        /* Posting */
       $chat_id = $this->input->post('chat_id');
       echo $this->_get_chats_messages($chat_id);
    }

    /**
     * Ajax Get Chat Message
     * @return array
     */
    public function _get_chats_messages($chat_id){
		is_login();
        $last_chat_message_id = (int) $this->session->userdata('last_chat_message_id_' . $chat_id);
        /* Executing the method on model */
        $chats_messages = $this->company_model->get_chats_messages($chat_id, $last_chat_message_id);
//pre( $chats_messages);
        if ($chats_messages->num_rows() > 0) {
            $base_url = base_url();
            /* Store the last chat message id */
           $last_chat_message_id = $chats_messages->row($chats_messages->num_rows() - 1)->id;
            $this->session->set_userdata('last_chat_message_id_' . $chat_id, $last_chat_message_id);
            // return the messages

            $chats_messages_html = '<ul class="list-unstyled msg_list">';
            foreach ($chats_messages->result() as $chats_messages) {
				$record = $this->db->get_where('user_detail', ['u_id' => $chats_messages->messaged_by])->row_array();
                $avatar = $record['user_profile'];
				$li_class = ($_SESSION['loggedInUser']->c_id == $chats_messages->user_id) ?'class="text-right"' : '';
                $image_class = ($_SESSION['loggedInUser']->c_id == $chats_messages->user_id) ?'image-reply' : 'image';
                $a_class = ($_SESSION['loggedInUser']->c_id == $chats_messages->user_id) ?'col-lg-6 col-md-6 col-md-offset-6 col-sm-12 col-xs-12':'';
				$li_style = ($_SESSION['loggedInUser']->c_id == $chats_messages->user_id) ?' style="float:left;"' : ' style="margin-left:50%"';
                if ($chats_messages->is_image == '0') {
                    if ($chats_messages->is_doc == '1') {
                        $chats_messages_html .=
                        '<li ' . $li_style .'>'
							.'<a class="'.$a_class.'"><span class="' . $image_class .'"><img src="'.base_url().'assets/modules/users/uploads/'.$avatar.'" alt="" class="img-responsive"></span>'
							.'<span><i class="fa fa-circle red"></i>&nbsp;'.$chats_messages->messaged_by_name.'</span> ' . $chats_messages->timestamp .'</span>'
							.'<span class="message">'.$chats_messages->content.'</span>'
							.'</a></li>';
                    } else {
						 $chats_messages_html .=
						 '<li ' . $li_class .'>'
							.'<a class="'.$a_class.'"><span class="' . $image_class .'"><img src="'.base_url().'assets/modules/users/uploads/'.$avatar.'" alt="" class="img-responsive"></span>'
							.'<span><i class="fa fa-circle red"></i>&nbsp;'.$chats_messages->messaged_by_name.'</span> ' . $chats_messages->timestamp .'</span>'
							.'<span class="message">'.$chats_messages->content.'</span>'
							.'</a></li>';
                    }
                } else {
                    $chats_messages_html .=
					'<li ' . $li_style.'>'
							.'<a class="'.$a_class.'"><span class="' . $image_class .'"><img src="'.base_url().'assets/modules/users/uploads/'.$avatar.'" alt="" class="img-responsive"></span>'
							.'<span><i class="fa fa-circle red"></i>&nbsp;'.$chats_messages->messaged_by_name.'</span> ' . $chats_messages->timestamp .'</span>'
							.'<img src="'.base_url().'assets/modules/company/uploads/'.$chats_messages->content.'" width="100" height="100" />'
							.'</a></li>';
                }
            }

            $chats_messages_html .= "</ul>";
            $result = [
                'status'    => 'ok',
                'content'   => $chats_messages_html,
                'last_chat_message_id' => $last_chat_message_id
            ];
            return json_encode($result);
            exit();
        } else {
            $result = [
                'status'    => 'ok',
                'content'   => '',
                'last_chat_message_id' => $last_chat_message_id
            ];
            return json_encode($result);
            exit();
        }
    }



		 /* Main Function to fetch all the listing of departments */
    public function non_connected_message() {
		is_login();
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Message', base_url() . 'message');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Message';
		//$data1['record'] = searchCompanyList();
		$data1['connectedCompanyRecord'] = connectedCompany($_SESSION['loggedInUser']->c_id);
		#pre($data1['connectedCompanyRecord']);
		$connectedCompanyId = '';
		foreach($data1['connectedCompanyRecord'] as $connectedComp){
			$connectedCompanyId .= $connectedComp['id'].',';
		}
		$connectedCompanyId =	rtrim($connectedCompanyId,',');
		#pre($connectedCompanyId); die;
		$data1['record'] = nonConnectedCompany($connectedCompanyId);
		#pre($data1['record']); die;
		$data1['chkNonConnect'] = 'Non_connected_company';
		$this->_render_template('inter_communication/dashboard/index', $data1);
		/* File upload code */
       if(isset($_FILES['userfile'])){
            $id = $this->uri->segment(3);
            $config['upload_path'] = './assets/modules/company/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|sql|xlsx|xls|ppt|pptx|php';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                die();
               // redirect('inter_communication/dashboard/index/'.$id);
               //redirect('company/message/'. $id);
               redirect('company/non_connected_message/'. $id);
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_ext = $data['upload_data']['file_ext'];
                if ($file_ext == '.docx' || $file_ext == '.doc' || $file_ext == '.pdf' || $file_ext == '.xls' || $file_ext == '.xlsx' || $file_ext == '.ppt' || $file_ext == '.php' || $file_ext == '.pptx'){
                    $is_image = '0';
                    $is_doc = '1';
                }else {
                    $is_image = '1';
                    $is_doc = '0';
                }
                $chat_id = $this->uri->segment(3);
                $user_id = $this->session->userdata('user_id');
                $content = $data['upload_data']['file_name'];
                $data = [
                    'chat_id' => $chat_id,
                    'user_id' => $user_id,
                    'content' => $content,
                    'is_image' => $is_image,
                    'is_doc' => $is_doc,
                    'messaged_by' => $_SESSION['loggedInUser']->u_id
                ];
                $this->db->insert('inter_comm_chats_messages', $data);
               // redirect('inter_communication/dashboard/index/'.$chat_id);
               // redirect('inter_communication/dashboard/index/'.$chat_id);
		//redirect('company/message/'. $id);
		redirect('company/non_connected_message/'. $id);
            }
        }
		elseif (isset($_POST['submit_video'])) {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            /* Activate video call */
            $this->view_data['video'] = 1;
            $this->view_data['audio'] = $this->session->userdata('audio');
            $this->session->set_userdata(['video' => 1]);
            $this->chat_component($chat_id);
        } elseif (isset($_POST['submit_audio'])) {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            /* Activate video call */
            $this->view_data['video'] = $this->session->userdata('video');
            $this->view_data['audio'] = 1;
            $this->session->set_userdata(['audio' => 1]);
            $this->chat_component($chat_id);
        } elseif (isset($_POST['submit_close_audio'])) {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            /* Activate video call */
            $this->session->unset_userdata('audio');
            $this->view_data['video'] = $this->session->userdata('video');
            $this->view_data['audio'] = 0;
            $this->chat_component($chat_id);
        } elseif (isset($_POST['submit_close_video'])) {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            /* Activate video call */
            $this->session->unset_userdata('video');
            $this->view_data['video'] = 0;
            $this->view_data['audio'] = $this->session->userdata('audio');
            $this->chat_component($chat_id);
        } else {
            /* If the chat_id on the uri segment 3 is blank */
            if (empty($chat_id = $this->uri->segment(3))) {
                $chat_id = $this->uri->segment(2);
            }
            $this->view_data['audio'] = $this->session->userdata('audio');
            $this->view_data['video'] = $this->session->userdata('video');
            $this->chat_component($chat_id);
        }
    }


	public function getInsertedChatId(){
		is_login();
		$first_id = $this->uri->segment(3);
        $second_id = $this->uri->segment(4);
		$topic = $first_id . $second_id;
		$chat = $this->company_model->get_company_related_data('inter_comm_chats', array('topic' => $topic) , 'oneRecord');
		if(empty($chat)){
			$topic = $second_id.$first_id ;
			$chat = $this->company_model->get_company_related_data('inter_comm_chats', array('topic' => $topic) , 'oneRecord');
		}
		echo $chat['id'];
	}

	/*--------------------Connected Company News Feed ------------------------------------*/
	public function news_feed(){
		is_login();
		if($this->input->post()){
			permissions_redirect('is_view');
		}
		$user_id = $_SESSION['loggedInUser']->id;

		if($user_id != ''){
			$this->breadcrumb->add('Company', base_url() . 'company/view/'.$user_id);
			$this->breadcrumb->add('News Feed', base_url() . 'company/news_feed');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Company View';
			$this->data['company'] = $this->company_model->get_data_by_key('user','id',$user_id);
			if(!empty($this->data['company'])){
				$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','u_id',$this->data['company']->u_id);
				$this->data['connections'] = connectedCompany($this->data['company']->c_id);
				$connectedCompanyId = '';
				foreach($this->data['connections'] as $connectedComp){
					$connectedCompanyId .= $connectedComp['id'].',';
				}
				$connectedCompanyId =	rtrim($connectedCompanyId,',');
				#$this->data['postCommentData'] = $this->company_model->getPosts($this->data['company']->c_id);
				$this->data['postCommentData'] = $this->company_model->getPosts($connectedCompanyId );



				//pre($this->data['connections']);
			//	$this->data['gallery'] = $this->company_model->getPosts($this->data['company']->c_id);
			}
		}
			$this->_render_template('news_feed', $this->data);
	}




	/***********************************************************************upload image in news feed***********************************************************/
	public function uploadPostImageByAjax(){
		if(isset($_POST["img"])){
			//pre($_POST["img"]);die;
			//pre($_POST['company_id']);die;
		    //pre($_POST["company_id"]); die;
			$data_post = $_POST["img"];
			//pre($data_post); die;
			$image_array = explode(";", $data_post);
			$image_array1 = explode(",", $image_array[1]);
			$data_post = base64_decode($image_array1[1]);
			$exp1=explode('.', $_POST["uploaded_post_image_name"]);

			$activityUserData = getNameById('user_detail',$_POST["userid"],'u_id');
			//pre($activityUserData);die;
			$nameChar1 = substr($activityUserData->name, 0, 3);
			//$oldImage = $activityUserData->logo;

			$imageName1 = $exp1[0].'postImage'.$nameChar1.'_'.time().".".$exp1[1];
			//pre($imageName1);
			file_put_contents('assets/modules/company/uploads/'.$imageName1, $data_post);
			//$success = $this->company_model->updateLogo('company_detail',array('logo'=>$imageName), 'u_id', $_POST["user_id"]);
			//$success = $this->company_model->insertImage('post',array('image'=>$imageName  , 'created_by'=> $_POST["user_id"]));
			//pre($success);
			/*if($oldImage != ''){
				unlink('assets/modules/users/uploads/'.$oldImage);
			}*/
			$result1 = array('image' => $imageName1,'imageHtml'=>'<img src="'.base_url().'assets/modules/company/uploads/'.$imageName1.'" class="img-thumbnail" height="100px" width="100px" />');
			//pre($result1);die;
			echo json_encode($result1);
		}
	}

	/***********************************************************************upload image company logo***********************************************************/
	public function uploadImageByAjax(){
		if(isset($_POST["image"])){
			//pre($_POST["image"]);die;
		    //pre($_POST["company_id"]); die;
			$data = $_POST["image"];
			$image_array_1 = explode(";", $data);
			$image_array_2 = explode(",", $image_array_1[1]);
			$data = base64_decode($image_array_2[1]);
			$exp=explode('.', $_POST["uploaded_image_name"]);
			//pre($exp) ; die;
			$activityUserData = getNameById('company_detail',$_POST["user_id"],'u_id');
			//pre($activityUserData);die;
			$nameChar = substr($activityUserData->name, 0, 3);
			$oldImage = $activityUserData->logo;
			//pre($oldImage);die;
			$imageName = $exp[0].'company'.$nameChar.'_'.time().".".$exp[1];
			//pre($imageName);
			file_put_contents('assets/modules/company/uploads/'.$imageName, $data);
			$success = $this->company_model->updateLogo('company_detail',array('logo'=>$imageName), 'u_id', $_POST["user_id"]);
			//$success = $this->company_model->insertImage('post',array('image'=>$imageName  , 'created_by'=> $_POST["user_id"]));
			//pre($success);
			if($oldImage != ''){
				unlink('assets/modules/company/uploads/'.$oldImage);
			}
			$result = array('image' => $imageName,'imageHtml'=>'<img src="'.base_url().'assets/modules/company/uploads/'.$imageName.'" class="img-thumbnail"/>');

			echo json_encode($result);
		}
	}

	/***********************************************************************upload image company logo***********************************************************/
	public function uploadCoverImageByAjax(){
		if(isset($_POST["CoverImg"])){
			$CoverImagedata = $_POST["CoverImg"];
			$size = getimagesize($CoverImagedata);





			$cover_image_array_1 = explode(";", $CoverImagedata);
			$cover_image_array_2 = explode(",", $cover_image_array_1[1]);
			$CoverImagedata = base64_decode($cover_image_array_2[1]);
			$exp_coverImage=explode('.', $_POST["uploaded_cover_image_name"]);

			$activityUserData = getNameById('company_detail',$_POST["logged_user_id"],'u_id');
			$nameChar = substr($activityUserData->name, 0, 3);
			$oldImage = $activityUserData->cover_photo;
			$imageName = $exp_coverImage[0].'company'.$nameChar.'_'.time().".".$exp_coverImage[1];

			file_put_contents('assets/modules/company/uploads/'.$imageName, $CoverImagedata);

			$config['upload_path'] = 'assets/modules/company/uploads/';
			$config['upload_url'] =  base_url().'assets/modules/company/uploads/';
			$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
			$config['max_size'] = '2000000';
			$config['file_name'] = $imageName;
			$this->load->library('upload', $config);



			$success = $this->company_model->updateCoverPhoto('company_detail',array('cover_photo'=>$imageName), 'u_id', $_POST["logged_user_id"]);

			if($oldImage != ''){
				unlink('assets/modules/company/uploads/'.$oldImage);
			}
			$result_cover = array('image' => $imageName,'imageHtml'=>'<img src="'.base_url().'assets/modules/company/uploads/'.$imageName.'" class="img-thumbnail"/>');

			echo json_encode($result_cover);
		}
	}


	public function businessProof($id=''){
		/*if($id == ''){
			$id = $_SESSION['loggedInUser']->id;
		}
		if($id != ''){
			$this->breadcrumb->add('Company', base_url() . 'company/view/'.$id);
			$this->breadcrumb->add('View', base_url() . 'company/view');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Company View';
			$this->data['company'] = $this->company_model->get_data_by_key('user','id',$id);
			#pre($this->data['company']);
			if(!empty($this->data['company'])){
				$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','u_id',$this->data['company']->u_id);
			}
			#$this->load->view('home/header');
			$this->_render_template('company/businessProof', $this->data);
			#$this->load->view('home/footer');
		}*/
		is_login();
		if($id == ''){
			$id = $_SESSION['loggedInUser']->id;
		}
		if($id != ''){
			$this->breadcrumb->add('Company', base_url() . 'company/view/'.$id);
			$this->breadcrumb->add('View', base_url() . 'company/view');
			$this->settings['breadcrumbs'] = $this->breadcrumb->output();
			$this->settings['pageTitle'] = 'Company View';
			#$this->data['company'] = $this->company_model->get_data_by_key('user','id',$id);
			$this->data['company'] = $this->company_model->get_data_by_key_for_business_proof('user','id',$id);
			if(!empty($this->data['company'])){
				#$this->data['users'] = $this->company_model->get_user_by_cid('user_detail','u_id',$this->data['company']->u_id);
				$this->data['users'] = $this->company_model->get_user_by_cid_for_business_proof('user_detail','u_id',$this->data['company']->u_id);
			}
			#$this->load->view('home/header');
			$this->_render_template('company/businessProof', $this->data);
			#$this->load->view('home/footer');
		}
	}

	# Function to upload Cover photo of company
	/*public function saveCompanyProofs(){
		is_login();
		if($this->input->post()) {
			$c_id = $_POST['c_id'];
			if($c_id && $c_id != ''){
				if(!empty($_FILES['business_certificate']['name'])){
					$i=0;
					foreach($_FILES['business_certificate']['name'] as $certificate){
						if($certificate !=''){
							$data['business_certificate'] = $certificate;
							$filename     = $_FILES['business_certificate']['name'][$i];
							$tmpname     = $_FILES['business_certificate']['tmp_name'][$i];
							$type     = $_FILES['business_certificate']['type'][$i];
							$error    = $_FILES['business_certificate']['error'][$i];
							$size    = $_FILES['business_certificate']['size'][$i];
							$exp=explode('.', $filename);
							$ext=end($exp);
							$newname=  $exp[0].'_'.time().".".$ext;
							$config['upload_path'] = 'assets/modules/company/uploads/';
							$config['upload_url'] =  base_url().'assets/modules/company/uploads/';
							$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
							$config['max_size'] = '2000000';
							$config['file_name'] = $newname;
							$this->load->library('upload', $config);
							move_uploaded_file($tmpname,"assets/modules/company/uploads/".$newname);
							$data['business_certificate_type'] = $this->input->post('business_certificate_type');
							$data['business_certificate'] =$newname;
							$data['gstin'] = $_POST['gstin'];
							$success = $this->company_model->updateCompanyProofs('company_detail',$data, 'id', $c_id);
							if($success){
								$msg = "Company proofs saved Successfully. Your account will be verified within 24 hours";
								$this->session->set_flashdata('message', $msg);
								redirect( base_url().'company/businessProof/', 'refresh');
							}
						}
						$i++;
					}
				} else {
					$data['business_certificate'] = $this->input->post('file_old_gstin_certificate');
				}

			}
		}
	}*/

	# Function to upload Cover photo of company
	public function saveCompanyProofs(){
		#pre($_POST); die;
		is_login();
		if($this->input->post()) {
			$c_id = $_POST['c_id'];
			if($_POST['id'] && $_POST['id'] != ''){
				if(!empty($_FILES['business_certificate']['name'])){
					$i=0;
					foreach($_FILES['business_certificate']['name'] as $certificate){
						if($certificate !=''){
							$data['business_certificate'] = $certificate;
							$filename     = $_FILES['business_certificate']['name'][$i];
							$tmpname     = $_FILES['business_certificate']['tmp_name'][$i];
							$type     = $_FILES['business_certificate']['type'][$i];
							$error    = $_FILES['business_certificate']['error'][$i];
							$size    = $_FILES['business_certificate']['size'][$i];
							$exp=explode('.', $filename);
							$ext=end($exp);
							$newname=  $exp[0].'_'.time().".".$ext;
							$config['upload_path'] = 'assets/modules/company/uploads/';
							$config['upload_url'] =  base_url().'assets/modules/company/uploads/';
							$config['allowed_types'] = "gif|jpg|jpeg|png|ico|doc|pdf";
							$config['max_size'] = '2000000';
							$config['file_name'] = $newname;
							$this->load->library('upload', $config);
							move_uploaded_file($tmpname,"assets/modules/company/uploads/".$newname);
							$data['business_certificate_type'] = $this->input->post('business_certificate_type');
							$data['business_certificate'] =$newname;
							#$data['business_status'] =1;
							#$data['company_db_name'] =$_POST['company_db_name'];
							$success = $this->company_model->updateCompanyProofs('company_detail',$data, 'id', $c_id);
							#$success = $this->company_model->updateCompanyProofs('user',$data, 'id', $_POST['id']);
							if($success){
							#if($this->company_model->updateCompanyProofs('user',$data, 'id', $_POST['id'])){
								$msg = "Company proofs saved Successfully. Your account will be verified within 24 hours";
								$this->session->set_flashdata('message', $msg);
								redirect( base_url().'company/businessProof/', 'refresh');
							}
						}
						$i++;
					}
				} else {
					$data['business_certificate'] = $this->input->post('file_old_gstin_certificate');
				}

			}
		}
	}

	/* Function to load backup page */
	public function db_backup(){
		is_login();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$id = $_SESSION['loggedInUser']->c_id;
		$this->breadcrumb->add('Company', base_url() . 'company/db_backup/'.$id);
		$this->breadcrumb->add('Database Backup', base_url() . 'assets/modules/company/db_backup');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Company Database Backup';
		$this->data['company_settings'] = $this->company_model->get_single_row_tbl_data_by_key('company_settings', 'c_id', $_SESSION['loggedInUser']->c_id);

		$this->_render_template('db_backup', $this->data);
	}

	/*  Function to backup the database */
	public function make_backup_db(){
		is_login();
		$company_db = $_SESSION['loggedInUser']->company_db_name;
			$this->db = $this->load->database('dynamicdb', TRUE);
        $this->load->dbutil();
        $prefs = array(
                'format'      => 'zip',
                'filename'    => 'db_backup.sql'
			);


        $backup =& $this->dbutil->backup($prefs);
        $db_name = $company_db.'_db-backup-'. date("Y-m-d-H-i-s") .'.zip';
        $save = FCPATH.'/assets/modules/company/db_backup/'.$db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        $this->load->helper('download');
        force_download($db_name, $backup);
	}

	public function delete_backup($backup){
		permissions_redirect('is_delete');
			if(file_exists(FCPATH.'/assets/modules/company/db_backup/' . $backup)){
				if (unlink(FCPATH.'/assets/modules/company/db_backup/' . $backup)) {
					$result = array('msg' => 'Backup Deleted Successfully', 'status' => 'success', 'code' => 'C288','url' => base_url().'company/db_backup');
				#	echo json_encode($result);
				}


			}
			redirect( base_url().'company/db_backup/', 'refresh');
    }


	public function saveCompanyBackupFrequency(){
		is_login();
		if($this->input->post()) {
			$data = $this->input->post();

				if($data['id'] && $data['id'] != ''){
						$success = $this->company_model->update_data('company_settings',$data, 'id', $data['id']);
						if ($success) {
							$data['message'] = "Backup frequency  updated successfully";
							logActivity('Backup frequency Updated','company_setting',$data['c_id']);
							$this->session->set_flashdata('message', 'Backup frequency Updated successfully');
							$this->db_backup();
						}
				}else{
					$id = $this->company_model->insert_tbl_data('company_settings',$data, 'id', $data['c_id']);
					if ($id) {
						logActivity('Backup frequency inserted successfully','company_setting',$data['c_id']);
						$this->session->set_flashdata('message', 'Backup frequency inserted successfully');
						$this->db_backup();
					}

				}
		}
	}


	/* For Company Settings (Dynamic Department) */
/*Company setting*/
	public function company_setting() {
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->data['can_view'] = view_permissions();
		$this->breadcrumb->add('Company Setting', base_url() . 'company_setting');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Company Setting';
		//$where = array('production_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id);
		//$this->data['company_branch']= $this->company_model->get_company_branch('company_detail',array('id' => $_SESSION['loggedInUser']->c_id));
		//$this->data['productionSetting']= $this->production_model->get_data('production_setting',$where);
		//$this->data['company_departments']= $this->company_model->get_data_company('department',array('department.created_by_cid' => $_SESSION['loggedInUser']->c_id));

		$this->data['company_departments']= $this->company_model->get_data_company('department',array('department.created_by_cid' => $this->companyGroupId));

		// pre($this->companyGroupId);die();

		//$this->data['machine_group']= $this->production_model->get_data('machine_group',array('machine_group.created_by_cid' => $_SESSION['loggedInUser']->c_id));
		//$this->data['machine_order']  = $this->production_model->get_data('add_machine',array('add_machine.created_by_cid' => $_SESSION['loggedInUser']->c_id));
		//$this->data['unit_price']= $this->production_model->get_data('electricity_unit',array('electricity_unit.created_by_cid' => $_SESSION['loggedInUser']->c_id));
		//$this->data['wages_perpiece']= $this->production_model->get_data('wages_perpiece_setting',array('wages_perpiece_setting.created_by_cid' => $_SESSION['loggedInUser']->c_id));
		$this->_render_template('company_settings/index', $this->data);
    }
	/*production setting edit*/

	public function edit_department(){
		if($this->input->post('id') != '')
			permissions_redirect('is_edit');
		else
			permissions_redirect('is_add');

		$this->data['department'] = $this->company_model->get_data_byId('department','id',$this->input->post('id'));
		$this->load->view('company_settings/edit', $this->data);
	}


	/*process name save function*/
	public function save_company_department(){
		if ($this->input->post()) {
			$required_fields = array('unit_name','name');
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}
			else{
				$data  = $this->input->post();
				$id = $data['id'];
				//$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;


				$data['created_by_cid'] = $this->companyGroupId ;

				$data['created_by'] = $_SESSION['loggedInUser']->u_id ;
				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id ;
					$success = $this->company_model->update_data('department',$data, 'id', $id);
					if ($success) {
                        $data['message'] = "Department updated successfully";
                        logActivity('Department Updated','update_production_department',$id);
                        $this->session->set_flashdata('message', 'Department Updated successfully');
					    redirect(base_url().'company/company_setting', 'refresh');
                    }
				}else{
					$departmentArray = array();
					if(!empty($data['name'])){
						$i = 0;
						foreach($data['name'] as $departmentName){
							$departmentArray[$i]['id'] = $id;
							$departmentArray[$i]['unit_name'] = $data['unit_name'];
							$departmentArray[$i]['name'] = $departmentName;
							$departmentArray[$i]['created_by_cid'] = $data['created_by_cid'];
							$departmentArray[$i]['created_by'] = $data['created_by'];
							$i++;
						}
					}
					$id = $this->company_model->insert_multiple_data('department',$departmentArray);
					$this->session->set_flashdata('message', 'Department inserted successfully');
					  redirect(base_url().'company/company_setting', 'refresh');

				}

			}
        }
	}


public function deleteDepartmentSetting($id = ''){
		if (!$id) {
           redirect('company/company_setting', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->company_model->delete_data('department','id',$id);
		if($result) {
			logActivity('Department setting Deleted','department',$id);

			$usersWithViewPermissions = $this->company_model->get_data_company('permissions', array('is_view' => 1 , 'sub_module_id' => 21));
			if(!empty($usersWithViewPermissions)){
				foreach($usersWithViewPermissions as $userViewPermission){
					if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
						/*pushNotification(array('subject'=> 'Department setting deleted' , 'message' => 'Department setting deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/



						pushNotification(array('subject'=> 'Department Setting deleted' , 'message' => 'Department Setting id : #'.$id.' is deleted by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id,'icon'=>'fa fa-archive'));

					}
				}
			}
			if($_SESSION['loggedInUser']->role !=1){
			/*	pushNotification(array('subject'=> 'Department setting deleted' , 'message' => 'Department setting deleted by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/




				pushNotification(array('subject'=> 'Department Setting deleted' , 'message' => 'Department Setting id : #'.$id.' is deleted by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id,'icon'=>'fa fa-archive'));
			}

			$this->session->set_flashdata('message', 'Department setting Deleted Successfully');
			$result = array('msg' => 'Department setting Deleted Successfully', 'status' => 'success', 'code' => 'C142','url' => base_url() . 'company/company_setting');
			echo json_encode($result);

			//redirect('company/company_setting', 'refresh');
        }
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C774'));
        }
	}



	function getcompany_unit(){
		$where = array('id' =>		$this->companyGroupId);
		$data  = $this->company_model->get_data_byAddress('company_detail',$where);
		$data1 = $data[0]['address'];
		$data2 = json_decode($data1);
		$addressArray = array();
		$i = 0;
		foreach($data2 as $dt){
			$addressArray[$i]['id'] = $dt->compny_branch_name;
			$addressArray[$i]['text'] = $dt->compny_branch_name;
			$i++;
		}
		echo json_encode($addressArray);
	}



	public function changeDb(){
		$company_detail = $this->company_model->get_data_by_key('user','email',$_POST['companyName']);
		$returnData = $this->company_model->auth_user_for_new_company($_POST['companyName']);
		$this->session->set_userdata('clientdb',$company_detail->company_db_name);
		$this->session->set_userdata('user_id',$returnData->u_id);
		$this->session->set_userdata('loggedInUser',$returnData);
		$this->session->set_userdata('loggedInCompany',$company_detail);
		$this->session->set_userdata('login_status', 'ok');
		$this->session->set_userdata('company_id',$company_detail->c_id);
	}


public function group_cmpny() {
		$this->data['can_edit'] = edit_permissions();
		$this->data['can_delete'] = delete_permissions();
		$this->data['can_add'] = add_permissions();
		$this->breadcrumb->add('Group Company', base_url() . 'Group Company');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Group Company Details';
		$created_by_id  = $_SESSION['loggedInUser']->c_id;
		//$this->data['company_grp_dtl']  = $this->company_model->get_group_company_data('grp_cmpny_setig',array('created_by_cid'=>$created_by_id));
		$this->data['company_grp_dtl']  = $this->company_model->get_group_company_data('company_detail',array('parent_cid'=>$_SESSION['loggedInUser']->c_id));
		$this->_render_template('group_company/index', $this->data);
	}
public function editgroup_company_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');
			$this->data['comapny_group_details'] = $this->company_model->get_data_byId('company_detail','id',$this->input->post('id'));
			$this->load->view('group_company/edit', $this->data);
		}
	}
public function viewgroup_company_details(){
		if($this->input->post()){
			$this->data['id'] = $this->input->post('id');
			//$this->data['comapny_group_details'] = $this->company_model->get_data_byId('grp_cmpny_setig','id',$this->input->post('id'));
			$this->data['comapny_group_details'] = $this->company_model->get_data_byId('company_detail','id',$this->input->post('id'));
			$this->load->view('group_company/view', $this->data);
		}
	}
public function save_company_group(){
		// is_login();
		if ($this->input->post()) {
			$required_fields = array('year_of_establish');
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}
			else{
				$data  = $this->input->post();
				if(!empty($_FILES['logo']['name'])){
					$data['logo']=$this->uploadFile('logo');
				} else {
					$data['logo'] = $this->input->post('fileOldlogo');
				}
				$data['c_id'] = $_SESSION['loggedInUser']->c_id;
				$addressLength = count($_POST['address']);
				if($addressLength >0){
					$addressArr = [];
					$i = 0;
					$idds = 1;
					while($i < $addressLength) {
						$addressJsonArrayObject = array('add_id'=> $idds,'address' => $_POST['address'][$i], 'country' => $_POST['country'][$i], 'state' => $_POST['state'][$i], 'city' => $_POST['city'][$i] , 'postal_zipcode' => $_POST['postal_zipcode'][$i], 'company_gstin' => $_POST['company_gstin'][$i],'compny_branch_name'=>$_POST['compny_branch_name'][$i]);
						$addressArr[$i] = $addressJsonArrayObject;
						$i++;
						$idds++;
					}
					$address_array = json_encode($addressArr);
				}else{
					$address_array = '';
				}
				$bankllength = count($_POST['account_no']);
			// pre($_POST);
			// die;
				if($bankllength >0){
					$bnkArr = [];
					$i = 0;
					$iddsb = 1;
					while($i < $bankllength) {
						$bnkJsonArrayObject = array('account_name'=> $_POST['account_name'][$i],'account_no'=> $_POST['account_no'][$i],'account_ifsc_code' => $_POST['account_ifsc_code'][$i], 'bank_name' => $_POST['bank_name'][$i], 'branch' => $_POST['branch'][$i]);
						$bnkArr[$i] = $bnkJsonArrayObject;
						$i++;
						$iddsb++;
					}
					$bank_array = json_encode($bnkArr);
				}else{
					$bank_array = '';
				}
				// pre($address_array); die;

				$data['address'] = $address_array;


				$data['bank_details'] = $bank_array;

				// pre($address_array); die;
				$data['created_by_cid'] =$_SESSION['loggedInUser']->c_id;
				//$data['created_by'] = $_SESSION['loggedInUser']->u_id;
				$data['u_id'] = $_SESSION['loggedInUser']->u_id;
				$data['parent_cid'] = $_SESSION['loggedInUser']->c_id;
				$id = $data['id'];

				if($id && $id != ''){
					$data['edited_by'] = $_SESSION['loggedInUser']->u_id;
					//$success = $this->company_model->update_data('grp_cmpny_setig',$data, 'id', $id);
                    $data['account_name'] = "";
                    $data['account_no'] = "";
                    $data['account_ifsc_code'] = "";
                    $data['bank_name'] = "";
                    $data['branch'] = "";
					
					// pre($data);die();
					$success = $this->company_model->update_data('company_detail',$data, 'id', $id,'group');
					if ($success) {
                        if(!empty($addressArr)){
							// $branch_data = get_location_settings_dtl('company_address',$_SESSION['loggedInUser']->c_id,'created_by_cid');

							// $already_data = count($branch_data);
							$already_data = 1;
							$j = 0;
							$p = 0;
							$compny_branch_id = 1;
                            foreach($addressArr as $address){
								$locationSettingData = array(
									'location' => $address['address'],
									'company_unit' => $address['compny_branch_name'],
									'compny_branch_id' => $address['add_id'],
									#'created_by_cid' => $_SESSION['loggedInUser']->c_id,
									'created_by_cid' => $_POST['id'],
									'created_by' => $_SESSION['loggedInUser']->u_id,
								);

									/* if(empty($branch_data)){
											//$this->company_model->insert_tbl_data('location_settings',$locationSettingData);
											//$this->company_model->insert_tbl_data('company_address',$locationSettingData);
											//$this->company_model->insert_sale_ledger_data('ledger',$add_sale_ledger);
									}else if($already_data < $addressLength){
										if(++$j === $addressLength) {//To Get Last Added Array in Company branch
											//$this->company_model->insert_tbl_data('location_settings',$locationSettingData);
											//$this->company_model->insert_tbl_data('company_address',$locationSettingData);
											//$this->company_model->insert_sale_ledger_data('ledger',$add_sale_ledger);
										  }
									}else{
										//$this->company_model->update_data('location_settings',$locationSettingData, 'compny_branch_id', $compny_branch_id);
										//$this->company_model->update_data('company_address',$locationSettingData, 'compny_branch_id', $compny_branch_id);
									} */

									if(empty($branch_data)){
											//$this->company_model->insert_tbl_data('location_settings',$locationSettingData);
											$this->company_model->insert_tbl_data('company_address',$locationSettingData);
											//$this->company_model->insert_sale_ledger_data('ledger',$add_sale_ledger);
									}else if($already_data < $addressLength){
										if(++$j === $addressLength) {//To Get Last Added Array in Company branch
											//$this->company_model->insert_tbl_data('location_settings',$locationSettingData);
											$this->company_model->insert_tbl_data('company_address',$locationSettingData);
											//$this->company_model->insert_sale_ledger_data('ledger',$add_sale_ledger);
										  }
									}else{
										//$this->company_model->update_data('location_settings',$locationSettingData, 'compny_branch_id', $compny_branch_id);
										$this->company_model->update_data('company_address',$locationSettingData, 'compny_branch_id', $compny_branch_id,'group');
									}


							$compny_branch_id++;

						}
                        }
                        $data['message'] = "Company Group details updated successfully";
                        logActivity('Company Group details Updated','company_detail',$id);
						$this->session->set_flashdata('message', 'Company Group Details Updated successfully');
                        redirect( base_url().'company/group_cmpny/'.$id, 'refresh');
                    }
				}else{
					if(!empty($_FILES['fileOldlogo']['name']) && $_FILES['fileOldlogo']['name'][0]!=''){
									$filename     = $_FILES['fileOldlogo']['name'];
									$tmpname     = $_FILES['fileOldlogo']['tmp_name'];
									$type     = $_FILES['fileOldlogo']['type'];
									$error    = $_FILES['fileOldlogo']['error'];
									$size    = $_FILES['fileOldlogo']['size'];
									$exp=explode('.', $filename);
									$ext=end($exp);
									 $newname=  $exp[0].'_'.time().".".$ext;
									$config['upload_path'] = 'assets/modules/company/uploads/';
									$config['upload_url'] =  base_url().'assets/modules/company/uploads/';
									$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
									$config['max_size'] = '2000000';
									$config['file_name'] = $newname;
									$this->load->library('upload', $config);

									move_uploaded_file($tmpname,"assets/modules/company/uploads/".$newname);
										$data['logo'] = $newname;
					}
					//$id = $this->company_model->insert_group_company_tbl_data('grp_cmpny_setig',$data);
					//pre($data);die;
                    $data['account_name'] = "";
                    $data['account_no'] = "";
                    $data['account_ifsc_code'] = "";
                    $data['bank_name'] = "";
                    $data['branch'] = "";
					$id = $this->company_model->insert_group_company_tbl_data('company_detail',$data,'group');
					if ($id) {

						  if(!empty($addressArr)){
								#$branch_data = get_location_settings_dtl('company_address',$_SESSION['loggedInUser']->c_id,'created_by_cid');

								#$already_data = count($branch_data);
								/* $j = 0;
								$p = 0; */
								$compny_branch_id = 1;
								foreach($addressArr as $address){
									$locationSettingData = array(
										'location' => $address['address'],
										'company_unit' => $address['compny_branch_name'],
										'compny_branch_id' => $address['add_id'],
										#'created_by_cid' => $_SESSION['loggedInUser']->c_id,
										#'created_by_cid' => $_POST['id'],
										'created_by_cid' => $id,
										'created_by' => $_SESSION['loggedInUser']->u_id,
									);



									#if(empty($branch_data)){
											//$this->company_model->insert_tbl_data('location_settings',$locationSettingData);
											$this->company_model->insert_tbl_data('company_address',$locationSettingData);
											//$this->company_model->insert_sale_ledger_data('ledger',$add_sale_ledger);
								#	}
									/* else if($already_data < $addressLength){
										if(++$j === $addressLength) {//To Get Last Added Array in Company branch
											//$this->company_model->insert_tbl_data('location_settings',$locationSettingData);
											$this->company_model->insert_tbl_data('company_address',$locationSettingData);
											//$this->company_model->insert_sale_ledger_data('ledger',$add_sale_ledger);
										  }
									} */
									/* else{
										//$this->company_model->update_data('location_settings',$locationSettingData, 'compny_branch_id', $compny_branch_id);
										$this->company_model->update_data('company_address',$locationSettingData, 'compny_branch_id', $compny_branch_id,'group');
									} */


							$compny_branch_id++;

						}
                        }

                        logActivity('New Company Group Created','save_company_group',$id);
                        $this->session->set_flashdata('message', 'New Company Group inserted successfully');
					    redirect(base_url().'company/group_cmpny/', 'refresh');
                    }
				}
			}
		}
	}

public function deletegoup_company_details($id = ''){
		if (!$id) {
           redirect('company/group_cmpny/', 'refresh');
        }
		permissions_redirect('is_delete');
        $result = $this->company_model->delete_data('grp_cmpny_setig','id',$id);
		if($result){
			logActivity('Group Company Details Deleted','grp_cmpny_setig',$id);
			$this->session->set_flashdata('message', 'Group Company Details Deleted Successfully');
			$result = array('msg' => 'Group Company Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'company/group_cmpny/');
			echo json_encode($result);
			die;
        }
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
	}

	public function uploadImage_company_groupByAjax(){
		if(isset($_POST["image"])){

			$data = $_POST["image"];

			$image_array_1 = explode(";", $data);
			$image_array_2 = explode(",", $image_array_1[1]);
			$data = base64_decode($image_array_2[1]);
			$exp=explode('.', $_POST["uploaded_image_name"]);
			$activityUserData = getNameById('grp_cmpny_setig',$_POST["id"],'id');
			$nameChar = substr($activityUserData->name, 0, 3);
			$oldImage = $activityUserData->logo;
			$imageName = $exp[0].'groupcompany'.$nameChar.'_'.time().".".$exp[1];
			file_put_contents('assets/modules/company/uploads/'.$imageName, $data);
				//move_uploaded_file("assets/modules/company/uploads/".$imageName, $data);
			$success = $this->company_model->updateLogo('grp_cmpny_setig',array('logo'=>$imageName), 'id', $_POST["id"]);
			if($oldImage != ''){
				unlink('assets/modules/company/uploads/'.$oldImage);
			}

			$result = array('image' => $imageName,'imageHtml'=>'<img src="'.base_url().'assets/modules/company/uploads/'.$imageName.'" class="img-thumbnail"/>');
			echo json_encode($result);
		}
	}
	/* Main Function to fetch all the activity and visiting logs */
    public function activity_log($id = '') {
		is_login();
		if($id == ''){
			$id = $_SESSION['loggedInUser']->id;
		}
        $this->settings['pageTitle'] = 'Activity Log View';

        $sdate = $this->input->post('sdate');
		if (!empty($sdate)) {
		    $date = $sdate;
		}else{
		    $date = date('Y-m-d');
		}

		if($id != ''){
			$this->data['activity_logs'] = $this->company_model->get_logs_related_data('activity_log', array("DATE_FORMAT(date,'%Y-%m-%d')" => $date));
			$this->data['visiting_logs'] = $this->company_model->get_logs_related_data('visiting_log', array("DATE_FORMAT(date,'%Y-%m-%d')" => $date));
			$this->_render_template('company/logs_view', $this->data);
		}
	}


	public function view_log() {
	    is_login();
	    if($id == ''){
			$id = $_SESSION['loggedInUser']->id;
		}
        $this->settings['pageTitle'] = 'View Log';
        if($id != ''){
		    $this->_render_template('company/logs_view', $this->data);
        }
	}

}
