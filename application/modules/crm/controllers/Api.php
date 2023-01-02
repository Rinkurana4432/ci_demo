<?php

// require APPPATH . '/libraries/REST_Controller.php';
// use Restserver\Libraries\REST_Controller;

class Api extends ERP_Controller
{
    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('crm/crm');
    }
    public function login(){
        //echo "test";die;
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
            $result = $this->apimodel->loginmodel($_REQUEST['email'], $_REQUEST['password']);
            
            if (!empty($result)) {
                if ($result->email_status != 'verified') {
                    //return 'Please verify your email id';
                    echo '{"Status":"false", "Data":[{"result":"Please verify your email id"}]}';
                } else if ($result->status == 0) {
                    //return 'Inactive account';
                    echo '{"Status":"false", "Data":[{"result":"Inactive account"}]}';
                } else { 
                    $this->session->set_userdata('loggedInUser', $result);
                    $config_app  = switch_db_dinamico($result->company_db_name);
                   $permissions = $this->apimodel->fetch_user_premissions_by_id($config_app, $result->id, array(
                        'p.sub_module_id' => '215',
                        'p.user_id' => $result->id
                    ));
                  //  pre($permissions);die;
                    $user_data   = array(
                        "user_id" => $result->id,
                        "company_id" => $result->c_id,
                        "user_email" => $result->email,
                        "username" => $result->name,
                        "profile_image" => $result->user_profile,
                        "birthday" => $result->age,
                        "tracking_permission" => (isset($permissions->is_view))?$permissions->is_view:0,
                        "gender" => $result->gender,
                        "signin_signout" => "1",
						"role" => $result->role,
                        'company_db_name' => $result->company_db_name
                    );
                    $ddd         = json_encode($user_data);
                    echo '{"Status":"true","Data":' . $ddd . '}';
                }
            } else { 
                echo '{"Status":"false", "Data":[{"result":"The credentials you supplied were not correct"}]}';
            }
        }
    }
    public function user_attend_timein(){
        $this->load->model('apimodel', '', true);
        date_default_timezone_set('Asia/Kolkata');
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['company_id']) && $_REQUEST['signin_signout'] != '') {
            if ($_REQUEST['signin_signout'] == '1') {
                
                $signin_data['user_id']        = $_REQUEST['user_id'];
                $signin_data['c_id']           = $_REQUEST['company_id'];
                $signin_data['latitude']       = $_REQUEST['latitude'];
                $signin_data['longitude']      = $_REQUEST['longitude'];
                $signin_data['signin_signout'] = 1;
                $signin_data['time_in']        = date('Y-m-d h-i-s');
                //print_r($signin_data);die();
                //Latitude
                //Longitude
                $inserted_id = $this->apimodel->insert_tbl_data('tbl_api_attendance', $signin_data);
                echo '{"Status":"true", "Data":[{"login_id":"' . $inserted_id . '","time_in":"' . date('Y-m-d h-i-s') . '"}]}';
            }
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }
    
    public function user_attend_timeout(){
        $this->load->model('apimodel', '', true);
        date_default_timezone_set('Asia/Kolkata');
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['company_id']) && isset($_REQUEST['login_id']) && $_REQUEST['signin_signout'] != '') {
            if ($_REQUEST['signin_signout'] == '0') {
                $sign_out['user_id']        = $_REQUEST['user_id'];
                $sign_out['c_id']           = $_REQUEST['company_id'];
                $sign_out['signin_signout'] = 0;
                $sign_out['time_out']       = date('Y-m-d h-i-s');
                $return_val                 = $this->apimodel->update_data('tbl_api_attendance', $sign_out, 'id', $_REQUEST['login_id']);
                echo '{"Status":"true", "Data":[{"Timout":"' . date('Y-m-d h-i-s') . '"}]}';
            }
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }
    public function employee_tracking(){
        $this->load->model('apimodel', '', true);
        //	pre($_REQUEST);
        date_default_timezone_set('Asia/Kolkata');
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['company_id'])) {
            if ($_REQUEST['end_shift'] == '1') {
                $signin_data['user_id']       = $_REQUEST['user_id'];
                $signin_data['c_id']          = $_REQUEST['company_id'];
                $signin_data['latitude']      = $_REQUEST['latitude'];
                $signin_data['longitude']     = $_REQUEST['longitude'];
                $signin_data['tracking_date'] = $_REQUEST['tracking_date'];
                $signin_data['tracking_time'] = $_REQUEST['tracking_time'];
                $company_db_name              = $_REQUEST['company_db_name'];
                $config_app                   = switch_db_dinamico($company_db_name);
                $tracking_id                  = $this->apimodel->insert_data($config_app, 'emp_tracking', $signin_data);
                echo '{"Status":"true", "Data":[{"tracking_id":"' . $tracking_id . '"}]}';
            } else {
                echo '{"Status":"false", "Data":[{"result":"Record Not added"}]}';
            }
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }
	public function get_employee_tracking(){
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['user_id']) && $_REQUEST['signin_signout'] == '1' && isset($_REQUEST['company_id'])) {
			$where = array();
            $where['user_id']   = $_REQUEST['user_id'];
            $where['c_id '] = $_REQUEST['company_id'];
			$where['tracking_date'] = $_REQUEST['date'];
            $tracking_data              = $this->apimodel->get_data('emp_tracking', $where);
			$where1 = array();
            $where1['created_by']   = $_REQUEST['user_id'];
            $where1['created_by_cid'] = $_REQUEST['company_id'];
			$where1['DATE(created_date)'] = date('Y-m-d',strtotime($_REQUEST['date']));
            $result              = $this->apimodel->get_data('leads', $where1);
			$i=0;
			$leads_data  = array();
			foreach ($result as $data) {	
				$company_data = $this->apimodel->getNameById('company_detail',$data->created_by_cid,'id');
				$user_data = $this->apimodel->getNameById('user_detail',$data->created_by,'u_id');
				//$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;		
				$companyLogo = base_url().'assets/modules/company/uploads/locatin-icon.png';				
				$leads_data[$i]['id']   = $data->id;
				$leads_data[$i]['first_name']   = $data->first_name;
				$leads_data[$i]['company'] = $data->company;
				$leads_data[$i]['latitude']   = $data->latitude;
				$leads_data[$i]['longitude']   = $data->longitude;
				$leads_data[$i]['street']   = $data->street;
				$leads_data[$i]['user_id'] = $data->created_by;
				$leads_data[$i]['user_name']   = $user_data->name;			
				$leads_data[$i]['company_id']   = $data->created_by_cid;			
				$leads_data[$i]['company_logo']   = $companyLogo;
				$leads_data[$i]['date'] = date('Y-m-d',strtotime($data->created_date));
				$i++;
			}
			
			  //  $leads=  !empty($leads_data)?$leads_data:"No Leads Available";    
				//pre($leads);
			$tracking_data         = json_encode($tracking_data);		
			$leads_data         = json_encode($leads_data);

			 echo '{"Status":"true","Data":' . $tracking_data . ',"leads":' . $leads_data . '}';            
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }	
	public function get_working_dates(){
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['user_id']) && $_REQUEST['signin_signout'] == '1' && isset($_REQUEST['company_id'])) {
			$where = array();
            $where['user_id']   = $_REQUEST['user_id'];
            $where['c_id '] = $_REQUEST['company_id'];
            $tracking_data              = $this->apimodel->get_data('emp_tracking', $where);
            $trackingdata = array();
            $i= 0;
            foreach ($tracking_data as $Comp_data){ 
                $trackingdata[$i]["id"]               = $Comp_data->id; 
				$trackingdata[$i]["tracking_date"]               = $Comp_data->tracking_date;
                $i++;
            }
			
			$usedTracking =array();
			$FilterTrackinArray =array();
			foreach ( $trackingdata AS $key => $line ) { 
				if ( !in_array($line['tracking_date'], $usedTracking) ) { 
					$usedTracking[] = $line['tracking_date']; 
					$FilterTrackinArray[] = $line; 
				} 
			} 
								
			$FilterTrackinArray         = json_encode($FilterTrackinArray);
			 echo '{"Status":"true","Data":' . $FilterTrackinArray . '}';            
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }
    public function get_companies(){
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['company_id'])) {
            $where       = array(
                'account_owner' => $_REQUEST['company_id']
            );
            $result      = $this->apimodel->get_data('account', $where);
            $companydata = array();
            $i           = 0;
            foreach ($result as $Comp_data) {
                $companydata[$i]["id"]               = $Comp_data->id;
                $companydata[$i]["account_owner_id"] = $Comp_data->account_owner;
                $companydata[$i]["name"]             = $Comp_data->name;
                $companydata[$i]["phone"]            = $Comp_data->phone;
                $companydata[$i]["fax"]              = $Comp_data->fax;
                $companydata[$i]["parent_account"]   = $Comp_data->parent_account;
                $companydata[$i]["website"]          = $Comp_data->website;
                $companydata[$i]["gstin"]            = $Comp_data->gstin;
                $companydata[$i]["email"]            = $Comp_data->email;
                $companydata[$i]["employee"]         = $Comp_data->employee;
                $companydata[$i]["type"]             = $Comp_data->type;
                $companydata[$i]["industry"]         = $Comp_data->industry;
                $companydata[$i]["revenue"]          = $Comp_data->revenue;
                $companydata[$i]["description"]      = $Comp_data->description;
                $companydata[$i]["billing_street"]   = $Comp_data->billing_street;
                $companydata[$i]["billing_country"]  = $Comp_data->billing_country;
                $companydata[$i]["billing_state"]    = $Comp_data->billing_state;
                $companydata[$i]["billing_city"]     = $Comp_data->billing_city;
                $companydata[$i]["shipping_country"] = $Comp_data->shipping_country;
                $companydata[$i]["shipping_state"]   = $Comp_data->shipping_state;
                $companydata[$i]["shipping_city"]    = $Comp_data->shipping_city;
                $i++;
                // echo '{"Status":"true", "Data":{"result":"'.$ddd.'"}}';
            }
            $ddd = json_encode($companydata);
            echo '{"Status":"true","Data":' . $ddd . '}';
        }
    }
    
    public function create_leads(){
        $this->load->model('apimodel', '', true);
		//pre($_REQUEST);	
        if (isset($_REQUEST['user_id']) && $_REQUEST['signin_signout'] == '1' && isset($_REQUEST['company_id'])) {
            $lead_data['first_name']     = $_REQUEST['first_name'];
          //  $lead_data['last_name']      = $_REQUEST['last_name'];
            $lead_data['email']          = $_REQUEST['email'];
            $lead_data['phone_no']       = $_REQUEST['phone_no'];
            $lead_data['street']         = $_REQUEST['street'];
            $lead_data['country']        = $_REQUEST['country'];
            $lead_data['state']          = $_REQUEST['state'];
            $lead_data['city']           = $_REQUEST['city'];
            $lead_data['zipcode']        = $_REQUEST['zipcode'];
			$lead_data['latitude']      = $_REQUEST['latitude'];
			$lead_data['longitude']      = $_REQUEST['longitude'];
            $lead_data['company']        = $_REQUEST['company'];
            $lead_data['lead_source']    = $_REQUEST['lead_owner'];
            $lead_data['created_by_cid'] = $_REQUEST['company_id'];         
            $lead_data['created_by'] = $_REQUEST['user_id'];         
			//$lead_data['date'] = $_REQUEST['date'];
			$company_db_name              = $_REQUEST['company_db_name'];
			$config_app                   = switch_db_dinamico($company_db_name);
            $leads_data = $this->apimodel->insert_data($config_app,'leads', $lead_data);
            echo '{"Status":"true", "Data":[{"added_id":"' . $leads_data . '"}]}';
            
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }    
	public function create_realtime_location(){
        $this->load->model('apimodel', '', true);
		//pre($_REQUEST);	
        if (isset($_REQUEST['user_id']) && $_REQUEST['signin_signout'] == '1' && isset($_REQUEST['company_id'])) {
			$realtime_data['latitude']      = $_REQUEST['latitude'];
			$realtime_data['longitude']      = $_REQUEST['longitude'];
            $realtime_data['created_by_cid'] = $_REQUEST['company_id'];         
			$realtime_data['created_by'] = $_REQUEST['user_id'];
			$company_db_name              = $_REQUEST['company_db_name'];
			$config_app                   = switch_db_dinamico($company_db_name);
            $leads_data = $this->apimodel->insert_data($config_app,'realtime_location', $realtime_data);
            echo '{"Status":"true", "Data":[{"added_id":"' . $leads_data . '"}]}';
            
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }  
    public function get_realtime_location(){
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['company_id'])) {
       
            $result      = $this->apimodel->get_single_record('realtime_location', $_REQUEST['company_id']);
			$realtimedata     = array();
			$i              = 0;

			foreach ($result as $data) {	
				$company_data = $this->apimodel->getNameById('company_detail',$data['created_by_cid'],'id');
				$user_data = $this->apimodel->getNameById('user_detail',$data['created_by'],'u_id');

			/* 	if(isset($company_data->logo)){
					$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
				}else{
					$companyLogo = base_url().'assets/modules/company/uploads/locatin-icon.png';

                }	 */	
			if(!empty($user_data)){				
				$companyLogo = base_url().'assets/modules/company/uploads/locatin-icon.png';				
				$realtimedata[$i]['id']   = $data['id'];
				$realtimedata[$i]['latitude'] = $data['latitude'];
				$realtimedata[$i]['longitude']   = $data['longitude'];
				$realtimedata[$i]['user_id'] = $data['created_by'];
				$realtimedata[$i]['user_name']   = @$user_data->name;			
				$realtimedata[$i]['company_id']   = $data['created_by_cid'];			
				$realtimedata[$i]['company_logo']   = $companyLogo;
				$realtimedata[$i]['date'] = $data['created_date'];
				$i++;
				}
			}
				//pre($realtimedata); die;

            $realtimedata = json_encode($realtimedata);
            echo '{"Status":"true","Data":' . $realtimedata . '}';
        }
    }	
	public function get_leads(){
        $this->load->model('apimodel', '', true);
		//pre($_REQUEST);	
        if (isset($_REQUEST['user_id']) && $_REQUEST['signin_signout'] == '1' && isset($_REQUEST['company_id'])) {
       		$where = array();
            $where['created_by']   = $_REQUEST['user_id'];
            $where['created_by_cid'] = $_REQUEST['company_id'];
            $leads_data              = $this->apimodel->get_data('leads', $where);
			$leads_data         = json_encode($leads_data);
             echo '{"Status":"true","Data":' . $leads_data . '}';   
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }
    
    public function get_country(){
        $this->load->model('apimodel', '', true);
        $country_result = $this->apimodel->get_data('country');
        $contrydata     = array();
        $i              = 0;
        foreach ($country_result as $Cont_data) {
            
            $contrydata[$i]["country_id"]   = $Cont_data->country_id;
            $contrydata[$i]["country_name"] = $Cont_data->country_name;
            $i++;
        }
        $contry_DATA = json_encode($contrydata);
        echo '{"Status":"true","Data":' . $contry_DATA . '}';
    }
    
    
    public function get_state(){
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['country_id'])) {
            $where        = array(
                'country_id' => $_REQUEST['country_id']
            );
            $state_result = $this->apimodel->get_data('state', $where);
            $statedata    = array();
            $i            = 0;
            foreach ($state_result as $Cont_data) {
                
                $statedata[$i]["state_id"]   = $Cont_data->state_id;
                $statedata[$i]["state_name"] = $Cont_data->state_name;
                $i++;
            }
            $state_DATA = json_encode($statedata);
            echo '{"Status":"true","Data":' . $state_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send Country First"}]}';
        }
    }
    public function get_city(){
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['state_id'])) {
            $where      = array(
                'state_id' => $_REQUEST['state_id']
            );
            $cty_result = $this->apimodel->get_data('city', $where);
            $ctyedata   = array();
            $i          = 0;
            foreach ($cty_result as $Cont_data) {
                
                $ctyedata[$i]["city_id"]   = $Cont_data->city_id;
                $ctyedata[$i]["city_name"] = $Cont_data->city_name;
                $i++;
            }
            $ctr_DATA = json_encode($ctyedata);
            echo '{"Status":"true","Data":' . $ctr_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send state First"}]}';
        }
    }
    
    public function get_lead_owner(){
        $this->load->model('apimodel', '', true);
        if ($_REQUEST['signin_signout'] == '1' && isset($_REQUEST['company_id'])) {
            $where          = array(
                'c_id' => $_REQUEST['company_id'],
                'is_activated' => 1
            );
            $lead_owner_dtl = $this->apimodel->get_data('user_detail', $where);
            $leadowner_data = array();
            $i              = 0;
            foreach ($lead_owner_dtl as $lead_ownr_data) {
                
                $leadowner_data[$i]["u_id"]       = $lead_ownr_data->u_id;
                $leadowner_data[$i]["name"]       = $lead_ownr_data->name;
                $leadowner_data[$i]["company_id"] = $lead_ownr_data->c_id;
                $i++;
            }
            $lead_oner_DATA = json_encode($leadowner_data);
            echo '{"Status":"true","Data":' . $lead_oner_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send state First"}]}';
        }
    }
    
    
    public function lat_lng(){
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['user_id']) && $_REQUEST['signin_signout'] == '1' && isset($_REQUEST['company_id'])) {
            $lead_data['latitude']   = $_REQUEST['lat'];
            $lead_data['longitude '] = $_REQUEST['lng'];
            $leads_data              = $this->apimodel->insert_tbl_data('tbl_api_attendance', $lead_data);
            echo '{"Status":"true", "Data":[{"added_id":"' . $leads_data . '"}]}';
            
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Add Latitude & Longitude First."}]}';
        }
    }
    
    public function get_company_employe(){
        $this->load->model('apimodel', '', true);
        if (isset($_REQUEST['company_id'])) {
            $employee_data = $this->apimodel->get_user_by_cid('user_detail', 'c_id', $_REQUEST['company_id']);
            //echo '<pre>';print_r($employee_data);die();
            $comp_empdata  = array();
            $i             = 0;
            foreach($employee_data as $chk_emp_Data){
                $comp_empdata[$i]["name"]       = $chk_emp_Data['name'];
                $comp_empdata[$i]["email"]      = $chk_emp_Data['email'];
                $comp_empdata[$i]["contact_no"] = $chk_emp_Data['contact_no'];       
				$comp_empdata[$i]["u_id"]      = $chk_emp_Data['u_id'];
                $comp_empdata[$i]["company_id"] = $chk_emp_Data['c_id'];
                //$comp_empdata[$i]["Latitude"]   = '38.8833';
               // $comp_empdata[$i]["Longitude"]  = '77.0167';
                $i++;
            }
            $chk_data = json_encode($comp_empdata);
            echo '{"Status":"true","Data":' . $chk_data . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send company id First"}]}';
        }
    }
    
    public function get_employee_attendance(){
        $this->load->model('apimodel', '', true);
      if (isset($_REQUEST['emp_id'])  && isset($_REQUEST['created_by_cid']) && isset($_REQUEST['atten_date'])) {
             $attendance['emp_type']   = "";
             $attendance['working_hour']   = "";
             $attendance['place']   = "";
             $attendance['absence']   = "";
             $attendance['overtime']   = "";
             $attendance['earnleave']   = "";
             $attendance['status']   = "P";
             $attendance['card_no']   = "";
             $attendance['shift']   = "";
             $attendance['in_out_details']   = "";
             $attendance['created_by']   = "0";
             $attendance['emp_id']   = $_REQUEST['emp_id'];
             $biometric_id =   getNameById('user_detail',$_REQUEST['emp_id'],'u_id');;
             $attendance['biometric_id']   = @ $biometric_id->biometric_id ;
             $attendance['atten_date'] = $_REQUEST['atten_date'];
             $attendance['signout_time'] =  $_REQUEST['signout_time'];
             $attendance['signin_time'] =  $_REQUEST['signin_time'];
             $attendance['created_by_cid'] = $_REQUEST['created_by_cid'];
             $company_db_name              = $_REQUEST['company_db_name'];
             $config_app                   = switch_db_dinamico($company_db_name);
             if($attendance['signout_time'] == "")
             {
             $attendance['signout_time'] = "";
             $attendance['signin_time'] =  $_REQUEST['signin_time'];
             $where['emp_id']   = $_REQUEST['emp_id'];
             $where['atten_date '] = $_REQUEST['atten_date'];
             $where['created_by_cid '] = $_REQUEST['created_by_cid'];
            $signIn_count = $this->apimodel->check_attendance_signin('attendance', $where);
            if($signIn_count == 0) {  $attendances = $this->apimodel->insert_data($config_app,'attendance', $attendance);   }
             }
             if($attendance['signin_time'] == "")
             {
            $sign_out['signout_time'] = $_REQUEST['signout_time'];
        	$where = array();
            $where['emp_id']   = $_REQUEST['emp_id'];
            $where['atten_date '] = $_REQUEST['atten_date'];
            $where['created_by_cid '] = $_REQUEST['created_by_cid'];
           # print_r($where);die;
            $attendances   = $this->apimodel->update_data_multiple($config_app,'attendance', $sign_out, $where);
             }
           # echo '{"Status":"true", "Data":[{"added_id":"' . $attendances . '"}]}';
       echo '{"Status":"true", "Data":[{"added_id":"' . @ $attendances . '"}]}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Add Attendance First."}]}';
        }
    }
}