<?php
if(!defined('WPINC')){	die; }

if(!class_exists('THWCFE_Utils_Core')):

class THWCFE_Utils_Core {

    public static function log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}

endif;