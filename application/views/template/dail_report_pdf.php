
<div class="x_content">
<div class="stik">	</div>
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">
	<?php $today = date('Y-m-d'); ?>
<h3>As On : <?php echo date('d-m-Y', strtotime($today . " - 1 day"));?></h3>	
<h3 style="text-align: center;">Daily Inventory Stock Report</h3>
            <!---------- datatable-buttons ------------->
<table id="" class="table table-striped table-bordered account_index" data-id="account">
				<thead>
					<tr>
						<th><h4>Id</h4></th>
						<th><h4>Material Name</h4></th>
						<th><h4>Opening Stock</h4></th>
						<th><h4>Received</h4></th>
						<th><h4>Issued</h4></th>
						<th><h4>Closing Stock</h4></th>
						<th><h4>UOM</h4></th>
					</tr>
			</tr>
		</thead>
		<tbody>
			<?php
			#pre($dataPdf);
		#	die;
		    if(!empty($dataPdf)){
						foreach($dataPdf as $mattrans){			
						#pre($mattrans);	
				#$moved = "";
					//$statusChecked = "";			
					#$action = '';
					#if($mattrans['through'] == "Moved"){$moved = "(Material Moved from Current to new Location)";} 
					$ww =  getNameByIdso_ir('material', $mattrans['material_id'],'id');
					$matname = !empty($ww)?$ww->material_name:'';	
					#pre($mattrans['material_id']);
									$ww1 =  getNameByIdso_ir('uom', $mattrans['uom'],'id');
									$uom = !empty($ww1)?$ww1->ugc_code:'-';
					echo  '<tr>
						<td>'.$mattrans['id'].'</td>
						<td>'.$matname.'</td>
						<td>'.$mattrans['opening_blnc'].'</td>
						<td>'.$mattrans['material_in'].'</td>
						<td>'.$mattrans['material_out'].'</td>
						<td>'.$mattrans['closing_blnc'].'</td>
						<td>'.$uom.'</td>	
					</tr>'; ?>
					<?php
				}
		   }
		   ?>
		</tbody>                   
	</table>
    <?php #echo $this->pagination->create_links(); ?>	
	</div>
</div>
