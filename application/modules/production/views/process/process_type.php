<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
			<?php echo $this->session->flashdata('message');?>
		</div>                        
<?php }?>


<div class="x_content addProcess-2">
  
	<!--datatable-buttons-->
	<p class="text-muted font-13 m-b-30"></p>    
<button class="btn btn-primary productionTab" data-toggle="modal" id="addType" data-id="editProcessType">Add</button>
<a href="<?php echo base_url();?>/production/process/"><button class="btn btn-primary" data-toggle="modal">Process Type</button></a>
 <form class="form-search" method="get" action="<?= base_url() ?>production/process_type" style="float: right;">
         <div class="col-md-6">
            <div class="input-group">
               <span class="input-group-addon">
               <i class="ace-icon fa fa-check"></i>
               </span>
               <input type="text" class="form-control search-query" placeholder="Enter id,Process Type" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="production/process_type">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-purple btn-sm">
               <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
               Search
               </button>
               <a href="<?php echo base_url(); ?>production/process_type">
			   <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </span>
            </div>
         </div>
      </form>
	<table id="" class="table table-striped table-bordered account_index" data-id="account">
		<thead>
			<tr>
				<th>Id<span><a href="<?php echo base_url(); ?>production/process_type?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>production/process_type?sort=desc" class="down"></a></span></th>
				<th>Process Type<span><a href="<?php echo base_url(); ?>production/process_type?sort=asc" class="up"></a>
               <a href="<?php echo base_url(); ?>production/process_type?sort=desc" class="down"></a></span></th>
				<th>Description</th>
				<th>Action</th>
					</tr>
			</tr>
		</thead>
		<tbody>
		   <?php if(!empty($processType)){
						foreach($processType as $process_Type){		
								
					$action = '';
					
						$action = '<button type="button" data-process-id="'.$process_Type["id"].'" id="'.$process_Type["id"].'" data-id="editProcessType" class="btn btn-primary productionTab" data-toggle="modal" data-tooltip="Edit">Edit</button>';
						
						if($process_Type['used_status'] == 1){
							$action = $action.'<a href="javascript:void(0)" class="
							btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" disabled="disabled" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
						}else{
							$action = $action.'<a href="javascript:void(0)" class="delete_listing
							btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
						}

					echo "<tr>
						<td>".$process_Type['id']."</td>
						<td>".$process_Type['process_type']."</td>
						<td>".$process_Type['description']."</td>
						<td>".$action."</td>	
					</tr>";
				}
		   } ?>
		</tbody>                   
	</table>
	 <?php echo $this->pagination->create_links(); ?>	
</div>

   <!--<div class="modal fade editProcessType production_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Add process Type</h4>
                        </div>
                        <div class="modal-body">
							<form method="post" class="form-horizontal" action="<?php ///echo base_url(); ?>production/saveProcessType" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
							<input type="hidden" id="id" name="id" value="">
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
								<label class="control-label col-md-2 col-sm-2 col-xs-4" for="process_type">Process Type : </label>
								<div class="col-md-10 col-sm-10 col-xs-8">
									<input type="text" id="process_type" name="process_type" class="form-control col-md-7 col-xs-12" value="">
								</div>
							</div>
						  
							<div class="item form-group col-md-12 col-sm-12 col-xs-12">
								<label class="control-label col-md-2 col-sm-2 col-xs-4" for="description">Description</label>
								<div class="col-md-10 col-sm-10 col-xs-8">
									<textarea type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" value=""></textarea>
								</div>
							</div>
							
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							  
							  <input type="submit" class="btn btn-warning" value="Submit">
							</div>
							</form>
                        </div>
                       

                      </div>
                    </div>
                  </div>-->
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Process Type</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>