<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  =======================================
 *  Author     : Vipinn Pathak
 *  License    : Protected
 *  Email      : dev@lastingerp.com
 *
 *  =======================================
*/
class Api_call {
	public $flipkartAccessToken;
	public function __construct($params){
		//parent::__construct();
		$url  = "https://seller.api.flipkart.net/oauth-service/oauth/token?grant_type=client_credentials&scope=Seller_Api";
		$curl = curl_init();
		$user_name  = $params['username'];
		$pwd  = $params['pwd'];
		$username = $user_name;
		$password = $pwd;
	/*	$username = '1711559a39084639b395119816850831a8b6';
		$password = '18181bb654c781a3fff929c2f6fa849a4';
	*/	/* $headers = array(
			"Authorization: Basic ".base64_encode("user:password"),
			"Content-Type: application/json"
		  ); */
		$headers = array(
			"Content-Type: application/json"
		  );		  
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);
		$this->flipkartAccessToken = $output->access_token;
		return $this->flipkartAccessToken;		
	}

    function order_list_api($secret_Key , $aws_access_key, $action , $seller_id , $Signature_method , $Signature_version , $nextToken, $time_stamp , $version , $MarketplaceId, $MSAuthToekn, $CreatedAfter) {
        $secretKey =  $secret_Key;
        $parameters = array();
        // required parameters
        $parameters['AWSAccessKeyId']       =  $aws_access_key;
        $parameters['Action']               =  $action;
        #$parameters['AmazonOrderId.Id.1']  = 'ENTERVALUE';
        $parameters['SellerId']             =  $seller_id;
        $parameters['SignatureMethod']      =  $Signature_method;
        $parameters['SignatureVersion']     =  $Signature_version;
		if(!empty($nextToken)){
			$parameters['NextToken']            =  $nextToken;
		}
        $parameters['Timestamp']            =  $time_stamp;
        $parameters['Version']              =  $version;
        $parameters['MarketplaceId.Id.1']   =  $MarketplaceId;
        //$parameters['OrderStatus.Status.1']   =  'PartiallyShipped';
        $parameters['OrderStatus.Status.1']   =  'Shipped';
        $parameters['MWSAuthToken']         =  $MSAuthToekn;
        $parameters['CreatedAfter']         =  $CreatedAfter;
      #  $parameters['CreatedBefore']        =  $CreatedBefore;
	  if(empty($nextToken)){
        function _sign($stringToSign, $secretKey) {
            //HmacSHA1
            $hash = 'sha256';
            return base64_encode(hash_hmac($hash, $stringToSign, $secretKey, true));
        }
	  //}
        function _calculateStringToSign(array $parameters) {
            $data = "POST\n";
            $data.= "mws.amazonservices.in\n";
            $data.= "/Orders/2013-09-01\n";
            $data.= _getParametersAsString($parameters);
            return $data;
        }
        function _getParametersAsString(array $parameters) {
            uksort($parameters, 'strcmp');
            $queryParameters = array();
            foreach ($parameters as $key => $value) {
                $queryParameters[] = $key . '=' . _urlencode($value);
            }
            return implode('&', $queryParameters);
        }
        function _urlencode($value) {
            return str_replace('%7E', '~', rawurlencode($value));
        }

        function buildRequest(array $parameters, $secretKey) {
            //$endpoint = 'https://mws.amazonservices.com/Orders/2013-09-01';
            $signature = _sign(_calculateStringToSign($parameters), $secretKey);
            $parameters['Signature'] = $signature;
            uksort($parameters, 'strcmp');
            return _getParametersAsString($parameters);
        }
}
        $request = buildRequest($parameters, $secretKey);
        $allHeaders = array();
        $allHeaders['Content-Type'] = "application/x-www-form-urlencoded; charset=utf-8"; // We need to make sure to set utf-8 encoding here
        //$allHeaders['Expect'] = null; // Don't expect 100 Continue
        /* $allHeadersStr = array();
        foreach ($allHeaders as $name => $val) {
            $str = $name . ": ";
            if (isset($val)) {
                $str = $str . $val;
            }
            $allHeadersStr[] = $str;
        } */

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mws.amazonservices.in/Orders/2013-09-01?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $allHeaders);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        /* curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) chrome/39.0.2171.71 Safari/537.36'); */
        $response = curl_exec($ch);
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        echo curl_error($ch);
        curl_close($ch);
        if(!empty($array['ListOrdersResult']['Orders']['Order'])){
        /* foreach ($array['ListOrdersResult']['Orders']['Order'] as $key) {
            #echo "<pre>";
            #print_r($key);
            $output[] =  $key;
        } */
			//$output[] = $array;
        }
        else{
            $output[] = '';
        }
        return $array;
		print_r($response);die;
		
    }
	
    function order_user_detail($secretKey,$aws_access_key, $lorderitemAction, $MSAuthToekn,$seller_id,$order_id,$Signature_version,$nextToken=null,$Signature_method,$time_stamp,$version ) {
        $secretKey =  $secretKey;
        $parameters = array();
        // required parameters
        $parameters['AWSAccessKeyId']       =  $aws_access_key;
        $parameters['Action']               =  $lorderitemAction;
        #$parameters['AmazonOrderId.Id.1']  = 'ENTERVALUE';
        $parameters['SellerId']             =  $seller_id;
        $parameters['AmazonOrderId']        =  $order_id;
        $parameters['SignatureMethod']      =  $Signature_method;
        $parameters['SignatureVersion']     =  $Signature_version;
		if(!empty($nextToken)){
			$parameters['NextToken']            =  $nextToken;
		}
        $parameters['Timestamp']            =  $time_stamp;
        $parameters['Version']              =  $version;
        //$parameters['MarketplaceId.Id.1']   =  $MarketplaceId;
        $parameters['MWSAuthToken']         =  $MSAuthToekn;
        //$parameters['CreatedAfter']         =  $CreatedAfter;
      #  $parameters['CreatedBefore']        =  $CreatedBefore;

        $request = buildRequest($parameters, $secretKey);
        $allHeaders = array();
        $allHeaders['Content-Type'] = "application/x-www-form-urlencoded; charset=utf-8"; // We need to make sure to set utf-8 encoding here
        $allHeaders['Expect'] = null; // Don't expect 100 Continue
        $allHeadersStr = array();
        foreach ($allHeaders as $name => $val) {
            $str = $name . ": ";
            if (isset($val)) {
                $str = $str . $val;
            }
            $allHeadersStr[] = $str;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mws.amazonservices.in/Orders/2013-09-01?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $allHeaders);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) chrome/39.0.2171.71 Safari/537.36');
        $response = curl_exec($ch);
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        echo curl_error($ch);
        curl_close($ch);
        if(!empty($array['ListOrdersResult']['Orders']['Order'])){

        }
        else{
            $output[] = '';
        }
        return $array;
    }	


	public function list_of_orders_api_flipkart_preDispatch(){
		//error_reporting(E_ALL);
		//pre($this->flipkartAccessToken);die;
		//$token['access_token'] = '57f669d5-7dc4-4dda-9fb3-bc79d9f62b4f';
		$url  = "https://api.flipkart.net/sellers/v3/shipments/filter";
		//$url  = "https://seller.api.flipkart.net/sellers/listings/v3/AZBTRSL0050";
		$curl = curl_init();
		$to = str_replace(" ", "T", date("Y-m-d H:i:s"));
		$makeDate = strtotime("-7 day", strtotime(date('Y-m-d H:i:s')));
		$from = str_replace(" ", "T", date("Y-m-d H:i:s", $makeDate));
		$data = '{
		  "filter": {
			"states": [
			  "APPROVED", "PACKING_IN_PROGRESS", "PACKED", "FORM_FAILED", "READY_TO_DISPATCH"
			],
			"type": "preDispatch",
			"orderDate": {
			  "from": "'.$from.'.962Z",
			  "to": "'.$to.'.962Z"
			}
		  },
		  "sellerId": "aa3ce916fc814715"
		}';/* pre($data);die; */
		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/json"
		  );
		curl_setopt($curl, CURLOPT_URL,$url);
		//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);
		//pre($ty);
		return $output;

	}

	public function list_of_orders_api_flipkart_preDispatch_more($url){
		//error_reporting(E_ALL);
		//$token['access_token'] = '57f669d5-7dc4-4dda-9fb3-bc79d9f62b4f';
		//$url  = "https://api.flipkart.net/sellers/v3/shipments/filter";
		//$url  = "https://seller.api.flipkart.net/sellers/listings/v3/AZBTRSL0050";
		$curl = curl_init();
				$to = str_replace(" ", "T", date("Y-m-d H:i:s"));
				$makeDate = strtotime("-7 day", strtotime(date('Y-m-d H:i:s')));
				$from = str_replace(" ", "T", date("Y-m-d H:i:s", $makeDate));
				//"APPROVED", "PACKING_IN_PROGRESS", "PACKED", "FORM_FAILED", "READY_TO_DISPATCH"
		$data = '{
		  "filter": {
			"states": [
			  "APPROVED", "PACKING_IN_PROGRESS", "PACKED", "FORM_FAILED", "READY_TO_DISPATCH"
			],
			"type": "preDispatch",
			"orderDate": {
			  "from": "'.$from.'.962Z",
			  "to": "'.$to.'.962Z"
			}
		  },
		  "sellerId": "aa3ce916fc814715"
		}';
		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/json"
		  );
		curl_setopt($curl, CURLOPT_URL,$url);
		//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);
		//pre($ty);
		return $output;
	}

	public function list_of_orders_api_flipkart_postDispatch(){
		//$token['access_token'] = '57f669d5-7dc4-4dda-9fb3-bc79d9f62b4f';
		$url  = "https://api.flipkart.net/sellers/v3/shipments/filter";

		$curl = curl_init();
		$to = str_replace(" ", "T", date("Y-m-d H:i:s"));
		$makeDate = strtotime("-7 day", strtotime(date('Y-m-d H:i:s')));
		$from = str_replace(" ", "T", date("Y-m-d H:i:s", $makeDate));
		$data = '{
		  "filter": {
			"states": [
			  "DELIVERED"
			],
			"type": "postDispatch",
			"orderDate": {
			  "from": "'.$from.'.962Z",
			  "to": "'.$to.'.962Z"
			}
		  },
		  "sellerId": "aa3ce916fc814715"
		}';

		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/json"
		  );
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);
		return $output;
	}

	public function list_of_orders_api_flipkart_postDispatch_more($url){
		//$token['access_token'] = '57f669d5-7dc4-4dda-9fb3-bc79d9f62b4f';
		//$url  = "https://api.flipkart.net/sellers/v3/shipments/filter";

		$curl = curl_init();
		$to = str_replace(" ", "T", date("Y-m-d H:i:s"));
		$makeDate = strtotime("-7 day", strtotime(date('Y-m-d H:i:s')));
		$from = str_replace(" ", "T", date("Y-m-d H:i:s", $makeDate));

		$data = '{
		  "filter": {
			"states": [
			  "SHIPPED"
			],
			"type": "postDispatch",
			"orderDate": {
			  "from": "'.$from.'.962Z",
			  "to": "'.$to.'.962Z"
			}
		  },
		  "sellerId": "aa3ce916fc814715"
		}';

		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/json"
		  );
		curl_setopt($curl, CURLOPT_URL,$url);
		//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);
		//pre($output);
		return $output;
	}
	/*get User Details of FlipKart*/
	public function get_order_details_user($orderItemid){
		$url  = "https://api.flipkart.net/sellers/v2/orders/shipments/?orderItemIds=".$orderItemid;
		$curl = curl_init();
		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/json"
		  );
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);
		//pre($ty);
		return $output;

	}

	/*Get Inventory details from FlipKart*/
	public function get_details_by_sku($sku){
	//	$sku = 'ABRC40';
		//$url  = "https://api.flipkart.net/sellers/listings/v3/$sku";
		$url  = "https://api.flipkart.net/sellers/skus/$sku/listings";
		$curl = curl_init();
		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/json"
		  );
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);

		return $output;
	}

	/*Update Inventory count in FlipKart*/
	//public function set_inventory_by_sku($productId ,$locationId, $setCount){
	
	
	public function set_inventory_by_sku($listingId, $skuId, $procurement_type, $mrp, $quantity){
	 //pre($listingId);
	 //pre($skuId);
	 //pre($procurement_type);
	 //pre($mrp);
	 //pre($quantity);
	 //echo "in pu";
		//$sku = 'AZJCLBRCB10';
		//$url  = "https://api.flipkart.net/sellers/listings/v3/update/inventory";
		$url  = "https://api.flipkart.net/sellers/skus/listings/$listingId";
		$curl = curl_init();
		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/json"
		);
		/* $data = '{
			"sku": {
				"product_id": "'.$productId.'",
				"locations": [
					{
						"id": "'.$locationId.'",
						"inventory": "'.$setCount.'"
					}
				]
			}
		}'; */
		$data = '{
					"listingId" : "'.$listingId.'",
					"skuId" : "'.$skuId.'",
					"attributeValues" : {
						"mrp": "'.$mrp.'",
						"stock_count" : "'.$quantity.'",
						"procurement_type": "'.$procurement_type.'"
					}
				}';	
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);

		return $output;
	}
	
	public function getInvoicePdf($shipmentId){
		
	 //pre($listingId);
	 //pre($skuId);
	 //pre($procurement_type);
	 //pre($mrp);
	 //pre($quantity);
	 //echo "in pu";
		//$sku = 'AZJCLBRCB10';
		//$url  = "https://api.flipkart.net/sellers/listings/v3/update/inventory";
		$url  = "https://api.flipkart.net/sellers/v3/shipments/$shipmentId/invoices";
		$curl = curl_init();
		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/pdf"
		);
		/* $data = '{
			"sku": {
				"product_id": "'.$productId.'",
				"locations": [
					{
						"id": "'.$locationId.'",
						"inventory": "'.$setCount.'"
					}
				]
			}
		}'; */
		/* $data = '{
					"listingId" : "'.$listingId.'",
					"skuId" : "'.$skuId.'",
					"attributeValues" : {
						"mrp": "'.$mrp.'",
						"stock_count" : "'.$quantity.'",
						"procurement_type": "'.$procurement_type.'"
					}
				}'; */	
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		//curl_setopt($curl, CURLOPT_POST, 1);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		//$output = json_decode($result);
		$output = $result;
		curl_close($curl);

		return $output;
	}	

	/*Update Inventory count in FlipKart*/
	public function set_shipmentLabel_status_by_sku($breadth ,$length, $weight, $height, $subShipmentId, $orderItemId, $orderId, $locationId, $shipmentId){
		$sku = 'AZJCLBRCB10';
		$url  = "https://api.flipkart.net/sellers/v3/shipments/labels";
		$curl = curl_init();
		$headers = array(
			"Authorization: Bearer ".$this->flipkartAccessToken,
			"Content-Type: application/json"
		);
		$data = '{
				  "shipments": [
					{
					  "subShipments": [
						{
						  "dimensions": {
							"breadth": '.$breadth.',
							"length": '.$length.',
							"weight": '.$weight.',
							"height": '.$height.'
						  },
						  "subShipmentId": "'.$subShipmentId.'"
						}
					  ],
					  "taxItems": [
						{
						  "taxRate": 0,
						  "orderItemId": "'.$orderItemId.'",
						  "quantity": 0
						}
					  ],
					  "invoices": [
						{
						  "orderId": "'.$orderId.'",
						  "invoiceNumber": "string",
						  "invoiceDate": "'.date('Y-m-d').'"
						}
					  ],
					  "serialNumbers": [
						{
						  "serialNumbers": [
							[
							  "string"
							]
						  ],
						  "orderItemId": "'.$orderItemId.'"
						}
					  ],
					  "locationId": "'.$locationId.'",
					  "shipmentId": "'.$shipmentId.'"
					}
				  ]
				}';  
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl);

		$header = curl_getinfo($curl);

		$output = json_decode($result);
		curl_close($curl);

		return $output;
	}	

	function request_report($secret_Key , $aws_access_key, $action , $seller_id , $Signature_method , $Signature_version , $time_stamp , $version , $MarketplaceId, $MSAuthToekn, $report_type) {
        $secretKey =  $secret_Key;
        $parameters = array();
        // required parameters
        $parameters['AWSAccessKeyId']       =  $aws_access_key;
        $parameters['Action']               =  $action;
        #$parameters['AmazonOrderId.Id.1']  = 'ENTERVALUE';
        $parameters['SellerId']             =  $seller_id;
        $parameters['SignatureMethod']      =  $Signature_method;
        $parameters['SignatureVersion']     =  $Signature_version;
        $parameters['Timestamp']            =  $time_stamp;
        $parameters['Version']              =  $version;
        $parameters['MarketplaceId.Id.1']   =  $MarketplaceId;
        $parameters['MWSAuthToken']         =  $MSAuthToekn;
        $parameters['ReportType']         =    $report_type;
		#  $parameters['CreatedBefore']        =  $CreatedBefore;
        function _sign($stringToSign, $secretKey) {
            //HmacSHA1
            $hash = 'sha256';
            return base64_encode(hash_hmac($hash, $stringToSign, $secretKey, true));
        }
        function _calculateStringToSign(array $parameters) {
            $data = "POST\n";
            $data.= "mws.amazonservices.in\n";
            $data.= "/Reports/2009-01-01\n";
            $data.= _getParametersAsString($parameters);
            return $data;
        }
        function _getParametersAsString(array $parameters) {
            uksort($parameters, 'strcmp');
            $queryParameters = array();
            foreach ($parameters as $key => $value) {
                $queryParameters[] = $key . '=' . _urlencode($value);
            }
            return implode('&', $queryParameters);
        }
        function _urlencode($value) {
            return str_replace('%7E', '~', rawurlencode($value));
        }
        function buildRequest(array $parameters, $secretKey) {
            //$endpoint = 'https://mws.amazonservices.com/Orders/2013-09-01';
            $signature = _sign(_calculateStringToSign($parameters), $secretKey);
            $parameters['Signature'] = $signature;
            uksort($parameters, 'strcmp');
            return _getParametersAsString($parameters);
        }
        $request = buildRequest($parameters, $secretKey);
        $allHeaders = array();
        $allHeaders['Content-Type'] = "application/x-www-form-urlencoded; charset=utf-8"; // We need to make sure to set utf-8 encoding here
        $allHeaders['Expect'] = null; // Don't expect 100 Continue
        $allHeadersStr = array();
        foreach ($allHeaders as $name => $val) {
            $str = $name . ": ";
            if (isset($val)) {
                $str = $str . $val;
            }
            $allHeadersStr[] = $str;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mws.amazonservices.in/Reports/2009-01-01?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $allHeaders);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) chrome/39.0.2171.71 Safari/537.36');
        $response = curl_exec($ch);
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
       # echo "<pre>";
       #  pre($array);        
        #die;
        echo curl_error($ch);
        curl_close($ch);
        if(!empty($array['RequestReportResult'])){
            foreach ($array['RequestReportResult'] as $key) {
                $output[] =  $key;
            }
        }
        else{
            $output[] = '';
        }
        return $output;
    }

   public function get_report_request_list($secret_Key , $aws_access_key, $action1 , $seller_id , $Signature_method , $Signature_version , $time_stamp , $version , $MarketplaceId, $MSAuthToekn, $report_id , $reprot_status) {
        $secretKey =  $secret_Key;
        $parameters = array();
        // required parameters
        $parameters['AWSAccessKeyId']       =  $aws_access_key;
        $parameters['Action']               =  $action1;
        #$parameters['AmazonOrderId.Id.1']  = 'ENTERVALUE';
        $parameters['SellerId']             =  $seller_id;
        $parameters['SignatureMethod']      =  $Signature_method;
        $parameters['SignatureVersion']     =  $Signature_version;
        $parameters['Timestamp']            =  $time_stamp;
        $parameters['Version']              =  $version;
        $parameters['MarketplaceId.Id.1']   =  $MarketplaceId;
        $parameters['MWSAuthToken']         =  $MSAuthToekn;
        $parameters['ReportId']             =    $report_id;
        $parameters['ReportProcessingStatusList.Status.1'] = $reprot_status;
      #  $parameters['CreatedBefore']       =  $CreatedBefore;
        function _sign1($stringToSign, $secretKey) {
            //HmacSHA1
            $hash = 'sha256';
            return base64_encode(hash_hmac($hash, $stringToSign, $secretKey, true));
        }
        function _calculateStringToSign1(array $parameters) {
            $data = "POST\n";
            $data.= "mws.amazonservices.in\n";
            $data.= "/Reports/2009-01-01\n";
            $data.= _getParametersAsString1($parameters);
            return $data;
        }
        function _getParametersAsString1(array $parameters) {
            uksort($parameters, 'strcmp');
            $queryParameters = array();
            foreach ($parameters as $key => $value) {
                $queryParameters[] = $key . '=' . _urlencode($value);
            }
            return implode('&', $queryParameters);
        }
        function _urlencode1($value) {
            return str_replace('%7E', '~', rawurlencode($value));
        }
        function buildRequest1(array $parameters, $secretKey) {
            //$endpoint = 'https://mws.amazonservices.com/Orders/2013-09-01';
            $signature = _sign1(_calculateStringToSign1($parameters), $secretKey);
            $parameters['Signature'] = $signature;
            uksort($parameters, 'strcmp');
            return _getParametersAsString1($parameters);
        }
        $request = buildRequest1($parameters, $secretKey);
        $allHeaders = array();
        $allHeaders['Content-Type'] = "application/x-www-form-urlencoded; charset=utf-8"; // We need to make sure to set utf-8 encoding here
        $allHeaders['Expect'] = null; // Don't expect 100 Continue
        $allHeadersStr = array();
        foreach ($allHeaders as $name => $val) {
            $str = $name . ": ";
            if (isset($val)) {
                $str = $str . $val;
            }
            $allHeadersStr[] = $str;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mws.amazonservices.in/Reports/2009-01-01?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $allHeaders);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) chrome/39.0.2171.71 Safari/537.36');
        $response = curl_exec($ch);
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
        #echo "<pre>";
        #pre($array);
        #die;
        echo curl_error($ch);
        curl_close($ch);

        if(!empty($array['GetReportRequestListResult']['ReportRequestInfo'])){
            foreach ($array['GetReportRequestListResult']['ReportRequestInfo'] as $key) {
                $output[] =  $key;
            }
        }
        else{
            $output[] = '';
        }
        return $output;

    }

    public function get_report($secret_Key , $aws_access_key, $action2 , $seller_id , $Signature_method , $Signature_version , $time_stamp , $version , $MarketplaceId, $MSAuthToekn, $get_report_id) {
        $secretKey =  $secret_Key;
        $parameters = array();
        // required parameters
        $parameters['AWSAccessKeyId']       =  $aws_access_key;
        $parameters['Action']               =  $action2;
        #$parameters['AmazonOrderId.Id.1']  = 'ENTERVALUE';
        $parameters['SellerId']             =  $seller_id;
        $parameters['SignatureMethod']      =  $Signature_method;
        $parameters['SignatureVersion']     =  $Signature_version;
        $parameters['Timestamp']            =  $time_stamp;
        $parameters['Version']              =  $version;
        $parameters['MarketplaceId.Id.1']   =  $MarketplaceId;
        $parameters['MWSAuthToken']         =  $MSAuthToekn;
        $parameters['ReportId']             =    $get_report_id;
        #$parameters['ReportProcessingStatusList.Status.1'] = $reprot_status;
      #  $parameters['CreatedBefore']       =  $CreatedBefore;
        function _sign2($stringToSign, $secretKey) {
            //HmacSHA1
            $hash = 'sha256';
            return base64_encode(hash_hmac($hash, $stringToSign, $secretKey, true));
        }
        function _calculateStringToSign2(array $parameters) {
            $data = "POST\n";
            $data.= "mws.amazonservices.in\n";
            $data.= "/Reports/2009-01-01\n";
            $data.= _getParametersAsString2($parameters);
            return $data;
        }
        function _getParametersAsString2(array $parameters) {
            uksort($parameters, 'strcmp');
            $queryParameters = array();
            foreach ($parameters as $key => $value) {
                $queryParameters[] = $key . '=' . _urlencode($value);
            }
            return implode('&', $queryParameters);
        }
        function _urlencode2($value) {
            return str_replace('%7E', '~', rawurlencode($value));
        }
        function buildRequest2(array $parameters, $secretKey) {
            //$endpoint = 'https://mws.amazonservices.com/Orders/2013-09-01';
            $signature = _sign2(_calculateStringToSign2($parameters), $secretKey);
            $parameters['Signature'] = $signature;
            uksort($parameters, 'strcmp');
            return _getParametersAsString2($parameters);
        }
        $request = buildRequest2($parameters, $secretKey);
        $allHeaders = array();
        $allHeaders['Content-Type'] = "application/x-www-form-urlencoded; charset=utf-8"; // We need to make sure to set utf-8 encoding here
        $allHeaders['Expect'] = null; // Don't expect 100 Continue
        $allHeadersStr = array();
        foreach ($allHeaders as $name => $val) {
            $str = $name . ": ";
            if (isset($val)) {
                $str = $str . $val;
            }
            $allHeadersStr[] = $str;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mws.amazonservices.in/Reports/2009-01-01?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $allHeaders);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) chrome/39.0.2171.71 Safari/537.36');
        $response = curl_exec($ch);
        /*$xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);*/
        #echo "<pre>";
        #pre($response);
        #die;
        echo curl_error($ch);
        curl_close($ch);

        /*if(!empty($array['GetReportRequestListResult']['ReportRequestInfo'])){
            foreach ($array['GetReportRequestListResult']['ReportRequestInfo'] as $key) {
                $output[] =  $key;
            }
        }
        else{
            $output[] = '';
        }*/
        return $response;

    }

   public function write_tabbed_file($filepath, $array, $save_keys=false){
    $content = '';
 
    reset($array);
    while(list($key, $val) = each($array)){
 
        // replace tabs in keys and values to [space]
        $key = str_replace("\t", " ", $key);
        $val = str_replace("\t", " ", $val);
 
        if ($save_keys){ $content .=  $key."\t"; }
 
        // create line:
        $content .= (is_array($val)) ? implode("\t", $val) : $val;
        $content .= "\n";
    }
 
    if (file_exists($filepath) && !is_writeable($filepath)){ 
        return false;
    }
    if ($fp = fopen($filepath, 'w+')){
        fwrite($fp, $content);
        fclose($fp);
    }
    else { return false; }
    return true;
}

}
?>