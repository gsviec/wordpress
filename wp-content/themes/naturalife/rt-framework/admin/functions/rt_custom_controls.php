<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * RT Custom Controls
 * @return $type
 */
function rtframework_custom_controls( $wp_customize ){


		/**
		 * Custom Media Control Class 
		 */
		class RT_Customize_Media_Control extends WP_Customize_Control {

			public $type = 'rt_media';
			public $statuses;

			public function enqueue() {
				wp_enqueue_media(); 
			}

		 	/**
			 * Constructor.
			 *
			 * If $args['settings'] is not defined, use the $id as the setting ID.
			 *
			 * @since   10/16/2012
			 * @uses    WP_Customize_Control::__construct()
			 * @param   WP_Customize_Manager $manager
			 * @param   string $id
			 * @param   array $args
			 * @return  void
			 */
			public function __construct( $manager, $id, $args = array() ) {

				$this->statuses = array( '' => esc_html_x( 'Default', 'Admin Panel','naturalife' ) );
				parent::__construct( $manager, $id, $args );
			}

	
			/**
			 * Constructor.
			 *
			 * @since 3.4.0
			 * @uses WP_Customize_Image_Control::__construct()
			 *
			 * @param WP_Customize_Manager $manager
			 */
			public function render_content() {

				$field_value = esc_html( $this->value() );
				$id = esc_attr($this->id);
				?>

				<label>

					<?php if ( ! empty( $this->label ) ) : ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php endif;
					if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo wp_kses_data($this->description); ?></span>
					<?php endif; ?>

					
					<div class="form_element upload">
						<input id="<?php echo esc_attr($id); ?>" autocomplete="off" type="text" <?php $this->link(); ?> class="upload_field">  
						<button data-inputid="<?php echo esc_attr($id) ?>" class="button icon-upload rttheme_upload_button" type="button"><?php echo esc_html_x('Upload','Admin Panel','naturalife'); ?></button>
					</div>

					<?php
					//the file extension
					$ext = pathinfo($field_value, PATHINFO_EXTENSION);

					//is the file an image?
					if( $ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif" ){
						$ext_image = true;
					}else{
						$ext_image = false;
					}												

					echo true == ( $field_value && $ext_image ) ? '<div data-holderid="'.$id.'" class="uploaded_file visible">' : '<div data-holderid="'.$id.'" class="uploaded_file ">'; 

						if($field_value){
							echo '<img class="loadit" src="'.$field_value.'"  data-image="'.$id.'" >';
						}else{ 
							echo '<img class="loadit" src="'.RT_THEMEADMINURI.'/images/blank.png"  data-image="'.$id.'">';	 			
						}  

					echo '<span class="icon-cancel delete_single" title="'.esc_html_x("remove image",'Admin Panel','naturalife').'" data-inputid="'.$id.'"></span>';
					echo '</div>';
					?>

				</label>

				<?php				
			}

		}

		/**
		 * Custom Color Control with RGBA Supporrt
		 */
		class RT_Color_Control extends WP_Customize_Control {

			public $type = 'rt_color';
			public $default = '';

			/**
			 * Constructor.
			 * @param WP_Customize_Manager $manager
			 */

			public function __construct( $manager, $id, $args ) { 

				parent::__construct( $manager, $id, $args );
 
				// prapare atts for google font subsets
				if( isset($this->input_attrs["class"]) && $this->input_attrs["class"] == "rt_fonts" ){

					$data_subset_id = get_theme_mod( $this->input_attrs["data-subset-id"] );
					$data_variant_id = get_theme_mod( $this->input_attrs["data-variant-id"] );

					$this->input_attrs["data-selected-subsets"] = ! empty($data_subset_id) ? implode(",", $data_subset_id ) : "";
					$this->input_attrs["data-selected-variant"] = ! empty($data_subset_id) ? $data_variant_id : "";					

				}
				
			}

			/**
			 * Render content
			 */						
			public function render_content() { ?>
				<label>

					<?php if ( ! empty( $this->label ) ) : ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php endif;
					if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo wp_kses_data($this->description); ?></span>
					<?php endif; ?>

					<div class="customize-control-content">
						<div class="wp-picker-container">
							<a class="rt-color-control-result wp-color-result" tabindex="0" style="background-color: <?php echo esc_attr( $this->value() ); ?>" title="<?php echo esc_html_x("Select Color",'Admin Panel','naturalife'); ?>" data-current="<?php echo esc_html_x("Current Color",'Admin Panel','naturalife'); ?>"></a>
							
							<span class="wp-picker-input-wrap">
								<input type="text" value="<?php echo esc_attr($this->value()); ?>" <?php esc_attr($this->link()); ?> class="wp-color-picker" data-default-color="<?php echo esc_attr($this->default); ?>" style="display:none;"  <?php $this->input_attrs(); ?>>
								<input class="button button-small wp-picker-default rt-color-control-default" type="button" value="Default" style="display:none;">
							</span>

							<div class="rt-color-control" data-elemenet-id="<?php echo esc_attr( $this->id); ?>"></div>
						</div>
					</div>

				</label>

			<?php }

		}

		/**
		 * Custom Select Control with input_attrs and optgroup support & customizations for rt_fonts
		 */
		class RT_Select_Control extends WP_Customize_Control {

			public $type = 'rt_select';
			public $default = '';


			/**
			 * Construct
			 */
			public function __construct( $manager, $id, $args ) { 

				parent::__construct( $manager, $id, $args );
 
				// prapare atts for google font subsets
				if( isset($this->input_attrs["class"]) && $this->input_attrs["class"] == "rt_fonts" ){

					$data_subset_id = get_theme_mod( $this->input_attrs["data-subset-id"] );
					$data_variant_id = get_theme_mod( $this->input_attrs["data-variant-id"] );

					$this->input_attrs["data-selected-subsets"] = ! empty($data_subset_id) ? implode(",", $data_subset_id ) : "";
					$this->input_attrs["data-selected-variant"] = ! empty($data_subset_id) ? $data_variant_id : "";					

				}
				
			}


			/**
			 * Render content
			 */
			public function render_content() {  
				?>
					<label>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif;
						if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo wp_kses_data($this->description); ?></span>
						<?php endif; ?>

						<select <?php $this->link(); ?> <?php $this->input_attrs(); ?>>
							<?php
							foreach ( $this->choices as $value => $label )

								switch ( $value ) {

									case strpos($value, "obt_start") > 0 :
										echo '<optgroup label="' . esc_attr($label) . '"">';	
										break;
								
									case strpos($value, "obt_end") > 0 :
										echo '</optgroup>';	
										break;

									case strpos( $value, "\"kind\":") > 0 :
										$this->create_font_option( $value, $label );
										break;

									default:
										echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_attr($label) . '</option>';
										break;
								}
								
							?>
						</select>
					</label>
				<?php
			}


			/**
			 * createa an option for font lists
			 */
			public function create_font_option( $value, $label ) {  

				$font_data = json_decode( $value );
				echo '<option value="' . $font_data->kind . '||'. $font_data->family .'" data-subsets="'. implode($font_data->subsets,',') .'" data-variants="'. implode($font_data->variants,',') .'" >' . $label . '</option>';	

			}


		}		

		/**
		 * Custom Content
		 */
		class RT_Content_Control extends WP_Customize_Control {

			public $type = 'rt_contents';
			public $default = '';

 
			/**
			 * Render content
			 */
			public function render_content() {  
				?>
					<label>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>	
						<?php endif; ?>

							<section class="rt_contnet_control">
								<?php
								 if ( ! empty( $this->description ) ) : ?>
									<?php echo wp_kses_data($this->description); ?>
								<?php endif;?> 
							</section>
							
					</label>
				<?php
			}

		}	

		/**
		 * Custom Checkbox
		 */
		class RT_Checkbox_Control extends WP_Customize_Control {

			public $type = 'rt_checkbox';
			public $default = '';

 
			/**
			 * Render content
			 */
			public function render_content() {  
				?>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); $this->input_attrs(); ?> />
						<?php echo esc_html( $this->label ); ?>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo wp_kses_data($this->description); ?></span>
						<?php endif; ?>
					</label>					

				<?php
			}

		}	



		/**
		 * Custom Seperator
		 */
		class RT_Seperator_Control extends WP_Customize_Control {

			public $type = 'rt_seperator';
			public $default = '';

 
 			/**
			 * Construct
			 */
			public function __construct( $manager, $id, $args ) { 

				parent::__construct( $manager, $id, $args );
 
				// prapare atts for google font subsets
				if( isset($this->input_attrs["class"]) && $this->input_attrs["class"] == "rt_fonts" ){

					$data_subset_id = get_theme_mod( $this->input_attrs["data-subset-id"] );
					$data_variant_id = get_theme_mod( $this->input_attrs["data-variant-id"] );

					$this->input_attrs["data-selected-subsets"] = ! empty($data_subset_id) ? implode(",", $data_subset_id ) : "";
					$this->input_attrs["data-selected-variant"] = ! empty($data_subset_id) ? $data_variant_id : "";					

				}
				
			}

			/**
			 * Render content
			 */
			public function render_content() {  
				?>
					<div  <?php $this->input_attrs(); ?>>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif;
						if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
						<?php endif; ?>
					</div>
				<?php
			}

		}	

		/**
		 * Custom SubSection Heading
		 */
		class RT_SubSection_Heading extends WP_Customize_Control {

			public $type = 'rt_subsection_heading';
			public $default = '';

 
			/**
			 * Render content
			 */
			public function render_content() {  
				?>
					<div>				
						<?php if ( ! empty( $this->label ) ) : ?> 
							<h3 class="rt-customizer-subsection-title"><span class="dashicons-arrow-down-alt2"></span><?php echo esc_attr( $this->label ); ?></h3>
						<?php endif;
						if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
						<?php endif; ?>
					</div>
				<?php
			}

		}			
}
add_action( 'customize_register', 'rtframework_custom_controls' );

