<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
   setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
   ?>
<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="get" action="<?= base_url() ?>purchase/purchase_indent">
            <input type="hidden" name="tab" value="<?php echo $_GET['tab'];?>"/>
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Id , Indent Number" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="purchase/purchase_indent?tab=<?php echo $_GET['tab'];?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm for_page">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=<?php echo $_GET['tab'];?>">
                  <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <form action="<?php echo base_url(); ?>purchase/purchase_indent" method="GET" id="date_range">  
            <input type="hidden" value='' class='start_date' name='start'/>
            <input type="hidden" value='' class='end_date' name='end'/>
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
         <div id="demo" class="collapse">
            <div class="col-md-12  col-xs-12 col-sm-12 datepicker">
               <fieldset style="float: left; padding: 0px 11px; ">
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="purchase/purchase_indent"> 
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?php echo base_url(); ?>purchase/purchase_indent?tab=<?php echo $_GET['tab']; ?>" method="GET" >
                  <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
                  <div class="row hidde_cls filter1 progress_filter">
                     <?php
                        $status_check = $_GET["status_check"];
                        ?>
                     <div class="col-md-12 col-xs-12">
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                           <select class="form-control  status_check select2-width-imp" name="status_check"  width="100%" tabindex="-1" aria-hidden="true" >
                              <option value=""> Select Status</option>
                              <option value="po_or_not" <?php if (isset($status_check) && $status_check=="po_or_not") echo "selected";?> >PO Pending</option>
                              <option value="mrn_or_not" <?php if (isset($status_check) && $status_check=="mrn_or_not") echo "selected";?> >GRN Pending </option>
                              <option value="approval_pending" <?php if (isset($status_check) && $status_check=="approval_pending") echo "selected";?> >Approval Pending</option>
                           </select>
                        </div>
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                           <select class="form-control select_mat select2-width-imp" name="material_type" data-id="material_type" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0">
                              <option value="">Select Material</option>
                           </select>
                        </div>
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible department select2-width-imp" name="departments"  data-id="department" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
                              <option value="">Select Department</option>
                           </select>
                        </div>
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
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
                              <option value="<?php echo $fetchAddress->add_id; ?>" <?php if ($address == $_GET['company_unit']) echo "selected";?> ><?php echo $address; ?></option>
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
                        <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="purchase/purchase_indent" disabled="disabled">
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="row hidde_cls stik">
         <div class="col-md-12 col-xs-12 col-md-12">
            <div class="export_div">
               <div class="btn-group"  role="group" aria-label="Basic example">
                  <?php if($can_add) { 
                     echo '<button type="buttton" class="btn btn-danger indent" id="delete_data" style="display:none;" data-table="purchase_indent" data-where="id" onclick="return confirm("Press a button!");"><i class="fa fa-trash btnTitle-icon"></i> Delete</button></a>';

                     echo '<button type="buttton" class="btn btn-success indent addBtn add_purchase_tabs" id="Pi" data-id="indentEdit" data-toggle="modal"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button></a>'; } ?>  
                  <!---<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>-->
                  <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss"
                     id="<?php echo ( $_GET['tab'] == 'complete' )?'bbtn22':'bbtn'; ?>">Print</button>
                 
                  <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                     <button style="margin-right: 0px !important;" class="btn btn-secondary dropdown-toggle btn-default Export" type="button" data-toggle="dropdown">Export<span class="caret"></span>
                     </button>
                     <ul class="dropdown-menu" role="menu" id="export-menu">
                        <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                        <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                     </ul>
                  </div>
                  <input type="hidden" value='purchase_indent' id="table" data-msg="Purchase Indent" data-path="purchase/purchase_indent"/>
                  <form action="<?php echo base_url(); ?>purchase/purchase_indent" method="get" >
                     <input type="hidden" value='1' name='favourites'/>
                     <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
                     <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
                     <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
                  </form>
                  <!--div class="Validate">
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
                  </div-->
               </div>
            </div>
         </div>
      </div>
   </div>
   <form class="form-search" id="orderby" method="get" action="<?= base_url() ?>purchase/purchase_indent">
      <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
   </form>
   <div class="stik">
      <form action="<?php echo base_url(); ?>purchase/purchase_indent?tab=<?php echo $_GET['tab']; ?>" method="GET" id="export-form">
         <input type="hidden" value='' id='hidden-type' name='ExportType'/>
         <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
         <input type="hidden" value='' class='start_date' name='start'/>
         <input type="hidden" value='' class='end_date' name='end'/>
         <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
         <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
         <input type="hidden" value='<?php echo $_GET['material_type']; ?>' class='material_type' name='material_type'/>
         <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
         <input type="hidden" value='<?php echo $_GET['company_unit']; ?>' name='company_unit'/>
         <input type="hidden" value='<?php echo $_GET['departments']; ?>' class='departments_type' name='departments'/>
         <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
         <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
         <input type="hidden" value='<?php echo $_GET['status_check']; ?>' name="status_check"/>
      </form>
   </div>
   <div role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#in_progress_tab" data-select='progress' id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="piinprocess_form1()">In Process</a></li>
         <li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onClick="picomplete_form1()">Complete</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>"> 
            <form id="piinprocess_form" ><input type="hidden" value="inprocess" name="tab"></form>
            <div id="print_div_content">
               <div class="table-responsive">
                  <?php /* <table id="example" style="width:100%;" class="table  table-bordered user_index inprocess_div" data-id="user" data-order='[[1,"desc"]]' border="1" cellpadding="2">    */   ?>     
                  <table style="width:100%;" class="table  table-bordered user_index inprocess_div" data-id="user"  border="1" cellpadding="2">
                     <thead>
                        <tr>
                           <?php /*    <th><input id="selecctall" type="checkbox"></th>
                              <th>Id</th>
                              <th>Indent No.</th>
                              <th>Material Type</th>
                              <th>Preferred Supplier</th>
                              <th>Inductor</th>
                              <th>Material Detail</th>
                              <th>Grand Total</th>
                              
                              <th>Department</th>
                              <th class='hidde'>Created By / Edited By</th>
                              <th class='hidde'>Validate</th>
                              <th class='hidde'>Created Date</th>
                              <th class='hidde' >Action</th> */ ?>
                           <th><input id="selecctall" type="checkbox"></th>
                           <th>Id
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th>Indent No.
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <!--th>Material Type 
                              <span><a href="<?php //echo base_url(); ?>purchase/purchase_indent?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php //echo base_url(); ?>purchase/purchase_indent?tab=inprocess&sort=desc" class="down"></a></span>
                              </th-->
                           <th>Preferred Supplier
                           </th>
                           <th>Inductor</th>
                           <th>Material Detail</th>
                           <th>Grand Total</th>
                           <th>Department</th>
                           <th class='hidde'>Created By / Edited By</th>
                           <th class='hidde'>Validate</th>
                           <th class='hidde'>Created Date</th>
                           <th class='hidde' >Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $total_sum=0;
                           if(!empty($purchase_indent_inProcess) ){
                              foreach($purchase_indent_inProcess as $indents_inprocess){  
                                           $departmentName = getNameById('department',$indents_inprocess['departments'],'id');
                              if($indents_inprocess['favourite_sts'] == '1'){
                                                   $rr = 'checked';
                                                }else{
                                                $rr = '';   
                                                }           
                                 $created_by = ($indents_inprocess['created_by']!=0)?(getNameById('user_detail',$indents_inprocess['created_by'],'u_id')->name):'';
                                 $edited_by = ($indents_inprocess['edited_by']!=0)?(getNameById('user_detail',$indents_inprocess['edited_by'],'u_id')->name):'';
                                 $matriealtype_name = ($indents_inprocess['material_type_id']!=0)?(getNameById('material_type',$indents_inprocess['material_type_id'],'id')->name):'';
                                 $supplierName = getNameById('supplier',$indents_inprocess['preffered_supplier'],'id');
                                 $disable = (($indents_inprocess['save_status'] == 0) || ($indents_inprocess["approve"] == 1))?'disabled':''; // if PI is in draft than it will not be approved or disapprove
                                 $disableEdit = (($indents_inprocess["approve"] == 1) || $indents_inprocess["po_or_not"] == 1)?'disabled':''; // if PI is in draft than it will not be approved or disapprove
                                 $draftImage = ($indents_inprocess['save_status'] == 0)?'<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="'.base_url().'assets/images/draft.png" ></a>':''; // to show image if PI is in draft
                                 $validatedBy = ($indents_inprocess['validated_by']!=0)?(getNameById('user_detail',$indents_inprocess['validated_by'],'u_id')):''; 
                                 $validatedByName = (!empty($validatedBy))?$validatedBy->name:''; // get the name of user who validate the PI
                           ?>
                        <tr>
                           <td><?php 
                              if($indents_inprocess["used_status"]==0 && $indents_inprocess["mrn_or_not"] != 1 && $indents_inprocess["po_or_not"] != 1 ){
                                 echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$indents_inprocess['id'].">";}
                              
                              if($indents_inprocess['favourite_sts'] == '1'){
                                    echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$indents_inprocess['id']."  checked = 'checked'>";
                                    echo"<input type='hidden' value='purchase_indent' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_indent' favour-sts='0' id-recd=".$indents_inprocess['id'].">";
                              }else{
                                    echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$indents_inprocess['id'].">";
                                    echo"<input type='hidden' value='purchase_indent' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_indent' favour-sts='1' id-recd =".$indents_inprocess['id'].">";
                              }
                              ?></td>
                           <td class="indent_id"><?php echo $draftImage.$indents_inprocess['id']; ?></td>
                           <td><?php echo $indents_inprocess['indent_code']; ?></td>
                           <!--td class="materialType" data-id="<?php //echo $indents_inprocess['material_type_id']; ?>"><?php //echo $matriealtype_name; ?></td-->
                           <td><a href="javascript:void(0)" id="<?php echo $indents_inprocess['preffered_supplier'] ; ?>" data-id="SupplierView" class="add_purchase_tabs"><?php if($supplierName == null){echo "";}else {echo $supplierName->name;  }?></a></td>
                           <td><?php echo $indents_inprocess['inductor']; ?></td>
                           <td>
                              <input type="hidden" class="materialType" data-id="<?php echo $indents_inprocess['material_type_id']; ?>">  
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
                                       
                                          if(!empty($materialName)){
                                             $mat_data =  $materialName->material_name;
                                             }
                                             else
                                             {
                                                $mat_data =   'N/A';
                                             }
                                             if($indents_inprocess['po_or_not'] == '0'){
                                                $po_OR_not = 'In Process';
                                             }elseif($indents_inprocess['po_or_not'] == '1'){
                                                $po_OR_not = 'Complete';
                                             }
                                          if (!empty($mat_type_id)) { $mattype_name = $mat_type_id->name;   }else{ $mattype_name =  $matriealtype_name; }
                                                      
                                          $output[] = array(
                                                'Indent Code' => $indents_inprocess['indent_code'],
                                                'Material Type' => $mattype_name,
                                                'Material Name' => $mat_data,
                                                'HSN' => $materialdetail->hsnCode??'',
                                                'Quantity' => $materialdetail->quantity,
                                                'UOM' => $uom,
                                                'Description' => (array_key_exists("description",$materialdetail)?$materialdetail->description:''),  
                                                'Expected Amount' => $materialdetail->expected_amount,
                                                'Purpose' => $materialdetail->purpose,
                                                'Amount' => $materialdetail->sub_total,
                                                'Department' => $departmentName->name,
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
                                 
                                  $departmentd=getNameById('department',$indents_inprocess['departments'],'id');
                                  ?>
                              <a style="cursor: pointer;" class="add_purchase_tabs" id="<?php echo $indents_inprocess['id']; ?>" data-toggle="modal" data-id="indentmat_View"><?php echo $materialName->material_name; ?></a>
                           </td>
                           <td class="grandTotal"><?php echo $indents_inprocess['grand_total'];?></td>
                           <td><?php echo $departmentd->name; ?></td>
                           <td class='hidde'><?php echo "<a href='".base_url()."users/edit/".$indents_inprocess['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$indents_inprocess["edited_by"].'" target="_blank"><br>'.$edited_by."</a>" ?></td>
                           <?php $userBudget = checkApproveByUser(); ?>
                           <td class='hidde <?php echo $can_validate?'':'disabled'; ?>' 
                              style="pointer-events:<?php 
                                                      $grandTotalBudget += $indents_inprocess['grand_total'];
                              if( $can_validate ){echo '';}else{
                                                            if( $userBudget['lowBudget'] ){
                                                               if( $userBudget['budgetLimit'] < $grandTotalBudget  ){
                                                                     echo 'none';
                                                               }
                                                            }elseif($userBudget['highBudget']){
                                                               if( $userBudget['budgetLimit'] < $grandTotalBudget  ){
                                                                     echo 'none';
                                                               }
                                                            }else{
                                                               echo 'none';
                                                            }

                              } ?>"> 
                              <?php 
                                 $selectApprove = $indents_inprocess['approve']==1?'checked':'';
                                 $selectDisapprove = $indents_inprocess['disapprove']==1?'checked':'';
                                 if($selectApprove =='checked'){
                                 echo "
                                 Approve:
                                    <input type='radio' class='validate' data-idd='".$indents_inprocess['id']."' name='status_".$indents_inprocess['id']."' value='Approve'/ ".$selectApprove." ".$disable."> Disapprove:
                                    <input type='radio' class='disapprove' data-idd='".$indents_inprocess['id']."' name='status_".$indents_inprocess['id']."' value='Disapprove'/ ".$selectDisapprove.$disable." disabled>
                                    <p class='disapprove_reason'>".$indents_inprocess['disapprove_reason']."</p>
                                    <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                                 }else{
                                    echo "
                                    Approve:
                                    <input type='radio' class='validate' data-idd='".$indents_inprocess['id']."' name='status_".$indents_inprocess['id']."' value='Approve'/ ".$selectApprove.$disable."> Disapprove:
                                    <input type='radio' class='disapprove' data-idd='".$indents_inprocess['id']."' name='status_".$indents_inprocess['id']."' value='Disapprove'/ ".$selectDisapprove.$disable.">
                                    <p class='disapprove_reason'>".$indents_inprocess['disapprove_reason']."</p>
                                    <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                                 }
                                 ?>
                           </td>
                           <td class='hidde'><?php echo date("j F , Y", strtotime($indents_inprocess['created_date'])); ?></td>
                           <td class='hidde action acc-btn' style="padding: 8px 1px;">
                              <i class="fa fa-cog" aria-hidden="true"></i>
				                <div class="on-hover-action">						   
                              <?php if($can_edit && $indents_inprocess['disapprove'] != '1') {                           
                                 echo '<button  class="btn btn-edit btn-xs indent add_purchase_tabs" id="'.$indents_inprocess["id"].'"'.$disableEdit.' data-toggle="modal" data-id="indentEdit" >Edit</button>';
                                 }
                                 if($can_delete && $indents_inprocess['used_status'] == 0 && $indents_inprocess['disapprove'] != '1') { 
                                    echo '<a href="javascript:void(0)"  class="delete_listing
                                       btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_indent/'.$indents_inprocess["id"].'">Delete</a>';
                                 }
                                 if($can_view) { 
                                    echo '<button  class="btn btn-view btn-xs indent add_purchase_tabs" id="'.$indents_inprocess["id"].'" data-toggle="modal" data-id="indentView">View</button>';
                                 }
                                 #if($indents['po_or_not']==1 || $indents['approve'] == '1' || $indents['save_status'] == '1'){
                                 if($indents_inprocess['po_or_not']==0 && $indents_inprocess['approve'] == '1' && $indents_inprocess['save_status'] == '1'){
                                    echo '<div class="createPO"><button id="'.$indents_inprocess['id'].'"  class="btn  btn-xs convert indent add_purchase_tabs" data-id="convert_to_po">Convert into PO</button></div>';  
                                 } 
                                 
                                 // if($indents_inprocess['mrn_or_not']==0 && $indents_inprocess['approve'] == '1' && $indents_inprocess['save_status'] == '1'){
                                    // echo '<div class="createPO"><button id="'.$indents_inprocess['id'].'"  class="btn  btn-xs convert indent add_purchase_tabs" data-id="convert_to_mrn_through_pi">Convert into GRN</div>';  
                                 // }  
                                 //echo '<button data-tooltip="View" class="btn btn-view btn-xs indent add_purchase_tabs" id="'.$indents_inprocess["id"].'" data-toggle="modal" data-id="indentViewNew">View New</button>';
                                 
                                 
                                 // if($indents_inprocess['approve'] == '1' && $indents_inprocess['save_status'] == '1'){
                                    // echo '<button data-tooltip="Change Status" class="btn btn-status btn-xs indent add_purchase_tabs" id="'.$indents_inprocess["id"].'" data-toggle="modal" data-id="indentChangeStatus">
                                    // <img src="'.base_url().  'assets/modules/purchase/images/status-change.png"></button>'; 
                                 // }
                                 
                                 ?>
							 </div>
                           </td>
                        </tr>
                        <?php
                           $total_sum += $indents_inprocess['grand_total'];                  
                           
                           }
                           $data3  = $output;
                           //pre($data3);
                           $data_balnk  = $output_blank;
                           export_csv_excel_blank($data_balnk); 
                           export_csv_excel($data3); 
                           }
                           ?>
                     </tbody>
                     <tr class="boot_strp_Data">
                        <th colspan="6" style="text-align:center;">Total</th>
                        <th  class="totlamt" ><?php echo money_format('%!i',$total_sum);?></th>
                        <td colspan="6"></td>
                     </tr>
                  </table>
                  <?php //echo $showPageInProcess; ?>
                  <?php //echo $paginglinksInProcess; ?>
               </div>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="Complete_content_tab" aria-labelledby="inProcess_TAB">
            <!-- <div class="row hidde_cls">
               <div class="col-md-12">
                  <div class="export_div">
                     <div class="btn-group"  role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
                        <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="bbtn22">Print</button>
                        <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                           <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                              <ul class="dropdown-menu" role="menu" id="export-menu">
                                 <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                                 <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                              </ul>
                        </div>
                     </div>
                  </div>
               </div>
               </div> -->
            <!-- Filter div Start-->
            <?php /* <div class="row hidde_cls filter1 complete_filter">
               <div class="col-md-12">
                <input type="hidden" name="activeTab_val" value="complete" >
               <div class="btn-group"  role="group" aria-label="Basic example">
                  <select name="material_type" class="form-control">
                     <option value=""> Select Category </option>
                        <?php
                  if(!empty($mat_type_ss) ){
                     foreach($mat_type_ss as $mat_type){
                  ?>
            <option value="<?php echo $mat_type['id']; ?>"><?php echo $mat_type['name']; ?></option>
            <?php } } ?>         
            </select>
         </div>
         <div class="btn-group"  role="group" aria-label="Basic example">
            <select class="form-control" name="departments">
               <option value=""> Select Department</option>
               <option value="Information Technology">Information Technology</option>
               <option value="Sales">Sales </option>
               <option value="Marketing">Marketing</option>
               <option value="Digital marketing">Digital marketeing</option>
               <option value="Accounts">Accounts</option>
               <option value="Human Resource">Human Resource</option>
               <option value="Production">Production</option>
               <option value="Exports">Exports</option>
            </select>
         </div>
         <input type="button" value="Filter" class="btn filt1">
      </div>
   </div>
   */?>
   <!-- Filter div End-->
   <form id="picomplete_form"><input type="hidden" value="complete" name="tab"></form>
   <div id="print_div_content_div">
      <?php /*<table id="example_tab" style="width:100%;" class="table  table-bordered user_index complete_div" data-id="user" data-order='[[1,"desc"]]' border="1" cellpadding="2">  */?>        
      <table style="width:100%;" class="table  table-bordered user_index complete_div" data-id="user" border="1" cellpadding="2">
         <thead>
            <tr>
               <?php /*    <th></th>
                  <th>Id</th>
                  <th>Indent No.</th>
                  <th>Material Type</th>
                  <th>Preffered Supplier</th>
                  <th>Inductor</th>
                  <th>Material Detail</th>
                  <th>Grand Total</th>
                  <th>Department</th>
                  <th class='hidde'>Created By / Edited By</th>
                  <th class='hidde'>Validate</th>
                  <th class='hidde'>Created Date</th>
                  <th class='hidde' >Action</th> */ ?>
               <th><input id="selecctall" type="checkbox"></th>
               <th>Id
                  <span><a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=complete&sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=complete&sort=desc" class="down"></a></span> 
               </th>
               <th>Indent No.
                  <span><a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=complete&sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>purchase/purchase_indent?tab=complete&sort=desc" class="down"></a></span>
               </th>
               <!--th>Material Type
                  <span><a href="<?php //echo base_url(); ?>purchase/purchase_indent?tab=complete&sort=asc" class="up"></a>
                  <a href="<?php //echo base_url(); ?>purchase/purchase_indent?tab=complete&sort=desc" class="down"></a></span>
                  </th-->
               <th>Preferred Supplier</th>
               <th>Inductor</th>
               <th>Material Detail</th>
               <th>Grand Total</th>
               <th>Department</th>
               <th class='hidde'>Created By / Edited By</th>
               <th class='hidde'>Validate</th>
               <th class='hidde'>Created Date</th>
               <th class='hidde' >Action</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($indent) ){
                  $total_sum=0;
                  foreach($indent as $indents){
                     $departmentName = getNameById('department',$indents['departments'],'id');
                     $created_by = ($indents['created_by']!=0)?(getNameById('user_detail',$indents['created_by'],'u_id')->name):'';
                     $edited_by = ($indents['edited_by']!=0)?(getNameById('user_detail',$indents['edited_by'],'u_id')->name):'';
                     $matriealtype_name = ($indents['material_type_id']!=0)?(getNameById('material_type',$indents['material_type_id'],'id')->name):'';
                     $supplierName = getNameById('supplier',$indents['preffered_supplier'],'id');
                     $disable = (($indents['save_status'] == 0) || ($indents["approve"] == 1))?'disabled':''; // if PI is in draft than it will not be approved or disapprove
                     $disableEdit = (($indents["approve"] == 1) || $indents["po_or_not"] == 1)?'disabled':''; // if PI is in draft than it will not be approved or disapprove
                     $draftImage = ($indents['save_status'] == 0)?'<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="http://busybanda.com/assets/images/draft.png" ></a>':''; // to show image if PI is in draft
                     $validatedBy = ($indents['validated_by']!=0)?(getNameById('user_detail',$indents['validated_by'],'u_id')):''; 
                     $validatedByName = (!empty($validatedBy))?$validatedBy->name:''; // get the name of user who validate the PI
               ?>
            <tr>
               <td>
                  <?php
                     if($indents['favourite_sts'] == '1'){
                                          echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$indents['id']."  checked = 'checked'>";
                                          echo"<input type='hidden' value='purchase_indent' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_indent' favour-sts='0' id-recd=".$indents['id'].">";
                                    }else{
                                       echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$indents['id'].">";
                                       echo"<input type='hidden' value='purchase_indent' id='favr' data-msg='Purchase Indent' data-path='purchase/purchase_indent' favour-sts='1' id-recd =".$indents['id'].">";
                                    }
                     ?>
               </td>
               <td class="indent_id"><?php echo $draftImage.$indents['id']; ?></td>
               <td><?php echo $indents['indent_code']; ?></td>
               <!--td><?php //echo $matriealtype_name; ?></td-->
               <td><a href="javascript:void(0)" id="<?php echo $indents['preffered_supplier'] ; ?>" data-id="SupplierView" class="add_purchase_tabs"><?php if($supplierName == null){echo "Does not Exist";}else {echo $supplierName->name;  }?></a></td>
               <td><?php echo $indents['inductor']; ?></td>
               <td>
                  <div class="table-responsive">
                     <?php if(($indents['material_name'] != '' && $indents['material_name'] != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]') ) { ?>
                     <?php 
                        $materialDetail=json_decode($indents['material_name']);
                        $countMaterialDetailLength = count($materialDetail);
                           $expectedAmount=0;
                           $i=1;
                          foreach($materialDetail as $materialdetailss){
                           $mat_type_id=getNameById('material_type',$materialdetailss->material_type_id,'id');  
                           $material_id=$materialdetailss->material_name_id;
                           $materialName=getNameById('material',$material_id,'id');
                        
                           $ww =  getNameById('uom', $materialdetailss->uom,'id');
                           $uom = !empty($ww)?$ww->ugc_code:'';
                           
                        $output[] = array( 
                           'Indent Code' => $indents['indent_code'],
                           'Material Type' => $matriealtype_name,
                           'Material Name' => $mat_data,
                           'Quantity' => $materialdetailss->quantity,
                           'UOM' => $uom,
                           'Description' => (array_key_exists("description",$materialdetailss)?$materialdetailss->description:''),
                           'Expected Amount' => $materialdetailss->expected_amount,
                           'Purpose' => $materialdetailss->purpose,
                           'Amount' => $materialdetailss->sub_total,
                           'Department' => $departmentName->name,
                           'P.O Created or Not' => $po_OR_not,
                           'Created Date' => date("d-m-Y", strtotime($indents['created_date'])),
                        ); 
                              
                        }
                        
                        ?>
                     <a style="cursor: pointer;" class="add_purchase_tabs" id="<?php echo $indents['id']; ?>" data-toggle="modal" data-id="indentmat_View"><?php echo $materialName->material_name; ?></a>
               </td>
               <?php }  
                  $departmentd=getNameById('department',$indents['departments'],'id');
                  
                  ?>
               </div>
               <td><?php echo $indents['grand_total'];?></td>
               <td><?php echo $departmentd->name; ?></td>
               <td class='hidde'><?php echo "<a href='".base_url()."users/edit/".$indents['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$indents["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
               <td class='hidde <?php echo $can_validate?'':'disabled'; ?>' style="pointer-events:<?php echo $can_validate?'':'none'; ?>"> 
                  <?php 
                     $selectApprove = $indents['approve']==1?'checked':'';
                     $selectDisapprove = $indents['disapprove']==1?'checked':'';
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
               <td class='hidde action acc-btn' style="padding: 8px 1px;">
                    <i class="fa fa-cog" aria-hidden="true"></i>
				                <div class="on-hover-action">			   
                  <?php if($can_edit) {                           
                     echo '<button  class="btn btn-edit btn-xs indent add_purchase_tabs" id="'.$indents["id"].'"'.$disableEdit.' data-toggle="modal" data-id="indentEdit" >Edit</button>';
                     }
                     if($can_delete && $indents['used_status'] == 0) { 
                        //echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                           //btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_indent/'.$indents["id"].'"><i class="fa fa-trash"></i></a>';
                     }
                     if($can_view) { 
                        echo '<button  class="btn btn-view btn-xs indent add_purchase_tabs" id="'.$indents["id"].'" data-toggle="modal" data-id="indentView">View</button>';
                     }
                     #if($indents['po_or_not']==1 || $indents['approve'] == '1' || $indents['save_status'] == '1'){
                     if($indents['po_or_not']==0 && $indents['approve'] == '1' && $indents['save_status'] == '1'){
                        echo '<div class="createPO"><button id="'.$indents['id'].'"  class="btn  btn-xs convert indent add_purchase_tabs" data-id="convert_to_po">Convert into PO</button></div>';   
                     }
                     
                     // if($indents['approve'] == '1' && $indents['save_status'] == '1'){
                        // echo '<button data-tooltip="Change Status" class="btn btn-status btn-xs indent add_purchase_tabs" id="'.$indents["id"].'" data-toggle="modal" data-id="indentChangeStatus">
                        // <img src="'.base_url().  'assets/modules/purchase/images/status-change.png"></button>'; 
                     // }
                     
                     ?>
					 </div>
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
                  if($indents['po_or_not'] == '0'){
                     $po_OR_not = 'In Process';
                  }elseif($indents['po_or_not'] == '1'){
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
            <th colspan="5" style="text-align:center;">Total</th>
            <th  class="totlamt_tab"></th>
            <th colspan="6"><?php echo money_format('%!i',$total_sum);?></th>
         </tr>
      </table>
      <?php //echo $showPagecomplete; ?>
      <?php //echo $paginglinksComplete; ?>
   </div>
</div>
</div>
</div>
<?php echo $this->pagination->create_links(); ?>   
<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Reason</h4>
         </div>
         <div class="modal-body">
            <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/disApproveIndent" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
               <input type="hidden" name="id" value="" id="indent_id">
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