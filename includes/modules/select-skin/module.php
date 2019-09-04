<?php
namespace Croco_MKI\Modules\Select_Skin;

use Croco_MKI\Base\Module as Module_Base;
use Croco_MKI\Plugin as Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Module extends Module_Base {

	/**
	 * Returns module slug
	 *
	 * @return void
	 */
	public function get_slug() {
		return 'select-skin';
	}

	/**
	 * Enqueue module-specific assets
	 *
	 * @return void
	 */
	public function enqueue_module_assets() {

		wp_enqueue_script(
			'croco-mki-skins',
			CROCO_MKI_URL . 'assets/js/skins.js',
			array( 'cx-vue-ui' ),
			CROCO_MKI_VERSION,
			true
		);

	}

	/**
	 * License page config
	 *
	 * @param  array  $config  [description]
	 * @param  string $subpage [description]
	 * @return [type]          [description]
	 */
	public function page_config( $config = array(), $subpage = '' ) {

		if ( ! empty( $_GET['action'] ) && 'import' === $_GET['action'] ) {
			$back       = $config['main_page'];
			$page_title = __( 'Upload your skin', 'croco-mki' );
			$action     = 'import';
			$first_tab  = 'upload-skin';

		} else {
			$back       = Plugin::instance()->dashboard->page_url( 'license' );
			$page_title = __( 'Select landing to install', 'croco-mki' );
			$action     = 'select';
			$first_tab  = 'skin';
		}

		$config['page_title']     = $page_title;
		$config['body']           = 'cbw-skins';
		$config['action']         = $action;
		$config['wrapper_css']    = 'panel-wide';
		$config['default_back']   = $back;
		$config['first_tab']      = $first_tab;
		$config['skins_by_types'] = Plugin::instance()->skins->get_skins_by_types();
		$config['allowed_types']  = Plugin::instance()->skins->get_types();
		$config['upload_hook']    = array(
			'action'  => Plugin::instance()->dashboard->page_slug . '/' . $this->get_slug(),
			'handler' => 'upload_user_skin',
		);
		$config['upload_errors']  = array(
			'limit' => __( 'Only 1 file allowed to upload', 'croco-mki' ),
			'type'  => __( 'Only .zip files are allowed', 'croco-mki' ),
		);

		return $config;

	}

	/**
	 * Add license component template
	 *
	 * @param  array  $templates [description]
	 * @param  string $subpage   [description]
	 * @return [type]            [description]
	 */
	public function page_templates( $templates = array(), $subpage = '' ) {

		$templates['skins']         = 'skins/main';
		$templates['skin']          = 'skins/skin';
		$templates['skin_uploader'] = 'skins/skin-uploader';

		return $templates;

	}

	public function upload_user_skin() {

		$skin = isset( $_FILES['_skin'] ) ? $_FILES['_skin'] : false;

		if ( ! $skin ) {
			wp_send_json_error( array(
				'message' => __( 'Skin file not found in request', 'croco-mki' ),
			) );
		}

		$uploader = new Uploader( $skin );

		$result = $uploader->upload();

		if ( ! $result ) {
			wp_send_json_error( array(
				'message' => $uploader->get_error(),
			) );
		}

		$info = array();

		ob_start();
		include $result['settings.json'];
		$settings = ob_get_clean();
		$settings = json_decode( $settings, true );

		if ( empty( $settings ) || ! isset( $settings['name'] ) || ! isset( $settings['slug'] ) ) {

			$uploader->delete_skin();

			wp_send_json_error( array(
				'message' => __( 'Incorrect settings file format', 'croco-mki' ),
			) );

		}

		wp_send_json_success( array(
			'name'      => $settings['name'],
			'slug'      => $settings['slug'],
			'demo'      => isset( $settings['demo'] ) ? $settings['demo'] : false,
			'thumbnail' => isset( $settings['thumbnail'] ) ? $settings['thumbnail'] : false,
		) );

	}

	/**
	 * Delete uploaded skin
	 *
	 * @return [type] [description]
	 */
	public function delete_uploaded_skin() {
		$slug = isset( $_REQUEST['slug'] ) ? esc_attr( $_REQUEST['slug'] ) : '';
		Plugin::instance()->files_manager->delete_dir( $slug );
	}

	/**
	 * Prepare passed skin for installation
	 *
	 * @return [type] [description]
	 */
	public function prepare_skin_installation() {

		$is_uploaded = isset( $_REQUEST['is_uploaded'] ) ? $_REQUEST['is_uploaded'] : false;
		$is_uploaded = filter_var( $is_uploaded, FILTER_VALIDATE_BOOLEAN );
		$skin        = ! empty( $_REQUEST['slug'] ) ? esc_attr( $_REQUEST['slug'] ) : false;

		if ( ! $skin ) {
			wp_send_json_error( array(
				'message' => __( 'Skin slug not found in request', 'croco-mki' ),
			) );
		}

		Plugin::instance()->storage->store( 'install_skin', $skin );

		wp_send_json_success( array(
			'redirect' => add_query_arg(
				array(
					'skin'        => $skin,
					'is_uploaded' => $is_uploaded
				),
				Plugin::instance()->dashboard->page_url( 'install-plugins' )
			)
		) );

	}

}
