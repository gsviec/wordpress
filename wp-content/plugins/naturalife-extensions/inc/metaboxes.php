<?php
/**
 * RT-Theme Metaboxes
 * 
 * Creates & save metaboxes
 *
 * @author 	RT-Themes
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'rt_meta_boxes' ) ) {

	class rt_meta_boxes{
		#
		# @var $prefix
		# @var $customFields
		# @var $settings
		#
		
		var $prefix = RT_COMMON_THEMESLUG;
		var $customFields;
		var $settings;
		
 
		/**
		* Constructor
		*/
		function __construct($settings,$customFields) {

			$this->settings = $settings;
			$this->customFields = $customFields;

				//create a hidden field to check this post created before or after the rt-theme
				array_push($this->customFields, array(
					"name"  => RT_THEMESLUG.'_hidden',
					"default" => "1",
					"type"  => "hidden"
				));

			add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
			add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );					 
		}
		 
		/**
		* Create the new Custom Fields meta box
		*/
		function createCustomFields() {
			
			if ( function_exists( 'add_meta_box' ) ) {
				if(is_array($this->settings['scope'])){
					
					foreach($this->settings['scope'] as $scope){
						add_meta_box( $this->settings['slug'], $this->settings['name'], array( &$this, 'displayCustomFields' ), $scope, $this->settings['context'], $this->settings['priority'] );
					}
					
				}else{
					add_meta_box( $this->settings['slug'], $this->settings['name'], array( &$this, 'displayCustomFields' ), $this->settings['scope'], $this->settings['context'], $this->settings['priority'] );
				}
			}
		}
		/**
		* Display the new Custom Fields meta box
		*/
		function displayCustomFields() {
			global $post,$rt_google_fonts;			
			
			$fontSystem = $extraClass = "";
			?>
			 <div class="rt-metaboxes">
				<?php
				
				wp_nonce_field($this->settings['slug'], $this->settings['slug'].'_wpnonce', false, true );

				//get grouped values
				if( isset( $this->settings["array_names"] )){
					foreach ($this->settings["array_names"] as $a_name ) {
						$group_var = $this->prefix.$a_name;
						$$group_var = get_post_meta( $post->ID, $group_var, true );
					}
				}

				//create fields
				foreach ( $this->customFields as $customField ) {
					
					if( isset( $customField[ 'name' ] ) ){

						preg_match("/(.*)\\[(.*)\\]/", str_replace("[]","",$customField[ 'name' ]), $key_name);
					
						//check the name if it is a group name
						if ( is_array($key_name) && count( $key_name ) > 1 ){				
							
							$key_name =  str_replace("[]","", $key_name) ; 
							$group_var = "";
							$group_var = $this->prefix .$key_name[1];
							$group_var = isset( $$group_var ) ? $$group_var : "";

							if( isset( $group_var ) && isset( $group_var[$key_name[2]] ) ){
								$field_value = $group_var[$key_name[2]];
							}else{
								$field_value = "";
							}

						//single name 
						}else{
							$field_value = get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true );
						}

					}else{
						$field_value = "";
					}

					$customField['default'] = isset( $customField['default'] ) ? $customField['default'] : "" ;
					$customField['name'] = isset( $customField['name'] ) ? $customField['name'] : "" ;
					$customField['help'] = isset( $customField['help'] ) ? $customField['help'] : "" ;
					$customField['select'] = isset( $customField['select'] ) ? $customField['select'] : "" ;
					$customField['class'] = isset( $customField['class'] ) ? $customField['class'] : "" ;
					$customField['font-system'] = isset( $customField['font-system'] ) ? $customField['font-system'] : "" ;	


					$id             = $this->prefix . $customField[ 'name' ];
					$title          = isset( $customField[ 'title' ] ) ? $customField[ 'title' ] : "";
					$description    = isset( $customField[ 'description' ] ) ? $customField[ 'description' ]: "";
					$check_desc     = isset( $customField[ 'check_desc' ] ) ? $customField[ 'check_desc' ]: "";
					$class          = isset( $customField[ 'class' ] ) ? $customField[ 'class' ]: "";
					$richEditor     = isset( $customField[ 'richeditor' ] ) ? $customField[ 'richeditor' ]: "";
					$label_position = isset( $customField[ 'label_position' ] ) ? $customField[ 'label_position' ]: "";
 
					// Hidden Field value - check the content saved with rt-theme
					$hidden_value 	= get_post_meta( $post->ID, $this->prefix.RT_THEMESLUG.'_hidden', true );
							
					// default value
					if( empty($hidden_value) && ( empty($field_value) && $customField[ 'type' ] != "checkbox" ) ){
						$field_value = $customField[ 'default' ];
					}

					//if it is a new post - field values are default
					if( ! isset($_GET['action']) ){
						$field_value = $customField[ 'default' ];
					}
 
					// Check capability
					if ( !current_user_can( $this->settings['capability'], $post->ID ) ){
						$output = false;
					}else{
						$output = true;
					}

					//dependency
					$data_atts = $table_class = "";
					if( isset( $customField['dependency'] ) ){

						$data_atts .= ' data-depends-id="'.$customField['dependency']['element'].'"';
						$data_atts .= ' data-depends-values="'.implode($customField['dependency']['value'], ',').'"';

						$table_class .= "hidden-row";
					}					


					//field id
					$html_id = str_replace("[", "_", str_replace("]","",$id));
					
					//labels 
					$description = ! empty( $showDefault ) ? $description . "<br /> Default Value = ".$showDefault." " : $description ;
					$label_style = ! empty( $label_position ) ? "labels_block" : "";
					$desc_row = ! empty( $description ) ? '<tr><td colspan="2"><div class="info rt-panel-icon-info-circled desc"><p>'.$description.'</p></div></td></tr>' : "";
					$help_icon = ! empty( $description ) ? '<span title="'._x('click for more information','Admin Panel','naturalife').'" class="tooltip_icon rt-panel-icon-help-circled"></span>' : "";
					$title_col = ! empty( $title) ? '<th><div>'.$help_icon.'<label for="'.$html_id.'">'.$title.'</label></div></th>' : "" ;
					$label = '<table class="table-row '.$table_class.' ' .$label_style.'" ' .$data_atts.'> '.$desc_row.'<tr>'.$title_col;


					// Output if allowed
					if ( $output ) { ?>

							<?php
							switch ( $customField[ 'type' ] ) {


								case 'tab_titles';
								#	tab titles

								$titles_output = '<ul class="tab_nav">';

								$meta_tab_count = 1;
								foreach ($customField['tab_names'] as $tab_id => $tab_name) {									
									$add_class = ! empty( $tab_name[1] ) ? "with_icon" : "";
									$add_class .= $meta_tab_count == 1 ? " active" : "";
									$icon_output = ! empty( $tab_name[1] ) ? '<span class="'.$tab_name[1].'"></span>' : "";
									$titles_output .= sprintf( '<li class="tab_title %1$s" data-tab-number="%2$s">%3$s %4$s</li>',$add_class, $tab_id,$icon_output,$tab_name[0]);
									$meta_tab_count ++;
								}

								$titles_output .= "</ul>";

								echo $titles_output;
								 								
								break;


								case 'table_start';
								#	table Start

								echo '<table class="table_master"><tr><td class="td_master">';		
								
								break;
 
								case 'table_end';
								#	table End			

								echo '</td></tr></table>';	
								
								break;				

								case 'td_col';			
								#	td split

								echo '</td><td class="td_master">';	
								
								break;		


								case "group_start": {
									// group start
									echo '<div id="'.$id.'" class="'.$class.'">';
									break;
								}
								case "group_end": {
									// group end
									echo '</div>';
									break;
								}								  


								#
								#	div start
								#
								case 'div_start';

								$the_div_id = isset( $id ) ? $id : "" ;
								$the_div_class = isset( $customField['div_class'] ) ? $customField['div_class'] : "" ;

								echo '<div id="'.$the_div_id.'" class="'.$the_div_class.'" ' .$data_atts.'>';

								break;


								#
								#	div end
								#
								case 'div_end';

								echo '</div>';

								break;


								#
								#	Checkbox
								#
								case 'checkbox2'; 

								echo '<table class="table-row '.$table_class.'" ' .$data_atts.'><tr><td><div class="form_element check rt_checkbox "><input autocomplete="off" class="checkbox '.$class.'" type="checkbox" name="'.$id.'"';
									
									if($field_value=="checked" || $field_value=="on"){
										echo ' checked="checked" '; 
										$label_class="icon-check";
									}else{
										$label_class="icon-check-empty";
									}
									
									echo ' id="'.$html_id.'"/><div class="'.$label_class.'">'.$title.'';

									echo ! empty( $description ) ? '<div class="desc">'.$description.'</div>' : "";

								echo '</label></div></td></tr></table>'; 

								break;

								#
								#	Checkbox
								#
								case 'checkbox';  

								echo $label.'<td><div class="form_element check rt_checkbox"><input autocomplete="off" class="checkbox '.$class.'" type="checkbox" name="'.$id.'"';

									if($field_value=="checked" || $field_value=="on"){
										echo ' checked="checked" '; 
									}else{
									}
																		
								echo ' id="'.$html_id.'"/>'.$check_desc.''; 

								echo '</div></div></td></tr></table>'; 

								break;


								#
								#	Radio Buttons
								#
								
 								case 'radio';
 
								echo $label .'<td class="col2"><div class="check"> ';				    				 
							
				
									if($class == "pattern_list") {
										echo '<table class="image_radio '.$class.' " id="'.$html_id.'"><tr>';
									}else{
										echo '<div id="'.$id.'">';
									}
								 

									//post formats
									$post_format_value = get_post_format( $post->ID );



									$field_counter = 1;
									foreach($customField['options'] as $option_value => $option_name){					
										//if array
										if(is_array($option_name)){
											$option_name = $option_name[1];
										}
										
										//new post format value
										if( isset( $post_format_value ) &&  $option_value == $post_format_value ){
											$option_value =  $field_value; 
										} 				

										if( ( isset( $customField['clean_name'] ) && $customField['clean_name'] == "post_format" ) && (  $post_format_value ) ){						
											$field_value = $post_format_value ;
										}

										//clean name
										if( isset( $customField['clean_name'] ) ){										
											$name = $customField['clean_name'];
										}else{
											$name = $id;
										}

										//specific id defined?
										if(isset($customField['ids']) && is_array($customField['options'])){
											$option_id=$customField['ids'][$field_counter-1];  
										}else{
											$option_id=$id.'-'.$field_counter;
										}

										if($class == "pattern_list"){
											if ($field_value==$option_value){
												 echo '<td><div class="first_div '.$class.'"><div class="radio_cover checked radio_'.$option_value.' '.$class.'">';
												 echo '<input type="radio" name="'.$name.'" value="'.$option_value.'"  id="'.$option_id.'" checked></div></div>';
												 echo '<label for="'.$option_id.'">'.$option_name.'</label>';
												 echo '</td>';
											}else{
												 echo '<td><div class="first_div '.$class.'"><div class="radio_cover radio_'.$option_value.' '.$class.'">';
												 echo '<input type="radio" name="'.$name.'" value="'.$option_value.'"  id="'.$option_id.'"></div></div>';
												 echo '<label for="'.$option_id.'">'.$option_name.'</label>';
												 echo '</td>';
											}
										}else{
											if ($field_value==$option_value){
												echo '<span class="radio_button_holder">';
												echo '<input type="radio" name="'.$name.'" value="'.$option_value.'" checked id="'.$option_id.'">';
												echo '<label for="'.$option_id.'">'.$option_name.'</label>'; 								
												echo '</span>';
											}else{
												echo '<span class="radio_button_holder">';
												echo '<input type="radio" name="'.$name.'" value="'.$option_value.'" id="'.$option_id.'">';
												echo '<label for="'.$option_id.'">'.$option_name.'</label>'; 									
												echo '</span>';
											}
										} 

										$field_counter++;
									}
 
									if($class == "pattern_list"){
										echo '</tr></table>';
									}else{
										echo '</div>';
									}
										 
									
								echo '</div></td></tr></table>';	 
								break; 

						 
								#
								#	Select
								#
								case 'select';														
  
								echo $label .'<td class="col2"><div class="form_element">';
								echo '<select autocomplete="off" name="'.$id.'" id="'.$html_id.'" class="'.$class.' '.$fontSystem.' '. $extraClass .' ">';
									
									if($customField['select']) echo '<option value="">'.$customField['select'].'</option>';
									    
									foreach($customField['options'] as $option_value => $option_name){					
										//if array
										if(is_array($option_name)){
											$option_name = $option_name[1];
											$font_family_name = $rt_google_fonts[$option_value][0]; 
										}else{ 
											$font_family_name = ""; 
										}
										
										if (strpos($option_value,"-optgroup-start",0)){
											 echo '<optgroup label="'.$option_name.'">';
										}elseif (strpos($option_value,"-optgroup-end",0)){
											 echo '</optgroup>'; 
										}else{
											if ($field_value==$option_value){
												 echo '<option value="'.$option_value.'"  class="'.@$font_family_name.'__" selected>'.$option_name.'</option>';
											}else{
												 echo '<option value="'.$option_value.'"  class="'.@$font_family_name.'__" >'.$option_name.'</option>';
											}
										}
										
										
									} 
									    
								echo '</select></div></td></tr></table>';		
								
								break;

								#
								#	Select Multiple
								#
								case 'selectmultiple':{
									//Multiple Select
									echo $label .'<td class="col2"><div class="form_element">';

									$options_list = $customField['options'];
									$saved_array  = $field_value; 

									if( is_array( $saved_array ) ){
										foreach (array_reverse($saved_array) as $select_key) {
											$options_list = array( $select_key => $options_list[$select_key] ) + $options_list;
										}
									}
						
									echo '<select multiple name="'.$id.'" id="'.$html_id.'" class="multiple '.$class.' "  title="'._x('Select','Admin Panel','naturalife').'">';
								
										foreach($options_list as $option_value => $option_name){
											$selected = "";
											
											//if value selected
											if(is_array($saved_array)){
												
												foreach($saved_array as $a_key => $a_value){
													if ( $a_value ==  $option_value ){
														$selected="selected";  
													}
													
												}
											}
								
											//if array
											if(is_array($option_name)){
												$option_name = $option_name[1];
											}
											
											if(!$option_value) $option_value=" ";
								
											echo '<option value="'.$option_value.'" '.$selected.'>'.$option_name.'</option>'; 
										}
										
						
									echo '</select>';
									echo '</div></td>'; 
									echo '</tr>';
									echo '</table>';		
								
									break;
								}
			 
								case 'textarea':{
									// Textarea
								
									echo $label;

										if($richEditor && function_exists('wp_editor') ){
											echo '<td class="col2"><div class="form_element">';
											wp_editor( htmlspecialchars_decode( $field_value ), ''.$id.'', array('quicktags' => array( 'buttons' => 'em,strong,link' ),'textarea_name'	=> ''.$id.'','quicktags'=> true,'tinymce'=> true) );
											echo '</div>';
										}else{
											echo '<td class="col2"><div class="form_element"><textarea name="'.$id.'" id="'.$html_id.'" >'.htmlspecialchars($field_value).'</textarea></div>';
										}										

									echo '</td></tr></table>';
					
									break;
								}
				 


								#
								#	Upload
								#
								case 'upload';
								
								echo $label.'
								<td class="col2">
								<div class="form_element upload"><input autocomplete="off" type="text" name="'.$id.'" value="'.$field_value.'" id="'.$html_id.'" class="upload_field">  
								<button data-inputid="'.$html_id.'" class="rt-panel-icon-upload template_button light rttheme_upload_button" type="button">'._x('Upload','Admin Panel','naturalife').'</button>
								</div>';

								//the file extension
								$ext = pathinfo($field_value, PATHINFO_EXTENSION);

								//is the file an image?
								if( $ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif" ){
									$ext_image = true;
								}else{
									$ext_image = false;
								}												

								echo ($field_value && $ext_image) ? '<div data-holderid="'.$html_id.'" class="uploaded_file visible">' : '<div data-holderid="'.$html_id.'" class="uploaded_file ">'; 

									if($field_value){
										echo '<img class="loadit" src="'.$field_value.'"  data-image="'.$html_id.'" >';
									}else{ 
										echo '<img class="loadit" src="'.RT_THEMEADMINURI.'/images/blank.png"  data-image="'.$html_id.'">';	 			
									}  

								echo '<span class="rt-panel-icon-cancel delete_single" title="'._x("remove image",'Admin Panel','naturalife').'" data-inputid="'.$html_id.'"></span>';
								echo '</div>';
								echo '</td></tr></table>';		
								
								break;


								#
								#	Image Upload
								#
								case 'image_upload';
								
								echo $label.'
								<td class="col2">
								<div class="form_element upload" style="display:inline-block;"><input autocomplete="off" type="hidden" name="'.$id.'" value="'.$field_value.'" id="'.$html_id.'" class="upload_field">  
								<button data-inputid="'.$html_id.'" class="rt-panel-icon-upload template_button light rttheme_image_upload_button" type="button">'._x('Upload','Admin Panel','naturalife').'</button>
								</div>';

								$uploaded_image_url = "";
								
								if( $field_value ){
									$get_cat_image = wp_get_attachment_image_src( $field_value, "thumbnail" );
									$uploaded_image_url = is_array( $get_cat_image ) ? $get_cat_image[0] : "";
								}										

								echo ($uploaded_image_url) ? '<div data-holderid="'.$html_id.'" class="uploaded_file visible">' : '<div data-holderid="'.$html_id.'" class="uploaded_file ">'; 

									if($uploaded_image_url){
										echo '<img class="loadit" src="'.$uploaded_image_url.'"  data-image="'.$html_id.'" >';
									}else{ 
										echo '<img class="loadit" src="'.RT_THEMEADMINURI.'/images/blank.png"  data-image="'.$html_id.'">';	 			
									}  

								echo '<span class="rt-panel-icon-cancel delete_single" title="'._x("remove image",'Admin Panel','naturalife').'" data-inputid="'.$html_id.'"></span>';

								echo '</div>';
								echo '</td></tr></table>';		
								
								break;


								#
								#	Headings
								#
								case 'heading';			
								echo '<table class="seperator '.$table_class.'" '.$data_atts.'><tr><td class="col1" colspan="2"><h4 class="sub_title rt-panel-icon-angle-down">'.$title.'</h4>';
								if($description) echo '<div class="desc">'.$description.'</div>';
								echo '</td></tr></table>'; 		
								
								break;


								#
								#	Heading 2
								#
								case 'heading2';			
								echo '<h5>'.$title.'</h5>'; 
								
								break;

								#
								#	Hidden
								#								
								case 'hidden':	{												
									echo '	<input type="hidden" name="'. $id .'" value="'.$field_value.'" id="' . $html_id .'">'; 									
									break;
								}								

								#
								#	Range input
								#
								case 'rangeinput':	{		

									echo $label.'<td class="col2"><div class="form_element"><input type="text" class="range" name="'.$id.'" id="'.$id.'" min="'.@$customField[ 'min' ].'" max="'.@$customField[ 'max' ].'" step="1" value="'.$field_value.'" /></div></td>';
									echo '</tr></table>';		
									
									break;
								}

								#
								#	Info Text  
								#
								case 'info_text_only';			
									
								echo '<table>';
								echo '    <tr>';
								echo '	<td class="col1" colspan="2"><div class="info_text">'.$description.'</div>';
								echo '	</td>';
								echo '    </tr>';
								echo '</table>'; 	
								
								break;

								#
								#	Info Text - with value
								#
								case 'info_text';			
								
								echo '<table>';
								echo '    <tr>';
								echo '	<td class="col1" colspan="2"><label for="'.$id.'">'.$title.'</label>'; 
								echo '	</td>';
								echo '    </tr>';
								echo '    <tr>';
								echo '	<td class="col2"><div class="form_element">'.$description.'</div></td>';
								echo @$help;
								echo '    </tr>';
								echo '</table>';		
								
								break;
								#
								#	Color Picker
								#
								case 'colorpicker';

								echo $label.'<td class="col2"><div class="color_field"><div class="form_element color"><input autocomplete="off" type="text" name="'.$id.'" value="'.$field_value.'" id="'.$id.'" class="'.$class.'"></div>';
								echo '</tr></table>';				 
								
								break;


								default: {
									// Plain text field 
								
									echo $label.'<td class="col2"><div class="form_element"><input type="text" class="'.$class.'" name="'. $id .'" value="'.$field_value.'" id="' . $id .'"></div></td>';
									echo '</tr></table>';
								}
							}

							//	HR
							if(isset($customField[ 'hr' ])=="true") echo "<hr />";

							?>						

					<?php
					}
				} ?>
			</div>
			
			<?php if( $this->settings['slug'] == "rt_design_custom_fields" ):?>
				<div class="rt-metaboxes-footer"><a href="#" id="reset-design-options"><?php echo esc_html_x('Reset design options','Admin Panel','naturalife') ?></a></div>
			<?php endif;?>


			<?php
		}

		#
		# Save the new Custom Fields values
		# 
		function saveCustomFields( $post_id, $post ) {

			//don't save when editing with VC frontend
			if( isset( $_POST["vc_inline"] ) ){
				return;
			}

			$theFields = isset ( $_POST[ $this->settings['slug'].'_wpnonce' ] )  ? $_POST[ $this->settings['slug'].'_wpnonce' ] : "" ;

			// is authorizated ?
			if ( ! wp_verify_nonce( $theFields, $this->settings['slug'] ) ){
				return $post_id;
			}

			// is auto save ?
			if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
				return;
			}

    		//is revision
			if ( isset( $post->post_type ) && 'revision' == $post->post_type ) {

				//save preview data for design options
				if( isset( $_POST[ $this->prefix . "_design_options" ] ) ){
					update_post_meta( $post_id, $this->prefix . "_design_preview_options", $_POST[ $this->prefix . "_design_options" ] ); 
				}
				
				return;

			}else{
				delete_post_meta( $post_id, $this->prefix . "_design_preview_options" ); 
			}


			//continue if user has capability to save
			if ( current_user_can( $this->settings['capability'], $post_id ) ) {

				///save single fields
				foreach ( $this->customFields as $cf ) {
					
					$cf_name = isset( $cf['name'] ) ? $cf['name'] : ""; 

					if (stripos($cf_name, "[")){
						continue;
					}

					$cf_post_value = isset( $_POST[ $this->prefix . $cf_name ] ) ? $_POST[ $this->prefix . $cf_name ] : "";

					if( ! empty( $cf_name ) ){
						update_post_meta( $post_id, $this->prefix . $cf_name, $cf_post_value );
					}
				}  

				//save array fields
				if( isset( $this->settings["array_names"] ) ){

					$cf_post_value = "";
					foreach ($this->settings["array_names"] as $a_name ) {
						$cf_post_value = isset( $_POST[ $this->prefix . $a_name ] ) ? $_POST[ $this->prefix . $a_name ] : "";
						update_post_meta( $post_id, $this->prefix . $a_name, $cf_post_value ); 
					}
				}
			}

			//action after rt meta update/delete
			do_action("rtframework_updated_post_meta",$post_id);			
			
		}
		 
	} // End Class
	
}
?>