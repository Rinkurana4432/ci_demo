<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Breadcrumb {
		private $breadcrumbs = array();
		private $separator = '  >  ';
		private $start = '<ul class="breadcrumb"><li><p>YOU ARE HERE</p></li>';
		private $end = '</ul>';
		
		public function __construct($params = array()){
			if (count($params) > 0){
				$this->initialize($params);
			}  
		}
		
		private function initialize($params = array()){
			if (count($params) > 0){
				foreach ($params as $key => $val){
					if (isset($this->{'_' . $key})){
						$this->{'_' . $key} = $val;
					}
				}
			}
		}
		
		function add($title, $href){  
			if (!$title OR !$href) return;
			$this->breadcrumbs[] = array('title' => $title, 'href' => $href);
		}
		
		function output(){
			
			if ($this->breadcrumbs) {
				$output = $this->start;
				
				#$output .= '<li><a href="' . base_url() . 'dashboard">Dashboard</a></li>';
				
				foreach ($this->breadcrumbs as $key => $crumb) {

					$is_active = array_keys($this->breadcrumbs);
					
					if (end($is_active) == $key) {
						$output .= '<li><a href="javascript:;" class="active">' . $crumb['title'] . '</a></li>';
					} else {
						$output .= '<li><a href="' . $crumb['href'] . '">' . $crumb['title'] . '</a></li>';
					}
				}
				return $output . $this->end . PHP_EOL;
			}
			
			return '';
		}
	}