<?php
/*
Plugin Name: Simple Vertical Timeline
Plugin URI: http://www.staniscia.net/simple-vertical-timeline/
Description: Allow to create a VERY Simple Vertical Timeline on the current blog.
Version: 0.2.0
Author: Alessandro Staniscia
Author URI: http://www.staniscia.net
License: GPL2
Text Domain: svt
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.4


Simple Vertical Timeline is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Simple Vertical Timeline. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.html.

*/


if ( ! defined( 'SVT_VER' ) ) {
	define( 'SVT_VER', '0.2.0' );
}


define( '__SVT_FILE__', __FILE__ );


if ( ! function_exists( 'write_log' ) ) {
	function write_log( $log ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, TRUE ) );
		} else {
			error_log( $log );
		}
	}
}


if ( ! class_exists( 'Simple_Vertical_Timeline' ) ) {

// Start up the engine
	/**
	 * Class Simple_Vertical_Timeline
	 */
	class Simple_Vertical_Timeline {
		/**
		 * Static property to hold our singleton instance
		 *
		 */
		static $instance = FALSE;

		/**
		 * This is our constructor
		 *
		 */
		private function __construct() {

			$this->loadDependecy();

			//Backend
			add_action( 'plugins_loaded', array( $this, 'textdomain' ) );

			// Blocks (Gutenberg)
			add_action( 'init', array( $this, 'register_blocks' ) );

			//front_end
			add_action( 'wp_enqueue_scripts', array(
				$this,
				'add_stylesheet'
			) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_js' ) );
			add_action( 'enqueue_block_assets', array( $this, 'enqueue_icon_library_styles' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
			add_shortcode( 'svt-event', array( $this, 'add_shortcode_event' ) );
			add_shortcode( 'svtimeline', array(
				$this,
				'add_shortcode_timeline'
			) );

			register_activation_hook( __SVT_FILE__, array(
				$this,
				'on_activation'
			) );
			register_deactivation_hook( __SVT_FILE__, array(
				$this,
				'on_deactivation'
			) );

		}

		/**
		 * Register Gutenberg blocks.
		 */
		public function register_blocks() {
			$build_dir = plugin_dir_path( __FILE__ ) . 'blocks/build';
			if ( file_exists( $build_dir . '/timeline/block.json' ) ) {
				register_block_type( $build_dir . '/timeline' );
			}
			if ( file_exists( $build_dir . '/event/block.json' ) ) {
				register_block_type( $build_dir . '/event' );
			}
		}

		function loadDependecy() {
			require_once( 'admin/svt-settings.php' );
			new SVT_Settings();
		}

		/**
		 * Installation. Runs on activation.
		 */
		public function on_activation() {
			update_option( SVT_Settings::OPTION_ANALITYCS, TRUE );
			update_option( SVT_Settings::OPTION_SIGNE, TRUE );
		}

		/**
		 * Deactivation Function
		 */
		public function on_deactivation() {
			delete_option( SVT_Settings::OPTION_ANALITYCS );
			delete_option( SVT_Settings::OPTION_SIGNE );
		}


		/**
		 * If an instance exists, this returns it.  If not, it creates one and
		 * retuns it.
		 *
		 * @return Simple_Vertical_Timeline
		 */
		public static function getInstance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * load textdomain
		 *
		 * @return void
		 */
		public function textdomain() {
			load_plugin_textdomain( 'svt', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}


		/**
		 * add style
		 */
		function add_js() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

			// Respects SSL, Style.css is relative to the current file
			wp_register_script( 'svt-script', plugins_url( 'js/svt-animation' . $suffix, __FILE__ ), array( 'jquery' ) );
			wp_enqueue_script( 'svt-script' );


		}


		/**
		 * add style
		 */
		function add_stylesheet() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';
			wp_register_style( 'svt-style', plugins_url( 'css/simple-vertical-timeline' . $suffix, __FILE__ ) );
			wp_enqueue_style( 'svt-style' );
			$this->enqueue_icon_library_styles();

			wp_register_style( 'svt-linearicons', plugins_url( 'img/linearicons/style.css', __FILE__ ), array( 'svt-style' ) );
			wp_enqueue_style( 'svt-linearicons' );
		}

		/**
		 * Load icon library styles for both frontend and editor.
		 */
		function enqueue_icon_library_styles() {
			wp_register_style(
				'svt-bootstrap-icons',
				plugins_url( 'assets/vendor/bootstrap-icons/font/bootstrap-icons.min.css', __FILE__ ),
				array(),
				SVT_VER
			);
			wp_enqueue_style( 'svt-bootstrap-icons' );
		}

		/**
		 * Editor-side assets.
		 */
		function enqueue_editor_assets() {
			$this->enqueue_icon_library_styles();
		}

		/**
		 * Add short code for the single event
		 *
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function add_shortcode_event( $atts, $content = NULL ) {
			// Attributes
			$atts = shortcode_atts(
				array(
					'icon'         => plugins_url( 'img/cd-icon-location.svg', __FILE__ ),
					'title'        => '',
					'date'         => date( "Y-m-d H:i" ),
					'class'        => 'svt-cd-green',
					'button_label' => 'More',
					'button_link'  => '',
					'title_class'  => ''
				),
				$atts,
				'svt-event'
			);

			if ( ! empty( $atts['button_link'] ) ) {
				$safe_link = esc_url( $atts['button_link'] );
				if ( ! empty( $safe_link ) ) {
					$buttons = '<a href="' . $safe_link . '" class="svt-cd-read-more" target="_blank" rel="noopener noreferrer">' . esc_html( $atts['button_label'] ) . '</a>';
				} else {
					$buttons = '';
				}
			} else {
				$buttons = '';
			}

			return '
			<div class="svt-cd-timeline-block">
			<a class="svt-cd-timeline-anchor" name="' . esc_attr( sanitize_title( $atts['title'] ) ) . '"></a>
			<div class="svt-cd-timeline-img ' . esc_attr( $atts['class'] ) . '">
			<img src="' . esc_url( $atts['icon'] ) . '" alt="' . esc_attr__( 'Picture', 'svt' ) . '">
			</div> <!-- svt-cd-timeline-img -->
			<div class="svt-cd-timeline-content">
			<h2 class="svt-cd-timeline-content-title ' . esc_attr( trim( $atts['title_class'] ) ) . '">' . esc_html( $atts['title'] ) . '</h2>
			<p class="svt-cd-timeline-content-body">' . do_shortcode( $content ) . '</p>
			<p class="svt-cd-timeline-content-btm-more"> ' . $buttons . '</p>
			<span class="svt-cd-date">' . esc_html( $atts['date'] ) . '</span>
			</div> <!-- svt-cd-timeline-content -->
			</div> <!-- svt-cd-timeline-block -->';
		}


		/**
		 * Add the shortcode for the full time line
		 *
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function add_shortcode_timeline( $atts = NULL, $content = NULL ) {

			/*$atts = shortcode_atts(
				array(
					'id' => uniqid( "svt-cd-timeline-" )
				),
				$atts,
				'svtimeline'
			);*/

			$out = "<dev>";
			$out .= ' <div class="svt-cd-timeline svt-cd-container">' . do_shortcode( $content ) . '</div> <!-- cd-timeline -->';
			$out .= ' <div style=\'' . SVT_Settings::get_sign() . '\'>powered by <a href="http://www.staniscia.net/simple-vertical-timeline/" target="_blank" rel="noopener noreferrer">SimpleVerticalTimeline</a>' . SVT_Settings::get_contrib() . '</div>';
			$out .= "</dev>";

			return $out;
		}

	}/// end class

}

// Instantiate our class
$Simple_Vertical_Timeline = Simple_Vertical_Timeline::getInstance();







