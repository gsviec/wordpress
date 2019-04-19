<?php

// Customizer / WP Methods
$sep = 0;

add_action( 'customize_register','getbowtied_customizer' );
function getbowtied_customizer( $wp_customize ) {

	// Add Panels
	$wp_customize->add_panel( 'panel_header', array(
		'title'          => esc_html__( 'Header', 'shopkeeper' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );

	// Add Panels
	$wp_customize->add_panel( 'panel_shop', array(
		'title'          => esc_html__( 'Shop', 'shopkeeper' ),
		'priority'       => 6,
		'capability'     => 'edit_theme_options',
	) );

	$wp_customize->add_panel( 'panel_blog', array(
		'title'          => esc_html__( 'Blog', 'shopkeeper' ),
		'priority'       => 8,
		'capability'     => 'edit_theme_options',
	) );
}

add_action( 'customize_register', 'kirki_custom_control_separator' );
function kirki_custom_control_separator( $wp_customize ) {

	class Kirki_Control_Separator extends WP_Customize_Control {
		public $type = 'separator';
		public function render_content() {
			if ( ! $this->label ) :
				echo '<hr />';
			else :
				echo '<h3>' . $this->label . '</h3>';
			endif;
		}
	}

	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['separator'] = 'Kirki_Control_Separator';
		return $controls;
	} );
}

add_action( 'customize_register', 'kirki_custom_control_collapsible' );
function kirki_custom_control_collapsible( $wp_customize ) {

	class Kirki_Control_Collapsible extends WP_Customize_Control {
		public $type = 'collapsible';
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			if ( ! empty( $args['slug'] ) ) {
				$this->slug = $args['slug'];
			}
		}

		public function render_content() { 
		?>
			<div class="customizer-control-collapsible">
				<span class="<?php echo esc_html( $this->slug ); ?>"></span>
				<h3><?php echo esc_html( $this->label ); ?></h3>
			</div>
		<?php
		}
	}

	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['collapsible'] = 'Kirki_Control_Collapsible';
		return $controls;
	} );
}

function add_my_custom_font( $standard_fonts ) {
    $fonts["Radnika"] = array(
        "label" => "Radnika",
        "stack" => "Radnika"
    );

    $fonts["NeueEinstellung"] = array(
        "label" => "NeueEinstellung",
        "stack" => "NeueEinstellung",
    );

    $fonts["Arial, Helvetica, sans-serif"] = array(
        "label" => "Arial, Helvetica, sans-serif",
        "stack" => "Arial, Helvetica, sans-serif",
    );

    $fonts["Arial Black, Gadget, sans-serif"] = array(
        "label" => "Arial Black, Gadget, sans-serif",
        "stack" => "Arial Black, Gadget, sans-serif",
    );

    $fonts["Bookman Old Style, serif"] = array(
        "label" => "Bookman Old Style, serif",
        "stack" => "Bookman Old Style, serif",
    );

    $fonts["Comic Sans MS, cursive"] = array(
        "label" => "Comic Sans MS, cursive",
        "stack" => "Comic Sans MS, cursive",
    );

    $fonts["Courier, monospace"] = array(
        "label" => "Courier, monospace",
        "stack" => "Courier, monospace",
    );

    $fonts["Garamond, serif" ] = array(
        "label" => "Garamond, serif" ,
        "stack" => "Garamond, serif" ,
    );

    $fonts["Georgia, serif"] = array(
        "label" => "Georgia, serif",
        "stack" => "Georgia, serif",
    );

    $fonts["Impact, Charcoal, sans-serif"] = array(
        "label" => "Impact, Charcoal, sans-serif",
        "stack" => "Impact, Charcoal, sans-serif",
    );

    $fonts["Lucida Console, Monaco, monospace"] = array(
        "label" => "Lucida Console, Monaco, monospace",
        "stack" => "Lucida Console, Monaco, monospace",
    );

    $fonts["MS Sans Serif, Geneva, sans-serif"] = array(
        "label" => "MS Sans Serif, Geneva, sans-serif",
        "stack" => "MS Sans Serif, Geneva, sans-serif",
    );

    $fonts["MS Serif, New York, sans-serif"] = array(
        "label" => "MS Serif, New York, sans-serif",
        "stack" => "MS Serif, New York, sans-serif",
    );

    $fonts["Palatino Linotype, Book Antiqua, Palatino, serif"] = array(
        "label" => "Palatino Linotype, Book Antiqua, Palatino, serif",
        "stack" => "Palatino Linotype, Book Antiqua, Palatino, serif",
    );

    $fonts["Tahoma,Geneva, sans-serif"] = array(
        "label" => "Tahoma,Geneva, sans-serif",
        "stack" => "Tahoma,Geneva, sans-serif",
    );

    $fonts["Times New Roman, Times,serif" ] = array(
        "label" => "Times New Roman, Times,serif" ,
        "stack" => "Times New Roman, Times,serif" ,
    );

    $fonts["Trebuchet MS, Helvetica, sans-serif"] = array(
        "label" => "Trebuchet MS, Helvetica, sans-serif",
        "stack" => "Trebuchet MS, Helvetica, sans-serif",
    );

    $fonts["Verdana, Geneva, sans-serif" ] = array(
        "label" => "Verdana, Geneva, sans-serif" ,
        "stack" => "Verdana, Geneva, sans-serif" ,
    );
    
    return $fonts;
}
add_filter( 'kirki/fonts/standard_fonts', 'add_my_custom_font' );

function shopkeeper_customizer_backend_styles() { ?>
	<style>
		#customize-controls .customize-control.customize-control-separator h3 {
			font-size: 11px;
			text-transform: uppercase;
		}
		#customize-controls .customize-control-kirki-image img {
			max-height: 80px;
		}

		.customize-pane-parent {
			display: flex;
			-webkit-flex-direction: column;
			    -ms-flex-direction: column;
			        flex-direction: column;
		}

		.customize-pane-parent > li:first-child {
			-webkit-order: 0;
			    -ms-order: 0;
			        order: 0;
		}

		.customize-pane-parent > li {
			-webkit-order: 99;
			    -ms-order: 99;
			        order: 99;
		}

		li#accordion-panel-panel_header {
			-webkit-order: 1;
			    -ms-order: 1;
			        order: 1;
		}

		li#accordion-section-footer {
			-webkit-order: 2;
			    -ms-order: 2;
			        order: 2;
		}

		li#accordion-section-styling {
			-webkit-order: 3;
			    -ms-order: 3;
			        order: 3;
		}

		li#accordion-section-fonts {
			-webkit-order: 4;
			    -ms-order: 4;
			        order: 4;
		}

		li#accordion-section-blog {
			-webkit-order: 7;
			    -ms-order: 7;
			        order: 7;
		}

		li#accordion-panel-panel_shop {
			-webkit-order: 6;
			    -ms-order: 6;
			        order: 6;
		}

		li#accordion-section-product {
			-webkit-order: 6;
			    -ms-order: 6;
			        order: 6;
		}
	</style>
	<?php

}
add_action( 'customize_controls_print_styles', 'shopkeeper_customizer_backend_styles', 999 );


if ( class_exists( 'Kirki' ) ) {

	// **************************************
	// Configs
	// **************************************
	Kirki::add_config( 'shopkeeper', array(
		'capability'        => 'edit_theme_options',
		'option_type'       => 'theme_mod',
		'disable_output'    => true,
	) );

	// **************************************
	// Sections
	// **************************************
	Kirki::add_section( 'header_style', array(
		'title'          => esc_attr__('Header Styles', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_elements', array(
		'title'          => esc_attr__( 'Header Elements', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_logo', array(
		'title'          => esc_attr__( 'Logo', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'top_bar', array(
		'title'          => esc_attr__( 'Top Bar', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'sticky_header', array(
		'title'          => esc_attr__( 'Sticky Header', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'search', array(
		'title'          => esc_attr__( 'Search', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'footer', array(
		'title'          => esc_attr__( 'Footer', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
	) );

	//==============================================================================
	//	Blog Sections
	//==============================================================================
	Kirki::add_section( 'blog_archive', array(
		'title'          => esc_attr__( 'Blog Posts Archive', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'			 => 'panel_blog'
	) );

	Kirki::add_section( 'single_post', array(
		'title'          => esc_attr__( 'Single Post', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'			 => 'panel_blog'
	) );

	//==============================================================================
	//	Shop Sections
	//==============================================================================
	Kirki::add_section( 'shop_layout', array(
		'title'          => esc_attr__( 'Shop Layout', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'			 => 'panel_shop'
	) );

	Kirki::add_section( 'product_card', array(
		'title'          => esc_attr__( 'Product Card', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'			 => 'panel_shop'
	) );

	Kirki::add_section( 'shop_notifications', array(
		'title'          => esc_attr__( 'Shop Notifications', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'			 => 'panel_shop'
	) );

	Kirki::add_section( 'product_badges', array(
		'title'          => esc_attr__( 'Product Badges', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'			 => 'panel_shop'
	) );

	Kirki::add_section( 'mobile_settings', array(
		'title'          => esc_attr__( 'Mobile Settings', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'			 => 'panel_shop'
	) );

	Kirki::add_section( 'catalog_mode', array(
		'title'          => esc_attr__( 'Catalog Mode', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'			 => 'panel_shop'
	) );

	Kirki::add_section( 'product', array(
		'title'          => esc_attr__( 'Product Page', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'styling', array(
		'title'          => esc_attr__( 'Styling', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'fonts', array(
		'title'          => esc_attr__( 'Fonts', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'social_media', array(
		'title'          => esc_attr__( 'Social Media', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'custom_code', array(
		'title'          => esc_attr__( 'Custom Code', 'shopkeeper' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
	) );


	// **************************************
	// Fields
	// **************************************

	/**
	 * HEADER
	 */

		/* Header Styles */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-image',
				'settings'    => 'main_header_layout',
				'label'       => esc_attr__( 'Header Layout', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => '1',
				'priority'    => 10,
				'choices'     => array(
						'1'         => get_template_directory_uri() . '/images/theme_options/icons/header_1.png',
						'11'        => get_template_directory_uri() . '/images/theme_options/icons/header_1b.png',
						'2'         => get_template_directory_uri() . '/images/theme_options/icons/header_2.png',
						'22'        => get_template_directory_uri() . '/images/theme_options/icons/header_2b.png',
						'3'         => get_template_directory_uri() . '/images/theme_options/icons/header_3.png',
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'slider',
				'settings'    => 'main_header_font_size',
				'label'       => esc_attr__( 'Navigation Font Size', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => '13',
				'choices'     => array(
						'min'  => 11,
						'max'  => 16,
						'step' => 1,
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'main_header_font_color',
				'label'       => esc_attr__( 'Navigation Font Color', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => '#000',
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'background',
				'settings'    => 'main_header_background',
				'label'       => esc_attr__( 'Header Background Color', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'	  => array('background-color' => '#FFFFFF'),
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
			    'type'        => 'slider',
			    'settings'    => 'spacing_above_logo',
			    'label'       => esc_html__( 'Spacing Above the Logo', 'shopkeeper' ),
			    'section'     => 'header_style',
			    'default'     => 20,
			    'priority'    => 10,
			    'choices'     => array(
			        'min'  => 0,
			        'max'  => 200,
			        'step' => 1,
			    ),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'slider',
				'settings'    => 'spacing_below_logo',
				'label'       => esc_html__( 'Spacing Below the Logo', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => 20,
				'priority'    => 10,
				'choices'     => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'header_width',
				'label'       => esc_html__( 'Header Width', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => 'custom',
				'priority'    => 10,
				'choices'     => array(
						'full'  => 'Full',
						'custom'    => 'Custom',
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'slider',
				'settings'    => 'header_max_width',
				'label'       => esc_html__( 'Custom Max Width', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => 1680,
				'priority'    => 10,
				'choices'     => array(
						'min'  => 960,
						'max'  => 1680,
						'step' => 1,
					),
				'active_callback'    => array(
					array(
						'setting'  => 'header_width',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'Header Transparency',
				'settings'    => 'main_header_transparency_collapsible',
				'slug'    	  => 'main_header_transparency_collapsible',
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'main_header_transparency',
				'label'       => esc_attr__( 'Transparent Header', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => false,
				'description' => '<span class="dashicons dashicons-editor-help"></span><a target="_blank" href="https://shopkeeper.wp-theme.help/hc/en-us/articles/206678899">Working with Header Transparency</a>',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'main_header_transparency_scheme',
				'label'       => esc_attr__( 'Default Transparency Color Scheme', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => 'transparency_light',
				'priority'    => 10,
				'choices'     => array(
						'transparency_light'    => 'Light Transparency',
						'transparency_dark'     => 'Dark Transparency',
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'Light Transparency Scheme',
				'settings'    => 'main_header_transparent_light_collapsible',
				'slug'    	  => 'main_header_transparent_light_collapsible',
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'main_header_transparent_light_color',
				'label'       => esc_attr__( 'Text / Icon Color', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => '#fff',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'light_transparent_header_logo',
				'label'       => esc_attr__( 'Logo Light', 'shopkeeper' ),
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'Dark Transparency Scheme',
				'settings'    => 'main_header_transparent_dark_collapsible',
				'slug'    	  => 'main_header_transparent_dark_collapsible',
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'main_header_transparent_dark_color',
				'label'       => esc_attr__( 'Text / Icon Color', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => '#fff',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'dark_transparent_header_logo',
				'label'       => esc_attr__( 'Logo Dark', 'shopkeeper' ),
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'Product Categories Transparency',
				'settings'    => 'main_product_categories_transparency_collapsible',
				'slug'    	  => 'main_product_categories_transparency_collapsible',
				'section'     => 'header_style',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'shop_category_header_transparency_scheme',
				'label'       => esc_attr__( 'Product Categories Transparency', 'shopkeeper' ),
				'section'     => 'header_style',
				'default'     => 'no_transparency',
				'priority'    => 10,
				'choices'     => array(
						'inherit'               => 'Same as Above',
						'no_transparency'       => 'No Transparency',
						'transparency_light'    => 'Light Transparency',
						'transparency_dark'     => 'Dark Transparency',
					),
			));

		/* Header Elements */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'Wishlist',
				'settings'    => 'header_wishlist_collapsible',
				'slug'    	  => 'header_wishlist_collapsible',
				'section'     => 'header_elements',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'main_header_wishlist',
				'label'       => esc_attr__( 'Wishlist Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'description' => '<span class="dashicons dashicons-editor-help"></span>Requires the <a target="_blank" href="https://wordpress.org/plugins/yith-woocommerce-wishlist/">YITH WooCommerce Wishlist</a> plugin.',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'default'	  => '<hr />',
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_wishlist',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'main_header_wishlist_icon',
				'label'       => esc_html__( 'Custom Wishlist Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_wishlist',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'Shopping Cart',
				'settings'    => 'header_shopping_cart_collapsible',
				'slug'    	  => 'header_shopping_cart_collapsible',
				'section'     => 'header_elements',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'main_header_shopping_bag',
				'label'       => esc_attr__( 'Shopping Cart Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'default'	  => '<hr />',
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_shopping_bag',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'main_header_shopping_bag_icon',
				'label'       => esc_html__( 'Custom Shopping Cart Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_shopping_bag',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'default'	  => '<hr />',
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_shopping_bag',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'option_minicart',
				'label'       => esc_attr__( 'Cart Icon Function', 'shopkeeper' ),
				'section'     => 'header_elements',
				'default'     => '1',
				'priority'    => 10,
				'choices'     => array(
						'1'     => esc_attr__( 'Mini Cart', 'shopkeeper' ),
						'2'     => esc_attr__( 'Link', 'shopkeeper' ),
					),
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_shopping_bag',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'option_minicart_open',
				'label'       => esc_attr__( 'Open Mini Cart On', 'shopkeeper' ),
				'section'     => 'header_elements',
				'default'     => '1',
				'priority'    => 10,
				'choices'     => array(
						'1'     => esc_attr__( 'Click', 'shopkeeper' ),
						'2'     => esc_attr__( 'Hover', 'shopkeeper' ),
					),
				'active_callback'    => array(
					array(
						'setting'  => 'option_minicart',
						'operator' => '==',
						'value'    => '1',
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'main_header_minicart_message',
				'label'       => esc_attr__( 'Mini Cart Message', 'shopkeeper' ),
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_shopping_bag',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'option_minicart',
						'operator' => '==',
						'value'    => '1',
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'My Account',
				'settings'    => 'header_my_account_collapsible',
				'slug'    	  => 'header_my_account_collapsible',
				'section'     => 'header_elements',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'my_account_icon_state',
				'label'       => esc_attr__( 'My Account Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'default'	  => '<hr />',
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'my_account_icon_state',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'custom_my_account_icon',
				'label'       => esc_html__( 'Custom My Account Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'my_account_icon_state',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'Search',
				'settings'    => 'header_search_collapsible',
				'slug'    	  => 'header_search_collapsible',
				'section'     => 'header_elements',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'main_header_search_bar',
				'label'       => esc_attr__( 'Search Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'default'	  => '<hr />',
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_search_bar',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'main_header_search_bar_icon',
				'label'       => esc_html__( 'Custom Search Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_search_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'collapsible',
				'label'		  => 'Off-Canvas Drawer',
				'settings'    => 'header_offcanvas_collapsible',
				'slug'    	  => 'header_offcanvas_collapsible',
				'section'     => 'header_elements',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'main_header_off_canvas',
				'label'       => esc_attr__( 'Off-Canvas Drawer', 'shopkeeper' ),
				'section'     => 'header_elements',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'default'	  => '<hr />',
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_off_canvas',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'main_header_off_canvas_icon',
				'label'       => esc_html__( 'Custom Off-Canvas Icon', 'shopkeeper' ),
				'section'     => 'header_elements',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'main_header_off_canvas',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

		/* Header Logo */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'site_logo',
				'label'       => esc_html__( 'Your Logo', 'shopkeeper' ),
				'section'     => 'header_logo',
				'priority'    => 10,
				'default'	  => get_template_directory_uri() . '/images/shopkeeper-logo.png',
				'description' => __('<span class="dashicons dashicons-editor-help"></span>Applied on Non-Transparent Headers. To upload a logo for a Tansparent Background go to <strong>Header Layout & Style</strong> section.', 'shopkeeper'),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_logo',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'image',
				'settings'    => 'sticky_header_logo',
				'label'       => esc_html__( 'Alternative Logo', 'shopkeeper' ),
				'section'     => 'header_logo',
				'priority'    => 10,
				'default'	  => get_template_directory_uri() . '/images/shopkeeper-logo.png',
				'description' => __('<span class="dashicons dashicons-editor-help"></span>Used on the <strong>Sticky Header</strong> and <strong>Mobile Devices</strong>.', 'shopkeeper'),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_logo',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'slider',
				'settings'    => 'logo_min_height',
				'label'       => esc_html__( 'Logo Container Min Width', 'shopkeeper' ),
				'section'     => 'header_logo',
				'priority'    => 10,
				'default'	  => 50,
				'choices'     => array(
						'min'  => 0,
						'max'  => 600,
						'step' => 1,
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'slider',
				'settings'    => 'logo_height',
				'label'       => esc_html__( 'Logo Container Height', 'shopkeeper' ),
				'section'     => 'header_logo',
				'priority'    => 10,
				'default'	  => 50,
				'choices'     => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
			));


			// array (

		/* Top Bar */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'top_bar_switch',
				'label'       => esc_attr__( 'Top Bar', 'shopkeeper' ),
				'section'     => 'top_bar',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
			    'settings'    => uniqid( 'separator' ),
			    'section'     => 'top_bar',
			    'default'     => '<hr>',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'top_bar_background_color',
				'label'       => esc_attr__( 'Top Bar Background Color', 'shopkeeper' ),
				'section'     => 'top_bar',
				'default'     => '#333333',
				'priority'    => 10,
				'choices'     => array(
					'alpha' => true,
				),
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
			    'settings'    => uniqid( 'separator' ),
			    'section'     => 'top_bar',
			    'default'     => '<hr>',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'top_bar_typography',
				'label'       => esc_attr__( 'Top Bar Text Color', 'shopkeeper' ),
				'section'     => 'top_bar',
				'default'     => '#fff',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
			    'settings'    => uniqid( 'separator' ),
			    'section'     => 'top_bar',
			    'default'     => '<hr>',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'top_bar_text',
				'label'       => esc_attr__( 'Top Bar Text', 'shopkeeper' ),
				'section'     => 'top_bar',
				'default' 	  => 'Free Shipping on All Orders Over $75!',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
			    'settings'    => uniqid( 'separator' ),
			    'section'     => 'top_bar',
			    'default'     => '<hr>',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'top_bar_navigation_position',
				'label'       => esc_attr__( 'Top Bar Navigation Position', 'shopkeeper' ),
				'section'     => 'top_bar',
				'default' 	  => 'right',
				'priority'    => 10,
				'choices'	  => 
					array(
						'left' 		=> 'Left',
                    	'right' 	=> 'Right'
					),
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
			    'settings'    => uniqid( 'separator' ),
			    'section'     => 'top_bar',
			    'default'     => '<hr>',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'top_bar_social_icons',
				'label'       => esc_attr__( 'Top Bar Social Icons', 'shopkeeper' ),
				'section'     => 'top_bar',
				'default' 	  => false,
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'top_bar_switch',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

		/* Sticky Header */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'sticky_header',
				'label'       => esc_attr__( 'Sticky Header', 'shopkeeper' ),
				'section'     => 'sticky_header',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
			    'settings'    => uniqid( 'separator' ),
			    'section'     => 'sticky_header',
			    'default'     => '<hr>',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'sticky_header',
						'operator' => '==',
						'value'    => true,
					)
				),
			));
			
			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'sticky_header_background_color',
				'label'       => esc_attr__( 'Sticky Header Background Color', 'shopkeeper' ),
				'section'     => 'sticky_header',
				'default'     => '#fff',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'sticky_header',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
			    'settings'    => uniqid( 'separator' ),
			    'section'     => 'sticky_header',
			    'default'     => '<hr>',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'sticky_header',
						'operator' => '==',
						'value'    => true,
					)
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'sticky_header_color',
				'label'       => esc_attr__( 'Sticky Header Color', 'shopkeeper' ),
				'section'     => 'sticky_header',
				'default'     => '#000',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'sticky_header',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

	/**
	 * FOOTER
	 */	
		/* Footer */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'footer_background_color',
				'label'       => esc_attr__( 'Footer Background Color', 'shopkeeper' ),
				'section'     => 'footer',
				'default'     => '#f4f4f4',
				'priority'    => 10,
				'choices'	  => 
					array(
						'alpha'		=> true
					)
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'footer_texts_color',
				'label'       => esc_attr__( 'Footer Text', 'shopkeeper' ),
				'section'     => 'footer',
				'default'     => '#868686',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'footer_links_color',
				'label'       => esc_attr__( 'Footer Links', 'shopkeeper' ),
				'section'     => 'footer',
				'default'     => '#000',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'footer_social_icons',
				'label'       => esc_attr__( 'Social Networking Icons', 'shopkeeper' ),
				'section'     => 'footer',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'textarea',
				'settings'    => 'footer_copyright_text',
				'label'       => esc_attr__( 'Copyright Footnote', 'shopkeeper' ),
				'section'     => 'footer',
				'default' 	  => 'Shopkeeper - eCommerce WP Theme',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'expandable_footer',
				'label'       => esc_attr__( 'Collapsed Widget Area on Mobiles', 'shopkeeper' ),
				'section'     => 'footer',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'back_to_top_button',
				'label'       => esc_attr__( 'Back To Top Button', 'shopkeeper' ),
				'section'     => 'footer',
				'default'     => false,
				'priority'    => 10,
			));

	/**
	 * BLOG
	 */
		/* Blog Archive */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-image',
				'settings'    => 'layout_blog',
				'label'       => esc_attr__( 'Blog Layout', 'shopkeeper' ),
				'section'     => 'blog_archive',
				'default'     => 'layout-3',
				'priority'    => 10,
				'choices'     => array(
						'layout-1'        => get_template_directory_uri() . '/images/theme_options/icons/blog_layout_1.png',
						'layout-2'        => get_template_directory_uri() . '/images/theme_options/icons/blog_layout_2.png',
						'layout-3'        => get_template_directory_uri() . '/images/theme_options/icons/blog_layout_3.png'
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_archive',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'sidebar_blog_listing',
				'label'       => esc_attr__( 'Blog Sidebar', 'shopkeeper' ),
				'section'     => 'blog_archive',
				'default'     => false,
				'description' => '<span class="dashicons dashicons-editor-help"></span>Only available for Blog Layout 1 and 2.',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'layout_blog',
						'operator' => '!=',
						'value'    => 'layout-3',
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_archive',
				'default'	  => '<hr />',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'layout_blog',
						'operator' => '!=',
						'value'    => 'layout-3',
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'pagination_blog',
				'label'       => esc_attr__( 'Blog Pagination Style', 'shopkeeper' ),
				'section'     => 'blog_archive',
				'default'     => 'infinite_scroll',
				'priority'    => 10,
				'choices'     => array(
						'classic'               	=> 'Classic',
	                    'load_more_button'          => 'Load More',
	                    'infinite_scroll'           => 'Infinite'
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_archive',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'portfolio_item_slug',
				'label'       => esc_attr__( 'Portfolio Item Slug', 'shopkeeper' ),
				'section'     => 'blog_archive',
				'default'     => 'portfolio-item',
				'description' => __('<span class="dashicons dashicons-editor-help"></span>Default slug is "portfolio-item". Enter a custom one to overwrite it. <br/><b>You need to regenerate your permalinks if you modify this!</b>', 'shopkeeper'),
				'priority'    => 10,
			));		

		/* Single Post */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'slider',
				'settings'    => 'single_post_width',
				'label'       => esc_html__( 'Content Width', 'shopkeeper' ),
				'section'     => 'single_post',
				'default'     => 708,
				'priority'    => 10,
				'choices'     => array(
						'min'  => 708,
						'max'  => 960,
						'step' => 1,
					),
				'active_callback'    => array(
					array(
						'setting'  => 'sidebar_blog_listing',
						'operator' => '==',
						'value'    => false,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'default'	  => '<hr />',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'single_post',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'sidebar_blog_listing',
						'operator' => '==',
						'value'    => false,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'post_meta_author',
				'label'       => esc_attr__( 'Author', 'shopkeeper' ),
				'section'     => 'single_post',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'single_post',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'post_meta_date',
				'label'       => esc_attr__( 'Date', 'shopkeeper' ),
				'section'     => 'single_post',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'single_post',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'post_meta_categories',
				'label'       => esc_attr__( 'Categories', 'shopkeeper' ),
				'section'     => 'single_post',
				'default'     => true,
				'priority'    => 10,
			));

	/**
	 * SHOP
	 */
		/* Shop Layout */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'breadcrumbs',
				'label'       => esc_attr__( 'Breadcrumbs', 'shopkeeper' ),
				'section'     => 'shop_layout',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_layout',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'sidebar_style',
				'label'       => __( 'Sidebar Style', 'shopkeeper' ),
				'section'     => 'shop_layout',
				'default'     => '1',
				'priority'    => 10,
				'choices'	  => 
					array(
						'0'		=> __('On Page', 'shopkeeper'),
						'1'		=> __('Off-Canvas', 'shopkeeper')
					)
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_layout',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'pagination_shop',
				'label'       => esc_attr__( 'Pagination Style', 'shopkeeper' ),
				'section'     => 'shop_layout',
				'priority'    => 10,
				'choices'	  =>
					array(
						'classic'               => 'Classic',
			            'load_more_button'      => 'Load More',
			            'infinite_scroll'       => 'Infinite'
					),
				'default'     => 'infinite_scroll'
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_layout',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'category_style',
				'label'       => __( 'Category Display Style', 'shopkeeper' ),
				'section'     => 'shop_layout',
				'default'     => 'styled_grid',
				'priority'    => 10,
				'choices'	  => 
					array(
						'styled_grid'		=> __('Categories Grid', 'shopkeeper'),
						'original_grid'		=> __('Thumbs', 'shopkeeper')
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_layout',
				'default'	  => '<hr />',
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'category_style',
						'operator' => '==',
						'value'    => 'styled_grid',
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'categories_grid_count',
				'label'       => esc_attr__( 'Display Number of Products on Categories Grid', 'shopkeeper' ),
				'section'     => 'shop_layout',
				'default'     => true,
				'priority'    => 10,
				'active_callback'    => array(
					array(
						'setting'  => 'category_style',
						'operator' => '==',
						'value'    => 'styled_grid',
					),
				),
			));

		/* Product Card */

			Kirki::add_field( 'shopkeeper', array(
		        'type'        	=> 'slider',
		        'settings'   	=> 'product_title_font_size',
		        'label'    	  	=> esc_attr__( 'Product Title Font Size (px)', 'shopkeeper' ),
		        'section'     	=> 'product_card',
		        'priority'    	=> 10,
		        'default'     	=> 12,
		        'choices'		=> 
		        	array
		        	(
		        		'min' => '10',
                		'step' => '1',
                		'max' => '24',
		        	)
		    ));

		    Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_card',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'second_image_product_listing',
				'label'       => __( '2<sup>nd</sup> Product Image on Hover', 'shopkeeper' ),
				'section'     => 'product_card',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_card',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'ratings_catalog_page',
				'label'       => __( 'Rating Stars', 'shopkeeper' ),
				'section'     => 'product_card',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_card',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'add_to_cart_display',
				'label'       => __( 'Add to Cart Button Display', 'shopkeeper' ),
				'section'     => 'product_card',
				'default'     => '1',
				'priority'    => 10,
				'choices'	  => 
					array(
						'1'		=> __('When Hovering', 'shopkeeper'),
						'0'		=> __('At all Times', 'shopkeeper')
					)
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_card',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'quick_view',
				'label'       => esc_attr__( 'Quick View', 'shopkeeper' ),
				'section'     => 'product_card',
				'default'     => false,
				'priority'    => 10,
			));

		/* Shop Notifications */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'notification_mode',
				'label'       => __( 'Notification Style', 'shopkeeper' ),
				'section'     => 'shop_notifications',
				'default'     => '1',
				'priority'    => 10,
				'choices'	  => 
					array(
						'1'		=> __('Animated', 'shopkeeper'),
						'0'		=> __('Classic', 'shopkeeper')
					)
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'notification_style',
				'label'       => __( 'Animation', 'shopkeeper' ),
				'section'     => 'shop_notifications',
				'default'     => '1',
				'priority'    => 10,
				'choices'	  => 
					array(
						'1'		=> __('Slide Out', 'shopkeeper'),
						'0'		=> __('Always Visible', 'shopkeeper')
					),
				'active_callback'    => array(
					array(
						'setting'  => 'notification_mode',
						'operator' => '==',
						'value'    => '1',
					),
				),
			));

		/* Product Badges */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'out_of_stock_label',
				'label'       => __( 'Out of Stock Label', 'shopkeeper' ),
				'help'		  => __('If you\'re using a multi language plugin we recommend leaving the default value.', 'shopkeeper'),
				'section'     => 'product_badges',
				'default'     => 'Out of stock',
				'priority'    => 10
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'sale_label',
				'label'       => __( 'Sale Label', 'shopkeeper' ),
				'help'		  => __('If you\'re using a multi language plugin we recommend leaving the default value.', 'shopkeeper'),
				'section'     => 'product_badges',
				'default'     => 'Sale!',
				'priority'    => 10
			));

		/* Mobile Settings */

		    Kirki::add_field( 'shopkeeper', array(
				'type'        => 'slider',
				'settings'    => 'mobile_columns',
				'label'       => esc_attr__( 'Number of Columns on Mobile', 'shopkeeper' ),
				'section'     => 'mobile_settings',
				'default'     => 2,
				'priority'    => 10,
				'choices'	  =>
					array(
						'min'	=> 1,
						'max'	=> 2,
						'step'  => 1
					)
			));

		/* Catalog Mode */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'catalog_mode',
				'label'       => esc_attr__( 'Catalog Mode', 'shopkeeper' ),
				'section'     => 'catalog_mode',
				'default'     => false,
				'description' => __('<span class="dashicons dashicons-editor-help"></span>When enabled, the feature Turns Off the shopping functionality of WooCommerce.', 'shopkeeper'),
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'predictive_search',
				'label'       => esc_attr__( 'Predictive Search', 'shopkeeper' ),
				'section'     => 'search',
				'default'     => true,
				'priority'    => 10,
			));

	/**
	 * PRODUCT PAGE
	 */
		/* Product Page */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-image',
				'settings'    => 'product_layout',
				'label'       => esc_attr__( 'Product Page Layout', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => 'default',
				'priority'    => 10,
				'choices'     => array(
						'default'        => get_template_directory_uri() . '/images/theme_options/icons/product_layout_1.png',
						'style_2'        => get_template_directory_uri() . '/images/theme_options/icons/product_layout_2.png',
						'style_3'        => get_template_directory_uri() . '/images/theme_options/icons/product_layout_3.png',
						'style_4'        => get_template_directory_uri() . '/images/theme_options/icons/product_layout_4.png'
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'radio-image',
				'settings'    => 'product_quantity_style',
				'label'       => esc_attr__( 'Product Quantity Style', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => 'default',
				'priority'    => 10,
				'choices'     => array(
						'default'        => get_template_directory_uri() . '/images/theme_options/icons/product_qty_style_1.png',
						'custom'         => get_template_directory_uri() . '/images/theme_options/icons/product_qty_style_2.png'
					),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'product_gallery_zoom',
				'label'       => esc_attr__( 'Product Gallery Zoom', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'product_gallery_lightbox',
				'label'       => esc_attr__( 'Product Gallery Lightbox', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'related_products',
				'label'       => esc_attr__( 'Related Products', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'slider',
				'settings'    => 'related_products_number',
				'label'       => esc_attr__( 'Number of Related Products', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => 4,
				'priority'    => 10,
				'choices'	  => 
					array 
					(
						'min'	=> 2,
						'max'	=> 6,
						'step'	=> 1
					),
				'active_callback'    => array(
					array(
						'setting'  => 'related_products',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'sharing_options',
				'label'       => esc_attr__( 'Social Sharing Options', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'review_tab',
				'label'       => esc_attr__( 'Review Tab', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'ajax_add_to_cart',
				'label'       => esc_attr__( 'AJAX Add to Cart', 'shopkeeper' ),
				'section'     => 'product',
				'description' => __('<span class="dashicons dashicons-editor-help"></span>The option is available for simple products.<div class="ajax-error"><span class="dashicons dashicons-warning"></span>Functionality turned off automatically due to incompatibility with:<span class="woo-addons">WooCommerce Product Add-Ons</span><span class="m-price-calculator">WC Measurement Price Calculator</span><span class="fields-factory">WC Fields Factory</span></div>', 'shopkeeper'),
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'disabled_outofstock_variations',
				'label'       => esc_attr__( 'Disable Out of Stock Variations', 'shopkeeper' ),
				'section'     => 'product',
				'default'     => true,
				'description' => __("<span class='dashicons dashicons-editor-help'></span>The variations will be disabled in the attribute's options list.", 'shopkeeper'),
				'priority'    => 10,
			));

	/**
	 * STYLING
	 */
		/* Styling */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'body_color',
				'label'       => esc_attr__( 'Body Text Color', 'shopkeeper' ),
				'section'     => 'styling',
				'default'     => '#545454',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'headings_color',
				'label'       => esc_attr__( 'Headings Color', 'shopkeeper' ),
				'section'     => 'styling',
				'default'     => '#000000',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'main_color',
				'label'       => esc_attr__( 'Accent Color', 'shopkeeper' ),
				'section'     => 'styling',
				'default'     => '#EC7A5C',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'background',
				'settings'    => 'main_background',
				'label'       => esc_attr__( 'Body Background', 'shopkeeper' ),
				'section'     => 'styling',
				'default'     => array('background-color' => '#FFFFFF'),
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'toggle',
				'settings'    => 'smooth_transition_between_pages',
				'label'       => esc_attr__( 'Smooth Transition Between Pages', 'shopkeeper' ),
				'section'     => 'styling',
				'default'     => 0,
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'offcanvas_bg_color',
				'label'       => esc_attr__( 'Off-Canvas Background Color', 'shopkeeper' ),
				'section'     => 'styling',
				'default'     => '#ffffff',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'offcanvas_headings_color',
				'label'       => esc_attr__( 'Off-Canvas Headings Color', 'shopkeeper' ),
				'section'     => 'styling',
				'default'     => '#000000',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'color',
				'settings'    => 'offcanvas_text_color',
				'label'       => esc_attr__( 'Off-Canvas Text Color', 'shopkeeper' ),
				'section'     => 'styling',
				'default'     => '#545454',
				'priority'    => 10,
			));

	/**
	 * FONTS
	 */
		/* Fonts */

		    Kirki::add_field( 'shopkeeper', array(
		        'type'     		=> 'typography',
		        'settings' 		=> 'new_main_font',
		        'label'    	  	=> esc_attr__( 'Main Font', 'shopkeeper' ),
		        'description' 	=> __( '<span class="dashicons dashicons-editor-help"></span>Used for titles and Headings.', 'shopkeeper' ),
		        'section'  		=> 'fonts',
		        'priority' 		=> 10,
		        'default'     => array(
			        'font-family'    => 'NeueEinstellung',
			        'variant'        => '500',
			        'subsets'        => array( 'latin' ),
			    ),
			    'output'      => array(
					array(
						'element' => '',
					),
				),
		    ));

		    Kirki::add_field( 'shopkeeper', array(
		        'type'        	=> 'slider',
		        'settings'   	=> 'headings_font_size',
		        'label'    	  	=> esc_attr__( 'Headings Font Size (px)', 'shopkeeper' ),
		        'section'     	=> 'fonts',
		        'priority'    	=> 10,
		        'default'     	=> 23,
		        'choices'		=> 
		        	array
		        	(
		        		'min' => '16',
                		'step' => '1',
                		'max' => '40',
		        	)
		    ));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'fonts',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        	=> 'typography',
				'settings'    	=> 'new_secondary_font',
				'label'       	=> esc_attr__( 'Secondary Font', 'shopkeeper' ),
		        'section'  	  	=> 'fonts',
		        'priority'    	=> 10,
		        'default'     => array(
			        'font-family'    => 'Radnika',
			    ),
			    'output'      => array(
					array(
						'element' => '',
					),
				),
		    ));

		    Kirki::add_field( 'shopkeeper', array(
		        'type'        	=> 'slider',
		        'settings'   	=> 'body_font_size',
		        'label'    	  	=> esc_attr__( 'Body Font Size (px)', 'shopkeeper' ),
		        'section'     	=> 'fonts',
		        'priority'    	=> 10,
		        'default'     	=> 16,
		        'choices'		=> 
		        	array
		        	(
		        		'min' => '12',
                		'step' => '1',
                		'max' => '20',
		        	)
		    ));

	/**
	 * SOCIAL MEDIA
	 */
		/* Social Media */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'facebook_link',
				'label'       => esc_attr__( 'Facebook', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '#',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'twitter_link',
				'label'       => esc_attr__( 'Twitter', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '#',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'pinterest_link',
				'label'       => esc_attr__( 'Pinterest', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'linkedin_link',
				'label'       => esc_attr__( 'LinkedIn', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'googleplus_link',
				'label'       => esc_attr__( 'Google+', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'rss_link',
				'label'       => esc_attr__( 'RSS', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'tumblr_link',
				'label'       => esc_attr__( 'Tumblr', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'instagram_link',
				'label'       => esc_attr__( 'Instagram', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'youtube_link',
				'label'       => esc_attr__( 'Youtube', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'vimeo_link',
				'label'       => esc_attr__( 'Vimeo', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'behance_link',
				'label'       => esc_attr__( 'Behance', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'dribbble_link',
				'label'       => esc_attr__( 'Dribbble', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'flickr_link',
				'label'       => esc_attr__( 'Flickr', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'git_link',
				'label'       => esc_attr__( 'Git', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'skype_link',
				'label'       => esc_attr__( 'Skype', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'weibo_link',
				'label'       => esc_attr__( 'Weibo', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'foursquare_link',
				'label'       => esc_attr__( 'Foursquare', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'soundcloud_link',
				'label'       => esc_attr__( 'Soundcloud', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'vk_link',
				'label'       => esc_attr__( 'VK', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'houzz_link',
				'label'       => esc_attr__( 'Houzz', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'naver_line_link',
				'label'       => esc_attr__( 'Naver LINE', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'tripadvisor_link',
				'label'       => esc_attr__( 'TripAdvisor', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'wechat_link',
				'label'       => esc_attr__( 'WeChat', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'whatsapp_link',
				'label'       => esc_attr__( 'WhatsApp', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'telegram_link',
				'label'       => esc_attr__( 'Telegram', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'viber_link',
				'label'       => esc_attr__( 'Viber', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'spotify_link',
				'label'       => esc_attr__( 'Spotify', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'text',
				'settings'    => 'bandcamp_link',
				'label'       => esc_attr__( 'Bandcamp', 'shopkeeper' ),
				'section'     => 'social_media',
				'default'     => '',
				'priority'    => 10,
			));


	/**
	 * CUSTOM CODE
	 */
		/* Custom Code */

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'code',
				'settings'    => 'custom_css',
				'label'       => esc_attr__( 'Custom CSS', 'shopkeeper' ),
				'section'     => 'custom_code',
				'default'     => '',
				'priority'    => 10,
				'choices'     => array(
					'language' => 'css',
					'theme'    => 'monokai',
					'height'   => 150,
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'custom_code',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'code',
				'settings'    => 'header_js',
				'label'       => esc_attr__( 'Header JavaScript Code', 'shopkeeper' ),
				'section'     => 'custom_code',
				'default'     => '',
				'priority'    => 10,
				'choices'     => array(
					'language' => 'javascript',
					'theme'    => 'monokai',
					'height'   => 150,
				),
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'separator',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'custom_code',
				'priority'    => 10,
			));

			Kirki::add_field( 'shopkeeper', array(
				'type'        => 'code',
				'settings'    => 'footer_js',
				'label'       => esc_attr__( 'Footer JavaScript Code', 'shopkeeper' ),
				'section'     => 'custom_code',
				'default'     => '',
				'priority'    => 10,
				'choices'     => array(
					'language' => 'javascript',
					'theme'    => 'monokai',
					'height'   => 150,
				),
			));

}// End if().
