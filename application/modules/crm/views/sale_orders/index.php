<div class="x_content">
    <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	         <form class="form-search" method="get" action="<?= base_url() ?>crm/sale_orders">
   <input type="hidden" name="tab" value="<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>"/>
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter id,Sale Order No,Account N" name="search" id="search" data-ctrl="crm/sale_orders?tab=<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
         <a href="<?php echo base_url(); ?>crm/sale_orders?tab=<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
         </span>
      </div>
   </div>
</form>
  <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo" aria-expanded="true"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
	  <div id="demo" class="collapse" aria-expanded="true" style="">
	               <div class="col-md-12 col-xs-12 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /* <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/sale_orders"> */?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/sale_orders">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>crm/sale_orders" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
               <input type="hidden" value='<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>' name='tab'/>
               <input type="hidden" value='' class='company_unit' name='company_unit'/>
            </form>
         </div>
                  <!-- Filter div Start-->  
                  <form action="<?php echo base_url(); ?>crm/sale_orders" method="get" >
                     <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
                     <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
                     <div class="row hidde_cls filter1 progress_filter">
                        <div class="col-md-12">
                           <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                              <select name="company_unit" class="form-control company_unit">
                                 <option value=""> Select Category </option>
                                 <?php
                                    if(!empty($company_unit_adress) ){
                                    foreach($company_unit_adress as $companyAdress){
                                    $getAddress = $companyAdress['address'];
                                    $getDecodeAddress = json_decode($getAddress);
                                    foreach($getDecodeAddress as $fetchAddress){
                                    $address = $fetchAddress->compny_branch_name;	
                                    ?>
                                 <option value="<?php echo $address; ?>"><?php echo $address; ?></option>
                                 <?php }} } ?>			
                              </select>
                           </div>
                           <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="crm/sale_orders" disabled="disabled">
                        </div>
                     </div>
                  </form>
                  <!-- Filter div End-->
               </div>
            </div>
	  </div>

   <?php if($this->session->flashdata('message') != ''){
      echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      }?>	
   <?php //if(!empty($sale_orders)){ ?>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
         <input type="hidden" value='sale_order' id="table" data-msg="Sale Order" data-path="crm/sale_orders"/>
         <input type="hidden" value='sale_order' id="favr" data-msg="Sale Order" data-path="crm/sale_orders" favour-sts="1"/>
         
         <div class="btn-group"  role="group" aria-label="Basic example">
		    <?php if($can_add) {
               //echo '<a href="'.base_url().'crm/editSaleOrder/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
               	echo '<button type="button" class="btn btn-success add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="sale_order"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
               } ?>
            <?php /*<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button> */ ?>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
            
            <form action="<?php echo base_url(); ?>crm/sale_orders" method="get" style="display:inline-block;">
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];}?>' class='end_date' name='end'/>
               <input type="hidden" name="tab" value="<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>"/>
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
            <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
            <div class="Validate">
               <button type="button" class="btn btn-default velidate" data-toggle="collapse" data-target="#demo3">Validate<span class="caret"></span>
               </button>
               <div id="demo3" class="collapse">
                  <div class='hidde ' style="pointer-events:">
                     <div>Approve:
                        <input type='radio' class='validate' name='status_' value='Approve'/ >
                     </div>
                     <div>Disapprove:
                        <input type='radio' class='disapprove' name='status_' value='Disapprove'/ >
                     </div>
                     <p class='disapprove_reason'></p>
                  </div>
               </div>
            </div>-->
         </div>
         <div class="col-md-3 col-xs-12 datePick-right">
            
            <form action="<?php echo site_url(); ?>crm/sale_orders?tab"<?php if(isset($_GET['tab'])){echo $_GET['tab'];}?> method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];}?>' class='end_date' name='end'/>
               <input type="hidden" value='<?php if(!empty($_GET['tab'])){echo $_GET['tab'];}?>' name='tab'/>
               <input type="hidden" value='<?php if(!empty($_GET['search'])){echo $_GET['search'];}?>' name='search'/>
               <input type="hidden" value='<?php if(!empty($_GET['favourites'])){echo $_GET['favourites'];}?>' name='favourites'/>
               <input type="hidden" value='<?php if(!empty($_GET['company_unit'])){echo $_GET['company_unit']; }?>' class='company_unit' name='company_unit'/>
            </form>
         </div>
      </div>
   </div>
   <?php //} ?>			
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#inprocess_sale_order" role="tab" id="inprocess_sale_order_tab" data-toggle="tab" aria-expanded="true" onClick="inprocess_saleorderc();">In Process Sale Order</a></li>
         <li role="presentation" class=""><a href="#complete_sale_order" id="complete_sale_order_tab" role="tab" data-toggle="tab" aria-expanded="false" onClick="complete_saleorderc();">Complete Sale Order</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="inprocess_sale_order" aria-labelledby="inprocess_sale_order_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">	
            <div id="print_div_content">
               <form id="inprocess_saleordr_frm">	<input type="hidden" value="inProcessorder" name="tab">	</form>
               <!-------------datatable-buttons--------->          
               <?php 	/* <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3"> */ ?>
               <table id="" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3">
               <thead>
                  <tr>
                     <th></th>
                     <th scope="col">Id
                        <span><a href="<?php echo base_url(); ?>crm/sale_orders?tab=inProcessorder&sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>crm/sale_orders?tab=inProcessorder&sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">Sale Order No.
                        <span><a href="<?php echo base_url(); ?>crm/sale_orders?tab=inProcessorder&sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>crm/sale_orders?tab=inProcessorder&sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">Account Name
                        <span><a href="<?php echo base_url(); ?>crm/sale_orders?tab=inProcessorder&sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>crm/sale_orders?tab=inProcessorder&sort=desc" class="down"></a></span>
                     </th>
                    
                     <th scope="col">Order Date</th>
                     <th scope="col">Dispatch Date</th>
                     <!--th scope="col">Payment Terms</th-->
                     <th scope="col">Validate</th>
                     <th scope="col">Created By</th>
                     <th scope="col">Edited Date</th>
                     <th scope="col">Created Date</th>
                     <th scope="col" class='hidde'>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if(!empty($sale_orders)){
                     $disabledClass = '';
                     $disableEdit = "";
                       foreach($sale_orders as $sale_order){
                     
                     // if($sale_order['save_status'] == 0){
                     	// $disabledClass = 'disableBtnClick';
                     	// $disableEdit = 'disabled';
                     // }
                     $orderDate = ($sale_order['order_date']!='')?date("j F , Y", strtotime($sale_order['order_date'])):'';		
                     $dispatchDate = ($sale_order['dispatch_date']!='')?date("j F , Y", strtotime($sale_order['dispatch_date'])):'';
                     $disable = (($sale_order['save_status'] == 0) || ($sale_order["approve"] == 1) || ($can_validate == ''))?'disabled':''; 
                     $disableDispatch = (($sale_order['save_status'] == 0) || ($sale_order["approve"] == 0) )?'disabled':''; 
                     $disableDispatchModalClass = (($sale_order['save_status'] == 0) || ($sale_order["approve"] == 0) )?'':'add_crm_tabs'; 
                     $action = '';
                      if($can_edit) { 
                     	$disableEdit = (($sale_order["approve"] == 1))?'disabled':''; // if PI is in draft than it will not be approved or disapprove
                     	if($sale_order["approve"] == 0){
                     		$cls_for_modal = 'add_crm_tabs';
                     		}else{
                     		 $cls_for_modal = '';
                     		}
                     	$action =  '<a href="javascript:void(0)" id="'. $sale_order["id"] . '" data-id="sale_order" data-tooltip="Edit" class="'.$cls_for_modal.' btn btn-edit  btn-xs" id="' . $sale_order["id"] . '" '.$disableEdit.'><i class="fa fa-pencil"></i>  </a>';
                     }
                     
                     #if($can_view) {				 
                     $action .=  '<a href="javascript:void(0)" id="'. $sale_order["id"] . '" data-id="sale_order_view" data-tooltip="View" class="add_crm_tabs btn btn-view btn-xs" id="' . $sale_order["id"] . '"><i class="fa fa-eye"></i>  </a>';
                     #}
                     if($can_delete) { 
                     	$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deleteSaleOrder/'.$sale_order["id"].'"><i class="fa fa-trash"></i></a>';
                     }
                     // if(($sale_order['save_status'] == 1) && ($sale_order["approve"] == 1) ){
                    // $action .=  '<a href="javascript:void(0)" id="'. $sale_order["id"] . '" data-id="sale_order_dispatch" data-tooltip="Dispatch" class="'.$disableDispatchModalClass.' btn btn-view  btn-xs" id="' . $sale_order["id"] . '" '.$disableDispatch.'><i class="fa fa-space-shuttle"></i>  </a>';
                     // }
                     $action .= '<a href="javascript:void(0)" id="'. $sale_order["id"] . '" data-id="sale_order_invoice" data-tooltip="Convert to Invoice" class="'.$disableDispatchModalClass.' btn btn-view  btn-xs" id="' . $sale_order["id"] . '" '.$disableDispatch.'><i class="fa fa-space-shuttle"></i>  </a>';
                     
                     // $action = $action.'<a href="javascript:void(0)" id="'. $sale_order["id"] . '"data-id="AddSimilarSO" data-tooltip="Add Similar Sale Order" class="add_crm_tabs btn  add-machine  btn-xs"><i class="fa fa-clone" aria-hidden="true"></i></a>';
                     // $action = $action.'<a href="javascript:void(0)" id="'. $sale_order["id"] . '"data-id="ProgessOfSO" data-tooltip="Progess Gantt Chart of Sale Order" class="add_crm_tabs btn btn-xs btn-edit"><i class="fa fa-line-chart" aria-hidden="true"></i></a>';
                     
                     $accountName = ($sale_order['account_id']!=0)?(getNameById('account',$sale_order['account_id'],'id')):'';
                     if(!empty($accountName)){
                     	$accountName = $accountName->name;
                     }else{
                     	$accountName = '';
                     }
                     
                     
                     $contactName = ($sale_order['contact_id']!=0)?(getNameById('contacts',$sale_order['contact_id'],'id')):'';
                     if(!empty($contactName)){
                     	$contactName = $contactName->first_name.' '.$contactName->last_name;
                     }else{
                     	$contactName = '';
                     }
                     
                     $validatedBy = ($sale_order['validated_by']!=0)?(getNameById('user_detail',$sale_order['validated_by'],'id')):'';
                     if(!empty($validatedBy)){
                     	$validatedByName = $validatedBy->name;
                     }else{
                     	$validatedByName = '';
                     }				
                     
                     $selectApprove = $sale_order['approve']==1?'checked':'';
                     $selectDisapprove = $sale_order['disapprove']==1?'checked':'';
					 
					 if($sale_order['modified_date'] == ''){
						 $modified_date = '00-00-0000';
					 }else{
						 $modified_date = date("j F , Y", strtotime($sale_order['modified_date']));
						 
					 }
                     
                     
                     
                     $draftImage = '';
                     if($sale_order['save_status'] == 0)
                     $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" width="25%">';
                     //<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox' data-ai=".$sale_order['account_id']." value=".$sale_order['id'].">
                     echo "<tr>											   
                     			<td>";
                     			if($sale_order['favourite_sts'] == '1'){
                     					echo "<input class='star' type='checkbox'  title='Mark Record' value=".$sale_order['id']."  checked = 'checked'><br/>";
                     					echo"<input type='hidden' value='sale_order' id='favr' data-msg=''Sale Order Unmarked' data-path='crm/sale_order' favour-sts='0' id-recd=".$sale_order['id'].">";
                     			}else{
                     					echo "<input class='star' type='checkbox'  title='Mark Record' value=".$sale_order['id']."><br/>";
                     					echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order Marked' data-path='crm/sale_order' favour-sts='1' id-recd =".$sale_order['id'].">";
                     			}
                     			
                     			echo "</td>
                     	<td data-label='Id:' class='sale_order_id' >". $draftImage . $sale_order['id']."</td>
                     	<td data-label='Id:'>". $sale_order['so_order']."</td>
                     	<td>".$accountName."</td>";
                     
						if($sale_order['product'] !=''){
							$products=json_decode($sale_order['product']);
							$createdByData = getNameById('user_detail',$sale_order['created_by'],'u_id');
							if(!empty($createdByData)){
                        		$createdByName = $createdByData->name;
                        	}else{
                        	$createdByName = '';
                        	}
							$subtotal = 0;
							foreach($products as $product){
								 // pre($product);
								$productDetail = getNameById('material',$product->product,'id');
								$subtotal += $product->individualTotal;
								$materialName = !empty($productDetail)?$productDetail->material_name:'';
							}
					}
						//<td><a href='javascrip:void(0)' id=". $sale_order["id"] . " data-id='sale_order_viewmat' class='add_crm_tabs' >".$materialName."</a></td>
						 //<td>".$sale_order['payment_terms']."</td>	
                     	echo "
                        <td>".$orderDate."</td>
                        <td>".$dispatchDate."</td>	
                       
                        <td><p>";
                        if($selectApprove =='checked'){
                        echo "
                        Approve:
                        	<input type='radio' class='validate1' name='status_".$sale_order['id']."' value='Approve'/ ".$selectApprove." ".$disable."> Disapprove:
                        	<input type='radio' class='disapprove' name='status_".$sale_order['id']."' value='Disapprove'/ ".$selectDisapprove.$disable." disabled>
                        	<p class='disapprove_reason'>".$sale_order['disapprove_reason']."</p>
                        	<p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                        }else{
                        	echo "
                        	Approve:
                        	<input type='radio'  class='validate1' name='status_".$sale_order['id']."' value='Approve'/ ".$selectApprove.$disable."> Disapprove:
                        	<input type='radio' class='disapprove' name='status_".$sale_order['id']."' value='Disapprove'/ ".$selectDisapprove.$disable.">
                        	<p class='disapprove_reason'>".$sale_order['disapprove_reason']."</p>
                        	<p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                        }
                        echo "<td>".$createdByName."</td>	
                        <td>".$modified_date."</td>	
                        <td>".date("j F , Y", strtotime($sale_order['created_date']))."</td>	
                        <td class='hidde'>".$action."</td>	
                        </tr>";
						
                        @$output[] = array(
                         'Sale Order No' =>  $sale_order['so_order'],
                        'Account Name' => $accountName,
                        //'Contact Name' => $contactName,
                        'Order Date' =>   date('d-m-Y',strtotime($orderDate)),
                        'Dispatch Date' =>date('d-m-Y',strtotime($dispatchDate)),
                        'Sub Total' =>    $subtotal,
                        // 'Total' =>        $sale_order['grandTotal'],
                        //'Payment Terms' =>$sale_order['payment_terms'],
                        'Created By' =>   $createdByName,
                        'Created Date' => date("d-m-Y", strtotime($sale_order['created_date'])),
                        );	
                        }
						 // pre($output);
                        $data3  = $output;
                        export_csv_excel($data3);
                        } ?>
                     </tbody>                   
                  </table>
            </div>
         </div>
         <!-------------------tab leads------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="complete_sale_order" aria-labelledby="complete_sale_order_tab">
         <div id="print_div_content">
         <!-------------datatable-buttons--------->          
         <form id="completee_saleordr_frm">	<input type="hidden" value="complete_order" name="tab">	</form>
         <table id="" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3">
         <thead>
         <tr>
         <th>Id
         <span><a href="<?php echo base_url(); ?>crm/sale_orders?tab=complete_order&sort=asc" class="up"></a>
         <a href="<?php echo base_url(); ?>crm/sale_orders?tab=complete_order&sort=desc" class="down"></a></span></th>
         <th>Sale Order No.
         <span><a href="<?php echo base_url(); ?>crm/sale_orders?tab=complete_order&sort=asc" class="up"></a>
         <a href="<?php echo base_url(); ?>crm/sale_orders?tab=complete_order&sort=desc" class="down"></a></span></th> 
         <th>Account Name
         <span><a href="<?php echo base_url(); ?>crm/sale_orders?tab=complete_order&sort=asc" class="up"></a>
         <a href="<?php echo base_url(); ?>crm/sale_orders?tab=complete_order&sort=desc" class="down"></a></span></th>
        
         
         <th>Order Date</th>
         <th>Dispatch Date</th>
         <th>Payment Terms</th>
         <th>Validate</th>
         <th>Created By</th>
         <th>Created Date</th>
         <th class='hidde'>Action</th>
         </tr>
         </thead>
         <tbody>
         <?php if(!empty($complete_sale_orders)){
            $disabledClass = '';
            $disableEdit = "";
              foreach($complete_sale_orders as $complete_sale_order){
			  
            $orderDate = ($complete_sale_order['order_date']!='')? date("j F , Y", strtotime($complete_sale_order['order_date'])):'';
				
            $dispatchDate = ($complete_sale_order['dispatch_date']!='')?date("j F , Y", strtotime($complete_sale_order['dispatch_date'])):'';
            $disable = (($complete_sale_order['save_status'] == 0) || ($complete_sale_order["approve"] == 1) || ($can_validate == ''))?'disabled':''; 
            $action = '';
             if($can_edit) { 
            	$disableEdit = (($complete_sale_order["approve"] == 1))?'disabled':''; // if PI is in draft than it will not be approved or disapprove
            	if($complete_sale_order["approve"] == 0){
            		$cls_for_modal = 'add_crm_tabs';
            		}else{
            		 $cls_for_modal = '';
            		}
            	#$action =  '<a href="javascript:void(0)" id="'. $complete_sale_order["id"] . '" data-id="sale_order" data-tooltip="Edit" class="'.$cls_for_modal.' btn btn-edit  btn-xs" id="' . $complete_sale_order["id"] . '" '.$disableEdit.'><i class="fa fa-pencil"></i>  </a>';
            }
            #if($can_view) {				 
            $action .=  '<a href="javascript:void(0)" id="'. $complete_sale_order["id"] . '" data-id="sale_order_view" data-tooltip="View" class="add_crm_tabs btn btn-view btn-xs" id="' . $complete_sale_order["id"] . '"><i class="fa fa-eye"></i>  </a>';
            #}
            
            #	$action .=  '<a href="javascript:void(0)" id="'. $complete_sale_order["id"] . '" data-id="sale_order_dispatch" data-tooltip="Edit" class="'.$cls_for_modal.' btn btn-edit  btn-xs" id="' . $complete_sale_order["id"] . '" '.$disableEdit.'><i class="fa fa-space-shuttle"></i>  </a>';
            
            if($can_delete ) { 
            $action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
            btn btn-delete btn-xs" data-href="'.base_url().'crm/deleteSaleOrder/'.$complete_sale_order["id"].'"><i class="fa fa-trash"></i></a>';
            }
            $accountName = ($complete_sale_order['account_id']!=0)?(getNameById('account',$complete_sale_order['account_id'],'id')):'';
            if(!empty($accountName)){
            	$accountName = $accountName->name;
            }else{
            	$accountName = '';
            }
            
            
            $contactName = ($complete_sale_order['contact_id']!=0)?(getNameById('contacts',$complete_sale_order['contact_id'],'id')):'';
            if(!empty($contactName)){
            	$contactName = $contactName->first_name.' '.$contactName->last_name;
            }else{
            	$contactName = '';
            }
            
            $validatedBy = ($complete_sale_order['validated_by']!=0)?(getNameById('user_detail',$complete_sale_order['validated_by'],'id')):'';
            if(!empty($validatedBy)){
            	$validatedByName = $validatedBy->name;
            }else{
            	$validatedByName = '';
            }				
            
            $selectApprove = $complete_sale_order['approve']==1?'checked':'';
            $selectDisapprove = $complete_sale_order['disapprove']==1?'checked':'';
            
            $saleorderid = '';
            if($complete_sale_order['complete_status'] == 1)
            	$saleorderid = $complete_sale_order['so_order'];
            
            $draftImage = '';
            if($complete_sale_order['save_status'] == 0)
            $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" width="25%">';
            
            echo "<tr>
            	<td class='sale_order_id' >". $draftImage . $complete_sale_order['id']."</td>
            	<td>".$saleorderid."</td>
            	<td>".$accountName."</td>";?>
         <!---- datatable-buttons ---->
         
         <?php 
            if($complete_sale_order['product'] !=''){
            	$products=json_decode($complete_sale_order['product']);
            	$createdByData = getNameById('user_detail',$complete_sale_order['created_by'],'u_id');
            	if(!empty($createdByData)){
            		$createdByName = $createdByData->name;
            	}else{
            	$createdByName = '';
            	}
            	
            	foreach($products as $product){
            	$productDetail = getNameById('material',$product->product,'id');
            	$materialName = !empty($productDetail)?$productDetail->material_name:'';
            	$ww =  getNameById('uom', $product->uom,'id');
            	$uom = !empty($ww)?$ww->ugc_code:'';
            		
            	} 
            }
           
            //echo "<a href='javascrip:void(0)' id=". $complete_sale_order["id"] . " data-id='sale_order_viewmat' class='add_crm_tabs' >".$materialName."</a></td>";
			echo "
                        <td>".$orderDate."</td>
                        <td>".$dispatchDate."</td>	
                        <td>".$complete_sale_order['payment_terms']."</td>	
                        <td><p>";
       
            if($selectApprove =='checked'){
            echo "
            Approve:
            	<input type='radio' class='validate' name='status_".$complete_sale_order['id']."' value='Approve'/ ".$selectApprove." ".$disable."> Disapprove:
            	<input type='radio' class='disapprove' name='status_".$complete_sale_order['id']."' value='Disapprove'/ ".$selectDisapprove.$disable." disabled>
            	<p class='disapprove_reason'>".$complete_sale_order['disapprove_reason']."</p>
            	<p class='validatedBy'>Validated By: ".$validatedByName."</p>";
            }else{
            	echo "
            	Approve:
            	<input type='radio' class='validate' name='status_".$complete_sale_order['id']."' value='Approve'/ ".$selectApprove.$disable."> Disapprove:
            	<input type='radio' class='disapprove' name='status_".$complete_sale_order['id']."' value='Disapprove'/ ".$selectDisapprove.$disable.">
            	<p class='disapprove_reason'>".$complete_sale_order['disapprove_reason']."</p>
            	<p class='validatedBy'>Validated By: ".$validatedByName."</p>";
            }
            echo "<td>".$createdByName."</td>	
            <td>".date("j F , Y", strtotime($complete_sale_order['created_date']))."</td>	
            <td class='hidde'>".$action."</td>	
            </tr>";
            @$output[] = array(
             'Sale Order No' =>  $complete_sale_order['so_order'],
            'Account Name' => $accountName,
            'Contact Name' => $contactName,
            'Order Date' =>   date('d-m-Y',strtotime($orderDate)),
            'Dispatch Date' =>date('d-m-Y',strtotime($dispatchDate)),
            'Sub Total' =>    $complete_sale_order['total'],
            'Total' =>        $complete_sale_order['grandTotal'],
            'Payment Terms' =>$complete_sale_order['payment_terms'],
            'Created By' =>   $createdByName,
            'Created Date' => date("d-m-Y", strtotime($complete_sale_order['created_date']))
            );	
            }
            $data3  = $output;
            export_csv_excel($data3);
            } ?>
         </tbody>                   
         </table>
         </div>
         </div>
         <!-----------------------------end tab------------------------------------>
      </div>
      <?php echo $this->pagination->create_links(); ?>
   </div>
</div>
<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
</button>
<h4 class="modal-title" id="myModalLabel">Reason</h4>
</div>
<div class="modal-body">
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/disApproveSaleOrder" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
<input type="hidden" name="id" value="" id="sale_order_id">
<input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
<input type="hidden" id="disapprove" name="disapprove" value="1">
<input type="hidden" id="disapprove" name="approve" value="0">
<input type="hidden" id="aci" name="aci" value="">
<div class="item form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments<span class="required">*</span></label>
<div class="col-md-6 col-sm-6 col-xs-12">														
<textarea id="disapprove_reason" required="required" rows="6" name="disapprove_reason" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>													
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<input type="submit" class="btn btn-warning" value="Submit">
</div>
</form>
</div>
</div>
</div>
</div>
<div id="crm_add_modal" class="modal fade in"  role="dialog">
<div class="modal-dialog modal-lg modal-large">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
</button>
<h4 class="modal-title nxt_cls"></h4>
</div>
<div class="modal-body-content"></div>
</div>
</div>
</div>
<div class="modal fade" id="variant_List" role="dialog">
    <div class="modal-dialog ">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">variant List</h4>
        </div>
        <div class="modal-body">
        
        </div>
        <div class="modal-footer">
         <button type="button" class="variant_submit btn btn-default">Submit</button>
          <button type="button" class="close_vlist btn btn-default">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<script>
   var measurementUnits = '<?php echo json_encode(measurementUnits()); ?>';
</script>
<?php	
   /*
   if(isset($_POST["ExportType"]))
   {
   
    ob_end_clean();
       switch($_POST['ExportType'])
       {
   		case "export-to-excel" :
               // Submission from
               $filename = $_POST["ExportType"] . ".xlsx";       
               header("Content-Type: application/vnd.ms-excel");
               header("Content-Disposition: attachment; filename=\"$filename\"");
   			//pre($data3);die();
   		    ExportFile($data3);
               exit();
           case "export-to-csv" :
               // Submission from
               $filename = $_POST["ExportType"] . ".csv";            
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-type: text/csv");
               header("Content-Disposition: attachment; filename=\"$filename\"");
               header("Expires: 0");
               ExportCSVFile($data3);
               //$_POST["ExportType"] = '';
               exit();
   		default :         
               die("Unknown action : ".$_POST["action"]);
               break;
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
   */
   ?>