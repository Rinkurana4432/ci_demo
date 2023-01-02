<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
        echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
}
?>
        <div class="col-md-12 col-xs-12 for-mobile">
            <div class="Filter Filter-btn2">
                <form class="form-search" method="post" action="<?= base_url() ?>inventory/uom_list">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                        <i class="ace-icon fa fa-check"></i>
                    </span>
                            <input type="text" class="form-control search-query" placeholder="Enter id,Quantity,Quantity Type" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="inventory/uom_list">
                            <span class="input-group-btn">
                        <button type="submit" class="btn btn-purple btn-sm">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span> Search
                            </button>
                            <a href="<?php echo base_url(); ?>inventory/uom_list"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                            </span>
                        </div>
                    </div>
                </form>
                <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>inventory/uom_list">
                    <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
                </form>
            </div>
        </div>
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
                        <th>Quantity (In Hand)</th>
                        <th>UOM</th>
                        
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