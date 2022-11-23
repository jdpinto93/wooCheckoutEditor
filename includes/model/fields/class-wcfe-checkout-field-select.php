<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_Select')):

class WCFE_Checkout_Field_Select extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'select';
	}	
	
}

endif;