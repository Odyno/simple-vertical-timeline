/**
 * Timeline container block — editor side.
 *
 * @package SimpleVerticalTimeline
 */

import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

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

registerBlockType( 'svt/timeline', {
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
