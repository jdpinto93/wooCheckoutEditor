<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_Textarea')):

class WCFE_Checkout_Field_Textarea extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'textarea';
	}	

}

endif;