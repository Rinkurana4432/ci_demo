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
            <form action="<?php echo base_url(); ?>inventory/monthlyReport" method="get" id="date_range">
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>
    </div>
</div>
   <div class="stik">
      <div class="col-md-12 export_div">
        
         <div class="btn-group" role="group" aria-label="Basic example">
           <a href="<?php echo base_url(); ?>inventory/monthlyReport" class="Reset-btn btn btn-success">
        Reset
         </a>
             <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
         </div>
         <div class="col-md-4 col-sm-12 datePick-right">
            <form action="<?php echo site_url(); ?>inventory/monthlyReport" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType' />
               <input type="hidden" value='<?php if(isset($_GET['start'])){echo $_GET['start'];} ?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if(isset($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end' />
            </form>
         </div>

      </div>
   </div> 
                                 <!-- <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset" ></a> -->

  
   <div class="x_content">
    <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="bbtn">Print</button>
     <div id="print_div_content">                 
			<table  class="table table-striped table-bordered user_index " data-id="user" id = "datatable-buttons_wrapper">
					   
			<!--<table id="datatable-buttons" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
			<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">-->
				<thead>
					<tr>	
						<th scope="col">S.No.</th>
						<th scope="col">Material Type</th>
						<th scope="col">Opening Balance</th>
						<th scope="col">Material issued</th>
						<th scope="col">Received</td>
						<th scope="col">Closing Balance</th>					
					</tr>
				</thead>
				<!--<tbody id="evaluation_data">-->
				<tbody>
				<?php if(!empty($monthlyReport)){
					$r = 1;
							foreach($monthlyReport as $mr){
								$ww = getNameById('material_type', $mr['material_type_id'], 'id');
								#$ww =  getnamebyid('material_type', $mr['material_id'],'id');
								$matname = !empty($ww)?$ww->name:'';	
								$matin =  !empty($mr["material_in"])?$mr["material_in"]:'0';
								$matout = !empty($mr["material_out"])?$mr["material_out"]:'0';

				   echo '<tr>
							<td data-label="Id:">'.$r++.'</td>
							<td data-label="Material Type:">'.$matname.'</td>
							<td data-label="Opening Balance:">'.$mr["opening_blnc"].'</td>
							<td data-label="Material issued:">'.$matout.'</td>
							<td data-label="Received:">'.$matin.'</td>
							<td data-label="Closing Balance:">'.$mr["closing_blnc"].'</td>
						<tr>';
						$output[] = array(
                        'Material Type' => !empty($matname)?$matname:'',
                        'Opening Balance' => !empty($mr["opening_blnc"])?$mr["opening_blnc"]:'',
                        'Material issued' => !empty($matout)?$matout:'',
                        'Received' => !empty($matin)?$matin:'',
                        'Closing Balance' => !empty($mr["closing_blnc"])?$mr["closing_blnc"]:'',
                      );   
				 }     
                     $data3  = $output;
                	export_csv_excel($data3);
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
   

 

			