<?php
/**
 * Class ITBConnectPublic
 */
class ITBConnectPublic {

	/**
	 * Entry point
	 */
	public function run ()
	{
		add_action('init', [$this, 'initAction']);
		add_filter('init', [$this, 'initFilter']);
	}

	public function getLocale($default='en')
	{
		list($locale) = explode('_', get_locale());
		return strtolower($locale);
	}

	public function initAction()
	{

		add_shortcode('itb_listing', [$this, 'listing']);
		add_shortcode('itb_carousel', [$this, 'carousel']);
		add_shortcode('itb_selection', [$this, 'selection']);

		add_shortcode('itb_property', [$this, 'property']);

		add_shortcode('itb_agencies', [$this, 'agencies']);

		add_shortcode('itb_contact', [$this, 'contact']);

		add_shortcode('itb_value', [$this, 'value']);
		add_shortcode('itb_dump', [$this, 'dump']);
		add_shortcode('itb_search', [$this, 'search']);
		add_shortcode('itb_searchresults', [$this, 'searchresults']);

		add_rewrite_tag('%property_id%', '([0-9]+)');
		add_rewrite_tag('%add_selection_property_id%', '([0-9]+)');
		add_rewrite_tag('%agency_id%', '([0-9]+)');
		add_rewrite_tag('%npage%', '([0-9]+)');
		add_rewrite_tag('%norder%', '([a-z_]+)');
		add_rewrite_tag('%ndirection%', '([a-z_]+)');
		add_rewrite_tag('%nsearch%', '(.*)');

		add_action( 'wp_enqueue_scripts', [$this, 'enqueueScripts']);

        if (!empty($_GET['add_selection_property_id'])) {
            $property_id = $_GET['add_selection_property_id'];
            $selection = isset($_COOKIE['itbconnect_selection'])&&@unserialize($_COOKIE['itbconnect_selection'])?unserialize($_COOKIE['itbconnect_selection']):[];

            if (isset($selection[$property_id])) {
                unset($selection[$property_id]);
            }
            else {
                $selection[$property_id] = time();
            }
            setcookie('itbconnect_selection', serialize($selection), time()+60*60*24*30, '/');

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                die('<div><div class="itbselectionjson" style="display: none;" data-count="'.count($selection).'"></div></div>');
            }
        }
	}

	public function enqueueScripts ()
	{
        $options = get_option(ITBCONNECT_OPTION_NAME, array());

		add_thickbox();

		if (!wp_script_is('jquery3')) {
			wp_deregister_script('jquery');
			wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), null, false);
		}
		if (!wp_script_is('bootstrap') && !wp_script_is('bootstrap3') && $options['include_bootstrap_js']) {
			wp_enqueue_script( 'bootstrap3', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), null, false );
		}
		wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array(), null, false);
		wp_enqueue_script('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js', array(), null, false);

        wp_enqueue_style('itbconnect-base-style',
            plugins_url( 'css/base.css', __FILE__ ),
            [],
            filemtime( __DIR__.'/css/base.css' )
        );
        wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', [], null, 'all');
        wp_enqueue_style('owl-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', [], null, 'all');
        wp_enqueue_style('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css', [], null, 'all');
        if (!wp_style_is('bootstrap') && !wp_style_is('bootstrap3') && $options['include_bootstrap_css']) {
            wp_enqueue_style('bootstrap3', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', [], null, 'all');
        }
	}


	public function initFilter()
	{
		$titles = [];

		/**
		 * Rewrite rules for the property pages
		 */
		if($pages = get_posts( array( 'post_type' => 'page', 'posts_per_page' => -1))) {
			foreach ( $pages as $page ) {
				if ( false !== strpos( $page->post_content, '[itb_property' ) && !preg_match('`\[itb_property[^\]]*id=`', $page->post_content)) {
					$titles[] = $page->post_title;
					add_rewrite_rule(
						'([a-z]{2}/)?('.$page->post_name.')/([0-9]+)-.*/?$',
						'index.php?pagename=$matches[2]&property_id=$matches[3]',
						'top'
					);
				}
                if (0&&false !== strpos( $page->post_content, '[itb_agencies' ) && !preg_match('`\[itb_agencies[^\]]*id=`', $page->post_content)) {
                    $titles[] = $page->post_title;
                    add_rewrite_rule(
                        '([a-z]{2}/)?('.$page->post_name.')/([0-9]+)-.*/?$',
                        'index.php?pagename=$matches[2]&agency_id=$matches[3]',
                        'top'
                    );
                }
			}
		}

		add_filter('_the_title', function ($title, $id = null) use ($titles) {   // H1 title for the property pages
//            if (($agency_id = get_query_var('agency_id')) && (in_array($title, $titles))) {
//                $agency = $this->getAgency($agency_id);
//                if ($agency) return $agency['name'];
//            }
			if (($property_id = get_query_var('property_id')) && (in_array($title, $titles))) {
				$title = $this->get_title($property_id);
				if (trim($title)) return $title;
			}
			return $title;
		});
		add_filter( 'document_title_parts', function ($title_parts) {   // Meta title for the property pages
            $agency_id = get_query_var('agency_id');
            if ($agency_id) {
                $agency = $this->getAgency($agency_id);
                if ($agency) $title_parts['title'] = $agency['name'].' - '.$title_parts['title'];
            }
			$property_id = get_query_var('property_id');
			if ($property_id) {
				$title = $this->get_title($property_id);
				if ($title) $title_parts['title'] = $title;
			}
			elseif (get_query_var('npage')>1) {
				$title_parts['title'] = $title_parts['title']. ' p:'.get_query_var('npage');
			}

			return $title_parts;
		}, 999, 1 );
	}

	/**
	 * Retrieve the title of the given property
	 * @param int $property_id The property ID
	 *
	 * @return string|null
	 */
	public function get_title($property_id)
	{
		$property = $this->getProperty($property_id);

		if ($property) {
			return $property['text_title'];
		}
		return null;
	}

	/**
	 * Get/setup Twig environment
	 * @return Twig_Environment
	 */
	static function getTwig ()
	{
		$paths = [];

		if (is_dir(get_stylesheet_directory().'/itb-connect/partials')) {
			$paths[] = get_stylesheet_directory().'/itb-connect/partials';
		}
		$paths[] = __DIR__.'/partials';
		$loader = new Twig_Loader_Filesystem($paths);
		$twig = new Twig_Environment($loader, [
			'debug'=>true
		]);
		$filter_trans = new Twig_SimpleFilter('trans', function ($string, $params=[], $domain='default') {
			if ($params) {
				return vsprintf(__($string, $domain), $params);
			}
			return __($string, $domain);
		});
		$twig->addFilter($filter_trans);
		$twig->addFunction(new Twig_SimpleFunction('__', function ($string, $domain='default', $params=[]) {
			if ($params) {
				return vsprintf(__($string, $domain), $params);
			}
			return __($string, $domain);
		}));
        $twig->addFunction(new Twig_SimpleFunction('do_shortcode', function ($content, $ignore_html = false) {

            return do_shortcode($content, $ignore_html);
        }));
		$twig->addExtension(new Twig_Extension_Debug());

		return $twig;
	}

	/**
	 * Clean tag content for Twig
	 * @param $string
	 *
	 * @return string
	 */
	static function cleanForTwig ($string) {
		$string = preg_replace('`^([\r\n]*<br />)*`', '', $string);
		$string = preg_replace('`([\r\n]*<br />)*$`', '', $string);
		$string = trim($string, "\r\n\t ");
		return $string;
	}


	/**
	 * [itb_listing] : Listing page
	 * @param array $atts
	 *
	 * @return string
	 * @throws Throwable
	 */
	public function listing($atts = [])
	{
        if (version_compare('5.6', phpversion()) > 0) return '';

        $option = get_option(ITBCONNECT_OPTION_NAME, array());

        $selection = isset($_COOKIE['itbconnect_selection'])&&@unserialize($_COOKIE['itbconnect_selection'])?unserialize($_COOKIE['itbconnect_selection']):[];
        $data_view['selection'] = $selection;
        $data_view['selection_url'] = get_page_link(isset($atts['selection_page_id'])?$atts['selection_page_id']:$option['basket_page_id']);
		$data_view['atts'] = $atts;

        if (!empty($_REQUEST['nsearch'])) {
            $atts = $atts + $_REQUEST['nsearch'];
        }
		$data_view['properties'] = ITBConnectAPI::properties($atts);
        $twig = self::getTwig();
        $template = $twig->load('listing.html.twig');
        return $template->render($data_view);
	}

    /**
     * [itb_selection] : Client selection page
     * @param array $atts
     *
     * @return string
     * @throws Throwable
     */
    public function selection($atts = [])
    {
        if (version_compare('5.6', phpversion()) > 0) return '';

        $option = get_option(ITBCONNECT_OPTION_NAME, array());

        if (!is_array($atts)) $atts = [];
        $data_view['atts'] = $atts;
        $selection = isset($_COOKIE['itbconnect_selection'])&&@unserialize($_COOKIE['itbconnect_selection'])?unserialize($_COOKIE['itbconnect_selection']):[];

        $atts['ids'] = implode(',', array_keys($selection));
        if (!$atts['ids'])$atts['ids'] = -1;
        $data_view['properties'] = ITBConnectAPI::properties($atts);
        $data_view['selection'] = $selection;
        $data_view['selection_url'] = get_page_link(isset($atts['selection_page_id'])?$atts['selection_page_id']:$option['basket_page_id']);
        $twig = self::getTwig();
        $template = $twig->load('selection.html.twig');
        return $template->render($data_view);
    }

	/**
	 * [itb_carousel] : Properties carousel
	 * @param array $atts
	 * @param null $content
	 * @param string $tag
	 *
	 * @return string
	 * @throws Throwable
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
	public function carousel($atts = [], $content = null, $tag = '')
	{
        if (version_compare('5.6', phpversion()) > 0) return '';

        $option = get_option(ITBCONNECT_OPTION_NAME, array());

        $selection = isset($_COOKIE['itbconnect_selection'])&&@unserialize($_COOKIE['itbconnect_selection'])?unserialize($_COOKIE['itbconnect_selection']):[];
        $data_view['selection'] = $selection;
        $data_view['selection_url'] = get_page_link(isset($atts['selection_page_id'])?$atts['selection_page_id']:$option['basket_page_id']);
        $data_view['atts'] = $atts;
        $properties = ITBConnectAPI::properties($atts);
        $data_view['properties'] = [];
        foreach ($properties['list'] as $property) {
            $property = $this->format_property($property, get_locale());
            $data_view['properties'][] = $property;
        }
        if ($data_view['properties']) {
            $twig = self::getTwig();
            $template = $twig->load('carousel.html.twig');
            return $template->render($data_view);
        }
        return '';
	}

	/**
	 * [itb_property] : Property page
	 * @param array $atts
	 * @param null $content
	 * @param string $tag
	 *
	 * @return string
	 * @throws Throwable
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
	public function property($atts = [], $content = null, $tag = '')
	{
        if (version_compare('5.6', phpversion()) > 0) return '';
        if (is_admin()) {
            return;
        }
        $option = get_option(ITBCONNECT_OPTION_NAME, array());
        $selection = isset($_COOKIE['itbconnect_selection'])&&@unserialize($_COOKIE['itbconnect_selection'])?unserialize($_COOKIE['itbconnect_selection']):[];
        $data_view['selection'] = $selection;
        $data_view['selection_url'] = get_page_link(isset($atts['selection_page_id'])?$atts['selection_page_id']:$option['basket_page_id']);

        if (!is_array($atts)) $atts = [];
		$option = get_option(ITBCONNECT_OPTION_NAME, array());
		$data_view['option'] = $option;
		if (isset($atts['id'])) {
			$property_id = $atts['id'];
		}
		else {
			$property_id = get_query_var('property_id');
		}
		$permalink = parse_url(get_permalink());
		if (!$property_id && 0===strpos($_SERVER['REQUEST_URI'], $permalink['path'])) {
            $redirect_url = isset($atts['notfound_page_id'])?get_page_link($atts['notfound_page_id']):'../';
            if (headers_sent()) {
                return '<script>window.location.href="'.$redirect_url.'";</script>';
            }
            else {
                header('Location: '.$redirect_url, true, 301);
                exit;
            }
        }
		$data_view['atts'] = $atts;

        $property = $this->getProperty($property_id);
        if (!$property && 0===strpos($_SERVER['REQUEST_URI'], $permalink['path'])) {

            $redirect_url = isset($atts['notfound_page_id'])?get_page_link($atts['notfound_page_id']):'../';
            if (headers_sent()) {
                return '<script>window.location.href="'.$redirect_url.'";</script>';
            }
            else {
                header('Location: '.$redirect_url, true, 301);
                exit;
            }
        }

        $data_view['property'] = $property;

		add_thickbox();
		$twig = self::getTwig();
		$template = $twig->load('property.html.twig');
		return $template->render($data_view);
	}

	/**
	 * [itb_agencies] : Agencies list page
	 * @param array $atts
	 * @param null $content
	 * @param string $tag
	 *
	 * @return string
	 * @throws Throwable
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
    public function agencies($atts = [], $content = null, $tag = '')
    {
        if (version_compare('5.6', phpversion()) > 0) return '';

        if (!is_array($atts)) $atts = [];
        $option = get_option(ITBCONNECT_OPTION_NAME, array());
        $selection = isset($_COOKIE['itbconnect_selection'])&&@unserialize($_COOKIE['itbconnect_selection'])?unserialize($_COOKIE['itbconnect_selection']):[];
        $data_view['selection'] = $selection;
        $data_view['selection_url'] = get_page_link(isset($atts['selection_page_id'])?$atts['selection_page_id']:$option['basket_page_id']);

        $data_view['atts'] = $atts;
        if (get_query_var('agency_id')) {
            $atts['id'] = get_query_var('agency_id');
            $data_view['agency'] = ITBConnectAPI::agency($atts);
        }
        else {
            $data_view['agencies'] = ITBConnectAPI::agencies($atts);
        }
        $twig = self::getTwig();
        $template = $twig->load('agencies.html.twig');
        return $template->render($data_view);
    }

	/**
	 * [itb_contact] : Contact link (property) or contact iframe (agency)
	 * @param array $atts
	 * @param null $content
	 * @param string $tag
	 *
	 * @return string
	 * @throws Throwable
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
	public function contact($atts = [], $content = null, $tag = '')
	{
        if (version_compare('5.6', phpversion()) > 0) return '';

        if (!is_array($atts)) $atts = [];
		$option = get_option(ITBCONNECT_OPTION_NAME, array());
		$data_view['option'] = $option;

		$property_id = null;
		if (isset($atts['id'])) {
			$property_id = $atts['id'];
		}
		elseif (get_query_var('property_id')) {
			$property_id = get_query_var('property_id');
		}
		$data_view['atts'] = $atts;

		if ($property_id) {
			$property = $this->getProperty($property_id);
			$data_view['property'] = $property;
			add_thickbox();
		}
		else {
			$data_view['agency'] = $this->getAgency(empty($atts['agency_id'])?null:$atts['agency_id']);
		}
		$twig = self::getTwig();
		if ($content) {
			$template = $twig->createTemplate("{% extends 'contact.html.twig' %}\r\n".self::cleanForTwig($content));
		}
		else $template = $twig->load('contact.html.twig');

		return $template->render($data_view);
	}

	/**
	 * [itb_search] : Search engine
	 * @param array $atts
	 * @param null $content
	 * @param string $tag
	 *
	 * @return string
	 * @throws Throwable
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
	public function search($atts = [], $content =null, $tag = '')
	{
        if (version_compare('5.6', phpversion()) > 0) return '';

        if (!is_array($atts)) $atts = [];
		$data_view = [];
		$data_view['atts'] = $atts;
		$search = !empty($_GET['nsearch'])?$_GET['nsearch']:[];
		if (!$search || !is_array($search)) $search = [];

		if (!empty($atts['type'])) $search['type'] = $atts['type'];
		if (!empty($atts['country'])) $search['country'] = strtoupper($atts['country']);
		if (!empty($atts['city'])) $search['city'] = explode(',', $atts['city']);
		if (!empty($atts['district'])) $search['district'] = explode(',', $atts['district']);
		if (!empty($atts['rooms'])) $search['rooms'] = explode(',', $atts['rooms']);
		if (!empty($atts['price_max'])) $search['price_max'] = $atts['price_max'];
		if (!empty($atts['price_min'])) $search['price_min'] = $atts['price_min'];
		if (!empty($atts['area_min'])) $search['area_min'] = $atts['area_min'];
		if (!empty($atts['area_max'])) $search['area_max'] = $atts['area_max'];
		if (!empty($atts['price_on_request'])) $search['price_on_request'] = $atts['price_on_request'];
		if (!empty($atts['featured'])) $search['featured'] = $atts['featured'];

		$data_view['search'] = $search;
		$property_id = get_query_var('property_id');
		if ($property_id) {
			$property = $this->getProperty($property_id);
			if ($property) {
				if (empty($data_view['search']['country'])) {
					$data_view['search']['country'] = $property['country_code'];
				}
				if (empty($data_view['search']['type'])) {
					$data_view['search']['type'] = $property['type_transaction_code'];
				}
			}
		}
		if (!empty($atts['type'])) {
			$data_view['search']['type'] = $atts['type'];
		}
		if (!empty($atts['country'])) {
			$data_view['search']['country'] = strtoupper($atts['country']);
		}
		if (!empty($atts['city'])) {
			$data_view['search']['city'] = strtoupper($atts['city']);
		}
		if (!empty($atts['district'])) {
			$data_view['search']['district'] = strtoupper($atts['district']);
		}
		$option = get_option(ITBCONNECT_OPTION_NAME, array());

		$searchresults_page_id = empty($atts['searchresults_page_id'])?$option['searchresults_page_id']:$atts['searchresults_page_id'];
		if (!$searchresults_page_id) return '';
		$data_view['searchresults_url'] = get_permalink($searchresults_page_id);
		$data_view['countries'] = $this->getCountries();
		$data_view['cities'] = $this->getCities();
		$data_view['districts'] = $this->getDistricts();

		$twig = self::getTwig();
		if ($content) {
			$template = $twig->createTemplate("{% extends 'search.html.twig' %}\r\n".self::cleanForTwig($content));
		}
		else $template = $twig->load('search.html.twig');

		return $template->render($data_view);
	}

	/**
	 * [itb_searchresults] : Search results page
	 * @param array $atts
	 * @param null $content
	 * @param string $tag
	 *
	 * @return string
	 * @throws Throwable
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
	public function searchresults($atts = [], $content =null, $tag = '')
	{
        if (version_compare('5.6', phpversion()) > 0) return '';

        if (!$atts) $atts = [];
        if (!empty($_REQUEST['nsearch'])) {
            $atts = $atts + $_REQUEST['nsearch'];
        }
		return $this->listing($atts, $content, $tag);
	}

	/**
	 * [itb_value] : Displays a value of a property
	 * ex: [itb_value]price[/itb_value]
	 * ex: [itb_value id="12345"]price[/itb_value]
	 *
	 * @param array $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function value($atts = [], $content = null)
	{
        if (version_compare('5.6', phpversion()) > 0) return '';

        if (!is_array($atts)) $atts = [];
        if (isset($atts['id'])) {
            $property_id = (int)$atts['id'];
        }
        else {
            $property_id = (int)get_query_var('property_id');
        }

        if (!$property_id>0) return '';
		if (!($property = $this->getProperty($property_id))) return '';

		if (isset($property[$content])) return $property[$content];
		return '';
	}

	static $properties = [];
	/**
	 * Retrieves a property by ID
	 * @param int $property_id
	 *
	 * @return array|null
	 */
	public function getProperty ($property_id)
	{
		if (isset(self::$properties[$property_id])) return self::$properties[$property_id];
		$option = get_option(ITBCONNECT_OPTION_NAME, array());

		$url = ITBCONNECT_API_BASEURL.'/properties/'.$property_id;
		$headers = [
			'X-AUTH-TOKEN: '.$option['private_key']
			, 'accept: application/ld+json'
		];
		$get['locale'] = current(explode('_', get_locale()));
		$response = ITBConnect::getRemoteUrl($url, $get, [], $headers, 60*60, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);

		if ($response) {
			$property = json_decode( $response, true );
			$property = $this->format_property($property, get_locale());

			return self::$properties[$property_id]=$property;
		}
		return null;
	}


	static $agency = null;
	static $agencies = [];

	/**
	 * Retrieves the agency data
	 * @return array|null
	 */
	public function getAgency ($agency_id=null)
	{
		if (self::$agency) return self::$agency; //cached agency

		$option = get_option(ITBCONNECT_OPTION_NAME, array());
        if ($agency_id) {
            $url = ITBCONNECT_API_BASEURL.'/agencies/'.$agency_id;
        }
        else {
		    $url = ITBCONNECT_API_BASEURL.'/agencies';
        }

		$headers = [
			'X-AUTH-TOKEN: '.$option['private_key']
			, 'accept: application/ld+json'
		];
		$get['locale'] = current(explode('_', get_locale()));
		$response = ITBConnect::getRemoteUrl($url, $get, [], $headers, 60*60, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);

		if ($response) {
		    if ($agency_id) {
		        return $this->format_agency(json_decode( $response, true ));
            }
            else {
                $agencies = json_decode( $response, true );
                if (isset($agencies['hydra:member'])) {
                    $agency = current($agencies['hydra:member']);
                    return self::$agency=$agency;
			}
            }
		}
		return null;
	}

	static $countries = [];
	public function getCountries ()
	{
		if (!empty(self::$countries)) return self::$countries;
		$option = get_option(ITBCONNECT_OPTION_NAME, array());

		$url = ITBCONNECT_API_BASEURL.'/countries';
		$headers = [
			'X-AUTH-TOKEN: '.$option['private_key']
			, 'accept: application/ld+json'
		];
		$get['locale'] = current(explode('_', get_locale()));
		$get['nbpp'] = 1000;
		$response = ITBConnect::getRemoteUrl($url, $get, [], $headers, 60*60, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);

		if ($response) {
			$data = json_decode( $response, true );
			if (isset($data['hydra:member'])) return self::$countries = $data['hydra:member'];
		}
		return null;
	}
	static $cities = [];
	public function getCities ()
	{
		if (!empty(self::$cities)) return self::$cities;
		$option = get_option(ITBCONNECT_OPTION_NAME, array());

		$url = ITBCONNECT_API_BASEURL.'/cities';
		$headers = [
			'X-AUTH-TOKEN: '.$option['private_key']
			, 'accept: application/ld+json'
		];
		$get['locale'] = current(explode('_', get_locale()));
		$get['nbpp'] = 1000;
		$response = ITBConnect::getRemoteUrl($url, $get, [], $headers, 60*60, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);

		if ($response) {
			$data = json_decode( $response, true );
			if (isset($data['hydra:member'])) return self::$cities = $data['hydra:member'];
		}
		return null;
	}
    static $districts = [];
    public function getDistricts ()
    {
        if (!empty(self::$districts)) return self::$districts;
        $option = get_option(ITBCONNECT_OPTION_NAME, array());

        $url = ITBCONNECT_API_BASEURL.'/districts';
        $headers = [
            'X-AUTH-TOKEN: '.$option['private_key']
            , 'accept: application/ld+json'
        ];
        $get['locale'] = current(explode('_', get_locale()));
        $get['country'] = 'MC';
        $get['all'] = 1;
        $get['nbpp'] = 1000;
        $response = ITBConnect::getRemoteUrl($url, $get, [], $headers, 60*60, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);

        if ($response) {
            $data = json_decode( $response, true );
            if (isset($data['hydra:member'])) return self::$districts = $data['hydra:member'];
        }
        return null;
    }

	public function format_property($property, $locale)
	{
		foreach ($property as $k=>$v) {
			if ($k[0]=='@') { unset($property[$k]); continue; }
			if ($k=='texts' || $k=='images') continue;
			if (is_array($v)) {
				foreach ($v as $k2=>$v2) {
					if ($k2[0]=='@') continue;
					$property[$k.'_'.$k2] = $v2;
				}
			}
		}
		$locale = strtolower(current(explode('_', $locale)));
		if (isset($property['texts'][$locale])) $text = $property['texts'][$locale];
		else $text = current($property['texts']);
		foreach ($text as $k=>$v) {
			if ($k[0]=='@') continue;
			$property['text_'.$k] = $v;
		}
		return $property;
	}

	public function format_agency($agency)
	{
		foreach ($agency as $k=>$v) {
			if ($k[0]=='@') { unset($agency[$k]); continue; }
			if ($k=='texts' || $k=='images') continue;
			if (is_array($v)) {
				foreach ($v as $k2=>$v2) {
					if ($k2[0]=='@') continue;
                    $agency[$k.'_'.$k2] = $v2;
				}
			}
		}
		return $agency;
	}
}
