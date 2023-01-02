<style>
div.DTS div.dataTables_scrollBody {
     background: unset!important; 
}

</style>
<div class="selection">
<input type="number" class="update_percentage">
<button id="update_percentage" type="button" class="btn edit-end-btn">Update</button>
</div>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveSalePriceUpdation" enctype="multipart/form-data" novalidate="novalidate">
<div class="x_content my-table">
<!--Tabletab-start--> 
<span class="mesg">
<?php 
if($this->session->flashdata('message') != ''){
?>                        
<div class="alert alert-info col-md-12">                            
<?php 
      echo $this->session->flashdata('message'); ?> 
</div>
<?php } ?>
</span>
<div role="tabpanel" data-example-id="togglable-tabs">
<div id="myTabContent" class="tab-content">
  <div id="#">
    <table id="sale_price_updatde" class="display" style="width:100%">
    <thead>
           
        <tr>
           <th><input type="checkbox" id="selecctallSaleorder" ></th>
           <th>Material Type</th>
           <th>Material Sub Type</th>
           <th>Product Code</th>
           <th>Product Name</th> 
           <th>Product SKU</th>
           <th>Previous price</th>
           <th>Change Price</th>
        </tr>
    </thead>
    <tbody> 
    <?php
	// pre($materialSale);die();
      if (!empty($materialSale)){ 
      $count=1;
      foreach ($materialSale as $materialSaleValue) {
      $material_type = getNameById('material_type', $materialSaleValue['material_type_id'], 'id');
      //pre();
    ?>        
      <tr class="rowtr" id=index_<?php echo $count; ?>> 
        <th><input type="checkbox" class="checkboxSaleOrder"  value=""  ></th>
         <td><?php echo $material_type->name; ?></td>
         <td><?php echo $materialSaleValue['sub_type']; ?></td>
         <td><?php echo $materialSaleValue['material_code']; ?></td>
         <td><?php echo $materialSaleValue['material_name']; ?></td>
         <td><?php echo $materialSaleValue['mat_sku']; ?></td>
         <td class="previous_price"><?php echo $materialSaleValue['sales_price']; ?></td>
         <td class="change_price">
		 <input type="text" name="change_price[<?php echo $materialSaleValue['id']; ?>]" class="change_prz" value="<?php echo $materialSaleValue['sales_price']; ?>"></td>
		 
		 
      </tr>
   <?php $count++; } } ?>
      </tbody>  
</table>
 </div>
<div class="row"> 
<br>
<div class="form-group">
  <div class="col-md-12 ">
     <center>
         <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
         <button id="send" type="submit" class="btn edit-end-btn" >Submit</button>
     </center>
  </div>
</div>
</form>
</div>

</div>
<!--Tabletab-End --> 
</div>
</div>


