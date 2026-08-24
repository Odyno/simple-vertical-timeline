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
$svt_date_raw     = isset( $attributes['eventDate'] ) ? $attributes['eventDate'] : '';
$svt_class        = isset( $attributes['nodeColor'] ) ? $attributes['nodeColor'] : 'svt-cd-green';
$svt_icon         = ! empty( $attributes['icon'] ) ? $attributes['icon'] : '';
$svt_icon_preset  = isset( $attributes['iconPreset'] ) ? $attributes['iconPreset'] : '';
$svt_button_label = isset( $attributes['buttonLabel'] ) ? $attributes['buttonLabel'] : '';
$svt_button_link  = isset( $attributes['buttonLink'] ) ? $attributes['buttonLink'] : '';
$svt_title_class  = isset( $attributes['titleClass'] ) ? $attributes['titleClass'] : '';

$svt_default_icon = plugins_url( 'img/cd-icon-location.svg', dirname( __DIR__, 3 ) . '/simple-vertical-timeline.php' );

$svt_date = trim( (string) $svt_date_raw );
if ( preg_match( '/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', $svt_date, $svt_date_match ) ) {
	$svt_day   = str_pad( $svt_date_match[1], 2, '0', STR_PAD_LEFT );
	$svt_month = str_pad( $svt_date_match[2], 2, '0', STR_PAD_LEFT );
	$svt_year  = $svt_date_match[3];
	$svt_date  = $svt_day . '.' . $svt_month . '.' . $svt_year;
}

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
$svt_out .= '<div class="svt-cd-timeline-img ' . esc_attr( $svt_class ) . '" aria-hidden="true">';
if ( ! empty( $svt_icon ) ) {
	$svt_out .= '<img src="' . esc_url( $svt_icon ) . '" alt="">';
} elseif ( ! empty( $svt_icon_preset ) ) {
	$svt_icon_class = sanitize_html_class( $svt_icon_preset );
	$svt_out       .= '<span class="dashicons ' . esc_attr( $svt_icon_class ) . '"></span>';
} else {
	$svt_out .= '<img src="' . esc_url( $svt_default_icon ) . '" alt="">';
}
$svt_out .= '</div><!-- svt-cd-timeline-img -->';
$svt_out .= '<article class="svt-cd-timeline-content" aria-label="' . esc_attr( $svt_title ) . '">';
$svt_out .= '<h2 class="svt-cd-timeline-content-title ' . esc_attr( trim( $svt_title_class ) ) . '">' . esc_html( $svt_title ) . '</h2>';
if ( '' !== $svt_date ) {
	$svt_out .= '<p class="svt-cd-date svt-cd-date-subtitle">' . esc_html( $svt_date ) . '</p>';
}
$svt_out .= '<div class="svt-cd-timeline-content-body">' . wp_kses_post( $content ) . '</div>';
$svt_out .= '<div class="svt-cd-timeline-content-meta">';
if ( $svt_buttons ) {
	$svt_out .= '<span class="svt-cd-timeline-content-btm-more">' . $svt_buttons . '</span>';
}
$svt_out .= '</div>';
$svt_out .= '</article><!-- svt-cd-timeline-content -->';
$svt_out .= '</div><!-- svt-cd-timeline-block -->';

echo $svt_out;
