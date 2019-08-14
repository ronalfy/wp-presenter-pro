import axios from 'axios';
import classnames from 'classnames';
import revealFonts from '../fonts/fonts.js';
import transitionOptions from '../transitions/transitions.js';

const { Component, Fragment } = wp.element;
const { withSelect } = wp.data;
const { __, _x } = wp.i18n;
const { compose } =  wp.compose;


const {
	PanelBody,
	Placeholder,
	SelectControl,
	TextControl,
	Toolbar,
	ToggleControl,
	Button,
	RangeControl,
	ButtonGroup,
	PanelRow,
	Spinner,
} = wp.components;

const {
	BlockControls,
	MediaUpload
} = wp.editor;

const {
	InspectorControls,
	RichText,
	PanelColorSettings
} = wp.blockEditor;


class WP_Presenter_Pro_Text_Box extends Component {

	constructor() {

		super( ...arguments );
	};

	render() {
		const { post, setAttributes } = this.props;
		const { textColor, padding, title, font, transitions} = this.props.attributes;

		let slideStyles = {
			color: textColor,
			padding: padding + 'px',
			fontFamily: `${font}`
		};

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'WP Presenter Pro Text Box', 'wp-presenter-pro' ) }>
						<PanelColorSettings
							title={ __( 'Text Color', 'wp-presenter-pro' ) }
							initialOpen={ true }
							colorSettings={ [ {
								value: textColor,
								onChange: ( value ) => {
									setAttributes( { textColor: value});
								},
								label: __( 'Text Color', 'wp-presenter-pro' ),
							} ] }
						>
						</PanelColorSettings>
						<SelectControl
								label={ __( 'Select a Font', 'user-profile-picture-enhanced' ) }
								value={font}
								options={ revealFonts }
								onChange={ ( value ) => {
									setAttributes( {font: value} );
								} }
						/>
						<SelectControl
								label={ __( 'Select a Transition', 'user-profile-picture-enhanced' ) }
								value={transitions}
								options={ transitionOptions }
								onChange={ ( value ) => {
									setAttributes( {transitions: value} );
								} }
						/>

						<RangeControl
							label={ __( 'Padding', 'wp-presenter-pro' ) }
							value={ padding }
							onChange={ ( value ) => setAttributes( { padding: value } ) }
							min={ 0 }
							max={ 100 }
							step={ 1 }
						/>
					</PanelBody>
				</InspectorControls>
				<Fragment>
					<div className={ classnames(
							'wp-presenter-pro-text-box'
						) }
						style={slideStyles}
					>
						<RichText
							placeholder={__('Enter some text here!', 'wp-presenter-pro')}
							value={ title }
							onChange={ ( content ) => setAttributes( { title: content } ) }
						/>
					</div>
				</Fragment>
			</Fragment>
		);
	}
}
export default WP_Presenter_Pro_Text_Box;