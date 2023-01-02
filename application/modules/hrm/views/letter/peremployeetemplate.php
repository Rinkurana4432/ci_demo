 	
			<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;



 ?>
<div class="stik">	
  


		
</div>

		
		<?php #if(!empty($competitor_details)){ ?>
	<div class="row hidde_cls export_div">

			
				<div class="col-md-12">
						<input type="hidden" value='account' id="table" data-msg="Company" data-path="crm/competitor_details"/>

					<div class="col-md-3 datePick-left">                
				<fieldset>
					<div class="control-group">
					  <div class="controls" style="text-align:left; color:#000; font-size:20px; font-weight:600;">
						<?php $emp_data = getNameById('user_detail',$u_id,'u_id'); if(!empty($emp_data)) echo " View Letters For ".$emp_data->name; ?> 
					  </div>
					</div>
				</fieldset>
			 
			</div>

						<div class="btn-group"  role="group" aria-label="Basic example">
						 
						</div>

				<div class="col-md-3 datePick-right">
						 
              </div>	
					
				</div>
			</div>
 
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">
	<!-------------datatable-buttons--------->          
			
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>crm/competitor_details">
			<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			
	   <table class="table table-hover" cellspacing="0" width="100%">
		<thead>
			<tr>
				 
				 
			 
				<th style="text-align:left">Subject</th>
			 
				<th style="text-align:right">Actions</th>
				  
			</tr>
		</thead>
		<tbody>

				<?php   if(!empty($all_templates)){
					 
                #  pre($all_templates);die;
					 
					foreach($all_templates as $template){    ?>
					    <tr> 
                           <td style="text-align:left"> <?php if(!empty($all_templates)) echo $template['title']; ?> </td> 
                           <td style="text-align:right"> <a  target="_blank" href="<?php echo base_url().'hrm/getpdfId/'.$template['id'].'/'.$u_id;  ?>"> <button style='padding: 3px 8px;' class="btn btn-primary"> Download Pdf</button></a> <a href="<?php echo base_url().'hrm/getEmailpdfId/'.$template['id'].'/'.$u_id;  ?>"> <button style='padding: 3px 8px;' class="btn btn-primary">Send Mail</button></a></td> 
					    </tr> 
						 
						 	<?php  }  
						 	
						 	}  ?>
 
			       
		</tbody>     

	</table>
	  
	</div>
</div>
 