<?php

function render_gr3($atts, $all_exhibitors, $pweGeneratorWebsite){
    extract( shortcode_atts( array(
        'generator_form_id' => '',
        'exhibitor_generator_html_text' => '',
        'generator_catalog' => '',
        'generator_patron' => '',
    ), $atts ));

    $output = '';
    $output .= '
        <div class="exhibitor-generator" data-group="gr3">
            <div class="exhibitor-generator__wrapper">
                <div class="exhibitor-generator__left"></div>
                <div class="exhibitor-generator__right">
                    <div class="exhibitor-generator__right-wrapper">
                        <div class="exhibitor-generator__right-title">
                            <h3>GR3 ' . PWECommonFunctions::languageChecker('WYGENERUJ</br>IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!', 'GENERATE</br>A VIP INVITATION</br>FOR YOUR GUESTS!') . '</h3>';
                            if (!empty(PWEExhibitorVisitorGenerator::$exhibitor_logo_url)  && !$pweGeneratorWebsite) {
                                $output .= '
                                <img id="exhibitor_logo_img" style="max-height: 120px;" src="' . PWEExhibitorVisitorGenerator::$exhibitor_logo_url . '">
                                <h3>' . PWEExhibitorVisitorGenerator::$exhibitor_name . '</h3>';
                            };
                        $output .= '
                        </div>
                        <div class="exhibitor-generator__right-icons">
                            <h5>' . PWECommonFunctions::languageChecker('Identyfikator VIP uprawnia do:', 'The VIP invitation entitles you to:') . '</h5>
                            <div class="exhibitor-generator__right-icons-wrapper">
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico3.png" alt="icon3">
                                    <p>' . PWECommonFunctions::languageChecker('Fast track', 'Fast track') . '</p>
                                </div>
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico4.png" alt="icon4">
                                    <p>' . PWECommonFunctions::languageChecker('Opieki concierge`a', 'Concierge care') . '</p>
                                </div>
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico1.png" alt="icon1">
                                    <p>' . PWECommonFunctions::languageChecker('VIP ROOM', 'VIP ROOM ') . '</p>
                                </div>
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico2.png" alt="icon2">
                                    <p>' . PWECommonFunctions::languageChecker('Udział w konferencjach', 'Participation in conferences') . '</p>
                                </div>';

                                if($pweGeneratorWebsite){
                                    $output .= '
                                    <div class="exhibitor-generator__right-icon">
                                        <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico6.png" alt="icon6">
                                        <p>' . PWECommonFunctions::languageChecker('Zaproszenie na Wieczór Branżowy', 'Invitation to the Industry Evening') . '</p>
                                    </div>';
                                }
                            $output .='

                            </div>
                        </div>
                        <div class="exhibitor-generator__right-form">
                            [gravityform id="'. $generator_form_id .'" title="false" description="false" ajax="false"]
                        </div>';

                        // Add a mass invite send button if not on a personal exhibitor page
                        if((get_locale() == "pl-PL" && !isset($company_array['exhibitor_name'])  && PWEExhibitorVisitorGenerator::fairStartDateCheck()) || current_user_can('administrator')){
                            $output .= '<button class="tabela-masowa btn-gold">' . PWECommonFunctions::languageChecker('Wysyłka zbiorcza', 'Collective send') . '</button>';
                        }

                        // Add optional content to the page if available
                        if (!empty($generator_html_text_content)) {
                            $output .= '<div class="exhibitor-generator__right-text">' . $generator_html_text_content . '</div>';
                        }

                    $output .= '
                    </div>
                </div>
            </div>
        </div>
        <script>
           jQuery(document).ready(function($){
                let exhibitor_name = "' . PWEExhibitorVisitorGenerator::$exhibitor_name . '";
                let exhibitor_desc = `' . PWEExhibitorVisitorGenerator::$exhibitor_desc . '`;
                let exhibitor_stand = "' . PWEExhibitorVisitorGenerator::$exhibitor_stand . '";

                $(".exhibitor_logo input").val("' . PWEExhibitorVisitorGenerator::$exhibitor_logo_url . '");
                $(".exhibitors_name input").val(exhibitor_name);
                $(".exhibitor_desc input").val(exhibitor_desc);
                $(".exhibitor_stand input").val(exhibitor_stand);

                $(`input[placeholder="FIRMA ZAPRASZAJĄCA"]`).val(exhibitor_name);

                $(`input[placeholder="FIRMA ZAPRASZAJĄCA"]`).on("input", function(){
                    if(!$(".badge_name").find("input").is(":checked")){
                        $(".exhibitors_name input").val($(this).val());
                    }
                    exhibitor_name = $(this).val();
                });

                $(".badge_name").on("change", function(){
                    if($(this).find("input").is(":checked")){
                        $(".exhibitors_name input").val("");
                    } else {
                        $(".exhibitors_name input").val(exhibitor_name);
                    }
                });
           });
        </script>
        ';
        if($pweGeneratorWebsite){
            $output .= '
            <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Funkcja do pobierania parametru z URL
                function getURLParameter(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
                }

                // Pobierz wartość parametru "p"
                const parametr = getURLParameter("p");

                // Jeśli parametr istnieje, znajdź input w elemencie o klasie "parametr" i wpisz wartość
                if (parametr) {
                const inputElement = document.querySelector(".parametr input");
                if (inputElement) {
                    inputElement.value = parametr;
                }
                }
            });
            </script>
            <style>
                .exhibitor-generator-tech-support {
                    display:none !important;
                }
            </style>';
        }

        return $output;
    }