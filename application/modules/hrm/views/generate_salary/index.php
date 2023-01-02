
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>


<div class="x_content">
    
    <p class="text-muted font-13 m-b-30"></p>    

<div class="col-md-12  export_div">  <div class="col-md-4 col-sm-12 datePick-left"><form method="post" action="" id="salaryform" class="form-material row">
                  <div class="form-group col-md-12">
                   
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class='input-group date' id=''>
                         <input type="date" min="0" id="salary_date" name="startdate" class="form-control datepick" required>
                        </div>
						<button  type="submit" id="BtnSubmit" class="btn datepick">Submit</button>
                      </div>
                    </div>
                  </div> 
                    
</form></div></div> 

              <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Employee Id 
                    </th>
                    <th>Full name
                    </th>
                    <th>Total salary
                    </th>
                    <th>Action
                    </th>
                  </tr>
                </thead>
                <tbody class="payroll">
                </tbody>
              </table>

</div>
                            <div id="printThis">
<div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
    <div class="modal-dialog modal-lg modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Generate Salary</h4>
            </div>
            <div class="modal-body-content"></div>
        </div>
    </div>
</div>
</div>         

    