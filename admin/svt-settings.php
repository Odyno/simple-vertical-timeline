<?php
/**
 * Created by PhpStorm.
 * User: astaniscia
 * Date: 30/07/16
 * Time: 11:27
 */

if ( ! class_exists( 'SVT_Settings' ) ) {


	class SVT_Settings {

		const OPTION_IS_ENABLED_SOLCIAL_MEDIA = "svt_is_enable_social_media";
		const OPTION_SIGNE = 'svt_signe';
		const OPTION_ANALITYCS = 'svt_analitycs';
		const PAGE_SETTING = 'svt_settings';
		const PAGE_ID = 'SVTPreference';


		/**
		 * This is our constructor
		 *
		 */
		public function __construct() {
			add_action( 'admin_init', array(
				$this,
				'register_settings_sections'
			) );
			add_action( 'admin_init', array(
				$this,
				'register_settings_style'
			) );
			add_action( 'admin_menu', array(
				$this,
				'add_menu_settings_voice'
			) );
			add_action( 'plugin_action_links', array(
				$this,
				'add_setting_link'
			), 2, 2 );

		}

		public function add_menu_settings_voice() {

			// Add new admin menu and save     returned page hook
			$hook_suffix = add_options_page(
				__( 'Simple Vertical Timeline Preference', 'svt' ),    // page Title
				__( 'Simple Vertical Timeline', 'svt' ),               // menu Link
				'manage_options',                                   //Capability
				SVT_Settings::PAGE_ID,                                     //ID
				array( $this, 'get_HTML_Setting_Page' )
			);

			//ADD CSS
			add_action( 'admin_print_styles-' . $hook_suffix, array(
				$this,
				'load_style'
			) );
		}

		public function register_settings_style() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';

			wp_register_style( 'svt-admin-style', plugins_url( "/admin/css/admin-style" . $suffix, __SVT_FILE__ ) );
		}


		public function load_style() {
			wp_enqueue_style( 'svt-admin-style' );
		}

		public function add_setting_link( $actions, $file ) {
			if ( FALSE !== strpos( $file, 'simple-vertical-timeline' ) ) {
				$actions['settings'] = '<a href="options-general.php?page=' . SVT_Settings::PAGE_ID . '">' . __( 'Settings', 'svt' ) . '</a>';
			}

			return $actions;
		}


		public function register_settings_sections() {
			$this->add_section_socialmedia();
			$this->add_section_adv();

		}

		//NOT USED
		public function add_section_socialmedia() {
			add_settings_section(
				SVT_Settings::PAGE_SETTING . "_SocialMedia", //String for use in the 'id' attribute of tags.
				__( ' ', 'svt' ),                //Title of the section
				function () {
					_e( ' ', 'svt' );
				},  //Function that fills the section with the desired content. The function should echo its output.
				SVT_Settings::PAGE_ID            //The type of settings page on which to show the section
			);


			add_settings_field(
				SVT_Settings::OPTION_IS_ENABLED_SOLCIAL_MEDIA,                        //String for use in the 'id' attribute of tags.
				__( 'Show extra social media sharing icons', 'svt' ),           // Title of the field.
				function () {
					echo ' <input name="' . SVT_Settings::OPTION_IS_ENABLED_SOLCIAL_MEDIA . '" value="1" type="checkbox" class="code" ' . checked( 1, get_option( SVT_Settings::OPTION_IS_ENABLED_SOLCIAL_MEDIA ), FALSE ) . ' />';
				}, //Function that fills the field with the desired inputs as part of the larger form. Name and id of the input should match the $id given to this function. The function should echo its output.
				SVT_Settings::PAGE_ID,          //The type of settings page on which to show the field
				SVT_Settings::PAGE_SETTING . "_SocialMedia"                  //The section of the settings page in which to show the box (default or a section you added with add_settings_section, look at the page in the source to see what the existing ones are.
			);

			register_setting( SVT_Settings::PAGE_SETTING, SVT_Settings::OPTION_IS_ENABLED_SOLCIAL_MEDIA );

		}


		public function add_section_adv() {
			//Build new Section
			add_settings_section(
				SVT_Settings::PAGE_SETTING . "_ADV",                 //String for use in the 'id' attribute of tags.
				__( ' ', 'svt' ),                              //Title of the section
				array(
					$this,
					'get_HTML_ADV_description'
				),  //Function that fills the section with the desired content. The function should echo its output.
				SVT_Settings::PAGE_ID            //The type of settings page on which to show the section
			);

			add_settings_field(
				SVT_Settings::OPTION_SIGNE,                        //String for use in the 'id' attribute of tags.
				__( 'Show a little and invisible sign of this plugin ( Thanks! )', 'svt' ),           // Title of the field.
				array(
					$this,
					'get_HTML_field_Signe'
				),          //Function that fills the field with the desired inputs as part of the larger form. Name and id of the input should match the $id given to this function. The function should echo its output.
				SVT_Settings::PAGE_ID,          //The type of settings page on which to show the field
				SVT_Settings::PAGE_SETTING . "_ADV"                  //The section of the settings page in which to show the box (default or a section you added with add_settings_section, look at the page in the source to see what the existing ones are.
			);

			add_settings_field(
				SVT_Settings::OPTION_ANALITYCS,
				__( 'Enable the tracking of this WordPress installation with anonymous data.', 'svt' ),
				array( $this, 'get_HTML_field_Analitycs' ),
				SVT_Settings::PAGE_ID,
				SVT_Settings::PAGE_SETTING . "_ADV"
			);

			register_setting( SVT_Settings::PAGE_SETTING, SVT_Settings::OPTION_SIGNE );
			register_setting( SVT_Settings::PAGE_SETTING, SVT_Settings::OPTION_ANALITYCS );
		}


		/**
		 * Description of option section
		 */
		function get_HTML_ADV_description() {
			echo "";
		}

		/**
		 * Function that fills the field with the desired inputs as part of the larger form.
		 * Name and id of the input should match the $id given to this function.
		 * The function should echo its output.
		 */
		function get_HTML_field_Signe() {
			echo ' <input name="' . SVT_Settings::OPTION_SIGNE . '" type="checkbox" value="1"  class="code" ' . checked( 1, get_option( SVT_Settings::OPTION_SIGNE ), FALSE ) . ' />';
		}

		function get_HTML_field_Analitycs() {
			echo ' <input name="' . SVT_Settings::OPTION_ANALITYCS . '" type="checkbox" value="1"  class="code" ' . checked( 1, get_option( SVT_Settings::OPTION_ANALITYCS ), FALSE ) . ' />';
		}

		function get_HTML_Setting_Page() {
			include( plugin_dir_path( __SVT_FILE__ ) . '/admin/views/html-settings-page.inc.php' );
		}


		/**
		 * return sign in according to user preference
		 * @return string
		 */
		static function get_sign() {

			$sign_inline_style = "display: none;";
			if ( get_option( SVT_Settings::OPTION_SIGNE, TRUE ) ) {
				$sign_inline_style = "color: #000; font-family: arial,sans-serif; text-align: right; font-size: 77%;";
			}

			return $sign_inline_style;
		}

		/**
		 * return contrib link in according of user preference
		 * @return string
		 */
		static function get_contrib() {
			$contribCode = "";
			if ( get_option( get_option( SVT_Settings::OPTION_ANALITYCS, TRUE ) ) ) {
				$contribCode = '
					<img style="display: none;" 
						src="http://www.staniscia.net/wp-data/logo.php?t=gif&p=svt&v=' . SVT_VER . '" 
						alt="logo" 
						onerror="this.parentNode.removeChild(this)" />';
			}

			return $contribCode;
		}

	}

}