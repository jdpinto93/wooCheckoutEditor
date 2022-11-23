<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Condition_Rule_Set')):

class WCFE_Condition_Rule_Set {
	const LOGIC_AND = 'and';
	const LOGIC_OR  = 'or';
	
	public $logic = self::LOGIC_OR;
	public $condition_rules = array();
	
	public function __construct() {
		
	}	
	
	public function add_condition_rule($condition_rule){
		if(isset($condition_rule) && $condition_rule instanceof WCFE_Condition_Rule){
			$this->condition_rules[] = $condition_rule;
		} 
	}
	
	public function set_logic($logic){
		$this->logic = $logic;
	}	
	public function get_logic(){
		return $this->logic;
	}
		
	public function set_condition_rules($condition_rules){
		$this->condition_rules = $condition_rules;
	}	
	public function get_condition_rules(){
		return $this->condition_rules; 
	}	
}

endif;