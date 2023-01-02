<form method="post" class="form-horizontal" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
	<div id="print_divv">

			<!--job card details-->
			<?php foreach($edit as $edit1){ ?>
	<input type="hidden" name="id" value="<?php echo $edit1->id;?>" />
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name 
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $edit1->report_name; ?>
					</div>
					<label class="col-md-2 col-sm-2 col-xs-12" for="expectation">Manufacturing Date</label>
			         <div class="col-md-3 col-sm-3 col-xs-6">
			            <?php echo date('d-m-Y',strtotime($edit1->created_date)); ?>
			         </div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $edit1->observations; ?>
						</div>
						<label class="col-md-2 col-sm-2 col-xs-12" for="expectation">Inspection date</label>
				         <div class="col-md-3 col-sm-3 col-xs-6">
				            <?php 
				               if( isset($edit1->created_date) ){
				                  echo date('d-m-Y',strtotime($edit1->created_date)); 
				               }
				            ?>
				         </div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $edit1->per_lot_of; ?>
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php foreach($uom as $data){?>
		 <?php if($data->id==$edit1->uom){ echo $data->uom_quantity; }}?>
						</div>
				</div>
					<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						<label>GRN</label>
						</div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel" disabled>
							<?php foreach($material as $material_name){?>
     <?php if($edit1->material_id==$material_name['id']){echo $material_name['material_name'];}?>
	 <?php }?>
							    </div>
				</div>
                <?php if(!empty($edit1->comment)){?>
                	<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">Comments</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $edit1->comment; ?>
						</div>
				</div>
                <?php }?>
</div>
		<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
		<div id="print_div_content">  
	<table id="example" class="table table-striped table-bordered" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
		<thead>
			<tr>			    	

				<th>Sno.</th>
               <th>Parameters</th>
               <th>Instrument</th>
               <th>Uom</th>
               <th>Expectation</th>
               <th>Deviation minimum</th>
               <th>Deviation maximum</th>
               <th>Expectation with minimum Deviation</th>
               <th>Expectation with maximum Deviation</th>
               <th>Result</th>
               <th>Remark</th>
               <?php 
                  if( $edit1->observations ){ 
                        for ($i=1; $i <= $edit1->observations ; $i++) { ?>
                           <th>Obs <?= $i; ?></th>
                  <?php }
                  }  ?>
               <th>Avg</th>
               <th>Pass/Fail</th>

			</tr>
		</thead>
	      

  <tbody id="table_data">
            <?php $i=1;
            foreach($trans as $key => $val){
               ?>
            <tr>
               <td><?php echo $i; ?></td>
               <td>
                  <?= $val->parameter;?>
               </td>
               <td>
                  <?php /*foreach($ins as $value){
                     if($value['id']==$val->instrument){ echo $value['name']; } */
                     echo $val->instrument;
                  //} ?> 
               </td>
               <td>
                  <?php foreach($uom as $umoVal){?>
                    <?php if($umoVal->id==$val->uom1){ echo $umoVal->uom_quantity; } ?></option>
                  <?php } ?>
                  </select>
               </td>
               <td>
                  <?= $val->expectation; ?>
               </td>
               <td>
                  <?php echo $val->deviation_min; ?>
               </td>
               <td>
                  <?php echo $val->deviation_max; ?>
               </td>
               <td>
                  <?php echo $val->exp_min_dev; ?>
               </td>
               <td>
                  <?php echo $val->exp_max_dev; ?>
               </td>
               <td><?php echo $val->result; ?></td>
               <td><?php echo $val->remark; ?></td>
               
               <?php 

                  if( isset($val->coils) ){
                     $obs = json_decode($val->coils);
                  }

                  if( $edit1->observations ){ 
                        for ($j=1; $j <= $edit1->observations ; $j++) { ?>
                           <td>
                              <?php $obsSr = "obs_{$j}"; echo $obs->$obsSr??'';?>
                           </td>
                  <?php }
                  }  ?> 
               <td>
                     <?= $val->avg??'' ?>
                  </td>
               <td>
                  <?php if( isset($val->pf) ){
                        echo ucfirst($val->pf);
                  } ?>
               </td>

            </tr>
            <?php $i++;}?>
         </tbody>
      </table>

		</table>
		<center>
	<?php if($edit1->final_report=='1'){?><strong>Pass</strong><?php }?> 
    <?php if($edit1->final_report=='2'){?><strong>Fail</strong><?php }?> 

        </center>	
	</div>
	<?php }?>
	 <center>
      <div class="modal-footer">
         <button type="button"  class="btn edit-end-btn hidden-print"  ><a class="edit-end-btn" target="_blank" href="<?= base_url('quality_control/qualityReportPdf/').$edit1->id; ?>">PDF</a></button>
         <button type="button"  class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
         <button type="button" class="btn edit-end-btn hidden-print" data-dismiss="modal">Close</button>							  
      </div>
   </center>
</div>
	</form>