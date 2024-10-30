<?php
/**
 *
 */
class ITBConnectAdmin {

	public function run ()
	{
		add_action( 'admin_menu', array( $this, 'addMenu' ) );
        add_action( 'init', array($this, 'gutenberg_boilerplate_block') );
	}

	public function gutenberg_boilerplate_block ()
    {
        if (version_compare('5.6', phpversion()) > 0) return null;

        if (function_exists('register_block_type')) {
            wp_register_script(
                'itbconnect-listing',
                plugins_url('js/block.js', __FILE__),
                array('wp-blocks', 'wp-element', 'wp-editor', 'wp-i18n')
            );
            wp_register_style('itbconnect-style',
                plugins_url('css/editor.css', __FILE__),
                array('wp-edit-blocks'),
                filemtime(__DIR__ . '/css/editor.css')
            );

            register_block_type('immotoolbox-connect/listing', array(
                'editor_script' => 'itbconnect-listing',
                'editor_style' => 'itbconnect-style',
            ));
        }
    }

	public function addMenu()
	{
		add_menu_page(
			__( 'ITB Connect', 'itbconnect' ),
			__( 'ITB Connect', 'itbconnect' ),
			'manage_options',
			'itbconnect',
			array($this, 'adminLayout'),
			''
		);

        if (version_compare('5.6', phpversion()) < 0) {
            add_submenu_page('itbconnect',
                __('Clear cache', 'itbconnect'),
                __('Clear cache', 'itbconnect'),
                'manage_options',
                'itbconnect_clearcache',
                [$this, 'clearcache']);
        }
	}

	/**
	 * Outputs the Admin Dashboard layout containing the form with all its options
	 *
	 * @return void
	 */
	public function adminLayout()
	{
        if (version_compare('5.6', phpversion()) > 0) {
            echo '<p>'.sprintf(__( 'This plugin requires a version of PHP greater than 5.6 (you have PHP %s version)', 'itbconnect' ), phpversion()).'</p>';
            return;
        }
		$data = $this->getData();
		if (!empty($_POST)) {
			if (!empty($_POST['itbconnect_private_key'])) {
				$data['private_key'] = $_POST['itbconnect_private_key'];
			}
			if (!empty($_POST['itbconnect_google_maps_api_key'])) {
				$data['google_maps_api_key'] = $_POST['itbconnect_google_maps_api_key'];
			}
			if (!empty($_POST['itbconnect_property_page_id'])) {
				$data['property_page_id'] = $_POST['itbconnect_property_page_id'];
			}
			if (!empty($_POST['itbconnect_searchresults_page_id'])) {
				$data['searchresults_page_id'] = $_POST['itbconnect_searchresults_page_id'];
			}
			if (!empty($_POST['itbconnect_basket_page_id'])) {
				$data['basket_page_id'] = $_POST['itbconnect_basket_page_id'];
			}
			if (!empty($_POST['itbconnect_view_url'])) {
				$data['view_url'] = $_POST['itbconnect_view_url'];
			}
			if (isset($_POST['itbconnect_include_bootstrap_js'])) {
				$data['include_bootstrap_js'] = (bool)$_POST['itbconnect_include_bootstrap_js'];
			}
			if (isset($_POST['itbconnect_include_bootstrap_css'])) {
				$data['include_bootstrap_css'] = (bool)$_POST['itbconnect_include_bootstrap_css'];
			}
			if (isset($_POST['itbconnect_nocheck_ssl'])) {
				$data['nocheck_ssl'] = (bool)$_POST['itbconnect_nocheck_ssl'];
			}
			update_option(ITBCONNECT_OPTION_NAME, $data);
			flush_rewrite_rules();
		}

		$connect_response = $this->testConnection($data['private_key']);
		include __DIR__.'/partials/settings.php';
	}

	public function clearcache()
	{
		$data = $this->getData();
		$files = glob(__DIR__.'/../cache/*/*/*');
		if (!empty($_POST)) {
			foreach ($files as $file) {
				unlink($file);
			}
			$files = glob(__DIR__.'/../cache/*/*/*');
		}
		include __DIR__.'/partials/clearcache.php';
	}


	/**
	 * Returns the saved options data as an array
	 *
	 * @return array
	 */
	private function getData() {
		return get_option(ITBCONNECT_OPTION_NAME, array());
	}

	/**
	 * Make an API call to the ImmoToolBox API to check connexion
	 *
	 * @return array
	 */
	private function testConnection ()
	{
		$option = $this->getData();

		$url = ITBCONNECT_API_BASEURL.'/properties';
		$headers = [
			'X-AUTH-TOKEN: '.$option['private_key']
			, 'accept: application/ld+json'
		];
		$response = ITBConnect::getRemoteUrl($url, [], [], $headers, 60, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);

		return $response?json_decode($response):null;
	}
}