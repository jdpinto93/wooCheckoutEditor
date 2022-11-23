<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Condition')):

class WCFE_Condition {
	const PRODUCT = 'product';
	const PRODUCT_VARIATION = 'product_variation';
	const CATEGORY = 'category';
	const FIELD = 'field';
	
	const USER_ROLE_EQ = 'user_role_eq';
	const USER_ROLE_NE = 'user_role_ne';
	
	const CART_CONTAINS = 'cart_contains'; 
	const CART_NOT_CONTAINS = 'cart_not_contains'; 
	const CART_ONLY_CONTAINS = 'cart_only_contains';
	
	const CART_TOTAL_EQ = 'cart_total_eq'; 
	const CART_TOTAL_GT = 'cart_total_gt'; 
	const CART_TOTAL_LT = 'cart_total_lt';
	
	const CART_SUBTOTAL_EQ = 'cart_subtotal_eq'; 
	const CART_SUBTOTAL_GT = 'cart_subtotal_gt'; 
	const CART_SUBTOTAL_LT = 'cart_subtotal_lt';
		
	const VALUE_EMPTY = 'empty';
	const VALUE_NOT_EMPTY = 'not_empty';
	
	const VALUE_EQ = 'value_eq';
	const VALUE_NE = 'value_ne'; 
	const VALUE_GT = 'value_gt'; 
	const VALUE_LT = 'value_le';
	
	public $operand_type = '';
	public $operand = '';
	public $operator = '';
	public $value = '';
	
	public $show_when_str = '';
		
	public function __construct() {
		
	}
	
	public function set_property($name, $value){
		if(property_exists($this, $name)){
			$this->$name = $value;
		}
	}
	
	public function get_property($name){
		if(property_exists($this, $name)){
			return $this->$name;
		}else{
			return '';
		}
	}
}

endif;