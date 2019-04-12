<?php
//Comments
function rtframework_comments($comment, $args, $depth) {
global $comment; 
?>
	

	<?php
	//highlight the author's comments
	if($comment->user_id == get_the_author_meta('ID')){
		$author_comment_class="author";
	}else{
		$author_comment_class = "";
	}
	?>
		
	 <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
  
  		<div class="comment-holder clearfix">

  			<?php if ($comment->comment_approved == '1') : ?>

				<div class="comment-avatar <?php echo esc_attr($author_comment_class);?>">
				  <?php
				  if(get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])))){
					  echo get_avatar($comment,$size=$args['avatar_size']);
				  }else{
					  echo get_avatar($comment,$size=48);
				  }
				  ?>  
				</div>
				
				<div id="comment-<?php comment_ID(); ?>" class="comment-body <?php echo isset($author_comment_class) ? esc_attr($author_comment_class) : "";?>">
					<div class="comment-author">
						<span class="author-name"><?php comment_author_link();?></span>
						<span class="comment-meta">
							<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(esc_html__('%1$s at %2$s','naturalife'), get_comment_date(), get_comment_time()) ?></a><?php edit_comment_link(esc_html__('(Edit)','naturalife'),' ','') ?>							
							<span class="comment-reply"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
						</span>
					</div>
				
					<div class="comment-text">
						<?php comment_text(); ?>
					</div>
				</div>  

			<?php else : ?>
				<div class="error_box"><?php esc_html_e( 'Your comment is awaiting moderation.', 'naturalife' ); ?></div> 
			<?php endif;?>

			<div class="clear"></div>

		</div>
<?php
}
?>