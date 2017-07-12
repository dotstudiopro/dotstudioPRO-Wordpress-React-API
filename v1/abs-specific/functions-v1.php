<?php


/**
 * Get featured video and description for front page.
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_featured_home_options() {

  $youtube = get_option('dspabs_admin_featured_youtube') ? true : false;

  $options = new stdClass;
  $video = new stdClass;
  $bg = get_option('dspabs_site_bg', null);
  $description = get_option('dspabs_site_description', "");
  $blurb =  get_option('dspabs_site_blurb', "");

  $video->id = get_option('dspabs_featured_video_id', null);
  $video->name = get_option('dspabs_featured_video_name', null);

  $options->video = $video;
  if(wp_get_attachment_image_src( $bg, 'large' )){
    $img = wp_get_attachment_image_src( $bg, 'large' );
    $options->background = new stdClass;
    $options->background->url = $img[0];
    $options->background->width = $img[1];
    $options->background->height = $img[2];
    $options->background->generated = $img[3];
  }
  if(wp_get_attachment_image_src( $description, 'large' )){
    $img = wp_get_attachment_image_src( $description, 'large' );
    $options->description = new stdClass;
    $options->description->url = $img[0];
    $options->description->width = $img[1];
    $options->description->height = $img[2];
    $options->description->generated = $img[3];
  }
  if(wp_get_attachment_image_src( $blurb, 'large' )){
    $img = wp_get_attachment_image_src( $blurb, 'large' );
    $options->blurb = new stdClass;
    $options->blurb->url = $img[0];
    $options->blurb->width = $img[1];
    $options->blurb->height = $img[2];
    $options->blurb->generated = $img[3];
  }

  return $options;

}

/**
 * Get posts marked "featured" for the home carousel.
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_featured_home_carousel() {

  $posts = array();

  $args = array(
    'orderby'          => 'date',
    'order'            => 'DESC',
    'meta_key'         => 'dspabs_featured_home',
    'meta_value'       => '1',
    'post_status'      => 'publish',
    'suppress_filters' => true,
    'post_type'        => 'any'
  );

  $query = get_posts( $args );

  for($a=0;$a<count($query);$a++){
    $posts[$a] = dspapi_get_post_info($query[$a]);
  }

  return $posts;

}

/**
 * Get posts marked "featured" for the blog.
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_featured_blog() {

  $posts = array();

  $args = array(
    'orderby'          => 'date',
    'order'            => 'DESC',
    'meta_key'         => 'dspabs_featured_blog',
    'meta_value'       => '1',
    'post_status'      => 'publish',
    'suppress_filters' => true,
    'post_type'        => 'any'
  );

  $query = get_posts( $args );

  for($a=0;$a<count($query);$a++){
    $posts[$a] = dspapi_get_post_info($query[$a], 'dspabs-blog-carousel-crop');
    $posts[$a]->blog_options = new stdClass;
    $type = $posts[$a]->post_type == "look" ? "get_the_look" : $posts[$a]->post_type . "s";
    $posts[$a]->blog_options->title = get_option("dspabs_" . $type . "_card_title", null);
    $posts[$a]->blog_options->title_bg = get_option("dspabs_" . $type . "_card_title_bg", null);
  }

  return $posts;

}

/**
 * Get posts marked "featured" for the show page.
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_featured_show_carousel() {

  $posts = array();

  $args = array(
    'orderby'          => 'date',
    'order'            => 'DESC',
    'meta_key'         => 'dspabs_featured_show',
    'meta_value'       => '1',
    'post_status'      => 'publish',
    'suppress_filters' => true,
    'post_type'        => 'any'
  );

  $query = get_posts( $args );

  for($a=0;$a<count($query);$a++){
    $posts[$a] = dspapi_get_post_info($query[$a], 'dspabs-show-carousel-crop');
  }

  return $posts;

}

/**
 * Get posts marked "featured" for the show page.
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_featured_show_sections() {

  $posts = array();

  $args = array(
    'orderby'          => 'date',
    'order'            => 'DESC',
    'meta_key'         => 'dspabs_featured_show_section',
    'meta_value'       => '1',
    'post_status'      => 'publish',
    'suppress_filters' => true,
    'post_type'        => 'any'
  );

  $query = get_posts( $args );

  for($a=0;$a<count($query);$a++){
    $meta = get_post_custom($query[$a]->ID);
    $image_size = isset($meta['dspabs_featured_show_card_size']) && $meta['dspabs_featured_show_card_size'][0] == 'long' ? 'dspabs-show-card-long-crop' : 'dspabs-show-card-short-crop';
    $image_crop = 'center-center';
    if(isset($meta['dspabs_featured_show_card_image_crop'])){
      $image_crop = $meta['dspabs_featured_show_card_image_crop'][0];
    }
    $image_size .= "-$image_crop";

    $posts[$a] = dspapi_get_post_info($query[0]);
    $posts[$a]->image_size = $image_size;
    $posts[$a]->image_crop = $image_crop;
  }

  return $posts;

}

/**
 * Get the latest show object.
 * @return object|null The latest show post, or null if none exist
 */
function dspapi_get_page_show() {

	$posts = get_posts(array(
		  	'post_status'      =>'publish',
		  	'post_type' 	   => 'show',
			'orderby'          => 'date',
			'order'            => 'DESC'
			)
  		);

	if(empty($posts)){
		return null;
	}

  $post = dspapi_get_post_info($posts[0]);

	return $post;

}

/**
 * Get the latest host object.
 * @return object|null The latest host post, or null if none exist
 */
function dspapi_get_page_host() {

	$posts = get_posts(array(
		  	'post_status'      =>'publish',
		  	'post_type' 	     => 'host',
  			'orderby'          => 'date',
  			'order'            => 'DESC'
  			)
  		);

	if(empty($posts)){
		return null;
	}

  $post = dspapi_get_post_info($posts[0]);

  return $post;

}

/**
 * Get the latest host object.
 * @return object|null The latest host post, or null if none exist
 */
function dspapi_get_page_judges() {

  $posts = get_posts(array(
          'post_status'      => 'publish',
          'post_type'        => 'judge',
          'orderby'          => 'date',
          'order'            => 'DESC'
        )
      );

  if(empty($posts)){
    return null;
  }

  foreach($posts as $post){
    $post = dspapi_get_post_info($post);
  }

  return $posts;

}

/**
 * Get the latest judge object.
 * @return object|null The latest host post, or null if none exist
 */
function dspapi_get_page_judges_active() {

  $posts = get_posts(array(
          'post_status'      => 'publish',
          'post_type'        => 'judge',
          'meta_key'         => 'dspabs_judge_active',
          'meta_value'       => 1,
          'orderby'          => 'post_title',
          'order'            => 'ASC'
        )
      );

  if(empty($posts)){
    return null;
  }

  $judges_main = [];
  $judges_temp = [];

  foreach($posts as $post){

    $main = false;

    $post = dspapi_get_post_info($post);

    if(!empty($post->meta['dspabs_judge_main']) && $post->meta['dspabs_judge_main'][0] == 1){
      $main = true;
    }

    if($main){
      $judges_main[] = $post;
    } else {
      $judges_temp[] = $post;
    }
  }

  $judges = array_merge($judges_main, $judges_temp);

  return $judges;

}

/**
 * Get the latest judge object.
 * @return object|null The latest host post, or null if none exist
 */
function dspapi_get_page_judge($data) {

	if(empty($data['id'])) return null;

	$posts = get_posts(array(
			 'post_ID'           => $data['id'],
		  	'post_status'      => 'publish',
		  	'post_type' 	     => 'judge',
  			'orderby'          => 'date',
  			'order'            => 'DESC'
  			)
  		);

	if(empty($posts)){
		return null;
	}

  $post = dspapi_get_post_info($posts[0]);

	return $post;

}

/**
 * Get a contestant object by post ID.
 * @param  array $data Array with the ID of the contestant being requested
 * @return object|null The contestant post, or null if none exist
 */
function dspapi_get_page_contestant($data) {

	if(empty($data['id'])) return null;

	$posts = get_posts(array(
		  	'post_ID'      	   => $data['id'],
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'contestant',
			'orderby'          => 'date',
			'order'            => 'DESC'
			)
  		);

	if(empty($posts)){
		return null;
	}

	$post = $posts[0];

	$meta = get_post_custom($post->ID);

	$filtered_meta = new stdClass;

	$filtered_meta->social_feed_facebook = $meta['social_feed_facebook'][0];

	$filtered_meta->social_feed_twitter = $meta['social_feed_twitter'][0];

	$filtered_meta->social_feed_instagram = $meta['social_feed_instagram'][0];

	$filtered_meta->social_feed_snapchat = $meta['social_feed_snapchat'][0];

	$filtered_meta->social_feed_linkedin = $meta['social_feed_linkedin'][0];

	$filtered_meta->custom_featured = $meta['dsp_custom_featured'][0];

	$filtered_meta->youtube = $meta['dspabs_youtube'][0];

	$filtered_meta->headshot = !empty($meta['headshot']) && is_numeric($meta['headshot'][0]) ? wp_get_attachment_image_src($meta['headshot'][0])[0] : null;

	if(is_numeric($meta['look'][0])){
		$look = get_posts(array(
			'post_ID'          => $meta['look'][0],
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'look',
			'orderby'          => 'date',
			'order'            => 'DESC'
			)
  		);

  		if(!empty($look)){
  			$look_post = $look[0];
  			$look_meta = get_post_custom($look[0]->ID);
  			$filtered_look_meta = new stdClass;
  			$filtered_look_meta->before_desc = $look_meta['before_desc'][0];
  			$filtered_look_meta->after_desc = $look_meta['after_desc'][0];
  			$filtered_look_meta->before_image = !empty($look_meta['before_image']) && is_numeric($look_meta['before_image'][0]) ? wp_get_attachment_image_src($look_meta['before_image'][0])[0] : null;
  			$filtered_look_meta->after_image = !empty($look_meta['after_image']) && is_numeric($look_meta['after_image'][0]) ? wp_get_attachment_image_src($look_meta['after_image'][0])[0] : null;
  			// Buy it now carousel bit is stored as JSON so it doesn't serialize in the DB
  			$btl = json_decode($look_meta['buy_the_look'][0]);
  			if($btl){
  				foreach($btl as $b){
  					if(is_numeric($b->image)) $b->image = wp_get_attachment_image_src($b->image)[0];
  				}
  			}
  			$filtered_look_meta->buy_the_look = $btl;
  			$look_post->meta = $filtered_look_meta;
	  		$filtered_meta->look = $look_post;
  		}
	}

	if(is_numeric($meta['teammate'][0])){
		$teammate = get_posts(array(
			'post_ID'          => $meta['teammate'][0],
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'teammate',
			'orderby'          => 'date',
			'order'            => 'DESC'
			)
  		);

  		if(!empty($teammate)){
  			$teammate_post = $teammate[0];
  			$teammate_meta = get_post_custom($teammate[0]->ID);
  			$filtered_teammate_meta = new stdClass;
  			$filtered_teammate_meta->headshot = !empty($teammate_meta['headshot']) && is_numeric($teammate_meta['headshot'][0]) ? wp_get_attachment_image_src($teammate_meta['headshot'][0])[0] : null;

  			$filtered_teammate_meta->social_feed_facebook = $teammate_meta['social_feed_facebook'][0];

			$filtered_teammate_meta->social_feed_twitter = $teammate_meta['social_feed_twitter'][0];

			$filtered_teammate_meta->social_feed_instagram = $teammate_meta['social_feed_instagram'][0];

			$filtered_teammate_meta->social_feed_snapchat = $teammate_meta['social_feed_snapchat'][0];

			$filtered_teammate_meta->social_feed_linkedin = $teammate_meta['social_feed_linkedin'][0];

			$filtered_teammate_meta->custom_featured = $teammate_meta['dsp_custom_featured'][0];

  			$teammate_post->meta = $filtered_teammate_meta;
	  		$filtered_meta->teammate = $teammate_post;
  		}
	}

	if(!$filtered_meta->youtube) $filtered_meta->video_id = $meta['dspabs_video_id'][0];

	if(!$filtered_meta->youtube) $filtered_meta->video_name = $meta['dspabs_video_name'][0];

	$post->meta = $filtered_meta;

	return $post;

}

/**
 * Get all contestant objects.
 * @return object|null The contestant post, or null if none exist
 */
function dspapi_get_page_contestants() {

	$meta_key = "";
	$meta_value = "";

	// If we are requesting active, we set up the meta key and meta value vars
	if(strpos($_SERVER['REQUEST_URI'], 'active') !== false){
		$meta_key = "dsp_contestant_active";
		$meta_value = "1";
	}

	$posts = get_posts(array(
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'contestant',
			'orderby'          => 'date',
			'order'            => 'DESC',
			'meta_key'         => $meta_key,
			'meta_value'       => $meta_value
			)
  		);

	if(empty($posts)){
		return null;
	}

	foreach($posts as $post){

		$meta = get_post_custom($post->ID);

		$filtered_meta = new stdClass;

		$filtered_meta->social_feed_facebook = $meta['social_feed_facebook'][0];

		$filtered_meta->social_feed_twitter = $meta['social_feed_twitter'][0];

		$filtered_meta->social_feed_instagram = $meta['social_feed_instagram'][0];

		$filtered_meta->social_feed_snapchat = $meta['social_feed_snapchat'][0];

		$filtered_meta->social_feed_linkedin = $meta['social_feed_linkedin'][0];

		$filtered_meta->custom_featured = $meta['dsp_custom_featured'][0];

		$filtered_meta->youtube = $meta['dspabs_youtube'][0];

		$filtered_meta->headshot = !empty($look_meta['headshot']) && is_numeric($meta['headshot'][0]) ? wp_get_attachment_image_src($meta['headshot'][0])[0] : null;

		if(is_numeric($meta['look'][0])){
			$look = get_posts(array(
				'post_ID'          => $meta['look'][0],
			  	'post_status'      => 'publish',
			  	'post_type' 	   => 'look',
				'orderby'          => 'date',
				'order'            => 'DESC'
				)
	  		);

	  		if(!empty($look)){
	  			$look_post = $look[0];
	  			$look_meta = get_post_custom($look[0]->ID);
	  			$filtered_look_meta = new stdClass;
	  			$filtered_look_meta->before_desc = $look_meta['before_desc'][0];
	  			$filtered_look_meta->after_desc = $look_meta['after_desc'][0];
	  			$filtered_look_meta->before_image = !empty($look_meta['before_image']) && is_numeric($look_meta['before_image'][0]) ? wp_get_attachment_image_src($look_meta['before_image'][0])[0] : null;
	  			$filtered_look_meta->after_image = !empty($look_meta['after_image']) && is_numeric($look_meta['after_image'][0]) ? wp_get_attachment_image_src($look_meta['after_image'][0])[0] : null;
	  			// Buy it now carousel bit is stored as JSON so it doesn't serialize in the DB
	  			$btl = json_decode($look_meta['buy_the_look'][0]);
	  			if($btl){
	  				foreach($btl as $b){
	  					if(is_numeric($b->image)) $b->image = wp_get_attachment_image_src($b->image)[0];
	  				}
	  			}
	  			$filtered_look_meta->buy_the_look = $btl;
	  			$look_post->meta = $filtered_look_meta;
		  		$filtered_meta->look = $look_post;
	  		}
		}

		if(is_numeric($meta['teammate'][0])){
			$teammate = get_posts(array(
				'post_ID'          => $meta['teammate'][0],
			  	'post_status'      => 'publish',
			  	'post_type' 	   => 'teammate',
				'orderby'          => 'date',
				'order'            => 'DESC'
				)
	  		);

	  		if(!empty($teammate)){
	  			$teammate_post = $teammate[0];
	  			$teammate_meta = get_post_custom($teammate[0]->ID);
	  			$filtered_teammate_meta = new stdClass;
	  			$filtered_teammate_meta->headshot = !empty($teammate_meta['headshot']) && is_numeric($teammate_meta['headshot'][0]) ? wp_get_attachment_image_src($teammate_meta['headshot'][0])[0] : null;

	  			$filtered_teammate_meta->social_feed_facebook = $teammate_meta['social_feed_facebook'][0];

				$filtered_teammate_meta->social_feed_twitter = $teammate_meta['social_feed_twitter'][0];

				$filtered_teammate_meta->social_feed_instagram = $teammate_meta['social_feed_instagram'][0];

				$filtered_teammate_meta->social_feed_snapchat = $teammate_meta['social_feed_snapchat'][0];

				$filtered_teammate_meta->social_feed_linkedin = $teammate_meta['social_feed_linkedin'][0];

				$filtered_teammate_meta->custom_featured = $teammate_meta['dsp_custom_featured'][0];

	  			$teammate_post->meta = $filtered_teammate_meta;
		  		$filtered_meta->teammate = $teammate_post;
	  		}
		}

		if(!$filtered_meta->youtube) $filtered_meta->video_id = $meta['dspabs_video_id'][0];

		if(!$filtered_meta->youtube) $filtered_meta->video_name = $meta['dspabs_video_name'][0];

		$post->meta = $filtered_meta;

	}

	return $posts;

}

/**
 * Get a look object by post ID.
 * @param  array $data Array with the ID of the look being requested
 * @return object|null The look post, or null if none exist
 */
function dspapi_get_page_look($data) {

	if(empty($data['id'])) return null;

	$posts = get_posts(array(
		  	'post_ID'      	   => $data['id'],
		  	'post_status'      => 'publish',
		  	'post_type' 	     => 'look',
  			'orderby'          => 'date',
  			'order'            => 'DESC'
  			)
  		);

	if(empty($posts)){
		return null;
	}

  $post = dspapi_get_post_info($posts[0], 'article_categories');

	return $post;

}

/**
 * Get all looks.
 * @return object|null The look post, or null if none exist
 */
function dspapi_get_page_looks() {

	$posts = get_posts(array(
		  	'post_status'      => 'publish',
		  	'post_type' 	     => 'look',
  			'orderby'          => 'date',
  			'order'            => 'DESC'
  			)
  		);

	if(empty($posts)){
		return null;
	}

	foreach($posts as $post){

    $post = dspapi_get_post_info($post, 'look_categories');

  }

	return $posts;

}

/**
 * Get all looks that have the specified taxonomy.
 * @return object|null The look posts, or null if none exist
 */
function dspapi_get_page_looks_by_taxonomy($data) {

  if(!$data['term']) return new WP_Error( 'rest_no_tax_term', __( 'A term is required for this method.' ), array( 'status' => 500 ) );

  $terms = get_terms( array(
      'taxonomy' => 'look_categories',
      'slug' => $data['term'],
      'hide_empty' => false,
  ) );

  if(empty($terms) || !is_array($terms)){
    return null;
  }

  $posts = get_posts(array(
        'post_status'      => 'publish',
        'post_type'        => 'look',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'tax_query' => array(
            array(
                  'taxonomy' => 'look_categories',
                  'field' => 'slug',
                  'terms' => array($data['term']),
                  'operator' => 'IN'
              )
          )
        )
      );

  if(empty($posts) || !is_array($posts)){
    return null;
  }

  foreach($posts as $post){

    $post = dspapi_get_post_info($post, 'look_categories');

  }

  return $posts;

}

/**
 * Get a tutorial object by post ID.
 * @param  array $data Array with the ID of the tutorial being requested
 * @return object|null The tutorial post, or null if none exist
 */
function dspapi_get_page_tutorial($data) {

	if(empty($data['id'])) return null;

	$posts = get_posts(array(
		  	'post_ID'      	   => $data['id'],
		  	'post_status'      => 'publish',
		  	'post_type' 	     => 'tutorial',
  			'orderby'          => 'date',
  			'order'            => 'DESC'
  			)
  		);

	if(empty($posts)){
		return null;
	}

  $post = dspapi_get_post_info($posts[0], 'tutorial_categories');

	return $post;

}

/**
 * Get all tutorials.
 * @return object|null The tutorial post, or null if none exist
 */
function dspapi_get_page_tutorials() {

  $posts = get_posts(array(
        'post_status'      => 'publish',
        'post_type'        => 'tutorial',
        'orderby'          => 'date',
        'order'            => 'DESC'
        )
      );

  if(empty($posts)){
    return null;
  }

  foreach($posts as $post){

    $post = dspapi_get_post_info($post, 'tutorial_categories');

  }

  return $posts;

}

/**
 * Get all tutorials that have the specified taxonomy.
 * @return object|null The tutorial posts, or null if none exist
 */
function dspapi_get_page_tutorials_by_taxonomy($data) {

  if(!$data['term']) return new WP_Error( 'rest_no_tax_term', __( 'A term is required for this method.' ), array( 'status' => 500 ) );

  $terms = get_terms( array(
      'taxonomy' => 'tutorial_categories',
      'slug' => $data['term'],
      'hide_empty' => false,
  ) );

  if(empty($terms) || !is_array($terms)){
    return null;
  }

  $posts = get_posts(array(
        'post_status'      => 'publish',
        'post_type'        => 'tutorial',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'tax_query' => array(
            array(
                  'taxonomy' => 'tutorial_categories',
                  'field' => 'slug',
                  'terms' => array($data['term']),
                  'operator' => 'IN'
              )
          )
        )
      );

  if(empty($posts) || !is_array($posts)){
    return null;
  }

  foreach($posts as $post){

    $post = dspapi_get_post_info($post, 'tutorial_categories');

  }

  return $posts;

}

/**
 * Get a article object by post ID.
 * @param  array $data Array with the ID of the article being requested
 * @return object|null The article post, or null if none exist
 */
function dspapi_get_page_article($data) {

	if(empty($data['id'])) return null;

	$posts = get_posts(array(
		  	'post_ID'      	   => $data['id'],
		  	'post_status'      => 'publish',
		  	'post_type' 	     => 'article',
  			'orderby'          => 'date',
  			'order'            => 'DESC'
  			)
  		);

	if(empty($posts)){
		return null;
	}

  $post = dspapi_get_post_info($posts[0], 'article_categories');

	return $post;

}

/**
 * Get all articles.
 * @return object|null The article post, or null if none exist
 */
function dspapi_get_page_articles() {

	$posts = get_posts(array(
		  	'post_status'      => 'publish',
		  	'post_type' 	     => 'article',
  			'orderby'          => 'date',
  			'order'            => 'DESC'
  			)
  		);

	if(empty($posts)){
		return null;
	}

	foreach($posts as $post){

    $post = dspapi_get_post_info($post, 'article_categories');

  }

	return $posts;

}

/**
 * Get all articles that have the specified taxonomy.
 * @return object|null The article posts, or null if none exist
 */
function dspapi_get_page_articles_by_taxonomy($data) {

  if(!$data['term']) return new WP_Error( 'rest_no_tax_term', __( 'A term is required for this method.' ), array( 'status' => 500 ) );

  $terms = get_terms( array(
      'taxonomy' => 'article_categories',
      'slug' => $data['term'],
      'hide_empty' => false,
  ) );

  if(empty($terms) || !is_array($terms)){
    return null;
  }

  $posts = get_posts(array(
        'post_status'      => 'publish',
        'post_type'        => 'article',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'tax_query' => array(
            array(
                  'taxonomy' => 'article_categories',
                  'field' => 'slug',
                  'terms' => array($data['term']),
                  'operator' => 'IN'
              )
          )
        )
      );

  if(empty($posts) || !is_array($posts)){
    return null;
  }

  foreach($posts as $post){

    $post = dspapi_get_post_info($post, 'article_categories');

  }

  return $posts;

}

/**
 * Get a aired episode object by post ID.
 * @param  array $data Array with the ID of the aired_episode being requested
 * @return object|null The aired episode post, or null if none exist
 */
function dspapi_get_page_aired_episode($data) {

	if(empty($data['id'])) return null;

	$posts = get_posts(array(
		  	'post_ID'      	   => $data['id'],
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'airedepisode',
			'orderby'          => 'date',
			'order'            => 'DESC'
			)
  		);

	if(empty($posts)){
		return null;
	}

  $post = dspapi_get_post_info($posts[0]);

	return $post;

}

/**
 * Get all aired episodes.
 * @return object|null The aired episode post, or null if none exist
 */
function dspapi_get_page_aired_episodes() {

	$posts = get_posts(array(
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'airedepisode',
			'orderby'          => 'date',
			'order'            => 'DESC'
			)
  		);

	if(empty($posts)){
		return null;
	}

	foreach($posts as $post){

    $post = dspapi_get_post_info($post);

	}

	return $posts;

}

/**
 * Get an aired episode object by post ID.
 * @return object|null The aired episode post, or null if none exist
 */
function dspapi_get_page_last_episode() {

	$posts = get_posts(array(
		  	'post_status'      => 'publish',
		  	'post_type' 	     => 'airedepisode',
  			'orderby'          => 'date',
  			'order'            => 'DESC',
  			'limit'            => 1
  			)
  		);

	if(empty($posts)){
		return null;
	}

  $post = dspapi_get_post_info($posts[0]);

	return $post;

}

/**
 * Get all schedule objects.
 * @return array|null The schedule posts, or null if none exist
 */
function dspapi_get_page_schedules() {

	$posts = get_posts(array(
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'schedule',
			'orderby'          => 'date',
			'order'            => 'DESC',
	    	'per_page'         => '50',
			)
  		);

	if(empty($posts)){
		return null;
	}

	foreach($posts as $post){

    $post = dspapi_get_post_info($post);

	}

	return $posts;

}

/**
 * Get all schedule objects in a timestamp range.
 * @return array|null The schedule posts, or null if none exist
 */
function dspapi_get_page_schedules_range($data) {

	$start = !empty($data['start']) ? $data['start'] : 0;

	$query = array(
				array(
	            'key' => 'schedule_time',
	            'value' => $start,
	            'compare' => '>='
	        	)
			);

	if(!empty($data['end'])){

		$query[] = array(
		            'key' => 'schedule_time',
		            'value' => $data['end'] > $data['start'] ? $data['end'] : $data['start']+1,
		            'compare' => '<='
	        	);
	}

	$args = array(
	    'post_type' => 'schedule',
	    'posts_per_page' => '50',
	    'meta_query' => $query,
	    'orderby' => 'meta_value_num',
	    'order' => 'DESC'
	);

	$posts = (new WP_Query($args))->posts;

	if(empty($posts)){
		return null;
	}

	foreach($posts as $post){

		$post = dspapi_get_post_info($post);

	}

	return $posts;

}

/**
 * Get a contest object by post ID.
 * @param  array $data Array with the ID of the contest being requested
 * @return object|null The contest post, or null if none exist
 */
function dspapi_get_page_contest($data) {

	if(empty($data['id'])) return null;

	$posts = get_posts(array(
		  	'post_ID'      	   => $data['id'],
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'contest',
			'orderby'          => 'date',
			'order'            => 'DESC'
			)
  		);

	if(empty($posts)){
		return null;
	}

	$post = dspapi_get_post_info($posts[0], 'contest_categories');

	return $post;

}

/**
 * Get all contests.
 * @return object|null The contest post, or null if none exist
 */
function dspapi_get_page_contests() {

	$posts = get_posts(array(
		  	'post_status'      => 'publish',
		  	'post_type' 	   => 'contest',
			'orderby'          => 'date',
			'order'            => 'DESC'
			)
  		);

	if(empty($posts)){
		return null;
	}

  foreach($posts as $post){

    $post = dspapi_get_post_info($post, 'contest_categories');

  }

	return $posts;

}

/**
 * Get all contests that have the specified taxonomy.
 * @return object|null The contest posts, or null if none exist
 */
function dspapi_get_page_contests_by_taxonomy($data) {

  if(!$data['term']) return new WP_Error( 'rest_no_tax_term', __( 'A term is required for this method.' ), array( 'status' => 500 ) );

  $terms = get_terms( array(
      'taxonomy' => 'contest_categories',
      'slug' => $data['term'],
      'hide_empty' => false,
  ) );

  if(empty($terms) || !is_array($terms)){
    return null;
  }

  $posts = get_posts(array(
        'post_status'      => 'publish',
        'post_type'        => 'contest',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'tax_query' => array(
            array(
                  'taxonomy' => 'contest_categories',
                  'field' => 'slug',
                  'terms' => array($data['term']),
                  'operator' => 'IN'
              )
          )
        )
      );

  if(empty($posts) || !is_array($posts)){
    return null;
  }

  foreach($posts as $post){

    $post = dspapi_get_post_info($post, 'contest_categories');

  }

  return $posts;

}

/**
 * Get featured blog posts for a post type.
 * @return object|null The contest post, or null if none exist
 */
function dspapi_get_featured_blog_posts_by_type($type, $first = false) {

  $posts = get_posts(array(
        'post_status'      => 'publish',
        'post_type'        =>  $type,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'meta_key'         => 'dspabs_featured_blog',
        'meta_value'       => '1',
      )
      );

  if(empty($posts)){
    return null;
  }

  foreach($posts as $post){

    $post = dspapi_get_post_info($post);

    $post->thumb = get_the_post_thumbnail_url($post->ID) ?: "";

  }

  return $first ? $posts[0] : $posts;

}

/**
 * Get blog page featured details and featured post IDs
 * @return object The options for the blog featured details and the most recent featured post ID
 */
function dspapi_get_blog_featured_details() {

	// Watch
	$watch_post = get_option('dspabs_watch_card_featured_post', false);
	$watch = new stdClass;
	$watch->title = get_option('dspabs_watch_card_title', false) ?: null;
	$watch->title_bg = get_option('dspabs_watch_card_title_bg', false) ?: null;
	$watch->featured_post = $watch_post ? get_post($watch_post) : null;
	if($watch->featured_post) $watch->featured_post->categories = get_the_category( $watch_post );
	if(get_option('dspabs_watch_card_image_choice', false) == 1 && get_option('dspabs_watch_card_image', false)){
		$watch->image = wp_get_attachment_image_src(get_option('dspabs_watch_card_image'))[0];
	} else {
		$watch->image = get_post_status ( $watch->featured_post ) == 'publish' ? get_the_post_thumbnail_url($watch_post ?: 0) : null;
	}

	// Get the look
	$get_the_look_post = get_option('dspabs_get_the_look_card_featured_post', false);
	$get_the_look = new stdClass;
	$get_the_look->title = get_option('dspabs_get_the_look_card_title', false) ?: null;
	$get_the_look->title_bg = get_option('dspabs_get_the_look_card_title_bg', false) ?: null;
	$get_the_look->featured_post = $get_the_look_post ? get_post($get_the_look_post) : null;
	if($get_the_look->featured_post) $get_the_look->featured_post->categories = get_the_category( $get_the_look );
	if(get_option('dspabs_get_the_look_card_image_choice', false) == 1 && get_option('dspabs_get_the_look_card_image', false)){
		$get_the_look->image = wp_get_attachment_image_src(get_option('dspabs_get_the_look_card_image'))[0];
	} else {
		$get_the_look->image = get_post_status ( $get_the_look->featured_post ) == 'publish' ? get_the_post_thumbnail_url( $get_the_look_post ?: 0 ) : null;
	}

	// Tutorials
	$tutorials_post = get_option('dspabs_tutorials_card_featured_post', false);
	$tutorials = new stdClass;
	$tutorials->title = get_option('dspabs_tutorials_card_title', false) ?: null;
	$tutorials->title_bg = get_option('dspabs_tutorials_card_title_bg', false) ?: null;
	$tutorials->featured_post = $tutorials_post ? get_post($tutorials_post) : null;
	if($tutorials->featured_post) $tutorials->featured_post->categories = get_the_category( $tutorials_post );
	if(get_option('dspabs_tutorials_card_image_choice', false) == 1 && get_option('dspabs_tutorials_card_image', false)){
		$tutorials->image = wp_get_attachment_image_src(get_option('dspabs_tutorials_card_image'))[0];
	} else {
		$tutorials->image = get_post_status ( $tutorials->featured_post ) == 'publish' ? get_the_post_thumbnail_url( $tutorials_post ?: 0 ) : null;
	}

	// Contests
	$contests_post = get_option('dspabs_contests_card_featured_post', false);
	$contests = new stdClass;
	$contests->title = get_option('dspabs_contests_card_title', false) ?: null;
	$contests->title_bg = get_option('dspabs_contests_card_title_bg', false) ?: null;
	$contests->featured_post = $contests_post ? get_post($contests_post) : null;
	if($contests->featured_post) $contests->featured_post->categories = get_the_category( $contests_post );
	if(get_option('dspabs_contests_card_image_choice', false) == 1 && get_option('dspabs_contests_card_image', false)){
		$contests->image = wp_get_attachment_image_src(get_option('dspabs_contests_card_image'))[0];
	} else {
		$contests->image = get_post_status ( $contests->featured_post ) == 'publish' ? get_the_post_thumbnail_url( $contests_post ?: 0 ) : null;
	}

	$blog = new stdClass;
	$blog->watch = $watch;
	$blog->get_the_look = $get_the_look;
	$blog->tutorials = $tutorials;
	$blog->contests = $contests;

	return $blog;

}