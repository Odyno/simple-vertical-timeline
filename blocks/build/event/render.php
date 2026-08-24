<?php
/**
 * Server-side rendering for the Timeline Event block.
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

if ( ! function_exists( 'svt_normalize_bootstrap_icon_class' ) ) {
	/**
	 * Normalize any icon input to a valid Bootstrap Icons class token.
	 *
	 * @param string $value Raw icon class/name.
	 * @return string
	 */
	function svt_normalize_bootstrap_icon_class( $value ) {
		$clean = strtolower( trim( (string) $value ) );
		$clean = preg_replace( '/\s+/', '', $clean );
		$clean = preg_replace( '/[^a-z0-9\-]/', '', $clean );

		if ( '' === $clean ) {
			return 'bi-geo-alt-fill';
		}

		if ( 0 === strpos( $clean, 'bi-' ) ) {
			return $clean;
		}

		return 'bi-' . $clean;
	}
}

$svt_title       = isset( $attributes['title'] ) ? $attributes['title'] : '';
$svt_date_raw    = isset( $attributes['eventDate'] ) ? $attributes['eventDate'] : '';
$svt_icon_mode   = isset( $attributes['iconMode'] ) ? $attributes['iconMode'] : 'library';
$svt_icon_url    = ! empty( $attributes['icon'] ) ? $attributes['icon'] : '';
$svt_icon_class  = isset( $attributes['iconClass'] ) ? $attributes['iconClass'] : '';
$svt_icon_color  = isset( $attributes['iconColor'] ) ? sanitize_hex_color( $attributes['iconColor'] ) : '';
$svt_title_class = isset( $attributes['titleClass'] ) ? $attributes['titleClass'] : '';
$svt_date_class  = isset( $attributes['dateClass'] ) ? $attributes['dateClass'] : '';

$svt_date = trim( (string) $svt_date_raw );
if ( preg_match( '/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', $svt_date, $svt_date_match ) ) {
	$svt_day   = str_pad( $svt_date_match[1], 2, '0', STR_PAD_LEFT );
	$svt_month = str_pad( $svt_date_match[2], 2, '0', STR_PAD_LEFT );
	$svt_year  = $svt_date_match[3];
	$svt_date  = $svt_day . '.' . $svt_month . '.' . $svt_year;
}

$svt_icon_class = svt_normalize_bootstrap_icon_class( $svt_icon_class );

$svt_marker_style_attr = '';
if ( ! empty( $svt_icon_color ) ) {
	$svt_marker_style_attr = ' style="color:' . esc_attr( $svt_icon_color ) . '"';
}

$svt_anchor = sanitize_title( $svt_title );

$svt_title_class_safe = implode(
	' ',
	array_map( 'sanitize_html_class', preg_split( '/\s+/', trim( (string) $svt_title_class ) ) )
);
$svt_date_class_safe = implode(
	' ',
	array_map( 'sanitize_html_class', preg_split( '/\s+/', trim( (string) $svt_date_class ) ) )
);

$svt_title_classes = trim( 'svt-cd-timeline-content-title ' . $svt_title_class_safe );
$svt_date_classes  = trim( 'svt-cd-date svt-cd-date-subtitle ' . $svt_date_class_safe );

$svt_out  = '<div class="svt-cd-timeline-block">';
$svt_out .= '<a class="svt-cd-timeline-anchor" name="' . esc_attr( $svt_anchor ) . '"></a>';
$svt_out .= '<div class="svt-cd-timeline-img svt-cd-green" aria-hidden="true"' . $svt_marker_style_attr . '>';
if ( 'image' === $svt_icon_mode && ! empty( $svt_icon_url ) ) {
	$svt_out .= '<img src="' . esc_url( $svt_icon_url ) . '" alt="">';
} elseif ( ! empty( $svt_icon_url ) && filter_var( $svt_icon_url, FILTER_VALIDATE_URL ) ) {
	$svt_out .= '<img src="' . esc_url( $svt_icon_url ) . '" alt="">';
} else {
	$svt_out .= '<i class="svt-bi bi ' . esc_attr( $svt_icon_class ) . '"></i>';
}
$svt_out .= '</div><!-- svt-cd-timeline-img -->';
$svt_out .= '<article class="svt-cd-timeline-content" aria-label="' . esc_attr( $svt_title ) . '">';
$svt_out .= '<h2 class="' . esc_attr( $svt_title_classes ) . '">' . esc_html( $svt_title ) . '</h2>';
if ( '' !== $svt_date ) {
	$svt_out .= '<p class="' . esc_attr( $svt_date_classes ) . '">' . esc_html( $svt_date ) . '</p>';
}
$svt_out .= '<div class="svt-cd-timeline-content-body">' . wp_kses_post( $content ) . '</div>';
$svt_out .= '</article><!-- svt-cd-timeline-content -->';
$svt_out .= '</div><!-- svt-cd-timeline-block -->';

echo $svt_out;
