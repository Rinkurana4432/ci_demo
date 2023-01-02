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
<?php  	$workOrdersIds =json_decode($production_report->workorder_ids,true);
	  $groups = array();
	  $k =1;	$i = 1;  $j=1;
	  $start_date = $production_report->month.'-01';
	   if(!empty($workOrdersIds)){
			foreach($workOrdersIds as $workOrderId){
				//echo $start_date."----";
               $workOrder = getNameById('work_order',  $workOrderId,'id');				
				$g = new stdClass;

				$g->id = "group_".$workOrder->id;
				$g->text = $workOrder->workorder_name;
				//$g->tags['info'] = $workOrder->sale_order_no;
				$g->tags['info'] = "workOrder";
				$g->expanded = true;
				$g->eventHeight = 30;
				$g->children = array(); 
				$products=json_decode($workOrder->product_detail);
				$production_data = get_production_data($workOrder->id);
				$finishgoods_data = get_finishgoods_data($workOrder->id);
			
				foreach($products as $product){
                     $productDetail = getNameById('material',$product->product,'id');
                     $materialName = !empty($productDetail)?$productDetail->material_name:'';
					 $bomRouting_detail = get_data_byId_fromMaterial('material','id',$product->product);
					$process_details = json_decode($bomRouting_detail->machine_details,true);
					$alotQty= $bomRouting_detail->lot_qty;
					$requiredQty = $product->transfer_quantity;
					$process_req_qty=$compeleteQty = $pendingQty= 0;
					$p =  new stdClass;
					$p->id = $k.'_'.$product->product;
					//$p->tags['info'] = $product->job_card;
					$p->tags['info'] = "product";
					$p->text = $materialName;
					
					$g->children[] = $p;

					
					foreach($process_details as $process){
					
						$per_process_output = json_decode($process['output_process'],true);
						$outputsum = array_sum(array_column($per_process_output, 'quantity_output'));
						$process_req_qty = round(($outputsum/$alotQty)*$requiredQty);
						$proc_details = getNameById('add_process',$process['processess'],'id');
						$compeleteQty = array_sum($output_array[$product->product][$proc_details->id]);
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

						$r =  new stdClass;
						
						$r->id = $i.'_'.$proc_details->id;
						$r->tags['info'] = "Process";
						$r->text = $proc_details->process_name;

						$r->complete = $complete;
						//$r->box['bubbleHtml'] =  "This is a bubble with task details";
						//$r->row['bubbleHtml'] =  "Row bubble";
						$p->children[] = $r;	
						$machine_details = json_decode($process['machine_details'],true);
						   
							foreach($machine_details as $mach){		
								$per_shift_production = $mach['production_shift'];			
								$RequiredShifts = round($process_req_qty/$per_shift_production);
								//echo $RequiredShifts;die;
                                  $mach_details = getNameById('add_machine', $mach['machine_id'],'id');	
								  if($RequiredShifts== 0 || is_infinite($RequiredShifts)){
									 $RequiredShifts= 2;
								  }else{
									  //echo $RequiredShifts."++++";
								  }
									$end_date = date('Y-m-d', strtotime($start_date . '+ ' . $RequiredShifts . ' days'));
						    		$m =  new stdClass;
									$m->start = $start_date; 
									$m->end =  $end_date; 			
									$m->id = $j.'_'.$mach_details->id;
									//$m->tags['info'] = $mach_details->machine_code;
									$m->tags['info'] = "machine";
									$m->text = $mach_details->machine_name;
									$r->children[] = $m;
									$start_date = $end_date;
									$j++;
								}
						$i++;
					 }
				$k++; } 
				$g->complete = "40";
				$groups[] = $g;
			}
	   }

			  $start_date = $production_report->month.'-01';
		$m= date('m',strtotime($start_date));
		$y= date('Y',strtotime($start_date));
		
		$number = cal_days_in_month(CAL_GREGORIAN, $m, $y); // 31
//echo $number;die;
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
        startDate:"<?php echo $start_date ?>",
        days: <?php echo $number ?>,
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