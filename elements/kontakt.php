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
            "mr.glasstec.pl" => "Agata",
            "tubetechnicpoland.com" => "Agata",
            "wiretechpoland.com" => "Agata",
            "maintenancepoland.com" => "Patrycja",
            "controldrivespoland.com" => "Patrycja",
            "roboticswarsaw.com" => "Agata",
            "compositepoland.com" => "Agata",
            "bathceramicsexpo.com" => "Aleksandra",
            "warsawstone.com" => "Patrycja",
            "smarthomeexpo.pl" => "Izabela",
            "cleantechexpo.pl" => "Izabela",
            "worldofbuildexpo.com" => "Aleksandra",
            "filtratecexpo.com" => "Aleksandra",
            "medivisionforum.com" => "Izabela",
            "automechanicawarsaw.com" => "Patrycja",
            "futureenergyweekpoland.com" => "Agata",
            "labotec.pl" => "Aleksandra",
            "aluminiumtechexpo.com" => "Izabela",
            "industrialbuildingexpo.pl" => "Patrycja",
            "cybersecurityexpo.pl" => "Agata",
            "chemtecpoland.com" => "Aleksandra",
            "pneumaticswarsaw.com" => "Patrycja",
            "lasertechnicapoland.com" => "Izabela",
            "isoltexexpo.com" => "Agata",
            "coldtechpoland.com" => "Agata",
            "coiltechexpo.com" => "Patrycja",
            "funeralexpo.pl" => "Izabela",
            "pharmacyexpopoland.com" => "Izabela",
            "polandsustainabilityexpo.com" => "Patrycja",
            "warsawoptiexpo.com" => "Aleksandra",
            "coffeeeuropeexpo.com" => "Izabela",
            "hairbarberweekpoland.com" => "Aleksandra",
            "warsawwindowexpo.com" => "Patrycja",
            "glasstechpoland.com" => "Agata",
            "valvespumpsexpo.com" => "Izabela",
            "grindtechexpo.com" => "Patrycja",
            "concreteexpo.pl" => "Izabela",
            "fastechexpo.com" => "Aleksandra",
            "cosmopharmpack.com" => "",
            "worldofhydrogenexpo.com" => "",
            "solidsexpopoland.com" => "",
            "emobilityexpo.pl" => "Agata",
            "decarbonisationexpo.com" => "",
            "warsawgardentech.com" => "",
            "lightexpo.pl" => "Izabela",
            "warsawtoys.com" => "",
            "labelingtechpoland.com" => "Agata, Patrycja",
        ];
        
        
        $edition_2 = [
            "warsawmetaltech.pl" => "",
            "warsawplastexpo.com" => "",
            "forumbhp.com" => "",
            "weldexpopoland.com" => "",
            "warsawprinttech.com" => "",
            "heatingtechexpo.com" => "",
            "recyclingexpo.pl" => "",
            "warsawsweettech.com",
            "wodkantech.com" => "",
            "gastroquickservice.com" => "",
            "bioagropolska.com" => "",
            "poultrypoland.com" => "",
            "electroinstalexpo.com" => "",
            "polandcoatings.com" => "",
            "warsawsecurityexpo.com" => "",
            "warsawmedicalexpo.com" => "",
            "facadeexpo.pl" => "",
            "roofexpo.pl" => "",
            "fruitpolandexpo.com" => "",
            "packagingpoland.pl" => "Agata, Patrycja",
            "intralogisticapoland.com" => "",
            "esteticaexpo.com" => "",
            "furnitechexpo.pl" => "",
            "furniturecontractexpo.com" => "",
            "batteryforumpoland.com" => "",
            "floorexpo.pl" => "",
            "door-tec.pl" => "",
            "electronics-show.com" => "",
            "winewarsawexpo.com" => "Patrycja",
            "beerwarsawexpo.com" => "Patrycja",
            "boattechnica.com" => "",
            "automotive-expo.eu" => "",
            "buildoutdoorexpo.com" => "",
            "warsawtoolsshow.com" => "",
            "woodwarsawexpo.com" => "",
            "warsawconstructionexpo.com" => ""
        ];
        
        $edition_3 = [
            "warsawpack.pl" => "",
            "industryweek.pl" => "",
            "dentalmedicashow.pl" => "",
            "boatshow.pl" => "",
            "campercaravanshow.com" => "",
            "bioexpo.pl" => "",
            "warsawfoodexpo.pl" => "",
            "fasttextile.com" => "",
            "centralnetargirolnicze.com" => "",
            "warsawmotorshow.com" => "",
            "motorcycleshow.pl" => "",
            "animalsdays.eu" => "",
            "mttsl.pl" => "",
            "warsawgiftshow.com" => "",
            "warsawbusexpo.eu" => "",
            "eurogastro.com.pl" => "",
            "remadays.com" => "",
            "warsawhomefurniture.com" => "",
            "warsawbuild.eu" => "",
            "warsawhomekitchen.com" => "",
            "warsawhomelight.com" => "",
            "warsawhometextile.com" => "",
            "warsawhomebathroom.com" => "",
            "ttwarsaw.pl" => "",
            "fiwe.pl" => "",
            "etradeshow.pl" => "",
            "franczyzaexpo.pl" => "",
            "worldhotel.pl" => "",
            "beautydays.pl" => "",
            "solarenergyexpo.com" => "",
            "warsawhvacexpo.com" => "",
            "foodtechexpo.pl" => "",
            "automaticaexpo.com" => "",
            "targirehabilitacja.pl" => ""
        ];

        // Get domain address
        $current_url = $_SERVER['HTTP_HOST'];

        // Check which edition the current domain belongs to
        if (array_key_exists($current_url, $edition_1)) {
            $edition_number = "edition_1";
            $service_mail = "biuro.podawcze1";
            $contact_name = strtolower($edition_1[$current_url]);
        } elseif (array_key_exists($current_url, $edition_2)) {
            $edition_number = "edition_2";
            $service_mail = "biuro.podawcze2";
            $contact_name = strtolower($edition_2[$current_url]);
        } elseif (array_key_exists($current_url, $edition_3)) {
            $edition_number = "edition_3";
            $service_mail = "biuro.podawcze3";
            $contact_name = strtolower($edition_3[$current_url]);
        } else {
            $edition_number = "edition_1";
            $service_mail = "biuro.podawcze1";
            $contact_name = strtolower($edition_1[$current_url]);
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
                                <a href="mailto:media@warsawexpo.eu">
                                    <span>media</span><span>@warsawexpo.eu</span>
                                </a>
                            </p>
                        </div>
                    </div>';

                    if (!empty($contact_name)) {

                        if (strpos($contact_name, "izabela") !== false) {
                            $output .= '
                            <div class="pwe-contact-icon-item">
                                <img src="/wp-content/plugins/PWElements/media/Person.jpg" alt="grafika osoby">
                                <div class="uncode_text_column" style="overflow-wrap: anywhere;">
                                    <p>
                                        <b>Izabela Górska</b>
                                        <a href="tel:+48453068740">+48 453 068 740</a>
                                        <a href="mailto:izabela.gorska@warsawexpo.eu">
                                            <span>izabela.gorska</span><span>@warsawexpo.eu</span>
                                        </a>
                                    </p>
                                </div>
                            </div>';
                        }
                        if (strpos($contact_name, "patrycja") !== false) {
                            $output .= '
                            <div class="pwe-contact-icon-item">
                                <img src="/wp-content/plugins/PWElements/media/Person.jpg" alt="grafika osoby">
                                <div class="uncode_text_column" style="overflow-wrap: anywhere;">
                                    <p>
                                        <b>Patrycja Łukasik</b>
                                        <a href="tel:+48572333909">+48 572 333 909</a>
                                        <a href="mailto:patrycja.lukasik@warsawexpo.eu">
                                            <span>patrycja.lukasik</span><span>@warsawexpo.eu</span>
                                        </a>
                                    </p>
                                </div>
                            </div>';
                        } 
                        if (strpos($contact_name, "agata") !== false) {
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
                        if (strpos($contact_name, "aleksandra") !== false) {
                            $output .= '
                            <div class="pwe-contact-icon-item">
                                <img src="/wp-content/plugins/PWElements/media/Person.jpg" alt="grafika osoby">
                                <div class="uncode_text_column" style="overflow-wrap: anywhere;">
                                    <p>
                                        <b>Aleksandra Pączek</b>
                                        <a href="tel:+48453068739">+48 453 068 739</a>
                                        <a href="mailto:aleksandra.paczek@warsawexpo.eu">
                                            <span>aleksandra.paczek</span><span>@warsawexpo.eu</span>
                                        </a>
                                    </p>
                                </div>
                            </div>';
                        }
                    
                    }
                    
                    $output .= '
                </div>

            </div>';         

    return $output;
    }
}
