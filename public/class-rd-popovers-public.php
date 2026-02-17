<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.paulramotowski.com
 * @since      1.0.0
 *
 * @package    Rd_Popovers
 * @subpackage Rd_Popovers/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rd_Popovers
 * @subpackage Rd_Popovers/public
 * @author     Paul Ramotowski <paulramotowski@gmail.com>
 */
class Rd_Popovers_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rd_Popovers_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rd_Popovers_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rd-popovers-public.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'css/rd-popovers-public.css' ), 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rd_Popovers_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rd_Popovers_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rd-popovers-public.js', array( 'jquery' ), filemtime( plugin_dir_path( __FILE__ ) . 'js/rd-popovers-public.js' ), false );

	}

	/**
	 * Register plugin shortcodes.
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'scroll_popup_trigger', array( $this, 'scroll_popup_trigger_shortcode' ) );
	}

	/**
	 * Render the scroll_popup_trigger shortcode.
	 *
	 * Triggers a popup at a configurable scroll depth, or immediately if the page
	 * is not scrollable. Uses session storage to show only once per session.
	 *
	 * Usage: [scroll_popup_trigger delay="1000" scroll="50"]Your content here[/scroll_popup_trigger]
	 *
	 * @since    1.0.0
	 * @param    array     $atts     Shortcode attributes.
	 * @param    string    $content  Shortcode content.
	 * @return   string              HTML output.
	 */
	public function scroll_popup_trigger_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'delay'  => '0',
				'scroll' => '30',
			),
			$atts,
			'scroll_popup_trigger'
		);

		$scroll = intval( $atts['scroll'] );
		$scroll = max( 0, min( 100, $scroll ) );

		$popup_id = 'scroll-popup-' . uniqid();

		ob_start();
		?>
		<div id="<?php echo esc_attr( $popup_id ); ?>"
		     class="spt-popup-overlay"
		     data-delay="<?php echo esc_attr( $atts['delay'] ); ?>"
		     data-scroll="<?php echo esc_attr( $scroll ); ?>"
		     aria-hidden="true"
		     role="dialog"
		     aria-modal="true">
			<div class="spt-popup-container">
				<div class="spt-popup-content">
					<button class="spt-popup-close" aria-label="Close popup">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<line x1="18" y1="6" x2="6" y2="18"></line>
							<line x1="6" y1="6" x2="18" y2="18"></line>
						</svg>
					</button>
					<div class="spt-popup-inner">
						<?php echo do_shortcode( $content ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

}
