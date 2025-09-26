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
            'map_custom_current_edition' => '',
            'map_number_visitors' => '',
            'map_number_abroad_visitors' => '',
            'map_number_exhibitors' => '',
            'map_exhibition_space' => '',
            'map_year_previous' => '',
            'map_custom_previous_edition' => '',
            'map_number_visitors_previous' => '',
            'map_number_abroad_visitors_previous' => '',
            'map_number_exhibitors_previous' => '',
            'map_exhibition_space_previous' => '',
            'map_number_countries' => '',
            'map_percent_polish_visitors' => '',
            'map_exhibition_space' => '',
        ), $atts ));

        $pwe_visitors             = do_shortcode('[pwe_visitors]');
        $map_number_visitors      = !empty($pwe_visitors) ? $pwe_visitors : $map_number_visitors;

        $pwe_visitors_foreign     = do_shortcode('[pwe_visitors_foreign]');
        $map_number_abroad_visitors = !empty($pwe_visitors_foreign) ? $pwe_visitors_foreign : $map_number_abroad_visitors;

        $pwe_exhibitors           = do_shortcode('[pwe_exhibitors]');
        $map_number_exhibitors    = !empty($pwe_exhibitors) ? $pwe_exhibitors : $map_number_exhibitors;

        $pwe_countries            = do_shortcode('[pwe_countries]');
        $map_number_countries     = !empty($pwe_countries) ? $pwe_countries : $map_number_countries;

        $pwe_area                 = do_shortcode('[pwe_area]');
        $map_exhibition_space     = !empty($pwe_area) ? $pwe_area : $map_exhibition_space;

        $pwe_visitors_prev        = do_shortcode('[pwe_visitors_prev]');
        $map_number_visitors_previous = !empty($pwe_visitors_prev) ? $pwe_visitors_prev : $map_number_visitors_previous;

        $pwe_visitors_foreign_prev = do_shortcode('[pwe_visitors_foreign_prev]');
        $map_number_abroad_visitors_previous = !empty($pwe_visitors_foreign_prev) ? $pwe_visitors_foreign_prev : $map_number_abroad_visitors_previous;

        $pwe_exhibitors_prev      = do_shortcode('[pwe_exhibitors_prev]');
        $map_number_exhibitors_previous = !empty($pwe_exhibitors_prev) ? $pwe_exhibitors_prev : $map_number_exhibitors_previous;

        $pwe_countries_prev       = do_shortcode('[pwe_countries_prev]');
        $map_number_countries_previous = !empty($pwe_countries_prev) ? $pwe_countries_prev : 0;

        $pwe_area_prev            = do_shortcode('[pwe_area_prev]');
        $map_exhibition_space_previous = !empty($pwe_area_prev) ? $pwe_area_prev : $map_exhibition_space_previous;

        $pwe_statistics_year_curr = do_shortcode('[pwe_statistics_year_curr]');
        $map_year                 = !empty($pwe_statistics_year_curr) ? $pwe_statistics_year_curr : $map_year;

        $pwe_statistics_year_prev = do_shortcode('[pwe_statistics_year_prev]');
        $map_year_previous        = !empty($pwe_statistics_year_prev) ? $pwe_statistics_year_prev : $map_year_previous;

        $map_number_visitors            = !empty($map_number_visitors) ? $map_number_visitors : 0;
        $map_percent_polish_visitors    = !empty($map_percent_polish_visitors) ? $map_percent_polish_visitors : 0;
        $map_number_countries           = !empty($map_number_countries) ? $map_number_countries : 15;

        $map_more_logotypes = (isset($atts['map_more_logotypes'])) ? explode(';', $atts['map_more_logotypes']) : '';

        $trade_fair_edition = do_shortcode('[trade_fair_edition]');
        $map_custom_edition = !empty($trade_fair_edition) ? $trade_fair_edition : $map_custom_current_edition;

        $trade_fair_edition = do_shortcode('[trade_fair_edition]');

        $map_custom_edition = !empty($trade_fair_edition) ? $trade_fair_edition : $map_custom_current_edition;

        if (!empty($map_dynamic_preset) && $map_dynamic_preset === 'preset_3') {
            if (!empty($map_year_previous) && !empty($map_custom_previous_edition)) {
                $map_custom_edition = $map_custom_previous_edition;
            }
        }

        if (!empty($map_custom_edition) && !in_array(strtolower($map_custom_edition), ['premierowa', 'premier'])
        ) {
            $map_custom_title = self::languageChecker(
                'Branżowi odwiedzający ' . $map_custom_edition . ' edycji',
                'Industry visitors of the ' . $map_custom_edition . 'nd edition'
            );
        }

        if (!empty($map_number_visitors_previous)) {
            $max_visitors = max($map_number_visitors, $map_number_visitors_previous);
            $map_number_visitors_percentage = ($map_number_visitors / $max_visitors) * 100;
            $map_number_visitors_previous_percentage = ($map_number_visitors_previous / $max_visitors) * 100;

            $map_number_visitors_increase = round(100 - $map_number_visitors_previous_percentage);
        }

        if (!empty($map_number_exhibitors_previous)) {
            $max_exhibitors = max($map_number_exhibitors, $map_number_exhibitors_previous);
            $map_number_exhibitors_percentage = ($map_number_exhibitors / $max_exhibitors) * 100;
            $map_number_exhibitors_previous_percentage = ($map_number_exhibitors_previous / $max_exhibitors) * 100;

            $map_number_exhibitors_increase = round(100 - $map_number_exhibitors_previous_percentage);
        }

        if (!empty($map_exhibition_space_previous)) {
            $max_exhibition_space = max($map_exhibition_space, $map_exhibition_space_previous);
            $map_exhibition_space_percentage = ($map_exhibition_space / $max_exhibition_space) * 100;
            $map_exhibition_space_previous_percentage = ($map_exhibition_space_previous / $max_exhibition_space) * 100;

            $map_exhibition_space_increase = round(100 - $map_exhibition_space_previous_percentage);
        }

        // CSS <----------------------------------------------------------------------------------------------<
        require_once plugin_dir_path(dirname( __FILE__ )) . 'assets/style.php';

        if ($map_dynamic_preset === 'preset_1') {
            require_once plugin_dir_path(__FILE__) . 'presets/map_dynamic_preset_1.php';
        } else if ($map_dynamic_preset === 'preset_2') {
            require_once plugin_dir_path(__FILE__) . 'presets/map_dynamic_preset_2.php';
        } else if ($map_dynamic_preset === 'preset_3') {
            require_once plugin_dir_path(__FILE__) . 'presets/map_dynamic_preset_3.php';
        }

        return $output;
    }
}