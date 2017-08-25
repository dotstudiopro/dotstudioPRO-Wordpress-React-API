<?php

/*** Get new API token ***/
function dspapi_get_token(){

    $key = get_option('dspapi-api-key');

    if(!$key) return "";

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.myspotlight.tv/token",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"key\"\r\n\r\n$key\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
      // Automatic account API Key: 32a70a32da27b30a10fe546ead126f0778c5f00f
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return false;
    } else {
      if(json_decode($response)->success){
        return json_decode($response)->token;
      } else {
        return "";
      }
    }
}

/*** Search dotstudioPRO for the $term ***/
function dspapi_api_search($term){

	$token = get_option('dspapi_auth_token');
	$exp = get_option('dspapi_auth_token_exp');

	$ttl = $exp ? $exp - time() : 0;

	// If we have less than a day to go before expiring, renew
	if(!$token || !$exp || $ttl < (60*60*24)){
	  $token = dspapi_get_token();
	  update_option('dspapi_auth_token', $token);
	  // Expires in 30 days
	  update_option('dspapi_auth_token_exp', time() + (60*60*24*30));
	}

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://api.myspotlight.tv/search/videos?q=" . $term,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache",
	    "x-access-token: $token"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  return $err;
	} else {
		$resp = json_decode($response);
	  return $resp->success ? $resp->data->hits : array();
	}

}

function dspapi_get_post_info($post, $image_size = "thumb"){
  // If post isn't a post object, don't do anything
  if(!is_object($post)) return $post;

  // $saved_post = get_transient( "saved_post:$post->ID" );

  // $decoded = json_decode($saved_post);

  // if($saved_post && $decoded && $decoded->meta) return $decoded;

  $taxonomy = $post->post_type ? $post->post_type . "_categories" : "";

  $post->post_content = apply_filters( 'the_content', $post->post_content );

  $default_blog_page_ad = get_option('dspabs_blog_page_default_ads_script') ?: "";

  $meta = get_post_custom($post->ID);

  $meta_array = [];

  $filtered_meta = new stdClass;

  // Parse meta, removing unnecessary keys and setting up images if they exist
  foreach($meta as $key=>$m){
    if(empty($m[0])) continue;
    $m = apply_filters( 'dspapi_post_info_meta_key_filter', $m, $key, $image_size );
    if(!$m) continue;
    $meta_array[$key] = $m;
  }

  // Get the featured image
  if (has_post_thumbnail( $post->ID )){
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $image_size );
    $post->featured_image = new stdClass;
    $post->featured_image->url = $thumb[0];
    $post->featured_image->width = $thumb[1];
    $post->featured_image->height = $thumb[2];
    $post->featured_image->generated = $thumb[3];
  }

  // Get author data
  $user = get_user_by("ID", !empty($meta_array['dspabs_custom_author']) ? $meta_array['dspabs_custom_author'][0] : $post->post_author);

  $userFiltered = new stdClass;

  foreach($user->data as $k=>$v){
    if(array_search($k, ['user_nicename', 'user_email', 'user_url', 'display_name']) === false) continue;
    $userFiltered->$k = $v;
  }

  // Set up the excerpt
  $post->post_excerpt = implode(' ', array_slice(explode(' ', wp_strip_all_tags($post->post_content)), 0, 35));

  // Get author headshot
  $headshot = get_user_meta( $post->post_author, "author_headshot", true );
  $author_img = wp_get_attachment_image_src($headshot, 'thumb');
  $author_image_obj = $userFiltered->author_headshot = new stdClass;
  if($author_img){
    $author_image_obj->url = $author_img[0];
    $author_image_obj->width = $author_img[1];
    $author_image_obj->height = $author_img[2];
    $author_image_obj->generated = $author_img[3];
    $userFiltered->author_headshot = array('default'=>(int) $headshot, 'image'=>$author_image_obj);
  }

  $post->author_data = $userFiltered;
  $post->meta = $meta_array;
  $post->thumb = get_the_post_thumbnail_url($post->ID) ?: null;

  $taxonomy = get_the_terms( $post->ID, $taxonomy);
  if(!empty($taxonomy->errors) || !$taxonomy) $taxonomy = null;
  $post->taxonomy = $taxonomy;

  $filtered_post = apply_filters( 'dspapi_post_filter', $post );

  set_transient( "saved_post:$post->ID", json_encode($filtered_post), get_option('dspapi_transient_cache_timeout', 300) );

  return $filtered_post;
}

function dspapi_json_decode($json){
  // Deal with the multitude of slashes that could exist on things
  return str_replace("\\\\", "\\", str_replace("\\\"", "\"", str_replace("\\'", "'", json_decode($json))));
}