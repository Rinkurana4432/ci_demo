<?php
/*
Dynamic Layout for Forms
*/

/* HTML for input field*/
function input_field($array){
	$field = '<div class="form-group">';
	if(!empty($array)) {
		$field .= '<input type="'.(isset($array['type']))?$array['type']:'text'.'" name="'.(isset($array['name']))?$array['name']:'field-name'.'" class="form-control '.(isset($array['class']))?$array['class']:''.'" id="'.(isset($array['type']))?$array['type']:'field-id'.'">';	
	} else {
		$field .= '<input type="text" name="field-name" class="form-control" id="field-id">';		
	}
	$field .= '</div>';
	return $field;
}

?>