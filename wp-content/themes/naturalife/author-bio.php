<?php
/* 
* rt-theme author bio 
*/

$author_meta_description = get_the_author_meta( 'description' );

if( ! empty( $author_meta_description ) ):
?>
<div class="author-info d-flex align-items-center">

	<div class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
	</div>
	<div class="author-description">
		<span class="author-title"><?php printf( esc_html__( 'About %s', 'naturalife' ), get_the_author() ); ?></span>
		<?php if(! empty($author_meta_description)): ?>
			<div class="author-bio">
				<?php echo wp_kses_data($author_meta_description); ?>
			</div>
		<?php endif;?>
	</div>
</div>
<?php endif;?>