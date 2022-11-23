<?php
if(!defined('WPINC')){	die; }

if(!class_exists('THWCFE_Admin_Form_Field')):

class THWCFE_Admin_Form_Field extends THWCFE_Admin_Form{
	private $field_props = array();

	public function __construct() {
		$this->init_constants();
	}

	private function init_constants(){
		$this->field_props = $this->get_field_form_props();
		//$this->field_props_display = $this->get_field_form_props_display();
	}

	private function get_field_types(){
		return array(
			'text' => 'Text', 'hidden' => 'Hidden', 'password' => 'Password', 
			'tel' => 'Telephone', 'email' => 'Email', 'number' => 'Number',  
			'textarea' => 'Textarea', 'select' => 'Select', 'multiselect' => 'Multiselect', 
			'radio' => 'Radio', 'checkbox' => 'Checkbox', 'checkboxgroup' => 'Checkbox Group', 
			'datepicker' => 'Date Picker', 'timepicker' => 'Time Picker', 
			'file' => 'File Upload', 
			'heading' => 'Heading', 'label' => 'Label'
		);
	}

	public function get_field_form_props(){
		$field_types = $this->get_field_types();
		
		$validations = array(
			'email' => 'Email',
			'phone' => 'Phone',
			'postcode' => 'Postcode',
			'state' => 'State',
			'number' => 'Number',
		);
		$custom_validators = THWCFE_Utils::get_settings('custom_validators');
		if(is_array($custom_validators)){
			foreach( $custom_validators as $vname => $validator ) {
				$validations[$vname] = $validator['label'];
			}
		}
		
		$confirm_validators = THWCFE_Utils::get_settings('confirm_validators');
		if(is_array($confirm_validators)){
			foreach( $confirm_validators as $vname => $validator ) {
				$validations[$vname] = $validator['label'];
			}
		}
		
		$price_types = array(
			'normal' => 'Fixed',
			'custom' => 'Custom',
			'percentage' => 'Percentage of Cart Contents Total',
			'percentage_subtotal' => 'Percentage of Subtotal',
			'percentage_subtotal_ex_tax' => 'Percentage of Subtotal Ex Tax',
			'dynamic' => 'Dynamic',
		);
		
		$week_days = array(
			'sun' => 'Sunday',
			'mon' => 'Monday',
			'tue' => 'Tuesday',
			'wed' => 'Wednesday',
			'thu' => 'Thursday',
			'fri' => 'Friday',
			'sat' => 'Saturday',
		);
		
		$html_text_tags = $this->get_html_text_tags();
		//$title_positions = array( 'left' => 'Left of the field', 'above' => 'Above field', );
		
		$time_formats = array(
			'h:i A' => '12-hour format',
			'H:i' => '24-hour format',
		);

		$suffix_types = array(
			'number' => 'Number',
			'alphabet' => 'Alphabet',
			'none' => 'None',
		);

		$suffix_types_1 = array(
			'number' => 'Number',
			'alphabet' => 'Alphabet',
		);

		$reserved_names = array('address');
		$hint_name_arr[] = "The field names prefixed with billing_ or shipping_ will automatically prefill with previous order field values";
		$hint_name_arr[] = "Some field names are reserved & usage will create unexpected errors";
		$hint_name_arr[] = "Eg: ". implode(', ', $reserved_names);
		$hint_name = implode('. ', $hint_name_arr);
		
		$hint_accept = "Specify allowed file types separated by comma (e.g. png,jpg,docx,pdf).";
		
		$hint_price = "If taxable, always enter price exclusive of tax.";
		$hint_default_date = "Specify a date in the current dateFormat, or number of days from today (e.g. +7) or a string of values and periods ('y' for years, 'm' for months, 'w' for weeks, 'd' for days, e.g. '+1m +7d'), or leave empty for today.";
		$hint_date_format = "The format for parsed and displayed dates.";
		$hint_min_date = "The minimum selectable date. Specify a date in yyyy-mm-dd format, or number of days from today (e.g. -7) or a string of values and periods ('y' for years, 'm' for months, 'w' for weeks, 'd' for days, e.g. '-1m -7d'), or leave empty for no minimum limit.";
		$hint_max_date = "The maximum selectable date. Specify a date in yyyy-mm-dd format, or number of days from today (e.g. +7) or a string of values and periods ('y' for years, 'm' for months, 'w' for weeks, 'd' for days, e.g. '+1m +7d'), or leave empty for no maximum limit.";
		$hint_year_range = "The range of years displayed in the year drop-down: either relative to today's year ('-nn:+nn' e.g. -5:+3), relative to the currently selected year ('c-nn:c+nn' e.g. c-10:c+10), absolute ('nnnn:nnnn' e.g. 2002:2012), or combinations of these formats ('nnnn:+nn' e.g. 2002:+3). Note that this option only affects what appears in the drop-down, to restrict which dates may be selected use the minDate and/or maxDate options.";
		$hint_number_of_months = "The number of months to show at once.";
		$hint_disabled_dates = "Specify dates in yyyy-mm-dd format separated by comma.";
		
		return array(
			'name' 		  => array('type'=>'text', 'name'=>'name', 'label'=>'Name', 'required'=>1, 'hint_text'=>$hint_name),
			'type' 		  => array('type'=>'select', 'name'=>'type', 'label'=>'Field Type', 'required'=>1, 'options'=>$field_types, 
								'onchange'=>'thwcfeFieldTypeChangeListner(this)'),
			'value' 	  => array('type'=>'text', 'name'=>'value', 'label'=>'Default Value'),
			'placeholder' => array('type'=>'text', 'name'=>'placeholder', 'label'=>'Placeholder'),
			'description' => array('type'=>'text', 'name'=>'description', 'label'=>'Description'),
			'validate'    => array('type'=>'multiselect', 'name'=>'validate', 'label'=>'Validations', 'placeholder'=>'Select validations', 'options'=>$validations),
			'cssclass'    => array('type'=>'text', 'name'=>'cssclass', 'label'=>'Wrapper Class', 'placeholder'=>'Separate classes with comma', 'value'=>'form-row-wide'),
			'input_class' => array('type'=>'text', 'name'=>'input_class', 'label'=>'Input Class', 'placeholder'=>'Separate classes with comma'),
			
			'price'        => array('type'=>'text', 'name'=>'price', 'label'=>'Price', 'placeholder'=>'Price', 'hint_text'=>$hint_price),
			'price_unit'   => array('type'=>'text', 'name'=>'price_unit', 'label'=>'Unit', 'placeholder'=>'Unit'),
			'price_type'   => array('type'=>'select', 'name'=>'price_type', 'label'=>'Price Type', 'options'=>$price_types, 'onchange'=>'thwcfePriceTypeChangeListener(this)'),
			'taxable'      => array('type'=>'select', 'name'=>'taxable', 'label'=>'Taxable', 'options'=>array('no' => 'No', 'yes' => 'Yes')),
			'tax_class'    => array('type'=>'select', 'name'=>'tax_class', 'label'=>'Tax Class', 'options'=>THWCFE_Utils::get_product_tax_class_options()),
			
			'order_meta' => array('type'=>'checkbox', 'name'=>'order_meta', 'label'=>'Order Meta Data', 'value'=>'yes', 'checked'=>1),
			'user_meta'  => array('type'=>'checkbox', 'name'=>'user_meta', 'label'=>'User Meta Data', 'value'=>'yes', 'checked'=>0),
			
			'checked'   => array('type'=>'checkbox', 'name'=>'checked', 'label'=>'Checked by default', 'value'=>'yes', 'checked'=>1),
			'required'  => array('type'=>'checkbox', 'name'=>'required', 'label'=>'Required', 'value'=>'yes', 'checked'=>0, 'status'=>1),
			'clear' 	=> array('type'=>'checkbox', 'name'=>'clear', 'label'=>'Clear Row', 'value'=>'yes', 'checked'=>0, 'status'=>1),
			'enabled'   => array('type'=>'checkbox', 'name'=>'enabled', 'label'=>'Enabled', 'value'=>'yes', 'checked'=>1, 'status'=>1),
			
			'show_in_email' => array('type'=>'checkbox', 'name'=>'show_in_email', 'label'=>'Display in Admin Emails', 'value'=>'yes', 'checked'=>1),
			'show_in_email_customer' => array('type'=>'checkbox', 'name'=>'show_in_email_customer', 'label'=>'Display in Customer Emails', 'value'=>'yes', 'checked'=>1),
			'show_in_order' => array('type'=>'checkbox', 'name'=>'show_in_order', 'label'=>'Display in Order Detail Pages', 'value'=>'yes', 'checked'=>1),
			'show_in_thank_you_page' => array('type'=>'checkbox', 'name'=>'show_in_thank_you_page', 'label'=>'Display in Thank You Page', 'value'=>'yes', 'checked'=>1),
			'show_in_my_account_page' => array('type'=>'checkbox', 'name'=>'show_in_my_account_page', 'label'=>'Display in My Account Page', 'value'=>'yes', 'checked'=>0),
			
			'title'          => array('type'=>'text', 'name'=>'title', 'label'=>'Label'),
			'title_type'     => array('type'=>'select', 'name'=>'title_type', 'label'=>'Title Type', 'value'=>'h3', 'options'=>$html_text_tags),
			'title_color'    => array('type'=>'colorpicker', 'name'=>'title_color', 'label'=>'Title Color'),
			'title_class'    => array('type'=>'text', 'name'=>'title_class', 'label'=>'Label Class', 'placeholder'=>'Separate classes with comma'),
			
			'subtitle'       => array('type'=>'text', 'name'=>'subtitle', 'label'=>'Subtitle'),
			'subtitle_type'  => array('type'=>'select', 'name'=>'subtitle_type', 'label'=>'Subtitle Type', 'value'=>'label', 'options'=>$html_text_tags),
			'subtitle_color' => array('type'=>'colorpicker', 'name'=>'subtitle_color', 'label'=>'Subtitle Color'),
			'subtitle_class' => array('type'=>'text', 'name'=>'subtitle_class', 'label'=>'Subtitle Class', 'placeholder'=>'Separate classes with comma'),
			
			'minlength'   => array('type'=>'text', 'name'=>'minlength', 'label'=>'Min. Length', 'hint_text'=>'The minimum number of characters allowed'),
			'maxlength'   => array('type'=>'text', 'name'=>'maxlength', 'label'=>'Max. Length', 'hint_text'=>'The maximum number of characters allowed'),
			//'repeat_x'    => array('type'=>'text', 'name'=>'repeat_x', 'label'=>'Repeat X'),
			
			'maxsize' => array('type'=>'text', 'name'=>'maxsize', 'label'=>'Maxsize(in MB)'),
			'accept'  => array('type'=>'text', 'name'=>'accept', 'label'=>'Accepted File Types', 'placeholder'=>'eg: png,jpg,docx,pdf', 'hint_text'=>$hint_accept),

			'autocomplete' 	=> array('type'=>'text', 'name'=>'autocomplete', 'label'=>'Autocomplete'),
			'country_field' => array('type'=>'text', 'name'=>'country_field', 'label'=>'Country Field Name'),
			'country' 		=> array('type'=>'text', 'name'=>'country', 'label'=>'Country'),
						
			'default_date' => array('type'=>'text','name'=>'default_date', 'label'=>'Default Date','placeholder'=>"Leave empty for today's date",'hint_text'=>$hint_default_date),
			'date_format'  => array('type'=>'text', 'name'=>'date_format', 'label'=>'Date Format', 'value'=>'dd/mm/yy', 'hint_text'=>$hint_date_format),
			'min_date'     => array('type'=>'text', 'name'=>'min_date', 'label'=>'Min. Date', 'placeholder'=>'The minimum selectable date', 'hint_text'=>$hint_min_date),
			'max_date'     => array('type'=>'text', 'name'=>'max_date', 'label'=>'Max. Date', 'placeholder'=>'The maximum selectable date', 'hint_text'=>$hint_max_date),
			'year_range'   => array('type'=>'text', 'name'=>'year_range', 'label'=>'Year Range', 'value'=>'-100:+1', 'hint_text'=>$hint_year_range),
			'number_of_months' => array('type'=>'text', 'name'=>'number_of_months', 'label'=>'Number Of Months', 'value'=>'1', 'hint_text'=>$hint_number_of_months),
			'disabled_days'  => array('type'=>'multiselect', 'name'=>'disabled_days', 'label'=>'Disabled Days', 'placeholder'=>'Select days to disable', 'options'=>$week_days),
			'disabled_dates' => array('type'=>'text', 'name'=>'disabled_dates', 'label'=>'Disabled Dates', 'placeholder'=>'Separate dates with comma', 
			'hint_text'=>$hint_disabled_dates),
			
			'min_time'    => array('type'=>'text', 'name'=>'min_time', 'label'=>'Min. Time', 'value'=>'12:00am', 'sub_label'=>'ex: 12:30am'),
			'max_time'    => array('type'=>'text', 'name'=>'max_time', 'label'=>'Max. Time', 'value'=>'11:30pm', 'sub_label'=>'ex: 11:30pm'),
			'start_time'  => array('type'=>'text', 'name'=>'start_time', 'label'=>'Start Time', 'value'=>'', 'sub_label'=>'ex: 2h 30m'),
			'time_step'   => array('type'=>'text', 'name'=>'time_step', 'label'=>'Time Step', 'value'=>'30', 'sub_label'=>'In minutes, ex: 30'),
			'time_format' => array('type'=>'select', 'name'=>'time_format', 'label'=>'Time Format', 'value'=>'h:i A', 'options'=>$time_formats),
			'linked_date' => array('type'=>'text', 'name'=>'linked_date', 'label'=>'Linked Date'),

			'rpt_name_suffix' => array('type'=>'select', 'name'=>'rpt_name_suffix', 'label'=>'Name Suffix', 'options'=>$suffix_types_1),
			'rpt_label_suffix' => array('type'=>'select', 'name'=>'rpt_label_suffix', 'label'=>'Label Suffix', 'options'=>$suffix_types),
			'rpt_incl_parent' => array('type'=>'checkbox', 'name'=>'rpt_incl_parent', 'label'=>'Start indexing from parent', 'value'=>'yes', 'checked'=>0),

			'inherit_display_rule' => array('type'=>'checkbox', 'name'=>'inherit_display_rule', 'label'=>'Inherit Cart & User based display rules', 'value'=>'yes', 'checked'=>1),
			'inherit_display_rule_ajax' => array('type'=>'checkbox', 'name'=>'inherit_display_rule_ajax', 'label'=>'Inherit Fields based display rules', 'value'=>'yes', 'checked'=>1),
			'auto_adjust_display_rule_ajax' => array('type'=>'checkbox', 'name'=>'auto_adjust_display_rule_ajax', 'label'=>'Adjust display rules based on fields in same section', 'value'=>'yes', 'checked'=>1),
		);
	}

	public function get_field_form_props_display(){
		return array(
			'name'  => array('name'=>'name', 'type'=>'text'),
			'type'  => array('name'=>'type', 'type'=>'select'),
			'title' => array('name'=>'title', 'type'=>'text', 'len'=>40),
			'placeholder' => array('name'=>'placeholder', 'type'=>'text', 'len'=>30),
			'validate' => array('name'=>'validate', 'type'=>'text'),
			'required' => array('name'=>'required', 'type'=>'checkbox', 'status'=>1),
			'enabled'  => array('name'=>'enabled', 'type'=>'checkbox', 'status'=>1),
		);
	}

	public function output_field_forms(){
		$this->output_field_form_pp();
		$this->output_form_fragments();
	}

	private function output_field_form_pp(){
		?>
        <div id="thwcfe_field_form_pp" class="thpladmin-modal-mask">
          <?php $this->output_popup_form_fields(); ?>
        </div>
        <?php
	}

	/*****************************************/
	/********** POPUP FORM WIZARD ************/
	/*****************************************/
	private function output_popup_form_fields(){
		?>
		<div class="thpladmin-modal">
			<div class="modal-container">
				<span class="modal-close" onclick="thwcfeCloseModal(this)">×</span>
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-wizard wizard">
							<aside>
								<side-title class="wizard-title">Save Field</side-title>
								<ul class="pp_nav_links">
									<li class="text-primary active first pp-nav-link-basic" data-index="0">
										<i class="dashicons dashicons-admin-generic text-primary"></i>Basic Info
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>
									<li class="text-primary pp-nav-link-styles" data-index="1">
										<i class="dashicons dashicons-art text-primary"></i>Display Styles
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>
									<!--<li class="text-primary pp-nav-link-tooltip" data-index="2">
										<i class="dashicons dashicons-admin-comments text-primary"></i>Tooltip Details
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>-->
									<li class="text-primary pp-nav-link-price" data-index="2">
										<i class="dashicons dashicons-cart text-primary"></i>Price Details
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>
									<li class="text-primary pp-nav-link-rules" data-index="3">
										<i class="dashicons dashicons-filter text-primary"></i>Display Rules
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>
									<li class="text-primary last" data-index="4">
										<i class="dashicons dashicons-controls-repeat text-primary"></i>Repeat Rules
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>
								</ul>
							</aside>
							<main class="form-container main-full">
								<form method="post" id="thwcfe_field_form" action="">
									<input type="hidden" name="f_action" value="" />
									<input type="hidden" name="i_name_old" value="" >
									<input type="hidden" name="i_order" value="" >
									<input type="hidden" name="i_priority" value="" >
			                        <input type="hidden" name="i_options" value="" >
									<input type="hidden" name="i_rules" value="" >
									<input type="hidden" name="i_rules_ajax" value="" >
									<input type="hidden" name="i_repeat_rules" value="" >
									<input type="hidden" name="i_country_field" value="" >
									<input type="hidden" name="i_country" value="" >
									<input type="hidden" name="i_autocomplete" value="" >
									<input type="hidden" name="i_rowid" value="" />
                    				<input type="hidden" name="i_original_type" value="" />

									<div class="data-panel data_panel_0">
										<?php $this->render_form_tab_general_info(); ?>
									</div>
									<div class="data-panel data_panel_1">
										<?php $this->render_form_tab_display_details(); ?>
									</div>
									<!--<div class="data-panel data_panel_2">
										<?php //$this->render_form_tab_tooltip_info(); ?>
									</div>-->
									<div class="data-panel data_panel_2">
										<?php $this->render_form_tab_price_info(); ?>
									</div>
									<div class="data-panel data_panel_3">
										<?php $this->render_form_tab_display_rules(); ?>
									</div>
									<div class="data-panel data_panel_4">
										<?php $this->render_form_tab_repeat_rules(); ?>
									</div>
								</form>
							</main>
							<footer>
								<span class="Loader"></span>
								<div class="btn-toolbar">
									<button class="save-btn pull-right btn btn-primary" onclick="thwcfeSaveField(this)">
										<span>Save & Close</span>
									</button>
									<button class="next-btn pull-right btn btn-primary-alt" onclick="thwcfeWizardNext(this)">
										<span>Next</span><i class="i i-plus"></i>
									</button>
									<button class="prev-btn pull-right btn btn-primary-alt" onclick="thwcfeWizardPrevious(this)">
										<span>Back</span><i class="i i-plus"></i>
									</button>
								</div>
							</footer>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/*----- TAB - General Info -----*/
	private function render_form_tab_general_info(){
		$this->render_form_tab_main_title('Basic Details');

		?>
		<div style="display: inherit;" class="data-panel-content">
			<?php
			$this->render_form_fragment_general();
			?>
			<table class="thwcfe_field_form_tab_general_placeholder thwcfe_pp_table thwcfe-general-info"></table>
		</div>
		<?php
	}

	/*----- TAB - Display Details -----*/
	private function render_form_tab_display_details(){
		$this->render_form_tab_main_title('Display Settings');

		?>
		<div style="display: inherit;" class="data-panel-content mt-10">
			<table class="thwcfe_pp_table compact thwcfe-display-info">
				<?php
				$this->render_form_elm_row($this->field_props['cssclass']);
				$this->render_form_elm_row($this->field_props['input_class']);
				$this->render_form_elm_row($this->field_props['title_class']);

				$this->render_form_elm_row_cb($this->field_props['show_in_email']);
				$this->render_form_elm_row_cb($this->field_props['show_in_email_customer']);
				$this->render_form_elm_row_cb($this->field_props['show_in_order']);
				$this->render_form_elm_row_cb($this->field_props['show_in_thank_you_page']);
				?>
			</table>
		</div>
		<?php
	}


	/*----- TAB - Price Info -----*/
	private function render_form_tab_price_info(){
		$price_type_props = $this->field_props['price_type'];
		$options = isset($price_type_props['options']) ? $price_type_props['options'] : array();
		
		
		$price_type_props['options'] = $options;

		$this->render_form_tab_main_title('Price Details');
		?>
		<div style="display: inherit;" class="data-panel-content">
			<table class="thwcfe_pp_table thwcfe-price-info">
				<tr class="form_field_price_type">
					<?php $this->render_form_field_element($price_type_props, $this->cell_props); ?>
		        </tr>
		        <tr class="form_field_price">
		            <td class="label"><?php THWCFE_i18n::et('Price'); ?></td>
		            <?php $this->render_form_fragment_tooltip(false); ?>
		            <td class="field">
		            	<input type="text" name="i_price" placeholder="Price" style="width:260px;" class="thpladmin-price-field"/>
		                <label class="thpladmin-dynamic-price-field" style="display:none">per</label>
		                <input type="text" name="i_price_unit" placeholder="Unit" style="width:80px; display:none" class="thpladmin-dynamic-price-field"/>
		                <label class="thpladmin-dynamic-price-field thpladmin-price-unit-label" style="display:none">unit</label>
		            </td>
				</tr>
				<?php
				$this->render_form_elm_row($this->field_props['taxable']);
				$this->render_form_elm_row($this->field_props['tax_class']);
				?>
			</table>
		</div>
		<?php
	}

	/*----- TAB - Display Rules -----*/
	private function render_form_tab_display_rules(){
		$this->render_form_tab_main_title('Display Rules');

		?>
		<div style="display: inherit;" class="data-panel-content">
			<table class="thwcfe_pp_table thwcfe-display-rules">
				<?php
				$this->render_form_fragment_rules(); 
				$this->render_form_fragment_rules_ajax();
				?>
			</table>
		</div>
		<?php
	}

	/*----- TAB - Repeat Rules -----*/
	private function render_form_tab_repeat_rules(){
		$this->render_form_tab_main_title('Repeat Rules');

		?>
		<div style="display: inherit;" class="data-panel-content">
			<table class="thwcfe_pp_table thwcfe-repeat-rules">
				<?php
				$this->render_form_fragment_repeat_rules($this->field_props);
				?>
			</table>
		</div>
		<?php
	}

	/*-------------------------------*/
	/*------ Form Field Groups ------*/
	/*-------------------------------*/
	private function render_form_fragment_general($input_field = true){
		//$field_types = $this->get_field_types();
		//$field_name_label = $input_field ? THWCFE_i18n::t('Name') : THWCFE_i18n::t('ID');
		?>
		<div class="err_msgs"></div>
        <table class="thwcfe_pp_table">
        	<?php
			$this->render_form_elm_row($this->field_props['type']);
			$this->render_form_elm_row($this->field_props['name']);
			?>
        </table>  
        <?php
	}

	private function output_form_fragments(){
		$this->render_form_field_inputtext();
		$this->render_form_field_hidden();
		$this->render_form_field_password();
		$this->render_form_field_number();
		$this->render_form_field_tel();
		$this->render_form_field_email();
		$this->render_form_field_textarea();
		$this->render_form_field_select();
		$this->render_form_field_multiselect();		
		$this->render_form_field_radio();
		$this->render_form_field_checkbox();
		$this->render_form_field_checkboxgroup();
		$this->render_form_field_datepicker();
		$this->render_form_field_timepicker();
		$this->render_form_field_file();
		$this->render_form_field_heading();
		$this->render_form_field_label();
		$this->render_form_field_default();
		
		$this->render_field_form_fragment_product_list();
		$this->render_field_form_fragment_category_list();
		$this->render_field_form_fragment_tag_list();
		$this->render_field_form_fragment_user_role_list();
		$this->render_field_form_fragment_fields_wrapper();
	}

	private function render_form_field_inputtext(){
		?>
        <table id="thwcfe_field_form_id_text" class="thwcfe_pp_table" style="display:none;">
        	<?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['minlength']);
			$this->render_form_elm_row($this->field_props['maxlength']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>
        </table>
        <?php   
	}

	private function render_form_field_hidden(){
		$title_props = $this->field_props['title'];
		$title_props['placeholder'] = 'For order details page & email';

		?>
        <table id="thwcfe_field_form_id_hidden" class="thwcfe_field_form_table" width="100%" style="display:none;">
			<?php
			$this->render_form_elm_row($title_props);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>  
        </table>
        <?php   
	}

	private function render_form_field_password(){
		?>
        <table id="thwcfe_field_form_id_password" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['maxlength']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>  
        </table>
        <?php   
	}

	private function render_form_field_number(){
		?>
        <table id="thwcfe_field_form_id_number" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>     
        </table>
        <?php   
	}

	private function render_form_field_tel(){
		?>
        <table id="thwcfe_field_form_id_tel" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['maxlength']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>    
        </table>
        <?php   
	}

	private function render_form_field_email(){
		?>
        <table id="thwcfe_field_form_id_email" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['maxlength']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>    
        </table>
        <?php   
	}
	
	private function render_form_field_textarea(){
		$value_props = $this->field_props['value'];
		$value_props['type'] = 'textarea';

		?>
        <table id="thwcfe_field_form_id_textarea" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($value_props);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['maxlength']);
			//$this->render_form_elm_row($this->field_props['cols']);
			//$this->render_form_elm_row($this->field_props['rows']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>     
        </table>
        <?php   
	}
	
	private function render_form_field_select(){
		?>
        <table id="thwcfe_field_form_id_select" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);

			$this->render_form_fragment_h_spacing();
			$this->render_form_fragment_options();
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_multiselect(){
		$maxlen_props = $this->field_props['maxlength'];
		$maxlen_props['label'] = 'Max. Selections';
		$maxlen_props['hint_text'] = 'The maximum number of options that can be selected';

		?>
        <table id="thwcfe_field_form_id_multiselect" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($maxlen_props);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);

			$this->render_form_fragment_h_spacing();
			$this->render_form_fragment_options();
			?> 
        </table>
        <?php   
	}
	
	private function render_form_field_radio(){
		?>
        <table id="thwcfe_field_form_id_radio" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);

			$this->render_form_fragment_h_spacing();
			$this->render_form_fragment_options();
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_checkbox(){
		$value_props = $this->field_props['value'];
		$value_props['label'] = THWCFE_i18n::t('Value');

		?>
        <table id="thwcfe_field_form_id_checkbox" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($value_props);

			$this->render_form_elm_row_cb($this->field_props['checked']);
			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>  
        </table>
        <?php   
	}
	
	private function render_form_field_checkboxgroup(){
		$value_props = $this->field_props['value'];
		$value_props['label'] = THWCFE_i18n::t('Default Values');

		?>
        <table id="thwcfe_field_form_id_checkboxgroup" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($value_props);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);

			$this->render_form_fragment_h_spacing();
			$this->render_form_fragment_options();
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_datepicker(){
		?>
        <table id="thwcfe_field_form_id_datepicker" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['placeholder']);

			$this->render_form_elm_row($this->field_props['date_format']);
			$this->render_form_elm_row($this->field_props['default_date']);
			$this->render_form_elm_row($this->field_props['min_date']);
			$this->render_form_elm_row($this->field_props['max_date']);
			$this->render_form_elm_row($this->field_props['year_range']);
			$this->render_form_elm_row($this->field_props['number_of_months']);
			$this->render_form_elm_row($this->field_props['disabled_days']);
			$this->render_form_elm_row($this->field_props['disabled_dates']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?> 
        </table>
        <?php   
	}
	
	private function render_form_field_timepicker(){
		?>
        <table id="thwcfe_field_form_id_timepicker" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['linked_date']);

			$this->render_form_elm_row($this->field_props['min_time']);
			$this->render_form_elm_row($this->field_props['max_time']);
			$this->render_form_elm_row($this->field_props['start_time']);
			$this->render_form_elm_row($this->field_props['time_step']);
			$this->render_form_elm_row($this->field_props['time_format']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_file(){
		?>
        <table id="thwcfe_field_form_id_file" class="thwcfe_field_form_table" width="100%" style="display:none;">
			<?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['maxsize']);
			$this->render_form_elm_row($this->field_props['accept']);
			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>
        </table>
        <?php   
	}

	private function render_form_field_country(){
		?>
        <table id="thwcfe_field_form_id_country" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>    
        </table>
        <?php   
	}

	private function render_form_field_state(){
		?>
        <table id="thwcfe_field_form_id_state" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['country_field']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>    
        </table>
        <?php   
	}
	
	private function render_form_field_heading(){
		$title_props = $this->field_props['title'];
		$title_props['label'] = $title_props['label'] ? 'Title' : $title_props['label'];
		$title_props['required'] = true;

		$title_class_props = $this->field_props['title_class'];
		$title_class_props['label'] = $title_class_props['label'] ? 'Title Class' : $title_class_props['label'];

		$show_in_order_props = $this->field_props['show_in_order'];
		$show_in_order_props['checked'] = 0;
		
		$show_in_thank_you_page_props = $this->field_props['show_in_thank_you_page'];
		$show_in_thank_you_page_props['checked'] = 0;

		?>
        <table id="thwcfe_field_form_id_heading" class="thwcfe_field_form_table" width="100%" style="display:none;">
			<?php
			$this->render_form_elm_row($title_props);
			$this->render_form_elm_row($this->field_props['title_type']);
			$this->render_form_elm_row_cp($this->field_props['title_color']);
			$this->render_form_elm_row($title_class_props);
			$this->render_form_elm_row($this->field_props['subtitle']);
			$this->render_form_elm_row($this->field_props['subtitle_type']);
			$this->render_form_elm_row_cp($this->field_props['subtitle_color']);
			$this->render_form_elm_row($this->field_props['subtitle_class']);

			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['show_in_email']);
			$this->render_form_elm_row_cb($this->field_props['show_in_email_customer']);
			$this->render_form_elm_row_cb($show_in_order_props);
			$this->render_form_elm_row_cb($show_in_thank_you_page_props);
			$this->render_form_elm_row_cb($this->field_props['show_in_my_account_page']);
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_label(){
		$title_props = $this->field_props['title'];
		$title_props['label'] = $title_props['label'] ? 'Title' : $title_props['label'];
		$title_props['required'] = true;

		$title_class_props = $this->field_props['title_class'];
		$title_class_props['label'] = $title_class_props['label'] ? 'Title Class' : $title_class_props['label'];

		$show_in_email_admin_props = $this->field_props['show_in_email'];
		$show_in_email_admin_props['checked'] = 0;

		$show_in_email_customer_props = $this->field_props['show_in_email_customer'];
		$show_in_email_customer_props['checked'] = 0;

		$show_in_order_props = $this->field_props['show_in_order'];
		$show_in_order_props['checked'] = 0;
		
		$show_in_thank_you_page_props = $this->field_props['show_in_thank_you_page'];
		$show_in_thank_you_page_props['checked'] = 0;
		?>
        <table id="thwcfe_field_form_id_label" class="thwcfe_field_form_table" width="100%" style="display:none;">
			<?php
			$this->render_form_elm_row($title_props);
			$this->render_form_elm_row($this->field_props['title_type']);
			$this->render_form_elm_row_cp($this->field_props['title_color']);
			$this->render_form_elm_row($title_class_props);
			$this->render_form_elm_row($this->field_props['subtitle']);
			$this->render_form_elm_row($this->field_props['subtitle_type']);
			$this->render_form_elm_row_cp($this->field_props['subtitle_color']);
			$this->render_form_elm_row($this->field_props['subtitle_class']);

			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($show_in_email_admin_props);
			$this->render_form_elm_row_cb($show_in_email_customer_props);
			$this->render_form_elm_row_cb($show_in_order_props);
			$this->render_form_elm_row_cb($show_in_thank_you_page_props);
			$this->render_form_elm_row_cb($this->field_props['show_in_my_account_page']);
			?>     
        </table>
        <?php   
	}

	
	private function render_form_field_default(){
		?>
        <table id="thwcfe_field_form_id_default" class="thwcfe_field_form_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['description']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['maxlength']);
			$this->render_form_elm_row($this->field_props['validate']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);

			$this->render_form_elm_row_cb($this->field_props['order_meta']);
			$this->render_form_elm_row_cb($this->field_props['user_meta']);
			?>    
        </table>
        <?php   
	}

	private function render_form_fragment_options(){


		?>
		<tr>
			<td class="sub-title"><?php THWCFE_i18n::et('Options'); ?></td>
			<?php $this->render_form_fragment_tooltip(); ?>
			<td></td>
		</tr>
		<tr>
			<td colspan="3" class="p-0">
				<table border="0" cellpadding="0" cellspacing="0" class="thwcfe-option-list thpladmin-options-table"><tbody>
					<tr>
						<td class="key"><input type="text" name="i_options_key[]" placeholder="Option Value"></td>
						<td class="value"><input type="text" name="i_options_text[]" placeholder="Option Text"></td>
						<td class="price"><input type="text" name="i_options_price[]" placeholder="Price"></td>
						<td class="price-type">    
							<select name="i_options_price_type[]">
								<option selected="selected" value="">Fixed</option>
								<option value="percentage">Percentage of Cart Contents Total</option>
								<option value="percentage_subtotal">Percentage of Subtotal</option>
								<option value="percentage_subtotal_ex_tax">Percentage of Subtotal Ex Tax</option>
							</select>
						</td>
						<td class="action-cell">
							<a href="javascript:void(0)" onclick="thwcfeAddNewOptionRow(this)" class="btn btn-tiny btn-primary" title="Add new option">+</a><a href="javascript:void(0)" onclick="thwcfeRemoveOptionRow(this)" class="btn btn-tiny btn-danger" title="Remove option">x</a><span class="btn btn-tiny sort ui-sortable-handle"></span>
						</td>
					</tr>
				</tbody></table>            	
			</td>
		</tr>
        <?php
	}

}

endif;