<?php
/*
Custom Helper to render view files 
*/

# Render Dashboard inner Pages
	function _render_dashboard_page($view, $data=null, $returnhtml=false, $header = true, $footer = true){
		$ci =& get_instance();	
		$ci->viewdata = (empty($data)) ? $ci->data: $data;		
		if($header){
			$ci->load->view('template/header', $ci->settings);
		}
		if($header){			
			$ci->load->view('template/header-and-sidebar', $ci->settings);
		} 
		$view_html = $ci->load->view($view, $ci->viewdata, $returnhtml);
		
		if($footer){
			$ci->load->view('template/footer', $ci->scripts);
		}
		#This will return html on 3rd argument being true
		if ($returnhtml) return $view_html; 
 	}

# Render Companies Tab
	function _render_company_tab(){			
		$ci =& get_instance();	
		$ci->viewdata = (empty($data)) ? $ci->data: $data;	
		$ci->load->view('template/company_tab', $ci->settings);		
 	}



?>