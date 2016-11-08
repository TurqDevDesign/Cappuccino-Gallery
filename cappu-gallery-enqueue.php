<?php

function cappu_gallery_admin_enqueue_scripts_and_styles(){
    global $typenow, $pagenow;

    if(($pagenow == 'post.php' || $pagenow == 'post-new.php') &&
       ($typenow == 'cappu-gallery-video' || $typenow == 'cappu-gallery-image')){

       wp_enqueue_script('cappu-gallery-admin-script', plugins_url('js/cappu-admin.js',__FILE__), array('jquery', 'quicktags'), ' ', true);
       wp_enqueue_style('cappu-gallery-admin-style', plugins_url('css/stylesheets/cappu-admin.css',__FILE__));

       if($typenow == 'cappu-gallery-image'){
           wp_enqueue_script('cappu-gallery-admin-image-script', plugins_url('js/cappu-admin-image.js',__FILE__), array('jquery'), ' ', true);
       }

       if($typenow == 'cappu-gallery-video'){
           wp_enqueue_script('cappu-gallery-admin-video-script', plugins_url('js/cappu-admin-video.js',__FILE__), array('jquery'), ' ', true);
       }


   }
}

//Enqueue media uploader scripts on custom post type pages
if( is_admin() && ! empty ( $_SERVER['PHP_SELF'] ) && 'upload.php' !== basename( $_SERVER['PHP_SELF'] ) ) {
     function my_admin_load_styles_and_scripts() {\
         wp_enqueue_media();
     }
     add_action( 'admin_enqueue_scripts', 'my_admin_load_styles_and_scripts' );
 }

function cappu_gallery_front_end_enqueue_scripts_and_styles(){

        //from https://github.com/liabru/jquery-match-height , Allows us to use
        //jQuery to match height of gallery items to height of largest in row.
        wp_register_script('match-height', plugins_url('js/jquery.matchHeight.js',__FILE__), array('jquery'), '', true);
        wp_register_script('match-height-instantiation', plugins_url('js/do-match-height.js',__FILE__), array('jquery','match-height'), '', true);

        //Load styles, all styles compiled to this one file, written in scss.
        //Sources provided in scss folder.
        wp_register_style('cappu-gallery-style', plugins_url('css/stylesheets/cappu_gallery_main.css',__FILE__), '', true);


}
