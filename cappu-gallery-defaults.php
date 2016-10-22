<?php
function cappu_gallery_defaultSettings(){

    $defaults = array(
        'cappu_display_settings' => array(
            'render_title'         => '1',
            'render_subtitle'      => '1',
            'render_caption'       => '1',
        ),
        'cappu_column_settings'  => array(
            'column_count_desktop' => '3',
            'column_count_tablet'  => '2',
            'column_count_mobile'  => '1',
        ),
        'cappu_sort_settings'    => array(
            'sorting_options'      => 'date added',
            'sorting_asc_desc'     => 'ascending',
        ),
    );

    return $defaults;

}

function cappu_gallery_get_option($option){
    foreach(cappu_gallery_defaultSettings() as $key => $value){
        foreach($value as $setting => $default) {
            $db_option = get_option($key);
            if(isset($db_option[$setting]) && $setting == $option) {
                return $db_option[$setting];
            } else if($setting == $option){
                return $default;
            }
        }
    }
}
