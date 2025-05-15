
<?php
class PWEConferenceCapFullMode extends PWEConferenceCap{

        /**
       * Constructor method.
       * Calls parent constructor and adds an action for initializing the Visual Composer map.
       */
      public function __construct() {
        parent::__construct();
    }

    public static function output($atts, $sessions, $conf_function, &$speakersDataMapping, $short_day, $conf_slug_index){


        extract(shortcode_atts(array(
            'conference_cap_title' => '',
            'conference_cap_style' => '',
            'conference_cap_html' => '',
            'conference_cap_conference_mode' => '',
        ), $atts));

        $has_any_speaker_info = false;

        foreach ($sessions as $session) {
            foreach ($session as $key => $value) {
                if (strpos($key, 'legent-') === 0 && is_array($value)) {
                    if (
                        (!empty($value['url'])) ||
                        (!empty($value['desc'])) ||
                        (!empty($value['name']))
                    ) {
                        $has_any_speaker_info = true;
                        break 2; // Wystarczy jeden przypadek – przerywamy sprawdzanie
                    }
                }
            }
        }
        
        $content .= '<div class="conference_cap__lecture-container">';
        
            foreach ($sessions as $key => $session) {
                if (strpos($key, 'pre-') !== 0) {
                    continue; // Pomijamy wpisy, które nie zaczynają się od "pre-"
                }
                
                $lecture_counter++;
                $lectureId = $conf_slug_index . '_' . $short_day . '_' . 'pre-' . $lecture_counter;
                $time  = isset($session['time']) ? $session['time'] : '';
                $title = isset($session['title']) ? $session['title'] : '';
                $desc  = isset($session['desc']) ? $session['desc'] : '';

                $formatted_speaker_names = [];

                // Pobieramy dane prelegentów
                $speakers = [];
                foreach ($session as $key => $value) {
                    if (strpos($key, 'legent-') === 0 && is_array($value)) {
                        $speakers[] = $value;
                    }
                }

                $content .= '<div id="' . esc_attr($lectureId) . '" class="conference_cap__lecture-box">';
                if ($has_any_speaker_info) {
                    $content .= '<div class="conference_cap__lecture-speaker">';
                        $speakers_bios = [];

                        if (!empty($speakers)) {
                            $speaker_images = []; // Tablica na zdjęcia prelegentów
                        
                            foreach ($speakers as $speaker) {
                                $raw_name = isset($speaker['name']) ? $speaker['name'] : '';
                                $name_parts = explode(';;', $raw_name);
                            
                                // Do HTML-a
                                $speaker_name_html = esc_html($name_parts[0]);
                                if (isset($name_parts[1])) {
                                    $speaker_name_html .= '<br><span class="conference_cap__lecture-name-subline">' . esc_html($name_parts[1]) . '</span>';
                                }
                            
                                // Do atrybutów alt, bio['name'], itp.
                                $speaker_name_plain = esc_html(trim($name_parts[0] . (isset($name_parts[1]) ? ' ' . $name_parts[1] : '')));
                            
                                $speaker_url  = isset($speaker['url']) ? $speaker['url'] : '';
                                $speaker_desc = isset($speaker['desc']) ? $speaker['desc'] : '';
                            
                                if (!empty($speaker_name_plain) && $speaker_name_plain !== '*') {
                                    $content .= '<div class="conference_cap__lecture-speaker-item">';
                            
                                    if (!empty($speaker_url)) {
                                        $speaker_images[] = $speaker_url;
                                    }
                            
                                    $content .= '</div>'; // Koniec .conference_cap__lecture-speaker-item
                            
                                    if (!empty($speaker_desc)) {
                                        $speakers_bios[] = array(
                                            'name' => $speaker_name_plain,
                                            'name_html' => $speaker_name_html,
                                            'url'  => $speaker_url,
                                            'bio'  => $speaker_desc
                                        );
                                    }
                            
                                    // Zbieramy nazwę w wersji HTML do późniejszego użycia (np. <h5>)
                                    $formatted_speaker_names[] = $speaker_name_html;
                                }
                            }
                            
                        
                            // Dodanie funkcji speakerImageMini po pętli
                            if (!empty($speaker_images)) {
                                $content .= '<div class="conference_cap__lecture-speaker-img">' . $conf_function::speakerImageMini($speaker_images) . '</div>';
                            }
                        
                            if (!empty($speakers_bios)) {
                                $speakersDataMapping[$lectureId] = $speakers_bios;
                                $content .= '<button class="conference_cap__lecture-speaker-btn">BIO</button>';
                            }

                        }
                    
                    $content .= '</div>';
                }

                     $content .= '
                     <div class="conference_cap__lecture-box-info">
                        <h4 class="conference_cap__lecture-time">' . esc_html($time) . '</h4>';

                        $speaker_names = $formatted_speaker_names ?? [];
                        

                        if (!empty($speaker_names) && implode('', $speaker_names) !== 'brak') {
                            $content .= '<h5 class="conference_cap__lecture-name">' . implode('<br>', $speaker_names) . '</h5>';
                        }
                        
                        $content .= '<h4 class="conference_cap__lecture-title">' . esc_html($title) . '</h4>
                        <div class="conference_cap__lecture-desc"><p>' . $desc . '</p></div>
                    </div>
                </div>';
            }

        $content .= '</div>';

        return $content;
    }

}