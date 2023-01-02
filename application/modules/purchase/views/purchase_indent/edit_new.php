<?php 	
	$getcompanyName = getCompanyTableId('company_detail');
	$name = $getcompanyName->name;
	$CompanyName = substr($name , 0,6);
	$last_id = getLastTableId('purchase_indent');
	$rId = $last_id + 1;
	$indentCode = ($indents && !empty($indents))?$indents->indent_code:('Indent_'.rand(1, 1000000).'_'.$CompanyName.'_'.$rId);
?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveIndent" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
	<div class="row">
	<div class="col-md-12 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-form-label" >Purchase Indent No.</label>
            <div class="col-md-7 rightborder">
                    <input id="purchase_indent" class="form-control mrn-control" name="indent_code" placeholder="ABC239894" type="text" value="<?php  echo $indentCode; ?>" readonly>
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
            <div class="col-md-7 rightborder">
                   <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
				<option value="">Select Option</option>
				<?php
				if(!empty($indents)){
					$material_type_id = getNameById('material_type',$indents->material_type_id,'id');
					echo '<option value="'.$indents->material_type_id.'" selected>'.$material_type_id->name.'</option>';
					}
				?>	
			</select>
			<span class="spanLeft control-label"></span>
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
	  <th scope="col"> Delete</th>
          </tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half" contenteditable="false">	<select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
				<option value="">Select Option</option>
				<?php
				if(!empty($indents)){
					$material_type_id = getNameById('material_type',$indents->material_type_id,'id');
					echo '<option value="'.$indents->material_type_id.'" selected>'.$material_type_id->name.'</option>';
					}
				?>	
			</select>
			<span class="spanLeft control-label"></span></td>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
			<td class="pt-3-half only-numbers" contenteditable>
			</td>
            <td class="pt-3-half " contenteditable></td>
            <td class="pt-3-half noeditable" contenteditable></td>
            <td>
              <span class="table-remove">
			  <a href="#!"  class="btn btn-delete btn-lg" >
			  <i class="fa fa-trash"></i></a>
			</span>
            </td>
          </tr>
        </tbody>
      </table>
	  </div>
	  <div class="table_add float-right mb-3 mr-2"><a href="#!" class="text-success">
	   <!---- <i class="fa fa-plus fa-2x" aria-hidden="true"></i>--------->
	   <p class="additem"> Add Item&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
	   <span id='add-row'> Add Charges</span>
	  </a>
	  </div>
	 
	  <div class="box">
	  </div>
    </div>
  </div>
</div>
<!-- Editable table -->
<div class="row payment-bottom">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Preffered Supplier</label>
            <div class="col-md-7 col-xs-12 rightborder pdd-bottom ">
                <select  class="prefferedSupplier form-control mrn-control selectAjaxOption select2" id="preffered_supplier"  name="preffered_supplier" data-id="supplier" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
				<option value="">Select Supplier</option>	
					<?php if(!empty($indents)){
						$supplier_name_id = getNameById('supplier',$indents->preffered_supplier,'id');
						echo '<option value="'.$indents->preffered_supplier.'" selected>'.$supplier_name_id->name.'</option>';
					} ?>	
			</select>
			<input type="hidden" id="preff_supp">
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Inductor</label>
            <div class="col-md-7 col-xs-12 rightborder" >
            <input type="text" id="inductor" name="inductor" class="form-control mrn-control" value="<?php if($_SESSION['loggedInUser']) echo $_SESSION['loggedInUser']->email; ?>" readonly>
		</div>
    </div>
<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Department</label>
            <div class="col-md-7 col-xs-12 rightborder">
            <select class="form-control mrn-control" name="departments">
				<option value="">-- Choose --</option>
				<option value="Information Technology" <?php if(!empty($indents) && $indents->departments == 'Information Technology'){ echo 'selected'; }?>>Information Technology</option>
				<option value="Sales" <?php if(!empty($indents) && $indents->departments == 'Sales'){ echo 'selected'; }?>>Sales </option>
				<option value="Marketing" <?php if(!empty($indents) && $indents->departments == 'Marketing'){ echo 'selected'; }?>>Marketing</option>
				<option value="Digital marketing" <?php if(!empty($indents) && $indents->departments == 'Digital marketing'){ echo 'selected'; }?>>Digital marketeing</option>
				<option value="Accounts" <?php if(!empty($indents) && $indents->departments == 'Accounts'){ echo 'selected'; }?>>Accounts</option>
				<option value="Human Resource" <?php if(!empty($indents) && $indents->departments == 'Human Resource'){ echo 'selected'; }?>>Human Resource</option>
				<option value="Production" <?php if(!empty($indents) && $indents->departments == 'Production'){ echo 'selected'; }?>>Production</option>
				<option value="Exports" <?php if(!empty($indents) && $indents->departments == 'Exports'){ echo 'selected'; }?>>Exports</option>
			</select>
			</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" for="rating" >Required Date </label>
            <div class="col-md-7 col-xs-12 rightborder">
			<div class="">
                <span class="add-on input-group-addon req-date mrn-control" style="width: 7%;padding: 2px 0px;"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
			<input type="text" style="width: 93%;" id="req_date" name="required_date" class="form-control mrn-control" required="required" placeholder="Required date" value="<?php if(!empty($indents)) echo $indents->required_date;?>">
			</div>
			</div>
    </div>

  </div>
  <div class="col-md-6 col-xs-12">
   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Specification </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <textarea  id="specfication" name="specification" class="form-control mrn-control " placeholder="Specification"><?php if(!empty($indents)) echo $indents->specification;?></textarea>
			 </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Others </label>
            <div class="col-md-7 col-xs-12 rightborder">
             <textarea  id="other" name="other"  class="form-control mrn-control" placeholder="other"><?php if(!empty($indents)) echo $indents->other; ?></textarea>
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
                <div class="form-group">
                    <div class="col-md-12 sub-btns">
                        
							
                            
							<a class="btn btn-default " onclick="location.href='<?php echo base_url();?>purchase/suppliers'">Close</a>
							<button type="reset" class="btn edit-end-btn ">Reset</button>
							<?php if((!empty($suppliers) && $suppliers->save_status == 0) || empty($suppliers)){
								echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">';
							} ?>
							<input type="submit" class="btn edit-end-btn " value="submit">
                    </div>
                </div>
</form>

	<!--------------Quick add material code----------------------->
	<div class="modal modal-center fade" id="myModal_Add_matrial_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add Material Details</h4>
					<span id="mssg34"></span>
				</div>
				<form name="insert_party_data" name="ins"  id="insert_Matrial_data_id">
					<div class="modal-body">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Material Name <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="material_name" name="material_name" required="required" class="form-control col-md-7 col-xs-12" value="">
								<span class="spanLeft control-label"></span>
							</div>
						</div> 
						<input type="hidden" name="material_type_id" id="material_type_id"  class="form-control" value="">
						<input type="hidden" name="prefix"  id="prefix">
						<span class="spanLeft control-label"></span>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">HSN Code </label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="hsn_code" name="hsn_code" class="form-control col-md-7 col-xs-12" value="" >
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">UOM</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select name="uom" id="uom_id"  class="form-control col-md-1">
									<option value="">Select</option>
									<?php $uom = getUom();	
									foreach($uom as $unit) { ?>		
										<option value="<?php echo $unit; ?>"><?php echo $unit; ?></option>	
									<?php }	?>
								</select>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Specification</label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<textarea id="specification" name="specification" class="form-control col-md-7 col-xs-12" rows="6" placeholder="Enter specification"></textarea>
								<span class="spanLeft control-label"></span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" id="add_matrial_Data_onthe_spot">
						<button type="button" class="btn btn-default close_sec_model" >Close</button>
						<button id="Add_matrial_details_on_button_click" type="button" class="btn btn-warning">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>
	
	<!--------------- Quick add preffered supplier -------------------->
	<div class="modal left fade" id="myModal_Add_supplier"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add Supplier</h4>
					<span id="mssg"></span>
				</div>
				<form name="insert_supplier_data" name="ins"  id="insert_supplier_data_id">
					<div class="modal-body">
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Supplier Name <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="suppliername" name="name" required="required" class="form-control col-md-7 col-xs-12" value="" placeholder="Supplier Name ">							
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Account Group<span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible acc_group_id"  required name="supp_account_group_id" data-id="account_group" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" ></select>
								<span id="acc_grp_id"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">GSTIN <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<input type="text" id="suppgstin" name="gstin" class="form-control col-md-7 col-xs-12" value=""  required placeholder="GSTIN">
								<span class="spanLeft control-label"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Country <span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" id='cntry' required name="country" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true"  onchange="getState(event,this)"></select>
								<span id="contry"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">State<span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								<select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible state_id" name="state" required  width="100%" tabindex="-1" aria-hidden="true"  onchange="getCity(event,this)"></select>
								<span id="state1"></span>
							</div>
						</div>
						<div class="item form-group col-md-12 col-sm-12 col-xs-12">
							<label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">City<span class="required">*</span></label>
							<div class="col-md-10 col-sm-10 col-xs-8 form-group">
								 <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible city_id" name="city" required width="100%" tabindex="-1" aria-hidden="true"></select>
								<span id="city1"></span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default close_sec_model" >Close</button>
						<button id="add_suplier_btn_id" type="button" class="btn edit-end-btn">Submit</button>
					</div>
				</form>
			</div>
        </div>
    </div>	
	<script>
		var measurementUnits = <?php echo json_encode(getUom()); ?>;		
	</script>
<!-- /page content -->