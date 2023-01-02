<table id="attendance123" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
  <?= table_th(['Report Name','Discription','Run Date']) ?>
   <tbody>
      <?php 
        if( $purchaseReportType ){
          foreach ($purchaseReportType as $key => $value) { 
                $url = base_url("purchase/purchase_report/{$value['url']}");
            ?>
              <tr>
                <td><?= "<a href='{$url}'><strong>{$value['report_name']}</strong></a>"; ?></td>
                <td><?= $value['description']; ?></td>
                <td><?= $value['created_at']; ?></td>
              </tr>          
    <?php }
        }

      ?>
   </tbody>
</table>