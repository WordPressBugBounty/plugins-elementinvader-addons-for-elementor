<?php
namespace ELI;
use ELI\Widgets;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class EliPlugin {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/widgets/register', [ $this, 'on_widgets_registered' ] );

		add_action( 'elementor/frontend/after_register_scripts', function()
		{
			wp_register_script( 'elementinvader_addons_for_elementor-main', plugins_url( '/assets/js/main.js', ELI_FILE__ ), [ 'jquery' ], false, true );
		} );
	}
        
	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
		$this->register_modules();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
            
                require_once ( ELI_PATH."/core/Elementinvader_Base.php");
                
                require_once(ELI_PATH.'modules/forms/ajax-handler.php');
                
                require_once(ELI_PATH.'widgets/contact-form.php');
                require_once(ELI_PATH.'widgets/map.php');
                require_once(ELI_PATH.'widgets/menu.php');
                require_once(ELI_PATH.'widgets/newsletter.php');
                require_once(ELI_PATH.'widgets/blog-search.php');
                require_once(ELI_PATH.'widgets/blog-grid.php');
                require_once(ELI_PATH.'widgets/slider.php');
                require_once(ELI_PATH.'widgets/pageloader.php');
                require_once(ELI_PATH.'widgets/current-date.php');
                require_once(ELI_PATH.'widgets/logo.php');
                require_once(ELI_PATH.'widgets/blog-post-counter.php');
                require_once(ELI_PATH.'widgets/blog-preview-thumbnail.php');
                require_once(ELI_PATH.'widgets/blog-preview-title.php');
                require_once(ELI_PATH.'widgets/blog-preview-content.php');
                require_once(ELI_PATH.'widgets/blog-preview-button.php');
                require_once(ELI_PATH.'widgets/blog-preview-category.php');
                require_once(ELI_PATH.'widgets/blog-preview-meta.php');
                require_once(ELI_PATH.'widgets/blog-preview-button-custom.php');

						
				if (
					class_exists('\ELI\Widgets\EliContact_Form') &&
					! class_exists('\ElementinvaderAddonsForElementor\Widgets\EliContact_Form')
				) {
					class_alias(
						'\ELI\Widgets\EliContact_Form',
						'\ElementinvaderAddonsForElementor\Widgets\EliContact_Form'
					);
				}

				do_action('eli/includes');
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
            $this->addtp_register('ELI\Widgets\EliContact_Form');
            $this->addtp_register('ELI\Widgets\EliMap');
            $this->addtp_register('ELI\Widgets\EliMenu');
            $this->addtp_register('ELI\Widgets\EliNewsletter');
            $this->addtp_register('ELI\Widgets\EliBlog_Search');
            $this->addtp_register('ELI\Widgets\EliBlog_Grid');
            $this->addtp_register('ELI\Widgets\EliSlider');
            $this->addtp_register('ELI\Widgets\EliPageLoader');
            $this->addtp_register('ELI\Widgets\EliCurrentDate');
            $this->addtp_register('ELI\Widgets\EliLogo');
            $this->addtp_register('ELI\Widgets\EliBlog_Post_Counter');
            $this->addtp_register('ELI\Widgets\EliBlog_Preview_Title');
            $this->addtp_register('ELI\Widgets\EliBlog_Preview_Content');
            $this->addtp_register('ELI\Widgets\EliBlog_Preview_Thumbnail');
            $this->addtp_register('ELI\Widgets\EliBlog_Preview_Button');
            $this->addtp_register('ELI\Widgets\EliBlog_Preview_Category');
            $this->addtp_register('ELI\Widgets\EliBlog_Preview_Meta');
            $this->addtp_register('ELI\Widgets\EliBlog_Preview_Button_Custom');

			do_action('eli/register_widget');
	}
	
	public function addtp_register($class = ''){
		if(class_exists($class))
		{
			$object = new $class();
			\Elementor\Plugin::instance()->widgets_manager->register( $object );
		};
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_modules() {
		
	}
}

add_action( 'elementor/init', function() {
	new EliPlugin();
	do_action('eli/init');
});



