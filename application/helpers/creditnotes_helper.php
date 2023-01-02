<?php

function get_statuses()
{
	$statuses = array(
		array(
			'id'=>1,
			'color'=>'#03a9f4',
			'name'=> 'Open',
			'order'=>1,
			'filter_default'=>true,
			),
		 array(
			'id'=>2,
			'color'=>'#84c529',
			'name'=> 'Closed',
			'order'=>2,
			'filter_default'=>true,
		 ),
		 array(
			'id'=>3,
			'color'=>'#777',
			'name'=> 'Void',
			'order'=>3,
			'filter_default'=>false,
		 ),
	);

	return $statuses;
}

/**
 * Format credit note status
 * @param  mixed  $status credit note current status
 * @param  boolean $text   to return text or with applied styles
 * @return string
 */
function format_credit_note_status($status, $text = false)
{
    
    $statuses = get_statuses();
    $statusArray = false;
    foreach ($statuses as $s) {
        if ($s['id'] == $status) {
            $statusArray = $s;
            break;
        }
    }

    if (!$statusArray) {
        return $status;
    }

    if ($text) {
        return $statusArray['name'];
    }

    $style = 'border: 1px solid '.$statusArray['color'].';color:'.$statusArray['color'].';';
    $class = 'label s-status';

    return '<span class="'.$class.'" style="'.$style.'">' . $statusArray['name'] . '</span>';
}
?>