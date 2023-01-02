<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveWorkdetail" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
	 <input type="hidden" name="id" value="<?php if($work_detail && !empty($work_detail)){ echo $work_detail->id;} ?>">
	 <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
	<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="work_detail">Assigned To</label>
		<div class="col-md-6 col-sm-10 col-xs-8">
			<?php
			// pre($work_detail);
			
			$status = getNameById('user_detail',$work_detail->assigned_to,'id');
			if(!empty($work_detail) && $work_detail){ echo ucfirst($status->name); }?>
		</div>
	</div>
  
	<!--div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class=" col-md-3 col-sm-2 col-xs-4" for="description">Supervisor</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<?php
			// if(!empty($work_detail->superviser) && $work_detail->superviser!=0){
			// $status = getNameById('user_detail',$work_detail->superviser,'suervisorID');
			// if(!empty($status)) echo ucfirst($status->name); }
			?>
		</div>
	</div-->



</div>
<div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
	<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Task Name</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
		<?php if(!empty($work_detail)) echo $work_detail->task_name; ?>
		</div>
	</div>

	<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Description </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
		<?php if(!empty($work_detail)) echo $work_detail->description; ?>
		</div>
	</div>

<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description"> Status</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
		<?php 
		
			$purchase_data_id = getNameById('task_list_status',$work_detail->pipeline_status,'id');
              echo $purchase_data_id->name;
	
	 ?>
		</div>
	</div>

<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Start Date/ Task date </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
	<?php if(!empty($work_detail)) echo date('d-m-Y',strtotime($work_detail->start_date)); ?>
		</div>
	</div>

<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Due Date and time </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
	<?php if(!empty($work_detail)) echo date('d-m-Y',strtotime($work_detail->due_date)); ?>
		</div>
	</div>
 <?php  $item_code_Settings = $this->hrm_model->get_Companydata('company_detail',array('id'=> $this->companyGroupId));
            if($item_code_Settings[0]['npdm_on_off'] == '1'){
            ?>	
<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">NPDM Product </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
			<?php if(!empty($work_detail)){
			$purchase_data_id = getNameById('npdm',$work_detail->npdm,'id');
			echo $purchase_data_id->product_name;
		}?>
		</div>
	</div>
<?php }?>
<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Repeatable </label>
		<div class="col-md-7 col-sm-10 col-xs-8">
		<?php
		 if($work_detail->repeat_task =='1'){
		     echo 'Yes';
		 }
         if($work_detail->repeat_task =='0'){
    		 echo 'No';     
    	}
		?>
		</div>
	</div>
	<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Repeatable Days</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
		<?php
		echo $work_detail->repeatation_days;     
		?>
		</div>
	</div>
		<div class="item form-group col-md-6 col-sm-12 col-xs-12">
		<label class="col-md-3 col-sm-2 col-xs-4" for="description">Task Description</label>
		<div class="col-md-7 col-sm-10 col-xs-8">
		<?php
		echo $work_detail->description;     
		?>
		</div>
	</div>
</div>
	
	<div class="modal-footer">
	<center>
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>						
	 </center>
	</div>
</form>