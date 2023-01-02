<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/savecustomertype" enctype="multipart/form-data" id="myform" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($customer_type)) echo $customer_type->id; ?>">
	<input type="hidden" name="before_customer" value="<?php if(!empty($customer_type)) echo $customer_type->type_of_customer; ?>">
	<input type="hidden" name="created_date" value="<?php if(!empty($customer_type)) echo $customer_type->created_date; ?>">


	   
	 
		<hr>
		<div class="bottom-bdr"></div>
		
			<?php if(empty($customer_type)){ ?>
			<div class="item form-group blog-mdl" style="padding-bottom: 15px;">
			<div class="col-md-12 col-sm-12 col-xs-12 processDiv middle-box">
			     
			
				<div class="well " style="overflow:auto; overflow:auto;border-top: 1px solid #c1c1c1 !important;" id="chkIndex_1">				
					
                     <div class="col-md-4 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Types of Customers</label>
					<input type="text" id="customer_type" name="type_of_customer" required="required" class="form-control col-md-12 col-xs-12" placeholder="Customer Type" value="<?php if(!empty($customer_type)) echo $customer_type->type_of_customer; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>
                   <div class="col-md-4 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Full Load</label>
					<input onKeyPress="return check(event,value)" type="text" id="full_load" name="full_load" required="required" class="chk_percent form-control col-md-12 col-xs-12" placeholder="Percentage" value="<?php if(!empty($customer_type)) echo $customer_type->full_load; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>
                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Part Load</label>
					<input onKeyPress="return check(event,value)" type="text" id="part_load" name="part_load" required="required" class="chk_percent form-control col-md-12 col-xs-12" placeholder="Percentage" value="<?php if(!empty($customer_type)) echo $customer_type->part_load; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>					
						<div class="col-md-12 col-sm-12 btn-row"><div class="input-group-append">
							<!--button class="btn edit-end-btn addMoreProcess" type="button">Add</button-->
						</div>
					</div>
					
				</div>
			</div>
			<?php }else{ ?>
				<div class="col-md-12 col-sm-12 col-xs-12 processDiv middle-box">
                    <div class="well " style="overflow:auto; overflow:auto;border-top: 1px solid #c1c1c1 !important;" >				
					
                   <div class="col-md-4 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Types of Customers</label>

					 <!--  <input type="hidden"  name="cust_typ" value="<?php //if(!empty($customer_type)) echo $customer_type->type_of_customer; ?>"> -->



					<input type="text" id="customer_type" name="type_of_customer" required="required" class="form-control col-md-12 col-xs-12" placeholder="Customer Type" value="<?php if(!empty($customer_type)) echo $customer_type->type_of_customer; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>
					<div class="col-md-4 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Full Load</label>
					<input onKeyPress="return check(event,value)" type="text" id="full_load" name="full_load" required="required" class="form-control col-md-12 col-xs-12 chk_percent" placeholder="Percentage" value="<?php if(!empty($customer_type)) echo $customer_type->full_load; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>
                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Part Load</label>
					<input onKeyPress="return check(event,value)" type="text" id="part_load" name="part_load" required="required" class="form-control col-md-12 col-xs-12 chk_percent" placeholder="Percentage" value="<?php if(!empty($customer_type)) echo $customer_type->part_load; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>
                 </div>					 
			</div>
			<?php }			?>
			</div>
			
<hr>




				<div class="form-group">
					<div class="col-md-12 ">
					  <center>
						<button type="reset" class="btn btn-default">Reset</button>
						<button id="send" type="submit" class="btn btn-warning">Submit</button>
						<a class="btn btn-danger" data-dismiss="modal">Cancel</a>
						</center>
					</div>
				</div>
</form>
<script>
var point=false;
var count=0;
function check(e,value){
if(count==3)return false;
var unicode=e.charCode? e.charCode : e.keyCode;

if( unicode == 46 && point==true)
   return false;
if( unicode == 46 && point==false)
{
	point=true;
}
if (unicode!=8)if((unicode<48||unicode>57)&&unicode!=46)return false;
if(point==true)
count++;
}
$(document).on('keyup', '.chk_percent', function(){
if ($(this).val() > 100){
alert("No numbers above 100");
$(this).val('0');
}
});
</script>