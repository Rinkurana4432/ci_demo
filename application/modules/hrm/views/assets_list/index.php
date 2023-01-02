
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
   


<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/assets_list">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Name,Brand,Model,Code" name="search" id="search" data-ctrl="hrm/assets_list?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?> " value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
		 <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/assets_list?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?> '" value="Reset"></a>
      </div>
   </div>
</form>	
</div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="col-md-12  export_div">
      <div class="col-md-4 col-sm-12 datePick-right"><?php if($can_add) {
         echo '<button type="button" class="btn btn-success hrmTab addBtn" data-toggle="modal" id="add" data-id="addAssetsList"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add Assets List</button>';
         } ?></div>
   </div>
   <div class="container">
     <input type="hidden" name="tab" id="current_tab" value=""/>
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
         <li class="active" >
            <a onclick="submit_available_assets();" href="#available" id="available_assets1" role="tab" data-toggle="tab" aria-expanded="true" >
            <i class="fa fa-list"></i> Available Assets
            </a>
         </li>
         <li><a href="#notavailable" role="tab" data-toggle="tab" aria-expanded="false" id="notavailable_assets1" onclick="submit_notavailable_assets();">
            <i class="fa fa-list"></i> Not Available Assets
            </a>
         </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
	   <div class="tab-pane fade active in" id="available">
		 <form id="available_assets">	<input type="hidden" value="available_assets" name="tab">	</form>
            <h2>Available Assets</h2>
            <table id="available_assets" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th scope="col">ID
		   <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=available_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=available_assets" class="down"></a></span></th>
                     <th scope="col">Type 
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=available_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=available_assets" class="down"></a></span></th>
                     <th scope="col">Name 
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=available_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=available_assets" class="down"></a></span></th>
                     <th scope="col">Brand 
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=available_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=available_assets" class="down"></a></span></th>
                     <th scope="col">Model
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=available_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=available_assets" class="down"></a></span></th>
                     <th scope="col">Code 
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=available_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=available_assets" class="down"></a></span></th>
                     <th scope="col">Specification </th>
                     <th scope="col">Available </th>
                     <th scope="col">Action </th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($available_assets as $value): ?>
                  <?php /* <td><?php echo $mat['inventory_unit']; ?></td> */ 
                  $ww =  getNameById('assets_category', $value['catid'],'id');
                  $catname = !empty($ww)?$ww->cat_name:'';?>
                  <tr>
                     <td data-label='Id:'><?php echo $value['id']; ?></td>
                     <td data-label='Type:'><?php echo $catname; ?></td>
                     <td data-label='Name:'><?php echo $value['ass_name']; ?></td>
                     <td data-label='Brand:'><?php echo $value['ass_brand']; ?></td>
                     <td data-label='Model:'><?php echo $value['ass_model']; ?></td>
                     <td data-label='Code:'><?php echo $value['ass_code']; ?></td>
                     <td data-label='Specification:'><?php echo substr($value['configuration'],0,25).'...'?></td>
                     <td data-label='Available:'><?php echo ($value['in_stock']==1)?'Yes':'No'; ?></td>
                     <td data-label='Action:' class="jsgrid-align-center hidde action">
					    <i class='fa fa-cog'></i>
							<div class='on-hover-action'>
                        <a href="javascript:void(0);" title="Edit" class="hrmTab btn btn-edit  btn-xs" id="<?php echo $value['id']; ?>" data-id="addAssetsList">Edit</a>
                        <!--<a href="AssetsDelet?D=<?php #echo $value->ass_id; ?>" onclick="confirm('Are you Sure??')" title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>-->
						</div>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
         <div class="tab-pane fade" id="notavailable">
            <h2> Not Available Assets</h2>
			<form id="notavailable_assets">	<input type="hidden" value="notavailable_assets" name="tab">	</form>
            <table id="notavailable_assets" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th scope="col">ID
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=notavailable_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=notavailable_assets" class="down"></a></span></th>
                     <th scope="col">Type 
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=notavailable_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=notavailable_assets" class="down"></a></span></th>
                     <th scope="col">Name 
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=notavailable_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=notavailable_assets" class="down"></a></span></th>
                     <th scope="col">Brand 
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=notavailable_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=notavailable_assets" class="down"></a></span></th>
                     <th scope="col">Model
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=notavailable_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=notavailable_assets" class="down"></a></span></th>
                     <th scope="col">Code 
					 <span><a href="<?php echo base_url(); ?>hrm/assets_list?sort=asc&tab=notavailable_assets" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/assets_list?sort=desc&tab=notavailable_assets" class="down"></a></span></th>
                     <th scope="col">Specification </th>
                     <th scope="col">Available </th>
                     <th scope="col">Action </th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($notavailable_assets as $value): ?>
                  <?php /* <td><?php echo $mat['inventory_unit']; ?></td> */ 
                  $ww =  getNameById('assets_category', $value['catid'],'id');
                  $catname = !empty($ww)?$ww->cat_name:'';?>
                  <tr>
                     <td data-label='Id:'><?php echo $value['id']; ?></td>
                     <td data-label='Type:'><?php echo $catname; ?></td>
                     <td data-label='Name:'><?php echo $value['ass_name']; ?></td>
                     <td data-label='Brand:'><?php echo $value['ass_brand']; ?></td>
                     <td data-label='Model:'><?php echo $value['ass_model']; ?></td>
                     <td data-label='Code:'><?php echo $value['ass_code']; ?></td>
                     <td data-label='Specification:'><?php echo substr($value['configuration'],0,25).'...'?></td>
                     <td data-label='Available:'><?php echo ($value['in_stock']==1)?'Yes':'No'; ?></td>
                     <td data-label='Action:' class="jsgrid-align-center hidde action">
					 <i class='fa fa-cog'></i>
							<div class='on-hover-action'>
                        <a href="javascript:void(0);" title="Edit" class="hrmTab btn btn-edit  btn-xs" id="<?php echo $value['id']; ?>" data-id="addAssetsList">Edit</a>
                        <!--<a href="AssetsDelet?D=<?php #echo $value->ass_id; ?>" onclick="confirm('Are you Sure??')" title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>-->
						<div>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
		
         </div>
		 	<?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
      </div>
   </div>
</div>
<div id="printThis">
   <div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Assets List</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<?php #$this->load->view('backend/footer'); ?>