<?php

$schema_abs = new dspapi_abs_schema;

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/featured/home/options', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_featured_home_options',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_featured_home_video_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/featured/home/carousel', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_featured_home_carousel',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_featured_home_carousel_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/featured/blog/carousel', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_featured_blog',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_featured_blog_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/featured/blog/sections', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_blog_featured_details',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_blog_featured_details_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/featured/show/carousel', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_featured_show_carousel',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_featured_show_carousel_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/featured/show/sections', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_featured_show_sections',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_featured_show_sections_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/show', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_show',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_show_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/host', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_host',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_host_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/contestants', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_contestants',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_contestants_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/contestants/active', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_contestants',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_contestants_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/contestants/byid/(?P<id>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_contestant',
            'args' => array(
                'id' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('ID of the contestant post', 'my-text-domain'),
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
            $schema_abs,
            'dspapi_get_page_contestant_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/judges', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_judges',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_judges_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/judges/active', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_judges_active',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_judges_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/judges/byid/(?P<id>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_judge',
            'args' => array(
                'id' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('ID of the judge post', 'my-text-domain'),
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
            $schema_abs,
            'dspapi_get_page_judge_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/looks', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_looks',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_looks_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/looks/bytaxonomy/(?P<term>\S+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_looks_by_taxonomy',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_looks_by_taxonomy_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/looks/byid/(?P<id>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_look',
            'args' => array(
                'id' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('ID of the look post', 'my-text-domain'),
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
            $schema_abs,
            'dspapi_get_page_look_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/tutorials', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_tutorials',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_tutorials_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/tutorials/bytaxonomy/(?P<term>\S+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_tutorials_by_taxonomy',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_tutorials_by_taxonomy_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/tutorials/byid/(?P<id>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_tutorial',
            'args' => array(
                'id' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('ID of the tutorial post', 'my-text-domain'),
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
            $schema_abs,
            'dspapi_get_page_tutorial_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/articles', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_articles',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_articles_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/articles/bytaxonomy/(?P<term>\S+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_articles_by_taxonomy',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_articles_by_taxonomy_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/articles/byid/(?P<id>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_article',
            'args' => array(
                'id' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('ID of the article post', 'my-text-domain'),
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
            $schema_abs,
            'dspapi_get_page_article_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/last_episode', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_last_episode',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_last_episode_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/aired_episodes', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_aired_episodes',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_aired_episodes_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/aired_episodes/byid/(?P<id>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_aired_episode',
            'args' => array(
                'id' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('ID of the aired_episode post', 'my-text-domain'),
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
            $schema_abs,
            'dspapi_get_page_aired_episode_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/schedules', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_schedules',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_schedules_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/schedules/(?P<start>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_schedules_range',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_schedules_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/schedules/(?P<start>\d+)/(?P<end>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_schedules_range',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_schedules_by_range_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/contests', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_contests',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_contests_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/contests/bytaxonomy/(?P<term>\S+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_contests_by_taxonomy',
            'args' => array()
        ),
        'schema' => array(
            $schema_abs,
            'dspapi_get_page_contests_by_taxonomy_schema'
        )
    ));
});

add_action('rest_api_init', function(){
    global $schema_abs;
    register_rest_route('dsp/v1', '/page/contests/byid/(?P<id>\d+)', array(
        array(
            'methods' => 'GET',
            'callback' => 'dspapi_get_page_contest',
            'args' => array(
                'id' => array(
                    'required' => true,
                    // description should be a human readable description of the argument.
                    'description' => esc_html__('ID of the contest post', 'my-text-domain'),
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
            $schema_abs,
            'dspapi_get_page_contest_schema'
        )
    ));
});