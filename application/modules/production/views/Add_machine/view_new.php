<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddMachine" enctype="multipart/form-data" id="add_machine" novalidate="novalidate">
   <div>
<?php //pre($mrnView); ?>
	<div class="row">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Machine Name</label>
            <div class="col-md-7 col-xs-12 rightborder">
				<p><?php if(!empty($AddMachine)){ echo $AddMachine->machine_name; } ?></p>
                    <!--<P>0002917-IN</P>----->
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Machine Code <span class="required">*</span></label>
            <div class="col-md-7 col-xs-12 rightborder">
				
                    <P><?php if(!empty($AddMachine)){ echo $AddMachine->machine_code; } ?></P>
            </div>
    </div>

  
  </div>
  <div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Company Branch</label>
            <div class="col-md-7 col-xs-12 rightborder">
                   <p><?php if(!empty($AddMachine)){ echo $AddMachine->company_branch; } ?></p>
		</div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Department </label>
            <div class="col-md-7 col-xs-12 rightborder">
                  <p><?php if(!empty($AddMachine)){ echo $AddMachine->department; } ?></p>
		</div>
    </div>
  </div>
</div>
<!--  table -->
<div class="card">
   <ul class="nav nav-tabs">
    <li class="active"><a href="#">Preventive Maintenance</a></li>
 </ul>
  <br>
  <div class="table-responsive">
<table class="table table-bordered ">
    <thead>
       <tr>
         <th scope="col">Machine Parameter</th>
		<th scope="col">Uom</th>
          </tr>
    </thead>
    <tbody>
	 <?php 
		if(!empty($AddMachine) && $AddMachine->machine_parameter !=''){											
		   $machineParameter =  json_decode($AddMachine->machine_parameter);	
			   if(!empty($machineParameter)){									
				   foreach($machineParameter as $machine_Parameter){												
		?>
      <tr>
	 
            <td class="pt-3-half"><?php echo $machine_Parameter->machine_parameter; ?></td>
			<td class="pt-3-half"><?php echo $machine_Parameter->uom;?></td>
        
          </tr>
		  <?php
		}
		} 
		}?>
    </tbody>
  </table>
  </div>
	<div class="box">
	  </div>

</div>

<!--  table -->
<div class="row payment-bottom">
	<div class="col-md-6 col-xs-12">
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Process Name</label>
            <div class="col-md-7 col-xs-12 rightborder ">
			<?php if(!empty($AddMachine)){							
							   $AddMachine->process_name;							
							$processName = getNameById('add_process',$AddMachine->process_name,'id'); }?>
               <p> <?php  if(!empty($processName)){echo $processName->process_name;} else {echo "NULL";}?></p>
            </div>
    </div>
	<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Make & Model</label>
            <div class="col-md-7 col-xs-12 rightborder" >
            <p><?php if(!empty($AddMachine)){ echo $AddMachine->make_model; } ?></p>
		</div>
    </div>
<div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Date Of Purchase</label>
            <div class="col-md-7 col-xs-12 rightborder">
            <p>
				<?php if(!empty($AddMachine)){ echo date("j F , Y", strtotime($AddMachine->year_purchase)); } ?>
			</p>
			</div>
    </div>


  </div>
  <div class="col-md-6 col-xs-12">

   <div class="row ">
       <label class="col-md-4 col-xs-12 col-form-label" >Placement</label>
            <div class="col-md-7 col-xs-12 rightborder">
             <p><?php if(!empty($AddMachine)){ echo $AddMachine->placement; } ?></p>
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
</div>
<div class="clearfix"></div>
  <div class="ln_solid"></div>
<center>
	<button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>



</form>