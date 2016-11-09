<?php

/**
 * Function to limit the number of characters that can be
 * echoed from a string.
 */
function limit_echo($string, $length)
{
  if(strlen($string) <= $length) {
    return $string;
  } else {
    $newString = substr($string,0,$length) . '...';
    return $newString;
  }
}

function add_image_columns($columns) {
    return array_merge(
                array_slice($columns, 0, 2, true),
                array(
                   'caption' =>__( 'Caption' ),
                   'image' => __( 'Image' )
                ),
                array_slice($columns, 2, count($columns)-2, true)
           );
}

function add_video_columns($columns) {
    return array_merge(
                array_slice($columns, 0, 2, true),
                array(
                    'caption' =>__( 'Caption' ),
                    'video' => __( 'Video' )
                ),
                array_slice($columns, 2, count($columns)-2, true)
           );
}

function manage_custom_gallery_columns($column_name, $post_id) {
    global $pagenow;
    $post = get_post($post_id);
    $post_meta = get_post_meta($post_id);
    if (($post->post_type == 'cappu-gallery-image' || 'cappu-gallery-image') &&
        is_admin() &&
        $pagenow == 'edit.php')  {
            switch ($column_name) {
                case 'image':
                    ?>
                        <img height="60px" src="<?php echo wp_get_attachment_image_src($post_meta['_gallery_image_attachment'][0], 'thumbnail')[0]; ?>" alt="" />
                    <?php
                break;
                case 'video':
                    ?>
                        <img height="60px" src="//img.youtube.com/vi/<?php echo $post_meta['_gallery_embed_markup'][0]; ?>/0.jpg">
                    <?php
                break;
                case 'caption':
                    echo limit_echo(get_post_meta($post_id,'_gallery_caption',true), 120);
                break;
            }
    }
}

//Populate custom columns
add_action('manage_cappu-gallery-image_posts_custom_column', 'manage_custom_gallery_columns', 10, 2);
add_action('manage_cappu-gallery-video_posts_custom_column', 'manage_custom_gallery_columns', 10, 2);

//Add custom columns to post list page
add_filter('manage_cappu-gallery-image_posts_columns' , 'add_image_columns');
add_filter('manage_cappu-gallery-video_posts_columns' , 'add_video_columns');
