const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { Component, Fragment } = wp.element;
import edit from './edit';

/**
 * Register Basic Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made available as an option to any
 * editor interface where blocks are implemented.
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'wppp/blockquote', {
	title: __( 'Blockquote', 'wp-presenter-pro' ), // Block title.
	icon: <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/><path d="M0 0h24v24H0z" fill="none"/></svg>,
	description: __( 'Add flashy blockquotes to your presentation.', 'wp-presenter-pro' ),
	category: 'wp-presenter-pro',
	keywords: [
		__( 'slide', 'wp-presenter-pro' ),
		__( 'blockquote', 'wp-presenter-pro' ),
	],
	edit: edit,
	save() {return null },
	example: {
		attributes: {
			backgroundType: 'gradient',
			backgroundGradient: 'linear-gradient(-225deg, rgb(255, 5, 124) 0%, rgb(141, 11, 147) 50%, rgb(50, 21, 117) 100%)',
			align: 'center',
			quoteStyle: 'quotes',
			paddingTop: 30,
			paddingBottom: 30,
			blockquoteAlign: 'center',
			textColor: '#FFFFFF',
			content: __( 'An inspiring quote...', 'wp-presenter-pro' ),
		},
	},
} );