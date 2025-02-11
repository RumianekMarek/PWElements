<?php 

/**
 * Class PWElementConferenceCap
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementConferenceCap extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }    

    /**
     * Static method to initialize Visual Composer elements.
     * Returns an array of parameters for the Visual Composer element.
     */
    public static function initElements() {
        $element_output = array(
            array(
                'type'       => 'textfield',
                'group'      => 'PWE Element',
                'heading'    => __('Tytuł elementu', 'pwe_element'),
                'param_name' => 'conference_cap_title',
                'save_always'=> true,
                'std'        => __('Dane Konferencji', 'pwe_element'),
            ),
            array(
                'type'       => 'textfield',
                'group'      => 'PWE Element',
                'heading'    => __('Custom style', 'pwe_element'),
                'param_name' => 'conference_cap_style',
                'save_always'=> true,
            ),
        );
        return $element_output;
    }

    public static function output($atts) {
        // Pobieramy ustawienia shortcode
        extract(shortcode_atts(array(
            'conference_cap_title' => '',
            'conference_cap_style' => '',
        ), $atts));
        
        // URL, z którego pobieramy JSON
        $json_url = "https://mr.glasstec.pl/doc/Konf.json";
        
        // Pobieramy dane JSON przy użyciu wp_remote_get (bezpieczne pobieranie w WordPressie)
        $response = wp_remote_get($json_url);
        if (is_wp_error($response)) {
            return '<p>Błąd podczas pobierania danych JSON.</p>';
        }
        
        $body = wp_remote_retrieve_body($response);
        $json_data = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return '<p>Błąd podczas dekodowania danych JSON.</p>';
        }
        
        // Zmienna na dynamiczne reguły CSS do pokazywania właściwej treści
        $dynamic_css = "";
        
        // Tablica na zapis danych prelegentów (bio) – identyfikator lecture-box => dane
        $speakersDataMapping = array();

        // Rozpoczynamy budowę wyjścia HTML – dodajemy styl (CSS)
        $output = '
            <style>
                .conference_cap__tab-radio {
                    display: none !important;
                }
                .conference_cap__tabs-labels {
                    display: flex;
                    flex-wrap: nowrap;
                    margin: 10px;
                    justify-content: center;
                }
                .conference_cap__tab-label {
                    padding: 10px 20px;
                    background: #eee;
                    cursor: pointer;
                    margin: 4px;
                }
                .conference_cap__tab-radio:checked + .conference_cap__tab-label {
                    background: #ddd;
                    font-weight: bold;
                }
                .conference_cap__tab-content {
                    display: none;
                    padding: 15px;
                    border-top: 1px solid #ddd;
                }
                /* ---- lecture-box ---- */
                .conference_cap__lecture-box {
                    display: flex;
                    text-align: left;
                    gap: 18px;
                    margin-top: 36px;
                    padding: 10px;
                }
                .conference_cap__lecture-speaker {
                    width: 200px;
                    min-width: 200px;
                    display: flex;
                    flex-direction: column;
                    text-align: center;
                }
                .conference_cap__lecture-speaker-item {
                    margin-bottom: 10px;
                }
                .conference_cap__lecture-box-info {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    gap: 18px;
                }
                .conference_cap__lecture-time, .conference_cap__lecture-name, .conference_cap__lecture-title, .conference_cap__lecture-desc p {
                    margin: 0;
                }
                .conference_cap__lecture-speaker-img img {
                    border-radius: 50%;
                    max-width: 80%;
                    background: white;
                    border: 2px solid gray;
                    aspect-ratio: 1 / 1;
                    object-fit: cover;
                }
                .conference_cap__lecture-speaker-btn {
                    margin: 10px auto !important;
                    color: white;
                    background-color: var(--accent-color);
                    border: 1px solid var(--accent-color);
                    padding: 6px 16px;
                    font-weight: 600;
                    width: 80px;
                    border-radius: 10px;
                    transition: .3s ease;
                }
                .conference_cap__lecture-speaker-btn:hover {
                    color: white;
                    background-color: color-mix(in srgb, var(--accent-color), black 20%);
                    border: 1px solid color-mix(in srgb, var(--accent-color), black 20%);
                }       
                /* Style modala */
                .custom-modal-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 10000;
                }
                .custom-modal {
                    background: #fefefe;
                    padding: 20px;
                    border-radius: 8px;
                    position: relative;
                    max-width: 800px;
                    width: 90%;
                    max-height: 90%;
                    overflow-y: auto;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                    border: 1px solid #888;
                    transition: transform 0.3s;
                    transform: scale(0);
                }
                .custom-modal-close {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: transparent;
                    border: none;
                    font-size: 24px;
                    cursor: pointer;
                }
                .custom-modal-content {
                    display: flex;
                    flex-direction: column;
                    align-items: stretch;
                }
                .custom-modal-content img {
                    max-width: 150px;
                    border-radius: 8px;
                    margin-bottom: 10px;
                }
                .custom-modal-content h2 {
                    margin: 10px 0 10px;
                    font-size: 1.5em;
                }
                .custom-modal-content p {
                    margin: 0;
                }
                .custom-modal.visible {
                    transform: scale(1);
                }
            </style>
        ';
        
        if (!empty($conference_cap_title)) {
            $output .= '<h2>' . esc_html($conference_cap_title) . '</h2>';
        }
        
        $output .= '<div class="pwe-conference-cap-element" style="' . esc_attr($conference_cap_style) . '">';
        
        if (is_array($json_data) && !empty($json_data)) {
            // Przygotowujemy zmienne na nagłówki i treści
            $tab_headers = '';
            $tab_contents = '';
            $tab_index = 0;

            // Licznik do unikalnych identyfikatorów lecture-boxów
            $lecture_counter = 0;

            // Umieszczamy radio inputy na początku – muszą być rodzeństwem obu kontenerów
            $radio_inputs = '';

            foreach ($json_data as $day => $sessions) {
                $tab_index++;
                $checked = ($tab_index === 1) ? ' checked' : '';
                // Generujemy radio input – unikalny identyfikator
                $radio_inputs .= '<input type="radio" name="conference_cap_tabs" id="conference_cap_tab_' . $tab_index . '" class="conference_cap__tab-radio"' . $checked . '>';

                // Generujemy nagłówek (label)
                $tab_headers .= '<label for="conference_cap_tab_' . $tab_index . '" class="conference_cap__tab-label">' . esc_html($day) . '</label>';

                // Budujemy zawartość zakładki
                $content = '<div class="conference_cap__tab-content" id="content_conference_cap_tab_' . $tab_index . '">';
                if (is_array($sessions) && !empty($sessions)) {
                    $content .= '<div class="conference_cap__lecture-container">';
                    
                    // Iterujemy po sesjach dla danego dnia
                    foreach ($sessions as $session) {
                        $lecture_counter++; // zwiększamy licznik lecture-boxów
                        $lectureId = 'cap-lecture-' . $lecture_counter;

                        $time  = isset($session['time']) ? $session['time'] : '';
                        $title = isset($session['title']) ? $session['title'] : '';
                        $desc  = isset($session['desc']) ? $session['desc'] : '';
                        
                        // Pobieramy dane prelegentów – iterujemy po kluczach zaczynających się od "legent-"
                        $speakers = array();
                        foreach ($session as $key => $value) {
                            if (strpos($key, 'legent-') === 0 && is_array($value)) {
                                $speakers[] = $value;
                            }
                        }
                        
                        // Budujemy strukturę HTML dla pojedynczej sesji (lecture)
                        $content .= '<div id="' . esc_attr($lectureId) . '" class="conference_cap__lecture-box">';
                        
                        // Część dotycząca prelegentów
                        $content .= '<div class="conference_cap__lecture-speaker">';
                        $speakers_bios = array(); // tablica na dane do modala
                        if (!empty($speakers)) {
                            foreach ($speakers as $speaker) {
                                $speaker_name = isset($speaker['name']) ? $speaker['name'] : '';
                                $speaker_url  = isset($speaker['url']) ? $speaker['url'] : '';
                                $speaker_desc = isset($speaker['desc']) ? $speaker['desc'] : '';
                                // Wyświetlamy dane tylko, jeśli nazwa prelegenta jest podana i różna od "*"
                                if (!empty($speaker_name) && $speaker_name !== '*') {
                                    $content .= '<div class="conference_cap__lecture-speaker-item">';
                                    $content .= '<div class="conference_cap__lecture-speaker-img">';
                                    if (!empty($speaker_url)) {
                                        $content .= '<img src="' . esc_url($speaker_url) . '" alt="' . esc_attr($speaker_name) . '">';
                                    }
                                    $content .= '</div>';
                                    $content .= '</div>';
                                    // Zbieramy dane prelegenta do modala, jeśli opis (bio) nie jest pusty
                                    if (!empty($speaker_desc)) {
                                        $speakers_bios[] = array(
                                            'name' => $speaker_name,
                                            'url'  => $speaker_url,
                                            'bio'  => $speaker_desc
                                        );
                                    }
                                }
                            }
                            // Jeśli znaleziono prelegentów z bio, zapisujemy dane do globalnej mapy po identyfikatorze lecture-box
                            if (!empty($speakers_bios)) {
                                $speakersDataMapping[$lectureId] = $speakers_bios;
                                $content .= '<button class="conference_cap__lecture-speaker-btn">BIO</button>';
                            }
                        }
                        $content .= '</div>'; // Koniec .conference_cap__lecture-speaker
                        
                        // Część z informacjami o sesji
                        $content .= '<div class="conference_cap__lecture-box-info">';
                        
                        // Czas sesji
                        $content .= '<h4 class="conference_cap__lecture-time">' . esc_html($time) . '</h4>';
                        
                        // Nazwy prelegentów – łączymy, jeśli jest więcej niż jeden
                        $speaker_names = array();
                        if (!empty($speakers)) {
                            foreach ($speakers as $speaker) {
                                $speaker_name = isset($speaker['name']) ? $speaker['name'] : '';
                                if (!empty($speaker_name) && $speaker_name !== '*') {
                                    $speaker_names[] = $speaker_name;
                                }
                            }
                        }
                        $content .= '<h5 class="conference_cap__lecture-name">' . esc_html(implode(', ', $speaker_names)) . '</h5>';
                        
                        // Tytuł sesji
                        $content .= '<h4 class="conference_cap__lecture-title">' . esc_html($title) . '</h4>';
                        
                        // Opis sesji
                        $content .= '<div class="conference_cap__lecture-desc"><p>' . esc_html($desc) . '</p></div>';
                        
                        $content .= '</div>'; // Koniec .conference_cap__lecture-box-info
                        $content .= '</div>'; // Koniec .conference_cap__lecture-box
                    }
                    
                    $content .= '</div>'; // Koniec .conference_cap__lecture-container
                } else {
                    $content .= '<p>Brak danych do wyświetlenia.</p>';
                }
                $content .= '</div>'; // Koniec .conference_cap__tab-content
                
                // Zbieramy zawartość dla wszystkich zakładek
                $tab_contents .= $content;

                // Generujemy dynamiczną regułę CSS – gdy dany radio input jest zaznaczony, pokazujemy odpowiadający kontener
                $dynamic_css .= "#conference_cap_tab_{$tab_index}:checked ~ .conference_cap__tabs-contents #content_conference_cap_tab_{$tab_index} { display: block; } ";
            }
            
            // Wyjście – najpierw radio inputy
            $output .= '<div class="conference_cap__tabs">';
            $output .= $radio_inputs;
            // Kontener na nagłówki (zakładki)
            $output .= '<div class="conference_cap__tabs-labels">' . $tab_headers . '</div>';
            // Kontener na zawartość zakładek
            $output .= '<div class="conference_cap__tabs-contents">' . $tab_contents . '</div>';
            $output .= '</div>';
            
            // Dodajemy dynamicznie wygenerowany CSS do już istniejącego stylu
            $output .= '<style>' . $dynamic_css . '</style>';
            
        } else {
            $output .= '<p>Brak danych do wyświetlenia.</p>';
        }
        
        $output .= '</div>'; // Koniec .pwe-conference-cap-element

        // Generujemy globalną zmienną JavaScript ze zmapowanymi danymi prelegentów (klucz: id lecture-box)
        $globalSpeakersData = json_encode($speakersDataMapping);

        $output .= '
        <script>
          // Globalna zmienna zawierająca dane prelegentów dla poszczególnych lecture-boxów
          window.speakersData = ' . $globalSpeakersData . ' || {};
        
          const globalSpeakersData = ' . $globalSpeakersData . ';
          console.log(globalSpeakersData);
          document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".conference_cap__lecture-speaker-btn").forEach(function(button) {
              button.addEventListener("click", function(e) {
                e.preventDefault();
                // Znajdujemy najbliższy lecture-box i pobieramy jego id
                var lectureBox = this.closest(".conference_cap__lecture-box");
                if (!lectureBox) return;
                var lectureId = lectureBox.getAttribute("id");
                if (!lectureId || !window.speakersData[lectureId]) return;
                openSpeakersModal(window.speakersData[lectureId]);
              });
            });
        
            function openSpeakersModal(speakers) {
              var overlay = document.createElement("div");
              overlay.classList.add("custom-modal-overlay");
        
              var modal = document.createElement("div");
              modal.classList.add("custom-modal", "visible");
        
              var modalContent = "";
              speakers.forEach(function(speaker, index) {
                modalContent += `
                  <div class="modal-speaker">
                    ${ speaker.url ? `<img src="${speaker.url}" alt="${speaker.name}">` : "" }
                    <h2>${speaker.name}</h2>
                    <p>${speaker.bio}</p>
                  </div>
                `;
                if(index < speakers.length - 1) {
                  modalContent += "<hr style=\"margin: 20px 0;\">";
                }
              });
        
              modal.innerHTML = `
                <button class="custom-modal-close" title="Zamknij">&times;</button>
                <div class="custom-modal-content">
                  ${modalContent}
                </div>
              `;
        
              overlay.appendChild(modal);
              document.body.appendChild(overlay);
        
              modal.querySelector(".custom-modal-close").addEventListener("click", function() {
                document.body.removeChild(overlay);
              });
        
              overlay.addEventListener("click", function(e) {
                if(e.target === overlay) {
                  document.body.removeChild(overlay);
                }
              });
            }
          });
        </script>
        ';

        return $output;
    }    
    
}
