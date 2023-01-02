<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id;
?>

	<div class="col-md-12">
	    <div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
            <div class="item form-group">
                <label class="col-md-3 col-sm-3 col-xs-12" for="item_code">Item Code</label>
                <div class="col-md-6 col-sm-6 col-xs-12">                 
                <?php echo !empty($variants->item_code) ? $variants->item_code:''; ?>
                </div>
            </div>

	        <div class="item form-group">
                <label class="col-md-3 col-sm-3 col-xs-12" for="name">Material name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden" name="id" value="<?php echo !empty($variants->id) ? $variants->id:''; ?>">    
                <?php echo !empty($variants->temp_material_name) ? $variants->temp_material_name:''; ?>
                </div>
            </div>
            
            <?php
            $material_data = !empty($variants->temp_material_data) ? json_decode($variants->temp_material_data):'';
            ?>
            
		    <div class="item form-group">
                <label class="col-md-3 col-sm-3 col-xs-12" for="type">Material Type</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?php
                        if(!empty($material_data->material_type_id)){
                           $material_type = getNameById('material_type',$material_data->material_type_id,'id');
                           echo $material_type->name;
                        }
                    ?>
                </div>
            </div>
		   <div class="item form-group">
                <label class="col-md-3 col-sm-3 col-xs-12" for="subtype">Material Sub Type</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php 
                      if(!empty($material_data->sub_type)){
                            echo $material_data->sub_type;
                      }
                    ?>
                </div>
            </div>	
		</div>
		<div class="col-md-6 col-xs-12 col-sm-12 vertical-border">
		     <div class="item form-group">
                <label class="col-md-3 col-sm-3 col-xs-12" for="uom">Unit of Measure</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php
                        if(!empty($material_data->uom_type)){
                           $uom_type = getNameById('uom',$material_data->uom_type,'id');
                           echo $uom_type->uom_quantity;
                        }
                    ?>
                </div>
            </div>
	        <div class="item form-group">
                <label class="col-md-3 col-sm-3 col-xs-12" for="hsncode">HSN Code</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
					<?php 
                      if(!empty($material_data->hsn_code)){
                          $hsn_sac = getNameById('hsn_sac_master',$material_data->hsn_code,'id');
                          echo $hsn_sac->hsn_sac;
                      }
                    ?>
				</div>
            </div>
            <div class="item form-group">
                <label class="col-md-3 col-sm-3 col-xs-12" for="taxrate">Tax Rate</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
					<?php
                    $taxes = taxList();
                    foreach($taxes as $tax){
                        if($material_data->tax == $tax){
                            echo $tax;
                        }
                    }
                   ?>
				</div>
            </div>
		</div>
		
		<div class="col-md-12 col-sm-6 col-xs-12" style="padding-top: 30px;">
		    <div id="multiple_variant_materials">
		        
                <table class="table table-striped table-bordered" id="variant_materials_list">
		            <thead>
		                <tr>
		                    <th>Material Name</th>
		                    <th>Variant code / SKU</th>
		                    <th>Default sales price</th>
		                </tr>
		            </thead>
		            <tbody>
		              <?php 
		                $specification = '';
		                if(!empty($materials))
		                {
		                    foreach($materials as $material){
		                        $specification = $material['specification'];
		                        $array = !empty($material['material_name']) ? explode('_', $material['material_name']):array();
		                ?>  
		                <tr>
		                    <td><?php echo $material['material_name']; ?></td>
			                <td><?php echo $material['mat_sku']; ?></td>
		                    <td><?php echo $material['sales_price']; ?></td>
		                </tr>
		              <?php 
		                    } 
		                }
                        ?> 
		            </tbody>
		        </table>
                
            </div>    
        </div>
		
		<div class="col-md-12 item form-group" style="padding-top: 10px;">
            <label class="col-md-12 col-sm-12 col-xs-12 MuiTypography-root MuiTypography-caption _elevio_underline ctxUnderline" for="code">Specification</label>
            <div class="col-md-12">
				<?php echo $specification; ?>
			</div>
        </div>
        
        <center><button class="btn btn-secondary" onclick="goback();">Back</button></center>
	</div>

<style>
.item.form-group {
    overflow: hidden;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#variant_materials_list').DataTable({
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false
    });  
});

function goback(){
    window.history.back();
}
</script>