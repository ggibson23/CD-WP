<?php
$output = $color = $size = $icon = $target = $link = $el_class = $title = $a_href = $a_title = $a_target = $a_rel = '';
	extract(shortcode_atts(array(
		'color' => 'btn_themecolor',
		'size' => '',
		'icon_name' => '',
		'link' => '',
		'button_style' => '',
		'el_class' => '',
		'title' => __('Text on the button', 'core-extend'),
		'css_animation' => '',
		'css_animation_delay' => ''
	), $atts));
	$a_class = '';

	if ( $el_class != '' ) {
		$tmp_class = explode(" ", strtolower($el_class));
		$tmp_class = str_replace(".", "", $tmp_class);
		if ( in_array("prettyphoto", $tmp_class) ) {
			wp_enqueue_script( 'prettyphoto' );
			wp_enqueue_style( 'prettyphoto' );
			$a_class .= ' prettyphoto';
			$el_class = str_ireplace("prettyphoto", "", $el_class);
		}
		if ( in_array("pull-right", $tmp_class) && $link != '' ) { $a_class .= ' pull-right'; $el_class = str_ireplace("pull-right", "", $el_class); }
		if ( in_array("pull-left", $tmp_class) && $link != '' ) { $a_class .= ' pull-left'; $el_class = str_ireplace("pull-left", "", $el_class); }
	}

	//parse link
	$link = ( '||' === $link ) ? '' : $link;
	$link = vc_build_link( $link );
	$use_link = false;
	if ( strlen( $link['url'] ) > 0 ) {
		$use_link = true;
		$a_href = $link['url'];
		$a_title = $link['title'];
		$a_target = $link['target'];
		$a_rel = $link['rel'];
	}
	
	$link_attributes = array();
	
	if ( $use_link ) {
	$link_attributes[] = 'href="' . trim( $a_href ) . '"';
	$link_attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
	if ( ! empty( $a_target ) ) {
		$link_attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
	}
	if ( ! empty( $a_rel ) ) {
		$link_attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
	}
	}
	
	$link_attributes = implode( ' ', $link_attributes );

	$color = ( $color != '' ) ? ' wpb_'.$color : '';
	$size = ( $size != '' && $size != 'wpb_regularsize' ) ? ' wpb_'.$size : ' '.$size;
	$i_icon = ( $icon_name != '' ) ? ' <i class="fa '. $icon_name .'"></i>' : '';
	$button_style = ( $button_style != '' ) ? ' wpb_btn-minimal' : '';
	$el_class = $this->getExtraClass($el_class);
	
	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_button'.$color.$size.$el_class.$button_style, $this->settings['base']);
	$css_class .= $this->getCSSAnimation($css_animation);
	($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';


	if ( $use_link ) {
		$output .= '<span class="'.$css_class.'">'.$i_icon.$title.'</span>';
		$output = '<a class="wpb_button_a'.$a_class.'" ' .$link_attributes. '>' . $output . '</a>';
	} else {
		$output .= '<button class="'.$css_class.'">'.$i_icon.$title.'</button>';
	}

echo $output . $this->endBlockComment('button') . "\n";