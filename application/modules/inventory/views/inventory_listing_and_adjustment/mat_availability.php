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
                <!-- <div class="btn-group">
                    <button type="button" class="btn btn-success inventory_tabs addBtn" data-toggle="modal" id="add" data-id="reservedmaterial"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>
                </div> -->
            </div>
        </div>
        <p class="text-muted font-13 m-b-30"></p>
        <div id="print_div_content">
            <table class="table table-striped maintable" id="mytable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Customer Type</th>
                        <th>Material Type</th>
                        <th>Material Name</th>
                        <th>Total Quantity</th>
                        <th>Reserved Quantity</th>
                        <th>Available Quantity</th>
                        <th>Created by</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                                <?php 
                                    if(!empty($reserved_material)){
                                        foreach($reserved_material as $reservedmaterial){       
                                            $rty1 = getNameById('account',$reservedmaterial['customer_id'],'id');
                                            $type = !empty($rty1->type) ? $rty1->type:'';
                                            $custmr = getSingleAndWhere('type_of_customer','types_of_customer',['id' => $type ]) ;
                                            //$custmr = !empty($rty1)?$rty1->type:'';
                                            $rty = getNameById('user_detail',$reservedmaterial['created_by'],'u_id');
                                            $usernme = !empty($rty)?$rty->name:'';
                                            $matype = getNameById('material_type',$reservedmaterial['material_type'],'id');
                                            $mat_type = !empty($matype)?$matype->name:'';
                                            $manme = getNameById('material',$reservedmaterial['mayerial_id'],'id');
                                            $mat_nme = !empty($manme)?$manme->material_name:'';

                                            $yu = getNameById_mat('mat_locations',$reservedmaterial['mayerial_id'],'material_name_id');
                                            $sum = 0;
                                             if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                             else{ echo "";}
                                             $blnc = $sum - $reservedmaterial['quantity'];
                                ?>
                    <tr>
                        <td>
                            <?php echo $reservedmaterial['id'];?>
                        </td>
                        <td>
                            <?php echo $custmr; ?>
                        </td>
                        <td>
                            <?php echo $mat_type; ?>
                        </td>
                        <td>
                            <?php  echo $mat_nme; ?>
                        </td>
                        <td>
                            <?php  echo $sum; ?>
                        </td>
                        <td>
                            <?php echo $reservedmaterial['quantity']; ?>
                        </td>
                        <td>
                            <?php echo $blnc; ?>
                        </td>
                        <td>
                            <?php echo $usernme;?>
                        </td>
                        <td>
                            <?php echo $reservedmaterial['created_date'];?>
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