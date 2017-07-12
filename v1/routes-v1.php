<?php

$schema = new dspapi_schema;

add_action('rest_api_init', function(){
    global $schema;
    register_rest_route('dsp/v1', '/posts', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_posts_condensed',
            'args' => array(
                'page' => array(
                    'required' => false,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('Number of the page of results', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'integer',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_numeric($param);
                    }
                ),
                'per_page' => array(
                    'required' => false,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('Number of results per page', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'integer',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_numeric($param);
                    }
                ),
                'type' => array(
                    'required' => false,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('The post type.  Defaults to "any"', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'string',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_string($param);
                    }
                )
            )
        ),
        'schema' => array(
            $schema,
            'dspapi_get_posts_condensed_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema;
    register_rest_route('dsp/v1', '/posts/(?P<type>\S+)/(?P<per_page>\d+)/(?P<page>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_posts_condensed',
            'args' => array(
                'page' => array(
                    'required' => false,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('Number of the page of results', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'integer',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_numeric($param);
                    }
                ),
                'per_page' => array(
                    'required' => false,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('Number of results per page', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'integer',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_numeric($param);
                    }
                ),
                'type' => array(
                    'required' => false,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('The post type.  Defaults to "any"', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'string',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_string($param);
                    }
                )
            )
        ),
        'schema' => array(
            $schema,
            'dspapi_get_posts_condensed_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema;
    register_rest_route('dsp/v1', '/post/(?P<id>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_post_condensed',
            'args' => array()
        ),
        'schema' => array(
            $schema,
            'dspapi_get_post_condensed_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema;
    register_rest_route('dsp/v1', '/post/byslug/(?P<slug>\S+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_post_by_slug_condensed',
            'args' => array()
        ),
        'schema' => array(
            $schema,
            'dspapi_get_post_condensed_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    register_rest_route('dsp/v1', '/category/(?P<slug>\S+)', array(
        'methods' => 'GET',
        'callback' => 'dspapi_get_category_by_slug',
        'args' => array(
            'slug' => array(
                'required' => true,
                // description should be a human readable description of the argument.
                'description' => esc_html__('The category slug', 'my-text-domain'),
                // type specifies the type of data that the argument should be.
                'type' => 'string',
                'validate_callback' => function($param, $request, $key)
                {
                    return is_string($param);
                }
            )
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema;
    register_rest_route('dsp/v1', '/search/(?P<search>\S+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_search',
            'args' => array(
                'search' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('The search string', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'string',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_string($param);
                    }
                )
            )
        ),
        'schema' => array(
            $schema,
            'dspapi_search_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema;
    register_rest_route('dsp/v1', '/featured', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_featured',
            'args' => array()
        ),
        'schema' => array(
            $schema,
            'dspapi_get_featured_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema;
    register_rest_route('dsp/v1', '/random/withcategory/(?P<type>\S+)/(?P<category>\S+)/(?P<count>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_random_by_type',
            'args' => array(
                'type' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('The post type', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'string',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_string($param);
                    }
                ),
                'category' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('The post category', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'string',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_string($param);
                    }
                ),
                'count' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('The number of posts to return', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'integer',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_numeric($param);
                    }
                )
            )
        ),
        'schema' => array(
            $schema,
            'dspapi_get_random_by_type_with_category_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema;
    register_rest_route('dsp/v1', '/random/(?P<type>\S+)/(?P<count>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_random_by_type',
            'args' => array(
                'type' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('The post type', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'string',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_string($param);
                    }
                ),
                'count' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('The number of posts to return', 'my-text-domain'),
                    // type specifies the type of data that the argument should be.
                    'type' => 'integer',
                    'validate_callback' => function($param, $request, $key)
                    {
                        return is_numeric($param);
                    }
                )
            )
        ),
        'schema' => array(
            $schema,
            'dspapi_get_random_by_type_schema'
        )
    ));
});