<?php
/**
 *
 */

/*
 * Main class
 */
/**
 * Class ITBConnect
 *
 * This class creates the option page and add the web app script
 */
class ITBConnect
{

	public function run ()
	{
        require_once(__DIR__.'/ITBConnectAPI.php');
		add_action( 'plugins_loaded', function () {
            load_plugin_textdomain( 'immotoolbox-connect', FALSE, '/immotoolbox-connect/languages/' );
		});

		if (is_admin()) {
			require_once(__DIR__.'/../admin/ITBConnectAdmin.php');
			$plugin = new ITBConnectAdmin();
			$plugin->run();
		}
		require_once(__DIR__.'/../public/ITBConnectPublic.php');
		$plugin = new ITBConnectPublic();
		$plugin->run();
	}


	/**
	 * Plugin activation
	 */
	public static function activate ()
	{
		$data['private_key'] = '';
		$data['property_page_id'] = '';
		$data['view_url'] = 'view';
		$data['google_maps_api_key'] = '';
		$post_id = wp_insert_post(array(
			'post_title'=> 'Property details',
			'post_name'=> 'property',
			'post_type'=> 'page',
			'post_content'=> '[itb_property]',
			'post_status'=>'publish',
        ));
		$data['property_page_id'] = $post_id;
		$data['auto_property_page_id'] = $post_id;

		$post_id = wp_insert_post(array(
			'post_title'=> 'Search results',
			'post_name'=> 'propertysearch',
			'post_type'=> 'page',
			'post_content'=> '[itb_searchresults]',
			'post_status'=>'publish',
        ));
		$data['searchresults_page_id'] = $post_id;
		$data['auto_searchresults_page_id'] = $post_id;

		$post_id = wp_insert_post(array(
			'post_title'=> 'Client selection',
			'post_name'=> 'propertyselection',
			'post_type'=> 'page',
			'post_content'=> '[itb_selection]',
			'post_status'=>'publish',
        ));
		$data['basket_page_id'] = $post_id;
		$data['auto_basket_page_id'] = $post_id;

		update_option(ITBCONNECT_OPTION_NAME, $data);
		flush_rewrite_rules();
	}


	/**
	 * Plugin desactivation
	 */
	public static function deactivate ()
	{
		$options = get_option(ITBCONNECT_OPTION_NAME);
		if ($options['auto_property_page_id']) {
			wp_delete_post($options['auto_property_page_id']);
		}
		if ($options['auto_searchresults_page_id']) {
			wp_delete_post($options['auto_searchresults_page_id']);
		}

		delete_option(ITBCONNECT_OPTION_NAME);
		flush_rewrite_rules();
	}

	static function getRemoteUrl($url, $get = null, $post = null, $headers = null, $cachetime = 300, $nocheck_ssl = false)
	{
        global $wp_version;

		$cachename = md5($url.serialize($get).serialize($post).serialize($headers).'?v7');
		$cachepath = __DIR__.'/../cache/'.$cachename[0].$cachename[1].'/'.$cachename[2].$cachename[3];
		$filename = $cachepath.'/'.$cachename;
		if (file_exists($filename) && filemtime($filename)>time()-$cachetime) {
			return file_get_contents($cachepath.'/'.$cachename);
		}

		if (!is_dir($cachepath)) mkdir($cachepath, 0777, true);
		$opts = array(
			"http" => array(
				"method" => "GET",
            )
        );
		if ($nocheck_ssl) {
		    $opts['ssl'] = array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            );
        }
        $get['ori'] = $_SERVER['SERVER_NAME'];
        $get['wp_version'] = $wp_version;
        $url = trim($url, '?').'?'.http_build_query($get);

		if ($post) {
			$postdata = http_build_query($post);
			$opts['http']['method'] = 'POST';
			$opts['http']['content'] = $postdata;
		}
		if ($headers) {
			$opts['http']['header'] = implode("\r\n", $headers);
		}

		$context = stream_context_create($opts);
		$contents = file_get_contents($url, false, $context);
		if ($contents) file_put_contents($filename, $contents);
		return $contents;
	}
}