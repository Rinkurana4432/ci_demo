<style>
.ceracl-img {
    margin-left: 10px;
}
</style>
<?php if($this->session->flashdata('message') != ''){?>                        
    <div class="alert alert-success col-md-6">                            
      <?php echo $this->session->flashdata('message');?>
    </div>                        
<?php }?>
<div class="x_content" style="overflow:auto;"> 
  <p class="text-muted font-13 m-b-30"></p>    
<div class="container-fluid" style="">
 <!--  <form action="<?php echo base_url(); ?>crm/pipeline" method="post" style="display: inline-table;" class="ceracl-img">
    <button type="submit" class="btn btn-view  btn-xs" style="background: black; margin-bottom: 25px;">
      All
    </button>
    </form> -->
  <?php 

 if(!empty($user1)){ ?>
  <div class="col-md-2 col-sm-6 col-xs-12" style="display: flex;align-items: center;     margin-top: 8px;">
      Filter By Lead Owner 
      <form action="<?php echo base_url(); ?>crm/pipeline" method="post" style="display: inline-table;" class="ceracl-img" style="margin-left: 10px;" >
      <select class="form-control" onchange="this.form.submit()" width="50%"  aria-hidden="true" name="user_id" style="    margin-left: 10px;">
      <?php 
         echo '<option value="">Choose the Users</option>'; 
         echo '<option value="0">All</option>';                  
         foreach($user1 as $lo){
                echo '<option value="'.$lo['id'].'">'.$lo['name'].'</option>';                  
         }
         ?>
      </select>
      </form>
   </div>
<?php
}
  ?>
<div class="dragg">
  <button type="button" class="btn btn-primary addBtn add_crm_tabs" data-toggle="modal" id="add" data-id="lead">Create leads</button> 
        <div id="sortableKanbanBoards" class="row">
<?php 
  if(!empty($processdata)){
    $i= 0;
  foreach($processdata as $process_data){
    //pre($process_data);
    
    ?>
            <!--sütun başlangıç-->
            <div class="panel panel-primary kanban-col" id="leadStyatus_<?php  echo $i; ?>" data-name="<?php echo $process_data['types']['name'];?>">


                <div class="panel-heading">
                  <input type="hidden" class='totalprice' value='<?php //echo count($process_data['process']); ?>'/>
            <?php echo $process_data['types']['name'];?><span style="text-align:  left;" class="total11">
              
            </span>



                    <i class="fa fa-2 fa-chevron-up pull-right process"></i>
                </div>
                <div class="panel-body" style="height: 100px;" >

                    <div id="<?php echo $process_data['types']['id'];?>" class="kanban-centered">

        <?php  foreach($process_data['process'] as $pd){


        #echo   $pd['created_date'];

       # date("Y-m-d h:i:s", strtotime("-30 Days"));

        if($pd['created_date'] > date("Y-m-d h:i:s", strtotime("-30 Days")) && $pd['lead_status'] == '4' || $pd['created_date'] > date("Y-m-d h:i:s", strtotime("-30 Days")) && $pd['lead_status'] == '5' || $pd['created_date'] > date("Y-m-d h:i:s", strtotime("-30 Days")) && $pd['lead_status'] == '6'){
          /*if($pd['created_date'] < date("Y-m-d h:i:s", strtotime("-30 Days")) && $pd['lead_status'] == '4' )*/
        
                    // echo   count($pd['grand_total']);

            #pre($pd['created_date']);
          #pre(date("Y-m-d h:i:s", strtotime("-30 Days")));
        ?>

                        <!--<article class="kanban-entry grab process" id="<?php //echo $pd['order_id'];?>" draggable="true" data-id="<?php //echo $pd['id'];?>">-->
                        <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" draggable="true" data-id="<?php //echo $pd['order_id'];?>">
                            <div class="kanban-entry-inner">
                                <div class="kanban-label" style="cursor: -webkit-grab;">
                                    
                  <h2><button type="button" data-id="lead" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="add_crm_tabs btn btn-view  btn-xs pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>

          
                  </h2>
                                    <p><?php echo $pd['company'];?></p>
                                     <p class="ee"><?php echo $pd['grand_total'];?></p>
                  
                                </div>
                            </div>
                                                     
                        </article>
        <?php }


        if($pd['lead_status'] == '1' || $pd['lead_status'] == '2' || $pd['lead_status'] == '3'){ 

           #pre($pd['created_date']);

          ?>

         
          <article class="kanban-entry grab process" id="<?php echo $pd['id'];?>" draggable="true" data-id="<?php //echo $pd['order_id'];?>">
                            <div class="kanban-entry-inner">
                                <div class="kanban-label" style="cursor: -webkit-grab;">
                                    
                  <h2><button type="button" data-id="lead" data-tooltip="View" data-id="<?php echo $pd["id"]; ?>" class="add_crm_tabs btn btn-view  btn-xs pull-right" data-toggle="modal" id="<?php echo $pd["id"]; ?>"><i class="fa fa-pencil"></i></button>

          
                  </h2>
                                    <p><?php echo $pd['company'];?></p>
                                     <p class="ee"><?php echo $pd['grand_total'];?></p>
                  
                                </div>
                            </div>
                                                     
                        </article>

       <?php }

        }

        ?>     
                    </div>
                </div>
                <div class="panel-footer">

                
                    <a href="#"></a>
                </div>

            </div>

    <?php 
$i++;



  } 




}
   ?>   



        </div>
    </div>


   
  
</div>  
</div>

<div id="1t" class="kanban-col"></div>
<div id="2t" class="kanban-col"></div>
<div id="3t" class="kanban-col"></div>
<div id="4t" class="kanban-col"></div>
<div id="5t" class="kanban-col"></div>
<div id="6t" class="kanban-col"></div>

 

<!--<div id="kanban" class="container-fluid">

  <div class="row">
  <?php 
  /*if(!empty($processdata)){
  foreach($processdata as $process_data){
    ?>
    <div id="todo" data-id="<?php echo $process_data['types']['id']; ?>" class="col-sm-4">
      <div class="title">
        <h1 class="text-center"><?php echo $process_data['types']['process_type'];?></h1>
      </div>
      <div class="card-stack">
    
      <?php foreach($process_data['process'] as $pd){
        ?>
        <div>
          <div class="card">
            <?php echo $pd['process_name'];?>
          </div>
        </div>
      <?php } ?>
       
     
      </div>
    </div>

  <?php }} */?>
  </div>
  
</div>-->

  
   <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa-spin"></i>
                        <h4>Processing...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal modal-static fade" id="comment" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <form method="post" action="<?php echo base_url();?>crm/add_comment">
                            <input type="hidden" name="status" id="status" value="<?php echo $process_data['types']['name'];?>"/>
                            <input type="hidden" name="id" id="id" value=""/>
                            <h4>Comment</h4>
                        <textarea class="form-control col-md-7 col-xs-12" name="comment" ></textarea>
                        <input type="submit" class="btn edit-end-btn" value="Submit">
                        <button type="button" class="btn btn-default close_sec_model">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
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


