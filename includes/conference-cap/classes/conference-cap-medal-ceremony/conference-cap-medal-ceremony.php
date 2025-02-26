
<?php
class PWEConferenceCapMedalCeremony extends PWEConferenceCap{

        /**
       * Constructor method.
       * Calls parent constructor and adds an action for initializing the Visual Composer map.
       */
      public function __construct() {
        parent::__construct();
    }

 public static function output($atts, $sessions, $conf_function, &$speakersDataMapping){

    extract(shortcode_atts(array(
        'conference_cap_html' => '',
        'conference_cap_conference_mode' => '',
    ), $atts));

    
    
    $content .= '<div class="conference_cap_medal_ceremony__ceremony-container">';
    $content .= '<div class="conference_cap_medal_ceremony__date"';
    $content .= '<h4>Data</h4>';
    $content .= '<span>test</span>';
    $content .= '</div>';
    $content .= '<div class="conference_cap_medal_ceremony__location"';
    $content .= '<h4>Lokalizacja</h4>';
    $content .= '<span>test</span>';
    $content .= '</div>';

    
    $content .= '</div>';
 return $content;
  }

  }