<?php
if($this->session->flashdata('message') != ''){
    echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
}
?>
<div class="x_content">
        <div class="col-md-12 col-xs-12 for-mobile">
            <div class="Filter Filter-btn2">
                <form class="form-search" method="post" action="<?= base_url() ?>inventory/reserved_material">
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
                            <a href="<?php echo base_url(); ?>inventory/reserved_material"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                            </span>
                        </div>
                    </div>
                </form>
                <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>inventory/uom_list">
                    <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <button type="button" class="btn btn-success inventory_tabs addBtn" data-toggle="modal" id="add" data-id="reservedmaterial"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>
                </div>
            </div>
        </div>
        <p class="text-muted font-13 m-b-30"></p>
        <div id="print_div_content">
            <table class="table table-striped maintable" id="mytable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Customer Name</th>
                        <th>Material Type</th>
                        <th>Material Name</th>
                        <th>Reserved Quantity</th>
                        <th>Created by</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(!empty($reserved_material)){
                            foreach($reserved_material as $reservedmaterial){       
                                $rty1 = getNameById('types_of_customer',$reservedmaterial['customer_id'],'id');
                                $custmr = !empty($rty1)?$rty1->type_of_customer:'';
                                $rty = getNameById('user_detail',$reservedmaterial['created_by'],'u_id');
                                $usernme = !empty($rty)?$rty->name:'';
                                $matype = getNameById('material_type',$reservedmaterial['material_type'],'id');
                                $mat_type = !empty($matype)?$matype->name:'';
                                $manme = getNameById('material',$reservedmaterial['mayerial_id'],'id');
                                $mat_nme = !empty($manme)?$manme->material_name:'';
                                $statusChecked = $reservedmaterial['active_inactive']==1?'checked':'';
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
                            <?php echo $reservedmaterial['quantity']; ?>
                        </td>
                        <td>
                            <?php echo $usernme;?>
                        </td>
                        <td>
                            <?php echo $reservedmaterial['created_date'];?>
                        </td>
                        <td>
                            <?php                             
                                if($can_edit) { 
                                    echo '<button class="btn btn-info btn-xs inventory_tabs" data-tooltip="Edit" id="'.$reservedmaterial["id"].'" data-toggle="modal" data-id="reservedmaterial"><i class="fa fa-pencil"></i> </button>'; 
                                }
                                // if($can_view) { 
                                    // echo '<a href="javascript:void(0)" id="'.$dailyreportsetting["id"] . '" data-id="location_view" class="inventory_tabs btn btn-warning btn-xs" id="'. $dailyreportsetting["id"].'"><i class="fa fa-eye"></i> View </a>'; 
                                // }
                                echo '<input type="checkbox" class="js-switch change_status_rm" data-switchery="true" style="display: none;" value="'.''.'" 
                            data-value="'.$reservedmaterial['id'].'" '.$statusChecked .'>';
                            ?>
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
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Reserved Material For Customers</h4>
            </div>
            <div class="modal-body-content" ></div>
        </div>
    </div>
</div>
<script>
    var measurementUnits = '';
</script>