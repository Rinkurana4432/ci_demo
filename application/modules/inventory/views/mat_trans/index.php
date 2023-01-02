<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}
?>

<?PHP /**<div class="row hidde_cls export_div">
<div class="col-md-12">
					<div class="col-md-3 datePick-left">  
					<input type="hidden" value='termscond' id="table" data-msg="Terms & Conditions" data-path="crm/crmterms_condtn"/>
					<input type="hidden" value='termscond' id="favr" data-msg="Terms & Conditions" data-path="crm/crmterms_condtn" favour-sts="1"/>              
				<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<?php /*  <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/termscond"> */?>
				<?php /**		  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/crmterms_condtn">
						</div>
					  </div>
					</div>
				</fieldset>
			</div>	<?php 
				</div>
			</div>**/?>
			
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	        <form class="form-search" method="get" action="<?= base_url() ?>inventory/mat_trans">
	<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter ID,Material Name,Ref ID" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="inventory/mat_trans">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>	
              <a href="<?php echo base_url(); ?>inventory/mat_trans"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
</div>
			</form>	
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>inventory/uom_list">
			<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
	  </div>
</div>
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">	
	
			
            <!---------- datatable-buttons ------------->
<table id="" class="table table-striped table-bordered account_index" data-id="account">
				<thead>
			<tr>
				<th scope="col">Id
							<span><a href="<?php echo base_url(); ?>inventory/mat_trans?sort=asc" class="up"></a>
							<a href="<?php echo base_url(); ?>inventory/mat_trans?sort=desc" class="down"></a></span></th>
				<th scope="col">Material Name<span><a href="<?php echo base_url(); ?>inventory/mat_trans?sort=asc" class="up"></a>
					<a href="<?php echo base_url(); ?>inventory/mat_trans?sort=desc" class="down"></a></span></th>
						<th scope="col">Material <br>(IN)</th>
						<th scope="col">Material (OUT)</th>
						<th scope="col">Opening Stock</th>
						<th scope="col">Closing Stock</th>
						<th scope="col">Location</th>
						
						<th scope="col">UOM</th>
						<th scope="col">Action</th>	
						<th scope="col">Ref ID</th>
						<th scope="col">User Comments</th>
						<th scope="col">Created by</th>
						<th scope="col">Created Date</th>
					</tr>
			</tr>
		</thead>
		<tbody>
		   <?php if(!empty($mat_trans)){
						foreach($mat_trans as $mattrans){		

						// pre($mattrans);	
				$moved = "";
					//$statusChecked = "";			
					$action = '';
					if($mattrans['through'] == "Moved"){$moved = "(Material Moved from Current to new Location)";} 
					$ww =  getNameById('material', $mattrans['material_id'],'id');
					$matname = !empty($ww)?$ww->material_name:'';	
					#pre($mattrans['material_id']);
									$ww1 =  getNameById('uom', $mattrans['uom'],'id');
									$uom = !empty($ww1)?$ww1->ugc_code:'-';

					$matin = !empty($mattrans['material_in'])?$mattrans['material_in']:'-';
					$matout = !empty($mattrans['material_out'])?$mattrans['material_out']:'-';

					$ww2 =  getNameById('user_detail', $mattrans['created_by'],'u_id');
					$uname = !empty($ww2)?$ww2->name:'';

					$dt =  date("j F , Y", strtotime($mattrans['created_date'])); 

					echo "<tr>
						<td data-label='id:'>".$mattrans['id']."</td>
						<td data-label='Material Name:'>".$matname."</td>
						<td data-label='Material in:'>".$matin."</td>
						<td data-label='Material out:'>".$matout."</td>
						<td data-label='Opening Stock:'>".$mattrans['opening_blnc']."</td>
						<td data-label='Closing Stock:'>".$mattrans['closing_blnc']."</td>";
						if($mattrans['current_location'] !=''){
								$loc1 = json_decode($mattrans['current_location']);
								foreach($loc1 as $loc){
									$location = getNameById('company_address',$loc->location,'id');
								
								} 
						}
						if($mattrans['new_location'] !=''){
							$loc1 = json_decode($mattrans['new_location']);
								foreach($loc1 as $loc){
									$location = getNameById('company_address',$loc->location,'id');
								
								} 
						}
						if(@$location->location != ''){
							$locationdata = $location->location;
						}else{
							$locationdata =  '';
						}

					echo "<td data-label='Current Location:'><a href='javascript:void(0)' id='".$mattrans['id']."' data-id='material_Locationview' class='inventory_tabs' id='".$mattrans["id"]."'> ".$locationdata."</a></td>
						
						<td data-label='uom:'>".$uom."</td>
						<td data-label='Action:'>".$mattrans['through']."<br> ".$moved."</td>
						<td data-label='Ref ID:'>".$mattrans['ref_id']."</td>	
						<td data-label='User Comments:'>".$mattrans['comment']."</td>
						<td data-label='Created by:'>".$uname."</td>	
						<td data-label='Created Date:'>".$dt."</td>	
					</tr>";
				}
		   } ?>
		</tbody>                   
	</table>
    <?php echo $this->pagination->create_links(); ?>
 <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>	
	</div>
</div>
<div id="printView">
	<div id="inventory_add_modal" class="modal fade in" role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Locations</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
</div>

