	<div class="row">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-form-label" >Suppplier Code</label>
            <div class="col-md-7 rightborder">
                  <p>  <?php if(!empty($supplier)){ echo $supplier->supplier_code; } ?></p>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-form-label" >Supplier Name <span class="required">*</span></label>
            <div class="col-md-7 rightborder">
                    <p><?php if(!empty($supplier)){ echo $supplier->name; } ?></p>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-form-label" >Account Group<span class="required" style="color:red;">*</span></label>
            <div class="col-md-7 rightborder pdd-bottom">
                   <p>STATIC </P>
		</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-form-label" >GSTIN </label>
            <div class="col-md-7 rightborder">
                  <p>STATIC<?php if(!empty($supplier)){ echo $supplier->gstin; } ?></p>
		</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-form-label" >Mailing Name <span style="color:red;">*</span> </label>
            <div class="col-md-7 rightborder">
                  <P>STATIC</P>
		</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-form-label" >Website </label>
            <div class="col-md-7 rightborder">
                <P>  Static</P>
		</div>
    </div>
  
  </div>
  <div class="col-md-6 col-xs-12">
  <div class="row ">
       <label class="col-md-4 col-form-label" >Address</label>
            <div class="col-md-7 rightborder">
                <P>Static</P>
			</div>
    </div>
   <div class="row ">
       <label class="col-md-4 col-form-label " >Country </label>
            <div class="col-md-7 rightborder pdd-bottom">
            <P> <?php 
					if(!empty($supplier)){
						$country = getNameById('country',$supplier->country,'country_id');
						if(!empty($country)){echo $country ->country_name; } else {echo "NULL" ;}
					}
					?></P>
			 </div>
    </div>
	 <div class="row ">
       <label class="col-md-4 col-form-label" >State/Province </label>
            <div class="col-md-7 rightborder  pdd-bottom">
               <P> <?php 
					if(!empty($supplier)){
						$state = getNameById('state',$supplier->state,'state_id');
						if(!empty($state)){echo $state ->state_name;} else {echo "NULL";}
					}
					?></P>
			 </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-form-label" >city </label>
            <div class="col-md-7 rightborder pdd-bottom">
               <P> <?php 
					if(!empty($supplier)){
						$city = getNameById('city',$supplier->city,'city_id');
						if(!empty($city)){echo $city ->city_name;} else{echo "NULL";}
					}
					?></P>
			 </div>
    </div>
  </div>
</div>
<!-- Editable table -->
<div class="card">
<div class="row">
    	<div class="col-md-12">
            <div class="panel with-nav-tabs ">
                <div class="">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Material List</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Contact Details</a></li>
                            
                        </ul>
                </div>
                <div class="panel-body-tabs ">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1default">
						<div>
      
	  <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
         <th scope="col">Material Name<span class="required">*</span></th>
		<th scope="col">UOM</th>
		
		</tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half">
			STATIC
			</td>
          <td class="pt-3-half noeditable"></td>
			
          </tr>
        </tbody>
      </table>
	  </div>
    </div>
	</div>
    <div class="tab-pane fade" id="tab2default">
	<div class="card-body">
    <div>
      
	  <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
         <th scope="col">Name<span class="required">*</span></th>
      <th scope="col">Email</th>
      <th scope="col">Designation</th>
      <th scope="col">Contact</th>
          </tr>
        </thead>
        <tbody class="test-body">
          <tr>
            <td class="pt-3-half"></td>
            <td class="pt-3-half"></td>
            <td class="pt-3-half"></td>
            <td class="pt-3-half only-numbers"></td>
          </tr>
        </tbody>
      </table>
	  </div>
    </div>
  </div>
						</div>
                        
                    </div>
                </div>
            </div>
        </div>
		</div>
</div>
<!-- Editable table -->
<div class="row payment-bottom">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-form-label" >Bank Name</label>
            <div class="col-md-7 rightborder pdd-bottom">
                <?php  if(!empty($supplier)){
						$bankName = getNameById('bank_name',$supplier->bank_name,'bankid');
						if(!empty($bankName)){echo $bankName ->bank_name;} else{ echo "N/A";}
					}?>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-form-label" >Branch Name</label>
            <div class="col-md-7 rightborder" >
			<p>STATIC
            <?php if(!empty($supplier)){ echo $supplier->branch_name; } ?></p>
		</div>
    </div>
<div class="row ">
       <label class="col-md-4 col-form-label" >Account Number</label>
            <div class="col-md-7 rightborder">
			<p>STATIC
          <?php if(!empty($supplier)){ echo $supplier->account_no; } ?></p>
			</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-form-label" for="rating" >IFSC Code </label>
            <div class="col-md-7 rightborder">
         <p> STATIC<?php if(!empty($supplier)){ echo $supplier->ifsc_code; } ?></p>
            
    </div>

  </div>
    <div class="row ">
       <label class="col-md-4 col-form-label" >Other </label>
            <div class="col-md-7 rightborder">
             <p>STATIC</p>
			 </div>
    </div>

</div>
  <div class="col-md-6 col-xs-12">
   <div class="row ">
       <label class="col-md-4 col-form-label" >Id Proof</label>
            <div class="col-md-7 rightborder fields_wrap">
             <div class="x_content">							
						<div class="row">									
							<div class="col-md-6">									
								<?php if(!empty($idproofs)){										
										foreach($idproofs as $proofs){								
											echo '<div  class="col-md-55"><div class="image view view-first"><img style="width: 100%; display: block;" src="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'" alt="image"/></div></div>';				
										}
									} ?>									
							</div>							
						</div>                          						
					</div>	
			 </div>
    </div>
</div>
  </div><div class="bottom-form">
<p>&nbsp; &nbsp;Frieght:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<span>0.00<i class="fa fa-inr" aria-hidden="true"></i></span></p>
<p>&nbsp; &nbsp;Other Charges:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<span>50.00<i class="fa fa-inr" aria-hidden="true"></i></span></p>
<h3><span>&nbsp; &nbsp;Grand Total:&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</span><span>5000.00<i class="fa fa-inr" aria-hidden="true"></i></span></h3>
</div>
<div class="clearfix"></div>
    <div class="ln_solid"></div>
<center>
	<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>