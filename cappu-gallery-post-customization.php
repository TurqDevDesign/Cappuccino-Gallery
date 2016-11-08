<?php

/*
 * Start meta box callbacks
 */

//Callback to display metabox image attachment
function cappu_gallery_attach(){
        global $post, $typenow;
        $post_meta = get_post_meta($post->ID);

        wp_nonce_field(basename(__FILE__), 'cappu_gallery_attach_nonce');

        switch($typenow){
            case 'cappu-gallery-image':
                // Get WordPress' media upload URL
                $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

                // See if there's a media id already saved as post meta
                $img_id = get_post_meta( $post->ID, '_gallery_image_attachment', true );

                // Get the image src
                $img_src = wp_get_attachment_image_src( $img_id, 'full' );

                // For convenience, see if the array is valid
                $have_img = is_array( $img_src );
                ?>

                <!-- Your image container, which can be manipulated with js -->
                <div id="gallery_image_container" class="gallery-img-container">
                    <?php if ( $have_img ) : ?>
                        <img src="<?php echo $img_src[0] ?>" alt="Gallery Image" style="max-width:100%;" />
                    <?php endif; ?>
                </div>

                <!-- Your add & remove image links -->
                <p class="hide-if-no-js">
                    <a class="upload-gallery-img <?php if ( $have_img  ) { echo 'hidden'; } ?>"
                       href="<?php echo $upload_link ?>">
                        <?php _e('Set image') ?>
                    </a>
                    <a class="delete-gallery-img <?php if ( ! $have_img  ) { echo 'hidden'; } ?>"
                      href="#">
                        <?php _e('Remove image') ?>
                    </a>
                </p>

                <!-- A hidden input to set and post the chosen image id -->
                <input class="gallery-img-id" name="_gallery_image_attachment" type="hidden" value="<?php echo esc_attr( $img_id ); ?>" />
                <?php
            break;
            case 'cappu-gallery-video':

            $vid_link = get_post_meta( $post->ID, '_gallery_video_link', true );
            $embed_markup_set = isset($post_meta['_gallery_embed_markup']) && !empty($post_meta['_gallery_embed_markup'][0]);
            $embed = $embed_markup_set ? $post_meta['_gallery_embed_markup'][0] : false;

            ?>
            <div class="cappu-gallery-metabox">
                <div class="cappu-gallery-option">
                    <div class="option-title">
                        Video Link
                    </div>
                    <div class="option-value">
                        <input type="text" id="vid_link" name="_gallery_video_link" placeholder="i.e. https://youtu.be/VdD2BOO3Ons" value="<?php if ( ! empty ( $post_meta['_gallery_video_link'] ) ) {
        					echo esc_attr( $post_meta['_gallery_video_link'][0] );
        				} ?>">
                        </br>
                        <span class="small">
                            <a href="/dev_testing/wp-admin/admin.php?page=cappu_gallery_help#adding_videos" target="_blank">
                                Where can I find this?
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="video-display" id="video_display">
                <div class="video-holder <?php echo $embed ? ' ' : 'no-video'; ?>" id="video_holder">
                    <?php
                    if($embed){
                        ?>
                        <iframe width='100%' height='100%' src='https://www.youtube.com/embed/<?php echo trim(html_entity_decode($embed, ENT_QUOTES, 'UTF-8')); ?>?rel=0&showinfo=0' frameborder='0' allowfullscreen></iframe>
                        <?php
                    } else if(!$embed && !empty($vid_link) && isset($vid_link)){
                        echo "Invalid URL";
                    } else {
                        echo "No Video";
                    }
                    ?>
                </div>
            </div>

            <!-- A hidden input to set and post the video embed markup -->
            <input class="gallery-embed-id" id="gallery_embed_id" name="_gallery_embed_markup" type="hidden" value="<?php echo html_entity_decode($embed, ENT_QUOTES, 'UTF-8'); ?>" />
            <?php
            break;
        }
}

//Callback to display metabox image options
function cappu_gallery_options(){
    global $post;
    $post_meta = get_post_meta($post->ID);
    wp_nonce_field(basename(__FILE__), 'cappu_gallery_text_nonce');

?>
    <div class="cappu-gallery-metabox">
        <div class="cappu-gallery-option">
            <div class="option-title">Subtitle</div>
            <div class="option-value">
                <input type="text" name="_gallery_subtitle" maxlength="100" value="<?php if ( ! empty ( $post_meta['_gallery_subtitle'] ) ) {
					echo esc_attr( $post_meta['_gallery_subtitle'][0] );
				} ?>">
            </div>
        </div>
        <div class="cappu-gallery-option">
            <div class="option-title">Caption</div>
            <div class="option-value">
                <?php
                    $content   = get_post_meta($post->ID, '_gallery_caption', true);
                    $editor_id = '_gallery_caption';
                    $settings  = array(
                        'textarea_rows' => 5,
                        'wpautop'       => false,
                        'media_buttons' => false,
                        'textarea_name' => $editor_id,
                        'quicktags'     => false,
                        'tinymce'       => array(
                            'toolbar1'  => 'bold,italic,underline,link,unlink,undo,redo'
                        )
                    );

                    wp_editor( $content, $editor_id, $settings);
                ?>
            </div>
        </div>
    </div>
<?php
}

/*
 * End meta box callbacks
 */

function add_image_meta_boxes() {

    //cappu-gallery-image attach image
    add_meta_box(
        'cappu-gallery-image-attach-image',
        'Attach Image',
        'cappu_gallery_attach',
        'cappu-gallery-image',
        'normal',
        'high'

    );
    //cappu-gallery-image options
    add_meta_box(
        'cappu-gallery-image-options',
        'Image Options',
        'cappu_gallery_options',
        'cappu-gallery-image',
        'normal',
        'high'

    );
}

function add_video_meta_boxes() {
    //cappu-gallery-video attach video
    add_meta_box(
        'cappu-gallery-video-attach-video',
        'Attach Video',
        'cappu_gallery_attach',
        'cappu-gallery-video',
        'normal',
        'high'

    );
    //cappu-gallery-video options
    add_meta_box(
        'cappu-gallery-video-options',
        'Video Options',
        'cappu_gallery_options',
        'cappu-gallery-video',
        'normal',
        'high'

    );
}

//Save images
function cappu_gallery_save( $post_id ) {
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_attach_nonce = ( isset( $_POST[ 'cappu_gallery_attach_nonce' ] ) && wp_verify_nonce( $_POST[ 'cappu_gallery_attach_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    $is_valid_text_nonce = ( isset( $_POST[ 'cappu_gallery_text_nonce' ] ) && wp_verify_nonce( $_POST[ 'cappu_gallery_text_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_attach_nonce || !$is_valid_text_nonce ) {
        return;
    }
    if ( isset( $_POST[ '_gallery_image_attachment' ] ) ) {
    	update_post_meta( $post_id, '_gallery_image_attachment', sanitize_text_field( $_POST[ '_gallery_image_attachment' ] ) );
    }
    if ( isset( $_POST[ '_gallery_subtitle' ] ) ) {
    	update_post_meta( $post_id, '_gallery_subtitle', sanitize_text_field( $_POST[ '_gallery_subtitle' ] ) );
    }
    if ( isset( $_POST[ '_gallery_caption' ] ) ) {
    	update_post_meta( $post_id, '_gallery_caption', sanitize_text_field( $_POST[ '_gallery_caption' ] ) );
    }
    if ( isset( $_POST[ '_gallery_video_link' ] ) ) {
    	update_post_meta( $post_id, '_gallery_video_link', sanitize_text_field( $_POST[ '_gallery_video_link' ] ) );
    }
    if ( isset( $_POST[ '_gallery_embed_markup' ] ) ) {
    	update_post_meta( $post_id, '_gallery_embed_markup', sanitize_text_field( $_POST[ '_gallery_embed_markup' ] ) );
    }
}
add_action( 'save_post', 'cappu_gallery_save' );

add_action('add_meta_boxes_cappu-gallery-image', 'add_image_meta_boxes');
add_action('add_meta_boxes_cappu-gallery-video', 'add_video_meta_boxes');
