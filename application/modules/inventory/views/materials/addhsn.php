<form method="post" class="form-horizontal"  id="HSNForm" novalidate="novalidate">

	<div class="col-md-6 col-xs-12 col-sm-12 vertical-border ">	
	<center id="mssg333"></center>
		<div class="required item form-group">
			<label class=" col-md-3 col-sm-2 col-xs-4" for="hsn_sac">HSN / SAC<span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<!-- data-validate-length-range="4" -->
				<input id="hsn_name" class="form-control col-md-7 col-xs-12"   value="" name="hsn_sac" type="number"  required="required" onKeyPress="return check(event,value)" onInput="checkLength(8,this)" id="txtF"> 		
			</div>
		</div> 
			
		<div class="required item form-group">
			<label class="col-md-3 col-sm-12 col-xs-12" for="account_id">Short Name</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<input id="hsn_short_name" class="form-control col-md-7 col-xs-12"   value="" name="short_name" type="text"  > 	
			</div>
		</div> 
	</div>
	<div class="col-md-6 col-xs-12 col-sm-12 vertical-border ">	
		
		
		
		
	<div class="item form-group">
		<label class="col-md-3 col-sm-2 col-xs-12" for="name">CESS </label>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<input  class="form-control col-md-7 col-xs-12"  value="" name="cess" type="text"  id="cess"> </div>
	</div>
		
</div>
<hr>
<div class="col-md-12" style="margin-top: 30px;padding:0px;">

<div class="col-md-6 col-xs-12 col-sm-12 vertical-border ">
<div class="item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">Type </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<select class="itemName form-control  select2"  name="type"  width="100%" id="hsnType">
					<option value="">Select And Begin Typing</option>
					<option value="goods"  > Goods </option>
					<option value="service" > Service </option>
				</select> 	
			</div>
	</div>
  <div class="item form-group" >
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">CGST </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="cgst_hsnmaster" class="form-control col-md-7 col-xs-12"  value="" name="cgst" type="text" > </div>
		</div>	
</div>
<div class="col-md-6 col-xs-12 col-sm-12 vertical-border ">
    <div class="item form-group">
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">IGST </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="igst_keyup" class="form-control col-md-7 col-xs-12"  value="" name="igst" type="text" > </div>
		</div>
		
		<div class="item form-group" >
			<label class="col-md-3 col-sm-2 col-xs-12" for="name">SGST </label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<input id="sgst_keyup" class="form-control col-md-7 col-xs-12"  value="" name="sgst" type="text" > </div>
		</div>
</div>
\
</div>
<hr>
  <center>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-3">
		 
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="reset" class="btn btn-default">Reset</button>
			<input type="button" id="add_hsnNumber" class="btn btn-warning" value="Submit"> </div>
			
	</div>
	</center>
</form>