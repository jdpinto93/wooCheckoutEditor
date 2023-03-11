<?php
if(!defined('WPINC')){	die; }

if(!class_exists('THWCFE_Admin')):
 
class THWCFE_Admin {
	private $plugin_name;
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.9.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
	
	public function enqueue_styles_and_scripts($hook) {
		global $pagenow;

		if(strpos($hook, 'page_th_checkout_field_editor_pro') !== false) {
			$debug_mode = apply_filters('thwcfe_debug_mode', false);
			$suffix = $debug_mode ? '' : '.min';
			
			$this->enqueue_styles($suffix);
			$this->enqueue_scripts($suffix);

		}else if($pagenow === 'user-edit.php'){
			$debug_mode = apply_filters('thwcfe_debug_mode', false);
			$suffix = $debug_mode ? '' : '.min';
			$jquery_version = isset($wp_scripts->registered['jquery-ui-core']->ver) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';
			
			$this->enqueue_userprofile_styles($suffix, $jquery_version);
			$this->enqueue_userprofile_scripts($suffix, $jquery_version);
		}
	}
	
	private function enqueue_styles($suffix) {
		wp_enqueue_style('woocommerce_admin_styles');
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('thwcfe-admin-style', THWCFE_ASSETS_URL_ADMIN . 'css/thwcfe-admin'. $suffix .'.css', $this->version);
	}

	private function enqueue_scripts($suffix) {
		$this->version = '1.9.3.16'; //TODO check this

		$deps = array('jquery', 'jquery-ui-dialog', 'jquery-ui-sortable', 'jquery-tiptip', 'woocommerce_admin', 'select2', 'wp-color-picker');
			
		wp_enqueue_script( 'thwcfe-admin-script', THWCFE_ASSETS_URL_ADMIN . 'js/thwcfe-admin'. $suffix .'.js', $deps, $this->version, false );

		$skip_products_loading = WCFE_Checkout_Fields_Utils::skip_products_loading();
		$skip_products_loading = $skip_products_loading ? 'yes' : 'no';
		
		$wcfe_var = array(
            'admin_url' => admin_url(),
            'ajax_url' => admin_url( 'admin-ajax.php' ),
			'sanitize_names' => apply_filters("thwcfe_sanitize_field_names", true),
			'input_operand' => $skip_products_loading,
        );
		wp_localize_script('thwcfe-admin-script', 'wcfe_var', $wcfe_var);
	}

	private function enqueue_userprofile_styles($suffix, $jquery_version, $in_footer=true) {	
		wp_enqueue_style('thwcfe-public-myaccount-style', THWCFE_ASSETS_URL_PUBLIC . 'css/thwcfe-public'. $suffix .'.css', $this->version);
	}

	private function enqueue_userprofile_scripts($suffix, $jquery_version, $in_footer=true) {		
		wp_enqueue_script('thwcfe-userprofile-script', THWCFE_ASSETS_URL_PUBLIC.'js/thwcfe-userprofile'. $suffix .'.js', array(), THWCFE_VERSION, $in_footer);
			
		$wcfe_var = array(
			'ajax_url'    => admin_url( 'admin-ajax.php' ),
		);
		wp_localize_script('thwcfe-userprofile-script', 'thwcfe_public_var', $wcfe_var);
	}
	
	public function admin_menu() {
		$capability = THWCFE_Utils::wcfe_capability();
		$this->screen_id = add_submenu_page('woocommerce', THWCFE_i18n::t('WooCommerce Checkout Field Editor Pro'), THWCFE_i18n::t('Checkout Editor'), $capability, 'th_checkout_field_editor_pro', array($this, 'output_settings'));
	}
	
	public function add_screen_id($ids){
		$ids[] = 'woocommerce_page_th_checkout_field_editor_pro';
		$ids[] = strtolower(__( 'WooCommerce', 'woocommerce' )) .'_page_th_checkout_field_editor_pro';
		return $ids;
	}

	public function plugin_action_links($links) {
		$settings_link = '<a href="'.admin_url('admin.php?page=th_checkout_field_editor_pro').'">'. THWCFE_i18n::t('Settings') .'</a>';
		array_unshift($links, $settings_link);
		return $links;
	}
	
	public function plugin_row_meta( $links, $file ) {
		if(THWCFE_BASE_NAME == $file) {
			$doc_link = esc_url('https://www.webmasteryagency.com/');
			$support_link = esc_url('https://www.webmasteryagency.com/');
				
			$row_meta = array(
				'docs' => '<a href="'.$doc_link.'">'.THWCFE_i18n::esc_html__t('Documentacion').'</a>',
				'support' => '<a href="'.$support_link.'">'.THWCFE_i18n::esc_html__t('Soporte').'</a>',
			);

			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}
	
	public function output_settings(){
		echo '<div class="wrap">';
		echo '<h2></h2>';		
		$tab  = isset( $_GET['tab'] ) ? esc_attr( $_GET['tab'] ) : 'fields';
		
		echo '<div class="thwcfe-wrap">';
		if($tab === 'advanced_settings'){			
			$advanced_settings = THWCFE_Admin_Settings_Advanced::instance();	
			$advanced_settings->render_page();
		
		}else{
			$general_settings = THWCFE_Admin_Settings_General::instance();	
			$general_settings->init();
		}
		echo '</div">';
		echo '</div>';		
	}


	public function print_js_variables(){
		$screen = get_current_screen();
		if(strpos($screen->id,'th_checkout_field_editor_pro') === false){
			return;
		}
		$content = "";
		$checkout_fields = array();
		$sections = THWCFE_Utils::get_custom_sections();
		if($sections && is_array($sections)){
			foreach($sections as $sname => $section){
				if($section && THWCFE_Utils_Section::is_valid_section($section)){
					$fields_data = array();
					$fields = THWCFE_Utils_Section::get_fields($section);
					foreach($fields as $name => $field){
						if(THWCFE_Utils_Field::is_valid_field($field)){
							$fields_data[$field->name] = array(
								'name' => $field->name,
								'custom_field' => $field->custom_field,
								'title' => $field->title,
							);
						}
					}
					$checkout_fields[$section->name] = array(
						'name' => $section->name,
						'custom_section' => $section->custom_section,
						'title' => $section->title,
						'fields' => $fields_data,
					);
				}
			}
		}

		if(!empty($checkout_fields)){
			$checkout_fields = json_encode($checkout_fields);
			$content .= "var thwcfeCheckoutFields = $checkout_fields;";
		}

		$section = isset( $_GET['section'] ) ? esc_attr( $_GET['section'] ) : 'billing';
		if($section){
			$content .= " var thwcfe_current_section = '$section';";
		} ?>
		<script type='text/javascript'>
			<?php echo $content; ?>
		</script>
		<?php
	}


}

endif;