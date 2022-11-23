<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_TimePicker')):

class WCFE_Checkout_Field_TimePicker extends WCFE_Checkout_Field{
	public $min_time = '';
	public $max_time = '';
	public $start_time = '';
	public $time_step = '';
	public $time_format = '';
	public $linked_date = '';
	
	public function __construct() {
		$this->type = 'timepicker';
	}	
	
	public function prepare_field($name, $field){
		if(!empty($field) && is_array($field)){
			parent::prepare_field($name, $field);
			
			$this->set_min_time( isset($field['min_time']) ? $field['min_time'] : '' );
			$this->set_max_time( isset($field['max_time']) ? $field['max_time'] : '' );
			$this->set_start_time( isset($field['start_time']) ? $field['start_time'] : '' );
			$this->set_time_step( isset($field['time_step']) ? $field['time_step'] : '' );
			$this->set_time_format( isset($field['time_format']) ? $field['time_format'] : '' );
			$this->set_linked_date( isset($field['linked_date']) ? $field['linked_date'] : '' );
		}
	}

	
   /**********************************
	**** Setters & Getters - START ****
	***********************************/
	public function set_min_time($min_time){
		$this->min_time = $min_time;
	}
	public function set_max_time($max_time){
		$this->max_time = $max_time;
	}
	public function set_start_time($start_time){
		$this->start_time = $start_time;
	}
	public function set_time_step($time_step){
		$this->time_step = $time_step;
	}
	public function set_time_format($time_format){
		$this->time_format = $time_format;
	}
	public function set_linked_date($linked_date){
		$this->linked_date = $linked_date;
	}
		
	/* Getters */
	public function get_min_time(){
		return empty($this->min_time) ? '' : $this->min_time;
	}
	public function get_max_time(){
		return empty($this->max_time) ? '' : $this->max_time;
	}
	public function get_start_time(){
		return empty($this->start_time) ? '' : $this->start_time;
	}
	public function get_time_step(){
		return empty($this->time_step) ? '' : $this->time_step;
	}
	public function get_time_format(){
		return empty($this->time_format) ? '' : $this->time_format;
	}
	public function get_linked_date(){
		return empty($this->linked_date) ? '' : $this->linked_date;
	}	
}

endif;