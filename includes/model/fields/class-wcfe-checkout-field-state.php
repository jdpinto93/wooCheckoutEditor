<?php
if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_State')):

class WCFE_Checkout_Field_State extends WCFE_Checkout_Field{
	public $country_field = '';
	public $country = '';
	
	public function __construct() {
		$this->type = 'state';
	}	
}

endif;