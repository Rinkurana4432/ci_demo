<?php


		function getNameById($table='',$id='',$field=''){
			$qry="select * from $table where $field='$id'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row();
			return $result;
		}
		function getNameBySearch($table='',$id='',$field=''){
			$qry="select * from $table where $field like '%$id%'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row();
			return $result;
		}
		function getNameById_bywith_ledgers($table='',$id='',$field=''){
			$qry="select * from $table where $field='$id' AND account_group_id = 7 ";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row();
			return $result;
		}


		function checkValue($table='',$name='',$field=''){
			$query="select * from $table where $field='$name'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($query);
			if($qryy->num_rows() > 0){
				  return true;
				   return $result;
			   }else{
				   return false;
			   }
		}
		
		
		function checkTargetValue($table='',$userid = '',$company_id=''){
			$startDate = date('Y-m-01');
			// echo "select * from $table where user_id = '$userid' AND company_id = '$company_id' AND start_date = '$startDate'";die();
			$query="select * from $table where user_id = '$userid' AND company_id = '$company_id' AND start_date = '$startDate'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($query);
			if($qryy->num_rows() > 0){
				  return true;
			   }else{
				   return false;
			   }
		}



		function get_purchase_bill_count($table='',$id='',$field=''){
			$qry= "SELECT id FROM ".$table." where ".$field." = ".$id." ORDER BY id DESC LIMIT 1";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row();
			return $result;
		}
		function getDbitcrditNoteNumber($table='',$id='',$field='',$debitnotetyp){
			//echo "SELECT id FROM ".$table." where ".$field." = ".$id." AND `PurchaseReturn_DN_ornot` = ".$debitnotetyp." ORDER BY id DESC LIMIT 1";
			$qry= "SELECT id FROM ".$table." where ".$field." = ".$id." AND `PurchaseReturn_DN_ornot` = ".$debitnotetyp." ORDER BY id DESC LIMIT 1";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row();
			return $result;
		}
		function get_purchase_bill_count_RCM_Voucher($table='',$id='',$field=''){
			//$qry= "SELECT * FROM purchase_bill ORDER BY id DESC LIMIT 1";
			$qry= "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'voucher' LIMIT 1";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row();
			return $result;
		}

		function get_challan_number_count($table='',$id='',$field=''){
			$qry= "SELECT count(*) as total_challan FROM ".$table." where ".$field." = ".$id." ORDER BY id DESC LIMIT 1";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row();
			return $result;
		}



		function get_closing_balance($ledger_id='',$Login_user_id=''){

			 $qry="SELECT transaction_dtl.*, ledger.opening_balance,ledger.openingbalc_cr_dr,ledger.account_group_id FROM transaction_dtl RIGHT JOIN ledger on transaction_dtl.ledger_id = ledger.id where ledger.id = '".$ledger_id."' ";
			 //AND ledger.created_by_cid = '".$Login_user_id."' AND ledger.created_by_cid = '0'
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->result_array();
			return $result;
		}

		function get_total_user_amount_debit($table='',$ledger_id,$Login_user_id){
			$qry="SELECT sum(debit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1 AND created_by_cid = '".$Login_user_id."'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);

			$result = $qryy->row_array();
			return $result;
		}
		function get_total_user_amount_crdt($table='',$ledger_id,$Login_user_id){
			$qry="SELECT sum(credit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1  AND  created_by_cid = '".$Login_user_id."'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row_array();
			return $result;
		}

		function get_total_user_amount_debit_where($table='',$ledger_id,$Login_user_id,$where){
			$qry="SELECT sum(debit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1 AND ".$where."";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);

			$result = $qryy->row_array();
			return $result;
		}
		function get_total_user_amount_crdt_where($table='',$ledger_id,$Login_user_id,$where){
			$qry="SELECT sum(credit_dtl) FROM $table where ledger_id = '".$ledger_id."' AND cancel_restore = 1 AND  ".$where."";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row_array();
			return $result;
		}







		/*function measurementUnits(){
			// $measurementUnits = array('Kgs','Tons','Grams','Meters','Inches','CentiMeters');
			// return $measurementUnits;
			$measurementUnits = array('Meter/Metre','Millimeter','Centimeter','Decimeter','Kilometer','Inch','Foot','Yard','Square meter','Square inches','Square feet','Cubic meter','Liter','Milliliter','Centiliter','Deciliter','Hectoliter','Cubic Inch','Quart','Gallon','Grams','Kilogram','Grain','Ounce','Pound','Ton','Tonne');
			return $measurementUnits;
		}*/

		function send_invoice_email($email_data=''){


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
												<td align="center" class="masthead" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: white; background: #099a8c; margin: 0; padding: 30px 0;     border-radius: 4px 4px 0 0;" bgcolor="#099a8c"> <img src="'.base_url().'assets/modules/company/uploads/logo.png" alt="logo" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; max-width: 100%; display: block; margin: 0 auto; padding: 0;" /></td>
											</tr>';

							$footer = '<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
									<td class="container" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 0;">
										<!-- Message start -->
										<table style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; border-collapse: collapse; margin: 0; padding: 0;">
											<tr style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
												<td class="content footer" align="center" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; background: white none; margin: 0; padding: 30px 35px;     border-radius: 0 0 4px 4px;" bgcolor="white">
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center"><a href="'. base_url() .'" style="font-size: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; color: #888; text-decoration: none; font-weight: bold; margin: 0; padding: 0;">ERP</a></p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">Phone: (+91) 172 419 4999 | Support: support@erp.org</p>
													<p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; color: #888; text-align: center; margin: 0; padding: 0;" align="center">SCO 07, 2nd Floor, Sector 11 Panchkula, India - 134109</p>
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
											<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Hi '.$email_data['party_name'].',</p>

											<p style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; line-height: 1.65; font-weight: normal; margin: 0 0 20px; padding: 0;">Message '.$email_data['added_msg'].'</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>';
return $messageContent = $header.$email_message.$footer;
		}

	function getLastTableId($table=''){
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$query = $dynamicdb->query("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
		$result = $query->row();
		if(!empty($result))
			return $result->id;
		else return false;
}


		function GSTR1_helper(){
			$GSTR1_data = array('B2B Invoices - 4A,4B,4C','B2C (Large) Invoice-5A,5B','B2C (Small) Invoice- 7','Credit/Debit Notes(Registered)-9B','Credit/Debit Notes(Unregistered)-9B','Export Invoices - 6A','Tax Liability(Advances recevied)-11A(1),11A(2)','Adjustment of Advances-11B(1),11B(2)','Nill Rated Invoices - 8A,8B,8C,8D');
			return $GSTR1_data;
		}
		function GSTR3B_helper(){
			$GSTR3B_data = array('Outward supplies and inward supplies liable to reverse charge','Of the supplies shown in 3.1(a) above of interstate supplies made to unregisterd persons,composition taxable person and UNI holders','Eligible ITC','Value of exempt,nil rated and non-GST inward supplies','Interest and Late Fee Payable');
			return $GSTR3B_data;
		}


		function Get_loan_liablity_Data($table='',$credit_debit_id,$login_user_id){
			$qry="select * from $table where child_ladger_id='".$credit_debit_id."' and created_by_cid='".$login_user_id."'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			//$qryy = $CI->db->query($qry);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->result();
			return $result;
		}
		//My new Code End Trail Balance
		 function get_capital_accoun_other($table='',$Login_user_id){
			$qry="SELECT * FROM $table where `account_group_id` IN (1,2,4,5,12,10) AND created_by_cid = '".$Login_user_id."'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->result_array();
			return $result;
		}
		function get_sum_of_debit_other($table='',$acc_grp_id,$Login_user_id){
			$qry="SELECT sum(opening_balance) FROM $table where account_group_id = '".$acc_grp_id."' AND  openingbalc_cr_dr = 0 AND created_by_cid = '".$Login_user_id."'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row_array();
			return $result;
		}

		function get_sum_of_credit_other($table='',$acc_grp_id,$Login_user_id){
			$qry="SELECT sum(opening_balance) FROM $table where account_group_id = '".$acc_grp_id."' AND  openingbalc_cr_dr = 1 AND created_by_cid = '".$Login_user_id."'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->row_array();
			return $result;
		}

	//My new Code End Trail Balance


		function  Get_Tax_amount($table='',$Login_user_id){

			//$qry="SELECT sum(debit_dtl) as total_tax FROM $table WHERE `ledger_id` IN (1,2,3) AND created_by_cid = '".$Login_user_id."'";//change created_by_cid
			$qry="SELECT * FROM $table WHERE `ledger_id` IN (1,2,3) AND created_by_cid = '".$Login_user_id."'";//change created_by_cid
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->result_array();
			return $result;
		}

		function  Get_Voucher_detail_reg_unreg($table='',$current_login_id){
			// $qry="SELECT * FROM transaction_dtl where type = 'voucher' AND created_by_cid = '".$current_login_id."'";
			$qry="SELECT * FROM voucher where voucher_name = 6 OR voucher_name = 8  AND created_by_cid = '".$current_login_id."'";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->result_array();
			return $result;
		}
		/*GET CONNECTED Comapny DATA*/
		// function connectedCompany(){
			// $loggedInCompanyId =  	$_SESSION['loggedInUser']->c_id;
			// $qry="select cd.*,u.email from company_detail  as cd inner join connection on (connection.requested_to = cd.id or connection.requested_by = cd.id) inner join user as u on (cd.u_id = u.id ) where cd.id != $loggedInCompanyId and  connection.status = 1";
			// $CI =& get_instance();
			// $qryy = $CI->db->query($qry);
			// $result = $qryy->result_array();
			// return $result;
		// }

		function connectedCompany(){
			$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
			$loggedInCompanyId =  	$this->companyGroupId;
			$qry="select cd.*,u.email from company_detail  as cd inner join connection on (connection.requested_to = cd.id or connection.requested_by = cd.id) inner join user as u on (cd.u_id = u.id ) where cd.id != $loggedInCompanyId and  connection.status = 1";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$qryy = $dynamicdb->query($qry);
			$result = $qryy->result_array();
			return $result;
		}
		/*GET CONNECTED Comapny DATA*/

	function monthWiseIncomeExpenseAmountGraph($startDate = '', $endDate = ''){
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		error_reporting(0);
			if( $_SESSION['loggedInUser']->role == 1){
					$expenseWhere = ' AND purchase_bill.created_by_cid='.$this->companyGroupId;
			}else{
					$expenseWhere = ' AND purchase_bill.created_by='.$_SESSION['loggedInUser']->id;
			}
			$expenseDateQuery = '';
			if($startDate != '' && $endDate != ''){
				$expenseDateQuery = ' AND purchase_bill.created_date >="'.$startDate . '" AND purchase_bill.created_date <="' .$endDate . '"' ;
			}else{
				$expenseDateQuery = ' AND DATE_FORMAT(purchase_bill.created_date, "%Y") = YEAR (CURDATE())' ;
			}

			$expenseQry = "SELECT  substring(
				concat('  January'
					  ,' February'
					  ,'    March'
					  ,'    April'
					  ,'      May'
					  ,'     June'
					  ,'     July'
					  ,'   August'
					  ,'September'
					  ,'  October'
					  ,' November'
					  ,' December'
					  )
				 , m*9 - 8
				 , 9 ) as period ,purchase_bill.invoice_total_with_tax as purchase_bill_amount  FROM
		(
			SELECT 1 as m
			UNION SELECT 2 as m
			UNION SELECT 3 as m
			UNION SELECT 4 as m
			UNION SELECT 5 as m
			UNION SELECT 6 as m
			UNION SELECT 7 as m
			UNION SELECT 8 as m
			UNION SELECT 9 as m
			UNION SELECT 10 as m
			UNION SELECT 11 as m
			UNION SELECT 12 as m
		) as Months
		LEFT JOIN purchase_bill  on Months.m = MONTH(purchase_bill.created_date)  $expenseWhere $expenseDateQuery
		ORDER BY
			Months.m";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$expenseQryy = $dynamicdb->query($expenseQry);
			$expenseResult = $expenseQryy->result_array();
			if(!empty($expenseResult)){
				$i = 0;
				$expenseAmountArray = array();
				$unique_months = array_unique(array_map(function($elem){return $elem['period'];}, $expenseResult));
				foreach($unique_months as $um){
					foreach($expenseResult as $res){
						if($um == $res['period']){
							$expenseAmountArray[$i]['month'] = $um;
							if($res['purchase_bill_amount'] != ''){
								$pbData[$i] = json_decode($res['purchase_bill_amount']);
								$expenseAmountArray[$i]['expense'] += $pbData[$i][0]->invoice_total_with_tax;
							}else{
								$expenseAmountArray[$i]['expense'] = 0;
							}
						}
					}
					$i++;
				}
			}

	/*     Income Query      */
	if( $_SESSION['loggedInUser']->role == 1){
			$incomeWhere = ' AND invoice.created_by_cid='.$this->companyGroupId;
	}else{
			$incomeWhere = ' AND invoice.created_by='.$_SESSION['loggedInUser']->id;
	}
	if($startDate != '' && $endDate != ''){
		$incomeDateQuery = ' AND invoice.created_date >="'.$startDate . '" AND invoice.created_date <="' .$endDate . '"' ;
	}else{
		$incomeDateQuery = ' AND DATE_FORMAT(invoice.created_date, "%Y") = YEAR (CURDATE())' ;
	}

		$incomeQry = "SELECT  substring(
			concat('  January'
				  ,' February'
				  ,'    March'
				  ,'    April'
				  ,'      May'
				  ,'     June'
				  ,'     July'
				  ,'   August'
				  ,'September'
				  ,'  October'
				  ,' November'
				  ,' December'
				  )
			 , m*9 - 8
			 , 9 ) as period ,invoice.invoice_total_with_tax as expanse_bill_amount  FROM
	(
		SELECT 1 as m
		UNION SELECT 2 as m
		UNION SELECT 3 as m
		UNION SELECT 4 as m
		UNION SELECT 5 as m
		UNION SELECT 6 as m
		UNION SELECT 7 as m
		UNION SELECT 8 as m
		UNION SELECT 9 as m
		UNION SELECT 10 as m
		UNION SELECT 11 as m
		UNION SELECT 12 as m
	) as Months
	LEFT JOIN invoice  on Months.m = MONTH(invoice.created_date)  $incomeWhere $incomeDateQuery
	ORDER BY
		Months.m";

	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$incomeQryy = $dynamicdb->query($incomeQry);
	$incomeResult = $incomeQryy->result_array();
		if(!empty($incomeResult)){
		$i = 0;
		$incomeAmountArray = array();
		$income_unique_months = array_unique(array_map(function($elem){return $elem['period'];}, $incomeResult));
			foreach($income_unique_months as $eum){
				foreach($incomeResult as $eres){
					if($eum == $eres['period']){
						$incomeAmountArray[$i]['month'] = $eum;
						if($eres['invoice_total_with_tax'] != ''){
							$sbData[$i] = json_decode($eres['invoice_total_with_tax']);
							$incomeAmountArray[$i]['income'] += $sbData[$i][0]->invoice_total_with_tax;
						}else{
							$incomeAmountArray[$i]['income'] = 0;
						}
					}
				}
				$i++;
			}
	}


	$incomeExpenseArray  = array_merge($expenseAmountArray , $incomeAmountArray);
	$finalIncomeExpenseArray = array();
	$i = 0;
	foreach($income_unique_months as $um){
		foreach($incomeExpenseArray as $ma){
			if($um == $ma['month']){
				$finalIncomeExpenseArray[$i]['month'] = $um ;
				$finalIncomeExpenseArray[$i]['expense'] += $ma['expense'] ;
				$finalIncomeExpenseArray[$i]['income'] += $ma['income'] ;
			}
		}
		$i++;
	}
	return $finalIncomeExpenseArray;
}


function materialSaleAmountGraph($startDate = '', $endDate = ''){
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$getPermissionsForDashboard = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>6,'permissions.is_view'=>1));
	$accounts_material_sale_key = array_search('invoice', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($accounts_material_sale_key) != 'boolean' || $accounts_material_sale_key != '')  && $_SESSION['loggedInUser']->role == 2){
		$where = ' invoice.created_by_cid='.$this->companyGroupId;
	}else if( $_SESSION['loggedInUser']->role == 1){
		$where = ' invoice.created_by_cid='.$this->companyGroupId;
	}else{
		$where = ' invoice.created_by='.$_SESSION['loggedInUser']->u_id;
	}

	if($startDate != '' && $endDate != ''){
		$dateQuery = ' AND invoice.created_date >="'.$startDate . '" AND invoice.created_date <="' .$endDate . '"' ;
	}else{
		$dateQuery = ' AND DATE_FORMAT(invoice.created_date, "%Y") = YEAR (CURDATE())' ;
	}

	$qry = "SELECT invoice.descr_of_goods FROM invoice where $where $dateQuery";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $dynamicdb->query($qry);
	$result = $qryy->result_array();
	$goodsArray =array();
	$i = 0;
		if(!empty($result)){
			foreach($result as $res){
				$goodsData = json_decode($res['descr_of_goods']);
				$goodsArray[$i] = $res ;
				foreach($goodsData as $gd){
					$goodsArray[$i] = $gd ;
					$i++;
				}
		}
		$unique_material_ids = array_unique(array_map(function($elem){return $elem->material_id;}, $goodsArray));
		$finalMaterialArray =array();
		$j = 0;
		foreach($unique_material_ids as $unique_material_id){
			foreach($goodsArray as $ga){
				if($unique_material_id == $ga->material_id){
					$finalMaterialArray[$j]['amount'] += $ga->amount ;
					$finalMaterialArray[$j]['mat_id'] = $ga->material_id ;
					$finalMaterialArray[$j]['matarial_name'] = getNameById('material',$ga->material_id ,'id')->material_name;


				}
			}
			$j++;
		}

		#pre($finalMaterialArray);
		return $finalMaterialArray;
}
}


function monthWiseCashFlowGraph($startDate = '', $endDate = ''){

	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;


	$getPermissionsForDashboard = getPermissionsForDashboard(array('permissions.user_id' => $_SESSION['loggedInUser']->id,'modules.id'=>6,'permissions.is_view'=>1));
	$accounts_cash_flow_key = array_search('Payment', array_column($getPermissionsForDashboard, 'sub_module_name'));
	if( (gettype($accounts_cash_flow_key) != 'boolean' || $accounts_cash_flow_key != '')  && $_SESSION['loggedInUser']->role == 2){
		$paymentDoneWhere = ' AND payment.created_by_cid='.$this->companyGroupId;
		//$paymentDoneWhere = ' AND payment.created_by=13 ' ;
	}else if( $_SESSION['loggedInUser']->role == 1){
		$paymentDoneWhere = ' AND payment.created_by_cid='.$this->companyGroupId;
		//$paymentDoneWhere = ' AND payment.created_by=13 ' ;
	}else{
		$paymentDoneWhere = ' AND payment.created_by='.$_SESSION['loggedInUser']->u_id;
		//$paymentDoneWhere = ' AND payment.created_by=13 ' ;
	}

	/*      Payment Done     */
	if( $_SESSION['loggedInUser']->role == 1){
					$paymentDoneWhere = ' AND payment.created_by_cid='.$this->companyGroupId;
					//$paymentDoneWhere = ' AND payment.created_by=13 ' ;
			}else{
				$paymentDoneWhere = ' AND payment.created_by='.$_SESSION['loggedInUser']->id;
					//$paymentDoneWhere = ' AND payment.created_by==13 ';
			}
			if($startDate != '' && $endDate != ''){
				$paymentDoneDateQuery = ' AND payment.created_date >="'.$startDate . '" AND payment.created_date <="' .$endDate . '"' ;
			}else{
				$paymentDoneDateQuery = ' AND DATE_FORMAT(payment.created_date, "%Y") = YEAR (CURDATE())' ;
			}

			$paymentDoneQry = "SELECT  substring(
				concat('  January'
					  ,' February'
					  ,'    March'
					  ,'    April'
					  ,'      May'
					  ,'     June'
					  ,'     July'
					  ,'   August'
					  ,'September'
					  ,'  October'
					  ,' November'
					  ,' December'
					  )
				 , m*9 - 8
				 , 9 ) as period ,payment.added_amount as paymentDone  FROM
		(
			SELECT 1 as m
			UNION SELECT 2 as m
			UNION SELECT 3 as m
			UNION SELECT 4 as m
			UNION SELECT 5 as m
			UNION SELECT 6 as m
			UNION SELECT 7 as m
			UNION SELECT 8 as m
			UNION SELECT 9 as m
			UNION SELECT 10 as m
			UNION SELECT 11 as m
			UNION SELECT 12 as m
		) as Months
        LEFT JOIN payment on Months.m = MONTH(payment.created_date) $paymentDoneWhere  $paymentDoneDateQuery AND payment.type = 1 ORDER BY Months.m";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$paymentDoneQryy = $dynamicdb->query($paymentDoneQry);
			$paymentDoneResult = $paymentDoneQryy->result_array();

			if(!empty($paymentDoneResult)){
				$i = 0;
				$paymentDoneArray = array();
				$unique_months = array_unique(array_map(function($elem){return $elem['period'];}, $paymentDoneResult));
				foreach($unique_months as $um){
					foreach($paymentDoneResult as $res){
						if($um == $res['period']){
							$paymentDoneArray[$i]['month'] = $um;
							if($res['paymentDone'] != ''){
								$paymentDoneArray[$i]['paymentDone'] += $res['paymentDone'];
							}else{
								$paymentDoneArray[$i]['paymentDone'] = 0;
							}
						}
					}
					$i++;
				}
			}

	/*     Payment Received Query      */
if( $_SESSION['loggedInUser']->role == 1){
				$paymentDoneWhere = ' AND payment.created_by_cid='.$this->companyGroupId;
					//$paymentReceivedWhere = ' AND payment.created_by_cid=13 ' ;
			}else{
				$paymentDoneWhere = ' AND payment.created_by='.$_SESSION['loggedInUser']->id;
					//$paymentReceivedWhere = ' AND payment.created_by_cid==13 ';
			}
			if($startDate != '' && $endDate != ''){
				$paymentReceivedDateQuery = ' AND payment.created_date >="'.$startDate . '" AND payment.created_date <="' .$endDate . '"' ;
			}else{
				$paymentReceivedDateQuery = ' AND DATE_FORMAT(payment.created_date, "%Y") = YEAR (CURDATE())' ;
			}

			$paymentReceivedQry = "SELECT  substring(
				concat('  January'
					  ,' February'
					  ,'    March'
					  ,'    April'
					  ,'      May'
					  ,'     June'
					  ,'     July'
					  ,'   August'
					  ,'September'
					  ,'  October'
					  ,' November'
					  ,' December'
					  )
				 , m*9 - 8
				 , 9 ) as period ,payment.added_amount as paymentReceived  FROM
		(
			SELECT 1 as m
			UNION SELECT 2 as m
			UNION SELECT 3 as m
			UNION SELECT 4 as m
			UNION SELECT 5 as m
			UNION SELECT 6 as m
			UNION SELECT 7 as m
			UNION SELECT 8 as m
			UNION SELECT 9 as m
			UNION SELECT 10 as m
			UNION SELECT 11 as m
			UNION SELECT 12 as m
		) as Months
        LEFT JOIN payment on Months.m = MONTH(payment.created_date) $paymentReceivedWhere  $paymentReceivedDateQuery AND payment.type = 0 ORDER BY Months.m";
			$CI =& get_instance();
			$dynamicdb = $CI->load->database('dynamicdb', TRUE);
			$paymentReceivedQryy = $dynamicdb->query($paymentReceivedQry);
			$paymentReceivedResult = $paymentReceivedQryy->result_array();

			if(!empty($paymentReceivedResult)){
				$i = 0;
				$paymentReceivedArray = array();
				$unique_months = array_unique(array_map(function($elem){return $elem['period'];}, $paymentReceivedResult));

				foreach($unique_months as $um){
					foreach($paymentReceivedResult as $res){
						if($um == $res['period']){
							$paymentReceivedArray[$i]['month'] = $um;
							if($res['paymentReceived'] != ''){
								$paymentReceivedArray[$i]['paymentReceived'] += $res['paymentReceived'];
							}else{
								$paymentReceivedArray[$i]['paymentReceived'] = 0;
							}
						}
					}
					$i++;
				}
			}
	$paymentDoneReceivedArray  = array_merge($paymentDoneArray , $paymentReceivedArray);
	$finalPaymentDoneReceivedArray = array();
	$j = 0;
	foreach($unique_months as $um){
		foreach($paymentDoneReceivedArray as $pdr_array){
			if($um == $pdr_array['month']){
				$finalPaymentDoneReceivedArray[$j]['month'] = $um ;
				$finalPaymentDoneReceivedArray[$j]['paymentReceived'] += $pdr_array['paymentReceived'] ;
				$finalPaymentDoneReceivedArray[$j]['paymentDone'] += $pdr_array['paymentDone'] ;
			}
		}
		$j++;
	}
	return $finalPaymentDoneReceivedArray;

}


function getPermissionsForDashboard($where = array()){
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$dynamicdb->select('permissions.*,sub_module.sub_module_name,sub_module.slug,modules.id as moduleId');
		$dynamicdb->from('permissions');
		$dynamicdb->join('sub_module', 'permissions.sub_module_id = sub_module.id', 'left');
		$dynamicdb->join('modules', 'modules.id = sub_module.modules_id', 'left');
		$dynamicdb->where($where);
		$query = $dynamicdb->get();
		$result = $query->result_array();
		return $result;
}


function export_csv_excel($data3 = array()){

	 if(!empty($_GET['ExportType'])){
		 ob_end_clean();

		switch($_GET["ExportType"])
		{
			case "export-to-excel" :
				// Submission from
				$filename = $_GET["ExportType"] . ".xls";
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile($data3);
				//$_POST["ExportType"] = '';
				exit();
			case "export-to-csv" :
				// Submission from
				$filename = $_GET["ExportType"] . ".csv";
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-type: text/csv");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				header("Expires: 0");
				ExportCSVFile($data3);
				//$_POST["ExportType"] = '';
				exit();
			case "export-to-blank-excel" :
				// Submission from
				$filename = $_GET["ExportType"] . ".xls";
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile_blank($data3);
				//$_POST["ExportType"] = '';
            exit();

			default :
				die("Unknown action : ".$_GET["action"]);
				break;
		}
	 }
}

function export_csv_excel_blank($data_blank3 = array()){
	 if(!empty($_GET['ExportType_blank'])){
		// pre($_POST);
		 ob_end_clean();
		switch($_GET["ExportType_blank"])
		{
			case "export-to-blank-excel" :
				// Submission from
				$filename = $_GET["ExportType_blank"] . ".xlsx";
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				ExportFile_blank($data_blank3);
				//$_POST["ExportType"] = '';
            exit();

			default :
				die("Unknown action : ".$_GET["action"]);
				break;
		}
	 }
}

function ExportCSVFile($records) {
    // create a file pointer connected to the output stream
    $fh = fopen( 'php://output', 'w' );
    $heading = false;
        if(!empty($records))
			ob_end_clean();
          foreach($records as $row) {
            if(!$heading) {
              // output the column headings
              fputcsv($fh, array_keys($row));
              $heading = true;
            }
            // loop over the rows, outputting them
             fputcsv($fh, array_values($row));

          }
          fclose($fh);
}

function ExportFile($records) {
	$heading = false;
    if(!empty($records))
		//ob_end_clean();
      foreach($records as $row) {
        if(!$heading) {
          // display field/column names as a first row
          echo implode("\t", array_keys($row)) . "\n";
          $heading = true;
        }
        echo implode("\t", array_values($row)) . "\n";
      }
    exit;
}
function ExportFile_blank($records) {

    $heading = false;
    if(!empty($records))
		//ob_end_clean();
      foreach($records as $row) {
        if(!$heading) {
          // display field/column names as a first row
          echo implode("\t", array_keys($row)) . "\n";
          $heading = true;
        }
        echo implode("\t", array_values($row)) . "\n";
      }
    exit;
}
function switch_db_dinamico($name_db){
		$config_app['hostname'] = 'localhost';
		$config_app['username'] = 'ERP_root';
		$config_app['password'] = '#Lh{a@I~VQ6I';
		$config_app['database'] = $name_db;
		$config_app['dbdriver'] = 'mysqli';
		$config_app['dbprefix'] = '';
		$config_app['pconnect'] = FALSE;
		$config_app['db_debug'] = (ENVIRONMENT !== 'production');
		$config_app['save_queries'] = true;
		return $config_app;
	}
function getNameById_mat($table='',$id='',$field=''){
	$qry="select * from $table where $field='$id'";
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
	}
	$result = $qryy->result_array();
	return $result;
}


function getNameById_matFinal($table='',$id='',$field=''){
	$qry="select * from $table where `quantity` > 0 AND $field='$id' ORDER BY id ASC Limit 1";
	//die();
	$CI =& get_instance();
	if(!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role == 3){
		$qryy = $CI->db->query($qry);
	}else{
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);
		$qryy = $dynamicdb->query($qry);
	}
	$result = $qryy->result_array();
	
	return $result;
}

function paginationAttr($base_url,$rows){
	$config = array();
    $config["base_url"] = base_url() . $base_url;
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
    return $config;
}

function getSingleAndWhere($select,$table,$where){
	$ci =& get_instance();
	$dynamicdb = $ci->load->database('dynamicdb', TRUE);
	$data = $dynamicdb->select($select)
			->where($where)->get($table)->row_array();
	return $data[$select];
}

function getMaterialUpdateInvntry($select,$table,$where){
	$ci =& get_instance();
	$dynamicdb = $ci->load->database('dynamicdb', TRUE);
	$data = $dynamicdb->select($select)->where($where)
							->get($table)->row_array();
	if( $data[$select] ){
			return json_decode($data[$select],true);
	}
	return false;
}

function multiArrayUnique($array1,$array2){
	  $returnNewArray = [];
	  $oldMaterialCount = count($array1);
	  $newMaterialCount = count($array2);
	  $uniqueDataExist     = false;
	  if( $newMaterialCount > $oldMaterialCount ){
	      $graterMaterialArray = $array2; // newArray
	      $lessMaterialArray   = $array1;
	      $uniqueDataExist     = true;     //oldArray
	  }elseif( $newMaterialCount < $oldMaterialCount ){
	      $graterMaterialArray = $array1;
	      $lessMaterialArray   = $array2;
	      $uniqueDataExist     = true;
	  }

	  if( $uniqueDataExist ){
	      foreach($graterMaterialArray as $key => $value){
	          if( isset($lessMaterialArray[$key]) ){
	               $returnNewArray[] = (object)$value;
	          }
	      }
	      return $returnNewArray;
	  }else{
	  	return $array2;
	  }

}

function deleteforupdate($table='',$id='',$type=''){
	$qry="DELETE FROM $table WHERE type_id = '$id' AND type = '$type' ";
	$CI =& get_instance();
	$dynamicdb = $CI->load->database('dynamicdb', TRUE);
	$qryy = $CI->db->query($qry);
	$CI->db->affected_rows();
	
	$qryy = $dynamicdb->query($qry);
	$dynamicdb->affected_rows();
	// $result = $qryy->row();
	// return $result;
}


function debitCreditTrans($debit_dtl,$ledger_id,$credit_dtl,$type,$id,$add_Date,$billType = ""){

		$debit_data['debit_dtl']  = $debit_dtl;
		$debit_data['credit_dtl'] = $credit_dtl;
		/*if( !empty($billType) ){
			switch ($billType) {
				case 'Sale':
					$debit_data['debit_dtl']  = $debit_dtl;
					$debit_data['credit_dtl'] = $credit_dtl;
					break;
				case 'Purchase':
					$debit_data['debit_dtl']  = $credit_dtl;
					$debit_data['credit_dtl'] = $debit_dtl;
					break;
			}
		}*/

		$debit_data['ledger_id']  = $ledger_id;

		$debit_data['type'] 	  = $type;
		$debit_data['created_by'] = $_SESSION['loggedInUser']->u_id;
		$debit_data['created_by_cid'] = $_SESSION['loggedInUser']->c_id;
		$debit_data['type_id'] = $id;
		$debit_data['cancel_restore'] = 1;
		$debit_data['add_date'] = $add_Date;
		return $debit_data;
}


function lastInvoiceNo(){
		$ci =& get_instance();
		$dynamicdb = $ci->load->database('dynamicdb', TRUE);
		$query = $dynamicdb->query('SELECT * FROM invoice');
		$invoice_count =  $query->num_rows();
		$ccount = rand(10,100) + 1 . $invoice_count;
		return 'INVOICE/'.$ccount;
}

function lastRefrenceNo($select,$table){
		$ci =& get_instance();
		$dynamicdb = $ci->load->database('dynamicdb', TRUE);
		$data = $dynamicdb->select($select)->order_by('id','desc')->get($table)->row_array();
		if( $data[$select] ) {
			return $data[$select];
		}
		return 'N/A';
}

function chargeAmountPerMat($charges_added,$matPerQty,$invoice_matrial_details){

	$data_charges_json = json_decode($charges_added,true);
	$invoice_matrial_details = json_decode($invoice_matrial_details,true);
	$totalDisItem = 0;
	if( !empty($data_charges_json) ){

		$subtotal = 0;
		foreach ($invoice_matrial_details as $key => $value) {
			if( empty($value['after_desc_amt']) ){
				$subtotal +=  $value['quantity'] * $value['rate'];
			}else{
				$subtotal +=  $value['after_desc_amt'];
			}
		}


		foreach ($data_charges_json as $key => $discountCharge) {
			$charges_name = getNameById('charges_lead',$discountCharge['particular_charges_name'],'id');
			if( $charges_name->type_charges != 'plus' ){
				$totalDisItem += $discountCharge['amt_with_tax'];
			}
		}
		/*echo '<br>';
		echo 'matPerQty'.$matPerQty;
		echo '<br>';
		echo 'totalDisItm'.$totalDisItem;
		echo '<br>';
		echo 'Subtotal'.$subtotal;*/

		if( $totalDisItem ){
			return round(($matPerQty * $totalDisItem)/$subtotal,1);
		}
		return 0;
	}
}

// function mergeMultiDemArray($array1,$array2){
	// $data = [];
	// $i = 0;
	// foreach ($array1 as $key => $value) {
		// $data[] = $value;
		// $i++;
	// }
	// if( count($array1) == $i ){
		// foreach ($array2 as $key => $value) {
			// $data[$i] = $value;
			// $i++;
		// }
	// }
	// return $data;
// }

function showAllTable(){
    $CI =& get_instance();
    $dynamicdb = $CI->load->database('dynamicdb', TRUE);

	$secondDataBase['hostname'] = 'localhost';
	$secondDataBase['username'] = 'bimlaAshvi';
	$secondDataBase['password'] = 'aTXjR~qz-?%u';
	$secondDataBase['database'] = 'compersion_ashvi_bimla';
	$secondDataBase['dbdriver'] = 'mysqli';
	$secondDataBase['dbprefix'] = '';
	$secondDataBase['pconnect'] = FALSE;
	$secondDataBase['db_debug'] = (ENVIRONMENT !== 'production');
	$secondDataBase['save_queries'] = true;

	$firstdb  = $CI->load->database('dynamicdb', TRUE);
	$seconddb = $CI->load->database($secondDataBase, TRUE);

	$getAllFirstTable  = $firstdb->query("SHOW TABLES")->result_array();
	$getAllSecondTable  = $seconddb->query("SHOW TABLES")->result_array();

	$firstNewArray = $secondNewArray = [];

	if( $getAllFirstTable ){
		foreach ($getAllFirstTable as $key => $value) {
			$firstNewArray[] = $getAllFirstTable[$key]['Tables_in_erp_pos_ashvi'];
		}
	}

	if( $getAllSecondTable ){
		foreach ($getAllSecondTable as $key => $value) {
			$secondNewArray[] = $getAllSecondTable[$key]['Tables_in_compersion_ashvi_bimla'];
		}
	}
	$arrayDiffValue = array_diff($firstNewArray,$secondNewArray);

	$showCreateTable = [];
	if( $arrayDiffValue ){
		foreach ($arrayDiffValue as $key => $value) {
			$showCreateTable[] = $firstdb->query("SHOW CREATE TABLE {$value}")->row_array();
		}
	}
	pre($showCreateTable);

}
