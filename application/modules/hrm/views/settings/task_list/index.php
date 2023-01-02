
<?php
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
   <!-- </?php if($this->session->flashdata('message') != ''){ ?>
        <div class="alert alert-info col-md-12">
         </?php echo $this->session->flashdata('message');?>
        </div>
    </?php }?>-->
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Add Storage</a> </li>
                        <li role="presentation"><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Product Types</a> </li>
                        <li role="presentation"><a href="#tab_content3" role="tab" id="profile-tab1" data-toggle="tab" aria-expanded="false">Inventory Reports</a> </li>
                        <li role="presentation"><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Lot Management</a> </li>
                        <li role="presentation"><a href="#tab_content5" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Location Setting</a> </li>
                        <li role="presentation"><a href="#tab_content6" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">UOM list</a> </li>
                        <li role="presentation"><a href="#tab_content7" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false">Tag Management</a> </li>
                        <!-- <li role="presentation" class=""><a href="#tab_content7" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false">Tag Management</a> </li> -->
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active " id="tab_content1" aria-labelledby="home-tab">
                            <p class="text-muted font-13 m-b-30"></p>
                            <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveLocationSetting" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
                                <table class="table table-striped maintable" id="mytable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Location</th>
                                            <th>Storage</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     </tbody>
                                </table>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab"></div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab1"></div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab2"></div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab3"></div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab4"></div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content7" aria-labelledby="profile-tab5"></div>
                    </div>
            </div>
			
          
         
        
            <div id="inventory_add_modal" class="modal fade in" class="modal fade in" role="dialog" style="overflow:auto;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> </button>
                            <h4 class="modal-title modalName" id="myModalLabel">Add Storage</h4> </div>
                        <div class="modal-body-content"></div>
                    </div>
                </div>
            </div>
          