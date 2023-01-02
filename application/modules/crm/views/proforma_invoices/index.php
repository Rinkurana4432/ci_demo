<div class="x_content">
   <?php if($this->session->flashdata('message') != ''){
      echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      }?>	
   <?php //if(!empty($pis)){ ?>
   
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	    <form class="form-search" method="post" action="<?= base_url() ?>crm/proforma_invoice">
         <div class="col-md-6">
            <div class="input-group">
               <span class="input-group-addon">
               <i class="ace-icon fa fa-check"></i>
               </span>
               <input type="text" class="form-control search-query" placeholder="Enter id,Invoice No,Account Name" name="search" id="search" data-ctrl="crm/proforma_invoice" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-purple btn-sm">
               <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
               Search
               </button>
               <a href="<?php echo base_url(); ?>crm/proforma_invoice">
               <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </span>
            </div>
         </div>
      </form>
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>crm/proforma_invoice">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
	   <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo" aria-expanded="true"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
	  <div id="demo" class="collapse" aria-expanded="true" style="">
	        <div class="col-md-12 datePick-left">
            <input type="hidden" value='proforma_invoice' id="table" data-msg="Proforma Invoice" data-path="crm/proforma_invoice"/>  
            <input type="hidden" value='proforma_invoice' id="favr" data-msg="Proforma Invoice" data-path="crm/proforma_invoice" favour-sts="1"/>       
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /*<input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/proforma_invoice">*/?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/proforma_invoice">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>crm/proforma_invoice" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div> 
	  </div>
	  </div>
   </div>
   <div class="row hidde_cls  export_div">
      <div class="col-md-12">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
		      <?php if($can_add) {
               echo '<button type="button" class="btn btn-success add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="proforma_invoice"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
               } ?>	
            
         </div>
         <div class="col-md-3 col-xs-12 datePick-right">
           
           		
            <form action="<?php echo site_url(); ?>/crm/proforma_invoice" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
               <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
               <input type="hidden" value='<?php if(isset($_GET['favourites']))echo $_GET['favourites'];?>' name='favourites'/>
            </form>
         </div>
      </div>
   </div>
   <?php //} ?>	
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content">
      <!-------------datatable-buttons--------->          
     
      <?php /* <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3"> */ ?>
      <table id="" style="width:100%; margin-top:40px;" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3">
      <thead>
         <tr>
            <th></th>
            <th scope="col">Id
               <span><a href="<?php echo base_url(); ?>crm/proforma_invoice?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>crm/proforma_invoice?sort=desc" class="down"></a></span>
            </th>
            <th scope="col">Proforma Invoice No.
               <span><a href="<?php echo base_url(); ?>crm/proforma_invoice?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>crm/proforma_invoice?sort=desc" class="down"></a></span>
            </th>
            <th scope="col">Buyer  Name
               <span><a href="<?php echo base_url(); ?>crm/proforma_invoice?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>crm/proforma_invoice?sort=desc" class="down"></a></span>
            </th>
            <th scope="col">Contact Name
               <span><a href="<?php echo base_url(); ?>crm/proforma_invoice?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>crm/proforma_invoice?sort=desc" class="down"></a></span>
            </th>
            <!--<th scope="col">Product</th>-->
            <th scope="col">Order Date</th>
            <th scope="col">Estimated Dispatch Date</th>
            <!--<th scope="col">Payment Terms</th>-->
            <th scope="col">Created By</th>
            <th scope="col">Edited Date</th>
            <th scope="col">Created Date</th>
            <th scope="col" class='hidde'>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php if(!empty($pis)){
            foreach($pis as $pi){ 
            
            
            
            
            	$action = '';
            	if($can_edit)				 
            		$action =  '<a href="javascript:void(0)" id="'. $pi["id"] . '" data-id="proforma_invoice"  class="add_crm_tabs btn btn-edit  btn-xs" id="' . $pi["id"] . '">Edit</a>';	
            	#if($can_view)				 
            		$action .=  '<a href="javascript:void(0)" id="'. $pi["id"] . '" data-id="proforma_invoice_view" class="add_crm_tabs btn  btn-view  btn-xs"  id="' . $pi["id"] . '">View</a>';
            	
            	if($can_delete) { 
            						$action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deleteProformaInvoice/'.$pi["id"].'">Delete</a>';
            					}
            	if($pi['save_status'] == 1)
            		if($pi['sale_ordr_converted'] == 0 ){
            			$action = $action.'<a href="javascript:void(0)" id="' . $pi["id"] . '" data-id="convertPiIntoSaleOrderview"  class="add_crm_tabs btn  convert  btn-xs">Convert into Sale Order</a>';					
            		 }
            		 $action = $action.'<a href="javascript:void(0)" id="'. $pi["id"] . '"data-id="AddSimilarPI" data-tooltip="Add Similar Proforma Invoice" class="add_crm_tabs btn  add-machine  btn-xs" style="display: none;"><i class="fa fa-clone" aria-hidden="true"></i></a>';
            	$accountName = ($pi['account_id']!=0)?(getNameById('account',$pi['account_id'],'id')):'';
            	$contactName = ($pi['account_id']!=0)?(getNameById('account',$pi['account_id'],'id')):'';
			
            	$accountName = (!empty($accountName))?$accountName->name:'';						
            	//$contactName = ($pi['contact_id']!=0)?(getNameById('contacts',$pi['contact_id'],'id')):'';
            	//$contactName = ($pi['contact_id']!=0)?(getNameById('contacts',$pi['contact_id'],'id')):'';
            	//$contactName = (!empty($contactName))?($contactName->first_name.' '.$contactName->last_name):'';
            	$draftImage = ($pi['save_status'] == 0)?('<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft"><img src="'.base_url(). 'assets/images/draft.png"   class="img-responsive hidde"></a>'):'';
            	
            	$orderDate  = $pi['order_date']!=''?date("j F , Y", strtotime($pi['order_date'])):'';
            	$dispatchDate  = $pi['dispatch_date']!=''?date("j F , Y", strtotime($pi['dispatch_date'])):'';
				
				
				if($pi['modified_date'] == ''){
						 $modified_date = '00-00-0000';
					 }else{
						 $modified_date = date("j F , Y", strtotime($pi['modified_date']));
						 
					 }
            	
            	
            	//<input name='checkbox[]' class='checkbox1 checkbox[]' data-ai=".$pi['account_id']." type='checkbox'  value=".$pi['id'].">
            	
            	echo "<tr>											   
            						   		<td>";
            						   		if($pi['favourite_sts'] == '1'){
            						   				echo "<input class='star' type='checkbox'  title='Mark Record' value=".$pi['id']."  checked = 'checked'><br/>";
            						   				echo"<input type='hidden' value='proforma_invoice' id='favr' data-msg=''Proforma Invoice Unmarked' data-path='crm/proforma_invoice' favour-sts='0' id-recd=".$pi['id'].">";
            						   		}else{
            										echo "<input class='star' type='checkbox'  title='Mark Record' value=".$pi['id']."><br/>";
            										echo"<input type='hidden' value='proforma_invoice' id='favr' data-msg='Proforma Invoice Marked' data-path='crm/proforma_invoice' favour-sts='1' id-recd =".$pi['id'].">";
            						   		}
            						   		
            						   		echo "</td>
            
            
            			<td data-label='Id:'>". $draftImage . $pi['id']."</td>
            			<td data-label='Proforma Invoice No:'>". $pi['pi_code']."</td>
            			<td data-label='account name:'>".$accountName."</td>
            			<td data-label='contact Name:'>".@$contactName->contact_name."</td>
            			";?>
         <!---- datatable-buttons------>
         
            <?php 
               if($pi['product'] !=''){
               		$products = json_decode($pi['product']);
               
               
               		//pre($pi['product']);
               
               
               		//die;
               
               		foreach($products as $product){
               			$piCreatedBy = ($pi['created_by']!=0)?(getNameById('user_detail',$pi['created_by'],'u_id')):'';
               			$createdByName = (!empty($piCreatedBy))?$piCreatedBy->name:'';
               			
               
               			//pre($product->product);
               
               			$productDetail = getNameById('material',$product->product,'id');
               		
               
               			$materialName = !empty($productDetail)?$productDetail->material_name:'';
               			$ww =  getNameById('uom', $product->uom,'id');
               			$uom = !empty($ww)?$ww->ugc_code:'';
               
               		} 
               	}
               	echo "<td data-label='product:' style='display:none;'><a href='javascript:void(0)' data-id='proforma_invoice_Matview' class='add_crm_tabs' id='".$pi["id"]."'>". $materialName ."</a></td>";
               	echo "</td>
               		<td data-label='order Date:'>".$orderDate."</td>
               		<td data-label='Dispatch Date:'>".$dispatchDate."</td>	
               		<!--<td data-label='Payment Terms:'>".$pi['payment_terms']."</td>-->	
               		<td data-label='Created By:'>".$createdByName."</td>	
               		<td data-label='edited Date:'>".$modified_date."</td>
               		<td data-label='Created Date:'>".date("j F , Y", strtotime($pi['created_date']))."</td>
               		<td data-label='Action:' class='hidde action'> 
					    <i class='fa fa-cog'></i>
				         <div class='on-hover-action'>".$action."
				   </div></td>	
               </tr>";
               $output[] = array(
               'Proforma Invoice' =>$pi['pi_code'],
               'Account Name' => $accountName,
               	'Contact Name' => $contactName,
               'Order Date' =>   date('d-m-Y',strtotime($orderDate)),
               	'Dispatch Date' =>date('d-m-Y',strtotime($dispatchDate)),
               	'Sub Total' =>    $pi['total'],
               	'Total' =>        $pi['grandTotal'],
               	'Payment Terms' =>$pi['payment_terms'],
               	'Created By' =>   $createdByName,
               	'Created Date' => date("d-m-Y", strtotime($pi['created_date'])),
               );	
               }
               $data3  = $output;
               
               export_csv_excel($data3);
               } ?>
            </tbody>                   
         </table>
         <?php echo $this->pagination->create_links(); ?>
   </div>
</div>
<div id="printThis">
<div id="crm_add_modal" class="modal fade in btnPrint"  role="dialog">
<div class="modal-dialog modal-lg modal-large">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
</button>
<h4 class="modal-title chng_lbl nxt_cls addtitle2" id="myModalLabel">Proforma Invoice</h4>
</div>
<div class="modal-body-content"></div>
</div>
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