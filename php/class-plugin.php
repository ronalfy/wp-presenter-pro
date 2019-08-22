<?php
/**
 * Primary plugin file.
 *
 * @package   WP_Presenter_Pro
 */

namespace WP_Presenter_Pro;

/**
 * Class Plugin
 */
class Plugin extends Plugin_Abstract {
	/**
	 * Execute this once plugins are loaded.
	 */
	public function plugin_loaded() {

		// Check for dependencies.
		$this->dependencies = new Admin\Admin_Prerequisites();
		$this->dependencies->register_hooks();

		// Load ACF.
		$this->acf = new Admin\ACF();
		$this->acf->register_hooks();

		// Load REST.
		$this->rest_avatar = new REST\Rest_Get_Avatar();
		$this->rest_avatar->register_hooks();

		// Enqueue scripts.
		$this->block_enqueue = new Blocks\Enqueue();
		$this->block_enqueue->register_hooks();

		// Block for main slide.
		$this->block_slide = new Blocks\Slide();
		$this->block_slide->register_hooks();

		// Block for main slide title.
		$this->block_slide_title = new Blocks\Slide_Title();
		$this->block_slide_title->register_hooks();

		// Block for text box.
		$this->block_text_box = new Blocks\Text_Box();
		$this->block_text_box->register_hooks();

		// Block for code box.
		$this->block_code = new Blocks\Code();
		$this->block_code->register_hooks();

		// List Item Block.
		$this->block_list = new Blocks\List_Item();
		$this->block_list->register_hooks();

		// Image Block.
		$this->block_image = new Blocks\Image();
		$this->block_image->register_hooks();

		// Spacer Block.
		$this->block_spacer = new Blocks\Spacer();
		$this->block_spacer->register_hooks();

		// Show Content Image Block.
		$this->block_content_image = new Blocks\Content_Image();
		$this->block_content_image->register_hooks();

		// Show Content Block.
		$this->block_content = new Blocks\Content();
		$this->block_content->register_hooks();

		// Show Content Block.
		$this->block_content_two_columns = new Blocks\Content_Two_Columns();
		$this->block_content_two_columns->register_hooks();

		// Show Notes Block.
		$this->block_show_notes = new Blocks\Show_Notes();
		$this->block_show_notes->register_hooks();

		// Vertical Slides Block.
		$this->block_vertical_slide = new Blocks\Vertical_Slide();
		$this->block_vertical_slide->register_hooks();

		// Transition Slides Block.
		$this->block_transition = new Blocks\Transition();
		$this->block_transition->register_hooks();

		// Register post type actions and filters.
		$this->post_type = new Admin\Post_Type();
		$this->post_type->register_hooks();

		// Register license and settings.
		$this->license_admin = new Admin\EDD_License_Settings();
		$this->license_admin->register_hooks();

		// Register Settings page.
		$this->settings_admin = new Admin\Add_Settings_Page();
		$this->settings_admin->register_hooks();
	}
}
