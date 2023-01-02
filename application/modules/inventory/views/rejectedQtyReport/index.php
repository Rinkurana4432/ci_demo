<div class="x_content">



  
   <div class="x_content">
     <div id="print_div_content">                 
			<table  class="table table-striped table-bordered user_index " data-id="user" id = "datatable-buttons_wrapper">
					   
			<!--<table id="datatable-buttons" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
			<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">-->
				<thead>
					<tr>	
						<th scope="col">S.No.</th>
						<th scope="col">Material Type</th>
						<th scope="col">Material Name</th>
						<th scope="col">Quantity</th>
						<th scope="col">Reason</th>
						<th scope="col">Date</th>
						<th style="width: 50px !important;">Action</th>					
					</tr>
				</thead>
				<!--<tbody id="evaluation_data">-->
				<tbody>
          <?php
		   
          $i=1;
          foreach ($rejectedQtyReport as $key => $rejectedqty) {
			   
          $material_details = getNameById('material', $rejectedqty['material_name_id'],'id');
          $material_type = getNameById('material_type', $rejectedqty['material_type_id'],'id');
		  if($rejectedqty['quantity'] >0){
			 
          ?>
              <tr>
				    <td><?php echo $i; ?></td>
						<td><?php echo $material_type->name; ?></td>
						<td><?php echo $material_details->material_name; ?></td>
						<td><?php echo $rejectedqty['quantity']; ?></td>
						<td><?php echo $rejectedqty['reason']; ?></td>
						<td><?php echo date('d-m-Y', strtotime($rejectedqty['created_date'])); ?></td>
						<td class="hidde action">
						 <i class="fa fa-cog"></i>
                         <div class="on-hover-action">
						     <a type="button" class="btn inventory_tabs" id="<?php echo $rejectedqty['id']; ?>" data-id="converttoinventory" data-toggle="modal">Convert To Inventory</a>
							<a type="button" href="<?php echo base_url();?>inventory/inventory_debit_note/<?php echo $rejectedqty['rejectedMrnID'].'/'.$rejectedqty['material_name_id']?>" class="btn" >Convert Debit Note</a>
							<a type="button" href="<?php echo base_url();?>inventory/inventory_purchasereturnDN/<?php echo $rejectedqty['rejectedMrnID'].'/'.$rejectedqty['material_name_id']?>" class="btn" >Convert to Purchase Return</a>
                         </div>						 
						</td>
          </tr>
		  <?php $i++; } }?>
				</tbody>   
			    
			</table>
			    
		
</div>
    </div>
</div>


 
<!-- Modal -->
<div id="inventory_add_modal" class="modal fade in" class="modal fade in" role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> </button>
            <h4 class="modal-title modalName" id="myModalLabel">Convert To Inventory</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
  
   <div class="modal fade" id="Convert_To_Datanote" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Convert To Datanote</h4>
        </div>
        <div class="modal-body">
          <div class="col-md-12 col-xs-12 col-sm-12 vertical-border">
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Quantity</label>
			<div class="col-md-8 col-sm-6 col-xs-12">
				<input type="text" id="datepicker" name="date" class="form-control col-md-7 col-xs-12" value="27-01-2022">
			</div>
		</div>
	</div>
        </div>
        <div class="modal-footer">
		  <center>
           <button type="reset" class="btn edit-end-btn ">Submit</button>
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>		   
         </center>
        </div>
      </div>
      
    </div>
  </div>
  
  <div class="modal fade" id="convert_to_purchase_Return" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Convert To Purchase Return</h4>
        </div>
        <div class="modal-body">
          <div class="col-md-12 col-xs-12 col-sm-12 vertical-border">
		<div class="item form-group">
			<label class="col-md-3 col-sm-3 col-xs-12" for="mat_name">Quantity</label>
			<div class="col-md-8 col-sm-6 col-xs-12">
				<input type="text" id="datepicker" name="date" class="form-control col-md-7 col-xs-12" value="27-01-2022">
			</div>
		</div>
	</div>
        </div>
        <div class="modal-footer">
		  <center>
           <button type="reset" class="btn edit-end-btn ">Submit</button>
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>		   
         </center>
        </div>
      </div>
      
    </div>
  </div>
		
			