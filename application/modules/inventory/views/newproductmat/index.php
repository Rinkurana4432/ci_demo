<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id;
?>
    <div role="tabpanel" class="tab-pane fade active in" id="Material_Active" aria-labelledby="home-tab">
        <div class="export_div">
            <div class="btn-group" role="group" aria-label="Basic example">		     
                <a href="<?php echo base_url() ?>inventory/variantmat" class="btn btn-info btn-lg addBtn"><i class="fa fa-plus-circle btnTitle-icon"></i>Add</a>
            </div>
        </div>
		
		<span class="mesg">
			<?php if(!empty($this->session->flashdata('message'))){ ?>                        
			<div class="alert alert-info col-md-12">                            
			<?php echo $this->session->flashdata('message'); ?> 
			</div>
			<?php } ?>
			<?php if(!empty($this->session->flashdata('error'))){ ?>                        
			<div class="alert alert-danger col-md-12">                            
			<?php echo $this->session->flashdata('error'); ?> 
			</div>
			<?php } ?>
		</span>

        
        <div id="variants_materials_content" style="margin-top: 0px;">
            <table class="table table-striped table-bordered" id="variant_materials_list">
              <thead>
                 <tr>
                    <th>#</th>
                    <th>Material Name</th>
                    <th>Material Type</th>
                    <th>UOM</th>
                    <th>Action</th>
                 </tr>
              </thead>
              <tbody>
                <?php  
                if(!empty($material_variants)){
					$i = 1;
                    foreach($material_variants as $rows){
                        $mv_id = $rows['id'];
                        $material_name = $rows['temp_material_name'];
                        $material_data = !empty($rows['temp_material_data']) ? json_decode($rows['temp_material_data'], true):'';
                        $material_type_id = !empty($material_data['material_type_id']) ? $material_data['material_type_id']:'';
                        $sub_type = !empty($material_data['sub_type']) ? $material_data['sub_type']:'';
                        $uom_type = !empty($material_data['uom_type']) ? $material_data['uom_type']:'';
                        $hsn_code = !empty($material_data['hsn_code']) ? $material_data['hsn_code']:'';
                        $tax = !empty($material_data['tax']) ? $material_data['tax']:'';
                        
                        $materialType = getNameByID('material_type',$material_type_id,'id');
                        $material_type = !empty($materialType) ? $materialType->name:'';
                        $uomType =  getNameById('uom', $uom_type,'id');
                        $uom = !empty($uomType) ? $uomType->ugc_code:'';
                 ?>
                 <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $material_name; ?></td>
                    <td><?php echo $material_type; ?></td>
                    <td><?php echo $uom; ?></td>
                    <td data-label="Action:" class="action">
						<i class="fa fa-cog" aria-hidden="true"></i>
						<div class="on-hover-action">
						  <a href="<?php echo base_url(); ?>inventory/variantmat?id=<?php echo $mv_id; ?>" class="btn btn-edit btn-xs edit_variants">Edit</a>
							<a href="<?php echo base_url(); ?>inventory/variantmat?view=<?php echo $mv_id; ?>" class="btn btn-view btn-xs view_variants">View</a>
							<a data-id="<?php echo $mv_id; ?>" onclick="return deleteVariant(this);" class="btn btn-delete btn-xs">Delete</a>	
						</div>
						
					</td>
                 </tr>
                <?php
						$i++;
                    }
                }
                ?>
              </tbody>
            </table>
        </div>
    </div>
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){          
    $('#variant_materials_list').DataTable();      
});

/* Delete material */
function deleteVariant(t){
    var vid = $(t).attr('data-id');
    if(vid != '' && typeof(vid) != 'undefined'){
        var checkstr = confirm('Are you sure you want to delete this?');
        if(checkstr == true){
            $.ajax({
                type: "POST",
                url: site_url + 'inventory/delete_variant',
                data: {id:vid},
                success: function(data){
                    //console.log(data);
                    if(data == 1){
                        $(t).parents('tr').remove();
                    }
                },
                error: function() {
                    alert('something went wrong');
                }
            }); 
        }else{
            return false;
        }
    }else{
        alert('Something went wrong');
    }
}
</script>