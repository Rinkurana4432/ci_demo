<?php
require APPPATH . '/libraries/CreatorJwt.php';
class Alfaapi extends ERP_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');
        $this->load->database();
        $this->load->helper('crm/crm');
    }
    public function login(){
        $json      = file_get_contents("php://input");
	    $data      = json_decode($json);
		
		    $username = $data->user;
	        $password = $data->password;
	     $this->load->model('alfaapimodel', '', true);
         $this->load->model('apimodel', '', true);
        if (isset($username) && isset($password)) {
            $result = $this->alfaapimodel->loginmodel($username, $password);
		
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
					$permissions = $this->alfaapimodel->fetch_user_premissions_by_id($config_app, $result->id, array(
                        'p.sub_module_id' => '215',
                        'p.user_id' => $result->id
                    ));
					$tokenData['timeStamp'] = Date('Y-m-d h:i:s');
					$jwtToken = $this->objOfJwt->GenerateToken($tokenData);
					$this->alfaapimodel->update_data($config_app, 'user',array('token'=>$jwtToken),'id',$result->id);
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
						"userToken" => $jwtToken,
                        'company_db_name' => $result->company_db_name
                    );
                    $ddd         = json_encode($user_data);
                    echo '{"Status":"true","Data":' . $ddd . '}';
                    //pre($ddd);
                }
            } else { 
                echo '{"Status":"false", "Data":[{"result":"The credentials you supplied were not correct"}]}';
            }
        }
	}
	public function AuthStockPermission(){
		 $this->load->model('alfaapimodel', '', true);
		if (isset($_REQUEST['email'])) {
		   $where = array('email'=>$_REQUEST['email']);
			$userDtl = $this->alfaapimodel->get_userDetails('user','email',$where);
			//pre($userDtl->id);
			$stockUsers = $this->alfaapimodel->get_userdata('stock_permission');
			$usersdata = json_decode($stockUsers->stock_permission);
			$userExist=0;
			foreach($usersdata as $stockuserID){
				if($stockuserID == $userDtl->id){
					$userExist=1;
				}
			}
			if($userExist==1){
				echo '{"Status":"true"}';
			}else{
				echo '{"Status":"false"}';
			}
				
			
						
			
	   } else {
            echo '{"Status":"false", "Data":[{"result":"Please Send Email ID."}]}';
        }
	}
  
  
   public function forgot_password(){
        $this->load->model('alfaapimodel', '', true);
          if (isset($_REQUEST['email'])){
            $findemail = $this->alfaapimodel->ForgotPassword($_REQUEST['email']);
			
            if($findemail){
                $data = $this->alfaapimodel->get_data_by('user','email',$findemail['email']); 
				
				  
              
                if(!empty($data)){
                    $randomNumberPass =  rand(100000000, 999999999);
                     $password = easy_crypt($randomNumberPass);
                    // $password = easy_crypt('admin@123');
                    $dataArray = array('password' => $password);
                  // pre($dataArray);die();
                    if($data->role==3){
                        #echo 'in role 3 '; die;
                       $udatedData = $this->alfaapimodel->update_data_Email('user',$dataArray,'email',$_REQUEST['email']);
                    }else{
                 
                       $udatedData = $this->alfaapimodel->update_data_Email('user',$dataArray,'email',$_REQUEST['email'],'companyDbExist',$data->company_db_name) ;
					  
                        #die;
                    }
                    $email_message = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
                                    <td class="content" align="left" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white; margin: 0; padding: 60px 35px;" bgcolor="white">
                                        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi ,</p>                               
                                        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Thanks for contacting regarding to forgot password,</p>
                                        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Your password is:'.$randomNumberPass.'</p>
                                        <p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Please Update your password.</p>                                           
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>'; 
					$sub  = 'Your Password';
                    if(email_send($_REQUEST['email'],$sub,$email_message)){
                         echo '{"Status":"true", "Data":[{"result":"Your New password is sent on your email address."}]}';
                     }else{
                        echo '{"Status":"false", "Data":[{"result":"Email Not Send."}]}'; 
                    }                                       
                    
            } 
                  
                  
              }else{
                 echo '{"Status":"false", "Data":[{"result":"Please Check Your Email."}]}'; 
              }
             }else{
                echo '{"Status":"false", "Data":[{"result":"Please Enter Your Email First."}]}';
            }
    }
	
    public function country_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        $where = array();
        $country_result = $this->alfaapimodel->get_data('country', $where, $config_app);
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


    public function state_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['country_id'])) {
            $where        = array(
                'country_id' => $_REQUEST['country_id']
            );
            $state_result = $this->alfaapimodel->get_data('state', $where, $config_app);
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
    public function city_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['state_id'])) {
            $where      = array(
                'state_id' => $_REQUEST['state_id']
            );
            $cty_result = $this->alfaapimodel->get_data('city', $where, $config_app);
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

    public function customer_type_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['created_by_cid'])) {
            $where      = array(
                'created_by_cid' => $_REQUEST['created_by_cid']
            );
            $customer_type_result = $this->alfaapimodel->get_data('types_of_customer', $where, $config_app);
            $customer_typedata   = array();
            $i          = 0;
            foreach ($customer_type_result as $Cont_data) {

                $customer_typedata[$i]["id"]   = $Cont_data->id;
                $customer_typedata[$i]["type_of_customer"] = $Cont_data->type_of_customer;
                $i++;
            }
            $customer_DATA = json_encode($customer_typedata);
            echo '{"Status":"true","Data":' . $customer_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send Created by Compeny id"}]}';
        }
    }

    public function company_name_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['account_owner'])) {
            $where      = array(
                //'account_owner' => $_REQUEST['account_owner']
                'created_by' => $_REQUEST['account_owner']
            );
            $company_result = $this->alfaapimodel->get_data('account', $where, $config_app);
			// pre($company_result);die();
            $company_DATA = json_encode($company_result);
            echo '{"Status":"true","Data":' . $company_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send account owner id"}]}';
        }
    }

    public function varient_type_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        $where = array();
        $variant_types_result = $this->alfaapimodel->get_data('variant_types', $where, $config_app);
        $variant_DATA = json_encode($variant_types_result);
        echo '{"Status":"true","Data":' . $variant_DATA . '}';
    }

    public function variant_code_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['variant_type_id'])) {
            $where      = array(
                'variant_type_id' => $_REQUEST['variant_type_id']
            );
            $variant_code_result = $this->alfaapimodel->get_data('variant_options', $where, $config_app);
            // pre($variant_code_result);
            // die;
            foreach ($variant_code_result as $key => $variant_code) {
            if(!empty($variant_code->option_img_name)){
            $image_url = base_url().'assets/modules/inventory/varient_opt_img/'.$variant_code->option_img_name;
            $variant_code_result[$key]->option_img_name = $image_url; 
            }
            }
            //pre($variant_code_result);
            $variant_code_DATA = json_encode($variant_code_result);
            //die;
            echo '{"Status":"true","Data":' . $variant_code_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send variant type id"}]}';
        }
    }

    public function material_data(){
        $this->load->model('alfaapimodel', '', true);
        $this->load->model('apimodel', '', true);
        $config_app  = switch_db_dinamico('alfa_child_db');
        $json      = file_get_contents("php://input");
        $data      = json_decode($json);
        $mat_name = $data->product_code.'_'.implode('_', $data->variation);
        $mat_details = $this->alfaapimodel->getNameById('material', $mat_name, 'material_name', $config_app);
        if(!empty($mat_details->packing_data)){
				$packing_data = json_decode($mat_details->packing_data);
				$standard_packing = $mat_details->standard_packing;
				$cbf = $weight = 0;
				foreach ($packing_data as $key => $packing_value) {
					$packing_qty = $packing_value->packing_qty;
					$packing_cbf = $packing_value->packing_cbf;
					$packing_weight = $packing_value->packing_weight;
					$cbf += (int)$packing_cbf*(int)$packing_qty;
					$weight += (int)$packing_weight*(int)$packing_qty;
				}
				if ($cbf > 0 && $standard_packing > 0 ){
					$total_cbf = round($cbf/$standard_packing, 2);    
				} else {
					$total_cbf = 0;    
				}
				if ($weight > 0 && $standard_packing > 0 ){
					$total_weight = round($weight/$standard_packing, 2);    
					} else {
					$total_weight = 0;    
				}
			} else {
				$total_cbf = $total_weight = 0;
        }
		
		       $uomdata = $this->alfaapimodel->getNameById_using_modal('uom',$mat_details->uom,'id',$config_app);
			   
			   $attachments = $this->alfaapimodel->get_image_by_materialId('attachments', 'rel_id', $mat_details->id, $config_app);
               if(!empty($attachments->file_name)){
			   $mat_details->img_path = base_url().'assets/modules/inventory/uploads/'.$attachments->file_name;
               } else {
               $mat_details->img_path = ''; 
               }
			   $mat_details->total_cbf_new = $total_cbf;
			   $mat_details->total_weight = $total_weight;
			   $mat_details->uomName = $uomdata->uom_quantity;
			   $mat_DATA = json_encode($mat_details);
				echo '{"Status":"true","Data":' . $mat_DATA . '}';
      
    }
	
    public function cutomer_creation(){
        $this->load->model('alfaapimodel', '', true);
        $this->load->model('apimodel', '', true);
        $config_app  = switch_db_dinamico('alfa_child_db');
        $json      = file_get_contents("php://input");
        $data      = json_decode($json);
        $address = $data->new_billing_address;
        $id = $data->id;
        $dataLedger['name'] = $data->name;
        $dataLedger['email'] = $data->email;
        $dataLedger['phone_no'] = $data->phone;
        $dataLedger['gstin'] = $data->gstin;
        $dataLedger['account_group_id'] = '54';
        $dataLedger['parent_group_id'] = '6';
        $dataLedger['website'] = $data->website;
        $dataLedger['save_status'] = $data->save_status;
        $company_details = $this->alfaapimodel->getNameById('company_detail', $this->companyGroupId, 'id', $config_app);
        if($company_details->ledger_crdit_limtOnOff == 1){
        if($data->temp_credit_limit == '' || $data->temp_credit_limit == '1970-01-01'){
        $Temdate = '';
        }else{
        $Temdate = $data['temp_crlimitDate'] = date("Y-m-d", strtotime($data->temp_crlimitDate));;
        }
        $dataLedger['purchaseLimit'] = $data->purchaseLimit;
        $dataLedger['temp_credit_limit'] = $Temdate;
        $dataLedger['temp_crlimitDate'] =  date("Y-m-d", strtotime($data->temp_crlimitDate));
        }

        $dataLedger['areastation'] = $data->areastation;
        @$dataLedger['due_days'] = $data->due_days;
        $dataLedger['delarType'] = $data->type;
        $dataLedger['conn_comp_id'] = 0;
        $dataLedger['compny_branch_id'] = 0;
        $dataLedger['opening_balance'] = 0;
        $dataLedger['created_by_cid'] = $this->companyGroupId;

        $billing_address = $shipping_address = array();
		
        foreach ($address as $key => $address_value) {
			
        if($address_value->address_type == "shipping") {
			$shipping_address[$key]['shipping_company_1'] = $address_value->billing_company_1;
			$shipping_address[$key]['shipping_street_1'] = $address_value->billing_street_1;
			//$shipping_address[$key]['shipping_country_1'] = $address_value->billing_country_1;
			$shipping_address[$key]['shipping_country_1'] = '101';
			$shipping_address[$key]['shipping_state_1'] = $address_value->billing_state_1;
			$shipping_address[$key]['shipping_city_1'] = $address_value->billing_city_1;
			$shipping_address[$key]['shipping_zipcode_1'] = $address_value->billing_zipcode_1;
			$shipping_address[$key]['shipping_phone_addrs'] = $address_value->billing_phone_addrs;
			$shipping_address[$key]['same_shipping'] = $address_value->same_shipping;
			$shipping_address[$key]['address_type'] = $address_value->address_type;
			$shipping_address[$key]['country_name'] = $address_value->country_name;
			$shipping_address[$key]['state_name'] = $address_value->state_name;
			$shipping_address[$key]['city_name'] = $address_value->city_name;
        }
        if($address_value->address_type == "billing"){
			$billing_address[] = $address[$key];
        }
        }
		// pre($data);die();
        $created_by = $data->created_by;
        $owner = $data->account_owner;
        $shipping_address = json_decode(json_encode(array_values($shipping_address)));
        $address_array = json_encode($billing_address);
        $saddress_array = json_encode($shipping_address);
        $data->new_billing_address = $address_array;
        $data->new_shipping_address = $saddress_array;
        $data = json_decode(json_encode($data), true);
		
		
        $dataLedger['new_billing_address'] = $address_array;
        $dataLedger['type_of_customer'] = $data->type_of_customer;
        $dataLedger['contact_name'] = $data->contact_name;
        if ($id && $id != '') {
        $account_ledgerID = $this->alfaapimodel->getNameById('account', $id, 'id', $config_app);
        $data['edited_by'] = $created_by;
        $data['created_by'] = $created_by;
        $data['salesPersons'] = 0;
        // $data['sales_area'] = '';
        $data['api_data'] = $json;
        $success = $this->alfaapimodel->update_data_customer($config_app, 'account', $data, 'id', $id);
        $dataLedger['customer_id'] = $id;
        $dataLedger['edited_by'] = $created_by;
        $this->alfaapimodel->update_data_customer($config_app, 'ledger', $dataLedger, 'id', $account_ledgerID->ledger_id);
        if ($success) {
        echo '{"Status":"true", "Data":[{"result":"Company updated successfully"}]}';
        }
        } else {
        $checkEmail = $this->alfaapimodel->emailExist($data->email, trim($data->name), trim($data->phone));
        if (empty($checkEmail)) {
        $data['created_by'] = $created_by;
        $data['salesPersons'] = 0;
		 // $data['sales_area'] = '';
        $data['api_data'] = $json;
// pre($data);die();        
        $id = $this->alfaapimodel->insert_tbl_data($config_app, 'account', $data);
        $data['created_by'] = $created_by;
        $dataLedger['customer_id'] = $id;
        $dataLedger['created_by'] = $created_by;
        $dataLedger['edited_by'] = $created_by;
        $dataLedger['created_by_cid'] = $owner;
        $ledger_id=$this->alfaapimodel->insert_tbl_data($config_app, 'ledger', $dataLedger);
        $data2=array('ledger_id'=>$ledger_id);
        $this->alfaapimodel->update_single_value_data($config_app, 'account', $data2, array('id'=> $id));
        if ($id) {
			// pre($data);die();
			$reversdata = array(
							'buyerid'=>$id,	
							'buyername'=>$data['name'],	
							'buyerphone'=>$data['phone'],	
							);
			$reversdata2 = json_encode($reversdata);
        // echo '{"Status":"true", "Data":[{"result":"New Company Created"}]}';
			echo '{"Status":"true", "Data":[{"result":"New Company Created"}],"userData":'.$reversdata2.'}';
        }
        } else {
        echo '{"Status":"false", "Data":[{"result":"Email ,Phone No. already exist"}]}';
        die;
        }
        }

    }

    public function pi_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['created_by_cid'])) {
            $where      = array(
               // 'created_by_cid' => $_REQUEST['created_by_cid']
                'created_by' => $_REQUEST['created_by_cid']
            );
            $pi_results = $this->alfaapimodel->get_data('proforma_invoice', $where, $config_app);
            foreach ($pi_results as $key => $pi_result) {
				$matdtl = json_decode($pi_result->product);
				$matname = array();
				$UOMNamedata = array();
				foreach($matdtl as $matdata){
					
					$productname = $this->alfaapimodel->getNameById('material', $matdata->product, 'id', $config_app);
					$matname[] = $productname->material_name;
					$uomName = $this->alfaapimodel->getNameById('uom', $matdata->uom, 'id', $config_app);
					$UOMNamedata[] = $uomName->uom_quantity;
				}
				$account = $this->alfaapimodel->getNameById('account', $pi_result->account_id, 'id', $config_app);
				$name = $account->name;
				$phone = $account->phone;
				$pi_results[$key]->buyer_name = $name; 
				$pi_results[$key]->buyer_phone = $phone;
				$pi_results[$key]->matName = $matname;
				$pi_results[$key]->uomName = $UOMNamedata;
            }
			
            $pi_DATA = json_encode($pi_results);
            echo '{"Status":"true","Data":' . $pi_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send created by cid"}]}';
        }
    }
	 public function Get_product_codeName(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
		$where      = array(
                'status' => 1,
			);
			$prdtData = [];
			$product_code_result = $this->alfaapimodel->get_data('material_variants', $where, $config_app);
           foreach ($product_code_result as $key => $product_result) {
			  	$prdtData[] = array(
									'id'=> $product_result->id,
									'product_code'=> $product_result->item_code,
									'temp_material_name'=> $product_result->temp_material_name,
									);
			
            }
              $prdtData_result = json_encode($prdtData);
             echo '{"Status":"true","Data":' . $prdtData_result . '}';
	 }	

    public function product_code_list(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
		    $product_id = $_REQUEST['id'];
			$product_code = $_REQUEST['product_code'];
            $where      = array(
                'status' => 1,
			);
			$where = array('created_by_cid' => $_REQUEST['created_by_cid'], 'status' => 1, 'product_code' => $product_id, 'non_inventry_material' => 0);
			
			$materials = $this->alfaapimodel->get_data('material', $where, $config_app);
			$variants = $this->alfaapimodel->getNameById_using_modal('material_variants',$product_id,'id',$config_app);
			$variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
			$variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
			$variantKeyCount = count($variant_key);
				// foreach($materials as $material){
				// 	$explodeArray = !empty($material->material_name) ? explode('_', $material->material_name):array(); 
				// 	for($t=1; $t<=$variantKeyCount; $t++){
				// 		$variant_option[] =  $explodeArray[1];
				// 	}
				// }
				
				
				
				//$variant_option_set = array_values(array_unique($variant_option));
				$set_array = array();
				    //$variant_option_set = "";
                    foreach ($variants_data['variant_key'] as $key2 => $variants_value){
                    $variant_option = array();
                    foreach ($variants_value as $key3 => $value) {
                foreach($materials as $key=> $material){
                    $explodeArray = !empty($material->material_name) ? explode('_', $material->material_name):array(); 
                    for($t=1; $t<=$variantKeyCount; $t++){
                        $variant_option[] =  $explodeArray[$key2];
                    }
                    
					}	
                    $variant_option_set = array_values(array_unique($variant_option));
                        $set_array[] = array(
                                'key' => $value,
                                'value' => implode(",",$variant_option_set)
                            ); 
						}
				}
              $changedata = json_encode($set_array);
             $variants->variants_data = $changedata;
             $product_code_DATA = json_encode($variants);
             echo '{"Status":"true","Data":' . $product_code_DATA . '}';
    }
	
	public function product_code_liste(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
		    // $product_id = $_REQUEST['id'];
			// $product_code = $_REQUEST['product_code'];
            $where      = array(
                'status' => 1,
			);
			// $where = array('created_by_cid' => $_REQUEST['created_by_cid'], 'status' => 1, 'product_code' => $product_id, 'non_inventry_material' => 0);
			// $materials = $this->alfaapimodel->get_data('material', $where,$config_app);
			
			// $variant_option = array();
			// foreach($materials as $material){
				
				// $explodeArray = !empty($material->material_name) ? explode('_', $material->material_name):array(); 
			
				// for($t=1; $t<=$variantKeyCount; $t++){
					// $variant_option[] =  $explodeArray[1];
				// }
			// }
			
            $product_code_result = $this->alfaapimodel->get_data('material_variants', $where, $config_app);
           foreach ($product_code_result as $key => $product_result) {
			  // pre($product_result);
            $variants_data =  json_decode($product_result->variants_data, true);
            $set_array = array();
			
			$variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
			$variantKeyCount = count($variant_key);
			
            foreach ($variants_data['variant_key'] as $key2 => $variants_value) {
			foreach ($variants_value as $key3 => $value) {
					
			          $set_array[] = array(
						'key' => $value,
						//'value' => implode(",",$variants_data['variant_value'][$key2])
						'value' => implode(",",$variants_data['variant_value'][$key2])
						); 
						
						
						
					}
            }
            
			
			// die();
            $changedata = json_encode($set_array);
            $product_code_result[$key]->variants_data = $changedata;
            }
            $product_code_DATA = json_encode($product_code_result);
            echo '{"Status":"true","Data":' . $product_code_DATA . '}';
					
		
		
	}	

    public function discount_rate(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['type']) && isset($_REQUEST['buyer'])) {
          $calcDiscount_val = $_REQUEST['type'];
        $customerval = $_REQUEST['buyer'];
        $account_data = $this->alfaapimodel->getNameById('account', $customerval, 'id', $config_app);
        $type_of_customer = $account_data->type_of_customer;
        $type_of_customer_data = $this->alfaapimodel->getNameById('types_of_customer', $type_of_customer, 'id',  $config_app);
        echo '{"Status":"true","Data":' . $type_of_customer_data->$calcDiscount_val . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send type and buyer"}]}';
        }
        }

    public function pi_creation(){
        $this->load->model('alfaapimodel', '', true);
        $this->load->model('apimodel', '', true);
        $config_app  = switch_db_dinamico('alfa_child_db');
        $json      = file_get_contents("php://input");
        $data      = json_decode($json, true);

  // pre($data);die(); 

        $products = count($data['product']);
        $comp_id = $_POST['account_id'];
        if ($products > 0) {
        $arr = [];
        $i = 0;
        while ($i < $products) {
        $material_type_id = $this->alfaapimodel->getNameById('material_variants', $data['material_type_id'][$i], 'id', $config_app);
        $jsonArrayObject = array('product_code' => $data['material_type_id'][$i], 'code_name' => $material_type_id->item_code,'product' => $data['product'][$i], 'pro_img' => $data['pro_img'][$i], 'description' => $data['description'][$i], 'quantity' => $data['qty'][$i], 'uom' => $data['uom'][$i], 'price' => $data['price'][$i], 'gst' => $data['gst'][$i], 'individualTotal' => $data['totals'][$i], 'individualTotalWithGst' => $data['TotalWithGsts'][$i]);
        $arr[$i] = $jsonArrayObject;
        $i++;
        }
        $product_array = json_encode($arr);
        } else {
        $product_array = '';
        }
		// $last_id = getLastTableId('proforma_invoice');
		$last_id = getLastTableId_dynamic('proforma_invoice',$config_app);
		$rId = $last_id + 110;
		$piCode = 'PIR_' . rand(1, 1000000) . '_' . $rId;
		
        $data['pi_paymode'] = json_encode($data['pi_paymode']);
        $data['created_by'] = $data['loggedUser'];
        $data['created_by_cid'] = 1;
        $data['product'] = $product_array;
        $data['material_type_id'] = json_encode($data['material_type_id']);
       
        $data['discount_offered'] = isset($data['discount_offered']) ? json_encode($data['discount_offered']) : '';
        $data['dispatch_documents'] = isset($data['dispatch_documents']) ? json_encode($data['dispatch_documents']) : '';
        $data['pi_remarks'] = isset($data['pi_remarks']) ? $data['pi_remarks'] : '';
        $data['apply_comment'] = isset($data['apply_comment']) ? $data['apply_comment'] : '';
        $data['special_discount_authorized'] = $data['special_discount_authorized'];
		 
       
        $id = $data['id'];
        if ($id && $id != '') {
					$data_log['apply_comment'] = $data['apply_comment'];
					$data_log['userid'] = $data['account_id'];
					$data_log['rel_type'] = 'Proforma Invoice';
					$data_log['rel_id'] = $id;
					$data_log['date'] = date("d/m/Y");
					$this->alfaapimodel->insert_tbl_data_pi($config_app, 'pi_comment_log', $data_log);
			
			//$data['pi_code'] = ($data['pi_code'] != '') ? $data['revised_po_code'] : '';
			$data['pi_code'] = $data['pi_code'].'_2(Revised)';
			
        $success = $this->alfaapimodel->update_data_pi($config_app, 'proforma_invoice', $data, 'id', $id);
        if ($success) {
        echo '{"Status":"true", "Data":[{"result":"Proforma Invoice Updated"}]}';
        }
        } else {
			 $data['pi_code'] = ($piCode != '') ? $piCode : '' ;
        $id = $this->alfaapimodel->insert_tbl_data_pi($config_app, 'proforma_invoice', $data);
					$data_log['apply_comment'] = $data['apply_comment'];
					$data_log['userid'] = $data['account_id'];
					$data_log['rel_type'] = 'Proforma Invoice';
					$data_log['rel_id'] = $id;
					$data_log['date'] = date("d/m/Y");
					$this->alfaapimodel->insert_tbl_data_pi($config_app, 'pi_comment_log', $data_log);
        if ($id) {
        echo '{"Status":"true", "Data":[{"result":"New Porforma Invoice Created"}]}';
        }
        }
    }
        public function pi_detail_by_id(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['pi_id'])) {
            $where      = array(
                'id' => $_REQUEST['pi_id']
            );
            $pi_detail_result = $this->alfaapimodel->get_data('proforma_invoice', $where, $config_app);
            $pi_detail_DATA = json_encode($pi_detail_result);
            echo '{"Status":"true","Data":' . $pi_detail_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send proforma invoice id"}]}';
        }
    }

        public function material_type_list(){
            $config_app  = switch_db_dinamico('alfa_child_db');
            $this->load->model('alfaapimodel', '', true);
            $material_type_result = $this->alfaapimodel->get_mat_list('material_type', $config_app);
            $material_type_DATA = json_encode($material_type_result);
            echo '{"Status":"true","Data":' . $material_type_DATA . '}';
        }

        public function stock_permission(){
            $config_app  = switch_db_dinamico('alfa_child_db');
            $this->load->model('alfaapimodel', '', true);
            $where = array();
            $stock_permission_result = $this->alfaapimodel->get_data('stock_permission', $where, $config_app);
            $stock_permission_DATA = $stock_permission_result[0]->stock_permission;
            echo '{"Status":"true","Data":' . $stock_permission_DATA . '}';
        }

        public function stock_details(){
            // ini_set('display_errors', 1);
            // ini_set('display_startup_errors', 1);
            // error_reporting(E_ALL);
            $config_app  = switch_db_dinamico('alfa_child_db');
            $this->load->model('alfaapimodel', '', true);
            $c_id      =  $_REQUEST['created_by_cid'];
            $stock_details_result = $this->alfaapimodel->get_stock_data('material', $c_id, $config_app);
            $set_mat_array = array();
            foreach ($stock_details_result as $key => $stock_value) {
				
				$uomdata = $this->alfaapimodel->getNameById_using_modal('uom',$stock_value->uom,'id',$config_app);
				$matQty = $this->alfaapimodel->getNameById_using_modalWithArray('mat_locations',$stock_value->id,'material_name_id',$config_app);
				$sumttl = 0;
                 if(!empty($matQty)){ 
				 foreach ($matQty as $matQtyval) {
					$sumttl += $matQtyval['quantity'];
					}
				}
				
				$set_mat_array[] = array(
					'item_code'  => $stock_value->item_code,
					'material_name' => $stock_value->material_name,
					//'closing_balance' => $stock_value->closing_balance,
					'closing_balance' => $sumttl,
					'uom' => $stock_value->uom,
					'uomName' => $uomdata->uom_quantity
				); 
            }
			 // die();
            $stock_details_DATA = json_encode($set_mat_array);
            echo '{"Status":"true","Data":' . $stock_details_DATA . '}';
        }

        public function stock_filter(){
        $config_app  = switch_db_dinamico('alfa_child_db');
        $this->load->model('alfaapimodel', '', true);
        if (isset($_REQUEST['filter'])) {
            $where      = array(
                'material_type_id' => $_REQUEST['filter'],
				'status' => 1
            );
            $stock_filter_result = $this->alfaapimodel->get_data('material', $where, $config_app);
			
			$set_mat_array = array();
		   
				foreach ($stock_filter_result as $key => $stock_value) {
					$uomdata = $this->alfaapimodel->getNameById_using_modal('uom',$stock_value->uom,'id',$config_app);
					$matQty = $this->alfaapimodel->getNameById_using_modalWithArray('mat_locations',$stock_value->id,'material_name_id',$config_app);
					//pre($matQty);
						$sumttl = 0;
						 if(!empty($matQty)){ 
						 foreach ($matQty as $matQtyval) {
							$sumttl += $matQtyval['quantity'];
							}
						}
					$set_mat_array[] = array(
					'item_code'  => $stock_value->item_code,
					'material_name' => $stock_value->material_name,
					//'closing_balance' => $stock_value->closing_balance,
					'closing_balance' => $sumttl,
					 'uom' => $stock_value->uom,
					 'uomName' =>  $uomdata->uom_quantity
					
					); 
				}
				// die();
            $stock_filter_DATA = json_encode($set_mat_array);
            echo '{"Status":"true","Data":' . $stock_filter_DATA . '}';
        } else {
            echo '{"Status":"false", "Data":[{"result":"Pleaes send material type id"}]}';
        }
    }

	   public function customer_listUnderSalesperson(){
        $this->load->model('alfaapimodel', '', true);
        if ($_REQUEST['signin_signout'] == '1' && isset($_REQUEST['company_id']) && isset($_REQUEST['token'])) {
			
			$company_db_name              = $_REQUEST['company_db_name'];
			
			
			
			$config_app                   = switch_db_dinamico($company_db_name);
			
		
			$data = $this->alfaapimodel->getNameById_using_modal('user',$_REQUEST['token'],'token',$config_app);
			
			
			if($data->token != $_REQUEST['token']){
				echo '{"Status":"false", "Data":[{"result":"Token Not Matched"}]}';
                    return false;
                }
				
            $where          = array(
                'c_id' => $_REQUEST['company_id'],
                'is_activated' => 1
            );
            $lead_owner_dtl = $this->alfaapimodel->get_data('user_detail', $where);
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
	
	
	 public function user_attend_timein(){
        $this->load->model('alfaapimodel', '', true);
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
                $inserted_id = $this->alfaapimodel->insert_tbl_data('tbl_api_attendance', $signin_data);
                echo '{"Status":"true", "Data":[{"login_id":"' . $inserted_id . '","time_in":"' . date('Y-m-d h-i-s') . '"}]}';
            }
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }
    
    public function user_attend_timeout(){
        $this->load->model('alfaapimodel', '', true);
        date_default_timezone_set('Asia/Kolkata');
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['company_id']) && isset($_REQUEST['login_id']) && $_REQUEST['signin_signout'] != '') {
            if ($_REQUEST['signin_signout'] == '0') {
                $sign_out['user_id']        = $_REQUEST['user_id'];
                $sign_out['c_id']           = $_REQUEST['company_id'];
                $sign_out['signin_signout'] = 0;
                $sign_out['time_out']       = date('Y-m-d h-i-s');
                $return_val                 = $this->alfaapimodel->update_data('tbl_api_attendance', $sign_out, 'id', $_REQUEST['login_id']);
                echo '{"Status":"true", "Data":[{"Timout":"' . date('Y-m-d h-i-s') . '"}]}';
            }
        } else {
            echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
        }
    }
	
	
	
	 public function sales_area_list(){
            $config_app  = switch_db_dinamico('alfa_child_db');
            $this->load->model('alfaapimodel', '', true);
            $sales_area = $this->alfaapimodel->get_mat_list('sales_area', $config_app);
            $sales_area_DATA = json_encode($sales_area);
            echo '{"Status":"true","Data":' . $sales_area_DATA . '}';
        }
	
	 public function get_materialData(){
       $config_app  = switch_db_dinamico('alfa_child_db');
	   $this->load->model('alfaapimodel', '', true);
	   if (isset($_REQUEST['mat_id'])  && isset($_REQUEST['created_by_cid'])) {
		   $where = array('id'=>$_REQUEST['mat_id']);
			$material = $this->alfaapimodel->get_materialDetails('material','id',$where, $config_app);
			
			$matDetails = array(
							'packgingData'=> $material->packing_data,	
							'Standardpackging'=> $material->standard_packing	
								);
			$matdat	= json_encode($matDetails);
				 echo '{"Status":"true", "Data":'.$matdat.'}';				
			
	   } else {
            echo '{"Status":"false", "Data":[{"result":"Please Send Material ID."}]}';
        }
	 }
	 
	 
	  public function genratePDFbakup(){
       $config_app  = switch_db_dinamico('alfa_child_db');
	   $this->load->model('alfaapimodel', '', true);
	   if (isset($_REQUEST['PI_id'])  && isset($_REQUEST['created_by_cid'])) {
		   
		  $this->load->library('Pdf');
		   $dataPdf = $this->alfaapimodel->getNameById_using_modal('proforma_invoice',$_REQUEST['PI_id'],'id',$config_app);
		   
		         
		   $obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
				$obj_pdf->SetCreator(PDF_CREATOR);  
				$obj_pdf->SetTitle("Proforma Invoice");  
				$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
				$obj_pdf->SetDefaultMonospacedFont('helvetica');  
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
				$obj_pdf->setPrintHeader(false);  
				$obj_pdf->setPrintFooter(false);  
				$obj_pdf->SetAutoPageBreak(TRUE, 10);  
				$obj_pdf->SetFont('helvetica', '', 11);
				
				$company_data = $this->alfaapimodel->getNameById_using_modal('company_detail',$_REQUEST['created_by_cid'],'id',$config_app);
				$bank_info = json_decode($company_data->bank_details);
				$primarybnk  = $bank_info[0];
				$image = base_url().'assets/modules/crm/uploads/alfalogo.jpg';
				$obj_pdf->Image($image,2,4,10,10,'PNG');
				$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
				$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
				$obj_pdf->AddPage(); 	
				$content = ''; 
				$ci =& get_instance();
				
				
				
				 			
				if($company_data->address != ''){
						$companyAddress = json_decode($company_data->address);
						$countryName = $this->alfaapimodel->getNameById_using_modal('country',$companyAddress[0]->country,'country_id',$config_app);			
						$stateName = $this->alfaapimodel->getNameById_using_modal('state',$companyAddress[0]->state,'state_id',$config_app);	
						$ctyName = $this->alfaapimodel->getNameById_using_modal('city',$companyAddress[0]->city,'city_id',$config_app);
						
						$companyAddress = 'Address: '.$companyAddress[0]->address.', Country: '.$countryName->country_name.', State: '.$stateName->state_name.', City: '.$ctyName->city_name.', Pincode: '.$companyAddress[0]->postal_zipcode;
					}else{
						$companyAddress = '';
					}


					
					$accountData = $this->alfaapimodel->getNameById_using_modal('account',$dataPdf->account_id,'id',$config_app);
					$contactData = $this->alfaapimodel->getNameById_using_modal('contacts',$dataPdf->contact_id,'id',$config_app);	
					
					$products =  json_decode($dataPdf->product);
					
					$max_val_chk = array();
					foreach($products as $product){
					
					$matData = $this->alfaapimodel->getNameById_using_modal('material',$product->product,'id',$config_app);
					$mat_name = $matData->material_name;
					$chunks = explode('_', $mat_name);
					$max_val_chk[] = count($chunks);	
					}
					
					$discount_offered = json_decode($dataPdf->discount_offered);
					$discount_offeredHtml = '';
					if(!empty($discount_offered)){
						foreach($discount_offered as $do){
							$discount_offeredHtml .=$do.',';	
						}	
							$discount_offeredHtml = substr_replace($discount_offeredHtml ,"", -1);
					}	
					$dispatch_documents = json_decode($dataPdf->dispatch_documents);
					$dispatch_documentsHtml = '';
					if(!empty($dispatch_documents)){
					foreach($dispatch_documents as $dd){
						$dispatch_documentsHtml .=$dd.',';	
					}	
						$dispatch_documentsHtml = substr_replace($dispatch_documentsHtml ,"", -1);
					}
					
					

				// Start Proforma Invoice number
				// $last_id = getLastTableId('proforma_invoice');
				// $rId = $last_id + 110;
				// $piCode = 'PIR_' . rand(1, 1000000) . '_' . $rId;
				/************** Revised Purchase order generation ******************/
				$currentRevisedPIChar = 'A';
				$nextRevisedPIChar = chr(ord($currentRevisedPIChar) + 1);
				$revisedPOCode = '';
				$revisedPICode = '';
				if ($dataPdf && $dataPdf->save_status == 1) {
					if($dataPdf->pi_code == ''){
						echo " ";
					}else{
						$pi_code_array = explode('_', $dataPdf->pi_code, 4);
				//pre($pi_code_array);
				//	foreach ($pi_code_array as $key => $value) {
				//	echo "pi_code_array[".$key."] = ".$value."<br>";
				//	}
				// pre();

						// if($pi_code_array[2] == ''){
						if(count($pi_code_array) < 3){
							$currentRevisedPIChar = 'A';
							#$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1);
							$revisedPICode = $dataPdf->pi_code.'_'.$currentRevisedPIChar.'(Revised)';
						}else if($pi_code_array[2] != ''){
							#echo $po_code_array[2];
							$orignalOrderCode = $pi_code_array[0].'_'.$pi_code_array[1].'_'.$pi_code_array[2];
							$currentRevisedPIChar = explode('(', $pi_code_array[2], 1);
							$nextRevisedPIChar = chr(ord($currentRevisedPIChar[0]) + 1);
							$revisedPICode = $orignalOrderCode.'_'.$nextRevisedPIChar.'(Revised)';
						}
					}
				}
				// echo $piCode;
				// die;
				// End Proforma Invoice number

				// Get terms and conditions
			
				$termsAndCondition = $this->alfaapimodel->get_PDF_data('termscond',$config_app);
				// pre($termsAndCondition);die();
				
				$variantTypes =	$this->alfaapimodel->get_PDF_data('variant_types',$config_app);;
			
				$variantImages = $this->alfaapimodel->get_PDF_data('variant_options',$config_app);;
				
				$variantImages = $this->alfaapimodel->get_PDF_data('material_variants',$config_app);
				$packing_data1 = 0;
				$matIDD = 0;
				foreach($variantImages as $mages ){
					if(!empty(json_decode($mages['packing_data']))){
						$packing_data = json_decode($mages['packing_data']);
				foreach($packing_data as $pp){
					$packing_data1 .= $pp->packing_mat;
					if(!empty($packing_data1)){
						$matIDD = $mages['id'];
						}
					}
					}
				}
				#echo $packing_data1;

				// pre($dataPdf);  die();
					
					$accountdata = $this->alfaapimodel->getNameById_using_modal('account',$dataPdf->account_id,'id',$config_app);
					$billingdata = json_decode($accountdata->new_billing_address);

				$content = '<table style="width: 100%;font-size: 10px;font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;  border-spacing: 0;" border="1" cellpadding ="2" >
				<thead>
				<tr>
				<td colspan="9"><span style="font-size: 18px;margin-top: 5px;text-align:center;font-wight:bold;">'.$company_data->name.'</span></td>
				<td border-left="0px"><img src="'.base_url().'/assets/modules/crm/uploads/alfalogo.jpg"  style="float: left;width: 80px;"></td>

				</tr>
				<tr>
				<th colspan="10">
				<strong>'.$companyAddress.'</strong>
				</th>
				</tr>
				<tr>
				<td>DATE</td>
				<td>'.$dataPdf->order_date.'</td>
				<td colspan="6" style="text-align:center;">SALE ORDER</td>
				<td>PI NO:</td>
				<td>'.$dataPdf->pi_code.'</td>
				</tr>
				<tr>
				<td colspan="4">TO</td>

				<th colspan="6">Bank Details</th>
				</tr>
				<tr>
				<td colspan="4">Buyer Name: '.$accountdata->name.'<br>
						Phone Number : '.$accountdata->phone.'<br>
						Address : '.$billingdata[0]->billing_street_1.'<br>
						State : '.$billingdata[0]->state_name.'<br>
						City : '.$billingdata[0]->city_name.'<br>
						Zipcode : '.$billingdata[0]->billing_zipcode_1.'</td>

				<td colspan="6" >Account Name: '.$company_data->name.'<br>
				Bank Name : '.$company_data->bank_name.'<br>
				Account Number: '.$company_data->account_no.'<br>
				IFSC Code: '.$company_data->account_ifsc_code.'<br>
				Branch Name: '.$company_data->branch.'
				</td>
				</tr>
				<tr>
				<th style="vertical-align: middle; text-align: center;" width="5%">SL.No</th>
				<th style="vertical-align: middle; text-align: center;" width="8%">Product Code</th>
				<th style="vertical-align: middle; text-align: center;" width="10%">Product Image</th>
				<th style="vertical-align: middle; text-align: center;" width="8%">Variant 1</th>
				<th style="vertical-align: middle; text-align: center;" width="8%">Variant 2</th>
				<th style="vertical-align: middle; text-align: center;" width="8%">Variant 3</th>
				<th style="vertical-align: middle; text-align: center;" width="8%">Variant 4</th>
				<th style="vertical-align: middle; text-align: center;" width="8%">Variant 5</th>';
				$content .= '<th style="vertical-align: middle; text-align: center;" width="10%">Description</th>
				<th style="vertical-align: middle; text-align: center;" width="8%">Quantity</th>
				<th style="vertical-align: middle; text-align: center;" width="9%">Price</th>
				<th style="vertical-align: middle; text-align: center;" width="10%">Total</th>
				</tr>
				</thead>
				<tbody>';	
				
				// pre($products);die();

				
				if(!empty($products)){
				$j =  1;
				$ck = $subtotal = $gst = 0;
				$imagepath = '';
				foreach($products as $product){
				$subtotal += $product->individualTotal;
				$gst += $product->individualTotal*($product->gst/100);
				if(!empty($dataPdf)){
				$mat_type = json_decode($dataPdf->material_type_id);
				// $material_type_id = getNameById('material_variants',$mat_type[$ck],'id');
				$material_type_id = $this->alfaapimodel->getNameById_using_modal('material_variants',$mat_type[$ck],'id',$config_app);
				$materialItemCode = $material_type_id->item_code;
				$variantData = $material_type_id->variants_data;
				$variantDataValue = json_decode($variantData);
				}
				$content .=  '<tr>
				<td style="vertical-align: middle; text-align: center" width="5%"><br><br><br>'.$j.'</td>
				<td style="vertical-align: middle; text-align: center" width="8%"><br><br><br>'.$materialItemCode.'</td>
				<td style="vertical-align: middle; text-align: center" width="10%">';

				$mat_name = $product->product;
				// $mat_details = getNameById('material', $mat_name, 'id');
				$mat_details = $this->alfaapimodel->getNameById_using_modal('material',$mat_name,'id',$config_app);
				$mat_id = $mat_details->id;
				// $attachments = $ci->crm_model->get_image_by_materialId('attachments', 'rel_id', $product->product);
				$attachments = $this->alfaapimodel->getNameById_using_modal('attachments',$product->product,'rel_id',$config_app);
 // pre($attachments);die();
				if(!empty($attachments)){
					//$content .=  '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'].'">';
					$content .=  '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments->file_name.'">';
				}else{
					$content .=  '<img style="width: 50px; height: 50px;" src="">';
				}
				$content .= '</td>';
				 // pre($product);
				 // $matData = getNameById('material', $product->product, 'id');
				 $matData = $this->alfaapimodel->getNameById_using_modal('material',$product->product,'id',$config_app);			
				$mat_name = $matData->material_name;

				//$chunks = explode('_', $mat_name);
					$chunks = explode('_', $mat_name);
						$countChunks = count($chunks);
						if(count($chunks) == 5){
							$colspan = '<td width="8%"></td>';
						} elseif(count($chunks) == 4){
							$colspan = '<td width="8%"></td><td width="8%"></td>';
						} elseif(count($chunks) == 3){
							$colspan = '<td width="8%"></td><td width="8%"></td><td width="8%"></td>';
						} elseif(count($chunks) == 2){
							$colspan = '<td width="8%"></td><td width="8%"></td><td width="8%"></td>';
						} elseif(count($chunks) == 1){
						$colspan = '<td width="8%"></td><td width="8%"></td><td width="8%"></td><td width="8%"></td>';
					}
				
					for ($i = 1; $i < max($max_val_chk); $i++) {
						// pre($chunks[$i]);
						$c =$i+1;
						if($c > count($chunks)){
						$content .= '<td style="vertical-align: middle; text-align: center"></td>';	
						} else {
						if($i <= 5){			
						// $variants = getNameById('variant_options', $chunks[$i], 'option_name');
						$variants = $this->alfaapimodel->getNameById_using_modal('variant_options',$chunks[$i],'option_name',$config_app);
						
						
						if(!empty($variants)){
								$imagepath =  '<img style="width: 50px; height: 50px;" src="'.base_url().'/assets/modules/inventory/varient_opt_img/'.$variants->option_img_name.'">';
								$content .= '<td  width="8%">'.$imagepath.'</td>';
							}
						}
						}
						
					}
					// die();

					$content .= ''.$colspan.'<td style="vertical-align: middle; text-align: center" width="10%"><br><br><br>'.$product->description.'</td>
					<td style="vertical-align: middle; text-align: center" width="8%"><br><br><br>'.$product->quantity.'</td>
					<td style="vertical-align: middle; text-align: center" width="9%"><br><br><br>'.$product->price.'</td>
					<td style="vertical-align: middle; text-align: center" width="10%"><br><br><br>'.$product->individualTotal.'</td>
					</tr>';
					$j++; $ck++; }
					}
					if(!empty($dataPdf)){
						// $account = getNameById('account',$dataPdf->account_id,'id');
						$account = $this->alfaapimodel->getNameById_using_modal('account',$dataPdf->account_id,'id',$config_app);
						$type_of_customer = $account->type_of_customer;
						// $type_of_customer_data = $ci->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
						$type_of_customer_data = $this->alfaapimodel->getNameById_using_modal('types_of_customer',$type_of_customer,'id',$config_app);
						$calcDiscount_val = $dataPdf->load_type;
						$pi_cbf = $dataPdf->pi_cbf;
						$pi_weight = $dataPdf->pi_weight;
						$pi_paymode = $dataPdf->pi_paymode;
						$pi_permitted = $dataPdf->pi_permitted;
						$special_discount = $dataPdf->special_discount;
						$freightCharges = $dataPdf->freightCharges;
						$advance_received = $dataPdf->advance_received;
						if(!empty($dataPdf->advance_received)){
							$advance_received = $dataPdf->advance_received;
						}else{
							$advance_received = 0;
						}
						 
							if($calcDiscount_val == 'none'){
								$discount_rate = 0;
							} else {
								$discount_rate = $type_of_customer_data->$calcDiscount_val;	
							}
						$discount_value = $subtotal*($discount_rate/100);
						$spd_value = $subtotal*($special_discount/100);
						$total = $subtotal - $discount_value - $spd_value;
						$gfc = $freightCharges*18/100;
						$grand_total = $total+$gst+$freightCharges+$gfc;
						$remain_balance = $grand_total-$advance_received;
					}
					
					

				$content .= '
				<tr>												
				<td colspan="8">TERMS & CONDITION</td>												
				<td colspan="3">Sub Total</td>
				<td colspan="1" style="text-align:center;">'.$subtotal.'</td>
				</tr>
				<tr>												
				<td colspan="8" rowspan="10">1.'.$termsAndCondition[0]['content'].'
				</td>
				<td colspan="3">Discount</td>
				<td colspan="1" style="text-align:center;">'.$discount_value.'</td>
				</tr>
				<tr>												
				<td colspan="3">Special Discount  </td>
				<td colspan="1" style="text-align:center;">'.$spd_value.'</td>
				</tr>
				<tr>												
				<td colspan="3">Total</td>
				<td colspan="1" style="text-align:center;">'.$total.'</td>
				</tr>
				<tr>												
				<td colspan="3">Tax</td>
				<td colspan="1" style="text-align:center;">'.$gst.'</td>
				</tr>
				<tr>												
				<td colspan="3">Freight</td>
				<td colspan="1" style="text-align:center;">'.$freightCharges.'</td>
				</tr>
				<tr>												

				<td colspan="3">GST on the Freight</td>
				<td colspan="1" style="text-align:center;">'.$gfc.'</td>
				</tr>
				<tr>												

				<td colspan="3">TCS</td>
				<td colspan="1" style="text-align:center;">0.00</td>
				</tr>
				<tr>												
				<td colspan="3">Grand Total</td>
				<td colspan="1" style="text-align:center;">'.$grand_total.'</td>
				</tr>
				<tr>												

				<td colspan="3">Advance</td>
				<td colspan="1" style="text-align:center;">'.$advance_received.'</td>
				</tr>
				<tr>												

				<td colspan="3">Balance</td>
				<td colspan="1" style="text-align:center;">'.$remain_balance.'</td>
				</tr>
				<tr>												
				<td colspan="12">Note:This is an electonic quote. Signature not requiers.</td>

				</tr>
				<tr>												
				<td colspan="8">Thanking You,</td>
				<td colspan="4">For '.$company_data->name.' <br><br>Authoriesd Signature</td>

				</tr>

				</tbody>	
				<!--
				<table border="1" cellpadding="2">
				<tr><td colspan="9"><h2 align="center" style="margin: 5px 0px;">Sale Order</h2></td></tr>
				<tr>
				<td colspan="3"><strong>Our Ref.</strong> &nbsp; '.$dataPdf->id.'<br> <strong>Dated</strong> &nbsp; '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
				<td colspan="6"><strong>Party Ref.</strong> &nbsp; '.$dataPdf->party_ref.'<br> <strong>Dated</strong> &nbsp;  '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
				</tr>		
				<tr>
				<td colspan="3">
				<strong>Consigner Address:</strong> <br>'.$company_data->name.'  <br> '.$companyAddress.'
				<br><strong>Phone :</strong> '.$company_data->phone.'<br><strong>GSTIN :</strong> '.$company_data->gstin.'<br>
				</td>
				<td colspan="6">';
				$countryName = $this->alfaapimodel->getNameById_using_modal('country',json_decode($accountData->new_billing_address)[0]->billing_country_1,'country_id',$config_app);	
				
				$stateName = $this->alfaapimodel->getNameById_using_modal('state',json_decode($accountData->new_billing_address)[0]->billing_state_1,'state_id',$config_app);			
				$ctyName = $this->alfaapimodel->getNameById_using_modal('city',json_decode($accountData->new_billing_address)[0]->billing_city_1,'city_id',$config_app);	
				
				echo '<strong>Consignee Name:</strong><br>'.json_decode($accountData->new_billing_address)[0]->billing_company_1.'<br><strong>Address:</strong> '.json_decode($accountData->new_billing_address)[0]->billing_street_1.'<br><strong>City:</strong>  '.$ctyName->city_name.'<br><strong>Zipcode:</strong>  '.json_decode($accountData->new_billing_address)[0]->billing_zipcode_1.'<br><strong>State:</strong>  '.$stateName->state_name.'<br><strong>Country:</strong>  '.$countryName->country_name.' <br><strong>Email :</strong> '.$accountData->email.'
				<br><strong>Phone :</strong> '.json_decode($accountData->new_billing_address)[0]->billing_phone_addrs.'<br><strong>GSTIN :</strong> '.json_decode($accountData->new_billing_address)[0]->billing_gstin_1.'<br>
				</td>
				</tr>
				<tr>
				<th width="30px"><strong>S No.</strong></th>
				<th width="110px"><strong>Material <br>Description</strong></th>
				<th width="30px"><strong>QTY</strong></th>
				<th><strong>UOM</strong></th>
				<th><strong>Unit Price(Rs)</strong></th>
				<th width="30px"><strong>Tax Rate(%)</strong></th>
				<th><strong>Net <br>Amt.(Rs)</strong></th>
				<th><strong>Tax Amt.(Rs)</strong></th>
				<th width="83px"><strong>Total Amt.</strong></th>
				</tr>';
				$i = 0;
				foreach($products as $product){	
				$i++;
				// $material_id = $product->product;	
							
				$materialName = $this->alfaapimodel->getNameById_using_modal('material',$product->product,'id',$config_app);					
				$matName = $materialName->material_name;
				// $ww =  getNameById('uom', $product->uom,'id');
				$ww =  $this->alfaapimodel->getNameById_using_modal('uom',$product->uom,'id',$config_app);
				$uom = !empty($ww)?$ww->ugc_code:'';
				$total_tax =  $product->individualTotal*$product->gst/100;
				$total_tax = floor($total_tax*100)/100;

				$content .= '<tr>
				<td>'.$i.'</td>
				<td><h5>'.$matName.'</h5><br>'.(array_key_exists("description",$product)?$product->description:'').'</td>
				<td>'.$product->quantity.'</td>
				<td>'.$uom.'</td>
				<td>'.$product->price.'</td>
				<td>'.$product->gst.'</td>
				<td>'.$product->individualTotal.'</td>
				<td>'.$total_tax.'</td>
				<td>'.$product->individualTotalWithGst.'</td>
				</tr>';
				}			
				$content .= '
				<tr>
				<td colspan="8" align="right"><strong>Total Amount </strong> </td>
				<td>Rs. '. $dataPdf->total.'</td>
				</tr>';
				if (!empty($dataPdf->agt)) {
				$content .=  
				'<tr>
				<td colspan="8" align="right">Other Taxes </td>
				<td>Rs. '. $dataPdf->agt.'</td>
				</tr>';
				}
				if (!empty($dataPdf->freightCharges)) {
				$content .=  
				' <tr>
				<td colspan="8" align="right">Freight Charges </td>
				<td>Rs.'. $dataPdf->freightCharges.'</td>
				</tr>';
				}
				if ($dataPdf->grandTotal) {
				$overAllTotal=$dataPdf->grandTotal+(float)$dataPdf->freightCharges??'';
				$content .=  
				'<tr>
				<td colspan="8" align="right"><strong>Grand Total</strong> </td>
				<td>Rs. '. $overAllTotal.'</td>
				</tr>';
				}
				if (!empty($dataPdf->advance_received)) {
				$content .=  
				'<tr>
				<td colspan="8" align="right"> Advance Received  </td>
				<td>Rs. '. $dataPdf->advance_received.'</td>
				</tr>';
				}
				if (!empty($overAllTotal)) {
				$overallremoveAdvamt=$overAllTotal-$dataPdf->advance_received;
				$content .=  
				'<tr>
				<td colspan="8" align="right"><strong>Total Payable Amount </strong> </td>
				<td>Rs. '. $overallremoveAdvamt.'</td>
				</tr>';
				}

				$content .=  
				'<tr>
				<td colspan="9"><strong>Guarantee/ Returnable Special Notes:</strong><br>'.$dataPdf->guarantee.'</td>
				</tr>		
				<tr>
				<td colspan="3">
				<strong>A/c Name:</strong> '.$company_data->account_name.' <br><strong>A/c No:</strong>  '.$company_data->account_no.' <br><strong>IFSC:</strong>  '.$company_data->account_ifsc_code.' 
				</td>
				<td colspan="6">
				<strong>Our Banker Address: </strong> <br> <strong>Bank :</strong>  '.$company_data->bank_name.' <br> <strong>Branch :</strong>  '.$company_data->branch.' 
				</td>
				</tr> 
				<tr>
				<th colspan="2"><strong>Dispatch Date</strong></th>  
				<th colspan="4"><strong>Payment Terms</strong></th> 
				<th colspan="4"><strong>Discount Offered</strong></th>
				</tr>
				<tr>
				<td colspan="2">'.date("j F , Y", strtotime($dataPdf->dispatch_date)).'</td>  
				<td colspan="4">'.$dataPdf->payment_terms.'</td> 
				<td colspan="4">'.$discount_offeredHtml.'</td>
				</tr>';
				$content .=  
				'<tr>
				<td colspan="4"><strong>Documents Dispatched : </strong> &nbsp; '.$dispatch_documentsHtml.'</td>
				<td colspan="5"><strong>Product Applications : </strong> &nbsp; '.$dataPdf->product_application.' </td>
				</tr>		
				<tr>
				<td colspan="4"><strong>Label Printing Express : </strong> &nbsp; '.$dataPdf->label_printing_express.'</td>
				<td colspan="5"><strong>Brand Label : </strong> &nbsp; '.$dataPdf->brand_label.' </td>
				</tr>
				<tr>
				<td colspan="9">For '.$company_data->name.' <br><br><br><br><br><br>(Authorized Signatory)</td>
				</tr>-->';  
				$content .= '</table>'; 


// pre($content);die();				

				$obj_pdf->writeHTML($content);
		ob_end_clean();
		$rand_num = rand(5000000, 1500000);
		$filename = "ProformaInv_".$rand_num."" . ".pdf";
		$obj_pdf->Output(FCPATH . 'assets/POUpload/'.$filename, 'F');
       	//$pdfFilePath = FCPATH . 'assets/POUpload/'.$filename;
       	$pdfFilePath = base_url() . 'assets/POUpload/'.$filename;
		
			echo '{"Status":"true","Data":"'. $pdfFilePath . '"}';
		
			
	   } else {
            echo '{"Status":"false", "Data":[{"result":"Please Send Material ID."}]}';
        }
	 }
	 
	  public function genratePDF(){
       $config_app  = switch_db_dinamico('alfa_child_db');
	   $this->load->model('alfaapimodel', '', true);
	   if (isset($_REQUEST['PI_id'])  && isset($_REQUEST['created_by_cid'])) {
		   $this->load->library('Pdf');
			$obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
				$obj_pdf->SetCreator(PDF_CREATOR);  
				$obj_pdf->SetTitle("SALE ORDER");  
				$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
				$obj_pdf->SetDefaultMonospacedFont('helvetica');  
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
				$obj_pdf->setPrintHeader(false);  
				$obj_pdf->setPrintFooter(false);  
				$obj_pdf->SetAutoPageBreak(TRUE, 10);  
				$obj_pdf->SetFont('helvetica', '', 11);
			//$obj_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			
			$dataPdf = $this->alfaapimodel->getNameById_using_modal('proforma_invoice',$_REQUEST['PI_id'],'id',$config_app);
			 //
			
			$company_data = $this->alfaapimodel->getNameById_using_modal('company_detail',$_REQUEST['created_by_cid'],'id',$config_app);
			
			
			$bank_info = json_decode($company_data->bank_details);
			$primarybnk  = $bank_info[0];
			$image = base_url().'assets/modules/crm/uploads/alfalogo.jpg';
			$obj_pdf->Image($image,2,4,10,10,'PNG');
			$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
			$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
			$obj_pdf->AddPage(); 	
			$content .= ''; 
			$ci =& get_instance();
			if($company_data->address != ''){
						$companyAddress = json_decode($company_data->address);
						$countryName = $this->alfaapimodel->getNameById_using_modal('country',$companyAddress[0]->country,'country_id',$config_app);			
						$stateName = $this->alfaapimodel->getNameById_using_modal('state',$companyAddress[0]->state,'state_id',$config_app);	
						$ctyName = $this->alfaapimodel->getNameById_using_modal('city',$companyAddress[0]->city,'city_id',$config_app);
						
						$companyAddress = 'Address: '.$companyAddress[0]->address.', Country: '.$countryName->country_name.', State: '.$stateName->state_name.', City: '.$ctyName->city_name.', Pincode: '.$companyAddress[0]->postal_zipcode;
					}else{
						$companyAddress = '';
					}


					$accountData = $this->alfaapimodel->getNameById_using_modal('account',$dataPdf->account_id,'id',$config_app);
					$contactData = $this->alfaapimodel->getNameById_using_modal('contacts',$dataPdf->contact_id,'id',$config_app);	
					
					$products =  json_decode($dataPdf->product);
					 // pre($products);die();
					$max_val_chk = array();
					foreach($products as $product){
					
					$matData = $this->alfaapimodel->getNameById_using_modal('material',$product->product,'id',$config_app);
					$mat_name = $matData->material_name;
					$chunks = explode('_', $mat_name);
					$max_val_chk[] = count($chunks);	
					}
					
					
					
					$discount_offered = json_decode($dataPdf->discount_offered);
					$discount_offeredHtml = '';
					if(!empty($discount_offered)){
						foreach($discount_offered as $do){
							$discount_offeredHtml .=$do.',';	
						}	
							$discount_offeredHtml = substr_replace($discount_offeredHtml ,"", -1);
					}	
					$dispatch_documents = json_decode($dataPdf->dispatch_documents);
					$dispatch_documentsHtml = '';
					if(!empty($dispatch_documents)){
					foreach($dispatch_documents as $dd){
						$dispatch_documentsHtml .=$dd.',';	
					}	
						$dispatch_documentsHtml = substr_replace($dispatch_documentsHtml ,"", -1);
					}
				
				

			// Start Proforma Invoice number
			
			/************** Revised Purchase order generation ******************/
			$currentRevisedPIChar = 'A';
			$nextRevisedPIChar = chr(ord($currentRevisedPIChar) + 1);
			$revisedPOCode = '';
			$revisedPICode = '';
			if ($dataPdf && $dataPdf->save_status == 1) {
				if($dataPdf->pi_code == ''){
					echo " ";
				}else{
					$pi_code_array = explode('_', $dataPdf->pi_code, 4);
			//pre($pi_code_array);
			//	foreach ($pi_code_array as $key => $value) {
			//	echo "pi_code_array[".$key."] = ".$value."<br>";
			//	}
			// pre();

					// if($pi_code_array[2] == ''){
					if(count($pi_code_array) < 3){
						$currentRevisedPIChar = 'A';
						#$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1);
						$revisedPICode = $dataPdf->pi_code.'_'.$currentRevisedPIChar.'(Revised)';
					}else if($pi_code_array[2] != ''){
						#echo $po_code_array[2];
						$orignalOrderCode = $pi_code_array[0].'_'.$pi_code_array[1].'_'.$pi_code_array[2];
						$currentRevisedPIChar = explode('(', $pi_code_array[2], 1);
						$nextRevisedPIChar = chr(ord($currentRevisedPIChar[0]) + 1);
						$revisedPICode = $orignalOrderCode.'_'.$nextRevisedPIChar.'(Revised)';
					}
				}
			}
			// echo $piCode;
			// die;
			// End Proforma Invoice number

			// Get terms and conditions
			$termsAndCondition = $this->alfaapimodel->get_PDF_data('termscond',$config_app);
			
				$variantTypes =	$this->alfaapimodel->get_PDF_data('variant_types',$config_app);;
			
				$variantImages = $this->alfaapimodel->get_PDF_data('variant_options',$config_app);;
				
				$variantImages = $this->alfaapimodel->get_PDF_data('material_variants',$config_app);
			
			
			
			$packing_data1 = 0;
				$matIDD = 0;
				foreach($variantImages as $mages ){
					if(!empty(json_decode($mages['packing_data']))){
						$packing_data = json_decode($mages['packing_data']);
				foreach($packing_data as $pp){
					$packing_data1 .= $pp->packing_mat;
					if(!empty($packing_data1)){
						$matIDD = $mages['id'];
						}
					}
					}
				}

			#echo $packing_data1;
			
			$accountdata = $this->alfaapimodel->getNameById_using_modal('account',$dataPdf->account_id,'id',$config_app);
			  $billingdata = json_decode($accountdata->new_billing_address);  

			
			$content .= '<table style="width: 100%;font-size: 10px;font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;  border-spacing: 0;" border="1" cellpadding ="2" >
			
			<tr>
			<td colspan="9"><span style="font-size: 18px;margin-top: 5px;text-align:center;font-wight:bold;">'.$company_data->name.'</span></td>
			<td border-left="0px"><img src="'.base_url().'/assets/modules/crm/uploads/alfalogo.jpg"  style="float: left;width: 80px;"></td>

			</tr>
			<tr>
			<th colspan="10">
			<strong>'.$companyAddress.'</strong>
			</th>
			</tr>
			<tr>
			<td>DATE</td>
			<td>'.$dataPdf->order_date.'</td>
			<td colspan="6" style="text-align:center;">Proforma invoice</td>
			<td>PI NO:</td>
			<td>'.$dataPdf->pi_code.'</td>
			</tr>
			<tr>
			<td colspan="4">TO</td>

			<th colspan="6">Bank Details</th>
			</tr>
			<tr>
			<td colspan="4">Buyer Name: '.$accountdata->name.'<br>
			Phone Number : '.$accountdata->phone.'<br>
			Address : '.$billingdata[0]->billing_street_1.'<br>
			State : '.$billingdata[0]->state_name.'<br>
			City : '.$billingdata[0]->city_name.'<br>
			Zipcode : '.$billingdata[0]->billing_zipcode_1.'</td>

			<td colspan="6" >Account Name: '.$company_data->name.'<br>
			Bank Name : '.$company_data->bank_name.'<br>
			Account Number: '.$company_data->account_no.'<br>
			IFSC Code: '.$company_data->account_ifsc_code.'<br>
			Branch Name: '.$company_data->branch.'
			</td>
			</tr>
			<tr>
			<th style="vertical-align: middle; text-align: center;">SL.No</th>
			<th style="vertical-align: middle; text-align: center;">Product Code</th>
			<th style="vertical-align: middle; text-align: center;">Product Image</th>';
			$max_val_chk = array();
			foreach($products as $product){
			// $matData = getNameById('material', $product->product, 'id');
			$matData = $this->alfaapimodel->getNameById_using_modal('material',$product->product,'id',$config_app);
			$mat_name = $matData->material_name;

			
			// $mat_name = $product->product;
			$chunks = explode('_', $mat_name);
			if(count($chunks) == 4){
			$colspan = '';
			} elseif(count($chunks) == 3){
			$colspan = '2';
			} elseif(count($chunks) == 2){
			$colspan = '3';
			} elseif(count($chunks) == 1){
			$colspan = '4';
			}
			$max_val_chk[] = count($chunks);	
			} 
			
			
			for ($i = 1; $i < max($max_val_chk); $i++) {
			$content .= '<th style="vertical-align: middle; text-align: center;">Variant '.$i.'</th>';
			}
			$content .= '<th style="vertical-align: middle; text-align: center;">Description</th>
			<th style="vertical-align: middle; text-align: center;">Quantity</th>
			<th style="vertical-align: middle; text-align: center;">Price</th>
			<th colspan="'.$colspan.'"  style="vertical-align: middle; text-align: center;">Total</th>
			</tr>
			
			<tbody>
			';											   
			if(!empty($products)){
			$j =  1;
			$ck = $subtotal = $gst = 0;
			$imagepath = '';
			foreach($products as $product){
				
			$subtotal += $product->individualTotal;
			$gst += $product->individualTotal*($product->gst/100);
			if(!empty($dataPdf)){
			$mat_type = json_decode($dataPdf->material_type_id);
			// $material_type_id = getNameById('material_variants',$mat_type[$ck],'id');
			$material_type_id = $this->alfaapimodel->getNameById_using_modal('material_variants',$mat_type[$ck],'id',$config_app);
			
			$materialItemCode = $material_type_id->item_code;
			$variantData = $material_type_id->variants_data;
			$variantDataValue = json_decode($variantData);
			}
			$content .=  '<tr>
			<td style="vertical-align: middle; text-align: center"><br><br><br>'.$j.'</td>
			<td style="vertical-align: middle; text-align: center"><br><br><br>'.$materialItemCode.'</td>
			<td style="vertical-align: middle; text-align: center">';

			$mat_name = $product->product;
			// $mat_details = getNameById('material', $mat_name, 'id');
			$mat_details = $this->alfaapimodel->getNameById_using_modal('material',$mat_name,'id',$config_app);
			
			$mat_id = $mat_details->id;
			$product_code_id = $mat_details->product_code;
			// $attachments = $ci->crm_model->get_image_by_materialId('attachments', 'rel_id', $product->product);
			
			$attachments = $this->alfaapimodel->getNameById_using_modalForImage('attachments',$product->product,'rel_id',$config_app);
			
			if(!empty($attachments)){
				$content .=  '<img style="width: 50px; height: 50px;" src="'.base_url().'assets/modules/inventory/uploads/'.$attachments->file_name.'">';
			}else{
				$content .=  '<img style="width: 50px; height: 50px;" src="">';
			}
			$content .= '</td>';
			
			// $matData = getNameById('material', $product->product, 'id');
			$matData = $this->alfaapimodel->getNameById_using_modal('material',$product->product,'id',$config_app);
			
			$mat_name = $matData->material_name;
			
			$chunks = explode('_', $mat_name);
			
			for ($i = 1; $i < max($max_val_chk); $i++) {
			$c =$i+1;
			if($c > count($chunks)){
			$content .= '<td style="vertical-align: middle; text-align: center"></td>';	
			} else {
				
			// $variants = getNameById('material_variants', $chunks[0], 'temp_material_name');
			$variants = $this->alfaapimodel->getNameById_using_modal('material_variants',$chunks[0],'temp_material_name',$config_app);
			
			
			
			$variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
			
			$variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
			  
			$variantKeyCount = count($variant_key);
			
			for($k=1; $k<=$variantKeyCount; $k++){
			$fieldname = $variant_key[$k][0];
			// $variants = getNameById_withmulti('variant_options', $chunks[$i], 'option_name', $fieldname, 'variant_type_name');
			// getNameById_withmulti('variant_options', $chunks[$i], 'option_name', $fieldname, 'variant_type_name');
			$variants =$this->alfaapimodel->getNameById_using_modalwithMulti('variant_options', $chunks[$i], 'option_name', $fieldname, 'variant_type_name',$config_app);
			
		
			
			$variantOptionName = $variants->option_name;
			if(!empty($variants)){
			$imagepath =  '<img style="width: 50px; height: 50px;" src="'.base_url().'/assets/modules/inventory/varient_opt_img/'.$variants->option_img_name.'">';
			
			$content .= '<td style="vertical-align: middle; text-align: center">'.$imagepath.'<br><span>'.$variantOptionName.'</span></td>';
			}
			}
			 
			//echo $chunks[$i];
				
			}

			}

				$content .= '<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->description.'</td>
				<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->quantity.'</td>
				<td style="vertical-align: middle; text-align: center"><br><br><br>'.$product->price.'</td>
				<td colspan="'.$colspan.'"  style="vertical-align: middle; text-align: center"><br><br><br>'.$product->individualTotal.'</td>
				</tr>';
				$j++; $ck++; 
				}
				
				}
				
				if(!empty($dataPdf)){
					// $account = getNameById('account',$dataPdf->account_id,'id');
					$account = $this->alfaapimodel->getNameById_using_modal('account',$dataPdf->account_id,'id',$config_app);
					
					$type_of_customer = $account->type_of_customer;
					// $type_of_customer_data = $ci->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
					$type_of_customer_data = $this->alfaapimodel->getNameById_using_modal('types_of_customer',$type_of_customer,'id',$config_app);
					$calcDiscount_val = $dataPdf->load_type;
					$pi_cbf = $dataPdf->pi_cbf;
					$pi_weight = $dataPdf->pi_weight;
					$pi_paymode = $dataPdf->pi_paymode;
					$pi_permitted = $dataPdf->pi_permitted;
					$special_discount = $dataPdf->special_discount;
					$freightCharges = $dataPdf->freightCharges;
					$advance_received = $dataPdf->advance_received;
					if(!empty($dataPdf->advance_received)){
						$advance_received = $dataPdf->advance_received;
					}else{
						$advance_received = 0;
					}
					 
						if($calcDiscount_val == 'none'){
							$discount_rate = 0;
						} else {
							$discount_rate = $type_of_customer_data->$calcDiscount_val;	
						}
					$discount_value = $subtotal*($discount_rate/100);
					$spd_value = $subtotal*($special_discount/100);
					$total = $subtotal - $discount_value - $spd_value;
					$gfc = $freightCharges*18/100;
					$grand_total = $total+$gst+$freightCharges+$gfc;
					$remain_balance = $grand_total-$advance_received;
				}
				

			$content .= '
			<tr>												
			<td colspan="7">TERMS & CONDITION</td>												
			<td colspan="2">Sub Total</td>
			<td colspan="1" style="text-align:center;">'.$subtotal.'</td>
			</tr>
			<tr>												
			<td colspan="7" rowspan="10">1.'.$termsAndCondition[0]['content'].'
			</td>
			<td colspan="2">Discount</td>
			<td colspan="1" style="text-align:center;">'.$discount_value.'</td>
			</tr>
			<tr>												
			<td colspan="2">Special Discount  </td>
			<td colspan="2" style="text-align:center;">'.$spd_value.'</td>
			</tr>
			<tr>												
			<td colspan="2">Total</td>
			<td colspan="2" style="text-align:center;">'.$total.'</td>
			</tr>
			<tr>												
			<td colspan="2">Tax</td>
			<td colspan="2" style="text-align:center;">'.$gst.'</td>
			</tr>
			<tr>												
			<td colspan="2">Freight</td>
			<td colspan="2" style="text-align:center;">'.$freightCharges.'</td>
			</tr>
			<tr>												

			<td colspan="2">GST on the Freight</td>
			<td colspan="2" style="text-align:center;">'.$gfc.'</td>
			</tr>
			<tr>												

			<td colspan="2">TCS</td>
			<td colspan="2" style="text-align:center;">0.00</td>
			</tr>
			<tr>												
			<td colspan="2">Grand Total</td>
			<td colspan="2" style="text-align:center;">'.$grand_total.'</td>
			</tr>
			<tr>												

			<td colspan="2">Advance</td>
			<td colspan="2" style="text-align:center;">'.$advance_received.'</td>
			</tr>
			<tr>												

			<td colspan="2">Balance</td>
			<td colspan="2" style="text-align:center;">'.$remain_balance.'</td>
			</tr>
			<tr>												
			<td colspan="10">Note:This is an electonic quote. Signature not requiers.</td>

			</tr>
			<tr>												
			<td colspan="7">Thanking You,</td>
			<td colspan="3">For '.$company_data->name.'<br><br>Authoriesd Signature</td>

			</tr>

			</tbody>	
			<!--
			<table border="1" cellpadding="2">
				<tr><td colspan="9"><h2 align="center" style="margin: 5px 0px;">Sale Order</h2></td></tr>
				<tr>
				<td colspan="3"><strong>Our Ref.</strong> &nbsp; '.$dataPdf->id.'<br> <strong>Dated</strong> &nbsp; '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
				<td colspan="6"><strong>Party Ref.</strong> &nbsp; '.$dataPdf->party_ref.'<br> <strong>Dated</strong> &nbsp;  '.date("j F , Y", strtotime($dataPdf->created_date)).'</td>
				</tr>		
				<tr>
				<td colspan="3">
				<strong>Consigner Address:</strong> <br>'.$company_data->name.'  <br> '.$companyAddress.'
				<br><strong>Phone :</strong> '.$company_data->phone.'<br><strong>GSTIN :</strong> '.$company_data->gstin.'<br>
				</td>
				<td colspan="6">';
				$countryName = $this->alfaapimodel->getNameById_using_modal('country',json_decode($accountData->new_billing_address)[0]->billing_country_1,'country_id',$config_app);	
				
				$stateName = $this->alfaapimodel->getNameById_using_modal('state',json_decode($accountData->new_billing_address)[0]->billing_state_1,'state_id',$config_app);			
				$ctyName = $this->alfaapimodel->getNameById_using_modal('city',json_decode($accountData->new_billing_address)[0]->billing_city_1,'city_id',$config_app);	
				
				$content .= '<strong>Consignee Name:</strong><br>'.json_decode($accountData->new_billing_address)[0]->billing_company_1.'<br><strong>Address:</strong> '.json_decode($accountData->new_billing_address)[0]->billing_street_1.'<br><strong>City:</strong>  '.$ctyName->city_name.'<br><strong>Zipcode:</strong>  '.json_decode($accountData->new_billing_address)[0]->billing_zipcode_1.'<br><strong>State:</strong>  '.$stateName->state_name.'<br><strong>Country:</strong>  '.$countryName->country_name.' <br><strong>Email :</strong> '.$accountData->email.'
				<br><strong>Phone :</strong> '.json_decode($accountData->new_billing_address)[0]->billing_phone_addrs.'<br><strong>GSTIN :</strong> '.json_decode($accountData->new_billing_address)[0]->billing_gstin_1.'<br>
				</td>
				</tr>
				<tr>
				<th width="30px"><strong>S No.</strong></th>
				<th width="110px"><strong>Material <br>Description</strong></th>
				<th width="30px"><strong>QTY</strong></th>
				<th><strong>UOM</strong></th>
				<th><strong>Unit Price(Rs)</strong></th>
				<th width="30px"><strong>Tax Rate(%)</strong></th>
				<th><strong>Net <br>Amt.(Rs)</strong></th>
				<th><strong>Tax Amt.(Rs)</strong></th>
				<th width="83px"><strong>Total Amt.</strong></th>
				</tr>';
			$i = 0;
			foreach($products as $product){	
			$i++;
			// $material_id = $product->product;	
			// $materialName = getNameById('material',$product->product,'id');	
			$materialName = $this->alfaapimodel->getNameById_using_modal('material',$product->product,'id',$config_app);			
			$matName = $materialName->material_name;
			// $ww =  getNameById('uom', $product->uom,'id');
			$ww =  $this->alfaapimodel->getNameById_using_modal('uom',$product->uom,'id',$config_app);;
			$uom = !empty($ww)?$ww->ugc_code:'';
			$total_tax =  $product->individualTotal*$product->gst/100;
			$total_tax = floor($total_tax*100)/100;

			$content .= '<tr>
			<td>'.$i.'</td>
			<td><h5>'.$matName.'</h5><br>'.(array_key_exists("description",$product)?$product->description:'').'</td>
			<td>'.$product->quantity.'</td>
			<td>'.$uom.'</td>
			<td>'.$product->price.'</td>
			<td>'.$product->gst.'</td>
			<td>'.$product->individualTotal.'</td>
			<td>'.$total_tax.'</td>
			<td>'.$product->individualTotalWithGst.'</td>
			</tr>';
			}			
			$content .= '
			<tr>
			<td colspan="8" align="right"><strong>Total Amount </strong> </td>
			<td>Rs. '. $dataPdf->total.'</td>
			</tr>';
			if (!empty($dataPdf->agt)) {
			$content .=  
			'<tr>
			<td colspan="8" align="right">Other Taxes </td>
			<td>Rs. '. $dataPdf->agt.'</td>
			</tr>';
			}
			if (!empty($dataPdf->freightCharges)) {
			$content .=  
			' <tr>
			<td colspan="8" align="right">Freight Charges </td>
			<td>Rs.'. $dataPdf->freightCharges.'</td>
			</tr>';
			}
			if ($dataPdf->grandTotal) {
			$overAllTotal=$dataPdf->grandTotal+(float)$dataPdf->freightCharges??'';
			$content .=  
			'<tr>
			<td colspan="8" align="right"><strong>Grand Total</strong> </td>
			<td>Rs. '. $overAllTotal.'</td>
			</tr>';
			}
			if (!empty($dataPdf->advance_received)) {
			$content .=  
			'<tr>
			<td colspan="8" align="right"> Advance Received  </td>
			<td>Rs. '. $dataPdf->advance_received.'</td>
			</tr>';
			}
			if (!empty($overAllTotal)) {
			$overallremoveAdvamt=$overAllTotal-$dataPdf->advance_received;
			$content .=  
			'<tr>
			<td colspan="8" align="right"><strong>Total Payable Amount </strong> </td>
			<td>Rs. '. $overallremoveAdvamt.'</td>
			</tr>';
			}

			$content .=  
			'<tr>
			<td colspan="9"><strong>Guarantee/ Returnable Special Notes:</strong><br>'.$dataPdf->guarantee.'</td>
			</tr>		
			<tr>
			<td colspan="3">
			<strong>A/c Name:</strong> '.$company_data->account_name.' <br><strong>A/c No:</strong>  '.$company_data->account_no.' <br><strong>IFSC:</strong>  '.$company_data->account_ifsc_code.' 
			</td>
			<td colspan="6">
			<strong>Our Banker Address: </strong> <br> <strong>Bank :</strong>  '.$company_data->bank_name.' <br> <strong>Branch :</strong>  '.$company_data->branch.' 
			</td>
			</tr> 
			<tr>
			<th colspan="2"><strong>Dispatch Date</strong></th>  
			<th colspan="4"><strong>Payment Terms</strong></th> 
			<th colspan="4"><strong>Discount Offered</strong></th>
			</tr>
			<tr>
			<td colspan="2">'.date("j F , Y", strtotime($dataPdf->dispatch_date)).'</td>  
			<td colspan="4">'.$dataPdf->payment_terms.'</td> 
			<td colspan="4">'.$discount_offeredHtml.'</td>
			</tr>';
			$content .=  
			'<tr>
			<td colspan="4"><strong>Documents Dispatched : </strong> &nbsp; '.$dispatch_documentsHtml.'</td>
			<td colspan="5"><strong>Product Applications : </strong> &nbsp; '.$dataPdf->product_application.' </td>
			</tr>		
			<tr>
			<td colspan="4"><strong>Label Printing Express : </strong> &nbsp; '.$dataPdf->label_printing_express.'</td>
			<td colspan="5"><strong>Brand Label : </strong> &nbsp; '.$dataPdf->brand_label.' </td>
			</tr>
			<tr>
			<td colspan="9">For '.$company_data->name.' <br><br><br><br><br><br>(Authorized Signatory)</td>
			</tr>-->';  
			$content .= '</table>'; 
			
			   // pre($content);die();

			$obj_pdf->writeHTML($content);
		ob_end_clean();
		$rand_num = rand(5000000, 1500000);
		$filename = "ProformaInv_".$rand_num."" . ".pdf";
		$obj_pdf->Output(FCPATH . 'assets/POUpload/'.$filename, 'F');
       	//$pdfFilePath = FCPATH . 'assets/POUpload/'.$filename;
       	$pdfFilePath = base_url() . 'assets/POUpload/'.$filename;
		
			echo '{"Status":"true","Data":"'. $pdfFilePath . '"}';
		
			
	   } else {
            echo '{"Status":"false", "Data":[{"result":"Please Send Material ID."}]}';
        }
	 }
	
	
		public function deletePDFafterDownload(){
		 $this->load->model('alfaapimodel', '', true);
		 if($_REQUEST['pdfFilePath']){
			 $fileWithPath = FCPATH .'assets/POUpload/'.$_REQUEST['pdfFilePath'];
			 // pre($fileWithPath);die();
			
			unlink($fileWithPath);
				echo '{"Status":"true", "Data":[{"result":"Deleted Successfully"}]}';
		 }else{
			 echo '{"Status":"false", "Data":[{"result":"Some Thing Missing."}]}';
		 }
	}
	
	
}//Main