/**
 * Timeline Event block — editor side.
 *
 * @package SimpleVerticalTimeline
 */

import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import './editor.css';
import './style.css';

const COLOR_OPTIONS = [
	{ label: __( 'Green', 'svt' ), value: 'svt-cd-green' },
	{ label: __( 'Red', 'svt' ), value: 'svt-cd-red' },
	{ label: __( 'Blue', 'svt' ), value: 'svt-cd-blue' },
	{ label: __( 'Yellow', 'svt' ), value: 'svt-cd-yellow' },
];

registerBlockType( 'svt/event', {
	edit: ( { attributes, setAttributes } ) => {
		const { title, eventDate, nodeColor, icon, buttonLabel, buttonLink } =
			attributes;

		const blockProps = useBlockProps( {
			className: 'svt-cd-timeline-block svt-editor-event',
		} );

		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Event settings', 'svt' ) }>
						<TextControl
							label={ __( 'Title', 'svt' ) }
							value={ title }
							onChange={ ( value ) =>
								setAttributes( { title: value } )
							}
						/>
						<TextControl
							label={ __( 'Date', 'svt' ) }
							help={ __( 'Free text, e.g. "2026-08-23" or "March 2012"', 'svt' ) }
							value={ eventDate }
							onChange={ ( value ) =>
								setAttributes( { eventDate: value } )
							}
						/>
						<SelectControl
							label={ __( 'Node color', 'svt' ) }
							value={ nodeColor }
							options={ COLOR_OPTIONS }
							onChange={ ( value ) =>
								setAttributes( { nodeColor: value } )
							}
						/>
						<TextControl
							label={ __( 'Icon URL', 'svt' ) }
							help={ __( 'Leave empty for the default pin icon', 'svt' ) }
							value={ icon }
							onChange={ ( value ) =>
								setAttributes( { icon: value } )
							}
						/>
						<TextControl
							label={ __( 'Button label', 'svt' ) }
							value={ buttonLabel }
							onChange={ ( value ) =>
								setAttributes( { buttonLabel: value } )
							}
						/>
						<TextControl
							label={ __( 'Button link', 'svt' ) }
							help={ __( 'Optional. Invalid URLs are dropped at render time.', 'svt' ) }
							value={ buttonLink }
							onChange={ ( value ) =>
								setAttributes( { buttonLink: value } )
							}
						/>
					</PanelBody>
				</InspectorControls>

				<div { ...blockProps }>
					<div
						className={ `svt-cd-timeline-img ${ nodeColor }` }
					>
						<span className="svt-editor-event-pin" aria-hidden="true" />
					</div>
					<div className="svt-cd-timeline-content">
						<strong className="svt-editor-event-title">
							{ title || __( 'Timeline event', 'svt' ) }
						</strong>
						{ eventDate && (
							<span className="svt-cd-date">{ eventDate }</span>
						) }
						<InnerBlocks
							template={ [
								[
									'core/paragraph',
									{
										placeholder: __(
											'Write the event description…',
											'svt'
										),
									},
								],
							] }
						/>
					</div>
				</div>
			</>
		);
	},
	save: () => {
		// Dynamic block: markup is generated server-side in render.php.
		return <InnerBlocks.Content />;
	},
} );
