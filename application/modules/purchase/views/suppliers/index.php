<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php } 
   ?>
<div class="x_content">
   <div class="col-md-12 col-sm-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form action="<?php echo site_url(); ?>purchase/suppliers" method="GET" id="export-form">
            <input type="hidden" value='' id='hidden-type' name='ExportType'/>
            <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
            <input type="hidden" value='' class='start_date' name='start'/>
            <input type="hidden" value='' class='end_date' name='end'/> 
            <input type="hidden" value='<?php echo $_GET['start']; ?>'  class='start_date' name='start'/>
            <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
            <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
            <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
         </form>
         <form class="form-search" method="GET" action="<?= base_url() ?>purchase/suppliers">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id,Supplier Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="purchase/suppliers">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>purchase/suppliers"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>purchase/suppliers">
            <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])=='' || $_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
            <input type="hidden" name="url" id="url" value="<?php echo $this->uri->segment(3);?>" />
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#demo" aria-expanded="false"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse" aria-expanded="false" style="height: 2px;">
            <div class="col-md-12  col-xs-12 col-sm-12 datePick-left">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" class="form-control daterange" value="" data-table="purchase/suppliers">
                        </div>
                     </div>
                  </div>
               </fieldset>
               <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
               <form action="<?= base_url() ?>purchase/suppliers" method="GET" >
                  <input type="hidden" value='<?php echo $_GET['start']; ?>' id='start_date' name='start'/>
                  <input type="hidden" value='<?php echo $_GET['end']; ?>' id='end_date' name='end'/>
                  <div class="row hidde_cls filter1 progress_filter">
                     <div class="col-md-12 col-xs-12 well" id="chkIndex_1" style="padding:0;margin-bottom:0;background-color:transparent;border:none;">
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId select2-width-imp" name="material_type" data-id="material_type" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" placeholder="Select Material"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid = 0" onchange="getMaterialName(event,this)">
                              <option value="">Select Material</option>
                           </select>
                        </div>
                        <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name Add_mat_onthe_spot select2-width-imp" id="mat_name"  name="material_name">
                              <option value="">Select Material Name</option>
                           </select>
                        </div>
                        <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="purchase/purchase_indent" disabled="disabled">
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
      <div class="row hidde_cls stik">
         <div class="col-md-12 col-xs-12">
            <div class="export_div">
               <div class="btn-group"  role="group" aria-label="Basic example">
                  <?php if($can_add) { 
                     echo '<button type="buttton" class="btn btn-info add_purchase_tabs addBtn" id="sup_add" data-toggle="modal" data-id="editSupplier"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
                     } 
                     
                     ?>
                
                  <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
                  <input type="hidden" value='supplier' id="table" data-msg="Suppliers" data-path="purchase/suppliers"/>
                  <!-- Import Button -->
                  <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                     <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="true">Import<span class="caret"></span></button>
                     <ul class="dropdown-menu import-bar" role="menu" id="export-menu">
                        <li>
                           <form action="<?= base_url('purchase/import_view'); ?>" method="post" enctype="multipart/form-data" 
                              style="display:flex;width: 300px; padding: 26px 7px;">   
                              <input type="file" class="form-control col-md-2" name="excelFile" id="file" style="width: 70%">
                              <input type="submit" class="form-control col-md-2" name="importe" value="Upload" style="width: 30%;">
                           </form>
                        </li>
                     </ul>
                  </div>
                  <!-- Import Button End -->
                  <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
                  <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                     <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                     <ul class="dropdown-menu" role="menu" id="export-menu">
                        <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                        <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                        <li><a href="<?= base_url('assets/download/supplierDemo.xlsx') ?>" download>Export blank sheet</a></li>
                     </ul>
                  </div>
                  <form action="<?php echo base_url(); ?>purchase/suppliers" method="get" >
                     <input type="hidden" value='1' name='favourites'/>
                     <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
                     <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
                     <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
                  </form>
                  <form action="<?php echo site_url(); ?>purchase/Create_suppliers_blankxls" method="post" id="export-form-blank">
                     <input type="hidden" value='' id='hidden-type-blank-excel' name='ExportType_blank'/>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">  
   <div id="print_div_content">
      <table id="" class="table table-bordered user_index" style="width:100%; margin-top: 40px;"  data-id="user" border="1" cellpadding="3">
         <thead>
            <tr>
               <th>#</th>
               <th scope="col">Id
                  <span><a href="<?php echo base_url(); ?>purchase/suppliers?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>purchase/suppliers?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Supplier Name 
                  <span><a href="<?php echo base_url(); ?>purchase/suppliers?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>purchase/suppliers?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Material Type
                  <span><a href="<?php echo base_url(); ?>purchase/suppliers?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>purchase/suppliers?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Material Detail</th>
               <th scope="col">Contact person </th>
               <th scope="col" class='hidde'>Created By / Edited By</th>
               <th>Created Date</th>
               <th scope="col" class='hidde'>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($suppliers)){             
               foreach($suppliers as $supplier){ 
			   
                  if($supplier['favourite_sts'] == '1'){
                     $rr = 'checked';
                  }else{
                     $rr = '';
                  }     
                  $created_by = ($supplier['created_by']!=0)?(getNameById('user_detail',$supplier['created_by'],'u_id')->name):'';
                  $edited_by = ($supplier['edited_by']!=0)?(getNameById('user_detail',$supplier['edited_by'],'u_id')->name):'';
                  
                  
                  $draftImage = '';
                  if($supplier['save_status'] == 0)
                  $draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';?>
            <tr>
               <td><?php 
			   //if($supplier["used_status"]==0){
                 // echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$supplier['id'].">";}
                             if($supplier['favourite_sts'] == '1'){
                              echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$supplier['id']."  checked = 'checked'>";
                              echo"<input type='hidden' value='supplier' id='favr' data-msg='Suppliers' data-path='purchase/suppliers' favour-sts='0' id-recd=".$supplier['id'].">";
                             }else{
                              echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$supplier['id'].">";
                              echo"<input type='hidden' value='supplier' id='favr' data-msg='Suppliers' data-path='purchase/suppliers' favour-sts='1' id-recd =".$supplier['id'].">";
                             }
                             ?>
               </td>
               <td data-label="id:"><?php echo $draftImage.$supplier['id']; ?></td>
               <td data-label="Supplier Name :"><?php echo $supplier['name']; ?></td>
               <?php
                   $materialNameData = $materialTypeData = $uom = [];
                   $materialName = $materialType = "";
                   if( !empty($supplier['material_name_id']) ){
                        $mData = json_decode($supplier['material_name_id']);
						
						 
                        $i = 0;
                        foreach ($mData as $key => $value) {
							
							
                           if( $i < 3 ){
                              $mattype = getSingleNameById('material_type_id','material',$value->material_name,'id');
							 // pre($mattype);
                              // $materialTypeData[] = getSingleNameById('name','material_type',$value->material_type_id,'id');
                              $materialTypeData[] = getSingleNameById('name','material_type',$mattype,'id');
                           }
                           $i++;
                        }
                        $materialType = implode('  ', $materialTypeData);
                        $j = 0;
                        foreach ($mData as $key => $value) {
                           if( $j < 3 ){
                              $materialNameData[] = getSingleNameById('material_name','material',$value->material_name,'id');
                           }
                           $j++;
                        }
                        $materialName = implode(' | ', $materialNameData);    
                        $k = 0;
                        foreach ($mData as $key => $value) {
                           if( $k < 3 ){
                              $uom[] = $value->uom;
                           }
                           $k++;
                        }
                        $uomName = implode(' | ', $uom);    
                   }
               ?>
               <td data-label="Material Type:">
                  <?= (!empty($materialType))?$materialType:'N/A'; ?>
               </td>
               <td data-label="Material Detail:"><a style="cursor: pointer;" class="add_purchase_tabs" id="<?php echo $supplier["id"]; ?>" data-toggle="modal" data-id="SupplierMatView"><?= (!empty($materialName))?$materialName:'N/A'; ?></a></td>
               <?php                   
                  $output[] = array(
                     'Supplier ID' => $supplier['id'],
                     'Supplier Name' => $supplier['name'],
                     'Material Type' => (!empty($materialType))?$materialType:'N/A',
                     'Material Name' => (!empty($materialName))?$materialName:'N/A',
                     'UOM' => (!empty($uomName))?$uomName:'N/A',
                     'Created Date' => date("d-m-Y", strtotime($supplier['created_date'])),
                  );
                  
                  $output_blank[] = array(
                        'name' => '',
                        'address' => '',
                        'mailing_name' => '',
                        'gstin' => '',
                        'website' => '',
                        'branch_name' => '', 
                        'account_no' => '',
                        'ifsc_code' => '',
                        'other' => '',
                  );    
                  
                  ?>
               <td data-label="Contact person :">
                  <?php $contactPerson = json_decode($supplier['contact_detail']);
                     if(!empty($contactPerson)){
                        foreach($contactPerson as $contact_person){
                           $PersonName= $contact_person->contact_detail;
                           echo $PersonName; 
                        }
                     }
                     ?>    
               </td>
               <td data-label="Created By / Edited By:" class='hidde'><?php echo "<a href='".base_url()."users/edit/".$supplier['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$supplier["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
               <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($supplier['created_date'])); ?></td>
               <td class="hidde action" >
			      <i class="fa fa-cog" aria-hidden="true"></i>
				    <div class="on-hover-action">
                  <?php 
                     if($can_edit)
                        echo '<a href="javascript:void(0)"  class="btn btn-edit btn-xs add_purchase_tabs" data-toggle="modal" data-id="editSupplier" id="'.$supplier["id"].'">Edit</a>'; 
                     if($can_view) 
                        echo '<a href="javascript:void(0)"  class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="'.$supplier["id"].'">View</a>';
                     if($can_delete && $supplier["used_status"]==0)
                        echo '<a href="javascript:void(0)"  class="delete_listing
                     btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_supplier/'.$supplier["id"].'">Delete</a>';
                     ?>
					 </div>
               </td>
            </tr>
            <?php
               }
               $data3  = $output;   
               //pre($data3);
               export_csv_excel($data3);  
               $data_balnk  = $output_blank;
               export_csv_excel_blank($data_balnk);   
               }else{
               echo '<tr><td colspan="9"><b>No Data Avilable.</b></td></tr>';   
               } 
               ?>
         </tbody>
      </table>
      <?php echo $this->pagination->create_links(); ?>   
      <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><?php echo $result_count; ?></span></div>
   </div>
</div>
<div id="printView">
   <div id="purchase_add_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Suppliers</h4>
            </div>
            <div class="modal-body-content" style="height:auto;"></div>
         </div>
      </div>
   </div>
</div>
<?php $this->load->view('common_modal'); ?>