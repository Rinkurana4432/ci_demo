<?php 

function table_th($th){
    $data  = "<thead>";
    $data .= "<tr>";
    if( $th ){
        foreach ($th as $key => $value) {
            $string = is_string($key);
            $style  = ($string)?$key:'';
            $data .="<th style='{$style}'>".ucfirst($value)."</th>";
        }
    }
    $data .= "</tr>";
    $data .= "</thead>";
    return $data;
}