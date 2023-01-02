<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 class Hrm_model extends ERP_Model {
    public function __construct() { 
        parent::__construct();
        $this->load->database();
        $this->tablename = 'user'; 
    }
    /* database field columns */
    public function get_field_type_data($data, $type) {
        switch ($type) {
			
             case 'attendance_Excel_dummy':
                $all_fields = array('biometric_id', 'from_date','to_date','D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9', 'D10', 'D11','D12', 'D13', 'D14', 'D15', 'D16', 'D17', 'D18', 'D19', 'D20', 'D21', 'D22', 'D23', 'D24', 'D25', 'D26', 'D27', 'D28', 'D29', 'D30', 'D31','created_by', 'created_by_cid');
            break;
             case 'workershiftChange':
                $all_fields = array('company_unit', 'department_id', 'shift_id', 'shiftChangeStartDate', 'employeeId', 'created_by', 'created_by_cid','employeeShiftEndDate');
            break; 
            case 'employshiftChange':
                $all_fields = array('company_unit', 'department_id', 'shift_id', 'shiftChangeStartDate', 'employeeId', 'created_by', 'created_by_cid','employeeShiftEndDate');
            break;  
            case 'workermonthalislab':
                $all_fields = array('monthYear', 'grossPay', 'empWokingSalary', 'oneDaysalary', 'totalLeave', 'weekoff', 'workingdays', 'otSalary', 'slabinfo','created_by_cid','created_by','worker_id','netpay','employerdeduction');
            break;        
            case 'user':
                $all_fields = array('email', 'password', 'email_status', 'status', 'role', 'c_id', 'activation_code', 'company_db_name', 'business_status');
            break;
            case 'production_data':
                $all_fields = array('shift','date','electr_unit_price','planning_id','production_data','department_id','company_branch','created_by_cid','save_status','created_by','edited_by','no_of_dys');
            case 'user_detail':
                $all_fields = array('name','manager_id','correspondence_state', 'permanent_state', 'address1', 'address2', 'designation', 'gender', 'age', 'contact_no', 'experience', 'qualification', 'date_joining', 'u_id', 'c_id', 'facebook', 'linkedin', 'twitter', 'instagram', 'skill', 'experience_detail', 'save_status','company_id','dept_id','probation_period','biometric_id','bankDetails','paymentMode','confirmation_date');
            break;
            case 'company':
                $all_fields = array('name', 'email', 'password', 'email_status', 'user_id');
            break;
            case 'permissions':
                $all_fields = array('sub_module_id', 'user_id', 'is_all', 'is_view', 'is_edit', 'is_delete', 'is_add', 'is_validate_purchase_budget_limit');
            break;
            case 'work_detail':
                $all_fields = array('job_name', 'work_assigned_to', 'end_date_time', 'work_description', 'npdm_id', 'work_status', 'created_by', 'created_by_cid');
            break;
            case 'worker_attendance_new':
                $all_fields = array('id', 'worker_id', 'atten_date', 'morning_shift', 'evening_shift', 'status', 'supervisor_id','created_by_cid');
            break;
            case 'worker':
                $all_fields = array('company_unit', 'worker_type','worker_supervisor','suervisorID', 'department', 'designation', 'name', 'address', 'state', 'country', 'city', 'mobile_number', 'bank_name', 'branch_name', 'account_no', 'ifsc_code', 'salary', 'date_of_joining', 'date_of_relieving', 'other', 'save_status', 'created_by', 'created_by_cid','worker_supervisor','shift_id','department_id','working_hrs','date_of_birth','fathername','plantLocation','education','adharNo','panNo','salarySlab','active_inactive','biomatricid','workerSlabData','uan_no','esic_no');
            break;
            case 'assets_category':
                $all_fields = array('id', 'cat_status', 'cat_name', 'created_by', 'created_by_cid');
            break;
            case 'assets_list':
                $all_fields = array('id', 'catid', 'ass_name', 'ass_brand', 'ass_model', 'ass_code', 'configuration', 'purchasing_date', 'ass_price', 'ass_qty', 'in_stock', 'created_by', 'created_by_cid', 'created_date');
            break;
            case 'assets_employees':
                $all_fields = array('id', 'asset_id', 'assign_id', 'assets_products', 'project_id', 'task_id', 'log_qty', 'start_date', 'end_date', 'back_date', 'back_qty', 'created_by', 'created_by_cid', 'created_date');
            break;       
			case 'assets_workers':
                $all_fields = array('id', 'asset_id', 'assign_id', 'assets_products', 'project_id', 'task_id', 'log_qty', 'start_date', 'end_date', 'back_date', 'back_qty', 'created_by', 'created_by_cid', 'created_date');
            break;
            case 'job_position':
                $all_fields = array('designation', 'department', 'recruitment_responsible', 'website', 'location', 'expected_new_employee', 'hr_responsible', 'job_description','no_position','exp_details', 'emp_type', 'supervises', 'qualification_detials','other_qualification', 'exp_year','report', 'other_specfications', 'person_name', 'expansion', 'person_designation', 'specific_field', 'date_separation', 'job_summary','headcount_other','headcount_AOP', 'created_by', 'created_by_cid');
            break;
            case 'job_application':
                $all_fields = array('name', 'email', 'phone_no', 'short_intro', 'resume_upload', 'job_position_id', 'reference', 'exp_salary', 'created_by', 'created_by_cid', 'status');
            break;
            case 'hrm_terms':
                $all_fields = array('title', 'terms_cond', 'created_date','created_by','created_by_cid');
            break;          
			case 'travel_info':
                $all_fields = array('u_id','no_of_days', 'daily_allowance', 'local_conveyance','Purpose_of_visit', 'travel_details', 'gross_charge','advance_taken', 'net_claim', 'remarks','approve_status', 'paid_status', 'created_by','created_by_cid', 'approve_by', 'paidstatus_by');
            break;		
			case 'salary_components':
                $all_fields = array('salary_component', 'salary_component_abbr', 'type','description', 'component_type', 'depends_on_payment_days','is_tax_applicable', 'is_income_tax_component', 'deduct_full_tax_on_selected_payroll_date','variable_based_on_taxable_salary', 'exempted_from_income_tax', 'round_to_the_nearest_integer', 'statistical_component','do_not_include_in_total', 'is_flexible_benefit', 'condition_formula','amount', 'amount_based_on_formula', 'created_by','created_by_cid', 'approve_status');
            break;
            case 'emp_salary':
                $all_fields = array('emp_id', 'type_id', 'total', 'created_by', 'created_by_cid','salary_details','slab_id');
            break;
            case 'attachments':
                $all_fields = array('rel_type','rel_id','file_type','file_name');
            break; 
            case 'letter_template':
                $all_fields = array('title','content','created_by','created_by_cid');
            break;
			case 'emp_leave':
			$all_fields = array('id','em_id','typeid','leave_type','start_date','end_date','leave_duration','apply_date','reason','cancel_reason','leave_status','created_by','created_by_cid','created_date','mail_id','approvedby_id');
			 break;
             case 'work_leave':
            $all_fields = array('id','em_id','typeid','leave_type','start_date','end_date','leave_duration','apply_date','reason','cancel_reason','leave_status','created_by','created_by_cid','created_date','mail_id','approvedby_id');
             break;
			case 'salary_slab':
			$all_fields = array('id','slab_start_date','slab_end_date','salary_from','salary_to','created_by','created_by_cid','slab_structure','created_date','slabname');
			 break;
			case 'task_list_status':
		   	$all_fields = array('id','sequence_id','name','status','task_done','created_by','created_by_cid');
			 break;
        	case 'task_list_role':
		   	$all_fields = array('id', 'name','created_by','created_by_cid','modified_date');
			 break;
        	case 'assigned_roles':
		   	$all_fields = array('id', 'role_id'  ,'assigned_to_user','assigned_to_worker','created_by','created_by_cid');
			 break;
        	case 'new_work_detail':
		   	$all_fields = array('id', 'assigned_to' ,'superviser','task_name','description','pipeline_status','start_date','due_date','npdm','attachment','repeat_task','repeatation_days','repeatation_on_off','task_done','created_by','created_by_cid');
			 break;
             case 'new_work_details_comments':
             $all_fields = array('id','new_work_detail_id','comments','created_by','created_by_cid');
            break;
            case 'transition_tasklist':
	 	   	$all_fields = array('id','pipeline_id', 'from_status'  ,'to_status','status','authority','created_by_cid','update_date');
			 break;
        	case 'task_list_sprint':
	 	   	$all_fields = array('id','name','created_by','created_by_cid','modified_date');
			 break;
            case 'transition_authority':
            $all_fields = array('id','pipeline_id','col_id','assignee','role','supervisor','created_by_cid');
            break;	
            case 'production_setting':
             $all_fields = array('company_unit','department','shift_number','shift_name','shift_start','shift_end','week_off','created_by_cid','created_by','edited_by');
                break; 
        }
        return $data = format_data_to_be_added($all_fields, $data);
    }
    public function fetch_job_application($table) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('status', 5);
        $qry = $dynamicdb->get();
        $result = $qry->row();
        return $result;
    }
    /* Insert Data */
    public function insert_tbl_data($table, $data) {  //pre($data);  
        $fieldData = $this->get_field_type_data($data, $table);
        $this->db->insert($table, $fieldData);
        $userInsertedid = $this->db->insert_id();
        if ($userInsertedid) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $fieldData['id'] = $userInsertedid; 
            $dynamicUserInsertedid = $dynamicdb->insert($table, $fieldData);
         
        }  // echo $dynamicdb->last_query();die();
        return $userInsertedid;
    }
    //num rows
	public function num_rows($table, $where = array(),$where2){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->select('*');  
		$dynamicdb->from($table);
		$dynamicdb->where($where);
	 if($where2!=''){
		 $dynamicdb->where($where2);
		 }
		$qry = $dynamicdb->get();
		 // echo $dynamicdb->last_query();
		$result = $qry->num_rows();		
		return $result; 
	}	
	
    public function get_status_data($table) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->order_by('id', 'ASC');
        $qry = $dynamicdb->get();
            //echo $dynamicdb->last_query();
        $result = $qry->result_array();
        //pre($result);die;
        return $result;
    }
    public function get_data($table = '', $where = array()) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        //pre($dynamicdb);
        if ($table == "sub_module" || $table == "modules" || $table == "activity_log" || $table == "user_detail" || $table == "work_status" || $table == "worker" ||  $table == "assets_list" || $table == "assets_category" || $table == "job_position_status" || $table == "leave_types") {
            $dynamicdb->select('*');
            $dynamicdb->from($table);
        } else {
            $dynamicdb->select($table . '.*,`user_detail`.u_id, user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill', 'user_detail.save_status');
            $dynamicdb->from($table);
            $dynamicdb->join("user_detail", $table . ".id = user_detail.u_id", 'left');
        }
        if ($table == "modules" && !empty($where)) $dynamicdb->where_in('id', $where);
        else $dynamicdb->where($where);
        $qry = $dynamicdb->get();
        // echo $dynamicdb->last_query();//die;
        $result = $qry->result_array();
        //pre($result);die;
        return $result;
    }
	    public function get_usr_data($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
       // error_reporting(E_ERROR);
      
         $start = ($start-1) * $limit;
        
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        //pre($dynamicdb);
        if ($table == "sub_module" || $table == "modules" || $table == "activity_log" || $table == "user_detail" || $table == "work_status" || $table == "worker" ||  $table == "assets_list" || $table == "assets_category" || $table == "job_position_status" || $table == "leave_types") {
            $dynamicdb->select('*');
            $dynamicdb->from($table);
        } else {
            $dynamicdb->select($table . '.*,`user_detail`.u_id, user_detail.name as usr_name, user_detail.address1, user_detail.address2, user_detail.designation as usr_designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill', 'user_detail.save_status');
            $dynamicdb->from($table);
            $dynamicdb->join("user_detail", $table . ".id = user_detail.u_id", 'left');
        }
        if ($table == "modules" && !empty($where)) $dynamicdb->where_in('id', $where);
        else $dynamicdb->where($where);
        if($where2!='')
            {$dynamicdb->where($where2);
            }
            if(isset($_GET['sort'])){
           
            $sort=(string)$_GET['sort'];
            $dynamicdb->order_by('id',$sort);
            }else{
                $dynamicdb->order_by('id',$order);
            }
        if($export_data == 0){
                $dynamicdb->limit($limit, $start);
            }
        $qry = $dynamicdb->get();
       // echo $dynamicdb->last_query();//die;
        $result = $qry->result_array();
        //pre($result);die;
        return $result;
        
    }
    /* Update Data in master database table in individual database*/
   public function update_data($table,$db_data,$field,$id) {       
        $data = $db_data;
        $db_data = $this->get_field_type_data($db_data,$table);
       # pre($db_data);
        $this->db->where($field, $id);      
        $result = $this->db->update($table, $db_data);  

        if($_SESSION['loggedInUser']->role != 3){   
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);     
            $dynamicdb->update($table, $db_data);   
        }
     // echo $dynamicdb->last_query();die();
        return TRUE;
    }  
	public function update_data_details($table,$db_data,$field,$id) {		
	
		//$db_data = $this->get_field_type_data($db_data, $table);
		$this->db->where($field, $id);		
		$result = $this->db->update($table, $db_data);		
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->where($field, $id);		
			$dynamicdb->update($table, $db_data);
			// echo $dynamicdb->last_query();//die();
		return TRUE;
	}	
	
    
    /* Function to fetch Data by Id */
    public function get_data_byId($table, $field, $id, $changePassword = '') {
        if ($changePassword == 'changePassword') {
            $this->db->select($table . '.*,user_detail.u_id,user_detail.manager_id,user_detail.company_id,user_detail.dept_id, user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill,user_detail.save_status');
            $this->db->from($table);
            $this->db->join("user_detail", $table . ".id = user_detail.u_id", 'left');
            $this->db->where($table . '.' . $field, $id);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select($table . '.*,user_detail.u_id,user_detail.manager_id,user_detail.company_id,user_detail.dept_id,user_detail.name, user_detail.address1, user_detail.address2, user_detail.designation,user_detail.gender,user_detail.age,user_detail.contact_no,user_detail.experience, user_detail.experience_detail,user_detail.qualification, user_detail.user_profile, user_detail.date_joining, user_detail.facebook, user_detail.twitter, user_detail.instagram, user_detail.linkedin, user_detail.skill,user_detail.save_status');
            $dynamicdb->from($table);
            $dynamicdb->join("user_detail", $table . ".id = user_detail.u_id", 'left');
            $dynamicdb->where($table . '.' . $field, $id);
            $qry = $dynamicdb->get();
			// echo $dynamicdb->last_query();die();
        }
        $result = $qry->row();
		// pre($result);die();
        return $result;
    }
    public function get_user_data_byId($table, $field, $id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('user.*, company.id as companyId , company.email as email,company.name as companyName');
        $dynamicdb->from($table);
        $dynamicdb->join("user", $table . ".user_id = user.id", 'left');
        $dynamicdb->where('company.' . $field, $id);
        $qry = $dynamicdb->get();
        $result = $qry->row();
        return $result;
    }
    public function emailExist($email) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $qry = $this->db->get();
        $result = $qry->row();
        return $result;
    }
    /* Function to delete data from selected Table */
   /* public function delete_data1($table, $field, $id) {
        $this->db->where($field, $id);
        $del = $this->db->delete($table);
        if ($del) {
            $this->db->where('u_id', $id);
            $this->db->delete('user_detail');
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where($field, $id);
            $delFromDynamicDb = $dynamicdb->delete($table);
            if ($delFromDynamicDb) {
                $dynamicdb->where('u_id', $id);
                $dynamicdb->delete('user_detail');
            }
        }
        return true;
    }   */
		/* Function to delete data from selected Table */
	public function delete_data($table ,$field ,$id) {	
		$this->db->where($field, $id);
		if($this->db->delete($table)){
			$this->db->where($field, $id);
				$this->db->delete($table);		
				$dynamicdb = $this->load->database('dynamicdb', TRUE);
				$dynamicdb->where($field, $id);
				$dynamicdb->delete($table);
				return true;
		}		
	}
	

    /*Update group permissions*/
    function update_user_permissions($user_id, $id, $permissions_data) {
        $this->db->where('user_id', $user_id);
        $this->db->where('sub_module_id', $id);
        $q = $this->db->get('permissions');
        if ($q->num_rows() > 0) {
            $this->db->where('user_id', $user_id);
            $this->db->where('sub_module_id', $id);
            $this->db->update('permissions', $permissions_data);
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('user_id', $user_id);
            $dynamicdb->where('sub_module_id', $id);
            $dynamicUserInsertedid = $dynamicdb->update('permissions', $permissions_data);
        } else {
            $this->db->insert('permissions', $permissions_data);
            $insertedId = $this->db->insert_id();
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $permissions_data['id'] = $insertedId;
            $dynamicUserInsertedid = $dynamicdb->insert('permissions', $permissions_data);
        }
        return true;
    }

    function update_user_comp_permissions($user_id, $id, $perm_status) {
        $this->db->where('user_id', $user_id);
        $this->db->where('comp_id', $id);
        $q = $this->db->get('comp_permission');
        if ($q->num_rows() > 0) {
            $this->db->where('user_id', $user_id);
            $this->db->where('comp_id', $id);
            $this->db->update('comp_permission', $perm_status);
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('user_id', $user_id);
            $dynamicdb->where('comp_id', $id);
            $dynamicUserInsertedid = $dynamicdb->update('comp_permission', $perm_status);
        } else {
            $this->db->insert('comp_permission', $perm_status);
            $insertedId = $this->db->insert_id();
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $permissions_data['id'] = $insertedId;
            $dynamicUserInsertedid = $dynamicdb->insert('comp_permission', $perm_status);
        }
        return true;
    }

    # Save user permissions
    public function save_user_permissions($data) {
        $this->db->insert('permissions', $data);
        $id = $this->db->insert_id();
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicUserInsertedid = $dynamicdb->insert('permissions', $data);
        return $id;
    }
    # get group permission by group Id
    function fetch_user_premissions($id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('sm.sub_module_name as sub_module_name,sm.id as sub_module_id,p.is_all as is_all,p.is_view as is_view,p.is_add as is_add,p.is_edit as is_edit,p.is_delete as is_delete,p.is_validate as is_validate,p.is_validate_purchase_budget_limit as is_validate_purchase_budget_limit');
        $dynamicdb->from('sub_module sm');
        $dynamicdb->join('permissions p', 'sm.id = p.sub_module_id and p.user_id="' . $id . '"', 'left');
        $query = $dynamicdb->get();
        $result = $query->result();
        return $result;
    }
    public function change_status($id, $status) {
        $this->db->where('id', $id);
        $status = array('status' => $status);
        $this->db->update('user', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('user', $status);
        return true;
    }
	public function change_status_UserDetails($id, $status) {
        $this->db->where('id', $id);
        $status = array('is_activated' => $status);
        $this->db->update('user_detail', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('u_id', $id);
        $dynamicdb->update('user_detail', $status);
		// echo $dynamicdb->last_query();
		// die();
        return true;
    }  
      
      
    public function change_status_tbl($table,$id, $status) {
        $this->db->where('id', $id);
        $status = array('status' => $status);
        $this->db->update($table, $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update( $table, $status);
        return true;
    }
    public function change_password($id, $password) {
        $this->db->where('id', $id);
        $password = array('password' => $password);
        $this->db->update('user', $password);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('user', $password);
        return true;
    }
    # get group permission by group Id
    function fetch_user_premissions_by_id($id , $where = array()){		
		$this->db->select('sm.sub_module_name as sub_module_name,sm.id as sub_module_id,p.id ,p.is_all as is_all,p.is_view as is_view,p.is_add as is_add,p.is_edit as is_edit,p.is_delete as is_delete,p.is_validate as is_validate');
		$this->db->from('sub_module sm');
		$this->db->join('permissions p', 'sm.id = p.sub_module_id and p.user_id="'.$id.'"','left');
		$this->db->where($where);
		$query = $this->db->get(); 
		#echo $this->db->last_query();		
		$result = $query->result();	
		return $result;
	}

    function fetch_comp_premissions_by_id($id, $where = array()) {
	     $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('cdp.name as comp_name,cdp.id as comp_id,cmp.status');
        $dynamicdb->from('company_detail cdp');
        $dynamicdb->join('comp_permission cmp', 'cdp.id = cmp.comp_id and cmp.user_id="' . $id . '"', 'left');
        $dynamicdb->where($where);
        $query = $dynamicdb->get();
		//echo $dynamicdb->last_query();
        $result = $query->result();
        return $result;
    }

    

    function fetch_user_activity_log($start, $limit, $id) {
        /* $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from('activity_log');
        $dynamicdb->where('userid',$id);
        $dynamicdb->order_by("id", "DESC");
        $dynamicdb->limit($limit, $start);
        $qry = $dynamicdb->get();
        $result = $qry->result_array();
        return $result; */
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from('activity_log');
        $dynamicdb->where('userid', $id);
        $dynamicdb->order_by("id", "DESC");
        $dynamicdb->limit($limit, $start);
        $qry = $dynamicdb->get();
        $result = $qry->result_array();
        return $result;
    }
    function fetch_country() {
        $this->db->order_by("country_name", "ASC");
        $query = $this->db->get("country");
        return $query->result();
    }
    function fetch_state($country_id) {
        $this->db->where('country_id', $country_id);
        $this->db->order_by('state_name', 'ASC');
        $query = $this->db->get('state');
        $output = '<option value="">Select State</option>';
        foreach ($query->result() as $row) {
            $output.= '<option value="' . $row->state_id . '">' . $row->state_name . '</option>';
        }
        return $output;
    }
    function fetch_city($state_id) {
        $this->db->where('state_id', $state_id);
        $this->db->order_by('city_name', 'ASC');
        $query = $this->db->get('city');
        $output = '<option value="">Select City</option>';
        foreach ($query->result() as $row) {
            $output.= '<option value="' . $row->city_id . '">' . $row->city_name . '</option>';
        }
        return $output;
    }
    function updateUserProfile($table, $db_data, $field, $id) {
        $this->db->where($field, $id);
        $result = $this->db->update($table, $db_data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where($field, $id);
        $dynamicdb->update($table, $db_data);
        return true;
    }
    /*PipeLine change status fucntion*/
    public function change_process_status($data, $id) {
        $data = array('work_status' => $_POST['processTypeId']);
        $this->db->where('id', $_POST['processId']);
        $this->db->update('work_detail', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $_POST['processId']);
        $dynamicdb->update('work_detail', $data);
        return true;
    }
    /*PipeLine change  order fucntion*/
    public function change_process_order($orders) {
        foreach ($orders as $order) {
            $id = $order['id'];
            if ($order['id'] == $id) {
                $data = array('order_id' => $order['position']);
                $this->db->where('id', $id);
                $this->db->update('work_detail', $data);
                $dynamicdb = $this->load->database('dynamicdb', TRUE);
                $data = array('order_id' => $order['position']);
                $dynamicdb->where('id', $id);
                $dynamicdb->update('work_detail', $data);
            }
        }
    }
    /*******************company filter in worker********************************/
    public function get_filter_details($table = '', $where = array(), $limit = '') {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $qry = $dynamicdb->get();
         //echo $this->db->last_query(); die();
        $result = $qry->result_array();
        return $result;
    }
    public function get_user_details($table = '', $where ) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where_in('u_id',$where);
        $qry = $dynamicdb->get();
         //echo $this->db->last_query(); die();
        $result = $qry->result_array();
        return $result;
    }
    /*change status in worker when click on toggle */
    public function toggle_change_status($id, $status) {
        #pre($id);
        #pre($status);
        $this->db->where('id', $id);
        $status = array('active_inactive' => $status);
        $this->db->update('worker', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        #$status = array('active_inactive' => $status);
        $dynamicdb->update('worker', $status);
        return true;
    }
    #For Worker Submodule
    public function get_data_byAddress($table, $where = array()) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $qry = $dynamicdb->get();
        $result = $qry->result_array();
        return $result;
        #echo $dynamicdb->last_query();
        
    }
    public function get_data_byId_wo($table, $field, $id) {
        //$dynamicdb = $this->load->database('dynamicdb', TRUE);
        //$table = $table?$table:$this->tablename;
        //if($table=="process_type"){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select($table . '.*,');
        $dynamicdb->from($table);
        //$this->db->join("user_detail", $table . ".id = user_detail.u_id", 'left');
        $dynamicdb->where($table . '.' . $field, $id);
        $qry = $dynamicdb->get();
        $result = $qry->row();
        return $result;
    }
    #Attandance Submodule Start
    public function xgetAllAttendance($where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `attendance`.`id`, `emp_id`, `atten_date`, `signin_time`, `signout_time`,  TRUNCATE(ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )/3600), 1) AS Hours,
        `user_detail`.`name` AS name
        FROM `attendance`
        LEFT JOIN `user_detail` ON `attendance`.`emp_id` = `user_detail`.`u_id`
        WHERE `attendance`.`status` = 'A' OR `attendance`.`status` = 'P' " . $where;
        $query = $dynamicdb->query($sql);
       //   echo $dynamicdb->last_query();die;
        $result = $query->result();
        return $result;
    }
     public function getAllAttendance($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
       $start = ($start-1) * $limit;
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('attendance.id,emp_id, atten_date, signin_time, signout_time' );
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $dynamicdb->join('user_detail', 'attendance.emp_id = user_detail.u_id', 'left');
        
		if($where2!='')
			{$dynamicdb->where($where2);
			}
		if(isset($_GET['sort'])){
		   
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		 $query = $dynamicdb->get();
		   //echo $dynamicdb->last_query();die; 
           $result = $query->result();
            return $result;

        
      /*  $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `attendance`.`id`, `emp_id`, `atten_date`, `signin_time`, `signout_time` 
        FROM `attendance`
        LEFT JOIN `user_detail` ON `attendance`.`emp_id` = `user_detail`.`u_id`
         WHERE    " . $where; 
     
        $query = $dynamicdb->query($sql);
     # echo $dynamicdb->last_query();die;    
       */
    }

      public function getWorkerAttendance($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
        $start = ($start-1) * $limit;
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('worker_attendance_new.*,worker.name');
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $dynamicdb->join('worker','worker_attendance_new.worker_id = worker.id', 'left');
       if($where2!='')
            {$dynamicdb->where($where2);
            }
        if(isset($_GET['sort'])){
           
            $sort=(string)$_GET['sort'];
            $dynamicdb->order_by('worker_attendance_new.id',$sort);
            }else{
                $dynamicdb->order_by('worker_attendance_new.id',$order);
            }
        if($export_data == 0){
                $dynamicdb->limit($limit, $start);
            }
        $query = $dynamicdb->get(); 
        $result = $query->result_array();
        return $result;
    }

       public function gettotalWorkerAttendance($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
        $start = ($start-1) * $limit;
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('worker_attendance_new.*,worker.name');
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $dynamicdb->join('worker','worker_attendance_new.emp_id = worker.id', 'left');
       if($where2!='')
            {$dynamicdb->where($where2);
            }
        if(isset($_GET['sort'])){
           
            $sort=(string)$_GET['sort'];
            $dynamicdb->order_by('worker_attendance_new.id',$sort);
            }else{
                $dynamicdb->order_by('worker_attendance_new.id',$order);
            }
              $dynamicdb->group_by('worker_attendance_new.emp_id');
        if($export_data == 0){
                $dynamicdb->limit($limit, $start);
            }
        $query = $dynamicdb->get(); 
        $result = $query->result_array();
        return $result;
    } 

    public function getAllAttendanceWork($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
		  $start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('`worker_attendance`.`id`, `emp_id`, `atten_date`, `signin_time`, `signout_time`,  TRUNCATE(ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )/3600), 1) AS Hours,name AS name' );
        $dynamicdb->from($table);
		//$dynamicdb->where('worker_attendance.status','A');
        $dynamicdb->where($where);
        $dynamicdb->join('worker','worker_attendance.emp_id = worker.id', 'left');
       if($where2!='')
			{$dynamicdb->where($where2);
			}
		if(isset($_GET['sort'])){
		   
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
				$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		$query = $dynamicdb->get(); 
         //pre($start);
       // echo $dynamicdb->last_query(); die;

		$result = $query->result();
		 //echo $dynamicdb->last_query();//die;    
		return $result;
       /* $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `worker_attendance`.`id`, `emp_id`, `atten_date`, `signin_time`, `signout_time`,  TRUNCATE(ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )/3600), 1) AS Hours,
         name AS name
       FROM `worker_attendance`
        LEFT JOIN `worker` ON `worker_attendance`.`emp_id` = `worker`.`id`
        WHERE `worker_attendance`.`status` = 'A'" . $where;
        $query = $dynamicdb->query($sql);
		 echo $dynamicdb->last_query();die;    
        $result = $query->result();
        return $result;*/
    }
    public function getDuplicateVal($emid, $date, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `attendance`
          WHERE `emp_id`='$emid' AND `atten_date`='$date'" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getDuplicateValWorker($emid, $date, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `worker_attendance`
          WHERE `emp_id`='$emid' AND `atten_date`='$date'" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function emselectByCode($emid, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `user_detail`
          WHERE `u_id`='$emid'" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function emselectByCodeWorker($emid, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `worker`
          WHERE `id`='$emid'" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function emEarnselectByLeave($emid, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `earned_leave` WHERE `em_id`='$emid' AND" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function emEarnselectByLeaveWorker($emid) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `earned_leave_worker` WHERE `em_id`='$emid' AND" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function UpdteEarnValue($emid, $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where('em_id', $emid);
        $this->db->update('earned_leave', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('em_id', $emid);
        $dynamicdb->update('earned_leave', $data);
        return true;
    }
    public function UpdteEarnValueWorker($emid, $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where('em_id', $emid);
        $this->db->update('earned_leave_worker', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('em_id', $emid);
        $dynamicdb->update('earned_leave_worker', $data);
        return true;
    }
    public function Add_AttendanceData($data) {
        $this->db->insert('attendance', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('attendance', $data);
        }
        return $rr;
    }
    public function Add_AttendanceDataWorker($data) {
        $this->db->insert('worker_attendance', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('worker_attendance', $data);
        }
        return $rr;
    }
    public function get_holiday_between_dates($day, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `holiday` WHERE ('$day' = `holiday`.`from_date`) OR ('$day' BETWEEN `holiday`.`from_date` AND `holiday`.`to_date`)" . $where;
        $query = $dynamicdb->query($sql);
        return $query->row();
    }
    public function get_holiday_between_datesWorker($day, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `worker_holiday` WHERE ('$day' = `worker_holiday`.`from_date`) OR ('$day' BETWEEN `worker_holiday`.`from_date` AND `worker_holiday`.`to_date`)" . $where;
        $query = $dynamicdb->query($sql);
        return $query->row();
    }
    public function Update_AttendanceData($id, $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where('id', $id);
        $this->db->update('attendance', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('attendance', $data);
    }
    public function Update_AttendanceDataWorker($id, $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where('id', $id);
        $this->db->update('worker_attendance', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('worker_attendance', $data);
    }
    #Leave Submodule Start
    public function GetAllHoliInfo($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$start = ($start-1) * $limit;
		$dynamicdb->select('*');
        $dynamicdb->from($table);
		$dynamicdb->where($where);
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
			$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
			$dynamicdb->limit($limit, $start);
			}

       // $sql = "SELECT * FROM `holiday`" . $where;
        //$query = $dynamicdb->query($sql);
		 $qry = $dynamicdb->get();
        $result = $qry->result();
        return $result;
    }
    public function Add_HolidayInfo($data) {
        $this->db->insert('holiday', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('holiday', $data);
        }
    }
    public function Update_HolidayInfo($id, $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where('id', $id);
        $this->db->update('holiday', $data);
        $dynamicdb = $this->load->database(   'dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('holiday', $data);
    }
   /* public function GetleavetypeInfo($where) {
       /* $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `leave_types` WHERE `status`='1'" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;*/
   
	   public function GetleavetypeInfo($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
		 $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$start = ($start-1) * $limit;
		$dynamicdb->select('*');
        $dynamicdb->from($table);
		$dynamicdb->where('status',1);
		$dynamicdb->where($where);
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
			$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
			$dynamicdb->limit($limit, $start);
			}

       // $sql = "SELECT * FROM `holiday`" . $where;
        //$query = $dynamicdb->query($sql);
		 $qry = $dynamicdb->get();
        //$sql = "SELECT * FROM `leave_types` WHERE `status`='1'" . $where;
        //$query = $dynamicdb->query($sql);
        $result = $qry->result();
        return $result;
    }
    public function Add_leave_Info($data) {
        $this->db->insert('leave_types', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('leave_types', $data);
        }
        return $rr;
    }
    public function Update_leave_Info($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('leave_types', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('leave_types', $data);
        return true;
    }
    public function AllLeaveAPPlication($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select(' `emp_leave`.*,
      `user_detail`.`u_id`,`user_detail`.`name`,
      `leave_types`.`id`,`emp_leave`.`id`,`leave_types`.`name` as leave_name' );
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $dynamicdb->join('user_detail','`emp_leave`.`em_id`=`user_detail`.`u_id`', 'left');
		$dynamicdb->join('leave_types','`emp_leave`.`typeid`=`leave_types`.`id`', 'left');
       if($where2!='')
			{$dynamicdb->where($where2);
			}
		if(isset($_GET['sort'])){
		   
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('emp_leave.id',$sort);
			}else{
				$dynamicdb->order_by('emp_leave.id',$order);
			}
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		$query = $dynamicdb->get(); 
		$result = $query->result();
		 //echo $dynamicdb->last_query(); die;    
		return $result;
     /*   $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `emp_leave`.*,
      `user_detail`.`u_id`,`user_detail`.`name`,
      `leave_types`.`id`,`emp_leave`.`id`,`leave_types`.`name` as leave_name
      FROM `emp_leave`
      LEFT JOIN `user_detail` ON `emp_leave`.`em_id`=`user_detail`.`u_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`id`
      WHERE " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;*/
    }
    public function AllLeaveAPPlicationWork($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
		$start = ($start-1) * $limit;
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('`work_leave`.*,`worker`.`id`,`worker`.`name`,`leave_types`.`id`,`work_leave`.`id`' );
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        $dynamicdb->join('worker','`work_leave`.`em_id`=`worker`.`id`', 'left');
		$dynamicdb->join('leave_types','`work_leave`.`typeid`=`leave_types`.`id`', 'left');
       if($where2!='')
			{$dynamicdb->where($where2);
			}
		if(isset($_GET['sort'])){
		   
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('work_leave.id',$sort);
			}else{
				$dynamicdb->order_by('work_leave.id',$order);
			}
		if($export_data == 0){
				$dynamicdb->limit($limit, $start);
			}
		$query = $dynamicdb->get(); 
		$result = $query->result();
		 //echo $dynamicdb->last_query();//die;    
		return $result;
        /*$dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `work_leave`.*,
      `worker`.`id`,`worker`.`name`,
      `leave_types`.`id`,`work_leave`.`id`
      FROM `work_leave`
      LEFT JOIN `worker` ON `work_leave`.`em_id`=`worker`.`id`
      LEFT JOIN `leave_types` ON `work_leave`.`typeid`=`leave_types`.`id`
      WHERE " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;*/
    }
    public function GetemassignLeaveType($emid, $id, $year, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `hour` FROM `assign_leave` WHERE `assign_leave`.`emp_id`='$emid' AND `type_id`='$id' AND `dateyear`='$year' AND";
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetleavetypeInfoid($id, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `leave_types` WHERE `status`='1' AND `id`='$id' AND" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    // Add the application of leave with ID no ID
    public function Application_Apply($data) {
        $this->db->insert('emp_leave', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('emp_leave', $data);
        }
        return $rr;
    }
    // Add the application of leave with ID no ID
    public function Application_Apply_Worker($data) {
        $this->db->insert('work_leave', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('work_leave', $data);
        }
        return $rr;
    }
    public function Application_Apply_Update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('emp_leave', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('emp_leave', $data);
        return true;
    }
    public function Application_Apply_Update_Worker($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('work_leave', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('work_leave', $data);
        return true;
    }
    public function updateAplicationAsResolved($id, $data) {
       //  pre($data); echo"mp"; die;
        $this->db->where('id', $id); 
        $this->db->update('emp_leave', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('emp_leave', $data);
    }
    public function updateAplicationAsResolvedWorker($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('work_leave', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('work_leave', $data);
    }
    public function determineIfNewLeaveAssign($employeeId, $type, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `assign_leave` WHERE `assign_leave`.`emp_id` = '$employeeId' AND `assign_leave`.`type_id` = '$type' AND" . $where;
        $query = $dynamicdb->query($sql);
        return $query->num_rows();
    }
    public function getLeaveTypeTotal($emid, $type, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT SUM(`hour`) AS 'totalTaken' FROM `assign_leave` WHERE `assign_leave`.`emp_id`='$emid' AND `assign_leave`.`type_id`='$type' AND" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function updateLeaveAssignedInfo($employeeID, $type, $data) {
        $this->db->where('type_id', $type);
        $this->db->where('emp_id', $employeeID);
        $this->db->update('assign_leave', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('type_id', $type);
        $dynamicdb->where('emp_id', $employeeID);
        $dynamicdb->update('assign_leave', $data);
    }
    public function insertLeaveAssignedInfo($data) {
        $this->db->insert('assign_leave', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('assign_leave', $data);
        }
        return $rr;
    }
    public function GetEarnedleaveBalance($where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `earned_leave`.*, `user_detail`.`name`,`user_detail`.`u_id` FROM `earned_leave` LEFT JOIN `user_detail` ON `earned_leave`.`em_id`=`user_detail`.`u_id` WHERE `earned_leave`.`hour` > 0 AND " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetEarnedleaveBalance1($where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `earned_leave`.*, `user_detail`.`name`,`user_detail`.`u_id` FROM `earned_leave` LEFT JOIN `user_detail` ON `earned_leave`.`em_id`=`user_detail`.`u_id` WHERE `earned_leave`.`present_date` > 0 AND " . $where."  order by id desc";
        $query = $dynamicdb->query($sql);
        $result = $query->result();
       # $dynamicdb->last_query();die;
        return $result;
    }
    // Add Earn leave with ID no ID
    public function Add_Earn_Leave($data) {
        $this->db->insert('earned_leave', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('earned_leave', $data);
        }
        return $rr;
    }
    // Payroll Starts
    public function getAllSalaryData($where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `pay_salary`.*,
              `user_detail`.`name`,`id`
              FROM `pay_salary`
              LEFT JOIN `user_detail` ON `pay_salary`.`emp_id`=`user_detail`.`u_id` where " . $where . "
              ORDER BY `pay_salary`.`month` DESC";
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAllSalaryDataById($id, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `pay_salary`.*,
              `user_detail`.`name`,`id`
              FROM `pay_salary`
              LEFT JOIN `user_detail` ON `pay_salary`.`emp_id`=`user_detail`.`u_id`
              WHERE `pay_salary`.pay_id = '$id' " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getEmployeeID($id, $where2) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `user_detail`.*,
      `user_detail`.`designation`,`user_detail`.`address1`,`user_detail`.`address2`,`user_detail`.`contact_no`,`user_detail`.`date_joining` 
      FROM `user_detail`
      LEFT JOIN `user` ON `user_detail`.`u_id`=`user`.`id`
      WHERE `user`.`id`='$id'" . $where2;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function Get_Salary_Value($id, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `emp_salary`.*,
      `addition`.*,
      `deduction`.*
      FROM `emp_salary`
      LEFT JOIN `addition` ON `emp_salary`.`id`=`addition`.`salary_id`
      LEFT JOIN `deduction` ON `emp_salary`.`id`=`deduction`.`salary_id`
      WHERE `emp_salary`.`emp_id`='$id' AND " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function Get_SalaryID($id, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `emp_salary`.*,
      `addition`.*,
      `deduction`.*
      FROM `emp_salary`
      LEFT JOIN `addition` ON `emp_salary`.`id`=`addition`.`salary_id`
      LEFT JOIN `deduction` ON `emp_salary`.`id`=`deduction`.`salary_id`
      WHERE `emp_salary`.`emp_id`='$id' AND " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetsalaryValueByID($eid, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `emp_salary`.*
      FROM `emp_salary`
      WHERE `emp_salary`.`emp_id`='$eid' AND " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        # echo $dynamicdb->last_query();
        return $result;
    }
    public function getAdditionDataBySalaryID($salaryID, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `addition`.*
              FROM `addition`
              WHERE `addition`.salary_id = '$salaryID' " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getDiductionDataBySalaryID($salaryID, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `deduction`.*
              FROM `deduction`
              WHERE `deduction`.salary_id = '$salaryID'" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getPinFromID($employeeID, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `id`
      FROM `user`
      WHERE `id` = '$employeeID' AND " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getNumberOfHolidays($month, $year, $where3) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT SUM(`number_of_days`) AS total_days
      FROM `holiday`
      WHERE MONTH(`from_date`)='$month' AND YEAR(`from_date`)='$year'" . $where3;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
        return $result;
    }
    public function totalHoursWorkedByEmployeeInAMonth($employeePIN, $start_date, $end_date, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT TRUNCATE((SUM(ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )))/3600), 1) AS Hours FROM `attendance` WHERE (`attendance`.`emp_id`='$employeePIN') AND (`atten_date` BETWEEN '$start_date' AND '$end_date')" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetsalaryType($where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT * FROM `salary_type` WHERE " . $where . " ORDER BY `salary_type` ASC";
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetAllSalary($where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `pay_salary`.*,
      `user_detail`.`name`,`user_detail`.`u_id`,
      `salary_type`.`salary_type`
      FROM `pay_salary`
      LEFT JOIN `user_detail` ON `pay_salary`.`emp_id`=`user_detail`.`u_id`
      LEFT JOIN `salary_type` ON `pay_salary`.`type_id`=`salary_type`.`id` where " . $where . " ORDER BY `pay_salary`.`pay_id` DESC";
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetDepEmployee($where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `user_detail`.*,
      `emp_salary`.`total`
      FROM `user_detail`
      LEFT JOIN `emp_salary` ON `user_detail`.`u_id`=`emp_salary`.`emp_id` where " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getSalaryRecord($emid, $month, $year, $where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT `pay_salary`.*
              FROM `pay_salary`
              WHERE `emp_id`='$emid' AND `month`='$month' AND `year`='$year' AND " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function updatePaidSalaryData($id, $data) {
        $this->db->where('pay_id', $id);
        $result1 = $this->db->update('pay_salary', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $$dynamicdb->where('pay_id', $id);
        $result = $dynamicdb->update('pay_salary', $data);
        return $result;
    }
    public function insertPaidSalaryData($data) {
        $rr = $this->db->insert('pay_salary', $data);
              $rr =     $this->db->insert_id();
        if ($rr) {
            $data['pay_id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('pay_salary', $data);
        }
        return $rr;
    }
    public function get_data1($table = '', $where = array(), $limit = '') {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where($where);
        if ($table == 'job_position') $dynamicdb->order_by('id', "desc");
        $qry = $dynamicdb->get();
        $result = $qry->result_array();
        return $result;
    }
    public function get_element_by_id($table, $field, $id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where($field, $id);
        $qry = $dynamicdb->get();
        $result = $qry->row();
        return $result;
    }
    public function get_list($table) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $qry = $dynamicdb->get();
        $result = $qry->result();
        return $result;
    }
    function get_status($table, $id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('status', $id);
        $query = $dynamicdb->get();
        //echo $dynamicdb->last_query();
        $result = $query->result_array();
        return $result;
    }
    function get_status_job($table, $id, $job_position_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('status', $id);
        $dynamicdb->where('job_position_id', $job_position_id);
        $query = $dynamicdb->get();
        $result = $query->result_array();
        return $result;
    }
 function get_status_pipeline($table, $id , $c_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('status', $id);
        $dynamicdb->where('created_by_cid', $c_id);
        $query = $dynamicdb->get();
        //echo $dynamicdb->last_query();
        $result = $query->result_array();
        return $result;
    }
    function get_status_job_pipeline($table, $id, $job_position_id ,$c_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('created_by_cid', $c_id);
        $dynamicdb->where('status', $id);
        $dynamicdb->where('job_position_id', $job_position_id);
        $query = $dynamicdb->get();
        $result = $query->result_array();
        return $result;
    }
    /*PipeLine change status function*/
    public function change_process_status1($table, $data, $id) {
        // print_r($data);die();
        $data = array('status' => $_POST['processTypeId']);
        $this->db->where('id', $_POST['processId']);
        $this->db->update($table, $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $_POST['processId']);
        $dynamicdb->update($table, $data);
        return true;
    }
    public function get_name($table, $name, $val) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('name', $name);
        $query = $dynamicdb->get();
        $result = $query->row($val);
        echo $result;
    }  
    public function get_name_by_id($table, $id, $val) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('*');
        $dynamicdb->from($table);
        $dynamicdb->where('id', $id);
        $query = $dynamicdb->get();
        $result = $query->row($val);
        echo $result;
    }
    public function chk_usr($table, $field, $val) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('count(*) as cnt');
        $dynamicdb->from($table);
        $dynamicdb->where($field, $val);
        $query = $dynamicdb->get();
        $result = $query->row('cnt');
		//echo  $dynamicdb->last_query();
        //pre($result);
        return $result;
    }
    public function insert_attachment_data($table, $data = array(), $type) {
        if (!empty($data)) {
            foreach ($data as $dt) {
                $fieldData = $this->get_field_type_data($dt, $table);
                $this->db->insert($table, $fieldData);
                $insertedid = $this->db->insert_id();
                if ($insertedid) {
                    if (!empty($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']->role != 3) {
                        $dynamicdb = $this->load->database('dynamicdb', TRUE);
                        $fieldData['id'] = $insertedid;
                        $dynamicInsertedid = $dynamicdb->insert($table, $fieldData);
                    }
                }
            }
            return $insertedid;
        }
    }
    public function get_attachmets($table, $where = '') {
        if ($_SESSION['loggedInUser']->role != 3) {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('*');
            $dynamicdb->from($table);
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
            $result = $qry->result_array();
            return $result;
        }
    }
     public function attachment_Update($attchid, $data) {
        $this->db->where('id', $attchid);
        $this->db->update('attachments', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $attchid);
        $dynamicdb->update('attachments', $data);
    }   
    public function insert($table, $data) {
        if ($table == 'quality_control_trans' || $table == 'inspection_report_trans' || $table == 'controlled_report_trans') {
            $this->db->insert($table, $data);
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $insert = $dynamicdb->insert($table, $data);
        } else {
            $fieldData = $this->get_field_type_data($data, $table);
            $this->db->insert($table, $fieldData);
            //echo $this->db->last_query();die();
            $insertedid = $this->db->insert_id();
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $fieldData['id'] = $insertedid;
            $dynamicdb->insert($table, $fieldData);
            $dynamicdb->insert_id();
            return $insertedid;
        }
    }

    public function bulk_Update($emid, $date, $data) {
        $this->db->where('emp_id', $emid);
        $this->db->where('atten_date', $date);
        $this->db->update('attendance', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('emp_id', $emid);
        $dynamicdb->where('atten_date', $date);
        $dynamicdb->update('attendance', $data);
    }
    public function get_production($c_id, $user_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        //$dynamicdb->select('`date`,`planning_id`,`shift`,`production_data`,`created_by_cid`');
        $dynamicdb->select('pd.*,pp.planning_data');
        $dynamicdb->from('production_data pd');
        $dynamicdb->join('production_planning pp', 'pp.id = pd.planning_id', 'left');
      #  $dynamicdb->join('production_planning pp', 'pp.id = pd.planning_id');
        $bb = "'";
        $cc = "'";
        $where = 'pd.created_by_cid = ' . $c_id . ' AND ' . '`pd.production_data` LIKE ' . $bb . '%\"worker_id\":[[\"' . $user_id . '\"]]%' . $cc . '';
        $dynamicdb->where($where);
        $dynamicdb->order_by("pd.id", "desc");
        //  $dynamicdb->where('JSON_CONTAINS(`production_data`, "' . $worker_id . '", `$.worker_id`)');
        $query = $dynamicdb->get();
        $result = $query->result_array();
     # echo $dynamicdb->last_query();
        //pre($result);die;
        return $result;
    }
    #Get WeekOff Days
    public function GetWeekOffInfo($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$start = ($start-1) * $limit;
		$dynamicdb->select('*');
        $dynamicdb->from($table);
		$dynamicdb->where($where);
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
			$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
			$dynamicdb->limit($limit, $start);
			}

       // $sql = "SELECT * FROM `holiday`" . $where;
        //$query = $dynamicdb->query($sql);
		 $qry = $dynamicdb->get();
        //$sql = "SELECT * FROM `leave_types` WHERE `status`='1'" . $where;
        //$query = $dynamicdb->query($sql);
        $result = $qry->result();
        return $result;
      //  $sql = "SELECT * FROM `worker_weekoff` " . $where;
       // $query = $dynamicdb->query($sql);
    }
    public function Add_WeekoffInfo($data) {
        $this->db->insert('worker_weekoff', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('worker_weekoff', $data);
        }
    }
    public function Update_WeekoffInfo($id, $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where('id', $id);
        $this->db->update('worker_weekoff', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('worker_weekoff', $data);
    }    
	//Employee
	   public function GetEmpWeekOffInfo($table = '', $where = array(),$limit,$start,$where2,$order,$export_data) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$start = ($start-1) * $limit;
		$dynamicdb->select('*');
        $dynamicdb->from($table);
		$dynamicdb->where($where);
		if($where2!=''){
		$dynamicdb->where($where2);
		}
		if(isset($_GET['sort'])){
			$sort=(string)$_GET['sort'];
			$dynamicdb->order_by('id',$sort);
			}else{
			$dynamicdb->order_by('id',$order);
			}
		if($export_data == 0){
			$dynamicdb->limit($limit, $start);
			}

       // $sql = "SELECT * FROM `holiday`" . $where;
        //$query = $dynamicdb->query($sql);
		 $qry = $dynamicdb->get();
        //$sql = "SELECT * FROM `leave_types` WHERE `status`='1'" . $where;
        //$query = $dynamicdb->query($sql);
        $result = $qry->result();
        return $result;
       // $sql = "SELECT * FROM `employee_weekoff` " . $where;
        //$query = $dynamicdb->query($sql);
        $result = $query->result();
        return $result;
    }
    public function Add_EmpWeekoffInfo($data) {
        $this->db->insert('employee_weekoff', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('employee_weekoff', $data);
			        }
		
    }
    public function Update_EmpWeekoffInfo($id, $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where('id', $id);
        $this->db->update('employee_weekoff', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('employee_weekoff', $data);
    }  
    public function Add_Rating($data) {
        $this->db->insert('job_applicant_rating', $data);
        $id = $this->db->insert_id();
        if ($id) {
            $data['id'] = $id;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('job_applicant_rating', $data);
        }
         return $id;
    }
    public function Update_Rating($id, $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where('id', $id);
        $this->db->update('job_applicant_rating', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update('job_applicant_rating', $data);
    }
    // Model End
    /* Function to fetch documents  by user Id */
    public function get_attachmets_by_UserId($table ,$field, $id,$rel_type="job_applicant_docs") {
        $this->db->select('*');    
        $this->db->from($table);
        $this->db->where($field, $id);
        $this->db->where('rel_type', $rel_type);
        $qry = $this->db->get();            
        $result = $qry->result_array(); 
        return $result;
    }
    public function approveJobPosition($data) {
        $this->db->where('id', $data['id']);        
        $approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '');
        $this->db->update('job_position', $approveData );
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $data['id']);       
        $approveData = array('approve' => $data['approve'],'validated_by' =>  $data['validated_by'] ,'disapprove' => 0 ,'disapprove_reason' => '');
        $dynamicdb->update('job_position', $approveData);
        return true;
    }
    
    public function disApprovePosition($data) {
        $this->db->where('id', $data['id']);        
       $approveData = array('approve' => 0,'validated_by' =>  $data['validated_by'] ,'disapprove' => 1, 'disapprove_reason' =>'');
        $this->db->update('job_position', $approveData );
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $data['id']);   
        $dynamicdb->update('job_position', $data );
        return true;
    }
	 public function approveStatusChange($id,$data,$table) {
        $this->db->where('id', $id);        
        $this->db->update($table, $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);       
        $dynamicdb->update($table, $data);
		//echo $dynamicdb->last_query();die();
        return true;
    }
    
    public function SubtractAssetStoke($table,$asset_qty,$id) {
        $this->db->set("in_stock", "in_stock - $asset_qty", FALSE)->where('id', $id)->update($table);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->set("in_stock", "in_stock - $asset_qty", FALSE)->where('id', $id)->update($table);
        return true;
    }   
    public function AddAssetStoke($table,$asset_qty,$id) {
        $this->db->set("in_stock", "in_stock + $asset_qty", FALSE)->where('id', $id)->update($table);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->set("in_stock", "in_stock + $asset_qty", FALSE)->where('id', $id)->update($table);
        return true;
    }
    public function change_asset_avaibility($table,$id, $status) {
        $this->db->where('id', $id);
      //  $status = array('status' => $status);
        $this->db->update($table, $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id);
        $dynamicdb->update($table, $status);
        return true;
    }

   function updateData($table, $db_data, $field, $id) {
        $this->db->where($field, $id);
        $result = $this->db->update($table, $db_data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where($field, $id);
        $dynamicdb->update($table, $db_data);
		 // echo $dynamicdb->last_query();die();
        return true;
    }
/*------server upload-----------*/
   public function get_user_data($c_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('user_detail.name,user_detail.u_id AS id' );
        $dynamicdb->from('user');
        
        $dynamicdb->where('user.c_id', $c_id);
        $dynamicdb->where('user.status', 1);
        $dynamicdb->join('user_detail','user.id = user_detail.u_id','Inner'); 
        $qry = $dynamicdb->get();
         $result = $qry->result_array();
         return $result;
    }
    
    public function GetAllHoliInfoEmp($c_id, $last_updated, $current_date) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $where = 'where holiday.created_by_cid = ' . $c_id . ' AND from_date BETWEEN "' . $last_updated . '" AND "' . $current_date . '"';
        $sql = "SELECT * FROM `holiday` " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
       //  echo $dynamicdb->last_query();die;
        return $result;
    }
      
       public function GetWeekOffInfoEmp($c_id) {
         
         $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $where = 'where employee_weekoff.created_by_cid = ' . $c_id;
        $sql = "SELECT * FROM `employee_weekoff`" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        # echo $dynamicdb->last_query();die;
        return $result;
    }
         public function GetWeekOffworker($c_id) {
         
         $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $where = 'where worker_weekoff.created_by_cid = ' . $c_id;
        $sql = "SELECT * FROM `worker_weekoff`" . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
        # echo $dynamicdb->last_query();die;
        return $result;
    }
 public function GetleaveStatusEmpGroup($c_id, $start_date , $end_date) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
     /*   $where = 'where emp_leave.created_by_cid = ' . $c_id . ' AND start_date BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND  em_id="'.$id.'"';*/
       $where = 'where created_by_cid = "' . $c_id . '" AND start_date >= "'.$start_date.'"  AND   start_date <= "'.$end_date.'"' ; 
        $sql = "SELECT count(leave_status) as status_count, em_id as emp_id, (CASE when (leave_status = 'Approve') THEN 'leave' ELSE 'absent' END ) as attendance_status FROM emp_leave " .$where. "  GROUP BY em_id, leave_status";
         
        $query = $dynamicdb->query($sql);
        $result = $query->result_array();
       //  echo $dynamicdb->last_query();die;
        return $result;
    }
public function GetAttendanceStatusEmpGroup(  $start_date , $end_date) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
     /*   $where = 'where emp_leave.created_by_cid = ' . $c_id . ' AND start_date BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND  em_id="'.$id.'"';*/
       $where = 'where atten_date  >= "'.$start_date.'"  AND   atten_date  <= "'.$end_date.'"' ; 
        $sql = "SELECT count(status) as status_count, emp_id, (CASE when (status = 'P') THEN 'present' ELSE 'absent' END )  as attendance_status 
        FROM attendance  " .$where. "  GROUP BY emp_id, status";
         
        $query = $dynamicdb->query($sql);
        $result = $query->result_array();
        // echo $dynamicdb->last_query();die;
        return $result;
    }
public function get_user_data_activeStatus($u_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('user_detail.name,user_detail.u_id AS id' );
        $dynamicdb->from('user');
        $dynamicdb->where('user.status', 1);
        $dynamicdb->where('user_detail.u_id',$u_id);
        $dynamicdb->join('user_detail','user.id = user_detail.u_id','Inner'); 
        $qry = $dynamicdb->get();
     //  echo $this->db->last_query();exit;
        $result = $qry->row();
        return $result;
    }
    
 public function GetEmpCodeData_date($c_id, $start_date, $end_date,$biometric_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $where = 'where   date BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND punchingcode = '.$biometric_id.'';
        $xwhere = 'where attendance.created_by_cid = ' . $c_id . ' AND  date BETWEEN "' . $start_date. '" AND "' . $end_date  . '" AND punchingcode = '.$biometric_id.'';
        $sql = "SELECT * FROM `tblt_timesheet` " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
    #echo $dynamicdb->last_query();die;
        return $result;
    } 
     public function get_latest_updated_record($where) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql = "SELECT  MAX( attendance.created_date ) AS latest_updated
        FROM `attendance` WHERE    " . $where;
     
        $query = $dynamicdb->query($sql);
        // echo $dynamicdb->last_query();die;      
        $result = $query->row();
        return $result;
    }
     public function checkExcel_AttendanceData($where) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where($where);
        $query = $this->db->get('attendance');
        $rows_count  =  $query->num_rows();
        return $rows_count; 
    }
     public function excelUpdate_AttendanceData($where , $data) {
        $this->load->database('dynamicdb', TRUE);
        $this->db->where($where);
        $this->db->update('attendance', $data);
      
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where($where);
        $dynamicdb->update('attendance', $data);
      #  echo  $dynamicdb->last_query(); 
        return 1;
    }
    
     public function  calculate_salary_frm_slab( $c_id, $salary,$start_date ,$end_date) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
         /*AND '.$salary.' <= salary_to  '*/
         
        $where = 'where salary_slab.created_by_cid = ' . $c_id . ' AND  "'.$salary.'" >=  salary_from   AND "'.$salary.'" <=  salary_to AND status = 1  AND  "'.$start_date.'" >= slab_start_date AND "'.$end_date.'" <= slab_end_date ' ;
        $sql = "SELECT * FROM `salary_slab` " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
           # echo $dynamicdb->last_query();die;
         return $result;
    }
   /* "' . $start_date. '" BETWEEN slab_start_date AND slab_end_date'*/
    public function  calculate_salary_frm_slab_f( $c_id, $salary,$start_date ,$end_date) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
         /*AND '.$salary.' <= salary_to  '*/
        $where = 'where salary_slab.created_by_cid = ' . $c_id . ' AND  "' . $salary. '" BETWEEN salary_from AND salary_to  AND status = 1 AND "' . $start_date. '" BETWEEN slab_start_date AND slab_end_date AND  "' . $end_date. '" BETWEEN slab_start_date AND slab_end_date' ;
        $sql = "SELECT * FROM `salary_slab` " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
         // echo $dynamicdb->last_query();die;
         return $result;
    }
     public function  xcalculate_salary_frm_slab_f( $c_id, $salary,$start_date ,$end_date) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
         /*AND '.$salary.' <= salary_to  '*/
        $where = 'where salary_slab.created_by_cid = ' . $c_id . ' AND  "'.$salary.'" >=  salary_from   AND "'.$salary.'" <=  salary_to AND status = 1 AND "' . $start_date. '" BETWEEN slab_start_date AND slab_end_date AND  "' . $end_date. '" BETWEEN slab_start_date AND slab_end_date' ;
        $sql = "SELECT * FROM `salary_slab` " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->row();
         echo $dynamicdb->last_query();die;
         return $result;
    }
    
    public function check_duplicate($name, $table,$cid)
    {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('name',$name);
		 $dynamicdb->where('created_by_cid',$cid);
        $result = $dynamicdb->get($table)->num_rows();
        return $result;
    } 
    
     public function add_emp_leave($data) {
        $this->db->insert('emp_leave_bal', $data);
        $rr = $this->db->insert_id();
        if ($rr) {
            $data['id'] = $rr;
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('emp_leave_bal', $data);
        }
        return $rr;
    }
    
     public function Update_emp_leave($leave_id, $data) {
        $this->db->where('leave_id', $leave_id);
        $this->db->update('emp_leave_bal', $data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('leave_id', $leave_id);
        $dynamicdb->update('emp_leave_bal', $data);
        return true;
    }
    
    public function get_emp_leave_bal($employeeID, $leave_id, $c_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('leave_id', $leave_id);
        $dynamicdb->where('status', '1');
        $dynamicdb->where('emp_id', $employeeID);
        $dynamicdb->where('created_by_cid', $c_id);
        $qry = $dynamicdb->get('emp_leave_bal');
        $result = $qry->row();
        return $result;
    }
    
    public function update_emp_leave_bal($employeeID, $leave_id, $c_id , $data) {
         $this->db->where('leave_id', $leave_id);
        $this->db->where('emp_id', $employeeID);
        $this->db->where('created_by_cid', $c_id);
        $this->db->update('emp_leave_bal', $data); 
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('leave_id', $leave_id);
        $dynamicdb->where('emp_id', $employeeID);
        $dynamicdb->where('created_by_cid', $c_id);
        $dynamicdb->update('emp_leave_bal', $data);
    }
    
     public function get_emp_leave_per_emp($employeeID, $c_id) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('emp_id', $employeeID);
        $dynamicdb->where('status', '1'); 
        $dynamicdb->where('created_by_cid', $c_id);
        $qry = $dynamicdb->get('emp_leave_bal');
        $result = $qry->result();
        return $result;
    }
     public function get_emp_leave_per_emp_date_wise($employeeID, $c_id,$report_start_date,$report_end_date) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('em_id', $employeeID);
        $dynamicdb->where('leave_status', 'Approve'); 
        $dynamicdb->where('start_date >= ',$report_start_date);
        $dynamicdb->where('end_date <= ',$report_end_date);
        $dynamicdb->where('created_by_cid', $c_id);
        $qry = $dynamicdb->get('emp_leave');
        $result = $qry->result();
        return $result;
    }
    
     public function Get_type_of_leave_check($month ,$year,$c_id ,$typeid ,$emp_id ) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
     /*   $where = 'where emp_leave.created_by_cid = ' . $c_id . ' AND start_date BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND  em_id="'.$id.'"';*/
     #  $where = 'where created_by_cid = "' . $c_id . '" AND start_date >= "'.$start_date.'"  AND   end_date <= "'.$end_date.'"' ;  where year(datefield) = 2017 and month(datefield) = 10 
        $where = 'where em_id ='.$emp_id.' and typeid='.$typeid.' AND created_by_cid = ' . $c_id . ' AND year(start_date) = "'.$year.'" and month(start_date) = "'.$month.'" '; /*  "'.$start_date.'"  BETWEEN  start_date AND  end_date';*/
        $sql = "SELECT *  
        FROM emp_leave " .$where. "   ";
         
        $query = $dynamicdb->query($sql);
      #  $result = $query->result_array();
         $result = $query->num_rows();
     # echo $dynamicdb->last_query();die;
        return $result;
    }
    
    public function get_email_admin_data($c_id)
    {
         $dynamicdb = $this->load->database('dynamicdb', TRUE);
      #  $dynamicdb->where('emp_id', $employeeID);
        $dynamicdb->where('role', '1'); 
        $dynamicdb->where('c_id', $c_id);
        $qry = $dynamicdb->get('user');
        $result = $qry->result();
        return $result;
    }
    
    
    
    public function get_email_hr_data($c_id)
    {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('user.email as hr_email');
            $dynamicdb->from('user_detail');
            $dynamicdb->where('user.status', '1');
            $dynamicdb->where('user.role', '2');
            $dynamicdb->where('user.hr_permissions', '1');
            $dynamicdb->where('user.c_id', $c_id); 
            $dynamicdb->join('user', 'user.id = user_detail.u_id');
            $qry = $dynamicdb->get();
            $resultx = $qry->result();
           // echo $dynamicdb->last_query(); 
            return $resultx;
    }
    
     public function get_emp_leave_Balance($c_id)
    {
            $todays_date = date('Y-m-d');
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
          #  $dynamicdb->where('emp_id', $emp_id);
            $dynamicdb->where('status', '1'); 
            $dynamicdb->where('created_by_cid', $c_id);
            $dynamicdb->where('start_date <=', $todays_date );
            $dynamicdb->where('end_date >=', $todays_date );
            $qry = $dynamicdb->get('emp_leave_bal');
            $result = $qry->result();
            return $result;
    }
    public function get_no_of_leave_empwise($c_id,$emp_id,$leave_id )
    {
            $todays_date = date('Y-m-d');
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
        
            $dynamicdb->where('leave_id', $leave_id); 
            $dynamicdb->where('emp_id', $emp_id); 
            $dynamicdb->where('status', '1'); 
            $dynamicdb->where('created_by_cid', $c_id);
            $dynamicdb->where('start_date <=', $todays_date );
            $dynamicdb->where('end_date >=', $todays_date );
            $qry = $dynamicdb->get('emp_leave_bal');
            $result = $qry->row();
            return $result;
    }
    
    
      public function leave_update($c_id,$emp_id,$leave_id,$data,$final_closing_bal )
    {
          $data  = array(
                        'opening_bal' => $data,
                        'closing_bal' => $final_closing_bal
                        );
              /*  echo "model";        
               pre($data);die;     */    
                       
             $this->db->where('leave_id', $leave_id);
        $this->db->where('emp_id', $emp_id);
        $this->db->where('created_by_cid', $c_id);
        $this->db->update('emp_leave_bal', $data); 
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('leave_id', $leave_id);
        $dynamicdb->where('emp_id', $emp_id);
        $dynamicdb->where('created_by_cid', $c_id);
        $dynamicdb->update('emp_leave_bal', $data);
            # echo $dynamicdb->last_query();die;
    }
    
    public function count_no_of_leave_empwise($c_id,$emp_id,$leave_id )
    {
            $todays_date = date('Y-m-d');
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
        
            $dynamicdb->where('leave_id', $leave_id); 
            $dynamicdb->where('emp_id', $emp_id); 
            $dynamicdb->where('status', '1'); 
            $dynamicdb->where('created_by_cid', $c_id);
            $dynamicdb->where('start_date <=', $todays_date );
            $dynamicdb->where('end_date >=', $todays_date );
            $qry = $dynamicdb->get('emp_leave_bal');
            $result = $qry->result();
          #  $result = $qry->num_rows();
            return $result;
    }
    
     public function leave_insert_emp_wise($data)
    {
        
           $this->db->insert('emp_leave_bal', $data);
           $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->insert('emp_leave_bal', $data);
    }
    
    
    
    public function check_tbl_by_id($table , $id, $field_name)
    {
         $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where($field_name,$id);
        $result = $dynamicdb->get($table)->num_rows();
       # echo $dynamicdb->last_query();die;
        return $result;
    }
	/*Task List Work Start*/
	 public function get_table_data($table){
          $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('created_by_cid', $this->companyGroupId );
            $dynamicdb->where('status', '1');
            $dynamicdb->order_by("sequence_id", "asc");
            $qry = $dynamicdb->get($table);
            $result = $qry->result();
            return $result;
        
    }
    public function get_table_data1($table){
          $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('created_by_cid', $this->companyGroupId );
            $qry = $dynamicdb->get($table);
            $result = $qry->result();
            return $result;
        
    }

      public function get_task_list($table,$where=array()){
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$dynamicdb->select('*');
			$dynamicdb->from($table);
			$dynamicdb->where($where);
			$qry = $dynamicdb->get();
			$result = $qry->result();
           // echo $dynamicdb->last_query();
            return $result;
    }
    public function get_assignee_id($table,$where=array()){
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('assignee');
            $dynamicdb->from($table);
            $dynamicdb->where($where);
            $qry = $dynamicdb->get();
			 // echo $dynamicdb->last_query();die;
            $result = $qry->row('assignee');
          
            return $result;
    }
	
	function updatePipelineData($table,$data,$where){
		$this->db->where($where);
        $result = $this->db->update($table,$data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where($where);
        $dynamicdb->update($table,$data);
		//echo $this->db->last_query();die;
        return true;
	}
	
    public function get_table_data3($table){
          $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('created_by_cid', $this->companyGroupId );
            $qry = $dynamicdb->get($table);
            $result = $qry->result_array();
            return $result;
        
    }
    
    public function get_table_data2($table){
           $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('created_by_cid', $this->companyGroupId );
            $dynamicdb->where('status', '1');
            $dynamicdb->order_by("sequence_id", "asc");
            $qry = $dynamicdb->get($table);
			// 
            $result = $qry->result_array();
            return $result;
        
    }
      public function check_transition_data($table,$id){
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$dynamicdb->where('created_by_cid', $this->companyGroupId );
		$dynamicdb->where('pipeline_id', $id);
		$qry = $dynamicdb->get($table);
		// echo $dynamicdb->last_query();die;
		$result    = $qry->num_rows();
		return $result;
        
    }
    
   

 
    public function check_tbl_by_id2($table , $c_id) // check if any record exist
    {
         $dynamicdb = $this->load->database('dynamicdb', TRUE);
               $dynamicdb->where('created_by_cid',$c_id);
        $result = $dynamicdb->get($table)->num_rows();
      // echo $dynamicdb->last_query();die;
        return $result;
    }  
   
  public function check_tbl_by_id3($table ,$pipeline_id ,$col_id , $c_id) // check if any record exist
    {
	   $dynamicdb = $this->load->database('dynamicdb', TRUE);
	   $dynamicdb->where('pipeline_id',$pipeline_id);
	   $dynamicdb->where('col_id',$col_id);
	   $dynamicdb->where('created_by_cid',$c_id);
	   $result = $dynamicdb->get($table)->num_rows();
       return $result;
    }  
   
  function updateData3($table, $db_data, $field, $id, $field1, $id1,$field2, $id2) {
        $this->db->where($field, $id);
        $this->db->where($field1, $id1);
        $this->db->where($field2, $id2);
        $result = $this->db->update($table, $db_data);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where($field, $id);
        $dynamicdb->where($field1, $id1);
        $dynamicdb->where($field2, $id2);
        $dynamicdb->update($table, $db_data);
        // echo $dynamicdb->last_query();die;
        
        return true;
    }
    
   
  function getData_two_para($table,  $field, $id, $field1, $id1) {
        
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where($field, $id);
        $dynamicdb->where($field1, $id1);
        
        $qry = $dynamicdb->get($table);
        $result = $qry->row();
        return $result;
        
       //  echo $dynamicdb->last_query();die;
        
       
    }
     public function get_transition_data($table,$id){
           $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('created_by_cid', $this->companyGroupId );
            $dynamicdb->where('pipeline_id', $id);
            $qry = $dynamicdb->get($table);
        $result    = $qry->row();
            return $result;
        
    } 
    
   public function get_role_data($table,$id){
           $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('created_by_cid', $this->companyGroupId );
            $dynamicdb->where('role_id', $id);
            $qry = $dynamicdb->get($table);
        $result    = $qry->row();
            return $result;
        
    } 
    

public function update_activation($table,$db_data,$field,$id) {
    $data = $db_data;
    $this->db->where($field, $id);      
    $this->db->update($table, $data);
    $dynamicdb = $this->load->database('dynamicdb', TRUE);
    $dynamicdb->where($field, $id);     
    $dynamicdb->update($table, $data);
    #echo $dynamicdb->last_query();die();     
    return TRUE;
}

public function truncate_tbl_data($table) {
  
    $this->db->truncate($table);
    $dynamicdb = $this->load->database('dynamicdb', TRUE);
    $dynamicdb->truncate($table);
    
    return TRUE;
}

   
    public function get_all_task_iist($c_id, $last_updated, $current_date) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $where = 'where new_work_detail.created_by_cid = ' . $c_id . ' AND start_date BETWEEN "' . $last_updated . '" AND "' . $current_date . '"';
        $sql = "SELECT * FROM `new_work_detail` " . $where;
        $query = $dynamicdb->query($sql);
        $result = $query->result();
      //  echo $dynamicdb->last_query();die;
        return $result;
    }
    
     public function get_active_user($c_id,$u_id)
    {
          
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->select('user_detail.name,user_detail.u_id AS id' );
        $dynamicdb->from('user');
        
        $dynamicdb->where('user.c_id', $c_id);
        $dynamicdb->where('user.status', 1);
        $dynamicdb->where('user.role', 2);
        $dynamicdb->where('user.id', $u_id);
        $dynamicdb->join('user_detail','user.id = user_detail.u_id','Inner'); 
        $qry = $dynamicdb->get();
         $result = $qry->result_array();
         return $result;
    }
    
	/*Task List Work End*/
	public function get_Companydata($table = '' , $where = array()) {
		$dynamicdb = $this->load->database('dynamicdb', TRUE);
		$this->tablename = $table?$table:$this->tablename;
		$dynamicdb->select('*'); 
		$dynamicdb->from($this->tablename);
		$dynamicdb->where($where);
		$qry = $dynamicdb->get();
		#echo $dynamicdb->last_query();
		$result = $qry->result_array();			
		return $result;
	}
	Public Function update_SupervisorSettings($table,$check_on_of,$login_company_id){
		if($check_on_of != '' ){
			$update_emails = $this->db->query("update `".$table."` SET `workerSupervisor_setting` ='".$check_on_of."' where `id` = '".$login_company_id."'");
			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$update_emails = $dynamicdb->query("update `".$table."` SET `workerSupervisor_setting` ='".$check_on_of."' where `id` = '".$login_company_id."'");
		}
		return $update_emails;
	}
	Public Function update_workerdataSettings($table,$check_on_of,$login_company_id){
		
		if($check_on_of != '' ){
			$update_emails = $this->db->query("update `".$table."` SET `hrm_worker_data` ='".$check_on_of."' where `id` = '".$login_company_id."'");
			
			$dynamicdb = $this->load->database('dynamicdb', TRUE);
			$update_emails = $dynamicdb->query("update `".$table."` SET `hrm_worker_data` ='".$check_on_of."' where `id` = '".$login_company_id."'");
		}
		return $update_emails;
	}

    Public Function update_npdm_setting($table,$check_on_of,$login_company_id){
        if($check_on_of != '' ){
            $update_emails =$this->db->query("update `".$table."` SET `npdm_on_off` ='".$check_on_of."' where `id` = '".$login_company_id."'");
            
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $update_emails = $dynamicdb->query("update `".$table."` SET `npdm_on_off` ='".$check_on_of."' where `id` = '".$login_company_id."'");
        }
        return $update_emails;
    }
//25 ASS
    public function disApprove_ta_da($data) {
        $this->db->where('id', $data['id']);        
        //$approveData = array('approve' => 0,'validated_by' =>  $data['validated_by'] ,'disapprove' => 1, 'disapprove_reason' =>'');
        $this->db->update('travel_info', $data );
       //   echo $this->db->last_query();die;
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $data['id']);
        $dynamicdb->update('travel_info', $data );
        return true;
    }
     public function get_worker_data( $table,$where ) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT * FROM {$table} WHERE {$where}";
        $query = $dynamicdb->query($sql);
          // echo $dynamicdb->last_query();   
        return $query->result_array();
    }
         public function get_worker_data2( $table,$where ) {
         
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $sql ="SELECT production_data FROM {$table} WHERE {$where}";
        $query = $dynamicdb->query($sql);
         //echo $dynamicdb->last_query(); die;
        return $query->result_array();
    }
  
  public function change_status_hr_permissions($id, $status) {
        
        // pre($valueid); die;
        $this->db->where_in('id', $id);
        $status = array('hr_permissions' => $status);
       // echo $this->db->last_query(); die;
        $this->db->update('user', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where_in('id', $id);
     // echo $this->dynamicdb->last_query(); die;
        $dynamicdb->update('user', $status);
        return true;
    }  
      public function change_status_tada_permissions($id, $status) {
        
        // pre($valueid); die;
        $this->db->where_in('id', $id);
        $status = array('tatdsand_mail_permissions' => $status);
       // echo $this->db->last_query(); die;
        $this->db->update('user', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where_in('id', $id);
     // echo $this->dynamicdb->last_query(); die;
        $dynamicdb->update('user', $status);
        return true;
    }  
    public function change_status_tada_permissionsAcount($id, $status) {
        
        // pre($valueid); die;
        $this->db->where_in('id', $id);
        $status = array('tatdsand_mail_permissions_account' => $status);
       // echo $this->db->last_query(); die;
        $this->db->update('user', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where_in('id', $id);
     // echo $this->dynamicdb->last_query(); die;
        $dynamicdb->update('user', $status);
        return true;
    }

    public function get_worker_supervisor($id){
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->where('id', $id); 
            $qry = $dynamicdb->get('worker');
            $result = $qry->row('suervisorID');
            echo $result;
    }
    
  public function get_compdata($table = '' , $where = array()) {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $this->tablename = $table?$table:$this->tablename;
        $dynamicdb->select('*'); 
        $dynamicdb->from($this->tablename);
        $dynamicdb->where($where);
        $qry = $dynamicdb->get();
        #echo $dynamicdb->last_query();
        $result = $qry->result_array();         
        return $result;
    }
     public function Worker_ot_salary($id, $status) {   
        $this->db->where('id', $id);
        $status = array('hrm_worker_ot_salary' => $status);
        $this->db->update('company_detail', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id); 
        $dynamicdb->update('company_detail', $status);
        return true;
    }
/*------server upload-----------*/
  public function empWorkingHrsM($id, $status) {   
        $this->db->where('id', $id);
        $status = array('empWorkingHrs' => $status);
        $this->db->update('company_detail', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id); 
        $dynamicdb->update('company_detail', $status);
        return true;
    }
    public function worker_month_off($id, $status) {   
        $this->db->where('id', $id);
        $status = array('worker_week_off' => $status);
        $this->db->update('company_detail', $status);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('id', $id); 
        $dynamicdb->update('company_detail', $status);
        return true;
    }

   public  function updateWhere($table,$data,$where){
        $this->db->update($table,$data,$where);
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->update($table,$data,$where);
    }
    public function importworker($data) {
        // pre($data); die('jk');
        $res = $this->db->insert_batch('worker',$data);
           
         if($_SESSION['loggedInUser']->role != 3){
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $res = $dynamicdb->insert_batch('worker',$data);
        }    
         if($res){
         return TRUE;
         }
         else{
         return FALSE;
       }
   }
    public function attendance_Excel_dummys($data) {
      
        $res = $this->db->insert_batch('attendance_Excel_dummy',$data);
        if($_SESSION['loggedInUser']->role != 3){
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $res = $dynamicdb->insert_batch('attendance_Excel_dummy',$data);
    }
         
         if($res){
         return TRUE;
         }
         else{
         return FALSE;
       }
   }
  public function getUserEmailID($table, $ids) {
        if (!empty($_SESSION['loggedInUser'])) {
            $this->db->select('email');
            $this->db->from($table);
            $this->db->where_in('id', $ids);
            $qry = $this->db->get();
        } else {
            $dynamicdb = $this->load->database('dynamicdb', TRUE);
            $dynamicdb->select('email');
            $dynamicdb->from($table);
            $dynamicdb->where_in('id', $ids);
            $qry = $dynamicdb->get();
        }
        // echo $dynamicdb->last_query();
        // die;
        $result = $qry->result_array();
        return $result;
    }
     public function get_Userlist($c_id)
    {
        $dynamicdb = $this->load->database('dynamicdb', TRUE);
        $dynamicdb->where('c_id', $c_id);
        $qry = $dynamicdb->get('user');
        $result = $qry->result();
        return $result;
    }
     
     public function updateAttendanceData($where, $data) {
        $dynamicdb =  $this->load->database('dynamicdb', TRUE);
        $this->db->where($where);
        $this->db->update('attendance', $data);
        $dynamicdb->where($where);
        $dynamicdb->update('attendance', $data);
    }
     public function updateAttendanceWorker($where, $data) {
        $dynamicdb =  $this->load->database('dynamicdb', TRUE);
        $this->db->where($where);
        $this->db->update('worker_attendance', $data);
        $dynamicdb->where($where);
        $dynamicdb->update('worker_attendance', $data);
    }
}// main

