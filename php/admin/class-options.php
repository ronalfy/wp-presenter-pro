<?php
/**
 * Admin Options for WP Presenter Pro
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro\Admin;

/**
 * Class Admin
 */
class Options {

	/**
	 * Get admin options.
	 *
	 * @var array $options Store the options.
	 */
	private $options = array();

	/**
	 * Initialize the Options component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	/**
	 * Register the admin sub-menu.
	 */
	public function register_menu() {
		add_submenu_page(
			'edit.php?post_type=wppp',
			__( 'Options', 'wp-presenter-pro' ),
			__( 'Options', 'textdomain' ),
			'manage_options',
			'wp-presenter-pro-options',
			array( $this, 'output_options' )
		);
	}

	/**
	 * Output the options necessary for this pliugin.
	 */
	public function output_options() {
		$options = $this->get_options( true );
		if ( isset( $_POST['wppp_options_nonce'] ) ) {
			$post_vars = filter_input_array( INPUT_POST );
			if ( wp_verify_nonce( $post_vars['wppp_options_nonce'], 'save_wppp_options' ) && current_user_can( 'manage_options' ) ) {
				$options['blocks']         = sanitize_text_field( $post_vars['wppp-block-select'] );
				$options['post_type_slug'] = sanitize_title( $post_vars['wppp-post-type-slug'] );
				$options['taxonomy_slug']  = sanitize_title( $post_vars['wppp-taxonomy-slug'] );
				update_option( 'wp-presenter-pro-admin-options', $options );
				$this->options = $options;
				$this->show_admin_message(
					esc_html__( 'Settings Saved!', 'wp-presenter-pro' ),
					esc_html__( 'Your settings have been saved.', 'wp-presenter-pro' ),
					'notice-success'
				);
				update_option( 'wp_presenter_pro_permalinks_flushed', 0 );
			} else {
				$this->show_admin_message(
					esc_html__( 'Settings could not be saved!', 'wp-presenter-pro' ),
					esc_html__( 'Your settings have not been saved because the nonce could not be verified.', 'wp-presenter-pro' )
				);
			}
		}
		?>
		<div class="wrap">
			<h1><img src="<?php echo esc_url( WP_PRESENTER_PRO_URL . '/images/wp-presenter-pro-icon.png' ); ?>" width="25" height="25" alt="WP Presenter Pro Icon" /> <?php esc_html_e( 'WP Presenter Pro Options', 'wp-presenter-pro' ); ?></h1>
			<h2><?php esc_html_e( 'WP Presenter Pro Options', 'wp-presenter-pro' ); ?></h2>
			<hr />
			<form method="POST">
				<?php
				wp_nonce_field( 'save_wppp_options', 'wppp_options_nonce' );
				?>
				<fieldset>
					<legend><h3><?php esc_html_e( 'Toggle Blocks', 'wp-presenter-pro' ); ?></h3></legend>
					<input type="radio" name="wppp-block-select" id="wppp-radio-all-blocks" value="all" <?php checked( 'all', $options['blocks'] ); ?> />&nbsp;<label for="wppp-radio-all-blocks"><?php esc_html_e( 'Enable All Blocks', 'wp-presenter-pro' ); ?></label>
					<br />
					<input type="radio" name="wppp-block-select" id="wppp-radio-curated-blocks" value="curated" <?php checked( 'curated', $options['blocks'] ); ?> />&nbsp;<label for="wppp-radio-curated-blocks"><?php esc_html_e( 'Enable Curated Blocks Only (Recommended)', 'wp-presenter-pro' ); ?></label>
				</fieldset>
				<fieldset>
					<legend><h3><?php esc_html_e( 'Change Slugs', 'wp-presenter-pro' ); ?></h3></legend>
					<p>
						<label for="wppp-post-type-slug"><?php esc_html_e( 'Enter the post type slug for your slides.', 'wp-presenter-pro' ); ?></label><br />
						<input type="text" class="regular-text" name="wppp-post-type-slug" id="wppp-post-type-slug" value="<?php echo esc_attr( $options['post_type_slug'] ); ?>" />
					</p>
					<p>
						<label for="wppp-taxonomy-slug"><?php esc_html_e( 'Enter the taxonomy slug for your slides.', 'wp-presenter-pro' ); ?></label><br />
						<input type="text" class="regular-text" name="wppp-taxonomy-slug" id="wppp-taxonomy-slug" value="<?php echo esc_attr( $options['taxonomy_slug'] ); ?>" />
					</p>
				</fieldset>
				<?php submit_button(); ?>
				</form>
				<hr />
				<h3><?php esc_html_e( 'Gradients', 'wp-presenter-pro' ); ?></h3>
				<p><?php esc_html_e( 'Requires an up-to-date Gutenberg plugin.', 'wp-presenter-pro' ); ?></p>
				<p>
					<?php /* translators: %s is the URL to webgradients.com */ ?>
					<?php echo wp_kses_post( sprintf( __( 'Gradients from %s', 'wp-presenter-pro' ), '<a href="https://webgradients.com/">WebGradients.com</a>' ) ); ?>
				</p>
				<?php
				$gradients = array(
					'linear-gradient(45deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%)' => 'Warm Flame',
					'linear-gradient(to top, #a18cd1 0%, #fbc2eb 100%)' => 'Night Fade',
					'linear-gradient(to top, #fad0c4 0%, #ffd1ff 100%)' => 'Spring Warmth',
					'linear-gradient(to right, #ffecd2 0%, #fcb69f 100%)' => 'Juicy Peach',
					'linear-gradient(to right, #ff8177 0%, #ff867a 0%, #ff8c7f 21%, #f99185 52%, #cf556c 78%, #b12a5b 100%)' => 'Young Passion',
					'linear-gradient(to top, #ff9a9e 0%, #fecfef 99%, #fecfef 100%)' => 'Lady Lips',
					'linear-gradient(120deg, #f6d365 0%, #fda085 100%)' => 'Sunny Morning',
					'linear-gradient(to top, #fbc2eb 0%, #a6c1ee 100%)' => 'Rainy Ashville',
					'linear-gradient(to top, #fdcbf1 0%, #fdcbf1 1%, #e6dee9 100%)' => 'Frozen Dreams',
					'linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%)' => 'Winter Neva',
					'linear-gradient(120deg, #d4fc79 0%, #96e6a1 100%)' => 'Dusty Grass',
					'linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%)' => 'Tempting Azure',
					'linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%)' => 'Heavy Rain',
					'linear-gradient(120deg, #a6c0fe 0%, #f68084 100%)' => 'Amy Crisp',
					'linear-gradient(120deg, #fccb90 0%, #d57eeb 100%)' => 'Mean Fruit',
					'linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%)' => 'Deep Blue',
					'linear-gradient(120deg, #f093fb 0%, #f5576c 100%)' => 'Ripe Malinka',
					'linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%)' => 'Cloudy Knoxville',
					'linear-gradient(to right, #4facfe 0%, #00f2fe 100%)' => 'Malibu Beach',
					'linear-gradient(to right, #43e97b 0%, #38f9d7 100%)' => 'New Life',
					'linear-gradient(to right, #fa709a 0%, #fee140 100%)' => 'True Sunset',
					'linear-gradient(to top, #30cfd0 0%, #330867 100%)' => 'Morpheus Den',
					'linear-gradient(to top, #a8edea 0%, #fed6e3 100%)' => 'Rare Wind',
					'linear-gradient(to top, #5ee7df 0%, #b490ca 100%)' => 'Near Moon',
					'linear-gradient(to top, #d299c2 0%, #fef9d7 100%)' => 'Wild Apple',
					'linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%)' => 'Saint Petersburg',
					'radial-gradient(circle 248px at center, #16d9e3 0%, #30c7ec 47%, #46aef7 100%)' => 'Arielles Smile',
					'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' => 'Plum Plate',
					'linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%)' => 'Everlasting Sky',
					'linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%)' => 'Happy Fisher',
					'linear-gradient(to top, #fddb92 0%, #d1fdff 100%)' => 'Blessing',
					'linear-gradient(to top, #9890e3 0%, #b1f4cf 100%)' => 'Sharpeye Eagle',
					'linear-gradient(to top, #ebc0fd 0%, #d9ded8 100%)' => 'Ladoga Bottom',
					'linear-gradient(to top, #96fbc4 0%, #f9f586 100%)' => 'Lemon Gate',
					'linear-gradient(180deg, #2af598 0%, #009efd 100%)' => 'Itmeo Branding',
					'linear-gradient(to top, #cd9cf2 0%, #f6f3ff 100%)' => 'Zeus Miracle',
					'linear-gradient(to right, #e4afcb 0%, #b8cbb8 0%, #b8cbb8 0%, #e2c58b 30%, #c2ce9c 64%, #7edbdc 100%)' => 'Old Hat',
					'linear-gradient(to right, #b8cbb8 0%, #b8cbb8 0%, #b465da 0%, #cf6cc9 33%, #ee609c 66%, #ee609c 100%)' => 'Star Wine',
					'linear-gradient(to right, #6a11cb 0%, #2575fc 100%)' => 'Deep Blue',
					'linear-gradient(to top, #37ecba 0%, #72afd3 100%)' => 'Happy Acid',
					'linear-gradient(to top, #ebbba7 0%, #cfc7f8 100%)' => 'Awesome Pine',
					'linear-gradient(to top, #fff1eb 0%, #ace0f9 100%)' => 'New York',
					'linear-gradient(to right, #eea2a2 0%, #bbc1bf 19%, #57c6e1 42%, #b49fda 79%, #7ac5d8 100%)' => 'Shy Rainbow',
					'linear-gradient(to top, #c471f5 0%, #fa71cd 100%)' => 'Mixed Hopes',
					'linear-gradient(to top, #48c6ef 0%, #6f86d6 100%)' => 'Fly High',
					'linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%)' => 'Strong Bliss',
					'linear-gradient(to top, #feada6 0%, #f5efef 100%)' => 'Fresh Milk',
					'linear-gradient(to top, #e6e9f0 0%, #eef1f5 100%)' => 'Snow Again',
					'linear-gradient(to top, #accbee 0%, #e7f0fd 100%)' => 'February Ink',
					'linear-gradient(-20deg, #e9defa 0%, #fbfcdb 100%)' => 'Kind Steel',
					'linear-gradient(to top, #c1dfc4 0%, #deecdd 100%)' => 'Soft Grass',
					'linear-gradient(to top, #0ba360 0%, #3cba92 100%)' => 'Grown Early',
					'linear-gradient(to top, #00c6fb 0%, #005bea 100%)' => 'Sharp Blues',
					'linear-gradient(to right, #74ebd5 0%, #9face6 100%)' => 'Shady Water',
					'linear-gradient(to top, #6a85b6 0%, #bac8e0 100%)' => 'Dirty Beauty',
					'linear-gradient(to top, #a3bded 0%, #6991c7 100%)' => 'Great Whale',
					'linear-gradient(to top, #9795f0 0%, #fbc8d4 100%)' => 'Teen Notebook',
					'linear-gradient(to top, #a7a6cb 0%, #8989ba 52%, #8989ba 100%)' => 'Polite Rumors',
					'linear-gradient(to top, #3f51b1 0%, #5a55ae 13%, #7b5fac 25%, #8f6aae 38%, #a86aa4 50%, #cc6b8e 62%, #f18271 75%, #f3a469 87%, #f7c978 100%)' => 'Sweet Period',
					'linear-gradient(to top, #fcc5e4 0%, #fda34b 15%, #ff7882 35%, #c8699e 52%, #7046aa 71%, #0c1db8 87%, #020f75 100%)' => 'Wide Matrix',
					'linear-gradient(to top, #dbdcd7 0%, #dddcd7 24%, #e2c9cc 30%, #e7627d 46%, #b8235a 59%, #801357 71%, #3d1635 84%, #1c1a27 100%)' => 'Soft Cherish',
					'linear-gradient(to top, #f43b47 0%, #453a94 100%)' => 'Red Salvation',
					'linear-gradient(to top, #4fb576 0%, #44c489 30%, #28a9ae 46%, #28a2b7 59%, #4c7788 71%, #6c4f63 86%, #432c39 100%)' => 'Burning Spring',
					'linear-gradient(to top, #0250c5 0%, #d43f8d 100%)' => 'Night Party',
					'linear-gradient(to top, #88d3ce 0%, #6e45e2 100%)' => 'Sky Glider',
					'linear-gradient(to top, #d9afd9 0%, #97d9e1 100%)' => 'Heaven Peach',
					'linear-gradient(to top, #7028e4 0%, #e5b2ca 100%)' => 'Purple Division',
					'linear-gradient(15deg, #13547a 0%, #80d0c7 100%)' => 'Aqua Splash',
					'linear-gradient(to top, #505285 0%, #585e92 12%, #65689f 25%, #7474b0 37%, #7e7ebb 50%, #8389c7 62%, #9795d4 75%, #a2a1dc 87%, #b5aee4 100%)' => 'Spiky Naga',
					'linear-gradient(to top, #ff0844 0%, #ffb199 100%)' => 'Love Kiss',
					'linear-gradient(45deg, #93a5cf 0%, #e4efe9 100%)' => 'Clean Mirror',
					'linear-gradient(to right, #434343 0%, black 100%)' => 'Premium Dark',
					'linear-gradient(to top, #0c3483 0%, #a2b6df 100%, #6b8cce 100%, #a2b6df 100%)' => 'Cold Evening',
					'linear-gradient(45deg, #93a5cf 0%, #e4efe9 100%)' => 'Cochiti Lake',
					'linear-gradient(to right, #92fe9d 0%, #00c9ff 100%)' => 'Summer Games',
					'linear-gradient(to right, #ff758c 0%, #ff7eb3 100%)' => 'Passionate Bed',
					'linear-gradient(to right, #868f96 0%, #596164 100%)' => 'Mountain Rock',
					'linear-gradient(to top, #c79081 0%, #dfa579 100%)' => 'Desert Hump',
					'linear-gradient(45deg, #8baaaa 0%, #ae8b9c 100%)' => 'Jungle Day',
					'linear-gradient(to right, #f83600 0%, #f9d423 100%)' => 'Phoenix Start',
					'linear-gradient(-20deg, #b721ff 0%, #21d4fd 100%)' => 'October Silence',
					'linear-gradient(-20deg, #6e45e2 0%, #88d3ce 100%)' => 'Faraway River',
					'linear-gradient(-20deg, #d558c8 0%, #24d292 100%)' => 'Alchemist Lab',
					'linear-gradient(60deg, #abecd6 0%, #fbed96 100%)' => 'Over Sun',
					'linear-gradient(to top, #d5d4d0 0%, #d5d4d0 1%, #eeeeec 31%, #efeeec 75%, #e9e9e7 100%)' => 'Premium White',
					'linear-gradient(to top, #5f72bd 0%, #9b23ea 100%)' => 'Mars Party',
					'linear-gradient(to top, #09203f 0%, #537895 100%)' => 'Eternal Constance',
					'linear-gradient(-20deg, #ddd6f3 0%, #faaca8 100%, #faaca8 100%)' => 'Japan Blush',
					'linear-gradient(-20deg, #dcb0ed 0%, #99c99c 100%)' => 'Smiling Rain',
					'linear-gradient(to top, #f3e7e9 0%, #e3eeff 99%, #e3eeff 100%)' => 'Cloudy Apple',
					'linear-gradient(to top, #c71d6f 0%, #d09693 100%)' => 'Big Mango',
					'linear-gradient(60deg, #96deda 0%, #50c9c3 100%)' => 'Healthy Water',
					'linear-gradient(to top, #f77062 0%, #fe5196 100%)' => 'Amour Amour',
					'linear-gradient(to top, #c4c5c7 0%, #dcdddf 52%, #ebebeb 100%)' => 'Risky Concrete',
					'linear-gradient(to right, #a8caba 0%, #5d4157 100%)' => 'Strong Stick',
					'linear-gradient(60deg, #29323c 0%, #485563 100%)' => 'Vicious Stance',
					'linear-gradient(-60deg, #16a085 0%, #f4d03f 100%)' => 'Palo Alto',
					'linear-gradient(-60deg, #ff5858 0%, #f09819 100%)' => 'Happy Memories',
					'linear-gradient(-20deg, #2b5876 0%, #4e4376 100%)' => 'Midnight Bloom',
					'linear-gradient(-20deg, #00cdac 0%, #8ddad5 100%)' => 'Crystalline',
					'linear-gradient(to top, #4481eb 0%, #04befe 100%)' => 'Party Bliss',
					'linear-gradient(to top, #dad4ec 0%, #dad4ec 1%, #f3e7e9 100%)' => 'Confident Cloud',
					'linear-gradient(45deg, #874da2 0%, #c43a30 100%)' => 'Le Cocktail',
					'linear-gradient(to top, #4481eb 0%, #04befe 100%)' => 'River City',
					'linear-gradient(to top, #e8198b 0%, #c7eafd 100%)' => 'Frozen Berry',
					'linear-gradient(-20deg, #f794a4 0%, #fdd6bd 100%)' => 'Child Care',
					'linear-gradient(60deg, #64b3f4 0%, #c2e59c 100%)' => 'Flying Lemon',
					'linear-gradient(to top, #3b41c5 0%, #a981bb 49%, #ffc8a9 100%)' => 'New Retrowave',
					'linear-gradient(to top, #0fd850 0%, #f9f047 100%)' => 'Hidden Jaguar',
					'linear-gradient(to top, lightgrey 0%, lightgrey 1%, #e0e0e0 26%, #efefef 48%, #d9d9d9 75%, #bcbcbc 100%)' => 'Above The Sky',
					'linear-gradient(45deg, #ee9ca7 0%, #ffdde1 100%)' => 'Nega',
					'linear-gradient(to right, #3ab5b0 0%, #3d99be 31%, #56317a 100%)' => 'Dense Water',
					'linear-gradient(to top, #209cff 0%, #68e0cf 100%)' => 'Seashore',
					'linear-gradient(to top, #bdc2e8 0%, #bdc2e8 1%, #e6dee9 100%)' => 'Marble Wall',
					'linear-gradient(to top, #e6b980 0%, #eacda3 100%)' => 'Cheerful Caramel',
					'linear-gradient(to top, #1e3c72 0%, #1e3c72 1%, #2a5298 100%)' => 'Night Sky',
					'linear-gradient(to top, #d5dee7 0%, #ffafbd 0%, #c9ffbf 100%)' => 'Magic Lake',
					'linear-gradient(to top, #9be15d 0%, #00e3ae 100%)' => 'Young Grass',
					'linear-gradient(to right, #ed6ea0 0%, #ec8c69 100%)' => 'Colorful Peach',
					'linear-gradient(to right, #ffc3a0 0%, #ffafbd 100%)' => 'Gentle Care',
					'linear-gradient(to top, #cc208e 0%, #6713d2 100%)' => 'Plum Bath',
					'linear-gradient(to top, #b3ffab 0%, #12fff7 100%)' => 'Happy Unicorn',
					'linear-gradient(-45deg, #FFC796 0%, #FF6B95 100%)' => 'African Field',
					'linear-gradient(to right, #243949 0%, #517fa4 100%)' => 'Solid Stone',
					'linear-gradient(-20deg, #fc6076 0%, #ff9a44 100%)' => 'Orange Juice',
					'linear-gradient(to top, #dfe9f3 0%, white 100%)' => 'Glass Water',
					'linear-gradient(to right, #00dbde 0%, #fc00ff 100%)' => 'North Miracle',
					'linear-gradient(to right, #f9d423 0%, #ff4e50 100%)' => 'Fruit Blend',
					'linear-gradient(to top, #50cc7f 0%, #f5d100 100%)' => 'Millennium Pine',
					'linear-gradient(to right, #0acffe 0%, #495aff 100%)' => 'High Flight',
					'linear-gradient(-20deg, #616161 0%, #9bc5c3 100%)' => 'Mole Hall',
					'linear-gradient(60deg, #3d3393 0%, #2b76b9 37%, #2cacd1 65%, #35eb93 100%)' => 'Space Shift',
					'linear-gradient(to top, #df89b5 0%, #bfd9fe 100%)' => 'Forest Inei',
					'linear-gradient(to right, #ed6ea0 0%, #ec8c69 100%)' => 'Royal Garden',
					'linear-gradient(to right, #d7d2cc 0%, #304352 100%)' => 'Rich Metal',
					'linear-gradient(to top, #e14fad 0%, #f9d423 100%)' => 'Juicy Cake',
					'linear-gradient(to top, #b224ef 0%, #7579ff 100%)' => 'Smart Indigo',
					'linear-gradient(to right, #c1c161 0%, #c1c161 0%, #d4d4b1 100%)' => 'Sand Strike',
					'linear-gradient(to right, #ec77ab 0%, #7873f5 100%)' => 'Norse Beauty',
					'linear-gradient(to top, #007adf 0%, #00ecbc 100%)' => 'Aqua Guidance',
					'linear-gradient(-225deg, #20E2D7 0%, #F9FEA5 100%)' => 'Sun Veggie',
					'linear-gradient(-225deg, #2CD8D5 0%, #C5C1FF 56%, #FFBAC3 100%)' => 'Sea Lord',
					'linear-gradient(-225deg, #2CD8D5 0%, #6B8DD6 48%, #8E37D7 100%)' => 'Black Sea',
					'linear-gradient(-225deg, #DFFFCD 0%, #90F9C4 48%, #39F3BB 100%)' => 'Grass Shampoo',
					'linear-gradient(-225deg, #5D9FFF 0%, #B8DCFF 48%, #6BBBFF 100%)' => 'Landing Aircraft',
					'linear-gradient(-225deg, #A8BFFF 0%, #884D80 100%)' => 'Witch Dance',
					'linear-gradient(-225deg, #5271C4 0%, #B19FFF 48%, #ECA1FE 100%)' => 'Sleepless Night',
					'linear-gradient(-225deg, #FFE29F 0%, #FFA99F 48%, #FF719A 100%)' => 'Angel Care',
					'linear-gradient(-225deg, #22E1FF 0%, #1D8FE1 48%, #625EB1 100%)' => 'Crystal River',
					'linear-gradient(-225deg, #B6CEE8 0%, #F578DC 100%)' => 'Soft Lipstick',
					'linear-gradient(-225deg, #FFFEFF 0%, #D7FFFE 100%)' => 'Salt Mountain',
					'linear-gradient(-225deg, #E3FDF5 0%, #FFE6FA 100%)' => 'Perfect White',
					'linear-gradient(-225deg, #7DE2FC 0%, #B9B6E5 100%)' => 'Fresh Oasis',
					'linear-gradient(-225deg, #CBBACC 0%, #2580B3 100%)' => 'Strict November',
					'linear-gradient(-225deg, #B7F8DB 0%, #50A7C2 100%)' => 'Morning Salad',
					'linear-gradient(-225deg, #7085B6 0%, #87A7D9 50%, #DEF3F8 100%)' => 'Deep Relief',
					'linear-gradient(-225deg, #77FFD2 0%, #6297DB 48%, #1EECFF 100%)' => 'Sea Strike',
					'linear-gradient(-225deg, #AC32E4 0%, #7918F2 48%, #4801FF 100%)' => 'Night Call',
					'linear-gradient(-225deg, #D4FFEC 0%, #57F2CC 48%, #4596FB 100%)' => 'Supreme Sky',
					'linear-gradient(-225deg, #9EFBD3 0%, #57E9F2 48%, #45D4FB 100%)' => 'Light Blue',
					'linear-gradient(-225deg, #473B7B 0%, #3584A7 51%, #30D2BE 100%)' => 'Mind Crawl',
					'linear-gradient(-225deg, #65379B 0%, #886AEA 53%, #6457C6 100%)' => 'Lily Meadow',
					'linear-gradient(-225deg, #A445B2 0%, #D41872 52%, #FF0066 100%)' => 'Sugar Lollipop',
					'linear-gradient(-225deg, #7742B2 0%, #F180FF 52%, #FD8BD9 100%)' => 'Sweet Dessert',
					'linear-gradient(-225deg, #FF3CAC 0%, #562B7C 52%, #2B86C5 100%)' => 'Magic Ray',
					'linear-gradient(-225deg, #FF057C 0%, #8D0B93 50%, #321575 100%)' => 'Teen Party',
					'linear-gradient(-225deg, #FF057C 0%, #7C64D5 48%, #4CC3FF 100%)' => 'Frozen Heat',
					'linear-gradient(-225deg, #69EACB 0%, #EACCF8 48%, #6654F1 100%)' => 'Gagarin View',
					'linear-gradient(-225deg, #231557 0%, #44107A 29%, #FF1361 67%, #FFF800 100%)' => 'Fabled Sunset',
					'linear-gradient(-225deg, #3D4E81 0%, #5753C9 48%, #6E7FF3 100%)' => 'Perfect Blue',
				);
				foreach ( $gradients as $style => $name ) {
					?>
					<button class="wppp-gradient unchecked" arial-label="<?php echo esc_attr( $name ); ?>" title="<?php echo esc_attr( $name ); ?>" data-title="<?php echo esc_attr( sanitize_title( $name ) ); ?>" data-name="<?php echo esc_attr( $name ); ?>" data-style="<?php echo esc_attr( $style ); ?>" style="cursor: pointer; display: inline-block; border-radius: 50%; margin: 10px; width:50px; height: 50px; background-image: <?php echo esc_attr( $style ); ?>;"></button>
					<?php
				}
				?>
		</div>
		<?php
	}

	/**
	 * Get a list of admin options.
	 *
	 * @param bool $force_reload Whether to clear the cache and retrieve the options.
	 *
	 * @return array Array of option values.
	 */
	public function get_options( $force_reload = false ) {
		// Try to get cached options.
		$options = $this->options;
		if ( empty( $options ) || true === $force_reload ) {
			$options = get_option( 'wp-presenter-pro-admin-options', array() );
		}

		// Store options.
		if ( ! is_array( $options ) ) {
			$options = array();
		}

		$defaults = array(
			'blocks'         => 'curated',
			'post_type_slug' => 'slides',
			'taxonomy_slug'  => 'presentations',
		);
		if ( empty( $options ) || count( $options ) < count( $defaults ) ) {
			$options = wp_parse_args(
				$options,
				$defaults
			);
		}

		$this->options = $options;
		return $options;
	}

	/**
	 * Shows a admin notice.
	 *
	 * @param string $title   Title of the warning message.
	 * @param string $message Warning message in detail.
	 * @param string $class   Style class name for warning.
	 */
	private function show_admin_message( $title = '', $message, $class = 'notice-error' ) {
		?>
		<div class="notice <?php echo esc_attr( $class ); ?>">
			<p>
				<?php if ( ! empty( $title ) ) : ?>
					<strong>
						<?php echo esc_html( $title ); ?>
					</strong>
				<?php endif; ?>
				<span>
					<?php echo wp_kses_post( $message ); ?>
				</span>
			</p>
		</div>
		<?php
	}
}
