<?php

namespace ElementinvaderAddonsForElementor\Widgets;

use ElementinvaderAddonsForElementor\Core\Elementinvader_Base;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Editor;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use ElementinvaderAddonsForElementor\Modules\Forms\Ajax_Handler;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0 
 */
class EliBlog_Preview_Meta extends Elementinvader_Base {

    // Default widget settings
    public $defaults = array();
    public $view_folder = 'blog_preview';
    public $items_num = 0;

    public function __construct($data = array(), $args = null) {
        wp_enqueue_style('eli-main', plugins_url('/assets/css/main.css', ELEMENTINVADER_ADDONS_FOR_ELEMENTOR__FILE__));
        parent::__construct($data, $args);
    }

    /**
     * Retrieve the widget name.
     *
     * @since 1.1.0 
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'eli-blog-preview-meta';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Eli Blog Preview Meta', 'elementinvader-addons-for-elementor');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-tags';
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function register_controls() {
      
        /* TAB_STYLE */

		$this->start_controls_section(
			'config',
			[
				'label' => __( 'Config', 'elementinvader-addons-for-elementor' ),
			]
		);

        $this->add_control(
            'link_enabled',
            [
                'label' => esc_html__( 'Link to Post', 'elementinvader-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'elementinvader-addons-for-elementor' ),
                'label_off' => esc_html__( 'No', 'elementinvader-addons-for-elementor' ),
                'return_value' =>  'yes',
                'default' => '',
            ]
        );

		$this->add_control(
			'config_fields_title',
			[
				'label'         => __('Custom Title field', 'elementinvader-addons-for-elementor'),
				'type'          => Controls_Manager::TEXT,
				'default'       => '',
			]
		);


        $this->end_controls_section();

        /* TAB_STYLE */

        $items = [
            [
                'key'=>'styles_meta',
                'label'=> esc_html__('Styles', 'wpdirectorykit'),
                'selector_hide'=>'',
                'selector'=>'{{WRAPPER}} .eli_blog_preview_meta',
                'selector_hover'=>'{{WRAPPER}} .eli_blog_preview_meta:hover',
                'selector_focus'=>'',
                'options'=>'full',
            ]
        ];

        foreach ($items as $item) {
            $this->start_controls_section(
                $item['key'].'_section',
                [
                    'label' => $item['label'],
                    'tab' => 'tab_layout'
                ]
            );

            if(!empty($item['selector_hide'])) {
                $this->add_responsive_control(
                    $item['key'].'_hide',
                    [
                        'label' => esc_html__( 'Hide Element', 'wdk-svg-map' ),
                        'type' => Controls_Manager::SWITCHER,
                        'none' => esc_html__( 'Hide', 'wdk-svg-map' ),
                        'block' => esc_html__( 'Show', 'wdk-svg-map' ),
                        'return_value' =>  'none',
                        'default' => ($item['key'] == 'field_button_reset' ) ? 'none':'',
                        'selectors' => [
                            $item['selector_hide'] => 'display: {{VALUE}};',
                        ],
                    ]
                );
            }

            $selectors = array();

            if(!empty($item['selector']))
                $selectors['normal'] = $item['selector'];

            if(!empty($item['selector_hover']))
                $selectors['hover'] = $item['selector_hover'];

            if(!empty($item['selector_focus']))
                $selectors['focus'] = $item['selector_hover'];
                
            $this->generate_renders_tabs($selectors, $item['key'].'_dynamic', $item['options']);

            $this->end_controls_section();
            /* END special for some elements */
        }

        parent::register_controls();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function render() {
        parent::render();

        $id_int = substr($this->get_id_int(), 0, 3);
        $settings = $this->get_settings();
        global $eli_post_id;
        $args = array();
        $object = ['eli_post_id'=>$eli_post_id, 'settings'=>$settings,'id_int'=>$id_int];
                
        $object['is_edit_mode'] = false;          
        if(Plugin::$instance->editor->is_edit_mode())
            $object['is_edit_mode'] = true;

        echo $this->view('meta', $object); 
    }

	public static function ma_el_get_post_types()
	{
		$post_type_args = array(
			'public'            => true,
			'show_in_nav_menus' => true
		);

		$post_types = get_post_types($post_type_args, 'objects');
		$post_lists = array();
		foreach ($post_types as $post_type) {
			$post_lists[$post_type->name] = $post_type->labels->singular_name;
		}
		return $post_lists;
	}

	public static function set_dinamic_field($field_id = '', $field = '', $default = '')
	{
        $out = '';

        // Return post date if requested
        if ($field === 'post_date') {
            $post = get_post($field_id);
            if ($post && !is_wp_error($post)) {
                $out = get_the_date('', $post);
            }
        }
        // Check for taxonomy terms
        elseif (!empty($field) && wp_get_post_terms($field_id, $field, ['fields' => 'names']) && !is_wp_error(wp_get_post_terms($field_id, $field, ['fields' => 'names']))) {
            $out = implode(',', wp_get_post_terms($field_id, $field, ['fields' => 'names']));
        }
        // Check for Meta Box value
        elseif (function_exists('rwmb_meta') && !empty($field) && rwmb_meta($field, [], $field_id)) {
            $out = rwmb_meta($field, [], $field_id);
        }
    
        if (empty($out)) {
            $out = $default;
        }
    
        return $out;
	}
}
