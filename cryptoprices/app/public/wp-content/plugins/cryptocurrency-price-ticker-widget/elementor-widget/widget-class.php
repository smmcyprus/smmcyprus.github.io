<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Add a custom category for panel widgets
add_action( 'elementor/init', function() {
   \Elementor\Plugin::$instance->elements_manager->add_category( 
   	'ccpw',				 // the name of the category
   	[
   		'title' => esc_html__( 'Cryptocurrency Widgets', 'ccpw' ),
   		'icon' => 'fa fa-header', //default icon
   	],
   	1 // position
   );
} );

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class CCPW_WidgetClass {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->ccpw_add_actions();
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'ccpw_editor_styles' ] );
		
	}

	public function ccpw_editor_styles(){
		wp_enqueue_style(
			'ccpw-editor-styles',
			CCPWF_URL  . 'elementor-widget/assets/css/ccpw-editor-styles.css',array()
        );  
	}

	
	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function ccpw_add_actions() {
		add_action( 'elementor/widgets/widgets_registered', array($this, 'ccpw_on_widgets_registered' ));		
	}
	
	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function ccpw_on_widgets_registered() {
		$this->ccpw_widget_includes();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function ccpw_widget_includes() {		
		require_once CCPWF_DIR . 'elementor-widget/cryptocurrency-widgets.php';
	}

}

new CCPW_WidgetClass();