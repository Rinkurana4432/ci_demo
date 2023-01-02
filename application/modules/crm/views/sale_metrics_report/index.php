<?php
#pre($lead_reports);
?>

<table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
   <thead>
      <tr>
         <th>Report Name</th>
         <th>Discription</th>
         <th>Run Date</th>
      </tr>
   </thead>
   <tbody>
    <?php if(!empty($sale_metrics)){ 
      foreach ($sale_metrics as $lpr) {
      ?>
      <tr>
         <td><a href="<?php echo base_url(); ?><?php echo $lpr['report_slug']; ?>"><strong><?php echo $lpr['report_name']; ?></strong></a></td>
         <td><?php echo $lpr['discription']; ?></td>
         <td><?php echo time_elapsed_string($lpr['created_date']); ?></td>
      </tr>
    <?php  } }?>
   </tbody>
</table>
                                