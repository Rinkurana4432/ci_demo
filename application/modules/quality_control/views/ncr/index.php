 
<?php 	if($this->session->flashdata('message') != ''){?>                        	
<div class="alert alert-success col-md-6">                            	
<?php  echo $this->session->flashdata('message');?> </div>                        
<?php }?>	<div class="x_content">
<div role="tabpanel" data-example-id="togglable-tabs">		
<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">				
<li role="presentation" class="active "><a href="#open_complaint" role="tab" data-select="open" data-toggle="tab" id="open_tab" aria-expanded="true">Open</a></li>				
<li role="presentation" class="close_complaint">
<a href="#close_complaint" id="close_tab" role="tab" data-select="close" data-toggle="tab" aria-expanded="false">Close</a></li>			
</ul>
<div id="myTabContent" class="tab-content">
 <div role="tabpanel" class="tab-pane fade active in" id="open_complaint" aria-labelledby="open_tab">
<div class="x_content">
<div class="stik">
 <?php $str = base64_decode('YW5vZGl6ZSQxMjNfQCMhQA==');   str_replace("_@#!@", "", $str);	?>
</div>	
<div class="row">	
<div class="col-md-3 datePick-right col-xs-12 ">
	 <button type="button" class="btn btn-primary qualityTab addBtn" data-toggle="modal" id="add" data-id="AddNcr">Add NCR</button>							
	 </div>
		<div class="col-md-12 col-xs-12 col-sm-12">
		<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
<p class="text-muted font-13 m-b-30"></p>    
<div id="print_div_content">  	<table  id="example" class="table table-striped table-bordered account_index" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
		<thead>		
		<tr>		
				<th>Id</th>
				<th>Customer ID</th>
				<th>Customer Name</th>
				<th>Sale Order</th>
				<th>Complaint Date</th>		
				<th>Created Date</th>	
				<th>Validate</th>					
				<th>Actions</th>			
				</tr>		
				</thead>
		<tbody>
	<?php foreach($ncr as $data1){
			if($data1["approve"] == 0 ){
				$disable = '';
			}elseif($data1["approve"] == 1){
				$disable = 'disabled';
			}elseif($data1["approve"] == 1 || $can_validate == ''){
				$disable = 'disabled';
			}else{
				$disable = '';
		}
		?><tr>
            <td><?php echo $data1['id']; ?></td>
            <td><?php echo $data1['auto_cust_id']; ?></td>
            <td><?php 	$usr_nam = getNameById('account',$data1['cust_id'],'id');
            echo $usr_nam->name;?></td>
            <td><?php if(!empty($data1['saleorder_id'])){
            $sale_nam = getNameById('sale_order',$data1['saleorder_id'],'id');			
            echo @$sale_nam->so_order;}?></td>
            <td><?php echo date('d-m-Y',strtotime($data1['complaint_date'])); ?></td>		     
            <td><?php echo date('d-m-Y',strtotime($data1['created_date']));; ?></td>
            <!--<td class='hidde".<?php $can_validate;?>."?'':'disabled'> -->
            <td class='hidde'>		
	<?php if(($can_validate==1))
	{
		$disable='';
	}else{
		$disable='disabled';
	}
		$validatedByName =getNameById('user_detail',$data1['validated_by'],'u_id');
		$selectApprove = $data1['approve']==1?'checked':'';
		$selectDisapprove = $data1['disapprove']==1?'checked':'';
	if($selectApprove =='checked'){
	echo "Approve:";?>
		<input type='radio' class='validate' data-idd='<?php echo $data1['id'];?>' name='status_<?php echo $data1['id'];?>' value='Approve' <?php echo $selectApprove.$disable;?>> 
		<?php echo "Disapprove:";?>
		<input type='radio' class='disapprove' data-idd='<?php echo $data1['id'];?>' name='status_<?php echo $data1['id'];?>' value='Disapprove' <?php echo $selectDisapprove.$disable;?> disabled>
		<p class='disapprove_reason'><?php echo $data['disapprove_reason'];?></p>
		<p class='validatedBy'>Validated By:<br /><?php  if(isset($validatedByName)){echo $validatedByName->name;}?></p>
	<?php 
	}else{
		echo "Approve:";?>
		<input type='radio' class='validate' data-idd='<?php echo $data1['id'];?>' name='status_<?php echo $data1['id'];?>' value='Approve' <?php echo $selectApprove.$disable;?>> <?php echo "Disapprove:";?>
		<input type='radio' class='disapprove' data-idd='<?php echo $data1['id'];?>' name='status_<?php echo $data1['id'];?>' value='Disapprove' <?php echo $selectDisapprove.$disable;?>>
		<p class='disapprove_reason'><?php echo $data1['disapprove_reason'];?></p>
		<p class='validatedBy'><?php echo "Validated By:";?><?php if(isset($validatedByName)){ echo $validatedByName->name;}?></p>
	<?php } ?>
	</td>
		     <td>
	<button type="button" data-id="AddNcr" data-tooltip="Edit" class="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $data1['id']; ?>">Edit</button>
	<button type="button" data-id="ViewNcr" data-tooltip="View" cLass="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $data1['id']; ?>">View</button>	
    <a href="quality_control/delete_ncr/<?php echo $data1['id']; ?>" class="btn btn-delete btn-xs qualityTab" data-toggle="modal" id="<?php echo $data1['id']; ?>">Delete</a>	</td>
		</tr>
		<?php } ?>
		 </tbody>                               	
		 </table>
	</div>
	</div>		</div>			</div>			</div>	
	<div role="tabpanel" class="tab-pane fade" id="close_complaint" aria-labelledby="close_tab"><div class="x_content"><div class="stik"> <?php $str = base64_decode('YW5vZGl6ZSQxMjNfQCMhQA==');   str_replace("_@#!@", "", $str);	?></div>	<div class="row">		<div class="col-md-12 col-xs-12 col-sm-12"><input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId"><p class="text-muted font-13 m-b-30"></p>    <div id="print_div_content">  <table  id="example" class="table table-striped table-bordered account_index" border="1" cellpadding="3" data-order='[[1,"desc"]]'>		
	<thead>	
	<tr>			
	<th>Id</th>				
	<th>Customer ID</th>			
	<th>Customer Name</th>		
	<th>Sale Order</th>				
	<th>Complaint Date</th>			
	<th>Created Date</th>
	<th>Validate</th>
	<th>Actions</th>			
	</tr>		
	</thead>		
	<tbody>	<?php foreach($close_ncr as $data){
		if($data["approve"] == 0 ){
				$disable = '';
		}elseif($data["approve"] == 1){
								$disable = 'disabled';
	}elseif($data["approve"] == 1 || $can_validate == ''){
								$disable = 'disabled';
							}else{
								$disable = '';
						}
		?>
	<tr>		  
	<td><?php echo $data['id']; ?></td>		   
	<td><?php echo $data['auto_cust_id']; ?></td>		
	<td><?php 	$usr_nam = getNameById('account',$data['cust_id'],'id');			   
				echo $usr_nam->name;?></td>	
	<td><?php 	$sale_nam = getNameById('sale_order',$data['saleorder_id'],'id');			   echo $sale_nam->so_order;?></td>	
	<td><?php echo date('d-m-Y',strtotime($data['complaint_date'])); ?></td>	
	<td><?php echo date('d-m-Y',strtotime($data['created_date']));; ?></td>	
    			<td class='hidde'>
		
	<?php if(($can_validate==1))
	{
		$disable='';
	}else{
		$disable='disabled';
	}
	
	 $validatedByName =getNameById('user_detail',$data['validated_by'],'u_id');
	$selectApprove = $data['approve']==1?'checked':'';
	$selectDisapprove = $data['disapprove']==1?'checked':'';
	if($selectApprove =='checked'){
	echo "Approve:";?>
		<input type='radio' class='validate' data-idd='<?php echo $data['id'];?>' name='status_<?php echo $data['id'];?>' value='Approve'/<?php echo $selectApprove.$disable;?>> 
		<?php echo "Disapprove:";?>
		<input type='radio' class='disapprove' data-idd='<?php echo $data['id'];?>' name='status_<?php echo $data['id'];?>' value='Disapprove'/<?php echo $selectDisapprove.$disable;?> disabled>
		<p class='disapprove_reason'><?php echo $data['disapprove_reason'];?></p>
		<p class='validatedBy'>Validated By:<?php  if(isset($validatedByName)){echo $validatedByName->name; }?></p>
	<?php 
	}else{
		echo "Approve:";?>
		<input type='radio' class='validate' data-idd='<?php echo $data['id'];?>' name='status_<?php echo $data['id'];?>' value='Approve'/<?php echo $selectApprove.$disable;?>> <?php echo "Disapprove:";?>
		<input type='radio' class='disapprove' data-idd='<?php echo $data['id'];?>' name='status_<?php echo $data['id'];?>' value='Disapprove'/<?php echo $selectDisapprove.$disable;?>>
		<p class='disapprove_reason'><?php echo $data['disapprove_reason'];?></p>
		<p class='validatedBy'><?php echo "Validated By:";?><?php if(isset($validatedByName)){echo $validatedByName->name;}?></p>
	<?php } ?>
	</td>
	<td>	
	<button type="button" data-id="ViewNcr" data-tooltip="View" class="btn btn-edit btn-xs qualityTab" data-toggle="modal" id="<?php echo $data['id']; ?>">View Close Complaint</button>					</td>		
	</tr>	
	<?php } ?>		
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
<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Reason</h4>
				</div>
				<div class="modal-body">
					<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/disApprove_ncr" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
					<input type="hidden" name="id" value="" id="id">
					<input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
					<input type="hidden" id="disapprove" name="disapprove" value="1">
					<input type="hidden" id="disapprove" name="approve" value="0">
					<div class="item form-group">													
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">														
							<textarea id="disapprove_reason" required="required" rows="6" name="disapprove_reason" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>													
							</div>												
						</div>							
						<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						  <input type="submit" class="btn btn edit-end-btn " value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<div id="quality_modal" class="modal fade in"  role="dialog" >	<div class="modal-dialog modal-lg modal-large">		<div class="modal-content" style="display:table;">			<div class="modal-header">			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">NCRs Details</h4>		</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
