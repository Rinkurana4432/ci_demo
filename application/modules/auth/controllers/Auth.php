<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
		$this->load->model('auth_model');
		//$this->load->model('User_model');
		$this->load->helper(array('functions_helper')); 
		$this->load->library('email');
    }
	
    /* Main Function to fetch all the listing of departments */
    public function index() {
		if(isset($_SESSION['loggedInUser'])){
			redirect(base_url().'dashboard/', 'refresh');
		}
		$this->settings['module_title'] = 'Department';
		$this->data = '';
        $this->load->view('signup', $this->data);
    }
	
	
	public function test() {
		if(isset($_SESSION['loggedInUser'])){
			redirect(base_url().'dashboard/', 'refresh');
		}
		$this->settings['module_title'] = 'Department';
		$this->data = '';
        $this->load->view('new', $this->data);
    }
	
	 /* Main Function to fetch all the listing of departments */
    public function login() {
		if(isset($_SESSION['loggedInUser'])){
			redirect(base_url().'dashboard/', 'refresh');
		}	
		$this->settings['module_title'] = 'Department';
		$this->data = '';
        $this->load->view('signup', $this->data);
    }
	

	/**
     * This function is used for user authentication ( Working in login process )
     * @return Void
     */
	public function auth_user(){ 
		$return = $this->auth_model->auth_user();
//pre($return);die();	     	
		if($return == 'Please verify your email id') { 
			$this->session->set_flashdata('messagePr', 'Please verify your email id');	
            redirect( base_url().'auth/login#signin', 'refresh');  
        } else if($return == 'Entered Wrong detail'){ 			
			$this->session->set_flashdata('messagePr', 'Entered Wrong detail');	
			redirect( base_url().'auth/login#signin', 'refresh'); 
		}else if($return == 'Inactive account'){
			$this->session->set_flashdata('messagePr', 'Your account is inactive.');	
			redirect( base_url().'auth/login#signin', 'refresh'); 
		}
		/*else if($return->business_status == 0){
			$this->session->set_flashdata('messagePr', 'Your account is inactive, Please wait for 48 hours.');	
			redirect( base_url().'auth/login#signin', 'refresh'); 
		}*/
		else {
				//$company_detail = $this->auth_model->auth_user_company_detail($return->c_id);
				$company_detail = $this->auth_model->auth_user_company_detail($return->id);
				$this->session->set_userdata('user_id',$return->u_id);
				$this->session->set_userdata('loggedInUser',$return);				
				$this->session->set_userdata('loggedInCompany',$company_detail);
				$this->session->set_userdata('login_status', 'ok');
				$this->session->set_userdata('company_id',$company_detail->c_id);
    			//$this->user->logged($this->session->userdata('user_id'));
				redirect( base_url().'dashboard', 'refresh');
				redirect( base_url().'company/businessproof', 'refresh');
		}         
    }
	
    
		public function register(){
		if ($this->input->post()) {
			$required_fields = array('name','email','password');		
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);
			}
			else{
				$data  = $this->input->post();			
				$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
				$userIp=$this->input->ip_address();     
				$secret = $this->config->item('google_secret');   
				$url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp; 
				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL, $url); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				$output = curl_exec($ch); 
				curl_close($ch);               
				$status= json_decode($output, true); 
				if ($status['success'] && $recaptchaResponse!='') {
					$checkEmail = $this->auth_model->emailExist($data['email']);
					$email = $data['email'];
					if(empty($checkEmail)){				
						#$gstinEmail = $this->auth_model->gstinExist($data['gstin']);
						#if(empty($gstinEmail)){
							//echo 'in if con'; 
								$password = $data['password'];
								$data['password'] = easy_crypt($data['password']);
								$data['email_status'] = 'not verified';
								$data['activation_code'] = md5(rand());
								//$data['role'] = 1;
								$data['role'] = 3;
								$data['status'] = 1;
								$companyName = $data['name'];
								$insertedUserId = $this->auth_model->insert_tbl_data($data,'user');
								if ($insertedUserId) {
									$data['u_id'] = $insertedUserId;
									$companyDetailInsertedId = $this->auth_model->insert_tbl_data($data,'company_detail');
									$userDetailInsertedId = $this->auth_model->insert_tbl_data(array('c_id' => $companyDetailInsertedId, 'u_id' => $insertedUserId, 'name'=> 'admin'),'user_detail');
									if ($companyDetailInsertedId) {
										$udatedData = $this->auth_model->update_data('user',array('c_id' => $companyDetailInsertedId),'id',$insertedUserId) ;
									}
									$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
														<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
															<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$data["name"].',</p>								
															<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Thanks for Registration. Your password is '.$password.', This password will work only after your email verification.</p>
															<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Please Open this link to verified your email address - <a href='.base_url().'auth/verifyEmail/'.$data["activation_code"].'>Please Verify</a></p>  	
														</td>
													</tr>
												</table>
											</td>
										</tr>';
										
									$admin_email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
														<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
															<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi admin,</p>								
															<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">A new company "'.$companyName.'" is registered on LERP and the email is '.$email.' <br/> And Phone Number is : '.$_POST['phone'].'.</p>
															<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>	
														</td>
													</tr>
												</table>
											</td>
										</tr>';			
									send_mail($email ,'Email Verification' ,$email_message);									
									send_mail('lsplpkl@gmail.com' ,'New Company registered' ,$admin_email_message);
									// send_mail('dharamveersingh@lastingerp.com' ,'New Company registered' ,$admin_email_message);
									
									$this->session->set_flashdata('messageRegister', 'Signup Successfully , Please check your email and verify your email id.');
									redirect( base_url().'auth/login#signup', 'refresh'); 
							}	
						/*}else{
							$this->session->set_flashdata('messageRegister', 'GSTIN already exist');	
							redirect( base_url().'auth/login#signup', 'refresh'); 
						}*/
					}else{
						$this->session->set_flashdata('messageRegister', 'Email already exist');	
						redirect( base_url().'auth/login#signup', 'refresh'); 
					}
				}else{
					$this->session->set_flashdata('flashError', 'Sorry Recaptcha Unsuccessful!!');
					redirect( base_url().'auth/login#signup', 'refresh'); 
				}
				
			}
        }
	}
	
	
	
	
	
	
	/**
      * This function is used to logout user
      * @return Void
      */
    public function logout(){
		$logout_user_id =  $this->session->userdata('user_id');
		$this->auth_model->logout_for_chat($logout_user_id);
        is_login();
        $this->session->unset_userdata('loggedInUser');               
        $this->session->unset_userdata('loggedInCompany');               
        redirect( base_url(), 'refresh');
    }

	
	public function verifyEmail(){
		$activation_code =  $this->uri->segment(3);
		if(isset($activation_code)){
			$row = $this->auth_model->get_data_by('user','activation_code',$activation_code);
			#pre($row);
			$id = $row->id;
			$field = array('email_status' => 'verified');
		    if($row->email_status == 'not verified'){
				if($row->company_db_name == ''){
					$this->auth_model->update_data('user',$field,'id',$id);
				}else{
						$this->auth_model->update_data('user',$field,'id',$id,'companyDbExist');
				}
				$this->data['message'] = "Your Email Address Successfully Verified <br />You can login from here - <a href='".base_url()."auth/login'>Login</a>";
			}
			else{
				$this->data['message'] = "Your Email Address Already Verified <br />You can login from here - <a href='".base_url()."auth/login'>Login</a>";
			}
		}
		else{
			$this->data['message'] = "Invalid Link";
		}
		$this->load->view('email_verify', $this->data);			
	}
	
		
		/*
Forgotpassword email sender:
No view
*/
     public function ForgotPassword(){
        $email = $this->input->post('email');      
        $findemail = $this->auth_model->ForgotPassword($email);		
		if($findemail){
			//$this->usermodel->sendpassword($findemail);        
			$data = $this->auth_model->get_data_by('user','email',$findemail['email']);   
			if(!empty($data)){
				$randomNumberPass =  rand(100000000, 999999999);
				$password = easy_crypt($randomNumberPass);
				// $password = easy_crypt('admin@123');
				$dataArray = array('password' => $password);
				#$udatedData = $this->auth_model->update_data('user',$dataArray,'email',$email) ;
				
				if($data->role==3){
					$udatedData = $this->auth_model->update_data('user',$dataArray,'email',$email) ;
				}else{
					$udatedData = $this->auth_model->update_data('user',$dataArray,'email',$email,'companyDbExist',$data->company_db_name) ;
					#die;
				}
				
				
				$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
									<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
										<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi ,</p>								
										<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Thanks for contacting regarding to forgot password,</p>
										<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Your password is:  '.$randomNumberPass.'</p>
										<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Please Update your password.</p>											
									</td>
								</tr>
							</table>
						</td>
					</tr>';	
					
					$this->load->library('phpmailer_lib');
        
                                // PHPMailer object
                         $mail = $this->phpmailer_lib->load();
                         $mail->SMTPDebug = 0;  
							$mail->SMTPOptions = array(
							'ssl' => array(
								'verify_peer' => false,
								'verify_peer_name' => false,
								'allow_self_signed' => true
							)
						);// Enable verbose debug output
					$mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
					$mail->isSMTP();                                            // Send using SMTP
					$mail->Host       = 'email-smtp.ap-south-1.amazonaws.com';                    // Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
					$mail->Username   = 'AKIAZB4WVENVZ773ONVF';                     // SMTP username
					$mail->Password   = 'BLDqOsL9LkOKnY6n4coXRFsrXNq66C9xLDlsaCzasGEG';                               // SMTP password
					$mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
					$mail->Port       = 587;                     
					$mail->addAddress($email,'');     // Add a recipient
					$mail->setFrom('dev@lastingerp.com','Lasting ERP');	
					//$mail->addAddress('dharamveersingh@lastingerp.com','');     // Add a recipient
					// Content
					$mail->isHTML(true);
	
        $mailContent = $email_message;
        $mail->Body = $mailContent;
        $mail->Subject = 'Reset Password: Lasting ERP';
        
        //$mail->send();
        //$mail->ClearAllRecipients();
        if($mail->send()){
            $this->session->set_flashdata('messageForgetPassword', 'Your New password is sent on your email address.');
        }
					#$this->session->set_flashdata('messageForgetPassword', 'Sorry Unable to send email....');
					/*if(send_mail($email ,'Forgot password OTP' ,$email_message)){
						$this->session->set_flashdata('messageForgetPassword', 'Your New password is sent on your email address.');	
					}*/
					
					
					
					/*else{
						$this->session->set_flashdata('messageForgetPassword',' Email not found!');
						redirect(base_url().'auth/login#resetreqpsd','refresh');
					}	*/									
					redirect( base_url().'auth/login#resetreqpsd', 'refresh');
			}       
		   }else{
				$this->session->set_flashdata('messageForgetPassword',' Email not found!');
				redirect(base_url().'auth/login#resetreqpsd','refresh');
		   }
		}
	

}