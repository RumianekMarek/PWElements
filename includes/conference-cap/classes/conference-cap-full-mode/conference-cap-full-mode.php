
<?php
class PWEConferenceCapFullMode extends PWEConferenceCap{

        /**
       * Constructor method.
       * Calls parent constructor and adds an action for initializing the Visual Composer map.
       */
      public function __construct() {
        parent::__construct();
    }

    public static function output($atts, $sessions, $conf_function, &$speakersDataMapping, $tab_index, $conf_slug_index){


        extract(shortcode_atts(array(
            'conference_cap_title' => '',
            'conference_cap_style' => '',
            'conference_cap_html' => '',
            'conference_cap_conference_mode' => '',
        ), $atts));
        
        $content .= '<div class="conference_cap__lecture-container">';
        
            foreach ($sessions as $key => $session) {
                if (strpos($key, 'pre-') !== 0) {
                    continue; // Pomijamy wpisy, które nie zaczynają się od "pre-"
                }
                
                $lecture_counter++;
                $lectureId = $conf_slug_index . '-' . $tab_index . '-' . 'lecture-' . $lecture_counter;
                $time  = isset($session['time']) ? $session['time'] : '';
                $title = isset($session['title']) ? $session['title'] : '';
                $desc  = isset($session['desc']) ? $session['desc'] : '';

                // Pobieramy dane prelegentów
                $speakers = [];
                foreach ($session as $key => $value) {
                    if (strpos($key, 'legent-') === 0 && is_array($value)) {
                        $speakers[] = $value;
                    }
                }

                $content .= '<div id="' . esc_attr($lectureId) . '" class="conference_cap__lecture-box">
                    <div class="conference_cap__lecture-speaker">';
                        $speakers_bios = [];

                        if (!empty($speakers)) {
                            $speaker_images = []; // Tablica na zdjęcia prelegentów
                        
                            foreach ($speakers as $speaker) {
                                $speaker_name = isset($speaker['name']) ? $speaker['name'] : '';
                                $speaker_url  = isset($speaker['url']) ? $speaker['url'] : '';
                                $speaker_desc = isset($speaker['desc']) ? $speaker['desc'] : '';
                        
                                if (!empty($speaker_name) && $speaker_name !== '*') {
                                    $content .= '<div class="conference_cap__lecture-speaker-item">';
                        
                                    if (!empty($speaker_url)) {
                                        // Zapisanie URL do tablicy, zamiast dodawania pojedynczego obrazka w pętli
                                        $speaker_images[] = $speaker_url;
                                    }
                        
                                    $content .= '</div>'; // Koniec .conference_cap__lecture-speaker-item
                        
                                    if (!empty($speaker_desc)) {
                                        $speakers_bios[] = array(
                                            'name' => $speaker_name,
                                            'url'  => $speaker_url,
                                            'bio'  => $speaker_desc
                                        );
                                    }
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
                    
                    $content .= '</div>

                    <div class="conference_cap__lecture-box-info">
                        <h4 class="conference_cap__lecture-time">' . esc_html($time) . '</h4>';

                        $speaker_names = array_map(function ($speaker) {
                            return $speaker['name'];
                        }, $speakers);

                        if (!empty($speaker_names) && implode('', $speaker_names) !== 'brak') {
                            $content .= '<h5 class="conference_cap__lecture-name">' . implode('<br>', array_map('esc_html', $speaker_names)) . '</h5>';

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