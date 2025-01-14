<?php

/**
 * Class PWEMapDynamic
 * Extends PWEMap class and defines a custom Visual Composer element.
 */
class PWEMapDynamic extends PWEMap {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {

        extract( shortcode_atts( array(
            'map_type' => '',
            'map_dynamic_preset' => '',
            'map_dynamic_3d' => '',
            'map_color' => '',
            'map_overlay' => '',
            'map_image' => '',
            'map_custom_title' => '',
            'map_year' => '',
            'map_number_visitors' => '',
            'map_number_exhibitors' => '',
            'map_exhibition_space' => '',
            'map_year_previous' => '',
            'map_number_visitors_previous' => '',
            'map_number_exhibitors_previous' => '',
            'map_exhibition_space_previous' => '',
            'map_number_countries' => '',
            'map_percent_polish_visitors' => '',
            'map_event_date' => '',
            'map_exhibition_space' => '',
        ), $atts ));

        $map_number_visitors = !empty($map_number_visitors) ? $map_number_visitors : 0;
        $map_percent_polish_visitors = !empty($map_percent_polish_visitors) ? $map_percent_polish_visitors : 0;
        $map_number_countries = !empty($map_number_countries) ? $map_number_countries : 15;

        $map_more_logotypes = (isset($atts['map_more_logotypes'])) ? explode(';', $atts['map_more_logotypes']) : '';

        if (!empty($map_number_visitors_previous) || !empty($map_number_exhibitors_previous) || !empty($map_exhibition_space_previous)) {
            $max_visitors = max($map_number_visitors, $map_number_visitors_previous);
            $map_number_visitors_percentage = ($map_number_visitors / $max_visitors) * 100;
            $map_number_visitors_previous_percentage = ($map_number_visitors_previous / $max_visitors) * 100;
            
            $max_exhibitors = max($map_number_exhibitors, $map_number_exhibitors_previous);
            $map_number_exhibitors_percentage = ($map_number_exhibitors / $max_exhibitors) * 100;
            $map_number_exhibitors_previous_percentage = ($map_number_exhibitors_previous / $max_exhibitors) * 100;
            
            $max_exhibition_space = max($map_exhibition_space, $map_exhibition_space_previous);
            $map_exhibition_space_percentage = ($map_exhibition_space / $max_exhibition_space) * 100;
            $map_exhibition_space_previous_percentage = ($map_exhibition_space_previous / $max_exhibition_space) * 100;
        }

        // CSS <----------------------------------------------------------------------------------------------<
        require_once plugin_dir_path(dirname( __FILE__ )) . 'assets/style.php';

        if ($map_dynamic_preset === 'preset_1') {
            require_once plugin_dir_path(__FILE__) . 'presets/map_dynamic_preset_1.php';
        } else if ($map_dynamic_preset === 'preset_2') {
            require_once plugin_dir_path(__FILE__) . 'presets/map_dynamic_preset_2.php';
        }

        return $output;
    }
}