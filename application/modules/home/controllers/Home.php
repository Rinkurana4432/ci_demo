<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends ERP_Controller {
    public function __construct() {
        parent::__construct();
      #  is_login();
        $this->load->library(array( 'form_validation'));
		$this->load->library('email');
                $this->load->library('phpmailer_lib');
		$this->load->library('Pagination');
		$this->load->library('paypal_lib');
		$this->load->helper('home/home');
		$this->load->helper('cookie');
        $this->load->model('home_model');
		$this->settings['css'][]= 'assets/plugins/google-code-prettify/bin/prettify.min.css';
		$this->settings['css'][]= 'assets/modules/home/js/style.css';
		$this->scripts['js'][] = 'assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js';
		$this->scripts['js'][] = 'assets/plugins/jquery.hotkeys/jquery.hotkeys.js';
		$this->scripts['js'][] = 'assets/plugins/google-code-prettify/src/prettify.js';
		$this->scripts['js'][] = 'assets/modules/home/js/slick.min.js';
		$this->scripts['js'][] = 'assets/modules/home/js/script.js';		
    }
	
    /* Main Function to fetch all the listing of leads */
    public function index(){  
        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        
	 $data = $formData = array();
        // If contact request is submitted
        if ($this->input->post('contactSubmit')) {
			
            // Get the form data
            $formData = $this->input->post();
            // Define email data
                $mailData    = array(
                    'usr' => $formData['usr'],
                    'email' => $formData['email'],
                    'phone' => $formData['phone'],
                 );
                // Mail config
				 $to          = "sales@lastingerp.com,lsplpkl@gmail.com";
                                 //$to          = "lsplpkl@gmail.com";
				
                //$from = 'amandeep@lastingerp.com';
                //$fromName = 'AmitaERP';
                $mailSubject = 'Contact Request Submitted by LastingERP' . $mailData['usr'];
                
                // Mail content
                $mailContent = '
						<h2>Contact Request Submitted by LastingERP</h2>
						<p><b>Name: </b>' . $mailData['usr'] . '</p>
						<p><b>Email: </b>' . $mailData['email'] . '</p>
						<p><b>Mobile No : </b>' . $mailData['phone'] . '</p>';
				//	echo "<pre>"; print_r($mailContent);die;
           
                /*if($mailData['email'] == 'geetika@lastingerp.com') {
                    $send  = $this->send_mail($to, $mailSubject, $mailContent);
                    echo 'done'; die;
                } */
			 $send  = $this->send_mail($to, $mailSubject, $mailContent);
                         
                // Send an email to the site admin
                // $send = $this->sendEmail($mailData);
		   
                // Check email sending status
                if ($send) {
					  //  $this->home_model->insert_tbl_data('rfd', $formData);
					  //set message to be shown when registration is completed
					// Unset form data
                    //  $formData = array();
                     $formData = array();
                    $data['status'] = array(
                        'type' => 'success',
                        'msg' => 'Your contact request has been submitted successfully.'
                    );
					 //$this->session->set_flashdata('success','Your contact request has been submitted successfully.');
                    //redirect('home');
					//redirect(base_url() . 'home', 'refresh');
                } else {
                    $data['status'] = array(
                        'type' => 'error',
                        'msg' => 'Some problems occured, please try again.'
                    );
                    // $this->session->set_flashdata('error','Some problems occured, please try again.');
                 }
           redirect('https://lastingerp.com/lerp/thank-you/');
        }
		$this->load->view('new_header');
		$this->load->view('new_home', $this->data);
		#$this->load->view('maintenance_page', $this->data);
		$this->load->view('new_footer');
	}
	public function index_landing(){ 
		/*if(isset($_SESSION['loggedInUser'])){
			redirect(base_url().'dashboard/', 'refresh');
		}	*/
		
		//$where = array('sale_purchase'=> 'Sale','status'=>1);
		$where = array('status'=>1,'sale_purchase'=> '["Sale"]');
		#$this->data['products']  = $this->home_model->get_data('material',$where,'saleMaterial');		
		$this->data['products']  = $this->home_model->get_data('material',$where,'saleMaterial','landingPageLimit');
				
		//$this->data['topSellingMaterials']  = $this->home_model->topSellingMaterial();	
		$this->data['topSellingMaterials']  = getTopSellingProducts();	
		
		$this->load->view('landing/header');
		$this->load->view('landing/index',$this->data);
		$this->load->view('landing/footer');
			
    }
	
	   /* Main Function to fetch all the listing of leads */
    public function old_home(){		
		
		
		/*if(isset($_SESSION['loggedInUser'])){
			redirect(base_url().'dashboard/', 'refresh');
		}	*/
		
		//$where = array('sale_purchase'=> 'Sale','status'=>1);
		$where = array('status'=>1,'sale_purchase'=> '["Sale"]');
		#$this->data['products']  = $this->home_model->get_data('material',$where,'saleMaterial');		
		$this->data['products']  = $this->home_model->get_data('material',$where,'saleMaterial','landingPageLimit');
				
		//$this->data['topSellingMaterials']  = $this->home_model->topSellingMaterial();	
		$this->data['topSellingMaterials']  = getTopSellingProducts();	
		
		$this->load->view('header');
		$this->load->view('landing', $this->data);
		$this->load->view('footer');
		
		
			
    }
	
	
	
	    /* Main Function to fetch all the listing of leads */
    public function landing(){ 
		/*if(isset($_SESSION['loggedInUser'])){
			redirect(base_url().'dashboard/', 'refresh');
		}	*/
		$where = array('status'=>1 , 'sale_purchase'=> '["Sale"]');
		$this->data['materials']  = $this->home_model->get_data('material',$where,'saleMaterial');	
		
       // $this->load->view('signup', $this->data);
		$this->load->view('header');
		$this->load->view('landing', $this->data);
		$this->load->view('footer');			
    }
	
	public function rfq(){
		if ($this->input->post()) {
			# required field server side validation 
			$required_fields = array('contacts','email','mobile','products','quantity','uom');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}else{
				# If form is valid
				$data  = $this->input->post();	
				$emailData = $this->home_model->getCompanyEmailsRelatedToMaterial('material',$data['products']);
				if(!empty($emailData )){
					$uniqueCids = array_unique(array_map(function ($i) { return $i['created_by_cid']; }, $emailData));					
						foreach($uniqueCids as $uniqueCid){				
							$userData = getNameById('user',$uniqueCid,'c_id');
							$companyEmail = $userData->email;
							$companyData = getNameById('company_detail',$uniqueCid,'id');
							$companyName = $companyData->name;						
							$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
													<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
														<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$companyName.',</p>								
														<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">You have a request for material '.$data['products'].' of '.$data['quantity'].' '.$data['uom'] . ' from '.$data['contacts'].'.</p>
														<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>	
													</td>
												</tr>
											</table>
										</td>
									</tr>';	
							send_mail($data['email'] ,'Product Request' ,$email_message);
						}
					}
				
					# Insert rfq
					$id = $this->home_model->insert_tbl_data('rfq',$data);						
					if ($id) {  
						$leadData['contacts'] = '[{"first_name":"'.$data['contacts'].'","last_name":"","email":"'.$data['email'].'","phone_no":"'.$data['mobile'].'"}]';
						$leadData['products'] = $data['products'];
						$leadData['quantity'] = $data['quantity'];
						$leadData['uom'] = $data['uom'];
						$leadId = $this->home_model->insert_tbl_data('leads',$leadData);
                        $this->session->set_flashdata('message', 'Request sent successfully');
					    redirect(base_url().'home', 'refresh');
                    }    				
				
			}			
        }
	}
	
	public function search(){
		if ($this->input->get()) {
			$data  = $this->input->get();
			$materialWhere = array('sale_purchase'=> '["Sale"]','status'=>1);
			//$this->data['materials'] = $this->home_model->getCompanyEmailsRelatedToMaterial('material',$data['product_name'], $materialWhere);
			if($data['category'] == 'Product'){
				$this->data['materials'] = $this->home_model->getSearchRelatedData('material',array('material_name'=>$data['name'],'status'=>1), $materialWhere,'saleMaterial');
			}else{
				$this->data['company'] = $this->home_model->getSearchRelatedData('company_detail',array('name'=>$data['name']));
			}
			$this->load->view('header');
			$this->load->view('search', $this->data);
			$this->load->view('footer');
        }
	}

	
	public function product_detail(){
		$material_id = $_GET['material_id'];
		$comp_id = $_GET['company_id'];
		$this->data['material'] = $this->home_model->get_data_by_key('material' ,'id', $material_id);
		$this->data['imageUploads']  = $this->home_model->get_material_attachment_by_id('attachments', $material_id ,'material');
		
		$this->data['company']  = getNameById('company_detail',$comp_id,'id');
		
		$this->data['companyCertificate']  = $this->home_model->get_attachment_by_id('attachments',array('rel_id'=>$comp_id , 'rel_type'=>'company'));		
		#$this->data['companyProducts']  = $this->home_model->get_data('material',array('created_by_cid'=>$comp_id ,'sale_purchase'=>'sale'));
		$this->data['companyProducts']  = $this->home_model->get_data('material',array('created_by_cid'=>$comp_id ,'sale_purchase'=>'["Sale"]'),'saleMaterial');
		$this->data['reviews']  = $this->home_model->get_data('reviews',array('material_id'=>$material_id ));
		
		$this->data['countRating']  = getStarRatingCount('reviews',$material_id,'material_id');
		$this->data['countReviews']  = $this->home_model->getReviewRating('reviews',array('material_id'=>$material_id ));
		
			$config = array();
            $config["base_url"] = base_url() . "home/product_detail/";
            $config["total_rows"] = count($this->home_model->get_data('reviews',array('material_id'=>$material_id )));//This controller is used to fetch table  data
			//pre($config["total_rows"]);
            $config["per_page"] = 2;
            $config["uri_segment"] = 3;
            $config['reuse_query_string'] = true;
            $config["use_page_numbers"] = TRUE;
            $config["num_links"] = count($this->home_model->get_data('reviews',array('material_id'=>$material_id )));
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
            $config['cur_tag_open'] = '<li class="active">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>';
            $config['anchor_class'] = 'follow_link';
			$this->pagination->initialize($config);
		    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
			$this->data["users_data"] = $this->home_model->fetch_data_records('reviews', $config["per_page"], $page,$material_id); //users id table name
			//$this->data["users_data"] = $this->home_model->fetch_data_records('reviews', $material_id); //users id table name
			//pre($this->data["users_data"]);
            $this->data["links"] = $this->pagination->create_links();
			//pre($data["links"]); die;
			$this->load->view('header');
			$this->load->view('product_detail', $this->data);
			$this->load->view('footer');
	}
	
	public function contactSupplier(){
		$material_id = $_GET['material_id'];
		$comp_id = $_GET['company_id'];
		$this->data['material'] = $this->home_model->get_data_by_key('material' ,'id', $material_id);
		$this->data['company']  = getNameById('company_detail',$comp_id,'id');
		$this->load->view('header');
		$this->load->view('contact_supplier', $this->data);
		$this->load->view('footer');
	}
	
	
	
	
	
	public function emailContactSupplier(){
		if ($this->input->post()) {
			# required field server side validation 
			$required_fields = array('contacts','email','mobile','products','quantity','uom');	
			$is_valid = validate_fields($_POST, $required_fields);
			if (count($is_valid) > 0) {
				valid_fields($is_valid);				
			}else{
				# If form is valid
				$data  = $this->input->post();	
				$companyData = getNameById('company_detail',$data['company_id'],'id');
				if(!empty($companyData)){
					$companyUserData = getNameById('user',$companyData->u_id,'id');
					if(!empty($companyUserData )){	
						$companyEmail = $companyUserData->email;
						$companyName = $companyData->name;							
						$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
															<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$companyName.',</p>								
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">You have a request for material '.$data['products'].' of '.$data['quantity'].' '.$data['uom'] . ' from '.$data['contacts'].'.</p>
																<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>	
															</td>
														</tr>
													</table>
												</td>
											</tr>';	
							send_mail($companyEmail ,'Product Request' ,$email_message);
						}
					}
					# Insert rfq
					$id = $this->home_model->insert_tbl_data('rfq',$data);						
					if ($id) {  
						$leadData['contacts'] = '[{"first_name":"'.$data['contacts'].'","last_name":"","email":"'.$data['email'].'","phone_no":"'.$data['mobile'].'"}]';
						$leadData['products'] = $data['products'];
						$leadData['quantity'] = $data['quantity'];
						$leadData['uom'] = $data['uom'];
						$leadId = $this->home_model->insert_tbl_data('leads',$leadData);
                        $this->session->set_flashdata('message', 'Request sent successfully');
					   redirect(base_url().'home/contactSupplier?material_id='.$data["material_id"].'&company_id='.$data["company_id"].'', 'refresh');
                    }    				
				
			}			
        }		
	}
	
	public function emailSubscribe(){		
		if($_POST['email'] != ''){
			$email = $_POST['email'];
			/* Email to subscriber  */
			$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
								<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi,</p>								
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">You have been subscribed on our ERP</p>
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">If you want to unsubscribr than click on this link. <a href="'.base_url().'home/emailUnsubscribe/'.$email.'">Click here</a></p>
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>	
								</td>
							</tr>
						</table>
					</td>
				</tr>';	
			send_mail($_POST['email'] ,'Email Subscribed' ,$email_message);
			
			
			/* Email to erp  */
			
			$email_messageToErp = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
								<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi,</p>								
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">'.$_POST["email"].' is subscribed on ERP . Add this subscriber in your comtact list.'.base_url().'home/emailUnsubscribe/'.$_POST["email"].'</p>
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>	
								</td>
							</tr>
						</table>
					</td>
				</tr>';	
			send_mail('sales@lastingerp.com' ,'Email Subscription' ,$email_messageToErp);
			echo 'Email sent successfully';
		}
		
	
	}
	
	public function emailUnsubscribe($email = ''){		
		if($email != ''){		
			/* Email to subscriber  */
			$email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
								<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi,</p>								
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">You are successfully unsubscribed from our ERP</p>									
								</td>
							</tr>
						</table>
					</td>
				</tr>';	
			//send_mail('rachnajangra268@gmail,com' ,'Email Unsubscribed' ,$email_message);
			send_mail($email ,'Email Unsubscribed' ,$email_message);
			
			
			/* Email to erp  */
			
			$email_messageToErp = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
								<td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi,</p>								
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Unsubscription request received from '.$email.'</p>
									<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;"></p>	
								</td>
							</tr>
						</table>
					</td>
				</tr>';	
		$emailResponse =	send_mail('sales@lastingerp.com' ,'Unsubscription email request' ,$email_messageToErp);
		$this->data['message'] = 'You are successfully unsubscribed from ERP';
		$this->load->view('header');
		$this->load->view('unsubscribe', $this->data);
		$this->load->view('footer');
		}
		
	
	}
	
	public function saveReviews(){
		$material_id = $_POST['material_id'];
		$comp_id = $_POST['company_id'];
		if($this->input->post()){	
		$required_fields = array('name','comments');		
		$is_valid = validate_fields($_POST, $required_fields);
		if (count($is_valid) > 0) {
			valid_fields($is_valid);	
		}else{
			$data  = $this->input->post();
			$data['created_by_cid'] = $_SESSION['loggedInUser']->c_id ;
				//pre($_POST); die;
				
					$id = $this->home_model->insert_tbl_data('reviews',$data);
					// redirect(base_url().'product_detial/product_detail', 'refresh');
					//redirect(base_url().'home/product_detail?material_id=1&company_id=3', 'refresh');
					redirect(base_url().'home/product_detail?material_id='.$material_id.'&company_id='.$comp_id.'', 'refresh');
					
				
			}
        }
	
	}
	
	
	
	/*public function pagination() {
		
       $config = array();
       $config["base_url"] = base_url() . "home/product_detail";
       $config["total_rows"] = $this->home_model->record_count();
       $config["per_page"] = 5;
       $config["uri_segment"] = 3;
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       $data["results"] = $this->home_model->fetch_departments($config["per_page"], $page);
	  
       $data["links"] = $this->pagination->create_links();
	   pre($data["links"]);
	   $this->load->view('header');
	   $this->load->view('index', $data);
	   $this->load->view('footer');
      // $this->load->view("pagination", $data);
   }*/
   
 public function ciSessionData(){
	global $sess ;
	print_r($_SESSION);
	return $_SESSION;
 }




    /* Main Function to fetch all the listing of leads */
   /* public function pricing(){ 		
		$this->data['products'] = $this->home_model->getRows();
		$this->load->view('header');
		$this->load->view('pricing', $this->data);
		$this->load->view('footer');	
    }*/
	
	
	
	
	
	
	# function buy($id){
	 function buy($name,$price){
        // Set variables for paypal form
        $returnURL = base_url().'home/paypal/success';
        $cancelURL = base_url().'home/paypal/cancel';
        $notifyURL = base_url().'home/paypal/ipn';
        
        // Get product data from the database
        #$product = $this->home_model->getRows($id);
        
        // Get current user ID from the session
        $userID = $_SESSION['loggedInUser']->u_id;
        
        // Add fields to paypal form
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        #$this->paypal_lib->add_field('item_name', $product['name']);
        $this->paypal_lib->add_field('item_name', $name);
        $this->paypal_lib->add_field('custom', $userID);
        #$this->paypal_lib->add_field('item_number',  $product['id']);
        $this->paypal_lib->add_field('item_number',  $name);
        #$this->paypal_lib->add_field('amount',  $product['price']);
        $this->paypal_lib->add_field('amount',  $price);
        
        // Render paypal form
        $this->paypal_lib->paypal_auto_form();
    }

    
    
    public function send_mail($to,$subject,$message) {
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        ); // Enable verbose debug output
        $mail->Subject     = $subject;
        $mail->isSMTP(); // Send using SMTP
        $mail->Host       = 'email-smtp.ap-south-1.amazonaws.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = 'AKIAZB4WVENVTP6UMCP3';                     // SMTP username
        $mail->Password   = 'BDrXyyRLh/Z5ovqCQUiz35djHjtqoGf3MEtYynSgZ3b3';                               // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        //Recipients
        $mail->setFrom('dev@lastingerp.com', 'Lasting ERP');
        
        $recipients = explode(',',$to);
        foreach($recipients as $to) {
            $mail->addAddress($to, ''); // Add a recipient
        }
        
        // Content
        $mail->isHTML(true);
        // Email body content
        $mail->Body    = $message;
        #$mail->ClearAllRecipients();
        $mail->send();
        
        /*
        //send the message, check for errors
        if (!$mail->send()) { 
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
        die;
        */
    }
	
	public function send_request_mail(){
	$name=$_POST['name'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$email_message='<b>Name:</b> '.$name.'<br><b>Email:</b> '.$email.'<br><b>Phone:</b> '.$phone.'';
	$date = time();
	send_mail('sales@lastingerp.com',"Contact Request Form {$name} {$date}" ,$email_message);
	send_mail('lsplpkl@gmail.com',"Contact Request Form {$name} {$date}" ,$email_message);
	
	//send_mail('pankaj@lastingerp.com',"Contact Request Form {$name} {$date}" ,$email_message);

	
	}
	
	public function send_request_callback_mail(){
	$name=$_POST['name'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$industry=$_POST['industry'];
	$company_name=$_POST['company_name'];
	$city=$_POST['city'];
	$requirements=$_POST['requirements'];
	$current_software=$_POST['current_software'];
	$reason=$_POST['reason'];
	$employees=$_POST['employees'];
	$designation=$_POST['designation'];
	$deployment=$_POST['deployment'];
	$call_time=$_POST['call_time'];
	$users=$_POST['users'];
	$email_message='<b>Name:</b> '.$name.'<br><b>Email:</b> '.$email.'<br><b>Phone:</b> '.$phone.'<br><b>Company Name:</b> '.$company_name.'<br><b>Industry:</b> '.$industry.'<br><b>City:</b> '.$city.'<br><b>Requirements:</b> '.$requirements.'<br><b>Designation:</b> '.$designation.'<br><b>Employees:</b> '.$employees.'<br><b>Users:</b> '.$users.'<br><b>Preferred Call Time:</b> '.$call_time.'<br><b>Deployment:</b> '.$deployment.'<br><b>Current Software:</b> '.$current_software.'<br><b>Reason for changes:</b> '.$reason.'';
		$date = time();
		send_mail('sales@lastingerp.com',"Contact Request Form {$name} {$date}" ,$email_message);
		send_mail('lsplpkl@gmail.com',"Contact Request Form {$name} {$date}" ,$email_message);

		//send_mail('pankaj@lastingerp.com',"Contact Request Form {$name} {$date}" ,$email_message);
		
		echo 'yes';
	}

	public function submit_captcha(){
	if(isset($_POST['g-recaptcha-response'])) {
   // RECAPTCHA SETTINGS
   $captcha = $_POST['g-recaptcha-response'];
   $ip = $_SERVER['REMOTE_ADDR'];
   $key = $_POST['key'];
   $url = 'https://www.google.com/recaptcha/api/siteverify';

   // RECAPTCH RESPONSE
   $recaptcha_response = file_get_contents($url.'?secret='.$key.'&response='.$captcha.'&remoteip='.$ip);
   $data = json_decode($recaptcha_response);

   if(isset($data->success) &&  $data->success === true) {
   	echo 'yes';
   }
   else {
    echo 'no';
   }
 }
	}
	
	
}
	?>