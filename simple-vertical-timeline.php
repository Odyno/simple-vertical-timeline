<?php
/*
Plugin Name: Simple Vertical Timeline
Plugin URI: http://www.staniscia.net/simple-vertical-timeline/
Description: Allow to create a VERY Simple Vertical Timeline on the current blog.
Version: 0.1.1
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
	define( 'SVT_VER', '0.1.1' );
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
			add_action( 'init', array( $this, 'add_tinymce_buttons' ) );
			add_action( 'plugins_loaded', array( $this, 'textdomain' ) );

			//front_end
			add_action( 'wp_enqueue_scripts', array(
				$this,
				'add_stylesheet'
			) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_js' ) );
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

		function loadDependecy() {
			require_once( 'admin/svt-settings.php' );
			new SVT_Settings();
		}

		/**
		 * Installation. Runs on activation.
		 */
		public function on_activation() {
			update_option( SVT_Settings::OPTION_IS_ENABLED_SOLCIAL_MEDIA, TRUE );

			update_option( SVT_Settings::OPTION_ANALITYCS, TRUE );
			update_option( SVT_Settings::OPTION_SIGNE, TRUE );
		}

		/**
		 * Deactivation Function
		 */
		public function on_deactivation() {
			delete_option( SVT_Settings::OPTION_IS_ENABLED_SOLCIAL_MEDIA );

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
		 * Load Tinymce
		 */
		function add_tinymce_buttons() {
			add_filter( "mce_external_plugins", array(
				$this,
				"svt_add_buttons"
			) );
			add_filter( 'mce_buttons', array( $this, 'svt_register_buttons' ) );
		}

		/**
		 * Add custom buttons to Tinymce
		 *
		 * @param $plugin_array
		 *
		 * @return mixed
		 */
		function svt_add_buttons( $plugin_array ) {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

			$plugin_array['svt'] = plugins_url( 'js/svtplugin/svt-plugin' . $suffix, __FILE__ );

			return $plugin_array;
		}

		/**
		 * Add action on custom buttons to Tinymce
		 *
		 * @param $buttons
		 *
		 * @return mixed
		 */
		function svt_register_buttons( $buttons ) {
			array_push( $buttons, 'svtimeline', "svtevent" ); // dropcap', 'recentposts
			return $buttons;
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

			wp_register_style( 'svt-linearicons', plugins_url( 'img/linearicons/style.css', __FILE__ ), array( 'svt-style' ) );
			wp_enqueue_style( 'svt-linearicons' );
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
					'button_link'  => ''
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
			<h2 class="svt-cd-timeline-content-title">' . esc_html( $atts['title'] ) . ' ' . $this->add_share_code( $atts, $content ) . '</h2>
			<p class="svt-cd-timeline-content-body">' . do_shortcode( $content ) . '</p>
			<p class="svt-cd-timeline-content-btm-more"> ' . $buttons . '</p>
			<span class="svt-cd-date">' . esc_html( $atts['date'] ) . '</span>
			</div> <!-- svt-cd-timeline-content -->
			</div> <!-- svt-cd-timeline-block -->';
		}

		/**
		 * Add shortcode on the events
		 *
		 * @param $atts
		 * @param $content
		 *
		 * @return string
		 */
		function add_share_code( $atts, $content ) {
			if ( is_null( $content ) ) {
				$content = "";
			}


			// Get Post Thumbnail for pinterest
			$crunchifyThumbnail = NULL;

			$image_evento = $this->recupera_immagine( $content );
			if ( empty( $image_evento ) ) {
				$thumbnail_id  = get_post_thumbnail_id( get_the_ID() );
				$image_articolo = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : '';

				if ( ! empty( $image_articolo ) ) {
					$crunchifyThumbnail = esc_url( $image_articolo );
				}

			} else {
				$crunchifyThumbnail = esc_url( $image_evento );
			}

			// Get current page URL
			$planUrl = wp_get_shortlink() . '#' . esc_attr( sanitize_title( $atts['title'] ) );

			// Get current page title
			$crunchifyTitle = substr( urlencode( strip_tags( $content ) ), 0, 135 - strlen( urlencode( $planUrl ) ) );

			if ( empty( $crunchifyTitle ) ) {
				$crunchifyTitle = urlencode( get_the_title() );
			}

			// Add sharing button at the end of page/page content
			$content = '<span class="svt-share">';
			$content .= ' <span class="lnr lnr-link svt-share-icon"/>';
			$content .= ' <span class="svt-sharebox">';
			if ( get_option( SVT_Settings::OPTION_IS_ENABLED_SOLCIAL_MEDIA ) == "1" ) {

				// Construct sharing URL without using any script
				$twitterURL   = 'https://twitter.com/intent/tweet?text=' . $crunchifyTitle . '&amp;url=' . urlencode( $planUrl );
				$facebookURL  = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $planUrl );
				$googleURL    = 'https://plus.google.com/share?url=' . urlencode( $planUrl );
				$whatsappURL  = 'whatsapp://send?text=' . $crunchifyTitle . ' ' . urlencode( $planUrl );
				$linkedInURL  = 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( $planUrl ) . '&amp;title=' . $crunchifyTitle;
				$pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . urlencode( $planUrl ) . '&amp;media=' . urlencode( $crunchifyThumbnail ) . '&amp;description=' . $crunchifyTitle;

				$content .= '<a href="' . esc_url( $twitterURL ) . '" target="_blank" rel="noopener noreferrer"><span class="svt-icon-twitter"></span></a>';
				$content .= '<a href="' . esc_url( $facebookURL ) . '" target="_blank" rel="noopener noreferrer"><span class="svt-icon-facebook"></span></a>';
				$content .= '<a href="' . esc_url( $whatsappURL ) . '" target="_blank" rel="noopener noreferrer"><span class="svt-icon-whatsapp"></span></a>';
				$content .= '<a href="' . esc_url( $googleURL ) . '" target="_blank" rel="noopener noreferrer"><span class="svt-icon-googleplus"></span></a>';
				$content .= '<a href="' . esc_url( $linkedInURL ) . '" target="_blank" rel="noopener noreferrer"><span class="svt-icon-linkedin"></span></a>';
				$content .= '<a href="' . esc_url( $pinterestURL ) . '" target="_blank" rel="noopener noreferrer"><span class="svt-icon-pinterest"></span></a>';
			}

			$content .= ' <a href="#" onclick="window.prompt(\'Copy this link:\', \'' . esc_js( $planUrl ) . '\')" ><span class="svt-icon-external-link"></span></a>';
			$content .= ' </span>';
			$content .= '</span>';


			return $content;

		}

		function recupera_immagine( $content ) {
			$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );
			$out    = NULL;
			if ( $output != 0 ) {
				$out = $matches[1][0];
			}

			return $out;
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







