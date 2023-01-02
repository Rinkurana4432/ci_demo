  
<div class="x_content">
   <?php
      if ($this->session->flashdata('message') != '') {
          echo '<div class="alert alert-info">' . $this->session->flashdata('message') . '</div>';
      }
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
      ?>
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="post" action="<?=base_url() ?>inventory/reorder_level">
            <div class="col-md-6">
               <div class="input-group"> 
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter Id,Material Name" name="search" id="search" value="<?php if (!empty($_GET['search'])) echo $_GET['search']; ?>" data-ctrl="inventory/reorder_level1">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>	
                  <a href="<?php echo base_url(); ?>inventory/reorder_level"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <form class="form-search" id="orderby" method="post" action="<?=base_url() ?>inventory/reorder_level1">
            <input type="hidden" name="order" id="order" value="<?php if (isset($_POST['order']) == '' || $_POST['order'] == 'desc') { echo 'asc'; } else { echo 'desc'; } ?>">
         </form>
      </div>
   </div>

     <form action="<?php echo base_url(); ?>inventory/reorder_level" method="get" id="export-form">
       <input type="hidden" value='' id='hidden-type' name='ExportType' />
       <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'] ; ?>' name='search' />
    </form>

   <div class="row hidde_cls export_div">
      <div class="col-md-12">
           <div class="btn-group" role="group" aria-label="Basic example">
                <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                   <button class="btn btn-secondary dropdown-toggle btn-default" type="button"
                      data-toggle="dropdown">Export<span class="caret"></span></button>
                   <ul class="dropdown-menu" role="menu" id="export-menu">
                      <li id="export-to-excel"><a href="javascript:void(0);"
                            title="Please check your open office Setting">Export to excel</a></li>
                      <li id="export-to-csv"><a href="javascript:void(0);"
                            title="Please check your open office Setting">Export to csv</a></li>
                   </ul>
                </div>
				<button class="btn btn btn btn-outline-secondary indent createIndentreorder indent_create_btn"  data-toggle="modal" data-id="indentEdit" style="" disabled>Indent Create </button> 
      </div>
   </div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content">
      <!---------- datatable-buttons ------------->
      <table id="" class="table table-striped table-bordered account_index" data-id="account" style="margin-top:40px;">
         <thead>
            <tr>
				<th style="width: 1%;"><label style="padding: 6px;"><input type="checkbox" class="all_indent_create" value="" ></label></th>
			
               <th scope="col">Id<span><a href="<?php echo base_url(); ?>inventory/reorder_level?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>inventory/reorder_level?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Product Type</th>
               <th scope="col">Sub Type</th>
               <th scope="col">Material Name<span><a href="<?php echo base_url(); ?>inventory/reorder_level?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>inventory/reorder_level?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Product SKU<span><a href="<?php echo base_url(); ?>inventory/reorder_level?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>inventory/reorder_level?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Closing Balance<span><a href="<?php echo base_url(); ?>inventory/reorder_level?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>inventory/reorder_level?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Reorder Level<span><a href="<?php echo base_url(); ?>inventory/reorder_level?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>inventory/reorder_level?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Incoming Quantity</th>
               <th scope="col">Missing Quantity</th>
            </tr>
         </thead>
         <tbody>
            <?php if (!empty($reorder_level)) {
					$i=1;
               foreach ($reorder_level as $reorderlevel) {   
                        $below_reorder_level = 'class="well"';
                        if($reorderlevel['closing_balance'] < $reorderlevel['min_inventory']){
                           $below_reorder_level = 'class = "below_reorder_level well "';
                        }

						 // $where_type = "mrn_or_not = 0 AND created_by_cid = ".$this->companyGroupId;
						 // $incoingQty = $this->inventory_model->get_one_field('purchase_indent', 'material_name', $where_type);
						 // foreach($incoingQty);
						// $incoingQty= getNameById('purchase_indent',$reorderlevel['id'], 'work_order_id');
						// $reorderlevel['id']
                       	$action = '<a href="javascript:void(0)" id="'.$reorderlevel['id'].'" data-id="material_view" class="inventory_tabs btn btn-warning btn-xs" id="'.$reorderlevel["id"].'"><i class="fa fa-eye"></i></a>';
               	/*	$action .= '<a href="javascript:void(0)" id="'.$reorderlevel['id'].'" data-id="convert_to_pi" data-tooltip="Convert to Purchase Indent" class="inventory_tabs btn btn-edit  btn-xs"><img src="'.base_url().'assets/modules/crm/uploads/convert.png"></a>';*/
               	   echo "<tr $below_reorder_level  id='wochkIndex_".$i."' style='float:none!important;'>";?>
				    <td><input type="checkbox" class="indent_create" value="<?php echo $reorderlevel['id']; ?>"  ></td>

				   <?php
              
               $PurchaseQty=0;
                foreach ($reordepurchase as $Materialkey => $Qtyvalue) {
                    foreach ($Qtyvalue as  $valueQty) {
                      if($Materialkey==$reorderlevel['id']){ 
                         $PurchaseQty +=$valueQty->quantity;
                   }
                  }
                 }
                 $missingQty= ($reorderlevel['min_inventory']-$reorderlevel['closing_balance']-$PurchaseQty);
                   if($missingQty<0){
                    $finalMissingQty=0;
                  }else{
                     $finalMissingQty=$missingQty;
                  }
               	 	echo "	<td data-label='id:'>" . $reorderlevel['id'] . "</td>
								<td data-label='Material Name:'>" .$reorderlevel['product_type']. "</td>
								<td data-label='Material Name:'>" .$reorderlevel['sub_type']. "</td>
								<td data-label='Material Name:'>" .$reorderlevel['material_name']. "</td>
								<td data-label='Material Name:'>" .$reorderlevel['mat_sku']. "</td>
								<td data-label='Material Name:'>" .$reorderlevel['closing_balance']. "</td>
								<td data-label='Min Inventory:'>" . $reorderlevel['min_inventory'] . "</td>
								<td data-label='Incoming Qty:'>" .  $PurchaseQty . "</td>
                        <td data-label='Incoming Qty:'>" .   $finalMissingQty . "</td>
							</tr>";
                        $output[] = array(
                              /** 'Id' => $mat['id'],**/
                                 'Id' => $reorderlevel['id'],
                                 'Product Type' => $reorderlevel['product_type'],
                                 'Sub Type' => $reorderlevel['sub_type'],
                                 'Material Name' => $reorderlevel['material_name'],
                                 'Opening Balance' => $reorderlevel['opening_balance'],
                                 'Closing Balance' => $reorderlevel['closing_balance'],
                                 'Reorder Level' => $reorderlevel['min_inventory'],
                              );


				$i++;				
               	} 
                    $data3  = $output;
                    export_csv_excel($data3); 
               }
                           
             ?> 

         </tbody>
      </table>
      <?php echo $this->pagination->create_links(); ?>	
	   <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
   </div>
</div>
<div id="printThis">
   <div id="inventory_add_modal" class="modal fade in"  class="modal fade in"  role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Purchase Indent</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
   <div id="" class="modal fade in"  class="modal fade in"  role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Material</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
   <div class="modal fade bs-example-modal-lg "  role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Reorder Report Filter</h4>
            </div>
            <div class="modal-body">
               <form action="<?php echo  base_url() ?>inventory/generate_reorder_report" method="post">
                  <input type="hidden" id="record_id" value="<?php echo isset($reorderlevel['id']); ?>">
                  <div class="row">
                     <!--div class="col-md-12 col-sm-6 col-xs-12 form-group add_multiple_location middle-box2">	
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                               <label>Branch</label>
                        	   	<select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="branch_name" data-id="company_address" data-key="id" data-fieldname="location" id="branch" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
                        	   		<option value="">Select Option</option>
                        	   </select>
                        </div>
                        <div class="item form-group">
                        	<label class="col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Type<span class="required" style="color:red;">*</span></label>
                        	<div class="col-md-6 col-sm-6 col-xs-12">
                        		<select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0"  id="mattyp" onchange="ChangePrefix_and_subType();">
                        		<option value="">Select All</option>	
                        		</select>
                        	</div>
                        </div>
                        <div class="item form-group">
                        	<label class="col-md-3 col-sm-3 col-xs-12" for="materail_type">Material Sub Type</label>
                        	<div class="col-md-6 col-sm-6 col-xs-12">
                        		<select class="subtype form-control" name="sub_type" id="material_subtype">
                        			<option value="">Select Sub type</option>
                        		</select>
                        	</div>
                        </div>
                        </div-->
                     <div class="col-md-12 col-xs-12 col-sm-12">
					 <div class=" col-md-6 vertical-border">
                        <div class="item form-group">
                           <label class="col-md-3">Branch</label>
						   <div class="col-md-6 col-sm-6 col-xs-12">
                           <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location chck" name="branch_name" data-id="company_address" data-key="id" data-fieldname="location" id="branch" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>">
                              <option value="">Select Option</option>
                           </select>
						   </div>
                        </div>
                        <div class="item form-group">
                           <label class="col-md-3" for="materail_type">Material Type<span class="required" style="color:red;">*</span></label>
                           <div class="col-md-6 col-sm-6 col-xs-12">
                              <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId chck" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0"  id="mattyp" onchange="ChangePrefix_and_subType();" required
                                 >
                                 <option value="">Select All</option>
                              </select>
                           </div>
                        </div>
						</div>
						<div class=" col-md-6 vertical-border">
                        <div class="item form-group">
                           <label class="col-md-3" for="materail_type">Material Sub Type</label>
                           <div class="col-md-6 col-sm-6 col-xs-12">
                              <select class="subtype form-control" name="sub_type" id="material_subtype">
                                 <option value="">Select Sub type</option>
                              </select>
                           </div>
                        </div>
						</div>
                     </div>
                     <Center>
                        <input type="submit" class="btn btn-warning submitCompanyBtn" value="Submit"> 
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="reset" class="btn btn-default">Reset</button>	
                     </center>
               </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

 <div id="ReorderLevelPI_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
           <h4 class="modal-title" id="myModalLabel">Create Indent</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>




<!---------- Small Modal ---------------- -->