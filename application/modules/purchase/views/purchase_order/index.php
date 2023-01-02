 

<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
?>
<div class="x_content stik">
   <div class="col-md-12 col-sm-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>purchase/purchase_order">
            <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
         </form>
         <form class="form-search" method="get" action="<?= base_url() ?>purchase/purchase_order">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter Id,Order No" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="purchase/purchase_order?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
                  <input type="hidden" value='<?php  if(isset($_GET['tab']))echo $_GET['tab']; ?>' name="tab"/>
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=<?php  if(isset($_GET['tab']))echo $_GET['tab'];?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
            <div class="col-md-4 col-xs-12 col-sm-4 datePick-left">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="purchase/purchase_order"> 
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?php echo base_url(); ?>purchase/purchase_order" method="get" id="date_range">	
                  <input type="hidden" value='' class='start_date' name='start'/>
                  <input type="hidden" value='' class='end_date' name='end'/>
                  <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
               </form>
            </div>
            <!-- Filter div Start-->
            <form action="<?php echo base_url(); ?>purchase/purchase_order" method="get">
               <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
               <div class="row hidde_cls filter1">
                  <div class="col-md-12">
                     <div class="btn-group"  role="group" aria-label="Basic example">
                        <select class="form-control select_mat disbled_cls select2-width-imp" name="material_type" data-id="material_type" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0">
                           <option value="">Select Material</option>
                        </select>
                     </div>
                     <div class="btn-group"  role="group" aria-label="Basic example">
                        <select class="form-control supp_name disbled_cls select_supplier select2-width-imp" name="departments" data-id="supplier" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" >
                           <option value="">Select Supplier</option>
                        </select>
                     </div>
                     <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                        <select name="company_unit" class="form-control company_unit select2-width-imp" placeholder="Select Company Unit Address">
                           <option value=""> Select Category </option>
                           <?php
                              if(!empty($company_unit_adress) ){
                              	foreach($company_unit_adress as $companyAdress){
                              	$getAddress = $companyAdress['address'];
                              	
                              	$getDecodeAddress = json_decode($getAddress);
                              	foreach($getDecodeAddress as $fetchAddress){
                              		$address = $fetchAddress->address;
                              ?>
                           <option value="<?php echo $fetchAddress->add_id; ?>" <?php if ($address == $_POST['company_unit']) echo "selected";?> selected><?php echo $address; ?></option>
                           <?php }} } ?>			
                        </select>
                     </div>
                     <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                        <select class="form-control select2-width-imp" id="approved_material_type" name="purchase_type"  width="100%" tabindex="-1" aria-hidden="true" >
                           <option value="" style="color: #999 !important;"> Select Type</option>
                           <option value="2" >Domestic</option>
                           <option value="1">Import</option>
                        </select>
                     </div>
                     <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="purchase/purchase_order" disabled="disabled">
                  </div>
               </div>
            </form>
            <!-- Filter div End-->
         </div>
      </div>
      <div >
      </div>
      <div class="col-md-12">
         <div class=" export ">
            <form action="<?php echo base_url(); ?>purchase/purchase_order?tab=<?php  if(isset($_GET['tab']))echo $_GET['tab']; ?>" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <!--input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/-->
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
               <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
               <input type="hidden" value='<?php echo $_GET['material_type']; ?>' class='material_type' name='material_type'/>
               <input type="hidden" value='<?php echo $_GET['departments']; ?>' class='departments_type' name='departments'/>
               <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
               <input type="hidden" value='<?php echo $_GET['company_unit']; ?>' name="company_unit"/>
               <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
               <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
            </form>
         </div>
      </div>
      <div class="row hidde_cls stik">
         <div class="col-md-12 col-xs-12">
            <div class="export_div">
               <div class="btn-group"  role="group" aria-label="Basic example">
                  <?php if($can_add) { echo '<button type="buttton" class="btn btn-info order addBtn add_purchase_tabs" id="PO" data-id="po_edit" data-toggle="modal"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button></a>'; } ?>	
                  
                  <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="<?php echo ( $_GET['tab'] == 'complete' )?'bbtn22':'bbtn'; ?>">Print</button>
                  <input type="hidden" value='purchase_order' id="table" data-msg="Purchase Order" data-path="purchase/purchase_order"/>                       
                  <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                     <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                     <ul class="dropdown-menu" role="menu" id="export-menu">
                        <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                        <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                     </ul>
                  </div>
                  <form action="<?php echo base_url(); ?>purchase/purchase_order" method="get" >
                     <input type="hidden" value='1' name='favourites'/>
                     <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
                     <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
                     <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#in_progress_tab" data-select='progress' id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="poinprocess_form3()">In Process</a></li>
         <li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onClick="pocomplete_form3()">Complete</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">	
            <form id="poinprocess_form"><input type="hidden" value="inprocess" name="tab"></form>
            <div id="print_div_content">
               <div class="table-responsive">
                  <?php  /* <table id="example" class="table table-bordered user_index sale_order_index inprocess_div" data-id="user" style="width:100%;" border="1" cellpadding="2" data-order='[[1,"desc"]]'> */ ?>
                  <table id="" class="table table-bordered user_index sale_order_index inprocess_div" data-id="user" style="width:100%;" border="1" cellpadding="2">
                     <thead>
                        <tr>
                           <th><input id="selecctall" type="checkbox"></th>
                           <th scope="col">Id
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Order Number
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Created Through
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=desc" class="down"></a></span>                       
                           </th>
                           <th scope="col">Supplier Name
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Material Detail</th>
                           <th scope="col">Grand Total</th>
                           <th scope="col">Payment Terms</th>
                           <?php if( checkPurchaseApprove() ){
                                 echo '<th scope="col">Approve</th>';   
                           } ?>
                           <th scope="col">Expected Delivery Date</th>
                           <th scope="col">Order Date</th>
						    <th class='hidde'>Validate</th>
                           <th scope="col">Created By</th>
                           <th scope="col" class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           if (!empty($purchase_order_inProcess)) {
                                                $total_sum=0;
							foreach ($purchase_order_inProcess as $order_inprocess) {
							$supplierName = getNameById('supplier', $order_inprocess['supplier_name'], 'id');
							$matriealtype_name = ($order_inprocess['material_type_id']!=0)?(getNameById('material_type',$order_inprocess['material_type_id'],'id')->name):'';
							$pi_code = getNameById('purchase_indent', $order_inprocess['pi_id'], 'id');
							$MRNCreated = ($order_inprocess['mrn_or_not'] == 1) ? ' ' : '';
							$draftImage = ($order_inprocess['save_status'] == 0)?'<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="'.base_url().'assets/images/draft.png" > </a>':'';
							 $validatedBy = ($order_inprocess['validated_by']!=0)?(getNameById('user_detail',$order_inprocess['validated_by'],'u_id')):''; 
                               $validatedByName = (!empty($validatedBy))?$validatedBy->name:''; // get the name of user who validate the PO
							
							
							?>
                        <tr style="background:<?php echo $MRNCreated; ?>">
                           <td><?php if($order_inprocess["used_status"]==0){echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$order_inprocess['id'].">";}
                              if($order_inprocess['favourite_sts'] == '1'){
                                                 echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$order_inprocess['id']."  checked = 'checked'>";
                                                 echo"<input type='hidden' value='purchase_order' id='favr' data-msg='Purchase Order' data-path='purchase/purchase_order' favour-sts='0' id-recd=".$order_inprocess['id'].">";
                                           }else{
                                              echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$order_inprocess['id'].">";
                                              echo"<input type='hidden' value='purchase_order' id='favr' data-msg='Purchase Order' data-path='purchase/purchase_order' favour-sts='1' id-recd =".$order_inprocess['id'].">";
                                           }
                              ?></td>
                           <td data-label="Id:">
                              <?php echo $draftImage . $order_inprocess['id']; ?>
                           </td>
                           <td data-label="Order Number:">
                              <?php echo $order_inprocess['order_code']; ?>
                           </td>
						   
                           <td data-label="Created Through:">
                              <?php if (!empty($pi_code)) {
                                 echo '<a href="javascript:void(0)" id="'.$order_inprocess['pi_id'].'" data-id="indentView" class="add_purchase_tabs">'.$pi_code->indent_code.'</a>';
                                 		} ?>
                              </a>
                           </td>
                           <td data-label="Supplier Name:">
                              <a href="javascript:void(0)" id="<?php echo $order_inprocess['supplier_name'] ; ?>" data-id="SupplierView" class="add_purchase_tabs"><?php echo (($supplierName == null)?'':$supplierName->name);	?></a>
                           </td>
                         <?php
						 
                               $materialDetail = json_decode($order_inprocess['material_name']);
                             
                                 foreach ($materialDetail as $materialdetail) {
                                    if($materialdetail->material_name_id != '' && $materialdetail->quantity != 0){
									   $material_id = $materialdetail->material_name_id;
									   $materialName = getNameById('material', $material_id, 'id');
										$mat_type_id=getNameById('material_type',$materialdetail->material_type_id,'id');
                                                              
                                    if ($order_inprocess['pi_id'] != 0) {
                                    $dataa = "Through Purchase Indent";
                                    } else {
                                    $dataa = "Without Purchase Indent";
                                    }
                                    if (!empty($materialName)) {
                                    $mat_name =  $materialName->material_name;
                                    } else {
                                    $mat_name =  "Null";
                                    }
                                    
                                    if (!empty($supplierName)) {
                                    $supp_name =  $supplierName->name;
                                    } else {
                                    $supp_name =  "Supplier Does not exist";
                                    }
                                    if($order_inprocess['mrn_or_not'] == '0'){
                                    $mrn_or_notd = 'Material  Not Received';
                                    }elseif($order_inprocess['mrn_or_not'] == '1'){
                                    $mrn_or_notd = 'Material Received';
                                    }
                                    if($order_inprocess['pay_or_not'] == '0'){
                                    $pay_or_notd = 'Payment  Not Received';
                                    }elseif($order_inprocess['pay_or_not'] == '1'){
                                    $pay_or_notd = 'Payment Received';
                                    }
                                    if (!empty($mat_type_id)) { $mat_data =  $mat_type_id->name;	}else{ $mat_data =  $matriealtype_name; }
                                    $output[] = array(
                                    'ID' => $order_inprocess['id'],
                                    'Order Code' => $order_inprocess['order_code'],
                                    'Created Through' => $dataa,
                                    'Supplier Name' => $supp_name,
                                    'Material Type' => $mat_data,
                                    'Material Name' => $mat_name,
                                    'Quantity' => @$materialdetail->quantity,
                                    'GST' => @$materialdetail->gst,
                                    'Sub Total' => @$materialdetail->sub_total,
                                    'Sub Tax' => @$materialdetail->sub_tax,
                                    'Total' => @$materialdetail->total,
                                    'Payment' => @$pay_or_notd,
                                    'Material' => @$mrn_or_notd,
                                    'Created Date' => date("d-m-Y", strtotime($order_inprocess['date'])),
                                    );
                                    $output_blank[] = array(
                                      'order_code' => '',
                                      'pi_id' => '',
                                      'supplier_name' => '',
                                      'material_type_id' => '',
                                      'quantity' => '',
                                      'gst' => '', 
                                      'sub_total' => '',
                                      'sub_tax' => '',
                                      'total' => '',
                                      'pay_or_not' => '',
                                      'mrn_or_not' => '',
                                      
                                    );		
                                    }
                                    }//if conditions
                                    
                                    ?>
                           
                         
                        <td data-label="Material Detail:">
							<a style="cursor: pointer;" id="<?php echo $order_inprocess['id']; ?>" data-toggle="modal" data-id="PurchaseorderMatView" class="add_purchase_tabs">
							<?php echo $materialName->material_name; ?>
							</a>
							
												
						</td>
						   
						   
                           <td data-label="Grand Total:"><?php echo money_format('%!i',$order_inprocess['grand_total']); ?></td>
                           <td data-label="Payment Terms:"><?php echo $order_inprocess['payment_terms']; ?></td>
                           <!--  purchase order approve funtion start -->
                              <?php if( checkPurchaseApprove()  ){
                                       $userAprData = checkSetComplete($order_inprocess['id']);
                                       $appHtml = '<td data-label="Approve Step:">';   
                                       foreach($userAprData['stepShow'] as $checkAppKey => $checkAppValue){
                                          if($order_inprocess['mrn_or_not'] == 1){
                                             $appHtml .= str_replace('Pending', 'Approve',$checkAppValue )." <br>";
                                          }else{
                                             $appHtml .= "{$checkAppValue}<br>";
                                          }
                                       }
                                       $appHtml .= '</td>';
                                       echo $appHtml;
                              
                              } ?>

                           <!--  purchase order approve funtion end -->


                           <td data-label="Expected Delivery Date:"><?php if($order_inprocess['expected_delivery_date']!='') echo date("j F , Y", strtotime($order_inprocess['expected_delivery_date'])); ?></td>
                           <td data-label="Order Date:"><?php if($order_inprocess['date']!='') echo date("j F , Y", strtotime($order_inprocess['date'])); ?></td>
						  
                           <td class='hidde'> 
                              <?php 
							   // pre($order_inprocess);
                                 $selectApprove = $order_inprocess['approve']==1?'checked':'';
                                 $selectDisapprove = $order_inprocess['disapprove']==1?'checked':'';
                                 if($selectApprove =='checked'){
									 
                                 echo "
                                 Approve:
                                    <input type='radio' class='validatePO' data-idd='".$order_inprocess['id']."' name='status_".$order_inprocess['id']."' value='Approve'/ ".$selectApprove." > Disapprove:
                                    <input type='radio' class='disapprovePO' data-idd='".$order_inprocess['id']."' name='status_".$order_inprocess['id']."' value='Disapprove'/ ".$selectDisapprove." disabled>
                                    <p class='disapprove_reason'>".$order_inprocess['disapprove_reason']."</p>
                                    <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                                 }else{
                                    echo "
                                    Approve:
                                    <input type='radio' class='validatePO' data-idd='".$order_inprocess['id']."' name='status_".$order_inprocess['id']."' value='Approve'/ ".$selectApprove."> Disapprove:
                                    <input type='radio' class='disapprovePO' data-idd='".$order_inprocess['id']."' name='status_".$order_inprocess['id']."' value='Disapprove'/ ".$selectDisapprove.">
                                    <p class='disapprove_reason'>".$order_inprocess['disapprove_reason']."</p>
                                    <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                                 }
                                 ?>
                           </td>
						   
						   
						   
						   
                           <td data-label="Action:"><?php //echo (($order_inprocess['created_by']!=0)?(getNameById('user_detail',$order_inprocess['created_by'],'u_id')->name):'').'<br>'.(($order_inprocess['edited_by']!=0)?(getNameById('user_detail',$order_inprocess['edited_by'],'u_id')->name):''); 
                              echo "<a href='".base_url()."users/edit/".$order_inprocess['created_by']."' target='_blank'>".(($order_inprocess['created_by']!=0)?(getNameById('user_detail',$order_inprocess['created_by'],'u_id')->name):'')."</a>";
                              ?></td>
                           <td data-label="Created By:" class='hidde'>
                              <?php 
                                 #if($can_edit && $order_inprocess['save_status'] == 0 ) { 
                                 $showBtnApprove = false;
                                 if( checkPurchaseApprove() && $order_inprocess['mrn_or_not'] != 1 ){
                                    $userAprData = checkSetComplete($order_inprocess['id']);
                                    $showBtnApprove = showApproveBtnInPo($userAprData['userId']);
                                 }

                                 if( $showBtnApprove ){
                                    echo '<button data-tooltip="Approve" id="'.$order_inprocess["id"].'" class="btn btn-edit btn-xs order add_purchase_tabs" data-id="po_approve"><i class="fa fa-check" aria-hidden="true"></i></button>';   
                                 }
                                 

                                 if($can_edit && $order_inprocess['mrn_or_not'] == 0 && $order_inprocess['gate_or_not'] != 1 ) {
                                       if( checkPurchaseApprove() ){ 
                                          $userAprData = checkSetComplete($order_inprocess['id']);

                                          if( !in_array('Disapproved',$userAprData['poStatus'])  ){
                                            if( in_array('Pending',$userAprData['poStatus']) ){
                                                echo '<button data-tooltip="Edit" id="'.$order_inprocess["id"].'" class="btn btn-edit btn-xs order add_purchase_tabs" data-id="po_edit"><i class="fa fa-pencil"></i></button>';
                                            }
                                          }  

                                       }else if($order_inprocess['approve'] != 1){
                                          echo '<button data-tooltip="Edit" id="'.$order_inprocess["id"].'" class="btn btn-edit btn-xs order add_purchase_tabs" data-id="po_edit"><i class="fa fa-pencil"></i></button>';   
                                       }  
                                 		
                                 }	
                                 if ($can_view) {
                                   echo '<button data-tooltip="View" class="btn btn-view btn-xs add_purchase_tabs" data-id="OrderView" id="' . $order_inprocess["id"] . '"><i class="fa fa-eye"></i></button>';
                                 } 
                                 if($can_delete && $order_inprocess["used_status"]==0 && $order_inprocess['approve'] != 1)
                                 		echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                                 	btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_order/'.$order_inprocess["id"].'"><i class="fa fa-trash"></i></a>';?>

                              <?php 

                              if ($order_inprocess['mrn_or_not'] != 1 && $order_inprocess['save_status'] == 1 ):
                                 if( checkGateEnable() ):
                              			if(!$order_inprocess["gate_or_not"]):?>
	                                 		<!-- <button data-id="convertPoToGate" id="<?php echo $order_inprocess['id']; ?>" data-tooltip="GATE" class="btn  btn-xs convert add_purchase_tabs"><img src="<?php  echo base_url();?>assets/modules/crm/uploads/convert.png">
	                                 		</button>  -->
                              <?php 	endif;
                              	endif;
                              endif;
                             
							 
                                    $title   = "Grn";
                                    $data_id = "convert_to_mrn";
                                    $id      = $order_inprocess['id'];
                                    $disable = "disabled";
                                    if( checkPurchaseApprove() && $order_inprocess['mrn_or_not'] != 1 && $order_inprocess['approve'] == 1 ){
                                       $userAprData = checkSetComplete($order_inprocess['id']);
                                       if( !in_array('Disapproved',$userAprData['poStatus'])  ){
                                            if( !in_array('Pending',$userAprData['poStatus']) ){
                                                $title   = "Convert To GRN";
                                                $data_id = "convert_to_mrn";
                                                $id      = $order_inprocess['id'];
                                                $disable = "";   
                                            }
                                       }  
                                    }else{
                                       if($order_inprocess['mrn_or_not'] != 1 && $order_inprocess['save_status'] == 1 && $order_inprocess['approve'] == 1  ){
                                             $title   = "Convert To GRN";
                                             $data_id = "convert_to_mrn";
                                             $id      = $order_inprocess['id'];
                                             $disable = "";
                                       }       
                                    }

                              ?>
                                    <button title="<?= $title ?>" data-id="<?= $data_id ?>" id="<?= $id ?>" data-tooltip="GRN" class="btn  btn-xs add_purchase_tabs" <?= $disable ?>>
                                    <img src="<?php  echo base_url();?>assets/modules/crm/uploads/convert.png"></button>
                           </td>
                        </tr>
                        <?php
                           $total_sum+=$order_inprocess['grand_total'];
                                                }
                                                $inprocess_data3  = $output;
                                                export_csv_excel($inprocess_data3);	
                                                
                                                $data_balnk  = $output_blank;
                                                export_csv_excel_blank($data_balnk); 	
                                                }
                                                ?>
                     </tbody>
                     <tr class="boot_strp_Data">
                        <th colspan="6" style="text-align:right;">Total</th>
                        <th  class="totlamt"><?php echo money_format('%!i',$total_sum);?></th>
                        <th colspan="6"></th>
                     </tr>
                  </table>
                  <?php //echo $this->pagination->create_links(); ?>
               </div>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="Complete_content_tab" aria-labelledby="inProcess_TAB">
           
            <form id="pocomplete_form"><input type="hidden" value="complete" name="tab"></form>
            <div id="print_div_content_div">
               <?php  /* <table id="example_tab" class="table table-bordered user_index  complete_div" data-id="user" style="width:100%;" border="1" cellpadding="2" data-order='[[1,"desc"]]'> */ ?>
               <table id="" class="table table-bordered user_index  complete_div" data-id="user" style="width:100%;" border="1" cellpadding="2">
                  <thead>
                     <tr>
                        <th></th>
                        <th scope="col">Id
                           <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=complete&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=complete&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Order Number
                           <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=complete&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=complete&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Created Through
                           <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=complete&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=complete&sort=desc" class="down"></a></span>
                        </th>
                        <?php
                           /* foreach($sort_cols as $field_name => $field_display){ ?>
                        <th><?php echo anchor('purchase/purchase_order/'.$field_name.'/'.($sort_by == $field_name ? $sort_order : 'asc').'/'.$page, $field_display); */?>
                        <th scope="col">Supplier Name
                           <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=complete&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=complete&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Material Detail</th>
                        <th scope="col">Grand Total</th>
                        <th scope="col">Payment Terms</th>
                        <th scope="col">Expected Delivery Date</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Created By</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (!empty($purchase_order)) {
                        $total_sum=0;
                                         foreach ($purchase_order as $order) {
                                         
                                         $supplierName = getNameById('supplier', $order['supplier_name'], 'id');
                                         $matriealtype_name = ($order['material_type_id']!=0)?(getNameById('material_type',$order['material_type_id'],'id')->name):'';
                                         $pi_code = getNameById('purchase_indent', $order['pi_id'], 'id');
                                         $MRNCreated = ($order['mrn_or_not'] == 1) ? ' ' : '';
                                         $draftImage = ($order['save_status'] == 0)?'<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="'.base_url().'assets/images/draft.png" > </a>':'';
                                         ?>
                     <tr style="background:<?php echo $MRNCreated; ?>">
                        <td>
                           <?php
                              if($order['favourite_sts'] == '1'){
                                               echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$order['id']."  checked = 'checked'>";
                                               echo"<input type='hidden' value='purchase_order' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_order' favour-sts='0' id-recd=".$order['id'].">";
                                         }else{
                                            echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$order['id'].">";
                                            echo"<input type='hidden' value='purchase_order' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_order' favour-sts='1' id-recd =".$order['id'].">";
                                         }
                              
                              ?>
                        </td>
                        <td data-label="Id:">
                           <?php echo $draftImage . $order['id']; ?>
                        </td>
                        <td data-label="Order Number:">
                           <?php echo $order['order_code']; ?>
                        </td>
                        <td data-label="Created Through:">
                           <?php if (!empty($pi_code)) {
                              echo '<a href="javascript:void(0)" id="'.$order['pi_id'].'" data-id="indentView" class="add_purchase_tabs">'.$pi_code->indent_code.'</a>';
                              		} ?>
                        </td>
                        <td data-label="Supplier Name:">
                           <a href="javascript:void(0)" id="<?php echo $order['supplier_name'] ; ?>" data-id="SupplierView" class="add_purchase_tabs"><?php echo (($supplierName == null)?'supplier Does not exist':$supplierName->name);?></a>
                        </td>
                        
                           <?php 				
                             // if($order['material_name'] != '' && $order['material_name'] != '	[{"material_name_id":"","uom":"","quantity":"","price":"","sub_tax":"","sub_total":"","gst":"","total":""}]') {  ?>
                         
                              <?php #echo $order['material_name'];
                                 $materialDetail = json_decode($order['material_name']);
                                 $countMaterialDetailLength = count($materialDetail);
                                 $i=1;
                                 foreach ($materialDetail as $materialdetail) {
								// pre($materialdetail);
                                 if($materialdetail->material_name_id != '' && $materialdetail->quantity != 0){
								
                                 $material_id = $materialdetail->material_name_id;
                                 $materialName = getNameById('material', $material_id, 'id');
								 	 	
                                 $mat_type_id=getNameById('material_type',$materialdetail->material_type_id,'id');
                                
                             
                                
                             
                                 if ($order['pi_id'] != 0) {
                                 $dataa = "Through Purchase Indent";
                                 } else {
                                 $dataa = "Without Purchase Indent";
                                 }
                                 if (!empty($materialName)) {
                                 $mat_name =  $materialName->material_name;
                                 } else {
                                 $mat_name =  "Null";
                                 }
                                 
                                 if (!empty($supplierName)) {
                                 $supp_name =  $supplierName->name;
                                 } else {
                                 $supp_name =  "Supplier Does not exist";
                                 }
                                 
                                 if($order['mrn_or_not'] == '0'){
                                 $mrn_or_notd = 'Material  Not Received';
                                 }elseif($order['po_or_not'] == '1'){
                                 $mrn_or_notd = 'Material Received';
                                 }
                                 if($order['pay_or_not'] == '0'){
                                 $pay_or_notd = 'Payment  Not Received';
                                 }elseif($order['pay_or_not'] == '1'){
                                 $pay_or_notd = 'Payment Received';
                                 }
                                 if (!empty($mat_type_id)) { $mat_data = $mat_type_id->name;	}else{ $mat_data = $matriealtype_name; } 
                                 $output_new[] = array(
                                 'Order Code' => $order['order_code'],
                                 'Created Through' => $dataa,
                                 'Supplier Name' => $supp_name,
                                 'Material Type' => $mat_data,
                                 'Material Name' => $mat_name,
                                 'Quantity' => @$materialdetail->quantity,
                                 'GST' => @$materialdetail->gst,
                                 'Sub Total' => @$materialdetail->sub_total,
                                 'Sub Tax' => @$materialdetail->sub_tax,
                                 'Total' => @$materialdetail->total,
                                 'Payment' => @$pay_or_notd,
                                 'Material' => @$mrn_or_notd,
                                 'Created Date' => date("d-m-Y", strtotime($order['created_date'])),
                                 );
                                 
                                 $output_blank[] = array(
                                   'order_code' => '',
                                   'pi_id' => '',
                                   'supplier_name' => '',
                                   'material_type_id' => '',
                                   'quantity' => '',
                                   'gst' => '', 
                                   'sub_total' => '',
                                   'sub_tax' => '',
                                   'total' => '',
                                   'pay_or_not' => '',
                                   'mrn_or_not' => '',
                                   
                                 );			
                                
                        }
                                 
                    }
 ?>
						<td data-label="Material Detail:">
							<a style="cursor: pointer;" id="<?php echo $order['id']; ?>" data-toggle="modal" data-id="PurchaseorderMatView" class="add_purchase_tabs">
							<?php echo $materialName->material_name; ?>
							</a>
							
												
						</td>
                              
                           <?php //} ?>
                      
                        <td data-label="Grand Total:"><?php  echo money_format('%!i',$order['grand_total']); ?></td>
                        <td data-label="Payment Terms:"><?php echo $order['payment_terms']; ?></td>
                        <td data-label="Expected Delivery_Date:"><?php if($order['expected_delivery_date'] !='') echo date("j F , Y", strtotime($order['expected_delivery_date'])); ?></td>
                        <td data-label="Order Date:"><?php if($order['date'] !='') echo date("j F , Y", strtotime($order['date'])); ?></td>
                        <td data-label="created by:"><?php //echo (($order['created_by']!=0)?(getNameById('user_detail',$order['created_by'],'u_id')->name):'').'<br>'.(($order['edited_by']!=0)?(getNameById('user_detail',$order['edited_by'],'u_id')->name):'');
                           echo "<a href='".base_url()."users/edit/".$order['created_by']."' target='_blank'>".(($order['created_by']!=0)?(getNameById('user_detail',$order['created_by'],'u_id')->name):'')."</a>";
                           ?></td>
                        <td data-label="action:" class='hidde'>
                           <?php 
                              #if($can_edit && $order['save_status'] == 0 ) { 
                              if($can_edit && $order['mrn_or_not'] == 0 ) { 
                              		echo '<button id="'.$order["id"].'" class="btn btn-edit btn-xs order add_purchase_tabs" data-id="po_edit"><i class="fa fa-pencil"></i></button>';
                              		
                              }	
                              if ($can_view) {
                                echo '<button data-tooltip="View" class="btn btn-view btn-xs add_purchase_tabs" data-id="OrderView" id="' . $order["id"] . '"><i class="fa fa-eye"></i></button>';
                              }  
                              if($can_delete && $order["used_status"]==0)
                              		echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                              	btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_order/'.$order["id"].'"><i class="fa fa-trash"></i></a>';		

                              								
                              if ($order_inprocess['mrn_or_not'] != 1 && $order_inprocess['save_status'] == 1 ):
                                 if( checkGateEnable() ):
                                       if(!$order_inprocess["gate_or_not"]):?>
                                          <button data-id="convertPoToGate" id="<?php echo $order_inprocess['id']; ?>" data-tooltip="GATE" class="btn  btn-xs convert add_purchase_tabs"><img src="<?php  echo base_url();?>assets/modules/crm/uploads/convert.png">
                                          </button> 
                              <?php    endif;
                                 endif;
                              endif;
                              ?>
                            <?php  if ($order['mrn_or_not'] != 1 && $order['save_status'] == 1) {
                                ?>
                           <button data-id="convert_to_mrn" id="<?php echo $order['id']; ?>" data-tooltip="GRN" class="btn  btn-xs convert add_purchase_tabs">
                           <img src="<?php  echo base_url();?>assets/modules/crm/uploads/convert.png">
                           </button>
                           <?php } else { ?>                
                           <button title="GRN Already Created" data-id="convert_to_mrn" id="javascript:void();" data-tooltip="GRN" class="btn  btn-xs convert indent add_purchase_tabs" disabled>
                           <img src="<?php  echo base_url();?>assets/modules/crm/uploads/convert.png"></button>
                           <?php  } ?>
                        </td>
                     </tr>
                     <?php
                        $total_sum+=$order['grand_total'];
                                          }
                                      $complete_data3  = $output_new;
                                                       export_csv_excel($complete_data3);	
                                                       
                                                       $data_balnk  = $output_blank;
                                                       export_csv_excel_blank($data_balnk);      
                                          }
                                          ?>
                  </tbody>
                  <tr class="boot_strp_Data">
                     <th colspan="6" style="text-align:center;">Total</th>
                     <th  class="totlamt_tab"><?php echo money_format('%!i',$total_sum);?></th>
                     <th colspan="6"></th>
                  </tr>
               </table>
               <?php //echo $this->pagination->create_links(); ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php echo $this->pagination->create_links(); ?>

<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><?php echo $result_count; ?></span></div>



<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Reason</h4>
         </div>
         <div class="modal-body">
            <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/disApprovePorder" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
               <input type="hidden" name="id" value="" id="order_id">
               <input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
               <input type="hidden" id="disapprove" name="disapprove" value="1">
               <input type="hidden" id="disapprove" name="approve" value="0">
               <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                                        
                     <textarea id="disapprove_reason" required="required" rows="6" name="disapprove_reason" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>                                       
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>                      
                  <input type="submit" class="btn btn edit-end-btn " value="Submit">
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<div id="printView">
   <div id="purchase_add_modal" class="modal fade in" role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">
               <span aria-hidden="true">×
               </span>
               </button>
               <h4 class="modal-title chng_lbl add_title nxt_cls addtitle2" id="myModalLabel">Purchase Order</h4>
            </div>
            <div class="modal-body-content">
            </div>
         </div>
      </div>
   </div>
</div>
<?php //$this->load->view('common_modal'); ?>	
<?php //export_csv_excel($data3); ?>