<?php
if( ! function_exists("rt_bullet_list") ){
	/**
	 * Icon Lists Holder Shortcode
	 * 
	 * @param  array $atts
	 * @param  string $content
	 * @return html $output
	 */				
	function rt_bullet_list( $atts, $content = null ) { 

	extract(shortcode_atts(array(  
		"id" => '',
		"class" => '',			
		"list_style" => "style-1",
		"icon" => "arrow",
		"columns" => ""
	), $atts));

	$output = "";
 
	//id attr
	$id_attr = ! empty( $id ) ? 'id="'.$id.'"' : "";

	//fix shortcode
	$content = do_shortcode( $content, false );
	$content = rt_visual_composer_content_fix($content,"true");

	//add columns
	if( ! empty( $columns ) && intval( $columns ) > 1 ){
			//columns
			$class .= " column-list column-list-".intval( $columns );

			$re = "/(<li>)(.*)(<\\/li>)/i"; 
			
			preg_match_all($re, $content, $matches);

			$content = "";
			$i = 0;

			foreach ( $matches[0] as $value ) {
				$i++;

				if($i === 1 ){
				//	continue;
					$content .= str_replace("<li", '<li class="first"', $value);	
				}elseif( $i === intval($columns) ){
					$content .= str_replace("<li", '<li class="last"', $value);	
					$i=0;
				}else{
					$content .= str_replace("<li", '<li', $value);	
				}
			}

			$content = "<ul>".$content."</ul>";
	}

	$output = sprintf('	 
		<div %1$s class="bullet-list %2$s">
		%3$s
		</div>
	', $id_attr, trim($list_style ." ". $class ." ". $icon), $content );

	return $output;
	}
}
add_shortcode('rt_bullet_list', 'rt_bullet_list');