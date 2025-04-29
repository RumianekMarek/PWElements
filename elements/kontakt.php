<?php
/**
* Class PWElementContact
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementContact extends PWElements {

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
            $element_output[] = 
                array(
                    'type' => 'checkbox',
                    'group' => 'PWE Element',
                    'heading' => __('Horizontal display', 'pwelement'),
                    'param_name' => 'horizontal',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'pwe_element',
                        'value' => 'PWElementContact',
                    ),
                );
        return $element_output;
    }
    
    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts) {
        $all_images = self::findAllImages('/doc/galeria/zdjecia_wys_odw', 2);
        
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';

        $edition_1 = [
            "mr.glasstec.pl",
            "worldofbuildexpo.com", 
            "futureenergyweekpoland.com", 
            "industrialbuildingexpo.pl", 
            "filtratecexpo.com", 
            "chemtecpoland.com", 
            "lasertechnicapoland.com", 
            "coldtechpoland.com", 
            "warsawoptiexpo.com", 
            "funeralexpo.pl", 
            "coffeeeuropeexpo.com", 
            "pharmacyexpopoland.com", 
            "warsawwindowexpo.com", 
            "glasstechpoland.com", 
            "valvespumpsexpo.com", 
            "hairbarberweekpoland.com", 
            "concreteexpo.pl", 
            "automechanicawarsaw.com", 
            "fastechexpo.com", 
            "aiindustryexpo.com", 
            "medivisionforum.com", 
            "warsawprokitchen.com", 
            "aluminiumtechexpo.com", 
            "medinnovationsexpo.com", 
            "emobilityexpo.pl", 
            "worldofhydrogenexpo.com", 
            "warsawtoys.com", 
            "biopowerexpo.com", 
            "agrofarmaexpo.com", 
            "veterinaryexpopoland.com", 
            "isoltexexpo.com", 
            "polandsustainabilityexpo.com", 
            "solidsexpopoland.com", 
            "forestechexpopoland.com", 
            "lightexpo.pl", 
            "warsawclimatech.com", 
            "decarbonisationexpo.com", 
            "globalfoodexpo.pl", 
            "photonicsexpo.pl", 
            "waterexpopoland.com", 
            "warsawplastexpo.com", 
            "grindtechexpo.com", 
            "safetyrescueexpo.com", 
            "cybersecurityexpo.pl", 
            "pneumaticswarsaw.com", 
            "labotec.pl", 
            "coiltechexpo.com", 
            "autotuningshow.com", 
            "biurotexexpo.com", 
            "cosmopharmpack.com", 
            "huntingexpo.pl", 
            "warsawfleetexpo.com", 
            "warsawshopexpo.com", 
            "hotelequipmentexpo.com", 
            "bakerytechpoland.com", 
            "postdeliverylogisticsexpo.com", 
            "warsawgardentech.com", 
            "warsawspawellnessexpo.com", 
            "electroinstalexpo.com", 
            "wiretechpoland.com", 
            "tubetechnicpoland.com", 
            "bathceramicsexpo.com", 
            "warsawbusexpo.eu", 
            "centralnetargirolnicze.com"
        ];
        
        $edition_2 = [
            "esteticaexpo.com", 
            "automaticaexpo.com", 
            "batteryforumpoland.com", 
            "floorexpo.pl", 
            "door-tec.pl", 
            "furnitechexpo.pl", 
            "furniturecontractexpo.com", 
            "electronics-show.com", 
            "forumbhp.com", 
            "weldexpopoland.com", 
            "warsawprinttech.com", 
            "heatingtechexpo.com", 
            "recyclingexpo.pl", 
            "warsawsweettech.com", 
            "wodkantech.com", 
            "polandcoatings.com", 
            "gastroquickservice.com", 
            "warsawconstructionexpo.com", 
            "warsawtoolsshow.com", 
            "targirehabilitacja.pl", 
            "boattechnica.com", 
            "automotive-expo.eu", 
            "packagingpoland.pl", 
            "labelingtechpoland.com", 
            "warsawmedicalexpo.com", 
            "warsawsecurityexpo.com", 
            "foodtechexpo.pl", 
            "facadeexpo.pl", 
            "roofexpo.pl", 
            "poultrypoland.com", 
            "bioagropolska.com", 
            "fruitpolandexpo.com", 
            "warsawmetaltech.pl", 
            "maintenancepoland.com", 
            "controldrivespoland.com", 
            "intralogisticapoland.com", 
            "roboticswarsaw.com", 
            "compositepoland.com", 
            "smarthomeexpo.pl", 
            "warsawstone.com", 
            "woodwarsawexpo.com", 
            "beerwarsawexpo.com", 
            "winewarsawexpo.com", 
            "cleantechexpo.pl", 
            "buildoutdoorexpo.com", 
            "bioexpo.pl"
        ];
        
        $edition_3 = [
            "warsawpack.pl", 
            "mttsl.pl", 
            "warsawfoodexpo.pl", 
            "dentalmedicashow.pl", 
            "beautydays.pl", 
            "boatshow.pl", 
            "warsawhome.eu", 
            "warsawhomefurniture.com", 
            "warsawhomekitchen.com", 
            "warsawhomelight.com", 
            "warsawhometextile.com", 
            "warsawhomebathroom.com", 
            "warsawbuild.eu", 
            "industryweek.pl", 
            "solarenergyexpo.com", 
            "remadays.com", 
            "franczyzaexpo.pl", 
            "etradeshow.pl", 
            "warsawgardenexpo.com", 
            "warsawgiftshow.com", 
            "eurogastro.com.pl", 
            "worldhotel.pl", 
            "warsawhvacexpo.com"
        ];
        
        $edition_b2c = [
            "campercaravanshow.com", 
            "motorcycleshow.pl", 
            "animalsdays.eu", 
            "oldtimerwarsaw.com", 
            "fiwe.pl", 
            "ttwarsaw.pl", 
            "warsawmotorshow.com"
        ];        

        // Get domain address
        $current_url = $_SERVER['HTTP_HOST'];

        // Check which edition the current domain belongs to
        if (in_array($current_url, $edition_1)) {
            $edition_number = "edition_1";
            $service_mail = "biuro.podawcze1";
            $media_mail = "media1";
        } else if (in_array($current_url, $edition_2)) {
            $edition_number = "edition_2";
            $service_mail = "biuro.podawcze2";
            $media_mail = "media2";
            $contact_name = strtolower($edition_2[$current_url]);
        } else if (in_array($current_url, $edition_3)) {
            $edition_number = "edition_3";
            $service_mail = "biuro.podawcze3";
            $media_mail = "media3";
        } else {
            $edition_number = "edition_b2c";
            $service_mail = "biuro.podawcze3";
            $media_mail = "media3";
        }

        $output = '';

        $output .= '
        <style>
            .pwelement_'. self::$rnd_id .' .pwe-container-contact {
                padding: 36px;
                border: 1px solid black;
                border-radius: 18px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-container-contact-items {
                display:flex; 
                flex-direction: column;
                gap: 18px;
                margin-top: 18px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-contact-icon-item {
                display:flex; 
                align-items: center;
                gap: 18px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-contact-icon-item a {
                font-size: 14px;
                display: flex;
                flex-wrap: wrap;
            }
            .pwelement_'. self::$rnd_id .' .pwe-container-contact img{
                max-width: 110px !important;
                border-radius: 18px;
            }
            .pwelement_'. self::$rnd_id .' .uncode_text_column :is(p, a),
            .pwelement_'. self::$rnd_id .' .pwe-heading-text h4 {
                margin: 0;
                ' . $text_color . '
            }
            .pwelement_'. self::$rnd_id .' .pwe-container-contact .main-pwe-heading-text {
                padding-top: 0;
                text-transform: uppercase;
            }

            @media (max-width:860px){
                .pwelement_'. self::$rnd_id .' .pwe-contact-icon-item {
                    flex-wrap: wrap;
                    justify-content: center;
                    text-align: center;
                    flex-direction: column;
                }
                .pwelement_'. self::$rnd_id .' .pwe-heading-text {
                    text-align: center;
                }
                .pwelement_'. self::$rnd_id .' .pwe-heading-text h4 {
                    width: 100%;
                    margin-bottom: 10px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-contact-icon-item p { 
                    min-width: 160px;
                }
            }';

            if (isset($atts["horizontal"]) && $atts["horizontal"] == "true") {
                $output .= '
                .pwelement_'. self::$rnd_id .' .pwe-container-contact-items {
                    display: flex; 
                    flex-wrap: wrap;
                    justify-content: space-evenly;
                }
                .pwelement_'. self::$rnd_id .' .pwe-contact-icon-item {
                    flex-direction: column;
                    text-align: center;
                    flex: 1;
                }
                .pwelement_'. self::$rnd_id .' {
                    padding: 9px 0;
                }';
            }
        $output .= '
        </style>

        <div id="contact" class="pwe-container-contact">

            <div class="pwe-heading-text main-pwe-heading-text">
                <h4>'.self::languageChecker('Obsługa klienta', 'Customer service').'</h4>
            </div>

            <div class="pwe-container-contact-items">

                <div class="pwe-contact-icon-item">
                    <img src="/wp-content/plugins/PWElements/media/Phone.jpg" alt="grafika słuchawka">
                    <div class="uncode_text_column">
                        <p>
                            <b>'. self::languageChecker('Biuro obsługi', 'Customer Service Office') .'</b>
                            <a href="tel:+48518739124">+48 518 739 124</a>
                            <a href="mailto:'. $service_mail .'@warsawexpo.eu">
                                <span>'. $service_mail .'</span><span>@warsawexpo.eu</span>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="pwe-contact-icon-item">
                    <img src="/wp-content/plugins/PWElements/media/WystawcyZ.jpg" alt="grafika wystawcy">
                    <div class="uncode_text_column">
                        <p>
                            <b>'.self::languageChecker('Obsługa techniczna wystawców<br>', 'Technical support for exhibitors<br>').'</b>
                            <a href="mailto:konsultanttechniczny@warsawexpo.eu">
                                <span>konsultanttechniczny</span><span>@warsawexpo.eu</span>
                            </a>
                        </p>
                    </div>
                </div>

            </div>

            <div class="pwe-heading-text main-pwe-heading-text" style="margin-top: 36px;">
                <h4>'.self::languageChecker('Media i marketing', 'Media and marketing').'</h4>
            </div>

            <div class="pwe-container-contact-items">

                <div class="pwe-contact-icon-item">
                    <img src="/wp-content/plugins/PWElements/media/Marketing.jpg" alt="grafika technicy">
                    <div class="uncode_text_column" style="overflow-wrap: anywhere;">
                        <p>
                            <b>'. self::languageChecker('Obsługa marketingowa i media', 'Marketing and media services').'</b>
                            <a href="mailto:'. $media_mail .'@warsawexpo.eu">
                                <span>'. $media_mail .'</span><span>@warsawexpo.eu</span>
                            </a>
                        </p>
                    </div>
                </div>';

                if (in_array($current_url, $edition_1)) {
                    $output .= '
                    <div class="pwe-contact-icon-item">
                        <img src="/wp-content/plugins/PWElements/media/Person.jpg" alt="grafika osoby">
                        <div class="uncode_text_column" style="overflow-wrap: anywhere;">
                            <p>
                                <b>Agata Olej</b>
                                <a href="tel:+48690520874">+48 690 520 874</a>
                                <a href="mailto:agata.olej@warsawexpo.eu">
                                    <span>agata.olej</span><span>@warsawexpo.eu</span>
                                </a>
                            </p>
                        </div>
                    </div>';
                }             
                
                $output .= '
            </div>

        </div>';         

    return $output;
    }
}
