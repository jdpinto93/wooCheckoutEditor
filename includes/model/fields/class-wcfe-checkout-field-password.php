<?php
if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_Password')):

class WCFE_Checkout_Field_Password extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'password';
	}	
}

endif;