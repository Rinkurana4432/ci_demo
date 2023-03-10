<?php if($this->session->flashdata('message') != ''){?>
<div class="alert alert-info">
   <?php echo $this->session->flashdata('message');?>
   <?php

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ; ?>
</div>
<?php }

   ?>
<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="post" action="<?= base_url() ?>inventory/work_in_process">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Product Name,Product Type" name="search" id="search" data-ctrl="inventory/work_in_process" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>inventory/work_in_process"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>inventory/work_in_process">
            <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
         </form>
       <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
          <div id="demo" class="collapse">
       <div class="col-md-4 col-xs-12 col-sm-6 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="inventory/work_in_process">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>inventory/work_in_process" method="get" id="date_range"> <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'] ;} ?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'] ;} ?>' class='end_date' name='end'/>
            </form>
         </div>
        <ul style="padding: 0px; text-align: center;">
                  <li id="export-to-excel">
                     <form action="<?php echo base_url(); ?>inventory/work_in_process" method="get" >
                        <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start'/>
                        <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end'/>
                        <div >
                           <div class="col-md-12">
                              <div class="btn-group disbled_cls"  role="group" aria-label="Basic example" >
         <select style="border-right: 1px solid #c1c1c1;" class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="company_unit" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyId; ?>">
                                    <option>Select Location</option>
                                 </select>
                              </div>
                              <input type="submit" value="Filter" class="btn filterBtn filt1"  >
                           </div>
                        </div>
                     </form>
                  </li>
               </ul>
       </div>
      </div>
   </div>
   <div class="row hidde_cls">
      <div class="col-md-12  export_div">
         <form action="<?php echo base_url(); ?>inventory/work_in_process" method="get" id="export-form">
            <input type="hidden" value='export-to-excel' id='hidden-type' name='ExportType'/>
            <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'] ;} ?>' class='start_date' name='start'/>
            <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'] ;} ?>' class='end_date' name='end'/>
            <input type="hidden" value='<?php if(isset($_GET['company_unit'])){echo $_GET['company_unit'] ;} ?>' class='company_unit' name='company_unit'/>
         <input type="hidden" value='<?php if(isset($_GET['search'])){echo $_GET['search'] ;} ?>' name='search'/>
       </form>


            <div class="btn-group"  role="group" aria-label="Basic example">
             <?php if($can_add) {
            echo '<button type="buttton" class="btn btn-info inventory_tabs addBtn" id="wip_add" data-toggle="modal" data-id="work_in_process">Add RM Request</button>';

            }

            ?>
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
               <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                  <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="export-menu">
                     <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                     <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                   <!--  <li id="export-to-blank-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to Blank Excel</a></li>-->
                  </ul>
               </div>

            </div>



      </div>

   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">
   <div id="print_div_content">

      <!------- datatable-buttons ------------->
      <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3" style="margin-top:40px;">
      <thead>
         <tr>
            <th scope="col">Id
               <span><a href="<?php echo base_url(); ?>inventory/work_in_process?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>inventory/work_in_process?sort=desc" class="down"></a></span>
            </th>
            <th scope="col">WIP Material Detail</th>
            <th scope="col">UOM</th>
            <th scope="col">Location</th>
            <th scope="col">Created By</th>
             <th scope="col">Created Date</th>
            <th scope="col" class='hidde'>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php if(!empty($material_issue)){

 
            foreach($material_issue as $materialissue){

                 $quotCreatedBy = ($materialissue['created_by']!=0)?(getNameById('user_detail',$materialissue['created_by'],'u_id')):'';
                  $createdByName = (!empty($quotCreatedBy))?$quotCreatedBy->name:'';


            if ($materialissue['issued_status']==1) {

               $action='<button id="'. $materialissue["id"] . '" data-id="work_in_processwork_in_processID"-tooltip="View" class="btn btn-xs inventory_tabs add-machine add-simi"><i class="fa fa-eye" aria-hidden="true"></i></button>';
            }else if ($materialissue['issued_status']==0) {

            $action = '<button id="'. $materialissue["id"] . '" data-id="work_in_process_edit_one" data-tooltip="Edit" class="btn btn-xs inventory_tabs add-machine add-simi"><i class="fa fa-edit" aria-hidden="true"></i></button>

            <button id="'. $materialissue["id"] . '" data-id="work_in_processwork_in_processID" data-tooltip="View" class="btn btn-xs inventory_tabs add-machine add-simi"><i class="fa fa-eye" aria-hidden="true"></i></button>';
              }
       ?>
         <!-----------datatable-buttons-------->

            <?php

               if($materialissue['mat_detail'] !=''){
                     $productsjd = json_decode($materialissue['mat_detail']);
                      $locadd = ''; 
                     foreach ($productsjd as  $product) { 
                      $material_type = getNameById('material_type',$product->material_type_id,'id');
                            if(!empty($material_type)){ $mattype =  $material_type->name;} else { }

                            $productDetail = getNameById('material',$product->material_id,'id');
                            $materialName = !empty($productDetail->material_name)?$productDetail->material_name:'';

                            $location_address = getNameById('company_address',$product->location,'id');

                            if(!empty($location_address)){ $locadd =  $location_address->location;} else {  }
                            $ww =  getNameById('uom', $product->uom,'id');
                            $uom = !empty($ww)?$ww->ugc_code:'';
                            $mat_status = $product->material_status??'';
                            $quanttyyy = !empty($product)?$product->quantity:'';
                           
                   $output[] = array(
                      'Id' =>$materialissue['id'],
                      'Product Type'=>$mattype,
                      'Product Name' =>$materialName,
                      'Uom' => $uom??'',
                      'Location'=> str_replace(",","",$locadd),
                      'Created By'=> $createdByName,
                      // 'Wokr Order' => $new_work_order,
                      // 'NPDM'=> $new_npdm,
                      // 'Machine Name' =>$new_machine
                   );
                  
                     

                 }
                  }

                  echo "<tr>
                     <td data-label='Id:'>".$materialissue['id']."</td>
                     <td data-label='WIP Material Detail:'> " .@$materialName."   </td>
                  <td data-label='Created By:'>". @$uom."</td>
                   <td data-label='Created By:'>".str_replace(",","",$locadd)."</td>
                     <td data-label='Created By:'>".$createdByName."</td>


                     <td data-label='Created Date:'>".date("j F , Y", strtotime($materialissue['created_date']))."</td>
                     <td data-label='action:' class='hidde'>".$action."</td>


               </tr>";

               }
               $data3  = @$output;
             # pre($data3);
              # die;
               export_csv_excel($data3);
               } ?>
         </table>
         <?php echo $this->pagination->create_links(); ?>
        <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
   </div>
</div>
<div id="printView">
<div id="inventory_add_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
<div class="modal-dialog modal-large">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">??</span>
</button>
<h4 class="modal-title" id="myModalLabel">Raw Material Request</h4>
</div>
<div class="modal-body-content"></div>
</div>
</div>
</div>
</div>
