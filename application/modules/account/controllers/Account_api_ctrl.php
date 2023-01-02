<?php 
class Account_api_ctrl extends ERP_Controller
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
       $this->load->helper('account/account');
	   // $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
    }
	
	 public function login(){
        //echo "test";die;  
        $this->load->model('account_api_model', '', true);
        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
            $result = $this->account_api_model->loginmodel($_REQUEST['email'], $_REQUEST['password']);
            
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
                   $permissions = $this->account_api_model->fetch_user_premissions_by_id($config_app, $result->id, array(
                        'p.sub_module_id' => '216',
                        'p.user_id' => $result->id
                    ));
                   
                    $user_data   = array(
                        "user_id" => $result->id,
                        "company_id" => $result->c_id,
                        "user_email" => $result->email,
                        "username" => $result->name,
                        "profile_image" => $result->user_profile,
                        "birthday" => $result->age,
                        "permission" => (isset($permissions->is_view))?$permissions->is_view:0,
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
	
	public function get_ledgers(){
	$this->load->model('account_api_model', '', true);
	if( isset($_REQUEST['company_id']) &&  isset($_REQUEST['company_db_name']) && $_REQUEST['company_id'] !=''){
	$company_db_name              = $_REQUEST['company_db_name'];
	$config_app                   = switch_db_dinamico($company_db_name);
	@$created_by_id  = $_REQUEST['company_id'];
	
	$ledger_Dtl  = $this->account_api_model->get_legers_dtl('ledger',$created_by_id,$config_app);
	     $i=0;
		 $ledger_dtls  = array();
		foreach($ledger_Dtl as $dtls){
			$ledger_dtls[$i]['id']   = $dtls->id;
			$ledger_dtls[$i]['name']   = $dtls->name;
			$ledger_dtls[$i]['created_by_cid'] = $dtls->created_by_cid;
		 $i++;	
		 }
		// pre($ledger_dtls);die();
		 if(!empty($ledger_Dtl)){
			 $ledger_dtled = json_encode($ledger_dtls);
			 echo '{"Status":"true","Data":'. $ledger_dtled . '}';    
		}else{
			 echo '{"Status":"false", "Data":[{"result":"No Data Available."}]}';
		 }
		}else{
			echo '{"Status":"false", "Data":[{"result":"Please Login First."}]}';
		}	 
	}
	public function get_ledger_opening_balance(){
			$this->load->model('account_api_model', '', true);
		if( isset($_REQUEST['company_id']) &&  isset($_REQUEST['ledger_id']) && $_REQUEST['company_id'] !='' && $_REQUEST['company_db_name']){
			$company_db_name    = $_REQUEST['company_db_name'];
			$selected_ledger_id = $_REQUEST['ledger_id'];
			$config_app                   = switch_db_dinamico($company_db_name);
			$created_by_cid  = $_REQUEST['company_id'];
			$i=0;
	        $ledger_Dtld  = $this->account_api_model->get_leger_dtl('ledger',$created_by_cid,$config_app,$selected_ledger_id);
				$data  = array();
				foreach($ledger_Dtld as $val){
					$data[$i]['openingbalc_cr_dr'] = $val->openingbalc_cr_dr;
					$data[$i]['opening_balance']  = $val->opening_balance;
					$i++;
				}
			if(!empty($data)){
				$ledger_balcne_report_dtld = json_encode($data);
				echo '{"Status":"true","Data":'. $ledger_balcne_report_dtld . '}';    
			}else{
				 echo '{"Status":"false", "Data":[{"result":"No Data Available."}]}';
				}
		}else{
			echo '{"Status":"false", "Data":[{"result":"Data Missing."}]}';
		}
	
	}
	public function get_ledger_report(){
	$this->load->model('account_api_model', '', true);
	if( isset($_REQUEST['company_id']) &&  isset($_REQUEST['ledger_id']) && $_REQUEST['company_id'] !='' && $_REQUEST['company_db_name']){
	 $company_db_name    = $_REQUEST['company_db_name'];
	 $selected_ledger_id = $_REQUEST['ledger_id'];
	 $config_app                   = switch_db_dinamico($company_db_name);
	 $created_by_cid  = $_REQUEST['company_id'];
	 $date_fun = $this->account_api_model->get_termconditions_details('company_detail','id',$created_by_cid,$config_app);//Fetch Data to Company Table
	

	$date_fcal = json_decode($date_fun->financial_year_date,true);
	if(empty($date_fcal)){
					if (date('m') <= 4) {//Upto June 2014-2015
						 $mydate = date(date('Y-04-01'));
						$lastyear = strtotime("-1 year", strtotime($mydate));
						$first_date = date("Y-m-d", $lastyear); 
						$date = date(date('Y-03-31'));
						$second_date = date('Y-m-d', strtotime("$date"));
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
	     	$get_details = array(
					'ledger_id' => $selected_ledger_id,
					'created_by_cid' => $created_by_cid,
					'add_date >=' => $first_date,
					'add_date <=' => $second_date
				);
	
	        $ledger_dtl = $this->account_api_model->get_ladger_account_Data2('transaction_dtl',$get_details,$config_app);
				
		 $i=0;
		 $ledger_report  = array();
		 $cr_dr_total  = array();
		  $credit_total = 0;
		  $debit_total = 0;
			foreach($ledger_dtl as $dtls){
				
				if($dtls->type == 'invoice'){
					$vcher_type = 'Invoice';
					$get_invoice_dtl = $this->account_api_model->getNameById_using_modal('invoice',$dtls->type_id,'id',$config_app);
					$newDate = date("j F , Y", strtotime($get_invoice_dtl->date_time_of_invoice_issue));
					$ledger_data = $this->account_api_model->getNameById_using_modal('ledger',$get_invoice_dtl->party_name,'id',$config_app);
					$ledger_opn_balance = $ledger_data->opening_balance;
					$ledger_opn_balance_cr_dr = $ledger_data->openingbalc_cr_dr;
					$namee = $ledger_data->name; 
				}else if($dtls->type == 'purchase_bill'){
					$vcher_type = 'Purchase Bill';
					$get_purchase_bill_dtl = $this->account_api_model->getNameById_using_modal('purchase_bill',$dtls->type_id,'id',$config_app);
					$newDate = date("j F , Y", strtotime($get_purchase_bill_dtl->date));
					$ledger_data = $this->account_api_model->getNameById_using_modal('ledger',$get_purchase_bill_dtl->party_name,'id',$config_app);
					$ledger_opn_balance = $ledger_data->opening_balance;
					$ledger_opn_balance_cr_dr = $ledger_data->openingbalc_cr_dr;
					$namee = $ledger_data->name; 
				}else if($dtls->type == 'Payment Receive'){
					$vcher_type = 'Payment Receive';
					$get_payment_recive_dtl = $this->account_api_model->getNameById_using_modal('payment',$dtls->type_id,'id',$config_app);
					$newDate = date("j F , Y", strtotime($get_payment_recive_dtl->payment_date));
					$ledger_data = $this->account_api_model->getNameById_using_modal('ledger',$get_payment_recive_dtl->party_id,'id',$config_app);
					$ledger_opn_balance = $ledger_data->opening_balance;
					$ledger_opn_balance_cr_dr = $ledger_data->openingbalc_cr_dr;
					$namee = $ledger_data->name;
				}else if($dtls->type == 'purchase_bill_payment_recive'){
					$vcher_type = 'Payment Done';
					$newDate = date("j F , Y", strtotime($dtls->created_date));
					$ledger_data = $this->account_api_model->getNameById_using_modal('ledger',$get_payment_payment_done_dtl->party_id,'id',$config_app);
					$ledger_opn_balance = $ledger_data->opening_balance;
					$ledger_opn_balance_cr_dr = $ledger_data->openingbalc_cr_dr;
					$namee = $ledger_data->name; 
				}else{
					$get_vaoucher_id = $this->account_api_model->getNameById_using_modal('voucher',$dtls->type_id,'id',$config_app);
					$get_vaoucher_name = $this->account_api_model->getNameById_using_modal('voucher_type',$get_vaoucher_id->voucher_name,'id',$config_app);
					$vcher_type = $get_vaoucher_name->voucher_name;
					$newDate = date("j F , Y", strtotime($get_vaoucher_id->voucher_date));
				}	
				
			    $credit_total += $dtls->credit_dtl;
				$debit_total += $dtls->debit_dtl;
				
				
				
				
				$ledger_report[$i]['id']   = $dtls->id;
				$ledger_report[$i]['ledger_id']   = $dtls->ledger_id;
				$ledger_report[$i]['debit_dtl']   = $dtls->debit_dtl;
				$ledger_report[$i]['credit_dtl']   = $dtls->credit_dtl;
				$ledger_report[$i]['voucher_type']   = $dtls->type;
				$ledger_report[$i]['voucher_no']   = $dtls->type_id;
				$ledger_report[$i]['particulars']   = @$namee;
				// $ledger_report[$i]['opening_balance']   = $ledger_opn_balance;
				// $ledger_report[$i]['ledger_opn_balance_cr_dr']   = $ledger_opn_balance_cr_dr;
				$ledger_report[$i]['add_date']   =  date("j F , Y", strtotime($dtls->add_date));
				$ledger_report[$i]['created_by_cid'] = $dtls->created_by_cid;
				
			 $i++;	
			 }
			 
			    $cr_dr_total['credit_total'] = $credit_total;
				$cr_dr_total['debit_total'] = $debit_total;
				
				
			  if(!empty($ledger_report)){
			 $ledger_report_dtld = json_encode($ledger_report);
			 $cr_dr_total = json_encode($cr_dr_total);
			 echo '{"Status":"true","Data":'. $ledger_report_dtld . ',"Total":'.$cr_dr_total.'}';    
		}else{
			 echo '{"Status":"false", "Data":[{"result":"No Data Available."}]}';
		 }
	}else{
		echo '{"Status":"false", "Data":[{"result":"Data Missing."}]}';
	}
	}
	
	
		public function get_sale_report(){
			$this->load->model('account_api_model', '', true);
			if( isset($_REQUEST['company_id']) && $_REQUEST['company_id'] !='' && $_REQUEST['company_db_name']){
			 $company_db_name    = $_REQUEST['company_db_name'];
			 $config_app                   = switch_db_dinamico($company_db_name);
			 $created_by_cid  = $_REQUEST['company_id'];
			
			 $i=0;
			  
				$sale_ledger_Dtld  = $this->account_api_model->get_data('invoice',array('created_by_cid'=> $created_by_cid,'pay_or_not'=>0),$config_app);
				$sale_ledger_data  = array();
				foreach($sale_ledger_Dtld as $value){
					$prty_name = $this->account_api_model->getNameById_using_modal('ledger',$value['party_name'],'id',$config_app);
					$sale_ledger_name = $this->account_api_model->getNameById_using_modal('ledger',$value['sale_ledger'],'id',$config_app);
					$party_state = $this->account_api_model->getNameById_using_modal('state',$value['party_state_id'],'state_id',$config_app);
					$sale_Ladger_state_id = $this->account_api_model->getNameById_using_modal('state',$value['sale_L_state_id'],'state_id',$config_app);
					$edited_by = $this->account_api_model->getNameById_using_modal('user_detail',$value['edited_by'],'u_id',$config_app);
					$created_by_cid = $this->account_api_model->getNameById_using_modal('company_detail',$value['created_by_cid'],'id',$config_app);
					
					if($value['pay_or_not'] == 0){
						$pay_or_not = 'Not Pay';
					}else{
						$pay_or_not = 'Paid';
					}
					$sale_ledger_data[$i]['party_name'] = $prty_name->name;
					$sale_ledger_data[$i]['sale_ledger'] = $sale_ledger_name->name;
					$sale_ledger_data[$i]['invoice_type'] = $value['invoice_type'];
					$sale_ledger_data[$i]['invoice_num'] = $value['invoice_num'];
					$sale_ledger_data[$i]['eway_bill_no'] = $value['eway_bill_no'];
					$sale_ledger_data[$i]['email'] = $value['email'];
					$sale_ledger_data[$i]['gr_date'] = $value['gr_date'];
					$sale_ledger_data[$i]['gr_no'] = $value['gr_no'];
					$sale_ledger_data[$i]['port_loading'] = $value['port_loading'];
					$sale_ledger_data[$i]['port_discharge'] = $value['port_discharge'];
					$sale_ledger_data[$i]['party_phone'] = $value['party_phone'];
					$sale_ledger_data[$i]['buyer_order_no'] = $value['buyer_order_no'];
					$sale_ledger_data[$i]['dispatch_document_no'] = $value['dispatch_document_no'];
					$sale_ledger_data[$i]['transport'] = $value['transport'];
					$sale_ledger_data[$i]['vehicle_reg_no'] = $value['vehicle_reg_no'];
					$sale_ledger_data[$i]['mode_of_payment'] = $value['mode_of_payment'];
					$sale_ledger_data[$i]['pan'] = $value['pan'];
					$sale_ledger_data[$i]['party_gstin'] = $value['gstin'];
					$sale_ledger_data[$i]['party_gstin'] = $pay_or_not;
					$sale_ledger_data[$i]['transport_driver_pno'] = $value['transport_driver_pno'];
					$sale_ledger_data[$i]['date_time_of_invoice_issue'] = $value['date_time_of_invoice_issue'];
					$sale_ledger_data[$i]['date_time_of_invoice_issue'] = $value['date_time_removel_of_goods'];
					$sale_ledger_data[$i]['buyer_order_date'] = $value['buyer_order_date'];
					$sale_ledger_data[$i]['dispatch_document_date'] = $value['dispatch_document_date'];
					$sale_ledger_data[$i]['terms_of_delivery'] = $value['terms_of_delivery'];
					$sale_ledger_data[$i]['message_for_email'] = $value['message_for_email'];
					$sale_ledger_data[$i]['total_amount'] = $value['total_amount'];
					$sale_ledger_data[$i]['totaltax_total'] = $value['totaltax_total'];
					$sale_ledger_data[$i]['CGST'] = $value['CGST'];
					$sale_ledger_data[$i]['SGST'] = $value['SGST'];
					$sale_ledger_data[$i]['IGST'] = $value['IGST'];
					$sale_ledger_data[$i]['party_state_id'] = $party_state->state_name;
					$sale_ledger_data[$i]['sale_L_state_id'] = $sale_Ladger_state_id->state_name;
					//$sale_ledger_data[$i]['edited_by'] = $edited_by->name;
					$sale_ledger_data[$i]['created_by_cid'] = $created_by_cid->name;
					$sale_ledger_data[$i]['created_date'] = $value['created_date'];
					
					$i++;
					
					$data_json_decode = json_decode($value['descr_of_goods']);
					$mat_Detail = array();
					$j = 0;
					foreach($data_json_decode as $mat_desc){
						$mat_name = $this->account_api_model->getNameById_using_modal('material',$mat_desc->material_id,'id',$config_app);
						$uomName = $this->account_api_model->getNameById_using_modal('uom',$mat_desc->UOM,'id',$config_app);
						
							$mat_Detail[$j]['material_name'] = $mat_name->material_name;
							$mat_Detail[$j]['descr_of_goods'] = $mat_desc->descr_of_goods;
							$mat_Detail[$j]['hsnsac'] = $mat_desc->hsnsac;
							$mat_Detail[$j]['quantity'] = $mat_desc->quantity;
							$mat_Detail[$j]['rate'] = $mat_desc->rate;
							$mat_Detail[$j]['added_tax_Row_val'] = $mat_desc->added_tax_Row_val;
							$mat_Detail[$j]['UOM'] = $uomName->uom_quantity;
							$mat_Detail[$j]['amount'] = $mat_desc->amount;
							$mat_Detail[$j]['disctype'] = $mat_desc->disctype;
							$mat_Detail[$j]['discamt'] = $mat_desc->discamt;
							$mat_Detail[$j]['after_desc_amt'] = $mat_desc->after_desc_amt;
							$mat_Detail[$j]['cess'] = $mat_desc->cess;
							$j++;
					}
					
				}
				
				if(!empty($sale_ledger_Dtld)){
					$ledger_report_dtld = json_encode($sale_ledger_data);
					$material_details = json_encode($mat_Detail);
					echo '{"Status":"true","Data":'. $ledger_report_dtld . ',"material_detail":'.$material_details.'}';    
				}else{
					echo '{"Status":"false", "Data":[{"result":"No Data Available."}]}';
				}
			}else{
				echo '{"Status":"false", "Data":[{"result":"Data Missing."}]}';
			}
		}	
	
	
	
}//Main	