<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Hrm extends ERP_Controller {
    public function __construct() {
        parent::__construct();
        is_login();
        $this->load->library(array('form_validation', 'email'));
        $this->load->helper('hrm/hrm');
        $this->load->model('hrm_model');
        $this->load->model('crm/crm_model');
        $this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
        $this->settings['css'][] = 'assets/plugins/switchery/dist/switchery.min.css'; 
        $this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->scripts['js'][] = 'assets/plugins/switchery/dist/switchery.min.js';
        $this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
        $this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
        //  $this->scripts['js'][] = 'assets/plugins/uploadfile/jquery.uploadfile.min.js';      
        #$this->scripts['js'][] = 'assets/modules/users/js/croppe.js';
        #$this->scripts['js'][] = 'assets/plugins/Croppie-master/croppie.js';
        $this->scripts['js'][] = 'assets/modules/hrm/js/script.js';
        $this->scripts['js'][] = 'assets/modules/hrm/js/ckeditor/ckeditor.js';
        #$this->scripts['js'][] = 'assets/modules/users/js/script.js';
        #$this->scripts['css'][] = 'assets/plugins/Croppie-master/croppie.css';
        $this->settings['css'][] = 'assets/modules/hrm/css/style1.css';
        $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId'] != '' && $_SESSION['companyGroupSessionId'] != 0) ? $_SESSION['companyGroupSessionId'] : $_SESSION['loggedInUser']->c_id;
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		
		  $CI =& get_instance();
		
		  $CI->createTableColumn('production_setting','working_hrs',"INT(11) NULL DEFAULT NULL  AFTER shift_start");
		  $CI->createTableColumnInParent('production_setting','working_hrs',"INT(11) NULL DEFAULT NULL  AFTER shift_start");

		
    }
	
	
	 public function createTableColumnInParent($table,$column,$defineColumType){
        $ci =& get_instance();
        //$dynamicdb = $ci->load->database('dynamicdb', TRUE);
        $data = $ci->db->query("SHOW COLUMNS FROM  {$table} LIKE '{$column}'")->row_array();
        if( empty($data) ){
            $ci->db->query("ALTER TABLE {$table}  ADD {$column} {$defineColumType}");
        }
    }

    public function createTableColumn($table,$column,$defineColumType){
        $ci =& get_instance();
        $dynamicdb = $ci->load->database('dynamicdb', TRUE);
        $data = $dynamicdb->query("SHOW COLUMNS FROM  {$table} LIKE '{$column}'")->row_array();
        if( empty($data) ){
            $dynamicdb->query("ALTER TABLE {$table}  ADD {$column} {$defineColumType}");
        }
    }
    /* Main Function to fetch all the listing of users */
    public function index() {
          $this->data['users'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
        $this->data['inactive_user'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 0));
        $this->breadcrumb->add('Hrm', base_url() . 'hrm/index');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'HRM';
        $this->data['country'] = $this->hrm_model->fetch_country();
        $this->_render_template('users/index', $this->data);
    }
    /* Main Function to fetch all the listing of users */
    public function users() {
        #$this->data['users']  = $this->users_model->get_data('user',array('user.c_id' =>$this->companyGroupId  , 'user.role' => 2));
        //$this->data['users']  = $this->users_model->get_data('user',array('user.c_id' =>$this->companyGroupId ));
        //$this->data['inactive_user']  = $this->users_model->get_data('user',array('user.c_id' =>$this->companyGroupId  , 'user.role' => 2, 'user.status' => 0));
        $this->data['users'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
        $this->data['inactive_user'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 0));
        $this->breadcrumb->add('Hrm', base_url() . 'hrm/index');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'HRM';
        $this->data['country'] = $this->hrm_model->fetch_country();
        $this->_render_template('users/index', $this->data);
    }
    public function add() {
        $this->breadcrumb->add('Users', base_url() . 'users');
        $this->breadcrumb->add('Add', base_url() . 'hrm/add');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'User Add';
        $this->data['users'] = $this->hrm_model->get_data('user');
        $this->_render_template('add', $this->data);
    }
    public function editUser($id = '') {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Users', base_url() . 'users');
        $this->breadcrumb->add('Edit', base_url() . 'users/edit');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'User Edit';
        $parentModules = $this->hrm_model->get_data('modules');
        $permissionsArray = array();
        $i = 0;
        foreach ($parentModules as $parentModule) {
            $permissionsArray[$i] = $parentModule;
            $sub_modules = $this->hrm_model->get_data('sub_module', array('modules_id' => $parentModule['id']));
            $permissionsArray[$i]['sub_module'] = $sub_modules;
            $y = 0;
            #pre($sub_modules);
            foreach ($sub_modules as $sub_module) {
                $permissions = $this->hrm_model->fetch_user_premissions_by_id($id, array('p.sub_module_id' => $sub_module['id'], 'p.user_id' => $id));
                #pre($permissions);
                $permissionsArray[$i]['sub_module'][$y]['permissions'] = $permissions;
                $y++;
            }
            $i++;
        }
        $cmp_grp = getCompaniesOfGroup();
        $comp_perm = array();
        foreach ($cmp_grp as $key) {
            $comp_perm[$i] = $key;
            $comp_perm[$i]['comp_permission'] = $this->hrm_model->fetch_comp_premissions_by_id($id, array('cmp.comp_id' => $key['id'], 'cmp.user_id' => $id));
            $cmp_grp = $comp_perm;
            $i++;
        }
        $this->data['groupofCompany'] = $cmp_grp;
        $this->data['permissionsArray'] = $permissionsArray;
        $this->data['user'] = $this->hrm_model->get_data_byId('user', 'id', $id);
        $totalFields = count(array_keys((array)$this->data['user'])) - 3;
        $nonEmptyFields = count(array_filter((array)$this->data['user'])) - 3;
        $this->data['profileComplete'] = round($nonEmptyFields * 100 / $totalFields);
        $this->data['activity_logs'] = $this->hrm_model->get_data('activity_log', array('userid' => $id));
        $this->data['country'] = $this->hrm_model->fetch_country();
        $this->data['attachments'] = $this->hrm_model->get_attachmets_by_UserId('attachments', 'rel_id', $id);
        #pre($this->data);die;
        $this->_render_template('users/edit', $this->data);
    }
    public function editprofile() {
        $id = $_POST['id'];
        $this->data['user'] = $this->hrm_model->get_data_byId('user', 'id', $id);
        $totalFields = count(array_keys((array)$this->data['user'])) - 3;
        $nonEmptyFields = count(array_filter((array)$this->data['user'])) - 3;
        $this->data['profileComplete'] = round($nonEmptyFields * 100 / $totalFields);
        $this->data['activity_logs'] = $this->hrm_model->get_data('activity_log', array('userid' => $id));
        $this->data['country'] = $this->hrm_model->fetch_country();
        //pre($this->data);die;
        $this->load->view('users/editprofile', $this->data);
    }
    #  Function to add/edit User
    public function saveUser() {
        #  pre($_POST);die;
        $jsonPermanentAddressArrayObject = (array('address' => @$_POST['permanent_address'], 'country' => @$_POST['permanent_country'], 'state' => @$_POST['permanent_state'], 'city' => @$_POST['permanent_city'], 'postal_zipcode' => @$_POST['permanent_postal_zipcode']));
        $address1 = json_encode($jsonPermanentAddressArrayObject);
        $jsonCorrespondanceAddressArrayObject = (array('address' => @$_POST['correspondance_address'], 'country' => @$_POST['correspondance_country'], 'state' => @$_POST['correspondance_state'], 'city' => @$_POST['correspondance_city'], 'postal_zipcode' => @$_POST['correspondance_postal_zipcode']));
        $address2 = json_encode($jsonCorrespondanceAddressArrayObject);
        $jsonBankDetailsArrayObject = (array('pan_number' => @$_POST['pan_number'], 'include_pf' => @$_POST['include_pf'], 'pf_number' => @$_POST['pf_number'], 'uan_number' => @$_POST['uan_number'], 'pf18000' => @$_POST['pf18000'], 'pfgreaterthan1800' => @$_POST['pfgreaterthan1800'], 'include_esi' => @$_POST['include_esi'], 'include_lwf' => @$_POST['include_lwf']));
        $bankDetails = json_encode($jsonBankDetailsArrayObject);
        $jsonPaymentModeArrayObject = (array('payment_mode' => @$_POST['payment_mode'], 'bank_branch' => @$_POST['bank_branch'], 'dd_payable_at' => @$_POST['dd_payable_at'], 'account_no' => @$_POST['account_no'], 'branch_name' => @$_POST['branch_name'], 'bank_name' => @$_POST['bank_name']));
        $paymentMode = json_encode($jsonPaymentModeArrayObject);
        $experienceLength = count(@$_POST['companyName']);
        if ($experienceLength > 0) {
            $experienceArr = array();
            $i = 0;
            while ($i < $experienceLength) {
                $experienceJsonArrayObject = array('companyName' => @$_POST['companyName'][$i], 'companyLocation' => @$_POST['companyLocation'][$i], 'position' => @$_POST['position'][$i], 'work_period' => @$_POST['work_period'][$i], 'responsibility' => @$_POST['responsibility'][$i]);
                $experienceArr[$i] = $experienceJsonArrayObject;
                $i++;
            }
            $experience_array = json_encode($experienceArr);
        } else {
            $experience_array = '';
        }
        $qualLength = count(@$_POST['qualification']);
        if ($qualLength > 0) {
            $arr = array();
            $i = 0;
            while ($i < $qualLength) {
                $jsonArrayObject = (array('qualification' => @$_POST['qualification'][$i], 'university' => @$_POST['university'][$i], 'year' => @$_POST['year'][$i], 'marks' => @$_POST['marks'][$i]));
                $arr[$i] = $jsonArrayObject;
                $i++;
            }
            $qualification_array = json_encode($arr);
        } else {
            $qualification_array = '';
        }
        $skillLength = count(@$_POST['skill_name']);
        if ($skillLength > 0) {
            $skillArr = array();
            $j = 0;
            while ($j < $skillLength) {
                $jsonSkillObject = (array('skill_name' => $_POST['skill_name'][$j], 'skill_count' => @$_POST['skill_count'][$j]));
                $skillArr[$j] = $jsonSkillObject;
                $j++;
            }
            $skill_array = json_encode($skillArr);
        } else {
            $skill_array = '';
        }
        if ($this->input->post()) {
            $required_fields = array('name', 'email', 'designation', 'contact_no', 'age', 'date_joining', 'gender');
            $is_valid = validate_fields($_POST, $required_fields);
            //pre($is_valid);die;
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['qualification'] = $qualification_array;
                $data['experience_detail'] = $experience_array;
                $data['skill'] = $skill_array;
                $data['address1'] = $address1;
                $data['address2'] = $address2;
                $data['bankDetails'] = $bankDetails;
                $data['paymentMode'] = $paymentMode;
                $id = $data['id'];
                #if(!empty($_FILES['user_profile']['name'])){
                /* if($data['changed_user_profile'] != ''){
                
                #$data['user_profile']=$this->uploadFile('user_profile', $data['changed_user_profile']);
                
                #file_put_contents('assets/modules/users/uploads/'.$data['changed_user_profile'], $data['changed_user_profile']);
                
                $data['user_profile'] = $data['changed_user_profile'];
                
                //pre($data['user_profile']); die;
                
                }else {
                
                $data['user_profile'] = $this->input->post('fileOldlogo');
                
                }  */
                if ($id && $id != '') {
                    if ($_SESSION['loggedInUser']->role == 1) {
                        $data['c_id'] = $data['company_id'];
                        $user_datax = array('c_id' => $data['company_id']);
                        $this->hrm_model->updateData('user', $user_datax, 'id', $id);
                    }
                    
                
                    $success = $this->hrm_model->update_data('user_detail', $data, 'u_id', $id);
                    if ($success) {
                        if (!empty($_FILES['doc_upload']['name']) && $_FILES['doc_upload']['name'][0] != '') {
                            $attachment_array = array();
                            $certificateCount = count($_FILES['doc_upload']['name']);
                            for ($i = 0;$i < $certificateCount;$i++) {
                                $filename = $_FILES['doc_upload']['name'][$i];
                                $tmpname = $_FILES['doc_upload']['tmp_name'][$i];
                                $type = $_FILES['doc_upload']['type'][$i];
                                $error = $_FILES['doc_upload']['error'][$i];
                                $size = $_FILES['doc_upload']['size'][$i];
                                $exp = explode('.', $filename);
                                $ext = end($exp);
                                $newname = $exp[0] . '_' . time() . "." . $ext;
                                $config['upload_path'] = 'assets/modules/hrm/uploads/';
                                $config['upload_url'] = base_url() . 'assets/modules/hrm/uploads/';
                                $config['allowed_types'] = "gif|jpg|jpeg|png|doc|pdf|docx|ods";
                                $config['max_size'] = '2000000';
                                $config['file_name'] = $newname;
                                $this->load->library('upload', $config);
                                move_uploaded_file($tmpname, "assets/modules/hrm/uploads/" . $newname);
                                $attachment_array[$i]['rel_id'] = $id;
                                $attachment_array[$i]['rel_type'] = 'job_applicant_docs';
                                $attachment_array[$i]['file_name'] = $newname;
                                $attachment_array[$i]['file_type'] = $type;
                            }
                            //pre($attachment_array);die;
                            if (!empty($attachment_array)) {
                                /* Insert file information into the database */
                                $attachmentId = $this->hrm_model->insert_attachment_data('attachments', $attachment_array, 'hrm/editUser/' . $id);
                                //pre($attachmentId);die;
                                
                            }
                        }
                        $data['message'] = "user details updated successfully";
                        logActivity('user details Updated', 'user', $id);
                        $this->session->set_flashdata('message', 'User Details Updated successfully');
                        redirect(base_url() . 'hrm/editUser/' . $id, 'refresh');
                        die;
                    }
                } else {
                    $checkEmail = $this->hrm_model->emailExist($data['email']);
                    $email = $data['email'];
                    if ($checkEmail == '') {
                        /*$uploadData = array();
                        
                        if(!empty($_FILES['user_profile']['name'])){
                        
                        $uploadPath = 'assets/modules/users/uploads/';
                        
                        $config['upload_path'] = $uploadPath;
                        
                        $config['allowed_types'] = 'gif|jpg|png';
                        
                        $this->load->library('upload', $config);
                        
                        $this->upload->initialize($config);
                        
                        //if($this->upload->do_upload('user_profile')){
                        
                        if($this->upload->do_upload('changed_user_profile')){
                        
                        $fileData = $this->upload->data();
                        
                        $data['user_profile'] = $data['changed_user_profile'];
                        
                        }
                        
                        } */
                        $password = rand(100000000, 999999999);
                        $data['password'] = easy_crypt($password);
                        $data['activation_code'] = md5(rand());
                        $data['email_status'] = 'not verified';
                        $data['name'] = $data['name'];
                        $data['role'] = 2;
                        $data['status'] = 1;
                        $data['company_db_name'] = $_SESSION['loggedInUser']->company_db_name;
                        $data['business_status'] = 1;
                        $data['c_id'] = $this->companyGroupId;
                        //$data['c_id'] = $data['company_id'];
                        # print_r($data);
                        #  die();
                        $insertedUserId = $this->hrm_model->insert_tbl_data('user', $data);
                        if ($insertedUserId) {
                            $data['u_id'] = $insertedUserId;
                            $insertedUserDetailId = $this->hrm_model->insert_tbl_data('user_detail', $data);
                            $this->add_leaves_to_newUser($insertedUserId);
                            if (!empty($_POST['applicant_id'])) {
                                $attachments = $this->hrm_model->get_attachmets_by_UserId('attachments', 'rel_id', $_POST['applicant_id']);
                                //$attachmentsLength = count($attachments);
                                foreach ($attachments as $attch) {
                                    $attachments_data = array();
                                    $attachments_data = array('rel_id' => $insertedUserId);
                                    $attachments = $this->hrm_model->attachment_Update($attch['id'], $attachments_data);
                                }
                            }
                            if (!empty($_FILES['doc_upload']['name']) && $_FILES['doc_upload']['name'][0] != '') {
                                $attachment_array = array();
                                $certificateCount = count($_FILES['doc_upload']['name']);
                                for ($i = 0;$i < $certificateCount;$i++) {
                                    $filename = $_FILES['doc_upload']['name'][$i];
                                    $tmpname = $_FILES['doc_upload']['tmp_name'][$i];
                                    $type = $_FILES['doc_upload']['type'][$i];
                                    $error = $_FILES['doc_upload']['error'][$i];
                                    $size = $_FILES['doc_upload']['size'][$i];
                                    $exp = explode('.', $filename);
                                    $ext = end($exp);
                                    $newname = $exp[0] . '_' . time() . "." . $ext;
                                    $config['upload_path'] = 'assets/modules/hrm/uploads/';
                                    $config['upload_url'] = base_url() . 'assets/modules/hrm/uploads/';
                                    $config['allowed_types'] = "gif|jpg|jpeg|png|doc|pdf|docx|ods";
                                    $config['max_size'] = '2000000';
                                    $config['file_name'] = $newname;
                                    $this->load->library('upload', $config);
                                    move_uploaded_file($tmpname, "assets/modules/hrm/uploads/" . $newname);
                                    $attachment_array[$i]['rel_id'] = $insertedUserId;
                                    $attachment_array[$i]['rel_type'] = 'job_applicant_docs';
                                    $attachment_array[$i]['file_name'] = $newname;
                                    $attachment_array[$i]['file_type'] = $type;
                                }
                                //pre($attachment_array);die;
                                if (!empty($attachment_array)) {
                                    /* Insert file information into the database */
                                    $attachmentId = $this->hrm_model->insert_attachment_data('attachments', $attachment_array, 'hrm/editUser/' . $insertedUserId);
                                    //pre($attachmentId);die;
                                    
                                }
                            }
                            $sub_modules = $this->hrm_model->get_data('sub_module');
                            foreach ($sub_modules as $sub_module) {
                                $permissions_data = array();
                                $permissions_data['is_all'] = 0;
                                $permissions_data['is_view'] = 0;
                                $permissions_data['is_add'] = 0;
                                $permissions_data['is_edit'] = 0;
                                $permissions_data['is_delete'] = 0;
                                $permissions_data['is_validate'] = 0;
                                $permissions_data['sub_module_id'] = $sub_module['id'];
                                $permissions_data['user_id'] = $insertedUserId;
                                $insertPermission = $this->hrm_model->save_user_permissions($permissions_data);
                            }
                            $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">

                                                <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">

                                                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi ' . $data["name"] . ',</p>                              

                                                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">You are registered as a user on ERP. Your password is ' . $password . ', This password will work only after your email verification.</p>

                                                    <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Please Open this link to verified your email address - ' . base_url() . 'auth/verifyEmail/' . $data["activation_code"] . '</p> 

                                                </td>

                                            </tr>

                                        </table>

                                    </td>

                                </tr>';
                            $this->load->library('phpmailer_lib');
                            // PHPMailer object
                            $monthYearail = $this->phpmailer_lib->load();
                            //Server settings
                            $monthYearail->SMTPDebug = 0;
                            $monthYearail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)); // Enable verbose debug output
                            
                            $monthYearail->Subject = 'Email Verification';
                            $monthYearail->isSMTP(); // Send using SMTP
                            $monthYearail->Host = 'email-smtp.ap-south-1.amazonaws.com'; // Set the SMTP server to send through
                            $monthYearail->SMTPAuth = true; // Enable SMTP authentication
                            $monthYearail->Username = 'AKIAZB4WVENVZ773ONVF'; // SMTP username
                            $monthYearail->Password = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG'; // SMTP password
                            $monthYearail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $monthYearail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            //Recipients
                            $monthYearail->setFrom('dev@lastingerp.com', 'Lasting ERP');
                            $monthYearail->addAddress($email, ''); // Add a recipient
                            // Content
                            $monthYearail->isHTML(true);
                            // Email body content
                            $monthYearailContent = $email_message;
                            $monthYearail->Body = $monthYearailContent;
                            $monthYearail->Subject = 'User Registration';
                            #$monthYearail->ClearAllRecipients();
                            $monthYearail->send();
                            #pre($monthYearail->send());
                            #die;
                            logActivity('User details Inserted', 'user', $insertedUserId);
                            $this->session->set_flashdata('message', 'User Details Inserted successfully');
                            //pre($_REQUEST);pre($_FILES);die;
                            redirect(base_url() . 'hrm', 'refresh');
                            die;
                        }
                    } else {
                        $this->session->set_flashdata('message', 'Email id already exist');
                        redirect(base_url() . 'hrm/job_position_pipeline', 'refresh');
                        die;
                    }
                }
            }
        }
    }
    # Delete User by status inactive
    public function deleteUser($id = '') {
        if (!$id) {
            redirect('Hrm/users', 'refresh');
        }
        // $result = $this->users_model->delete_data('user','id',$id);
        $result = $this->hrm_model->change_status($id, 0);
        if ($result) {
            logActivity('user Deleted', 'user', $id);
            $this->session->set_flashdata('message', 'user Deleted Successfully');
            $result = array('msg' => 'user Deleted Successfully', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'hrm');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C118'));
        }
    }
    # Function to save the permissions of User
    public function save_permission() {
        $cmp_grp = getCompaniesOfGroup();
        $data = $this->input->post();  
        foreach ($cmp_grp as $tyu) {
            $perm_status = array();
            $perm_status['status'] = 0;
            if ($this->input->post($tyu['id'] . '_status')) {
                $perm_status['status'] = 1;
                $perm_status['comp_id'] = $tyu['id'];
                $perm_status['user_id'] = $data['id'];
            }
            $this->hrm_model->update_user_comp_permissions($data['id'], $tyu['id'], $perm_status);
        }
        #pre($perm_status);
        #die;
        $sub_modules = $this->hrm_model->get_data('sub_module');
        foreach ($sub_modules as $sub_module) {
            $permissions_data = array();
            # Initially set all the permissions to zero means user don't have any permission to access
            $permissions_data['is_all'] = 0;
            $permissions_data['is_view'] = 0;
            $permissions_data['is_add'] = 0;
            $permissions_data['is_edit'] = 0;
            $permissions_data['is_delete'] = 0;
            $permissions_data['is_validate'] = 0;
            # Set the permissions
            if ($this->input->post($sub_module['id'] . '_all')) {
                $permissions_data['is_all'] = 1;
            }
            if ($this->input->post($sub_module['id'] . '_view')) {
                $permissions_data['is_view'] = 1;
            }
            if ($this->input->post($sub_module['id'] . '_add')) {
                $permissions_data['is_add'] = 1;
            }
            if ($this->input->post($sub_module['id'] . '_edit')) {
                $permissions_data['is_edit'] = 1;
            }
            if ($this->input->post($sub_module['id'] . '_delete')) {
                $permissions_data['is_delete'] = 1;
            }
            if ($this->input->post($sub_module['id'] . '_validate')) {
                $permissions_data['is_validate'] = 1;
            }
            $permissions_data['sub_module_id'] = $sub_module['id'];
            $permissions_data['user_id'] = $data['id'];
            $permission = $this->hrm_model->update_user_permissions($data['id'], $sub_module['id'], $permissions_data);
        }
        if ($permission) {
            logActivity('permission are set', 'permisssions', $permission);
            $this->session->set_flashdata('message', 'Permission updated successfully.');
            redirect(base_url() . 'hrm', 'refresh');
        }
    }
    /*    Function for datatable pagination    */
    public function pagination_data() {
        echo json_encode(user_tbl_data());
        die;
    }
    # Function to Upload file
    /* public function uploadFile($fielName, $changed_user_profile) {
    
    $filename=$_FILES[$fielName]['name'];
    
    $tmpname=$_FILES[$fielName]['tmp_name'];
    
    //$exp=explode('.', $filename);
    
    //$ext=end($exp);
    
    #$newname=  $exp[0].'_'.time().".".$ext;
    
    $newname = $changed_user_profile;
    
    $config['upload_path'] = 'assets/modules/users/uploads/';
    
    $config['upload_url'] =  base_url().'assets/modules/users/uploads/';
    
    $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
    
    $config['max_size'] = '2000000';
    
    $config['file_name'] = $newname;
    
    $this->load->library('upload', $config);
    
    #move_uploaded_file($tmpname,"assets/modules/users/uploads/".$newname);
    
    return $newname;
    
    } */
    #  Function change status of group
    public function change_status() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
         $status = (isset($_POST['status']) && $_POST['status'] == 1) ? '1' : '0';
        $status_data = $this->hrm_model->change_status($id, $status);
        $status_dataUserDetails = $this->hrm_model->change_status_UserDetails($id, $status);
        logActivity('Changed', 'user', $id);
        $result = array('msg' => ' Status Changed', 'status' => 'success', 'code' => 'C221', 'url' => base_url() . 'hrm/users');
        echo json_encode($result);
    }
    /* change_hr_permissions using Java script functionality
     public function change_hr_permissions() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['hr_permissions']) && $_POST['hr_permissions'] == 1) ? '1' : '0';
        $status_data = $this->hrm_model->change_status_hr_permissions($id, $status);
        logActivity('Changed', 'user', $id);
        $result = array('msg' => ' Status Changed', 'hr_permissions' => 'success', 'code' => 'C221', 'url' => base_url() . 'hrm/users');
        echo json_encode($result);
    } 
    */
   
    # Function to change the password of User
    public function changePassword() {
        $data = $this->input->post();
        $password = easy_crypt($data['password']);
        $old_row = $this->hrm_model->get_data_byId('user', 'id', $_POST['id'], 'changePassword');
        #pre($old_row);
        #die;
        if (easy_crypt($data['old_password']) == $old_row->password) {
            #echo 'jjgjg'; #die;
            $success = $this->hrm_model->change_password($data['id'], $password);
            if ($success) {
                logActivity('user password changed', 'user', $data['id']);
                $this->session->set_flashdata('message', 'user password changed successfully');
                redirect(base_url() . 'hrm/editUser/' . $data['id'], 'refresh');
                die;
            }
        } else {
            #echo 'llllllll';        die;
            $this->session->set_flashdata('message', 'Your old password is wrong.');
            redirect(base_url() . 'hrm/editUser/' . $data['id'], 'refresh');
            die;
        }
    }
    # Function to get activity log of particular User
    # Function to get activity log of particular User
    public function fetch_user_activity_log() {
        if (isset($_POST["limit"], $_POST["start"])) {
            //$userLog = $this->users_model->fetch_user_activity_log($_POST["start"],$_POST["limit"],$_SESSION['loggedInUser']->id);
            $userLog = $this->hrm_model->fetch_user_activity_log($_POST["start"], $_POST["limit"], $_POST["id"]);
            //echo json_encode($userLog);
            $userData = '';
            foreach ($userLog as $activity_log) {
                $activityUserData = getNameById('user_detail', $activity_log['userid'], 'u_id');
                if (!empty($activityUserData)) {
                    if ($activityUserData->user_profile != '') {
                        $userProfile = $activityUserData->user_profile;
                    } else {
                        $userProfile = ($activityUserData->user_profile == '' && $activityUserData->gender == 'Female') ? 'female_image_placeholder.jpg' : 'dummy.jpg';
                    }
                    //$userProfile = $activityUserData->user_profile?$activityUserData->user_profile:'userp.png';
                    
                } else {
                    $userProfile = 'dummy.jpg';
                } ?>    

                <li>

                    <img src="<?php echo base_url('assets/modules/hrm/uploads') . '/' . $userProfile; ?>" class="avatar" alt="Avatar">

                    <div class="message_date">

                      <?php /*<h3 class="date text-info">24</h3>
                
                 <p class="month">May</p> <?php */ ?>

                      <p class="month"><?php echo $activity_log['date']; ?></p>

                    </div>

                    <div class="message_wrapper">

                      <h4 class="heading"><?php echo $activity_log['rel_type']; ?></h4>

                      <blockquote class="message"><?php echo $activity_log['description']; ?></blockquote>

                      <br />

                      <p class="url">                   

                        <a href="#"><i class="fa fa-paperclip"></i>  </a>

                      </p>

                    </div>

                </li>

              <?php
            }
        }
    }
    /* Function to fetch all the CRM dashboard data with or without month-year range */
    public function userActivityGraphData() {
        //$userActivityGraphData = userActivityGraphData($_POST['userid']);
        if (isset($_POST["userid"])) {
            $userActivityGraphData = getActivityLogGraphData($_POST['userid']);
            echo json_encode($userActivityGraphData);
        }
    }
    /*public function uploadImageByAjax(){
    
    if(isset($_POST["image"])){
    
    $data = $_POST["image"];
    
    $image_array_1 = explode(";", $data);
    
    $image_array_2 = explode(",", $image_array_1[1]);
    
    $data = base64_decode($image_array_2[1]);
    
    $exp=explode('.', $_POST["uploaded_image_name"]);
    
    $imageName = $exp[0].'_'.time().".".$exp[1];
    
    file_put_contents('assets/modules/users/uploads/'.$imageName, $data);
    
    $result = array('image' => $imageName,'imageHtml'=>'<img src="'.base_url().'assets/modules/users/uploads/'.$imageName.'" class="img-thumbnail" />');
    
    echo json_encode($result);
    
    }
    
    }*/
    public function uploadImageByAjax() {
        if (isset($_POST["image"])) {
            $data = $_POST["image"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $exp = explode('.', $_POST["uploaded_image_name"]);
            $activityUserData = getNameById('user_detail', $_POST["user_id"], 'u_id');
            $nameChar = substr($activityUserData->name, 0, 3);
            $oldImage = $activityUserData->user_profile;
            $imageName = $exp[0] . '_user_' . $nameChar . '_' . time() . "." . $exp[1];
            file_put_contents('assets/modules/hrm/uploads/' . $imageName, $data);
            $success = $this->hrm_model->updateUserProfile('user_detail', array('user_profile' => $imageName), 'u_id', $_POST["user_id"]);
            if ($oldImage != '') {
                unlink('assets/modules/hrm/uploads/' . $oldImage);
            }
            $result = array('image' => $imageName, 'imageHtml' => '<img src="' . base_url() . 'assets/modules/hrm/uploads/' . $imageName . '" class="img-thumbnail" />');
            echo json_encode($result);
        }
    }
    /*Work Detail index page*/
    public function work_detail() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('Work Details', base_url() . 'work_detail');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Work Detail';
        $where = array('created_by_cid' => $this->companyGroupId);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "job_name like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('work_detail', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/work_detail/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['work_detail'] = $this->hrm_model->get_usr_data('work_detail', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        //$this->data['work_detail']     = $this->hrm_model->get_data('work_detail', $where);
        $this->_render_template('work_detail/index', $this->data);
    }
    /* Edit Work Edit*/
    public function editworkdetails() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['work_detail'] = $this->hrm_model->get_data_byId('work_detail', 'id', $id);
        $this->data['users1'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
        $this->load->view('work_detail/edit', $this->data);
    }
    public function viewworkdetails() {
        $id = $_POST['id'];
        if ($id == '') {
            redirect(base_url() . 'hrm/task_list');
        } else {
            $this->data['work_detail'] = $this->hrm_model->get_data_byId('work_detail', 'id', $id);
            $this->load->view('work_detail/view', $this->data);
        }
    }
    public function saveWorkdetail() {
        if ($this->input->post()) {
            $required_fields = array('');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                $data['npdm_id'] = $_POST['npdm_name'];
                $data['work_status'] = $_POST['work_status'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 115));
                //pre($data);die;
                if ($id && $id != '') {
                    //$processType = $this->production_model->processTypeExist($_POST['process_type'], 'update');
                    //if($processType){
                    //}else{
                    $success = $this->hrm_model->update_data('work_detail', $data, 'id', $id);
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
                        redirect(base_url() . 'hrm/work_detail', 'refresh');
                    }
                } else {
                    $id = $this->hrm_model->insert_tbl_data('work_detail', $data);
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
                        redirect(base_url() . 'hrm/work_detail', 'refresh');
                    }
                }
            }
        }
    }
    public function deleteWorkdetail($id = '') {
        if (!$id) {
            redirect('hrm/work_detail', 'refresh');
        }
        $result = $this->hrm_model->delete_data('work_detail', 'id', $id);
        if ($result) {
            logActivity('Work Detail Deleted', 'work_detail', $id);
            $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 115));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Work Detail deleted', 'message' => 'Work Detail deleted by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Work Detail deleted', 'message' => 'Work Detail deleted by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id));
            }
            $this->session->set_flashdata('message', 'Work Detail Deleted Successfully');
            $result = array('msg' => 'Work Detail Dleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'hrm/work_detail');
            echo json_encode($result);
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    // For PipeLine Module Start//
    public function changeProcessType() {
        $data = $this->input->post();
        $id = $data['processId'];
        $process_status = $this->hrm_model->change_process_status($data, $id);
        $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 5));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array('subject' => 'Work status updated', 'message' => 'Work status updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'to status' => $data['processTypeId'], 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array('subject' => 'Work status updated', 'message' => 'Work status updated by ' . $_SESSION['loggedInUser']->u_id . '  with id : ' . $id . '', 'to status' => $data['processTypeId'], 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id));
        }
        $this->_render_template('task_list/index', $process_status);
    }
    public function changeOrder() {
        $orders = $_POST['order'];
        //pre($orders);
        $process_order = $this->hrm_model->change_process_order($orders);
        echo json_encode(array('msg' => 'error', 'status' => 'success', 'code' => 'C774'));
    }
    public function task_list() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/users');
        $this->breadcrumb->add('Task List', base_url() . 'hrm/task_list');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Task List';
        $where = array('c_id' => $this->companyGroupId);
        $this->data['user1'] = $this->hrm_model->get_data('user_detail', $where);
        if (isset($_POST['user_id'])) {
            $array = array();
            //$where = array('created_by_cid' =>$this->companyGroupId );
            $this->data['processType'] = $this->hrm_model->get_data('work_status');
            $i = 0;
            foreach ($this->data['processType'] as $ProcessType) {
                $where = array('work_status' => $ProcessType['id']);
                $process = $this->hrm_model->get_data('work_detail', $where);
                $array[$i]['types'] = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }
            $this->data['processdata'] = $array;
            $this->_render_template('task_list/index', $this->data);
        } else {
            $array = array();
            //  $where = array('created_by_cid' =>$this->companyGroupId );
            $this->data['processType'] = $this->hrm_model->get_data('work_status');
            $i = 0;
            foreach ($this->data['processType'] as $ProcessType) {
                $where = array('work_status' => $ProcessType['id']);
                $process = $this->hrm_model->get_data('work_detail', $where);
                $array[$i]['types'] = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }
            $this->data['processdata'] = $array;
            $this->_render_template('task_list/index', $this->data);
        }
    }
    public function checkworkstatus() {
        $work_d = $this->hrm_model->get_data('work_detail');
		// pre($work_d);die();
		foreach ($work_d as $key) {
            if ($key['work_status'] != 4 && $key['work_status'] != 5) {
                $data['work_status'] = '2';
                $data['job_name'] = $key['job_name'];
                $data['work_assigned_to'] = $key['work_assigned_to'];
                $data['work_description'] = $key['work_description'];
                $data['end_date_time'] = $key['end_date_time'];
                $data['created_by'] = $key['created_by'];
                $data['created_by_cid'] = $key['created_by_cid'];
                $data['created_date'] = $key['created_date'];
                $data['updated_date'] = date("Y-m-d H:i:s");
                $data['npdm_id'] = $key['npdm_id'];
                $var = $key['end_date_time'];
				
                if (time() > strtotime($var)) {
				    $success = $this->hrm_model->update_data('work_detail', $data, 'id', $key['id']);
                    echo 'Status Updated';
                } else {
				    echo 'dont update status' . '<br>';
                }
            }
        }
    }
    # Worker Submodule Start
    /*********************************************************Worker information*************************************************/
    /*Main fucntion of worker listing*/
    public function workers() {
        $this->load->library("pagination");
        //pre($_GET);die;
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('worker', base_url() . 'worker');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        #$whereCompany = "(id ='".$_SESSION['loggedInUser']->c_id."')";
        $whereCompany = "(id ='" . $this->companyGroupId . "')";
        $this->data['company_unit_adress'] = $this->hrm_model->get_filter_details('company_detail', $whereCompany);
        $whereActive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1);
        $whereInactive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "worker_type like '%" . strtolower(str_replace(' ', '_', $_GET['search'])) . "%' or name like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        if (isset($_GET['favourites']) && $_GET['favourites'] != '' && isset($_GET['start']) == '' && isset($_GET['end']) == '') {
            if (!empty($_GET['tab']) == 'worker_active' && $_GET['tab'] != 'worker_inactive') {
                #$whereActive = array('worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' =>1 , 'worker.favourite_sts' =>1);
                $whereActive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1, 'worker.favourite_sts' => 1);
            } elseif (!empty($_GET['tab']) == 'worker_inactive' && $_GET['tab'] != 'worker_active') {
                #$whereInactive = array('worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' =>0 , 'worker.favourite_sts' =>1);
                $whereInactive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0, 'worker.favourite_sts' => 1);
            } else {
                $whereActive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1, 'worker.favourite_sts' => 1);
            }
        }
        if (!empty($_GET) && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['company_unit']) == '' && isset($_GET['ExportType']) == '') {
            #$whereActive = array('worker.created_date >=' => $_GET['start'] , 'worker.created_date <=' => $_GET['end'],'worker.created_by_cid'=>$this->companyGroupId ,'worker.active_inactive' => 1 );
            $whereActive = array('worker.created_date >=' => $_GET['start'], 'worker.created_date <=' => $_GET['end'], 'worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1);
            //Get User based on Worker Type
            if (isset($_GET['worker_type'])) {
                $whereActive['worker_type'] = $_GET['worker_type'];
            }
            #$whereInactive = array('worker.created_date >=' => $_GET['start'] , 'worker.created_date <=' => $_GET['end'],'worker.created_by_cid'=>$this->companyGroupId , 'worker.active_inactive' => 0  );
            $whereInactive = array('worker.created_date >=' => $_GET['start'], 'worker.created_date <=' => $_GET['end'], 'worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0);
            if (isset($_GET['worker_type'])) {
                $whereInactive['worker_type'] = $_GET['worker_type'];
            }
        } elseif (!empty($_GET) && isset($_GET['start']) == '' && isset($_GET['end']) == '' && isset($_GET['company_unit']) != '') {
            #$whereActive = array('worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' => 1 ,'worker.company_unit' => $_GET['company_unit']);
            $whereActive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1, 'worker.company_unit' => $_GET['company_unit']);
            //Get User based on Worker Type
            if (isset($_GET['worker_type'])) {
                $whereActive['worker_type'] = $_GET['worker_type'];
            }
            #$whereInactive = array('worker.created_by_cid'=>$this->companyGroupId , 'worker.active_inactive' => 0  ,'worker.company_unit' => $_GET['company_unit']);
            if (isset($_GET['worker_type'])) {
                $whereInactive['worker_type'] = $_GET['worker_type'];
            }
            $whereInactive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0, 'worker.company_unit' => $_GET['company_unit']);
        } elseif (!empty($_GET) && isset($_GET['start']) != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
            #$whereActive = array('worker.created_date >=' => $_GET['start'] , 'worker.created_date <=' => $_GET['end'],'worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' => 1 ,'worker.company_unit' => $_GET['company_unit']);
            $whereActive = array('worker.created_date >=' => $_GET['start'], 'worker.created_date <=' => $_GET['end'], 'worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1, 'worker.company_unit' => $_GET['company_unit']);
            //Get User based on Worker Type
            if (isset($_GET['worker_type'])) {
                $whereActive['worker_type'] = $_GET['worker_type'];
            }
            #$whereInactive = array('worker.created_date >=' => $_GET['start'] , 'worker.created_date <=' => $_GET['end'],'worker.created_by_cid'=>$this->companyGroupId , 'worker.active_inactive' => 0  ,'worker.company_unit' => $_GET['company_unit']);
            $whereInactive = array('worker.created_date >=' => $_GET['start'], 'worker.created_date <=' => $_GET['end'], 'worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0, 'worker.company_unit' => $_GET['company_unit']);
            //Get User based on Worker Type
            if (isset($_GET['worker_type'])) {
                $whereInactive['worker_type'] = $_GET['worker_type'];
            }
        } else {
            #$whereActive = array('worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' =>1);
            $whereActive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1);
            //Get User based on Worker Type
            if (isset($_GET['worker_type'])) {
                $whereActive['worker_type'] = $_GET['worker_type'];
            } #$whereInactive = array('worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' =>0);
            $whereInactive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0);
            //Get User based on Worker Type
            if (isset($_GET['worker_type'])) {
                $whereInactive['worker_type'] = $_GET['worker_type'];
            }
        }
        if (isset($_GET["ExportType"]) && $_GET['start'] == '' && $_GET['end'] == '' && $_GET['company_unit'] == '' && $_GET['company_unit'] == '') {
            #$whereActive = array('worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' => 1 );
            if (!empty($_GET['tab']) == 'worker_active' && $_GET['tab'] != 'worker_inactive') {
                $whereActive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1);
            }
            if (!empty($_GET['tab']) == 'worker_inactive' && $_GET['tab'] != 'worker_active') {
                $whereInactive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0);
            } else {
                $whereActive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1);
            }
        }
        if (isset($_GET['worker_type'])) {
            $whereActive['worker_type'] = $_GET['worker_type'];
            #$whereInactive = array('worker.created_by_cid'=>$this->companyGroupId , 'worker.active_inactive' => 0  );
            $whereInactive = array('worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0);
        } elseif (isset($_GET["ExportType"]) && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] == '') {
            #$whereActive = array('worker.created_date >=' => $_GET['start'] , 'worker.created_date <=' => $_GET['end'],'worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' => 1);
            $whereActive = array('worker.created_date >=' => $_GET['start'], 'worker.created_date <=' => $_GET['end'], 'worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1);
            if (isset($_GET['worker_type'])) {
                $whereActive['worker_type'] = $_GET['worker_type'];
            }
            #$whereInactive = array('worker.created_date >=' => $_GET['start'] , 'worker.created_date <=' => $_GET['end'],'worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' => 0);
            $whereInactive = array('worker.created_date >=' => $_GET['start'], 'worker.created_date <=' => $_GET['end'], 'worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0);
            if (isset($_GET['worker_type'])) {
                $whereInactive['worker_type'] = $_GET['worker_type'];
            }
        } elseif (isset($_GET["ExportType"]) && $_GET['start'] != '' && $_GET['end'] != '' && $_GET['company_unit'] != '') {
            #$whereActive = array('worker.created_date >=' => $_GET['start'] , 'worker.created_date <=' => $_GET['end'],'worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' => 1,'worker.company_unit' => $_GET['company_unit']);
            $whereActive = array('worker.created_date >=' => $_GET['start'], 'worker.created_date <=' => $_GET['end'], 'worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 1, 'worker.company_unit' => $_GET['company_unit']);
            if (isset($_GET['worker_type'])) {
                $whereActive['worker_type'] = $_GET['worker_type'];
            }
            #$whereInactive = array('worker.created_date >=' => $_GET['start'] , 'worker.created_date <=' => $_GET['end'],'worker.created_by_cid'=>$this->companyGroupId  ,'worker.active_inactive' => 0,'worker.company_unit' => $_GET['company_unit']);
            $whereInactive = array('worker.created_date >=' => $_GET['start'], 'worker.created_date <=' => $_GET['end'], 'worker.created_by_cid' => $this->companyGroupId, 'worker.active_inactive' => 0, 'worker.company_unit' => $_GET['company_unit']);
            if (isset($_GET['worker_type'])) {
                $whereInactive['worker_type'] = $_GET['worker_type'];
            }
            //Get Worker Array Based on Worker Type
            
        }
        /*if((isset($_GET["ExportType"]) && $_POST['start'] != '' && $_POST['end'] != ''  && $_POST['company_unit'] =='') || (isset($_POST["ExportType"]) && $_POST['start'] != '' && $_POST['end'] != ''  && $_POST['company_unit'] !='')){
        
            $this->load->view('workers/index', $this->data);
        
            }else{*/
        if (!empty($_GET['tab']) == 'worker_active' && $_GET['tab'] != 'worker_inactive') {
            $rows = $this->hrm_model->num_rows('worker', $whereActive, $where2);
        } elseif (!empty($_GET['tab']) == 'worker_inactive' && $_GET['tab'] != 'worker_active') {
            $rows = $this->hrm_model->num_rows('worker', $whereInactive, $where2);
        } else {
            $rows = $this->hrm_model->num_rows('worker', $whereActive, $where2);
        }
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/workers/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        if (!empty($_GET['tab']) == 'worker_active' && $_GET['tab'] != 'worker_inactive') {
            $this->data['active_workers'] = $this->hrm_model->get_usr_data('worker', $whereActive, $config["per_page"], $page, $where2, $order, $export_data);
        } elseif (!empty($_GET['tab']) == 'worker_inactive' && $_GET['tab'] != 'worker_active') {
            $this->data['inactive_workers'] = $this->hrm_model->get_usr_data('worker', $whereInactive, $config["per_page"], $page, $where2, $order, $export_data);
        } else {
            $this->data['active_workers'] = $this->hrm_model->get_usr_data('worker', $whereActive, $config["per_page"], $page, $where2, $order, $export_data);
            $this->data['inactive_workers'] = $this->hrm_model->get_usr_data('worker', $whereInactive, $config["per_page"], $page, $where2, $order, $export_data);
        }
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        $this->_render_template('workers/index', $this->data);
    }
    //  }
    /*worker add/edit code*/
    public function worker_edit() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
         $productionSettingWhere          = array(
            'production_setting.created_by_cid' => $this->companyGroupId
        );
        $this->data['productionSetting'] = $this->hrm_model->get_data('production_setting', $productionSettingWhere);
        $this->data['workers'] = $this->hrm_model->get_data_byId_wo('worker', 'id', $id);
        $this->load->view('workers/edit', $this->data);
    }
    
   public function saveWorker() {

        if ($this->input->post()) {
            $required_fields = array('name');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                           $total=$this->input->post('salary');
                           $basic= $this->input->post('basic');
                           $basicNewPre=((float)$basic/(float)$total)*100;
                           $da= $this->input->post('da');
                           $daNewPre=((float)$da/(float)$total)*100;
                           $hra= $this->input->post('hra');
                           $hraNewPre=((float)$hra/(float)$total)*100;
                           $ca= $this->input->post('ca');
                           $caNewPre=((float)$ca/(float)$total)*100;
                           $sa= $this->input->post('sa');
                           $saNewPre=((float)$sa/(float)$total)*100;
                           $monthYearedical= $this->input->post('medical');
                           $monthYearedicalNewPre=((float)$monthYearedical/(float)$total)*100;
                           $others= $this->input->post('others');
                           $othersNewPre=((float)$others/(float)$total)*100;
                           $esic= $this->input->post('esic');
                           $esicNewPre=((float)$esic/(float)$total)*100;
                           $tds= $this->input->post('tds');
                           $tdsNewPre=((float)$tds/(float)$total)*100;
                           $pf= $this->input->post('pf');
                           $pfNewPre=((float)$pf/(float)$basic)*100;
                           $lwf= $this->input->post('lwf');
                         //  $lwfNewPre=((float)$lwf/(float)$total)*100;
                           $esic_employer= $this->input->post('esic_employer');
                           $esic_employerNewPre=((float)$esic_employer/(float)$total)*100;
                           $pf_employer= $this->input->post('pf_employer');
                           $pf_employerNewPre=((float)$pf_employer/(float)$basic)*100;
                           $lwf_employer= $this->input->post('lwf_employer');
                           //$lwf_employerNewPre=((float)$lwf_employer/(float)$total)*100;
            
                $slabData = (array(
                         'basic' =>$basicNewPre,
                         'da' =>$daNewPre,
                         'hra' =>$hraNewPre,
                         'ca' =>$caNewPre,
                         'sa' =>$saNewPre,
                         'medical' =>$monthYearedicalNewPre,
                         'others' =>$othersNewPre,
                         'esic' =>$esicNewPre,
                         'tds' =>$tdsNewPre,
                         'pf' =>$pfNewPre,
                         'lwf' =>$lwf,
                         'esic_employer' =>$esic_employerNewPre,
                         'pf_employer' =>$pf_employerNewPre,
                         'lwf_employer' =>$lwf_employer));

                $slabDataInJson=json_encode($slabData);
                $data = $this->input->post();
                $data['workerSlabData']=$slabDataInJson;
                $data['created_by_cid'] = $this->companyGroupId;
                $id = $data['id']; 
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 59));
                if ($id && $id != '') {
                    //pre($data);die;
                    // Update workers
                    $data['edited_by'] = $_SESSION['loggedInUser']->u_id;
                    $data['active_inactive']='1';
                    $success = $this->hrm_model->update_data('worker', $data, 'id', $id);
                    #die;
                    if ($success) {
                        $data['message'] = "Worker Info updated successfully";
                        logActivity('Worker Info Updated', 'worker', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Worker updated' , 'message' => 'Worker updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Worker updated', 'message' => 'Worker id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'hrmTab', 'data_id' => 'workerView', 'icon' => 'fa fa-archive'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*pushNotification(array('subject'=> 'Worker updated' , 'message' => 'Worker updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'Worker updated', 'message' => 'Worker id : #: ' . $id . ' is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'hrmTab', 'data_id' => 'workerView', 'icon' => 'fa fa-archive'));
                        }
                        $this->session->set_flashdata('message', 'Worker info  Updated successfully');
                        redirect(base_url() . 'hrm/workers', 'refresh');
                    }
                } else {
                    $data['active_inactive']='1'; 
					// pre($data);die();
                    $id = $this->hrm_model->insert_tbl_data('worker', $data);
                    if ($id) {
                        logActivity('Worker Info Added ', 'worker', $id);
                        if (!empty($usersWithViewPermissions)) {
                            foreach ($usersWithViewPermissions as $userViewPermission) {
                                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                    /*pushNotification(array('subject'=> 'Worker created' , 'message' => 'Worker created by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id));*/
                                    pushNotification(array('subject' => 'Worker Created', 'message' => 'New Worker is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'class' => 'hrmTab', 'data_id' => 'workerView', 'icon' => 'fa fa-archive'));
                                }
                            }
                        }
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'Worker Created', 'message' => 'New Worker is created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'hrmTab', 'data_id' => 'workerView', 'icon' => 'fa fa-archive'));
                        }
                        $this->session->set_flashdata('message', 'Worker Info Added successfully');
                        redirect(base_url() . 'hrm/workers', 'refresh');
                    }
                }
            }
        }
    }
    /*Worker view code*/
    public function worker_view() {
        permissions_redirect('is_view');
        $id = $_POST['id'];
        $this->data['workerView'] = $this->hrm_model->get_data_byId('worker', 'id', $id);
        $this->load->view('workers/view', $this->data);
    }
    public function workers_pms($user_id = NULL) {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('worker PMS', base_url() . 'worker');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $array = array();
        $bb = "'";
        $cc = "'";
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/pms/";
        $config["total_rows"] = $this->hrm_model->num_rows('production_data', 'created_by_cid = ' . $this->companyGroupId, '`production_data` LIKE ' . $bb . '%\"worker_id\":[[\"' . $user_id . '\"]]%' . $cc . '');
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
        //  pre($config);die;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        #$whereCompany = "(id ='".$_SESSION['loggedInUser']->c_id."')";
        $whereCompany = "(id ='" . $this->companyGroupId . "')";
        $this->data['company_unit_adress'] = $this->hrm_model->get_filter_details('company_detail', $whereCompany);
        $this->data['workerView'] = $this->hrm_model->get_data_byId('worker', 'id', $user_id);
        # $this->data['productionData']      = $this->hrm_model->get_production($_SESSION['loggedInUser']->c_id, $user_id);
        $this->data['productionData'] = $this->hrm_model->get_production($this->companyGroupId, $user_id);
        # pre($this->data['productionData'] );die;
        $this->_render_template('pms/index', $this->data);
        //  }
        
    }
    /*delete worker*/
    public function deleteWorker($id = '') {
        if (!$id) {
            redirect('hrm/workers', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->hrm_model->delete_data('worker', 'id', $id);
        if ($result) {
            logActivity('Worker  Deleted', 'worker', $id);
            $this->session->set_flashdata('message', 'worker Deleted Successfully');
            $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 59));
            if (!empty($usersWithViewPermissions)) {
                foreach ($usersWithViewPermissions as $userViewPermission) {
                    if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                        pushNotification(array('subject' => 'Worker deleted', 'message' => 'Worker id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-archive'));
                    }
                }
            }
            if ($_SESSION['loggedInUser']->role != 1) {
                pushNotification(array('subject' => 'Worker deleted', 'message' => 'Worker id : #' . $id . ' is deleted by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-archive'));
            }
            $result = array('msg' => 'Worker Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'hrm/workers');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    /**********active inactive status of worker ****************/
    public function change_status_worker() {
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['workerStatus']) && $_POST['workerStatus'] == 1) ? '1' : '0';
        $status_data = $this->hrm_model->toggle_change_status($id, $status);
        $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 59));
        if (!empty($usersWithViewPermissions)) {
            foreach ($usersWithViewPermissions as $userViewPermission) {
                if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                    pushNotification(array('subject' => 'Worker Status Changed', 'message' => 'Worker Status id : #' . $id . ' is changed by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $id, 'icon' => 'fa fa-archive'));
                }
            }
        }
        if ($_SESSION['loggedInUser']->role != 1) {
            pushNotification(array('subject' => 'Worker Status Changed', 'message' => 'Worker Status id : #' . $id . ' is changed by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'icon' => 'fa fa-archive'));
        }
        echo json_encode($status_data);
    }
    # For Worker
    function getcompany_unit() {
        //$where = array('u_id' => $_SESSION['loggedInUser']->u_id);
        #$where = array('id' =>$this->companyGroupId );
        $where = array('id' => $this->companyId);
        $data = $this->hrm_model->get_data_byAddress('company_detail', $where);
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
    /*Employees Attendance Submodule Started*/
    // public function Attendance() {
    //     $this->load->library('pagination');
    //     $this->data['can_edit'] = edit_permissions();
    //     $this->data['can_delete'] = delete_permissions();
    //     $this->data['can_add'] = add_permissions();
    //     $this->data['can_view'] = view_permissions();
    //     $this->breadcrumb->add('HRM', base_url() . 'hrm/Attendance');
    //     $this->breadcrumb->add('Attendance', base_url() . 'hrm/Attendance');
    //     $this->settings['breadcrumbs'] = $this->breadcrumb->output();
    //     $this->settings['pageTitle'] = 'Attendance';
    //     $where = '  attendance.created_by_cid = ' . $this->companyGroupId;
    //     $latest_updated = $this->hrm_model->get_latest_updated_record($where);
    //      $where = ' attendance.created_by_cid = ' . $this->companyGroupId . ' AND  attendance.created_date = "' . $latest_updated->latest_updated .'"';  
    //     // $this->data['termsconds']      = $this->hrm_model->get_data('hrm_terms', array('created_by_cid' =>$this->companyGroupId ));
    //     $where2 = '';
    //     if (isset($_GET['search']) && $_GET['search'] != '') {
    //         $EmpName = getNameBySearch('user_detail', $_GET['search'], 'name');
    //         $where2 = array();
    //         foreach ($EmpName as $name) { //pre($name['id']);
    //             $where2[] = "attendance.emp_id ='" . $name['u_id'] . "'";
    //         }
    //         if (sizeof($where2) != '') {
    //             $where2 = implode("||", $where2);
    //         } else {
    //             $where2 = "attendance.emp_id = '" . $_GET['search'] . "'";
    //         }
    //     }
    //     if (!empty($_POST['order'])) {
    //         $order = $_POST['order'];
    //     } else {
    //         $order = "desc";
    //     }
    //     //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
    //     #pre($this->data['application']);
    //     $rows = $this->hrm_model->num_rows('attendance', $where, $where2);
    //     //Pagination
    //     $config = array();
    //     $config["base_url"] = base_url() . "hrm/Attendance/";
    //     $config["total_rows"] = $rows;
    //     $config["per_page"] = 10;
    //     $config["uri_segment"] = 3;
    //     $config['reuse_query_string'] = true;
    //     $config["use_page_numbers"] = TRUE;
    //     $config['full_tag_open'] = '<ul class="pagination">';
    //     $config['full_tag_close'] = '</ul><!--pagination-->';
    //     $config['first_link'] = '&laquo; First';
    //     $config['first_tag_open'] = '<li class="prev page">';
    //     $config['first_tag_close'] = '</li>';
    //     $config['last_link'] = 'Last &raquo;';
    //     $config['last_tag_open'] = '<li class="next page">';
    //     $config['last_tag_close'] = '</li>';
    //     $config['next_link'] = 'Next &rarr;';
    //     $config['next_tag_open'] = '<li class="next page">';
    //     $config['next_tag_close'] = '</li>';
    //     $config['next_tag_close'] = '</li>';
    //     $config['prev_link'] = '&larr; Previous';
    //     $config['prev_tag_open'] = '<li class="prev page">';
    //     $config['prev_tag_close'] = '</li>';
    //     $config['cur_tag_open'] = '<li class="active"><a href="">';
    //     $config['cur_tag_close'] = '</a></li>';
    //     $config['num_tag_open'] = '<li class="page">';
    //     $config['num_tag_close'] = '</li>';
    //     $config['anchor_class'] = 'follow_link';
    //     $this->pagination->initialize($config);
    //     $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
    //     if (!empty($_GET['ExportType'])) {
    //         $export_data = 1;
    //     } else {
    //         $export_data = 0;
    //     }
    //     $this->data['attendancelist'] = $this->hrm_model->getAllAttendance('attendance', $where, $config["per_page"], $page, $where2, $order, $export_data);
    //     pre($this->data['attendancelist']);
    //     if (!empty($this->uri->segment(3))) {
    //         $frt = (int)$this->uri->segment(3) - 1;
    //         $start = $frt * $config['per_page'] + 1;
    //     } else {
    //         $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
    //     }
    //     if (!empty($this->uri->segment(3))) {
    //         $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
    //     } else {
    //         $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
    //     }
    //     if ($end > $config['total_rows']) {
    //         $total = $config['total_rows'];
    //     } else {
    //         $total = $end;
    //     }
    //     $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
    //     //$this->data['attendancelist']  = $this->hrm_model->getAllAttendance($where);
    //     # pre($this->data['attendancelist']);die;
    //     $this->_render_template('attendance/index', $this->data);
    // }
    public function Attendance() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add(' Attendance', base_url() . 'hrm/Attendance');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = ' Attendance';
        $where = ' attendance.created_by_cid = ' . $this->companyGroupId;
        // $this->data['termsconds']      = $this->hrm_model->get_data('hrm_terms', array('created_by_cid' =>$this->companyGroupId ));
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
              
            $EmpName = getNameBySearch('user_detail', $_GET['search'], 'name');

            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "attendance.emp_id ='" . $name['u_id'] . "'";
            }  
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "attendance.emp_id='" . $_GET['search'] . "'";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('attendance', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/Attendance/";
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

        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['attendancelist'] = $this->hrm_model->getAllAttendance('attendance', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        /*$this->data['attendancelist']  = $this->hrm_model->getAllAttendanceWork($where);*/
        $this->_render_template('attendance/index', $this->data);
    }
    // For Editing Attendance
    public function attendance_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->hrm_model->get_data('user_detail');
        $this->data['attval'] = $this->hrm_model->get_data_byId('attendance', 'id', $this->input->post('id'));
        $this->data['users1'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
        $this->load->view('attendance/add_attendance', $this->data);
    }
    public function checkLeave(){
           $em_ids = $this->input->post('emid');
           $startdate = $this->input->post('attdate');
           $where= "('{$startdate}' between start_date AND end_date) AND em_id = {$em_ids}";   
           $employeeData  = $this->hrm_model->get_worker_data('emp_leave',$where);
           if($employeeData){
                $startDate='';
                $endDate='';
                foreach ($employeeData as $key => $leaveData) {  
                   $startDate=$leaveData['start_date'];
                   $endDate=$leaveData['end_date'];
                } 
              echo json_encode(['start_date' =>$startDate,'end_date'=>$endDate ]);
           }else{
            echo '2';
           }
    }
    public function checkWorkerLeave(){
           $em_ids = $this->input->post('emid');
           $startdate = $this->input->post('attdate');
           $where= "('{$startdate}' between start_date AND end_date) AND em_id = {$em_ids}";   
           $employeeData  = $this->hrm_model->get_worker_data('work_leave',$where);
           if($employeeData){
                $startDate='';
                $endDate='';
                foreach ($employeeData as $key => $leaveData) {  
                   $startDate=$leaveData['start_date'];
                   $endDate=$leaveData['end_date'];
                } 
              echo json_encode(['start_date' =>$startDate,'end_date'=>$endDate ]);
           }else{
            echo '2';
        }
    }
   public function saveAttendance() { 
            if ($this->input->post()) {
            $where = array('created_by_cid' => $this->companyGroupId);
            $required_fields = array('emid', 'attdate',  'status');
            $id = $this->input->post('id');
            $em_id = $this->input->post('emid');
            $emp_code = getNameById('user_detail', $em_id, 'u_id');
            $biometric_id = @$emp_code->biometric_id;
            $attdate = $this->input->post('attdate');
            $signin = $this->input->post('signin');
            $signout = $this->input->post('signout');
            $place = $this->input->post('place');
            $status = $this->input->post('status');
            $old_date = $_POST['attdate']; // returns Saturday, January 30 10 02:06:34
            $old_date_timestamp = strtotime($old_date);
            $new_date = date('m/d/Y', $old_date_timestamp);
            $where = ' AND created_by_cid = ' . $this->companyGroupId;
            $where1 = ' created_by_cid = ' . $this->companyGroupId;
            $new_date_changed = date('Y-m-d', strtotime(str_replace('-', '/', $new_date)));
            $is_valid = validate_fields($_POST, $required_fields);
         
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $sin = new DateTime($new_date . $_POST['signin']);
                $sout = new DateTime($new_date . $_POST['signout']);
                $hour = $sin->diff($sout);
                $work = $hour->format('%H h %i m'); 
                 
                if (empty($id)) {
                    $day = date("D", strtotime($new_date_changed));
                      
                    if ($day == "Fri") { 
                        $duplicate = $this->hrm_model->getDuplicateVal($em_id, $new_date_changed, $where);
                         if (!empty($duplicate)) {
                            $this->session->set_flashdata('message', 'Already Exist');
                            redirect(base_url() . 'hrm/Attendance', 'refresh');
                        } else {
                            $where24 = 'AND c_id =' . $this->companyGroupId;
                            $emcode = $this->hrm_model->emselectByCode($em_id, $where24);
                            $emid = $emcode->id;
                            $earnval = $this->hrm_model->emEarnselectByLeave($emid, $where1);
                            $data = array();
                            $data = array('present_date' => $earnval->present_date + 1, 'hour' => $earnval->hour + 480, 'status' => '1');
                            $success = $this->hrm_model->UpdteEarnValue($emid, $data);
                            $data = array();
                            $data = array('emp_id' => $em_id, 'atten_date' => $new_date_changed, 'signin_time' => $signin, 'signout_time' => $signout, 'working_hour' => $work, 'place' => $place, 'status' => $status, 'created_by_cid' => $this->companyGroupId);
                            logActivity('Attendance Updated Successfully', 'attendance', $id);
                            $success = $this->hrm_model->Add_AttendanceData($data);
                              
                            $this->session->set_flashdata('message', 'Successfully Updated');
                            redirect(base_url() . 'hrm/Attendance', 'refresh');
                        }
                    } elseif ($day != "Fri") {
                        $holiday = $this->hrm_model->get_holiday_between_dates($new_date_changed, $where);
                        if ($holiday) { 
                            $duplicate = $this->hrm_model->getDuplicateVal($em_id, $new_date_changed, $where);
                            //print_r($duplicate);
                            if (!empty($duplicate)) {
                                $this->session->set_flashdata('message', 'Already Exist');
                            } else {
                                $where24 = 'AND c_id =' . $this->companyGroupId;
                                $emcode = $this->hrm_model->emselectByCode($em_id, $where24);
                                $emid = $emcode->id;
                                $earnval = $this->hrm_model->emEarnselectByLeave($emid, $where);
                                $data = array();
                                $data = array('present_date' => $earnval->present_date + 1, 'hour' => $earnval->hour + 480, 'status' => '1');
                                $success = $this->hrm_model->UpdteEarnValue($emid, $data);
                                $data = array();
                                $data = array('emp_id' => $em_id, 'atten_date' => $new_date_changed, 'signin_time' => $signin, 'signout_time' => $signout, 'working_hour' => $work, 'place' => $place, 'status' => $status, 'created_by_cid' => $this->companyGroupId);
                                $ri = $this->hrm_model->Add_AttendanceData($data);
                                
                                logActivity('Attendance Added Successfully', 'attendance', $ri);
                                $this->session->set_flashdata('message', 'Successfully Added');
                                redirect(base_url() . 'hrm/Attendance', 'refresh');
                            }
                        } else {
                            $duplicate = $this->hrm_model->getDuplicateVal($em_id, $new_date_changed, $where);
                              
                            if (!empty($duplicate)) {
                                $this->session->set_flashdata('message', 'Already Exist');
                                redirect(base_url() . 'hrm/Attendance', 'refresh');
                            } else {
                                //$date = date('Y-m-d', $i);
                                $data = array();
                                $data = array('emp_id' => $em_id, 'biometric_id' => $biometric_id, 'atten_date' => $new_date_changed, 'signin_time' => $signin, 'signout_time' => $signout, 'working_hour' => $work, 'place' => $place, 'status' => $status, 'created_by_cid' => $this->companyGroupId);
                                $rt = $this->hrm_model->Add_AttendanceData($data);
                                
                                logActivity('Attendance Added Successfully', 'attendance', $rt);
                                $this->session->set_flashdata('message', 'Successfully Added');
                                redirect(base_url() . 'hrm/Attendance', 'refresh');
                            }
                        }
                    }
                } else {
                    $data = array();
                    $data = array('atten_date' => $attdate, 'signin_time' => $signin, 'signout_time' => $signout, 'working_hour' => $work, 'place' => $place, 'status' => $status, 'created_by_cid' => $this->companyGroupId);
                   
                    $this->hrm_model->Update_AttendanceData($id, $data);
                    logActivity('Attendance Updated Successfully', 'attendance', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect(base_url() . 'hrm/Attendance', 'refresh');
                }
            }
        }else{
            redirect(base_url() . 'hrm/Attendance', 'refresh');
      
   }
 }
    #Leave Sub-module start
    public function holiday() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Holiday List', base_url() . 'hrm/holiday');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Holiday List';
        $where = 'holiday.created_by_cid = ' . $this->companyGroupId;
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "holiday_name like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('holiday', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/holiday/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['holidays'] = $this->hrm_model->GetAllHoliInfo('holiday', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        $this->_render_template('holiday/index', $this->data);
    }
    // For Editing Attendance
    public function holidayedit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->hrm_model->get_data('user_detail');
        $this->data['holiday'] = $this->hrm_model->get_data_byId('holiday', 'id', $this->input->post('id'));
        $this->load->view('holiday/add', $this->data);
    }
    public function saveHolidays() {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('holiname');
            $sdate = $this->input->post('startdate');
            $edate = $this->input->post('enddate');
            $required_fields = array('holiname', 'startdate', 'enddate');
            if (empty($edate)) {
                $nofdate = '1';
                //die($nofdate);
                
            } else {
                $date1 = new DateTime($sdate);
                $date2 = new DateTime($edate);
                $diff = date_diff($date1, $date2);
                $nofdate = $diff->format("%a");
                $nofdate = $nofdate + 1;
            }
            $year = date('m-Y', strtotime($sdate));
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = array();
                $data = array('holiday_name' => $name, 'from_date' => $sdate, 'to_date' => $edate, 'number_of_days' => $nofdate, 'year' => $year, 'created_by_cid' => $this->companyGroupId);
                if ($this->input->post('id') == '') {
                    $success = $this->hrm_model->Add_HolidayInfo($data);
                    logActivity('Holiday Inserted Successfully', 'holiday', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect("hrm/holiday");
                    echo "Successfully Added";
                } else {
                    $success = $this->hrm_model->Update_HolidayInfo($id, $data);
                    logActivity('Holiday Updated Successfully', 'holiday', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect("hrm/holiday");
                    echo "Successfully Updated";
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function deleteHoliday($id = '') {
        if (!$id) {
            redirect('hrm/holiday', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->hrm_model->delete_data('holiday', 'id', $id);
        if ($result) {
            logActivity('Holiday Deleted', 'holiday', $id);
            $this->session->set_flashdata('message', 'Holiday Deleted Successfully');
            /*$usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 59));
            
            
            
            if(!empty($usersWithViewPermissions)){
            
            foreach($usersWithViewPermissions as $userViewPermission){
            
            if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){
            
            pushNotification(array('subject'=> 'Worker deleted' , 'message' => 'Worker id : #'.$id.' is deleted by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id,'icon'=>'fa fa-archive'));
            
            }
            
            }
            
            }
            
            if($_SESSION['loggedInUser']->role !=1){
            
            pushNotification(array('subject'=> 'Worker deleted' , 'message' => 'Worker id : #'.$id.' is deleted by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id,'icon'=>'fa fa-archive'));
            
            }   */
            $result = array('msg' => 'Holiday Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'hrm/holiday');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    public function leave_type() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Leave Type', base_url() . 'hrm/Leave Type');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Leave Type';
        $where = array('created_by_cid' => $this->companyGroupId);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "name like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('leave_types', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/leave_type/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['leavetypes'] = $this->hrm_model->get_usr_data('leave_types', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        // $this->data['leavetypes']      = $this->hrm_model->get_data('leave_types', $where);
        $this->_render_template('leave_type/index', $this->data);
    }
    public function leave_type_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->hrm_model->get_data('user_detail');
        $this->data['leavetype'] = $this->hrm_model->get_data_byId_wo('leave_types', 'id', $this->input->post('id'));
        $this->load->view('leave_type/add', $this->data);
    }
    public function leave_type_view() {
        $this->data['users'] = $this->hrm_model->get_data('user_detail');
        $this->data['leavetype'] = $this->hrm_model->get_data_byId_wo('leave_types', 'id', $this->input->post('id'));
        $this->load->view('leave_type/view', $this->data);
    }
    public function delete_leave_type() {
        $id = $this->uri->segment(3);
        $this->hrm_model->delete_data('leave_types', 'id', $id);
        $this->emp_leave_bal($id, '0', 'delete', '0');
        $this->session->set_flashdata('message', 'Leave Deleted successfully');
        redirect(base_url() . 'hrm/leave_type', 'refresh');
    }
    public function saveLeavetype() {
        if ($this->input->post()) {
            $required_fields = array('leavename');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                #$data['created_by']     = '13';
                $data['created_by_cid'] = $this->companyGroupId;
                $id = $leave_id = $data['id'];
                $name = $data['name'];
                $leave_day = $data['leave_day'];
                $leave_status = $data['status'];
                @$automatically_assign_leave = $data['automatically_assign_leave'];
                $status = "";
                if ($id && $id != '') {
                    if ($automatically_assign_leave == '1') {
                        $status = "insert";
                        $this->emp_leave_bal($id, $leave_day, $status, $leave_status);
                    }
                    $status = "update";
                    $this->emp_leave_bal($id, $leave_day, $status, $leave_status);
                    unset($data['name']);
                    $success = $this->hrm_model->Update_leave_Info($id, $data);
                    if ($success) {
                        $data['message'] = "Worker Info updated successfully";
                        logActivity('Leave Type Updated', 'leave_type', $id);
                        $this->session->set_flashdata('message', 'Leave Type  Updated successfully');
                        redirect('hrm/leave_type', 'refresh');
                    }
                } else {
                    $table = "leave_types";
                    $check = $this->hrm_model->check_duplicate($name, $table, $this->companyGroupId);
                    if ($check > 0) {
                        $this->session->set_flashdata('message', 'Duplicate Leave Found ');
                        redirect('hrm/leave_type', 'refresh');
                    } else {
                        $id = $this->hrm_model->Add_leave_Info($data);
                        if ($automatically_assign_leave == '1') {
                            $status = "insert";
                            $this->emp_leave_bal($id, $leave_day, $status, $leave_status);
                        }
                        if ($id) {
                            logActivity('Leave Type Added ', 'leave_type', $id);
                            $this->session->set_flashdata('message', 'Leave Type Added successfully');
                            redirect('hrm/leave_type', 'refresh');
                        }
                    }
                }
            }
        }
    }
    public function emp_leave_bal($leave_id, $leave_day, $status, $leave_status) {
        $users = $this->hrm_model->get_user_data($this->companyGroupId);
        $data = global_variable_hrm();
        if ($status == "insert") {
            foreach ($users as $val) {
                $data['emp_id'] = $val['id'];
                $data['leave_id'] = $leave_id;
                $data['status'] = $leave_status;
                $data['opening_bal'] = $leave_day;
                $data['closing_bal'] = $leave_day;
                $data['start_date'] = $data['start_date'];
                $data['end_date'] = $data['end_date'];
                # $  $data['created_by'] =  $_SESSION['loggedInUser']->u_id;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $this->hrm_model->add_emp_leave($data);
            }
        }
        if ($status == "update") {
            $data['status'] = $leave_status;
            $data['opening_bal'] = $leave_day;
            $data['closing_bal'] = $leave_day;
            $this->hrm_model->Update_emp_leave($leave_id, $data);
        }
        if ($status == "delete") {
            $this->hrm_model->delete_data('emp_leave_bal', 'leave_id', $leave_id);
        }
    }
    public function leave_application() {

        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Leave Application', base_url() . 'hrm/Leave Application');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Leave Application';
        $companyApproveUsers = json_decode(getSingleAndWhere('hrm_approve_users','company_detail',['id' => $this->companyGroupId ]),true );
        $where = 'leave_types.created_by_cid = ' . $this->companyGroupId;
          $options = [];
         // $where1 = 'emp_leave.created_by_cid = ' . $this->companyGroupId;
        // $where1 = 'emp_leave.em_id = ' .$_SESSION['loggedInUser']->id;
        $where1=''; 
       if ($_SESSION['loggedInUser']->role==1) {
       
            $where1 = array('emp_leave.created_by_cid' =>$this->companyGroupId);
        }elseif($_SESSION['loggedInUser']->hr_permissions==1 && $_SESSION['loggedInUser']->role==2) {
            
            $where1 = array('emp_leave.created_by_cid' =>$this->companyGroupId);
        }elseif($_SESSION['loggedInUser']->role==2 && $_SESSION['loggedInUser']->hr_permissions==0){
              
         
       if(checkPurchaseApprove()){
          if( $companyApproveUsers ){
         foreach ($companyApproveUsers as $compuser){ 
             if (in_array($_SESSION['loggedInUser']->id, $compuser)) {
                $where1 = array('emp_leave.created_by_cid' =>$this->companyGroupId); 
               goto end;
                  
            }else{ 
                $where1 = array('emp_leave.created_by_cid' =>$this->companyGroupId,'emp_leave.em_id' =>$_SESSION['loggedInUser']->id );
             }
            }  
          }
         } else{
                $where1 = array('emp_leave.created_by_cid' =>$this->companyGroupId,'emp_leave.em_id' =>$_SESSION['loggedInUser']->id );
        } 
       }     
       end: 
         $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $EmpName = getNameBySearch('user_detail', $_GET['search'], 'name');
            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "emp_leave.em_id ='" . $name['u_id'] . "'";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']); 
        $rows = $this->hrm_model->num_rows('emp_leave', $where1, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/leave_application/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
         
        $this->data['leavetiypes'] = $this->hrm_model->GetleavetypeInfo('leave_types', $where, $config["per_page"], $page, '', $order, $export_data);
        $this->data['application'] = $this->hrm_model->AllLeaveAPPlication('emp_leave', $where1, $config["per_page"], $page, $where2, $order, $export_data);
        /// pre($this->data['application'] ); die; //$_SESSION['loggedInUser']
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        /*$where22                       = 'emp_leave.created_by_cid = ' .$this->companyGroupId ;
        
        $this->data['leavetypes']      = $this->hrm_model->GetleavetypeInfo($where);
        
        $this->data['application']     = $this->hrm_model->AllLeaveAPPlication($where22);
        
        */
        $this->data['approve_by']=$companyApproveUsers;
        $this->_render_template('leave_application/index', $this->data);
    }
    public function leave_application_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->hrm_model->get_data('user_detail');
        $this->data['empleave'] = $this->hrm_model->get_data_byId_wo('emp_leave', 'id', $this->input->post('id'));
         //$this->data['users1'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
        $this->data['users1'] = $this->hrm_model->get_data_byId_wo('user_detail','u_id', $_SESSION['loggedInUser']->id);
      // pre($this->data['users1']); die;
        $this->load->view('leave_application/add', $this->data);
    }
    public function CancelLeaveApp() {
        $id = $_POST['id'];
        $data = array('leave_status' => 'Cancel');
        $this->hrm_model->update_data_details('emp_leave', $data, 'id', $id);
        $this->session->set_flashdata('message', 'Leave Application Cancelled');
        $all_email = $this->get_email_data_admin_hr();
        //pre($all_email);die;
        // PHPMailer object
        $this->load->library('phpmailer_lib');
        $monthYearail = $this->phpmailer_lib->load();
        //Server settings
        $monthYearail->SMTPDebug = 0;
        $monthYearail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)); // Enable verbose debug output
        $monthYearail->Subject = 'Leave Cancelled';
        $monthYearail->isSMTP(); // Send using SMTP
        $monthYearail->Host = 'email-smtp.ap-south-1.amazonaws.com'; // Set the SMTP server to send through
        $monthYearail->SMTPAuth = true; // Enable SMTP authentication
        $monthYearail->Username = 'AKIAZB4WVENV5X4RKVMF'; // SMTP username
        $monthYearail->Password = 'BBOBZRx1LIjwa56GWzgM0e8X9JAfCZ6Rr7ldVOcGHHRk'; // SMTP password
        $monthYearail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $monthYearail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        //Recipients
        $monthYearail->setFrom('dev@lastingerp.com', 'Lasting ERP');
        //$monthYearail->addAddress('varsha@lastingerp.com');
        for ($i = 0;$i < count($all_email);$i++) {
            $monthYearail->addAddress($all_email[$i], ''); // Add a recipient
            
        }
        // $monthYearail->addAddress($email, ''); // Add a recipient
        // Content
        $monthYearail->isHTML(true);
        // Email body content
        $monthYearail->Body = 'Leave Cancelled';
        #$monthYearail->ClearAllRecipients();
        $monthYearail->send();
        redirect('hrm/leave_application', 'refresh');
    }
    public function LeaveAssign() {
        $where34 = 'AND assign_leave.created_by_cid = ' . $this->companyGroupId;
        $where35 = 'AND leave_types.created_by_cid = ' . $this->companyGroupId;
        $employeeID = $_POST["employeeID"];
        $leaveID = $_POST["leaveTypeID"];
        #if (!empty($leaveID)) {
        $year = date('Y');
        $daysTaken = $this->hrm_model->GetemassignLeaveType($employeeID, $leaveID, $year, $where34);
        //die($daysTaken->hour);
        $leavetypes = $this->hrm_model->GetleavetypeInfoid($leaveID, $where35);
        #pre($leavetypes);
        if (empty($daysTaken->hour)) {
            $daysTakenval = '0';
        } else {
            $daysTakenval = $daysTaken->hour / 8;
        }
        if ($leaveID == '5') {
            $earnTaken = $this->hrm_model->emEarnselectByLeave($employeeID);
            $totalday = 'Earned Balance: ' . ($earnTaken->hour / 8) . ' Days';
            echo $totalday;
        } else {
            //$totalday   = $leavetypes->leave_day . '/' . ($daysTaken/8);
            $totalday = 'Leave Balance: ' . ($leavetypes->leave_day - $daysTakenval) . ' Days Of ' . $leavetypes->leave_day;
            echo $totalday;
        }
        /* $daysTaken = $this->leave_model->GetemassignLeaveType('Sah1804', 2, 2018);
        
        $leavetypes = $this->leave_model->GetleavetypeInfoid($leaveID);
        
        // $totalday   = $leavetypes->leave_day . '/' . $daysTaken['0']->day;
        
        echo $daysTaken['0']->day;
        
        echo $leavetypes->leave_day;*/
        # } else {
        #echo "Something wrong.";
        #}
        
    }
    public function save_Applications() {
         
        if ($this->input->post()) {
             $required_fields = array('id');
            $id = $this->input->post('id');
            $emid = $this->input->post('emid');
            $typeid = $this->input->post('typeid');
            $applydate = date('Y-m-d');
            $appstartdate = $this->input->post('startdate');
            $appenddate = $this->input->post('enddate');
            $send_email = $this->input->post('send_email');
            $leave_duration = $this->input->post('leave_duration');
            #   $hourAmount      = $this->input->post('hourAmount');
            $reason = $this->input->post('reason');
            $type = $this->input->post('type');
            $monthYearail= json_encode($_POST['mail_id']); 
             $send_email_data[] = $emid;
            $send_email_data[] = $appstartdate;
            $send_email_data[] = $appenddate;
            $send_email_data[] = $leave_duration;
            $send_email_data[] = $reason;
            $send_email_data[] = $applydate;
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = array();
                $data = array('em_id' => $emid, 'typeid' => $typeid, 'apply_date' => $applydate, 'start_date' => $appstartdate, 'end_date' => $appenddate, 'reason' => $reason, 'leave_type' => $type, 'leave_duration' => $leave_duration, 'leave_status' => 'Not Approve', 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId,'mail_id'=>$monthYearail);
                if (empty($id)) { 
                    $success = $this->hrm_model->Application_Apply($data); 
                    $data['message'] = "Leave Application Added successfully";
                    logActivity('Leave Application Added', 'leave_app', $id);
                    $this->session->set_flashdata('message', 'Leave Application Added successfully');
                    

                  $getalluserHR= $this->hrm_model->get_Userlist($this->companyGroupId);
                  foreach ($getalluserHR as $keys => $HRandAnmin) {
                     
                     if ($HRandAnmin->hr_permissions==1) {
                          pushNotification(array('subject' => 'Leave Application', 'message' => 'Leave Application by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$HRandAnmin->id, 'to_id' => $HRandAnmin->id, 'ref_id' => $id));
                     }elseif($HRandAnmin->role==1){
                       pushNotification(array('subject' => 'Leave Application', 'message' => 'Leave Application by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$HRandAnmin->id, 'to_id' => $HRandAnmin->id, 'ref_id' => $id));
                     }
                  }
                 
              


                    $selecteduser= $_POST['mail_id'];
                    $loginuser[]= $_POST['emid'];
                    $allgetemail= array_merge($selecteduser, $loginuser);
                
                   $emails= $this->hrm_model->getUserEmailID('user',$allgetemail);
                   
                   $emailid=[];
                    foreach ($emails as $key => $emailsvalue) {
                        $emailid[]=$emailsvalue['email'];
                      }  
                     $all_email = $this->get_email_data_admin_hr();
                     $monthYearailesandto= array_merge($all_email, $emailid);
					 
					 
                     
                     $this->send_email_leave_application($monthYearailesandto, $send_email_data);
                    redirect('hrm/leave_application', 'refresh');
                } else { 
                    $success = $this->hrm_model->Application_Apply_Update($id, $data);
                    $data['message'] = "Leave Application Updated successfully";
                    logActivity('Leave Application Updated', 'leave_app', $id);
                     $this->session->set_flashdata('message', 'Leave Application Application Updated');
                     $getalluserHR= $this->hrm_model->get_Userlist($this->companyGroupId);
                     foreach ($getalluserHR as $keys => $HRandAnmin) {
                     
                     if ($HRandAnmin->hr_permissions==1) {
                          pushNotification(array('subject' => 'Leave Application', 'message' => 'Leave Application by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$HRandAnmin->id, 'to_id' => $HRandAnmin->id, 'ref_id' => $id));
                        }elseif($HRandAnmin->role==1){
                        pushNotification(array('subject' => 'Leave Application', 'message' => 'Leave Application by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$HRandAnmin->id, 'to_id' => $HRandAnmin->id, 'ref_id' => $id));
                         }
                      }
                     $emails= $this->hrm_model->getUserEmailID('user',$_POST['mail_id']);
                   
                   $emailid=[];
                    foreach ($emails as $key => $emailsvalue) {
                        $emailid[]=$emailsvalue['email'];
                      }  
                    $all_email = $this->get_email_data_admin_hr();
                   $monthYearailesandto= array_merge($all_email, $emailid);
                     
                      $this->send_email_leave_application($monthYearailesandto, $send_email_data);
                    redirect('hrm/leave_application', 'refresh');
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
/*Approve and update leave status*/
    public function approveLeaveStatus(){
         $where45 = ' assign_leave.created_by_cid = '.$this->companyGroupId;
         $employeeId = $this->input->post('employeeId');
         $leave_duration = $this->input->post('leave_duration');
         $id = $this->input->post('lid');
         $value = $this->input->post('lvalue');
         $duration = $this->input->post('duration');
         $approvedby[] = $this->input->post('approvedby'); 
         $type = $typeid = $this->input->post('type');
         $approvel_status[]=$this->input->post('approvedby').' '.$value;
         $datainsub = getNameById('emp_leave',$id,'id');
         
          $approvelval= json_decode($datainsub->approvedby_id);
           // pre($approvelval); die;
          $jsonapprov='';
          if ($approvelval=='') {
             $jsonapprov=json_encode($approvedby,true);
              
          }elseif($approvelval!=''){
            $newapprovel=array_merge($approvedby,$approvelval);
             $jsonapprov=json_encode($newapprovel,true);
           }
           $approvelS= json_decode($datainsub->approve_status);

           $approvelStatus='';
          if ($approvelS=='') {
             $approvelStatus=json_encode($approvel_status,true);
           }elseif($approvelS!=''){
            $newapprovel2=array_merge($approvel_status,$approvelS);
             $approvelStatus=json_encode($newapprovel2,true);
           }
          $this->load->library('form_validation');
          $this->form_validation->set_error_delimiters();
        
           $data = array();
          $data = array('approvedby_id' => $jsonapprov,'approve_status' => $approvelStatus);
          $success = $this->hrm_model->updateAplicationAsResolved($id, $data);
          $where =  "`id`= '{$id}'" ;
          $alldata = $this->hrm_model->get_worker_data('emp_leave',  $where);
          $approvel= json_decode($alldata[0]['approvedby_id']);
          $biometric_id = getNameById('company_detail', $this->companyGroupId, 'id');
          $approvelvalue=json_decode($biometric_id->hrm_approve_users);
          $allarrey=[];
          foreach ($approvelvalue as  $approsettingvalue) {
             foreach ($approsettingvalue as  $approvelvalue1) {
                  $allarrey[]=$approvelvalue1;
             }
          }
         $result= array_diff($allarrey,$approvel);
          if(empty($result)){
            $data = array('leave_status' => $value);
            $success = $this->hrm_model->updateAplicationAsResolved($id, $data);
          }elseif(!empty($result)){
            $data = array('leave_status' => 'Not Approve');
            $success = $this->hrm_model->updateAplicationAsResolved($id, $data);
          } 
            $send_email_data[] = $employeeId; 
            $emid=$alldata[0]['em_id'];
            $appstartdate=$alldata[0]['start_date'];
            $appenddate=$alldata[0]['end_date'];
            $leave_duration=$alldata[0]['leave_duration'];
            $reason=$alldata[0]['reason'];
            $applydate=$alldata[0]['apply_date'];
            $send_email_data[] = $emid;
            $send_email_data[] = $appstartdate;
            $send_email_data[] = $appenddate;
            $send_email_data[] = $leave_duration;
            $send_email_data[] = $reason;
            $send_email_data[] = $applydate; 
                    //$selecteduser= $_POST['mail_id'];
                    $loginuser= $this->input->post('employeeId');
                   // $allgetemail= array_merge($selecteduser, $loginuser);
                    $emails= $this->hrm_model->getUserEmailID('user',$loginuser);
                    
                    $emailid=[];
                    foreach ($emails as $key => $emailsvalue){
                        $emailid[]=$emailsvalue['email'];
                      }  
                     $all_email = $this->get_email_data_admin_hr();
                     $monthYearailesandto= array_merge($all_email, $emailid);
 
            $this->send_email_leave_application($monthYearailesandto, $send_email_data,$value);
            logActivity('Leave Application Added', 'leave_app', $id);
            $this->session->set_flashdata('message', 'Leave Application Added successfully');
       if ($value == 'Approve') {
            $leave_balance_data = $this->hrm_model->get_emp_leave_bal($employeeId, $typeid, $this->companyGroupId);
            $closing_bal_days = @$leave_balance_data->closing_bal;
            $total_closing_days_in_hours = $closing_bal_days * 8;
            $total_hours_left = $total_closing_days_in_hours - $duration;
            $total_days_left = $total_hours_left / 8;
            $total_days_left_roundOff = round($total_days_left, 1);
            $data_update = array('closing_bal' => $total_days_left_roundOff);
            $success = $this->hrm_model->update_emp_leave_bal($employeeId, $typeid, $this->companyGroupId, $data_update);
          
        } 
    }
    public function leave_report() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Leave Report', base_url() . 'hrm/ Leave Report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Leave Report';
        $this->data['earnleave'] = $this->hrm_model->Get_emp_leave_Balance($this->companyGroupId);
        $this->_render_template('leave_report/index', $this->data);
    }
    public function hr_leave_allotment() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['leave_types'] = $this->hrm_model->get_data('leave_types', array('leave_types.created_by_cid' => $this->companyGroupId, 'leave_types.status' => 1));
        $this->data['emp_id'] = $this->input->post('id');
        #   pre( $this->data['leave_types']  );die;
        $this->load->view('leave_report/add', $this->data);
    }
    public function earned_leave() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Earned Leave', base_url() . 'hrm/Earned Leave');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Earned Leave';
        $where = 'earned_leave.created_by_cid = ' . $this->companyGroupId;
        $where22 = 'emp_leave.created_by_cid = ' . $this->companyGroupId;
        $this->data['earnleave'] = $this->hrm_model->GetEarnedleaveBalance1($where);
        # pre($this->data);die;
        $this->_render_template('earned_leave/index', $this->data);
    }
    public function earned_leave_edit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
        $this->data['earned_leave'] = $this->hrm_model->get_data_byId_wo('earned_leave', 'em_id', $this->input->post('id'));
        #pre($this->data['earned_leave']);
        $this->load->view('earned_leave/add', $this->data);
    }
    public function earned_leave_view() {
        $this->data['earned_leave'] = $this->hrm_model->get_data_byId_wo('earned_leave', 'em_id', $this->input->post('id'));
        #pre($this->data['earned_leave']);
        $this->load->view('earned_leave/view', $this->data);
    }
    public function delete_earned_leave() {
        $id = $this->uri->segment(3);
        $this->hrm_model->delete_data1('earned_leave', 'id', $id);
        $this->session->set_flashdata('message', 'Earned Leave Deleted successfully');
        redirect(base_url() . 'hrm/earned_leave', 'refresh');
    }
    public function saveEarnedLeave() {
        $where = ' earned_leave.created_by_cid = ' . $this->companyGroupId;
        $emid = $employee = $this->input->post('emid');
        #  pre($employee);die;
        $earned_day = $this->input->post('present_date');
        $where24 = 'AND c_id =' . $this->companyGroupId;
        $emcode = $this->hrm_model->emselectByCode($employee, $where24);
        #     $emid       = $emcode->id;
        $earnval = $this->hrm_model->emEarnselectByLeave($emid, $where);
        if (!empty($earnval)) {
            $data = array();
            $data = array('present_date' => $earned_day, 'status' => '1');
            $success = $this->hrm_model->UpdteEarnValue($emid, $data);
            logActivity('Earned Leave Updated', 'earned_leave', $success);
            $this->session->set_flashdata('message', 'Earned Leave Updated Successfully');
            redirect('hrm/earned_leave', 'refresh');
        } else {
            $data = array();
            $data = array('em_id' => $emid, 'present_date' => $earned_day, 'status' => '1', 'save_status' => '1', 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId);
            # pre($data);die;
            $success = $this->hrm_model->Add_Earn_Leave($data);
            logActivity('Earned Leave Saved', 'earned_leave', $success);
            $this->session->set_flashdata('message', 'Earned Leave Saved Successfully');
            redirect('hrm/earned_leave', 'refresh');
        }
    }
    public function saveEarnedLeave_old() {
        $where = ' earned_leave.created_by_cid = ' . $this->companyGroupId;
        $employee = $this->input->post('emid');
        $start = $this->input->post('startdate');
        $end = $this->input->post('enddate');
        $where24 = 'AND c_id =' . $this->companyGroupId;
        if (empty($end)) {
            $days = '1';
            //die($nofdate);
            
        } else {
            $date1 = new DateTime($start);
            $date2 = new DateTime($end);
            $diff = date_diff($date1, $date2);
            $days = $diff->format("%a");
            //die($nofdate);
            
        }
        $hour = $days * 8;
        $emcode = $this->hrm_model->emselectByCode($employee, $where24);
        $emid = $emcode->id;
        $earnval = $this->hrm_model->emEarnselectByLeave($emid, $where);
        if (!empty($earnval)) {
            $data = array();
            $data = array('present_date' => $earnval->present_date + $days, 'hour' => $earnval->hour + $hour, 'status' => '1');
            $success = $this->hrm_model->UpdteEarnValue($emid, $data);
            logActivity('Earned Leave Updated', 'earned_leave', $success);
            $this->session->set_flashdata('message', 'Earned Leave Updated Successfully');
            redirect('hrm/earned_leave', 'refresh');
        } else {
            $data = array();
            $data = array('em_id' => $emid, 'present_date' => $days, 'hour' => $hour, 'status' => '1', 'save_status' => '1', 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId);
            $success = $this->hrm_model->Add_Earn_Leave($data);
            logActivity('Earned Leave Saved', 'earned_leave', $success);
            $this->session->set_flashdata('message', 'Earned Leave Saved Successfully');
            redirect('hrm/earned_leave', 'refresh');
        }
        /*if($this->db->affected_rows()){
        
        $startdate = strtotime($start);
        
        $enddate = strtotime($end);
        
        for($i = $startdate; $i <= $enddate; $i = strtotime('+1 day', $i)){
        
        $date = date('Y-m-d',$i);
        
        $data = array();
        
        $data = array(
        
        'emp_id' => $employee,
        
        'atten_date' => $date,
        
        'working_hour' => '480',
        
        'signin_time' => '09:00:00',
        
        'signout_time' => '17:00:00',
        
        'status' => 'E'
        
        );
        
        $this->project_model->insertAttendanceByFieldVisitReturn($data); 
        
        
        
        }*/
    }
    public function UpdateEarnLeave() {
        $emid = $this->input->post('employee');
        $days = $this->input->post('day');
        $hour = $this->input->post('hour');
        $data = array();
        $data = array('present_date' => $days, 'save_status' => '1', 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId, 'hour' => $hour);
        $success = $this->hrm_model->UpdteEarnValue($emid, $data);
        logActivity('Earned Leave Updated', 'earned_leave', $success);
        $this->session->set_flashdata('message', 'Earned Leave Updated Successfully');
        redirect('hrm/earned_leave', 'refresh');
    }
    public function assets_category() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Assets Category', base_url() . 'hrm/assets_category');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Assets Category';
        $where = array('created_by_cid' => $this->companyGroupId);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "(assets_category.cat_status like '%" . $_GET['search'] . "%' or assets_category.cat_name like '%" . $_GET['search'] . "%')";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('assets_category', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/assets_category/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['catvalue'] = $this->hrm_model->get_usr_data('assets_category', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        $this->_render_template('assets_category/index', $this->data);
    }
    public function assets_edit() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['assets_val'] = $this->hrm_model->get_data_byId_wo('assets_category', 'id', $id);
        $this->load->view('assets_category/add', $this->data);
    }
    public function saveAssetsCat() {
        if ($this->input->post()) {
            $required_fields = array('cat_name');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 115));
                if ($id && $id != '') {
                    $success = $this->hrm_model->update_data('assets_category', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Assets Category Updated Successfully";
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
                        logActivity('Assets Category Update', 'assets_category', $id);
                        $this->session->set_flashdata('message', 'Assets Category Updated successfully');
                        redirect(base_url() . 'hrm/assets_category', 'refresh');
                    }
                } else {
                    $id = $this->hrm_model->insert_tbl_data('assets_category', $data);
                    if ($id) {
                        logActivity('Assets Category Inserted', 'assets_category', $id);
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
                        $this->session->set_flashdata('message', 'Assets Category inserted successfully');
                        redirect(base_url() . 'hrm/assets_category', 'refresh');
                    }
                }
            }
        }
    }
    public function assets_list() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Assets List', base_url() . 'hrm/assets_list');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Assets List';
        $where = array('created_by_cid' => $this->companyGroupId, 'in_stock' => 1);
        if (isset($_GET['tab']) == 'available_assets' && $_GET['tab'] != 'notavailable_assets') {
            $where = array('created_by_cid' => $this->companyGroupId, 'in_stock' => 1);
        } elseif (isset($_GET['tab']) == 'notavailable_assets' && $_GET['tab'] != 'available_assets') {
            $where = array('created_by_cid' => $this->companyGroupId, 'in_stock' => 0);
        }
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "ass_name like '%" . $_GET['search'] . "%' or ass_brand like '%" . $_GET['search'] . "%' or ass_model like '%" . $_GET['search'] . "%' or ass_code like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('assets_list', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/assets_list/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['available_assets'] = $this->hrm_model->get_usr_data('assets_list', $where, $config["per_page"], $page, $where2, $order, $export_data);
        $this->data['notavailable_assets'] = $this->hrm_model->get_usr_data('assets_list', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        /*
        
        $this->data['available_assets']    = $this->hrm_model->get_data('assets_list', $where);
        
        $where1                            = array(
        
            'created_by_cid' =>$this->companyGroupId ,
        
            'in_stock' => 0
        
        );
        
        $this->data['notavailable_assets'] = $this->hrm_model->get_data('assets_list', $where1);*/
        //  pre($this->data['available_assets']);die;
        $this->_render_template('assets_list/index', $this->data);
    }
    public function addAssetsList() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['assets_list'] = $this->hrm_model->get_data_byId_wo('assets_list', 'id', $id);
        $this->load->view('assets_list/add', $this->data);
    }
    public function saveAssetsList() {
        //pre($this->input->post());die;
        if ($this->input->post()) {
            $required_fields = array('catid');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 115));
                if ($id && $id != '') {
                    //$data['in_stock'] = $this->input->post('in_stock');
                    $success = $this->hrm_model->update_data('assets_list', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Assets List Updated Successfully";
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
                        logActivity('Assets List Update', 'assets_list', $id);
                        $this->session->set_flashdata('message', 'Assets List Updated successfully');
                        redirect(base_url() . 'hrm/assets_list', 'refresh');
                    }
                } else {
                    //$data['in_stock'] = '1';
                    $id = $this->hrm_model->insert_tbl_data('assets_list', $data);
                    if ($id) {
                        logActivity('Assets List Inserted', 'assets_list', $id);
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
                        $this->session->set_flashdata('message', 'Assets List Inserted successfully');
                        redirect(base_url() . 'hrm/assets_list', 'refresh');
                    }
                }
            }
        }
    }
    public function assign_assets_employees() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Assets List', base_url() . 'hrm/assign_assets_employees');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Employee Assets Assigned List';
        $where = array('created_by_cid' => $this->companyGroupId, 'log_qty' => 0);
        if (!empty($_GET['tab']) == 'return' && $_GET['tab'] != 'assigned') {
            $where = array('created_by_cid' => $this->companyGroupId, 'log_qty' => 0);
        } elseif (!empty($_GET['tab']) == 'assigned' && $_GET['tab'] != 'return') {
            $where = array('created_by_cid' => $this->companyGroupId, 'log_qty' => 1);
        }
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $EmpName = getNameBySearch('user_detail', $_GET['search'], 'name');
            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "assets_employees.assign_id ='" . $name['u_id'] . "'";
            }
            $AssetName = getNameBySearch('assets_list', $_GET['search'], 'ass_name');
            foreach ($AssetName as $name) { //pre($name['id']);
                $where2[] = "assets_employees.assets_products like '%\"product_name\":\"" . $name['id'] . "\"%'";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "assets_products like '%\"model_no\":\"%" . $_GET['search'] . "%\"%' or '%\"assets_code\":\"%" . $_GET['search'] . "%\"%'";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('assets_employees', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/assign_assets_employees/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['notassigned_assets'] = $this->hrm_model->get_usr_data('assets_employees', $where, $config["per_page"], $page, $where2, $order, $export_data);
        $this->data['assigned_assets'] = $this->hrm_model->get_usr_data('assets_employees', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        /*$this->data['assigned_assets']    = $this->hrm_model->get_data('assets_employees', $where);
        
        $where1                           = array(
        
            'created_by_cid' =>$this->companyGroupId ,
        
            'log_qty' => 0
        
        );
        
        
        
        $this->data['notassigned_assets'] = $this->hrm_model->get_data('assets_employees', $where1);*/
        // pre($this->data['supportview']);
        $this->_render_template('assign_empployees/index', $this->data);
    }
    public function AssignAssetsEmp() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
        $this->data['assign_emp'] = $this->hrm_model->get_data_byId_wo('assets_employees', 'id', $id);
        $this->load->view('assign_empployees/add', $this->data);
    }
    public function ViewAssetsEmp() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        $data['assign_emp'] = $this->hrm_model->get_data_byId_wo('assets_employees', 'id', $id);
        $this->load->view('assign_empployees/view', $data);
    }
    // For Saving Quotation
    public function saveAssignAssetsEmp() {
        if ($this->input->post()) {
            $required_fields = array('assign_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                //$data = $this->input->post();
                //unset($data['loggedUser']);
                $products = count($_POST['product_name']);
                if ($products > 0) {
                    $arr = array();
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product_name' => $_POST['product_name'][$i], 'model_no' => $_POST['model_no'][$i], 'assets_code' => $_POST['assets_code'][$i], 'remarks' => $_POST['remarks'][$i], 'return_remarks' => (!empty($_POST['return_remarks'][$i]) ? $_POST['return_remarks'][$i] : ''));
                        $arr[$i] = $jsonArrayObject;
                        //$instokeupdated = $this->hrm_model->SubtractAssetStoke('assets_list', $_POST['assign_quantity'][$i], $_POST['product_name'][$i]);
                        $instoke_status['in_stock'] = 0;
                        $instokeupdated = $this->hrm_model->updateData('assets_list', $instoke_status, 'id', $_POST['product_name'][$i]);
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $unsetarray = array("product_name", "model_no", "assets_code", "remarks", "return_remarks", "loggedUser");
                $data = array_diff_key($this->input->post(), array_flip($unsetarray));
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['assets_products'] = $product_array;
                /*          $total_assign_qty = array_sum($_POST['assign_quantity']);
                
                $back_quantity =array_sum(isset($_POST['back_quantity'])?$_POST['back_quantity']:array());
                
                $data['log_qty'] = $total_assign_qty - $back_quantity;
                
                $data['back_qty'] = $back_quantity; */
                $data['log_qty'] = '1';
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
                // pre($data);
                // die;
                $id = $data['id'];
                if ($id && $id != '') {
                    $success = $this->hrm_model->updateData('assets_employees', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Assign Assets Employees updated successfully";
                        logActivity('Assign Assets Employees updated', 'assign_assets_emp', $id);
                        $this->session->set_flashdata('message', 'Assign Assets Employees Updated successfully');
                    }
                } else {
                    $id = $this->hrm_model->insert_tbl_data('assets_employees', $data);
                    if ($id) {
                        logActivity('Assets Assign to Employees', 'Quotation', $id);
                        $this->session->set_flashdata('message', 'Assets Assign to Employees successfully');
                    }
                }
                redirect(base_url() . 'hrm/assign_assets_employees', 'refresh');
            }
        }
    }
    public function ReturnAssetsEmp() {
        // $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['assign_emp'] = $this->hrm_model->get_data_byId_wo('assets_employees', 'id', $id);
        $this->load->view('assign_empployees/retrun', $this->data);
    }
    // For Saving Quotation
    public function saveReturnAssetsEmp() {
        if ($this->input->post()) {
            $required_fields = array('assign_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                // $data = $this->input->post();
                $products = count($_POST['product_name']);
                if ($products > 0) {
                    $arr = array();
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product_name' => $_POST['product_name'][$i], 'model_no' => $_POST['model_no'][$i], 'assets_code' => $_POST['assets_code'][$i], 'remarks' => $_POST['remarks'][$i], 'return_remarks' => $_POST['return_remarks'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        //$instokeupdated = $this->hrm_model->AddAssetStoke('assets_list', $_POST['back_quantity'][$i], $_POST['product_name'][$i]);
                        $instoke_status['in_stock'] = 1;
                        $instokeupdated = $this->hrm_model->updateData('assets_list', $instoke_status, 'id', $_POST['product_name'][$i]);
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $unsetarray = array("product_name", "model_no", "assets_code", "remarks", "return_remarks", "loggedUser");
                $data = array_diff_key($this->input->post(), array_flip($unsetarray));
                //pre($this->input->post());die;
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['assets_products'] = $product_array;
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
                /*  $total_assign_qty = array_sum($_POST['assign_quantity']);
                
                $back_quantity = array_sum($_POST['back_quantity']);
                
                $data['log_qty'] = $total_assign_qty - $back_quantity;
                
                $data['back_qty'] = $back_quantity; */
                $data['log_qty'] = '0';
                #pre($data);
                #die;
                $id = $data['id'];
                if ($id && $id != '') {
                    $success = $this->hrm_model->updateData('assets_employees', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Assign Assets Employees updated successfully";
                        logActivity('Assign Assets Employees updated', 'assign_assets_emp', $id);
                        $this->session->set_flashdata('message', 'Assign Assets Employees Updated successfully');
                    }
                } else {
                    $id = $this->hrm_model->insert_tbl_data('assets_employees', $data);
                    if ($id) {
                        logActivity('Assets Assign to Employees', 'Quotation', $id);
                        $this->session->set_flashdata('message', 'Assets Assign to Employees successfully');
                    }
                }
                redirect(base_url() . 'hrm/assign_assets_employees', 'refresh');
            }
        }
    }
    public function assign_assets_workers() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Assets List', base_url() . 'hrm/assign_assets_employees');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Workers Assets Assigned List';
        /* $where                            = array(
        
            'created_by_cid' =>$this->companyGroupId ,
        
            'log_qty' => 1
        
        );
        
        $this->data['assigned_assets']    = $this->hrm_model->get_data('assets_workers', $where);
        
        $where1                           = array(
        
            'created_by_cid' =>$this->companyGroupId ,
        
            'log_qty' => 0
        
        );
        
        $this->data['notassigned_assets'] = $this->hrm_model->get_data('assets_workers', $where1);
        
        */
        $where = array('created_by_cid' => $this->companyGroupId, 'log_qty' => 1);
        if (!empty($_GET['tab']) == 'return' && $_GET['tab'] != 'assigned') {
            $where = array('created_by_cid' => $this->companyGroupId, 'log_qty' => 0);
        }
        if (!empty($_GET['tab']) == 'assigned' && $_GET['tab'] != 'return') {
            $where = array('created_by_cid' => $this->companyGroupId, 'log_qty' => 1);
        }
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $EmpName = getNameBySearch('worker', $_GET['search'], 'name');
            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "assets_workers.assign_id ='" . $name['id'] . "'";
            }
            $AssetName = getNameBySearch('assets_list', $_GET['search'], 'ass_name');
            foreach ($AssetName as $name) { //pre($name['id']);
                $where2[] = "assets_workers.assets_products like '%\"product_name\":\"" . $name['id'] . "\"%'";
            }
            if (sizeof($where2) != '') {
                $where2 = '(' . implode("||", $where2) . ')';
            } else {
                $where2 = "assets_products like '%\"model_no\":\"%" . $_GET['search'] . "%\"%' or '%\"assets_code\":\"%" . $_GET['search'] . "%\"%'";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('assets_workers', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/assign_assets_workers/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['assigned_assets'] = $this->hrm_model->get_usr_data('assets_workers', $where, $config["per_page"], $page, $where2, $order, $export_data);
        $this->data['notassigned_assets'] = $this->hrm_model->get_usr_data('assets_workers', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        #pre($this->data['application']);
        $this->_render_template('assign_workers/index', $this->data);
    }
    public function AssignAssetsWork() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['assign_emp'] = $this->hrm_model->get_data_byId_wo('assets_workers', 'id', $id);
        $this->load->view('assign_workers/add', $this->data);
    }
    // For Saving Quotation
    public function saveAssignAssetsWork() {
        if ($this->input->post()) {
            $required_fields = array('assign_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                //  $data = $this->input->post();
                $products = count($_POST['product_name']);
                if ($products > 0) {
                    $arr = array();
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product_name' => $_POST['product_name'][$i], 'model_no' => $_POST['model_no'][$i], 'assets_code' => $_POST['assets_code'][$i], 'remarks' => $_POST['remarks'][$i], 'return_remarks' => (!empty($_POST['return_remarks'][$i]) ? $_POST['return_remarks'][$i] : ''));
                        $arr[$i] = $jsonArrayObject;
                        $instoke_status['in_stock'] = 0;
                        $instokeupdated = $this->hrm_model->updateData('assets_list', $instoke_status, 'id', $_POST['product_name'][$i]);
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $unsetarray = array("product_name", "model_no", "assets_code", "remarks", "return_remarks", "loggedUser");
                $data = array_diff_key($this->input->post(), array_flip($unsetarray));
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                //$data['created_by_cid'] =$this->companyGroupId ;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['assets_products'] = $product_array;
                $data['log_qty'] = '1';
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
                $id = $data['id'];
                if ($id && $id != '') {
                    $success = $this->hrm_model->update_data('assets_workers', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Assign Assets Workers updated successfully";
                        logActivity('Assign Assets Workers updated', 'assign_assets_work', $id);
                        $this->session->set_flashdata('message', 'Assign Assets Workers Updated successfully');
                    }
                } else {
                    $id = $this->hrm_model->insert_tbl_data('assets_workers', $data);
                    if ($id) {
                        logActivity('Assets Assign to Workers', 'assets_workers', $id);
                        $this->session->set_flashdata('message', 'Assets Assign to Workers successfully');
                    }
                }
                redirect(base_url() . 'hrm/assign_assets_workers', 'refresh');
            }
        }
    }
    public function ViewAssetsWorker() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        $data['assign_emp'] = $this->hrm_model->get_data_byId_wo('assets_workers', 'id', $id);
        $this->load->view('assign_workers/view', $data);
    }
    public function ReturnAssetsWorker() {
        // $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['assign_emp'] = $this->hrm_model->get_data_byId_wo('assets_workers', 'id', $id);
        $this->load->view('assign_workers/retrun', $this->data);
    }
    // For Saving Quotation
    public function saveReturnAssetsWorker() {
        if ($this->input->post()) {
            $required_fields = array('assign_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                //$data = $this->input->post();
                $products = count($_POST['product_name']);
                if ($products > 0) {
                    $arr = array();
                    $i = 0;
                    while ($i < $products) {
                        $jsonArrayObject = array('product_name' => $_POST['product_name'][$i], 'model_no' => $_POST['model_no'][$i], 'assets_code' => $_POST['assets_code'][$i], 'remarks' => $_POST['remarks'][$i], 'return_remarks' => $_POST['return_remarks'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        //$instokeupdated = $this->hrm_model->AddAssetStoke('assets_list', $_POST['back_quantity'][$i], $_POST['product_name'][$i]);
                        $instoke_status['in_stock'] = 1;
                        $instokeupdated = $this->hrm_model->updateData('assets_workers', $instoke_status, 'id', $_POST['product_name'][$i]);
                        $i++;
                    }
                    $product_array = json_encode($arr);
                } else {
                    $product_array = '';
                }
                $unsetarray = array("product_name", "model_no", "assets_code", "remarks", "return_remarks", "loggedUser");
                $data = array_diff_key($this->input->post(), array_flip($unsetarray));
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['assets_products'] = $product_array;
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 94));
                /*  $total_assign_qty = array_sum($_POST['assign_quantity']);
                
                $back_quantity = array_sum($_POST['back_quantity']);
                
                $data['log_qty'] = $total_assign_qty - $back_quantity;
                
                $data['back_qty'] = $back_quantity; */
                $data['log_qty'] = '0';
                #pre($data);
                #die;
                $id = $data['id'];
                if ($id && $id != '') {
                    $success = $this->hrm_model->updateData('assets_workers', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Assign Assets Worker updated successfully";
                        logActivity('Assign Assets Worker updated', 'assign_assets_emp', $id);
                        $this->session->set_flashdata('message', 'Assign Assets Worker Updated successfully');
                    }
                } else {
                    $id = $this->hrm_model->insert_tbl_data('assets_workers', $data);
                    if ($id) {
                        logActivity('Assets Assign to Worker', 'Quotation', $id);
                        $this->session->set_flashdata('message', 'Assets Assign to Worker successfully');
                    }
                }
                redirect(base_url() . 'hrm/assign_assets_workers', 'refresh');
            }
        }
    }
    public function getAssetsDataById() {
        if ($_POST['id'] != '') {
            $monthYearaterial = $this->hrm_model->get_data_byId('assets_list', 'id', $_POST['id']);
            //pre($monthYearaterial);
            echo json_encode($monthYearaterial);
        }
    }
    /*Worker Attendance Submodule Started*/
    public function Worker_Attendance() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Worker Attendance', base_url() . 'hrm/Worker_Attendance');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Worker Attendance';
        $where = ' worker_attendance.created_by_cid = ' . $this->companyGroupId;
        // $this->data['termsconds']      = $this->hrm_model->get_data('hrm_terms', array('created_by_cid' =>$this->companyGroupId ));
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $EmpName = getNameBySearch('worker', $_GET['search'], 'name');
            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "worker_attendance.emp_id ='" . $name['id'] . "'";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "worker_attendance.id='" . $_GET['search'] . "'";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('worker_attendance', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/worker_Attendance/";
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
        //$page =1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        } 
        $this->data['attendancelist'] = $this->hrm_model->getAllAttendanceWork('worker_attendance', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        /*$this->data['attendancelist']  = $this->hrm_model->getAllAttendanceWork($where);*/
        $this->_render_template('workers_attendance/index', $this->data);
    }
    // For Editing Attendance
    public function attendance_edit_workers() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->hrm_model->get_data('user_detail');
        $this->data['attval'] = $this->hrm_model->get_data_byId('worker_attendance', 'id', $this->input->post('id'));
        $this->load->view('workers_attendance/add_attendance', $this->data);
    }
    public function saveAttendanceWorker() {
        if ($this->input->post()) {
            $where = array('created_by_cid' => $this->companyGroupId);
            $required_fields = array('emid', 'attdate');
            $id = $this->input->post('id');
            $em_id = $this->input->post('emid');
            $attdate = $this->input->post('attdate');
            $signin = $this->input->post('signin');
            $signout = $this->input->post('signout');
            $place = $this->input->post('place');
            $status = $this->input->post('status');
            $old_date = $_POST['attdate']; // returns Saturday, January 30 10 02:06:34
            $old_date_timestamp = strtotime($old_date);
            $new_date = date('m/d/Y', $old_date_timestamp);
            $where = 'AND created_by_cid = ' . $this->companyGroupId;
            // CHANGING THE DATE FORMAT FOR DB UTILITY
            $new_date_changed = date('Y-m-d', strtotime(str_replace('-', '/', $new_date)));
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $sin = new DateTime($new_date . $_POST['signin']);
                $sout = new DateTime($new_date . $_POST['signout']);
                $hour = $sin->diff($sout);
                $work = $hour->format('%H h %i m');
                 
                if (empty($id)) {
                    $day = date("D", strtotime($new_date_changed));
                    if ($day == "Sun") {
                        $duplicate = $this->hrm_model->getDuplicateValWorker($em_id, $new_date_changed, $where);
                        //print_r($duplicate);
                        if (!empty($duplicate)) {
                            $this->session->set_flashdata('message', 'Already Exist');
                            redirect(base_url() . 'hrm/Worker_Attendance', 'refresh');
                        } else {
                            $where24 = 'AND created_by_cid =' . $this->companyGroupId;
                            $emcode = $this->hrm_model->emselectByCodeWorker($em_id, $where24);
                            $emid = $emcode->id;
                            $earnval = $this->hrm_model->emEarnselectByLeaveWorker($emid, $where);
                            $data = array();
                            $data = array('present_date' => $earnval->present_date + 1, 'hour' => $earnval->hour + 480, 'status' => '1');
                     
                            $success = $this->hrm_model->UpdteEarnValueWorker($emid, $data);
                            $data = array();
                            $data = array('emp_id' => $em_id, 'atten_date' => $new_date_changed, 'signin_time' => $signin, 'signout_time' => $signout, 'working_hour' => $work, 'place' => $place, 'status' => $status, 'created_by_cid' => $this->companyGroupId);
                            logActivity('Worker Attendance Updated Successfully', 'worker_attendance', $id);
                            $success = $this->hrm_model->Add_AttendanceDataWorker($data);
                            $this->session->set_flashdata('message', 'Successfully Updated');
                            redirect(base_url() . 'hrm/Worker_Attendance', 'refresh');
                        }
                    } elseif ($day != "Sun") {
                        $holiday = $this->hrm_model->get_holiday_between_datesWorker($new_date_changed, $where);
                        if ($holiday) {
                            $duplicate = $this->hrm_model->getDuplicateValWorker($em_id, $new_date_changed, $where);
                            //print_r($duplicate);
                            if (!empty($duplicate)) {
                                $this->session->set_flashdata('message', 'Already Exist');
                            } else {
                                $where24 = 'AND c_id =' . $this->companyGroupId;
                                $emcode = $this->hrm_model->emselectByCodeWorker($em_id, $where24);
                                $emid = $emcode->id;
                                $earnval = $this->hrm_model->emEarnselectByLeaveWorker($emid, $where);
                                $data = array();
                                $data = array('present_date' => $earnval->present_date + 1, 'hour' => $earnval->hour + 480, 'status' => '1');
                                $success = $this->hrm_model->UpdteEarnValueWorker($emid, $data);
                                $data = array();
                                $data = array('emp_id' => $em_id, 'atten_date' => $new_date_changed, 'signin_time' => $signin, 'signout_time' => $signout, 'working_hour' => $work, 'place' => $place, 'status' => $status, 'created_by_cid' => $this->companyGroupId);

                                $ri = $this->hrm_model->Add_AttendanceDataWorker($data);
                                logActivity('Worker Attendance Added Successfully', 'worker_attendance', $ri);
                                $this->session->set_flashdata('message', 'Worker Attendance Successfully Added');
                                redirect(base_url() . 'hrm/Worker_Attendance', 'refresh');
                            }
                        } else {
                            $duplicate = $this->hrm_model->getDuplicateValWorker($em_id, $new_date_changed, $where);
                            //print_r($duplicate);
                            if (!empty($duplicate)) {
                                $this->session->set_flashdata('message', 'Already Exist');
                                redirect(base_url() . 'hrm/Worker_Attendance', 'refresh');
                            } else {
                                //$date = date('Y-m-d', $i);
                                $data = array();
                                $data = array('emp_id' => $em_id, 'atten_date' => $new_date_changed, 'signin_time' => $signin, 'signout_time' => $signout, 'working_hour' => $work, 'place' => $place, 'status' => $status, 'created_by_cid' => $this->companyGroupId);
                                $rt = $this->hrm_model->Add_AttendanceDataWorker($data);
                                logActivity('Worker Attendance Added Successfully', 'worker_attendance', $rt);
                                $this->session->set_flashdata('message', 'Worker Attendace Successfully Added');
                                redirect(base_url() . 'hrm/Worker_Attendance', 'refresh');
                            }
                        }
                    }
                } else {
                    $data = array();
                    $data = array('signin_time' => $signin, 'signout_time' => $signout, 'working_hour' => $work, 'place' => $place, 'status' => $status, 'created_by_cid' => $this->companyGroupId);
                    $this->hrm_model->Update_AttendanceDataWorker($id, $data);
                    logActivity('Attendance Updated Successfully', 'attendance', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect(base_url() . 'hrm/Worker_Attendance', 'refresh');
                }
            }
        } else {
            redirect(base_url() . 'hrm/Worker_Attendance', 'refresh');
        }
    }
    # Worker Leave Application
    public function leave_application_worker() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Worker Leave Application', base_url() . 'hrm/Worker Leave Application');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Worker Leave Application';
        $where = 'leave_types.created_by_cid = ' . $this->companyGroupId;
        // $where1 = 'work_leave.created_by_cid = ' . $this->companyGroupId;
        $companyApproveUsers = json_decode(getSingleAndWhere('hrm_approve_users','company_detail',['id' => $this->companyGroupId ]),true );
        $where = 'leave_types.created_by_cid = ' . $this->companyGroupId;
          $options = [];
         // $where1 = 'emp_leave.created_by_cid = ' . $this->companyGroupId;
        // $where1 = 'emp_leave.em_id = ' .$_SESSION['loggedInUser']->id;
        $where1=''; 
       if ($_SESSION['loggedInUser']->role==1) {
            $where1 = array('work_leave.created_by_cid' =>$this->companyGroupId);
        }elseif($_SESSION['loggedInUser']->hr_permissions==1 && $_SESSION['loggedInUser']->role==2) {
            $where1 = array('work_leave.created_by_cid' =>$this->companyGroupId);
        }elseif($_SESSION['loggedInUser']->role==2 && $_SESSION['loggedInUser']->hr_permissions==0){
        $where1='';
       if(checkPurchaseApprove() ){
        
          if( $companyApproveUsers ){
         foreach ($companyApproveUsers as $compuser){ 
             if (in_array($_SESSION['loggedInUser']->id, $compuser)) {
                $where1 = array('work_leave.created_by_cid' =>$this->companyGroupId); 
               goto end;
                 
            }else{ 
                $where1 = array('work_leave.created_by_cid' =>$this->companyGroupId,'work_leave.em_id' =>$_SESSION['loggedInUser']->id );
             }
            }  
          }
         }  
       }     
       end: 
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $EmpName = getNameBySearch('worker', $_GET['search'], 'name');
            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "work_leave.em_id ='" . $name['id'] . "'";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('work_leave', $where1, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/leave_application_worker/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['leavetypes'] = $this->hrm_model->GetleavetypeInfo('leave_types', $where, $config["per_page"], $page, '', $order, $export_data);
        $this->data['application'] = $this->hrm_model->AllLeaveAPPlicationWork('work_leave', $where1, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        #pre($this->data['application']);
         $this->data['approve_by']=$companyApproveUsers;
        $this->_render_template('worker_leave_application/index', $this->data);
    }
    public function leave_application_edit_worker() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['users'] = $this->hrm_model->get_data('worker');
        $this->data['empleave'] = $this->hrm_model->get_data_byId_wo('work_leave', 'id', $this->input->post('id'));
        #pre($this->data['empleave']);
        $this->load->view('worker_leave_application/add', $this->data);
    }
    public function leave_application_view_worker() {
        $this->data['users'] = $this->hrm_model->get_data('worker');
        $this->data['empleave'] = $this->hrm_model->get_data_byId_wo('work_leave', 'id', $this->input->post('id'));
        #pre($this->data['empleave']);
        $this->load->view('worker_leave_application/view', $this->data);
    }
    public function delete_application_worker() {
        $id = $this->uri->segment(3);
        $this->hrm_model->delete_data('work_leave', 'id', $id);
        $this->session->set_flashdata('message', 'Leave Application Deleted successfully');
        redirect(base_url() . 'hrm/leave_application_worker', 'refresh');
    }
    public function save_Applications_worker() {
          
        if ($this->input->post()) {
             $required_fields = array('id');
            $id = $this->input->post('id');
            $emid = $this->input->post('emid');
            $typeid = $this->input->post('typeid');
            $applydate = date('Y-m-d');
            $appstartdate = $this->input->post('startdate');
            $appenddate = $this->input->post('enddate');
            $send_email = $this->input->post('send_email');
            $leave_duration = $this->input->post('leave_duration');
            #   $hourAmount      = $this->input->post('hourAmount');
            $reason = $this->input->post('reason');
            $type = $this->input->post('type');
            $monthYearail= json_encode($_POST['mail_id']); 
             $send_email_data[] = $emid;
            $send_email_data[] = $appstartdate;
            $send_email_data[] = $appenddate;
            $send_email_data[] = $leave_duration;
            $send_email_data[] = $reason;
            $send_email_data[] = $applydate;
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = array();
                $data = array('em_id' => $emid, 'typeid' => $typeid, 'apply_date' => $applydate, 'start_date' => $appstartdate, 'end_date' => $appenddate, 'reason' => $reason, 'leave_type' => $type, 'leave_duration' => $leave_duration, 'leave_status' => 'Not Approve', 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId,'mail_id'=>$monthYearail);

                if (empty($id)) { 
                    $success = $this->hrm_model->Application_Apply_Worker($data); 
                    $data['message'] = "Leave Application Added successfully";
                    logActivity('Leave Application Added', 'leave_app', $id);
                    $this->session->set_flashdata('message', 'Leave Application Added successfully');
                    redirect('hrm/leave_application_worker', 'refresh');

                  $getalluserHR= $this->hrm_model->get_Userlist($this->companyGroupId);
                  foreach ($getalluserHR as $keys => $HRandAnmin) {
                     
                     if ($HRandAnmin->hr_permissions==1) {
                          pushNotification(array('subject' => 'Leave Application', 'message' => 'Leave Application by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$HRandAnmin->id, 'to_id' => $HRandAnmin->id, 'ref_id' => $id));
                     }elseif($HRandAnmin->role==1){
                       pushNotification(array('subject' => 'Leave Application', 'message' => 'Leave Application by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$HRandAnmin->id, 'to_id' => $HRandAnmin->id, 'ref_id' => $id));
                     }
                  }
                 
                    $selecteduser= $_POST['mail_id'];
                    $loginuser[]= $_POST['emid'];
                    $allgetemail= array_merge($selecteduser, $loginuser);
                
                   $emails= $this->hrm_model->getUserEmailID('user',$allgetemail);
                   
                   $emailid=[];
                    foreach ($emails as $key => $emailsvalue) {
                        $emailid[]=$emailsvalue['email'];
                      }  
                     $all_email = $this->get_email_data_admin_hr();
                     $monthYearailesandto= array_merge($all_email, $emailid);
                     
                     $this->send_email_leave_application($monthYearailesandto, $send_email_data);
                } else {
                    $success = $this->hrm_model->Application_Apply_Update_Worker($id, $data);
                    $data['message'] = "Leave Application Updated successfully";
                    logActivity('Leave Application Updated', 'leave_app', $id);
                     $this->session->set_flashdata('message', 'Leave Application Application Updated');
                     $getalluserHR= $this->hrm_model->get_Userlist($this->companyGroupId);
                     foreach ($getalluserHR as $keys => $HRandAnmin) {
                     
                     if ($HRandAnmin->hr_permissions==1) {
                          pushNotification(array('subject' => 'Leave Application', 'message' => 'Leave Application by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$HRandAnmin->id, 'to_id' => $HRandAnmin->id, 'ref_id' => $id));
                        }elseif($HRandAnmin->role==1){
                        pushNotification(array('subject' => 'Leave Application', 'message' => 'Leave Application by ' . $_SESSION['loggedInUser']->name, 'from_id' =>$HRandAnmin->id, 'to_id' => $HRandAnmin->id, 'ref_id' => $id));
                         }
                      }
                     $emails= $this->hrm_model->getUserEmailID('user',$_POST['mail_id']);
                   
                   $emailid=[];
                    foreach ($emails as $key => $emailsvalue) {
                        $emailid[]=$emailsvalue['email'];
                      }  
                    $all_email = $this->get_email_data_admin_hr();
                   $monthYearailesandto= array_merge($all_email, $emailid);
                     
                      $this->send_email_leave_application($monthYearailesandto, $send_email_data);
                    redirect('hrm/leave_application_worker', 'refresh');
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*Approve and update leave status*/
 public function approveLeaveStatusWorker() {
         $where45 = ' assign_leave.created_by_cid = '.$this->companyGroupId;

            $employeeId = $this->input->post('employeeId');
            $leave_duration = $this->input->post('leave_duration');
            $id = $this->input->post('lid');
            $value = $this->input->post('lvalue');
            $duration = $this->input->post('duration');
            $approvedby[] = $this->input->post('approvedby'); 
            $type = $typeid = $this->input->post('type');
            $approvel_status[]=$this->input->post('approvedby').' '.$value;
            $datainsub = getNameById('work_leave',$id,'id');
           $approvelval= json_decode($datainsub->approvedby_id);
           // pre($approvelval); die;
          $jsonapprov='';
          if ($approvelval=='') {
             $jsonapprov=json_encode($approvedby,true);
              
          }elseif($approvelval!=''){
            $newapprovel=array_merge($approvedby,$approvelval);
             $jsonapprov=json_encode($newapprovel,true);
           } 
           $approvelS= json_decode($datainsub->approve_status);

           $approvelStatus='';
          if ($approvelS=='') {
             $approvelStatus=json_encode($approvel_status,true);
           }elseif($approvelS!=''){
            $newapprovel2=array_merge($approvel_status,$approvelS);
             $approvelStatus=json_encode($newapprovel2,true);
           }
          $this->load->library('form_validation');
          $this->form_validation->set_error_delimiters();
        
           $data = array();
          $data = array('approvedby_id' => $jsonapprov,'approve_status' => $approvelStatus);
          $success = $this->hrm_model->updateAplicationAsResolvedWorker($id, $data);
          $where =  "`id`= '{$id}'" ;
          $alldata = $this->hrm_model->get_worker_data('work_leave',  $where);
          $approvel= json_decode($alldata[0]['approvedby_id']);
          $biometric_id = getNameById('company_detail', $this->companyGroupId, 'id');
          $approvelvalue=json_decode($biometric_id->hrm_approve_users);
          $allarrey=[];
          foreach ($approvelvalue as  $approsettingvalue) {
             foreach ($approsettingvalue as  $approvelvalue1) {
                  $allarrey[]=$approvelvalue1;
             }
          }
         $result= array_diff($allarrey,$approvel);
          if(empty($result)){
            $data = array('leave_status' => $value);
            $success = $this->hrm_model->updateAplicationAsResolvedWorker($id, $data);
          }elseif(!empty($result)){
            $data = array('leave_status' => 'Not Approve');
            $success = $this->hrm_model->updateAplicationAsResolvedWorker($id, $data);
          }
    } 
    # Employee Payroll
    public function emp_payroll_list() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Payroll', base_url() . 'hrm/emp_payroll_list');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Payroll';
        $where = 'pay_salary.created_by_cid = ' . $this->companyGroupId;
        $this->data['salary_info'] = $this->hrm_model->getAllSalaryData($where);
        $this->_render_template('payroll_list/index', $this->data);
    }
    // Start Invoice
    public function Invoice() {
        $where20 = 'emp_salary.created_by_cid = ' . $this->companyGroupId;
        $where2 = 'AND user.c_id = ' . $this->companyGroupId;
        $where25 = 'AND pay_salary.created_by_cid = ' . $this->companyGroupId;
        $where3 = 'AND addition.created_by_cid = ' . $this->companyGroupId;
        $where4 = 'AND deduction.created_by_cid = ' . $this->companyGroupId;
        $where5 = 'AND holiday.created_by_cid = ' . $this->companyGroupId;
        $where6 = 'user.c_id = ' . $this->companyGroupId;
        /*$data['typevalue'] = $this->payroll_model->GetsalaryType();*/
        $id = $_POST['pid'];
        $eid = $_POST['employeeId'];
        $data2 = array();
        $data['salary_info'] = $this->hrm_model->getAllSalaryDataById($id, $where25);
        //  pre($data['salary_info']);die;     // = $this->payroll_model->getAllSalaryID($id);
        $data['employee_info'] = $this->hrm_model->getEmployeeID($eid, $where2);
        $data['salaryvaluebyid'] = $this->hrm_model->Get_Salary_Value($eid, $where20); // 24
        $data['salarypaybyid'] = $this->hrm_model->Get_SalaryID($eid, $where20);
        $data['salaryvalue'] = $this->hrm_model->GetsalaryValueByID($eid, $where20); // 25000
        # $data['loanvaluebyid']      = $this->payroll_model->GetLoanValueByID($eid);
        $data['settingsvalue'] = $this->hrm_model->getEmployeeID($eid, $where2);
        @$data['addition'] = $this->hrm_model->getAdditionDataBySalaryID($data['salaryvalue']->id, $where3);
        @$data['diduction'] = $this->hrm_model->getDiductionDataBySalaryID($data['salaryvalue']->id, $where4);
        //$data['diduction'] = $this->payroll_model->getDiductionDataBySalaryID($data['salaryvalue']->id);
        //$monthYearonth = date('m');
        //$data['loanInfo']      = $this->payroll_model->getLoanInfoInvoice($id, $monthYearonth);
        #$data['otherInfo']      = $this->payroll_model->getOtherInfo($eid);
        #$data['bankinfo']      = $this->payroll_model->GetBankInfo($eid);
        //Count Add/Did
        @$monthYearonth_init = $data['salary_info']->month;
        $monthYearonth = date("n", strtotime($monthYearonth_init));
        @$year = $data['salary_info']->year;
        if (!empty($data['employee_info']->id)) {
            $id_em = $data['employee_info']->id;
        } else {
            $id_em = '';
        }
        $data['id_em'] = $id_em;
        $data['month'] = $monthYearonth;
        if ($monthYearonth < 10) {
            $monthYearonth = '0' . $monthYearonth;
        }
        //$data['hourlyAdditionDiduction']      = $monthYearonth;
        $employeePIN = $this->hrm_model->getPinFromID($id_em, $where6);
        // Count Friday
        $fridays = $this->count_friday($monthYearonth, $year);
        $monthYearonth_holiday_count = $this->hrm_model->getNumberOfHolidays($monthYearonth, $year, $where5);
        // Total holidays and friday count
        $total_days_off = $fridays + $monthYearonth_holiday_count->total_days;
        // Total days in the month
        $total_days_in_the_month = $this->total_days_in_a_month($monthYearonth, $year);
        $total_work_days = $total_days_in_the_month - $total_days_off;
        $total_work_hours = $total_work_days * 8;
        //Format date for hours count in the hours_worked_by_employee() function
        $start_date = $year . '-' . $monthYearonth . '-' . 1;
        $end_date = $year . '-' . $monthYearonth . '-' . $total_days_in_the_month;
        // Employee actually worked
        @$employee_actually_worked = $this->hours_worked_by_employee($employeePIN->id, $start_date, $end_date); // in hours
        //Get his monthly salary
        $employee_salary = $this->hrm_model->GetsalaryValueByID($id_em, $where20);
        if ($employee_salary) {
            $employee_salary = $employee_salary->total;
        }
        // Hourly rate for the month
        $hourly_rate = $employee_salary / $total_work_hours; //15.62
        $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours);
        $data['work_h_diff'] = $work_hour_diff;
        $addition = 0;
        $diduction = 0;
        if ($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if ($work_hour_diff > 0) {
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }
        // Loan
        /* $loan_amount = $this->payroll_model->GetLoanValueByID($id_em);
        
        if($loan_amount) {
        
        $loan_amount = $loan_amount->installment;
        
        }*/
        // Sending
        $data['a'] = $addition;
        $data['d'] = $data['salary_info']->diduction;
        $this->load->view('payroll_list/invoice', $data);
    }
    private function total_days_in_a_month($monthYearonth, $year) {
        return cal_days_in_month(CAL_GREGORIAN, $monthYearonth, $year);
    }
    private function count_friday($monthYearonth, $year) {
        //  var_dump($year);
        $fridays = 0;
        $total_days = cal_days_in_month(CAL_GREGORIAN, $monthYearonth, $year);
        for ($i = 1;$i <= $total_days;$i++) {
            if (date('N', strtotime($year . '-' . $monthYearonth . '-' . $i)) == 5) {
                $fridays++;
            }
        }
        return $fridays;
    }
    // Totals hours worked by an emplyee in a month
    private function hours_worked_by_employee($employeeID, $start_date, $end_date) {
        $where4 = 'AND attendance.created_by_cid = ' . $this->companyGroupId;
        return $this->hrm_model->totalHoursWorkedByEmployeeInAMonth($employeeID, $start_date, $end_date, $where4);
    }
    public function Generate_salary() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Generate Payslip', base_url() . 'hrm/Generate_salary');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Generate Payslip';
        $where = 'user_detail.c_id = ' . $this->companyGroupId;
        $where78 = 'salary_type.created_by_cid = ' . $this->companyGroupId;
        $where10 = 'pay_salary.created_by_cid = ' . $this->companyGroupId;
        $this->data['typevalue'] = $this->hrm_model->GetsalaryType($where78);
        $this->data['employee'] = $this->hrm_model->get_data('user_detail', $where);
        $this->data['salaryvalue'] = $this->hrm_model->GetAllSalary($where10);
        $this->_render_template('generate_salary/index', $this->data);
    }
    //Recruitment
    // Generate the list of employees by dept. to generate their payments
    public function load_employee() {
        $where = 'user_detail.c_id = ' . $this->companyGroupId;
        // Get the month and year
        $date_time = $_POST['date_time'];
        $year = explode('-', $date_time);
        @$year1 = $year[0];
        @$monthYearonth = $year[1];
        $employees = $this->hrm_model->GetDepEmployee($where);
        foreach ($employees as $employee) {
            $full_name = $employee->name;
            // Loan
            echo "<tr>

                    <td>$employee->id</td>

                    <td>$full_name</td>

                    <td>$employee->total</td>

                    <td><a href='javascript:void(0)' data-id='$employee->id' data-month='$monthYearonth' data-year='$year1' data-tooltip='Generate Payslip' class='sgh btn btn-primary addBtn'>Generate Payslip</a>

                    </td>

                    

                </tr>";
        }
        // Sending
        /*   $data = array();
        
        $data['basic_salary'] = $employee_salary;
        
        $data['total_work_hours'] = $total_work_hours;
        
        $data['employee_actually_worked'] = $employee_actually_worked[0]->Hours;
        
        $data['addition'] = $addition;
        
        $data['diduction'] = $diduction;
        
        $data['loan'] = $loan_amount;
        
        echo json_encode($data);*/
    }
    public function generate_payroll_for_each_employee() {
        $where20 = 'emp_salary.created_by_cid = ' . $this->companyGroupId;
        // Get the month and year
        $monthYearonth = $_POST['month'];
        $yearx = trim($_POST['year']);
        $year = (int)$yearx;
        $employeeID = $_POST['emid'];
        $where3 = 'AND holiday.created_by_cid = ' . $this->companyGroupId;
        $where6 = 'user.c_id = ' . $this->companyGroupId;
        // Get employee PIN
        $employeePIN = $this->hrm_model->getPinFromID($employeeID, $where6);
        // Count Friday
        $fridays = $this->count_friday($monthYearonth, $year);
        $monthYearonth_holiday_count = $this->hrm_model->getNumberOfHolidays($monthYearonth, $year, $where3);
        // Total holidays and friday count
        $total_days_off = $fridays + $monthYearonth_holiday_count->total_days;
        // Total days in the month
        $total_days_in_the_month = $this->total_days_in_a_month($monthYearonth, $year);
        $total_work_days = $total_days_in_the_month - $total_days_off;
        $total_work_hours = $total_work_days * 8;
        $sdate = 01;
        //Format date for hours count in the hours_worked_by_employee() function
        //$start_date = $year . '-' . $monthYearonth . '-' . date('d');
        $result = strtotime("{$year}-{$monthYearonth}-01");
        $start_date = date('Y-m-d', $result);
        $end_date = $year . '-' . $monthYearonth . '-' . $total_days_in_the_month;
        // Employee actually worked
        @$employee_actually_worked = $this->hours_worked_by_employee($employeePIN->id, $start_date, $end_date); // in hours
        //echo json_encode($start_date);
        //Get his monthly salary
        $employee_salary = $this->hrm_model->GetsalaryValueByID($employeeID, $where20);
        if ($employee_salary) {
            @$employee_salary = $employee_salary->total;
        }
        // Hourly rate for the month
        $hourly_rate = $employee_salary / $total_work_hours;
        @$work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours); // 96 - 16 = 80
        $addition = 0;
        $diduction = 0;
        if ($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if ($work_hour_diff > 0) {
            // 80 is > 0 which means he worked less, so diduction = 80 hrs
            // so 80 * hourly rate 208 taka = 17500
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }
        // Loan
        /* $loan_amount = 0;
        
        $loan_id = 0;
        
        $loan_info = $this->payroll_model->GetLoanValueByID($employeeID);
        
        if($loan_info) {
        
        $loan_amount = $loan_info->installment;
        
        $loan_id = $loan_info->id;
        
        }*/
        // Final Salary
        $final_salary = $employee_salary + $addition - $diduction;
        // Sending
        @$data = array();
        @$data['empid'] = $employeePIN->id;
        $data['basic_salary'] = $employee_salary;
        $data['total_work_hours'] = $total_work_hours;
        @$data['employee_actually_worked'] = $employee_actually_worked[0]->Hours;
        $data['wpay'] = $total_work_hours - $employee_actually_worked[0]->Hours;
        $data['addition'] = round($addition, 2);
        $data['diduction'] = round($diduction, 2);
        //$data['loan_amount'] = $loan_amount;
        // $data['loan_id'] = $loan_id;
        $data['year'] = $year;
        $data['final_salary'] = round($final_salary, 2);
        $data['rate'] = round($hourly_rate, 2);
        $this->data['salary_data'] = $data;
        $this->load->view('generate_salary/gen_salary', $this->data);
        // echo json_encode($data);
        
    }
    /*public function Payslip_Report(){
    
    if($this->session->userdata('user_login_access') != False) {  
    
    $data=array();    
    
    $data['employee'] = $this->employee_model->emselect();
    
    $this->load->view('backend/salary_report',$data);
    
    }
    
    else{
    
    redirect(base_url() , 'refresh');
    
    }        
    
    }*/
    public function pay_salary_add_record() {
        $emid = $this->input->post('emid');
        $monthYearonth = $this->month_number_to_name($this->input->post('month'));
        $basic = $this->input->post('basic');
        $year = $this->input->post('year');
        $hours_worked = $this->input->post('hours_worked');
        $addition = $this->input->post('addition');
        $diduction = $this->input->post('diduction');
        $loan_id = $this->input->post('loan_id');
        $loan = $this->input->post('loan');
        $total_paid = $this->input->post('total_paid');
        $paydate = $this->input->post('paydate');
        $status = $this->input->post('status');
        $paid_type = $this->input->post('paid_type');
        $where3 = ' pay_salary.created_by_cid = ' . $this->companyGroupId;
        $required_fields = array('id');
        $is_valid = validate_fields($_POST, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $data = array();
            $data = array('emp_id' => $emid, 'month' => $monthYearonth, 'year' => $year, 'paid_date' => $paydate, 'total_days' => $hours_worked, 'basic' => $basic, 'loan' => $loan, 'total_pay' => $total_paid, 'addition' => $addition, 'diduction' => $diduction, 'status' => $status, 'paid_type' => $paid_type, 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId);
        }
        // pre($data);die;
        // See if record exists
        @$get_salary_record = $this->hrm_model->getSalaryRecord($emid, $monthYearonth, $year, $where3);
        if ($get_salary_record) {
            $payID = $get_salary_record[0]->pay_id;
            $payment_status = $get_salary_record[0]->status;
        }
        // If exists, add/edit
        if (isset($payID) && $payID > 0) {
            if ($payment_status == "Paid") {
                $this->session->set_flashdata('message', 'Salary Already Paid');
                redirect('hrm/emp_payroll_list', 'refresh');
            } else {
                $success = $this->hrm_model->updatePaidSalaryData($payID, $data);
                // Do the loan update
                if ($success && $status == "Paid") {
                    $this->session->set_flashdata('message', 'Salary Updated');
                    redirect('hrm/emp_payroll_list', 'refresh');
                }
            }
        } else {
            $success = $this->hrm_model->insertPaidSalaryData($data);
            if ($success) {
                $this->session->set_flashdata('message', 'Salary Added');
                redirect('hrm/emp_payroll_list', 'refresh');
            }
        }
    }
    public function month_number_to_name($monthYearonth) {
        $dateObj = DateTime::createFromFormat('!m', $monthYearonth);
        return $dateObj->format('F'); // March
        
    }
    #recurtiment
    public function recruitment() {
        $this->load->library('pagination');
        //$this->data['can_validate'] = validate_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Recruitment';
        if ($_SESSION['loggedInUser']->role != 1) {
            $where = array('created_by' => $_SESSION['loggedInUser']->id, 'created_by_cid' => $this->companyGroupId);
        } else {
            $where = array('created_by_cid' => $this->companyGroupId);
        }
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "job_position.designation like '%" . $_GET['search'] . "%' or job_position.department like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        #pre($this->data['application']);
        @$rows = $this->hrm_model->num_rows('job_position', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/recruitment/";
        $config["total_rows"] = $rows;
        $config["per_page"] = 10;
        $config["uri_segment"] = 4;
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
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        @$data['job_position'] = $this->hrm_model->get_usr_data('job_position', $where, $config["per_page"], $page, $where2, $order, $export_data);
        // error_reporting(E_ERROR | E_PARSE);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        // $data['job_position']          = $this->hrm_model->get_data1('job_position', $where);
        $this->_render_template('recruitment/job_position/index', $data);
        #   $this->_render_template('recruitment/job_position/index', $data);
        
    }
    # Function to load add/edit job_position
    public function add_job_position() {
        $id = $_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $data['job_position'] = $this->hrm_model->get_element_by_id('job_position', 'id', $id);
        $this->load->view('recruitment/job_position/add', $data);
    }
    //delete_job_position
    public function delete_job_position() {
        $id = $this->uri->segment(4);
        $this->hrm_model->delete_data('job_position', 'id', $id);
        $this->session->set_flashdata('message', 'Job Position Deleted successfully');
        redirect(base_url() . 'hrm/recruitment', 'refresh');
    }
    //save_job_position
    public function save_job_position() {
        # pre($_POST);die;
        error_reporting(E_ERROR | E_PARSE);
        if ($this->input->post()) {
            # required field server side validation
            $required_fields = array('company');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                # If form is valid
                $data = $this->input->post();
                $send_email_data['designation'] = $this->input->post('designation');
                $send_email_data['no_of_position'] = $this->input->post('no_position');
                $job = count($_POST['res']);
                if ($job > 0) {
                    $arr = array();
                    $i = 0;
                    while ($i < $job) {
                        $jsonArrayObject = array('res' => $_POST['res'][$i], 'skills' => $_POST['skills'][$i], 'add_skills' => $_POST['add_skills'][$i]);
                        $arr[$i] = $jsonArrayObject;
                        $i++;
                    }
                    $job = json_encode($arr);
                } else {
                    $job = '';
                }
                $data['job_description'] = $job;
                $id = $data['id'];
                if ($id && $id != '') {
                    unset($data['res']);
                    unset($data['skills']);
                    unset($data['add_skills']);
                    $data['created_by'] = $_SESSION['loggedInUser']->id;
                    $data['created_by_cid'] = $this->companyGroupId;
                    #   pre($data);die;
                    $success = $this->hrm_model->update_data('job_position', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Job Position updated successfully";
                        logActivity('Job Position Updated', 'job_position_updated', $id);
                    }
                    $this->session->set_flashdata('message', 'Job Position Updated successfully');
                } else {
                    $data['created_by'] = $_SESSION['loggedInUser']->id;
                    $data['created_by_cid'] = $this->companyGroupId;
                    $this->hrm_model->insert('job_position', $data);
                    $all_email = $this->get_email_data_admin_hr();
                    $this->send_email_job_application($all_email, $send_email_data);
                    $this->session->set_flashdata('message', 'Job Position successfully');
                }
            }
        }
        redirect(base_url() . 'hrm/recruitment', 'refresh');
    }
    public function view_job_position() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        $data['job_position'] = $this->hrm_model->get_element_by_id('job_position', 'id', $id);
        $this->load->view('recruitment/job_position/view', $data);
    }
    /*approve Job Position*/
    public function approveJobPosition() {
        if ($_POST['id'] && $_POST['id'] != '') {
            //pre($_POST);die;
            $data = array('approve' => $_POST['approve'], 'validated_by' => $_POST['validated_by'], 'disapprove_reason' => '', 'disapprove' => 0);
            $result = $this->hrm_model->approveJobPosition($_POST);
            if ($result) {
                logActivity('Job Position Approved', 'job_position', $_POST['id']);
                /* $usersWithViewPermissions = $this->production_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 20));
                
                if(!empty($usersWithViewPermissions)){
                
                foreach($usersWithViewPermissions as $userViewPermission){
                
                if( $userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id){ 
                
                pushNotification(array('subject'=> 'Job Card Approved' , 'message' => 'Job Card id : #'.$id.' is approved by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $userViewPermission['user_id'], 'ref_id'=> $id,'icon'=>'fa fa-archive'));
                
                }
                
                }
                
                }   
                
                if($_SESSION['loggedInUser']->role !=1){
                
                pushNotification(array('subject'=> 'Job Card Approved' , 'message' => 'Job Card id : #'.$id.' is approved by '.$_SESSION['loggedInUser']->name, 'from_id'=>$_SESSION['loggedInUser']->u_id ,'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id,'icon'=>'fa fa-archive'));
                
                }                */
                $this->session->set_flashdata('message', 'Job Position approved');
                $result = array('msg' => 'Job Position approved', 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'hrm/recruitment');
                echo json_encode($result);
                die;
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
    /*disarppove Job Position*/
    public function disApproveJobPosition() {
        if ($this->input->post()) {
            $required_fields = array('disapprove_reason');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $idss = $_POST['id'];
                $id = explode(",", $idss);
                //pre($id);die;
                foreach ($id as $key) {
                    $data = array('id' => $key, 'validated_by' => $_POST['validated_by'], 'disapprove' => $_POST['disapprove'], 'approve' => $_POST['approve'], 'disapprove_reason' => $_POST['disapprove_reason']);
                    $success = $this->hrm_model->disApprovePosition($data);
                    logActivity('Job Position Disapproved', 'job_position', $key);
                }
                if ($success) {
                    $data['message'] = "Job Position Disapproved";
                    $this->session->set_flashdata('message', 'Job Position Disapproved successfully');
                    redirect(base_url() . 'hrm/recruitment', 'refresh');
                }
            }
        }
    }
    //Job Application
    public function job_application() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Job Application';
        $where = array('created_by' => $_SESSION['loggedInUser']->id, 'created_by_cid' => $this->companyGroupId);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "(job_application.name like '%" . $_GET['search'] . "%' or job_application.email like '%" . $_GET['search'] . "%' or job_application.phone_no like '%" . $_GET['search'] . "%')";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('job_application', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/job_application/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['job_application'] = $this->hrm_model->get_usr_data('job_application', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        // $this->data['job_application'] = $this->hrm_model->get_data1('job_application', $where);
        # pre($this->data);die;
        $this->_render_template('recruitment/job_application/index', $this->data);
    }
    # Function to load add/edit job_application
    public function add_job_application() {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $where1 = array('approve' => 1, 'created_by_cid' => $this->companyGroupId);
        $data['job_position'] = $this->hrm_model->get_data1('job_position', $where1);
        $data['job_application'] = $this->hrm_model->get_element_by_id('job_application', 'id', $id);
        $data['attachments'] = $this->hrm_model->get_attachmets_by_UserId('attachments', 'rel_id', $id);
        $this->load->view('recruitment/job_application/add', $data);
    }
    //delete_job_application
    public function delete_job_application() {
        $id = $this->uri->segment(4);
        $this->hrm_model->delete_data('job_application', 'id', $id);
        $this->session->set_flashdata('message', 'Job Application Deleted successfully');
        redirect(base_url() . 'hrm/job_application', 'refresh');
    }
    //save_job_application
    public function save_job_application() {
        if ($this->input->post()) {
            $required_fields = array('company');
            $is_valid = validate_fields($_POST, $required_fields);
            #   pre($_FILES['resume_upload']);die;
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                # if ($this->input->post('resume_upload1') != '') {
                # pre($_FILES);die;
                if ($_FILES['resume_upload']['size'] == 0) {
                    $data['resume_upload'] = $_POST['resume_upload1'];
                    #  $resume_upload1   = $this->input->post('resume_upload1');
                    #     $data['resume_upload'] = $resume_upload1;
                    unset($data['resume_upload1']);
                    # pre($data);die;
                    
                } else {
                    $config['upload_path'] = './assets/modules/hrm/uploads/';
                    $config['allowed_types'] = '*';
                    # $config['allowed_types'] = 'gif|jpg|jpeg|png|doc|pdf|docx|ods|.xls|.xlsx';
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('resume_upload')) {
                        $error = array('error' => $this->upload->display_errors());
                        $data['resume_upload'] = '';
                    } else {
                        $data1 = array();
                        $data1 = array('resume_upload' => $this->upload->data());
                        $file_namex = $_FILES['resume_upload']['name'];
                        $data['resume_upload'] = str_replace(" ", "_", $file_namex);
                        #  $data['resume_upload'] = $newfile_name= preg_replace('/[^A-Za-z0-9]/', "",);
                        
                    }
                }
                $id = $data['id'];
                if ($id && $id != '') {
                    $data['status'] = 3;
                    $data['created_by'] = $_SESSION['loggedInUser']->id;
                    $data['created_by_cid'] = $this->companyGroupId;
                    $success = $this->hrm_model->update_data('job_application', $data, 'id', $id);
                    if ($success) {
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
                                $config['upload_path'] = 'assets/modules/hrm/uploads/';
                                $config['upload_url'] = base_url() . 'assets/modules/hrm/uploads/';
                                #    $config['allowed_types'] = "gif|jpg|jpeg|png|doc|pdf|docx|ods|.xls|.xlsx";
                                $config['allowed_types'] = '*';
                                $config['max_size'] = '2000000';
                                $config['file_name'] = $newname;
                                $this->load->library('upload', $config);
                                move_uploaded_file($tmpname, "assets/modules/hrm/uploads/" . $newname);
                                $attachment_array[$i]['rel_id'] = $id;
                                $attachment_array[$i]['rel_type'] = 'job_applicant_docs';
                                $attachment_array[$i]['file_name'] = $newname;
                                $attachment_array[$i]['file_type'] = $type;
                            }
                            if (!empty($attachment_array)) {
                                /* Insert file information into the database */
                                $attachmentId = $this->hrm_model->insert_attachment_data('attachments', $attachment_array, 'hrm/add_job_application/' . $data['id']);
                            }
                        }
                        $data['message'] = "Job Application updated successfully";
                        logActivity('Job Application Updated', 'job_application_updated', $id);
                    }
                    $this->session->set_flashdata('message', 'Job Application Updated successfully');
                } else {
                    $data['status'] = 3;
                    $data['created_by'] = $_SESSION['loggedInUser']->id;
                    $data['created_by_cid'] = $this->companyGroupId;
                    #  pre($data);die;
                    $insertedid = $this->hrm_model->insert('job_application', $data);
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
                            $config['upload_path'] = 'assets/modules/hrm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/hrm/uploads/';
                            #  $config['allowed_types'] = "gif|jpg|jpeg|png|doc|pdf|docx|ods|.xls|.xlsx";
                            $config['allowed_types'] = '*';
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/hrm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $insertedid;
                            $attachment_array[$i]['rel_type'] = 'job_applicant_docs';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            #  pre($attachment_array);die;
                            $attachmentId = $this->hrm_model->insert_attachment_data('attachments', $attachment_array, 'hrm/add_job_application/' . $insertedid);
                        }
                    }
                    $this->session->set_flashdata('message', 'Job Application Added successfully');
                }
            }
        }
        redirect(base_url() . 'hrm/job_application', 'refresh');
    }
    public function xsave_job_application() {
        if ($this->input->post()) {
            # required field server side validation
            $required_fields = array('company');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                # If form is valid
                $data = $this->input->post();
                if ($this->input->post('resume_upload1') != '') {
                    $data['resume_upload'] = $this->input->post('resume_upload1');
                } else {
                    $config['upload_path'] = './assets/modules/hrm/uploads/';
                    $config['allowed_types'] = 'jpg|jpeg|JPG|doc|pdf|ods';
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('resume_upload')) {
                        $error = array('error' => $this->upload->display_errors());
                        $data['resume_upload'] = '';
                    } else {
                        $data1 = array();
                        $data1 = array('resume_upload' => $this->upload->data());
                        $data['resume_upload'] = $data1['resume_upload']['orig_name'];
                    }
                }
                $id = $data['id'];
                if ($id && $id != '') {
                    $data['status'] = 3;
                    $data['created_by'] = $_SESSION['loggedInUser']->id;
                    $data['created_by_cid'] = $this->companyGroupId;
                    unset($data['resume_upload1']);
                    $success = $this->hrm_model->update_data('job_application', $data, 'id', $id);
                    if ($success) {
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
                                $config['upload_path'] = 'assets/modules/hrm/uploads/';
                                $config['upload_url'] = base_url() . 'assets/modules/hrm/uploads/';
                                $config['allowed_types'] = "gif|jpg|jpeg|png|doc|pdf|docx|ods";
                                $config['max_size'] = '2000000';
                                $config['file_name'] = $newname;
                                $this->load->library('upload', $config);
                                move_uploaded_file($tmpname, "assets/modules/hrm/uploads/" . $newname);
                                $attachment_array[$i]['rel_id'] = $id;
                                $attachment_array[$i]['rel_type'] = 'job_applicant_docs';
                                $attachment_array[$i]['file_name'] = $newname;
                                $attachment_array[$i]['file_type'] = $type;
                            }
                            if (!empty($attachment_array)) {
                                /* Insert file information into the database */
                                $attachmentId = $this->hrm_model->insert_attachment_data('attachments', $attachment_array, 'hrm/add_job_application/' . $data['id']);
                            }
                        }
                        $data['message'] = "Job Application updated successfully";
                        logActivity('Job Application Updated', 'job_application_updated', $id);
                    }
                    $this->session->set_flashdata('message', 'Job Application Updated successfully');
                } else {
                    $data['status'] = 3;
                    $data['created_by'] = $_SESSION['loggedInUser']->id;
                    $data['created_by_cid'] = $this->companyGroupId;
                    $insertedid = $this->hrm_model->insert('job_application', $data);
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
                            $config['upload_path'] = 'assets/modules/hrm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/hrm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|doc|pdf|docx|ods";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/hrm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $insertedid;
                            $attachment_array[$i]['rel_type'] = 'job_applicant_docs';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        }
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->hrm_model->insert_attachment_data('attachments', $attachment_array, 'hrm/add_job_application/' . $insertedid);
                        }
                    }
                    $this->session->set_flashdata('message', 'Job Application Added successfully');
                }
            }
        }
        redirect(base_url() . 'hrm/job_application', 'refresh');
    }
    //job application
    public function view_job_application() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        $where1 = array('approve' => 1, 'created_by_cid' => $this->companyGroupId);
        $data['job_position'] = $this->hrm_model->get_data1('job_position', $where1);
        // $data['job_position'] = $this->hrm_model->get_list('job_position');
        $data['job_application'] = $this->hrm_model->get_element_by_id('job_application', 'id', $id);
        $data['attachments'] = $this->hrm_model->get_attachmets_by_UserId('attachments', 'rel_id', $id);
        $where = array('created_by' => $_SESSION['loggedInUser']->id, 'created_by_cid' => $this->companyGroupId, 'applicant_id' => $id);
        $data['rating_data'] = $this->hrm_model->get_data1('job_applicant_rating', $where);
        $this->load->view('recruitment/job_application/view', $data);
    }
    public function convertUser() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        //$where1 = array('approve' => 1, 'created_by_cid' =>$this->companyGroupId );
        //   $data['job_position'] = $this->hrm_model->get_data1('job_position', $where1);
        // $data['job_position'] = $this->hrm_model->get_list('job_position');
        $data['job_application'] = $this->hrm_model->get_element_by_id('job_application', 'id', $id);
        $data['attachments'] = $this->hrm_model->get_attachmets_by_UserId('attachments', 'rel_id', $id);
        //$where = array('created_by' => $_SESSION['loggedInUser']->id, 'created_by_cid' =>$this->companyGroupId , 'applicant_id' =>$id);
        //$data['rating_data'] = $this->hrm_model->get_data1('job_applicant_rating', $where);
        //pre($data);die;
        $this->load->view('recruitment/pipeline/convertUser', $data);
    }
    //job applicant Rating
    public function rate_job_application() {
        // pre($_POST);die;
        $id = $_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $data['job_position'] = $this->hrm_model->get_list('job_position');
        $data['job_application'] = $this->hrm_model->get_element_by_id('job_application', 'id', $id);
        $where = array('created_by' => $_SESSION['loggedInUser']->id, 'created_by_cid' => $this->companyGroupId, 'applicant_id' => $id, 'interview_step' => $data['job_application']->status);
        $data['rating'] = $this->hrm_model->get_data1('job_applicant_rating', $where);
        $data['attachments'] = $this->hrm_model->get_attachmets_by_UserId('attachments', 'rel_id', $id);
        $this->load->view('recruitment/pipeline/edit', $data);
    }
    public function saveRating() {
        //pre($this->input->post());die;
        $id = $this->input->post('id');
        if ($this->input->post()) {
            $data = array();
            $data = $this->input->post();
            $data['created_by'] = $_SESSION['loggedInUser']->u_id;
            $data['created_by_cid'] = $this->companyGroupId;
            //pre($data);die;
            if (empty($id)) {
                $id = $this->hrm_model->Add_Rating($data);
                $status = $this->input->post('interview_step') + 1;
                $applicant_id = $this->input->post('applicant_id');
                $this->hrm_model->change_status_tbl('job_application', $applicant_id, $status);
                logActivity('Rating Inserted Successfully', 'Rating', $id);
                $this->session->set_flashdata('message', 'Successfully Updated');
                redirect("hrm/job_position_pipeline");
                echo "Successfully Added";
            } else {
                $sucess = $this->hrm_model->Update_Rating($id, $data);
                $status = $this->input->post('interview_step') + 1;
                $applicant_id = $this->input->post('applicant_id');
                $this->hrm_model->change_status_tbl('job_application', $applicant_id, $status);
                logActivity('Rating Updated Successfully', 'Rating', $id);
                $this->session->set_flashdata('message', 'Successfully Updated');
                redirect("hrm/job_position_pipeline");
                echo "Successfully Updated";
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /* Delete Docs function*/
    public function delete_doc($id = '', $docsId = '') {
        if (!$id) {
            redirect('hrm/job_application', 'refresh');
        }
        $result = $this->hrm_model->delete_data('attachments', 'id', $id);
        if ($result) {
            logActivity('Document Deleted Successfully', 'User_Docs', $id);
            $this->session->set_flashdata('message', 'Document Deleted Successfully');
            //redirect(base_url() . 'hrm/job_application', 'refresh');
            // $result = array('msg' => 'Document Deleted Successfully', 'status' => 'success', 'code' => 'C174','url' => base_url() . 'purchase/suppliers/supplier_edit/'.$docsId);
            // echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    public function job_position_pipeline() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Pipe Line', base_url() . 'hrm/pipeline');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Pipeline';
        $where1 = array('approve' => 1, 'created_by_cid' => $this->companyGroupId);
        //$this->data['job_position'] = $this->hrm_model->get_list('job_position');
        $this->data['job_position'] = $this->hrm_model->get_data1('job_position', $where1);
        $where = array('c_id' => $this->companyGroupId);
        $c_id = $this->companyGroupId;
        $array = array();
        //$where = array('created_by_cid' =>$this->companyGroupId );
        $this->data['processType'] = $this->hrm_model->get_status_data('job_position_status');
        $i = 0;
        $job_position_id = $this->input->post('job_position_id');
        foreach ($this->data['processType'] as $ProcessType) {
            if ($job_position_id == '') {
                $process = $this->hrm_model->get_status_pipeline('job_application', $ProcessType['id'], $c_id);
            } else {
                $process = $this->hrm_model->get_status_job_pipeline('job_application', $ProcessType['id'], $job_position_id, $c_id);
            }
            $array[$i]['types'] = $ProcessType;
            $array[$i]['process'] = $process;
            $i++;
        }
        $this->data['processdata'] = $array;
        //    pre($this->data);die;
        $this->_render_template('hrm/recruitment/pipeline/index', $this->data);
    }
    public function changeProcessType2() {
        $data = $this->input->post();
        $id = $data['processId'];
        $process_status = $this->hrm_model->change_process_status1('job_application', $data, $id);
        $this->_render_template('hrm/recruitment/pipeline/index', $process_status);
    }
    public function changeOrder2() {
        $orders = $_POST['order'];
        //pre($orders);
        $process_order = $this->hrm_model->change_process_order('job_application', $orders);
        echo json_encode(array('msg' => 'error', 'status' => 'success', 'code' => 'C774'));
    }
    // For Indexing Terms & Condtions
    public function hrmterms_condtn() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Settings', base_url() . 'hrm/settings');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Settings';
        $where = array('created_by_cid' => $this->companyGroupId);
        // $this->data['termsconds']      = $this->hrm_model->get_data('hrm_terms', array('created_by_cid' =>$this->companyGroupId ));
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "( hrm_terms.title like '%" . $_GET['search'] . "%' or hrm_terms.terms_cond like '%" . $_GET['search'] . "%')";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('hrm_terms', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/hrmterms_condtn/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['termsconds'] = $this->hrm_model->get_usr_data('hrm_terms', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        $this->_render_template('settings/terms_conditions/index', $this->data);
    }
    //  For Editing Terms & Conditions
    public function editterms_condtn() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['termsconds'] = $this->hrm_model->get_element_by_id('hrm_terms', 'id', $this->input->post('id'));
        $this->load->view('settings/terms_conditions/edit', $this->data);
    }
    public function delete_terms_condtn() {
        $result = $this->hrm_model->delete_data('hrm_terms', 'id', $this->uri->segment(3));
        if ($result) {
            $this->session->set_flashdata('message', ' Deleted Successfully');
            redirect(base_url() . 'hrm/hrmterms_condtn', 'refresh');
        }
    }
    // For Viewing Terms & Conditions
    public function termscond_view() {
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_view');
        }
        $this->data['termsconds'] = $this->hrm_model->get_element_by_id('hrm_terms', 'id', $id);
        $this->load->view('settings/terms_conditions/view', $this->data);
    }
    // For Saving Terms & Conditions
    public function saveterms_condtn() {
        #pre($_POST);
        if ($this->input->post()) {
            $required_fields = array('title', 'terms_cond');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $id = $data['id'] = $this->input->post('id');
                $data['title'] = $this->input->post('title');
                $data['terms_cond'] = $this->input->post('terms_cond');
                $data['created_by'] = $_SESSION['loggedInUser']->id;
                $data['created_by_cid'] = $this->companyGroupId;
                // $id="";
                //  $data['id'] =   $id     ;
                //  $usersWithViewPermissions = $this->crm_model->get_data('permissions', array('is_view' => 1 , 'sub_module_id' => 95));
                if ($id && $id != '') {
                    $success = $this->hrm_model->update_data('hrm_terms', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Terms & Conditions updated successfully";
                        logActivity('Terms & Conditions updated', 'lead', $id);
                        if ($_SESSION['loggedInUser']->role != 1) {
                            /*  pushNotification(array('subject'=> 'CRM terms & conditions updated' , 'message' => 'CRM terms & conditions updated by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id'=> $id));*/
                            pushNotification(array('subject' => 'terms & conditions updated', 'message' => 'terms & conditions updated : #' . $id . 'is updated by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'qualityTab', 'data_id' => 'termscond_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'Terms & Conditions updated successfully');
                    }
                } else {
                    //  pre($data);die;
                    $id = $this->hrm_model->insert('hrm_terms', $data);
                    //  echo $this->db->last_query();die;
                    if ($id) {
                        logActivity('New Terms & Conditions Created', 'Terms & Conditions', $id);
                        if ($_SESSION['loggedInUser']->role != 1) {
                            pushNotification(array('subject' => 'terms & conditions created', 'message' => 'New terms & conditions created by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInCompany']->u_id, 'ref_id' => $id, 'class' => 'qualityTab', 'data_id' => 'termscond_view', 'icon' => 'fa fa-shekel'));
                        }
                        $this->session->set_flashdata('message', 'New Terms & Conditions Created', 'Terms & Conditions');
                    }
                }
                redirect(base_url() . 'hrm/hrmterms_condtn', 'refresh');
            }
        }
    }
    public function Payslip_Report() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Payroll', base_url() . 'hrm/Payslip_Report');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Payslip Report';
        $where = 'pay_salary.created_by_cid = ' . $this->companyGroupId;
        $this->data['salary_info'] = $this->hrm_model->getAllSalaryData($where);
        $this->_render_template('payroll_report/index', $this->data);
    }
    public function users_salary() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Employee Salary', base_url() . 'hrm/users_salary');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Employees Salary';
        $where = array('created_by_cid' => $this->companyGroupId);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $EmpName = getNameBySearch('user_detail', $_GET['search'], 'name');
            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "(emp_salary.emp_id ='" . $name['u_id'] . "')";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "emp_salary.total='" . $_GET['search'] . "'";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('emp_salary', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/users_salary/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['catvalue'] = $this->hrm_model->get_usr_data('emp_salary', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        //$this->data['catvalue']        = $this->hrm_model->get_data('emp_salary', $where);
        #pre($this->data['application']);
        $this->_render_template('users_salary/index', $this->data);
    }
    public function users_salary_edit() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['salary_slab'] = $this->hrm_model->get_data('salary_slab', array('salary_slab.created_by_cid' => $this->companyGroupId));
        $this->data['users'] = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1));
        $this->data['salary_val'] = $this->hrm_model->get_data_byId_wo('emp_salary', 'id', $id);
        $this->load->view('users_salary/add', $this->data);
    }
    public function users_salary_view() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            $this->data['salary_val'] = $this->hrm_model->get_data_byId_wo('emp_salary', 'id', $id);
            $this->data['salary_val'] = $this->hrm_model->get_data_byId_wo('emp_salary', 'id', $id);
            $this->load->view('users_salary/view', $this->data);
        } else {
            redirect(base_url() . 'hrm/users_salary', 'refresh');
        }
    }
    public function delete_users_salary() {
        $id = $this->uri->segment('3');
        if ($id == '') {
            redirect(base_url() . 'hrm/users_salary', 'refresh');
        }
        $this->hrm_model->delete_data('emp_salary', 'id', $id);
        $this->session->set_flashdata('message', ' Deleted Successfully');
        redirect(base_url() . 'hrm/users_salary', 'refresh');
    }
    /*salary slab starts*/
    public function salary_slab() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Employees Salary Slab', base_url() . 'hrm/users_salary');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Employees Salary Slab';
        $where = array('created_by_cid' => $this->companyGroupId);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "salary_from ='" . $_GET['search'] . "' or salary_to = '" . $_GET['search'] . "'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('salary_slab', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/salary_slab/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['catvalue'] = $this->hrm_model->get_usr_data('salary_slab', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        //$this->data['catvalue']        = $this->hrm_model->get_data('salary_slab', $where);
        #pre($this->data['application']);
        $this->_render_template('salary_slab/index', $this->data);
    }
    public function salary_slab_edit() {
        $id = $_POST['id'];
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        if ($id != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $where = array('id' => $id);
        $this->data['salary_val'] = $this->hrm_model->get_data_byId_wo('salary_slab', 'id', $id);
        # $this->data['salary_val'] = $this->hrm_model->get_data_byId_wo('salary_slab', 'id', $id);
        $this->load->view('salary_slab/add', $this->data);
    }
    public function salary_slab_view() {
        $this->scripts['js'][] = 'assets/modules/purchase/js/test.js';
        $id = $_POST['id'];
        if ($id != '') {
            $this->data['salary_val'] = $this->hrm_model->get_data_byId_wo('salary_slab', 'id', $id);
            $this->load->view('salary_slab/view', $this->data);
        } else {
            redirect(base_url() . 'hrm/users_salary', 'refresh');
        }
    }
    public function delete_salary_slab() {
        $id = $this->uri->segment('3');
        if ($id == '') {
            redirect(base_url() . 'hrm/users_salary', 'refresh');
        }
        $this->hrm_model->delete_data('salary_slab', 'id', $id);
        $this->session->set_flashdata('message', ' Deleted Successfully');
        redirect(base_url() . 'hrm/salary_slab', 'refresh');
    }
    /*salary slab ends*/
      public function saveempsalaryslab() {
         
        if ($this->input->post()) {
            $required_fields = array('slab_start_date', 'slab_end_date', 'salary_from', 'salary_to');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $jsonEmpSalaryArrayObject = (array('basic' => $_POST['basic'], 'hra' => $_POST['hra'], 'ca' => $_POST['ca'], 'sa' => $_POST['sa'],   'others' => $_POST['others'], 'pf' => $_POST['pf'],'lwf' => $_POST['lwf'], 'esic' => $_POST['esic'], 'da' => $_POST['da'], 'medical' => $_POST['medical'], 'tds' => $_POST['tds'],'esic_employer' => $_POST['esic_employer'],'pf_employer' => $_POST['pf_employer'],'lwf_employer' => $_POST['lwf_employer']));

                $total_charges=$_POST['basic']+$_POST['others']+$_POST['hra']+$_POST['ca']+$_POST['sa']+$_POST['da']+$_POST['medical'];

                if($total_charges!=100){
                   $this->session->set_flashdata('message', 'Please check Total Charges can be 100%');
                   redirect(base_url() . 'hrm/salary_slab', 'refresh'); 
                }
                $empSalary = json_encode($jsonEmpSalaryArrayObject);
                $data = $this->input->post();
                $id = $data['id'];
                $data['salary_from'] = $_POST['salary_from'];
                $data['salary_to'] = $_POST['salary_to'];
                $data['slab_end_date'] = $_POST['slab_end_date'];
                $data['slab_start_date'] = $_POST['slab_start_date'];
                $data['slab_structure'] = $empSalary;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $data['created_date'] = date('Y-m-d H:i:s');
                # pre($data);die;
                if ($id && $id != '') {
                    
                    $success = $this->hrm_model->update_data('salary_slab', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Salary Slab Updated Successfully";
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
                        logActivity('ESalary Slab Update', 'emp_salary', $id);
                        $this->session->set_flashdata('message', 'Salary Slab Updated successfully');
                        redirect(base_url() . 'hrm/salary_slab', 'refresh');
                    }
                } else {
                    
                    $id = $this->hrm_model->insert_tbl_data('salary_slab', $data);
                    if ($id) {
                        logActivity('Salary Slab Inserted', 'salary_slab', $id);
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
                        $this->session->set_flashdata('message', 'Salary Slab inserted successfully');
                        redirect(base_url() . 'hrm/salary_slab', 'refresh');
                    }
                }
            }
        }
    }
  public function saveempsalary() { 
        if ($this->input->post()) {
            $required_fields = array('emp_id');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                 $total=$this->input->post('total');
                           $basic= $this->input->post('basic');
                           $basicNewPre=((float)$basic/(float)$total)*100;
                           $da= $this->input->post('da');
                           $daNewPre=((float)$da/(float)$total)*100;
                           $hra= $this->input->post('hra');
                           $hraNewPre=((float)$hra/(float)$total)*100;
                           $ca= $this->input->post('ca');
                           $caNewPre=((float)$ca/(float)$total)*100;
                           $sa= $this->input->post('sa');
                           $saNewPre=((float)$sa/(float)$total)*100;
                           $monthYearedical= $this->input->post('medical');
                           $monthYearedicalNewPre=((float)$monthYearedical/(float)$total)*100;
                           $others= $this->input->post('others');
                           $othersNewPre=((float)$others/(float)$total)*100;
                           $esic= $this->input->post('esic');
                           $esicNewPre=((float)$esic/(float)$total)*100;
                           $tds= $this->input->post('tds');
                           $tdsNewPre=((float)$tds/(float)$total)*100;
                           $pf= $this->input->post('pf');
                           $pfNewPre=((float)$pf/(float)$basic)*100;
                           $lwf= $this->input->post('lwf');
                         //  $lwfNewPre=((float)$lwf/(float)$total)*100;
                           $esic_employer= $this->input->post('esic_employer');
                           $esic_employerNewPre=((float)$esic_employer/(float)$total)*100;
                           $pf_employer= $this->input->post('pf_employer');
                           $pf_employerNewPre=((float)$pf_employer/(float)$basic)*100;
                           $lwf_employer= $this->input->post('lwf_employer');
                         //  $lwf_employerNewPre=((float)$lwf_employer/(float)$total)*100;
            
                $jsonEmpSalaryArrayObject = (array(
                         'basic' =>$basicNewPre,
                         'da' =>$daNewPre,
                         'hra' =>$hraNewPre,
                         'ca' =>$caNewPre,
                         'sa' =>$saNewPre,
                         'medical' =>$monthYearedicalNewPre,
                         'others' =>$othersNewPre,
                         'esic' =>$esicNewPre,
                         'tds' =>$tdsNewPre,
                         'pf' =>$pfNewPre,
                         'lwf' =>$lwf,
                         'esic_employer' =>$esic_employerNewPre,
                         'pf_employer' =>$pf_employerNewPre,
                         'lwf_employer' =>$lwf_employer));
                
                $empSalary = json_encode($jsonEmpSalaryArrayObject);
                $data = $this->input->post();
                #pre();die;
                $emp_id = $data['emp_id'];
                $id = $data['id'];
                $data['salary_details'] = $empSalary;
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 115));
                if ($id && $id != '') {
                    $success = $this->hrm_model->update_data('emp_salary', $data, 'id', $id);
                    if ($success) {
                        $data['message'] = "Employees Salary Updated Successfully";
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
                        logActivity('Employees Salary Update', 'emp_salary', $id);
                        $this->session->set_flashdata('message', 'Employee Salary Updated successfully');
                        redirect(base_url() . 'hrm/users_salary', 'refresh');
                    }
                } else {
                    $field_name = 'emp_id';
                    $check = $this->hrm_model->check_tbl_by_id('emp_salary', $emp_id, $field_name, $this->companyGroupId);
                    if ($check > 0) {
                        $this->session->set_flashdata('message', 'Employees Salary Already Exists');
                        redirect(base_url() . 'hrm/users_salary', 'refresh');
                    }
                    $id = $this->hrm_model->insert_tbl_data('emp_salary', $data);
                    if ($id) {
                        logActivity('Employees Salary Inserted', 'emp_salary', $id);
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
                        $this->session->set_flashdata('message', 'Employees Salary inserted successfully');
                        redirect(base_url() . 'hrm/users_salary', 'refresh');
                    }
                }
            }
        }
    }
    public function uploadData() {

        echo error_reporting(E_ERROR | E_PARSE);
        $atten_date = $this->input->post('atten_date');
        $path = 'assets/modules/hrm/uploads/';
        require_once APPPATH . "/third_party/PHPExcel.php";
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
        if (empty($error)) {
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
                $i = 0;
                $k = 1;
                foreach ($allDataInSheet as $value) {
                   // pre($value);
                    if ($flag) {
                        $flag = false;
                        continue;
                    }
                    if (!empty($value['B']) && $k >= 8) {
                        $biometric_id = getNameById('user_detail', $value['B'], 'biometric_id');
                        if (@$biometric_id->c_id == $this->companyGroupId) {
                            $same_company = "True";
                        } else {
                            $same_company = "";
                        }
                        # if(!empty($biometric_id) && !empty($same_company))
                        if (!empty($biometric_id) && !empty($same_company)) {
                            $inserdata[$i]['emp_id'] = @$biometric_id->u_id;
                            #  $inserdata[$i]['emp_id']   =   $value['B'];
                            $inserdata[$i]['biometric_id'] = $value['C'];
                            $inserdata[$i]['atten_date'] = $atten_date;
                            $inserdata[$i]['card_no'] = $value['C'];
                            $inserdata[$i]['shift'] = $value['E'];
                            $inserdata[$i]['signin_time'] = date("H:i:s", strtotime($value['G']));
                            $inserdata[$i]['signout_time'] = date("H:i:s", strtotime($value['T']));
                            $inserdata[$i]['status'] = $value['U'];
                            $inserdata[$i]['created_by_cid'] = $this->companyGroupId;
                        }
                    }
                    $i++;
                    $k++;
                }

                $attendanceData = array_map('array_filter', $inserdata);
                $attendanceData = array_filter($attendanceData);
                foreach ($attendanceData as $key => $value) {
                    /*For attendance(Present) should not get inserted in Leave*/
                    $biometric_id = $attendanceData[$key]['biometric_id'];
                    $biometric_idd = getNameById('user_detail', $biometric_id, 'biometric_id');
                    $emp_id = @$biometric_idd->u_id;
                    $leave_check = getEmpLeave_check('emp_leave', $emp_id, $atten_date, $this->companyGroupId);
                    if ($leave_check > 0) {
                        $status = 'A';
                    } else {
                        $status = $attendanceData[$key]['status'];
                    } 
                    $atten_date = $attendanceData[$key]['atten_date'];
                    $created_by_cid = $attendanceData[$key]['created_by_cid'];
                    $signin_time = $attendanceData[$key]['signin_time'];
                    $signout_time = $attendanceData[$key]['signout_time'];
                    $where = array('biometric_id' => $biometric_id, 'atten_date' => $atten_date, 'created_by_cid' => $created_by_cid);
                    $check_data = $this->hrm_model->checkExcel_AttendanceData($where);
                    if ($check_data > 0) {
                        $data = array('signin_time' => $signin_time, 'signout_time' => $signout_time, 'status' => $status);
                        $result = $this->hrm_model->excelUpdate_AttendanceData($where, $data);
                    } else {
                        if ($value['signin_time'] == "05:30:00") {
                            $value['signin_time'] = "";
                        }
                        if ($value['signout_time'] == "05:30:00") {
                            $value['signout_time'] = "";
                        } 
                       //  $result = $this->hrm_model->Add_AttendanceData($value);
                    }
                }
                echo error_reporting(E_ERROR | E_PARSE);
                if ($result) {
                    echo "Imported successfully";
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
        redirect('hrm/Attendance', 'refresh');
    }
    #WeekOff Sub-module start
    public function weekoff() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('WeekOFF Holiday List', base_url() . 'hrm/holiday');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'WeekOff List';
        $where = 'created_by_cid = ' . $this->companyGroupId;
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "day like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('worker_weekoff', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/weekoff/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['holidays'] = $this->hrm_model->GetWeekOffInfo('worker_weekoff', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        //$this->data['holidays']        = $this->hrm_model->GetWeekOffInfo($where);
        $this->_render_template('weekoff/index', $this->data);
    }
    // For Editing Attendance
    public function weekoffedit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        //  $this->data['users'] = $this->hrm_model->get_data('user_detail');
        $this->data['holiday'] = $this->hrm_model->get_data_byId('worker_weekoff', 'id', $this->input->post('id'));
        //  pre($this->data);die;
        $this->load->view('weekoff/add', $this->data);
    }
    public function saveWeekoff() {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $day = $this->input->post('day');
            $required_fields = array('day');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = array();
                $data = array('day' => $day, 'created_by_cid' => $this->companyGroupId);
                if (empty($id)) {
                    $success = $this->hrm_model->Add_WeekoffInfo($data);
                    logActivity('Weekoff Inserted Successfully', 'Weekoff', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect("hrm/weekoff");
                    echo "Successfully Added";
                } else {
                    $success = $this->hrm_model->Update_WeekoffInfo($id, $data);
                    logActivity('Weekoff Updated Successfully', 'Weekoff', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect("hrm/weekoff");
                    echo "Successfully Updated";
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function deleteweekoffHoliday($id = '') {
        //
        if (!$id) {
            redirect('hrm/weekoff', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->hrm_model->delete_data('worker_weekoff', 'id', $id);
        if ($result) {
            logActivity('WeekOFF Deleted', 'worker_weekoff', $id);
            $this->session->set_flashdata('message', 'WeekOFF Deleted Successfully');
            $result = array('msg' => 'WeekOFF Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'hrm/weekoff');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    //employee week off
    public function emp_weekoff() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('WeekOFF Holiday List', base_url() . 'hrm/emp_weekoff');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Employee WeekOff List';
        $where = ' created_by_cid = ' . $this->companyGroupId;
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "day like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('employee_weekoff', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/emp_weekoff/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['holidays'] = $this->hrm_model->GetEmpWeekOffInfo('employee_weekoff', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        // $this->data['holidays']        = $this->hrm_model->GetEmpWeekOffInfo($where);
        $this->_render_template('emp_weekoff/index', $this->data);
    }
    // For Editing Attendance
    public function empweekoffedit() {
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $this->data['holiday'] = $this->hrm_model->get_data_byId('employee_weekoff', 'id', $this->input->post('id'));
        $this->load->view('emp_weekoff/add', $this->data);
    }
    public function empsaveWeekoff() {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $day = $this->input->post('day');
            $required_fields = array('day');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = array();
                $data = array('day' => $day, 'created_by_cid' => $this->companyGroupId);
                #  pre($_POST);die;
                if (empty($id)) {
                    $field_name = 'day';
                    $check = $this->hrm_model->check_tbl_by_id('employee_weekoff', $day, $field_name, $this->companyGroupId);
                    if ($check > 0) {
                        $this->session->set_flashdata('message', 'Duplicate Record Found');
                        redirect("hrm/emp_weekoff");
                    }
                    $success = $this->hrm_model->Add_EmpWeekoffInfo($data);
                    logActivity('Weekoff Inserted Successfully', 'Weekoff', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect("hrm/emp_weekoff");
                    echo "Successfully Added";
                } else {
                    $success = $this->hrm_model->Update_EmpWeekoffInfo($id, $data);
                    logActivity('Weekoff Updated Successfully', 'Weekoff', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect("hrm/emp_weekoff");
                    echo "Successfully Updated";
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function deleteempweekoffHoliday($id = '') {
        //
        if (!$id) {
            redirect('hrm/emp_weekoff', 'refresh');
        }
        permissions_redirect('is_delete');
        $result = $this->hrm_model->delete_data('employee_weekoff', 'id', $id);
        if ($result) {
            logActivity('WeekOFF Deleted', 'employee_weekoff', $id);
            $this->session->set_flashdata('message', 'WeekOFF Deleted Successfully');
            $result = array('msg' => 'WeekOFF Deleted Successfully', 'status' => 'success', 'code' => 'C142', 'url' => base_url() . 'hrm/emp_weekoff');
            echo json_encode($result);
            die;
        } else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C1004'));
        }
    }
    /* ..............TA/DA Management---------------------*/
    //travel info
    public function travel_info() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('TA/DA List', base_url() . 'hrm/travel_info');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'TA/DA List';
        $where = array('created_by_cid' => $this->companyGroupId, 'paid_status' => 0);
        if (!empty($_GET['tab']) == 'pending' && $_GET['tab'] != 'complete') {
            $where = array('created_by_cid' => $this->companyGroupId, 'paid_status' => 0);
        }
        if (!empty($_GET['tab']) == 'complete' && $_GET['tab'] != 'pending') {
            $where = array('created_by_cid' => $this->companyGroupId, 'paid_status' => 1);
        }
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $EmpName = getNameBySearch('user_detail', $_GET['search'], 'name');
            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "travel_info.created_by ='" . $name['u_id'] . "'";
            }
            if (sizeof($where2) != '') {
                $where2 = implode("||", $where2);
            } else {
                $where2 = "travel_details like '[{\"travel_from\":\"%" . $_GET['search'] . "%\"}]' or '[{\"travel_to\":\"%" . $_GET['search'] . "%\"}]' or '[{\"travel_mode\":\"%" . $_GET['search'] . "%\"}]'";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('travel_info', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/travel_info/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        if (!empty($_GET['tab']) == 'pending' && $_GET['tab'] != 'complete') {
            $this->data['unpaid_list'] = $this->hrm_model->get_usr_data('travel_info', $where, $config["per_page"], $page, $where2, $order, $export_data);
        } elseif (!empty($_GET['tab']) == 'complete' && $_GET['tab'] != 'pending') {
            $this->data['paid_list'] = $this->hrm_model->get_usr_data('travel_info', $where, $config["per_page"], $page, $where2, $order, $export_data);
        } else {
            //$this->data['paid_list']       = $this->hrm_model->get_usr_data('travel_info',$where,$config["per_page"], $page, $where2, $order, $export_data);
            $this->data['unpaid_list'] = $this->hrm_model->get_usr_data('travel_info', $where, $config["per_page"], $page, $where2, $order, $export_data);
        }
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        $this->_render_template('travel_info/index', $this->data);
    }
    //delete travel info
    public function delete_travel_info() {
        $id = $this->uri->segment('3');
        if ($id == '') {
            redirect(base_url() . 'hrm/travel_info', 'refresh');
        }
        $this->hrm_model->delete_data('travel_info', 'id', $id);
        $this->session->set_flashdata('message', ' Deleted Successfully');
        redirect(base_url() . 'hrm/travel_info', 'refresh');
    }
    # Function to load add/edit job_application
    public function add_travel_info() {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $data['travel_details'] = $this->hrm_model->get_element_by_id('travel_info', 'id', $id);
        $data['attachments'] = $this->hrm_model->get_attachmets_by_UserId('attachments', 'rel_id', $id, 'travel_info_docs');
        //pre($data);die;
        $this->load->view('travel_info/add', $data);
    }
    # Function to load Paid Travel Info
    public function paid_travel_info() {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $data['travel_details'] = $this->hrm_model->get_element_by_id('travel_info', 'id', $id);
        $this->load->view('travel_info/payment', $data);
    }
    //save_job_application
    public function save_travel_info() {

        if ($this->input->post()) {
            # required field server side validation
            $required_fields = array('no_of_days');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                # If form is valid
                $travelLength = count(@$_POST['travel_from']);
                if ($travelLength > 0) {
                    $travelArr = array();
                    $j = 0;
                    while ($j < $travelLength) {
                        $jsontravelObject = (array('travel_from' => $_POST['travel_from'][$j], 'travel_to' => @$_POST['travel_to'][$j], 'start_date' => @$_POST['start_date'][$j], 'end_date' => @$_POST['end_date'][$j], 'travel_mode' => @$_POST['travel_mode'][$j], 'travel_cost' => @$_POST['travel_cost'][$j]));
                        $travelArr[$j] = $jsontravelObject;
                        $j++;
                    }
                    $travel_array = json_encode($travelArr);
                } else {
                    $travel_array = '';
                }
                $unsetarray = array("travel_from", "travel_to", "start_date", "end_date", "travel_cost", "name", "travel_mode");
                $data = array_diff_key($this->input->post(), array_flip($unsetarray));
                $data['u_id'] = $_POST['u_id'];
                $data['travel_details'] = $travel_array;
                $id = $data['id'];
                if ($id && $id != '') {
                   
                    $success = $this->hrm_model->update_data('travel_info', $data, 'id', $id);
                    
                    if ($success) {
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
                                $config['upload_path'] = 'assets/modules/hrm/uploads/';
                                $config['upload_url'] = base_url() . 'assets/modules/hrm/uploads/';
                                $config['allowed_types'] = "gif|jpg|jpeg|png|doc|pdf|docx|ods|csv|xlsx|xls";
                                $config['max_size'] = '2000000';
                                $config['file_name'] = $newname;
                                $this->load->library('upload', $config);
                                move_uploaded_file($tmpname, "assets/modules/hrm/uploads/" . $newname);
                                $attachment_array[$i]['rel_id'] = $id;
                                $attachment_array[$i]['rel_type'] = 'travel_info_docs';
                                $attachment_array[$i]['file_name'] = $newname;
                                $attachment_array[$i]['file_type'] = $type;
                            }
                            if (!empty($attachment_array)) {
                                /* Insert file information into the database */
                                $attachmentId = $this->hrm_model->insert_attachment_data('attachments', $attachment_array, 'hrm/add_travel_info/' . $id);
                            }
                        }
                        $data['message'] = "Travel Info updated successfully";
                        logActivity('Travel Info Updated', 'travel_info_updated', $id);
                    }
                     if ($success)
                     {

                                $where = array('c_id' =>$this->companyGroupId,  'tatdsand_mail_permissions'=>1);
                                $user = $this->hrm_model->get_filter_details('user', $where);
                                
                                $userIdemails=array();
                                foreach ($user as  $uservalue)
                                {
                                $userIdemails[]= $uservalue['email'];
                                }
                           $where2 = array('id' =>$_SESSION['loggedInUser']->id, 'c_id' =>$this->companyGroupId);
                          $user2 = $this->hrm_model->get_filter_details('user', $where2);
                          $useremail[]=$user2[0]['email'];
                          $allemails=array_merge($userIdemails,$useremail);
                          $this->send_emailFor_TADA($allemails,$success);
                                
                                
                     }
                    $this->session->set_flashdata('message', 'Job Application Updated successfully');
                } else {
                 
                    $insertedid = $this->hrm_model->insert('travel_info', $data);
                     if ($insertedid)   
                     { 
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
                            $config['upload_path'] = 'assets/modules/hrm/uploads/';
                            $config['upload_url'] = base_url() . 'assets/modules/hrm/uploads/';
                            $config['allowed_types'] = "gif|jpg|jpeg|png|doc|pdf|docx|ods|csv|xlsx|xls";
                            $config['max_size'] = '2000000';
                            $config['file_name'] = $newname;
                            $this->load->library('upload', $config);
                            move_uploaded_file($tmpname, "assets/modules/hrm/uploads/" . $newname);
                            $attachment_array[$i]['rel_id'] = $insertedid;
                            $attachment_array[$i]['rel_type'] = 'travel_info_docs';
                            $attachment_array[$i]['file_name'] = $newname;
                            $attachment_array[$i]['file_type'] = $type;
                        } 
                        if (!empty($attachment_array)) {
                            /* Insert file information into the database */
                            $attachmentId = $this->hrm_model->insert_attachment_data('attachments', $attachment_array, 'hrm/add_travel_info/' . $insertedid);
                        }
                    }
                    $where = array('c_id' =>$this->companyGroupId,  'tatdsand_mail_permissions'=>1);
                          $user = $this->hrm_model->get_filter_details('user', $where);
                          $userIdemails=array();
                          foreach ($user as  $uservalue){ $userIdemails[]= $uservalue['email']; }
                           $where2 = array('id' =>$_SESSION['loggedInUser']->id, 'c_id' =>$this->companyGroupId);
                          $user2 = $this->hrm_model->get_filter_details('user', $where2);
                          $useremail[]=$user2[0]['email'];
                          $allemails=array_merge($userIdemails,$useremail);
                          $this->send_emailFor_TADA($allemails,$insertedid);
                }
                    $this->session->set_flashdata('message', 'Travel Info Added successfully');
                }
            }
        }
        redirect(base_url() . 'hrm/travel_info', 'refresh');
    }
    //job application
    public function view_travel_info() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        $data['travel_info'] = $this->hrm_model->get_element_by_id('travel_info', 'id', $id);
        $data['attachments'] = $this->hrm_model->get_attachmets_by_UserId('attachments', 'rel_id', $id, 'travel_info_docs');
        # pre($data);die;
        $this->load->view('travel_info/view', $data);
    }
    /*approve Job Position*/
    public function approveStatusChange() {
        if ($_POST['id'] && $_POST['id'] != '') {
            $id=$_POST['id'];
            $data = array('approve_status' => $_POST['approve_status'], 'approve_by' => $_POST['approve_by'], 'disapprove_reason' => '');
            $result = $this->hrm_model->approveStatusChange($_POST['id'], $data, 'travel_info');
            
            if ($result) {    
                            $where = array( 'c_id' =>$this->companyGroupId,'tatdsand_mail_permissions_account'=>1);
                            $user = $this->hrm_model->get_filter_details('user', $where);

                            $userIdemails=array();
                            foreach ($user as  $uservalue)
                            {
                            $userIdemails[]= $uservalue['email'];
                            }   
                         $where2 = array('id' =>$_SESSION['loggedInUser']->id, 'c_id' =>$this->companyGroupId);
                         $user2 = $this->hrm_model->get_filter_details('user', $where2);
                         $useremail[]=$user2[0]['email'];
                        $allemails=array_merge($userIdemails,$useremail);
                        $this->send_emailFor_TADA($allemails,$id);
                                        
                if ($_POST['approve_status'] == 1) {
                    $monthYearsg = 'TA/DA Approved';
                } else {
                    $monthYearsg = 'TA/DA Disapproved';
                }
                logActivity($monthYearsg, 'travel_info', $_POST['id']);
                $this->session->set_flashdata('message', $monthYearsg);
                $result = array('msg' => $monthYearsg, 'status' => 'success', 'code' => 'C296', 'url' => base_url() . 'hrm/recruitment');
                echo json_encode($result);
                
            } else {
                echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C301'));
            }
        }
    }
    public function payment_travel_info() {
        if (isset($_POST['check_payment_complete']) && $_POST['check_payment_complete'] == 'complete_payment') {
            $ifBalance = 0; //Payment Complete
            date_default_timezone_set('Asia/Kolkata');
            $complete_Date = date('Y-m-d H:i');
            $data['paid_status'] = 1;
        } else {
            $ifBalance = 1; //Payment Not Complete
            $data['paid_status'] = 0;
        }
        $data['paidstatus_by'] = $_POST['paidstatus_by'];
        $id = $_POST['id'];
        $travel_info = $this->hrm_model->get_element_by_id('travel_info', 'id', $id);
        #  pre($travel_info);die;
        $previous_payment = json_decode($travel_info->payment_details);
        $current_payment[] = $this->input->post();
        unset($current_payment[0]['id']);
        unset($current_payment[0]['paidstatus_by']);
        $current_payment[0]['balance'] = $ifBalance;
        # $total_payment                 = array_merge($previous_payment, $current_payment);
        $total_payment = $current_payment;
        #  pre($current_payment); pre($xprevious_payment); pre($xtotal_payment);die;
        if (!empty($total_payment)) {
            $data['payment_details'] = json_encode($total_payment);
            $updated = $this->hrm_model->updateData('travel_info', $data, 'id', $id);
            if ($updated) {
                $this->session->set_flashdata('message', 'Payment Info Added successfully');
            } else {
                $this->session->set_flashdata('message', 'Payment Info Not Added');
            }
        } else {
            $this->session->set_flashdata('message', 'Payment Info Not Added');
        }
        redirect(base_url() . 'hrm/travel_info', 'refresh');
    }
    /* ..............TA/DA Management END---------------------*/
    /* ..............Salary Component Management---------------------*/
    //travel info
    public function salary_component() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Salary Component List', base_url() . 'hrm/salary_component');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Salary Component List';
        $where = array('created_by_cid' => $this->companyGroupId,);
        $this->data['salary_components_list'] = $this->hrm_model->get_data('salary_components', $where);
        $this->_render_template('salary_component/index', $this->data);
    }
    # Function to load add/edit job_application
    public function add_salary_component() {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }
        $data['salary_component_detail'] = $this->hrm_model->get_element_by_id('salary_components', 'id', $id);
        $this->load->view('salary_component/add', $data);
    }
    public function saveSalaryComponent() {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $required_fields = array('salary_component', 'salary_component_abbr');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $data['salary_component_abbr'] = strtoupper($this->input->post('salary_component_abbr'));
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                if (empty($id)) {
                    $success = $this->hrm_model->insert_tbl_data('salary_components', $data);
                    logActivity('Salary Components Inserted Successfully', 'salary_components', $success);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect("hrm/salary_component");
                    echo "Successfully Added";
                } else {
                    $success = $this->hrm_model->updateData('salary_components', $data, 'id', $id);
                    logActivity('Salary Components Updated Successfully', 'salary_components', $id);
                    $this->session->set_flashdata('message', 'Successfully Updated');
                    redirect("hrm/salary_component");
                    echo "Successfully Updated";
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function view_salary_component() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        $data['salary_component_detail'] = $this->hrm_model->get_element_by_id('salary_components', 'id', $id);
        $this->load->view('salary_component/view', $data);
    }
    /* ..............END Salary Component Management---------------------*/
    public function dailyreport() {
        $this->data['c_id'] = $c_id = $this->companyGroupId;
        $this->data['date'] = $this->session->userdata('find_attendance');
        $this->session->unset_userdata('find_attendance');
        $this->breadcrumb->add('HRM', base_url() . 'hrm/users');
        $this->breadcrumb->add('Daily Report', base_url() . 'hrm/dailyreport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Daily Report';
        $this->data['users'] = $this->hrm_model->get_user_data($c_id);
        $this->_render_template('report/daily_report', $this->data);
    }
    public function dailyreport_adjustment() {
        $date = $this->input->post('current_date');
        $this->session->set_userdata('find_attendance', $date);
        $this->data['users'] = $this->hrm_model->get_user_data($this->companyGroupId);
        redirect('hrm/dailyreport', 'refresh');
    }
    public function statusreport() {
        $this->data['date'] = $this->session->userdata('start_end_date');
        $this->breadcrumb->add('HRM', base_url() . 'hrm/status');
        $this->breadcrumb->add('Calendar View', base_url() . 'hrm/statusreport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Calendar View';
        $this->data['c_id'] = $this->companyGroupId;
        $this->data['users'] = $this->hrm_model->get_user_data($this->companyGroupId);
        $this->_render_template('report/status_report', $this->data);
    }
    public function statusreport_adjustment() {
        $start_end_date = array('start_date' => date("Y-m-d", strtotime($this->input->post('start'))), 'end_date' => date("Y-m-d", strtotime($this->input->post('end'))));
        $start_date = date("Y-m-d", strtotime($this->input->post('start')));
        $end_date = date("Y-m-d", strtotime($this->input->post('end')));
        $where = 'AND created_by_cid = ' . $this->companyGroupId;
        //    $holidays = $this->hrm_model->GetAllHoliInfoEmp($_SESSION['loggedInUser']->c_id, $start_date, $end_date);
        $holidays = $this->hrm_model->GetAllHoliInfoEmp($this->companyGroupId, $start_date, $end_date);
        if (isset($holiday->from_date) && isset($holiday->to_date)) {
            $start_end_holiday = array('startDate_holiday' => $holiday->from_date, 'endDate_holiday' => $holiday->to_date);
        }
        $this->session->set_userdata('holiday', $holidays);
        $this->session->set_userdata('start_end_date', $start_end_date);
        redirect('hrm/statusreport', 'refresh');
    }
    public function summaryreport() {
        $this->data['date'] = $this->session->userdata('start_end_date_summary');
        $this->session->unset_userdata('find_attendance');
        $this->data['c_id'] = $this->companyGroupId;
        $this->breadcrumb->add('HRM', base_url() . 'hrm/users');
        $this->breadcrumb->add('Summary Report', base_url() . 'hrm/summaryreport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Summary Report';
        $this->data['users'] = $this->hrm_model->get_user_data($this->companyGroupId);
        $this->_render_template('report/summary_report', $this->data);
    }
    public function summaryreport_adjustment() {
        $start_end_date_summary = array('start_date' => date("Y-m-d", strtotime($this->input->post('start'))), 'end_date' => date("Y-m-d", strtotime($this->input->post('end'))));
        $start_date = date("Y-m-d", strtotime($this->input->post('start')));
        $end_date = date("Y-m-d", strtotime($this->input->post('end')));
        $where = 'AND created_by_cid = ' . $this->companyGroupId;
        $holidays = $this->hrm_model->GetAllHoliInfoEmp($this->companyGroupId, $start_date, $end_date);
        $week_off_emp = $this->hrm_model->GetWeekOffInfoEmp($this->companyGroupId);
        #  pre($week_off_emp);die;
        #  $get_leaveorabsent = $this->hrm_model->GetleaveStatusEmpGroup($_SESSION['loggedInUser']->c_id, $start_date, $end_date);
        $get_leaveorabsent = $this->hrm_model->GetleaveStatusEmpGroup($this->companyGroupId, $start_date, $end_date);
        $get_attendance_p_a = $this->hrm_model->GetAttendanceStatusEmpGroup($start_date, $end_date);
        if (isset($holiday->from_date) && isset($holiday->to_date)) {
            $start_end_holiday = array('startDate_holiday' => $holiday->from_date, 'endDate_holiday' => $holiday->to_date);
        }
        $this->session->set_userdata('paid_off_unpaid_days', $get_leaveorabsent);
        $this->session->set_userdata('worked_days', $get_attendance_p_a);
        $this->session->set_userdata('week_off_emp', $week_off_emp);
        $this->session->set_userdata('holiday', $holidays);
        $this->session->set_userdata('start_end_date_summary', $start_end_date_summary);
        redirect('hrm/summaryreport', 'refresh');
    }
    public function userreport() {
        $this->data['date'] = $this->session->userdata('start_end_date');
        //  print_r($this->data['users']); exit;
        $this->breadcrumb->add('HRM', base_url() . 'hrm/index');
        $this->breadcrumb->add('User Report', base_url() . 'hrm/userreport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'User Report';
        $this->data['users'] = $this->hrm_model->get_user_data();
        //  echo $this->db->last_query();
        $this->_render_template('report/user_report', $this->data);
    }
    public function userreport_adjustment() {
        $start_end_date = array('start_date' => date("Y-m-d", strtotime($this->input->post('start'))), 'end_date' => date("Y-m-d", strtotime($this->input->post('end'))));
        $this->session->set_userdata('start_end_date', $start_end_date);
        redirect('hrm/userreport', 'refresh');
    }
    public function punchReport() {
        $this->breadcrumb->add('HRM', base_url() . 'hrm/index');
        $this->breadcrumb->add('Punch Report', base_url() . 'hrm/punchReport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Punch Report';
        $this->data['users'] = $this->hrm_model->get_user_data($this->companyGroupId);
        //  echo $this->db->last_query();
        $this->_render_template('report/punch_report', $this->data);
    }
    public function punchreport_adjustment() {
        $start_date = date("Y-m-d", strtotime($this->input->post('start')));
        $end_date = date("Y-m-d", strtotime($this->input->post('end')));
        $emp_code = $this->input->post('emp_code');
        $biometric_id = getNameById('user_detail', $emp_code, 'u_id');
        #  pre($start_date);die;
        if ($start_date == "1970-01-01") {
            $start_date = date('Y-m-d', strtotime('today - 30 days'));
            $end_date = date('Y-m-d');
        }
        if (!empty($biometric_id)) {
            $data = $this->hrm_model->GetEmpCodeData_date($this->companyGroupId, $start_date, $end_date, @$biometric_id->biometric_id);
            $this->session->set_userdata('dateRange_empCode', $data);
        }
        redirect('hrm/punchReport', 'refresh');
    }
    /* .............. Attendance Report End's---------------------*/
    /* .............. Letter Managment Start's  ---------------------*/
    public function editlettertemplate() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/letters');
        $this->breadcrumb->add('Create Letter', base_url() . 'hrm/letters');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Letter';
        $id = $this->session->userdata('letter_temp_id');
        if (!empty($id)) {
            $this->data['template'] = $this->hrm_model->get_data_byId('letter_template', 'id', $id);
            $this->_render_template('letter/index', $this->data);
        }
    }
    public function savelettertemplate() {
        $template_id = $this->input->post('update_letter_template_id');
        $data['title'] = $this->input->post('title');
        $data['content'] = $this->input->post('content');
        $data['created_by'] = $_SESSION['loggedInUser']->u_id;
        $data['created_by_cid'] = $this->companyGroupId;
        if (empty($template_id)) {
            $this->hrm_model->insert_tbl_data('letter_template', $data);
            $this->session->set_flashdata('message', 'Document Created Successfully');
        } else {
            $this->hrm_model->update_data('letter_template', $data, 'id', $template_id);
            $this->session->set_flashdata('message', 'Document Updated Successfully');
        }
        redirect('hrm/viewlettertemplate', 'refresh');
    }
    public function viewlettertemplate() {
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/letters');
        $this->breadcrumb->add('Create Letter', base_url() . 'hrm/letters');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Letter';
        $where = array('created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "title like '%" . $_GET['search'] . "%'";
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('letter_template', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/viewlettertemplate/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['all_templates'] = $this->hrm_model->get_usr_data('letter_template', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        #$this->data['all_templates']       = $this->hrm_model->get_data('letter_template', $where);
        # pre($this->data['all_templates']);die;
        $this->_render_template('letter/editlettertemplate', $this->data);
    }
    public function view_lettertemplate() {
        $id = $this->uri->segment('3');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/letters');
        $this->breadcrumb->add('Create Letter', base_url() . 'hrm/letters');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Letter';
        if (!empty($id)) {
            $this->data['template'] = $this->hrm_model->get_data_byId('letter_template', 'id', $id);
            $this->_render_template('letter/viewlettertemplate', $this->data);
        }
    }
    public function lettertemplate() {
        $id = $this->uri->segment('3');
        if (!empty($id)) {
            $this->session->set_userdata('letter_temp_id', $id);
            redirect('hrm/editlettertemplate', 'refresh');
        }
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/letters');
        $this->breadcrumb->add('Create Letter', base_url() . 'hrm/letters');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Letter';
        $where = array('created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId);
        $this->session->unset_userdata('letter_temp_id');
        $this->_render_template('letter/index', $this->data);
    }
    public function sharetemplate() {
        $this->load->library('pagination');
        $this->breadcrumb->add('HRM', base_url() . 'hrm/sharetemplate');
        $this->breadcrumb->add('Share Template', base_url() . 'hrm/sharetemplate');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Share Template';
        /*    $this->data['users']         = $this->hrm_model->get_data('user', array(
        
            'user.c_id' =>$this->companyGroupId ,
        
            'user.role' => 2,
        
            'user.status' => 1                                                      ));
        
        */
        $where = array('user.c_id' => $this->companyGroupId, 'user.role' => 2, 'user.status' => 1);
        $where2 = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $EmpName = getNameBySearch('user_detail', $_GET['search'], 'name');
            $where2 = array();
            foreach ($EmpName as $name) { //pre($name['id']);
                $where2[] = "user.id ='" . $name['u_id'] . "'";
            }
            if (sizeof($where2) != '') {
                $where2 = '(' . implode("||", $where2) . ')';
            } else {
                $where2 = "id = '" . $_GET['search'] . "'";
            }
        }
        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }
        //$this->data['catvalue']        = $this->hrm_model->get_data('assets_category', $where);
        #pre($this->data['application']);
        $rows = $this->hrm_model->num_rows('user', $where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/sharetemplate/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }
        $this->data['users'] = $this->hrm_model->get_usr_data('user', $where, $config["per_page"], $page, $where2, $order, $export_data);
        if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';
        $this->_render_template('letter/sharetemplate', $this->data);
    }
    public function peremployeetemplate() {
        $u_id = $this->uri->segment('3');
        if (!empty($u_id)) {
            $this->session->set_userdata('perEmp_temp_id', $u_id);
            redirect('hrm/viewletter', 'refresh');
        }
    }
    public function viewletter() {
        $this->data['u_id'] = $this->session->userdata('perEmp_temp_id');
        if (!empty($this->data['u_id'])) {
            $this->breadcrumb->add('HRM', base_url() . 'hrm/viewletter');
            $this->breadcrumb->add('View Letter', base_url() . 'hrm/viewletter');
            $this->settings['breadcrumbs'] = $this->breadcrumb->output();
            $this->settings['pageTitle'] = 'View Letter';
            $where = array('created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId);
            $this->data['all_templates'] = $this->hrm_model->get_data('letter_template', $where);
            $this->_render_template('letter/peremployeetemplate', $this->data);
        }
    }
    public function getEmailpdfId() {
        $emailData = array('letter_id' => $this->uri->segment('3'), 'u_id' => $this->uri->segment('4'));
        $this->session->set_userdata('emailpdfId', $emailData);
        redirect('hrm/sendEmailToUser', 'refresh');
    }
    public function getpdfId() {
        $emailData = array('letter_id' => $this->uri->segment('3'), 'u_id' => $this->uri->segment('4'));
        $this->session->set_userdata('downloadPdf', $emailData);
        redirect('hrm/downloadPdf', 'refresh');
    }
    public function deleteLetterTemplate() {
        $letter_id = $this->uri->segment('3');
        $result = $this->hrm_model->delete_data('letter_template', 'id', $letter_id);
        if ($result) {
            $this->session->set_flashdata('message', 'Document Deleted Successfully');
            redirect('hrm/viewlettertemplate', 'refresh');
        }
    }
    public function downloadPdf() {
        $data = $this->session->userdata('downloadPdf');
        $letter_id = $data['letter_id'];
        $u_id = $data['u_id'];
        /*
        
                $letter_id =    $this->input->post('letter_id');
        
                          $u_id =   $this->input->post('u_id');*/
        $letter_data = $this->hrm_model->get_data('letter_template', array('letter_template.id' => $letter_id, 'letter_template.created_by_cid' => $this->companyGroupId));
        $user = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.id' => $u_id));
        $subjectContent = $letter_data[0]['title'];
        $monthYearailContent = $letter_data[0]['content'];
        if (!empty($user[0]['address1'])) {
            $permanentAddress = json_decode($user[0]['address1']);
        }
        $dateNow = date('d-m-Y');
        $JoiningDate  = date('d- m- Y',strtotime($user[0]['date_joining']));
        //  pre($permanentAddress);die;
         $vars = array('[name]' => $user[0]['name'], '[mobile]' => $user[0]['contact_no'], '[address]' => $permanentAddress->address, '[designation]' => $user[0]['designation'], '[joining_date]' => $JoiningDate, '[dob]' => $user[0]['age'],'[todays_date]'=>$dateNow);
        $to = $user[0]['email'];
        $readyMailContent = strtr($monthYearailContent, $vars);
        ini_set('memory_limit', '20M');
        $this->load->library('Pdf');
        $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $obj_pdf->SetTitle("REQUEST FOR QUOTATION");
        $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $obj_pdf->SetDefaultMonospacedFont('helvetica');
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
        $obj_pdf->setPrintHeader(false);
        $obj_pdf->setPrintFooter(false);
        $obj_pdf->SetMargins('40', '40', '40');
        $obj_pdf->SetFooterMargin('80');
        $obj_pdf->SetAutoPageBreak(TRUE, 10);
        $obj_pdf->SetFont('helvetica', '', 9);
        $obj_pdf->AddPage();
        $pdfFilePath = FCPATH . "assets/modules/hrm/letterPdf/employeeLetter.pdf";
        $obj_pdf->writeHTML($readyMailContent);
        ob_end_clean();
        $obj_pdf->Output($pdfFilePath, 'F');
        header('Content-Type: application/pdf');
        //  header('Content-disposition: attachment; filename="'.$pdfFilePath.'"');
        /*      header('Location: http://www.example.com/');*/
        readfile($pdfFilePath);
    }
    public function sendEmailToUser() {
        $data = $this->session->userdata('emailpdfId');
        $letter_id = $data['letter_id'];
        $u_id = $data['u_id'];
        $letter_data = $this->hrm_model->get_data('letter_template', array('letter_template.id' => $letter_id, 'letter_template.created_by_cid' => $this->companyGroupId));
        $user = $this->hrm_model->get_data('user', array('user.c_id' => $this->companyGroupId, 'user.id' => $u_id));
        $subjectContent = $letter_data[0]['title'];
        $monthYearailContent = $letter_data[0]['content'];
        if (!empty($user[0]['address1'])) {
            $permanentAddress = json_decode($user[0]['address1']);
        }
        $vars = array('[name]' => $user[0]['name'], '[mobile]' => $user[0]['contact_no'], '[address]' => $permanentAddress->address, '[designation]' => $user[0]['designation'], '[joining_date]' => $user[0]['date_joining'], '[dob]' => $user[0]['age']);
        $to = $user[0]['email'];
        $readyMailContent = strtr($monthYearailContent, $vars);
        ini_set('memory_limit', '20M');
        $this->load->library('Pdf');
        $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $obj_pdf->SetTitle("REQUEST FOR QUOTATION");
        $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $obj_pdf->SetDefaultMonospacedFont('helvetica');
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
        $obj_pdf->setPrintHeader(false);
        $obj_pdf->setPrintFooter(false);
        $obj_pdf->SetAutoPageBreak(TRUE, 10);
        $obj_pdf->SetFont('helvetica', '', 9);
        $obj_pdf->AddPage();
        $obj_pdf->writeHTML($readyMailContent);
        $pdfFilePath = FCPATH . "assets/modules/hrm/letterPdf/employeeLetter.pdf";
        $obj_pdf->Output($pdfFilePath, 'F');
        $result = $this->email->from('dev@lastingerp.com')->to('dharamveersingh@lastingerp.com')->subject($subjectContent)->attach($pdfFilePath)->send();
        $this->email->clear($pdfFilePath);
        if ($result) {
            unlink($pdfFilePath);
            $this->session->set_flashdata('message', 'Document Sent Successfully');
            redirect('hrm/sharetemplate', 'refresh');
        }
    }
    /* .............. Letter Managment End's---------------------*/
    /*-----------------------------------------send email----------------------------------------------- */
    public function get_email_data_admin_hr() {
        $data = $this->hrm_model->get_email_admin_data($this->companyGroupId);
        $admin_email=[];
        foreach ($data as $email) {
            if (!empty($email->email)) {
                $admin_email[] = $email->email;
            }
        }
       // pre($admin_email);
        $data = $this->hrm_model->get_email_hr_data($this->companyGroupId);
        $hr_email=[];
        foreach ($data as $email) {
            if (!empty($email->hr_email)) {
                $hr_email[] = $email->hr_email;
            }
        }
        #pre($admin_email);
        $all_email_id = array_merge($admin_email, $hr_email);
       ///  pre($all_email_id); die;
        return $all_email_id;
    }
    public function send_email_job_application($all_email, $send_email_data) {
        $designation = $send_email_data['designation'];
        $no_of_position = $send_email_data['no_of_position'];
        $this->load->library('phpmailer_lib');
        $monthYearail = $this->phpmailer_lib->load();
        //Server settings
        $monthYearail->SMTPDebug = 0;
        $monthYearail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)); // Enable verbose debug output
        $monthYearail->isSMTP(); // Send using SMTP
        $monthYearail->Host = 'email-smtp.ap-south-1.amazonaws.com'; // Set the SMTP server to send through
        $monthYearail->SMTPAuth = true; // Enable SMTP authentication
        $monthYearail->Username = 'AKIAZB4WVENV747XUBKK'; // SMTP username
        $monthYearail->Password = 'BJV3EOgvWvrXviFFlzknoxBydMdXxWYSg9nMoyYxntzc'; // SMTP password
        $monthYearail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $monthYearail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        //Recipients
        $monthYearail->setFrom('dev@lastingerp.com', 'LastingERP');
        for ($i = 0;$i < count($all_email);$i++) {
            $monthYearail->addAddress($all_email[$i], ''); // Add a recipient
            
        }
        // Content
        $monthYearail->isHTML(true);
        // Email body content
        #$monthYearailContent = $monthYearessageContent;
        $monthYearail->Body = 'Job Position For : "' . $designation . '"  <br>No Of Positions :  "' . $no_of_position . '" <br> Link : <a href="https://busybanda.com/hrm/recruitment">Go To Website</a> ';
        $monthYearail->Subject = 'Job Position For "' . $designation . '"';
        $success3=$monthYearail->send();
        if ($success3) {
            #
            
        } else {
           // echo "notsend";
        }
        /*    }     */
        redirect(base_url() . 'hrm/recruitment/job_position', 'refresh');
    }
    public function send_email_leave_application($all_email, $send_email_data,$subject='') {
         
          if (!empty($subject)) {
        $empid = $send_email_data[1];
        $start_date = $send_email_data[2];
        $end_date = $send_email_data[3];
        $leave_duration = $send_email_data[4];
        $reason = $send_email_data[5];
        $applied_date = $send_email_data[6];
        $owner = getNameById('user_detail',$empid,'u_id');
          }else{
        $emp_id = $send_email_data[0];
        $start_date = $send_email_data[1];
        $end_date = $send_email_data[2];
        $leave_duration = $send_email_data[3];
        $reason = $send_email_data[4];
        $applied_date = $send_email_data[5];
        $owner = getNameById('user_detail',$emp_id,'u_id');
      }  
          // pre($owner); die;
        $this->load->library('phpmailer_lib');
        $monthYearail = $this->phpmailer_lib->load();
        $monthYearail->SMTPDebug = 0;  
        $monthYearail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $monthYearail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
        $monthYearail->isSMTP();    
        $monthYearail->Host       = 'email-smtp.ap-south-1.amazonaws.com';
        $monthYearail->SMTPAuth   = true;
        $monthYearail->Username   = 'AKIAZB4WVENVZ773ONVF';
        $monthYearail->Password   = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG';
        $monthYearail->SMTPSecure = 'tls';
        $monthYearail->Port       = 587;                     
        $monthYearail->setFrom('dev@lastingerp.com','lerp');   
        foreach($all_email as $email){
             $monthYearail->addAddress($email, '');
        } 
        // Content
         $monthYearail->isHTML(true); 
     // Email body content
        #$monthYearailContent = $monthYearessageContent; $owner->name." &nbsp;( &nbsp;Emp Code :".$owner->u_id.")";
       
        if (!empty($subject)) { 
           $monthYearail->Body = 'Leave start date : "' . $start_date . '"  <br> Leave End Date :  "' . $end_date . '" <br> Leave Duration :   "' . $leave_duration . '"  <br> Reason of leave :   "' . $reason . '" <br> Applied Date :   "' . $applied_date . '" <br><h3>Your Request: "'.$subject.'"</h3>'; 
         }else{
           $monthYearail->Body = 'Leave start date : "' . $start_date . '"  <br> Leave End Date :  "' . $end_date . '" <br> Leave Duration :   "' . $leave_duration . '"  <br> Reason of leave :   "' . $reason . '" <br> Applied Date :   "' . $applied_date . '"  ';
         }
        $monthYearail->Subject = 'Leave Application of "' .$owner->name.' ( Emp Code : "'.$owner->u_id.'")"';
        $success=$monthYearail->send();
        if ($success) {
            //echo'ok';
            
        } else {
           echo 'Mailer error: ' . $monthYearail->ErrorInfo;  
        }
        /*    }     */
        redirect('hrm/leave_application', 'refresh');
    }
    /* .............. Salary Structure Start's---------------------*/
    public function salary_structure() {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/dashboard');
        $this->breadcrumb->add('Salary Component List', base_url() . 'hrm/salary_component');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Salary Component List';
        $where = array('created_by_cid' => $this->companyGroupId,);
        $this->data['salary_components_list'] = $this->hrm_model->get_data('salary_components', $where);
        $this->_render_template('salary_component/index', $this->data);
    }
    /* .............. Salary Structure Ends---------------------*/
    public function ViewLeaveApp() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        $data['leave_app_details'] = $this->hrm_model->get_data_byId_wo('emp_leave', 'id', $this->input->post('id'));
        $this->load->view('leave_application/view', $data);
    }
  public function viewWorkerLeavApp() {
        if ($this->input->post()) {
            permissions_redirect('is_view');
        }
        $id = $_POST['id'];
        $data['leave_app_details'] = $this->hrm_model->get_data_byId_wo('work_leave', 'id', $this->input->post('id'));
        $this->load->view('worker_leave_application/view', $data);
    }

    public function xsalarySlab() {
        $this->data['id'] = @$_POST['id'];
        $id = $this->data['id'];
        $this->data['slab_start_date'] = @$_POST['slab_start_date'];
        $this->data['slab_end_date'] = @$_POST['slab_end_date'];
        $this->data['salary_from'] = @$_POST['salary_from'];
        $this->data['salary_to'] = @$_POST['salary_to'];
        $this->data['created_by'] = $_SESSION['loggedInUser']->u_id;;
        $this->data['created_by_cid'] = $this->companyGroupId;
        $jsonSalarySlabArrayObject = (array('basic' => @$_POST['basic'], 'hra' => @$_POST['hra'], 'ca' => @$_POST['ca'], 'sa' => @$_POST['sa'], 'da' => @$_POST['da'], 'medical' => @$_POST['medical'], 'incentive' => @$_POST['incentive'], 'tds' => @$_POST['tds'], 'esic' => @$_POST['esic']));
        $salarySlab = json_encode($jsonSalarySlabArrayObject);
        $this->data['slab_structure'] = $salarySlab;
        if ($id && $id != '') {
            $success = $this->hrm_model->update_data('salary_slab', $data, 'id', $id);
        } else {
            $this->hrm_model->insert_tbl_data('salary_slab', $data);
        }
    }
    public function calculate_salary_slab() {
        // $global_start_end_date = global_variable_hrm();
        // $start_date = $global_start_end_date['start_date'];
        // $end_date = $global_start_end_date['end_date'];
        $emp_id = $_POST['emp_id'];
        $total_sal = $_POST['total_sal'];
        $salary_slab = $_POST['salary_slab'];
        $salary_slabs = getNameById('salary_slab', $salary_slab, 'id');
        $this->data['salary_slabs']=$salary_slabs;
        $this->data['total_sal']=$total_sal;  
        $this->data['emp_id']=$emp_id;  
        echo json_encode(['html' => $this->load->view('users_salary/slabview', $this->data,true)]);
       // $data = $this->hrm_model->calculate_salary_frm_slab($this->companyGroupId, $total_sal, $start_date, $end_date);

        // print_r(json_decode($data->slab_structure));
       // print_r(@$data->slab_structure);
    }
    public function process_payroll() {
        $this->data['date'] = $this->session->userdata('start_end_date_summary');
        $this->session->unset_userdata('find_attendance');
        $this->data['c_id'] = $this->companyGroupId;
        $this->breadcrumb->add('HRM', base_url() . 'hrm/users');
        $this->breadcrumb->add('Process Payroll', base_url() . 'hrm/summaryreport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Process Payroll';
        $this->data['users'] = $this->hrm_model->get_user_data($this->companyGroupId);
        #  pre($this->data['users']);die;
        if(!empty($this->input->post('month'))){
        $where2='';
        $day = '1';
        $monthYearonth = $this->input->post('month');
        $year = date('Y');
        $dt = $monthYearonth . '-' . $day; 
         
          $start_end_date_summary = array('start_date' => date("Y-m-01", strtotime($dt)), 'end_date' => date("Y-m-t", strtotime($dt))); 
        $start_date = date("Y-m-01", strtotime($dt));
        $end_date = date("Y-m-t", strtotime($dt));
        $work_days = date("t", strtotime($end_date)); 
        $where = 'AND created_by_cid = ' . $this->companyGroupId;
        $holidays = $this->hrm_model->GetAllHoliInfoEmp($this->companyGroupId, $start_date, $end_date);
        $week_off_emp = $this->hrm_model->GetWeekOffInfoEmp($this->companyGroupId); 
        $get_leaveorabsent = $this->hrm_model->GetleaveStatusEmpGroup($this->companyGroupId, $start_date, $end_date); 
      //  $get_attendance_p_a = $this->hrm_model->GetAttendanceStatusEmpGroup($start_date, $end_date); 
        if( isset($start_date) && isset($end_date) ){
           if ( $start_date != '' && $end_date != ''){
            $start = $start_date;
            $end =$end_date;
           $where2 .= "atten_date >= '{$start}' AND atten_date <= '{$end}' ";
          } 
        }
        $employeeData  = $this->hrm_model->get_worker_data('attendance',$where2);
        $empDataID=[];
            foreach ($employeeData as $empkey => $empDatavalue) {
            
             if ($empDatavalue['status']=='P') {
                    $empDataID[$empDatavalue['emp_id']][]=$empDatavalue;
            }
          } 
        if (isset($holiday->from_date) && isset($holiday->to_date)) {
            $start_end_holiday = array('startDate_holiday' => $holiday->from_date, 'endDate_holiday' => $holiday->to_date);
        } 
        $this->data['work_days'] = $work_days;
        $this->data['get_leaveorabsent'] = $get_leaveorabsent;
        $this->data['get_attendance_p_a'] = $empDataID;
        $this->data['week_off_emp'] = $week_off_emp;
        $this->data['holidays'] = $holidays;
        $this->data['start_end_date_summary'] = $start_end_date_summary;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->_render_template('payroll/index', $this->data); 
     }else{
        $this->_render_template('payroll/index', $this->data);
     }
    }
    // public function process_payroll_adjustment() {
    //     $day = '1';
    //     $monthYearonth = $this->input->post('month');
    //     $year = date('Y');
    //     $dt = $year . '-' . $monthYearonth . '-' . $day;
    //     #     pre($dt);die;
    //     #   echo 'First day : '. date("Y-m-01", strtotime($dt)).' - Last day : '. date("Y-m-t", strtotime($dt));
    //     $start_end_date_summary = array('start_date' => date("Y-m-01", strtotime($dt)), 'end_date' => date("Y-m-t", strtotime($dt)));
    //     $start_date = date("Y-m-01", strtotime($dt));
    //     $end_date = date("Y-m-t", strtotime($dt));
    //     $work_days = date("t", strtotime($end_date));
    //     #echo $start_date;
    //     #  echo $end_date;
    //      // echo $work_days;
    //      //  echo "start end waork";die;
    //     $where = 'AND created_by_cid = ' . $this->companyGroupId;
    //     $holidays = $this->hrm_model->GetAllHoliInfoEmp($this->companyGroupId, $start_date, $end_date);
    //     $week_off_emp = $this->hrm_model->GetWeekOffInfoEmp($this->companyGroupId);
   
    //     $get_leaveorabsent = $this->hrm_model->GetleaveStatusEmpGroup($this->companyGroupId, $start_date, $end_date);
    //    //  pre($get_leaveorabsent);die;
    //     $get_attendance_p_a = $this->hrm_model->GetAttendanceStatusEmpGroup($start_date, $end_date);
    //     if (isset($holiday->from_date) && isset($holiday->to_date)) {
    //         $start_end_holiday = array('startDate_holiday' => $holiday->from_date, 'endDate_holiday' => $holiday->to_date);
    //     }
    //     $this->session->set_userdata('work_days', $work_days);
    //     $this->session->set_userdata('paid_off_unpaid_days', $get_leaveorabsent);
    //     $this->session->set_userdata('worked_days', $get_attendance_p_a);
    //     $this->session->set_userdata('week_off_emp', $week_off_emp);
    //     $this->session->set_userdata('holiday', $holidays);
    //     $this->session->set_userdata('start_end_date_summary', $start_end_date_summary);
    //    redirect('hrm/process_payroll', 'refresh');
    // }
     public function process_payroll_adjustment() {
        $day = '1';
        $monthYearonth = $this->input->post('month');
        $year = date('Y');
        $dt = $year . '-' . $monthYearonth . '-' . $day;
             # pre($dt);die;
        #   echo 'First day : '. date("Y-m-01", strtotime($dt)).' - Last day : '. date("Y-m-t", strtotime($dt));
          $start_end_date_summary = array('start_date' => date("Y-m-01", strtotime($dt)), 'end_date' => date("Y-m-t", strtotime($dt))); 
        $start_date = date("Y-m-01", strtotime($dt));
        $end_date = date("Y-m-t", strtotime($dt));
        $work_days = date("t", strtotime($end_date));
        //echo $end_date; die;
        #  echo $end_date;
       //  echo $work_days; die;
        #  echo "start end waork";die;
        $where = 'AND created_by_cid = ' . $this->companyGroupId;
        $holidays = $this->hrm_model->GetAllHoliInfoEmp($this->companyGroupId, $start_date, $end_date);

        $week_off_emp = $this->hrm_model->GetWeekOffInfoEmp($this->companyGroupId);

        // pre($week_off_emp);die;
        #  $get_leaveorabsent = $this->hrm_model->GetleaveStatusEmpGroup($_SESSION['loggedInUser']->c_id, $start_date, $end_date);
        $get_leaveorabsent = $this->hrm_model->GetleaveStatusEmpGroup($this->companyGroupId, $start_date, $end_date);
     // pre($get_leaveorabsent); 
         // pre($get_leaveorabsent);die;
        $get_attendance_p_a = $this->hrm_model->GetAttendanceStatusEmpGroup($start_date, $end_date);
          
        if (isset($holiday->from_date) && isset($holiday->to_date)) {
            $start_end_holiday = array('startDate_holiday' => $holiday->from_date, 'endDate_holiday' => $holiday->to_date);
        }
        $this->session->set_userdata('work_days', $work_days);
        $this->session->set_userdata('paid_off_unpaid_days', $get_leaveorabsent);
        $this->session->set_userdata('worked_days', $get_attendance_p_a);
        $this->session->set_userdata('week_off_emp', $week_off_emp);
        $this->session->set_userdata('holiday', $holidays);
        $this->session->set_userdata('start_end_date_summary', $start_end_date_summary);
        redirect('hrm/process_payroll', 'refresh');
        // $this->data['work_days'] = $work_days;
        // $this->data['get_leaveorabsent'] = $get_leaveorabsent;
        // $this->data['get_attendance_p_a'] = $get_attendance_p_a;
        // $this->data['week_off_emp'] = $week_off_emp;
        // $this->data['holidays'] = $holidays;
        // $this->data['start_end_date_summary'] = $start_end_date_summary; 
    }
    public function show_payroll_process_per_emp() {    
          $this->data['allData']=$this->input->post();
        $this->load->view('payroll/view', $this->data);
    }
    public function get_emp_leave_balance() {
        $typeid = @$_POST['leave_id'];
        $employeeId = @$_POST['emp_id'];
        $companyGroupId = @$_POST['created_by_cid'];
        $leave_balance_data = $this->hrm_model->get_emp_leave_bal($employeeId, $typeid, $companyGroupId);
        $closing_bal_days = @$leave_balance_data->closing_bal;
        
    }
    public function get_emp_leave_per_emp() {
        $employeeId = @$_POST['emp_id'];
        $companyGroupId = @$_POST['created_by_cid'];
        $leave_balance_data = $this->hrm_model->get_emp_leave_bal($employeeId, $typeid, $companyGroupId);
        $closing_bal_days = @$leave_balance_data->closing_bal;
        print_r($closing_bal_days);
        die;
    }
    public function select_one_cl_only() {
        $typeid = @$_POST['leave_id'];
        $employeeId = @$_POST['emp_id'];
        $companyGroupId = @$_POST['created_by_cid'];
        $startdate = @$_POST['startdate'];
        $enddate = @$_POST['enddate'];
        $comm = "";
        $leave_ty = getNameById('leave_types', $typeid, 'id');
        if (@$leave_ty->name == 'CL') {
            if ($startdate != $enddate) {
                #  $comm = "dont select second day";
                #    return $comm;
                echo '1';
            } else {
                $time = strtotime($startdate);
                $monthYearonth = date("m", $time);
                $year = date("Y", $time);
                /*
                
                $monthYearonth = M($startdate);
                
                $year = Y($startdate);*/
                $leave_balance_data = $this->hrm_model->Get_type_of_leave_check($monthYearonth, $year, $companyGroupId, $typeid, $employeeId);
                if ($leave_balance_data != '0') {
                    #  echo "Already Got CL PLease Select LOP";
                    echo '2';
                }
            }
        }
    }
    public function attendance_weekoff_holiday_leave_check() {
        $c_id = $this->companyGroupId;
        $date_id = $_POST['date_id1'];
        $emp_id = $_POST['emp_id'];
        #  pre($date_id);die;
        if ($emp_id != "empty") {
            $data['leave_check'] = $leave_check = getEmpLeave_check('emp_leave', $emp_id, $date_id, $c_id);
        } else {
            $data['leave_check'] = 0;
        }
        $data['holiday_count'] = $holiday_count = getEmpHoliday_check($date_id, $c_id);
        $day_to = date('l', strtotime($date_id));
        #  pre($day_to);die;
        if ($day_to == 'Saturday') {
            $week_off = $this->hrm_model->get_data('employee_weekoff', array('employee_weekoff.created_by_cid' => $this->companyGroupId));
            #  pre($week_off);die;
            foreach ($week_off as $day) {
                if (($day['day'] == 'Second Saturday') || ($day['day'] == 'Fourth Saturday')) {
                    $year = date('Y', strtotime($date_id));
                    $monthYearonth = date('M', strtotime($date_id));
                    $datee = date('d', strtotime($date_id));
                    $second_saturday = date('Y-m-d', strtotime('second sat of ' . $monthYearonth . ' ' . $year));
                    $fourth_saturday = date('Y-m-d', strtotime('fourth sat of ' . $monthYearonth . ' ' . $year));
                    /* pre($date_id);
                    
                                   pre($second_saturday); 
                    
                                    pre($fourth_saturday);  */
                    if ($date_id == $second_saturday) {
                        $date_to = 'Second Saturday';
                        $data['week_off'] = $week_off = getEmpWeekoff_check($date_to, $c_id);
                    } elseif ($date_id == $fourth_saturday) {
                        $data['week_off'] = $week_off = getEmpWeekoff_check('Fourth Saturday', $c_id);
                    } else {
                        $day_to = date('l', strtotime($date_id));
                        $data['week_off'] = $week_off = getEmpWeekoff_check($day_to, $c_id);
                    }
                }
            }
        } else {
            $data['week_off'] = $week_off = getEmpWeekoff_check($day_to, $c_id);
        }
        echo json_encode($data);
    }
    public function check_no_of_leaves() {
        $c_id = $this->companyGroupId;
        $emp_id = $_POST['emp_id'];
        $leave_id = $_POST['leave_id'];
        $leave_balance_data = $this->hrm_model->get_no_of_leave_empwise($c_id, $emp_id, $leave_id);
        echo $leave_balance_data->opening_bal;
    }
    public function leave_update() {
        $c_id = $this->companyGroupId;
        $emp_id = $_POST['emp_id'];
        $leave_id = $_POST['leave_id'];
        $days = $_POST['days'];
        #$leave_bal = $this->hrm_model->count_no_of_leave_empwise($c_id,$emp_id,$leave_id );
        $leave_data = $this->hrm_model->count_no_of_leave_empwise($c_id, $emp_id, $leave_id);
        $leave_bal = count($leave_data);
        if ($leave_bal > 0) {
            $opening_bal_Db = $leave_data[0]->opening_bal;
            $closing_bal_Db = $leave_data[0]->closing_bal;
            $bal_to_be_added_in_closing = $days - $opening_bal_Db;
            $final_closing_bal = $closing_bal_Db + ($bal_to_be_added_in_closing);
            /*   pre($final_closing_bal);die;*/
            $leave_balance_data = $this->hrm_model->leave_update($c_id, $emp_id, $leave_id, $days, $final_closing_bal);
        } else { #  echo $leave_balance_data->opening_bal;
            $global_start_end_date = global_variable_hrm();
            $start_date = $global_start_end_date['start_date'];
            $end_date = $global_start_end_date['end_date'];
            $data = array('emp_id' => $emp_id, 'leave_id' => $leave_id, 'opening_bal' => $days, 'closing_bal' => $days, 'status' => 1, 'start_date' => $start_date, 'end_date' => $end_date, 'created_by' => $_SESSION['loggedInUser']->u_id, 'created_by_cid' => $this->companyGroupId);
            #  $this->db->insert('emp_leave_bal', $data);
            #   pre($data);die;
            $leave_balance_data = $this->hrm_model->leave_insert_emp_wise($data);
        }
    }
    public function add_leaves_to_newUser($emp_id) {
        $leave_types = $this->hrm_model->get_data('leave_types', array('leave_types.created_by_cid' => $this->companyGroupId, 'leave_types.automatically_assign_leave' => 1, 'leave_types.status' => 1));
        $start_end_global = global_variable_hrm();
        $field_name = 'emp_id';
        $check = $this->hrm_model->check_tbl_by_id('emp_leave_bal', $emp_id, $field_name, $this->companyGroupId);
        if ($check > 0) {
            $leave_status = 'update';
        } else {
            foreach ($leave_types as $key => $val) {
                $data['emp_id'] = $emp_id;
                $data['leave_id'] = $val['id'];
                $data['status'] = $val['status'];
                $data['opening_bal'] = $val['leave_day'];
                $data['closing_bal'] = $val['leave_day'];
                $data['start_date'] = $start_end_global['start_date'];
                $data['end_date'] = $start_end_global['end_date'];
                $data['created_by'] = $_SESSION['loggedInUser']->u_id;
                $data['created_by_cid'] = $this->companyGroupId;
                $this->hrm_model->add_emp_leave($data);
            }
        }
    }
    public function worker_worked_view() {
        $this->breadcrumb->add('HRM', base_url() . 'hrm/Work Done');
        $this->breadcrumb->add('Work Done', base_url() . 'hrm/worker_worked_view');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Work Done';
        $id = $this->uri->segment('3');
        $this->data['single_worker_work'] = $this->hrm_model->get_data('add_bd_request', array('add_bd_request.created_by_cid' => $this->companyGroupId, 'add_bd_request.request_status' => 1, 'add_bd_request.assign_worker' => $id));
        $this->_render_template('workers/per_worker_view', $this->data);
    }
    // Controller End
    /* Task List Work Start*/
     public function hrm_setting(){
		$this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM Setting', base_url() . 'hrm/hrm_setting');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'HRM Setting';

        $this->data['sprint'] = $this->hrm_model->get_table_data1(
            'task_list_sprint'
        );
        $this->data['new_work_detail'] = $this->hrm_model->get_table_data1(
            'new_work_detail'
        );
        $this->data['role'] = $this->hrm_model->get_table_data1(
            'task_list_role'
        );
        $this->data['all_pipeline_status'] = $this->hrm_model->get_table_data1(
            'task_list_status'
        );
        $this->data['data'] = $this->hrm_model->get_table_data(
            'task_list_status'
        );
        $this->data['all_pipeline_data'] = $this->hrm_model->get_table_data1(
            'task_list_status'
        );
        $this->data['transition_data'] = $this->hrm_model->get_table_data3(
            'transition_tasklist'
        );

			$where = array('c_id' =>$this->companyGroupId );
			$this->data['user']  = $this->hrm_model->get_filter_details('user_detail', $where);
			$where = array('c_id' =>$this->companyGroupId,'hr_permissions'=>1 );
			$user = $this->hrm_model->get_filter_details('user', $where);
			$userId=array();
       foreach ($user as  $uservalue) {
          $userId[]= $uservalue['id'];
    } 
		$this->data['userDetail']='';
		if (!empty($userId)) {
			 $this->data['userDetail']= $this->hrm_model->get_user_details('user_detail', $userId);
		}

       $where = array('c_id' =>$this->companyGroupId,'tatdsand_mail_permissions'=>1 );
       $user = $this->hrm_model->get_filter_details('user', $where);

         $userId=array();
       foreach ($user as  $uservalue) {
          $userId[]= $uservalue['id'];
    } 
    $this->data['userDetailtada']='';
    if (!empty($userId)) {
         $this->data['userDetailtada']= $this->hrm_model->get_user_details('user_detail', $userId);
    }

      $where = array('c_id' =>$this->companyGroupId,'tatdsand_mail_permissions_account'=>1 );
       $user = $this->hrm_model->get_filter_details('user', $where);

         $userId=array();
       foreach ($user as  $uservalue) {
          $userId[]= $uservalue['id'];
    } 
    $this->data['userDetailacount']='';
    if (!empty($userId)) {
         $this->data['userDetailacount']= $this->hrm_model->get_user_details('user_detail', $userId);
    }
      // $where = "employeeId = '{$userAllActive['id']}'";  
       $where12='';
         if( !empty($_GET['startEmp']) && !empty($_GET['endEmp']) ){
         
            $startEmp = date('Y-m-d 00:00:01',strtotime($_GET['startEmp']));
            $endEmp = date('Y-m-d 23:59:59',strtotime($_GET['endEmp']));
              $where12 .= "(atten_date >= '{$startEmp}' AND atten_date <= '{$endEmp}')";
        }else{  
         $where12 .= "MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE()) ";
     }
        
        $this->data['employshiftChange']  = $this->hrm_model->get_worker_data('employshiftChange',$where12);
       
        $where13='';
         if( !empty($_GET['startWorker']) && !empty($_GET['endWorker']) ){
          
            $startWorker = date('Y-m-d 00:00:01',strtotime($_GET['startWorker']));
            $endWorker = date('Y-m-d 23:59:59',strtotime($_GET['endWorker']));
             $where13 .= "(atten_date >= '{$startWorker}' AND atten_date <= '{$endWorker}')";
        }else{  
         $where13 .= "MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE()) ";
     }
        
         $this->data['workershiftChange']  = $this->hrm_model->get_worker_data('workershiftChange',$where13);
          
       $this->_render_template('task_list_setting/index');
    }

    public function add_task_list_status()
    {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $data['task_list_data'] = $this->hrm_model->get_element_by_id(
            'task_list_status',
            'id',
            $id
        );
        //  pre($data);die;
        $this->load->view('task_list_setting/edit', $data);
    }

     public function view_task_list_status()
    {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $data['task_list_data'] = $this->hrm_model->get_element_by_id('task_list_status','id',$id);
        //  pre($data);die;
        $this->load->view('task_list_setting/view', $data);
    }

    public function savePipeLineDetails()
    {
        if ($this->input->post()) {
            $required_fields = ['id'];
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $status = $this->input->post('status');
            $task_done = $this->input->post('task_done');

            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = [];
                $data = [
                    'name' => $name,
                    'status' => $status,
                    'task_done' => $task_done,
                    'created_by' => $_SESSION['loggedInUser']->u_id,
                    'created_by_cid' => $this->companyGroupId,
                ];
                   // pre($data);die;
                if (empty($id)) {
                    $inserted_id = $this->hrm_model->insert_tbl_data('task_list_status',$data);
                    $update_data = ['sequence_id' => $inserted_id];
                    $this->hrm_model->updateData('task_list_status',$update_data,'id',$inserted_id);
                    $this->session->set_flashdata('message','Record Added successfully');
                    redirect('hrm/hrm_setting', 'refresh');
                } else {
                    $this->hrm_model->updateData(
                        'task_list_status',
                        $data,
                        'id',
                        $id
                    );
                    $this->session->set_flashdata('message', 'Record Updated');
                    redirect('hrm/hrm_setting', 'refresh');
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function set_task_list_status()
    {
        $all_data = $this->input->post();
        $sourceId = $all_data['sourceId'];
        $target_id = $all_data['target_id'];
        $update_data1 = ['sequence_id' => $all_data['sourceId']];
        $update_data2 = ['sequence_id' => $all_data['target_id']];
        $source_id = $this->hrm_model->get_element_by_id(
            'task_list_status',
            'sequence_id',
            $sourceId
        );
        $target_id = $this->hrm_model->get_element_by_id(
            'task_list_status',
            'sequence_id',
            $target_id
        );

        $this->hrm_model->updateData(
            'task_list_status',
            $update_data1,
            'id',
            $target_id->id
        );
        $this->hrm_model->updateData(
            'task_list_status',
            $update_data2,
            'id',
            $source_id->id
        );
        return;
    }

    public function add_role_task_list()
    {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $data['task_list_role_data'] = $this->hrm_model->get_element_by_id(
            'task_list_role',
            'id',
            $id
        );
        //  pre($data);die;
        $this->load->view('task_list_setting/role/edit', $data);
    }

    public function add_role_task_list_to_user()
    {
        $id = @$_POST['id'];

        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $data['users1'] = $this->hrm_model->get_data('user', [
            'user.c_id' => $this->companyGroupId,
            'user.role' => 2,
            'user.status' => 1,
        ]);

        $data['id'] = $id;
        $data['role_data'] = $this->hrm_model->get_element_by_id(
            'assigned_roles',
            'role_id',
            $id
        );

        $this->load->view('task_list_setting/role_assign_users/edit', $data);
    }

    public function saveRoleDetails()
    {
        if ($this->input->post()) {
            $required_fields = ['id'];
            $id = $this->input->post('id');
            $name = $this->input->post('name');

            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = [];
                $data = [
                    'name' => $name,
                    'created_by' => $_SESSION['loggedInUser']->u_id,
                    'created_by_cid' => $this->companyGroupId,
                ];
                //  pre($data);die;
                if (empty($id)) {
                    $inserted_id = $this->hrm_model->insert_tbl_data(
                        'task_list_role',
                        $data
                    );
                    $this->session->set_flashdata(
                        'message',
                        'Record Added successfully'
                    );
                    redirect('hrm/hrm_setting', 'refresh');
                } else {
                    $this->hrm_model->updateData(
                        'task_list_role',
                        $data,
                        'id',
                        $id
                    );
                    $this->session->set_flashdata('message', 'Record Updated');
                    redirect('hrm/hrm_setting', 'refresh');
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }



 public function del_task_list_role($id = '')
    {
        if (!$id) {
            redirect('hrm/hrm_setting', 'refresh');
        }
        permissions_redirect('is_delete');

        $result = $this->hrm_model->delete_data('task_list_role', 'id', $id);
       if($result){
            logActivity('Task Details Deleted','task_list_status',$id);
            $this->session->set_flashdata('message', 'Task Details Deleted Successfully');
            $result = array('msg' => 'Task Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'hrm/hrm_setting');    
            echo json_encode($result);
            die;
        } 
        else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
    }
    public function saveRoleAssignedtoDetails()
    {
        if ($this->input->post()) {
         //   $assigned_to_user = count($_POST['assigned_to_user']);
            $assigned_to_worker = count($_POST['assigned_to_worker']);
            $role_id = $_POST['name'];
            $id = $_POST['id'];
        }

        if ($assigned_to_worker > 0) {
            $arr1 = [];
            $i = 0;
            while ($i < $assigned_to_worker) {
                $jsonArrayObject = [
                    'assigned_to_worker' => $_POST['assigned_to_worker'][$i],
                ];
                $arr1[$i] = $jsonArrayObject;
                $i++;
            }
            $assigned_to_worker_array = json_encode($arr1);
        } else {
            $assigned_to_worker_array = '';
        }
      /*  if ($assigned_to_user > 0) {
            $arr = [];
            $i = 0;
            while ($i < $assigned_to_user) {
                $jsonArrayObject = [
                    'assigned_to_user' => $_POST['assigned_to_user'][$i],
                ];
                $arr[$i] = $jsonArrayObject;
                $i++;
            }
            $assigned_to_user_array = json_encode($arr);
        } else {
            $assigned_to_user_array = '';
        }*/
        //   pre($assigned_to_array);
         /* pre($id);     
          pre($assigned_to_worker_array);    die;*/
        $required_fields = ['assigned_to_worker'];

        $is_valid = validate_fields($_POST, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $data = [
                'assigned_to_user' => 0,
                'assigned_to_worker' => $assigned_to_worker_array,
                'role_id' => $role_id,
                'created_by' => $_SESSION['loggedInUser']->u_id,
                'created_by_cid' => $this->companyGroupId,
            ];
        }

        if (empty($id)) {
            $inserted_id = $this->hrm_model->insert_tbl_data(
                'assigned_roles',
                $data
            );
            $this->session->set_flashdata(
                'message',
                'Record Added successfully'
            );
            redirect('hrm/hrm_setting', 'refresh');
        } else {
            $this->hrm_model->updateData('assigned_roles', $data, 'id', $id);
            $this->session->set_flashdata('message', 'Record Updated');
            redirect('hrm/hrm_setting', 'refresh');
        }
    }

    public function getManagerId(){
          $id =$_POST['id'];
      echo getNameById('user_detail',$id,'id')->manager_id;
    }

    public function getSupervisorById(){
        $this->hrm_model->get_worker_supervisor($_POST['id']);
    }

    public function add_task_to_userWorker()
    {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $data['work_detail'] = $this->hrm_model->get_element_by_id('new_work_detail','id', $id);
       // $data['comments'] = $this->hrm_model->get_element_by_id('new_work_details_comments','new_work_detail_id', $id);
        //  pre($data);die;
        $data['comments'] = $this->hrm_model->get_data('new_work_details_comments', [
            'new_work_details_comments.created_by_cid' => $this->companyGroupId,
            'new_work_details_comments.new_work_detail_id' => $id,
           
        ]);
        
       # pre($data['comments']);die;
        $this->load->view('work_detail/task/edit', $data);
    }

    public function deleteTaskListStatus($id = '')
    {
        if (!$id) {
            redirect('hrm/hrm_setting', 'refresh');
        }
        permissions_redirect('is_delete');
        
        
        
        $result = $this->hrm_model->delete_data('task_list_status', 'id', $id);
              $this->hrm_model->delete_data('transition_tasklist', 'pipeline_id', $id);
        
        if($result){
            logActivity('Task Details Deleted','task_list_status',$id);
            $this->session->set_flashdata('message', 'Task Details Deleted Successfully');
            $result = array('msg' => 'Task Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'hrm/hrm_setting');    
            echo json_encode($result);
            die;
        } 
        else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        }
    }

    public function new_task_list()
    {
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();
        $this->breadcrumb->add('HRM', base_url() . 'hrm/users');
        $this->breadcrumb->add('Task List', base_url() . 'hrm/new_task_list');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Task List New';

        $this->data['worker'] = $this->hrm_model->get_data('worker', [
            'worker.created_by_cid' => $this->companyGroupId,
            'worker.active_inactive' => 1,
           
        ]);
/*   $this->data['user1'] = $this->hrm_model->get_data('user', [
            'user.c_id' => $this->companyGroupId,
            'user.role' => 2,
            'user.status' => 1,
        ]);
*/  if(isset($_POST)){
        // if ($_POST['user_id'] != '0') {
            if (!empty($_POST['user_id'])) {
            $array = [];
            $this->data['processType'] = $this->hrm_model->get_table_data2(
                'task_list_status'
            );
            $i = 0;

            foreach ($this->data['processType'] as $ProcessType) {
                $where = [
                    'new_work_detail.pipeline_status' => $ProcessType['id'],
                    'new_work_detail.created_by_cid' => $this->companyGroupId,
                    'new_work_detail.assigned_to' => $_POST['user_id'],
                ];

                $process = $this->hrm_model->get_data(
                    'new_work_detail',
                    $where
                );
                $array[$i]['types'] = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }

            $this->data['processdata'] = $array;
            $this->_render_template(
                'task_list_setting/task_list/index',
                $this->data
            );
        } else {
            $array = [];

            $this->data['processType'] = $this->hrm_model->get_table_data2(
                'task_list_status'
            );

            $i = 0;
            foreach ($this->data['processType'] as $ProcessType) {
                $where = [
                    'new_work_detail.pipeline_status' => $ProcessType['id'],
                    'new_work_detail.created_by_cid' => $this->companyGroupId,
                ];

                $process = $this->hrm_model->get_data(
                    'new_work_detail',
                    $where
                );
                $array[$i]['types'] = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }
            $this->data['processdata'] = $array;
            $this->_render_template('task_list_setting/task_list/index',$this->data);
        }
    }   
    }

    public function saveNewWorkdetail(){
	
        if ($this->input->post()) {
            $data['assigned_to'] = $_POST['assigned_to'];
            $data['superviser'] = $_POST['superviser'];
            $data['task_name'] = $_POST['task_name'];
            $data['description'] = $_POST['description'];
            $data['pipeline_status'] = $_POST['pipeline_status'];
            $data['start_date'] = $_POST['start_date'];
            $data['due_date'] = $_POST['due_date'];
            $data['npdm'] = $_POST['npdm'];
            $data['repeat_task'] = $_POST['repeat_task'];
            $data['repeatation_days'] = $_POST['repeatation_days'];
            $data['repeatation_on_off'] = $_POST['repeatation_on_off'];
            $data['created_by'] = $_SESSION['loggedInUser']->u_id;
            $data['created_by_cid'] = $this->companyGroupId;

          if (isset($_POST['name'])) {
               $role_id = $_POST['name'];
            }
            $id = $_POST['id'];
        }

        if (empty($id)) {
            /* pre($data['task_name']);
             echo"second";*/
            $total_records = count($data['task_name']);

            if ($total_records > 0) {
                $arr = [];
                $i = 0;
                while ($i < $total_records) {
                    $jsonArrayObject = [
                        'assigned_to' => $_POST['assigned_to'],
                        'superviser' => $_POST['superviser'],
                        'task_name' => $_POST['task_name'][$i],
                        'description' => $_POST['description'][$i],
                        'pipeline_status' => $_POST['pipeline_status'][$i],
                        'start_date' => $_POST['start_date'][$i],
                        'due_date' => $_POST['due_date'][$i],
                        'npdm' => $_POST['npdm'][$i],
                        'attachment' =>'',
                        'repeat_task' => $_POST['repeat_task'][$i],
                        'repeatation_days' => $_POST['repeatation_days'][$i],
                        'repeatation_on_off' =>$_POST['repeatation_on_off'][$i],
                        'created_by' => $_SESSION['loggedInUser']->u_id,
                        'created_by_cid' => $this->companyGroupId,
                    ];

                    $arr[$i] = $jsonArrayObject;
                    $i++;
                }
                   // pre($arr);die;

                // $assigned_to_array = json_encode($arr);
            } else {
                $assigned_to_array = '';
            }

             $total_records = count($arr);
            // die;
            for ($x = 0; $x < $total_records; $x++) {
                $inserted_id = $this->hrm_model->insert_tbl_data('new_work_detail', $arr[$x]);
            }

            $this->session->set_flashdata('message','Record Added successfully');
            redirect('hrm/task_list_workers', 'refresh');
        } else {


            $new_work_detail_id = $id;
            $comments   =   $_POST['comments'];
            if(!empty($comments))
             {  

                $data1 = array(
                    'new_work_detail_id'=> $new_work_detail_id,
                    'comments'=> $comments,
                    'created_by'=> $_SESSION['loggedInUser']->u_id,
                    'created_by_cid'=> $this->companyGroupId
                    
                );


                $this->hrm_model->insert_tbl_data('new_work_details_comments', $data1);
             }
      
            $this->hrm_model->updateData('new_work_detail', $data, 'id', $id);
			
			
            $this->session->set_flashdata('message', 'Record Updated');
            redirect('hrm/task_list_workers', 'refresh');
        }
    }

    function empty_data_transition_table()
    {
        $table = "transition_tasklist";
        $this->hrm_model->truncate_tbl_data($table);
          redirect('hrm/hrm_setting', 'refresh');
    }
    
   function insert_data_transition_table()
    {
        $all_pipeline_status = $this->hrm_model->get_table_data1('task_list_status');
       
	   foreach ($all_pipeline_status as $key => $val) {
            $id[] = $val->id;
            $status[] = $val->status;
			
        }
		

        foreach ($id as $key1 => $val1) {
            $id_one = $val1;
            $status_one = $status[$key1];
            $from_status = [$id_one => $status_one];

            foreach ($id as $key2 => $val2) {
				$jsonArrayObject = [$val2 => $status[$key2]];
                $arr[$key2] = $jsonArrayObject;
				$jsonArrayObject2 = [$val2 => "0"];
                $arr2[$val2] = $jsonArrayObject2;
			}
			$statusva = json_encode($arr2);	
            $to_status = json_encode($arr);
            $from_status = json_encode($from_status);

            $val11 = (int) $val1;
            $data = [
                'pipeline_id' => $val11,
                'from_status' => $from_status,
                'to_status' => $to_status,
                // 'status' => $statusva,
                'created_by_cid' => $this->companyGroupId,
            ];

            $rows_returned = $this->hrm_model->check_transition_data('transition_tasklist',$val11);
			
			// pre($data);die();
            if ($rows_returned > 0) {
                $this->hrm_model->updateData('transition_tasklist',$data,'pipeline_id',$val11);
            } else {
                $this->hrm_model->insert_tbl_data('transition_tasklist', $data);
            }
        }
		
        redirect('hrm/hrm_setting', 'refresh');
    }

    function set_transition_status(){
		// pre($_POST["formData"]);die();
        parse_str($_POST["formData"], $monthYearyArray);
        foreach ($monthYearyArray as $key => $val) {
            $all_status[] = [$key => $val];
        }
        $pipeline_id = $all_status[0][row_id];
        unset($all_status[0]);
        $status = json_encode($all_status);
        $data = ['status' => $status];

        /* pre($pipeline_id); */
     // pre($data);die; 
    
      $result = $this->hrm_model->updateData('transition_tasklist',$data,'pipeline_id',$pipeline_id);
        
      
        if($result){
            logActivity('Task Details Deleted','task_list_status',$id);
            $this->session->set_flashdata('message', 'Task Details Saved Successfully');
            $result = array('msg' => 'Task Details Saved Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'hrm/hrm_setting');    
            echo json_encode($result);
            die;
        } 
        else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C271'));
        } 
    }

    function xset_transition_status()
    {
        parse_str($_POST["formData"], $monthYearyArray);

        foreach ($monthYearyArray as $key => $val) {
            $all_status[] = [$key => $val];
        }
        $pipeline_id = $all_status[0][row_id];

        unset($all_status[0]);

        $status = json_encode($all_status);
        $data = [
            'status' => $status,
        ];
        // pre($data);
        // die();
        $this->hrm_model->updateData(
            'transition_tasklist',
            $data,
            'pipeline_id',
            $pipeline_id
        );
    }

    public function add_sprint_task_list()
    {
        $id = @$_POST['id'];
        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $data['task_list_sprint_data'] = $this->hrm_model->get_element_by_id(
            'task_list_sprint',
            'id',
            $id
        );

        $this->load->view('task_list_setting/sprint/edit', $data);
    }

    public function saveSprintDetails()
    {
        if ($this->input->post()) {
            $required_fields = ['id'];
            $id = $this->input->post('id');
            $name = $this->input->post('name');

            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = [];
                $data = [
                    'name' => $name,
                    'created_by' => $_SESSION['loggedInUser']->u_id,
                    'created_by_cid' => $this->companyGroupId,
                ];
                //  pre($data);die;
                $field_name = 'id';
                $check = $this->hrm_model->check_tbl_by_id2(
                    'task_list_sprint',
                    $this->companyGroupId
                );

                //  if (empty($id)) {
                if ($check > 0) {
                    $this->hrm_model->updateData(
                        'task_list_sprint',
                        $data,
                        'id',
                        $id
                    );
                    $this->session->set_flashdata('message', 'Record Updated');
                    redirect('hrm/hrm_setting', 'refresh');
                } else {
                    //     pre($data);die;
                    $inserted_id = $this->hrm_model->insert_tbl_data(
                        'task_list_sprint',
                        $data
                    );
                    $this->session->set_flashdata(
                        'message',
                        'Record Added successfully'
                    );
                    redirect('hrm/hrm_setting', 'refresh');
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function deleteSprint($id = '')
    {
        if (!$id) {
            redirect('hrm/hrm_setting', 'refresh');
        }
        permissions_redirect('is_delete');

        $result = $this->hrm_model->delete_data('task_list_sprint', 'id', $id);
       if($result){
            
            $this->session->set_flashdata('message', 'Sprint Deleted Successfully');
            $result = array('msg' => 'Sprint Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'hrm/hrm_setting');    
            echo json_encode($result);
            die;
        
        } else {
            $this->session->set_flashdata('message', 'Sprint Not Deleted');
        }
    }

    public function delete_new_work_detail($id = '')
    {
        if (!$id) {
            redirect('hrm/task_list_workers', 'refresh');
        }
        permissions_redirect('is_delete');

        $result = $this->hrm_model->delete_data('new_work_detail', 'id', $id);
      if($result){
            logActivity('Work Details Deleted','task_list_status',$id);
            $this->session->set_flashdata('message', 'Work Details Deleted Successfully');
            $result = array('msg' => 'Work Details Deleted Successfully', 'status' => 'success', 'code' => '309','url' => base_url() . 'hrm/task_list_workers');    
            echo json_encode($result);
            die;
        }  else {
            $this->session->set_flashdata('message', 'Task Not Deleted');
        }
    }

    public function load_transition_authority($id = '')
    {
     $pipeline_id =   $data['row_id'] = @$_POST['row_id'];
     $col_id =   $data['col_id'] = @$_POST['col_id'];

        if ($this->input->post('id') != '') {
            permissions_redirect('is_edit');
        } else {
            permissions_redirect('is_add');
        }

        $this->data['role'] = $this->hrm_model->get_table_data1(
            'task_list_role'
        );
        $this->data['assignee_supervisor'] = $this->hrm_model->get_table_data1(
            'new_work_detail'
        );

        $data['authority_data'] = $this->hrm_model->get_data('transition_authority', [
            'transition_authority.created_by_cid' => $this->companyGroupId,
            'transition_authority.pipeline_id' => $pipeline_id,
            'transition_authority.col_id' => $col_id,
        ]);

     
        $this->load->view('task_list_setting/transition_authority/edit', $data);
    }

    public function saveTransitionAuthority()
    {
        if ($this->input->post()) {
            $role = count($_POST['role']);
            $supervisor = $_POST['supervisor'];

          
            $row_id = $_POST['row_id'];
            $col_id = $_POST['col_id'];
            $assignee = $_POST['assignee'];
        }

        if ($role > 0) {
            $arr1 = [];
            $i = 0;
            while ($i < $role) {
                $jsonArrayObject = ['role' => $_POST['role'][$i]];
                $arr1[$i] = $jsonArrayObject;
                $i++;
            }
            $role = json_encode($arr1);
        } else {
            $role = '';
        }
  

        $required_fields = ['role'];

        $is_valid = validate_fields($_POST, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $data = [
                'role' => $role,
                'supervisor' => $supervisor,
                'pipeline_id' => $row_id,
                'col_id' => $col_id,
                'assignee' => $assignee,

                'created_by_cid' => $this->companyGroupId,
            ];
        }

        $check = $this->hrm_model->check_tbl_by_id3(
            'transition_authority',
            $row_id,
            $col_id,
            $this->companyGroupId
        );
     /*  pre($check); 
       pre($data); die;*/
            
        if ($check > 0) {
            $this->hrm_model->updateData3('transition_authority',$data,'pipeline_id', $row_id, 'col_id',$col_id,'created_by_cid',$this->companyGroupId);
            $this->session->set_flashdata('message', 'Record Updated');
            redirect('hrm/hrm_setting', 'refresh');
        } else {
            $inserted_id = $this->hrm_model->insert_tbl_data(
                'transition_authority',
                $data
            );

            $this->session->set_flashdata(
                'message',
                'Record Added successfully'
            );
            redirect('hrm/hrm_setting', 'refresh');
        }
    }
  public function xsaveTransitionAuthority()
    {
        if ($this->input->post()) {
            $role = count($_POST['role']);
            $supervisor = count($_POST['supervisor']);
            $row_id = $_POST['row_id'];
            $col_id = $_POST['col_id'];
            $assignee = $_POST['assignee'];
        }

        if ($role > 0) {
            $arr1 = [];
            $i = 0;
            while ($i < $role) {
                $jsonArrayObject = ['role' => $_POST['role'][$i]];
                $arr1[$i] = $jsonArrayObject;
                $i++;
            }
            $role = json_encode($arr1);
        } else {
            $role = '';
        }
        if ($supervisor > 0) {
            $arr = [];
            $i = 0;
            while ($i < $supervisor) {
                $jsonArrayObject = ['supervisor' => $_POST['supervisor'][$i]];
                $arr[$i] = $jsonArrayObject;
                $i++;
            }
            $supervisor = json_encode($arr);
        } else {
            $supervisor = '';
        }
        //   pre($assigned_to_array);

        $required_fields = ['role'];

        $is_valid = validate_fields($_POST, $required_fields);
        if (count($is_valid) > 0) {
            valid_fields($is_valid);
        } else {
            $data = [
                'role' => $role,
                'supervisor' => $supervisor,
                'pipeline_id' => $row_id,
                'col_id' => $col_id,
                'assignee' => $assignee,

                'created_by_cid' => $this->companyGroupId,
            ];
        }

        $check = $this->hrm_model->check_tbl_by_id3(
            'transition_authority',
            $row_id,
            $col_id,
            $this->companyGroupId
        );

        if ($check > 0) {
            $this->hrm_model->updateData3(
                'transition_authority',
                $data,
                'pipeline_id',
                $row_id,
                'col_id',
                $col_id,
                'created_by_cid',
                $this->companyGroupId
            );
            $this->session->set_flashdata('message', 'Record Updated');
            redirect('hrm/hrm_setting', 'refresh');
        } else {
            $inserted_id = $this->hrm_model->insert_tbl_data(
                'transition_authority',
                $data
            );

            $this->session->set_flashdata(
                'message',
                'Record Added successfully'
            );
            redirect('hrm/hrm_setting', 'refresh');
        }
    }

    function get_data_transition_tasklist()
    {
        $all_data = $this->input->post();
        $pipeline_id = $all_data['pipeline_id'];
        $target_id = $all_data['target_id'];
        $id = $all_data['id'];
        $created_by_cid = $this->companyGroupId;
         // pre($all_data);die;
        $transition_tasklist_data = $this->hrm_model->getData_two_para(
            'transition_tasklist',
            'pipeline_id',
            $pipeline_id,
            'created_by_cid',
            $created_by_cid
        );
        $transition_data = json_decode($transition_tasklist_data->status);
        foreach ($transition_data as $val) {
            if ($val->$target_id == 1) {
                $data = ['pipeline_status' => $target_id];
                $this->hrm_model->updateData(
                    'new_work_detail',
                    $data,
                    'id',
                    $id
                );
            }
        }
    }
    public function reverify()
    {
        $email = $_POST['email'];
        $randomNumberPass = rand(100000000, 999999999);
        $password = easy_crypt($randomNumberPass);
        $data['activation_code'] = md5(rand());
        $data['password'] = $password;
        $this->hrm_model->update_activation('user', $data, 'id', $_POST['id']);
        $usernme = getNameById('user_detail', $_POST['id'], 'u_id');
        $email_message =
            '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                                                        <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                                                            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi ' .
            $usernme->name .
            ',</p>   
                                                            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Thanks for Registration. Your password is ' .
            $randomNumberPass .
            ', This password will work only after your email verification.</p>                           
                                                            <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Please Open this link to verified your email address - ' .
            base_url() .
            'auth/verifyEmail/' . $data["activation_code"] .
            '</p> 
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                </tr>';
        $res = send_mail($email, 'Email Verification', $email_message);
        if (!empty($res)) {
            echo true;
            $this->session->set_flashdata(
                'message',
                'Reverification Email sent successfully'
            );
        }
    }
    
    
    public function task_list_daterange()
    {
      $start_end_date = [
            'start_date' => date(
                "Y-m-d",
                strtotime($this->input->post('start'))
            ),
            'end_date' => date("Y-m-d", strtotime($this->input->post('end'))),
        ];
        $start_date = date("Y-m-d", strtotime($this->input->post('start')));
        $end_date = date("Y-m-d", strtotime($this->input->post('end')));

        $where = 'AND created_by_cid = ' . $this->companyGroupId;
             $this->data['sprint'] = $this->hrm_model->get_table_data1(
            'task_list_sprint'
        );
       
       
         $data['new_work_detail']  = $this->hrm_model->get_all_task_iist(
            $this->companyGroupId,
            $start_date,
            $end_date
        );  
         $this->session->set_userdata('task_list_date_range', $data);
         redirect('hrm/hrm_setting', 'refresh');
       
    }
    /* Task List Work End*/
    
    
    public function save_Settings(){
        
    
        if(isset($_POST['workerSupervisor_setting'])){
            $login_company_id = $this->companyGroupId;
            $retrn_val = $this->hrm_model->update_SupervisorSettings('company_detail',$_POST['workerSupervisor_setting'],$login_company_id); 
            if($retrn_val > 0){
             $this->session->set_flashdata('message', 'Settings changed Successfully');
             redirect('hrm/hrm_setting', 'refresh');    
         }
        }   
        if(isset($_POST['hrm_worker_data'])){
        
            $login_company_id = $this->companyGroupId;
            $retrn_val = $this->hrm_model->update_workerdataSettings('company_detail',$_POST['hrm_worker_data'],$login_company_id); 
            if($retrn_val > 0){
             $this->session->set_flashdata('message', 'worker data changed Successfully');
             redirect('hrm/hrm_setting', 'refresh');    
         }
        }
    }
    public function save_npdm_setting(){
    
        if(isset($_POST['npdm_setting'])){
        
            $login_company_id = $this->companyGroupId;
            $retrn_val = $this->hrm_model->update_npdm_setting('company_detail',$_POST['npdm_setting'],$login_company_id); 
            if($retrn_val > 0){
             $this->session->set_flashdata('message', 'Settings changed Successfully');
             redirect('hrm/hrm_setting', 'refresh');    
         }
        }   
    }
 public function worker_ot_salary(){
            
            $data= $_POST['hrm_worker_ot_salary'];
            $id=$_POST['id'];
             
                    $success = $this->hrm_model->Worker_ot_salary($id,$data); 
                  if($success > 0){
                    $this->session->set_flashdata('message', 'Worker OT Salary Updated Successfully');
                  redirect('hrm/hrm_setting', 'refresh');    
                }
            }
      
     public function empWorkingHrs(){
            
            $data= $_POST['empWorkingHrs'];
            $id=$_POST['id'];
             
                    $success = $this->hrm_model->empWorkingHrsM($id,$data); 
                  if($success > 0){
                    $this->session->set_flashdata('message', 'Employees Working HRS Updated Successfully');
                  redirect('hrm/hrm_setting', 'refresh');    
                }
            }
      public function disApprove_ta_da() {
        if ($this->input->post()) {
            $required_fields = array('disapprove_reason');
            $is_valid = validate_fields($_POST, $required_fields);
            if (count($is_valid) > 0) {
                valid_fields($is_valid);
            } else {
                $data = $this->input->post();
                $idss1 = $_POST['id'];
                $id = explode(",", $idss1);
                $usersWithViewPermissions = $this->hrm_model->get_data('permissions', array('is_view' => 1, 'sub_module_id' => 1));
                foreach ($id as $key) {
                    $data = array('id' => $key, 'approve_by' => $_POST['validated_by'], 'approve_status' => $_POST['disapprove'], 'disapprove_reason' => $_POST['disapprove_reason']);
                    $success = $this->hrm_model->disApprove_ta_da($data,$idss1);
                    logActivity('TA/DA Disapproved', 'travel_info', $key);
                    if (!empty($usersWithViewPermissions)) {
                        foreach ($usersWithViewPermissions as $userViewPermission) {
                            if ($userViewPermission['user_id'] != $_SESSION['loggedInUser']->u_id) {
                                pushNotification(array('subject' => 'TA/DA disapproved', 'message' => 'TA/DA id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $userViewPermission['user_id'], 'ref_id' => $key, 'class' => 'add_purchase_tabs', 'data_id' => 'indentView', 'icon' => 'fa-shopping-cart'));
                            }
                        }
                    }
                    if ($_SESSION['loggedInUser']->role != 1) {
                        pushNotification(array('subject' => 'TA/DA disapproved', 'message' => 'TA/DA id :# ' . $key . ' is disapproved by ' . $_SESSION['loggedInUser']->name, 'from_id' => $_SESSION['loggedInUser']->u_id, 'to_id' => $_SESSION['loggedInUser']->u_id, 'ref_id' => $key, 'class' => 'hrmTab', 'data_id' => 'ViewTavelInfo', 'icon' => 'fa-shopping-cart'));
                    }
                }
                if ($success) {
                    $data['message'] = "TA/DA Disapproved";
                    //  logActivity('Idnent Disapproved','purchasE_indent',$id);
                    //pushNotification(array('subject'=> 'Purchase indent disapproved' , 'message' => 'Purchase indent disapproved by '.$_SESSION['loggedInUser']->u_id.'  with id : '.$id.'', 'from_id'=>$_SESSION['loggedInUser']->u_id , 'ref_id'=> $id));
                    $this->session->set_flashdata('message', 'TA/DA Disapproved successfully');
                    redirect(base_url() . 'hrm/travel_info', 'refresh');
                }
            }
        }
    }
    
    
      public function view_new_workdetails() {
        $id = $_POST['id'];
        if ($id == '') {
            redirect(base_url() . 'hrm/new_task_list');
        } else {
            $this->data['work_detail'] = $this->hrm_model->get_data_byId('new_work_detail', 'id', $id);
            $this->load->view('work_detail/task/view', $this->data);
            
        }
    }
    
    
    public function task_list_workers(){
        $this->load->library('pagination');
        $this->data['can_edit'] = edit_permissions();
        $this->data['can_delete'] = delete_permissions();
        $this->data['can_add'] = add_permissions();
        $this->data['can_view'] = view_permissions();

        $this->breadcrumb->add('Task List Workers', base_url() . 'hrm/task_list_workers');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Task List Workers';
		$where=['created_by_cid' => $this->companyGroupId];
		$where2 = '';
        
		if (isset($_GET['search']) && $_GET['search'] != '') {
            $where2 = "worker.id like '%" . $_GET['search'] . "%'";
        }

        if (!empty($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "desc";
        }

    if(isset($_GET['start']) ||  isset($_GET['start'])!='' && isset($_GET['end']) || isset($_GET['end'])!='' && isset($_GET['ExportType'])==''){
        $where=['created_by_cid' => $this->companyGroupId ,'due_date >='=> $_GET['start'] ,'due_date <='=> $_GET['end']];
    }
    
    if(isset($_GET['superviser']) && $_GET['superviser']!='' && $_GET['status']==''){ //die('1');
        $where=['created_by_cid' => $this->companyGroupId ,'superviser'=> $_GET['superviser']];
    }
    
    if(isset($_GET['assigned_to']) && $_GET['assigned_to']!='' && $_GET['status']==''){//die('2');
       $where=['created_by_cid' => $this->companyGroupId ,'assigned_to'=> $_GET['assigned_to'],'pipeline_status!='=>4,'start_date<='=>date('Y-m-d'),'task_done'=>0];
    }

    if(isset($_GET['assigned_to']) && $_GET['assigned_to']!='' && $_GET['status']=='completed'){//die('3');
          $where=['created_by_cid' => $this->companyGroupId ,'assigned_to'=> $_GET['assigned_to'],'task_done'=>1];
    }

    if(isset($_GET['superviser']) && $_GET['superviser']!='' && $_GET['status']=='completed'){
          $where=['created_by_cid' => $this->companyGroupId ,'superviser'=> $_GET['superviser'],'task_done'=>1];
    }
    
     if(isset($_GET['status'])=='completed' && isset($_GET['assigned_to'])=='' && isset($_GET['supervisor'])=='' && isset($_GET['ExportType'])==''){//die('33');
        $where=['created_by_cid' => $this->companyGroupId ,'task_done'=>1];
    }elseif(isset($_GET['status'])=='completed' && isset($_GET['assigned_to'])=='' && isset($_GET['supervisor'])=='' && isset($_GET['ExportType'])!=''){//die('32');
        $where=['created_by_cid' => $this->companyGroupId ,'task_done'=>1];
    }
    if(isset($_GET['ExportType']) && $_GET['ExportType']!='' && $_GET['assigned_to']=='' && $_GET['start']=='' && $_GET['end']==''&& $_GET['supervisor']=='' && $_GET['status']==''){
        $where=['created_by_cid' => $this->companyGroupId];
    }elseif(isset($_GET['ExportType'])!='' && isset($_GET['assigned_to'])!='' && $_GET['start']=='' && $_GET['end']==''&& $_GET['supervisor']==''&& $_GET['status']==''){//die('363');
          $where=['created_by_cid' => $this->companyGroupId ,'assigned_to'=> $_GET['assigned_to'],'pipeline_status!='=>4,'start_date<='=>date('Y-m-d'),'task_done'=>0];
    }elseif(isset($_GET['ExportType'])!='' && isset($_GET['supervisor'])!='' && isset($_GET['assigned_to'])==''&& isset($_GET['start'])=='' && isset($_GET['end'])==''&& isset($_GET['status'])==''){//die('313');
        $where=['created_by_cid' => $this->companyGroupId ,'superviser'=> $_GET['supervisor']];
    }
    if(isset($_GET['ExportType'])!='' && isset($_GET['supervisor'])=='' && isset($_GET['assigned_to'])==''&& $_GET['start']=='' && $_GET['end']==''&& $_GET['status']=='completed'){//die('73');
       $where=['created_by_cid' => $this->companyGroupId ,'task_done'=> 1];
    }
     if(isset($_GET['ExportType'])!='' && $_GET['start']!='' && $_GET['end']!=''&& isset($_GET['supervisor'])!='' && isset($_GET['assigned_to'])==''){//die('53');
        $where=['created_by_cid' => $this->companyGroupId ,'due_date >='=> $_GET['start'] ,'due_date <='=> $_GET['end']];
    }

    
    
    
        $this->data['new_work_detail'] = $this->hrm_model->get_task_list(
            'new_work_detail',$where);
       $this->data['comments'] = $this->hrm_model->get_table_data1(
            'new_work_details_comments','desc');
        $this->data['all_pipeline_status'] = $this->hrm_model->get_table_data1(
            'task_list_status'
        );
        $this->data['data'] = $this->hrm_model->get_table_data(
            'task_list_status'
        );
        $this->data['all_pipeline_data'] = $this->hrm_model->get_table_data1(
            'task_list_status'
        );
        $this->data['transition_data'] = $this->hrm_model->get_table_data3(
            'transition_tasklist'
        );
        $this->data['worker'] = $this->hrm_model->get_data('worker', [
            'worker.created_by_cid' => $this->companyGroupId,'worker.active_inactive' => 1]);

        $rows = $this->hrm_model->num_rows('new_work_detail',$where, $where2);
        //Pagination
        $config = array();
        $config["base_url"] = base_url() . "hrm/task_list_workers/";
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
        if (!empty($_GET['ExportType'])) {
            $export_data = 1;
        } else {
            $export_data = 0;
        }



          $this->data['work_detail'] = $this->hrm_model->get_usr_data('new_work_detail',$where, $config["per_page"], $page, $where2, $order, $export_data);
		  
		 
         if (!empty($this->uri->segment(3))) {
            $frt = (int)$this->uri->segment(3) - 1;
            $start = $frt * $config['per_page'] + 1;
        } else {
            $start = (int)$this->uri->segment(3) * $config['per_page'] + 1;
        }
        if (!empty($this->uri->segment(3))) {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']) + 1)) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'];
        } else {
            $end = ($this->uri->segment(3) == (floor($config['total_rows'] / $config['per_page']))) ? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
        }
        if ($end > $config['total_rows']) {
            $total = $config['total_rows'];
        } else {
            $total = $end;
        }
        $this->data['result_count'] = '<span class="Dj"><span><span class="ts">' . $start . '</span>–<span class="ts">' . $total . '</span></span> of <span class="ts">' . $config['total_rows'] . '</span>';

    if(isset($_POST)){
        // if ($_POST['user_id'] != '0') {
            if (!empty($_POST['user_id'])) {
            $array = [];
            $this->data['processType'] = $this->hrm_model->get_table_data2(
                'task_list_status'
            );
            $i = 0;

            foreach ($this->data['processType'] as $ProcessType) {
              
                 $where = [
                    'new_work_detail.pipeline_status' => $ProcessType['id'],
                    'new_work_detail.created_by_cid' => $this->companyGroupId,
                    'new_work_detail.assigned_to' => $_GET['user_id'],
                    'new_work_detail.task_done' =>0,
                    'new_work_detail.start_date<='=>date('Y-m-d')
                ];

                $process = $this->hrm_model->get_data(
                    'new_work_detail',
                    $where
                );
                $array[$i]['types'] = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }

            $this->data['processdata'] = $array;
            $this->_render_template(
                'task_list_setting/task_list/index',
                $this->data
            );
        } else {
            $array = [];

            $this->data['processType'] = $this->hrm_model->get_table_data2(
                'task_list_status'
            );

            $i = 0;
            foreach ($this->data['processType'] as $ProcessType) {
                if(isset($_GET['assigned_to']) && $_GET['assigned_to']!=''){
            $where = [
                    'new_work_detail.pipeline_status' => $ProcessType['id'],
                    'new_work_detail.created_by_cid' => $this->companyGroupId,
                    'new_work_detail.assigned_to' => $_GET['assigned_to'],
                    'new_work_detail.task_done' => 0,
                    // 'new_work_detail.start_date<='=>date('Y-m-d')
                ];
                }else{
            $where = [
                    'new_work_detail.pipeline_status' => $ProcessType['id'],
                    'new_work_detail.created_by_cid' => $this->companyGroupId,
                    'new_work_detail.task_done' => 0,
                    // 'new_work_detail.start_date<='=>date('Y-m-d')
                ];
                }
               
                $process = $this->hrm_model->get_data(
                    'new_work_detail',
                    $where
                );
                $array[$i]['types'] = $ProcessType;
                $array[$i]['process'] = $process;
                $i++;
            }
            $this->data['processdata'] = $array;
         // pre($this->data);die;
        $this->_render_template('task_list_setting/task_list_workers',$this->data);
    }
    }
   } 

   public function empty_task_list(){
            $where=['created_by_cid' => $this->companyGroupId ,'task_done'=>1];
            $status=$this->hrm_model->get_task_list('task_list_status',$where);
            foreach($status as $data){
                $where=['created_by_cid' => $this->companyGroupId ,'pipeline_status'=>$data->id];
                $data=['task_done'=>1];
                $this->hrm_model->updatePipelineData('new_work_detail',$data,$where);       
            }
            redirect('hrm/task_list_workers');
    }

    
    /* worker_Work  Report coding start ASS  */
      public function change_hr_permissions() {
          $id=$this->input->post(); 
          $ids='';
           foreach ($id as $key => $value) {
               $ids=$value; 
           }  
           $status = 1;
        $status_data = $this->hrm_model->change_status_hr_permissions($ids,$status);
         if ($status_data) { 
            $this->session->set_flashdata('message', ' Hr Permission Approved successfully');
                redirect(base_url() . 'hrm/hrm_setting/'.'refresh');

              }
           
    } 

     public function change_hr_permissions_zero() {
          $id=$this->uri->segment(3);  
           $status = 0;
        $status_data = $this->hrm_model->change_status_hr_permissions($id,$status);
         if ($status_data) { 
             $this->session->set_flashdata('message', ' Hr Permission Cancel successfully');
                redirect(base_url() . 'hrm/hrm_setting/'.'refresh');
          }
           
    } 
     public function change_status_tada_permissions_one() {
          $id=$this->input->post(); 
          $ids='';
           foreach ($id as $key => $value) {
               $ids=$value; 
           }  
           $status = 1;
        $status_data = $this->hrm_model->change_status_tada_permissions($ids,$status);
         if ($status_data) { 
             $this->session->set_flashdata('message', ' TA-DA Permission Approved successfully');
                redirect(base_url() . 'hrm/hrm_setting/'.'refresh');
              }
           
    } 

     public function change_status_tada_permissions_zero() {
          $id=$this->uri->segment(3);   
           $status = 0;
        $status_data = $this->hrm_model->change_status_tada_permissions($id,$status);
         if ($status_data) { 
             $this->session->set_flashdata('message', ' TA-DA Permission Cancel successfully');
                redirect(base_url() . 'hrm/hrm_setting/'.'refresh');
              }
           
    } 
    public function change_status_tada_permissionsAcount() {
          $id=$this->input->post(); 
          $ids='';
           foreach ($id as $key => $value) {
               $ids=$value; 
           }  
           $status = 1;
        $status_data = $this->hrm_model->change_status_tada_permissionsAcount($ids,$status);
         if ($status_data) { 
             $this->session->set_flashdata('message', ' Accountant  Permission Approved successfully');
                redirect(base_url() . 'hrm/hrm_setting/'.'refresh');
              }
           
    } 

     public function change_status_tada_permissionsAcount_zero() {
          $id=$this->uri->segment(3);  
           $status = 0;
        $status_data = $this->hrm_model->change_status_tada_permissionsAcount($id,$status);
         if ($status_data) { 
             $this->session->set_flashdata('message', ' Accountant Permission Cancel successfully');
                redirect(base_url() . 'hrm/hrm_setting/'.'refresh');
              }
           
    } 
 


    public function send_emailFor_TADA($useremail, $tadaid) { 
        
       $tadadata = $this->hrm_model->get_element_by_id('travel_info', 'id', $tadaid);
         $this->load->library('phpmailer_lib');
        $monthYearail = $this->phpmailer_lib->load();
        $monthYearail->SMTPDebug = 0;  
        $monthYearail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $monthYearail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
        $monthYearail->isSMTP();    
        $monthYearail->Host       = 'email-smtp.ap-south-1.amazonaws.com';
        $monthYearail->SMTPAuth   = true;
        $monthYearail->Username   = 'AKIAZB4WVENVZ773ONVF';
        $monthYearail->Password   = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG';
        $monthYearail->SMTPSecure = 'tls';
        $monthYearail->Port       = 587;                     
        $monthYearail->setFrom('dev@lastingerp.com','lerp');  
        //   $monthYearail->addAddress('abhiudai@lastingerp.com','');
        foreach($useremail as $email)
        {
           $monthYearail->addAddress($email, '');
        }
        // Content
        $ab = '<a href="https://lastingerp.com/hrm/travel_info ">Click</a>';
         $monthYearail->isHTML(true); 
     // Email body content
        #$monthYearailContent = $monthYearessageContent; $owner->name." &nbsp;( &nbsp;Emp Code :".$owner->u_id.")";
        $monthYearail->Body = 'Purpose Of Visit : "' . $tadadata->Purpose_of_visit. '"  <br> No Of Days :  "' . $tadadata->no_of_days . '" <br> More Details :  "' . $ab . '" ';
        if($tadadata->approve_status==1) {
         $monthYearail->Subject = 'Approve of ta/da';
        }else if($tadadata->approve_status==0) {
             $monthYearail->Subject = 'Disapprove of ta/da';
        }else if($tadadata->approve_status==2){
            $monthYearail->Subject = 'Request of ta/da';
        }
        
        $success2=$monthYearail->send();
        if ($success2) {
            //echo'ok';
            
        } else {
           echo 'Mailer error: ' . $monthYearail->ErrorInfo;  
        }
        /*    }     */
        redirect('hrm/travel_info', 'refresh');
    }

 public function worker_Work(){   
          
        $user_id= $_GET['user_id'];
        $where=''; 
         if( isset($_GET['start'])!='' && isset($_GET['end'])!='' && isset($_GET['user_id'])!= '')
        {   
            if($_GET['start']=='a' && $_GET['end']=='b' && isset($_GET['user_id'])!= ''){
            $where .= "worker_id LIKE '%{$user_id}%' AND MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE())";
            }
            else{ 
            $user_id=$_GET['user_id'];
            $start = date('Y-m-d 00:00:01',strtotime($_GET['start']));
            $end =date('Y-m-d 23:59:59',strtotime($_GET['end']));
            $where .= "worker_id LIKE '%{$user_id}%' AND created_date >= '{$start}' AND created_date <= '{$end}' ";
      }
    } 

       $this->data['workerdata']  = $this->hrm_model->get_worker_data('production_dataWages',$where);
       $this->data['workerid'] = $user_id ;
       $this->_render_template('worker_Work/index', $this->data);
    }


    public function monthly_salary_report(){
          
        $where=''; 
        
         if( isset($_GET['start']) && isset($_GET['end']) )
        {
         
            if ( $_GET['start'] != '' && $_GET['end'] != '')
        {
            $start = date('Y-m-d 00:00:01',strtotime($_GET['start']));
            $end =date('Y-m-d 23:59:59',strtotime($_GET['end']));
            $where .= "created_date >= '{$start}' AND created_date <= '{$end}' ";
         } 
        

     }elseif (isset($_GET["ExportType"]) != '' && isset($_GET['start']) == '' && isset($_GET['end']) == '' ) {
      
            $where .= "created_by_cid = $this->companyGroupId ";
         } else{
        $where= "MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE())"; 
    }
        $workerdata  = $this->hrm_model->get_worker_data('production_data',$where);
        $alluserdata=[];
       $workeriddata=[]; 
     foreach ($workerdata as $key => $value) {
                $con= " production_id='{$value['id']}'"; 
               $userproductiondata  = $this->hrm_model->get_worker_data('production_dataWages',$con);
               foreach ($userproductiondata as   $arryavalue) {
                 $workerid=json_decode($arryavalue['worker_id']);  
                if(!empty($workerid)){
                foreach ($workerid as $Wkey => $workervalue) {
                      $workeriddata[$workervalue]=$workervalue;  
                }
               }
               }
              }           
           foreach ($workeriddata as $unicvalue) {  
                      $user_id=$unicvalue;
                       $con= "worker_id LIKE '%{$user_id}%' AND MONTH(created_date) = MONTH(CURRENT_DATE()) AND YEAR(created_date) = YEAR(CURRENT_DATE())"; 
                      $userproductiondata  = $this->hrm_model->get_worker_data('production_dataWages',$con);
                      $alluserdata[$user_id]  = $userproductiondata;
                    
            }   
       if (isset($_GET['start'])) {
           $this->data['start']=$_GET['start'];
       }
         if (isset($_GET['end'])) {
          $this->data['end']=$_GET['end'];
       }
        
        $this->data['workerdata']=$alluserdata;
       $this->_render_template('worker_Work/view', $this->data);
    }
 //new AS
 public function worker_month_off(){
            
            $data= $_POST['worker_week_off'];
            $id=$_POST['id'];
             
                    $success = $this->hrm_model->worker_month_off($id,$data); 
                  if($success > 0){
                    $this->session->set_flashdata('message', 'Worker OT Salary Updated Successfully');
                  redirect('hrm/hrm_setting', 'refresh');    
                }
            }
  public function monthly_best_workers_reportsa(){   
          
        $user_id= $_GET['user_id'];
        $where=''; 
         if( isset($_GET['start'])!='' && isset($_GET['end'])!='' && isset($_GET['user_id'])!= '')
        {   
            if($_GET['start']=='a' && $_GET['end']=='b' && isset($_GET['user_id'])!= ''){
            $where .= "worker_id LIKE '%{$user_id}%' AND MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE())";
            }
            else{ 
            $user_id=$_GET['user_id'];
            $start = date('Y-m-d 00:00:01',strtotime($_GET['start']));
            $end =date('Y-m-d 23:59:59',strtotime($_GET['end']));
            $where .= "worker_id LIKE '%{$user_id}%' AND created_date >= '{$start}' AND created_date <= '{$end}' ";
      }
    } 

       $this->data['workerdata']  = $this->hrm_model->get_worker_data('production_dataWages',$where);
       $this->data['workerid'] = $user_id ;
       $this->_render_template('monthly_best_workers_report/index', $this->data);
    }


    public function monthly_best_workers_report(){
          
        $where=''; 
        
         if( isset($_GET['start']) && isset($_GET['end']) )
        {
         
            if ( $_GET['start'] != '' && $_GET['end'] != '')
        {
            $start = date('Y-m-d 00:00:01',strtotime($_GET['start']));
            $end =date('Y-m-d 23:59:59',strtotime($_GET['end']));
            $where .= "created_date >= '{$start}' AND created_date <= '{$end}' ";
         } 
        

     }elseif (isset($_GET["ExportType"]) != '' && isset($_GET['start']) == '' && isset($_GET['end']) == '' ) {
 
            $where .= "created_by_cid = $this->companyGroupId ";
         } else{
        $where= "MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE())"; 
    }
        $workerdata  = $this->hrm_model->get_worker_data('production_data',$where);
        $alluserdata=[];
       $workeriddata=[]; 
     foreach ($workerdata as $key => $value) {
                $con= " production_id='{$value['id']}'"; 
               $userproductiondata  = $this->hrm_model->get_worker_data('production_dataWages',$con);
               foreach ($userproductiondata as   $arryavalue) {
                 $workerid=json_decode($arryavalue['worker_id']);  
                if(!empty($workerid)){
                foreach ($workerid as $Wkey => $workervalue) {
                      $workeriddata[$workervalue]=$workervalue;  
                }
               }
               }
              }           
           foreach ($workeriddata as $unicvalue) {  
                      $user_id=$unicvalue;
                       $con= "worker_id LIKE '%{$user_id}%' AND MONTH(created_date) = MONTH(CURRENT_DATE()) AND YEAR(created_date) = YEAR(CURRENT_DATE())"; 
                      $userproductiondata  = $this->hrm_model->get_worker_data('production_dataWages',$con);
                      $alluserdata[$user_id]  = $userproductiondata;
                    
            }   
       if (isset($_GET['start'])) {
           $this->data['start']=$_GET['start'];
       }
         if (isset($_GET['end'])) {
          $this->data['end']=$_GET['end'];
       }
        
        $this->data['workerdata']=$alluserdata;
       $this->_render_template('monthly_best_workers_report/view', $this->data);
    }
    function onOffStatusUpdate(){
        $checked = 0;

        $setMsg = "Multi Approve Level";
        if( !empty($_POST['msg'] )){
            $setMsg = $_POST['msg'];
        }

         $monthYearsg = "OFF";
         if( $_POST['value'] && empty($_POST['msg']) ){
            $checked = 1;
            $monthYearsg = "ON";
            $setMsg = $setMsg." ".$monthYearsg;
        }
        $this->hrm_model->updateWhere($_POST['table'],[$_POST['column'] => $checked ],$_POST['where']);
        $this->session->set_flashdata('message',"{$setMsg}");
        echo json_encode(['refresh' => 'refresh']);
    }
    function updateSingleValue(){
        $value = 0;
        if( $_POST['value'] ){
            $value = $_POST['value'];
            $monthYearsg = "updated";
        }

        if( $_POST['column'] == 'hrm_multi_lever_approve' ){
            $poApproveDetail = getSingleAndWhere('hrm_multi_lever_approve',$_POST['table'],$_POST['where']);
            $userDetail = json_decode($poApproveDetail,true);
            if(  empty($value) || $value == 0 ){
                $this->hrm_model->updateWhere($_POST['table'],['hrm_multi_lever_approve' => '' ],$_POST['where']);
            }else{
                $newUserData = [];
                $j = 0;
                for ( $i=1; $i <= $value; $i++) {
                    if( isset($userDetail[$j]) ){
                        $newUserData[] = $userDetail[$j];
                        $j++;
                    }
                }
                $this->hrm_model->updateWhere($_POST['table'],['hrm_multi_lever_approve' => json_encode($newUserData) ],$_POST['where']);
            }
        }

        $this->hrm_model->updateWhere($_POST['table'],[$_POST['column'] => $value ],$_POST['where']);
        $this->session->set_flashdata('message',"HRM Multi Approve Level {$monthYearsg}");
        echo json_encode(['refresh' => 'refresh']);
    }
    function hrm_approve_user(){
        if( !empty($_POST['hrm_approve_users']) ){
            $poUser = json_encode($_POST['hrm_approve_users']);
            $this->hrm_model->updateWhere('company_detail',['hrm_approve_users' => $poUser ],['id' => $this->companyGroupId]);
            $this->session->set_flashdata('message',"HRM Multi approval update successfully");
            redirect('hrm/hrm_setting');
        }
    }
     public function importworker() {

        if (!empty($_FILES['uploadFile']['name']) != '') {
            $path = 'assets/modules/crm/uploads/';
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

                try {

                    $inputfiletype = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
                    $objReader->setReadDataOnly(true);//Get the area of data inserted
                    @$objPHPExcel = $objReader->load($inputFileName);
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestDataRow();
                    $highestColumn = $sheet->getHighestColumn();
                    // $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    // $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    // $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true, true);
                    $flag = true;
                    $i1 = 0;
                    $r = 0;
                        
                    foreach ($allDataInSheet as $value) {
                         if ($flag) {
                             $flag = false;
                            continue;
                        }
                           $total=!empty($value['X']) ? $value['X'] : '';
                           $basic= !empty($value['Y']) ? $value['Y'] : '';
                           $basicNewPre=((float)$basic/(float)$total)*100;
                           $da= !empty($value['AC']) ? $value['AC'] : '';
                           $daNewPre=((float)$da/(float)$total)*100;
                           $hra= !empty($value['Z']) ? $value['Z'] : '';
                           $hraNewPre=((float)$hra/(float)$total)*100;
                           $ca= !empty($value['AB']) ? $value['AB'] : '';
                           $caNewPre=((float)$ca/(float)$total)*100;
                           $sa= !empty($value['AA']) ? $value['AA'] : '';
                           $saNewPre=((float)$sa/(float)$total)*100;
                           $monthYearedical= !empty($value['AD']) ? $value['AD'] : '';
                           $monthYearedicalNewPre=((float)$monthYearedical/(float)$total)*100;
                           $others= !empty($value['AE']) ? $value['AE'] : '';
                           $othersNewPre=((float)$others/(float)$total)*100;
                           $esic= !empty($value['AF']) ? $value['AF'] : '';
                           $esicNewPre=((float)$esic/(float)$total)*100;
                           $tds= !empty($value['AG']) ? $value['AG'] : '';
                           $tdsNewPre=((float)$tds/(float)$total)*100;
                           $pf= !empty($value['AH']) ? $value['AH'] : '';
                           $pfNewPre=((float)$pf/(float)$basic)*100;
                           $lwf= !empty($value['AI']) ? $value['AI'] : '';
                           //$lwfNewPre=((float)$lwf/(float)$total)*100;
                           $esic_employer= !empty($value['AJ']) ? $value['AJ'] : '';
                           $esic_employerNewPre=((float)$esic_employer/(float)$total)*100;
                           $pf_employer= !empty($value['AK']) ? $value['AK'] : '';
                           $pf_employerNewPre=((float)$pf_employer/(float)$basic)*100;
                           $lwf_employer= !empty($value['AL']) ? $value['AL'] : '';
                           //$lwf_employerNewPre=((float)$lwf_employer/(float)$total)*100;
            
                $slabData = (array(
                         'basic' =>$basicNewPre,
                         'da' =>$daNewPre,
                         'hra' =>$hraNewPre,
                         'ca' =>$caNewPre,
                         'sa' =>$saNewPre,
                         'medical' =>$monthYearedicalNewPre,
                         'others' =>$othersNewPre,
                         'esic' =>$esicNewPre,
                         'tds' =>$tdsNewPre,
                         'pf' =>$pfNewPre,
                         'lwf' =>$lwf,
                         'esic_employer' =>$esic_employerNewPre,
                         'pf_employer' =>$pf_employerNewPre,
                         'lwf_employer' =>$lwf_employer));

                   $slabDataInJson=json_encode($slabData);  
                           $birthDATE = ((float)$value['H'] - 25569) * 86400;
                           $birthday= gmdate("Y-m-d", $birthDATE);
                           $joingdatedd = ((float)$value['N'] - 25569) * 86400;
                           $joingdateddaa= gmdate("Y-m-d", $joingdatedd);
                            if(!empty($value['B']) || !empty($value['C']) || !empty($value['D']) || !empty($value['E'])){
                            $insertdata[$i1]['biomatricid'] = !empty($value['A']) ? $value['A'] : '';  
                            $insertdata[$i1]['name'] = !empty($value['B']) ? $value['B'] : '';
                            $insertdata[$i1]['mobile_number'] = !empty($value['C']) ? $value['C'] : '';
                            $insertdata[$i1]['fathername'] = !empty($value['D']) ? $value['D'] : '';
                            $insertdata[$i1]['department'] = !empty($value['E']) ? $value['E'] : '';
                            $insertdata[$i1]['worker_type'] = !empty($value['F']) ? $value['F'] : '';
                            $insertdata[$i1]['designation'] = !empty($value['G']) ? $value['G'] : ''; 
                            $insertdata[$i1]['designation'] = !empty($value['H']) ? $value['H'] : ''; 
                            $insertdata[$i1]['education'] = !empty($value['I']) ? $value['I'] : '';
                            $insertdata[$i1]['plantLocation'] = !empty($value['J']) ? $value['J'] : '';
                            $insertdata[$i1]['address'] = !empty($value['K']) ? $value['K'] : ''; 
                            $insertdata[$i1]['address'] = !empty($value['L']) ? $value['L'] : '';
                            $insertdata[$i1]['address'] = !empty($value['M']) ? $value['M'] : '';
                            $insertdata[$i1]['address'] = !empty($value['N']) ? $value['N'] : '';
                            $insertdata[$i1]['adharNo'] = !empty($value['O']) ? $value['O'] : '';
                            $insertdata[$i1]['panNo'] = !empty($value['P']) ? $value['P'] : '';
                            $insertdata[$i1]['account_no'] = !empty($value['Q']) ? $value['Q'] : '';
                            $insertdata[$i1]['ifsc_code'] = !empty($value['R']) ? $value['R'] : '';
                            $insertdata[$i1]['branch_name'] = !empty($value['T']) ? $value['T'] : '';
                            $insertdata[$i1]['uan_no'] = !empty($value['U']) ? $value['U'] : ''; 
                            $insertdata[$i1]['esic_no'] = !empty($value['V']) ? $value['V'] : '';  
                            $insertdata[$i1]['working_hrs'] = !empty($value['W']) ? $value['W'] : ''; 
                            $insertdata[$i1]['salary'] = !empty($value['X']) ? $value['X'] : '';
                            $insertdata[$i1]['workerSlabData'] = $slabDataInJson; 
                            $insertdata[$i1]['country'] = 101; 
                            $insertdata[$i1]['created_by'] = $_SESSION['loggedInUser']->u_id;
                            $insertdata[$i1]['created_by_cid'] = $this->companyGroupId;
                            $insertdata[$i1]['salarySlab'] = !empty($value['AB']) ? $value['AB'] : ''; 
                            $insertdata[$i1]['active_inactive'] = 1; 
                           
                            #pre($insertdata[$i]['contacts'])    ;
                            $i1++;
                        }
                    }
               // worker 
                   unset($insertdata[0]);  
                // pre($insertdata); die;
                    $result = $this->hrm_model->importworker($insertdata);
                    if ($result) {
                          // echo "Imported successfully";
                         

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
           # die;
            $this->session->set_flashdata('message', 'Worker Imported Successfully');
             redirect(base_url() . 'hrm/workers', 'refresh');
        }
        echo "<script>alert('Please Select the File to Upload')</script>";
         redirect(base_url() . 'hrm/workers', 'refresh');
    }
     function getExplodeTime($time){
     	$addSimbaleTotime = substr_replace($time, '~', 5, 1);
        $dateTo = explode('~', $addSimbaleTotime);
        return $dateTo;
     }
    public function importAttendanceEmployee() {
    	              
    	 if (!empty($_FILES['uploadFile']['name']) != '') {
            $path = 'assets/modules/crm/uploads/';
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
                try {

                    $inputfiletype = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
                    $objReader->setReadDataOnly(true);//Get the area of data inserted
                    @$objPHPExcel = $objReader->load($inputFileName);
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestDataRow();
                    $highestColumn = $sheet->getHighestColumn();
                    // $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    // $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    // $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true, true);
                    $flag = true;
                    $i1 = 0;
                    $r = 0;
                    #pre($allDataInSheet);
                    #die;
                    foreach ($allDataInSheet as $value) {
                         if ($flag) {
                             $flag = false;
                            continue;
                        } 
                        $start_date=$this->input->post('attenDateStart');
                        $end_date=$this->input->post('attenDateEnd');
                            if(!empty($value['B']) || !empty($value['C']) || !empty($value['D']) || !empty($value['E'])){
                            $insertdata[$i1]['biometric_id'] = !empty($value['A']) ? $value['A'] : '';  
                            $insertdata[$i1]['from_date'] = $start_date;  
                            $insertdata[$i1]['to_date'] = $end_date;  
                            $insertdata[$i1]['D1'] = !empty($value['B']) ? $value['B'] : '';
                            $insertdata[$i1]['D2'] = !empty($value['C']) ? $value['C'] : '';
                            $insertdata[$i1]['D3'] = !empty($value['D']) ? $value['D'] : '';
                            $insertdata[$i1]['D4'] = !empty($value['E']) ? $value['E'] : '';
                            $insertdata[$i1]['D5'] = !empty($value['F']) ? $value['F'] : '';
                            $insertdata[$i1]['D6'] = !empty($value['G']) ? $value['G'] : '';
                            $insertdata[$i1]['D7'] = !empty($value['H']) ? $value['H'] : '';
                            $insertdata[$i1]['D8'] = !empty($value['I']) ? $value['I'] : '';
                            $insertdata[$i1]['D9'] = !empty($value['J']) ? $value['J'] : '';
                            $insertdata[$i1]['D10'] = !empty($value['K']) ? $value['K'] : '';
                            $insertdata[$i1]['D11'] = !empty($value['L']) ? $value['L'] : '';
                            $insertdata[$i1]['D12'] = !empty($value['M']) ? $value['M'] : '';
                            $insertdata[$i1]['D13'] = !empty($value['N']) ? $value['N'] : '';
                            $insertdata[$i1]['D14'] = !empty($value['O']) ? $value['O'] : '';
                            $insertdata[$i1]['D15'] = !empty($value['P']) ? $value['P'] : '';
                            $insertdata[$i1]['D16'] = !empty($value['Q']) ? $value['Q'] : '';
                            $insertdata[$i1]['D17'] = !empty($value['R']) ? $value['R'] : '';
                            $insertdata[$i1]['D18'] = !empty($value['S']) ? $value['S'] : '';
                            $insertdata[$i1]['D19'] = !empty($value['T']) ? $value['T'] : '';
                            $insertdata[$i1]['D20'] = !empty($value['U']) ? $value['U'] : ''; 
                            $insertdata[$i1]['D21'] = !empty($value['V']) ? $value['V'] : '';  
                            $insertdata[$i1]['D22'] = !empty($value['W']) ? $value['W'] : ''; 
                            $insertdata[$i1]['D23'] = !empty($value['X']) ? $value['X'] : '';
                            $insertdata[$i1]['D24'] = !empty($value['Y']) ? $value['Y'] : '';
                            $insertdata[$i1]['D25'] = !empty($value['Z']) ? $value['Z'] : '';
                            $insertdata[$i1]['D26'] = !empty($value['AA']) ? $value['AA'] : '';
                            $insertdata[$i1]['D27'] = !empty($value['AB']) ? $value['AB'] : '';
                            $insertdata[$i1]['D28'] = !empty($value['AC']) ? $value['AC'] : '';
                            $insertdata[$i1]['D29'] = !empty($value['AD']) ? $value['AD'] : '';
                            $insertdata[$i1]['D30'] = !empty($value['AE']) ? $value['AE'] : '';
                            $insertdata[$i1]['D31'] = !empty($value['AF']) ? $value['AF'] : '';
                            $insertdata[$i1]['created_by'] = $_SESSION['loggedInUser']->u_id;
                            $insertdata[$i1]['created_by_cid'] = $this->companyGroupId;
                            $i1++;
                        }
                    }    
                    $result = $this->hrm_model->attendance_Excel_dummys($insertdata);
                    if ($result) {
                        $start_date12=$this->input->post('attenDateStart');
                        $end_date12=$this->input->post('attenDateEnd');
                        $monthYear= date('Y-m',strtotime($start_date12)); 
                    	$whereCer = " from_date >= '{$start_date12}' AND to_date <= '{$end_date12}' AND created_by_cid='{$this->companyGroupId}'";
                    	$empDataAtt  = $this->hrm_model->get_worker_data('attendance_Excel_dummy',$whereCer);
                    	$employee=[];
                    	 foreach ($empDataAtt as $key => $empDataAttValue) {  
                    		          $employeeAtt = array(
                    		    	                $monthYear.'-01' => $this->getExplodeTime($empDataAttValue['D1']),
                    		                        $monthYear.'-02' =>$this->getExplodeTime($empDataAttValue['D2']),
									    		    $monthYear.'-03' =>$this->getExplodeTime($empDataAttValue['D3']), 
									    		    $monthYear.'-04' =>$this->getExplodeTime($empDataAttValue['D4']),
									    		    $monthYear.'-05' =>$this->getExplodeTime($empDataAttValue['D5']),
									    		    $monthYear.'-06' =>$this->getExplodeTime($empDataAttValue['D6']),
									    		    $monthYear.'-07' =>$this->getExplodeTime($empDataAttValue['D7']),
									    		    $monthYear.'-08' =>$this->getExplodeTime($empDataAttValue['D8']),
									    		    $monthYear.'-09' =>$this->getExplodeTime($empDataAttValue['D9']),
									    		    $monthYear.'-10' =>$this->getExplodeTime($empDataAttValue['D10']),
									    		    $monthYear.'-11' =>$this->getExplodeTime($empDataAttValue['D11']),
									    		    $monthYear.'-12' =>$this->getExplodeTime($empDataAttValue['D12']),
									    		    $monthYear.'-13' =>$this->getExplodeTime($empDataAttValue['D13']),
									    		    $monthYear.'-14' =>$this->getExplodeTime($empDataAttValue['D14']),
									    		    $monthYear.'-15' =>$this->getExplodeTime($empDataAttValue['D15']),
									    		    $monthYear.'-16' =>$this->getExplodeTime($empDataAttValue['D16']),
									    		    $monthYear.'-17' =>$this->getExplodeTime($empDataAttValue['D17']),
									    		    $monthYear.'-18' =>$this->getExplodeTime($empDataAttValue['D18']),
									    		    $monthYear.'-19' =>$this->getExplodeTime($empDataAttValue['D19']),
									    		    $monthYear.'-20' =>$this->getExplodeTime($empDataAttValue['D20']),
									    		    $monthYear.'-21' =>$this->getExplodeTime($empDataAttValue['D21']),
									    		    $monthYear.'-22' =>$this->getExplodeTime($empDataAttValue['D22']),
									    		    $monthYear.'-23' =>$this->getExplodeTime($empDataAttValue['D23']),
									    		    $monthYear.'-24' =>$this->getExplodeTime($empDataAttValue['D24']),
									    		    $monthYear.'-25' =>$this->getExplodeTime($empDataAttValue['D25']),
									    		    $monthYear.'-26' =>$this->getExplodeTime($empDataAttValue['D26']),
									    		    $monthYear.'-27' =>$this->getExplodeTime($empDataAttValue['D27']),
									    		    $monthYear.'-28' =>$this->getExplodeTime($empDataAttValue['D28']),
									    		    $monthYear.'-29' =>$this->getExplodeTime($empDataAttValue['D29']),
									    		    $monthYear.'-30' =>$this->getExplodeTime($empDataAttValue['D30']),
									    		    $monthYear.'-31' =>$this->getExplodeTime($empDataAttValue['D31'])
                                             );
                    		   $employee[$empDataAttValue['biometric_id']]=$employeeAtt;
                     }
            foreach ($employee as $userBiomaxId => $userValue) {
               foreach ($userValue as $dateInKey => $dateValue) {
               	$activityUserData = getNameById('user_detail', $userBiomaxId, 'biometric_id');
				if($dateValue[0] == 'A' || $dateValue[0] == 'WO-I'){
				$status = "A";
				$signin_time = $signout_time = "00:00";
				} elseif(($dateValue[0] == '' && $dateValue[1] == '') || ($dateValue[0] == 'NA' || $dateValue[1] == 'NA')){
				$signin_time = $signout_time = "00:00";
				$status = "A";
				} elseif($dateValue[1] == ''){
				$signout_time = "00:00";
				$status = "A";
				} else {
				$status = "P";
				$signin_time = $dateValue[0];
				$signout_time = $dateValue[1];
				} 
               		             $data12['emp_id']= $activityUserData->u_id??'';
                                 $data12['biometric_id']=$userBiomaxId;
                                 $data12['atten_date']=$dateInKey;
                                 $data12['signin_time']=$signin_time;
                                 $data12['signout_time']=$signout_time;
                                 $data12['place']='office';
                                 $data12['status']=$status; 
                                 $data12['created_by_cid'] = $this->companyGroupId;
                                 $data12['created_by'] = $_SESSION['loggedInUser']->u_id;
                                 $singTime = new DateTime($signin_time);
                                 $souTime = new DateTime($signout_time);
                                 $hournew = $singTime->diff($souTime);
                                 $work12 = $hournew->format('%H h %i m'); 
                                 $data12['working_hour'] = $work12; 
               	                 $id12=$this->hrm_model->Add_AttendanceData($data12);
                                  
                
                     }
                   } 
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
            $this->session->set_flashdata('message', 'Worker Imported Successfully');
              redirect(base_url() . 'hrm/Attendance', 'refresh');
        }
        echo "<script>alert('Please Select the File to Upload')</script>";
          redirect(base_url() . 'hrm/Attendance', 'refresh');
    }
   

    public function employeeSalarySlab(){
       $where=''; 
    if( isset($_GET['start']) && isset($_GET['end']) ){
           if ( $_GET['start'] != '' && $_GET['end'] != ''){
            $start = date('Y-m-d 00:00:01',strtotime($_GET['start']));
            $end =date('Y-m-d 23:59:59',strtotime($_GET['end']));
            $where .= "created_date >= '{$start}' AND created_date <= '{$end}' ";
         } 
     }elseif (isset($_GET["ExportType"]) != '' && isset($_GET['start']) == '' && isset($_GET['end']) == '' ) {
       $where .= "created_by_cid = $this->companyGroupId ";
         } else{
         $where= "MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE())"; 
     }
        $employeeData  = $this->hrm_model->get_worker_data('attendance',$where);
        $empDataID=[];
       foreach ($employeeData as $empkey => $empDatavalue) {
        
         if ($empDatavalue['status']=='P') {
                $empDataID[$empDatavalue['emp_id']][]=$empDatavalue;
        }
      }
    
       if (isset($_GET['start'])) {
           $this->data['start']=$_GET['start'];
       }
         if (isset($_GET['end'])) {
          $this->data['end']=$_GET['end'];
       }
        
        $this->data['workerdata']=$alluserdata;
       $this->_render_template('payroll/index2', $this->data);
    }
    public function worker_process_payroll(){

        $this->data['date'] = $this->session->userdata('start_end_date_summary');
        $this->session->unset_userdata('find_attendance');
        $this->data['c_id'] = $this->companyGroupId;
        $this->breadcrumb->add('HRM', base_url() . 'hrm/users');
        $this->breadcrumb->add('Worker Process Payroll ', base_url() . 'hrm/summaryreport');
        $this->settings['breadcrumbs'] = $this->breadcrumb->output();
        $this->settings['pageTitle'] = 'Worker Process Payroll';
        $this->data['users'] = $this->hrm_model->get_user_data($this->companyGroupId);
        #  pre($this->data['users']);die;
        if(!empty($this->input->post('month'))){
        $where2='';
        $day = '1';
        $monthYearonth = $this->input->post('month');
        $year = date('Y');
        $dt = $year . '-' . $monthYearonth . '-' . $day; 
         $start_end_date_summary = array('start_date' => date("Y-m-01", strtotime($dt)), 'end_date' => date("Y-m-t", strtotime($dt))); 
        $start_date = date("Y-m-01", strtotime($dt));
        $end_date = date("Y-m-t", strtotime($dt));
        $work_days = date("t", strtotime($end_date)); 
        $where = 'AND created_by_cid = ' . $this->companyGroupId;
        $holidays = $this->hrm_model->GetAllHoliInfoEmp($this->companyGroupId, $start_date, $end_date);
        $week_off_emp = $this->hrm_model->GetWeekOffworker($this->companyGroupId); 
        $get_leaveorabsent = $this->hrm_model->GetleaveStatusEmpGroup($this->companyGroupId, $start_date, $end_date); 
      //  $get_attendance_p_a = $this->hrm_model->GetAttendanceStatusEmpGroup($start_date, $end_date); 
        if( isset($start_date) && isset($end_date) ){
           if ( $start_date != '' && $end_date != ''){
            $start = $start_date;
            $end =$end_date;
           $where2 .= "atten_date >= '{$start}' AND atten_date <= '{$end}' ";
          } 
        }
        $employeeData  = $this->hrm_model->get_worker_data('worker_attendance',$where2);
        $empDataID=[];
            foreach ($employeeData as $empkey => $empDatavalue) {
            
             if ($empDatavalue['status']=='P') {
                    $empDataID[$empDatavalue['emp_id']][]=$empDatavalue;
            }
          } 
        if (isset($holiday->from_date) && isset($holiday->to_date)) {
            $start_end_holiday = array('startDate_holiday' => $holiday->from_date, 'endDate_holiday' => $holiday->to_date);
        }  
        $this->data['work_days'] = $work_days;
        $this->data['get_leaveorabsent'] = $get_leaveorabsent;
        $this->data['get_attendance_p_a'] = $empDataID;
        $this->data['week_off_emp'] = $week_off_emp;
         $this->data['holidays'] = $holidays;
        $this->data['start_end_date_summary'] = $start_end_date_summary;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->_render_template('workerpayroll/index', $this->data); 
     }else{
        $this->_render_template('workerpayroll/index', $this->data);
     }
    }
     public function workerSalarySlab() {    
        $this->data['allData']=$this->input->post();
          $this->load->view('workerpayroll/view', $this->data);
    }
      public function workerDetails() {    
        $id=$_POST['id'];
        $start=$_POST['start'];
        $end=$_POST['end'];
        $where = "emp_id = '{$id}' AND atten_date >= '{$start}' AND atten_date <= '{$end}'";  
        $empleaveData  = $this->hrm_model->get_worker_data('worker_attendance',$where);
        $this->data['attendancelist'] = $empleaveData; 
        $this->data['startDate'] = $start; 
        $this->data['endDate'] = $end; 
        $this->load->view('workerpayroll/workerview', $this->data);
    }
       public function empDetails() {    
        $id=$_POST['id'];
        $start=$_POST['start'];
        $end=$_POST['end'];
        $where = "emp_id = '{$id}' AND atten_date >= '{$start}' AND atten_date <= '{$end}'";  
        $empleaveData  = $this->hrm_model->get_worker_data('attendance',$where);
        $this->data['attendancelist'] = $empleaveData; 
        $this->data['startDate'] = $start; 
        $this->data['endDate'] = $end; 
        $this->load->view('payroll/empviewAtt', $this->data);
    }
    public function checkAadharNo(){
           $aadhar = $this->input->post('aadhar'); 
           $where= "adharNo = '{$aadhar}'";   
           $employeeData  = $this->hrm_model->get_worker_data('worker',$where);
           if($employeeData){
            echo '1';
           }else{
            echo '2';
           }
    }
     public function checkPanNo(){
           $panNo = $this->input->post('panNo'); 
              $where= "`panNo` = '{$panNo}'";   
           // $where= "`panNo` = '0AFVHGF6'";  
           $employeeData  = $this->hrm_model->get_worker_data('worker',$where);
           if($employeeData){
            echo '1';
           }else{
            echo '2';
           }
    }
      public function workermonthalyslab(){ //workermonthalislab
       
            $dataSlab = array(
                 'basic' => $this->input->post('basic'),
                 'da' => $this->input->post('da'),
                 'hra' => $this->input->post('hra'),
                 'ca' => $this->input->post('ca'),
                 'sa' => $this->input->post('sa'),
                 'medical' => $this->input->post('medical'),
                 'others' => $this->input->post('others'),
                 'employee_esi' => $this->input->post('employee_esi'),
                 'employee_pf' => $this->input->post('employee_pf'),
                 'employee_tds' => $this->input->post('employee_tds'),
                 'employee_lwf' => $this->input->post('employee_lwf'),
                 'netpay' => $this->input->post('netpay'),
                 'employer_esi' => $this->input->post('employer_esi'),
                 'employer_pf' => $this->input->post('employer_pf'),
                 'employer_lwf' => $this->input->post('employer_lwf'),
                 'employerdeduction' => $this->input->post('employerdeduction') 
               );
       $data=$this->input->post();
       $data['slabinfo']=json_encode($dataSlab);
       $data['created_by_cid'] = $this->companyGroupId;
       $data['created_by'] = $_SESSION['loggedInUser']->u_id;
       $id=$this->hrm_model->insert_tbl_data('workermonthalislab', $data);
       if ($id) {
             $this->session->set_flashdata('message', 'Worker Salary Add Successfully');
             redirect(base_url() . 'hrm/worker_process_payroll', 'refresh');
       }

    }
   public function workerSalarySlabNormal() {    
        $this->data['allData']=$this->input->post();
          $this->load->view('workerpayroll/viewworkernormalslab', $this->data);
    }
   public function employeeShiftChange() {    
       $workerids=$_POST['checkboxEmp'];
       $company_unit=$this->input->post('company_unit');
       $department_id=$this->input->post('department_id');
       $shift_id=$this->input->post('shift_id');
       $shiftChangeDate=$this->input->post('shiftChangeStartDate');
       $employeeShiftEndDate=$this->input->post('employeeShiftEndDate');
       $id='';
       foreach ($workerids as   $workerIdInsert) {
       $data['company_unit']=$company_unit;
       $data['department_id']=$department_id;
       $data['shift_id']=$shift_id;
       $data['employeeId']=$workerIdInsert;
       $data['shiftChangeStartDate']=$shiftChangeDate;
       $data['employeeShiftEndDate']=$employeeShiftEndDate;
       $data['created_by_cid'] = $this->companyGroupId;
       $data['created_by'] = $_SESSION['loggedInUser']->u_id;
       $id=$this->hrm_model->insert_tbl_data('employshiftChange', $data);
       }  
       if ($id) {
             $this->session->set_flashdata('message', 'Employee Shift Changed Successfully');
             redirect(base_url() . 'hrm/hrm_setting', 'refresh');
       }
    }   
  public function workerShiftChange() {  
       $workerids=$_POST['checkboxEmp'];
       $company_unit=$this->input->post('company_unit');
       $department_id=$this->input->post('department_id');
       $shift_id=$this->input->post('shift_id');
       $shiftChangeDate=$this->input->post('shiftChangeStartDate');
       $employeeShiftEndDate=$this->input->post('employeeShiftEndDate');
       $id=''; 
       foreach ($workerids as   $workerIdInsert){ 
       $data['company_unit']=$company_unit;
       $data['department_id']=$department_id;
       $data['shift_id']=$shift_id;
       $data['employeeId']=$workerIdInsert;
       $data['employeeShiftEndDate']=$employeeShiftEndDate;
       $data['shiftChangeStartDate']=$shiftChangeDate;
       $data['created_by_cid'] = $this->companyGroupId;
       $data['created_by'] = $_SESSION['loggedInUser']->u_id;
       $id=$this->hrm_model->insert_tbl_data('workershiftChange', $data);
       }   
       if ($id){
             $this->session->set_flashdata('message', 'Worker Shift Changed Successfully');
             redirect(base_url() . 'hrm/hrm_setting', 'refresh');
       }
    }  
     
  function attendanceBiometric(){ 
        $db2 = $this->load->database('db2', TRUE);
        $db2->select('*');  
        $db2->from('dbo.EmpDetails'); 
        // $db2->where('Employee_id',18);
        $db2->order_by('id','desc'); 
        $db2->limit('10000'); 
        $query = $db2->get(); 
        $result = $query->result_array(); 
         if ($result) {  
             $employee=[];
             $employees=[];
             foreach ($result as $key => $empAttValue) {  
                  $employees[$empAttValue['Employee_id']]=$empAttValue['Employee_id'];
                  $employee[$empAttValue['Employee_id']][$key]= array(
                   'date'=> $empAttValue['Date'],
                   'time' => $empAttValue['Time']
                    ); 
                
        }  
          $finArray = [];
         foreach ($employee as $key1 => $valueIF) {
             foreach ($valueIF as $key12 => $valueIF1) {
               if($valueIF1['date'] == $valueIF[$key12]['date']){
                $finArray[$key1][$valueIF1['date']][] = $valueIF[$key12]['time'];
                
               } 
          } 
         }  
         foreach ($finArray as $userBiomaxId => $userValue) {
              foreach ($userValue as $dateInKey => $dateValue) {
                        $where12 = "biomatricid = '{$userBiomaxId}'";  
                       $empDataAtt2  = $this->hrm_model->get_worker_data('worker',$where12);
                       if ($empDataAtt2[0]['biomatricid']==$userBiomaxId) {
                                $where1 = "biometric_id = '{$userBiomaxId}' AND atten_date = '{$dateInKey}'";  
                                $workerDataAtt  = $this->hrm_model->get_worker_data('worker_attendance',$where1);
                                $activityWorker = getNameById('worker', $userBiomaxId, 'biomatricid');

                          if ($workerDataAtt) {
                                 $data1['emp_id']= $activityWorker->id;
                                 $data1['biometric_id']=$userBiomaxId;
                                 $data1['atten_date']=$dateInKey;
                                 $data1['signin_time']=$dateValue[1];
                                 $data1['signout_time']=$dateValue[0];
                                 $data1['place']='office';
                                 $data1['status']='P';
                                 $data1['created_by_cid'] = $this->companyGroupId;
                                 $data1['created_by'] = $_SESSION['loggedInUser']->u_id; 
                                 $singTime13 = new DateTime($dateValue[1]);
                                 $souTime13 = new DateTime($dateValue[0]);
                                 $hournew13 = $singTime13->diff($souTime13);
                                 $work16 = $hournew13->format('%H h %i m'); 
                                 $data1['working_hour'] = $work16; 
                                 $where2 = array('biometric_id' => $userBiomaxId,'atten_date' => $dateInKey);
                                  $successWorker = $this->hrm_model->updateAttendanceWorker($where2,$data1);
                                   if ($successWorker) {
                                     $this->session->set_flashdata('message', 'Data Successfully');
                                       redirect(base_url() . 'hrm/worker_process_payroll', 'refresh');
                                 }
                             }else{   
                                 $data2['emp_id']= $activityWorker->id;
                                 $data2['biometric_id']=$userBiomaxId;
                                 $data2['atten_date']=$dateInKey;
                                 $data2['signin_time']=$dateValue[1];
                                 $data2['signout_time']=$dateValue[0];
                                 $data2['place']='office';
                                 $data2['status']='P'; 
                                 $data2['created_by_cid'] = $this->companyGroupId;
                                 $data2['created_by'] = $_SESSION['loggedInUser']->u_id;
                                 $singTime12 = new DateTime($dateValue[1]);
                                 $souTime12 = new DateTime($dateValue[0]);
                                 $hournew12 = $singTime12->diff($souTime12);
                                 $work15 = $hournew12->format('%H h %i m'); 
                                 $data2['working_hour'] = $work15;
                                
                                 $idWorker=$this->hrm_model->Add_AttendanceDataWorker($data2);
                                 if ($idWorker) {
                                    $this->session->set_flashdata('message', 'Data Successfully');
                                     redirect(base_url() . 'hrm/worker_process_payroll', 'refresh');
                                 }
                            }

                         }elseif($empDataAtt2[0]['biomatricid']!=$userBiomaxId){
                                $where1 = "biometric_id = '{$userBiomaxId}' AND atten_date = '{$dateInKey}'";  
                                $empDataAtt  = $this->hrm_model->get_worker_data('attendance',$where1);
                                $activityUserData = getNameById('user_detail', $userBiomaxId, 'biometric_id');
                          if ($empDataAtt) {
                                 $data3['emp_id']= $activityUserData->u_id;
                                 $data3['biometric_id']=$userBiomaxId;
                                 $data3['atten_date']=$dateInKey;
                                 $data3['signin_time']=$dateValue[1];
                                 $data3['signout_time']=$dateValue[0];
                                 $data3['place']='office';
                                 $data3['status']='P';
                                 $data3['created_by_cid'] = $this->companyGroupId;
                                 $data3['created_by'] = $_SESSION['loggedInUser']->u_id; 
                                 $singTime1 = new DateTime($dateValue[1]);
                                 $souTime1 = new DateTime($dateValue[0]);
                                 $hournew1 = $singTime1->diff($souTime1);
                                 $work13 = $hournew1->format('%H h %i m'); 
                                 $data3['working_hour'] = $work13; 
                                 $where3 = array('biometric_id' => $userBiomaxId,'atten_date' => $dateInKey);
                                 $successEmp = $this->hrm_model->updateAttendanceData($where3,$data3);
                                 if ($successEmp) {
                                    $this->session->set_flashdata('message', 'Data Successfully');
                                     redirect(base_url() . 'hrm/worker_process_payroll', 'refresh');
                                 }
                             }else{   
                                 $data4['emp_id']= $activityUserData->u_id;
                                 $data4['biometric_id']=$userBiomaxId;
                                 $data4['atten_date']=$dateInKey;
                                 $data4['signin_time']=$dateValue[1];
                                 $data4['signout_time']=$dateValue[0];
                                 $data4['place']='office';
                                 $data4['status']='P'; 
                                 $data4['created_by_cid'] = $this->companyGroupId;
                                 $data4['created_by'] = $_SESSION['loggedInUser']->u_id;
                                 $singTime = new DateTime($dateValue[1]);
                                 $souTime = new DateTime($dateValue[0]);
                                 $hournew = $singTime->diff($souTime);
                                 $work12 = $hournew->format('%H h %i m'); 
                                 $data4['working_hour'] = $work12;
                                 $idEmp=$this->hrm_model->Add_AttendanceData($data4);
                                 if ($idEmp) {
                                    $this->session->set_flashdata('message', 'Data Successfully');
                                     redirect(base_url() . 'hrm/worker_process_payroll', 'refresh');
                                 }
                      }
                   }
                   
              }
         }
     } 
 }   
 
      
/*Update New function for Pipeline*/
	public function update_workers_data(){
		$data=array('suervisorID'=>$_POST['target_id']);
		$this->hrm_model->updateData('worker', $data, 'id', $_POST['id']);
	}
	
	
	public function get_transition_assignee(){
        $col_id=$_POST['target_id'];
        $pipeline_id=$_POST['source_id'];
        $where=['created_by_cid' => $this->companyGroupId ,'pipeline_id'=>$pipeline_id,'col_id'=>$col_id];
        $assignee_id = $this->hrm_model->get_assignee_id('transition_authority',$where);
		
		// pre($where);
		// pre($assignee_id);
		
		// die('df');
        if($assignee_id==""){
        	echo 2;
        }else{echo $assignee_id;}
    }
	
	
	
	
	
/*Update New function for Pipeline*/























}//main