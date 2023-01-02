<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends ERP_Controller {
    public function __construct() {
        parent::__construct();
		is_login();
        $this->load->library(array('form_validation','email'));
		$this->load->helper('users/user');
        $this->load->model('users_model');		
		$this->settings['css'][] = 'assets/plugins/bootstrap-datepicker/datepicker.css';
		$this->settings['css'][] = 'assets/plugins/switchery/dist/switchery.min.css';
		$this->scripts['js'][] = 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->scripts['js'][] = 'assets/plugins/switchery/dist/switchery.min.js';
		$this->scripts['js'][] = 'assets/plugins/raphael/raphael.min.js';
		$this->scripts['js'][] = 'assets/plugins/morris.js/morris.min.js';
		#$this->scripts['js'][] = 'assets/modules/users/js/croppe.js';		
		#$this->scripts['js'][] = 'assets/plugins/Croppie-master/croppie.js';		
		$this->scripts['js'][] = 'assets/modules/users/js/script.js';
		#$this->scripts['js'][] = 'assets/modules/users/js/script.js';		
		#$this->scripts['css'][] = 'assets/plugins/Croppie-master/croppie.css';		
		$this->settings['css'][] = 'assets/modules/users/css/style1.css';
    }
	
    /* Main Function to fetch all the listing of users */
    public function index() {
		#$this->data['users']  = $this->users_model->get_data('user',array('user.c_id' => $_SESSION['loggedInUser']->c_id , 'user.role' => 2));
		#$this->data['users']  = $this->users_model->get_data('user',array('user.c_id' => $_SESSION['loggedInUser']->c_id));
		$this->data['users']  = $this->users_model->get_data('user',array('user.c_id' => $_SESSION['loggedInUser']->c_id , 'user.role' => 2, 'user.status' => 1));
		$this->data['inactive_user']  = $this->users_model->get_data('user',array('user.c_id' => $_SESSION['loggedInUser']->c_id , 'user.role' => 2, 'user.status' => 0));
		
        $this->breadcrumb->add('Users', base_url() . 'users/index');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'Users';
		$this->data['country'] = $this->users_model->fetch_country();
		$this->_render_template('index', $this->data);
    }
	
	public function add(){	
		$this->breadcrumb->add('Users', base_url() . 'users');
		$this->breadcrumb->add('Add', base_url() . 'users/add');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'User Add';
		$this->data['users']  = $this->users_model->get_data('user');
		$this->_render_template('add', $this->data);
	}
	
	public function edit($id = ''){	
		$this->breadcrumb->add('Users', base_url() . 'users');
		$this->breadcrumb->add('Edit', base_url() . 'users/edit');
		$this->settings['breadcrumbs'] = $this->breadcrumb->output();
		$this->settings['pageTitle'] = 'User Edit';
		$parentModules  = $this->users_model->get_data('modules');
		$permissionsArray = array();
		$i = 0;
		foreach($parentModules as $parentModule){
			$permissionsArray[$i] = $parentModule;
			$sub_modules  = $this->users_model->get_data('sub_module',array('modules_id' => $parentModule['id']));
			$permissionsArray[$i]['sub_module'] = $sub_modules;
			$y = 0;
			foreach($sub_modules  as $sub_module){			
				$permissions = $this->users_model->fetch_user_premissions_by_id($id , array('p.sub_module_id' => $sub_module['id'] , 'p.user_id' => $id));
				$permissionsArray[$i]['sub_module'][$y]['permissions'] = $permissions;
				$y++;
			}
			$i++;
		}
		
		$this->data['permissionsArray'] = $permissionsArray;
		$this->data['user'] = $this->users_model->get_data_byId('user','id',$id);
		$totalFields = count(array_keys((array) $this->data['user'])) - 3;
		$nonEmptyFields = count(array_filter((array) $this->data['user'])) - 3;
		$this->data['profileComplete'] = round($nonEmptyFields * 100 / $totalFields);
		$this->data['activity_logs'] = $this->users_model->get_data('activity_log',array('userid' => $id));
		$this->data['country'] = $this->users_model->fetch_country();
		$this->_render_template('edit', $this->data);
	}
	
	
	#  Function to add/edit User
	public function save(){
		$jsonPermanentAddressArrayObject = (array('address' => $_POST['permanent_address'], 'country' => $_POST['permanent_country'], 'state' => @$_POST['permanent_state'], 'city' => @$_POST['permanent_city'], 'postal_zipcode' => $_POST['permanent_postal_zipcode']));				
		$address1 = json_encode($jsonPermanentAddressArrayObject);		
		$jsonCorrespondanceAddressArrayObject = (array('address' => $_POST['correspondance_address'], 'country' => $_POST['correspondance_country'], 'state' => @$_POST['correspondance_state'], 'city' => @$_POST['correspondance_city'], 'postal_zipcode' => $_POST['correspondance_postal_zipcode']));				
		$address2 = json_encode($jsonCorrespondanceAddressArrayObject);
		$experienceLength = count($_POST['companyName']);	
		if($experienceLength >0){
			$experienceArr = [];
			$i = 0;
			while($i < $experienceLength) {				
				$experienceJsonArrayObject = array('companyName' => $_POST['companyName'][$i], 'companyLocation' => $_POST['companyLocation'][$i], 'position' => $_POST['position'][$i], 'work_period' => $_POST['work_period'][$i] , 'responsibility' => $_POST['responsibility'][$i]);
				$experienceArr[$i] = $experienceJsonArrayObject;
				$i++;				
			}
			$experience_array = json_encode($experienceArr);
		}else{
			$experience_array = '';
		}
		$qualLength = count($_POST['qualification']);	
		if($qualLength >0){
			$arr = [];
			$i = 0;
			while($i < $qualLength) {				
				$jsonArrayObject = (array('qualification' => $_POST['qualification'][$i], 'university' => $_POST['university'][$i], 'year' => $_POST['year'][$i], 'marks' => $_POST['marks'][$i]));
				$arr[$i] = $jsonArrayObject;
				$i++;				
			}
			$qualification_array = json_encode($arr);
		}else{
			$qualification_array = '';
		}
		$skillLength = count($_POST['skill_name']);	
		if($skillLength >0){
			$skillArr = [];
			$j = 0;
			while($j < $skillLength) {				
				$jsonSkillObject = (array('skill_name' => $_POST['skill_name'][$j], 'skill_count' => $_POST['skill_count'][$j]));
				$skillArr[$j] = $jsonSkillObject;
				$j++;				
			}
			$skill_array = json_encode($skillArr);
		}else{
			$skill_array = '';
		}
		if ($this->input->post()) {
			$required_fields = array('name','email','designation','contact_no','age','date_joining','gender');		
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}else{				
				$data  = $this->input->post();	
				
				#pre($data); die;
				$data['qualification'] = $qualification_array;
				$data['experience_detail'] = $experience_array;
				$data['skill'] = $skill_array;
				$data['address1'] = $address1;
				$data['address2'] = $address2;
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
				if($id && $id != ''){
					#pre($data); die;
					$success = $this->users_model->update_data('user_detail',$data, 'u_id', $id);
					if ($success) {
						$data['message'] = "user details updated successfully";
						logActivity('user details Updated','user',$id);
						$this->session->set_flashdata('message', 'User Details Updated successfully');
						redirect( base_url().'users/edit/'.$id, 'refresh');
						die;
					}
				}else{					
					$checkEmail = $this->users_model->emailExist($data['email']);
					$email = $data['email'];
					if(empty($checkEmail)){
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
						$data['company_db_name'] =  $_SESSION['loggedInUser']->company_db_name;
						$data['business_status'] =  1;
						//pre($data); die;
						$insertedUserId = $this->users_model->insert_tbl_data('user', $data);
						if ($insertedUserId) {
							$data['u_id'] = $insertedUserId;
							$insertedUserDetailId = $this->users_model->insert_tbl_data('user_detail', $data);
							$sub_modules = $this->users_model->get_data('sub_module');	
							foreach($sub_modules as $sub_module) {
								$permissions_data = array();
								$permissions_data['is_all'] = 0;
								$permissions_data['is_view'] = 0;
								$permissions_data['is_add'] = 0;
								$permissions_data['is_edit'] = 0;
								$permissions_data['is_delete'] = 0;
								$permissions_data['is_validate'] = 0;
								$permissions_data['sub_module_id'] = $sub_module['id'];
								$permissions_data['user_id'] = $insertedUserId;
								$insertPermission=$this->users_model->save_user_permissions($permissions_data);
							}
							$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
												<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
													<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$data["name"].',</p>								
													<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">You are registered as a user on ERP. Your password is '.$password.', This password will work only after your email verification.</p>
													<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Please Open this link to verified your email address - '.base_url().'auth/verifyEmail/'.$data["activation_code"].'</p>	
												</td>
											</tr>
										</table>
									</td>
								</tr>';	
								send_mail($email ,'Email Verification' ,$email_message);							
								logActivity('User details Inserted','user',$id);
								$this->session->set_flashdata('message', 'User Details Inserted successfully');
								
								redirect( base_url().'users', 'refresh');
								die;	
						}			
					}else{
						$this->session->set_flashdata('message', 'Email id already exist');
						redirect( base_url().'users', 'refresh');
						die;						
					}
				}
			}
		}
	}
	
	# Delete User by status inactive
	public function delete($id = ''){
		if (!$id) {
           redirect('Users/users', 'refresh');
        }
       // $result = $this->users_model->delete_data('user','id',$id);
		$result = $this->users_model->change_status($id, 0);
		if($result) {
			logActivity('user Deleted','user',$id);
			$this->session->set_flashdata('message', 'user Deleted Successfully');
			$result = array('msg' => 'user Deleted Successfully', 'status' => 'success', 'code' => 'C296','url' => base_url() . 'users');    
			echo json_encode($result);
			die;
        } 
		else {
            echo json_encode(array('msg' => 'error', 'status' => 'error', 'code' => 'C118'));
        }
	}

	# Function to save the permissions of User
	public function save_permission(){
        $sub_modules = $this->users_model->get_data('sub_module'); 
        $data  = $this->input->post();
        foreach($sub_modules as $sub_module) {
            $permissions_data = array();
			# Initially set all the permissions to zero means user don't have any permission to access
            $permissions_data['is_all'] = 0;
            $permissions_data['is_view'] = 0;
            $permissions_data['is_add'] = 0;
            $permissions_data['is_edit'] = 0;
            $permissions_data['is_delete'] = 0;
			$permissions_data['is_validate'] = 0;
			# Set the permissions 
            if($this->input->post($sub_module['id'].'_all')) {    
                $permissions_data['is_all'] = 1;
            }
            if($this->input->post($sub_module['id'].'_view')) {    
                $permissions_data['is_view'] = 1;
            }
            if($this->input->post($sub_module['id'].'_add')) {    
                $permissions_data['is_add'] = 1;
            }
            if($this->input->post($sub_module['id'].'_edit')) {    
                $permissions_data['is_edit'] = 1;
            }
            if($this->input->post($sub_module['id'].'_delete')) {    
                $permissions_data['is_delete'] = 1;
            }   
            if($this->input->post($sub_module['id'].'_validate')) {    
                $permissions_data['is_validate'] = 1;
            }                			
            $permissions_data['sub_module_id'] = $sub_module['id'];
            $permissions_data['user_id'] = $data['id'];     
            $permission=$this->users_model->update_user_permissions( $data['id'],$sub_module['id'],$permissions_data);
        }
		if ($permission) {                        
			logActivity('permission are set','permisssions',$permission);
			$this->session->set_flashdata('message', 'Permission updated successfully.');
			redirect( base_url().'users', 'refresh');
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
   public function change_status(){
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $status = (isset($_POST['status']) && $_POST['status'] == 1) ? '1' : '0';
		$status_data = $this->users_model->change_status($id, $status);
        logActivity('Changed','user',$id);
        $result = array('msg' => ' Status Changed', 'status' => 'success', 'code' => 'C221','url' => base_url().'Users/users');
        echo json_encode($result);
   }
   
   # Function to change the password of User
   public function changePassword(){
		$data  = $this->input->post();		
		$password = easy_crypt($data['password']);
		$old_row = $this->users_model->get_data_byId('user', 'id',$_POST['id']);		
		if(easy_crypt($data['old_password']) == $old_row->password){
			$success = $this->users_model->change_password($data['id'],$password);
				if ($success) {
					logActivity('user password changed','user',$data['id']);
					$this->session->set_flashdata('message', 'user password changed successfully');
					redirect( base_url().'users/edit/'.$data['id'], 'refresh');
					die;
				}
		}else{			 
			$this->session->set_flashdata('message', 'Your old password is wrong.');
			redirect( base_url().'users/edit/'.$data['id'], 'refresh');
					die;
		}
		

   }
   
    # Function to get activity log of particular User
	public function fetch_user_activity_log(){
		if(isset($_POST["limit"], $_POST["start"])){		
			//$userLog = $this->users_model->fetch_user_activity_log($_POST["start"],$_POST["limit"],$_SESSION['loggedInUser']->id);
			$userLog = $this->users_model->fetch_user_activity_log($_POST["start"],$_POST["limit"],$_POST["id"]);
			//echo json_encode($userLog);
			$userData  = '';
			
			foreach($userLog as $activity_log){
					$activityUserData = getNameById('user_detail',$activity_log['userid'],'u_id');
					if(!empty($activityUserData)){
						if($activityUserData->user_profile != ''){
							$userProfile = $activityUserData->user_profile;
						}else{
							$userProfile = ($activityUserData->user_profile == '' && $activityUserData->gender =='Female')?'female_image_placeholder.jpg':'dummy.jpg';
						}
						//$userProfile = $activityUserData->user_profile?$activityUserData->user_profile:'userp.png';
					}else{
						$userProfile = 'dummy.jpg';
					}?>	
				<li>
					<img src="<?php echo base_url('assets/modules/users/uploads').'/'.$userProfile;?>" class="avatar" alt="Avatar">
					<div class="message_date">
					  <?php /*<h3 class="date text-info">24</h3>
					  <p class="month">May</p> <?php */ ?>
					  <p class="month"><?php echo $activity_log['date'] ; ?></p>
					</div>
					<div class="message_wrapper">
					  <h4 class="heading"><?php echo $activity_log['rel_type'] ; ?></h4>
					  <blockquote class="message"><?php echo $activity_log['description'] ; ?></blockquote>
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
	public function userActivityGraphData(){
		//$userActivityGraphData = userActivityGraphData($_POST['userid']);
		$userActivityGraphData = getActivityLogGraphData($_POST['userid']);
		echo json_encode($userActivityGraphData);
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
	
	
	public function uploadImageByAjax(){
		if(isset($_POST["image"])){
			$data = $_POST["image"];
			$image_array_1 = explode(";", $data);
			$image_array_2 = explode(",", $image_array_1[1]);
			$data = base64_decode($image_array_2[1]);
			$exp=explode('.', $_POST["uploaded_image_name"]);			
			$activityUserData = getNameById('user_detail',$_POST["user_id"],'u_id');
			$nameChar = substr($activityUserData->name, 0, 3);
			$oldImage = $activityUserData->user_profile;
			
			$imageName = $exp[0].'_user_'.$nameChar.'_'.time().".".$exp[1];	
			file_put_contents('assets/modules/users/uploads/'.$imageName, $data);			
			$success = $this->users_model->updateUserProfile('user_detail',array('user_profile'=>$imageName), 'u_id', $_POST["user_id"]);
			if($oldImage != ''){
				unlink('assets/modules/users/uploads/'.$oldImage);
			}
			$result = array('image' => $imageName,'imageHtml'=>'<img src="'.base_url().'assets/modules/users/uploads/'.$imageName.'" class="img-thumbnail" />');
			echo json_encode($result);
		}
	}
	
}