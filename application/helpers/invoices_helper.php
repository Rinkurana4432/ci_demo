<?php
/**
 * Format invoice status
 * @param  integer  $status
 * @param  string  $classes additional classes
 * @param  boolean $label   To include in html label or not
 * @return mixed
 */
function format_invoice_status($status, $classes = '', $label = true)
{
    $id          = $status;
    $label_class = get_invoice_status_label($status);
    if ($status == 1) {
        $status = 'Unpaid';
    } elseif ($status == 2) {
        $status = 'Paid';
    } elseif ($status == 3) {
        $status = 'Not Paid Completely';
    } elseif ($status == 4) {
        $status = 'Overdue';
    } elseif ($status == 5) {
        $status = 'Canceled';
    } else {
        // status 6
        $status = 'Draft';
    }
    if ($label == true) {
        return '<span class="label label-' . $label_class . ' ' . $classes . ' s-status invoice-status-' . $id . '">' . $status . '</span>';
    } else {
        return $status;
    }
}
/**
 * Return invoice status label class baed on twitter bootstrap classses
 * @param  mixed $status invoice status id
 * @return string
 */
function get_invoice_status_label($status)
{
    $label_class = '';
    if ($status == 1) {
        $label_class = 'danger';
    } elseif ($status == 2) {
        $label_class = 'success';
    } elseif ($status == 3) {
        $label_class = 'warning';
    } elseif ($status == 4) {
        $label_class = 'warning';
    } elseif ($status == 5 || $status == 6) {
        $label_class = 'default';
    } else {
        if (!is_numeric($status)) {
            if ($status == 'not_sent') {
                $label_class = 'default';
            }
        }
    }

    return $label_class;
}

/**
 * Function used in invoice PDF, this function will return RGBa color for PDF dcouments
 * @param  mixed $status_id current invoice status id
 * @return string
 */
function invoice_status_color_pdf($status_id)
{
    $statusColor = '';

    if ($status_id == 1) {
        $statusColor = '252, 45, 66';
    } elseif ($status_id == 2) {
        $statusColor = '0, 191, 54';
    } elseif ($status_id == 3) {
        $statusColor = '255, 111, 0';
    } elseif ($status_id == 4) {
        $statusColor = '255, 111, 0';
    } elseif ($status_id == 5 || $status_id == 6) {
        $statusColor = '114, 123, 144';
    }

    return $statusColor;
}

/**
 * This function do not work with cancelled status
 * Calculate invoices percent by status
 * @param  mixed $status          estimate status
 * @param  mixed $total_invoices in case the total is calculated in other place
 * @return array
 */
function get_invoices_percent_by_status($status, $total_invoices = '')
{
   // $has_permission_view = has_permission('invoices', '', 'view');

	$has_permission_view = 1;
    if (!is_numeric($total_invoices)) {
        $where_total = 'status NOT IN(5)';
        if (!$has_permission_view) {
            $where_total .= ' AND addedfrom=' . $this->session->userdata('user_id');
        }
        $total_invoices = total_rows('invoices', $where_total);
    }
    $data            = array();
    $total_by_status = 0;
    if (!is_numeric($status)) {
        if ($status == 'not_sent') {
            $total_by_status = total_rows('invoices', 'sent=0 AND status NOT IN(2,5)' . (!$has_permission_view ? ' AND addedfrom=' . $this->session->userdata('user_id'): ''));
        }
    } else {
        $total_by_status = total_rows('invoices', 'status = ' . $status . ' AND status NOT IN(5)' . (!$has_permission_view ? ' AND addedfrom=' . $this->session->userdata('user_id') : ''));
    }
    $percent                 = ($total_invoices > 0 ? number_format(($total_by_status * 100) / $total_invoices, 2) : 0);
    $data['total_by_status'] = $total_by_status;
    $data['percent']         = $percent;
    $data['total']           = $total_invoices;

    return $data;
}


function load_invoices_total_template()
{
    $CI = &get_instance();
    $CI->load->model('crm_model');   
    $data['total_result'] = $CI->crm_model->get_invoices_total();
    $CI->load->view('widgets/invoices_total_template', $data);
}

?>