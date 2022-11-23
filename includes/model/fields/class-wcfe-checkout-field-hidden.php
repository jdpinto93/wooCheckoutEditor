<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_Hidden')):

class WCFE_Checkout_Field_Hidden extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'hidden';
	}	
}

endif;