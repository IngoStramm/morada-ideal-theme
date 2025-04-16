<?php

function mi_get_blogposts()
{
    $disable_blog_transient = mi_get_option('mi_disable_blog_transient');
    if ($disable_blog_transient === 'on' || false === ($blogposts = get_transient('blogposts'))) {
        $blogposts = mi_fetch_blogposts();
        set_transient('blogposts', $blogposts, 12 * HOUR_IN_SECONDS);
    }
    return $blogposts;
}

/**
 * mi_fetch_blogposts
 *
 * @return array
 */
function mi_fetch_blogposts()
{
    $blog_url = mi_get_option('mi_blog_url');
    if (!$blog_url) {
        $blog_url = 'https://moradaideal.pt/';
    }
    $per_page = mi_get_option('mi_blog_qty');
    if (!$per_page) {
        $per_page = 3;
    }
    $blog_url = rtrim($blog_url);
    $get_posts_response = wp_remote_get($blog_url . '/wp-json/wp/v2/posts?per_page=' . $per_page . '&_fields=id,link,title,excerpt,categories,featured_media');
    $posts_whitout_thumbnail = null;

    if (is_array($get_posts_response) && ! is_wp_error($get_posts_response)) {
        $posts_whitout_thumbnail = json_decode(wp_remote_retrieve_body($get_posts_response));
    }

    $media_arr = [];
    $cat_arr = [];
    $blogposts_arr = [];
    if ($posts_whitout_thumbnail) {
        foreach ($posts_whitout_thumbnail as $key => $blogpost) {
            $media_arr[$blogpost->id] = $blogpost->featured_media;
            $blogposts_arr[$blogpost->id] = $blogpost;
            $cat_arr[$blogpost->id] = $blogpost->categories;
        }
    }
    if ($media_arr && count($media_arr) > 0) {
        foreach ($media_arr as $blogpost_id => $media_id) {
            $get_media_response = wp_remote_get('https://moradaideal.pt/wp-json/wp/v2/media/' . $media_id);
            if (is_array($get_media_response) && ! is_wp_error($get_media_response)) {
                $media = json_decode(wp_remote_retrieve_body($get_media_response));
                // mi_debug($media->media_details->sizes->full->source_url);
                $blogposts_arr[$blogpost_id]->media = $media->media_details->sizes->full->source_url;
            }
        }
    }
    if ($cat_arr && count($cat_arr) > 0) {
        foreach ($cat_arr as $blogpost_id => $cat_id_arr) {
            $blogposts_arr[$blogpost_id]->cats = [];
            foreach ($cat_id_arr as $cat_id) {
                $get_cat_response = wp_remote_get('https://moradaideal.pt/wp-json/wp/v2/categories/' . $cat_id);
                if (is_array($get_cat_response) && ! is_wp_error($get_cat_response)) {
                    $cat = json_decode(wp_remote_retrieve_body($get_cat_response));
                    // mi_debug($cat->media_details->sizes->full->source_url);
                    $blogposts_arr[$blogpost_id]->cats[] = $cat->name;
                }
            }
        }
    }
    return $blogposts_arr;
}
