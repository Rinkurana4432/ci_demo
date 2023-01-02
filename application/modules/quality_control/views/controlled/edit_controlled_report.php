
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/update_controlled_report" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
<div role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#controlled_report" id="controlled_tab" role="tab" data-toggle="tab" aria-expanded="true">Report</a></li>
				<li role="presentation" class="inspection "><a href="#product" role="tab" data-toggle="tab" id="inspection_tab" aria-expanded="false">Product</a></li>
			</ul>
<div id="myTabContent" class="tab-content">
  <div role="tabpanel" class="tab-pane fade active in" id="controlled_report" aria-labelledby="controlled_tab">
			<!--job card details-->
			<?php foreach($edit as $edit1){ ?>
	<input type="hidden" name="id" value="<?php echo $edit1->id;?>" />
<div class="col-md-12 col-sm-12 col-xs-12">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<input id="para" class="form-control col-md-7 col-xs-12" name="report_name" value="<?php echo $edit1->report_name; ?>" required="required" type="text" >		

					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input id="ins" class="form-control col-md-7 col-xs-12" name="observations"  value="<?php echo $edit1->observations; ?>" type="text" >
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="per_lot_of" value="<?php echo $edit1->per_lot_of; ?>" type="number" >
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<select class="form-control" name="uom">
						<option>Select</option>
						<?php foreach($uom as $data){?>
						<option value="<?php echo $data->id;?>" <?php if($data->id==$edit1->uom){echo 'Selected';}?>><?php echo $data->uom_quantity;?></option><?php }?>
						</select>
						</div>
				</div>
					<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						<label>Controlled</label>
						</div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel"  >
							<select id="sel_con1" class="form-control " name="saleorder" >
							<option>Select</option>
							<option value="grn" <?php if($edit1->saleorder=='grn'){echo 'Selected';} ?>>GRN</option>
							<option value="saleorder" <?php if($edit1->saleorder=='saleorder'){echo 'Selected';} ?>>Sale Order</option>
							</select>
							    </div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel"  >
	   <select id="sel_con2" class="form-control " name="material_id" onchange="get_table_values();get_product_qty();get_material_name()">
       <option value="">Select</option>
                                <?php if($edit1->material_name1!=''&&$edit1->material_id==''|| $edit1->material_id==0){
						$material_name=getNameById('material',$edit1->material_name1,'id');
						$material_name = $material_name->material_name;	?>
        <option value="<?php echo $edit1->material_name1;?>"><?php echo $material_name;?></option>
								<?php }else{?>
								<option value="<?php echo $edit1->material_id?>" Selected><?php $this->Quality_control_model->get_row_value('material','id',$edit1->material_id);?></option>
                                <?php } ?>
							     </select>
							    </div>
							    	
				</div>
					
</div>
						


	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">


<div id="print_div_content">  

	<table id="example" class="table table-striped table-bordered" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
		<thead>
			<tr>
			    	
				<th>Sno.</th>
				<th>Parameters</th>
				<th>Instrument</th>
				<th>Uom</th>
				<th>Expectation</th>
				<th>Deviation minimum</th>
				<th>Deviation maximum</th>
				<th>Expectation with minimum Deviation</th>				
				<th>Expectation with maximum Deviation</th>	
					<th>Result</th>	
						<th>Remark</th>	
							<th>Pass/Fail</th>	
			</tr>
		</thead>
	           <tbody id="table_data">
	               <?php $i=1;foreach($trans as $val){?>
  <tr>
     <td><?php echo $i; ?></td> 
     <td><input type="text" name="parameter[]" style="width:80px" value="<?php echo $val->parameter;?>"readonly/></td>
     <td><input type="text" name="instrument[]" style="width:80px" value="<?php echo $val->instrument; ?>"readonly/></td> 
     <td><input type="number" name="uom1[]" style="width:70px" value="<?php echo $val->uom1; ?>"/></td> 
     <td><input type="number" class="exp" name="exp[]" value="<?php echo $val->expectation; ?>" style="width:70px" step="any" readonly/></td> 
     <td><input type="number" class="min_dev" name="min_dev[]" value="<?php echo $val->deviation_min; ?>" style="width:70px" min="-0.1"step="any"/></td>
     <td><input type="number" class="max_dev" name="max_dev[]" value="<?php echo $val->deviation_max; ?>" style="width:70px" max="0.9" step="any"/></td>
     <td><input type="number" class="exp_min_dev" name="exp_min_dev[]" value="<?php echo $val->exp_min_dev; ?>" style="width:70px" readonly/></td>
      <td><input type="number" class="exp_max_dev" name="exp_max_dev[]" value="<?php echo $val->exp_max_dev; ?>" style="width:70px" readonly/></td>
      <td><input type="number" style="width:70px" value="<?php echo $val->result; ?>" name="result[]"/></td>
      <td><input type="text" style="width:70px" value="<?php echo $val->remark; ?>" name="remark[]"/></td>
      <td><select name="res[]"><option value="pass" <?php if($val->pf=='pass'){echo 'Selected';}?>>Pass</option>
      <option value="fail" <?php if($val->pf=='fail'){echo 'Selected';}?>>Fail</option></select>
     </td>
    </tr> 
				   <?php $i++;}?>
  </tbody>     
		</table>
		<center>
		<label for="pass" class="btn edit-end-btn">
	<input type="radio" name="final_report" id="pass" value="2" <?php if($edit1->final_report=='2'){echo 'checked';}?>/>Pass</label>
	<label for="fail"  class="btn edit-end-btn">
	<input type="radio" name="final_report" id="fail" value="3" <?php if($edit1->final_report=='3'){echo 'checked';}?>/>Fail</label>
        </center>
	</div>
	<center>
	    
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						  <input type="submit" class="btn btn edit-end-btn " value="Submit">
						</div>
	</center>
    </div>
    	<div role="tabpanel" class="tab-pane fade" id="product" aria-labelledby="controlled_tab">
	<div id="print_div_content">  
	<table id="" class="table table-striped table-bordered" border="1" cellpadding="3">
		<thead>
			<tr>
			    <th>Product</th>
			    <th>Total Qty</th>
				<th>Qty Passed</th>
				<th>Qty Rejected</th>
				<th>Rework Qty</th>
			</tr>
		</thead>
	           <tbody>
			   <tr>
			   <td><div id="material_name">
               <?php if($edit1->material_name1!=''&&$edit1->material_id==''|| $edit1->material_id==0){
						$material_name=getNameById('material',$edit1->material_name1,'id');
						$material_name = $material_name->material_name;	 echo $material_name;?>
								<?php }else{?>
		<?php $this->Quality_control_model->get_row_value('material','id',$edit1->material_id);?>
                                <?php } ?></div></td>
             <?php $qty=json_decode($edit1->quantity_info,true);?>
			   <td><input type="text" name="tot_qty" id="tot_qty" value="<?php if($qty!=''){echo $qty['tot_qty'];}?>" readonly="readonly"/></td>
			   <td><input type="text" value="<?php if($qty!=''){echo $qty['qty_pass'];}?>" onblur="chk_qty()" id="qty_pass" name="qty_pass"/></td>
			   <td><input type="text" value="<?php if($qty!=''){echo $qty['qty_reject'];}?>" onblur="chk_qty()" id="qty_reject" name="qty_reject"/></td>
			   <td><input type="text" value="<?php if($qty!=''){echo $qty['qty_rework'];}?>" onblur="chk_qty()" id="qty_rework" name="qty_rework"/></td>
			   </tr>
			   </tbody>
               </table>
	</div>
	</div>
	<?php }?>
	</form>
<script>
 jQuery(document).on('change', 'select#sel_con1', function (e) {
	 $('#tot_qty').val(''); 
	 $('#qty_pass').val(''); 
	 $('#qty_reject').val(''); 
	 $('#qty_rework').val('');
	 $('#material_name').val('');
    e.preventDefault();
	$("select#sel_con2").val(' ');
    var  products= jQuery(this).val();
    //alert(material);
    get_order(products);
});

  function chk_qty()
  {
	  var tot_qty=$('#tot_qty').val(); 
	  var qty_pass=$('#qty_pass').val(); 
	  var qty_reject=$('#qty_reject').val(); 
	  var qty_rework=$('#qty_rework').val();
	  var sum_qty =Number(qty_pass)+Number(qty_reject)+Number(qty_rework);
	  if(tot_qty >= sum_qty)
	  {
	  }else{ 
	 $('#qty_pass').val(''); 
	 $('#qty_reject').val(''); 
	 $('#qty_rework').val('');	  
		  }
  }
  

function get_product_qty()
{
	var material_id=$('#sel_con2').val();
	var material_type=$('#sel_con1').val();
	if(material_type=='grn'){url='<?php echo base_url();?>quality_control/get_grn_product_quantity';}
	if(material_type=='saleorder'){
		url='<?php echo base_url();?>quality_control/get_saleorder_product_order';}
	    $.ajax({
        url:url,
        type: 'post',
        data: {product: material_id},
        success: function (data) {
	     $("#tot_qty").val(data);
		 },
    });
}

function get_material_name()
{
		var material_id=$('#sel_con2').val();
	    $.ajax({
        url: "<?php echo base_url();?>quality_control/get_product_name",
        type: 'post',
        data: {material: material_id},
        success: function (data) {
	     $("#material_name").html(data);
		 },
    });
}

function get_order(products) {
    $.ajax({
        url: "<?php echo base_url();?>quality_control/get_product_order",
        type: 'post',
        data: {product: products},
        dataType:'json',
        success: function (data) {
         // alert(data);
            var options = '';
            options +='<option value="">Select </option>';
            
                $.each(data, function (index, value) {
           
                options += '<option value="' + value.id+ '">' + value.material_name + '</option>';
        
                });
            
            jQuery("select#sel_con2").html(options);
 
        },
    });
}

function get_table_values()
  {
      var material=$('#sel_con2').val();
	  if(material!=''){
   //   alert(material);die();
       $.ajax({
        url: "<?php echo base_url();?>quality_control/get_con_table_values",
        type: 'post',
        data: {material_id: material},
         dataType: 'json',
        success: function (data) {
           var str = '';var i=1;
                $.each(data, function (index, value) 
                {
					var selected_pass='';
					var selected_fail='';
					if(value.pf=='pass'){selected_pass='selected';}
					if(value.pf=='fail'){selected_fail='selected';}
             str +='<tr><td>'+i+'</td> <td><input type="text" name="parameter[]" value="'+value.parameter+'" style="width:80px" readonly/></td><td><input type="text" value="'+value.instrument+'" name="instrument[]"  style="width:80px"readonly/></td><td><input type="number" name="uom1[]" value="'+value.uom1+'" style="width:70px"/></td><td><input type="number" class="exp" value="'+value.expectation+'" name="exp[]" style="width:70px" step="any"  readonly/></td><td><input type="number" class="min_dev" name="min_dev[]" style="width:70px" min="-0.1" value="'+value.deviation_min+'" step="any" readonly/></td><td><input type="number" class="max_dev" value="'+value.deviation_max+'" name="max_dev[]" style="width:70px" max="0.9" step="any" readonly/></td><td><input type="number" value="'+value.exp_min_dev+'" class="exp_min_dev" name="exp_min_dev[]" style="width:70px" readonly/></td><td><input type="number" class="exp_max_dev" value="'+value.exp_max_dev+'" name="exp_max_dev[]" style="width:70px"  readonly/></td><td><input type="number" style="width:70px" name="result[]"/></td><td><input type="text" style="width:70px" name="remark[]"/></td><td><select name="res"><option value="pass" '+selected_pass+'>Pass</option><option value="fail" '+selected_fail+'>Fail</option></select></td></tr>';
               i++; });
            jQuery("#example tbody").html(str);
        },
    });
  }}
</script>

                        