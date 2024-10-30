<?php


class ITBConnectAPI {

    static function properties($atts)
    {
        $options = get_option(ITBCONNECT_OPTION_NAME, []);
        $private_key = empty($atts['private_key'])?$options['private_key']:$atts['private_key'];
        $property_page_id = empty($atts['property_page_id'])?$options['property_page_id']:$atts['property_page_id'];
        $property_page_id = apply_filters('wpml_object_id', $property_page_id, 'page', true);
        $page = empty($atts['page'])?get_query_var('npage', 1):$atts['page'];
        $nbpp = empty($atts['nbpp'])?20:$atts['nbpp'];
        $base_list_url = empty($atts['url'])?get_permalink():$atts['url'];
        $locale = current(explode('_', get_locale()));
        $apiurl = ITBCONNECT_API_BASEURL.'/properties';
        $get = ['locale'=>$locale, 'nbpp'=>$nbpp, 'page'=>$page];

        if (!empty($atts['type'])) {
            $get['type_transaction'] = $atts['type'];
        }
        if (!empty($atts['country'])) {
            if (is_array($atts['country'])) {
                $get['country'] = [];
                foreach ($atts['country'] as $item) {
                    if ($item) $get['country'][] = $item;
                }
                if (!$get['country']) unset($get['country']);
            }
            else {
                $get['country'] = $atts['country'];
            }
        }
        if (!empty($atts['city'])) {
            if (is_array($atts['city'])) {
                $get['city'] = [];
                foreach ($atts['city'] as $item) {
                    if ($item) $get['city'][] = $item;
                }
                if (!$get['city']) unset($get['city']);
            }
            else {
                $get['city'] = $atts['city'];
            }
        }
        if (!empty($atts['district'])) {
            if (is_array($atts['district'])) {
                $get['district'] = [];
                foreach ($atts['district'] as $item) {
                    if ($item) $get['district'][] = $item;
                }
                if (!$get['district']) unset($get['district']);
            }
            else {
                $get['district'] = $atts['district'];
            }
        }
        if (!empty($atts['building'])) {
            if (is_array($atts['building'])) {
                $get['building'] = [];
                foreach ($atts['building'] as $item) {
                    if ($item) $get['building'][] = $item;
                }
                if (!$get['building']) unset($get['building']);
                else $get['building'] = implode(',', $get['building']);
            }
            else {
                $get['building'] = $atts['building'];
            }
        }

        if (!empty($atts['rooms'])) {
            if (is_array($atts['rooms'])) {
                $get['num_rooms'] = [];
                foreach ($atts['rooms'] as $item) {
                    if ($item) $get['num_rooms'][] = $item;
                }
                if (!$get['num_rooms']) unset($get['num_rooms']);
                else $get['num_rooms'] = implode(',', $get['num_rooms']);
            }
            else {
                $get['num_rooms'] = $atts['rooms'];
            }
        }
        if (!empty($atts['rooms_min'])) {
            $get['num_rooms_min'] = $atts['rooms_min'];
        }
        if (!empty($atts['rooms_max'])) {
            $get['num_rooms_max'] = $atts['rooms_max'];
        }

        if (!empty($atts['bedrooms'])) {
            if (is_array($atts['bedrooms'])) {
                $get['num_bedrooms'] = [];
                foreach ($atts['bedrooms'] as $item) {
                    if ($item) $get['num_bedrooms'][] = $item;
                }
                if (!$get['num_bedrooms']) unset($get['num_bedrooms']);
                else $get['num_bedrooms'] = implode(',', $get['num_bedrooms']);
            }
            else {
                $get['num_bedrooms'] = $atts['bedrooms'];
            }
        }
        if (!empty($atts['bedrooms_min'])) {
            $get['num_bedrooms_min'] = $atts['bedrooms_min'];
        }
        if (!empty($atts['bedrooms_max'])) {
            $get['num_bedrooms_max'] = $atts['bedrooms_max'];
        }

        if (!empty($atts['bathrooms'])) {
            if (is_array($atts['bathrooms'])) {
                $get['num_bathrooms'] = [];
                foreach ($atts['bathrooms'] as $item) {
                    if ($item) $get['num_bathrooms'][] = $item;
                }
                if (!$get['num_bathrooms']) unset($get['num_bathrooms']);
                else $get['num_bathrooms'] = implode(',', $get['num_bathrooms']);
            }
            else {
                $get['num_bathrooms'] = $atts['bathrooms'];
            }
        }
        if (!empty($atts['bathrooms_min'])) {
            $get['num_bathrooms_min'] = $atts['bathrooms_min'];
        }
        if (!empty($atts['bathrooms_max'])) {
            $get['num_bathrooms_max'] = $atts['bathrooms_max'];
        }

        if (!empty($atts['parkings'])) {
            if (is_array($atts['parkings'])) {
                $get['num_parkings'] = [];
                foreach ($atts['parkings'] as $item) {
                    if ($item) $get['num_parkings'][] = $item;
                }
                if (!$get['num_parkings']) unset($get['num_parkings']);
                else $get['num_parkings'] = implode(',', $get['num_parkings']);
            }
            else {
                $get['num_parkings'] = $atts['parkings'];
            }
        }
        if (!empty($atts['parkings_min'])) {
            $get['num_parkings_min'] = $atts['parkings_min'];
        }
        if (!empty($atts['parkings_max'])) {
            $get['num_parkings_max'] = $atts['parkings_max'];
        }

        if (!empty($atts['box'])) {
            if (is_array($atts['box'])) {
                $get['num_box'] = [];
                foreach ($atts['box'] as $item) {
                    if ($item) $get['num_box'][] = $item;
                }
                if (!$get['num_box']) unset($get['num_box']);
                else $get['num_box'] = implode(',', $get['num_box']);
            }
            else {
                $get['num_box'] = $atts['box'];
            }
        }
        if (!empty($atts['box_min'])) {
            $get['num_box_min'] = $atts['box_min'];
        }
        if (!empty($atts['box_max'])) {
            $get['num_box_max'] = $atts['box_max'];
        }

        if (!empty($atts['cellars'])) {
            if (is_array($atts['cellars'])) {
                $get['num_cellars'] = [];
                foreach ($atts['cellars'] as $item) {
                    if ($item) $get['num_cellars'][] = $item;
                }
                if (!$get['num_cellars']) unset($get['num_cellars']);
                else $get['num_cellars'] = implode(',', $get['num_cellars']);
            }
            else {
                $get['num_cellars'] = $atts['cellars'];
            }
        }
        if (!empty($atts['cellars_min'])) {
            $get['num_cellars_min'] = $atts['cellars_min'];
        }
        if (!empty($atts['cellars_max'])) {
            $get['num_cellars_max'] = $atts['cellars_max'];
        }

        if (!empty($atts['type_property'])) {
            if (is_array($atts['type_property'])) {
                $get['type_property'] = [];
                foreach ($atts['type_property'] as $item) {
                    if ($item) $get['type_property'][] = $item;
                }
                if (!$get['type_property']) unset($get['type_property']);
                else $get['type_property'] = implode(',', $get['type_property']);
            }
            else {
                $get['type_property'] = $atts['type_property'];
            }
        }

        if (!empty($atts['price_min'])) {
            $get['price']['gte'] = $atts['price_min'];
        }
        if (!empty($atts['price_max'])) {
            $get['price']['lte'] = $atts['price_max'];
        }
        if (!empty($atts['price_on_request'])) {
            if ($atts['price_on_request'] == 'always_include') $get['includePricePrivate'] = 1;
            elseif ($atts['price_on_request'] == 'include_match') $get['searchPricePrivate'] = 1;
        }
        elseif (!empty($atts['includepriceprivate'])) {
            $get['includePricePrivate'] = 1;
        }
        elseif (!empty($atts['searchpriceprivate'])) {
            $get['searchPricePrivate'] = 1;
        }

        if (!empty($atts['area_min'])) {
            $get['living_area']['gte'] = $atts['area_min'];
        }
        if (!empty($atts['area_max'])) {
            $get['living_area']['lte'] = $atts['area_max'];
        }

        if (!empty($atts['featured'])) {
            $get['featured'] = 1;
        }
        if (!empty($atts['ids'])) {
            $get['ids'] = $atts['ids'];
        }
        if (!empty($atts['nids'])) {
            $get['nids'] = $atts['nids'];
        }

        if (!empty($atts['agency'])) {
            $get['agency'] = $atts['agency'];
        }

        if (get_query_var('norder')) {
            $get['order'] = get_query_var('norder');
        }
        elseif (!empty($atts['order'])) {
            $get['order'] = $atts['order'];
        }
        if (get_query_var('ndirection')) {
            $get['direction'] = get_query_var('ndirection');
        }
        elseif (!empty($atts['direction'])) {
            $get['direction'] = $atts['direction'];
        }


        $return = [];
        $return['get'] = $get;
        $return['atts'] = $atts;
        $headers = [
            'X-AUTH-TOKEN: '.$private_key
            , 'accept: application/ld+json'
        ];

//        print_r($get);die($apiurl);
        $response = ITBConnect::getRemoteUrl($apiurl, $get, [], $headers, 300, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);

        if ($response) {
            $data = json_decode($response, true);
            $properties = [];
            
            foreach ($data['hydra:member'] as $property) {
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

                if (isset($property['texts'][$locale])) $text = $property['texts'][$locale];
                else $text = current($property['texts']);
                foreach ($text as $k=>$v) {
                    if ($k[0]=='@') continue;
                    $property['text_'.$k] = $v;
                }
                $slug = $property['type_property'];
                if ($property['district_name']) {
                    $slug.='-'.$property['district_name'];
                }
                elseif ($property['city_name']) {
                    $slug.='-'.$property['city_name'];
                }
                if ($property['country_name']) {
                    $slug.='-'.$property['country_name'];
                }
                $slug = trim( sanitize_title($slug), '-');
                $property['url'] = $url = rtrim(get_page_link($property_page_id), '/').'/'.$property['id'].'-'.$slug.'/';
                $property['image'] = $img = $property['images'][0]['url'];
                $properties[] = $property;
            }
            $return['list'] = $properties;
            $return['count'] = $data['hydra:totalItems'];
            $return['page'] = $get['page'];

            $return['num_pages'] = preg_replace('`.*page=([0-9]+).*`', '$1', $data['hydra:view']['hydra:last']);
            $return['url'] = $base_list_url;
            $return['url_next'] = $return['url_previous'] = '';

            $atts_request = !empty($_GET['nsearch'])?$_GET['nsearch']:[];
            if (!$atts_request || !is_array($atts_request)) $atts_request = [];
            foreach ( $atts_request as $k => $v ) {
                if (is_array($v)) continue;
                if (!trim($v)) unset($atts_request[$k]);
            }

            $page_request = $atts_request?['nsearch'=>$atts_request]:[];
            $return['url_current'] = empty($atts['url_current'])?$return['url']:$atts['url_current'];
            $return['url_current'].= (false===strpos($return['url_current'], '?')?'?':'&') . ($page_request?http_build_query($page_request).'&':'');

            if (isset($data['hydra:view']['hydra:next'])) {
                $page_request = ['nsearch'=>$atts_request];
                $page_request['npage'] = $return['page']+1;
                if ($order = get_query_var('norder')) {
                    $page_request['norder'] = $order;
                    if ($direction = get_query_var('ndirection')) {
                        $page_request['ndirection'] = $direction;
                    }
                }

                $return['url_next'] = $return['url'];
                $return['url_next'].= (false===strpos($return['url'], '?')?'?':'&') . http_build_query($page_request);
            }
            if (isset($data['hydra:view']['hydra:previous'])) {
                $page_request = $atts_request;

                if ($return['page']>2) {
                    $page_request['npage'] = $return['page']-1;
                }
                if ($order = get_query_var('norder')) {
                    $page_request['norder'] = $order;
                    if ($direction = get_query_var('ndirection')) {
                        $page_request['ndirection'] = $direction;
                    }
                }

                $return['url_previous']  = $return['url'];
                if ($page_request) $return['url_previous'].= (false===strpos($return['url'], '?')?'?':'&') . http_build_query($page_request);
            }
            return $return;
        }
        return null;
    }

    static function agency ($atts)
    {
        $return = [];
        $options = get_option(ITBCONNECT_OPTION_NAME, array());

        $property_page_id = empty($atts['property_page_id'])?$options['property_page_id']:$atts['property_page_id'];
        $property_page_id = apply_filters('wpml_object_id', $property_page_id, 'page', true);
        $base_list_url = empty($atts['url'])?get_permalink():$atts['url'];
        $locale = current(explode('_', get_locale()));
        $apiurl = ITBCONNECT_API_BASEURL.'/agencies/'.$atts['id'];
        $get = ['locale'=>$locale];

        $headers = [
            'X-AUTH-TOKEN: '.$options['private_key']
            , 'accept: application/ld+json'
        ];
        $get['locale'] = current(explode('_', get_locale()));
        $response = ITBConnect::getRemoteUrl($apiurl, $get, [], $headers, 60*60, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);
        if ($response) {
            $return = json_decode( $response, true );

            foreach ($return as $k=>$v) {
                if ($k[0]=='@') { unset($return[$k]); continue; }
                if ($k=='texts' || $k=='images') continue;
                if (is_array($v)) {
                    foreach ($v as $k2=>$v2) {
                        if ($k2[0]=='@') continue;
                        $return[$k.'_'.$k2] = $v2;
                    }
                }
            }
            $slug = trim( sanitize_title($return['name']), '-');
            $agencyurl = rtrim(get_permalink(), '/').'/'.$return['id'].'-'.$slug.'/';

            $return['properties'] = ITBConnectAPI::properties(['agency'=>$return['id'], 'url'=>$agencyurl]+$atts);
        }

        return $return;
    }

    static function agencies ($atts)
    {
        $return = [];
        $options = get_option(ITBCONNECT_OPTION_NAME, array());

        $property_page_id = empty($atts['property_page_id'])?$options['property_page_id']:$atts['property_page_id'];
        $property_page_id = apply_filters('wpml_object_id', $property_page_id, 'page', true);

        $page = empty($atts['page'])?get_query_var('npage', 1):$atts['page'];
        $nbpp = empty($atts['nbpp'])?20:$atts['nbpp'];
        $base_list_url = empty($atts['url'])?get_permalink():$atts['url'];
        $locale = current(explode('_', get_locale()));
        $apiurl = ITBCONNECT_API_BASEURL.'/agencies';
        $get = ['locale'=>$locale, 'nbpp'=>$nbpp, 'page'=>$page];

        $url = get_permalink();
        $return['atts'] = $atts;

        $option = get_option(ITBCONNECT_OPTION_NAME, array());

        $apiurl = ITBCONNECT_API_BASEURL.'/agencies';
        $headers = [
            'X-AUTH-TOKEN: '.$option['private_key']
            , 'accept: application/ld+json'
        ];
        $get['locale'] = current(explode('_', get_locale()));

        if (!empty($atts['nbpp'])) {
            $get['nbpp'] = $atts['nbpp'];
        }
        $get['page'] = get_query_var('npage', 1);
        $return['get'] = $get;
        $response = ITBConnect::getRemoteUrl($apiurl, $get, [], $headers, 60*60, isset($option['nocheck_ssl'])&&$option['nocheck_ssl']);

        if ($response) {
            $data = json_decode( $response, true );
            $agencies = [];
            foreach ($data['hydra:member'] as $agency) {
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
                $slug = trim( sanitize_title($agency['name']), '-');
                $agency['pageurl'] = $url = rtrim(get_permalink(), '/').'/'.$agency['id'].'-'.$slug.'/';
                $agency['image'] = $img = $agency['thumb'];
                $agencies[] = $agency;
            }
            $return['list'] = $agencies;
            $return['count'] = $data['hydra:totalItems'];
            $return['page'] = $get['page'];
            $return['num_pages'] = preg_replace('`[^0-9]+`', '', $data['hydra:view']['hydra:last']);
            $return['url'] = get_permalink();
            $return['url_next'] = $return['url_previous'] = '';


            $atts_request = !empty($_GET['nsearch'])?$_GET['nsearch']:[];
            $page_request = $atts_request?['nsearch'=>$atts_request]:[];
            $return['url_current'] = empty($atts['url_current'])?$return['url']:$atts['url_current'];
            $return['url_current'].= (false===strpos($return['url_current'], '?')?'?':'&') . ($page_request?http_build_query($page_request).'&':'');

            if (isset($data['hydra:view']['hydra:next'])) {
                $page_request = ['nsearch'=>$atts_request];
                $page_request['npage'] = $return['page']+1;
                if ($order = get_query_var('norder')) {
                    $page_request['norder'] = $order;
                    if ($direction = get_query_var('ndirection')) {
                        $page_request['ndirection'] = $direction;
                    }
                }

                $return['url_next'] = $return['url'];
                $return['url_next'].= (false===strpos($return['url'], '?')?'?':'&') . http_build_query($page_request);
            }
            if (isset($data['hydra:view']['hydra:previous'])) {
                $page_request = $atts_request;

                if ($return['page']>2) {
                    $page_request['npage'] = $return['page']-1;
                }
                if ($order = get_query_var('norder')) {
                    $page_request['norder'] = $order;
                    if ($direction = get_query_var('ndirection')) {
                        $page_request['ndirection'] = $direction;
                    }
                }

                $return['url_previous']  = $return['url'];
                if ($page_request) $return['url_previous'].= (false===strpos($return['url'], '?')?'?':'&') . http_build_query($page_request);
            }
        }

        add_thickbox();

        return $return;
    }
}
