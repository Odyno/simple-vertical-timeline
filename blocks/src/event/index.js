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

const ICON_PRESET_OPTIONS = [
	{ label: __( 'Default pin icon', 'svt' ), value: '' },
	{ label: __( 'Location', 'svt' ), value: 'dashicons-location' },
	{ label: __( 'Location Alt', 'svt' ), value: 'dashicons-location-alt' },
	{ label: __( 'Calendar', 'svt' ), value: 'dashicons-calendar-alt' },
	{ label: __( 'Flag', 'svt' ), value: 'dashicons-flag' },
	{ label: __( 'Star', 'svt' ), value: 'dashicons-star-filled' },
	{ label: __( 'Clock', 'svt' ), value: 'dashicons-clock' },
	{ label: __( 'Admin Site', 'svt' ), value: 'dashicons-admin-site' },
];

const ICON_PRESET_GLYPHS = {
	'dashicons-location': '⌖',
	'dashicons-location-alt': '⌖',
	'dashicons-calendar-alt': '🗓',
	'dashicons-flag': '⚑',
	'dashicons-star-filled': '★',
	'dashicons-clock': '◷',
	'dashicons-admin-site': '⌂',
};

const getEditorPresetGlyph = ( preset ) => ICON_PRESET_GLYPHS[ preset ] || '⌖';

const normalizeEventDate = ( rawDate ) => {
	if ( ! rawDate ) {
		return '';
	}

	const match = String( rawDate ).trim().match( /^(\d{1,2})\.(\d{1,2})\.(\d{4})$/ );
	if ( ! match ) {
		return rawDate;
	}

	const day = match[ 1 ].padStart( 2, '0' );
	const month = match[ 2 ].padStart( 2, '0' );
	const year = match[ 3 ];
	return `${ day }.${ month }.${ year }`;
};

registerBlockType( 'svt/event', {
	edit: ( { attributes, setAttributes } ) => {
		const {
			title,
			eventDate,
			nodeColor,
			icon,
			iconPreset,
			buttonLabel,
			buttonLink,
			titleClass,
		} = attributes;

		const blockProps = useBlockProps( {
			className: 'svt-cd-timeline-block svt-editor-event',
		} );
		const displayDate = normalizeEventDate( eventDate );

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
						<SelectControl
							label={ __( 'WordPress icon', 'svt' ) }
							help={ __( 'Built-in dashicon. Icon URL overrides this if both are set.', 'svt' ) }
							value={ iconPreset }
							options={ ICON_PRESET_OPTIONS }
							onChange={ ( value ) =>
								setAttributes( { iconPreset: value } )
							}
						/>
						<TextControl
							label={ __( 'Icon URL', 'svt' ) }
							help={ __( 'Optional custom icon URL. Leave empty to use preset/default.', 'svt' ) }
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
						<TextControl
							label={ __( 'Title CSS class', 'svt' ) }
							help={ __( 'Additional CSS class(es) for the event title', 'svt' ) }
							value={ titleClass }
							onChange={ ( value ) =>
								setAttributes( { titleClass: value } )
							}
						/>
					</PanelBody>
				</InspectorControls>

				<div { ...blockProps }>
					<div
						className={ `svt-cd-timeline-img ${ nodeColor }` }
						aria-hidden="true"
					>
						{ icon ? (
							<img
								className="svt-editor-event-icon"
								src={ icon }
								alt=""
							/>
						) : (
							<span className="svt-editor-event-glyph" aria-hidden="true">
								{ getEditorPresetGlyph( iconPreset ) }
							</span>
						) }
					</div>
					<div className="svt-cd-timeline-content">
						<strong className="svt-editor-event-title">
							{ title || __( 'Timeline event title', 'svt' ) }
						</strong>
						{ displayDate && (
							<p className="svt-cd-date svt-cd-date-subtitle svt-editor-date">
								{ displayDate }
							</p>
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
