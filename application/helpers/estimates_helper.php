<?php
/**
 * Format estimate status
 * @param  integer  $status
 * @param  string  $classes additional classes
 * @param  boolean $label   To include in html label or not
 * @return mixed
 */
function format_estimate_status($status, $classes = '', $label = true)
{
    $id          = $status;
    $label_class = estimate_status_color_class($status);
    $status      = estimate_status_by_id($status);
    if ($label == true) {
        return '<span class="label label-' . $label_class . ' ' . $classes . ' s-status estimate-status-' . $id . ' estimate-status-' . $label_class . '">' . $status . '</span>';
    } else {
        return $status;
    }
}

function statuses_list() {
	$status = array(            
            4,
            1,
            5,
            2,
            3,
        );	
	return $status;
}
/**
 * Return estimate status translated by passed status id
 * @param  mixed $id estimate status id
 * @return string
 */
function estimate_status_by_id($id)
{
    $status = '';
    if ($id == 1) {
        $status = 'Draft';
    } elseif ($id == 2) {
        $status = 'Sent';
    } elseif ($id == 3) {
        $status = 'Declined';
    } elseif ($id == 4) {
        $status = 'Accepted';
    } elseif ($id == 5) {
        // status 5
        $status = 'Expired';
    } else {
        if (!is_numeric($id)) {
            if ($id == 'not_sent') {
                $status = 'Not Sent';
            }
        }
    }

    $hook_data = array(
        'id' => $id,
        'label' => $status,
    );
    $status    = $hook_data['label'];

    return $status;
}

/**
 * Return estimate status color class based on twitter bootstrap
 * @param  mixed  $id
 * @param  boolean $replace_default_by_muted
 * @return string
 */
function estimate_status_color_class($id, $replace_default_by_muted = false)
{
    $class = '';
    if ($id == 1) {
        $class = 'default';
        if ($replace_default_by_muted == true) {
            $class = 'muted';
        }
    } elseif ($id == 2) {
        $class = 'info';
    } elseif ($id == 3) {
        $class = 'danger';
    } elseif ($id == 4) {
        $class = 'success';
    } elseif ($id == 5) {
        // status 5
        $class = 'warning';
    } else {
        if (!is_numeric($id)) {
            if ($id == 'not_sent') {
                $class = 'default';
                if ($replace_default_by_muted == true) {
                    $class = 'muted';
                }
            }
        }
    }

    $hook_data = array(
        'id' => $id,
        'class' => $class,
    );
    $class     = $hook_data['class'];

    return $class;
}

/**
 * Calculate estimates percent by status
 * @param  mixed $status          estimate status
 * @param  mixed $total_estimates in case the total is calculated in other place
 * @return array
 */
function get_estimates_percent_by_status($status, $total_estimates = '')
{
   	//$has_permission_view = has_permission('estimates', '', 'view');
	$has_permission_view = 1;
    if (!is_numeric($total_estimates)) {
        $where_total = array();
        if (!$has_permission_view) {
            $where_total['addedfrom'] = $this->session->userdata('user_id');
        }
        $total_estimates = total_rows('estimates', $where_total);
    }

    $data            = array();
    $total_by_status = 0;

    if (!is_numeric($status)) {
        if ($status == 'not_sent') {
            $total_by_status = total_rows('estimates', 'sent=0 AND status NOT IN(2,3,4)' . (!$has_permission_view ? ' AND addedfrom=' . $this->session->userdata('user_id') : ''));
        }
    } else {
        $where = array(
            'status' => $status,
        );
        if (!$has_permission_view) {
            $where = array_merge($where, array(
                'addedfrom' => $this->session->userdata('user_id'),
            ));
        }
        $total_by_status = total_rows('estimates', $where);
    }

    $percent                 = ($total_estimates > 0 ? number_format(($total_by_status * 100) / $total_estimates, 2) : 0);
    $data['total_by_status'] = $total_by_status;
    $data['percent']         = $percent;
    $data['total']           = $total_estimates;

	//echo '<pre>'; print_r($data);
    return $data;
}

function get_total_by_status($status, $clientid = 0) {
	$subtotal = 0;
	$CI =& get_instance();
	$CI->db->select_sum('subtotal');
	$CI->db->from('estimates');
    $CI->db->where(array('clientid' => $clientid,'status' => $status));
    $query = $CI->db->get()->row();
	$subtotal = ($query->subtotal != null)?$query->subtotal:0;
	return $subtotal;
	
}

?>