<?php

    //Checkbox callback
    function cappu_gallery_settings_check($args) {

        $settingValue = cappu_gallery_get_option($args['field']);

        $type          = ' type  ="checkbox"';
        $typeHidden    = ' type  ="hidden"';
        $name          = ' name  ="' . $args['db-group'] . '[' . $args['field'] .']"';
        $id            = ' id    ="' . $args['field'] . '"';
        $idHidden      = ' id    ="' . $args['field'] . '_hidden"';
        $value         = ' value ="1"';
        $valueHidden   = ' value ="0"';
        $for           = ' for   ="' . $args['db-group'] . '[' . $args['field'] .']"';

        $output  = '<label' . $for . '>';

        $output .= '<input' . $type . $name . $id . $value . checked( 1, $settingValue , false ) . '/>';

        $output .= '</label>';

        //The following is a hidden field with the same name as the visable checkbox.
        //The accompanying script disables the hidden field whenever the box is checked,
        //and re-enables it when it's unchecked, that way we can store a value of 0,
        //from the hidden input, when the box is unchecked and doesn't post anything.
        $output .= '<input' . $typeHidden . $name . $idHidden . $valueHidden . '/>';

        $output .= "<script>
                var box_{$args['field']} = document.getElementById('{$args['field']}'),
                    box_{$args['field']}_hidden = document.getElementById('{$args['field']}_hidden');

                function disableHidden(e){
                    if(box_{$args['field']}.checked) {
                        box_{$args['field']}_hidden.disabled = true;
                    } else {
                        box_{$args['field']}_hidden.disabled = false;
                    }
                }

                disableHidden(null);

                box_{$args['field']}.addEventListener('change', disableHidden);


            </script>";

        echo $output;

    }

    //Dropdown menu callback
    function cappu_gallery_settings_dropdown($args) {

        $settingValue = cappu_gallery_get_option($args['field']);

        $name   = ' name="' . $args['db-group'] . '[' . $args['field'] .']"';
        $id     = ' id="' . $args['field'] . '"';

        $output  = '<select' . $id . $name . '>';

        foreach($args['options'] as $choice) {

            $value  = ' value="' . strtolower($choice) . '"';

            $output .= '<option' . $value . selected( $settingValue, strtolower($choice), false) . '>' . $choice . '</option>';

        }

        $output .= '</select>';

        echo $output;

    }

    // Populate fields (called from admin_init action point in cappu-gallery-cpt.php)
    // using Wordpress Settings API
    function cappu_gallery_settings_fields() {

        //Adding separate sections for Gallery settings
        //Custom page name for last param
        add_settings_section('cappu_display_options','Display','cappu_gallery_options_display','cappu_display_page');

        //Adding separate sections for Gallery settings
        //Custom page name for last param
        add_settings_section('cappu_column_options','Column Count','cappu_gallery_options_columns','cappu_display_page');

        //Adding separate sections for Gallery settings
        //Custom page name for last param
        add_settings_section('cappu_sort_options','Sorting','cappu_gallery_options_sorting','cappu_sorting_page');

        //Adding all settings fields to proper sections
        add_settings_field(
            'render_title',                        //Setting ID
            'Title',                               //Setting display text
            'cappu_gallery_settings_check',        //Setting callback
            'cappu_display_page',                  //Setting page, same as section and register_setting
            'cappu_display_options',               //Setting section
            array(                                 //Array to pass to callback
                'field' => 'render_title',
                'db-group' => 'cappu_display_settings'
            )
        );
        add_settings_field(
            'render_subtitle',                     //Setting ID
            'Subtitle',                            //Setting display text
            'cappu_gallery_settings_check',        //Setting callback
            'cappu_display_page',                  //Setting page, same as section and register_setting
            'cappu_display_options',               //Setting section
            array(                                 //Array to pass to callback
                'field' => 'render_subtitle',
                'db-group' => 'cappu_display_settings'
            )
        );
        add_settings_field(
            'render_caption',                      //Setting ID
            'Caption',                             //Setting display text
            'cappu_gallery_settings_check',        //Setting callback
            'cappu_display_page',                  //Setting page, same as section and register_setting
            'cappu_display_options',               //Setting section
            array(                                 //Array to pass to callback
                'field' => 'render_caption',
                'db-group' => 'cappu_display_settings'
            )
           );
        add_settings_field(
            'desktop_columns',                     //Setting ID
            'Desktop',                             //Setting display text
            'cappu_gallery_settings_dropdown',     //Setting callback
            'cappu_display_page',                  //Setting page, same as section and register_setting
            'cappu_column_options',                //Setting section
            array(                                 //Array to pass to callback
                'field'   => 'column_count_desktop',
                'options' => array('4','3','2','1'),
                'db-group' => 'cappu_column_settings'
            )
          );
        add_settings_field(
            'tablet_columns',                      //Setting ID
            'Tablet',                              //Setting display text
            'cappu_gallery_settings_dropdown',     //Setting callback
            'cappu_display_page',                  //Setting page, same as section and register_setting
            'cappu_column_options',                //Setting section
            array(                                 //Array to pass to callback
                'field'   => 'column_count_tablet',
                'options' => array('3','2','1'),
                'db-group' => 'cappu_column_settings'
            )
         );
        add_settings_field(
            'mobile_columns',                      //Setting ID
            'Mobile',                              //Setting display text
            'cappu_gallery_settings_dropdown',     //Setting callback
            'cappu_display_page',                  //Setting page, same as section and register_setting
            'cappu_column_options',                //Setting section
            array(                                 //Array to pass to callback
                'field'   => 'column_count_mobile',
                'options' => array('2','1'),
                'db-group' => 'cappu_column_settings'
            )
        );
        add_settings_field(
            'sorting_asc_desc',                    //Setting ID
            'Sorting Direction',                   //Setting display text
            'cappu_gallery_settings_dropdown',     //Setting callback
            'cappu_sorting_page',                  //Setting page, same as section and register_setting
            'cappu_sort_options',                  //Setting section
            array(                                 //Array to pass to callback
                'field'   => 'sorting_asc_desc',
                'options' => array('Ascending','Descending'),
                'db-group' => 'cappu_sort_settings'
            )
        );
        add_settings_field(
            'sorting_options',                     //Setting ID
            'Sort By',                             //Setting display text
            'cappu_gallery_settings_dropdown',     //Setting callback
            'cappu_sorting_page',                  //Setting page, same as section and register_setting
            'cappu_sort_options',                  //Setting section
            array(                                 //Array to pass to callback
                'field'   => 'sorting_options',
                'options' => array('Date Added', 'Alphabetical' /*, 'Custom' */),
                'db-group' => 'cappu_sort_settings'
            )
        );


        register_setting(
            'cappu_display_page',                     //Options section/page ID, must match section and field
            'cappu_display_settings'                  //ID/group to store settings in database
        );
        register_setting(
            'cappu_display_page',                     //Options section/page ID, must match section and field
            'cappu_column_settings'                   //ID/group to store settings in database
        );
        register_setting(
            'cappu_sorting_page',                     //Options section/page ID, must match section and field
            'cappu_sort_settings'                     //ID/group to store settings in database
        );


    }

    // Callback for add_settings_sections above
    function cappu_gallery_options_display() {

        _e('Select which elements you would like displayed with each gallery item. These are just default settings and may be overridden with shortcode parameters.', 'cappu-gallery');

    }

    // Callback for add_settings_sections above
    function cappu_gallery_options_columns() {

        _e('In order for your gallery to adapt to all screen sizes we have to specify how many columns we want at each breakpoint. Here you can select how many columns you would like to display for desktop, tablet, and mobile screen sizes. These are just default settings and may be overridden with shortcode parameters.', 'cappu-gallery');

    }

    // Callback for add_settings_sections above
    function cappu_gallery_options_sorting() {

        _e('Here you may choose how you\'d like your gallery to be sorted. These are just default settings and may be overridden with shortcode parameters.', 'cappu-gallery');

        /*_e('Here you may choose how you\'d like your gallery to be sorted. If you\'d prefer a custom order then you can select \'Custom\' under the \'Sort By\' section, then simply click and drag your gallery items to your preferred order.', 'cappu-gallery');*/

    }

    // Callback from cappu_gallery_addTopLevelMenuItem()
    function cappu_gallery_settings() {

    ?>

        <div class="wrap">

            <h1> <?php _e('Gallery Settings', 'cappu-gallery'); ?> </h1>
            <?php

                $cappuSettingPage = 'display';
                if(isset($_GET['cappu-settings-page'])){

                    $cappuSettingPage = strtolower($_GET['cappu-settings-page']);

                }
                switch($cappuSettingPage) {
                    case 'display':
                        echo '<p>';
                            _e('Here you may adjust how your galleries are displayed.', 'cappu-gallery');
                        echo '</p>';
                    break;
                    case 'sorting':
                        echo '<p>';
                            _e('Here you may adjust how your galleries are sorted.', 'cappu-gallery');
                        echo '</p>';
                    break;
                    default:
                        echo '<p>';
                            _e('Tab not found.', 'cappu-gallery');
                        echo '</p>';
                    break;
                }

                settings_errors();

            ?>


            <!-- Wordpress tabbed navigation class -->
            <h2 class="nav-tab-wrapper">

                <!-- Display options tab -->
                <a href="<?php echo add_query_arg('cappu-settings-page', 'display'); ?>" class="nav-tab <?php echo $cappuSettingPage == 'display' ? 'nav-tab-active' : ''; ?>">Display</a>

                <!-- Sorting options tab -->
                <a href="<?php echo add_query_arg('cappu-settings-page', 'sorting'); ?>" class="nav-tab <?php echo $cappuSettingPage == 'sorting' ? 'nav-tab-active' : ''; ?>">Sorting</a>

            </h2>

            <form method="post" action="options.php">
                <?php

                    $pageToDisplay = 'cappu_' . $cappuSettingPage . '_page';

                    do_settings_sections($pageToDisplay);
                    settings_fields($pageToDisplay);
                    submit_button('Save Settings', 'primary', 'cappu-save-settings');

                ?>
            </form>

        </div>


    <?php

    }
