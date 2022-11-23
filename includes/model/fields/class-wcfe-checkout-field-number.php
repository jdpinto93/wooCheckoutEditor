<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_Number')):

class WCFE_Checkout_Field_Number extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'number';
	}	

}

endif;