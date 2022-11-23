<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_Email')):

class WCFE_Checkout_Field_Email extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'email';
	}	
}

endif;