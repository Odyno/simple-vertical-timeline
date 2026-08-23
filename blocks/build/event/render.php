<?php
/**
 * Server-side rendering for the Timeline Event block.
 *
 * Reuses the same output structure as the legacy [svt-event] shortcode
 * so frontend rendering is identical between blocks and shortcodes.
 *
 * @package SimpleVerticalTimeline
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block inner content (event body).
 * @param WP_Block $block      Block instance.
 * @return string
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$svt_title        = isset( $attributes['title'] ) ? $attributes['title'] : '';
$svt_date         = isset( $attributes['eventDate'] ) ? $attributes['eventDate'] : '';
$svt_class        = isset( $attributes['nodeColor'] ) ? $attributes['nodeColor'] : 'svt-cd-green';
$svt_icon         = ! empty( $attributes['icon'] ) ? $attributes['icon'] : plugins_url( 'img/cd-icon-location.svg', dirname( __DIR__, 3 ) . '/simple-vertical-timeline.php' );
$svt_button_label = isset( $attributes['buttonLabel'] ) ? $attributes['buttonLabel'] : '';
$svt_button_link  = isset( $attributes['buttonLink'] ) ? $attributes['buttonLink'] : '';

// Build optional "read more" button (same escaping rules as shortcode).
$svt_buttons = '';
if ( ! empty( $svt_button_link ) ) {
	$svt_safe_link = esc_url( $svt_button_link );
	if ( ! empty( $svt_safe_link ) ) {
		$svt_buttons = '<a href="' . $svt_safe_link . '" class="svt-cd-read-more" target="_blank" rel="noopener noreferrer">' . esc_html( $svt_button_label ? $svt_button_label : __( 'More', 'svt' ) ) . '</a>';
	}
}

$svt_anchor = sanitize_title( $svt_title );

$svt_out  = '<div class="svt-cd-timeline-block">';
$svt_out .= '<a class="svt-cd-timeline-anchor" name="' . esc_attr( $svt_anchor ) . '"></a>';
$svt_out .= '<div class="svt-cd-timeline-img ' . esc_attr( $svt_class ) . '">';
$svt_out .= '<img src="' . esc_url( $svt_icon ) . '" alt="' . esc_attr__( 'Picture', 'svt' ) . '">';
$svt_out .= '</div><!-- svt-cd-timeline-img -->';
$svt_out .= '<div class="svt-cd-timeline-content">';
$svt_out .= '<h2 class="svt-cd-timeline-content-title">' . esc_html( $svt_title ) . '</h2>';
$svt_out .= '<div class="svt-cd-timeline-content-body">' . wp_kses_post( $content ) . '</div>';
if ( $svt_buttons ) {
	$svt_out .= '<p class="svt-cd-timeline-content-btm-more">' . $svt_buttons . '</p>';
}
$svt_out .= '<span class="svt-cd-date">' . esc_html( $svt_date ) . '</span>';
$svt_out .= '</div><!-- svt-cd-timeline-content -->';
$svt_out .= '</div><!-- svt-cd-timeline-block -->';

return $svt_out;
