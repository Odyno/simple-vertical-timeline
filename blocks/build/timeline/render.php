<?php
/**
 * Server-side rendering for the Timeline container block.
 *
 * @package SimpleVerticalTimeline
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block content (inner events HTML).
 * @param WP_Block $block      Block instance.
 * @return string
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Simple wrapper without get_block_wrapper_attributes (which can fail in some contexts)
$svt_out  = '<div class="svt-cd-timeline svt-cd-container wp-block-svt-timeline">';
$svt_out .= $content;
$svt_out .= '</div><!-- svt-cd-timeline -->';

if ( class_exists( 'SVT_Settings' ) ) {
	$svt_out .= '<div style="' . esc_attr( SVT_Settings::get_sign() ) . '">powered by <a href="http://www.staniscia.net/simple-vertical-timeline/" target="_blank" rel="noopener noreferrer">SimpleVerticalTimeline</a>' . SVT_Settings::get_contrib() . '</div>';
}

return $svt_out;
