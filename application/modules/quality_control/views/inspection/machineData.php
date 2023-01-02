
<?php 
$actual = $set = $table = "";
if(isset($edit->input_process)){
   $inputIncData = json_decode($edit->input_process);
}
if(isset($edit->machine_actual)){
   $machineActual = json_decode($edit->machine_actual);
}
if( $dataProcess ){
   foreach ($dataProcess as $key => $data) {
      if( $view ){
         echo '<br>';
         echo '<br>';
         echo '<br>';
      }
      $border = 'border="1px"';
      $cellpadding = 'cellpadding="2"';
      $cellpadding1 = 'cellpadding="1"';
      $tableAttr = 'id="example" class="table table-striped table-bordered"';
      $table .= '<table width="100%">';
      $table .= '<tr>';
            $table .= '<td style="width:48%; padding-right:5px;">';
                  $table .= "<table {$tableAttr} {$border}  {$cellpadding}>";
                  if( isset($data['machineDetails']) ){
                     foreach ($data['machineDetails']['machineBio'] as $machineDetailsKey => $machineDetailsValue) {
                        $table .= '<tr>';
                        $table .='<td><strong>Machine Name</strong></td>';
                        $table .='<td><strong>Machine Parameter</strong></td>';
                        $table .='<td><strong>Set</strong></td>';
                        $table .='<td><strong>Actual</strong></td>';
                        $table .= '</tr>';
                        $table .= "<tr>";
                        $table .="<td><strong>M/C Name.</strong>  {$machineDetailsValue['machine_name']}</td>";
                        $table .= "<td>";
                        foreach ($machineDetailsValue['machine_parameter'] as $macPerKey => $macPerValue) {
                              $table .= "<strong>Machine Parameter</strong> : {$macPerValue['machine_parameter']} <br>";
                              $table .= "<strong>Parameter UOM</strong>     : {$macPerValue['uom']} <br> <br>";
                        }
                        $table .= "</td>";
                        $table .= "<td {$border}>";
                        foreach ($machineDetailsValue['machine_parameter'] as $macPerKey => $macPerValue) {
                              $setmachine = $macPerValue['uom_value'];
                              if( $view == 'view' ){
                                 $table .= $setmachine . '<br>';
                              }else{
                                 $table .= "<input type='text' class='form-control' value='{$setmachine}' readonly /><br>";
                              }
                        }
                        $table .= "</td>";
                        $table .= "<td>";
                        foreach ($machineDetailsValue['machine_parameter'] as $macPerKey => $macPerValue) {
                            $a = $machineActual[$macPerKey]??'';
                              if( $view == 'view' ){
                                  
                                 $table .= "$a <br>";
                              }else{
                                 $table .= "<input type='text'   name='machine[actual][$macPerKey]' class='form-control' value='{$a}' /><br>";
                              }
                        }
                        $table .= "</td>";
                        $table .= "</tr>";
                     }
                  }
                  $table .= "</table>";
            $table .= "</td>";
            $table .= '<td style="width:50%;">';
                  $table .= "<table {$tableAttr} {$border} {$cellpadding1}>";
                  $col6 = 'colspan="6"';
                  $textAlign = 'style="text-align:center"';
                  $table .= "<tr>";
                  $table .= "<td {$col6} {$textAlign}><center><strong>Input Process</strong></center></td>";
                  $table .= "</tr>";
                  $table .= "<tr>";
                  $table .= "<td>Material Type</td> <td>Material Name</td> <td>Quantity Input</td> <td>UOM</td> <td>Set</td> <td>Actual</td>";
                  $table .= "</tr>";
                  if( isset($data['input_process']) ){
                      foreach ($data['input_process'] as $inputKey => $inputValue) {
                            $mId    = $inputValue['materialNameId'];
                            $set =   $inputValue['quantity_input']??'';
                            if( isset($inputIncData[$inputKey]->material_name_id) ){
                               if( $mId == $inputIncData[$inputKey]->material_name_id ){
                                  $actual = $inputIncData[$inputKey]->actual??'';
                               }
                            }
                            $table .= "<tr>";
                            $table .= "<td>{$inputValue['material_type']}</td>";
                            $table .= "<td>{$inputValue['material_name']}</td>";
                            $table .= "<td>{$inputValue['quantity_input']}</td>";
                            $table .= "<td>{$inputValue['uom']}</td>";
                            if($view == 'view'){
                                  $table .= "<td>{$set}</td>";
                                  $table .= "<td>{$actual}</td>";
                               }else{
                                  $table .= "<td><input type='hidden' name='inputProcess[{$inputKey}][material_name_id]' value='{$mId}' />
                                                 <input type='text'    class='form-control' value='{$set}' readonly /></td>";
                                  $table .= "<td><input type='text'   name='inputProcess[{$inputKey}][actual]' class='form-control' value='{$actual}' /></td>";
                            }
                            $table .= "</tr>"; 
                      }
                  }
                  $table .= "</table>";
            $table .= "</td>";
   $table .= "</tr>";
   $table .= "</table>";
   if( $view ){
      $table .= '<br><br><br>';
   }
   }
}
echo $table;
?>