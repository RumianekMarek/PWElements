<?php

class PWEConferenceShortInfoGr3Schedule extends PWEConferenceShortInfo {

    public static function initElements() {
        return [];
    }

    private static function limit_words(string $text, int $max_words = 12, string $ellipsis = '…'): string {
        $text = trim(strip_tags($text));               // na wszelki wypadek
        if ($max_words <= 0 || $text === '') return '';
        $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (!$words) return '';
        if (count($words) <= $max_words) return $text;
        return implode(' ', array_slice($words, 0, $max_words)) . $ellipsis;
    }

    public static function output($atts, $all_conferences, $rnd_class, $name, $title, $desc) {

        $lang = (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'en') ? 'EN' : 'PL';

        $processed_conferences = [];
        foreach ($all_conferences as $conf) {

            $conf_slug = $conf->conf_slug;
            $organizer_info = self::getConferenceOrganizer($conf->id, $conf_slug, $lang);

            if (!$organizer_info) continue;

            $logo = $organizer_info['logo_url'];

            $fair_days = self::getFairDaysFromShortcodes();

            if (!empty($fair_start) && !empty($fair_end)) {
                $interval = new DateInterval('P1D');
                $period = new DatePeriod($fair_start, $interval, $fair_end);
                foreach ($period as $day) {
                    $fair_days[] = $day->format('Y-m-d');
                }
            }

            $decoded_data = json_decode($conf->conf_data, true);
            if (!is_array($decoded_data) || !isset($decoded_data[$lang])) continue;

            // NIE przerywamy, gdy brak dni – tylko logujemy
            $keys = array_diff(array_keys($decoded_data[$lang]), ['main-desc']);
            if (empty($keys) && current_user_can('manage_options')) {
                echo "<script>console.log('Brak dni (tylko main-desc) | slug: " . addslashes($conf->conf_slug) . "');</script>";
            }

            // Zbieramy potencjalne dni (może wyjść pusto – to OK)
            $conference_dates = [];
            foreach (array_keys($decoded_data[$lang]) as $key) {
                if ($key === 'main-desc') continue;
                $parsed_date = self::parse_conference_key_to_date($key, $conf->conf_slug);
                if ($parsed_date) $conference_dates[] = $parsed_date;
            }

            // Filtrowanie po dniach targów (jeśli są), ale nie przerywamy, gdy wynik pusty
            if (!empty($fair_days)) {
                $conference_dates = array_values(array_filter(
                    $conference_dates,
                    fn($date) => in_array($date, $fair_days, true)
                ));
            }

            // Ustal zakres dat lub zostaw pustą
            $date_range = '';
            if (!empty($conference_dates)) {
                $start_date = min($conference_dates);
                $end_date   = max($conference_dates);

                $start_dt = new DateTime($start_date);
                $end_dt   = new DateTime($end_date);

                if ($start_dt->format('Y-m-d') === $end_dt->format('Y-m-d')) {
                    // jeden dzień → "dd | mm | rrrr"
                    $date_range = $start_dt->format('d') . ' | ' . $start_dt->format('m') . ' | ' . $start_dt->format('Y');
                } else {
                    // wiele dni → "dd–dd | mm | rrrr"
                    $date_range = $start_dt->format('d') . '–' . $end_dt->format('d') . ' | ' . $start_dt->format('m') . ' | ' . $start_dt->format('Y');
                }
            }

            // Dodajemy konferencję ZAWSZE — data może być pusta
            $processed_conferences[] = [
                'slug'  => $conf_slug,
                'title' => PWECommonFunctions::languageChecker($conf->conf_name_pl, $conf->conf_name_en ?? $conf->conf_name_pl),
                'img'   => PWECommonFunctions::languageChecker($conf->conf_img_pl, $conf->conf_img_en ?? $conf->conf_img_pl),
                'logo'  => $logo,
                'date'  => $date_range,
                'url'   => PWECommonFunctions::languageChecker('/wydarzenia', '/en/conferences') . '/?konferencja=' . $conf_slug,
            ];
        }

        // echo '<pre style="width:600px;">';
        // var_dump($processed_conferences);
        // echo '</pre>';

        $output = '';

        // Styl
        $output .= '<style>

            .row.limit-width.row-parent:has(#pwe-conf-short-info-gr3-schedule) {
                padding: 36px 0 !important;
                max-width: 100% !important;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__top-container {
                max-width: 1200px;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                margin: 18px auto;
                padding: 0 36px;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__congress-logo {
                max-width: 280px !important;
                width: 100%;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__title {
                font-size: clamp(1rem, 3vw, 2.5rem);
                font-weight: 900;
                line-height: 1;
                width: 100%;
                margin-top: 0px;
                color: var(--accent-color);
                /* opacity: .5; */
                text-transform: uppercase;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__subtitle {
                font-size: 26px;
                font-weight: 800;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__column-container {
                position: relative;
                display: flex;
                align-items: center;
                background-image: url(/doc/background.webp);
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
                justify-content: center;
                min-height: 450px;
                gap: 36px;
                padding: 0 36px;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__column-container:before {
                content: "";
                position: absolute;
                width: 100%;
                height: 100%;
                background: white;
                opacity: 0.4;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__column-container:after {
                content: "";
                position: absolute;
                width: 100%;
                height: 100%;
                background: var(--main2-color);
                clip-path: polygon(58% 0, 100% 0, 100% 100%, 58% 100%, 42% 50%);
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__left {
                flex: 1 1 30%;
                position: relative;
                max-width: 400px;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__info-box {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 18px;
                width: 100%;
                min-height: 340px;
            }

            .' . $rnd_class . '  .pwe-conf-short-info-gr3-schedule__info-box{
                opacity:0;
                pointer-events:none;
                transition: opacity .75s ease;
            }
            .' . $rnd_class . '  .pwe-conf-short-info-gr3-schedule__info-box.is-active{
                opacity:1;
                pointer-events:auto;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__info-box-logo {
                max-width: 160px !important;
                aspect-ratio: 3/2;
                object-fit: contain;
                background: white;
                border-radius: 18px;
                padding: 8px;
                box-shadow: 0 0 8px -4px black;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__info-box-date {
                background: white;
                max-width: 260px;
                width: 100%;
                text-align: center;
                padding: 8px 12px;
                border-radius: 9px;
                font-size: 16px;
                font-weight: 600;
                box-shadow: 0 0 8px -4px black;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__info-box-title {
                font-size: 18px;
                font-weight: 600;
                text-align: center;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__info-box-btn {
                border-radius: 36px;
                color: white !important;
                background: #0000004f;
                transform-origin: center !important;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__right {
                flex: 1 1 60%;
            }

            .' . $rnd_class . ' .swiper {
                max-width: 800px;
                padding: 28px 10px !important;
                user-select: none;
            }

            .' . $rnd_class . ' .swiper-slide {
                aspect-ratio: 1/1;
                border-radius: 18px;
                overflow: hidden;
            }

            .' . $rnd_class . ' .swiper-pagination {
                background: white;
                padding: 2px 4px;
                bottom: 0px !important;
                border-radius: 36px;
            }

            .' . $rnd_class . ' .swiper-pagination-bullet-active {
                background: var(--main2-color) !important;
            }

            .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__tile {
                height: auto;
                width: 100%;
                aspect-ratio: 1 / 1;
                object-fit: cover;
            }

            @media (max-width: 960px) {
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__left, 
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__right {
                    flex: 1 1 50%;
                }

                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__column-container:after {
                    clip-path: polygon(70% 0, 100% 0, 100% 100%, 70% 100%, 60% 50%);
                }
            }

            @media (max-width: 768px) {
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__top-container {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 12px;
                }
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__title {
                    font-size: clamp(22px, 5vw, 2.5rem);
                }
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__subtitle {
                    font-size: clamp(18px, 4vw, 2rem);
                }
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__column-container {
                    flex-direction: column;
                    background-image: url(/doc/header_mobile.webp);
                    padding: 36px 0;
                }
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__left, 
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__right {
                    flex: 1 1 100%;
                    padding: 0 36px;
                    max-width: unset;
                }
                .' . $rnd_class . '  .pwe-conf-short-info-gr3-schedule__info-box{
                    display: none;
                }
                .' . $rnd_class . '  .pwe-conf-short-info-gr3-schedule__info-box.is-active{
                    display: flex;
                    position: static;
                    transform: unset;
                }
                .' . $rnd_class . ' .pwe-conf-short-info-gr3-schedule__column-container:after {
                    clip-path: polygon(50% 70%, 100% 80%, 100% 100%, 0 100%, 0 80%);
                }

                .' . $rnd_class . ' .swiper {
                    padding: 0 10px 28px !important;
                    margin: 0 !important;
                }

            }
        </style>';

        // Layout
        $output .= '<div id="pwe-conf-short-info-gr3-schedule">
            <div class="pwe-conf-short-info-gr3-schedule__wrapper">
                <div class="pwe-conf-short-info-gr3-schedule__top-container">
                    <div class="pwe-conf-short-info-gr3-schedule__title-container">
                        <div class="pwe-conf-short-info-gr3-schedule__title">' . PWECommonFunctions::languageChecker('Konferencje i wydarzenia towarzyszące', 'Conferences and accompanying events') . '</div>
                        <div class="pwe-conf-short-info-gr3-schedule__subtitle">' . $name . '</div>
                    </div>
                    <img class="pwe-conf-short-info-gr3-schedule__congress-logo" src="/doc/kongres-color.webp" alt="Congress logo">
                </div>
                <div class="pwe-conf-short-info-gr3-schedule__column-container">
                    <div class="pwe-conf-short-info-gr3-schedule__left">';
                        $is_first_panel = true;
                        foreach ($processed_conferences as $item) {
                            $slug  = $item['slug'];
                            $raw_title        = $item['title'] ?? '';
                            $limited_title    = self::limit_words($raw_title, 20);
                            $content_title    = htmlspecialchars($limited_title, ENT_QUOTES, 'UTF-8');
                            $content_date     = $item['date'];
                            $content_logo     = $item['logo'];
                            $content_url      = $item['url'];

                            $output .= '<div class="pwe-conf-short-info-gr3-schedule__info-box ' . $slug . '-content ' . ($is_first_panel ? ' is-active' : '') .'">'
                                . ($content_date ? '<div class="pwe-conf-short-info-gr3-schedule__info-box-date">' . $content_date . '</div>' : '') .

                                 ($content_logo ? '<img class="pwe-conf-short-info-gr3-schedule__info-box-logo" src="' . $content_logo . '" alt="Logo">' : '') . '
                                <div class="pwe-conf-short-info-gr3-schedule__info-box-title">' . $content_title . '</div>
                                <a class="pwe-conf-short-info-gr3-schedule__info-box-btn btn" href="' . $content_url . '" target="_blank" rel="noopener">' .
                                    PWECommonFunctions::languageChecker('Zobacz więcej', 'See more') .
                                '</a>
                            </div>';
                            $is_first_panel = false;
                        }
                    $output .= '</div>
                    <div class="pwe-conf-short-info-gr3-schedule__right swiper">
                        <div class="swiper-wrapper">';
                            foreach ($processed_conferences as $item) {
                                if (empty($item["img"])) continue;
                                $src = htmlspecialchars($item["img"], ENT_QUOTES, "UTF-8");
                                $alt = htmlspecialchars(($item["title"] ?: $item["slug"]), ENT_QUOTES, "UTF-8");
                                $id  = htmlspecialchars(($item["slug"] ?: pathinfo($src, PATHINFO_FILENAME)), ENT_QUOTES, "UTF-8");

                                $output .= '
                                <div class="swiper-slide ' . $item['slug'] . '-slide">
                                    <img id="' . $id . '" class="pwe-conf-short-info-gr3-schedule__tile" data-no-lazy="1" src="' . $src . '" alt="' . $alt . '">
                                </div>';
                            }
                        $output .= '</div>
                    <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>';

        include_once plugin_dir_path(__FILE__) . '/../../../scripts/swiper.php';
        $output .= PWESwiperScripts::swiperScripts('conf-short-info-gr3-schedule', '#pwe-conf-short-info-gr3-schedule', 'true', '', '', ['autoplay' => ['delay'=>6000, 'disableOnInteraction'=>true, 'pauseOnMouseEnter'=>false], 'slideToClickedSlide' => true, 'watchSlidesProgress' => true],
            rawurlencode(json_encode([
                ['breakpoint_width' => 300, 'breakpoint_slides' => 1.5, 'centeredSlides' => true],
                ['breakpoint_width' => 600, 'breakpoint_slides' => 2],
                ['breakpoint_width' => 1024, 'breakpoint_slides' => 3],
            ]))
        );

        $output .= '
        <script>
        jQuery(function($){
        var $root = $("#pwe-conf-short-info-gr3-schedule");
        if (!$root.length) return;

        // --- GUARD: nie podpinaj kilka razy, jeśli skrypt wstrzyknięty wielokrotnie
        if ($root.data("gr3Bound")) return;
        $root.data("gr3Bound", true);

        var $panels  = $root.find(".pwe-conf-short-info-gr3-schedule__info-box");
        var $wrapper = $root.find(".swiper-wrapper");
        var $slides  = $wrapper.find(".swiper-slide");
        if (!$wrapper.length || !$slides.length) return;

        // pseudo-elementy nie łapią klików (na wypadek, gdyby CSS się nie zaktualizował)
        try {
            var cc = $root.find(".pwe-conf-short-info-gr3-schedule__column-container")[0];
            if (cc) {
            cc.style.setProperty("--pe-none","1");
            }
        } catch(e){}

        function slugFromSlideEl(el){
            if (!el) return null;
            var classes = (el.className || "").split(/\\s+/);
            for (var i = 0; i < classes.length; i++) {
            var c = classes[i];
            if (c === "swiper-slide" || c.indexOf("swiper-") === 0) continue;
            if (/-slide$/.test(c)) return c.replace(/-slide$/, "");
            }
            return null;
        }

        var lastSlug = null;
        var suppressUntil = 0;

        function activateBySlug(slug){
            if (!slug) { // fallback
            if (!$panels.filter(".is-active").length) $panels.first().addClass("is-active");
            return;
            }
            if (slug === lastSlug) return; // nie rób nic, jeśli już jest aktywny

            var $target = $panels.filter("." + slug + "-content");
            if (!$target.length) {
            // ostateczny fallback po indeksie
            var idx = $slides.index($slides.filter(function(){ return slugFromSlideEl(this) === slug; })[0]);
            if (idx >= 0) $target = $panels.eq(idx);
            }
            if (!$target.length) return;

            $panels.removeClass("is-active");
            $target.addClass("is-active");
            lastSlug = slug;
        }

        function updateFromActive(){
            // jeśli chwilę temu kliknęliśmy ręcznie, pomiń (żeby MO nie „cofnął”)
            if (Date.now() < suppressUntil) return;
            var active = $root.find(".swiper-slide.swiper-slide-active")[0];
            var slug = active ? slugFromSlideEl(active) : null;
            activateBySlug(slug);
        }

        // stan startowy
        if (!$panels.filter(".is-active").length) $panels.first().addClass("is-active");
        // inicjalna synchronizacja (bez logów)
        updateFromActive();
        setTimeout(updateFromActive, 200);

        // OBSERWATOR – tylko 1 instancja, obserwuj zmiany klas slajdów
        var mo = new MutationObserver(function(muts){
            for (var i=0;i<muts.length;i++){
            if (muts[i].attributeName === "class") { updateFromActive(); break; }
            }
        });
        $slides.each(function(){
            mo.observe(this, { attributes:true, attributeFilter:["class"] });
        });

        // HANDLERY – TYLKO JEDEN (click) i TYLKO na .swiper-slide
        $root.off("click.gr3").on("click.gr3", ".swiper-slide", function(e){
            e.preventDefault();
            e.stopPropagation();
            var slug = slugFromSlideEl(this);
            if (!slug) return;
            suppressUntil = Date.now() + 350; // 350 ms ignoruj MO, żeby nie cofnął wyboru
            activateBySlug(slug);
        });

        });
        </script>';

        return $output;
    }
}
