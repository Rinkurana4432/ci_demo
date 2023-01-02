
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
     
         <!--<div class="col-md-12 ">
           
         </div>-->
     
	  <div class="Filter Filter-btn2">
	       <form class="form-search" method="get" action="<?= base_url() ?>production/sale_order_with_production">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id,accountName,Product Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="production/sale_order_with_production?tab=<?php if(isset($_GET['tab']))echo $_GET['tab']?>">
                  <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']?>" />
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=<?php if(isset($_GET['tab']))echo $_GET['tab']?>">
                  <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
	     <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
		 <div id="demo" class="collapse">
		    <div class="col-md-6 datePick-right">
               <?php //if($can_add){ echo '<button class="btn btn-primary productionTab addBtn" data-toggle="modal" id="add1" data-id="machineEdit">Add</button>'; }?>	
               <?php //if($can_add){ echo '<button class="btn btn-primary productionTab addBtn" data-toggle="modal" id="add1" data-id="machineEditNew">Add New</button>'; }?>				
               <form action="<?php echo site_url(); ?>production/sale_order_with_production?tab=<?php if(isset($_GET['tab']))echo $_GET['tab']?>" method="get" id="export-form">
                  <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                  <input type="hidden" value='' class='start_date' name='start'/>
                  <input type="hidden" value='' class='end_date' name='end'/>
                  <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php echo $_GET['tab']; ?>' name='tab'/>
                  <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
                  <input type="hidden" value='<?php echo $_GET['search']; ?>' name='search'/>
                  <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name='favourites'/>
               </form>
            </div>
			<div class="col-md-3 col-xs-12">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/sale_order_with_production"/>
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?php echo base_url(); ?>production/sale_order_with_production?tab=<?php if(isset($_GET['tab']))echo $_GET['tab']?>" method="get" id="date_range">	
                  <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']?>" />
                  <input type="hidden" value='' class='start_date' name='start'/>
                  <input type="hidden" value='' class='end_date' name='end'/>
               </form>
            </div>
		 </div>
	  </div>
      <div class="row hidde_cls stik">
         <div class="col-md-12 export_div">
            
            <div class="btn-group"  role="group" aria-label="Basic example">
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
               <form action="<?php echo base_url(); ?>production/sale_order_with_production?tab=<?php if(isset($_GET['tab']))echo $_GET['tab']?>" method="get" >
                  <input type="hidden" value='1' name='favourites'/>
                  <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
                  <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
                  <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']?>" />
                  <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
               </form>
               <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                  <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="export-menu">
                     <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                     <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  </ul>
               </div>
            </div>
            <div class="col-md-3 col-xs-12 datePick-right"></div>
         </div>
        
      </div>
   </div>
   <div  role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active">
            <a href="#inprocess_sale_order" role="tab" id="inprocess_sale_order_tab" data-toggle="tab" aria-expanded="true" onClick="inprocess_sale_order();">In Process Sale Order</a>
         </li>
         <li role="presentation" class=""><a href="#sale_order_priority" id="sale_order_priority_tab" role="tab" data-toggle="tab" aria-expanded="false">Sale order Priority</a></li>
         <li role="presentation" class="">
            <a href="#complete_sale_order" id="complete_sale_order_tab" role="tab" data-toggle="tab" aria-expanded="false" onClick="complete_sale_order();">Complete Sale Order</a>
         </li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="inprocess_sale_order" aria-labelledby="inprocess_sale_order_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <div id="print_div_content" class="table-responsive">
               <form id="inprocess_tab">
                  <input type="hidden" name="tab" value="inprocess">
               </form>
               <table class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                  <thead>
                     <tr>
                        <th></th>
                        <th scope="col">Id<span><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=inprocess&sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=inprocess&sort=desc" class="down"></a></span></th>
                        <th scope="col">Account Name<a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=inprocess&sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=inprocess&sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
                        <th scope="col">Product Details<a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=inprocess&sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=inprocess&sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
                        <th scope="col">Order Date<span class="resize-handle"></span></th>
                        <th scope="col">Dispatched Date<span class="resize-handle"></span></th>
                        <th scope="col">Approved date<span class="resize-handle"></span></th>
                        <th scope="col">Created By<span class="resize-handle"></span></th>
                        <th scope="col">Created Date<span class="resize-handle"></span></th>
                        <th scope="col" class='hidde'>Action<span class="resize-handle"></span></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($sale_order_approved)){
                        foreach($sale_order_approved as $approved_saleOrder){
                        	
                        $saleIdFrom_WorkOrder = getNameById('work_order',$approved_saleOrder['id'],'sale_order_id');
                        $getSaleOrderId = !empty($saleIdFrom_WorkOrder->sale_order_id)?$saleIdFrom_WorkOrder->sale_order_id:'';
                        
                        $accountName = getNameById('account',$approved_saleOrder['account_id'],'id');
                        $disableDispatch = (($approved_saleOrder['save_status'] == 0) || ($approved_saleOrder["approve"] == 0) )?'disabled':'';
                        $disableDispatchModalClass = (($approved_saleOrder['save_status'] == 0) || ($approved_saleOrder["approve"] == 0) )?'':'productionTab'; 					
                        ?>
                     <tr>
                        <td><?php 
                           if($approved_saleOrder['favourite_sts'] == '1'){
                           	   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$approved_saleOrder['id']."  checked = 'checked'>";
                           	   				echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order' data-path='production/sale_order_with_production?tab=inprocess' favour-sts='0' id-recd=".$approved_saleOrder['id'].">";
                           	   		}else{
                           					echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$approved_saleOrder['id'].">";
                           					echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order' data-path='production/sale_order_with_production?tab=inprocess' favour-sts='1' id-recd =".$approved_saleOrder['id'].">";
                           	   		}
                           
                           ?>
                        </td>
                        <td data-label="Id:"><?php echo $approved_saleOrder['id']; ?></td>
                        <td data-label="Account Name:"><?php if(!empty($accountName)){echo $accountName->name;} ?></td>
						<?php 
						 if($approved_saleOrder['product'] !=''){

                                 	$products=json_decode($approved_saleOrder['product']);
                                 	$createdByData = getNameById('user_detail',$approved_saleOrder['created_by'],'u_id');
                                 	//$createdByData = getNameById('user_detail',$approved_saleOrder['created_by'],'u_id');
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
									 $output[] = array( 
											 'Id'=>$approved_saleOrder['id'],
											 'Account Name' => $accountName->name,
											 'Product' => $materialName,
										  
											 'Quantity' =>$product->quantity,
											 'UOM' => $uom,
											 'Price'=>$product->price,
											 'Created Date' =>date("d-m-Y", strtotime($approved_saleOrder['created_date'])),
									);
                             
									}
                     }
						?>
						
                        <td data-label="Product details:"><a href="javascript:void(0)" id="<?php echo $approved_saleOrder["id"];?>" data-id="dispatched_order_matview" class="productionTab"><?php echo $materialName; ?></a></td>
                        <td data-label="Order Date:"><?php echo date("j F , Y", strtotime($approved_saleOrder['order_date'])); ?></td>
                        <td data-label="Dispatched Date:">
                           <?php $dispatch_date = json_decode($approved_saleOrder['production_dispatch_date']);

                              if(!empty($dispatch_date)){
                              
                              	foreach($dispatch_date->dispatch_date as $key=> $dispatch){
                                       echo "<strong> </strong>".$dispatch." <br>";
                                     }
                                    
                                     foreach($dispatch_date->approveby as $keyx=> $approveby){
                                          echo  "<strong> </strong> ".$approveby." <br> "; 
                                  }
                              }
                              ?>
                        </td>
                        <td data-label="Approved date:"><?php echo $approved_saleOrder['approve_date']; ?></td>
                        <td data-label="Approved By :"><?php echo $createdByName; ?></td>
                        <td data-label="Created Date :"><?php echo date("j F , Y", strtotime($approved_saleOrder['created_date'])); ?></td>
                        <td data-label='Action:' class='hidde acc-btn action'><i class='fa fa-cog' aria-hidden='true'></i><div class='on-hover-action'>
                           <a id="<?php echo $approved_saleOrder["id"]; ?>" data-id="dispatched_order"  class="productionTab btn btn-view  btn-xs" <?php echo $disableDispatch ; ?>>Dispatch</a>
                           <a id="<?php echo $approved_saleOrder["id"]; ?>" data-id="set_dispatched_date"  class="productionTab btn btn-view  btn-xs" <?php echo $disableDispatch ; ?>>Dispatch Date</a>
                           <?php echo '<a href="javascript:void(0)" id="'. $approved_saleOrder["id"] . '" data-id="dispatched_order_view"  class="productionTab btn btn-view btn-xs" id="' . $approved_saleOrder["id"] . '">View</a>'; ?>
                           <?php /*if($getSaleOrderId == $approved_saleOrder['id']){?>
                           <button id="<?php echo $approved_saleOrder["id"]; ?>" data-id="create_work_order" data-tooltip="Work Order" class="productionTab btn btn-default  btn-xs" <?php echo 'disabled' ; ?>><i class="fa fa-edit"></i>Work order</button>
                           <?php }else{ ?>
                           <?php } */ ?>
                  <?php if (!empty($dispatch_date)): ?>
                     <a id="<?php echo $approved_saleOrder["id"]; ?>" data-id="create_work_order" class="productionTab btn btn-view  btn-xs" >Work Order</a>
                  <?php endif ?>
                         
                        </td>
                     </tr>
                     <?php } $process_saleorder  = $output;
                        export_csv_excel($process_saleorder);} ?>
                  </tbody>
               </table>
            </div>
         </div>
         <!------------sale order priority--------------------------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="sale_order_priority" aria-labelledby="sale_order_priority_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <div id="print_div_content">
               <div id="sortableKanbanBoards" class="saleOrderPriority">
                  <div class="panel panel-primary kanban-col" style="width:100%">
                     <div class="panel-heading">
                        Set Sale order Priority
                        <!--i class="fa fa-2x fa-plus-circle pull-right"></i-->
                        <i class="fa fa-2x fa-minus-circle pull-right machineOrder"></i>
                     </div>
                     <div class="panel-body">
                        <div id="sale_order
                           " class="kanban-centered">
                           <?php if(!empty($sale_orders_priority)){
                              $i = 0;
                              foreach($sale_orders_priority as $sale_priority){ 
                              	
                              	$i++;
                              	
                              	$accountName = ($sale_priority['account_id']!=0)?(getNameById('account',$sale_priority['account_id'],'id')):'';
                              	$accountName = !empty($accountName)?$accountName->name:'';										
                              	$contactName = ($sale_priority['contact_id']!=0)?(getNameById('contacts',$sale_priority['contact_id'],'id')):'';
                              	if(!empty($contactName)){
                              		$contactName = $contactName->first_name.' '.$contactName->last_name;
                              	}else{
                              		$contactName = '';
                              	}
                              	
                              	$validatedBy = ($sale_priority['validated_by']!=0)?(getNameById('user_detail',$sale_priority['validated_by'],'id')):'';
                              	if(!empty($validatedBy)){
                              		$validatedByName = $validatedBy->name;
                              	}else{
                              		$validatedByName = '';
                              	}	
                              	$material_name = array();					
                              	$products = json_decode($sale_priority['product']);
                              	//pre($products);
                              	foreach($products as $prod_detail){
                              		//if(!empty($prod_detail) && isset($prod_detail)){
                              		$materialData = getNameById('material',$prod_detail->product,'id');
                              			if(!empty($materialData)){
                              				$material_name[] =$materialData->material_name;
                              			}
                              		//}
                              	}
                              	
                              	$material = implode(',',$material_name);
                              	?>
                           <div class="main-rw">
                              <a><span class="counting-bg step_no"><?php echo $i; ?></span></a>
                              <article class="kanban-entry grab saleOrder" id="item<?php echo $i; ?>" data_sale_order_id="<?php echo $sale_priority['id'];?>" draggable="true"  data_priority="<?php echo $sale_priority['sale_order_priority']; ?>">
                                 <div class="kanban-entry-inner" >
                                    <div class="kanban-label">	
                                       <?php echo " Sale Order Id : ".$sale_priority['id']."                   |                   Account Name : ".$accountName. "                  |                   Contact Name : ".$contactName."                   |                   Order Date : ".$sale_priority['order_date']."                   |                   Dispatch Date : ".$sale_priority['dispatch_date']."                   |                   Created By : ".$createdByName."                   |                   Created Date: ".$sale_priority['created_date']."<br>Product Name : ".$material; ?>
                                    </div>
                                 </div>
                              </article>
                           </div>
                           <?php	} } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!----------------------complete sale order tab start---------------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="complete_sale_order" aria-labelledby="complete_sale_order_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <form id="complete_tab">
               <input type="hidden" name="tab" value="complete">
            </form>
            <div id="print_div_content">
               <table style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                  <thead>
                     <tr>
                        <th></th>
                        <th scope="col">Id<span><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=complete&sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=complete&sort=desc" class="down"></a></span></th>
                        <th scope="col">Account Name<span><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=complete&sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=complete&sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
                        <th scope="col">Product<span><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=complete&sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/sale_order_with_production?tab=complete&sort=desc" class="down"></a></span><span class="resize-handle"></span></th>
                        <th scope="col">Order Date<span class="resize-handle"></span></th>
                        <th scope="col">Dispatched Date<span class="resize-handle"></span></th>
                        <th scope="col" >Created By<span class="resize-handle"></span></th>
                        <th scope="col">Created Date<span class="resize-handle"></span></th>
                        <th scope="col" class='hidde'>Action<span class="resize-handle"></span></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($complete_sale_order)){
                        foreach($complete_sale_order as $completedOrder){
                        $accountName = getNameById('account',$completedOrder['account_id'],'id');
                        $disableDispatch = (($completedOrder['save_status'] == 0) || ($completedOrder["approve"] == 0) )?'disabled':'';
                        $disableDispatchModalClass = (($completedOrder['save_status'] == 0) || ($completedOrder["approve"] == 0) )?'':'productionTab'; 					
                        ?>
                     <tr>
                        <td><?php 
                           if($completedOrder['favourite_sts'] == '1'){
                           			   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$completedOrder['id']."  checked = 'checked'>";
                           			   				echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order' data-path='production/sale_order_with_production?tab=complete' favour-sts='0' id-recd=".$completedOrder['id'].">";
                           			   		}else{
                           							echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$completedOrder['id'].">";
                           							echo"<input type='hidden' value='sale_order' id='favr' data-msg='Sale Order' data-path='production/sale_order_with_production?tab=complete' favour-sts='1' id-recd =".$completedOrder['id'].">";
                           			   		}
                           ?></td>
                        <td data-label="Id:"><?php echo $completedOrder['id']; ?></td>
                        <td data-label="Account Name:"><?php if(!empty($accountName)){echo $accountName->name;} ?></td>
						<?php 
						if($completedOrder['product'] !=''){
                                 	$productData=json_decode($completedOrder['product']);
                                 	$createdByData = getNameById('user_detail',$completedOrder['created_by'],'u_id');
                                 	if(!empty($createdByData)){
                                 		$createdByName = $createdByData->name;
                                 	}else{
                                 	$createdByName = '';
                                 	}
                                 	
                                 	foreach($productData as $product_data){
                                 	$product_Detail = getNameById('material',$product_data->product,'id');
                                 	$materialName = !empty($product_Detail)?$product_Detail->material_name:'';
                                 	$ww =  getNameById('uom', $product_data->uom,'id');
                                 	$uom = !empty($ww)?$ww->ugc_code:'';
                                 						
                                 $output[] = array( 
                                 'Account Name' => $accountName->name,
                                 'Product' => $materialName,
                                 'Quantity' =>$product_data->quantity,
                                 'UOM' => $uom,
                                 'Price'=>$product_data->price,
                                 'Created Date' =>date("d-m-Y", strtotime($completedOrder['created_date'])),
                                 );	
                                 	} 
                                 }
						
						?>
						<td data-label="Product details:"><a href="javascript:void(0)" id="<?php echo $completedOrder["id"];?>" data-id="dispatched_order_matview" class="productionTab"><?php echo $materialName; ?></a></td>
                        <!--td data-label="Product:"><?php //echo $materialName; ?></td-->
                        <td data-label="order date:"><?php echo date("j F , Y", strtotime($completedOrder['order_date'])); ?></td>
                        <td data-label="Dispatched Date:"><?php $dispatch_date = json_decode($completedOrder['production_dispatch_date']);
                           //pre($dispatch_date);
                           if(!empty($dispatch_date)){
                           	foreach($dispatch_date as $dispatch){
                           		foreach($dispatch as $date){
                           			echo "<strong> </strong>:".$date."</br>";
                           		}
                           	}
                           }
                           ?></td>
                        <td data-label="Created By:"><?php echo $createdByName; ?></td>
                        <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($completedOrder['created_date'])); ?></td>
                        <td data-label='Action:' class='hidde acc-btn action'><i class='fa fa-cog' aria-hidden='true'></i><div class='on-hover-action'><?php echo '<a href="javascript:void(0)" id="'. $completedOrder["id"] . '" data-id="dispatched_order_view"  class="productionTab btn btn-view btn-xs" id="' . $completedOrder["id"] . '">View</a>'; ?></div></td>
                     </tr>
                     <?php }
                        $saleorder  = $output;
                        export_csv_excel($saleorder);} ?>
                  </tbody>
               </table>
		</div>
         </div>
	<?php echo $this->pagination->create_links(); ?>	
  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span>
  </div>
         <!--------end of tab complete sale order------------------------------------------>
         <!----------- sale order tab close -------------------------------------------------->
      </div>
   </div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title sale_order_work_order" id="myModalLabel">Dispatch Detail</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="text-center">
               <i class="fa fa-refresh fa-5x fa fa-spin"></i>
               <h4>Processing...</h4>
            </div>
         </div>
      </div>
   </div>
</div>