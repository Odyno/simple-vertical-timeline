/**
 * Timeline Event block — editor side.
 *
 * @package SimpleVerticalTimeline
 */

import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, PanelColorSettings, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import timeeventIcon from '../icons/timeevent.png';

import './editor.css';
import './style.css';

const ICON_MODE_OPTIONS = [
	{ label: __( 'External library (Bootstrap Icons)', 'svt' ), value: 'library' },
	{ label: __( 'Image URL', 'svt' ), value: 'image' },
];

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

const normalizeIconClass = ( value ) => {
	const raw = String( value || '' ).toLowerCase().trim();
	if ( ! raw ) {
		return 'bi-geo-alt-fill';
	}

	const token = raw
		.split( /\s+/ )
		.find( ( item ) => /^bi-[a-z0-9-]+$/.test( item ) );
	if ( token ) {
		return token;
	}

	const compact = raw
		.replace( /[^a-z0-9-]/g, '' )
		.replace( /^bi-?/, '' );

	if ( ! compact ) {
		return 'bi-geo-alt-fill';
	}

	return `bi-${ compact }`;
};

const iconInputValue = ( iconClass ) => normalizeIconClass( iconClass ).replace( /^bi-/, '' );

const timeeventBlockIcon = (
	<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
		<image href={ timeeventIcon } xlinkHref={ timeeventIcon } x="0" y="0" width="24" height="24" preserveAspectRatio="xMidYMid meet" />
	</svg>
);

registerBlockType( 'svt/event', {
	icon: timeeventBlockIcon,
	edit: ( { attributes, setAttributes } ) => {
		const { title, eventDate, icon, iconMode, iconClass, iconColor, markerBgColor, titleClass, dateClass } = attributes;
		const displayDate = normalizeEventDate( eventDate );
		const currentMode = iconMode || 'library';
		const currentIconClass = normalizeIconClass( iconClass );

		const blockProps = useBlockProps( {
			className: 'svt-cd-timeline-block svt-editor-event',
		} );

		const markerStyle = {
			...( iconColor ? { color: iconColor } : {} ),
			...( markerBgColor ? { backgroundColor: markerBgColor } : {} ),
		};

		const titleClasses = `svt-editor-event-title ${ titleClass || '' }`.trim();
		const dateClasses = `svt-cd-date svt-cd-date-subtitle svt-editor-date ${ dateClass || '' }`.trim();

		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Event settings', 'svt' ) }>
						<TextControl
							label={ __( 'Title', 'svt' ) }
							value={ title }
							onChange={ ( value ) => setAttributes( { title: value } ) }
						/>
						<TextControl
							label={ __( 'Date', 'svt' ) }
							help={ __( 'Free text, e.g. "2026-08-23" or "March 2012"', 'svt' ) }
							value={ eventDate }
							onChange={ ( value ) => setAttributes( { eventDate: value } ) }
						/>
						<SelectControl
							label={ __( 'Icon source', 'svt' ) }
							value={ currentMode }
							options={ ICON_MODE_OPTIONS }
							onChange={ ( value ) => setAttributes( { iconMode: value } ) }
						/>
						{ currentMode === 'library' ? (
							<TextControl
								label={ __( 'Bootstrap icon name', 'svt' ) }
								help={ __( 'Insert only the icon name, without prefix (e.g. geo-alt-fill).', 'svt' ) }
								value={ iconInputValue( currentIconClass ) }
								onChange={ ( value ) => setAttributes( { iconClass: normalizeIconClass( value ) } ) }
							/>
						) : (
							<TextControl
								label={ __( 'Icon image URL', 'svt' ) }
								help={ __( 'Absolute URL to an image icon (SVG/PNG).', 'svt' ) }
								value={ icon }
								onChange={ ( value ) => setAttributes( { icon: value } ) }
							/>
						) }
						<TextControl
							label={ __( 'Title CSS class', 'svt' ) }
							value={ titleClass || '' }
							onChange={ ( value ) => setAttributes( { titleClass: value } ) }
						/>
						<TextControl
							label={ __( 'Date CSS class', 'svt' ) }
							value={ dateClass || '' }
							onChange={ ( value ) => setAttributes( { dateClass: value } ) }
						/>
					</PanelBody>
					<PanelColorSettings
						title={ __( 'Icon colors', 'svt' ) }
						colorSettings={ [
							{
								value: iconColor,
								onChange: ( value ) => setAttributes( { iconColor: value || '' } ),
								label: __( 'Icon color', 'svt' ),
							},
							{
								value: markerBgColor,
								onChange: ( value ) => setAttributes( { markerBgColor: value || '' } ),
								label: __( 'Icon circle background', 'svt' ),
							},
						] }
					/>
				</InspectorControls>

				<div { ...blockProps }>
					<div className="svt-cd-timeline-img svt-cd-green" style={ markerStyle } aria-hidden="true">
						{ currentMode === 'image' && icon ? (
							<img className="svt-editor-event-icon" src={ icon } alt="" />
						) : (
							<i className={ `svt-bi bi ${ currentIconClass }` } aria-hidden="true" />
						) }
					</div>
					<div className="svt-cd-timeline-content">
						<strong className={ titleClasses }>{ title || __( 'Timeline event title', 'svt' ) }</strong>
						{ displayDate && <p className={ dateClasses }>{ displayDate }</p> }
						<InnerBlocks
							template={ [
								[
									'core/paragraph',
									{ placeholder: __( 'Write the event description…', 'svt' ) },
								],
							] }
						/>
					</div>
				</div>
			</>
		);
	},
	save: () => <InnerBlocks.Content />,
} );
