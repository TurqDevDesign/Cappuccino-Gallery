<?php

    function cappu_gallery_loop($query, $atts){

        // The Loop
        if ( $query->have_posts() ) {
            wp_enqueue_style('cappu-gallery-style');
            wp_enqueue_script('match-height');
            wp_enqueue_script('match-height-instantiation');

            $title = false;
            $subtitle = false;
            $caption = false;

            if($atts['title'] == 1 || $atts['title'] == 'true') {
                $title = true;
            }

            if($atts['subtitle'] == 1 || $atts['subtitle'] == 'true') {
                $subtitle = true;
            }

            if($atts['caption'] == 1 || $atts['caption'] == 'true') {
                $caption = true;
            }

            $output = '';

            $output .= '<div class="gallery-container">';

            ob_start(); //Start output buffer

        	while ( $query->have_posts() ) {
        		$query->the_post();
                $post_meta = get_post_meta(get_the_ID());
                $d = $atts['desktop-columns']; //desktop
                $t = $atts['tablet-columns']; //tablet
                $m = $atts['mobile-columns']; //mobile

        		?>
                    <div class="gallery-parent cg-d-1of<?php echo $d; ?> cg-t-1of<?php echo $t; ?> cg-m-1of<?php echo $m; ?>">
                        <?php if( isset($post_meta['_gallery_image_attachment'][0]) &&
                                  !empty($post_meta['_gallery_image_attachment'][0])) :?>
                            <a href="<?php echo wp_get_attachment_url($post_meta['_gallery_image_attachment'][0]); ?>">
                        <?php endif; ?>
                        <div class="custom-gallery-item">
                            <?php if( isset($post_meta['_gallery_image_attachment'][0]) &&
                                      !empty($post_meta['_gallery_image_attachment'][0])) :?>
                                <div class="custom-gallery-image">
                                    <img src="<?php echo wp_get_attachment_image_src($post_meta['_gallery_image_attachment'][0], 'thumbnail')[0]; ?>" alt="" />
                                </div>
                            <?php endif; ?>
                            <?php if( isset($post_meta['_gallery_embed_markup'][0]) &&
                                      !empty($post_meta['_gallery_embed_markup'][0])) :?>
                                <div class="custom-gallery-video">
                                    <iframe width='100%' height='100%' src='https://www.youtube.com/embed/<?php echo trim(html_entity_decode( $post_meta['_gallery_embed_markup'][0], ENT_QUOTES, 'UTF-8')); ?>?rel=0&showinfo=0' frameborder='0' allowfullscreen></iframe>
                                </div>
                            <?php endif; ?>
                            <?php if( $title ) :?>
                                <div class="custom-gallery-title">
                                     <?php echo get_the_title(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if( $subtitle &&
                                      isset($post_meta['_gallery_subtitle'][0]) &&
                                      !empty($post_meta['_gallery_subtitle'][0])) :?>
                                <div class="custom-gallery-subtitle">
                                     <?php echo $post_meta['_gallery_subtitle'][0]; ?>
                                </div>
                            <?php endif; ?>
                            <?php if( $caption &&
                                      isset($post_meta['_gallery_caption'][0]) &&
                                      !empty($post_meta['_gallery_caption'][0])) :?>
                                <div class="custom-gallery-caption">
                                    <?php echo $post_meta['_gallery_caption'][0]; ?>
                                </div>
                        <?php endif; ?>
                        </div>
                        <?php if( isset($post_meta['_gallery_image_attachment'][0]) &&
                                  !empty($post_meta['_gallery_image_attachment'][0])) :?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php
        	}

            $output .= ob_get_clean(); //Now the while loop is finished, get the
                                       //content of the output buffer and
                                       //add it to $output

            $output .= '</div>';

            return $output;

        	/* Restore original Post Data */
        	wp_reset_postdata();
        } else {
        	return "<div class='no-gallery-found'> No gallery items found </div>";
        }

    }

    function cappu_gallery_query($atts){
        //Combining default/set options and shortcode options.
        $atts = shortcode_atts( array(
            'title'             => cappu_gallery_get_option('render_title'),
            'subtitle'          => cappu_gallery_get_option('render_subtitle'),
            'caption'           => cappu_gallery_get_option('render_caption'),
            'desktop-columns'   => cappu_gallery_get_option('column_count_desktop'),
            'tablet-columns'    => cappu_gallery_get_option('column_count_tablet'),
            'mobile-columns'    => cappu_gallery_get_option('column_count_mobile'),
            'sort-by'           => cappu_gallery_get_option('sorting_options'),
            'sorting-direction' => cappu_gallery_get_option('sorting_asc_desc'),
            'gallery'           => 'all',
            'category'          => '' //Alternate to 'gallery'
        ), $atts );

        //Preparing query to retrieve posts from database
        $query_args = array(
            'post_type'      => array('cappu-gallery-video', 'cappu-gallery-image'),
			'posts_per_page' => - 1
		);

		switch(strtolower($atts['sort-by'])){
            case 'date':
            case 'date-added':
            case 'date added':
            case 'dateadded':
                $query_args['orderby'] = 'date';
            break;
            case 'alphabetical':
            case 'alphabet':
            case 'abc':
                $query_args['orderby'] = 'title';
            break;
        }

		switch(strtolower($atts['sorting-direction'])){
            case 'ascending':
            case 'ascend':
            case 'asc':
                $query_args['order'] = 'ASC';
            break;
            case 'descending':
            case 'descend':
            case 'desc':
                $query_args['order'] = 'DESC';
            break;
        }

		switch(strtolower($atts['gallery'])){
            case 'all':
                //do Nothing
            break;
            default:
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'cappu-gallery-groups',
                        'field' => 'slug',
                        'terms' => $atts['gallery'],
                    ),
                );
            break;
        }

        //In case users decide to use 'category' instead of 'gallery',
        //'category' has a higher prescedence and overwrites 'gallery'
		switch(strtolower($atts['category'])){
            case '':
                //Do nothing
            break;
            case 'all':
                $query_args['tax_query'] = array();
            break;
            default:
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'cappu-gallery-groups',
                        'field' => 'slug',
                        'terms' => $atts['category'],
                    ),
                );
            break;
        }

        $cappu_gallery_query = new WP_Query( $query_args );

        return cappu_gallery_loop($cappu_gallery_query, $atts);

    }

    add_shortcode( 'cappuccino_gallery', 'cappu_gallery_query' );
