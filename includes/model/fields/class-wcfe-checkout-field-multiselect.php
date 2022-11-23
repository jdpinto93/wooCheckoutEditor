<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_Multiselect')):

class WCFE_Checkout_Field_Multiselect extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'multiselect';
	}	

}

endif;