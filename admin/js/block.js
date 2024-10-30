var el = wp.element.createElement,
    Fragment = wp.element.Fragment,
    registerBlockType = wp.blocks.registerBlockType,
    InspectorControls  = wp.editor.InspectorControls ,
    i18n = wp.i18n,
    SelectControl = wp.components.SelectControl,
    TextControl = wp.components.TextControl,
    TextareaControl = wp.components.TextareaControl,
    ToggleControl  = wp.components.ToggleControl,
    PanelBody  = wp.components.PanelBody,
    Icon = wp.components.Icon;


registerBlockType( 'immotoolbox-connect/listing', {
    title: i18n.__('ImmoToolBox Property Listing', "immotoolbox-connect"),
    description: i18n.__('This block displays a list of properties', "immotoolbox-connect"),

    icon: 'admin-multisite',

    category: 'embed',

    attributes: {
        type: {
            type: 'string'
        },
        country: {
            type: 'string'
        },
        city: {
            type: 'string'
        },
        district: {
            type: 'string'
        },
        building: {
            type: 'string'
        },
        rooms: {
            type: 'string'
        },
        price_min: {
            type: 'string'
        },
        price_max: {
            type: 'string'
        },
        price_on_request: {
            type: 'string'
        },
        area_min: {
            type: 'string'
        },
        order: {
            type: 'string'
        },
        direction: {
            type: 'string'
        },
        manual: {
            type: 'string'
        },
        featured: {
            type: 'boolean'
        },
        ids: {
            type: 'string'
        },
        nids: {
            type: 'string'
        },
        agency: {
            type: 'string'
        },
    },

    edit: function( props ) {
        return (
            el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        {
                            "title": i18n.__("Filter properties", "immotoolbox-connect"),
                            initialOpen: false,
                        },
                        [
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.type,
                                    label: i18n.__("Type", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { type: newValue } ) },
                                    options: [
                                        {value: '', label: ''}
                                        , {value: 'sale', label: i18n.__('Properties for sale', "immotoolbox-connect")}
                                        , {value: 'rental', label: i18n.__('Properties for rent', "immotoolbox-connect")}
                                    ]
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.country,
                                    label: i18n.__("Country Code", "immotoolbox-connect"),
                                    placeholder: "MC / FR / ...",
                                    onChange: function (newValue) { props.setAttributes( { country: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.city,
                                    label: i18n.__("City ID", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { city: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.district,
                                    label: i18n.__("District ID", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { district: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.building,
                                    label: i18n.__("Building ID", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { building: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.rooms,
                                    label: i18n.__("Nb. rooms", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { rooms: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.price_min,
                                    label: i18n.__("Min. price", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { price_min: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.price_max,
                                    label: i18n.__("Max. price", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { price_max: newValue } ) },
                                }
                            ),
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.price_on_request,
                                    label: i18n.__("Prices on request when using price filter", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { price_on_request: newValue } ) },
                                    options: [
                                        {value: 'dont_include', label: i18n.__('Don\'t include', "immotoolbox-connect")}
                                        , {value: 'include_match', label: i18n.__('Include if private price match', "immotoolbox-connect")}
                                        , {value: 'always_include', label: i18n.__('Always include', "immotoolbox-connect")}
                                    ]
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.area_min,
                                    label: i18n.__("Min. area", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { area_min: newValue } ) },
                                }
                            ),
                            el(
                                ToggleControl,
                                {
                                    checked: props.attributes.featured,
                                    label: i18n.__("Featured properties", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { featured: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.ids,
                                    label: i18n.__("IDs of property to display", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { ids: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.nids,
                                    label: i18n.__("IDs of property to exclude", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { nids: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.agency,
                                    label: i18n.__("Agency ID", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { agency: newValue } ) },
                                }
                            ),
                        ]
                    ),
                    el(
                        PanelBody,
                        {
                            "title": i18n.__("Ordering", "immotoolbox-connect"),
                            initialOpen: false,
                        },
                        [
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.order,
                                    label: i18n.__("Order", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { order: newValue } ) },
                                    options: [
                                        {value: '', label: ''}
                                        , {value: 'date', label: i18n.__('Date', "immotoolbox-connect")}
                                        , {value: 'price', label: i18n.__('Price', "immotoolbox-connect")}
                                        , {value: 'area', label: i18n.__('Area', "immotoolbox-connect")}
                                        , {value: 'type', label: i18n.__('Type', "immotoolbox-connect")}
                                        , {value: 'country', label: i18n.__('Country', "immotoolbox-connect")}
                                        , {value: 'city', label: i18n.__('City', "immotoolbox-connect")}
                                    ]
                                }
                            ),
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.direction,
                                    label: i18n.__("Direction", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { direction: newValue } ) },
                                    options: [
                                        {value: '', label: ''}
                                        , {value: 'asc', label: i18n.__('Asc', "immotoolbox-connect")}
                                        , {value: 'desc', label: i18n.__('Desc', "immotoolbox-connect")}
                                    ]
                                }
                            ),
                        ]
                    ),
                    el(
                        PanelBody,
                        {
                            "title": i18n.__("Other settings", "immotoolbox-connect"),
                            initialOpen: false,
                        },
                        el(
                            TextareaControl,
                            {
                                value: props.attributes.manual,
                                placeholder: "aaa=bbb ccc=ddd ...",
                                onChange: function (newValue) { props.setAttributes( { manual: newValue } ) },
                            }
                        )
                    )
                ),
                el(
                    "p",
                    {},
                    [
                        el("strong", {},
                            [
                                el(Icon, {icon: "admin-multisite"}),
                                " "+i18n.__("ImmoToolBox Property Listing", "immotoolbox-connect")
                            ]
                        ),
                        el(
                            "ul",
                            {},
                            [
                                (props.attributes.type||props.attributes.country||props.attributes.city||props.attributes.district||props.attributes.rooms||props.attributes.price_max||props.attributes.price_min||props.attributes.price_on_request||props.attributes.area_min||props.attributes.featured||props.attributes.ids||props.attributes.nids||props.attributes.agency)?el(
                                    "li",
                                    {className: "itbconnect_subvalues"},
                                    [
                                        i18n.__("Search values :", "immotoolbox-connect"),
                                        props.attributes.type?el("span", {className: "itbconnect_label"}, i18n.__("Transaction", "immotoolbox-connect")+" : "+props.attributes.type):null,
                                        props.attributes.country?el("span", {className: "itbconnect_label"}, i18n.__("Country", "immotoolbox-connect")+" : "+props.attributes.country):null,
                                        props.attributes.city?el("span", {className: "itbconnect_label"}, i18n.__("City", "immotoolbox-connect")+" : "+props.attributes.city):null,
                                        props.attributes.district?el("span", {className: "itbconnect_label"}, i18n.__("District", "immotoolbox-connect")+" : "+props.attributes.district):null,
                                        props.attributes.building?el("span", {className: "itbconnect_label"}, i18n.__("Building", "immotoolbox-connect")+" : "+props.attributes.building):null,
                                        props.attributes.rooms?el("span", {className: "itbconnect_label"}, i18n.__("Num. rooms", "immotoolbox-connect")+" : "+props.attributes.rooms):null,
                                        props.attributes.price_max?el("span", {className: "itbconnect_label"}, i18n.__("Max. price", "immotoolbox-connect")+" : "+props.attributes.price_max):null,
                                        props.attributes.price_min?el("span", {className: "itbconnect_label"}, i18n.__("Min. price", "immotoolbox-connect")+" : "+props.attributes.price_min):null,
                                        props.attributes.price_on_request?el("span", {className: "itbconnect_label"}, i18n.__("Price on request", "immotoolbox-connect")+" : "+props.attributes.price_on_request):null,
                                        props.attributes.area_min?el("span", {className: "itbconnect_label"}, i18n.__("Min. area", "immotoolbox-connect")+" : "+props.attributes.area_min):null,
                                        props.attributes.featured?el("span", {className: "itbconnect_label"}, i18n.__("Featured properties", "immotoolbox-connect")):null,
                                        props.attributes.ids?el("span", {className: "itbconnect_label"}, i18n.__("IDs of properties to display", "immotoolbox-connect")):null,
                                        props.attributes.nids?el("span", {className: "itbconnect_label"}, i18n.__("IDs of properties to exclude", "immotoolbox-connect")):null,
                                        props.attributes.agency?el("span", {className: "itbconnect_label"}, i18n.__("Agency", "immotoolbox-connect")+" : "+props.attributes.agency):null,
                                    ]
                                ):null,
                                (props.attributes.order||props.attributes.direction)?el(
                                    "li",
                                    {className: "itbconnect_subvalues"},
                                    [
                                        i18n.__("Ordering :", "immotoolbox-connect"),
                                        props.attributes.order?el("span", {className: "itbconnect_label"}, i18n.__("Order", "immotoolbox-connect")+" : "+props.attributes.order):null,
                                        props.attributes.direction?el("span", {className: "itbconnect_label"}, i18n.__("Direction", "immotoolbox-connect")+" : "+props.attributes.direction):null,
                                    ]
                                ):null,
                                props.attributes.manual?(
                                    el(
                                        "li",
                                        {className: "itbconnect_subvalues"},
                                        [
                                            i18n.__("Other settings :", "immotoolbox-connect"),
                                            el("span", {className: "itbconnect_label"}, props.attributes.manual)
                                        ]
                                    )
                                ):null,
                            ]
                        )
                    ]
                ),
                el(
                    "pre",
                    {className: "wp-block-shortcode itbconnect_shortcode"},
                    listing_shortcode_value(props)
                )
            )
        );
    },

    save: function( props) {
        return el( 'div', {  }, listing_shortcode_value(props) );
    },
} );

function listing_shortcode_value(props)
{
    var code = '[itb_listing';
    if (props.attributes.type) {
        code+=' type="'+props.attributes.type+'"';
    }
    if (props.attributes.country) {
        code+=' country="'+props.attributes.country+'"';
    }
    if (props.attributes.city) {
        code+=' city="'+props.attributes.city+'"';
    }
    if (props.attributes.district) {
        code+=' district="'+props.attributes.district+'"';
    }
    if (props.attributes.building) {
        code+=' building="'+props.attributes.building+'"';
    }
    if (props.attributes.rooms) code+=' rooms="'+props.attributes.rooms+'"';
    if (props.attributes.price_min) code+=' price_min="'+props.attributes.price_min+'"';
    if (props.attributes.price_max) code+=' price_max="'+props.attributes.price_max+'"';
    if (props.attributes.price_on_request) code+=' price_on_request="'+props.attributes.price_on_request+'"';
    if (props.attributes.area_min) code+=' area_min="'+props.attributes.area_min+'"';
    if (props.attributes.featured) code+=' featured="1"';
    if (props.attributes.ids) code+=' ids="'+props.attributes.ids+'"';
    if (props.attributes.nids) code+=' nids="'+props.attributes.nids+'"';
    if (props.attributes.agency) code+=' agency="'+props.attributes.agency+'"';

    if (props.attributes.order) {
        code+=' order="'+props.attributes.order+'"';
    }
    if (props.attributes.direction) {
        code+=' direction="'+props.attributes.direction+'"';
    }
    if (props.attributes.manual) {
        code+=' '+props.attributes.manual;
    }
    code+= ']';

    return code;
}




registerBlockType( 'immotoolbox-connect/carousel', {
    title: i18n.__('ImmoToolBox Property Carousel', "immotoolbox-connect"),
    description: i18n.__('This block displays a carousel of properties', "immotoolbox-connect"),

    icon: 'images-alt',

    category: 'embed',

    attributes: {
        type: {
            type: 'string'
        },
        country: {
            type: 'string'
        },
        city: {
            type: 'string'
        },
        district: {
            type: 'string'
        },
        building: {
            type: 'string'
        },
        rooms: {
            type: 'string'
        },
        price_min: {
            type: 'string'
        },
        price_max: {
            type: 'string'
        },
        price_on_request: {
            type: 'string'
        },
        area_min: {
            type: 'string'
        },
        order: {
            type: 'string'
        },
        direction: {
            type: 'string'
        },
        manual: {
            type: 'string'
        },
        featured: {
            type: 'boolean'
        },
        ids: {
            type: 'string'
        },
        nids: {
            type: 'string'
        },
        agency: {
            type: 'string'
        },
    },

    edit: function( props ) {
        return (
            el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        {
                            "title": i18n.__("Filter properties", "immotoolbox-connect"),
                            initialOpen: false,
                        },
                        [
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.type,
                                    label: i18n.__("Type", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { type: newValue } ) },
                                    options: [
                                        {value: '', label: ''}
                                        , {value: 'sale', label: i18n.__('Properties for sale', "immotoolbox-connect")}
                                        , {value: 'rental', label: i18n.__('Properties for rent', "immotoolbox-connect")}
                                    ]
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.country,
                                    label: i18n.__("Country Code", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { country: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.city,
                                    label: i18n.__("City ID", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { city: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.district,
                                    label: i18n.__("District ID", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { district: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.building,
                                    label: i18n.__("Building ID", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { building: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.rooms,
                                    label: i18n.__("Nb. rooms", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { rooms: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.price_min,
                                    label: i18n.__("Min. price", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { price_min: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.price_max,
                                    label: i18n.__("Max. price", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { price_max: newValue } ) },
                                }
                            ),
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.price_on_request,
                                    label: i18n.__("Prices on request when using price filter", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { price_on_request: newValue } ) },
                                    options: [
                                        {value: 'dont_include', label: i18n.__('Don\'t include', "immotoolbox-connect")}
                                        , {value: 'include_match', label: i18n.__('Include if private price match', "immotoolbox-connect")}
                                        , {value: 'always_include', label: i18n.__('Always include', "immotoolbox-connect")}
                                    ]
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.area_min,
                                    label: i18n.__("Min. area", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { area_min: newValue } ) },
                                }
                            ),
                            el(
                                ToggleControl,
                                {
                                    checked: props.attributes.featured,
                                    label: i18n.__("Featured properties", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { featured: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.ids,
                                    label: i18n.__("IDs of property to display", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { ids: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.nids,
                                    label: i18n.__("IDs of property to exclude", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { nids: newValue } ) },
                                }
                            ),
                            el(
                                TextControl,
                                {
                                    value: props.attributes.agency,
                                    label: i18n.__("Agency ID", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { agency: newValue } ) },
                                }
                            ),
                        ]
                    ),
                    el(
                        PanelBody,
                        {
                            "title": i18n.__("Ordering", "immotoolbox-connect"),
                            initialOpen: false,
                        },
                        [
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.order,
                                    label: i18n.__("Order", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { order: newValue } ) },
                                    options: [
                                        {value: '', label: ''}
                                        , {value: 'date', label: i18n.__('Date', "immotoolbox-connect")}
                                        , {value: 'price', label: i18n.__('Price', "immotoolbox-connect")}
                                        , {value: 'area', label: i18n.__('Area', "immotoolbox-connect")}
                                    ]
                                }
                            ),
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.direction,
                                    label: i18n.__("Direction", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { direction: newValue } ) },
                                    options: [
                                        {value: '', label: ''}
                                        , {value: 'asc', label: i18n.__('Asc', "immotoolbox-connect")}
                                        , {value: 'desc', label: i18n.__('Desc', "immotoolbox-connect")}
                                    ]
                                }
                            ),
                        ]
                    ),
                    el(
                        PanelBody,
                        {
                            "title": i18n.__("Other settings", "immotoolbox-connect"),
                            initialOpen: false,
                        },
                        [
                            el(
                                TextareaControl,
                                {
                                    value: props.attributes.manual,
                                    placeholder: "aaa=bbb ccc=ddd ...",
                                    onChange: function (newValue) { props.setAttributes( { manual: newValue } ) },
                                }
                            )
                        ]
                    )
                ),
                el(
                    "p",
                    {},
                    [
                        el("strong", {},
                            [
                                el(Icon, {icon: "images-alt"}),
                                " "+i18n.__("ImmoToolBox Property Carousel", "immotoolbox-connect")
                            ]
                        ),
                        el(
                            "ul",
                            {},
                            [
                                (props.attributes.type||props.attributes.country||props.attributes.city||props.attributes.district||props.attributes.building||props.attributes.rooms||props.attributes.price_max||props.attributes.price_min||props.attributes.price_on_request||props.attributes.area_min||props.attributes.featured||props.attributes.ids||props.attributes.nids||props.attributes.agency)?el(
                                    "li",
                                    {className: "itbconnect_subvalues"},
                                    [
                                        i18n.__("Search values :", "immotoolbox-connect"),
                                        props.attributes.type?el("span", {className: "itbconnect_label"}, i18n.__("Transaction", "immotoolbox-connect")+" : "+props.attributes.type):null,
                                        props.attributes.country?el("span", {className: "itbconnect_label"}, i18n.__("Country", "immotoolbox-connect")+" : "+props.attributes.country):null,
                                        props.attributes.city?el("span", {className: "itbconnect_label"}, i18n.__("City", "immotoolbox-connect")+" : "+props.attributes.city):null,
                                        props.attributes.district?el("span", {className: "itbconnect_label"}, i18n.__("District", "immotoolbox-connect")+" : "+props.attributes.district):null,
                                        props.attributes.building?el("span", {className: "itbconnect_label"}, i18n.__("Building", "immotoolbox-connect")+" : "+props.attributes.building):null,
                                        props.attributes.rooms?el("span", {className: "itbconnect_label"}, i18n.__("Num. rooms", "immotoolbox-connect")+" : "+props.attributes.rooms):null,
                                        props.attributes.price_min?el("span", {className: "itbconnect_label"}, i18n.__("Min. price", "immotoolbox-connect")+" : "+props.attributes.price_min):null,
                                        props.attributes.price_max?el("span", {className: "itbconnect_label"}, i18n.__("Max. price", "immotoolbox-connect")+" : "+props.attributes.price_max):null,
                                        props.attributes.price_on_request?el("span", {className: "itbconnect_label"}, i18n.__("Price on request", "immotoolbox-connect")+" : "+props.attributes.price_on_request):null,
                                        props.attributes.area_min?el("span", {className: "itbconnect_label"}, i18n.__("Min. area", "immotoolbox-connect")+" : "+props.attributes.area_min):null,
                                        props.attributes.featured?el("span", {className: "itbconnect_label"}, i18n.__("Featured properties", "immotoolbox-connect")):null,
                                        props.attributes.ids?el("span", {className: "itbconnect_label"}, i18n.__("IDs of properties to display", "immotoolbox-connect")):null,
                                        props.attributes.nids?el("span", {className: "itbconnect_label"}, i18n.__("IDs of properties to exclude", "immotoolbox-connect")):null,
                                        props.attributes.agency?el("span", {className: "itbconnect_label"}, i18n.__("Agency", "immotoolbox-connect")+" : "+props.attributes.agency):null,
                                    ]
                                ):null,
                                (props.attributes.order||props.attributes.direction)?el(
                                    "li",
                                    {className: "itbconnect_subvalues"},
                                    [
                                        i18n.__("Ordering :", "immotoolbox-connect"),
                                        props.attributes.order?el("span", {className: "itbconnect_label"}, i18n.__("Order", "immotoolbox-connect")+" : "+props.attributes.order):null,
                                        props.attributes.direction?el("span", {className: "itbconnect_label"}, i18n.__("Direction", "immotoolbox-connect")+" : "+props.attributes.direction):null,
                                    ]
                                ):null,
                                props.attributes.manual?(
                                    el(
                                        "li",
                                        {className: "itbconnect_subvalues"},
                                        [
                                            i18n.__("Other settings :", "immotoolbox-connect"),
                                            el("span", {className: "itbconnect_label"}, props.attributes.manual)
                                        ]
                                    )
                                ):null,
                            ]
                        )
                    ]
                ),
                el(
                    "pre",
                    {className: "wp-block-shortcode itbconnect_shortcode"},
                    carousel_shortcode_value(props)
                )
            )
        );
    },

    save: function( props) {
        return el( 'div', {  }, carousel_shortcode_value(props) );
    },
} );


function carousel_shortcode_value(props)
{
    var code = '[itb_carousel';
    if (props.attributes.type) {
        code+=' type="'+props.attributes.type+'"';
    }
    if (props.attributes.country) {
        code+=' country="'+props.attributes.country+'"';
    }
    if (props.attributes.city) {
        code+=' city="'+props.attributes.city+'"';
    }
    if (props.attributes.district) {
        code+=' district="'+props.attributes.district+'"';
    }
    if (props.attributes.building) {
        code+=' building="'+props.attributes.building+'"';
    }
    if (props.attributes.rooms) code+=' rooms="'+props.attributes.rooms+'"';
    if (props.attributes.price_min) code+=' price_min="'+props.attributes.price_min+'"';
    if (props.attributes.price_max) code+=' price_max="'+props.attributes.price_max+'"';
    if (props.attributes.price_on_request) code+=' price_on_request="'+props.attributes.price_on_request+'"';
    if (props.attributes.area_min) code+=' area_min="'+props.attributes.area_min+'"';
    if (props.attributes.featured) code+=' featured="1"';
    if (props.attributes.ids) code+=' ids="'+props.attributes.ids+'"';
    if (props.attributes.nids) code+=' nids="'+props.attributes.nids+'"';
    if (props.attributes.agency) code+=' agency="'+props.attributes.agency+'"';

    if (props.attributes.order) {
        code+=' order="'+props.attributes.order+'"';
    }
    if (props.attributes.direction) {
        code+=' direction="'+props.attributes.direction+'"';
    }
    if (props.attributes.manual) {
        code+=' '+props.attributes.manual;
    }
    code+= ']';
    return code;
}



registerBlockType( 'immotoolbox-connect/search', {
    title: i18n.__('ImmoToolBox Property Search', "immotoolbox-connect"),
    description: i18n.__('This block displays a search engine', "immotoolbox-connect"),

    icon: 'search',

    category: 'embed',

    attributes: {
        format: {
            type: 'string'
        },
        hide_type: {
            type: 'boolean',
        },
        hide_country: {
            type: 'boolean'
        },
        hide_city: {
            type: 'boolean'
        },
        hide_district: {
            type: 'boolean'
        },
        hide_price_max: {
            type: 'boolean'
        },
        hide_rooms: {
            type: 'boolean'
        },
        hide_area_min: {
            type: 'boolean'
        },
        hide_submit: {
            type: 'boolean'
        },
        type: {
            type: 'string'
        },
        country: {
            type: 'string'
        },
        city: {
            type: 'string'
        },
        district: {
            type: 'string'
        },
        building: {
            type: 'string'
        },
        rooms: {
            type: 'string'
        },
        price_min: {
            type: 'string'
        },
        price_max: {
            type: 'string'
        },
        price_on_request: {
            type: 'string'
        },
        area_min: {
            type: 'string'
        },
        order: {
            type: 'string'
        },
        direction: {
            type: 'string'
        },
        featured: {
            type: 'boolean'
        },
        ids: {
            type: 'string'
        },
        nids: {
            type: 'string'
        },
        agency: {
            type: 'string'
        },

        manual: {
            type: 'string'
        },
    },

    edit: function( props ) {
        return (
            el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    [
                        el(
                            PanelBody,
                            {},
                            el(
                                SelectControl,
                                {
                                    value: props.attributes.format,
                                    label: i18n.__("Format", "immotoolbox-connect"),
                                    onChange: function (newValue) { props.setAttributes( { format: newValue } ) },
                                    options: [
                                        {value: '', label: ''}
                                        , {value: 'vertical', label: i18n.__('Vertical', "immotoolbox-connect")}
                                        , {value: 'horizontal', label: i18n.__('Horizontal', "immotoolbox-connect")}
                                    ]
                                }
                            )
                        ),
                        el(
                            PanelBody,
                            {
                                "title": i18n.__("Hidden fields", "immotoolbox-connect"),
                                initialOpen: false,
                            },
                            [
                                el(
                                    ToggleControl,
                                    {
                                        checked: props.attributes.hide_type,
                                        label: i18n.__("Type", "immotoolbox-connect"),
                                        onChange: function (newValue) { props.setAttributes( { hide_type: newValue } ) },
                                    }
                                ),
                                el(
                                    ToggleControl,
                                    {
                                        checked: props.attributes.hide_country,
                                        label: i18n.__("Country", "immotoolbox-connect"),
                                        onChange: function (newValue) { props.setAttributes( { hide_country: newValue } ) },
                                    }
                                ),
                                el(
                                    ToggleControl,
                                    {
                                        checked: props.attributes.hide_city,
                                        label: i18n.__("City", "immotoolbox-connect"),
                                        onChange: function (newValue) { props.setAttributes( { hide_city: newValue } ) },
                                    }
                                ),
                                el(
                                    ToggleControl,
                                    {
                                        checked: props.attributes.hide_district,
                                        label: i18n.__("District", "immotoolbox-connect"),
                                        onChange: function (newValue) { props.setAttributes( { hide_district: newValue } ) },
                                    }
                                ),
                                el(
                                    ToggleControl,
                                    {
                                        checked: props.attributes.hide_price_max,
                                        label: i18n.__("Max. price", "immotoolbox-connect"),
                                        onChange: function (newValue) { props.setAttributes( { hide_price_max: newValue } ) },
                                    }
                                ),
                                el(
                                    ToggleControl,
                                    {
                                        checked: props.attributes.hide_rooms,
                                        label: i18n.__("Nb. rooms", "immotoolbox-connect"),
                                        onChange: function (newValue) { props.setAttributes( { hide_rooms: newValue } ) },
                                    }
                                ),
                                el(
                                    ToggleControl,
                                    {
                                        checked: props.attributes.hide_area_min,
                                        label: i18n.__("Min. area", "immotoolbox-connect"),
                                        onChange: function (newValue) { props.setAttributes( { hide_area_min: newValue } ) },
                                    }
                                ),
                                el(
                                    ToggleControl,
                                    {
                                        checked: props.attributes.hide_submit,
                                        label: i18n.__("Submit", "immotoolbox-connect"),
                                        onChange: function (newValue) { props.setAttributes( { hide_submit: newValue } ) },
                                    }
                                ),
                            ]
                        ),
                        el(
                            PanelBody,
                            {
                                "title": i18n.__("Pre-filled values", "immotoolbox-connect"),
                                initialOpen: false,
                            },
                            [
                                [
                                    el(
                                        SelectControl,
                                        {
                                            value: props.attributes.type,
                                            label: i18n.__("Type", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { type: newValue } ) },
                                            options: [
                                                {value: '', label: ''}
                                                , {value: 'sale', label: i18n.__('Properties for sale', "immotoolbox-connect")}
                                                , {value: 'rental', label: i18n.__('Properties for rent', "immotoolbox-connect")}
                                            ]
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.country,
                                            label: i18n.__("Country Code", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { country: newValue } ) },
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.city,
                                            label: i18n.__("City ID", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { city: newValue } ) },
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.district,
                                            label: i18n.__("District ID", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { district: newValue } ) },
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.rooms,
                                            label: i18n.__("Nb. rooms", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { rooms: newValue } ) },
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.price_min,
                                            label: i18n.__("Min. price", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { price_min: newValue } ) },
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.price_max,
                                            label: i18n.__("Max. price", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { price_max: newValue } ) },
                                        }
                                    ),
                                    el(
                                        SelectControl,
                                        {
                                            value: props.attributes.price_on_request,
                                            label: i18n.__("Prices on request when using price filter", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { price_on_request: newValue } ) },
                                            options: [
                                                {value: 'dont_include', label: i18n.__('Don\'t include', "immotoolbox-connect")}
                                                , {value: 'include_match', label: i18n.__('Include if private price match', "immotoolbox-connect")}
                                                , {value: 'always_include', label: i18n.__('Always include', "immotoolbox-connect")}
                                            ]
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.area_min,
                                            label: i18n.__("Min. area", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { area_min: newValue } ) },
                                        }
                                    ),
                                    el(
                                        ToggleControl,
                                        {
                                            checked: props.attributes.featured,
                                            label: i18n.__("Featured properties", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { featured: newValue } ) },
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.ids,
                                            label: i18n.__("IDs of property to display", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { ids: newValue } ) },
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.nids,
                                            label: i18n.__("IDs of property to exclude", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { nids: newValue } ) },
                                        }
                                    ),
                                    el(
                                        TextControl,
                                        {
                                            value: props.attributes.agency,
                                            label: i18n.__("Agency ID", "immotoolbox-connect"),
                                            onChange: function (newValue) { props.setAttributes( { agency: newValue } ) },
                                        }
                                    ),
                                ]
                            ]
                        ),
                        el(
                            PanelBody,
                            {
                                "title": i18n.__("Other settings", "immotoolbox-connect"),
                                initialOpen: false,
                            },
                            [
                                el(
                                    TextareaControl,
                                    {
                                        value: props.attributes.manual,
                                        placeholder: "aaa=bbb ccc=ddd ...",
                                        onChange: function (newValue) { props.setAttributes( { manual: newValue } ) },
                                    }
                                )
                            ]
                        )
                    ]
                ),
                el(
                    "div",
                    {},
                    [
                        el("strong", {},
                            [
                                el(Icon, {icon: "search"}),
                                " "+i18n.__("ImmoToolBox Property Search", "immotoolbox-connect")
                            ]
                        ),
                        el(
                            "ul",
                            {},
                            [
                                (props.attributes.hide_type||props.attributes.hide_country||props.attributes.hide_city||props.attributes.hide_district||props.attributes.hide_price_max||props.attributes.hide_rooms||props.attributes.hide_area_min||props.attributes.hide_submit)?el(
                                    "li",
                                    {className: "itbconnect_subvalues"},
                                    [
                                        i18n.__("Hidden fields :", "immotoolbox-connect"),
                                        props.attributes.hide_type?el("span", {className: "itbconnect_label"}, i18n.__("Type", "immotoolbox-connect")):null,
                                        props.attributes.hide_country?el("span", {className: "itbconnect_label"}, i18n.__("Country", "immotoolbox-connect")):null,
                                        props.attributes.hide_city?el("span", {className: "itbconnect_label"}, i18n.__("City", "immotoolbox-connect")):null,
                                        props.attributes.hide_district?el("span", {className: "itbconnect_label"}, i18n.__("District", "immotoolbox-connect")):null,
                                        props.attributes.hide_price_max?el("span", {className: "itbconnect_label"}, i18n.__("Max. price", "immotoolbox-connect")):null,
                                        props.attributes.hide_rooms?el("span", {className: "itbconnect_label"}, i18n.__("Nb. rooms", "immotoolbox-connect")):null,
                                        props.attributes.hide_area_min?el("span", {className: "itbconnect_label"}, i18n.__("Min. area", "immotoolbox-connect")):null,
                                        props.attributes.hide_submit?el("span", {className: "itbconnect_label"}, i18n.__("Submit", "immotoolbox-connect")):null,
                                    ]
                                ):null,
                                ( props.attributes.type||props.attributes.country)?el(
                                    "li",
                                    {className: "itbconnect_subvalues"},
                                    [
                                        i18n.__("Default values :", "immotoolbox-connect"),
                                        props.attributes.type?el("span", {className: "itbconnect_label"}, i18n.__("Type", "immotoolbox-connect")+" : "+props.attributes.type):null,
                                        props.attributes.country?el("span", {className: "itbconnect_label"}, i18n.__("Country", "immotoolbox-connect")+" : "+props.attributes.country):null,
                                        props.attributes.city?el("span", {className: "itbconnect_label"}, i18n.__("City", "immotoolbox-connect")+" : "+props.attributes.city):null,
                                        props.attributes.district?el("span", {className: "itbconnect_label"}, i18n.__("District", "immotoolbox-connect")+" : "+props.attributes.district):null,
                                        props.attributes.building?el("span", {className: "itbconnect_label"}, i18n.__("Building", "immotoolbox-connect")+" : "+props.attributes.building):null,
                                        props.attributes.rooms?el("span", {className: "itbconnect_label"}, i18n.__("Rooms", "immotoolbox-connect")+" : "+props.attributes.rooms):null,
                                        props.attributes.price_min?el("span", {className: "itbconnect_label"}, i18n.__("Min. price", "immotoolbox-connect")+" : "+props.attributes.price_min):null,
                                        props.attributes.price_max?el("span", {className: "itbconnect_label"}, i18n.__("Max. price", "immotoolbox-connect")+" : "+props.attributes.price_max):null,
                                        props.attributes.price_on_request?el("span", {className: "itbconnect_label"}, i18n.__("Price on request", "immotoolbox-connect")+" : "+props.attributes.price_on_request):null,
                                        props.attributes.area_min?el("span", {className: "itbconnect_label"}, i18n.__("Min. area", "immotoolbox-connect")+" : "+props.attributes.area_min):null,
                                        props.attributes.featured?el("span", {className: "itbconnect_label"}, i18n.__("Featured", "immotoolbox-connect")):null,
                                        props.attributes.ids?el("span", {className: "itbconnect_label"}, i18n.__("IDs of properties to display", "immotoolbox-connect")):null,
                                        props.attributes.nids?el("span", {className: "itbconnect_label"}, i18n.__("IDs of properties to exclude", "immotoolbox-connect")):null,
                                        props.attributes.agency?el("span", {className: "itbconnect_label"}, i18n.__("Agency", "immotoolbox-connect")+" : "+props.attributes.agency):null,
                                    ]
                                ):null,
                                props.attributes.manual?(
                                    el(
                                        "li",
                                        {className: "itbconnect_subvalues"},
                                        [
                                            i18n.__("Other settings :", "immotoolbox-connect"),
                                            el("span", {className: "itbconnect_label"}, props.attributes.manual)
                                        ]
                                    )
                                ):null,
                            ]
                        )
                    ]
                ),
                el(
                    "pre",
                    {className: "wp-block-shortcode itbconnect_shortcode"},
                    search_shortcode_value(props)
                )


            )
        );
    },

    save: function( props) {
        return el( 'div', {  }, search_shortcode_value(props) );
    },
} );

function search_shortcode_value(props,)
{
    var code = '[itb_search';
    if (props.attributes.format) {
        code+=' format="'+props.attributes.format+'"';
    }
    if (props.attributes.hide_type) code+=' hide_type="1"';
    if (props.attributes.hide_country) code+=' hide_country="1"';
    if (props.attributes.hide_city) code+=' hide_city="1"';
    if (props.attributes.hide_district) code+=' hide_district="1"';
    if (props.attributes.hide_type) code+=' hide_type="1"';
    if (props.attributes.hide_price_max) code+=' hide_price_max="1"';
    if (props.attributes.hide_rooms) code+=' hide_rooms="1"';
    if (props.attributes.hide_area_min) code+=' hide_area_min="1"';
    if (props.attributes.hide_submit) code+=' hide_submit="1"';

    if (props.attributes.type) {
        code+=' type="'+props.attributes.type+'"';
    }
    if (props.attributes.country) {
        code+=' country="'+props.attributes.country+'"';
    }
    if (props.attributes.city) {
        code+=' city="'+props.attributes.city+'"';
    }
    if (props.attributes.district) {
        code+=' district="'+props.attributes.district+'"';
    }
    if (props.attributes.building) {
        code+=' building="'+props.attributes.building+'"';
    }
    if (props.attributes.rooms) {
        code+=' rooms="'+props.attributes.rooms+'"';
    }
    if (props.attributes.price_min) {
        code+=' price_min="'+props.attributes.price_min+'"';
    }
    if (props.attributes.price_max) {
        code+=' price_max="'+props.attributes.price_max+'"';
    }
    if (props.attributes.price_on_request) {
        code+=' price_on_request="'+props.attributes.price_on_request+'"';
    }
    if (props.attributes.area_min) {
        code+=' area_min="'+props.attributes.area_min+'"';
    }
    if (props.attributes.featured) {
        code+=' featured="1"';
    }
    if (props.attributes.ids) {
        code+=' ids="'+props.attributes.ids+'"';
    }
    if (props.attributes.nids) {
        code+=' nids="'+props.attributes.nids+'"';
    }
    if (props.attributes.agency) {
        code+=' agency="'+props.attributes.agency+'"';
    }

    if (props.attributes.manual) {
        code+=' '+props.attributes.manual;
    }

    code+= ']';

    return code;
}

