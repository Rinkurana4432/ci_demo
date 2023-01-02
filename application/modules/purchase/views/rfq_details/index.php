<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div class="x_content">
   <div class="col-md-12 col-sm-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="get" action="<?= base_url() ?>purchase/purchase_rfq">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter Id,Indent No" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="purchase/purchase_rfq?tab=<?php echo $_GET['tab'];?>">
                  <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=<?php echo $_GET['tab'];?>">
                  <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset">                       </a>
                  </span>
               </div>
            </div>
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
            <div class="col-md-12  col-xs-12 col-sm-12 datepicker">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="purchase/purchase_rfq"> 
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?php echo base_url(); ?>purchase/purchase_rfq" method="get" id="date_range">  
                  <input type="hidden" value='' class='start_date' name='start'/>
                  <input type="hidden" value='' class='end_date' name='end'/>
               </form>
            </div>
            <form action="<?php echo base_url(); ?>purchase/purchase_rfq" method="get" >
               <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
               <div class="row hidde_cls filter1 progress_filter">
                  <?php
                     $status_check = $_POST["status_check"];
                     ?>
                  <div class="col-md-12">
                     <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                        <select class="form-control  status_check select2-width-imp" name="status_check"  width="100%" tabindex="-1" aria-hidden="true" >
                           <option value=""> Select Status</option>
                           <option value="po_or_not" <?php if (isset($status_check) && $status_check=="po_or_not") echo "selected";?> >PO Pending</option>
                           <option value="approval_pending" <?php if (isset($status_check) && $status_check=="approval_pending") echo "selected";?> >Approval Pending</option>
                        </select>
                     </div>
                     <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                        <select class="form-control select_mat select2-width-imp" name="material_type" data-id="material_type" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0">
                           <option value="">Select Material</option>
                        </select>
                     </div>
                     <?php
                        $departments = $_POST["departments"];
                        ?>
                     <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible department select2-width-imp" name="departments"  data-id="department" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
                           <option value="">Select Department</option>
                        </select>
                     </div>
                     <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                        <select name="company_unit" class="form-control company_unit select2-width-imp">
                           <option value=""> Select Category </option>
                           <?php
                              if(!empty($company_unit_adress) ){
                                 foreach($company_unit_adress as $companyAdress){
                                 $getAddress = $companyAdress['address'];
                                 $getDecodeAddress = json_decode($getAddress);
                                 foreach($getDecodeAddress as $fetchAddress){
                                    $address = $fetchAddress->address;
                              ?>
                           <option value="<?php echo $fetchAddress->add_id; ?>" <?php if ($address == $_POST['company_unit']) echo "selected";?> ><?php echo $address; ?></option>
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
                     <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="purchase/purchase_rfq" disabled="disabled">
                  </div>
               </div>
            </form>
         </div>
      </div>
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>purchase/purchase_rfq">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
      <div class="row hidde_cls stik">
         <div class="col-md-12 col-xs-12 col-md-12">
            <div class="export_div">
               <div class="btn-group"  role="group" aria-label="Basic example">
                  <?php 
                  echo '<button type="buttton" class="btn btn-danger indent" id="delete_data" style="display:none;" data-table="purchase_rfq" data-where="product_induction_id" onclick="return confirm("Press a button!");"><i class="fa fa-trash btnTitle-icon"></i> Delete</button></a>'; ?>
                  <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="<?php echo ( $_GET['tab'] == 'complete' )?'bbtn22':'bbtn'; ?>">Print</button>
                  <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                     <button style="margin-right: 0px !important;" class="btn btn-secondary dropdown-toggle btn-default Export" type="button" data-toggle="dropdown">Export<span class="caret"></span>
                     </button>
                     <ul class="dropdown-menu" role="menu" id="export-menu">
                        <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                        <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                     </ul>
                  </div>
                  <input type="hidden" value='purchase_rfq' id="table" data-msg="Purchase Indent" data-path="purchase/purchase_rfq"/>
                  <form action="<?php echo base_url(); ?>purchase/purchase_rfq" method="get" >
                     <input type="hidden" value='1' name='favourites'/>
                     <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
                     <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
                     <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
                  </form>
                  <div class="Validate">
                     <button type="button" class="btn btn-default velidate" data-toggle="collapse" data-target="#demo3">Validate<span class="caret"></span>
                     </button>
                     <div id="demo3" class="collapse">
                        <div class='hidde ' style="pointer-events:">
                           <div>Approve:
                              <input type='radio' class='validatesr' name='status_' value='Approve'/ >
                           </div>
                           <div>Disapprove:
                              <input type='radio' class='disapprove' name='status_' value='Disapprove'/ >
                           </div>
                           <p class='disapprove_reason'></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-3 col-xs-12 col-sm-12 datePick-right">
                  <!--button class="btn " onclick="listView()"><a href="#list" data-toggle="tab" aria-expanded="false"><i class="fa fa-bars"></i></a></button> 
                     <button class="btn " onclick="gridView()"><a href="#grid" data-toggle="tab" aria-expanded="false"><i class="fa fa-th-large"></i></a></button>
                     <button type="button" class="btn btn-primary" >Import<span class="caret"></span></button-->
                  <!-- if($can_add) { echo '<button type="buttton" class="btn btn-info indent addBtn add_purchase_tabs" id="Pi" data-id="purchaseRfqDetails" data-toggle="modal">Add</button></a>'; } -->         
               </div>
            </div>
         </div>
      </div>
      <div class="stik">
         <form action="<?php echo base_url(); ?>purchase/purchase_rfq?tab=<?php echo $_GET['tab']; ?>" method="get" id="export-form">
            <input type="hidden" value='' id='hidden-type' name='ExportType'/>
            <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
            <input type="hidden" value='' class='start_date' name='start'/>
            <input type="hidden" value='' class='end_date' name='end'/>
            <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
            <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
            <input type="hidden" value='<?php echo $_GET['material_type']; ?>' class='material_type' name='material_type'/>
            <input type="hidden" value='<?php echo $_GET['departments']; ?>' class='departments_type' name='departments'/>
            <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
            <input type="hidden" value='<?php echo $_GET['status_check']; ?>' name="status_check"/>
            <input type="hidden" value='<?php echo $_GET['company_unit']; ?>' name="company_unit"/>
            <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
            <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
         </form>
         <!-- Filter div End-->
      </div>
   </div>
   <div role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#in_progress_tab" data-select='progress' id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="piinprocess_form2()">In Process</a></li>
         <li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onClick="picomplete_form2()">Complete</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>"> 
            <form id="piinprocess_formrfq"><input type="hidden" value="inprocess" name="tab"></form>
            <div id="print_div_content">
               <div class="table-responsive">
                  <table style="width:100%;" class="table  table-bordered user_index inprocess_div" data-id="user"  border="1" cellpadding="2">
                     <thead>
                        <tr>
                           <th><input id="selecctall" type="checkbox"></th>
                           <th scope="col">Id
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Indent No.
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Preferred Supplier</th>
                           <th scope="col">Inductor</th>
                           <th scope="col">Material Detail</th>
                           <th scope="col">Grand Total</th>
                           <th scope="col">Department</th>
                           <th scope="col" class='hidde'>Created By / Edited By</th>
                           <th scope="col" class='hidde'>RFQ Validate</th>
                           <th scope="col" class='hidde'>Created Date</th>
                           <th scope="col" class='hidde' >Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $total_sum=0;
                           if(!empty($purchase_indent_inProcess) ){
                           
                             //pre($purchase_indent_inProcess);die;
                              foreach($purchase_indent_inProcess as $indents_inprocess){  
                                 $materialData = json_decode($indents_inprocess['material_name']);

                                 $checkPoConvertStatus = checkMaterialConvert($materialData,$rfqMaterial,$indents_inprocess['id']);
                           
                              if($indents_inprocess['favourite_sts'] == '1'){
                                 $rr = 'checked';
                              }else{
                                 $rr = '';   
                              }           
                                 $created_by = ($indents_inprocess['created_by']!=0)?(getNameById('user_detail',$indents_inprocess['created_by'],'u_id')->name):'';
                                 $edited_by = ($indents_inprocess['edited_by']!=0)?(getNameById('user_detail',$indents_inprocess['edited_by'],'u_id')->name):'';
                                 $matriealtype_name = ($indents_inprocess['material_type_id']!=0)?(getNameById('material_type',$indents_inprocess['material_type_id'],'id')->name):'';
                                 $supplierName = getNameById('supplier',$indents_inprocess['preffered_supplier'],'id');
                              
                                 $disableEdit = (($indents_inprocess["approve"] == 1) || $indents_inprocess["po_or_not"] == 1)?'':''; // if PI is in draft than it will not be approved or disapprove
                                 $draftImage = ($indents_inprocess['save_status'] == 0)?'<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="'.base_url().'assets/images/draft.png" ></a>':''; // to show image if PI is in draft
                                 $validatedBy = ($indents_inprocess['rfq_validated_by']!=0)?(getNameById('user_detail',$indents_inprocess['rfq_validated_by'],'u_id')):''; 
                                 $validatedByName = (!empty($validatedBy))?$validatedBy->name:''; // get the name of user who validate the PI
                           ?>
                        <tr>
                           <td>
                              <?php                      
                                 /*   if($indents_inprocess['save_status'] == 1 && ($indents_inprocess["rfq_status"] == 0 || $indents_inprocess["rfq_status"] == '') && ( $can_validate_purchase_budget_limit == '1' && $purchase_budget_limit >= $indents_inprocess['grand_total'])     ){
                                      $disable = '';
                                   }elseif($indents_inprocess['save_status'] == 0 || ($indents_inprocess["rfq_status"] == 1) || ($can_validate_purchase_budget_limit == ''  || ($can_validate_purchase_budget_limit == 1 && $purchase_budget_limit <= $indents_inprocess['grand_total']) )){
                                      $disable = 'disabled';
                                   }elseif($indents_inprocess['save_status'] == 0 || ($indents_inprocess["rfq_status"] == 1) || ($can_validate == '')){
                                      $disable = 'disabled';
                                   }else{
                                      $disable = '';
                                   } */
                                   ?>
                              <?php if($indents_inprocess["used_status"]==0 && $indents_inprocess["rfq_status"] == 0){echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$indents_inprocess['id'].">";}
                                 if($indents_inprocess['favourite_sts'] == '1'){
                                 echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$indents_inprocess['id']."  checked = 'checked'>";
                                 echo"<input type='hidden' value='purchase_indent' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_rfq' favour-sts='0' id-recd=".$indents_inprocess['id'].">";
                                 }else{
                                 echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$indents_inprocess['id'].">";
                                 echo"<input type='hidden' value='purchase_indent' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_rfq' favour-sts='1' id-recd =".$indents_inprocess['id'].">";
                                 } ?>
                           </td>
                           <td data-label="Id:" class="indent_id"><?php echo $draftImage.$indents_inprocess['id']; ?></td>
                           <td data-label="Indent No:" ><?php echo $indents_inprocess['indent_code']; ?></td>
                           <td data-label="Preferred Supplier:" ><a href="javascript:void(0)" id="<?php echo $indents_inprocess['preffered_supplier'] ; ?>" data-id="SupplierView" class="add_purchase_tabs"><?php if($supplierName == null){echo "";}else {echo $supplierName->name;  }?></a></td>
                           <td data-label="Inductor:"><?php echo $indents_inprocess['inductor']; ?></td>
                           <td data-label="Material Detail:">
                              <?php 
                                 $materialDetail=json_decode($indents_inprocess['material_name']);
                                 foreach($materialDetail as $mat_dtls){
                                    $materialName=getNameById('material',$mat_dtls->material_name_id,'id');
                                    //pre($supplierName);
                                    
                                 }
                                 ?>
                              <a style="cursor: pointer;" class="add_purchase_tabs" id="<?php echo $indents_inprocess['id']; ?>" data-toggle="modal" data-id="indentmat_View"><?php echo $materialName->material_name; ?></a>
                              <!--<div class="table-responsive">
                                 <?php if(($indents_inprocess['material_name'] != '' && $indents_inprocess['material_name'] != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]') ) { ?>
                                 <table  style="width:100%;"  class="table table-bordered user_index" data-id="user" border='1' cellpadding='3'>
                                    <thead>
                                       <tr>
                                          <th>Material Type</th>
                                          <th>Material Name</th>
                                          <th>Quantity</th>
                                          <th>UOM</th>
                                          <th>Expected Amount</th>
                                          <th>Purpose</th>
                                          <th>Total</th>
                                       </tr>
                                    </thead>
                                    <?php 
                                    $materialDetail=json_decode($indents_inprocess['material_name']);
                                    $countMaterialDetailLength = count($materialDetail);
                                       $expectedAmount=0;
                                       $i=1;
                                      foreach($materialDetail as $materialdetail){
                                    $mat_type_id=getNameById('material_type',$materialdetail->material_type_id,'id');
                                    $material_id=$materialdetail->material_name_id;
                                    $materialName=getNameById('material',$material_id,'id');
                                    $ww =  getNameById('uom', $materialdetail->uom,'id');
                                    $uom = !empty($ww)?$ww->ugc_code:'';
                                       if($i<=3){ ?>
                                    <tr>
                                 
                                 <td class="materialType" data-id="<?php echo $materialdetail->material_type_id; ?>"><?php if (!empty($mat_type_id)) { echo $mat_type_id->name;  }else{ echo $matriealtype_name; } ?></td>
                                       <td>
                                          <h5><a href="javascript:void(0)" id="<?php echo $material_id ; ?>" data-id="material_view" class="inventory_tabs"><?php if (!empty($materialName)) { echo $materialName->material_name;   } ?></a></h5>
                                          <br><?php echo (array_key_exists("description",$materialdetail)?$materialdetail->description:''); ?>
                                       </td>
                                       <td><?php echo $materialdetail->quantity; ?></td>
                                       <td><?php echo $uom; ?></td>
                                       <td><?php echo $materialdetail->expected_amount; ?></td>
                                       <td><?php echo $materialdetail->purpose; ?></td>
                                       <td><?php echo $materialdetail->sub_total; ?></td>
                                    </tr>
                                    <?php 
                                    }
                                    $i++;
                                    if(!empty($materialName)){
                                       $mat_data =  $materialName->material_name;
                                       }
                                       else
                                       {
                                          $mat_data =   'N/A';
                                       }
                                       if($indents_inprocess['po_or_not'] == '0' || $indents_inprocess['mrn_or_not'] == '0'){
                                          $po_OR_not = 'In Process';
                                       }elseif($indents_inprocess['po_or_not'] == '1' || $indents_inprocess['mrn_or_not'] == '1'){
                                          $po_OR_not = 'Complete';
                                       }
                                    
                                    $dpart_nam = getNameById('department',$indents_inprocess['departments'],'id');
                                    if (!empty($mat_type_id)) { $mattype_name = $mat_type_id->name;   }else{ $mattype_name =  $matriealtype_name; }
                                    
                                    $output[] = array(
                                    
                                          'Indent Code' => $indents_inprocess['indent_code'],
                                          'Preferred Supplier' => $supplierName->name??'',
                                          'Inductor'           => $indents_inprocess['inductor'],
                                          'Material Type' => $mattype_name,
                                          'Material Name' => $mat_data,
                                          'Quantity' => $materialdetail->quantity,
                                          'UOM' => $uom,
                                          'Expected Amount' => $materialdetail->expected_amount,
                                          'Purpose' => $materialdetail->purpose,
                                          'Amount' => $materialdetail->sub_total,
                                          'Department' => $dpart_nam->name,
                                          'P.O Created or Not' => $po_OR_not,
                                          'Created Date' => date("d-m-Y", strtotime($indents_inprocess['created_date'])),
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
                                    if($countMaterialDetailLength > 3){                               
                                    if($can_view) {
                                    echo "<tr class='hidde'>
                                       <th colspan='6'>
                                          <a href='javascript:void(0)' id='". $indents_inprocess["id"] . "' data-id='RFQView' class='add_purchase_tabs ' data-tooltip='View' style='color:green;'>View More....</a>
                                       </th>
                                    </tr>";
                                    }
                                    }                       
                                    ?>
                                 </table>
                                 <?php }  ?>
                                 </div>-->
                           </td>
                           <td data-label="grand total:" class="grandTotal"><?php echo $indents_inprocess['grand_total'];?></td>
                           <td data-label="Department:"><?php  $dpart_nam = getNameById('department',$indents_inprocess['departments'],'id');
                              echo $dpart_nam->name; ?></td>
                           <td data-label="Created By / Edited By:" class='hidde'><?php echo "<a href='".base_url()."users/edit/".$indents_inprocess['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$indents_inprocess["edited_by"].'" target="_blank"><br>'.$edited_by."</a>" ?></td>
                           <td data-label="RFQ Validate:" class='hidde <?php echo $can_validate?'':'disabled'; ?>' style="pointer-events:<?php echo $can_validate?'':'none'; ?>">
                              <?php 
                                 $AprChecked = "";
                                 $disChecked = "";
                                 if( !empty($validatedByName) && ($indents_inprocess['rfq_status']==0)  ){
                                    $disChecked = "checked";
                                 }elseif($indents_inprocess['rfq_status']==1){
                                    $AprChecked = "checked";
                                 }
                                 ?>
                              Approve:
                              <input type="radio" class="validate_rfq" data-idd="<?php echo $indents_inprocess['id']; ?>" name="rfqstatus_<?php echo $indents_inprocess['id'];?>" value="1" <?= $AprChecked;  ?>  > Disapprove:
                              <input type="radio" class="validate_rfq" data-idd="<?php echo $indents_inprocess['id'];?>" name="rfqstatus_<?php echo $indents_inprocess['id'];?>" value="0" <?= $disChecked ?> >

                              <p class="validatedBy">Validated By:<?php echo $validatedByName;?> </p>
                           </td>
                           <td data-label="created date:" class='hidde'><?php echo date("j F , Y", strtotime($indents_inprocess['created_date'])); ?></td>
                           <td data-label="action:" class='hidde action acc-btn' style="padding: 8px 1px;">
                               <i class="fa fa-cog" aria-hidden="true"></i>
				                <div class="on-hover-action">							   
                              <?php if($can_edit && $indents_inprocess['rfq_status'] !=='1') {                          
                                 echo '<button  class="btn btn-edit btn-xs indent add_purchase_tabs afterUpdate'.$indents_inprocess["id"].'" id="'.$indents_inprocess["id"].'"'.$disableEdit.' data-toggle="modal" data-id="purchaseRfqDetails" >Edit</button>';
                                 }
                                 if($can_delete && $indents_inprocess['used_status'] == 0) { 
                                    //echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_indent/'.$indents_inprocess["id"].'"><i class="fa fa-trash"></i></a>';
                                 }
                                 if($can_view) { 
                                    echo '<button  class="btn btn-view btn-xs indent add_purchase_tabs afterUpdate'.$indents_inprocess["id"].'" id="'.$indents_inprocess["id"].'" data-toggle="modal" data-id="RFQView">View</button>';
                                 }
                                 if( $checkPoConvertStatus && $indents_inprocess['rfq_status'] == '1'  ){
                                       echo '<div class="createPO"><button id="'.$indents_inprocess['id'].'" class="btn  btn-xs convert indent add_purchase_tabs" data-id="rfq_convert_to_po">Convert into PO</button></div>'; 

                                 }
                                 #if($indents['po_or_not']==1 || $indents['approve'] == '1' || $indents['save_status'] == '1'){
                                 if($indents_inprocess['po_or_not']==0 && $indents_inprocess['approve'] == '1' && $indents_inprocess['save_status'] == '1' && !empty($indents_inprocess['rfq_supp'])  && $indents_inprocess['rfq_status'] =='1'){
                                    echo '<div class="createPO"><button id="'.$indents_inprocess['id'].'"  class="btn  btn-xs convert indent add_purchase_tabs" data-id="rfq_convert_to_po">Convert into PO</button></div>'; 
                                 } 
                                 
                                 if($indents_inprocess['mrn_or_not']==0 && $indents_inprocess['approve'] == '1' && $indents_inprocess['save_status'] == '1'){
                                    //echo '<div class="createPO"><button id="'.$indents_inprocess['id'].'" data-tooltip="Convert into GRN" class="btn  btn-xs convert indent add_purchase_tabs" data-id="convert_to_mrn_through_pi"><img src="'.base_url().  'assets/modules/crm/uploads/convert.png"></button></div>';  
                                 }  
                                 
                                 
                                 ?>
								</div>
                           </td>
                        </tr>
                        <?php
                           $total_sum+=$indents_inprocess['grand_total'];
                           }
                           
                           $data3  = $output;
                           //pre($data3);
                           export_csv_excel($data3); 
                            $data_balnk  = $output_blank;
                            export_csv_excel_blank($data_balnk); 
                           
                           }
                           ?>
                     </tbody>
                     <tr class="boot_strp_Data">
                        <th colspan="7" style="text-align:center;">Total</th>
                        <th  class="totlamt" ><?php echo $total_sum;?></th>
                        <td colspan="7"></td>
                     </tr>
                  </table>
                  <?php  //echo $this->pagination->create_links(); ?>   
               </div>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="Complete_content_tab" aria-labelledby="inProcess_TAB">
            <!-- Filter div Start-->
            <!-- Filter div End-->
            <div id="print_div_content_div">
               <form id="picomplete_formrfq"><input type="hidden" value="complete" name="tab"></form>
               <table style="width:100%;" class="table  table-bordered user_index complete_div" data-id="user" border="1" cellpadding="2">
                  <thead>
                     <tr>
                        <th><input id="selecctall" type="checkbox"></th>
                        <th>Id
                           <span><a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=complete&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=complete&sort=desc" class="down"></a></span>
                        </th>
                        <th>Indent No.
                           <span><a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=complete&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>purchase/purchase_rfq?tab=complete&sort=desc" class="down"></a></span>
                        </th>
                        <th>Preferred Supplier</th>
                        <th>Inductor</th>
                        <th >Material Detail</th>
                        <th>Grand Total</th>
                        <th>Department</th>
                        <th class='hidde'>Created By / Edited By</th>
                        <th class='hidde'>RFQ Validate</th>
                        <th class='hidde'>Created Date</th>
                        <th class='hidde' >Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        if(!empty($indent) ){
                           $total_sum=0;
                           foreach($indent as $indents){
                              
                              $created_by = ($indents['created_by']!=0)?(getNameById('user_detail',$indents['created_by'],'u_id')->name):'';
                              $edited_by = ($indents['edited_by']!=0)?(getNameById('user_detail',$indents['edited_by'],'u_id')->name):'';
                              $matriealtype_name = ($indents['material_type_id']!=0)?(getNameById('material_type',$indents['material_type_id'],'id')->name):'';
                              $supplierName = getNameById('supplier',$indents['preffered_supplier'],'id');
                              $disable = (($indents['save_status'] == 0) || ($indents["approve"] == 1))?'disabled':''; // if PI is in draft than it will not be approved or disapprove
                              $disableEdit = (($indents["approve"] == 1) || $indents["po_or_not"] == 1)?'disabled':''; // if PI is in draft than it will not be approved or disapprove
                              $draftImage = ($indents['save_status'] == 0)?'<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="'.base_url().' assets/images/draft.png" ></a>':''; // to show image if PI is in draft
                              $validatedBy = ($indents['validated_by']!=0)?(getNameById('user_detail',$indents['validated_by'],'u_id')):''; 
                              $validatedByName = (!empty($validatedBy))?$validatedBy->name:''; // get the name of user who validate the PI
                        ?>
                     <tr>
                        <td>
                           <?php
                              if($indents['favourite_sts'] == '1'){
                              echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$indents['id']."  checked = 'checked'>";
                              echo"<input type='hidden' value='purchase_indent' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_rfq' favour-sts='0' id-recd=".$indents['id'].">";
                              }else{
                              echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$indents['id'].">";
                              echo"<input type='hidden' value='purchase_indent' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_rfq' favour-sts='1' id-recd =".$indents['id'].">";
                              }
                                ?>
                        </td>
                        <td class="indent_id"><?php echo $draftImage.$indents['id']; ?></td>
                        <td><?php echo $indents['indent_code']; ?></td>
                        <td><a href="javascript:void(0)" id="<?php echo $indents['preffered_supplier'] ; ?>" data-id="SupplierView" class="add_purchase_tabs"><?php if($supplierName == null){echo "Does not Exist";}else {echo $supplierName->name;  }?></a></td>
                        <td><?php echo $indents['inductor']; ?></td>
                        <td>
                           <?php 
                              $materialDetail=json_decode($indents['material_name']);
                              foreach($materialDetail as $mat_dtls){
                                 $materialName=getNameById('material',$mat_dtls->material_name_id,'id');
                                 
                              }
                              ?>
                           <a style="cursor: pointer;" class="add_purchase_tabs" id="<?php echo $indents['id']; ?>" data-toggle="modal" data-id="indentmat_View"><?php echo $materialName->material_name; ?></a>
                           <!--<div class="table-responsive">
                              <?php if(($indents['material_name'] != '' && $indents['material_name'] != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]') ) { ?>
                              <table style="width:100%;"  class="table table-bordered user_index" data-id="user" border='1' cellpadding='3'>
                                 <thead>
                                    <tr>
                                       <th>Material Type</th>
                                       <th>Material Name</th>
                                       <th>Quantity</th>
                                       <th>UOM</th>
                                       <th>Expected Amount</th>
                                       <th>Purpose</th>
                                       <th>Total</th>
                                    </tr>
                                 </thead>
                                 <?php 
                                 $materialDetail=json_decode($indents['material_name']);
                                 $countMaterialDetailLength = count($materialDetail);
                                    $expectedAmount=0;
                                    $i=1;
                                   foreach($materialDetail as $materialdetailss){
                                 $mat_type_id=getNameById('material_type',$materialdetail->material_type_id,'id');  
                                    $material_id=$materialdetailss->material_name_id;
                                    $materialName=getNameById('material',$material_id,'id');
                                 
                                    $ww =  getNameById('uom', $materialdetailss->uom,'id');
                                    $uom = !empty($ww)?$ww->ugc_code:'';
                                    if($i<=3){ ?>
                                 <tr>
                              
                              <td class="materialType" data-id="<?php echo $materialdetail->material_type_id; ?>"><?php if (!empty($mat_type_id)) { echo $mat_type_id->name;  }else{ echo $matriealtype_name; } ?></td>
                                    <td>
                                       <h5><a href="javascript:void(0)" id="<?php echo $material_id ; ?>" data-id="material_view" class="inventory_tabs"><?php if (!empty($materialName)) {  echo $materialName->material_name;  } ?></a></h5>
                                       <br><?php echo (array_key_exists("description",$materialdetailss)?$materialdetailss->description:''); ?>
                                    </td>
                                    <td><?php echo $materialdetailss->quantity; ?></td>
                                    <td><?php echo $uom ; ?></td>
                                    <td><?php echo $materialdetailss->expected_amount; ?></td>
                                    <td><?php echo $materialdetailss->purpose; ?></td>
                                    <td><?php echo $materialdetailss->sub_total; ?></td>
                                 </tr>
                                 <?php 
                                 } 
                                 $i++;
                                 if (!empty($mat_type_id)) { $mattype_name = $mat_type_id->name;   }else{ $mattype_name =  $matriealtype_name; }
                                 $output[] = array( 
                                 'zzz' => 'zzz',
                                    'Indent Code' => $indents['indent_code'],
                                    'Material Type' => $mattype_name,
                                    'Material Name' =>$materialName->material_name,
                                    'Quantity' => $materialdetailss->quantity,
                                    'UOM' => $uom,
                                    'Expected Amount' => $materialdetailss->expected_amount,
                                    'Purpose' => $materialdetailss->purpose,
                                    'Amount' => $materialdetailss->sub_total,
                                    'Department' => $indents['departments'],
                                    'P.O Created or Not' => $po_OR_not,
                                    'Created Date' => date("d-m-Y", strtotime($indents['created_date'])),
                                 ); 
                                       
                                 }
                                 if($countMaterialDetailLength > 3){                               
                                             if($can_view) {
                                                echo "<tr class='hidde'>
                                                      <th colspan='6'>
                                                      <a href='javascript:void(0)' id='". $indents["id"] . "' data-id='RFQView' class='add_purchase_tabs ' data-tooltip='View' style='color:green;'>View More....</a>
                                                      </th>
                                                   </tr>";
                                                   }
                                             } 
                                 ?>
                              </table>
                              <?php }  ?>
                              </div>-->
                        </td>
                        <td><?php echo $indents['grand_total'];?></td>
                        <td><?php 
                           $dpart_nam = getNameById('department',$indents_inprocess['departments'],'id'); 
                           echo $dpart_nam->name;
                           ?></td>
                        <td class='hidde'><?php echo "<a href='".base_url()."users/edit/".$indents['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$indents["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
                        <td class='hidde <?php echo $can_validate?'':'disabled'; ?>' style="pointer-events:<?php echo $can_validate?'':'none'; ?>"> 
                           <?php 
                              $selectApprove = $indents['rfq_status']==1?'checked':'';
                              $selectDisapprove = $indents['rfq_status']==0?'checked':'';
                              if($selectApprove =='checked'){
                              echo "
                              Approve:
                                 <input type='radio' class='validate' data-id='".$indents['id']."' name='status_".$indents['id']."' value='Approve'/ ".$selectApprove." ".$disable."> Disapprove:
                                 <input type='radio' class='disapprove' data-id='".$indents['id']."' name='status_".$indents['id']."' value='Disapprove'/ ".$selectDisapprove.$disable." disabled>
                                 <p class='disapprove_reason'>".$indents['disapprove_reason']."</p>
                                 <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                              }else{
                                 echo "
                                 Approve:
                                 <input type='radio' class='validate' data-id='".$indents['id']."' name='status_".$indents['id']."' value='Approve'/ ".$selectApprove.$disable."> Disapprove:
                                 <input type='radio' class='disapprove' data-id='".$indents['id']."' name='status_".$indents['id']."' value='Disapprove'/ ".$selectDisapprove.$disable.">
                                 <p class='disapprove_reason'>".$indents['disapprove_reason']."</p>
                                 <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                              }
                              ?>
                        </td>
                        <td class='hidde'><?php echo date("j F , Y", strtotime($indents['created_date'])); ?></td>
                        <td class='hidde acc-btn' style="padding: 8px 1px;">  
                           <?php if($can_edit) {                           
                              echo '<button data-tooltip="Edit" class="btn btn-edit btn-xs indent add_purchase_tabs" id="'.$indents["id"].'"'.$disableEdit.' data-toggle="modal" data-id="purchaseRfqDetails" ><i class="fa fa-pencil"></i>  </button>';
                              }
                              if($can_delete && $indents['used_status'] == 0) { 
                              }
                              if($can_view) { 
                                 echo '<button data-tooltip="View" class="btn btn-view btn-xs indent add_purchase_tabs" id="'.$indents["id"].'" data-toggle="modal" data-id="RFQView"><i class="fa fa-eye"></i></button>';
                              }
                              if($indents['po_or_not']==0 && $indents['approve'] == '1' && $indents['save_status'] == '1'){
                                 echo '<div class="createPO"><button id="'.$indents['id'].'" data-tooltip="Convert into PO" class="btn  btn-xs convert indent add_purchase_tabs" data-id="rfq_convert_to_po"><img src="'.base_url().'assets/modules/crm/uploads/convert.png"></button></div>';  
                              }
                              
                              ?>
                        </td>
                     </tr>
                     <?php
                        if(!empty($materialName)){
                           $mat_data =  $materialName->material_name;
                           }
                           else
                           {
                              $mat_data =   'N/A';
                           }
                           if($indents['po_or_not'] == '0' || $indents['mrn_or_not'] == '0'){
                              $po_OR_not = 'In Process';
                           }elseif($indents['po_or_not'] == '1' || $indents['mrn_or_not'] == '1'){
                              $po_OR_not = 'Complete';
                           }
                        
                                             
                        $total_sum+=$indents['grand_total'];
                        }
                        $data_for_complete  = $output;
                        export_csv_excel($data_for_complete);
                        
                           
                        
                              
                        }
                        ?>
                  </tbody>
                  <tr class="boot_strp_Data">
                     <th colspan="6" style="text-align:center;">Total</th>
                     <th  class="totlamt_tab"></th>
                     <th colspan="5"><?php echo $total_sum;?></th>
                  </tr>
               </table>
               <?php //echo $this->pagination->create_links(); ?> 
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
               <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/disApproveRFQ" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
                  <input type="hidden" name="id" value="" id="indent_id">
                  <input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
                  <input type="hidden" id="disapprove" name="disapprove" value="1">
                  <input type="hidden" id="approve" name="approve" value="0">
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
</div>
<div id="printView">
   <div id="purchase_add_modal" class="modal fade in"  role="dialog" >
      <div class="modal-dialog modal-large">
         <div class="modal-content" style="overflow:auto;">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title chng_lbl nxt_cls addtitle2" id="myModalLabel">Purchase Indent</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<?php $this->load->view('common_modal'); ?>
<?php //export_csv_excel($data3); ?>