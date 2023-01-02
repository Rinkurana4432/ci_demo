
<?php if($this->session->flashdata('message') != ''){?>
<div class="alert alert-info">
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }
   setlocale(LC_MONETARY, 'en_IN');
   ?>
<div class="x_content">
   <div class="row hidde_cls stik">
      <div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
            <form class="form-search" method="get" action="<?= base_url() ?>purchase/mrn">
               <div class="col-md-6">
                  <div class="input-group">
                     <span class="input-group-addon">
                     <i class="ace-icon fa fa-check"></i>
                     </span>
                     <input type="text" class="form-control search-query" placeholder="Enter Id,Bill no" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="purchase/mrn">
                     <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
                     <span class="input-group-btn">
                     <button type="submit" class="btn btn-purple btn-sm">
                     <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                     Search
                     </button>
                     <a href="<?php echo base_url(); ?>purchase/mrn">
                     <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                     </span>
                  </div>
               </div>
            </form>
            <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
            <div id="demo" class="collapse">
               <!-- Filter div Start-->
               <div class="col-md-12  col-sm-12 datePick-left">
                  <fieldset>
                     <div class="control-group">
                        <div class="controls">
                           <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="purchase/mrn">
                           </div>
                        </div>
                     </div>
                  </fieldset>
                  <form action="<?php echo base_url(); ?>purchase/mrn" method="GET" id="date_range">
                     <input type="hidden" value='' class='start_date' name='start'/>
                     <input type="hidden" value='' class='end_date' name='end'/>
                  </form>
               </div>
               <div class="row filter1 Filter_div">
                  <form action="<?php echo base_url(); ?>purchase/mrn" method="GET">
                     <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
                     <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
                     <div class="col-md-12">
                        <div class="btn-group"  role="group" aria-label="Basic example" >
                           <select class="form-control select_mat disbled_cls select2-width-imp" name="material_type" data-id="material_type" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0">
                              <option value="">Select Material</option>
                           </select>
                        </div>
                        <div class="btn-group"  role="group" aria-label="Basic example" >
                           <select class="form-control supp_name disbled_cls select_supplier select2-width-imp" name="supplier_name" data-id="supplier" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" >
                              <option value="">Select </option>
                           </select>
                        </div>
                        <div class="btn-group"  role="group" aria-label="Basic example" >
                           <select name="company_unit" class="form-control company_unit disbled_cls select2-width-imp">
                              <option value=""> Select Category </option>
                              <?php
                                 if(!empty($company_unit_adress) ){
                                    foreach($company_unit_adress as $companyAdress){
                                    $getAddress = $companyAdress['address'];
                                    $getDecodeAddress = json_decode($getAddress);
                                    foreach($getDecodeAddress as $fetchAddress){
                                       $address = $fetchAddress->address;


                                 ?>
                              <option value="<?php echo $address; ?>" <?php if ($address == $_POST['company_unit']) echo "selected";?> ><?php echo $address; ?></option>
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
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                           <select class="form-control commanSelect2 select2-width-imp" name="report_type" width="100%">
                              <option value="">Select Report Type</option>
                              <option value="pass" <?= ($_GET['report_type'] == 'pass')?'selected':''; ?> >Pass</option>
                              <option value="fail" <?= ($_GET['report_type'] == 'fail')?'selected':''; ?>>Fail</option>
                           </select>
                        </div>
                        <input type="submit" value="Filter" class="btn filt1"  disabled="disabled">
                     </div>
                  </form>
               </div>
               <!-- Filter div End-->
            </div>
            <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>purchase/mrn">
               <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
            </form>
         </div>
         <form action="<?php echo base_url(); ?>purchase/mrn?tab=<?php echo $_GET['tab']; ?>" method="GET" id="export-form">
            <input type="hidden" value='' id='hidden-type' name='ExportType' />
            <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
            <input type="hidden" value='' class='start_date' name='start' />
            <input type="hidden" value='' class='end_date' name='end' />
            <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
            <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
            <input type="hidden" value='<?php echo $_GET['material_type']; ?>' class='material_type' name='material_type'/>
            <input type="hidden" value='<?php echo $_GET['supplier_name']; ?>' class='supplier_name' name='supplier_name'/>
            <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
            <input type="hidden" value='<?php echo $_GET['company_unit']; ?>' name="company_unit"/>
            <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
            <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
         </form>
         <div class="col-md-12 col-xs-12">
            <div class=" export_div">
               <div class="btn-group" role="group" aria-label="Basic example">
                  <?php if ($can_add) {
                     echo '<button type="buttton" class="btn btn-info add_purchase_tabs addBtn" data-id="EditMRN" id="MRN_add"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
                     } ?>
                 
                  <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="<?= ( $_GET['tab'] == 'complete' )?'bbtn22':'bbtn'; ?>">Print</button>
                  <input type="hidden" value='mrn_detail' id="table" data-msg="Goods Receipt Note" data-path="purchase/mrn"/>
                  <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                     <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                     <ul class="dropdown-menu" role="menu" id="export-menu">
                        <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                        <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                     </ul>
                  </div>
                  <form action="<?php echo base_url(); ?>purchase/mrn" method="get" >
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
   <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
   <div role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#in_progress_tab" data-select='progress' id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="mrninprocess_form4()">In Process</a></li>
         <li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onClick="mrncomplete_form4()">Complete</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">
            <form id="mrninprocess_form"><input type="hidden" value="inprocess" name="tab"></form>
            <div id="print_div_content">
               <div class="table-responsive">
                  <?php /* <table id="example" style="width:100%;" class="table  table-bordered inprocess_div" data-id="user" data-order='[[1,"desc"]]' border="1" cellpadding="2" > */   ?>
                  <table id="" style="width:100%;" class="table  table-bordered inprocess_div" data-id="user"  border="1" cellpadding="2" >
                     <thead>
                        <tr>
                           <th><input id="selecctall" type="checkbox"></th>
                           <th scope="col">Id
                              <span><a href="<?php echo base_url(); ?>purchase/mrn?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/mrn?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Bill No.
                              <span><a href="<?php echo base_url(); ?>purchase/mrn?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/mrn?sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Supplier Name
                              <span><a href="<?php echo base_url(); ?>purchase/mrn?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/mrn?sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Purchase Indent No. / Purchase Order No.
                              <span><a href="<?php echo base_url(); ?>purchase/mrn?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/mrn?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Material Detail</th>
                           <th scope="col">Grand Total</th>
                           <th scope="col">Payment Terms</th>
                           <th scope="col">Received Date</th>
                           <th scope="col">Order Date</th>
                           <th scope="col">Ratings</th>
                           <th scope="col" Class='hidde'>Created By</th>
                           <th scope="col" Class='hidde'>Created Date</th>
                           <th scope="col" Class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($mrn)) {
                           $total_sum=0;
                              foreach ($mrn as $MRN) {
                                 $supplierName = getNameById('supplier', $MRN['supplier_name'], 'id');
                                 $po_number = getNameById('purchase_order', $MRN['po_id'], 'id');
                                 $pi_number = getNameById('purchase_indent', $MRN['pi_id'], 'id');
								 // pre($pi_number);
                                 $matriealtype_name = ($MRN['material_type_id']!=0)?(getNameById('material_type',$MRN['material_type_id'],'id')->name):'';
                                 $deliveryAddress = getNameById('company_detail', $MRN['delivery_address'], 'id');
                                 $draftImage = '';
                                 if ($MRN['save_status'] == 0)
                                    $draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="'.base_url().'assets/images/draft.png" > </a>';
 
                                 ?>
                        <tr>
                           <td><?php if($MRN["used_status"]==0){echo "<input name='checkbox[]' class='checkbox1 checkbox[]'  type='checkbox'  value=".$MRN['id'].">";}
                              if($MRN['favourite_sts'] == '1'){
                                                echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$MRN['id']."  checked = 'checked'>";
                                                echo"<input type='hidden' value='mrn_detail' id='favr' data-msg='GRN' data-path='purchase/mrn' favour-sts='0' id-recd=".$MRN['id'].">";
                                          }else{
                                             echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$MRN['id'].">";
                                             echo"<input type='hidden' value='mrn_detail' id='favr' data-msg='GRN' data-path='purchase/mrn' favour-sts='1' id-recd =".$MRN['id'].">";
                                          }
                              ?></td>
                           <td data-label="id:"><?php echo $draftImage . $MRN['id']; ?></td>
                           <td data-label="Bill No:"><?php echo $MRN['bill_no']; ?></td>
                           <td data-label="Supplier Name:"><?php if (!empty($supplierName)) {
                              echo '<a href="javascript:void(0)" id="'.$MRN['supplier_name'].'" data-id="SupplierView" class="add_purchase_tabs">'.$supplierName->name.'</a>';
                              } ?></td>
                           <td data-label="Purchase Order No. /  Purchase Indent No.:">
						   <?php
						   if(!empty($po_number) || !empty($pi_number)){
                              if (!empty($po_number)) {
                                 echo '<a href="javascript:void(0)" id="'.$MRN['po_id'].'" data-id="OrderView" class="add_purchase_tabs">'.$po_number->order_code.'</a>';
                              } 
							  echo '   /  ';
							  if(!empty($pi_number)){
                                 echo '<a href="javascript:void(0)" id="'.$MRN['pi_id'].'" data-id="indentView" class="add_purchase_tabs">'.$pi_number->indent_code.'</a>';
                              }
						   }else{
								echo '   Direct GRN  ';
							}
                                 ?></td>
                           <td data-label="Material Detail:">
                                <?php

                                 $materialDetail=json_decode($MRN['material_name']);
								 $materialName = getNameById('material',$materialDetail[0]->material_name_id,'id');

                                 if( !empty($materialName) ){ ?>

					<a style="cursor: pointer;" class="add_purchase_tabs" id="<?php echo $MRN['id']; ?>" data-toggle="modal" data-id="MRNmat_View"><?php echo $materialName->material_name; ?></a>
                                 <?php
								 }

                              ?>
                              <?php
                                 /*$materialDetail=json_decode($MRN['material_name']);
                                 foreach($materialDetail as $mat_dtls){
                                    $materialName=getNameById('material',$mat_dtls->material_name_id,'id');

                                 }*/
                                 ?>
                              <!-- <a style="cursor: pointer;" class="add_purchase_tabs" id="<?php //echo $MRN['id']; ?>" data-toggle="modal" data-id="MRNmat_View"><?php //echo $materialName->material_name; ?></a>   -->
                              <!--<?php if($MRN['material_name'] != ''  && $MRN['material_name'] !='[{"material_name_id":"","uom":"","quantity":"","price":"","sub_tax":"","sub_total":"","gst":"","total":"","defected":0,"defected_reason":"","received_quantity":""}]'){ ?>
                                 <table  class="table  table-bordered user_index  bulk_action" data-id="user" style="width:100%;" border="1" cellpadding="2">
                                    <thead>
                                       <tr>
                                          <th>Material Type</th>
                                          <th>Material Name</th>
                                          <th>Quantity</th>
                                          <th>Price</th>
                                          <th>Sub Total</th>
                                          <th>GST</th>
                                          <th>Sub Tax</th>
                                          <th>Total</th>
                                          <th>Received Quantity</th>
                                          <th>Approve /Disapprove with reason</th>
                                       </tr>
                                    </thead>
                                    <?php
                                    $materialDetail = json_decode($MRN['material_name']);
                                    $countMaterialDetailLength = count($materialDetail);
                                    $i=1;
                                    foreach ($materialDetail as $materialdetail) {
                                        if($materialdetail->material_name_id != '' && $materialdetail->quantity != 0){
                                       $material_id = $materialdetail->material_name_id;
                                       $materialName = getNameById('material', $material_id, 'id');
                                       $materialTypeName = getNameById('material_type', $materialdetail->material_type_id, 'id');
                                       if(!empty($materialTypeName)){$mat_type_name =  $materialTypeName->name; }else{ $mat_type_name = $matriealtype_name;}
                                       if($i<=3){ ?>
                                    <tr>
                                       <td><?php echo $mat_type_name; ?></td>
                                       <td>
                                          <h5><a href="javascript:void(0)" id="<?php echo $material_id ; ?>" data-id="material_view" class="inventory_tabs"><?php if (!empty($materialName)) {
                                    echo $materialName->material_name;  } ?></a></h5>
                                          <br>
                                          <p><?php echo (array_key_exists("description",$materialdetail)?$materialdetail->description:''); ?></p>
                                       </td>
                                       <td><?php echo $materialdetail->quantity; ?></td>
                                       <td><?php echo $materialdetail->price; ?></td>
                                       <td><?php echo $materialdetail->sub_total; ?></td>
                                       <td><?php echo $materialdetail->gst; ?></td>
                                       <td><?php echo $materialdetail->sub_tax; ?></td>
                                       <td><?php echo $materialdetail->total; ?></td>
                                       <td><?php echo $materialdetail->received_quantity;?></td>
                                       <td><?php echo ($materialdetail->defected == 1)?$materialdetail->defected_reason:'';?><br /></td>
                                    </tr>
                                    <?php }
                                    $i++;
                                    if ($supplierName == null) {
                                    $Sup_name = "supplier Does not exist";
                                    } else {
                                    $Sup_name = $supplierName->name;
                                    }
                                    if (!empty($po_number)) {
                                    $po_no = "Created through PO:-" . $po_number->order_code;
                                    } else {
                                    $po_no = "Without Purchase Order";
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
                                    if(!empty($materialTypeName)){$mat_type_name =  $materialTypeName->name; }else{ $mat_type_name = $matriealtype_name;}
                                    $output[] = array(
                                    'Supplier Name' => $Sup_name,
                                    'Purchase Order No' => $po_no,
                                    'Material Type' => $mat_type_name,
                                    'Material Name' => $mat_name,
                                    'Quantity' => @$materialdetail->quantity,
                                    'GST' => @$materialdetail->gst,
                                    'Sub Total' => @$materialdetail->sub_total,
                                    'Sub Tax' => @$materialdetail->sub_tax,
                                    'Total' => @$materialdetail->total,
                                    'Created Date' => date("d-m-Y", strtotime($MRN['created_date'])),
                                    );

                                    $output_blank[] = array(
                                      'supplier_name' => '',
                                      'order_code' => '',
                                      'material_type_id' => '',
                                      'quantity' => '',
                                      'gst' => '',
                                      'sub_total' => '',
                                      'sub_tax' => '',
                                      'total' => '',
                                    );





                                    }
                                    }

                                    if($countMaterialDetailLength > 3){
                                       if($can_view) {
                                          echo "<tr class='hidde'>
                                                <th colspan='9'>
                                                <a href='javascript:void(0)' id='". $MRN["id"] . "' data-id='MrnView' class='add_purchase_tabs ' data-tooltip='View' style='color:green;'>View More....</a>
                                                </th>
                                             </tr>";
                                       }
                                    }?>
                                 </table>
                                 <?php } ?>-->
                           </td>
                           <!--td><?php// echo $grand_totaldd = money_format('%!i', $MRN['grand_total']); ?></td-->
                           <td data-label="Grand Total:"><?php echo $MRN['grand_total']; ?></td>
                           <td data-label="Payment Terms:"><?php echo $MRN['payment_terms']; ?></td>
                           <td data-label="Received Date:"><?php if($MRN['received_date'] != '') echo date("j F , Y", strtotime($MRN['received_date'])); ?></td>
                           <td data-label="Received Date:"><?php if($MRN['date'] != '') echo date("j F , Y", strtotime($MRN['date'])); ?></td>
                           <td data-label="Ratings:"><?php echo $MRN['rating']; ?></td>
                           <td data-label="Created By:" Class='hidde'><?php echo "<a href='".base_url()."users/edit/".$MRN['created_by']."' target='_blank'>".(($MRN['created_by']!=0)?(getNameById('user_detail',$MRN['created_by'],'u_id')->name):'')."</a>"; ?></td>
                           <td data-label="Created Date:" Class='hidde'><?php echo date("j F , Y", strtotime($MRN['created_date'])); ?></td>
                           <td data-label="Action:"  Class='hidde'>
                              <?php
                                 if($can_edit) {
                                 #echo '<button id="echo $MRN['id'];" data-id="EditMRN" class="btn btn-info btn-xs Mrn"><i class="fa fa-pencil"></i> Edit </button>';
                                 
                                 echo '<button id="'.$MRN["id"].'" class="btn btn-edit btn-xs Mrn add_purchase_tabs" data-id="EditMRN"><i class="fa fa-pencil"></i></button>';
                                 }
                                 if ($can_view) {
                                 echo '<button id="' . $MRN["id"] . '" class="btn btn-view btn-xs add_purchase_tabs" data-tooltip="View" data-id="MrnView"><i class="fa fa-eye"></i> </button>';
                                 }

                                 if($can_delete && $MRN["used_status"]==0)
                                    echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                                    btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_mrn/'.$MRN["id"].'"><i class="fa fa-trash"></i></a>';

                                 ?>
                           </td>
                        </tr>
                        <?php
                           $total_sum+=$MRN['grand_total'];
                           }
                           $data3  = $output;
                           //pre($data3);die();
                           export_csv_excel($data3);

                           $data_balnk  = $output_blank;
                           export_csv_excel_blank($data_balnk);


                           } ?>
                     </tbody>
                     <tr class="boot_strp_Data">
                        <th colspan="7" style="text-align:center;">Total</th>
                        <th  class="totlamt"><?php echo $total_sum;?></th>
                        <th colspan="7"></th>
                     </tr>
                  </table>
                  <?php  //$paginglinksInProcess;
                     //  echo $this->pagination->create_links(); ?>
               </div>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="Complete_content_tab" aria-labelledby="inProcess_TAB">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">
            <div id="print_div_content_div">
               <form id="mrncomplete_form"><input type="hidden" value="complete" name="tab"></form>
               <div class="table-responsive">
                  <?php /*  <table id="example_tab" style="width:100%;" class="table  table-bordered complete_div" data-id="user" data-order='[[1,"desc"]]' border="1" cellpadding="2" > */  ?>
                  <table id="" style="width:100%;" class="table  table-bordered complete_div" data-id="user" border="1" cellpadding="2" >

                     <thead>
                        <tr>
                           <th></th>
                           <?php
                              /* foreach($sort_cols as $field_name => $field_display){ ?>
                           <th><?php echo anchor('purchase/mrn/'.$field_name.'/'.($sort_by == $field_name ? $sort_order : 'asc').'/'.$page, $field_display); */?>
                           <th>Id
                              <span><a href="<?php echo base_url(); ?>purchase/mrn?tab=complete&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/mrn?tab=complete&sort=desc" class="down"></a></span>
                           </th>
                           <th>Bill No.
                              <span><a href="<?php echo base_url(); ?>purchase/mrn?tab=complete&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/mrn?tab=complete&sort=desc" class="down"></a></span>
                           </th>
                           <th>Supplier Name
                              <span><a href="<?php echo base_url(); ?>purchase/mrn?tab=complete&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/mrn?tab=complete&sort=desc" class="down"></a></span>
                           </th>
                           <th>Purchase Indent No. / Purchase Order No.
                              <span><a href="<?php echo base_url(); ?>purchase/mrn?tab=complete&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/mrn?tab=complete&sort=desc" class="down"></a></span>
                           </th>
                           <th>Material Detail</th>
                           <th>Grand Total</th>
                           <th>Payment Terms</th>
                           <th>Received Date</th>
                           <th>Ratings</th>
                           <th Class='hidde'>Created By</th>
                           <th Class='hidde'>Created Date</th>
                           <th Class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($mrn_complete)) {
                           $total_sum=0;
                                       foreach ($mrn_complete as $mrn_comp) {
                                          $supplierName = getNameById('supplier', $mrn_comp['supplier_name'], 'id');
                                          $po_number = getNameById('purchase_order', $mrn_comp['po_id'], 'id');
										  
										
                                          $pi_number = getNameById('purchase_indent', $mrn_comp['pi_id'], 'id');
										  
                                          $matriealtype_name = ($mrn_comp['material_type_id']!=0)?(getNameById('material_type',$mrn_comp['material_type_id'],'id')->name):'';
                                          $deliveryAddress = getNameById('company_detail', $mrn_comp['delivery_address'], 'id');
                                          $draftImage = '';
                                          if ($mrn_comp['save_status'] == 0)
                                             $draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive" src="'.base_url().'assets/images/draft.png" > </a>';
										 
										 
										

                                          ?>
                        <tr>
                           <td>
                              <?php
                                 if($mrn_comp['favourite_sts'] == '1'){
                                                         echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$mrn_comp['id']."  checked = 'checked'>";
                                                         echo"<input type='hidden' value='mrn_detail' id='favr' data-msg='Suppliers' data-path='purchase/mrn' favour-sts='0' id-recd=".$mrn_comp['id'].">";
                                                   }else{
                                                      echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$mrn_comp['id'].">";
                                                      echo"<input type='hidden' value='mrn_detail' id='favr' data-msg='Suppliers' data-path='purchase/mrn' favour-sts='1' id-recd =".$mrn_comp['id'].">";
                                                   }

                                 ?>
                           </td>
                           <td data-label="id:"><?php echo $draftImage . $mrn_comp['id']; ?></td>
                           <td data-label="Bill No:"><?php echo $mrn_comp['bill_no']; ?></td>
                           <td data-label="Supplier Name:"><?php if (!empty($supplierName)) {
                              echo '<a href="javascript:void(0)" id="'.$mrn_comp['supplier_name'].'" data-id="SupplierView" class="add_purchase_tabs">'.$supplierName->name.'</a>';
                              } ?></td>
                           <td data-label="Purchase Indent No. / Purchase Order No:"><?php
							
							
							if(!empty($pi_number->indent_code)){
                                 echo '<a href="javascript:void(0)" id="'.$mrn_comp['pi_id'].'" data-id="indentView" class="add_purchase_tabs">'.$pi_number->indent_code.'</a> / ';
                              }
							  
                              if (!empty($po_number)) {
                                 echo '<a href="javascript:void(0)" id="'.$mrn_comp['po_id'].'" data-id="OrderView" class="add_purchase_tabs">'.$po_number->order_code.'</a>';
                              }
							  


                                 ?></td>
                           <td data-label="Material Detail:">
                              <?php
                                 $materialDetail=json_decode($mrn_comp['material_name']);
                                 foreach($materialDetail as $mat_dtls){
                                    $materialName=getNameById('material',$mat_dtls->material_name_id,'id');

                                 }
                                 ?>
                              <a style="cursor: pointer;" class="add_purchase_tabs" id="<?php echo $mrn_comp['id']; ?>" data-toggle="modal" data-id="MRNmat_View"><?php echo $materialName->material_name; ?></a>
                              <!--<?php if($mrn_comp['material_name'] != ''  && $mrn_comp['material_name'] !='[{"material_name_id":"","uom":"","quantity":"","price":"","sub_tax":"","sub_total":"","gst":"","total":"","defected":0,"defected_reason":"","received_quantity":""}]'){ ?>
                                 <table  class="table  table-bordered user_index  bulk_action" data-id="user" style="width:100%;" border="1" cellpadding="2">
                                    <thead>
                                       <tr>
                                          <th>Material Type</th>
                                          <th>Material Name</th>
                                          <th>Quantity</th>
                                          <th>Price</th>
                                          <th>Sub Total</th>
                                          <th>GST</th>
                                          <th>Sub Tax</th>
                                          <th>Total</th>
                                          <th>Received Quantity</th>
                                          <th>Approve /Disapprove with reason</th>
                                       </tr>
                                    </thead>
                                    <?php
                                    $materialDetail = json_decode($mrn_comp['material_name']);
                                    $countMaterialDetailLength = count($materialDetail);
                                    $i=1;
                                    foreach ($materialDetail as $materialdetail) {

                                       $material_id = $materialdetail->material_name_id;
                                       $materialName = getNameById('material', $material_id, 'id');
                                       $materialTypeName = getNameById('material_type', $materialdetail->material_type_id, 'id');
                                       if(!empty($materialTypeName)){$mat_type_name =  $materialTypeName->name; }else{ $mat_type_name = $matriealtype_name;}
                                       if($i<=3){ ?>
                                    <tr>
                                       <td><?php echo $mat_type_name; ?></td>
                                       <td>
                                          <h5><a href="javascript:void(0)" id="<?php echo $material_id ; ?>" data-id="material_view" class="inventory_tabs"><?php if (!empty($materialName)) {  echo $materialName->material_name;  } ?></a></h5>
                                          <br>
                                          <p><?php echo (array_key_exists("description",$materialdetail)?$materialdetail->description:''); ?></p>
                                       </td>
                                       <td><?php echo $materialdetail->quantity; ?></td>
                                       <td><?php echo $materialdetail->price; ?></td>
                                       <td><?php echo $materialdetail->sub_total; ?></td>
                                       <td><?php echo $materialdetail->gst; ?></td>
                                       <td><?php echo $materialdetail->sub_tax; ?></td>
                                       <td><?php echo $materialdetail->total; ?></td>
                                       <td><?php echo $materialdetail->received_quantity;?></td>
                                       <td><?php echo ($materialdetail->defected == 1)?$materialdetail->defected_reason:'';?><br /></td>
                                    </tr>
                                    <?php }
                                    $i++;
                                    if ($supplierName == null) {
                                    $Sup_name = "supplier Does not exist";
                                    } else {
                                    $Sup_name = $supplierName->name;
                                    }
                                    if (!empty($po_number)) {
                                    $po_no = "Created through PO:-" . $po_number->order_code;
                                    } else {
                                    $po_no = "Without Purchase Order";
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
                                    if(!empty($materialTypeName)){$mat_type_name =  $materialTypeName->name; }else{ $mat_type_name = $matriealtype_name;}
                                    $output[] = array(
                                    'Supplier Name' => $Sup_name,
                                    'Purchase Order No' => $po_no,
                                    'Material Type' => $mat_type_name,
                                    'Material Name' => $mat_name,
                                    'Quantity' => @$materialdetail->quantity,
                                    'GST' => @$materialdetail->gst,
                                    'Sub Total' => @$materialdetail->sub_total,
                                    'Sub Tax' => @$materialdetail->sub_tax,
                                    'Total' => @$materialdetail->total,
                                    //'Created Date' => date("d-m-Y", strtotime($indents['created_date'])),
                                    );

                                    $output_blank[] = array(
                                      'supplier_name' => '',
                                      'order_code' => '',
                                      'material_type_id' => '',
                                      'quantity' => '',
                                      'gst' => '',
                                      'sub_total' => '',
                                      'sub_tax' => '',
                                      'total' => '',
                                    );






                                    }

                                    if($countMaterialDetailLength > 3){
                                       if($can_view) {
                                          echo "<tr class='hidde'>
                                                <th colspan='9'>
                                                <a href='javascript:void(0)' id='". $mrn_comp["id"] . "' data-id='MrnView' class='add_purchase_tabs ' data-tooltip='View' style='color:green;'>View More....</a>
                                                </th>
                                             </tr>";
                                       }
                                    }?>
                                 </table>
                                 <?php } ?>-->
                           </td>
                           <!--td><?php// echo $grand_totaldd = money_format('%!i', $mrn_comp['grand_total']); ?></td-->
                           <td data-label="Grand Total:"><?php echo $mrn_comp['grand_total']; ?></td>
                           <td data-label="Payment Terms:"><?php echo $mrn_comp['payment_terms']; ?></td>
                           <td data-label="Received Date:"><?php if($mrn_comp['received_date'] != '') echo date("j F , Y", strtotime($mrn_comp['received_date'])); ?></td>
                           <td data-label="Ratings:"><?php echo $mrn_comp['rating']; ?></td>
                           <td data-label="Created By:" Class='hidde'><?php echo "<a href='".base_url()."users/edit/".$mrn_comp['created_by']."' target='_blank'>".(($mrn_comp['created_by']!=0)?(getNameById('user_detail',$mrn_comp['created_by'],'u_id')->name):'')."</a>"; ?></td>
                           <td data-label="Created Date:" Class='hidde'><?php echo date("j F , Y", strtotime($mrn_comp['created_date'])); ?></td>
                           <td data-label="Action:" Class='hidde'>
                              <?php
                                 if($can_edit) {
                                 #echo '<button id="echo $mrn_comp['id'];" data-id="EditMRN" class="btn btn-info btn-xs Mrn"><i class="fa fa-pencil"></i> Edit </button>';

                                 //echo '<button id="'.$mrn_comp["id"].'" class="btn btn-edit btn-xs Mrn add_purchase_tabs" data-id="EditMRN"><i class="fa fa-pencil"></i></button>';
                                 }
                                 if ($can_view) {
                                 echo '<button id="' . $mrn_comp["id"] . '" class="btn btn-view btn-xs add_purchase_tabs" data-tooltip="View" data-id="MrnView"><i class="fa fa-eye"></i> </button>';
                                 }

                                 //if($can_delete && $mrn_comp["used_status"]==0)
                                  //  echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                                   // btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_mrn/'.$mrn_comp["id"].'"><i class="fa fa-trash"></i></a>';

                                 ?>
                           </td>
                        </tr>
                        <?php
                           $total_sum+=$mrn_comp['grand_total'];
                           }
                           $data3  = $output;
                           //pre($data3);die();
                           export_csv_excel($data3);

                           $data_balnk  = $output_blank;
                           export_csv_excel_blank($data_balnk);


                           } ?>
                     </tbody>
                     <tr class="boot_strp_Data">
                        <th colspan="6" style="text-align:center;">Total</th>
                        <th  class="totlamt_tab"></th>
                        <th colspan="6"><?php echo $total_sum;?></th>
                     </tr>
                  </table>
                  <?php //echo $this->pagination->create_links(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><?php echo $result_count; ?></span></div>
<div id="printView">
   <div id="purchase_add_modal" class="modal fade in" role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title add_title" id="myModalLabel">GRN</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<?php $this->load->view('common_modal'); ?>
