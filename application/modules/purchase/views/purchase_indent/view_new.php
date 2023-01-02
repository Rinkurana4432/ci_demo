<div class="row">
	<div class="col-md-12 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-form-label" >Purchase Indent No.</label>
            <div class="col-md-7 rightborder">
                   <p> STATIC</p>
            </div>
    </div>
  </div>

</div>

<!-- Editable table -->
<div class="card">

   <ul class="nav nav-tabs">
    <li class="active"><a href="#">Material Detail</a></li>
 </ul>
  <br>
  	<div class="row M-type">
       <label class="col-md-4 col-form-label" >Material Type <span class="required">*</span></label>
            <?php if(!empty($materialType)){ 
						$indents->material_type_id;                                    
						$material_type=getNameById('material_type',$indents->material_type_id,'id')->name;                     
						}                       
						?> 
			<div class="col-md-7 rightborder">
                <p> <?php echo $material_type;?> </p> 
            </div>
    </div>
  <div class="card-body">
    <div id="table_edit" class="table-editable">
      
	  <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
         <th scope="col">Material Name<span class="required">*</span></th>
      <th scope="col">Description</th>
      <th scope="col">Quantity</th>
      <th scope="col">UOM</th>
	  <th scope="col">Exp Amount</th>
	  <th scope="col">Purpose</th>
	  <th scope="col">Sub Total</th>

          </tr>
        </thead>
        <tbody class="test-body">
          <tr>
		  <?php 
								if(!empty($indents) && $indents->material_name !='' && $indents->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]'){					
									$materialDetail =  json_decode($indents->material_name); 
									$Total=0;									
									foreach($materialDetail as $material_detail){
									
									$material_id=$material_detail->material_name_id;
									$materialName=getNameById('material',$material_id,'id');
									$Total+=$material_detail->sub_total;	
									 
									
									?>	
            <td class="pt-3-half"><h5><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></h5><br><?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?>	</td>
            <td class="pt-3-half">STATIC</td>
            <td class="pt-3-half only-numbers"><?php echo $material_detail->quantity;?><br /></td>
            <td class="pt-3-half noeditable">STATIC</td>
			<td class="pt-3-half only-numbers"><?php echo number_format($material_detail->expected_amount);?><br />
			</td>
            <td class="pt-3-half "><?php echo $material_detail->purpose;?><br /></td>
            <td class="pt-3-half noeditable"><?php echo number_format($material_detail->sub_total);?></td>
         
								</tr><?php } } ?>
        </tbody>
      </table>
	  </div>
    </div>
  </div>
  <div class="box">
	  </div>
</div>
<!-- Editable table -->
<div class="row payment-bottom">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Preffered Supplier</label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom ">
               <p> <?php if(!empty($suppliername)){                                  
						$indents->preffered_supplier;                                   
						$supplierName=getNameById('supplier',$indents->preffered_supplier,'id');                     
						                     
						?>                      
						<td>
						<?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
						</td> 
						<?php }?></p>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Inductor</label>
            <div class="col-md-7 col-xs-12 rightborder" >
           <p> <?php if(!empty($indents)){ echo $indents->inductor; } ?></p>
		</div>
    </div>
<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Department</label>
            <div class="col-md-7 col-xs-12 rightborder">
            <p><?php if(!empty($indents)){ echo $indents->departments; } ?></p>
			</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" for="rating" >Required Date </label>
            <div class="col-md-7 col-xs-12 rightborder">
			<p><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->required_date)); } ?></p>
			</div>
    </div>

  </div>
  <div class="col-md-6 col-xs-12">
   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Specification </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p><?php if(!empty($indents)){ echo $indents->specification; } ?></p>
			 </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Others </label>
            <div class="col-md-7 col-xs-12 rightborder">
            <p> <?php if(!empty($indents)){ echo $indents->other; } ?></p>
			 </div>
    </div>
</div>
</div>
<div class="bottom-form">
<p>&nbsp; &nbsp;Frieght:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<span>0.00<i class="fa fa-inr" aria-hidden="true"></i></span></p>
<p>&nbsp; &nbsp;Other Charges:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<span>50.00<i class="fa fa-inr" aria-hidden="true"></i></span></p>
<h3><span>&nbsp; &nbsp;Grand Total:&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</span><span>5000.00<i class="fa fa-inr" aria-hidden="true"></i></span></h3>
</div>
<div class="clearfix"></div>
    <div class="ln_solid"></div>
<center>
	<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>