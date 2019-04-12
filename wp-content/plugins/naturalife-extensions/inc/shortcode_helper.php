<?php
#-----------------------------------------
#	RT-Theme shortcode_helper.php
#-----------------------------------------
 

class rt_shortcode_helper{

	public $shortcode_list = array();

	public function __construct()
	{
		$this->start();
	} 

	#
	#	Init
	#
	public function start() { 

		//start 
		if(is_admin()){
			// add shortcode helper menu & editor button
			add_action( 'wp_before_admin_bar_render', array(&$this, "custom_toolbar") , 98 );		
			add_filter( 'tiny_mce_version', array(&$this, "refresh_editor") );
			add_filter( 'init', array(&$this, "rt_theme_shortcode_button") );
		}
		
	}

	#
	#	Add Toolbar Menu
	#
 
	public function custom_toolbar() {

		if ( ! class_exists("RTFramework") ){
			return;
		}
				
		global $wp_admin_bar;


		$args = array(
			'id'     => 'rt_shortcode_helper_button',
			'title'  => '<div><span class="ab-icon"></span>'._x( 'Shortcodes', 'Admin Panel', 'naturalife' ) .'</div>',		
			'group'  => false 
		);

		$wp_admin_bar->add_menu( $args ); 
	}

	#
	#	Add shortcode button to editor
	#
 
	public function rt_theme_shortcode_button() {

		if ( ! class_exists("RTFramework") ){
			return;
		}

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;

		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", array(&$this,'rt_theme_add_shortcode_tinymce_plugin'));
			add_filter('mce_buttons', array(&$this,'rt_theme_register_shortcode_button'));
		}
	}


	#
	#	Register editor buttons
	#
 
	public function rt_theme_register_shortcode_button($buttons) {
		array_push($buttons, "", "rt_themeshortcode");
		return $buttons;
	}

	#
	#	Load the js file
	#

	public function rt_theme_add_shortcode_tinymce_plugin($plugin_array) {
		$plugin_array['rt_themeshortcode'] = RT_THEMEURI . '/rt-framework/admin/js/editor-buttons.js';
		return $plugin_array;
	}


	#
	#	Refresh the editor 
	#
	public function refresh_editor($ver) {
		$ver += 3;
		return $ver;
	}

	#
	#	Shortcode List & Helper Menu
	#
	public function create_shortcode_list() {   

		if ( ! class_exists("RTFramework") ){
			return;
		}

		$this->create_shortcode_array();

		//create UI
		$output = $tab_names_output = $tab_contents_output = $group_id = $parameters = "";

		foreach ( $this->shortcode_list as $shortcode_id => $shortcode_arg  ) {		

			//group name 
			$group_name = isset( $shortcode_arg["group_name"] ) ? $shortcode_arg["group_name"] : "";

			//group id 
			$group_id = isset( $shortcode_arg["group_name"] ) ? $shortcode_id : $group_id;

			//the shortcode format
		 	$shortcode_arg["parameters"] = isset(  $shortcode_arg["parameters"] ) ?  $shortcode_arg["parameters"] : "";
			$the_shortcode_format = empty( $group_name) ? $this->create_shortcode_format( $shortcode_id, $shortcode_arg["parameters"] ) : "";

 
			if( ! isset( $shortcode_arg["subline"] ) || $shortcode_arg["subline"] == false ){
	 
				if( empty( $group_name ) ) {

						//create tab panels
						$tab_names_output .= sprintf('
								<li class="%3$s" data-tab-number="shorcode-%2$s">	
									%1$s
								</li>
						', $shortcode_arg["name"], $shortcode_id, $group_id );				

						$this_tab_content = '';

						//this tab output format
						$this_tab_content_format = ' <h3><span class="rt-panel-icon-code-outline icon"></span> %1$s </h3> <p class="description"> %2$s <span class="pformat">%5$s</span></p> %3$s %4$s ';

						//output for the main shortcode					
						$this_tab_content .= sprintf($this_tab_content_format, $shortcode_arg["name"], $shortcode_arg["description"], $parameters, $this->create_parameters( $shortcode_arg["parameters"] ), htmlspecialchars($the_shortcode_format)  );				

						//sub shorcode 
						if( isset( $shortcode_arg["content"] ) ){
							if( ! empty( $shortcode_arg["content"]["shortcode_id"] ) ){
								$sub_shortcode_id = $shortcode_arg["content"]["shortcode_id"];			
								$sub_shortcode_parameters = isset(  $this->shortcode_list[$sub_shortcode_id]["parameters"] ) ? $this->shortcode_list[$sub_shortcode_id]["parameters"] : "";
								$the_sub_shortcode_format = $this->create_shortcode_format( $sub_shortcode_id, $sub_shortcode_parameters ) ;//the shortcode format
								$this_tab_content .= sprintf($this_tab_content_format, $this->shortcode_list[$sub_shortcode_id]["name"], $this->shortcode_list[$sub_shortcode_id]["description"], $parameters, $this->create_parameters( $sub_shortcode_parameters ), $the_sub_shortcode_format );				

							}
						}			

						// shortcode example 
						$example_code = isset( $this->shortcode_examples[$shortcode_id] ) ? $this->shortcode_examples[$shortcode_id] : "" ;
						$example_code_output = "";

							if( ! empty( $example_code ) ){
								if( is_array( $example_code ) ){
									foreach ($example_code as $desc => $code) {			
										
										$code = preg_replace('/\t+/', '', $code);

										$example_code_output .= sprintf('
												<h3><span class="rt-panel-icon-info icon"></span> %1$s </h3>
												<textarea>%2$s</textarea>
												<input type="button" class="button insert_to_editor" value="insert to editor">
											', $desc, $code );
									}						
								}
							}else{						
								$example_code_output = sprintf('
									<h3><span class="rt-panel-icon-info icon"></span> %1$s </h3> <textarea>%2$s</textarea> <input type="button" class="button insert_to_editor"  value="insert to editor">', 
									_x( 'Example', 'Admin Panel','naturalife' ), $this->create_shortcode_example( $shortcode_id, $shortcode_arg["parameters"] ) );				
							}

						//add to the output
						$tab_contents_output .= sprintf('
								<div id="shorcode-%1$s" class="tab_content_wrapper">
									<table>
										<tr>
											<td>%2$s</td>
											<td>
												%3$s
											</td>
										</tr>
									</table>
								</div>
						', $shortcode_id, $this_tab_content,  $example_code_output);				

				}else{

					//group start
					$tab_names_output .= sprintf('
						<div class="group_name"><span class="%2$s icon"></span>%1$s</div>
					', $group_name, $shortcode_arg["group_icon"] );
 
				}
				
			}
		}

		$output  = sprintf( '

			<div id="rttheme_shortcode_helper" class="rt_modal">
				
				<div class="window_bar">
					<div class="title">'.  _x( 'Theme Shortcodes', 'Admin Panel','naturalife' ) .'</div>

					<div class="rt_modal_close rt_modal_control"><span class="rt-panel-icon-cancel"></span></div>
				</div>

				<div class="modal_content">

					<div class="rt_tabs left tab-position-2 style-2">
						<ul class="tab_nav">
							%1$s
						</ul>
						<div class="tab_contents">
							%2$s
						</div>
					</div>

				</div>

			</div>
			', $tab_names_output, $tab_contents_output );
 
		echo $output;
	}


	#
	#	Shortcode Parameter Guide
	#
	
	private function create_parameters( $parameters = array() ){
		
		$output = "";

		if( is_array( $parameters ) ){

			foreach ($parameters as $parameter ) {

				$option_list = $default_value = $value = "";
				$heading = $description = $param_name = $default_value = $option_list = $dependency = "";

				extract( $parameter );

				$heading = isset( $heading ) && ! empty( $heading ) ? $heading.". " : "";

				$dependency = isset( $dependency ) && ! empty( $dependency ) ? "<br /><u>Dependency</u>: ". $dependency["element"]. "=" . implode(",", $dependency["value"] ) : "";

				//parameter option list
				if( is_array( $value ) ){

					foreach ($value as $key => $val) {
						$option_list .=  '<span class="poptionname rt_clean_copy">'. $val .'</span>' . $key .'<br />' ;
					}

					$option_list = sprintf(' <li><span class="poptions">%1$s</span> %2$s  </li> ',  _x('Options','Admin Panel','naturalife'), $option_list );
				}

				//default value
				$default_value = isset( $default_value ) && $default_value != "" ? $default_value : "";
				$default_value = isset( $value ) && ! is_array( $value ) && $value != "" && $default_value == "" ? $value : $default_value;

				if( $default_value != "" ){
					$default_value = sprintf(' <li><span class="pdefault">%1$s</span> :  <span class="poptionname rt_clean_copy">%2$s</span>  </li> ',  _x('Default Value','Admin Panel','naturalife'), $default_value );
				}

				//paramater list
				$output .= sprintf('
									<li>
										
										<span class="pname">%1$s : </span>

											<ul>					
												<li><p class="pdescription"> %2$s </p></li>											
												%3$s
												%4$s
											</ul>

									</li>
								', 

								$param_name, $heading."".$description."".$dependency, $default_value, $option_list
							);

				$heading = $description = $param_name = $default_value = $option_list = $dependency = "";
			}

		}

		if ( ! empty( $output ) ) {
			return '
				<h3><span class="rt-panel-icon-cog icon"></span>'. _x('Parameters','Admin Panel','naturalife') .'</h3>
				<ul class="parameters">'
					.$output.'
				</ul>';
		}

	}


	#
	#	Create Shortocde Format
	#
	
	private	function create_shortcode_format( $shortcode_id, $parameters ){
		
		$output = $parameters_output = "";

		//createa paramater format
		if( is_array( $parameters ) ){
			foreach ($parameters as $paramater ) {
				$parameters_output .= sprintf(' %1$s=""', $paramater["param_name"] ); 
			}
		}

		//the shortcode
		if( $this->shortcode_list[$shortcode_id]["close"] == false ){
			$output = sprintf('[%1$s%2$s]',$shortcode_id, $parameters_output);
		}else{
			$this->shortcode_list[$shortcode_id]["content"]["text"] = isset( $this->shortcode_list[$shortcode_id]["content"]["text"] ) ? $this->shortcode_list[$shortcode_id]["content"]["text"] : "";
			$output = sprintf('[%1$s%2$s]%3$s[/%1$s]',$shortcode_id, $parameters_output, $this->shortcode_list[$shortcode_id]["content"]["text"]);
		}
			
		return $output;

	}



	#
	#	Create Shortocde Example
	#
	
	private	function create_shortcode_example( $shortcode_id, $parameters ){
		
		$output = $parameters_output = "";

		//createa paramater format
		if( is_array( $parameters ) ){
			foreach ($parameters as $paramater ) {
				$paramater["default_value"] = isset( $paramater["default_value"] ) ? $paramater["default_value"] : "";

				//default value
				$paramater["default_value"] = isset( $paramater["default_value"] ) && $paramater["default_value"] != "" ? $paramater["default_value"] : "";
				$paramater["default_value"] = isset( $paramater["value"] ) && ! is_array($paramater["value"]) && $paramater["value"] != "" && $paramater["default_value"] == "" ? $paramater["value"] : $paramater["default_value"];

				$parameters_output .= sprintf(' %1$s="%2$s"', $paramater["param_name"], $paramater["default_value"] ); 
			}
		}

		//shortcode content
		if( $this->shortcode_list[$shortcode_id]["close"] == true ){
 	
 			$sub_shortcode_id = isset( $this->shortcode_list[$shortcode_id]["content"] ) && isset( $this->shortcode_list[$shortcode_id]["content"]["shortcode_id"] ) ? $this->shortcode_list[$shortcode_id]["content"]["shortcode_id"] : "" ;

			if( ! empty( $sub_shortcode_id ) ) {
				$shorcode_content = $this->create_shortcode_example( $sub_shortcode_id, $this->shortcode_list[$sub_shortcode_id]["parameters"] ) ;
			}else{
				$shorcode_content = $this->shortcode_list[$shortcode_id]["content"]["text"];
			}

		}


		//the shortcode
		if( $this->shortcode_list[$shortcode_id]["close"] == false ){
			$output = sprintf('[%1$s%2$s]',$shortcode_id, $parameters_output);
		}else{
			$output = sprintf('[%1$s%2$s]%3$s[/%1$s]',$shortcode_id, $parameters_output, $shorcode_content);
		}
			
		return $output;

	}


	public function create_shortcode_array(){

		$this->shortcode_list = array(

				/* format

					"shortcode_name" => array(
						"name"=> '',
						"subline" => '',
						"id"=> '',
						"description"=> '',
						"open" => '',
						"close" => '',	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(
											array(
												"param_name" => '',
												"description"=> '',
												"default_value" => '',
												"value" => array(),
											),
										),
					),

				*/
	 


			/*
				Group Name
			*/
			// "group-1" => array(
			// 	"group_name"=> _x('Layout Elements','Admin Panel','naturalife'),
			// 	"group_icon"=> "rt-panel-icon-code-1",
			// ),

			/*
				Posts
			*/
			"group-2" => array(
				"group_name"=> _x('Posts','Admin Panel','naturalife'),
				"group_icon"=> "rt-panel-icon-code-1",
			),

					/*
						Blog Posts
					*/
					"blog_box" => array(
						"name"=> _x('Blog Posts','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'blog_box',
						"description"=> _x('Displays blog posts with selected parameters','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(


													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),


													array(
														'param_name'  => 'list_layout',
														'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
														"description" => _x("Column layout for the list",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			"1/6" => "1/6", 
																			"1/4" => "1/4",
																			"1/3" => "1/3",
																			"1/2" => "1/2",
																			"1/1" => "1/1"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'heading_size',
														'heading'     => _x( 'Heading Size', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select the size of the heading tag', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown', 
														"value"       => array(
																			"H1" => "h1", 
																			"H2" => "h2", 
																			"H3" => "h3", 
																			"H4" => "h4", 
																			"H5" => "h5", 
																			"H6" => "h6", 
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'layout_style',
														'heading'     => _x( 'Layout Style', 'Admin Panel','naturalife' ),
														"description" => _x("Design of the layout",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default",'Admin Panel','naturalife') => "",
																			_x("Masonry",'Admin Panel','naturalife') => "masonry" 
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'box_style',
														'heading'     => _x( 'Box Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Default','Admin Panel','naturalife') => '',
																			_x('Boxed','Admin Panel','naturalife') => 'boxed',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'use_excerpts',
														'heading'     => _x("Excerpts", 'Admin Panel','naturalife'),
														"description" => _x("As default the full blog content will be displayed for this list.  Enable this option to minify the content automatically by using WordPress's excerpt option.  You can keep disabled and split your content manually by using <a href=\"http://en.support.wordpress.com/splitting-content/more-tag/\">The More Tag</a>",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'excerpt_length',
														'heading'     => _x('Excerpt Length', 'Admin Panel','naturalife' ),
														"description" => _x("Customize the excerpt length. Leave blank for the default value.",'Admin Panel','naturalife'),
														'type'        => 'rt_number',
														'value'       => '',
														"dependency"  => array(
																				"element" => "use_excerpts",
																				"value" => array("true")
																		 	),	
														'save_always' => true
													),

													array(
														'param_name'  => 'pagination',
														'heading'     => _x( 'Pagination', 'Admin Panel','naturalife' ),
														"description" => _x("Splits the list into pages",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),				
														'save_always' => true
													),

													array(
														'param_name'  => 'ajax_pagination',
														'description' => _x( 'Works with Masonry layout only', 'Admin Panel','naturalife' ),
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Enable ajax pagination (load more)", 'Admin Panel','naturalife') => "true",
																		),	
														"dependency"  => array(
																			"element" => "pagination",
																			"value" => array("true")
																		),	
														'save_always' => true
													),

													array(
														'param_name'  => 'list_orderby',
														'heading'     => _x( 'List Order By', 'Admin Panel','naturalife' ),
														"description" => _x("Sorts the posts by this parameter",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Date','Admin Panel','naturalife') => 'date',
																			_x('Author','Admin Panel','naturalife') => 'author',
																			_x('Title','Admin Panel','naturalife') => 'title',
																			_x('Modified','Admin Panel','naturalife') => 'modified',
																			_x('ID','Admin Panel','naturalife') => 'ID',
																			_x('Randomized','Admin Panel','naturalife') => 'rand',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'list_order',
														'heading'     => _x( 'List Order', 'Admin Panel','naturalife' ),
														"description" => _x("Designates the ascending or descending order of the list_orderby parameter",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Descending','Admin Panel','naturalife') => 'DESC',
																			_x('Ascending','Admin Panel','naturalife') => 'ASC',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'item_per_page',
														'heading'     => _x('Amount of post per page', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),


													array(
														'param_name'  => 'categories',
														'heading'     => _x( 'Categories', 'Admin Panel','naturalife' ),
														"description" => _x("Filter the posts by selected categories.",'Admin Panel','naturalife'),
														'type'        => 'dropdown_multi',
														"value"       => array_merge(array(_x('All Categories','Admin Panel','naturalife')=>""),array_flip(rt_get_categories())),
														'save_always' => true
													),

													array(
														'param_name'  => 'show_date',
														'heading'     => _x("Display Date", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'show_author',
														'heading'     => _x("Display Post Author", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'show_categories',
														'heading'     => _x("Display Categories", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'show_comment_numbers',
														'heading'     => _x("Display Comment Numbers", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'show_share',
														'heading'     => _x("Display Social Share", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													/* Featured Images */
													array(
														'param_name'  => 'show_featured_media',
														'heading'     => _x("Display Featured Images / Media", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_resize',
														'heading'     => _x( 'Resize Featured Images', 'Admin Panel','naturalife' ),
														'description' => _x('Enable the "Image Resize" to resize or crop the featured images automatically. These settings will be overwrite the global settings. Please note, since the theme is reponsive the images cannot be wider than the column they are in. Leave values "0" to use theme defaults.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled",'Admin Panel','naturalife') => "true",
																			_x("Disabled",'Admin Panel','naturalife') => "false"
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_max_width',
														'heading'     => _x('Featured Image Max Width', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => 0,
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_max_height',
														'heading'     => _x('Featured Image Max Height', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => 0,
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_crop',
														'heading'     => _x( 'Crop Featured Images', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),								
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

										),
					),

					/*
						Portfolio Posts
					*/ 
					"portfolio_box" => array(
						"name"=> _x('Portfolio Posts','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'portfolio_box',
						"description"=> _x('Displays porfolio posts with selected parameters','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(


													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),

													array(
														'param_name'  => 'layout_style',
														'heading'     => _x( 'Layout Style', 'Admin Panel','naturalife' ),
														"description" => _x("Design of the layout",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Grid",'Admin Panel','naturalife') => "grid",
																			_x("Masonry",'Admin Panel','naturalife') => "masonry",
																			_x("Metro",'Admin Panel','naturalife') => "metro", 
																		),
														'save_always' => true
													),


													array(
														'param_name'  => 'list_layout',
														'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
														"description" => _x("Column layout for the list",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			"1/6" => "1/6", 
																			"1/4" => "1/4",
																			"1/3" => "1/3",
																			"1/2" => "1/2",
																			"1/1" => "1/1"
																		),
														"dependency"  => array(
																			"element" => "layout_style",
																			"value" => array("grid","masonry")
																		),								
														'save_always' => true
													),

													array(
														'param_name'  => 'metro_layout',
														'heading'     => _x( 'Metro Layout', 'Admin Panel','naturalife' ),
														"description" => _x("Select a pre-defined layout for the metro gallery",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																				_x('Layout 1','Admin Panel','naturalife') => "1",
																				_x('Layout 2','Admin Panel','naturalife') => "2",
																				_x('Layout 3','Admin Panel','naturalife') => "3"
																		),
														"dependency"  => array(
																			"element" => "layout_style",
																			"value" => array("metro")
																		),								
														'save_always' => true
													),

													array(
														'param_name'  => 'nogaps',
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Remove Gaps", 'Admin Panel','naturalife') => "true",
																		),	
														'save_always' => true	
													),


													array(
														'param_name'  => 'item_style',
														'heading'     => _x( 'Item Style', 'Admin Panel','naturalife' ),
														"description" => _x("Select a style for the portfolio item in listing pages & categories.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Style 1 - Info under the featured image",'Admin Panel','naturalife') => "style-1",
																			_x("Style 2 - Info embedded to the featured image ",'Admin Panel','naturalife') => "style-2"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'hover_style',
														'heading'     => _x( 'Hover Style', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select an overlay text style.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Style 1", 'Admin Panel','naturalife') => "hover-1",
																			_x("Style 2", 'Admin Panel','naturalife') => "hover-2", 
																		),				
														"dependency"  => array(
																			"element" => "item_style",
																			"value" => array("style-2")
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'box_style',
														'heading'     => _x( 'Box Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Default','Admin Panel','naturalife') => '',
																			_x('Boxed','Admin Panel','naturalife') => 'boxed',
																		),
														'save_always' => true
													),

						 							array(
														'param_name'  => 'filterable',
														'heading'     => _x( 'Filter Navigation', 'Admin Panel','naturalife' ),
														"description" => _x("Displays a filter navigation that contains categories of the posts of the list.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														"dependency"  => array(
																			"element" => "layout_style",
																			"value" => array("metro","masonry")
																		),										
														'save_always' => true
													),

													array(
														'param_name'  => 'pagination',
														'heading'     => _x( 'Pagination', 'Admin Panel','naturalife' ),
														"description" => _x("Splits the list into pages",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'ajax_pagination',
														'description' => _x( 'Works with Masonry & Metro layouts only.', 'Admin Panel','naturalife' ),
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Enable ajax pagination (load more)", 'Admin Panel','naturalife') => "true",
																		),	
														"dependency"  => array(
																			"element" => "pagination",
																			"value" => array("true")
																		),
														'save_always' => true	
													),

													array(
														'param_name'  => 'list_orderby',
														'heading'     => _x( 'List Order By', 'Admin Panel','naturalife' ),
														"description" => _x("Sorts the posts by this parameter",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Date','Admin Panel','naturalife') => 'date',
																			_x('Author','Admin Panel','naturalife') => 'author',
																			_x('Title','Admin Panel','naturalife') => 'title',
																			_x('Modified','Admin Panel','naturalife') => 'modified',
																			_x('ID','Admin Panel','naturalife') => 'ID',
																			_x('Randomized','Admin Panel','naturalife') => 'rand',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'list_order',
														'heading'     => _x( 'List Order', 'Admin Panel','naturalife' ),
														"description" => _x("Designates the ascending or descending order of the list_orderby parameter",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Descending','Admin Panel','naturalife') => 'DESC',
																			_x('Ascending','Admin Panel','naturalife') => 'ASC',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'item_per_page',
														'heading'     => _x('Amount of post per page', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),


													array(
														'param_name'  => 'display_categories',
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Display Categories", 'Admin Panel','naturalife') => "true",
																		),	
														'save_always' => true	
													),


													array(
														'param_name'  => 'display_excerpts',
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Display Excerpts", 'Admin Panel','naturalife') => "true",
																		),	
														'save_always' => true	
													),


													array(
														'param_name'  => 'categories',
														'heading'     => _x( 'Categories', 'Admin Panel','naturalife' ),
														"description" => _x("Filter the posts by selected categories.",'Admin Panel','naturalife'),
														'type'        => 'dropdown_multi',
														"value"       => array_merge(array(_x('All Categories','Admin Panel','naturalife')=>""),array_flip(rt_get_portfolio_categories())),
														'save_always' => true
													),



													/* Featured Images */


													array(
														'param_name'  => 'metro_resize',
														'heading'     => _x('Resize and Crop Metro Gallery Images?', 'Admin Panel','naturalife' ),
														"description" => _x("Do not upload small or landscape/portrait sized photos to get correct layout.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																					_x("Disabled",'Admin Panel','naturalife') => "false",
																					_x("Enabled",'Admin Panel','naturalife') => "true"
																				),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														"dependency"  => array(
																			"element" => "layout_style",
																			"value" => array("metro")
																		),								
														'save_always' => true
													),



													array(
														'param_name'  => 'featured_image_resize',
														'heading'     => _x( 'Resize Featured Images', 'Admin Panel','naturalife' ),
														'description' => _x('Enable the "Image Resize" to resize or crop the featured images automatically. These settings will be overwrite the global settings. Please note, since the theme is reponsive the images cannot be wider than the column they are in. Leave values "0" to use theme defaults.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled",'Admin Panel','naturalife') => "true",
																			_x("Disabled",'Admin Panel','naturalife') => "false"
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														"dependency"  => array(
																			"element" => "layout_style",
																			"value" => array("grid","masonry")
																		),								
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_max_width',
														'heading'     => _x('Featured Image Max Width', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => 0,
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_max_height',
														'heading'     => _x('Featured Image Max Height', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => 0,
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_crop',
														'heading'     => _x( 'Crop Featured Images', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),								
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),


										),
					),
					/*
						Testimonials Posts
					*/ 

					"testimonial_box" => array(
						"name"=> _x('Testimonials Posts','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'testimonial_box',
						"description"=> _x('Displays Testimonial posts with selected parameters','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(



												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),


												array(
													'param_name'  => 'list_layout',
													'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
													"description" => _x("Column layout for the list",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		"1/1" => "1/1",
																		"1/2" => "1/2",
																		"1/3" => "1/3",
																		"1/4" => "1/4",
																		"1/6" => "1/6", 
																	),
													'save_always' => true
												),
					 
					 							array(
													'param_name'  => 'style',
													'heading'     => _x( 'Style', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Left Aligned Text",'Admin Panel','naturalife') => "left",
																		_x("Centered Small Text ",'Admin Panel','naturalife') => "center",
																		_x("Centered Big Text ",'Admin Panel','naturalife') => "center big"
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'headings',
													'heading'     => _x( 'Display Headings', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"													
																	),
													'save_always' => true										
												),						

												array(
													'param_name'  => 'client_images',
													'heading'     => _x( 'Display Client Images', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"													
																	),
													'save_always' => true										
												),
												
												array(
													'param_name'  => 'pagination',
													'heading'     => _x( 'Pagination', 'Admin Panel','naturalife' ),
													"description" => _x("Splits the list into pages",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		"False" => "false", 
																		"True" => "true"													
																	),
													'save_always' => true										
												), 

												array(
													'param_name'  => 'categories',
													'heading'     => _x( 'Categories', 'Admin Panel','naturalife' ),
													"description" => _x("Filter the posts by selected categories.",'Admin Panel','naturalife'),
													'type'        => 'dropdown_multi',
													"value"       => array_merge(array(_x('All Categories','Admin Panel','naturalife')=>""),array_flip(rt_get_testimonial_categories())),
												),
												
												array(
													'param_name'  => 'list_orderby',
													'heading'     => _x( 'List Order By', 'Admin Panel','naturalife' ),
													"description" => _x("Sorts the posts by this parameter",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		_x('Date','Admin Panel','naturalife') => 'date',
																		_x('Author','Admin Panel','naturalife') => 'author',
																		_x('Title','Admin Panel','naturalife') => 'title',
																		_x('Modified','Admin Panel','naturalife') => 'modified',
																		_x('ID','Admin Panel','naturalife') => 'ID',
																		_x('Randomized','Admin Panel','naturalife') => 'rand',
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'list_order',
													'heading'     => _x( 'List Order', 'Admin Panel','naturalife' ),
													"description" => _x("Designates the ascending or descending order of the list_orderby parameter",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		_x('Descending','Admin Panel','naturalife') => 'DESC',
																		_x('Ascending','Admin Panel','naturalife') => 'ASC',
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'item_per_page',
													'heading'     => _x('Amount of post per page', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

										),
					),

					/*
						Team Posts
					*/ 

					"staff_box" => array(
						"name"=> _x('Team','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'staff_box',
						"description"=> _x('Displays team members','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(


												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

												array(
													'param_name'  => 'list_layout',
													'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
													"description" => _x("Column layout for the list",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		"1/6" => "1/6", 
																		"1/4" => "1/4",
																		"1/3" => "1/3",
																		"1/2" => "1/2",
																		"1/1" => "1/1"
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'box_style',
													'heading'     => _x( 'Box Style', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x('Default','Admin Panel','naturalife') => '',
																		_x('Boxed','Admin Panel','naturalife') => 'boxed',
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'ids',
													'heading'     => _x( 'Select Members', 'Admin Panel','naturalife' ),
													"description" => _x("List posts of selected members only.",'Admin Panel','naturalife'),
													'type'        => 'dropdown_multi',
													"value"       => array_merge(array(_x('All Members','Admin Panel','naturalife')=>""),array_flip(rt_get_staff_list())),
												),

												array(
													'param_name'  => 'list_orderby',
													'heading'     => _x( 'List Order By', 'Admin Panel','naturalife' ),
													"description" => _x("Sorts the posts by this parameter",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		_x('Date','Admin Panel','naturalife') => 'date',
																		_x('Author','Admin Panel','naturalife') => 'author',
																		_x('Title','Admin Panel','naturalife') => 'title',
																		_x('Modified','Admin Panel','naturalife') => 'modified',
																		_x('ID','Admin Panel','naturalife') => 'ID',
																		_x('Randomized','Admin Panel','naturalife') => 'rand',
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'list_order',
													'heading'     => _x( 'List Order', 'Admin Panel','naturalife' ),
													"description" => _x("Designates the ascending or descending order of the list_orderby parameter",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		_x('Descending','Admin Panel','naturalife') => 'DESC',
																		_x('Ascending','Admin Panel','naturalife') => 'ASC',
																	),
													'save_always' => true
												),


										),
					),

					/*
						Portfolio Carousel
					*/ 
					"portfolio_carousel" => array(
						"name"=> _x('Portfolio Carousel','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'product_carousel',
						"description"=> _x('Displays portfolio posts with selected parameters as a carousel','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(


													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', "Admin Panel","naturalife" ),
														'description' => _x('Unique ID', "Admin Panel","naturalife" ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'list_layout',
														'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
														"description" => __("Visible item count for each slide on desktop screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																				"1" => "1/1",
																				"2" => "1/2",
																				"3" => "1/3",
																				"4" => "1/4",
																				"5" => "1/5",
																				"6" => "1/6"
																			),
														'save_always' => true
													),
						 
						  							array(
														'param_name'  => 'tablet_layout',
														'heading'     => __( 'Carousel Layout (Tablet)', 'Admin Panel','naturalife' ),
														"description" => __("Visible item count for each slide on medium screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			__("Default",'Admin Panel',"naturalife") => "",
																			"1" => "1",
																			"2" => "2",													
																			"3" => "3",													
																			"4" => "4",													
																			"5" => "5",													
																			"6" => "6"
																			),
														'save_always' => true
													),

													array(
														'param_name'  => 'mobile_layout',
														'heading'     => __( 'Carousel Layout (Mobile)', 'Admin Panel','naturalife' ),
														"description" => __("Visible item count for each slide on small screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			__("Default",'Admin Panel',"naturalife") => "",
																			"1" => "1",
																			"2" => "2",													
																			"3" => "3",													
																			"4" => "4"		 
																			),
														'save_always' => true
													),

													array(
														'param_name'  => 'item_style',
														'heading'     => _x( 'Item Style', "Admin Panel","naturalife" ),
														"description" => _x("Select a style for the portfolio items","Admin Panel","naturalife"),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Style 1 - Info under the featured image","Admin Panel","naturalife") => "style-1",
																			_x("Style 2 - Info embedded to the featured image ","Admin Panel","naturalife") => "style-2"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'hover_style',
														'heading'     => _x( 'Hover Style', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select an overlay text style.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Style 1", 'Admin Panel','naturalife') => "hover-1",
																			_x("Style 2", 'Admin Panel','naturalife') => "hover-2", 
																		),				
														"dependency"  => array(
																			"element" => "item_style",
																			"value" => array("style-2")
																		),
														'save_always' => true
													),
													
													array(
														'param_name'  => 'color_set',
														'heading'     => _x( 'Color Set', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select a color scheme for the portflio list.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Global", 'Admin Panel','naturalife') => "global-style",
																			_x("Color Set 1", 'Admin Panel','naturalife') => "default-style",
																			_x("Color Set 2", 'Admin Panel','naturalife') => "alt-style-1", 
																			_x("Color Set 3", 'Admin Panel','naturalife') => "light-style",
																		),				
														"dependency"  => array(
																			"element" => "item_style",
																			"value" => array("style-1")
																		),								
														'save_always' => true
													),
													array(
														'param_name'  => 'max_item',
														'heading'     => _x('Amount of item to display', "Admin Panel","naturalife" ),
														'type'        => 'rt_number',
														'value'       => '10',
														'save_always' => true
													),


													array(
														'param_name'  => 'nav',
														'heading'     => _x( 'Navigation Arrows', "Admin Panel","naturalife" ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled","Admin Panel","naturalife") => "true", 
																			_x("Disabled","Admin Panel","naturalife") => "false"													
																		),
														'save_always' => true										
													),

													array(
														'param_name'  => 'dots',
														'heading'     => _x( 'Navigation Dots', "Admin Panel","naturalife" ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled","Admin Panel","naturalife") => "true", 
																			_x("Disabled","Admin Panel","naturalife") => "false"												
																		),
														'save_always' => true										
													),

													array(
														'param_name'  => 'autoplay',
														'heading'     => _x( 'Auto Play', "Admin Panel","naturalife" ),
														'type'        => 'dropdown',
														"value"       => array(												
																			_x("Disabled","Admin Panel","naturalife") => "false",
																			_x("Enabled","Admin Panel","naturalife") => "true"
																		),
														'save_always' => true										
													),

													array(
														'param_name'  => 'timeout',
														'heading'     => _x('Auto Play Speed (ms)', "Admin Panel","naturalife" ),
														'type'        => 'rt_number',
														'value'       => "",
														"description" => _x("Auto play speed value in milliseconds. For example; set 5000 for 5 seconds","Admin Panel","naturalife"),
														"dependency"  => array(
																			"element" => "autoplay",
																			"value" => array("true")
																		)
													),
													
													array(
														'param_name'  => 'list_orderby',
														'heading'     => _x( 'List Order By', "Admin Panel","naturalife" ),
														"description" => _x("Sorts the posts by this parameter","Admin Panel","naturalife"),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Date',"Admin Panel","naturalife") => 'date',
																			_x('Author',"Admin Panel","naturalife") => 'author',
																			_x('Title',"Admin Panel","naturalife") => 'title',
																			_x('Modified',"Admin Panel","naturalife") => 'modified',
																			_x('ID',"Admin Panel","naturalife") => 'ID',
																			_x('Randomized',"Admin Panel","naturalife") => 'rand',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'list_order',
														'heading'     => _x( 'List Order', "Admin Panel","naturalife" ),
														"description" => _x("Designates the ascending or descending order of the list_orderby parameter","Admin Panel","naturalife"),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Descending',"Admin Panel","naturalife") => 'DESC',
																			_x('Ascending',"Admin Panel","naturalife") => 'ASC',
																		),
														'save_always' => true
													),


													array(
														'param_name'  => 'categories',
														'heading'     => _x( 'Categories', "Admin Panel","naturalife" ),
														"description" => _x("Filter the posts by selected categories.","Admin Panel","naturalife"),
														'type'        => 'dropdown_multi',
														"value"       => array_merge(array(_x('All Categories',"Admin Panel","naturalife")=>""),array_flip(rt_get_portfolio_categories())),
														'save_always' => true
													),


													/* Featured Images */
													array(
														'param_name'  => 'featured_image_resize',
														'heading'     => _x( 'Resize Featured Images', "Admin Panel","naturalife" ),
														'description' => _x('Enable the "Image Resize" to resize or crop the featured images automatically. These settings will be overwrite the global settings. Please note, since the theme is reponsive the images cannot be wider than the column they are in. Leave values "0" to use theme defaults.', "Admin Panel","naturalife" ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled","Admin Panel","naturalife") => "true",
																			_x("Disabled","Admin Panel","naturalife") => "false"
																		),
														'group' => _x('Featured Images', "Admin Panel","naturalife"),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_max_width',
														'heading'     => _x('Featured Image Max Width', "Admin Panel","naturalife" ),
														'type'        => 'textfield',
														'value'       => 0,
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),
														'group' => _x('Featured Images', "Admin Panel","naturalife"),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_max_height',
														'heading'     => _x('Featured Image Max Height', "Admin Panel","naturalife" ),
														'type'        => 'textfield',
														'value'       => 0,
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),
														'group' => _x('Featured Images', "Admin Panel","naturalife"),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_crop',
														'heading'     => _x( 'Crop Featured Images', "Admin Panel","naturalife" ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled","Admin Panel","naturalife") => "false",
																			_x("Enabled","Admin Panel","naturalife") => "true"
																		),
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),								
														'group' => _x('Featured Images', "Admin Panel","naturalife"),
														'save_always' => true
													),

													array(
														'param_name'  => 'margin',
														'heading'     => _x('Item Margin', 'Admin Panel','naturalife' ),
														'description' => _x('Set a value for the margin between carousel items. Default is 15px', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => ''
													),

													array(
														'param_name'  => 'padding',
														'heading'     => _x('Stage Padding', 'Admin Panel','naturalife' ),
														'description' => _x('Set a value for the padding of the carousel stage. This will cut first and last visible items.', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => ''
													),

													array(
														'param_name'  => 'loop',
														'heading'     => _x( 'Loop Items', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'display_categories',
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Display Categories", "Admin Panel","naturalife") => "true",
																		),	
														'save_always' => true	
													),


													array(
														'param_name'  => 'display_excerpts',
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Display Excerpts", "Admin Panel","naturalife") => "true",
																		),	
														'save_always' => true	
													),

										),	
					),


					/*
						Posts Carousel
					*/ 
					"blog_carousel" => array(
						"name"=> _x('Blog Posts Carousel','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'blog_carousel',
						"description"=> _x('Displays posts with selected parameters as a carousel','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(



													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'list_layout',
														'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
														"description" => __("Visible item count for each slide on desktop screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																				"1" => "1/1",
																				"2" => "1/2",
																				"3" => "1/3",
																				"4" => "1/4",
																				"5" => "1/5",
																				"6" => "1/6"
																			),
														'save_always' => true
													),
						 
						  							array(
														'param_name'  => 'tablet_layout',
														'heading'     => __( 'Carousel Layout (Tablet)', 'Admin Panel','naturalife' ),
														"description" => __("Visible item count for each slide on medium screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			__("Default",'Admin Panel',"naturalife") => "",
																			"1" => "1",
																			"2" => "2",													
																			"3" => "3",													
																			"4" => "4",													
																			"5" => "5",													
																			"6" => "6"
																			),
														'save_always' => true
													),

													array(
														'param_name'  => 'mobile_layout',
														'heading'     => __( 'Carousel Layout (Mobile)', 'Admin Panel','naturalife' ),
														"description" => __("Visible item count for each slide on small screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			__("Default",'Admin Panel',"naturalife") => "",
																			"1" => "1",
																			"2" => "2",													
																			"3" => "3",													
																			"4" => "4"		 
																			),
														'save_always' => true
													),

													array(
														'param_name'  => 'box_style',
														'heading'     => _x( 'Box Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Default','Admin Panel','naturalife') => '',
																			_x('Boxed','Admin Panel','naturalife') => 'boxed',
																		),
														'save_always' => true
													),


													array(
														'param_name'  => 'heading_size',
														'heading'     => _x( 'Heading Size', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select the size of the heading tag', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown', 
														"value"       => array(
																			"H1" => "h1", 
																			"H2" => "h2", 
																			"H3" => "h3", 
																			"H4" => "h4", 
																			"H5" => "h5", 
																			"H6" => "h6", 
																		),
														'save_always' => true
													),


													array(
														'param_name'  => 'max_item',
														'heading'     => _x('Amount of item to display', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '10',
														'save_always' => true
													),


													array(
														'param_name'  => 'excerpt_length',
														'heading'     => _x('Excerpt Length', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '100',
														'save_always' => true
													),

													array(
														'param_name'  => 'nav',
														'heading'     => _x( 'Navigation Arrows', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled",'Admin Panel','naturalife') => "true", 
																			_x("Disabled",'Admin Panel','naturalife') => "false"													
																		),
																		'save_always' => true						
													),

													array(
														'param_name'  => 'dots',
														'heading'     => _x( 'Navigation Dots', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled",'Admin Panel','naturalife') => "true", 
																			_x("Disabled",'Admin Panel','naturalife') => "false"												
																		),
																		'save_always' => true						
													),

													array(
														'param_name'  => 'autoplay',
														'heading'     => _x( 'Auto Play', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(												
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
																		'save_always' => true						
													),

													array(
														'param_name'  => 'timeout',
														'heading'     => _x('Auto Play Speed (ms)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => "",
														"description" => _x("Auto play speed value in milliseconds. For example; set 5000 for 5 seconds",'Admin Panel','naturalife'),
														"dependency"  => array(
																			"element" => "autoplay",
																			"value" => array("true")
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'list_orderby',
														'heading'     => _x( 'List Order By', 'Admin Panel','naturalife' ),
														"description" => _x("Sorts the posts by this parameter",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Date','Admin Panel','naturalife') => 'date',
																			_x('Author','Admin Panel','naturalife') => 'author',
																			_x('Title','Admin Panel','naturalife') => 'title',
																			_x('Modified','Admin Panel','naturalife') => 'modified',
																			_x('ID','Admin Panel','naturalife') => 'ID',
																			_x('Randomized','Admin Panel','naturalife') => 'rand',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'list_order',
														'heading'     => _x( 'List Order', 'Admin Panel','naturalife' ),
														"description" => _x("Designates the ascending or descending order of the list_orderby parameter",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Descending','Admin Panel','naturalife') => 'DESC',
																			_x('Ascending','Admin Panel','naturalife') => 'ASC',
																		),
														'save_always' => true
													),


													array(
														'param_name'  => 'categories',
														'heading'     => _x( 'Categories', 'Admin Panel','naturalife' ),
														"description" => _x("Filter the posts by selected categories.",'Admin Panel','naturalife'),
														'type'        => 'dropdown_multi',
														"value"       => array_merge(array(_x('All Categories','Admin Panel','naturalife')=>""),array_flip(rt_get_categories())),
														'save_always' => true
													),


													/* Post Meta */

													array(
														'param_name'  => 'show_date',
														'heading'     => _x("Display Date", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'show_author',
														'heading'     => _x("Display Post Author", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'show_categories',
														'heading'     => _x("Display Categories", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'show_comment_numbers',
														'heading'     => _x("Display Comment Numbers", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group'       => _x('Post Meta', 'Admin Panel','naturalife'),
														'save_always' => true
													),


													array(
														'param_name'  => 'margin',
														'heading'     => _x('Item Margin', 'Admin Panel','naturalife' ),
														'description' => _x('Set a value for the margin between carousel items. Default is 15px', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => ''
													),

													array(
														'param_name'  => 'padding',
														'heading'     => _x('Stage Padding', 'Admin Panel','naturalife' ),
														'description' => _x('Set a value for the padding of the carousel stage. This will cut first and last visible items.', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => ''
													),

													array(
														'param_name'  => 'loop',
														'heading'     => _x( 'Loop Items', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														'save_always' => true
													),
													

													/* Featured Images */
													array(
														'param_name'  => 'show_featured_media',
														'heading'     => _x("Display Featured Images / Media", 'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Yes','Admin Panel','naturalife') => 'true',
																			_x('No','Admin Panel','naturalife') => 'false',
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_resize',
														'heading'     => _x( 'Resize Featured Images', 'Admin Panel','naturalife' ),
														'description' => _x('Enable the "Image Resize" to resize or crop the featured images automatically. These settings will be overwrite the global settings. Please note, since the theme is reponsive the images cannot be wider than the column they are in. Leave values "0" to use theme defaults.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled",'Admin Panel','naturalife') => "true",
																			_x("Disabled",'Admin Panel','naturalife') => "false"
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_max_width',
														'heading'     => _x('Featured Image Max Width', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => 0,
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_max_height',
														'heading'     => _x('Featured Image Max Height', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => 0,
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'featured_image_crop',
														'heading'     => _x( 'Crop Featured Images', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														"dependency"  => array(
																			"element" => "featured_image_resize",
																			"value" => array("true")
																		),								
														'group' => _x('Featured Images', 'Admin Panel','naturalife'),
														'save_always' => true
													),

										),
					),

					/*
						Testimonials Carousel
					*/  

					"testimonial_carousel" => array(
						"name"=> _x('Testimonials Carousel','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'testimonial_carousel',
						"description"=> _x('Displays testimonial posts within a carousel','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(


												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'list_layout',
													'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
													"description" => __("Visible item count for each slide on desktop screens.",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																			"1" => "1/1",
																			"2" => "1/2",
																			"3" => "1/3",
																			"4" => "1/4",
																			"5" => "1/5",
																			"6" => "1/6"
																		),
													'save_always' => true
												),
					 
					  							array(
													'param_name'  => 'tablet_layout',
													'heading'     => __( 'Carousel Layout (Tablet)', 'Admin Panel','naturalife' ),
													"description" => __("Visible item count for each slide on medium screens.",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		__("Default",'Admin Panel',"naturalife") => "",
																		"1" => "1",
																		"2" => "2",													
																		"3" => "3",													
																		"4" => "4",													
																		"5" => "5",													
																		"6" => "6"
																		),
													'save_always' => true
												),

												array(
													'param_name'  => 'mobile_layout',
													'heading'     => __( 'Carousel Layout (Mobile)', 'Admin Panel','naturalife' ),
													"description" => __("Visible item count for each slide on small screens.",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		__("Default",'Admin Panel',"naturalife") => "",
																		"1" => "1",
																		"2" => "2",													
																		"3" => "3",													
																		"4" => "4"		 
																		),
													'save_always' => true
												),

												array(
													'param_name'  => 'box_style',
													'heading'     => _x( 'Box Style', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x('Default','Admin Panel','naturalife') => '',
																		_x('Boxed','Admin Panel','naturalife') => 'boxed',
																	),
													'save_always' => true
												),

					 							array(
													'param_name'  => 'style',
													'heading'     => _x( 'Style', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Left Aligned Text",'Admin Panel','naturalife') => "left",
																		_x("Centered Small Text ",'Admin Panel','naturalife') => "center",
																		_x("Centered Big Text ",'Admin Panel','naturalife') => "center big"
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'headings',
													'heading'     => _x( 'Display Headings', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"													
																	),
													'save_always' => true										
												),							
												
												array(
													'param_name'  => 'client_images',
													'heading'     => _x( 'Display Client Images', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"													
																	),					
													'save_always' => true	
												),

												array(
													'param_name'  => 'max_item',
													'heading'     => _x('Amount of item to display', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'value'       => '10',
													'save_always' => true
												),
					 

												array(
													'param_name'  => 'nav',
													'heading'     => _x( 'Navigation Arrows', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"													
																	),
													'save_always' => true						
												),

												array(
													'param_name'  => 'dots',
													'heading'     => _x( 'Navigation Dots', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"												
																	),
													'save_always' => true						
												),

												array(
													'param_name'  => 'autoplay',
													'heading'     => _x( 'Auto Play', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(												
																		_x("Disabled",'Admin Panel','naturalife') => "false",
																		_x("Enabled",'Admin Panel','naturalife') => "true"
																	),
													'save_always' => true						
												),

												array(
													'param_name'  => 'timeout',
													'heading'     => _x('Auto Play Speed (ms)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'value'       => "",
													"description" => _x("Auto play speed value in milliseconds. For example; set 5000 for 5 seconds",'Admin Panel','naturalife'),
													"dependency"  => array(
																		"element" => "autoplay",
																		"value" => array("true")
																	),
												),
												/*
												array(
													'param_name'  => 'ids',
													'heading'     => _x( 'Select Testimonials', 'Admin Panel','naturalife' ),
													"description" => _x("List posts of selected posts only.",'Admin Panel','naturalife'),
													'type'        => 'dropdown_multi',
													"value"       => array_merge(array(_x('All Testimonials','Admin Panel','naturalife')=>""),array_flip(RTFramework::rt_get_testimonial_list())),
												),
												*/

												array(
													'param_name'  => 'categories',
													'heading'     => _x( 'Categories', 'Admin Panel','naturalife' ),
													"description" => _x("Filter the posts by selected categories.",'Admin Panel','naturalife'),
													'type'        => 'dropdown_multi',
													"value"       => array_merge(array(_x('All Categories','Admin Panel','naturalife')=>""),array_flip(rt_get_testimonial_categories())),
												),
												

												array(
													'param_name'  => 'list_orderby',
													'heading'     => _x( 'List Order By', 'Admin Panel','naturalife' ),
													"description" => _x("Sorts the posts by this parameter",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		_x('Date','Admin Panel','naturalife') => 'date',
																		_x('Author','Admin Panel','naturalife') => 'author',
																		_x('Title','Admin Panel','naturalife') => 'title',
																		_x('Modified','Admin Panel','naturalife') => 'modified',
																		_x('ID','Admin Panel','naturalife') => 'ID',
																		_x('Randomized','Admin Panel','naturalife') => 'rand',
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'list_order',
													'heading'     => _x( 'List Order', 'Admin Panel','naturalife' ),
													"description" => _x("Designates the ascending or descending order of the list_orderby parameter",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		_x('Descending','Admin Panel','naturalife') => 'DESC',
																		_x('Ascending','Admin Panel','naturalife') => 'ASC',
																	),
													'save_always' => true
												),
					  
								
						
										),
					),


					/*
						Image Carousel
					*/  

					"rt_image_carousel" => array(
						"name"=> _x('Image Carousel','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'rt_image_carousel',
						"description"=> _x('Displays selected images as a carousel','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(


													array(
														'param_name'  => 'images',
														'heading'     => _x('Images', 'Admin Panel','naturalife' ),
														'description' => _x('Select images for the carousel', 'Admin Panel','naturalife' ),
														'type'        => 'attach_images',
														'value'	     => '',
													),

													array(
														'param_name'  => 'carousel_layout',
														'heading'     => _x( 'Carousel Layout', 'Admin Panel','naturalife' ),
														"description" => _x("Visible item count for each slide on desktop screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			"1" => "1",
																			"2" => "2",													
																			"3" => "3",													
																			"4" => "4",													
																			"5" => "5",													
																			"6" => "6",													
																			"7" => "7",													
																			"8" => "8",													
																			"9" => "9", 
																			"10" => "10"
																		),
														'save_always' => true
													),


						  							array(
														'param_name'  => 'tablet_layout',
														'heading'     => __( 'Carousel Layout (Tablet)', 'Admin Panel','naturalife' ),
														"description" => __("Visible item count for each slide on medium screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			__("Default",'Admin Panel',"naturalife") => "",
																			"1" => "1",
																			"2" => "2",													
																			"3" => "3",													
																			"4" => "4",													
																			"5" => "5",													
																			"6" => "6"
																			),
														'save_always' => true
													),

													array(
														'param_name'  => 'mobile_layout',
														'heading'     => __( 'Carousel Layout (Mobile)', 'Admin Panel','naturalife' ),
														"description" => __("Visible item count for each slide on small screens.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			__("Default",'Admin Panel',"naturalife") => "",
																			"1" => "1",
																			"2" => "2",													
																			"3" => "3",													
																			"4" => "4"		 
																			),
														'save_always' => true
													),

													array(
														'param_name'  => 'image_size',
														'heading'     => __( 'Image size', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array_merge(array("Custom","full"),get_intermediate_image_sizes()),
														'save_always' => true
													),

													array(
														'param_name'  => 'img_width',
														'heading'     => _x('Max Image Width', 'Admin Panel','naturalife' ),
														'description' => _x('Set an maximum width value for the carousel images. Note: Remember that the carousel width will be fluid.', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => ''
													),

													array(
														'param_name'  => 'img_height',
														'heading'     => _x('Max Image Height', 'Admin Panel','naturalife' ),
														'description' => _x('Set an maximum height value for the carousel images.', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => ''
													),

													array(
														'param_name'  => 'crop',
														'heading'     => _x( 'Crop Images', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														"dependency"  => array(
																			"element" => "image_size",
																			"value" => array("custom")
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'nav',
														'heading'     => _x( 'Navigation Arrows', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enabled",'Admin Panel','naturalife') => "true", 
																			_x("Disabled",'Admin Panel','naturalife') => "false"													
																		),
														'save_always' => true						
													),

													array(
														'param_name'  => 'dots',
														'heading'     => _x( 'Navigation Dots', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",	
																			_x("Enabled",'Admin Panel','naturalife') => "true"							
																		),
														'save_always' => true						
													),

													array(
														'param_name'  => 'autoplay',
														'heading'     => _x( 'Auto Play', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(												
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														'save_always' => true						
													),

													array(
														'param_name'  => 'timeout',
														'heading'     => _x('Auto Play Speed (ms)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => "",
														"description" => _x("Auto play speed value in milliseconds. For example; set 5000 for 5 seconds",'Admin Panel','naturalife'),
														"dependency"  => array(
																			"element" => "autoplay",
																			"value" => array("true")
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'links',
														'heading'     => _x( 'Item Links', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Open Orginal Images in Lightbox",'Admin Panel','naturalife') => "lightbox",
																			_x("Custom Links",'Admin Panel','naturalife') => "custom"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'custom_links',
														'heading'     => _x( 'Custom Links', 'Admin Panel','naturalife' ),
														'description' => _x("Enter links for each image. The links must be entered line by line. ( enter ) ",'Admin Panel','naturalife'),
														'type'        => 'exploded_textarea',
														"dependency"  => array(
																				"element" => "links",
																				"value" => array("custom")
																			),								
													),

													array(
														'param_name'  => 'link_target',
														'heading'     => _x('Link Target', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																			_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																		),
														"dependency"  => array(
																				"element" => "links",
																				"value" => array("custom")
																			),											
														'save_always' => true
													),

													array(
														'param_name'  => 'captions',
														'heading'     => _x('Image Captions', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'margin',
														'heading'     => _x('Item Margin', 'Admin Panel','naturalife' ),
														'description' => _x('Set a value for the margin between carousel items. Default is 15px', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => ''
													),

													array(
														'param_name'  => 'padding',
														'heading'     => _x('Stage Padding', 'Admin Panel','naturalife' ),
														'description' => _x('Set a value for the padding of the carousel stage. This will cut first and last visible items.', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => ''
													),

													array(
														'param_name'  => 'loop',
														'heading'     => _x( 'Loop Items', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'boxed',
														'heading'     => _x( 'Boxed Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'shadows',
														'heading'     => _x( 'Item Shadows', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),
						
										),
					),

					/*
						Latest News
					*/  

					"rt_latest_news" => array(
						"name"=> _x('Latest News','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'rt_latest_news',
						"description"=> _x('Displays blog posts with latest news style','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),


													array(
														'param_name'  => 'list_layout',
														'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
														"description" => _x("Column layout for the list",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			"1/6" => "1/6", 
																			"1/4" => "1/4",
																			"1/3" => "1/3",
																			"1/2" => "1/2",
																			"1/1" => "1/1"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'style',
														'heading'     => _x( 'Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																				_x("Style 1", 'Admin Panel','naturalife')   => "style-1",
																				_x("Style 2", 'Admin Panel','naturalife')   => "style-2", 
																			),
														'save_always' => true
													),

													array(
														'param_name'  => 'heading_size',
														'heading'     => _x( 'Heading Size', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select the size of the heading tag', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown', 
														"value"       => array(
																			"H1" => "h1", 
																			"H2" => "h2", 
																			"H3" => "h3", 
																			"H4" => "h4", 
																			"H5" => "h5", 
																			"H6" => "h6", 
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'max_item',
														'heading'     => _x('Amount of item to display', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '10',
														'save_always' => true
													),


													array(
														'param_name'  => 'excerpt_length',
														'heading'     => _x('Excerpt Length', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '100',
														'save_always' => true
													),

													array(
														'param_name'  => 'list_orderby',
														'heading'     => _x( 'List Order By', 'Admin Panel','naturalife' ),
														"description" => _x("Sorts the posts by this parameter",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Date','Admin Panel','naturalife') => 'date',
																			_x('Author','Admin Panel','naturalife') => 'author',
																			_x('Title','Admin Panel','naturalife') => 'title',
																			_x('Modified','Admin Panel','naturalife') => 'modified',
																			_x('ID','Admin Panel','naturalife') => 'ID',
																			_x('Randomized','Admin Panel','naturalife') => 'rand',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'list_order',
														'heading'     => _x( 'List Order', 'Admin Panel','naturalife' ),
														"description" => _x("Designates the ascending or descending order of the list_orderby parameter",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			_x('Descending','Admin Panel','naturalife') => 'DESC',
																			_x('Ascending','Admin Panel','naturalife') => 'ASC',
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'categories',
														'heading'     => _x( 'Categories', 'Admin Panel','naturalife' ),
														"description" => _x("Filter the posts by selected categories.",'Admin Panel','naturalife'),
														'type'        => 'dropdown_multi',
														"value"       => array_merge(array(_x('All Categories','Admin Panel','naturalife')=>""),array_flip(rt_get_categories())),
														'save_always' => true
													),


													array(
														'param_name'  => 'show_categories',
														'heading'     => _x('Display Post Categories?', 'Admin Panel','naturalife' ),
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Yes", 'Admin Panel','naturalife') => "true"
														),
														'save_always' => true								
													),

													array(
														'param_name'  => 'show_dates',
														'heading'     => _x('Display Post Dates?', 'Admin Panel','naturalife' ),
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Yes", 'Admin Panel','naturalife') => "true"
														),
														'save_always' => true								
													),

													array(
														'param_name'  => 'show_button',
														'heading'     => _x('Display Read More Button?', 'Admin Panel','naturalife' ),
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Yes", 'Admin Panel','naturalife') => "true"
														),
														'save_always' => true								
													),

													array(
														'param_name'  => 'thumbnails',
														'heading'     => _x('Display Post Thumbnails?', 'Admin Panel','naturalife' ),
														'type'        => 'checkbox',
														"value"       => array(
																			_x("Yes", 'Admin Panel','naturalife') => "true"
														),
														'save_always' => true								
													),


													/* Featured Images */
													array(
														'param_name'  => 'image_width',
														'heading'     => _x('Featured Image Max Width', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => 50,
														'save_always' => true,
														"dependency"  => array(
																			"element" => "thumbnails",
																			"value" => array("true")
																		),								
													),

													array(
														'param_name'  => 'image_height',
														'heading'     => _x('Featured Image Max Height', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => 50,
														'save_always' => true,
														"dependency"  => array(
																			"element" => "thumbnails",
																			"value" => array("true")
																		),								
													),


										),
					),
			/*
				Images
			*/
			"group-3" => array(
				"group_name"=> _x('Media & Sliders','Admin Panel','naturalife'),
				"group_icon"=> "rt-panel-icon-code-1",
			),


					"rt_photo_gallery" => array(
						"name"=> _x('Photo Gallery','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'rt_photo_gallery',
						"description"=> _x('Creates a photo gallery with the selected images','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),						
						"parameters" => array(

													array(
														'param_name'  => 'image_ids',
														'heading'     => _x('Photos', 'Admin Panel','naturalife' ),
														'description' => _x('Select photos for the gallery', 'Admin Panel','naturalife' ),
														'type'        => 'attach_images',
														'value'	     => '',
													),


													array(
														'param_name'  => 'layout_style',
														'heading'     => _x( 'Layout Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																					_x("Grid",'Admin Panel','naturalife') => "grid",
																					_x("Masonry",'Admin Panel','naturalife') => "masonry",
																					_x("Metro",'Admin Panel','naturalife') => "metro"
																				),
														'save_always' => true
													),

													array(
														'param_name'  => 'image_size',
														'heading'     => __( 'Image size', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array_merge(array("Custom","full"),get_intermediate_image_sizes()),
														"dependency"  => array(
																					"element" => "layout_style",
																					"value" => array("grid","masonry")
																				),										
														'save_always' => true
													),


													array(
														'param_name'  => 'w',
														'heading'     => _x('Image Width', 'Admin Panel','naturalife' ),
														'description' => _x('Set a width value for the carousel images. Note: Remember that the images width will be resoponsive. Leave blank for auto width.', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '',
														"save_always" => true,
														"dependency"  => array(
																					"element" => "image_size",
																					"value" => array("Custom")
																				),
														'save_always' => true
													),

													array(
														'param_name'  => 'h',
														'heading'     => _x('Image Height', 'Admin Panel','naturalife' ),
														'description' => _x('Set a height value for the images. Remember that the image heights will be resoponsive. Leave blank for auto height.', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '',
														"save_always" => true,
														"dependency"  => array(
																				"element" => "image_size",
																				"value" => array("Custom")
																				),
														'save_always' => true								
													),

													array(
														'param_name'  => 'crop',
														'heading'     => _x( 'Crop Images', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																					_x("Disabled",'Admin Panel','naturalife') => "false",
																					_x("Enabled",'Admin Panel','naturalife') => "true"
																				),
														'save_always' => true,
														"dependency"  => array(
																				"element" => "image_size",
																				"value" => array("Custom")
																			),
														'save_always' => true								
													),
						 
													array(
														'param_name'  => 'metro_resize',
														'heading'     => _x('Resize and Crop Metro Gallery Images?', 'Admin Panel','naturalife' ),
														"description" => _x("Do not upload small or landscape/portrait sized photos to get correct layout.",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																					_x("Disabled",'Admin Panel','naturalife') => "false",
																					_x("Enabled",'Admin Panel','naturalife') => "true"
																				),
														"dependency"  => array(
																			"element" => "layout_style",
																			"value" => array("metro")
																		),								
														'save_always' => true
													),


													array(
														'param_name'  => 'layout',
														'heading'     => _x('Metro Layout', 'Admin Panel','naturalife' ),
														"description" => _x("Pre defined layouts",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																					_x("Style 1",'Admin Panel','naturalife') => "1",
																					_x("Style 2",'Admin Panel','naturalife') => "2",
																					_x("Style 3",'Admin Panel','naturalife') => "3"
																				),
														"dependency"  => array(
																			"element" => "layout_style",
																			"value" => array("metro")
																		),								
														'save_always' => true
													),


						 							array(
														'param_name'  => 'item_width',
														'heading'     => _x('Gallery Layout', 'Admin Panel','naturalife' ),
														"description" => _x("Image per row",'Admin Panel','naturalife'),
														'type'        => 'dropdown',
														"value"       => array(
																			"1/12" => "1/12", 
																			"1/6" => "1/6", 
																			"1/4" => "1/4",
																			"1/3" => "1/3",
																			"1/2" => "1/2",
																			"1/1" => "1/1"
																		),
														"dependency"  => array(
																			"element" => "layout_style",
																			"value" => array("grid","masonry")
																		),								
														'save_always' => true
													),
						 
										 			array(
														'param_name'  => 'nogaps', 
														"value"       => array(
																			_x("Remove column gaps", 'Admin Panel','naturalife') => "true"
																		),							
														'type'        => 'checkbox',
														'save_always' => true
													),


													array(
														'param_name'  => 'links',
														'heading'     => _x( 'Item Links', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Open Orginal Images in Lightbox",'Admin Panel','naturalife') => "lightbox",
																			_x("Custom Links",'Admin Panel','naturalife') => "custom"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'custom_links',
														'heading'     => _x( 'Custom Links', 'Admin Panel','naturalife' ),
														'description' => _x("Enter links for each image. The links must be entered line by line. ( enter ) ",'Admin Panel','naturalife'),
														'type'        => 'exploded_textarea',
														"dependency"  => array(
																				"element" => "links",
																				"value" => array("custom")
																			),								
													),

													array(
														'param_name'  => 'link_target',
														'heading'     => _x('Link Target', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																			_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																		),
														"dependency"  => array(
																				"element" => "links",
																				"value" => array("custom")
																			),											
														'save_always' => true
													),

													array(
														'param_name'  => 'captions',
														'heading'     => _x('Image Captions', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Disabled",'Admin Panel','naturalife') => "false",
																			_x("Enabled",'Admin Panel','naturalife') => "true"
																		),
														'save_always' => true
													),


													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),
										),
					),

					/*
						Image Grid Gallery Holder
					*/			
					"rt_image_gallery" => array(

						"name"=> _x('Image Gallery Grid','Admin Panel','naturalife'),
						"description"=> _x('Image gallery holder','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_image_gallery',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'rt_gal_item',
										"text" => ''
									),
						"parameters" => array(


												array(
													'param_name'  => 'list_layout',
													'heading'     => _x( 'Layout', 'Admin Panel','naturalife' ),
													"description" => _x("Column layout for the list",'Admin Panel','naturalife'),
													'type'        => 'dropdown',
													"value"       => array(
																		"1/6" => "1/6", 
																		"1/4" => "1/4",
																		"1/3" => "1/3",
																		"1/2" => "1/2",
																		"1/1" => "1/1"
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'crop',
													'heading'     => _x('Crop', 'Admin Panel','naturalife' ),
													'type'        => 'checkbox',
													"value"       => array(
																		_x("Crop Images", 'Admin Panel','naturalife') => "true",
																	),
													'save_always' => true
												),
												
												array(
													'param_name'  => 'tooltips',
													'heading'     => _x('Tooltips', 'Admin Panel','naturalife' ),
													"description" => _x('Note: Tooltips works only when the image has not been linked to the lighbox or custom link.','naturalife'),
													'type'        => 'checkbox',
													"value"       => array(
																		_x("Enable Tooltips", 'Admin Panel','naturalife') => "true",
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'frames',
													'heading'     => _x('Frames', 'Admin Panel','naturalife' ),
													'type'        => 'checkbox',
													"value"       => array(
																		_x("Add Frames", 'Admin Panel','naturalife') => "true",
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

									
										),
					),

					/*
						Photo gallery images
					*/			
					"rt_gal_item" => array(

						"name"=> _x('Image','Admin Panel','naturalife'),
						"description"=> _x('Adds a new image','Admin Panel','naturalife'),
						"subline" => true,
						"id"=> 'rt_gal_item',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Description of the image'
									),
						"parameters" => array(
				
						 							array(
														'param_name'  => 'image_id',
														'heading'     => _x('Image', 'Admin Panel','naturalife' ),
														'description' => _x('Image ID', 'Admin Panel','naturalife' ),
														'type'        => 'attach_image',
														'holder'      => 'img',
													),
						 
													array(
														'param_name'  => 'title',
														'heading'     => _x( 'Title', 'Admin Panel','naturalife' ),
														'description' => '',
														'type'        => 'textfield',
														'holder'      => 'h4',
													),

													//link
													array(
														'param_name'  => 'action',
														'heading'     => _x('Action', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"default_value" => 'lightbox',
														'value'       => array(
																				"lightbox" => _x("Open orginal image in a lightbox", 'Admin Panel','naturalife'), 
																				"custom_link" => _x("Link the thumbnail to the custom link", 'Admin Panel','naturalife'), 
																				"no_link" => _x("No link", 'Admin Panel','naturalife'), 
																		), 
													),

													//link
													array(
														'param_name'  => 'custom_link',
														'heading'     => _x('Custom Link', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														"dependency"  => array(
																		"element" => "action",
																		"value" => array("custom_link")
														),									
													),
						 
													array(
														'param_name'  => 'link_target',
														'heading'     => _x('Link Target', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			"_self" => _x("Same Tab", 'Admin Panel','naturalife'),
																			"_blank" => _x("New Tab", 'Admin Panel','naturalife')
																		),
														"dependency"  => array(
																		"element" => "action",
																		"value" => array("custom_link")	
														),						
													),	


													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),

										),				
					),


					/*
						Image Slider Holder
					*/						

					"rt_slider" => array(

						"name"=> _x('Content Slider','Admin Panel','naturalife'),
						"description"=> _x('Holder shortcode for photo slider.','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_slider',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'rt_slide',
										"text" => ''
									),
						"parameters" => array(

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

												array(
													'param_name'  => 'min_height',
													'heading'     => _x('Minimum Slider Height (px)', 'Admin Panel','naturalife' ),
													'description' => _x('Slider minimum height value. ', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'value'       => 400,
													'save_always' => true
												),

												array(
													'param_name'  => 'mobile_min_height',
													'heading'     => _x('Minimum Slider Height for Mobile (px)', 'Admin Panel','naturalife' ),
													'description' => _x('Slider minimum height value to be applied for small screens only (< 768px).', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'value'       => 400,
													'save_always' => true
												),

												array(
													'param_name'  => 'autoplay',
													'heading'     => _x('Autoplay', 'Admin Panel','naturalife' ),
													'type'        => 'checkbox',
													'save_always' => true,
													"value"       => array(
																		_x("Start sliding automatically", 'Admin Panel','naturalife') => "true",
																	),
												),

												array(
													'param_name'  => 'fullheight',
													'heading'     => _x('Full Height', 'Admin Panel','naturalife' ),
													'type'        => 'checkbox',
													'save_always' => true,
													"value"       => array(
																		_x("Full-Height Carousel", 'Admin Panel','naturalife') => "true",
																	),
												),

												array(
													'param_name'  => 'parallax',
													'heading'     => _x('Parallax Effect', 'Admin Panel','naturalife' ),
													'type'        => 'checkbox',
													'save_always' => true,
													"value"       => array(
																		_x("Enable parallax effect for this slider", 'Admin Panel','naturalife') => "true",
																	),
												),

												array(
													'param_name'  => 'timeout',
													'heading'     => _x('Timeout', 'Admin Panel','naturalife' ),
													'description' => _x('Timeout value for each slide. Default is 5000 (equal 5sec)', 'Admin Panel','naturalife' ),
													'value'       => '5000',
													'type'        => 'rt_number',
													'save_always' => true
												),

												array(
													'param_name'  => 'text_nav',
													'heading'     => _x( 'Text Navigation', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"												
																	),
													'save_always' => true						
												),

												array(
													'param_name'  => 'nav',
													'heading'     => _x( 'Navigation Arrows', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"													
																	),
													'save_always' => true						
												),

												array(
													'param_name'  => 'dots',
													'heading'     => _x( 'Navigation Dots', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled",'Admin Panel','naturalife') => "true", 
																		_x("Disabled",'Admin Panel','naturalife') => "false"												
																	),
													'save_always' => true						
												),

										),
					),


					/*
						Slides
					*/			
					"rt_slide" => array(

						"name"=> _x('Slide','Admin Panel','naturalife'),
						"description"=> _x('Adds slide to the slider.','Admin Panel','naturalife'),
						"subline" => true,
						"id"=> 'rt_slide',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => _x('Slide text', 'Admin Panel','naturalife')
									),
						"parameters" => array(


													/**
													 * Slide Content Options
													 */

						 							array(
														'param_name'  => 'heading',
														'heading'     => _x('Heading', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'group' => _x('Slide Content', 'Admin Panel','naturalife')
													), 

						 							array(
														'param_name'  => 'nav_text',
														'heading'     => _x('Navigation Text', 'Admin Panel','naturalife' ),
														'description' => _x('The text will be displayed as a navigation item if the "Text Navigation" has been enabled for the slider.', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'group'       => _x('Slide Content', 'Admin Panel','naturalife')
													), 

													/**
													 *  Styling Options
													 */
													
													array(
														'param_name'  => 'heading_max_font_size',
														'heading'     => _x('Heading Max Font Size (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x('Styling', 'Admin Panel','naturalife')
													),

													array(
														'param_name'  => 'heading_min_font_size',
														'heading'     => _x('Heading Min Font Size (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',	
														'group'       => _x('Styling', 'Admin Panel','naturalife')
													),

													array(
														'param_name'  => 'content_font_size',
														'heading'     => _x('Content Font Size (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x('Styling', 'Admin Panel','naturalife')
													),

						 							array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'group' => _x('Styling', 'Admin Panel','naturalife')
													),

													array(
														'param_name'  => 'content_color_schema',
														'heading'     => _x( 'Content Color Scheme', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select a color scheme for the column. Please note the background color of the scheme will not be applied.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Global", 'Admin Panel','naturalife') => "global-style",
																			_x("Color Set 1", 'Admin Panel','naturalife') => "default-style",
																			_x("Color Set 2", 'Admin Panel','naturalife') => "alt-style-1", 
																			_x("Color Set 3", 'Admin Panel','naturalife') => "light-style",
																		),
														'save_always' => true,
														'group' => _x('Styling', 'Admin Panel','naturalife')

													),

													array(
														'param_name'  => 'content_wrapper_width',
														'heading'     => _x('Content Wrapper Width', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select a pre-defined width for the row content', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default Width", 'Admin Panel','naturalife') => "default",
																			_x("Full Width", 'Admin Panel','naturalife') => "fullwidth",
																		),	
														'save_always' => true,
														'group'       => _x('Styling', 'Admin Panel','naturalife')
													),

													array(
														'param_name'  => 'content_width',
														'heading'     => _x('Content Width (percent)', 'Admin Panel','naturalife' ),
														'description' => _x('Width of the content block. For mobile device screens, this value will be calculated automatically depends the screen width.', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '40',
														'save_always' => true,
														'group'       => _x('Styling', 'Admin Panel','naturalife')
													),

													array(
														'param_name'  => 'content_align',
														'heading'     => _x('Content Align', 'Admin Panel','naturalife' ),
														'description' => _x('Select a position for the content block. For mobile device screens, the content block will be aligned to the center automatically', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(		
																			_x("Right",'Admin Panel','naturalife') => "right",
																			_x("Left",'Admin Panel','naturalife') => "left",
																			_x("Center",'Admin Panel','naturalife') => "center", 
																		),
														'group' => _x('Styling', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'text_align',
														'heading'     => _x('Text Align', 'Admin Panel','naturalife' ),
														'description' => _x('Align the text within the content block.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(		
																			_x("Left",'Admin Panel','naturalife') => "left",
																			_x("Right",'Admin Panel','naturalife') => "right",													
																			_x("Center",'Admin Panel','naturalife') => "center", 
																		),
														'group' => _x('Styling', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'content_bg_color',
														'heading'     => __( 'Content Background Color', 'naturalife' ),
														'description' => '',
														'type'        => 'colorpicker',
														'group' 		  => __('Styling', 'naturalife')
													),


													/**
													 * Mobile Styling Options
													 */
						 							array(
														'param_name'  => 'mobile_heading_font_size',
														'heading'     => _x('Heading Font Size for Mobile (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'description' => _x('Default 28px', 'Admin Panel','naturalife'),
														'group' => _x('Mobile Styling', 'Admin Panel','naturalife'),
														'save_always' => true
													),

						 							array(
														'param_name'  => 'mobile_content_font_size',
														'heading'     => _x('Content Font Size for Mobile (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'description' => _x('Default 18px', 'Admin Panel','naturalife'),
														'group' => _x('Mobile Styling', 'Admin Panel','naturalife'),
														'save_always' => true
													),


													/**
													 * Link Options
													 */
													array(
														'param_name'  => 'link',
														'heading'     => _x('Link', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => _x('Link', 'Admin Panel','naturalife')
													),

													array(
														'param_name'  => 'link_target',
														'heading'     => _x('Link Target', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																			_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																		),
														'group'       => _x('Link', 'Admin Panel','naturalife')
													),		

						 							array(
														'param_name'  => 'link_title',
														'heading'     => _x('Link Title', 'Admin Panel','naturalife' ),
														'description' => _x('Text for the title attribute', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'group'       => _x('Link', 'Admin Panel','naturalife')
													),


													/**
													 * Background Options
													 */
													array(
														'param_name'  => 'bg_color_tone',
														'heading'     => _x( 'Background Color Tone', 'Admin Panel','naturalife' ),
														'description' => _x( 'Specify the background color tone to match the related color set with the overlapped header (if active), arrows and navigation buttons.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(		
																					_x("Dark",'Admin Panel','naturalife') => "dark",
																					_x("Light",'Admin Panel','naturalife') => "light",
																				),
														'group'       => _x( 'Background Options', 'Admin Panel','naturalife' ),
														'save_always' => true
													),

													
													array(
														'param_name'  => 'bg_color',
														'heading'     => _x( 'Background Color', 'Admin Panel','naturalife' ),
														'description' => '',
														'type'        => 'colorpicker',
														'group'       => _x('Background Options', 'Admin Panel','naturalife'),
														'save_always' => true
													),


													array(
														'param_name'  => 'bg_image',
														'heading'     => _x('Background Image', 'Admin Panel','naturalife' ),
														'description' => _x('Select an image for the slider background', 'Admin Panel','naturalife' ),
														'type'        => 'attach_image',
														'group'       => _x('Background Options', 'Admin Panel','naturalife'),
														'save_always' => true
													),

													array(
														'param_name'  => 'bg_image_repeat',
														'heading'     => _x( 'Background Repeat', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select and set repeat mode direction for the background image.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(		
																			_x("No Repeat",'Admin Panel','naturalife') => "no-repeat",
																			_x("Tile",'Admin Panel','naturalife') => "repeat",
																			_x("Tile Horizontally",'Admin Panel','naturalife') => "repeat-x",
																			_x("Tile Vertically",'Admin Panel','naturalife') => "repeat-y"
																		),
														'group'       => _x( 'Background Options', 'Admin Panel','naturalife' ),
														'save_always' => true
													),

													array(
														'param_name'  => 'bg_size',
														'heading'     => _x( 'Background Image Size', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select and set size / coverage behaviour for the background image.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown', 
														"value"       => array(		
																			_x("Cover",'Admin Panel','naturalife') => "cover",
																			_x("Auto",'Admin Panel','naturalife') => "auto auto",						
																			_x("Contain",'Admin Panel','naturalife') => "contain",
																			_x("100%",'Admin Panel','naturalife') => "100% auto",
																			_x("50%",'Admin Panel','naturalife') => "50% auto",
																			_x("25%",'Admin Panel','naturalife') => "25% auto",
																		),	
														'group'       => _x( 'Background Options', 'Admin Panel','naturalife' ),
														'save_always' => true
													),

													array(
														'param_name'  => 'bg_position',
														'heading'     => _x( 'Background Position', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select a positon for the background image.', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown', 
														"value"       => array(		
																			_x("Right Top",'Admin Panel','naturalife') => "right top",
																			_x("Right Center",'Admin Panel','naturalife') => "right center",
																			_x("Right Bottom",'Admin Panel','naturalife') => "right bottom",
																			_x("Left Top",'Admin Panel','naturalife') => "left top",
																			_x("Left Center",'Admin Panel','naturalife') => "left center",
																			_x("Left Bottom",'Admin Panel','naturalife') => "left bottom",
																			_x("Center Top",'Admin Panel','naturalife') => "center top",
																			_x("Center Center",'Admin Panel','naturalife') => "center center",
																			_x("Center Bottom",'Admin Panel','naturalife') => "center bottom",
																		),	
														'group'       => _x( 'Background Options', 'Admin Panel','naturalife' ),
														'save_always' => true
													),



													/* button */

													array(
														'param_name'  => 'button_text',
														'heading'     => _x('Button Text', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => 'Buttons'
													),

													array(
														'param_name'  => 'button_size',
														'heading'     => _x( 'Button Size', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Small", 'Admin Panel','naturalife') => "small",
																			_x("Medium", 'Admin Panel','naturalife') => "medium",
																			_x("Big", 'Admin Panel','naturalife') => "big",
																		),
														'group'       => 'Buttons'
													),

													array(
														'param_name'  => 'button_style',
														'heading'     => _x( 'Button Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																				_x("Flat Text", 'Admin Panel','naturalife') => "text",
																				_x("Style 1", 'Admin Panel','naturalife')   => "style-1",
																				_x("Style 2", 'Admin Panel','naturalife')   => "style-2",
																				_x("Style 3", 'Admin Panel','naturalife')   => "style-3", 
																				_x("Black", 'Admin Panel','naturalife')     => "black", 
																				_x("White", 'Admin Panel','naturalife')     => "white"
																			),
														'group'       => 'Buttons',
														'save_always' => true,
													),
														
													array(
														'param_name'  => 'button_icon',
														'heading'     => _x('Icon', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => 'Buttons'
													),

													array(
														'param_name'  => 'button_link',
														'heading'     => _x('Link', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => 'Buttons'
													),

													array(
														'param_name'  => 'button_arrow',
														'type'        => 'checkbox',
														'group'       => 'Buttons',
														'value'       => array(
																				_x("Button Arrow", 'Admin Panel','naturalife') => "true"
																			 )
													),

													array(
														'param_name'  => 'button_rounded',
														'type'        => 'checkbox',
														'group'       => 'Buttons',
														'value'       => array(
																				_x("Rounded Button", 'Admin Panel','naturalife') => "true"
																			 )
													),

													array(
														'param_name'  => 'button_link_target',
														'heading'     => _x('Link Target', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																			_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																		),
														'group'       => 'Buttons',

													),										

													array(
														'param_name'  => 'button_href_title',
														'heading'     => _x('Link Title', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														'type'        => 'textfield',
														'group'       => 'Buttons'
													),		



													/* button 2 */

													array(
														'param_name'  => 'button2_text',
														'heading'     => _x('Button 2 Text', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => 'Buttons' 
													),

													array(
														'param_name'  => 'button2_size',
														'heading'     => _x( 'Button 2 Size', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Small", 'Admin Panel','naturalife') => "small",
																			_x("Medium", 'Admin Panel','naturalife') => "medium",
																			_x("Big", 'Admin Panel','naturalife') => "big",
																		),
														'group'       => 'Buttons' 
													),

													array(
														'param_name'  => 'button2_style',
														'heading'     => _x( 'Button 2 Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																				_x("Flat Text", 'Admin Panel','naturalife') => "text",
																				_x("Style 1", 'Admin Panel','naturalife')   => "style-1",
																				_x("Style 2", 'Admin Panel','naturalife')   => "style-2",
																				_x("Style 3", 'Admin Panel','naturalife')   => "style-3", 
																				_x("Black", 'Admin Panel','naturalife')     => "black", 
																				_x("White", 'Admin Panel','naturalife')     => "white"
																		),
														'group'       => 'Buttons',
														'save_always' => true, 
													),

													array(
														'param_name'  => 'button2_arrow',
														'type'        => 'checkbox',
														'group'       => 'Buttons',
														'value'       => array(
																				_x("Button Arrow", 'Admin Panel','naturalife') => "true"
																			 )
													),

													array(
														'param_name'  => 'button2_rounded',
														'type'        => 'checkbox',
														'group'       => 'Buttons',
														'value'       => array(
																				_x("Rounded Button", 'Admin Panel','naturalife') => "true"
																			 )
													),

													array(
														'param_name'  => 'button2_icon',
														'heading'     => _x('Button 2 Icon', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => 'Buttons' 
													),

													array(
														'param_name'  => 'button2_link',
														'heading'     => _x('Button 2 Link', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => 'Buttons' 
													),

													array(
														'param_name'  => 'button2_link_target',
														'heading'     => _x('Button 2 Link Target', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																			_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																		),
														'group'       => 'Buttons' 
													),										

													array(
														'param_name'  => 'button2_href_title',
														'heading'     => _x('Button 2 Link Title', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														'type'        => 'textfield',
														'group'       => 'Buttons' 
													),									  

										),				
					),


					/*
						Video Embed
					*/			
					"rt_embed" => array(

						"name"=> _x('Video Embed','Admin Panel','naturalife'),
						"description"=> _x('This shortcodes embeds a video from YouTube and Vimeo in a responsive layout. Just the put the video url between the shorcode.','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_embed',
						"open" => true,
						"close" => false,
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),
						"parameters" => array(
				
										),				
					),

			/*
				Contents
			*/
			"group-4" => array(
				"group_name"=> _x('Contents','Admin Panel','naturalife'),
				"group_icon"=> "rt-panel-icon-code-1",
			),

					/*
						Icon Lists
					*/						

					"rt_icon_list" => array(

						"name"=> _x('Icon Lists','Admin Panel','naturalife'),
						"description"=> _x('Icon list holder','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_icon_list',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'rt_icon_list_line',
										"text" => ''
									),
						"parameters" => array(


												array(
													'param_name'  => 'list_style',
													'heading'     => _x('List Style', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													'description' => _x('Select a list style', 'Admin Panel','naturalife' ),
													"value"       => array(
																		_x("Default Icons", 'Admin Panel','naturalife') => "style-1", 
																		_x("Light Icons", 'Admin Panel','naturalife') => "style-2", 
																		_x("Boxed Icons", 'Admin Panel','naturalife') => "style-3", 
																		_x("Big Icons", 'Admin Panel','naturalife') => "style-4", 
																	),
													'save_always' => true
												), 

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),


										),
					),

					/*
						Icon list line
					*/			
					"rt_icon_list_line" => array(

						"name"=> _x('List Item','Admin Panel','naturalife'),
						"description"=> _x('Adds a new item to the icon list','Admin Panel','naturalife'),
						"subline" => true,
						"id"=> 'rt_icon_list_line',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Content'
									),
						"parameters" => array(
									
												array(
													'param_name'  => 'icon_name',
													'heading'     => _x('Icon', 'Admin Panel','naturalife' ),
													'description' => _x('Click inside the field to select an icon or type the icon name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'class'       => 'icon_selector',
												),
					
												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

										),				
					),


					/*
						Bullet Lists
					*/						

					"rt_bullet_list" => array(

						"name"=> _x('Bullet Lists','Admin Panel','naturalife'),
						"description"=> _x('Holder shortcode for bullet lists','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_bullet_list',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'rt_bullet_list',
										"text" =>"",
									),
						"parameters" => array(

												array(
													'param_name'  => 'style',
													'heading'     => _x('List Style', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													'description' => _x('Select a list style', 'Admin Panel','naturalife' ),
													"value"       => array(
																				_x("Icons with primary color background", 'Admin Panel','naturalife') => "style-1",
																				_x("Text color Icons", 'Admin Panel','naturalife') => "style-2",
																				_x("Primary color Icons", 'Admin Panel','naturalife') => "style-3",
																			),
												), 

												array(
													'param_name'  => 'icon',
													'heading'     => _x('Icon', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													'description' => _x('Select an icon for the list', 'Admin Panel','naturalife' ),
													"value"       => array(
																				_x("Arrow", 'Admin Panel','naturalife') => "arrow",
																				_x("Arrow 2", 'Admin Panel','naturalife') => "arrow-2",
																				_x("Star", 'Admin Panel','naturalife') => "star",
																				_x("Check", 'Admin Panel','naturalife') => "check",
																			),
												), 

												array(
													'param_name'  => 'columns',
													'heading'     => _x('Columns Size', 'Admin Panel','naturalife' ),
													'description' => _x('Splits into columns. ', 'Admin Panel','naturalife' ),
													"value"       => array(
																				_x("1 Column", 'Admin Panel','naturalife') => "1",
																				_x("2 Columns", 'Admin Panel','naturalife') => "2",
																				_x("3 Columns", 'Admin Panel','naturalife') => "3",
																				_x("4 Columns", 'Admin Panel','naturalife') => "4",
																				_x("5 Columns", 'Admin Panel','naturalife') => "5",
																				_x("6 Columns", 'Admin Panel','naturalife') => "6",
																			),													
													'type'        => 'textfield'
												),

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

										),
					),

					/*
						Tabs
					*/				

					"rt_tabs" => array(

						"name"=> _x('Tabs','Admin Panel','naturalife'),
						"description"=> _x('Holder shortcode for tabs.','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_tabs',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'rt_tab',
										"text" => ''
									),
						"parameters" => array(

													array(
														'param_name'  => 'tabs_style',
														'heading'     => _x('Tab Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																				_x("Horizontal Tabs", 'Admin Panel','naturalife') => "style-1",
																				_x("Horizontal Big Tabs", 'Admin Panel','naturalife') => "style-4",
																				_x("Left Vertical Tabs", 'Admin Panel','naturalife') => "style-2", 
																				_x("Right Vertical Tabs", 'Admin Panel','naturalife') => "style-3", 
																		),
														'group'       => 'Link'
													),										

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),

										),
					),

					/*
						tab content
					*/			
					"rt_tab" => array(

						"name"=> _x('Tab','Admin Panel','naturalife'),
						"description"=> _x('The tab content.','Admin Panel','naturalife'),
						"subline" => true,
						"id"=> 'rt_tab',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Content'
									),
						"parameters" => array(

													array(
														'param_name'  => 'title',
														'heading'     => _x('Title', 'Admin Panel','naturalife' ),
														'description' => _x('Tab Title', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'holder'      => 'strong',
														'value'       => _x( 'Tab Title', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'icon_name',
														'heading'     => _x('Tab Icon', 'Admin Panel','naturalife' ),
														'description' => _x('Click inside the field to select an icon or type the icon name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'class'       => 'icon_selector',
													),

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),

										),				
					),


					/*
						Accordions
					*/						

					"rt_accordion" => array(

						"name"=> _x('Accordion','Admin Panel','naturalife'),
						"description"=> _x('Accordion content holder','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_accordion',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'rt_accordion_content',
										"text" => ''
									),
						"parameters" => array(

												array(
													'param_name'  => 'style',
													'heading'     => _x('Accordion Style', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													'description' => _x('Select an accordion content style', 'Admin Panel','naturalife' ),
													"value"       => array(
																		_x("Numbered", 'Admin Panel','naturalife') => "numbered",
																		_x("With Icons", 'Admin Panel','naturalife') => "icons", 
																		_x("Captions Only", 'Admin Panel','naturalife') => "only_captions"
																	),
												),										

												array(
													'param_name'  => 'first_one_open',
													'heading'     => _x('First content', 'Admin Panel','naturalife' ),
													'description' => _x('Keep the first section opened when the page loaded.', 'Admin Panel','naturalife' ),
													'type'        => 'checkbox',
													"value"       => array(
																		_x("First one open", 'Admin Panel','naturalife') => "true",
																	),
												),

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),


										),
					),


					/*
						Accordion content
					*/			
					"rt_accordion_content" => array(
						"name"=> _x('Pane','Admin Panel','naturalife'),
						"description"=> _x('Adds a new section to a accordion content.','Admin Panel','naturalife'),
						"subline" => true,
						"id"=> 'rt_accordion_content',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Content'
									),
						"parameters" => array(


													array(
														'param_name'  => 'title',
														'heading'     => _x('Title', 'Admin Panel','naturalife' ),
														'description' => _x('Accordion Title', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => _x( 'Accordion Title', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'icon_name',
														'heading'     => _x('Accordion Icon', 'Admin Panel','naturalife' ),
														'description' => _x('Click inside the field to select an icon or type the icon name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'class'       => 'icon_selector',
													),

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),

										),				
					),


					/*
						Pricing Tables
					*/						

					"rt_pricing_table" => array(

						"name"=> _x('Pricing Table','Admin Panel','naturalife'),
						"description"=> _x('Holder shortcode for pricing table.','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_pricing_table',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'rt_table_column',
										"text" => ''
									),
						"parameters" => array(

											array(
												"param_name" => 'style',
												"description"=> 'Style',
												"default_value" => 'service',
												"value" => array(
																		_x("Service", 'Admin Panel','naturalife') => "service",
																		_x("Compare", 'Admin Panel','naturalife') => "compare", 
																	),										
											),

											array(
												'param_name'  => 'id',
												'heading'     => _x('ID', 'Admin Panel','naturalife' ),
												'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
												'type'        => 'textfield',
												'value'       => ''
											),

											array(
												'param_name'  => 'class',
												'heading'     => _x('Class', 'Admin Panel','naturalife' ),
												'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
												'type'        => 'textfield'
											),

										),
					),


					/*
						Pricing Table Columns
					*/			
					"rt_table_column" => array(
						"name"=> _x('Table Column','Admin Panel','naturalife'),
						"description"=> _x('Adds a column to the table. Use HTML ul lists to create cells.','Admin Panel','naturalife'),
						"subline" => true,
						"id"=> 'rt_table_column',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => ' <code>'.htmlentities("
										<ul>
											<li>....</li>
											<li>....</li>
											<li>....</li>
										</ul>
										") .'</code>'
									),

						"parameters" => array(

											array(
												"param_name" => 'caption',
												"description"=> 'Caption',
												"default_value" => '',
											),

											array(
												"param_name" => 'price',
												"description"=> 'Price',
												"default_value" => '',
											),

											array(
												"param_name" => 'info',
												"description"=> 'Info text',
												"default_value" => '',
											),

											array(
												"param_name" => 'style',
												"description"=> _x('Icon name.','Admin Panel','naturalife'),
												"default_value" => '',
												"value" => array(
																		""   => "Default",
																		"highlight"  => "Highlighted column",
																	),		


											),

											array(
												'param_name'  => 'id',
												'heading'     => _x('ID', 'Admin Panel','naturalife' ),
												'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
												'type'        => 'textfield',
												'value'       => ''
											),

											array(
												'param_name'  => 'class',
												'heading'     => _x('Class', 'Admin Panel','naturalife' ),
												'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
												'type'        => 'textfield'
											),

										),				
					),


					/*
						Content Box With Featured Image
					*/			

					"content_image_box" => array(
						"name"=> _x('Content Box With Image','Admin Panel','naturalife'),
						"description"=> _x('Creates a styled content box with an image','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'content_image_box',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur euismod enim a metus adipiscing aliquam. Vestibulum in vestibulum lorem.</p>'
									),

						"parameters" => array(


												/* Image */
												array(
													'param_name'  => 'img',
													'heading'     => _x('Image', 'Admin Panel', 'naturalife' ),
													'description' => _x('Image ID', 'Admin Panel', 'naturalife' ),
													'type'        => 'attach_image',
													'holder'      => 'img',
													'value'       => '',							
												),
					 

												array(
													'param_name'  => 'heading',
													'heading'     => _x( 'Heading', 'Admin Panel', 'naturalife' ),
													'description' => '',
													'type'        => 'textfield',
													'holder'      => 'div',
													'value'       => _x( 'Box Heading', 'Admin Panel', 'naturalife' ),
													'holder'      => 'h4',
													'save_always' => true
												), 

												array(
													'param_name'  => 'heading_size',
													'heading'     => _x( 'Heading Size', 'Admin Panel', 'naturalife' ),
													'description' => _x( 'Select the size of the heading tag', 'Admin Panel', 'naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		"H1" => "h1", 
																		"H2" => "h2", 
																		"H3" => "h3", 
																		"H4" => "h4", 
																		"H5" => "h5", 
																		"H6" => "h6", 
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'style',
													'heading'     => _x( 'Box Style', 'Admin Panel', 'naturalife' ),
													'description' => _x( 'Select a box style', 'Admin Panel', 'naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Style One - Default layout", 'Admin Panel','naturalife') => "style-1",
																		_x("Style Two - Use the image as the background", 'Admin Panel','naturalife') => "style-2", 												),
													'group'       => 'Box Style',
													'save_always' => true
												),

												array(
													'param_name'  => 'box_height',
													'heading'     => _x( 'Box Height', 'Admin Panel', 'naturalife' ),
													'type'        => 'rt_number',
													'group'       => 'Box Style',
													'save_always' => true											
												),

												array(
													'param_name'  => 'heading_bottom_margin',
													'heading'     => _x( 'Heading Bottom Margin (px)', 'Admin Panel', 'naturalife' ),
													'group'       => 'Box Style',
													'type'        => 'rt_number',
													"dependency"  => array(
																				"element" => "style",
																				"value" => array("style-1")
																			),	
												),

												array(
													'param_name'  => 'text_align',
													'heading'     => _x( 'Text Align', 'Admin Panel', 'naturalife' ),
													'type'        => 'dropdown',
													'group'       => 'Box Style',
													"value"       => array(
																		_x("Left", 'Admin Panel','naturalife') => "left",
																		_x("Right", 'Admin Panel','naturalife') => "right", 
																		_x("Center", 'Admin Panel','naturalife') => "center", 
																	),
													"dependency"  => array(
																	"element" => "style",
																	"value" => array("style-1","style-2")
													),	
													'save_always' => true							
												),

												array(
													'param_name'  => 'text_width',
													'heading'     => _x( 'Text Width (percent %)', 'Admin Panel', 'naturalife' ),
													'group'       => 'Box Style',
													"dependency"  => array(
																	"element" => "style",
																	"value" => array("style-1")
													),									
													'type'        => 'rt_number'
												),

												array(
													'param_name'  => 'img_pos',
													'heading'     => _x( 'Image Position', 'Admin Panel', 'naturalife' ),
													'type'        => 'dropdown',
													'group'       => 'Box Style',
													"value"       => array(
																		_x("Before the text", 'Admin Panel','naturalife') => "before",
																		_x("After the text", 'Admin Panel','naturalife') => "after", 
																	),
													"dependency"  => array(
																	"element" => "style",
																	"value" => array("style-1")
													),	
													'save_always' => true							
												),

												array(
													'param_name'  => 'img_align',
													'heading'     => _x( 'Image Align', 'Admin Panel', 'naturalife' ),
													'type'        => 'dropdown',
													'group'       => 'Box Style',
													"value"       => array(
																		_x("Left", 'Admin Panel','naturalife') => "left",
																		_x("Right", 'Admin Panel','naturalife') => "right", 
																		_x("Center", 'Admin Panel','naturalife') => "center", 
																	),
													"dependency"  => array(
																	"element" => "style",
																	"value" => array("style-1")
													),	
													'save_always' => true							
												),

												array(
													'param_name'  => 'img_valign',
													'heading'     => _x( 'Image Vertical Align', 'Admin Panel', 'naturalife' ),
													'type'        => 'dropdown',
													'group'       => 'Box Style',
													"value"       => array(
																		_x("Top", 'Admin Panel','naturalife') => "top",
																		_x("Middle", 'Admin Panel','naturalife') => "middle", 
																		_x("Bottom", 'Admin Panel','naturalife') => "bottom", 
																	),
													"dependency"  => array(
																	"element" => "style",
																	"value" => array("style-1")
													),	
													'save_always' => true							
												),

												array(
													'type' => 'checkbox',
													'heading' => '',
													'param_name' => 'retina_image',
													"value"       => array(
																		_x("Retina Image?", 'Admin Panel','naturalife') => "true",
																	),
													'description' => _x("If the option checked, the selected image will be displayed 50% smaller than it's original size. Upload 2x bigger images to get a clear render on retina displays.", 'Admin Panel','naturalife'),
													'save_always' => true								
												),


												array(
													'param_name'  => 'img_bottom_margin',
													'heading'     => _x( 'Image Bottom Margin (px)', 'Admin Panel', 'naturalife' ),
													'group'       => 'Box Style',
													'type'        => 'rt_number',
													"dependency"  => array(
																				"element" => "style",
																				"value" => array("style-1")
																			),	
												),

												array(
													'param_name'  => 'img_top_margin',
													'heading'     => _x( 'Image Top Margin (px)', 'Admin Panel', 'naturalife' ),
													'group'       => 'Box Style',
													'type'        => 'rt_number',
													"dependency"  => array(
																				"element" => "style",
																				"value" => array("style-1")
																			),	
												),

												array(
													'param_name'  => 'img_left_margin',
													'heading'     => _x( 'Image Left Margin (px)', 'Admin Panel', 'naturalife' ),
													'group'       => 'Box Style',
													'type'        => 'rt_number',
													"dependency"  => array(
																				"element" => "style",
																				"value" => array("style-1")
																			),	
												),

												array(
													'param_name'  => 'img_right_margin',
													'heading'     => _x( 'Image Right Margin (px)', 'Admin Panel', 'naturalife' ),
													'group'       => 'Box Style',
													'type'        => 'rt_number',
													"dependency"  => array(
																				"element" => "style",
																				"value" => array("style-1")
																			),								
												),

												array(
													'param_name'  => 'bg_image',
													'heading'     => _x( 'Background Image', 'Admin Panel','naturalife' ),
													'description' => _x( 'Select a background image', 'Admin Panel','naturalife' ),
													'type'        => 'attach_image',	
													'group'       => 'Box Style',
													'value'	     => '',
													"dependency"  => array(
																				"element" => "style",
																				"value" => array("style-1")
																			),											
												),

												array(
													'param_name'  => 'bg_color',
													'heading'     => _x( 'Background Color', 'Admin Panel','naturalife' ),
													'description' => _x( 'Select a background color', 'Admin Panel','naturalife' ),
													'type'        => 'colorpicker',
													'group'       => 'Box Style',
													'save_always' => true,
													"dependency"  => array(
																				"element" => "style",
																				"value" => array("style-1")
																			),			
												),

												array(
													'param_name'  => 'text_color',
													'heading'     => _x( 'Text Color', 'Admin Panel', 'naturalife' ),
													'type'        => 'colorpicker',
													'group'       => 'Box Style'									
												),

												array(
													'param_name'  => 'text_bg_color',
													'heading'     => _x( 'Text Background Color', 'Admin Panel', 'naturalife' ),
													'type'        => 'colorpicker',
													'group'       => 'Box Style'										
												),

												array(
													'param_name'  => 'mobile_layout',
													'heading'     => _x('Mobile Layout', 'Admin Panel', 'naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Enabled", 'Admin Panel','naturalife') => "true",
																		_x("Disabled", 'Admin Panel','naturalife') => "false", 
																	),
													'group'       => 'Box Style'	
												),			

												array(
													'param_name'  => 'link',
													'heading'     => _x('Link', 'Admin Panel', 'naturalife' ),
													'type'        => 'textfield',
													'value'       => '',
													'group'       => 'Link'
												),

												array(
													'param_name'  => 'link_text',
													'heading'     => _x('Link Text', 'Admin Panel', 'naturalife' ),
													'type'        => 'textfield',
													'value'       => '',
													'group'       => 'Link'
												),

												array(
													'param_name'  => 'link_target',
													'heading'     => _x('Link Target', 'Admin Panel', 'naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																		_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																	),
													'group'       => 'Link'
												),										


												array(
													'param_name'  => 'button_style',
													'heading'     => _x( 'Button Style', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Flat Text", 'Admin Panel','naturalife') => "text",
																		_x("Style 1", 'Admin Panel','naturalife')   => "style-1",
																		_x("Style 2", 'Admin Panel','naturalife')   => "style-2",
																		_x("Style 3", 'Admin Panel','naturalife')   => "style-3", 
																		_x("Black", 'Admin Panel','naturalife')     => "black", 
																		_x("White", 'Admin Panel','naturalife')     => "white"
																	),
													'save_always' => true,
													'group'       => 'Link',
												),

												array(
													'param_name'  => 'button_size',
													'heading'     => _x( 'Button Size', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Small", 'Admin Panel','naturalife') => "small",
																		_x("Medium", 'Admin Panel','naturalife') => "medium",
																		_x("Big", 'Admin Panel','naturalife') => "big",
																		_x("Hero", 'Admin Panel','naturalife') => "hero",
																	),
													'save_always' => true,
													'group'       => 'Link',
												),
												
												array(
													'param_name'  => 'padding_top',
													'heading'     => _x( 'Padding Top', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set padding top value (px,%) default: 0px', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),							
												),

												array(
													'param_name'  => 'padding_bottom',
													'heading'     => _x( 'Padding Bottom', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set padding bottom value (px,%) default: 0px', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),							
												),

												array(
													'param_name'  => 'padding_left',
													'heading'     => _x( 'Padding Left', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set padding left value (px,%) default: 0px', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),							
												),

												array(
													'param_name'  => 'padding_right',
													'heading'     => _x( 'Padding Right', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set padding right value (px,%) default: 0px', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),							
												),	

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel', 'naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel', 'naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel', 'naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel', 'naturalife' ),
													'type'        => 'textfield'
												),
							
		 
										),				
					),

					/*
						Timelines
					*/			

					"rt_timeline" => array(

						"name"=> _x('Timeline Events','Admin Panel','naturalife'),
						"description"=> _x('Timeline holder','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_timeline',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'rt_tl_event',
										"text" => ''
									),
						"parameters" => array(

												array(
													'param_name'  => 'style',
													'heading'     => __( 'Style', 'naturalife' ),
													'description' => __( 'Select a style', 'naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		__("Chained Timeline", "naturalife") => "style-1",
																		__("List", "naturalife") => "style-2",
																	),
													'save_always' => true
												),


												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),
		 
		 
										),
					),

					/*
						Timeline Event
					*/			


					"rt_tl_event" => array(

						"name"=> _x('Event','Admin Panel','naturalife'),
						"description"=> _x('Adds a new event to the timeline','Admin Panel','naturalife'),
						"subline" => true,
						"id"=> 'rt_tl_event',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Content'
									),
						"parameters" => array(
													
													array(
														'param_name'  => 'title',
														'heading'     => _x( 'Title', 'Admin Panel','naturalife' ),
														'description' => '',
														'type'        => 'textfield',
														'holder'      => 'h4',
													),

													array(
														'param_name'  => 'day',
														'heading'     => _x('Event Day', 'Admin Panel','naturalife' ),
														'description' => _x('Day', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														"holder"      => "span",
														'class'       => 'icon_selector',
													),

													array(
														'param_name'  => 'month',
														'heading'     => _x('Event Month', 'Admin Panel','naturalife' ),
														'description' => _x('Month', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														"holder"      => "span",
														'class'       => 'icon_selector',
													),

													array(
														'param_name'  => 'year',
														'heading'     => _x('Event Year', 'Admin Panel','naturalife' ),
														'description' => _x('Year', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														"holder"      => "span",
														'class'       => 'icon_selector',
													),

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),
										),				
					),

			/*
				Elements
			*/
			"group-5" => array(
				"group_name"=> _x('Elements','Admin Panel','naturalife'),
				"group_icon"=> "rt-panel-icon-code-1",
			),


					/*
						Contact Form
					*/			
					"contact_form" => array(
						"name"=> _x('Contact Form','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'contact_form',
						"description"=> _x('Calls the contact form','Admin Panel','naturalife'),
						"open" => true,
						"close" => true,	
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Contact form description text'
									),					
						"parameters" => array(

											array(
												'param_name'  => 'email',
												'heading'     => _x('Email', 'Admin Panel','naturalife' ),
												'description' => _x('The contact form will be submited to this email.', 'Admin Panel','naturalife' ),
												'type'        => 'textfield',
												'value' => $current_user->user_email,
												'save_always' => true
											),

											array(
												'param_name'  => 'security',
												'heading' => _x( 'Security Question', 'Admin Panel','naturalife' ),
												'type'        => 'checkbox',
												"value"       => array(
																	_x("Enable the security question to prevent spam messages.", 'Admin Panel','naturalife') => "true",
																),
											),

											array(
												'param_name'  => 'confirmation',
												'heading' => _x( 'Confirmation', 'Admin Panel','naturalife' ),
												'type'        => 'checkbox',
												"value"       => array(
																	_x("Enable the confirmation checkbox for GDPR.", 'Admin Panel','naturalife') => "true",
																),
											),

											array(
												'param_name'  => 'id',
												'heading'     => _x('ID', 'Admin Panel','naturalife' ),
												'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
												'type'        => 'textfield',
												'value'       => ''
											),

											array(
												'param_name'  => 'class',
												'heading'     => _x('Class', 'Admin Panel','naturalife' ),
												'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
												'type'        => 'textfield'
											)

										),
					),


					/*
						Horizontal Line
					*/			
					"rt_divider" => array(

						"name"=> _x('Horizontal Line','Admin Panel','naturalife'),
						"description"=> _x('Horizontal line shortcode','Admin Panel','naturalife'),
						"id"=> 'rt_divider',
						"subline" => false,
						"open" => true,
						"close" => true, 					
						"parameters" => array(

													array(
														'param_name'  => 'style',
														'heading'     => _x( 'Style', 'Admin Panel','naturalife' ),
														'description' => _x( 'Select a style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
													 						_x("Style One - Classical Line", "naturalife") => "style-1", 
																			_x("Style Two - Short Horizontal Line", "naturalife") => "style-2",  
																			_x("Style Two - Short Vertical Line", "naturalife") => "style-3"
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'color_type',
														'heading'     => _x( 'Color', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default Border Color", 'Admin Panel','naturalife') => "", 						
																			_x("Primary Color", 'Admin Panel','naturalife') => "primary", 
																			_x("Custom Color", 'Admin Panel','naturalife') => "custom", 
																		),
													),

													array(
														'param_name'  => 'color',
														'heading'     => _x( 'Custom Color', 'Admin Panel','naturalife' ), 
														'type'        => 'colorpicker',
														"dependency"  => array(
																					"element" => "color_type",
																					"value" => array("custom")
																				),	
													),

													array(
														'param_name'  => 'width',
														'heading'     => _x( 'Custom Width', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set a custom width value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number', 
													),

													array(
														'param_name'  => 'height',
														'heading'     => _x( 'Custom Height', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set a custom height value (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number'
													),

													array(
														'param_name'  => 'margins',
														'heading'     => _x('Margins', 'Admin Panel','naturalife' ),
														'type'        => 'rt_styling',  
														'default_value' => "20px,20px,auto,auto",
 														'description' => _x( 'Margin values separated with comma (Top, Bottom, Left, Right)', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'width',
														'heading'     => _x( 'Custom Width', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set a custom width value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number', 
													),

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),
											),
					),

					/*
						Pullquote
					*/			
					"pullquote" => array(

						"name"=> _x('Pullquote','Admin Panel','naturalife'),
						"description"=> _x('Pullquote shortcode','Admin Panel','naturalife'),
						"subline" => false,
						"open" => true,
						"id"=> 'pullquote',
						"close" => true, 					
						"parameters" => array(
											array(
												"param_name" => 'align',
												"description"=> _x('Alignment','Admin Panel','naturalife'),
												"default_value" => 'left',
												"value" => array(
																		_x('Left ','Admin Panel','naturalife') => "left",
																		_x('Right','Admin Panel','naturalife') => "Right",
																	),
											),
										),
					),

					/*
						Pullquote
					*/			
					"rt_quote" => array(

						"name"=> _x('Qoute','Admin Panel','naturalife'),
						"description"=> _x('Quote shortcode','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_quote',
						"open" => true,
						"close" => true, 					
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Content Text'
									),								
						"parameters" => array(


												array(
													'param_name'  => 'name',
													'heading'     => _x('Author Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'position',
													'heading'     => _x('Author Title', 'Admin Panel','naturalife' ), 
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'style',
													'heading'     => _x('Style', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													"value"       => array(
																		__("Style 1", 'Admin Panel', "naturalife") => "style-1",
																		__("Style 2", 'Admin Panel', "naturalife") ." - ". __("No borders", 'Admin Panel', "naturalife") => "style-2",													
																	),
												),

												array(
													'param_name'  => 'link',
													'heading'     => _x('Link', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'link_title',
													'heading'     => _x('Link Title', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),		

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

										),
					),

					/*
						Google maps
					*/						

					"google_maps" => array(

						"name"=> _x('Google Maps','Admin Panel','naturalife'),
						"description"=> _x('Holder shortcode for google maps.','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'google_maps',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => 'location',
										"text" => ''
									),
						"parameters" => array(

											array(
												'param_name'  => 'map_id',
												'heading'     => _x('ID', 'Admin Panel','naturalife' ),
												'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
												'type'        => 'textfield',
												'value'       => ''
											),

											array(
												'param_name'  => 'height',
												'heading'     => _x('Height', 'Admin Panel','naturalife' ),
												'description' => _x('Map Height', 'Admin Panel','naturalife' ),
												'type'        => 'rt_number'
											),

											array(
												'param_name'  => 'zoom',
												'heading'     => _x('Zoom Level', 'Admin Panel','naturalife' ),
												'type'        => 'rt_number',
												'description' => _x('Zoom level. Works only with single map location. Enter a zoom level between 1 and 19','Admin Panel','naturalife'),
												'value'       => 10,
												'save_always' => true
											),

											array(
												'param_name'  => 'bwcolor',
												'heading'     => _x('Black & White Map', 'Admin Panel','naturalife' ),
												'type'        => 'checkbox', 
												'save_always' => true,
												'value' => array( _x( 'Make the map only black and white', 'Admin Panel','naturalife' ) => 'yes' ),
											),


											array(
												'param_name'  => 'class',
												'heading'     => _x('Class', 'Admin Panel','naturalife' ),
												'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
												'type'        => 'textfield',
											)						

										),
					),

					/*
						Map Locations
					*/			
					"location" => array(

						"name"=> _x('Map Location','Admin Panel','naturalife'),
						"description"=> _x('Adds locations to the map.','Admin Panel','naturalife'),
						"subline" => true,
						"id"=> 'location',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Location description'
									),
						"parameters" => array(
				
											array(
												'param_name'  => 'title',
												'heading'     => _x('Location Title', 'Admin Panel','naturalife' ),
												'type'        => 'textfield',
												'holder'      => 'span',
											),
 
											array(
												'param_name'  => 'lat',
												'heading'     => _x('Latitude', 'Admin Panel','naturalife' ),
												'type'        => 'rt_number',
												'class'       => 'geo_selection',
											),

											array(
												'param_name'  => 'lon',
												'heading'     => _x('Longitude', 'Admin Panel','naturalife' ),
												'type'        => 'rt_number',
												'class'       => 'geo_selection',
											),

										),				
					),

					/*
						Social Media Icons
					*/						
					"rt_social_media_icons" => array(

						"name"=> _x('Social Media Icons','Admin Panel','naturalife'),
						"description"=> _x('Displays the social media icons list that created by using <a href="?page=rt_social_options">Social Media Options</a> of the theme.','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_social_media_icons',
						"open" => true,
						"close" => false,
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									)
					),

					/*
						Social Share Icons
					*/						
					"rt_social_media_share" => array(

						"name"=> _x('Social Media Share','Admin Panel','naturalife'),
						"description"=> _x('Display social media share links with icons','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rtframework_social_media_share',
						"open" => true,
						"close" => false,
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									)
					),



					/*
						Icons
					*/						

					"rt_icon" => array(

						"name"=> _x('Icons','Admin Panel','naturalife'),
						"description"=> _x('Displays an icon. Click the "<span class="rt-panel-icon-rocket"></span>Icons" link top of the page to find an icon name. ','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_icon',
						"open" => true,
						"close" => false,
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),
						"parameters" => array(


												array(
													'param_name'  => 'icon_name',
													'heading'     => __('Icon Name', 'naturalife' ),
													'description' => __('Icon name', 'naturalife' ),
													'type'        => 'textfield',
													'class'       => 'icon_selector'
												),


												array(
													'param_name'  => 'align',
													'heading'     => __( 'Text Align', 'naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		__("Default", "naturalife") => "",
																		__("Left", "naturalife") => "left",
																		__("Right", "naturalife") => "right",
																		__("Center", "naturalife") => "center",													
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'color_type',
													'heading'     => _x( 'Icon Color', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Text Color", 'Admin Panel','naturalife') => "text", 
																		_x("Primary Color", 'Admin Panel','naturalife') => "primary", 
																		_x("Custom Color", 'Admin Panel','naturalife') => "custom", 
																	),
													'save_always' => true
												),

												array(
													'param_name'  => 'color',
													'heading'     => _x('Custom Icon Color', 'Admin Panel','naturalife' ),
													'type'        => 'colorpicker',
													"dependency"  => array(
																	"element" => "color_type",
																	"value" => array("custom")
													),											
												),

												array(
													'param_name'  => 'background_color',
													'heading'     => _x('Custom Background Color', 'Admin Panel','naturalife' ),
													'type'        => 'colorpicker',
													"dependency"  => array(
																	"element" => "color_type",
																	"value" => array("custom")
													),											
												),

												array(
													'param_name'  => 'font_size',
													'heading'     => _x('Custom Icon Size (px)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number'								
												),

												array(
													'param_name'  => 'border_color',
													'heading'     => _x('Border Color', 'Admin Panel','naturalife' ),
													'type'        => 'colorpicker'				
												),

												array(
													'param_name'  => 'border_width',
													'heading'     => _x('Border Width (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number'							
												),

												array(
													'param_name'  => 'border_radius',
													'heading'     => _x('Border Radius (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number'							
												),

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),


												array(
													'param_name'  => 'margin_top',
													'heading'     => _x( 'Margin Top', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set margin top value (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Margins', 'Admin Panel','naturalife' ),
												),

												array(
													'param_name'  => 'margin_bottom',
													'heading'     => _x( 'Margin Bottom', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set margin bottom value (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Margins', 'Admin Panel','naturalife' ),
												),

												array(
													'param_name'  => 'margin_left',
													'heading'     => _x( 'Margin Left', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set margin left value (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Margins', 'Admin Panel','naturalife' ),
												),

												array(
													'param_name'  => 'margin_right',
													'heading'     => _x( 'Margin Right', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set margin right value (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Margins', 'Admin Panel','naturalife' ),
												),	


												array(
													'param_name'  => 'padding_top',
													'heading'     => _x( 'Padding Top', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set padding top value (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),
												),

												array(
													'param_name'  => 'padding_bottom',
													'heading'     => _x( 'Padding Bottom', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set padding bottom value (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),
												),

												array(
													'param_name'  => 'padding_left',
													'heading'     => _x( 'Padding Left', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set padding left value (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),
												),

												array(
													'param_name'  => 'padding_right',
													'heading'     => _x( 'Padding Right', 'Admin Panel','naturalife' ),
													'description' => _x( 'Set padding right value (px,%)', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),
												),	

										),								

					),


					/*
						ToolTips
					*/						

					"tooltip" => array( 

						"name"=> _x('ToolTips','Admin Panel','naturalife'),
						"description"=> _x('Displays a tooltip text when hover the item that inside the brackets.','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'tooltip',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Content text'
									),
						"parameters" => array(

											array(
												"param_name" => 'text',
												"description"=> 'ToolTip Text',
												"default_value" => 'Tooltip Text',
											),

											array(
												"param_name" => 'link',
												"description"=> 'Link (url)',
												"default_value" => '',
											),

											array(
												"param_name" => 'target',
												"description"=> _x('Link Target','Admin Panel','naturalife'),
												"default_value" => '',
												"value" => array(
																		_x('Same Window','Admin Panel','naturalife') => "_self",
																		_x('New Window','Admin Panel','naturalife') => "_blank",
																	),
											),

										),								

					),

					/*
						Counter
					*/						

					"rt_counter" => array( 

						"name"=> _x('Animated Number','Admin Panel','naturalife'),
						"description"=> _x('Displays an animated number','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_counter',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Number Description'
									),
						"parameters" => array(

													array(
														'param_name'  => 'number',
														'heading'     => _x('Number', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '99',
														'holder'      => 'h2',
														'save_always' => true
													),

													array(
														'param_name'  => 'text',
														'heading'     => _x( 'Text', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'holder'      => 'div',
														'description' => _x( 'Text after number', 'Admin Panel','naturalife' ), 
														'save_always' => true
													), 

													array(
														'param_name'  => 'font',
														'heading'     => _x( 'Font Family', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default", 'Admin Panel','naturalife') => "", 
																			_x("Heading Font", 'Admin Panel','naturalife') => "heading-font", 
																			_x("Body Font", 'Admin Panel','naturalife') => "body-font", 
																			_x("Secondary Font", 'Admin Panel','naturalife') => "secondary-font", 
																			_x("Menu Font", 'Admin Panel','naturalife') => "menu-font"
																		),
														'save_always' => true
													),
													
													array(
														'param_name'  => 'font_size',
														'heading'     => _x('Custom Font Size (px,em)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number'
													),		


													array(
														'param_name'  => 'align',
														'heading'     => __( 'Text Align', 'naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			__("Default", "naturalife") => "",
																			__("Left", "naturalife") => "left",
																			__("Right", "naturalife") => "right",
																			__("Center", "naturalife") => "center",													
																		)	
													),

						  
													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),
										),								

					),

					/*
						Animated Text
					*/						

					"rt_anim" => array( 

						"name"=> _x('Animated Text','Admin Panel','naturalife'),
						"description"=> _x('Displays an animated text','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_anim',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'WELCOME|WILLKOMMEN|WELKOM'
									),
						"parameters" => array(

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),

													array(
														'param_name'  => 'style',
														'heading'     => _x( 'Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																				_x("No Style", 'Admin Panel','naturalife')  => "no-style", 
																				_x("Style 1", 'Admin Panel','naturalife')   => "1",
																				_x("Style 2", 'Admin Panel','naturalife')   => "2",
																				_x("Style 3", 'Admin Panel','naturalife')   => "3", 																				
																			), 
														'save_always' => true
													),

													array(
														'param_name'  => 'timeout',
														'heading'     => _x('Timeout', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '3000',
													),													

										),								

					),


					/*
						Animated Text
					*/						

					"rt_countdown" => array( 

						"name"=> _x('Countdown','Admin Panel','naturalife'),
						"description"=> 
											_x('Add an animated date countdown.','Admin Panel','naturalife').'<br />'.
											_x('Leave blank for the default output. To customize the output you can use these available special codes;', 'Admin Panel','naturalife' ).
											'<br/><br/><code>%Y</code> '._x('for years', 'Admin Panel','naturalife' ).
											'<br/><code>%m</code> '._x('for monts', 'Admin Panel','naturalife' ). 
											'<br/><code>%n</code> '._x('for days of the month', 'Admin Panel','naturalife' ).
											'<br/><code>%D</code> '._x('for total days', 'Admin Panel','naturalife' ).
											'<br/><code>%H</code> '._x('for hours', 'Admin Panel','naturalife' ).
											'<br/><code>%I</code> '._x('for total hours', 'Admin Panel','naturalife' ).
											'<br/><code>%M</code> '._x('for minutes', 'Admin Panel','naturalife' ).
											'<br/><code>%S</code> '._x('for seconds', 'Admin Panel','naturalife' ).
											'<br /><br /><b>'._x('Example', 'Admin Panel','naturalife' )
											,
						"subline" => false,
						"id"=> 'rt_countdown',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => '<i><b>%D</b>DAYS</i> <i><b>%H</b>HOURS</i> <i><b>%M</b>MINUTES</i> <i><b>%S</b>SECONDS</i>'
									),
						"parameters" => array(

													array(
														'param_name'  => 'date',
														'heading'     => _x('End Date', 'Admin Panel','naturalife' ),
														'description' => _x('Use only this format: year/month/day hour:minutes - example:', 'Admin Panel','naturalife' ).'<code>2018/01/01 22:39</code>',
														'type'        => 'textfield',
														'value'       => '',
														'holder'      => 'p',
														'save_always' => true
													),
 
													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),
													  
													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),
										

										),								

					),


					/*
					* Retina Image
					*/						

					"rt_retina_image" => array( 

						"name"=> _x('Retina Image','Admin Panel','naturalife'),
						"description"=> _x('Add an image with retina support','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_retina_image',
						"open" => true,
						"close" => false,
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),
						"parameters" => array(

						        
													array(
														'param_name'  => 'auto_resize',
														'heading'     => _x( 'Auto Resize', 'Admin Panel', 'naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Enable", 'Admin Panel','naturalife') => "true", 
																			_x("Disabled", 'Admin Panel','naturalife') => "false", 
																		),
														'save_always' => true							
													),


													/* Image */
													array(
														'param_name'  => 'img_1x',
														'heading'     => _x('Image 1x', 'Admin Panel', 'naturalife' ),
														'description' => _x("Select an image from your media library. The selected image will be displayed on standard displays.", 'Admin Panel', 'naturalife' ),
														'type'        => 'attach_image',
														'holder'      => '',
														'value'       => '',
														"dependency"  => array(
																		"element" => "auto_resize",
																		"value" => array("false")
														),																		
													),

													array(
														'param_name'  => 'img',
														'heading'     => _x('Image 2x', 'Admin Panel', 'naturalife' ),
														'description' => _x("Select an image from your media library. If auto resize is enabled, the 1x version will be created automatically. Upload 2x bigger images to get a clear render on retina displays.", 'Admin Panel', 'naturalife' ),
														'type'        => 'attach_image',
														'holder'      => 'img',
														'value'       => '',						
													),
						        
													array(
														'param_name'  => 'img_align',
														'heading'     => _x( 'Image Align', 'Admin Panel', 'naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Select", 'Admin Panel','naturalife') => "",
																			_x("Left", 'Admin Panel','naturalife') => "left",
																			_x("Right", 'Admin Panel','naturalife') => "right", 
																			_x("Center", 'Admin Panel','naturalife') => "center", 
																		),
														'save_always' => true							
													),

													array(
														'param_name'  => 'img_bottom_margin',
														'heading'     => _x( 'Image Bottom Margin (px)', 'Admin Panel', 'naturalife' ),
														'group'       => 'Margins',
														'type'        => 'rt_number'
													),

													array(
														'param_name'  => 'img_top_margin',
														'heading'     => _x( 'Image Top Margin (px)', 'Admin Panel', 'naturalife' ),
														'group'       => 'Margins',
														'type'        => 'rt_number'
													),

													array(
														'param_name'  => 'img_left_margin',
														'heading'     => _x( 'Image Left Margin (px)', 'Admin Panel', 'naturalife' ),
														'group'       => 'Margins',
														'type'        => 'rt_number'
													),

													array(
														'param_name'  => 'img_right_margin',
														'heading'     => _x( 'Image Right Margin (px)', 'Admin Panel', 'naturalife' ),
														'group'       => 'Margins',
														'type'        => 'rt_number'						
													),
						 

													array(
														'param_name'  => 'link',
														'heading'     => _x('Link', 'Admin Panel', 'naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => 'Link'
													),

													array(
														'param_name'  => 'link_title',
														'heading'     => _x('Link Title', 'Admin Panel', 'naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'group'       => 'Link'
													),

													array(
														'param_name'  => 'link_target',
														'heading'     => _x('Link Target', 'Admin Panel', 'naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																			_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																		),
														'group'       => 'Link'
													),										


													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel', 'naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel', 'naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel', 'naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel', 'naturalife' ),
														'type'        => 'textfield'
													),
										),								

					),

					/*
						Info Box
					*/						

					"info_box" => array( 

						"name"=> _x('Info Box','Admin Panel','naturalife'),
						"description"=> _x('Creates an info box','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'info_box',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Content text'
									),
						"parameters" => array( 

												array(
													'param_name'  => 'style',
													'heading'     => _x( 'Button Size', 'Admin Panel','naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		_x("Announcement",'Admin Panel','naturalife')=>"announcement",
																		_x("Ok",'Admin Panel','naturalife')=>"ok",
																		_x("Attention",'Admin Panel','naturalife')=>"attention",
																		_x("Info",'Admin Panel','naturalife')=>"info",
																	), 
													'save_always' => true
												),

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield',
													'value'       => ''
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

										),								

					),


					/*
						Buttons
					*/			

					"button" => array(
						"name"=> _x('Button','Admin Panel','naturalife'),
						"description"=> _x('Creates button.','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'button',
						"open" => true,
						"close" => false,
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),
						"parameters" => array(


													array(
														'param_name'  => 'button_text',
														'heading'     => _x('Button Text', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'holder'      => 'span',
														'save_always' => true
													),

													array(
														'param_name'  => 'button_style',
														'heading'     => _x( 'Button Style', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																				_x("Style 1", 'Admin Panel','naturalife')   => "style-1",
																				_x("Style 2", 'Admin Panel','naturalife')   => "style-2",
																				_x("Style 3", 'Admin Panel','naturalife')   => "style-3", 
																				_x("Black", 'Admin Panel','naturalife')     => "black", 
																				_x("White", 'Admin Panel','naturalife')     => "white", 
																				_x("Flat Text", 'Admin Panel','naturalife') => "text",
																				_x("Custom", 'Admin Panel','naturalife')    => "custom",
																			),
														'save_always' => true
													),

													array(
																'param_name'  => 'button_arrow',
																'type'        => 'checkbox',
																'value'       => array(
																						_x("Button Arrow", 'Admin Panel','naturalife') => "true"
																					 )
															),

													array(
																'param_name'  => 'button_rounded',
																'type'        => 'checkbox',
																'value'       => array(
																						_x("Rounded Button", 'Admin Panel','naturalife') => "true"
																					 )
															),

													array(
														'param_name'  => 'font',
														'heading'     => _x( 'Font Family', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default", 'Admin Panel','naturalife') => "", 
																			_x("Heading Font", 'Admin Panel','naturalife') => "heading-font", 
																			_x("Body Font", 'Admin Panel','naturalife') => "body-font", 
																			_x("Secondary Font", 'Admin Panel','naturalife') => "secondary-font", 
																		),
														'save_always' => true
													),
													

													array(
														'param_name'  => 'button_size',
														'heading'     => _x( 'Button Size', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Small", 'Admin Panel','naturalife') => "small",
																			_x("Medium", 'Admin Panel','naturalife') => "medium",
																			_x("Big", 'Admin Panel','naturalife') => "big",
																			_x("Hero", 'Admin Panel','naturalife') => "hero",
																		),
														'save_always' => true,
														"dependency"  => array(
															"element" => "button_style",
															"value" => array("style-1","style-2","style-3","black","white","custom")
														),											
													),
 
													array(
														'param_name'  => 'button_icon',
														'heading'     => _x('Button Icon', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'save_always' => true,
														"dependency"  => array(
															"element" => "button_style",
															"value" => array("style-1","style-2","style-3","black","white","custom")
														),											
													),

													array(
														'param_name'  => 'button_align',
														'heading'     => _x( 'Button Align', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default", 'Admin Panel','naturalife') => "",
																			_x("Left", 'Admin Panel','naturalife') => "left",
																			_x("Right", 'Admin Panel','naturalife') => "right",
																			_x("Center", 'Admin Panel','naturalife') => "center",													
																		),
														'save_always' => true
													),
 
													array(
														'param_name'  => 'link_open',
														'heading'     => _x('Link Target', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																			_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'href_title',
														'heading'     => _x('Link Title', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														'type'        => 'textfield',
													),		

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),
										),				
					),


					/*
						Heading 
					*/			

					"rt_heading" => array(
						"name"=> _x('Heading','Admin Panel','naturalife'),
						"description"=> _x('Creates a styled heading','Admin Panel','naturalife'),
						"subline" => false,
						"id"=> 'rt_heading',
						"open" => true,
						"close" => true,
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Heading Text'
									),
						"parameters" => array(

													array(
														'param_name'  => 'style',
														'heading'     => __( 'Style', 'naturalife' ),
														'description' => __( 'Select a style', 'naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																				__("No-Style", "naturalife") => "", 
																				__("Style One - ( w/ a short thin line before )", "naturalife") => "style-1",
																				__("Style Two - ( w/ a short thin line after )", "naturalife") => "style-2", 
																				__("Style Three - ( w/ lines before and after )", "naturalife") => "style-3", 
																				__("Style Four - ( w/ a thin line below - centered ) ", "naturalife") => "style-4", 
																				__("Style Five - ( w/ a thin line below - left aligned ) ", "naturalife") => "style-5", 
																				__("Style Six - ( w/ a long line after - left aligned )  ", "naturalife") => "style-6", 										
																		),
														'save_always' => true
													),


												array(
													'param_name'  => 'align',
													'heading'     => __( 'Text Align', 'naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		__("Default", "naturalife") => "",
																		__("Left", "naturalife") => "left",
																		__("Right", "naturalife") => "right",
																		__("Center", "naturalife") => "center",													
																	),
													"dependency"  => array(
																	"element" => "style",
																	"value" => array("")
													),									
													'save_always' => true
												),

												array(
													'param_name'  => 'mobile_align',
													'heading'     => __( 'Mobile Text Align', 'naturalife' ),
													'description' => __( 'Tablet portrait or smaller', 'naturalife' ),
													'type'        => 'dropdown',
													"value"       => array(
																		__("Default", "naturalife") => "",
																		__("Left", "naturalife") => "left",
																		__("Right", "naturalife") => "right",
																		__("Center", "naturalife") => "center",													
																	),
													"dependency"  => array(
																	"element" => "style",
																	"value" => array("")
													),									
													'save_always' => true
												),

													array(
														'param_name'  => 'punchline',
														'heading'     => __('Punchline', 'naturalife' ),
														'description' => __('Optional puchline text', 'naturalife' ),
														'type'        => 'textfield',
														"dependency"  => array(
																		"element" => "style",
																		"value" => array("style-1","style-2","style-4","style-5")
														),	
														'save_always' => true									
													),


													array(
														'param_name'  => 'size',
														'heading'     => __( 'Tag', 'naturalife' ),
														'description' => __( 'Select the tag of the heading', 'naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			"H1" => "h1", 
																			"H2" => "h2", 
																			"H3" => "h3", 
																			"H4" => "h4", 
																			"H5" => "h5", 
																			"H6" => "h6", 
																			"p" => "p",
																			"span" => "span"													
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'icon_name',
														'heading'     => __('Icon Name', 'naturalife' ),
														'description' => __('Icon name', 'naturalife' ),
														'type'        => 'textfield',
														'class'       => 'icon_selector'
													),

													array(
														'param_name'  => 'icon_size',
														'heading'     => __('Icon Size (px)', 'naturalife' ),
														'type'        => 'textfield',
														'class'       => 'rt_number',
														"dependency"  => array(
																		"element" => "style",
																		"value" => array("")
														),									
													),

													array(
														'param_name'  => 'font_color_type',
														'heading'     => _x( 'Font Color', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default Heading Color", 'Admin Panel','naturalife') => "", 
																			_x("Custom Color", 'Admin Panel','naturalife') => "custom", 
																			_x("Primary Color", 'Admin Panel','naturalife') => "primary", 
																		),
														'save_always' => true
													),

													array(
														'param_name'  => 'font_color',
														'heading'     => _x('Custom Font Color', 'Admin Panel','naturalife' ),
														'type'        => 'colorpicker',
														"dependency"  => array(
																		"element" => "font_color_type",
																		"value" => array("custom")
														),											
													),


													array(
														'param_name'  => 'background_color',
														'heading'     => _x('Custom Background Color', 'Admin Panel','naturalife' ),
														'type'        => 'colorpicker',
														"dependency"  => array(
																		"element" => "font_color_type",
																		"value" => array("custom")
														),											
													),

													array(
														'param_name'  => 'font',
														'heading'     => _x( 'Font Family', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default", 'Admin Panel','naturalife') => "", 
																			_x("Heading Font", 'Admin Panel','naturalife') => "heading-font", 
																			_x("Body Font", 'Admin Panel','naturalife') => "body-font", 
																			_x("Secondary Font", 'Admin Panel','naturalife') => "secondary-font", 
																			_x("Menu Font", 'Admin Panel','naturalife') => "menu-font"
																		),
														'save_always' => true
													),


													array(
														'param_name'  => 'custom_font_size',
														'heading'     => _x('Font Size', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Default Size", 'Admin Panel','naturalife') => "", 
																			_x("Custom Size", 'Admin Panel','naturalife') => "custom", 
																			_x("Responsive Size", 'Admin Panel','naturalife') => "responsive",  
																		),
														'save_always' => true
													),


													array(
														'param_name'  => 'font_size',
														'heading'     => _x('Custom Font Size (px,em)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														"dependency"  => array(
																		"element" => "custom_font_size",
																		"value" => array("custom")
														),											
													),

													array(
														'param_name'  => 'max_font_size',
														'heading'     => _x('Max Font Size (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														"dependency"  => array(
																		"element" => "custom_font_size",
																		"value" => array("responsive")
														),											
													),

													array(
														'param_name'  => 'min_font_size',
														'heading'     => _x('Min Font Size (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														"dependency"  => array(
																		"element" => "custom_font_size",
																		"value" => array("responsive")
														),											
													),

													array(
														'param_name'  => 'line_height',
														'heading'     => _x('Custom Line Height (px, %)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number'
													),
													
													array(
														'param_name'  => 'letter_spacing',
														'heading'     => _x('Custom Letter Spacing (px)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number'
													),

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => ''
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),


													array(
														'param_name'  => 'link',
														'heading'     => _x('Link', 'Admin Panel','naturalife' ),
														'type'        => 'textfield',
														'value'       => '',
														'save_always' => true,
														'group'       => 'Link'
													),

													array(
														'param_name'  => 'link_open',
														'heading'     => _x('Link Target', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														"value"       => array(
																			_x("Same Tab", 'Admin Panel','naturalife') => "_self",
																			_x("New Tab", 'Admin Panel','naturalife') => "_blank", 
																		),
														'save_always' => true,
														'group'       => 'Link'
													),

													array(
														'param_name'  => 'href_title',
														'heading'     => _x('Link Title', 'Admin Panel','naturalife' ),
														'type'        => 'dropdown',
														'type'        => 'textfield',
														'group'       => 'Link'
													),		


													array(
														'param_name'  => 'margin_top',
														'heading'     => _x( 'Margin Top', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set margin top value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x( 'Margins', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'margin_bottom',
														'heading'     => _x( 'Margin Bottom', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set margin bottom value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x( 'Margins', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'margin_left',
														'heading'     => _x( 'Margin Left', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set margin left value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x( 'Margins', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'margin_right',
														'heading'     => _x( 'Margin Right', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set margin right value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x( 'Margins', 'Admin Panel','naturalife' ),
													),	


													array(
														'param_name'  => 'padding_top',
														'heading'     => _x( 'Padding Top', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set padding top value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'padding_bottom',
														'heading'     => _x( 'Padding Bottom', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set padding bottom value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'padding_left',
														'heading'     => _x( 'Padding Left', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set padding left value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),
													),

													array(
														'param_name'  => 'padding_right',
														'heading'     => _x( 'Padding Right', 'Admin Panel','naturalife' ),
														'description' => _x( 'Set padding right value (px,%)', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'group'       => _x( 'Paddings', 'Admin Panel','naturalife' ),
													),	
										),				
					),


					/*
						Space
					*/			
					"space_box" => array(
						"name"=> _x('Space','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'space_box',
						"description"=> _x('Puts a space.','Admin Panel','naturalife'),
						"open" => true,
						"close" => false,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),					
						"parameters" => array(
											array(
												"param_name" => 'id',
												"description"=> _x('unique id','Admin Panel','naturalife'),
												"default_value" => '', 
											),
											array(
												"param_name" => 'height',
												"description"=> _x('Height value (do not include px, number only)','Admin Panel','naturalife'),
												"default_value" => ''
											),									
										),
					),



					/*
						Highlights
					*/			
					"rt_highlight" => array(
						"name"=> _x('Highlight','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'rt_highlight',
						"description"=> _x('Highlights a text','Admin Panel','naturalife'),
						"open" => true,
						"close" => true,	
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Text'
									),					
						"parameters" => array(
												array(
													"param_name" => 'style',
													"description"=> _x('Style','Admin Panel','naturalife'),
													"default_value" => 'style-1',
													"value" => array(
																			_x('Style 1','Admin Panel','naturalife') => "style-1",
																			_x('Style 2','Admin Panel','naturalife') => "style-2",
																		),
												),								
										),
					),


					/*
						Split Text
					*/			
					"rt_split_text" => array(
						"name"=> _x('Split Text','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'rt_split_text',
						"description"=> _x('Splits a text into columns','Admin Panel','naturalife'),
						"open" => true,
						"close" => true,	
						"content" => array(
										"shortcode_id" => '',
										"text" => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque facilisis velit a eleifend bibendum. Sed bibendum velit placerat libero cursus cursus. Sed nibh turpis, malesuada vitae purus sed, fermentum efficitur turpis. Integer porttitor nisi tortor, fermentum egestas augue commodo id.'
									),					
						"parameters" => array(
												array(
													"param_name" => 'col',
													"description"=> _x('Column Size','Admin Panel','naturalife'),
													"default_value" => '1',
													"value" => array(
																			_x('Column 1','Admin Panel','naturalife') => "1",
																			_x('Column 2','Admin Panel','naturalife') => "2",
																			_x('Column 3','Admin Panel','naturalife') => "3",
																			_x('Column 4','Admin Panel','naturalife') => "4",
																			_x('Column 5','Admin Panel','naturalife') => "5",
																			_x('Column 6','Admin Panel','naturalife') => "6",																			
																		),
												),								
										),
					),

					/*
						Pie Chart
					*/			
					"rt_pie_chart" => array(
						"name"=> _x('Pie Chart','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'rt_pie_chart',
						"description"=> _x('Add a single animated pie chart.','Admin Panel','naturalife'),
						"open" => true,
						"close" => true,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),					
						"parameters" => array(

												array(
													'param_name'  => 'percent',
													'heading'     => _x('Percent', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'value'       => '',
													'holder'      => 'h2',
													'save_always' => true
												),

												array(
													'param_name'  => 'icon_name',
													'heading'     => _x('Icon Name', 'Admin Panel', 'naturalife' ),
													'description' => __('Click inside the field to select an icon or type the icon name.', 'naturalife' ),
													'type'        => 'textfield',
													'class'       => 'icon_selector'
												),

												array(
													'param_name'  => 'base_color',
													'heading'     => _x( 'Base Color', 'Admin Panel','naturalife' ),
													'description' => _x( 'Leave blank for the default value.', 'Admin Panel','naturalife' ),
													'type'        => 'colorpicker',
													'save_always' => true		
												),

												array(
													'param_name'  => 'bar_color',
													'heading'     => _x( 'Bar Color', 'Admin Panel','naturalife' ),
													'description' => _x( 'Leave blank for the default value.', 'Admin Panel','naturalife' ),
													'type'        => 'colorpicker',
													'save_always' => true		
												),

												array(
													'param_name'  => 'size',
													'heading'     => _x( 'Bar Size', 'Admin Panel','naturalife' ),
													'description' => _x( 'Leave blank for the default value. Default value is 180px', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'save_always' => true		
												),

												array(
													'param_name'  => 'linewidth',
													'heading'     => _x( 'Line Width', 'Admin Panel','naturalife' ),
													'description' => _x( 'Leave blank for the default value. Default value is 15px', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'save_always' => true		
												),


												array(
													'param_name'  => 'font_size',
													'heading'     => _x( 'Font Size', 'Admin Panel','naturalife' ),
													'description' => _x( 'Leave blank for the default value. Default value is 30px', 'Admin Panel','naturalife' ),
													'type'        => 'rt_number',
													'save_always' => true		
												),

												array(
													'param_name'  => 'font_color',
													'heading'     => _x( 'Font Color', 'Admin Panel','naturalife' ),
													'description' => _x( 'Select a background color for the icon or percent value', 'Admin Panel','naturalife' ),
													'type'        => 'colorpicker'
												),

												array(
													'param_name'  => 'id',
													'heading'     => _x('ID', 'Admin Panel','naturalife' ),
													'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

												array(
													'param_name'  => 'class',
													'heading'     => _x('Class', 'Admin Panel','naturalife' ),
													'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
													'type'        => 'textfield'
												),

											),
					),


					/*
						Progress Bar
					*/			
					"rt_progress_bar" => array(
						"name"=> _x('Progress Bar','Admin Panel','naturalife'),
						"subline" => '',
						"id"=> 'rt_progress_bar',
						"description"=> _x('Add a single progress bar.','Admin Panel','naturalife'),
						"open" => true,
						"close" => true,	
						"content" => array(
										"shortcode_id" => '',
										"text" => ''
									),					
						"parameters" => array(

													array(
														'param_name'  => 'heading',
														'heading'     => _x('Heading', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '',
														'holder'      => 'h5',
														'save_always' => true
													),

													array(
														'param_name'  => 'percent',
														'heading'     => _x('Percent', 'Admin Panel','naturalife' ),
														'type'        => 'rt_number',
														'value'       => '',
														'holder'      => 'p',
														'save_always' => true
													),

													array(
														'param_name'  => 'base_color',
														'heading'     => _x( 'Base Color', 'Admin Panel','naturalife' ),
														'description' => _x( 'Leave blank for the default value.', 'Admin Panel','naturalife' ),
														'type'        => 'colorpicker',
														'save_always' => true		
													),

													array(
														'param_name'  => 'bar_color',
														'heading'     => _x( 'Bar Color', 'Admin Panel','naturalife' ),
														'description' => _x( 'Leave blank for the default value.', 'Admin Panel','naturalife' ),
														'type'        => 'colorpicker',
														'save_always' => true		
													),

													array(
														'param_name'  => 'id',
														'heading'     => _x('ID', 'Admin Panel','naturalife' ),
														'description' => _x('Unique ID', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),

													array(
														'param_name'  => 'class',
														'heading'     => _x('Class', 'Admin Panel','naturalife' ),
														'description' => _x('CSS Class Name', 'Admin Panel','naturalife' ),
														'type'        => 'textfield'
													),

											),
					),

				);


		 

				//example shortcodes
				$this->shortcode_examples = array(
		 
					 
					/*
						Columns
					*/			
					"rt_cols" => array(
						_x('Two Columns Example','Admin Panel','naturalife') => '
						[rt_cols]
							
							[rt_col width="6/12"]
								Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							[/rt_col]

							[rt_col width="6/12"]
								Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							[/rt_col]

						[/rt_cols]
						',

						_x('Three Columns Example','Admin Panel','naturalife') => '
						[rt_cols]

							[rt_col width="4/12"]
								Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							[/rt_col]					

							[rt_col width="4/12"]
								Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							[/rt_col]

							[rt_col width="4/12"]
								Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
							[/rt_col]

						[/rt_cols]
						',				

						),

					/*
						Columns
					*/			
					"rt_pricing_table" => array(
						_x('Pricing Table Example','Admin Panel','naturalife') => '
							[rt_pricing_table style="service"][rt_table_column style="" caption="BASIC PACKAGE" price="<sup>$</sup>19" info="yearly plan"]
							<ul>
							 	<li>[tooltip text="Tooltip Text"]Description With Tooltip[/tooltip]</li>
							 	<li>10 MB Max File Size</li>
							 	<li>1 GHZ CPU</li>
							 	<li>256 MB Memory</li>
							 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="black"]</li>
							</ul>
							[/rt_table_column][rt_table_column style="highlight" caption="PRO PACKAGE" price="<sup>$</sup>49" info="yearly plan"]
							<ul>
							 	<li>[tooltip text="Tooltip Text"]Description With Tooltip[/tooltip]</li>
							 	<li>20 MB Max File Size</li>
							 	<li>2 GHZ CPU</li>
							 	<li>512 MB Memory</li>
							 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="style-1"]</li>
							</ul>
							[/rt_table_column][rt_table_column style="" caption="DEVELOPER PACKAGE" price="<sup>$</sup>109" info="monthly plan"]
							<ul>
							 	<li>[tooltip text="Tooltip Text"]Description With Tooltip[/tooltip]</li>
							 	<li>200 MB Max File Size</li>
							 	<li>3 GHZ CPU</li>
							 	<li>1000 MB Memory</li>
							 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="black"]</li>
							</ul>
							[/rt_table_column][/rt_pricing_table]
						',				

						_x('Compare Table Example','Admin Panel','naturalife') => '
							[rt_compare_table style="compare"][rt_compare_table_column style="features"]
							<ul>
							 	<li>Use Tooltips</li>
							 	<li>Use Icons</li>
							 	<li>CPU</li>
							 	<li>Memory</li>
							</ul>
							[/rt_compare_table_column][rt_compare_table_column style="" caption="BASIC PACKAGE" info="yearly plan" price="<sup>$</sup>19"]
							<ul>
							 	<li>[tooltip text="Tooltip Text"][rt_icon icon_name="icon-info-circled"][/tooltip]</li>
							 	<li>[rt_icon icon_name="icon-cancel"]</li>
							 	<li>[rt_icon icon_name="icon-cancel"]</li>
							 	<li>256 MB Memory</li>
							 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="black"]</li>
							</ul>
							[/rt_compare_table_column][rt_compare_table_column style="highlight" caption="START PACKAGE" info="yearly plan" price="<sup>$</sup>49"]
							<ul>
							 	<li>[tooltip text="Tooltip Text"][rt_icon icon_name="icon-info-circled"][/tooltip]</li>
							 	<li>[rt_icon icon_name="icon-ok"]</li>
							 	<li>[rt_icon icon_name="icon-ok"]</li>
							 	<li>512 MB Memory</li>
							 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="style-1"]</li>
							</ul>
							[/rt_compare_table_column][rt_compare_table_column style="" caption="PRO PACKAGE" info="monthly plan" price="<sup>$</sup>109"]
							<ul>
							 	<li>[tooltip text="Tooltip Text"][rt_icon icon_name="icon-info-circled"][/tooltip]</li>
							 	<li>[rt_icon icon_name="icon-ok"]</li>
							 	<li>[rt_icon icon_name="icon-ok"]</li>
							 	<li>1000 MB Memory</li>
							 	<li>[button button_link="#" button_text="BUY NOW" button_size="medium" button_rounded="true" button_style="black"]</li>
							</ul>
							[/rt_compare_table_column][/rt_compare_table]
						',				
						),


					/*
						Photo Gallery
					*/			
					"rt_image_gallery" => array(
						_x('Example 1','Admin Panel','naturalife') => '
						[rt_image_gallery list_layout="1/4" crop="true" tooltips="true"]
							[rt_gal_item action="lightbox" link_target="_self" image_id="THE-IMAGE-ID" title="Title"]Optional caption text[/rt_gal_item]
							[rt_gal_item action="lightbox" custom_link="" link_target="_self" id="" image_id="THE-IMAGE-ID" title="Title"]Optional caption text[/rt_gal_item]
							[rt_gal_item action="lightbox" custom_link="" link_target="_self" id="" image_id="THE-IMAGE-ID" title="Title"]Optional caption text[/rt_gal_item]
							[rt_gal_item action="lightbox" custom_link="" link_target="_self" id="" image_id="THE-IMAGE-ID" title="Title"]Optional caption text[/rt_gal_item]
						[/rt_image_gallery]
						',				

						),

					/*
						Google Maps
					*/			
					"google_maps" => array(
						_x('Example With 3 Locations','Admin Panel','naturalife') => '
						[google_maps height="300"]
							[location title="Eifel Tower" lat="48.8582285" lon="2.2943877000000157"]Location description for Eifel Tower[/location]
							[location title="Big Ben" lat="51.5007046" lon="-0.12457480000000487"]Location description for Big Ben[/location]
							[location title="Leaning Tower of Pisa" lat="43.722952" lon="10.396596999999929"]Location description for Pisa Tower[/location]
						[/google_maps]
						',				

						),			

					/*
						Icon List
					*/			
					"rt_icon_list" => array(
						_x('Example With 3 lines','Admin Panel','naturalife') => '
							[rt_icon_list list_style="style-1" id=""]
								[rt_icon_list_line icon_name="icon-home-1"]63739 street lorem ipsum City, Country[/rt_icon_list_line]
								[rt_icon_list_line icon_name="icon-phone"]+1 123 312 32 23[/rt_icon_list_line]
								[rt_icon_list_line icon_name="icon-mobile-1"]+1 123 312 32 24[/rt_icon_list_line]
								[rt_icon_list_line icon_name="icon-mail"]info@company.com[/rt_icon_list_line]
							[/rt_icon_list]
						',				

						),			

					/*
						Tabs
					*/			
					"rt_tabs" => array(
						_x('Example With 3 tabs','Admin Panel','naturalife') => '
						[rt_tabs tabs_style="style-1" id=""]

							[rt_tab title="Tab 1" tab_id=""]
								I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
							[/rt_tab]

							[rt_tab title="Tab 2" tab_id=""]
								I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
							[/rt_tab]

						[/rt_tabs]
						',				

						_x('Vertical Tabs Example','Admin Panel','naturalife') => '
						[rt_tabs tabs_style="style-3" id=""]

							[rt_tab title="Tab 1" tab_id=""]
								I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
							[/rt_tab]

							[rt_tab title="Tab 2" tab_id=""]
								I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
							[/rt_tab]
							
						[/rt_tabs]
						',

						),		

		 
					/*
						Accordions
					*/			
					"rt_accordion" => array(
						_x('Example With 3 panes','Admin Panel','naturalife') => '

						[rt_accordion style="icons" first_one_open="true"]

							[rt_accordion_content title="Pane 1 Title" icon_name="icon-home"]
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
							[/rt_accordion_content]

							[rt_accordion_content title="Pane 2 Title" icon_name="icon-pin"]
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
							[/rt_accordion_content]

							[rt_accordion_content title="Pane 3 Title" icon_name="icon-ok"]
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
							[/rt_accordion_content]

						[/rt_accordion]
						',				

						),		
					

					/*
						pullquote
					*/			
					"pullquote" => array(
						_x('Example','Admin Panel','naturalife') => '

						[pullquote align="left"]
							<p>
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
							</p>
						[/pullquote]
						',				

						),		


					/*
						video_embed
					*/			
					"rt_embed" => array(
						_x('Example','Admin Panel','naturalife') => '[rt_embed]http://www.youtube.com/watch?v=utUPth77L_o[/rt_embed]',				
						
						),		
		 
		 			/*
						rt_timeline
					*/			
					"rt_timeline" => array(
						_x('Example','Admin Panel','naturalife') => '
							[rt_timeline id=""]
								[rt_tl_event day="01" month="January" year="2015" title="Title"]<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum non dolor ultricies, porttitor justo non, pretium mi.</p>[/rt_tl_event]
								[rt_tl_event day="01" month="February" year="2015" title="Title"]<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum non dolor ultricies, porttitor justo non, pretium mi.</p>[/rt_tl_event]
								[rt_tl_event day="01" month="March" year="2015" title="Title"]<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum non dolor ultricies, porttitor justo non, pretium mi.</p>[/rt_tl_event]
							[/rt_timeline]
						',				
						
						),		


		 			/*
						rt_bullet_list
					*/			
					"rt_bullet_list" => array(
						_x('Example','Admin Panel','naturalife') => '
							[rt_bullet_list list_style="style-1" icon="check" id="" class=""]
							<ul>
								<li>Donec sollicitudin elit vel quam tincidunt.</li>
								<li>Nunc sed est vulputate est hendrerit dapibus non ut diam!</li>
								<li>Donec pharetra felis non sem facilisis fermentum id at eros.</li>
								<li>Integer tempus neque non arcu mattis pulvinar.</li>
							</ul>
							[/rt_bullet_list]
						',				
						
						),	


			);


	}

}


new rt_shortcode_helper;