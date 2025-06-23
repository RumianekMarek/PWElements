<?php

function render_gr2($atts, $source_utm){
  extract( shortcode_atts( array(
    'registration_form_id' => '',
    'register_show_ticket' => '',
    'register_ticket_price_frist' => '',
    'register_ticket_register_benefits' => '',
    'register_ticket_link' => '',
    'badgevipmockup' => '',
  ), $atts ));


  if (strpos($source_utm, 'utm_source=premium') !== false || strpos($source_utm, 'utm_source=platyna') !== false ) {
      $badgevipmockup = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/badgevipmockup.webp') ? '/doc/badgevipmockup.webp' : '');
  } else if(strpos($source_utm, 'utm_source=byli') !== false ) {
      if (get_locale() == 'pl_PL') {
          $badgevipmockup = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/badgevipmockup.webp') ? '/doc/badgevipmockup.webp' : '');
      } else {
          $badgevipmockup = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/badgevipmockup-en.webp') ? '/doc/badgevipmockup-en.webp' : '/doc/badgevipmockup.webp');
      }
  }

  if (strpos($source_utm, 'utm_source=byli') !== false || strpos($source_utm, 'utm_source=premium') !== false ) {

    $output .= '
    <div id="pweRegistration" class="pwe-registration vip">
        <div class="pwe-reg-column pwe-mockup-column">
            <img src="'. $badgevipmockup .'">
        </div>
        <div class="pwe-reg-column pwe-registration-column">
            <div class="pwe-registration-step-text">
                <p>'. PWECommonFunctions::languageChecker('Krok 1 z 2', 'Step 1 of 2') .'</p>
            </div>
            <div class="pwe-registration-title">
                <h4>'. PWECommonFunctions::languageChecker('Twój bilet na targi', 'Your ticket to the trade fair') .'</h4>
            </div>
            <div class="pwe-registration-form">
                [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
            </div>
        </div>
    </div>';
    } else if(strpos($source_utm, 'utm_source=platyna') !== false){
      $output .= '
            <div id="pweRegistration" class="pwe-registration platyna">
              <div class="pwe-registration-column">

                <div id="pweForm">
                  <div class="pweform_container">
                    <div class="form">
                      <h3>'. PWECommonFunctions::languageChecker('Krok 1 z 2', 'Step 1 of 2') .'</h3>
                      <h2 class="form-title">'. PWECommonFunctions::languageChecker('Twój bilet<br>na targi', 'Your ticket<br>to the fair') .'</h2>
                      <div class="pwe-registration-form">
                        [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
                      </div>
                    </div>
                    <div class="benefits">
                      <h2>'. PWECommonFunctions::languageChecker('Zaproszenie Vip obejmuje', 'The Vip invitation includes') .'</h2>
                      <div class="benefits_icon">
                        <img src="/wp-content/plugins/pwe-media/media/platyna/fasttrack.webp" />
                        <p>'. PWECommonFunctions::languageChecker('Wejście bezpłatne', 'Free entry') .'</br>FAST TRACK</p>
                      </div>
                      <div class="benefits_icon">
                        <img src="/wp-content/plugins/pwe-media/media/platyna/obsluga.webp" />
                        <p>'. PWECommonFunctions::languageChecker('Obsługę concierge"a', 'Concierge service') .'</p>
                      </div>
                      <div class="benefits_icon">
                        <img src="/wp-content/plugins/pwe-media/media/platyna/vip.webp" />
                        <p>'. PWECommonFunctions::languageChecker('Strefę VIP ROOM', 'VIP ROOM Zone') .'</p>
                      </div>
                      <div class="benefits_icon">
                        <img src="/wp-content/plugins/pwe-media/media/platyna/aktywacja.webp" />
                        <p>'. PWECommonFunctions::languageChecker('Możliwość wcześniejszej</br>aktywacji zaproszenia', 'Possibility of earlier</br> activation of the invitation') .'</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
   } else {
            $output .= '
            <div id="pweRegistration" class="pwe-registration">
                <div class="pwe-registration-column">
                    <div id="pweForm">
                        <img class="form-badge-top" src="/wp-content/plugins/PWElements/media/badge_top.png">
                        <div class="form-container pwe-registration">
                            <div class="form-badge-header">
                                <h2 class="form-header-title">'. PWECommonFunctions::languageChecker('Twój bilet<br>na targi', 'Your ticket<br>to the fair') .'</h2>
                                <a href="https://warsawexpo.eu/" target="_blank"><img class="form-header-image-qr" src="/wp-content/plugins/PWElements/media/logo_pwe_black.webp"></a>
                            </div>
                            <img class="form-badge-left" src="/wp-content/plugins/PWElements/media/badge_left.png">
                            <img class="form-badge-bottom" src="/wp-content/plugins/PWElements/media/badge_bottom.png">
                            <img class="form-badge-right" src="/wp-content/plugins/PWElements/media/badge_right.png">
                            <a href="https://warsawexpo.eu/" target="_blank"><img class="form-image-qr" src="/wp-content/plugins/PWElements/media/logo_pwe_black.webp"></a>
                            <div class="form">
                                <h2 class="form-title">'. PWECommonFunctions::languageChecker('Twój bilet<br>na targi', 'Your ticket<br>to the fair') .'</h2>
                                <div class="pwe-registration-form">
                                    [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

  return $output;
}
