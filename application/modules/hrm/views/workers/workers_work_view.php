 
 <label for="material">Worker Name :</label>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
              
              
               <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                   <?php
                      @ $worker_id= $single_worker_work[0]['assign_worker'];
                  $worker_data = getNameById('worker', $worker_id, 'id');  ?>
                  <div>  <?php  if(!empty($worker_data->name)){ echo $worker_data->name;  }   ?>  </div>
               </div>
            </div>
<?php   foreach($single_worker_work as $val   ){ ?>
   <div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;">
       
      <div class="table-responsive" >
          
         <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
              
               <label for="material">Machine Name :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div>  <?php  if(!empty($val['machine_name'])){ echo $val['machine_name'];  }   ?>  </div>
               </div>
            </div>
           <!-- </?php if(!empty($viewbreakdown->machine_type)){ ?>-->
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Acknowledge Date :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                   <div>  <?php  if(!empty($val['acknowledge'])){ echo $val['acknowledge'];  }   ?>  </div>
               </div>
            </div>
           <!-- </?php } ?>
            </?php if(!empty($viewbreakdown->requested_by)){ ?>-->
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">   Complete Time:</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
               <div>  <?php  if(!empty($val['complete_time'])){ echo $val['complete_time'];  }   ?>  </div>
               </div>
            </div>
         <!--   </?php } ?>-->
            
             
         </div>
         <div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
          <!--  </?php if(!empty($viewbreakdown->breakdown_couses)){ ?>		-->
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Breakdown Causes :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    <div>  <?php  if(!empty($val['breakdown_couses'])){ echo $val['breakdown_couses'];  }   ?>  </div>
               </div>
            </div>
           <!-- </?php } ?>
            </?php if(!empty($viewbreakdown->priority)){ ?>-->
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
               <label for="material">Corrective Action  :</label>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <div>  <?php  if(!empty($val['conective_entry'])){ echo $val['conective_entry'];  }   ?>  </div>
               </div>
            </div>
        
                      
		 	
	 
         </div>
      </div>
   </div>
   
    <?php } ?>
<center>
   <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
</center>