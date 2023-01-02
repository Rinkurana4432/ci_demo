<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="get" action="<?= base_url() ?>account/purchase_bill">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/purchase_bill?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
                  <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>account/purchase_bill?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
         <div id="demo" class="collapse">
            <div class="col-md-12 col-xs-12 datePick-left">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/purchase_bill"/>
                        </div>
                     </div>
                  </div>
               </fieldset>
			   <form action="<?php echo base_url(); ?>account/purchase_bill" method="get" id="date_range">	
							   <input type="hidden" value='' class='start_date' name='start'/>
							  <input type="hidden" value='' class='end_date' name='end'/>
							      <input type="hidden" value='<?php echo $_GET['tab'];?>' name='tab'/>
							</form>	
              
            </div>
         </div>
      </div>
   </div>
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <div class="row hidde_cls">
	  <?php
			 if($this->session->flashdata('message') != ''){
                  	echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
                  }
	  ?>
         <div class="col-md-12  export_div">
            
               <div class="btn-group"  role="group" aria-label="Basic example">
			       <?php 
                  setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
                 ?>
               <?php if($can_add) {
                  // echo '<button type="button" class="btn btn-success addBtn add_purchase_bill_to_tabs" data-toggle="modal" id="add" data-id="purchase_bill"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
				  echo '<a href="'.base_url().'account/create_purchaseBill" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
                  } ?>
                  <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
				  <?php 
				    if($_GET['tab']== 'purchase_bill'){
				  ?>
                  <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
					<?php }elseif($_GET['tab']== 'auto_entry'){ ?>
					<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtnauto">Print</button>
					<?php }else{ ?>
					<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
					<?php } ?>
                  <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
                     <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                     <ul class="dropdown-menu" role="menu" id="export-menu">
                        <li id="export-to-excel"><a href="#" title="Please check your open office Setting">Export to excel</a></li>
                        <li id="export-to-csv"><a href="#" title="Please check your open office Setting">Export to csv</a></li>
                        <!--li id="export-to-pdf"><a href="#" title="Please check your open office Setting">Export to Pdf</a></li-->
                     </ul>
                  </div>
               </div>
          
         </div>
      </div>
	    <form action="<?php echo site_url(); ?>account/purchase_bill" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='<?php echo $_GET['start'];?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php echo $_GET['end'];?>' class='end_date' name='end'/>
               <input type="hidden" value='<?php echo $_GET['tab'];?>' name='tab'/>
			   <input type="hidden" value='<?php echo $_GET['search'];?>' name='search'/>
            </form>
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#tab_content_purchase_bill" id="purchase_bill_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="submit_purchase_bill()">Purchase Bill</a>
         </li>
         <li role="presentation" class=""><a href="#tab_content_auto_entry" role="tab" id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onClick="submit_auto_form()">Auto Entry</a>
         </li>
      </ul>
      <div id="myTabContent" class="tab-content"> 
	
         <div role="tabpanel" class="tab-pane fade active in" id="tab_content_purchase_bill" aria-labelledby="purchase_bill_tab">
           
            <p class="text-muted font-13 m-b-30"></p>
            <div id="print_div_content">
			 <center><table style="display:none;" class="comp_name"> <tr><td><b>Purchase Bill</b></td></tr></table></center>
               <form id="purchase_bill_form">
                  <input type="hidden" value="purchase_bill" name="tab">	
               </form>
               <!---------------- datatable-buttons ------------------->
               <table id="" class="table table-striped table-bordered" data-id="account"  border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th scope="col">Id
                           <span><a href="<?php echo base_url(); ?>account/purchase_bill?tab=purchase_bill&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>account/purchase_bill?tab=purchase_bill&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Supplier Name
                           <span><a href="<?php echo base_url(); ?>account/purchase_bill?tab=purchase_bill&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>account/purchase_bill?tab=purchase_bill&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Party Name
                           <span><a href="<?php echo base_url(); ?>account/purchase_bill?tab=purchase_bill&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>account/purchase_bill?tab=purchase_bill&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Material Detail</th>
                        <th scope="col">Grand Total</th>
                        <th scope="col">Paid</th>
                        <th scope="col">Bill Add Date</th>
                        <th scope="col">Created By</th>
                        <th scope="col" class='hidde'>Edited By</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php  
                        $date = $freeze_date->freeze_date;
                        if(!empty($purchase_data)){
                          foreach($purchase_data as $purchase_datas){ 
                        //  pre($purchase_datas);
                          
                         $action = '';
                        if($can_edit) { 
                        	if($purchase_datas['created_date'] < $date){
                        		$action .=  '<a href="javascript:void(0)" disabled="disabled" id="'.$purchase_datas["id"].'" data-id="purchase_bill" class="add_purchase_bill_to_tabs btn btn-info btn-xs" id="'.$purchase_datas["id"].'" >Edit</a>';
                        	}
                        	else{
                        		//$action .=  '<a href="javascript:void(0)" id="'.$purchase_datas["id"].'" data-id="purchase_bill" class="add_purchase_bill_to_tabs btn btn-info btn-xs" id="'.$purchase_datas["id"].'"><i class="fa fa-pencil"></i></a>';
								
								
                        		$action .=  '<a href="'.base_url().'account/editpurchase_bill_detail/'.$purchase_datas["id"].'"  class="btn btn-info btn-xs" data-tooltip="Edit" >Edit</a>';
                        		
                        	}
                        	$action .=  '<a href="javascript:void(0)" id="'.$purchase_datas["id"] . '" data-id="purchase_bill_view" class="add_purchase_bill_to_tabs btn btn-warning btn-xs" id="'.$purchase_datas["id"].'" >View</a>';
                        }
                        if($can_delete) { 
                        	if($purchase_datas['created_date'] < $date){
                        		$action = $action.'<a href="javascript:void(0)" disabled="disabled" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deletePurchase_bill_details/'.$purchase_datas["id"].'" >Delete</a>';
                        	}else{
                        		$action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deletePurchase_bill_details/'.$purchase_datas["id"].'" >Delete</a>';
                        	}
                        }
                        
                        	$supplier_data = getNameById('ledger',$purchase_datas['supplier_name'],'id');
                        	//pre($purchase_datas['supplier_name']);
                        	
                        	if($purchase_datas['party_name'] != '0'){
                        		$ledger_name = getNameById('ledger',$purchase_datas['party_name'],'id');
                        		$ledger_name->name;
                        	}else{
                        		@$ledger_name->name = '';
                        	}
                        	
                        	$billDAte = date("j F , Y", strtotime($purchase_datas['date']));
                        	$edited_by = ($purchase_datas['edited_by']!=0)?(getNameById('user_detail',$purchase_datas['edited_by'],'u_id')->name):'';
                        	
                        	if($purchase_datas['pay_or_not'] =='1'){
                        		$paid_or_not =  'Paid';
                        	}else{
                        		$paid_or_not = 'Not Paid';
                        	}
                        	
                        	/*if($purchase_datas['vehicle_reg_no']==''){
                        		$purchase_datas['vehicle_reg_no'] = 'N/A';
                        	}
                        	if($purchase_datas['ifsc_code']==''){
                        		$purchase_datas['ifsc_code'] = 'N/A';
                        	}
                        	if($purchase_datas['gstin']==''){
                        		$purchase_datas['gstin'] = 'N/A';
                        	}*/
                        $draftImage = '';	
                        if($purchase_datas['save_status'] == 0)
                                    $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                        
                        echo "<tr>
                        	<td data-label='id:'>".$draftImage.$purchase_datas['id']."</td>
                        	<td data-label='Supplier Name:'><a href='javascript:void(0)' id='".$purchase_datas['supplier_name'] ."' data-id='ledger_view' ata-toggle='modal' class='add_account_tabs'>".$supplier_data->name."</a></td>
                        	<td data-label='Party Name:'><a href='javascript:void(0)' id='". $purchase_datas['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$ledger_name->name."</a></td>";
                        	
                        		
                        			$descr_of_bills_detail=json_decode($purchase_datas['descr_of_bills']);	
                        				$countDescrBillLength = count($descr_of_bills_detail);
                        					$i = 1;
                        					foreach($descr_of_bills_detail as $descr_of_bills){		
                        					$materialName=getNameById('material',$descr_of_bills->product_details,'id');
											 $output[] = array(
												   'Bill ID' => $purchase_datas['id'],
												   'Supplier Name' => $supplier_data->name,
												   'Party Name' => $ledger_name->name,
												   'Material Name' =>$materialName->material_name,
												   'Grand Total' => $purchase_datas['grand_total'],
												   'Paid or Not' => $paid_or_not,
												   'Vehicle Registration Number' => $purchase_datas['vehicle_reg_no'],
												   'Created Date' => date("d-m-Y", strtotime($purchase_datas['created_date'])),
												);	
                        					}
                        			
                        	
							echo "<td data-label='Material Detail:'><a style='cursor: pointer;' class='add_purchase_bill_to_tabs' id=".$purchase_datas['id']." data-toggle='modal' data-id='purchase_bill_mat_view'>".$materialName->material_name."</a></td>
                        	<td data-label='Grand Total:'>".money_format('%!i',$purchase_datas['grand_total'])."</td>
                        	<td data-label='Paid:'>".$paid_or_not."</td>
                        	<td data-label='Bill Add Date:'>".$billDAte."</td>
                        	<td data-label='Created By:'><a href='".base_url()."users/edit/".$purchase_datas['created_by']."' target='_blank'>".getNameById('user_detail',$purchase_datas['created_by'],'u_id')->name."</a></td>	
                        	<td data-label='Edited By:' class='hidde'><a href='".base_url()."users/edit/".$purchase_datas['edited_by']."' target='_blank'>".$edited_by."</a></td>	
                        	<td data-label='Action:' class='hidde action'><i class='fa fa-cog'></i><div class='on-hover-action'>".$action."</div></td>	
                        </tr>";
                        
                          }
                           $data3  = $output;
                        export_csv_excel($data3); 
                        
                         }
                        ?>
                  </tbody>
               </table>
            </div>
         </div> 
		 
         <div role="tabpanel" class="tab-pane fade" id="tab_content_auto_entry" aria-labelledby="auto_entery_tab">
		 <div id="print_div_contentAuto">
		 
            <form id="auto_entry_form">	<input type="hidden" value="auto_entry" name="tab">	</form>
            <!---------------- example --------------->
            <table id="" class="table table-striped table-bordered" data-id="account" border="1" cellpadding="3">
               <thead>
                  <tr>
                     <th>Invoice No.
                        <span><a href="<?php echo base_url(); ?>account/purchase_bill?tab=auto_entry&sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>account/purchase_bill?tab=auto_entry&sort=desc" class="down"></a></span>
                     </th>
                     <th>Sale Ledger Name
                        <span><a href="<?php echo base_url(); ?>account/purchase_bill?tab=auto_entry&sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>account/purchase_bill?tab=auto_entry&sort=desc" class="down"></a></span>
                     </th>
                     <th>Order No.
                        <span><a href="<?php echo base_url(); ?>account/purchase_bill?tab=auto_entry&sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>account/purchase_bill?tab=auto_entry&sort=desc" class="down"></a></span>
                     </th>
                     <th>Dispatch doc.No</th>
                     <th>Transport Type</th>
                     <th>Transport Driver No.</th>
                     <th>Invoice Created Date</th>
                     <th>Total Amount</th>
                     <th>Total Tax</th>
                     <th class="hidde">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if(!empty($automatic_purchase_bill)){
                     foreach($automatic_purchase_bill as $p_val){
                     	$purchase_data = json_decode($p_val['descr_of_goods']);
                     	$invoice_created_date = date("j F , Y", strtotime($p_val['created_date']));
                     		if($purchase_data['save_status'] == 0)
                     			$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                     		echo '<tr>
                     			<td>'.$draftImage.$p_val['id'].'</td>	
                     			<td><a href="javascript:void(0)" id="'. $p_val['sale_ledger'] . '" data-id="ledger_view" class="add_account_tabs">'.getNameById('ledger',$p_val['sale_ledger'],'id')->name.'</a></td>	
                     			<td>'.$p_val['buyer_order_no'].'</td>	
                     			<td>'.$p_val['dispatch_document_no'].'</td>	
                     			<td>'.$p_val['transport'].'</td>	
                     			<td>'.$p_val['transport_driver_pno'].'</td>	
                     			<td>'.$invoice_created_date.'</td>	
                     			<td>'.money_format('%!i',$p_val['total_amount']).'</td>	
                     			<td>'.money_format('%!i',$p_val['totaltax_total']).'</td>	
                     			<td class="hidde action"><i class="fa fa-cog"></i><div class="on-hover-action"><a href="javascript:void(0)" id="'.$p_val["id"] . '" data-id="automatic_entery_view" class="view_automatic_entery_invoice btn btn-warning btn-xs" id="'.$p_val["id"].'">View </a></div></td>	
                     		</tr>';	
							
                     	}
                     }
                     if(!empty($purchase_data_form_mrn)){
                     foreach($purchase_data_form_mrn as $frm_mrn){
                     	
                     	$supplier_data = getNameById('ledger',$frm_mrn['supplier_name'],'id');
                     	
                     	$bill_created_date = date("j F , Y", strtotime($frm_mrn['created_date']));
                     	echo '<tr>
                     			<td>'.$frm_mrn['id'].'</td>
                     			<td>'.$supplier_data->name.'</td>
                     			<td></td>
                     			<td></td>	
                     			<td></td>	
                     			<td></td>										
                     			<td>'.$bill_created_date.'</td>
                     			<td>'.money_format('%!i',$frm_mrn['total_amount']).'</td>	
                     			
                     			<td>'.money_format('%!i',$frm_mrn['totaltax_total']).'</td>	
                     			<td class="hidde action"><i class="fa fa-cog"></i><div class="on-hover-action"><a href="javascript:void(0)" id="'.$frm_mrn["id"].'" data-id="purchase_bill" class="add_purchase_bill_to_tabs btn btn-info btn-xs" id="'.$frm_mrn["id"].'"> Edit </div></a></td>	
                     	
                     	
                     	</tr>';
                     	//pre($frm_mrn);
                     $output[] = array( 'Invoice No' =>$frm_mrn['id'],
					 'supplier_ledger_name'=>$supplier_data->name,
					 'order_no'=>$p_val['buyer_order_no'],
					 'dispatch_document_no'=>$p_val['dispatch_document_no'],
					 'transport_type'=>$p_val['transport'],
					 'transport_driver_pno'=>$p_val['transport_driver_pno'],
					 'Invoice Created Date'=>$bill_created_date,
					 'Total Amount'=>money_format('%!i',$frm_mrn['total_amount']),
					 'Total Tax'=>money_format('%!i',$frm_mrn['totaltax_total']));
						}  $data3  = $output;
                     }
                     
					
                      export_csv_excel($data3); 
                     ?>
               </tbody>
            </table>
         </div>
         </div>
      </div>
      <?php echo $this->pagination->create_links(); ?>	
      <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
         <?php echo $result_count; ?></span>
      </div>
      <div id="purchase_bill_modal" class="modal fade in"  role="dialog">
         <div class="modal-dialog modal-lg modal-large">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Purchase Bill Detail</h4>
               </div>
               <div class="modal-body-content"></div>
            </div>
         </div>
      </div>
      <!--Automatic Entery Modal-->
      <div id="auto_entry_invoice" class="modal fade in"  role="dialog">
         <div class="modal-dialog modal-lg modal-large">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Auto Entry Invoice</h4>
               </div>
               <div class="modal-body-content"></div>
            </div>
         </div>
      </div>
      <!--Automatic Entery Modal-->
   </div>
</div>
<?php 
   $this->load->view('common_modal'); 
   ?>