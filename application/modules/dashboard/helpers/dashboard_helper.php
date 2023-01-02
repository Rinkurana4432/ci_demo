<?php function getPermissionsForDashboard($where = array()){ 
		$CI =& get_instance();
		$dynamicdb = $CI->load->database('dynamicdb', TRUE);	
		$dynamicdb->select('permissions.*,sub_module.sub_module_name,sub_module.slug,modules.id as moduleId');
		$dynamicdb->from('permissions');
		$dynamicdb->join('sub_module', 'permissions.sub_module_id = sub_module.id', 'left');
		$dynamicdb->join('modules', 'modules.id = sub_module.modules_id', 'left');
		$dynamicdb->where($where);
		$query = $dynamicdb->get();
		$result = $query->result_array();		
		return $result;
} ?>