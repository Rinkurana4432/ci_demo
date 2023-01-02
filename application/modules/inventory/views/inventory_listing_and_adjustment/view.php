<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
        <div class="col-md-4 datePick-right">
            <input type="hidden" value='leads' id="table" data-msg="Leads" data-path="crm/leads" />
            <input type="hidden" name="rating" id="rating" />
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /* <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value=""  data-table="crm/leads"/>*/?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/leads" />
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>inventory/inventory_adjustmentListing_view?id=<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
               <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
           <a href="<?php echo base_url(); ?>inventory/inventory_adjustmentListing_view?id=<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>" class="Reset-btn btn btn-success">
        Reset
         </a>
             <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false" style="display: none;">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
         </div>
         <div class="col-md-4 col-sm-12 datePick-right">
            <form action="<?php echo base_url(); ?>inventory/inventory_adjustmentListing_view?id=<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType' />
              <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
               <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
            </form>
         </div>
      </div>
   </div> 
                                 <!-- <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset" ></a> -->
   <div class="x_content">
   
    <!-- <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="bbtn">Print</button> -->
     <div id="print_div_content">
   
         
    <!---------- datatable-buttons ------------->
        <table id="example084" class="table table-striped table-bordered account_index" data-id="account">
            <thead>
               <tr>
                  <th scope="col">Date wise</th>
                  <th scope="col">Opening Stock</th>
                  <th scope="col">Inwards</th>
                  <th scope="col">Outwards</th>
                  <th scope="col">Closing Stock</th>
                  <th scope="col">Through</th>
                  <th scope="col">View</th>
               </tr>
         </tr>
      </thead>
      <tbody>
         <?php if(!empty($mat_trans)){
            foreach($mat_trans as $mattrans){      

              /* pre($mattrans);*/
                  
               $moved = "";
               //$statusChecked = "";        
               $action = '';
               if($mattrans['through'] == "Moved"){$moved = "(Material Moved from Current to new Location)";} 
               $ww =  getNameById('material', $mattrans['material_id'],'id');
               $matname = !empty($ww)?$ww->material_name:'';   
               #pre($mattrans['material_id']);
               $ww1 =  getNameById('uom', $mattrans['uom'],'id');
               $uom = !empty($ww1)?$ww1->ugc_code:'-';

               $matin = !empty($mattrans['material_in'])?$mattrans['material_in']:'-';
               $matout = !empty($mattrans['material_out'])?$mattrans['material_out']:'-';

               $ww2 =  getNameById('user_detail', $mattrans['created_by'],'u_id');
               $uname = !empty($ww2)?$ww2->name:'';

               $dt =  date("d-M-Y", strtotime($mattrans['created_date'])); 
               #$dt =  date("j F , Y", strtotime($mattrans['created_date'])); 

               echo "<tr>
                     <td data-label='Created Date:'>".$dt."</td>  
                     <td data-label='Opening Stock:'>".$mattrans['opening_blnc']."</td>
                     <td data-label='Material in:'>".$matin."</td>
                     <td data-label='Material out:'>".$matout."</td> 
                     <td data-label='Closing Stock:'>".$mattrans['closing_blnc']."</td>
                     <td data-label='Closing Stock:'>".$mattrans['through']."</td>
                     <td data-label='Created Date:'>".'<a target="_BLANK"href="'.base_url().'inventory/inventory_adjustmentListing_view_bydate?date='.$mattrans['created_date'].'&mat_id='.$mattrans['material_id'].'" class="
                                                  btn btn-delete btn-xs" data-tooltip="View" data-href="" ><i class="fa fa-eye"></i> View </a>'."</td>   
                  </tr>";
            }
         } ?>
      </tbody>                   
   </table>
    </div>
    </div>
</div>
<div id="printThis">
<div id="crm_add_modal" class="modal fade in"  role="dialog">
  <div class="modal-dialog modal-lg modal-large">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title nxt_cls" id="myModalLabel">Lead</h4>
      </div>
      <div class="modal-body-content"></div>
    </div>
  </div>
</div>         
   