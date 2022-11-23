<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Condition_Set')):

class WCFE_Condition_Set {
	const LOGIC_AND = 'and';
	const LOGIC_OR  = 'or';
	
	public $logic = self::LOGIC_AND;
	public $conditions = array();
	
	public function __construct() {
		
	}	
	
	public function add_condition($condition){
		if(THWCFE_Utils_Condition::is_valid_condition($condition)){
			$this->conditions[] = $condition;
		} 
	}
	
	public function set_logic($logic){
		$this->logic = $logic;
	}	
	public function get_logic(){
		return $this->logic;
	}
		
	public function set_conditions($conditions){
		$this->conditions = $conditions;
	}	
	public function get_conditions(){
		return $this->conditions; 
	}	
}

endif;