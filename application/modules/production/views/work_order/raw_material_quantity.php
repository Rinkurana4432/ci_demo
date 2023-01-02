
   <div class="col-md-12 col-sm-12 col-xs-12">
      <table id="datatable-buttons" class="table table-striped table-bordered" data-id="account">
         <thead>
            <tr>
               <th>S.no</th>
               <th>Unit Of Measurement</th>
               <th>Total Quantity</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($raw_material_report)){
                  $sno = 1;
				      foreach ($raw_material_report as $val) {
						   $uomname = getNameById('uom',$val['uom'],'id');
						   echo '<tr><td>'.$sno.'</td><td>'.$uomname->uom_quantity.'</td><td>'.$val['quantity'].'</td></tr>';
						   $sno++;
					   }
				   }
            ?>
         </tbody>
      </table>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <div class="form-group">
            <div class="modal-footer">
               <button type="button" class="btn btn-default workOrderModal" >Close</button>
            </div>
         </div>
      </div>
   </div>
