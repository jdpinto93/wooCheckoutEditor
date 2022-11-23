<?php


if(!defined('ABSPATH')){ exit; }

if(!class_exists('WCFE_Checkout_Field_Tel')):

class WCFE_Checkout_Field_Tel extends WCFE_Checkout_Field{
	
	public function __construct() {
		$this->type = 'tel';
	}	

}

endif;