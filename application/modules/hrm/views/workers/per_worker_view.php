<?php if($this->session->flashdata('message') != ''){?>                        
		<div class="alert alert-success col-md-6">                            
			<?php echo $this->session->flashdata('message');?>
		</div>                        
<?php }
#pre($single_worker_work);
?>
<div class="x_content">
    <div class="row hidde_cls">
      <div class="col-md-12  export_div">
         <div class="col-md-4 col-xs-12 col-sm-6 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span >
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="worker_worked_view">
                        </div>
                  </div>
               </div>
            </fieldset>
            <form action="worker_worked_view" method="post" id="date_range">   
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
               <input type="hidden" value='<?php // if(!empty($_POST['company_unit'])){echo $_POST['company_unit'] ;} ?>' class='company_unit' name='company_unit'/>
            </form>
            <?php  if(!empty($date['start_date'])){ ?>
                       <h4>Showing Results  <?php echo "From :  ".$date['start_date'] ."      To :   ". $date['end_date'] ?> </h4>
                            <?php } ?>
         </div>
         <div class="btn-group"  role="group" aria-label="Basic example">
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
            </div>
         </div>
         <div class="col-md-3 col-xs-12 col-sm-6 datePick-right">
         </div>
      </div>
   </div> 
	<p class="text-muted font-13 m-b-30"></p>  
	<div id="print_div_content">  
  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                   <?php
                      @ $worker_id= $single_worker_work[0]['assign_worker'];
                  $worker_data = getNameById('worker', $worker_id, 'id');  ?>
                  <div><b> Total Work Done By :</b> <?php  if(!empty($worker_data->name)){ echo $worker_data->name;  }   ?>  </div>
               </div>
		
			<hr>
			<input type="hidden" id="visible_row" value=""/>
		<table id="mytable" class="table tblData table-striped table-bordered" border="1" cellpadding="3" style="width:100%;" data-order='[[1,"desc"]]'>
		    <?php  if(!empty($single_worker_work)){  ?>
			<thead>
				<tr>
					<th>Id</th>
					<th>Completion Date </th>
					<th>Completion Time </th>
					<th>Machine Name </th>	
					<th>Acknowledge Date</th>	
					<th>Complete Time</th>	
					<th>Breakdown Causes</th>	
					<th>Corrective Action</th>
					<th>Created Date </th>
				</tr>
			</thead>
			<tbody>
			    <?php
			    $s_no = 1;
			   
			    foreach($single_worker_work as $val){ 
			   
                    $year    =  (date('Y',strtotime($val['created_date'])));
                    $timeAndDate = $val['complete_time']; 
                    $dummy = (explode("-",$timeAndDate));
                    $date_time = (explode(" ",$dummy[0],2));
                    $date_time1 = (explode(" ",$dummy[1],3));
                   
			    ?>
			    <tr>
                    <td><?php  echo $s_no;  ?></td>
                    <td><?php  if(!empty($val['created_date'] != '0000-00-00 00:00:00')){ print_r($year."/".$date_time[0]."-".$year."/".$date_time1[1]);} ?></td>
                    <td><?php   if(!empty($val['created_date'] != '0000-00-00 00:00:00')){  print_r($date_time[1].'-'.$date_time1[2]);  } ?></td>
                    <td><?php  if(!empty($val['machine_name'])){ echo $val['machine_name'];  } ?></td>
                    <td><?php  if(!empty($val['acknowledge'])){ echo $val['acknowledge'];  } ?></td>
                    <td><?php  if(!empty($val['complete_time'])){ echo $val['complete_time'];  } ?>   </td>
                    <td><?php  if(!empty($val['breakdown_couses'])){ echo $val['breakdown_couses'];  } ?> </td>
                    <td><?php  if(!empty($val['conective_entry'])){ echo $val['conective_entry'];  } ?> </td>
                    <td><?php  if(!empty($val['created_date'])){ echo $val['created_date'];  } ?> </td>
				</tr>
				<?php  $s_no++;  } ?>
			</tbody>
			<?php  }else{ ?>
				 <div> No Data Found   </div>
				<?php  } ?>   
		</table>
	</div>
</div>
