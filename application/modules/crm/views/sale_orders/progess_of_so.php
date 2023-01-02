  <style type="text/css">
    p, body, td { font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 10pt; }
    body { padding: 0px; margin: 0px; background-color: #ffffff; }
    a { color: #1155a3; }
    .space { margin: 10px 0px 10px 0px; }
    .header { background: #003267; background: linear-gradient(to right, #011329 0%, #00639e 44%, #011329 100%); padding: 20px 10px; color: white; box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.75); }
    .header a { color: white; }
    .header h1 a { text-decoration: none; }
    .header h1 { padding: 0px; margin: 0px; }
    .main { padding: 10px; margin-top: 10px; }
	.gantt_default_corner div:nth-of-type(2) {
    display: none !important;
}
.gantt_default_corner div:nth-of-type(4) {
    display: none !important;
}
.modal-body-content {
    min-height: 500px;
}
  </style>
<?php 
$product_details = $sale_order->product;
	  $product_details = json_decode($product_details);
	  foreach($production_data as $saleProduction){
		$saleOrderProduction = $saleProduction['production_data'];
		$saleOrderProduction = json_decode($saleOrderProduction);
		foreach($saleOrderProduction as $val){
			if(!empty($val->sale_order)){
			if (in_array($sale_order->id, $val->sale_order)) {
					$relatedProductionArray[] = $val;
				}
			}
		}
		}

	  $groups = array();
	   if(!empty($product_details)){
			foreach($product_details as $pro){
					  $total_output =array();

					$requiredQty= $pro->quantity;
					$material_detail = getNameById('material',$pro->product,'id');
					//pre($material_detail);
					$bomRouting_detail = getNameById('job_card', $material_detail->job_card,'id');
					//pre($bomRouting_detail);
					$alotQty= $bomRouting_detail->lot_qty;
					$process_details = json_decode($bomRouting_detail->machine_details);
					//pre($process_details);die;
					$RequiredShifts = 2;
					
					 	 $g = new stdClass;

							  $g->id = "group_".$material_detail->id;
							  $g->text = $material_detail->material_name;
							  $g->tags['info'] = "Test";
							  $g->expanded = true;
							  $g->eventHeight = 30;
							 
							  $g->children = array(); 
							  
							  $i = 1;
				   	foreach($process_details as $process){
						$per_shift_production = $process->production_shift;			
						$per_process_output =  json_decode($process->output_process);
						$outputsum = array_sum(array_column($per_process_output, 'quantity_output'));
                        $process_qty = round(($outputsum/$alotQty)*$requiredQty);
						$RequiredShifts = round($process_qty/$per_shift_production);
						$proc_details = getNameById('add_process', $process->processess,'id');
					  $OUTPUT = 0;
					  $complete = 0;
					  foreach($relatedProductionArray as $PROARRAY){
						  if(isset($PROARRAY->process_name)){
							//  pre();
					     if (in_array($proc_details->id,$PROARRAY->process_name)) {
								$OUTPUT = $PROARRAY->output[0];
							  $complete = round(($OUTPUT/$process_qty)*100);
							  $total_output[]= $complete;
							}
						  }
					  }
					  //pre($RequiredShifts);
						 $start_date = date('Y-m-d', strtotime($sale_order->approve_date . '+ ' . $i . ' days'));
							 $r =  new stdClass;
								$r->id = $i.'_'.$proc_details->id;
								//$r->id = $i;
								$r->text = $proc_details->process_name;
								$r->start = $start_date; 
								//$r->end =  date('Y-m-d', strtotime($Date. ' + 10 days')); 
                                $r->end =  date('Y-m-d', strtotime($start_date . '+ ' . $RequiredShifts . ' days')); 			
								$r->complete = $complete;
								$r->box['bubbleHtml'] =  "This is a bubble with task details";
								$r->row['bubbleHtml'] =  "Row bubble";
								$g->children[] = $r;
                              $i++;

                    }
					//pre($total_output);
					$g->complete = array_sum($total_output);
					$groups[] = $g;
			}
	   }
		// pre($groups);die;
?>

  <!-- daypilot -->
<div class="x_content" >
<div class="main">
  <div id="dp"></div>
</div>
</div>
<script>
 $(document).ready(function () {
    $("#dp").daypilotGantt({
        startDate: '2020-08-24',
        days: 31,
        columns: [
            {
                title: "Name",
                width: 50,
                property: "text"
            },
            {
                title: "Info",
                width: 50,
                property: "info"
            },
            {
                title: "Duration",
                width: 50,
                format: function (args) {
                    var duration = args.task.duration();
                    return duration.toString("d") + "d " + duration.toString("h") + "h";
                }
            }
        ],
        tasks:<?php echo json_encode($groups); ?>,
        links: [
            {from: 1, to: 2},
			{from: 2, to: 3}
        ],
        onTaskClicked: function (args) {
            alert("Clicked: " + args.e.id());
        }
    });
});
</script>