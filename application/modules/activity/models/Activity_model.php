<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class activity_model extends ERP_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tablename = 'activity_log';
        //$this->column_search = array('name');
    }  
	
	
	
	/*material code*/
	 /* Function to fetch Data od material */
		public function get_data($table = '' , $where = array()) {
			$table = $table?$table:$this->tablename;
			
			if($table=="activity_log"){
				$this->db->select($table.'.*,company.name');
				$this->db->from($table);
				$this->db->join("company", $table . ".userid = company.id", 'left');
				
			}else if($table=="supplier_detail"){
					$this->db->select($table.'.*,'.$table.'.id as supplier_id, material.material_name as material_name');  
					$this->db->from($table);					
					$this->db->join("material", $table . ".material_name = material.id", 'left');
					
				}else if($table=="company"){
					$this->db->select($table.'.*,company_detail.address1');  
					$this->db->from($table);					
					$this->db->join("company_detail", $table . ".id = company_detail.company_id", 'left');
					
				}
				
			else{
				$this->db->select($table.'.*,material_type.name as materialtype');
				$this->db->from($table);
				$this->db->join("material_type", $table . ".material_type = material_type.id", 'left');
			}
			$this->db->where($where);
			$qry = $this->db->get();	
			$result = $qry->result_array();			
			return $result;
	}	
	
	
	 /* Function to fetch Data by Id of material */
		public function get_data_byId($table ,$field, $id) {
			if($table=="material" || $table=="purchase_indent" || $table=="purchase_order"){
				 
				$this->db->select($table.'.*, material_type.name as materialtype ');  
				$this->db->from($table);
				$this->db->join("material_type", $table . ".material_type = material_type.id", 'left');
				 
			}else if($table == 'supplier_detail'){
				$this->db->select($table.'.*,'.$table.'.id as supplier_id, material.material_name as material_name');  
				$this->db->from($table);
				$this->db->join("material", $table . ".material_name = material.id", 'left');
				
			}
			$this->db->where($table.'.'.$field, $id);
			$qry = $this->db->get();		
			
			$result = $qry->row();	
			return $result;
	}
	
	 
	
	/*Function to delete data from selected Table */
	public function delete_data($table ,$field ,$id) {	
		$this->db->where($field, $id);
		$this->db->delete($table);
		return true;
	}
	
	
		

}