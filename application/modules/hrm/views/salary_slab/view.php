<form method="post" action="saveempsalary" id="assetsform" enctype="multipart/form-data">
     <?php 
   
      if(!empty($salary_val->slab_structure)){
      $salary_details = json_decode($salary_val->slab_structure);
      }
       
   ?>
   
    <input type="hidden" name="id" value="<?php if(!empty($assets_val)){ echo $assets_val->id; }?>">
    <input type="hidden" name="save_status" value="1" class="save_status">  
    <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
    <div class="modal-body">
        <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
         
    <div class="item form-group">
        <label class="col-md-3 col-sm-12 col-xs-12 ">Slab Name</label>
       <div class="col-md-6 col-sm-12 col-xs-12"><?php if(!empty($salary_val)){ echo $salary_val->slabname; }?></div>
    </div> 
	<div class="item form-group">
        <label class="col-md-3 col-sm-12 col-xs-12 ">Slab Start Date</label>
       <div class="col-md-6 col-sm-12 col-xs-12"><?php if(!empty($salary_val)){ echo $salary_val->slab_start_date; }?></div>
    </div> 
    <div class="item form-group">
        <label class="col-md-3 col-sm-12 col-xs-12 ">Slab End Date</label>
       <div class="col-md-6 col-sm-12 col-xs-12"><?php if(!empty($salary_val)){ echo $salary_val->slab_end_date; }?></div>
    </div> 
    <div class="item form-group">
        <label class="col-md-3 col-sm-12 col-xs-12 ">Salary From</label>
       <div class="col-md-6 col-sm-12 col-xs-12"><?php if(!empty($salary_val)){ echo $salary_val->salary_from; }?></div>
    </div> 
    <div class="item form-group">
        <label class="col-md-3 col-sm-12 col-xs-12 ">Salary To</label>
       <div class="col-md-6 col-sm-12 col-xs-12"><?php if(!empty($salary_val)){ echo $salary_val->salary_to; }?></div>
    </div> 
    </div>
	<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
	    
     
    <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">BASIC %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->basic)){ echo $salary_details->basic;  } ?>
            
          </div>
    </div> 
<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">HRA %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->hra)){ echo $salary_details->hra;  } ?>
            
          </div>
    </div> 
<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">CA %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->ca)){ echo $salary_details->ca;  } ?>
            
          </div>
    </div> 
<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">SA %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->sa)){ echo $salary_details->sa;  } ?>
            
          </div>
    </div> 
<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">INCENTIVE %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->incentive)){ echo $salary_details->incentive;  } ?>
            
          </div>
    </div>
   
    <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">DA %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->da)){ echo $salary_details->da;  } ?>
              </div>
    </div> 
   
    <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">MEDICAL %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->medical)){ echo $salary_details->medical;  } ?>
            
          </div>
    </div> 
    
       
<!--<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">Others</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->others)){ echo $salary_details->others;  } ?>
            
          </div>
    </div> 
    
<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">PF</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->pf)){ echo $salary_details->pf;  } ?>
            
          </div>
    </div> -->
      
<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">ESIC %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->esic)){ echo $salary_details->esic;  } ?>
            
          </div>
    </div> 
 
 
<div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">TDS %</label>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(!empty($salary_details->tds)){ echo $salary_details->tds;  } ?>
            
          </div>
    </div> 
  
</div>	
</div>
<div class="modal-footer">                                       
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</form>