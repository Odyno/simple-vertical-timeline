<?php
/*
Plugin Name: Simple Vertical Timeline
Plugin URI: http://www.staniscia.net/simple-vertical-timeline/
Description: Allow to create a VERY Simple Vertical Timeline on the current blog.
Version: 0.0.2
Author: Alessandro Staniscia
Author URI: ttp://www.staniscia.net
License: GPL2


Simple Vertical Timeline is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Simple Vertical Timeline. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.html.

*/


if( !defined( 'SVT_VER' ) )
	/**
	 *
	 */
	define( 'SVT_VER', '0.0.2' );


// Start up the engine
/**
 * Class Simple_Vertical_Timeline
 */
class Simple_Vertical_Timeline {
	/**
	 * Static property to hold our singleton instance
	 *
	 */
	static $instance = false;

	/**
	 * This is our constructor
	 *
	 * @return void
	 */
	private function __construct() {

		//Backend
		add_action( 'init', array( $this, 'add_tinymce_buttons' ) );
		add_action( 'plugins_loaded', array( $this, 'textdomain' ) );

		//front_end
		add_action( 'wp_enqueue_scripts', array( $this, 'add_stylesheet' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_js' ) );
		add_shortcode( 'svt-event', array( $this, 'add_shortcode_event' ) );
		add_shortcode( 'svtimeline', array( $this, 'add_shortcode_timeline' ) );
	}

	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * retuns it.
	 *
	 * @return WP_Comment_Notes
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
		load_plugin_textdomain( 'svt', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}


	/**
	 * Load Tinymce
	 */
	function add_tinymce_buttons() {
		add_filter( "mce_external_plugins", array($this,"svt_add_buttons") );
		add_filter( 'mce_buttons', array($this,'svt_register_buttons') );
	}

	/**
	 * Add custom buttons to Tinymce
	 *
	 * @param $plugin_array
	 *
	 * @return mixed
	 */
	function svt_add_buttons( $plugin_array ) {
		$plugin_array['svt'] = plugins_url('js/svtplugin/svt-plugin.js', __FILE__);
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
		array_push( $buttons, 'svtimeline',"svtevent" ); // dropcap', 'recentposts
		return $buttons;
	}

	/**
	 * add style
	 */
	function add_js() {
		// Respects SSL, Style.css is relative to the current file
		wp_register_script('svt-script', plugins_url('js/svt-animation.js', __FILE__), array( 'jquery' ) );
		wp_enqueue_script( 'svt-script');
	}


	/**
	 * add style
	 */
	function add_stylesheet() {
		// Respects SSL, Style.css is relative to the current file
		wp_register_style( 'svt-style', plugins_url('css/simple-vertical-timeline.css', __FILE__) );
		wp_enqueue_style( 'svt-style' );
	}

	/**
	 * Add short code for the single event
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	function add_shortcode_event( $atts , $content = null ) {
		// Attributes
		$atts = shortcode_atts(
			array(
				'icon' => plugins_url('img/cd-icon-location.svg', __FILE__),
				'title' => '',
				'date' => date("Y-m-d H:i"),
				'class' => 'svt-cd-green',
				'button_label' => 'More',
				'button_link' => ''
			),
			$atts,
			'svt-event'
		);

		if ( ! empty($atts['button_link']) )
		  $buttons='<a href="'.$atts['button_link'].'" class="svt-cd-read-more" target="_new">'.$atts['button_label'].'</a>';
		else
		  $buttons=''; // none now <a href="#0" class="svt-cd-read-more">pluto</a>';

		return ' 
 		<div class="svt-cd-timeline-block">
			<div class="svt-cd-timeline-img '.$atts['class'].' is-hidden">
				<img src="'.$atts['icon'].'" alt="Picture">
			</div> <!-- svt-cd-timeline-img -->

			<div class="svt-cd-timeline-content is-hidden">
				<h2>'.$atts['title'].'</h2>
				'.do_shortcode($content).'<br>
				'.$buttons.'
				<span class="svt-cd-date">'.$atts['date'].'</span>
			</div> <!-- svt-cd-timeline-content -->
		</div> <!-- svt-cd-timeline-block -->
		';

	}


	/**
	 * Add the shortcode for the full time line
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	function add_shortcode_timeline( $atts , $content = null ) {

		$atts = shortcode_atts(
			array(
				'id' => uniqid("svt-cd-timeline-")
			),
			$atts,
			'svtimeline'
		);

		return '<section id="svt-cd-timeline" class="svt-cd-container">'.do_shortcode($content).'</section> <!-- cd-timeline -->';
	}

}/// end class



// Instantiate our class
$Simple_Vertical_Timeline = Simple_Vertical_Timeline::getInstance();







