<?php


function getbowtied_theme_register_required_plugins() {

  if (!class_exists('GetBowtied_Tools')):
  $plugins = array(
      'woocommerce' => array(
        'name'               => 'WooCommerce',
        'slug'               => 'woocommerce',
        'required'           => false,
        'description'        => 'The eCommerce engine',
        'demo_required'      => true
      ),
      'js_composer' => array(
          'name'               => 'WPBakery Page Builder',
          'slug'               => 'js_composer',
          'source'             => get_template_directory() . '/inc/plugins/js_composer.zip',
          'required'           => false,
          'external_url'       => '',
          'description'        => '#1 WordPress Page Builder Plugin',
          'demo_required'      => true,
          'version'            => '5.6'
      ),
      'one-click-demo-import'=> array(
        'name'               => 'One Click Demo Import',
        'slug'               => 'one-click-demo-import',
        'required'           => false,
        'description'        => 'Import your demo content, widgets and theme settings with one click.',
        'demo_required'      => true
      ),
      'envato-market'        => array(
        'name'               => 'Envato Market',
        'slug'               => 'envato-market',
        'required'           => false,
        'source'             => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
        'description'        => 'Automatically update your Envato theme',
        'demo_required'      => true
      ),
      'shopkeeper-extender'  => array(
        'name'               => 'Shopkeeper Extender',
        'slug'               => 'shopkeeper-extender',
        'source'             => 'https://github.com/getbowtied/shopkeeper-extender/zipball/master',
        'required'           => true,
        'external_url'       => 'https://github.com/getbowtied/shopkeeper-extender',
        'description'        => 'Extends the functionality of Shopkeeper with Gutenberg elements.',
        'demo_required'      => false,
        'version'            => '1.3.1'
      ),
    );
  else: 
     $plugins = array(
      'woocommerce' => array(
        'name'               => 'WooCommerce',
        'slug'               => 'woocommerce',
        'required'           => false,
        'description'        => 'The eCommerce engine',
        'demo_required'      => true
      ),
      'js_composer' => array(
        'name'               => 'WPBakery Page Builder',
        'slug'               => 'js_composer',
        'source'             => get_template_directory() . '/inc/plugins/js_composer.zip',
        'required'           => false,
        'external_url'       => '',
        'description'        => '#1 WordPress Page Builder Plugin',
        'demo_required'      => true,
        'version'            => '5.6'
      ),
      'shopkeeper-extender'  => array(
        'name'               => 'Shopkeeper Extender',
        'slug'               => 'shopkeeper-extender',
        'source'             => 'https://github.com/getbowtied/shopkeeper-extender/zipball/master',
        'required'           => true,
        'external_url'       => 'https://github.com/getbowtied/shopkeeper-extender',
        'description'        => 'Extends the functionality of Shopkeeper with Gutenberg elements.',
        'demo_required'      => false,
        'version'            => '1.3.1'
      ),
    );
    endif;

  $config = array(
    'id'               => 'getbowtied',
    'default_path'      => '',
    'parent_slug'       => 'themes.php',
    'menu'              => 'tgmpa-install-plugins',
    'has_notices'       => true,
    'is_automatic'      => true,
  );

  tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'getbowtied_theme_register_required_plugins' );


