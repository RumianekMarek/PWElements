<?php

trait PWEConferenceShortInfoFunctions {

    /** WYBÓR KLASY RENDERERA (widok skrótu) */
    public static function getConferenceRendererClass($domain, $fair_group) {

        if (in_array($domain, [
            'warsawhome.eu', 'warsawhomefurniture.com', 'warsawhometextile.com',
            'warsawhomelight.com', 'warsawhomekitchen.com', 'warsawhomebathroom.com',
            'warsawbuild.eu'
        ], true)) {
            require_once plugin_dir_path(__FILE__) . '/conference-short-info-home.php';
            return 'PWEConferenceShortInfoHome';
        }

        switch ($fair_group) {
            case 'gr1':
                require_once plugin_dir_path(__FILE__) . '/conference-short-info-gr1.php';
                return 'PWEConferenceShortInfoGr1';

            default:
                require_once plugin_dir_path(__FILE__) . '/conference-short-info-default.php';
                return 'PWEConferenceShortInfoDefault';
        }
    }

    /** WYBÓR KLASY RENDERERA (widok harmonogramu) */
    public static function getConferenceRendererClassSchedule($domain, $fair_group) {

        switch ($fair_group) {
            case 'gr3':
                require_once plugin_dir_path(__FILE__) . '/conference-short-info-gr3-schedule.php';
                return 'PWEConferenceShortInfoGr3Schedule';

            default:
                require_once plugin_dir_path(__FILE__) . '/conference-short-info-default-schedule.php';
                return 'PWEConferenceShortInfoDefaultSchedule';
        }
    }

    /** DNI TARGOWE NA PODSTAWIE SHORTCÓDÓW */
    public static function getFairDaysFromShortcodes(): array {

        $start_raw = do_shortcode('[trade_fair_datetotimer]');
        $end_raw   = do_shortcode('[trade_fair_enddata]');

        $start = DateTime::createFromFormat('Y/m/d H:i', $start_raw);
        $end   = DateTime::createFromFormat('Y/m/d H:i', $end_raw);
        if (!$start || !$end) return [];

        if ($end < $start) [$start, $end] = [$end, $start];

        $days = [];
        $period = new DatePeriod($start, new DateInterval('P1D'), (clone $end));
        foreach ($period as $d) $days[] = $d->format('Y-m-d');
        return $days;
    }

    /** CZY SĄ KONFERENCJE W DNIACH TARGOWYCH */
    public static function hasValidConferences($all_conferences, $fair_days): bool {

        if (empty($fair_days)) return false;

        foreach ($all_conferences as $conf) {
            $decoded_data = json_decode($conf->conf_data ?? '', true);
            $lang = (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'en') ? 'EN' : 'PL';
            if (!is_array($decoded_data) || !isset($decoded_data[$lang])) continue;

            foreach (array_keys($decoded_data[$lang]) as $key) {
                if ($key === 'main-desc') continue;
                $parsed_date = self::parse_conference_key_to_date($key, $conf->conf_slug);
                if ($parsed_date && in_array($parsed_date, $fair_days, true)) {
                    return true;
                }
            }
        }
        return false;
    }

    /** PARSOWANIE DATY Z KLUCZA */
    public static function parse_conference_key_to_date($key, $conf_slug = '') {

        $candidates = [];

        foreach (explode(';;', (string)$key) as $piece) {
            $piece = trim(html_entity_decode(strip_tags($piece)));
            if ($piece !== '') $candidates[] = $piece;
        }
        if (empty($candidates)) {
            $candidates[] = trim(html_entity_decode(strip_tags((string)$key)));
        }

        $date_patterns = [
            '\b\d{4}/\d{1,2}/\d{1,2}\b',   // Y/m/d
            '\b\d{1,2}/\d{1,2}/\d{4}\b',   // d/m/Y
            '\b\d{1,2}\.\d{1,2}\.\d{4}\b', // d.m.Y
            '\b\d{4}-\d{1,2}-\d{1,2}\b',   // Y-m-d
        ];
        $regex   = '~(' . implode('|', $date_patterns) . ')~u';
        $formats = ['Y/m/d', 'd/m/Y', 'd.m.Y', 'Y-m-d'];

        foreach ($candidates as $raw) {
            if (preg_match($regex, $raw, $m)) {
                $found = $m[0];
                foreach ($formats as $fmt) {
                    $dt = DateTime::createFromFormat($fmt, $found);
                    $errors = DateTime::getLastErrors();
                    if ($dt && $errors['warning_count'] === 0 && $errors['error_count'] === 0) {
                        [$Y, $mth, $d] = explode('-', $dt->format('Y-m-d'));
                        if (checkdate((int)$mth, (int)$d, (int)$Y)) {
                            return $dt->format('Y-m-d');
                        }
                    }
                }
            }
        }

        if (function_exists('current_user_can') && current_user_can('manage_options')) {
            echo "<script>console.log('Nieparsowalna data | slug: " . addslashes($conf_slug) . " | key: " . addslashes((string)$key) . "');</script>";
        }
        return null;
    }

    /** ORGANIZATOR KONFERENCJI (logo + opis) */
    public static function getConferenceOrganizer($conf_id, $conf_slug, $lang) {

        $logo_url = 'https://cap.warsawexpo.eu/public/uploads/conf/' . $conf_slug . '/organizer/conf_organizer.webp';
        $organizer_name = '';

        $preferred_slugs = ($lang === 'PL') ? ['org-name_pl'] : ['org-name_en', 'org-name_pl'];

        $cap_db = PWECommonFunctions::connect_database();
        if ($cap_db) {
            $placeholders = implode(',', array_fill(0, count($preferred_slugs), '%s'));
            $sql = $cap_db->prepare(
                "SELECT slug, data FROM conf_adds WHERE conf_id = %d AND slug IN ($placeholders)",
                array_merge([$conf_id], $preferred_slugs)
            );
            $rows = $cap_db->get_results($sql, ARRAY_A);

            $by_slug = [];
            foreach ($rows as $r) {
                if (!empty($r['data']) && $r['data'] !== 'null') {
                    $by_slug[$r['slug']] = trim($r['data'], "\"");
                }
            }
            foreach ($preferred_slugs as $slug_key) {
                if (!empty($by_slug[$slug_key])) { $organizer_name = $by_slug[$slug_key]; break; }
            }
        }

        $has_logo = false;
        $response = wp_remote_head($logo_url);
        $code = is_wp_error($response) ? 0 : (int) wp_remote_retrieve_response_code($response);
        if ($code >= 200 && $code < 400) $has_logo = true;

        if (empty($organizer_name) && !$has_logo) return null;

        return ['logo_url' => $has_logo ? $logo_url : null, 'desc' => $organizer_name];
    }
}
