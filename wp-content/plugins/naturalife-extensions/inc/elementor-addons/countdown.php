<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_RT_Countdown extends Widget_Base {

	public function get_name() {
		return 'rt-countdown';
	}

	public function get_title() {
		return "[RT] ".esc_html_x( 'Countdown', 'Adnin Panel', 'naturalife' );
	}

	public function get_categories() {
		return [ 'rt-elementor-addons' ];
	}

	public function get_icon() {
		return 'eicon-countdown';
	}
	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'RT_countdown_content',
  			[
  				'label' => esc_html_x( 'Countdown','Admin Panel','naturalife' )
  			]
  		); 
 

		$this->add_control(
			'date',
			[
				'label' =>  esc_html_x( 'Date', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::TEXT,  	
				'description' => esc_html_x('Use only this format: year/month/day hour:minutes - example:', 'Admin Panel','naturalife' ).'<code>2018/01/01 22:39</code>',
				'placeholder' => esc_html_x( 'year/month/day', 'Admin Panel','naturalife' ),
			]
		);

		$this->add_control(
			'content',
			[
				'label' =>  esc_html_x( 'Custom Output Format', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::TEXTAREA,  	
				'description' => 
				esc_html_x('Leave blank for the default output. To customize the output you can use these available special codes;', 'Admin Panel','naturalife' ).
					'<br/><br/><code>%Y</code> '._x('for years', 'Admin Panel','naturalife' ).
					'<br/><code>%m</code> '._x('for monts', 'Admin Panel','naturalife' ). 
					'<br/><code>%n</code> '._x('for days of the month', 'Admin Panel','naturalife' ).
					'<br/><code>%D</code> '._x('for total days', 'Admin Panel','naturalife' ).
					'<br/><code>%H</code> '._x('for hours', 'Admin Panel','naturalife' ).
					'<br/><code>%I</code> '._x('for total hours', 'Admin Panel','naturalife' ).
					'<br/><code>%M</code> '._x('for minutes', 'Admin Panel','naturalife' ).
					'<br/><code>%S</code> '._x('for seconds', 'Admin Panel','naturalife' ).
					'<br /><br /><b>'._x('Example', 'Admin Panel','naturalife' ).
					'<br/><code>&lt;i&gt;&lt;b&gt;%D&lt;/b&gt;DAYS&lt;/i&gt; &lt;i&gt;&lt;b&gt;%H&lt;/b&gt;HOURS&lt;/i&gt; &lt;i&gt;&lt;b&gt;%M&lt;/b&gt;MINUTES&lt;/i&gt; &lt;i&gt;&lt;b&gt;%S&lt;/b&gt;SECONDS&lt;/i&gt;</code>'
				, 
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html_x( 'Alignment', 'Admin Panel', 'naturalife' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html_x( 'Left', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html_x( 'Center', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html_x( 'Right', 'Admin Panel', 'naturalife' ),
						'icon' => 'fa fa-align-right',
					], 
				],
				'prefix_class' => 'elementor%s-align-'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rt-countdown *',
			]		
		);

		$this->add_control(
			'color',
			[
				'label' =>  esc_html_x( 'Color', 'Admin Panel','naturalife' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .rt-countdown *' => 'color: {{VALUE}} !important;',
				]				
			]
		);
		$this->end_controls_section();
	}


	protected function render( ) {

		$settings = $this->get_settings(); 
		echo rt_countdown_function( $settings, $settings["content"] );

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_RT_Countdown() );

