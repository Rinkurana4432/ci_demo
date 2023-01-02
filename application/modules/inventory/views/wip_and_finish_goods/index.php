<?php if($this->session->flashdata('message') != ''){
	?>                        
		<div class="alert alert-info col-md-6">                            
		<?php 
		
		echo $this->session->flashdata('message');?> </div>                        
	<?php }?>
<div class="x_content">
	<button type="buttton" class="btn btn-info inventory_tabs addBtn " id=""  data-toggle="modal" data-id="editMaterialWIP">Work In Process</button>
	<button type="buttton" class="btn btn-info inventory_tabs addBtn " id="" data-toggle="modal" data-id="editMaterialFinishGoods">Received Finish Goods</button>
</div>	

<div id="inventory_add_modal" class="modal fade in"  class="modal fade in"  role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title modalName" id="myModalLabel"></h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>



				