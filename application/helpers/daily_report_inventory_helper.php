<?php
  function switch_db_dinamico($name_db){
		$config_app['hostname'] = 'lastingerp-instance-1.cihrq4rjnxlt.ap-south-1.rds.amazonaws.com';
		$config_app['username'] = 'lastingerp';
		$config_app['password'] = '!lastingerpamitaerp!';
		$config_app['database'] = $name_db;
		$config_app['dbdriver'] = 'mysqli';
		$config_app['dbprefix'] = '';
		$config_app['pconnect'] = FALSE;
		$config_app['db_debug'] = (ENVIRONMENT !== 'production'); 
		$config_app['save_queries'] = true;
    	$config_app['db_debug'] = FALSE;
    	$config_app['cache_on'] = FALSE;
    	$config_app['cachedir'] = '';
    	$config_app['char_set'] = 'utf8mb4';
    	$config_app['dbcollat'] = 'utf8mb4_unicode_ci';
    	$config_app['swap_pre'] = '';
    	$config_app['encrypt'] = FALSE;
    	$config_app['compress'] = FALSE;
    	$config_app['stricton'] = FALSE;
    	$config_app['failover'] = array();
    	$config_app['save_queries'] = TRUE;
		return $config_app;
	}	


function getNameByIdso_ir($table='',$id='',$field=''){	
	$config_app = switch_db_dinamico('lastingerp');
	#pre($CI);
	$CI =& get_instance();
	// $config_app = switch_db_dinamico('lerp_Azuka_Synthetics_llp');
	 $qry = "select * from $table where $field='$id'";
	 $dynamicdb = $CI->load->database($config_app, TRUE);
	 $qryy = $dynamicdb->query($qry);	
	 $result = $qryy->row();
	 return $result;	
}


?>