<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_DatePicker')):

class WCFE_Checkout_Field_DatePicker extends WCFE_Checkout_Field{
		
	public $default_date = '';
	public $date_format = '';
	public $min_date = '';
	public $max_date = '';
	public $year_range = '';
	public $number_of_months = '';
	public $disabled_days = array();
	public $disabled_dates = array();
	
	public function __construct() {
		$this->type = 'datepicker';
	}	
	
	public function prepare_field($name, $field){
		if(!empty($field) && is_array($field)){
			parent::prepare_field($name, $field);
			
			$this->set_property('default_date', isset($field['default_date']) ? $field['default_date'] : '');
			$this->set_property('date_format', isset($field['date_format']) ? $field['date_format'] : '');
			$this->set_property('min_date', isset($field['min_date']) ? $field['min_date'] : '');
			$this->set_property('max_date', isset($field['max_date']) ? $field['max_date'] : '');
			$this->set_property('year_range', isset($field['year_range']) ? $field['year_range'] : '');
			$this->set_property('number_of_months', isset($field['number_of_months']) ? $field['number_of_months'] : '');
			$this->set_property('disabled_days', isset($field['disabled_days']) ? $field['disabled_days'] : array());
			$this->set_property('disabled_dates', isset($field['disabled_dates']) ? $field['disabled_dates'] : '');
		}
	}
}

endif;