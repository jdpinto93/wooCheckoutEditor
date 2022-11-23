<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_InputText')):

class WCFE_Checkout_Field_InputText extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'text';
	}	
		
}

endif;