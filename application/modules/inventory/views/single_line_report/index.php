<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
        echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
}
?>
        <a href="<?php echo base_url(); ?>inventory/single_line_report"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset" style="float:right;"></a>
        <div class="row hidde_cls export_div">
            <div class="col-md-12">
                <div class="btn-group">
				 
                    <!-- <button type="button" class="btn btn-success inventory_tabs addBtn" data-toggle="modal" id="add" data-id="reservedmaterial"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button> -->
                </div>
            </div>
        </div>
        <?php
       # pre($materials);
        ?>
        <p class="text-muted font-13 m-b-30"></p>
        <div id="print_div_content">
            <table class="table table-striped maintable" id="mytable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Materia Code</th>
                        <th>Material Name</th>
                        <th>Material Type</th>
                        <th>Closing Balance</th>
                        <th>UOM</th>    
                        <th>Action</th>     
                    </tr>
                </thead>
                <tbody>
                                <?php 
                                    if(!empty($materials)){
                                        foreach($materials as $material){       

                                            $materialType = getNameByID('material_type',$material['material_type_id'],'id'); 
                                            $ww =  getNameById('uom', $material['uom'],'id');
                                            $uom = !empty($ww)?$ww->ugc_code:'';
                                            $yu = getNameById_mat('mat_locations',$material['id'],'material_name_id');
                                            $sum = 0;
                                             if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                             else{ echo "";}
                                ?>
                        <tr>
                            <td>
                                <?php echo $material['id'];?>
                            </td>
                            <td>
                                <?php echo $material['material_code']; ?>
                            </td>
                            <td>
                                <?php echo $material['material_name']; ?>
                            </td>
                            <td><?php if(!empty($materialType)){echo $materialType->name ;} else {echo "";} ?></td>
                            <td>
                                <?php  echo $sum; ?> 
                            </td>
                            <td>
                                <?php echo $uom; ?>
                            </td>  
                            <td>
                            <?php echo '<a target="_BLANK"href="'.base_url().'inventory/view_loc_report?id='.$material['id'].'" class="
                                                  btn btn-delete btn-xs" data-tooltip="Location Report" data-href="" ><i class="fa fa-eye"></i>Location Report</a>' ?>
                            </td>               
                        </tr>
                    <?php }}?>
                </tbody>
            </table>
            <?php #echo $this->pagination->create_links(); ?>
            <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
                <?php #echo $result_count; ?>
                </span>
            </div>
        </div>
</div>
<div id="inventory_add_modal" class="modal fade in"  role="dialog">
    <div class="modal-dialog modal-lg modal-large">
        <div class="modal-content" style="display:table;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">UOM List</h4>
            </div>
            <div class="modal-body-content" ></div>
        </div>
    </div>
</div>
<script>
    var measurementUnits = '';
</script>