/**
 * Timeline container block — editor side.
 *
 * @package SimpleVerticalTimeline
 */

import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import timelineIcon from '../icons/timeline.png';

import './editor.css';
import './style.css';

const TEMPLATE = [
	[
		'svt/event',
		{
			title: __( 'First event', 'svt' ),
		},
	],
];

const timelineBlockIcon = (
	<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
		<image href={ timelineIcon } xlinkHref={ timelineIcon } x="0" y="0" width="24" height="24" preserveAspectRatio="xMidYMid meet" />
	</svg>
);

registerBlockType( 'svt/timeline', {
	icon: timelineBlockIcon,
	edit: () => {
		const blockProps = useBlockProps( {
			className: 'svt-cd-timeline svt-cd-container svt-editor-timeline',
		} );

		return (
			<div { ...blockProps }>
				<InnerBlocks
					allowedBlocks={ [ 'svt/event' ] }
					template={ TEMPLATE }
					renderAppender={ InnerBlocks.ButtonBlockAppender }
				/>
			</div>
		);
	},
	save: () => {
		// Dynamic block: markup is generated server-side in render.php.
		return <InnerBlocks.Content />;
	},
} );
