<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_City')):

class WCFE_Checkout_Field_City extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'city';
	}
	
}

endif;