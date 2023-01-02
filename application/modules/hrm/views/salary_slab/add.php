<style type="text/css">
    .ditect{ width: 100%;
    text-align: center;
    font-size: 18px;
    background-color: #fff;
    color: #140104db;
    }

</style>
<form method="post" action="saveempsalaryslab" id="assetsform" enctype="multipart/form-data">
   
   <?php 
   
      if(!empty($salary_val->slab_structure)){
      $salary_details = json_decode($salary_val->slab_structure);
    
      }   
   ?>
    
    <input type="hidden" name="id" value="<?php if(!empty($salary_val)){ echo $salary_val->id; }?>">
    <!--<input type="hidden" name="save_status" value="1" class="save_status">  -->
    <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
    <div class="modal-body">
    <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Slab Name <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="slabname" id="slabname" value="<?php if(!empty($salary_val)){ echo $salary_val->slabname;  } ?>" class="form-control" />
            </div>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Slab Start Date</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="date" name="slab_start_date" id="slab_start_date" value="<?php if(!empty($salary_val)){ echo $salary_val->slab_start_date;  } ?>" class="form-control" />
            </div>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Slab End Date</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="date" name="slab_end_date" id="slab_end_date" value="<?php if(!empty($salary_val)){ echo $salary_val->slab_end_date;  } ?>" class="form-control" />
            </div>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Salary From</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="salary_from" id="salary_from" name="total" class="form-control" value="<?php if(!empty($salary_val)){  echo $salary_val->salary_from;  } ?>" placeholder="Salary Amount..." />
            </div>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Salary To</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="salary_to" id="salary_to" name="total" class="form-control" value="<?php if(!empty($salary_val)){ echo $salary_val->salary_to;  } ?>" placeholder="Salary Amount..." />
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Basic %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="basic" id="basic" value="<?php if(!empty($salary_details->basic)){ echo $salary_details->basic;  } ?>" class="form-control" onkeyup="checkcharges()" />
            </div>
        </div>
        <div id="da_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Dearness Allowance %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" id="da" name="da" value="<?php if(!empty($salary_details->da)){ echo $salary_details->da;  } ?>" class="form-control" onkeyup="checkcharges()" />
            </div>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">HRA %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" id="hra" name="hra" value="<?php if(!empty($salary_details->hra)){ echo $salary_details->hra;  } ?>" class="form-control" onkeyup="checkcharges()" />
            </div>
        </div>

        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Conveyance Allowance %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="ca" id="ca" value="<?php if(!empty($salary_details->ca)){ echo $salary_details->ca;  } ?>" class="form-control" onkeyup="checkcharges()" />
            </div>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Special Allowance %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="sa" id="sa" value="<?php if(!empty($salary_details->sa)){ echo $salary_details->sa;  } ?>" class="form-control" onkeyup="checkcharges()" />
            </div>
        </div>
        <div id="medical_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Medical %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="medical" id="medical" value="<?php if(!empty($salary_details->medical)){ echo $salary_details->medical;  } ?>" onkeyup="checkcharges()" class="form-control" />
            </div>
        </div>
        <!-- <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">Incentives %</label>
         <div class="col-md-6 col-sm-12 col-xs-12"> 
         <input required type="text" name="incentive" id="incentive" value="<?php if(!empty($salary_details->incentive)){ echo $salary_details->incentive;  } ?>" onkeyup="checkcharges()" class="form-control">
         </div>
    </div>  -->

        <div id="others_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Other %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="others" id="others" value="<?php if(!empty($salary_details->others)){ echo $salary_details->others;  } ?>" class="form-control" onkeyup="checkcharges()" />
            </div>
        </div>

        <div class="item form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="col-md-3 col-sm-12 col-xs-12 ditect"> Employee Contribution</label>
            </div>
        </div>
        <div id="esic_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">ESIC%</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="esic" id="esic" value="<?php if(!empty($salary_details->esic)){ echo $salary_details->esic;  } ?>" class="form-control" />
            </div>
        </div>
        <div id="tsd_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">TDS %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="tds" id="tds" value="<?php if(!empty($salary_details->tds)){ echo $salary_details->tds;  } ?>" class="form-control" />
            </div>
        </div>
        <div id="pf_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">EPF %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="pf" id="pf" value="<?php if(!empty($salary_details->pf)){ echo $salary_details->pf;  } ?>" class="form-control" />
            </div>
        </div>
        <div id="pf_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">LWF (Labour Welfare Fund)</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="lwf" id="lwf" value="<?php if(!empty($salary_details->lwf)){ echo $salary_details->lwf;  } ?>" class="form-control" />
            </div>
        </div>
        <div class="item form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="col-md-3 col-sm-12 col-xs-12 ditect">Employer Contribution</label>
            </div>
        </div>
        <div id="esic_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">ESIC%</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="esic_employer" id="esic_employer" value="<?php if(!empty($salary_details->esic_employer)){ echo $salary_details->esic_employer;  } ?>" class="form-control" />
            </div>
        </div>
        <div id="pf_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">EPF %</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="pf_employer" id="pf_employer" value="<?php if(!empty($salary_details->pf_employer)){ echo $salary_details->pf_employer;  } ?>" class="form-control" />
            </div>
        </div>
        <div id="pf_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">LWF (Labour Welfare Fund)</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="lwf_employer" id="lwf_employer" value="<?php if(!empty($salary_details->lwf_employer)){ echo $salary_details->lwf_employer;  } ?>" class="form-control" />
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">  
   <!-- <input type="button" class="btn btn-default" value="Refresh"  id="salary_refresh" > --> 
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     <button type="submit" class="btn btn-primary save">Submit</button>
</div>
</form>