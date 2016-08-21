<?php
$output = '';
	
	$accent_color = '#14b8c0';
	
	if ( function_exists( 'ot_get_option' ) ) {
	  $accent_color = ot_get_option('accent_color');
	}
	
	extract(shortcode_atts(array(
		'el_class' => '',
		'img_url' => '',
		'name' => 'John Doe',
		'position' => 'Designer',
		'css_animation' => '',
		'css_animation_delay' => ''
	), $atts));
	
	$el_class = $this->getExtraClass($el_class);
	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'team_wrapper'.$el_class, $this->settings['base']);
	$css_class .= $this->getCSSAnimation($css_animation);
	($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';
	
	if($img_url != '') {
		$img_url = wp_get_attachment_image_src( $img_url, 'full');
		$img_url = $img_url[0];
		$img = '<img class="vc_box_shadow_border vc_box_border_grey" src="'. aq_resize($img_url, 540, 580, true, true, true) .'" alt="" />';
	} else {
		$img = '';
	}

		$output .= '<div class="'.$css_class.'"><div class="team_image">'.$img.'</div><div class="team_member_name">'.$name.'</div><div class="team_member_position">'.$position.'</div><div class="team_info">';
		$output .= wpb_js_remove_wpautop($content);
		$output .= '</div></div>';


echo $output;
