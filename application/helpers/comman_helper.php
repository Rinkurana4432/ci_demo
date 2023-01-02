<?php 

function paginationAttr($base_url,$rows){
    $config = array();
    $config["base_url"] = base_url() . $base_url;
    $config["total_rows"] = $rows;
    $config["per_page"] = 10;
    $config["uri_segment"] = 3;
    $config['reuse_query_string'] = true;
    $config["use_page_numbers"] = TRUE;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul><!--pagination-->';
    $config['first_link'] = '&laquo; First';
    $config['first_tag_open'] = '<li class="prev page">';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Last &raquo;';
    $config['last_tag_open'] = '<li class="next page">';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = 'Next &rarr;';
    $config['next_tag_open'] = '<li class="next page">';
    $config['next_tag_close'] = '</li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '&larr; Previous';
    $config['prev_tag_open'] = '<li class="prev page">';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page">';
    $config['num_tag_close'] = '</li>';
    $config['anchor_class'] = 'follow_link';
    return $config;
}

function multiObjectToArray($data){
    $arrayData = [];
    if( !empty($data) ){
        foreach ($data as $key => $value) {
            foreach ($value as $mkey => $mvalue) {
               $arrayData[$key][$mkey] = $mvalue;                   
            }             
        }       
    }
    return $arrayData;
}

function mergeMultiDemArray($array1,$array2){
    $data = [];
    $i = 0;
    foreach ($array1 as $key => $value) {
        $data[] = $value;
        $i++;
    }
    if( count($array1) == $i ){
        foreach ($array2 as $key => $value) {
            $data[$i] = $value;
            $i++;
        }
    }

   return $data;


}