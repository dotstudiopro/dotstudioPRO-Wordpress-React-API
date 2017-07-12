<?php


/**
 * Return all posts with fewer fields than /wp/v2/posts
 * @param array $data An array with options for grabbing posts.
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_posts_condensed( $data ) {

  $ppp = 5;
  $offset = 0;

  if($data['per_page'] && is_numeric($data['per_page'])) $ppp = $data['per_page'];

  if($data['page'] && is_numeric($data['page'])) $offset = floor( $ppp * ($data['page']-1) );

  $posts = get_posts(array("post_status"=>"publish", 'post_type' => $data['type'] ?: 'any','posts_per_page' => $ppp, 'offset' => ($offset > 0 ? $offset : 0)));

  if ( empty( $posts ) ) {
    return [];
  }

  $smallerPosts = [];

  // Store only the useful objects we plan on returning
  foreach($posts as $k => $p){
  	$smallerPosts[$k] = (object) array("ID"=>$p->ID, "post_author"=>$post->post_author, "post_modified"=>$p->post_modified, "post_date"=>$p->post_date, "post_name"=>$p->post_name, "post_content"=>$p->post_content, "post_title"=>$p->post_title);
    $smallerPosts[$k] = dspapi_get_post_info($smallerPosts[$k]);
  }

  return $smallerPosts;
}

/**
 * Return a post with fewer fields than /wp/v2/posts/{id}
 * @param array $data An array with the id of the post.
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_post_condensed( $data ) {

  // If we don't have an id, then we can't call a post
  if(!$data['id']) return null;

  $post = get_post($data['id']);

  if ( empty( $post ) ) {
    return null;
  }

  // Store only the useful objects we plan on returning
  $smallerPost = (object) array("ID"=>$post->ID, "post_author"=>$post->post_author, "post_modified"=>$post->post_modified, "post_date"=>$post->post_date, "post_name"=>$post->post_name, "post_content"=>$post->post_content, "post_title"=>$post->post_title, "post_type"=>$post->post_type);

  $smallerPost = dspapi_get_post_info($smallerPost);

  return $smallerPost;
}

/**
 * Return a post with fewer fields than /wp/v2/posts/{id}, and get the post by slug instead of ID
 * @param array $data An array with the slug of the post.
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_post_by_slug_condensed( $data ) {

  // If we don't have a slug, then we can't call a post
  if(!$data['slug']) return null;

  $args = array(
    'name'   => $data['slug'],
    'post_type'   => 'any',
    'post_status' => 'publish',
    'numberposts' => 1
  );
  $posts = get_posts($args);

  if ( empty( $posts ) ) {
    return null;
  }

  $post = $posts[0];

  // Store only the useful objects we plan on returning
  $smallerPost = (object) array("ID"=>$post->ID, "post_author"=>$post->post_author, "post_modified"=>$post->post_modified, "post_date"=>$post->post_date, "post_name"=>$post->post_name, "post_content"=>$post->post_content, "post_title"=>$post->post_title, "post_type"=>$post->post_type);

  $smallerPost = dspapi_get_post_info($smallerPost);

  return $smallerPost;
}

/**
 * Return all of the posts in a category by slug
 * @param array $data An array with the desired slug.
 * @return array|null An array of posts within a category, or null if no posts exist
 */
function dspapi_get_category_by_slug( $data ) {

  // If we don't have an id, then we can't call a post
  if(!$data['slug']) return null;

  $cat = get_posts( array('category' => $data['slug'] ) );

  if ( empty( $cat ) ) {
    return null;
  }

  $smallerCat = [];

  // Store only the useful objects we plan on returning
  foreach($cat as $k => $p){
    $smallerCat[$k] = (object) array("ID"=>$p->ID, "post_modified"=>$p->post_date, "post_name"=>$p->post_name, "post_content"=>$p->post_content, "post_title"=>$p->post_title);
  }

  return $smallerCat;
}

/**
 * Search for posts/pages with the search string via WP and DSP
 * @param array $data An array with the desired search string.
 * @return object An object with an array of posts and videos returned by the search
 */
function dspapi_search( $data ) {

  /* Wordpress Search */

  // If we don't have an id, then we can't call a post
  if(!$data['search']) return null;

  $query_args = array( 's' => $data['search'], 'post_type' => 'any' );
  $query = new WP_Query( $query_args );

  $posts = array();

  for($a=0;$a<count($query->posts);$a++){
    $posts[$a] = dspapi_get_post_info($query->posts[$a]);
  }

  /* dotstudioPRO Search */

  $dsp_search = dspapi_api_search($data['search']);

  $results = new stdClass;

  $results->wordpress = $posts;
  $results->dsp = $dsp_search;

  return $results;

}

/**
 * Get posts marked "featured".
 * @return array|null An array of posts, or null if no posts exist
 */
function dspapi_get_featured() {

  $posts = array();

  $args = array(
    'orderby'          => 'date',
    'order'            => 'DESC',
    'meta_key'         => 'dsp_custom_featured',
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
 * Get X number of random posts by type.
 * @return object|null The posts, or null if none exist
 */
function dspapi_get_random_by_type($data) {



  if(!$data['type'] || !$data['count'] || !is_numeric($data['count'])) return null;

  $args = array(
        'post_status'      => 'publish',
        'post_type'        =>  $data['type'],
        'orderby'          => 'date',
        'order'            => 'DESC',
        'numberposts'      => $data['count'] * 3,
        );

  if($data['category']){
    $args['tax_query'] = array(
            array(
                  'taxonomy' => $data['type'] . '_categories',
                  'field' => 'slug',
                  'terms' => array($data['category']),
                  'operator' => 'IN'
              )
          );
  }

  $posts = get_posts($args);

  if(empty($posts)){
    return null;
  }

  for($a=0;$a<rand(1, 25);$a++){
    shuffle($posts);
  }

  $postsToReturn = [];

  for($a=0;$a<$data['count'];$a++){
    if(!empty($posts[$a])) $postsToReturn[] = $posts[$a];
  }

  foreach($postsToReturn as $post){
    $post = dspapi_get_post_info($post);
  }

  return $postsToReturn;

}
